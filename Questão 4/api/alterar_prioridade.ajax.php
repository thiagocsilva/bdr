<?php
define('ABSPATH', '../');
include(ABSPATH . 'init.php');
include_once(ABSPATH_REPOSITORIES . '/TarefaClass.php');
$tarefaClass = new tarefaClass();
$msg="";
$stt=0;
//variaveis da busca
if(isset($_REQUEST['idsInOrder'])) 
	$ids = $_REQUEST['idsInOrder'];

$tarefaClass->prioridade($ids);

		
		