<?php
class AppCore{
    public $name;
    public $id;

	static function find_first($item_id, $key = "id", $eager_load = true){
		global $wpdb;
		$class = get_called_class();
		$results = $wpdb->get_results($wpdb->prepare("SELECT ".static::fields_to_query()." FROM ". static::$table_name ." as {$class} WHERE {$key}=%s LIMIT 1", $item_id));
		
		if(!empty($results)){
			return $item = new $class(array_pop($results), $eager_load);
		}
		return false;
	}
			
	function delete(){
		global $wpdb;
		return $wpdb->query($wpdb->prepare("DELETE FROM ".static::$table_name." WHERE id=%d", $this->id));
	}
	
	static function fields_to_query(){
		$class = get_called_class();
		$query = "";
		foreach(static::$fields as $field){
			$query .= "{$class}.{$field} as {$class}_{$field}";
			if($field != end(static::$fields)) $query .= ", ";
		}
		return $query;
	}
	
	static function get_timezones(){
		$timezones = array();
		$timezone_regions = array(DateTimeZone::AMERICA, DateTimeZone::EUROPE, DateTimeZone::ASIA, DateTimeZone::AUSTRALIA, DateTimeZone::PACIFIC);
		foreach($timezone_regions as $location){		
			$timezones = array_merge($timezones, DateTimeZone::listIdentifiers($location));
		}
		
		return $timezones;
	}
	
	static function get_all($join = null){
		global $wpdb;
		$class = get_called_class();

		$join_pre = "";
		$join_post = ""; 
		
		if($join){
			$join_pre .= ", ". $join['class']::fields_to_query();
			$join_post .= " LEFT JOIN {$join['class']::$table_name}  as {$join['class']} ON {$class}.{$join['foreign_key']} = {$join['class']}.{$join['key']}";			
		}
		
		$query = "SELECT ".static::fields_to_query() ."{$join_pre}  FROM ". static::$table_name ." as $class {$join_post} GROUP BY {$class}.id ORDER BY {$class}.id DESC";
		
		$results = $wpdb->get_results($query);	
		$data = array();
		if($results){
			foreach($results as $result){
				$data[] = new $class($result);
			}
		}
		return $data;
	}
}
?>