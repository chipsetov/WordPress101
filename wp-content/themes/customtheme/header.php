<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo wp_get_document_title(); ?></title>
		<?php wp_head(); ?>
	</head>
	
<body>

	<?php wp_nav_menu(array('theme_location'=>'primary')); ?>