<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/bootstrap.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<!-- Latest compiled and minified JavaScript -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("button[name='cancel_button']").click(function(){
		window.location.href="?page=<?= EmailCounter::$name ?>.php";
	})
})
</script>
<div class="container-fluid">
  <div class="row">
	  <div class="page-header">
          <div id="logo"><img src="<?=plugin_dir_url( __DIR__ ) ?>../include_files/logo.png" /></div>
			 <h1><small>Editar contador de cuenta atrás</small></h1>
			<div style="width:100%; margin:0 auto; padding:10px 20px;">

				<code><strong>Código de inserción: </strong>
				<?php if($this->counter->link && is_object($this->counter->link)): ?>
					<?php echo htmlentities('<a href="'.site_url().'/?timr_link='.$this->counter->link->slug .'">');?>
				<?php endif ?>
				<?= htmlentities("<img src='".site_url()."/?timr=".$this->counter->id."' />") ?>
				<?php if($this->counter->link && is_object($this->counter->link)): ?>
					<?php echo htmlentities("</a>"); ?>

				<?php endif ?>				
				</code>
				<?php
				$this->render_form();
				?>
			</div>
		</div>
	</div>
</div>