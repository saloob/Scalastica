<?php
require_once 'SerializeManager.php';
if(isset($this->__unserialized_data__) && is_array($this->__unserialized_data__)){
	SerializeManager::instance()
	 ->replaceUnserializedObjects($this->__unserialized_data__);
	foreach($this->__unserialized_data__ as $key=>$value){
	  $this->$key = $value;
	}
	unset($this->__unserialized_data__);
}
?>