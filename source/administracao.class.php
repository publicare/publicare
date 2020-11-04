<?php
/**
* Publicare - O CMS Público Brasileiro
* @description Classe Administração, responsável por administrar os objetos (criar, editar objetos e classes)
* @author Diogo Corazolla <diogocorazolla@gmail.com>, Thiago Borges <thiago.m2r@gmail.com>, Manuel Poppe <manuelpoppe@gmail.com>
* @copyright GPL © 2007
* @package publicare
*
* MCTI - Ministério da Ciência, Tecnologia e Inovação - www.mcti.gov.br
* ANTT - Agência Nacional de Transportes Terrestres - www.antt.gov.br
* EPL - Empresa de Planejamento e Logística - www.epl.gov.br
* LogicBSB - LogicBSB Sistemas Inteligentes - www.logicbsb.com.br
*
* Este arquivo é parte do programa Publicare
* Publicare é um software livre; você pode redistribuí-lo e/ou modificá-lo dentro dos termos da Licença Pública Geral GNU 
* como publicada pela Fundação do Software Livre (FSF); na versão 3 da Licença, ou (na sua opinião) qualquer versão.
* Este programa é distribuído na esperança de que possa ser  útil, mas SEM NENHUMA GARANTIA; sem uma garantia implícita 
* de ADEQUAÇÃO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a Licença Pública Geral GNU para maiores detalhes.
* Você deve ter recebido uma cópia da Licença Pública Geral GNU junto com este programa, se não, veja <http://www.gnu.org/licenses/>.
*/

/**
 * Classe que contém métodos para manipulação de objetos
 */
class Administracao
{
    public $classesPrefixos;
    public $classesNomes;
    public $classesLocalizarPorNome;
    public $classesIndexaveis;
    public $_index;

    /**
     * Método construtor da classe Administracao.class.php
     * @param object $_page - Referência de objeto da classe Pagina
     */
    function __construct(&$_page)
    {
        $this->metadados = $_page->_db->metadados;
    }

    /**
     * Busca lista de classes no banco de dados e popula propriedades de classes
     * @param object $_page - Referência de objeto da classe Pagina
     */
    function CarregaClasses(&$_page)
    {
        $sql = "select cod_classe, 
        prefixo, 
        nome, 
        indexar 
        from classe 
        order by nome";
        
        $res=$_page->_db->ExecSQL($sql);
        $row=$res->GetRows();

        for ($i=0; $i<sizeof($row); $i++)
        {
            $this->classesPrefixos[$row[$i]['prefixo']]=$row[$i]['cod_classe'];
            $this->classesNomes[$row[$i]['nome']]=$row[$i]['cod_classe'];
            $this->classesLocalizarPorNome[strtolower($row[$i]['nome'])]=$row[$i]['cod_classe'];

            if ($row[$i]['indexar'])
                    $this->classesIndexaveis[]=$row[$i]['cod_classe'];
        }
    }

    /**
     * Retorna o código de uma classe com base em seu prefixo
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $prefixo - Prefixo da classe
     * @return int - Código da classe
     */
    function CodigoDaClasse(&$_page, $prefixo)
    {
        $this->CarregaClasses($_page);
        return $this->classesPrefixos[$prefixo];
    }

    /**
     * Busca lista de peles no banco de dados. Caso esteja logado com usuário
     * admin ve todas as peles, caso contrario somente peles publicas
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $rcvPele - Código da pele
     * @return array
     */
    function PegaListaDePeles(&$_page, $rcvPele=NULL)
    {
        $result=array();
        $sqladd = "";
        
        if ($rcvPele && $rcvPele!=NULL) $sqladd = " AND cod_pele=".$rcvPele;
        
        $sql = "SELECT cod_pele AS codigo, nome AS texto FROM pele WHERE 1=1";
        if ($_SESSION['usuario']['perfil'] != _PERFIL_ADMINISTRADOR) {
            $sql .= " AND publica='1'";
        }
        $sql .= $sqladd;
        $sql .= " ORDER BY texto";
        
        $res = $_page->_db->ExecSQL($sql);
        return $res->GetRows();
    }

    /**
     * Busca peles no bancod e dados e manda array com as peles 
     * para metodo que monta os options
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_pele
     * @param bool $branco
     * @param int $peleAtual
     * @return string com <options>
     */
    function DropDownListaDePeles(&$_page, $cod_pele, $branco=true, $peleAtual=NULL)
    {
        $lista = $this->PegaListadePeles($_page, $peleAtual);
        if ($lista)
            return $this->CriaDropDown($lista, $cod_pele, $branco);
    }

    /**
     * Busca lista de usuários dependentes, caso usuario logado 
     * seja administrador traz todos usuários
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_usuario - código do usuário chefe
     * @return array
     */
    function PegaListadeDependentes(&$_page, $cod_usuario)
    {
        $result=array();
        if($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR)
        {
            $sql = "select usuario.cod_usuario as codigo, 
            usuario.nome as texto 
            from usuario 
            where ((valido = 1) or cod_usuario = ".$cod_usuario.") 
            order by texto";
        }
        else
        {
            if ($_SESSION['usuario']['cod_usuario'] == $cod_usuario)
            {
                $sql = "select usuario.cod_usuario as codigo, 
                usuario.nome as texto 
                from usuario 
                where ((chefia = ".$cod_usuario.") 
                or (cod_usuario = ".$cod_usuario." and valido = ".$cod_usuario.") 
                or (cod_usuario = ".$cod_usuario.")) 
                order by texto";
            }
            else 
            {
                $sql = false;
            }
        }
        if ($sql)
        {
            $rs = $_page->_db->ExecSQL($sql);
            $result = $rs->GetRows();
        }

        return $result;
    }

    /**
     * Chama metodo PegaListadeDependentes e com retorno deste método
     * e passa o array de resposta para o método CriaDropDown
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_usuario
     * @return string com lista de <options>
     */
    function DropDownListaDependentes(&$_page, $cod_usuario)
    {
        $lista=$this->PegaListadeDependentes($_page, $cod_usuario);
        return $this->CriaDropDown($lista, $cod_usuario, false, 30);
    }

		function PegaListadeArquivosNoDiretorio() {} // Producao prevista para 30/10/2006

		function DropDownListaViews() {}		// Producao prevista para 30/10/2006

    /**
     * Recebe array e monta string com <options> para o select do dropdown
     * @param type $lista
     * @param type $selecionado
     * @param type $branco
     * @param type $nummaxletras
     * @return string
     */
    function CriaDropDown($lista, $selecionado, $branco=true, $nummaxletras=0)
    {
        $result = "";
        if ($branco)
        {
            $result = '<option value="0" selected>&nbsp;Selecione&nbsp;</option>';
        }

        foreach($lista as $item)
        {
            $result.='<option value="'.$item['codigo'].'"';
            if (($selecionado==$item['codigo']) || ($selecionado==$item['texto']))
            {
                $result .=' selected ';
            }
            $result .= '>';
            if ($nummaxletras)
            {
                $result .= substr($item['texto'],0,$nummaxletras);
            }
            else 
            {
                $result .= $item['texto'];
            }
            $result .= '</option>';
        }

        return $result;
    }

    /**
     * Busca propriedades da classe no banco de dados e retorna array com informações
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe
     * @return array
     */
    function PegaPropriedadesDaClasse(&$_page, $cod_classe)
    {
        $result = "";
        $sql = "select ".$_page->_db->nomes_tabelas["propriedade"].".cod_tipodado, 
                cod_propriedade,
                ".$_page->_db->nomes_tabelas["tipodado"].".nome as tipodado, 
                ".$_page->_db->nomes_tabelas["propriedade"].".campo_ref,
                ".$_page->_db->nomes_tabelas["propriedade"].".nome,
                ".$_page->_db->nomes_tabelas["tipodado"].".tabela,
                ".$_page->_db->nomes_tabelas["propriedade"].".cod_referencia_classe, 
                ".$_page->_db->nomes_tabelas["propriedade"].".posicao, 
                ".$_page->_db->nomes_tabelas["propriedade"].".descricao, 
                ".$_page->_db->nomes_tabelas["propriedade"].".rotulo, 
                ".$_page->_db->nomes_tabelas["propriedade"].".obrigatorio, 
                ".$_page->_db->nomes_tabelas["propriedade"].".seguranca, 
                ".$_page->_db->nomes_tabelas["propriedade"].".valorpadrao, 
                ".$_page->_db->nomes_tabelas["propriedade"].".rot1booleano, 
                ".$_page->_db->nomes_tabelas["propriedade"].".rot2booleano 
                from propriedade ".$_page->_db->nomes_tabelas["propriedade"]." 
                inner join tipodado ".$_page->_db->nomes_tabelas["tipodado"]." on ".$_page->_db->nomes_tabelas["propriedade"].".cod_tipodado = ".$_page->_db->nomes_tabelas["tipodado"].".cod_tipodado
                where ".$_page->_db->nomes_tabelas["propriedade"].".cod_classe=$cod_classe 
                order by ".$_page->_db->nomes_tabelas["propriedade"].".posicao";
        $rs = $_page->_db->ExecSQL($sql);
        
        return $rs->GetRows(); 
    }

    /**
     * Busca lista de objetos, com codigo do objeto e propriedade informada, 
     * de determinada classe no banco de dados e retorna array com informações.
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Código da classe
     * @param string $propriedade - Propriedade que deseja valor
     * @return array
     */
    function PegaListaDeObjetos(&$_page, $cod_classe, $propriedade)
    {
        $result=array();
        if (in_array($propriedade, $_page->_db->metadados))
        {
            $sql = "select cod_objeto as codigo,
            ".$propriedade." as texto 
            from objeto 
            where cod_classe=".$cod_classe." 
            and apagado <> 1 
            order by ".$propriedade;
        }
        else
        {
            $info = $_page->_adminobjeto->CriaSQLPropriedade($_page, cod_classe, $propriedade, ' asc');
            $sql = "select objeto.cod_objeto as codigo,
            ".$info['field']." as texto 
            from objeto ".$info['join']." 
            where ".$info['where']." 
            order by ".$info['sort'];
        }
        $res=$_page->_db->ExecSQL($sql);
        
        return $res->GetRows();
    }

    /**
     * Busca objetos no banco de dados e envia retorno para função de 
     * criação de dropdown, retornando string com <options> para select
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Código da classe
     * @param string $propriedade - Nome da propriedade que deseja receber
     * @param int $selecionado - Objeto que já deve vir selecionado
     * @param int $nummaxletras - Maximo de letras para colocar no <option>
     * @return string
     */
    function DropDownListaDeObjetos(&$_page, $cod_classe, $propriedade, $selecionado=-1, $nummaxletras=0)
    {
        $lista=$this->PegaListadeObjetos($_page, $cod_classe, $propriedade);
        return $this->CriaDropDown($lista, $selecionado, true, $nummaxletras);
    }

    /**
     * Troca pele de filhos recursivamente de determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto pai
     * @param int $cod_pele - Código da pele
     */
    function TrocaPeleFilhos(&$_page, $cod_objeto, $cod_pele)
    {
        $filhos = $_page->_adminobjeto->ListaCodFilhos($_page, $cod_objeto);
        if (count($filhos)>0)
        {
            $sql_pele_filhos="update objeto 
            set cod_pele=".($cod_pele+0)." 
            where cod_objeto in (".join(',',$filhos).")";
            $_page->_db->ExecSQL($sql_pele_filhos);
            foreach ($filhos as $filho)
            {
                $this->TrocaPeleFilhos($_page, $filho, $cod_pele);
            }
        }
    }

    /**
     * Altera a lista de objetos que podem conter objetos de determinada classe
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe
     * @param array $lista - Array com códigos dos objetos
     */
    function AlterarListaDeObjetosQueContemClasse(&$_page, $cod_classe, $lista)
    {
        $sql = 'delete from classexobjeto 
        where cod_classe='.$cod_classe;
        $_page->_db->ExecSQL($sql);	

        if (is_array($lista))
        {
            foreach ($lista as $item)
            {
                $_page->_db->ExecSQL("insert into classexobjeto(cod_classe,cod_objeto) values(".$cod_classe.",".$item.")");
            }
        }
    }

    /**
     * Altera objeto no banco de dados
     * @param object $_page - Referência de objeto da classe Pagina
     * @param array $dados - Dados do objeto
     * @param bool $log - Indica se deve gerar log ou não
     * @return int - Código do objeto alterado
     */
    function AlterarObjeto(&$_page, $dados, $log=true)
    {	
        $fieldlist = array();
        $valorlist = array();
        $tagslist = array();
        $proplist = array();
        foreach ($dados as $key=>$valor)
        {
            if ($key!="submit")
            {
                if ($key=="tags")
                {
                    $tagslist = split(",",$valor);
                }
                if (strpos($key,":"))
                {
                    $proplist[$key]=$valor;
                }
            }
        }

        $sql_pele = "select cod_pele 
        from objeto 
        where cod_objeto=".$dados['cod_objeto'];
        $row_pele = $_page->_db->ExecSQL($sql_pele);
        $row_pele = $row_pele->GetRows();
        $row_pele = $row_pele[0];

        if ((is_array($row_pele) && $row_pele['cod_pele']!=$dados['cod_pele']) || (is_null(row_pele) && !is_null($dados['cod_pele'])))
        {
            $this->TrocaPeleFilhos($_page, $dados['cod_objeto'], $dados['cod_pele']);
        }

        // Objeto root deverá ser sempre publicado
        if ($dados['cod_objeto']==1 || $dados['cod_objeto']==_ROOT)
        {
            $dados['cod_status'] = _STATUS_PUBLICADO;
        }
			
        $dados['url_amigavel'] = $this->verificaExistenciaUrlAmigavel($_page, $dados['url_amigavel'], $dados['cod_objeto']);
			
        $sql = "update objeto 
        set cod_pai=".$dados['cod_pai'].",
        script_exibir='".$dados['script_exibir']."',
        cod_classe=".$dados['cod_classe'].",
        cod_usuario=".$dados['cod_usuario'].",";
        if (!is_null($dados['cod_pele'])) $sql .= "cod_pele=".($dados['cod_pele']).",";
        $sql .= "cod_status=".$dados['cod_status'].",
        titulo='".$_page->_db->Slashes($dados['titulo'])."',
        descricao='".$_page->_db->Slashes($dados['descricao'])."',
        data_publicacao='".ConverteData($dados['data_publicacao'],27)."',
        data_validade ='".ConverteData($dados['data_validade'],27)."',
        peso='".$dados['peso']."',
        url_amigavel='".$dados['url_amigavel']."'
        where cod_objeto=".$dados['cod_objeto'];
        $_page->_db->ExecSQL($sql);

        $this->ApagarPropriedades($_page, $dados['cod_objeto'],false);
        $this->GravarPropriedades($_page, $dados['cod_objeto'], $dados['cod_classe'], $proplist);
        $this->GravarTags($_page, $dados['cod_objeto'], $tagslist);
			
        if ($log)
        {
            $_page->_log->IncluirLogObjeto($_page, $dados['cod_objeto'], _OPERACAO_OBJETO_EDITAR);
        }

        return $dados['cod_objeto'];
    }

    /**
     * Verifica se já existe outro objeto utilizando a url amigável
     * se tiver adiciona número no final e verifica novamente
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $url - Url amigável para verificar
     * @param int $cod_objeto - Código do objeto
     * @param int $nivel - número a ser adicionado no final
     * @param int $tamanho - tamanho máximo da url amigável
     * @return string - url amigável a ser gravada
     */
    function verificaExistenciaUrlAmigavel(&$_page, $url, $cod_objeto=0, $nivel=0, $tamanho=0)
    {
        $url = limpaString($url);
        $url = strtolower($url);
        if (strlen($url)>249) $url = substr($url_amigavel, 0, 245);
        $sql = "select cod_objeto from objeto where url_amigavel='".$url."'";
        if ($cod_objeto>0) $sql .= " and not cod_objeto = ".$cod_objeto;
        $rs = $_page->_db->ExecSQL($sql);
        if ($tamanho==0) $tamanho = strlen($url);
        if ($rs->_numOfRows > 0)
        {
            $nivel++;
            $url = substr($url, 0, $tamanho).$nivel;
            $url = $this->verificaExistenciaUrlAmigavel($_page, $url, $cod_objeto, $nivel, $tamanho);
        }
        return $url;
    }

    /**
     * Apaga propriedades de determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a remover as propriedades
     * @param bool $tudo - Indica se deve apagar blobs também
     */
    function ApagarPropriedades(&$_page, $cod_objeto, $tudo=true)
    {
        $sql = "select tabela 
        from objeto 
        inner join propriedade on objeto.cod_classe=propriedade.cod_classe
        inner join tipodado on propriedade.cod_tipodado = tipodado.cod_tipodado
        where cod_objeto = ".$cod_objeto ;

        if (!$tudo)
        {
            $sql .= " and tabela<>'tbl_blob'";   
        }

        $res = $_page->_db->ExecSQL($sql);
        $row = $res->GetRows();

        for ($i=0; $i<sizeof($row); $i++)
        {
            if ($row[$i]['tabela']=='tbl_blob')
            {
                if (defined ("_BLOBDIR"))
                {
                    $sql = "select cod_blob, arquivo 
                    from tbl_blob 
                    where cod_objeto=$cod_objeto";
                    $res_blob = $_page->_db->ExecSQL($sql);
                    $row_blob = $res_blob->GetRows();

                    for ($j=0; $j<sizeof($row_blob); $j++)
                    {
                        $file_ext=PegaExtensaoArquivo($row_blob[$j]['arquivo']);
                        if (file_exists(_BLOBDIR."/".identificaPasta($row_blob[$j]['cod_blob'])."/".$row_blob[$j]['cod_blob'].'.'.$file_ext))
                        {
                            $checkDelete = unlink(_BLOBDIR."/".identificaPasta($row_blob[$j]['cod_blob'])."/".$row_blob[$j]['cod_blob'].'.'.$file_ext);
                        }
                        if (defined ("_THUMBDIR"))
                        {
                            if (file_exists(_THUMBDIR.$row_blob[$j]['cod_blob'].'.'.$file_ext))
                            {
                                unlink(_THUMBDIR.$row_blob[$j]['cod_blob'].'.'.$file_ext);
                            }
                        }
                    }
                }
            }
            $sql = "delete from ".$row[$i]['tabela']." where cod_objeto = ".$cod_objeto;
            $_page->_db->ExecSQL($sql);
        }
    }

    /**
     * Grava propriedades do objeto
     * @global array $_FILES - Array com inputs file do PHP
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     * @param int $cod_classe - Codigo da classe
     * @param array $proplist - Lista de propriedades
     * @param array $array_files - Array com arquivos de upload
     */
    function GravarPropriedades(&$_page, $cod_objeto, $cod_classe, $proplist, $array_files='')
    {
        global $_FILES;

        if (!is_array($array_files))
        {
            $array_files= $_FILES;
            $source='post';
        }
        else
        {
            $source='string';
        }

        if (is_array($proplist))
        {
            foreach ($proplist as $key=>$valor)
            {
                $ar_fld = explode (":",$key);
                if (strpos($ar_fld[1],"^")===false)
                {
                    $info = $_page->_adminobjeto->PegaInfoSobrePropriedade($_page, $cod_classe, $ar_fld[1]);
                    if ($info['tabela']=='tbl_text')
                    {
                        if (!preg_match('%(\<p|\<BR)%is',$valor))
                        {
                            $valor=nl2br($valor);
                        }
                    }
                    if ($info['tabela']=='tbl_date')
                    {
                        $valor=ConverteData($valor,16);
                    }
                    if ($valor!="")
                    {
                        if ($valor == _VERSIONPROG)
                        {
                            $valor = NULL;
                        }
                        $valor=stripslashes($valor);
                        if ($info['tabela']!='tbl_blob')
                        {
                            $sql = "insert into ".$info['tabela']." (cod_propriedade,cod_objeto,valor) values (".
                            $info['cod_propriedade'].",".$cod_objeto.",".$info['delimitador'].$_page->_db->Slashes($valor).$info['delimitador'].")";
                            $_page->_db->ExecSQL($sql);
                        }
                        else
                        {
                            if (!$this->tamanho_temp_blob) $this->tamanho_temp_blob = 1;
                            $sql = "insert into ".$info['tabela']."(cod_propriedade,cod_objeto,arquivo,tamanho) values (".
                            $info['cod_propriedade'].",".$cod_objeto.",".$info['delimitador'].$_page->_db->Slashes($valor).$info['delimitador'].",".$this->tamanho_temp_blob.")";
                            $_page->_db->ExecSQL($sql);

                            if ($this->codigo_temp_blob)
                            {
                                $cod_temporario = $_page->_db->InsertID($info['tabela']);
                                if (!$resultado=is_dir(_BLOBDIR.identificaPasta($cod_temporario)."/")) 
                                {
                                    mkdir(_BLOBDIR.identificaPasta($cod_temporario), 0755); //cria a pasta
                                }
                                copy(_BLOBDIR.identificaPasta($this->codigo_temp_blob)."/".$this->codigo_temp_blob.".".$this->tipo_temp_blob, _BLOBDIR.identificaPasta($cod_temporario)."/".$cod_temporario.".".$this->tipo_temp_blob);

                                if (defined("_THUMBDIR"))
                                {									
                                    if ($this->tipo_temp_blob=="jpg") $im = @imagecreatefromjpeg(_BLOBDIR.identificaPasta($cod_temporario)."/".$cod_temporario.".".$this->tipo_temp_blob);
                                    if ($this->tipo_temp_blob=="png") $im = @imagecreatefrompng(_BLOBDIR.identificaPasta($cod_temporario)."/".$cod_temporario.".".$this->tipo_temp_blob);
                                    if (!$im){}
                                    else
                                    {
                                        $x=ImageSX($im);
                                        $y=ImageSY($im);
                                        $width=_THUMBWIDTH;
                                        $height=ceil(_THUMBWIDTH*$y/$x);
                                        if ($this->tipo_temp_blob =="jpg") $newim = ImageCreateTrueColor($width,$height);
                                        else $newim=ImageCreate($width,$height);
                                        ImageCopyResized($newim,$im,0,0,0,0,$width,$height,$x,$y);
                                        $im=$newim;
                                        switch ($this->tipo_temp_blob)
                                        {
                                            case 'jpg':
                                                ImageJpeg($im,_THUMBDIR.$cod_temporario.'.'.$this->tipo_temp_blob,100);
                                                break;
                                            case 'png':
                                                ImagePNG($im,_THUMBDIR.$cod_temporario.'.'.$this->tipo_temp_blob);
                                                break;
                                        }
                                    }
                                }
                            } 
                        }
                    }
                }
                else
                {
                    $ar_fld = explode("^",$ar_fld[1]);

                    $info = $_page->_adminobjeto->PegaInfoSobrePropriedade($_page, $cod_classe, $ar_fld[0]);

                    if ($info['tabela'] == "tbl_blob")
                    {
                        $sql = "Select * from tbl_blob where cod_propriedade=".$info["cod_propriedade"]." and cod_objeto=".$cod_objeto;
                        $rs = $_page->_db->ExecSQL($sql);

                        while ($row = $rs->FetchRow())
                        {
                            $file_ext = PegaExtensaoArquivo($row['arquivo']);
                            if (file_exists(_BLOBDIR."/".identificaPasta($row['cod_blob'])."/".$row['cod_blob'].'.'.$file_ext))
                            {
                                $checkDelete = unlink(_BLOBDIR."/".identificaPasta($row['cod_blob'])."/".$row['cod_blob'].'.'.$file_ext);
                            }

                            if (defined ("_THUMBDIR"))
                            {
                                if (file_exists(_THUMBDIR.$row['cod_blob'].'.'.$file_ext)) unlink(_THUMBDIR.$row['cod_blob'].'.'.$file_ext);
                            }
                        }
                    }

                    $sql = "delete from ".$info['tabela']." where cod_propriedade=".$info['cod_propriedade'].
                                    " and cod_objeto=$cod_objeto";
                    $_page->_db->ExecSQL($sql);
                }
            }
        }

        if (is_array($array_files))
        {
            foreach ($array_files as $key=>$valor)
            {
                if ($valor['size'])
                {
                    $ar_fld = explode (":",$key);
                    $info = $_page->_adminobjeto->PegaInfoSobrePropriedade($_page, $cod_classe, $ar_fld[1]);
                    if ($valor!="")
                    {
                        $sql = "delete from ".$info['tabela']." where cod_propriedade=".$info['cod_propriedade'].
                                        " and cod_objeto=$cod_objeto";
                        $_page->_db->ExecSQL($sql);
                        if ($source=='post') $data = fread(fopen($valor['tmp_name'], "rb"), filesize($valor['tmp_name']));
                        else $data = stripslashes($valor['data']);

                        if (!defined ("_BLOBDIR"))
                        {
                            $campo = gzcompress($data);
                            $sql = "insert into ".$info['tabela']."(cod_propriedade,cod_objeto,valor,arquivo,tamanho) values (".
                            $info['cod_propriedade'].",".$cod_objeto.",".$info['delimitador'].$_page->_db->BlobSlashes($data).$info['delimitador'].",'".$valor['name']."',".filesize($valor['tmp_nsme']).")";
                            $_page->_db->ExecSQL($sql);
                        }
                        else
                        {
                            $campos = array();
                            $campos['cod_propriedade'] = (int)$info['cod_propriedade'];
                            $campos['cod_objeto'] = (int)$cod_objeto;
                            $campos['arquivo'] = strtolower($valor['name']);
                            $campos['tamanho'] = filesize($valor['tmp_name']);
                            $name = $_page->_db->Insert($info['tabela'],$campos);
                            $filetype=PegaExtensaoArquivo($valor['name']);

                            $subpasta = identificaPasta($name);  //Pega o nome da subpasta
                            if (!$resultado=is_dir(_BLOBDIR."/".$subpasta."/"))
                            {
                                mkdir(_BLOBDIR."/".$subpasta, 0755); //cria a pasta
                            }

                            $fp=fopen(_BLOBDIR."/".$subpasta."/".$name.'.'.$filetype,"wb");
                            fwrite($fp,$data);
                            fclose($fp);
                            if (defined("_THUMBDIR"))
                            {
                                if (in_array($filetype,array('png','jpg')))
                                {
                                    $im = imagecreatefromstring($data);
                                    $x=ImageSX($im);
                                    $y=ImageSY($im);
                                    $width=_THUMBWIDTH;
                                    $height=ceil(_THUMBWIDTH*$y/$x);
                                    if ($filetype=='jpg') $newim = ImageCreateTrueColor($width,$height);
                                    else $newim=ImageCreate($width,$height);
                                    ImageCopyResized($newim,$im,0,0,0,0,$width,$height,$x,$y);
                                    $im=$newim;
                                    switch ($filetype)
                                    {
                                        case 'jpg':
                                            ImageJpeg($im,_THUMBDIR.$name.'.'.$filetype,100);
                                            break;
                                        case 'png':
                                            ImagePNG($im,_THUMBDIR.$name.'.'.$filetype);
                                            break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Cria objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param array $dados - Dados do objeto a ser criado
     * @param bool $log - Indica se deve gerar log
     * @param array $array_files - Lista de arquivos
     * @return int - Codigo do objeto criado
     */
    function CriarObjeto(&$_page, $dados, $log=true, $array_files='')
    {
        $fieldlist = array();
        $valuelist = array();
        $tagslist = array();
        $proplist = array();
        foreach ($dados as $key=>$value)
        {
            if ($key!="submit")
            {
                if ($key=="tags") $tagslist = split(",",$value);
                if (strpos($key,":")) $proplist[$key]=$value;
            }
        }
        if (strlen($dados['data_publicacao'])<9)
        {
            if (preg_match('|[\.-]|',$dados['data_publicacao']))
            {
                $dados['data_publicacao'].= ' 00:00:00';
            }
            else
            {
                $dados['data_publicacao'].= '000000';
            }
        }
        if (strlen($dados['data_validade'])<9)
        {
            if (preg_match('|[\.-]|',$dados['data_validade']))
            {
                $dados['data_validade'].= ' 00:00:00';
            }
            else
            {
                $dados['data_validade'].= '000000';
            }
        }
        $noname = date("ymd-his"); 
        if ($dados['titulo']=="") $dados['titulo']=$noname;

        $campos = array();
        $campos['script_exibir'] = $dados['script_exibir'];
        $campos['cod_pai'] = $dados['cod_pai'];
        $campos['cod_classe'] = $dados['cod_classe'];
        $campos['cod_usuario'] = $dados['cod_usuario'];
        if (!empty($dados['cod_pele'])) $campos['cod_pele'] = $dados['cod_pele'];
        $campos['cod_status'] = $dados['cod_status'];
        $campos['titulo'] = $_page->_db->Slashes($dados['titulo']);
        $campos['descricao'] = $_page->_db->Slashes($dados['descricao']);
        $campos['data_publicacao']= ConverteData($dados['data_publicacao'],27);
        $campos['data_validade']= ConverteData($dados['data_validade'],27);
        $campos['peso'] = $dados['peso']+0;

        if ($dados['url_amigavel']=="") $dados['url_amigavel']=limpaString($dados["titulo"]);
        $campos['url_amigavel'] = $this->verificaExistenciaUrlAmigavel($_page, $dados['url_amigavel']);

        $cod_objeto = $_page->_db->Insert('objeto', $campos);

        $this->GravarPropriedades($_page, $cod_objeto, $dados['cod_classe'], $proplist, $array_files);
        $this->CriaParentesco($_page, $cod_objeto, $dados['cod_pai']);
        $this->GravarTags($_page, $cod_objeto, $tagslist);

        if ($log) $_page->_log->IncluirLogObjeto($_page, $cod_objeto, _OPERACAO_OBJETO_CRIAR);

        return $cod_objeto;
    }

    /**
     * Grava tags do objeto no banco de dados
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     * @param array $tagslist - Lista de tags
     */
    function GravarTags(&$_page, $cod_objeto, $tagslist)
    {
        if (is_array($tagslist) && count($tagslist)>=1)
        {
            $this->ApagarTags($_page, $cod_objeto);

            foreach ($tagslist as $tag)
            {
                $tag = limpaString(trim($tag), "_");
                $sql = "select cod_tag from tag where nome_tag='".$tag."'";
                $rs = $_page->_db->ExecSQL($sql);
                if ($rs->_numOfRows == 0)
                {
                    $cod_tag = $_page->_db->Insert("tag", array("nome_tag"=>$tag));
                }
                else
                {
                    $row = $rs->FetchRow();
                    $cod_tag = $row["cod_tag"];
                }

                $sql = "insert into tagxobjeto (cod_tag, cod_objeto) values (".$cod_tag.",".$cod_objeto.")";
                $rs = $_page->_db->ExecSQL($sql);
            }
        }
    }

    /**
     * Remove tags do objeto e do banco caso não tenha nenhum 
     * outro objeto utilizando
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     */
    function ApagarTags(&$_page, $cod_objeto)
    {
        $sql = "delete from tagxobjeto where cod_objeto=".$cod_objeto;
        $rs = $_page->_db->ExecSQL($sql);

        $sql = "delete from tag where cod_tag not in (select cod_tag from tagxobjeto)";
        $rs = $_page->_db->ExecSQL($sql);
    }

    /**
     * Apaga lista de relação de parentesco de objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     */
    function ApagarParentesco(&$_page, $cod_objeto)
    {
        $_page->_db->ExecSQL("delete from parentesco where cod_objeto =".$cod_objeto);
    }

    /**
     * Cria relação de parentesco entre objetos
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     * @param int $cod_pai - Codigo do objeto pai
     */
    function CriaParentesco(&$_page, $cod_objeto, $cod_pai)
    {
        $sql = "insert into parentesco(cod_objeto,cod_pai,ordem) select $cod_objeto,cod_pai,ordem+1 from parentesco where cod_objeto=$cod_pai";
        $_page->_db->ExecSQL($sql);
        $sql = "insert into parentesco(cod_objeto,cod_pai,ordem) values ($cod_objeto,$cod_pai,1)";
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Verifica se classe é indexavel
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe
     * @return int - 0 ou 1
     */
    function ClasseIndexavel(&$_page, $cod_classe)
    {
        $this->CarregaClasses($_page);
        return (in_array($cod_classe, $this->classesIndexaveis));
    }

    /**
     * Apaga objeto, fisicamente ou logicamente
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a ser apagado
     * @param bool $definitivo - indica se deve apagar realmente, ou mandar para lixeira
     */
    function ApagarObjeto(&$_page, $cod_objeto, $definitivo=false)
    {
        if (!$definitivo)
        {
            $sql = "select parentesco.cod_objeto, cod_status 
            from parentesco inner join objeto on parentesco.cod_objeto=objeto.cod_objeto 
            where parentesco.cod_pai=$cod_objeto 
            or parentesco.cod_objeto=$cod_objeto";
            $res = $_page->_db->ExecSQL($sql);

            while ($row = $res->FetchRow())
            {
                $sql = "update objeto set apagado=1, data_exclusao='".date("Ymd")."' ";
                if ($row['cod_status'] == _STATUS_SUBMETIDO)
                {
                    $_page->_db->ExecSQL("delete from pendencia where cod_objeto=".$row["cod_objeto"]);
                    $sql .=", cod_status="._STATUS_PRIVADO;
                }

                $sql .= " where cod_objeto=".$row["cod_objeto"];
                $_page->_db->ExecSQL($sql);
            }
        }
        else
        {
            $sql = "delete from tagxobjeto where cod_objeto=".$cod_objeto;
            $rs = $_page->_db->ExecSQL($sql);
            $this->ApagarPropriedades($_page, $cod_objeto, true);

            $sql = "delete from objeto where cod_objeto=$cod_objeto";
            $_page->_db->ExecSQL($sql);

            $sql = "select cod_objeto from parentesco where cod_pai=$cod_objeto";
            $res = $_page->_db->ExecSQL($sql);
            $row = $res->GetRows();

            for ($m=0; $m<sizeof($row); $m++)
            {
                $this->ApagarPropriedades($_page, $row[$m]['cod_objeto'],true);

                $sql = "delete from objeto where cod_objeto=".$row[$m]['cod_objeto'];
                $_page->_db->ExecSQL($sql);
            }

            $this->ApagarParentesco($_page, $cod_objeto);
        }

        $_page->_log->IncluirLogObjeto($_page, $cod_objeto,_OPERACAO_OBJETO_REMOVER);
    }
    
    /**
     * Verifica se objeto é indexavel
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a verificar
     * @return int - 0 ou 1
     */
    function ObjetoIndexado(&$_page, $cod_objeto)
    {
        $sql = "select indexar from classe left join objeto on objeto.cod_classe=classe.cod_classe
                        where cod_objeto=$cod_objeto";
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->fields;
        return $row['indexar'];
    }

    /**
     * Verifica se usuário é dono do objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_usuario - Codigo do usuario
     * @param int $cod_objeto - Codigo do objeto
     * @return boolean
     */
    function UsuarioEDono(&$_page, $cod_usuario,$cod_objeto)
    {
        $sql = "select cod_objeto from objeto where cod_objeto=$cod_objeto and cod_usuario=$cod_usuario";
        $rs = $_page->_db->ExecSQL($sql);
        if ($rs->_numOfRows > 0) return true;
        else return false;
    }

    /**
     * Busca informações sobre usuário que é dono de determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     * @return array - Dados do usuário dono do objeto
     */
    function QuemEDono(&$_page, $cod_objeto)
    {
        $sql = "select usuario.cod_usuario as cod_usuario, usuario.nome as nome, "
                . "usuario.email as email, usuario.login as login, usuario.chefia as chefia, "
                . "usuario.valido as valido from objeto inner join usuario "
                . "on usuario.cod_usuario = objeto.cod_usuario where cod_objeto=".$cod_objeto;
        $rs = $_page->_db->ExecSQL($sql);
        return $rs->GetRows(); 
    }

    /**
     * Rejeita publicação do objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $mensagem - Mensagem de rejeição
     * @param int $cod_objeto - Codigo do objeto
     */
    function RejeitarObjeto(&$_page, $mensagem, $cod_objeto)
    {
        if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR)
                || (($_SESSION['usuario']['perfil']==_PERFIL_AUTOR) && $this->UsuarioEdono($_page, $_SESSION['usuario']['cod_usuario'], $cod_objeto)))
        {
            $this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_REJEITADO);
            $_page->_db->ExecSQL("delete from pendencia where cod_objeto=".$cod_objeto);
        }
    }

    /**
     * Publica objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $mensagem - mensagem de publicação
     * @param int $cod_objeto - Codigo do objeto
     */
    function PublicarObjeto(&$_page, $mensagem, $cod_objeto)
    {			
        if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR))
        {
            $this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_PUBLICADO);
            $_page->_db->ExecSQL("delete from pendencia where cod_objeto=".$cod_objeto);

            if (defined("_avisoPublicacao") && _avisoPublicacao==true)
            {
                $objetoPublicado = new Objeto($_page, $cod_objeto);
                $array_objeto = null;
                $array_objeto[] = array($objetoPublicado->metadados["cod_objeto"], $objetoPublicado->metadados["titulo"]);
                $caminhoObjeto = $_page->_adminobjeto->PegaIDPai($_page, $cod_objeto, 100, array(0));
                foreach ($caminhoObjeto as $codigo=>$titulo) 
                {
                    $array_objeto[] = array($codigo, $titulo);
                }

                $mensagemEmail = "<html><head><title>Objeto Publicado</title></head>
                <body>
                Objeto publicado no site: <b>"._PORTAL_NAME."</b><br>
                Data: ".date("d/m/Y H:i:s")."<br>
                Objeto: <a href=\""._URL."/index.php/content/view/".$array_objeto[0][0].".html\" target=\"_blank\">".$array_objeto[0][1]."</a><br><br>
                Caminho do objeto: <br>";

                for ($i=1; $i<sizeof($array_objeto); $i++) {
                    $mensagemEmail .= $i." - <a href=\""._URL."/index.php/content/view/".$array_objeto[$i][0].".html\" target=\"_blank\">".$array_objeto[$i][1]."</a><br>";
                }

                $mensagemEmail .= "<br><small>Mensagem gerada automaticamente. Nao responda.</small>
                </body></html>";

                $destinatario = _emailAvisoPublicacao;
                $remetente =  _remetenteAvisoPublicacao;
                $assunto = "Objeto publicado no site: "._PORTAL_NAME;
                $wassent = EnviarEmail($remetente, $destinatario, $assunto, $mensagemEmail); 
            }
        }
    }

    /**
     * Despublica objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $mensagem - Mensagem de despublicação
     * @param int $cod_objeto - Codigo do objeto
     */
    function DesPublicarObjeto(&$_page, $mensagem, $cod_objeto)
    {			
        if (($_SESSION['usuario']['perfil']==_PERFIL_ADMINISTRADOR) || ($_SESSION['usuario']['perfil']==_PERFIL_EDITOR))
        {
            $this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_PRIVADO);
        }
    }

    /**
     * Envia objeto para publicação, solicita publicação do objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $mensagem - mensagem de solicitação de publicação
     * @param int $cod_objeto - Codigo do objeto
     */
    function SubmeterObjeto(&$_page, $mensagem, $cod_objeto)
    {
        $dadosObjeto = $_page->_adminobjeto->PegaDadosObjetoPeloID($_page, $cod_objeto);

        if ((($_SESSION['usuario']['perfil']==_PERFIL_AUTOR) || ($this->UsuarioEdono($_page, $_SESSION['usuario']['cod_usuario'],$cod_objeto))) && ($dadosObjeto['cod_status'] == _STATUS_PRIVADO))
        {
            $this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_SUBMETIDO);

            $sql = "select ".$_SESSION["usuario"]["chefia"]." as cod_usuario,".$cod_objeto." as cod_objeto from usuarioxobjetoxperfil inner join parentesco on (usuarioxobjetoxperfil.cod_objeto=parentesco.cod_pai or usuarioxobjetoxperfil.cod_objeto=parentesco.cod_objeto) where parentesco.cod_objeto=".$cod_objeto." group by cod_usuario, cod_usuario";
            $rs = $_page->_db->ExecSQL($sql, 1, 1);
            $campos = $rs->fields;

            $sql = "select * from pendencia where cod_usuario = ".$campos['cod_usuario']." and cod_objeto = ".$campos['cod_objeto'];
            $rs = $_page->_db->ExecSQL($sql);

            if (!$rs->GetRows())
            {
                $sql = "insert into pendencia(cod_usuario, cod_objeto) values (".$campos['cod_usuario'].", ".$campos['cod_objeto'].")";
                $_page->_db->ExecSQL($sql);
            }

            $EnviaEmailSolicitacao = $_page->_adminobjeto->EnviaEmailSolicitacao($_page, $_SESSION['usuario']['chefia'], $cod_objeto, $mensagem);
        }
    }

    /**
     * Remove solicitação de publicação
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $mensagem - mensagem de remoção da pendencia
     * @param int $cod_objeto - Codigo do objeto
     */
    function RemovePendencia(&$_page, $mensagem, $cod_objeto)
    {
        $this->TrocaStatusObjeto($_page, $mensagem, $cod_objeto, _STATUS_PRIVADO);
        $sql = "delete from pendencia where cod_objeto = ".$cod_objeto;
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Troca status do objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $mensagem - Mensagem da troca de status
     * @param int $cod_objeto - Codigo do objeto
     * @param int $cod_status - Codigo do novo status
     */
    function TrocaStatusObjeto(&$_page, $mensagem, $cod_objeto, $cod_status)
    {
        if ($cod_objeto != _ROOT)
        {
            $_page->_db->ExecSQL("update objeto set cod_status=".$cod_status." where cod_objeto=$cod_objeto");
            $_page->_log->RegistraLogWorkFlow($_page, $mensagem, $cod_objeto, $cod_status);
        }
    }

    /**
     * Define status para criação do objeto conforme perfil do usuário
     * @return int - Codigo do status
     */
    function PegaStatusNovoObjeto()
    {
        if ($_SESSION['usuario']['perfil']==_PERFIL_AUTOR)
        {
            $status=_STATUS_PRIVADO;
        }
        else
        {
            $status = _STATUS_PUBLICADO;
        }

        return $status;
    }

    /**
     * Cria cópia de determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - codigo do objeto a ser copiado
     * @param int $cod_pai - Codigo do objeto pai onde sera criado novo objeto
     */
    function CopiarObjeto(&$_page, $cod_objeto, $cod_pai)
    {
        $this->DuplicarObjeto($_page, $cod_objeto, $cod_pai);
        $this->RemoveObjetoDaPilha($_page, $cod_objeto);
    }

    /**
     * Move determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a ser movido
     * @param int $cod_pai - Codigo do objeto pai onde ficara objeto movido
     */
    function MoverObjeto(&$_page, $cod_objeto, $cod_pai)
    {
        if ($cod_objeto==-1)
        {
                $cod_objeto=$this->PegaPrimeiroDaPilha($_page);
        }
        $sql = "update objeto set cod_pai=$cod_pai where cod_objeto=$cod_objeto";
        $_page->_db->ExecSQL($sql);

        $this->ApagarParentesco($_page, $cod_objeto);
        $this->CriaParentesco($_page, $cod_objeto, $cod_pai);

        $sql = "select objeto.cod_pai,objeto.cod_objeto from objeto inner join parentesco on objeto.cod_objeto=parentesco.cod_objeto 
                        where parentesco.cod_pai=".$cod_objeto." group by objeto.cod_objeto, objeto.cod_pai";
        $res = $_page->_db->ExecSQL($sql);
        $row = $res->GetRows();
        for ($i=0; $i<sizeof($row); $i++)
        {
                $this->ApagarParentesco($_page, $row[$i]['cod_objeto']);
                $this->CriaParentesco($_page, $row[$i]['cod_objeto'], $row[$i]['cod_pai']);
        }

        $this->RemoveObjetoDaPilha($_page, $cod_objeto);
    }

    /**
     * Cola objeto da pilha como link
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - codigo do objeto a ser colado como link
     * @param int $cod_pai - codigo do objeto que será pai do link
     */
    function ColarComoLink(&$_page, $cod_objeto, $cod_pai)
    {
        if ($cod_objeto==-1)
        {
            $cod_objeto=$this->PegaPrimeiroDaPilha($_page);
        }

        $orig_obj = $_adminobjeto->CriarObjeto($_page, $cod_objeto);
        $dados = $orig_obj->metadados;

        $status = $this->PegaStatusNovoObjeto();

        $campos=array();
        $campos['cod_pai'] = $cod_pai;
        $campos['cod_classe'] = _Interlink;
        $campos['cod_usuario'] = $dados['cod_usuario'];
        $campos['cod_pele'] = ($dados['cod_pele']+0);
        $campos['cod_status'] = $dados['cod_status'];
        $campos[' titulo'] = $_page->_db->Slashes($dados['titulo']);
        $campos['descricao'] = $_page->_db->Slashes($dados['descricao']);
        $campos['data_publicacao'] = ConverteData($dados['data_publicacao'],27);
        $campos['data_validade'] = ConverteData($dados['data_validade'],27);

        $novo_cod_objeto = $_page->_db->Insert('objeto',$campos);		

        $this->GravarPropriedades($_page, $novo_cod_objeto, _Interlink, array('property:endereco'=>"$cod_objeto"));
        $this->RemoveObjetoDaPilha($_page, $cod_objeto);
        $this->CriaParentesco($_page, $novo_cod_objeto, $cod_pai);
    }

    /**
     * Pega primeiro objeto da pilha
     * @param object $_page - Referência de objeto da classe Pagina
     * @return int - codigo do primeiro objeto da pilha
     */
    function PegaPrimeiroDaPilha(&$_page)
    {
        $sql = "select pilha.cod_objeto from pilha
                        where pilha.cod_usuario=".$_SESSION['usuario']['cod_usuario'];
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->fields;

        return $row['cod_objeto'];
    }

    /**
     * Duplica objeto e seus filhos
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a duplicar
     * @param int $cod_pai - Codigo do objeto pai, onde ficara novo objeto
     * @return int - Codigo do novo objeto
     */
    function DuplicarObjeto(&$_page, $cod_objeto, $cod_pai=-1)
    {
        if ($cod_objeto==-1)
        {
            $cod_objeto=$this->PegaPrimeiroDaPilha($_page);
        }

        $orig_obj = $_page->_adminobjeto->CriarObjeto($_page, $cod_objeto);
        $dados = $orig_obj->metadados;

        if ($cod_pai==-1) $cod_pai=$dados['cod_pai'];

        $campos = array();
        $campos['script_exibir'] = $dados['script_exibir'];
        $campos['cod_pai'] = $cod_pai;
        $campos['cod_classe'] = $dados['cod_classe'];
        $campos['cod_usuario'] = $dados['cod_usuario'];
        $campos['cod_pele'] = ($dados['cod_pele']+0);
        $campos['cod_status'] = $dados['cod_status'];
        $campos[' titulo'] = $_page->_db->Slashes($dados['titulo']);
        $campos['descricao'] = $_page->_db->Slashes($dados['descricao']);
        $campos['data_publicacao'] = ConverteData($dados['data_publicacao'],27);
        $campos['data_validade'] = ConverteData($dados['data_validade'],27);
        $campos['peso'] = $dados['peso'];

        $cod_objeto = $_page->_db->Insert('objeto',$campos);	
        $this->DuplicarPropriedades($_page, $cod_objeto, $orig_obj);
        $this->CriaParentesco($_page, $cod_objeto, $cod_pai);

        if ($orig_obj->PegaListaDeFilhos($_page))
        {
            while ($childobj = $orig_obj->PegaProximoFilho())
            {
                $this->DuplicarObjeto($_page, $childobj->Valor($_page, "cod_objeto"), $cod_objeto);
            }
        }

        $_page->_log->IncluirLogObjeto($_page, $cod_objeto, _OPERACAO_OBJETO_CRIAR);
        return $cod_objeto;
    }

    /**
     * Duplica propriedades de determinado objeto em outro objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $destino - codigo do objeto que recebera as propriedades
     * @param int $origem - codigo do objeto que tera proprieades duplicadas
     */
    function DuplicarPropriedades(&$_page, $destino, $origem)
    {
        $propriedades = $origem->PegaListaDePropriedades($_page);
        foreach ($propriedades as $nome => $valor)
        {
            if ($valor["tipo"]=="tbl_objref" && isset($valor["referencia"]))
            {
                $lista['property:'.$nome] = $valor['referencia'];
            }
            else
            {
                // adicionado para duplicar os blobs no caso de copias
                if ($valor["tipo"] == "tbl_blob" && isset($valor["cod_blob"]))
                {
                    $this->codigo_temp_blob = $valor['cod_blob'];
                    $this->tipo_temp_blob = $valor['tipo_blob'];
                    $this->tamanho_temp_blob = $valor['tamanho_blob'];
                }
                $lista["property:".$nome] = $valor["valor"];
            }
        }
        $this->GravarPropriedades($_page, $destino, $origem->Valor($_page, "cod_classe"), $lista);
    }

    /**
     * Busca lista de classes que podem ser criadas abaixo de determinada classe
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe a ser verificada
     * @return array - Lista de classes que podem ser criadas
     */
    function ListaDeClassesPermitidas(&$_page, $cod_classe)
    {
        $out=array();
        $sql = "select cod_classe_filho, classe.nome, classe.descricao,classe.prefixo from classexfilhos
                        inner join classe on classe.cod_classe=classexfilhos.cod_classe_filho
                        where classexfilhos.cod_classe=$cod_classe order by classe.nome";
        $res = $_page->_db->ExecSQL($sql);
        return $res->GetRows();
    }
    
    /**
     * Verifica quais classes podem ser criadas abaixo de determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto
     * @return array - Lista de classes que podem ser criadas
     */
    function ListaDeClassesPermitidasNoObjeto(&$_page, $cod_objeto)
    {
        $out=array();
        $sql = "select classe.cod_classe,classe.nome, classe.descricao,classe.prefixo from classexobjeto
                        inner join classe on classe.cod_classe=classexobjeto.cod_classe
                        where classexobjeto.cod_objeto=$cod_objeto order by classe.nome";
        $rs = $_page->_db->ExecSQL($sql);
        return $rs->GetRows();
    }

    /**
     * Envia objeto para pilha do usuario
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto para ir para pilha
     */
    function CopiarObjetoParaPilha(&$_page, $cod_objeto)
    {
        $sql = "insert into pilha (cod_objeto,cod_usuario) values($cod_objeto,".$_SESSION['usuario']['cod_usuario'].")";
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Remove objeto da pilha do usuario
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto que deve sair da pilha
     */
    function RemoveObjetoDaPilha(&$_page, $cod_objeto)
    {
        $sql = "delete from pilha where cod_usuario=".$_SESSION['usuario']['cod_usuario']." and cod_objeto=$cod_objeto";
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Limpa pilha do usuário
     * @param object $_page - Referência de objeto da classe Pagina
     */
    function LimparPilha(&$_page)
    {
        $sql = "delete from pilha where cod_usuario=".$_SESSION['usuario']['cod_usuario'];
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Pega pilha do usuario logado
     * @param object $_page - Referência de objeto da classe Pagina
     * @return array - lista de objetos na pilha
     */
    function PegaPilha(&$_page)
    {
        $result=array();
        $this->ContadorPilha=0;
        $sql = "select pilha.cod_objeto as codigo, objeto.titulo as texto from pilha
                        left join objeto on objeto.cod_objeto=pilha.cod_objeto
                        where pilha.cod_usuario=".$_SESSION['usuario']['cod_usuario'];
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->GetRows();
        for ($i=0; $i<sizeof($row); $i++)
        {
            $this->ContadorPilha++;
            $result[]=$row[$i];
        }
        return $result;
    }

    /**
     * Verifica se usuario tem objetos na pilha
     * @param object $_page - Referência de objeto da classe Pagina
     * @return int - Numero de objetos na pilha
     */
    function TemPilha(&$_page)
    {
        if (!$this->ContadorPilha)
        {
            $sql = "select count(*) as contador from pilha where cod_usuario=".$_SESSION['usuario']['cod_usuario'];
            $rs = $_page->_db->ExecSQL($sql);
            $this->ContadorPilha = $rs->fields["contador"];
        }
        return $this->ContadorPilha;
    }

    /**
     * Busca objetos da pilha e envia resultado para metodo que monta dropdown
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $selecionado - codigo do parametro que deve vir selecionado no <select>
     * @param bool $branco - indica se deve ter um <option> com value em branco
     * @return string - Lista de <option> para o <select>
     */
    function DropDownPilha(&$_page, $selecionado='', $branco=false)
    {
        $lista = $this->PegaPilha($_page);
        return $this->CriaDropDown($lista, $selecionado, $branco);
    }

    /**
     * Busca informações de determinada classe
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe
     * @return array - lista com informações da classe
     */
    function PegaInfoDaClasse(&$_page, $cod_classe)
    {
        $sql = "select * from classe where cod_classe=$cod_classe order by classe.nome";
        $rs = $_page->_db->ExecSQL($sql);
        $result['classe'] = $rs->fields;

        $sql = "select cod_classe,nome from classe order by nome";
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->GetRows();
        for ($i=0; $i<sizeof($row); $i++)
        {
            $result['todas'][$row[$i]['cod_classe']]=$row[$i];
        }

        $sql = "select cod_classe_filho from classexfilhos where cod_classe=$cod_classe";
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->GetRows();
        for ($i=0; $i<sizeof($row); $i++)
        {
            $result['todas'][$row[$i]['cod_classe_filho']]['permitido']=true;
        }

        $sql = "select cod_classe from classexfilhos where cod_classe_filho=$cod_classe";
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->GetRows();
        for ($i=0; $i<sizeof($row); $i++)
        {
            $result['todas'][$row[$i]['cod_classe']]['criadoem']=true;
        }

        $prop = $this->PegaPropriedadesDaClasse($_page, $cod_classe);
        $count=1;
        $result['prop']=array();
        if (is_array($prop))
        {
            foreach($prop as $value)
            {
                $result['prop'][$value['nome']]=$value;
            }

        }

        $sql = "select count(cod_objeto) as cnt from objeto where cod_classe=$cod_classe";
        $rs = $_page->_db->ExecSQL($sql);
        $result['obj_conta'] = $rs->fields["cnt"];

        $sql = "select objeto.cod_objeto, objeto.titulo from classexobjeto "
                . "inner join objeto on classexobjeto.cod_objeto=objeto.cod_objeto "
                . "where classexobjeto.cod_classe=$cod_classe";
        $res = $_page->_db->ExecSQL($sql);
        $row = $res->GetRows();
        for ($k=0; $k<sizeof($row); $k++)
        {
            $result['objetos'][]=$row[$k];
        }
        return $result;
    }

    /**
     * Busca tipos de dado existentes e envia valores para metodo que monta dropdown
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $selecionado - Valor que devera vir selecionado no dropdown
     * @param bool $branco - indica se devera ter <option> com value em branco
     * @return string - Lista de <option> para o <select>
     */
    function DropDownTipoDado(&$_page, $selecionado, $branco=false)
    {
        $lista=$this->PegaListaDeTipoDado($_page);
        return $this->CriaDropDown($lista, $selecionado, $branco);
    }

    /**
     * Pega lista de tipos de dados no banco de dados
     * @param object $_page - Referência de objeto da classe Pagina
     * @return array - lista com tipos de dados
     */
    function PegaListaDeTipoDado(&$_page)
    {
        $sql = "select cod_tipodado as codigo, nome as texto from tipodado order by nome";
        $rs = $_page->_db->ExecSQL($sql);
        return $rs->GetRows();
    }

    /**
     * Busca classes e envia valores para metodo que monta dropdown
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $selecionado - Valor que devera vir selecionado no dropdown
     * @param bool $branco - indica se devera ter <option> com value em branco
     * @return string - Lista de <option> para o <select>
     */
    function DropDownClasses(&$_page, $selecionado, $branco=false)
    {
        $lista = $this->PegaListaDeClasses($_page);
        return $this->CriaDropDown($lista,$selecionado,$branco);
    }

    /**
     * Busca lista de classes no banco de dados
     * @param object $_page - Referência de objeto da classe Pagina
     * @return array - lista de classes
     */
    function PegaListaDeClasses(&$_page)
    {
        $this->CarregaClasses($_page);

        foreach ($this->classesNomes as $texto => $codigo)
                $saida[]=array ('codigo'=>$codigo,'texto'=>$texto);

        return $saida;
    }

    /**
     * Busca lista de classes e monta checkboxes com lista
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $nome - Nome do checkbox
     * @param array $lista - Lista de itens para checkboxes
     * @param string $flag - item que deve ja aparecer checked
     * @param bool $habilitado - se checkboxes devem vir ativos ou desativados
     * @return string - html com checkboxes
     */
    function CheckBoxClasses(&$_page, $nome, $lista, $flag, $habilitado=true)
    {
        $codigo='cod_classe';
        $texto='nome';
        $selecionado=$flag;
        if (!is_array($lista))
        {
            $lista=$this->PegaListaDeClasses($_page);
            $codigo='codigo'; 
            $texto='texto';
            $selecionado='selecionado';
        }
        return $this->CriaCheckBox($nome,$lista,$codigo,$texto,$selecionado,$habilitado);
    }

    /**
     * Cria elementos html checkboxes
     * @param string $nome - Nome do checkbox
     * @param array $lista - Lista de itens para checkboxes
     * @param string $codigo - Nome do campo do array onde esta o valor
     * @param string $texto - Nome do campo do array onde está o nome do chackbox
     * @param string $selecionado - Campo que devera vir checado
     * @param string $habilitado - Campo que indica se checkbox devera ser ativo ou desativado
     * @return string
     */
    function CriaCheckBox($nome,$lista,$codigo='codigo',$texto='texto',$selecionado='selecionado',$habilitado=true)
    {
        $txt = "";
        $result = "";
        if (!$habilitado) $txt=" disabled ";
        foreach ($lista as $item)
        {
            $result.= '<input '.$txt.'type="checkbox" name="'.$nome.'" value="'.$item[$codigo].'"';
            if (isset($item[$selecionado]) && $item[$selecionado]) $result.=" checked ";
            $result.='>'.$item[$texto]."<BR>";
        }
        return $result;
    }

    /**
     * Busca lista de prefixos das classes, excluindo classe informada
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe que nao deseja buscar prefixo
     * @return array - lista com prefixos
     */
    function PegaListaDePrefixos(&$_page, $cod_classe)
    {
        $result=array();
        $sql = "select prefixo from classe where cod_classe<>$cod_classe";
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->GetRows();
        for ($i=0; $i<sizeof($row); $i++)
        {
            $result[]=$row[$i]['prefixo'];
        }
        return $result;
    }

    /**
     * Apaga propriedade
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe
     * @param string $nome - Nome da propriedade a ser apagada
     */
    function ApagarPropriedadeDaClasse(&$_page, $cod_classe, $nome)
    {
        $sql = "select cod_propriedade,tipodado.tabela from propriedade
                        left join tipodado on tipodado.cod_tipodado=propriedade.cod_tipodado
                        where propriedade.nome='$nome' and propriedade.cod_classe=$cod_classe";
        $rs = $_page->_db->ExecSQL($sql);
        $row = $rs->fields;

        if ($row['tabela']=="tbl_blob")
        {
            $sql = "select cod_blob,arquivo from tbl_blob where cod_propriedade=".$row['cod_propriedade'];
            $rs2 = $_page->_db->ExecSQL($sql);

            while ($row2 = $rs2->FetchRow())
            {
                $file_ext = $this->PegaExtensaoArquivo($row2['arquivo']);
                if (file_exists(_BLOBDIR."/".identificaPasta($row2['cod_blob'])."/".$row2['cod_blob'].'.'.$file_ext))
                    $checkDelete = unlink(_BLOBDIR."/".identificaPasta($row2['cod_blob'])."/".$row2['cod_blob'].'.'.$file_ext);
                if (defined ("_THUMBDIR"))
                {
                    if (file_exists(_THUMBDIR.$row2['cod_blob'].'.'.$file_ext)) unlink(_THUMBDIR.$row2['cod_blob'].'.'.$file_ext);
                }
            }
        }
        if (isset($row['tabela']) && $row['tabela']!="")
        {
            $sql = "delete from ".$row['tabela']." where cod_propriedade=".$row['cod_propriedade'];
            $_page->_db->ExecSQL($sql);
        }
        $sql = "delete from propriedade where cod_propriedade=".$row['cod_propriedade'];
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Renomeia propriedade
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe
     * @param string $nomeatual - Nome atual da propriedade
     * @param string $nome - novo nome da propriedade
     */
    function RenomearPropriedadeDaClasse(&$_page, $cod_classe, $nomeatual, $nome)
    {
        $sql = "update propriedade set nome='$nome' where nome='$nomeatual' and cod_classe=$cod_classe";
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Adiciona propriedade em classe
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe
     * @param array $novo - Dados da propriedade
     */
    function AcrescentarPropriedadeAClasse(&$_page, $cod_classe, $novo)
    {
        $sql = "insert into propriedade (cod_classe,cod_tipodado,cod_referencia_classe,campo_ref,nome,posicao, rotulo, descricao, obrigatorio, seguranca, valorpadrao, rot1booleano, rot2booleano)
                        values ($cod_classe,".($novo['cod_tipodado']+0).",'".($novo['cod_referencia_classe']+0)."','".$novo['campo_ref'].
                        "','".$novo['nome']."','".($novo['posicao']+0)."','".
                        $novo['rotulo']."','".$novo['descricao']."',".($novo['obrigatorio']+0).",".($novo['seguranca']+0).",'".trim($novo['valorpadrao'])."','".trim($novo['rot1booleano'])."','".trim($novo['rot2booleano'])."')";
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Atualiza dados de propriedade ao criar ou alterar classe
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_propriedade - Codigo da propriedade
     * @param array $dados - dados da proprieadde
     */
    function AtualizarDadosDaPropriedade(&$_page, $cod_propriedade,$dados)
    {
        $sql = "update propriedade set 
                        nome='".$dados['nome']."',
                        rotulo='".$dados['rotulo']."', 
                        descricao='".$dados['descricao']."', 
                        valorpadrao='".trim($dados['valorpadrao'])."', 
                        rot1booleano='".trim($dados['rot1booleano'])."', 
                        rot2booleano='".trim($dados['rot2booleano'])."', 
                        obrigatorio=".($dados['obrigatorio']+0).", 
                        seguranca=".($dados['seguranca']+0).",  
                        posicao=".($dados['posicao']+0)." 
                        where cod_propriedade=".$cod_propriedade;
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Atualiza informações de campo obj_ref para cadastro de classes
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe que contem a propriedade
     */
    function AtualizarInfoDaPropriedade(&$_page, $cod_classe, $novo)
    {
        $sql = "update propriedade set campo_ref='".$novo['cod_referencia_classe']."',
                        posicao='".$novo['posicao']."' where cod_classe=$cod_classe and
                        nome='".$novo['nome']."'";
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Busca lista de seções de usuários e envia retorno para funcao que monta dropdown
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $selecionado - Campo que deverá estar seleiconado
     * @param bool $branco - indica se deverá conter elemento <option> com value em branco
     * @return string - lista de <options> para popular <select>
     */
    function DropDownUsuarioSecao(&$_page, $selecionado=0, $branco=false){
        $lista = $this->PegaListaDeSecao($_page);
        return $this->CriaDropDown($lista,$selecionado,$branco,40);
    }

    /**
     * Busca lista de seçõas de usuários no banco
     * @param object $_page - Referência de objeto da classe Pagina
     * @return array - lista com seções
     */
    function PegaListaDeSecao(&$_page){
        $sql = "select DISTINCT secao as codigo, secao as texto from usuario "
                . "where valido=1 and secao <> '' order by secao";
        $rs = $_page->_db->ExecSQL($sql);
        return $rs->GetRows();
    }

    /**
     * Busca lista de usuarios e envia retorno para funcao que monta dropdown
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $selecionado - Campo que deverá estar seleiconado
     * @param bool $branco - indica se deverá conter elemento <option> com value em branco
     * @param string $secao - seção para buscar usuários
     * @return string - lista de <options> para popular <select>
     */
    function DropDownUsuarios(&$_page, $selecionado, $branco=false, $secao=NULL)
    {
        $lista=$this->PegaListaDeUsuarios($_page, $secao);
        return $this->CriaDropDown($lista,$selecionado,$branco,20);
    }

    /**
     * Busca lista de usuarios no banco de dados
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $secao - seção do usuario
     * @return array - Lista de usuários
     */
    function PegaListaDeUsuarios(&$_page, $secao=NULL)
    {
        if (!$secao)
                $sql = "select cod_usuario as codigo,nome as texto, chefia as intchefia from usuario where valido=1 order by  nome, secao";
        else 
                $sql = "select cod_usuario as codigo,nome as texto, chefia as intchefia from usuario where valido=1 and secao = '".$secao."' order by nome, secao";
        $rs = $_page->_db->ExecSQL($sql);
        return $rs->GetRows();
    }

    /**
     * Busca informações de determinado usuario
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_usuario - Codigo do usuario a buscar
     * @return array - Dados do usuario
     */
    function PegaInformacaoUsuario(&$_page, $cod_usuario)
    {
        $sql = "select cod_usuario,nome,email,login,chefia,secao,ramal,"
                . "data_atualizacao from usuario where cod_usuario=$cod_usuario";
        $rs = $_page->_db->ExecSQL($sql);
        return $rs->fields;
    }

    /**
     * Verifica se ja existe usuario com mesmo login
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $login - Login a ser verificado
     * @param int $cod_usuario - Codigo do usuario, caso seja update
     * @return bool
     */
    function ExisteOutroUsuario(&$_page, $login, $cod_usuario)
    {
        $sql = "select cod_usuario from usuario where login='$login' and valido<>0";
        if ($cod_usuario) $sql .=" and cod_usuario<>$cod_usuario ";
        $rs = $_page->_db->ExecSQL($sql);
        return !$rs->EOF;
    }

    /**
     * Apaga classe do banco de dados e objetos que pertencam a ela
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe a ser apagada
     */
    function ApagarClasse(&$_page, $cod_classe)
    {
        // apagando objetos da classe
        $sql = "select cod_objeto from objeto where cod_classe=".$cod_classe;
        $rs = $_page->_db->ExecSQL($sql);
        while ($row = $rs->FetchRow())
        {
            $this->ApagarObjeto($_page, $row['cod_objeto'],true);
        }

        // apagando propriedades da classe
        $sql = "delete from propriedade where cod_classe=".$cod_classe;
        $_page->_db->ExecSQL($sql);

        // apagando relacionamentos entre classes
        $sql = "delete from classexfilhos where cod_classe=".$cod_classe;
        $_page->_db->ExecSQL($sql);
        $sql = "delete from classexfilhos where cod_classe_filho=".$cod_classe;
        $_page->_db->ExecSQL($sql);

        // apagando relacionamentos entre classes e objetos
        $sql = "delete from classexobjeto where cod_classe=".$cod_classe;
        $_page->_db->ExecSQL($sql);

        // apagando a classe
        $sql  = "delete from classe where cod_classe=".$cod_classe;
        $_page->_db->ExecSQL($sql);
    }

    /**
     * Busca todos os direitos que usuario tem no portal
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $interCod_Usuario - Codigo do usuario
     * @return array
     */
    function PegaDireitosDoUsuario(&$_page, $interCod_Usuario)
    {
        $sql = "select cod_objeto, 
        cod_perfil 
        from usuarioxobjetoxperfil 
        where cod_usuario=$interCod_Usuario";
        $rs = $_page->_db->ExecSQL($sql);
        if ($rs->_numOfRows>0){
            while (!$rs->EOF){
                $out[$rs->fields['cod_objeto']]=$rs->fields['cod_perfil'];
                $rs->MoveNext();
            }
        }
        return $out;
    }

    /**
     * Busca perfil de usuário no objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_usuario - Codigo do usuario
     * @param int $cod_objeto - Codigo do objeto
     * @return boolean
     */
    function PegaPerfilDoUsuarioNoObjeto(&$_page, $cod_usuario, $cod_objeto)
    {
        if (empty($cod_usuario)) return false;
        $perfil = $this->PegaDireitosDoUsuario($_page, $cod_usuario);
        $caminho = explode(",", $_page->_adminobjeto->PegaCaminhoObjeto($_page, $cod_objeto));
        foreach ($perfil as $objeto => $cod_perfil)
        {
            if ((in_array($objeto, $caminho))) return $cod_perfil;
        }
        return false;
    }

    /**
     * Altera/exclui perfil de usuario em determinado objeto
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_usuario - Codigo do usuario
     * @param int $cod_objeto - Codigo do objeto
     * @param int $perfil - Perfil a ser adicionado
     * @param bool $inserir - Indica se deve inserir novo perfil
     */
    function AlterarPerfilDoUsuarioNoObjeto(&$_page, $cod_usuario, $cod_objeto, $perfil, $inserir=true)
    {
        $sql = "delete from usuarioxobjetoxperfil where cod_objeto=$cod_objeto and cod_usuario=$cod_usuario";
        $_page->_db->ExecSQL($sql);
        if ($inserir)
        {
            $sql = "insert into usuarioxobjetoxperfil (cod_usuario,cod_objeto,cod_perfil) values($cod_usuario,$cod_objeto,$perfil)";
            $_page->_db->ExecSQL($sql);
        }
    }

    /**
     * Busca lista de objetos apagados logicamente
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $start - dados para paginação da busca
     * @param int $limit - dados para paginação da busca
     * @return array - Lista de objetos apagados
     */
    function PegaListaDeApagados(&$_page, $start=-1, $limit=-1)
    {
        $out=array();
        $sql = "select cod_objeto,data_exclusao,titulo,cod_usuario,classe.nome as classe from objeto
                        left join classe on classe.cod_classe=objeto.cod_classe
                        where apagado=1 order by data_exclusao desc";
        if ($limit!=-1 && $start!=-1)
        {
            $rs = $_page->_db->ExecSQL($sql, $start, $limit);

        }
        else
        {
            $rs = $_page->_db->ExecSQL($sql);
        }
        $row = $rs->GetRows();
        for ($l=0; $l<sizeof($row); $l++)
        {
                $row[$l]['exibir']="/index.php/content/view/".$row[$l]['cod_objeto'].".html";
                $out[]=$row[$l];
        }
        return $out;
    }

    /**
     * Busca lista de objetos vencidos
     * @param object $_page - Referência de objeto da classe Pagina
     * @param string $ord1 - Metadado para ordenação da lista
     * @param string $ord2 - asc ou desc
     * @param int $inicio - dados para paginação da busca
     * @param int $limite - dados para paginação da busca
     * @param int $cod_objeto - Objeto pai da busca
     * @return array - Lista de objetos vencidos
     */
    function PegaListaDeVencidos(&$_page, $ord1="peso", $ord2="asc", $inicio=-1, $limite=-1, $cod_objeto=1)
    {
        $out=array();
        $sql = "select t1.cod_objeto,
        t1.titulo,
        t1.cod_usuario,
        t1.data_validade,
        t2.nome as classe 
        from objeto t1 
        inner join classe t2 on t2.cod_classe=t1.cod_classe 
        inner join parentesco t3 on t1.cod_objeto=t3.cod_objeto
        where t3.cod_pai=".$cod_objeto." 
        and t1.data_validade < ".date("Ymd")."000000 
        and t1.apagado=0
        order by t1.".$ord1." ".$ord2;
        $rs = $_page->_db->ExecSQL($sql, $inicio, $limite);
        $row = $rs->GetRows();

        for ($i=0; $i<sizeof($row); $i++)
        {
            $row[$i]['exibir']="/index.php?action=/content/view&cod_objeto=".$row[$i]['cod_objeto'];
            $out[]=$row[$i];
        }

        return $out;
    }

    /**
     * Apaga objeto em definitivo - fisicamente
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a ser apagado
     */
    function ApagarEmDefinitivo(&$_page, $cod_objeto)
    {
        $this->ApagarTags($_page, $cod_objeto);

        $sql = "select cod_objeto from parentesco where cod_pai=$cod_objeto";
        $res=$_page->_db->ExecSQL($sql);
        $row = $res->GetRows();

        for ($c=0; $c<sizeof($row); $c++)
        {
            $this->ApagarTags($_page, $row[$c]["cod_objeto"]);
            $sql = "delete from classexobjeto where cod_objeto=".$row[$c]["cod_objeto"];
            $_page->_db->ExecSQL($sql);
            $this->ApagarParentesco($_page, $row[$c]["cod_objeto"]);
            $this->ApagarPropriedades($_page, $row[$c]["cod_objeto"]);
            $sql = "delete from objeto where cod_objeto=".$row[$c]["cod_objeto"];
            $_page->_db->ExecSQL($sql);
        }

        $sql = "delete from classexobjeto where cod_objeto=".$cod_objeto;
        $_page->_db->ExecSQL($sql);
        $this->ApagarParentesco($_page, $cod_objeto);
        $this->ApagarPropriedades($_page, $cod_objeto);
        $_page->_db->ExecSQL("delete from parentesco where cod_objeto=$cod_objeto");
        $_page->_db->ExecSQL("delete from objeto where cod_objeto=$cod_objeto");
    }

    /**
     * Recupera objeto apagado logicamente
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_objeto - Codigo do objeto a ser recuperado
     */
    function RecuperarObjeto(&$_page, $cod_objeto)
    {
        $sql = "select parentesco.cod_objeto, 
        cod_status, 
        cod_classe 
        from parentesco 
        inner join objeto on parentesco.cod_objeto=objeto.cod_objeto 
        where parentesco.cod_pai=$cod_objeto 
        or parentesco.cod_objeto=$cod_objeto";
        $res=$_page->_db->ExecSQL($sql);
        $row = $res->GetRows();

        for ($i=0; $i<sizeof($row); $i++)
        {
            $sql = "update objeto set apagado=0 ";
            $sql .= " where cod_objeto=".$row[$i]['cod_objeto'];
            $_page->_db->ExecSQL($sql);
        }
        $_page->_log->IncluirLogObjeto($_page, $cod_objeto, _OPERACAO_OBJETO_RECUPERAR);
    }

    /**
     * Verifica se propriedade tem preenchimento obrigatorio
     * @param object $_page - Referência de objeto da classe Pagina
     * @param int $cod_classe - Codigo da classe que propriedade pertence
     * @param array $propriedades - Lista de propriedades
     * @return boolean
     */
    function ValidarPropriedades(&$_page, $cod_classe, $propriedades)
    {
        $lista = $this->PegaPropriedadesDaClasse($_page, $cod_classe);
        foreach ($lista as $prop)
        {
            if (($prop['obrigatorio']) && (!strlen($propriedades['prop:'.$prop['nome']]))) return false;
        }
        return true;	
    }

}
