<?php

class bancoDeDados {

//*****************************ATRIBUTOS DA CLASSE PARA CONEXAO ************************
    var $aHost;
    var $aUsuario;
    var $aSenha;
	var $aBanco;
	var $aConexao;

//**************************** CONSTRUTOR DA CLASSE BD ********************
    function bancoDeDados($pHost, $pUsuario, $pSenha, $pBanco = "") {

        $this->aHost = $pHost;
        $this->aUsuario = $pUsuario;
        $this->aSenha = $pSenha;
        $this->aBanco = $pBanco;
        $this->conectar();
    }

//************************* FUNCAO CONECTAR *******************************

    function conectar() {
        try {
            $this->aConexao = new PDO('mysql:host='.$this->aHost.';dbname='.$this->aBanco,$this->aUsuario,$this->aSenha);
        } catch (PDOException $i) {
            print "Erro: <code>" . $i->getMessage() . "</code>";
        }
    }
}
