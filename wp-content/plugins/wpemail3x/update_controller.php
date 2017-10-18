<?php
class UpdateController{
	public $plugin_location;
	public $slug;
	public $plugin_data;
	public $update_response;

	function UpdateController($plugin_location){
		$this->plugin_location = $plugin_location;
	}
	
	function init_data(){
		$this->slug = plugin_basename($this->plugin_location);
		$this->plugin_data = get_plugin_data($this->plugin_location);		
	}
	
	function set_plugin_info($false, $action, $response){
		$this->init_data();
		$this->get_release_info();

		if (!$response->slug || $response->slug != $this->slug ) {
		    return false;
		}
		$response->last_updated = (string) $this->update_response->published;
		$response->slug = $this->slug;
		$response->plugin_name  = $this->plugin_data["Name"];
		$response->name  = $this->plugin_data["Name"];		
		$response->version = (string) $this->update_response->version;
		$response->author = $this->plugin_data["AuthorName"];
		$response->homepage = $this->plugin_data["PluginURI"];
 		$response->download_link = (string)  $this->update_response->location;
		
		$response->sections = array(
		    'description' => $this->plugin_data["Description"],
		    'changelog' => (string) $this->update_response->release_notes
		);
		
		return $response;
	}
	
	function set_transient($transient){
		if (empty($transient->checked)){
		    return $transient;
		}
		
		$this->init_data();
		$this->get_release_info();

		$should_update = version_compare((float) $this->update_response->version, (float) $this->plugin_data["Version"]);
		
		if($should_update){
			$package = (string) $this->update_response->location;
			
			$transient_object = new stdClass();
			$transient_object->slug = $this->slug;
			$transient_object->new_version = (string) $this->update_response->version;
			$transient_object->url = $this->plugin_data["PluginURI"];
			$transient_object->package = $package;
			$transient_object->name = $this->plugin_data["Name"];
			$transient->response[$this->slug] = $transient_object;							
		}
		return $transient;
	}
	function get_release_info(){
		if(!empty($this->update_response)){
			return;
		}
		$remote = wp_remote_get($this->updater_url);
		$this->update_response = wp_remote_retrieve_body($remote);
		
		if($this->update_response){
			$this->update_response = simplexml_load_string($this->update_response);
		}
	}
}
?>