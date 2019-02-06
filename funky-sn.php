<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-06-08
# Page: funky-sn.php 
##########################################################

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

  if (!function_exists('get_param')){
     include ("common.php");
     }

  if (!function_exists('api_sugar')){
     include ("api-sugarcrm.php");
     }

  if (!class_exists('funky')){
     include ("funky.php");
     $funky_gear = new funky ();   
     }

class funky_sn {

 #######################
 # SN Contacts

 function sn_contacts ($sn_params){

  global $BodyDIV,$funky_gear,$strings,$lingo,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$crm_api_user2,$crm_api_pass2,$crm_wsdl_url2,$auth,$sess_contact_id,$sess_account_id,$fb_session,$gg_session,$li_session,$portal_title,$portal_email,$portal_email_password,$portal_email_server,$portal_email_smtp_port,$portal_email_smtp_auth,$assigned_user_id,$hostname,$standard_statuses_closed,$divstyle_white,$divstyle_blue,$divstyle_grey;

  $do = $sn_params[0];
  $action = $sn_params[1];
  $valtype = $sn_params[2];
  $val = $sn_params[3];
  $extra_params = $sn_params[4];

  #var_dump($sn_params);

  # Social Network Connections | ID: 24ac8d1e-9a9a-4f88-98c9-55500353563d
  # Social Network Members | ID: 5f10a8e8-0520-5864-3674-55217c1f6a84
  # Social Network Strengths | ID: b93e2b07-a0da-c96a-42ce-5521dd1aa032
  # Social Networks | ID: 427feba6-efdd-414d-a1c1-55217c33f71a
  # Accounts | ID: 6898e8d5-e6b5-eda3-b1bc-55220a1b5037
    # 
  # Contacts | ID: 140cf7f9-fc5c-cb9c-2082-55220a924268
    # 
  # Events | ID: 4e4233fd-bd1b-cf45-8baa-55220aeeadea
    # Event Contacts | ID: f0bf777f-5346-d2e1-53c4-5551659b758d
  # Hiroko's Timer | ID: bca0aabe-0755-2cc8-f1fd-557538042d7d
    # Shared Timer Contacts | ID: 75fd626b-b544-a54e-6557-5575b50579c6
  # Lifestyle & State Categories | ID: 8be14b88-4b94-8325-ccd4-55220b6319d9
    # 
  # Products & Services | ID: 347e25e9-e3af-e3cc-e33c-55220ab84201
    # 
  # Projects | ID: 3058d2a4-2b0a-cc01-978a-55753c57facf
    # 
  # Tasks | ID: bee1b9f7-914a-756c-3b92-55753c54ad4c
    # 

  # There will be different types of connections based on the type of service
  # Events will have related/shared members - or just using email - depends on type of recipient

  switch ($do){

   case 'Accounts':

   break;
   case 'AccountsServices':

   break;
   case 'Contacts':

   break;
   case 'Events':
   case 'Effects':

    $rel_object_type_cit = 'f0bf777f-5346-d2e1-53c4-5551659b758d';

   break;
   case 'HirorinsTimer':

    $rel_object_type_cit = '75fd626b-b544-a54e-6557-5575b50579c6';

   break;
   case 'Lifestyles':

   break;
   case 'Projects':

   break;
   case 'ProjectTasks':

   break;
   case 'SocialNetworking':

    $rel_object_type_cit = '24ac8d1e-9a9a-4f88-98c9-55500353563d';

   break;

  } # end valtype switch

  # 
  ####################
  # Action

  switch ($action){

   # Listh the contacts based on the type
   case 'list':

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "sclm_configurationitemtypes_id_c='".$rel_object_type_cit."' && name='".$val."'";
    #$ci_params[0] = "name='".$val."'";
    $ci_params[1] = "id,name"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
    
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_wrapper_id = $ci_items[$cnt]['id'];

           } # for

       } # is array

    if ($ci_wrapper_id != NULL){

       #echo $ci_wrapper_id;

       # Gather any related items
       $ci_object_type = 'ConfigurationItems';
       $ci_object_action = "select";

       if ($auth == 3){
          $ci_object_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' "; # parent
          } elseif ($auth == 2) {
          $ci_object_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
          } else {
          $ci_object_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') "; # parent
          } 

       $ci_object_params[1] = "id,name,sclm_configurationitemtypes_id_c,account_id_c,contact_id_c,description"; // select array
       $ci_object_params[2] = ""; // group;
       $ci_object_params[3] = " name,date_entered DESC "; // order;
       $ci_object_params[4] = ""; // limit

       $ci_object_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_object_action, $ci_object_params);

       if (is_array($ci_object_items)){          

          for ($ci_object_cnt=0;$ci_object_cnt < count($ci_object_items);$ci_object_cnt++){

              $events_contact = "";

              $ci_object_id = $ci_object_items[$ci_object_cnt]['id'];
              $contact_info = $ci_object_items[$ci_object_cnt]['name'];
              $contact_type = $ci_object_items[$ci_object_cnt]['sclm_configurationitemtypes_id_c'];
              $account_id_c = $ci_object_items[$ci_object_cnt]['account_id_c'];
              $contact_id_c = $ci_object_items[$ci_object_cnt]['contact_id_c'];

              #echo $ci_object_id;

              # Contact Info can be email address or ID
              # Configuration Item Types: Messaging Systems

              switch ($contact_type){
  
               case '821d3058-e575-b6fa-c3bb-5559de9489ce': # Account Contacts

                $account_contacts = "";
                $account_contacts = explode (",",$contact_info);

                foreach ($account_contacts as $contact_key=>$contact_id){
  
                        $anon_params[0] = $contact_id; # Content owner
                        $anon_params[1] = ""; # account_owner
                        $anon_params[2] = $sess_contact_id; #contact_viewer
                        $anon_params[3] = $sess_account_id; #account_viewer
                        $anon_params[4] = $do;
                        $anon_params[5] = $valtype;
                        $anon_params[6] = $val;
                        $anon_params[7] = $contact_type;

                        $show_namer = $funky_gear->anonymity($anon_params);

                        if ($show_namer != NULL){
                           $show_name = $show_namer[0];
                           $show_description = $show_namer[1];
                           $profile_photo = $show_namer[2];
                           $contact_profile = $show_namer[3];

                           $object_contacts .= $contact_profile;

                           } # if not null

                        } # foreach

               break;
               case 'd8ba0615-94b3-78a5-51e4-5559de992b1c': # Email Contacts

                # Search the contact list for this email to make new connection
                $object_contacts = "";
                $contact_email = "";
                $rego_params = "";

                $email_contacts = explode (",",$contact_info);

                foreach ($email_contacts as $contact_key=>$contact_email){

                        if ($contact_email != NULL){

                           $rego_object_type = "Contacts";
                           $rego_action = "contact_by_email";
                           $rego_params = $contact_email; # query

                           $existing_contact_id = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $rego_object_type, $rego_action, $rego_params);

                           #echo "Exists: $existing_contact_id <BR>";

                           if ($existing_contact_id != NULL){

                              # Get Anonymity
                              $anon_params[0] = $existing_contact_id; # Content owner
                              $anon_params[1] = ""; # account_owner
                              $anon_params[2] = $sess_contact_id; #contact_viewer
                              $anon_params[3] = $sess_account_id; #account_viewer
                              $anon_params[4] = $do;
                              $anon_params[5] = $valtype;
                              $anon_params[6] = $val;
                              $anon_params[7] = $contact_type;

                              $show_namer = $funky_gear->anonymity($anon_params);

                              if ($show_namer != NULL){

                                 $show_name = $show_namer[0];
                                 $show_description = $show_namer[1];
                                 $profile_photo = $show_namer[2];
                                 $contact_profile = $show_namer[3];

                                 $object_contacts .= "<div style=\"".$divstyle_white."\"><B>Contact Email: ".$contact_email."</B></div>";
                                 $object_contacts .= $contact_profile;

                                 #echo "contact_profile: $contact_profile <BR>";
                                 } else {
                                 # if null
                                 $object_contacts .= "";
                                 } 

                              } else {

                              $object_contacts .= "<div style=\"".$divstyle_white."\"><B>".$contact_email."</B> is not currently a ".$portal_title." member.</div>";

                              } 

                           } else {

                           $object_contacts .= "";

                           } 

                        } # foreach

               break;
               case '2e465f2e-57db-e22d-0b7c-5559e0aaeeaf': #  Facebook Contacts

                $object_contacts = $contact_info;

               break;
               case '54cf2e2f-a525-85d0-ceff-5559e04f44f2': #  Google Contacts

                $object_contacts = "";
                $contact_email = "";
                $rego_params = "";

                $email_contacts = explode (",",$contact_info);

                foreach ($email_contacts as $contact_key=>$contact_email){
  
                        if ($contact_email != NULL){

                           $rego_object_type = "Contacts";
                           $rego_action = "contact_by_email";
                           $rego_params = $contact_email; # query

                           $existing_contact_id = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $rego_object_type, $rego_action, $rego_params);

                           #echo "Exists: $existing_contact_id <BR>";

                           if ($existing_contact_id != NULL){
                              # Get Anonymity

                              $anon_params[0] = $existing_contact_id; # Content owner
                              $anon_params[1] = ""; # account_owner
                              $anon_params[2] = $sess_contact_id; #contact_viewer
                              $anon_params[3] = $sess_account_id; #account_viewer
                              $anon_params[4] = $do;
                              $anon_params[5] = $valtype;
                              $anon_params[6] = $val;
                              $anon_params[7] = $contact_type;

                              $show_namer = $funky_gear->anonymity($anon_params);

                              if ($show_namer != NULL){

                                 $show_name = $show_namer[0];
                                 $show_description = $show_namer[1];
                                 $profile_photo = $show_namer[2];
                                 $contact_profile = $show_namer[3];

                                 $object_contacts .= "<div style=\"".$divstyle_white."\"><B>Contact Email: ".$contact_email."</B></div>";
                                 $object_contacts .= $contact_profile;

                                 #echo "contact_profile: $contact_profile <BR>";

                                 } else {
                                 # if null
                                 $object_contacts .= "";
                                 } 

                              } else {

                              $object_contacts .= "<div style=\"".$divstyle_white."\"><B>".$contact_email."</B> is not currently a ".$portal_title." member.</div>";

                              } 

                           } else {

                           $object_contacts .= "";

                           } 

                        } # foreach

               break;
               case '18a8e733-f0e1-32a2-d5b3-5559e087dffb': #  LinkedIn Contacts

                $object_contacts = $contact_info;

               break;
               case '33485c3e-4814-12a5-5a38-5559e204e411': #  Social Networks

                # Sharing events directly to the Social Networks in lifestyle categories
                $object_contacts = $contact_info;

               break;
               case '7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e': #  Shared Effects Personal Social Network Contacts

                # Connections that have been made directly with other members in the system

                $account_contacts = "";
                $account_contacts = explode (",",$contact_info);

                foreach ($account_contacts as $contact_key=>$contact_id){

                        $anon_params[0] = $contact_id; # Content owner
                        $anon_params[1] = ""; # account_owner
                        $anon_params[2] = $sess_contact_id; #contact_viewer
                        $anon_params[3] = $sess_account_id; #account_viewer
                        $anon_params[4] = $do;
                        $anon_params[5] = $valtype;
                        $anon_params[6] = $val;
                        $anon_params[7] = $contact_type;

                        $show_namer = $funky_gear->anonymity($anon_params);

                        if ($show_namer != NULL){
                           $show_name = $show_namer[0];
                           $show_description = $show_namer[1];
                           $profile_photo = $show_namer[2];
                           $contact_profile = $show_namer[3];
                           #$anonymity_names = $show_namer[4]; 

                           $object_contacts .= $contact_profile;

                           } # if not null

                       } # foreach

               break;

              } # contact_description

              $edit = "";
              if ($sess_contact_id != NULL && $contact_id_c == $sess_contact_id || $auth==3){

                 $edit ="<a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=relate_contacts_edit&value=".$ci_object_id."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red><B>[".$strings["action_edit"]."]</B></font></a>";

                 } 

              $rel_contacts .= "<div style=\"".$divstyle_white."\"><img src=images/icons/i_users.gif width=16 border=0 alt=".$object_name."> ".$edit."<BR>".$object_contacts."</div>";

              } # for

          $rel_contacts .= "<div style=\"".$divstyle_blue."\"><a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=relate_contacts_add&value=".$ci_wrapper_id."&valuetype=Wrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=blue><B>[".$strings["action_addnew"]."]</B></font></a></div>";

          } else {# is array

          $rel_contacts = "<div style=\"".$divstyle_white."\">There are no people connected to this yet.<BR><a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=relate_contacts_add&value=".$ci_wrapper_id."&valuetype=Wrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=blue><B>[".$strings["action_addnew"]."]</B></font></a></div>";
  
          }

       } else {# is ci_wrapper_id

       $rel_contacts = "<div style=\"".$divstyle_white."\">There are no people connected to this yet.<BR><a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=relate_contacts_add&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=blue><B>[".$strings["action_addnew"]."]</B></font></a></div>";

       } 

    $returnpack[0] = $rel_contacts;

   break; # list
   case 'shared':

    # Check by ID or email
    $conmail_object_type = 'Contacts';
    $conmail_action = "select_soap";
    $conmail_params[0] = "contacts.id='".$val."'";
    $conmail_params[1] = "email1"; // select array
    $conmail_params[2] = ""; // group;
    $conmail_params[3] = ""; // order;
    $conmail_params[4] = ""; // limit
    
    $conmail_items = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $conmail_object_type, $conmail_action, $conmail_params);

    if (is_array($conmail_items)){          

       for ($conmailcnt=0;$conmailcnt < count($conmail_items);$conmailcnt++){

           $email1 = $conmail_items[$conmailcnt]['email1'];
	
           } # for

       } # is array

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";

    if ($email1 != NULL){
       #$ci_params[0] = "sclm_configurationitemtypes_id_c='".$rel_object_type_cit."' && (name like '%".$val."%' OR name like '%".$email1."%' ) && contact_id_c != '".$val."'";
       $ci_params[0] = "(name like '%".$val."%' OR name like '%".$email1."%' ) && contact_id_c != '".$val."'";

       } else {
       #$ci_params[0] = "sclm_configurationitemtypes_id_c='".$rel_object_type_cit."' && name like'%".$val."%' && contact_id_c != '".$val."'";
       $ci_params[0] = "name like '%".$val."%' && contact_id_c != '".$val."'";
       }

    #echo $ci_params[0];

    $ci_params[1] = "id,name,contact_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
    
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_wrapper_id = $ci_items[$cnt]['id'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];

           $anon_params[0] = $contact_id_c; # Content owner
           $anon_params[1] = ""; # account_owner
           $anon_params[2] = $sess_contact_id; #contact_viewer
           $anon_params[3] = $sess_account_id; #account_viewer
           $anon_params[4] = $do;
           $anon_params[5] = $valtype;
           $anon_params[6] = $val;
           $anon_params[7] = ""; #$contact_type;
           $show_namer = $funky_gear->anonymity($anon_params);

           if ($show_namer != NULL){
              $show_name = $show_namer[0];
              $rel_contacts .= "<div style=\"".$divstyle_white."\"><a href=\"\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=HirorinsTimer&action=view&value=".$contact_id_c."&valuetype=HirorinsTimer&sendiv=".$BodyDIV."');return false\"><font color=blue><B>View ".$show_name." Hirorin Timer</B></font></a></div>";

              } # show_namer

           } # for

       } # is array

    $returnpack[0] = $rel_contacts;

   break; # shared

   #
   ##########################

   } # switch

   return $returnpack;

  # Return Pack
  #############################

 } # end function sn_contacts

} # end class funky_sn

# end
##########################################################
?>