<?php
##################################
# Start Scalastica
##################################
# Convert Name/Values

if (!$_SESSION){
 session_start();
 }

if (!function_exists('nameValuePairToSimpleArray')){

function nameValuePairToSimpleArray($array){
    $my_array=array();
    while(list($name,$value)=each($array)){
        $my_array[$value['name']]=$value['value'];
    }
    return $my_array;
}

}

# End Convert Name/Values
##################################
# SugarCRM SOAP Session

function sugarsession ($api_user, $api_pass, $crm_wsdl_url){

 require_once ("nusoap/nusoap.php");
 
// $sugar_sessioner = $_SESSION["sugarsoapsessionid"];
// $date = date("Y-m-d G:i:s");

 //echo "User: ".$api_user."<P>";

/*

    user_auth: tns:user_auth
    application_name: xsd:string

*/

//    $soapclient = new SoapClient($crm_wsdl_url); // create a PHP SOAP object that uses SUGAR WSDL definitions in remote soap.php file
    
    // setup parameters to send to function through the SOAP object
/*
    $user_auth = array( 
        'user_name' => $api_user, 
        'password' => md5($api_pass),
        'version' => $soapclient->get_server_version()
    );

    $application = "RealPolitika.org";
*/

    // call SUGAR WSDL login function as method of PHP SOAP object


 $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass), 'version' => '0.1'),'Scalastica');
// $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass)));
// $auth_array = array ('user_name' => $api_user, 'password' => md5($api_pass));

 $soapclient = new nusoap_client($crm_wsdl_url);
 #$soapclient->soap_defencoding = 'UTF-8';
 #$soapclient->decode_utf8 = false;

 $login_results = $soapclient->call('login',$auth_array);
 $sugar_session_id = $login_results['id'];

 //$soapclient->debug_flag=true
 //$soapclient->decodeUTF8(false);
/*

 if ($sugar_sessioner == NULL){

  $login_results = $soapclient->call('login',$auth_array,'RealPolitika.org');

//var_dump($login_results);

  $sugar_session_id = $login_results['id'];

  $sugar_sessioner = $sugar_session_id."[]".$date;
  $_SESSION["sugarsoapsessionid"] = $sugar_sessioner;
  //echo $sugar_sessioner;
  } else {
  //echo "SESSIONER: ".$sugar_sessioner."<BR>";
  // Session will expire - give ourselves time limit of say 15 mins
  $thisminutes = date("i");

  list($sugar_session_id,$createdtime) = explode('[]',$sugar_sessioner);
  // Must check session timeout
  if ($createdtime == NULL){
   $checktime = 100;
   } else {
   list ($datep1, $datep2) = explode (" ", $createdtime);
   list ($hours, $minutes, $seconds) = explode (":", $datep2);
   $checktime = $minutes+15;
   if ($checktime>60){
    $checktime = $checktime-60;
    }
   } // end if not null

  if (($checktime>($thisminutes+14)) || (($thisminutes-16)<$checktime)){

   $login_results = $soapclient->call('login',$auth_array,'RealPolitika.org');
   $sugar_session_id = $login_results['id'];
   $sugar_sessioner = $sugar_session_id."[]".$date;
   $_SESSION["sugarsoapsessionid"] = $sugar_sessioner;

   } else {
   // All sweet
   list($sugar_session_id, $createdtime) = explode('[]',$sugar_sessioner);
   //echo "SESS: ".$sugar_session_id."<BR>";
   }

  } // end if has session
*/

 $soapreturn = array();
 $soapreturn[0] = $soapclient;
 $soapreturn[1] = $sugar_session_id;
 
 return $soapreturn;  

 } // end sugarsession function

# End sessioner
##################################
# Core Function

function api_sugar ($api_user, $api_pass, $api_url, $object_type, $action, $params){

global $lingos, $lingo, $strings, $crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $funky_gear;

  if (!$lingo){
      $lingo = "en";
      }
  if (!$lingoname){
     $lingoname = "name_".$lingo;
     }


// Select db or SOAP

//echo "Sugar 1<BR>";

if ($api_user != NULL){
 
   define('sugarEntry', TRUE);  

   // Provide for non-SOAP access - SLOOOOW
   $sessiontype = "soap";

   // Set up session with timeout check
   $soaper = sugarsession ($api_user, $api_pass, $api_url);
   $soapclient = $soaper[0];
   $sugar_session_id = $soaper[1];
 
   } else {
    
   global $db,$db_name,$db_user,$db_pass,$db_host;

   $sessiontype = "db";

   }
 
# End Database Initialise
#####################################################
# Begin switch

$returnpack = "";

switch ($object_type){
  
 ###############################################
 case 'Accounts':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM accounts $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['account_type'] = $the_row['account_type'];
           $returnpack[$cnt]['industry'] = $the_row['industry'];
           $returnpack[$cnt]['annual_revenue'] = $the_row['annual_revenue'];
           $returnpack[$cnt]['phone_fax'] = $the_row['phone_fax'];
           $returnpack[$cnt]['billing_address_street'] = $the_row['billing_address_street'];
           $returnpack[$cnt]['billing_address_city'] = $the_row['billing_address_city'];
           $returnpack[$cnt]['billing_address_state'] = $the_row['billing_address_state'];
           $returnpack[$cnt]['billing_address_postalcode'] = $the_row['billing_address_postalcode'];
           $returnpack[$cnt]['billing_address_country'] = $the_row['billing_address_country'];
           $returnpack[$cnt]['rating'] = $the_row['rating'];
           $returnpack[$cnt]['phone_office'] = $the_row['phone_office'];
           $returnpack[$cnt]['phone_alternate'] = $the_row['phone_alternate'];
           $returnpack[$cnt]['website'] = $the_row['website'];
           $returnpack[$cnt]['ownership'] = $the_row['ownership'];
           $returnpack[$cnt]['employees'] = $the_row['employees'];
           $returnpack[$cnt]['ticker_symbol'] = $the_row['ticker_symbol'];
           $returnpack[$cnt]['shipping_address_street'] = $the_row['shipping_address_street'];
           $returnpack[$cnt]['shipping_address_city'] = $the_row['shipping_address_city'];
           $returnpack[$cnt]['shipping_address_state'] = $the_row['shipping_address_state'];
           $returnpack[$cnt]['shipping_address_postalcode'] = $the_row['shipping_address_postalcode'];
           $returnpack[$cnt]['shipping_address_country'] = $the_row['shipping_address_country'];
           $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
           $returnpack[$cnt]['sic_code'] = $the_row['sic_code'];
           $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];

           $cnt++;

          }

   break;
   case 'select_cstm':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM accounts_cstm $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id_c'] = $the_row['id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['status_c'] = $the_row['status_c'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['email_system_c'] = $the_row['email_system_c'];
           $returnpack[$cnt]['industry_id_c'] = $the_row['industry_id_c'];
           $returnpack[$cnt]['category_id_c'] = $the_row['category_id_c'];
           $returnpack[$cnt]['image_c'] = $the_row['image_c'];

           $cnt++;

          }

   break;
   case 'select_soap':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = array();
       $group = "";
       $order = "";
       $limit = "";
       }
 
    $offset = 0;
       
    $result = $soapclient->call('get_entry_list',array(
'session'=>$sugar_session_id,
'module_name'=>'Accounts',
'query'=>$query,
'order_by'=>$order,
'offset'=>$offset,
'select_fields'=>$select,
'max_results'=>$limit,
'deleted'=>'0',
));
        
    //var_dump($result);

//    $gotten = $soapclient->response;
    $cnt = 0;
    foreach ($result['entry_list'] as $gotten){

          $the_row = nameValuePairToSimpleArray($gotten['name_value_list']);
     
           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['account_type'] = $the_row['account_type'];
           $returnpack[$cnt]['industry'] = $the_row['industry'];
           $returnpack[$cnt]['annual_revenue'] = $the_row['annual_revenue'];
           $returnpack[$cnt]['phone_fax'] = $the_row['phone_fax'];
           $returnpack[$cnt]['billing_address_street'] = $the_row['billing_address_street'];
           $returnpack[$cnt]['billing_address_city'] = $the_row['billing_address_city'];
           $returnpack[$cnt]['billing_address_state'] = $the_row['billing_address_state'];
           $returnpack[$cnt]['billing_address_postalcode'] = $the_row['billing_address_postalcode'];
           $returnpack[$cnt]['billing_address_country'] = $the_row['billing_address_country'];
           $returnpack[$cnt]['rating'] = $the_row['rating'];
           $returnpack[$cnt]['phone_office'] = $the_row['phone_office'];
           $returnpack[$cnt]['phone_alternate'] = $the_row['phone_alternate'];
           $returnpack[$cnt]['website'] = $the_row['website'];
           $returnpack[$cnt]['ownership'] = $the_row['ownership'];
           $returnpack[$cnt]['employees'] = $the_row['employees'];
           $returnpack[$cnt]['ticker_symbol'] = $the_row['ticker_symbol'];
           $returnpack[$cnt]['shipping_address_street'] = $the_row['shipping_address_street'];
           $returnpack[$cnt]['shipping_address_city'] = $the_row['shipping_address_city'];
           $returnpack[$cnt]['shipping_address_state'] = $the_row['shipping_address_state'];
           $returnpack[$cnt]['shipping_address_postalcode'] = $the_row['shipping_address_postalcode'];
           $returnpack[$cnt]['shipping_address_country'] = $the_row['shipping_address_country'];
           $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
           $returnpack[$cnt]['sic_code'] = $the_row['sic_code'];
           $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];
           $returnpack[$cnt]['cmv_statuses_id_c'] = $the_row['cmv_statuses_id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['email_system_c'] = $the_row['email_system_c'];
           $returnpack[$cnt]['industry_id_c'] = $the_row['industry_id_c'];
           $returnpack[$cnt]['category_id_c'] = $the_row['category_id_c'];

          $cnt++;

          } // end foreach

   break;
   case 'select_contacts':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM accounts_contacts $query $group $order $limit";

     $contacts_db = new DB_Sql();
     $contacts_db->Database = DATABASE_NAME;
     $contacts_db->User     = DATABASE_USER;
     $contacts_db->Password = DATABASE_PASSWORD;
     $contacts_db->Host     = DATABASE_HOST;
     
     $the_list = $contacts_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           //$returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['contact_id'] = $the_row['contact_id'];
           $returnpack[$cnt]['account_id'] = $the_row['account_id'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];

//           $contact_object_type = "Contacts";
//           $contact_action = "contact_by_id";
//           $contact_params = $the_row['contact_id'];

           if ($the_row['contact_id'] != NULL){
              $returnpack[$cnt]['first_name'] = dlookup("contacts", "first_name", "id='".$the_row['contact_id']."'");
              $returnpack[$cnt]['last_name'] = dlookup("contacts", "last_name", "id='".$the_row['contact_id']."'");
              $returnpack[$cnt]['profile_photo_c'] = dlookup("contacts_cstm", "profile_photo_c", "id_c='".$the_row['contact_id']."'");
              }
/*
           $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
        
           foreach ($contact_info['entry_list'] as $gotten){

                   $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);
                   //$returnpack[$cnt]['id'] = $fieldarray['id'];
                   $returnpack[$cnt]['first_name'] = $fieldarray['first_name'];
                   $returnpack[$cnt]['last_name'] = $fieldarray['last_name'];
                 
                   } // end for each
*/
           $cnt++;

          }

   break;
   case 'create':
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'Accounts',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end Accounts
 ###############################################
 case 'AccountsConfigurationItems':
 
  switch ($action){
  
   case 'select':
    
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = " WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM sclm_accountsconfigurationitems $query $group $order $limit";

   $the_list = $db->query($final_query);

   $cnt = 0;
  
   while ($the_row = mysql_fetch_array ($the_list)){
         $returnpack[$cnt]['id'] = $the_row['id'];
         $returnpack[$cnt]['name'] = $the_row['name'];
         $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
         $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];    
         $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
         $returnpack[$cnt]['created_by'] = $the_row['created_by'];
         $returnpack[$cnt]['description'] = $the_row['description'];
         $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
         $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
         $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
         $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
         $returnpack[$cnt]['sclm_configurationitems_id_ic'] = $the_row['sclm_configurationitems_id_ic'];

         $cnt++;

         } // end while
       
   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_AccountsConfigurationItems',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;
 
   } // end Action switch
 
 break; // end AccountsConfigurationItems
 ###############################################
 case 'AccountRelationships':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM sclm_accountrelationships $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['effect_date'] = $the_row['effect_date'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['parent_account_id'] = $the_row['account_id_c'];
           $returnpack[$cnt]['parent_account_name'] = dlookup("accounts", "name", "id='".$the_row['account_id_c']."'");
           $returnpack[$cnt]['child_account_id'] = $the_row['account_id1_c'];
           $returnpack[$cnt]['child_account_name'] = dlookup("accounts", "name", "id='".$the_row['account_id1_c']."'");
           $returnpack[$cnt]['entity_type'] = $the_row['entity_type'];

           if ($returnpack[$cnt]['entity_type']){
              $ci_type_id = dlookup("sclm_configurationitems", "sclm_configurationitemtypes_id_c", "id='".$returnpack[$cnt]['entity_type']."'");
              $returnpack[$cnt]['ci_type_id'] = $ci_type_id;
              }

           if ($ci_type_id){
              $ci_data_type = dlookup("sclm_configurationitemtypes", "ci_data_type", "id='".$ci_type_id."'");
              $returnpack[$cnt]['ci_data_type'] = $ci_data_type;
              }

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_AccountRelationships',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end AccountRelationships
 ###############################################
 case 'AccountsServices':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_accountsservices $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          $returnpack[$cnt]['sclm_accountsservices_id_c'] = $the_row['sclm_accountsservices_id_c'];

          if ($returnpack[$cnt]['sclm_services_id_c']){
             $returnpack[$cnt]['service_name'] = dlookup("sclm_services", "name", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
             $returnpack[$cnt]['service_type'] = dlookup("sclm_services", "service_type", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
             $returnpack[$cnt]['market_value'] = dlookup("sclm_services", "market_value", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
             $returnpack[$cnt]['service_account_id_c'] = dlookup("sclm_services", "account_id_c", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
             $returnpack[$cnt]['service_contact_id_c'] = dlookup("sclm_services", "contact_id_c", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
             $returnpack[$cnt]['service_tier'] = dlookup("sclm_services", "service_tier", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");

             $returnpack[$cnt]['parent_service_type'] = dlookup("sclm_services", "parent_service_type", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");

             if ($returnpack[$cnt]['service_tier']){
                $service_tier_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_tier']."'");
                $returnpack[$cnt]['service_tier_name'] = $service_tier_name;
                }

             if ($returnpack[$cnt]['service_type']){
                $service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_type']."'");
                $returnpack[$cnt]['service_type_name'] = $service_type_name;
                }

             if ($returnpack[$cnt]['parent_service_type']){
                $parent_service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['parent_service_type']."'");
                $returnpack[$cnt]['parent_service_type_name'] = $parent_service_type_name;
                }

             } # if sclm_services_id_c

          if ($the_row['image'] == NULL){
             if ($returnpack[$cnt]['sclm_services_id_c']){
                $returnpack[$cnt]['image'] = dlookup("sclm_services", "image", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
                }
             } else {
             $returnpack[$cnt]['image'] = $the_row['image'];
             } 

          $returnpack[$cnt]['lifestyle_category'] = $the_row['lifestyle_category'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_AccountsServices',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end AccountsServices
 ###############################################
 case 'AccountsServicesSLAs':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_accountsservicesslas $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
          $returnpack[$cnt]['sclm_servicessla_id_c'] = $the_row['sclm_servicessla_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          $returnpack[$cnt]['sclm_accountsservices_id_c'] = $the_row['sclm_accountsservices_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_AccountsServicesSLAs',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end AccountsServicesSLAs
 ###############################################
 case 'Actions':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM sfx_actions $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['effect_date'] = $the_row['effect_date'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['sfx_externalsources_id_c'] = $the_row['sfx_externalsources_id_c'];

           $returnpack[$cnt]['sfx_sourceobjects_id_c'] = $the_row['sfx_sourceobjects_id_c'];
           if ($the_row['sfx_sourceobjects_id_c'] != NULL){
              $sfx_sourceobjects_id_c = $the_row['sfx_sourceobjects_id_c'];
              $sourceobject = dlookup("sfx_sourceobjects", "name", "id='".$sfx_sourceobjects_id_c."'");
              $returnpack[$cnt]['sourceobject'] = $sourceobject;
              }

           $returnpack[$cnt]['object_id'] = $the_row['object_id'];

           $returnpack[$cnt]['sfx_purposes_id_c'] = $the_row['sfx_purposes_id_c'];
           if ($the_row['sfx_purposes_id_c'] != NULL){
              $sfx_purposes_id_c = $the_row['sfx_purposes_id_c'];
              $purpose = dlookup("sfx_purposes", "name", "id='".$sfx_purposes_id_c."'");
              $returnpack[$cnt]['purpose'] = $purpose; 
              }

           $returnpack[$cnt]['sfx_emotions_id_c'] = $the_row['sfx_emotions_id_c'];
           if ($the_row['sfx_emotions_id_c'] != NULL){
              $sfx_emotions_id_c = $the_row['sfx_emotions_id_c'];
              $emotion = dlookup("sfx_emotions", "name", "id='".$sfx_emotions_id_c."'");
              $returnpack[$cnt]['emotion'] = $emotion; 
              }

           $returnpack[$cnt]['external_url'] = $the_row['external_url'];

           $contact_id_c = $the_row['contact_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $contact_id_c;
           $returnpack[$cnt]['cmv_statuses_id_c'] = $the_row['cmv_statuses_id_c'];

           $cmv_statuses_id_c = $the_row['cmv_statuses_id_c'];

           if (($cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' || $cmv_statuses_id_c != 'dfc905da-7434-7375-86fd-4d48ff743f78') && $the_row['contact_id_c'] != NULL){
              $first_name = dlookup("contacts", "first_name", "id='".$contact_id_c."'");
              $last_name = dlookup("contacts", "last_name", "id='".$contact_id_c."'");
              $returnpack[$cnt]['contact_name'] = $first_name." ".$last_name;
              } else {
              $returnpack[$cnt]['contact_name'] = $strings["AnonymousUser"];
              } 

           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['view_count'] = $the_row['view_count'];

           $returnpack[$cnt]['sfx_sibaseunits_id_c'] = $the_row['sfx_sibaseunits_id_c'];
           $returnpack[$cnt]['sfx_time_id_c'] = $the_row['sfx_time_id_c'];
           if ($the_row['sfx_time_id_c'] != NULL){
              $sfx_time_id_c = $the_row['sfx_time_id_c'];
              $time = dlookup("sfx_time", "name", "id='".$sfx_time_id_c."'");
              $returnpack[$cnt]['time'] = $time; 
              }

           $returnpack[$cnt]['cmv_newscategories_id_c'] = $the_row['cmv_newscategories_id_c'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_Actions',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end Actions
 ###############################################
 case 'ActionsContacts':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM sfx_actions_contacts_c $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['sfx_actions_contactssfx_actions_ida'] = $the_row['sfx_actions_contactssfx_actions_ida'];
           $returnpack[$cnt]['sfx_actions_contactscontacts_idb'] = $the_row['sfx_actions_contactscontacts_idb'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_ActionsContacts',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end ActionsContacts
 ###############################################
 case 'Administrators':

  switch ($action){

   case 'select_contacts':
    
    if (is_array($params)){
      
      $sess_contact_id = $params[0];
      $value_type = $params[1];
      $value_id = $params[2];
      
      }

//echo "VALTYPE: ".$value_type."<P>";
//echo "VAL: ".$value_id."<P>";

     switch ($value_type){
   
      case 'Governments':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_governments_id_c='".$value_id."'");
       
      break;
      case 'PoliticalParties':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_politicalparties_id_c='".$value_id."'");
       
      break;
      case 'Organisations':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_organisations_id_c='".$value_id."'");
       
      break;
      
     } // end switch type for admin
     
     if ($administrators_id){
        
//echo "Admini* ".$administrators_id."<P>";

      $query = "SELECT * FROM cmv_administrators_contacts_c WHERE cmv_administrators_contactscmv_administrators_ida='".$administrators_id."' && deleted=0";

      $admini_db = new DB_Sql();
      $admini_db->Database = DATABASE_NAME;
      $admini_db->User     = DATABASE_USER;
      $admini_db->Password = DATABASE_PASSWORD;
      $admini_db->Host     = DATABASE_HOST;
      
      $the_list = $admini_db->query($query);

      // get contacts based on admin settings
      
      $cnt=0;
      while ($the_row = mysql_fetch_array ($the_list)){

        $cmv_administrators_contactscontacts_idb = $the_row['cmv_administrators_contactscontacts_idb'];
        
        //echo "ADMIN: ".$cmv_administrators_contactscontacts_idb."<P>";
        
        $admin_object_type = "Contacts";
        $admin_action = "contact_by_id";
        $admin_params = $cmv_administrators_contactscontacts_idb;

        $admin_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $admin_object_type, $admin_action, $admin_params);
        
        //var_dump($admin_info);
        
        foreach ($admin_info['entry_list'] as $gotten){

         $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
         
         $returnpack[$cnt]['id'] = $fieldarray['id'];
         $returnpack[$cnt]['fn'] = $fieldarray['first_name'];
         $returnpack[$cnt]['ln'] = $fieldarray['last_name'];
         //$dd_pack[$cmv_adminisors_contacts_c] = $fn." ".$ln;
         //echo "ADMIN: ".$fieldarray['first_name']."<P>";
                 
         } // end for each

         $cnt++;
         
        } // end while        
        
      } // end if admin
                        
    break; // end select_contacts
    case 'select':
    
     if (is_array($params)){
      
      $sess_contact_id = $params[0];
      $value_type = $params[1];
      $value_id = $params[2];
      
      }
      
     switch ($value_type){
   
      case 'Governments':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_governments_id_c='".$value_id."'");
       
      break;
      case 'PoliticalParties':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_politicalparties_id_c='".$value_id."'");
       
      break;
      case 'Organisations':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_organisations_id_c='".$value_id."'");
       
      break;
      
     } // end switch type for admin
     
     if ($administrators_id){
        
      $the_list = $db->query("SELECT * FROM cmv_administrators WHERE id='".$administrators_id."'");

      while ($the_row = mysql_fetch_array ($the_list)){

        $returnpack['id'] = $the_row['id'];
        $returnpack['name'] = $the_row['name'];
        $returnpack['date_entered'] = $the_row['date_entered'];
        $returnpack['date_modified'] = $the_row['date_modified'];    
        $returnpack['modified_user_id'] = $the_row['modified_user_id'];
        $returnpack['created_by'] = $the_row['created_by'];
        $returnpack['description'] = $the_row['description'];
        $returnpack['assigned_user_id'] = $the_row['assigned_user_id'];
        $returnpack['cmv_politicalparties_id_c'] = $the_row['cmv_politicalparties_id_c'];
        $returnpack['contact_id_c'] = $the_row['contact_id_c']; // first, core admini
        $returnpack['access_level'] = $the_row['access_level']; // added users level
        $returnpack['cmv_governments_id_c'] = $the_row['cmv_governments_id_c']; // if gov
        $returnpack['cmv_governmentconstitutions_id_c'] = $the_row['cmv_governmentconstitutions_id_c']; // if constitution
        $returnpack['allow_joiner_requests'] = $the_row['allow_joiner_requests']; //allow
        
        // get contacts within

        } // end while        
        
      } // end if admin
                   
    break; // end select
    case 'check_admin':

     if (is_array($params)){
      
      $sess_contact_id = $params[0];
      $value_type = $params[1];
      $value_id = $params[2];
      
      }
      
     switch ($value_type){
   
      case 'Governments':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_governments_id_c='".$value_id."'");
       
      break;
      case 'PoliticalParties':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_politicalparties_id_c='".$value_id."'");
       
      break;
      case 'Organisations':
   
       $administrators_id = dlookup("cmv_administrators", "id", "cmv_organisations_id_c='".$value_id."'");
       
      break;

     }
   
     $returnpack['current_contact_status'] = FALSE;
     $returnpack['allow_joiner_requests'] = FALSE;
       
     if ($administrators_id){
 
        $contact_id_c = dlookup("cmv_administrators", "contact_id_c", "id='".$administrators_id."'");
        $access_level = dlookup("cmv_administrators", "access_level", "id='".$administrators_id."'");
        $returnpack['contact_id_c'] = $contact_id_c;
        $returnpack['access_level'] = $access_level;

        $cmv_governments_id_c = dlookup("cmv_administrators", "cmv_governments_id_c", "id='".$administrators_id."'");       
        $allow_joiner_requests  = dlookup("cmv_administrators", "allow_joiner_requests", "id='".$administrators_id."'");
        $pparty_id = dlookup("cmv_administrators", "cmv_politicalparties_id_c",  "id='".$administrators_id."'");
        $constitution_id = dlookup("cmv_administrators", "cmv_governmentconstitutions_id_c",  "id='".$administrators_id."'");
        $organisation_id = dlookup("cmv_administrators", "cmv_organisations_id_c",  "id='".$administrators_id."'");

        if ($organisation_id){
           $returnpack['organisation_id'] = $organisation_id;
           }

        if ($pparty_id){
           $returnpack['political_party_id'] = $pparty_id;
           }

        if ($constitution_id){
           $returnpack['constitution_id'] = $constitution_id;
           }

        if ($cmv_governments_id_c){
           $returnpack['government_id'] = $cmv_governments_id_c;
           }

        
        if ($allow_joiner_requests == 1){
           $returnpack['allow_joiner_requests'] = TRUE;
           }
     
        $the_list = $db->query("SELECT * FROM cmv_administrators_contacts_c WHERE cmv_administrators_contactscmv_administrators_ida='".$administrators_id."' && deleted=0");

        $cnt = 0;
        while ($the_row = mysql_fetch_array ($the_list)){

              $admin_contact_id = $the_row['cmv_administrators_contactscontacts_idb'];
          
              if ($admin_contact_id == $sess_contact_id || $contact_id_c == $sess_contact_id){
                 $returnpack['current_contact_status'] = TRUE;
                 }

               $cnt++;
   
              } // end while
     
           // Check for the contacts related to this admin set
  
       } // end if admin
       
   break; // end check_admin
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_Administrators',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;
   case 'update_contacts':



   break; 
  } // end Action switch
  
 break;
 ###############################################
 case 'Advisory':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM sclm_advisory $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['summary'] = $the_row['summary'];
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
           $returnpack[$cnt]['cmn_industries_id_c'] = $the_row['cmn_industries_id_c'];

           if ($returnpack[$cnt]['cmn_industries_id_c']){
              $returnpack[$cnt]['cmn_industries_name'] = dlookup("cmn_industries", "name", "id='".$returnpack[$cnt]['cmn_industries_id_c']."'");
              $returnpack[$cnt]['parent_industry_id'] = dlookup("cmn_industries", "cmn_industries_id_c", "id='".$returnpack[$cnt]['cmn_industries_id_c']."'");
              $returnpack[$cnt]['parent_industry_name'] = dlookup("cmn_industries", "name", "id='".$returnpack[$cnt]['parent_industry_id']."'");
              }

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Advisory',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end Advisory
 ###############################################
 case 'Comments':
 
  switch ($action){
  
   case 'select':
    
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM cmv_comments $query $group $order $limit";

     $comments_db = new DB_Sql();
     $comments_db->Database = DATABASE_NAME;
     $comments_db->User     = DATABASE_USER;
     $comments_db->Password = DATABASE_PASSWORD;
     $comments_db->Host     = DATABASE_HOST;
     
     $cnt = 0;     
      
     $comm_list = $comments_db->query($final_query);
       
     while ($comm_row = mysql_fetch_array ($comm_list)){

          $returnpack[$cnt]['id'] = $comm_row['id'];
          $returnpack[$cnt]['name'] = $comm_row['name'];
          $returnpack[$cnt]['date_entered'] = $comm_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $comm_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $comm_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $comm_row['created_by'];
          $returnpack[$cnt]['description'] = $comm_row['description'];
          $returnpack[$cnt]['deleted'] = $comm_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $comm_row['assigned_user_id'];
          $returnpack[$cnt]['language_id'] = $comm_row['cmn_languages_id_c'];
          $returnpack[$cnt]['cmv_statuses_id_c'] = $comm_row['cmv_statuses_id_c'];

          $contact_id_c = $comm_row['contact_id_c'];
          if ($contact_id_c != NULL){
           $returnpack[$cnt]['contact_id_c'] = $comm_row['contact_id_c'];
           $first_name = dlookup("contacts", "first_name", "id='".$contact_id_c."'");
           $last_name = dlookup("contacts", "last_name", "id='".$contact_id_c."'");
           $returnpack[$cnt]['first_name'] = $first_name;
           $returnpack[$cnt]['last_name'] = $last_name;
           } // end if contact

          $returnpack[$cnt]['saloob_tv_media_type'] = $comm_row['saloob_tv_media_type'];
          $returnpack[$cnt]['media_value'] = $comm_row['media_value'];
          $returnpack[$cnt]['cmv_governmenttypes_id_c'] = $comm_row['cmv_governmenttypes_id_c'];
          $returnpack[$cnt]['cmv_governments_id_c'] = $comm_row['cmv_governments_id_c'];
          $returnpack[$cnt]['cmv_constitutionalarticles_id_c'] = $comm_row['cmv_constitutionalarticles_id_c'];
          $returnpack[$cnt]['cmv_politicalparties_id_c'] = $comm_row['cmv_politicalparties_id_c'];
          $returnpack[$cnt]['cmv_constitutionalamendments_id_c'] = $comm_row['cmv_constitutionalamendments_id_c'];
          $returnpack[$cnt]['cmv_governmentconstitutions_id_c'] = $comm_row['cmv_governmentconstitutions_id_c'];
          $returnpack[$cnt]['cmv_governmentbranches_id_c'] = $comm_row['cmv_governmentbranches_id_c'];
          $returnpack[$cnt]['cmv_department_agencies_id_c'] = $comm_row['cmv_department_agencies_id_c'];
          $returnpack[$cnt]['cmv_news_id_c'] = $comm_row['cmv_news_id_c'];
          $returnpack[$cnt]['cmv_organisations_id_c'] = $comm_row['cmv_organisations_id_c'];
          $returnpack[$cnt]['cmv_government_tenders_id_c'] = $comm_row['cmv_government_tenders_id_c'];
          $returnpack[$cnt]['cmv_governmentroles_id_c'] = $comm_row['cmv_governmentroles_id_c'];
          $returnpack[$cnt]['cmv_branch_departments_id_c'] = $comm_row['cmv_branch_departments_id_c'];
          $returnpack[$cnt]['cmv_politicalpartyroles_id_c'] = $comm_row['cmv_politicalpartyroles_id_c'];
          $returnpack[$cnt]['cmv_governmentpolicies_id_c'] = $comm_row['cmv_governmentpolicies_id_c'];
          $returnpack[$cnt]['cmv_nominees_id_c'] = $comm_row['cmv_nominees_id_c'];
          $returnpack[$cnt]['cmv_events_id_c'] = $comm_row['cmv_events_id_c'];
          $returnpack[$cnt]['cmv_content_id_c'] = $comm_row['cmv_content_id_c'];
          $returnpack[$cnt]['cmv_bills_id_c'] = $comm_row['cmv_bills_id_c'];
          $returnpack[$cnt]['cmv_laws_id_c'] = $comm_row['cmv_laws_id_c'];
          $returnpack[$cnt]['cmv_statutes_id_c'] = $comm_row['cmv_statutes_id_c'];
          $returnpack[$cnt]['cmv_causes_id_c'] = $comm_row['cmv_causes_id_c'];
          $returnpack[$cnt]['sfx_effects_id_c'] = $comm_row['sfx_effects_id_c'];
          $returnpack[$cnt]['view_count'] = $comm_row['view_count'];
          $returnpack[$cnt]['cmv_lawcases_id_c'] = $comm_row['cmv_lawcases_id_c'];
          $returnpack[$cnt]['cmv_comments_id_c'] = $comm_row['cmv_comments_id_c'];
          $returnpack[$cnt]['cmn_countries_id_c'] = $comm_row['cmn_countries_id_c'];
          $returnpack[$cnt]['sfx_actions_id_c'] = $comm_row['sfx_actions_id_c'];
          $returnpack[$cnt]['cmv_independentagencies_id_c'] = $comm_row['cmv_independentagencies_id_c'];

          $cnt++;
        
        } // end while
       
    break; // end Select
    case 'select_by_contact':
    
     if (is_array($params)){
      $query = $params[0];
      $query2 = $params[1];      
      } 
 
     if ($query != NULL && $query2 == NULL){
      $query = "WHERE ".$query." ";
      }

     if ($query2 != NULL){
      $query .= " WHERE ".$query2;
      }
      
     $comments_db = new DB_Sql();
     $comments_db->Database = DATABASE_NAME;
     $comments_db->User     = DATABASE_USER;
     $comments_db->Password = DATABASE_PASSWORD;
     $comments_db->Host     = DATABASE_HOST;
     
     $comm_list = $comments_db->query("SELECT * FROM cmv_comments $query order by cmv_comments.date_modified ASC");
     $cnt = 0;

     while ($comm_row = mysql_fetch_array ($comm_list)){
        $id = $comm_row['id'];
        $returnpack[$cnt]['comment_id'] = $id;
        $returnpack[$cnt]['name'] = $comm_row['name'];
        $returnpack[$cnt]['date_entered'] = $comm_row['date_entered'];
        $returnpack[$cnt]['date_modified'] = $comm_row['date_modified'];
        $returnpack[$cnt]['modified_user_id'] = $comm_row['modified_user_id'];
        $returnpack[$cnt]['created_by'] = $comm_row['created_by'];
        $returnpack[$cnt]['description'] = $comm_row['description'];
        $returnpack[$cnt]['deleted'] = $comm_row['deleted'];
        $returnpack[$cnt]['assigned_user_id'] = $comm_row['assigned_user_id'];
        $returnpack[$cnt]['language_id'] = $comm_row['cmn_languages_id_c'];
        $returnpack[$cnt]['cmv_statuses_id_c'] = $comm_row['cmv_statuses_id_c'];
        $returnpack[$cnt]['cmv_constib541rticles_ida'] = $comm_row['cmv_constib541rticles_ida'];
        $returnpack[$cnt]['cmv_govern1a56tutions_ida'] = $comm_row['cmv_govern1a56tutions_ida'];
        $returnpack[$cnt]['cmv_commen2d82olicies_idb'] = $comm_row['cmv_commen2d82olicies_idb'];
        $returnpack[$cnt]['cmv_governc909tenders_ida'] = $comm_row['cmv_governc909tenders_ida'];
        } // end while
          
        $cnt++;
             
   break; // end Select 
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_Comments',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;
  } // end Action switch

 break; // end Comments object 
 ###############################################
 case 'ConfigurationItems':
 
  switch ($action){
  
   case 'select':
    
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "en";
       }
 
   if ($query != NULL){
      $query = " WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM sclm_configurationitems $query $group $order $limit";

   $ci_db = new DB_Sql();
   $ci_db->Database = DATABASE_NAME;
   $ci_db->User     = DATABASE_USER;
   $ci_db->Password = DATABASE_PASSWORD;
   $ci_db->Host     = DATABASE_HOST;
     
   $the_list = $ci_db->query($final_query);

   $cnt = 0;

   $name_field_base = "name_";
   $content_field_base = "description_";
  
   while ($the_row = mysql_fetch_array ($the_list)){
         $returnpack[$cnt]['id'] = $the_row['id'];
         $returnpack[$cnt]['name'] = $the_row['name'];
         $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
         $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];    
         $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
         $returnpack[$cnt]['created_by'] = $the_row['created_by'];
         $returnpack[$cnt]['description'] = $the_row['description'];
         $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
         $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
         $returnpack[$cnt]['system_ci'] = $the_row['system_ci'];
         $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
         $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
         $returnpack[$cnt]['sclm_configurationitemtypes_id_c'] = $the_row['sclm_configurationitemtypes_id_c'];
         $returnpack[$cnt]['ci_type_id'] = $the_row['sclm_configurationitemtypes_id_c'];
         $returnpack[$cnt]['sclm_scalasticachildren_id_c'] = $the_row['sclm_scalasticachildren_id_c'];
         $returnpack[$cnt]['child_id'] = $the_row['sclm_scalasticachildren_id_c'];
         $returnpack[$cnt]['image_url'] = $the_row['image_url'];

         # Collect all available lingos

         for ($x=0;$x<count($lingos);$x++) {

             $extension = $lingos[$x][0][0][0][0][0][0];

             if ($name_field_base == "name_x_c"){

                $name_field_lingo = "name_".$extension."_c";
                $content_field_lingo = "description_".$extension."_c";

                } else {

                $name_field_lingo = $name_field_base.$extension;
                $content_field_lingo = $content_field_base.$extension;

                } 

             if ($the_row[$name_field_lingo] == NULL){
                $returnpack[$cnt][$name_field_lingo] = $the_row['name']; 
                } else {
                $returnpack[$cnt][$name_field_lingo] = $the_row[$name_field_lingo];
                } 

             if ($the_row[$content_field_lingo] == NULL){
                $returnpack[$cnt][$content_field_lingo] = $the_row['description']; 
                } else {
                $returnpack[$cnt][$content_field_lingo] = $the_row[$content_field_lingo];
                } 

           } // end for loop

         # End Lingo Collection

         $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
         $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
         $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
         $returnpack[$cnt]['sclm_sow_id_c'] = $the_row['sclm_sow_id_c'];
         $returnpack[$cnt]['sclm_sowitems_id_c'] = $the_row['sclm_sowitems_id_c'];
         $returnpack[$cnt]['enabled'] = $the_row['enabled'];
         $returnpack[$cnt]['opportunity_id_c'] = $the_row['opportunity_id_c'];
         $returnpack[$cnt]['junban'] = $the_row['junban'];

         if ($returnpack[$cnt]['ci_type_id']){
            $ci_type_name = dlookup("sclm_configurationitemtypes", "name", "id='".$returnpack[$cnt]['ci_type_id']."'");
            $ci_data_type = dlookup("sclm_configurationitemtypes", "ci_data_type", "id='".$returnpack[$cnt]['ci_type_id']."'");
            $returnpack[$cnt]['ci_type_name'] = $ci_type_name;
            $returnpack[$cnt]['ci_data_type'] = $ci_data_type;
            }

         if ($returnpack[$cnt]['child_id']){
            $child_name = dlookup("sclm_scalasticachildren", "name", "id='".$returnpack[$cnt]['child_id']."'");
            $returnpack[$cnt]['child_name'] = $child_name;
            }

         $returnpack[$cnt]['sclm_configurationitems_id_c'] = $the_row['sclm_configurationitems_id_c'];
         if ($returnpack[$cnt]['sclm_configurationitems_id_c']){
            $parent_ci_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['sclm_configurationitems_id_c']."'");
            $returnpack[$cnt]['parent_ci_name'] = $parent_ci_name;
            $parent_ci_type = dlookup("sclm_configurationitems", "sclm_configurationitemtypes_id_c", "id='".$returnpack[$cnt]['sclm_configurationitems_id_c']."'");
            $returnpack[$cnt]['parent_ci_type'] = $parent_ci_type;
            }

//         $parent_id = dlookup("sclm_configurationitemtypes", "name", "id='".$returnpack[$cnt]['ci_type_id']."'");


         $cnt++;

         } // end while
       
   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_ConfigurationItems',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;
 
   } // end Action switch
 
 break; // end ConfigurationItems
 ###############################################
 case 'ConfigurationItemTypes':
 
  switch ($action){
  
   case 'select':
    
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM sclm_configurationitemtypes $query $group $order $limit";

   $the_list = $db->query($final_query);

   $cnt = 0;
  
   while ($the_row = mysql_fetch_array ($the_list)){
         $returnpack[$cnt]['id'] = $the_row['id'];
         $returnpack[$cnt]['name'] = $the_row['name'];
         $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
         $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];    
         $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
         $returnpack[$cnt]['created_by'] = $the_row['created_by'];
         $returnpack[$cnt]['description'] = $the_row['description'];
         $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
         $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
         $returnpack[$cnt]['ci_data_type'] = $the_row['ci_data_type'];
         $returnpack[$cnt]['sclm_configurationitemtypes_id_c'] = $the_row['sclm_configurationitemtypes_id_c'];
         $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
         $returnpack[$cnt]['name_en'] = $the_row['name_en'];
         $returnpack[$cnt]['name_ja'] = $the_row['name_ja'];
         $returnpack[$cnt]['description_en'] = $the_row['description_en'];
         $returnpack[$cnt]['description_ja'] = $the_row['description_ja'];
         $returnpack[$cnt]['image_url'] = $the_row['image_url'];
         $returnpack[$cnt]['external_source'] = $the_row['external_source'];
         $returnpack[$cnt]['external_data_id'] = $the_row['external_data_id'];
                
         $cnt++;

         } // end while
       
   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_ConfigurationItemTypes',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;
 
   } // end Action switch
 
 break; // end ConfigurationItemTypes
 ###############################################
 case 'Contacts':
 case 'contacts':

  switch ($action){

   case 'select_all':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $final_query = "SELECT $select FROM contacts $query $group $order $limit";

    $contacts_db = new DB_Sql();
    $contacts_db->Database = DATABASE_NAME;
    $contacts_db->User     = DATABASE_USER;
    $contacts_db->Password = DATABASE_PASSWORD;
    $contacts_db->Host     = DATABASE_HOST;

    $the_list = $contacts_db->query($final_query);
    
    $cnt = 0;
    
    while ($the_row = mysql_fetch_array ($the_list)){
     
          $returnpack[$cnt]['id'] = $the_row['id'];
          $this_id = $the_row['id'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['salutation'] = $the_row['salutation'];
          $returnpack[$cnt]['first_name'] = $the_row['first_name'];
          $returnpack[$cnt]['last_name'] = $the_row['last_name'];
          $returnpack[$cnt]['title'] = $the_row['title'];
          $returnpack[$cnt]['department'] = $the_row['department'];
          $returnpack[$cnt]['do_not_call'] = $the_row['do_not_call'];
          $returnpack[$cnt]['phone_home'] = $the_row['phone_home'];
          $returnpack[$cnt]['phone_mobile'] = $the_row['phone_mobile'];
          $returnpack[$cnt]['phone_work'] = $the_row['phone_work'];
          $returnpack[$cnt]['phone_other'] = $the_row['phone_other'];
          $returnpack[$cnt]['phone_fax'] = $the_row['phone_fax'];
          $returnpack[$cnt]['primary_address_street'] = $the_row['primary_address_street'];
          $returnpack[$cnt]['primary_address_city'] = $the_row['primary_address_city'];
          $returnpack[$cnt]['primary_address_state'] = $the_row['primary_address_state'];
          $returnpack[$cnt]['primary_address_postalcode'] = $the_row['primary_address_postalcode'];
          $returnpack[$cnt]['primary_address_country'] = $the_row['primary_address_country'];
          $returnpack[$cnt]['alt_address_street'] = $the_row['alt_address_street'];
          $returnpack[$cnt]['alt_address_city'] = $the_row['alt_address_city'];
          $returnpack[$cnt]['alt_address_state'] = $the_row['alt_address_state'];
          $returnpack[$cnt]['alt_address_postalcode'] = $the_row['alt_address_postalcode'];
          $returnpack[$cnt]['alt_address_country'] = $the_row['alt_address_country'];
          $returnpack[$cnt]['assistant'] = $the_row['assistant'];
          $returnpack[$cnt]['assistant_phone'] = $the_row['assistant_phone'];
          $returnpack[$cnt]['lead_source'] = $the_row['lead_source'];
          $returnpack[$cnt]['reports_to_id'] = $the_row['reports_to_id'];
          $returnpack[$cnt]['birthdate'] = $the_row['birthdate'];
          $returnpack[$cnt]['portal_name'] = $the_row['portal_name'];
          $returnpack[$cnt]['portal_active'] = $the_row['portal_active'];
          $returnpack[$cnt]['portal_app'] = $the_row['portal_app'];
          $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];

          $cstm_contacts_db = new DB_Sql();
          $cstm_contacts_db->Database = DATABASE_NAME;
          $cstm_contacts_db->User     = DATABASE_USER;
          $cstm_contacts_db->Password = DATABASE_PASSWORD;
          $cstm_contacts_db->Host     = DATABASE_HOST;
       
          $cstm_list = $cstm_contacts_db->query("SELECT * FROM contacts_cstm WHERE id_c='".$this_id."'");

          while ($cstm_row = mysql_fetch_array ($cstm_list)){

                #$returnpack[$cnt]['id_c'] = $cstm_row['id_c'];
                #$returnpack[$cnt]['source_id_c'] = $cstm_row['source_id_c'];
                $returnpack[$cnt]['password_c'] = $cstm_row['password_c'];
                $returnpack[$cnt]['twitter_name_c'] = $cstm_row['twitter_name_c'];
                $returnpack[$cnt]['linkedin_name_c'] = $cstm_row['linkedin_name_c'];
                $returnpack[$cnt]['twitter_password_c'] = $cstm_row['twitter_password_c'];
                #$returnpack[$cnt]['dead_c'] = $cstm_row['dead_c'];
                #$returnpack[$cnt]['death_date_c'] = $cstm_row['death_date_c'];
                $returnpack[$cnt]['nickname_c'] = $cstm_row['nickname_c'];
                $returnpack[$cnt]['cloakname_c'] = $cstm_row['cloakname_c'];
                $returnpack[$cnt]['create_news_c'] = $cstm_row['create_news_c'];
                $returnpack[$cnt]['profile_photo_c'] = $cstm_row['profile_photo_c'];
                $returnpack[$cnt]['role_c'] = $cstm_row['role_c'];
                $returnpack[$cnt]['cmn_languages_id_c'] = $cstm_row['cmn_languages_id_c'];
                $returnpack[$cnt]['cmn_countries_id_c'] = $cstm_row['cmn_countries_id_c'];
                $returnpack[$cnt]['social_network_name_type_c'] = $cstm_row['social_network_name_type_c'];
                $returnpack[$cnt]['default_name_type_c'] = $cstm_row['default_name_type_c'];
                $returnpack[$cnt]['friends_name_type_c'] = $cstm_row['friends_name_type_c'];

                } # while cstm

           $cnt++;

          } # while

   break;
   case 'select_cstm':

    if (is_array($params)){
       $query = $params[0];
       $select_fields = $params[1];
       } else {
       $query = '';
//       $select_fields = array();
       $select_fields = "";
       }

    if ($query){
       $query = "WHERE ".$query." ";
       }
      
    if (!$select_fields){
       $select_fields = "*";
       }

    $contacts_db = new DB_Sql();
    $contacts_db->Database = DATABASE_NAME;
    $contacts_db->User     = DATABASE_USER;
    $contacts_db->Password = DATABASE_PASSWORD;
    $contacts_db->Host     = DATABASE_HOST;
       
    $result = $contacts_db->query("SELECT $select_fields FROM contacts_cstm $query");
    
    $cnt = 0;
    
    //var_dump($result);
    
    while ($the_row = mysql_fetch_array ($result)){
     
          $returnpack[$cnt]['id_c'] = $the_row['id_c'];
//          $returnpack[$cnt]['source_id_c'] = $the_row['source_id_c'];
          $returnpack[$cnt]['password_c'] = $the_row['password_c'];
          $returnpack[$cnt]['twitter_name_c'] = $the_row['twitter_name_c'];
          $returnpack[$cnt]['linkedin_name_c'] = $the_row['linkedin_name_c'];
          $returnpack[$cnt]['twitter_password_c'] = $the_row['twitter_password_c'];
//          $returnpack[$cnt]['dead_c'] = $the_row['dead_c'];
//          $returnpack[$cnt]['death_date_c'] = $the_row['death_date_c'];
          $returnpack[$cnt]['nickname_c'] = $the_row['nickname_c'];
          $returnpack[$cnt]['cloakname_c'] = $the_row['cloakname_c'];
          $returnpack[$cnt]['create_news_c'] = $the_row['create_news_c'];
          $returnpack[$cnt]['profile_photo_c'] = $the_row['profile_photo_c'];
          $returnpack[$cnt]['role_c'] = $the_row['role_c'];
          $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
          $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
          $returnpack[$cnt]['social_network_name_type_c'] = $the_row['social_network_name_type_c'];
          $returnpack[$cnt]['default_name_type_c'] = $the_row['default_name_type_c'];
          $returnpack[$cnt]['friends_name_type_c'] = $the_row['friends_name_type_c'];

          $cnt++;

          }

   break;
   case 'select':
  
/* 
    if (is_array($params)){
     $query = $params[0];
     //$query = '';
     $select_fields = $params[1];
     } else {
     $query = '';
     $select_fields = array();
     }

    $offset = 0;
    
    //$query = "cmv_leadsources_id_c = '".$params[0]."' AND source_id = '".$params[1]."' " ;
    
    $result = $soapclient->call('get_entry_list',array(
'session'=>$sugar_session_id,
'module_name'=>'Contacts',
'query'=>$query,
'order_by'=>'contacts.last_name asc',
'offset'=>$offset,
'select_fields'=>$select_fields,
'max_results'=>'10000',
'deleted'=>'0',
));
    
    //var_dump($result);
    
    //    $encode = mb_detect_encoding($result);
    
    $gotten = $soapclient->response;
    $cnt = 0;
    foreach ($result['entry_list'] as $gotten){

     $the_row = nameValuePairToSimpleArray($gotten['name_value_list']);

     $returnpack[$cnt]['id'] = $the_row['id'];
     $returnpack[$cnt]['source_id_c'] = $the_row['source_id_c'];
     $returnpack[$cnt]['password_c'] = $the_row['password_c'];
     /*
     $returnpack[$cnt]['open_state_first_name_c'] = $the_row['open_state_first_name_c'];
     $returnpack[$cnt]['open_state_last_name_c'] = $the_row['open_state_last_name_c'];
     $returnpack[$cnt]['open_state_email1_c'] = $the_row['open_state_email1_c'];
     $returnpack[$cnt]['ads_state_last_name_c'] = $the_row['ads_state_last_name_c'];
     $returnpack[$cnt]['desired_cmv_last_name_c'] = $the_row['desired_cmv_last_name_c'];
     $returnpack[$cnt]['ads_state_first_name_c'] = $the_row['ads_state_first_name_c'];
     $returnpack[$cnt]['desired_cmv_first_name_c'] = $the_row['desired_cmv_first_name_c'];
     $returnpack[$cnt]['ads_state_email1_c'] = $the_row['ads_state_email1_c'];
     $returnpack[$cnt]['verify_state_first_name_c'] = $the_row['verify_state_first_name_c'];
     $returnpack[$cnt]['verify_state_last_name_c'] = $the_row['verify_state_last_name_c'];
     $returnpack[$cnt]['desired_cmv_email1_c'] = $the_row['desired_cmv_email1_c'];
     $returnpack[$cnt]['verify_state_email1_c'] = $the_row['verify_state_email1_c'];
     $returnpack[$cnt]['desired_cmv_phone_home_c'] = $the_row['desired_cmv_phone_home_c'];
     $returnpack[$cnt]['desired_cmv_phone_mobile_c'] = $the_row['desired_cmv_phone_mobile_c'];
     $returnpack[$cnt]['verify_state_phone_home_c'] = $the_row['verify_state_phone_home_c'];
     $returnpack[$cnt]['verify_state_phone_mobile_c'] = $the_row['verify_state_phone_mobile_c'];
     $returnpack[$cnt]['open_state_phone_home_c'] = $the_row['open_state_phone_home_c'];
     $returnpack[$cnt]['open_state_phone_mobile_c'] = $the_row['open_state_phone_mobile_c'];
     $returnpack[$cnt]['ads_state_phone_home_c'] = $the_row['ads_state_phone_home_c'];
     $returnpack[$cnt]['ads_state_phone_mobile_c'] = $the_row['ads_state_phone_mobile_c'];
     $returnpack[$cnt]['twitter_name_c'] = $the_row['twitter_name_c'];
     $returnpack[$cnt]['twitter_password_c'] = $the_row['twitter_password_c'];
     $returnpack[$cnt]['dead_c'] = $the_row['dead_c'];
     $returnpack[$cnt]['death_date_c'] = $the_row['death_date_c'];
     $returnpack[$cnt]['create_party_count_c'] = $the_row['create_party_count_c'];

     $cnt++;

     } // end forloop
*/

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM contacts $query $group $order $limit";

   $contacts_db = new DB_Sql();
   $contacts_db->Database = DATABASE_NAME;
   $contacts_db->User     = DATABASE_USER;
   $contacts_db->Password = DATABASE_PASSWORD;
   $contacts_db->Host     = DATABASE_HOST;

   $the_list = $contacts_db->query($final_query);
/*
    if (is_array($params)){
       $query = $params[0];
       $select_fields = $params[1];
       } else {
       $query = '';
       $select_fields = array();
       }

     if ($query){
        $query = "WHERE ".$query." ";
        }
      
     if (!$select_fields){
        $select_fields = "*";
        }
       
    $result = $contacts_db->query("SELECT $select_fields FROM contacts $query");
*/
    
    $cnt = 0;
    
    while ($the_row = mysql_fetch_array ($the_list)){
     
          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['salutation'] = $the_row['salutation'];
          $returnpack[$cnt]['first_name'] = $the_row['first_name'];
          $returnpack[$cnt]['last_name'] = $the_row['last_name'];
          $returnpack[$cnt]['title'] = $the_row['title'];
          $returnpack[$cnt]['department'] = $the_row['department'];
          $returnpack[$cnt]['do_not_call'] = $the_row['do_not_call'];
          $returnpack[$cnt]['phone_home'] = $the_row['phone_home'];
          $returnpack[$cnt]['phone_mobile'] = $the_row['phone_mobile'];
          $returnpack[$cnt]['phone_work'] = $the_row['phone_work'];
          $returnpack[$cnt]['phone_other'] = $the_row['phone_other'];
          $returnpack[$cnt]['phone_fax'] = $the_row['phone_fax'];
          $returnpack[$cnt]['primary_address_street'] = $the_row['primary_address_street'];
          $returnpack[$cnt]['primary_address_city'] = $the_row['primary_address_city'];
          $returnpack[$cnt]['primary_address_state'] = $the_row['primary_address_state'];
          $returnpack[$cnt]['primary_address_postalcode'] = $the_row['primary_address_postalcode'];
          $returnpack[$cnt]['primary_address_country'] = $the_row['primary_address_country'];
          $returnpack[$cnt]['alt_address_street'] = $the_row['alt_address_street'];
          $returnpack[$cnt]['alt_address_city'] = $the_row['alt_address_city'];
          $returnpack[$cnt]['alt_address_state'] = $the_row['alt_address_state'];
          $returnpack[$cnt]['alt_address_postalcode'] = $the_row['alt_address_postalcode'];
          $returnpack[$cnt]['alt_address_country'] = $the_row['alt_address_country'];
          $returnpack[$cnt]['assistant'] = $the_row['assistant'];
          $returnpack[$cnt]['assistant_phone'] = $the_row['assistant_phone'];
          $returnpack[$cnt]['lead_source'] = $the_row['lead_source'];
          $returnpack[$cnt]['reports_to_id'] = $the_row['reports_to_id'];
          $returnpack[$cnt]['birthdate'] = $the_row['birthdate'];
          $returnpack[$cnt]['portal_name'] = $the_row['portal_name'];
          $returnpack[$cnt]['portal_active'] = $the_row['portal_active'];
          $returnpack[$cnt]['portal_app'] = $the_row['portal_app'];
          $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];
          $cnt++;

          }
   
   break;
   case 'select_soap':

    if (is_array($params)){
     $query = $params[0];
     //$query = '';
     $select_fields = $params[1];
     } else {
     $query = '';
     $select_fields = array();
     }

    $offset = 0;
       
    $result = $soapclient->call('get_entry_list',array(
'session'=>$sugar_session_id,
'module_name'=>'Contacts',
'query'=>$query,
'order_by'=>'contacts.last_name asc',
'offset'=>$offset,
'select_fields'=>$select_fields,
'max_results'=>'10000',
'deleted'=>'0',
));
        
    //var_dump($result);

    $gotten = $soapclient->response;
    $cnt = 0;
    foreach ($result['entry_list'] as $gotten){

          $the_row = nameValuePairToSimpleArray($gotten['name_value_list']);
     
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['salutation'] = $the_row['salutation'];
          $returnpack[$cnt]['first_name'] = $the_row['first_name'];
          $returnpack[$cnt]['last_name'] = $the_row['last_name'];
          $returnpack[$cnt]['email1'] = $the_row['email1'];
          $returnpack[$cnt]['title'] = $the_row['title'];
          $returnpack[$cnt]['department'] = $the_row['department'];
          $returnpack[$cnt]['do_not_call'] = $the_row['do_not_call'];
          $returnpack[$cnt]['phone_home'] = $the_row['phone_home'];
          $returnpack[$cnt]['phone_mobile'] = $the_row['phone_mobile'];
          $returnpack[$cnt]['phone_work'] = $the_row['phone_work'];
          $returnpack[$cnt]['phone_other'] = $the_row['phone_other'];
          $returnpack[$cnt]['phone_fax'] = $the_row['phone_fax'];
          $returnpack[$cnt]['primary_address_street'] = $the_row['primary_address_street'];
          $returnpack[$cnt]['primary_address_city'] = $the_row['primary_address_city'];
          $returnpack[$cnt]['primary_address_state'] = $the_row['primary_address_state'];
          $returnpack[$cnt]['primary_address_postalcode'] = $the_row['primary_address_postalcode'];
          $returnpack[$cnt]['primary_address_country'] = $the_row['primary_address_country'];
          $returnpack[$cnt]['alt_address_street'] = $the_row['alt_address_street'];
          $returnpack[$cnt]['alt_address_city'] = $the_row['alt_address_city'];
          $returnpack[$cnt]['alt_address_state'] = $the_row['alt_address_state'];
          $returnpack[$cnt]['alt_address_postalcode'] = $the_row['alt_address_postalcode'];
          $returnpack[$cnt]['alt_address_country'] = $the_row['alt_address_country'];
          $returnpack[$cnt]['assistant'] = $the_row['assistant'];
          $returnpack[$cnt]['assistant_phone'] = $the_row['assistant_phone'];
          $returnpack[$cnt]['lead_source'] = $the_row['lead_source'];
          $returnpack[$cnt]['reports_to_id'] = $the_row['reports_to_id'];
          $returnpack[$cnt]['birthdate'] = $the_row['birthdate'];
          $returnpack[$cnt]['portal_name'] = $the_row['portal_name'];
          $returnpack[$cnt]['portal_active'] = $the_row['portal_active'];
          $returnpack[$cnt]['portal_app'] = $the_row['portal_app'];
          $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];
          $returnpack[$cnt]['twitter_name_c'] = $the_row['twitter_name_c'];
          $returnpack[$cnt]['twitter_password_c'] = $the_row['twitter_password_c'];
          $returnpack[$cnt]['linkedin_name_c'] = $the_row['linkedin_name_c'];
//          $returnpack[$cnt]['dead_c'] = $the_row['dead_c'];
//          $returnpack[$cnt]['death_date_c'] = $the_row['death_date_c'];
//          $returnpack[$cnt]['create_party_count_c'] = $the_row['create_party_count_c'];
//          $returnpack[$cnt]['profile_photo_c'] = $the_row['profile_photo_c'];
          $returnpack[$cnt]['role_c'] = $the_row['role_c'];

          $cnt++;

          } // end foreach

   break;
   case 'get_count':

    $offset = 0;
    
    if (is_array($params)){
     $query = $params[0];
     $deleted = $params[1];
     } else {
     $query = "";
     $deleted = "0";
     }
    
    $result = $soapclient->call('get_entries_count',array('session'=>$sugar_session_id,'module_name'=>'Contacts','query'=>$query,'deleted'=>$deleted));

    $returnpack = $result['result_count'];
    
    //    var_dump($result);

   break;
   case 'get_all':

    $offset = 0;

    $result = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,'module_name'=>'Contacts','query'=>'','order_by'=>'contacts.last_name asc','offset'=>$offset, 'select_fields'=>array(), 'max_results'=>'10000'));

    //    $encode = mb_detect_encoding($result);

    $gotten = $soapclient->response;
    $cnt = 0;
    foreach ($result['entry_list'] as $gotten){

     $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);
     $crmparams[$cnt][0] = $fieldarray['id'];
     $crmparams[$cnt][1] = $fieldarray['first_name'];
     $crmparams[$cnt][2] = $fieldarray['last_name'];
     $crmparams[$cnt][3] = $fieldarray['email1'];

     // Possibility that the entry didn't have an email set
     if ($fieldarray['email1']== NULL){
      $dater = date("Y-m-d");
      $domain = $params[0];
      $crmparams[$cnt][3] = $dater."-scalastica@".$domain;
      }

     $crmparams[$cnt][4] = $fieldarray['lead_source'];
     $crmparams[$cnt][5] = $fieldarray['phone_work'];
     $crmparams[$cnt][6] = $fieldarray['account_name'];
     $crmparams[$cnt][6] = $fieldarray['primary_address_street'];
     $crmparams[$cnt][7] = $fieldarray['primary_address_city'];
     $crmparams[$cnt][8] = $fieldarray['primary_address_state'];
     $crmparams[$cnt][9] = $fieldarray['primary_address_postalcode'];
     $crmparams[$cnt][10] = $fieldarray['primary_address_country'];
     $crmparams[$cnt][11] = $fieldarray['phone_fax'];
     $crmparams[$cnt][12] = $fieldarray['password_c'];
     $crmparams[$cnt][13] = $fieldarray['role_c'];

     $cnt++;

     } // end forloop

    $returnpack = $crmparams;

   break;
   case 'get_contact_email':

    $final_query = "SELECT email_addresses.email_address FROM contacts,email_addr_bean_rel,email_addresses WHERE contacts.id = '".$params."' && email_addr_bean_rel.email_address_id=email_addresses.id && email_addr_bean_rel.bean_id=contacts.id && email_addr_bean_rel.deleted=0";

   $contacts_db = new DB_Sql();
   $contacts_db->Database = DATABASE_NAME;
   $contacts_db->User     = DATABASE_USER;
   $contacts_db->Password = DATABASE_PASSWORD;
   $contacts_db->Host     = DATABASE_HOST;

   $the_list = $contacts_db->query($final_query);

   $cnt = 0;
  
   while ($the_row = mysql_fetch_array ($the_list)){

         $returnpack = $the_row['email_address'];                

         } // end while

   break;
   case 'contact_by_email':

    $offset = 0;

/*
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM cmv_contactssources $query $group $order $limit";
*/

   $final_query = "SELECT contacts.id FROM contacts,email_addr_bean_rel,email_addresses WHERE email_addresses.email_address = '".$params."' && email_addr_bean_rel.email_address_id=email_addresses.id && email_addr_bean_rel.bean_id=contacts.id && email_addr_bean_rel.deleted=0";

//echo "Query: ".$final_query."<P>";

   $contacts_db = new DB_Sql();
   $contacts_db->Database = DATABASE_NAME;
   $contacts_db->User     = DATABASE_USER;
   $contacts_db->Password = DATABASE_PASSWORD;
   $contacts_db->Host     = DATABASE_HOST;

   $the_list = $contacts_db->query($final_query);

   $cnt = 0;
  
   while ($the_row = mysql_fetch_array ($the_list)){

//echo "ID: ".$the_row['id']."<BR>";

         $returnpack = $the_row['id'];                

         } // end while

//         $returnpack = ['entry_list']['name_value_list']['id'] = $the_row['id'];
//         $returnpack = '<entry_list><name_value_list><id>'.$id.'</id></name_value_list></entry_list>';                

    
//echo "URL :".$crm_wsdl_url;
    
//    require_once ("nusoap/nusoap.php");
        
//    $soapclient = new nusoap_client($crm_wsdl_url);

    //  $query = "email_address='".$params[0]."'";
//    $query = "contacts.id IN ( SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON eabr.email_address_id = ea.id WHERE eabr.bean_module = 'Contacts' AND ea.email_address = '".$params."' ) " ;

//    $id = dlookup("cmv_governments", "government_e", "id='".$government_id."'");

//    $query = "contacts.id in (SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 and ea.email_address LIKE '%" . $params . "%')";
    // Email ID from email_addresses

//    $query = "contacts.id FROM contacts,email_addr_bean_rel,email_addresses WHERE email_addresses.email_address = '".$params."' && email_addr_bean_rel.email_address_id=email_addresses.id && email_addr_bean_rel.bean_id=contacts.id";

//    $result = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,' module_name'=>'Contacts','query'=>$query, 'order_by'=>'','offset'=>0,'select_fields'=>array(),'max_results'=>10,'deleted'=>-1));


//email_addr_bean_rel,
//email_addr_bean_rel.bean_id=


//    $query = "contacts.id in (SELECT eabr.bean_id FROM email_addr_bean_rel eabr JOIN email_addresses ea ON (ea.id = eabr.email_address_id) WHERE eabr.deleted=0 AND ea.email_address = '".$params."'";

//    $select_fields = array();
//    $select_fields = array("last_name", "id","email1");

//    $result = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,' module_name'=>'Contacts','query'=>$query, 'order_by'=>'','offset'=>0,'select_fields'=>array(),'max_results'=>10,'deleted'=>-1));

//echo "Query :".$query."<P>";

//    $result = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,'module_name'=>'Contacts','query'=>$query,'order_by'=>'contacts.last_name asc','offset'=>$offset, 'select_fields'=>array(), 'max_results'=>'10000'));

    //    $result = $soapclient->call('get_id_from_email_prospect', $params);

    //    $gotten = $soapclient->response;

//    var_dump($result);
    //echo $soapclient->error_str;
    //echo $gotten;
    /*
    $cnt = 0;

    foreach ($result['entry_list'] as $gotten){

     $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);

            $crmparams[$cnt][0] = $fieldarray['id'];
            $crmparams[$cnt][1] = $fieldarray['account_id'];
            $crmparams[$cnt][2] = $fieldarray['first_name'];
            $crmparams[$cnt][3] = $fieldarray['last_name'];
            $crmparams[$cnt][4] = $fieldarray['email1'];
            $crmparams[$cnt][5] = $fieldarray['lead_source'];
            $crmparams[$cnt][6] = $fieldarray['phone_work'];
            $crmparams[$cnt][7] = $fieldarray['account_name'];

            $cnt++;

            } // end forloop

      $returnpack = $crmparams;
*/
   // $returnpack = $result;
     
   break;
   case 'contact_by_id':

    $offset = 0;

    $query = "contacts.id = '".$params."' " ;

    //    echo "<P>Query: ".$query."<P>";

    //echo "ID In:".$params[0]."<BR>"; 

    $returnpack = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,'module_name'=>'Contacts','query'=>$query,'order_by'=>'contacts.last_name asc','offset'=>$offset, 'select_fields'=> array(), 'max_results'=>'10000'));

//    var_dump($returnpack);

   break;
   case 'contact_by_source':

    $offset = 0;

    $query = "sclm_leadsources_id_c = '".$params[0]."' AND source_id = '".$params[1]."' " ;

//    echo "Query:".$query." sugar session $sugar_session_id <BR> ";

    $returnpack = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,'module_name'=>'sclm_ContactsSources','query'=>$query,'order_by'=>'sclm_contactssources.name asc','offset'=>$offset, 'select_fields'=>array(), 'max_results'=>'10000'));

//    var_dump($returnpack);

   break;    
   case 'all_source_contacts':

    $offset = 0;

    $query = $params[0];

//    echo "Query:".$query."<BR>";

/*
    $returnpack = $soapclient->call('get_entry_list',array(
'session'=>$sugar_session_id,
'module_name'=>'cmv_ContactsSources',
'query'=>$query,
'order_by'=>'cmv_contactssources.name asc',
'offset'=>$offset,
'select_fields'=>array(),
'max_results'=>'10000',
'deleted'=>'0'));
*/
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM sclm_contactssources $query $group $order $limit";

   $the_list = $db->query($final_query);

   $cnt = 0;
  
   while ($the_row = mysql_fetch_array ($the_list)){
         $returnpack[$cnt]['id'] = $the_row['id'];
         $returnpack[$cnt]['name'] = $the_row['name'];
         $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
         $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];    
         $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
         $returnpack[$cnt]['created_by'] = $the_row['created_by'];
         $returnpack[$cnt]['description'] = $the_row['description'];
         $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
         $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
         $returnpack[$cnt]['source_id'] = $the_row['source_id'];
         $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
         $returnpack[$cnt]['sclm_leadsources_id_c'] = $the_row['sclm_leadsources_id_c'];
//         $returnpack[$cnt]['cmv_targetmarkets_id_c'] = $the_row['cmv_targetmarkets_id_c'];
                
         $cnt++;

         } // end while

   break;    
   case 'create':

    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list'=>array(
                            array('name'=>'last_name','value'=>$params[0]),
                            array('name'=>'first_name','value'=>$params[1]),
                            array('name'=>'email1','value'=>$params[2]),
                            array('name'=>'role_c','value'=>$params[3]),
                            )
                        );

    // Now Add the Contact
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;
   case 'create_sclm_ContactsSources':

    // Now Prepare a Contact
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_ContactsSources',
              'name_value_list'=> $params
   );

    // Now Add the Contact
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;   
   case 'update':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list'=> $params
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

    //var_dump($result);

   break;
   case 'update_lead':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list'=>array(
                            array('name'=>'id','value'=>$params[0]),
                            array('name'=>'lead_source','value'=>$params[1]),
                            )
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

    //var_dump($result);

   break;
   case 'update_team':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list'=>array(
                            array('name'=>'id','value'=>$params[0]),
                            array('name'=>'team_id','value'=>$params[1]),
                            )
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

    //var_dump($result);

   break;
   case 'update_assigned_user':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list'=>array(
                            array('name'=>'id','value'=>$params[0]),
                            array('name'=>'assigned_user_id','value'=>$params[1]),
                            )
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

    //var_dump($result);

   break;
   case 'update_password':

    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list' => array(
                            array('name'=>'id','value' => $params[0]),
                            array('name'=>'password_c','value' => $params[1])
                            )
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;
   case 'update_source':

    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list' => array(
                            array('name'=>'id','value' => $params[0]),
                            array('name'=>'contacts.source_id_c','value' => $params[1])
                            )
                        );

    $returnpack = $soapclient->call('set_entries',$set_entry_params);

   break;
   case 'update_personal':

    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'Contacts',
              'name_value_list'=>$params
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;
   case 'get_account_id':

    $offset = 0;

    $module = "Contacts";
    $id = $params[0];
    if ($params[1] != NULL){
       $selected_fields = $params[1];
       } else {
       $selected_fields = "";
       }

    $set_params = array(
              'session' => $sugar_session_id,
              'module_name' => $module,
              'id'=> $id,
              'select_fields'=>$selected_fields
                        );

    $entry = $soapclient->call('get_entry',$set_params);

    if (is_array($entry)){
       foreach ($entry['entry_list'] as $key => $value){
               if (is_array($value)){
                  foreach ($value as $key2 => $value2){
                          if ($key2 == 'name_value_list'){
                             if (is_array($value2)){
                                foreach ($value2 as $key3 => $value3){
                                        if (is_array($value2)){
                                           foreach ($value3 as $key4 => $value4){
                                                   if ($value4 == 'account_id'){
                                                      $returnpack = $value3['value'];
                                                      } // end if
                                                   } // end foreach
                                           } // end if
                                        } // end foreach
                                } // end if
                             } // end if
                          } // end foreach inner
                  } // end is array
               } // end foreach
       } // end is array
   
   break;

  } // end switch contacts actions
   
 break; // end contacts
 ###############################################
 case 'ContactsNotifications':
 
  switch ($action){
  
   case 'select':
    
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = " WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

   $final_query = "SELECT $select FROM sclm_notificationcontacts $query $group $order $limit";

   $contacts_db = new DB_Sql();
   $contacts_db->Database = DATABASE_NAME;
   $contacts_db->User     = DATABASE_USER;
   $contacts_db->Password = DATABASE_PASSWORD;
   $contacts_db->Host     = DATABASE_HOST;
       
   $the_list = $contacts_db->query($final_query);

   $cnt = 0;
  
   while ($the_row = mysql_fetch_array ($the_list)){
         $returnpack[$cnt]['id'] = $the_row['id'];
         $returnpack[$cnt]['name'] = $the_row['name'];
         $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
         $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];    
         $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
         $returnpack[$cnt]['created_by'] = $the_row['created_by'];
         $returnpack[$cnt]['description'] = $the_row['description'];
         $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
         $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
         $returnpack[$cnt]['sclm_serviceslarequests_id_c'] = $the_row['sclm_serviceslarequests_id_c'];
         $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
         $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
         $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
         if ($returnpack[$cnt]['cmn_statuses_id_c']){
            $returnpack[$cnt]['cmn_statuses_name'] = dlookup("cmn_statuses", "name", "id='".$the_row['cmn_statuses_id_c']."'");
            }
         $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];

         $cnt++;

         } // end while
       
   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_NotificationContacts',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;
 
   } // end Action switch
 
 break; // end ContactsNotifications
 ###############################################
 case 'ContactProfiles':

  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

    $final_query = "SELECT $select FROM cmn_contactprofiles $query $group $order $limit";

    $contacts_db = new DB_Sql();
    $contacts_db->Database = DATABASE_NAME;
    $contacts_db->User     = DATABASE_USER;
    $contacts_db->Password = DATABASE_PASSWORD;
    $contacts_db->Host     = DATABASE_HOST;
       
    $the_list = $contacts_db->query($final_query);
   
    $cnt = 0;

    while ($the_row = mysql_fetch_array ($the_list)){
     
          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['default_name_type'] = $the_row['cmv_contactnametypes_id_c'];
          $returnpack[$cnt]['social_network_name_type'] = $the_row['cmv_contactnametypes_id1_c'];
          $returnpack[$cnt]['friends_name_type'] = $the_row['cmv_contactnametypes_id2_c'];

          $cnt++;

          }

   break;
   case 'update':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'cmn_ContactProfiles',
              'name_value_list'=> $params
                        );

    $soapclient->call('set_entry',$set_entry_params);

   break;
  } // end switch contacts actions
   
 break; // end contacts profiles
 ###############################################
 case 'ContactsServices':

  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

    $final_query = "SELECT $select FROM sclm_contactsservices $query $group $order $limit";

    $contacts_db = new DB_Sql();
    $contacts_db->Database = DATABASE_NAME;
    $contacts_db->User     = DATABASE_USER;
    $contacts_db->Password = DATABASE_PASSWORD;
    $contacts_db->Host     = DATABASE_HOST;
       
    $the_list = $contacts_db->query($final_query);
   
    $cnt = 0;

    while ($the_row = mysql_fetch_array ($the_list)){
     
          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['contact_id'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['account_id'] = $the_row['account_id_c'];
          $returnpack[$cnt]['desired_credits'] = $the_row['desired_credits'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'sclm_ContactsServices',
              'name_value_list'=> $params
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;
  } // end switch contacts actions
   
 break; // end ContactsServices
 ###############################################
 case 'ContactsServicesSLA':

  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
   if ($query != NULL){
      $query = "WHERE ".$query." ";
      }

   if ($order != NULL){
      $order = " ORDER BY ".$order." ";
      }

   if ($group != NULL){
      $group = " GROUP BY ".$group." ";
      } 

   if ($limit != NULL){
      $limit = " LIMIT ".$limit." ";
      } 

   if (!$select){
      $select = "*";
      }

    $final_query = "SELECT $select FROM sclm_contactsservicessla $query $group $order $limit";

    $contacts_ser_db = new DB_Sql();
    $contacts_ser_db->Database = DATABASE_NAME;
    $contacts_ser_db->User     = DATABASE_USER;
    $contacts_ser_db->Password = DATABASE_PASSWORD;
    $contacts_ser_db->Host     = DATABASE_HOST;
       
    $the_list = $contacts_ser_db->query($final_query);
   
    $cnt = 0;

    while ($the_row = mysql_fetch_array ($the_list)){
     
          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['contact_id'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['account_id'] = $the_row['account_id_c'];
          $returnpack[$cnt]['desired_credits'] = $the_row['desired_credits'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
          $returnpack[$cnt]['sclm_servicessla_id_c'] = $the_row['sclm_servicessla_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    $offset = 0;

    // Now Prepare Product
    $set_entry_params = array(
              'session' => $sugar_session_id,
              'module_name' => 'sclm_ContactsServicesSLA',
              'name_value_list'=> $params
                        );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;
  } // end switch contacts actions
   
 break; // end ContactsServicesSLA
 ###############################################
 case 'Content':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM sclm_content $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";

     $name_field_base = "name_";
     $content_field_base = "description_";

     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];

           $returnpack[$cnt]['cmn_industries_id_c'] = $the_row['cmn_industries_id_c'];

           if ($returnpack[$cnt]['cmn_industries_id_c']){
              $returnpack[$cnt]['cmn_industries_name'] = dlookup("cmn_industries", "name", "id='".$returnpack[$cnt]['cmn_industries_id_c']."'");
              $returnpack[$cnt]['parent_industry_id'] = dlookup("cmn_industries", "cmn_industries_id_c", "id='".$returnpack[$cnt]['cmn_industries_id_c']."'");
              $returnpack[$cnt]['parent_industry_name'] = dlookup("cmn_industries", "name", "id='".$returnpack[$cnt]['parent_industry_id']."'");
              }

           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['sclm_advisory_id_c'] = $the_row['sclm_advisory_id_c'];

           $returnpack[$cnt]['content_type'] = $the_row['content_type'];
           if ($returnpack[$cnt]['content_type']){
              $returnpack[$cnt]['content_type_name'] = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['content_type']."'");
              $returnpack[$cnt]['content_type_image'] = dlookup("sclm_configurationitems", "image_url", "id='".$returnpack[$cnt]['content_type']."'");
              }

           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];

           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

           # Collect all available lingos

           for ($x=0;$x<count($lingos);$x++) {

               $extension = $lingos[$x][0][0][0][0][0][0];

               if ($name_field_base == "name_x_c"){

                  $name_field_lingo = "name_".$extension."_c";
                  $content_field_lingo = "description_".$extension."_c";

                  } else {

                  $name_field_lingo = $name_field_base.$extension;
                  $content_field_lingo = $content_field_base.$extension;

                  } 

               if ($the_row[$name_field_lingo] == NULL){
                  $returnpack[$cnt][$name_field_lingo] = $the_row['name']; 
                  } else {
                  $returnpack[$cnt][$name_field_lingo] = $the_row[$name_field_lingo];
                  } 

               if ($the_row[$content_field_lingo] == NULL){
                  $returnpack[$cnt][$content_field_lingo] = $the_row['description']; 
                  } else {
                  $returnpack[$cnt][$content_field_lingo] = $the_row[$content_field_lingo];
                  } 

               } // end for loop

           # End Lingo Collection

           $returnpack[$cnt]['portal_content_type'] = $the_row['portal_content_type'];

           $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
           $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
           $returnpack[$cnt]['sclm_sow_id_c'] = $the_row['sclm_sow_id_c'];
           $returnpack[$cnt]['sclm_sowitems_id_c'] = $the_row['sclm_sowitems_id_c'];

           $returnpack[$cnt]['content_url'] = $the_row['content_url'];
           $returnpack[$cnt]['content_thumbnail'] = $the_row['content_thumbnail'];

           $returnpack[$cnt]['sclm_emails_id_c'] = $the_row['sclm_emails_id_c'];
           $returnpack[$cnt]['sclm_messages_id_c'] = $the_row['sclm_messages_id_c'];
           $returnpack[$cnt]['sclm_ticketing_id_c'] = $the_row['sclm_ticketing_id_c'];
           $returnpack[$cnt]['sclm_ticketingactivities_id_c'] = $the_row['sclm_ticketingactivities_id_c'];
           $returnpack[$cnt]['sclm_accountsservices_id_c'] = $the_row['sclm_accountsservices_id_c'];
           $returnpack[$cnt]['sclm_servicesprices_id_c'] = $the_row['sclm_servicesprices_id_c'];
           $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
           $returnpack[$cnt]['sclm_events_id_c'] = $the_row['sclm_events_id_c'];
           $returnpack[$cnt]['sclm_configurationitemtypes_id_c'] = $the_row['sclm_configurationitemtypes_id_c'];
           $returnpack[$cnt]['sclm_configurationitems_id_c'] = $the_row['sclm_configurationitems_id_c'];

           $returnpack[$cnt]['channel'] = $the_row['channel'];
           $returnpack[$cnt]['url'] = $the_row['url'];
           $returnpack[$cnt]['object_type'] = $the_row['object_type'];
           $returnpack[$cnt]['object_value'] = $the_row['object_value'];
           $returnpack[$cnt]['fee_type_id'] = $the_row['fee_type_id'];
           $returnpack[$cnt]['media_type_id'] = $the_row['media_type_id'];
           $returnpack[$cnt]['view_count'] = $the_row['view_count'];
           $returnpack[$cnt]['cmv_newscategories_id_c'] = $the_row['cmv_newscategories_id_c'];
           $returnpack[$cnt]['cmv_newstypes_id_c'] = $the_row['cmv_newstypes_id_c'];
           $returnpack[$cnt]['cmv_causes_id_c'] = $the_row['cmv_causes_id_c'];
           $returnpack[$cnt]['cmv_governments_id_c'] = $the_row['cmv_governments_id_c'];
           $returnpack[$cnt]['cmv_governmenttypes_id_c'] = $the_row['cmv_governmenttypes_id_c'];
           $returnpack[$cnt]['cmv_governmenttenders_id_c'] = $the_row['cmv_governmenttenders_id_c'];
           $returnpack[$cnt]['cmv_governmentroles_id_c'] = $the_row['cmv_governmentroles_id_c'];
           $returnpack[$cnt]['cmv_governmentpolicies_id_c'] = $the_row['cmv_governmentpolicies_id_c'];
           $returnpack[$cnt]['cmv_governmentlevels_id_c'] = $the_row['cmv_governmentlevels_id_c'];
           $returnpack[$cnt]['cmv_governmentconstitutions_id_c'] = $the_row['cmv_governmentconstitutions_id_c'];
           $returnpack[$cnt]['cmv_governmentbranches_id_c'] = $the_row['cmv_governmentbranches_id_c'];
           $returnpack[$cnt]['cmv_independentagencies_id_c'] = $the_row['cmv_independentagencies_id_c'];
           $returnpack[$cnt]['cmv_politicalparties_id_c'] = $the_row['cmv_politicalparties_id_c'];
           $returnpack[$cnt]['cmv_politicalpartyroles_id_c'] = $the_row['cmv_politicalpartyroles_id_c'];
           $returnpack[$cnt]['cmv_branchbodies_id_c'] = $the_row['cmv_branchbodies_id_c'];
           $returnpack[$cnt]['cmv_branchdepartments_id_c'] = $the_row['cmv_branchdepartments_id_c'];
           $returnpack[$cnt]['cmv_constitutionalamendments_id_c'] = $the_row['cmv_constitutionalamendments_id_c'];
           $returnpack[$cnt]['sclm_content_id_c'] = $the_row['sclm_content_id_c'];
           $returnpack[$cnt]['cmv_news_id_c'] = $the_row['cmv_news_id_c'];
           $returnpack[$cnt]['cmv_organisations_id_c'] = $the_row['cmv_organisations_id_c'];
           $returnpack[$cnt]['cmv_constitutionalarticles_id_c'] = $the_row['cmv_constitutionalarticles_id_c'];

           $returnpack[$cnt]['social_networking_id'] = $the_row['social_networking_id'];
           $returnpack[$cnt]['portal_account_id'] = $the_row['portal_account_id'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Content',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end Content
 ###############################################
 case 'Countries':
  
  switch ($action){
 
   case 'select':
    
    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = " WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

    $country_db = new DB_Sql();
    $country_db->Database = DATABASE_NAME;
    $country_db->User     = DATABASE_USER;
    $country_db->Password = DATABASE_PASSWORD;
    $country_db->Host     = DATABASE_HOST;
       
    $result = $country_db->query("SELECT $select FROM cmn_countries $query $group $order $limit");
    
    $cnt = 0;
    
    while ($the_row = mysql_fetch_array ($result)){
     
      $returnpack[$cnt]['id'] = $the_row['id'];       
      $returnpack[$cnt]['name'] = $the_row['name'];
      $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
      $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
      $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
      $returnpack[$cnt]['created_by'] = $the_row['created_by'];
      $returnpack[$cnt]['description'] = $the_row['description'];
      $returnpack[$cnt]['deleted'] = $the_row['deleted'];
      $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
      $returnpack[$cnt]['type'] = $the_row['type'];
      $returnpack[$cnt]['sub_type'] = $the_row['sub_type'];
      $returnpack[$cnt]['sovereignty'] = $the_row['sovereignty'];
      $returnpack[$cnt]['capital'] = $the_row['capital'];
      $returnpack[$cnt]['currency_code'] = $the_row['currency_code'];
      $returnpack[$cnt]['currency_name'] = $the_row['currency_name'];
      $returnpack[$cnt]['telephone_code'] = $the_row['telephone_code'];
      $returnpack[$cnt]['two_letter_code'] = $the_row['two_letter_code'];
      $returnpack[$cnt]['three_letter_code'] = $the_row['three_letter_code'];
      $returnpack[$cnt]['iso_number'] = $the_row['iso_number'];
      $returnpack[$cnt]['tld'] = $the_row['tld'];
      $returnpack[$cnt]['latitude'] = $the_row['latitude'];
      $returnpack[$cnt]['longitude'] = $the_row['longitude'];
      $returnpack[$cnt]['population'] = $the_row['population'];
      $returnpack[$cnt]['flag_id'] = $the_row['flag_id'];
      $returnpack[$cnt]['flag_image'] = $the_row['flag_image'];
      $returnpack[$cnt]['view_count'] = $the_row['view_count'];

      $cnt++;
     
    } // end while

   break; // end Select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmn_Countries',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
  break;

  } // end Action switch
 
 break; // end Countries object 
 ###############################################
 case 'CountryStates':
 
  switch ($action){
  
   case 'select_by_gov':
    
    if (is_array($params)){
     $query = $params[0];
     } else {
     $query = "";
     }
     
    if ($query != NULL){
     $query = "WHERE ".$query." ";
     }
      
    $states_db = new DB_Sql();
    $states_db->Database = DATABASE_NAME;
    $states_db->User     = DATABASE_USER;
    $states_db->Password = DATABASE_PASSWORD;
    $states_db->Host     = DATABASE_HOST;
     
    $the_list = $states_db->query("SELECT * FROM cmv_governmrnmentstates_c $query");

    $cnt = 0;
  
    while ($the_row = mysql_fetch_array ($the_list)){
       $id = $the_row['cmv_governe9e3tstates_idb'];
       $returnpack[$cnt]['state_id'] = $id;

       $cmv_governments_id_c = dlookup("cmv_governmentstates", "cmv_governments_id_c", "id='".$id."'");
       $returnpack[$cnt]['cmv_governments_id_c'] = $cmv_governments_id_c;

       $cmv_governmenttypes_id_c = dlookup("cmv_governmentstates", "cmv_governmenttypes_id_c", "id='".$id."'");
       $returnpack[$cnt]['cmv_governmenttypes_id_c'] = $cmv_governmenttypes_id_c;

       $cmv_governments_id1_c = dlookup("cmv_governmentstates", "cmv_governments_id1_c", "id='".$id."'");
       $returnpack[$cnt]['cmv_governments_id1_c'] = $cmv_governments_id1_c;

       $state_e = dlookup("cmv_governmentstates", "state_e", "id='".$id."'");
       $returnpack[$cnt]['state_e'] = $state_e;

       $state_j = dlookup("cmv_governmentstates", "state_j", "id='".$id."'");
       $returnpack[$cnt]['state_j'] = $state_j;
       
       $state_ch = dlookup("cmv_governmentstates", "state_ch", "id='".$id."'");
       $returnpack[$cnt]['state_ch'] = $state_ch;
        
        $cnt++;
        } // end while
       
    break; // end select
    case 'select':
    
     if (is_array($params)){
        $query = $params[0];
        $select = $params[1];
        $group = $params[2];
        $order = $params[3];
        $limit = $params[4];
        } else {
        $query = "";
        $select = "";
        $group = "";
        $order = "";
        $limit = "";
        }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM cmv_countrystates $query $group $order $limit";

     $states_db = new DB_Sql();
     $states_db->Database = DATABASE_NAME;
     $states_db->User     = DATABASE_USER;
     $states_db->Password = DATABASE_PASSWORD;
     $states_db->Host     = DATABASE_HOST;
     
     $the_list = $states_db->query($final_query);

     $cnt = 0;
  
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['state_e'] = $the_row['state_e'];
           $returnpack[$cnt]['state_j'] = $the_row['state_j'];
           $returnpack[$cnt]['state_ch'] = $the_row['state_ch'];
           $returnpack[$cnt]['cmv_governments_id_c'] = $the_row['cmv_governments_id_c'];
           $returnpack[$cnt]['cmv_governmenttypes_id_c'] = $the_row['cmv_governmenttypes_id_c'];
           $returnpack[$cnt]['cmv_governments_id1_c'] = $the_row['cmv_governments_id1_c'];
        
           $cnt++;

           } // end while
       
   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_CountryStates',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break; 
 
  } // end Action switch
 
 break; // end Country States object 
 ###############################################
 case 'Currencies':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if (!$select){
        $select = "*";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     $final_query = "SELECT $select FROM cmn_currencies $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['number_to_basic'] = $the_row['number_to_basic'];
           $returnpack[$cnt]['fractional'] = $the_row['fractional'];
           $returnpack[$cnt]['iso_code'] = $the_row['iso_code'];
           $returnpack[$cnt]['sign'] = $the_row['sign'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmn_Currencies',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end Currencies
 ###############################################
 case 'Emails':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    $final_query = "SELECT $select FROM sclm_emails $query $group $order $limit";

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query($final_query);

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
          $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
          $returnpack[$cnt]['sclm_ticketing_id_c'] = $the_row['sclm_ticketing_id_c'];
          $returnpack[$cnt]['sclm_ticketingactivities_id_c'] = $the_row['sclm_ticketingactivities_id_c'];
          $returnpack[$cnt]['name_en'] = $the_row['name_en'];
          $returnpack[$cnt]['name_ja'] = $the_row['name_ja'];
          $returnpack[$cnt]['description_en'] = $the_row['description_en'];
          $returnpack[$cnt]['description_ja'] = $the_row['description_ja'];
          $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          $returnpack[$cnt]['message_id'] = $the_row['message_id'];
          $returnpack[$cnt]['encode'] = $the_row['encode'];
          $returnpack[$cnt]['original_date'] = $the_row['original_date'];
          $returnpack[$cnt]['sender'] = $the_row['sender'];
          $returnpack[$cnt]['server'] = $the_row['server'];
          $returnpack[$cnt]['filter_id'] = $the_row['filter_id'];
          $returnpack[$cnt]['receiver'] = $the_row['receiver'];
          $returnpack[$cnt]['message_number'] = $the_row['message_number'];
          $returnpack[$cnt]['sclm_emails_id_c'] = $the_row['sclm_emails_id_c'];
          $returnpack[$cnt]['debug_mode'] = $the_row['debug_mode'];

          $cnt++;

          }

   break;
   case 'count':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "name_en";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT COUNT($select) as TOTALFOUND FROM sclm_emails $query $group $order $limit");

    $returnpack = mysql_result($the_list,0,"TOTALFOUND");

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Emails',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Emails
 ###############################################
 case 'ExternalSources':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if (!$select){
        $select = "*";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     $final_query = "SELECT $select FROM sfx_externalsources $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['api_url'] = $the_row['api_url'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['api_username'] = $the_row['api_username'];
           $returnpack[$cnt]['api_password'] = $the_row['api_password'];
           $returnpack[$cnt]['secret_key'] = $the_row['secret_key'];
           $returnpack[$cnt]['sfx_externalsourcetypes_id_c'] = $the_row['sfx_externalsourcetypes_id_c'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_ExternalSources',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end External Sources
 ###############################################
 case 'ExternalSourceTypes':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if (!$select){
        $select = "*";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     $final_query = "SELECT $select FROM sfx_externalsourcetypes $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_ExternalSourceTypes',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end External Sources
 ###############################################
 case 'Events':
 
  switch ($action){
    
   case 'select':    

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $order = "";
       $group = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($select == NULL){
       $select = "*";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       }

    $events_db = new DB_Sql();
    $events_db->Database = DATABASE_NAME;
    $events_db->User     = DATABASE_USER;
    $events_db->Password = DATABASE_PASSWORD;
    $events_db->Host     = DATABASE_HOST;
     
    $the_list = $events_db->query("SELECT $select FROM sclm_events $query $group $order $limit");
    
     $cnt = 0;
  
#     $fullquery = "SELECT $select FROM `sclm_events` $query $group $order $limit";

#     $events_db->query($fullquery);
#     $the_list = $events_db->resultset();

 
#     foreach ($the_list as $the_row) {

    while ($the_row = mysql_fetch_array ($the_list)){

        $returnpack[$cnt]['id'] = $the_row['id'];
        $returnpack[$cnt]['name'] = $the_row['name'];
        $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
        $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
        $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
        $returnpack[$cnt]['created_by'] = $the_row['created_by'];
        $returnpack[$cnt]['description'] = $the_row['description'];
        $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
        $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];

        $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
        $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];

        $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
        $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
        $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
        $returnpack[$cnt]['cmn_currencies_id_c'] = $the_row['cmn_currencies_id_c'];

        $returnpack[$cnt]['view_count'] = $the_row['view_count'];
        $returnpack[$cnt]['time_frame_id'] = $the_row['time_frame_id'];
        if ($the_row['time_frame_id']){
           $returnpack[$cnt]['time_frame'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['time_frame_id']."'");
           }

        $returnpack[$cnt]['sclm_events_id_c'] = $the_row['sclm_events_id_c'];
        if ($the_row['sclm_events_id_c']){
           $returnpack[$cnt]['parent_event_name'] = dlookup("sclm_events", "name", "id='".$the_row['sclm_events_id_c']."'");
           }

        $returnpack[$cnt]['start_date'] = $the_row['start_date'];
        $returnpack[$cnt]['end_date'] = $the_row['end_date'];

        $returnpack[$cnt]['object_type_id'] = $the_row['object_type_id'];
        $returnpack[$cnt]['object_value'] = $the_row['object_value'];

        $returnpack[$cnt]['street'] = $the_row['street'];
        $returnpack[$cnt]['city'] = $the_row['city'];
        $returnpack[$cnt]['state'] = $the_row['state'];
        $returnpack[$cnt]['zip'] = $the_row['zip'];
        $returnpack[$cnt]['latitude'] = $the_row['latitude'];
        $returnpack[$cnt]['longitude'] = $the_row['longitude'];
        $returnpack[$cnt]['fb_event_id'] = $the_row['fb_event_id'];
        $returnpack[$cnt]['event_url'] = $the_row['event_url'];
        $returnpack[$cnt]['location'] = $the_row['location'];

        $returnpack[$cnt]['value'] = $the_row['value'];
        $returnpack[$cnt]['positivity'] = $the_row['positivity'];
        $returnpack[$cnt]['probability'] = $the_row['probability'];

        $returnpack[$cnt]['group_type_id'] = $the_row['group_type_id'];
        if ($the_row['group_type_id']){
           $returnpack[$cnt]['group_type_name'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['group_type_id']."'");
           }

        $returnpack[$cnt]['value_type_id'] = $the_row['value_type_id'];
        if ($the_row['value_type_id']){
           $returnpack[$cnt]['value_type_name'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['value_type_id']."'");
           }

        $returnpack[$cnt]['purpose_id'] = $the_row['purpose_id'];
        if ($the_row['purpose_id']){
           $returnpack[$cnt]['purpose'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['purpose_id']."'");
           }

        $returnpack[$cnt]['emotion_id'] = $the_row['emotion_id'];
        if ($the_row['emotion_id']){
           $returnpack[$cnt]['emotion'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['emotion_id']."'");
           }

        $returnpack[$cnt]['ethics_id'] = $the_row['ethics_id'];
        if ($the_row['ethics_id']){
           $returnpack[$cnt]['ethics'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['ethics_id']."'");
           }

        $returnpack[$cnt]['sibaseunit_id'] = $the_row['sibaseunit_id'];
        if ($the_row['sibaseunit_id']){
           $returnpack[$cnt]['sibaseunit'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['sibaseunit_id']."'");
           }

        $returnpack[$cnt]['external_source_id'] = $the_row['external_source_id'];
        $returnpack[$cnt]['source_object_id'] = $the_row['source_object_id'];
        $returnpack[$cnt]['source_object_item_id'] = $the_row['source_object_item_id'];
        $returnpack[$cnt]['object_id'] = $the_row['object_id'];
        $returnpack[$cnt]['external_url'] = $the_row['external_url'];
        $returnpack[$cnt]['event_type'] = $the_row['event_type'];
        $returnpack[$cnt]['rsvp_status'] = $the_row['rsvp_status'];
        $returnpack[$cnt]['serial_number'] = $the_row['serial_number'];
        $returnpack[$cnt]['category_id'] = $the_row['category_id'];

        $returnpack[$cnt]['cmv_politicalparties_id_c'] = $the_row['cmv_politicalparties_id_c'];
        $returnpack[$cnt]['cmv_politicalpartyroles_id_c'] = $the_row['cmv_politicalpartyroles_id_c'];

        $returnpack[$cnt]['cmv_governments_id_c'] = $the_row['cmv_governments_id_c'];
        $returnpack[$cnt]['cmv_governmentroles_id_c'] = $the_row['cmv_governmentroles_id_c'];
        $returnpack[$cnt]['cmv_governmentpolicies_id_c'] = $the_row['cmv_governmentpolicies_id_c'];
        $returnpack[$cnt]['cmv_governmentconstitutions_id_c'] = $the_row['cmv_governmentconstitutions_id_c'];

        $returnpack[$cnt]['cmv_departmentagencies_id_c'] = $the_row['cmv_departmentagencies_id_c'];

        $returnpack[$cnt]['cmv_branchbodies_id_c'] = $the_row['cmv_branchbodies_id_c'];
        $returnpack[$cnt]['cmv_branchdepartments_id_c'] = $the_row['cmv_branchdepartments_id_c'];

        $returnpack[$cnt]['cmv_causes_id_c'] = $the_row['cmv_causes_id_c'];

        $returnpack[$cnt]['cmv_independentagencies_id_c'] = $the_row['cmv_independentagencies_id_c'];
        $returnpack[$cnt]['cmv_organisations_id_c'] = $the_row['cmv_organisations_id_c'];

        $returnpack[$cnt]['cmv_constitutionalarticles_id_c'] = $the_row['cmv_constitutionalarticles_id_c'];
        $returnpack[$cnt]['cmv_constitutionalamendments_id_c'] = $the_row['cmv_constitutionalamendments_id_c'];

        $returnpack[$cnt]['social_networking_id'] = $the_row['social_networking_id'];
        $returnpack[$cnt]['portal_account_id'] = $the_row['portal_account_id'];

        $returnpack[$cnt]['event_image_url'] = $the_row['event_image_url'];

        $returnpack[$cnt]['menstruation_phase_id'] = $the_row['menstruation_phase_id'];
        $returnpack[$cnt]['start_years'] = $the_row['start_years'];
        $returnpack[$cnt]['end_years'] = $the_row['end_years'];

        $returnpack[$cnt]['allow_joiners'] = $the_row['allow_joiners'];

        $cnt++;
     
      } // end while
    
    break; // end select action
    case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Events',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;
   
  } // end actions switch
  
 break; // end Events
 ###############################################
 case 'Industries':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM cmn_industries $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['cmn_industries_id_c'] = $the_row['cmn_industries_id_c'];


           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmn_Industries',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end Industries
 ###############################################
 case 'LeadSourcess':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM cmv_leadsources $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['cmv_lead_source_url'] = $the_row['cmv_lead_source_url'];
          $returnpack[$cnt]['cmv_lead_source_id'] = $the_row['cmv_lead_source_id'];
          $returnpack[$cnt]['sfx_externalsources_id_c'] = $the_row['sfx_externalsources_id_c'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_LeadSources',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end LeadSources
 ###############################################
 case 'Meetings':

  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM meetings $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['location'] = $the_row['location'];
           $returnpack[$cnt]['password'] = $the_row['password'];
           $returnpack[$cnt]['join_url'] = $the_row['join_url'];
           $returnpack[$cnt]['host_url'] = $the_row['host_url'];
           $returnpack[$cnt]['displayed_url'] = $the_row['displayed_url'];
           $returnpack[$cnt]['creator'] = $the_row['creator'];
           $returnpack[$cnt]['external_id'] = $the_row['external_id'];
           $returnpack[$cnt]['duration_hours'] = $the_row['duration_hours'];
           $returnpack[$cnt]['duration_minutes'] = $the_row['duration_minutes'];
           $returnpack[$cnt]['date_start'] = $the_row['date_start'];
           $returnpack[$cnt]['date_end'] = $the_row['date_end'];
           $returnpack[$cnt]['parent_type'] = $the_row['parent_type'];
           $returnpack[$cnt]['status'] = $the_row['status'];
           $returnpack[$cnt]['type'] = $the_row['type'];
           $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
           $returnpack[$cnt]['reminder_time'] = $the_row['reminder_time'];
           $returnpack[$cnt]['email_reminder_time'] = $the_row['email_reminder_time'];
           $returnpack[$cnt]['email_reminder_sent'] = $the_row['email_reminder_sent'];
           $returnpack[$cnt]['outlook_id'] = $the_row['outlook_id'];
           $returnpack[$cnt]['sequence'] = $the_row['sequence'];
           $returnpack[$cnt]['repeat_type'] = $the_row['repeat_type'];
           $returnpack[$cnt]['repeat_interval'] = $the_row['repeat_interval'];
           $returnpack[$cnt]['repeat_dow'] = $the_row['repeat_dow'];
           $returnpack[$cnt]['repeat_until'] = $the_row['repeat_until'];
           $returnpack[$cnt]['repeat_count'] = $the_row['repeat_count'];
           $returnpack[$cnt]['repeat_parent_id'] = $the_row['repeat_parent_id'];
           $returnpack[$cnt]['recurring_source'] = $the_row['recurring_source'];

           $cnt++;

          }

   break;
   case 'select_mix':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM meetings,meetings_cstm $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['location'] = $the_row['location'];
           $returnpack[$cnt]['password'] = $the_row['password'];
           $returnpack[$cnt]['join_url'] = $the_row['join_url'];
           $returnpack[$cnt]['host_url'] = $the_row['host_url'];
           $returnpack[$cnt]['displayed_url'] = $the_row['displayed_url'];
           $returnpack[$cnt]['creator'] = $the_row['creator'];
           $returnpack[$cnt]['external_id'] = $the_row['external_id'];
           $returnpack[$cnt]['duration_hours'] = $the_row['duration_hours'];
           $returnpack[$cnt]['duration_minutes'] = $the_row['duration_minutes'];
           $returnpack[$cnt]['date_start'] = $the_row['date_start'];
           $returnpack[$cnt]['date_end'] = $the_row['date_end'];
           $returnpack[$cnt]['parent_type'] = $the_row['parent_type'];
           $returnpack[$cnt]['status'] = $the_row['status'];
           $returnpack[$cnt]['type'] = $the_row['type'];
           $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
           $returnpack[$cnt]['reminder_time'] = $the_row['reminder_time'];
           $returnpack[$cnt]['email_reminder_time'] = $the_row['email_reminder_time'];
           $returnpack[$cnt]['email_reminder_sent'] = $the_row['email_reminder_sent'];
           $returnpack[$cnt]['outlook_id'] = $the_row['outlook_id'];
           $returnpack[$cnt]['sequence'] = $the_row['sequence'];
           $returnpack[$cnt]['repeat_type'] = $the_row['repeat_type'];
           $returnpack[$cnt]['repeat_interval'] = $the_row['repeat_interval'];
           $returnpack[$cnt]['repeat_dow'] = $the_row['repeat_dow'];
           $returnpack[$cnt]['repeat_until'] = $the_row['repeat_until'];
           $returnpack[$cnt]['repeat_count'] = $the_row['repeat_count'];
           $returnpack[$cnt]['repeat_parent_id'] = $the_row['repeat_parent_id'];
           $returnpack[$cnt]['recurring_source'] = $the_row['recurring_source'];

           $returnpack[$cnt]['id_c'] = $the_row['id_c'];
           $returnpack[$cnt]['jjwg_maps_lng_c'] = $the_row['jjwg_maps_lng_c'];
           $returnpack[$cnt]['jjwg_maps_lat_c'] = $the_row['jjwg_maps_lat_c'];
           $returnpack[$cnt]['jjwg_maps_geocode_status_c'] = $the_row['jjwg_maps_geocode_status_c'];
           $returnpack[$cnt]['jjwg_maps_address_c'] = $the_row['jjwg_maps_address_c'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

           $cnt++;

          }

   break;
   case 'select_cstm':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM meetings_cstm $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id_c'] = $the_row['id_c'];
           $returnpack[$cnt]['jjwg_maps_lng_c'] = $the_row['jjwg_maps_lng_c'];
           $returnpack[$cnt]['jjwg_maps_lat_c'] = $the_row['jjwg_maps_lat_c'];
           $returnpack[$cnt]['jjwg_maps_geocode_status_c'] = $the_row['jjwg_maps_geocode_status_c'];
           $returnpack[$cnt]['jjwg_maps_address_c'] = $the_row['jjwg_maps_address_c'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

           /* not created yet
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
           $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
           $returnpack[$cnt]['name_en'] = $the_row['name_en'];
           $returnpack[$cnt]['name_ja'] = $the_row['name_ja'];
           $returnpack[$cnt]['description_en'] = $the_row['description_en'];
           $returnpack[$cnt]['description_ja'] = $the_row['description_ja'];
           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
           $returnpack[$cnt]['sclm_messages_id_c'] = $the_row['sclm_messages_id_c'];
           $returnpack[$cnt]['has_been_read'] = $the_row['has_been_read'];
           $returnpack[$cnt]['has_been_replied'] = $the_row['has_been_replied'];
           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['extra_addressees'] = $the_row['extra_addressees'];
           */

           $cnt++;

          }

   break;
   case 'select_contacts';

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM meetings_contacts $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){


           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['meeting_id'] = $the_row['meeting_id'];
           $returnpack[$cnt]['contact_id'] = $the_row['contact_id'];
           $returnpack[$cnt]['required'] = $the_row['required'];
           $returnpack[$cnt]['accept_status'] = $the_row['accept_status'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];

           $cnt++;

          }

   break;
   case 'select_users';

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM meetings_users $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['meeting_id'] = $the_row['meeting_id'];
           $returnpack[$cnt]['user_id'] = $the_row['user_id'];
           $returnpack[$cnt]['required'] = $the_row['required'];
           $returnpack[$cnt]['accept_status'] = $the_row['accept_status'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Messages',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch
   
 break; // end LeadSources
 ###############################################
 case 'Messages':

  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM sclm_messages $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['account_id1_c'] = $the_row['account_id1_c'];
           $returnpack[$cnt]['contact_id1_c'] = $the_row['contact_id1_c'];
           $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
           $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
           $returnpack[$cnt]['name_en'] = $the_row['name_en'];
           $returnpack[$cnt]['name_ja'] = $the_row['name_ja'];
           $returnpack[$cnt]['description_en'] = $the_row['description_en'];
           $returnpack[$cnt]['description_ja'] = $the_row['description_ja'];
//           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
           $returnpack[$cnt]['sclm_messages_id_c'] = $the_row['sclm_messages_id_c'];
           $returnpack[$cnt]['has_been_read'] = $the_row['has_been_read'];
           $returnpack[$cnt]['has_been_replied'] = $the_row['has_been_replied'];
/*
           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];

*/
          $returnpack[$cnt]['extra_addressees'] = $the_row['extra_addressees'];
          $returnpack[$cnt]['sn_cit'] = $the_row['sn_cit'];
          $returnpack[$cnt]['sn_object_id'] = $the_row['sn_object_id'];
          $returnpack[$cnt]['sn_ci'] = $the_row['sn_ci'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Messages',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch
   
 break;
 ###############################################
 case 'Modules':

  switch ($action){

   case 'set_modules':

    if ($params[0] == 'Administrators' && $params[2] == 'Contacts'){
       $table = "cmv_adminisors_contacts_c";
       $column_one = 'cmv_adminif2a7trators_ida';
       $column_two = 'cmv_admini08d5ontacts_idb';
       }

    if ($params[0] == 'Effects' && $params[2] == 'Effects'){
       $table = "sfx_effects_sfx_effects_c";
       $column_one = 'sfx_effects_sfx_effectssfx_effects_ida';
       $column_two = 'sfx_effects_sfx_effectssfx_effects_idb';
       }

     // Should check if exists first, but...time!!
    if (!class_exists('funky')){
       include ("funky.php");
       }

     $funky_gear = new funky ();

     $id = $funky_gear->create_guid();
     $date = date("Y-m-d G:i:s");
     $mods_query = "INSERT INTO $table (id,date_modified,deleted,`".$column_one."`,`".$column_two."`) VALUES ('".$id."','".$date."',0,'".$params[1]."','".$params[3]."');";

     $mods_query_alter = "INSERT INTO $table (id,date_modified,deleted,`".$column_one."`,`".$column_two."`) VALUES ('".$id."','".$date."',0,'".$params[3]."','".$params[1]."');";

     $mods_db = new DB_Sql();
     $mods_db->Database = DATABASE_NAME;
     $mods_db->User     = DATABASE_USER;
     $mods_db->Password = DATABASE_PASSWORD;
     $mods_db->Host     = DATABASE_HOST;
     
     $mods_db->query($mods_query);
     $mods_db->query($mods_query_alter);

     $returnpack = $id;

   break; // end action set_modules 
   case 'set_modules_soap':
    
    $set_rel_params = array(
              'session' => $sugar_session_id,
              'set_relationship_value'=>array(
                            'module1'=> $params[0],
                            'module1_id'=> $params[1],
                            'module2' => $params[2],
                            'module2_id'=> $params[3]
                            )
                        );

     $returnpack = $soapclient->call('set_relationship',$set_rel_params); 

     //var_dump($returnpack);

   break; // end action set_modules 
   case 'get_all':

    $offset = 0;
    $returner = false;

/*
    $phpsoapclient = new SoapClient('http://jp.saloob.com/crm/soap.php?wsdl'); // create a PHP SOAP object that uses SUGAR WSDL definitions in remote soap.php file
    
    // setup parameters to send to function through the SOAP object
    $user_auth = array( 
        'user_name' => $api_user, 
        'password' => md5($api_pass),
        'version' => $phpsoapclient->get_server_version()
    );

    $application = "RealPolitika.org";

    // call SUGAR WSDL login function as method of PHP SOAP object
    $result = $phpsoapclient->login($user_auth,$application);
    $sugar_session_id = $result->id;
*/
    $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass), 'version' => '0.1'));

    $soapclient = new nusoap_client($crm_wsdl_url);

    $login_results = $soapclient->call('login',$auth_array,'RealPolitika.org');
    $sugar_session_id = $login_results['id'];

    //echo '<br><br><b>Get list of Modules:</b><BR>';
    $result = $soapclient->call('get_available_modules', $sugar_session_id);
    //echo '<b>HERE IS ERRORS:</b><BR>';
    //echo $soapclient->error_str;

    //echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
    //echo $soapclient->response;

    //echo '<BR><BR><b>HERE IS RESULT:</b><BR>';

    foreach ($result['modules'] as $key => $value){

            //echo $key.'=>'.$value.'<br />';

	        // If param sent - use to check for a module
            if ($params != NULL){

	            if ($value == $params){

                   $returner = true;

                   } // end if true

                } // end if params

            } // end forloop for modules
    
   $returnpack = $result;

   return $returnpack;

   break; // end action get_all 
   case 'get_all_external':

    $offset = 0;
    $returner = false;

    $crm_api_user2 = $params[0];
    $crm_api_pass2 = $params[1];
    $crm_wsdl_url2 = $params[2];
    $selected_module = $params[3];

    $_SESSION["sugarsoapsessionid"] = "";

    $soaper = sugarsession ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2);

/*
    $soapClient->soap_defencoding = 'UTF-8';
    $soapClient->decode_utf8 = false;
*/
    $soapclient = $soaper[0];
    $sugar_session_id = $soaper[1];

echo "<P>SESS: ".$sugar_session_id."<P>";

    //echo '<br><br><b>Get list of Modules:</b><BR>';
//    $result = $soapclient->call('get_available_modules', $sugar_session_id);
    $result = $soapclient->call('get_available_modules', array('session'=>$sugar_session_id,'max_results'=>$limit,'deleted'=>'0'));

    //echo '<b>HERE IS ERRORS:</b><BR>';
    //echo $soapclient->error_str;

    //echo '<BR><BR><b>HERE IS RESPONSE:</b><BR>';
    //echo $soapclient->response;

    //echo '<BR><BR><b>HERE IS RESULT:</b><BR>';

    foreach ($result['modules'] as $key => $value){

            echo $key.'=>'.$value.'<br />';

	        // If param sent - use to check for a module
            if ($params[3] != NULL){

	            if ($value == $params[3]){

                       $returner = true;

                   } // end if true

                } // end if params

            } // end forloop for modules
    
   $returnpack = $result;

   return $returnpack;

   break;
   case 'get_module_items':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $module = $params[5];
       } else {
       $query = "";
       $select = array();
       $group = "";
       $order = "";
       $limit = "";
       $module = "";
       }
 
    $offset = 0;
 
//echo "<P> $api_user, $api_pass, $crm_wsdl_url <P>";

/*
    $soaper = sugarsession ($api_user, $api_pass, $crm_wsdl_url);
    $soapclient = $soaper[0];
    $sugar_session_id = $soaper[1];
*/
  	 $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass), 'version' => '0.1'));

 require_once ("nusoap/nusoap.php");

	 $soapclient = new nusoap_client($crm_wsdl_url);
	 $login_results = $soapclient->call('login',$auth_array,'Scalastica.com');

//var_dump($login_results);

	 $sugar_session_id = $login_results['id'];

//echo "SugarSess".$sugar_session_id;

 	 $limit = "";
    
    $result = $soapclient->call('get_entry_list',array(
'session'=>$sugar_session_id,
'module_name'=>$module,
'query'=>$query,
'order_by'=>$order,
'offset'=>$offset,
'select_fields'=>$select,
'max_results'=>$limit,
'deleted'=>'0',
));

//	 $result = $soapclient->call('get_available_modules', array('session'=>$sugar_session_id,'max_results'=>$limit,'deleted'=>'0'));
        
//echo "Module: $module <P>";
//    var_dump($result);
//    $gotten = $soapclient->response;

    $cnt = 0;

    $returnpack = $result;
/*
    foreach ($result['entry_list'] as $gotten){

          $the_row = nameValuePairToSimpleArray($gotten['name_value_list']);
     
           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
/*
           $returnpack[$cnt]['account_type'] = $the_row['account_type'];
           $returnpack[$cnt]['industry'] = $the_row['industry'];
           $returnpack[$cnt]['annual_revenue'] = $the_row['annual_revenue'];
           $returnpack[$cnt]['phone_fax'] = $the_row['phone_fax'];
           $returnpack[$cnt]['billing_address_street'] = $the_row['billing_address_street'];
           $returnpack[$cnt]['billing_address_city'] = $the_row['billing_address_city'];
           $returnpack[$cnt]['billing_address_state'] = $the_row['billing_address_state'];
           $returnpack[$cnt]['billing_address_postalcode'] = $the_row['billing_address_postalcode'];
           $returnpack[$cnt]['billing_address_country'] = $the_row['billing_address_country'];
           $returnpack[$cnt]['rating'] = $the_row['rating'];
           $returnpack[$cnt]['phone_office'] = $the_row['phone_office'];
           $returnpack[$cnt]['phone_alternate'] = $the_row['phone_alternate'];
           $returnpack[$cnt]['website'] = $the_row['website'];
           $returnpack[$cnt]['ownership'] = $the_row['ownership'];
           $returnpack[$cnt]['employees'] = $the_row['employees'];
           $returnpack[$cnt]['ticker_symbol'] = $the_row['ticker_symbol'];
           $returnpack[$cnt]['shipping_address_street'] = $the_row['shipping_address_street'];
           $returnpack[$cnt]['shipping_address_city'] = $the_row['shipping_address_city'];
           $returnpack[$cnt]['shipping_address_state'] = $the_row['shipping_address_state'];
           $returnpack[$cnt]['shipping_address_postalcode'] = $the_row['shipping_address_postalcode'];
           $returnpack[$cnt]['shipping_address_country'] = $the_row['shipping_address_country'];
           $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
           $returnpack[$cnt]['sic_code'] = $the_row['sic_code'];
           $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];
           $returnpack[$cnt]['cmv_statuses_id_c'] = $the_row['cmv_statuses_id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
*/

//          $cnt++;

  //        } // end foreach

   break;

  } // end action switch
   
 break;
 ###############################################
 case 'News':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM cmv_news $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['title_e'] = $the_row['title_e'];
           $returnpack[$cnt]['title_j'] = $the_row['title_j'];
           $returnpack[$cnt]['title_ch'] = $the_row['title_ch'];
           $returnpack[$cnt]['title_fr'] = $the_row['title_fr'];
           $returnpack[$cnt]['title_de'] = $the_row['title_de'];
           $returnpack[$cnt]['title_ru'] = $the_row['title_ru'];
           $returnpack[$cnt]['news_e'] = $the_row['news_e'];
           $returnpack[$cnt]['news_j'] = $the_row['news_j'];
           $returnpack[$cnt]['news_ch'] = $the_row['news_ch'];
           $returnpack[$cnt]['news_fr'] = $the_row['news_fr'];
           $returnpack[$cnt]['news_de'] = $the_row['news_de'];
           $returnpack[$cnt]['news_ru'] = $the_row['news_ru'];
           $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
           $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c']; // author
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c']; 
           $returnpack[$cnt]['view_count'] = $the_row['view_count'];
           $returnpack[$cnt]['url'] = $the_row['url'];
           $returnpack[$cnt]['cmv_statuses_id_c'] = $the_row['cmv_statuses_id_c'];
           $returnpack[$cnt]['cmv_governments_id_c'] = $the_row['cmv_governments_id_c'];
           $returnpack[$cnt]['cmv_governmentbranches_id_c'] = $the_row['cmv_governmentbranches_id_c'];
           $returnpack[$cnt]['cmv_branchbodies_id_c'] = $the_row['cmv_branchbodies_id_c'];
           $returnpack[$cnt]['cmv_branchdepartments_id_c'] = $the_row['cmv_branchdepartments_id_c'];
           $returnpack[$cnt]['cmv_departmentagencies_id_c'] = $the_row['cmv_departmentagencies_id_c'];
           $returnpack[$cnt]['cmv_governmentconstitutions_id_c'] = $the_row['cmv_governmentconstitutions_id_c'];
           $returnpack[$cnt]['cmv_constitutionalarticles_id_c'] = $the_row['cmv_constitutionalarticles_id_c'];
           $returnpack[$cnt]['cmv_events_id_c'] = $the_row['cmv_events_id_c'];
           $returnpack[$cnt]['cmv_governmentpolicies_id_c'] = $the_row['cmv_governmentpolicies_id_c'];
           $returnpack[$cnt]['cmv_governmentroles_id_c'] = $the_row['cmv_governmentroles_id_c'];
           $returnpack[$cnt]['cmv_governmenttenders_id_c'] = $the_row['cmv_governmenttenders_id_c'];
           $returnpack[$cnt]['cmv_laws_id_c'] = $the_row['cmv_laws_id_c'];
           $returnpack[$cnt]['cmv_lawcases_id_c'] = $the_row['cmv_lawcases_id_c'];
           $returnpack[$cnt]['cmv_politicalparties_id_c'] = $the_row['cmv_politicalparties_id_c'];
           $returnpack[$cnt]['cmv_statutes_id_c'] = $the_row['cmv_statutes_id_c'];
           $returnpack[$cnt]['cmv_bills_id_c'] = $the_row['cmv_bills_id_c'];
           $returnpack[$cnt]['cmv_causes_id_c'] = $the_row['cmv_causes_id_c'];
           $returnpack[$cnt]['cmv_nominees_id_c'] = $the_row['cmv_nominees_id_c'];
           $returnpack[$cnt]['cmv_politicalpartyroles_id_c'] = $the_row['cmv_politicalpartyroles_id_c'];
           $returnpack[$cnt]['cmv_independentagencies_id_c'] = $the_row['cmv_independentagencies_id_c'];
           $returnpack[$cnt]['cmv_organisations_id_c'] = $the_row['cmv_organisations_id_c'];
           $returnpack[$cnt]['newsmaker_status'] = $the_row['newsmaker_status'];
           $returnpack[$cnt]['cmv_newscategories_id_c'] = $the_row['cmv_newscategories_id_c'];

           $cnt++;

          }

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_News',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break;

  } // end action switch

 break; // end News
 ###############################################
 case 'Opportunities':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM opportunities $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['opportunity_type'] = $the_row['opportunity_type'];
          $returnpack[$cnt]['campaign_id'] = $the_row['campaign_id'];
          $returnpack[$cnt]['lead_source'] = $the_row['lead_source'];
          $returnpack[$cnt]['amount'] = $the_row['amount'];
          $returnpack[$cnt]['currency_id'] = $the_row['currency_id'];
          $returnpack[$cnt]['date_closed'] = $the_row['date_closed'];
          $returnpack[$cnt]['next_step'] = $the_row['next_step'];
          $returnpack[$cnt]['sales_stage'] = $the_row['sales_stage'];
          $returnpack[$cnt]['probability'] = $the_row['probability'];

          $returnpack[$cnt]['account_id_c'] = dlookup("opportunities_cstm", "account_id_c", "id_c='".$the_row['id']."'");
          $returnpack[$cnt]['contact_id_c'] = dlookup("opportunities_cstm", "contact_id_c", "id_c='".$the_row['id']."'");
          $returnpack[$cnt]['cmn_statuses_id_c'] = dlookup("opportunities_cstm", "cmn_statuses_id_c", "id_c='".$the_row['id']."'");
          
          $cnt++;

          }

   break;
   case 'select_cstm':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM opportunities_cstm $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id_c'] = $the_row['id_c'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          
          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'Opportunities',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Opportunities
 ###############################################
 case 'Relationships':
 case 'relationships':

  switch ($action){

   case 'get_contact_relationships':

    $set_rel_params = array('session' => $sugar_session_id,'id'=>$params[0]);

    $gotten = $soapclient->call('get_contact_relationships',$set_rel_params);

    $cnt = 0;
    foreach ($result['contact_detail_array'] as $gotten){

      $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);

      $returnpack[$cnt][0] = $fieldarray['id'];
      //echo $crmparams[$cnt][0];
            
      } // end foreach
            
      //var_dump($returnpack);

   break; // end action get_all

  } // end realtionship actions

 break; // end object relationships  
 ###############################################
 case 'Projects':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingo = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingo = "name_en_c";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM project $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['estimated_start_date'] = $the_row['estimated_start_date'];
           $returnpack[$cnt]['estimated_end_date'] = $the_row['estimated_end_date'];
           $returnpack[$cnt]['status'] = $the_row['status'];

           if ($the_row['status'] == NULL){
              $returnpack[$cnt]['status'] = 'f0cd169d-411d-c1e2-5458-52a443232050';
              }

           $returnpack[$cnt]['status_image'] = dlookup("sclm_configurationitems", "image_url", "id='".$returnpack[$cnt]['status']."'");

echo $lingo;

           $returnpack[$cnt]['status_name'] = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['status']."'");

           $returnpack[$cnt]['priority'] = $the_row['priority'];

           $returnpack[$cnt]['account_id1_c'] = dlookup("project_cstm", "account_id1_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['contact_id1_c'] = dlookup("project_cstm", "contact_id1_c", "id_c='".$the_row['id']."'");


           $cnt++;

          }

   break;
   case 'select_cstm':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM project_cstm $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id_c'] = $the_row['id_c'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['name_en_c'] = $the_row['name_en_c'];
           $returnpack[$cnt]['name_ja_c'] = $the_row['name_ja_c'];
           $returnpack[$cnt]['description_en_c'] = $the_row['description_en_c'];
           $returnpack[$cnt]['description_ja_c'] = $the_row['description_ja_c'];
           $returnpack[$cnt]['project_process_stage_c'] = $the_row['project_process_stage_c'];
           $returnpack[$cnt]['itil_stage_c'] = $the_row['itil_stage_c'];
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
           $returnpack[$cnt]['account_id1_c'] = $the_row['account_id1_c'];
           $returnpack[$cnt]['contact_id1_c'] = $the_row['contact_id1_c'];

           $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'Project',
              'name_value_list'=> $params
    );

    // Now Add the Laws
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add project

  } // end action switch

 break; // end Projects
 ###############################################
 case 'ProjectTasks':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $prequery = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $prequery = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM project_task $prequery $query $group $order $limit";

     $project_task_db = new DB_Sql();
     $project_task_db->Database = DATABASE_NAME;
     $project_task_db->User     = DATABASE_USER;
     $project_task_db->Password = DATABASE_PASSWORD;
     $project_task_db->Host     = DATABASE_HOST;
     
     $the_list = $project_task_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['project_id'] = $the_row['project_id'];
           $returnpack[$cnt]['project_task_id'] = $the_row['project_task_id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['status'] = $the_row['status'];

           if ($the_row['status'] == NULL){
              $returnpack[$cnt]['status'] = 'f0cd169d-411d-c1e2-5458-52a443232050';
              }

           $returnpack[$cnt]['status_image'] = dlookup("sclm_configurationitems", "image_url", "id='".$returnpack[$cnt]['status']."'");
           $returnpack[$cnt]['status_name'] = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['status']."'");

           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['predecessors'] = $the_row['predecessors'];
           $returnpack[$cnt]['date_start'] = $the_row['date_start'];
           $returnpack[$cnt]['time_start'] = $the_row['time_start'];
           $returnpack[$cnt]['time_finish'] = $the_row['time_finish'];
           $returnpack[$cnt]['date_finish'] = $the_row['date_finish'];
           $returnpack[$cnt]['duration'] = $the_row['duration'];
           $returnpack[$cnt]['duration_unit'] = $the_row['duration_unit'];
           $returnpack[$cnt]['actual_duration'] = $the_row['actual_duration'];
           $returnpack[$cnt]['percent_complete'] = $the_row['percent_complete'];
           $returnpack[$cnt]['date_due'] = $the_row['date_due'];
           $returnpack[$cnt]['time_due'] = $the_row['time_due'];
           $returnpack[$cnt]['parent_task_id'] = $the_row['parent_task_id'];
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['priority'] = $the_row['priority'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['milestone_flag'] = $the_row['milestone_flag'];
           $returnpack[$cnt]['order_number'] = $the_row['order_number'];
           $returnpack[$cnt]['task_number'] = $the_row['task_number'];
           $returnpack[$cnt]['estimated_effort'] = $the_row['estimated_effort'];
           $returnpack[$cnt]['actual_effort'] = $the_row['actual_effort'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];
           $returnpack[$cnt]['utilization'] = $the_row['utilization'];

           $returnpack[$cnt]['account_id_c'] = dlookup("project_task_cstm", "account_id_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['contact_id_c'] = dlookup("project_task_cstm", "contact_id_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['itil_stage_c'] = dlookup("project_cstm", "itil_stage_c", "id_c='".$the_row['project_id']."'");           
//           $returnpack[$cnt]['itil_stage_c'] = dlookup("project_task_cstm", "itil_stage_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['itil_stage_process_c'] = dlookup("project_task_cstm", "itil_stage_process_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['name_en_c'] = dlookup("project_task_cstm", "name_en_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['name_ja_c'] = dlookup("project_task_cstm", "name_ja_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['description_en_c'] = dlookup("project_task_cstm", "description_en_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['description_ja_c'] = dlookup("project_task_cstm", "description_ja_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['projecttask_id_c'] = dlookup("project_task_cstm", "projecttask_id_c", "id_c='".$the_row['id']."'");
           if ($returnpack[$cnt]['projecttask_id_c'] != NULL){
              $returnpack[$cnt]['parent_projecttask_id_c'] = dlookup("project_task_cstm", "projecttask_id_c", "id_c='".$returnpack[$cnt]['projecttask_id_c']."'");
              }

           $returnpack[$cnt]['cmn_statuses_id_c'] = dlookup("project_task_cstm", "cmn_statuses_id_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['account_id1_c'] = dlookup("project_task_cstm", "account_id1_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['contact_id1_c'] = dlookup("project_task_cstm", "contact_id1_c", "id_c='".$the_row['id']."'");
           $returnpack[$cnt]['contact_id2_c'] = dlookup("project_task_cstm", "contact_id2_c", "id_c='".$the_row['id']."'");

           $cnt++;

          }

   break;
   case 'select_cstm':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $prequery = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $prequery = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM project_task_cstm $prequery $query $group $order $limit";

     $project_task_cstm_db = new DB_Sql();
     $project_task_cstm_db->Database = DATABASE_NAME;
     $project_task_cstm_db->User     = DATABASE_USER;
     $project_task_cstm_db->Password = DATABASE_PASSWORD;
     $project_task_cstm_db->Host     = DATABASE_HOST;
     
     $the_list = $project_task_cstm_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id_c'] = $the_row['id_c'];
           $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
           $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
           $returnpack[$cnt]['name_en_c'] = $the_row['name_en_c'];
           $returnpack[$cnt]['name_ja_c'] = $the_row['name_ja_c'];
           $returnpack[$cnt]['description_en_c'] = $the_row['description_en_c'];
           $returnpack[$cnt]['description_ja_c'] = $the_row['description_ja_c'];
           $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];

           $returnpack[$cnt]['date_start'] = dlookup("project_task", "date_start", "id='".$the_row['id_c']."'");
           $returnpack[$cnt]['date_finish'] = dlookup("project_task", "date_finish", "id='".$the_row['id_c']."'");
           $returnpack[$cnt]['date_due'] = dlookup("project_task", "date_due", "id='".$the_row['id_c']."'");
           $returnpack[$cnt]['task_number'] = dlookup("project_task", "task_number", "id='".$the_row['id_c']."'");
           $returnpack[$cnt]['name'] = dlookup("project_task", "name", "id='".$the_row['id_c']."'");

           $returnpack[$cnt]['percent_complete'] = dlookup("project_task", "percent_complete", "id='".$the_row['id_c']."'");

           $returnpack[$cnt]['status'] = dlookup("project_task", "status", "id='".$the_row['id_c']."'");
           if ($returnpack[$cnt]['status'] == NULL){
              $returnpack[$cnt]['status'] = 'f0cd169d-411d-c1e2-5458-52a443232050';
              }
           $returnpack[$cnt]['status_image'] = dlookup("sclm_configurationitems", "image_url", "id='".$returnpack[$cnt]['status']."'");
           $returnpack[$cnt]['status_name'] = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['status']."'");
           $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
           $returnpack[$cnt]['account_id1_c'] = $the_row['account_id1_c']; # Project Manager Provider
           $returnpack[$cnt]['contact_id1_c'] = $the_row['contact_id1_c']; # Project Manager Contact
           $returnpack[$cnt]['contact_id2_c'] = $the_row['contact_id2_c']; # Project Task Assignee Contact

           $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'ProjectTask',
              'name_value_list'=> $params
    );

    // Now Add the Laws
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add project

  } // end action switch

 break; // end ProjectTasks
 ###############################################
 case 'SearchKeywords':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        } 

     if (!$select){
        $select = "*";
        }

     $final_query = "SELECT $select FROM cmn_searchkeywords $query $group $order $limit";

     $content_db = new DB_Sql();
     $content_db->Database = DATABASE_NAME;
     $content_db->User     = DATABASE_USER;
     $content_db->Password = DATABASE_PASSWORD;
     $content_db->Host     = DATABASE_HOST;
     
     $the_list = $content_db->query($final_query);

     $cnt = 0;
     $returnpack = "";
     
     while ($the_row = mysql_fetch_array ($the_list)){

           $returnpack[$cnt]['id'] = $the_row['id'];
           $returnpack[$cnt]['name'] = $the_row['name'];
           $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
           $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
           $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
           $returnpack[$cnt]['created_by'] = $the_row['created_by'];
           $returnpack[$cnt]['description'] = $the_row['description'];
           $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
           $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
           $returnpack[$cnt]['search_count'] = $the_row['search_count'];
           $returnpack[$cnt]['sclm_leadsources_id_c'] = $the_row['sclm_leadsources_id_c'];

           $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmn_SearchKeywords',
              'name_value_list'=> $params
    );

    // Now Add the Laws
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content
   case 'create_stats':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmn_SearchKeywordStats',
              'name_value_list'=> $params
    );

    // Now Add the Laws
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Stats
 ###############################################
 case 'SearchKeywordStats':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM cmn_searchkeywordstats $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
          $returnpack[$cnt]['cmn_searchkeywords_id_c'] = $the_row['cmn_searchkeywords_id_c'];
          $returnpack[$cnt]['ip'] = $the_row['ip'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['search_count'] = $the_row['search_count'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmn_SearchKeywordStats',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end KeywordStats
 ###############################################
 case 'Security':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "name_en";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $final_query = "SELECT $select FROM sclm_security $query $group $order $limit";

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query($final_query);

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];

          $returnpack[$cnt]['system_module'] = $the_row['system_module'];
          if ($the_row['system_module']){
             $returnpack[$cnt]['system_module_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_module']."'");             
             }

          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];

          $returnpack[$cnt]['system_action_create'] = $the_row['system_action_create'];
          if ($the_row['system_action_create']){
             $returnpack[$cnt]['system_action_create_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_create']."'");             
             }

          $returnpack[$cnt]['system_action_delete'] = $the_row['system_action_delete'];
          if ($the_row['system_action_delete']){
             $returnpack[$cnt]['system_action_delete_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_delete']."'");             
             }

          $returnpack[$cnt]['system_action_edit'] = $the_row['system_action_edit'];
          if ($the_row['system_action_edit']){
             $returnpack[$cnt]['system_action_edit_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_edit']."'");             
             }

          $returnpack[$cnt]['system_action_export'] = $the_row['system_action_export'];
          if ($the_row['system_action_export']){
             $returnpack[$cnt]['system_action_export_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_export']."'");             
             }
          $returnpack[$cnt]['system_action_import'] = $the_row['system_action_import'];
          if ($the_row['system_action_import']){
             $returnpack[$cnt]['system_action_import_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_import']."'");             
             }
          $returnpack[$cnt]['system_action_view_details'] = $the_row['system_action_view_details'];
          if ($the_row['system_action_view_details']){
             $returnpack[$cnt]['system_action_view_details_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_view_details']."'");             
             }
          $returnpack[$cnt]['system_action_view_list'] = $the_row['system_action_view_list'];
          if ($the_row['system_action_view_list']){
             $returnpack[$cnt]['system_action_view_list_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['system_action_view_list']."'");             
             }

          $returnpack[$cnt]['role'] = $the_row['role'];
          if ($the_row['role']){
             $returnpack[$cnt]['role_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['role']."'");             
             }

          $returnpack[$cnt]['access'] = $the_row['access'];
          if ($the_row['access']){
             $returnpack[$cnt]['access_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['access']."'");             
             }

          $returnpack[$cnt]['security_item_type'] = $the_row['security_item_type'];
          if ($the_row['security_item_type']){
             $returnpack[$cnt]['security_item_type_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['security_item_type']."'");
             }

          $returnpack[$cnt]['security_level'] = $the_row['security_level'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Security',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Security
 ###############################################
 case 'Services':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $othertable = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $othertable = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    if ($othertable != NULL){
       $othertable = ",".$othertable;
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_services$othertable $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['service_type'] = $the_row['service_type'];
          $returnpack[$cnt]['market_value'] = $the_row['market_value'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['service_tier'] = $the_row['service_tier'];
          $returnpack[$cnt]['image'] = $the_row['image'];

          if ($returnpack[$cnt]['service_tier']){
             $service_tier_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_tier']."'");
             $returnpack[$cnt]['service_tier_name'] = $service_tier_name;
             }

          $returnpack[$cnt]['service_type'] = $the_row['service_type'];
          if ($returnpack[$cnt]['service_type']){
             $service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_type']."'");
             $returnpack[$cnt]['service_type_name'] = $service_type_name;
             }

          $returnpack[$cnt]['parent_service_type'] = $the_row['parent_service_type'];
          if ($returnpack[$cnt]['parent_service_type']){
             $parent_service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['parent_service_type']."'");
             $returnpack[$cnt]['parent_service_type_name'] = $parent_service_type_name;
             }

          $returnpack[$cnt]['lifestyle_category'] = $the_row['lifestyle_category'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Services',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Services
 ###############################################
 case 'ServicesPrices':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_servicesprices $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
          $returnpack[$cnt]['cmn_currencies_id_c'] = $the_row['cmn_currencies_id_c'];
          $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['sclm_servicessla_id_c'] = $the_row['sclm_servicessla_id_c'];
          $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
          $returnpack[$cnt]['credits'] = $the_row['credits'];
          $returnpack[$cnt]['timezone'] = $the_row['timezone'];

          if ($the_row['image'] == NULL){
             if ($the_row['sclm_services_id_c'] != NULL){
                $returnpack[$cnt]['image'] = dlookup("sclm_services", "image", "id='".$returnpack[$cnt]['sclm_services_id_c']."'");
                } 
             } else {
             $returnpack[$cnt]['image'] = $the_row['image'];
             } 

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_ServicesPrices',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end ServicesPrices
 ###############################################
 case 'ServicesSLA':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_servicessla $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
          $returnpack[$cnt]['sclm_sla_id_c'] = $the_row['sclm_sla_id_c'];
          $returnpack[$cnt]['service_tier'] = $the_row['service_tier'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

          if ($returnpack[$cnt]['service_tier']){
             $service_tier_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_tier']."'");
             $returnpack[$cnt]['service_tier_name'] = $service_tier_name;
             }

          if ($returnpack[$cnt]['sclm_sla_id_c']){
             $sclm_sla_name = dlookup("sclm_sla", "name", "id='".$returnpack[$cnt]['sclm_sla_id_c']."'");
             $returnpack[$cnt]['sclm_sla_name'] = $sclm_sla_name;
             }

/*
          $returnpack[$cnt]['service_type'] = $the_row['service_type'];
          $returnpack[$cnt]['market_value'] = $the_row['market_value'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];

          $returnpack[$cnt]['service_type_id'] = $the_row['service_type'];
          if ($returnpack[$cnt]['service_type_id']){
             $service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_type_id']."'");
             $returnpack[$cnt]['service_type_name'] = $service_type_name;
             }

          $returnpack[$cnt]['parent_service_type_id'] = $the_row['parent_service_type'];
          if ($returnpack[$cnt]['parent_service_type_id']){
             $parent_service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['parent_service_type_id']."'");
             $returnpack[$cnt]['parent_service_type_name'] = $parent_service_type_name;
             }
*/
          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_ServicesSLA',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end ServicesSLA
 ###############################################
 case 'ServiceSLARequests':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_serviceslarequests $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sclm_services_id_c'] = $the_row['sclm_services_id_c'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          $returnpack[$cnt]['sclm_servicessla_id_c'] = $the_row['sclm_servicessla_id_c'];
          $returnpack[$cnt]['start_date'] = $the_row['start_date'];
          $returnpack[$cnt]['end_date'] = $the_row['end_date'];
          $returnpack[$cnt]['sclm_accountsservices_id_c'] = $the_row['sclm_accountsservices_id_c'];
          $returnpack[$cnt]['sclm_accountsservicesslas_id_c'] = $the_row['sclm_accountsservicesslas_id_c'];
          $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
          $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
          $returnpack[$cnt]['sclm_sowitems_id_c'] = $the_row['sclm_sowitems_id_c'];
          $sclm_servicessla_id_c = $the_row['sclm_servicessla_id_c'];

          if ($the_row['sclm_servicessla_id_c'] == NULL){
             if ($the_row['sclm_accountsservicesslas_id_c'] != NULL){
                $sclm_servicessla_id_c = dlookup("sclm_accountsservicesslas", "sclm_servicessla_id_c", "id='".$the_row['sclm_accountsservicesslas_id_c']."'");
                $returnpack[$cnt]['sclm_servicessla_id_c'] = $sclm_servicessla_id_c;
                } // if sclm_accountsservicesslas_id_c
             }

          if ($sclm_servicessla_id_c != NULL){
             $sclm_sla_id_c = dlookup("sclm_servicessla", "sclm_sla_id_c", "id='".$sclm_servicessla_id_c."'");
             $returnpack[$cnt]['sclm_sla_id_c'] = $sclm_sla_id_c;
             }

          $returnpack[$cnt]['provider_price'] = $the_row['provider_price'];
          $returnpack[$cnt]['reseller_price'] = $the_row['reseller_price'];
          $returnpack[$cnt]['customer_price'] = $the_row['customer_price'];
          $returnpack[$cnt]['sclm_servicesprices_id_c'] = $the_row['sclm_servicesprices_id_c'];
          $returnpack[$cnt]['timezone'] = $the_row['timezone'];
          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_ServiceSLARequests',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end ServiceSLARequests
 ###############################################
 case 'SLA':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_sla $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['performance_metric'] = $the_row['performance_metric'];
          $returnpack[$cnt]['metric_count'] = $the_row['metric_count'];
          $returnpack[$cnt]['count_type'] = $the_row['count_type'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['start_time'] = $the_row['start_time'];
          $returnpack[$cnt]['end_time'] = $the_row['end_time'];

/*
          $returnpack[$cnt]['service_type'] = $the_row['service_type'];
          $returnpack[$cnt]['market_value'] = $the_row['market_value'];

          $returnpack[$cnt]['service_type_id'] = $the_row['service_type'];
          if ($returnpack[$cnt]['service_type_id']){
             $service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_type_id']."'");
             $returnpack[$cnt]['service_type_name'] = $service_type_name;
             }

          $returnpack[$cnt]['parent_service_type_id'] = $the_row['parent_service_type'];
          if ($returnpack[$cnt]['parent_service_type_id']){
             $parent_service_type_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['parent_service_type_id']."'");
             $returnpack[$cnt]['parent_service_type_name'] = $parent_service_type_name;
             }
*/
          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_SLA',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Services
 ###############################################


/* case 'SideEffects':
 
  switch ($action){

   // In future to be external API via SOAP to separate service 

   case 'select_actions':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $query = "SELECT $select FROM sfx_actions $query $group $order";

    $sfxactions_db = new DB_Sql();
    $sfxactions_db->Database = DATABASE_NAME;
    $sfxactions_db->User     = DATABASE_USER;
    $sfxactions_db->Password = DATABASE_PASSWORD;
    $sfxactions_db->Host     = DATABASE_HOST;

    $the_list = $sfxactions_db->query($query);

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sfx_externalsources_id_c'] = $the_row['sfx_externalsources_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['sfx_sourceobjects_id_c'] = $the_row['sfx_sourceobjects_id_c'];
          $returnpack[$cnt]['object_id'] = $the_row['object_id'];
          $returnpack[$cnt]['sfx_purposes_id_c'] = $the_row['sfx_purposes_id_c'];
          $returnpack[$cnt]['sfx_emotions_id_c'] = $the_row['sfx_emotions_id_c'];

          $cnt++;

          }

   break;
   case 'select_effects':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sideeffects_db = new DB_Sql();
    $sideeffects_db->Database = DATABASE_NAME;
    $sideeffects_db->User     = DATABASE_USER;
    $sideeffects_db->Password = DATABASE_PASSWORD;
    $sideeffects_db->Host     = DATABASE_HOST;

    $the_list = $sideeffects_db->query("SELECT $select FROM sfx_effects $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['value'] = $the_row['value'];
          $returnpack[$cnt]['positivity'] = $the_row['positivity'];
          $returnpack[$cnt]['probability'] = $the_row['probability'];

          $returnpack[$cnt]['sfx_effects_id_c'] = $the_row['sfx_effects_id_c']; // parent effect
          if ($the_row['sfx_effects_id_c'] != NULL){
             $parent_effect_id = $the_row['sfx_effects_id_c'];
             $parent_effect_name = dlookup("sfx_effects", "name", "id='".$parent_effect_id."'");
             $returnpack[$cnt]['parent_effect_name'] = $parent_effect_name; // parent effect
             }

          $returnpack[$cnt]['sfx_grouptypes_id_c'] = $the_row['sfx_grouptypes_id_c'];
          if ($the_row['sfx_grouptypes_id_c'] != NULL){
             $sfx_grouptypes_id_c = $the_row['sfx_grouptypes_id_c'];
             $group_type_name = dlookup("sfx_grouptypes", "name", "id='".$sfx_grouptypes_id_c."'");
             $returnpack[$cnt]['group_type_name'] = $group_type_name; // parent effect
             }

          $returnpack[$cnt]['sfx_valuetypes_id_c'] = $the_row['sfx_valuetypes_id_c'];
          if ($the_row['sfx_valuetypes_id_c'] != NULL){
             $sfx_valuetypes_id_c = $the_row['sfx_valuetypes_id_c'];
             $value_type_name = dlookup("sfx_valuetypes", "name", "id='".$sfx_valuetypes_id_c."'");
             $returnpack[$cnt]['value_type_name'] = $value_type_name; // parent effect
             }

          $returnpack[$cnt]['sfx_purposes_id_c'] = $the_row['sfx_purposes_id_c'];
          if ($the_row['sfx_purposes_id_c'] != NULL){
             $sfx_purposes_id_c = $the_row['sfx_purposes_id_c'];
             $purpose = dlookup("sfx_purposes", "name", "id='".$sfx_purposes_id_c."'");
             $returnpack[$cnt]['purpose'] = $purpose; // parent effect
             }

          $returnpack[$cnt]['sfx_emotions_id_c'] = $the_row['sfx_emotions_id_c'];
          if ($the_row['sfx_emotions_id_c'] != NULL){
             $sfx_emotions_id_c = $the_row['sfx_emotions_id_c'];
             $emotion = dlookup("sfx_emotions", "name", "id='".$sfx_emotions_id_c."'");
             $returnpack[$cnt]['emotion'] = $emotion; // parent effect
             }

          $returnpack[$cnt]['sfx_actions_id_c'] = $the_row['sfx_actions_id_c']; // parent action - crm object
          if ($the_row['sfx_actions_id_c'] != NULL){
             $sfx_actions_id_c = $the_row['sfx_actions_id_c'];
             $action = dlookup("sfx_actions", "name", "id='".$sfx_actions_id_c."'");
             $returnpack[$cnt]['action'] = $action; // parent effect
             $returnpack[$cnt]['object_id'] = dlookup("sfx_actions", "object_id", "id='".$sfx_actions_id_c."'");
             $returnpack[$cnt]['sfx_sourceobjects_id_c'] = dlookup("sfx_actions", "sfx_sourceobjects_id_c", "id='".$sfx_actions_id_c."'");
             $returnpack[$cnt]['sourceobject'] = dlookup("sfx_sourceobjects", "name", "id='".$returnpack[$cnt]['sfx_sourceobjects_id_c']."'");
             }

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_Actions',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end SideEffects
*/
 ###############################################
 case 'SocialNetworkMembers':
 
  switch ($action){
  
   case 'select':
    
    if (is_array($params)){
     $query = $params[0];
     $order = $params[1];
     $group = $params[2];
     $selection = $params[3];
     } else {
     $query = "";
     $order = "";
     $group = "";
     $selection = "";
     }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($selection == NULL){
        $selection = "*";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     $causes_db = new DB_Sql();
     $causes_db->Database = DATABASE_NAME;
     $causes_db->User     = DATABASE_USER;
     $causes_db->Password = DATABASE_PASSWORD;
     $causes_db->Host     = DATABASE_HOST;
     
     $the_list = $causes_db->query("SELECT $selection FROM cmv_socialnetworkmembers $query $group $order ");

     $cnt = 0;

     while ($the_row = mysql_fetch_array ($the_list)){

        $returnpack[$cnt]['id'] = $the_row['id'];
        $returnpack[$cnt]['name'] = $the_row['name'];
        $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
        $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
        $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
        $returnpack[$cnt]['created_by'] = $the_row['created_by'];
        $returnpack[$cnt]['description'] = $the_row['description'];
        $returnpack[$cnt]['deleted'] = $the_row['deleted'];
        $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
        $returnpack[$cnt]['social_network_type'] = $the_row['social_network_type'];
        $returnpack[$cnt]['social_network_type_id'] = $the_row['social_network_type_id'];

        $contact_id_c = $the_row['contact_id_c'];
        $returnpack[$cnt]['contact_id_c'] = $contact_id_c;

/*
        $first_name = dlookup("contacts", "first_name", "id='".$contact_id_c."'");
        $last_name = dlookup("contacts", "last_name", "id='".$contact_id_c."'");
        $nickname = dlookup("contacts_cstm", "nickname_c", "id_c='".$contact_id_c."'");
        $cloakname = dlookup("contacts_cstm", "cloakname_c", "id_c='".$contact_id_c."'");
        $social_network_name_type = dlookup("cmv_contactprofiles", "cmv_contactnametypes_id1_c", "contact_id_c='".$contact_id_c."'");

        $returnpack[$cnt]['first_name'] = $first_name;
        $returnpack[$cnt]['last_name'] = $last_name;
        $returnpack[$cnt]['nickname'] = $nickname;
        $returnpack[$cnt]['cloakname'] = $cloakname;
        $returnpack[$cnt]['social_network_name_type'] = $social_network_name_type;
*/
        $cnt++;

        } // end while

   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_SocialNetworkMembers',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break; 
  } // end Action switch

 break; // end SocialNetworkMembers
 ###############################################
 case 'SourceObjects':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM sfx_sourceobjects $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sfx_externalsources_id_c'] = $the_row['sfx_externalsources_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_SourceObjects',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end SourceObjects
 ###############################################
 case 'SourceObjectItems':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM sfx_sourceobjectitems $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sfx_externalsources_id_c'] = $the_row['sfx_externalsources_id_c'];
          $returnpack[$cnt]['sfx_sourceobjects_id_c'] = $the_row['sfx_sourceobjects_id_c'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['source_object_item_external_id'] = $the_row['source_object_item_external_id'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sfx_SourceObjectItems',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end SourceObjectItems
 ###############################################
 case 'SOW':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM sclm_sow $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
          $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
          $returnpack[$cnt]['name_en'] = $the_row['name_en'];
          $returnpack[$cnt]['name_ja'] = $the_row['name_ja'];
          $returnpack[$cnt]['description_en'] = $the_row['description_en'];
          $returnpack[$cnt]['description_ja'] = $the_row['description_ja'];
          $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_SOW',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end SOW
 ###############################################
 case 'SOWItems':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $sourceobjects_db = new DB_Sql();
    $sourceobjects_db->Database = DATABASE_NAME;
    $sourceobjects_db->User     = DATABASE_USER;
    $sourceobjects_db->Password = DATABASE_PASSWORD;
    $sourceobjects_db->Host     = DATABASE_HOST;
     
    $the_list = $sourceobjects_db->query("SELECT $select FROM sclm_sowitems $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['sclm_sow_id_c'] = $the_row['sclm_sow_id_c'];
          $returnpack[$cnt]['sclm_sowitems_id_c'] = $the_row['sclm_sowitems_id_c']; // parent
          if ($returnpack[$cnt]['sclm_sowitems_id_c'] != NULL){
             $returnpack[$cnt]['parent_sclm_sowitems_id_c'] = dlookup("sclm_sowitems", "sclm_sowitems_id_c", "id='".$returnpack[$cnt]['sclm_sowitems_id_c']."'");
             }

/*
          if ($the_row['sclm_sowitems_id_c']){

             $sowitems_db = new DB_Sql();
             $sowitems_db->Database = DATABASE_NAME;
             $sowitems_db->User     = DATABASE_USER;
             $sowitems_db->Password = DATABASE_PASSWORD;
             $sowitems_db->Host     = DATABASE_HOST;
     
             $sowitems_list = $sowitems_db->query("SELECT $select FROM sclm_sowitems WHERE id='".$the_row['sclm_sowitems_id_c']."' $group $order");

             $sowitemscnt = 0;
             $returnpack = "";
     
             while ($sowitems_row = mysql_fetch_array ($sowitems_list)){

                   $returnpack['sowitems'][1][$sowitemscnt]['id'] = $sowitems_row['id'];
                   $returnpack['sowitems'][1][$sowitemscnt]['name'] = $sowitems_row['name'];
                   $returnpack['sowitems'][1][$sowitemscnt]['sclm_sowitems_id_c'] = $sowitems_row['sclm_sowitems_id_c'];

                   $sowitemscnt++;

                   } // end while at level 1

             } // end if at level 1
*/
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
          $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
          $returnpack[$cnt]['item_number'] = $the_row['item_number'];
          $returnpack[$cnt]['name_en'] = $the_row['name_en'];
          $returnpack[$cnt]['name_ja'] = $the_row['name_ja'];
          $returnpack[$cnt]['description_en'] = $the_row['description_en'];
          $returnpack[$cnt]['description_ja'] = $the_row['description_ja'];
          $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_SOWItems',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end SOWItems
 ###############################################
 case 'TasksServiceSLARequests':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_tasksserviceslarequests $query $group $order");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
          $returnpack[$cnt]['sclm_serviceslarequests_id_c'] = $the_row['sclm_serviceslarequests_id_c'];
          $returnpack[$cnt]['task_id_c'] = $the_row['task_id_c'];

          $cnt++;

          }

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_TasksServiceSLARequests',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end TasksServiceSLARequests
 ###############################################
 case 'Ticketing':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "name_en";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$lingoname){
       $lingoname = "name_en";
       }

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_ticketing $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $id = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['sclm_serviceslarequests_id_c'] = $the_row['sclm_serviceslarequests_id_c'];

          if ($the_row['status'] == NULL){
             $returnpack[$cnt]['status'] = 'e47fc565-c045-fef9-ef4f-52802bfc479c';
             $status = 'e47fc565-c045-fef9-ef4f-52802bfc479c';
             }else{
             $returnpack[$cnt]['status'] = $the_row['status'];
             $status = $the_row['status'];
             }

          $returnpack[$cnt]['account_id1_c'] = $the_row['account_id1_c'];
          $returnpack[$cnt]['contact_id1_c'] = $the_row['contact_id1_c'];

          if ($status != 'e47fc565-c045-fef9-ef4f-52802bfc479c'){

             # Get Activity Count
             $act_db = new DB_Sql();
             $act_db->Database = DATABASE_NAME;
             $act_db->User     = DATABASE_USER;
             $act_db->Password = DATABASE_PASSWORD;
             $act_db->Host     = DATABASE_HOST;
     
             $act_list = $act_db->query("SELECT id FROM sclm_ticketingactivities WHERE sclm_ticketing_id_c='".$id."' ");
             while ($act_row = mysql_fetch_array ($act_list)){
                   $act_count = count($act_row);
                   $returnpack[$cnt]['activity_count'] = $act_count;
                   }

             if ($the_row['contact_id1_c'] != NULL){
                $returnpack[$cnt]['agent_name'] = dlookup("contacts", "first_name", "id='".$the_row['contact_id1_c']."'");
                }

             $sclm_servicessla_id_c = dlookup("sclm_serviceslarequests", "sclm_servicessla_id_c", "id='".$the_row['sclm_serviceslarequests_id_c']."'");

             if ($sclm_servicessla_id_c != NULL){

                $returnpack[$cnt]['sclm_servicessla_id_c'] = $sclm_servicessla_id_c;
                $sclm_sla_id_c = dlookup("sclm_servicessla", "sclm_sla_id_c", "id='".$sclm_servicessla_id_c."'");

                if ($sclm_sla_id_c != NULL){

                   $returnpack[$cnt]['sclm_sla_id_c'] = $the_row['sclm_sla_id_c'];

                   $metric_count = dlookup("sclm_sla", "metric_count", "id='".$sclm_sla_id_c."'");
                   $returnpack[$cnt]['metric_count'] = $metric_count;
                   $count_type = dlookup("sclm_sla", "count_type", "id='".$sclm_sla_id_c."'");
                   $returnpack[$cnt]['count_type'] = $count_type;
                   $start_time = dlookup("sclm_sla", "start_time", "id='".$sclm_sla_id_c."'");
                   $returnpack[$cnt]['start_time'] = $start_time;
                   $end_time = dlookup("sclm_sla", "end_time", "id='".$sclm_sla_id_c."'");
                   $returnpack[$cnt]['end_time'] = $end_time;

                   switch ($metric_count){

                    case '3071beef-694f-1232-c936-525935686c09': // Days

                     $slaminutes = $metric_count*24*60; // Total minutes

                    break;
                    case '8cfee2ac-bbb2-9db9-0f61-523fc9329f55': // Hours

                     $slaminutes = $metric_count*60; // Total minutes

                    break;
                    case 'b42d5cd9-19f7-d2ec-ab39-526f95140529': // Months
   
                     $slaminutes = (365/12/730)*$metric_count*60; // Total minutes

                    break;
                    case '784310ea-344a-a053-836a-523fc2fcb1f5': // Seconds

                     

                    break;
                    case '6d9901cd-9516-5fcd-59a4-52593456d9e3': // Percentage

                     

                    break;
 
                   } // end switch

                   $returnpack[$cnt]['slaminutes'] = $slaminutes;

                   $nowdate = date("Y-m-d H:i:s");
                   $difference = $funky_gear->timeDiff($the_row['date_entered'],$nowdate);
                   $years = abs(floor($difference / 31536000));
                   $days = abs(floor(($difference-($years * 31536000))/86400));
                   $hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));
                   $mins = abs(floor(($difference-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);   
                   $accumulated_minutes = floor(($difference)/60); 

                   $remaining_sla_mins = $slaminutes-$accumulated_minutes;
                   $returnpack[$cnt]['remaining_sla_mins'] = $remaining_sla_mins;
   
                   } // end if $sclm_sla_id_c

                } // end if $sclm_servicessla_id_c

             } // end if

          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['service_operation_process'] = $the_row['service_operation_process'];
          $returnpack[$cnt]['project_id_c'] = $the_row['project_id_c'];
          $returnpack[$cnt]['projecttask_id_c'] = $the_row['projecttask_id_c'];
          $returnpack[$cnt]['sclm_sowitems_id_c'] = $the_row['sclm_sowitems_id_c'];

          if ($returnpack[$cnt]['service_operation_process']){
             $service_operation_process_name = dlookup("sclm_configurationitems", $lingoname, "id='".$returnpack[$cnt]['service_operation_process']."'");
             #$service_operation_process_name = dlookup("sclm_configurationitems", $lingoname, "id='".$returnpack[$cnt]['service_operation_process']."'");

             if ($service_operation_process_name == NULL){
                $service_operation_process_name = dlookup("sclm_configurationitems", "name", "id='".$returnpack[$cnt]['service_operation_process']."'");
                }

             $returnpack[$cnt]['service_operation_process_name'] = $service_operation_process_name;
             }

          $returnpack[$cnt]['ticket_source'] = $the_row['ticket_source'];
          $returnpack[$cnt]['sclm_configurationitems_id_c'] = $the_row['sclm_configurationitems_id_c'];
          $returnpack[$cnt]['ticket_id'] = $the_row['ticket_id'];
          $returnpack[$cnt]['accumulated_minutes'] = $the_row['accumulated_minutes'];

          $status_image = dlookup("sclm_configurationitems", "image_url", "id='".$returnpack[$cnt]['status']."'");
          $returnpack[$cnt]['status_image'] = $status_image;
          $status_name = dlookup("sclm_configurationitems", "name_en", "id='".$returnpack[$cnt]['status']."'");
          $returnpack[$cnt]['status_name'] = $status_name;
          $status_name_ja = dlookup("sclm_configurationitems", "name_ja", "id='".$returnpack[$cnt]['status']."'");
          $returnpack[$cnt]['status_name_ja'] = $status_name_ja;
          $returnpack[$cnt]['sclm_emails_id_c'] = $the_row['sclm_emails_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
          $returnpack[$cnt]['extra_addressees'] = $the_row['extra_addressees'];
          $returnpack[$cnt]['extra_addressees_cc'] = $the_row['extra_addressees_cc'];
          $returnpack[$cnt]['extra_addressees_bcc'] = $the_row['extra_addressees_bcc'];
          $returnpack[$cnt]['filter_id'] = $the_row['filter_id'];

          if ($the_row['filter_id'] != NULL){
             #$returnpack[$cnt]['filter_name'] = dlookup("sclm_configurationitems", $lingoname, "id='".$the_row['filter_id']."'");
             $returnpack[$cnt]['filter_name'] = dlookup("sclm_configurationitems", "name", "id='".$the_row['filter_id']."'");
             }

          $returnpack[$cnt]['to_addressees'] = $the_row['to_addressees'];
          $returnpack[$cnt]['cc_addressees'] = $the_row['cc_addressees'];
          $returnpack[$cnt]['bcc_addressees'] = $the_row['bcc_addressees'];
          $returnpack[$cnt]['sdm_confirmed'] = $the_row['sdm_confirmed'];
          $returnpack[$cnt]['billing_count'] = $the_row['billing_count'];
          $returnpack[$cnt]['vendor_code'] = $the_row['vendor_code'];
          $returnpack[$cnt]['sclm_ticketing_id_c'] = $the_row['sclm_ticketing_id_c'];

          $cnt++;

          }

   break;
   case 'count':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "name_en";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT COUNT($select) as TOTALFOUND FROM sclm_ticketing $query $group $order $limit");

    $returnpack = mysql_result($the_list,0,"TOTALFOUND");

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_Ticketing',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end Ticketing
 ###############################################
 case 'TicketingActivities':
 
  switch ($action){

   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "name_en";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT $select FROM sclm_ticketingactivities $query $group $order $limit");

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['account_id1_c'] = $the_row['account_id1_c'];
          $returnpack[$cnt]['contact_id1_c'] = $the_row['contact_id1_c'];
          $returnpack[$cnt]['accumulated_minutes'] = $the_row['accumulated_minutes'];
          $returnpack[$cnt]['sclm_ticketing_id_c'] = $the_row['sclm_ticketing_id_c'];

          if ($the_row['status'] == NULL){
             $returnpack[$cnt]['status'] = 'e47fc565-c045-fef9-ef4f-52802bfc479c';
             }else{
             $returnpack[$cnt]['status'] = $the_row['status'];
             }

          $status_image = dlookup("sclm_configurationitems", "image_url", "id='".$returnpack[$cnt]['status']."'");
          $returnpack[$cnt]['status_image'] = $status_image;
          $returnpack[$cnt]['extra_addressees'] = $the_row['extra_addressees'];
          $returnpack[$cnt]['extra_cc_addressees'] = $the_row['extra_cc_addressees'];
          $returnpack[$cnt]['extra_bcc_addressees'] = $the_row['extra_bcc_addressees'];
          $returnpack[$cnt]['filter_id'] = $the_row['filter_id'];
          $returnpack[$cnt]['to_addressees'] = $the_row['to_addressees'];
          $returnpack[$cnt]['cc_addressees'] = $the_row['cc_addressees'];
          $returnpack[$cnt]['bcc_addressees'] = $the_row['bcc_addressees'];
          $returnpack[$cnt]['ticket_update'] = $the_row['ticket_update'];

          $cnt++;

          }

   break;
   case 'count':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       $lingoname = $params[5];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       $lingoname = "name_en";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $content_db = new DB_Sql();
    $content_db->Database = DATABASE_NAME;
    $content_db->User     = DATABASE_USER;
    $content_db->Password = DATABASE_PASSWORD;
    $content_db->Host     = DATABASE_HOST;
     
    $the_list = $content_db->query("SELECT COUNT($select) as TOTALFOUND FROM sclm_ticketingactivities $query $group $order $limit");

    $returnpack = mysql_result($the_list,0,"TOTALFOUND");

   break;
   case 'update':

    // Now Prepare
    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'sclm_TicketingActivities',
              'name_value_list'=> $params
    );

    // Now Add the Stats
    $returnpack = $soapclient->call('set_entry',$set_entry_params);

   break; // end add content

  } // end action switch

 break; // end TicketingActivities
 ###############################################
 case 'Users':

  switch ($action){

   case 'get_users':

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = array();
       $group = "";
       $order = "";
       $limit = "";
       }
    
    $offset = 0;
 
    $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass), 'version' => '0.1'));

    $soapclient = new nusoap_client($crm_wsdl_url);
    $login_results = $soapclient->call('login',$auth_array,'RealPolitika.org');

    $sugar_session_id = $login_results['id'];

    $limit = "";
    
    $result = $soapclient->call('user_list',array(
'user_name'=>$api_user,
'password'=>md5($api_pass),
));

    $cnt = 0;

    foreach ($result as $gotten){
    
           $returnpack[$cnt]['id'] = $gotten['id'];
           $this_user_id = $gotten['id'];
           $returnpack[$cnt]['user_name'] = $gotten['user_name'];
           $returnpack[$cnt]['first_name'] = $gotten['first_name'];
           $returnpack[$cnt]['last_name'] = $gotten['last_name'];
           $returnpack[$cnt]['department'] = $gotten['department'];
           $returnpack[$cnt]['title'] = $gotten['title'];

           $offset = 0;
    
           $user_query = " users.id = '".$this_user_id."' " ;
           $select_fields = array();
           $select_fields = array("email1");

           $user_result = $soapclient->call('get_entry_list',array('session'=>$sugar_session_id,'module_name'=>'Users','query'=>$user_query,'order_by'=>'users.user_name asc','offset'=>$offset, 'select_fields'=>$select_fields, 'max_results'=>'10000'));

           foreach ($user_result['entry_list'] as $user_gotten){

                   $user_data = nameValuePairToSimpleArray($user_gotten['name_value_list']);

                   $returnpack[$cnt]['email_address'] = $user_data['email1'];

                   }

           $cnt++;

          } // end foreach

   break;
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'Users',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;  
  } // end action switch
   
 break; // End Users/Employees
 ###############################################
 case 'Votes':

  switch ($action){

   case 'count_vote':

     if (is_array($params)){
      $query = $params[0];     
      } else {
      $query = "";  
      }

     $object_type = "Vote";
     $action = "select";
     $voteparams = array();
     $voteparams[0] =  $query;
     $voteparams[1] = "";
    
     $vote_list = api_sugar ($api_user, $api_pass, $api_url, $object_type, $action, $voteparams);    

     //var_dump($vote_list);

     $vote_sum = 0;
     if ($vote_list != NULL){

        for ($cnt=0;$cnt < count($vote_list);$cnt++){

            $id = $vote_list[$cnt]['id'];
            $vote = $vote_list[$cnt]['vote'];
            $vote_sum = $vote_sum+$vote;

            }

        $returnpack['vote_count'] = count($vote_list);
        $returnpack['vote_sum'] = $vote_sum;
        $returnpack['vote_average'] = $vote_sum/count($vote_list);

        }


   break;  
   case 'do_vote':
    
    //echo "API: ".$crm_wsdl_url2."<P>";
    
    $soaper = sugarsession ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2);
    $soapclient = $soaper[0];
    $sugar_session_id = $soaper[1];
    
    //echo "SOAP Session: ".$sugar_session_id."<P>";
    //var_dump($params);
    //echo "<P>";
         
    $set_entry_params = array(
      'session' => $sugar_session_id,
      'module_name' => 'cmv_Votes',
      'name_value_list'=>$params,
      );
          
     // Now Add the Contact
     $returnpack = $soapclient->call('set_entry',$set_entry_params);
         
   break;  // end do vote
   case 'select':
    
    /*
year/month - will relate to constitutional restrictions on vote recurrence for the object type
from/to dates for voting
can change? retract?

*/

    if (is_array($params)){
       $query = $params[0];
       $select = $params[1];
       $group = $params[2];
       $order = $params[3];
       $limit = $params[4];
       } else {
       $query = "";
       $select = "";
       $group = "";
       $order = "";
       $limit = "";
       }
 
    if ($query != NULL){
       $query = "WHERE ".$query." ";
       }

    if ($group != NULL){
       $group = " GROUP BY ".$group." ";
       } 

    if ($order != NULL){
       $order = " ORDER BY ".$order." ";
       }

    if ($limit != NULL){
       $limit = " LIMIT ".$limit." ";
       } 

    if (!$select){
       $select = "*";
       }

    $query = "SELECT $select FROM cmv_votes $query $group $order $limit";

    $votes_db = new DB_Sql();
    $votes_db->Database = DATABASE_NAME;
    $votes_db->User     = DATABASE_USER;
    $votes_db->Password = DATABASE_PASSWORD;
    $votes_db->Host     = DATABASE_HOST;
     
    $the_list = $votes_db->query($query);

    $cnt = 0;
    $returnpack = "";
     
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
          $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
          $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
          $returnpack[$cnt]['created_by'] = $the_row['created_by'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
          $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];
          $returnpack[$cnt]['ip_address'] = $the_row['ip_address'];
          $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];
          $returnpack[$cnt]['vote'] = $the_row['vote'];
          $returnpack[$cnt]['contact_id1_c'] = $the_row['contact_id1_c'];
          $returnpack[$cnt]['cmv_governments_id_c'] = $the_row['cmv_governments_id_c'];
          $returnpack[$cnt]['cmv_governmentpolicies_id_c'] = $the_row['cmv_governmentpolicies_id_c'];
          $returnpack[$cnt]['cmv_constitutionalarticles_id_c'] = $the_row['cmv_constitutionalarticles_id_c'];
          $returnpack[$cnt]['cmv_politicalparties_id_c'] = $the_row['cmv_politicalparties_id_c'];
          $returnpack[$cnt]['cmv_governmenttypes_id_c'] = $the_row['cmv_governmenttypes_id_c'];
          $returnpack[$cnt]['cmv_constitutionalamendments_id_c'] = $the_row['cmv_constitutionalamendments_id_c'];
          $returnpack[$cnt]['contact_id2_c'] = $the_row['contact_id2_c'];
          $returnpack[$cnt]['cmv_politicalpartyroles_id_c'] = $the_row['cmv_politicalpartyroles_id_c'];
          $returnpack[$cnt]['cmv_governmentroles_id_c'] = $the_row['cmv_governmentroles_id_c'];
          $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
          $returnpack[$cnt]['cmn_countries_id1_c'] = $the_row['cmn_countries_id1_c'];
          $returnpack[$cnt]['cmv_governmentconstitutions_id_c'] = $the_row['cmv_governmentconstitutions_id_c'];
          $returnpack[$cnt]['cmv_nominees_id_c'] = $the_row['cmv_nominees_id_c'];
          $returnpack[$cnt]['cmv_causes_id_c'] = $the_row['cmv_causes_id_c'];
          $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
          $returnpack[$cnt]['cmv_comments_id_c'] = $the_row['cmv_comments_id_c'];
          $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
          $returnpack[$cnt]['cmv_news_id_c'] = $the_row['cmv_news_id_c'];

          $returnpack[$cnt]['sclm_events_id_c'] = $the_row['sclm_events_id_c'];
          $returnpack[$cnt]['sclm_content_id_c'] = $the_row['sclm_content_id_c'];

          $cnt++;
     
          } // end while
    
   break; // end select
   case 'update':

    $set_entry_params = array(
   'session' => $sugar_session_id,
              'module_name' => 'cmv_Votes',
              'name_value_list'=> $params
    );

    $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
   break;  
  } // end Action switch
  
 break; // end Vote object
 ###############################################
 
} // end Object Type switch

 return $returnpack;
     
} // End function

# End 
###################
?>