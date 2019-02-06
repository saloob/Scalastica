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
# Data sent from register.php - to use SOAP to register in CRM

$crm_wsdl_url = 'http://www.saloob.jp/crm/soap.php?wsdl';
$crm_api_user = 'matt@saloob.com';
$crm_api_pass = 'zacross1972';

if (!function_exists('api_sugar')){
   include ("../api-sugarcrm.php");
	}

####################################################################
# Collect Core Data to create Contact
	
$source_c = "Facebook - YourCMV";
$cmv_leadsources_id_c = "85b88fa2-1f14-4042-5f2d-4c96a93c941e";
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$source_id = $_POST['source_id'];
$email = $_POST['email'];
$gender = $_POST['gender'];
$locale = $_POST['locale'];

if ($email == NULL){
	
	echo "An Email Address is required to register with YourCMV - please <a href=http://apps.facebook.com/yourcmv/ target=_parent><B>click here to return</B></a><P>";
	exit;

	} else {

	echo "First Name: ".$first_name."<BR>";
	echo "Last Name: ".$last_name."<BR>";
	//	echo "ID:".$source_id_c."<BR>";
	echo "Email: ".$email."<BR>";
	//echo "GE:".$gender."<BR>";
	//echo "LO:".$locale."<BR>";

	// First check if the email exists;
	$object_type = "contacts";
	$action = "contact_by_email";
	$params = $email; // query

	$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

	foreach ($result['entry_list'] as $gotten){

			$fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);   	
			$id =  $fieldarray['id'];

			} // end for each

//    var_dump($result);
//    echo "<BR>ID:".$id."<BR>";
			
	if ($id != NULL){
				
   	// User exists by email - just update the contact with their ID and source

//		echo "does exist<BR>";
//		echo "ID:".$id."<BR>";
//		echo "source_id:".$source_id."<BR>";

/*		
		$object_type = "relationships";
		$action = "set_modules";
		$params[0] = "cmv_LeadSources";
		$params[1] = $cmv_leadsources_id_c;
		$params[2] = "Contacts";
		$params[3] = $id;		
		
		$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

		var_dump($result);
*/
		// Create cmv_ContactsSources entry - with existing contact
				
		$object_type = "contacts";
		$action = "create_cmv_ContactsSources";
		$params = array(
                            array('name'=>'name','value' => $first_name." from Facebook MyCMV"),
                            array('name'=>'contact_id_c','value' => $id),
                            array('name'=>'source_id','value' => $source_id),
                            array('name'=>'cmv_leadsources_id_c','value' => $cmv_leadsources_id_c) 
                            );	

		$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

//		var_dump($result);
	
   	} else {
   		
//echo "<P>Doesn't exist - create contact<BR>";
   		
	    // User doesn't exist by email - create new contact
		$object_type = "contacts";
		$action = "create";
		$params = array(
                            array('name'=>'first_name','value' => $first_name),
                            array('name'=>'last_name','value' => $last_name),
                            array('name'=>'email1','value' => $email) 
                            );			

		$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

		$contact_id = $result['id'];

//var_dump($result);
//echo "<P>Contact ID: ".$contact_id."<P>";

/*
		$object_type = "relationships";
		$action = "set_modules";
		$params[0] = "cmv_LeadSources";
		$params[1] = $cmv_leadsources_id_c;
		$params[2] = "Contacts";
		$params[3] = $contact_id;		
*/
		// Create cmv_ContactsSources entry - with existing contact
				
		$object_type = "contacts";
		$action = "create_cmv_ContactsSources";
		$params = array(
                            array('name'=>'name','value' => $first_name." from Facebook MyCMV"),
                            array('name'=>'contact_id_c','value' => $contact_id),
                            array('name'=>'source_id','value' => $source_id),
                            array('name'=>'cmv_leadsources_id_c','value' => $cmv_leadsources_id_c) 
                            );	

		$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

//		var_dump($result);
				
   	} // end else	if id by email doesn't exist

   	// By this stage the user should have been added or ID updated if they already existed

	echo "<BR><center>Thank you for confirming your details for MyCMV - please <a href=http://apps.facebook.com/yourcmv/ target=_parent><B>click here to enter YourCMV</B></a><P>";

	} // end if email exists
?>