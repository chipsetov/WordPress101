<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/bootstrap.css">
<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/custom.css">

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
	$('button[name="delete_button"]').click(function(){
		var counter_id = $(this).data('counter-id');
		var form = $("#delete_"+ counter_id +"_form");
		$('#confirm').modal({ backdrop: 'static', keyboard: false }).on('click', "#delete", function(){
			form.submit();
		})
	});	
	$("button[name='new_counter']").click(function(){
		window.location.href="?page=<?= EmailCounter::$name ?>.php&action=new";
	})
	$("button[name='edit_counter']").click(function(){
		var counter_id = $(this).data('counter-id');
		window.location.href="?page=<?= EmailCounter::$name ?>.php&action=edit&counter_id="+ counter_id;
	})	
	$("button[name='embed_counter']").click(function(){
		var counter_id = $(this).data('counter-id');
		var link_path = $(this).data('link-path');
		var banner_width = $(this).data('banner-width');
		var counter_name = $(this).data('counter-name');		
		var plugin_url = "<?php echo site_url(); ?>";
		
		var width = (banner_width != "") ? " width='"+ banner_width +"px'" : "";
		
		var embed = "&lt;img"+width+" src='"+plugin_url+"/?timr="+counter_id+"'/&gt;";
        var embedMin = plugin_url +"/?timr_link="+link_path;
		if(link_path != ""){
			embed = "&lt;a href='"+ plugin_url +"/?timr_link="+link_path+"'&gt;"+ embed +"&lt;/a&gt;";
		}
		$("#embed_code").html("<div class='linkshort'><p class='modal-title-min'>Código Contador</p><code>"+ embed +"</code></div><div class='linkshort'><p class='modal-title-min'>Código Enlace</p><strong>&lt;a href='" + embedMin + "'&gt;link&lt;/a&gt;</strong></div>");
		$("#timer_embed_name").html('"' + counter_name +'"');
		$('#embed').modal({ backdrop: 'static', keyboard: false });
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

<?php if(!empty($this->alert)): ?>
	<div class="alert alert-<?php echo $this->alert['level'] ?>" role="alert"><?php echo $this->alert['message']; ?></div>
<?php endif; ?>

<div id="embed" class="modal fade">
	 <div class="modal-dialog">
		<div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerca</span></button>
	        <h4 class="modal-title"><span id="timer_embed_name">timer_name</span> Código de inserción</h4>
	      </div>			
			<div class="modal-body" id="embed_code">
	    	  embed_code
		  	</div>
		    <div class="modal-footer">
		      <button type="button" data-dismiss="modal" class="btn btn-primary">Listo</button>
		    </div>
		</div>
	</div>
</div>

<div class="container-fluid">
  <div class="row">
	  <div class="page-header">
		<img src="<?php echo plugin_dir_url() ?>wpemail3x/include_files/logo.png" width="250" />
			<h2>Contador de cuenta regresiva</h2>
			<table class="table">
				<thead>
					<tr>
						<td>
                            Nombre
						</td>
						<td>
                            Fecha final
						</td>
						<td>
                            Zona horaria
                        </td>
						<td>
                            Comportamiento
						</td>			
					</tr>
				</thead>
				<tbody>
					<?php foreach(Counter::get_all(array("class"=> "Link", "key"=>"counter_id", "foreign_key"=>"id")) as $counter): ?>
					<tr <?php if($counter->is_running()): ?> class="info" <?php else: ?> class="success" <?php endif; ?>>
						<td>
							<?= $counter->name ?>
						</td>
						<td>
							<?= $counter->pretty_date_time(); ?>
						</td>
						<td>
							<?= $counter->timezone; ?>
						</td>						
						<td>
							<form id="delete_<?=$counter->id ?>_form" action="#" method="POST">
								<input type="hidden" value="delete" name="action">					
								<input type="hidden" value="<?= $counter->id ?>" name="counter_id">
							</form>
							<button type="button" class="btn btn-default btn-sm" name="edit_counter" data-counter-id="<?=$counter->id ?>">Editar <span class="glyphicon glyphicon-wrench"></button>
							<button type="button" class="btn btn-default btn-sm" name="embed_counter" data-counter-name="<?=$counter->name ?>" data-counter-id="<?=$counter->id ?>" data-link-path="<?php if($counter->link) echo $counter->link->slug?>" data-banner-width="<?php echo $counter->width ?>">Obtener código de contador <span class="glyphicon glyphicon-time"></button>
							&nbsp;							
							<button type="button" name="delete_button" class="btn btn-danger btn-sm" data-counter-id="<?=$counter->id ?>">Borrar <span class="glyphicon glyphicon-trash"></span></button>
						</td>						
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<button type="button" name="new_counter" class="btn btn-primary">Crear contador</button>
			<a href="?page=email_counter.php&action=link_index" class="btn btn-default">Ver enlaces</a>
	  </div>
  </div>
</div>