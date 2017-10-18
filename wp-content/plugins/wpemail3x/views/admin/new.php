<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/bootstrap.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
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
		<img src="<?=plugin_dir_url() ?>wpemail3x/include_files/logo.png" width="250" />
			 <h1><small>Crear un nuevo contador de cuenta atrás</small></h1>
			<div style="width:100%; padding:15px;">
				<?php
				$this->render_form();
				?>
			</div>

		</div>
	</div>
</div>