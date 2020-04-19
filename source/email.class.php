<?php

define("EmailTextCharset", "utf-8");
define("EmailHtmlCharset", "us-ascii");
define("EmailNewLine", "\r\n");

class Email
{

	public $_remetente = "";
	public $_destinatario = "";
	public $_assunto = "";
	public $_corpo = "";
	public $_headers = "";
	
	function __construct($rem="", $des="", $ass="", $cor="")
	{
		$this->_remetente = $rem;
		$this->_destinatario = $des;
		$this->_assunto = $ass;
		$this->_corpo = $cor;
		
		$this->montaHeaders();
	}
	
	function montaHeaders()
	{
		$this->_headers = "MIME-Version: 1.0".EmailNewLine; 
		$this->_headers .= "Content-type: text/html; charset=utf-8".EmailNewLine; 
		$this->_headers .= "From: $this->_remetente".EmailNewLine; 
		$this->_headers .= "Return-Path: $this->_remetente".EmailNewLine;
	}
	
	function Send()
	{
		$this->envia();
	}
	
	function envia()
	{
		if (mail($this->_destinatario, $this->_assunto, $this->_corpo, $this->_headers))
			return true;
		else
			return false;
	}

}
?>