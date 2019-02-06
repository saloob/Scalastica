<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-13
# Page: Left
############################################## 
# Debugging - show variables

  if (!function_exists('get_param')){
     include ("common.php");
     }

  $this_module = '78be7af9-e6a9-e9e6-c809-52b52e7e1a7b';
  $security_params[0] = $this_module;
  $security_params[1] = $lingo;
  $security_params[2] = $_SESSION['contact_id'];
  $security_check = $funky_gear->check_security($security_params);
  $security_access = $security_check[0];
  $security_level = $security_check[1];
  $security_role = $security_check[2];
  $system_action_add = $security_check[3];
  $system_action_delete = $security_check[4];
  $system_action_edit = $security_check[5];
  $system_action_export = $security_check[6];
  $system_action_import = $security_check[7];
  $system_action_view = $security_check[8];
  $system_action_list = $security_check[9];

//  $security_params[0] = " deleted=0 ";

  /*
  # how long to keep the cache files (hours)
  $cache_time = 1;

  # return location and name for cache file
  $cache_file = "/tmp/cache_l_".md5($hostname);

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

   */

/*
  switch ($system_action_list){

   case $action_rights_all:
//    $sec_params[0] .= " cmn_statuses_id_c != '".$standard_statuses_closed."' ";
   break;
   case $action_rights_none:
    $sec_params[0] .= " cmn_statuses_id_c = 'ZZZZZZZZZZZZZZZZZZ' ";
   break;
   case $action_rights_owner:
    $sec_params[0] .= " contact_id_c = '".$_SESSION['contact_id']."' ";
   break;
   case $action_rights_account:
    $sec_params[0] .= " account_id_c = '".$_SESSION['account_id']."' ";
   break;

  } // end system_action_list
*/

#foreach ($_POST as $name=>$value){

        //echo "Field: ".$name." - Value: ".$value."<BR>";

#        }

#
############################################## 

$section = "Body";
$page = "Body.php";
$sendvars = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
$lingobar = language_selector($section,$lingo, $sendvars, $page,$LeftDIV,$BodyDIV,$RightDIV);

###############################
# Public Access Menu

if (!$sess_account_id){
   $check_account_id = $parent_account_id;
   } else {
   $check_account_id = $sess_account_id;
   }

echo "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$portal_title."</font></B></center></div>";
echo "<div style=\"".$divstyle_white."\"><center>".$strings["Languages"].": ".$lingobar."</center></div>";


   # Every portal owner can have their own FB access details
#   if ($sess_contact_id != NULL && $fb_source_id != NULL && $sess_fb_userid != NULL && $allow_fb_rego == TRUE) {
#      $access = TRUE;
#      }

  if ($access){

     // Get Contact info
     $object_type = "Contacts";
     $api_action = "select_soap";
     $params = array();
     $params[0] = "contacts.id='".$sess_contact_id."'"; // query
     $params[1] = array("email1");
     $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $params);

     if (is_array ($result)){

        for ($cnt=0;$cnt < count($result);$cnt++){    
/*
            $first_name = $result[$cnt]['first_name'];
            $last_name = $result[$cnt]['last_name'];
            $description = $result[$cnt]['description'];
*/
            $email = $result[$cnt]['email1'];

            } // end for

        } // if array

     $login_menu .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=edit&value=".$sess_contact_id."&valuetype=Contacts');return false\">".$strings["PersonalAccount"]."<BR>".$email."</a></div>";

     $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"action_logout\" id=\"action_logout\" value=\"".$strings["action_logout"]."\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=logout&value=&valuetype=');timedRefresh(100);return false\"></center></div>";

     if ($allow_wellbeing == TRUE){

        #$login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"Manage Well-being\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php','do=Wellbeing&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=lightfull');document.getElementById('fade').style.display='block';return false\"></center></div>";

       $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"Manage Well-being\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Wellbeing&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=".$BodyDIV."');return false\"></center></div>";

        #$login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"lifestyle\" id=\"lifestyle\" value=\"Social Networking\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','do=Lifestyles&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></center></div>";
       $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"Social Networking\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=".$BodyDIV."');return false\"></center></div>";

        }

     if ($enable_hirorins_timer == TRUE){

       $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"hirorinstimer\" id=\"hirorinstimer\" value=\"Manage Hirorin's Timer\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=HirorinsTimer&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=".$BodyDIV."');return false\"></center></div>";

        } # if enable Hirokos Timer

     if ($allow_lifeplanner == TRUE){

       $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"lifeplanner\" id=\"lifeplanner\" value=\"Manage Life Planner\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=LifePlanning&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=".$BodyDIV."');return false\"></center></div>";

        } # if enable Hirokos Timer

     } else {

     # Not logged-in
     $fb_session = $_SESSION['facebook'];

     $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"action_logout\" id=\"action_logout\" value=\"".$strings["action_login"]."\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=login&value=&valuetype=');return false\"></center></div>";

     # Check for LinkedIn
     if ($allow_linkedin_rego == TRUE){

        #$login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"linkedin_connect_form\" value=\"LinkedIn\" onclick=\"location.href='linkedin/auth.php'\"></center></div>";

        $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"linkedin_connect_form\" id=\"linkedin_connect_form\" value=\"LinkedIn\" onClick=\"Scroller();loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','api-linkedin.php','action=login&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></div>";

        } # Allow LinkedIn

     # Check for Facebook
     if ($allow_fb_rego == TRUE && $fb_session == NULL){

        $fb_sendvars = "Body@".$lingo."@Facebook@Login@@";
        $fb_sendvars = $funky_gear->encrypt($fb_sendvars);

        #$login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb_connect_form\" value=\"Facebook\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','tr.php', 'pc=".$portalcode."&sv=".$fb_sendvars."&sendiv=lightform');return false\"></center></div>";
        #$login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb_connect_form\" value=\"Facebook\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','fb/index.php', 'pc=".$portalcode."&sv=".$fb_sendvars."&sendiv=lightform');return false\"></center></div>";

        #$login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb_connect_form\" value=\"Facebook\" onClick=\"loadpage('lightform','api-facebook.php')('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&sv=".$fb_sendvars."');return false\"></center></div>";
        $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb_connect_form\" id=\"fb_connect_form\" value=\"Facebook\" onClick=\"Scroller();loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','api-facebook.php','action=login&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></div>";

        } # Allow FB

     if ($allow_google_rego == TRUE){

        $login_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"gg_connect_form\" id=\"gg_connect_form\" value=\"Google\" onClick=\"Scroller();loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','api-google.php','action=login&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></div>";

        } # Allow GG

     } # else

echo $login_menu;

# End Public Access Menu
###############################
#

$system_menu = "<BR><center><img src=images/blank.gif width=90% height=10></center><BR><div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["Administration"]."</font></B></center></div>";
$config_menu = "<BR><center><img src=images/blank.gif width=90% height=10></center><BR><div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["SystemConfiguration"]."</font></B></center></div>";
$services_menu = "<BR><center><img src=images/blank.gif width=90% height=10></center><BR><div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["CatalogServices"]."</font></B></center></div>";
$account_menu = "<BR><center><img src=images/blank.gif width=90% height=10></center><BR><div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["AccountServices"]."</font></B></center></div>";
$user_menu = "<BR><center><img src=images/blank.gif width=90% height=10></center><BR><div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["UserServices"]."</font></B></center></div>";
$icondivstart = "<div style=\"width:10;float:left;padding-top:0;\">";
$linkdivstart = " <div style=\"width:180;float:left;padding-top:3;margin-left:8;padding-left:2;\">";
$linkdivend = "</div>";

$parent_account_id = $portal_info['parent_account_id'];
#echo "parent_account_id: ".$parent_account_id."<P>";

if ($sess_account_id != NULL){

   $ci_object_type = "AccountRelationships";
   $ci_action = "select";
   $ci_params[0] = " account_id1_c='".$sess_account_id."' && account_id_c='".$parent_account_id."' ";
   $ci_params[1] = "account_id_c,account_id1_c,entity_type"; // select array
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

           } // for

       } // is array

   } else {// if account

   # Do nothing - will not show special menu

   } 

if (!$auto_hostname){
   $hostname = $_SERVER['HTTP_HOST'];
   } else {
   // Auto script to do cron jobs for each host each 30 seconds
   $hostname = $auto_hostname;
   }

#echo "Entity Type: ".$entity_type."<P>";
 
#$portal_info = $funky_gear->portaliser($hostname);

# Entity Types | ID: a867fcdd-218a-34be-d0f2-51ca18235609
# Service Provider | ID: de438478-a493-51ad-ec49-51ca1a3aca3e
# Reseller Partner | ID: f2aa14f0-dc5e-16ce-87c9-51ca1af657fe
# Supplier Partner | ID: 644f1c78-18a6-e2c4-7789-51eea359fde9
# Client | ID: e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3

if ($account_id_c == $system_account){

   $base_services_menu = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/env_repair_16.gif width=16></div>".$linkdivstart."<B>".$strings["BaseServices"]."</B></a>".$linkdivend."</div>
";
   } elseif ($entity_type == 'de438478-a493-51ad-ec49-51ca1a3aca3e'){

   $base_services_menu = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/env_repair_16.gif width=16></div>".$linkdivstart."<B>".$strings["BaseServices"]."</B></a>".$linkdivend."</div>
";

   $base_services_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$parent_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/env_repair_16.gif width=16></div>".$linkdivstart."<B>Parent Portal Catalog</B></a>".$linkdivend."</div>
";

   $base_services_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$portal_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/env_repair_16.gif width=16></div>".$linkdivstart."<B>Portal Catalog</B></a>".$linkdivend."</div>
";

   } elseif ($entity_type != 'de438478-a493-51ad-ec49-51ca1a3aca3e' && $account_id_c != $system_account && $entity_type != 'e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3'){

   $base_services_menu = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$portal_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/env_repair_16.gif width=16></div>".$linkdivstart."<B>".$strings["BaseServices"]."</B></a>".$linkdivend."</div>
";
   } elseif ($entity_type == 'e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3'){

   $base_services_menu = "";

   }

   #$base_services_menu = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/env_repair_16.gif width=16></div>".$linkdivstart."<B>".$strings["BaseServices"]."</B></a>".$linkdivend."</div>";

#$services_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$parent_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/i_commercemanager_med.gif width=16></div>".$linkdivstart."<B>".$strings["Services"]."</B></a>".$linkdivend."</div>";

#############################
# Set Custom Navigation

  function do_navi ($portal_account_id){

   global $funky_gear,$portal_account_id,$sess_account_id,$BodyDIV,$strings,$crm_api_user, $crm_api_pass, $crm_wsdl_url,$divstyle_white,$divstyle_blue,$custom_portal_divstyle,$portal_font_colour,$lingo;

   $allow_navi_object_type = "ConfigurationItems";
   $allow_navi_action = "select";
   $allow_custom_navi_cit = "b55e3f9f-ee16-3a5d-474d-54eb2973e625";
   $allow_navi_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='".$allow_custom_navi_cit."' && name=1";
   $allow_navi_params[1] = "name"; // select array
   $allow_navi_params[2] = ""; // group;
   $allow_navi_params[3] = ""; // order;
   $allow_navi_params[4] = ""; // limit

   $allow_navi_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $allow_navi_object_type, $allow_navi_action, $allow_navi_params);

   if (is_array($allow_navi_items)){

      $navi_object_type = "ConfigurationItems";
      $navi_action = "select";
      $custom_navi_cit = "ad1d9ad1-0a25-0e49-3c18-54eb24956766";

      if ($sess_account_id == NULL){
         $extra_query = " && enabled=1 ";
         }

      $navi_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='".$custom_navi_cit."' ".$extra_query;
      $namer = "name_".$lingo;

      $navi_params[1] = "id,enabled,name,name_en,name_ja,image_url,account_id_c"; // select array
      $navi_params[2] = ""; // group;
      $navi_params[3] = ""; // order;
      $navi_params[4] = ""; // limit

      $navi_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $navi_object_type, $navi_action, $navi_params);

      if (is_array($navi_items)){

         $img_returner = $funky_gear->object_returner ('ConfigurationItemTypes', $custom_navi_cit);
         $cit_navi_image = $img_returner[7];

         for ($navi_cnt=0;$navi_cnt < count($navi_items);$navi_cnt++){

             $id = $navi_items[$navi_cnt]['id'];
             $enabled = $navi_items[$navi_cnt]['enabled'];
             $name = $navi_items[$navi_cnt][$namer];

             if (!$name){
                $name = $navi_items[$navi_cnt]['name'];
                }

             $navi_image = $navi_items[$navi_cnt]['image_url'];
             $navi_account_id_c = $navi_items[$navi_cnt]['account_id_c'];

             $edit = "";
             if ($sess_account_id != NULL && $sess_account_id == $portal_account_id){
                $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$id."&valuetype=ConfigurationItems');return false\"><font color=red>[<B>".$strings["action_edit"]."</B>]</font></a> ";
                }

             if ($navi_image == NULL){
                $navi_image = $cit_navi_image;
                }

             $navigation .= "<div style=\"".$divstyle_white."\"><img src=".$navi_image." width=16> ".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$id."&valuetype=ConfigurationItems');return false\"><font color=#151B54><B>".$name."</B></font></a></div>";

             } # for

         } # is array

      if ($sess_account_id == $portal_account_id || is_array($navi_items)){
         $navigation_title = "<BR><center><img src=images/blank.gif width=90% height=5><BR>";
         $navigation_title .= "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">Navigation</font></B></center></div>";
         }
   
         $total_navigation = $navigation_title;
         $total_navigation .= $navigation;

      if ($sess_account_id != NULL && $sess_account_id == $portal_account_id){

         $total_navigation .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$custom_navi_cit."&valuetype=ConfigurationItemTypes');return false\"><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

         } # if owner or enabled

      #$total_navigation .= "<BR><center><img src=images/blank.gif width=90% height=1></center><BR>";

      #echo $total_navigation;
      #echo "<BR><center><img src=images/blank.gif width=90% height=5></center><BR>";

      } # is array allow_navi_items

   return $total_navigation;

   } # end function

  # End navi function
  #########################
  # how long to keep the cache files (hours)

  $cache_time = 1;

  # return location and name for cache file
  #echo "$sess_account_id == $portal_account_id";

  if ($sess_account_id != NULL && $sess_account_id == $portal_account_id){
     $left_cache_file = "/tmp/cache_left_in_".$lingo."_".md5($hostname);
     } elseif ($sess_account_id == NULL){
     $left_cache_file = "/tmp/cache_left_out_".$lingo."_".md5($hostname);
     }

  # check that cache file exists and is not too old
  if (!file_exists($left_cache_file)){
     $navigation = do_navi($portal_account_id);
     file_put_contents($left_cache_file, $navigation);
     } elseif (filemtime($left_cache_file) < time() - $cache_time * 3600){
     $navigation = do_navi($portal_account_id);
     file_put_contents($left_cache_file, $navigation);
     } else {
     $navigation = file_get_contents($left_cache_file);
     } 

  echo $navigation;

#
#############################
# Shared Effects Integration

   $ci_object_type = "ConfigurationItems";
   $ci_action = "select";
   $ci_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='5ffacdc0-8d54-b786-eba2-55079c9d70b6' && name=1 ";
   $ci_params[1] = "id,name"; // select array
   $ci_params[2] = ""; // group;
   $ci_params[3] = ""; // order;
   $ci_params[4] = ""; // limit
  
   $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

   if (is_array($ci_items)){

      #$sharedeffects = "<BR><center><img src=images/blank.gif width=90% height=10></center><BR>";
      #$sharedeffects .= "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["action_search"]."</font></B></center></div>";

      $date = date("Y@m@d@G");
      $body_sendvars = $date."#Bodyphp";
      $body_sendvars = $funky_gear->encrypt($body_sendvars);
      $action_search_keyword = $strings["action_search_keyword"];
      $DateStart = $strings["DateStart"];
      $action_search = $strings["action_search"];

$sfxsearch = <<< SFXSEARCH
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="text" id="keyword" placeholder="$action_search_keyword" name="keyword" value="$search_keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <BR><input type="text" id="search_date" placeholder="$DateStart" name="search_date" value="$search_date" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="pg" name="pg" value="$body_sendvars" >
     <input type="hidden" id="value" name="value" value="" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="Effects" >
     <input type="hidden" id="valuetype" name="valuetype" value="Effects" >
     <BR><input type="button" name="button" value="$action_search" onclick="javascript:Scroller();loader('$BodyDIV');get(this.parentNode);" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
SFXSEARCH;

      $sfx_object_type = "Events";
      $sfx_action = "select";
      $sfx_params[0] = " deleted=0 && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') && (sclm_events_id_c='' || sclm_events_id_c IS NULL || sclm_events_id_c='NULL') ";
      $sfx_params[1] = "id,name,view_count"; // select array
      $sfx_params[2] = ""; // group;
      $sfx_params[3] = "view_count DESC"; // order;
      $sfx_params[4] = "15"; // limit
  
      $sfx_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);

      if (is_array($sfx_items)){

         $events = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=list&value=&valuetype=');return false\"><B>".$strings["action_showall"]." -></B></a></div>";

         for ($sfx_cnt=0;$sfx_cnt < count($sfx_items);$sfx_cnt++){

             $sfx_id = $sfx_items[$sfx_cnt]['id'];
             $event_name = $sfx_items[$sfx_cnt]['name'];
             #$event_name = $sfx_items[$sfx_cnt][$namer];
             #if (!$event_name){
             #   $event_name = $sfx_items[$sfx_cnt]['name'];
             #   }
             $view_count = $sfx_items[$sfx_cnt]['view_count'];

             $events .= "<a href=\"#\" onclick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$portalcode."&do=Effects&value=".$sfx_id."&valuetype=Effects&action=view');return false;\"><img src=images/SharedEffects-Action-50x50.png width=16 border=0 alt=".$event_name."> <font size=1>".$event_name." (".$view_count.")</font></a><BR>";
         
             } # for

         $addnew = "";
         if ($sess_contact_id != NULL){
             $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$sess_contact_id."&valuetype=Contact');return false\"><B>".$strings["action_addnew"]."</B></a></div>";
             }

         $events .= "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=list&value=&valuetype=');return false\"><B>".$strings["action_showall"]." -></B></a>";

         $sharedeffects .= "<BR><div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">Shared Effects</font></B></center></div>";


         $sharedeffects .= "<div style=\"".$divstyle_white."\">";
         if ($sess_contact_id != NULL){
            $sharedeffects .= "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=list&value=".$sess_contact_id."&valuetype=Contacts');return false\"><B>List My Events</B></a>";
            }
         $sharedeffects .= $sfxsearch;
         $sharedeffects .= "</div>";

         $sharedeffects .= $addnew."<div style=\"".$divstyle_white."\">".$events."</div>".$addnew;

         } # is array

      echo $sharedeffects;

      } # is array

# End Shared Effects
#############################
# Get portal configs
# Allow Global Portal: 4a67c6fb-42d0-8cb6-84b9-54deec34066b

$curr_services_menu = $services_menu;
$services_menu = "";

$ci_object_type = "ConfigurationItems";
$ci_action = "select";

$ci_params[0] = " deleted=0 && account_id_c='".$check_account_id."' && (sclm_configurationitemtypes_id_c='4a67c6fb-42d0-8cb6-84b9-54deec34066b' || sclm_configurationitemtypes_id_c='6ba459d7-3800-59bf-c2ea-54df2f50dd66') && name=1";
$ci_params[1] = "id,name,description,sclm_configurationitemtypes_id_c"; // select array
$ci_params[2] = ""; // group;
$ci_params[3] = ""; // order;
$ci_params[4] = ""; // limit

$ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

$service_exist = FALSE;

if (is_array($ci_items)){

   #$services_menu = $curr_services_menu;

   for ($cnt=0;$cnt < count($ci_items);$cnt++){

       $sclm_configurationitemtypes_id_c = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

       #$menu_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sclm_configurationitemtypes_id_c);
       #$menu_name = $menu_returner[0];
       #$menu_image = $menu_returner[7];

       switch ($sclm_configurationitemtypes_id_c){

        case '4a67c6fb-42d0-8cb6-84b9-54deec34066b':
         $thisvaltype = "Global";
         $sendval = "";
         $menu_image = "images/icons/GlobalShopping-36x36.png";
         $menu_name = "Global Catalog";
        break;
        case '6ba459d7-3800-59bf-c2ea-54df2f50dd66':
         $thisvaltype = "Accounts";
         $sendval = $check_account_id;
         $menu_image = "images/icons/i_commercemanager_med.gif";
         $menu_name = "Portal Catalog";
         $service_exist = TRUE;
        break;

       }

       $services_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$sendval."&valuetype=".$thisvaltype."');return false\">".$icondivstart."<img src=".$menu_image." width=16></div>".$linkdivstart."<B>".$menu_name."</B></a>".$linkdivend."</div>";

       } # for

   $services_menu = $curr_services_menu.$services_menu;

   } elseif ($base_services_menu != NULL) {# is array


   } 

# End get portal configs
#############################

/*

For now, removing from config_menu
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Security&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/sheild.png width=16></div>".$linkdivstart."<B>".$strings["Security"]."</B></a>".$linkdivend."</div>

<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=Billing&action=view&value=".$sess_account_id."&valuetype=Billing&sendiv=GRID');return false\">".$icondivstart."<img src=images/icons/i_billingmanager.gif width=16></div>".$linkdivstart."<B>".$strings["Billing"]." [GRID]</B></a>".$linkdivend."</div>

<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=&valuetype=ExternalSystem');return false\">".$icondivstart."<img src=images/icons/gear.png width=16></div>".$linkdivstart."<B>".$strings["ExternalSystemsConfiguration"]."</B></a>".$linkdivend."</div>

<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$sess_account_id."&valuetype=Infrastructure');return false\">".$icondivstart."<img src=images/icons/defender.png width=16></div>".$linkdivstart."<B>".$strings["InfraConfiguration"]."</B></a>".$linkdivend."</div>

<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Calls&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/i_phone.gif width=16></div>".$linkdivstart."<B>".$strings["CallLogs"]."</B></a>".$linkdivend."</div>


*/

$config_menu .= "
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/infrastructure_16.gif width=16></div>".$linkdivstart."<B>".$strings["AccountDetails"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Licensing&action=list&value=".$sess_account_id."&valuetype=Licensing');return false\">".$icondivstart."<img src=images/icons/password.png width=16></div>".$linkdivstart."<B>Licensing</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Billing&action=list&value=".$sess_account_id."&valuetype=Billing');return false\">".$icondivstart."<img src=images/icons/i_billingmanager.gif width=16></div>".$linkdivstart."<B>".$strings["Billing"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemTypes&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/objects-16x16x32b.png width=16></div>".$linkdivstart."<B>".$strings["ConfigurationItemTypes"]."</a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/defender.png width=16></div>".$linkdivstart."<B>Infrastructure Maintenance</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=&valuetype=PortalSet');return false\">".$icondivstart."<img src=images/icons/webspaces_32.gif width=16></div>".$linkdivstart."<B>".$strings["PortalConfiguration"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=list&value=&valuetype=EmailFilteringSet');return false\">".$icondivstart."<img src=images/icons/SearchOn.gif width=16></div>".$linkdivstart."<B>".$strings["EmailFiltering"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/Email-100x100.png width=16></div>".$linkdivstart."<B>".$strings["EmailLogs"]."</B></a>".$linkdivend."</div>
";

/*

*/

$account_menu .= "
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Projects&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/i_hspcservices.gif width=16></div>".$linkdivstart."<B>".$strings["Projects"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Opportunities&action=list&value=".$sess_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/i_businessdirector.gif width=16></div>".$linkdivstart."<B>".$strings["Opportunities"]."</B></a>".$linkdivend."</div>
";

if ($allow_infracerts == TRUE){

   $account_menu .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"Infracerts\" id=\"Infracerts\" value=\"Manage Infracerts\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infracerts&action=list&value=".$sess_account_id."&valuetype=Accounts&sendiv=".$BodyDIV."');return false\"></center></div>";

   } # if enable Infracerts

/*
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/SupportTicket.jpg width=16></div>".$linkdivstart."<B>".$strings["Tickets"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=TicketingActivities&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/SupportTicket.jpg width=16></div>".$linkdivstart."<B>".$strings["TicketingActivities"]."</B></a>".$linkdivend."</div>

*/

$user_menu .= "
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$sess_contact_id."&valuetype=');return false\">".$icondivstart."<img src=images/icons/i_users_med.gif width=16></div>".$linkdivstart."<B>".$strings["PersonalDetails"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Meetings&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/Partnership.png width=16></div>".$linkdivstart."<B>".$strings["Meetings"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Calendar&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/calendar.png width=16></div>".$linkdivstart."<B>".$strings["Calendar"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=list&value=".$sess_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/uu.png width=16></div>".$linkdivstart."<B>".$strings["ServiceSLARequests"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=list&value=".$sess_account_id."&valuetype=');return false\">".$icondivstart."<img src=images/icons/defender.png width=16></div>".$linkdivstart."<B>Infrastructure Maintenance</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Sprints&action=list&value=".$sess_account_id."&valuetype=');return false\">".$icondivstart."<img src=images/icons/defender.png width=16></div>".$linkdivstart."<B>Sprints</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=Ticketing&action=gridlist&value=&valuetype=&sendiv=GRID');return false\">".$icondivstart."<img src=images/icons/SupportTicket.jpg width=16></div>".$linkdivstart."<B>".$strings["Tickets"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Messages&action=list&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/MessagesIcon-100x100.png width=16></div>".$linkdivstart."<B>".$strings["Messages"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=list&value=".$sess_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/MyContacts-64x64.png width=16></div>".$linkdivstart."<B>".$strings["Contacts"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=list&value=58029bdc-251a-46ea-404c-527bfa90f57e&valuetype=ConfigurationItemTypes');return false\">".$icondivstart."<img src=images/icons/i_account_properties_med.gif width=16></div>".$linkdivstart."<B>".$strings["CallTree"]."</B></a>".$linkdivend."</div>
<div style=\"".$divstyle_white."\"> <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=list_all&value=&valuetype=');return false\">".$icondivstart."<img src=images/icons/ContentType-Images.gif width=16></div>".$linkdivstart."<B>".$strings["Content"]."</B></a>".$linkdivend."</div>
";

$system_menu .= "
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=list&value=&valuetype=');return false\">Accounts</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&action=list&value=&valuetype=');return false\">Events</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=list&value=&valuetype=');return false\">Effects</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Meetings&action=list&value=&valuetype=');return false\">Meetings</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Calendar&action=list&value=&valuetype=');return false\">Calendar</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Licensing&action=list&value=&valuetype=');return false\">Licensing</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Security&action=list&value=&valuetype=');return false\">".$strings["Security"]."</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SLA&action=list&value=&valuetype=');return false\">".$strings["SLAManagement"]."</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServicesPrices&action=list&value=&valuetype=');return false\">".$strings["ServicesPricing"]."</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemTypes&action=list&value=&valuetype=');return false\">".$strings["ConfigurationItemTypes"]."</a></center></div>
<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=list&value=&valuetype=');return false\">".$strings["ConfigurationItems"]."</a></center></div>
";

 switch ($portal_type){

  case 'system':
  case 'provider':
  case 'reseller':

//   echo "portal_type $portal_type <P>";
   $config_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=manage&value=".$sess_account_id."&valuetype=Accounts');return false\">".$icondivstart."<img src=images/icons/uu.png width=16></div>".$linkdivstart."<B>".$strings["ServicesPrices"]."</B></a>".$linkdivend."</div>";

   switch ($security_role){
 
    case $role_AccountAdministrator:
    case $role_DivisionAdministrator:

     //$services_menu .= $base_services_menu;

    break;

   } // switch

  break;
  case 'client':

  break;

  }

switch ($security_role){

 case $role_AccountAdministrator:
 case $role_SDM:

  $services_menu .= $base_services_menu;

  $menu .= $services_menu;
  $menu .= $config_menu;
  $menu .= $account_menu;
  $menu .= $user_menu;

 break;
 case $role_AccountMember:

  $menu .= $user_menu;

 break;
 case $role_DivisionAdministrator:

  $menu .= $services_menu;
  $menu .= $account_menu;
  $menu .= $user_menu;

 break;
 case $role_Guest:

  $menu .= $services_menu;

 break;
 case $role_SystemAdministrator:

  $services_menu .= $base_services_menu;

  $menu .= $system_menu;
  $menu .= $config_menu;
  $menu .= $services_menu;
  $menu .= $account_menu;
  $menu .= $user_menu;

 break;
 case $role_TeamLeader:

  $menu .= $user_menu;

 break;

} // end $security_role switch

echo $menu;

#echo "<div style=\"".$divstyle_white."\"><BR><img src=images/blank.gif width=50 height=10<BR>".$strings["BestViewedBrowsers"]."</div>";

#
############################################## 
?>