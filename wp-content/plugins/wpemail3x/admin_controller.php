<?php
class AdminController{
    public $plugin_location;
    public $counter;
    public $link;
    public $registered = false;
	public $alert = array();
	static $flash;
	
	function AdminController($location = ""){
		$this->plugin_location = $location;
		$this->counter = new Counter;
		$this->link = new Link;
 
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == "complete_registration" && !empty($_POST)){
			update_option("ot_user_email", $_POST['client_email']);
			if(!$this->validate_registration()) static::set_error("danger", "Sorry that email address was not found or does not have access to this product");
		}
		
		if(!$this->registered) $this->assert_registered();
		
		if(!isset($_REQUEST['action']) || $_REQUEST['action'] == "index"){
			$this->render('index');
		}
		else{
			$this->render($_REQUEST['action']);
		}		
	}
	
	function render_form($form=""){
		include($this->plugin_location. "/views/admin/".$form."_form.php");
	}

	static function set_error($type="error", $message=""){
		static::$flash = array("type" => $type, "message" => $message);
	}
	function assert_registered(){
		if($this->should_check_registration()){
			if($this->validate_registration()) return;
			else{
				include($this->plugin_location. "/views/admin/register.php");
				die();
			}
		}
	}
	
	function should_check_registration(){		
		$last_checked = get_option("ot_last_checked");
		$time = time();
	
		if($last_checked != "") $last_checked = strtotime($last_checked ." + 1 day");						

		if($last_checked == "" or $last_checked < $time) return true; 
		
		return false;
	}
	
	function validate_registration(){

		return true;
	}
	function render($action = null){
		$this->health_check();
		switch($action){
			//Link Actions
			case "new_link":
				include_once($this->plugin_location ."/views/admin/new_link.php");
				break;
			case "create_link":
				$this->create_link();
				break;
			break;			
			case "delete_link":
				$this->delete_link();
				break;			
			case "edit_link":
				$this->link = Link::find_first($_GET['link_id']);
				include_once($this->plugin_location ."/views/admin/edit_link.php");
				break;
			break;
			case "link_index":
				include_once($this->plugin_location ."/views/admin/link_index.php");		
				break;
			break;			
			

			case "new":
				include_once($this->plugin_location ."/views/admin/new.php");
				break;
			case "create":
				$this->create();
				break;
			break;			
			case "delete":
				$this->delete();
				break;			
			case "edit":
				$this->counter = Counter::find_first($_GET['counter_id']);
				include_once($this->plugin_location ."/views/admin/edit.php");
				break;
			break;
						
			default:
				include_once($this->plugin_location ."/views/admin/index.php");								
				break;
		}
	}
	
	function create_link(){
		if($_POST['link']){
			$link = new Link($_POST['link']);
			if(!$link->save()){
				print("Couldn't Save!");
			}
		}
		$this->render('link_index');				
	}
	
	function delete_link(){
		$link = Link::find_first($_POST['link_id']);
		$link->delete();
		$this->render('link_index');
	}
	
	function health_check(){
		if(!extension_loaded('gd') || !function_exists('gd_info')){
			$this->set_alert("PHP GD no encontrado. wp email 3x requiere la biblioteca de imágenes PHP GD. Póngase en contacto con su anfitrión para obtener PHP GD instalado", 'danger');
		}
	}
	
	function set_alert($message, $level){
		$this->alert["message"] = $message;
		$this->alert['level'] = $level;
	}
	function create(){
		if($_POST['counter']){
			$counter = new Counter($_POST['counter']);
			if(!$counter->save()){
				print("Couldn't Save!");
			}
			else{
				if(isset($_POST['link']['id']) && intval($_POST['link']['id']) != 0){
					if(trim($_POST['link']['active_url']) == ""){
						$link = Link::find_first($_POST['link']['id']);
						$link->delete();
					}
				}
				if(isset($_POST['link']['active_url']) && trim($_POST['link']['active_url']) != ""){
					$link_data = $_POST['link'];
					$link_data['counter_id'] = $counter->id;
					$link = new Link($link_data);
					$link->save();
				}
			}
		}
		$this->render();		
	}
	function delete(){
		$counter = Counter::find_first($_POST['counter_id']);
		$counter->delete();
		$this->render();
	}
}
$controller = new AdminController($this->plugin_location);
?>