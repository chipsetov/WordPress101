<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/bootstrap.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("button[name='cancel_button']").click(function(){
		window.location.href="?page=<?= EmailCounter::$name ?>.php&action=link_index";
	})
})

</script>
<div class="container-fluid">
  <div class="row">
	  <div class="page-header">
		<img src="<?=plugin_dir_url( __DIR__ ) ?>../include_files/img/logo.png" width="250" />
			 <h1><small>Editar enlace</small></h1>
			<div style="width:500px;">
				<?php
				$this->render_form("_link");
				?>
			</div>

			
		</div>
	</div>
</div>