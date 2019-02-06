<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Contacts.php 
##########################################################
# case 'Contacts':

  $this_module = '2abc3625-4ee1-78ed-42a8-52b4f5e1f7c0';
  $security_params[0] = $this_module;
  $security_params[1] = $lingo;
  $security_params[2] = $sess_contact_id;
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

  #echo "$role_AccountAdministrator = $security_role";

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
    $sec_params[0] .= "deleted=0 && account_id_c = '".$_SESSION['account_id']."' ";
   break;

  } // end system_action_list

  switch ($valtype){

  

  }

  switch ($action){

   case 'list':
   
    echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_color."><B>".$strings["Contacts"]."</B></font></center></div>";
    echo "<center><img src=images/icons/MyContacts-128x128.png alt='".$strings["Contacts"]."'></center>";

    switch ($valtype){

     case 'Accounts':

      $contact_object_type = "Accounts";
      $contact_action = "select_contacts";
      $contact_params = array();

      if ($sec_params[0]){
         $contact_params[0] = $sec_params[0]." && deleted=0 && account_id='".$val."' ";
         } else {
         $contact_params[0] = "deleted=0 && account_id='".$val."' ";
         }
      $check_acc_admin_object_type = "Accounts";
      $check_acc_admin_action = "select_cstm";
      $check_acc_admin_params = array();
      $check_acc_admin_params[0] = " contact_id_c='".$sess_contact_id."' && id_c='".$val."'  ";
      $check_acc_admin_params[1] = "*";
      $check_acc_admin_params[2] = "";
      $check_acc_admin_params[3] = "";
      $check_acc_admin_params[4] = "";
 
      $check_acc_admin_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_acc_admin_object_type, $check_acc_admin_action, $check_acc_admin_params);

      if (is_array($check_acc_admin_list)){

         for ($cnt=0;$cnt < count($check_acc_admin_list);$cnt++){
             $account_id = $check_acc_admin_list[$cnt]['id_c'];
             }

         if ($account_id != NULL && $account_id == $val){ 
            $is_admin = TRUE;

            }
         }

     break;
     case 'Messages':

      $contact_object_type = 'Messages';
      $contact_action = "select";
      $contact_params[0] =  $sec_params[0]." && (account_id_c='".$account_id_c."' || account_id1_c='".$account_id_c."') ";
      $contact_params[1] = ""; // select array
      $contact_params[2] = ""; // group;
      $contact_params[3] = ""; // order;
      $contact_params[4] = ""; // limit
  
//      $mess = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mess_object_type, $mess_action, $mess_params);

      break;

   } // end switch

//    $contact_params[0] = " (cmv_statuses_id_c = 'cf7e4020-cff4-81bf-1d88-4d48ffa7497b') || (cmv_statuses_id_c = 'dfc905da-7434-7375-86fd-4d48ff743f78') ";
//      $accparams[0] = "";
  
    if ($valtype == 'Block'){

       echo "<img src=images/blank.gif width=100 height=10><BR>";

       $contact_params[1] = "*";
       $contact_params[2] = "";
       $contact_params[3] = " date_modified DESC ";
       $contact_params[4] = " 10 ";
       $contentmax = 5;
       $blockwidth = 190;
       $marginleft = "3%";
       $marginright = "3%";

       } else { // valtype

       echo $object_return;
       #echo "<img src=images/blank.gif width=98% height=10><BR>";

       $contentmax = 20;
       $blockwidth = 190;
       $marginleft = "3%";
       $marginright = "3%";
       $contact_params[1] = "*";
       $contact_params[2] = "";
       $contact_params[3] = " date_modified DESC ";
       $contact_params[4] = "50";

       } 
/*
    if ($valtype == 'Search'){
       $contact_params[0] .= " && (name like '%".$val."%' || description like '%".$val."%') ";
       }
*/    
    $contacts_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);

    if (is_array($contacts_list)){

       $count = count($items_list);
       $page = $_POST['page'];
       $glb_perpage_items = $contentmax;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       if ($valtype != 'Block'){
          echo $navi;
          }

       $contact_params[1] = "*";
       $contact_params[2] = "";
       $contact_params[3] = " date_modified DESC ";
       $contact_params[4] = " $lfrom , $glb_perpage_items ";
 
       $contacts_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
       for ($cnt=0;$cnt < count($contacts_list);$cnt++){

           $contact_id = $contacts_list[$cnt]['contact_id'];
           $first_name = $contacts_list[$cnt]['first_name'];
           $last_name = $contacts_list[$cnt]['last_name'];
           $date_modified = $contacts_list[$cnt]['date_modified'];

/*
           $contacts_cstm_object_type = "Contacts";
           $contacts_cstm_action = "select_cstm";
           $contacts_cstm_params[0] = "id_c='".$contact_id."' ";
           $contacts_cstm_params[1] = ""; // select
           $contacts_cstm_params[2] = ""; // group;
           $contacts_cstm_params[3] = ""; // order;
           $contacts_cstm_params[4] = ""; // limit

           $contacts_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $contacts_cstm_object_type, $contacts_cstm_action, $contacts_cstm_params);

           if (is_array($contacts_cstm_info)){
      
              for ($cstm_cnt=0;$cstm_cnt < count($contacts_cstm_info);$cstm_cnt++){

                  $twitter_name_c = $contacts_cstm_info[$cstm_cnt]['twitter_name_c'];
                  $linkedin_name_c = $contacts_cstm_info[$cstm_cnt]['linkedin_name_c'];
                  $nickname_c = $contacts_cstm_info[$cstm_cnt]['nickname_c']; // Administrator

                  } // for

              } // if array
*/
           // Check Admin for Edit
           if (($sess_contact_id == $contact_id && $sess_contact_id != NULL) || $auth==3 || $is_admin==TRUE || $role_AccountAdministrator == $security_role){
     
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$contact_id."&valuetype=".$valtype."');return false\"><font color=RED><B> [".$strings["action_edit"]."] </B></font></a>";

              } else {// end if admin
              $edit = "";
              } 

            $sendmessage = "";
            $sendmessage = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$contact_id."&valuetype=Contacts&sendiv=lightform&related=".$valtype."&relval=".$val."');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'>".$agent_name."</a> ";

           // View
           if ($cmn_countries_id_c){
              $country = $funky_gear->makecountry ($cmn_countries_id_c,$portalcode,$BodyDIV,$lingo);
              } else {
              $country = "";
              }

           $this_contact = $country." ".$edit."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$contact_id."&valuetype=".$do."');return false\"><font color=#151B54>".$first_name." ".$last_name."</font></a> ".$sendmessage."<BR>";

           $contacts .= "<div style=\"".$divstyle_white."\">".$this_contact."</div>";
      
           } // end for
      
       } else { // end if array

         $contacts = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }  
    
    if ($sess_contact_id != NULL && $is_admin==TRUE){
     
       $add_contact = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
     
       } else {
      
       $add_contact = "<div style=\"".$divstyle_white."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }
     
    # Provide Google Contacts Import as new members
    # echo "<div style=\"".$divstyle_white."\"><a style=\"font-size:25px;font-weight:bold;\" href=\"https://accounts.google.com/o/oauth2/auth?client_id=635529415363.apps.googleusercontent.com&redirect_uri=http://localhost/gmail/oauth2callback.php&scope=https://www.google.com/m8/feeds/&response_type=php\"><strong>Click here to Import Gmail Contacts</strong></a></div>";

 
    if (count($items_list)>10){
       echo "<P>".$add_contact."<P>".$contacts."<P>".$add_contact;
//       echo $items;
       } else {
       echo "<P>".$add_contact.$contacts;
//       echo $items;
       }

       if ($valtype != 'Block'){
          echo $navi;
          }

    $this->funkydone ($_POST,$lingo,'AccountRelationships','list',$sess_account_id,$do,$bodywidth);

   break;
   case 'add':
   case 'edit':

   ############################################
   # Contact info via SOAP

    echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["Dashboard"]."</B></font></center></div>";   

    echo "<center><img src=images/icons/MyContacts-128x128.png alt='".$strings["Contacts"]."'></center>";

    $contact_object_type = 'Contacts';
    $contact_action = 'select_cstm';
   
    $contact_params = array();

    #$contact_params[1] =  "id_c,password_c,twitter_name_c,twitter_password_c,linkedin_name_c,nickname_c,cloakname_c,profile_photo_c,role_c";
    $contact_params[1] = ""; 

    if ($action == 'edit'){
   
       if ($val != NULL){
          $contact_params[0] = "id_c='".$val."'";
          } else {
          $contact_params[0] = "id_c='".$sess_contact_id."'";
          }

       $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $contact_object_type, $contact_action, $contact_params);

       }

    ############################################
    # Contact

    echo $this->funkydone ($_POST,$lingo,'ConfigurationItemSets','view',$sess_contact_id,'PersonalSet',$bodywidth);

    # Contact
    ############################################
    # Facebook

    if ($allow_fb_rego == TRUE){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";
    
       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = "Facebook Details".$headerpic; // container_title
       $container_params[4] = "FacebookDetails"; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);
  
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       if ($fb_session != NULL){

          require_once ("api-facebook.php");

          $fb_params[0] = "return_permissions"; #fb_action;
          $fb_params[1] = $fb_session; # userid

          $fbpermissions = do_facebook ($fb_params);

          foreach ($fbpermissions as $key=>$value) {

                  $permission = $value['permission'];
                  $status = $value['status'];
                  $showperms .= "<div style=\"".$divstyle_white."\"><B>Permission:</B> ".$permission." [".$status."]</div>";

                  } # foreach 1
   
          $facebook .= "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Facebook Permissions</B></font></center></div>";
          $facebook .= "<div style='width: 98%; max-height:200px;overflow:scroll; padding: 0.5em; resize: both;'>".$showperms."</div>";

          # Get events to allow for conversion into Shared Effects
          $fb_params[0] = "return_events"; #fb_action;
          $fb_params[1] = $fb_session; # userid

          $fbevents = do_facebook ($fb_params);

          $fbevents_list = $fbevents['data'];

          for ($event_cnt=0;$event_cnt < count($fbevents_list);$event_cnt++){

              $fbevent_start_time = $fbevents_list[$event_cnt]['start_time'];
              $fbevent_end_time = $fbevents_list[$event_cnt]['end_time'];
              $fbevent_location = $fbevents_list[$event_cnt]['location'];
              $fbevent_name = $fbevents_list[$event_cnt]['name'];
              $fbevent_timezone = $fbevents_list[$event_cnt]['timezone'];
              $fbevent_id = $fbevents_list[$event_cnt]['id'];
              $fbevent_rsvp_status = $fbevents_list[$event_cnt]['rsvp_status'];

              #list ($start_datepart,$start_timepart) = explode ("T", $fbevent_start_time);
              #list ($start_time,$start_timezone) = explode ("+", $start_timepart);
              #list ($end_datepart,$end_timepart) = explode ("T", $fbevent_end_time);
              #list ($end_time,$end_timezone) = explode ("+", $end_timepart);
              #$map_location = str_replace(" ", "+", $fbevent_location);
              #$map_location = "http://www.google.co.jp/maps/place/".$map_location;
              #<textarea id=\"embedLink\" name=\"embedLink\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$map_location."</textarea>";


              # Check if the FB event already exists
              $fbeventwrap_object_type = "ConfigurationItems";
              $fbeventwrap_action = "select";
              $fbeventwrap_params[0] = " name='".$fbevent_id."' ";
              $fbeventwrap_params[1] = "name,sclm_configurationitems_id_c"; // select array
              $fbeventwrap_params[2] = ""; // group;
              $fbeventwrap_params[3] = ""; // order;
              $fbeventwrap_params[4] = ""; // limit

              $fbeventwrap_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbeventwrap_object_type, $fbeventwrap_action, $fbeventwrap_params);

              if (is_array($fbeventwrap_items)){    

                 for ($fbwrapeventcnt=0;$fbwrapeventcnt < count($fbeventwrap_items);$fbwrapeventcnt++){

                     # The Parent CI contains the event ID in the name field
                     $parci_id = $fbeventwrap_items[$fbwrapeventcnt]['sclm_configurationitems_id_c'];

                     # Get the event id from the name field
                     $fbevent_object_type = "ConfigurationItems";
                     $fbevent_action = "select";
                     $fbevent_params[0] = "id='".$parci_id."' ";
                     $fbevent_params[1] = "name"; // select array
                     $fbevent_params[2] = ""; // group;
                     $fbevent_params[3] = ""; // order;
                     $fbevent_params[4] = ""; // limit

                     $fbevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbevent_object_type, $fbevent_action, $fbevent_params);

                     if (is_array($fbevent_items)){    

                        for ($fbeventcnt=0;$fbeventcnt < count($fbevent_items);$fbeventcnt++){

                            # The event ID is in the name field
                            $event_id = $fbevent_items[$fbeventcnt]['name'];
                            $fb_event_returner = $funky_gear->object_returner ("Effects", $event_id);
                            $fb_event_name = $fb_event_returner[0];

                            $fbevent .= "<div style=\"".$divstyle_white."\">Registered in Shared Effects: <a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$event_id."&valuetype=Facebook&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red><B>".$fb_event_name."</B></font></a></div>";

                            } # for

                        } # is array

                     } # for

                 } else {# is array

                 $fbevent .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$fbevent_id."&valuetype=Facebook&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red><B>Create Shared Effect Event</B></font></a> from ".$fbevent_name. " [Start Date/Time: ".$start_datepart."/".$start_time." End Date/Time: ".$end_datepart."/".$end_time."  @ ".$fbevent_location." in ".$fbevent_timezone.". Attendance: ".$fbevent_rsvp_status."</div>";

                 } # if not registered

              } # end return events

          $facebook .= "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Facebook Events</B></font></center></div>";
          $facebook .= "<div style=\"".$divstyle_orange_light."\">Select an event to create a Shared Effect event</div>";
          $facebook .= "<div style='width: 98%; max-height:300px;overflow:scroll; padding: 0.5em; resize: both;'>".$fbevent."</div>";

          # Get UserÅfs Profile Picture
          $fb_params[0] = "return_picture"; #fb_action;
          $fb_params[1] = $fb_session; # userid

          $fbpicturedata = do_facebook ($fb_params);
   
          $fb_pic_silhouette = $fbpicturedata['is_silhouette'];
          $fb_pic_url = $fbpicturedata['url'];

          if ($fb_pic_url){
             $headerpic = "<BR><img src=".$fb_pic_url." width = 150>";
             }

          ################################
          # Adjust the container for the pic

          $container_params[3] = "Facebook Details".$headerpic; // container_title
          $container = $funky_gear->make_container ($container_params);
  
          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];

          $dashboard .= $container_top;

          $dashboard .= "<div style=\"".$divstyle_white."\">".$facebook."</div>";       

          $dashboard .= $container_bottom;

          # End Content
          ################################

          } else { # end FB sess

          ################################
          # Not logged in

          $dashboard .= $container_top;
          # Allow to sync using some other account that already logged-in with
          $facebook = "<div style=\"".$divstyle_orange_light."\">You are currently not logged-in with Facebook, but you can click below to synchronise the accounts. This will enable you to see your events, make posts of Shared Effects to Facebook and various other handy actions.</div>";

          $facebook .=  "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb_connect_form\" id=\"fb_connect_form\" value=\"Synchronise Facebook\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','api-facebook.php','action=login&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></div>";       

          $dashboard .= "<div style=\"".$divstyle_white."\">".$facebook."</div>";       

          $dashboard .= $container_bottom;

          } #if not logged-in

       } # if FB allowed

    # Facebook
    ############################################
    # LinkedIn

    if ($allow_linkedin_rego == TRUE){

       $container_params[3] = "LinkedIn Details"; // container_title
       $container_params[4] = "LinkedInDetails"; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);
  
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       if ($li_session != NULL){

          require_once ("api-linkedin.php");
 
          $li_params[0] = "get_info"; #
          $li_params[1] = $li_session; # use

          $li_info = do_linkedin ($li_params);

          $li_userid = $li_info['id'];
          $first_name = $li_info['first-name'];
          $last_name = $li_info['last-name'];
          $email = $li_info['email-address'];
          $headline = $li_info['headline'];
          $li_picture_url = $li_info['picture-url'];

          if ($li_picture_url){
             $headerpic = "<BR><img src=".$li_picture_url." width = 150>";
             }

          $container_params[3] = "LinkedIn Details".$headerpic; // container_title

          $container = $funky_gear->make_container ($container_params);
  
          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];

          $dashboard .= $container_top;

          #$linkedin = "<img src=".$li_picture_url." width=150><P>";
          $linkedin .= "<B>LinkedIn User ID:</B> ".$li_userid."<BR>";
          $linkedin .= "<B>First Name:</B> ".$first_name."<BR>";
          $linkedin .= "<B>Last Name:</B> ".$last_name."<BR>";
          $linkedin .= "<B>Email:</B> ".$email."<BR>";
          $linkedin .= "<B>Headline:</B> ".$headline."<BR>";

          $dashboard .= "<div style=\"".$divstyle_white."\">".$linkedin."</div>";       
   
          $dashboard .= $container_bottom;

          } else {

          $dashboard .= $container_top;
          # Allow to sync using some other account that already logged-in with
          $linkedin = "<div style=\"".$divstyle_orange_light."\">You are currently not logged-in with LinkedIn, but you can click below to synchronise the accounts. This will enable you to see your posts, connections and make posts of Shared Effects to LinkedIn and various other handy actions.</div>";
          $linkedin .=  "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"li_connect_form\" id=\"li_connect_form\" value=\"Synchronise LinkedIn\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','api-linkedin.php','action=login&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></div>";       

          $dashboard .= "<div style=\"".$divstyle_white."\">".$linkedin."</div>";       

          $dashboard .= $container_bottom;

          } # if not logged-in

       } # allow LI

    # LinkedIn
    ############################################
    # Google

    if ($allow_google_rego == TRUE){

       $container_params[3] = "Google Details"; // container_title
       $container_params[4] = "GoogleDetails"; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);
  
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       if ($gg_session != NULL){

          require_once ("api-google.php");

          $gg_params[0] = "get_info"; #gg_action;
          $gg_params[1] = $gg_session; # userid

          $google_info = do_google ($gg_params);

          $gg_userid = $google_info[3]['userid'];
          $gg_user_name = $google_info[3]['name'];
          $gg_first_name = $google_info[3]['first_name'];
          $gg_last_name = $google_info[3]['last_name'];
          $gg_email = $google_info[3]['email'];
          $gg_gender = $google_info[3]['gender'];
          $gg_link = $google_info[3]['link'];
          $gg_picture = $google_info[3]['picture'];

          if ($gg_picture){
             $headerpic = "<BR><img src=".$gg_picture." width = 150>";
             }

          $container_params[3] = "Google Details".$headerpic; // container_title

          $container = $funky_gear->make_container ($container_params);
  
          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];

          $dashboard .= $container_top;

          #$google .= "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Google Info</B></font></center></div>";
          #$google .= "<img src=".$gg_picture." width=150><P>";
          $google .= "<B>Google User ID:</B> ".$gg_userid."<BR>";
          $google .= "<B>First Name:</B> ".$gg_first_name."<BR>";
          $google .= "<B>Last Name:</B> ".$gg_last_name."<BR>";
          $google .= "<B>Email:</B> ".$gg_email."<BR>";
          $google .= "<B>Gender:</B> ".$gg_gender."<BR>";
          $google .= "<B>Link:</B> ".$gg_link."<BR>";

          $gg_params[0] = "get_cal_list"; #gg_action;
          $gg_params[1] = $gg_session; # userid

          $google_cals = do_google ($gg_params);

          if (is_array($google_cals)){

             for ($cnt=0;$cnt < count($google_cals);$cnt++){
 
                 $id = $google_cals[$cnt]['id'];
                 $etag = $google_cals[$cnt]['etag'];
                 $timeZone = $google_cals[$cnt]['timeZone'];
                 $location = $google_cals[$cnt]['location'];
                 $colorId = $google_cals[$cnt]['colorId'];
                 $backgroundColor = $google_cals[$cnt]['backgroundColor'];
                 $foregroundColor = $google_cals[$cnt]['foregroundColor'];
                 $accessRole = $google_cals[$cnt]['accessRole'];
                 $description = $google_cals[$cnt]['description'];
                 $summary = $google_cals[$cnt]['summary'];

                 $cals .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Google&action=view_calendar&value=".$id."&valuetype=Google&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$summary."</B> (".$timeZone.")</font></a> [".$id."]</div><P>";

                 } # for

             } # is array

          $google .= "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Google Calendars</B></font></center></div>";
          $google .= "<div style=\"".$divstyle_orange_light."\">Select a Calendar's event to create a Shared Effect event</div>";
          $google .= "<div style='width: 98%; max-height:300px;overflow:scroll; padding: 0.5em; resize: both;'>".$cals."</div>";
          $dashboard .= "<div style=\"".$divstyle_white."\">".$google."</div>";      

          #echo $this->funkydone ($_POST,$lingo,'Google','list_calenders',$gg_session,'Contacts',$bodywidth);

          $dashboard .= $container_bottom;

          } else {

          $dashboard .= $container_top;

          # Allow to sync using some other account that already logged-in with
          $google = "<div style=\"".$divstyle_orange_light."\">You are currently not logged-in with Google, but you can click below to synchronise the accounts. This will enable you to see your posts, connections and make posts of Shared Effects to Google and various other handy actions.</div>";

          $google .=  "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"gg_connect_form\" id=\"gg_connect_form\" value=\"Synchronise Google\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','api-google.php','action=login&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center></div>";       

          $dashboard .= "<div style=\"".$divstyle_white."\">".$google."</div>";       

          $dashboard .= $container_bottom;

          } 

       } # if allow G

    # Google
    ############################################
    # Dashboard

   # $dashboard = "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Dashboard</B></font></center></div>";

    #$char_strength_cit = "7c726fb7-2947-6d40-734a-54ea110fd7e9"; # Character Strengths
 
    $ci_object_type = "ConfigurationItemTypes";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && id='".$char_strength_cit."' ";
    $ci_params[1] = "id,name,description"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    #$ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    #if (is_array($ci_items)){

     #  for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
      #     $charstrengths_id = $ci_items[$cnt]['id'];
        #   $charstrengths_title = $ci_items[$cnt]['name'];
       #    $charstrengths_description = $ci_items[$cnt]['description'];

         #  } # for

#       } # for

 #   $charstrengths_description = str_replace("\n", "<br>", $charstrengths_description);

  #  $viewall = "<a href=\"#\" onClick=\"loader('strengths');doBPOSTRequest('strengths','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=list&value=".$sess_contact_id."&valuetype=CharacterStrengths&sendiv=strengths');return false\"><font color=BLUE><B>Manage Character Strengths</B></font></a> <a href=\"#\" onClick=\"loader('strengths');doBPOSTRequest('strengths','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=listvals&value=".$sess_contact_id."&valuetype=CharacterStrengths&sendiv=strengths');return false\"><font color=BLUE><B>List Strengths</B></font></a>";

   # $charstrengths = "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"Manage Wellbeing\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php','do=Wellbeing&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=lightfull');return false\"></center></div>";

    #$charstrengths .= "<div style=\"".$divstyle_blue."\"><center>".$viewall."<BR>Lower VIA scores represent your strongest areas...</div>";
    #$charstrengths .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
    #$charstrengths .= $charstrengths_description;
    #$charstrengths .= "</div>";

       ################################
       # Start Content
    
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";
    
       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $charstrengths_title; // container_title
       $container_params[4] = "CharacterStrengths"; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       #$container = $funky_gear->make_container ($container_params);
  
       #$container_top = $container[0];
       #$container_middle = $container[1];
       #$container_bottom = $container[2];

       #$dashboard .= $container_top;

       #$dashboard .= "<div style='width: 98%; max-height:500px;overflow:scroll; padding: 0.5em; resize: both;'>".$charstrengths."</div>";

       #$dashboard .= $container_bottom;

       # End Content
       ################################

    echo $dashboard;

    # Dashboard
    ############################################
    # Show Contac Info

    //$the_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
    //var_dump($the_list);
    
    if (is_array($the_list)){
      
     for ($cnt=0;$cnt < count($the_list);$cnt++){

      $password_c = $the_list[$cnt]['password_c'];
      $twitter_name_c = $the_list[$cnt]['twitter_name_c'];
      $twitter_password_c = $the_list[$cnt]['twitter_password_c'];
      $linkedin_name_c = $the_list[$cnt]['linkedin_name_c'];
      $nickname_c = $the_list[$cnt]['nickname_c'];
      $cloakname_c = $the_list[$cnt]['cloakname_c'];
      $profile_photo_c = $the_list[$cnt]['profile_photo_c'];
      $role_c = $the_list[$cnt]['role_c'];
      $social_network_name_type_c = $the_list[$cnt]['social_network_name_type_c'];
      $default_name_type_c = $the_list[$cnt]['default_name_type_c'];
      $friends_name_type_c = $the_list[$cnt]['friends_name_type_c'];
      $cmn_countries_id_c = $the_list[$cnt]['cmn_countries_id_c'];
      $cmn_languages_id_c = $the_list[$cnt]['cmn_languages_id_c'];

      } // end for
      
    } // end if array

    if (!$profile_photo_c){
       $profile_photo_c = $fb_pic_url;
       } elseif (!$fb_pic_url){
       $profile_photo_c = $li_picture_url;
       } elseif (!$li_picture_url){
       $profile_photo_c = $gg_picture;
       }
/*
    $contact_object_type = 'ContactProfiles';
    $contact_action = 'select';
    
    $contact_params = array();
    $contact_params[0] = "contact_id_c='".$sess_contact_id."'";
    $contact_params[1] =  "*";

    if ($action == 'edit'){
       $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $contact_object_type, $contact_action, $contact_params);
       }

    if (is_array($the_list)){
      
     for ($cnt=0;$cnt < count($the_list);$cnt++){



         }
       }
*/

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "id"; // Field Name
    $tablefields[$tblcnt][1] = "Contact ID"; // Full Name
    $tablefields[$tblcnt][2] = 1; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '0';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;

    if ($action == 'edit'){
       if ($val != NULL){
          $tablefields[$tblcnt][21] = $val;
          } else {
          $tablefields[$tblcnt][21] = $sess_contact_id; //$_SESSION['sess_contact_id']; 
          }

       $accid_object_type = "Contacts";
       $accid_action = "get_account_id";
       $accid_params[0] = $tablefields[$tblcnt][21];
       $accid_params[1] = "account_id";
       $account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);
       } else {
       $tablefields[$tblcnt][21] = ""; //$_SESSION['sess_contact_id']; 
       }
  
    $tblcnt++;

    $tablefields[$tblcnt][0] = "account_id"; // Field Name
    $tablefields[$tblcnt][1] = "Account ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '0';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "account_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $account_id_c; //$_SESSION['sess_contact_id']; 

/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = "contact_profile_id"; // Field Name
    $tablefields[$tblcnt][1] = "Contact Profile ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '0';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "contact_profile_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $contact_profile_id; //$_SESSION['sess_contact_id']; 
*/

    if ($valtype == 'update_using_fb') {

       $userid = $fbme[id];
       $name = $fbme[name];
       $first_name = $fbme[first_name];
       $last_name = $fbme[last_name];
       $link = $fbme[link];
       $hometown = $fbme[hometown];
       $hometown_id = $hometown[id];
       $hometown_name = $hometown[name];
       $gender = $fbme[gender];
       $email = $fbme[email];
       $timezone = $fbme[timezone];
       $locale = $fbme[locale];
       $verified = $fbme[verified];
       $updated_time = $fbme[updated_time];

       } else {

       // Get Contact info
       
       $object_type = "Contacts";
       $api_action = "select_soap";
       $params = array();

       if ($action == 'edit'){
          if ($val != NULL){
             $params[0] = "contacts.id='".$val."'"; // query
             } else {
             $params[0] = "contacts.id='".$sess_contact_id."'"; // query
             }
          } else {
          $params[0] = ""; //$_SESSION['sess_contact_id']; 
          }

       $params[1] = array("first_name","last_name","description","email1");

       if ($action == 'edit'){
          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $params);
          }

       if (is_array ($result)){

          for ($cnt=0;$cnt < count($result);$cnt++){    
              $first_name = $result[$cnt]['first_name'];
              $last_name = $result[$cnt]['last_name'];
              $description = $result[$cnt]['description'];
              $email = $result[$cnt]['email1'];

              } // end for

          } // if array

       } // end if not fb

    if ($auth==2 || $auth==3 || $is_admin==TRUE){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'role_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Role"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    if ($auth==3){
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='e95b1f0d-034e-0d4c-7754-527329f5b975' "; //roles
       } else {
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='e95b1f0d-034e-0d4c-7754-527329f5b975' && id != '43b66381-12b8-7c4b-0602-5276698dcb48' && id != '2388a2b4-13b2-21ef-fe07-52732991fbfc' "; //roles
       }
    $tablefields[$tblcnt][9][5] = $role_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'role_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $role_c; //$field_value;
//    $tablefields[$tblcnt][43] = "<img src=images/blank.gif width=10 height=3>".$status_image; // field extras

    }

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "first_name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["FirstName"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][12] = 50; // Field length
    $tablefields[$tblcnt][20] = "first_name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $first_name; //$field_value;      

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "last_name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["LastName"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][12] = 50; // Field length
    $tablefields[$tblcnt][20] = "last_name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $last_name; //    

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "profile_photo_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["ProfilePhoto"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "profile_photo_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $profile_photo_c; //$field_value;  

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "nickname_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Nickname"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "nickname_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $nickname_c; //$field_value;  

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "cloakname_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Cloakname"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "cloakname_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $cloakname_c; //$field_value;  

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "password_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Password"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'password';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "password_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $password_c; //$field_value;  

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "email"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Email"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "email"; //$field_value_id;
    $tablefields[$tblcnt][21] = $email; //$field_value;   

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "default_name_type_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["DefaultViewableName"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_contactnametypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $default_name_type_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $default_name_type_c; // Field ID
    $tablefields[$tblcnt][20] = 'default_name_type_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $default_name_type_c; //$field_value; 

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "social_network_name_type_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["SocialNetworkViewableName"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_contactnametypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $social_network_name_type_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $social_network_name_type_c; // Field ID
    $tablefields[$tblcnt][20] = 'social_network_name_type_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $social_network_name_type_c; //$field_value; 

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "friends_name_type_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["FriendsViewableName"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_contactnametypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $friends_name_type_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $friends_name_type_c; // Field ID
    $tablefields[$tblcnt][20] = 'friends_name_type_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $friends_name_type_c; //$field_value; 

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "twitter_name_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TwitterName"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "twitter_name_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $twitter_name_c; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "twitter_password_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TwitterPassword"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'password';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "twitter_password_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $twitter_password_c; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "linkedin_name_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["LinkedInName"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "linkedin_name_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $linkedin_name_c; //$field_value;

    $tblcnt++;
          
    $tablefields[$tblcnt][0] = "cmn_languages_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Language"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_languages'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_languages_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_languages_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_languages_id_c; //$field_value; 
    
    $tblcnt++;
             
    $tablefields[$tblcnt][0] = "cmn_countries_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Country"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_countries'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_countries_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_countries_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_countries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_countries_id_c; //$field_value; 

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Description"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;      
    
    if ($sess_contact_id != NULL){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } else {
       $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
       }
    $valpack = "";
    $valpack[0] = 'Contacts';
    $valpack[1] = $action; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;


    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);
      
    if ($action == 'edit' || $action == 'view' ){
       echo "<div style=\"".$divstyle_grey."\"><font size=3>".$strings["Account"].": ".$first_name."</font></div>";
       }

       echo "<div style=\"".$divstyle_blue."\"><font size=3>".$strings["MemberProfile_Note"]."</font></div>";
       echo "<div style=\"".$divstyle_white."\"><center><font size=3><B>".$strings["RequiredMessage"]."</B></font></center></div>";
       echo "<img src=images/blank.gif width=98% height=10><BR>";

    echo $zaform;
    
    ###################################################
    # FB

    if ($fbme) {

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = 'My Facebook Friends'; // container_title
    $container_params[4] = 'FacebookFriends'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    $fbuserid = $fbme[id];
    $fbname = $fbme[name];
    $first_name = $fbme[first_name];
    $last_name = $fbme[last_name];
    $link = $fbme[link];
    $hometown = $fbme[hometown];
    $hometown_id = $hometown[id];
    $hometown_name = $hometown[name];
    $gender = $fbme[gender];
    $email = $fbme[email];
    $timezone = $fbme[timezone];
    $locale = $fbme[locale];
    $verified = $fbme[verified];
    $updated_time = $fbme[updated_time];
 
    echo "<center><font size=3><B>Hi " . $fbname."!</B></font></center><P>";
    echo "<div style=\"".$divstyle_orange_light."\">".$strings["Facebook_InviteFriends_Explanation"]."</div>";
    echo "<img src=images/blank.gif width=98% height=10><BR>";

    // Retrieve array of friends who've already added the app.  
    // $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.') AND has_added_app = 1'; 
    // SELECT uid2 FROM friend WHERE uid1=me()"
    // Retrieve array of friends who have not added the app
    // $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.') AND has_added_app = 0'; 

    $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.') '; 
    $_friends = $facebook->api(array(
'method' => 'fql.query',
'query' =>$fbfriendquery,
));

    // Extract the user ID's returned in the FQL request into a new array.  
    $friends = array();  
    $frcnt = 0;

    $tablefields = "";
    $tblcnt = 0;

    if (is_array($_friends) && count($_friends)) {  

       foreach ($_friends as $friend) {  

               $this_friend_id = $friend['uid']; 
               $myfriends[$frndcnt]['uid'] = $this_friend_id; 

               $frndcnt++;

               } // end foreach

       } // is array uid

    // $fbfriendquery = "SELECT flid, owner, name FROM friendlist WHERE owner=".$fbuserid;

    // $myfriends[$frndcnt]['uid'] = $friend['flid']; // friends list ID
    // $myfriends[$frndcnt]['owner'] = $friend['owner'];  // friends list ID
    // $myfriends[$frndcnt]['name'] = $friend['name'];  // friends list ID

      $tblcnt = 0;

      $fb_object_type = "Contacts";
      $fb_action = "all_source_contacts";
      $fb_params = array();
      $fb_params[0] = " cmv_leadsources_id_c='".$facebook_service_leadsources_id_c."' || cmv_leadsources_id_c='".$saloob_service_leadsources_id_c."' "; // query
      $fb_params[1] = ""; // select
      $fb_params[2] = ""; // group
      $fb_params[3] = ""; // order
      $fb_params[4] = ""; // limit

      $fb_result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fb_object_type, $fb_action, $fb_params);

      for ($cnt=0;$cnt < count($fb_result);$cnt++){

           $contact_id = $fb_result[$cnt]['contact_id_c'];
           $source_id = $fb_result[$cnt]['source_id'];
           $existing_users[$source_id] = $contact_id;

           }

      for ($cnt=0;$cnt < count($myfriends);$cnt++){

          $uid = $myfriends[$cnt]['uid'];

          if (array_key_exists($uid,$existing_users)){

             $contact_id = $existing_users[$uid];
             $contact_object_type = "Contacts";
             $contact_action = "contact_by_id";
             $contact_params = $contact_id; // query

             $contact_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);

             foreach ($contact_result['entry_list'] as $contact_gotten){

                     $contact_field = nameValuePairToSimpleArray($contact_gotten['name_value_list']);    
                     $first_name =  $contact_field['first_name'];
                     $last_name =  $contact_field['last_name'];
                     $contact_name = $first_name." ".$last_name;

                     } // foreach

             $existing_user .= "<div style=\"".$divstyle_white."\"><img src=images/icons/ok.gif> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$contact_id."&valuetype=Contacts');return false\"><B><B>".$contact_name."</B></a> <a href=https://www.facebook.com/".$uid." target=Facebook>View in Facebook</a></div>";

             // Check what they are in here for and whether they are in users social network - or shared networks...

             } // if in array

          } // for
/*
Can't register - no email from FB!! Doh! Need to use FB invite form
May be able to invite existing known users internally to join own Network
Need to loop through

        $tablefields[$tblcnt][0] = "uid-".$uid; // Field Name
        $tablefields[$tblcnt][1] = $uid; // Full Name
        $tablefields[$tblcnt][2] = 1; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = '0'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '';//1; // show in view 
        $tablefields[$tblcnt][11] = ''; // Field ID
        $tablefields[$tblcnt][20] = "uid-".$uid; //$field_value_id;
        $tablefields[$tblcnt][21] = 1; //$field_value;   

        $tblcnt++;

        $tablefields[$tblcnt][0] = "name-".$uid; // Field Name
        $tablefields[$tblcnt][1] = "Name"; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = '0'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = ""; // Field ID
        $tablefields[$tblcnt][20] = "name-".$uid; //$field_value_id;
        $tablefields[$tblcnt][21] = $name; //$field_value;   

        $tblcnt++;

        $tablefields[$tblcnt][0] = "email-".$email; // Field Name
        $tablefields[$tblcnt][1] = "Email"; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = '0'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = ""; // Field ID
        $tablefields[$tblcnt][20] = "email-".$email; //$field_value_id;
        $tablefields[$tblcnt][21] = $email; //$field_value;   

        $tblcnt++;

        $tablefields[$tblcnt][0] = "process_type"; // Field Name
        $tablefields[$tblcnt][1] = "Process Type"; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = '0'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = 'process_type'; // Field ID
        $tablefields[$tblcnt][20] = "process_type"; //$field_value_id;
        $tablefields[$tblcnt][21] = "Facebook"; //$field_value;   

        $tblcnt++;

End loop

    $valpack = "";
    $valpack[0] = 'Contacts';
    $valpack[1] = "add"; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = 2; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = 1; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);
    
    echo "<img src=images/blank.gif width=550 height=10><BR>";

    echo $zaform;
*/

    echo $existing_user;

    echo $container_bottom;

       } // end if fb

    # End FB
    ###################################################

    echo "<img src=images/blank.gif width=90% height=10><BR>";

    echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$sess_contact_id."&valuetype=id');return false\"><font=#151B54><B>".$strings["Account"]."</B></font></a></div><P>";

    echo "<img src=images/blank.gif width=90% height=10><BR>";

   break; // end edit
   ###################################################
   case 'process':

    echo $object_return;
    echo "<img src=images/blank.gif width=90% height=10><BR>";

    $process_type = $_POST['process_type'];

    switch ($process_type){

     case "":

      $error = "";
    
      if ($_POST['first_name'] == NULL){
         $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["FirstName"]."</B></font><BR>";
         }

      if ($_POST['last_name'] == NULL){
         $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["LastName"]."</B></font><BR>";
         }

      if ($_POST['nickname_c'] == NULL){
         $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Nickname"]."</B></font><BR>";
         } else {

         // Check if nickname exists

         $object_type = 'Contacts';
         $api_action = 'select_cstm';
    
         $params = array();
         $params[0] = "nickname_c='".$_POST['nickname_c']."' && id_c != '".$_POST['id']."' ";
         $params[1] =  "id_c,nickname_c";
         $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $api_action, $params);
    
         if (is_array($the_list)){
            $error .= "<font color=red><B>".$strings["SubmissionErrorAlreadyExists"].$strings["Nickname"]."(".$_POST['nickname_c'].")</B></font><BR>";
            }

         } // end else


      if ($_POST['email'] == NULL){
         $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Email"]."</B></font><BR>";
         } else {

         // Check if email exists

         $object_type = 'Contacts';
         $api_action = 'select_soap';
    
         $params = array();
         $params[0] = "email1='".$_POST['email']."' && id != '".$sess_contact_id."' ";
         $params[1] =  "id,email1";
         $the_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $params);
    
         if (is_array($the_list)){
            $error .= "<font color=red><B>".$strings["SubmissionErrorAlreadyExists"].$strings["Email"]."(".$_POST['email'].")</B></font><BR>";
            }

         } // end else

      if ($_POST['password_c'] == NULL){
         $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Password"]."</B></font><BR>";
         }

      if (!$error){

         $process_object_type = "Contacts";
         $process_action = "update";

         $process_params = array(
          array('name'=>'id','value' => $_POST['id']),
          array('name'=>'account_id','value' => $_POST['account_id']),
          array('name'=>'first_name','value' => $_POST['first_name']),
          array('name'=>'last_name','value' => $_POST['last_name']),
          array('name'=>'nickname_c','value' => $_POST['nickname_c']),
          array('name'=>'cloakname_c','value' => $_POST['cloakname_c']),
          array('name'=>'password_c','value' => $_POST['password_c']),
          array('name'=>'email1','value' => $_POST['email']),
          array('name'=>'twitter_name_c','value' => $_POST['twitter_name_c']),
          array('name'=>'twitter_password_c','value' => $_POST['twitter_password_c']),
          array('name'=>'linkedin_name_c','value' => $_POST['linkedin_name_c']),
          array('name'=>'profile_photo_c','value' => $_POST['profile_photo_c']),
          array('name'=>'description','value' => $_POST['description']),
          array('name'=>'default_name_type_c','value' => $_POST['default_name_type_c']),
          array('name'=>'social_network_name_type_c','value' => $_POST['social_network_name_type_c']),
          array('name'=>'friends_name_type_c','value' => $_POST['friends_name_type_c']),
          array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']),
          array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']),
          array('name'=>'role_c','value' => $_POST['role_c']),
          ); 

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         $newcontact_id = $result['id'];

/*
         $process_object_type = "ContactProfiles";
         $process_action = "update";

         $sent_contact_profile_id = $_POST['contact_profile_id'];
         $sent_default_name_type = $_POST['default_name_type'];
         $sent_social_network_name_type = $_POST['social_network_name_type'];
         $sent_friends_name_type = $_POST['friends_name_type'];

         if ($_POST['contact_profile_id'] == NULL){
            $contact_profile_name = $_POST['first_name']." Default Profile";
            }

         $process_params = array(
          array('name'=>'id','value' => $sent_contact_profile_id),
          array('name'=>'contact_id_c','value' => $_POST['id']),
          array('name'=>'name','value' => $contact_profile_name),
          array('name'=>'cmn_contactnametypes_id_c','value' => $sent_default_name_type),
          array('name'=>'cmn_contactnametypes_id1_c','value' => $sent_social_network_name_type),
          array('name'=>'cmn_contactnametypes_id2_c','value' => $sent_friends_name_type),
          ); 

         $contact_profile_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
*/
         $process_message .= $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$sess_contact_id."&valuetype=".$valtype."');return false\">View Here</a>";       

         $process_message .= "<P><B>Profile Photo:</B> <img src=".$_POST['profile_photo_c']." width=400><P>";
         $process_message .= "<B>".$strings["FirstName"].":</B> ".$_POST['first_name']."<BR>";
         $process_message .= "<B>".$strings["LastName"].":</B> ".$_POST['last_name']."<BR>";
         $process_message .= "<B>".$strings["Nickname"].":</B> ".$_POST['nickname_c']."<BR>";
         $process_message .= "<B>".$strings["Cloakname"].":</B> ".$_POST['cloakname_c']."<BR>";
         $process_message .= "<B>".$strings["Email"].":</B> ".$_POST['email']."<BR>";

         $accid_object_type = "Contacts";
         $accid_action = "get_account_id";
         $accid_params[0] = $sess_contact_id;
         $accid_params[1] = "account_id";
         $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

         if ($account_id != NULL){

            $relate_object_type = "Relationships";
            $relate_action = "set_modules";
            $relate_params = array();
            $relate_params[0] = "Accounts";
            $relate_params[1] = $account_id;
            $relate_params[2] = "Contacts";
            $relate_params[3] = $newcontact_id;

            $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $relate_object_type, $relate_action, $relate_params);

            } // if account - must be to even be here, but check anyway...something might be screwed up...

         echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";

         } else {// no error

         echo "<div style=\"".$divstyle_organge."\">".$error."</div>";
  
         }

      break; // end no process type
      case "Facebook":

       foreach ($_POST as $name=>$value){

               echo "Field: ".$name." - Value: ".$value."<BR>";

               list ($type,$typeval) = explode ("-", $name);
               if ($type == 'uid'){

                  $namefield = "name-".$typeval;
                  $name = $_POST[$namefield];
                  $emailfield = "email-".$typeval;
                  $email = $_POST[$emailfield];

                  echo "ID: $typeval | $name | $email <BR>";

                  } // if uid

               } // foreach

      break; // end Facebook members added
      case "SugarCRM":

       $newcontacts_cnt = 0;

       foreach ($_POST as $name=>$value){

               //echo "Field: ".$name." - Value: ".$value."<BR>";

               list ($type,$typeval) = explode ("_|_", $name);

               if ($type == 'id'){

                  $first_namefield = "first_name_|_".$typeval;
                  $first_name = $_POST[$first_namefield];
                  $last_namefield = "last_name_|_".$typeval;
                  $last_name = $_POST[$last_namefield];
                  $emailfield = "email_|_".$typeval;
                  $email = $_POST[$emailfield];
                  $idfield = "id_|_".$typeval;
                  $idval = $_POST[$idfield]; //checkbox = on
                  $sclm_externalsources_id_cfield = "sclm_externalsources_id_c_|_".$typeval;
                  $sclm_externalsources_id_c = $_POST[$sclm_externalsources_id_cfield];

                  if ($idval==1){
                     // To be processed
		     
                     echo "To be created as Contact from External Source ($sfx_externalsources_id_c) User - ID: $typeval | $first_name | $last_name | $email<BR>";
		     $check_object_type = "Contacts";
		     $check_action = "contact_by_email";
		     $check_params = $email; // query

		     $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $check_object_type, $check_action, $check_params);

		     foreach ($result['entry_list'] as $gotten){

		             $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
		             $id =  $fieldarray['id'];

		             echo "Check $email has ID: ".$id."<P>";

		             } // end for each

		     if ($id != NULL){
		        // Email exists

		        echo "This email (".$email.") already exists.<P>";

		        } else {

		        // Email doesn't exist - create contact

		        $create_object_type = "Contacts";
		        $create_action = "create";
		        $create_params = array();
		        $create_params[0] = $last_name;
		        $create_params[1] = $first_name;
		        $create_params[2] = $email;

		        $create_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $create_object_type, $create_action, $create_params);

		        $contact_id = $create_result['id'];

		        $pass_object_type = "Contacts";
		        $pass_action = "update_password";
                        $password = $funky_gear->createRandomPassword();
                        $pass_params = array();
                        $pass_params[0] = $contact_id;
                        $pass_params[1] = $password;

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $pass_object_type, $pass_action, $pass_params);

                        $newcontacts[$newcontacts_cnt]['id'] = $contact_id;
                        $newcontacts[$newcontacts_cnt]['password'] = $password;
                        $newcontacts[$newcontacts_cnt]['url'] = $first_name." ".$last_name."'s account with email (".$email.") has been created. <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Contacts&action=view&val=".$contact_id."');return false\"><font size=2 color=\"##6e89dd\">View here</font></a><BR>";
                        $newcontacts[$newcontacts_cnt]['name'] = $first_name." ".$last_name;
                        $newcontacts[$newcontacts_cnt]['email'] = $email;
                        $newcontacts[$newcontacts_cnt]['sfx_externalsources_id_c'] = $sfx_externalsources_id_c; // Users SugarCRM Source
                        $newcontacts[$newcontacts_cnt]['external_user_id'] = $idval; // Should be from users SugarCRM

                        $newcontacts_cnt++;

                        } // end if email doesn't exist

                     } else {

                     echo "NOT to be created: $typeval | $first_name | $last_name | $email | sfx_externalsources_id_c= $sfx_externalsources_id_c<P>";

                     }

                  } // if id

               } // foreach

       if (is_array($newcontacts)){

          $accid_object_type = "Contacts";
          $accid_action = "get_account_id";
          $accid_params[0] = $sess_contact_id;
          $accid_params[1] = "account_id";
          $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

          $acc_object_type = "Accounts";
          $acc_action = "select";
          $acc_params[0] = "id='".$account_id."' ";
          $acc_params[1] = "name";
          $acc_params[2] = "";
          $acc_params[3] = "";
          $acc_result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

          for ($cnt=0;$cnt < count($acc_result);$cnt++){

              $account_name = $acc_result[$cnt]['name'];

              }

          // Check to see if new contact lead source exists (based on the external source)
          $checkleadsource_object_type = "LeadSources";
          $checkleadsource_action = "select";
          $checkleadsource_params = array();
          $checkleadsource_params[0] = " sclm_externalsources_id_c='".$sclm_externalsources_id_c."' "; // query
          $checkleadsource_params[1] = "id"; // select
          $checkleadsource_params[2] = ""; // group
          $checkleadsource_params[3] = ""; // order
          $checkleadsource_params[4] = ""; // limit

          $checkleadsource_result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $checkleadsource_object_type, $checkleadsource_action, $checkleadsource_params);

          if (is_array($checkleadsource_result)){

             for ($cnt=0;$cnt < count($checkleadsource_result);$cnt++){

                 $lead_source_id = $checkleadsource_result[$cnt]['id'];

                 } // end for

             }

          if ($lead_source_id == NULL){

             $ext_object_type = "ExternalSources";
             $ext_action = "select";
             $ext_params[1] = ""; // select
             $ext_params[2] = ""; // group;
             $ext_params[3] = ""; // order;
             $ext_params[4] = ""; // limit

             $ext_source_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ext_object_type, $ext_action, $ext_params);

             if (is_array($ext_source_info)){
      
                for ($cnt=0;$cnt < count($ext_source_info);$cnt++){

                    $ext_source_name = $ext_source_info[$cnt]['name'];
                    $ext_source_api_url = $source_info[$cnt]['api_url'];
                    $ext_source_username = $source_info[$cnt]['api_username'];

                    } // end for

                } // is array

             // Doesn't exist - must create
             $leadsource_object_type = "LeadSources";
             $leadsource_action = "select";
             $leadsource_name = $account_name."'s SugarCRM Contact Lead Source";
             $leadsource_desc = $account_name."'s Contact Lead Source based on an External SugarCRM Source";
             $created_by = 1;
             $modified_user_id = 1;
             $assigned_user_id = 1;

             $process_params = array(
        array('name'=>'id','value' => $lead_source_id),
        array('name'=>'name','value' => $leadsource_name),
        array('name'=>'modified_user_id','value' => $modified_user_id),
        array('name'=>'created_by','value' => $created_by),
        array('name'=>'description','value' => $leadsource_desc),
        array('name'=>'assigned_user_id','value' => $assigned_user_id),
        array('name'=>'sclm_lead_source_url','value' =>$ext_source_api_url),
        array('name'=>'sclm_lead_source_id','value' => $ext_source_username),
        array('name'=>'sclm_externalsources_id_c','value' => $sclm_externalsources_id_c),
        array('name'=>'account_id_c','value' => $account_id),
        ); 

             $leadsource_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $lead_source_id = $leadsource_result['id'];

             } // end if lead source null

          if ($lead_source_id != NULL){

             for ($cnt=0;$cnt < count($newcontacts);$cnt++){

                 $new_contact_id = $newcontacts[$cnt]['id'];
                 $new_contact_password = $newcontacts[$cnt]['password'];
                 $new_contact_url = $newcontacts[$cnt]['url'];
                 $new_contact_name = $newcontacts[$cnt]['name'];
                 $new_contact_email = $newcontacts[$cnt]['email'];
                 $new_contact_ext_id = $newcontacts[$cnt]['external_user_id']; // Should be from users SugarCRM

                 // Create Contact Source
                 $contsource_object_type = "Contacts";
                 $contsource_action = "create_sclm_ContactsSources";
                 $contsource_name = $new_contact_name." from ".$leadsource_name;
                 $cmv_targetmarkets_id_c = "23842d3d-1140-2197-ed02-4c9d57a32740";

                 $contsource_params = array();      
                 $contsource_params = array(
                  array('name'=>'name','value' => $contsource_name),
                  array('name'=>'contact_id_c','value' => $new_contact_id),
                  array('name'=>'source_id','value' => $new_contact_ext_id),
                  array('name'=>'sclm_targetmarkets_id_c','value' => $cmv_targetmarkets_id_c),
                  array('name'=>'sclm_leadsources_id_c','value' => $lead_source_id) 
                  ); 

                 $contsource_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contsource_object_type, $contsource_action, $contsource_params);

                 echo $new_contact_url;

                 if ($account_id != NULL){

                    $relate_object_type = "Relationships";
                    $relate_action = "set_modules";

                    $relate_params = array();
                    $relate_params[0] = "Accounts";
                    $relate_params[1] = $account_id;
                    $relate_params[2] = "Contacts";
                    $relate_params[3] = $contact_id;

                    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $relate_object_type, $relate_action, $relate_params);

                    } // if account - must be to even be here, but check anyway...something might be screwed up...
   
                 } // end for loop of new contacts

             } // if lead source

          } // end if array of new contacts

      break; // end SugarCRM members added
     
    } // end process type switch

   break; // end process
   case 'sync':

    // sync to facebook, linkedin, google, etc

   break; // end sync
   case 'view':
   case 'view-short':

    if ($val != $sess_contact_id && $val != NULL){

       $anon_params[0] = $val; # Content owner
       $anon_params[1] = ""; # account_owner
       $anon_params[2] = $sess_contact_id; #contact_viewer
       $anon_params[3] = $sess_account_id; #account_viewer
       $anon_params[4] = $do;
       $anon_params[5] = $valtype;
       $anon_params[6] = $val;

       $show_namer = $funky_gear->anonymity($anon_params);

       $show_name = $show_namer[0];
       $show_description = $show_namer[1];
       $profile_photo = $show_namer[2];
       $contact_profile = $show_namer[3];

       // Show a profile of some contact
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'closed'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $show_name; // container_title
       $container_params[4] = 'ContactProfile'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       echo $contact_profile;

       echo $container_bottom;

       #
       #################
       # Wellbeing

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'closed'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = "Well-being"; // container_title
       $container_params[4] = 'Well-being'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $cits = "sclm_configurationitemtypes_id_c='71529bf3-01ce-1a56-6f8f-554fe9490b75'";

       $ci_object_type = "ConfigurationItems";
       $ci_action = "select";
       $ci_params[0] = " deleted=0 && contact_id_c='".$val."' && ".$cits." ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          $this->funkydone ($_POST,$lingo,'Wellbeing','view',$val,$do,$bodywidth);

          } else {

          echo "<div style=\"".$divstyle_white."\"><B>Well-being content can only be shown if made public by the owner.</B></div>";

          } 

       echo $container_bottom;

       #
       #################
       # SNS

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'closed'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = "Social Networks"; // container_title
       $container_params[4] = 'SocialNetworks'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       #echo $container_top;

       #echo $this->funkydone ($_POST,$lingo,'SocialNetworking','list',$val,$do,$bodywidth);    

       #echo $container_bottom;

       #
       ##################
       # Content
/*
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = "Share ".$show_name; // container_title
       $container_params[4] = 'Share'; // container_label
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       if ($action == 'view'){

           echo $container_middle;

       ###################################################
       # Start Make Embedded Object Link

          $params = array();
          $params[0] = $show_name;
          echo $funky_gear->makeembedd ($do,'view',$val,'Contacts',$params);

          }

       # End Make Embedded Object Link
       ###################################################

       if ($action == 'view'){
  
       $container_params[3] = $show_name." ".$strings["Content"]; // container_title
       $container_params[4] = 'Content'; // container_label
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       echo $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);
       
       echo $container_bottom;

          } else { 

           echo $container_bottom;

          }
       # End Content
       ###################################################
*/
       } // end if not contact but has val

    if (($val == $sess_contact_id || $val == $is_admin) && $action != 'view-short'){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["MyAccount"]; // container_title
       $container_params[4] = 'MyAccount'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       ################################
       # Start MyAccount
       ################################

       $profile .= "<div style=\"".$divstyle_grey."\"><center><h2>".$portal_title." Account Information</h2></center></div>";

       $object_type = "Contacts";
       $api_action = "select_soap";
       $params = array();
       
       //echo "Contact ID: ".$sess_contact_id."<P>";
       
       $params[0] = "contacts.id='".$sess_contact_id."'"; // query
       $params[1] = array("first_name","last_name","description","email1","twitter_name_c","profile_photo_c");

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $params);
       
       //var_dump($result);
       
       if (is_array($result)){
       for ($cnt=0;$cnt < count($result);$cnt++){    
           $first_name = $result[$cnt]['first_name'];
           $last_name = $result[$cnt]['last_name'];
           $description = $result[$cnt]['description'];
           $email = $result[$cnt]['email1'];
           $twitter_name_c = $result[$cnt]['twitter_name_c'];
           $profile_photo = $result[$cnt]['profile_photo_c'];
           $cmn_languages_id_c = $result[$cnt]['cmn_languages_id_c'];
           $cmn_countries_id_c = $result[$cnt]['cmn_countries_id_c'];

           if ($profile_photo == NULL){

              $profile_photo = "images/profile_photo_default.png";

              }

           } // end for
       }

       ################################
       # Dashboard - Business Account
       ################################
       // Check if Business Account

       $object_type = "Contacts";
       $api_action = "get_account_id";
       $accparams[0] = $sess_contact_id;
       $accparams[1] = "account_id";
       $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $accparams);

    if ($account_id != NULL){
   
       $object_type = "Accounts";
       $api_action = "select_cstm";
       $accparams[0] = "id_c='".$account_id."' ";
       $accparams[1] = ""; // select
       $accparams[2] = ""; // group;
       $accparams[3] = ""; // order;
       $accparams[4] = ""; // limit

       $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $api_action, $accparams);

       if (is_array($account_info)){
      
          for ($cnt=0;$cnt < count($account_info);$cnt++){

              $create_party_count_c = $account_info[$cnt]['create_party_count_c'];
              $cmn_countries_id_c = $account_info[$cnt]['cmn_countries_id_c'];
              $account_admin_id = $account_info[$cnt]['contact_id_c']; // Administrator

              } // for

          } // if array

       $object_type = "Accounts";
       $api_action = "select";
       $accparams[0] = "id='".$account_id."' ";
       $accparams[1] = ""; // select
       $accparams[2] = ""; // group;
       $accparams[3] = ""; // order;
       $accparams[4] = ""; // limit

       $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $api_action, $accparams);

       if (is_array($account_info)){
      
          for ($cnt=0;$cnt < count($account_info);$cnt++){

              $account_name = $account_info[$cnt]['name'];

              } // for

          } // if array

       ###################################

       if ($sess_contact_id == $account_admin_id){

          $profile .="<div style=\"".$divstyle_blue."\"><center><img src=images/icons/infrastructure_16.gif width=16><font size=4> <B>".$strings["BusinessAccount"]."</B></font><BR><img src=images/blank.gif width=90% height=25><BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=edit&value=".$account_id."&valuetype=Accounts');return false\" class=\"css3button\"><font color=red><B>".$strings["action_edit"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=".$account_id."&valuetype=Accounts');return false\" class=\"css3button\"><B>".$account_name."</B></a><BR><img src=images/blank.gif width=90% height=25><BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Projects&action=list&value=".$account_id."&valuetype=Accounts');return false\" class=\"css3button\"><img src=images/icons/i_hspcservices.gif width=16><B>".$strings["ManageProject"]."</B></a><BR><img src=images/blank.gif width=90% height=10><BR></div>";
          } else {
          $profile .="<div style=\"".$divstyle_blue."\"><img src=images/icons/infrastructure_16.gif width=16> <B>".$strings["BusinessAccount"].":</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=".$account_id."&valuetype=Accounts');return false\"><font color=#151B54><B>".$account_name."</B></font></a></div>";
          }

       ###################################

       } else {

       $account_name = "No Account - Create now";

       $profile .="<div style=\"".$divstyle_orange."\"><img src=images/icons/infrastructure_16.gif width=16> <B>".$strings["BusinessAccount"].":</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=add&value=".$sess_contact_id."&valuetype=Contacts');return false\"><font=#151B54><B>".$account_name."</B></font></a></div>";

       } // if/not account 

    # End Dashboard - Business Account
    ################################
    # Profile Info
    $welcome = str_replace("XXXXXX",$first_name,$strings["AdvisoryWelcomeBack"]);
    $profile .="<div style=\"".$divstyle_white."\"><center><img src=".$profile_photo." width=200></center></div>";
    $profile .="<div style=\"".$divstyle_white."\"><B>".$welcome."</B>!".$strings["PersonalDetailsUpdate"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=edit&value=".$sess_contact_id."&valuetype=Contacts');return false\"><font color=#151B54><B>".$strings["action_view_here"]."</B></font></a></div>";

    $profile .="<div style=\"".$divstyle_white."\"><B>".$portal_title." ID:</B> ".$sess_contact_id."</div>";
// The following could be the Contact Source ID
//   $profile .="<div style=\"".$divstyle_white."\"><B>".$portal_title." Key:</B> ".$sess_leadsources_id_c."</div>";
    $profile .="<div style=\"".$divstyle_white."\"><B>".$strings["FirstName"].":</B> ".$first_name."</div>";
    $profile .="<div style=\"".$divstyle_white."\"><B>".$strings["LastName"].":</B> ".$last_name."</div>";
    $profile .="<div style=\"".$divstyle_white."\"><B>".$strings["Email"].":</B> ".$email."</div>";
    $profile .="<div style=\"".$divstyle_white."\"><B>".$strings["TwitterName"].":</B> ".$twitter_name_c."</div>";


    // Check for Facebook

    if ($fbme) {

       $userid = $fbme[id];
       $name = $fbme[name];
       $first_name = $fbme[first_name];
       $last_name = $fbme[last_name];
       $link = $fbme[link];
       $hometown = $fbme[hometown];
       $hometown_id = $hometown[id];
       $hometown_name = $hometown[name];
       $gender = $fbme[gender];
       $email = $fbme[email];
       $timezone = $fbme[timezone];
       $locale = $fbme[locale];
       $verified = $fbme[verified];
       $updated_time = $fbme[updated_time];

       $welcome = str_replace("XXXXXX",$first_name,$strings["AdvisoryWelcomeBack"]);
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>".$welcome."</B>!".$strings["PersonalDetailsUpdate"]."<a href=".$facebook_app_url." target=FB>Facebook</a>".$strings["or"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=edit&value=yes&valuetype=update_using_fb');return false\"><font=#151B54><B>".$strings["action_view_here"]."</B></font></a></div>";
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>Facebook ID:</B> ".$userid."</div>";
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>".$strings["FirstName"].":</B> ".$first_name."</div>";
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>".$strings["LastName"].":</B> ".$last_name."</div>";
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>".$strings["Email"].":</B> ".$email."</div>";
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>Timezone:</B> ".$timezone."</div>";
       $fbprofile .="<div style=\"".$divstyle_white."\"><B>Locale:</B> ".$locale."</div>";
    
       $profile .= "<div style=\"".$divstyle_grey."\"><center><h2>Facebook Account Information</h2></center></div>";

       $profile .= $fbprofile;
    
    //$rs = $facebook->api_client->fql_query("SELECT uid FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1 = $userid)");
    //$rs = $facebook->api('/me/friends');
    //https://graph.facebook.com/$userid/friends?fields=picture,name&access_token=$fbsession
    
    //$fbquery = "SELECT publish_stream,create_event,rsvp_event,sms,offline_access,publish_checkins from permissions where uid=$fbuid";
       
       $profile .= "<div style=\"".$divstyle_white."\"><center><h2>Facebook Permissions for ".$portal_title."</h2></center></div>";

       $fbquery = "SELECT publish_stream,create_event,rsvp_event,sms,offline_access,publish_checkins from permissions where uid=$fbuid";
    
    //echo $fbquery ;
    
       $permissions = $facebook->api(array(
       'method' => 'fql.query',
       'query' =>$fbquery,
       ));
    
       $permlist = array();
    //$permlist = array("publish_stream","create_event","rsvp_event","sms","offline_access","publish_checkins","manage_pages","email","read_insights","read_stream","read_mailbox","ads_management","xmpp_login","user_about_me","user_activities","user_birthday","user_education_history","user_events","user_groups","user_hometown","user_interests","user_likes","user_location","user_notes","user_online_presence","user_photo_video_tags","user_photos","user_relationships","user_religion_politics","user_status","user_videos","user_website","user_work_history","read_friendlists","read_requests","user_checkins","friends_events");
    
       $permlist = array("publish_stream","create_event","rsvp_event","sms","offline_access","publish_checkins","user_status");

       $permission = array();  
       $cnt=3;
       if (is_array($permissions) && count($permissions)) {  
          foreach ($permissions as $permission) {  

/*
         $publish_stream = $permission['publish_stream'];
         $create_event = $permission['create_event'];
         $rsvp_event = $permission['rsvp_event'];
         $sms = $permission['sms'];
         $offline_access = $permission['offline_access'];
         $publish_checkins = $permission['publish_checkins'];
*/ 
                  foreach ($permlist as $perm){
         
                          $permval = $permission[$perm];
                          //echo "<B>Perm: ".$perm.":</B> Permval: ".$permval."<BR>";
                          $profile .= "<div style=\"".$divstyle_white."\"><B>".$perm.":</B> ".$funky_gear->yesno($permval)."</div>";
         
                          }
     
     /*
     echo "<B>Publish Stream: </B>".$funky_gear->yesno($publish_stream)."<BR>
     <B>Create Event: </B>".$funky_gear->yesno($create_event)."<BR>
     <B>RSVP Event: </B>".$funky_gear->yesno($rsvp_event)."<BR>
     <B>SMS: </B>".$funky_gear->yesno($sms)."<BR>
     <B>Offline Access: </B>".$funky_gear->yesno($offline_access)."<BR>
     <B>Publish Checkins: </B>".$funky_gear->yesno($publish_checkins)."<BR>";
     */
     
                  } // for each perm
     
         } // end is array
    

//    echo "FBAPPID: ".$fbappid."<P>";
 

/*    
   $myFriends = $facebook->api('/me/friends');
   foreach($myFriends["data"] AS $key => $value){
      $my_friends[$key] = $value["id"];
      echo "Friend: ".$value["id"]."<BR>";
      }
  
 
   $comments = $facebook->api($val."/comments");
        
   foreach ($comments['data'] as $$comment) {
    if (!$like_users[$comment['name']]) {
     $like_users[$comment['name']] = 1;
     $like_user_ids[$comment['name']] = $comment['id'];
     } else {
     $like_users[$comment['name']]++;
     }
     echo "Comments: ".$comment['name']."<BR>";
     }
     
  
  
   $fbmovies = $facebook->api('/me/movies');
  

from from
to to
message message
picture picture
link link
name name
caption caption
description description
source source
icon icon
attribution attribution
actions actions
//commenting, liking
privacy privacy
//friends, networks, allow and deny
//EVERYONE, CUSTOM, ALL_FRIENDS, NETWORKS_FRIENDS, FRIENDS_OF_FRIENDS
created_time created_time
updated_time updated_time
targeting targeting
//country , city , region and locale  
  
   
   $myposts = $facebook->api('/me/posts');
 
    foreach ($myposts['data'] as $post) {
  
id
from from
to to
message message
picture picture
link link
name name
caption caption
description description
source source
icon icon
attribution attribution
actions actions
//commenting, liking
privacy privacy
//friends, networks, allow and deny
//EVERYONE, CUSTOM, ALL_FRIENDS, NETWORKS_FRIENDS, FRIENDS_OF_FRIENDS
created_time created_time
updated_time updated_time
targeting targeting
//country , city , region and locale

//connections
comments comments
likes likes

  
   $likes = $facebook->api($val."/likes");
        
   foreach ($likes['data'] as $like) {
    if (!$like_users[$like['name']]) {
     $like_users[$like['name']] = 1;
     $like_user_ids[$like['name']] = $like['id'];
     } else {
     $like_users[$like['name']]++;
     }
     echo "Likes: ".$like['name']."<BR>";
     }
 
  */
   # End Facebook
   ############################################
   } else {
   ############################################
    
    // Not FB - look up details from SOAP

   $profile .= "<div style=\"".$divstyle_grey."\"><center><h2>".$portal_title." Profile</h2></center></div>";  
   $profile .= "<div style=\"".$divstyle_white."\">".$portal_title." ID: ".$sess_contact_id."</div>";
   $profile .= "<div style=\"".$divstyle_white."\">".$portal_title." Key: ".$sess_leadsources_id_c."</div>";
    
   }
   
   // Get Credits
   ############################################
   # Contact info via SOAP
   
    $object_type = 'contacts';
    $action = 'select_cstm';
    
    $params = array();
    $params[0] = "id_c='".$sess_contact_id."'";
    //$params[0] ="";
    $params[1] =  "id_c,password_c,twitter_name_c,twitter_password_c,linkedin_name_c";
       
    //$the_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
    $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
    //var_dump($the_list);
    
    if (is_array($the_list)){
      
     for ($cnt=0;$cnt < count($the_list);$cnt++){

      $password_c = $the_list[$cnt]['password_c'];
      $twitter_name_c = $the_list[$cnt]['twitter_name_c'];
      $twitter_password_c = $the_list[$cnt]['twitter_password_c'];

      $linkedin_name_c = $the_list[$cnt]['linkedin_name_c'];

   $profile .= "<div style=\"".$divstyle_grey."\"><center><h2>Twitter Profile</h2></center></div>";

      if ($twitter_name_c){      
         $profile .= "<div style=\"".$divstyle_white."\"><B>Twitter Name:</B> ".$twitter_name_c."</div>";
         } else {
         $profile .= "<div style=\"".$divstyle_orange_light."\">Update your account with your Twitter account information</div>";
         } 

   $profile .= "<div style=\"".$divstyle_grey."\"><center><h2>Linkedin Profile</h2></center></div>";

      if ($linkedin_name_c){      
         $profile .= "<div style=\"".$divstyle_white."\"><B>Linkedin Name:</B> ".$linkedin_name_c."</div>";
         } else {
         $profile .= "<div style=\"".$divstyle_orange_light."\">Update your account with your Linkedin account information</div>";
         } 
      
      } // end for
      
    } // end if array
   
   // Get usual details
   

   $profile .= "<div style=\"".$divstyle_grey."\"><center><h2>Your Environment</h2></center></div>";
   
   $profile .= "<div style=\"".$divstyle_white."\"><B>Current IP:</B> ".$ip_address."</div>";
  
   if (!empty($country)) {
    $country = dlookup("cmn_countries", "name", "two_letter_code='".$country."'");   
    }
   
   $profile .= "<div style=\"".$divstyle_white."\"><B>IP-based Country:</B> ".$country."</div>";
  
   echo $profile;
  
# End MyAccount
###################################################
# ServiceCapabilities

   $container = "";  
   $container_top = "";
   $container_middle = "";
   $container_bottom = "";

   $container_params[0] = 'closed'; // container open state
   $container_params[1] = $bodywidth; // container_width
   $container_params[2] = $bodyheight; // container_height
   $container_params[3] = "My Service Capabilities"; // container_title
   $container_params[4] = 'ServiceCapabilities'; // container_label
   $container_params[5] = $portal_info; // portal info
   $container_params[6] = $portal_config; // portal configs
   $container_params[7] = $strings; // portal configs
   $container_params[8] = $lingo; // portal configs

   $container = $funky_gear->make_container ($container_params);

   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

   echo $container_middle;
  
   echo $this->funkydone ($_POST,$lingo,'ContactsServices','list',$val,$do,$bodywidth);

################################
# Start My Actions
/*
   $container = "";  
   $container_top = "";
   $container_middle = "";
   $container_bottom = "";

   $container_params[3] = "My Actions"; // container_title
   $container_params[4] = 'MyActions'; // container_label
   $container = $funky_gear->make_container ($container_params);

   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'Actions','list',$sess_contact_id,"Contacts",$bodywidth);

# End My Actions
################################
# Start Messages

   $container = "";  
   $container_top = "";
   $container_middle = "";
   $container_bottom = "";

   $container_params[3] = "My Messages"; // container_title
   $container_params[4] = 'MyMessages'; // container_label
   $container = $funky_gear->make_container ($container_params);

   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'Messages','list',$sess_contact_id,"Contacts",$bodywidth);

# End Messages
################################
# Start SocialNetworks

   $container = "";  
   $container_top = "";
   $container_middle = "";
   $container_bottom = "";

   $container_params[3] = "My Social Network"; // container_title
   $container_params[4] = 'MySocialNetwork'; // container_label
   $container = $funky_gear->make_container ($container_params);

   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'SocialNetworks','mine',$sess_contact_id,"Contacts",$bodywidth);
*/
################################
# Start My Events

   $container = "";  
   $container_top = "";
   $container_middle = "";
   $container_bottom = "";

   $container_params[3] = $strings["MyEvents"]; // container_title
   $container_params[4] = 'MyEvents'; // container_label
   $container = $funky_gear->make_container ($container_params);

   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

  // echo $container_middle;

//date_default_timezone_set("UTC");

   //echo $this->funkydone ($_POST,'Comments','list',$val,'Government',$bodywidth,$sess_source_id,$sess_contact_id,$sess_leadsources_id_c,$sess_targetmarkets_id_c);
       
   //echo "<a name=\"Events\" id=\"Events\"></a>";
   $myevents .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&action=add&value=".$sess_contact_id."&valuetype=Contact');return false\"><font=#151B54><B>Add Event</B></font></a></div>";
   
   if ($fbme) {
    
   $myevents .= "<div style=\"".$divstyle_grey."\"><center><h2>Facebook Events</h2></center></div>";
  
    $fbevents = $facebook->api('/me/events');
    
   //var_dump($fbevents);
   
    $event = array();  
    if (is_array($fbevents['data']) && count($fbevents['data'])) {  
     foreach ($fbevents['data'] as $event) {

     $eid = $event['id'];
     $pic = $event['pic_small'];
     $event_owner = $event['owner'];
     $event_name = $event['name'];
     $event_tagline = $event['tagline'];
     $event_description = $event['description'];
     $event_type = $event['event_type'];
     $event_subtype = $event['event_subtype'];
     $event_location = $event['location'];
     $event_date_start = $event['start_time'];
     $event_date_end = $event['end_time'];
     $event_rsvp_status = $event['rsvp_status'];
     
     //2011-04-15T09:00:00
     list ($event_date_start,$event_start_time) = explode ("T", $event_date_start);
     list ($event_date_end,$event_end_time) = explode ("T", $event_date_end);
     //$event_start_time = date("l dS F Y",$event['start_time']);
     //$event_date_start = date("dS F Y h:i",$event['start_time']);
     //$event_date_end = date("dS F Y h:i",$event['end_time']);
     $venue = $event['venue'];      
     //var_dump($venue);
     $venue_street = $venue['street'];
     $venue_city = $event['venue']['city'];
     $venue_state = $event['venue']['state'];
     $venue_zip = $event['venue']['zip'];
     $venue_country = $event['venue']['country'];
     $venue_latitude = $event['venue']['latitude'];
     $venue_longitude = $event['venue']['longitude'];

     if ($pic){
      $pic = "<img src=$pic>";
      } else {
      $pic = "<img src=images/cal.gif>";
      }
  
     $this_event = $pic."<BR>
<B>Event:</B> <a href=\"http://www.facebook.com/event.php?eid=".$eid."&index=1\" target=\"Facebook\">".$event_name."</a><BR>
<B>RSVP Status:</B> ".$event_rsvp_status."<BR>
<B>Location:</B> ".$event_location."<BR>
<B>Date Start:</B> ".$event_date_start." - <B>Start Time: </B> ".$event_start_time."<BR>
<B>Date End:</B> ".$event_date_end." - <B>End Time: </B> ".$event_end_time."<BR>";

/*
<B>Owner:</B> ".$event_owner."<BR>
<B>Tagline:</B> ".$event_tagline."<BR>
<B>Description:</B> ".$event_description."<BR>
<B>Type:</B> ".$event_type."<BR>
<B>Sub Type:</B> ".$event_subtype."<BR>
*/
      if ($venue){
      $this_event = "<B>Venue Street:</B> ".$venue_street."<BR>
<B>Venue City:</B> ".$venue_city."<BR>
<B>Venue State:</B> ".$venue_state."<BR>
<B>Venue Zip :</B> ".$venue_zip ."<BR>
<B>Venue Country:</B> ".$venue_country."<BR>
<B>Venue Latitude:</B> ".$venue_latitude."<BR>
<B>Venue Longitude:</B> ".$venue_longitude."<BR>";
       }
       
   $myevents .= "<div style=\"".$divstyle_white."\">".$this_event."</div>";
  
     } // end for each event
   
    } else { // end if events array
  
   $myevents .= "<div style=\"".$divstyle_white."\">No events on Facebook</div>";
  
     // Create an event now
   $myevents .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Events&action=add&value=".$sess_contact_id."&valuetype=Contact');return false\"><font=#151B54><B>Create an Event and post it on Facebook, invite connections...</B></font></a></div>";
  
    }   
    
  } // end if no fb events  

   $myevents .= "<div style=\"".$divstyle_grey."\"><center><h2>".$portal_title." Events</h2></center></div>";

//   echo $myevents;
     
//  $this->funkydone ($_POST,$lingo,'Events','list',$sess_contact_id,'Contacts',$bodywidth);   
   
 
# End My Events
################################
/*
    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[3] = $strings["MyComments"]; // container_title
    $container_params[4] = 'MyComments'; // container_label
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_middle;

    ################################
    # Start My Comments


    #
    ################################

    echo $container_bottom;
*/
       }

    if ($val == NULL && $sess_contact_id == NULL){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = $strings["Login"]; // container_title
       $container_params[4] = 'Login'; // container_label
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       echo "<P><a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=logout&value=&valuetype=');return false\"><B>Your Session has ended - please log in again..</B></a>";

       echo $container_bottom;

       exit;

       } // close it down if not signed in

   break; // end Contacts view

   } // end switch

# break;
##########################################################
?>