<?php
	class ClasseLog
	{

		public $ArrayMetadados;
		
		function __construct(&$_page)
		{
			$this->ArrayMetadados=$_page->_db->metadados;
		}
		
		function RegistraLogWorkflow(&$_page, $mensagem, $cod_objeto, $cod_status)
		{
			$sql = "insert into logworkflow (cod_objeto,cod_usuario,mensagem,cod_status,estampa) values ($cod_objeto,".$_SESSION['usuario']['cod_usuario'].",'$mensagem',$cod_status,".$_page->_db->TimeStamp().')';
			$_page->_db->ExecSQL($sql);
		}

		function PegaLogWorkflow(&$_page, $cod_objeto)
		{
			$result = "";
			$sql = "select usuario.nome as usuario, mensagem, 
					status.nome as status, estampa from logworkflow 
					left join usuario on usuario.cod_usuario=logworkflow.cod_usuario
					left join status on status.cod_status=logworkflow.cod_status
					where cod_objeto=$cod_objeto order by estampa desc";
			$res = $_page->_db->ExecSQL($sql);
			$row = $res->GetRows();

			for ($i=0; $i<sizeof($row); $i++)
			{
				$row[$i]['estampa']=ConverteData($row[$i]['estampa'],1);
				$result[]=$row[$i];
			}
			return $result;
		}

		function InfoObjeto(&$_page, $cod_objeto)
		{
			$sql = "select usuario.nome as usuario, mensagem, 
					status.nome as status, estampa from logworkflow 
					left join usuario on usuario.cod_usuario=logworkflow.cod_usuario
					left join status on status.cod_status=logworkflow.cod_status
					where cod_objeto=$cod_objeto order by estampa desc";
			$res = $_page->_db->ExecSQL($sql,0,1);
			$row = $res->GetRows();
			for ($i=0; $i<sizeof($row); $i++)
			{
				$result = $row[$i];
			}
			$result['estampa'] = ConverteData($result['estampa'],1);
			return $result;
		}
		
		function IncluirLogObjeto(&$_page, $cod_objeto, $operacao)
		{
			$sql = "insert into logobjeto (cod_objeto,cod_usuario,cod_operacao,estampa)
					values ($cod_objeto,".$_SESSION['usuario']['cod_usuario'].
				   ",".$operacao.",".$_page->_db->TimeStamp().')';
			$_page->_db->ExecSQL($sql);
			if ($operacao==_OPERACAO_OBJETO_REMOVER || $operacao==_OPERACAO_OBJETO_RECUPERAR)
			{
                $sql = "insert into logobjeto (cod_objeto,cod_usuario,cod_operacao,estampa)
						select cod_objeto,".$_SESSION['usuario']['cod_usuario'].
				   ",".$operacao.",".$_page->_db->TimeStamp()." from parentesco where cod_pai=$cod_objeto";
				$_page->_db->ExecSQL($sql);
			}
		}
		
		function PegaLogObjeto(&$_page, $cod_objeto)
		{
			$result = "";
			global $_OPERACAO_OBJETO;
			$sql = "select usuario.nome as usuario, cod_operacao,
					estampa from logobjeto
					left join usuario on usuario.cod_usuario=logobjeto.cod_usuario
					where cod_objeto=$cod_objeto order by estampa desc";
			$res = $_page->_db->ExecSQL($sql);
			$row = $res->GetRows();

			for ($i=0; $i<sizeof($row); $i++)
			{
				$row[$i]['estampa']=ConverteData($row[$i]['estampa'],1);
				$row[$i]['operacao']=$_OPERACAO_OBJETO[$row[$i]['cod_operacao']];
				$result[]=$row[$i];
			}
			return $result;
		}
		
		
	
	}
?>