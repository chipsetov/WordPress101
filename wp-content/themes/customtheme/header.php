<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo wp_get_document_title(); ?></title>
		<?php wp_head(); ?>
	</head>

	<?php
		if ( is_front_page() ):
			$custom_classes = array('custom-class', 'my-class');
		else:
			$custom_classes = array('no-custom-class');
		endif;

	?>
	
<body <?php body_class($custom_classes); ?>>

	<?php wp_nav_menu(array('theme_location'=>'primary')); ?>