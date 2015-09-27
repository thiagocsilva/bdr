<?php
define('ABSPATH', '');
include(ABSPATH . 'init.php');
Session::start();
$layout_title ="Prova Thiago Corrêa da Silva";
include_once(ABSPATH_PARTIAL . '/html_init.php');
include_once(ABSPATH_PARTIAL . '/header.php');
?>
<div class="header-before">
    <div class="home-pesquisa bg-05">
        <div class="container">
            <div class="row">
            	<div class="col-xs-12 col-sm-6  col-md-6  col-lg-6">
                    <h3>Thiago Corrêa da Silva</h3>
                    
                    <address>
                        <p >Endereço: Sv. Olandi, 50 </p>
                        <p >CEP: 88063-463</p>
                        <p >Bairro: Campeche </p>
                        <p >Cidade: Florianópolis/SC</p>
                        <p > Telefone: (47) 9928-0964 / (48) 8445-5160</p>
                        <p >E-mail: thiago.correa@netunna.com.br </p>
                        
                    </address>
                </div>
                <div class="col-xs-12 col-sm-6  col-md-6  col-lg-6">
                    <a href="<?php echo url(''); ?>" class="btn-logo">
                    <h2 class="white">Tarefas</h2>
                    </a>
                   <br />

                    <ul class="footer-links">
                        <li><a href="<?php echo url('/tarefa1'); ?>">Tarefa 1</a></li>
                        <li><a href="<?php echo url('/tarefa2'); ?>">Tarefa 2</a></li>
                        <li><a href="<?php echo url('/tarefa3'); ?>">Tarefa 3</a></li>
                        <li><a href="<?php echo url('/tarefa4'); ?>">Tarefa 4</a></li>
                    </ul>
                </div>   
            </div>
        </div>
    </div>
 </div>
<?php include(ABSPATH_PARTIAL . '/footer.php'); ?>
<?php include(ABSPATH_PARTIAL . '/scriptsbase.php'); ?>
<?php include(ABSPATH_PARTIAL . '/html_end.php'); ?>



