<?php
define('ABSPATH', '../');
include(ABSPATH . 'init.php');
include_once(ABSPATH_REPOSITORIES . '/TarefaClass.php');
$tarefaClass = new tarefaClass();
$msg="";
$stt=0;
//variaveis da busca
if(isset($_REQUEST['id'])) 
	$id = $_REQUEST['id'];
if(isset($_REQUEST['titulo'])) 
	$titulo = $_REQUEST['titulo'];
if(isset($_REQUEST['descricao'])) 
	$descricao 	= $_REQUEST['descricao'];

$tarefa = compact('id', 'titulo', 'descricao');

if(isset($id) && is_numeric($id)){
	//update
	if (!$tarefaClass->update($tarefa)){
		$msg="Problema ao atualizar registro!";
	}
	else{
		$stt=1;
		$msg="Atualizado com Sucesso!";
	}
}
else{
	//insert
	$tarefa = compact('id', 'titulo', 'descricao');
	
	if (!$tarefaClass->insert($tarefa)){
		$msg="Problema ao inserir registro!";
	}
	else{
		$stt=$tarefaClass->lastInsertId();
		$msg="Inserido com Sucesso!";
	}

}
$retorno[] = array(
			'status' => $stt,
			'msg'	 => $msg,
		);
echo( json_encode( $retorno ) );
		
		