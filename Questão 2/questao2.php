<?php
	//CONSIDERANDO QUE ESTAS VARIAVEIS ESTARÃO ALIMENTADAS COM true OU false, O !empty RESOLVE O CASO
	if((!empty($_SESSION['loggedin'])) || (!empty($_COOKIE['Loggedin']))) {   
	    header("Location: http://www.google.com");   
		exit();
	}
	