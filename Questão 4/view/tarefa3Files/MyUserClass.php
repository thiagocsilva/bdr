<?php

include_once("config.php");
include_once("bancoClass.php");

class MyUserClass extends bancoDeDados {

    function __construct() {
        parent::__construct(BD_HOST, BD_USUARIO, BD_SENHA, BD_BANCO);
    }

    public function getUserList()
	{
		$results = $this->query('select name from user'); 
		
		sort($results);    
    
		return $results;       
    }
}
