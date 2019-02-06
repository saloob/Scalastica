<?php

#error_reporting (E_ALL ^ E_NOTICE);
//===============================
// Database Connection Definition
//-------------------------------

session_start();

include("./db_mysql.inc");

mb_internal_encoding("UTF-8");

if (!file_exists('config.php')){
   exit;
   } else {
   require_once('config.php');
   }

#####################################################
# Extract Database Information from App

if (empty($portal_config['dbconfig']['db_host_name'])){
   exit;
   }
	   
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

$portal_email_password = $portal_config['portalconfig']['portal_email_password'];
$portal_name = $portal_config['portalconfig']['portal_title'];
$portal_email = $portal_config['portalconfig']['portal_email'];
$default_service_leadsources_id_c = $portal_config['portalconfig']['default_service_leadsources_id_c'];
$config['baseurl'] = $portal_config['portalconfig']['baseurl'];
$my_app_url = $config['baseurl'];

// Credits
$credits_base_rate = $portal_config['creditsconfig']['base_rate'];
$credits_base_currency = $portal_config['creditsconfig']['base_currency'];
$credits_partner_share = $portal_config['creditsconfig']['partner_share'];

// Facebook 
$facebook_service_leadsources_id_c = $portal_config['facebook']['facebook_service_leadsources_id_c'];
$facebook_app_url = $portal_config['facebook']['facebook_app_url'];

// include_once "fbmain.php";
//$timestamp = time();
//$userid = $fbme[id];
$fbappid = $fbconfig['appid'];
	
# End Extract Database Information from App
#####################################################
# Database Connection Definition

define("DATABASE_NAME",$db_name);
define("DATABASE_USER",$db_user);
define("DATABASE_PASSWORD",$db_pass);
define("DATABASE_HOST",$db_host);

// Database Initialize
$db = new DB_Sql();
$db->Database = DATABASE_NAME;
$db->User     = DATABASE_USER;
$db->Password = DATABASE_PASSWORD;
$db->Host     = DATABASE_HOST;

//===============================
// Site Initialization
//-------------------------------
// Obtain the path where this site is located on the server
//-------------------------------
$app_path = ".";
//-------------------------------
// Create Header and Footer Path variables
//-------------------------------

//===============================

//===============================
// Common functions
//-------------------------------
// Convert non-standard characters to HTML
//-------------------------------
function tohtml($strValue)
{
  return htmlspecialchars($strValue);
}

//-------------------------------
// Convert value to URL
//-------------------------------
function tourl($strValue)
{
  return urlencode($strValue);
}

//-------------------------------
// Obtain specific URL Parameter from URL string
//-------------------------------
function get_param($param_name)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;

  $param_value = "";
  if(isset($HTTP_POST_VARS[$param_name]))
    $param_value = $HTTP_POST_VARS[$param_name];
  else if(isset($HTTP_GET_VARS[$param_name]))
    $param_value = $HTTP_GET_VARS[$param_name];

  return $param_value;
}

function get_session($param_name)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;
  global ${$param_name};

  $param_value = "";
  if(!isset($HTTP_POST_VARS[$param_name]) && !isset($HTTP_GET_VARS[$param_name]) && session_is_registered($param_name)) 
    $param_value = ${$param_name};

  return $param_value;
}

function set_session($param_name, $param_value)
{
  global ${$param_name};
  if(session_is_registered($param_name)) 
    session_unregister($param_name);
  ${$param_name} = $param_value;
  session_register($param_name);
}

function is_number($string_value)
{
  if(is_numeric($string_value) || !strlen($string_value))
    return true;
  else 
    return false;
}

//-------------------------------
// Convert value for use with SQL statament
//-------------------------------
function tosql($value, $type)
{
  if(!strlen($value))
    return "NULL";
  else
    if($type == "Number")
      return str_replace (",", ".", doubleval($value));
    else
    {
      if(get_magic_quotes_gpc() == 0)
      {
        $value = str_replace("'","''",$value);
        $value = str_replace("\\","\\\\",$value);
      }
      else
      {
        $value = str_replace("\\'","''",$value);
        $value = str_replace("\\\"","\"",$value);
      }

      return "'" . $value . "'";
    }
}

function strip($value)
{
  if(get_magic_quotes_gpc() == 0)
    return $value;
  else
    return stripslashes($value);
}

function db_fill_array($sql_query)
{
  global $db;
  $db_fill = new DB_Sql();
  $db_fill->Database = $db->Database;
  $db_fill->User     = $db->User;
  $db_fill->Password = $db->Password;
  $db_fill->Host     = $db->Host;

  $db_fill->query($sql_query);
  if ($db_fill->next_record())
  {
    do
    {
      $ar_lookup[$db_fill->f(0)] = $db_fill->f(1);
    } while ($db_fill->next_record());
    return $ar_lookup;
  }
  else
    return false;

}

//-------------------------------
// Deprecated function - use get_db_value($sql)
//-------------------------------
function dlookup($table_name, $field_name, $where_condition)
{
  $sql = "SELECT " . $field_name . " FROM " . $table_name . " WHERE " . $where_condition;
  return get_db_value($sql);
}


//-------------------------------
// Lookup field in the database based on SQL query
//-------------------------------
function get_db_value($sql)
{
  global $db;
  $db_look = new DB_Sql();
  $db_look->Database = $db->Database;
  $db_look->User     = $db->User;
  $db_look->Password = $db->Password;
  $db_look->Host     = $db->Host;

  $db_look->query($sql);
  if($db_look->next_record())
    return $db_look->f(0);
  else 
    return "";
}

//-------------------------------
// Obtain Checkbox value depending on field type
//-------------------------------
function get_checkbox_value($value, $checked_value, $unchecked_value, $type)
{
  if(!strlen($value))
    return tosql($unchecked_value, $type);
  else
    return tosql($checked_value, $type);
}

//-------------------------------
// Obtain lookup value from array containing List Of Values
//-------------------------------
function get_lov_value($value, $array)
{
  $return_result = "";

  if(sizeof($array) % 2 != 0) 
    $array_length = sizeof($array) - 1;
  else
    $array_length = sizeof($array);

  for($i = 0; $i < $array_length; $i = $i + 2)
  {
    if($value == $array[$i]) $return_result = $array[$i+1];
  }

  return $return_result;
}

//-------------------------------
// Verify user's security level and redirect to login page if needed
//-------------------------------


###################################
# Security

function check_security($security_params){

 global $divstyle_orange,$strings,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$lingoname;

 $lingoname = "name_en";

 $system_module = $security_params[0];
 $lingo = $security_params[1];
 $contact_id_c = $security_params[2];
// $contact_id_c = $security_params[2];

//echo "Module: ".$module."<BR>";
//echo "Lingo: ".$lingo."<BR>";
//echo "Contact: ".$contact_id_c."<BR>";
//echo "Strings: ".$strings."<BR>";
//echo "API User: ".$crm_api_user."<BR>";
 if ($contact_id_c == NULL){
    $contact_id_c = 'ceadfac1-d392-7883-d2b4-52355c9bc961';
    }

 if ($contact_id_c != NULL){

    // 1) Check the role attached to the customer
    $contact_object_type = 'Contacts';
    $contact_action = 'select_cstm';
    $contact_params = array();
    $contact_params[0] = "id_c='".$contact_id_c."'";
    $contact_params[1] = "id_c,role_c";
    $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $contact_object_type, $contact_action, $contact_params);
    
    if (is_array($the_list)){
      
       for ($cnt=0;$cnt < count($the_list);$cnt++){

           $role_c = $the_list[$cnt]['role_c'];

           } // end for
      
       } else {// end if array

       $message = "1: There seems to be a system issue accessing this area: Role not set";
       echo "<div style=\"".$divstyle_orange."\"><center><font size=3><B>".$message."</B></font></center></div>";

       } 

    // 2) Check the role vs. module rights

    $security_params = "";
    $security_object_type = 'Security';
    $security_action = "select";
    $security_params[0] = " deleted=0 && role='".$role_c."' && system_module='".$system_module."' ";
    $security_params[1] = ""; // select array
    $security_params[2] = ""; // group;
    $security_params[3] = ""; // order;
    $security_params[4] = ""; // limit
    $security_params[5] = $lingoname; 

    #var_dump($security_params);

    $security_items = "";
    $security_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $security_object_type, $security_action, $security_params);
 
    #var_dump($security_items);

    if (is_array($security_items)){

       for ($sec_cnt=0;$sec_cnt < count($security_items);$sec_cnt++){

           #$id = $security_items[$cnt]['id'];
           #echo "ID: ".$id."<P>";
           #$name = $security_items[$cnt]['name'];
/*
           $ci_account_id = $security_items[$cnt]['account_id'];
           $ci_contact_id = $security_items[$cnt]['contact_id'];
           $module = $ci_security_itemstems[$cnt]['module'];
*/
          # $system_action_create = $security_items[$cnt]['system_action_create'];
          # $system_action_delete = $security_items[$cnt]['system_action_delete'];
          # $system_action_edit = $security_items[$cnt]['system_action_edit'];
          # $system_action_export = $security_items[$cnt]['system_action_export'];
          # $system_action_import = $security_items[$cnt]['system_action_import'];
          # $system_action_view_details = $security_items[$cnt]['system_action_view_details'];
          # $system_action_view_list = $security_items[$cnt]['system_action_view_list'];
          # $role = $security_items[$cnt]['role'];
          # $security_access = $security_items[$cnt]['access'];
          # $security_level = $security_items[$cnt]['security_level'];
          # $security_item_type = $security_items[$cnt]['security_item_type'];

/*
           $actions[] = $system_action_create;
           $actions[] = $system_action_delete;
           $actions[] = $system_action_edit;
           $actions[] = $system_action_export;
           $actions[] = $system_action_import;
           $actions[] = $system_action_view_details;
           $actions[] = $system_action_view_list;
*/

           #$_SESSION['system_action_create'] = $security_items[$cnt]['system_action_create'];#$system_action_create;
           #$_SESSION['system_action_delete'] = $security_items[$cnt]['system_action_delete'];#$system_action_delete;
           #$_SESSION['system_action_edit'] = $security_items[$cnt]['system_action_edit'];#$system_action_edit;
           #$_SESSION['system_action_export'] = $security_items[$cnt]['system_action_export'];#$system_action_export;
           #$_SESSION['system_action_import'] = $security_items[$cnt]['system_action_import'];#$system_action_import;
           #$_SESSION['system_action_view_details'] = $security_items[$cnt]['system_action_view_details'];#$system_action_view_details;
           #$_SESSION['system_action_view_list'] = $security_items[$cnt]['system_action_view_list'];#$system_action_view_list;
           #$_SESSION['security_level'] = $security_items[$cnt]['security_level'];#$security_level;

           #echo "security_level ".$security_items[$cnt]['security_level']."<P>";

           $security_pack[0] = $security_items[$sec_cnt]['access'];
           $security_pack[1] = $security_items[$sec_cnt]['security_level'];
           $security_pack[2] = $security_items[$sec_cnt]['role'];
           $security_pack[3] = $security_items[$sec_cnt]['system_action_create'];
           $security_pack[4] = $security_items[$sec_cnt]['system_action_delete'];
           $security_pack[5] = $security_items[$sec_cnt]['system_action_edit'];
           $security_pack[6] = $security_items[$sec_cnt]['system_action_export'];
           $security_pack[7] = $security_items[$sec_cnt]['system_action_import'];
           $security_pack[8] = $security_items[$sec_cnt]['system_action_view_details'];
           $security_pack[9] = $security_items[$sec_cnt]['system_action_view_list'];

           #var_dump($security_pack);           

           } // end for

       } else { // end is array

       $message = "2: There seems to be a system issue accessing this area: Role and Module not set<BR>ID:".$system_module;
       echo "<div style=\"".$divstyle_orange."\"><center><font size=3><B>".$message."</B></font></center></div>";

       }

    // 2) Check the access rights
    if ($security_pack[0] == '551aa9e6-5719-bad9-d295-527324162629'){
       // Enabled
       $security_access = TRUE;

       } else {
       // Disabled
       $security_access = FALSE;
       // Module: 79656625-8754-217e-1932-52ac728bb67b
       // Field: df646b94-a080-8539-4084-52ac72b39c42

       if ($security_items[$cnt]['security_item_type'] == '79656625-8754-217e-1932-52ac728bb67b'){ // Module not field
          echo "<div style=\"".$divstyle_orange."\">3: ".$strings["message_restricted_area"]."</div>";
          }

       }

    } else {// if no contact

      echo "<div style=\"".$divstyle_orange."\">4: ".$strings["message_restricted_area"]."</div>";

    } 
/*
 $security_pack[0] = $security_access;
 $security_pack[1] = $security_level;
 $security_pack[2] = $role_c;
 $security_pack[3] = $system_action_create;
 $security_pack[4] = $system_action_delete;
 $security_pack[5] = $system_action_edit;
 $security_pack[6] = $system_action_export;
 $security_pack[7] = $system_action_import;
 $security_pack[8] = $system_action_view_details;
 $security_pack[9] = $system_action_view_list;
*/
 return $security_pack;

/*
  global $UserRights;
  if(!session_is_registered("UserID"))
    header ("Location: index.php?querystring=" . urlencode(getenv("QUERY_STRING")) . "&ret_page=" . urlencode(getenv("REQUEST_URI")));
  else
    if(!session_is_registered("UserRights") || $UserRights < $security_level)
      header ("Location: index.php?querystring=" . urlencode(getenv("QUERY_STRING")) . "&ret_page=" . urlencode(getenv("REQUEST_URI")));
*/

} // end security check

###################################
# Includes

include ("global/global.php");
include ("css/style.php");

$lingo = $_SESSION['lingo'];

if ($_GET['lingo'] && $lingo == NULL){
   $lingo = $_GET['lingo'];
   }
   
if ($_POST['lingo'] && $lingo == NULL){
   $lingo = $_POST['lingo'];
   }

if ($lingo != NULL){
   $_SESSION['lingo'] = $lingo;
   }

if (!$lingo){
   $lingo = "en";
   $_SESSION['lingo'] = $lingo;
   }

if (!function_exists('set_lingo')){
   include ("global/lingo.inc.php");
   include (set_lingo());
   $lingofile = set_lingo();
   include ($lingofile);
   }

if (!class_exists('funky')){
   include ("funky.php");
   $funky_gear = new funky ();   
   }

if (!function_exists('api_sugar')){
   include ("api-sugarcrm.php");
   }

if (!class_exists('funkydo')){
   include ("funkydo.php");
   $funkydo_gear = new funkydo ();   
   }

# Includes
####################################################
# Collect Params

$sent_portalcode = $_GET['pc'];
if (!$sent_portalcode){
   $sent_portalcode = $_POST['pc'];
   }
	
$page = $_GET['pg'];
if (!$page){
   $page = $_POST['pg'];
   }

if (!$do){
   $do = $_GET['do'];
   }
if (!$do){
   $do = $_POST['do'];
   }
	
if (!$action){
   $action = $_GET['action'];
   }
if (!$action){
   $action = $_POST['action'];
   }
	
if (!$val){
   $val = $_GET['value'];
   }
if (!$val){
   $val = $_POST['value'];
   }
	
if (!$valtype){
   $valtype = $_GET['valuetype'];
   }
if (!$valtype){
   $valtype = $_POST['valuetype'];
   }

$sendvars = $_GET['sv'];
if (!$sendvars){
   $sendvars = $_POST['sv'];
   }

$contentvars = $_GET['cn'];
if (!$contentvars){
   $contentvars = $_POST['cn'];
   }

if ($action == 'add'){
   $form_action = 'add';
   }

if ($action == 'edit'){
   $form_action = 'edit';
   }

if ($action == 'view'){
   $form_action = 'view';
   }

if ($action == 'manage'){
   $form_action = 'manage';
   }

if (!$auto_hostname){
   $hostname = $_SERVER['HTTP_HOST'];
   } else {
   // Auto script to do cron jobs for each host each 30 seconds
   $hostname = $auto_hostname;
   }

# End Collect Params
####################################################
# State Params

$date = date("Y@m@d@G");

$scalastica_account_id = 'de8891b2-4407-b4c4-f153-51cb64bac59e';

$standard_statuses_open_public = "6d8c12c1-4c83-f44a-26b4-51c233d31503";
$standard_statuses_open_anonymous = "a5c0a369-b375-e510-d453-51c233c589bb";
$standard_statuses_closed = "8eb47529-7e4e-d5ae-b2fa-51c233872ff3";

$anonymity_Anonymous = 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd';
$anonymity_Cloakname = '8aa7e22a-4769-caba-7711-4e0e7510ddc8';
$anonymity_Fullname = '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d';
$anonymity_Nickname = '178af3ac-57f1-63d9-60b0-4e0e7534ec7b';

$anonymity_params[0] = $anonymity_Anonymous;
$anonymity_params[1] = $anonymity_Cloakname;
$anonymity_params[2] = $anonymity_Fullname;
$anonymity_params[3] = $anonymity_Nickname;

$ci_value_entity = '1675499b-3176-50b1-3bef-51b327815629'; // sclm_ci for entity

$child_access = FALSE;
$access = FALSE;
 
$sess_account_id = $_SESSION['account_id'];
$sess_contact_id = $_SESSION['contact_id'];
$sess_source_id = $_SESSION['source_id'];
$sess_leadsources_id_c = $_SESSION['sclm_leadsources_id_c'];
$sess_targetmarkets_id_c = $_SESSION['sclm_targetmarkets_id_c'];

if ($sess_targetmarkets_id_c == NULL){
   $targetmarket = "15709226-5214-775e-ccbe-4c9d57db0143";
   $_SESSION['sclm_targetmarkets_id_c'] = $targetmarket;
   } else {
   $targetmarket = $sess_targetmarkets_id_c;
   }

$bodywidth = "0.98"; 

if ($sess_source_id != NULL && $sess_contact_id != NULL && $sess_leadsources_id_c != NULL ) {
   $access = TRUE;
   }

if ($sess_contact_id != NULL) {
   $access = TRUE;
   }
 
if ($sess_leadsources_id_c == NULL){
   $sess_leadsources_id_c = $default_service_leadsources_id_c;
   $_SESSION['sclm_leadsources_id_c'] = $sess_leadsources_id_c;
   }

# End Param Collection
####################################################
# Environment Values

  $ip_address = $_SERVER['REMOTE_ADDR'];

  if (!$cmn_countries_id_c){
     if (!empty($ip_address)) {
        $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip_address);
        $known = $tags['known'];
        $locationcode = $tags['locationcode'];
        $fips104 = $tags['fips104'];
        $iso2 = $tags['country'];
        $country = $iso2;
        $iso3 = $tags['iso3'];
        $ison = $tags['ison'];
        $internet = $tags['internet'];
        $countryid = $tags['countryid'];
        $country_name = $tags['country'];
        $regionid = $tags['regionid'];
        $region = $tags['region'];
        $regioncode = $tags['regioncode'];
        $adm1code = $tags['adm1code'];
        $cityid = $tags['cityid'];
        $city = $tags['city'];
        $latitude = $tags['latitude'];
        $longitude = $tags['longitude'];
        $timezone = $tags['timezone'];
        $certainty = $tags['certainty'];
        $mapbytesremaining = $tags['mapbytesremaining'];

//var_dump($tags);

        }

     if (empty($country)) {
        $country = "JP";
        }

     if (!empty($country)) {
        $cmn_countries_id_c = dlookup("cmn_countries", "id", "two_letter_code='".$country."'");
        $country = dlookup("cmn_countries", "name", "two_letter_code='".$country."'");   
        }
    
     } // end else if/country 

  $browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 1);
  $cmn_languages_id_c = "";
  if (!empty($browser_lingo)) {
     $cmn_languages_id_c = dlookup("cmn_languages", "id", "extension='".$browser_lingo."'");     
     }

# End Environment Values
####################################################
# Manage Params

//echo "sendvars: ".$sendvars."<P>";
if ($sent_portalcode){

   //echo $sent_portalcode."<P>";
   $decsendvars = $funky_gear->decrypt($sent_portalcode);
   list ($page,$lingo,$do,$action,$val,$valtype) = explode ("@", $decsendvars);
   //echo $decsendvars."<P>";
   //echo "$page,$lingo,$do,$action,$val,$valtype<P>";

   }


if ($sendvars){
   $decsendvars = $funky_gear->decrypt($sendvars);
   list ($page,$lingo,$do,$action,$val,$valtype) = explode ("@", $decsendvars);
   }

if ($contentvars){
   $deccontentvars = $funky_gear->decrypt($contentvars);
   list ($page,$lingo,$do,$action,$val,$valtype,$owner_contact_id_c,$owner_account_id_c) = explode ("@", $deccontentvars);
   }

if ($page != 'Left' && $page != 'Right' && $page != 'Body' && $page != 'Uploader' ){  
   $page = $funky_gear->decrypt($page);
   list ($datepart,$pagepart) = explode ("#", $page);
   $page = str_replace("php", "", $pagepart);
   }

if ($val != NULL && $valtype != NULL){

   $returner = $funky_gear->object_returner ($valtype, $val);
   $object_return_name = $returner[0];
   $object_return = $returner[1];
   $object_return_title = $returner[2];
   $object_return_target = $returner[3];
   $object_return_params = $returner[4];
   $object_return_completion = $returner[5];
   $object_return_voter = $returner[6];

   }

# End Param Management
####################################################
# Build Collapsable Tree

foreach ($_POST as $key=>$value){
 
//echo "Field: ".$key." - Value: ".$value."<BR>";
 
 // get the first parts - tree_branch_

 $treepart = 'tree_';

 $checkname = substr($key, 0, 5);
 
 if ($checkname == $treepart){
   
  $newtreebit = "&".$key."=1";
  
  if ($value == NULL){
     $collapsables .= str_replace($newtreebit, "", $collapsables);
     } else {
     $collapsables .= $newtreebit;
     }
  
  }

} // end for post each 

# End Build Collapsable Tree
####################################################
# Portal Info

  // how long to keep the cache files (hours)
  $cache_time = 1;

  // return location and name for cache file
  $cache_file = "/tmp/cache_".md5($hostname);

  // check that cache file exists and is not too old
  if (!file_exists($cache_file)){
     $portal_info = $funky_gear->portaliser($hostname);
     file_put_contents($cache_file, serialize($portal_info));
     } elseif (filemtime($cache_file) < time() - $cache_time * 3600){
     $portal_info = $funky_gear->portaliser($hostname);
     file_put_contents($cache_file, serialize($portal_info));
     } elseif ($hostname != NULL) {
     // if so, display cache file and stop processing
     $portal_info = unserialize(file_get_contents($cache_file));
     #readfile($cache_file);
     } else {
     $hostname = "scalastica.com";
     $portal_info = $funky_gear->portaliser($hostname);
     file_put_contents($cache_file, serialize($portal_info));
     }

if ($hostname != NULL){
   #$portal_info = unserialize(file_get_contents($hostname));
   }

$child_id = $portal_info['child_id'];
$children = $portal_info['children'];

$auth = "";

$portal_account_id = $portal_info['portal_account_id'];

if ($auto_account_id != NULL){
   $parent_account_id = $auto_account_id;
   $portal_account_id = $auto_account_id;
   } else {
   $parent_account_id = $portal_info['parent_account_id'];
   $portal_account_id = $parent_account_id;
   }

$assigned_user_id = $_SESSION['assigned_user_id'];

if ($assigned_user_id == NULL){

   #echo "Assigned User NULL Session<P>";

   $assigned_user_id = $portal_info['portal_assigned_user_id'];

   if ($assigned_user_id == NULL){

      #echo "Assigned User ID: Null Portal Info<P>";

      $sclmacc_object_type = "Accounts";
      $sclmacc_action = "select";
      $sclmacc_params[0] = " id='".$portal_account_id."' "; 
      $sclmacc_params[1] = "assigned_user_id";
      $sclmacc_params[2] = "";
      $sclmacc_params[3] = "";
      $sclmacc_params[4] = "";

      $sclmacc_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclmacc_object_type, $sclmacc_action, $sclmacc_params);

      if (is_array($sclmacc_rows)){ 

       for ($cnt=0;$cnt < count($sclmacc_rows);$cnt++){

           $assigned_user_id = $sclmacc_rows[$cnt]['assigned_user_id'];

           #echo "Assigned User ID: ".$assigned_user_id."<P>";

           } // end for

         } // is array

      } // if still null

   } else {// if null

   #echo "Assigned User ID: ".$assigned_user_id."<P>";

   }

if ($_SESSION['assigned_user_id'] == NULL){
    $_SESSION['assigned_user_id'] = $assigned_user_id;
    }

$sess_account_id = $_SESSION['account_id'];

if ($sess_account_id != NULL && $_SESSION['portal_admin'] == NULL){

   #$portal_account_id = $sess_account_id;
   $portal_acc_object_type = "Accounts";
   $portal_acc_action = "select_cstm";
   $portal_acc_params[0] = " id_c='".$sess_account_id."' ";
   $portal_acc_params[1] = "contact_id_c";
   $portal_admin_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $portal_acc_object_type, $portal_acc_action, $portal_acc_params);

   if (is_array($portal_admin_info)){

      for ($cnt=0;$cnt < count($portal_admin_info);$cnt++){

          $portal_admin = $portal_admin_info[$cnt]['contact_id_c'];
          $_SESSION['portal_admin'] = $portal_admin;

          } // for

      } // if

   } // if

$system_account = 'de8891b2-4407-b4c4-f153-51cb64bac59e';

if ($sess_account_id == $system_account){
   if ($sess_contact_id != NULL){
      $auth = 3;
      }
   }

//echo "Auth: ".$auth."<BR>";

if ($contact_id_c == NULL){
   $contact_id_c = $sess_contact_id;
   }

if ($contact_id_c != NULL && $sess_account_id == NULL){

   $accid_object_type = "Contacts";
   $accid_action = "get_account_id";
   $accid_params[0] = $contact_id_c;
   $accid_params[1] = "account_id";
   $account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

   if ($account_id_c != NULL){

      $_SESSION['account_id'] = $account_id_c;
      $sess_account_id = $account_id_c;

      } else {

      $account_id_c = $portal_account_id;

      } 

   } else {

    $account_id_c = $portal_account_id;

   } 

if ($account_id_c != NULL && $_SESSION['account_admin'] == NULL){

   $acc_object_type = "Accounts";
   $acc_action = "select_cstm";
   $acc_params[0] = " id_c='".$account_id_c."' ";
   $acc_params[1] = "contact_id_c";
   $account_admin_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $acc_object_type, $acc_action, $acc_params);

   if (is_array($account_admin_info)){

      for ($cnt=0;$cnt < count($account_admin_info);$cnt++){

          $account_admin = $account_admin_info[$cnt]['contact_id_c'];
          $_SESSION['account_admin'] = $account_admin;

          } // for

      } // if

   } elseif ($account_id_c != NULL && $_SESSION['account_admin'] != NULL) {// if
     $account_admin = $_SESSION['account_admin'];
   }

# Check AUTH
$security_role = $_SESSION['security_role'];
if ($security_role == NULL){
   $security_role = '43b66381-12b8-7c4b-0602-5276698dcb48';
   $_SESSION['security_role'] = $security_role;
   }

if ($auth == NULL){
   $auth = $_SESSION['security_level'];
   #echo "<P>Auth: ".$sess_auth."<P>";
   /*
   if ($sess_contact_id == $account_admin){
      $auth = 2;
      } elseif ($sess_contact_id != NULL){
      $auth = 1;
      }
   */

   }

if (is_array($children)){
   
   for ($cnt=0;$cnt < count($children);$cnt++){
       $child_id = $children[$cnt];
       $external_source_params[$cnt][0] = $funky_gear->encrypt($child_id);
       }

   foreach ($portal_info['external_source_type_id'] as $key=>$value){
           //echo "EXT Key: ".$key." - Value: ".$value."<BR>";
           $external_source_params[$key][1] = $funky_gear->encrypt($value);
           }

   foreach ($portal_info['external_url'] as $key=>$value){
           //echo "EXT Key: ".$key." - Value: ".$value."<BR>";
           $external_source_params[$key][2] = $funky_gear->encrypt($value);
           }

   foreach ($portal_info['external_admin_name'] as $key=>$value){
           //echo "EXT Key: ".$key." - Value: ".$value."<BR>";
           $external_source_params[$key][3] = $funky_gear->encrypt($value);
           }

   foreach ($portal_info['external_admin_password'] as $key=>$value){
           //echo "EXT Key: ".$key." - Value: ".$value."<BR>";
           $external_source_params[$key][4] = $funky_gear->encrypt($value);
           }

   foreach ($portal_info['external_account'] as $key=>$value){
           //echo "EXT Key: ".$key." - Value: ".$value."<BR>";
           $external_source_params[$key][5] = $funky_gear->encrypt($value);
           }
   
   } else {// end is_array

    if ($child_id != NULL){

       //$external_source_type_name = $portal_info['external_source_type_name'];
       $external_account = $portal_info['external_account'];
       $external_source_type_id = $portal_info['external_source_type_id'];
       $external_url = $portal_info['external_url'];
       $external_admin_name = $portal_info['external_admin_name'];
       $external_admin_password = $portal_info['external_admin_password'];
//   $child_access[$cnt] = $portal_info['child_access'][$cnt];

       $external_source_params[][0] = $funky_gear->encrypt($child_id);
       $external_source_params[][1] = $funky_gear->encrypt($external_source_type_id);
       $external_source_params[][2] = $funky_gear->encrypt($external_url);
       $external_source_params[][3] = $funky_gear->encrypt($external_admin_name);
       $external_source_params[][4] = $funky_gear->encrypt($external_admin_password);
       $external_source_params[][5] = $funky_gear->encrypt($external_account);
//   $external_source_params[6] = $funky_gear->encrypt($child_access);

       } // end if child

    } // else 

$portal_email = $portal_info['portal_email'];
$portal_email_password = $portal_info['portal_email_password'];
$portal_email_server = $portal_info['portal_email_server'];
$portal_email_smtp_auth = $portal_info['portal_email_smtp_auth'];
$portal_email_smtp_port = $portal_info['portal_email_smtp_port'];

switch ($portal_email_smtp_auth){
 case '2a73fcfc-3c25-0119-937d-5205837b3f86':
  $portal_email_smtp_auth = TRUE;
 break;
 case 'acdbab9d-ac3c-7c9c-4081-5205831bd04f':
  $portal_email_smtp_auth = FALSE;
 break;
}

$portal_skin = $portal_info['portal_skin'];
$portal_type = $portal_info['portal_type'];
$portal_title = $portal_info['portal_title'];
$portal_logo = $portal_info['portal_logo'];

if (!$portal_skin){
   $portal_skin = "scalastica";
   }

if (!$portal_logo){
   $portal_logo = "css/".$portal_skin."/images/".$portal_skin."-logo.png";
   }

if ($account_id_c != NULL && $account_id_c != $system_account){

   $ci_object_type = "AccountRelationships";
   $ci_action = "select";
   $ci_params[0] = " account_id1_c='".$account_id_c."' ";
   $ci_params[1] = ""; // select array
   $ci_params[2] = ""; // group;
   $ci_params[3] = ""; // order;
   $ci_params[4] = ""; // limit

   $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

   if (is_array($ci_items)){

      for ($cnt=0;$cnt < count($ci_items);$cnt++){

/*
       $id = $ci_items[$cnt]['id'];
       $name = $ci_items[$cnt]['name'];
       $date_entered = $ci_items[$cnt]['date_entered'];
       $date_modified = $ci_items[$cnt]['date_modified'];
           $modified_user_id = $ci_items[$cnt]['modified_user_id'];
           $created_by = $ci_items[$cnt]['created_by'];
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
*/
           #$parent_account_id = $ci_items[$cnt]['parent_account_id'];
           $child_account_id = $ci_items[$cnt]['child_account_id'];
           $entity_type = $ci_items[$cnt]['entity_type'];

//echo "Parent: ".$parent_account_id." & Child: ".$child_account_id." & type: ".$entity_type."<BR>";

           } // for

       } // is array

   } // if account

#
####################################################
# Standard formatting 

########################
# Page Config

$tablewidth = 980;
$tablewidth = "100%";
$leftcolumnwidth = "230px";
//$bodycolumnwidth = "550px";
$rightcolumnwidth = "230px";
//$leftcolumnwidth = "15%";
$bodycolumnwidth = "510px";
//$rightcolumnwidth = "15%";

$bodyheight = "100";
$bodywidth = ".98";

$pagesdivs = $funky_gear->makedivs ();
$Do = $pagesdivs['do_page'];
$Left = $pagesdivs['left_page'];
$Body = $pagesdivs['body_page'];
$Right = $pagesdivs['right_page'];
$MTV = $pagesdivs['mtv_page'];
$DoDIV = $pagesdivs['do_div'];
$LeftDIV = $pagesdivs['left_div'];
$BodyDIV = $pagesdivs['body_div'];
$RightDIV = $pagesdivs['right_div'];
$MTVDIV = $pagesdivs['mtv_div'];
$MobileDIV = $pagesdivs['mobile_div'];
$GridDIV = $pagesdivs['grid_div'];

# End Standard formatting
####################################################
# Div Styles

$divstyle_params[0] = "98%"; // minwidth
$divstyle_params[1] = "25px"; // minheight
$divstyle_params[2] = "1%"; // margin_left
$divstyle_params[3] = "1%"; // margin_right
$divstyle_params[4] = "2px"; // padding_left
$divstyle_params[5] = "2px"; // padding_right
$divstyle_params[6] = "0px"; // margin_top
$divstyle_params[7] = "0px"; // margin_bottom
$divstyle_params[8] = "5px"; // padding_top
$divstyle_params[9] = "2px"; // padding_bottom

$divstyles = $funky_gear->makedivstyles ($divstyle_params);
$divstyle_blue = $divstyles[0];
$divstyle_grey = $divstyles[1];
$divstyle_white = $divstyles[2];
$divstyle_orange = $divstyles[3];
$divstyle_orange_light = $divstyles[4];

$form_title_divstyle_params[0] = "98%"; // minwidth
$form_title_divstyle_params[1] = "25px"; // minheight
$form_title_divstyle_params[2] = "1%"; // margin_left
$form_title_divstyle_params[3] = "1%"; // margin_right
$form_title_divstyle_params[4] = "2px"; // padding_left
$form_title_divstyle_params[5] = "2px"; // padding_right
$form_title_divstyle_params[6] = "5px"; // margin_top
$form_title_divstyle_params[7] = "0px"; // margin_bottom
$form_title_divstyle_params[8] = "5px"; // padding_top
$form_title_divstyle_params[9] = "2px"; // padding_bottom

$formtitle_divstyles = $funky_gear->makedivstyles ($form_title_divstyle_params);
$formtitle_divstyle_blue = $formtitle_divstyles[0];
$formtitle_divstyle_grey = $formtitle_divstyles[1];
$formtitle_divstyle_white = $formtitle_divstyles[2];
$formtitle_divstyle_orange = $formtitle_divstyles[3];
$formtitle_divstyle_orange_light = $formtitle_divstyles[4];

# End Div Styles
####################################################
#

$lingoname = "name_".$lingo;
$lingodesc = "description_".$lingo;
$name_field_base = "name_";
$desc_field_base = "description_";

$access_enabled = '551aa9e6-5719-bad9-d295-527324162629';
$access_disabled = '749fb8f4-7815-8df1-233e-5273249b3363';

$action_rights_all = '35363731-f4be-d413-569a-527328219108';
$action_rights_none = '992bd4be-fb2c-4c3c-c6f1-5273285dafe5'; // no access
$action_rights_owner = '639cb83a-3d5f-9b64-e33b-52732894a2fa'; // creator
$action_rights_account = 'f17210a0-060c-aaec-79f3-527761465523'; // any account member

# Roles e95b1f0d-034e-0d4c-7754-527329f5b975

$role_AccountAdministrator = '9f9eac92-9527-b7fe-926c-527329fc72e1';
$role_AccountMember = '9dc1781c-af86-5a27-b16e-52732adde5b6';
$role_DivisionAdministrator = 'b74c12a4-4638-1921-09fe-5273290ce548';
$role_Guest = '43b66381-12b8-7c4b-0602-5276698dcb48';
$role_SystemAdministrator = '2388a2b4-13b2-21ef-fe07-52732991fbfc';
$role_TeamLeader = '2803fc3c-a696-1037-4474-527845cbabb0';
$role_SDM = 'b9b2568b-2e44-4f95-439d-5303deb3d1b5';

$icon_star = "<img src=images/icons/star.png width=16 border=0>";

#
?>