<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-04-14
# Page: SocialNetworking.php 
##########################################################
# case 'SocialNetworking':

if (!function_exists('get_param')){
   include ("common.php");
   }

  $sn_cit = $_POST['sn_cit'];

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     if (!$sendiv){
        $sendiv = $BodyDIV;
        }
     }

  switch ($action){

   case 'list':

    $sn_style = "background-color: ".$portal_header_colour.";float:left;height:25px;padding-top:4px;padding-left:3%;padding-right:3%;width:200px;overflow: auto;border: 1px solid #ffcc66;margin-left: 1%;";

    $profile_style = "background-color:".$portal_header_colour.";padding-left:3%;padding-right:3%;width:200px;height:25px;padding-top:4px;overflow: auto;border: 1px solid #ffcc66;margin-right: 1%;";

    if ($sess_contact_id != NULL) {# if contact

       # Accounts | ID: 6898e8d5-e6b5-eda3-b1bc-55220a1b5037
       # Contacts | ID: 140cf7f9-fc5c-cb9c-2082-55220a924268
       # Events | ID: 4e4233fd-bd1b-cf45-8baa-55220aeeadea
       # Lifestyle & State Categories | ID: 8be14b88-4b94-8325-ccd4-55220b6319d9
       # Products & Services | ID: 347e25e9-e3af-e3cc-e33c-55220ab84201

       # Available SNs Types
       $sn_cits = " (sclm_configurationitemtypes_id_c='6898e8d5-e6b5-eda3-b1bc-55220a1b5037' || sclm_configurationitemtypes_id_c='140cf7f9-fc5c-cb9c-2082-55220a924268' || sclm_configurationitemtypes_id_c='4e4233fd-bd1b-cf45-8baa-55220aeeadea' || sclm_configurationitemtypes_id_c='8be14b88-4b94-8325-ccd4-55220b6319d9' || sclm_configurationitemtypes_id_c='347e25e9-e3af-e3cc-e33c-55220ab84201') ";

       $sclm_object_type = "ConfigurationItems";
       $sclm_action = "select";
       $sclm_params[0] = " deleted=0 && ".$sn_cits;
       $sclm_params[1] = "id,name,sclm_configurationitemtypes_id_c";
       $sclm_params[2] = "";
       $sclm_params[3] = "";
       $sclm_params[4] = "";

       $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

       if (is_array($sclm_rows)){

          $sns_wrap = "<div style=\"".$sn_style."\"><center><font size=3 color=".$portal_font_colour."><B>Social Networks</B></font></center></div><div style=\"".$profile_style."\"><center><font size=3 color=".$portal_font_colour."><B>My Profiles</B></font></center></div>";

          for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

              # SN Parent Item - members become children under this
              $id = $sclm_rows[$cnt]['id'];
              $sn_object_id = $sclm_rows[$cnt]['name']; # Lifestyle Category/Event ID
              $sn_type_id = $sclm_rows[$cnt]['sclm_configurationitemtypes_id_c']; # Type - Lifestyle Cat or Event

              #echo "sn_object_id $sn_object_id <BR>";
              #echo "sclm_configurationitemtypes_id_c $sclm_configurationitemtypes_id_c <BR>";

              # Val is the profile ID - the parent owns the members' profiles
              $sclm_sn_object_type = "ConfigurationItems";
              $sclm_sn_action = "select";
              if ($val != NULL){
                 $sclm_sn_params[0] = " deleted=0 && contact_id_c='".$sess_contact_id."' && sclm_configurationitems_id_c='".$id."' && id!='".$val."'";
                 } else {
                 $sclm_sn_params[0] = " deleted=0 && contact_id_c='".$sess_contact_id."' && sclm_configurationitems_id_c='".$id."' ";
                 } 
              $sclm_sn_params[1] = "id,name,enabled";
              $sclm_sn_params[2] = "";
              $sclm_sn_params[3] = "";
              $sclm_sn_params[4] = "";

              $sclm_sn_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_sn_object_type, $sclm_sn_action, $sclm_sn_params);

              if (is_array($sclm_sn_rows)){

                 $sns = "";

                 for ($sn_cnt=0;$sn_cnt < count($sclm_sn_rows);$sn_cnt++){

                     $sn_profile_id = $sclm_sn_rows[$sn_cnt]['id'];
                     $sn_profile_title = $sclm_sn_rows[$sn_cnt]['name'];

                     #$sns .= "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=view&value=".$sn_profile_id."&valuetype=SocialNetworking&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><B>".$sn_profile_title."</B></a>";
                     $sns .= "<a href=\"#\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=view&value=".$sn_profile_id."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\"><font size=2><B>".$sn_profile_title."</B></font></a>";

                     } # for 

                 # Get SN Name
                 # Accounts | ID: 6898e8d5-e6b5-eda3-b1bc-55220a1b5037
                 # Contacts | ID: 140cf7f9-fc5c-cb9c-2082-55220a924268
                 # Events | ID: 4e4233fd-bd1b-cf45-8baa-55220aeeadea
                 # Lifestyle & State Categories | ID: 8be14b88-4b94-8325-ccd4-55220b6319d9
                 # Products & Services | ID: 347e25e9-e3af-e3cc-e33c-55220ab84201

                 switch ($sn_type_id){
   
                  case '6898e8d5-e6b5-eda3-b1bc-55220a1b5037': # Accounts

                   $sn_returner = $funky_gear->object_returner ("Accounts", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '140cf7f9-fc5c-cb9c-2082-55220a924268': # Accounts
   
                   $sn_returner = $funky_gear->object_returner ("Contacts", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '4e4233fd-bd1b-cf45-8baa-55220aeeadea': # Events

                   $sn_returner = $funky_gear->object_returner ("Events", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '8be14b88-4b94-8325-ccd4-55220b6319d9': # Lifestyle cat

                   $sn_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '347e25e9-e3af-e3cc-e33c-55220ab84201': # AccountsServices

                   $sn_returner = $funky_gear->object_returner ("AccountsServices", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;

                 } # end type switch

                 # Final wrapper with title and any sub profiles

                 $sns_wrap .= "<div style=\"background-color:#FFFFFF;float:left;height:30px;padding-top:10px;padding-left:3%;padding-right:3%;width:200px;overflow: auto;border: 1px solid #ffcc66;margin-left: 1%;\"><center><font color=BLACK size=3><B>".$sn_name."</B></font></center></div><div style=\"background-color:#FFFFFF;padding-left:3%;padding-right:3%;width:200px;height:30px;padding-top:10px;overflow: auto;border: 1px solid #ffcc66;margin-right:1%;\"><center>".$sns."</center></div>";

                 } # is array

              } # for 

          # Should be SN options available - only wrapped if they are in one
          $socialnetwork = "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:98%; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left:2px; padding-right:2px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;\"><center><font size=3 color=".$portal_font_colour."><B>My Other Social Networks</B></font></center></div>";

          $socialnetwork .= "<div name=\"wellbeing\" id=\"wellbeing\" style=\"width:99%;min-height:28px;margin-left: auto;margin-right: auto;\">".$sns_wrap."</div>";

          } # is array

       } else {# Logged-in but needs to select

       $socialnetwork = "<div style=\"".$divstyle_white."\">You are not currently signed-in, so we can not yet show this Social Network. Please do try to register and/or sign in and then return to this page or the link you may have received. Thank you!</div>";  

       } 

       echo $socialnetwork;

   break; # list
   case 'edit_connection':

   break; # edit_connection
   case 'list_connections':

    $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

/*
    $sn_params[0] = $do;
    $sn_params[1] = "list";
    $sn_params[2] = $valtype;
    $sn_params[3] = $val;

    # lifestyleval=".$wblinkval."
    $extra_params[0] = "";
    $extra_params[1] = "";
    $sn_params[4] = $extra_params;
    
    $sn_returner = $funky_sn->sn_contacts ($sn_params);
    $rel_contacts = $sn_returner[0];
    echo $rel_contacts;
*/

    $ci_object_type = "ConfigurationItems";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && (contact_id_c='".$sess_contact_id."' || name='".$sess_contact_id."') && sclm_configurationitemtypes_id_c='24ac8d1e-9a9a-4f88-98c9-55500353563d'";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $category_id = $ci_items[$cnt]['description'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];

           $edit = "";

           if ($name == $sess_contact_id){

              $anon_params[0] = $contact_id_c; # Content owner
              $anon_params[1] = $account_id_c; # account_owner
              $anon_params[2] = $sess_contact_id; #contact_viewer
              $anon_params[3] = $sess_account_id; #account_viewer

              $friend = $contact_id_c;

              } elseif ($contact_id_c == $sess_contact_id){

              $anon_params[0] = $name; # Content owner
              $anon_params[1] = ""; # account_owner
              $anon_params[2] = $sess_contact_id; #contact_viewer
              $anon_params[3] = $sess_account_id; #account_viewer

              $edit = " <a href=\"#Top\" onClick=\"Scroller();loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=edit_connection&value=".$id."&valuetype=SocialNetworking&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";

              $friend = $name;

              }

           $anon_params[4] = $do;
           $anon_params[5] = $valtype;
           $anon_params[6] = $val;

           $show_namer = $funky_gear->anonymity($anon_params);

           $show_name = $show_namer[0];
           $show_description = $show_namer[1];
           $profile_photo = $show_namer[2];
           $contact_profile = $show_namer[3];

           $catter = $funky_gear->object_returner ("ConfigurationItemTypes", $category_id);
           $category = $catter[0];

           $connections .= "<div style=\"background-color: #FFFFFF;float:left;height:60px;padding-top:4px;padding-left:4px;padding-right:4px;width:60px;overflow: auto;border: 1px solid #ffcc66;margin-left:8px;\"><center><img src=".$profile_photo." width=50px></center></div><div style=\"background-color:#FFFFFF;padding-left:4px;padding-right:4px;width:385px;height:60px;padding-top:4px;overflow: auto;border: 1px solid #ffcc66;margin-right:4px;\">".$category.": <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$friend."&valuetype=".$do."');return false\"><B><font color=#151B54 size=3>".$show_name."</font></B></a></div>";

           } # for

       } else {

       $connections = $strings["Empty_Listed"];

       } 

    echo "<div style=\"".$divstyle_white."\">".$connections."</div>";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

   break; # list_connections
   #
   ###########################
   #
   case 'relate_contacts_add':
   case 'relate_contacts_edit':

    $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

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

    switch ($valtype){

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
     case 'HirokosTimer':

      $rel_object_type_cit = '75fd626b-b544-a54e-6557-5575b50579c6';

     break;
     case 'Lifestyles':

     break;
     case 'Projects':

     break;
     case 'ProjectTasks':

     break;
     case 'SocialNetworking':

     break;

    } # end valtype switch

    if ($action == 'relate_contacts_add' && $valtype == 'Wrapper'){

       # Wrapper created for the object
       $sclm_configurationitems_id_c = $val; # parent

       $ci_object_type = 'ConfigurationItems';
       $ci_action = "select";
       $ci_params[0] = "id='".$sclm_configurationitems_id_c."'";
       $ci_params[1] = "id,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){          

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $object_id_c = $ci_items[$cnt]['name'];
              #echo "sclm_events_id_c $sclm_events_id_c ";

              } # for

         } # is array

       } elseif ($action == 'relate_contacts_add' && $valtype != 'Wrapper'){

       # No wrapper created yet
       $object_id_c = $val;

       } elseif ($action == 'relate_contacts_edit'){

         $ci_object_type = "ConfigurationItems";
         $ci_object_action = "select";
         $ci_object_params[0] = "id='".$val."'"; #
         $ci_object_params[1] = "id,name,description,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,account_id_c,contact_id_c,cmn_statuses_id_c"; // select array
         $ci_object_params[2] = ""; // group;
         $ci_object_params[3] = " name, date_entered DESC "; // order;
         $ci_object_params[4] = ""; // limit
  
         $ci_object_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_object_action, $ci_object_params);

         if (is_array($ci_object_items)){          

            for ($ci_object_cnt=0;$ci_object_cnt < count($ci_object_items);$ci_object_cnt++){

                $recipient_id = $ci_object_items[$ci_object_cnt]['id'];
                $recipient_contacts = $ci_object_items[$ci_object_cnt]['name'];
                $recipient_contacts_description = $ci_object_items[$ci_object_cnt]['description'];
                $account_id_c = $ci_object_items[$ci_object_cnt]['account_id_c'];
                $contact_id_c = $ci_object_items[$ci_object_cnt]['contact_id_c'];
                $cmn_statuses_id_c = $ci_object_items[$ci_object_cnt]['cmn_statuses_id_c'];
                $sclm_configurationitems_id_c = $ci_object_items[$ci_object_cnt]['sclm_configurationitems_id_c'];
                $sclm_configurationitemtypes_id_c = $ci_object_items[$ci_object_cnt]['sclm_configurationitemtypes_id_c'];

                } # for

            ##############
            # Get Object
            $ci_object_type = 'ConfigurationItems';
            $ci_action = "select";
            $ci_params[0] = "id='".$sclm_configurationitems_id_c."'";
            $ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
            $ci_params[2] = ""; // group;
            $ci_params[3] = " name, date_entered DESC "; // order;
            $ci_params[4] = ""; // limit
  
            $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

            if (is_array($ci_items)){          

               for ($cnt=0;$cnt < count($ci_items);$cnt++){

                   $object_id_c = $ci_items[$cnt]['name'];
                   $rel_object_type_cit = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

                   } # for

               } # is array

            # Get Object
            ##############

            } # is array

         } # if edit

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "recipient_id"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 1; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "recipient_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $recipient_id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = "lightform"; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = 'lightform'; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_configurationitems_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "PAR CI"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "sclm_configurationitems_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_configurationitemtypes_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "CIT"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "sclm_configurationitemtypes_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $rel_object_type_cit; //$field_value;

    if ($action == 'relate_contacts_add'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'recipient_types'; // Field Name
       $tablefields[$tblcnt][1] = "Contacts"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       if ($action == 'relate_contacts_add'){
          $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
          } else {
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          } 
       #$tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = $funky_messaging->message_recipient_selections();

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // Exceptions
       $tablefields[$tblcnt][9][5] = $sclm_configurationitemtypes_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = ""; // Current Value
       $tablefields[$tblcnt][9][7] = "recipient_types"; // reltable
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "recipient_types"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_configurationitemtypes_id_c; //$field_value;     

       }

    if ($action == 'relate_contacts_edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "recipient_contacts"; // Field Name
       $tablefields[$tblcnt][1] = "Contact Value"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $recipient_contacts; // Field ID
       $tablefields[$tblcnt][20] = "recipient_contacts"; //$field_value_id;
       $tablefields[$tblcnt][21] = $recipient_contacts; //$field_value;   

       /*
       $tblcnt++;

       $tablefields[$tblcnt][0] = "recipient_contacts_description"; // Field Name
       $tablefields[$tblcnt][1] = "Contact Description"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $recipient_contacts_description; // Field ID
       $tablefields[$tblcnt][20] = "recipient_contacts_description"; //$field_value_id;
       $tablefields[$tblcnt][21] = $recipient_contacts_description; //$field_value;   

       */

       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "value"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "value"; //$field_value_id;
    $tablefields[$tblcnt][21] = $object_id_c; //$field_value;   

    # Need to present the object's item based on the do type
    # 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "valuetype"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;   

    #$tablefields = $this->$field_ojectify($tblcnt);

    if ($action == 'relate_contacts_add'){
       $account_id_c = $sess_account_id;
       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'account_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Account"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'accounts'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " id='".$account_id_c."' "; // exception
       }
    $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

    if ($action == 'relate_contacts_add'){
       $contact_id_c = $sess_contact_id;
       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'contact_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["User"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'accounts_contacts,contacts'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'first_name';

    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } elseif ($auth == 2){
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$account_id_c."'"; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id='".$contact_id_c."'"; // exception
       }

    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

    $tblcnt++;

    if (!$cmn_statuses_id_c){
       $cmn_statuses_id_c = $standard_statuses_closed;
       }

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_statuses'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "send_notification"; // Field Name
    $tablefields[$tblcnt][1] = "Send Notification?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $send_notification; // Field ID
    $tablefields[$tblcnt][20] = "send_notification"; //$field_value_id;
    $tablefields[$tblcnt][21] = $send_notification; //$field_value;

    ###########################################
    # To be added in future for additional permissions for added users
    # Event Contact Permissions | ID: a945556f-df9d-3805-6c99-555b6b8c50cd
    # Allow Access to Event Parent & Children | ID: 20afe70c-d7fe-0af9-67b4-555b6d928194
    ###########################################

    $valpack = "";
    $valpack[0] = "SocialNetworking";
    $valpack[1] = 'custom'; //
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = 'relate_contacts_process'; //
    $valpack[7] = "Relate Contacts";
    $valpack[8] = ""; 
    $valpack[10] = 'lightform';

    $relateform = $funky_gear->form_presentation($valpack);

    echo $relateform;

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

   break;
   #
   ###########################
   #
   case 'relate_contacts_process':

    $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

    # Content sent from form from function

    $message_link = "Body@".$lingo."@".$valtype."@view@".$val."@".$valtype;
    $message_link = $funky_gear->encrypt($message_link);
    $message_link = "https://".$hostname."/?pc=".$message_link;
    $message_image = "https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-100x100.png";


    /*
      foreach ($_POST as $acc_key=>$acc_value){

              echo "acc_key: ".$acc_key." => acc_value: ".$acc_value."<BR>";

              $acc_email = str_replace("account_contacts_key_","",$acc_key);

              echo "acc_email: ".$acc_email." (remove account_contacts_key_ )<BR>";

              $acc_diff = str_replace($acc_email,"",$acc_value);

              echo "acc_diff ".$acc_diff."<BR>";

              echo "if ($acc_email != NULL && $acc_value != NULL && $acc_email == $acc_value) <BR>";

              if ($acc_email != NULL && $acc_value != NULL && $acc_email == $acc_value){

                 echo $acc_email." == ".$acc_value."<BR>";

                 $acc_addressees[$acc_value] = $acc_value;
                 $recipient_contacts .= $acc_value.",";

                 } // if acc

              } // end foreach

    */

    #echo "Recipients = $recipient_contacts <BR>";

    #exit;

    switch ($valtype){

     case 'Accounts':

     break;
     case 'AccountsServices':

     break;
     case 'Contacts':

     break;
     case 'Events':
     case 'Effects':

      $rel_object_type_cit = 'f0bf777f-5346-d2e1-53c4-5551659b758d';

      $message_title = "You have been tagged in a ".$portal_title." Event!";
      $message_body = "Hello,\n\nYou have been included in an event posting on ".$portal_title.". Please go to the following link to check it out.";

     break;
     case 'HirokosTimer':

      $rel_object_type_cit = '75fd626b-b544-a54e-6557-5575b50579c6';
      $message_title = "You have been given access to Hiroko's Timer in ".$portal_title."!";
      $message_body = "Hello,\n\nYou have been given access to Hiroko's Timer in ".$portal_title.". Please go to the following link to check it out.";

     break;
     case 'Lifestyles':

     break;
     case 'Projects':

     break;
     case 'ProjectTasks':

     break;
     case 'SocialNetworking':

     break;

    } # end valtype switch

    $message_body .= "\n\n#################\n\n".$message_link;
    $message_body .= "\n\n#################\n\n".$portal_title." is a new type of Social Collaboration service that allows you to manage events and sub-events that matter in your life. Just like evolution - we are the result of all that occured before us - and now you have a way to manage the path you have taken and the path you will take - collaboratively; with friends, family, colleagues and/or the general public.\n\n";

    # Process the contacts
    $error = "";
    
    if ($_POST['recipient_types'] == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"]."Recipients</B></font><BR>";
       }

    #echo "Value Type: $valtype Value $val recipient_types $recipient_types<P>";
    #echo "<P>".$message_title."<BR>".$message_body;

    #exit;

    if (!$error){

       if ($_POST['sclm_configurationitems_id_c'] == NULL){

          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $val);
          $process_params[] = array('name'=>'description','value' => $val);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $rel_object_type_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

          $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
          $ci_wrapper_id = $rel_result['id'];

          } else {

          $ci_wrapper_id = $_POST['sclm_configurationitems_id_c'];

          } 

       # Switch based on valuetype (object)

       $msg_params[0] = $_POST;
       $msg_params[1] = $message_title;
       $msg_params[2] = $message_body;
       $msg_params[3] = $message_link;
       $msg_params[4] = $message_image;
       $msg_params[5] = $do;
       $msg_params[6] = $action;
       $msg_params[7] = $valtype;
       $msg_params[8] = $val;
       $extra_msg_params[0] = $rel_object_type_cit;
       $extra_msg_params[1] = $ci_wrapper_id;
       $msg_params[9] = $extra_msg_params;

       $message_results = $funky_messaging->message_delivery ($msg_params);

       $process_message = $strings["SubmissionSuccess"]."<P>";

       $message_id = $message_results[0];
       $emailresult = $message_results[1];

       $object_namer = $funky_gear->object_returner ($valtype, $val);
       $object_name = $object_namer[0];

       $process_message .= "<BR>".$emailresult;

       $process_message .= "<BR><a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$val."&valuetype=".$valtype."');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">".$object_name."</a><BR>";

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";  

       } else {

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";  

       } 

   break; # share_contacts_process
   case 'view_connection':

   break; # view_connection
   case 'add_connection':

    $target_contact = $val;

    $process_object_type = "ConfigurationItems";
    $process_action = "update";

    $cit = "24ac8d1e-9a9a-4f88-98c9-55500353563d";
    $process_params = array();  
    $process_params[] = array('name'=>'id','value' => $ci);
    $process_params[] = array('name'=>'name','value' => $target_contact);

    $description = "cce9664d-ccb9-9e0d-6afc-54fd70bdb27e"; # category

    $process_params[] = array('name'=>'description','value' => $description);
    $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $cit);
    $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
    $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
    $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
    $process_params[] = array('name'=>'enabled','value' => 1);
    $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($result != NULL){
       $connection_id = $result['id'];
       }

    $anon_params[0] = $target_contact; # Content owner
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


    $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

    echo "<div style=\"".$divstyle_white."\">Congratulations! You are now connected with ".$show_name."!</div>";
    echo "<div style=\"".$divstyle_white."\">".$contact_profile."</div>";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

   break; # add_connection
   case 'share':

    # Someone has been sent a link to a social network, and may not have an account.
    $sclm_configurationitems_id_c = $val;
    $sn_parent_id = $sclm_configurationitems_id_c;
    #echo "Par: ".$sn_parent_id."<BR>"; # <- Wrapper for the CIT SN based on below CIT
    #$sn_par_returner = $funky_gear->object_returner ("ConfigurationItems", $sn_parent_id);
    #$sn_par_name = $sn_par_returner[0]; #<- Lifestyle Cat CIT ID
    #echo "Par: ".$sn_par_name."<BR>";
    $sn_par_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_parent_id);
    $sn_par_name = $sn_par_returner[0];

    $socialnetwork .= "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Social Networking</B></font></center></div>";

    $socialnetwork .= "<div style=\"".$divstyle_white."\">Welcome to the <B>".$sn_par_name."</B> Social Network in ".$portal_title.".</div>";

    if ($sess_contact_id != NULL && $sn_parent_id != NULL){

       $sn_params[0] = "Lifestyles";
       $sn_params[1] = $sn_parent_id;
       $sn_params[2] = $account_id;
       $sn_params[3] = $contact_id;
       $sn_params[4] = $sess_account_id;
       $sn_params[5] = $sess_contact_id;
       $sn_params[6] = $BodyDIV;

       $social_network = $funky_gear->check_sn ($sn_params);
       $status = $social_network[0];
       $sn_button = $social_network[1];

       } else {

       $sn_button .= "<div style=\"".$divstyle_white."\">You must be a registered member and signed-in to be able to join the <B>".$sn_par_name."</B> Social Network in ".$portal_title.". Please try registering with Facebook, LinkedIn, Google or manually - we look forward to having you join us!</div>";

       } 

    $socialnetwork .= "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">Social Networking with Shared Effects allows you to join Social Networks that suit your lifestyle - the empowerment of your well-being.</div>";

    $socialnetwork .= "<div style=\"width:98%;margin-left: auto;margin-right: auto;\"><CENTER>".$sn_button."</CENTER></div>";

    echo $socialnetwork;

    
   break; # share
   case 'add':
   case 'edit':
   case 'view':

    # View SN Profile

    $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer."</center><P>";
       }

    if ($action == 'view' || $action == 'edit'){

       $snprofile_object_type = "ConfigurationItems";
       $snprofile_action = "select";
       $snprofile_params[0] = " id='".$val."' "; # Profile - under the wrapper of the sn category
       $snprofile_params[1] = "id,name,enabled,description,cmn_statuses_id_c,sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c";
       $snprofile_params[2] = "";
       $snprofile_params[3] = "";
       $snprofile_params[4] = "";

       $snprofile_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $snprofile_object_type, $snprofile_action, $snprofile_params);

       if (is_array($snprofile_rows)){

          for ($snprofilecnt=0;$snprofilecnt < count($snprofile_rows);$snprofilecnt++){

              $id = $snprofile_rows[$snprofilecnt]['id'];
              $name = $snprofile_rows[$snprofilecnt]['name'];
              $description = $snprofile_rows[$snprofilecnt]['description'];
              $sclm_configurationitemtypes_id_c = $snprofile_rows[$snprofilecnt]['sclm_configurationitemtypes_id_c'];

              $sclm_configurationitems_id_c = $snprofile_rows[$snprofilecnt]['sclm_configurationitems_id_c'];
              $sn_parent_id = $sclm_configurationitems_id_c;
              #echo "Par: ".$sn_parent_id."<BR>"; -< Wrapper for the CIT SN based on below CIT
              #$sn_par_returner = $funky_gear->object_returner ("ConfigurationItems", $sn_parent_id);
              #$sn_par_name = $sn_par_returner[0]; <- Lifestyle Cat CIT ID
              #echo "Par: ".$sn_par_name."<BR>";
              #$sn_par_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_par_name);
              #$sn_par_name = $sn_par_returner[0];
              #echo "Par: ".$sn_par_name."<BR>";

              $cmn_statuses_id_c = $snprofile_rows[$snprofilecnt]['cmn_statuses_id_c'];
              $enabled = $snprofile_rows[$snprofilecnt]['enabled'];

              } # for
   
          } # is array

       $sclm_sn_object_type = "ConfigurationItems";
       $sclm_sn_action = "select";
       $sclm_sn_params[0] = " id='".$sclm_configurationitems_id_c."' ";
       $sclm_sn_params[1] = "id,name,enabled,description,cmn_statuses_id_c,sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c";
       $sclm_sn_params[2] = "";
       $sclm_sn_params[3] = "";
       $sclm_sn_params[4] = "";

       $sclm_sn_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_sn_object_type, $sclm_sn_action, $sclm_sn_params);

       if (is_array($sclm_sn_rows)){

          for ($cnt=0;$cnt < count($sclm_sn_rows);$cnt++){

              #$id = $sclm_sn_rows[$cnt]['id'];
              $sn_cit = $sclm_sn_rows[$cnt]['name'];
              $sn_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_cit);
              $sn_name = $sn_returner[0];

              } # for
   
          } # is array

       $sn_joiner_msg = "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">Welcome back to the <B>".$sn_name." Social Network!</B> By joining this Social Network, you will be able to share events, content, discussion and more about things that interest you together with other like-minded people.</div>";

       } else { # edit/view

       #echo "Valtype: ".$valtype."<P>";
       #echo "SN ID: ".$sn_id."<P>";
       #echo "SN: ".$sn_name."<P>";
       #echo "SN CID: ".$val."<P>";

       switch ($valtype){

        case 'Accounts':
   
         $sn_id = "6898e8d5-e6b5-eda3-b1bc-55220a1b5037";
         #$sn_returner = $this->object_returner ($do, $object_id);
         #$sn_name = $sn_returner[0];

        break;
        case 'Contacts':
   
         $sn_id = "140cf7f9-fc5c-cb9c-2082-55220a924268";
         #$sn_returner = $this->object_returner ($do, $object_id);
         #$sn_name = $sn_returner[0];

        break;
        case 'Events':
        case 'Effects':

         $sn_id = "4e4233fd-bd1b-cf45-8baa-55220aeeadea";
  
         #$sn_returner = $this->object_returner ($do, $object_id);
         #$sn_name = $sn_returner[0];

        break;
        case 'Lifestyles':
   
         $sn_id = "8be14b88-4b94-8325-ccd4-55220b6319d9"; # Lifestyle & State Categories
         $account_id_c = "321f338d-5986-3a94-e391-548e62c74a22";
         $contact_id_c = "e761b2e7-8e6d-e75c-f0ee-548a4210f6cd";
         #echo "SN CIT: ".$sn_cit."<P>";
         $lst_cit = $sn_cit;
         $sn_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $lst_cit);
         $sn_name = $sn_returner[0];

        break;
        case 'AccountsServices':

         $sn_id = "347e25e9-e3af-e3cc-e33c-55220ab84201";
         #$sn_returner = $this->object_returner ($do, $object_id);
         #$sn_name = $sn_returner[0];

        break;

        } # switch valtype

       $sclm_configurationitems_id_c = $val;
       $sclm_configurationitemtypes_id_c = $sn_id;

       $sn_joiner_msg = "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">Welcome to the ".$sn_name." Social Network! By joining this Social Network, you will be able to share events, content, discussion and more about things that interest you together with other like-minded people.</div>";

       } # action

    #$sendiv = "lightform";

    $tblcnt = 0; // first set
      
    $tablefields[$tblcnt][0] = "id"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 1; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $id; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = "Profile Name"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $name; // Field ID
    $tablefields[$tblcnt][12] = '40'; # size
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_configurationitems_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "Parent CID (SN)"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $sclm_configurationitems_id_c; // Field ID
    $tablefields[$tblcnt][20] = "sclm_configurationitems_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_configurationitemtypes_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "SN CIT"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $sclm_configurationitemtypes_id_c; // Field ID
    $tablefields[$tblcnt][20] = "sclm_configurationitemtypes_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_configurationitemtypes_id_c; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'enabled'; // Field Name
    $tablefields[$tblcnt][1] = "Enabled"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'enabled';//$field_value_id;
    $tablefields[$tblcnt][21] = $enabled; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_statuses'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "Account"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $sess_account_id; // Field ID
    $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sess_account_id; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "Contact"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $sess_contact_id; // Field ID
    $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
    $tablefields[$tblcnt][1] = "Sendiv"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sendiv; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = "Description"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $description; // Field ID
    #$tablefields[$tblcnt][12] = '50'; # size
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   

    $auth=2;

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // Provide Add button
    $valpack[6] = ""; // Next Action
    $valpack[10] = $sendiv; # div for edit links

    switch ($action){

     case 'add':
      $valpack[7] = "Join"; // Action Button
     break;
     case 'edit':
      $valpack[7] = $strings["action_update"]; // Action Button
     break;
 
    } # switch

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = "97%"; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = "Social Networking"; // container_title
    $container_params[4] = 'SocialNetworking'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
     
    $container = $funky_gear->make_container ($container_params);
  
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;    

    #$sn_menu = "<center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:250px;color:#FFFFFF;\" name=\"lifestyle\" id=\"lifestyle\" value=\"Return to Social Networking\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','do=Lifestyles&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center><BR>";
    $sn_menu = "<center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:250px;color:#FFFFFF;\" name=\"lifestyle\" id=\"lifestyle\" value=\"Return to Social Networking\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php','do=Lifestyles&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=".$sendiv."');return false\"></center><BR>";

    $sn_menu .= "<center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"share\" id=\"share\" value=\"Share Social Network\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=Messages&action=add&value=".$sn_parent_id."&valuetype=SocialNetworking&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"></center><BR>";

    echo $sn_menu;

    echo $sn_joiner_msg;

    echo $zaform;

    if ($action == 'edit' || $action == 'view'){

       $workspace_header = "<P><div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Social Networking Workspace</B></font></center></div>";

       echo $workspace_header;

       # List all SNs
       $workspace_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('sn_workspace');doBPOSTRequest('sn_workspace','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=list_events&value=".$sn_parent_id."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\"><B>List Events</B></a></div>";

       # List all SNs
       $workspace_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('sn_workspace');doBPOSTRequest('sn_workspace','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=list&value=".$val."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\"><B>List My Other Social Networks</B></a></div>";

       # Show Messages
       $workspace_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('sn_workspace');doBPOSTRequest('sn_workspace','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=list_messages&value=".$sn_parent_id."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\"><B>List ".$sn_name." Messages</B></a></div>";

       # Show Content

       # Show Members

       $workspace_menu .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('sn_workspace');doBPOSTRequest('sn_workspace','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=list_members&value=".$sn_parent_id."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\"><B>List ".$sn_name." Members</B></a></div>";

       echo $workspace_menu;

       $sn_workspace = "<div name=sn_workspace id=sn_workspace style=\"font-family: v; font-size: 12pt; background-color:".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:99%; margin-top:2px;margin-bottom:2px;margin-left:1%;margin-right:1%; padding-left:2px; padding-right:2px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=BLACK><B>Social Networking Workspace</B></font></center></div>";

       echo $sn_workspace;

       echo "<img src=images/blank.gif width=95% height=5><BR>";

       $this->funkydone ($_POST,$lingo,'Content','list',$sn_parent_id,$do,$bodywidth);

       }

    echo $container_bottom;

   break; #end view
   case 'list_events':

    $addnew = "";
    if ($sess_contact_id != NULL){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=SocialNetworking&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><B>".$strings["action_addnew"]."</B></a></div>";
       }

    $sfx_object_type = "Events";
    $sfx_action = "select";
    $sfx_params[0] = "social_networking_id='".$val."'";
    $sfx_params[1] = "";
    $sfx_params[2] = "";
    $sfx_params[3] = "";
   
    $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);

    if (is_array($effects)){

       for ($cnt=0;$cnt < count($effects);$cnt++){

           $id = $effects[$cnt]['id'];
           $name = $effects[$cnt]['name'];
           $contact_id_c = $effects[$cnt]['contact_id_c'];

           $time_frame_id = $effects[$cnt]['time_frame_id'];
           $time_frame = $effects[$cnt]['time_frame'];

           $edit = "";
           if (($sess_contact_id == $contact_id_c && $sess_contact_id != NULL) || $auth == 3){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit&value=".$id."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red size=2><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           #$show_probability = ROUND($probability*100,2);

           $showdate = substr($start_date, 0, -9);

           #$sfx .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$id."&valuetype=Effects');return false\"><font color=#151B54 size=3><B>[".$time_frame."] ".$showdate." - ".$name."</B></font> (".$strings["Views"].": ".$view_count.") <font color=#151B54 size=2>[".$strings["Purpose"].": ".$purpose.", ".$strings["Probability"].": ".$show_probability."%, ".$strings["Positivity"].": ".$positivity.", ".$strings["AffectedGroupType"].": ".$group_type.", ".$strings["ValueType"].": ".$value_type."]</font></a></div>";
           $sfx .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$id."&valuetype=Effects');return false\"><font color=#151B54 size=3><B>[".$time_frame."] ".$showdate." - ".$name."</B></font></a></div>";

           } # for 

       } else {# is array 

       $sfx = "<div style=\"".$divstyle_white."\"><font color=black size=3>".$strings["Empty_Listed"]."</font></div>";

       } 

    echo $addnew.$sfx;

   break; #end list_messages
   case 'list_messages':

    $this->funkydone ($_POST,$lingo,'Messages','list',$val,$do,$bodywidth);

   break; #end list_messages
   case 'list_members':

    # $val is the parent CI of the members - it holds the type and name holds the object (cat ID/ event ID)

    if ($val != NULL){

       # The Social Network - Based on Cat/Event/Account/Contact/Product IDs as objects
       $sclm_sn_object_type = "ConfigurationItems";
       $sclm_sn_action = "select";
       $sclm_sn_params[0] = " id='".$val."' ";
       $sclm_sn_params[1] = "id,name,enabled,description,cmn_statuses_id_c,sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c";
       $sclm_sn_params[2] = "";
       $sclm_sn_params[3] = "";
       $sclm_sn_params[4] = "";

       $sclm_sn_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_sn_object_type, $sclm_sn_action, $sclm_sn_params);

       if (is_array($sclm_sn_rows)){

          for ($cnt=0;$cnt < count($sclm_sn_rows);$cnt++){

              #$id = $sclm_sn_rows[$cnt]['id'];
              $sn_object_id = $sclm_sn_rows[$cnt]['name'];
              $sn_type_id = $sclm_sn_rows[$cnt]['sclm_configurationitemtypes_id_c'];

              # Accounts | ID: 6898e8d5-e6b5-eda3-b1bc-55220a1b5037
              # Contacts | ID: 140cf7f9-fc5c-cb9c-2082-55220a924268
              # Events | ID: 4e4233fd-bd1b-cf45-8baa-55220aeeadea
              # Lifestyle & State Categories | ID: 8be14b88-4b94-8325-ccd4-55220b6319d9
              # Products & Services | ID: 347e25e9-e3af-e3cc-e33c-55220ab84201

              switch ($sn_type_id){

               case '6898e8d5-e6b5-eda3-b1bc-55220a1b5037': # Accounts

                $sn_returner = $funky_gear->object_returner ("Accounts", $sn_object_id);
                $sn_name = $sn_returner[0];                

               break;
               case '140cf7f9-fc5c-cb9c-2082-55220a924268': # Accounts

                $sn_returner = $funky_gear->object_returner ("Contacts", $sn_object_id);
                $sn_name = $sn_returner[0];                

               break;
               case '4e4233fd-bd1b-cf45-8baa-55220aeeadea': # Events

                $sn_returner = $funky_gear->object_returner ("Events", $sn_object_id);
                $sn_name = $sn_returner[0];                

               break;
               case '8be14b88-4b94-8325-ccd4-55220b6319d9': # Lifestyle cat

                $sn_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_object_id);
                $sn_name = $sn_returner[0];                

               break;
               case '347e25e9-e3af-e3cc-e33c-55220ab84201': # AccountsServices

                $sn_returner = $funky_gear->object_returner ("AccountsServices", $sn_object_id);
                $sn_name = $sn_returner[0];                

               break;

              } # end type switch

              } # for
   
          } # is array

       $snprofile_object_type = "ConfigurationItems";
       $snprofile_action = "select";
       $snprofile_params[0] = " sclm_configurationitems_id_c='".$val."' ";
       $snprofile_params[1] = "id,name,account_id_c,contact_id_c,enabled,description,cmn_statuses_id_c,sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c";
       $snprofile_params[2] = "";
       $snprofile_params[3] = "";
       $snprofile_params[4] = "";

       $snprofile_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $snprofile_object_type, $snprofile_action, $snprofile_params);

       if (is_array($snprofile_rows)){

          for ($snprofilecnt=0;$snprofilecnt < count($snprofile_rows);$snprofilecnt++){

              $profile_id = $snprofile_rows[$snprofilecnt]['id'];
              $profile_name = $snprofile_rows[$snprofilecnt]['name'];
              $account_id_c = $snprofile_rows[$snprofilecnt]['account_id_c'];
              $contact_id_c = $snprofile_rows[$snprofilecnt]['contact_id_c'];
              $profile_description = $snprofile_rows[$snprofilecnt]['description'];
              $sclm_configurationitemtypes_id_c = $snprofile_rows[$snprofilecnt]['sclm_configurationitemtypes_id_c'];

              $sclm_configurationitems_id_c = $snprofile_rows[$snprofilecnt]['sclm_configurationitems_id_c'];
              $sn_parent_id = $sclm_configurationitems_id_c;

              $cmn_statuses_id_c = $snprofile_rows[$snprofilecnt]['cmn_statuses_id_c'];
              $enabled = $snprofile_rows[$snprofilecnt]['enabled'];

              /*
              $anon_params[0] = $contact_id_c; # Content owner
              $anon_params[1] = $account_id_c; # account_owner
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
              */

              if ($contact_owner != NULL && $contact_viewer != NULL && $contact_owner != $contact_viewer){
                 $sn_params[0] = $contact_id_c; # Contact Target
                 $sn_params[1] = $sess_contact_id; # Contact Maker
                 $sn_params[2] = "connect";
                 $connect_button = $funky_gear->social_networking($sn_params);
                 $connection = "<font color=BLACK>".$connect_button."</font><BR>";
                 }
              $sns_wrap .= "<div style=\"background-color:#FFFFFF;float:left;height:30px;padding-top:10px;padding-left:3%;padding-right:3%;width:20%;overflow: auto;border: 1px solid #ffcc66;margin-left: 3%;\"><center><font color=BLACK><B>".$profile_name."</B></font></center></div><div style=\"float:left;background-color:#FFFFFF;padding-left:3%;padding-right:3%;width:60%;height:30px;padding-top:10px;overflow: auto;border: 1px solid #ffcc66;margin-right:3%;\">".$connection."<font color=BLACK><B>".$profile_description."</B></font></div>";

              } # for
   
          } # is array

       } # if val

    $workspace_header = "<P><div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Meet your fellow \"".$sn_name."\" Social Network Members</B></font></center></div>";

    echo $workspace_header;
    echo $sns_wrap;

   break; # end list_members
   case 'connection_request':

    # Via SN?

   break; # end connection_request
   case 'process':

    $process_object_type = "ConfigurationItems";
    $process_action = "update";
    $process_params = "";
    $process_params = array();
    $process_params[] = array('name'=>'id','value' => $_POST['id']);
    $process_params[] = array('name'=>'name','value' => $_POST['name']);
    $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
    $process_params[] = array('name'=>'description','value' => $_POST['description']);
    $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
    $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
    $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['sclm_configurationitems_id_c']);
    $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $_POST['sclm_configurationitemtypes_id_c']);
    $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
    $process_params[] = array('name'=>'enabled','value' => 1);
 
    $sn_service_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
    $sn_service_id = $sn_service_result['id'];

    $process_message = $strings["SubmissionSuccess"]."<P>";
    $process_message .= "<BR><B>".$strings["Title"].":</B> <a href=\"#\" onClick=\"doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$sn_service_id."&valuetype=".$do."');return false\">".$_POST['name']."</a><BR>";

    $sent_description = str_replace("\n", "<br>", $_POST['description']);
    $process_message .= "<B>".$strings["Description"].":</B> ".$sent_description."<BR>";

    echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";  

   break;

  } # action switch

# break; SocialNetworking
##########################################################
?>