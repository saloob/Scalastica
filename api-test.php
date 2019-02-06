<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: api-test.php 
##########################################################
# case 'API TEST':

$url = "http://www.scalastica.com/api/v1/nw/1";
$response = file_get_contents($url);
echo $response;

# break; // End Activity
##########################################################
?>