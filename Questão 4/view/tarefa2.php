<?php
define('ABSPATH', '../');
include(ABSPATH . 'init.php');
Session::start();
$layout_title  ="Tarefa 2";
include(ABSPATH_PARTIAL . '/html_init.php');
include(ABSPATH_PARTIAL . '/header.php');
?>
    <div class="header-before breadcrumb-container">
        <div class="container ">
            <ol class="breadcrumb">
                <li><a href="<?php echo url('/'); ?>">Início</a></li>
                <li class="active">Tarefa 2</li>
            </ol>
        </div>
    </div>
    <div class="page">
        <div class="container card ">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h1>Tarefa 2</h1>
                    <p>
                    Refatore o código abaixo, fazendo as alterações que julgar necessário. 
                    </p>
                    <img  src="<?php echo url('/images/tarefa2_enunciado.png') ?>"  />
                    <hr />
                    <img  src="<?php echo url('/images/tarefa2_resolvido.png') ?>"  />
                </div>
            </div>
        </div>
    </div>
<?php include(ABSPATH_PARTIAL . '/footer.php'); ?>
<?php include(ABSPATH_PARTIAL . '/html_end.php'); ?>