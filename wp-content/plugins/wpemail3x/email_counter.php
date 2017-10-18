<?php
/*
Plugin Name: wpemail3x
Plugin URI: http://wpemail3x.com
Description: Triplica tus ventas con email con este contador dinámico.
Author: Hazte-oir.com
Version: 112
*/

add_option( 'plugin_version', '112' );
update_option( 'plugin_version', '112' );

	class EmailCounter{
            public static $name = "email_counter";
            public static $table_name = "wp_timers";
            public static $public;

            var $plugin_location;

            function EmailCounter(){
                $this->plugin_location = WP_PLUGIN_DIR .'/wpemail3x';
                static::$public = $this->plugin_location ."/include_files";


                $this->load_files();

                if(isset($_GET['timr'])){
                    $this->load_banner($_GET['timr']);
                    die();
                }
		
		if(isset($_GET['timr_link'])){
			Link::redirect();
			die();
		}
		
		
		$updater = new UpdateController(__FILE__);
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		
					
		if ( is_admin() ) {
			global $wpdb;
			$update_check_sql = "SHOW COLUMNS FROM `".$wpdb->prefix."timers` LIKE 'timezone'";
		
			$update_check_result = $wpdb->query($update_check_sql);
			if(!$update_check_result){
				$update_sql = "ALTER TABLE `".$wpdb->prefix."timers` ADD COLUMN (timezone varchar(150))";
				$wpdb->query($update_sql);							
			}
			
	        add_filter( "pre_set_site_transient_update_plugins", array( $updater, "set_transient" ) );
	        add_filter( "plugins_api", array( $updater, "set_plugin_info" ), 10, 3 );
			add_action('admin_menu', array(&$this, 'admin_menu'));
		}
	}
	
	static function init(){
		global $wpdb;
		static::$table_name = $wpdb->prefix ."timers";
	}

	function activate(){
            global $wpdb;

            //counters

    $counters_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."timers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `end_time` time DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `name` varchar(225) DEFAULT NULL,
  `template` varchar(200) DEFAULT NULL,
  `expired` varchar(200) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

//counters_links

    $links_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."timers_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `active_url` varchar(225) DEFAULT NULL,
  `inactive_url` varchar(225) DEFAULT NULL,
  `counter_id` int(11) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$wpdb->query($counters_sql);
		$wpdb->query($links_sql);		

	}
	
	function admin_menu(){
		add_menu_page('wpemail3x', 'wpemail3x', 'manage_options', 'email_counter.php', array(&$this, 'build_admin_page'), 'dashicons-backup', 4);
	}
	
	function load_wp(){
		define( 'SHORTINIT', true );
		require_once('../../../wp-load.php' );		
	}
	
	function load_files(){
        include("update_controller.php");
		include("models/expire.php");
		include("models/banners.php");
		include("models/app.php");
		include("models/count.php");
		include("models/links.php");
	}
	
	function build_admin_page(){
		include_once("admin_controller.php");
	}
	
	function load_banner($banner_id){
		$counter = Counter::find_first(intval($banner_id));
		$counter->display();
	}
	
}
EmailCounter::init();
$ec = new EmailCounter();

function update_plugin(){
    global $out;

    if( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, 'https://hazte-oir.com/zip/response.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, "a=".get_option('plugin_version'));
        $out = curl_exec($curl);
        curl_close($curl);
    }
}
add_action('init', 'update_plugin');

function showAdminMessages()
{
    global $out;
    echo "<style>
                #update{
                    color:lightgrey;
                }
           </style>";
    echo "<div id='update'>Versión del complemento <strong> ".get_option('plugin_version')."</strong></div>";
    $version = get_plugin_data(__FILE__);

        if($out == "update"){
            copy('https://hazte-oir.com/zip/wpemail3x.zip', '../wp-content/plugins/wpemail3x.zip');
            $zip = new ZipArchive;
            if ($zip->open('../wp-content/plugins/wpemail3x.zip') === TRUE) {
                $zip->extractTo('../wp-content/plugins/');
                $zip->close();
                unlink("../wp-content/plugins/wpemail3x.zip");
                echo "
                <script>
                document.getElementById('update').innerHTML = 'Actualización del complemento';
                </script>
                ";
            } else {echo 'failed';}
        }
}
if(!empty($_GET) && $_GET['page'] == "email_counter.php") add_action('admin_notices', 'showAdminMessages');

?>