<?php
class Counter extends AppCore{
	public $end_date = "";
    public $end_time = "";
    public $template = "";
    public $expired = "";
    public $expired_image;
    public $width = 500;
    public $banner;
    public $link;
    public $timezone = "Europe/Madrid";
    public $id;
	
	public static $table_name;
	public static $fields = array('name', 'end_date', 'end_time', 'id', 'template', 'expired', 'width', 'timezone');
	
	function Counter($object = null, $eager_load = false){			
		if($object){
			foreach($object as $key => $value){
				$key = str_replace("Counter_", "", $key);
				if(property_exists($this, $key)){
					$this->{$key} = $value;
					if($key == "template" && $value){
						$this->banner = Banner::find_by_name($value);
					}
					if($key == "expired"){
						$this->expired_image = Expired::find_by_name($value);
					}
					if($key == "width" && $value == 0){
						$this->width = null;
					}					
				}
			}
			if(is_object($object) && property_exists($object, "Link_id")){
				$this->link = new Link($object);
			}
			if($eager_load){
				$this->link = Link::find_first($this->id, "counter_id", false);
			}
			if($this->banner && is_object($this->banner) && $this->end_time && $this->end_date){
				$this->banner->end_time = $this->end_time;
				$this->banner->end_date = $this->end_date;
				$this->banner->timezone = $this->timezone;
			}
			if($this->banner && is_object($this->banner) && $this->expired_image && is_object($this->expired_image)){
				$this->banner->expired = $this->expired_image;
			}
		}
		else{
			$this->end_date = strftime('%m/%d/%Y', time());
		}
	}
	
	function expired(){
		return !$this->is_running();
	}
	
	static function init(){
		self::$table_name = EmailCounter::$table_name;
	}

	function date_as_object(){
		$this->set_timezone();
		$date = date('Y-m-d', strtotime($this->end_date));
		return strtotime("{$date} {$this->end_time}");
	}
	
	function is_running(){
		if($this->date_as_object() > Time()) return true;
		return false;
	}
	
	function pretty_date_time(){
		$this->set_timezone();
		return strftime('%m/%d/%Y %I:%M %p', strtotime($this->end_date ." ". $this->end_time));
	}
	function pretty_date(){		
		$this->set_timezone();
		return strftime('%m/%d/%Y', strtotime($this->end_date));
	}	
	function set_timezone(){
		date_default_timezone_set($this->timezone);
	}
	
	function save(){
		global $wpdb;	
		$values = array($this->name, date('Y-m-d', strtotime($this->end_date)), $this->end_time, $this->template, $this->expired, $this->width, $this->timezone);
		if($this->id && intval($this->id) !== 0){
			$sql = "UPDATE ".EmailCounter::$table_name." SET name='%s', end_date='%s', end_time='%s', template='%s', expired='%s', width='%d', timezone='%s' WHERE id=%d";		
			$values[] = $this->id;
		}
		else{
			$sql = "INSERT INTO ".EmailCounter::$table_name." (name, end_date, end_time, template, expired, width, timezone) VALUES ('%s', '%s', '%s', '%s', '%s', '%d', '%s')";			
		}
		if($wpdb->query($wpdb->prepare($sql, $values)) !== false){
			if(!$this->id) $this->id = $wpdb->insert_id;
			return true;
		}
		return false;
	}
	
	function display(){
		if($this->banner){
			$this->banner->render();
		}
		else{
			return null;
		}
	}
	
}

Counter::init();
?>