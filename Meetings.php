<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-10-01
# Page: Meetings.php 
############################################## 
# Meetings

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     if (!$sendiv){
        $sendiv = $BodyDIV;
        }
     }

  $search_date = $_POST['date'];

  if ($search_date){
     $search_year = date('Y', strtotime($search_date));
     $search_month = date('m', strtotime($search_date));
     $search_day = date('d', strtotime($search_date));
     } 

  $mtg_params[0] = " deleted=0 ";
  $evt_params[0] = " deleted=0 ";

  if (!$search_date){
     $today = date("Y-m-d");
     $this_year = date("Y");
     $this_month = date("m");
     $this_day = date("d");
     } else {
     $today = $search_date;
     $mtg_params[0] .= " && meetings.date_start like '%".$search_date."%' ";
     $evt_params[0] .= " && start_date like '%".$search_date."%' ";
     $this_year = date('Y', strtotime($search_date));
     $this_month = date('m', strtotime($search_date));
     $this_day = date('d', strtotime($search_date));
     }

  $go_previous_month_year = strtotime(date("Y-m-d", strtotime($today)) . "-1 months");
  $go_previous_month_year = date("Y-m-d", $go_previous_month_year);
  $go_next_month_year = strtotime(date("Y-m-d", strtotime($today)) . "+1 months");
  $go_next_month_year = date("Y-m-d", $go_next_month_year);

  $go_previous_month = "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$go_previous_month_year."&sendiv=".$sendiv."');return false\"><font size=2>Previous Month [".$go_previous_month_year."]<font></a>";
  $go_next_month = "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$go_next_month_year."&sendiv=".$sendiv."');return false\"><font size=2>Next Month [".$go_next_month_year."]<font></a>";

  $mtg_params[0] .= " && (meetings_cstm.cmn_statuses_id_c != '".$standard_statuses_closed."' || meetings_cstm.account_id_c='".$sess_account_id."') ";
  $evt_params[0] .= " && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";

  switch ($action){
   
   case 'list':
   case 'search':

    $tblcnt = 0;

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
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sendiv; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "date"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Date"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = '12'; //length
    $tablefields[$tblcnt][20] = "date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $today; //$field_value;   

    $valpack = "";
    #$do = 'ConfigurationItems';
    $valpack[0] = $do;
    $valpack[1] = 'custom'; //
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ''; //
    $valpack[6] = 'list'; //
    $valpack[7] = 'Select'; //

    $monthsform = $funky_gear->form_presentation($valpack);

    $cal_object_type = "Meetings";
    $cal_action = "select_mix";
    $cal_params[1] = "meetings.id,meetings.name,meetings.date_start"; // select array
    $cal_params[2] = ""; // group;
    $cal_params[3] = ""; // order;
    $cal_params[4] = ""; // limit
    $cal_params[5] = $lingoname; // lingo
 
    $cal_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cal_object_type, $cal_action, $mtg_params);

    if (is_array($cal_items)){

       $count = count($cal_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $extraparams = "&sendiv=".$sendiv;
       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$sendiv,$extraparams);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       $cal_params[4] = " $lfrom , $glb_perpage_items "; 

       $cal_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cal_object_type, $cal_action, $mtg_params);
  
       for ($cnt=0;$cnt < count($cal_items);$cnt++){
   
           $id = $cal_items[$cnt]['id'];
           $name = $cal_items[$cnt]['name'];
           $date_entered = $cal_items[$cnt]['date_entered'];
           $date_modified = $cal_items[$cnt]['date_modified'];
           $modified_user_id = $cal_items[$cnt]['modified_user_id'];
           $created_by = $cal_items[$cnt]['created_by'];
           /*
           $description = $cal_items[$cnt]['description'];
           $deleted = $cal_items[$cnt]['deleted'];
           $location = $cal_items[$cnt]['location'];
           $password = $cal_items[$cnt]['password'];
           $join_url = $cal_items[$cnt]['join_url'];
           $host_url = $cal_items[$cnt]['host_url'];
           $displayed_url = $cal_items[$cnt]['displayed_url'];
           $creator = $cal_items[$cnt]['creator'];
           $external_id = $cal_items[$cnt]['external_id'];
           $duration_hours = $cal_items[$cnt]['duration_hours'];
           $duration_minutes = $cal_items[$cnt]['duration_minutes'];
           */
           $date_start = $cal_items[$cnt]['date_start'];
           $date_end = $cal_items[$cnt]['date_end'];
           /*
           $parent_type = $cal_items[$cnt]['parent_type'];
           $status = $cal_items[$cnt]['status'];
           $type = $cal_items[$cnt]['type'];
           $parent_id = $cal_items[$cnt]['parent_id'];
           $reminder_time = $cal_items[$cnt]['reminder_time'];
           $email_reminder_time = $cal_items[$cnt]['email_reminder_time'];
           $email_reminder_sent = $cal_items[$cnt]['email_reminder_sent'];
           $outlook_id = $cal_items[$cnt]['outlook_id'];
           $sequence = $cal_items[$cnt]['sequence'];
           $repeat_type = $cal_items[$cnt]['repeat_type'];
           $repeat_interval = $cal_items[$cnt]['repeat_interval'];
           $repeat_dow = $cal_items[$cnt]['repeat_dow'];
           $repeat_until = $cal_items[$cnt]['repeat_until'];
           $repeat_count = $cal_items[$cnt]['repeat_count'];
           $repeat_parent_id = $cal_items[$cnt]['repeat_parent_id'];
           $recurring_source = $cal_items[$cnt]['recurring_source'];
           */

           $id_c = $cal_items[$cnt]['id_c'];
           $jjwg_maps_lng_c = $cal_items[$cnt]['jjwg_maps_lng_c'];
           $jjwg_maps_lat_c = $cal_items[$cnt]['jjwg_maps_lat_c'];
           $jjwg_maps_geocode_status_c = $cal_items[$cnt]['jjwg_maps_geocode_status_c'];
           $jjwg_maps_address_c = $cal_items[$cnt]['jjwg_maps_address_c'];
           $account_id_c = $cal_items[$cnt]['account_id_c'];
           $contact_id_c = $cal_items[$cnt]['contact_id_c'];

           $edit = "";

           if ($sess_account_id != NULL){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=edit&value=".$id."&valuetype=".$do."&sendiv=lightform');return false\"><font size=1 color=RED>".$strings["action_edit"]."</font></a>";
             }

           $cal_name .= "<div style=\"".$divstyle_white."\"><font size=1 color=RED>[M]</font> ".$edit." <a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=view&value=".$id."&valuetype=".$do."&sendiv=lightform');return false\"><font size=1 color=BLUE>".$name."</font></a></div>";


           }  # end for

       }  # is array

    if ($sess_account_id != NULL){
       $add_mtg = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=add&value=".$check_date."&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["action_addnew"]."</font></a></div>";
       }

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    #$container_params[3] = $go_last_month." <- Calendar"; // container_title
    $container_params[3] = $strings["Meetings"]; // container_title
    $container_params[4] = 'Meetings'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    echo "<P>";
    echo "<center>".$go_previous_month." | ".$go_next_month."</center>";
    echo "<center>".$monthsform."</center>";

    echo $navi;

    echo $add_mtg;

    echo $cal_name;

    if ($count>10){
       echo $add_mtg;
       }

    echo $navi;

    echo $container_bottom;

   break;
   case 'add':
   case 'edit':
   case 'view':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    if ($action == 'edit' || $action == 'view'){

       $cal_object_type = "Meetings";
       $cal_action = "select_mix";
       $mtg_params[0] = "meetings.id='".$val."' ";
       $cal_params[1] = ""; // select array
       $cal_params[2] = ""; // group;
       $cal_params[3] = ""; // order;
       $cal_params[4] = ""; // limit
       $cal_params[5] = $lingoname; // lingo
 
       $cal_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cal_object_type, $cal_action, $mtg_params);

       if (is_array($cal_items)){
  
          for ($cnt=0;$cnt < count($cal_items);$cnt++){
   
              $id = $cal_items[$cnt]['id'];
              $name = $cal_items[$cnt]['name'];
              $date_entered = $cal_items[$cnt]['date_entered'];
              $date_modified = $cal_items[$cnt]['date_modified'];
              $modified_user_id = $cal_items[$cnt]['modified_user_id'];
              $created_by = $cal_items[$cnt]['created_by'];
              $description = $cal_items[$cnt]['description'];
              $deleted = $cal_items[$cnt]['deleted'];
              $location = $cal_items[$cnt]['location'];
              $password = $cal_items[$cnt]['password'];
              $join_url = $cal_items[$cnt]['join_url'];
              $host_url = $cal_items[$cnt]['host_url'];
              $displayed_url = $cal_items[$cnt]['displayed_url'];
              $creator = $cal_items[$cnt]['creator'];
              $external_id = $cal_items[$cnt]['external_id'];
              $duration_hours = $cal_items[$cnt]['duration_hours'];
              $duration_minutes = $cal_items[$cnt]['duration_minutes'];
              $date_start = $cal_items[$cnt]['date_start'];
              $date_end = $cal_items[$cnt]['date_end'];
              $parent_type = $cal_items[$cnt]['parent_type'];
              $status = $cal_items[$cnt]['status'];
              $type = $cal_items[$cnt]['type'];
              $parent_id = $cal_items[$cnt]['parent_id'];
              $reminder_time = $cal_items[$cnt]['reminder_time'];
              $email_reminder_time = $cal_items[$cnt]['email_reminder_time'];
              $email_reminder_sent = $cal_items[$cnt]['email_reminder_sent'];
              $outlook_id = $cal_items[$cnt]['outlook_id'];
              $sequence = $cal_items[$cnt]['sequence'];
              $repeat_type = $cal_items[$cnt]['repeat_type'];
              $repeat_interval = $cal_items[$cnt]['repeat_interval'];
              $repeat_dow = $cal_items[$cnt]['repeat_dow'];
              $repeat_until = $cal_items[$cnt]['repeat_until'];
              $repeat_count = $cal_items[$cnt]['repeat_count'];
              $repeat_parent_id = $cal_items[$cnt]['repeat_parent_id'];
              $recurring_source = $cal_items[$cnt]['recurring_source'];

              # Custom fields
              #$id_c = $cal_items[$cnt]['id_c'];
              $jjwg_maps_lng_c = $cal_items[$cnt]['jjwg_maps_lng_c'];
              $jjwg_maps_lat_c = $cal_items[$cnt]['jjwg_maps_lat_c'];
              $jjwg_maps_geocode_status_c = $cal_items[$cnt]['jjwg_maps_geocode_status_c'];
              $jjwg_maps_address_c = $cal_items[$cnt]['jjwg_maps_address_c'];
              $account_id_c = $cal_items[$cnt]['account_id_c'];
              $contact_id_c = $cal_items[$cnt]['contact_id_c'];
              $cmn_statuses_id_c = $cal_items[$cnt]['cmn_statuses_id_c'];

              }  # end for

          }  # is array

       }  # edit/view

    $now_time = date("H-i-s");

    if (!$date_entered){
       $date_entered = date("Y-m-d H-i-s");
       }

    if (!$date_start && $action == 'add'){
       $date_start = $val." ".$now_time;
       }

    if (!$date_end && $action == 'add'){
       $date_end = $val." ".$now_time;
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
    $tablefields[$tblcnt][11] = $id; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $id; //$field_value;

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
 
    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Title"]; // Full Name
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
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value; 

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
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

    $tblcnt++;

    if (!$send_email){
       $send_email = 0;
       }

    $tablefields[$tblcnt][0] = "send_email"; // Field Name
    $tablefields[$tblcnt][1] = $strings["SendEmail"]." ?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $send_email; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "send_email"; //$field_value_id;
    $tablefields[$tblcnt][21] = $send_email; //$field_value;


    if (!$ci_account_id_c){
       $ci_account_id_c = $sess_account_id;
       }

    if (!$ci_account_id_c){
       $ci_account_id_c = $portal_account_id;
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
          $tablefields[$tblcnt][9][4] = " id='".$ci_account_id_c."' "; // exception
          }
       $tablefields[$tblcnt][9][5] = $ci_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   

       $tblcnt++;

       if (!$ci_contact_id_c){
          $ci_contact_id_c = $sess_contact_id;
          }

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
          } else {
          $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$ci_account_id_c."' && accounts_contacts.contact_id=contacts.id "; // exception
          }

       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "date_entered"; // Field Name
    $tablefields[$tblcnt][1] = $strings["date_entered"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $date_entered; // Field ID
    $tablefields[$tblcnt][20] = "date_entered"; //$field_value_id;
    $tablefields[$tblcnt][21] = $date_entered; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "date_start"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_start"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $date_start; // Field ID
    $tablefields[$tblcnt][12] = '21'; 
    $tablefields[$tblcnt][20] = "date_start"; //$field_value_id;
    $tablefields[$tblcnt][21] = $date_start; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "date_end"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_end"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $date_end; // Field ID
    $tablefields[$tblcnt][12] = '21'; 
    $tablefields[$tblcnt][20] = "date_end"; //$field_value_id;
    $tablefields[$tblcnt][21] = $date_end; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "duration_hours"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_duration_hours"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $duration_hours; // Field ID
    $tablefields[$tblcnt][12] = '2'; 
    $tablefields[$tblcnt][20] = "duration_hours"; //$field_value_id;
    $tablefields[$tblcnt][21] = $duration_hours; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "duration_minutes"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_duration_minutes"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $duration_minutes; // Field ID
    $tablefields[$tblcnt][12] = '2'; 
    $tablefields[$tblcnt][20] = "duration_minutes"; //$field_value_id;
    $tablefields[$tblcnt][21] = $duration_minutes; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "password"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_password"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $password; // Field ID
    $tablefields[$tblcnt][12] = '16'; 
    $tablefields[$tblcnt][20] = "password"; //$field_value_id;
    $tablefields[$tblcnt][21] = $password; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "join_url"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_join_url"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $join_url; // Field ID
    $tablefields[$tblcnt][12] = '60'; 
    $tablefields[$tblcnt][20] = "join_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $join_url; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "host_url"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_host_url"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $host_url; // Field ID
    $tablefields[$tblcnt][12] = '60'; 
    $tablefields[$tblcnt][20] = "host_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $host_url; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "displayed_url"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_displayed_url"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $displayed_url; // Field ID
    $tablefields[$tblcnt][12] = '60'; 
    $tablefields[$tblcnt][20] = "displayed_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $displayed_url; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "reminder_time"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Meeting_reminder_time"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $reminder_time; // Field ID
    $tablefields[$tblcnt][12] = '60'; 
    $tablefields[$tblcnt][20] = "reminder_time"; //$field_value_id;
    $tablefields[$tblcnt][21] = $reminder_time; //$field_value; 

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
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // provide add new button
    $valpack[6] = ""; // provide add new button
    $valpack[10] = $sendiv; # div for edit links

    if ($action == 'add'){
       $valpack[7] = $strings["Add"];
       }

    if ($action == 'edit'){
       $valpack[7] = $strings["Edit"];
       }

    # Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    #$container_params[3] = $go_last_month." <- Calendar"; // container_title
    $container_params[3] = $strings["Meeting"]; // container_title
    $container_params[4] = 'Meeting'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    echo $zaform;

    if ($action == 'view' || $action == 'edit' ){

       # Provide ICS

       $dstart = "";
       $dend = "";
       $dstamp = "";
       $from_email = "";
       $uid = "";
       $from_name = "";
       $from_email = "";
       $summary = "";

       $message = "BEGIN:VCALENDAR
VERSION:2.0
CALSCALE:GREGORIAN
METHOD:REQUEST
BEGIN:VEVENT
DTSTART:20110718T121000Z
DTEND:20110718T131000Z
DTSTAMP:20110525T075116Z
ORGANIZER;CN=From Name:mailto:from email id
UID:12345678
ATTENDEE;PARTSTAT=NEEDS-ACTION;RSVP= TRUE;CN=Sample:mailto:sample@test.com
DESCRIPTION:This is a test of iCalendar event invitation.
LOCATION: Kochi
SEQUENCE:0
STATUS:CONFIRMED
SUMMARY:Test iCalendar
TRANSP:OPAQUE
END:VEVENT
END:VCALENDAR";

       #echo "<a href=".$message." target=_parent>Add to Outlook</a>";

       } # end view/edit

    echo $container_bottom;

   break;
   case 'process':

    echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

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
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'date_entered','value' => $_POST['date_entered']);
       #$process_params[] = array('name'=>'date_modified','value' => $_POST['date_modified']);
       #$process_params[] = array('name'=>'modified_user_id','value' => $_POST['modified_user_id']);
       #$process_params[] = array('name'=>'created_by','value' => $_POST['created_by']);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       #$process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
       $process_params[] = array('name'=>'location','value' => $_POST['location']);
       $process_params[] = array('name'=>'password','value' => $_POST['password']);
       $process_params[] = array('name'=>'join_url','value' => $_POST['join_url']);
       $process_params[] = array('name'=>'host_url','value' => $_POST['host_url']);
       $process_params[] = array('name'=>'displayed_url','value' => $_POST['displayed_url']);
       #$process_params[] = array('name'=>'creator','value' => $_POST['creator']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'external_id','value' => $_POST['external_id']);
       $process_params[] = array('name'=>'duration_hours','value' => $_POST['duration_hours']);
       $process_params[] = array('name'=>'duration_minutes','value' => $_POST['duration_minutes']);
       $process_params[] = array('name'=>'date_start','value' => $_POST['date_start']);
       $process_params[] = array('name'=>'date_end','value' => $_POST['date_end']);
       $process_params[] = array('name'=>'parent_type','value' => $_POST['parent_type']);
       $process_params[] = array('name'=>'status','value' => $_POST['status']);
       $process_params[] = array('name'=>'type','value' => $_POST['type']);
       $process_params[] = array('name'=>'parent_id','value' => $_POST['parent_id']);
       $process_params[] = array('name'=>'reminder_time','value' => $_POST['reminder_time']);
       $process_params[] = array('name'=>'email_reminder_time','value' => $_POST['email_reminder_time']);
       $process_params[] = array('name'=>'email_reminder_sent','value' => $_POST['email_reminder_sent']);
       $process_params[] = array('name'=>'outlook_id','value' => $_POST['outlook_id']);
       $process_params[] = array('name'=>'sequence','value' => $_POST['sequence']);
       $process_params[] = array('name'=>'repeat_type','value' => $_POST['repeat_type']);
       $process_params[] = array('name'=>'repeat_interval','value' => $_POST['repeat_interval']);
       $process_params[] = array('name'=>'repeat_dow','value' => $_POST['repeat_dow']);
       $process_params[] = array('name'=>'repeat_until','value' => $_POST['repeat_until']);
       $process_params[] = array('name'=>'repeat_count','value' => $_POST['repeat_count']);
       $process_params[] = array('name'=>'repeat_parent_id','value' => $_POST['repeat_parent_id']);
       $process_params[] = array('name'=>'recurring_source','value' => $_POST['recurring_source']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($_POST['id'] == NULL && $result['id'] != NULL){
          $val = $result['id'];
          } else {
          $val = $_POST['id'];
          }

       $process_message = $strings["SubmissionSuccess"]."<P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$do."');return false\">".$strings["action_edit"]."</a> || <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$do."');return false\">".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break;

 } # switch

?>