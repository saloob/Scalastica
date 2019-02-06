<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Messages.php 
##########################################################
# case 'Messages':

  $sendiv = $_POST['sendiv'];
  if ($sendiv != NULL){
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
    $ticket_params[1] = "id,name,account_id2_c"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = ""; // order;
    $ticket_params[4] = ""; // limit
    $ticket_params[5] = $lingoname; // lingo
 
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           #$id = $ticket_items[$cnt]["id"];
           $account_id1_c = $ticket_items[$cnt]['account_id2_c'];
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
From: ".$sender."<BR>
".$message_icon." Subject: <a href=\"#Top\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."&sendiv=light');document.getElementById('fade').style.display='block';return false\"><B>".$name."</B></a></div>";


           } // end for

       } else { // end if array

       $messages = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL && $valtype == 'Messages' && $val != NULL){    
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."&sendiv=light');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$strings["MessageReply"]."</B></font></a></div>";
       }

    if ($sendiv == 'light'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    if (count($mess)>10){
       echo $addnew.$messages.$addnew;
       } else {
       echo $messages.$addnew;
       }
   
    echo $navi;

//    echo "<img src=images/blank.gif width=90% height=1><BR>";
//    $this->funkydone ($_POST,$lingo,'Content','view','b48bd8cb-33bc-66b8-1aa5-525477be579a','Projects',$bodywidth);

    # End List
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

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

  //  if ($action == 'add' || $action == 'view'){
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
   
       }

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
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "extra_addressees"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_addressees; //$field_value;   

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
       $tablefields[$tblcnt][21] = "light"; //$field_value;

       }

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if ($contact_id_c != NULL && $contact_id_c == $sess_contact_id && $sess_contact_id != NULL){
//       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
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

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings['Message']; // container_title
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


    echo $container_top;

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";  

    if ($valtype == 'Contacts'){

       $object_type = "Contacts";
       $api_action = "select_soap";
       $params = array();
       $params[0] = "contacts.id='".$val."'"; // query
       $params[1] = array("first_name","last_name","description","email1");

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $params);

       if (is_array($result)){

          for ($cnt=0;$cnt < count($result);$cnt++){

              $first_name = $result[$cnt]['first_name'];
              $last_name = $result[$cnt]['last_name'];
              $description = $result[$cnt]['description'];
              $email = $result[$cnt]['email1'];
//              $twitter_name_c = $result[$cnt]['twitter_name_c'];

              } // end for

          } // end is array

       $anon_params[0] = $val;
       $show_names = $funky_gear->anonymity($anon_params);
       $show_name = $show_names['default_name'];
       $anonymity = $show_names['default_name_anonymity'];

       // Future: Check to see if friend if sess_contact_id_c not contact_id_c
       switch ($anonymity){
        case '':
        case $anonymity_Anonymous:
//         $show_name = $strings["Anonymous"];
        break;
        case $anonymity_Fullname: // Full Name

         $object_type = 'Contacts';
         $api_action = 'select_cstm';
         $params = array();
         $params[0] = "id_c='".$val."'";
         $params[1] =  "id_c,password_c,twitter_name_c,twitter_password_c,linkedin_name_c,nickname_c,cloakname_c,profile_photo_c";
         $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $api_action, $params);
    
         if (is_array($the_list)){
      
            for ($cnt=0;$cnt < count($the_list);$cnt++){

//              $source_id_c = $the_list[$cnt]['source_id_c'];
                $password_c = $the_list[$cnt]['password_c'];
                $twitter_name_c = $the_list[$cnt]['twitter_name_c'];
                $twitter_password_c = $the_list[$cnt]['twitter_password_c'];
                $linkedin_name_c = $the_list[$cnt]['linkedin_name_c'];
                $nickname = $the_list[$cnt]['nickname_c'];
                $cloakname = $the_list[$cnt]['cloakname_c'];
                $profile_photo = $the_list[$cnt]['profile_photo_c'];

                } // end for
      
            } // end if array

        break;
        case $anonymity_Nickname: // Nickname
//         $show_name = $nickname;
        break;
        case $anonymity_Cloakname: // Cloakname
//         $show_name = $cloakname;
        break;

       } # end switch

       $contact_description = str_replace("\n", "<br>", $description);

       if (!$profile_photo){
          $profile_photo = "images/profile_photo_default.png";
          }

       $contact_profile .="<div style=\"".$divstyle_white."\"><center><img src=".$profile_photo." width=80%></center><P><font size=3><B>Profile Name</B>:</font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$val."&valuetype=Contacts');return false\"><B><font color=#151B54><font size=3>".$show_name."</font></font></B></a><P><font size=2>".$contact_description."</font></div>";

       #$contact = $this->funkydone ($_POST,$lingo,'Contacts','view',$val,'Contacts',$bodywidth);
       #echo "<div style=\"".$divstyle_white."\"><div id=contactdiv name=contactdiv style=\"width:18%;float:left;\">".$contact_profile."</div><div style=\"width:80%;float:left;padding-top:20;\">".$zaform."</div></div>";
       echo "<table width=100% border=1><tr><td width=20% valign=top>".$contact_profile."</td><td width=80%>".$zaform."</td></tr></table>";
       } else {
       $contact_profile = "<center><img src=\"images/profile_photo_default.png\" width=80%></center>";
       echo "<table width=100% border=1><tr><td width=20% valign=top>".$contact_profile."</td><td width=80%>".$zaform."</td></tr></table>";
       #echo "<div style=\"".$divstyle_white."\"><div style=\"width:80%;float:left;padding-top:20;\">".$zaform."</div><div id=contactdiv name=contactdiv style=\"width:18%;float:left;\">Messages</div></div>";
       } 

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

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if (!$_POST['name']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Subject"]."</font><P>";
       }   

    if (!$_POST['description']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Message"]."</font><P>";
       }   

    if (!$error){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       $process_params[] = array('name'=>'assigned_user_id','value' => 1);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
       $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);

       if ($_POST['id'] != $_POST['sclm_messages_id_c'] && $_POST['sclm_messages_id_c'] != NULL && $_POST['id'] != NULL){
          $process_params[] = array('name'=>'sclm_messages_id_c','value' => $_POST['sclm_messages_id_c']);
          }

       $process_params[] = array('name'=>'has_been_read','value' => $_POST['has_been_read']);
       $process_params[] = array('name'=>'has_been_replied','value' => $_POST['has_been_replied']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

       foreach ($_POST as $name_key=>$name_value){

               $name_lingo = str_replace("name_","",$name_key);

               if ($name_lingo != NULL && in_array($name_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$name_key,'value' => $name_value);

                  } // if namelingo

               } // end foreach

       foreach ($_POST as $desc_key=>$desc_value){

               $desc_lingo = str_replace("description_","",$desc_key);

               if ($desc_lingo != NULL && in_array($desc_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$desc_key,'value' => $desc_value);

                  } // if namelingo

               } // end foreach

       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);

       if ($_POST['extra_addressees']!= NULL){
          $process_params[] = array('name'=>'extra_addressees','value' => $_POST['extra_addressees']);
          }

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];

          $this_message_link = "Body@".$lingo."@Messages@view@".$val."@Messages";
          $this_message_link = $funky_gear->encrypt($this_message_link);
          $this_message_link = "http://".$hostname."/?pc=".$this_message_link;

          $type = 1;

          $from_name = $portal_title;
          $from_email = $portal_email;
          $from_email_password = $portal_email_password;

          $contact_object_type = "Contacts";
          $contact_action = "select_soap";
          $contact_params = array();
          $contact_params[0] = "contacts.id='".$_POST['contact_id1_c']."'"; // query
          $contact_params[1] = array("first_name","last_name","email1");

          $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
          for ($cnt=0;$cnt < count($contact_info);$cnt++){

              $first_name = $contact_info[$cnt]['first_name'];
              $last_name = $contact_info[$cnt]['last_name'];
              $to_email = $contact_info[$cnt]['email1'];

              }

          $to_name = $first_name." ".$last_name;

          if ($_POST['message_lingo'] != NULL){
             $lingo = $_POST['message_lingo'];
             echo "Desired Lingo: ".$lingo."<BR>";
             }

          $account_id1_c = $_POST['account_id1_c'];

          if ($ci_account_id_c != NULL){

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

                   $message_link = "Body@".$lingo."@Messages@view@".$val."@Messages";
                   $message_link = $funky_gear->encrypt($message_link);
                   $message_link = "http://".$provider_hostname."/?pc=".$message_link;

                   $message_description = "\n\n############\n\nYou may also log into your own portal and check your messages.
\n\n".$message_link;

                   } # provider_hostname

                } # is array
       
             } # if ci_account_id_c != NULL

          $mailparams[0] = $from_name;
          $mailparams[1] = $to_name;
          $mailparams[2] = $from_email;
          $mailparams[3] = $from_email_password;
          $mailparams[4] = $to_email;
          $mailparams[5] = $type;
          $mailparams[6] = $lingo;
          $mailparams[7] = $_POST['name'];
          $mailparams[8] = $_POST['description']."\n".$strings["action_view_here"].":\n".$this_message_link."\n\n".$message_description;
          $mailparams[9] = $portal_email_server;
          $mailparams[10] = $portal_email_smtp_port;
          $mailparams[11] = $portal_email_smtp_auth;

          $emailresult = $funky_gear->do_email ($mailparams);

          if ($_POST['extra_addressees']!= NULL){

             $extra_addressees = $_POST['extra_addressees'];
             $extra_recipients = explode(",", $extra_addressees);

             foreach ($extra_recipients as $recipient) {

                     $recipient = trim($recipient);

                     $mailparams[0] = $from_name;
                     $mailparams[1] = $recipient;
                     $mailparams[2] = $from_email;
                     $mailparams[3] = $from_email_password;
                     $mailparams[4] = $recipient;
                     $mailparams[5] = $type;
                     $mailparams[6] = $lingo;
                     $mailparams[7] = $_POST['name'];
                     $mailparams[8] = $_POST['description']."\n".$strings["action_view_here"].":\n".$this_message_link."\n\n".$message_description;
                     $mailparams[9] = $portal_email_server;
                     $mailparams[10] = $portal_email_smtp_port;
                     $mailparams[11] = $portal_email_smtp_auth;

                     $emailresult .= $funky_gear->do_email ($mailparams);

                     } // for each recipient

             } // is addressees

          if ($_POST['sclm_messages_id_c'] != NULL && $_POST['has_been_replied']==0){

             $process_params[] = array('name'=>'id','value' => $_POST['sclm_messages_id_c']);
             $process_params[] = array('name'=>'has_been_replied','value' => '1');

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             if ($result['id'] != NULL){
                //echo "Replied: ".$result['id'];
                }

             } // if parent_message

          $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

          $process_message .= "<B>".$strings["Subject"].":</B> ".$_POST['name']."<BR>";
          $process_message .= "<B>".$strings["Message"].":</B> ".$_POST['description']."<BR>".$strings["EmailExtraAddressees"].": ".$_POST['extra_addressees']."<BR>";

          echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

          } else {

          echo "<div style=\"".$divstyle_orange."\">Something Failed - please contact your administrator.</div>";       

          } 

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>