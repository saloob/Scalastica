<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Google.php 
##########################################################
# case 'Google':

if (!function_exists('get_param')){
   include ("common.php");
   }

if ($action == NULL){
   $action = $_GET['action'];
   }

if ($action == NULL){
   $action = $_POST['action'];
   }

$sendiv = $_GET['sendiv'];
if ($sendiv == NULL){
   $sendiv = $_POST['sendiv'];
   }

  switch ($action){

   case 'SetApp':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "sclm_configurationitems_id_c='".$val."' ";
    $ci_params[1] = "id,name,cmn_statuses_id_c,account_id_c,contact_id_c,sclm_configurationitemtypes_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_type_id = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

           if ($ci_type_id == 'd5f7d222-2792-ceee-73a0-551c6f36cf88'){ # 

              $gg_app_id_cid = $ci_items[$cnt]['id'];
              $gg_app_id = $ci_items[$cnt]['name'];

              } elseif ($ci_type_id == 'b7e10bcc-b510-ee48-5550-551c70d5aa4c'){ # 

              $gg_app_secret_cid = $ci_items[$cnt]['id'];
              $gg_app_secret = $ci_items[$cnt]['name'];

              } elseif ($ci_type_id == '75340245-0e5e-7c17-5094-551c6f0d13b5'){ # 

              $gg_app_devkey_cid = $ci_items[$cnt]['id'];
              $gg_app_devkey = $ci_items[$cnt]['name'];

              } 

           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];

           } # for

       } # is array

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "par_ci_id"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = "par_ci_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;   

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
    $tablefields[$tblcnt][11] = 'lightform'; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = 'lightform'; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "gg_app_id_cid"; // Field Name
    $tablefields[$tblcnt][1] = "APP ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = 'gg_app_id_cid'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $gg_app_id_cid; //$field_value_id;
    $tablefields[$tblcnt][21] = $gg_app_id_cid; //$field_value;
    $tblcnt++;

    $tablefields[$tblcnt][0] = "gg_app_id"; // Field Name
    $tablefields[$tblcnt][1] = "APP ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'gg_app_id'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $gg_app_id; //$field_value_id;
    $tablefields[$tblcnt][21] = $gg_app_id; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "gg_app_secret_cid"; // Field Name
    $tablefields[$tblcnt][1] = "APP Secret"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'gg_app_secret_cid'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $gg_app_secret_cid; //$field_value_id;
    $tablefields[$tblcnt][21] = $gg_app_secret_cid; //$field_value; 
  
    $tblcnt++;

    $tablefields[$tblcnt][0] = "gg_app_secret"; // Field Name
    $tablefields[$tblcnt][1] = "APP Secret"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'gg_app_secret'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $gg_app_secret; //$field_value_id;
    $tablefields[$tblcnt][21] = $gg_app_secret; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "gg_app_devkey_cid"; // Field Name
    $tablefields[$tblcnt][1] = "APP Dev Key"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'gg_app_devkey_cid'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $gg_app_devkey_cid; //$field_value_id;
    $tablefields[$tblcnt][21] = $gg_app_devkey_cid; //$field_value; 
  
    $tblcnt++;

    $tablefields[$tblcnt][0] = "gg_app_devkey"; // Field Name
    $tablefields[$tblcnt][1] = "APP Dev Key"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'gg_app_devkey'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $gg_app_devkey; //$field_value_id;
    $tablefields[$tblcnt][21] = $gg_app_devkey; //$field_value;   

    /*
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
    */

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
       } else {
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$account_id_c."' && accounts_contacts.contact_id=contacts.id "; // exception
       }

    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

    $valpack = "";
    $valpack[0] = 'Google';
    $valpack[1] = 'custom'; //
    $valpack[2] = 'Google';
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = 'SetAppProcess'; // next_action
    $valpack[7] = $strings["action_edit"];
    $valpack[8] = ""; 
    $valpack[9] = ""; 
    $valpack[10] = 'lightform';

    echo $funky_gear->form_presentation($valpack);

   break; # end SetApp
   #
   ################################
   #
   case 'SetAppProcess':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $par_ci_id = $_POST['par_ci_id'];

    $gg_app_id_cid = $_POST['gg_app_id_cid'];
    $gg_app_id = $_POST['gg_app_id'];

    $gg_app_secret_cid = $_POST['gg_app_secret_cid'];
    $gg_app_secret = $_POST['gg_app_secret'];

    $gg_app_devkey_cid = $_POST['gg_app_devkey_cid'];
    $gg_app_devkey = $_POST['gg_app_devkey'];

    $cmn_statuses_id_c = $_POST['cmn_statuses_id_c'];
    $contact_id_c = $_POST['contact_id_c'];
    $account_id_c = $_POST['account_id_c'];

    $process_object_type = "ConfigurationItems";
    $process_action = "update";

    if ($_POST['gg_app_id'] && $_POST['par_ci_id'] && $_POST['contact_id_c'] && $_POST['account_id_c']){

       $process_message = $strings["SubmissionSuccess"]."<P>";

       $process_params = "";
       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['gg_app_id_cid']);
       $process_params[] = array('name'=>'name','value' => $_POST['gg_app_id']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['gg_app_id']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['par_ci_id']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'd5f7d222-2792-ceee-73a0-551c6f36cf88');
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
       $process_message .= "Google App ID: ".$_POST['gg_app_id']."<P>";

       }

    if ($_POST['gg_app_secret'] && $_POST['par_ci_id'] && $_POST['contact_id_c'] && $_POST['account_id_c']){

       $process_params = "";
       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['gg_app_secret_cid']);
       $process_params[] = array('name'=>'name','value' => $_POST['gg_app_secret']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['gg_app_secret']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['par_ci_id']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'b7e10bcc-b510-ee48-5550-551c70d5aa4c');
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
       $process_message .= "Google Secret ID: ".$_POST['gg_app_secret']."<P>";

       }

    if ($_POST['gg_app_devkey'] && $_POST['par_ci_id'] && $_POST['contact_id_c'] && $_POST['account_id_c']){

       $process_params = "";
       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['gg_app_devkey_cid']);
       $process_params[] = array('name'=>'name','value' => $_POST['gg_app_devkey']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['gg_app_devkey']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['par_ci_id']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '75340245-0e5e-7c17-5094-551c6f0d13b5');
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
       $process_message .= "Google Dev Key: ".$_POST['gg_app_devkey']."<P>";

       }

     echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";        

   break; # end SetAppProcess
   #
   ################################
   #
   case 'list_calenders':

    if ($sendiv == 'lightform'){

       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       } elseif ($sendiv == 'autoform'){

       echo "<center><a href=\"#\" onClick=\"cleardiv('autoform');document.getElementById('autoform').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       }

    require_once ("api-google.php");

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

           $cals .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$sendiv."');document.getElementById('".$sendiv."').style.display='block';doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=Google&action=view_calendar&value=".$id."&valuetype=Google&sendiv=".$sendiv."');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$summary."</B> (".$timeZone.")</font></a></div><P>";

           } # for

       } # is array

    $google .= "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Google Calendars</B></font></center></div>";
    $google .= "<div style=\"".$divstyle_orange_light."\">Select a Calendar's event to create a Shared Effect event</div>";
    $google .= "<div style='width: 98%; max-height:300px;overflow:scroll; padding: 0.5em; resize: both;'>".$cals."</div>";
    $google .= "<div style=\"".$divstyle_white."\">".$google."</div>";      

    echo $google;

   break;
   case 'view_calendar':

    if ($sendiv == 'lightform'){

       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       } elseif ($sendiv == 'autoform'){

       echo "<center><a href=\"#\" onClick=\"cleardiv('autoform');document.getElementById('autoform').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       }

    echo "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3>Google Event Search</font></B></center></div>";
       
    $search_date_start = $_POST['search_date_start'];
    $search_date_end = $_POST['search_date_end'];
    $search_keyword = $_POST['search_keyword'];

    $today = date("Y-m-d");
    $encdate = date("Y@m@d@G");
    $body_sendvars = $encdate."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

    if ($search_date_start == NULL){
       $search_date_start = $today;
       }

    if ($search_date_end == NULL){
       $search_date_end = strtotime(date("Y-m-d", strtotime($search_date_start)) . "+1 months");
       $search_date_end = date("Y-m-d", $search_date_end);
       }

    $action_search_keyword = $strings["action_search_keyword"];
    $DateStart = $strings["Date"];
    $action_search = $strings["action_search"];

    $ggsearch = <<< GGSEARCH
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="text" id="search_keyword" placeholder="$action_search_keyword" name="search_keyword" value="$search_keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <BR><input type="text" id="search_date_start" placeholder="$DateStart From" name="search_date_start" value="$search_date_start" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <BR><input type="text" id="search_date_end" placeholder="$DateStart To" name="search_date_end" value="$search_date_end" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="pg" name="pg" value="$body_sendvars" >
     <input type="hidden" id="value" name="value" value="$val" >
     <input type="hidden" id="sendiv" name="sendiv" value="lightform" >
     <input type="hidden" id="action" name="action" value="view_calendar" >
     <input type="hidden" id="do" name="do" value="Google" >
     <input type="hidden" id="valuetype" name="valuetype" value="$valtype" >
     <BR><input type="button" name="button" value="$action_search" onclick="javascript:loader('lightform');get(this.parentNode);" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
GGSEARCH;

    echo "<div style=\"".$divstyle_white."\">".$ggsearch."</div>";

    $gg_start_date = $funky_gear->date3339($search_date_start);
    $gg_end_date = $funky_gear->date3339($search_date_end);

    require_once ("api-google.php");

    $gg_params[0] = "view_calendar"; #gg_action;
    $gg_params[1] = $gg_session; # userid
    $gg_params[2] = $val; # cal

    $gg_params[3] = $gg_start_date; 
    $gg_params[4] = $gg_end_date; 
    $gg_params[5] = $search_keyword; 

    $google_cal_events = do_google ($gg_params);

    if (is_array($google_cal_events)){

       for ($cnt=0;$cnt < count($google_cal_events);$cnt++){
 
           $id = $google_cal_events[$cnt]['id'];
           $etag = $google_cal_events[$cnt]['etag'];
           $start_date = $google_cal_events[$cnt]['start_date'];
           $end_date = $google_cal_events[$cnt]['end_date'];
           $created = $google_cal_events[$cnt]['created'];
           $updated = $google_cal_events[$cnt]['updated'];
           $location = $google_cal_events[$cnt]['location'];
           $status = $google_cal_events[$cnt]['status'];
           $description = $google_cal_events[$cnt]['description'];
           $summary = $google_cal_events[$cnt]['summary'];
           $creator = $google_cal_events[$cnt]['creator'];
           $creator_id = $google_cal_events[$cnt]['creator_id'];
           $creator_displayName = $google_cal_events[$cnt]['creator_displayName'];
           $attendees = $google_cal_events[$cnt]['attendees'];

           $description = str_replace("\n", "<br>", $description);

           # Check if the GG event already exists
           #echo "Google ID: $id <BR>";

           if ($id != NULL){

              $ggeventwrap_object_type = "ConfigurationItems";
              $ggeventwrap_action = "select";
              $ggeventwrap_params[0] = " name='".$id."' ";
              $ggeventwrap_params[1] = "name,sclm_configurationitems_id_c"; // select array
              $ggeventwrap_params[2] = ""; // group;
              $ggeventwrap_params[3] = ""; // order;
              $ggeventwrap_params[4] = ""; // limit

              $ggeventwrap_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ggeventwrap_object_type, $ggeventwrap_action, $ggeventwrap_params);

              if (is_array($ggeventwrap_items)){    

                 for ($ggwrapeventcnt=0;$ggwrapeventcnt < count($ggeventwrap_items);$ggwrapeventcnt++){

                     # The Parent CI contains the event ID in the name field
                     $parci_id = $ggeventwrap_items[$ggwrapeventcnt]['sclm_configurationitems_id_c'];

                     # Get the event id from the name field
                     $ggevent_object_type = "ConfigurationItems";
                     $ggevent_action = "select";
                     $ggevent_params[0] = "id='".$parci_id."' && contact_id_c='".$sess_contact_id."' ";
                     $ggevent_params[1] = "name"; // select array
                     $ggevent_params[2] = ""; // group;
                     $ggevent_params[3] = ""; // order;
                     $ggevent_params[4] = ""; // limit

                     $ggevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ggevent_object_type, $ggevent_action, $ggevent_params);

                     if (is_array($ggevent_items)){    

                        for ($ggeventcnt=0;$ggeventcnt < count($ggevent_items);$ggeventcnt++){

                            # The event ID is in the name field
                            #echo "Event ID: $event_id <BR>";
                            $event_id = $ggevent_items[$ggeventcnt]['name'];
                            $gg_event_returner = $funky_gear->object_returner ("Effects", $event_id);
                            $gg_event_name = $gg_event_returner[0];

                            $cals .= "<div style=\"".$divstyle_white."\">Registered in Shared Effects: <a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$event_id."&valuetype=Google&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red><B>".$gg_event_name."</B></font></a></div>";

                            } # for

                        } else {# is array

                        $cals .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$id."&valuetype=Google&sendiv=lightform&cal=".$val."');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$summary."</B></font></a><BR><font color=#151B54><B>Start Date:</B> ".$start_date."<BR><B>End Date:</B> ".$end_date."<BR><B>Location:</B> ".$location."<BR><B>Description:</B><P>".$description."</font></div>";

                        } 

                     } # for

                 } else {# is array

                 $cals .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$id."&valuetype=Google&sendiv=lightform&cal=".$val."');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$summary."</B></font></a><BR><font color=#151B54><B>Start Date:</B> ".$start_date."<BR><B>End Date:</B> ".$end_date."<BR><B>Location:</B> ".$location."<BR><B>Description:</B><P>".$description."</font></div>";

                 } 

              } else {# if ID

              #$cals .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$id."&valuetype=Google&sendiv=lightform&cal=".$val."');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$summary."</B></font></a><BR><font color=#151B54><B>Start Date:</B> ".$start_date."<BR><B>End Date:</B> ".$end_date."<BR><B>Location:</B> ".$location."<BR><B>Description:</B><P>".$description."</font></div>";

              }

           } # for

       } # is array

    $google = "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Google Calendar: ".$val."</B></font></center></div>";
    $google .= "<div style=\"".$divstyle_orange_light."\">Select an event to create a Shared Effect event</div>";
    $google .= "<div style='width: 98%; max-height:300px;overflow:scroll; padding: 0.5em; resize: both;'>".$cals."</div>";

    echo $google;
   
   break;
   case 'embedd':

    $link = $_GET['link'];
    $name = $_GET['name'];
    $vartype = $_GET['vartype'];
    $page_title = $_GET['page_title'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article">
 <head>
  <title><?php echo $page_title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="robots" content="ALL,index,follow">
  <meta name="description" content="Real Politika provides tools and services that promote democratic, transparent Government">
  <meta name="keywords" content="Real Politika,realpolitika,Democratic,Transparent,Government,Technology, Lobbyists, Japan, Australia, America,China">
  <meta name="resource-type" content="document">
  <meta name="revisit-after" content="3 Days">
  <meta name="classificaton" content="Service Provider">
  <meta name="distribution" content="Global">
  <meta name="rating" content="Safe For Kids">
  <meta name="author" content="realPolitika">
  <meta http-equiv="reply-to" content="info@realpolitika.org">
  <meta http-equiv="imagetoolbar" content="no">
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
 </head>
 <body>

<?php

    switch ($vartype){
 
     case 'Share':

      $google = "<g:plusone annotation=\"inline\" href=\"".$link."\"></g:plusone><span itemprop=\"name\">".$name."</span><span itemprop=\"description\">".$name."</span>";

     break;
     case 'Contacts':

       $google = "";

     break;

    } // vartpe switch

    echo $google;
?>
 </body>
</html>
<?php

   break;

  } // end action switch

# break; // End Google
##########################################################
?>