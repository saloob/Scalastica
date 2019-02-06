<?php
require_once 'SerializeManager.php';
if(!isset($serialized_by_manager_data)){
	$serialized_by_manager_data = get_object_vars($this);
}
$serialized = SerializeManager::instance()->serializeVars($this, $serialized_by_manager_data);
?>