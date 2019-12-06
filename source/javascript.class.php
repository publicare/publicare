<?php
 
class Javascript
{
    
    private $_scripts = array();
    private $_conteudo = "";
    
    function __construct($scripts = array())
    {
        $this->_scripts = $scripts;
        if (count($this->_scripts) > 0)
        {
            foreach ($this->_scripts as $script)
            {
                $path = "javascript/".$script;
                if (file_exists($path) && is_readable($path))
                {
                    $this->_conteudo .= "\n".file_get_contents($path);
                }
                    
            }
        }
        
//        $this->_imprimeResultado();
    }
    
    public function imprimeResultado()
    {
        if ($this->_conteudo != "")
        {
            header("content-type: application/x-javascript");
            echo $this->_conteudo;
        }
    }
    
    public function incluiScripts()
    {
        
    }
    
}