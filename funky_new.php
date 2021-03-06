<?php
##############################################
# Form Builder
# Author: Matthew Edmond, Saloob
# Date: 2011-02-24
# Page: funky.php
############################################## 
# Global Functions

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

class funky
{

################################
# Anonymity

    public function anonymity($sent_params){

    global $strings,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$anonymity_params;

    $contact = $sent_params[0];
    $do = $sent_params[1];

    $Anonymous = $anonymity_params[0];
    $Cloakname = $anonymity_params[1];
    $Fullname = $anonymity_params[2];
    $Nickname = $anonymity_params[3];

    $object_type = 'Contacts';
    $action = 'select_cstm';
    $params = array();
    $params[0] = "id_c='".$contact."'";
    $params[1] =  "";
    $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
    if (is_array($the_list)){
      
       for ($cnt=0;$cnt < count($the_list);$cnt++){

//           $contact_profile_id = $the_list[$cnt]['id'];
           $default_name_type_c = $the_list[$cnt]['default_name_type_c'];
           $social_network_name_type_c = $the_list[$cnt]['social_network_name_type_c'];
           $friends_name_type_c = $the_list[$cnt]['friends_name_type_c'];

           } // end for

       } else {

         // If haven't updated in their Profile - MUST keep as anonymous
         $default_name_type_c = $Anonymous;
         $social_network_name_type_c = $Anonymous;
         $friends_name_type_c = $Anonymous;

       } // end else if no profile settings

       // Get Real Name if not anonymous
    if (($default_name_type_c == $Cloakname || $social_network_name_type_c == $Cloakname || $friends_name_type_c == $Cloakname) || ($default_name_type_c == $Nickname || $social_network_name_type_c == $Nickname || $friends_name_type_c == $Nickname)){

       $object_type = 'Contacts';
       $action = 'select_cstm';
       $params = array();
       $params[0] = "id_c='".$contact."'";
       $params[1] =  "id_c,nickname_c,cloakname_c";
       
       $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
       if (is_array($the_list)){
      
          for ($cnt=0;$cnt < count($the_list);$cnt++){

              $nickname = $the_list[$cnt]['nickname_c'];
              $cloakname = $the_list[$cnt]['cloakname_c'];

              } // end for
      
          } // end if array

       } // end if 

    // Get Real Name if not anonymous

    if ($default_name_type_c == $Fullname || $social_network_name_type_c == $Fullname || $friends_name_type_c == $Fullname){

       $object_type = "Contacts";
       $action = "select_soap";
       $params = array();
       $params[0] = "contacts.id='".$contact."'"; // query
       $params[1] = array("first_name","last_name","description");
       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
       
       if (is_array($result)){

          for ($cnt=0;$cnt < count($result);$cnt++){

              $first_name = $result[$cnt]['first_name'];
              $last_name = $result[$cnt]['last_name'];
              $description = $result[$cnt]['description'];

              } // end for

          } // end if array

       } // end if Fullname

    $show_name = $strings["Anonymous"];

    switch ($social_network_name_type_c){

     case '':
     case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
      $show_name = $strings["Anonymous"];
     break;
     case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': // Full Name
      $show_name = $first_name." ".$last_name;
     break;
     case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': // Nickname
      $show_name = $nickname;
     break;
     case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': // Cloakname
      $show_name = $cloakname;
     break;

    }

    $anonymity_names['social_network_name'] = $show_name;
    $anonymity_names['social_network_name_anonymity'] = $social_network_name_type_c;

    switch ($default_name_type_c){

     case '':
     case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
      $show_name = $strings["Anonymous"];
     break;
     case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': // Full Name
      $show_name = $first_name." ".$last_name;
     break;
     case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': // Nickname
      $show_name = $nickname;
     break;
     case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': // Cloakname
      $show_name = $cloakname;
     break;

    }

    $anonymity_names['default_name'] = $show_name;
    $anonymity_names['default_name_anonymity'] = $default_name_type_c;

    switch ($friends_name_type_c){

     case '':
     case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
      $show_name = $strings["Anonymous"];
     break;
     case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': // Full Name
      $show_name = $first_name." ".$last_name;
     break;
     case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': // Nickname
      $show_name = $nickname;
     break;
     case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': // Cloakname
      $show_name = $cloakname;
     break;

    }

    $anonymity_names['friends_name'] = $show_name;
    $anonymity_names['friends_name_anonymity'] = $friends_name_type_c;

    return $anonymity_names;

    } // end function

# End Anonymity
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

   $childbits =0;

   for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

       $id = $sclm_rows[$cnt]['id'];
       $child_id = $sclm_rows[$cnt]['child_id'];

       if ($child_id){

          #echo "Had child $childbits <BR>";
          $children[$childbits] = $child_id;
          $childbits++;

          }

       $portal_account_id = $sclm_rows[$cnt]['account_id_c'];
       $admin_id = $sclm_rows[$cnt]['contact_id_c'];

       } // for

   $portal_bits['parent_account_id'] = $portal_account_id;
   $portal_bits['portal_account_id'] = $portal_account_id;
   $portal_bits['admin_id'] = $admin_id;
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
      $portal_type = "system";
      $sclm_params[0] = " deleted=0 ";
      } else {
      // Scalastica System Owner

      $sclm_object_type = "AccountRelationships";
      $sclm_action = "select";
      #$sclm_params[0] = " deleted=0 && account_id_c='".$account_id."' "; // Check if primary
      $sclm_params[0] = " deleted=0 && account_id1_c='".$portal_account_id."' "; // Check if under another and what the relationship is
      $sclm_params[1] = "*";
      $sclm_params[2] = "";
      $sclm_params[3] = "";
      $sclm_params[4] = "";

      $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

      if (is_array($sclm_rows)){      

       for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

           $id = $sclm_rows[$cnt]['id'];
           $name = $sclm_rows[$cnt]['name'];
           $date_entered = $sclm_rows[$cnt]['date_entered'];
           $date_modified = $sclm_rows[$cnt]['date_modified'];
           $modified_user_id = $sclm_rows[$cnt]['modified_user_id'];
           $created_by = $sclm_rows[$cnt]['created_by'];
           $description = $sclm_rows[$cnt]['description'];
           $deleted = $sclm_rows[$cnt]['deleted'];
           $parent_account_id = $sclm_rows[$cnt]['parent_account_id'];
           $child_account_id = $sclm_rows[$cnt]['child_account_id'];
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
        case 'e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3': // Client
         $portal_type = "client";
        break;

       } // end switch entity type

      } // if not system account

   $portal_bits['portal_type'] = $portal_type;

   # If child - then external ticket system exists
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

   // Get Portal Details based on type

   $sclm_object_type = "ConfigurationItems";
   $sclm_action = "select";   
  // commented by vivek
  // $sclm_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' ";
   $sclm_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c IN ('c964c341-ebef-c62b-07f5-51a9cea93d17','723305fd-5711-83d6-1158-51aa0cfcb60','795f11f8-ab63-3948-aac3-51d777dd433c','12e4272a-e571-1067-44f3-51d7787a4045','234cd0fc-fea8-bfb3-6253-5291aaa03b0c','6fb14f09-71c7-ce07-c746-5291aa2c39c4','571f4cd2-1d12-d165-a8c7-5205833eb24c','c0fed5ce-05ba-66e2-e9ae-51b2f2446f68')";
   $sclm_params[1] = "*";
   $sclm_params[2] = "";
   $sclm_params[3] = "";
   $sclm_params[4] = "";

   $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

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
          $portal_skin = $sclm_rows[$cnt]['parent_ci_name'];

          }

       } // end for

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

   return $portal_bits;

  } // end function

# End Portaliser
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

      $effects_map = "<img src=images/loading-reloaded.gif width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Actions&action=view&value=".$item_id."&valuetype=Actions');return false\"><font color=#151B54><B>".$item_name."</B></font></a>";

     //$params[6] = array('object'=>$this_map,'id'=>$item_id);

    break;
    case 'Effects':

      $sfx_params[0] = "";
      $sfx_params[0] = " deleted=0 && sfx_effects_id_c='".$effect_id."' ";
      $sfx_params[1] = "*";
      $sfx_params[2] = "";
      $sfx_params[3] = " effect_date DESC ";
      $sfx_params[4] = "";

//      $id_array[] = $effect_id;

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

  if ($this_currency == $credits_base_currency){

     $divisor = 1;
     $credit_value = $credits*($credits_base_rate/$divisor);
     $provider_share = $credit_value*(1-$credits_partner_share);
     $partner_share = $credit_value*$credits_partner_share;

     } else {

     $ci_object_type = 'Currencies';
     $ci_action = "select";

     $ci_params[0] = " id='".$this_currency."' ";
     $ci_params[1] = ""; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = ""; // order;
     $ci_params[4] = ""; // limit
  
     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($ci_items)){

        for ($cnt=0;$cnt < count($ci_items);$cnt++){

            $id = $ci_items[$cnt]['id'];
            $name = $ci_items[$cnt]['name'];
            $number_to_basic = $ci_items[$cnt]['number_to_basic'];
            $fractional = $ci_items[$cnt]['fractional'];
            $iso_code = $ci_items[$cnt]['iso_code'];
            $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
 
            } // end for
      
        } else { // end if array

        }

     $divisor = $number_to_basic;
     $credit_value = $credits*($credits_base_rate/$divisor);
     $provider_share = $credit_value*(1-$credits_partner_share);
     $partner_share = $credit_value*$credits_partner_share;

     } // not base currency

  $credit_return[0] = $credit_value;
  $credit_return[1] = $provider_share;
  $credit_return[2] = $partner_share;
  $credit_return[3] = $name;
  $credit_return[4] = $iso_code;
  $credit_return[5] = $cmn_countries_id_c;

  return $credit_return;

 } // end creditisor

 #
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

 #
 ################################
 #

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

     } else {

     $minwidth = "98%"; 
     $minheight = "25px"; 
     $margin_left = "1%";
     $margin_right = "1%";
     $padding_left = "3px";
     $padding_right = "3px";
     $margin_top = "0px";
     $margin_bottom = "0px";
     $padding_top = "5px";
     $padding_bottom = "2px";

     }

//     $whiteminwidth = "97%"; 

  $divstyle_blue = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#e6ebf8;min-width:".$minwidth.";min-height:".$minheight.";border:1px solid #d3d3d3;border-radius:3px;padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;";

  $divstyle_grey = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#e6e6e6 50% 50% repeat-x;min-width:".$minwidth.";min-height:".$minheight.";border:1px solid #d3d3d3;border-radius:3px;padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;overflow:no;color:#555555;font-weight: bold;";

  $divstyle_white = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#FFFFFF;min-width:".$minwidth.";min-height:".$minheight.";border:1px solid #d3d3d3;border-radius:3px;padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;";

  $divstyle_orange = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#FF8040;min-width:".$minwidth.";min-height:".$minheight.";border:1px solid #d3d3d3;border-radius:3px;padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;";

  $divstyle_orange_light = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:left;background:#FFE4B5;min-width:".$minwidth.";min-height:".$minheight.";border:1px solid #d3d3d3;border-radius:3px;padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;";

  $divstyle_custom = "margin-top:".$margin_top.";margin-left:".$margin_left.";margin-right:".$margin_right.";margin-bottom:".$margin_bottom.";float:".$custom_float.";background:".$custom_color_back.";min-width:".$minwidth.";max-width:".$maxwidth.";min-height:".$minheight.";border:1px solid ".$custom_color_border.";border-radius:3px;padding-left:".$padding_left.";padding-right:".$padding_right.";padding-top:".$padding_top.";padding-bottom:".$padding_bottom.";text-align:left;";

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

  $divstyle_params[0] = '96%'; // minwidth
  $divstyle_params[1] = '20px'; // minheight
  $divstyle_params[2] = '1%'; // margin_left
  $divstyle_params[3] = '1%'; // margin_right
  $divstyle_params[4] = '2px'; // padding_left
  $divstyle_params[5] = '2px'; // padding_right

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
  $link = "http://".$hostname."/?pc=".$embedd;
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
 margin-left: 2px;
 margin-right: 2px;
 border-radius: 5px;  
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

   $embedder .= "<div id=\"embeddtoggle\" style=\"".$quickstyle."\"><center><a id=\"embeddtoggler\" href=\"javascript:embeddtoggler('embedddiv','embeddtoggler');\"><font size=2><B>".$strings["action_click_here_to_hide_embedded"]."</B></font></a></center></div><BR><div id=\"embedddiv\"><BR><div class=\"embedbox\"><center><BR><B>".$strings["LinkExternal"].":</B> <a href=".$link." target=\"".$portal_title."\"><B>".$object_name."</B></a><P><B>".$strings["action_copy_link_share"]."</B><BR><textarea id=\"embedLink\" name=\"embedLink\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$link."</textarea>";
  
  return $embedder;
  
  } // end make mebedd
 
 # End Realpolitika Code
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

     // Need to add the proper country for the customer/provider/user - not the system
     $this_country = 'JPN';

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

                if (!$checkdate){
                   $date = date("Y-m-d G:i:s");
                   $now_hour = date("G");
                   $now_min = date("i");
                   $now_sec = date("s");
                   } else {
                   $date = date("Y-m-d G:i:s", strtotime($checkdate));
                   $now_hour = date("G", strtotime($checkdate));
                   $now_min = date("i", strtotime($checkdate));
                   $now_sec = date("s", strtotime($checkdate));
                   }

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

                  // Check hours - assuming 9-17
                  if ($start_hour == 17){

                     if ($now_hour > 17 || $now_hour < 9){
                        $sla_status = 1;

/*
                        if ($now_holidays == TRUE){
                           $sla_status = 0;
                           }
*/
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
/*
                        if ($now_holidays == TRUE){
                           $sla_status = 1;
                           }
*/
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

                  // Check hours - assuming 9-17
                  if ($start_hour == 17){

                     if ($now_hour > 17 || $now_hour < 9){

                        $sla_status = 1;

/*
                        if ($now_holidays == TRUE){
                           $sla_status = 0;
                           }
*/
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
/*
                        if ($now_holidays == TRUE){
                           $sla_status = 1;
                           }
*/
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
 # Funky Return Links

 function object_returner ($valtype,$val){
  
  global $do,$lingo,$strings,$action,$sess_contact_id,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$portal_skin,$portal_title,$standard_statuses_closed;

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

  $divstyle_params[0] = '98.5%'; // minwidth
  $divstyle_params[1] = '25px'; // minheight
  $divstyle_params[2] = '0px'; // margin_left
  $divstyle_params[3] = '0px'; // margin_right
  $divstyle_params[4] = '0px'; // padding_left
  $divstyle_params[5] = '0px'; // padding_right
  $divstyle_params[6] = "11px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "5px"; // padding_top
  $divstyle_params[9] = "5px"; // padding_bottom

  $divstyles = $this->makedivstyles($divstyle_params);

  $divstyle_blue = $divstyles[0];
  $divstyle_grey = $divstyles[1];
  $divstyle_white = $divstyles[2];
  $divstyle_orange = $divstyles[3];
  $divstyle_orange_light = $divstyles[4];

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

       $object_return = "<font size=3 color=#FBB117><B>".$strings["Accounts"].": </B></font><font size=3><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=#FBB117><B>".$strings["Accounts"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

       $object_return = "<font size=3 color=#FBB117><B>".$strings["AccountRelationships"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

       $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

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

       $object_return = "<font size=3 color=#FBB117><B>".$strings["CatalogService"].": </B></font><font size=3><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=#FBB117><B>".$strings["CatalogService"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

       $object_return = "<font size=3 color=#FBB117><B>".$strings["AccountsServicesSLAs"].": </B></font><font size=3><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=#FBB117><B>".$strings["AccountsServicesSLAs"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

       $object_return = "<font size=3 color=#FBB117><B>".$strings["Advisory"].": </B></font><font size=3><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=#FBB117><B>".$strings["Advisory"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Cause"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

       $object_return = "<font size=3 color=#FBB117><B>".$object_string.": </B></font><font size=3><B>".$object_name."</B></font>";

       $object_target = "<font size=2>".$object_name."</font>";

       } else {

       $object_return = "<font size=3 color=#FBB117><B>".$object_string.": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["ConfigurationItems"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ConfigurationItems"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ConfigurationItems_Common':

    $params[0] = "deleted=0 && cmn_configurationitems_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmn_configurationitems", $object_name, "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["SystemConfigurationItems"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["ConfigurationItemTypes"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ConfigurationItemTypes"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ConfigurationItemTypes_Common':

    $params[0] = "deleted=0 && cmn_configurationitemtypes_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmn_configurationitemtypes", $object_name, "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["SystemConfigurationItemTypes"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

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

    $object_return = "<font size=3 color=#FBB117><B>Member Profile: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Contact"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["NotificationContacts"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["NotificationContacts"]." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);
 
   break; 
   ########################################
   case 'ContactsServicesSLA':
     
    $params[0] =" deleted=0 && sclm_contactsservicessla_id_c='".$val."' ";

    $object_name = "name";
    $object_name = dlookup("sclm_contactsservicessla", $object_name, "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>Resource: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Contact"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Agency"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$val."&valuetype=Content');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$val."&valuetype=Content');return false\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Content"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Country"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Countries"]." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'CountryStates':

    $params[0] ="deleted=0 && cmv_countrystates_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmv_countrystates", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["State"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["State"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Currency"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Currencies"]." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Events':

    $params[0] ="deleted=0 && cmv_events_id_c='".$val."'";

    if ($do == 'Comments' && $action == 'edit'){
       $val = dlookup("cmv_comments", "cmv_events_id_c", "id='".$val."'");
       }

    $object_name = "name";
    $object_name = dlookup("cmv_events", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Event"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Events"]." ".$comment_title."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Emails':

    $params[0] =" deleted=0 && sclm_emails_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_emails", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Email"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Emails"]."</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'ExternalSources':

    $params[0] ="deleted=0 && sfx_externalsources_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sfx_externalsources", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>External Sources: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>External Sources</B></div>";

  //  $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'Languages':

    $params[0] ="deleted=0 && cmn_languages_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("cmn_languages", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Language"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Languages"]." ".$comment_title."</B></div>";

//    $object_voter = $funky_do->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case'Messages':
       
//    $params[0] = "deleted=0 && related_object='".$valtype."' && related_object_id='".$val."' ";

    $params[0] ="deleted=0 && sclm_messages_id_c='".$val."'";

    $object_name = "name";
    $object_name = dlookup("sclm_messages", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Message"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Messages"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["News"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["News"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Opportunity"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Opportunities"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Project"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Projects"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["ProjectTask"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ProjectTasks"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Security"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Security"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Service"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Services"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["ServicePrice"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ServicePrices"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Service"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Services"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["ServiceSLARequests"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["ServiceSLARequests"]." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Service"]." SLA: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Services"]." SLA ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################
   case 'SocialNetworks':

//    echo " valtype='".$valtype."' && val='".$val."' "; 

    $valtype = dlookup("cmv_socialnetworkmembers", "social_network_type", "id='".$val."'");
    $val = dlookup("cmv_socialnetworkmembers", "social_network_type_id", "id='".$val."'");

    $params[0] = "deleted=0 && social_network_type='".$valtype."' && social_network_type_id='".$val."' ";

    //echo "Params: ".$params[0]."<P>";

    //echo " valtype='".$valtype."' && val='".$val."' ";

    $returner = $this->object_returner ($valtype, $val);
    $object_name = $returner[0];
    $object_return = $returner[1];
    $object_title = $returner[2];
    $object_target = $returner[3];
    //$params = $returner[4];
    //$object_return_completion = $returner[5];
    //$object_return_voter = $returner[6];

//    echo $object_name;

    //$object_return = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworks&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name." </B></font></a> ".$strings["SocialNetwork"];

    //$object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SocialNetworks&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=3>".$object_name."</font></a> ".$strings["SocialNetwork"];

    //$object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." ".$strings["SocialNetwork"]." ".$comment_title."</B></div>";

  //  if (!class_exists('funkydo')){
    //   include ("funkydo.php");
      // }

//    $funkydo_gear = new funkydo ();   

    //$object_voter = $funkydo_gear->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$valtype,$bodywidth);

   break; //
   ########################################
   case 'SourceObjects':

    $params[0] = "deleted=0 && sfx_sourceobjects_id_c='".$val."' ";
 
    $object_name = "name";
    $object_name = dlookup("sfx_sourceobjects", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>Source Object: </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SourceObjects&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name." </B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SourceObjects&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=3>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." Source Object ".$comment_title."</B></div>";

   break; //
   ########################################
   case 'SOW':

    $params[0] = " deleted=0 && sclm_sow_id_c='".$val."' ";
 
    $object_name = "name";
    $object_name = dlookup("sclm_sow", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["SOW"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name." </B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." ".$strings["SOW"]." ".$comment_title."</B></div>";

   break; //
   ########################################
   case 'SOWItems':

    $params[0] = " deleted=0 && sclm_sowitems_id_c='".$val."' ";
 
    $object_name = "name";
    $object_name = dlookup("sclm_sowitems", "$object_name", "id='".$val."'");

    $object_return = "<font size=3 color=#FBB117><B>".$strings["SOWItem"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name." </B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$object_name." ".$strings["SOWItems"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["Ticket"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$valtype."&action=reference&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["Ticket"]." ".$comment_title."</B></div>";

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

    $object_return = "<font size=3 color=#FBB117><B>".$strings["TicketingActivities"].": </B></font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');return false\"><font size=3><B>".$object_name."</B></font></a>";

    $object_target = "<a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&value=".$val."&valuetype=".$valtype."&action=view');\"><font size=2>".$object_name."</font></a>";

    $object_title = "<div style=\"".$divstyle_orange."\"><B>".$strings["TicketingActivities"]." ".$comment_title."</B></div>";

    $object_title = "<div style=\"".$divstyle_orange."\">".$val."</div>";

   break;
   ########################################

  } // end switch

  if ($object_return != NULL){
     $object_return = "<div style=\"".$divstyle_grey."\"><center>".$object_return."</center></div>";
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
  $strings = $container_params[7]; // portal config
  $lingo = $container_params[8]; // portal config

  $portal_skin = $portal_info['portal_skin'];
  $portal_type = $portal_info['portal_type'];
  $portal_name = $portal_info['portal_name'];
  $portal_logo = $portal_info['portal_logo'];

//echo "portal_skin $portal_skin <P>";
 
  if (!$width){
     $width=.98;
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
  $bodywidth_top = "99%";
  $bodywidth_inner = $width*0.98;
  $bodywidth_inner = $bodywidth_inner.$extension;

  $header_color = $portal_config['portalconfig']['portal_header_color'];
  $body_color = $portal_config['portalconfig']['portal_body_color'];
  $footer_color = $portal_config['portalconfig']['portal_footer_color'];
  $border_color = $portal_config['portalconfig']['portal_border_color'];
  $font_color = $portal_config['portalconfig']['portal_font_color'];

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

  $divstyle_params[0] = '99%'; // minwidth
  $divstyle_params[1] = '25px'; // minheight
  $divstyle_params[2] = '1px'; // margin_left
  $divstyle_params[3] = '0px'; // margin_right
  $divstyle_params[4] = '0px'; // padding_left
  $divstyle_params[5] = '0px'; // padding_right
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

//  $header_style = "background: #e6e6e6 50% 50% repeat-x;margin-left:0px;font-weight: bold;0px;border-radius:3px;margin-right:2%;margin-top:0px;padding-top:5px;padding-right:0px;padding-left:3px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";min-height:25px;overflow:no;color:".$header_color.";";

  $header_style = $divstyle_grey;

  $body_style = "margin-left:0px;border-radius:3px;margin-right:2%;padding-top:5px;padding-right:0px;padding-left:3px;padding-bottom:15px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";min-height:".$height.";overflow:auto;background-color:".$body_color.";";

  $footer_style = "margin-left:0px;border-radius:3px;margin-right:2%;padding-right:0px;padding-left:3px;border:1px solid ".$border_color.";min-width:".$bodywidth_top.";min-height:10px;overflow:no;background-color:".$footer_color.";";

$container_top = <<< CONTAINERTOP
<div style="min-width:$bodywidth_top;overflow:no;float:left;">
 <div style="$header_style"><font size=$menu_font>$title</font></div>
 <div style="$body_style">
 
CONTAINERTOP;

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

$container_middle = <<< CONTAINERMIDDLE
</div>
 <div style="$footer_style"><img src=images/blank.gif height=5 width=$bodywidth_inner></div>
</div>
<div style="width:$bodywidth_top;overflow:no;float:left;">
 <div style="$header_style">$title</div>
 <div style="$body_style">
CONTAINERMIDDLE;

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

$container_bottom = <<< CONTAINERBOTTOM
</div>
 <div style="$footer_style"><img src=images/blank.gif height=5 width=$bodywidth_inner></div>
</div>
CONTAINERBOTTOM;

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
 
/*
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

 function navigator ($count,$do,$action,$val,$valtype,$page,$glb_perpage_items,$thediv){

  global $strings, $lingo;

  $divstyle_params[0] = '98%';
  $divstyle_params[1] = '25px';

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
//     $thepage = 'Body.php';
     $key = $action[0];
     $keyvalue = $action[1];
     $sent_action = $action[2];
     $url_extension = "&tbl=".$thediv."&".$key."=".$keyvalue;
     $posting_start = "getjax('getjax.php?pc=".$portalcode;
     $posting_end = ",'cmv_mediatypes'";
     } else {
     $thepage = 'Body.php';
     $sent_action = $action;
     $posting_start = "doBPOSTRequest('".$thediv."','Body.php', 'pc=".$portalcode;
     $posting_end = "";
     }

//echo $posting;

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
        $navi .= "<a href=\"#Top\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=1".$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$first]</B></font></a>";
        if ($page > 2){
           $ppage = $page-1;
           $navi .= "<a href=\"#Top\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$ppage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$prev]</B></font></A>";
           }
        }

//echo "the page: ".$thepage." thediv: ".$thediv."<BR>";
//echo "'pc=".$portalcode."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$ppage.$url_extension."'";

        $npage = $page+1;
        if ($page < $mpage){
           if ($page < ($mpage-1)){ 
              $navi .= "<a href=\"#Top\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$npage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$next]</B></font></A>";
              }
           $navi .= "<a href=\"#Top\" onClick=\"loader('".$thediv."');".$posting_start."&do=".$do."&action=".$sent_action."&value=".$val."&valuetype=".$valtype."&page=".$mpage.$url_extension."'".$posting_end.");return false\"><font color=white size=2><B>[$last]</B></font></A>";
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
           if ($subject != str_replace($checkcharset,"",$subject)){

              return $checkcharset;
              break;

              } elseif ($subject != str_replace($uppercheckcharset,"",$subject)){// if

              #echo "Upper Checkcharset: ".$uppercheckcharset."<BR>";
              return $uppercheckcharset;
              break;

              } // elseif

           } //foreach

} // end check_charset

function get_body_attach ($mbox, $mid) {

  mb_language('uni');
  mb_internal_encoding('UTF-8');

    $struct = imap_fetchstructure($mbox, $mid);

    $parts = $struct->parts;
    $i = 0;
    if (!$parts) { /* Simple message, only 1 piece */
        $attachment = array(); /* No attachments */
        $content = imap_body($mbox, $mid);
    } else { /* Complicated message, multiple parts */

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
            }

            if (!$endwhile) {
                /* Create message part first (example '1.2.3') */
                $partstring = "";
                foreach ($stack as $s) {
                    $partstring .= ($s["i"]+1) . ".";
                }
                $partstring .= ($i+1);

                if (strtoupper($parts[$i]->disposition) == "ATTACHMENT" || strtoupper($parts[$i]->disposition) == "INLINE") { /* Attachment or inline images */
                    $filedata = imap_fetchbody($mbox, $mid, $partstring);
                    if ( $filedata != '' ) {
                        // handles base64 encoding or plain text
                        $decoded_data = base64_decode($filedata);
                        if ( $decoded_data == false ) {
                            $attachment[] = array("filename" => $parts[$i]->parameters[0]->value,
                                "filedata" => $filedata);
                        } else {
                          #$attachment[] = array("filename" => $parts[$i]->parameters[0]->value,"filedata" => $decoded_data);
                          // Saloob added 2014-01-06
                          if (count($parts[$i]->parameters)>0){
                             foreach ($parts[$i]->parameters as $param){
                                     if ((strtoupper($param->attribute)=='NAME') ||(strtoupper($param->attribute)=='FILENAME')){
                                        $filename=$param->value;
                                        $attachment[] = array("filename" => $param->value, "filedata" => $decoded_data);
                                        } // if
                                     } // foreach
                             } // if
                        } // else
                    } // if
                } elseif (strtoupper($parts[$i]->subtype) == "PLAIN" && strtoupper($parts[$i+1]->subtype) != "HTML") {
                  # plain text message
                  $content .= imap_fetchbody($mbox, $mid, $partstring);
                } elseif ( strtoupper($parts[$i]->subtype) == "HTML" ) {
                  # HTML message takes priority
                  $content .= imap_fetchbody($mbox, $mid, $partstring);
                }
            }

            if ($parts[$i]->parts) {
                if ( $parts[$i]->subtype != 'RELATED' ) {
                    // a glitch: embedded email message have one additional stack in the structure with subtype 'RELATED', but this stack is not present when using imap_fetchbody() to fetch parts.
                    $stack[] = array("p" => $parts, "i" => $i);
                }
                $parts = $parts[$i]->parts;
                $i = 0;
            } else {
                $i++;
            }
        } /* while */
    } /* complicated message */

    $ret = array();

    if (isset($struct->parts) && is_array($struct->parts) && isset($struct->parts[1])) {
       $part = $struct->parts[1];
       #$message = imap_fetchbody($inbox,$email_number,2);
       #echo "Part Encode: ".$part->encoding."<P>";

       #$charset = $struct->parts[0]->parameters[0]->parts[0]->parameters->value;
       #$charset = $struct->parts;
       #var_dump($charset);

       #$charset = $struct->parts[1];
       
       #array(1) { [0]=> object(stdClass)#46 (2) { ["attribute"]=> string(7) "CHARSET" ["value"]=> string(5) "utf-8" } } ID: 5 Part Encode: 0 & Charset: Array

       #$charset = $struct->parts[1]->parts;

       #array(1) { [0]=> object(stdClass)#10 (12) { ["type"]=> int(0) ["encoding"]=> int(4) ["ifsubtype"]=> int(1) ["subtype"]=> string(5) "PLAIN" ["ifdescription"]=> int(0) ["ifid"]=> int(0) ["lines"]=> int(68) ["bytes"]=> int(3259) ["ifdisposition"]=> int(0) ["ifdparameters"]=> int(0) ["ifparameters"]=> int(1) ["parameters"]=> array(1) { [0]=> object(stdClass)#11 (2) { ["attribute"]=> string(7) "CHARSET" ["value"]=> string(11) "iso-2022-jp" } } } } ID: 5 Part Encode: 0 & Charset: Array

       #$charset = $struct->parts[1]->parts[0]->parameters[0]->value;
       #$charset = $struct->parts[1]->parameters;
       #var_dump($charset);
       #$charset = $struct->parameters[0]->value;

       #echo "ID: ".$mid." Encode: ".$part->encoding." && Charset: ".$charset."<BR>";

       #$charset = $struct->parts->parameters[1];
       $encode = $part->encoding;

       if ($part->encoding == 0){
            $content = imap_base64($content);
          } elseif ($part->encoding == 1){ 
            $content = imap_8bit($content); 
          } elseif ($part->encoding == 2) { 
            $content = imap_binary($content); 
          } elseif ($part->encoding == 3) {
            $content = imap_base64($content);
          } elseif ($part->encoding == 4) {
            $content = quoted_printable_decode($content);
          } else {
            $content = imap_qprint($content);
          }

       } else { // if isset

       $encode = $struct->encoding;
       #$charset = $struct->parts[1]->parts[0]->parameters[0]->value;
       if (is_array($struct->parameters)){
          $charset = $struct->parameters[0]->value;
          } else {
          $headers = imap_headerinfo($mbox, $mid);
          $subject = $headers->subject;
          #var_dump($subject);
          #$subject = strip_tags($subject);
          #echo "Subject: ".$subject."<BR>";
          $charset = $this->check_charset ($subject);

#          if ($subject != str_replace("iso-2022-jp","",$subject)){
#             $charset = "iso-2022-jp";
#             } elseif ($subject != str_replace("ISO-2022-JP","",$subject)){
#             $charset = "iso-2022-jp";
#             } else {
#             #$charset = mb_detect_encoding($subject);
#             #echo "AUTO CHARSET: ".$charset."<BR>";
#             $charset = "AUTO";
#             }

          } // is array

       #var_dump($struct);

       #Normal Email MIME Structure
       #object(stdClass)#5 (12) { ["type"]=> int(0) ["encoding"]=> int(3) ["ifsubtype"]=> int(1) ["subtype"]=> string(5) "PLAIN" ["ifdescription"]=> int(0) ["ifid"]=> int(0) ["lines"]=> int(78) ["bytes"]=> int(6072) ["ifdisposition"]=> int(0) ["ifdparameters"]=> int(0) ["ifparameters"]=> int(1) ["parameters"]=> array(1) { [0]=> object(stdClass)#4 (2) { ["attribute"]=> string(7) "CHARSET" ["value"]=> string(5) "utf-8" } } }

       # EXAdmin_Agent@agc.jp MIME Structure
       #object(stdClass)#5 (12) { ["type"]=> int(0) ["encoding"]=> int(0) ["ifsubtype"]=> int(1) ["subtype"]=> string(5) "PLAIN" ["ifdescription"]=> int(0) ["ifid"]=> int(0) ["lines"]=> int(1) ["bytes"]=> int(127) ["ifdisposition"]=> int(0) ["ifdparameters"]=> int(0) ["ifparameters"]=> int(0) ["parameters"]=> object(stdClass)#4 (0) { } } 

       #var_dump($charset);

       #$parameters = $struct->parameters;
       #$charset = $parameters->value;
       #$charset = "AUTO";

       #echo "ID: ".$mid." Encode :".$encode." && Charset: ".$charset."<BR>";

       switch ($encode){

        case 0 :

         $encode_body=imap_qprint($content);
         #$charset = mb_detect_encoding($content);
         #echo "Body Encode: ".$charset."<BR>";

         #$encode_body=imap_base64($content);
         #$charset = "iso-2022-jp";
         $content = mb_convert_encoding($encode_body, 'UTF-8', $charset);
         #$content = $encode_body;

        break;
        case 1 :
         $encode_body=imap_8bit($content);
         $encode_body=imap_qprint($encode_body);
         $content = mb_convert_encoding($encode_body, "UTF-8", $charset);
        break;
        case 3 :
         $encode_body=imap_base64($content);
         $content = mb_convert_encoding($encode_body, "UTF-8", $charset);
        break;
        case 4 :
         $encode_body=imap_qprint($content);
         $content = mb_convert_encoding($encode_body, 'UTF-8', $charset);
        break;
        case 5 :
        default:
         $content = imap_qprint($content);
        break;

       }


       #echo "NO structure->parts<P>";
       #$encoding = mb_detect_encoding($content);
       #echo "Encoding: ".$encoding."<P>";
       #$content = mb_convert_encoding($content,"UTF-8",$encoding);
       #$encoding = mb_detect_encoding($content);
       #echo "Encoding: ".$encoding."<P>";

       #$content = quoted_printable_decode($content);

/*
       foreach (mb_list_encodings() as $chr){ 
               #echo "Char Encodes: ".$chr."<br>";
               #echo "Char Encode: ".$chr.": ".mb_convert_encoding($content, 'UTF-8', $chr)."<P>#############<P>";    
               }
*/
       }

    $ret['body'] = $content;
    $ret['attachment'] = $attachment;
    $ret['encoding'] = $encode;
    return $ret;
}

###############################

function get_body_attach_depricated ($mbox, $mid) {

   mb_language('uni');
   mb_internal_encoding('UTF-8');

   $struct = imap_fetchstructure($mbox, $mid);

   if ( !empty($struct->parts) ) {

      $parts_cnt=count($struct->parts);
      for ( $p=0; $p<$parts_cnt; $p++ ) {
	  # タイプにより処理を分ける
	  # [参考] http://www.php.net/manual/ja/function.imap-fetchstructure.php
          if ( $struct->parts[$p]->type == 0 ) {

	     if ( empty( $charset ) ) {
		$charset=$struct->parts[$p]->parameters[0]->value;
		}

	     if ( empty( $encoding ) ) {
		$encoding=$struct->parts[$p]->encoding;
		}

	     } elseif (!empty($struct->parts[$p]->parts) && $struct->parts[$p]->parts[$p]->type == 0){
	       $parameters=$struct->parts[$p]->parameters[0]->value;

	       if ( empty( $charset ) ) {
	          $charset=$struct->parts[$p]->parts[$p]->parameters[0]->value;
		  }

	       if ( empty( $encoding ) ) {
	          $encoding=$struct->parts[$p]->parts[$p]->encoding;
		  }

	     } elseif ($struct->parts[$p]->type == 5){

	       $files = imap_mime_header_decode($struct->parts[$p]->dparameters[0]->value);

	       if (!empty($files) && is_array($files) ) {
		  $attached_data[$p]['file_name']=null;
		  foreach ($files as $key => $file) {

			  if ( $file->charset != 'default') {
			     $attached_data[$p]['file_name'].=mb_convert_encoding($file->text, 'UTF-8', $file->charset);
			     } else {
			     $attached_data[$p]['file_name'].=$file->text;
			     }

			  } // foreach

                  } // if files

               $attached_data[$p]['content_type'] = $struct->parts[$p]->subtype;

	      } // elseif

	  } //for

      } else { // empty($struct->parts

      $charset = $struct->parameters[0]->value;
      $encoding = $struct->encoding;
      #$charset = 'iso-2022-jp';
      #$encoding = 0;
      #echo "Charset: ".$charset."<BR>";
      #echo "Encoding: ".$encoding."<BR>";

/*
      foreach ($struct as $str) {

              #$charset = $str->charset;
              $encoding = $str->encoding;

              } // foreach
*/

      } // ifnot empty

   if (empty($charset) ) {
      # エラー処理を記述...
      $charset = 'iso-2022-jp';
      $encoding = 0;
      }

   # 本文を取得
   $body=imap_fetchbody($mbox, $mid, 1, FT_INTERNAL);
   $body=trim($body);

   echo "Encode: ".$encoding."<BR>Charset: ".$charset."<BR>";

   if ( !empty($body) ) {
      # タイプによってエンコード変更
      switch( $encoding ) {
	case 0 :

         if ($charset != "UTF-8"){
            #$encode_body=imap_base64($body);
            $content = mb_convert_encoding($encode_body, "UTF-8", $charset);
            } else {
            #$content = imap_qprint($body);
            }

	break;
	case 1 :
	 $encode_body=imap_8bit($body);
	 $encode_body=imap_qprint($encode_body);
	 $content = mb_convert_encoding($encode_body, "UTF-8", $charset);
	break;
	case 3 :
	 $encode_body=imap_base64($body);
	 $content = mb_convert_encoding($encode_body, "UTF-8", $charset);
	break;
	case 4 :
	 $encode_body=imap_qprint($body);
	 $content = mb_convert_encoding($encode_body, 'UTF-8', $charset);
	break;
	case 2 :
         $content = imap_binary($body); 
	break;
	case 5 :
	default:
         $content = imap_qprint($body);
	# エラー処理を記述...
	break;

       } // end switch

      }else{
      # エラー処理を記述...
      }
		
   # 添付を取得
   if (!empty($attached_data)){

      foreach ($attached_data as $key => $value) {

              $attached=imap_fetchbody($mbox, $mid, $key+1, FT_INTERNAL);

	      if (empty($attached)) break;
		 # ファイル名を一意の名前にする(同じファイルが存在しないように)

	      list($name, $ex)=explode('.', $value['file_name']);

	      #$attachment['attached_file'][$key]['file_name']=$name.'_'.time().'_'.$key.'.'.$ex;
	      $attachment['attached_file'][$key]['filename']=$name;
	      $attachment['attached_file'][$key]['filedata']=imap_base64($attached);
	      $attachment['attached_file'][$key]['content_type']='Content-type: image/'.strtolower($value['content_type']);

	      } // foreach

      } // if attached

    $ret['body'] = $content;
    $ret['attachment'] = $attachment;
    $ret['encoding'] = $encoding;

    return $ret;

  } // end function

###############################

 function get_email ($emailparams){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

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
         #$subject = $elements[$i]->text;

         } // for

     #echo "charset $charset<BR>";

     #$subject = mb_decode_mimeheader($subject);
     $subject = imap_utf8($subject);

     #echo "subject $subject<BR>";

     if ($charset == 'UTF-8' || $charset == 'utf-8'){
        # Do nothing
        } else {
        #$subject = mb_convert_encoding($subject, "UTF-8", $charset);
        #echo "converted subject $subject<BR>";
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

    if ($keyword != NULL){
       $emails = imap_search($inbox,"SUBJECT '".$keyword."'");
       } elseif ($searchemail != NULL){
       $emails = imap_search($inbox,"FROM '".$searchemail."'");
       } else {
       $emails = imap_search($inbox,'ALL');
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
		
                #$overview = imap_fetch_overview($inbox,$email_number,0);
                $headers = imap_header($inbox,$email_number);
                $message_id = $headers->message_id;

                $messageparts = $this->get_body_attach($inbox, $email_number);
                $message = $messageparts['body'];
                $attachments = $messageparts['attachment'];
                $encoding = $messageparts['encoding'];
                $subject = $headers->subject;
                #$subject = mb_decode_mimeheader($subject);

                $elements = imap_mime_header_decode($subject);
                for ($i=0; $i<count($elements); $i++) {
                    $charset = $elements[$i]->charset;
                    }

                $subject = imap_utf8($subject);

		$output[$cnt]['number'] = $email_number;
                $output[$cnt]['Msgno'] = $headers->Msgno;
		$output[$cnt]['id'] = $message_id;
		$output[$cnt]['cc'] = $headers->cc;
                $output[$cnt]['to'] = $headers->to;
          #     $output[$cnt]['read'] = utf8_decode(imap_utf8($headers->seen));
		$output[$cnt]['read'] = $headers->seen;
		$output[$cnt]['subject'] = $subject;
                $output[$cnt]['charset'] = $charset;
		$output[$cnt]['encode'] = $encoding;
		$output[$cnt]['from'] = $headers->from;
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

/*
  $structure = imap_fetchstructure($mbox, $id); 
  $message = imap_fetchbody($mbox,$id,$part);    
  $name = $structure->parts[$part]->dparameters[0]->value;
  $type = $structure->parts[$part]->typee;

 ############## type 

 if ($type == 0){ 
    $type = "text/"; 
    } elseif ($type == 1){ 
    $type = "multipart/"; 
    } elseif ($type == 2){ 
    $type = "message/"; 
    } elseif ($type == 3){ 
    $type = "application/"; 
    } elseif ($type == 4){ 
    $type = "audio/"; 
    } elseif ($type == 5){ 
    $type = "image/"; 
    } elseif ($type == 6){ 
    $type = "video"; 
    } elseif($type == 7){ 
    $type = "other/"; 
    }

 $type .= $structure->parts[$part]->subtypee; 

 ######## Type end 

 header("Content-typee: ".$type); 
 header("Content-Disposition: attachment; filename=".$name); 

 ######## coding 

 ########## coding end 
 imap_close($mbox); 
*/

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
}

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
}

function convertbody ($check_params){

  $from = $check_params[0];
  $subject = $check_params[1];
  $body = $check_params[2];
  $tolist = $check_params[3];

  $subjectis_Japanese = $this->isJapanese($subject);
  $bodyis_Japanese = $this->isJapanese($body);

  if ($subjectis_Japanese || $bodyis_Japanese){
     //echo "Subject/Body Contains Japanese!<BR>";
     mb_language('Japanese');
     }

  $body_encode = mb_detect_encoding($body);
  //echo "Original Body Encode: ".$body_encode."<BR>";

  #decode7Bit_ISO-2022-JP[]ISC-OA-SCOM-PR@agc.com

//  $encodecatch_list = "base64_decode[]ISC-OA-Backup@agc.com,mb_convert_encoding[]MSKK_MOM@agc.co.jp,base64_decode[]ISC-OA-SCOM-DR@agc.com,utf16_decode_base64_decode[]VBCorp_System@agc.com,base64_decode[]ISC-OA-SCOM-PR@agc.com,base64_decode_UTF-8_UTF-16LE_decode[]ISC-OA-Backup@agc.com,base64_decode[]toru.kazami@hp.com,base64_decode[]masasi-suwa@agc.com,decode7Bit_ISO-2022-JP[]hp-agc@scalastica.com,decode7Bit_ISO-2022-JP[]exadmin-agent@aidas.in.agc.co.jp,decode7Bit_ISO-2022-JP[]EXAdmin_Agent@agc.jp,base64_decode[]lu.dan@hp.com,base64_decode[]hiroyuki.okamoto@hp.com";

# MSKK_MOM@agc.co.jp - Shift_JIS_UTF-8 - NG
# MSKK_MOM@agc.co.jp - base64_decode - NG
# MSKK_MOM@agc.co.jp - none - NG
# MSKK_MOM@agc.co.jp - mb_convert_encoding - NG
# MSKK_MOM@agc.co.jp - utf8_decode_imap_utf8 - NG
# MSKK_MOM@agc.co.jp - imap_utf8 - NG
# MSKK_MOM@agc.co.jp - utf8_decode - NG
# MSKK_MOM@agc.co.jp - utf8_decode_convert_UTF-8_ISO-2022-JP - NG
# MSKK_MOM@agc.co.jp - convert_UTF-8_ISO-2022-JP_imap_utf8 - NG
# MSKK_MOM@agc.co.jp - convert_UTF-8_ISO-2022-JP_utf8_decode - NG
# MSKK_MOM@agc.co.jp - convert_UTF-8_ISO-2022-JP_utf8_decode - NG
# MSKK_MOM@agc.co.jp - convert_UTF-8_AUTO_utf8_decode - NG
# MSKK_MOM@agc.co.jp - convert_UTF-8_AUTO_utf8_decode_imap_utf8 - NG
# MSKK_MOM@agc.co.jp - remove_mb - NG
# MSKK_MOM@agc.co.jp - Shift_JIS_mb_convert_encoding - NG
# EXOperator_Agent@agc.jp - Shift_JIS_mb_convert_encoding  - NG
# EXOperator_Agent@agc.jp - base64_decode - NG
# EXOperator_Agent@agc.jp - mb_convert_encoding - NG
# EXOperator_Agent@agc.jp - decode7Bit_ISO-2022-JP - NG
# EXOperator_Agent@agc.jp - UTF-8_base64_decode - NG
# EXOperator_Agent@agc.jp - imap_utf7_decode - NG
# EXOperator_Agent@agc.jp - utf8_decode_imap_utf8 - NG
# EXOperator_Agent@agc.jp - imap_utf8 - NG
# yu.yoshikawa@hp.com - UTF-8_iconv -NG
# yu.yoshikawa@hp.com - ISO-2022-JP_UTF-8 - NG
# yu.yoshikawa@hp.com - utf8_decode_imap_utf8 - NG
# yu.yoshikawa@hp.com - Shift_JIS_UTF-8 - NG
# yu.yoshikawa@hp.com - ISO-2022-JP_UTF-8_base64 - NG
# yu.yoshikawa@hp.com - base64_decode_UTF-8_AUTO - NG
# yu.yoshikawa@hp.com - imap_utf8 - NG
# yu.yoshikawa@hp.com - UTF-8_base64_decode - NG
# yu.yoshikawa@hp.com - none - NG
# yu.yoshikawa@hp.com - SJIS - NG
# yu.yoshikawa@hp.com - convert_UTF-8_AUTO_utf8_decode_imap_utf8 - NG
# yu.yoshikawa@hp.com - ISO-2022-JP-MS_UTF-8 - NG
# hp-agc@scalastica.com - UTF-8_base64_decode - NG
# 

  $encodecatch_list = "quoted_printable_decode_UTF-8[]EXOperator_Agent@agc.jp,base64_decode[]ISC-OA-Backup@agc.com,quoted_printable_decode_UTF-8[]MSKK_MOM@agc.co.jp,decode7Bit_ISO-2022-JP[]ISC-OA-SCOM-PR@agc.com,base64_decode[]ISC-OA-SCOM-DR@agc.com,utf16_decode_base64_decode[]VBCorp_System@agc.com,base64_decode[]ISC-OA-SCOM-PR@agc.com,base64_decode_UTF-8_UTF-16LE_decode[]ISC-OA-Backup@agc.com,base64_decode[]masasi-suwa@agc.com,quoted_printable_decode_UTF-8[]hp-agc@scalastica.com,nash[]matthew.edmond@KVHasia.com,decode7Bit_ISO-2022-JP[]exadmin-agent@aidas.in.agc.co.jp,decode7Bit_ISO-2022-JP[]EXAdmin_Agent@agc.jp,base64_decode[]lu.dan@hp.com,quoted_printable_decode_UTF-8[]yu.yoshikawa@hp.com,quoted_printable_decode_UTF-8[]tho@computec.co.jp,decode7Bit_ISO-2022-JP[]kazuhiro.fujimoto@hp.com,quoted_printable_decode_UTF-8[]hiroyuki.okamoto@hp.com,base64_decode[]toru.kazami@hp.com";

   if (is_array($from)){
      //echo "Have a From Array<BR>";
      foreach ($from as $id => $object) {
              $from_name = $object->personal;
              $from_mailname = $object->mailbox . "@" . $object->host;
              $from_mailname = str_replace(" ","",$from_mailname);
              #echo "From: $from_mailname<BR>";
              } // foreach
      } // if from array

  # Should get from CI db for encode whitelist
  $toarray = explode(',',$tolist);
  $mailnameexists = FALSE;

  if ($encodecatch_list != NULL){

     $encodecatch_array = explode(',',$encodecatch_list);

     foreach ($encodecatch_array as $encodecatch_value){

             list ($decoder,$check_address) = explode('[]',$encodecatch_value);
             //echo "Array Decoder: $decoder, Array From: $from_address <BR>";
             $check_address = str_replace(" ","",$check_address);
             $encodecatch_addressees[$check_address] = $check_address;

             if ($from_mailname != NULL){
                #echo "Have a From Array<BR>";
                if ($from_mailname == $check_address){
                   #echo "$from_mailname == $from_address && decoder_method = $decoder <BR>";
                   $decoder_method = $decoder;
                   $mailnameexists = TRUE;

                   }

                if ($from_mailname == 'hp-agc@scalastica.com' && (in_array('takasi-moriwaki@agc.com',$toarray) || in_array('kazuhiro.fujimoto@hp.com',$toarray) || in_array('toru.kazami@hp.com',$toarray))){

                   $decoder_method = 'decode7Bit_ISO-2022-JP';
                   break 1;

                   } // if check address same as this email sender

                } // if from

             } // foreach

     }

     if ($mailnameexists != TRUE){

        $decoder_method = "quoted_printable_decode_UTF-8";

        }


     switch ($decoder_method){

      case '':
      case 'none':

       $body_encode = mb_detect_encoding($body);
       //echo "Default: No decoding: ".$body_encode."<BR>";
       $body = $body;

      break;
      case 'remove_mb':

       $body = 'remove_mb';

      break;
      case 'quoted_printable_decode':

       $body = quoted_printable_decode($body);

      break;
      case 'quoted_printable_decode_UTF-8':

       $body = quoted_printable_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8', 'auto');

      break;
      case 'nash':

       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body_encode = mb_detect_encoding($body);
       //echo "Default: to UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'ISO-2022-JP-MS_UTF-8':

       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP-MS');

      break;
      case 'JIS_UTF-8':

       $body = mb_convert_encoding($body, 'UTF-8', 'JIS');

      break;
      case 'SJIS_UTF-8':

       $body = mb_convert_encoding($body, 'UTF-8', 'SJIS');

      break;
      case 'decode7Bit':

       $body = $this->decode7Bit($body);

      break;
      case 'decode7Bit_ISO-2022-JP':

       $body = $this->decode7Bit($body);
       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');

      break;
      case 'imap_utf7_decode':

       $body = imap_utf7_decode($body);
       //$body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');

      break;
      case 'decode7Bit_base64':

       $body = $this->decode7Bit($body);
       $body = base64_decode($body);

      break;
      case 'utf8_decode_imap_utf8':

       $body = utf8_decode(imap_utf8($body));

      break;
      case 'imap_utf8':

       $body = imap_utf8($body);

      break;
      case 'imap_utf8_convert_UTF-8_ISO-2022-JP':

       $body = imap_utf8($body);
       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');

      break;
      case 'convert_UTF-8_ISO-2022-JP_imap_utf8':

       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
       $body = imap_utf8($body);

      break;
      case 'convert_UTF-8_ISO-2022-JP_utf8_decode':

       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
       $body = utf8_decode($body);

      break;
      case 'convert_UTF-8_AUTO_utf8_decode':

       $body = mb_convert_encoding($body, 'UTF-8', 'AUTO');
       $body = utf8_decode($body);

      break;
      case 'convert_UTF-8_AUTO_utf8_decode_imap_utf8':

       $body = mb_convert_encoding($body, 'UTF-8', 'AUTO');
       $body = utf8_decode(imap_utf8($body));

      break;
      case 'utf8_decode_convert_UTF-8_ISO-2022-JP':

       $body = utf8_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');

      break;
      case 'utf8_decode':

       $body = utf8_decode($body);

      break;
      case 'imap_utf8':

       $body = imap_utf8($body);

      break;
      case 'Shift_JIS_UTF-8':

       $body = mb_convert_encoding($body, 'UTF-8', 'Shift_JIS');
       $body_encode = mb_detect_encoding($body);
       //echo "Shift_JIS_UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'ISO-2022-JP_UTF-8':

       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
       $body_encode = mb_detect_encoding($body);
       //echo "ISO-2022-JP_UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'ISO-2022-JP_UTF-8_base64':

       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
       $body = base64_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "ISO-2022-JP_UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'base64_ISO-2022-JP_UTF-8':

       $body = base64_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
       $body_encode = mb_detect_encoding($body);
       //echo "ISO-2022-JP_UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'ISO-2022-JP_base64_UTF-8':

       $body = mb_convert_encoding($body, 'UTF-8', 'ISO-2022-JP');
       $body = base64_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8');
       $body_encode = mb_detect_encoding($body);
       //echo "ISO-2022-JP_UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'utf-8_utf-16le':

       $body = mb_convert_encoding($body , 'UTF-8' , 'UTF-16LE');

      break;
      case 'base64_decode_UTF-8_UTF-16LE_decode':

       $body = base64_decode($body);
       $body = mb_convert_encoding($body , 'UTF-8' , 'UTF-16LE');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: base64_decode_UTF-8_UTF-16LE_decode: ".$body_encode."<BR>";

      break;
      case 'quoted_printable_decode':

       $body = quoted_printable_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo " quoted_printable_decode: ".$body_encode."<BR>";

      break;
      case 'base64_decode_utf16_decode':

       $body = base64_decode($body);
       $body = $this->utf16_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: utf16_decode_base64_decode: ".$body_encode."<BR>";

      break;
      case 'UTF-8_base64_decode':

       $body = mb_convert_encoding($body, 'UTF-8');
       $body = base64_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: UTF-8_base64_decode: ".$body_encode."<BR>";

      break;
      case 'utf16_decode_decode_UTF-8':

       $body = $this->utf16_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: utf16_decode_decode_UTF-8: ".$body_encode."<BR>";

      break;
      case 'decode_UTF-8_utf16_decode':

       $body = mb_convert_encoding($body, 'UTF-8');
       $body = $this->utf16_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: decode_UTF-8_utf16_decode: ".$body_encode."<BR>";

      break;
      case 'base64_decode_UTF-8':

       $body = base64_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: UTF-8_base64_decode: ".$body_encode."<BR>";

      break;
      case 'base64_decode_UTF-8_AUTO':

       $body = base64_decode($body);
       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: UTF-8_base64_decode: ".$body_encode."<BR>";

      break;
      case 'UTF-8_AUTO_base64_decode':

       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body = base64_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: UTF-8_base64_decode: ".$body_encode."<BR>";

      break;
      case 'utf16_decode_base64_decode':

       $body = $this->utf16_decode($body);
       $body = base64_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: utf16_decode_base64_decode: ".$body_encode."<BR>";

      break;
      case 'utf16_decode':

       $body = $this->utf16_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: utf16_decode: ".$body_encode."<BR>";

      break;
      case 'mb_convert_encoding':

       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: to UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'mb_convert_encoding_simple':

       $body = mb_convert_encoding($body, 'UTF-8');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: to UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'Shift_JIS_mb_convert_encoding':

       $body = mb_convert_encoding($body, 'UTF-8', 'Shift_JIS');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: Shift_JIS to UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'ASCII_mb_convert_encoding':

       $body = mb_convert_encoding($body, 'UTF-8', 'ASCII');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: ASCII to UTF-8 using mb_convert_encoding: ".$body_encode."<BR>";

      break;
      case 'UTF-8_iconv':

       $body = iconv('UTF-8', 'UTF-8//IGNORE', $body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: From ASCII to UTF-8 using iconv: ".$body_encode."<BR>";

      break;
      case 'ASCII_iconv':

       $body = iconv('ASCII', 'UTF-8//IGNORE', $body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: From ASCII to UTF-8 using iconv: ".$body_encode."<BR>";

      break;
      case 'ASCII_iconv_UTF-8_mb_convert_encoding':

       $body = iconv('ASCII', 'UTF-8//IGNORE', $body);
       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: From ASCII to UTF-8 using iconv: ".$body_encode."<BR>";

      break;
      case 'iconv_UTF-16':

       $body = iconv('UTF-16', 'UTF-8//IGNORE', $body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: From ASCII to UTF-8 using iconv: ".$body_encode."<BR>";

      break;
      case 'iconv_UTF-16_UTF-8_auto':

       $body = iconv('UTF-16', 'UTF-8//IGNORE', $body);
       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: From ASCII to UTF-8 using iconv: ".$body_encode."<BR>";

      break;
      case 'iconv_Shift_JIS':

       $body = iconv('Shift_JIS', 'UTF-8//IGNORE', $body);
       $body = mb_convert_encoding($body, 'UTF-8', 'auto');
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: From ASCII to UTF-8 using iconv: ".$body_encode."<BR>";

      break;
      case 'base64_decode':

       $body = base64_decode($body);
       $body_encode = mb_detect_encoding($body);
       //echo "Catchlist: Base64 using base64_decode: ".$body_encode."<BR>";

      break;

     }

return $body;

} // end convert body

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
   break;
   case 'maintenance_status':
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['type_id'] = '2864a518-19f4-ddfa-366e-52ccd012c28b';
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['paritem_id'] = $paritem_id;
    $update_ci['2864a518-19f4-ddfa-366e-52ccd012c28b']['item_value'] = $item_value;
   break;
   case 'frequency_timestamp':
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['type_id'] = '7a454f0d-3d12-7bc5-7607-52defc746103';
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['paritem_id'] = $paritem_id;
    $update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['item_value'] = $item_value;
   break;
   case 'frequency_count':
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['type_id'] = 'c3891c31-9198-476d-0a8a-52df0e00c722';
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['paritem_id'] = $paritem_id;
    $update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['item_value'] = $item_value;
   break;
   case 'maintenance_window':

    $maintenance_startdatetime = $params[3];
    $maintenance_enddatetime = $params[4];

    #echo "<P>Entered Maintenance Update<P>";

    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['type_id'] = '787ab970-8f2a-efed-3aca-52ecd566b16b';
    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['paritem_id'] = $paritem_id;
    $update_ci['787ab970-8f2a-efed-3aca-52ecd566b16b']['item_value'] = $maintenance_startdatetime;

    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['type_id'] = 'b38181b6-eb59-0bc3-bad3-52ecd65163f5';
    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['paritem_id'] = $paritem_id;
    $update_ci['b38181b6-eb59-0bc3-bad3-52ecd65163f5']['item_value'] = $maintenance_enddatetime;

   break;

   }

  if ($paritem_id != NULL && is_array($update_ci)){

     foreach ($update_ci as $ci_info){
 
             $paritem_id = $ci_info['paritem_id'];
             $ci_type = $ci_info['type_id'];
             $item_value = $ci_info['item_value'];

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
             $update_process_params[] = array('name'=>'description','value' => $item_value);
             $update_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
             $update_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $update_process_params[] = array('name'=>'description','value' => $description);
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
# Do Filterbits

 function do_filterbits ($filterbit_params){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  if (!function_exists('get_param')){
     include ("common.php");
     }

  global $portal_account_id,$portal_email_server,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c;
 
  $filterbits = $filterbit_params[0];
  $subject = $filterbit_params[1];
  $from_mailname = $filterbit_params[2];
  $body = $filterbit_params[3];
  $date = $filterbit_params[4];
  $udate = $filterbit_params[5];
  $filespack = $filterbit_params[6];
  $report = $filterbit_params[7];
  $match = $filterbit_params[8];
  $debug = $filterbit_params[9];
  $filter_id = $filterbit_params[10];
  $do_catchall = $filterbit_params[11];
  $catchall = $filterbit_params[12];
  $check_maint_servers = $filterbit_params[13];
  $previous_ticket = $filterbit_params[14];
  $previous_title = $filterbit_params[15];
  $previous_subject = $filterbit_params[16];
  $email_id = $filterbit_params[17];
  $received_to = $filterbit_params[18];
  $received_cc = $filterbit_params[19];
  $triggercount = $filterbit_params[20];
  $replyparams = $filterbit_params[21];
  $precheckparams = $filterbit_params[22];

  if ($replyparams != NULL){
     $create_activity_ticket_id = $replyparams[0];
     $create_activity_email_ticket_id = $replyparams[1];
     $create_activity_email_ticket_status = $replyparams[2];
     }

  $server_replace = $precheckparams[0];
  $message_pass = $precheckparams[1];
  $message_source = $precheckparams[2];
  $event_source = $precheckparams[3];
  $event_category = $precheckparams[4];
  $nameupper = $precheckparams[5];
  $namelower = $precheckparams[6];
  $server_pack = $precheckparams[7];

  $debugger = "<img src=http://".$hostname."/images/icons/bug.png width=16> <B>Debug:</B>";

  # If final message, then came from pre-catch-all = requires report...maybe...
  if ($debug == TRUE){
     $create_report = TRUE;
     }

  if ($create_report == TRUE){
     $report .= $debugger." Previous_ticket: <B>".$previous_ticket."</B> Title: ".$previous_title." Subject: ".$previous_subject."<BR>"; 
     }

  if ($create_report == TRUE){
     $report .= $debugger." Filter Trigger Count to be met to either ignore or create a ticket: <B>".$triggercount."</B><BR>";
     }

  ##########################################
  # Use Filtering Set to get SLA Request

  for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

      $filterbit_id = $filterbits[$cntfb]['id'];
      $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

      if ($filterbit_configurationitemtypes_id_c == '683bb5f7-e1c7-4796-8d23-52b0df65369f'){
         $sla_filter_sla_id = $filterbits[$cntfb]['name']; // the actual ID of the SLA item
         $sla_returner = $this->object_returner ("ServiceSLARequests", $sla_filter_sla_id);
         $sla_filter_name = $sla_returner[0];

         if ($create_report == TRUE){
            $report .= $debugger." Found SLA Filter: <B>".$sla_filter_name."</B> [ID: ".$sla_filter_sla_id."]<BR>";
            }

         // Must pack in array for later use in checking within emails for server name
         $sla_pack[$sla_filter_sla_id]=$sla_filter_name;

         } // end sla for

      } // end for filterbits

   if (is_array($sla_pack)){

      foreach ($sla_pack as $sla_id => $sla_name){ 

              $sla_object_type = "ServiceSLARequests";
              $sla_action = "select";
              $sla_params[0] = " id='".$sla_id."' ";
              $sla_params[1] = ""; // select array
              $sla_params[2] = ""; // group;
              $sla_params[3] = ""; // order;
              $sla_params[4] = ""; // limit
  
              $sla_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sla_object_type, $sla_action, $sla_params);

              if (is_array($sla_list)){

                 for ($sla_cnt=0;$sla_cnt < count($sla_list);$sla_cnt++){

                     $sclm_sla_id_c = $sla_list[$sla_cnt]['sclm_sla_id_c'];

                     if ($sclm_sla_id_c != NULL){

                        $sla_params[5] = $sclm_sla_id_c;
                        $sla_params[11] = $date;
                        $sla_return = $this->check_sla ($sla_params);
                        $sla_status = $sla_return[0];

                        if ($sla_status == 1){
                           $sclm_serviceslarequests_id_c = $sla_id;

                           if ($create_report == TRUE){
                               $report .= $debugger."SLA Live Status for selected SLA <B>[".$sla_name."]</B><BR>";
                               }

                           } // if sla status OK

                        } // if sclm_sla_id_c

                     } // for sla

                 } // if array

              } // foreach

      } // is array sla_pack

  # End get sla
  ##########################################
  # If reply activity is set

  if ($create_activity_ticket_id != NULL){

     $michimail = FALSE;
     $match = TRUE;
     $create_activity = TRUE;
     $create_ticket = FALSE;
     $create_email = TRUE;

     } else {

     if ($do_catchall != TRUE){
        $match = FALSE;
        }

     # Set the count for the triggers that must be met to satisfy the filter conditions
     $trigger_rate = 0;

     #########################################
     # Use Filtering Set to get servers

     $servermatch = FALSE;

     for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

         $filterbit_id = $filterbits[$cntfb]['id'];
         $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
 
         if ($filterbit_configurationitemtypes_id_c == '6de9b547-7c78-9ff4-83ea-52a8dc7f33f1'){
            $server_filter_server_id = $filterbits[$cntfb]['name'];
            if ($server_filter_server_id){
               $server_returner = $this->object_returner ("ConfigurationItems", $server_filter_server_id);
               $server_filter_name = $server_returner[0];

               if ($create_report == TRUE){
                  $report .= $debugger." Found Server Filter: <B>".$server_filter_name."</B> [ID: ".$server_filter_server_id."]<BR>"; 
                  }

               # Must pack in array for later use in checking within emails for server name
               $server_show .= $server_filter_name."<BR>";
               $server_pack[$server_filter_server_id]=$server_filter_name;
               if ($body != $this->replacer($server_filter_name, "", $body)){
                  $servermatch = TRUE;
                  $filterbit_touched = TRUE;

                  if ($create_report == TRUE){
                     $report .= $debugger."Server Filter found in email ([ID: ".$email_id."]: <B>".$server_filter_name."</B><BR>"; 
                     }

                  } elseif ($this->replacer(strtolower($server_filter_name),"",$body) != $body){

                  $servermatch = TRUE;
                  $filterbit_touched = TRUE;

                  if ($create_report == TRUE){
                     $report .= $debugger." Server Filter (lowercase) found in email: <B>".$server_filter_name."</B><BR>";
                     }

                  } elseif  ($this->replacer(strtoupper($server_filter_name),"",$body) != $body){

                  $servermatch = TRUE;
                  $filterbit_touched = TRUE;

                  if ($create_report == TRUE){
                     $report .= $debugger." Server Filter (lowercase) found in email: <B>".$server_filter_name."</B><BR>";
                     }

                  } else {

                  if ($create_report == TRUE){
                     $report .= $debugger." Server Filter (UPPER or LOWER) NOT matching: <B>".$server_filter_name."</B><BR>";
                     }

                  }

               if ($servermatch != TRUE){
                  $match = FALSE;
                  $servermatch = FALSE;

                  if ($create_report == TRUE){
                     $report .= $debugger." Server Filter NOT matching: <B>FALSE</B><BR>";
                     }

                  } else {

                  if ($create_report == TRUE){
                     $report .= $debugger." Server Filter Matching: <B>TRUE</B><BR>";
                     }

                  }

               } else {

               if ($create_report == TRUE){
                  $report .= $debugger." Error Found Server Filter but no ID in name field: <B>".$server_filter_name."</B><BR>";
                  }

               }

            # Add sla to email/ticket info - may be more than one, but 

           } // end if server

         } // end for filterbits

      # End get servers
      ##########################################
      # Use Filtering Set to get Sender

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '97ea1d7a-3243-4df3-38f4-52a8dc5793b4'){
          $sender = $filterbits[$cntfb]['name']; // the actual ID of the sender item
          if ($sender){
             #$sender_returner = $this->object_returner ("ConfigurationItems", $sender_filter_sender_id);
             #$sender_filter_name = $sender_returner[0];

             if ($create_report == TRUE){
                $report .= $debugger." Found Sender Filter: <B>".$sender."</B><BR>";
                }

             // Must pack in array for later use in checking within emails for server name
             $sender_pack[]=$sender;

             if (!$addressees_pack){
                $addressees_pack = $sender;
                } else {
                $addressees_pack = $addressees_pack.",".$sender;
                }

             } else {// end if sender_filter_sender_id

             if ($create_report == TRUE){
                $report .= $debugger." Error Found Sender Filter but no ID in name field: <B>".$sender."</B><BR>";
                }

             }

          } // end if Sender

       # Add a feature to reply to sender??
       # Add Sender to email/ticket info - may be more than one, but 
       # $process_params[] = array('name'=>'extra_addressees','value' => $addressees_pack);

       } // end for filterbits

   # End get sender
   ##########################################
   # Check for filter string

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68'){
          $filter_string = $filterbits[$cntfb]['name'];
          $filter_strings[] = $filter_string; 

          if ($create_report == TRUE){
             $report .= $debugger." Filter String: <B>".$filter_string."</B><BR>";
             } 

          } // if filter_string

       } // end for filterbits

   # End check for string
   ##########################################
   # Check for filter non-strings

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'afc56334-a00e-12d3-66ce-52d0f6cf46ec'){
          $filter_nonstring = $filterbits[$cntfb]['name'];
          $filter_nonstrings[] = $filter_nonstring; 

          if ($create_report == TRUE){
             $report .= $debugger." Filter Non-String: <B>".$filter_nonstring."</B><BR>";
             } 

          } // if filter_string

       } // end for filterbits

   # End check for non-strings
   ##########################################
   # Check for filter Server/IPs

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'ef1bdff1-4df1-1562-7bd9-52c04ed4dae7'){
          $filter_ipserver_set_name = $filterbits[$cntfb]['name'];
          $filter_ipservers = $filterbits[$cntfb]['description'];

          if ($filter_ipservers != NULL){

             $ipservers_to_array = explode(',',$filter_ipservers); //split string into array seperated by ','

             foreach ($ipservers_to_array as $ipserver){
                     $ipserver_show .= "Server/IP: ".$ipserver."<BR>";
                     $ipserver_pack[] = $ipserver;

                     } // end for

             } // end if recp_cc_list

          if ($create_report == TRUE){
             $report .= $debugger." Filter Server/IP Set: <B>".$filter_ipserver_set_name."</B><BR>";
             }

          } // if filter_string

       } // end for filterbits

   # End check for IPs
   ##########################################
   # Check for filter non-Servers/IPs

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'd3ce77c0-aa02-e4e3-8e67-52d1ef420dde'){
          $filter_nonipserver_set_name = $filterbits[$cntfb]['name'];
          $filter_nonipservers = $filterbits[$cntfb]['description'];

          if ($filter_nonipservers != NULL){
             $nonipservers_to_array = explode(',',$filter_nonipservers); //split string into array seperated by ','
             foreach ($nonipservers_to_array as $nonipserver){
                     $nonipserver_show .= "Non-Server/IP: ".$nonipserver."<BR>";
                     $nonipserver_pack[] = $nonipserver;
                     }
             } // end if recp_cc_list

          if ($create_report == TRUE){
             $report .= $debugger." Filter OUT Server/IP Set: <B>".$filter_nonipserver_set_name."</B><BR>";
             }

          } // if filter_string

       } // end for filterbits

   # End check for IPs
   ##########################################
   # Check for filter triggers

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       $sender_match = "";
       $subject_match = "";
       $subod_match = "";
       $body_match = "";
       $mm_match = "";

       if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2'){
  
          $filter_trigger = $filterbits[$cntfb]['name'];

          switch ($filter_trigger){

           ##################################
           # Trigger->Sender Match

           case '4f3d2814-e8ff-18a0-3d0f-52b8d841b39e': // sender email only

            if (is_array($sender_pack)){
               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE;
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger -> Email only: <B>".$from_mailname."=".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               #$match = FALSE;
               } 

            if ($sender_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               } 

           break; 
           # End Trigger->email only filter check
           ##################################
           # Trigger->Sender and Body String Match
           case 'a5d69649-6e50-56e1-d52c-52b8ddb43cd0':

            if (is_array($sender_pack)){

               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched One!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; 
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger -> Email: <B>".$from_mailname." with ".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               $sender_match = FALSE;
               }

            if (is_array($filter_strings)){

               foreach ($filter_strings as $filter_string){

                       if ($body != $this->replacer($filter_string,"",$body)){
                          $body_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$body_match = FALSE;
                          $bodystring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger -> AND Body String: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if is_array($filter_strings)

            if ($sender_match == TRUE && $body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           break;
           # End Trigger->Sender and Body String Match
           ##################################
           # Trigger->Subject or Body String Match
           case '275f496d-eab4-6cf3-3add-52e191ce3241':

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($body != $this->replacer($filter_string,"",$body)){
                          $body_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          //$match = FALSE; 
                          $bodystring_result = "Not Matched!";
                        
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  Body String Match: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if string array

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $this->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; // also thus negates the above if TRUE
                          $subjectstring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  Subject($subject) not exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE || $body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           break;
           # End Trigger->Subject or Body String Match
           ##################################
           # Trigger->Sender and Subject Exact String Match
           case '6e27808f-9fa0-f469-d04d-52b8dcb4bc8a':

            if (is_array($sender_pack)){

               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$sender_match = FALSE; 
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger -> Email: <B>".$from_mailname." with ".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               $sender_match = FALSE;
               } 
                                            
            if (is_array($filter_strings)){

               foreach ($filter_strings as $filter_string){

                       if ($filter_string == $subject){
                          $subject_match = TRUE;
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                         //$subject_match = FALSE; 
                          $subjectstring_result = "Not Matched!";
                          }

                       } // foreach

               } // if is array

            if ($sender_match == TRUE && $subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

            if ($create_report == TRUE){
               $report .= $debugger." Filter Trigger ->  Subject Exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
               }

           break;
           # End Trigger->Sender and Subject Exact String Match
           ##################################
           # Trigger->Sender and Subject Not Exact String Match
           case '9dcd893b-93bb-ade3-57d5-52d08a4cdb09':

            $subject_match = "";
            $sender_match = "";

            if (is_array($sender_pack)){

               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; 
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger -> Email: <B>".$from_mailname." with ".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               $sender_match = FALSE;
               } 
                                            
            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $this->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; // also thus negates the above if TRUE
                          $subjectstring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  Subject($subject) not exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE && $sender_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           break;
           # End Trigger->Sender and Subject Not Exact String Match
           ##################################
           # Trigger->String Exactly Matches Subject Only
           case '9dc67d76-b728-5a03-f8bf-52b8daf4da69':

            $subject_match = "";

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($filter_string != $subject){
                          //$subject_match = FALSE;
                          $subjectstring_result = "Not Matched!";
                          } else {
                          $subject_match = TRUE; 
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          }

                       } // foreach

               } // if is array

            if ($create_report == TRUE){
               $report .= $debugger." Filter Trigger ->  Subject Exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
               }

            if ($subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           break; 
           # End Trigger->String Exactly Matches Subject Only
           ##################################
           # Trigger->String in Body
           case '50be0484-2daf-dd18-0b6b-52b8da93e1df':

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($body != $this->replacer($filter_string,"",$body)){
                          $body_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          //$match = FALSE; 
                          $bodystring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  Body String Match: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if

            if ($body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               #$match = FALSE;
               }

           break;
           # End Trigger->String in Body
           ##################################
           # Trigger->Multiple Strings in Body-any OK
           case '21a5e0a4-e760-351b-e606-52c8e5f5ce89':

            if (is_array($filter_strings)){

               $mm_match = FALSE;

               foreach ($filter_strings as $filter_string){

                       if ($body != $this->replacer($filter_string,"",$body)){
                          $mm_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          //$match = FALSE; 
                          $bodystring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  Body String Match (Multiple): <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if is array

            if ($mm_match == TRUE){
               $match = TRUE;
               $bodystring_result = "Final Match!";
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               $bodystring_result = "Finally NO Match!";
               } 

            if ($create_report == TRUE){
               $report .= $debugger." Filter Trigger ->  Body String Match (Multiple): <B>".$bodystring_result."</B><BR>";
               }

           break;
           # End Trigger->Multiple Strings in Body-any OK
           ##################################
           # Trigger->String in Subject Only
           case 'b52694ac-cf4d-839e-3a74-52b8da5eb6c0': 

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $this->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result .= $filter_string." Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          $subject_match = FALSE; // also thus negates the above if previously TRUE or ignores if after this
                          $subjectstring_result .= $filter_string." Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  String in Subject ($subject) String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               } 

           break;
           # End Trigger->String in Subject Only
           ##################################
           # Trigger->All Strings must be in Subject
           case '6ffb1f7d-273e-6bc9-9688-532706510ec4': 

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $this->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result .= " Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          $subject_false_match = TRUE; // also thus negates the above if previously TRUE or ignores if after this
                          $subjectstring_result .= " Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  String in Subject ($subject) String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE && $subject_false_match != TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               } 

           break;
           # End Trigger->String in Subject Only
           ##################################
           # Trigger->String NOT in Subject or Body
           case 'ec244f7a-9ba9-7de6-2ead-52d08b86f607':

            # Non-servers are designed to remove rubbish more than to act upon - so are not for a trigger count
            $triggercount = $triggercount-1;

            if ($create_report == TRUE){
               $report .= $debugger." Filter Trigger ->  Checking for Non-String in Subject or Body<BR>";
               }

            if (is_array($filter_nonstrings)){

               foreach ($filter_nonstrings as $filter_nonstring){

                       if ($subject != $this->replacer($filter_nonstring,"",$subject)){
                          //$match = TRUE;
                          $subod_match = FALSE;
                          $nostring = TRUE;
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;

                          if ($create_report == TRUE){
                             $report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") FOUND in Subject<BR>";
                             }

                          } elseif ($subject != $this->replacer (strtoupper($filter_nonstring),"",$subject)) {
                            $subod_match = FALSE;
                            $nostring = TRUE;
                            $filterbit_touched = TRUE;

                            if ($create_report == TRUE){
                               $report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") CAPS FOUND in Subject<BR>";
                               }

                          } elseif ($subject != $this->replacer (strtolower($filter_nonstring),"",$subject)) {
                            $subod_match = FALSE;
                            $nostring = TRUE;
                            $filterbit_touched = TRUE;

                            if ($create_report == TRUE){
                               $report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") LOWER FOUND in Subject<BR>";
                               }

                          } // if

                       if ($body != $this->replacer($filter_nonstring,"",$body)){
                          //$match = TRUE; // also thus negates the above if TRUE
                          $subod_match = FALSE; 
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          $nostring = TRUE;

                          if ($create_report == TRUE){
                             $report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") FOUND in Body<BR>";
                             }

                          } // if

                       } // foreach

               } // is array strings

            if ($subod_match == FALSE){
               $match = FALSE;
               #$trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!

               if ($create_report == TRUE){
                  $report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") NOT in Subject or Body<BR>";
                  }

               } 

           break;
           # End Trigger->String NOT in Subject or body
           ##################################
           # Trigger->Filter OUT Servers/IPs from List
           case 'a0faabd3-32ce-1495-9616-52d1f105cac5':

            # Non-servers are designed to remove rubbish more than to act upon
            $triggercount = $triggercount-1;

            if (is_array($nonipserver_pack)){

               $subjectstring_result = "";
               $noipserverstring = "";

               foreach ($nonipserver_pack as $filter_nonserverip){

                       if ($body != $this->replacer($filter_nonserverip,"",$body)){
                          $body_match = FALSE; 
                          $filterbit_touched = TRUE;
                          $noipserverstring = TRUE;
                          $subjectstring_result .= $filter_nonserverip.": Matched!<BR>";
                          } elseif ($body != $this->replacer (strtoupper ($filter_nonserverip),"",$body)) {
                            $body_match = FALSE;
                            $noipserverstring = TRUE;
                            $filterbit_touched = TRUE;
                            $subjectstring_result .= strtoupper ($filter_nonserverip).": Matched!<BR>";
                          } elseif ($body != $this->replacer(strtolower ($filter_nonserverip),"",$body)) {
                            $body_match = FALSE;
                            $filterbit_touched = TRUE;
                            $noipserverstring = TRUE;
                            $subjectstring_result .= strtolower ($filter_nonserverip).": Matched!<BR>";
                          }

                       if ($create_report == TRUE){
                          $report .= $debugger." Filter Trigger ->  Non-Server/IP (".$filter_nonserverip.") <B>".$subjectstring_result."</B><BR>";
                          }

                       } // foreach

               } // is array filter_nonserverips

            if ($body_match == FALSE){
               $match = FALSE;
               #$trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               //$match = TRUE;
               } 

            if ($noipserverstring == TRUE){
               $nostring = TRUE;
               }

           break;
           # End Trigger->filter_nonserverips in Body
           ##################################
           # Trigger->catch-all
           case 'a51b8e41-bb1b-f729-2c59-52ccc314bc0a':
           # Catch-all
           # If no match - collect any remining email based on senders and create ticket

            $addreport = TRUE;

            if ($create_report == TRUE){
               $report .= $debugger." Filter Trigger Catch-All - based on other rules in the Filter for Email: <B>".$from_mailname." with Subject: ".$subject."</B>. If the rules in this filter are FALSE - then no email will be delivered.<BR>";
               }

           break;

           # End Trigger->catch-all
           ##################################

          } // switch

          } // if filtertriggers

       } // end for filterbits

   # End check for filtertriggers
   ##########################################
   # May find other text, but if no IPs or servers found, then no match

   if (is_array($ipserver_pack)){

      foreach ($ipserver_pack as $check_ipserver){
  
              if ($body != $this->replacer($check_ipserver,"",$body)){
                 $ipservermatch = TRUE; 
                 $filterbit_touched = TRUE;
                 $ipbodystring_result .= "Matched $check_ipserver!<BR>";
                 } elseif ($body != $this->replacer(strtoupper ($check_ipserver),"",$body)){
                 $ipservermatch = TRUE; 
                 $filterbit_touched = TRUE;
                 $ipbodystring_result .= "Matched UPPERCASE ".strtoupper ($check_ipserver)."!<BR>";
                 } elseif ($body != $this->replacer(strtolower ($check_ipserver),"",$body)){
                 $ipservermatch = TRUE; 
                 $filterbit_touched = TRUE;
                 $ipbodystring_result .= "Matched lowercase ".strtolower ($check_ipserver)."!<BR>";
                 }

              } // foreach ip_pack

      if ($ipservermatch == TRUE){

         # There was no other hit so just a server is not good enough to make TRUE
         if ($match != FALSE){
            $match = TRUE;
            } else {

            if ($create_report == TRUE){
               $report .= $debugger." There was no other hit so just a server hit is not good enough to make TRUE<BR>";
               }

            }

         $trigger_rate = $trigger_rate + 1;
         } else {// if not true - then false!
         $match = FALSE;
         $ipbodystring_result = "No Match!";
         }

      if ($create_report == TRUE){
         $report .= $debugger." Filter Server/IP Set: <B>".$ipbodystring_result."</B><BR>";
         }

      } // is array IPs

   # End check for ips
   ##########################################
   # Check for time ranges

   $beforedatesmatch = $match;

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '291f5d67-13af-1b11-7e39-52b9d60288dc'){
          $filter_timerange = $filterbits[$cntfb]['name'];
          list($start_time,$end_time) = explode("_", $filter_timerange);
                                      
          $start_time = date('H:i', strtotime($start_time));
          $end_time = date('H:i', strtotime($end_time));
          $emailtime = date('H:i', strtotime($date));
          #list($email_hour,$email_minute) = explode(":", $emailtime);

          if ($emailtime > $start_time && $emailtime < $end_time){
             $timematch = TRUE;
             $filterbit_touched = TRUE;
             $trigger_rate = $trigger_rate + 1;
             $email_between_time_range_match = TRUE;
             $email_between_time_range_debug = "Time Range is a match!";
             } else {
             $timematch = FALSE;
             $email_between_time_range_match = FALSE;
             $email_between_time_range_debug = "Time Range is not a match!";
             }

          if ($create_report == TRUE){
             $report .= $debugger." Filter Time Range: <B>".$filter_timerange."</B> if ($emailtime > $start_time && $emailtime < $end_time){ for;<BR>
Email: ".$emailtime."<BR> 
Start Time: ".$start_time."<BR>
End Time: ".$end_time."<BR>
Result: ".$email_between_time_range_debug."<BR>";
             }

          } // if filter_timerange

       } // end for filterbits

   # End check for time ranges
   ##########################################
   # Check for date ranges
   # if ((is_array($filter_strings) || is_array($filter_nonstrings)) && $match != FALSE){

   $datematch = "";

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'ecf521df-6ff1-aa5c-0069-52b9d605f284'){
          $filter_daterange = $filterbits[$cntfb]['name'];
          list($start_date,$end_date) = explode("_", $filter_daterange);
          $start_date = date('d/m/Y', strtotime($start_day));
          $end_date = date('d/m/Y', strtotime($end_day));
          $email_date = date('d/m/Y', strtotime($date));

          if ($email_date >= $start_date && $email_date <= $end_date){
             $datematch = TRUE;
             $filterbit_touched = TRUE;
             $trigger_rate = $trigger_rate + 1;
             $email_between_date_range_match = TRUE;
             $email_between_date_range_debug = "Date Range is a match!";
             } else {
             $datematch = FALSE;
             $email_between_date_range_match = FALSE;
             $email_between_date_range_debug = "Date Range is not a match!";
             }

          if ($create_report == TRUE){
             $report .= $debugger." Filter Date Range: <B>".$filter_daterange."</B> ($email_date > $start_date && $email_date < $end_date) <BR>
Start Date: ".$start_date."<BR>
End Date: ".$end_date."<BR>
Email Date: ".$email_date."<BR>
Result: ".$email_between_date_range_debug."<BR>";
             }

          } // if filter_daterange

       } // end for filterbits

   # End check for date ranges
   ##########################################
   # Check for day ranges

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'bb105bd2-6d5d-e9b1-dc66-52ba021e1f63'){
          $filter_dayrange = $filterbits[$cntfb]['name'];
          list($start_day,$end_day) = explode("_", $filter_dayrange);
          $emailday = date("l", strtotime($date)); // Day of the email
          $emailday_date = date('Y-m-d', strtotime($date));

          #$date = date('Y-m-d H:i:s', $udate);
          $emaildate_plus_one_day = date('Y-m-d', strtotime($date .' +1 day'));
          $emaildate_plus_two_days = date('Y-m-d', strtotime($date .' +2 days'));
          $emaildate_plus_three_days = date('Y-m-d', strtotime($date .' +3 days'));
          $emaildate_plus_four_days = date('Y-m-d', strtotime($date .' +4 days'));
          $emaildate_plus_five_days = date('Y-m-d', strtotime($date .' +5 days'));
          $emaildate_plus_six_days = date('Y-m-d', strtotime($date .' +6 days'));

          $emaildate_minus_one_day = date('Y-m-d', strtotime($date .' -1 day'));
          $emaildate_minus_two_days = date('Y-m-d', strtotime($date .' -2 days'));
          $emaildate_minus_three_days = date('Y-m-d', strtotime($date .' -3 days'));
          $emaildate_minus_four_days = date('Y-m-d', strtotime($date .' -4 days'));
          $emaildate_minus_five_days = date('Y-m-d', strtotime($date .' -5 days'));
          $emaildate_minus_six_days = date('Y-m-d', strtotime($date .' -6 days'));

          if ($emailday == $start_day){
             $start_day_date = $emailday_date;
             } elseif ($start_day == date('l', strtotime($date .' -1 day'))){
             $start_day_date = $emaildate_minus_one_day;
             } elseif ($start_day == date('l', strtotime($date .' -2 days'))){
             $start_day_date = $emaildate_minus_two_days; 
             } elseif ($start_day == date('l', strtotime($date .' -3 days'))){
             $start_day_date = $emaildate_minus_three_days; 
             } elseif ($start_day == date('l', strtotime($date .' -4 days'))){
             $start_day_date = $emaildate_minus_four_days; 
             } elseif ($start_day == date('l', strtotime($date .' -5 days'))){
             $start_day_date = $emaildate_minus_five_days; 
             } elseif ($start_day == date('l', strtotime($date .' -6 days'))){
             $start_day_date = $emaildate_minus_six_days; 
             }

          # Work out the start date and then add the end date from that
          if ($end_day == $start_day){
             $end_day_date = $start_day_date;
             } elseif ($end_day == date('l', strtotime($start_day_date .' +1 day'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +1 day'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +2 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +2 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +3 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +3 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +4 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +4 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +5 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +5 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +6 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +6 days'));
             }

          if ($emailday_date >= $start_day_date && $emailday_date <= $end_day_date){
             $daymatch = TRUE;
             $filterbit_touched = TRUE;
             $email_between_day_range_match = TRUE;
             $email_between_day_range_debug = "Day Range is a match!";
             $trigger_rate = $trigger_rate + 1;
             } else {
             $daymatch = FALSE;
             $email_between_day_range_match = FALSE;
             $email_between_day_range_debug = "Day Range is not a match!";
             }

          if ($create_report == TRUE){
             $report .= $debugger." Filter Day Range: <B>".$filter_dayrange."</B> with ($emailday_date > $start_day_date && $emailday_date < $end_day_date) for;<BR>
Email Day: ".$emailday." = ".$emailday_date."<BR>
Start: ".$start_day." = ".$start_day_date."<BR>
End: ".$end_day." = ".$end_day_date."<BR>
Result: ".$email_between_day_range_debug."<BR>";
             }

          } // if filter_dayrange

       } // end for filterbits

   # End check for day ranges
   ##########################################
   # Check for time AND day ranges if exists first, then if concat

   $do_datetimeconcat = FALSE;

   if ($start_time && $end_time && $start_day_date && $end_day_date){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
 
          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          if ($filterbit_configurationitemtypes_id_c == 'cc55a107-98ca-8261-9900-52ce36601cd0'){
             $filter_datetimeconcat = $filterbits[$cntfb]['name'];

             $full_start_date = $start_day_date." ".$start_time;
             $full_end_date = $end_day_date." ".$end_time;

             if ($filter_datetimeconcat == 1){
                # This is available and thus requires concat check
                $do_datetimeconcat = TRUE;
                } // if filter_datetimeconcat

             } // end if ($filterbit_configurationitemtypes_id_c

          } // end for filterbits

      if ($do_datetimeconcat == TRUE){

         $email_datetime = date('Y-m-d H:i', strtotime($date));

         if ($email_datetime >= $full_start_date && $email_datetime <= $full_end_date){
            $timedateday = TRUE;
            $email_between_datetime_range_debug = "Datetime Range is a match!";
            if ($timematch == FALSE){
               $trigger_rate = $trigger_rate + 2;
               } else {
               $trigger_rate = $trigger_rate + 1;
               }
            } else {
            $timedateday = FALSE;
            $email_between_datetime_range_debug = "Datetime is not a Match!";
            }

         if ($create_report == TRUE){
            $report .= $debugger." We see both a Filter Date AND Time Range, so we have to put them together and see if that becomes a match: <B>if ($email_datetime > $full_start_date && $email_datetime < $full_end_date){</B><BR>
Start Date: ".$full_start_date."<BR>
End Date: ".$full_end_date."<BR>
Email Date: ".$email_datetime."<BR>
Result: ".$email_between_datetime_range_debug."<BR>";
            }

         } else { // end if ($do_datetimeconcat

         } 

      if ($do_datetimeconcat == FALSE) { 

         $report .= $debugger." No Concat checker<BR>";

         if ($daymatch == FALSE || $timematch == FALSE){

            $timedateday = FALSE;

            if ($create_report == TRUE){
               $report .= $debugger." Day no match, time no match: FALSE<BR>";
               }

            } elseif ($daymatch == TRUE && $timematch == TRUE){

            $timedateday = TRUE;

            if ($create_report == TRUE){
               $report .= $debugger." Day is match, time is match: TRUE<BR>";
               }

            } elseif ($daymatch == FALSE && $timematch == TRUE){

            $timedateday = FALSE;

            if ($create_report == TRUE){
               $report .= $debugger." Day no match, time is match: FALSE<BR>";
               }

            } elseif ($daymatch == TRUE && $timematch == FALSE){

            $timedateday = FALSE;

            if ($create_report == TRUE){
               $report .= $debugger." Day is match, time no match: FALSE<BR>";
               }

            } else {// if day and time are false then false
            $timedateday = FALSE;
            }

         } // end else if datetime check

      } else {

      # First check to see if such time rules exist before true and flase check

      if ($create_report == TRUE){
         $report .= $debugger." No Day and Time parts together - must see if seperately and if true/false<BR>";
         }

      if ($daymatch == TRUE || $daymatch == FALSE && $daymatch != NULL){
         if ($daymatch == TRUE){
            $timedateday = TRUE;
            $timedateday_show = "1-TRUE";

            if ($create_report == TRUE){
               $report .= $debugger." IS Day Match Only:".$timedateday_show."<BR>";
               }

            } else {
            #$timedateday = "";
            $timedateday_show = "2-Nothing";

            if ($create_report == TRUE){
               $report .= $debugger." No Day Match Only:".$timedateday_show."<BR>";
               }

            } // end if true

         } // end true/false

      if ($timematch == TRUE || $timematch == FALSE && $timematch != NULL){// if exist to check
         if ($timematch == TRUE){
            $timedateday = TRUE;
            $timedateday_show = "3-TRUE";

            if ($create_report == TRUE){
               $report .= $debugger." IS Time Match Only:".$timedateday_show."<BR>";
               }

            } else {// end else
            #$timedateday = "";
            $timedateday_show = "4-Nothing";

            if ($create_report == TRUE){
               $report .= $debugger." No Time Match Only:".$timedateday_show."<BR>";
               }

            } // end if true

         } // end true/false

      } // end else

   $start_time = "";
   $end_time = "";
   $start_day_date = "";
   $end_day_date = "";

   # End Check for time AND day ranges
   ##########################################
   # Filters are not based on only dates
   # There must be some argument not true for dates to have any meaning.

   if ($create_report == TRUE){
      $report .= $debugger." BEFORE DATE MATCH VALUE  $beforedatesmatch and timedateday: $timedateday<P>";
      }

   $timedateday_show = "";
   if ($timedateday == TRUE || $timedateday == FALSE && $timedateday != NULL){
      if ($timedateday == TRUE && $beforedatesmatch == FALSE){
         $match = FALSE;
         $timedateday_show = "5FALSE";
         } elseif ($timedateday == TRUE && $beforedatesmatch == TRUE){
         $match = TRUE;
         $timedateday_show = "6TRUE";
         } elseif ($timedateday == FALSE && $beforedatesmatch == FALSE){
         $match = FALSE;
         $timedateday_show = "7FALSE";
         } elseif ($timedateday == FALSE && $beforedatesmatch == TRUE){
         $match = FALSE;
         $timedateday_show = "8FALSE";
         }
      } else {
      #$match = FALSE;
      #$timedateday_show = "FALSE";
      }

   if ($create_report == TRUE){
      $report .= $debugger." FINAL DATE MATCH VALUE: [$timedateday] Match: [$match] $timedateday_show<P>";
      }

   if ($nostring == TRUE){
      $match = FALSE;
      }

   ##########################################
   # Trigger Count

   if ($create_report == TRUE){
      $report .= $debugger." FINAL TRIGGER COUNT = ".$trigger_rate." && EXPECTED = ".$triggercount."<P>";
      }
  
   # End Trigger Count
   ##########################################
   # Check for create ticket

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '1078abaa-0615-06ef-9826-52b0d6f32290'){
          $filter_createticket = $filterbits[$cntfb]['name'];
          if ($filter_createticket == 1){
             $create_ticket = TRUE;
             }

          if ($create_report == TRUE){
$filter_createticket_show = $this->yesno($filter_createticket);
$report .= $debugger." Filter Create Ticket: <B>".$filter_createticket_show."</B><BR>";
             }

          } // if filter_createticket

       } // end for filterbits

   # End check for create ticket
   ##########################################
   # Check for create email

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '99490a5c-8f51-6652-a121-52bfac638c32'){
          $filter_createmail = $filterbits[$cntfb]['name'];

          if ($filter_createmail == 1){
             $create_email = TRUE;
             }

          if ($create_report == TRUE){
             $filter_createmail_show = $this->yesno($filter_createmail);
             $report .= $debugger." Filter Create Email: <B>".$filter_createmail_show."</B><BR>";
             }

          } // if filter_createmail

       } // end for filterbits

   # End check for create email
   ###################################
   # Check for servers status as a filter item

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2'){
          $filter_trigger = $filterbits[$cntfb]['name'];

          switch ($filter_trigger){

           case 'ebf1233d-4415-a3b8-f8aa-52cee1526e02': // Multiple Servers are down 

            if ($create_report == TRUE){
               $report .= $debugger." Checking if Multiple Servers are down <BR>";
               }

            if (is_array($server_pack)){

               $matchcnt=0;

               foreach ($server_pack as $filter_server_id=>$filter_server_name){
                                                       
                       # Check the server status and count them >1

                       if ($create_report == TRUE){
                          $report .= $debugger." Checking for Server: <B>".$filter_server_name."</B><BR>";
                          }

                       $serverbit_object_type = "ConfigurationItems";
                       $serverbit_action = "select";
                       # parent CI will be the registered server (also a CI)
                       # not the filter as we may use this filter for other purposes
                       # The type is Live Status 1/0
                       $serverbit_type_id = '423752fe-a632-9b4d-8c3b-52ccc968fe59';
                       $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                       $serverbit_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                       $serverbit_params[2] = ""; // group;
                       $serverbit_params[3] = ""; // order;
                       $serverbit_params[4] = ""; // limit
  
                       $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                       if (is_array($serverbits)){

                          for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                              $server_status_id = $serverbits[$srvbitcnt]['id'];
                              $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                              $server_status = $serverbits[$srvbitcnt]['name']; // 1/0

                              switch ($server_status){

                               case '':
                                $server_status_show = "NA";
                                #$matchcnt++;
                               break;
                               case '1':
                                $server_status_show = $strings["CI_ServerStatusOnline"];
                                #$matchcnt++;
                               break;
                               case '0':
                                $server_status_show = $strings["CI_ServerStatusOffline"];
                                $matchcnt++;
                               break;

                              } // switch

                              if ($create_report == TRUE){
                                 $report .= $debugger." Server Status Check($matchcnt): <B>".$server_status_show."</B><BR>";
                                 }

                              } // foreach serverbits

                          } // if serverbits array

                       } // foreach server_pack

               if ($matchcnt>1){
                  $match = TRUE; //  Send out the email/ticket
                  $server_status_show = "Send out the email/ticket";
                  $trigger_rate = $trigger_rate + 1;
                  } else {
                  $match = FALSE; //  Don't Send out the email/ticket
                  $server_status_show = "Don't Send out the email/ticket";
                  } // end cnt

               if ($create_report == TRUE){
                  $report .= $debugger." Server More than one is down Check: <B>".$server_status_show."</B><BR>";
                  }

               } // if server_pack array

           break; // end multiple servers

           } // switch for triggers

          } // if trigger type

       } // for filterbitsr

   # End Check for servers status as a filter item
   ##########################################
   # Check for Frequency trigger

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       # Get triggers if some other string has been found
       if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2' && $match == TRUE){
  
          $filter_trigger = $filterbits[$cntfb]['name'];

          if ($filter_trigger == '4241fe8d-450a-6ce6-87c2-52def2358317'){ // Frequency Count Match

             if ($create_report == TRUE){
                $report .= $debugger." Frequency Count Match Check Started<BR>";
                }

             # Get related timestamp IF available
             $freq_ts_object_type = "ConfigurationItems";
             $freq_ts_action = "select";
             $freq_ts_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='7a454f0d-3d12-7bc5-7607-52defc746103' ";
             $freq_ts_params[1] = "id,name,description"; // select array
             $freq_ts_params[2] = ""; // group;
             $freq_ts_params[3] = ""; // order;
             $freq_ts_params[4] = ""; // limit
  
             $freq_ts_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_ts_object_type, $freq_ts_action, $freq_ts_params);

             if (is_array($freq_ts_bits)){
                for ($cnt_tsfrq=0;$cnt_tsfrq < count($freq_ts_bits);$cnt_tsfrq++){
                    $freq_timestamp = $freq_ts_bits[$cnt_tsfrq]['name']; 
                    } // for freq_bits

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Timestamp Found: <B>".$freq_timestamp."</B><BR>";
                   }

                } else {// if freq_bits array
                # Must create first timestamp to start with
                $freq_ts_params[0] = $filter_id;
                $freq_timestamp = date('Y-m-d H:i:s', strtotime($date)); // use email date
                $freq_ts_params[1] = $freq_timestamp;
                $freq_ts_params[2] = 'frequency_timestamp';
                $freq_ts_updated = "";
                $freq_ts_updated = $this->update_items($freq_ts_params);

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Timestamp Created: <B>".$freq_timestamp."</B><BR>";
                   }

                } // else create timestamp

             # Should have timestamp - now get current count
             $freq_cnt_object_type = "ConfigurationItems";
             $freq_cnt_action = "select";
             $freq_cnt_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='c3891c31-9198-476d-0a8a-52df0e00c722' ";
             $freq_cnt_params[1] = "id,name,description"; // select array
             $freq_cnt_params[2] = ""; // group;
             $freq_cnt_params[3] = ""; // order;
             $freq_cnt_params[4] = ""; // limit
  
             $freq_cnt_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_cnt_object_type, $freq_cnt_action, $freq_cnt_params);

             if (is_array($freq_cnt_bits)){

                for ($cnt_cntfrq=0;$cnt_cntfrq < count($freq_cnt_bits);$cnt_cntfrq++){
                    $freq_curr_cnt = $freq_cnt_bits[$cnt_cntfrq]['name']; 
                    } // for freq_bits

                $firstround = FALSE;

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Count Found: <B>".$freq_curr_cnt."</B><BR>";
                   }

                } else {// if freq_bits array
                # Must create first timestamp to start with

                $firstround = TRUE;
                $freq_cnt_params[0] = $filter_id;
                $freq_curr_cnt = 1; // use email date
                $freq_cnt_params[1] = $freq_curr_cnt;
                $freq_cnt_params[2] = 'frequency_count';
                $freq_cnt_updated = "";
                $freq_cnt_updated = $this->update_items($freq_cnt_params);

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Count Created: <B>".$freq_curr_cnt."</B><BR>";
                   }

                } // else create timestamp

             # Should have timestamp and current count - now check if within the timestamp and count range
             # First get time-span

             $freq_sp_object_type = "ConfigurationItems";
             $freq_sp_action = "select";
             $freq_sp_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='278395e9-3127-dc1c-53ac-52def9c06c63' ";
             $freq_sp_params[1] = "id,name,description"; // select array
             $freq_sp_params[2] = ""; // group;
             $freq_sp_params[3] = ""; // order;
             $freq_sp_params[4] = ""; // limit
  
             $freq_sp_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_sp_object_type, $freq_sp_action, $freq_sp_params);

             if (is_array($freq_sp_bits)){

                for ($cnt_spfrq=0;$cnt_spfrq < count($freq_sp_bits);$cnt_spfrq++){
                    $freq_timespan = $freq_sp_bits[$cnt_spfrq]['name']; 
                    } // for freq_bits

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Time-span Found: <B>".$freq_timespan."</B><BR>";
                   }

                } else {// if freq_bits array
                # If not provided - use a default - send alert...
                $freq_timespan = 30; // default

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Default Time-span Set: <B>".$freq_timespan."</B><BR>";
                   }

                } // else count range

             # First get count range
             $freq_rng_object_type = "ConfigurationItems";
             $freq_rng_action = "select";
             $freq_rng_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='a19083b1-25bd-65be-76e8-52def587f20f' ";
             $freq_rng_params[1] = "id,name,description"; // select array
             $freq_rng_params[2] = ""; // group;
             $freq_rng_params[3] = ""; // order;
             $freq_rng_params[4] = ""; // limit
  
             $freq_rng_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_rng_object_type, $freq_rng_action, $freq_rng_params);

             if (is_array($freq_rng_bits)){

                for ($cnt_rngfrq=0;$cnt_rngfrq < count($freq_rng_bits);$cnt_rngfrq++){
                    $freq_cnt_range = $freq_rng_bits[$cnt_rngfrq]['name']; 
                    } // for freq_bits

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Count Range Found: <B>".$freq_cnt_range."</B><BR>";
                   }

                } else {// if freq_bits array
                # If not provided - use a default - send alert...
                $freq_cnt_range = 5; // default

                if ($create_report == TRUE){
                   $report .= $debugger." Frequency Default Count Range Set: <B>".$freq_cnt_range."</B><BR>";
                   }

                } // else count range

             # Do the actual check based on timestamp first
             # Add one minute for cronjob
             $freq_timespan = $freq_timespan+1;
             $freq_timespan = " +".$freq_timespan." minute";
             $freq_timestamp_plus_span = date("Y-m-d H:i:s", strtotime($freq_timestamp.$freq_timespan));
             #$freq_timestamp_plus_span = date("Y-m-d H:i:s", strtotime($freq_timestamp.' +$freq_timespan minutes'));
             $email_timestamp = date('Y-m-d H:i:s', strtotime($date));

             if ($email_timestamp <= $freq_timestamp_plus_span){
                # Check/Add a count
                if ($freq_curr_cnt < $freq_cnt_range){
                   # Not jackpot :(
                   # Add counter if not firstround
                   if ($firstround == FALSE){

                      $freq_new_cnt_params[0] = $filter_id;
                      $freq_curr_cnt++; // use email date
                      $freq_new_cnt_params[1] = $freq_curr_cnt;
                      $freq_new_cnt_params[2] = 'frequency_count';
                      $freq_new_cnt_updated = "";
                      $freq_new_cnt_updated = $this->update_items($freq_new_cnt_params);

                      } // add count

                   $freq_match = FALSE;

                   } elseif ($freq_curr_cnt >= $freq_cnt_range){ 
                     # Jackpot!! :))

                   $trigger_rate = $trigger_rate + 1;

                   if ($create_report == TRUE){
                      $report .= $debugger." Frequency Count Matched! Beauty!!<B>Time: ".$email_timestamp." || Expected Count: ".$freq_cnt_range." || Current Count: ".$freq_curr_cnt."</B><BR>";
                      }

                     # Re-set the counter to 0;
                     $freq_re_params[0] = $filter_id;
                     $freq_curr_cnt = 0; // use email date
                     $freq_re_params[1] = $freq_curr_cnt;
                     $freq_re_params[2] = 'frequency_count';
                     $freq_re_updated = "";
                     $freq_re_updated = $this->update_items($freq_re_params);

                     # Set as true
                     $freq_match = TRUE;

                   } // end count check

                } elseif ($email_timestamp > $freq_timestamp_plus_span){// if over timestamp span

                  if ($create_report == TRUE){
                     $report .= $debugger." Frequency Count Time Over - Re-set! Email Time ".$email_timestamp." || TimeSpan: ".$freq_timestamp_plus_span." </B><BR>";
                     }

                  # Must re-set the timestamp
                  $freq_re_params[0] = $filter_id;
                  $freq_timestamp = date('Y-m-d H:i:s', strtotime($date)); // use email date
                  $freq_re_params[1] = $freq_timestamp;
                  $freq_re_params[2] = 'frequency_timestamp';
                  $freq_re_updated = "";
                  $freq_re_updated = $this->update_items($freq_re_params);

                  # Re-set the counter to 0  - missed its chance!!
                  $freq_recnt_params[0] = $filter_id;
                  $freq_curr_cnt = 0; // use email date
                  $freq_recnt_params[1] = $freq_curr_cnt;
                  $freq_recnt_params[2] = 'frequency_count';
                  $freq_recnt_updated = "";
                  $freq_recnt_updated = $this->update_items($freq_recnt_params);

                  $freq_match = FALSE; // better luck next time!!

                } // over timestamp

             if ($freq_match == TRUE){

                $match = TRUE;

                if ($create_email == TRUE){
                   $create_email = TRUE;
                   }
                if ($create_ticket == TRUE){
                   $create_ticket = TRUE;
                   }

                } else {

                $match = FALSE;
                $create_email = FALSE;
                $create_ticket = FALSE;

                }

             } // if Frequency Count Match

          } // if triggers

       } // end for filterbits

   # End Frequency trigger
   ##########################################
   # Check for create activity - only to be nullified if the ticket states so

     } // end else if do create activity

   # End check for create activity based on an email
   ##########################################
   # Catch-all must be TRUE

   if ($do_catchall == TRUE){
      $match = TRUE;
      }

   # End Catch-all
   ##########################################
   # Use Filtering Set to get Notification Templates

   if ($match == TRUE && $create_email == TRUE){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          $server_links = "";

          if ($filterbit_configurationitemtypes_id_c == 'c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d'){

             $templ_id = $filterbits[$cntfb]['name']; // actual template ID
             $templ_filter_object_type = "ConfigurationItems";
             $templ_filter_action = "select";
             $templ_filter_params[0] = " id='".$templ_id."' ";
             $templ_filter_params[1] = "id,name,description"; // select array
             $templ_filter_params[2] = ""; // group;
             $templ_filter_params[3] = ""; // order;
             $templ_filter_params[4] = ""; // limit
  
             $templ_filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $templ_filter_object_type, $templ_filter_action, $templ_filter_params);

             if (is_array($templ_filters)){

                for ($cnttmplfltr=0;$cnttmplfltr < count($templ_filters);$cnttmplfltr++){

                    $templ_name = $templ_filters[$cnttmplfltr]['name'];
                    $templ_content = $templ_filters[$cnttmplfltr]['description']; 
                    $email_content = $this->replacer("\n", "<BR>", $templ_content);

                    # Strip Title of Email based on XXXXX
                    $startcheck = "";
                    $endcheck = "";
                    $startcheck = "";
                    $endcheck = "";
                    $message_pass = "";
                    $startcheck = $this->replacer("[TITLE_START]", "", $templ_content);
                    $endcheck = $this->replacer("[TITLE_END]", "", $templ_content);
                    if ($startcheck == $templ_content || $endcheck == $templ_content){
                       # Do nothing - they don't exist
                       } else {
                       $titlestartsAt = strpos($templ_content, "[TITLE_START]") + strlen("[TITLE_START]");
                       $titleendsAt = strpos($templ_content, "[TITLE_END]", $titlestartsAt);
                       $email_title = substr($templ_content, $titlestartsAt, $titleendsAt - $titlestartsAt);
                       $templ_content = $this->replacer("[TITLE_START]", "", $templ_content);
                       $templ_content = $this->replacer("[TITLE_END]", "", $templ_content);
                       $templ_content = $this->replacer($email_title, "", $templ_content);

                       if ($create_report == TRUE){
                          $report .= $debugger." Email Title: <B>".$email_title."</B><BR>";
                          }

                       } // end if title components exist

                    # General placeholders
                    #[TITLE_START] Email Title [TITLE_END]
                    #AGC-MT-009:
                    #->[DATEFROM]
                    #->[DATETO]
                    #->[VIRUS_COUNT]
                    #AGC-MT-011:
                    #->[COMPANY][CONTACT]

                    # Add email links for actual servers found
                    if (is_array($server_pack)){
                       // Create a pack of links for the email and ticket for reference
                       foreach ($server_pack as $server_filter_server_id=>$server_filter_name){
                                                        
                               $server_link = "Body@".$lingo."@ConfigurationItems@view@".$server_filter_server_id."@ConfigurationItems";
                               $server_link = $this->encrypt($server_link);
                               $server_links .= "\n".$server_filter_name.": http://".$hostname."/?pc=".$server_link;
                               }
                                                
                       } // if server array

                    if (is_array($ip_pack)){
                       #$server_replace .= $ip_show;
                       } // if server array

                    if ($server_links != NULL){
                       //$server_links .= "\n".$ip_show; // 
                       } // if server array

                    if ($server_links == NULL && $server_replace != NULL){
                       $server_links .= "\n".$server_replace;
                       }

                    if ($create_activity == TRUE){

                       $bodyarr = explode("\n", $body);
                       foreach ($bodyarr as $bodykey => $bodyvalue) {
                               $bodyarr[$bodykey] = '> ' . $bodyarr[$bodykey];
                               }

                       $body = implode("\n", $bodyarr);

                       } else { // end if activity

                       $email_title = $this->replacer("[SERVER]", $server_replace, $email_title);
                       $email_title = $email_title.": ".$subject;
                       $templ_content = $this->replacer("[SERVER]", $server_replace, $templ_content);

                       } 

                    if ($templ_content != $this->replacer("[ALERT_MESSAGE]","",$templ_content)){
                       $email_content = $this->replacer("[ALERT_MESSAGE]", $body, $templ_content);
                       } else {
                       $email_content = $email_content."\\".$body;
                       } 

                    #$email_content = str_replace("Event originator:", "Event originator:XXXXXXXXXX", $email_content);
                    #$email_content = str_replace("Event Severity:", "XXXXXXXXXXEvent Severity:", $email_content);
                    # Crude way to extract and implant the server names - assumes in above area..
                    # list($extracted_servers,$other) = explode("XXXXXXXXXX", $email_content);
                    # Use Server pack to search text
                    $bodydate_year = date('Y',strtotime($date));
                    $bodydate_month = date('m',strtotime($date));
                    $bodydate_day = date('d',strtotime($date));
                    $bodydate_hour = date('H',strtotime($date));
                    $bodydate_minute = date('i',strtotime($date));
                    $bodydate_second = date('s',strtotime($date));
                    //date('Y-m-d H:i:s'
                    if ($lingo == 'ja'){
                       $bodydate = $bodydate_year."年".$bodydate_month."月".$bodydate_day."日 ".$bodydate_hour."時".$bodydate_minute."分".$bodydate_second."秒";
                       } else {
                       $bodydate = $date;
                       }
 
                    $email_content = $this->replacer("[DATE]", $bodydate, $email_content);
                    $email_content .= "\n".$strings["CI_Servers"]."\n".$server_links;

                    if ($debug == TRUE){
                       $email_content = $this->replacer("\n", "<br>", $email_content);
                       }

                    if ($create_report == TRUE){
                       $report .= $debugger." Found Filter Template: <B>".$templ_name."</B><P>".$email_content."<BR>";
                       }

                    } // end templ for

                } // end templ array

             } // end templ type

          } // end for filterbits

      } // end if $create_email == TRUE

   # End get templ
   ############################################
   # Add File Attachments

   if ($match == TRUE){

      if (is_array($filespack)){

         $email_content .= "Attachments\n";

         foreach ($filespack as $filename->$link){
                                             
                 $email_content .= $filename.": ".$link."\n";

                 if ($create_report == TRUE){
                    $report .= $debugger." Filename: ".$filename.": ".$link."<BR>";
                    }

                 } // foreach

         } // is array

      } // match

   # End Add File Attachments
   ##########################################
   # Check for Recipients: TO/CC/BCC

   if ($match == TRUE && $create_email == TRUE){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          if ($filterbit_configurationitemtypes_id_c == 'be9692fa-5341-6934-7500-52ba77913179'){
             $recipient_to_id = $filterbits[$cntfb]['name'];

             $recip_to_object_type = "ConfigurationItems";
             $recip_to_action = "select";
             $recip_to_params[0] = " id='".$recipient_to_id."' ";
             $recip_to_params[1] = "id,name,description"; // select array
             $recip_to_params[2] = ""; // group;
             $recip_to_params[3] = ""; // order;
             $recip_to_params[4] = ""; // limit
  
             $recip_tos = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_to_object_type, $recip_to_action, $recip_to_params);

             if (is_array($recip_tos)){

                for ($cntrecpto=0;$cntrecpto < count($recip_tos);$cntrecpto++){

                    $recp_to_name = $recip_tos[$cntrecpto]['name'];
                    $recp_to_list = $recip_tos[$cntrecpto]['description']; 

                    if ($create_report == TRUE){
                       $report .= $debugger." Filter Recipient TO: <B>".$recp_to_name."</B> List: [".$recp_to_list."]<BR>";
                       }

                    } // end recipient_to_id for

                } // end recipient_to_id array

             } // if recipient_to_id

          } // end for filterbits

      } // end if $create_email == TRUE

   # End check for recipient_to_id
   ##########################################
   # Check for Recipients: CC

   if ($match == TRUE && $create_email == TRUE){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          if ($filterbit_configurationitemtypes_id_c == '45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0'){
             $recipient_cc_id = $filterbits[$cntfb]['name'];

             $recip_cc_object_type = "ConfigurationItems";
             $recip_cc_action = "select";
             $recip_cc_params[0] = " id='".$recipient_cc_id."' ";
             $recip_cc_params[1] = "id,name,description"; // select array
             $recip_cc_params[2] = ""; // group;
             $recip_cc_params[3] = ""; // order;
             $recip_cc_params[4] = ""; // limit
  
             $recip_ccs = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_cc_object_type, $recip_cc_action, $recip_cc_params);

             if (is_array($recip_ccs)){

                for ($cntrecpcc=0;$cntrecpcc < count($recip_ccs);$cntrecpcc++){

                    $recp_cc_name = $recip_ccs[$cntrecpcc]['name'];
                    $recp_cc_list = $recip_ccs[$cntrecpcc]['description']; 

                    if ($create_report == TRUE){
                       $report .= $debugger." Filter Recipient CC: <B>".$recp_cc_name."</B> List: [".$recp_cc_list."]<BR>";
                       }

                    } // end recipient_cc_id for

                } // end recipient_cc_id array

             } // if recipient_cc_id

          } // end for filterbits

      } // end if $create_email == TRUE

   # End check for recipient_cc_id
   ##########################################
   # Check for Recipients: BCC

   if ($match == TRUE && $create_email == TRUE){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          if ($filterbit_configurationitemtypes_id_c == '47e1b49f-4059-3d14-94c7-52ba7891d1b5'){
             $recipient_bcc_id = $filterbits[$cntfb]['name'];

             $recip_bcc_object_type = "ConfigurationItems";
             $recip_bcc_action = "select";
             $recip_bcc_params[0] = " id='".$recipient_bcc_id."' ";
             $recip_bcc_params[1] = "id,name,description"; // select array
             $recip_bcc_params[2] = ""; // group;
             $recip_bcc_params[3] = ""; // order;
             $recip_bcc_params[4] = ""; // limit
  
             $recip_bccs = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_bcc_object_type, $recip_bcc_action, $recip_bcc_params);

             if (is_array($recip_bccs)){

                for ($cntrecpbcc=0;$cntrecpbcc < count($recip_bccs);$cntrecpbcc++){

                    $recp_bcc_name = $recip_bccs[$cntrecpbcc]['name'];
                    $recp_bcc_list = $recip_bccs[$cntrecpbcc]['description']; 

                    if ($create_report == TRUE){
                       $report .= $debugger." Filter Recipient BCC: <B>".$recp_bcc_name."</B> List: [".$recp_bcc_list."]<BR>";
                       }

                    } // end recipient_bcc_id for

                } // end recipient_bcc_id array

             } // if recipient_bcc_id

          } // end for filterbits

      } // end if $create_email == TRUE

   # End check for recipient_bcc_id
   ##########################################
   # Actions to take before closing loop for each filter

   if ($create_report == TRUE){
      $report .= $debugger." Total Filter Hit-Rate=<font color=red size=5><B>".$filterbit_rate."</B></font><BR>";
      }

   $subject = $this->replacer("イヘント","イベント", $subject);
   $subject = $this->replacer("ショフ","ジョブ", $subject);
   $subject = $this->replacer("リカハリーホイントか作成てきない","リカバリーポイントが作成できない", $subject);
   $subject = $this->replacer("リカハリー","リカバリー", $subject);
   $subject = $this->replacer("ホイント","ポイント", $subject);
   $subject = $this->replacer("てきない","できない", $subject);
   $subject = mb_convert_encoding($subject, 'UTF-8', 'UTF-8');

   # Create Ticket if Match and TRUE
   ###################################
   # Check if this is a response to an existing ticket - should add activity

   if ($match == TRUE && ($create_ticket == TRUE || $create_activity == TRUE)){

      # Create a ticket - get ticket ID
      $config_object_type = 'ConfigurationItems';
      $config_action = "select";
      $config_params[0] = " sclm_configurationitemtypes_id_c='6cc00767-12da-3666-9081-52826ae1cea5' && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
      $config_params[1] = "id,sclm_configurationitems_id_c,name"; // select array
      $config_params[2] = ""; // group;
      $config_params[3] = " name, date_entered DESC "; // order;
      $config_params[4] = ""; // limit
  
      $config_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $config_object_type, $config_action, $config_params);

      if (is_array($config_items)){

         for ($configcnt=0;$configcnt < count($config_items);$configcnt++){
            
             # $id = $config_items[$configcnt]['id'];
             $ticket_id = $config_items[$configcnt]['name'];

             if ($create_report == TRUE){
                $report .= $debugger." New TicketActivity ID: ".$ticket_id."<BR>";
                }

             } // end for

         } else {// end if
         $ticket_id = "SDaaS+AMS-";
         } 

      if ($create_report == TRUE){
         $report .= $debugger." Create Ticket/Activity<BR>";
         }

      if ($sclm_serviceslarequests_id_c){

         $svcslar_object_type = 'ServiceSLARequests';
         $svcslar_action = "select";
         $svcslar_params[0] = " id ='".$sclm_serviceslarequests_id_c."' ";
         $svcslar_params[1] = ""; // select array
         $svcslar_params[2] = ""; // group;
         $svcslar_params[3] = ""; // order;
         $svcslar_params[4] = ""; // limit

         $svcslar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $svcslar_object_type, $svcslar_action, $svcslar_params);

         if (is_array($svcslar_items)){

            for ($svcslarcnt=0;$svcslarcnt < count($svcslar_items);$svcslarcnt++){

                $sclm_services_id_c = $svcslar_items[$svcslarcnt]['sclm_services_id_c'];
                $account_id_c = $svcslar_items[$svcslarcnt]['account_id_c'];
                $contact_id_c = $svcslar_items[$svcslarcnt]['contact_id_c'];
                $cmn_statuses_id_c = $svcslar_items[$svcslarcnt]['cmn_statuses_id_c'];
                $sclm_servicessla_id_c = $svcslar_items[$svcslarcnt]['sclm_servicessla_id_c'];
                $sclm_accountsservices_id_c = $svcslar_items[$svcslarcnt]['sclm_accountsservices_id_c'];
                $sclm_accountsservicesslas_id_c = $svcslar_items[$svcslarcnt]['sclm_accountsservicesslas_id_c'];
                $project_id_c = $svcslar_items[$svcslarcnt]['project_id_c'];
                $projecttask_id_c = $svcslar_items[$svcslarcnt]['projecttask_id_c'];
                $sclm_sowitems_id_c = $svcslar_items[$svcslarcnt]['sclm_sowitems_id_c'];
                $sclm_sla_id_c = $svcslar_items[$svcslarcnt]['sclm_sla_id_c'];

                } // for svcslar_items

            } // is array svcslar_items

         } // if sla

      $email_content = $this->replacer("</ br>", "", $email_content);
      $email_content = $this->replacer("</br>", "", $email_content);
      #$email_content = $this->replacer("<br>", "", $email_content);
      #$email_content = $this->replacer("<br>", '\n', $email_content);
      $email_content = $this->replacer("<br />",'',$email_content);
      $email_content = $this->replacer("<BR>", '', $email_content);
      $email_title = $this->replacer("</ br>", "", $email_title);
      $email_title = $this->replacer("</br>", "", $email_title);
      $email_title = $this->replacer("<br />", "", $email_title);
      $email_title = $this->replacer("<br>", "", $email_title);

      #if ($create_activity == TRUE && $create_activity_email_ticket_id != NULL){
      if ($create_activity == TRUE){
         # Create Activity
         #$ticket_date = date("Y-m-d-H-i-s");
         #$ticket_id = $ticket_id.$ticket_date;

         $email_title = $subject;

         #$email_title = $this->replacer("[TICKET]", $create_activity_email_ticket_id, $email_title);
         $email_content = $this->replacer("[TICKET]", $create_activity_email_ticket_id, $email_content);
         if (!$email_content){
            $email_content = $email_title;
            }

         $act_process_object_type = "TicketingActivities";
         $act_process_action = "update";

         $act_process_params = array();  
         $act_process_params[] = array('name'=>'name','value' => $email_title);
         $act_process_params[] = array('name'=>'assigned_user_id','value' => 1);
         $act_process_params[] = array('name'=>'description','value' => $email_content);
         $act_process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $sclm_serviceslarequests_id_c);
         $act_process_params[] = array('name'=>'date_entered','value' => $date);
         $act_process_params[] = array('name'=>'date_modified','value' => $date);
         $act_process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
         $act_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
         $act_process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $create_activity_ticket_id);
         #$tick_process_params[] = array('name'=>'service_operation_process','value' => $_POST['service_operation_process']);
         $act_process_params[] = array('name'=>'accumulated_minutes','value' => 0);
         #$act_process_params[] = array('name'=>'status','value' => $create_activity_email_ticket_status);
         $act_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
         $act_process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
         $act_process_params[] = array('name'=>'filter_id','value' => $filter_id);

         #$act_process_params[] = array('name'=>'to_addressees','value' => );
         #$act_process_params[] = array('name'=>'cc_addressees','value' => );
         #$act_process_params[] = array('name'=>'bcc_addressees','value' => $_POST['bcc_addressees']);
         $act_process_params[] = array('name'=>'extra_addressees','value' => $from_mailname.",".$received_to);
         $act_process_params[] = array('name'=>'extra_cc_addressees','value' => $received_cc);
         #$act_process_params[] = array('name'=>'extra_bcc_addressees','value' => $_POST['extra_bcc_addressees']);

         if ($create_report == TRUE){
            $report .= $debugger." About to create Ticket Activity<BR>";
            }

         if ($debug == TRUE){
            #
            } else {
            $act_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $act_process_object_type, $act_process_action, $act_process_params);                                                    

            }
      
         if ($act_result['id'] != NULL){
            $sclm_ticketingactivities_id_c = $act_result['id'];

            $message_link = "Body@".$lingo."@TicketingActivities@view@".$sclm_ticketingactivities_id_c."@TicketingActivities";
            $message_link = $this->encrypt($message_link);
            $message_link = "http://".$hostname."/?pc=".$message_link;

            }

         } else {

         ###########################
         # Create Ticket

         $ticket_date = date("Y-m-d_H-i-s",strtotime($date));
         $ticket_id = $ticket_date;

         $email_title = $this->replacer("[TICKET]", $ticket_id, $email_title);
         $email_content = $this->replacer("[TICKET]", $ticket_id, $email_content);
         $tick_process_object_type = "Ticketing";
         $tick_process_action = "update";

         $tick_process_params = array();  
         $tick_process_params[] = array('name'=>'name','value' => $email_title);
         $tick_process_params[] = array('name'=>'assigned_user_id','value' => 1);
         $tick_process_params[] = array('name'=>'description','value' => $email_content);
         #$tick_process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
         $tick_process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $sclm_serviceslarequests_id_c);
         $tick_process_params[] = array('name'=>'date_entered','value' => $date);
         $tick_process_params[] = array('name'=>'date_modified','value' => $date);

         $tick_process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
         $tick_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
         #$tick_process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
         #$tick_process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
         #$tick_process_params[] = array('name'=>'service_operation_process','value' => $_POST['service_operation_process']);
         $tick_process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
         $tick_process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
         $tick_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
         $tick_process_params[] = array('name'=>'ticket_id','value' => $ticket_id);
         $tick_process_params[] = array('name'=>'ticket_source','value' => '544567e9-f0e5-85a0-8d85-52b0e7704312');
         $tick_process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $filter_server_id);
         $tick_process_params[] = array('name'=>'accumulated_minutes','value' => 0);
         $tick_process_params[] = array('name'=>'status','value' => $status);
         $tick_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
         $tick_process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
         $tick_process_params[] = array('name'=>'filter_id','value' => $filter_id);
         $tick_process_params[] = array('name'=>'extra_addressees','value' => $from_mailname.",".$received_to);
         $tick_process_params[] = array('name'=>'extra_cc_addressees','value' => $received_cc);

         if ($create_report == TRUE){
            $report .= $debugger." About to create Ticket<BR>";
            }

         if ($debug == TRUE){

            } else {
            # Try to stop duplications
            if ($previous_ticket != $ticket_id){

               $tick_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $tick_process_object_type, $tick_process_action, $tick_process_params);

               } // if previous_ticket

            } // if debug
      
         if ($tick_result['id'] != NULL){
            $sclm_ticketing_id_c = $tick_result['id'];

            $message_link = "Body@".$lingo."@Ticketing@view@".$sclm_ticketing_id_c."@Ticketing";
            $message_link = $this->encrypt($message_link);
            $message_link = "http://".$hostname."/?pc=".$message_link;

            }

         } // ticket or activity

      } // end if ($match == TRUE && $create_ticket == TRUE)

   # End ticket or activity
   ###############################
   # Move email to ticketed folder

   $debug_filter_folder = "";
   $debug_ticket_folder = "";

   if ($debug == TRUE && $create_ticket == TRUE && $create_activity == FALSE && ($match == TRUE || $do_catchall)){

      $debug_filter_folder = "Development/Test-In";
      $debug_ticket_folder = "Development/Test-Auto-Ticket";

      if ($do_catchall == TRUE){
         $debug_ticket_folder = "Development/Test-Auto-Michi";
         }

      } elseif ($debug == TRUE && $create_activity == TRUE && $match == TRUE){

      $debug_filter_folder = "Development/Test-In";
      $debug_ticket_folder = "Development/Test-Auto-Activity";

      } elseif ($debug == TRUE && $create_ticket == FALSE && $create_activity == FALSE && $match == TRUE && ($trigger_rate >= $triggercount)){

      $debug_filter_folder = "Development/Test-In";
      $debug_ticket_folder = "Development/Test-Auto-Mushi";

      } else {

      $catchall = TRUE;

      #$debug_filter_folder = "Development/Test-In";
      #$debug_ticket_folder = "Development/Test-Auto-Michi";

      }

   if ($debug_filter_folder != NULL && $debug_ticket_folder != NULL){

      $portal_imap_port = "993";
      $portal_imap_server = "imap.gmail.com";

      $moveparams[0] = $portal_imap_port;
      $moveparams[2] = $portal_imap_server;
      $moveparams[3] = $debug_filter_folder;
      $moveparams[4] = $debug_ticket_folder;
      $moveparams[5] = $email_id;
      $moveparams[6] = $portal_email;
      $moveparams[7] = $portal_email_password;
      $moveparams[8] = $report;
      $moveparams[9] = $create_report;

      $report = $this->move_emails($moveparams);

      } // $debug_filter_folder != NULL && $debug_ticket_folder != NULL)

   # End debug filer
   ###############################
   # Move auto email to ticketed folder

   if ($debug != TRUE){
      $real_filter_folder = "";
      $real_ticket_folder = "";
      $catchall = FALSE;
      }

   if ($debug != TRUE && $create_ticket == TRUE && $create_activity == FALSE && ($match == TRUE || $do_catchall)) {// if debug for moving emails

      $real_filter_folder = "Admin/0 - Auto-Filtered";
      $real_ticket_folder = "Admin/0 - Auto-Tickets";

      if ($do_catchall == TRUE){
         $real_ticket_folder = "Admin/0 - Auto-Michi";
         }

      } elseif ($debug != TRUE && $create_activity == TRUE && $match == TRUE) {// if debug for moving emails

      $real_filter_folder = "Admin/0 - Auto-Filtered";
      $real_ticket_folder = "Admin/0 - Auto-Activities";

      } elseif ($debug != TRUE && $create_ticket == FALSE && $create_activity == FALSE && $match == TRUE && $trigger_rate >= $triggercount){

       $real_filter_folder = "Admin/0 - Auto-Filtered";
       $real_ticket_folder = "Admin/0 - Auto-Mushi";

      } else {

       $catchall = TRUE;

       #$real_filter_folder = "Admin/0 - Auto-Filtered";
       #$real_ticket_folder = "Admin/0 - Auto-Michi";

      }

   if ($real_filter_folder != NULL && $real_ticket_folder != NULL){

      ###############################
      # Move email to ticketed folder

      $portal_imap_port = "993";
      $portal_imap_server = "imap.gmail.com";

      $moveparams[0] = $portal_imap_port;
      $moveparams[2] = $portal_imap_server;
      $moveparams[3] = $real_filter_folder;
      $moveparams[4] = $real_ticket_folder;
      $moveparams[5] = $email_id;
      $moveparams[6] = $portal_email;
      $moveparams[7] = $portal_email_password;
      $moveparams[8] = $report;
      $moveparams[9] = $create_report;

      $report = $this->move_emails($moveparams);

      if ($real_ticket_folder == "Admin/0 - Auto-Mushi"){
         break;
         }

      } // end if debug and move

   # End move email
   ###############################
   # Prepare Emails
   # If this is a response to an existing ticket - should add activity

   if ($match == TRUE && $create_email == TRUE){

      $type = 1;

      $from_name = $portal_title;
      $from_email = $portal_email;
      $from_email_password = $portal_email_password;

      # To send based on sla lists before filter lists

      if ($sclm_serviceslarequests_id_c){

         if ($create_report == TRUE){
            $report .= $debugger." Have Service SLA Request - to get notifiees. ID: ".$sclm_serviceslarequests_id_c."<BR>";
            }

         $cnotifications_object_type = "ContactsNotifications";
         $cnotifications_action = "select";
         $cnotifications_params[0] = " sclm_serviceslarequests_id_c='".$sclm_serviceslarequests_id_c."' && cmn_statuses_id_c='".$standard_statuses_open_public."' ";
         $cnotifications_params[1] = ""; // select array
         $cnotifications_params[2] = ""; // group;
         $cnotifications_params[3] = ""; // order;
         $cnotifications_params[4] = ""; // limit
  
         $cnotifications = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cnotifications_object_type, $cnotifications_action, $cnotifications_params);

         if (is_array($cnotifications)){

            for ($cnt=0;$cnt < count($cnotifications);$cnt++){

                $contact_id_c = $cnotifications[$cnt]['contact_id_c'];

                $contact_object_type = "Contacts";
                $contact_action = "select_soap";
                $contact_params = array();
                $contact_params[0] = "contacts.id='".$contact_id_c."'"; // query
                $contact_params[1] = array("first_name","last_name","email1");
                #$contact_params[1] = array("email1");

                $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
                for ($cnt=0;$cnt < count($contact_info);$cnt++){

                    $first_name = $contact_info[$cnt]['first_name'];
                    $last_name = $contact_info[$cnt]['last_name'];
                    $to_email = $contact_info[$cnt]['email1'];
                    $to_name = $first_name." ".$last_name;
                    $internal_to_addressees[$to_email] = $to_name;

                    } // end for contact info

                } // end for cnotifications

            } // end is_array($cnotifications

         } else {// end if sclm_serviceslarequests_id_c to get 

         $report .= $debugger." Has NO Service SLA Request - will not send to any notifiees. <BR>";

         } // no sla - no notifications

      # Get lists found
      if ($recp_to_list != NULL){
         $recp_to_array = explode(',',$recp_to_list); //split string into array seperated by ','
         foreach ($recp_to_array as $recp_to_value){
                 $to_addressees[$recp_to_value] = $recp_to_value;
                 }
         } // end if recp_cc_list

      if ($recp_cc_list != NULL){
         $recp_cc_array = explode(',',$recp_cc_list); //split string into array seperated by ','
         foreach ($recp_cc_array as $recp_cc_value){
                 $cc_addressees[$recp_cc_value] = $recp_cc_value;
                 }
         } // end if recp_cc_list

      if ($recp_bcc_list != NULL){
         $recp_bcc_array = explode(',',$recp_bcc_list); //split string into array seperated by ','
         foreach ($recp_bcc_array as $recp_bcc_value){
                 $bcc_addressees[$recp_bcc_value] = $recp_bcc_value;
                 }
         } // end if recp_bcc_list

      # End Preparing recipients
      #########################################
      # Build Email

      $mailparams[0] = $from_name;
      #$mailparams[1] = $to_name;
      $mailparams[2] = $from_email;
      $mailparams[3] = $from_email_password;
      #$mailparams[4] = $to_email;
      $mailparams[5] = $type;
      $mailparams[6] = $lingo;
      $email_title = $this->replacer("<br>", '', $email_title);
      $mailparams[7] = $email_title;
      # may have to remove <BR> with \n
      $email_content = $this->replacer("<br>", '', $email_content);
      $email_content = $this->replacer("<BR>", '\n', $email_content);
      $email_content = $this->replacer("<BR>", '', $email_content);
      $email_content = $this->replacer("<br />", '\n', $email_content);
      $email_content = $this->replacer("&nbsp;",'',$email_content);

      # Catch-all report
      if ($addreport == TRUE){
         #$report = $final_message;
         }
      #$mailparams[8] = $email_content."\n".$strings["action_view_here"].":\n".$message_link."\n".$report;
      $mailparams[8] = $email_content."\n".$strings["action_view_here"].":\n".$message_link."\n";
      $mailparams[9] = $portal_email_server;
      $mailparams[10] = $portal_email_smtp_port;
      $mailparams[11] = $portal_email_smtp_auth;

      if ($create_report == TRUE){
$report .= $debugger." Send Email out to recipients Ticket<P>
Email sent with newly created Ticket<BR>
To: ".$to_name." Email: ".$to_email."<BR>
From: ".$from_name." Email: ".$from_email."<BR>
Type: ".$type."<BR>
Lingo: ".$lingo."<BR>
Portal Email Server: ".$portal_email_server."<BR>
Subject: ".$mailparams[7]."<BR>Body:".$email_content."<BR>";
         }

      if ($debug == TRUE){

         # Do nothing
 
         } else {

         if ($previous_title != $email_title){

            if ($sclm_serviceslarequests_id_c && is_array($internal_to_addressees)){

               $mailparams[12] = "";
               $mailparams[12] = $internal_to_addressees; // array
               $emailresult = $this->do_email ($mailparams);
 
               }

            if (is_array($to_addressees)){

               $mailparams[12] = "";
               $mailparams[12] = $to_addressees; // array
               $mailparams[13] = $cc_addressees; // array
               $mailparams[14] = $bcc_addressees; // array

               $emailresult = $this->do_email ($mailparams);

               } // TO/CC/BCC

            } // if title not same

         } // end if not debugging

      } // ($match == TRUE && $create_email == TRUE){

   # End Preparing recipients
   #########################################
   # Check create_activity

   if ($create_report == TRUE){
      $report .= $debugger." Check create_activity ($create_activity == TRUE) && create_activity_ticket_id ($create_activity_ticket_id != NULL)<BR>";
      }

   if ($create_activity == TRUE && $create_activity_ticket_id != NULL){
      # Check to see if an email exists with the parent ticket
      $sclm_ticketing_id_c = $create_activity_ticket_id;

      $check_email_object_type = 'Emails';
      $check_email_action = "select";
      $check_email_params[0] = " sclm_ticketing_id_c='".$create_activity_ticket_id."' ";
      $check_email_params[1] = "id,name,sclm_ticketing_id_c"; // select array
      $check_email_params[2] = ""; // group;
      $check_email_params[3] = ""; // order;
      $check_email_params[4] = ""; // limit
  
      $check_email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_email_object_type, $check_email_action, $check_email_params);

      if (is_array($check_email)){
   
         for ($chkmlcnt=0;$chkmlcnt < count($check_email);$chkmlcnt++){

             $sclm_emails_id_c = $check_email[$chkmlcnt]['id'];
             $sclm_emails_name = $check_email[$chkmlcnt]['name'];

             if ($create_report == TRUE){
                $report .= $debugger." Found Parent Email [".$sclm_emails_name."]<BR>";  
                }

             } // end for

         } // end is array

      } // end if activity

   # End Preparing recipients
   #########################################
   #Create/Activity

   if ($match == TRUE && ($create_ticket == TRUE || $create_activity == TRUE)){
      # Store Email Locally

      if ($create_report == TRUE){
         $report .= $debugger." Store Email Content Locally<BR>"; 
         }

      $process_object_type = "Emails";
      $process_action = "update";
      $process_params[] = array('name'=>'name','value' => $subject);
      $process_params[] = array('name'=>'date_entered','value' => $date);
      $process_params[] = array('name'=>'assigned_user_id','value' => 1);
      $process_params[] = array('name'=>'description','value' => $body);
      $process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
      $process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
      $process_params[] = array('name'=>'message_id','value' => $message_id);
      $process_params[] = array('name'=>'sender','value' => $from_mailname);
      $process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
      $process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
      $process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
      $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
      $process_params[] = array('name'=>'encode','value' => $encode);
      $process_params[] = array('name'=>'original_date','value' => $udate);
      $process_params[] = array('name'=>'receiver','value' => $portal_email);
      $process_params[] = array('name'=>'message_number','value' => $message_number);
      $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $sclm_serviceslarequests_id_c);
      $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $sclm_ticketing_id_c);
      $process_params[] = array('name'=>'sclm_ticketingactivities_id_c','value' => $sclm_ticketingactivities_id_c);
      $process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);
      $process_params[] = array('name'=>'filter','value' => $filter_id);
      $process_params[] = array('name'=>'filter_id','value' => $filter_id);

      if ($create_report == TRUE){
         $report .= $debugger." Skipped storing email<BR>"; 
         }

      if ($debug == TRUE){

         } else {

         if ($previous_subject != $subject){

            $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
            if ($result['id'] != NULL){

               $sclm_emails_id_c = $result['id'];

               if ($create_activity == TRUE){

                  $act_process_object_type = "TicketingActivities";
                  $act_process_action = "update";
                  $act_process_params = array(); 
                  $act_process_params[] = array('name'=>'id','value' => $sclm_ticketingactivities_id_c); 
                  $act_process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);

                  $act_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $act_process_object_type, $act_process_action, $act_process_params);       

                  } elseif ($create_ticket == TRUE) {
                  $tick_process_object_type = "Ticketing";
                  $tick_process_action = "update";
                  $tick_process_params = array(); 
                  $tick_process_params[] = array('name'=>'id','value' => $sclm_ticketing_id_c); 
                  $tick_process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);

                  $tick_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $tick_process_object_type, $tick_process_action, $tick_process_params);
                  }

               }

            } // end if no duplicate

         } // end if no debug

      } // end if $create_mail == TRUE)

   # End Create Ticket if Match and TRUE
   # End Actions to take before closing loop for each filter
   #########################################
   # Whatever rule combinations are producing catch-alls incorrectly should be here to avoide erronious catch-alls

   if ($catchall == TRUE){
      $report .= $debugger." DO perform catch-all - filters missed or ignored this and must be checked..<BR>";
      } else {
      $catchall = FALSE; // will result in false, but not a stray email to send in
      }

   $previous_ticket = $ticket_id;
   $previous_title = $email_title;
   $previous_subject = $subject;

   $filterbit_returner[0] = $report;
   $filterbit_returner[1] = $match;
   $filterbit_returner[2] = $create_mail;
   $filterbit_returner[3] = $create_ticket;
   $filterbit_returner[4] = $create_activity;
   $filterbit_returner[5] = $catchall;
   $filterbit_returner[6] = $previous_ticket;
   $filterbit_returner[7] = $previous_title;
   $filterbit_returner[8] = $previous_subject;
   $filterbit_returner[9] = $trigger_rate;
   $filterbit_returner[10] = $triggercount;

  return $filterbit_returner;

 } // end do_filterbits function

# End Do Filterbits
####################################################################################
# Do Filters (Filterstart)

 function do_filters ($params){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  if (!function_exists('get_param')){
     include ("common.php");
     }

  global $portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c;

  if (!$account_id_c){
     $account_id_c = $portal_account_id;
     }

  $source = $params[0]; // Email, other
  $emailparams = $params[1]; // Email, other

  switch ($source){

   case 'Auto':

    $debug = $emailparams[7];

   break;
   case 'Emails':

    $debug = $emailparams[7];

   break;

  }

  #$debug_makefile = TRUE;
  $debug_makefile = FALSE;
  $do_logger = FALSE;
  #$do_logger = TRUE;

  $content_location = "/var/www/vhosts/scalastica.com/httpdocs/content/".$portal_account_id;
  $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
  $log_name = "Scalastica";
  $log_link = "content/".$portal_account_id."/".$log_name.".log";

  $bodyfiledate = date('Y-m-d-H-i-s');
  $bodyfile_location = "/var/www/vhosts/scalastica.com/httpdocs/content/".$bodyfiledate."-body.txt";

  $valtype = $emailparams[8];

  $debugger = "<img src=http://".$hostname."/images/icons/bug.png width=16> <B>Debug:</B>";

  $imapemails = $this->get_email ($emailparams);

  #var_dump($imapemails);

  #if (is_array($imapemails)){
  if ($imapemails != FALSE){

     #echo "Still here!!";

     ############################
     # Do Logger
     if ($do_logger == TRUE){
        #$log_content = "From Auto Params - 0 $emailparams[0] 1 $emailparams[1] 2 $emailparams[2] 3 $emailparams[3] 4 $emailparams[4] 5 $emailparams[5] 6 $emailparams[6] 7 $emailparams[7] 8 $emailparams[7] Array: ".$imapemails." [".$bodyfiledate."]";
        $logparams[0] = $log_location;
        $logparams[1] = $log_name;
        $logparams[2] = $log_content;
        #$this->funky_logger ($logparams);
        }
     # End Logger 
     ############################

     #var_dump($imapemails);

     $mailcount = count($imapemails);

     if ($emailparams[6]){
        echo "<P><B>Keyword: <font color=red>".$val." [CNT:".count($imapemails)."]</font></B><P>";
        }

     # Check all servers in system
     $maintsrv_object_type = "ConfigurationItems";
     $maintsrv_action = "select";
     $maintsrv_types = "(sclm_configurationitemtypes_id_c='7835c8b9-f7d5-5d0a-be10-52ad9c866856' || sclm_configurationitemtypes_id_c='34647ae4-154c-68f3-74ea-52b0c8abc3dc' || sclm_configurationitemtypes_id_c='7ef914c8-09f8-82c9-d4b9-52c29793ef85' || sclm_configurationitemtypes_id_c='3f6d75b7-c0f5-1739-c66d-52c2989ce02d' || sclm_configurationitemtypes_id_c='cd287492-19ce-99b3-6ead-52e0c97a6e83' || sclm_configurationitemtypes_id_c='49ff2505-7d08-cb5c-64e8-52e0e490c0dc')";
     $maintsrv_params[0] = " deleted=0 && account_id_c='".$account_id_c."' && $maintsrv_types ";

     $maintsrv_params[1] = "id,name,description"; // select array
     $maintsrv_params[2] = ""; // group;
     $maintsrv_params[3] = ""; // order;
     $maintsrv_params[4] = ""; // limit
  
     $maintservers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $maintsrv_object_type, $maintsrv_action, $maintsrv_params);

     if (is_array($maintservers)){
        $check_maint_servers = $maintservers;
        }

     #########################################
     # Begin looping through each email available

     for ($mailcnt=0;$mailcnt < count($imapemails);$mailcnt++){

         $number = $imapemails[$mailcnt]['number'];
         $msgno = $imapemails[$mailcnt]['Msgno'];
         $email_id = $imapemails[$mailcnt]['id'];
         $to = $imapemails[$mailcnt]['to'];
         $cc = $imapemails[$mailcnt]['cc'];
         $email_id = $this->replacer("<", "", $email_id);
         $email_id = $this->replacer(">", "", $email_id);
         $encode = $imapemails[$mailcnt]['encode'];
         $read = $imapemails[$mailcnt]['read'];
         $subject = $imapemails[$mailcnt]['subject'];
         $charset = $imapemails[$mailcnt]['charset'];
         # Picks this up in the japanese word for event: イベント
         #$subject = $this->replacer("べ","べ", $subject);
         #$subject = $this->replacer("ブ","ブ", $subject);
         #$subject = $this->replacer("ショ゙","ジョ", $subject);
         $subject = $this->replacer("゙","", $subject);

         $from = $imapemails[$mailcnt]['from'];
         $fromaddress = $imapemails[$mailcnt]['fromaddress'];
         $date = $imapemails[$mailcnt]['date'];
         $udate = $imapemails[$mailcnt]['udate'];
         $body = $imapemails[$mailcnt]['body'];
         $attachments = $imapemails[$mailcnt]['attachments'];

         if (!$subject){

            ############################
            # Do Logger
            if ($do_logger == TRUE){
               $log_content = "No subject at [".$bodyfiledate."] - break early!";
               $logparams[0] = $log_location;
               $logparams[1] = $log_name;
               $logparams[2] = $log_content;
               $this->funky_logger ($logparams);
               }
            # End Logger 
            ############################

            break;

            }

         ############################
         # Do Logger
         if ($do_logger == TRUE){
            $log_content = "For Mail Loop [Cnt: ".$mailcount."] - Start for Subject [".$bodyfiledate."]: ".$subject;
            $logparams[0] = $log_location;
            $logparams[1] = $log_name;
            $logparams[2] = $log_content;
            $this->funky_logger ($logparams);
            }
         # End Logger 
         ############################

         if (is_array($from)){

            foreach ($from as $fromid => $object) {
                    $from_name = $object->personal;
                    $from_mailname = $object->mailbox . "@" . $object->host;
                    }

            } else {// end if array from

            $from_name = "No Name";
            $from_mailname = "NoName@NoDomain";

            } 

         $topack = "";
         $tolist = "";
         $usabletopack = "";
         $ccpack = "";
         $cclist = "";
         $usableccpack = "";

         if (is_array($to)){

            $tocount = count($to);

            foreach ($to as $id => $object) {

                    $to_name = $object->personal;
                    $to_mailname = $object->mailbox."@".$object->host;

                    if ($to_mailname != $portal_email){
                       # Don't include own portal email address from to list - we KNOW it is to us because we are here!! :)))
                       # Also will go into a perpetual loop..

                       if ($tocount == 1){
                          $toender = "";
                          } else {
                          $toender = ",";
                          } 

                       $topack .= $to_name." [".$to_mailname."]".$toender;
                       $tolist .= $to_mailname.$toender;
                       $usabletopack[]['name'] = $to_name;
                       $usabletopack[]['mailname'] = $to_mailname;

                       $tocount = $tocount-1;

                       } // end else mailname = portal mail

                    } // for each

            } else {// if to array
            #echo "Not array - TO: ".$to."<BR>";
            }

         if (is_array($cc)){

            $cccount = count($cc);

            foreach ($cc as $id => $object) {

                    $cc_name = $object->personal;
                    $cc_mailname = $object->mailbox."@".$object->host;

                    if ($cccount == 1){
                       $ccender = "";
                       } else {
                       $ccender = ",";
                       } 

                    $ccpack .= $cc_name." [".$cc_mailname."]".$ccender;
                    $cclist .= $cc_mailname.$ccender;
                    $usableccpack[]['name'] = $cc_name;
                    $usableccpack[]['mailname'] = $cc_mailname;

                    $cccount = $cccount-1;

                    }

            } // if cc array

         $files = "";
         if (is_array($attachments)){

            foreach ($attachments as $attaid => $object) {

                    $filename = $object['filename'];
                    $file = $object['filedata'];
                    $content_type = $object['content_type'];

                    if ($from_mailname=='ISC-OA-Backup@agc.com'){
                       $file = mb_convert_encoding($file, 'UTF-8', 'Shift_JIS');
                       }

                    $file_location = $content_location."/".$filename;

                    if (!file_exists($file_location)){
                       $fp = fopen($file_location, 'w');
                       $file_link = "content/".$portal_account_id."/".$filename;
                       fputs($fp, $file);
                       fclose($fp);
                       } else {
                       $filedate = date('Y-m-d_H-i-s',$udate);
                       #$filedate = date('Y-m-d-H-i-s');
                       $file_location = $content_location."/".$filedate."-".$filename;
                       $file_link = "content/".$portal_account_id."/".$filedate."-".$filename;
                       $fp = fopen($file_location, 'w');
                       fputs($fp, $file);
                       fclose($fp);
                       }

                    $files .= "<a href=".$file_link." target=File>".$filename."</a><BR>";
                    $filespack[$filename] = "<a href=".$file_link." target=File>".$filename."</a><BR>";

                    } // end foreach attachments

            } // if attachments array

         if ($debug_makefile == TRUE){
            $fp = fopen($bodyfile_location, 'w');
            fputs($fp, $body);
            fclose($fp);
            }

/*
         $check_params[0] = $from;
         $check_params[1] = $subject;
         $check_params[2] = $body;
         $check_params[3] = $tolist;

         $convert_body = $this->convertbody ($check_params);
         if ($convert_body == 'remove_mb'){
            } else {
            $body = $convert_body;
            mb_language('Japanese');
            mb_internal_encoding('UTF-8');
            }
*/
         $date = date('Y-m-d H:i:s',$udate);

         if ($read == 0){
            $read = $strings["MessageUnread"];
            } else {
            $read = $strings["MessageRead"];
            }

         if ($body != NULL){

            $original_body = $body;

            if ($body != strip_tags($body)) {
               # contains HTML
               #echo "Is HTML<BR>";
               #$body = htmlspecialchars(strip_tags($body), ENT_QUOTES, 'utf-8');
               $body = $this->replacer("<br>", "SCALASTICA", $body);
               #$body = $this->replacer("\n", "<br>", $body);
               $body = strip_tags($body);
               #$body = $this->replacer("\n", "<br>", $body);
               $body = $this->replacer("SCALASTICA", "\n", $body);
               #$body = $this->replacer("SCALASTICA", "<br>", $body);
               $body = $this->replacer("&amp;nbsp;", "", $body);
               #$body = $this->replacer("&amp;", "", $body);
               #$body = $this->replacer("nbsp;", "", $body);
               } else {
               #$body = $this->replacer("\n", "<br>", $body);
               }
            }

         if ($debug == 1){
            $debug = TRUE;
            $create_report = TRUE;
            }

         # Prepare to send in link to create tickets
         $html_subject = urlencode ($subject);
         $html_body = urlencode ($body);
         $html_date = urlencode ($date);

         $imap_emails .= "<div style=\"".$divstyle_white."\">
<B>#:</B> ".$number."<BR>
<B>Msgno:</B> ".$msgno."<BR>
<B>Encode:</B> ".$encode."<BR>
<B>Charset:</B> ".$charset."<BR>
<B>ID:</B> ".$email_id."<BR>
<B>Date:</B> ".$date."<BR>
<B>TO:</B> ".$topack."<BR>
<B>From:</B> ".$from_name." [".$from_mailname."] <BR>
<B>CC:</B> ".$ccpack."<BR>
<B>Subject:</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=".$number."&valuetype=view_email');return false\"><font color=red><B>".$subject."</B></font></a><BR>
<B>Test:</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=".$number."&valuetype=test_filter_single_debug');return false\"><font color=red><B>Debug</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=".$number."&valuetype=test_filter_single_live');return false\"><font color=red><B>Live</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&value=".$number."&valuetype=IMAPEmails&fromemail_subject=".$htmlsubject."&fromemail_body=".$htmlbody."&fromemail_date=".$html_date."');return false\"><font size=2 color=red><B>->".$strings["EmailConvertToTicket"]."</B></font></a><BR>";

         $convert = "";

         if ($files){
            $imap_emails .= "<div style=\"".$divstyle_blue."\"><B>Attachments:</B><BR>".$files."</div>";
            }

         if ($debug == TRUE){
            $showbody = $this->replacer("\n", "<br>", $body);
            } else {
            $showbody = $body;
            }

         $imap_emails .= "<B>Body:</B><P>".$showbody."</div>";

         if ($debug_makefile == TRUE){
            #$fp = fopen($bodyfile_location, 'w');
            #fputs($fp, $body);
            #fclose($fp);
            }

         ##########################################
         # If set to debug or go live

         if ($valtype == 'test_filter_all_live' || $valtype == 'test_filter_all_debug' || $valtype == 'test_filter_single_debug' || $valtype == 'test_filter_single_live'){

            if ($create_report == TRUE){
               $report  = "<div style=\"".$divstyle_orange."\"><center><B>Debug for Email: ".$subject."</B></center></div>";
               }

            ##########################################
            # Get list of keywords to scan body to determine auto downtime status

            $status_down_keywords_citype = '9c2d0f4b-1f1f-5de1-692e-52ceeab416c6';

            # Use Filter to collect components
            $prtlstatuskwds_object_type = "ConfigurationItems";
            $prtlstatuskwds_action = "select";
            $prtlstatuskwds_params[0] = " sclm_configurationitemtypes_id_c='".$status_down_keywords_citype."' && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ";
            $prtlstatuskwds_params[1] = "id,sclm_configurationitems_id_c,name,sclm_configurationitemtypes_id_c";
            $prtlstatuskwds_params[2] = ""; // group;
            $prtlstatuskwds_params[3] = ""; // order;
            $prtlstatuskwds_params[4] = ""; // limit

            $prtlstatuskwds = "";
            $prtlstatuskwds = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $prtlstatuskwds_object_type, $prtlstatuskwds_action, $prtlstatuskwds_params);

            if (is_array($prtlstatuskwds)){
                              
               for ($prtkwdcnt=0;$prtkwdcnt < count($prtlstatuskwds);$prtkwdcnt++){

                   # Got the portal 
                   $keyword_check = "";
                   $filter_keyword = "";
                   $filter_keyword = $prtlstatuskwds[$prtkwdcnt]['name'];                                   

                   if ($create_report == TRUE){
                      $report .= $debugger." Server Status Check with: <B>".$filter_keyword."</B><BR>";
                      }

                   if ($body != $this->replacer($filter_keyword, "", $body)){

                      # keyword exists in body - check for servers
                      if (is_array($server_pack)){

                         $server_check = "";

                         foreach ($server_pack as $server_id=>$server_name){
 
                                 if ($body == $this->replacer($server_name,"", $body)){
                                    # keyword doesnt exist in body - do nothing
                                    } else {//  end if 
                                    # keyword exists in body - check for servers
                                    $srvupdateparams[0] = $server_id;
                                    $srvupdateparams[1] = 0;
                                    $srvupdateparams[2] = 'live_status';
                                    $updated = "";
                                    $updated = $this->update_items($srvupdateparams);
   
                                    if ($create_report == TRUE){
                                       $report .= $debugger." Server Status Updated: <B>OFF: ".$updated."</B><BR>";
                                       }

                                    } // Server updated!

                                 } // foreach ($server_pack)

                         } // is_array($server_pack)

                      } // if keyword matches

                   } // for

               } // is array $prtlstatuskwds

            # End list of keywords to scan body to determine auto downtime status
            ##########################################
            # Get list of keywords to scan body to determine auto uptime status

            $status_up_keywords_citype = '8e83ef85-41e5-5f35-e239-52ceea6db03f';

            # Use Filter to collect components
            $prtlstatuskwds_object_type = "ConfigurationItems";
            $prtlstatuskwds_action = "select";
            $prtlstatuskwds_params[0] = " sclm_configurationitemtypes_id_c='".$status_up_keywords_citype."' && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ";
            $prtlstatuskwds_params[1] = "id,sclm_configurationitems_id_c,name,sclm_configurationitemtypes_id_c";
            $prtlstatuskwds_params[2] = ""; // group;
            $prtlstatuskwds_params[3] = ""; // order;
            $prtlstatuskwds_params[4] = ""; // limit

            $prtlstatuskwds = "";
            $prtlstatuskwds = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $prtlstatuskwds_object_type, $prtlstatuskwds_action, $prtlstatuskwds_params);

            if (is_array($prtlstatuskwds)){
                               
               for ($prtkwdcnt=0;$prtkwdcnt < count($prtlstatuskwds);$prtkwdcnt++){

                   # Got the portal 
                   $keyword_check = "";
                   $filter_keyword = "";
                   $filter_keyword = $prtlstatuskwds[$prtkwdcnt]['name'];                                   

                   if ($create_report == TRUE){
                      $report .= $debugger." Server Status Check with: <B>".$filter_keyword."</B><BR>";
                      }
      
                   if ($body != $this->replacer($filter_keyword, "", $body)){
                      # keyword exists in body - check for servers

                      if (is_array($server_pack)){

                         $server_check = "";

                         foreach ($server_pack as $server_id=>$server_name){
 
                                 if ($body == $this->replacer($server_name,"", $body)){
                                    # keyword doesnt exist in body - do nothing
                                    } else {//  end if 
                                    # keyword exists in body - check for servers
                                    $srvupdateparams[0] = $server_id;
                                    $srvupdateparams[1] = 1;
                                    $srvupdateparams[2] = 'live_status';
                                    $updated = "";
                                    $updated = $this->update_items($srvupdateparams);

                                    if ($create_report == TRUE){
                                       $report .= $debugger." Server Status Updated: <B>ON: ".$updated."</B><BR>";
                                       }

                                    } // Server updated!
   
                                 } // foreach ($server_pack)

                         } // is_array($server_pack)
   
                      } // if keyword matches

                   } // for

               } // is array $prtlstatuskwds

            # End list of keywords to scan body to determine auto uptime status
            ##########################################
            # Specific for AGC - should be included in some rules

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $message_source = "";
            $startcheck = $this->replacer("ソース:", "", $body);
            $endcheck = $this->replacer("パス:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "ソース:") + strlen("ソース:");
               $endsAt = strpos($body, "パス: ", $startsAt);
               $message_source = substr($body, $startsAt, $endsAt - $startsAt);
               $message_source = $this->replacer("\n", "", $message_source);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $message_pass = "";
            $startcheck = $this->replacer("パス:", "", $body);
            $endcheck = $this->replacer("イベント日時:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "パス:") + strlen("パス:");
               $endsAt = strpos($body, "イベント日時:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $this->replacer("\n", "", $server_replace);
               $server_replace = $this->replacer(" ", "", $server_replace);
               $message_pass = $server_replace;
               $server_replace = $this->replacer(".agc.jp", "", $server_replace);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $this->replacer("Server :", "", $body);
            $endcheck = $this->replacer("ErrorCode :", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "Server :") + strlen("Server :");
               $endsAt = strpos($body, "ErrorCode :", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $this->replacer("\n", "", $server_replace);
               $server_replace = $this->replacer(".agc.jp", "", $server_replace);
               $server_replace = $this->replacer(" ", "", $server_replace);
               } 
          
            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $this->replacer("エージェント:", "", $body);
            $endcheck = $this->replacer("時刻:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "エージェント:") + strlen("エージェント:");
               $endsAt = strpos($body, "時刻:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $this->replacer("\n", "", $server_replace);
               $server_replace = $this->replacer(".agc.jp", "", $server_replace);
               $server_replace = $this->replacer(" ", "", $server_replace);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $this->replacer("コンピューター:", "", $body);
            $endcheck = $this->replacer("イベントソース:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "コンピューター:") + strlen("コンピューター:");
               $endsAt = strpos($body, "イベントソース:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $this->replacer("\n", "", $server_replace);
               $server_replace = $this->replacer(".agc.jp", "", $server_replace);
               $server_replace = $this->replacer(" ", "", $server_replace);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $event_source = "";
            $startcheck = $this->replacer("イベントソース:", "", $body);
            $endcheck = $this->replacer("イベントディスプレイNo.:","", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "イベントソース:") + strlen("イベントソース:");
               $endsAt = strpos($body, "イベントディスプレイNo.:", $startsAt);
               $event_source = substr($body, $startsAt, $endsAt - $startsAt);
               $event_source = $this->replacer("\n", "", $event_source);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $event_category = "";
            $startcheck = $this->replacer("イベントカテゴリー:", "", $body);
            $endcheck = $this->replacer("コンピューター:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "イベントカテゴリー:") + strlen("イベントカテゴリー:");
               $endsAt = strpos($body, "コンピューター:", $startsAt);
               $event_category = substr($body, $startsAt, $endsAt - $startsAt);
               $event_category = $this->replacer("\n", "", $event_category);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $this->replacer("Event originator:", "", $body);
            $endcheck = $this->replacer("Event Severity:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "Event originator:") + strlen("Event originator:");
               $endsAt = strpos($body, "Event Severity:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $this->replacer("\n", "", $server_replace);
               $server_replace = $this->replacer(".agc.jp", "", $server_replace);
               $server_replace = $this->replacer(" ", "", $server_replace);
               }

            $server_replace = $this->replacer(".agc.jp","",$server_replace);
/*
            $this_server_check = substr($server_replace, 0, 13);
            $server_replace = $this->replacer(" ","",$server_replace);
            $server_replace = $this->replacer("\n","",$server_replace);
            $server_replace = $this->replacer("\n","",$server_replace);
            $server_replace = $this->replacer("<BR>","",$server_replace);
            $server_replace = $this->replacer("<br />","",$server_replace);
            $server_replace = $this->replacer("<BR>","",$server_replace);
            $server_replace = $this->replacer("</ br>","",$server_replace);
            $server_replace = $this->replacer("</br>","",$server_replace);
            $server_replace = $this->replacer("<br />","",$server_replace);
            $server_replace = $this->replacer("<br>","",$server_replace);
            $server_replace = preg_replace('/^\s+|\s+$/','', $server_replace);
            $server_replace = htmlspecialchars(strip_tags($server_replace), ENT_QUOTES, 'utf-8');
            $server_replace = htmlspecialchars($server_replace, ENT_QUOTES, 'utf-8');
            $server_replace = strip_tags($server_replace);
            $server_replace = htmlentities($server_replace, ENT_QUOTES | ENT_IGNORE, "UTF-8");
            $server_replace = $this->replacer(" ","",$server_replace);
   
*/

            # We need to search for it by hostname (caps) and add it to the pack
            $server_replace = rtrim($server_replace);
            $server_replace = ltrim($server_replace);

            $server_replace = $this->replacer("\n","",$server_replace);
            $server_replace = $this->replacer("\n","",$server_replace);
            $server_replace = mb_convert_encoding($server_replace, "HTML-ENTITIES", "UTF-8");
            $server_replace = strip_tags($server_replace);
            #$server_replace = htmlentities($server_replace,"ENT_QUOTES", "UTF-8");
            $server_replace = htmlspecialchars($server_replace, ENT_QUOTES, "UTF-8");
            $server_replace = $this->replacer("nbsp;", "", $server_replace);
            $server_replace = $this->replacer("&amp;", "", $server_replace);
            #$server_replace = $this->replacer("amp", "", $server_replace);
            #$server_replace = htmlentities($server_replace, ENT_QUOTES, UTF-8);
            #$server_replace = htmlentities($server_replace);
            #$server_replace = $this->replacer("&ACIRC;&NBSP;","",$server_replace);
            #$server_replace = $this->replacer("Â","",$server_replace);
            #$server_replace = $this->replacer("â","",$server_replace);

            $server_replace = rtrim($server_replace);
            $server_replace = ltrim($server_replace);

            $nameupper = strtoupper ($server_replace);
            $namelower = strtolower ($server_replace);

            if ($create_report == TRUE){
               $report .= $debugger." Server Found in Body/Subject: <B>".$server_replace."</B><BR>";
               }

            ###############################
            # Pre-pack for sending in for replies and normal filters

            $precheckparams[0] = $server_replace;
            $precheckparams[1] = $message_pass;
            $precheckparams[2] = $message_source;
            $precheckparams[3] = $event_source;
            $precheckparams[4] = $event_category;
            $precheckparams[5] = $nameupper;
            $precheckparams[6] = $namelower;
   
            # End Pre-pack
            ###############################
            # We have the server now - lets see if it is in the server array or maybe pick it up

            if ($server_replace != NULL){

               if ($create_report == TRUE){
                  $report .= $debugger." name like '%".$server_replace."%' || name like '%".$nameupper."%' || name like '%".$namelower."%' <BR>";
                  }

               # Try to get the Infra DB ID
               $server_object_type = "ConfigurationItems";
               $server_action = "select";
               # These same items need to be updated in the ConfigurationItems.php add action switch ($ci_type_id)
               $server_params[0] = " (name like '%".$server_replace."%' || name like '%".$nameupper."%' || name like '%".$namelower."%') && $maintsrv_types ";
               $server_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // array
               $server_params[2] = ""; // group;
               $server_params[3] = ""; // order;
               $server_params[4] = ""; // limit

               $find_server = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $server_object_type, $server_action, $server_params);
               if (is_array($find_server)){

                  for ($cntsrvr=0;$cntsrvr < count($find_server);$cntsrvr++){

                      $found_server_id = $find_server[$cntsrvr]['id'];
                      $found_server_name = $find_server[$cntsrvr]['name'];
                      # Add to the pack
                      $server_pack[$found_server_id] = $found_server_name;
       
                      if ($create_report == TRUE){
                         $report .= $debugger." Found server within Infra DB [".$found_server_name." - ".$found_server_id."]<BR>";
                         }
   
                      } // for servers found
       
                  } else {// is an array - for servers found
       
                  } // was not in the infra db

               $precheckparams[7] = $server_pack;

               } // if server found

            # End checking email for servers and other key tags
            ###############################
            # Check for vendor code

            $ticket_object_type = "Ticketing";
            $ticket_action = "select";
            $ticket_params[1] = " account_id_c='".$account_id_c."' && vendor_code != NULL && status != 'bbed903c-c79a-00a6-00fe-52802db36ba9' ";
            $ticket_params[1] = "name,ticket_id,status,filter_id,id,account_id_c,date_entered,vendor_code"; // select array
            $ticket_params[2] = ""; // group;
            $ticket_params[3] = " date_entered DESC "; // order;
            $ticket_params[4] = ""; // limit
            $ticket_params[5] = "name_en"; // lingo

            $vend_ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

            if (is_array($vend_ticket_items)){

               for ($vendcnt=0;$vendcnt < count($vend_ticket_items);$vendcnt++){

                   $vendor_code = $vend_ticket_items[$vendcnt]["vendor_code"];

                   if ($subject != $this->replacer($vendor_code,"", $subject)){

                      $tick_id = $vend_ticket_items[$vendcnt]['id'];
                      $ticket_id = $vend_ticket_items[$vendcnt]['ticket_id'];
                      $reply_filter_id = $vend_ticket_items[$vendcnt]['filter_id'];
                      $existticket_name = $vend_ticket_items[$vendcnt]['name'];
                      $ticket_status = $vend_ticket_items[$vendcnt]['status'];

                      $michimail = FALSE;
                      $match = TRUE;
                      $create_activity = TRUE;
                      $create_email = TRUE;
                      $create_activity_ticket_id = $tick_id;
                      $create_activity_email_ticket_id = $ticket_id;
                      $create_activity_email_ticket_status = $ticket_status;

                      break;

                      } // if code

                   } // for

               } // if array

            # Check for vendor code
            ###############################
            # Check for create activity - only to be nullified if the ticket states so
            # Get specific ticket ID

            if ($vendor_code != NULL){
               # Do nothing
               } else {

               $create_activity = FALSE;

               $exist_object_type = 'ConfigurationItems';
               $exist_action = "select";
               $exist_params[0] = " sclm_configurationitemtypes_id_c='6cc00767-12da-3666-9081-52826ae1cea5' && (account_id_c='".$account_id_c."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
               $exist_params[1] = "id,sclm_configurationitems_id_c,name"; // select array
               $exist_params[2] = ""; // group;
               $exist_params[3] = " name, date_entered DESC "; // order;
               $exist_params[4] = ""; // limit
  
               $exist_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $exist_object_type, $exist_action, $exist_params);

               if (is_array($exist_items)){

                  for ($exist_cnt=0;$exist_cnt < count($exist_items);$exist_cnt++){
            
                      # $id = $config_items[$configcnt]['id'];
                      $exist_ticket_id = $exist_items[$exist_cnt]['name'];

                      if ($create_report == TRUE){
                         $report  .= $debugger." Existing TicketActivity ID: ".$exist_ticket_id."<BR>";
                         }

                      } // end for

                  } else {// end if
                  $exist_ticket_id = "SDaaS+AMS-";
                  } 
      
               if ($create_report == TRUE){
                  $report  .= $debugger." Ticket ID to auto-create activities... [".$exist_ticket_id."]<BR>";
                  }

               } // if not vendor and chheck for ticket reply

            # End finding auto ID
            #########################
            # ID is already pre-filtered
            # Check if ID is in the subject - this has to be the key to continue for activities

            if ($subject != $this->replacer($exist_ticket_id, "", $subject)){

               $create_activity = TRUE;
               # Includes the ticket ID

               if ($create_report == TRUE){
                  $report  .= $debugger." Found Ticket ID in subject!!<BR>";
                  }

               # Look if subject in ticket name
               if ($create_activity != FALSE){
                  #########################
                  # Check based on a ticket - if a ticket exists with same subject
  
                  if ($create_report == TRUE){
                     $report  .= $debugger." No activity restrictions - check if subject is in ticket ID...<BR>";
                     }

                  $this_year = date("Y");
                  $this_month = date("m");
                  if ($this_month == 1){
                     $last_month = 12;
                     $year = $this_year-1;
                     } else {
                     $last_month = $this_month-1;
                     $year = $this_year;
                     }
                  $last_month_ticket = $year."-".$last_month; // to the month 
                  $this_month_ticket = $year."-".$this_month; // to the month 
                  #$exist_ticket_day = date("Y-m-d"); // to the month
                  $ticket_id_type_one = $exist_ticket_id."[".$last_month_ticket;
                  $ticket_id_type_two = $exist_ticket_id."[".$this_month_ticket;

                  # Allow for at least one week either way - by which time the ticket should be closed..
                  /*
                  $exist_ticket_day_plus_one_day = date('Y-m-d', strtotime($exist_ticket_day .' +1 day'));
                  $exist_ticket_day_minus_six_days = date('Y-m-d', strtotime($exist_ticket_day .' -6 days'));
                  $exist_ticket_day_minus_five_days = date('Y-m-d', strtotime($exist_ticket_day .' -5 days'));
                  $exist_ticket_day_minus_four_days = date('Y-m-d', strtotime($exist_ticket_day .' -4 days'));
                  $exist_ticket_day_minus_three_days = date('Y-m-d', strtotime($exist_ticket_day .' -3 days'));
                  $exist_ticket_day_minus_two_days = date('Y-m-d', strtotime($exist_ticket_day .' -2 days'));
                  $exist_ticket_day_minus_one_day = date('Y-m-d', strtotime($exist_ticket_day .' -1 day'));
                  $exist_ticket_day_plus_two_days = date('Y-m-d', strtotime($exist_ticket_day .' +2 days'));
                  $exist_ticket_day_plus_three_days = date('Y-m-d', strtotime($exist_ticket_day .' +3 days'));
                  $exist_ticket_day_plus_four_days = date('Y-m-d', strtotime($exist_ticket_day .' +4 days'));
                  $exist_ticket_day_plus_five_days = date('Y-m-d', strtotime($exist_ticket_day .' +5 days'));
                  $exist_ticket_day_plus_six_days = date('Y-m-d', strtotime($exist_ticket_day .' +6 days'));
                  */

                  $acttickets_object_type = "Ticketing";
                  $acttickets_action = "select";
                  $acttickets_params[0] = " name LIKE '%".$ticket_id_type_one."%' || name LIKE '%".$ticket_id_type_two."%'  ";
                  $acttickets_params[1] = "id,filter_id,account_id_c,ticket_id,name,status"; // select array
                  $acttickets_params[2] = ""; // group;
                  $acttickets_params[3] = ""; // order;
                  $acttickets_params[4] = ""; // limit
                  $acttickets_params[5] = $lingoname; // limit
  
                  $acttickets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acttickets_object_type, $acttickets_action, $acttickets_params);

                  if (is_array($acttickets)){
      
                     if ($create_report == TRUE){
                        $report .= $debugger." Tickets potentially exist like ".$ticket_id_type_one." to attach this new Activity to.<BR>";   
                        }

                     for ($cntactkt=0;$cntactkt < count($acttickets);$cntactkt++){
                         $tick_id = $acttickets[$cntactkt]['id'];
                         $ticket_id = $acttickets[$cntactkt]['ticket_id'];
                         $reply_filter_id = $acttickets[$cntactkt]['filter_id'];
                         $existticket_name = $acttickets[$cntactkt]['name'];
                         $ticket_status = $acttickets[$cntactkt]['status'];

                         if ($create_report == TRUE){
                            $report .= $debugger." Ticket potentially exists: ".$ticket_id."<BR>";
                            }


                         # This will only work IF the engineers use the ticketing system, key AND it is registered in the DB
                         if ($subject != $this->replacer($ticket_id,"",$subject)){
                            # We have a hit - the subject/body resembles an existing ticket

                            if ($create_report == TRUE){
                               $report .= $debugger." Ticket found: ".$ticket_id."<BR>";
                               }

                            $michimail = FALSE;
                            $match = TRUE;
                            $create_activity = TRUE;
                            $create_email = TRUE;
                            $create_activity_ticket_id = $tick_id;
                            $create_activity_email_ticket_id = $ticket_id;
                            $create_activity_email_ticket_status = $ticket_status;

                            break;

                            } // end if ($subject != $this->replacer($ticket_id,"",$subject)){

                         } // for based on like

                     } // if array

                  } // if found ticket_id

               } // if exist_ticket_id

            #########################
            # If by vendor ID or by ticket

            if ($create_activity != FALSE){
               #########################
               # Just keeping structure

               if ($create_activity != FALSE){
                  #########################
                  # Just keeping structure

                  if ($create_activity != FALSE){
                     #########################
                     # If reply - create activity

                     if ($reply_filter_id == NULL){

                        # Have to find a filter rule that provide default activity info
                        $checkfilter_object_type = "ConfigurationItems";
                        $checkfilter_action = "select";
                        $checkfilter_params[0] = " name='DefaultActivityFilter' && account_id_c='".$account_id_c."' ";
                        $checkfilter_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname";
                        $checkfilter_params[2] = ""; // group;
                        $checkfilter_params[3] = ""; // order;
                        $checkfilter_params[4] = ""; // limit
  
                        $checkfilters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $checkfilter_object_type, $checkfilter_action, $checkfilter_params);

                        if (is_array($checkfilters)){

                           # Default exists for this account = NEW Filterbits for sending

                           for ($chkfltrcnt=0;$chkfltrcnt < count($checkfilters);$chkfltrcnt++){
 
                               $reply_filter_id = $checkfilters[$chkfltrcnt]['id'];

                               } // end for

                           } // if array checkfilters

                        } // if filter_id

                     if ($reply_filter_id != NULL){

                        # Use Filter to collect components
                        $filterbit_object_type = "ConfigurationItems";
                        $filterbit_action = "select";
                        $filterbit_params[0] = " sclm_configurationitems_id_c='".$reply_filter_id."' && enabled=1 ";
                        $filterbit_params[1] = "";
                        $filterbit_params[2] = ""; // group;
                        $filterbit_params[3] = ""; // order;
                        $filterbit_params[4] = ""; // limit
                        $replyfilterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

                        if ($create_report == TRUE){
                           $report .= $debugger." Filter Base Ticket: <B>".$existticket_name." [".$ticket_id."] and filter ".$filter_id."</B><BR>";
                           }

                        ############################
                        # Do Logger
                        if ($do_logger == TRUE){
                           $log_content = "Email Reply with ticket info [".$bodyfiledate."]: ".$ticket_id;
                           $logparams[0] = $log_location;
                           $logparams[1] = $log_name;
                           $logparams[2] = $log_content;
                           $this->funky_logger ($logparams);
                           }
                        # End Logger 
                        ############################

                        if ($create_report == TRUE){
                           $report  .= $debugger." Doing Filterbit for filter ".$reply_filter_id."<BR>";
                           }

                        $dofilterbit_params[0] = $replyfilterbits;
                        $dofilterbit_params[1] = $subject;
                        $dofilterbit_params[2] = $from_mailname;
                        $dofilterbit_params[3] = $body;
                        $dofilterbit_params[4] = $date;
                        $dofilterbit_params[5] = $udate;
                        $dofilterbit_params[6] = $filespack;
                        $dofilterbit_params[7] = $report;
                        $dofilterbit_params[8] = $match;
                        $dofilterbit_params[9] = $debug;
                        $dofilterbit_params[10] = $reply_filter_id;
                        $dofilterbit_params[11] = FALSE;
                        $dofilterbit_params[12] = FALSE;
                        $dofilterbit_params[13] = $check_maint_servers;
                        $dofilterbit_params[14] = "";//$previous_ticket;
                        $dofilterbit_params[15] = "";//$previous_title;
                        $dofilterbit_params[16] = "";//$previous_subject;
                        $dofilterbit_params[17] = $email_id;
                        $dofilterbit_params[18] = $tolist;
                        $dofilterbit_params[19] = $cclist;
                        $dofilterbit_params[20] = 0; //count($filterbit_triggers);

                        $replyparams[0] = $create_activity_ticket_id;
                        $replyparams[1] = $create_activity_email_ticket_id;
                        $replyparams[2] = $create_activity_email_ticket_status;

                        $dofilterbit_params[21] = $replyparams; // is reply
                        $dofilterbit_params[22] = $precheckparams; // is reply
 
                        ##########################################
                        # Begin doing filterbits

                        $filterbit_returns = $this->do_filterbits ($dofilterbit_params);
                        $final_message = $filterbit_returns[0];
                        $match = $filterbit_returns[1];
                        $create_mail = $filterbit_returns[2];
                        $create_ticket = $filterbit_returns[3];
                        $create_activity = $filterbit_returns[4];
                        $catchall = $filterbit_returns[5];
                        $previous_ticket = $filterbit_returner[6];
                        $previous_title = $filterbit_returner[7];
                        $previous_subject = $filterbit_returner[8];
                        $trigger_rate = $filterbit_returner[9];
                        $thistriggercount = $filterbit_returner[10];
   
                        $emailreply = TRUE;

                        $break;

                        } else {

                        # No filter - problem if we have come to this point!!
 
                        if ($create_report == TRUE){
                           $report .= $debugger." No Filter ID!!<BR>";
                           }

                        } // end if filter

                     } else { // if array based on like

                     $create_activity = FALSE;

                     if ($create_report == TRUE){
                         $report  .= $debugger." No Tickets Exist to attach Activity to...<BR>";
                         }
   
                     } // end if check

                  } // if do create activity

               } // end if key is in subject

            # End check for create activity based on an email
            ##########################################
            # Maintenance

            if ($found_server_id && $create_activity == FALSE){

               # Check Maintenance
               $maintenance = FALSE;
               # Nullify the server in the email if in Maintenance
               $maintenance_window = "";

               # Check the email current datetime
               $email_datetime = date('Y-m-d H:i', strtotime($date));
               # Collect any maintenance start/end times if available
               if ($create_report == TRUE){
                  $report .= $debugger." Checking Maintenance window for Server: <B>".$server_replace."</B><BR>";
                  }
  
               # Start DateTime
               $ci_type = '787ab970-8f2a-efed-3aca-52ecd566b16b';
               $mnt_object_type = 'ConfigurationItems';
               $mnt_action = "select";
               $mnt_params[0] = " sclm_configurationitems_id_c='".$found_server_id."' && sclm_configurationitemtypes_id_c='".$ci_type."' ";
               $mnt_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,$lingoname";
               $mnt_params[2] = ""; // group;
               $mnt_params[3] = "";
               $mnt_params[4] = ""; // limit
       
               $mnt_items = "";    
               $mnt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mnt_object_type, $mnt_action, $mnt_params);

               $mnt_id = "";
               $maintenance_startdatetime = "";

               if (is_array($mnt_items)){

                  for ($mntcnt=0;$mntcnt < count($mnt_items);$mntcnt++){

                      #$mnt_id = $mnt_items[$mntcnt]['id']; // The live status
                      $maintenance_startdatetime = $mnt_items[$mntcnt]['name']; // The live status

                      if ($create_report == TRUE){
                         $report .= $debugger." Maintenance start: <B>".$maintenance_startdatetime."</B><BR>";
                         }

                      } // end for
                    
                  } // end if

               # End DateTime
               $ci_type = 'b38181b6-eb59-0bc3-bad3-52ecd65163f5';
               $mnt_object_type = 'ConfigurationItems';
               $mnt_action = "select";
               $mnt_params[0] = " sclm_configurationitems_id_c='".$found_server_id."' && sclm_configurationitemtypes_id_c='".$ci_type."' ";
               $mnt_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,$lingoname";
               $mnt_params[2] = ""; // group;
               $mnt_params[3] = "";
               $mnt_params[4] = ""; // limit

               $mnt_items = "";  
               $mnt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mnt_object_type, $mnt_action, $mnt_params);

               $mnt_id = "";
               $maintenance_enddatetime = "";

               if (is_array($mnt_items)){

                  for ($mntcnt=0;$mntcnt < count($mnt_items);$mntcnt++){
       
                      #$mnt_id = $mnt_items[$mntcnt]['id']; // The live status
                      $maintenance_enddatetime = $mnt_items[$mntcnt]['name']; // The live status

                      if ($create_report == TRUE){
                         $report .= $debugger." Maintenance end: <B>".$maintenance_enddatetime."</B><BR>";
                         }
   
                      } // end for

                  } // end if

               if ($maintenance_startdatetime != NULL && $maintenance_enddatetime != NULL){

                  if ($email_datetime >= $maintenance_startdatetime && $email_datetime <= $maintenance_enddatetime){

                     # Within the maintenance window
                     $maintenance = TRUE;
                     $match = FALSE;

                     if ($create_report == TRUE){
                        $report .= $debugger." IS IN Maintenance!!<BR>";
                        }

                     } else {
      
                     if ($create_report == TRUE){
                        $report .= $debugger." NOT IN Maintenance!!<BR>";
                        }
         
                     }

                  } else {// if null

                  $ci_type = '2864a518-19f4-ddfa-366e-52ccd012c28b';

                  if ($create_report == TRUE){
                     $report .= $debugger." Checking Maintenance for Individual Server: <B>".$server_replace."</B><BR>";
                     }

                  $mnt_object_type = 'ConfigurationItems';
                  $mnt_action = "select";
                  $mnt_params[0] = " sclm_configurationitems_id_c='".$found_server_id."' && sclm_configurationitemtypes_id_c='".$ci_type."' ";
                  $mnt_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,$lingoname";
                  $mnt_params[2] = ""; // group;
                  $mnt_params[3] = "";
                  $mnt_params[4] = ""; // limit

                  $mnt_items = "";  
                  $mnt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mnt_object_type, $mnt_action, $mnt_params);

                  $mnt_id = "";
                  $maintenance_status = "";

                  if (is_array($mnt_items)){

                     for ($mntcnt=0;$mntcnt < count($mnt_items);$mntcnt++){

                         #$mnt_id = $mnt_items[$mntcnt]['id']; // The live status
                         $maintenance_status = $mnt_items[$mntcnt]['name']; // The live status

                         if ($maintenance_status == 1){
                            $maintenance = TRUE;
                            $match = FALSE;
 
                            if ($create_report == TRUE){
                               $report .= $debugger." Maintenance IN for Server: <B>".$server_replace."</B><BR>";
                               }
   
                            } elseif ($maintenance_status == 0){// in maintenance

                            #$match = TRUE;
                            if ($create_report == TRUE){
                               $report .= $debugger." Maintenance OUT for Server: <B>".$server_replace."</B><BR>";
                               }
                    
                            } else { // end else

                            if ($create_report == TRUE){
                               $report .= $debugger." Maintenance not set for Server: <B>".$server_replace."</B><BR>";
                               }
                    
                            } // end status check

                         } // end for

                     } // end if array

                  } // end else check for individual server status

               } // if $found_server_id and not activity

            ###############################
            # Move email to ticketed folder

            $portal_imap_port = "993";
            $portal_imap_server = "imap.gmail.com";

            if ($debug == TRUE && $maintenance == TRUE){
               $nocatchall = TRUE; // will result in false, but not a stray email to send in
               $report .= $debugger." Do NOT perform catch-all - Maintenance ON and FALSE is correct result..<BR>";

               $from_folder = "Development/Test-In";
               $to_folder = "Development/Test-Auto-Maintenance";

               $moveparams[0] = $portal_imap_port;
               $moveparams[2] = $portal_imap_server;
               $moveparams[3] = $from_folder;
               $moveparams[4] = $to_folder;
               $moveparams[5] = $email_id;
               $moveparams[6] = $portal_email;
               $moveparams[7] = $portal_email_password;
               $moveparams[8] = $report;
               $moveparams[9] = $create_report;

               $report = $this->move_emails($moveparams);
      
               } elseif ($debug != TRUE && $maintenance == TRUE) {

               $from_folder = "Admin/0 - Auto-Filtered";
               $to_folder = "Admin/0 - Auto-Maintenance";
   
               $moveparams[0] = $portal_imap_port;
               $moveparams[2] = $portal_imap_server;
               $moveparams[3] = $from_folder;
               $moveparams[4] = $to_folder;
               $moveparams[5] = $email_id;
               $moveparams[6] = $portal_email;
               $moveparams[7] = $portal_email_password;
               $moveparams[8] = $report;
               $moveparams[9] = $create_report;

               $report = $this->move_emails($moveparams);

               break;

               }

            # End Moving mintenance emails
            ###############################
            # Setting Maintenance Window

         if ($create_activity == FALSE){

            if ($create_report == TRUE){
               $report  .= $debugger." Checking for Maintenance Window<BR>";
               }

            $maintenance_setting = FALSE;

            $maintenance_startdatetime = "";
            $maintenance_startcheck = "";
            $maintenance_endcheck = "";
            $maintenance_startsAt = "";
            $maintenance_endsAt = "";
            $maintenance_startcheck = $this->replacer("[Maintenance_Start_DateTime]", "", $body);
            $maintenance_endcheck = $this->replacer("[EndMaintenance_Start_DateTime]", "", $body);
            if ($maintenance_startcheck == $body || $maintenance_endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $maintenance_startsAt = strpos($body, "[Maintenance_Start_DateTime]") + strlen("[Maintenance_Start_DateTime]");
               $maintenance_endsAt = strpos($body, "[EndMaintenance_Start_DateTime]", $maintenance_startsAt);
               $maintenance_startdatetime = substr($body, $maintenance_startsAt, $maintenance_endsAt - $maintenance_startsAt);
               $maintenance_startdatetime = $this->replacer("\n", "", $maintenance_startdatetime);
               #$maintenance_startdatetime = $this->replacer(" ", "", $maintenance_startdatetime);
               } 

            $maintenance_enddatetime = "";
            $maintenance_startcheck = "";
            $maintenance_endcheck = "";
            $maintenance_startsAt = "";
            $maintenance_endsAt = "";
            $maintenance_startcheck = $this->replacer("[Maintenance_End_DateTime]", "", $body);
            $maintenance_endcheck = $this->replacer("[EndMaintenance_End_DateTime]", "", $body);
            if ($maintenance_startcheck == $body || $maintenance_endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $maintenance_startsAt = strpos($body, "[Maintenance_End_DateTime]") + strlen("[Maintenance_End_DateTime]");
               $maintenance_endsAt = strpos($body, "[EndMaintenance_End_DateTime]", $maintenance_startsAt);
               $maintenance_enddatetime = substr($body, $maintenance_startsAt, $maintenance_endsAt - $maintenance_startsAt);
               $maintenance_enddatetime = $this->replacer("\n", "", $maintenance_enddatetime);
               #$maintenance_enddatetime = $this->replacer(" ", "", $maintenance_enddatetime);
               } 

            if ($maintenance_startdatetime != NULL && $maintenance_enddatetime != NULL){
         
               $maintenance_setting = TRUE;

               if ($create_report == TRUE){
                  $report  .= $debugger." Maintenance Window Found (".$maintenance_startdatetime." to ".$maintenance_enddatetime.") <BR>";
                  }

               # Update the servers in the email with new maintenance windows
               if (is_array($check_maint_servers)){

                  for ($cntmntsrvr=0;$cntmntsrvr < count($check_maint_servers);$cntmntsrvr++){
      
                      $server_id = $check_maint_servers[$cntmntsrvr]['id'];
                      $server_name = $check_maint_servers[$cntmntsrvr]['name'];

                      $server_check = $this->replacer($server_name,"", $body);

                      $nameupper = strtoupper ($server_name);

                      $server_check_upper = $this->replacer($nameupper,"", $body);

                      $namelower = strtolower ($server_name);

                      $server_check_lower = $this->replacer($namelower,"", $body);

                      if (($server_check != $body || $server_check_upper != $body || $server_check_lower != $body ) && $server_id != NULL){
                         # keyword exists in body - check for servers
                         $srvupdateparams[0] = $server_id;
                         $srvupdateparams[1] = 1;
                         $srvupdateparams[2] = 'maintenance_window';
                         $srvupdateparams[3] = $maintenance_startdatetime;
                         $srvupdateparams[4] = $maintenance_enddatetime;
                         $updated = "";
                         $updated = $this->update_items($srvupdateparams);

                         if ($create_report == TRUE){
                            $report  .= $debugger." Maintenance Window set for <B>".$server_name."</B><BR>";
                            }
      
                         } // if server in email

                      } // end for all server check

                  } // if array 

               } // end if maintenance window provided
      
            # End Setting Maintenance Window
            ##########################################
            # Checking Individual Maintenance

            $update_status = "";
            $keyword_check = "";
            $keyword_check = $this->replacer("Server_Maintenance_In","",$body);

            $maintenanceIN = FALSE;
            $maintenanceOUT = FALSE;

            if ($keyword_check != $body){
               $update_status = 1;
               $maintenanceIN = TRUE;

               if ($create_report == TRUE){
                  $report .= $debugger." Found Server Maintenance Status Command: <B>Turn ON</B><BR>";
                  }

               } // end if keyword for IN

            $keyword_check = $this->replacer("Server_Maintenance_Out","",$body);

            if ($keyword_check != $body){
               $update_status = 0;
               $maintenanceOUT = TRUE;
   
               if ($create_report == TRUE){
                  $report .= $debugger." Found Server Maintenance Status Command: <B>Turn OFF</B><BR>";
                  }

               } // end if keyword for OUT

            if ($maintenanceIN == TRUE || $maintenanceOUT == TRUE){

               $maintenance_setting = TRUE;
               # keyword exists in body - check for servers
               # Check all servers in system

               if (is_array($check_maint_servers)){

                  for ($cntmntsrvr=0;$cntmntsrvr < count($check_maint_servers);$cntmntsrvr++){
                      $server_id = $check_maint_servers[$cntmntsrvr]['id'];
                      $server_name = $check_maint_servers[$cntmntsrvr]['name'];

                      $maint_server_check = $this->replacer($server_name,"", $body);
      
                      if ($maint_server_check != $body && $maintenanceIN == TRUE){
                         # keyword exists in body - check for servers
                         $srvupdateparams[0] = $server_id;
                         $srvupdateparams[1] = 1;
                         $srvupdateparams[2] = 'maintenance_status';
                         $updated = "";
                         $updated = $this->update_items($srvupdateparams);

                         if ($create_report == TRUE){
                            $report  .= $debugger."ALL Servers Maintenance Status Updated for $server_name: <B>: ".$updated."</B><BR>";
                            }

                         } // Server updated!

                      if ($server_check != $body && $maintenanceOUT == TRUE){
                         # keyword exists in body - check for servers
                         $srvupdateparams[0] = $server_id;
                         $srvupdateparams[1] = 0;
                         $srvupdateparams[2] = 'maintenance_status';
                         $updated = "";
                         $updated = $this->update_items($srvupdateparams);

                         if ($create_report == TRUE){
                            $report  .= $debugger."ALL Servers Maintenance Status Updated for $server_name: <B>: ".$updated."</B><BR>";
                            }

                         } // Server updated!

                      } // for

                  } // is_array($server_pack)

               } // if keyword matches

            # End Check maintenance
            #################################################
            # Perform Filter

            # First see if a similar email has arrived in the last 2 minutes
            #$date = date('Y-m-d H:i:s', $udate);
            $emailmins = date("Y-m-d H:i:s",strtotime($date));
            $checktime_minus_mins = date('Y-m-d H:i:s', strtotime($emailmins .' -3 minutes'));
            $previous_date_minus_mins = date('Y-m-d H:i:s', strtotime($previous_date .' -3 minutes'));

            # Check previous email
            $end_time = date("Y-m-d H:i:s", strtotime($previous_date.' +4 minutes'));
            $start_time = date("Y-m-d H:i:s", strtotime($previous_date.' -4 minutes'));
            $emailtime = date("Y-m-d H:i:s", strtotime($date));
            #list($email_hour,$email_minute) = explode(":", $emailtime);
 
            $duplicate = FALSE;

            if (($emailtime >= $start_time && $emailtime <= $end_time) && ($subject == $previous_subject)){
               # if (($emailtime == $previous_date) && $subject == $previous_subject)){

               if ($create_report == TRUE){
                  $report  .= "<div style=\"".$divstyle_orange."\">($emailtime >= $start_time && $emailtime <= $end_time) && ($subject == $previous_subject)</div>";
                  }

               $duplicate = TRUE;

               } // end if not same email/subject in time-frame

            $mailcheck_object_type = "Emails";
            $mailcheck_action = "select";
            #$tickcheck_params[0] = " (status='e47fc565-c045-fef9-ef4f-52802bfc479c' || status='320138e7-3fe4-727e-8bac-52802c62a4b6') && account_id_c='".$portal_account_id."' ";
            #$mailcheck_params[0] = " name='".$subject."' && account_id_c='".$portal_account_id."' && ('".$checktime_minus_five_mins."' <= DATE_FORMAT(date_entered,'%Y-%m-%d %H-%i') AND '".$emailmins."' >=DATE_FORMAT(date_entered,'%Y-%m-%d %H-%i')) ";
            #$mailcheck_params[0] = " name='".$subject."' && account_id_c='".$portal_account_id."' && ('".$checktime_minus_mins."' <= date_entered AND '".$emailmins."' >= date_entered) ";
            # If Existing Email Date is greater than the New Email Date minus 3 Minutes  
            #$mailcheck_params[0] = " name='".$subject."' && account_id_c='".$portal_account_id."' && (date_entered >= '".$checktime_minus_mins."') ";
            #select * from myTable where Login_time > date_sub(now(), interval 3 minute) ;
            $mailchecksubject = $this->replacer('\\','\\\\',$subject);
            #$mailcheckbody = $body;
            $mailcheck_params[0] = " deleted=0 && name='".$mailchecksubject."' && account_id_c='".$portal_account_id."' && (date_entered >= '".$checktime_minus_mins."' AND date_entered <= '".$emailmins."') ";
            #$mailcheck_params[0] = " description='".$mailcheckbody."' && account_id_c='".$portal_account_id."' && (date_entered >= '".$checktime_minus_mins."' AND date_entered <= '".$emailmins."') ";
  
            $mailcheck_params[1] = "id,date_entered,name,description,account_id_c,sclm_ticketing_id_c"; // select array
            $mailcheck_params[2] = ""; // group;
            $mailcheck_params[3] = ""; // order;
            $mailcheck_params[4] = ""; // limit

            $mailcheck = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mailcheck_object_type, $mailcheck_action, $mailcheck_params);

            $recentemails = 0;
            $recentemails = count($mailcheck);

            if (is_array($mailcheck)){

               for ($mlckcnt=0;$mlckcnt < count($mailcheck);$mlckcnt++){

                   $check_email_id = $mailcheck[$mlckcnt]['id'];
                   $check_email_date = $mailcheck[$mlckcnt]['date_entered'];
                   $check_email_name = $mailcheck[$mlckcnt]['name'];
                   $check_email_ticket_id = $mailcheck[$mlckcnt]['sclm_ticketing_id_c'];
                   # Need to get the filter ID to check what other strings may exist in body as subject may be same, but body diff

                   $checkedmails .= "Date: ".$check_email_date." Subject: ".$check_email_name."<BR>";

                   } // for

               } // if

            if ($create_report == TRUE){
               $report .= $debugger." Check Query (".$mailcheck_params[0].") for recent similar emails [Count: ".$recentemails."] with Subject and date within minutes (Email time:".$emailmins." to check within ".$checktime_minus_mins." - if true - then ignore!!<BR>".$checkedmails."<BR>";
               }

            $filterset_object_type = "ConfigurationItems";
            $filterset_action = "select";
            $filterset_params[0] = " sclm_configurationitemtypes_id_c='d2313332-261a-cfe2-4fbe-528f0a6bb9a1' && account_id_c='".$portal_account_id."' ";
            $filterset_params[1] = ""; // select array
            $filterset_params[2] = ""; // group;
            $filterset_params[3] = ""; // order;
            $filterset_params[4] = ""; // limit
  
            $filtersets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterset_object_type, $filterset_action, $filterset_params);

            if ($create_report == TRUE){
               $report .= $debugger." Check for Filter Sets<BR>";
               }

            if ($duplicate == TRUE){

               if ($create_report == TRUE){
                  $report .= $debugger."<div style=\"".$divstyle_orange."\">The Previous Body (Subject: $previous_subject & Date: $previous_date) is same as this Body - we ain't gonna do it!!!</div>";
                  }

               } // if duplicate

            #################################################
            # Have Filter Sets

            if (is_array($filtersets) && ($check_email_id==NULL) && ($duplicate != TRUE) && ($maintenance_setting == FALSE) && ($emailreply != TRUE)){
               #if (is_array($filtersets) && ($check_email_id==NULL) && ($duplicate != TRUE)){

               for ($cnt=0;$cnt < count($filtersets);$cnt++){
                   # Second loop for Filtersets - PER email

                   $filterset_id = $filtersets[$cnt]['id'];
                   $filterset_name = $filtersets[$cnt]['name'];

                   ############################
                   # Do Logger
                   if ($do_logger == TRUE){
                      $log_content = "For Filterset Loop Start for Filterset [".$bodyfiledate." CNT[".count($filtersets)."]]: ".$filterset_name;
                      $logparams[0] = $log_location;
                      $logparams[1] = $log_name;
                      $logparams[2] = $log_content;
                      $this->funky_logger ($logparams);
                      }
                   # End Logger 
                   ############################

                   if ($create_report == TRUE){
                      $report .= "<div style=\"".$divstyle_blue."\"><center><B>Debug for Filter Set: ".$filterset_name."</B></center></div>";
                      $report .= $debugger." Found a Filter Set: ".$filterset_name." ID: ".$filterset_id."<BR>";
                      }

                   ##########################################
                   # Use Filtering Set to get Filters

                   # Find the catch-all component as part of a filter to remove it
                   $catch_all_filter_object_type = "ConfigurationItems";
                   $catch_all_filter_action = "select";
                   $catch_all_filter_params[0] = " name='a51b8e41-bb1b-f729-2c59-52ccc314bc0a' && enabled=1 && account_id_c='".$portal_account_id."' ";
                   $catch_all_filter_params[1] = "id,enabled,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c";
                   $catch_all_filter_params[2] = ""; // group;
                   $catch_all_filter_params[3] = ""; // order;
                   $catch_all_filter_params[4] = ""; // limit
  
                   $catch_all_filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $catch_all_filter_object_type, $catch_all_filter_action, $catch_all_filter_params);

                   if (is_array($catch_all_filters)){

                      for ($catch_all_cntfltr=0;$catch_all_cntfltr < count($catch_all_filters);$catch_all_cntfltr++){
   
                          $catch_all_filter_id = $catch_all_filters[$catch_all_cntfltr]['sclm_configurationitems_id_c'];
                          $catch_all_filterbit_id = $catch_all_filters[$catch_all_cntfltr]['id'];

                         if ($create_report == TRUE){
                            $returner = $this->object_returner ("ConfigurationItems", $catch_all_filter_id);
                            $catch_all_filter_name = $returner[0];
                            $report .= $debugger." Catch-all filter ".$catch_all_filter_name." found<BR>";
                            }

                          # Check if this filter is within the filter set - $filterset_id

                          $catch_all_filterset_object_type = "ConfigurationItems";
                          $catch_all_filterset_action = "select";
                          $catch_all_filterset_params[0] = " id='".$catch_all_filter_id ."' ";
                          $catch_all_filterset_params[1] = "id,enabled,sclm_configurationitems_id_c";
                          $catch_all_filterset_params[2] = ""; // group;
                          $catch_all_filterset_params[3] = ""; // order;
                          $catch_all_filterset_params[4] = ""; // limit
                          
                          $catch_all_filtersets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $catch_all_filterset_object_type, $catch_all_filterset_action, $catch_all_filterset_params);

                          if (is_array($catch_all_filtersets)){

                             for ($catch_all_cntfltrset=0;$catch_all_cntfltrset < count($catch_all_filtersets);$catch_all_cntfltrset++){
   
                                 $catch_all_filterset_id = $catch_all_filtersets[$catch_all_cntfltrset]['sclm_configurationitems_id_c'];

                                 if ($catch_all_filterset_id == $filterset_id){
                                    # The catch-all filter is part of this filterset

                                    if ($create_report == TRUE){
                                       $report .= "<div style=\"".$divstyle_orange."\"><center><B>Catch-All Filter Found for Filterset</B></center></div>";
                                       }

                                    break1;

                                    } else {

                                    $catch_all_filter_id = "";
                                    $catch_all_filterbit_id = "";

                                    } // end else 

                                 } // end for

                             } // end if

                          } // end for

                      if ($catch_all_filter_id != NULL){
                         $catch_all_query = " && id != '".$catch_all_filter_id."' ";

                         if ($create_report == TRUE){
                            $report .= $debugger." Catch-all filter ".$catch_all_filter_name." to be used last<BR>";
                            }

                         } else {
                         $catch_all_query = "";
                         }

                      } // end if array

                   # End find Check-all Filters
                   ##########################################
                   # Get Filters

                   $filter_object_type = "ConfigurationItems";
                   $filter_action = "select";
                   $filter_params[0] = " sclm_configurationitems_id_c='".$filterset_id."' && enabled=1 && sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' ".$catch_all_query;
                   $filter_params[1] = "id,enabled,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,account_id_c,contact_id_c,project_id_c,projecttask_id_c"; // select array
                   $filter_params[2] = ""; // group;
                   $filter_params[3] = ""; // order;
                   $filter_params[4] = ""; // limit
  
                   $filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filter_object_type, $filter_action, $filter_params);

                   if ($create_report == TRUE || $catch_all_filter_id != NULL){
                      $report .= $debugger." Looking for Filters (Catch-all query: ".$catch_all_query.")<BR>";
                      }

                   ##########################################
                   # Have Filters

                   $match = FALSE;

                   if (is_array($filters)){
   
                      for ($cntfltr=0;$cntfltr < count($filters);$cntfltr++){
                          # Third loop - each filter and filterbits PER email

                          $filter_createticket = "";
                          $create_ticket = "";
                          $create_email = "";
                          $ip_pack = "";
                          $ip_show = "";
                          $server_pack = "";
                          $server_show = "";
                          $sla_pack = "";
                          $filter_strings = "";
                          $filter_string = "";
                          $filter_nonstrings = "";
                          $filter_nonstring = "";
                          $filter_nonserverips = "";

                          $filter_createactivity = "";
                          $create_activity = "";
                          $sender_pack = "";

                          $filter_id = $filters[$cntfltr]['id'];
                          $filter_name = $filters[$cntfltr]['name'];

                          ############################
                          # Do Logger
                          if ($do_logger == TRUE){
                             $log_content = "For Filter Loop Start for Filter [".$bodyfiledate." CNT [".$cntfltr." of ".count($filters)."]]: ".$filter_name;
                             $logparams[0] = $log_location;
                             $logparams[1] = $log_name;
                             $logparams[2] = $log_content;
                             $this->funky_logger ($logparams);
                             }
                          # End Logger 
                          ############################
                          
                          if ($match != TRUE){
                             #$match = FALSE;
                             }

                          if ($debug == TRUE || $check_all_filter_id != NULL){
                             $filter_message = "<div style=\"".$divstyle_grey."\"><center><B>Debug for Filter: ".$filter_name."</B></center></div>";
                             $filter_message .= $debugger." Found Filter: <B>".$filter_name."</B> - need to collect filter components<BR>";
                             }

                          # Use Filter to collect components
                          $filterbit_object_type = "ConfigurationItems";
                          $filterbit_action = "select";
                          $filterbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && enabled=1 ";
                          $filterbit_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c";
                          $filterbit_params[2] = ""; // group;
                          $filterbit_params[3] = ""; // order;
                          $filterbit_params[4] = ""; // limit
  
                          $filterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

                          ##########################################
                          # Have Filterbits - use filterbits function to loop through for each

                          if (is_array($filterbits)){
   
                             # How many triggers must be met to be true
                             $filterbit_trigger_object_type = "ConfigurationItems";
                             $filterbit_trigger_action = "select";
                             #$trigger_types = "83a83279-9e48-0bfe-3ca0-52b8d8300cc2";
                             $filterbit_trigger_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && enabled=1 && (sclm_configurationitemtypes_id_c='83a83279-9e48-0bfe-3ca0-52b8d8300cc2' || sclm_configurationitemtypes_id_c='291f5d67-13af-1b11-7e39-52b9d60288dc' || sclm_configurationitemtypes_id_c='ecf521df-6ff1-aa5c-0069-52b9d605f284' || sclm_configurationitemtypes_id_c='bb105bd2-6d5d-e9b1-dc66-52ba021e1f63' || sclm_configurationitemtypes_id_c='cc55a107-98ca-8261-9900-52ce36601cd0') ";
                             $filterbit_trigger_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c"; // select array
                             $filterbit_trigger_params[2] = ""; // group
                             $filterbit_trigger_params[3] = ""; // order
                             $filterbit_trigger_params[4] = ""; // limit
                             $filterbit_triggers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_trigger_object_type, $filterbit_trigger_action, $filterbit_trigger_params);

                             $triggercount = count($filterbit_triggers);
                   
                             $filterbit_params[0] = $filterbits;
                             $filterbit_params[1] = $subject;
                             $filterbit_params[2] = $from_mailname;
                             $filterbit_params[3] = $body;
                             $filterbit_params[4] = $date;
                             $filterbit_params[5] = $udate;
                             $filterbit_params[6] = $filespack;
                             $report = $report.$filter_message;
                             $filterbit_params[7] = $report;
                             $filterbit_params[8] = $match;
                             $filterbit_params[9] = $debug;
                             $filterbit_params[10] = $filter_id;

                             if ($check_all_filter_id != NULL){
                                $filterbit_params[11] = TRUE;
                                }

                             $filterbit_params[12] = #$catchall;
                             $filterbit_params[13] = $check_maint_servers;
                             $filterbit_params[14] = $previous_ticket;
                             $filterbit_params[15] = $previous_title;
                             $filterbit_params[16] = $previous_subject;
                             $filterbit_params[17] = $email_id;
                             $filterbit_params[18] = $tolist;
                             $filterbit_params[19] = $cclist;
                             $filterbit_params[20] = count($filterbit_triggers);
                             $filterbit_params[22] = $precheckparams;

                             ##########################################
                             # Begin doing filterbits

                             $filterbit_returns = $this->do_filterbits ($filterbit_params);
                             $report = $filterbit_returns[0];
                             $match = $filterbit_returns[1];
                             $create_mail = $filterbit_returns[2];
                             $create_ticket = $filterbit_returns[3];
                             $create_activity = $filterbit_returns[4];
                             $catchall = $filterbit_returns[5];
                             $previous_ticket = $filterbit_returner[6];
                             $previous_title = $filterbit_returner[7];
                             $previous_subject = $filterbit_returner[8];
                             $trigger_rate = $filterbit_returner[9];
                             $thistriggercount = $filterbit_returner[10];

                             } // if is_array($filterbits)

                          # End Filterbits Array Loop
                          ##########################################
                          # If TRUE, then no need to continue filters

		          if ($create_mail == TRUE && $create_ticket == TRUE){

                             $catchall = FALSE; 
                             break;

                             } #elseif ($cntfltr == count($filters)-1 && $catchall == TRUE){

                             #elseif ($trigger_rate < $thistriggercount && $match == FALSE){
                             #$catchall = TRUE; 
                             #break1;

                             #} // end elseif

                          } // for ($cntfltr=0;$cntfltr < count($filters);$cntfltr++){

                      # End for Filters
                      ###################################
                      # Get ride of any files not used with no match

                      if (is_array($filespack) && $match == FALSE && ($create_mail == FALSE || $create_ticket == FALSE || $create_activity == FALSE)){
                               
                         foreach ($filespack as $filename->$link){
                                            
                                 $email_content .= $filename.": ".$link."\n";
                                 $this_file_location = "/var/www/vhosts/scalastica.com/httpdocs/content/".$filename;

                                 if ($debug == TRUE || $check_all_filter_id != NULL){
                                    $report .= $debugger." Delete Filename: ".$this_file_location.": ".$link."<BR>";
                                    }

                                 unlink($this_file_location);

                                 } // foreach

                         } // files

                      # End Get rid of any files not used with no match
                      ##########################################
                      } // array filters

                   ##########################################
                   # Have Filters - do again to check for catch-all

                   if ($catch_all_filter_id != NULL && $catchall == TRUE){

                      # Use Filter to collect components
                      $filterbit_object_type = "ConfigurationItems";
                      $filterbit_action = "select";
                      $filterbit_params[0] = " sclm_configurationitems_id_c='".$catch_all_filter_id."' ";
                      $filterbit_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c";
                      $filterbit_params[2] = ""; // group;
                      $filterbit_params[3] = ""; // order;
                      $filterbit_params[4] = ""; // limit
  
                      $filterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

                      ##########################################
                      # Have Filter Bits

                      if (is_array($filterbits)){

                         if ($debug == TRUE || $catch_all_filter_id != NULL){
                            $report .= "<div style=\"".$divstyle_grey."\"><center><B>Debug for Catch-all Filter: ".$catch_all_filter_name."</B></center></div>";
                            $report .= $debugger." Catch All Filter Run: <B>".$catch_all_filter_name."</B> - need to collect filter components<BR>";
                            } 

                         # How many triggers must be met to be true
                         $filterbit_trigger_object_type = "ConfigurationItems";
                         $filterbit_trigger_action = "select";
                         $trigger_type = "83a83279-9e48-0bfe-3ca0-52b8d8300cc2";
                         $filterbit_trigger_params[0] = " sclm_configurationitems_id_c='".$catch_all_filter_id."' && enabled=1 && sclm_configurationitemtypes_id_c='".$trigger_type."' ";
                         $filterbit_trigger_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c";
                         $filterbit_trigger_params[2] = ""; // group
                         $filterbit_trigger_params[3] = ""; // order
                         $filterbit_trigger_params[4] = ""; // limit
                         $filterbit_triggers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_trigger_object_type, $filterbit_trigger_action, $filterbit_trigger_params);

                         $triggercount = count($filterbit_triggers);

                         ############################
                         # Do Logger
                         if ($do_logger == TRUE){
                            $log_content = "For Catch-all Filter [".$bodyfiledate."]: ".$catch_all_filter_name;
                            $logparams[0] = $log_location;
                            $logparams[1] = $log_name;
                            $logparams[2] = $log_content;
                            $this->funky_logger ($logparams);
                            }
                         # End Logger 
                         ############################
     
                         $filterbit_params[0] = $filterbits;
                         $filterbit_params[1] = $subject;
                         $filterbit_params[2] = $from_mailname;
                         $filterbit_params[3] = $body;
                         $filterbit_params[4] = $date;
                         $filterbit_params[5] = $udate;
                         $filterbit_params[6] = $filespack;
                         $filterbit_params[7] = $report;
                         $filterbit_params[8] = TRUE;
                         $filterbit_params[9] = $debug;
                         $filterbit_params[10] = $catch_all_filter_id;
                         $filterbit_params[11] = TRUE;
                         $filterbit_params[12] = TRUE;
                         $filterbit_params[13] = $check_maint_servers;
                         $filterbit_params[14] = $previous_ticket;
                         $filterbit_params[15] = $previous_title;
                         $filterbit_params[16] = $previous_subject;
                         $filterbit_params[17] = $email_id;
                         $filterbit_params[18] = $tolist;
                         $filterbit_params[19] = $cclist;
                         $filterbit_params[20] = count($filterbit_triggers);
                         $filterbit_params[21] = "";
                         $filterbit_params[22] = $precheckparams;

                         $filterbit_returns = $this->do_filterbits ($filterbit_params);
                         $report = $filterbit_returns[0];
                         $match = $filterbit_returns[1];
                         $create_mail = $filterbit_returns[2];
                         $create_ticket = $filterbit_returns[3];
                         $create_activity = $filterbit_returns[4];
                         $catchall = $filterbit_returns[5];
                         $previous_ticket = $filterbit_returner[6];
                         $previous_title = $filterbit_returner[7];
                         $previous_subject = $filterbit_returner[8];
                         $trigger_rate = $filterbit_returner[9];
                         $thistriggercount = $filterbit_returner[10];

                         } // is array filterbits

                      # End Have Filter Bits
                      ##########################################
   
                      } // if match false
   
                   # End Catch-all
                   ##########################################

                   } // for filter sets

               } else { // array filter sets       

               # Duplicate Exists
               if ($debug == TRUE){
                  #
                  }

               } // end filtersets

            } // end if ($valtype == 'test_filter_all_live'

            } // end if create activity

         # if perform
         #################################################

         $previous_body = $body; // check for duplicates
         $previous_date = $date;
         $previous_subject = $subject;

         } // for imap emails

     #########################################
     # End looping through each email available

     $final_messages .= "<div style=\"".$divstyle_white."\">".$report."</div>";
     $report = "";
     $final_message = "";
     $filter_message = "";
     $header_message = "";

     $imap_emails = "<div style=\"overflow:auto;min-height:200px;max-height:500px;width:98%;\">".$imap_emails."</div>";

     } else { // if array emails

     $imap_emails = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

     }

  $filterreturner[0] = $imap_emails;
  $filterreturner[1] = $final_messages;

  return $filterreturner;

 } // end do_filters function

# do_filters
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

   foreach ($to_addressees as $toadd_email => $toadd_name){
           $toadd_name = mb_encode_mimeheader($toadd_name, 'UTF-8', 'Q', "\n");
           $n = strpos($toadd_name, "\n");
           if ($n !== FALSE) $toadd_name = substr($toadd_name, 0, $n);
           $mail->AddAddress($toadd_email, $toadd_name);

           }

   } // if array

if (is_array($cc_addressees)){

   foreach ($cc_addressees as $cc_email => $cc_name){
           $cc_name = mb_encode_mimeheader($cc_name, 'UTF-8', 'Q', "\n");
           $n = strpos($cc_name, "\n");
           if ($n !== FALSE) $cc_name = substr($cc_name, 0, $n);
           $mail->AddCC($cc_email, $cc_name);
           }

   } // if array

if (is_array($bcc_addressees)){

   foreach ($bcc_addressees as $bcc_email => $bcc_name){
           $bcc_name = mb_encode_mimeheader($bcc_name, 'UTF-8', 'Q', "\n");
           $n = strpos($bcc_name, "\n");
           if ($n !== FALSE) $bcc_name = substr($bcc_name, 0, $n);
           $mail->AddBCC($bcc_email, $bcc_name);
           }

   } // if array

$mail->Subject  = $subject;
$mail->Body     = $body;
$mail->WordWrap = 100;  
 
if(!$mail->Send()) {

  $emailresult[0] = "NG";
  $emailresult[1] = "Message was not sent.";
  $emailresult[2] = "Mailer error: " . $mail->ErrorInfo;
  } else {
  $emailresult[0] = "OK";
  }

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
 # Drop down function

 function dropdown_jaxer ($do,$action,$valtype,$dd_pack, $current_value, $label,$tbl,$val,$params){

 global $strings;

 $drop_down_return = "";

 //echo "DO $do Action $action Label: $label table: $tbl <P>";

 if (is_array($params)){
    reset($params);
    while (list($key, $value) = each($params)){
          $added_params .= "&".$key."=".$value;
          }
    }

 $drop_down_return = "<select name=$label id=$label onChange=\"loader('".$tbl."');getjax('getjax.php?do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."&tbl=".$tbl.$added_params."&id='+this.value,'".$tbl."');\">";

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

 // Use packaged array data to create list

 if (is_array($dd_pack)){
    reset($dd_pack);

    $cnt = 0;

    while (list($key, $value) = each($dd_pack)){

          $title = $value[0];
          $image = $value[1];

          switch ($type){

           case 'checkbox':

            $label = $label."_key_".$key;

           break;

          }
          
          if ($current_value==$key){
             $checkimage = "<input type=\"".$type."\" name=\"".$label."\" id=\"".$label."\" value=\"".$key."\" checked><img src=\"".$image."\" width=50>";
             } else {
             $checkimage = "<input type=\"".$type."\" name=\"".$label."\" id=\"".$label."\" value=\"".$key."\"><img src=\"".$image."\" width=50>";
             }

          $checkimage = "<td style=\"width:50px;height:150;\">".$checkimage."<img src=images/blank.gif width=10 height=50></td>";

          if ($cnt < 6){
             $cnt++;
             }

          if ($cnt == 6){
             $checkimage = "<tr>".$checkimage."</tr>";
             $cnt = 0;
             }

          $drop_down_return .= $checkimage;


         } // end while

        } // end if array 

// $drop_down_return = "<div style=\"width:350px;min-height:150;overflow:auto;\">". $drop_down_return."</div>";

 $drop_down_return = "<table>". $drop_down_return."</table>";

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

 $drop_down_return = "<select id=$label name=$label onchange=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&valuetype=".$valtype."&value=".$val."&".$label."='+this.value);return false\">";


 // Use packaged array data to create list

 if (is_array($dd_pack)){
    reset($dd_pack);

    $drop_down_return .= "<option SELECTED id=NULL value=NULL>".$strings["action_select_request"];

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

 function dropdown ($action, $dd_pack, $current_value, $label, $object){

  global $BodyDIV,$portalcode,$val,$valtype,$do,$lingo,$strings;

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

     $drop_down_return = "<select id=$label name=$label>";

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

//           echo "Field: ".$name_field_lingo." = ".$name_data."<BR>";

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
 # Form Presentation

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

 ################################
 # Form Presentation
 
 function form_presentation ($valuepack){
  
  global $portalcode,$strings,$lingo,$BodyDIV,$portal_config;

  $header_color = $portal_config['portalconfig']['portal_header_color'];
  $body_color = $portal_config['portalconfig']['portal_body_color'];
  $footer_color = $portal_config['portalconfig']['portal_footer_color'];
  $border_color = $portal_config['portalconfig']['portal_border_color'];
  
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

     $next_action = $valuepack[6];

     }

  if (is_array($table_fields)){

   $form = "";

   ##########################
   # Actions

   $divwidth = 490;
#   $divwidth = "98%";
//   $divwidth = 450;
   $tdlabelwidth = 85;
   $tdvaluewidth = 350;
//   $tdvaluewidth = "88%";
   $textboxsize = 68;
   $textareacols = 20;
   $skinfont = "WHITE";

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
  $form_object $field_extras
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
<table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
  
    break; // end Add/Edit action
    #
    ############################
    # View List
    case 'view':
    
     $list_type = 'rows';
     
//     $form_header = "<table style=\"".$style_FormTable."\" width=\"98%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";
     $form_header = "<script type=\"text/javascript\">setVarsForm(\"do=".$do."&valtype=".$valtype."&val=".$primary_id.$edit_link_params."\");</script><table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

     $form = $this->fill_data($action,$next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params);
     
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

     $form = $this->fill_data($next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params);

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

        $the_button = $button_style."<div><button type=\"button\" name=\"button\" value=\"".$button_text."\" onclick=\"loader('".$BodyDIV."');get(this.form);return false\" class=\"css3button\">".$button_text."</div>"; 

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
 
  switch ($type){

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
    
     global $db;
     
     if ($selections == NULL){
        $selections = "*";
        }

     $reltablename = $thisvalue[1];
     $query = "SELECT $selections FROM $reltablename $query ";
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

 function fill_data ($action,$next_action,$valtype,$table_fields,$do,$list_type,$admin_status,$primary_id,$edit_link_params){

  global $portalcode,$strings,$portal_config,$BodyDIV,$skinfont;

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

      $fieldval = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$this_id."&valuetype=".$valtype.$edit_link_params."');return false\"><font color=red><B>".$strings["action_edit"].": ".$fieldval."</B></font></a>";

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
