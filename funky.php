<?php
##############################################
# Form Builder
# Author: Matthew Edmond, Saloob
# Date: 2011-02-24
# Page: funky.php
############################################## 
# Namespace

/**
 * Scalastica Funky
 *
 * @category ScalasticaFunctions
 * @package  funky
 * @author   Matthew Edmond <saloobinc@gmail.com>
 * @license  http://www.saloob.com/ Apache License 2.0
 * @link     http://www.saloob.com/
 */

#
#############################
# Global Functions

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

class funky
{

################################
# Social Networking

 function social_networking($sn_params){

  global $strings,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$anonymity_params,$BodyDIV,$portal_header_colour,$portal_font_colour,$strings,$portalcode;

  # Check current signed-in user against content owner
  $contact_target = $sn_params[0]; # Contact Target
  $contact_maker = $sn_params[1]; # Contact Maker
  $this_action = $sn_params[2]; # Contact Maker    

  switch ($this_action){

   case 'connect':

    # My Private Connections: 24ac8d1e-9a9a-4f88-98c9-55500353563d 
    $ci_object_type = "ConfigurationItems";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && (contact_id_c='".$contact_target."' || contact_id_c='".$contact_maker."') && (name='".$contact_target."' || name='".$contact_maker."') && sclm_configurationitemtypes_id_c='24ac8d1e-9a9a-4f88-98c9-55500353563d'";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){
       /*
       for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];    

           } # for
       */

       $returner = " You are already connected.";

       } else {# is array
       
       $returner = " You are not connected - <a href=\"#Top\" onClick=\"Scroller();loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=SocialNetworking&action=add_connection&value=".$contact_target."&valuetype=SocialNetworking&sendiv=lightform');document.getElementById('fade').style.display='block';return false\">Make Connection!</a>";
       }

   break;

  } # switch

 return $returner;

 } # social networking function

# Social Networking
################################
# Anonymity

   public function anonymity($sent_params){

    global $strings,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$anonymity_params,$BodyDIV,$portal_header_colour,$portal_font_colour,$strings;

    # Check current signed-in user against content owner
    $contact_owner = $sent_params[0]; # Content owner
    $account_owner = $sent_params[1]; 
    $contact_viewer = $sent_params[2];
    $account_viewer = $sent_params[3];
    $do = $sent_params[4];
    $valtype = $sent_params[5];
    $val = $sent_params[6];
    $contact_type = $sent_params[7];

    $Anonymous = $anonymity_params[0];
    $Cloakname = $anonymity_params[1];
    $Fullname = $anonymity_params[2];
    $Nickname = $anonymity_params[3];

    if ($contact_owner != NULL){

       # Owner is not viewer

       if ($contact_owner != NULL && $account_owner == NULL){

          $accid_object_type = "Contacts";
          $accid_action = "get_account_id";
          $accid_params[0] = $contact_owner;
          $accid_params[1] = "account_id";
          $account_owner = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

          }

       # If the contact and account exist, then a good chance both data are real and usable
       # May be occassions when null data is sent, such as with contact collection for event contacts

       if ($contact_owner != NULL && $account_owner != NULL){

          $object_type = 'Contacts';
          $action = 'select_cstm';
          $params = array();
          $params[0] = "id_c='".$contact_owner."'";
          $params[1] =  "id_c,twitter_name_c,twitter_password_c,linkedin_name_c,nickname_c,cloakname_c,default_name_type_c,social_network_name_type_c,friends_name_type_c,profile_photo_c";
          $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
       
          if (is_array($the_list)){
      
             for ($cnt=0;$cnt < count($the_list);$cnt++){

                 # $contact_profile_id = $the_list[$cnt]['id'];
                 $default_name_type_c = $the_list[$cnt]['default_name_type_c'];
                 $social_network_name_type_c = $the_list[$cnt]['social_network_name_type_c'];
                 $friends_name_type_c = $the_list[$cnt]['friends_name_type_c'];
                 $nickname = $the_list[$cnt]['nickname_c'];
                 $cloakname = $the_list[$cnt]['cloakname_c'];
                 $profile_photo = $the_list[$cnt]['profile_photo_c'];
                 $twitter_name_c = $the_list[$cnt]['twitter_name_c'];
                 $twitter_password_c = $the_list[$cnt]['twitter_password_c'];
                 $linkedin_name_c = $the_list[$cnt]['linkedin_name_c'];

                 } # end for

             } else {

             # If haven't updated in their Profile - MUST keep as anonymous
             $default_name_type_c = $Anonymous;
             $social_network_name_type_c = $Anonymous;
             $friends_name_type_c = $Anonymous;

             } # end else if no profile settings

          } # contact_owner != NULL && account_owner != NULL

       } # if owner

    if ($contact_owner != NULL && $account_owner != NULL){

       # Get Real Name if not anonymous

       if ($default_name_type_c == $Fullname || $social_network_name_type_c == $Fullname || $friends_name_type_c == $Fullname){

          $object_type = "Contacts";
          $action = "select_soap";
          $params = array();
          $params[0] = "contacts.id='".$contact_owner."'"; // query
          $params[1] = array("first_name","last_name","description");
          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
       
          if (is_array($result)){

             for ($cnt=0;$cnt < count($result);$cnt++){

                 $first_name = $result[$cnt]['first_name'];
                 $last_name = $result[$cnt]['last_name'];
                 $description = $result[$cnt]['description'];

                 } # end for

             } # end if array

          } # end if Fullname

       if ($twitter_name_c != NULL){

          $embed_name = $portal_title." Member Profile for ".$twitter_name_c;
          $embed_name = urlencode ($embed_name);
          $twitter = "<iframe src=\"Twitter.php?action=embedd&vartype=Contacts&page_title=".$embed_name."&name=".$twitter_name_c."\"
           scrolling=\"no\" frameborder=\"0\"
           style=\"border:none; width:450px; height:80px\"></iframe>";
          }

       if ($linkedin_name_c != NULL){

          $embed_name = $portal_title." Member Profile for ".$linkedin_name_c;
          $embed_name = urlencode ($embed_name);
          $linkedin = "<iframe src=\"Linkedin.php?action=embedd&vartype=Contacts&page_title=".$embed_name."&name=".$linkedin_name_c."\"
           scrolling=\"no\" frameborder=\"0\"
           style=\"border:none; width:450px; height:80px\"></iframe>";
          }

       $show_name = $strings["Anonymous"];

       switch ($social_network_name_type_c){

        case '':
        case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
         $show_name = $strings["Anonymous"];
         $description = "";
         $profile_photo = "";
        break;
        case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': # Full Name
         $show_name = $first_name." ".$last_name;
        break;
        case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': # Nickname
         $show_name = $nickname;
        break;
        case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': # Cloakname
         $show_name = $cloakname;
        break;

       }

       $anonymity_names['social_network_name'] = $show_name;
       $anonymity_names['social_network_name_anonymity'] = $social_network_name_type_c;
   
       switch ($default_name_type_c){
   
        case '':
        case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
         $show_name = $strings["Anonymous"];
         $description = "";
         $profile_photo = "";
        break;
        case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': # Full Name
         $show_name = $first_name." ".$last_name;
        break;
        case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': # Nickname
         $show_name = $nickname;
        break;
        case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': # Cloakname
         $show_name = $cloakname;
        break;
   
       }
   
       $anonymity_names['default_name'] = $show_name;
       $anonymity_names['default_name_anonymity'] = $default_name_type_c;
   
       switch ($friends_name_type_c){

        case '':
        case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
         $show_name = $strings["Anonymous"];
         $description = "";
         $profile_photo = "";
        break;
        case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': # Full Name
         $show_name = $first_name." ".$last_name;
        break;
        case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': # Nickname
         $show_name = $nickname;
        break;
        case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': # Cloakname
         $show_name = $cloakname;
        break;

       }

       $anonymity_names['friends_name'] = $show_name;
       $anonymity_names['friends_name_anonymity'] = $friends_name_type_c;

       if ($contact_viewer != NULL){
          # First see if same account or same person
          if ($contact_owner == $contact_viewer){
   
             $anonymity_name = "You";
      
             } elseif ($account_owner == $account_viewer){
   
             $anonymity_name = $anonymity_names['friends_name'];
   
             } elseif ($account_owner != $account_viewer){

             # Check if the current viewer is in SNs
             if ($do == 'SocialNetworking'){
                $anonymity_name = $anonymity_names['social_network_name'];
                } else {
                $anonymity_name = $anonymity_names['default_name'];
                }

             } else {
             $anonymity_name = $anonymity_names['default_name'];
             } 

          } else {

          $anonymity_name = $anonymity_names['default_name'];

          } 

       if ($contact_owner != NULL && $contact_viewer != NULL && $contact_owner==$contact_viewer){
          $show_name = "You";
          }

       if (!$profile_photo){
          $profile_photo = "images/profile_photo_default.png";
          }

       if ($description != NULL){
          $description = str_replace("\n", "<br>", $description);
          }

       #$contact_profile = "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:4px;margin-bottom:4px;margin-left:4px;margin-right:4px; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["Member"]."</B></font></center></div>";

       $sendmessage = "";
       if ($contact_owner != NULL){
          $sendmessage = " <a href=\"#Top\" onClick=\"Scroller();loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$contact_owner."&valuetype=Contacts&sendiv=lightform&related=".$do."&relval=".$val."');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'>Send Message</a> ";
          }

       $connect_button = "";
       if ($contact_owner != NULL && $contact_viewer != NULL && $contact_owner != $contact_viewer){
          # Allow connection
          # Check if connection exists yet or not
          $sn_params[0] = $contact_owner; # Contact Target
          $sn_params[1] = $contact_viewer; # Contact Maker
          $sn_params[2] = "connect";
          $connect_button = $this->social_networking($sn_params);
          }
   
       # List Social Networks
       $contact_profile .= "<div style=\"background-color: #FFFFFF;float:left;height:60px;padding-top:4px;padding-left:4px;padding-right:4px;width:60px;overflow: auto;border: 1px solid #ffcc66;margin-left:8px;\"><center><img src=".$profile_photo." width=50px></center></div><div style=\"background-color:#FFFFFF;padding-left:4px;padding-right:4px;width:385px;height:60px;padding-top:4px;overflow: auto;border: 1px solid #ffcc66;margin-right:4px;\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$contact_owner."&valuetype=".$do."');return false\"><B><font color=#151B54 size=3>".$show_name."</font></B></a> ".$sendmessage." ".$connect_button."<BR><font size=2>".$description."</font><BR>".$twitter."<BR>".$linkedin."</div>";

       #$anonymity_namer[0] = $anonymity_name." (".$contact_owner.")";
       $anonymity_namer[0] = $anonymity_name;
       $anonymity_namer[1] = $description;
       $anonymity_namer[2] = $profile_photo;
       $anonymity_namer[3] = $contact_profile;
       $anonymity_namer[4] = $anonymity_names; # all types embedded in array

       } else {# if not null

       $anonymity_namer = "";

       } 

    return $anonymity_namer;

    } # end function

# End Anonymity
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
    $sec_params[0] = " deleted=0 && role='".$role_c."' && system_module='".$system_module."' ";
    $sec_params[1] = "access,security_level,role,system_action_create,system_action_delete,system_action_edit,system_action_export,system_action_import,system_action_view_details,system_action_view_list"; // select array
    $sec_params[2] = ""; // group;
    $sec_params[3] = ""; // order;
    $sec_params[4] = ""; // limit
    $sec_params[5] = $lingoname; 

    $security_items = "";
    $security_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $security_object_type, $security_action, $sec_params);
 
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

# Check security
################################
# Check Social Network

  function check_sn ($sn_params){

   global $api_user, $api_pass, $crm_wsdl_url,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$standard_statuses_closed,$assigned_user_id;

   $do = $sn_params[0];
   $object_id = $sn_params[1];
   $owner_account_id = $sn_params[2];
   $owner_contact_id = $sn_params[3];
   $user_account_id = $sn_params[4];
   $user_contact_id = $sn_params[5];
   $sendiv = $sn_params[6];

   # Check if wrapper exists for this particular object

   switch ($do){

   case 'Accounts':

    $sn_id = "6898e8d5-e6b5-eda3-b1bc-55220a1b5037";
    $sn_returner = $this->object_returner ($do, $object_id);
    $sn_name = $sn_returner[0];

   break;
   case 'Contacts':

    $sn_id = "140cf7f9-fc5c-cb9c-2082-55220a924268";
    $sn_returner = $this->object_returner ($do, $object_id);
    $sn_name = $sn_returner[0];

   break;
   case 'Events':
   case 'Effects':

    $sn_id = "4e4233fd-bd1b-cf45-8baa-55220aeeadea";

    $sn_returner = $this->object_returner ($do, $object_id);
    $sn_name = $sn_returner[0];

   break;
   case 'Lifestyles':

    $sn_id = "8be14b88-4b94-8325-ccd4-55220b6319d9"; # Lifestyle & State Categories
    $owner_account_id = "321f338d-5986-3a94-e391-548e62c74a22";
    $owner_contact_id = "e761b2e7-8e6d-e75c-f0ee-548a4210f6cd";
    $addparams = "&sn_cit=".$object_id;
    $sn_returner = $this->object_returner ("ConfigurationItemTypes", $object_id);
    $sn_name = $sn_returner[0];

   break;
   case 'AccountsServices':

    $sn_id = "347e25e9-e3af-e3cc-e33c-55220ab84201";
    $sn_returner = $this->object_returner ($do, $object_id);
    $sn_name = $sn_returner[0];

   break;

   } # switch

   $sclm_object_type = "ConfigurationItems";
   $sclm_action = "select";
   $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$sn_id."' && name='".$object_id."' ";
   $sclm_params[1] = "id,name,enabled";
   $sclm_params[2] = "";
   $sclm_params[3] = "";
   $sclm_params[4] = "";

   $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

   if (is_array($sclm_rows)){

      # Wrapper Exists
      for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

          # Use the ID as the parent CI

          $id = $sclm_rows[$cnt]['id'];
          $name = $sclm_rows[$cnt]['name'];
          $enabled = $sclm_rows[$cnt]['enabled'];
   
          } # for

      # ID exists
      $sclm_sn_object_type = "ConfigurationItems";
      $sclm_sn_action = "select";
      $sclm_sn_params[0] = " deleted=0 && sclm_configurationitems_id_c='".$id."' && contact_id_c='".$user_contact_id."' ";
      $sclm_sn_params[1] = "id,name,enabled";
      $sclm_sn_params[2] = "";
      $sclm_sn_params[3] = "";
      $sclm_sn_params[4] = "";

      $sclm_sn_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_sn_object_type, $sclm_sn_action, $sclm_sn_params);

      if (is_array($sclm_sn_rows)){

         for ($cnt=0;$cnt < count($sclm_sn_rows);$cnt++){

             $id = $sclm_sn_rows[$cnt]['id'];
             $title = $sclm_sn_rows[$cnt]['name'];
             #$description = $sclm_sn_rows[$cnt]['description'];
             #$enabled = $sclm_sn_rows[$cnt]['enabled'];

             } # for
   
         # Contact has joined the SN
         $status = TRUE;
         $sn_button = "You are a member of the <B>\"".$sn_name."\"</B> Social Network with profile, ".$title."<P><input type=\"button\" style=\"font-family: v; font-size: 12pt;text-align: center;font-weight: bold; background-color: BLUE; border: 1px solid #5E6A7B;  border-radius:5px; width:80%;height:50px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" name=\"sn\" id=\"sn\" value=\"Got to the ".$sn_name." Social Network\" onClick=\"loader('".$sendiv."');document.getElementById('".$sendiv."').style.display='block';doBPOSTRequest('".$sendiv."','Body.php','pc=".$portalcode."&do=SocialNetworking&action=view&value=".$id."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\">";

         } else {# is array

         $status = FALSE;
         $sn_button = "You are not yet a member of the <B>\"".$sn_name."\"</B> Social Network.<P><input type=\"button\" style=\"font-family: v; font-size: 12pt;text-align: center;font-weight: bold; background-color: RED; border: 1px solid #5E6A7B;  border-radius:5px; width:80%;height:50px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" name=\"sn\" id=\"sn\" value=\"Join the ".$sn_name." Social Network\" onClick=\"loader('".$sendiv."');document.getElementById('".$sendiv."').style.display='block';doBPOSTRequest('".$sendiv."','Body.php','pc=".$portalcode."&do=SocialNetworking&action=add&value=".$id."&valuetype=".$do.$addparams."&sendiv=".$sendiv."');return false\">";

         } # is array

      } else {# is array

      # Wrapper Doesn't exist - create it

      $process_object_type = "ConfigurationItems";
      $process_action = "update";
      $process_params = "";
      $process_params = array();
      $process_params[] = array('name'=>'name','value' => $object_id); # Acc Service ID
      $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
      $process_params[] = array('name'=>'description','value' => $object_id);
      $process_params[] = array('name'=>'account_id_c','value' => $owner_account_id);
      $process_params[] = array('name'=>'contact_id_c','value' => $owner_contact_id);
      $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $sn_id);
      $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
      $process_params[] = array('name'=>'enabled','value' => 1);

      $sn_service_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
      $sn_service_id = $sn_service_result['id'];

      $status = TRUE;
      $sn_button = "<input type=\"button\" style=\"font-family: v; font-size: 12pt;text-align: center;font-weight: bold; background-color: #1560BD; border: 1px solid #5E6A7B;  border-radius:5px; width:80%;height:20px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\ name=\"sn\" id=\"sn\" value=\"Join the ".$sn_name." Social Network\" onClick=\"loader('".$sendiv."');document.getElementById('".$sendiv."').style.display='block';doBPOSTRequest('".$sendiv."','Body.php','pc=".$portalcode."&do=SocialNetworking&action=add&value=".$sn_service_id."&valuetype=".$do.$addparams."&sendiv=".$sendiv."');return false\">";

      } # is array

  $sn_status[0] = $status;
  $sn_status[1] = $sn_button;

  return $sn_status;

  } # end function

# Check Social Network
################################
# Child Access

  function child_access ($child){

   global $api_user, $api_pass, $crm_wsdl_url;

   $sclm_object_type = "ConfigurationItems";
   $sclm_action = "select";
   $sclm_params[0] = " deleted=0 && sclm_scalasticachildren_id_c='".$child."' ";
   $sclm_params[1] = "*";
   $sclm_params[2] = "";
   $sclm_params[3] = "";
   $sclm_params[4] = "";

   $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

   for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

       $id = $sclm_rows[$cnt]['id'];
       $name = $sclm_rows[$cnt]['name'];
       $ci_type_id = $sclm_rows[$cnt]['ci_type_id'];

       if ($ci_type_id == '6321083c-f187-736c-0f59-51aa7d8d0e1d'){
          $child_info['external_source_type_id'] = $this->encrypt($name);
          }

       if ($ci_type_id == 'b96c3687-8203-9f05-ab21-51a9dae3ad9f'){ //external_url
          $child_info['external_url'] = $this->encrypt($name);
          }

       if ($ci_type_id == '9254a5ad-698a-2254-6127-51a9da598e45'){ //external_admin_name
          $child_info['external_admin_name'] = $this->encrypt($name);
          }

       if ($ci_type_id == '4dae87e1-3127-d7f1-d963-51a9da793fe5'){ //external_admin_password
          $child_info['external_admin_password'] = $this->encrypt($name);
          }

       if ($ci_type_id == 'b656325e-95ce-cc9f-9e80-5219c4a9b430'){ //external_account
          $child_info['external_account'] = $this->encrypt($name);
          }

       } // end for

   return $child_info;

  } // end function

# End Child Access
##########################
# Google date format

function date3339($timestamp=0) {

    if (!$timestamp) {
        $timestamp = time();
       }

    #$date = date('Y-m-d\TH:i:s', $timestamp);
    $date = strtotime(date("Y-m-d\TH:i:s", strtotime($timestamp)));
    $date = date("Y-m-d\TH:i:s", $date);

    #echo  "Date: $date <BR>";

    $matches = array();
    if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
        $date .= $matches[1].$matches[2].':'.$matches[3];
    } else {
        $date .= 'Z';
    }
    return $date;
}

# Google date format
################################
# Get Country

  function get_country($countryparams){

   global $cmn_countries_id_c;

   $type = $countryparams[0];

   switch ($type){

    case 'by_contact':

     $contact_id = $countryparams[1];
     $country_object_type = 'Contacts';
     $country_action = 'select_cstm';
     $country_params = array();
     $country_params[0] = "id_c='".$contact_id."'";
     $country_params[1] = "cmn_countries_id_c"; 

     $country_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $country_object_type, $country_action, $country_params);

     if (is_array($country_list)){
      
        for ($cnt=0;$cnt < count($country_list);$cnt++){

            #$password_c = $the_list[$cnt]['password_c'];
            #$twitter_name_c = $the_list[$cnt]['twitter_name_c'];
            #$twitter_password_c = $the_list[$cnt]['twitter_password_c'];
            #$linkedin_name_c = $the_list[$cnt]['linkedin_name_c'];
            #$nickname_c = $the_list[$cnt]['nickname_c'];
            #$cloakname_c = $the_list[$cnt]['cloakname_c'];
            #$profile_photo_c = $the_list[$cnt]['profile_photo_c'];
            #$role_c = $the_list[$cnt]['role_c'];
            #$social_network_name_type_c = $the_list[$cnt]['social_network_name_type_c'];
            #$default_name_type_c = $the_list[$cnt]['default_name_type_c'];
            #$friends_name_type_c = $the_list[$cnt]['friends_name_type_c'];
            $countries_id_c = $country_list[$cnt]['cmn_countries_id_c'];
            #$cmn_languages_id_c = $the_list[$cnt]['cmn_languages_id_c'];

            } // end for
      
        } // end if array

    break; # by_contact
    case 'by_event':

     $event_id = $countryparams[1];
     $country_object_type = 'Events';
     $country_action = 'select';
     $country_params = array();
     $country_params[0] = "id='".$event_id."'";
     $country_params[1] = "cmn_countries_id_c"; 

     $country_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $country_object_type, $country_action, $country_params);

     if (is_array($country_list)){
      
        for ($cnt=0;$cnt < count($country_list);$cnt++){

            $countries_id_c = $country_list[$cnt]['cmn_countries_id_c'];

            } // end for
      
        } // end if array

    break; # by_event

   } # switch

  if ($countries_id_c != NULL){
     $country_details = $this->object_returner ("Countries", $countries_id_c);
     $country_name = $country_details[0];
     } else {
     $countries_id_c = $cmn_countries_id_c;
     $country_details = $this->object_returner ("Countries", $countries_id_c);
     $country_name = $country_details[0];
     }

  $country_details[0] = $countries_id_c;
  $country_details[1] = $country_name;

  return $country_details;

  } # end function

# Get Country
################################
# Get Currencies

  function get_currency_rates ($package){

   $file = "latest.json";
   $app_id = "30c42832e35445d88dbcbb232dcec12d";
   $curr_url = "https://openexchangerates.org/api/".$file."?app_id=".$app_id;
   #$ch = curl_init("https://openexchangerates.org/api/{$file}?app_id={$appId}&symbols={$currencies}");
   $ch = curl_init($curr_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

   # Get the data:
   $json = curl_exec($ch);
   curl_close($ch);

   # Decode JSON response:
   $exchangeRates = json_decode($json);

   #var_dump($exchangeRates);

   #$currencies = array (AED,AFN,ALL,AMD,ANG,AOA,ARS,AUD,AWG,AZN,BAM,BBD,BDT,BGN,BHD,BIF,BMD,BND,BOB,BRL,BSD,BTC,BTN,BWP,BYR,BZD,CAD,CDF,CHF,CLF,CLP,CNY,COP,CRC,CUC,CUP,CVE,CZK,DJF,DKK,DOP,DZD,EEK,EGP,ERN,ETB,EUR,FJD,FKP,GBP,GEL,GGP,GHS,GIP,GMD,GNF,GTQ,GYD,HKD,HNL,HRK,HTG,HUF,IDR,ILS,IMP,INR,IQD,IRR,ISK,JEP,JMD,JOD,JPY,KES,KGS,KHR,KMF,KPW,KRW,KWD,KYD,KZT,LAK,LBP,LKR,LRD,LSL,LTL,LVL,LYD,MAD,MDL,MGA,MKD,MMK,MNT,MOP,MRO,MTL,MUR,MVR,MWK,MXN,MYR,MZN,NAD,NGN,NIO,NOK,NPR,NZD,OMR,PAB,PEN,PGK,PHP,PKR,PLN,PYG,QAR,RON,RSD,RUB,RWF,SAR,SBD,SCR,SDG,SEK,SGD,SHP,SLL,SOS,SRD,STD,SVC,SYP,SZL,THB,TJS,TMT,TND,TOP,TRY,TTD,TWD,TZS,UAH,UGX,USD,UYU,UZS,VEF,VND,VUV,WST,XAF,XAG,XAU,XCD,XDR,XOF,XPD,XPF,XPT,YER,ZAR,ZMK,ZMW,ZWL);

   #$disclaimer = $exchangeRates->disclaimer;
   #$license = $exchangeRates->license;
   #$timestamp = $exchangeRates->timestamp;
   #$base = $exchangeRates->base;
   $rates = $exchangeRates->rates;
   #$USD = $rates->USD;
   #$AUD = $rates->AUD;
   #$JPY = $rates->JPY;

   if ($package != NULL){

      if (is_array($package)){

         foreach ($package as $check_rate){

                 $return_rates[] = $rates->$check_rate;

                 } # foreach

         #$rate_a = $package[0];
         #$rate_a = $rates->$rate_a;
         #$rate_b = $package[1];
         #$rate_b = $rates->$rate_b;

         #$return_rates[0] = $rate_a;
         #$return_rates[1] = $rate_b;

         } else {

         $return_rates = $rates->$package;

         } 

      } else {

      $return_rates = $rates;

      }

   #var_dump($rates);

   #foreach ($rates as $curr=>$rate){
           #echo $curr.": ".$rate."<BR>";
   #        $currencies .= $curr.",";
   #        }

   #echo $currencies;
   #echo "USD: ".$USD;
   #echo "AUD: ".$AUD;
   #echo "JPY: ".$JPY;

   # USD:1 == AUD: 1.365562 == JPY: 108.9751
   # 1 AUD in JPY = 108.9751 / 1.365562 = 79.80238
   # 1 JPY in AUD = 1.365562 / 108.9751 = 0.012530
   # 100 JPY in AUD = 1.253095

  return $return_rates;

  } # end function

# Get Currencies
################################
# Partner pricing - show or not

  function get_pricing_partners ($package){

   global $portal_account_id;

   # Use the given acc as the parent - find any children

   $check_acc_id = $package[0];

   $ci_object_type = "AccountRelationships";
   $ci_action = "select";
   $ci_params[1] = "account_id_c='".$check_acc_id."' ";
   $ci_params[1] = "id,account_id_c,account_id1_c"; // select array
   $ci_params[2] = ""; // group;
   $ci_params[3] = " name, date_entered DESC "; // order;
   $ci_params[4] = ""; // limit
  
   $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

   if (is_array($ci_items)){

      $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';

      for ($cnt=0;$cnt < count($ci_items);$cnt++){

          $acc_rel_id = $ci_items[$cnt]['id'];

          # Child acc - whatever type
          $child_account_id = $ci_items[$cnt]['child_account_id'];

          # Get Accounts Sharing Set
          $cis_object_type = "ConfigurationItems";
          $cis_action = "select";
          $cis_params[0] = " sclm_configurationitemtypes_id_c='".$acc_sharing_set."' && name='".$acc_rel_id."' ";
          $cis_params[1] = "id"; // select array
          $cis_params[2] = ""; // group;
          $cis_params[3] = ""; // order;
          $cis_params[4] = ""; // limit 

          $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

          if (is_array($cis_list)){

             for ($ciscnt=0;$ciscnt < count($cis_list);$ciscnt++){

                 $cis_id = $cis_list[$ciscnt]['id'];

                 # Get Account to be shared
                 $shared_account_cit = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

                 $cis_acc_object_type = "ConfigurationItems";
                 $cis_acc_action = "select";
                 $cis_acc_params[0] = " sclm_configurationitems_id_c='".$cis_id."' && sclm_configurationitemtypes_id_c='".$shared_account_cit."' ";
                 $cis_acc_params[1] = "id"; // select array
                 $cis_acc_params[2] = ""; // group;
                 $cis_acc_params[3] = ""; // order;
                 $cis_acc_params[4] = ""; // limit
  
                 $cis_acc_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_acc_object_type, $cis_acc_action, $cis_acc_params);

                 if (is_array($cis_acc_list)){

                    for ($cntcisacc=0;$cntcisacc < count($cis_acc_list);$cntcisacc++){
 
                        $cis_acc_id = $cis_acc_list[$cntcisacc]['id'];

                        # Check if this acc allowed to share prices
                        # Shared Partner Pricing (Within own portal)
                        $acc_shared_type_pricing = '58a896be-c277-844b-f051-54ebedac5dd4'; 
                        $shp_object_type = "ConfigurationItems";
                        $shp_action = "select";
                        $shp_params[0] = " sclm_configurationitems_id_c='".$cis_acc_id."' && sclm_configurationitemtypes_id_c='".$acc_shared_type_pricing."' ";
                        $shp_params[1] = "sclm_configurationitemtypes_id_c";
                        $shp_params[2] = ""; // group;
                        $shp_params[3] = "sclm_configurationitemtypes_id_c ASC"; // order;
                        $shp_params[4] = ""; // limit
  
                        $shp_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $shp_object_type, $shp_action, $shp_params);

                        if (is_array($shp_list)){

                           if (!in_array($child_account_id,$allowed_accounts_arr)){
                              $allowed_accounts_arr[] = $child_account_id;
                              }

                           } # is array shp_list

                        } # for cis_acc_list
 
                    } # is array cis_acc_list

                 } # for cis_list

             } # is array cis_list

          } // end for ci_items
      
      } # is array ci_items

   if (is_array($allowed_accounts_arr)){

      $allowed_accs = count($allowed_accounts_arr);
      $allcount = 0;

      $relaccquery = " && (account_id_c='".$portal_account_id."' ";

      if ($check_acc_id != NULL && $check_acc_id != $portal_account_id){
         # Allow the accounts own prices to show
         $relaccquery .= " || account_id_c='".$check_acc_id."' ";
         }

      #$relaccquery .= " || account_id_c='de8891b2-4407-b4c4-f153-51cb64bac59e' ";

      foreach ($allowed_accounts_arr as $allkey=>$child_acc_id){

              if ($allcount == 0 && $allowed_accs>1){
                 $relaccquery .= "|| account_id_c='".$child_acc_id."' ";
                 } elseif ($allowed_accs==1){
                 $relaccquery .= "|| account_id_c='".$child_acc_id."' )";
                 } elseif (($allcount == $allowed_accs-1) && $allowed_accs>1) {
                 $relaccquery .= "|| account_id_c='".$child_acc_id."' )";
                 } else {
                 $relaccquery .= "|| account_id_c='".$child_acc_id."' ";
                 }

              $allcount++;

              } # foreach

      } elseif ($portal_account_id != NULL){

      #if ($check_acc_id != NULL){
      if ($check_acc_id != NULL && $check_acc_id != $portal_account_id){
         #$relaccquery = " && (account_id_c='".$portal_account_id."' || account_id_c='".$check_acc_id."' || account_id_c='de8891b2-4407-b4c4-f153-51cb64bac59e')";
         $relaccquery = " && (account_id_c='".$portal_account_id."' || account_id_c='".$check_acc_id."')";
         } else {
         #$relaccquery = " && (account_id_c='".$portal_account_id."' || account_id_c='de8891b2-4407-b4c4-f153-51cb64bac59e') ";
         $relaccquery = " && account_id_c='".$portal_account_id."' ";
         } 

      } # end if is_array($allowed_accounts_arr

  return $relaccquery;

  } # end get_pricing_partners function

# End get_pricing_partners function
################################
# Scheduling

  function do_scheduler ($sche_package){

   # Scheduling | CIT: 42b87b36-aadd-1d0a-2483-57121e2264f2
   # Loop through the above CIT for all types of schedulers

   # Consider the timezone
   # Gather any Service SLAs attached to this schedule

   $auto = $sche_package[0]; # Not used yet

   $scheduler_cit = '42b87b36-aadd-1d0a-2483-57121e2264f2';

   # Service SLAs - Auto-orders for SLA Requests | CIT: 9afa5bc2-9a1f-c831-b032-57122091b780
   $ord_scheduler_cit = '9afa5bc2-9a1f-c831-b032-57122091b780';

   $datetime = date("Y-m-d G:i:s");
   $today = date("Y-m-d");
   $today_day = date("d");
   #$target_date = date('Y-m-d', strtotime('+7 days'));

   $scheduler_object_type = "ConfigurationItemTypes";
   $scheduler_action = "select";
   $scheduler_params[0] = " sclm_configurationitemtypes_id_c='".$scheduler_cit."' ";
   $scheduler_params[1] = "id"; # select
   $scheduler_params[2] = ""; // group;
   $scheduler_params[3] = ""; // order;
   $scheduler_params[4] = ""; // limit

   $scheduler_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $scheduler_object_type, $scheduler_action, $scheduler_params);

   if (is_array($scheduler_array)){

      for ($cnt=0;$cnt < count($scheduler_array);$cnt++){

          # Loop through the various schedulers
          $this_scheduler_cit = $scheduler_array[$cnt]['id'];

          # Special collection for making orders (Licenses)
          if ($this_scheduler_cit == $ord_scheduler_cit){

             ###################################################
             # Start from children of system -> then work down from there

             $system_acc = "de8891b2-4407-b4c4-f153-51cb64bac59e"; # Scalastica

             $ar_object_type = "AccountRelationships";
             $ar_action = "select";
             $ar_params[0] = " deleted=0 && account_id_c='".$system_acc."' ";
             $ar_params[1] = "account_id1_c"; // select array
             $ar_params[2] = ""; // group;
             $ar_params[3] = " name, date_entered DESC "; // order;
             $ar_params[4] = ""; // limit

             $ar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ar_object_type, $ar_action, $ar_params);

             if (is_array($ar_items)){

                for ($ar_cnt=0;$ar_cnt < count($ar_items);$ar_cnt++){

                    #$id = $ar_items[$ar_cnt]['id'];
                    #$name = $ar_items[$ar_cnt]['name'];
                    #$par_account_id = $ar_items[$ar_cnt]['parent_account_id'];
                    $child_account_id = $ar_items[$ar_cnt]['child_account_id'];
                    #$entity_type = $ar_items[$ar_cnt]['entity_type'];

                    $default_billing_day = '27'; # default if none set by account

                    # Collect only accounts whose invoice day is today
                    # Package children orders, collected to become parent orders - loop
                    # Need to next create orders for the owner of the SLA

                    $inv_type_id = '78fdc61d-6ce5-1172-a55a-52c7048a48c7'; #Invoice day

                    $inv_object_type = "ConfigurationItems";
                    $inv_action = "select";
                    $inv_params[0] = " deleted=0 && account_id_c='".$child_account_id."' && sclm_configurationitemtypes_id_c='".$inv_type_id."' && (name=".$today_day." || (name IS NULL && ".$today_day."=".$default_billing_day."))";
                    $inv_params[1] = "account_id_c"; // select array
                    $inv_params[2] = ""; // group;
                    $inv_params[3] = ""; // order;
                    $inv_params[4] = ""; // limit
  
                    $inv_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $inv_object_type, $inv_action, $inv_params);

                    # Need system level orders by this date and any subsequent ones
                    if (is_array($inv_items)){

                       for ($inv_cnt=0;$inv_cnt < count($inv_items);$inv_cnt++){
 
                           # Matches the day and CIT - store the acc
                           $order_account_id_c = $inv_items[$inv_cnt]['account_id_c'];
                           $order_accs[] = $order_account_id_c;

                           } # for invoice day

                       } # if is_array($inv_items

                    } # for ar_items

                } # if is_array($ar_items

             $schedule_pack[0] = $this_scheduler_cit;
             $schedule_pack[1] = $order_accs;

             # End $this_scheduler_cit == $ord_scheduler_cit
             ###################################################
             # Do the next scheduler

             } elseif ($this_scheduler_cit == 'XXXX') {

             # Do some other type of scheduler
           
             } # some other scheduler

          } # for scheduler_array

      } # is array scheduler_array

   return $schedule_pack;

  } # end do_scheduler function

# End do_scheduler function
################################
# Ordering

  function do_ordering ($par_accs){

   global $portal_account_id;

   # Sent from cron scheduler
   # Create orders based on the accounts provided - already vetted for invoice day
   # Create orders based on ServiceSLARequests - to be included in invoices
   # Consider the timezone

   $today = date("Y-m-d");
   $todaydatetime = date("Y-m-d G:i:s");
   $ord_scheduler_cit = '9afa5bc2-9a1f-c831-b032-57122091b780';

   # Create orders for Accounts for Licenses
   if (is_array($par_accs)){

      # Gather scheduled licenses to order
      $ord_sched_object_type = "ConfigurationItems";
      $ord_sched_action = "select";
      $ord_sched_params[0] = " sclm_configurationitemtypes_id_c='".$ord_scheduler_cit."' && enabled=1";
      $ord_sched_params[1] = "id,enabled,name"; # select
      $ord_sched_params[2] = ""; // group;
      $ord_sched_params[3] = ""; // order;
      $ord_sched_params[4] = ""; // limit

      $ord_sched_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ord_sched_object_type, $ord_sched_action, $ord_sched_params);

      if (is_array($ord_sched_array)){

         for ($ord_sched_cnt=0;$ord_sched_cnt < count($ord_sched_array);$ord_sched_cnt++){

             $service_sla_id = $ord_sched_array[$ord_sched_cnt]['name']; # Service SLA ID
             # Work out the type of SLA - minute, hour, day, month, year - count - count what??!!
             # Package the Service info
             $service_namer = $this->object_returner ('ServicesSLA', $service_sla_id);
             $service_name = $service_namer[1];

             $serviceslas[$ord_sched_cnt]['service_id'] = $service_sla_id;
             $serviceslas[$ord_sched_cnt]['service_name'] = $service_name;

             } # for

         } # is array

      $service_sla_id = "";
      $service_name = "";

      foreach ($par_accs as $order_account_id_c){

              $log_content .= "Acc: ".$order_account_id_c." | ";

              if (is_array($serviceslas)){

                 for ($servicesla_cnt=0;$servicesla_cnt < count($servicesla);$servicesla_cnt++){

                     $service_sla_id = $servicesla[$servicesla_cnt]['service_id']; # Service SLA ID
                     $service_sla_name = $servicesla[$servicesla_cnt]['service_name']; # Service SLA ID

                     $log_content .= "SLA: ".$service_sla_name." | ";

                     # Use the Service SLA to fetch Service SLA Requests whose dates are viable & match the account
                     # First, create orders from top level, then create orders for children
                     $slareq_object_type = 'ServiceSLARequests';
                     $slareq_action = "select";
                     $slareq_params[0] = "deleted=0 && account_id_c='".$order_account_id_c."' && sclm_servicessla_id_c='".$service_sla_id."' && DATE(end_date)>'$today' ";
                     $slareq_params[1] = "id,name,account_id_c,sclm_servicesprices_id_c,description,start_date,end_date,provider_price,reseller_price,customer_price"; // select array
                     $slareq_params[2] = ""; // group;
                     $slareq_params[3] = " start_date DESC "; // order;
                     $slareq_params[4] = ""; // limit

                     $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

                     if (is_array($slareq_items)){

                        for ($slareq_cnt=0;$slareq_cnt < count($slareq_items);$slareq_cnt++){
             
                            $slareq_id = $slareq_items[$slareq_cnt]['id'];
                            $slareq_name = $slareq_items[$slareq_cnt]['name'];
                            #$slareq_date_entered = $slareq_items[$slareq_cnt]['date_entered'];
                            #$slareq_date_modified = $slareq_items[$slareq_cnt]['date_modified'];
                            $slareq_description = $slareq_items[$slareq_cnt]['description'];
                            #$slareq_assigned_user_id = $slareq_items[$slareq_cnt]['assigned_user_id'];
                            #$slareq_sclm_services_id_c = $slareq_items[$slareq_cnt]['sclm_services_id_c'];
                            #$slareq_account_id_c = $slareq_items[$slareq_cnt]['account_id_c'];
                            #$slareq_contact_id_c = $slareq_items[$slareq_cnt]['contact_id_c'];
                            #$slareq_sclm_servicessla_id_c = $slareq_items[$slareq_cnt]['sclm_servicessla_id_c'];
                            $slareq_start_date = $slareq_items[$slareq_cnt]['start_date'];
                            $slareq_end_date = $slareq_items[$slareq_cnt]['end_date'];
                            #$slareq_sclm_accountsservices_id_c = $slareq_items[$slareq_cnt]['sclm_accountsservices_id_c'];
                            #$slareq_sclm_accountsservicesslas_id_c = $slareq_items[$slareq_cnt]['sclm_accountsservicesslas_id_c'];    
                            #$project_id_c = $ci_items[$cnt]['project_id_c'];
                            #$projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
                            #$sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];

                            $slareq_sclm_servicesprices_id_c = $slareq_items[$slareq_cnt]['sclm_servicesprices_id_c'];

                            # Provider makes custom pricing for this particular SLA Request
                            $slareq_provider_price = $slareq_items[$slareq_cnt]['provider_price']; # Original
                            $slareq_reseller_price = $slareq_items[$slareq_cnt]['reseller_price']; # Reseller
                            $slareq_customer_price = $slareq_items[$slareq_cnt]['customer_price']; # Client

                            if ((($slareq_provider_price == NULL && $slareq_reseller_price == NULL && $slareq_customer_price == NULL) || ($slareq_provider_price == 'NULL' && $slareq_reseller_price == 'NULL' && $slareq_customer_price == 'NULL')) && $slareq_sclm_servicesprices_id_c != NULL){

                               ##########################
                               # Collect pricing info
    
                               $pricing_object_type = "ServicesPrices";
                               $pricing_action = "select";
                               $pricing_params[0] = " id='".$slareq_sclm_servicesprices_id_c."' ";
                               $pricing_params[1] = "name,cmn_currencies_id_c,credits,timezone,account_id_c"; // select array
                               $pricing_params[2] = ""; // group;
                               $pricing_params[3] = ""; // order;
                               $pricing_params[4] = ""; // limit
  
                               $pricing_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $pricing_object_type, $pricing_action, $pricing_params);

                               if (is_array($pricing_items)){

                                  for ($prc_cnt=0;$prc_cnt < count($pricing_items);$prc_cnt++){

                                      #$price_id = $pricing_items[$prc_cnt]['id'];
                                      $price_name = $pricing_items[$prc_cnt]['name'];
                                      #$price_date_entered = $pricing_items[$prc_cnt]['date_entered'];
                                      #$price_date_modified = $pricing_items[$prc_cnt]['date_modified'];
                                      #$price_modified_user_id = $pricing_items[$prc_cnt]['modified_user_id'];
                                      #$price_created_by = $pricing_items[$prc_cnt]['created_by'];
                                      #$price_description = $pricing_items[$prc_cnt]['description'];
                                      #$price_deleted = $pricing_items[$prc_cnt]['deleted'];
                                      #$price_assigned_user_id = $pricing_items[$prc_cnt]['assigned_user_id'];
                                      #$price_sclm_services_id_c = $pricing_items[$prc_cnt]['sclm_services_id_c'];
                                      $price_cmn_currencies_id_c = $pricing_items[$prc_cnt]['cmn_currencies_id_c'];
                                      #$price_cmn_countries_id_c = $pricing_items[$prc_cnt]['cmn_countries_id_c'];

                                      # The provider of this price
                                      $price_ci_account_id_c = $pricing_items[$prc_cnt]['account_id_c'];

                                      #$price_ci_contact_id_c = $pricing_items[$prc_cnt]['contact_id_c'];
                                      #$price_sclm_servicessla_id_c = $pricing_items[$prc_cnt]['sclm_servicessla_id_c'];
                                      #$price_cmn_languages_id_c = $pricing_items[$prc_cnt]['cmn_languages_id_c'];
                                      $price_credits = $pricing_items[$prc_cnt]['credits'];
                                      $price_timezone = $pricing_items[$prc_cnt]['timezone'];

                                      $credit_params[0] = $price_credits;
                                      $credit_params[1] = $price_cmn_currencies_id_c;
                                      $credit_params[2] = $price_ci_account_id_c;
                                      $credits_pack = $this->creditisor ($credit_params);

                                      $slareq_customer_price = $credits_pack[0];
                                      $slareq_provider_price = $credits_pack[1];
                                      $slareq_reseller_price = $credits_pack[2];
                                      $currency_name = $credits_pack[3];
                                      $iso_code = $credits_pack[4];
                                      $currency_country = $credits_pack[5];

                                      } # end for pricing_items

                                  } # is array pricing_items
                               
                               } # if $slareq_sclm_servicesprices_id_c

                            # End collect pricing info
                            ##########################
                            # Package order items info

                            $order_items[]['slareq_id'] = $slareq_id;
                            $order_items[]['slareq_name'] = $slareq_name;
                            $order_items[]['slareq_start_date'] = $slareq_start_date;
                            $order_items[]['slareq_end_date'] = $slareq_end_date;
                            $order_items[]['price_id'] = $slareq_sclm_servicesprices_id_c; # May not exist
                            $order_items[]['price_name'] = $price_name; # May not exist
                            $order_items[]['price_credits'] = $price_credits;
                            $order_items[]['currency_name'] = $currency_name;
                            $order_items[]['currency_country'] = $currency_country;
                            $order_items[]['iso_code'] = $iso_code;
                            $order_items[]['quantity'] = 1;
                            $order_items[]['customer_price'] = $slareq_customer_price;
                            $order_items[]['provider_price'] = $slareq_provider_price;
                            $order_items[]['reseller_price'] = $slareq_reseller_price;
    
                            # End package order items info
                            ##########################

                            } # for slareq_items       

                        } # is_array slareq_items

                     ##########################
                     # Package order service info

                     $order_services[]['order_service_id'] = $service_sla_id;
                     $order_services[]['order_service_name'] = $service_sla_name;
                     $order_services[]['order_items'] = $order_items;
  
                     # End package order service info
                     ##########################

                     } # for $servicesla

                 } # is array serviceslas

              ##########################
              # Package order info for acc

              $order_package[]['order_subject'] = $order_account_id_c;
              $order_package[]['order_date'] = $todaydatetime;
              $order_package[]['order_services'] = $order_services;
              $order_package = serialize($order_package);

              # Insert order package into the order CIT's CI

              # End package order info for acc
              ##########################

              } # foreach ($par_accs

      } # is_array($par_accs) 

   if (is_array($slareqsaccs)){
      $slareqsaccs = array_unique($slareqsaccs);
      }

   $return_package[0] = $slareqs;
   $return_package[1] = $slareqsaccs[0];
   $return_package[2] = $slareq_params[0];

   ############################
   # Do Logger

   $bodyfiledate = date('Y-m-d-H-i-s');
   $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
   $log_name = "Scalastica";

   #$do_logger = FALSE;
   $do_logger = TRUE;

   if ($do_logger == TRUE){

      $log_content = "Auto-scheduler create orders: ".$log_content;
      $logparams[0] = $log_location;
      $logparams[1] = $log_name;
      $logparams[2] = $log_content;
      $this->funky_logger ($logparams);

      }

    # End Logger 
    ############################

  } # end do_ordering function

# End do_ordering function
################################
# Ticketing

   # CIT = SLA Performance Metrics | ID: 6996b047-5a1a-0dfa-9b3c-523717a14b4c
   # CIT -> ABA - Abandonment Rate | ID: 5fa11fd0-72e1-dae3-ac4b-523718e4b49a
   # CIT -> ASA - Average Speed to Answer | ID: 2cb434d7-a5e7-ecf5-53ea-52371981bda6
   # CIT -> FCR - First-Call Resolution | ID: e333975f-aea8-2324-20f9-523870fdf3a1
   # CIT -> MTTR - Mean Time To Recover | ID: 3fb7e9d5-bc95-2fa9-5ed3-523871d1c8d5
   # CIT -> Per Item | ID: 19853b0a-a956-cfd5-2f95-54dc9035de5c
   # CIT -> TAT - Turn-Around Time | ID: 7e975548-f451-3cee-5df0-523871c72077
   # CIT -> TSF - Time Service Factor | ID: 4fff98cd-bcad-b5f1-f1d3-52371c5e1628
   # CIT -> Uptime | ID: 497ff110-28c7-93f3-7a1f-5238710432e3

# Cron job for auto-ticketing

  function do_ticketing ($package){

   # Check monthly type SLAs & get Service SLAs & get ServiceSLARequests based on that
   # CIT = Count Type = sclm_configurationitemtypes_id_c='4804b907-85e4-4858-ce4b-523fc23fea3a'
   # CIs = Types = sclm_configurationitems
   # CI -> Days | ID: 3071beef-694f-1232-c936-525935686c09
   # CI -> Hours | ID: 8cfee2ac-bbb2-9db9-0f61-523fc9329f55
   # CI -> Items | ID: 7f2e0456-3148-cea2-10bb-54dc932eb0e0
   # CI -> Months | ID: b42d5cd9-19f7-d2ec-ab39-526f95140529
   # CI -> Percentage | ID: 6d9901cd-9516-5fcd-59a4-52593456d9e3
   # CI -> Seconds | ID: 784310ea-344a-a053-836a-523fc2fcb1f5

   # Count Type -> SLA -> Service SLA -> Account Service's SLAs

   # SLAs must be bound to a module


  } # end function do_ticketing

# end function do_ticketing
################################
# Invoices

  function do_invoices ($package){

  # Auto execute via cron job to gather invoice information to create an invoice, or
  # Simply present the invoice information to the web
  $invoices_cit = 'b09057dd-11ae-dc9c-76f9-5707dbc9c9f1';

  $purpose = $package[0];
  $account_id = $package[1];
  $sla_req_id = $package[2];

  switch ($purpose){

   case '0':

    # Auto
    # Loop through accounts' for their invoicing requirements
    # Get the accounts' preferred invoicing day
    # $ci_type_id = '78fdc61d-6ce5-1172-a55a-52c7048a48c7' <- invoice_day
    # If matches today, then run with it and create a new invoice
     
    # Select distinct accounts from sla requests - just need accounts that HAVE SLARequests
    # This will be superceded by ServiceSLARequests that have "scheduling" attached to them 

    $sclm_object_type = "ServiceSLARequests";
    $sclm_action = "select";
    $sclm_params[0] = " deleted=0 ";
    $sclm_params[1] = "distinct account_id_c";
    $sclm_params[2] = "";
    $sclm_params[3] = "";
    $sclm_params[4] = "";

    $accounts = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

    if (is_array($accounts)){

       # Will need to remove any monthly SLA type tickets as these are usually charged based on monthly fee, not per ticket

       $today_date = date("Y-m-d");
       $today_day = date("d");

       # Set default billing date - last day of month
       #$billing_day = date("Y-m-t", strtotime($today_date));
       $billing_day = '27'; # default??

       for ($acc_cnt=0;$acc_cnt < count($accounts);$acc_cnt++){

           $customer_account_id = $accounts[$acc_cnt]['account_id_c'];

           $ci_type_id = '78fdc61d-6ce5-1172-a55a-52c7048a48c7'; #Invoice day

           $ci_object_type = "ConfigurationItems";
           $ci_action = "select";
           $ci_params[0] = " deleted=0 && account_id_c='".$customer_account_id."' && ".$ci_type_id." ";
           $ci_params[1] = "name"; // select array
           $ci_params[2] = ""; // group;
           $ci_params[3] = ""; // order;
           $ci_params[4] = ""; // limit
  
           $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

           if (is_array($ci_items)){

              for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
                  #$id = $ci_items[$cnt]['id'];
                  $invoice_day = $ci_items[$cnt]['name'];

                  if ($invoice_day == NULL || $invoice_day == ""){

                     $invoice_day = $billing_day; #whatever!

                     } # if inv

                  if ($invoice_day == $today_day){

                     # Execute auto billing if auto
                     # Collect the invoice details, serialise and record in invoices under CIT
                     # Use AccountSLARequests to collect details - make sure no invoice created for it yet
                     # Multiple AccountSLARequests per invoice
                     # Check licensing via accounts_services_id - 

                     /*

                     Use the following specifically for Scalastica licensing, but we want to invoice the customer for all usage!

                     $lic_cit = '8251ddbc-cd5c-a23c-fc58-53da6f001002';
                     $lic_cit_accounts = '8e3ff812-8fdd-7797-5cfe-54b64bbf679c';
                     $lic_cit_contacts  = '4e5d6794-a96e-610e-ca1a-53da6f999945';
                     $lic_cit_content  = '8dc70254-4c2a-49ff-7605-54b899dbe239';
                     $lic_cit_filters = 'b1ec5fc3-1154-06a5-d20f-54b64b958d0e';
                     $lic_cit_infra = '10270906-ba22-4c42-ca1d-54b66213c795';
                     $lic_cit_projects = '9b7266a8-6896-33fd-07aa-54b64a4c0759';
                     $lic_cit_ticketing = 'd2ef598d-7db6-2685-85ba-54b662f69f4c';
                     $lic_cit_activities = '469b1a65-d8b5-69c2-398e-54b88a9c17b0';
                     $lic_cit_workflows = '80d45f1b-b608-b123-41d6-54b64caea0bc';
                     $lic_cit_services = '8bb68b8c-1d16-c9a4-f4e6-54b64b529598';
                     $lic_cit_emails = '74244077-62e2-6538-6b44-54dd86b18d66';

                     $lic_params[0] .= " && (sclm_configurationitemtypes_id_c='".$lic_cit_accounts."' || sclm_configurationitemtypes_id_c='".$lic_cit_contacts."' || sclm_configurationitemtypes_id_c='".$lic_cit_content."' || sclm_configurationitemtypes_id_c='".$lic_cit_filters."' || sclm_configurationitemtypes_id_c='".$lic_cit_infra."' || sclm_configurationitemtypes_id_c='".$lic_cit_projects."' || sclm_configurationitemtypes_id_c='".$lic_cit_ticketing."' || sclm_configurationitemtypes_id_c='".$lic_cit_activities."' || sclm_configurationitemtypes_id_c='".$lic_cit_workflows."' || sclm_configurationitemtypes_id_c='".$lic_cit_services."' || sclm_configurationitemtypes_id_c='".$lic_cit_emails."') "; 
                     */

                     # Originally required the portal type of customer to determine their prcing for the particular service - but
                     # Need to work out the relationship between the customer and provider of that SLA to
                     #  determine their prcing for the particular service
                     # Portal type is incorrect as it only represents SLAs based on the immediate parent relationship
                     # Not all SLAs are from the parent - they may come from other partners or providers

                     $slareq_object_type = 'ServiceSLARequests';
                     $slareq_action = "select";
                     $slareq_params[0] = " deleted=0 && account_id_c='".$customer_account_id."' ";
                     $slareq_params[0] .= " && name IS NOT NULL ";
                     $slareq_params[1] = "id,name,date_entered,provider_price,reseller_price,customer_price,sclm_servicesprices_id_c";
                     $slareq_params[2] = ""; // group;
                     $slareq_params[3] = " date_entered ASC ";
                     $slareq_params[4] = ""; // limit

                     $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

                     # Start SLA

                     if (is_array($slareq_items)){

                        for ($slareq_cnt=0;$slareq_cnt < count($slareq_items);$slareq_cnt++){

                            $servicesum = 0;

                            $provider_price = 0;
                            $reseller_price = 0;
                            $customer_price = 0;

                            $id = $slareq_items[$slareq_cnt]['id'];
                            $name = $slareq_items[$slareq_cnt]['name'];
                            #$serviceslarequests[$id]=$name;
                            $provider_price = $slareq_items[$slareq_cnt]['provider_price'];
                            $reseller_price = $slareq_items[$slareq_cnt]['reseller_price'];
                            $customer_price = $slareq_items[$slareq_cnt]['customer_price'];
                            $sclm_servicesprices_id_c = $slareq_items[$slareq_cnt]['sclm_servicesprices_id_c'];

                            # Use the Service Account ID to get the relationship between the provider and the current customer
                            $service_acc_id = $slareq_items[$slareq_cnt]['service_acc_id'];

                            if ($service_acc_id != NULL && $customer_account_id == $service_acc_id){

                               # Own service - use provider price
                               $relationship_type = 'provider';

                               } elseif ($service_acc_id != NULL){

                               # If the relationship of customer_account_id to the SLA account is provider, then provider
                               # If the relationship of customer_account_id is provider of the SLA account, then self, then provider                               # Can only get reseller pricing if sold to another 
                                  
                               $rel_object_type = "AccountRelationships";
                               $rel_action = "select";
                               $rel_params[0] = " deleted=0 && (";
                               $rel_params[0] .= " (account_id_c='".$customer_account_id."' && account_id1_c='".$customer_account_id."') || ";
                               $rel_params[0] .= " (account_id_c='".$service_acc_id."' && account_id1_c='".$customer_account_id."') || ";
                               $rel_params[0] .= " (account_id_c='".$customer_account_id."' && account_id1_c='".$service_acc_id."')";
                               $rel_params[0] .= ") ";
                               $rel_params[1] = "id,name,date_entered,account_id_c,account_id1_c,entity_type"; # select array
                               $rel_params[2] = ""; # group;
                               $rel_params[3] = " name, date_entered DESC "; # order;
                               $rel_params[4] = ""; # limit

                               $rel_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $rel_object_type, $rel_action, $rel_params);

                               if (is_array($rel_list)){

                                  for ($relcnt=0;$relcnt < count($rel_list);$relcnt++){

                                      $id = $rel_list[$relcnt]['id'];
                                      $name = $rel_list[$relcnt]['name'];
                                      $par_account_id = $rel_list[$relcnt]['parent_account_id'];
                                      $child_account_id = $rel_list[$relcnt]['child_account_id'];
                                      $entity_type = $rel_list[$relcnt]['entity_type'];

                                      # Entity Types CIT: a867fcdd-218a-34be-d0f2-51ca18235609
                                      # Entity Types CIs: Should have been CITs, but legacy!!! Doh!!
                                      # Need to change in multiple places by creating sub CITs

                                      # Client | ID: e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3
                                      # Reseller Partner | ID: f2aa14f0-dc5e-16ce-87c9-51ca1af657fe
                                      # Service Provider | ID: de438478-a493-51ad-ec49-51ca1a3aca3e
                                      # Supplier Partner | ID: 644f1c78-18a6-e2c4-7789-51eea359fde9

                                      if ($customer_account_id == $par_account_id){

                                         $relationship_type = 'client';

                                         } 

                                      if ($entity_type != NULL){


                                         } elseif ($customer_account_id == $child_account_id){

                                         $relationship_type = 'client';

                                         }

                                      } # end for

                                  } else {

                                  # No relationship entry exists
                                  $relationship_type = 'client';
                 
                                  } 

                               } else {

                               $relationship_type = 'client';

                               } 

                            if ($sclm_servicesprices_id_c){

                               $credits_object_type = "ServicesPrices";
                               $credits_action = "select";
                               $credits_params[0] = " id='".$sclm_servicesprices_id_c."' ";
                               $credits_params[1] = "id,credits"; // select array
                               $credits_params[2] = ""; // group;
                               $credits_params[3] = ""; // order;
                               $credits_params[4] = ""; // limit

                               $credits_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $credits_object_type, $credits_action, $credits_params);
                               if (is_array($credits_list)){

                                  for ($cntcrd=0;$cntcrd < count($credits_list);$cntcrd++){
                                      $credits = $credits_list[$cntcrd]['credits'];

                                      } // for

                                  } // if

                               } // if

                            $serviceslaaverage=1;

                            if ($credits){
                               $provider_price = $credits*$provider_price;
                               $reseller_price = $credits*$reseller_price;
                               $customer_price = $credits*$customer_price;
                               } else {
                               $provider_price = $serviceslaaverage*$provider_price;
                               $reseller_price = $serviceslaaverage*$reseller_price;
                               $customer_price = $serviceslaaverage*$customer_price;
                               }

                            switch ($relationship_type){

                             case 'system':

                              $price = $provider_price;

                             break;
                             case 'provider':
                 
                              $price = $provider_price;

                             break;
                             case 'reseller':
                 
                              $price = $reseller_price;

                             break;
                             case 'client':

                              $price = $customer_price;

                             break;

                            } // end switch

                            $tick_params[0] = $sdm_confirmed;
                            $tick_params[1] = $id;
                            $tick_params[2] = $name;
                            $tick_params[3] = $price;
                            $tick_params[4] = $tickets_filter;
                            $tick_params[5] = $selected_provider;
                            $tick_params[6] = $stats;
                            $tick_params[7] = $csv;
                            $tick_params[8] = $serviceslarequests_total;
                            $tick_params[9] = $serviceslarequests_show;
                            $tick_params[10] = $provider_account_name;

                            } # for $slareq_items

                        } # if $slareq_items

                     $invoice_date = "";
                     $invoice_package = serialize($portal_info);

                     } # if $invoice_day == $today_day

                  } # end for

              } # end is_array ci_items

           } # end for accounts

       } # end is_array accounts

   break;
   case '1':

    # Present based on acc or sla_req
    if ($account_id != NULL){

       # Collect any invoice CIs for this account
       # The description will contain serialised content

       $ci_object_type = "ConfigurationItems";
       $ci_action = "select";
       $ci_params[0] = " deleted=0 && account_id_c='".$account_id."' && ".$invoices_cit." ";
       $ci_params[1] = "id,name,description"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
              #$id = $ci_items[$cnt]['id'];
              $invoice_id = $ci_items[$cnt]['id'];
              $invoice_sla_req_id = $ci_items[$cnt]['name'];
              $invoice_description = $ci_items[$cnt]['description'];

              $invoice_pack[0] = $invoice_id;
              $invoice_pack[1] = $invoice_sla_req_id;
              $invoice_pack[2] = unserialize($invoice_description);

              } # for

          } # is_array

       } elseif ($sla_req_id != NULL){
       

       } 

    return $invoice_pack;

   break;
   
   } # end purpose switch 

  } # end do_invoices function 

# End do_invoices function 
################################
# Portal CITs

  function get_portal_cits (){

   $portal_cits = "(sclm_configurationitemtypes_id_c='ea0de164-0803-4551-8cc1-51fdc1881db6' || sclm_configurationitemtypes_id_c='78fdc61d-6ce5-1172-a55a-52c7048a48c7' || sclm_configurationitemtypes_id_c='c964c341-ebef-c62b-07f5-51a9cea93d17' || sclm_configurationitemtypes_id_c='723305fd-5711-83d6-1158-51aa0cfcb607' || sclm_configurationitemtypes_id_c='234cd0fc-fea8-bfb3-6253-5291aaa03b0c' || sclm_configurationitemtypes_id_c='571f4cd2-1d12-d165-a8c7-5205833eb24c' || sclm_configurationitemtypes_id_c='6fb14f09-71c7-ce07-c746-5291aa2c39c4' || sclm_configurationitemtypes_id_c='795f11f8-ab63-3948-aac3-51d777dd433c' || sclm_configurationitemtypes_id_c='12e4272a-e571-1067-44f3-51d7787a4045' || sclm_configurationitemtypes_id_c='9dc21c7b-6279-dfd3-3663-51b2f0489807' || sclm_configurationitemtypes_id_c='ad2eaca7-8f00-9917-501a-519d3e8e3b35' || sclm_configurationitemtypes_id_c='1d3da104-6fad-d1d8-719a-54d71a00b7d0' || sclm_configurationitemtypes_id_c='5e7c49e5-e48d-f53e-9c4a-54d719f5fedb' || sclm_configurationitemtypes_id_c='2f6a1ad8-2501-c5d7-025f-54d71a110296' || sclm_configurationitemtypes_id_c='cafad60b-6fab-dbd2-66d6-54d7a1988a3e' || sclm_configurationitemtypes_id_c='4a67c6fb-42d0-8cb6-84b9-54deec34066b' || sclm_configurationitemtypes_id_c='9dc21c7b-6279-dfd3-3663-51b2f0489807' || sclm_configurationitemtypes_id_c='c0fed5ce-05ba-66e2-e9ae-51b2f2446f68' || sclm_configurationitemtypes_id_c='6ba459d7-3800-59bf-c2ea-54df2f50dd66' || sclm_configurationitemtypes_id_c='771c822d-0966-41d7-c00b-54e4c259bed1' || sclm_configurationitemtypes_id_c='b55e3f9f-ee16-3a5d-474d-54eb2973e625' || sclm_configurationitemtypes_id_c='b60c0862-9acd-fd4a-d64b-54fd9f023ed9' || sclm_configurationitemtypes_id_c='374e0ff5-c728-b849-5867-54fd9f775591' || sclm_configurationitemtypes_id_c='891105ec-400c-9b2b-f1f0-54fda0c49f24' || sclm_configurationitemtypes_id_c='201e0ed5-cc50-0cfb-e264-54fd9f3794a7' || sclm_configurationitemtypes_id_c='52fb4588-f0f2-ae8e-76c0-54fd9f9f5b6b' || sclm_configurationitemtypes_id_c='c1e37d9b-a6c9-0cd2-d6dd-54fda09a337a' || sclm_configurationitemtypes_id_c='2a060f28-75dc-c937-ccb7-54fdc47aaa2d' || sclm_configurationitemtypes_id_c='90b3d066-c1b4-7e42-8f2b-54fe44936c60' || sclm_configurationitemtypes_id_c='185e7990-5681-98be-0d2d-54fe44be14b2' || sclm_configurationitemtypes_id_c='881a41d2-2a73-1a75-bd02-54fe443417a5' || sclm_configurationitemtypes_id_c='5ffacdc0-8d54-b786-eba2-55079c9d70b6' || sclm_configurationitemtypes_id_c='1d0df382-a9a7-7af3-0ce0-55263163f34f' || sclm_configurationitemtypes_id_c='915e05bc-2a28-490e-fb53-5562b607702d' || sclm_configurationitemtypes_id_c='11ca3637-558a-7600-13be-556d1758f2fa' || sclm_configurationitemtypes_id_c='18cdeba5-6e31-a186-d472-556d56e2bec1' || sclm_configurationitemtypes_id_c='48ac706c-658d-7c2c-7af0-5575167b902a' || sclm_configurationitemtypes_id_c='10539d8a-aa52-5005-092f-557a4f7ba573' || sclm_configurationitemtypes_id_c='8a5c8fb2-dd32-d0b4-3af1-5516a8746b5e')"; 

  return $portal_cits;

  }

# Portal CITs
################################
# Portaliser

  function portaliser ($hostname){

   # ad2eaca7-8f00-9917-501a-519d3e8e3b35 = hosts - hostname

   $sclm_object_type = "ConfigurationItems";
   $sclm_action = "select";
   $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='ad2eaca7-8f00-9917-501a-519d3e8e3b35' && name='".$hostname."' ";
   $sclm_params[1] = "";
   $sclm_params[2] = "";
   $sclm_params[3] = "";
   $sclm_params[4] = "";

   $sclm_rows = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

   $childbits = 0;

   for ($chld_cnt=0;$chld_cnt < count($sclm_rows);$chld_cnt++){

       $id = $sclm_rows[$chld_cnt]['id'];
       $child_id = $sclm_rows[$chld_cnt]['child_id'];

       if ($child_id){

          #echo "Had child $childbits <BR>";
          $children[$childbits] = $child_id;
          $childbits++;

          } # end if

       $portal_account_id = $sclm_rows[$chld_cnt]['account_id_c'];
       $admin_id = $sclm_rows[$chld_cnt]['contact_id_c'];

       } // for

   # Why was this set as the same as itself???
   # $portal_bits['parent_account_id'] = $portal_account_id;

   $acc_object_type = "Accounts";
   $acc_action = "select_cstm";
   $acc_cstm_params[0] = "id_c='".$portal_account_id."' ";
   $acc_cstm_params[1] = "account_id_c"; // select
   $acc_cstm_params[2] = ""; // group;
   $acc_cstm_params[3] = ""; // order;
   $acc_cstm_params[4] = ""; // limit

   $account_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_cstm_params);

   if (is_array($account_cstm_info)){
      
      for ($cstm_cnt=0;$cstm_cnt < count($account_cstm_info);$cstm_cnt++){

          #$status_c = $account_cstm_info[$cstm_cnt]['status_c'];
          #$cmn_countries_id_c = $account_cstm_info[$cstm_cnt]['cmn_countries_id_c'];
          #$contact_id_c = $account_cstm_info[$cstm_cnt]['contact_id_c']; // Administrator
          $parent_account_id = $account_cstm_info[$cstm_cnt]['account_id_c']; // Parent
          #$email_system_c = $account_cstm_info[$cstm_cnt]['email_system_c']; // Parent
          #$category_id_c = $account_cstm_info[$cstm_cnt]['category_id_c']; // category_id_c
          #$image_c = $account_cstm_info[$cstm_cnt]['image_c'];

          } // for

      } // if array

   if (!$parent_account_id){
      $portal_bits['parent_account_id'] = $portal_account_id;
      }

   $portal_bits['parent_account_id'] = $parent_account_id;
   $portal_bits['portal_account_id'] = $portal_account_id;
   $portal_bits['admin_id'] = $admin_id;
   $portal_bits['portal_admin'] = $admin_id;
   $portal_bits['child_id'] = $child_id;
   $portal_bits['children'] = $children;

/* 

   1) Scalastica = System Owner
      1.1) Provider Partners -> Log in via System
      1.2) Reseller Partners -> Log in via Provider
      1.3) Clients -> Log in via Reseller
      1.4) Users -> Log in via Client

   2) Provider Partners
      2.1) Reseller Partners
           2.1.1) Resellers' Clients
                  2.1.1.1) Resellers' Clients' Users
      2.2) Clients
           2.2.1) Clients' Users

   3) Clients
      3.1) Clients' Users

*/

   $sclm_rows = "";

   if ($portal_account_id == 'de8891b2-4407-b4c4-f153-51cb64bac59e'){

      # Scalastica System Owner
      $portal_type = "system";
      $sclm_params[0] = " deleted=0 ";

      } else {

      # Get info where the child is the portal owner
      $sclm_object_type = "AccountRelationships";
      $sclm_action = "select";
      # $sclm_params[0] = " deleted=0 && account_id_c='".$account_id."' "; // Check if primary
      # Check if under another and what the relationship is
      $sclm_params[0] = " deleted=0 && account_id_c='".$parent_account_id."' && account_id1_c='".$portal_account_id."' ";
      $sclm_params[1] = "entity_type";
      $sclm_params[2] = "";
      $sclm_params[3] = "";
      $sclm_params[4] = "";

      $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

      if (is_array($sclm_rows)){      

         for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

           #$id = $sclm_rows[$cnt]['id'];
           #$name = $sclm_rows[$cnt]['name'];
           #$date_entered = $sclm_rows[$cnt]['date_entered'];
           #$date_modified = $sclm_rows[$cnt]['date_modified'];
           #$modified_user_id = $sclm_rows[$cnt]['modified_user_id'];
           #$created_by = $sclm_rows[$cnt]['created_by'];
           #$description = $sclm_rows[$cnt]['description'];
           #$deleted = $sclm_rows[$cnt]['deleted'];
           #$parent_account_id = $sclm_rows[$cnt]['parent_account_id'];

           # Non logged-in values
           #$child_account_id = $sclm_rows[$cnt]['child_account_id'];
             $entity_type = $sclm_rows[$cnt]['entity_type'];

             } // end for

         } // is array

      switch ($entity_type){

       case 'de438478-a493-51ad-ec49-51ca1a3aca3e': // Provider
        $portal_type = "provider";
       break;
       case 'f2aa14f0-dc5e-16ce-87c9-51ca1af657fe': // Partner Reseller
        $portal_type = "reseller";
       break;
       case '644f1c78-18a6-e2c4-7789-51eea359fde9': // Supplier Partner
        $portal_type = "supplierr";
       break;
       case 'e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3': // Client
        $portal_type = "client";
       break;

      } // end switch entity type

      } // if not system account

   $portal_bits['portal_type'] = $portal_type;

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

          } // end for

      } else {// is array
      $assigned_user_id = 1;
      } 

   $portal_bits['portal_assigned_user_id'] = $assigned_user_id;

   # First check if top content is available
   $ci_object_type = "Content";
   $ci_action = "select";
   $top_portal_content_type = '69c77ef3-f622-6866-79ca-55006b8d2836';
   $standard_statuses_closed = "8eb47529-7e4e-d5ae-b2fa-51c233872ff3"; # Also in common

   $ci_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && portal_content_type='".$top_portal_content_type."' && account_id_c='".$portal_account_id."' " ;

     $ci_params[1] = "deleted,cmn_statuses_id_c,portal_content_type,account_id_c,id"; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = ""; // order;
     $ci_params[4] = ""; // limit
  
     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($ci_items)){

        for ($cnt=0;$cnt < count($ci_items);$cnt++){

            $topgear_id = $ci_items[$cnt]['id'];

            } # for

        } # is array

   $portal_bits['topgear_id'] = $topgear_id;

   # If child - then external ticket system exists

   /*
   if (is_array($children)){

      $childbits = 0;

      for ($childcnt=0;$childcnt < count($children);$childcnt++){

          $child_id = $children[$childcnt];

          // Get all entity related configs
          $sclm_object_type = "ConfigurationItems";
          $sclm_action = "select";
          $sclm_params[0] = " deleted=0 && sclm_scalasticachildren_id_c='".$child_id."' ";
          $sclm_params[1] = "*";
          $sclm_params[2] = "";
          $sclm_params[3] = "";
          $sclm_params[4] = "";

          $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);
    
          for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

              $id = $sclm_rows[$cnt]['id'];
              $name = $sclm_rows[$cnt]['name'];
              $ci_type_id = $sclm_rows[$cnt]['ci_type_id'];

              if ($ci_type_id == '6321083c-f187-736c-0f59-51aa7d8d0e1d'){
                 $portal_bits['external_source_type_id'][] = $name;
                 }

              if ($ci_type_id == 'b656325e-95ce-cc9f-9e80-5219c4a9b430'){
                 $portal_bits['external_account'][] = $name;
                 }

              if ($ci_type_id == '9254a5ad-698a-2254-6127-51a9da598e45'){
                 $portal_bits['external_admin_name'][] = $name;
                 }

              if ($ci_type_id == '4dae87e1-3127-d7f1-d963-51a9da793fe5'){
                 $portal_bits['external_admin_password'][] = $name;
                 }

              if ($ci_type_id == 'b96c3687-8203-9f05-ab21-51a9dae3ad9f'){
                 $portal_bits['external_url'][] = $name;
                 }

             } // for

          } // for childbits

      } else { 

   if ($child_id != NULL){

      // Get all entity related configs
      $sclm_object_type = "ConfigurationItems";
      $sclm_action = "select";
      $sclm_params[0] = " deleted=0 && sclm_scalasticachildren_id_c='".$child_id."' ";
      $sclm_params[1] = "*";
      $sclm_params[2] = "";
      $sclm_params[3] = "";
      $sclm_params[4] = "";

      $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

      $childbits = 0;

      for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

          $id = $sclm_rows[$cnt]['id'];
          $name = $sclm_rows[$cnt]['name'];
          $ci_type_id = $sclm_rows[$cnt]['ci_type_id'];

          if ($ci_type_id == '6321083c-f187-736c-0f59-51aa7d8d0e1d'){
             $portal_bits['external_source_type_id'] = $name;
             }
          if ($ci_type_id == 'b96c3687-8203-9f05-ab21-51a9dae3ad9f'){
             $portal_bits['external_url'] = $name;
             }
          if ($ci_type_id == 'b656325e-95ce-cc9f-9e80-5219c4a9b430'){
             $portal_bits['external_account'] = $name;
             }
          if ($ci_type_id == '9254a5ad-698a-2254-6127-51a9da598e45'){
             $portal_bits['external_admin_name'] = $name;
             }
          if ($ci_type_id == '4dae87e1-3127-d7f1-d963-51a9da793fe5'){
             $portal_bits['external_admin_password'] = $name;
             }
  
          } // for

      if ($portal_bits['external_source_type_id'] && $portal_bits['external_account'] && $portal_bits['external_admin_password'] && $portal_bits['external_admin_name'] && $portal_bits['external_url']){
         $portal_bits['child_access'] = TRUE;
         }

      } // end if child_id

     } // if not array

      */

   # Get Portal Details based on type
   # These CITs need to be updated in ConfgurationItemSets at PortalSet
   $sclm_object_type = "ConfigurationItems";
   $sclm_action = "select";
   $sclm_params = "";
   $cits = $this->get_portal_cits();
   $sclm_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && ".$cits." ";

   $sclm_params[1] = "id,name,sclm_configurationitemtypes_id_c";
   $sclm_params[2] = "";
   $sclm_params[3] = "";
   $sclm_params[4] = "";

   $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

   $portal_bits['allow_engineer_rego'] = FALSE;
   $portal_bits['allow_provider_rego'] = FALSE;
   $portal_bits['allow_reseller_rego'] = FALSE;
   $portal_bits['allow_client_rego'] = FALSE;
   $portal_bits['allow_fb_rego'] = FALSE;
   $portal_bits['allow_google_rego'] = FALSE;
   $portal_bits['allow_linkedin_rego'] = FALSE;
   $portal_bits['enable_hirorins_timer'] = FALSE;
   $portal_bits['allow_lifeplanner'] = FALSE;

   if (is_array($sclm_rows)){

      for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

          $id = $sclm_rows[$cnt]['id'];
          $name = $sclm_rows[$cnt]['name'];
          $ci_type_id = $sclm_rows[$cnt]['ci_type_id'];

          if ($ci_type_id == 'c964c341-ebef-c62b-07f5-51a9cea93d17'){ //portal_title
             $portal_title = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '723305fd-5711-83d6-1158-51aa0cfcb607'){ //portal_logo
             $portal_logo = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '795f11f8-ab63-3948-aac3-51d777dd433c'){ //portal_email
             $portal_email = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '12e4272a-e571-1067-44f3-51d7787a4045'){ //portal_email_password
             $portal_email_password = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '234cd0fc-fea8-bfb3-6253-5291aaa03b0c'){ //portal_email_server
             $portal_email_server = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '6fb14f09-71c7-ce07-c746-5291aa2c39c4'){ //portal_email_port
             $portal_email_smtp_port = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '571f4cd2-1d12-d165-a8c7-5205833eb24c'){ //portal_email_auth
             $portal_email_smtp_auth = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == 'c0fed5ce-05ba-66e2-e9ae-51b2f2446f68'){ // portal_skin
             $portal_skin_id = $sclm_rows[$cnt]['name'];
             $portal_skin_returner = $this->object_returner ('ConfigurationItems', $portal_skin_id);
             $portal_skin = $portal_skin_returner[0];
             #$portal_skin = $sclm_rows[$cnt]['parent_ci_name'];
             }

          # Right column rego
          if ($ci_type_id == 'ea0de164-0803-4551-8cc1-51fdc1881db6' && $name == 1){ // allow_engineer_rego
             $portal_bits['allow_engineer_rego'] = TRUE;
             }

          if ($ci_type_id == '5e7c49e5-e48d-f53e-9c4a-54d719f5fedb' && $name == 1){ // allow_provider_rego
             $portal_bits['allow_provider_rego'] = TRUE;
             }

          if ($ci_type_id == '2f6a1ad8-2501-c5d7-025f-54d71a110296' && $name == 1){ // allow_reseller_rego
             $portal_bits['allow_reseller_rego'] = TRUE;
             }

          if ($ci_type_id == '1d3da104-6fad-d1d8-719a-54d71a00b7d0' && $name == 1){ // allow_client_rego
             $portal_bits['allow_client_rego'] = TRUE;
             }

          if ($ci_type_id == '1d0df382-a9a7-7af3-0ce0-55263163f34f' && $name == 1){ # allow wellbeing
             $portal_bits['allow_wellbeing'] = TRUE;
             }

          if ($ci_type_id == '915e05bc-2a28-490e-fb53-5562b607702d' && $name == 1){ # enable_hirorins_timer
             $portal_bits['enable_hirorins_timer'] = TRUE;
             }

          if ($ci_type_id == '10539d8a-aa52-5005-092f-557a4f7ba573' && $name == 1){ # allow_infracerts
             $portal_bits['allow_infracerts'] = TRUE;
             }

          if ($ci_type_id == '48ac706c-658d-7c2c-7af0-5575167b902a' && $name == 1){ # allow_lifeplanner
             $portal_bits['allow_lifeplanner'] = TRUE;
             }

          if ($ci_type_id == '8a5c8fb2-dd32-d0b4-3af1-5516a8746b5e' && $name == 1){ // allow scalastica rego

             $portal_bits['allow_sc_rego'] = TRUE;
             $portal_bits['sc_source_id'] = $ci_type_id;

             # Get details
             $sc_object_type = "ConfigurationItems";
             $sc_action = "select";
             $sc_params = "";
             $sc_params[0] = " sclm_configurationitems_id_c='".$id."' ";
             $sc_params[1] = "id,name,sclm_configurationitemtypes_id_c";
             $sc_params[2] = "";
             $sc_params[3] = "";
             $sc_params[4] = "";

             $portal_bits['sc_parci_id'] = $id;

             /*
             $sc_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sc_object_type, $sc_action, $sc_params);

             if (is_array($sc_rows)){

                for ($sc_cnt=0;$sc_cnt < count($sc_rows);$sc_cnt++){
   
                    $sc_id = $sc_rows[$sc_cnt]['id'];
                    $sc_name = $sc_rows[$sc_cnt]['name'];
                    $sc_ci_type_id = $sc_rows[$sc_cnt]['ci_type_id'];

                    if ($sc_ci_type_id == '7f853e35-698d-1390-6ea9-551b660d9bbe'){
                       $portal_bits['sc_app_id'] = $sc_name;
                       }

                    if ($sc_ci_type_id == '42a70683-202e-5530-84cb-551b668d2c1b'){
                       $portal_bits['sc_app_secret'] = $sc_name;
                       }

                    } # for

                } # is array

             */

             } # if SC

          if ($ci_type_id == '90b3d066-c1b4-7e42-8f2b-54fe44936c60' && $name == 1){ // allow_fb_rego

             $portal_bits['allow_fb_rego'] = TRUE;
             $portal_bits['fb_source_id'] = $ci_type_id;

             # Get details
             $fb_object_type = "ConfigurationItems";
             $fb_action = "select";
             $fb_params = "";
             $fb_params[0] = " sclm_configurationitems_id_c='".$id."' ";
             $fb_params[1] = "id,name,sclm_configurationitemtypes_id_c";
             $fb_params[2] = "";
             $fb_params[3] = "";
             $fb_params[4] = "";

             $portal_bits['fb_parci_id'] = $id;

             $fb_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $fb_object_type, $fb_action, $fb_params);

             if (is_array($fb_rows)){

                for ($fb_cnt=0;$fb_cnt < count($fb_rows);$fb_cnt++){

                    $fb_id = $fb_rows[$fb_cnt]['id'];
                    $fb_name = $fb_rows[$fb_cnt]['name'];
                    $fb_ci_type_id = $fb_rows[$fb_cnt]['ci_type_id'];

                    if ($fb_ci_type_id == '96a1aa15-7655-90ad-c64a-551675847b8d'){
                       $portal_bits['fb_app_id'] = $fb_name;
                       }

                    if ($fb_ci_type_id == '16423725-a2bd-8ed9-7f49-55167500faea'){
                       $portal_bits['fb_app_secret'] = $fb_name;
                       }

                    } # for

                } # is array

             } # if FB

          if ($ci_type_id == '185e7990-5681-98be-0d2d-54fe44be14b2' && $name == 1){ // allow_google_rego
             $portal_bits['allow_google_rego'] = TRUE;
             $portal_bits['gg_source_id'] = $ci_type_id;

             # Get details
             $gg_object_type = "ConfigurationItems";
             $gg_action = "select";
             $gg_params = "";
             $gg_params[0] = " sclm_configurationitems_id_c='".$id."' ";
             $gg_params[1] = "id,name,sclm_configurationitemtypes_id_c";
             $gg_params[2] = "";
             $gg_params[3] = "";
             $gg_params[4] = "";

             $portal_bits['gg_parci_id'] = $id;

             $gg_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $gg_object_type, $gg_action, $gg_params);

             if (is_array($gg_rows)){

                for ($gg_cnt=0;$gg_cnt < count($gg_rows);$gg_cnt++){
   
                    $gg_id = $gg_rows[$gg_cnt]['id'];
                    $gg_name = $gg_rows[$gg_cnt]['name'];
                    $gg_ci_type_id = $gg_rows[$gg_cnt]['ci_type_id'];

                    if ($gg_ci_type_id == 'd5f7d222-2792-ceee-73a0-551c6f36cf88'){
                       $portal_bits['gg_app_id'] = $gg_name;
                       }

                    if ($gg_ci_type_id == 'b7e10bcc-b510-ee48-5550-551c70d5aa4c'){
                       $portal_bits['gg_app_secret'] = $gg_name;
                       }

                    if ($gg_ci_type_id == '75340245-0e5e-7c17-5094-551c6f0d13b5'){
                       $portal_bits['gg_app_devkey'] = $gg_name;
                       }

                    } # for

                } # is array

             } # ned if G

          if ($ci_type_id == '881a41d2-2a73-1a75-bd02-54fe443417a5' && $name == 1){ // allow_linkedin_rego

             $portal_bits['allow_linkedin_rego'] = TRUE;
             $portal_bits['li_source_id'] = $ci_type_id;

             # Get details
             $li_object_type = "ConfigurationItems";
             $li_action = "select";
             $li_params = "";
             $li_params[0] = " sclm_configurationitems_id_c='".$id."' ";
             $li_params[1] = "id,name,sclm_configurationitemtypes_id_c";
             $li_params[2] = "";
             $li_params[3] = "";
             $li_params[4] = "";

             $portal_bits['li_parci_id'] = $id;

             $li_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $li_object_type, $li_action, $li_params);

             if (is_array($li_rows)){

                for ($li_cnt=0;$li_cnt < count($li_rows);$li_cnt++){
   
                    $li_id = $li_rows[$li_cnt]['id'];
                    $li_name = $li_rows[$li_cnt]['name'];
                    $li_ci_type_id = $li_rows[$li_cnt]['ci_type_id'];

                    if ($li_ci_type_id == '7f853e35-698d-1390-6ea9-551b660d9bbe'){
                       $portal_bits['li_app_id'] = $li_name;
                       }

                    if ($li_ci_type_id == '42a70683-202e-5530-84cb-551b668d2c1b'){
                       $portal_bits['li_app_secret'] = $li_name;
                       }

                    } # for

                } # is array

             } # if LI

          if ($ci_type_id == '11ca3637-558a-7600-13be-556d1758f2fa' && $name == 1){ # Show Partner Listing 
             $portal_bits['show_partners'] = TRUE;
             }

          if ($ci_type_id == '18cdeba5-6e31-a186-d472-556d56e2bec1' && $name == 1){ # Show Service Statistics 
             $portal_bits['show_statistics'] = TRUE;
             }

          if ($ci_type_id == 'b60c0862-9acd-fd4a-d64b-54fd9f023ed9'){ # Portal Body Colour
             $portal_body_colour = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '374e0ff5-c728-b849-5867-54fd9f775591'){ # Portal Border Colour
             $portal_border_colour = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '891105ec-400c-9b2b-f1f0-54fda0c49f24'){ # Portal Description
             $portal_description = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '201e0ed5-cc50-0cfb-e264-54fd9f3794a7'){ # Portal Footer Colour
             $portal_footer_colour = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '52fb4588-f0f2-ae8e-76c0-54fd9f9f5b6b'){ # Portal Header Colour 
             $portal_header_colour = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == '2a060f28-75dc-c937-ccb7-54fdc47aaa2d'){ # Portal Font Colour 
             $portal_font_colour = $sclm_rows[$cnt]['name'];
             }

          if ($ci_type_id == 'c1e37d9b-a6c9-0cd2-d6dd-54fda09a337a'){ # Portal Keywords 
             $portal_keywords = $sclm_rows[$cnt]['name'];
             }

          } # end for

      } # is array

    if ($parent_account_id != NULL && $parent_account_id != $portal_account_id && ($portal_email == NULL || $portal_email_password == NULL || $portal_email_server == NULL ||  $portal_email_smtp_auth == NULL || $portal_email_smtp_port == NULL )){

       $sclm_object_type = "ConfigurationItems";
       $sclm_action = "select";   
       $sclm_params = "";

       $cits = $this->get_portal_cits();
       $sclm_params[0] = " deleted=0 && account_id_c='".$parent_account_id."' && ".$cits." ";

       $sclm_params[1] = "*";
       $sclm_params[2] = "";
       $sclm_params[3] = "";
       $sclm_params[4] = "";

       $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

       for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

           $id = $sclm_rows[$cnt]['id'];
           $name = $sclm_rows[$cnt]['name'];
           $ci_type_id = $sclm_rows[$cnt]['ci_type_id'];
/*
           if ($ci_type_id == 'c964c341-ebef-c62b-07f5-51a9cea93d17'){ //portal_title
              $portal_title = $sclm_rows[$cnt]['name'];
              }

           if ($ci_type_id == '723305fd-5711-83d6-1158-51aa0cfcb607'){ //portal_logo
              $portal_logo = $sclm_rows[$cnt]['name'];
              }
*/
           if ($ci_type_id == '795f11f8-ab63-3948-aac3-51d777dd433c'){ //portal_email
              $portal_email = $sclm_rows[$cnt]['name'];
              }

           if ($ci_type_id == '12e4272a-e571-1067-44f3-51d7787a4045'){ //portal_email_password
              $portal_email_password = $sclm_rows[$cnt]['name'];
              }

           if ($ci_type_id == '234cd0fc-fea8-bfb3-6253-5291aaa03b0c'){ //portal_email_server
              $portal_email_server = $sclm_rows[$cnt]['name'];
              }

           if ($ci_type_id == '6fb14f09-71c7-ce07-c746-5291aa2c39c4'){ //portal_email_port
              $portal_email_smtp_port = $sclm_rows[$cnt]['name'];
              }

           if ($ci_type_id == '571f4cd2-1d12-d165-a8c7-5205833eb24c'){ //portal_email_auth
              $portal_email_smtp_auth = $sclm_rows[$cnt]['name'];
              }

/*
#           if ($ci_type_id == 'c0fed5ce-05ba-66e2-e9ae-51b2f2446f68'){ // portal_skin
           if ($ci_type_id == '9dc21c7b-6279-dfd3-3663-51b2f0489807'){ // portal_skin
              $portal_skin_id = $sclm_rows[$cnt]['name'];
              $portal_skin = $sclm_rows[$cnt]['parent_ci_name'];
              }

*/

           } # end for

       } # end if $parent_account_id != NUL

    $portal_bits['portal_email'] = $portal_email;
    $portal_bits['portal_email_password'] = $portal_email_password;
    $portal_bits['portal_email_server'] = $portal_email_server;
    $portal_bits['portal_email_smtp_auth'] = $portal_email_smtp_auth;
    $portal_bits['portal_email_smtp_port'] = $portal_email_smtp_port;
    # Need to set in CIs and then CI Sets
    #$portal_bits['portal_email_imap_auth'] = $portal_email_imap_auth;
    #$portal_bits['portal_email_imap_port'] = $portal_email_imap_port;

    $portal_bits['portal_title'] = $portal_title;
    $portal_bits['portal_logo'] = $portal_logo;
    $portal_bits['portal_skin'] = $portal_skin;

    $portal_bits['portal_body_colour'] = $portal_body_colour;
    $portal_bits['portal_border_colour'] = $portal_border_colour;
    $portal_bits['portal_footer_colour'] = $portal_footer_colour;
    $portal_bits['portal_header_colour'] = $portal_header_colour;
    $portal_bits['portal_font_colour'] = $portal_font_colour;
    $portal_bits['portal_keywords'] = $portal_keywords;
    $portal_bits['portal_description'] = $portal_description;
    $portal_bits['topgear_id'] = $topgear_id;

   return $portal_bits;

  } // end function

# End Portaliser
################################
# Portal Sharing

  function portal_sharing ($params){

   global $crm_api_user, $crm_api_pass, $crm_wsdl_url;

   $parent_acc_id = $params[0];
   $child_acc_id = $params[1];

   # First get the account relationship - sharing CIs based on this
   $accrel_ci_object_type = "AccountRelationships";
   $accrel_ci_action = "select";
   $accrel_ci_params[0] = " account_id_c='".$parent_acc_id."' && account_id1_c='".$child_acc_id."' ";
   $accrel_ci_params[1] = "id,account_id_c,account_id1_c"; // select array
   $accrel_ci_params[2] = ""; // group;
   $accrel_ci_params[3] = " name, date_entered DESC "; // order;
   $accrel_ci_params[4] = ""; // limit
             
   #echo "query ".$accrel_ci_params[0]."<BR>"; 

   $accrel_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accrel_ci_object_type, $accrel_ci_action, $accrel_ci_params);

   if (is_array($accrel_ci_items)){

      for ($accrel_cnt=0;$accrel_cnt < count($accrel_ci_items);$accrel_cnt++){

          $acc_rel_id = $accrel_ci_items[$accrel_cnt]['id'];

          } # For

      $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';

      # Get Accounts Sharing Set
      $cis_object_type = "ConfigurationItems";
      $cis_action = "select";
      $cis_params[0] = " sclm_configurationitemtypes_id_c='".$acc_sharing_set."' && name='".$acc_rel_id."' ";
      $cis_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
      $cis_params[2] = ""; // group;
      $cis_params[3] = ""; // order;
      $cis_params[4] = ""; // limit

      $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

      if (is_array($cis_list)){

         for ($ciscnt=0;$ciscnt < count($cis_list);$ciscnt++){

             $cis_id = $cis_list[$ciscnt]['id'];

             } # for

         $shared_account_ci = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

         # Collect the shared account
         $ci_object_type = "ConfigurationItems";
         $ci_action = "select";
         $ci_params[0] = " deleted=0 && enabled=1 && name='".$child_acc_id."' && sclm_configurationitems_id_c='".$cis_id."' && sclm_configurationitemtypes_id_c='".$shared_account_ci."' ";
         $ci_params[1] = "id,deleted,enabled,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
         $ci_params[2] = ""; // group;
         $ci_params[3] = ""; // order;
         $ci_params[4] = ""; // limit
  
         $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

         if (is_array($ci_items)){

            $acc_shared_type_projects = 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f';
            $acc_shared_type_slarequests = '39ffa1e6-2b7c-7aaa-3370-52b389684442';
            $acc_shared_type_ticketing = '562695ff-00d4-8ead-e3c2-52b3897ef61e';
            $acc_shared_type_portalaccess = 'e2affd29-d116-caa8-6f0c-52fa4d034cf5';
            $acc_shared_type_portaladmin = '5195ecc6-ec22-1fdd-0fd5-54d898ab38ed';
            $acc_shared_type_emails = 'a8d97830-b100-e03e-c445-54d8be1ae651';
            $acc_shared_type_infra = 'c4f8a9b2-b8f2-8e42-995b-54d8d7e192c1';

            for ($cnt=0;$cnt < count($ci_items);$cnt++){

                $shared_id = $ci_items[$cnt]['id'];

                #echo "shared_id $shared_id";

                # Found own signed-in company - thus must have some components
                $portal_object_type = "ConfigurationItems";
                $portal_action = "select";
                $portal_params[0] = " deleted=0 && enabled=1 && sclm_configurationitems_id_c='".$shared_id."' ";
                $portal_params[1] = "id,deleted,enabled,name,sclm_configurationitemtypes_id_c"; // select array
                $portal_params[2] = ""; // group;
                $portal_params[3] = ""; // order;
                $portal_params[4] = ""; // limit
  
                $portal_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $portal_object_type, $portal_action, $portal_params);
 
                if (is_array($portal_items)){

                   #echo "portal_items";

                   for ($cntptl=0;$cntptl < count($portal_items);$cntptl++){
  
                       $sclm_configurationitemtypes_id_c = $portal_items[$cntptl]['sclm_configurationitemtypes_id_c'];

                       ########
                       # Start checking various sharable modules/features

                       if ($sclm_configurationitemtypes_id_c == $acc_shared_type_portalaccess){

                          $shared_portal_access_status = $portal_items[$cntptl]['name'];

                          if ($shared_portal_access_status != 1){
                             $sharepack['shared_portal_access'] = 0;
                             } else {
                             $sharepack['shared_portal_access'] = 1;
                             } 

                          } elseif ($sclm_configurationitemtypes_id_c == $acc_shared_type_projects){

                          $shared_portal_project = $portal_items[$cntptl]['name'];
                          $shared_portal_projects[] = $shared_portal_project;

                          if (!$shared_portal_projects_sql){
                              $shared_portal_projects_sql = "id_c='".$shared_portal_project."' ";
                              } else {
                              $shared_portal_projects_sql = $shared_portal_projects_sql." || id_c='".$shared_portal_project."'";
                              } 

                          } elseif ($sclm_configurationitemtypes_id_c == $acc_shared_type_slarequests){

                          $shared_portal_slarequest = $portal_items[$cntptl]['name'];
                          $shared_portal_slarequests[] = $shared_portal_slarequest;

                          if (!$shared_portal_slarequest_sql){
                              $shared_portal_slarequest_sql = "sclm_serviceslarequests_id_c='".$shared_portal_slarequest."' ";
                              } else {
                              $shared_portal_slarequest_sql = $shared_portal_slarequest_sql." || sclm_serviceslarequests_id_c='".$shared_portal_slarequest."'";
                              } 

                          } elseif ($sclm_configurationitemtypes_id_c == $acc_shared_type_ticketing){

                          $shared_portal_ticketing_status = $portal_items[$cntptl]['name'];

                          if ($shared_portal_ticketing_status != 1){
                             $sharepack['shared_portal_ticketing'] = 0;
                             } else {
                             $sharepack['shared_portal_ticketing'] = 1;
                             } 

                          } elseif ($sclm_configurationitemtypes_id_c == $acc_shared_type_portaladmin){

                          $shared_portal_admin_status = $portal_items[$cntptl]['name'];

                          if ($shared_portal_admin_status != 1){
                             $sharepack['shared_portal_admin'] = 0;
                             } else {
                             $sharepack['shared_portal_admin'] = 1;
                             } 

                          } elseif ($sclm_configurationitemtypes_id_c == $acc_shared_type_emails){

                          $shared_portal_emails_status = $portal_items[$cntptl]['name'];

                          if ($shared_portal_emails_status != 1){
                             $sharepack['shared_portal_emails'] = 0;
                             } else {
                             $sharepack['shared_portal_emails'] = 1;
                             } 

                          } elseif ($sclm_configurationitemtypes_id_c == $acc_shared_type_infra){

                          $shared_portal_infra_status = $portal_items[$cntptl]['name'];

                          if ($shared_portal_infra_status != 1){
                             $sharepack['shared_portal_infra'] = 0;
                             } else {
                             $sharepack['shared_portal_infra'] = 1;
                             } 

                          } # end elseif

                       # End checking
                       ###################

                       } // end for

                   $sharepack['shared_portal_projects'] = $shared_portal_projects;
                   $sharepack['shared_portal_projects_sql'] = $shared_portal_projects_sql;
                   $sharepack['shared_portal_slarequests'] = $shared_portal_slarequests;
                   $sharepack['shared_portal_slarequest_sql'] = $shared_portal_slarequest_sql;

                   } // end if array portal_items

                } // end for accounts shared 
                   
            } # end is_array 

         } # is array cis_list

      } else { # is accrel_ci_items array

      $sharepack['error'] = "No account relationship exists!";
      #echo "Error ".$sharepack['error']."<BR>";

      } 

  return $sharepack;

  } # end function

# End Sharing
################################
# Effects Mapper

  public function effects_mapper($params){

   global $BodyDIV,$portalcode,$api_user,$api_pass,$crm_wsdl_url;

   $item_id = $params[0];
   $item_type = $params[1];
   $item_name = $params[2];
   $effect_id = $params[3];
   $effect_name = $params[4];
   $effects_map = $params[5];

   $sfx_params = "";
   $sfx_params = array();
   $id_array = array();

   switch ($item_type){

    case 'Actions':

      $sfx_params[0] = "";
      $sfx_params[0] = "deleted=0 && sfx_actions_id_c='".$item_id."' ";
      $sfx_params[1] = "*";
      $sfx_params[2] = "";
      $sfx_params[3] = " effect_date DESC ";
      $sfx_params[4] = "";

//      $params[9] = array($item_id);

      $effects_map = "<img src=images/loading-reloaded.gif width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$item_id."&valuetype=Effects');return false\"><font color=#151B54><B>".$item_name."</B></font></a>";

     //$params[6] = array('object'=>$this_map,'id'=>$item_id);

    break;
    case 'Effects':

      $sfx_params[0] = "";
      $sfx_params[0] = " deleted=0 && slcm_events_id_c='".$effect_id."' ";
      $sfx_params[1] = "*";
      $sfx_params[2] = "";
      $sfx_params[3] = " effect_date DESC ";
      $sfx_params[4] = "";

//      $id_array[] = $effect_id;
      $effects_map = "<img src=images/loading-reloaded.gif width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$item_id."&valuetype=Effects');return false\"><font color=#151B54><B>".$item_name."</B></font></a>";

    break;

   } // end switch

   $sfx_object_type = "Effects";
   $sfx_action = "select";

   $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);

   if (is_array($effects)){

      if (!is_array($id_exists)){

         for ($cnt=0;$cnt < count($effects);$cnt++){

             $id = $effects[$cnt]['id'];
             $id_exists[] = $id;

             }
         }

      for ($cnt=0;$cnt < count($effects);$cnt++){

          $id = $effects[$cnt]['id'];
          $name = $effects[$cnt]['name'];

          if (in_array($id,$id_exists)){
             $width = 10;
             } else {
             $params[8]++;
             $width = $params[8]*10;
             }

          if ($effects_map != NULL){
             //$effects_map = "<BR><img src=images/blank.gif width=$width height=5>".$effects_map;
             }

          $sfx_effects_id_c = $effects[$cnt]['sfx_effects_id_c'];
          $sfx_effects_name = $effects[$cnt]['parent_effect_name'];
          $sfx_actions_id_c = $effects[$cnt]['sfx_actions_id_c'];
          $sfx_action_name = $effects[$cnt]['action'];

          if (!in_array($item_id,$id_array) && $sfx_actions_id_c != NULL && $sfx_actions_id_c != $item_id){

             $this_map = "<img src=images/loading-reloaded.gif width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Actions&action=view&value=".$item_id."&valuetype=Actions');return false\"><font color=#151B54><B>".$item_name."</B></font></a>";

             $params[0] = $sfx_actions_id_c;
             $params[1] = 'Actions';
             $params[2] = $sfx_action_name;
             $params[3] = $id;
             $params[4] = $name;
             $params[5] = $effects_map.$this_map;
             $params[6] = array('object'=>'Actions','id'=>$item_id);
             $params[7] = array('object'=>'Effects','id'=>$id);
             $effects_map = $this->effects_mapper($params);

             $id_array[] = $item_id;

             }

         if (!in_array($id,$id_array)){

             $this_map = "<BR><img src=images/blank.gif width=$width height=5><img src=images/loading_snake_white.gif width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$id."&valuetype=Effects');return false\"><font color=#151B54><B>".$name."</B></font></a>";

             $params[0] = $id;
             $params[1] = 'Effects';
             $params[2] = $name;
             $params[3] = $id;
             $params[4] = $name;
             $params[5] = $effects_map.$this_map;
             $params[6] = array('object'=>'Actions','id'=>$item_id);
             $params[7] = array('object'=>'Effects','id'=>$id);
             $params[9] = "";//$id_array[];
             $effects_map = $this->effects_mapper($params);

             } // if not exists in array

          $id_array[] = $id;

          } // end for

      } // is array

   return $params[5];

  } // end effects_mapper function

# End Effects Mapper
################################
# Encryption

    public function __set( $name, $value )
    {
        switch( $name)
        {
            case 'key':
            case 'ivs':
            case 'iv':
            $this->$name = $value;
            break;

            default:
            throw new Exception( "$name cannot be set" );
        }
    }

    /**
    *
    * Gettor - This is called when an non existant variable is called
    *
    * @access    public
    * @param    string    $name
    *
    */
    public function __get( $name )
    {
        switch( $name )
        {
            case 'zakey':
            return '5150';

            case 'zivs':
            return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB );

            case 'ziv':
   $ziv = substr( md5(mt_rand(),true), 0, 8 );
            //return mcrypt_create_iv( $this->zivs );
   return $ziv;

            default:
            throw new Exception( "$name cannot be called" );
        }
    }

    /**
    *
    * Encrypt a string
    *
    * @access    public
    * @param    string    $text
    * @return    string    The encrypted string
    *
    */

    public function encrypt($urll)
    {

  //echo strlen($urll) . "\n";
  
  for($i=0; $i<strlen($urll); $i++) {
   $char = substr($urll, $i, 1);
   $keychar = substr($this->zakey, ($i % strlen($this->zakey))-1, 1);
   $char = chr(ord($char)+ord($keychar));
   $result.=$char;
   }


  $result  = urlencode(base64_encode($result));
  $result = str_replace('%2B', '-', $result);
  $result = str_replace('%2F', '_', $result);

  //echo strlen($result ) . "\n";
  
  return $result ;
   
    }
 
    /**
    *
    * Decrypt a string
    *
    * @access    public
    * @param    string    $text
    * @return    string    The decrypted string
    *
    */
    public function decrypt($urll)
    {
  
  $urll = str_replace('-', '%2B', $urll);
  $urll = str_replace('_', '%2F', $urll);
  $string = base64_decode(urldecode($urll));

 for($i=0; $i<strlen($string); $i++) {
             $char = substr($string, $i, 1);
             $keychar = substr($this->zakey, ($i % strlen($this->zakey))-1, 1);
             $char = chr(ord($char)-ord($keychar));
             $resultt.=$char;
            }

  return $resultt;

    }
 
 # End Encryptor
 ################################
 # Create Sugar ID

function create_guid() {

$microTime = microtime();
list($a_dec, $a_sec) = explode(" ", $microTime);
$dec_hex = sprintf("%x", $a_dec* 1000000);
$sec_hex = sprintf("%x", $a_sec);
$this->ensure_length($dec_hex, 5);
$this->ensure_length($sec_hex, 6);
$guid = "";
$guid .= $dec_hex;
$guid .= $this->create_guid_section(3);
$guid .= '-';
$guid .= $this->create_guid_section(4);
$guid .= '-';
$guid .= $this->create_guid_section(4);
$guid .= '-';
$guid .= $this->create_guid_section(4);
$guid .= '-';
$guid .= $sec_hex;
$guid .= $this->create_guid_section(6);
return $guid;
}

function create_guid_section($characters){
 $return = "";
 for($i=0; $i<$characters; $i++){
    $return .= sprintf("%x", mt_rand(0,15));
    }
return $return;
}

function ensure_length(&$string, $length){
 $strlen = strlen($string);
 if($strlen < $length){
   $string = str_pad($string,$length,"0");
   } else if($strlen > $length) {
     $string = substr($string, 0, $length);
   }
}

 #
 ################################
 # 0 - Password Generator
 /**
  * The letter l (lowercase L) and the number 1
  * have been removed, as they can be mistaken
  * for each other.
  */

 function createRandomPassword() {

     $chars = "abcdefghijkmnopqrstuvwxyz023456789";

     srand((double)microtime()*1000000);

     $i = 0;

     $pass = '' ;

     while ($i <= 7) {

         $num = rand() % 33;

         $tmp = substr($chars, $num, 1);

         $pass = $pass . $tmp;

         $i++;

     }

     return $pass;

 }
 
 # End Password Generator
 ################################ 
 # Create Realpolitika Code
 
 function cleantext ($starttext,$do,$id){
  
  global $sess_contact_id;
  
  $text = str_replace("<?", "", $starttext);
  $text = str_replace("?>", "", $text);
  $text = str_replace("<%", "", $text);
  $text = str_replace("%>", "", $text);
  $text = str_replace("<script type=\"text/javascript\">", "", $text);
  $text = str_replace("<script type='text/javascript'>", "", $text);
  $text = str_replace("function", "", $text);
  $text = str_replace("try{", "", $text);
  $text = str_replace("try {", "", $text);
  $text = str_replace("</script>", "", $text);
  
  if ($starttext != $text){
   
   $body = "The current user ID: ".$sess_contact_id." has sent code for Object: ".$do." with ID: ".$id;
   
   $this->do_email ('Realpolitika', 'Realpolitika', 'saloobinc@gmail.com', 'saloobinc@gmail.com', 1, 'j', 'Suspect Code Detected', $body);
   return ""; // Send nothing back
   
   } else {
   
   return $text;
   
   }
  
  } // end clean text
 
 function yesno ($fieldval){
    
  if ($fieldval == 1){
   $yesnoval = 'Yes';
   } else {
   $yesnoval = 'No';
   }
    
   return $yesnoval;
  
  } // end yesno function

 #
 ############################
 # Check Email Validation

 /**
 Validate an email address.
 Provide email address (raw input)
 Returns true if the email address has the email 
 address format and the domain exists.
 */

 function validEmail($email)
 {
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
 }

 # End Check Email Validation
 ################################
 #

 function create_rp (){
  
  global $realpolitika_config;
  
  $synchkey = $realpolitika_config['portalconfig']['synchkey'];
  $date = date("Y@m@d@G");
  
  $date = $this->encrypt($date);
  $portalcode = $synchkey."@".$date;
  
  $portalcode = $this->encrypt($portalcode);
  
  return $portalcode;

 }


 #
 ################################
 # Field Language Generator

 function creditisor ($params){

  global $credits_base_rate,$credits_base_currency,$credits_partner_share,$crm_api_user,$crm_api_pass,$crm_wsdl_url;

  $credits = $params[0];
  $this_currency = $params[1];
  $price_account_id_c = $params[2];

  # Reseller Commission - set in portal configurations
  $commission_cit = '771c822d-0966-41d7-c00b-54e4c259bed1';

  $comm_object_type = 'ConfigurationItems';
  $comm_action = "select";
  $comm_params[0] = " sclm_configurationitemtypes_id_c='".$commission_cit."' && account_id_c='".$price_account_id_c."' ";
  $comm_params[1] = ""; // select array
  $comm_params[2] = ""; // group;
  $comm_params[3] = ""; // order;
  $comm_params[4] = ""; // limit
  
  $comm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $comm_object_type, $comm_action, $comm_params);

  if (is_array($comm_items)){

     for ($comm_cnt=0;$comm_cnt < count($comm_items);$comm_cnt++){

         #$id = $comm_items[$comm_cnt]['id'];
         $reseller_commission = $comm_items[$comm_cnt]['name'];

         } # for

     #$reseller_commission = $reseller_commission/100;

     } else {# is array

     # 
     #$reseller_commission = $credits_partner_share;
     $reseller_commission = 0;

     } # commission

  # ddd07ef1-8ce6-2188-ae4e-5157be0c437e | Japanese Yen       | JPY      |             100 
  #echo "$this_currency == $credits_base_currency";
  #echo "reseller_commission = ".$reseller_commission."<BR>";

  $curr_object_type = 'Currencies';
  $curr_action = "select";
  $curr_params[0] = " id='".$this_currency."' ";
  $curr_params[1] = "name,iso_code,cmn_countries_id_c"; // select array
  $curr_params[2] = ""; // group;
  $curr_params[3] = ""; // order;
  $curr_params[4] = ""; // limit
  
  $curr_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $curr_object_type, $curr_action, $curr_params);

  if (is_array($curr_items)){

     for ($crrcnt=0;$crrcnt < count($curr_items);$crrcnt++){

         #$id = $curr_items[$crrcnt]['id'];
         $name = $curr_items[$crrcnt]['name'];
         #$number_to_basic = $curr_items[$crrcnt]['number_to_basic'];
         #$fractional = $curr_items[$crrcnt]['fractional'];
         $iso_code = $curr_items[$crrcnt]['iso_code'];
         $cmn_countries_id_c = $curr_items[$crrcnt]['cmn_countries_id_c'];
 
         } // end for
     
     } else { // end if array

     }

  # Not using any currency changes here
  # May use for payments, but until then - basic pricing based on selected currency

  $credit_value = $credits;
  $provider_share = $credit_value*(1-$reseller_commission);
  $partner_share = $credit_value*$reseller_commission;

  $credit_return[0] = $credit_value;
  $credit_return[1] = $provider_share;
  $credit_return[2] = $partner_share;
  $credit_return[3] = $name;
  $credit_return[4] = $iso_code;
  $credit_return[5] = $cmn_countries_id_c;

  return $credit_return;

 } // end creditisor

 # End Creditisor
 ################################
 # Get security

 function get_security ($role_c){

             switch ($role_c){

              case '':
              case '43b66381-12b8-7c4b-0602-5276698dcb48': // Guest

               $security_level = 0;

              break;
              case '9dc1781c-af86-5a27-b16e-52732adde5b6': // Account Member

               $security_level = 1;

              break;
              case '9f9eac92-9527-b7fe-926c-527329fc72e1': // Account Administrator

               $security_level = 2;

              break;
              case '2388a2b4-13b2-21ef-fe07-52732991fbfc': // System Admin

               $security_level = 3;

              break;
              case '2803fc3c-a696-1037-4474-527845cbabb0': // Team Leader

               $security_level = 2;

              break;
              case 'b9b2568b-2e44-4f95-439d-5303deb3d1b5': // Service Delivery Manager

               $security_level = 2;

              break;

             } // end role switch

  return $security_level;

 } # get security

 # Get roles
 ################################
 # Do rego

 function do_rego ($passed_params){

  # Set neccesary globals
  global $crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$crm_api_user, $crm_api_pass, $crm_wsdl_url,$portal_title,$hostname,$standard_statuses_closed,$parent_account_id,$portal_account_id,$assigned_user_id,$portal_email,$portal_email_password,$portal_email_server,$portal_email_smtp_port,$portal_email_smtp_auth,$strings,$lingo,$cmn_countries_id_c;

  $baseurl = "https://".$hostname;

  # Collect all params

  $service_leadsources_id_c = $passed_params[0]['service_leadsources_id_c'];
  $service_ci_source = $passed_params[0]['service_ci_source']; # This will act as the wrapper for any userids under it as parent
  $service_parci_id = $passed_params[0]['service_parci_id'];
  $members_cit_id = $passed_params[0]['members_cit_id'];

  $sess_contact_id = $passed_params[1]['portal_contact']; 
  $sess_account_id = $passed_params[1]['portal_account']; 

  $sc_session = $passed_params[1]['scalastica'];
  $fb_session = $passed_params[1]['facebook'];
  $li_session = $passed_params[1]['linkedin'];
  $gg_session = $passed_params[1]['google'];

  # If either of these sessions already exist, then could link it to that account - otherwise by email..

  switch ($service_leadsources_id_c){

   case "d2dc840e-c041-d08d-9f53-51bf7aac9cb7": # Scalastica

    $service_name = $portal_title;
    $sess_var = "scalastica";

   break;
   case "c3b95266-d158-bd41-f241-55169e31dbc7": # Facebook

    $service_name = "Facebook";
    $sess_var = "facebook";

   break;
   case "b072a533-4274-cdd8-5f64-5518f035719a": # LinkedIn

    $service_name = "LinkedIn";
    $sess_var = "linkedin";

   break;
   case "52139b42-630e-d13f-9578-5518f0df3545": # Google

    $service_name = "Google";
    $sess_var = "google";

   break;

  } # switch

  $account_name = $passed_params[3]['account_name'];
  $userid = $passed_params[3]['userid'];
  $user_name = $passed_params[3]['name'];
  $first_name = $passed_params[3]['first_name'];
  $last_name = $passed_params[3]['last_name'];
  $email = $passed_params[3]['email'];
  $timezone = $passed_params[3]['timezone'];
  $locale = $passed_params[3]['locale'];
  $password = $passed_params[3]['password'];

  if (!$account_name){
     $account_name = $first_name." ".$last_name;
     }

  $role_c = $passed_params[4]['role_c'];
  $security_level = $passed_params[4]['security_level'];

  if (!$role_c){
     $role_c = "9f9eac92-9527-b7fe-926c-527329fc72e1"; # Account admin
     }

  $security_level = $this->get_security ($role_c);

  if ($password == NULL){
     $password = $this->createRandomPassword();
     }

  $entity_type = $passed_params[5];

  $rego_hostname = $passed_params[6]['hostname']; # used for business accounts
  $rego_hostname_type = $passed_params[6]['hostname_type'];

  # Start the messaging
  $process_messages .= "<P>Welcome to the ".$portal_title." registration, ".$first_name."!<P>";
  $process_messages .= "Your ".$service_name." email is: ".$email."<BR>";
  $process_messages .= "Your ".$service_name." ID is: ".$userid."<P>";

  # Show service name based on sess var

  #var_dump($passed_params[3]);

  $syncuid = "";

  if ($sc_session != NULL && $sess_var != "scalastica"){

     # There is a FB session, but the user wants to connect another account to the FB one!
     $process_messages .= "Your ".$portal_title." account exists with us already - welcome back!<P>";
     $process_messages .= "We will now try to link your ".$service_name." account with this one...<P>";
     $syncuid = $sc_session;

     } 

  if ($fb_session != NULL && $sess_var != "facebook"){

     # There is a FB session, but the user wants to connect another account to the FB one!
     $process_messages .= "Your Facebook account exists with ".$portal_title." already - welcome back!<P>";
     $process_messages .= "We will now try to link your ".$service_name." account with this one...<P>";
     $syncuid = $fb_session;

     } 

  if ($li_session != NULL && $sess_var != "linkedin"){

     # There is a LI session, but the user wants to connect another account to the LI one!
     $process_messages .= "Your LinkedIn account exists with ".$portal_title." already - welcome back!<P>";
     $process_messages .= "We will now try to link your ".$service_name." account with this one...<P>";
     $syncuid = $li_session;

     } 

  if ($gg_session != NULL && $sess_var != "google"){

     # There is a GG session, but the user wants to connect another account to the GG one!
     $process_messages .= "Your Google account exists with ".$portal_title." already - welcome back!<P>";
     $process_messages .= "We will now try to link your ".$service_name." account with this one...<P>";
     $syncuid = $gg_session;

     }

  # Check if already signed-in and wants to sync another account
  if ($syncuid != NULL){

     $sync_rego_object_type = "ConfigurationItems";
     $sync_rego_action = "select";
     $sync_rego_params = "";
     $sync_rego_params[0] = " deleted=0 && name='".$syncuid."' ";
     $sync_rego_params[1] = "id,name,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c";
     $sync_rego_params[2] = "";
     $sync_rego_params[3] = "";
     $sync_rego_params[4] = "";
   
     $sync_rego_rows = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sync_rego_object_type, $sync_rego_action, $sync_rego_params);

     if (is_array($sync_rego_rows)){

        # This user exists for this source (FB)
        for ($syncrego_cnt=0;$syncrego_cnt < count($sync_rego_rows);$syncrego_cnt++){

            $sync_rego_ci_id = $sync_rego_rows[$syncrego_cnt]['id'];
            $sync_rego_contact_id_c = $sync_rego_rows[$syncrego_cnt]['contact_id_c'];
            $sync_rego_account_id_c = $sync_rego_rows[$syncrego_cnt]['account_id_c'];

            } # for

        } # is array

     # Check to see if the id exists already
     $exist_rego_object_type = "ConfigurationItems";
     $exist_rego_action = "select";
     $exist_rego_params = array();
     $exist_rego_params[0] = " deleted=0 && name='".$userid."'";
     $exist_rego_params[1] = "id,name,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c";
     $exist_rego_params[2] = "";
     $exist_rego_params[3] = "";
     $exist_rego_params[4] = "";
   
     $exist_rego_rows = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $exist_rego_object_type, $exist_rego_action, $exist_rego_params);

     #echo "UserID $userid Should be array";
     #var_dump($exist_rego_rows);
     #exit;

     if (!is_array($exist_rego_rows)){

        echo "<P>not array<P>";

        # Set the userid under the service that has been allowed (fb)
        $process_object_type = "ConfigurationItems";
        $process_action = "update";
        $process_params = "";
        $process_params = array();  
        $process_params[] = array('name'=>'name','value' => $userid);
        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
        $process_params[] = array('name'=>'description','value' => $userid);
        $process_params[] = array('name'=>'account_id_c','value' => $sync_rego_account_id_c);
        $process_params[] = array('name'=>'contact_id_c','value' => $sync_rego_contact_id_c);
        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $service_parci_id);
        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $members_cit_id);
        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

        $process_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
        $source_id = $process_result['id'];

        # Set the Contacts Sources - depricated.. should already have been done for the other service it was based on...
        $source_object_type = "Contacts";
        $source_action = "create_sclm_ContactsSources";
        $source_params = "";
        $source_params = array(
                   array('name'=>'name','value' => $first_name." from ".$portal_title." on ".$service_name),
                   array('name'=>'contact_id_c','value' => $sync_rego_contact_id_c),
                   array('name'=>'account_id_c','value' => $sync_rego_account_id_c),
                   array('name'=>'source_id','value' => $source_id),
                   array('name'=>'sclm_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 
      
        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $source_object_type, $source_action, $source_params);

        } # end of adding the session

     switch ($sess_var){

      case 'google':
       #$_SESSION['google'] = $userid;
       $process_messages .= "Your account with ".$service_name." has now been linked to ".$portal_title." - welcome!<P>";
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='api-google.php/?gguid=".$userid."'\"><P>";
      break;
      case 'facebook':
       $_SESSION['facebook'] = $userid;
       $process_messages .= "Your account with ".$service_name." has now been linked to ".$portal_title." - welcome!<P>";
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
      break;
      case 'linkedin':
       $_SESSION['linkedin'] = $userid;
       $process_messages .= "Your account with ".$service_name." has now been linked to ".$portal_title." - welcome!<P>";
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
      break;
      case 'scalastica':
       $_SESSION['scalastica'] = $userid;
       $process_messages .= "Your account with ".$service_name." has now been linked to ".$portal_title." - welcome!<P>";
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
      break;

     } # switch

     # Set the sessions and get out!
     # Will still keep the original ones
     #$_SESSION["contact_id"] = $rego_contact_id_c;
     #$_SESSION["account_id"] = $rego_account_id_c;
     #$_SESSION['security_level'] = $security_level;
     #$_SESSION['security_role'] = $role_c;

     } else {

     $syncrego_rows = "";

     # Begin checking if exists by userid - simplest way - then by email   
     $syncrego_object_type = "ConfigurationItems";
     $syncrego_action = "select";
     $syncrego_params = array();
     $syncrego_params[0] = " deleted=0 && name='".$userid."'";
     $syncrego_params[1] = "id,name,contact_id_c,account_id_c";
     $syncrego_params[2] = "";
     $syncrego_params[3] = "";
     $syncrego_params[4] = "";
   
     $syncrego_rows = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $syncrego_object_type, $syncrego_action, $syncrego_params);

     } # if no sync - will create empty array

    #echo "UserID $userid Should be array";
    #var_dump($syncrego_rows);
    #exit;

  if (is_array($syncrego_rows) && $syncuid == NULL){

     # This user exists for this source (FB)
     $process_messages .= "Your ".$service_name." account exists with ".$portal_title." already - welcome back!<P>";

     for ($syncrego_cnt=0;$syncrego_cnt < count($syncrego_rows);$syncrego_cnt++){

         $rego_ci_id = $syncrego_rows[$syncrego_cnt]['id'];
         $rego_contact_id_c = $syncrego_rows[$syncrego_cnt]['contact_id_c'];
         $rego_account_id_c = $syncrego_rows[$syncrego_cnt]['account_id_c'];

         } # for

     switch ($sess_var){

      case 'google':
       #$_SESSION['google'] = $userid;
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='api-google.php/?gguid=".$userid."'\"><P>";
      break;
      case 'facebook':
       $_SESSION['facebook'] = $userid;
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
      break;
      case 'linkedin':
       $_SESSION['linkedin'] = $userid;
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
      break;
      case 'scalastica':
       $_SESSION['scalastica'] = $userid;
       $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
      break;

     } # switch

     $_SESSION['contact_id'] = $rego_contact_id_c;
     $_SESSION['account_id'] = $rego_account_id_c;
     $_SESSION['security_level'] = $security_level;
     $_SESSION['security_role'] = $role_c;
     
     $process_message['rego_status'] = 'OK';
     $process_message['rego_contact_id'] = $rego_contact_id_c;
     $process_message['rego_account_id'] = $rego_account_id_c;
     $process_message['rego_security_level'] = $security_level;
     $process_message['rego_security_role'] = $role_c;
     $process_message['rego_messages'] = $process_messages; 

     } elseif ($syncuid == NULL) {# is not array

     # This user does NOT exist for this source in our system yet
     $process_messages .= "Your ".$service_name." account does not exist with us - we will check your email (".$email.") from another service...<P>";

     $check_object_type = "Contacts";
     $check_action = "contact_by_email";
     $check_params = "";
     $check_params = $email; // query

     $rego_contact_id_c = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_object_type, $check_action, $check_params);

     if ($rego_contact_id_c != NULL){
 
        $process_messages .= "Your ".$service_name." email (".$email.") exists with us already - we will now link it to ".$portal_title."...<P>";

        # Get account entry - with contact
        $accid_object_type = "Contacts";
        $accid_action = "get_account_id";
        $accid_params = "";
        $accid_params[0] = $rego_contact_id_c;
        $accid_params[1] = "account_id";

        $rego_account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

        # Set the userid under the service that has been allowed (fb)
        $process_object_type = "ConfigurationItems";
        $process_action = "update";
        $process_params = "";
        $process_params = array();  
        $process_params[] = array('name'=>'name','value' => $userid);
        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
        $process_params[] = array('name'=>'description','value' => $userid);
        $process_params[] = array('name'=>'contact_id_c','value' => $rego_contact_id_c);
        $process_params[] = array('name'=>'account_id_c','value' => $rego_account_id_c);
        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $service_parci_id);
        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $members_cit_id);
        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

        $rego_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
        $source_id = $rego_result['id'];    

        # Set the Contacts Sources - depricated.. should already have been done for the other service it was based on...
        $source_object_type = "Contacts";
        $source_action = "create_sclm_ContactsSources";
        $source_params = "";
        $source_params = array(
                   array('name'=>'name','value' => $first_name." from ".$portal_title." on ".$service_name),
                   array('name'=>'contact_id_c','value' => $rego_contact_id_c),
                   array('name'=>'account_id_c','value' => $rego_account_id_c),
                   array('name'=>'source_id','value' => $source_id),
                   array('name'=>'sclm_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 
   
        $source_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $source_object_type, $source_action, $source_params);

        # Set the sessions and get out!

        $process_messages .= "Your account with ".$service_name." has now been linked to ".$portal_title." - welcome!<P>";

        switch ($sess_var){

         case 'google':
          #$_SESSION['google'] = $userid;
          $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='api-google.php/?gguid=".$userid."'\"><P>";
         break;
         case 'facebook':
          $_SESSION['facebook'] = $userid;
          $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
         break;
         case 'linkedin':
          $_SESSION['linkedin'] = $userid;
          $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
         break;
         case 'scalastica':
          $_SESSION['scalastica'] = $userid;

          $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
         break;

        } # switch

        $_SESSION["contact_id"] = $rego_contact_id_c;
        $_SESSION["account_id"] = $rego_account_id_c;
        $_SESSION['security_level'] = $security_level;
        $_SESSION['security_role'] = $role_c;
        
        $process_message['rego_status'] = 'OK';
        $process_message['rego_contact_id'] = $rego_contact_id_c;
        $process_message['rego_account_id'] = $rego_account_id_c;
        $process_message['rego_security_level'] = $security_level;
        $process_message['rego_security_role'] = $role_c;
        $process_message['rego_messages'] = $process_messages; 
              
        } else {# end if contact exists by email

        # This user does NOT exist for this source or email in our system yet
        $process_messages .= "Your ".$service_name." account and email (".$email.") do not exist with ".$portal_title." - we will set it up now...<P>";
        # Assume this is not in our DB for anything - and create new completely
        # User doesn't exist by email - create new contact

        $cont_object_type = "Contacts";
        $cont_action = "update";
        $cont_params = "";
        $cont_params = array();
        $cont_params = array(
                   array('name'=>'name','value' => $account_name),
                   array('name'=>'first_name','value' => $first_name),
                   array('name'=>'last_name','value' => $last_name),
                   array('name'=>'email1','value' => $email),
                   array('name'=>'role_c','value' => $role_c),
                   array('name'=>'password_c','value' => $password),
                   array('name'=>'cmn_countries_id_c','value' => $cmn_countries_id_c)
                   ); 

        $cont_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $cont_object_type, $cont_action, $cont_params);
        $rego_contact_id_c = $cont_result['id'];

        #var_dump($cont_result);
        #exit;

        if ($rego_contact_id_c != NULL){

           # Create the account
           $acc_object_type = "Accounts";
           $acc_action = "update";
           $acc_params = "";
           $acc_params = array();
           $acc_params = array(
                   array('name'=>'name','value' => $account_name),
                   array('name'=>'parent_id','value' => $portal_account_id),
                   array('name'=>'account_id_c','value' => $portal_account_id),
                   array('name'=>'contact_id_c','value' => $rego_contact_id_c),
                   array('name'=>'status_c','value' => $standard_statuses_closed),
                   array('name'=>'cmn_countries_id_c','value' => $cmn_countries_id_c)
                   ); 

           $acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $acc_object_type, $acc_action, $acc_params);
           $rego_account_id_c = $acc_result['id'];

           if ($rego_account_id_c != NULL){

              # Add Account to the contact
              $crego_object_type = "Contacts";
              $crego_action = "update";
              $crego_params = "";
              $crego_params = array(
                array('name'=>'id','value' => $rego_contact_id_c),
                array('name'=>'account_id','value' => $rego_account_id_c)
                ); 

              $cont_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $crego_object_type, $crego_action, $crego_params);

              # Relate the contact to the account as the owner/admin
              $rrego_object_type = "Relationships";
              $rrego_action = "set_modules_soap";
              $rrego_params = "";
              $rrego_params = array();
              $rrego_params[0] = "Accounts";
              $rrego_params[1] = $rego_account_id_c;
              $rrego_params[2] = "Contacts";
              $rrego_params[3] = $rego_contact_id_c;

              $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rrego_object_type, $rrego_action, $rrego_params);

              # Relate the account to the contact as the owner/admin
              $rrego_object_type = "Relationships";
              $rrego_action = "set_modules_soap";
              $rrego_params = "";
              $rrego_params = array();
              $rrego_params[0] = "Contacts";
              $rrego_params[1] = $rego_contact_id_c;
              $rrego_params[2] = "Accounts";
              $rrego_params[3] = $rego_account_id_c;

              $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rrego_object_type, $rrego_action, $rrego_params);

              # Set Parent Account
              $relgo_object_type = "Relationships";
              $relgo_action = "set_modules_soap";
              $relgo_params = "";
              $relgo_params = array();
              $relgo_params[0] = "Accounts";
              $relgo_params[1] = $portal_account_id;
              $relgo_params[2] = "Accounts";
              $relgo_params[3] = $rego_account_id_c;

              $par_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $relgo_object_type, $relgo_action, $relgo_params);

              # Set the userid under the service that has been allowed (fb)
              $process_object_type = "ConfigurationItems";
              $process_action = "update";
              $process_params = "";
              $process_params = array();  
              $process_params[] = array('name'=>'name','value' => $userid);
              $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
              $process_params[] = array('name'=>'description','value' => $userid);
              $process_params[] = array('name'=>'contact_id_c','value' => $rego_contact_id_c);
              $process_params[] = array('name'=>'account_id_c','value' => $rego_account_id_c);
              $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $service_parci_id);
              $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $members_cit_id);
              $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

              $rego_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
              $source_id = $rego_result['id'];    

              # Set the Contacts Sources - depricated.. should already have been done for the other service it was based on...
              $source_object_type = "Contacts";
              $source_action = "create_sclm_ContactsSources";
              $source_params = "";
              $source_params = array(
                   array('name'=>'name','value' => $first_name." from ".$portal_title." on ".$service_name),
                   array('name'=>'contact_id_c','value' => $rego_contact_id_c),
                   array('name'=>'account_id_c','value' => $rego_account_id_c),
                   array('name'=>'source_id','value' => $source_id),
                   array('name'=>'sclm_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 
   
              $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $source_object_type, $source_action, $source_params);

              # Manage hostnames if any sent
              $hostname_cit = "ad2eaca7-8f00-9917-501a-519d3e8e3b35";
   
              if ($rego_hostname != NULL && $rego_hostname_type != NULL){

                 switch ($rego_hostname_type){

                   case 'sub':
   
                    $rego_hostname = $rego_hostname.".".$hostname; # create the subdomain from this portal hostname

                   break;

                 } # end switch hn type

                 # First confirm it doesn't already exist
                 $process_object_type = "ConfigurationItems";
                 $process_action = "select";
                 $process_params = "";
                 $process_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$hostname_cit."' && name='".$rego_hostname."' ";
                 $process_params[1] = "id,name,contact_id_c,account_id_c";
                 $process_params[2] = "";
                 $process_params[3] = "";
                 $process_params[4] = "";

                 $hn_rows = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $process_object_type, $process_action, $process_params);

                 if (is_array($hn_rows)){

                    # Already exists!
                    $process_messages .= "The hostname (".$rego_hostname.") you selected already exists - it must be unique - please try again from the Account Details menu...<P>";

                    } else {
   
                    $process_messages .= "The hostname (".$rego_hostname.") you selected does not already exist with us - please be sure to set your DNS A Records to point at the IP of ".$hostname." [119.27.35.191] - unless you have selected our sub-domain, in which case we will notify you when is is ready. This can later be adjusted in the Account Details menu...<P>";

                    $process_object_type = "ConfigurationItems";
                    $process_action = "update";
                    $process_params = "";
                    $process_params = array();  
                    #$process_params[] = array('name'=>'id','value' => $_POST['hostname_id']);
                    $process_params[] = array('name'=>'name','value' => $rego_hostname);
                    $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                    $process_params[] = array('name'=>'description','value' => $rego_hostname);
                    $process_params[] = array('name'=>'account_id_c','value' => $rego_account_id_c);
                    $process_params[] = array('name'=>'contact_id_c','value' => $rego_contact_id_c);
                    #$process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
                    $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'ad2eaca7-8f00-9917-501a-519d3e8e3b35');
                    $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
   
                    $hn_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                    } # if portal_hostname

                 } else {# end if hostname sent

                 $process_messages .= "No hostname was selected for this account. This can be adjusted from the Account Details menu...<P>";

                 } # end if hostname

              # Add Account relationship
              $par_account_returner = $this->object_returner ("Accounts", $portal_account_id);
              $par_account_name = $par_account_returner[0];
              $ar_name = $par_account_name. " (Parent) -> ".$account_name." (Child)";

              $process_object_type = "AccountRelationships";
              $process_action = "update";
              $process_params = "";
              $process_params = array();  
              $process_params[] = array('name'=>'name','value' => $ar_name);
              $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
              $process_params[] = array('name'=>'description','value' => $ar_name);
              $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id);
              $process_params[] = array('name'=>'account_id1_c','value' => $rego_account_id_c);
              $process_params[] = array('name'=>'entity_type','value' => $entity_type);

              $ar_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
              $account_rel_id = $ar_result['id']; # used below for sharing features

              # Portal Registration Auto Access: cafad60b-6fab-dbd2-66d6-54d7a1988a3e
              # Check to see if allows for portal auto-access - otherwise admin must add manually
              # Needed if the client chooses no domain but still needs access - normal multi-tenancy

              $ci_object_type = "ConfigurationItems";
              $ci_action = "select";
              $ci_params = "";
              $ci_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='cafad60b-6fab-dbd2-66d6-54d7a1988a3e' && name=1";
              $ci_params[1] = "id"; // select array
              $ci_params[2] = ""; // group;
              $ci_params[3] = ""; // order;
              $ci_params[4] = ""; // limit
  
              $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

              if (is_array($ci_items)){

                 # If Portal Access Allowed 
                 # Get acc admin
                 $process_message .= "Portal access to ".$service_name." is allowed - will set...<P>";

                 $acc_object_type = "Accounts";
                 $acc_action = "select_cstm";
                 $acc_params[0] = "id_c='".$portal_account_id."' ";
                 $acc_params[1] = "contact_id_c"; // select
                 $acc_params[2] = ""; // group;
                 $acc_params[3] = ""; // order;
                 $acc_params[4] = ""; // limit

                 $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

                 if (is_array($account_info)){
      
                    for ($cnt=0;$cnt < count($account_info);$cnt++){

                        $account_admin_id = $account_info[$cnt]['contact_id_c']; // Administrator

                        } // for

                    } // if array

                 # Related Account Sharing Set: 3172f9e9-3915-b709-fc58-52b38864eaf6
                 $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';
                 $image_returner = $this->object_returner ("ConfigurationItemTypes", $acc_sharing_set);
                 $image_url = $image_returner[7];
   
                 $process_object_type = "ConfigurationItems";
                 $process_action = "update";
                 $process_params = "";
                 $process_params = array();
                 $process_params[] = array('name'=>'name','value' => $account_rel_id);
                 $process_params[] = array('name'=>'enabled','value' => 1);
                 $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_sharing_set);
                 $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                 $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id); # Parent owns this 
                 $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
                 $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                 $process_params[] = array('name'=>'image_url','value' => $image_url);

                 $rel_acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                 $rel_acc_id = $rel_acc_result['id']; # Used below

                 # Allowed Shared Account
                 $shared_account_ci = '8ff4c847-2c82-9789-f085-52b3897c8bf6';
                 $image_returner = $this->object_returner ("ConfigurationItemTypes", $shared_account_ci);
                 $image_url = $image_returner[7];

                 $process_object_type = "ConfigurationItems";
                 $process_action = "update";
                 $process_params = "";
                 $process_params = array();
                 $process_params[] = array('name'=>'name','value' => $rego_account_id_c);
                 $process_params[] = array('name'=>'enabled','value' => 1);
                 $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $rel_acc_id);
                 $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $shared_account_ci);
                 $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                 $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id); # Parent owns this 
                 $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
                 $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                 $process_params[] = array('name'=>'image_url','value' => $image_url);
      
                 $sh_acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                 $shared_acc_id = $sh_acc_result['id']; # Used below for access to portal

                 # Allow Parent Portal Access
                 $acc_shared_type_portalaccess = 'e2affd29-d116-caa8-6f0c-52fa4d034cf5';
                 $image_returner = $this->object_returner ("ConfigurationItemTypes", $acc_shared_type_portalaccess);
                 $image_url = $image_returner[7];

                 $process_object_type = "ConfigurationItems";
                 $process_action = "update";
                 $process_params = "";
                 $process_params = array();
                 $process_params[] = array('name'=>'name','value' => 1);
                 $process_params[] = array('name'=>'enabled','value' => 1);
                 $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $shared_acc_id);
                 $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_shared_type_portalaccess);
                 $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                 $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id); # Parent owns this 
                 $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
                 $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                 $process_params[] = array('name'=>'image_url','value' => $image_url);

                 $port_access_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                 $port_access_id = $port_access_result['id'];

                 $process_messages .= "Portal access to ".$service_name." has been set - see Account Details for other features...<P>";

                 } # end is_arrayi_items

                $process_messages .= "Your ".$service_name." account and email (".$email.") have now been linked to ".$portal_title." - welcome!<P>";

                 switch ($sess_var){

                  case 'google':
                   #$_SESSION['google'] = $userid;
                   $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='api-google.php/?gguid=".$userid."'\"><P>";
                  break;
                  case 'facebook':
                   $_SESSION['facebook'] = $userid;
                   $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
                  break;
                  case 'linkedin':
                   $_SESSION['linkedin'] = $userid;
                   $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
                  break;
                  case 'scalastica':
                   $_SESSION['scalastica'] = $userid;
                   $process_messages .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" value=\"".$strings["action_clicktologin"]."\" onClick=\"location.href='../'\"><P>";
                  break;

                 } # switch

              $_SESSION["contact_id"] = $rego_contact_id_c;
              $_SESSION['account_id'] = $rego_account_id_c;
              $_SESSION['security_level'] = $security_level;
              $_SESSION['security_role'] = $role_c;
              
              $process_message['rego_status'] = 'OK';
              $process_message['rego_contact_id'] = $rego_contact_id_c;
              $process_message['rego_account_id'] = $rego_account_id_c;
              $process_message['rego_security_level'] = $security_level;
              $process_message['rego_security_role'] = $role_c;
              $process_message['rego_messages'] = $process_messages; 

              # Send rego email

              $subject = $portal_title." Account Registration";

              $body = $first_name.", you have tried to register with ".$portal_title." with the following email address;\n
             Email: ".$email."\n
             Please use the following password to access your account;\n
             Password: ".$password." \n
             URL: ".$baseurl." \n
             Enyoy using ".$portal_title."!";

              $to_name = $first_name." ".$last_name;

              $from_name = $portal_title;
              $from_email = $portal_email;
              $from_email_password = $portal_email_password;

              $mailparams[0] = $from_name;
              #$mailparams[1] = $to_name;
              $mailparams[2] = $from_email;
              $mailparams[3] = $from_email_password;
              #$mailparams[4] = $to_email;
              $type = 1;
              $mailparams[5] = $type;
              $lingo = "en";
              $mailparams[6] = $lingo;
              $mailparams[7] = $subject;
              $mailparams[8] = $body;
              $mailparams[9] = $portal_email_server;
              $mailparams[10] = $portal_email_smtp_port;
              $mailparams[11] = $portal_email_smtp_auth;

              $internal_to_addressees[$email] = $to_name;
              $internal_to_addressees[$from_email] = $portal_email;
              $mailparams[12] = $internal_to_addressees;
              $mailparams[20] = $attachments;

              $emailresult = $this->do_email ($mailparams);

              if ($emailresult[0] == 'OK'){


                 $process_messages .= "Please check your email to get your password - it has been sent there.<P>";
                 $process_message['rego_email_status'] = 'OK'; 
                 $process_message['rego_messages'] = $process_messages;

                 } else {

                 $process_message .= "There seems to be a problem sending to this email - please check with the Administrator by contacting directly by email @: ".$portal_email.".<P>";
                 
                 $process_message['rego_email_status'] = 'NG'; 
                 $process_message['rego_messages'] = $process_messages;

                 }

              } else {# if account created

              $process_messages .= "This Account could not be created - please check with the Administrator: $portal_email...<P>";
              $process_messages .= "<a href=".$baseurl." target=_parent>Click here</a> to return...<P>";
              
              $process_message['rego_status'] = 'NG'; 
              $process_message['rego_messages'] = $process_messages;

              } # no Account created

           } else {# if contact created

           $process_messages .= "This User could not be created - please check with the Administrator: $portal_email...<P>";
           $process_messages .= "<a href=".$baseurl." target=_parent>Click here</a> to return...<P>";
           
           $process_message['rego_status'] = 'NG'; 
           $process_message['rego_messages'] = $process_messages;           

           } # no User/Contact created

        } # end if not in system at all

     } # end if not in DB as user yet

 return $process_message;

 } # end function

 # Do rego
 ################################
 # Field Language Generator

 function field_lingo ($field){

  global $lingos;

  $navi_count = 0;

  for ($x=0;$x<count($lingos);$x++) {

      $extension = $lingos[$x][0][0][0][0][0][0];
      $field_lingo = $field.$extension;
      $lingos[$x][1][1][1][1][1][1][1] = $field_lingo;
      
      } // end foreach

  return $lingos;  

 } // end function

 # Field Language Generator
 ################################
 # isEven

 function isEven($number) {

    $isEven = false;

    if (is_numeric ($number)) {

        if ( $number % 2 == 0) $isEven = true;

       } # if

    return $isEven;

 } #

 # isEven
 ################################
 # Get Timezones

 function get_timezones($id){

      $country_code = dlookup("cmn_countries", "two_letter_code","id='".$id."' ");
      $region_code_csv = fopen('region_codes.csv', 'r');

      while (($codes = fgetcsv($region_code_csv)) !== FALSE) {
            //$codes is an array of the csv elements
            #list($country_codes[], $regiona_code[], $country_name[]) = $codes;
            $these_codes[] = $codes;
            } // while

      fclose($region_code_csv);

      $system_timezone = 'Asia/Tokyo';
      date_default_timezone_set($system_timezone);
      $date = date ("Y-m-d G:i:s");

      $tz_pack = "";
      $tz_pack = array();

      if (is_array($these_codes)){

            foreach ($these_codes AS $key => $value){
                     $this_country_code = $value[0];
                     $this_region_code = $value[1];
                     $this_region_name = $value[2];

                     if ($this_country_code == $country_code && $country_code != 'US' && $country_code != 'SG'){
                        #echo "Key: ".$key." Country Code: ".$this_country_code."<BR>";
                        # Some timezones crash the geoip function - reason as yet unknown

                        #if ($this_region_name != "Armed Forces Americas" && $this_region_name != "Armed Forces Europe, Middle East, & Canada" && $this_region_name != "Armed Forces Pacific"){

                        if ($this_country_code != NULL && $this_region_code != NULL){

                           if (geoip_time_zone_by_country_and_region($this_country_code,$this_region_code)){
                              $this_timezone = geoip_time_zone_by_country_and_region($this_country_code,$this_region_code);
                              }

                           }

                        if ($this_timezone != 'America/Argentina'){

                           $tz_date = new DateTime($date, new DateTimeZone($system_timezone) );
                           $tz_date->setTimeZone(new DateTimeZone($this_timezone));
                           $new_date = $tz_date->format('Y-m-d H:i:s');

                           } else {

                           $new_date = $date;

                           }

                        $tz_pack[$this_timezone] = $this_timezone." -> ".$new_date;

                        } // if key

                     } //foreach

          } // is array

      if (!$this_timezone){

         $all_timezones = timezone_identifiers_list();
         $tzi = 0;

         foreach ($all_timezones AS $zone) {

                 $zone = explode('/',$zone);
                 $zonen[$tzi]['continent'] = isset($zone[0]) ? $zone[0] : '';
                 $zonen[$tzi]['city'] = isset($zone[1]) ? $zone[1] : '';
                 $zonen[$tzi]['subcity'] = isset($zone[2]) ? $zone[2] : '';
                 $this_timezone = $zonen[$tzi]['continent']."/".$zonen[$tzi]['city'];
/*
                 if ($this_timezone != 'America/Argentina'){
                    $tz_date = new DateTime($date, new DateTimeZone($system_timezone) );
                    $tz_date->setTimeZone(new DateTimeZone($this_timezone));
                    $new_date = $tz_date->format('Y-m-d H:i:s');
                    } else {
                    $new_date = $date;
                    }
*/
                 #$tz_pack[$this_timezone] = "Timezone: ".$this_timezone." -> ".$new_date;

                 $tz_pack[$this_timezone] = $this_timezone;

                 $tzi++;

                 } // foreach

         } // if no timezone

 return $tz_pack;

 } // end function


 # End get timezone function
 ################################
 # Make content function

 function makecontent (){

  

 } // end makecontent

 #
 ################################
 #

 function makecountry ($val,$portalcode,$BodyDIV,$lingo){

  global $strings;

  $flag_image = dlookup("cmn_countries", "flag_image", "id='".$val."'");
  $name_field = "name_".$lingo;
  $name = dlookup("cmn_countries", "$name_field", "id='".$val."'");
  if ($name == NULL){
     $name = dlookup("cmn_countries", "name", "id='".$val."'");
     }

  if ($flag_image == 'NULL'){
     $flag = "<img src=\"images/blank.gif\" border=\"0\" width=\"16\" alt=\"".$name."\">";
     } else {
     if (substr($flag_image, 0, 4)=='http'){
        $flag = "<img src=\"".$flag_image."\" width=\"16\" border=\"0\" alt=\"".$name."\">";
        } else {
        $flag = "<img src=\"images/flags/".$flag_image."\" width=\"16\" border=\"0\" alt=\"".$name."\">";
        }
     }
  
  $country = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Countries&action=view&value=".$val."&valuetype=Countries');return false\">".$flag." <font=#151B54><B>".$name."</B></font></a>";

 return $country;

 } // end makecontent

 #
 ################################
 #

 function makedivstyles ($params){

  global $portal_info;

  $body_color = $portal_info['portal_body_colour'];
  $border_color = $portal_info['portal_border_colour'];
  $footer_color = $portal_info['portal_footer_colour'];
  $header_color = $portal_info['portal_header_colour'];

  if (is_array($params)){

     $minwidth = $params[0]; 
     $minheight = $params[1];
     $margin_left = $params[2];
     $margin_right = $params[3];
     $padding_left = $params[4];
     $padding_right = $params[5];
     $margin_top = $params[6];
     $margin_bottom = $params[7];
     $padding_top = $params[8];
     $padding_bottom = $params[9];
     $custom_color_back = $params[10];
     $custom_color_border = $params[11];
     $custom_float = $params[12];
     $maxwidth = $params[13];
     $maxheight = $params[14];
     $top_radius = $params[15];
     $bottom_radius = $params[16];
     $overflow = $params[17];

     } else {

     $minwidth = "98%"; 
     $minheight = "25px"; 
     $margin_left = "1%";
     $margin_right = "1%";
     $padding_left = "2px";
     $padding_right = "2px";
     $margin_top = "0px";
     $margin_bottom = "0px";
     $padding_top = "5px";
     $padding_bottom = "2px";

     }

  if ($maxheight != NULL){
     $maxheight = ";max-height:".$maxheight;
     }

  if (!$top_radius){
     $top_radius = "5px";
     }

  if (!$bottom_radius){
     $bottom_radius = "1px";
     }

  if (!$overflow){
     $overflow = "no";
     } else {
     $scrollbar = "::-webkit-scrollbar { width: 3px; height: 3px;}
	::-webkit-scrollbar-button {  background-color: #666; }
	::-webkit-scrollbar-track {  background-color: #999;}
	::-webkit-scrollbar-track-piece { background-color: #ffffff;}
	::-webkit-scrollbar-thumb { height: 50px; background-color: #666; border-radius: 3px;}
	::-webkit-scrollbar-corner { background-color: #999;}}
	::-webkit-resizer { background-color: #666;}";
     }

  $divstyle_blue = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#e6ebf8;min-width:".$minwidth.";min-height:".$minheight.$maxheight.";border:1px solid #d3d3d3;border-top-left-radius:".$top_radius.";border-top-right-radius:".$top_radius.";border-bottom-left-radius:".$bottom_radius.";border-bottom-right-radius:".$bottom_radius.";padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:".$overflow.";";

  $divstyle_grey = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#e6e6e6 50% 50% repeat-x;min-width:".$minwidth.";min-height:".$minheight.$maxheight.";border:1px solid #d3d3d3;border-top-left-radius:".$top_radius.";border-top-right-radius:".$top_radius.";border-bottom-left-radius:".$bottom_radius.";border-bottom-right-radius:".$bottom_radius.";padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:".$overflow.";color:#555555;font-weight: bold;";

  $divstyle_white = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#FFFFFF;min-width:".$minwidth.";min-height:".$minheight.$maxheight.";border:1px solid ".$border_color.";padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:".$overflow.";";

  $divstyle_orange = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#FF8040;min-width:".$minwidth.";min-height:".$minheight.$maxheight.";border:1px solid #d3d3d3;border-top-left-radius:".$top_radius.";border-top-right-radius:".$top_radius.";border-bottom-left-radius:".$bottom_radius.";border-bottom-right-radius:".$bottom_radius.";padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:".$overflow.";";

  $divstyle_orange_light = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#FFE4B5;min-width:".$minwidth.";min-height:".$minheight.$maxheight.";border:1px solid #d3d3d3;border-top-left-radius:".$top_radius.";border-top-right-radius:".$top_radius.";border-bottom-left-radius:".$bottom_radius.";border-bottom-right-radius:".$bottom_radius.";padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:".$overflow.";";

  $divstyle_custom = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:".$custom_float.";background:".$custom_color_back.";min-width:".$minwidth.";max-width:".$maxwidth.";min-height:".$minheight.$maxheight.";border:1px solid ".$custom_color_border.";border-top-left-radius:".$top_radius.";border-top-right-radius:".$top_radius.";border-bottom-left-radius:".$bottom_radius.";border-bottom-right-radius:".$bottom_radius.";padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:".$overflow.";";

  $divstyles = array();
  $divstyles[0] = $divstyle_blue;
  $divstyles[1] = $divstyle_grey;
  $divstyles[2] = $divstyle_white;
  $divstyles[3] = $divstyle_orange;
  $divstyles[4] = $divstyle_orange_light;
  $divstyles[5] = $divstyle_custom;

  return $divstyles;

 }

 #
 ################################

 function makedivs (){

  $date = date("Y@m@d");

  $Do = "dophp";
  $Do = $date."#".$Do;
  $Do = $this->encrypt($Do);

  $Nav = "getjaxphp";
  $Nav = $date."#".$Nav;
  $Nav = $this->encrypt($Nav);

  $Body = "Bodyphp";
  $Body = $date."#".$Body;
  $Body = $this->encrypt($Body);

  $Left = "Leftphp";
  $Left = $date."#".$Left;
  $Left = $this->encrypt($Left);

  $Right = "Rightphp";
  $Right = $date."#".$Right;
  $Right = $this->encrypt($Right);

  $MTV = "TVphp";
  $MTV = $date."#".$MTV;
  $MTV = $this->encrypt($MTV);

  $Mobile = "Mobilephp";
  $Mobile = $date."#".$Mobile;
  $Mobile = $this->encrypt($Mobile);

  $Grid = "Gridphp";
  $Grid = $date."#".$Grid;
  $Grid = $this->encrypt($Grid);

  $DoDIV = substr($Do, 0, 26);
  $NavDIV = substr($Nav, 0, 26);
  $BodyDIV = substr($Body, 0, 26);
  $LeftDIV = substr($Left, 0, 26);
  $RightDIV = substr($Right, 0, 26);
  $MTVDIV = substr($MTV, 0, 26);
  $MOBILEDIV = substr($Mobile, 0, 26);
  $GridDIV = substr($Grid, 0, 26);

  $DoDIV = substr($DoDIV,-8);
  $NavDIV = substr($NavDIV,-8);
  $BodyDIV = substr($BodyDIV,-8);
  $LeftDIV = substr($LeftDIV,-8);
  $RightDIV = substr($RightDIV,-8);
  $MTVDIV = substr($MTVDIV,-8);
  $MOBILEDIV = substr($MOBILEDIV, -8);
  $GridDIV = substr($GridDIV, -8);
  
  $returndiv['do_page'] = $Do;
  $returndiv['left_page'] = $Left;
  $returndiv['body_page'] = $Body;
  $returndiv['right_page'] = $Right;
  $returndiv['mtv_page'] = $MTV;
  $returndiv['mobile_page'] = $Mobile;
  $returndiv['do_div'] = $DoDIV;
  $returndiv['left_div'] = $LeftDIV;
  $returndiv['body_div'] = $BodyDIV;
  $returndiv['nav_div'] = $NavDIV;
  $returndiv['right_div'] = $RightDIV;
  $returndiv['mtv_div'] = $MTVDIV;
  $returndiv['mobile_div'] = $MOBILEDIV;
  $returndiv['grid_div'] = $GridDIV;

  return $returndiv;

 } // end makecontent

 #
 ################################
 #
 
 function makemenu ($do,$action,$val,$valtype,$access){

  global $lingo, $strings,$portal_title,$portal_config;

  $sess_contact_id = $_SESSION['contact_id'];

  $pagesdivs = $this->makedivs ();

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

  $divstyle_params[0] = '98%'; // minwidth
  $divstyle_params[1] = '20px'; // minheight
  $divstyle_params[2] = '1%'; // margin_left
  $divstyle_params[3] = '1%'; // margin_right
  $divstyle_params[4] = '2px'; // padding_left
  $divstyle_params[5] = '2px'; // padding_right
  $divstyle_params[6] = "0px"; //$margin_top
  $divstyle_params[7] = "0px"; //$margin_bottom
  $divstyle_params[8] = "5px"; //$padding_top
  $divstyle_params[9] = "2px"; //$padding_bottom


  $divstyles = $this->makedivstyles($divstyle_params);

  $divstyle_blue = $divstyles[0];
  $divstyle_grey = $divstyles[1];
  $divstyle_white = $divstyles[2];
  $divstyle_orange = $divstyles[3];
  $divstyle_orange_light = $divstyles[4];

  $section = "Body";
  $page = "tr.php";

  $sendvars = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
//  $sendvars = "sv=".$this->encrypt($sendvars);
//  $lingobar = language_selector($section,$lingo,$sendvars,$page,"",$BodyDIV,"");

  $home_sendvars = "Body@".$lingo."@Home@".$action."@@";
  $home_sendvars = $this->encrypt($home_sendvars);

  $account_sendvars = "Body@".$lingo."@Contacts@view@".$sess_contact_id."@id";
  $account_sendvars = $this->encrypt($account_sendvars);

  $about_sendvars = "Body@".$lingo."@About@@@";
  $about_sendvars = $this->encrypt($about_sendvars);
 

  if ($access){

     $logout_sendvars = "Body@".$lingo."@Login@logout@@";
     $logout_sendvars = $this->encrypt($logout_sendvars);

     $loginout = "<li><a href=\"#Account\" onClick=\"loader('$BodyDIV');doBPOSTRequest('$BodyDIV','tr.php', 'pc=".$portalcode."&sv=".$account_sendvars."');return false\">".$strings["Account"]."</a></li>
<li><a href=\"#Logout\" onClick=\"loader('$BodyDIV');doBPOSTRequest('".$BodyDIV."','tr.php', 'pc=".$portalcode."&sv=".$logout_sendvars."');timedRefresh(1000);return false\">".$strings["action_logout"]."</a></li>";

     $have_access = "<P>".$strings["message_have_permission"];

     } else {

     $login_sendvars = "Body@".$lingo."@Login@login@@";
     $login_sendvars = $this->encrypt($login_sendvars);
     $register_sendvars = "Body@".$lingo."@Login@register@@";
     $register_sendvars = $this->encrypt($register_sendvars);

     $loginout = "<li><a href=\"#Login\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','tr.php', 'pc=".$portalcode."&sv=".$login_sendvars."');return false\">".$strings["Login"]."</a></li>
<li><a href=\"#Register\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','tr.php', 'pc=".$portalcode."&sv=".$register_sendvars."');return false\">".$strings["Register"]."</a></li>";

     $have_access = "<P>".$strings["message_have_no_permission"];

     }

  $menu_links = "<div id=\"tabs\">
 <ul>
  <li><a href=\"#Home\" onClick=\"loader('$BodyDIV');doBPOSTRequest('$BodyDIV','tr.php', 'pc=".$portalcode."&sv=".$home_sendvars."');return false\">Home</a></li>
  ".$loginout."
  <li><a href=\"#About\" onClick=\"loader('$BodyDIV');doBPOSTRequest('$BodyDIV','tr.php', 'pc=".$portalcode."&sv=".$about_sendvars."');return false\">About Scalastica</a></li>
 </ul>
</div>";

//  <li>".$lingobar."</li>

/*
  $menu_links = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=&action=&value=&valuetype=');loader('".$LeftDIV."');doLPOSTRequest('".$LeftDIV."','Left.php','pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."');loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Right.php','pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."');return false\"><font size=2>".$strings["home"]."</font></a>";
*/

switch ($portal_config['portalconfig']['glb_domain']){

 case 'realpolitika.org':
 
  $menu_links .= " <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworks&action=About&value=&valuetype=');return false\"><font color=#FF8040 size=2><B>".$strings["SocialNetworks"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Rules&action=&value=&valuetype=');return false\"><font size=2>".$strings["Rules"]."</font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Structure&action=&value=&valuetype=');return false\"><font size=2>".$strings["Structure"]."</font></a> ";

 break;
 case 'sharedeffects.com':

  $menu_links .= " <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworks&action=About&value=&valuetype=');return false\"><font color=#FF8040 size=2><B>".$strings["SocialNetworks"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=BusinessAccounts&action=&value=&valuetype=');return false\"><font size=2><B>".$strings["BusinessAccounts"]."</B></font></a> ";

 break;

 }
/*
 $menu_links .= "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=PrivacyPolicy&action=view&value=&valuetype=PrivacyPolicy');return false\"><font size=2>".$strings["PrivacyPolicy"]."</font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=TermsOfUse&action=view&value=&valuetype=TermsOfUse');return false\"><font size=2>".$strings["TermsOfUse"]."</font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=About&action=&value=&valuetype=');return false\"><font size=2>".$strings["About"]."</font></a>";
*/

// $account_links = $loginout.$have_access;

 $menu[0] = $menu_links;
 $menu[1] = $account_links;

 return $menu;

 }

 #
 ################################
 #
 
 function makeembedd ($do,$action,$val,$valtype,$params){
  
  global $BodyDIV,$sess_contact_id,$lingo,$strings,$portal_title,$portal_config,$hostname;

  $social_network_types = array('Actions','Accounts','BranchBodyDepartmentAgencies','BranchBodyDepartments','Causes','Contacts','Countries','Governments','GovernmentTypes','Journalists','PoliticalParties');

  $messaging_objects = array('Actions','Effects','Events','Causes','Governments','PoliticalParties','PoliticalPartyPolicies');

  $object_name = $params[0];
  $object_status = $params[1];
  
  //echo "DO: ".$do." and VAL: ".$val." and VALTYPE: ".$valtype." and name: ".$object_name."<P>";
   
  if (!$do){
     $do = 'NULL';
     }

  if (!$action){
     $action = 'view';
     }

  if (!$val){
     $val = 'NULL';
     }

  if (!$valtype){
     $valtype = 'NULL';
     }

   if (in_array($do,$social_network_types) && $action != 'list'){

      if ($sess_contact_id != NULL){

         $join_network = "<P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworks&action=join&value=".$val."&valuetype=".$valtype."');return false\"><font size=4 color=#FBB117><B>".$strings["action_join_socialnetwork"]."</B></font></a><P>";
         } else {

         $join_network = "<P><font size=2 color=red><B>".$strings["message_need_to_log-in-socialnetworks"]."</B></font><P>";

         } // end if session

      } else {// end valtype

         $join_network = "<P>";

      }

  //echo "DO: ".$do." and VAL: ".$val." and VALTYPE: ".$valtype." and name: ".$object_name."<P>";
   
  #$embedd = $do."@".$action."@".$val."@".$valtype;
  $embedd = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
  $embedd = $this->encrypt($embedd);
  #$glb_home_url = $portal_config['portalconfig']['glb_home_url'];
  $link = "https://".$hostname."/?pc=".$embedd;
  $embedd_frame = "<iframe src=\"".$hostname."/embedd.php?pc=".$embedd."\" width=\"650\" height=\"650\" scrolling=\"auto\" name=\"".$portal_title."\">If you can see this, your browser can't view IFRAME. Please use this link: <A HREF=\"".$link."\">".$portal_title."</A></iframe>";

  # Use do as it is what the embedd is really for

  #$share = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Messages&action=Share&value=".$val."&valuetype=".$do."');return false\"><B><font size=5>".$strings["action_share_this_page"]."</font></B></a><P>";


  if ($val != 'NULL' && $valtype != 'NULL'){
     # $newsmakers = "<a href=\"#Top\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Newsmakers&action=About&value=".$val."&valuetype=".$do."');return false\"><font color=red size=2><B>".$strings["action_click_here_to_make_news"]."</B></font></a>";
     }

  if ($object_status != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' || $object_status == NULL){

     $facebook = "<iframe src=\"http://www.facebook.com/plugins/like.php?href=".$link."\"
        scrolling=\"no\" frameborder=\"0\"
        style=\"border:none; width:450px; height:80px\"></iframe><BR><img src=images/blank.gif width=10 height=2 border=0>";

     $linkedin_embedd = "<iframe src=\"Linkedin.php?action=embedd&vartype=Share&page_title=".$object_name."&link=".$link."\"
        scrolling=\"no\" frameborder=\"0\"
        style=\"border:none; width:100px; height:80px\"></iframe>";

     $twitter_name = $portal_config['portalconfig']['twitter']['username'];

     $twitter = "<iframe src=\"Twitter.php?action=embedd&name=".$twitter_name."&vartype=Share&page_title=".$object_name."&link=".$link."\"
        scrolling=\"no\" frameborder=\"0\"
        style=\"border:none; width:150px; height:80px\"></iframe>";

     $google = "<iframe src=\"Google.php?action=embedd&vartype=Share&page_title=".$object_name."&link=".$link."\"
        scrolling=\"no\" frameborder=\"0\"
        style=\"border:none; width:200px; height:80px\"></iframe>";

     $social_plugins = "<BR>".$facebook."<BR><img src=images/blank.gif width=10 height=2 border=0>".$linkedin_embedd."<BR><img src=images/blank.gif width=10 height=2 border=0>".$twitter."<BR><img src=images/blank.gif width=10 height=2 border=0>".$google."<BR><img src=images/blank.gif width=10 height=2 border=0>".$newsmakers."<BR><img src=images/blank.gif width=10 height=2 border=0>";

     }

  // linkedIn Users

  $sess_source_id = $_SESSION["source_id"];
  $sess_contact_id = $_SESSION["contact_id"];
  $sess_service_leadsources_id_c = $_SESSION["cmn_leadsources_id_c"];

  if (in_array($do,$messaging_objects) && $sess_source_id != NULL && $sess_service_leadsources_id_c == 'dc35866e-079c-4232-8027-4d972ddd96a3'){ 

     $linkedin_messaging = "<center><B><font size=3>You are connected to your LinkedIn Account!</font></B></center><BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=LinkedIn&action=prepare_message&value=".$val."&valuetype=".$do."');return false\"><B>Click here to invite to this ".$do.".</B></a><BR>";

     } // end if sess source


/*
$jqmodal .= "<style type=\"text/css\">
 .embedder {
	border-top: 1px solid #333;
	border-bottom: 1px dashed #CCC;
	margin: 20px;
	clear: both;
	padding-top: 1.5em;
	color: #222;
	font-size: 1.22em;
}
  </style>";
*/


//  $embedd_url = $glb_home_url."/embedd.php?pc=".$embedd;

//  $embedder .= "<P><div><center><a href=\"#\" class=\"realtrigger\">Share This</a></center></div><P>";

  $embedder .= " <style type=\"text/css\">
    .embedbox{
 margin-left: 1%;
 margin-right: 1%;
 border-radius: 3px;  
 padding-right:2px;
 padding-left:2px;
 border: 1px solid #60729b;
    width: 98%;
    min-height:120px;
    overflow:no;
    background-color: #e6ebf8;
    float:auto;
    }
  </style>";


  #$embedder .= "<div id=\"embeddtoggle\" style=\"".$quickstyle."\"><center><a id=\"embeddtoggler\" href=\"javascript:embeddtoggler('embedddiv','embeddtoggler');\"><font size=2><B>".$strings["action_click_here_to_hide_embedded"]."</B></font></a></center></div><BR><div id=\"embedddiv\"><BR><div class=\"embedbox\"><center><BR>".$share."<BR><B>".$portal_title." ".$strings["LinkExternal"].":</B> <a href=".$link." target=\"Realpolitika\"><B>".$object_name."</B></a><BR>".$social_plugins."<BR>".$linkedin_messaging."<BR>".$join_network."<B>".$strings["action_copy_link_share"]."</B><BR><textarea id=\"embedLink\" name=\"embedLink\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$link."</textarea><BR><B>".$strings["action_copy_code_embedd"]."</B><BR><textarea id=\"embedCode\" name=\"embedCode\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$embedd_frame."</textarea></div></div></center><BR>";

   $embedder .= "<div id=\"embeddtoggle\" style=\"".$quickstyle."\"><center><a id=\"embeddtoggler\" href=\"javascript:embeddtoggler('embedddiv','embeddtoggler');\"><font size=2><B>".$strings["action_click_here_to_hide_embedded"]."</B></font></a></center></div><BR><div id=\"embedddiv\"><BR><div class=\"embedbox\"><center><BR><B>".$strings["LinkExternal"].":</B> <a href=".$link." target=\"".$portal_title."\"><B>".$object_name."</B></a><P><B>".$strings["action_copy_link_share"]."</B><BR><textarea id=\"embedLink\" name=\"embedLink\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$link."</textarea></div></div>";
  
  return $embedder;
  
  } // end make mebedd
 
 # End Realpolitika Code
 ################################ 
 # Make Percentage

 function makepercentage (){

  $dd_pack = "";
  $dd_pack = array();
  $dd_pack["100"] = "100%";
  $dd_pack["99"] = "99%";
  $dd_pack["98"] = "98%";
  $dd_pack["97"] = "97%";
  $dd_pack["96"] = "96%";
  $dd_pack["95"] = "95%";
  $dd_pack["94"] = "94%";
  $dd_pack["93"] = "93%";
  $dd_pack["92"] = "92%";
  $dd_pack["91"] = "91%";
  $dd_pack["90"] = "90%";
  $dd_pack["89"] = "89%";
  $dd_pack["88"] = "88%";
  $dd_pack["87"] = "87%";
  $dd_pack["86"] = "86%";
  $dd_pack["85"] = "85%";
  $dd_pack["84"] = "84%";
  $dd_pack["83"] = "83%";
  $dd_pack["82"] = "82%";
  $dd_pack["81"] = "81%";
  $dd_pack["80"] = "80%";
  $dd_pack["79"] = "79%";
  $dd_pack["78"] = "78%";
  $dd_pack["77"] = "77%";
  $dd_pack["76"] = "76%";
  $dd_pack["75"] = "75%";
  $dd_pack["74"] = "74%";
  $dd_pack["73"] = "73%";
  $dd_pack["72"] = "72%";
  $dd_pack["71"] = "71%";
  $dd_pack["70"] = "70%";
  $dd_pack["69"] = "69%";
  $dd_pack["68"] = "68%";
  $dd_pack["67"] = "67%";
  $dd_pack["66"] = "66%";
  $dd_pack["65"] = "65%";
  $dd_pack["64"] = "64%";
  $dd_pack["63"] = "63%";
  $dd_pack["62"] = "62%";
  $dd_pack["61"] = "61%";
  $dd_pack["60"] = "60%";
  $dd_pack["59"] = "59%";
  $dd_pack["58"] = "58%";
  $dd_pack["57"] = "57%";
  $dd_pack["56"] = "56%";
  $dd_pack["55"] = "55%";
  $dd_pack["54"] = "54%";
  $dd_pack["53"] = "53%";
  $dd_pack["52"] = "52%";
  $dd_pack["51"] = "51%";
  $dd_pack["50"] = "50%";
  $dd_pack["49"] = "49%";
  $dd_pack["48"] = "48%";
  $dd_pack["47"] = "47%";
  $dd_pack["46"] = "46%";
  $dd_pack["45"] = "45%";
  $dd_pack["44"] = "44%";
  $dd_pack["43"] = "43%";
  $dd_pack["42"] = "42%";
  $dd_pack["41"] = "41%";
  $dd_pack["40"] = "40%";
  $dd_pack["39"] = "39%";
  $dd_pack["38"] = "38%";
  $dd_pack["37"] = "37%";
  $dd_pack["36"] = "36%";
  $dd_pack["35"] = "35%";
  $dd_pack["34"] = "34%";
  $dd_pack["33"] = "33%";
  $dd_pack["32"] = "32%";
  $dd_pack["31"] = "31%";
  $dd_pack["30"] = "30%";
  $dd_pack["29"] = "29%";
  $dd_pack["28"] = "28%";
  $dd_pack["27"] = "27%";
  $dd_pack["26"] = "26%";
  $dd_pack["25"] = "25%";
  $dd_pack["24"] = "24%";
  $dd_pack["23"] = "23%";
  $dd_pack["22"] = "22%";
  $dd_pack["21"] = "21%";
  $dd_pack["20"] = "20%";
  $dd_pack["19"] = "19%";
  $dd_pack["18"] = "18%";
  $dd_pack["17"] = "17%";
  $dd_pack["16"] = "16%";
  $dd_pack["15"] = "15%";
  $dd_pack["14"] = "14%";
  $dd_pack["13"] = "13%";
  $dd_pack["12"] = "12%";
  $dd_pack["11"] = "11%";
  $dd_pack["10"] = "10%";
  $dd_pack["9"] = "9%";
  $dd_pack["8"] = "8%";
  $dd_pack["7"] = "7%";
  $dd_pack["6"] = "6%";
  $dd_pack["5"] = "5%";
  $dd_pack["4"] = "4%";
  $dd_pack["3"] = "3%";
  $dd_pack["2"] = "2%";
  $dd_pack["1"] = "1%";
  $dd_pack["0"] = "0%";

 return $dd_pack;

 } // end makepercentage

 # End makepercentage
 ################################ 
 # Make Probability

 function makeprobability (){

  $dd_pack = "";
  $dd_pack = array();
  $dd_pack["1"] = "100%";
  $dd_pack[".99"] = "99%";
  $dd_pack[".98"] = "98%";
  $dd_pack[".97"] = "97%";
  $dd_pack[".96"] = "96%";
  $dd_pack[".95"] = "95%";
  $dd_pack[".94"] = "94%";
  $dd_pack[".93"] = "93%";
  $dd_pack[".92"] = "92%";
  $dd_pack[".91"] = "91%";
  $dd_pack[".90"] = "90%";
  $dd_pack[".89"] = "89%";
  $dd_pack[".88"] = "88%";
  $dd_pack[".87"] = "87%";
  $dd_pack[".86"] = "86%";
  $dd_pack[".85"] = "85%";
  $dd_pack[".84"] = "84%";
  $dd_pack[".83"] = "83%";
  $dd_pack[".82"] = "82%";
  $dd_pack[".81"] = "81%";
  $dd_pack[".80"] = "80%";
  $dd_pack[".79"] = "79%";
  $dd_pack[".78"] = "78%";
  $dd_pack[".77"] = "77%";
  $dd_pack[".76"] = "76%";
  $dd_pack[".75"] = "75%";
  $dd_pack[".74"] = "74%";
  $dd_pack[".73"] = "73%";
  $dd_pack[".72"] = "72%";
  $dd_pack[".71"] = "71%";
  $dd_pack[".70"] = "70%";
  $dd_pack[".69"] = "69%";
  $dd_pack[".68"] = "68%";
  $dd_pack[".67"] = "67%";
  $dd_pack[".66"] = "66%";
  $dd_pack[".65"] = "65%";
  $dd_pack[".64"] = "64%";
  $dd_pack[".63"] = "63%";
  $dd_pack[".62"] = "62%";
  $dd_pack[".61"] = "61%";
  $dd_pack[".60"] = "60%";
  $dd_pack[".59"] = "59%";
  $dd_pack[".58"] = "58%";
  $dd_pack[".57"] = "57%";
  $dd_pack[".56"] = "56%";
  $dd_pack[".55"] = "55%";
  $dd_pack[".54"] = "54%";
  $dd_pack[".53"] = "53%";
  $dd_pack[".52"] = "52%";
  $dd_pack[".51"] = "51%";
  $dd_pack[".50"] = "50%";
  $dd_pack[".49"] = "49%";
  $dd_pack[".48"] = "48%";
  $dd_pack[".47"] = "47%";
  $dd_pack[".46"] = "46%";
  $dd_pack[".45"] = "45%";
  $dd_pack[".44"] = "44%";
  $dd_pack[".43"] = "43%";
  $dd_pack[".42"] = "42%";
  $dd_pack[".41"] = "41%";
  $dd_pack[".40"] = "40%";
  $dd_pack[".39"] = "39%";
  $dd_pack[".38"] = "38%";
  $dd_pack[".37"] = "37%";
  $dd_pack[".36"] = "36%";
  $dd_pack[".35"] = "35%";
  $dd_pack[".34"] = "34%";
  $dd_pack[".33"] = "33%";
  $dd_pack[".32"] = "32%";
  $dd_pack[".31"] = "31%";
  $dd_pack[".30"] = "30%";
  $dd_pack[".29"] = "29%";
  $dd_pack[".28"] = "28%";
  $dd_pack[".27"] = "27%";
  $dd_pack[".26"] = "26%";
  $dd_pack[".25"] = "25%";
  $dd_pack[".24"] = "24%";
  $dd_pack[".23"] = "23%";
  $dd_pack[".22"] = "22%";
  $dd_pack[".21"] = "21%";
  $dd_pack[".20"] = "20%";
  $dd_pack[".19"] = "19%";
  $dd_pack[".18"] = "18%";
  $dd_pack[".17"] = "17%";
  $dd_pack[".16"] = "16%";
  $dd_pack[".15"] = "15%";
  $dd_pack[".14"] = "14%";
  $dd_pack[".13"] = "13%";
  $dd_pack[".12"] = "12%";
  $dd_pack[".11"] = "11%";
  $dd_pack[".10"] = "10%";
  $dd_pack[".09"] = "9%";
  $dd_pack[".08"] = "8%";
  $dd_pack[".07"] = "7%";
  $dd_pack[".06"] = "6%";
  $dd_pack[".05"] = "5%";
  $dd_pack[".04"] = "4%";
  $dd_pack[".03"] = "3%";
  $dd_pack[".02"] = "2%";
  $dd_pack[".01"] = "1%";
  $dd_pack["0"] = "0%";

 return $dd_pack;

 } // end makepositivity

 # End makepositivity
 ################################ 
 # Messaging

 # Messaging
 ################################
 # Make Timeslist

 function timeslist (){

  $dd_pack = "";
  $dd_pack = array();
  $second_cnt = "00";

  for ($hour_cnt=0;$hour_cnt <=23;$hour_cnt++){
      if (strlen($hour_cnt)==1){
         $hour_cnt = "0".$hour_cnt;
         }
      for ($min_cnt=0;$min_cnt <= 59;$min_cnt++){
          if (strlen($min_cnt)==1){
             $min_cnt = "0".$min_cnt;
             }
/*
          for ($second_cnt=0;$second_cnt <= 59;$second_cnt++){
              if (strlen($second_cnt)==1){
                 $second_cnt = "0".$second_cnt;
                 }
*/
              $dd_pack["$hour_cnt:$min_cnt:$second_cnt"] = "$hour_cnt:$min_cnt:$second_cnt";

//              }
          }
      }

 return $dd_pack;

 } // end makepositivity

 # End timeslist
 ################################ 
 # Make Positivity Scale

 function makepositivity (){

  $dd_pack = "";
  $dd_pack = array();
  $dd_pack[-10] = -10;
  $dd_pack[-9] = -9;
  $dd_pack[-8] = -8;
  $dd_pack[-7] = -7;
  $dd_pack[-6] = -6;
  $dd_pack[-5] = -5;
  $dd_pack[-4] = -4;
  $dd_pack[-3] = -3;
  $dd_pack[-2] = -2;
  $dd_pack[-1] = -1;
  $dd_pack[0] = 0;
  $dd_pack[1] = 1;
  $dd_pack[2] = 2;
  $dd_pack[3] = 3;
  $dd_pack[4] = 4;
  $dd_pack[5] = 5;
  $dd_pack[6] = 6;
  $dd_pack[7] = 7;
  $dd_pack[8] = 8;
  $dd_pack[9] = 9;
  $dd_pack[10] = 10;

 return $dd_pack;

 } // end makepositivity

 # End makepositivity
 ################################ 
 # Make Stats

 function makestats ($type_label,$label,$value,$item_count,$positivity,$params){

  global $strings;

 if (is_array($params)){
    $custom_label = $params[0];
    $custom_value = $params[1];
    if ($custom_value != NULL){
       $custom = ", ".$custom_label.": ".$custom_value;
       } else {
       $custom = " ".$custom_label;
       }
    } else {
    $custom = "";
    } 

  if ($type_label != NULL){
     $type_label = " ".$type_label;
     } else {
     $type_label = "";
     }

  $ratewidth = "25px";
  $ratecolor = "#C0C0C0"; //Silver

  if ($item_count == 0 || $item_count == NULL){
     $item_count = 1;
     }

  if ($value > 0){
     $value_average = $value/$item_count;
     if ($value_average <= 1){
        $value_average = ROUND(($value_average*100),0);
        } else {
        $value_average = ROUND($value_average,0);
        } 

     $value_width = $value_average;

     } else {
     $value_average = "0";
     $value_width = "45";
     }

  switch ($positivity){

   case '-10':

    $valuecolor = "#C11B17";
    $font_color = "#FFFFFF";

   break;
   case '-9':

    $valuecolor = "#E42217"; 
    $font_color = "#FFFFFF";

   break;
   case '-8':

    $valuecolor = "#F62817"; 
    $font_color = "#FFFFFF";

   break;
   case '-7':

    $valuecolor = "#FF0000";
    $font_color = "#FFFFFF";

   break;
   case '-6':

    $valuecolor = "#7E2217";
    $font_color = "#000000";

   break;
   case '-5':

    $valuecolor = "#7E3117";
    $font_color = "#000000";

   break;
   case '-4':

    $valuecolor = "#C35617";
    $font_color = "#000000";

   break;
   case '-3':

    $valuecolor = "#F88017";
    $font_color = "#000000";

   break;

   case '-2':

    $valuecolor = "#C34A2C";
    $font_color = "#000000";

   break;
   case '-1':
 
    $valuecolor = "#F88158";
    $font_color = "#000000";

   break;
   case '0':

    $valuecolor = "#F9966B";
    $font_color = "#000000";

   break;
   case '1':

    $valuecolor = "#4CC417";    
    $font_color = "#000000";

   break;
   case '2':

    $valuecolor = "#4E8975";
    $font_color = "#000000";

   break;
   case '3':

    $valuecolor = "#5E767E";
    $font_color = "#000000";

   break;
   case '4':

    $valuecolor = "#A0CFEC";
    $font_color = "#000000";

   break;
   case '5':

    $valuecolor = "#82CAFA";
    $font_color = "#000000";

   break;
   case '6':

    $valuecolor = "#6698FF";
    $font_color = "#000000";

   break;
   case '7':

    $valuecolor = "#488AC7";
    $font_color = "#000000";

   break;
   case '8':

    $valuecolor = "#1569C7";
    $font_color = "#000000";

   break;
   case '9':

    $valuecolor = "#2B60DE";
    $font_color = "#FFFFFF";

   break;
   case '10':

    $valuecolor = "#2554C7"; 
    $font_color = "#FFFFFF";

   break;

  } // end switch for positivity

  if ($positivity > 0){
     $positivity = "+".$positivity;
     }

    $stats = "<tr><td width=400>
                <div style=\"float:left;width:".$value_width."%;border:1px solid #60729b;background-color:".$valuecolor.";\">
                 <div style=\"float:left;padding-top:3px;width:".$ratewidth.";background-color:".$ratecolor.";\"><center><B>".$positivity."</B></center></div>
                 <div style=\"float:left;padding-left:5px;margin-top:3px;\"><font color=".$font_color."><B>".$label.": ".$item_count.$type_label.", ".$strings["Average"].": ".$value_average."%".$custom."</B></font></div>
                </div>
               </td>
              </tr>";
         
  return $stats;

  } // end makestats function

 # Make Stats
 ################################ 
 # Multidimensional Search

 function multidimensional_search($parents, $searched) { 

  if (empty($searched) || empty($parents)) { 
    return false; 
  } 
  
  foreach ($parents as $key => $value) { 
    $exists = true; 

//echo "key: ".$key." Value: ".$value."<BR>";

    foreach ($searched as $skey => $svalue) { 

//echo "skey: ".$skey." sValue: ".$svalue."<BR>";

$zaval = $parents[$key][$skey];

//echo "zaval :".$zaval." = ".$svalue."<BR>";

      $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
    } 
    if($exists){ return $key; } 
  } 
  
  return false; 
} 

 # End Multidimensional Search
 ################################ 
 # Check SLA

    function check_sla ($params){

     global $crm_api_user, $crm_api_pass, $crm_wsdl_url;

     $do = $params[0];
     $valtype = $params[1];
     $val = $params[2];
     $action = $params[3];
     $id = $params[4];
     $sclm_sla_id_c = $params[5];
     $sclm_servicessla_id_c = $params[6];
     $start_date = $params[7];
     $end_date = $params[8];
     $sclm_accountsservices_id_c = $params[9];
     $sclm_accountsservicesslas_id_c = $params[10];
     $checkdate = $params[11];
     $requestor_country = $params[12];
     $requestor_timezone = $params[13];

     // Need to add the proper country for the customer/provider/user - not the system
     if (!$requestor_country){
        $requestor_country = 'JPN';
        }

     if (!$requestor_timezone){
        $requestor_timezone = 'JP/01';
        }

     if (!$checkdate){

        $date = date("Y-m-d G:i:s");

        if ($requestor_country == 'JPN'){
           $now_hour = date("G");
           $now_min = date("i");
           $now_sec = date("s");
           } else {
           $date = new DateTime($date, new DateTimeZone('".$requestor_timezone."'));
           }

        } else {

        $date = date("Y-m-d G:i:s", strtotime($checkdate));

        if ($requestor_country == 'JPN'){
           $now_hour = date("G", strtotime($checkdate));
           $now_min = date("i", strtotime($checkdate));
           $now_sec = date("s", strtotime($checkdate));
           } else {
           $date = new DateTime($date, new DateTimeZone('".$requestor_timezone."'));
           $now_hour = date("G", strtotime($date));
           $now_min = date("i", strtotime($date));
           $now_sec = date("s", strtotime($date));
           }
        }


     $now_time = date("G:i", strtotime($date));

     #$timezone = geoip_time_zone_by_country_and_region($requestor_timezone,$requestor_region);

     $this_country = $requestor_country;

     #echo "<BR>Date: $date & TZ: $requestor_timezone && Now Time: $now_time && Country: $this_country<BR>";

     include ("dates/Dates.php");

     if ($now_holidays == TRUE){
        #echo "<P>Holidays: $now_holidays <P>";
        $now_holidays = "";
        }

/*
      if ($sclm_accountsservicesslas_id_c != NULL){

         $slareq_object_type = "AccountsServicesSLAs";
         $slareq_action = "select";
         $slareq_params[0] = " id='".$sclm_accountsservicesslas_id_c."' ";
         $slareq_params[1] = ""; // select array
         $slareq_params[2] = ""; // group;
         $slareq_params[3] = ""; // order;
         $slareq_params[4] = ""; // limit

         $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

         if (is_array($slareq_items)){

            for ($cnt=0;$cnt < count($slareq_items);$cnt++){

                $id = $slareq_items[$cnt]['id'];
                $sclm_servicessla_id_c = $slareq_items[$cnt]['sclm_servicessla_id_c'];

                } // for 

            } // end if

         } // end if sclm_accountsservicesslas_id_c

      if ($sclm_servicessla_id_c != NULL){

         $slareq_object_type = "ServicesSLA";
         $slareq_action = "select";
         $slareq_params[0] = " id='".$sclm_servicessla_id_c."' ";
         $slareq_params[1] = ""; // select array
         $slareq_params[2] = ""; // group;
         $slareq_params[3] = ""; // order;
         $slareq_params[4] = ""; // limit

         $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

         if (is_array($slareq_items)){

            for ($cnt=0;$cnt < count($slareq_items);$cnt++){

                $id = $slareq_items[$cnt]['id'];
                $sclm_sla_id_c = $slareq_items[$cnt]['sclm_sla_id_c'];

                } // for 

            } // end if

         } // end if sclm_accountsservicesslas_id_c
*/

      if ($sclm_sla_id_c != NULL){

         $slareq_object_type = "SLA";
         $slareq_action = "select";
         $slareq_params[0] = " id='".$sclm_sla_id_c."' ";
         $slareq_params[1] = ""; // select array
         $slareq_params[2] = ""; // group;
         $slareq_params[3] = ""; // order;
         $slareq_params[4] = ""; // limit

         $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

         if (is_array($slareq_items)){

            for ($cnt=0;$cnt < count($slareq_items);$cnt++){

                $id = $slareq_items[$cnt]['id'];
                $performance_metric = $slareq_items[$cnt]['performance_metric'];
                $metric_count = $slareq_items[$cnt]['metric_count'];

                // Check 24x7
                $start_time = $slareq_items[$cnt]['start_time'];
                $end_time = $slareq_items[$cnt]['end_time'];

                #echo "<P>checkdate; ".$checkdate."<P>";

                $day = date("l", strtotime($date));

                if ($start_time != NULL){
                   list($start_hour,$start_minute,$start_second) = explode(":", $start_time);
//                   str_replace(".".$extension, '', $original_name);
                   }

                if ($end_time != NULL){
                   list($end_hour,$end_minute,$end_second) = explode(":", $end_time);
                   }

                $count_type = $slareq_items[$cnt]['count_type'];
                $start_hour = intval($start_hour);

                switch ($count_type){

                 case '3071beef-694f-1232-c936-525935686c09':// Days 
                   //
                 break;
                 case '8cfee2ac-bbb2-9db9-0f61-523fc9329f55':// Hours 

/*
                  if ($start_time < '23:59' && $start_time > $end_time && $end_time < '12:00'){
                     #echo " End Time is morning";
                     #echo "\n\n";
 
                     if ($now_time >= $start_time || $now_time <= $end_time){
                        #echo "Status = 1";
                        $sla_status = 1;
                        } else {
                        #echo "Status = 0";
                        $sla_status = 0;
                        }
   
                     } else {
   
                     #echo " End Time is morning";
   
                     if ($now_time >= $start_time && $now_time <= $end_time){
                        #echo "Status = 1";
                        $sla_status = 1;
                        } else {
                        $sla_status = 0;
                        #echo "Status = 0";
                        }

                     }

                  # Have to assume start time for 24x7 = 17!! Doh!
                  if (($now_holidays == TRUE || $day=='Saturday' || $day=='Sunday') && ($start_time > '17:00')){
                     $sla_status = 1;
                     }

*/

                  // Check hours - assuming 9-17
                  if ($start_hour == 17){

                     if ($now_hour > 17 || $now_hour < 9){
                        $sla_status = 1;

#                        if ($now_holidays == TRUE){
#                           $sla_status = 0;
#                           }

                        } else {
                        $sla_status = 0;

                        if ($now_holidays == TRUE || $day=='Saturday' || $day=='Sunday'){
                           $sla_status = 1;
                           }

                        }    
                      
                     } else {

                     if ($now_hour >= 9 && $now_hour <= 17){
                        $sla_status = 1;

                        if ($now_holidays == TRUE || $day=='Saturday' || $day=='Sunday'){
                           $sla_status = 0;
                           }

                        } else {
                        $sla_status = 0;

#                        if ($now_holidays == TRUE){
#                           $sla_status = 1;
#                           }

                        }
                      
                     } 


                 break;
                 case 'b42d5cd9-19f7-d2ec-ab39-526f95140529':// Months 
                   //
                        $sla_status = 1;

                 break;
                 case '6d9901cd-9516-5fcd-59a4-52593456d9e3':// Percentage
                   //
                 break;
                 case '784310ea-344a-a053-836a-523fc2fcb1f5':// Seconds

                  #$now_time = $now_hour.":".
/*
                  if ($start_time < '23:59' && $start_time > $end_time && $end_time < '12:00'){
                     #echo " End Time is morning";
                     #echo "\n\n";
 
                     if ($now_time >= $start_time || $now_time <= $end_time){
                        #echo "Status = 1";
                  	$sla_status = 1;	  
                        } else {
                        #echo "Status = 0";
                 	$sla_status = 0;
	                }
   
                     } else {
   
                     #echo " End Time is morning";
   
                     if ($now_time >= $start_time && $now_time <= $end_time){
                        #echo "Status = 1";
                  	$sla_status = 1;
                        } else {
                  	$sla_status = 0;	  
                        #echo "Status = 0";
	                }      
   
                     }

                  # Have to assume start time for 24x7 = 17!! Doh!
                  if (($now_holidays == TRUE || $day=='Saturday' || $day=='Sunday') && ($start_time > '17:00')){
                     $sla_status = 1;
                     }
*/

                  // Check hours - assuming 9-17
                  if ($start_hour == 17){

                     if ($now_hour > 17 || $now_hour < 9){

                        $sla_status = 1;


#                        if ($now_holidays == TRUE){
#                           $sla_status = 0;
#                           }

                        } else {
                        $sla_status = 0;

                        if ($now_holidays == TRUE || $day=='Saturday' || $day=='Sunday'){
                           $sla_status = 1;
                           }

                        }    
                      
                     } else {

                     if ($now_hour >= 9 && $now_hour <= 17){
                        $sla_status = 1;

                        if ($now_holidays == TRUE || $day=='Saturday' || $day=='Sunday'){
                           $sla_status = 0;
                           }
 
                        } else {
                        $sla_status = 0;

#                        if ($now_holidays == TRUE){
#                           $sla_status = 1;
#                           }

                        }
                      
                     }


                 break;

                 } // end count type switch

                #echo "<P> Holidays $now_holidays == TRUE || $day=='Saturday' || $day=='Sunday' <P>";

                } // for 

            } // end if

         } // end if sclm_accountsservicesslas_id_c


    $checked_sla[0] = $sla_status;
//    $checked_sla[1] = $sclm_servicessla_id_c;
//    $checked_sla[2] = $sla_status;

    return $checked_sla;

    } // end function
 # 
 ################################ 
 # Array ID Checker

    function variable_id_checker ($check_pack,$id_to_check){

     $exist = false;

     foreach ($check_pack as $zakey => $zavalue){

         if ($zakey == $id_to_check){

            $exist = true;

            } // end if exists

         } // end foreach loop

     return $exist;

     }

 # End Multidimensional Search
 ################################ 
 # Array ID Checker

    function id_to_check ($check_pack,$object,$id_to_check){

     $counter = 0;

     for ($chkcnt=0;$chkcnt < count($check_pack);$chkcnt++){

         $this_id = $check_pack[$chkcnt][$object];

         if ($id_to_check == $this_id){

            $counter++;

            } 

         } // end forloop

     return $counter;

     }

 # End Multidimensional Search
 ################################ 
 # object_to_array

function object_to_array($obj) {

    if(is_object($obj)) $obj = (array) $obj;

    if(is_array($obj)) {

        $new = array();

        foreach($obj as $key => $val) {

            $new[$key] = $this->object_to_array($val);

        }

    }

    else $new = $obj;

    return $new;       

 } # end function 

 # End Multidimensional Search
 ################################ 
 # Quick Forms

 function quickforms ($params){

  

 } # end function quickforms

 # Quick Forms
 ################################ 
 # Funky Return Links

 function object_returner ($valtype,$val){
  
  global $do,$lingo,$strings,$action,$sess_contact_id,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$portal_skin,$portal_title,$standard_statuses_closed,$portal_info;

$pagesdivs = $this->makedivs ();
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

  $divstyle_params[0] = '98%'; // minwidth
  $divstyle_params[1] = '25px'; // minheight
  $divstyle_params[2] = '1%'; // margin_left
  $divstyle_params[3] = '1%'; // margin_right
  $divstyle_params[4] = '2px'; // padding_left
  $divstyle_params[5] = '2px'; // padding_right
  $divstyle_params[6] = "0px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "5px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom

  $divstyles = $this->makedivstyles($divstyle_params);

  $divstyle_blue = $divstyles[0];
  $divstyle_grey = $divstyles[1];
  $divstyle_white = $divstyles[2];
  $divstyle_orange = $divstyles[3];
  $divstyle_orange_light = $divstyles[4];

  $body_color = $portal_info['portal_body_colour'];
  $border_color = $portal_info['portal_border_colour'];
  $footer_color = $portal_info['portal_footer_colour'];
  $header_color = $portal_info['portal_header_colour'];
  $font_color = $portal_info['portal_font_colour'];

  $params = array();

  if ($do == "Comments"){
     $comment_title = $strings["Comments"];
     } else {
     $comment_title = "";
     }

  $completion = 5; // For starters

  switch ($valtype){

   case '':

    $val = "";

    $params[0] ="deleted=0";
    $params[1] = "*";


   break;
   ########################################
   case 'Accounts':
     
    $params[0] = "deleted=0 && account_id_c='".$val."' ";

    $object_name = "name";
    $object_name = dlookup("accounts", "$object_name","id='".$val."'");

    if ($object_name == NULL){

       $object_name = $strings["action_add"];

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["Accounts"].": </B></font><font size=3 color=".$font_color."><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["Accounts"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

       }

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Accounts"].": ".$object_name." ".$comment_title."</B></div>";

   break;
   ########################################
   case 'AccountRelationships':
     
    $params[0] = "deleted=0 && account_id_c='".$val."' ";

    $object_name = "name";
    $object_name = dlookup("sclm_accountrelationships", "$object_name","id='".$val."'");

    if ($object_name == NULL){

       $object_name = $strings["action_add"];

       $object_return = "<font size=3 color=#FBB117><B>".$strings["Accounts"].": </B></font><font size=3><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["AccountRelationships"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2 color=".$font_color.">".$object_name."</font></a>";

       }

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Accounts"].": ".$object_name." ".$comment_title."</B></div>";

   break;
   ########################################
   case 'AccountsServices':
     
    $params[0] = "deleted=0 && sclm_accountsservices_id_c='".$val."' ";

    $object_name = "name";
    $object_name = dlookup("sclm_accountsservices", "$object_name","id='".$val."'");

    if ($object_name == NULL){

       $object_name = $strings["action_add"];

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["CatalogService"].": </B></font><font size=3 color=".$font_color."><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["CatalogService"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

       }

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["CatalogService"].": ".$object_name." ".$comment_title."</B></div>";

   break;
   ########################################
   case 'AccountsServicesSLAs':
     
    $params[0] = "deleted=0 && sclm_accountsservicesslas_id_c='".$val."' ";

    $object_name = "name";
    $object_name = dlookup("sclm_accountsservicesslas", "$object_name","id='".$val."'");

    if ($object_name == NULL){

       $object_name = $strings["action_add"];

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["AccountsServicesSLAs"].": </B></font><font size=3 color=".$font_color."><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["AccountsServicesSLAs"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

       }

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["AccountsServicesSLAs"].": ".$object_name." ".$comment_title."</B></div>";

   break;
   ########################################
   case 'Advisory':
     
//    $params[0] = "deleted=0 && sfx_actions_id_c='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
    if ($val){
       $params[0] = "deleted=0 && sclm_advisory_id_c='".$val."' && cmn_statuses_id_c !='".$standard_statuses_closed."' ";
       } else {
       $params[0] = "deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' ";
       } 
//    $object_name = "title_".$lingo;
    $object_name = "name";
    $object_name = dlookup("sclm_advisory", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_advisory", "$object_name","id='".$val."'");
       }

    if ($object_name == NULL){
       $object_name = $strings["action_add"];

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["Advisory"].": </B></font><font size=3 color=".$font_color."><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=".$font_color."><B>".$strings["Advisory"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

       }

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Advisory"].": ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
      
   break;
   ########################################
   case 'Causes':

    $params[0] = "deleted=0 && cmv_causes_id_c='".$val."'";

    $object_name = "title_".$lingo;
    $object_name = dlookup("cmv_causes", "$object_name ", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("cmv_causes", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Cause"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Cause"]." ".$strings["Comments"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Comments':
     
//    $params[0] = "deleted=0 && accounts_id_c='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";

    $object_string = $strings["Comments"];
    $object_table = "cmv_comments";
    $object_id = "cmv_comments_id_c";

//    if ($do == $valtype){
//       $params[0] = "deleted=0 && id='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
//       } else {
       $params[0] = "deleted=0 && $object_id='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
//       }

//echo "<P>".$params[0]."<P>";

    $object_name = "name";
    $object_name = dlookup("$object_table", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("$object_table", "$object_name","id='".$val."'");
       }

    if ($object_name == NULL){
       $object_name = $strings["action_add"];

       $object_return = "<font size=3 color=".$font_color."><B>".$object_string.": </B></font><font size=3 color=".$font_color."><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=".$font_color."><B>".$object_string.": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

       }

//    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_string.": ".$object_name." ".$comment_title."</B></div>";
    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_string.": ".$object_name."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
      
   break;
   ########################################
   case 'ConfigurationItems':
   case 'EmailFilteringSet':

    switch ($valtype){

     case 'EmailFilteringSet':
      $do = 'ConfigurationItemSets';
     break;
     case 'ConfigurationItems':
      $do = 'ConfigurationItems';
     break;

    } // switch

    $params[0] = "deleted=0 && sclm_configurationitems_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_configurationitems", $object_name, "id='".$val."'");
    $image_url = dlookup("sclm_configurationitems", "image_url", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["ConfigurationItems"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ConfigurationItems"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ConfigurationItems_Common':

    $params[0] = "deleted=0 && cmn_configurationitems_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmn_configurationitems", $object_name, "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["SystemConfigurationItems"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["SystemConfigurationItems"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ConfigurationItemTypes':

    $params[0] = "deleted=0 && sclm_configurationitemtypes_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_configurationitemtypes", $object_name, "id='".$val."'");
    $image_url = dlookup("sclm_configurationitemtypes", "image_url", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["ConfigurationItemTypes"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ConfigurationItemTypes"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ConfigurationItemTypes_Common':

    $params[0] = "deleted=0 && cmn_configurationitemtypes_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmn_configurationitemtypes", $object_name, "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["SystemConfigurationItemTypes"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["SystemConfigurationItemTypes"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Contacts':
   case 'contacts':
     
    $params[0] =" deleted=0 && contact_id_c='".$val."' ";

    // Future: Check to see if friend if sess_contact_id_c not contact_id_c
    $anon_params[0] = $val;
    $show_names = $this->anonymity($anon_params);
    $show_name = $show_names['default_name'];
    $anonymity = $show_names['default_name_anonymity'];
//    $show_name = $show_names['friends_name'];
//    $show_name = $show_names['social_network_name'];

    $object_name = $show_name;

    ############

    $object_return = "<font size=3 color=".$font_color."><B>Member Profile: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Contact"]." ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break;
   ########################################
   case 'ContactsNotifications':
   
    $params[0] = "deleted=0 && sclm_notificationcontacts_id_c='".$val."' ";
     
    $object_name = "name";
    $object_name = dlookup("sclm_notificationcontacts", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("cmv_news", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["NotificationContacts"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["NotificationContacts"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
 
   break; 
   ########################################
   case 'ContactsServicesSLA':
     
    $params[0] =" deleted=0 && sclm_contactsservicessla_id_c='".$val."' ";

    $object_name = "name";
    $object_name = dlookup("sclm_contactsservicessla", $object_name, "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>Resource: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Contact"]." ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break;
   ########################################
   case 'Content':

    $params[0] = " deleted=0 && sclm_content_id_c='".$val."'";

//    $content_title_field = "title_".$lingo;
    $content_title_field = "name";
    $object_name = dlookup("sclm_content", "$content_title_field","id='".$val."'");

    //$params[0] = "deleted=0 && cmv_content_id_c='".$val."' || name like '%".$object_name."%' ";

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_content", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Agency"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$val."&valuetype=Content');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$val."&valuetype=Content');return false\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Content"]." ".$object_name." ".$comment_title."</B></div>";

 //   $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break;
   ########################################
   case 'Countries':

    $params[0] ="deleted=0 && cmn_countries_id_c='".$val."'";

    if ($do == 'Events' && $action == 'view'){
       $val = dlookup("sclm_events", "cmn_countries_id_c", "id='".$val."'");
       }

    $object_name = "name";
    $object_name = dlookup("cmn_countries", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Country"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Countries"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'CountryStates':

    $params[0] ="deleted=0 && cmv_countrystates_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmv_countrystates", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["State"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["State"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Currencies':

    $params[0] ="deleted=0 && cmn_currencies_id_c='".$val."'";

    if ($do == 'ServicesPrices'){
       $object_name = "iso_code";
       } else {
       $object_name = "name";
       }

    $object_name = dlookup("cmn_currencies", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Currency"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Currencies"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Effects':

    $params[0] ="deleted=0 && sclm_events_id_c='".$val."'";

    if ($do == 'Comments' && $action == 'edit'){
       #$val = dlookup("sclm_comments", "sclm_events_id_c", "id='".$val."'");
       }

    $object_name = "name";
    $object_name = dlookup("sclm_events", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Effect"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Effects"]." ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Events':

    $params[0] ="deleted=0 && sclm_events_id_c='".$val."'";

    if ($do == 'Comments' && $action == 'edit'){
       $val = dlookup("sclm_comments", "sclm_events_id_c", "id='".$val."'");
       }

    $object_name = "name";
    $object_name = dlookup("sclm_events", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Event"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Events"]." ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Emails':

    $params[0] =" deleted=0 && sclm_emails_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_emails", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Email"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Emails"]." ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ExternalSources':

    $params[0] ="deleted=0 && sfx_externalsources_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sfx_externalsources", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>External Sources: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>External Sources ".$object_name." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Languages':

    $params[0] ="deleted=0 && cmn_languages_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmn_languages", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Language"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Languages"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case'Messages':
       
//    $params[0] = "deleted=0 && related_object='".$valtype."' && related_object_id='".$val."' ";

    $params[0] ="deleted=0 && sclm_messages_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_messages", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Message"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Messages"]." ".$object_name." ".$comment_title."</B></div>";

/*
    switch ($action){

     case 'Contact':
      $actioner = $strings["action_contact"]." ".$portal_title;
     break;
     case 'request_ownership_transfer':
      $actioner = $strings["RequestOwnershipTransfer"];
     break;
     case 'send_internal_process':
      $actioner = $strings["action_send_private_message"];
     break;
     case 'Share':
      $actioner = $strings["action_Share"]." ".$portal_title;
     break;

    }
*/
     
   break;
   ########################################
   case 'News':
   
    $params[0] = "deleted=0 && cmv_news_id_c='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
     
    $object_name = "title_".$lingo;
    $object_name = dlookup("cmv_news", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("cmv_news", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["News"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["News"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
 
   break; 
   ########################################
   case 'Opportunities':
   
//    $params[0] = "deleted=0 && project_id='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
    $params[0] = " opportunity_id_c='".$val."' ";
     
//    $object_name = "title_".$lingo;
//    $object_name = dlookup("cmv_news", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("opportunities", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Opportunity"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Opportunities"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
 
   break; 
   ########################################
   case 'Projects':
   
//    $params[0] = "deleted=0 && project_id='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
    $params[0] = " project_id_c='".$val."' ";
     
//    $object_name = "title_".$lingo;
//    $object_name = dlookup("cmv_news", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("project", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Project"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Projects"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
 
   break; 
   ########################################
   case 'ProjectTasks':
   
//    $params[0] = "deleted=0 && project_id='".$val."' && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
    $params[0] = " projecttask_id_c='".$val."' ";
     
//    $object_name = "title_".$lingo;
//    $object_name = dlookup("cmv_news", "$object_name","id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("project_task", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["ProjectTask"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ProjectTasks"]." ".$object_name." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
 
   break; 
   ########################################
   case 'Search':

    // If val is array of not just keywords...otherwise text keyword..
    if (is_array($val)){
       $search_title = "";       
       } else {
       $vallength = strlen($val);
       $trimval = substr($val, 0, -1);

       $params[0] = "deleted=0 && (description like '%".$val."%' || name like '%".$val."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";
//       $search_title = $strings["action_search_via_keyword"].": ".$val;
       }

    $object_name = "";
    $object_return = "";
    $object_target = "";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'Security':

    $params[0] = "deleted=0 && sclm_security_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_security", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_security", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Security"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Security"]." ".$object_name." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'Services':

    $params[0] = "deleted=0 && sclm_services_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_services", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_services", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Service"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Services"]." ".$object_name." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'ServicesPrices':

    $params[0] = "deleted=0 && sclm_servicesprices_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_servicesprices", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_servicesprices", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["ServiceSLAPrice"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ServiceSLAPrice"]." ".$object_name." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'ServicesSLA':

    $params[0] = "deleted=0 && sclm_servicessla_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_servicessla", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_servicessla", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Service"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Services"]." ".$object_name." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'ServiceSLARequests':

    $params[0] = "deleted=0 && sclm_serviceslarequests_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_serviceslarequests", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_serviceslarequests", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["ServiceSLARequests"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ServiceSLARequests"]." ".$object_name." ".$comment_title."</B></div>";

    #$object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'SLA':

    $params[0] = "deleted=0 && sclm_sla_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_sla", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_sla", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Service"]." SLA: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Services"]." SLA ".$object_name." ".$comment_title."</B></div>";

    #$object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'SocialNetworking':

    #$sn_parent_id = $val;
    #$sn_par_returner = $this->object_returner ("ConfigurationItems", $sn_parent_id);
    #$sn_cat_id = $sn_par_returner[0];
    #$sn_par_returner = $this->object_returner ("ConfigurationItemTypes", $sn_cat_id);
    #$sn_cat_name = $sn_par_returner[0];

    $params[0] = "deleted=0 && social_networking_id='".$sn_parent_id."' ";

    $object_name = $sn_cat_name;

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["SocialNetwork"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=view&value=".$val."&valuetype=SocialNetworking');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworking&value=".$val."&valuetype=SocialNetworking&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["SocialNetwork"]." ".$object_name." ".$comment_title."</B></div>";

   break; //
   ########################################
   case 'SourceObjects':

    $params[0] = "deleted=0 && sfx_sourceobjects_id_c='".$val."' ";
 
    $object_name = "name";
    $object_name = dlookup("sfx_sourceobjects", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>Source Object: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SourceObjects&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name." </B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SourceObjects&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=3>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." Source Object ".$object_name." ".$comment_title."</B></div>";

   break; //
   ########################################
   case 'SOW':

    $params[0] = " deleted=0 && sclm_sow_id_c='".$val."' ";
 
    $object_name = "name";
    $object_name = dlookup("sclm_sow", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["SOW"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name." </B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." ".$strings["SOW"]." ".$object_name." ".$comment_title."</B></div>";

   break; //
   ########################################
   case 'SOWItems':

    $params[0] = " deleted=0 && sclm_sowitems_id_c='".$val."' ";
 
    $object_name = "name";
    $object_name = dlookup("sclm_sowitems", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["SOWItem"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name." </B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." ".$strings["SOWItems"]." ".$object_name." ".$comment_title."</B></div>";

   break; //
   ########################################
   case 'Ticketing':

    $params[0] = "deleted=0 && sclm_ticketing_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_ticketing", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_ticketing", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["Ticket"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$valtype."&action=reference&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Ticket"]." ".$object_name." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'TicketingActivities':

    $params[0] = "deleted=0 && sclm_ticketingactivities_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_ticketingactivities", "$object_name", "id='".$val."'");

    if ($object_name == NULL){
       $object_name = "name";
       $object_name = dlookup("sclm_ticketingactivities", "$object_name","id='".$val."'");
       }

    $object_return = "<font size=3 color=".$font_color."><B>".$strings["TicketingActivities"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=".$font_color."><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["TicketingActivities"]." ".$object_name." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################

  } // end switch


  $divstyle_params[0] = '98%'; // minwidth
  $divstyle_params[1] = '20px'; // minheight
  $divstyle_params[2] = '1%'; // margin_left
  $divstyle_params[3] = '1%'; // margin_right
  $divstyle_params[4] = '2px'; // padding_left
  $divstyle_params[5] = '2px'; // padding_right
  $divstyle_params[6] = "0px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "5px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom
  $divstyle_params[10] = $header_color." 50% 50% repeat-x"; // custom_color_back
  $divstyle_params[11] = $border_color; // custom_color_border
  $divstyle_params[12] = "left"; // custom_float
  $maxwidth = "98%";
  $divstyle_params[13] = $maxwidth; // maxwidth
  $divstyle_params[14] = ""; // maxheight

  $divstyles = $this->makedivstyles($divstyle_params);

  $divstyle_blue = $divstyles[0];
  $divstyle_grey = $divstyles[1];
  $divstyle_white = $divstyles[2];
  $divstyle_orange = $divstyles[3];
  $divstyle_orange_light = $divstyles[4];
  $divstyle_custom = $divstyles[5];

  if ($object_return != NULL){
     $object_return = "<div style=\"".$divstyle_custom."\"><center>".$object_return."</center></div>";
     } else {
     $object_return = "";
     } 

  $object_completion = $completion/100;

  if ($params[0] == NULL){
     $params[0] = " deleted=0 ";
     }


  $returner[0] = $object_name;
  $returner[1] = $object_return;
  $returner[2] = $object_title;
  $returner[3] = $object_target;
  $returner[4] = $params;
  $returner[5] = $object_completion;
  $returner[6] = $object_voter;
  $returner[7] = $image_url;

  return $returner;

 } // end function

 # End Return Links
 ################################ 
 # Real Container

 function make_container ($container_params){

  $state = $container_params[0]; // container open state
  $width = $container_params[1]; // container_width
  $height = $container_params[2]; // container_height
  $title = $container_params[3]; // container_title
  $treename = $container_params[4]; // container_label
  $portal_info = $container_params[5]; // portal info
  $portal_config = $container_params[6]; // portal config
  $strings = $container_params[7]; // strings
  $lingo = $container_params[8]; // lingo

  $portal_skin = $portal_info['portal_skin'];
  $portal_type = $portal_info['portal_type'];
  $portal_name = $portal_info['portal_name'];
  $portal_logo = $portal_info['portal_logo'];

//echo "portal_skin $portal_skin <P>";
 
  if (!$width){
     $width = .98;
     }

  $menu_font = 3;

  if ($width <= 1){
     $width = $width*100;
     $extension = "%";
     } else {
     $extension = "px";
     }

  $minimiserestore = $strings["action_minimiserestore"];
//  $bodywidth_top = $width."".$extension;
  $bodywidth_top = "98%";
  $bodywidth_inner = $width*0.98;
  $bodywidth_inner = $bodywidth_inner.$extension;

  #echo $bodywidth_inner;

  /*
  $header_color = $portal_config['portalconfig']['portal_header_color'];
  $body_color = $portal_config['portalconfig']['portal_body_color'];
  $footer_color = $portal_config['portalconfig']['portal_footer_color'];
  $border_color = $portal_config['portalconfig']['portal_border_color'];
  $font_color = $portal_config['portalconfig']['portal_font_color'];
  */

  $body_color = $portal_info['portal_body_colour'];
  $border_color = $portal_info['portal_border_colour'];
  $footer_color = $portal_info['portal_footer_colour'];
  $header_color = $portal_info['portal_header_colour'];
  $font_color = $portal_info['portal_font_colour'];

  if (!$state){
     $state = 'closed';
     }

  if ($state == 'open'){
     $navstate = 'navOpen';
     }
  if ($state == 'closed'){
     $navstate = 'navClosed';
     }

  if ($height == NULL){
     $height = "80px";
     }

  $title = "<center><font color=".$font_color." size=4><B>$title</B></font></center>";

//  $header_style = "background: #e6e6e6 url(images/ui-bg_glass_75_e6e6e6_1x400.png) 50% 50% repeat-x;margin-left:font-weight: bold;0px;border-radius:3px;margin-right:2%;margin-top:2px;padding-top:5px;padding-right:0px;padding-left:3px;border:1px solid ".$border_color.";width:100%;min-height:35px;overflow:no;color:".$header_color.";";

  $divstyle_params[0] = '94%'; // minwidth
  $divstyle_params[1] = '25px'; // minheight
  $divstyle_params[2] = '1%'; // margin_left
  $divstyle_params[3] = '1%'; // margin_right
  $divstyle_params[4] = '2px'; // padding_left
  $divstyle_params[5] = '2px'; // padding_right
  $divstyle_params[6] = "5px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "5px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom
  #$divstyle_params[6] = "0px"; // margin_top
  #$divstyle_params[7] = "0px"; // margin_bottom
  #$divstyle_params[8] = "2px"; // padding_top
  #$divstyle_params[9] = "2px"; // padding_bottom
  #$divstyle_params[10] = $portal_header_colour." 50% 50% repeat-x"; // custom_color_back
  #$divstyle_params[11] = $portal_border_colour; // custom_color_border
  $divstyle_params[12] = "left"; // custom_float
  $maxwidth = "95%";
  $divstyle_params[13] = $maxwidth; // maxwidth
  $divstyle_params[14] = ""; // maxheight

  $divstyles = $this->makedivstyles($divstyle_params);

  $divstyle_blue = $divstyles[0];
  $divstyle_grey = $divstyles[1];
  $divstyle_white = $divstyles[2];
  $divstyle_orange = $divstyles[3];
  $divstyle_orange_light = $divstyles[4];
  $divstyle_custom = $divstyles[5];

#  $header_style = "margin-left:1%;font-weight: bold;0px;border-radius:3px;margin-right:1%;margin-top:0px;padding-top:5px;padding-right:0px;padding-left:3px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";max-width:".$maxwidth.";min-height:25px;overflow:no;background-color:".$header_color.";";

  $header_style = "margin-left:1%;font-weight: bold;0px;border-top-right-radius:5px;border-top-left-radius:5px;margin-right:1%;margin-top:0px;padding-top:5px;padding-right:2px;padding-left:2px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";max-width:".$maxwidth.";min-height:25px;overflow:no;background-color:".$header_color.";";


  #$header_style = $divstyle_grey;

  $body_style = "margin-left:1%;border-radius:1px;margin-right:1%;padding-top:0px;padding-right:2px;padding-left:2px;padding-bottom:15px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";max-width:".$maxwidth.";min-height:".$height.";overflow:auto;background-color:".$body_color.";";

#  $footer_style = "margin-left:1%;border-radius:3px;margin-right:1%;padding-right:2px;padding-left:2px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";min-height:10px;max-width:".$maxwidth.";overflow:no;background-color:".$footer_color.";";

  $footer_style = "margin-left:1%;border-bottom-right-radius:5px;border-bottom-left-radius:5px;margin-right:1%;padding-right:2px;padding-left:2px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";min-height:10px;max-width:".$maxwidth.";overflow:no;background-color:".$footer_color.";";

$container_top = <<< CONTAINERTOP

 <div style="$header_style"><font size=$menu_font>$title</font></div>
 <div style="$body_style">
 
CONTAINERTOP;
/*
$container_top_old = <<< CONTAINERTOP_OLD
<div style="margin-left:0px;float: left; background: #fffff; min-width:$bodywidth_top;text-indent:0px;">
<table id="pageLayout" style="width: 100%; min-height: 100%; height: 100%;" border="0" cellpadding="0" cellspacing="0">
 <tbody>
  <tr>
   <td valign="top">
    <div class="screenBody" id="">
     <table id="navArea" cellspacing="0" cellpadding="0" width="100%" border="0" summary="Navigation Items Area">
      <tr>
       <td>
        <div id="navLayout">
         <table border="0" cellspacing="0" cellpadding="0" width="100%" class="$navstate" id="$treename">
          <tr title="$minimiserestore">
           <td>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="navTitle" onClick="return opentree ('$treename');">
             <tr>
              <td class="titleLeft"><img src="css/$portal_skin/images/topleft.gif" border="0" alt=""></td>
              <td class="titleText" width="100%">$title</td>
              <td class="titleHandle"><img src="css/$portal_skin/images/1x1.gif" width="20" height="1" border="0" alt=""></td>
              <td class="titleRight"><img src="css/$portal_skin/images/topright.gif" border="0" alt=""></td>
             </tr>
            </table>
           </td>
          </tr>
          <tr>
           <td>
            <div class="tree">
             <table border="0" cellspacing="0" cellpadding="0" width="$bodywidth_inner">
              <tr> 
               <td>
                <table border="0" cellspacing="0" cellpadding="0" width="$bodywidth_inner" id="dashboard" class="node">
                 <tr>
                  <td class="nodeImage">
                  </td>
                  <td width="$bodywidth_inner"><span class="name">
CONTAINERTOP_OLD;
*/
$container_middle = <<< CONTAINERMIDDLE
</div>
 <div style="$footer_style"><img src=images/blank.gif height=5 width=$bodywidth_inner></div>
</div>
<div style="width:$bodywidth_top;overflow:no;float:left;">
 <div style="$header_style">$title</div>
 <div style="$body_style">
CONTAINERMIDDLE;
/*
$container_middle_old = <<< CONTAINERMIDDLE_OLD
                  </td>
                 </tr>
                </table>            
               </td>
              </tr>
             </table>
            </div>
           </td>
          </tr>
         </table>
        </div>
       </td>
      </tr>
      <tr>
       <td>
        <div id="navLayout">
         <table border="0" cellspacing="0" cellpadding="0" width="100%" class="navClosed" id="$treename">
          <tr title="$minimiserestore">
           <td>
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="navTitle" onClick="return opentree ('$treename');">
             <tr>
              <td class="titleLeft"><img src="css/$portal_skin/images/topleft.gif" border="0" alt=""></td>
              <td class="titleText" width="100%">$title</td>
              <td class="titleHandle"><img src="css/$portal_skin/images/1x1.gif" width="20" height="1" border="0" alt=""></td>
              <td class="titleRight"><img src="css/$portal_skin/images/topright.gif" border="0" alt=""></td>
             </tr>
            </table>
           </td>
          </tr>
          <tr>
           <td>
            <div class="tree">
             <table border="0" cellspacing="0" cellpadding="0" width="$bodywidth_inner">
              <tr>
               <td>
                <table border="0" cellspacing="0" cellpadding="0" width="$bodywidth_inner" id="dashboard" class="node">
                 <tr>
                  <td class="nodeImage">
                  </td>
                  <td width="$bodywidth_inner"><span class="name">
CONTAINERMIDDLE_OLD;
*/
$container_bottom = <<< CONTAINERBOTTOM
</div>
 <div style="$footer_style"><img src=images/blank.gif height=5 width=$bodywidth_inner></div>

CONTAINERBOTTOM;
/*
$container_bottom_old = <<< CONTAINERBOTTOM_OLD
                   </td>
                  </tr>
                 </table>
                </td>
               </tr>
              </table>
             </div>
            </td>
           </tr>
          </table>
         </div>
        </td>
       </tr>
      </tbody>
     </table>
    </div>
   </td>
  </tr>
 </table>
</div>
CONTAINERBOTTOM_OLD;
 
 $container_return[0] = $container_top_old;
 $container_return[1] = $container_middle_old;
 $container_return[2] = $container_bottom_old;
*/

 $container_return[0] = $container_top;
 $container_return[1] = $container_middle;
 $container_return[2] = $container_bottom;

 return $container_return;

 } // end container

 # End Real Container
 ################################ 
 # Build Navi

 function navigator ($count,$do,$action,$val,$valtype,$page,$glb_perpage_items,$thediv,$extraparams){

  global $strings, $lingo,$portalcode;

  if (is_array($extraparams)){
     $sent_extension = $extraparams[0];
     } # if extra params sent

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
  #$divstyle_params[10] = $portal_header_colour." 50% 50% repeat-x"; // custom_color_back
  #$divstyle_params[11] = $portal_border_colour; // custom_color_border
  #$divstyle_params[12] = "left"; // custom_float
  #$divstyle_params[13] = "450"; // maxwidth
  #$divstyle_params[14] = ""; // maxheight

  $divstyles = $this->makedivstyles($divstyle_params);

  $divstyle_blue = $divstyles[0];
  $divstyle_grey = $divstyles[1];
  $divstyle_white = $divstyles[2];
  $divstyle_orange = $divstyles[3];
  $divstyle_orange_light = $divstyles[4];

  $back = $strings["action_back"];
  $next = $strings["action_next"];
  $prev = $strings["action_previous"];
  $last = $strings["action_last"];
  $first = $strings["action_first"];

  if ($page == ""){
     $page = 1;
     }

  if (is_array($action)){
     $thepage = 'getjax.php';
     $key = $action[0];
     $keyvalue = $action[1];
     $sent_action = $action[2];
     $url_extension = "&tbl=".$thediv."&".$key."=".$keyvalue.$sent_extension;
     $posting_start = "getjax('getjax.php?pc=".$portalcode;
     $posting_end = ",'".$thediv."'";
     } else {
     $thepage = 'Body.php';
     $sent_action = $action;
     $posting_start = "doBPOSTRequest('".$thediv."','Body.php', 'pc=".$portalcode.$sent_extension;
     $posting_end = "";
     }

  #echo "<P>action $sent_action posting start $posting_start <P>";

  // Calculates Max Page
  $mpage = floor($count / $glb_perpage_items);
  $rest = $count%$glb_perpage_items;
  if ($rest > 0){
     $mpage++;
     }

  $lfrom = ($page - 1) * $glb_perpage_items;

  if ($mpage != 1 ){
//     $navi = "<img src=images/blank.gif width=".$divstyle_params[0]." height=1><BR><div style=\"".$divstyle_orange."\">";      
     $navi = "<div style=\"".$divstyle_orange."\">";      
     $navi .= "<font color=white size=\"2\"><B>".$strings["action_page"].": <I> ".$page." / ".$mpage." ".$strings["action_page_of"]." ".$count." ".$strings["action_page_of_items"]." </I> </B></font>";

     if ($page > 1){

        if ($thediv == "BLAH"){

           $navi .= "<a href=\"".$thepage."?do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=1".$url_extension."\" onclick=\"return LoadData(this,".$thediv.")\"><font color=white size=2><B>[$first]</B></font></a>";

           } else {

           $navi .= "<a href=\"#\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=1".$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$first]</B></font></a>";

           }

        if ($page > 2){
           $ppage = $page-1;
           $navi .= "<a href=\"#\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$ppage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$prev]</B></font></A>";
           }
        }

#echo $posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$ppage.$url_extension."'".$posting_end.")";

//echo "the page: ".$thepage." thediv: ".$thediv."<BR>";
//echo "'pc=".$portalcode."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$ppage.$url_extension."'";

        $npage = $page+1;
        if ($page < $mpage){
           if ($page < ($mpage-1)){ 
              $navi .= "<a href=\"#\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$npage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$next]</B></font></A>";
              }

        if ($thediv == "BLAH"){

           $navi .= "<a href=\"".$thepage."?do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$mpage.$url_extension."#Grid\" onclick=\"return LoadData(this,".$thediv.")\"><font color=white size=2><B>[$last]</B></font></a>";

           #echo "Last: href=\"".$thepage."?do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$mpage.$url_extension."#Grid\" onclick=\"return LoadData(this,Grid)\"><font color=white size=2><B>[$last]</B></font>";

#           $navi .= "<a href=\"".$thepage."?do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$mpage.$url_extension."\" class=\"moreContent\"><font color=white size=2><B>[$last]</B></font></a>";

           } else {

           $navi .= "<a href=\"#\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$mpage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$last]</B></font></A>";


           #echo "Last: href=\"#Top\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$mpage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$last]</B></font>";


           } 

           }
        $navi .= "</div>";
        }

       $navi .= "\n";

  $navi_returner[0] = $lfrom;
  $navi_returner[1] = $navi;

  return $navi_returner;

 }

 # End Navi
 ################################ 
 # Looper

 function looper ($params){

  global $strings, $crm_api_user, $crm_api_pass, $crm_wsdl_url;

  $do = $params[0];
  $array = $params[1];
  $parent_field = $params[2];

  for ($cnt=0;$cnt < count($array);$cnt++){

      $id = $sow[$cnt]['id'];
      $name = $sow[$cnt]['name'];
      $parent_field_id = $sow[$cnt][parent_field];

      if ($parent_field_id){

         $object_type = $do;
         $action = "select";
         $new_params[0] = " id=$parent_field_id ";
         $new_params[1] = ""; // select array
         $new_params[2] = ""; // group;
         $new_params[3] = ""; // order;
         $new_params[4] = ""; // limit

         $new_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $new_params);

         if (is_array($new_array)){

            $looparams[0] = $do;
            $looparams[1] = $new_array;
            $looparams[2] = $parent_field_id;

            $new_items .= $this->looper ($looparams);
            $name .= $new_items[0];

            } // is array

         } // end if parent

      $namer .= $name."<BR>";

      } // end for

 $returner[0] = $namer;
// $returner[1] = $new_items;

 return $returner;

 } // end function

 # End looper
 ################################ 
 # Emailer

function isKanji($str) {
    return preg_match('/[\x{4E00}-\x{9FBF}]/u', $str) > 0;
}

function isHiragana($str) {
    return preg_match('/[\x{3040}-\x{309F}]/u', $str) > 0;
}

function isKatakana($str) {
    return preg_match('/[\x{30A0}-\x{30FF}]/u', $str) > 0;
}

function isJapanese($str) {
    return $this->isKanji($str) || $this->isHiragana($str) || $this->isKatakana($str);
}

 function check_type($structure) { ## CHECK THE TYPE

  if($structure->type == 1){
     return(true); ## YES THIS IS A MULTI-PART MESSAGE
    } else {
     return(false); ## NO THIS IS NOT A MULTI-PART MESSAGE
    }

  } // end function

# Japanese
######################################
# Day Value

                               function dayvalue ($day){

                                 switch ($day){

                                  case 'Monday':
                                   $dayval = 1;
                                  break;
                                  case 'Tuesday':
                                   $dayval = 2;
                                  break;
                                  case 'Wednesday':
                                   $dayval = 3;
                                  break;
                                  case 'Thursday':
                                   $dayval = 4;
                                  break;
                                  case 'Friday':
                                   $dayval = 5;
                                  break;
                                  case 'Saturday':
                                   $dayval = 6;
                                  break;
                                  case 'Sunday':
                                   $dayval = 7;
                                  break;

                                 } // switch

                                return $dayval;

                               } // end function

# Day Value
######################################
# Get IMAP Email parts

function getpart($mbox,$mid,$p,$partno) {

  mb_language('uni');
  mb_internal_encoding('UTF-8');


    // $partno = '1', '2', '2.1', '2.1.3', etc for multipart, 0 if simple
    global $htmlmsg,$plainmsg,$charset,$attachments;

    // DECODE DATA
    $data = ($partno)?
        imap_fetchbody($mbox,$mid,$partno):  // multipart
        imap_body($mbox,$mid);  // simple
    // Any part may be encoded, even plain text messages, so check everything.
    if ($p->encoding==4)
        $data = quoted_printable_decode($data);
    elseif ($p->encoding==3)
        $data = base64_decode($data);

    // PARAMETERS
    // get all parameters, like charset, filenames of attachments, etc.
    $params = array();
    if ($p->parameters)
        foreach ($p->parameters as $x)
            $params[strtolower($x->attribute)] = $x->value;
    if ($p->dparameters)
        foreach ($p->dparameters as $x)
            $params[strtolower($x->attribute)] = $x->value;

    // ATTACHMENT
    // Any part with a filename is an attachment,
    // so an attached text file (type 0) is not mistaken as the message.
    if ($params['filename'] || $params['name']) {
        // filename may be given as 'Filename' or 'Name' or both
        $filename = ($params['filename'])? $params['filename'] : $params['name'];
        // filename may be encoded, so see imap_mime_header_decode()
        $attachments[$filename] = $data;  // this is a problem if two files have same name
    }

    // TEXT
    if ($p->type==0 && $data) {
        // Messages may be split in different parts because of inline attachments,
        // so append parts together with blank row.
        if (strtolower($p->subtype)=='plain')
            $plainmsg .= trim($data) ."\n\n";
        else
            $htmlmsg .= $data ."<br><br>";
        $charset = $params['charset'];  // assume all parts are same charset
    }

    // EMBEDDED MESSAGE
    // Many bounce notifications embed the original message as type 2,
    // but AOL uses type 1 (multipart), which is not handled here.
    // There are no PHP functions to parse embedded messages,
    // so this just appends the raw source to the main message.
    elseif ($p->type==2 && $data) {
        $plainmsg .= $data."\n\n";
    }

    // SUBPART RECURSION
    if ($p->parts) {
        foreach ($p->parts as $partno0=>$p2)
            getpart($mbox,$mid,$p2,$partno.'.'.($partno0+1));  // 1.2, 1.2.1, etc.
    }
}
###############################

function check_charset ($subject){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

   $charsets = array('iso-8859-6','asmo-708','x-mac-arabic','windows-1256','iso-8859-4','windows-1257','iso-8859-2','latin2','x-mac-ce','windows-1250','euc-cn','gb2312','hz-gb-2312','x-mac-chinesesimp','cp-936','big5','x-mac-chinesetrad','cp-950','cp-932','euc-tw','iso-8859-5','koi8-r','koi8','x-mac-cyrillic','windows-1251','iso-8859-7','x-mac-greek','windows-1253','iso-8859-8','iso-8859-8-i','x-mac-hebrew','windows-1255','x-mac-icelandic','euc-jp','iso-2022-jp','x-mac-japanese','shift_jis','ks_c_5601-1987','ksc5601','euc-kr','iso-2022-kr','x-mac-korean','iso-8859-15','latin9','iso-8859-3','latin3','windows-874','tis-620','iso-8859-9','latin5','x-mac-turkish','windows-1254','utf-7','utf-8','iso-10646-ucs-2','us-ascii','windows-1258','iso-8859-1','latin1','x-mac-roman','macintosh','windows-1252','isiri-3342');

   $subject = strip_tags($subject);
   #echo "Subject: ".$subject."<BR>";
   foreach ($charsets as $checkcharset){

           #echo "Checkcharset: ".$checkcharset."<BR>";
           $uppercheckcharset = strtoupper($checkcharset);
           if ($subject != $this->replacer($checkcharset,"",$subject)){

              #echo "Checkcharset: ".$checkcharset."<BR>";                           
              return $checkcharset;
              break;

              } elseif ($subject != $this->replacer($uppercheckcharset,"",$subject)){// if

              #echo "Upper Checkcharset: ".$uppercheckcharset."<BR>";
              return $uppercheckcharset;
              break;

              } // elseif

           } //foreach

} // end check_charset

/*
function utf16_to_utf8($str) {
    $c0 = ord($str[0]);
    $c1 = ord($str[1]);

    if ($c0 == 0xFE && $c1 == 0xFF) {
        $be = true;
    } else if ($c0 == 0xFF && $c1 == 0xFE) {
        $be = false;
    } else {
        return $str;
    }

    $str = substr($str, 2);
    $len = strlen($str);
    $dec = '';
    for ($i = 0; $i < $len; $i += 2) {
        $c = ($be) ? ord($str[$i]) << 8 | ord($str[$i + 1]) : 
                ord($str[$i + 1]) << 8 | ord($str[$i]);
        if ($c >= 0x0001 && $c <= 0x007F) {
            $dec .= chr($c);
        } else if ($c > 0x07FF) {
            $dec .= chr(0xE0 | (($c >> 12) & 0x0F));
            $dec .= chr(0x80 | (($c >>  6) & 0x3F));
            $dec .= chr(0x80 | (($c >>  0) & 0x3F));
        } else {
            $dec .= chr(0xC0 | (($c >>  6) & 0x1F));
            $dec .= chr(0x80 | (($c >>  0) & 0x3F));
        }
    }
    return $dec;
}
*/

    // get the body of a part of a message according to the
    // string in $part
    function mail_fetchpart($mbox, $msgNo, $part) {
        $parts = $this->mail_fetchparts($mbox, $msgNo);
       
        $partNos = explode(".", $part);
       
        $currentPart = $parts;
        while(list ($key, $val) = each($partNos)) {
            $currentPart = $currentPart[$val];
        }
       
        if ($currentPart != "") return $currentPart;
          else return false;
    }

    // splits a message given in the body if it is
    // a mulitpart mime message and returns the parts,
    // if no parts are found, returns false
    function mail_mimesplit($header, $body) {
        $parts = array();
       
        $PN_EREG_BOUNDARY = "Content-Type:(.*)boundary=\"([^\"]+)\"";

        if (eregi ($PN_EREG_BOUNDARY, $header, $regs)) {
            $boundary = $regs[2];

            $delimiterReg = "([^\r\n]*)$boundary([^\r\n]*)";
            if (eregi ($delimiterReg, $body, $results)) {
                $delimiter = $results[0];
                $parts = explode($delimiter, $body);
                $parts = array_slice ($parts, 1, -1);
            }
           
            return $parts;
        } else {
            return false;
        }   
       
       
    }

    // returns an array with all parts that are
    // subparts of the given part
    // if no subparts are found, return the body of
    // the current part
    function mail_mimesub($part) {
        $i = 1;
        $headDelimiter = "\r\n\r\n";
        $delLength = strlen($headDelimiter);
   
        // get head & body of the current part
        $endOfHead = strpos( $part, $headDelimiter);
        $head = substr($part, 0, $endOfHead);
        $body = substr($part, $endOfHead + $delLength, strlen($part));
       
        // check whether it is a message according to rfc822
        if (stristr($head, "Content-Type: message/rfc822")) {
            $part = substr($part, $endOfHead + $delLength, strlen($part));
            $returnParts[1] = $this->mail_mimesub($part);
            return $returnParts;
        // if no message, get subparts and call function recursively
        } elseif ($subParts = $this->mail_mimesplit($head, $body)) {
            // got more subparts
            while (list ($key, $val) = each($subParts)) {
                $returnParts[$i] = $this->mail_mimesub($val);
                $i++;
            }           
            return $returnParts;
        } else {
            return $body;
        }
    }

    // get an array with the bodies all parts of an email
    // the structure of the array corresponds to the
    // structure that is available with imap_fetchstructure
    function mail_fetchparts($mbox, $msgNo) {
        $parts = array();
        $header = imap_fetchheader($mbox,$msgNo);
        $body = imap_body($mbox,$msgNo, FT_INTERNAL);
       
        #var_dump($body);

        $i = 1;
       
        if ($newParts = $this->mail_mimesplit($header, $body)) {
            while (list ($key, $val) = each($newParts)) {
                $parts[$i] = $this->mail_mimesub($val);
                $i++;               
            }
        } else {
            $parts[$i] = $body;
        }
        return $parts;
       
    }

function w1250_to_utf8($text) {
    // map based on:
    // http://konfiguracja.c0.pl/iso02vscp1250en.html
    // http://konfiguracja.c0.pl/webpl/index_en.html#examp
    // http://www.htmlentities.com/html/entities/
    $map = array(
        chr(0x8A) => chr(0xA9),
        chr(0x8C) => chr(0xA6),
        chr(0x8D) => chr(0xAB),
        chr(0x8E) => chr(0xAE),
        chr(0x8F) => chr(0xAC),
        chr(0x9C) => chr(0xB6),
        chr(0x9D) => chr(0xBB),
        chr(0xA1) => chr(0xB7),
        chr(0xA5) => chr(0xA1),
        chr(0xBC) => chr(0xA5),
        chr(0x9F) => chr(0xBC),
        chr(0xB9) => chr(0xB1),
        chr(0x9A) => chr(0xB9),
        chr(0xBE) => chr(0xB5),
        chr(0x9E) => chr(0xBE),
        chr(0x80) => '&euro;',
        chr(0x82) => '&sbquo;',
        chr(0x84) => '&bdquo;',
        chr(0x85) => '&hellip;',
        chr(0x86) => '&dagger;',
        chr(0x87) => '&Dagger;',
        chr(0x89) => '&permil;',
        chr(0x8B) => '&lsaquo;',
        chr(0x91) => '&lsquo;',
        chr(0x92) => '&rsquo;',
        chr(0x93) => '&ldquo;',
        chr(0x94) => '&rdquo;',
        chr(0x95) => '&bull;',
        chr(0x96) => '&ndash;',
        chr(0x97) => '&mdash;',
        chr(0x99) => '&trade;',
        chr(0x9B) => '&rsquo;',
        chr(0xA6) => '&brvbar;',
        chr(0xA9) => '&copy;',
        chr(0xAB) => '&laquo;',
        chr(0xAE) => '&reg;',
        chr(0xB1) => '&plusmn;',
        chr(0xB5) => '&micro;',
        chr(0xB6) => '&para;',
        chr(0xB7) => '&middot;',
        chr(0xBB) => '&raquo;',
    );
    return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-2'), ENT_QUOTES, 'UTF-8');
}

#
########################################
# Re-iterate parts for email content

function do_parts ($all_parts,$charset,$encode){

  foreach ($all_parts as $partkey => $partvalue){ 

          #echo "Partkey: ".$partkey."<BR>";
          #echo "Partval: ".$partvalue."<BR>";

          if ($partkey == 1){
             # Normal content in the email

             if ($encode == 'base64_decode'){
                $partvalue = base64_decode($partvalue);
                } elseif ($encode == 'quoted_printable_decode'){
                $partvalue = quoted_printable_decode($partvalue);
                }

             $content_encode = mb_detect_encoding($partvalue);

             if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
                $content = mb_convert_encoding($partvalue, "UTF-8", "ISO-2022-JP");
                } 
             } 

          if ($partkey == 2){
             # Normal content in the email
             if (is_array($partvalue)){

                foreach ($partvalue as $partkeytwo => $partvaluetwo){ 
                        #echo "Partkeytwo: ".$partkeytwo."<BR>";
                        $content .= "\n\n#####################\n\nThe below content was attached as an email.\n\n##################### \n\n".base64_decode($partvaluetwo);

                        } // for each

                } // is array

             }  // if key 2

          } // foreach

 return $content;

 } # end function

# end parts
########################################
# Get Email Get Body Attachments

function get_body_attach ($mbox, $mid) {

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  $struct = imap_fetchstructure($mbox, $mid);
  $headers = imap_headerinfo($mbox, $mid);
  $fromparts = $headers->from;

  #var_dump($from);
  $mailbox = $fromparts[0]->mailbox;
  $host = $fromparts[0]->host;
  $from = $mailbox."@".$host;

  echo "<P>INSIDE ATTACH<P>";

  #var_dump($struct);

  $parts = $struct->parts;

  $i = 0;

  #echo "<P>INSIDE ATTACH<P>";

  if (!$parts) { /* Simple message, only 1 piece */

     echo "<P>no parts<P>";

     $attachment = array(); /* No attachments */
     $content = imap_body($mbox, $mid);
     #var_dump($content);
     #echo "Content: ".$content."<P>"; 

     } else { /* Complicated message, multiple parts */

     echo "<P>multiple parts<P>";

     $endwhile = false;

     $stack = array(); /* Stack while parsing message */
     $content = "";    /* Content of message */
     $attachment = array(); /* Attachments */

     while (!$endwhile) {

           if (!$parts[$i]) {

              if (count($stack) > 0) {

                 $parts = $stack[count($stack)-1]["p"];
                 $i     = $stack[count($stack)-1]["i"] + 1;

                 array_pop($stack);

                 } else {

                 $endwhile = true;

                 }

              } //if parts

           if (!$endwhile) {
              /* Create message part first (example '1.2.3') */
              $partstring = "";

              foreach ($stack as $s) {
                      $partstring .= ($s["i"]+1) . ".";
                      }

              $partstring .= ($i+1);

              if (strtoupper($parts[$i]->disposition) == "ATTACHMENT" || strtoupper($parts[$i]->disposition) == "INLINE") {
                 /* Attachment or inline images */
                 $filedata = imap_fetchbody($mbox, $mid, $partstring);
                 if ( $filedata != '' ) {
                    // handles base64 encoding or plain text
                    $decoded_data = base64_decode($filedata);
                    if ( $decoded_data == false ) {
                       #var_dump($parts);
                       #exit;
                       #var_dump($parts[$i]->parameters);
                       #exit;
                       if (is_array($parts[$i]->parameters)){
                          $attachment[] = array("filename" => $parts[$i]->parameters[0]->value, "filedata" => $filedata);
                          }
                       # PHP Fatal error:  Cannot use object of type stdClass as array in
                       # 2015-09-30
                       } else {
                       #$attachment[] = array("filename" => $parts[$i]->parameters[0]->value,"filedata" => $decoded_data);
                       // Saloob added 2014-01-06
                       if (count($parts[$i]->parameters)>0){

                          foreach ($parts[$i]->parameters as $param){

                                  if ((strtoupper($param->attribute)=='NAME') ||(strtoupper($param->attribute)=='FILENAME')){

                                     $filename=$param->value;
                                     
                                     if ($filename != $this->replacer("=?ISO-2022-JP", "", $filename)){
                                        $filename = $this->replacer("=?ISO-2022-JP", "", $filename);

                                        if ($filename != $this->replacer("?B?", "", $filename)){

                                           $filename = $this->replacer("?B?", "", $filename);
                                           $filename = $this->replacer("?=", "", $filename);
                                           $filename = $this->replacer("==", "", $filename);
                                           $fileparts = explode(" ", $filename);

                                           # Loop through the encoded characters and replace any that are found.
                                           if (is_array($fileparts)){

                                              foreach ($fileparts as $filekey => $fileval) {
                                                      
                                                      $filepart = base64_decode($fileval);
                                                      $newfile = $newfile.$filepart;

                                                      } # foreach

                                              } # is array

                                           $filename = mb_convert_encoding($newfile, "UTF-8", "ISO-2022-JP");

                                           } # if 

                                        } else {# if
                                        $filename = $param->value;
                                        } 
                                     
                                     #$attachment[] = array("filename" => $param->value, "filedata" => $decoded_data);
                                     $attachment[] = array("filename" => $filename, "filedata" => $decoded_data);

                                     } // if

                                  } // foreach

                          } // if count

                       } // else decoded_data

                    } // filedata

                 } elseif (strtoupper($parts[$i]->subtype) == "PLAIN" && strtoupper($parts[$i+1]->subtype) != "HTML") {

                 # plain text message
                 $content .= imap_fetchbody($mbox, $mid, $partstring);

                 } elseif ( strtoupper($parts[$i]->subtype) == "HTML" ) {
 
                 # HTML message takes priority
                 $content .= imap_fetchbody($mbox, $mid, $partstring);

                 } // else

              } // endwhile

           if ($parts[$i]->parts) {

              if ( $parts[$i]->subtype != 'RELATED' ) {

                 // a glitch: embedded email message have one additional stack in the structure with subtype 'RELATED', but this stack is not present when using imap_fetchbody() to fetch parts.

                 $stack[] = array("p" => $parts, "i" => $i);

                 } // if

              $parts = $parts[$i]->parts;
              $i = 0;

              } else {

              $i++;

              }

           } /* while */

     } /* complicated message */

  $ret = array();

  if (isset($struct->parts) && is_array($struct->parts) && isset($struct->parts[1])) {

     ##########################
     # Has parts

     #var_dump($struct);

     $part = $struct->parts[1];
     #$subtype = $struct->parts[0]->subtype;
     $subtype = $struct->subtype;

     #echo "Subtype: ".$subtype."<P>";
     #echo "parts: ".$struct."<P>";

     if (is_array($struct->parts[0]->parameters) && (!empty($struct->parts[0]->parameters)) && ($struct->parts[0]->encoding != NULL)){

        $charset = $struct->parts[0]->parameters[0]->value;	
        $encode = $struct->parts[0]->encoding;  

        #echo "<P>A Charset $charset <P>";

        } elseif (is_array($struct->parts[1]->parameters) && ($struct->parts[1]->encoding != NULL)) {

        $charset = $struct->parts[1]->parameters[0]->value;
        $encode = $struct->parts[1]->encoding;  

        #echo "<P>B Charset $charset <P>";

        } elseif (isset($struct->parts[1]->encoding)) {

        # Some emails sent with nothing - broken - hopeless!
        $charset = "default";
        $encode = $struct->parts[1]->encoding;  

        #echo "<P>C Charset $charset <P>";

        }

     if (strtolower($subtype) == "mixed"){

        # Do nothing

        if (strtolower($struct->parts[0]->subtype) ==  "alternative"){

           $charset = $struct->parts[0]->parts[0]->parameters[0]->value;
           $encode = $struct->parts[0]->parts[0]->encoding;

           }

        } elseif (strtolower($subtype)  == "attachment"){

        if (is_array($struct->parts[0]->parts)){
           $charset = $struct->parts[0]->parts[0]->parameters[0]->value;
           $encode = $struct->parts[0]->parts[0]->encoding;        
           } elseif (is_array($struct->parts[0]->parameters)){
           $charset = $struct->parts[0]->parameters[0]->value;
           $encode = $struct->parts[0]->encoding;        
           }

        } elseif (strtolower($subtype)  == "alternative"){

        # Do nothing

        } elseif (strtolower($subtype) == "related"){

        # related and alternative

        if (strtolower($struct->parts[0]->subtype) ==  "alternative"){
           $charset = $struct->parts[0]->parts[0]->parameters[0]->value;
           $encode = $struct->parts[0]->parts[0]->encoding;
           }

        } else {

        # Do nothing

        }

     if ($encode == 0){

        ################
        # ENCODE = 0
        # 7BIT

        $all_parts = $this->mail_fetchparts($mbox, $mid);

        if (!is_array($all_parts) && ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP')){
           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
           } 

        # The function imap_fetchbody() seems uncapable of getting subordinate parts of a message/rfc822-part.
        # Ref: http://php.net/manual/en/function.imap-fetchbody.php - middle by  ulrich at kaldamar dot de

        if (is_array($all_parts)){

           # $content = $this->do_parts ($all_parts,$charset,'quoted_printable_decode');

           foreach ($all_parts as $partkey => $partvalue){ 

                   #echo "Partkey: ".$partkey."<BR>";

                   if ($partkey == 1){
                      # Normal content in the email
                      $partvalue = quoted_printable_decode($partvalue);
                      $content_encode = mb_detect_encoding($partvalue);
                      if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
                         $content = mb_convert_encoding($partvalue, "UTF-8", "ISO-2022-JP");
                         } 
                      } 

                   if ($partkey == 2){
                      # Normal content in the email
                      if (is_array($partvalue)){

                         foreach ($partvalue as $partkeytwo => $partvaluetwo){ 
                                 #echo "Partkeytwo: ".$partkeytwo."<BR>";
                                 $content .= "\n\n#####################\n\nThe below content was attached as an email.\n\n##################### \n\n".base64_decode($partvaluetwo);

                                 } // for each

                         } // is array

                      }  // if key 2

                   } // foreach

           } // is array

        # ENCODE = 0
        ################

        } elseif ($encode == 1){ 

        ################
        # ENCODE = 1
        # 8BIT

        # 2015-01-05 - This was put in due to an HP email mojibake - but it might not work for other charsets
        # http://stackoverflow.com/questions/6843871/do-7bit-and-8bit-encoded-messages-have-to-be-decoded-before-outputting
        # Need to keep an eye on this - maybe no content needs conversion??

        if ($charset == 'utf-8'){
           #Do nothing - seemed to cause mojibake
           } else {
           $content = imap_8bit($content); 
           } 

        # ENCODE = 1
        ################

        } elseif ($encode == 2) { 

        ################
        # ENCODE = 2
        # BINARY

        $content = imap_binary($content); 

        # ENCODE = 2
        ################

        } elseif ($encode == 3) {

        ################
        # ENCODE = 3
        # BASE64

        #$all_parts = $this->mail_fetchparts($mbox, $mid);
        #if (is_array($all_parts)){
        #   $content = $this->do_parts ($all_parts,$charset,'base64_decode');
        #   }

           if ($charset == 'utf-16' || $charset == 'utf-8' || $charset == 'UTF-16' || $charset == 'UTF-8'){

           $baseexceptions = array('WINDOWS-1252','windows-1252','Windows-1252');
           $subject = $headers->subject;
           $elements = imap_mime_header_decode($subject);
         
           for ($i=0; $i<count($elements); $i++) {
               $subjectcharset = $elements[$i]->charset;
               }

           if (in_array($subjectcharset,$baseexceptions)){

              #echo "<P>Subjectcharset: ".$subjectcharset." Subject: ".$subject."<P>";
              mb_internal_encoding("UTF-8");
              #$subject = mb_decode_mimeheader(str_replace('_', ' ', $subject));
              #echo "<P>Subjectcharset: ".$subjectcharset." Subject: ".$subject."<P>";
              #$subject = $this->replacer("=?ISO-2022-JP", "", $subject)              
              #$subject = $this->w1250_to_utf8($subject);
              $base = 'windows-1252';
              $pairs = array('?x-unknown?' => "?$base?");
              $subject = strtr($subject, $pairs);
              $subject = imap_utf8($subject);
              #echo "<P>Subjectcharset: ".$subjectcharset." Subject: ".$subject."<P>";
              #$subject = base64_decode($subject);
              #$subject = iconv($charset, "utf-8", $subject);
              /*
              $tab = array("UTF-8","UTF-16", "Windows-1252");
              $chain = "";
              foreach ($tab as $i)
                  {
                      foreach ($tab as $j)
                      {
                          $chain .= " $i$j ".iconv($i, $j, "$subject")."<BR>";
                      }
                  }
              echo $chain; 
              */
              #echo "<P>Subjectcharset: ".$subjectcharset." Subject: ".$subject."<P>";
              $content = base64_decode($content);
              $content = iconv($charset, "utf-8", $content);

              } else {

              $content = base64_decode($content);

              }

           } elseif ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){

           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");

           } elseif ($charset == 'default' || $charset == 'DEFAULT'){

           $content = $content;

           } else {

           $content = $content;

           }

        } elseif ($encode == 4) {

        ################
        # ENCODE = 4
        # QUOTED_PRINTABLE

        $content = quoted_printable_decode($content);

        if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
           } 

        if ($charset == 'WINDOWS-1252' || $charset == 'windows-1252' || $charset == 'Windows-1252'){

        #$baseexceptions = array('WINDOWS-1252','windows-1252');
        #$subject = $headers->subject;
        #$elements = imap_mime_header_decode($subject);
         
        #for ($i=0; $i<count($elements); $i++) {
        #    $subjectcharset = $elements[$i]->charset;
        #    }

        #if (in_array($charset,$baseexceptions)){

           echo "charset $charset ! <BR>";
 
           mb_internal_encoding("UTF-8");

           #$base = 'windows-1252';
           #$pairs = array('?x-unknown?' => "?$base?");
           #$subject = strtr($subject, $pairs);
           #$subject = imap_utf8($subject);
           #$content = base64_decode($content);
           $content = iconv($charset, "utf-8", $content);

           } # end if windows-1252

        } else {

        ################
        # OTHER

        $content = imap_qprint($content);

        if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
           } 

        }

        # OTHER
        ################

       #$body_encode = mb_detect_encoding($content);

      echo "PARTS: Subtype: ".$subtype." part->encoding MID: ".$mid." Encode :".$encode." && Charset: ".$charset."<BR>";

     # End parts
     #########################

     } else { // if isset

     #########################
     # No parts - simple text

     $encode = $struct->encoding;

     echo "<P>dump struct where no parts 2<P>";

     if (!$struct){
        echo "<P>no struct - try to re-fetch $mbox, $mid <P>";
        $struct = imap_fetchstructure($mbox, $mid);
        }

     #var_dump($struct);
     #$charset = $struct->parts[1]->parts[0]->parameters[0]->value;

     echo "<P>after struct dump no parts 2<P>";

     if (is_array($struct->parameters)){

        $charset = $struct->parameters[0]->value;

        } else {

        $headers = imap_headerinfo($mbox, $mid);
        $subject = $headers->subject;
        $charset = $this->check_charset ($subject);

        } // is array

     if (!$charset){

        $subject = $headers->subject;
        $elements = imap_mime_header_decode($subject);
        
        for ($i=0; $i<count($elements); $i++) {
            $subjectcharset = $elements[$i]->charset;
            }

       #echo "Subjectcharset: ".$subjectcharset."<P>";

       if (strtoupper($subjectcharset) == 'DEFAULT'){

          #$charset = "UTF-8";

          #$content_encode = mb_detect_encoding($content);
          #$subject_encode = mb_detect_encoding($subject);

          #echo "Body Encode: ".$content_encode."<P>";
          #echo "Subject Encode: ".$subject_encode."<P>";

          #if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
          #   $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
          #   }

          } # if default

       } # end if no charset still

     #var_dump($headers);

     #echo "Encode: ".$encode."<P>";

     if ($encode == 0){

        ################
        # ENCODE = 0
        # 7BIT

        $all_parts = $this->mail_fetchparts($mbox, $mid);

        if (!is_array($all_parts) && ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP')){

           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");

           } else {// if chareset

           #echo "Not parts!";
           if (strtoupper($subjectcharset) == 'DEFAULT'){
              #echo "Not parts!";
              $content_encode = mb_detect_encoding($content);
              if (!$content_encode){
                 $content = mb_convert_encoding($content, "UTF-8", "SJIS");
                 $charset = "UTF-8";

                 #$content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
                 #$content_extraction = mb_substr($content, 0, 240);
                 /*
                 $tab = array("UTF-8","UTF-16","Windows-1252", "ISO-8859-1", "ISO-2022-JP", "SJIS");

                 foreach ($tab as $i){ 

                         foreach ($tab as $j){ 

                                 $converted_content = iconv($i, $j, "$content_extraction"); 
                                 echo " $i to $j = ".$converted_content."<BR>";

                                 } # foreach

                         } # foreach 
                 */
                 } # if no encoding at all!

              } # is default

           # Do nothing unless picked by parts below - should already be UTF-8

           } 

        if (is_array($all_parts)){

           #$content = $this->do_parts ($all_parts,$charset,'quoted_printable_decode');

           foreach ($all_parts as $partkey => $partvalue){ 

                   if ($partkey == 1){

                      # Normal content in the email
                      $partvalue = quoted_printable_decode($partvalue);
                      $content_encode = mb_detect_encoding($partvalue);
                      if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
                         $content = mb_convert_encoding($partvalue, "UTF-8", "ISO-2022-JP");
                         } 
                      } 

                   if ($partkey == 2){

                      # Normal content in the email
                      if (is_array($partvalue)){

                         foreach ($partvalue as $partkeytwo => $partvaluetwo){ 

                                 $content .= "\n\n#####################\n\nThe below content was attached as an email.\n\n##################### \n\n".base64_decode($partvaluetwo);

                                 } // for each

                         } // is array

                      }  // if key 2

                   } // foreach

           } // is array

        # ENCODE = 0
        ################

        } elseif ($encode == 1){ 

        ################
        # ENCODE = 1
        # 8BIT

        # 2015-01-05 - This was put in due to an HP email mojibake - but it might not work for other charsets
        # http://stackoverflow.com/questions/6843871/do-7bit-and-8bit-encoded-messages-have-to-be-decoded-before-outputting
        # Need to keep an eye on this - maybe no content needs conversion??

        if ($charset == 'utf-8'){
           #Do nothing - seemed to cause mojibake
           } else {
           $content = imap_8bit($content); 
           } 

        } elseif ($encode == 2) { 

        ################
        # ENCODE = 2
        # BINARY

        $content = imap_binary($content); 


        # ENCODE = 2
        ################

        } elseif ($encode == 3) {

        ################
        # ENCODE = 3
        # BASE64

        if ($charset == 'UTF-8' || $charset == 'utf-8' || $charset == 'UTF-16' || $charset == 'utf-16'){

           # Some emails react badly and need this extra check up
           $baseexceptions = array('WINDOWS-1252','windows-1252');
           $subject = $headers->subject;
           $elements = imap_mime_header_decode($subject);
        
           for ($i=0; $i<count($elements); $i++) {
               $subjectcharset = $elements[$i]->charset;
               echo "Subject Charset :".$subjectcharset."<P>";
               }

           if (in_array($subjectcharset,$baseexceptions)){

              # Special treatment
              $content = base64_decode($content);
              $content = iconv($charset, "utf-8", $content);

              } else {

              # Normal treatment
              $content = base64_decode($content);
              #echo "Content treated normally with base64_decode($content):".$content."<P>";
              echo "Content treated normally with base64_decode(content)<P>";
              }

           } elseif ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){

           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");

           } elseif ($charset == 'default' || $charset == 'DEFAULT'){

           $content = $content;

           } else {

           $content = $content;

           }

        # ENCODE = 3
        ################

        } elseif ($encode == 4) {

        ################
        # ENCODE = 4
        # QUOTED_PRINTABLE

        $content = quoted_printable_decode($content);
        if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
           } 

        # ENCODE = 4
        ################

        } else {

        ################
        # OTHER

        $content = imap_qprint($content);

        if ($charset == 'iso-2022-jp' || $charset == 'ISO-2022-JP'){
           $content = mb_convert_encoding($content, "UTF-8", "ISO-2022-JP");
           } 

        }

        # OTHER
        ################

     echo "NO PARTS: struct->encoding Message ID: ".$mid." Encode :".$encode." && Charset: ".$charset."<BR>";

     # End no parts 
     #########################

     } // else isset parts

   $ret['body'] = $content;
   $ret['attachment'] = $attachment;
   $ret['encoding'] = $encode;
   $ret['charset'] = $charset;
   $ret['subjectcharset'] = $subjectcharset;

   return $ret;

} // end get_body_attach function

###############################

 function get_email ($emailparams){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  #echo "<P>INSIDE IMAP<P>";

  global $charset,$htmlmsg,$plainmsg,$attachments;

  $login = $emailparams[0]; 
  $password = $emailparams[1]; 
  $deletemail =  $emailparams[4];
  $viewmessage = $emailparams[5];
  $keyword = $emailparams[6];
  $searchemail = $emailparams[9];

  if ($deletemail == 0){
     $host = "{".$emailparams[2].":".$emailparams[3]."/imap/ssl}Development/Test-In";
     } elseif ($deletemail == 1) {
     $host = "{".$emailparams[2].":".$emailparams[3]."/imap/ssl}INBOX";
     }

// $host = "{".$emailparams[2].":110/pop3}"; 
// $host = '{imap.gmail.com:993/imap/ssl}INBOX';
// $mbox = imap_open("$host", "$login", "$password");

  if ($viewmessage != NULL){

     $inbox = imap_open($host,$login,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

     $messageparts = $this->get_body_attach($inbox, $viewmessage);
     $message = $messageparts['body'];
     $attachments = $messageparts['attachment'];
     $encoding = $messageparts['encoding'];

     $headers = imap_headerinfo($inbox, $viewmessage);
     $message_id = $headers->message_id;

     $subject = $headers->subject;

     $elements = imap_mime_header_decode($subject);

     for ($i=0; $i<count($elements); $i++) {

         $charset = $elements[$i]->charset;

         } // for

     #echo "<P>Here!<P>";

     if ($charset == 'UTF-8' || $charset == 'utf-8' || $charset == 'default'){

        $subject = imap_utf8($subject);

        } elseif ($charset == 'ISO-2022-JP' || $charset == 'iso-2022-jp') {

        mb_language('Japanese');
        mb_internal_encoding('utf-8');
        $subject = mb_convert_encoding(mb_decode_mimeheader($subject), 'utf-8');

#        } elseif ($charset == 'utf-16' || $charset == 'UTF-16'){
        } elseif ($charset == 'WINDOWS-1252' || $charset == 'windows-1252'){
         echo "<P>CONV WINDOWS-1252 to UTF-8<P>";
         mb_internal_encoding('utf-8'); 
         #$subject = quoted_printable_decode($subject);
         #$subject = base64_decode($subject);
         #$subject = mb_convert_encoding($subject, 'utf-8','WINDOWS-1252');

         $pairs = array('?x-unknown?' => "?$charset?");
         $subject = strtr($subject, $pairs);
         $subject = imap_utf8($subject);
         #$subject = mb_convert_encoding(mb_decode_mimeheader($subject), 'utf-8');

        } elseif ($charset == 'BIG5' || $charset == 'big5'){


        mb_internal_encoding('utf-8');
        $subject = iconv_mime_decode($subject, 0, 'utf-8');

/*        if (ereg("=?.{0,}?[Bb]?",$subject)){
           $arrHead=split("=?.{0,}?[Bb]?",$subject);
           while (list($key,$value)=each($arrHead)){

                 if (ereg("?=",$value)){
                    $arrTemp=split("?=",$value);
                    $arrTemp[0]=base64_decode($arrTemp[0]);
                    $arrHead[$key]=join("",$arrTemp);
                    } # end if

                 } # end while

          $subject=join("",$arrHead);

        } # end double-check
*/
        } else {
         # $subject = quoted_printable_decode($subject);
         mb_internal_encoding('utf-8');
         $subject = mb_convert_encoding($subject, 'utf-8');
        }

     $cnt = 0;

     $output[$cnt]['number'] = $viewmessage;
     $output[$cnt]['Msgno'] = $headers->Msgno;
     $output[$cnt]['id'] = $message_id;
     $output[$cnt]['to'] = $headers->to;
     $output[$cnt]['cc'] = $headers->cc;
     $output[$cnt]['read'] = utf8_decode(imap_utf8($headers->seen));
     $output[$cnt]['subject'] = $subject;
     $output[$cnt]['charset'] = $charset;
     $output[$cnt]['encode'] = $encoding;
     $output[$cnt]['from'] = $headers->from;

     #echo "<P>From: ".$headers->from."<P>";

     $output[$cnt]['date'] = utf8_decode(imap_utf8($headers->date));
     $output[$cnt]['udate'] = utf8_decode(imap_utf8($headers->udate));
     $output[$cnt]['body'] = $message;
     $output[$cnt]['attachments'] = $attachments; // array

     if ($deletemail == 1){
        imap_mail_move($inbox, $viewmessage,'Admin/0 - Auto-Filtered');
        #imap_delete($inbox, $viewmessage);
        }
/*
     if ($deletemail == 0){
        imap_mail_move($inbox, $viewmessage, 'Development/Test-Out', CP_UID);
        imap_delete($inbox, $viewmessage);
        }
*/
     imap_close($inbox);
     
     return $output;

     } // end if ($viewmessage)

  if (!$viewmessage){

     $inbox = imap_open($host,$login,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

     # Collect all emails from inbox - depending on any search

     if ($keyword != NULL){

        echo "Keyword = ".$keyword."<P>";

        $emails = imap_search($inbox,"SUBJECT '".$keyword."'");
        } elseif ($searchemail != NULL){
        $emails = imap_search($inbox,"FROM '".$searchemail."'");
        } else {
        $emails = imap_search($inbox,"ALL");
        } 

// $gmailhostname = '{imap.gmail.com:993/imap/ssl}[Gmail]/All Mail';
//print_r(imap_list($conn, $gmailhostname, '*'));

//     $imap_folder_list = imap_list($inbox,'ALL');
//     $imap_archive_folder_list = imap_list($inbox,'ALL Mail');

     if ($emails) {
	
        /* begin output var */
        $output = '';
	
        /* put the newest emails on top */
        sort($emails);
	
        /* for every email... */
        $cnt = 0;

        foreach ($emails as $email_number) {
		
                $headers = imap_header($inbox,$email_number);
                $message_id = $headers->message_id;
                $messageparts = $this->get_body_attach($inbox, $email_number);

                $message = $messageparts['body'];
                $attachments = $messageparts['attachment'];
                $encoding = $messageparts['encoding'];
                $contentcharset = $messageparts['charset'];
                $subjectcharset = $messageparts['subjectcharset'];

                $subject = $headers->subject;

                $elements = imap_mime_header_decode($subject);
                #var_dump($elements);

                for ($i=0; $i<count($elements); $i++) {
                    $charset = $elements[$i]->charset;
                    }

                # echo "<P>Here!<P>";
                # WINDOWS-1252
                #echo "<P>Charset: $charset<P>";

                if ($charset == 'UTF-8' || $charset == 'utf-8' || $charset == 'default'){

                   $subject = imap_utf8($subject);

                   } elseif ($charset == 'ISO-2022-JP' || $charset == 'iso-2022-jp') {
                   mb_language('Japanese');
                   mb_internal_encoding('utf-8');
                   $subject = mb_convert_encoding(mb_decode_mimeheader($subject), 'utf-8');
#                   } elseif ($charset == 'utf-16' || $charset == 'UTF-16'){
                   } elseif ($charset == 'WINDOWS-1252' || $charset == 'windows-1252'){

                   #echo "<P>Subject: ".$subject." encoded with WINDOWS-1252!!<P>";
                   #$subject = quoted_printable_decode($subject);

                   mb_internal_encoding('utf-8'); 
                   #mb_language('uni');
                   #echo "Strip underbar!";
                   #$subject = mb_decode_mimeheader(str_replace('_', ' ', $subject));
                   #$subject = imap_utf8($subject);
                   #$subject = quoted_printable_decode($subject);
                   #$pairs = array(
                   # '?x-unknown?' => "?$charset?"
                   #);
                   #$stringQP = strtr($subject, $pairs);
                   #$subject = strtr($subject, $pairs);
                   #$subject = imap_utf8($stringQP);
                   $subject = imap_utf8($subject);
                   #$subject = utf8_decode(imap_utf8($subject));
                   #$subject = utf8_decode($subject);
                   #$subject = mb_decode_mimeheader($subject);
                   #$subject = quoted_printable_decode($subject);
/*
                   $tab = array("UTF-8","UTF-16","Windows-1252", "ISO-8859-1");
                   $chain = ""; 
                   foreach ($tab as $i) 
                       { 

                           #$chain .= " to $i = ".mb_convert_encoding(mb_decode_mimeheader($subject), $i)."<BR>"; 
                           foreach ($tab as $j) 

                           { 

                               #$testsubject = iconv($i, $j, "$subject"); 
                               $testsubject = imap_utf8($subject);
                               $chain .= "imap_utf8 ".$testsubject."<BR>"; 
                               $testsubject = mb_decode_mimeheader($testsubject);
                               $chain .= "mb_decode_mimeheader ".$testsubject."<BR>"; 
                               $testsubject = mb_convert_encoding($testsubject, $i, $j);
                               #$testsubject = imap_utf8($testsubject);
                               $chain .= " $i to $j = ".$testsubject."<BR>"; 

                               #$chain .= " $i to $j = ".mb_convert_encoding(mb_decode_mimeheader($subject), 'utf-8');
                           } 
                       } 

                   echo "<P>Chain:<P>".$chain."<P>"; 
*/
                   #$subject = mb_decode_mimeheader($subject);
                   #$subject = quoted_printable_decode($subject);
                   #$subject = iconv($charset, "utf-8", $subject);
                   #$subject = mb_convert_encoding(mb_decode_mimeheader($subject), 'utf-8');
                   #$subject = iconv($charset, "utf-8", $subject);
                   #$subject = iconv("WINDOWS-1252","UTF-8",$subject);
                   } elseif ($charset == 'BIG5' || $charset == 'big5'){

                   #$subject = base64_decode($subject);        
                   #echo "<P>BIG5<P>";

                   mb_internal_encoding('utf-8');
                   $subject = iconv_mime_decode($subject, 0, 'utf-8');
/*
       if (ereg("=?.{0,}?[Bb]?",$subject)){
           $arrHead=split("=?.{0,}?[Bb]?",$subject);
           while (list($key,$value)=each($arrHead)){

                 if (ereg("?=",$value)){
                    $arrTemp=split("?=",$value);
                    $arrTemp[0]=base64_decode($arrTemp[0]);
                    $arrHead[$key]=join("",$arrTemp);
                    } # end if

                 } # end while

          $subject=join("",$arrHead);

        } # end double-check
*/
                   } else {
                   #echo "<P>AND Here!<P>";
                   # if (in_array($from,$baseexceptions)){
                   #$subject = quoted_printable_decode($subject);
                   mb_internal_encoding('utf-8');
                   $subject = mb_convert_encoding($subject, 'utf-8');
                   }

                $output[$cnt]['number'] = $email_number;
                $output[$cnt]['Msgno'] = $headers->Msgno;
                $output[$cnt]['id'] = $message_id;
                $output[$cnt]['cc'] = $headers->cc;
                $output[$cnt]['to'] = $headers->to;
                $output[$cnt]['read'] = $headers->seen;
                $output[$cnt]['subject'] = $subject;
                $output[$cnt]['charset'] = $charset;
                $output[$cnt]['encode'] = $encoding;
                $output[$cnt]['from'] = $headers->from;

                #echo "<P>From: ".$headers->from."<P>";
                #echo "<P>From: ".imap_utf8($headers->from)."<P>";

                $output[$cnt]['date'] = utf8_decode(imap_utf8($headers->date));
                $output[$cnt]['udate'] = utf8_decode(imap_utf8($headers->udate));
                $output[$cnt]['body'] = $message;
                $output[$cnt]['attachments'] = $attachments; // array

                $cnt++;

                if ($deletemail == 1){
                   imap_mail_move($inbox, $email_number,'Admin/0 - Auto-Filtered');
                   #imap_delete($inbox, $email_number);
                   }
/*
                if ($deletemail == 0){
                   imap_mail_move($inbox, $email_number, 'Development/Test-Out', CP_UID);
                   imap_delete($inbox, $email_number);
                   }
*/
                } // end foreach

//        $output[$cnt]['imap_folder_list'] = $imap_folder_list;
//        $output[$cnt]['imap_archive_folder_list'] = $imap_archive_folder_list;

        return $output;

        } // end if ($emails)

     /* close the connection */
     imap_close($inbox);

     } // end (!$viewmessage){

 } // end fetchemail

#
#####################
# Encodes

 function decode7Bit($text) {
  // If there are no spaces on the first line, assume that the body is
  // actually base64-encoded, and decode it.
  $lines = explode("\r\n", $text);
  $first_line_words = explode(' ', $lines[0]);

  if ($first_line_words[0] == $lines[0]) {
     $text = base64_decode($text);
     }

  // Manually convert common encoded characters into their UTF-8 equivalents.
  $characters = array(
    '=20' => ' ', // space.
    '=E2=80=99' => "'", // single quote.
    '=0A' => "\r\n", // line break.
    '=A0' => ' ', // non-breaking space.
    '=C2=A0' => ' ', // non-breaking space.
    "=\r\n" => '', // joined line.
    '=E2=80=A6' => '…', // ellipsis.
    '=E2=80=A2' => '•', // bullet.
  );

  // Loop through the encoded characters and replace any that are found.
  foreach ($characters as $key => $value) {
          $text = str_replace($key, $value, $text);
          }

  return $text;

 } // decode7Bit

function utf16_decode( $str ) {
    if( strlen($str) < 2 ) return $str;
    $bom_be = true;
    $c0 = ord($str{0});
    $c1 = ord($str{1});
    if( $c0 == 0xfe && $c1 == 0xff ) { $str = substr($str,2); }
    elseif( $c0 == 0xff && $c1 == 0xfe ) { $str = substr($str,2); $bom_be = false; }
    $len = strlen($str);
    $newstr = '';
    for($i=0;$i<$len;$i+=2) {
        if( $bom_be ) { $val = ord($str{$i})   << 4; $val += ord($str{$i+1}); }
        else {        $val = ord($str{$i+1}) << 4; $val += ord($str{$i}); }
        $newstr .= ($val == 0x228) ? "\n" : chr($val);
    }
    return $newstr;

 } // utf16_decode

# Encodes
#####################
# Update Items

 function update_items($params){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  global $portal_account_id,$portal_email_server,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c;

  $paritem_id = $params[0];
  $item_value = $params[1];
  $update_type = $params[2];
  $item_description = $params[3];

  if ($paritem_id != NULL){

     # Add some default content from parent
     $ci_object_type = 'ConfigurationItems';
     $ci_action = "select";
     $ci_params[0] = " id='".$paritem_id."' ";
     $ci_params[1] = ""; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
     $ci_params[4] = ""; // limit
  
     $upci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($upci_items)){

        for ($cnfgcnt=0;$cnfgcnt < count($upci_items);$cnfgcnt++){

            #$id = $upci_items[$cnfgcnt]['id'];
            #$name = $upci_items[$cnfgcnt]['name'];
            #$name = "New CI Name";
            #$date_entered = $upci_items[$cnfgcnt]['date_entered'];
            #$date_modified = $upci_items[$cnfgcnt]['date_modified'];
            #$modified_user_id = $upci_items[$cnfgcnt]['modified_user_id'];
            #$created_by = $upci_items[$cnfgcnt]['created_by'];
            #$description = $upci_items[$cnfgcnt]['description'];
            #$description = "New CI Description";
            #$deleted = $upci_items[$cnfgcnt]['deleted'];
            $assigned_user_id = $upci_items[$cnfgcnt]['assigned_user_id'];
            $child_id = $upci_items[$cnfgcnt]['child_id'];
            $account_id_c = $upci_items[$cnfgcnt]['account_id_c'];
            $contact_id_c = $upci_items[$cnfgcnt]['contact_id_c'];
            #$ci_data_type = $upci_items[$cnfgcnt]['ci_data_type'];
            $image_url = $upci_items[$cnfgcnt]['image_url'];
            $cmn_statuses_id_c = $upci_items[$cnfgcnt]['cmn_statuses_id_c'];
            $project_id_c = $upci_items[$cnfgcnt]['project_id_c'];
            $projecttask_id_c = $upci_items[$cnfgcnt]['projecttask_id_c'];
            $sclm_sow_id_c = $upci_items[$cnfgcnt]['sclm_sow_id_c'];
            $sclm_sowitems_id_c = $upci_items[$cnfgcnt]['sclm_sowitems_id_c'];
      
            } // end for

        } // is array

     } // end if paritem

  switch ($update_type){

   case 'live_status':
    $update_ci['423752fe-a632-9b4d-8c3b-52ccc968fe59']['type_id'] = '423752fe-a632-9b4d-8c3b-52ccc968fe59';
    $update_ci['423752fe-a632-9b4d-8c3b-52ccc968fe59']['paritem_id'] = $paritem_id;
    $update_ci['423752fe-a632-9b4d-8c3b-52ccc968fe59']['item_value'] = $item_value;
    $update_ci['423752fe-a632-9b4d-8c3b-52ccc968fe59']['item_description'] = $item_value;
   break;
   case 'maintenance_status':
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['type_id'] = '2864a518-19f4-ddfa-366e-52ccd012c28b';
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['paritem_id'] = $paritem_id;
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['item_value'] = $item_value;
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['item_description'] = $item_value;
   break;
   case 'frequency_timestamp':
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['type_id'] = '7a454f0d-3d12-7bc5-7607-52defc746103';
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['paritem_id'] = $paritem_id;
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['item_value'] = $item_value;
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['item_description'] = $item_description;
   break;
   case 'frequency_count':
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['type_id'] = 'c3891c31-9198-476d-0a8a-52df0e00c722';
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['paritem_id'] = $paritem_id;
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['item_value'] = $item_value;
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['item_description'] = $item_value;
   break;
   case 'maintenance_window':

    $maintenance_startdatetime = $params[3];
    $maintenance_enddatetime = $params[4];

    #echo "<P>Entered Maintenance Update<P>";

    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['type_id'] = '787ab970-8f2a-efed-3aca-52ecd566b16b';
    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['paritem_id'] = $paritem_id;
    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['item_value'] = $maintenance_startdatetime;
    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['item_description'] = $maintenance_startdatetime;

    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['type_id'] = 'b38181b6-eb59-0bc3-bad3-52ecd65163f5';
    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['paritem_id'] = $paritem_id;
    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['item_value'] = $maintenance_enddatetime;
    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['item_description'] = $maintenance_enddatetime;

   break;

   }

  # Get the ID of any record that already exists for this CI Type
  # Use that ID and update the record with new content

  if ($paritem_id != NULL && is_array($update_ci)){

     foreach ($update_ci as $ci_info){
 
             $paritem_id = $ci_info['paritem_id'];
             $ci_type = $ci_info['type_id'];
             $item_value = $ci_info['item_value'];
             $item_description = $ci_info['item_description'];

             $update_object_type = 'ConfigurationItems';
             $update_action = "select";
             $update_params[0] = " sclm_configurationitems_id_c='".$paritem_id."' && sclm_configurationitemtypes_id_c='".$ci_type."'   ";
             $update_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name"; // select array
             $update_params[2] = ""; // group;
             $update_params[3] = ""; // order;
             $update_params[4] = ""; // limit
  
             $update_item_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $update_object_type, $update_action, $update_params);

             $ci_id = "";

             if (is_array($update_item_list)){

                for ($update_cnt=0;$update_cnt < count($update_item_list);$update_cnt++){

                    $ci_id = $update_item_list[$update_cnt]['id']; // The live status

                    #echo "Value:".$item_value." ID: ".$ci_id."<BR>";

                    } // end for

                } // end if array

             if (!$item_value){
                $item_value = 0;
                }

             $update_process_object_type = "ConfigurationItems";
             $update_process_action = "update";
             $update_process_params = array();
             $update_process_params[] = array('name'=>'id','value' => $ci_id);
             $update_process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $paritem_id);
             $update_process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $ci_type);
             $update_process_params[] = array('name'=>'name','value' => $item_value);
             #$update_process_params[] = array('name'=>'description','value' => $item_value);
             $update_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
             $update_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $update_process_params[] = array('name'=>'description','value' => $item_description);
             $update_process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
             $update_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
             #$update_process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
             $update_process_params[] = array('name'=>'image_url','value' => $image_url);
             $update_process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
             $update_process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
             $update_process_params[] = array('name'=>'sclm_sow_id_c','value' => $sclm_sow_id_c);
             $update_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
             $update_process_params[] = array('name'=>'enabled','value' => $enabled);

             $update_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $update_process_object_type, $update_process_action, $update_process_params);

             if ($update_result['id'] != NULL){
                $update_id = $update_result['id'];
                #echo "ID: ".$update_id."<BR>";
                }

             } // end foreach

     } // end if item and type

  return $update_id;

 } // end function update_items

# End Update Items
#####################
# mb_str_replace

	function mb_str_replace($search, $replace, $subject, &$count = 0) {
		if (!is_array($subject)) {
			// Normalize $search and $replace so they are both arrays of the same length
			$searches = is_array($search) ? array_values($search) : array($search);
			$replacements = is_array($replace) ? array_values($replace) : array($replace);
			$replacements = array_pad($replacements, count($searches), '');
 
			foreach ($searches as $key => $search) {
				$parts = mb_split(preg_quote($search), $subject);
				$count += count($parts) - 1;
				$subject = implode($replacements[$key], $parts);
			}
		} else {
			// Call mb_str_replace for each subject in array, recursively
			foreach ($subject as $key => $value) {
				$subject[$key] = mb_str_replace($search, $replace, $value, $count);
			}
		}
 
		return $subject;
	}

# End mb_str_replace

function replacer ($checkstring,$replacestring,$originalstring){

 if ($this->isJapanese($originalstring)){
    #$convertstr = mb_convert_encoding($filter_string,'UTF-8','AUTO');
    #$convertsub = mb_convert_encoding($subject,'UTF-8','AUTO');
    #echo "convert string = $convertstr, convert subject = $convertsub <P>";
    #$result = str_replace($checkstring,$replacestring,$subject);
#    $result = implode($replacestring,mb_split($checkstring, $originalstring));
    $result = str_replace($checkstring,$replacestring,$originalstring);
    #echo "check_subject = $check_subject <P>";
    } else {
    $result = str_replace($checkstring,$replacestring,$originalstring);
    }

 return $result;

 }

# End mbstring
######################################################
# Make Log

function funky_logger ($logparams){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

        $log_location = $logparams[0];
        $log_name = $logparams[1];
        $log_content = $logparams[2];

        $logfile = $log_location."/".$log_name.".log";

        $logdate = date ("Y-m-d G:i:s");

//	$pwd = exec ("pwd");
//        $logfile = $pwd."/logs/Sca.log";

        ##############################
        # Check log size

        $size = filesize($logfile);

	if ($size>500000){
           $archdate = str_replace(" ", "_", $logdate);
           $archdate = str_replace(":", "-", $archdate);
	   $archive = $log_location."/".$log_name."_".$archdate."_archive.log";
           copy($logfile, $archive);
           unlink($logfile);
	}

        #
        ##############################

        $funkylog = "[".$log_name." LOG :".$logdate."] ".$log_content."\n";
	$fh = fopen ($logfile, 'a');
        fwrite ($fh, $funkylog);
        fclose ($fh);
	}

# End Logger
#################################
# 
 function move_emails ($moveparams){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  global $divstyle_orange;

  $portal_imap_port = $moveparams[0];
  $portal_imap_server = $moveparams[2];
  $from_folder = $moveparams[3];
  $to_folder = $moveparams[4];
  $email_id = $moveparams[5];
  $portal_email = $moveparams[6];
  $portal_email_password = $moveparams[7];
  $report = $moveparams[8];
  $create_report = $moveparams[9];

  $filteredhost = "{".$portal_imap_server.":".$portal_imap_port."/imap/ssl}".$from_folder;

  $filteredinbox = imap_open($filteredhost,$portal_email,$portal_email_password) or die('Cannot connect to Gmail: ' . imap_last_error());

  $filteredemails = imap_search($filteredinbox,'ALL');

  if ($filteredemails) {

     $mailcnt = 0;

     if ($create_report == TRUE){
        $report .= "<div style=\"".$divstyle_orange."\"><center><B>Check to move Filtered (Ticket Created) Email to ".$to_folder."</B></center></div>";
        }

     foreach ($filteredemails as $filteredemail_number) {

             $headers = imap_header($filteredinbox,$filteredemail_number);
             $thisemail_id = $headers->message_id;
             $thisemail_id = $this->replacer("<", "", $thisemail_id);
             $thisemail_id = $this->replacer(">", "", $thisemail_id);
 
             if ($thisemail_id == $email_id){

                if ($create_report == TRUE){
                   $report .= $debugger." Ticket was created from email ID (".$thisemail_id.")<BR>";
                   }

                imap_mail_move($filteredinbox, $filteredemail_number,$to_folder);
                #imap_delete($filteredinbox, $filteredemail_number);

                } // if msgno

             } // foreach

     imap_close($filteredinbox);

     } // if filteredemails

 return $report;

 } // end function

# End move emails function 
#################################
# Do Bound Elements

 function bounding_elements ($be_params){

  # Set some defaults

  date_default_timezone_set('Asia/Tokyo');

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  if (!function_exists('get_param')){
     include ("common.php");
     }

  global $portal_account_id,$portal_email_server,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c;

  # End default setting

  # Get sent params

  $binder_ci = $be_params[0]; // filterbit_id
  $binder_tci = $be_params[1]; // element_binder
  $ci_array = $be_params[2]; // filterbits
  $be_type = $be_params[3]; // string - 98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68
  $senddiv = $be_params[4]; // FILTER
  $granpar_ci = $be_params[5]; // filter_id

  # First, get any bound elements
  $elembind_object_type = "ConfigurationItems";
  $elembind_action = "select";
  $elembind_params[0] = " sclm_configurationitems_id_c='".$binder_ci."' && sclm_configurationitemtypes_id_c='".$binder_tci."' ";
  $elembind_params[1] = "id,enabled,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select
  $elembind_params[2] = ""; // group;
  $elembind_params[3] = ""; // order;
  $elembind_params[4] = ""; // limit
 
  $elembinders = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $elembind_object_type, $elembind_action, $elembind_params);

  $bound_elements_show = "<B>Bound Elements:</B><BR>";

  if (is_array($elembinders)){

     # The count will tell us if more than 1 and can then have AND/OR
     $eb_count = count($elembinders);

     if ($eb_count == 0 || $eb_count == 1){

        } elseif ($eb_count > 1){

        # More than 1, can provide condition selections, default is AND
        # Search for bound conditions for the CI/Instance (as parent CI), CIT=condition

        $condition = '36e996a8-4896-92cf-e920-54b023893469'; // defult for now

        # No need for conditions
        switch ($condition){

         case '36e996a8-4896-92cf-e920-54b023893469': // AND
  
          $condition = "<P><font color=blue size=2><B>AND</B></font><P>";

         break;

        } // end condition switch


        $change_jyunban_down = "<img src=images/icons/ArrowDownBlueWhite.gif width=12 border=0 alt='Move Down'>";
        $change_jyunban_up = "<img src=images/icons/ArrowUpBlueWhite.gif width=12 border=0 alt='Move Up'>";

        }

     for ($cnteb=0;$cnteb < count($elembinders);$cnteb++){

         $bound_element_carrier_id = $elembinders[$cnteb]['id']; // the carrier CI ID
         $bound_element_ci_id = $elembinders[$cnteb]['name']; // the actual element CI ID (string)
         $bound_element_enabled = $elembinders[$cnteb]['enabled'];
         if ($bound_element_enabled==1){
            $enabled = "<img src=images/icons/button_ok.png border=0 width=12 alt='Enabled'>";
            } else {
            $enabled = "<img src=images/icons/button_cancel.png border=0 width=12 alt='Disabled'>";
            } 

         if ($bound_element_ci_id != NULL){ 
            $bound_element_returner = $this->object_returner ("ConfigurationItems", $bound_element_ci_id);
            $bound_element_name = $bound_element_returner[0]." <img src=images/icons/pencil.png border=0 width=12 alt='Click to edit'>";
            } else {
            $bound_element_name = "Undefined!";
            }

         if ($cnteb == 0){
            $show_junban = " ".$change_jyunban_down."<BR>";
            } elseif (count($elembinders)-1 == $cnteb) {
            $show_junban = " ".$change_jyunban_up."<BR>";
            } else {
            $show_junban = " ".$change_jyunban_up." ".$change_jyunban_down."<BR>";
            }

         $bound_elements_show .= $enabled." <a href=\"#\" onClick=\"loader('".$senddiv."');doBPOSTRequest('".$senddiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$bound_element_carrier_id."&valuetype=ConfigurationItems&sendiv=".$senddiv."&parent_ci=".$binder_ci."&bindable_element=".$bound_element_ci_id."&partype=".$binder_tci."&granpar_ci=".$granpar_ci."');return false\">".$bound_element_name."</a>".$show_junban;

         if (count($elembinders)-1 == $cnteb){
            # This is the last item - don't need to show any conditions
            #$bound_elements_show .= $condition;
            } else {
            $bound_elements_show .= $condition;
            }

         $bound_elements[$bound_element_ci_id] = $bound_element_ci_id; // keep array to make sure not to use again below

         } // for

     } // is array provide a selection if exists

     # Loop through string to provide for attaching to this trigger

     $bindable_elements_show = "<BR><B>Bindable Elements:</B><BR>";

     for ($cntbefb=0;$cntbefb < count($ci_array);$cntbefb++){

         $be_ci_configurationitemtypes_id_c = $ci_array[$cntbefb]['sclm_configurationitemtypes_id_c'];

         if ($be_ci_configurationitemtypes_id_c == $be_type && $be_type == '98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68'){
            # String type
            $be_ci_id = $ci_array[$cntbefb]['id'];
            $be_ci_name = $ci_array[$cntbefb]['name'];

            if (in_array($be_ci_id,$bound_elements)){

               $bound_state = "Bound";

               $bindable_elements_show .= "[".$bound_state."] ".$be_ci_name."<BR>";

               } else {// if not in array

               $bound_state = "Un-bound";

               $bindable_elements_show .= "[".$bound_state."] <a href=\"#\" onClick=\"loader('".$senddiv."');doBPOSTRequest('".$senddiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$binder_tci."&valuetype=ConfigurationItemTypes&sendiv=".$senddiv."&parent_ci=".$binder_ci."&bindable_element=".$be_ci_id."&partype=".$binder_tci."&granpar_ci=".$granpar_ci."');return false\">".$be_ci_name."</a><BR>";

               $bindable_elements[$be_ci_id] = $be_ci_name;
               
               } 

            } elseif ($be_type == 'MMMMNNNN'){ // if other - some other item

            # Do something

            } // else other

         }  // for filterbits

 $bound_elements_show = "<img src=images/flowchart/flowchart-symbol-decision.png width=32><P>".$bound_elements_show;

 $be_pack[0] = $bound_elements_show;
 $be_pack[1] = $bound_elements;
 $be_pack[2] = $bindable_elements_show;
 $be_pack[3] = $bindable_elements;

 return $be_pack;

 } // end function

# End Bound Elements
#################################
# Fatality Catcher

function fatal_error_handler($buffer){

    $error=error_get_last();

    if ($error['type'] == 1){

       // type, message, file, line

       $newBuffer='<html><header><title>Fatal Error </title></header>
                    <style>                 
                    .error_content{                     
                        background: ghostwhite;
                        vertical-align: middle;
                        margin:0 auto;
                        padding:10px;
                        width:50%;                              
                     } 
                     .error_content label{color: red;font-family: Georgia;font-size: 16pt;font-style: italic;}
                     .error_content ul li{ background: none repeat scroll 0 0 FloralWhite;                   
                                border: 1px solid AliceBlue;
                                display: block;
                                font-family: monospace;
                                padding: 2%;
                                text-align: left;
                      }
                    </style>
                    <body style="text-align: center;">  
                      <div class="error_content">
                          <label >Fatal Error </label>
                          <ul>
                            <li><b>Line</b> '.$error['line'].'</li>
                            <li><b>Message</b> '.$error['message'].'</li>
                            <li><b>File</b> '.$error['file'].'</li>                             
                          </ul>

                          <a href="javascript:history.back()"> Back </a>                          
                      </div>
                    </body></html>';

       return $newBuffer;

    } # end if = 1

    return $buffer;

} # end function

# End Fatality Catcher
#################################
# Get Infra

  function get_infra (){
 

       # Service Assets | ID: a39735f4-b558-5214-1d07-52593e7f39da (not scanned)
       # Infrastructure | ID: 7827074f-a7d3-9ae5-e473-5255d64e5c73 (not scanned)
       # Data Center | ID: 7d2f42a9-9de7-224d-712c-52ad30da69fd (not scanned)
       # DC Floor (ID, Name) | ID: 9a2ee7f9-67b6-9f72-c133-52ad302dfdc0 (not scanned)
       # -> Rack (ID, Name) | ID: 63fef2c9-9acf-fbd1-56c7-52ad300f480f (not scanned)
       #    -> Rack Unit Space (ID, Name) | ID: de350370-d2d3-e84b-13c1-52ad5f2fb2ab (not scanned)
       #       -> System Name | ID: 9065cbc6-177f-9848-1ada-52ad30451c3f (not scanned)
       #       -> Blade Enclosure (ID, Name) | ID: 94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4 (not scanned)
       #          -> Blade Enclosure Hostnames | ID: cd287492-19ce-99b3-6ead-52e0c97a6e83 (scanned)
       #          -> Blade Enclosure Interconnect Bay | ID: 5601009c-5ebd-bc31-3659-52e0e4b16ffb (not scanned)
       #             -> Blade Enclosure Interconnect Bay Switch | ID: 3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889 (not scanned)
       #                -> Blade Enclosure Interconnect Bay Switch Hostname | ID: 49ff2505-7d08-cb5c-64e8-52e0e490c0dc  (scanned)
       #          -> Blades | ID: 617ab884-61b5-d7a1-1de7-52ad61df4cae (not scanned)
       #             -> Blade Hostname | ID: 34647ae4-154c-68f3-74ea-52b0c8abc3dc (scanned)
       #             -> Blade VM | ID: b3621853-e25d-0e38-84ff-52c286ae0de9 (not scanned)
       #                -> Blade VM Hostname | ID: 3f6d75b7-c0f5-1739-c66d-52c2989ce02d (scanned)
       #       -> Purpose | ID: cb455d67-8335-df81-1d3b-52ad67c4977e (not scanned)
       #       -> Rack Server - 1U | ID: 77c9dccf-a0a7-05fc-a05f-52ad62515fc7 (not scanned)
       #          -> Product Components | ID: 52784a42-d442-9e71-8d09-529304d1d518 (not scanned)
       #          -> Unit Host Name | ID: 7835c8b9-f7d5-5d0a-be10-52ad9c866856 (scanned)
       #          -> Unit VM | ID: 711d9da0-c885-6a0d-1a2c-52c286bd762d (not scanned)
       #             -> Unit VM Hostname | ID: 7ef914c8-09f8-82c9-d4b9-52c29793ef85 (scanned)
       #       -> Rack Storage Unit | ID: 7b5baafb-6f98-5d25-d9c8-541fca790cea (not scanned)
       #          -> Rack Storage Hostname | ID: 8c8a3231-1d86-0117-4680-541fcbab4f6a (scanned)
       #       -> Switch Unit | ID: c194460c-0e8d-ca8e-0aa9-541fc5785016 (not scanned)
       #          -> Switch Hostname | ID: 388b56dc-771e-b743-e63b-541fc6070ab9 (scanned)        

       # If edit - then must check any CIs that relate to this Account Service
       # When a Service SLA Request is added - will create an instance of this

       $service_types['9a2ee7f9-67b6-9f72-c133-52ad302dfdc0'] = 'DC Floor (ID, Name)';
       $service_types['63fef2c9-9acf-fbd1-56c7-52ad300f480f'] = 'Rack (ID, Name)';
       $service_types['de350370-d2d3-e84b-13c1-52ad5f2fb2ab'] = 'Rack Unit Space (ID, Name)';
       $service_types['94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4'] = 'Blade Enclosure (ID, Name)';
       $service_types['cd287492-19ce-99b3-6ead-52e0c97a6e83'] = 'Blade Enclosure Hostname';
       $service_types['5601009c-5ebd-bc31-3659-52e0e4b16ffb'] = 'Blade Enclosure Interconnect Bay';
       $service_types['3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889'] = 'Blade Enclosure Interconnect Bay Switch';
       $service_types['49ff2505-7d08-cb5c-64e8-52e0e490c0dc'] = 'Blade Enclosure Interconnect Bay Switch Hostname';
       $service_types['617ab884-61b5-d7a1-1de7-52ad61df4cae'] = 'Blade';
       $service_types['34647ae4-154c-68f3-74ea-52b0c8abc3dc'] = 'Blade Hostname';
       $service_types['b3621853-e25d-0e38-84ff-52c286ae0de9'] = 'Blade VM';
       $service_types['3f6d75b7-c0f5-1739-c66d-52c2989ce02d'] = 'Blade VM Hostname';
       $service_types['77c9dccf-a0a7-05fc-a05f-52ad62515fc7'] = 'Rack Server - 1U';
       $service_types['7835c8b9-f7d5-5d0a-be10-52ad9c866856'] = 'Unit Hostname';
       $service_types['711d9da0-c885-6a0d-1a2c-52c286bd762d'] = 'Unit VM';
       $service_types['7ef914c8-09f8-82c9-d4b9-52c29793ef85'] = 'Unit VM Hostname';
       $service_types['7b5baafb-6f98-5d25-d9c8-541fca790cea'] = 'Rack Storage Unit';
       $service_types['8c8a3231-1d86-0117-4680-541fcbab4f6a'] = 'Rack Storage Hostname';
       $service_types['c194460c-0e8d-ca8e-0aa9-541fc5785016'] = 'Switch Unit';
       $service_types['388b56dc-771e-b743-e63b-541fc6070ab9'] = 'Switch Hostname';

  return $service_types;

  } # end function get infra

# End Get Infra
#####################
# Do PDF

 function do_pdf ($pdf_content){

  $main_content = $pdf_content[0];
  $title = $pdf_content[1];

  require_once('tcpdf/config/tcpdf_config.php');

  // Include the main TCPDF library (search the library on the following directories).
  require_once('tcpdf/tcpdf.php');

  // create new PDF document
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  $titledate = date("Y-m-d_H-i-s");
  $title = $title."-".$titledate;

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('HP');
  $pdf->SetTitle($title);
  $pdf->SetSubject('Filtering');
  $pdf->SetKeywords('HP,Filtering,AGC,Report');

  // set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
  $pdf->setFooterData(array(0,64,0), array(0,64,128));

  // set header and footer fonts
  $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // set default monospaced font
  $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // set margins
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // set auto page breaks
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // set image scale factor
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // set some language-dependent strings (optional)
  if (@file_exists('tcpdf/lang/eng.php')) {
     require_once('tcpdf/lang/eng.php');
     $pdf->setLanguageArray($l);
     }

  // ---------------------------------------------------------

  // set default font subsetting mode
  $pdf->setFontSubsetting(true);

  // Set font
  // dejavusans is a UTF-8 Unicode font, if you only need to
  // print standard ASCII chars, you can use core fonts like
  // helvetica or times to reduce file size.
  $pdf->SetFont('dejavusans', '', 14, '', true);

  // Add a page
  // This method has several options, check the source code documentation for more information.
  $pdf->AddPage();

  // set text shadow effect
  $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

  // Set some content to print
  $html = <<<EOD
<h1>$title</h1>
<i>$titledate</i>
$main_content
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$file_title = str_replace(' ','',$title);
$file_title = str_replace('　','',$file_title);
$filename = $file_title.".pdf";
$pdf->Output($filename, 'I');

//return 

 } // end do pdf

# End do PDF
#####################
# Do Email

 function do_email ($mailparams){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  $from_name = $mailparams[0];
  $to_name = $mailparams[1];
  $from_email = $mailparams[2];
  $from_email_password = $mailparams[3];
  $to_email = $mailparams[4];
  $type = $mailparams[5];
  $lingo = $mailparams[6];
  $subject = $mailparams[7];
  $body = $mailparams[8];
  $mta_host = $mailparams[9];
  $mta_smtp_port = $mailparams[10];
  $mta_smtp_auth = $mailparams[11];
  $to_addressees = $mailparams[12];
  $cc_addressees = $mailparams[13];
  $bcc_addressees = $mailparams[14];
  $attachments = $mailparams[20];

/*
Used by;

SocialNetworks Rego
Forget Password
Registration

*/

// require("phpmailer/phpmailer.inc.php");

//$mail = new phpmailer;

$lingo = 'ja';

  switch ($lingo){

   case '':
   case 'e':
   case 'en':

    $subject = mb_convert_encoding($subject, "ISO-8859-1", "UTF-8");
    $body = mb_convert_encoding($body, "ISO-8859-1", "UTF-8");
    $mail_lingo = "ISO-8859-1";

   break;
   case 'j':
   case 'ja':

    #mb_language("ja");

    #$subject = mb_encode_mimeheader($subject,"ISO-2022-JP-MS");
    #$subject = mb_encode_mimeheader($subject,"ISO-2022-JP");
    #$body = mb_convert_encoding($body,"ISO-2022-JP-MS");
    $subject = mb_encode_mimeheader($subject,"UTF-8");
    $body = mb_convert_encoding($body,"UTF-8");

/*
    $subject = mb_encode_mimeheader($subject,"ISO-2022-JP");
    $body = mb_convert_encoding($body,"ISO-2022-JP");
*/
    #$mail_lingo = 'ISO-2022-JP';
    $mail_lingo = 'UTF-8';

   break;

  } // end lingo switch

//$subject_encode = mb_detect_encoding($subject);
//$body_encode = mb_detect_encoding($body);

  switch ($type){

   case '1':
    $mtype = "plain";
    $ishtml = false;
   break;
   case '2':
    $mtype = "html";
    $ishtml = true;
   break;

  } // end type switch

/*
$fromemail = $from_name." <".$from_email.">";
$replytoemail = $from_name." <".$from_email.">";

$headers = 
"MIME-Version: 1.0\n" .
"Content-type: text/". $mtype. "; charset=".$mail_lingo."\n".
"From: ".$from_email."\n".
"Reply-To: ".$replytoemail."\n".
"X-Mailer: PHP";

mail($to_email, $subject, $body, $headers);
*/

// path to the PHPMailer class
if (!class_exists('PHPMailer')){
   include("PHPMailer/class.phpmailer.php");
   }

$mail = new PHPMailer();  
$mail->CharSet = $mail_lingo;
$mail->Encoding = "7bit";
$mail->IsSMTP();  // telling the class to use SMTP
$mail->Mailer = "smtp";
if (!$mta_host){
   $mail->Host = "ssl://smtp.gmail.com";
   //$mail->Host = "smtp.gmail.com";
   } else {
   $mail->Host = $mta_host;
   }

if (!$mta_smtp_port){
   $mail->Port = 465;
   } else {
   $mail->Port = $mta_smtp_port;
   }

if (!$mta_smtp_auth){
   $mail->SMTPAuth = true;
   } else {
   $mail->SMTPAuth = $mta_smtp_auth;
   }

$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = $from_email; // SMTP username
$mail->Password = $from_email_password; // SMTP password 
 
$mail->From     = $from_email;

$from_name = mb_encode_mimeheader($from_name, 'UTF-8', 'Q', "\n");
$mail->FromName = $from_name;

if ($to_email && $to_name){
   $to_name = mb_encode_mimeheader($to_name, 'UTF-8', 'Q', "\n");
   $n = strpos($to_name, "\n");
   if ($n !== FALSE) $to_name = substr($to_name, 0, $n);
   $mail->AddAddress($to_email,$to_name);
   } elseif ($to_email != NULL && $to_name==NULL){
   $mail->AddAddress($to_email,$to_email);
   } elseif ($to_email == NULL && $to_name==NULL){
   //$mail->AddAddress($to_email,$to_email);
   }


if (is_array($to_addressees)){

   #$log_content .= "TO: ";
   foreach ($to_addressees as $toadd_email => $toadd_name){
           #$n = "";
           $toadd_name = mb_encode_mimeheader($toadd_name, 'UTF-8', 'Q', "\n");
           #$n = strpos($toadd_name, "\n");
           #if ($n !== FALSE){
              #$log_content .= "$toadd_name, ";
              $toadd_name = substr($toadd_name, 0, $n);
              $mail->AddAddress($toadd_email, $toadd_name);
           #   }
           }

   } // if array

if (is_array($cc_addressees)){

   foreach ($cc_addressees as $cc_email => $cc_name){
           #$n = "";
           $cc_name = mb_encode_mimeheader($cc_name, 'UTF-8', 'Q', "\n");
           #$n = strpos($cc_name, "\n");
           #if ($n !== FALSE){
              $cc_name = substr($cc_name, 0, $n);
              $mail->AddCC($cc_email, $cc_name);
           #   }
           }

   } // if array

if (is_array($bcc_addressees)){

   foreach ($bcc_addressees as $bcc_email => $bcc_name){
           #$n = "";
           $bcc_name = mb_encode_mimeheader($bcc_name, 'UTF-8', 'Q', "\n");
           #$n = strpos($bcc_name, "\n");
           #if ($n !== FALSE){
              $bcc_name = substr($bcc_name, 0, $n);
              $mail->AddBCC($bcc_email, $bcc_name);
            #  }
           }

   } // if array

$mail->Subject  = $subject;
$mail->Body     = $body;
#$mail->WordWrap = 100;  

if (is_array($attachments)){

   foreach ($attachments as $name => $attachment){

           $mail->AddAttachment($attachment,$name);

           } # foreach

   } # is attachment array
 
if(!$mail->Send()) {

  $emailresult[0] = "NG";
  $emailresult[1] = "Message was not sent.";
  $emailresult[2] = "Mailer error: " . $mail->ErrorInfo;
  } else {
  $emailresult[0] = "OK";
  }

  $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
  $log_name = "Scalastica";
  $log_link = "content/".$portal_account_id."/".$log_name.".log";
  #$log_content .= " Status: $emailresult[0] Sent: $emailresult[1] Error:  $emailresult[2] ";
  $logparams[0] = $log_location;
  $logparams[1] = $log_name;
  $logparams[2] = $log_content;
  #$this->funky_logger ($logparams);

return $emailresult;

/*
 $mail = new phpmailer;

 $mail->IsSMTP();
 $mail->SMTPAuth   = true; // enable SMTP authentication
 $mail->SMTPSecure = "ssl"; // use ssl
 $mail->Host = "smtp.googlemail.com"; // GMAIL's SMTP server
 $mail->Port  = 465; // SMTP port used by GMAIL server
 $mail->Username   = $from_email; // GMAIL username
 $mail->Password   = $from_email_password; // GMAIL password

 $mail->From = $from_email;
 $mail->FromName = $from_name;

 $mail->AddAddress($to_email, $to_name);
 $mail->AddReplyTo($from_email, $from_name);
 $mail->WordWrap = 50;    // set word wrap
// $mail->AddAttachment("c:\\temp\\js-bak.sql");  // add attachments
// $mail->AddAttachment("c:/temp/11-10-00.zip");

 $mail->IsHTML($ishtml);    // set email format to HTML
 $mail->Subject = $subject;
 $mail->Body = $body;
 $mail->Send(); // send message

 require("class.phpmailer.php");  
$mail -> charSet = "UTF-8";
$mail = new PHPMailer();  
$mail->IsSMTP();  
$mail->Host     = "smtp.mydomain.org";  
$mail->From     = "name@mydomain.org";
$mail->SMTPAuth = true; 
$mail->Username ="username"; 
$mail->Password="passw"; 
//$mail->FromName = $header;
$mail->FromName = mb_convert_encoding($header, "UTF-8", "auto");
$mail->AddAddress($emladd);
$mail->AddAddress("mytest@gmail.com");
$mail->AddBCC('mytest2@mydomain.org', 'firstadd');
$mail->Subject  = $sub;
$mail->Body = $message;
$mail->WordWrap = 50;  
 if(!$mail->Send()) {  
   echo 'Message was not sent.';  
   echo 'Mailer error: ' . $mail->ErrorInfo;  
 }

$recipients = array('person1@domain.com' => 'Person One','person2@domain.com' => 'Person Two',);

foreach($recipients as $email => $name)
{
   $mail->AddCC($email, $name);
}

*/

 } // end function do email

 # End Emailer
 ################################
 # Drop down function # 

 function dropdown_jaxer ($do,$action,$valtype,$dd_pack, $current_value,$label,$tbl,$val,$params){

 global $strings;

 $drop_down_return = "";

 //echo "DO $do Action $action Label: $label table: $tbl <P>";

 if (is_array($params)){
    reset($params);
    while (list($key, $value) = each($params)){
          $added_params .= "&".$key."=".$value;
          }
    }

 $drop_down_return = "<select name=$label id=$label style=\"font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;\" onChange=\"loader('".$tbl."');getjax('getjax.php?do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."&tbl=".$tbl.$added_params."&currval=".$current_value."&id='+this.value,'".$tbl."');\">";

    $drop_down_return .= "<option SELECTED id=NULL value=NULL>".$strings["action_select_request"];

 // Use packaged array data to create list

 if (is_array($dd_pack)){
    reset($dd_pack);
    while (list($key, $value) = each($dd_pack)){

          //echo "Key: ".$key." value: ".$value."<P>";
     
          if ($key == $current_value && $current_value != NULL){
             $option="<option SELECTED id=\"".$key."\" value=\"".$key."\">".$value;
             } else { 
             $option="<option id=\"".$key."\" value=\"".$key."\">".$value;
             }
          $drop_down_return .= $option;   
         } // end while

        } // end if array 

 $drop_down_return .= "</select>";

 return $drop_down_return;

 } // end drop down

 #
 ################################
 # Drop down function

 function file_jaxer ($do,$action,$valtype,$dd_pack, $current_value, $label,$tbl,$val,$params){

  global $strings;

 $drop_down_return = "";

// $drop_down_return = "<input type=\"file\" id=\"$label\" name=\"$label\">".$button_style."<div><button type=\"button\" name=\"button\" value=\"Upload\" onclick=\"loader('".$BodyDIV."');getjax('getjax.php?do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."&tbl=".$tbl.$added_params."&id='+this.value,'".$tbl."');\" class=\"css3button\">Upload</div>";

// $drop_down_return = "<input type=\"file\" id=\"$label\" name=\"$label\"><button type=\"button\" name=\"button\" value=\"".$strings["Upload"]."\" onClick=\"loader('".$BodyDIV."');getjax('getjax.php?do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."&tbl=".$tbl.$added_params."&id='+this.value,'".$tbl."');\" class=\"css3button\">".$strings["Upload"];

$formname = "form_".$tbl;

// $drop_down_return = "<form id=\"fileform\" action=\"getjax.php\" method=\"post\" enctype=\"multipart/form-data\">";
 $drop_down_return = "<fieldset>";
 $drop_down_return .= "<legend>HTML File Upload</legend>";
 $drop_down_return .= "<input type=\"hidden\" name=\"do\" id=\"do\" value=\"$do\">";
 $drop_down_return .= "<input type=\"hidden\" name=\"action\" id=\"action\" value=\"$action\">";
 $drop_down_return .= "<input type=\"hidden\" name=\"valuetype\" id=\"valuetype\" value=\"$valtype\">";
 $drop_down_return .= "<input type=\"hidden\" name=\"value\" id=\"value\" value=\"$val\">";
 $drop_down_return .= "<input type=\"hidden\" name=\"tbl\" id=\"tbl\" value=\"$tbl\">";
// $drop_down_return .= "<input type=\"hidden\" name=\"params\" value=\"$params\">";
 $drop_down_return .= "<input type=\"hidden\" id=\"MAX_FILE_SIZE\" name=\"MAX_FILE_SIZE\" value=\"300000\" />";
 $drop_down_return .= "<div>
	<label for=\"fileselect\">Files to upload:</label>
	<input type=\"file\" id=\"fileselect\" name=\"fileselect[]\" multiple=\"multiple\" />
	<div id=\"filedrag\">or drop files here</div>
</div>";

 $drop_down_return .= "<div id=\"submitbutton\">
	<button type=\"submit\">".$strings["UploadFile"]."</button>
</div>";

 $drop_down_return .= "</fieldset>";

/*
 $drop_down_return .= "<input type=\"file\" size=\"60\" name=\"myfile\">
     <input type=\"submit\" value=\"".$strings["UploadFile"]."\" class=\"css3button\">";
*/

 $drop_down_return .= "</form>";

 $drop_down_return .= "<div id=\"progress\">
        <div id=\"bar\"></div>
        <div id=\"percent\">0%</div >
</div>";

 $drop_down_return .= "<div id=\"message\"></div>";

$filer = <<< FILER

<script>
$(document).ready(function()
{
 
    var options = { 
    beforeSend: function() 
    {
        $("#progress").show();
        //clear everything
        $("#bar").width('0%');
        $("#message").html("");
        $("#percent").html("0%");
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#bar").width(percentComplete+'%');
        $("#percent").html(percentComplete+'%');
 
    },
    success: function() 
    {
        $("#bar").width('100%');
        $("#percent").html('100%');
 
    },
    complete: function(response) 
    {
        $("#message").html("<font color='green'>"+response.responseText+"</font>");
    },
    error: function()
    {
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
 
    }
 
}; 
 
     $("#$formname").ajaxForm(options);
 
});
 
</script>

FILER;

 $drop_down_return .= $filer;

 return $drop_down_return;

 } // end drop down

 #
 ################################
 # Gallery Parent Packager function

 function get_gallery_parent($parent_id,$parpack){

if (!class_exists('gallery')){
   include ("api-gallery.php");
   }

    $funky_gallery = new gallery ();

    $gallery_object_type = "Items";
    $gallery_action = "get_parent";

    $gallery_params = array();
    $gallery_params[0] = "WHERE id=".$parent_id." && parent_id>0 && type='album'";
    $gallery_params[1] = "id,name,parent_id";
    $gallery_params[2] = "order by parent_id DESC";

    $par_list = $funky_gallery->api_gallery ($gallery_object_type, $gallery_action, $gallery_params);

    if (is_array($par_list)){

       // Build a list of Parents albums to work out the URL      
       for ($parcnt=0;$parcnt<count($par_list);$parcnt++){

           $id = $par_list[$parcnt]["id"]; 
           $parent_id = $par_list[$parcnt]["parent_id"];
           $parent_name = $par_list[$parcnt]["name"];

           if ($parent_id){

              $parpack[$parent_id] = $parent_name;
              $parpack = $this->get_gallery_parent ($parent_id,$parpack);

              } // end if

           } // end for

       } // end if

   return $parpack;

 } // end function

 #
 ################################
 # Gallery Drop down function

 function dropdown_gallery ($dd_pack, $current_value, $label,$val,$type){

 $drop_down_return = "";

 # Use packaged array data to create list

 if (is_array($dd_pack)){
    reset($dd_pack);

    $cnt = 0;

    while (list($key, $value) = each($dd_pack)){

          $title = $value[0];
          $image = $value[1];
          $content = $value[2];
          $checkstate = $value[3];
          $details = $value[4];

          if ($details != NULL){
             $details = " | Details: ".$details;
             }

          switch ($type){

           case 'checkbox':

            $newkey = ""; 
            $newkey = $label."_key_".$key;
            $checkkey = $key;

           break;
           case 'radio':

            $newkey = ""; 
            $newkey = $label;
            $checkkey = $content;

           break;

          }

          if ($content != NULL){
             $image = "<a href=".$content." target=content><img src=\"".$image."\" width=50 border=0> ".$title."</a>".$details;
             } else {
             $image = "<img src=\"".$image."\" width=50 border=0> ".$title.$details;
             }

          if ($current_value==$checkkey || $checkstate == 1){
             $checkimage = "<input type=\"".$type."\" name=\"".$newkey."\" id=\"".$newkey."\" value=\"".$checkkey."\" checked>".$image;
             } else {
             $checkimage = "<input type=\"".$type."\" name=\"".$newkey."\" id=\"".$newkey."\" value=\"".$checkkey."\">".$image;
             }

          switch ($type){

           case 'checkbox':
            $checkimage = "<td style=\"width:400px;min-height:150px;\"><img src=images/blank.gif width=10 height=50> ".$checkimage."</td>";
            # The next line makes a new line per item
            $checkimage = "<tr>".$checkimage."</tr>";
            $drop_down_return .= $checkimage;
           break;
           case 'radio':
            $checkimage = "<td style=\"width:400px;min-height:150px;\"><img src=images/blank.gif width=10 height=50> ".$checkimage."</td>";
            # The next line makes a new line per item
            $checkimage = "<tr>".$checkimage."</tr>";
            $drop_down_return .= $checkimage;
           break;

           }
/*
          if ($cnt < 6){
             $cnt++;
             }

          if ($cnt == 6){
             $checkimage = "<tr>".$checkimage."</tr>";
             $cnt = 0;
             }
*/

         } // end while

        } // end if array 


   $reset = "<td style=\"width:400px;min-height:150px;\"><img src=images/blank.gif width=10 height=50><button type=\"reset\" value=\"Reset\">Reset</button></td>";

   #$toggle = "<td style=\"width:400px;min-height:150px;\"><img src=images/blank.gif width=10 height=50><input type=\"checkbox\" onClick=\"toggle(this)\" /> Toggle All<br/></td>";

   $drop_down_return .= "<tr>".$reset."</tr>";

 # Can't use toggle due to diff name for each item
 $funkytoggle = "<script language=\"JavaScript\">
function toggle(source) {
  checkboxes = document.getElementsByName('foo');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>";

 switch ($type){

  case 'checkbox':
   $drop_down_return = "<table>". $drop_down_return."</table>";
   $drop_down_return = "<div style=\"width:350px;min-height:150px;max-height:400px;overflow:auto;\">". $drop_down_return."</div>";
  break;
  case 'radio':
   $drop_down_return = "<table>". $drop_down_return."</table>";
   $drop_down_return = "<div style=\"width:350px;min-height:150px;max-height:400px;overflow:auto;\">". $drop_down_return."</div>";
  break;

 }

 return $drop_down_return;

 } // end drop down

 #
 ################################
 # Drop down function

 function dropdown_jumper ($do,$action,$valtype,$dd_pack, $current_value, $label,$val){

  global $lingo,$strings,$BodyDIV;

  $drop_down_return = "";

//  echo "DO $do Action $action Label: $label <P>";

// $drop_down_return = "<select id=$label name=$label onchange=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."');return false\">";

 $drop_down_return = "<select id=$label name=$label style=\"font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;\" onchange=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."&".$label."='+this.value);return false\">";


 // Use packaged array data to create list

 if (is_array($dd_pack)){
    reset($dd_pack);

    $drop_down_return .= "<option SELECTED id=NULL value=NULL>".$strings["action_select_request"];

    while (list($key, $value) = each($dd_pack)){

          #echo "Key: ".$key." value: ".$value."<P>";
     
          if ($key == $current_value && $current_value != NULL){
             $option="<option SELECTED id=\"".$key."\" value=\"".$key."\">".$value;
             } else { 
             $option="<option id=\"".$key."\" value=\"".$key."\">".$value;
             }
          $drop_down_return .= $option;   
         } // end while

        } // end if array 

 $drop_down_return .= "</select>";

 return $drop_down_return;

 } // end drop down

 #
 ################################
 # Drop down function

 function dropdown ($action, $dd_pack, $current_value, $label, $object){

  global $BodyDIV,$portalcode,$val,$valtype,$do,$lingo,$strings;

  #echo "$action, $dd_pack, $current_value, $label, $object";

  $drop_down_return = "";

  if ($action == 'view'){

     $drop_down_return = "";

     if (is_array($dd_pack)){

        reset($dd_pack);

        while (list($key, $value) = each($dd_pack)){
     
              if ($key == $current_value && $current_value != NULL){

                 if ($object != NULL){

                    $drop_down_return = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$object."&action=view&value=".$current_value."&valuetype=".$object."');return false\"><font=#151B54>".$value."</font></a>";

                    } else {

                    $drop_down_return = $value;

                    } // end if object

                 } // end if key value

               } // end while

         } // end if array 

     } else {

#     $drop_down_return = "<select id=$label name=$label>";

     $drop_down_return = "<select id=$label name=$label style=\"font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;\">";

     // Use packaged array data to create list

     $drop_down_return .= "<option SELECTED id=NULL value=NULL>".$strings["action_select_request"];

     if (is_array($dd_pack)){

        reset($dd_pack);

        while (list($key, $value) = each($dd_pack)){

              if ($key == $current_value && $current_value != NULL){
                 $option="<option SELECTED id=\"".$key."\" value=\"".$key."\">".$value;
                 } else { 
                 $option="<option id=\"".$key."\" value=\"".$key."\">".$value;
                 }

              $drop_down_return .= $option;   

              } // end while

        } // end if array 

     $drop_down_return .= "</select>";

     } // end if else

  return $drop_down_return;

 } // end drop down

 # End Drop Down
 ################################
 # Lingo Data Pack

 function lingo_data_pack ($data_array, $name, $description, $name_field_base,$content_field_base){

  global $lingos;

    for ($cnt=0;$cnt < count($data_array);$cnt++){

       #####################################################
       # Get Lingo Content

       for ($x=0;$x<count($lingos);$x++) {

           $field_lingo_pack[$x][0][0][0][0][0][0][0][0][0][0] = $lingos[$x][0][0][0][0][0][0];
           $field_lingo_pack[$x][1][0][0][0][0][0][0][0][0][0] = $lingos[$x][1][0][0][0][0][0];
           $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0] = $lingos[$x][1][1][0][0][0][0];
           $field_lingo_pack[$x][1][1][1][0][0][0][0][0][0][0] = $lingos[$x][1][1][1][0][0][0];
           $field_lingo_pack[$x][1][1][1][1][0][0][0][0][0][0] = $lingos[$x][1][1][1][1][0][0];
           $field_lingo_pack[$x][1][1][1][1][1][0][0][0][0][0] = $lingos[$x][1][1][1][1][1][0];
           $field_lingo_pack[$x][1][1][1][1][1][1][0][0][0][0] = $lingos[$x][1][1][1][1][1][1];

           $extension = $lingos[$x][0][0][0][0][0][0];

           if ($name_field_base == "name_x_c"){

              $name_field_lingo = "name_".$extension."_c";
              $content_field_lingo = "description_".$extension."_c";

              } else {

              $name_field_lingo = $name_field_base.$extension;
              $content_field_lingo = $content_field_base.$extension;

              } 

           $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0] = $name_field_lingo;
           $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0] = $content_field_lingo;

           $name_data = $data_array[$cnt][$name_field_lingo];
           $content_data = $data_array[$cnt][$content_field_lingo];

           #echo "Field: ".$name_field_lingo." = ".$name_data."<BR>";

           if ($name_data == NULL){
              $name_data = $name; 
              }

           if ($content_data == NULL){
              $content_data = $description; 
              }

           $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0] = $name_data;
           $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1] = $content_data;

           } // end for loop

    } // end for loop

  return $field_lingo_pack;

 } // end function

 # End Process Pack
 ################################
 # Lingo Process Pack

 function lingo_process_pack ($sent_name, $sent_description, $name_field_base,$content_field_base){

  global $lingos;

       for ($x=0;$x<count($lingos);$x++) {

           $field_lingo_pack[$x][0][0][0][0][0][0][0][0][0][0] = $lingos[$x][0][0][0][0][0][0];
           $field_lingo_pack[$x][1][0][0][0][0][0][0][0][0][0] = $lingos[$x][1][0][0][0][0][0];
           $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0] = $lingos[$x][1][1][0][0][0][0];
           $field_lingo_pack[$x][1][1][1][0][0][0][0][0][0][0] = $lingos[$x][1][1][1][0][0][0];
           $field_lingo_pack[$x][1][1][1][1][0][0][0][0][0][0] = $lingos[$x][1][1][1][1][0][0];
           $field_lingo_pack[$x][1][1][1][1][1][0][0][0][0][0] = $lingos[$x][1][1][1][1][1][0];
           $field_lingo_pack[$x][1][1][1][1][1][1][0][0][0][0] = $lingos[$x][1][1][1][1][1][1];

           $extension = $lingos[$x][0][0][0][0][0][0];

           $name_field_lingo = $name_field_base.$extension;
           $content_field_lingo = $content_field_base.$extension;

           $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0] = $name_field_lingo;
           $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0] = $content_field_lingo;

           $sent_name_data = $_POST[$name_field_lingo];
           $sent_content_data = $_POST[$content_field_lingo];

           if ($sent_name_data == NULL){
              $sent_name_data = $sent_name; 
              }

           if ($sent_content_data == NULL){
              $sent_content_data = $sent_description; 
              }

           $process_params[] = array('name'=>$name_field_lingo,'value' => $sent_name_data);
           $process_params[] = array('name'=>$content_field_lingo,'value' => $sent_content_data);

           $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0] = $sent_name_data;
           $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1] = $sent_content_data;

           } // end for loop

  $process_package[0] = $process_params;
  $process_package[1] = $field_lingo_pack;

  return $process_package;

 } // end function

 # End Process Pack
 ################################
 # timeDiff

 function timeDiff($firstTime,$lastTime){

 // convert to unix timestamps
 $firstTime=strtotime("$firstTime");
 $lastTime=strtotime("$lastTime");

 // perform subtraction to get the difference (in seconds) between times
// $timeDiff=$firstTime-$lastTime;
 $timeDiff=$lastTime-$firstTime;

 // return the difference
 return $timeDiff;

 }

 # 
 ################################
 # Form Presentation
 
 function form_presentation ($valuepack){
  
  global $portalcode,$strings,$lingo,$BodyDIV,$portal_config,$portal_header_colour,$portal_font_colour,$portal_body_colour,$portal_footer_colour,$portal_border_colour;

  $header_color = $portal_header_colour;
  $body_color = $portal_body_colour;
  $footer_color = $portal_footer_colour;
  $border_color = $portal_border_colour;
  $font_color = $portal_font_colour;

  /*
  $header_color = $portal_config['portalconfig']['portal_header_color'];
  $body_color = $portal_config['portalconfig']['portal_body_color'];
  $footer_color = $portal_config['portalconfig']['portal_footer_color'];
  $border_color = $portal_config['portalconfig']['portal_border_color'];
  */

  $popwidth = "600";
  $popheight = "550";
  $helperpopwidth = "500";
  $helperpopheight = "250";
  $form = "";
  include ("css/style.php");

  $do = $valuepack[0];
  $action = $valuepack[1];
  $valtype = $valuepack[2];  
  $table_fields = "";
  $table_fields = $valuepack[3];
  $admin_status = $valuepack[4];
  $provide_add_button = $valuepack[5];
  $next_action = $valuepack[6];
  $button_text = $valuepack[7];
  $edit_link_params = $valuepack[8];
  if ($valuepack[9] != NULL){
     $BodyDIV = $valuepack[9];
     }

  $sendiv = $valuepack[10];
  if ($sendiv != NULL){
     $BodyDIV = $sendiv;
     }

  $do_scroller = $valuepack[11];
  if ($do_scroller == FALSE){
     $scroller = "";
     } elseif ($do_scroller == NULL || $do_scroller == TRUE) {
     $scroller = "Scroller();";
     }

  $extra_form_params[0] = $BodyDIV;

  if ($next_action == NULL){

     if ($action == 'select'){
        $next_action='add';
        }

     if ($action == 'add' || $action == 'Contact' || $action == 'edit' || $action == 'send_internal'|| $action == 'Share' || $action == 'request_to_join' || $action == 'request_ownership_transfer'){
        $next_action='process';
        }

     if ($action == 'add_member'){
        $next_action='process_member';
        }
     
     if ($action == 'view'){
        $next_action='view';
        }  

     if ($action == 'search'){
        $next_action='search';
        }  

     } else {// end if no next action set (new feature as of 2013-01)

     #$next_action = $valuepack[6];
     #$action = $next_action;
     $next_action = $valuepack[6];
     #echo "next_action $next_action ";

     }

  if (is_array($table_fields)){

   $form = "";

   ##########################
   # Actions

#   $divwidth = 470;
   $divwidth = "95%";
//   $divwidth = 450;
   $tdlabelwidth = 85;
   $tdvaluewidth = 290;
//   $tdvaluewidth = "88%";
   $textboxsize = 50;
   $textareacols = 20;
   $skinfont = $font_color;

   switch ($action){  
 
    ############################
    # Edit/Add

    case 'add':
    case 'do_login':
    case 'custom':
    case 'register':
    case 'forgotten':
    case 'add_member':
    case 'Contact':
    case 'edit':
    case 'send_internal':
    case 'send_message':
    case 'search':
    case 'select':
    case 'Share':
    case 'request_to_join':
    case 'request_ownership_transfer':
    case 'notifications':

     $form = "";

     ##################################
     # Loop Table Fields

     for ($table_cnt=0;$table_cnt < count($table_fields);$table_cnt++){

//         $primary_id = $table_fields[$table_cnt][2];

         if ($table_fields[$table_cnt][2] == 1){
            $primary_id=$table_fields[$table_cnt][21];
            }

         if ($table_fields[$table_cnt][0] == 'sendiv'){
            $BodyDIV=$table_fields[$table_cnt][21];
            }

         }

     for ($table_cnt=0;$table_cnt < count($table_fields);$table_cnt++){

         // The loop will go through each tables fields and their respective properties
         // The action will determine form type
         // The type will determine form feature

         $form_object = "";

         // Field structure values
         $fieldname = "";
         $fieldname = $table_fields[$table_cnt][0];
         $fullname = "";
         $fullname = $table_fields[$table_cnt][1];

         $is_primary = $table_fields[$table_cnt][2];
         $is_auto = $table_fields[$table_cnt][3];
         $is_name = $table_fields[$table_cnt][4];
         $type = $table_fields[$table_cnt][5];
         $length = $table_fields[$table_cnt][6];
         $nullok = $table_fields[$table_cnt][7];
         $default = $table_fields[$table_cnt][8];

         $dropdownpack = $table_fields[$table_cnt][9];

         $show_field_in_view = $table_fields[$table_cnt][10];
         $field_id = $table_fields[$table_cnt][11];

         $field_object_length = $table_fields[$table_cnt][12];
         if ($field_object_length != NULL){
            $textboxsize = $field_object_length;
            }

         $table_fields[$table_cnt][13] = $table_fields[$table_cnt][21];
         $target_market = $table_fields[$table_cnt][17];
   
         // Contacts Fields Values - for editing
         $field_value_id = $table_fields[$table_cnt][20];
         $field_value = $table_fields[$table_cnt][21];

         $desired_cmv = $table_fields[$table_cnt][22];
         $open_state = $table_fields[$table_cnt][23];
         $ads_state = $table_fields[$table_cnt][24];
         $business_offer_value = $table_fields[$table_cnt][25];
         $cmv_verificationmethods_id_c = $table_fields[$table_cnt][26];
         $cmv_verificationstates_id_c = $table_fields[$table_cnt][27];
         $verification_state_id = $table_fields[$table_cnt][28];

         $is_child = $table_fields[$table_cnt][40];

         $flipfield = $table_fields[$table_cnt][41];
         $nolabel = $table_fields[$table_cnt][42]; // show no label
         $field_extras = $table_fields[$table_cnt][43]; // show extra after field
         # Additional bits after firld value (Images for statuses)
         $fill_bits[0] = $field_extras;

         $concat = $table_fields[$table_cnt][50];
         # Concat field for dropdowns - selection values
         $object_bits[0] = $concat;

         if ($nolabel == 1){
            $fullname = "";
            }
     
         $thisvalue = $field_value;

         // Try out the file upload feature
         if ($type == 'upload'){
            $multipart = 'enctype=\"multipart/form-data\"';
            } else {
            $multipart = '';
            } 

         $dropdown_jaxer_form_start = "";
         $dropdown_jaxer_form_end = "";
         $dropdown_jaxer_div_start = "";
         $dropdown_jaxer_div_end = "";

         if ($type == 'dropdown_jaxer' || $type == 'file_jaxer'){
            // Dropdown ajax selector needs a div to put new values into - call it same as tablename
            switch ($dropdownpack[0]){
             case 'db':
              $dropdown_jaxer_div_name = $dropdownpack[1];
             break;
             case 'list':
              $dropdown_jaxer_div_name = $dropdownpack[7];
              $dropdown_jaxer_action = "getjax.php";
             break;
            }

            $dropdown_jaxer_form_start = "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"".$dropdown_jaxer_action."\" name=\"form_".$dropdown_jaxer_div_name."\">";
            $dropdown_jaxer_form_end = "</form>";
            $dropdown_jaxer_div_start = "<div id=\"".$dropdown_jaxer_div_name."\" name=\"".$dropdown_jaxer_div_name."\">";
            $dropdown_jaxer_div_end = "</div>";
            $formobjectheight = "15px";

            } else {
            // Nothing - no effects
            $dropdown_jaxer_form_start = "";
            $dropdown_jaxer_form_end = "";
            $dropdown_jaxer_div_start = "";
            $dropdown_jaxer_div_end = "";
            $formobjectheight = "15px";
            } 

         // The valuepack would contain any values based on the above table/field structure IF ANY
         if ($action == 'edit' || $action == 'add' || $action == 'select' || $action == 'custom'){

            //$primary = $table_fields[0][0]; // primary
            $thisvalue = $field_value;

            } // end if edit

         $background= "white";

         if ($type == 'textarea'|| $type == 'upload' || $type == 'dropdown_gallery'){
            $formobjectheight = "250px";
            } 

         if ($type == 'textarea'){
//            $textboxsize = 65;
//            $textareacols = 30;
            }

         if ($is_auto != 1 && $type != 'hidden' && $dropdownpack==NULL){
            // If auto - then no need to show

            $form_object = $this->form_objects($do,$next_action,$valtype,$fieldname,$type,$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

            if ($flipfield == 1){

               $form .= "<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;float:auto;\">
        <div style=\"margin-left:0px;float:left;background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 2px 5px 7px 5px;overflow:no\">
            <font color=$skinfont>$form_object</font> $field_extras</div>
        <div style=\"margin-left:5px;margin-bottom:0px;margin-top:0px;float:left;background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 2px 5px 7px 5px;overflow:yes\">
  $fullname 
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>";
               } else {

               $form .= "<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;float:auto;\">
        <div style=\"margin-left:0px;float:left;background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 2px 5px 7px 5px;overflow:no\">
            <font color=$skinfont>$fullname</font></div>
        <div style=\"margin-left:5px;margin-bottom:0px;margin-top:0px;float:left;background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 2px 5px 7px 5px;overflow:yes\">
  $form_object";

// Trying to put rich editor in the textarea!!

               if ($type == 'textarea'){

/*                  $form .= "<script type=\"text/javascript\">
	CKEDITOR.replace('".$fieldname."');
</script>";
*/
                  } //  end if textarea

               $form .= "$field_extras
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>";

               } 

            } // end if auto
      

         if ($is_auto == 1 && $action == 'edit'){

            // No Edit box, but show value and use as hidden
            $form_object = $this->form_objects($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);
 
            if ($flipfield == 1){

               $form .= "<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
         $form_object $field_extras
            </div>
        <div style=\"margin-left:5px;float:left; background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>";
              } else {

               $form .= "<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
            </div>
        <div style=\"margin-left:5px;float:left; background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
         $form_object $field_extras
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>";
              } 

            } // end if auto 
      
         if (is_array($dropdownpack) && $dropdownpack != NULL){  
      
            // Usually pass $thisvalue into the form object builder, but will replace with params for dropdown
            $form_object = $this->form_objects($do,$next_action,$valtype,$fieldname,$type,$length,$textboxsize,$textareacols,$dropdownpack,$field_id,$primary_id,$object_bits);

            if ($flipfield == 1){

               $form .= $dropdown_jaxer_form_start."<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;\">
$dropdown_jaxer_div_start
        <div style=\"margin-left:0px;float: left; background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
         $form_object $field_extras</div>
        <div style=\"margin-left:5px;margin-bottom:0px;margin-top:0px;float:left;background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 2px 5px 7px 5px;overflow:yes\">
            <font color=$skinfont>$fullname</font>
        </div>
$dropdown_jaxer_div_end
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>".$dropdown_jaxer_form_end;

              } else {

               $form .= $dropdown_jaxer_form_start."<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;\">
$dropdown_jaxer_div_start
        <div style=\"margin-left:0px;float: left; background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
            <font color=$skinfont>$fullname</font></div>
        <div style=\"margin-left:5px;margin-bottom:0px;margin-top:0px;float:left;background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 2px 5px 7px 5px;overflow:yes\">
         $form_object $field_extras
        </div>
$dropdown_jaxer_div_end
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>".$dropdown_jaxer_form_end;

              } // end if flipfield

            } // end if relatedtable     

         if ($type == 'hidden'){

            $form_object = "";
            $form_object = $this->form_objects($do,$next_action,$valtype,$fieldname,$type,$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

            $form .= "<tr>
 <td>".$form_object."
 </td>
</tr>";

            } // end if
      
         } // end for loop

     # End Loop Table Fields
     ##################################

    // Do form header here as we may add elements such as upload based on form objects

     $form_header = "<form action=\"javascript:get(document.getElementById('".$BodyDIV."'));\" ".$multipart." id=\"Funky\">
<table align=\"center\" width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
  
    break; // end Add/Edit action
    #
    ############################
    # View List
    case 'view':
    
     $list_type = 'rows';
     
//     $form_header = "<table style=\"".$style_FormTable."\" width=\"98%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
     $form_header = "<script type=\"text/javascript\">setVarsForm(\"do=".$do."&valtype=".$valtype."&val=".$primary_id.$edit_link_params."\");</script><table align=\"center\" width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

     $form = $this->fill_data($action,$next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params,$extra_form_params);
     
    break;
    case 'view_list':
    
     $list_type = 'columns';

     $form_header = " <table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
  <tr>";

     for ($table_cnt=0;$table_cnt < count($table_fields);$table_cnt++){
         $fullname = $table_fields[$table_cnt][1];

         if ($table_fields[$table_cnt][10] == 1){
            $form_pack_td .= "<td>
      <div style=\"margin-left:0px;float: left; background:".$header_color."; width:".$divwidth."px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\"><font >$fullname</font></div>
    </td>";
 
            } // end if

         } // end for loop for field descs
  
     $form_header .= $form_pack_td."</tr>";

     $form = $this->fill_data($next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params,$extra_form_params);

    break; // end View action
    #
    ############################
    # Kakunin
    case 'kakunin':

     $form_header = "<form name=\"form_$tablename\" method=\"POST\" action=\"Body.php\"><input type=hidden name=tbl value=$table><input type=hidden name=action value=process>
 <table style=\"".$style_FormTable."\" width=\"750\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
  <tr>
  <td style=\"".$style_FormHeaderTD."\"><font style=\"".$style_FormHeaderFONT."\">$tablefullname</font></td>
 </tr>
</table>
<table style=\"".$style_FormTable."\" width=\"750\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

     $tablefields = $this->table_fields($table);

     if (is_array($tablefields)){

      for ($field_num=0;$field_num < count($tablefields);$field_num++){

       $field = $tablefields[$field_num][0];
       $field_val = get_param($field);
       $za_namer = $tablefields[$field_num][1];
       $canbenull = $tablefields[$field_num][7];

       if ($field_val != NULL){

        $form .= "<input type=hidden name=$field value=$field_val>Kakunin: $za_namer -> $field_val <BR>";

        } else {// end if fieldval
        // Check if allowed to be null

        if ($canbenull == 'NOTNULL'){

         $form .= "<font color=red>Field: $za_namer ($field) can NOT be NULL<BR>";
         $ng = 1;

         } // if can't be null

        } // end if canbenull

       } // end for loop
 
      } // end if is_array

    break; // end kakunin action
    #
    ############################
    # Process
    case 'process':

     $form_header = "<form name=\"form_$tablename\" method=\"POST\" action=\"Body.php\"><input type=hidden name=tbl value=$table><input type=hidden name=action value=view>
 <table style=\"".$style_FormTable."\" width=\"750\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
  <tr>
  <td style=\"".$style_FormHeaderTD."\"><font style=\"".$style_FormHeaderFONT."\">$tablefullname</font></td>
 </tr>
</table>
<table style=\"".$style_FormTable."\" width=\"750\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

     $tablefields = $this->table_fields($table);

     if (is_array($tablefields)){

      $insertvalues = "";

      for ($field_num=1;$field_num < count($tablefields);$field_num++){

       $field = $tablefields[$field_num][0];
       $field_val = get_param($field);
       $za_namer = $tablefields[$field_num][1];
       $canbenull = $tablefields[$field_num][7];

       if ($field_val != NULL){

        //$form .= "Kakunin: $za_namer ($field) $field_val <BR>";
        // Collect SQL for INSERT
        if ($field_num==1){ // first item
         $insertkeys = "($field";
         $insertvalues = "('".$field_val."'";
         } else {
         $insertkeys .= ",".$field;
         $insertvalues .= ",'".$field_val."'";
         }

        } else {// end if fieldval
        // Check if allowed to be null

         if ($field_num==1){ // first item
          $insertkeys = "(".$field;
          $insertvalues = "('".$field_val."'";
          } else {
          $insertkeys .= ",".$field;
          $insertvalues .= ",NULL";
          }

        } // end if canbenull

       } // end for loop
    
      $insertSQL = "INSERT INTO $tablename $insertkeys) VALUES $insertvalues)";

      $actions_db = new DB_Sql();
      $actions_db->Database = DATABASE_NAME;
      $actions_db->User     = DATABASE_USER;
      $actions_db->Password = DATABASE_PASSWORD;
      $actions_db->Host     = DATABASE_HOST;

      $actions_db->query($insertSQL);

      //$form = $insertSQL;
      $form = "<P>Record successfully added..";

      } // end if is_array

    break; // end Edit action
    #
    ############################
    # Process-Edit
    case 'process-edit':

     $form_header = "<form name=\"form_$tablename\" method=\"POST\" action=\"Body.php\">
<input type=hidden name=do value=$table>
<input type=hidden name=action value=view>
 <table style=\"".$style_FormTable."\" width=\"750\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">
  <tr>
  <td style=\"".$style_FormHeaderTD."\"><font style=\"".$style_FormHeaderFONT."\">$tablefullname</font></td>
 </tr>
</table>
<table style=\"".$style_FormTable."\" width=\"750\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

     $tablefields = $this->table_fields($table);

     if (is_array($tablefields)){

      $insertvalues = "";

      for ($field_num=0;$field_num < count($tablefields);$field_num++){

       $primary = $tablefields[0][0];
       $primary_val = get_param($primary);
       $field = $tablefields[$field_num][0];
       $field_val = get_param($field);
       $za_namer = $tablefields[$field_num][1];
       $canbenull = $tablefields[$field_num][7];

       if ($field_val != NULL){

        //$form .= "Kakunin: $za_namer ($field) $field_val <BR>";
        // Collect SQL for INSERT
        if ($field_num==0){ // first item
         $insertkeys = "($field";
         $insertvalues = "`$field` = '".$field_val."'";
         } else {
         $insertkeys .= ",".$field;
         $insertvalues .= ",`$field` = '".$field_val."'";
         }

        } else {// end if fieldval
        // Check if allowed to be null

        if ($field_num==0){ // first item
         $insertkeys = "(".$field;
         $insertvalues = "`$field` = '".$field_val."'";
         } else {
         $insertkeys .= ",".$field;
         $insertvalues .= ",`$field` = NULL";
         }

        } // end if canbenull

       } // end for loop
    
      $insertSQL = "UPDATE $tablename SET $insertvalues WHERE $primary=$primary_val LIMIT 1";

      $actions_db = new DB_Sql();
      $actions_db->Database = DATABASE_NAME;
      $actions_db->User     = DATABASE_USER;
      $actions_db->Password = DATABASE_PASSWORD;
      $actions_db->Host     = DATABASE_HOST;

      $actions_db->query($insertSQL);

      //$form = $insertSQL;
      $form = "<P>Record successfully updated..";

      } // end if is_array

     break; // end Process-Edit action
     
   #
   ############################
   } // end action switch

   switch ($action){

    ###############################

    case 'add':
    case 'do_login':
    case 'custom':
    case 'register':
    case 'forgotten':
    case 'add_member':
    case 'Share':
    case 'search':
    case 'send_internal':
    case 'send_message':
    case 'request_ownership_transfer':
    case 'Contact':
    case 'notifications':

     switch ($action){

      case 'add':
      case 'add_member':      	
       $button = $strings["action_add"];
      break;
      case 'Share':
       $button = "Share";
      break;
      case 'send_internal':
       $button = $strings["action_send_message"];
      break;
      case 'request_ownership_transfer':
       $button = "Request";
      break;
      case 'Contact':
       $button = $strings["Contact"];
      break;

            }

     $button_style ='<style type=\"text/css\">
        .css3button {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #050505;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#ebebeb 50%,
		#dbdbdb 50%,
		#b5b5b5);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#ffffff),
		color-stop(0.50, #ebebeb),
		color-stop(0.50, #dbdbdb),
		to(#b5b5b5));
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	border: 1px solid #949494;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.2),
		0px 1px 0px rgba(255,255,255,1);
}
</style>';

     if (!$button_text){
        $button_text = $button;
        }

     if ($button_text == NULL){
        $button_text = "Add";
        }

     if ($button_text != 'None'){

        $the_button = $button_style."<div><button type=\"button\" name=\"button\" value=\"".$button_text."\" onclick=\"".$scroller."get(this.form);return false\" class=\"css3button\">".$button_text."</div>"; 

        }

     $formend = "<tr>
 <td>
    <div style=\"width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; width: 115px;height:5;border-radius: 5px; padding: 5px 5px 5px 5px;\">
   <input type=hidden id=action name=action value=$action>
   <input type=hidden id=next_action name=next_action value=$next_action>
   <input type=hidden id=do name=do value=$do>
   <input type=hidden id=pg name=pg value=Body>
   <input type=hidden id=pc name=pc value=$portalcode>
   <input type=hidden id=sv name=sv value=$sendvars>
  </div>
        <div style=\"float: right; width:".$tdlabelwidth."px;height:5;border-radius: 5px; padding: 5px 5px 5px 5px;\">
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>
</table>".$the_button."
</form>";

    break;
    ###############################
    case 'select':

     $formend = "<tr>
 <td>
    <div style=\"width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; width: 115px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
   <input type=hidden id=next_action name=next_action value=$next_action>
   <input type=hidden id=do name=do value=$do>
   <input type=hidden id=rp name=rp value=$portalcode>
  </div>
        <div style=\"float: right; width:".$tdlabelwidth."px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>
</table>
</form>";

    break;
    ###############################
    case 'edit':

    if ($button_text != NULL){
       $button = $button_text;
       } else {
       $button = $strings["action_edit"];
       }

     if ($button_text == NULL){
        $button_text = "Edit";
        }


     $formend = "<tr>
 <td>
    <div style=\"width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; width: 115px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
   <input type=hidden id=next_action name=next_action value=$next_action>
   <input type=hidden id=do name=do value=$do>
   <input type=hidden id=rp name=rp value=$portalcode>
  </div>
        <div style=\"float: right; width:".$tdlabelwidth."px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>
</table>".$button_style."
<div><button type=\"button\" name=\"button\" value=\"".$button."\" onclick=\"get(this.form);return false\" class=\"css3button\">".$button_text."</div>
</form>";

/*
<div style=\"margin-left:0px;float: left; background:#e6ebf8; width: 100px;height:100%;border:1px dotted #555;border-radius: 15px; padding: 5px 5px 5px 5px;\"><a class=\"regobutton\" input type=\"button\" name=\"button\" value=\"".$button."\" onclick=\"loader('".$BodyDIV."');get(this.form);return false\"></div>
*/

    break;
    ###############################
    case 'kakunin':

     if ($ng != 1){
      // OK to send
      $formend = "<input type=hidden name=menu value=$sent_menu><input type=hidden name=submenu value=$tablename><tr><td width=\"$tdwidth\"></td>
      <td width=\"$tdvaluewidth\"> 
        <input type=\"submit\" name=\"$tablename\" value=\"Deliver\">
      </td>
    </tr></table></form>";
      } else {
      //$formend = returnbutton();
      $formend = "<P><div style=\"margin-left:0px;float: left; background:#e6ebf8; width: 100px;height:100%;border:1px dotted #555;border-radius: 15px; padding: 5px 5px 5px 5px;\"><input type=\"button\" value=\"<-<- Back\" onClick=\"history.go(-1)\" name=\"button\"></div>";

      } // end if NG

    break;
    ###############################
    case 'view':
    
     $formend = "<tr>
 <td>
    <div style=\"width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; width:".$tdlabelwidth."px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
  </div>
        <div style=\"float: right; width:".$tdvaluewidth."px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
        </div>
    </div>
 </td>
</tr>
</table>";

    if ($provide_add_button == 1){

       $formend .= "<BR><img src=images/blank.gif width=".$divwidth." height=5><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$field_id."&valuetype=".$valtype."');return false\" class=\"css3button\"><B>".$strings["action_addNew"] ."</B></a></form><BR><img src=images/blank.gif width=".$divwidth." height=20>";

     } // end add button
 
    break;
    ###############################
    case 'view_list':
    
     $formend = "</table><P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=&valuetype=');return false\" class=\"css3button\"><B>".$strings["action_addNew"] ."</B></a>";

    break;
    ###############################

   } // end formend switch

  } // end if_array

  $show_form = "<div style=\"padding-left:1%;\">".$form_header.$form.$formend."</div>";

  return $show_form;

 } // end function form_presentation

 # End Form Presentation Function
 ################################
 # Form Objects Function

 function form_objects ($do,$next_action,$valtype,$fieldname,$type,$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits){

  // Field ID - used when auto-creating fields from DB - such as CMV and Surveys

  global $portalcode,$strings,$portal_config;

  $selections = $object_bits[0];

  if ($thisvalue[10] != NULL){
     $action = $thisvalue[10]; // prep for custom action and next action
     }

  if ($action == NULL){
     $action = $next_action;
     }

  $formobject = "";

  #echo "Type: $type ";
 
  switch ($type){

   case 'autocomplete':

    $formobject = "<script src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
  <script src=\"js/auto-complete.js\"></script>";

    $formobject .= "<input type=\"text\" id=\"".$fieldname."\" placeholder=\"Search\" name=\"".$fieldname."\" value=\"".$thisvalue."\" size=\"".$textboxsize."\" maxlength=\"".$length."\">";

   break;
   case 'password':

    $formobject = "<input type=\"password\" id=\"".$fieldname."\" name=\"".$fieldname."\" value=\"".$thisvalue."\" size=\"".$textboxsize."\" maxlength=\"".$length."\">";

   break;
   case 'varchar':
   case 'internal_link':
   case 'external_link':

    $formobject = "<input type=\"text\" id=\"".$fieldname."\" name=\"".$fieldname."\" value=\"".$thisvalue."\" size=\"".$textboxsize."\" maxlength=\"".$length."\">";

   break;
   case 'decimal':

    $formobject = "<input type=\"text\" id=\"".$fieldname."\" name=\"".$fieldname."\" value=\"".$thisvalue."\" size=\"".$textboxsize."\" maxlength=\"".$length."\"> ".$strings["DecimalWarning"];

   break;
   case 'int':

    $formobject = "<input type=\"text\" id=\"".$fieldname."\" name=\"".$fieldname."\" value=\"".$thisvalue."\" size=\"".$textboxsize."\" maxlength=\"".$length."\"> ".$strings["IntegerWarning"];

   break;
   case 'percentage':

    $formobject = "<input type=\"text\" id=\"".$fieldname."\" name=\"".$fieldname."\" value=\"".$thisvalue."\" size=10 maxlength=10> ".$strings["PercentageWarning"];
   break;
   case 'hidden':

    $formobject = "<input type=\"hidden\" id=\"".$fieldname."\" name=\"".$fieldname."\" value=\"".$thisvalue."\">";

   break;
   case 'textarea':

    $formobject = "<textarea id=\"".$fieldname."\" name=\"".$fieldname."\"  cols=$textboxsize rows=$textareacols>".$thisvalue."</textarea>";

    $formobject .= "<script type=\"text/javascript\">
	CKEDITOR.replace('".$fieldname."');
        CKEDITOR.instances.$fieldname.setData( '".$fieldname."' );
</script>";

   break;
   case 'datetime':

    $formobject = "<input type=\"text\" id=\"".$fieldname."\" name=\"".$fieldname."\"  value=\"".$thisvalue."\" size=\"".$textboxsize."\" maxlength=\"".$length."\"> ".$strings["DateTimeWarning"];

   break;
   case 'checkbox':

    switch ($next_action){

     case 'process':
     case ($next_action != 'view'):

      if ($thisvalue==1){ 
         $formobject = "<input type=\"checkbox\" name=\"".$fieldname."\" id=\"".$fieldname."\" value=\"1\" checked>";
         } else {
         $formobject = "<input type=\"checkbox\" name=\"".$fieldname."\" id=\"".$fieldname."\" value=\"1\">";
         }

     break;
     case 'view':

      if ($thisvalue==1){ 
         $formobject = "Yes";
         } else {
         $formobject = "No";
         }

     break;
 
    }

   break;
   case 'yesno':

    switch ($next_action){

     case 'process':
     case ($next_action != 'view'):

      $dd_pack['0']='No';
      $dd_pack['1']='Yes';

      $formobject = $this->dropdown ($next_action, $dd_pack, $thisvalue, $fieldname, $object);

     break;
     case 'view':

      if ($thisvalue==1){ 
         $formobject = "Yes";
         } else {
         $formobject = "No";
         }

     break;
 
    }

   break;
   case 'timerange':

    switch ($next_action){

     case 'process':

      $times = "";
      $times = array();
      $second_cnt = "00";

      for ($hour_cnt=0;$hour_cnt <=23;$hour_cnt++){
          if (strlen($hour_cnt)==1){
             $hour_cnt = "0".$hour_cnt;
             }
          for ($min_cnt=0;$min_cnt <= 59;$min_cnt++){
              if (strlen($min_cnt)==1){
                 $min_cnt = "0".$min_cnt;
                 }
/*
              for ($second_cnt=0;$second_cnt <= 59;$second_cnt++){
                  if (strlen($second_cnt)==1){
                     $second_cnt = "0".$second_cnt;
                     }
*/
//              $dd_pack["$hour_cnt:$min_cnt:$second_cnt"] = "$hour_cnt:$min_cnt:$second_cnt";
              $dd_pack["$hour_cnt:$min_cnt"] = "$hour_cnt:$min_cnt";

//                }

              }
          }
/*
      foreach ($times as $key=>$time){
//              list($hour,$minute,$second) = explode(":", $time);
              //list($hour,$minute) = explode(":", $time);
              foreach ($times as $nextkey=>$nexttime){
//                      list($nexthour,$nextminute,$nextsecond) = explode(":", $nexttime);
                      //list($nexthour,$nextminute) = explode(":", $nexttime);
//                      $combo_id = $hour.":".$minute."_".$nexthour.":".$nextminute;
//                      $combo_name = "Between: ".$hour.":".$minute." and ".$nexthour.":".$nextminute;
                      $combo_id = $time."_".$nexttime;
                      $combo_name = "Between: ".$time." and ".$nexttime;
                      $dd_pack[$combo_id]=$combo_name;
                      }
              }
*/

      $formobject = $this->dropdown ($next_action, $dd_pack, $thisvalue, $fieldname, $object);

     break;
     case 'view':

      $times = $this->timeslist();


      $formobject = $this->dropdown ($next_action, $dd_pack, $thisvalue, $fieldname, $object);

     break;
 
    }

   break;
   case 'dayrange':

    switch ($next_action){

     case 'process':

      $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');

      foreach ($days as $key=>$day){
              foreach ($days as $nextkey=>$nextday){
                      $combo_id = $day."_".$nextday;
                      $combo_name = "Between: ".$day." and ".$nextday;
                      $dd_pack[$combo_id]=$combo_name;
                      }
              }

      $formobject = $this->dropdown ($next_action, $dd_pack, $thisvalue, $fieldname, $object);

     break;
     case 'view':

      $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');

      foreach ($days as $key=>$day){
              foreach ($days as $nextkey=>$nextday){
                      $combo_id = $day."_".$nextday;
                      $combo_name = "Between: ".$day." and ".$nextday;
                      $dd_pack[$combo_id]=$combo_name;
                      }
              }

      $formobject = $this->dropdown ($next_action, $dd_pack, $thisvalue, $fieldname, $object);

     break;
 
    }

   break;
   case 'radio':

    switch ($next_action){

     case 'process':

      if ($thisvalue==1){ 
         $formobject = "<input type=\"radio\" name=\"".$fieldname."\" id=\"".$fieldname."\" value=\"1\" checked>";
         } else {
         $formobject = "<input type=\"radio\" name=\"".$fieldname."\" id=\"".$fieldname."\" value=\"1\">";
         }

     break;
     case 'view':

      if ($thisvalue==1){ 
         $formobject = "Yes";
         } else {
         $formobject = "No";
         }

     break;
 
    }

   break;
   case 'upload':

     $formobject = "<link rel=\"stylesheet\" type=\"text/css\" href=\"uploader/css/style.css\" media=\"all\" /> 
      <div id=\"uploader_div\"></div>
      <script type=\"text/javascript\">
      $('#uploader_div').ajaxupload({
	//remote upload path, can be set also in the php upload script
	remotePath : 'uploads/', 
	//php/asp/jsp upload script
	url: 'upload.php', 
	//flash uploader url for not html5 browsers
	flash: 'uploader.swf', 
	//other user data to send in GET to the php script
	data: '', 
	//set asyncron upload or not
	async: true, 
	//max number of files can be selected
	maxFiles: 9999,
	//array of allowed upload extesion, can be set also in php script 
	allowExt:[], 
	//function that triggers every time a file is uploaded
	success:function(fn){},
	//function that triggers when all files are uploaded
	finish:	function(file_names, file_obj){},
	//function that triggers if an error occuors during upload,
	error:	function(err, fn){},
	//start plugin enable or disabled
	enable:	true,
	//default 1Mb,if supported send file to server by chunks
	chunkSize:1048576,
	//max parallel connection on multiupload recomended 3, firefox 
	//support 6, only for browsers that support file api
	maxConnections:3,
	//back color of drag & drop area, hex or rgb
	dropColor:'red',
	//set the id or element of area where to drop files. default self
	dropArea:'self',
	//if true upload will start immediately after drop of files 
	//or select of files
	autoStart:false,
	//max thumbnial height if set generate thumbnial of images 
	//on server side			
	thumbHeight:0,
	//max thumbnial width if set generate thumbnial of images
	//on server side
	thumbWidth:0,
	//set the post fix of generated thumbs, default filename_thumb.ext
	thumbPostfix:'_thumb',
	//set the path here thumbs should be saved, if empty path
	//setted as remotePath
	thumbPath:'',
	//default same as image, set thumb output format, jpg, png, gif	
	thumbFormat:'',
	//max file size of single file,
	maxFileSize:'10M',
	//integration with some form, set the form selector or object, 
	//and upload will start on form submit
	form:null,
	//event that runs before submiting a form
	beforeSubmit:function(file_names, file_obj, formsubmitcall){
		formsubmitcall.call(this);
	},
	//if true allow edit file names before upload, by dblclick
	editFilename:false,
	//set if need to sort file list, need jquery-ui (not working)
	sortable:false,
	//this function runs before upload start for each file, 
	//if return false the upload does not start
	beforeUpload:function(filename, file){return true;},
	//this function runs before upload all start, can be good 
	//for validation
	beforeUploadAll:function(files){return true;},
	//function that trigger after a file select has been made, 
	//paramter total files in the queue
	onSelect: function(files){},
	//function that trigger on uploader initialization. Usefull 
	//if need to hide any button before uploader set up, 
	//without using css
	onInit:	function(AU){},
	//set regional language, default is english, 
	//avaiables: sq_AL, it_IT
	language:	'auto',
	//experimental feature, works on google chrome, for upload 
	//an entire folder content
	uploadDir:false,
	//if true remove the file from the list after has been 
	//uploaded successfully
	removeOnSuccess:false,
	//if true remove the file from the list if it has 
	//errors during upload
	removeOnError:false,
	// tell if to show info upload speed, or where to 
	//show the infos
	infoBox:false,
	//tell if to use bootstrap for theming buttons
	bootstrap:false
});
</script>		

";

/*
    $formobject = "<script type=\"text/javascript\">
$('#uploader_div').ajaxupload({
	url:'upload.php',
	remotePath:'example1/',
	onInit: function(AU){
		AU.uploadFiles.hide();//Hide upload button
		AU.removeFiles.hide();//hide remove button
	}
});
</script>
<script>
	$('#button1').click(function(){
		$('#uploader_div').ajaxupload('start');
	});
	
	$('#button2').click(function(){
		var files = $('#uploader_div').ajaxupload('getFiles');
		var names = [];
		var size = [];
		var ext = [];
		for(var i = 0; i<files.length; i++){
			names.push(files[i].name);
			size.push(files[i].size);
			ext.push(files[i].ext);
		}
		alert( names );
	});
		
	$('#button3').click(function(){
		$('#uploader_div').ajaxupload('clear');
	});
</script>
<div id=\"uploader_div\"></div>
<input type=\"button\" class=\"btn btn-primary\" id=\"button1\" value=\"Start Upload\" />
<input type=\"button\" class=\"btn btn-success\" id=\"button2\" value=\"Get selected files\" />
<input type=\"button\" class=\"btn btn-success\" id=\"button3\" value=\"Clear files\" />
";
*/

/*
    $size_limit = "yes"; //do you want a size limit yes or no.
    $limit_size = 50000000; //How big do you want size limit to be in bytes
    $limit_ext = "yes";
    $ext_count = "11"; //total number of extensions in array below 
    $extensions = array(".gif", ".JPEG", ".jpg", ".jpeg", ".png", ".wmv", ".mov", ".rm", ".mpeg", ".mpg", ".MPEG"); 

        if (($limit_size == "") or ($size_limit != "yes")) {
            $limit_size = "any size";
            } else {
            $limit_size .= " bytes";
            }

        if (($extensions == "") or ($extensions == " ") or ($ext_count == "0") or ($ext_count == "") or ($limit_ext != "yes") or ($limit_ext == "")) {
           $extensions = "any extension";
           } else {
           $ext_count2 = $ext_count+1;
           for ($counter=0; $counter<$ext_count; $counter++) {
               $extensions = "&nbsp; $extensions[$counter]";
               }
           }
*/
/*
    $formobject = "<font size=\"2\">The following restrictions apply:</font><P>
      <ul type=\"square\">
       <li><font size=\"2\"><B>File Requirements/Limits:</B> [".$extensions."]</font></li>
        <li><font size=\"2\"><B>Maximum file size:</B> ".$limit_size."</font></li>
        <li><font size=\"2\"><B>No spaces in the filename</B></font></li>
        <li><font size=\"2\"><B>Filename cannot contain illegal characters and MUST be in ENGLISH (/,*,\,etc)</B></font></li>
       </ul>
<input type=\"file\" name=\"".$fieldname."\" id=\"".$fieldname."\" size=\"30\" style=\"font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1\"><br>    
<INPUT TYPE=\"hidden\" name=\"MAX_FILE_SIZE\" value=$limit_size>
<INPUT TYPE=\"hidden\" NAME=\"i\" VALUE=$item>
<INPUT TYPE=\"hidden\" name=\"upload\" value=\"true\">";
*/

//    $formobject = "<iframe src='Uploader.php' width=450 height=300 scroll=auto></iframe>";

//    $formobject = "<input name=\"".$fieldname."\" id=\"".$fieldname."\" type=\"file\"/><br/>";

    $baseurl = $portal_config['portalconfig']['baseurl'];
    $portal_email = $portal_config['portalconfig']['portal_email'];
    $galleryurl = $baseurl."gallery";
//    $formobject = "Please use: <a href=\"".$galleryurl."\" target=\"gallery\">".$galleryurl."</a> (will open in a new window) - then come back to this page and select Gallery to then select the uploaded image(s). Only validated members and journalists can receive a Gallery account. Please contact: ".$portal_email;

$ssss = <<< XXXXX

<div id="manual-fine-uploader"></div>
<div id="triggerUpload" class="btn btn-primary" style="margin-top: 10px;">
  <i class="icon-upload icon-white"></i> Upload Now
</div>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/fineuploader-3.5.0.js"></script>

<script>
  $(document).ready(function() {
    var manualuploader = new qq.FineUploader({
      element: $('#manual-fine-uploader')[0],
      request: {
        endpoint: 'server/handleUploads'
      },
      autoUpload: false,
      text: {
        uploadButton: '<i class="icon-plus icon-white"></i> Select Files'
      }
    });
 
    $('#triggerUpload').click(function() {
      manualuploader.uploadStoredFiles();
    });
  });
</script>

XXXXX;

    $content_sendvars = "Uploader@".$lingo."@".$do."@".$action."@".$val."@".$valtype."@".$sess_contact_id."@".$sess_account_id;
    $content_sendvars = $this->encrypt($content_sendvars);
    $formobject =  "<iframe src='tr.php?cn=".$content_sendvars."' height=200 width=98%></iframe>";

   break;
   case 'dropdown':
   case 'dropdown_gallery':
   case 'dropdown_jumper':
   case 'dropdown_jaxer':
   case 'file_jaxer':

   // This value contains the options
   $dropdowntype = $thisvalue[0];
   // $reltablename = $thisvalue[1]; determined by type
   $za_primary = $thisvalue[2];
   $za_namer =  $thisvalue[3];
   $exceptions = $thisvalue[4];

   if ($exceptions != NULL){
      $query = " WHERE ".$exceptions;
      } else {
      $query = "";
      } 

   $zisvalue = $thisvalue[5];
   $object = $thisvalue[6];

   $dd_pack = "";
   
   switch ($dropdowntype){
    
    case 'db':

     #echo "Here!";

     global $db;
     
     if ($selections == NULL){
        $selections = "*";
        }

     $reltablename = $thisvalue[1];
     $query = "SELECT $selections FROM $reltablename $query ";

     #echo $query;

     $za_list = $db->query($query);
     
     $dropcnt = 0;     
     while ($za_row = mysql_fetch_array ($za_list)) {
      
       $za_id = $za_row[$za_primary];
       $za_name = $za_row[$za_namer];
       $dd_pack[$za_id] = $za_name;

/*
       if ($selections != "*"){
          echo "ID: ".$za_id." ".$za_name."<BR>";
          }
*/
          $dropcnt++;
       
       } // end while     
     
    break;
    case 'list':
     $dd_pack = $thisvalue[1];
     $reltablename = $thisvalue[7];
     if ($thisvalue[8] != NULL){
        $do = $thisvalue[8];
        }

     $select_type = $thisvalue[10];
     if (!$select_type){
        $select_type = "checkbox";
        }

    break;
    
   } // end db type switch

   switch ($type){

    case 'dropdown_gallery':

     $val = $thisvalue[9];
     $formobject = $this->dropdown_gallery($dd_pack, $zisvalue, $fieldname,$val,$select_type);

    break;
    case 'dropdown_jumper':

     $val = $thisvalue[9];

     $formobject = $this->dropdown_jumper($do,$next_action,$valtype,$dd_pack, $zisvalue, $fieldname,$val);

    break;
    case 'dropdown':

     $formobject = $this->dropdown($next_action,$dd_pack, $zisvalue, $fieldname,$object);

     #echo "$next_action,$dd_pack, $zisvalue, $fieldname,$object";
     #var_dump($dd_pack);

    break;
    case 'dropdown_jaxer':

     if ($thisvalue[8] != NULL){
        $do = $thisvalue[8];
        }

     $val = $thisvalue[9];
     $params = $thisvalue[10];
     $formobject = $this->dropdown_jaxer($do,$next_action,$valtype,$dd_pack, $zisvalue, $fieldname,$reltablename,$val,$params);

    break;
    case 'file_jaxer':

     if ($thisvalue[8] != NULL){
        $do = $thisvalue[8];
        }

     $val = $thisvalue[9];
     $params = $thisvalue[10];
     $formobject = $this->file_jaxer($do,$next_action,$valtype,$dd_pack, $zisvalue, $fieldname,$reltablename,$val,$params);

    break;

   } // end dropdown type switch

   break;

  } // end switch

  return $formobject;

 } // end function form_objects

 # End Form Objects Function
 ################################
 # Form Fill Data Function

 function fill_data ($action,$next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params,$extra_form_params){

  global $portalcode,$strings,$portal_config,$BodyDIV,$skinfont;

  if ($extra_form_params[0] != NULL){
     $BodyDIV = $extra_form_params[0];
     }

  #echo $BodyDIV;

 //echo "<P> $action,$next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params <P>";

  $header_color = $portal_config['portalconfig']['portal_header_color'];
  $body_color = $portal_config['portalconfig']['portal_body_color'];
  $skinfont = "WHITE";

  $formtr = "";

  for ($table_fields_cnt=0;$table_fields_cnt < count($table_fields);$table_fields_cnt++){
      
/*
    $tablefields[$tblcnt][0] = 'id'; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 1; // is_primary
*/
      if ($table_fields[$table_fields_cnt][2] == 1 && ($table_fields[$table_fields_cnt][0] == 'id' || $table_fields[$table_fields_cnt][0] == 'id_c')){

         $this_id = $table_fields[$table_fields_cnt][21];

         }

      } // end for


  for ($table_cnt=0;$table_cnt < count($table_fields);$table_cnt++){

   $fieldval = "";
   $fieldname = $table_fields[$table_cnt][0];
   $fullname = $table_fields[$table_cnt][1];   
   $fieldval = $table_fields[$table_cnt][21];
   $thisfieldval = $fieldval;
   $type = $table_fields[$table_cnt][5];
   $dropdownpack = $table_fields[$table_cnt][9];

   # Additional bits after field value (Images for statuses)
   $field_extras = $table_fields[$table_cnt][43]; // show extra after field

   // Default Background
   $formobjectheight = "15px";
//   $background = "#FF8040";

   switch ($type){
    
    case 'yesno':
    
     if ($fieldval == 1){
      $fieldval = 'Yes';
      } else {
      $fieldval = 'No';
      }
    
    break;
    case 'external_link':
    
     $link = $dropdownpack[0];
     $link_name = $dropdownpack[1];
     $link_window = $dropdownpack[2];
     $fieldval = "<a href=\"".$link."\" target=\"".$link_window."\">".$link_name."</a>";
     
    break;  
    case 'internal_link':
    
     $fieldval = $dropdownpack[0];
     
    break;  
    case 'image':
    
     $fieldval = "<img src=".$fieldval." width=16>";
     
    break;  
    case 'checkbox':

     switch ($next_action){

      case 'process':

      if ($fieldval==1){ 
         $fieldval = "<input type=\"checkbox\" name=\"".$fieldname."\" id=\"".$fieldname."\" value=\"1\" checked>";
         } else {
         $fieldval = "<input type=\"checkbox\" name=\"".$fieldname."\" id=\"".$fieldname."\" value=\"1\">";
         }

      break;
      case 'view':

      if ($fieldval==1){ 
         $fieldval = "Yes";
         } else {
         $fieldval = "No";
         }

      break;
 
     }

    break;
    case 'varchar':
    case 'int':
    case 'decimal':
    case 'percentage':
    
     $background= "white";
     
    break;
    case 'varchar_inlinejax':

     $fieldval = "<span id=\"".$fieldname."\" class=\"editText\">".$fieldval."</span>";

    break;
    case 'textarea':
    
     $formobjectheight = "140px";
     
    break;
    
    } // end type switch
    
    // if (($table_fields[1][0] != NULL) && ($table_fields[$table_cnt][4]==1)){
    // Usually in a form will show a link to click to edit - will later add ajax to change..
    
   // echo $fullname." IS NAME: ".$table_fields[$table_cnt][4]."<BR>";

   if ($table_fields[$table_cnt][4]==1 && ($admin_status == 1 || $admin_status == 2 || $admin_status == 3)){

      //echo "pc=".$portalcode."&do=".$do."&action=edit&value=".$this_id."&valuetype=".$valtype.$edit_link_params;

      $fieldval = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$this_id."&valuetype=".$valtype.$edit_link_params."&sendiv=".$BodyDIV."');return false\"><font color=red><B>".$strings["action_edit"].": ".$fieldval."</B></font></a>";

//      echo "<P> DO $do ID $this_id VALTYPE: $valtype Admin: $admin_status <P>";

      } else {
      // May need to change to edit or view depending on the presentation type
      $fieldval = $fieldval; 

      }

   if ($dropdownpack != NULL && ($type == 'dropdown' || $type == 'dropdown_jaxer')){
    // This value contains the options
    $dropdowntype = $dropdownpack[0];
    // $reltablename = $thisvalue[1]; determined by type
    $za_primary = $dropdownpack[2];
    $za_namer =  $dropdownpack[3];
    $exceptions = $dropdownpack[4];
    $zisvalue = $dropdownpack[5];
    $object = $dropdownpack[6];

    if ($exceptions != NULL){
       $query = " WHERE ".$exceptions;
       } else {
       $query = "";
       } 

    $dd_pack = "";
   
    switch ($dropdowntype){

     case 'dropdown_gallery':

     $select_type = $dropdownpack[10];
     if (!$select_type){
        $select_type = "checkbox";
        }

//      $fieldval = $this->dropdown_gallery($do,$next_action,$valtype,$dropdownpack[1], $zisvalue, $fieldname);
      $fieldval = $this->dropdown_gallery($dropdownpack, $zisvalue, $fieldname,$select_type);

     break;
     case 'db':
    
      global $db;
      
      $reltablename = $dropdownpack[1];

//     $selections = $table_fields[$table_cnt][20];

     if ($selections == NULL){
        $selections = "*";
        }

      $za_list = $db->query("SELECT $selections FROM $reltablename $query ");
     
      $dropcnt = 0;     
      while ($za_row = mysql_fetch_array ($za_list)) {
      
       $za_id = $za_row[$za_primary];
       $za_name = $za_row[$za_namer];
       $dd_pack[$za_id] = $za_name;
       
          $dropcnt++;
       
       } // end while     
     
     break;
     case 'list':
      $dd_pack = $dropdownpack[1];
     break;
    
    } // end db type switch

    $fieldval = $this->dropdown($action,$dd_pack, $zisvalue, $fieldname,$object); 
   
   } // end if dropdown
   
   /*
   // Need to update this with the dropdown params
   if ($relatedtable != NULL){
    $reltabler = $this->tables($relatedtable);
    $reltablename = $reltabler[$relatedtable][0];
    $reltable_fields = $reltabler[$relatedtable][2];

    if (is_array($reltable_fields)){

     $rel_table_primary = $reltable_fields[0][0];
     // $rel_table_fld_name = $reltable_fields[1][0];
     for ($reltable_cnt=0;$reltable_cnt < count($reltable_fields);$reltable_cnt++){
      // loop through to find the namevalue
      if ($reltable_fields[$reltable_cnt][4]==1){
       $za_namer = $reltable_fields[$reltable_cnt][0];
       }
      } // end loop for name

     $rel_fld = dlookup("$reltablename", "$za_namer", "$rel_table_primary=$fieldval");
   
     } // end if is_array

    $fieldval = "<a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=GovernmentRoles&action=view&value=".$this_id."&valuetype=edit');return false\">".$fieldval."</a>";
    
    } // end if related table
*/
   // Add any special view features for this table
   //$fieldval .= $this->field_features($fieldname, $thisfieldval,$this_id);
   switch ($list_type){
    
    case 'rows':
    
     if ($table_fields[$table_cnt][10] == 1){

        if ($table_fields[$table_cnt][5] == 'textarea'){
           $labelwidth = "95%";
           $labelheight = "15px";
           $divwidth = "95%";//"450px";
           $formobjectwidth = "95%";
           $formobjectheight = "100px";
           $fieldval = str_replace("\n", "<BR>", $fieldval);
           $fieldval = "<font size=2>".$fieldval."</font>";
           $labelmargins = "margin-left:0px;float:left;"; 
           $formobjectmargins = "margin-left:0px;float:left;"; 
           $breaker = "<img src=images/blank.gif width=80% height=10<BR>";
           $class = " class=\"ckeditor\" ";
           } else {
           $labelwidth = "80px";
           $labelheight = "15px";
           $divwidth = "95%";//"450px";
           $formobjectwidth = "74%";
           $formobjectheight = "15px";
           $labelmargins = "margin-left:0px;float:left;"; 
           $formobjectmargins = "margin-left:5px;float:left;"; 
           $breaker = "";
           $class = "";
           } 

     $formtr = "";

     if ($table_fields[$table_cnt][41] == 1){

        // Fliipfield
        $formtr = "
    <div style=\"width: ".$divwidth.";\">
        <div style=\"".$labelmargins."background:".$header_color.";width:".$labelwidth.";min-height:".$labelheight.";border-radius: 3px; padding: 5px 5px 5px 5px;\">
         <font color=$skinfont>$fieldval</font>$field_extras</div>$breaker
        <div style=\"".$formobjectmargins." background: ".$body_color.";width:".$formobjectwidth.";min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 3px; padding: 5px 5px 5px 5px;overflow:auto;\">
            <font color=$header_color>$fullname</font>
        </div>
    </div>";

         } else {

        $formtr = "
    <div style=\"width: ".$divwidth.";\">
        <div style=\"".$labelmargins."background:".$header_color.";width:".$labelwidth.";min-height:".$labelheight.";border-radius: 3px; padding: 5px 5px 5px 5px;\">
            <font color=$skinfont>$fullname</font></div>$breaker
        <div style=\"".$formobjectmargins." background: ".$body_color.";width:".$formobjectwidth.";min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 3px; padding: 5px 5px 5px 5px;overflow:auto;\">
            <font color=$header_color>$fieldval</font>$field_extras
        </div>
    </div>";

         } // end flipfield

      } else {// if to show in view

       $formtr = "";

      } 
      
     $form .= "<tr><td>".$formtr."</td></tr>";      
    
    break;
    case 'columns':
    
     if ($table_fields[$table_cnt][10] == 1){

        $formtr .= "<div style=\"margin-left:0px;float: left; background:".$body_color."; width: 95%;min-height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 5px 5px 5px 5px;\">$fieldval $field_extras</div>";

        } // if to show in view

     $form .= "<tr><td>".$formtr."</td></tr>";
    
    break;
    
   } // end switch
    

   } // end loop

  return $form;

 } // end function fill_data

 # End Fill Data Function
 ################################

 function qrcoder ($params){

  global $hostname;

  $type = $params[0];

  switch ($type){

   case 'email':

    $email = $params[1];
    $subject = $params[2];
    $body = $params[3];
    $subject = urlencode(mb_convert_encoding($subject, "UTF-8"));
    $body = urlencode(mb_convert_encoding($body, "UTF-8"));
    $qrcode = "<img src=\"qrcoder/qr_img.php?d=MAILTO:".$email."%0D%0ASUBJECT:".$subject."%0D%0ABODY:".$body."\">";

   break;
   case 'url':

    $url = $params[1];
    $url = urlencode($url);
    $qrcode = "<img src=\"qrcoder/qr_img.php?d=".$url."\">";
  
   break;

  } // end switch

 return $qrcode;  

 } # end qrcoder function

#
###########################
} // end funky class

########################
# Class Begins

class shared_api //
{

########################
# Saloob TV

 function get_info ($za_url){

  $xmlObj = new shared_XmlToArray($za_url);
  $arrayData = $xmlObj->createArray();
  $INFOList = $arrayData['saloobtv_response']['list'];
  if( is_array($INFOList) && sizeof($INFOList) > 0 ) {
   $INFOList = $INFOList[0]['content']; // the "real" list
                  } // end if array

 return $INFOList;

 } // end function

 // Shared Effects

 function shared_info ($za_url){

  $xmlObj = new shared_XmlToArray($za_url);
  $arrayData = $xmlObj->createArray();
  $INFOList = $arrayData['sharedeffects_response']['list'];
  if (is_array($INFOList) && sizeof($INFOList) > 0 ) {
     $INFOList = $INFOList[0]['content']; // the "real" list
     } // end if array

 return $INFOList;

 } // end function

} // end class

######################################################
#

class rest_api //
{

 function get_info ($za_url){

  $xmlObj = new shared_XmlToArray($za_url);
  $arrayData = $xmlObj->createArray();
  return $INFOList;

 } // end function

}

class shared_XmlToArray extends shared_api
{

 var $xml='';

 /**
 * Default Constructor
 * @param $xml = xml data
 * @return none
 */

 function shared_XmlToArray($xml_url)
 {

  $this->fetch_remote_page($xml_url);
 }
     


 /**
 * Fetch remote page                          
 * Attempt to retrieve a remote page, first with cURL, then fopen, then fsockopen
 * @param $url
 * @return $data = The remote page as a string
 */

 function fetch_remote_page( $url ) { 

  $data = '';
  if (extension_loaded('curl')) {
      $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec ($ch);
        curl_close ($ch);
    } elseif ( ini_get('allow_url_fopen') ) {
   // cURL not supported, try fopen
   $hf = fopen($url, 'r');
     for ($data =''; $buf=fread($hf,1024); ) {  //read the complete file (binary safe)
        $data .= $buf;
        }
      fclose($hf);
  } else {
   // As a last resort, try fsockopen
      $url_parsed = parse_url($url);
      if ( empty($url_parsed['scheme']) ) {
          $url_parsed = parse_url('http://'.$url);
      }

      $port = $url_parsed["port"];
      if ( !$port ) {
          $port = 80;
      }

      $path = $url_parsed["path"];
      if ( empty($path) ) {
              $path="/";
      }
      if ( !empty($url_parsed["query"]) ) {
          $path .= "?".$url_parsed["query"];
      }

      $host = $url_parsed["host"];
      $foundBody = false;

      $out = "GET $path HTTP/1.0\r\n";
      $out .= "Host: $host\r\n";
      $out .= "Connection: Close\r\n\r\n";

      if ( !$fp = @fsockopen($host, $port, $errno, $errstr, 30) ) {
          $error = $errno;
          $error .= $errstr;
          return $error;
      }
      fwrite($fp, $out);
      while (!feof($fp)) {
          $s = fgets($fp, 128);
          if ( $s == "\r\n" ) {
              $foundBody = true;
              continue;
          }
          if ( $foundBody ) {
              $body .= $s;
          } 
      }
      fclose($fp);

      $data = trim($body);
  }

    $this->xml = $data;

 }


 /**
 * _struct_to_array($values, &$i)
 *
 * This is adds the contents of the return xml into the array for easier processing.
 * Recursive, Static
 *
 * @access    private
 * @param    array  $values this is the xml data in an array
 * @param    int    $i  this is the current location in the array
 * @return    Array
 */

 function _struct_to_array($values, &$i)
 {
  $child = array();
  if (isset($values[$i]['value'])) array_push($child, $values[$i]['value']);

  while ($i++ < count($values)) {
   switch ($values[$i]['type']) {
    case 'cdata':
             array_push($child, $values[$i]['value']);
    break;

    case 'complete':
     $name = $values[$i]['tag'];
     if(!empty($name)){
     $child[$name]= ( isset($values[$i]['value']) ? $values[$i]['value'] : '' );
     if(isset($values[$i]['attributes'])) {
      $child[$name] = $values[$i]['attributes'];
     }
    }
           break;

    case 'open':
     $name = $values[$i]['tag'];
     $size = isset($child[$name]) ? sizeof($child[$name]) : 0;
     $child[$name][$size] = $this->_struct_to_array($values, $i);
    break;

    case 'close':
             return $child;
    break;
   }
  }
  return $child;
 }//_struct_to_array

 /**
 * createArray($data)
 *
 * This is adds the contents of the return xml into the array for easier processing.
 *
 * @access    public
 * @param    string    $data this is the string of the xml data
 * @return    Array
 */
 function createArray()
 {
  $xml    = $this->xml;

  $values = array();
  $index  = array();
  $array  = array();
  $parser = xml_parser_create();
  xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
  xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
  xml_parse_into_struct($parser, $xml, $values, $index);
  xml_parser_free($parser);
  $i = 0;
  $name = $values[$i]['tag'];
  $array[$name] = isset($values[$i]['attributes']) ? $values[$i]['attributes'] : '';
  $array[$name] = $this->_struct_to_array($values, $i);
  return $array;

 }//createArray


}//XmlToArray

###############################
# rest request

class RestRequest
{
	protected $url;
	protected $verb;
	protected $requestBody;
	protected $requestLength;
	protected $username;
	protected $password;
	protected $acceptType;
	protected $responseBody;
	protected $responseInfo;
	
	public function __construct ($url = null, $verb = 'GET', $requestBody = null)
	{
		$this->url				= $url;
		$this->verb				= $verb;
		$this->requestBody		= $requestBody;
		$this->requestLength	= 0;
		$this->username			= null;
		$this->password			= null;
		$this->acceptType		= 'application/json';
		$this->responseBody		= null;
		$this->responseInfo		= null;
		
		if ($this->requestBody !== null)
		{
			$this->buildPostBody();
		}
	}
	
	public function flush ()
	{
		$this->requestBody		= null;
		$this->requestLength	= 0;
		$this->verb				= 'GET';
		$this->responseBody		= null;
		$this->responseInfo		= null;
	}
	
	public function execute ()
	{
		$ch = curl_init();
		$this->setAuth($ch);
		
		try
		{
			switch (strtoupper($this->verb))
			{
				case 'GET':
					$this->executeGet($ch);
					break;
				case 'POST':
					$this->executePost($ch);
					break;
				case 'PUT':
					$this->executePut($ch);
					break;
				case 'DELETE':
					$this->executeDelete($ch);
					break;
				default:
					throw new InvalidArgumentException('Current verb (' . $this->verb . ') is an invalid REST verb.');
			}
		}
		catch (InvalidArgumentException $e)
		{
			curl_close($ch);
			throw $e;
		}
		catch (Exception $e)
		{
			curl_close($ch);
			throw $e;
		}
		
	}
	
	public function buildPostBody ($data = null)
	{
		$data = ($data !== null) ? $data : $this->requestBody;
		
		if (!is_array($data))
		{
			throw new InvalidArgumentException('Invalid data input for postBody.  Array expected');
		}
		
		$data = http_build_query($data, '', '&');
		$this->requestBody = $data;
	}
	
	protected function executeGet ($ch)
	{		
		$this->doExecute($ch);	
	}
	
	protected function executePost ($ch)
	{
		if (!is_string($this->requestBody))
		{
			$this->buildPostBody();
		}
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$this->doExecute($ch);	
	}
	
	protected function executePut ($ch)
	{
		if (!is_string($this->requestBody))
		{
			$this->buildPostBody();
		}
		
		$this->requestLength = strlen($this->requestBody);
		
		$fh = fopen('php://memory', 'rw');
		fwrite($fh, $this->requestBody);
		rewind($fh);
		
		curl_setopt($ch, CURLOPT_INFILE, $fh);
		curl_setopt($ch, CURLOPT_INFILESIZE, $this->requestLength);
		curl_setopt($ch, CURLOPT_PUT, true);
		
		$this->doExecute($ch);
		
		fclose($fh);
	}
	
	protected function executeDelete ($ch)
	{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		
		$this->doExecute($ch);
	}
	
	protected function doExecute (&$curlHandle)
	{
		$this->setCurlOpts($curlHandle);
		$this->responseBody = curl_exec($curlHandle);
		$this->responseInfo	= curl_getinfo($curlHandle);
		
		curl_close($curlHandle);
	}
	
	protected function setCurlOpts (&$curlHandle)
	{
		curl_setopt($curlHandle, CURLOPT_TIMEOUT, 10);
		curl_setopt($curlHandle, CURLOPT_URL, $this->url);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array ('Accept: ' . $this->acceptType));
	}
	
	protected function setAuth (&$curlHandle)
	{
		if ($this->username !== null && $this->password !== null)
		{
			curl_setopt($curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
			curl_setopt($curlHandle, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		}
	}
	
	public function getAcceptType ()
	{
		return $this->acceptType;
	} 
	
	public function setAcceptType ($acceptType)
	{
		$this->acceptType = $acceptType;
	} 
	
	public function getPassword ()
	{
		return $this->password;
	} 
	
	public function setPassword ($password)
	{
		$this->password = $password;
	} 
	
	public function getResponseBody ()
	{
		return $this->responseBody;
	} 
	
	public function getResponseInfo ()
	{
		return $this->responseInfo;
	} 
	
	public function getUrl ()
	{
		return $this->url;
	} 
	
	public function setUrl ($url)
	{
		$this->url = $url;
	} 
	
	public function getUsername ()
	{
		return $this->username;
	} 
	
	public function setUsername ($username)
	{
		$this->username = $username;
	} 
	
	public function getVerb ()
	{
		return $this->verb;
	} 
	
	public function setVerb ($verb)
	{
		$this->verb = $verb;
	} 

} // end rest request

# End Za API
########################

# End Functions
########################
?>