<?php

class DBLayer
{
	public $con = null;
	public $db;
	public $host;
	public $server;
	public $port;
	public $user;
	public $password;

	public $result;
	public $page_size=25;
	public $contador;
	
	public $nomes_tabelas;
	public $metadados;
	public $tipodados;
	
	public $sqlobjsel;
	public $sqlobjfrom;
	public $sqlobj;
	public $sqltags;
		
	function __construct()
	{
	// pegando dados de conexao ao banco
		$this->contador = 0;
		$this->server = _DBSERVERTYPE;
		$this->db = _DBNOME;
		$this->host = _DBHOST;
		$this->port = _DBPORT;
		$this->user = _DBUSER;
		$this->password = _DBPWD;

	// criando alias para as tabelas
		$this->nomes_tabelas = array("classe"=>"t1",
		"classexfilhos"=>"t2",
		"classexobjeto"=>"t3",
		"comentarios"=>"t4",
		"index_badwords"=>"t5",
		"infoperfil"=>"t6",
		"logobjeto"=>"t7",
		"logrobo"=>"t8",
		"logworkflow"=>"t9",
		"objeto"=>"t10", 
		"parentesco"=>"t11",
		"pele"=>"t12", 
		"pendencia"=>"t13", 
		"perfil"=>"t14",
		"pilha"=>"t15",
		"propriedade"=>"t16",
		"status"=>"t17", 
		"tag"=>"t18",
		"tagxobjeto"=>"t19",  
		"tbl_blob"=>"t20", 
		"tbl_boolean"=>"t21", 
		"tbl_date"=>"t22", 
		"tbl_float"=>"t23", 
		"tbl_integer"=>"t24",
		"tbl_objref"=>"t25", 
		"tbl_string"=>"t26", 
		"tbl_text"=>"t27", 
		"tempcontrole"=>"t28", 
		"tipodado"=>"t29", 
		"unlock_table"=>"t30", 
		"usuario"=>"t31", 
		"usuarioxobjetoxperfil"=>"t32");
		
	// definindo campos que sao metadados do objeto
		$this->metadados = array ('cod_objeto',
		'cod_pai',
		'cod_usuario',
		'cod_classe',
		'classe',
		'temfilhos',
		'prefixoclasse',
		'cod_pele',
		'pele',
		'prefixopele',
		'cod_status',
		'status',
		'titulo',
		'descricao',
		'data_publicacao',
		'data_validade',
		'script_exibir',
		'apagado',
		'objetosistema',
		'url',
		'peso',
		'tags');
			
	// definindo tipos de dados para os bancos
		switch ($this->server){
	// PostgreSQL
		case "postgres":
			$this->tipodados = array("inteiro"=>"int",
			"inteirogde"=>"bigint",
			"inteiropqn"=>"smallint",
			"float"=>"float",
			"texto"=>"varchar(255)", 
			"coluna"=>"column");
			break;
	// MySQL
		case "mysql":
			$this->tipodados = array("inteiro"=>"int",
			"inteirogde"=>"bigint(14)",
			"inteiropqn"=>"tinyint",
			"float"=>"float",
			"texto"=>"varchar(255)", 
			"coluna"=>"");
			break;
	// MICROSOFT SQL SERVER
		case "mssql":
			$this->tipodados = array("inteiro"=>"[int]",
			"inteirogde"=>"[numeric](18, 0)",
			"inteiropqn"=>"[tinyint]",
			"float"=>"[numeric](18, 5)",
			"texto"=>"[varchar](255)", 
			"coluna"=>"");
			break;
		}
		
	// definindo sql geral de consulta
		$this->sqlobjsel = " ".$this->nomes_tabelas["objeto"].".cod_objeto,
		".$this->nomes_tabelas["objeto"].".cod_pai,
		".$this->nomes_tabelas["objeto"].".cod_classe,
		".$this->nomes_tabelas["classe"].".nome as classe,
		".$this->nomes_tabelas["classe"].".temfilhos,
		".$this->nomes_tabelas["classe"].".prefixo as prefixoclasse,
		".$this->nomes_tabelas["objeto"].".cod_usuario,
		".$this->nomes_tabelas["objeto"].".cod_pele, 
		".$this->nomes_tabelas["pele"].".nome as pele, 
		".$this->nomes_tabelas["pele"].".prefixo as prefixopele,
		".$this->nomes_tabelas["objeto"].".cod_status,
		".$this->nomes_tabelas["status"].".nome as status,
		".$this->nomes_tabelas["objeto"].".titulo,
		".$this->nomes_tabelas["objeto"].".descricao,
		".$this->nomes_tabelas["objeto"].".data_publicacao,
		".$this->nomes_tabelas["objeto"].".data_validade,
		".$this->nomes_tabelas["objeto"].".script_exibir,
		".$this->nomes_tabelas["objeto"].".apagado,
		".$this->nomes_tabelas["objeto"].".objetosistema,
		".$this->nomes_tabelas["objeto"].".peso ";
	
	// definindo clausula from do sql geral de consulta
		$this->sqlobjfrom = " from objeto ".$this->nomes_tabelas["objeto"]." 
		left join classe ".$this->nomes_tabelas["classe"]." on ".$this->nomes_tabelas["classe"].".cod_classe = ".$this->nomes_tabelas["objeto"].".cod_classe 
		left join pele ".$this->nomes_tabelas["pele"]." on ".$this->nomes_tabelas["pele"].".cod_pele = ".$this->nomes_tabelas["objeto"].".cod_pele 
		left join status ".$this->nomes_tabelas["status"]." on ".$this->nomes_tabelas["status"].".cod_status = ".$this->nomes_tabelas["objeto"].".cod_status ";
	
	// criando sql geral de consulta de objetos
		$this->sqlobj = "select ".$this->sqlobjsel." ".$this->sqlobjfrom;
		
		try {
				$this->con = ADONewConnection($this->server);
//				$this->con->debug = true;
				switch ($this->server)
				{
					case "postgres":
						$this->con->Connect("host=".$this->host." port=".$this->port." user=".$this->user." password=".$this->password." dbname=".$this->db) or die("Erro ao tentar conectar banco de dados");
						$this->con->Execute("SET CLIENT_ENCODING TO 'LATIN1'");
						break;

					case "mysql":
						$this->con->Connect($this->host, $this->user, $this->password, $this->db) or die("Erro ao tentar conectar banco de dados");
						break;
					
					case "mssql":
						$this->con->Connect($this->host, $this->user, $this->password, $this->db) or die("Erro ao tentar conectar banco de dados");
						break;
							
				}
				$this->con->SetFetchMode(ADODB_FETCH_ASSOC);
//				ini_get_all();
			} catch (exception $e) {
				echo "Erro ao conectar banco de dados";
// 				echo "<pre>";
// 				var_dump($e);
// 				adodb_backtrace($e->gettrace());
// 				echo "</pre>";
				exit();
			} 
	}
	
	function __destruct()
	{
		$this->Close();
	}
	
	function GetTempTable()
	{
		$tablename = "temp_".mt_rand(1,300).date("U");
		
		$sql = "CREATE TABLE ".$tablename." (
			cod_objeto ".$this->tipodados["inteiro"]." NOT NULL ,
			cod_pai ".$this->tipodados["inteiro"]." NULL ,
			cod_classe ".$this->tipodados["inteiro"]." NULL ,
			classe ".$this->tipodados["texto"]." NULL,
			temfilhos ".$this->tipodados["inteiro"]." NULL,
			prefixoclasse ".$this->tipodados["texto"]." NULL,
			cod_usuario ".$this->tipodados["inteiro"]." NULL ,
			cod_pele ".$this->tipodados["inteiro"]." NULL ,
			pele ".$this->tipodados["texto"]." NULL,
			prefixopele ".$this->tipodados["texto"]." NULL,
			cod_status ".$this->tipodados["inteiro"]." NULL ,
			status ".$this->tipodados["texto"]." NULL,
			titulo ".$this->tipodados["texto"]." NULL ,
			descricao ".$this->tipodados["texto"]." NULL ,
			data_publicacao ".$this->tipodados["inteirogde"]." NULL ,
			data_validade ".$this->tipodados["inteirogde"]." NULL ,
			script_exibir ".$this->tipodados["texto"]." NULL ,
			apagado ".$this->tipodados["inteiropqn"]." NULL ,
			objetosistema ".$this->tipodados["inteiropqn"]." NULL ,
			peso ".$this->tipodados["inteiro"]." NULL)";
		$this->ExecSQL($sql);		
		
		return $tablename;
	}
		
	function ExecSQL($sql, $start=-1, $limit=-1)
	{
		$this->contador++;
		$this->LogSQL[]=$sql;

		if ($limit!=-1)
			if ($start==-1)
				$start=0;
		
		if ($limit!=-1 && $start!=-1)
		{
			$this->result = $this->con->SelectLimit($sql, $limit, $start);
		}
		else 
		{
			$this->result = $this->con->Execute($sql);
		}

		return $this->result;
	}
		
	function FetchAssoc($rs='')
	{
		$ret = false;
		if ($rs==null || $rs==""){
			$rs = $this->result;
		}
		if ($rs->_numOfRows>0){
			$ret = $rs->GetRows();
		}
		return $ret;
	}
		
	function TimeStamp()
	{
		return date("YmdHis");
	}
	
	function DropTempTable($tbl)
	{
		$sql = 'drop table '.$tbl;
		$this->ExecSQL($sql);	
	}
	
	function AddFieldToTempTable($tbl, $field)
	{
		
//		var_dump($field);
		
		if (strpos($field['field'],'.')!==false)
		{
			$field['field']=substr($field['field'],0,strpos($field['field'],'.'));
		}
		
		switch ($field['type'])
		{
			case 'data' || 'Data':
				$txt = $field['field'].' '.$this->tipodados["inteirogde"].' NULL';
				break;
			case 'n�mero preciso' || 'N�mero Preciso':
				$txt = $field['field'].' '.$this->tipodados["float"].' NULL';
				break;
			case 'n�mero' || 'N�mero':
				$txt = $field['field'].' '.$this->tipodados["inteiro"].' NULL';
				break;
			case 'ref_objeto' || 'Ref. Objeto':
				break;
			case 'string' || 'String':
				$txt = $field['field'].' '.$this->tipodados["texto"].' NULL';
				break;
			case 'boolean' || 'Booleano':
				$txt = $field['field'].' '.$this->tipodados["inteiropqn"].' NULL';
				break;
							
		}
		$sql = "alter table ".$tbl." add ".$this->tipodados["coluna"]." ".$txt;
		$this->Query($sql);
	}
		
	function SpecialChars($array)
	{
		foreach ($array as $key=>$value)
		{
			$result[$key]=$this->Slashes($value,"\27");
		}
		return $result;
	}
	
	function Slashes($str)
	{
		$str = stripslashes($str);
		if ($this->server == "mysql") return addslashes($str);
		return str_replace("'","''",$str);
	}

	function Month($field)
	{
		return "(floor($field/100000000))";
	}

	function Day($field)
	{
		return "(floor($field/1000000))";
	}

	function Hour($field)
	{
		return "(floor($field/10000))";
	}

	function CreateDateTest($field,$condition,$value)
	{
		$zero_count=14-strlen($value);
		return "floor(".$field."/1".str_repeat("0",$zero_count).")".$condition.$value;
	}

	function Close()
	{
		$this->con->CacheFlush();
		$this->con->Close();
	}

	function Insert($table, $fields)
	{
		foreach ($fields as $value)
		{
			if (is_int($value)) $values[]=$value;
			else $values[]="'".$this->EscapeString($value)."'";		
		}

		$sql = sprintf("INSERT INTO %s (%s) VALUES(%s)",$table, implode(',',array_keys($fields)),implode(',',$values));
		
		if ($this->Query($sql))
		{
			return $this->InsertID($table);
		}
		else 
			return false;
	}
	
	function InsertID($table)
	{
		$table2 = $table;
		if (!($table == "index_word")){
			$arr_temp = explode("_", $table);
			if (sizeof($arr_temp)>=2) $table = $arr_temp[(sizeof($arr_temp)-1)];
		} 		
		$sql = "select max(cod_".$table.") as cod from ".$table2;
		$this->con->SetFetchMode(ADODB_FETCH_ASSOC);
		$this->result=$this->con->Execute($sql);
		return $this->result->fields["cod"];
	}
	
	function EscapeString($value)
	{
		return $this->Slashes($value);
	}
	
	function Query($sql)
	{
		$res = $this->con->Execute($sql);
		return $res;
	}
	
	function CreateTest($field,$ar_values)
	{
		$sql = '';
		foreach ($ar_values as $value)
		{
			if ($sql !='')
				$sql .= ' or ';
			if (is_numeric($value))
				$sql .= "$field=$value";
			else
				$sql .="LOWER($field)='$value'";
		}
		if ($sql!='')
			$sql = '('.$sql.')';
		else
			return " 1=1 ";
		return $sql;
	}
} 



