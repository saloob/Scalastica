<?php

if (!$_SESSION){
   session_start();
   }

require_once ('../config.php');

require_once ("../api-sugarcrm.php");

$db_host = $portal_config['dbconfig']['db_host_name'];
$db_name = $portal_config['dbconfig']['db_name'];
$db_user = $portal_config['dbconfig']['db_user_name'];
$db_pass = $portal_config['dbconfig']['db_password'];
	
$crm_wsdl_url = $portal_config['sugarconfig']['crm_wsdl_url'];
$crm_api_user = $portal_config['sugarconfig']['crm_api_user'];
$crm_api_pass = $portal_config['sugarconfig']['crm_api_pass'];

$crm_wsdl_url2 = $portal_config['sugarconfig']['crm_wsdl_url'];
$crm_api_user2 = $portal_config['sugarconfig']['crm_api_user'];
$crm_api_pass2 = $portal_config['sugarconfig']['crm_api_pass'];
	
$personal_targetmarket = $portal_config['targetmarkets']['personal'];
$business_targetmarket = $portal_config['targetmarkets']['business'];
$government_targetmarket = $portal_config['targetmarkets']['government'];

$config['baseurl'] = $portal_config['portalconfig']['baseurl'];
$config['base_url']             =   $portal_config['portalconfig']['baseurl'].'linkedin/auth.php';
$config['callback_url']         =   $portal_config['portalconfig']['baseurl'].'linkedin/auth2.php';
$config['linkedin_access']      =   $portal_config['linkedin']['apikey']; 
$config['linkedin_secret']      =   $portal_config['linkedin']['secret'];

include_once "linkedin.php";

# First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
$linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );
//$linkedin->debug = true;

if (isset($_REQUEST['oauth_verifier'])){

   $_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

   $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
   $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
   $linkedin->getAccessToken($_REQUEST['oauth_verifier']);

   $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
   header("Location: " . $config['callback_url']);
   exit;
   }
   else{
        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
   }


# You now have a $linkedin->access_token and can make calls on behalf of the current member
$xml_response = $linkedin->getProfile("~:(id,first-name,last-name,email-address,headline,picture-url)");

if ($xml_response != NULL){
   $person_array = new SimpleXMLElement($xml_response);
   }

foreach ($person_array as $key => $val) {

        if ($key == 'id'){
           $linkedin_id = $val;
           }
        if ($key == 'first-name'){
           $first_name = $val;
           }
        if ($key == 'last-name'){
           $last_name = $val;
           }
        if ($key == 'email-address'){
           $email_address = $val;
           }
        if ($key == 'headline'){
           $headline = $val;
           }
        if ($key == 'picture-url'){
           $picture_url = $val;
           }

        } // end for each

if ($linkedin_id != NULL){

   echo "<img src=".$picture_url."><P>ID: ".$linkedin_id."<BR>Name: ".$first_name." ".$last_name."<BR>Email: ".$email_address."<BR>Headline: ".$headline."<P>";

   $config['baseurl'] = $portal_config['portalconfig']['baseurl'];
   $portal_title = $portal_config['portalconfig']['portal_title'];
 
   $service_leadsources_id_c = $portal_config['linkedin']['linkedin_service_leadsources_id_c'];

   $sess_source_id = $_SESSION['source_id'];
   $sess_contact_id = $_SESSION['contact_id'];
   $sess_leadsources_id_c = $_SESSION['cmv_leadsources_id_c'];
   $sess_targetmarkets_id_c = $_SESSION['cmv_targetmarkets_id_c'];

   if ($sess_leadsources_id_c == NULL){

      $_SESSION['cmv_leadsources_id_c'] = $service_leadsources_id_c;
      $sess_leadsources_id_c = $_SESSION['cmv_leadsources_id_c'];

      }

   if ($sess_source_id != NULL && $sess_contact_id != NULL && $sess_leadsources_id_c != NULL ) {
      $access = TRUE;
      }

   ####################################
   # No Access

   if (!$access) {

      $object_type = "Contacts";
      $action = "contact_by_source";
      $params = array();
      $params[0] = $service_leadsources_id_c; // query
      $params[1] = $linkedin_id; // query source

      $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

      $count = $result['result_count'];

      if ($count >0 ){

         // There is a record of the LinkedIn uid with us

         $count = "";
  
         foreach ($result['entry_list'] as $gotten){

                 $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                 $contact_id =  $fieldarray['contact_id_c'];
                 $source_id =  $fieldarray['source_id'];
 
                 } 

         if ($contact_id != NULL){
  
            echo "Your LinkedIn Account ($linkedin_id) is registered with ".$portal_title." ($contact_id)<P>";
   
            $_SESSION["source_id"] = "$linkedin_id";
            $_SESSION["contact_id"] = "$contact_id";
            $_SESSION["cmv_leadsources_id_c"] = "$service_leadsources_id_c";  
   
            echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";
       
            }

         if ($contact_id == NULL && $source_id != NULL && $email_address != NULL){
   
            echo "Your LinkedIn Account has been registered with ".$portal_title." - but an account was not created, we will do so now...<P>";
            // The account wasn't created for some reason...

            echo "We will now check if your email (".$email_address.") exists with us with other services...<P>";
   
            $object_type = "Contacts";
            $action = "contact_by_email";
            $params = $email_address; // query

            $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
            $count = $result['result_count'];
   
            if ($count >0 ){
    
               foreach ($result['entry_list'] as $gotten){

                       $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                       $contact_id =  $fieldarray['id'];

                       } // end for each

               echo "Your LinkedIn Account email (".$email_address.") exists with us already - we will now link it to ".$portal_title."...<P>";
    
               $object_type = "Contacts";
               $action = "create_cmv_ContactsSources";
               $params = array();
               $params = array(
                   array('name'=>'name','value' => $first_name." ".$last_name." on ".$portal_title." via LinkedIn"),
                   array('name'=>'contact_id_c','value' => $contact_id),
                   array('name'=>'source_id','value' => "$linkedin_id"),
                   array('name'=>'cmv_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 

               $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
               echo "Your existing Account has now been linked to your LinkedIn account and ".$portal_title."...<P>";
    
               $_SESSION["source_id"] = "$linkedin_id";
               $_SESSION["contact_id"] = "$contact_id";
               $_SESSION["cmv_leadsources_id_c"] = "$service_leadsources_id_c";
    
               echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";

               } else {
               // Email doesn't exist - will create account

               $object_type = "Contacts";
               $action = "create";
               $params = array();
               $params = array(
                      array('name'=>'first_name','value' => $first_name),
                      array('name'=>'last_name','value' => $last_name),
                      array('name'=>'email1','value' => $email_address)
                      );   

               $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

               $contact_id = $result['id'];
               // Create cmv_ContactsSources entry - with new contact
    
               $object_type = "Contacts";
               $action = "create_cmv_ContactsSources";
               $params = array();
               $params = array(
                   array('name'=>'name','value' => $first_name." ".$last_name." on ".$portal_title." via LinkedIn"),
                   array('name'=>'contact_id_c','value' => $contact_id),
                   array('name'=>'source_id','value' => "$source_id"),
                   array('name'=>'cmv_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 

               $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
               echo "You have successfully linked your LinkedIn Account to ".$portal_title."...<P>Please go to your account to further edit your profile.<P>";
    
               $_SESSION["source_id"] = "$source_id";
               $_SESSION["contact_id"] = "$contact_id";
               $_SESSION["cmv_leadsources_id_c"] = "$service_leadsources_id_c";
    
               echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";

               } // end if no contact

            } // no contact but has source - rare occassion
   
         } else {
   
         // There is no record of the LinkedIn uid with us

         echo "Your LinkedIn Account is not yet registered with ".$portal_title." - we will now check if your email (".$email_address." & ID: ".$linkedin_id.") exists with us with other services...<P>";
   
         $object_type = "Contacts";
         $action = "contact_by_email";
         $params = $email_address; // query

         $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
         $count = $result['result_count'];
   
         if ($count >0 ){
    
            foreach ($result['entry_list'] as $gotten){

                    $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                    $contact_id =  $fieldarray['id'];

                    } // end for each

            echo "Your LinkedIn Account email (".$email_address.") exists with us so we will now link it to ".$portal_title."...<P>";
    
            $object_type = "Contacts";
            $action = "create_cmv_ContactsSources";
            $params = array();
            $params = array(
                   array('name'=>'name','value' => $first_name." ".$last_name." on ".$portal_title." via LinkedIn"),
                   array('name'=>'contact_id_c','value' => $contact_id),
                   array('name'=>'source_id','value' => "$linkedin_id"),
                   array('name'=>'cmv_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 

            $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
            echo "Your ".$portal_title." Account has now been linked to your LinkedIn account with ID (".$linkedin_id.").<P>";
    
            $_SESSION["source_id"] = "$linkedin_id";
            $_SESSION["contact_id"] = "$contact_id";
            $_SESSION["cmv_leadsources_id_c"] = "$service_leadsources_id_c";
    
            echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";
        
            } else {// is count by email 
    
            // Assume this is not in our DB for anything - and create new completely
            // User doesn't exist by email - create new contact
            $object_type = "Contacts";
            $action = "create";
            $params = array();
            $params = array(
                      array('name'=>'first_name','value' => $first_name),
                      array('name'=>'last_name','value' => $last_name),
                      array('name'=>'email1','value' => $email_address) 
                      );   

            $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

            $contact_id = $result['id'];
            // Create cmv_ContactsSources entry - with existing contact
    
            $object_type = "Contacts";
            $action = "create_cmv_ContactsSources";
            $params = array();
            $params = array(
                   array('name'=>'name','value' => $first_name." ".$last_name." on ".$portal_title." via LinkedIn"),
                   array('name'=>'contact_id_c','value' => $contact_id),
                   array('name'=>'source_id','value' => "$linkedin_id"),
                   array('name'=>'cmv_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 

            $result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
            echo "You have successfully linked your LinkedIn Account to ".$portal_title."...<P>";
    
            $_SESSION["source_id"] = "$linkedin_id";
            $_SESSION["contact_id"] = "$contact_id";
            $_SESSION["cmv_leadsources_id_c"] = "$service_leadsources_id_c";
    
            echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";
    
            } // end creating new source and contact
   
         } // end if not in DB

      } else {

      // Has Access
      echo "You have already linked your LinkedIn Account to ".$portal_title."...<P>";
      echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";

      }

   } else {

   // No LinkedIn Array returned

   echo "Sorry, there was a problem retrieving your LinkedIn details - please try again.<P>";
   echo "<a href=".$config['baseurl']." target=_parent>Click here</a> to continue...";

   } // is array

?>