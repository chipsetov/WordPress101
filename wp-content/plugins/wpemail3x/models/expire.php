<?php
class Expired{
	var $expired;
	var $preview;
	var $path;
	var $cached;
	
	static $template_path;

	function Expired($settings = null){
		if(is_array($settings)){
			if(file_exists($settings["template"]."/expired.png")) $this->expired = $settings["template"]."/expired.png";
			if(file_exists($settings["template"]."/preview.png")) $this->preview = $settings["template"]."/preview.png";
			if(file_exists($settings["template"])) $this->path = $settings["template"];			
		}
		
	}
	function load(){
		
	}	
	
	function name(){
		$name = explode("/", $this->path);
		return end($name);		
	}
	
	function preview_file(){
		$preview_path = explode("/", $this->preview);
		return end($preview_path);
	}
	
	function preview_url(){
		return plugin_dir_url( $this->preview ) ."preview.png";
	}
	
	static function init(){
		Expired::$template_path = __DIR__."/../expired_images/";
	}
	
	static function find_by_name($name){
		if(file_exists(Expired::$template_path . $name)){
			return new Expired(array("template"=>Expired::$template_path . $name));
		}
		return null;
	}
	
	static function get_all(){
		$images = array();
		
		foreach(glob(Expired::$template_path."*", GLOB_ONLYDIR) as $template){
			$images[] = new Expired(array("template" => $template));
		}
		
		return $images;
	}
	function image(){		
		if(!$this->cached && file_exists($this->expired)) $this->cached = imagecreatefrompng($this->expired);
		return $this->cached; 				
		
	}
}
Expired::init();
?>