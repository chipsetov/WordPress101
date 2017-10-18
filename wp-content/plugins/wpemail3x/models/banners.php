<?php
class Banner{
    public $preview;
    public $background;
    public $font;
    public $end_time;
    public $end_date;
    public $timezone = "Europe/Madrid";
    public $path;
    public $xml;

    public $expired;
	
	static $template_path;

	function Banner($settings = null){
		if(is_array($settings)){
			if(file_exists($settings["template"]."/preview.png")) $this->preview = $settings["template"]."/preview.png";
			if(file_exists($settings["template"]."/background.png")) $this->background = $settings["template"]."/background.png";			
			if(file_exists($settings["template"]."/font.ttf")) $this->font = $settings["template"]."/font.ttf";
			if(file_exists($settings["template"])) $this->path = $settings["template"];
			if($this->path && file_exists($this->path ."/data.xml")) $this->xml = simplexml_load_file($this->path .'/data.xml');
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
		Banner::$template_path = __DIR__."/../clock/";
	}
	
	static function find_by_name($name){
		if(file_exists(Banner::$template_path . $name)){
			return new Banner(array("template"=>Banner::$template_path . $name));
		}
		return null;
	}
	
	static function get_all(){
		$banners = array();
		
		foreach(glob(Banner::$template_path."*", GLOB_ONLYDIR) as $template){
			$banners[] = new Banner(array("template" => $template));
		}
		
		return $banners;
	}
	
	function hex2rgb() {
	   $hex = str_replace("#", "", (string) $this->xml->font->color);

	   if(strlen($hex) == 3) {
	      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
	      $r = hexdec(substr($hex,0,2));
	      $g = hexdec(substr($hex,2,2));
	      $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array("r" => $r, "g" => $g, "b" => $b);   
	   return $rgb; 
	}
	
	function render(){
		date_default_timezone_set($this->timezone);
		include __DIR__.'/gifPlay.php';

		$future_date = new DateTime(date('r',strtotime($this->end_date ." ". $this->end_time)));
		$time_now = time();
		$now = new DateTime(date('r', $time_now));
		$color = $this->hex2rgb();
		$frames = array();
		$delays = array();

		$image = imagecreatefrompng($this->background);

		$delay = 100;
		$font = array(
			'size'=>(int) $this->xml->font->size,
			'angle'=>0,
			'x-offset'=>(int) $this->xml->font->x,
			'y-offset'=>(int) $this->xml->font->y - 10,
			'file'=>$this->font,
			//'color'=>imagecolorallocate($image, $color["r"], $color["g"], $color["b"]),
            'color'=>imagecolorallocate($image, 000, 000, 000),
		);
		
		for($i = 0; $i <= 60; $i++){
			$interval = date_diff($future_date, $now);
			if($future_date < $now){
				$image = imagecreatefrompng($this->background);

				$text = $interval->format((string) $this->xml->font->end_format);
				
				imagettftext ($image , $font['size']-10 , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
				if($this->expired && $this->expired->image() != null) imagecopyresampled ( $image , $this->expired->image() , 0 , 0 , 0 , 0 , imagesx($this->expired->image()) , imagesy($this->expired->image()) , imagesx($this->expired->image()) , imagesy($this->expired->image()) );
				
								
				ob_start();				

				imagegif($image);								

				$frames[]=ob_get_contents();
				$delays[]=$delay;
		        $loops = 1;
				ob_end_clean();
				break;
			} else {
				$image = imagecreatefrompng($this->background);
				$text = str_pad($interval->format((string) $this->xml->font->format), strlen((string) $this->xml->font->format), '0', STR_PAD_LEFT);
				imagettftext ($image , $font['size']-10 , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
				ob_start();
				imagegif($image);
				$frames[]=ob_get_contents();
				$delays[]=$delay;
		        $loops = 1;
				ob_end_clean();
			}
			$now->modify('+1 second');
		}
		header( 'Expires: Fri, 01 Jan 1999 05:00:00 GMT' );
		header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
		header( 'Cache-Control: post-check=0, pre-check=0', false );
		header( 'Pragma: no-cache' );
		$gif = new AnimatedGif($frames,$delays,$loops);
		$gif->display();
		
	}
}
Banner::init();
?>