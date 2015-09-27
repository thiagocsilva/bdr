<?php
define('ABSPATH', '../');
include(ABSPATH . 'init.php');
Session::start();
$layout_title  ="Tarefa 4";
include(ABSPATH_PARTIAL . '/html_init.php');
include(ABSPATH_PARTIAL . '/header.php');
include(ABSPATH_REPOSITORIES . '/TarefaClass.php');
$tarefaClass = new tarefaClass();
$tarefas = $tarefaClass->findByStatus();
?>
    <div class="header-before breadcrumb-container">
        <div class="container ">
            <ol class="breadcrumb">
                <li><a href="<?php echo url('/'); ?>">Início</a></li>
                <li class="active">Tarefa 4</li>
            </ol>
        </div>
    </div>
    <div class="page">
        <div class="container card ">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h1>Tarefa 4</h1>
                    <p>
                    Desenvolva uma API Rest para  um sistema gerenciador de tarefas (inclusão/alteração/exclusão). 
                    </p>
                    <p>
                    As tarefas consistem em título e descrição, ordenadas por 
                    prioridade.
                    </p>
                    <h5>Desenvolver utilizando:</h5> 
                    <lu>
                        <li>Linguagem PHP (ou framework CakePHP); </li>
                        <li>Banco de dados MySQL; </li>
                    </lu>
                    
                    <h5>Diferenciais:</h5> 
                    <lu>
                        <li>Criação de interface para visualização da lista de tarefas;  </li>
                        <li>Interface com drag and drop;  </li>
                        <li>Interface responsiva (desktop e mobile);</li>
                    </lu> 
                    </p>
                    <hr/> 
                    
                    <h3>Lista de Tarefas 
                    <button onclick="feed_modal_tarefa();" class="btn btn-primary btn-sm pull-right">
                    Nova Tarefa
                    </button>                    
                    
                    </h3>
                    
                    <ul id="sortable" class="tarefa_listagem">
                    	<?php
						$ct=0;
						foreach ($tarefas as $tarefa){ ;
						?>
                            <li id="<?php  echo $tarefa['id']; ?>" class="tarefa_row ui-state-default"  >
								<!--Titulo tarefa-->
								<?php 
								echo $tarefa['titulo'];
								?>
                                <!--Ações-->                                
                                <span data-action="<?php  echo url('/api/deletar_tarefa.ajax.php?id='.$tarefa['id'])?>" data-toggle="tooltip" data-placement="bottom" data-original-title="Excluir" class="pull-right mg-3-5 fs-20 pointer icon-delete"></span>

                                <span onclick="feed_modal_tarefa(<?php echo $tarefa['id'].",'".$tarefa['titulo']."','".$tarefa['descricao']."'";?>)" 
                                	data-toggle="tooltip" data-placement="bottom" data-original-title="Editar" class="pull-right mg-3-5 pointer icon-write"></span>
                                
                                
                                <span onclick="feed_modal_tarefa(<?php echo $tarefa['id'].",'".$tarefa['titulo']."','".$tarefa['descricao']."','ver'";?>)" 
                                	data-toggle="tooltip" data-placement="bottom" data-original-title="Ver" class="pull-right mg-3-5 pointer icon-eye"></span>
                                
                             </li>
                             
                        <?php	
							$ct++;
						}
						if($ct==0){ ?>
							<li id="noRows"  class="tarefa_row"  >Nenhuma tarefa cadastrada no momento!</li>
						<?php
                        }
						?>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="md-tarefas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 id="md-title" class="modal-title" id="myModalLabel">Modal title</h4>
                          </div>
                          <div  class="modal-body">
                            <input id="ipt-id" name="ipt-id" type="hidden">
                            <input id="ipt-title" name="ipt-title" type="text" class="form-control" placeholder="Título" >
                            <textarea name="ipt-desc" id="ipt-desc" rows="6" class="form-control mw-570" placeholder="Descrição"></textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Fechar</button>
                            <button onclick="gerenciar_tarefa()" type="button" class="md-save btn btn-sm btn-success">Salvar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
<?php include(ABSPATH_PARTIAL . '/footer.php'); ?>
<?php include(ABSPATH_PARTIAL . '/scriptsbase.php'); ?>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 function grava_prioridade(){
     var idsInOrder = [];
     $("ul#sortable li").each(function() {
	 		idsInOrder.push($(this).attr('id'));
		});
	 $.getJSON('<?php  echo url('/api/alterar_prioridade.ajax.php')?>',{ idsInOrder:idsInOrder, ajax: 'true'}, function(j){ });
 }
 
  
  


 $(function() { 
	$('[data-toggle="tooltip"]').tooltip();
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
	$( "#sortable" ).sortable({
		stop: function( ) {
            var order = $("#sortable").sortable("serialize", {key:'order[]'});
            grava_prioridade();
        }
    });
	active_delete();
  });


//alimenta modal com informações da tarefa
function feed_modal_tarefa(id, titulo, descricao,acao){
	$('#ipt-title').removeClass('hidden');
	$('.md-save').removeClass('hidden');
	if(typeof id == 'undefined'){
		$('#md-title').html('Cadastrar nova tarefa.');
		$('#ipt-id').val('');
		$('#ipt-title').val('');
		$('#ipt-desc').val('');
	}
	else{
		if(acao=='ver'){
			$('#md-title').html(titulo);
			$('#ipt-title').addClass('hidden');
			$('#ipt-desc').val(descricao);
			$('.md-save').addClass('hidden');
		}
		else{
			$('#md-title').html('Editar Tarefa '+id);
			$('#ipt-id').val(id);
			$('#ipt-title').val(titulo);
			$('#ipt-desc').val(descricao);
		}
		
	}
	$('#md-tarefas').modal('show');
}

function gerenciar_tarefa(){
	
	id = $('#ipt-id').val();
	titulo = $('#ipt-title').val();
	descricao = $('#ipt-desc').val();
	
	tl_temp = titulo.replace(/(^\s+|\s+$)/g,' ');
	ds_temp = descricao.replace(/(^\s+|\s+$)/g,' ');
	if(tl_temp.length<3){
		swal("Oops","Por favor, preencha o título.","error");
	}
	else if(ds_temp.length<3){
		swal("Oops","Por favor, preencha a descrição.","error");
	}
	else{
	
		$.getJSON('<?php  echo url('/api/gerenciar_tarefas.ajax.php')?>',{ id:id, titulo:titulo,descricao:descricao,ajax: 'true'}, function(j){
		  
			  if(j[0].status==0){ 
				swal("Oops", j[0].msg,'error'); 
			  }
			  else{ 
				  if(j[0].status==1){
					   //atualizou 
					   result = titulo;
					   result+='<span data-action="<?php  echo url('/api/deletar_tarefa.ajax.php?id=');?>'+id+'"  data-toggle="tooltip" data-placement="bottom" data-original-title="Excluir" class="pull-right mg-3-5 fs-20 pointer icon-delete"></span>';
					   result+='<span id="edt'+id+'" onclick="" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar" class="pull-right mg-3-5 pointer icon-write"></span>';
					   result+='<span id="see'+id+'" onclick="" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver" class="pull-right mg-3-5 pointer icon-eye"></span>';
					   $('#'+id).html(result);
					   $("#edt"+id).attr("onclick","feed_modal_tarefa("+id+",'"+titulo+"','"+descricao+"')");
					   $("#see"+id).attr("onclick","feed_modal_tarefa("+id+",'"+titulo+"','"+descricao+"','ver')");
				  }
				  else{
					  $('#noRows').remove();
					   //inseriu
					   result ='<li id="'+j[0].status+'" class="tarefa_row ui-state-default ui-sortable-handle">';
					   result+= titulo;
					   result+='<span data-action="<?php  echo url('/api/deletar_tarefa.ajax.php?id=');?>'+j[0].status+'" data-toggle="tooltip" data-placement="bottom" data-original-title="Excluir" class="pull-right mg-3-5 fs-20 pointer icon-delete"></span>';
					   result+='<span id="edt'+j[0].status+'" onclick="" data-toggle="tooltip" data-placement="bottom" data-original-title="Editar" class="pull-right mg-3-5 pointer icon-write"></span>';
					   result+='<span id="see'+j[0].status+'" onclick="" data-toggle="tooltip" data-placement="bottom" data-original-title="Ver" class="pull-right mg-3-5 pointer icon-eye"></span>';
					   result+='</li>';		
					   $('#sortable').append(result);
					   $("#edt"+j[0].status).attr('onclick',"feed_modal_tarefa("+j[0].status+",'"+titulo+"','"+descricao+"')");
					   $("#see"+j[0].status).attr('onclick',"feed_modal_tarefa("+j[0].status+",'"+titulo+"','"+descricao+"','ver')");
				  }
				  active_delete();
				  $('#md-tarefas').modal('hide');
				  swal("Bom Trabalho", j[0].msg); 
			  }   
	 	});
	}
}

function active_delete(){
  $('.icon-delete').click(function () {
        var $this = $(this);
        swal({
                title: "Tem certeza?",
                text: "Você não será capaz de recuperar essa tarefa!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, delete isto!",
                cancelButtonText: "Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        method: "GET",
                        url: $this.data('action'),
                        error: function () {
                            //swal("Deletado!", "Sua tarefa foi removida com sucesso.", "success");

                        },
                        success: function () {
							li_hide = $this.data('action').split("=");
                            $('#'+li_hide[1]).remove();
							verifica_lista_vazia();
                            swal("Deletado!", "Esta tarefa foi removida com sucesso.", "success");
							
                        }
                    });

                } else {
                    swal("Cancelado", "Sua tarefa está segura!", "error");
                }
            });
			
  });
}
 
 function verifica_lista_vazia(){
     var idsInOrder = [];
	 cont=0
     $("ul#sortable li").each(function() {
	 		cont++;
		});
	 if(cont==0)
	 	 $('#sortable').html('<li id="noRows"  class="tarefa_row"  >Nenhuma tarefa cadastrada no momento!</li>'); 
 }

</script>
<?php include(ABSPATH_PARTIAL . '/html_end.php'); ?>