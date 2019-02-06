<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Messages.php 
##########################################################
# case 'Messages':

  $sendiv = $_POST['sendiv'];
  if ($sendiv == NULL){
     $sendiv = $_GET['sendiv'];
     if ($sendiv == NULL){
        $sendiv = $BodyDIV;
        } else {
        $BodyDIV = $sendiv;
        } 
     } else {
     $BodyDIV = $sendiv;
     } 

  switch ($valtype){

   case '':

    if ($sess_contact_id != NULL){
       #$object_return_params[0] = " sclm_messages_id_c='' && (contact_id_c='".$sess_contact_id."' || contact_id1_c='".$sess_contact_id."') ";
       $object_return_params[0] = " sclm_messages_id_c IS NULL && (contact_id_c='".$sess_contact_id."' || contact_id1_c='".$sess_contact_id."') ";
//       $object_return_params[0] = " contact_id_c='".$contact_id_c."' || contact_id1_c='".$contact_id_c."' ";
       }

/*
    if ($account_id_c != NULL){
       $valtype = 'Accounts';
       $object_return_params[0] = " account_id_c='".$account_id_c."' || account_id1_c='".$account_id_c."' ";
       } else {
       $object_return_params[0] = " account_id_c='' ";
       } 
*/
   break;
   case 'Accounts':

    $object_return_params[0] = " sclm_messages_id_c IS NULL && (account_id_c='".$val."' || account_id1_c='".$sess_account_id."') ";

   break;
   case 'Contacts':

    $object_return_params[0] = " sclm_messages_id_c IS NULL && (contact_id_c='".$sess_contact_id."' || contact_id1_c='".$val."') ";
    $contact_id1_c = $val;
    $accid_object_type = "Contacts";
    $accid_action = "get_account_id";
    $accid_params[0] = $val;
    $accid_params[1] = "account_id";
    $account_id1_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

   break;
   case 'Messages':

    $object_return_params[0] = " sclm_messages_id_c='".$val."' ";

    if ($val){
       $sclm_messages_id_c = $val;
       }

   break;
   case 'Ticketing':

    ##

   break;
   case 'SocialNetworking':

    $sn_parent_id = $val;
    $object_return_params[0] = " sn_ci='".$sn_parent_id."' ";

   break;

  }


  $related = $_POST['related'];
  $relval = $_POST['relval'];

  switch ($related){

   case 'Ticketing':
   
    $sclm_ticketing_id_c = $relval;

    $ticket_object_type = "Ticketing";
    $ticket_action = "select";
    $ticket_params[0] = "id='".$relval."' ";
    $ticket_params[1] = "id,name,account_id1_c"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = ""; // order;
    $ticket_params[4] = ""; // limit
    $ticket_params[5] = $lingoname; // lingo
 
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           #$id = $ticket_items[$cnt]["id"];
           $account_id1_c = $ticket_items[$cnt]['account_id1_c'];
           #$ci_contact_id2_c = $ticket_items[$cnt]['contact_id2_c'];
           $name = $ticket_items[$cnt]['name'];
           #$sdm_confirmed = $ticket_items[$cnt]['sdm_confirmed'];
           #$billing_count = $ticket_items[$cnt]['billing_count'];
           #$service_operation_process = $ticket_items[$cnt]['service_operation_process'];
           #$sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];

           }  // end for

       }  // is array

    $mess_link = "Body@".$lingo."@Ticketing@view@".$relval."@Ticketing";
    $mess_link = $funky_gear->encrypt($mess_link);
    $mess_link = "http://".$hostname."/?pc=".$mess_link;

    $name = "Re: ".$name;
    $description = "\n\n\n\n##########\n
You may need to log into the portal to view this message.

If you are a provider, you may need to become a partner of Cloud Jumbles to log into their portal - they can set such rights.";

    $description .= "\n\n".$mess_link."\n";

    $description .= "\n\n##########

Partners can provide other services within other portals such as SDaaS+AMS for Project and Ticket Management.";

    if ($account_id1_c != NULL){

       $ci_object_type = "ConfigurationItems";
       $ci_action = "select";
       $ci_hostname_id = 'ad2eaca7-8f00-9917-501a-519d3e8e3b35';
       $ci_params[0] = " deleted=0 && account_id_c='".$account_id1_c."' && sclm_configurationitemtypes_id_c='".$ci_hostname_id."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
              #$ci_id = $ci_items[$cnt]['id'];
              $provider_hostname = $ci_items[$cnt]['name'];

              } # for

          if ($provider_hostname != NULL){

             $mess_link = "Body@".$lingo."@ServicesPrices@view@".$relval."@ServicesPrices";
             $mess_link = $funky_gear->encrypt($mess_link);
             $mess_link = "http://".$provider_hostname."/?pc=".$mess_link;

             $description .= "You may also log into your own portal and check your messages.
\n\n".$mess_link."\n";

             } # provider_hostname

          } # is array
       
       } # if ci_account_id_c != NULL

   break; //  Ticketing
   case 'ServicesPrices':
   
    $sclm_ticketing_id_c = $relval;

    $ticket_object_type = "ServicesPrices";
    $ticket_action = "select";
    $ticket_params[0] = "id='".$relval."' ";
    $ticket_params[1] = "id,name,account_id_c"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = ""; // order;
    $ticket_params[4] = ""; // limit
    $ticket_params[5] = $lingoname; // lingo
 
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           #$id = $ticket_items[$cnt]["id"];
           $account_id1_c = $ticket_items[$cnt]['account_id_c'];
           $name = $ticket_items[$cnt]['name'];
           #$sdm_confirmed = $ticket_items[$cnt]['sdm_confirmed'];
           #$billing_count = $ticket_items[$cnt]['billing_count'];
           #$service_operation_process = $ticket_items[$cnt]['service_operation_process'];
           #$sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];

           }  // end for

       }  // is array

    $mess_link = "Body@".$lingo."@ServicesPrices@view@".$relval."@ServicesPrices";
    $mess_link = $funky_gear->encrypt($mess_link);
    $mess_link = "http://".$hostname."/?pc=".$mess_link;

    $name = "Re: ".$name;
    $description = "\n\n\n\n##########\n
You may need to log into the portal to view this message.

If you are a provider, you may need to become a partner of Cloud Jumbles to log into their portal - they can set such rights.";

    $description .= "\n\n".$mess_link."\n";

    $description .= "\n\n##########

Partners can provide other services within other portals such as SDaaS+AMS for Project and Ticket Management.";

    if ($account_id1_c != NULL){

       $ci_object_type = "ConfigurationItems";
       $ci_action = "select";
       $ci_hostname_id = 'ad2eaca7-8f00-9917-501a-519d3e8e3b35';
       $ci_params[0] = " deleted=0 && account_id_c='".$account_id1_c."' && sclm_configurationitemtypes_id_c='".$ci_hostname_id."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
              #$id = $ci_items[$cnt]['id'];
              $provider_hostname = $ci_items[$cnt]['name'];

              } # for

          if ($provider_hostname != NULL){

             $mess_link = "Body@".$lingo."@ServicesPrices@view@".$relval."@ServicesPrices";
             $mess_link = $funky_gear->encrypt($mess_link);
             $mess_link = "http://".$provider_hostname."/?pc=".$mess_link;

             $description .= "You may also log into your own portal and check your messages.
\n\n".$mess_link."\n";

             } # provider_hostname

          } # is array
       
       } # if ci_account_id_c != NULL

   break; //  ServicesPrices

  } // related

  switch ($action){
   
   case 'list':
   
    ################################
    # List


    #echo "Params: ".$object_return_params[0]."<P>";
    
    echo "<div style=\"".$divstyle_grey."\"><center><font size=3><B>".$strings["Messages"]."</B></font></center></div>";
    echo "<center><img src=images/icons/MessagesIcon-100x100.png alt='".$strings["Messages"]."'></center>";

    $mess_object_type = 'Messages';
    $mess_action = "select";
    $mess_params[0] = $object_return_params[0];
    $mess_params[1] = ""; // select array
    $mess_params[2] = ""; // group;
    $mess_params[3] = " date_entered DESC "; // order;
    $mess_params[4] = ""; // limit
  
    $mess = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mess_object_type, $mess_action, $mess_params);

    if (is_array($mess)){

       $count = count($mess);
       $page = $_POST['page'];
       $glb_perpage_items = 30;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $mess_params[4] = " $lfrom , $glb_perpage_items "; 

       $mess = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mess_object_type, $mess_action, $mess_params);

       for ($cnt=0;$cnt < count($mess);$cnt++){

           $id = $mess[$cnt]['id'];
           $date_entered = $mess[$cnt]['date_entered'];
           $date_modified = $mess[$cnt]['date_modified'];
           $modified_user_id = $mess[$cnt]['modified_user_id'];
           $created_by = $mess[$cnt]['created_by'];

           $name = $mess[$cnt]['name'];
           $description = $mess[$cnt]['description'];

           $deleted = $mess[$cnt]['deleted'];
           $assigned_user_id = $mess[$cnt]['assigned_user_id'];
           $contact_id_c = $mess[$cnt]['contact_id_c'];

           if ($contact_id_c != $sess_contact_id){
              $contact_id_c_returner = $funky_gear->object_returner ("Contacts",$contact_id_c);
              $sender = $contact_id_c_returner[0];
              }

           $account_id_c = $mess[$cnt]['account_id_c'];
           $project_id_c = $mess[$cnt]['project_id_c'];
           $projecttask_id_c = $mess[$cnt]['projecttask_id_c'];
           $contact_id1_c = $mess[$cnt]['contact_id1_c'];

           if ($contact_id1_c != $sess_contact_id){
              $contact_id1_c_returner = $funky_gear->object_returner ("Contacts",$contact_id1_c);
              $sender = $contact_id1_c_returner[0];
              }

           $account_id1_c = $mess[$cnt]['account_id1_c'];
           $sclm_messages_id_c = $mess[$cnt]['sclm_messages_id_c'];
           $has_been_read = $mess[$cnt]['has_been_read'];
           $has_been_replied = $mess[$cnt]['has_been_replied'];

           $child_mess_object_type = 'Messages';
           $child_mess_action = "select";
           $child_mess_params[0] = " sclm_messages_id_c='".$id."' ";
           $child_mess_params[1] = ""; // select array
           $child_mess_params[2] = ""; // group;
           $child_mess_params[3] = ""; // order;
           $child_mess_params[4] = ""; // limit
  
           $child_mess = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $child_mess_object_type, $child_mess_action, $child_mess_params);

           $child_count = "";
           if (is_array($child_mess)){
              $child_count = count($child_mess);
              } else {
              $child_count = 0;
              } 
/*
           if ($mess[$cnt][$lingoname] != NULL){
              $name = $mess[$cnt][$lingoname];
              }
*/

//           $cmn_languages_id_c = $mess[$cnt]['cmn_languages_id_c'];
           $cmn_statuses_id_c = $mess[$cnt]['cmn_statuses_id_c'];

           if ($sess_contact_id != NULL && $sess_contact_id==$contact_id_c){
  //            $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $message_icon = "";

           if ($has_been_replied){
              $message_icon = "<img src=images/icons/bar_close.gif width=16>";
              }

           if ($has_been_read){
              $message_icon .= "<img src=images/icons/pagesel.gif width=16>";
              } else {
              $message_icon .= "<img src=images/icons/page.gif width=16>";
              }

           $messages .= "<div style=\"".$divstyle_white."\"> ".$edit."
Date: ".$date_entered."<BR>
Replies: ".$child_count."<BR>
From: ".$sender."<BR>";

           if ($sendiv == 'lightform'){
              $messages .= $message_icon." Subject: <a href=\"#Top\" onClick=\"loader('".$sendiv."');document.getElementById('".$sendiv."').style.display='block';doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."&sendiv=".$sendiv."');document.getElementById('fade').style.display='block';return false\"><B>".$name."</B></a></div>";
              } else {
              $messages .= $message_icon." Subject: <a href=\"#Top\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."&sendiv=".$sendiv."');return false\"><B>".$name."</B></a></div>";
              }
           } // end for

       } else { // end if array

       $messages = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL && $valtype == 'Messages' && $val != NULL){    
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$sendiv."');document.getElementById('".$sendiv."').style.display='block';doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."&sendiv=".$sendiv."');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$strings["MessageReply"]."</B></font></a></div>";
       }

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    if (count($mess)>10){
       echo $addnew.$messages.$addnew;
       } else {
       echo $messages.$addnew;
       }
   
    echo $navi;

    # echo "<img src=images/blank.gif width=90% height=1><BR>";
    # $this->funkydone ($_POST,$lingo,'Content','view','b48bd8cb-33bc-66b8-1aa5-525477be579a','Projects',$bodywidth);

   break; // end list
   # End List
   ################################
   # End List
   case 'share':
   case 'add':
   case 'edit':
   case 'view':

   # if ($sendiv == 'lightform'){
   #    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
   #    }

    if ($action == 'edit' || $action == 'view'){ 

       $mess_object_type = $do;
       $mess_action = "select";
       $mess_params[0] = " id='".$val."' ";
       $mess_params[1] = ""; // select array
       $mess_params[2] = ""; // group;
       $mess_params[3] = ""; // order;
       $mess_params[4] = ""; // limit
  
       $mess = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mess_object_type, $mess_action, $mess_params);

       if (is_array($mess)){

          for ($cnt=0;$cnt < count($mess);$cnt++){

              $id = $mess[$cnt]['id'];
              $name = $mess[$cnt]['name'];
              $date_entered = $mess[$cnt]['date_entered'];
              $date_modified = $mess[$cnt]['date_modified'];
              $modified_user_id = $mess[$cnt]['modified_user_id'];
              $created_by = $mess[$cnt]['created_by'];
              $description = $mess[$cnt]['description'];
              $deleted = $mess[$cnt]['deleted'];
              $assigned_user_id = $mess[$cnt]['assigned_user_id'];
              $contact_id_c = $mess[$cnt]['contact_id_c'];
              $account_id_c = $mess[$cnt]['account_id_c'];
              $contact_id1_c = $mess[$cnt]['contact_id1_c'];
              $account_id1_c = $mess[$cnt]['account_id1_c'];
              $project_id_c = $mess[$cnt]['project_id_c'];
              $projecttask_id_c = $mess[$cnt]['projecttask_id_c'];
//              $cmn_languages_id_c = $mess[$cnt]['cmn_languages_id_c'];
              $cmn_statuses_id_c = $mess[$cnt]['cmn_statuses_id_c'];
              $sclm_messages_id_c = $mess[$cnt]['sclm_messages_id_c'];
              $has_been_read = $mess[$cnt]['has_been_read'];
              $has_been_replied = $mess[$cnt]['has_been_replied'];
   
              } // end for projects

          $field_lingo_pack = $funky_gear->lingo_data_pack ($mess, $name, $description, $name_field_base,$desc_field_base);

          } // is array

       } // if action

    $tblcnt = 0;

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
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "value"; // Field Name
    $tablefields[$tblcnt][1] = "value"; // Full Name
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
    $tablefields[$tblcnt][21] = $val; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "valuetype"; // Field Name
    $tablefields[$tblcnt][1] = "valuetype"; // Full Name
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

    if ($action == 'add' && $sclm_messages_id_c != NULL){

       $mess_object_type = 'Messages';
       $mess_action = "select";
       $mess_params[0] = " id='".$sclm_messages_id_c."' ";
       $mess_params[1] = ""; // select array
       $mess_params[2] = ""; // group;
       $mess_params[3] = ""; // order;
       $mess_params[4] = ""; // limit
  
       $mess = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mess_object_type, $mess_action, $mess_params);
 
       if (is_array($mess)){

          for ($cnt=0;$cnt < count($mess);$cnt++){
/*
              $id = $mess[$cnt]['id'];
              $date_entered = $mess[$cnt]['date_entered'];
              $date_modified = $mess[$cnt]['date_modified'];
              $modified_user_id = $mess[$cnt]['modified_user_id'];
              $created_by = $mess[$cnt]['created_by'];
*/
              $name = $mess[$cnt]['name'];
              $name = "Re: ".$name;

              $description = $mess[$cnt]['description'];
              $description = "\n\n\nOriginal Message\n\n".$description;

/*              $deleted = $mess[$cnt]['deleted'];
              $assigned_user_id = $mess[$cnt]['assigned_user_id'];
*/
              $contact_id1_c = $mess[$cnt]['contact_id_c'];
              $account_id1_c = $mess[$cnt]['account_id_c'];

              $project_id_c = $mess[$cnt]['project_id_c'];
              $projecttask_id_c = $mess[$cnt]['projecttask_id_c'];

              $contact_id_c = $mess[$cnt]['contact_id1_c'];
              $account_id_c = $mess[$cnt]['account_id1_c'];


//              $sclm_messages_id_c = $mess[$cnt]['sclm_messages_id_c'];
//              $has_been_read = $mess[$cnt]['has_been_read'];
//              $has_been_replied = $mess[$cnt]['has_been_replied'];

/*
              if ($mess[$cnt][$lingoname] != NULL){
                 $name = $mess[$cnt][$lingoname];
                 } 
*/
   //           $cmn_languages_id_c = $mess[$cnt]['cmn_languages_id_c'];
              $cmn_statuses_id_c = $mess[$cnt]['cmn_statuses_id_c'];

              } // end for

          } // if array

       } elseif ($action == 'add' && $sclm_messages_id_c == NULL){ # new message

       if ($account_id_c == NULL){
          $account_id_c = $sess_account_id;
          }

       if ($contact_id_c == NULL){
          $contact_id_c = $sess_contact_id;
          }

       } # else


    #echo "sclm_messages_id_c $sclm_messages_id_c <P>";

    if ($action == 'add' || $action == 'edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sclm_messages_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentMessage"]; // Full Name
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
       $tablefields[$tblcnt][20] = "sclm_messages_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_messages_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "has_been_read"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Read"]; // Full Name
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
       $tablefields[$tblcnt][20] = "has_been_read"; //$field_value_id;
       $tablefields[$tblcnt][21] = $has_been_read; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "has_been_replied"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Replied"]; // Full Name
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
       $tablefields[$tblcnt][20] = "has_been_replied"; //$field_value_id;
       $tablefields[$tblcnt][21] = $has_been_replied; //$field_value;   

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sclm_messages_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentMessage"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_messages'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $sclm_messages_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = '';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "sclm_messages_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_messages_id_c; //$field_value;   

       }

    if ($action == 'view' && ($contact_id1_c == $sess_contact_id || $account_id1_c == $sess_account_id)){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $val);
       $process_params[] = array('name'=>'has_been_read','value' => "1");

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          //echo "Read: ".$result['id'];
          }

       $tblcnt++;

       $tablefields[$tblcnt][0] = "has_been_read"; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageRead"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "has_been_read"; //$field_value_id;
       $tablefields[$tblcnt][21] = "1"; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "has_been_replied"; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageReplied"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "has_been_replied"; //$field_value_id;
       $tablefields[$tblcnt][21] = $has_been_replied; //$field_value;   

       }

/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_statuses_id_c'; // Field Name
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
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue
*/

    if ($action == 'add'){

       switch ($valtype){

        case "Effects":

         $sn_par_returner = $funky_gear->object_returner ("Events", $val);
         $event_name = $sn_par_returner[0];
         $name = "Check out the Event, '".$event_name."', and let's collaborate on ".$portal_title;
         $description = "\nI would like to invite you to the Event, '".$event_name."', and collaborate on ".$portal_title."\n";

        break;
        case "SocialNetworking":

         # val = $sn_parent_id = wrapper for the SN based on the CIT (Cat)
         $sn_par_returner = $funky_gear->object_returner ("ConfigurationItems", $val);
         $sn_cat_id = $sn_par_returner[0];
         $sn_cat_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_cat_id);
         $sn_cat_name = $sn_cat_returner[0];
         $name = "Check out the Social Network, '".$sn_cat_name."', and let's collaborate on ".$portal_title;
         $description = "\nI would like to invite you to the Social Network, '".$sn_cat_name."', and collaborate on ".$portal_title."\n";

        break;
        case "HirorinsTimer":

         $name = "Check out my 'Hirorin Timer', and let's collaborate on ".$portal_title;
         $description = "\nI would like to invite you to my 'Hirorin Timer', and collaborate on ".$portal_title."\n";

        break;

        } # switch valtype

       } # if add

    if ($action == 'add' || $action == 'view'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "name"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Subject"]." *"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   
   
       } # if add/view

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'message_lingo'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Language"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
  
    for ($x=0;$x<count($lingos);$x++) {

        $extension = $lingos[$x][0][0][0][0][0][0];
        $language = $lingos[$x][1][1][0][0][0][0];
/*
        $languages = $lingos[$x][1][1][1][0][0][0];
        $lingo_id = $lingos[$x][1][0][0][0][0][0];
        $image = $lingos[$x][1][1][1][1][0][0];
        $int = $lingos[$x][1][1][1][1][1][0];
        $pagebit = $lingos[$x][1][1][1][1][1][1];
*/
        $lingoddpack[$extension]=$language;

        }

    $tablefields[$tblcnt][9][1] = $lingoddpack;
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";
    $tablefields[$tblcnt][9][5] = $lingo; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'message_lingo';//$field_value_id;
    $tablefields[$tblcnt][21] = $lingo; //$field_value;   

    if ($valtype == 'Contacts'){

       #Contacts are internal and don't need extra recipients - maybe...
       $tblcnt++;

       $tablefields[$tblcnt][0] = "recipient_types"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Replied"]; // Full Name
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
       $tablefields[$tblcnt][20] = "recipient_types"; //$field_value_id;
       $tablefields[$tblcnt][21] = '12db0c6d-cc58-cbef-c092-555ad724ebd7'; //$field_value;   

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'recipient_types'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Recipients"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       # Provide available share options
       $dd_pack = $funky_messaging->message_recipient_selections();

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // Exceptions
       $tablefields[$tblcnt][9][5] = $recipient_types; // Current Value
       $tablefields[$tblcnt][9][6] = ""; // Current Value
       $tablefields[$tblcnt][9][7] = "recipient_types"; // reltable
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $recipient_types; // Field ID
       $tablefields[$tblcnt][20] = "recipient_types"; //$field_value_id;
       $tablefields[$tblcnt][21] = $recipient_types; //$field_value;     

       } # end if not sending to contact

    /*
    $tblcnt++;

    $tablefields[$tblcnt][0] = "extra_addressees"; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailExtraAddressees"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $extra_addressees; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "extra_addressees"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_addressees; //$field_value;   
    */

    if ($auth == 3 || $action == 'view'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'account_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageSenderAccount"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " account_id_c='".$portal_account_id."' ";
       $acc_params[1] = " account_id_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id_c "; // order;
       $acc_params[4] = ""; // limit
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $child_account_id = $acc_items[$acc_cnt]['child_account_id'];
              $child_account_name = $acc_items[$acc_cnt]['child_account_name'];
              $ddpack[$child_account_id]=$child_account_name;

              }
          }

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " account_id1_c='".$portal_account_id."' ";
       $acc_params[1] = " account_id1_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id1_c "; // order;
       $acc_params[4] = ""; // limit
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $parent_account_id = $acc_items[$acc_cnt]['parent_account_id'];
              $parent_account_name = $acc_items[$acc_cnt]['parent_account_name'];
              $ddpack[$parent_account_id]=$parent_account_name;

              }
          }

       // Include current
       $acc_returner = $funky_gear->object_returner ("Accounts", $account_id_c);
       $account_name = $acc_returner[0];
       $sender_pack = $ddpack;
       $sender_pack[$account_id_c]=$account_name;

       $tablefields[$tblcnt][9][1] = $sender_pack;
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";
       $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'contact_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageSender"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       if (is_array($sender_pack)){

          foreach ($sender_pack as $parent_account_id => $parent_account_name){
            
                  $acc_object_type = "Accounts";
                  $acc_action = "select_contacts";
                  $acc_params[0] = " account_id='".$parent_account_id."' ";
                  $acc_params[1] = ""; // select array
                  $acc_params[2] = ""; // group;
                  $acc_params[3] = "";
                  $acc_params[4] = ""; // 
  
                  $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

                  if (is_array($acc_items)){

                     for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

                         $contact_id = $acc_items[$acc_cnt]['contact_id'];
                         $first_name = $acc_items[$acc_cnt]['first_name'];
                         $last_name = $acc_items[$acc_cnt]['last_name'];
                         $conpack[$contact_id] = $parent_account_name." -> ".$first_name." ".$last_name;

                         } // for

                     } // if


                  } //for each

          } // is array


       $tablefields[$tblcnt][9][1] = $conpack; // 
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "firstlast";
       $tablefields[$tblcnt][21] = $contact_id_c;
       $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageRecipientAccount"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       // Include current
       $acc_returner = $funky_gear->object_returner ("Accounts", $account_id1_c);
       $recipient_account_name = $acc_returner[0];
       $recipient_pack = $ddpack;
       $recipient_pack[$account_id1_c]=$recipient_account_name;

       $tablefields[$tblcnt][9][1] = $recipient_pack;
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";
       $tablefields[$tblcnt][9][5] = $account_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id1_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageRecipient"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       if (is_array($recipient_pack)){

          foreach ($recipient_pack as $parent_account_id => $parent_account_name){
            
                  $acc_object_type = "Accounts";
                  $acc_action = "select_contacts";
                  $acc_params[0] = " account_id='".$parent_account_id."' ";
                  $acc_params[1] = ""; // select array
                  $acc_params[2] = ""; // group;
                  $acc_params[3] = "";
                  $acc_params[4] = ""; // 
  
                  $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

                  if (is_array($acc_items)){

                     for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

                         $contact_id = $acc_items[$acc_cnt]['contact_id'];
                         $first_name = $acc_items[$acc_cnt]['first_name'];
                         $last_name = $acc_items[$acc_cnt]['last_name'];
                         $recipient_conpack[$contact_id] = $parent_account_name." -> ".$first_name." ".$last_name;

                         } // for

                     } // if


                  } //for each

          } // is array


       $tablefields[$tblcnt][9][1] = $recipient_conpack; // 
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][5] = $contact_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "firstlast";
       $tablefields[$tblcnt][21] = $contact_id1_c;
       $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

       }

//    if ($action == 'view' || $action == 'add'){
/*
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
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][9][1] = "accounts_contacts,accounts,contacts";
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = "firstlast";
       $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id && accounts_contacts.account_id='".$account_id_c."' && accounts.id='".$account_id_c."' "; // exception
       $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][9][20] = "contacts.id,CONCAT(accounts.name,' - ',contacts.first_name,' ',contacts.last_name) as firstlast";
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["RecipientAccount"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $account_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id1_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["RecipientUser"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'accounts_contacts,accounts,contacts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'firstlast';

       if ($account_id1_c != NULL){
          $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id && accounts_contacts.account_id='".$account_id1_c."' && accounts.id='".$account_id1_c."' "; // exception
          } else {
          $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id &&  accounts_contacts.account_id=accounts.id "; // exception
          }

       $tablefields[$tblcnt][9][5] = $contact_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][9][20] = "contacts.id,CONCAT(accounts.name,' - ',contacts.first_name,' ',contacts.last_name) as firstlast";
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id1_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id1_c; //$field_value;   
*/
       

    if ($auth<3 && ($action == 'add' || $action == 'edit')){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id1_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "account_id1_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $account_id1_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "contact_id1_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "contact_id1_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id1_c; //$field_value;   

       }

    if ($action == 'add' || $action == 'edit'){

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

       }

//    if ($action == 'view'){
/*
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
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

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
//       $tablefields[$tblcnt][9][1] = "accounts_contacts,accounts,contacts";
       $tablefields[$tblcnt][9][1] = "contacts";
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = "firstlast";
//       $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id && accounts_contacts.account_id='".$account_id_c."' && accounts.id='".$account_id_c."' "; // exception
       $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][9][20] = "";
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageRecipientAccount"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $account_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id1_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MessageRecipient"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
//       $tablefields[$tblcnt][9][1] = 'accounts_contacts,accounts,contacts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][1] = 'contacts';
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'first_name';

       if ($account_id1_c != NULL){
          $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id && accounts_contacts.account_id='".$account_id1_c."' && accounts.id='".$account_id1_c."' "; // exception
          } else {
          $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id &&  accounts_contacts.account_id=accounts.id "; // exception
          }

       $tablefields[$tblcnt][9][5] = $contact_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
//       $tablefields[$tblcnt][9][20] = "contacts.id,CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast";
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id1_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id1_c; //$field_value;   

       }
*/

    if ($action == 'add' || $action == 'view'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "description"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Message"]." *"; // Full Name
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

       }

    if ($action == 'edit'){

       ################################
       # Loop for allowed languages

       for ($x=0;$x<count($field_lingo_pack);$x++) {

           $name_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0];
           $desc_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0];

           $name_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0];
           $desc_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1];

           $language = $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0];

           $tblcnt++;

           $tablefields[$tblcnt][0] = $name_field; // Field Name
           $tablefields[$tblcnt][1] = $strings["Subject"]." (".$language.")"; // Full Name
           $tablefields[$tblcnt][2] = 0; // is_primary
           $tablefields[$tblcnt][3] = 0; // is_autoincrement
           $tablefields[$tblcnt][4] = 1; // is_name
           $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$tblcnt][6] = '100'; // length
           $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = '1';//1; // show in view 
           $tablefields[$tblcnt][11] = $name_content; // Field ID
           $tablefields[$tblcnt][20] = $name_field;//$field_value_id;
           $tablefields[$tblcnt][21] = $name_content; //$field_value; 

           $tblcnt++;

           $tablefields[$tblcnt][0] = $desc_field; // Field Name
           $tablefields[$tblcnt][1] = $strings["Message"]." (".$language.")"; // Full Name
           $tablefields[$tblcnt][2] = 0; // is_primary
           $tablefields[$tblcnt][3] = 0; // is_autoincrement
           $tablefields[$tblcnt][4] = 0; // is_name
           $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
           $tablefields[$tblcnt][6] = '255'; // length
           $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = '1';//1; // show in view 
           $tablefields[$tblcnt][11] = $desc_content; // Field ID
           $tablefields[$tblcnt][20] = $desc_field;//$field_value_id;
           $tablefields[$tblcnt][21] = $desc_content; //$field_value;

           } // end for languages

       } // end if edit

    if ($sendiv){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sendiv"; // Field Name
       $tablefields[$tblcnt][1] = "sendiv"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '20'; //length
       $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sendiv; //$field_value;

       }

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if ($sess_contact_id != NULL){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       }

    $valpack[5] = ""; // provide add new button
    $valpack[7] = $strings["Send"]; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    #
    ###################
    #

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    if ($val != NULL){

       switch ($valtype){

        case 'Effects':
 
         $this_returner = $funky_gear->object_returner ("Effects", $val);
         $object_return_name = $this_returner[0];
         $object_return = $this_returner[1];
         $object_return_title = $this_returner[2];
         $object_return_target = $this_returner[3];      
         $container_title = "Share the ".$object_return_name." Shared Effects Event";

         $extra_content = "<div style=\"".$divstyle_white."\"><font size=2>Make sure the event's permissions are correctly set (Open/Closed/Anonymous/Open for Social Networks) before sharing with others. </font></div><BR><img src=images/blank.gif width=98% height=1><BR>";

        break;
        case 'Contacts':
 
         $anon_params[0] = $val; # Content owner
         $anon_params[1] = $account_owner; # account_owner
         $anon_params[2] = $sess_contact_id; #contact_viewer
         $anon_params[3] = $sess_account_id; #account_viewer
         $anon_params[4] = $do;
         $anon_params[5] = $valtype;
         $show_namer = $funky_gear->anonymity($anon_params);

         $show_name = $show_namer[0];
         $show_description = $show_namer[1];
         $profile_photo = $show_namer[2];

         if ($show_description != NULL){
            $contact_description = str_replace("\n", "<br>", $show_description);
            }

         if (!$profile_photo){
            $profile_photo = "images/profile_photo_default.png";
            }

         $extra_content = "<div style=\"".$divstyle_white."\"><center><img src=".$profile_photo." width=150px></center></div><div style=\"".$divstyle_white."\"><font size=3><B>Profile Name</B>:</font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$val."&valuetype=Contacts');return false\"><B><font color=#151B54><font size=3>".$show_name."</font></B></a><font size=2>".$contact_description."</font></div><BR><img src=images/blank.gif width=98% height=1><BR>";   

         $container_title = "Send a message to ".$show_name."!";

        break;
        case 'Ticketing':

         $extra_content = "<div style=\"".$divstyle_white."\"><center><img src=".$profile_photo." width=150px></center></div><div style=\"".$divstyle_white."\"><font size=3><B>Ticketing</B>:</font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=view&value=".$val."&valuetype=Messages');return false\"><B><font color=#151B54><font size=3>View Ticket</font></B></a><font size=2>".$contact_description."</font></div><BR><img src=images/blank.gif width=98% height=1><BR>";   

         $container_title = "Send a message to ".$show_name."!";         

        break;

       } # switch

       } else { # if

       $container_title = "Send a Message!";       

       } # if

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $container_title; // container_title
    $container_params[4] = 'Message'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

/*
    $returner = $funky_gear->object_returner ('Accounts', $account_id_c);
    $object_return = $returner[1];
    echo $object_return;
*/

    if ($sclm_messages_id_c){
       $returner = $funky_gear->object_returner ('Messages', $sclm_messages_id_c);
       $object_return = $returner[1];
       echo $object_return;
       }

    if ($val && $valtype == 'Messages' && $sclm_messages_id_c == NULL){
       $returner = $funky_gear->object_returner ('Messages', $val);
       $object_return = $returner[1];
       echo $object_return;
       }

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";  
       }

    echo $container_top;
    echo $extra_content;
    echo $zaform;
    echo $container_bottom;

    #
    ###################
    #

    if ($action == 'view' || $action == 'edit' ){ 

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["Messages"]; // container_title
       $container_params[4] = 'RelatedMessages'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'Messages','list',$val,$do,$bodywidth);       
   
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["Content"]; // container_title
       $container_params[4] = 'Content'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);       

       echo $container_bottom;

       }

    if (($action == 'view' || $action == 'view') && $project_id_c != NULL){ 

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["RelatedProjects"]; // container_title
       $container_params[4] = 'RelatedProjects'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'Projects','list',$project_id_c,$do,$bodywidth);       

       echo $container_bottom;

       }

    #
    ###################

   break; // end view
   case 'process':

    $sendiv = $_POST['sendiv'];

    if (!$_POST['name']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Subject"]."</font><P>";
       }   

    if (!$_POST['description']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Message"]."</font><P>";
       }   

    if (!$error){

       # Determine which kind of link to send - SN, Message, Effect

       $message_title = $_POST['name'];
       $message_body = $_POST['description'];

       switch ($valtype){

        case 'SocialNetworking':

         $message_link = "Body@".$lingo."@SocialNetworking@share@".$val."@SocialNetworking";
         $message_link = $funky_gear->encrypt($message_link);
         $message_link = "https://".$hostname."/?pc=".$message_link;

         # Collect an image based on valtype
         $message_image = "https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-SocialNetworks-500x500.png";

         $message_body .= "\n\nShared Effects provides a unique Social Networking service that allows you to manage events, sub-events and content around important areas in your lifestyle. Instead of just a person-to-person networking model, this way allows you to enter into any area of lifestyle that interests you and begin networking and collaborating - or just sharing information and content. Put together with Shared Effects, this is a very powerful way to manage your true lifeline of events around your lifestyle.\n\n";

        break;
        case 'Effects':

         $message_link = "Body@".$lingo."@Effects@view@".$val."@Effects";
         $message_link = $funky_gear->encrypt($message_link);
         $message_link = "https://".$hostname."/?pc=".$message_link;

         $message_image = "https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-100x100.png";

         $message_body .= "\n\nShared Effects is a new type of Social Collaboration service that allows you to manage events and sub-events that matter in your life. Just like evolution - we are the result of all that occured before us - and now you have a way to manage the path you have taken and the path you will take - collaboratively; with friends, family, colleagues and/or the general public.\n\n";

        break;
        case 'Messages':

         $message_link = "Body@".$lingo."@Messages@view@".$val."@Messages";
         $message_link = $funky_gear->encrypt($message_link);
         $message_link = "https://".$hostname."/?pc=".$message_link;

         $message_image = "https://".$hostname."/images/AlbertEinsteinHead.png"; #$image;

         $message_body .= "\n\nThis message is contained within the ".$portal_title." service and may require registration and log in to view and reply.\n\n";

        break;
        case 'HirorinsTimer':

         $message_link = "Body@".$lingo."@HirorinsTimer@view@".$val."@Messages";
         $message_link = $funky_gear->encrypt($message_link);
         $message_link = "https://".$hostname."/?pc=".$message_link;

         $message_image = "https://".$hostname."/images/AlbertEinsteinHead.png"; #$image;

         $message_body .= "\n\nThis message is contained within the ".$portal_title." service and may require registration and log in to view and reply.\n\n";

        break;
        case 'LifePlanning':

         $message_link = "Body@".$lingo."@LifePlanning@view@".$val."@Messages";
         $message_link = $funky_gear->encrypt($message_link);
         $message_link = "https://".$hostname."/?pc=".$message_link;

         $message_image = "https://".$hostname."/images/AlbertEinsteinHead.png"; #$image;

         $message_body .= "\n\nThis message is contained within the ".$portal_title." service and may require registration and log in to view and reply.\n\n";

         # bca0aabe-0755-2cc8-f1fd-557538042d7d

        break;

       } # end message link type switch

       $message_body .= "\n\nPlease access via the following link:\n\n";
       $message_body .= $message_link;

       # Check for additional recipients for Google/FB/LinkedIn

       $msg_params[0] = $_POST;
       $msg_params[1] = $message_title;
       $msg_params[2] = $message_body;
       $msg_params[3] = $message_link;
       $msg_params[4] = $message_image;
       $msg_params[5] = $do;
       $msg_params[6] = $action;
       $msg_params[7] = $valtype;
       $msg_params[8] = $val;
       $msg_params[9] = ""; # Extra params - used by Effects event-sharing recipients

       $message_results = $funky_messaging->message_delivery ($msg_params);

       $process_message = $strings["SubmissionSuccess"]."<P>";

       $message_id = $message_results[0];
       $emailresult = $message_results[1];

       $process_message .= "<BR>".$emailresult;

       $process_message .= "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."&sendiv=".$sendiv."');return false\"> ".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Subject"].":</B> ".$_POST['name']."<BR>";
       $process_message .= "<B>".$strings["Message"].":</B> ".$_POST['description']."<BR>".$strings["EmailExtraAddressees"].": ".$extra_addressees."<BR>";

       echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else {

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       } 

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>