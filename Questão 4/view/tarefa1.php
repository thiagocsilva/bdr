<?php
define('ABSPATH', '../');
include(ABSPATH . 'init.php');
Session::start();
$layout_title  ="Tarefa 1";
include(ABSPATH_PARTIAL . '/html_init.php');
include(ABSPATH_PARTIAL . '/header.php');
?>
    <div class="header-before breadcrumb-container">
        <div class="container ">
            <ol class="breadcrumb">
                <li><a href="<?php echo url('/'); ?>">Início</a></li>
                <li class="active">Tarefa 1</li>
            </ol>
        </div>
    </div>
    <div class="page">
        <div class="container card ">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h1>Tarefa 1</h1>
                    Escreva um programa que imprima números de 1 a 100.<br /> 
                    Mas, para múltiplos de 3 imprima “Fizz” em vez do número e para múltiplos de 5 imprima “Buzz”. 
                    Para números múltiplos de ambos (3 e 5), imprima “FizzBuzz”.

                    <hr />
                    <?php
					for($i=1;$i<=100;$i++){
						if(($i % 3 == 0) && ($i % 5 == 0))
						    echo "FizzBuzz";
						elseif($i % 3 == 0)
						    echo "Fizz";
						elseif($i % 5 == 0)
						    echo "Buzz";
						else
							echo $i;
							
						if($i % 20 == 0)
							echo '<br>';
						else
							echo " - ";
					}
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php include(ABSPATH_PARTIAL . '/footer.php'); ?>
<?php include(ABSPATH_PARTIAL . '/html_end.php'); ?>