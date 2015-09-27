<?php
define('ABSPATH', '../');
include(ABSPATH . 'init.php');
include_once(ABSPATH_REPOSITORIES . '/TarefaClass.php');
$tarefaClass = new tarefaClass();

if(isset($_REQUEST['id'])) 
	$id = $_REQUEST['id'];

if(is_numeric($id)){
	$tarefaClass->delete($id);
}


