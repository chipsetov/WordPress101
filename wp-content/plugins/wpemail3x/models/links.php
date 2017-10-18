<?php
class Link extends AppCore{
	static $table_name;
		
	var $active_url;
	var $inactive_url;
	var $slug;
	
	var $counter_id = 0;
		
	var $counter;	
	
	public static $fields = array('id', 'name', 'active_url', 'inactive_url', 'slug', 'counter_id');
			
	function Link($object = null, $eager_load = true){
		if($object){
			foreach($object as $key => $value){
				$key = str_replace("Link_", "", $key);
				if(property_exists($this, $key)){
					$this->{$key} = $value;
					
					if($key == "counter_id" && $eager_load){
						$this->counter = Counter::find_first($this->counter_id);
					}
				}
			}			
		}
	}
	
	static function init(){
		self::$table_name = EmailCounter::$table_name . "_links";
	}
	
	static function redirect(){
		if(isset($_GET['timr_link'])){
			$link = Link::find_first($_GET['timr_link'], "slug");
			if($link){
				if($link->counter->expired()){
					header("Location: {$link->inactive_url}");
				}
				else{
					header("Location: {$link->active_url}");					
				}
			}else{
				die("Invalid Link");
			}
			
		}
	}
	
	function save(){
		global $wpdb;	
		if(!$this->slug) $this->slug = $this->generate_random_key();		
		$values = array($this->name, $this->active_url, $this->inactive_url, $this->counter_id);
		if($this->id && intval($this->id) !== 0){
			$sql = "UPDATE ".self::$table_name." SET name='%s', active_url='%s', inactive_url='%s', counter_id=%d WHERE id=%d";		
			$values[] = $this->id;
		}
		else{
			$values[] = $this->slug;
			$sql = "INSERT INTO ".self::$table_name." (name, active_url, inactive_url, counter_id, slug) VALUES ('%s', '%s', '%s', %d, '%s')";			
		}
		
		if($wpdb->query($wpdb->prepare($sql, $values))){
			return true;
		}
		return false;
	}
	function generate_random_key(){
		global $wpdb;
		$range = array_merge(range('a', 'z'), array_merge(range('A', 'Z'), range(5, 9)));
		shuffle($range);
		$slug = substr(implode($range), 0, rand(4, 15));
		$count = $wpdb->get_results("SELECT count(*) as count FROM ".self::$table_name." WHERE slug = '".$slug."'");
		if($count){
			while((int) $count[0]->count > 0){
				shuffle($range);
				$slug = substr(implode($range), 0, rand(4, 15));
				$count = $wpdb->get_results("SELECT count(*) as count FROM ".self::$table_name." WHERE slug = '".$slug."'");
				print_r($count);
			}
		}
		return $slug;
	}
}

Link::init();
?>