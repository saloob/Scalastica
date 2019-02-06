<?php
require_once 'SerializeManager.php';
$this->__unserialized_data__ = SerializeManager::instance()->unserializeVars($this, $serialized);
?>