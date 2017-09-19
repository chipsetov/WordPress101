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
	<?php
$items = wp_get_nav_menu_items( 5 );?>
<pre>
	<?php
print_r( $items );


?>
</pre>
<?php
clean_custom_menu("primary");
?>


	<div class="container">

		<div class="row">

			<div class="col-xs-12">
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo home_url(); ?>">
                <?php bloginfo('name'); ?>
            </a>
    </div>

        <?php
            wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 3,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker())
            );
        ?>
    </div>
</nav>

				<?php  wp_nav_menu(array('theme_location'=>'primary')); ?>

			</div>
		</div>

	<img src="<?php header_image(); ?>" height="<?php get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" /> 