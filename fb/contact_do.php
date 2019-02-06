<?php 
####################################################################
# MyCMV Synch API
# To connect to and receive data for added-value services
# Saloob, Inc. All rights reserved 2010+
# Author: Matthew Edmond
# Date: 2010-09-20
# URL: http://www.saloob.com
# Email: sales@saloob.com
####################################################################
# Data sent from contact.php - to use SOAP to update in CRM

if (!$_SESSION){
    session_start();
}

$crm_wsdl_url = 'http://www.saloob.jp/crm/soap.php?wsdl';
$crm_api_user = 'matt@saloob.com';
$crm_api_pass = 'zacross1972';

if (!function_exists('api_sugar')){
   include ("../api-sugarcrm.php");
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$source_id_c = $_POST['source_id_c'];
$email = $_POST['email'];

echo "FN:".$first_name."<BR>";
echo "LN:".$last_name."<BR>";
echo "ID:".$source_id_c."<BR>";
echo "EM:".$email."<BR>";

/*

	// Auto-create using SOAP
	$object_type = "contacts";
	$action = "contact_by_source";
	$params[0] = "Facebook - MyCMV"; // query
	$params[1] = $source_id_c; // query
	$params[2] = $first_name; // query
	$params[3] = $last_name; // query
	$params[4] = $email; // query
		
	$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
*/



?>