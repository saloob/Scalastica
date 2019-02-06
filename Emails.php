<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Emails.php 
##########################################################
# case 'Emails':

if (!class_exists('funky_filters')){
   include ("funky-filters.php");
   $funky_filters = new funky_filters ();
   }

   ################################
   # Placeholders & Explosions

   # Get placeholders from DB

   $ph_server = '[SERVER]';
   $ph_alert_message = '[ALERT_MESSAGE]';
   $ph_ticketnumber = '[TICKET]';

   # Explosions

   $ex_date = '[DATE]';

   # Placeholders & Explosions
   ################################
   # Shared Access

   if ($action == 'list'){

      if ($portal_account_id != $sess_account_id){

         # They have the rights to log into the portal
         # Do they have the rights to view tickets?

         $sharing_params[0] = $portal_account_id;
         $sharing_params[1] = $sess_account_id;
         $sharing_info = $funky_gear->portal_sharing ($sharing_params);

         $shared_portal_ticketing = $sharing_info['shared_portal_ticketing'];
         $shared_portal_projects = $sharing_info['shared_portal_projects'];
         $shared_portal_slarequests = $sharing_info['shared_portal_slarequests'];
         $shared_portal_slarequest_sql = $sharing_info['shared_portal_slarequest_sql'];
         $shared_portal_emails = $sharing_info['shared_portal_emails'];

         #var_dump($shared_portal_slarequest_sql);
         #echo "<P>shared_portal_ticketing: ".$shared_portal_ticketing." && shared_portal_slarequests: ".$shared_portal_slarequest_sql."<P>";

         if ($shared_portal_emails == 1){
            $object_return_params[0] = " deleted=0 && account_id_c = '".$portal_account_id."' ";
            } else {# if ticketing
            $object_return_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
            } 

         } else {# if not portal_account_id 
         $object_return_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
         }

      } # End if list

   # End Shared Access
   ################################

  switch ($action){
   
   case 'list':
   
   #echo "<P>Sec Level ".$_SESSION['security_level']."<P>";

    ################################
    # List

//    $searchemail = $_POST['searchemail'];
    $keyword = $_POST['keyword'];

    if ($do == 'Emails' && ($valtype == 'Emails' || $valtype == NULL || $valtype == 'listall' || $valtype == 'view_email')){

       echo "<div style=\"".$divstyle_grey."\"><center><font size=3><B>".$strings["EmailLogs"]."</B></font></center></div>";
       echo "<center><img src=images/icons/EmailLarge.png width=100></center>";
       echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

       if ($auth > 1){

          #echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=&valuetype=listall');return false\"><font size=3><B>List All</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=&valuetype=test_filter_all_debug');return false\"><font size=3><B>Test Filter Debug [ALL]</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=&valuetype=test_filter_all_live');return false\"><font size=3><B>Test Filter Live [ALL]</B></font></a></center><BR>";
          echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=&valuetype=listall');return false\"><font size=3><B>List All</B></font></a></center><BR>";
          echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

         } // if auth

       }

    $date = date("Y@m@d@G");
    $body_sendvars = $date."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="list" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="keyword" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php

#echo "portal_email ".$portal_email."<P>";
#exit;

    $emailparams[0] = $portal_email;
    $emailparams[1] = $portal_email_password;
//    $emailparams[2] = $portal_email_server;
    $emailparams[2] = "imap.gmail.com";
    $emailparams[3] = 993;
    $emailparams[4] = 0; //delete
    $emailparams[5] = "";
    $emailparams[6] = "";

    if ($valtype == 'test_filter_all_debug'){
       $emailparams[4] = 0; //delete
       $emailparams[5] = "";
       $emailparams[6] = "";
       $debug = TRUE;
       $emailparams[7] = TRUE;
       $emailparams[8] = $valtype;
       } 

    if ($valtype == 'test_filter_all_live'){
       $emailparams[4] = 1; //delete
       $emailparams[5] = "";
       $emailparams[6] = "";
       $emailparams[7] = FALSE;
       $emailparams[8] = $valtype;
       }

    if ($valtype == 'test_filter_single_debug'){
       $emailparams[4] = 0; //delete
       $emailparams[5] = $val; // selected imap email
       $emailparams[7] = TRUE;
       $emailparams[8] = $valtype;
       $debug = TRUE;
       }

    if ($valtype == 'test_filter_single_live'){
       $emailparams[4] = 1; //delete
       $emailparams[5] = $val; // selected imap email
       $emailparams[7] = FALSE;
       $emailparams[8] = $valtype;
       }

    if ($valtype == 'view_email'){
       $emailparams[4] = 0; //delete
       $emailparams[5] = $val; // selected imap email
       $emailparams[6] = ""; // keyword
       $emailparams[7] = "";
       $emailparams[8] = $valtype;
       }

//    if ($valtype == 'keyword' && $keyword != NULL || $searchemail != NULL){
    if ($valtype == 'keyword' && $keyword != NULL){
       $emailparams[4] = 0; //delete
       $emailparams[5] = ""; // selected imap email
       $emailparams[6] = $keyword; // keyword
       $emailparams[7] = "";
       $emailparams[8] = $valtype;
//       $emailparams[9] = $searchemail;
       }

//    $imap_folder_list = $imapemails['imap_folder_list'];
//    $imap_archive_folder_list = $imapemails['imap_archive_folder_list'];

    // Call the filter function 
    $filterparams[0] = 'Emails';
    $filterparams[1] = $emailparams;

    if ($valtype == 'listall' || $valtype == 'keyword' || $valtype == 'view_email' || $valtype == 'test_filter_all_live' || $valtype == 'test_filter_all_debug' || $valtype == 'test_filter_single_debug' || $valtype == 'test_filter_single_live'){

       $emailfilterreturner = $funky_filters->do_filters ($filterparams);
       $imap_emails = $emailfilterreturner[0];
       $final_messages = $emailfilterreturner[1];

       mb_http_output('UTF-8');

       echo $imap_emails;

       echo $final_messages;

       #$pdf_pack[0] = $final_messages;
       #$pdf_pack[1] = $portal_title;

       #$pdf_link = $funky_gear->do_pdf($pdf_pack);
       #echo "<P><a href=".$pdf_link." target=PDF><font size=3><B>Download Filter PDF Report</B></font></a><P>".$final_messages;

       }

    ##################################################
    # Present non-IMAP emails from within scalastica

    if ($valtype == 'Ticketing'){
       $object_return_params[0] .= " && sclm_ticketing_id_c='".$val."' ";
       } elseif ($valtype == 'Emails'){
       $object_return_params[0] .= " && sclm_emails_id_c='".$val."' ";
       } elseif ($valtype == 'keyword' && $keyword != NULL){
       $object_return_params[0] .= " && (name like '%".$keyword."%' || description like '%".$keyword."%' ) ";
       }

    $email_object_type = 'Emails';
    $email_action = "select";
    $email_params[0] = $object_return_params[0];
    $email_params[1] = ""; // select array
    $email_params[2] = ""; // group;
    $email_params[3] = " date_entered DESC"; // order;
    $email_params[4] = "500"; // limit
  
    $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $email_object_type, $email_action, $email_params);

    if (is_array($email)){

       $count = count($email);
       $page = $_POST['page'];
       $glb_perpage_items = 100;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $email_params[4] = " $lfrom , $glb_perpage_items "; 

       $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $email_object_type, $email_action, $email_params);

       for ($cnt=0;$cnt < count($email);$cnt++){

           $id = $email[$cnt]['id'];
           $date_entered = $email[$cnt]['date_entered'];
           $date_modified = $email[$cnt]['date_modified'];
           $modified_user_id = $email[$cnt]['modified_user_id'];
           $created_by = $email[$cnt]['created_by'];

           $name = $email[$cnt]['name'];
           $description = $email[$cnt]['description'];

           $deleted = $email[$cnt]['deleted'];
           $assigned_user_id = $email[$cnt]['assigned_user_id'];
           $contact_id_c = $email[$cnt]['contact_id_c'];
           $account_id_c = $email[$cnt]['account_id_c'];
           $project_id_c = $email[$cnt]['project_id_c'];
           $projecttask_id_c = $email[$cnt]['projecttask_id_c'];
           $sclm_ticketing_id_c = $email[$cnt]['sclm_ticketing_id_c'];
           $sclm_ticketingactivities_id_c = $email[$cnt]['sclm_ticketingactivities_id_c'];

           if ($email[$cnt][$lingoname] != NULL){
              $name = $email[$cnt][$lingoname];
              }

           $cmn_languages_id_c = $email[$cnt]['cmn_languages_id_c'];
           $cmn_statuses_id_c = $email[$cnt]['cmn_statuses_id_c'];

           $message_id = $email[$cnt]['message_id'];
           $encode = $email[$cnt]['encode'];
           $original_date = $email[$cnt]['original_date'];
           $sender = $email[$cnt]['sender'];
           $server = $email[$cnt]['server'];
           $filter_td = $email[$cnt]['filter_id'];
           $receiver = $email[$cnt]['receiver'];
           $debug_mode = $email[$cnt]['debug_mode'];

           if ($debug_mode == 1){
              $debug = "<div id=\"debug-".$id."\" name=\"debug-".$id."\"><img src=images/icons/bug.png width=16> <B>Debug:</B> <a href=\"#\" onClick=\"if(confirmer('Debug OFF?')){loader('debug-".$id."');doBPOSTRequest('debug-".$id."','Body.php', 'pc=".$portalcode."&do=".$do."&action=debug&value=".$id."&valuetype=".$do."&debug_mode=0');return false}\"><font size=2 color=RED><B>ON</B></font></a></div> ";
              } else {
              $debug = "<div id=\"debug-".$id."\" name=\"debug-".$id."\"><img src=images/icons/bug.png width=16> <B>Debug:</B> <a href=\"#\" onClick=\"if(confirmer('Debug ON?')){loader('debug-".$id."');doBPOSTRequest('debug-".$id."','Body.php', 'pc=".$portalcode."&do=".$do."&action=debug&value=".$id."&valuetype=".$do."&debug_mode=1');return false}\"><font size=2 color=BLUE><B>OFF</B></font></a></div> ";
              }

           $sclm_emails_id_c = "";
           $sclm_emails_id_c = $email[$cnt]['sclm_emails_id_c'];

           $par_email_params = "";
           $par_email_object_type = 'Emails';
           $par_email_action = "select";
           $par_email_params[0] = "";
           $par_email_params[0] = " sclm_emails_id_c='".$id."' ";
           $par_email_params[1] = ""; // select array
           $par_email_params[2] = ""; // group;
           $par_email_params[3] = ""; // order;
           $par_email_params[4] = ""; // limit

           $par_email = "";  
           $par_email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $par_email_object_type, $par_email_action, $par_email_params);

           if (is_array($par_email)){
              $par_cnt = count($par_email);
              } else {
              $par_cnt = 0;
              }

           if ($sess_contact_id != NULL && $sess_contact_id==$contact_id_c){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> || <a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$do."&div=light');document.getElementById('fade').style.display='block';return false\"><font size=2 color=BLUE><B>Quick Edit</B></font></a>";

              }

           $convert = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>->".$strings["EmailConvertToTicket"]."</B></font></a> ";

           $emails .= "<div style=\"".$divstyle_white."\">".$debug." ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\">".$date_entered.": [".$par_cnt."]<B>".$name."</B></a></div>";

           } // end for

       } else { // end if array

       $emails = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL){    
       //$addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($email)>10){
       echo $addnew.$emails.$addnew;
       } else {
       echo $emails.$addnew;
       }
   
    echo $navi;

    # End Present non-IMAP emails from within scalastica
    ##################################################

    # End List
    ################################

   break; // end list
   case 'debug':

    $debug_mode = $_POST['debug_mode'];
    $email_id = $_POST['value'];

    #echo "debug: $debug_mode ID: $email_id <P>";

    if ($debug_mode != NULL && $email_id != NULL){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $email_id);
       $process_params[] = array('name'=>'debug_mode','value' => $debug_mode);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       if ($debug_mode == 1){
          $debug = "<div id=\"debug-".$email_id."\" name=\"debug-".$email_id."\"><img src=images/icons/bug.png width=16> <B>Debug:</B> <a href=\"#\" onClick=\"if(confirmer('Debug OFF?')){loader('debug-".$email_id."');doBPOSTRequest('debug-".$email_id."','Body.php', 'pc=".$portalcode."&do=".$do."&action=debug&value=".$email_id."&valuetype=".$do."&debug_mode=0');return false}\"><font size=2 color=RED><B>ON</B></font></a></div> ";
          } else {
          $debug = "<div id=\"debug-".$email_id."\" name=\"debug-".$email_id."\"><img src=images/icons/bug.png width=16> <B>Debug:</B> <a href=\"#\" onClick=\"if(confirmer('Debug ON?')){loader('debug-".$email_id."');doBPOSTRequest('debug-".$email_id."','Body.php', 'pc=".$portalcode."&do=".$do."&action=debug&value=".$email_id."&valuetype=".$do."&debug_mode=1');return false}\"><font size=2 color=BLUE><B>OFF</B></font></a></div> ";
          }

       echo $debug;
    
       }

   break; // end debug
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){ 

       $email_object_type = $do;
       $email_action = "select";
       $email_params[0] = " id='".$val."' ";
       $email_params[1] = ""; // select array
       $email_params[2] = ""; // group;
       $email_params[3] = ""; // order;
       $email_params[4] = ""; // limit
  
       $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $email_object_type, $email_action, $email_params);

       if (is_array($email)){

          for ($cnt=0;$cnt < count($email);$cnt++){

              $id = $email[$cnt]['id'];
              $name = $email[$cnt]['name'];
              $date_entered = $email[$cnt]['date_entered'];
              $date_modified = $email[$cnt]['date_modified'];
              $modified_user_id = $email[$cnt]['modified_user_id'];
              $created_by = $email[$cnt]['created_by'];
              $description = $email[$cnt]['description'];
              $deleted = $email[$cnt]['deleted'];
              $assigned_user_id = $email[$cnt]['assigned_user_id'];
              $contact_id_c = $email[$cnt]['contact_id_c'];
              $record_contact_id_c = $contact_id_c;
              $account_id_c = $email[$cnt]['account_id_c'];
              $project_id_c = $email[$cnt]['project_id_c'];
              $projecttask_id_c = $email[$cnt]['projecttask_id_c'];
              $cmn_languages_id_c = $email[$cnt]['cmn_languages_id_c'];
              $cmn_statuses_id_c = $email[$cnt]['cmn_statuses_id_c'];
              $sclm_ticketing_id_c = $email[$cnt]['sclm_ticketing_id_c'];
              $sclm_ticketingactivities_id_c = $email[$cnt]['sclm_ticketingactivities_id_c'];
              $sclm_emails_id_c = $email[$cnt]['sclm_emails_id_c'];
   
              $message_id = $email[$cnt]['message_id'];
              $encode = $email[$cnt]['encode'];
              $original_date = $email[$cnt]['original_date'];
              $sender = $email[$cnt]['sender'];
              $server = $email[$cnt]['server'];
              $filter_id = $email[$cnt]['filter_id'];
              $receiver = $email[$cnt]['receiver'];
              $debug_mode = $email[$cnt]['debug_mode'];

              } // end for projects

          $field_lingo_pack = $funky_gear->lingo_data_pack ($email, $name, $description, $name_field_base,$desc_field_base);

          } // is array

       } // if action

    if (!$record_contact_id_c){
       $record_contact_id_c = $contact_id_c;
       }

    if (!$record_account_id_c){
       $record_account_id_c = $account_id_c;
       }

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

    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Name"]; // Full Name
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

    $tblcnt++;

    $tablefields[$tblcnt][0] = "debug_mode"; // Field Name
    $tablefields[$tblcnt][1] = "Debug Mode"; // Full Name
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
    $tablefields[$tblcnt][20] = "debug_mode"; //$field_value_id;
    $tablefields[$tblcnt][21] = $debug_mode; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "encode"; // Field Name
    $tablefields[$tblcnt][1] = "Encode"; // Full Name
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
    $tablefields[$tblcnt][20] = "encode"; //$field_value_id;
    $tablefields[$tblcnt][21] = $encode; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sender"; // Field Name
    $tablefields[$tblcnt][1] = "Sender"; // Full Name
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
    $tablefields[$tblcnt][20] = "sender"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sender; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "server"; // Field Name
    $tablefields[$tblcnt][1] = "Server"; // Full Name
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
    $tablefields[$tblcnt][20] = "server"; //$field_value_id;
    $tablefields[$tblcnt][21] = $server; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "original_date"; // Field Name
    $tablefields[$tblcnt][1] = "Original Date"; // Full Name
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
    $tablefields[$tblcnt][20] = "original_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $original_date; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "receiver"; // Field Name
    $tablefields[$tblcnt][1] = "Receiver"; // Full Name
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
    $tablefields[$tblcnt][20] = "receiver"; //$field_value_id;
    $tablefields[$tblcnt][21] = $receiver; //$field_value;   

    if ($filter_id != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'filter_id'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Filter"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' ";
       $tablefields[$tblcnt][9][5] = $filter_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
       $tablefields[$tblcnt][9][9] = $filter_id; // Current Value       $tablefields[$tblcnt][9][6] = '';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'filter_id';//$field_value_id;
       $tablefields[$tblcnt][21] = $filter_id; //$field_value;
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       }  // if filter

    if ($action == 'view' || $auth == 3){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sclm_emails_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Parent"]." ".$strings["Email"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_emails'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       #$tablefields[$tblcnt][9][4] = " sclm_ticketing_id_c='959c09e9-c980-458c-9b1d-5258a462b8da' ";//$exception;
       $tablefields[$tblcnt][9][5] = $sclm_emails_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Emails';
       $tablefields[$tblcnt][9][7] = "sclm_emails"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Emails'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_emails_id_c; // Current Value

       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][12] = '20'; //length
       $tablefields[$tblcnt][20] = "sclm_emails_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_emails_id_c; //$field_value;  

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sclm_ticketing_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Ticket"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_ticketing'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       #$tablefields[$tblcnt][9][4] = " sclm_ticketing_id_c='959c09e9-c980-458c-9b1d-5258a462b8da' ";//$exception;
       $tablefields[$tblcnt][9][5] = $sclm_ticketing_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Ticketing';
       $tablefields[$tblcnt][9][7] = "sclm_ticketing"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Ticketing'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_ticketing_id_c; // Current Value

       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][12] = '20'; //length
       $tablefields[$tblcnt][20] = "sclm_ticketing_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_ticketing_id_c; //$field_value;  

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
       $tablefields[$tblcnt][9][5] = $record_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $record_account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][9][1] = 'contacts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'first_name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $record_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $record_contact_id_c; //$field_value;   

       } else {

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
       $tablefields[$tblcnt][21] = $record_account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][21] = $record_contact_id_c; //$field_value;   

       }

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
           $tablefields[$tblcnt][1] = $strings["Name"]." (".$language.")"; // Full Name
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
           $tablefields[$tblcnt][1] = $strings["Description"]." (".$language.")"; // Full Name
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

    if ($sess_contact_id == $record_contact_id_c || $auth==3){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       }

    $sentdiv = $_GET['div'];
    if ($sentdiv == NULL){
       $sentdiv = $_POST['div'];
       }

    if ($sentdiv != NULL){
       $closer = "<P><center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center><P>";
       }

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    $valpack[5] = ""; // provide add new button

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
    $container_params[3] = $strings["Emails"]; // container_title
    $container_params[4] = 'Emails'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

//    echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=add&value=".$val."&valuetype=".$do."');return false\" class=\"css3button\"><B>Order Service & SLA</B></a></center>";

//    echo "<BR><img src=images/blank.gif width=200 height=5><BR>";

/*
    $returner = $funky_gear->object_returner ('Accounts', $account_id_c);
    $object_return = $returner[1];
    echo $object_return;
*/
/*
    if ($val){
       $returner = $funky_gear->object_returner ('Projects', $val);
       $object_return = $returner[1];
       echo $object_return;
       }
*/
    if ($action == 'view'){
/*
       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";
       echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$val."&valuetype=".$do."');return false\" class=\"css3button\"><B>Attach Services to this Project (Project Management Services)</B></a></center>";
       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";
*/
       }

    echo $container_top;
  
    echo $closer;

    echo $zaform;

    echo $closer;

    echo $container_bottom;


    #
    ###################
    #
/*
    if ($action == 'view' || $project_id_c != NULL){ 

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

    $this->funkydone ($_POST,$lingo,'Projects','view',$project_id_c,$do,$bodywidth);       

    echo $container_bottom;

    }
*/
    if ($action == 'view' || $action == 'edit' ){ 

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = "Related ".$strings["Emails"]; // container_title
    $container_params[4] = 'RelatedEmails'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
   
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    $this->funkydone ($_POST,$lingo,'Emails','list',$val,$do,$bodywidth);    

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

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["Tickets"]; // container_title
    $container_params[4] = 'Tickets'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
   
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'Ticketing','list',$val,$do,$bodywidth);       

    echo $container_bottom;

/*
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["RelatedConfigurationItems"]; // container_title
       $container_params[4] = 'RelatedItems'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       //$container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

$lingoname = "name_".$lingo;

       $this->funkydone ($_POST,$lingo,'ConfigurationItems','list',$val,$do,$bodywidth);

       echo $container_bottom;
*/

    }

    #
    ###################

   break; // end view
   case 'process':

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if (!$_POST['name']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Name"]."</font><P>";
       }   

    if (!$_POST['description']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Description"]."</font><P>";
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
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);
       $process_params[] = array('name'=>'debug_mode','value' => $_POST['debug_mode']);

       if ($_POST['sclm_ticketing_id_c']){
          $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $_POST['sclm_ticketing_id_c']);
          }

       if ($_POST['sclm_serviceslarequests_id_c']){
          $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $_POST['sclm_serviceslarequests_id_c']);
          }

       if ($_POST['sclm_ticketingactivities_id_c']){
          $process_params[] = array('name'=>'sclm_ticketingactivities_id_c','value' => $_POST['sclm_ticketingactivities_id_c']);
          }

       if ($_POST['sclm_emails_id_c']){
          $process_params[] = array('name'=>'sclm_emails_id_c','value' => $_POST['sclm_emails_id_c']);
          }

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

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       $process_message = $strings["SubmissionSuccess"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>