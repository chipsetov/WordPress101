<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/bootstrap.css">
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	$('button[name="delete_button"]').click(function(){
		var link_id = $(this).data('link-id');
		var form = $("#delete_"+ link_id +"_form");
		$('#confirm').modal({ backdrop: 'static', keyboard: false }).on('click', "#delete", function(){
			form.submit();
		})
	});	
	$("button[name='new_link']").click(function(){
		window.location.href="?page=<?= EmailCounter::$name ?>.php&action=new_link";
	})
	$("button[name='edit_link']").click(function(){
		var link_id = $(this).data('link-id');
		window.location.href="?page=<?= EmailCounter::$name ?>.php&action=edit_link&link_id="+ link_id;
	})	
})

</script>
<div id="confirm" class="modal fade">
	 <div class="modal-dialog modal-sm">
		<div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerca</span></button>
	        <h4 class="modal-title">Confirmar</h4>
	      </div>			
			<div class="modal-body">
                Estás seguro de que quieres eliminar este elemento?
		  	</div>
		    <div class="modal-footer">
		      <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Borrar</button>
		      <button type="button" data-dismiss="modal" class="btn">Cancelar</button>
		    </div>
		</div>
	</div>
</div>



<div class="container-fluid">
  <div class="row">
	  <div class="page-header">
		<img src="<?=plugin_dir_url( __DIR__ ) ?>../include_files/img/logo.png" width="250" />
			 <h1><small>Enlaces Creados</small></h1>

			<table class="table">
				<thead>
					<tr>
						<td>
                            Nombre
						</td>
						<td>
                            Activo URL
						</td>
						<td>
                            Inactivo URL
						</td>						
						<td>
                            Comportamiento
						</td>			
					</tr>
				</thead>
				<tbody>
					<?php foreach(Link::get_all() as $link): ?>
					<tr>
						<td>
							<?= $link->name ?>
						</td>
						<td>
							<?= $link->active_url ?>
						</td>
						<td>
							<?= $link->inactive_url ?>
						</td>						
						<td>
							<form id="delete_<?=$link->id ?>_form" action="#" method="POST">
								<input type="hidden" value="delete_link" name="action">					
								<input type="hidden" value="<?= $link->id ?>" name="link_id">
							</form>
							<button type="button" class="btn btn-default btn-sm" name="edit_link" data-link-id="<?=$link->id ?>">Editar</button>
							&nbsp;							
							<button type="button" name="delete_button" class="btn btn-danger btn-sm" data-link-id="<?=$link->id ?>">Borrar</button>
						</td>						
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<button type="button" name="new_link" class="btn btn-primary">Crear enlace</button>
			<a href="?page=email_counter.php" class="btn btn-default">Ver contador</a>
	  </div>
  </div>
</div>