<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-23
# Page: common-new.php 
##########################################################
# New Common file for DB/API/AUTH

require_once('config.php');

$synchkey = $portal_config['portalconfig']['synchkey'];
$glb_domain = $portal_config['portalconfig']['glb_domain'];
$glb_home_url = $portal_config['portalconfig']['glb_home_url'];
$glb_app_dir = $portal_config['portalconfig']['glb_app_dir'];
$is_subdomain = $portal_config['portalconfig']['is_subdomain'];
$subdomain = $portal_config['portalconfig']['subdomain'];
$is_ssl = $portal_config['portalconfig']['is_ssl'];
$default_lingo = $portal_config['portalconfig']['default_lingo'];

$portal_email = $portal_config['portalconfig']['portal_email'];
$portal_email_password = $portal_config['portalconfig']['portal_email_password'];
$portal_title = $portal_config['portalconfig']['portal_title'];
$portal_skin = $portal_config['portalconfig']['portal_skin'];
$portal_style = $portal_config['portalconfig']['portal_style'];
$portal_system_style = $portal_config['portalconfig']['portal_system_style'];
$portal_style_images = $portal_config['portalconfig']['portal_style_images'];
$portal_logo = $portal_config['portalconfig']['portal_logo'];
$portal_logo_height = $portal_config['portalconfig']['portal_logo_height'];
$portal_logo_width = $portal_config['portalconfig']['portal_logo_width'];
$portal_logo_title = $portal_config['portalconfig']['portal_logo_title'];
$portal_url  = $portal_config['portalconfig']['portal_url'];
$portal_url_title = $portal_config['portalconfig']['portal_url_title'];
$portal_copyright_text = $portal_config['portalconfig']['portal_copyright_text'];
$portal_copyright_url = $portal_config['portalconfig']['portal_copyright_url'];

$personal_targetmarket = $portal_config['targetmarkets']['personal'];
$business_targetmarket = $portal_config['targetmarkets']['business'];
$government_targetmarket = $portal_config['targetmarkets']['government'];

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

$fbappid = $fbconfig['appid'];

$glb_root = "/var/www/vhosts";
$glb_raw_dir = $glb_root."/default";

if ($is_ssl == 1){
   $httpdocs = "httpsdocs";
   $http = "https";
   } else {
   $httpdocs = "httpdocs";
   $http = "http";
   }

if ($glb_app_dir != NULL){
   $glb_app_dir = "/".$glb_app_dir."/";
   } else {
   $glb_app_dir = "/";
   }

if ($is_subdomain == 1){
   $glb_doc_root = $glb_root."/".$glb_domain."/subdomains/".$subdomain."/".$httpdocs.$glb_app_dir;
   $glb_home_url = $http."://".$subdomain.".".$glb_domain.$glb_app_dir;
   $root = $glb_root."/".$glb_domain."/subdomains/".$subdomain."/".$httpdocs.$glb_app_dir;
   $home_url = $http."://".$subdomain.".".$glb_domain.$glb_app_dir;
   } else {
   $glb_doc_root = $glb_root."/".$glb_domain."/".$httpdocs.$glb_app_dir;
   $glb_home_url = $http."://".$glb_domain.$glb_app_dir;
   $root = $glb_root."/".$glb_domain."/".$httpdocs.$glb_app_dir;
   $home_url = $http."://".$glb_domain.$glb_app_dir;
   }

# End core config
#####################################################
# Extract Database Information from cinfig

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
	
# End Extract Database Information from App
#####################################################
# Initiate DB Class

if (!class_exists('DB_Sql')){

   include ("funky-db.php");

   define("DATABASE_NAME",$db_name);
   define("DATABASE_USER",$db_user);
   define("DATABASE_PASSWORD",$db_pass);
   define("DATABASE_HOST",$db_host);

   # Database Initialize
   $db = new DB_Sql();
   $db->Database = DATABASE_NAME;
   $db->User     = DATABASE_USER;
   $db->Password = DATABASE_PASSWORD;
   $db->Host     = DATABASE_HOST;

   }

function dlookup($table_name, $field_name, $where_condition){

  global $db;
  $db_look = new DB_Sql();
  $db_look->Database = $db->Database;
  $db_look->User     = $db->User;
  $db_look->Password = $db->Password;
  $db_look->Host     = $db->Host;

  $sql = "SELECT " . $field_name . " FROM " . $table_name . " WHERE " . $where_condition;
  $db_look->query($sql);
  $row = $db_look->single();

  return $row[$field_name];

} # end dlookup function

#
###################################
# Set up common variables

$lingo = $_SESSION['lingo'];

if ($lingo == NULL){
   $lingo = $_GET['lingo'];
   if ($lingo == NULL){
      $lingo = $_POST['lingo'];
      if ($lingo == NULL){
         $lingo = "en";
         $_SESSION['lingo'] = $lingo;
         }
      }
   }
   
if (!function_exists('set_lingo')){
   include ("lingo/lingo.inc.php");
   include (set_lingo());
   $lingofile = set_lingo();
   include ($lingofile);
   }

if (!class_exists('funky')){
   include ("funky.php");
   $funky_gear = new funky ();   
   }   

if (!function_exists('api_sugar')){
   include ("api-sugarcrm-new.php");
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
   if (!$do){
      $do = $_POST['do'];
      }
   }
	
if (!$action){
   $action = $_GET['action'];
   if (!$action){
      $action = $_POST['action'];
      }
   }
	
if (!$val){
   $val = $_GET['value'];
   if (!$val){
      $val = $_POST['value'];
      }
   }
	
if (!$valtype){
   $valtype = $_GET['valuetype'];
   if (!$valtype){
      $valtype = $_POST['valuetype'];
      }
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

  $cmn_countries_id_c = $_SESSION['cmn_countries_id_c'];

  if (!$cmn_countries_id_c){
     if (!empty($ip_address)) {
        #$tags=json_decode(file_get_contents('http://gd.geobytes.com/GetCityDetails?fqcn='. getIP()), true);
        $tags=json_decode(file_get_contents('http://gd.geobytes.com/GetCityDetails?fqcn='. $ip_address), true);
        #$tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip_address);
        #$known = $tags['known'];
        $locationcode = $tags['geobytesregionlocationcode'];
        #$fips104 = $tags['fips104'];
        $iso2 = $tags['geobytescountry'];
        $country = $iso2;
        $country_name = $iso2;
        #$iso3 = $tags['iso3'];
        #$ison = $tags['ison'];
        $internet = $tags['internet'];
        $countryid = $tags['geobytesinternet'];
        $regionid = $tags['geobyteslocationcode'];
        $region = $tags['geobytesregion'];
        $regioncode = $tags['geobytescode'];
        #$adm1code = $tags['adm1code'];
        $fqrn = $tags['geobytesfqcn'];
        $cityid = $tags['geobytescityid'];
        $city = $tags['geobytescity'];
        $latitude = $tags['geobyteslatitude'];
        $longitude = $tags['geobyteslongitude'];
        $capital = $tags['geobytescapital'];
        $nationalitysingular = $tags['geobytesnationalitysingular'];
        $nationalityplural = $tags['geobytesnationalityplural'];
        $population = $tags['geobytespopulation'];
        $timezone = $tags['geobytestimezone'];
        $mapreference = $tags['geobytesmapreference'];
        $currency = $tags['geobytescurrency'];
        $currencycode = $tags['geobytescurrencycode'];
        #$title = $tags['geobytestitle'];
        #$certainty = $tags['certainty'];
        #$mapbytesremaining = $tags['mapbytesremaining'];

        #var_dump($tags);

        }

     if (empty($countryid)) {
        $country = "JP";
        }

     if ($_SESSION['cmn_countries_id_c'] == NULL){

        if (!empty($countryid)) {

           $cmn_countries_id_c = dlookup("cmn_countries", "id", "two_letter_code='".$countryid."'");
           $_SESSION['cmn_countries_id_c'] = $cmn_countries_id_c;

           if ($_SESSION['country'] == NULL){

              $country = dlookup("cmn_countries", "name", "two_letter_code='".$countryid."'");   
              $_SESSION['country'] = $country;

              }
           }

        } // end else if _SESSION     

     } // end else if/country 

  $browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 1);
  $cmn_languages_id_c = "";
  if (!empty($browser_lingo) && $_SESSION['cmn_languages_id_c'] == NULL) {
     $cmn_languages_id_c = dlookup("cmn_languages", "id", "extension='".$browser_lingo."'");     
     $_SESSION['cmn_languages_id_c'] = $cmn_languages_id_c;
     }

# End Environment Values
####################################################
# Manage Params

if ($sent_portalcode){
   $decsendvars = $funky_gear->decrypt($sent_portalcode);
   list ($page,$lingo,$do,$action,$val,$valtype) = explode ("@", $decsendvars);
   }


if ($sendvars){
   $decsendvars = $funky_gear->decrypt($sendvars);
   list ($page,$lingo,$do,$action,$val,$valtype) = explode ("@", $decsendvars);
   }

if ($contentvars){
   $deccontentvars = $funky_gear->decrypt($contentvars);
   list ($page,$lingo,$do,$action,$val,$valtype,$owner_contact_id_c,$owner_account_id_c) = explode ("@", $deccontentvars);
   }

if ($page != 'Left' && $page != 'Right' && $page != 'Body' && $page != 'Uploader' && $page != 'Top' && $page != NULL){  
   $page = $funky_gear->decrypt($page);
   list ($datepart,$pagepart) = explode ("#", $page);
   $page = str_replace("php", "", $pagepart);
   }

# End Param Management
####################################################
# Portal Info

  // how long to keep the cache files (hours)
  $cache_time = 1;

  // return location and name for cache file
  $cache_file = "/tmp/cache_".md5($hostname);

  #echo $cache_file."<BR>";

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

$portal_admin = $portal_info['portal_admin'];

if ($portal_admin != NULL){
   $_SESSION['portal_admin'] = $portal_admin;
   }

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
      $_SESSION['account_id'] = $account_id_c;

      } 

   } elseif ($contact_id_c == NULL && $sess_account_id == NULL) {

    $account_id_c = $portal_account_id;
    #$_SESSION['account_id'] = $account_id_c;

   } elseif ($sess_account_id != NULL) {

    $account_id_c = $_SESSION['account_id'];

   } 

# Check AUTH
$security_role = $_SESSION['security_role'];
if ($security_role == NULL){
   $security_role = '43b66381-12b8-7c4b-0602-5276698dcb48';
   $_SESSION['security_role'] = $security_role;
   }

if ($auth == NULL){
   $auth = $_SESSION['security_level'];
   }

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
$portal_body_colour = $portal_info['portal_body_colour'];
$portal_border_colour = $portal_info['portal_border_colour'];
$portal_footer_colour = $portal_info['portal_footer_colour'];
$portal_header_colour = $portal_info['portal_header_colour'];
$portal_font_colour = $portal_info['portal_font_colour'];
$portal_keywords = $portal_info['portal_keywords'];
$portal_description = $portal_info['portal_description'];

# Used for the top div content if available.
$topgear_id = $portal_info['topgear_id'];

# User for right column

$allow_engineer_rego = $portal_info['allow_engineer_rego'];
$allow_provider_rego = $portal_info['allow_provider_rego'];
$allow_reseller_rego = $portal_info['allow_reseller_rego'];
$allow_client_rego = $portal_info['allow_client_rego'];

$fb_source_id = $portal_info['fb_source_id'];
$fb_parci_id = $portal_info['fb_parci_id'];
$allow_fb_rego = $portal_info['allow_fb_rego'];
$fb_app_id = $portal_info['fb_app_id'];
$fb_app_secret = $portal_info['fb_app_secret'];

$li_source_id = $portal_info['li_source_id'];
$li_parci_id = $portal_info['li_parci_id'];
$allow_linkedin_rego = $portal_info['allow_linkedin_rego'];
$li_app_id = $portal_info['li_app_id'];
$li_app_secret = $portal_info['li_app_secret'];

$gg_source_id = $portal_info['gg_source_id'];
$gg_parci_id = $portal_info['gg_parci_id'];
$allow_google_rego = $portal_info['allow_google_rego'];
$gg_app_id = $portal_info['gg_app_id'];
$gg_app_secret = $portal_info['gg_app_secret'];
$gg_app_devkey = $portal_info['gg_app_devkey'];

$allow_sc_rego = TRUE;
$sc_source_id = "8a5c8fb2-dd32-d0b4-3af1-5516a8746b5e"; # Allow Scalastica Portal Signups

$allow_wellbeing = $portal_info['allow_wellbeing'];

# Get external sessions
$sc_session = $_SESSION['scalastica'];
$fb_session = $_SESSION['facebook'];
$li_session = $_SESSION['linkedin'];
$gg_session = $_SESSION['google'];
#$sc_session,$fb_session

if (!$portal_skin){
   $portal_skin = "scalastica";
   }

if (!$portal_logo){
   $portal_logo = "css/".$portal_skin."/images/".$portal_skin."-logo.png";
   }
#
####################################################
# Standard formatting 

########################
# Page Config

$tablewidth = 980;
$tablewidth = "100%";

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

##############################
# 

$divstyle_params[0] = "98%"; // minwidth
$divstyle_params[1] = "25px"; // minheight
$divstyle_params[2] = "1%"; // margin_left
$divstyle_params[3] = "1%"; // margin_right
$divstyle_params[4] = "2px"; // padding_left
$divstyle_params[5] = "2px"; // padding_right
$divstyle_params[6] = "0px"; // margin_top
$divstyle_params[7] = "0px"; // margin_bottom
$divstyle_params[8] = "2px"; // padding_top
$divstyle_params[9] = "2px"; // padding_bottom
$divstyle_params[10] = $portal_header_colour." 50% 50% repeat-x"; // custom_color_back
$divstyle_params[11] = $portal_border_colour; // custom_color_border
$divstyle_params[12] = "left"; // custom_float
$divstyle_params[13] = "450"; // maxwidth
$divstyle_params[14] = ""; // maxheight

$portal_divstyle = $funky_gear->makedivstyles ($divstyle_params);
$custom_portal_divstyle = $portal_divstyle[5];

# End Portal Gear
#############################
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


# End
##########################################################
?>