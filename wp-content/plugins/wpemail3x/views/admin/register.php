
<link rel="stylesheet" href="<?=plugin_dir_url( __FILE__ ) ?>../../include_files/css/bootstrap.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<style type="text/css" media="screen">
#register_form_container{margin-top:15px;}
</style>

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
			<img src="<?=plugin_dir_url( __DIR__ ) ?>../include_files/img/logo.png" width="250" />
		</div>
		
		<?php if(AdminController::$flash): ?>
			<div class="alert alert-<?php echo AdminController::$flash['type'] ?>" role="alert"><?php echo AdminController::$flash['message'] ?></div>
		<?php endif; ?>
		
		<h3>Introduzca su correo electrónico para registrar este producto</h3>
		<div class="col-lg-6" id="register_form_container">
			<form action="?page=email_counter.php&action=complete_registration" method="post" class="form-inline">
				<label>Dirección de correo electrónico</label>
				<input type="text" name="client_email" id="client_email_field" class="form-control"/>
				<input type="submit" name="submit" value="Register" id="submit" class="btn btn-primary">
			</form>
		</div>
	</div>
</div>