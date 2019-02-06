<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-18
# Page: Accounts.php 
##########################################################
# case 'Accounts':

  # Security Checker
  $this_module = '3ab6d66b-e867-8c14-11a4-527377ce9e86'; # Accounts
  $security_params[0] = $this_module;
  $security_params[1] = $lingo;
  $security_params[2] = $_SESSION['contact_id'];
  $security_check = check_security($security_params);
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

  #echo "$role_AccountAdministrator = $security_role";

  switch ($do){

   case 'Reseller':

//    $accparams[0] 

   break;

  }

  switch ($action){

   case 'list':

    mb_language('uni');
    mb_internal_encoding('UTF-8');

    $object_type = "Accounts";
    $acc_action = "select_soap";

    $accparams = array();
//    $accparams[0] = $object_returner[4];

//    $accparams[0] = $object_return_params[0];
//    $accparams[0] = " (cmn_statuses_id_c = '".$standard_statuses_open_public."') || (cmn_statuses_id_c = '".$standard_statuses_open_anonymous."') ";
//      $accparams[0] = "";
  
  
    if ($valtype == 'Block'){

       echo "<img src=images/blank.gif width=100 height=10><BR>";

       $accparams[1] = "*";
       $accparams[2] = "";
       $accparams[3] = " date_entered DESC ";
       $accparams[4] = " 10 ";
       $contentmax = 5;
       $blockwidth = 190;
       $marginleft = "3%";
       $marginright = "3%";

       } else { // valtype

       echo $object_return;
       echo "<img src=images/blank.gif width=500 height=10><BR>";

       $contentmax = 20;
       $blockwidth = 190;
       $marginleft = "3%";
       $marginright = "3%";
       $accparams[1] = "*";
       $accparams[2] = "";
       $accparams[3] = " date_entered DESC ";
       $accparams[4] = "20";

       } 

    if ($valtype == 'Search'){
       $accparams[0] .= " && (name like '%".$val."%' || description like '%".$val."%') ";
       }
    
    $items_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $acc_action, $accparams);

    if (is_array($items_list)){

       $count = count($items_list);
       $page = $_POST['page'];
       $glb_perpage_items = $contentmax;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       if ($valtype != 'Block'){
          echo $navi;
          }

       $accparams[1] = "*";
       $accparams[2] = "";
       $accparams[3] = " date_entered DESC ";
       $accparams[4] = " $lfrom , $glb_perpage_items ";
 
       $items_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $acc_action, $accparams);
     
       for ($cnt=0;$cnt < count($items_list);$cnt++){

           $id = $items_list[$cnt]['id'];
           $name = $items_list[$cnt]['name'];
           $date_entered = $items_list[$cnt]['date_entered'];
           $date_modified = $items_list[$cnt]['date_modified'];
           $modified_user_id = $items_list[$cnt]['modified_user_id'];
           $created_by = $items_list[$cnt]['created_by'];
           $description = $items_list[$cnt]['description'];
           $assigned_user_id = $items_list[$cnt]['assigned_user_id'];
           $phone_office = $items_list[$cnt]['phone_office'];
           $website = $items_list[$cnt]['website'];
           $phone_fax = $items_list[$cnt]['phone_fax'];
           $billing_address_street = $items_list[$cnt]['billing_address_street'];
           $billing_address_city = $items_list[$cnt]['billing_address_city'];
           $billing_address_state = $items_list[$cnt]['billing_address_state'];
           $billing_address_postalcode = $items_list[$cnt]['billing_address_postalcode'];
           $description = $items_list[$cnt]['description'];

           $acc_cstm_object_type = "Accounts";
           $acc_cstm_action = "select_cstm";
           $acc_cstm_params[0] = "id_c='".$id."' ";
           $acc_cstm_params[1] = ""; // select
           $acc_cstm_params[2] = ""; // group;
           $acc_cstm_params[3] = ""; // order;
           $acc_cstm_params[4] = ""; // limit

           $account_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_cstm_object_type, $acc_cstm_action, $acc_cstm_params);

           if (is_array($account_cstm_info)){
      
              for ($cstm_cnt=0;$cstm_cnt < count($account_cstm_info);$cstm_cnt++){

                  $status_c = $account_cstm_info[$cstm_cnt]['status_c'];
                  $cmn_countries_id_c = $account_cstm_info[$cstm_cnt]['cmn_countries_id_c'];
                  $contact_id_c = $account_cstm_info[$cstm_cnt]['contact_id_c']; // Administrator

                  } // for

              } // if array


           # If Admin
           if ($auth == 3){
              $ci_object_type = "ConfigurationItems";
              $ci_action = "select";
              $ci_params[0] = " deleted=0 && account_id_c='".$id."' && sclm_configurationitemtypes_id_c='ad2eaca7-8f00-9917-501a-519d3e8e3b35' ";
              $ci_params[1] = ""; // select array
              $ci_params[2] = ""; // group;
              $ci_params[3] = ""; // order;
              $ci_params[4] = ""; // limit
  
              $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

              if (is_array($ci_items)){

                 for ($acc_cnt=0;$acc_cnt < count($ci_items);$acc_cnt++){
 
                     #$id = $ci_items[$cnt]['id'];
                     $acc_hostname = $ci_items[$acc_cnt]['name'];

                     if ($acc_hostname != NULL){
                        $hostname_md = md5($acc_hostname);
                        }

                     } # for

                 } # array

              $acc_encode = mb_detect_encoding($name);
              $name = mb_convert_encoding($name, "UTF-8", $acc_encode);
              $show_id = "Account ID: ".$id."<BR>Encode: ".$acc_encode."<BR>Hostname MD5:".$hostname_md;

              } else {
              $show_id = "";
              }
 
           // Check Admin for Edit
           if ($sess_contact_id != NULL && $sess_contact_id == $contact_id_c || $system_account == TRUE || $auth == 3 || $security_role == $role_AccountAdministrator){
     
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font color=#151B54><B>(".$strings["action_edit"].")</B></font></a>";
     
              } else {// end if admin

              $edit = "";
     
              } 

           // View
           if ($cmn_countries_id_c){
              $country = $funky_gear->makecountry ($cmn_countries_id_c,$portalcode,$BodyDIV,$lingo);
              } else {
              $country = "";
              }

           $this_item = $country." <a href=\"#Top\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><font=#151B54>".$name."</font></a> ".$edit."<BR>".$show_id;

           $items .= "<div style=\"".$divstyle_white."\">".$this_item."</div>";
      
           } // end for
      
       } else { // end if array

         $items = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }  
    
    if ($sess_contact_id != NULL){
     
       $add_item = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
     
       } else {
      
       $add_item = "<div style=\"".$divstyle_white."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }
     
    if (count($the_list)>10){
  //     echo "<P>".$add_item."<P>".$items."<P>".$add_item;
       echo $items;
       } else {
//       echo "<P>".$add_item.$items;
       echo $items;
       }

       if ($valtype != 'Block'){
          echo $navi;
          }

   break; 
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){

       $object_type = "Accounts";
       $acc_action = "select";
       $accparams[0] = "id='".$val."' ";
       $accparams[1] = ""; // select
       $accparams[2] = ""; // group;
       $accparams[3] = ""; // order;
       $accparams[4] = ""; // limit

       $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $acc_action, $accparams);

       if (is_array($account_info)){
      
          for ($cnt=0;$cnt < count($account_info);$cnt++){

              $account_name = $account_info[$cnt]['name'];
              $phone_office = $account_info[$cnt]['phone_office'];
              $website = $account_info[$cnt]['website'];
              $phone_fax = $account_info[$cnt]['phone_fax'];
              $billing_address_street = $account_info[$cnt]['billing_address_street'];
              $billing_address_city = $account_info[$cnt]['billing_address_city'];
              $billing_address_state = $account_info[$cnt]['billing_address_state'];
              $billing_address_postalcode = $account_info[$cnt]['billing_address_postalcode'];
              $description = $account_info[$cnt]['description'];

             } // for

          $object_type = "Accounts";
          $acc_action = "select_cstm";
          $acc_cstm_params[0] = "id_c='".$val."' ";
          $acc_cstm_params[1] = ""; // select
          $acc_cstm_params[2] = ""; // group;
          $acc_cstm_params[3] = ""; // order;
          $acc_cstm_params[4] = ""; // limit

          $account_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $acc_action, $acc_cstm_params);

          if (is_array($account_cstm_info)){
      
             for ($cstm_cnt=0;$cstm_cnt < count($account_cstm_info);$cstm_cnt++){

                 $status_c = $account_cstm_info[$cstm_cnt]['status_c'];
                 $cmn_countries_id_c = $account_cstm_info[$cstm_cnt]['cmn_countries_id_c'];
                 $contact_id_c = $account_cstm_info[$cstm_cnt]['contact_id_c']; // Administrator
                 $parent_account_id = $account_cstm_info[$cstm_cnt]['account_id_c']; // Parent
                 $email_system_c = $account_cstm_info[$cstm_cnt]['email_system_c']; // Parent

                } // for

             } // if array

          $tblcnt = 0;

          $tablefields[$tblcnt][0] = "id"; // Field Name
          $tablefields[$tblcnt][1] = $strings["ID"]; // Full Name
          $tablefields[$tblcnt][2] = 1; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '';//1; // show in view 
          $tablefields[$tblcnt][11] = $val; // Field ID
          $tablefields[$tblcnt][20] = "id"; //$field_value_id;
          $tablefields[$tblcnt][21] = $val; //$field_value;   

          } // if array

       } // if action

    if ($auth == 3){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentAccount"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = ""; // Exceptions
       $tablefields[$tblcnt][9][5] = $parent_account_id; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $parent_account_id; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $parent_account_id; //$field_value;   

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentAccount"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $parent_account_id; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $parent_account_id; //$field_value;   

       } 

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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $account_name; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "status_c"; // Field Name
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
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $status_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $status_c; // Field ID
    $tablefields[$tblcnt][20] = 'status_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $status_c; //$field_value;   

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
    $tablefields[$tblcnt][11] = ''; // Field ID
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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;   

    $tblcnt++;

    if ($phone_office != NULL && $action == 'view' || $action == 'edit'){

    $tablefields[$tblcnt][0] = "phone_office"; // Field Name
    $tablefields[$tblcnt][1] = $strings["phone_office"]; // Full Name
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
    $tablefields[$tblcnt][20] = "phone_office"; //$field_value_id;
    $tablefields[$tblcnt][21] = $phone_office; //$field_value;   

    $tblcnt++;

       }

    if ($phone_fax != NULL && $action == 'view' || $action == 'edit'){

    $tablefields[$tblcnt][0] = "phone_fax"; // Field Name
    $tablefields[$tblcnt][1] = $strings["phone_fax"]; // Full Name
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
    $tablefields[$tblcnt][20] = "phone_fax"; //$field_value_id;
    $tablefields[$tblcnt][21] = $phone_fax; //$field_value;   
     
    $tblcnt++;

       }

    if ($billing_address_street != NULL && $action == 'view' || $action == 'edit'){

    $tablefields[$tblcnt][0] = "billing_address_street"; // Field Name
    $tablefields[$tblcnt][1] = $strings["billing_address_street"]; // Full Name
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
    $tablefields[$tblcnt][20] = "billing_address_street"; //$field_value_id;
    $tablefields[$tblcnt][21] = $billing_address_street; //$field_value; 

    $tblcnt++;

       }

    if ($billing_address_city != NULL && $action == 'view' || $action == 'edit'){

    $tablefields[$tblcnt][0] = "billing_address_city"; // Field Name
    $tablefields[$tblcnt][1] = $strings["billing_address_city"]; // Full Name
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
    $tablefields[$tblcnt][20] = "billing_address_city"; //$field_value_id;
    $tablefields[$tblcnt][21] = $billing_address_city; //$field_value;

    $tblcnt++;

       }

    if ($billing_address_state != NULL && $action == 'view' || $action == 'edit'){

    $tablefields[$tblcnt][0] = "billing_address_state"; // Field Name
    $tablefields[$tblcnt][1] = $strings["billing_address_state"]; // Full Name
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
    $tablefields[$tblcnt][20] = "billing_address_state"; //$field_value_id;
    $tablefields[$tblcnt][21] = $billing_address_state; //$field_value;

    $tblcnt++;

       }

    if ($billing_address_postalcode != NULL && $action == 'view' || $action == 'edit'){

    $tablefields[$tblcnt][0] = "billing_address_postalcode"; // Field Name
    $tablefields[$tblcnt][1] = $strings["billing_address_postalcode"]; // Full Name
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
    $tablefields[$tblcnt][20] = "billing_address_postalcode"; //$field_value_id;
    $tablefields[$tblcnt][21] = $billing_address_postalcode; //$field_value; 

    $tblcnt++;

       }

    if ($contact_id_c == NULL){
       $contact_id_c = $sess_contact_id;
       }

    $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
    $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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
    $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value; 

    $tblcnt++;

    if ($cmv_countries_id_c != NULL && $action == 'view' || $action == 'edit'){

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
    $tablefields[$tblcnt][9][4] = ' deleted=0 order by name ASC '; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_countries_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = "Countries"; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_countries_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_countries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_countries_id_c; //$field_value; 

    $tblcnt++;

    }

    $tablefields[$tblcnt][0] = "website"; // Field Name
    $tablefields[$tblcnt][1] = $strings["website"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name

    if ($action == 'view'){

       $tablefields[$tblcnt][5] = 'external_link';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][9][0] = $website;//
       $tablefields[$tblcnt][9][1] = $website;//
       $tablefields[$tblcnt][9][2] = 'Scalastica';//

       } else {
 
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table

       } 

    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $website; // Field ID
    $tablefields[$tblcnt][20] = "website"; //$field_value_id;
    $tablefields[$tblcnt][21] = $website; //$field_value;   

/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'email_system_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailSystem"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='571f4cd2-1d12-d165-a8c7-5205833eb24c' "; // Portal Email Server Type 
    $tablefields[$tblcnt][9][5] = $email_system_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'email_system_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $email_system_c; //$field_value;
*/

/*
Spare
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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;   
*/
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

    $valpack = "";
    $valpack[0] = 'Accounts';
    $valpack[1] = $action; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if ($val == $sess_account_id || $auth==3){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } else {
       $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } 
    $valpack[5] = 0; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

//    echo "<img src=images/blank.gif width=550 height=20><BR>";

    if ($action == "view"){

       $object_type = "Accounts";
       $acc_action = "select_cstm";
       $accparams[0] = "id_c='".$val."' ";
       $accparams[1] = ""; // select
       $accparams[2] = ""; // group;
       $accparams[3] = ""; // order;
       $accparams[4] = ""; // limit

       $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $acc_action, $accparams);

       if (is_array($account_info)){
      
          for ($cnt=0;$cnt < count($account_info);$cnt++){

              $account_admin_id = $account_info[$cnt]['contact_id_c']; // Administrator

              } // for

          } // if array

       } # view

       ###################################################
       # More Content from same owner

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $title = "Vote for ".$account_name;
/*
       $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'Members');
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       echo $this->funkydone ($_POST,$lingo,'Votes','print_vote',$val,'Accounts',$bodywidth);
*/
       ###################################################
       # Workflows

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $title = "Workflows for ".$account_name;

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth*.98; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $title; // container_title
       $container_params[4] = 'Workflows'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       #$container = $funky_gear->make_container ($container_params);

       #$container_top = $container[0];
       #$container_middle = $container[1];
       #$container_bottom = $container[2];

       #echo $container_top;

       if ($val == $sess_account_id || $auth==3){

          $this->funkydone ($_POST,$lingo,'Workflows','list',$val,$do,$bodywidth);

          }

       ###################################################
       # Main Form

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";


       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $account_name; // container_title
       $container_params[4] = 'Account'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       if ($sess_account_id != NULL && $action == 'view' && $val != NULL && $sess_account_id != $val){

          # Provide a quick link to establish a relationship with this account if none yet

          $accrel_object_type = "AccountRelationships";
          $accrel_action = "select";
          $accrel_params[0] = " account_id_c='".$sess_account_id."' && account_id1_c='".$val."' ";
          $accrel_params[1] = "id,name,date_entered,account_id_c,account_id1_c,entity_type"; // select array
          $accrel_params[2] = ""; // group;
          $accrel_params[3] = " name, date_entered DESC "; // order;
          $accrel_params[4] = ""; // limit
  
          $accrel_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accrel_object_type, $accrel_action, $accrel_params);

          if (is_array($accrel_items)){              

             $provider_link = "<div style=\"".$divstyle_white."\"><center><font size=3><B>Partnership Exists</B></font></center></div>";
   
             } else { # is array

             $provider_link = "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountRelationships&action=add&value=".$ci_account_id_c."&valuetype=".$do."');return false\"><font size=2 color=red><B>Make New Partnership</font></B></a></center></div>";
 
             }

          echo $provider_link;

          } # if signed in
  
       echo $zaform;

       echo $container_bottom;

       # Main Form
       ###################################################
       # Relationships

       if ($val == $sess_account_id || $auth==3){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = "Related Companies"; // container_title
       $container_params[4] = 'AccountRelationships'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;
  
       $this->funkydone ($_POST,$lingo,'AccountRelationships','list',$val,$do,$bodywidth);

       echo $container_bottom;

       # AccountRelationships
       ###################################################
       # ConfigurationItemSets

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = "Company Configuration Item Sets"; // container_title
       $container_params[4] = 'CompanyConfigurationItemSets'; // container_label

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

          echo $container_top;

          echo "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$val."&valuetype=PortalSet');return false\"><font size=2 color=BLUE><B>Manage Portal Settings</B></font></a></div>";
          echo "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$val."&valuetype=AdvisorySet');return false\"><font size=2 color=BLUE><B>".$strings["AdvisorySettings"]."</B></font></a></div>";
       #echo "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$val."&valuetype=Infrastructure');return false\"><font size=2 color=BLUE><B>".$strings["InfraConfiguration"]."</B></font></a></div>";
       #echo "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$val."&valuetype=EmailFilteringSet');return false\"><font size=2 color=BLUE><B>".$strings["EmailFiltering"]."</B></font></a></div>";

          echo $container_bottom;
 
       # ConfigurationItemSets
       ###################################################
       # Projects

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = "Projects"; // container_title
       $container_params[4] = 'Projects'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;
  
       $this->funkydone ($_POST,$lingo,'Projects','list',$val,$do,$bodywidth);

       echo $container_bottom;

       # Projects
       ###################################################
       # ConfigurationItems

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = "Company Configuration Items"; // container_title
       $container_params[4] = 'CompanyConfigurationItems'; // container_label

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       #echo $container_top;

/*       echo "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$val."&valuetype=PortalSet');return false\"><font size=2 color=red><B>Edit Portal Set</B></font></a><P>";
*/
       if (!$lingo){
          $lingo = "en";
          }

       $lingoname = "name_".$lingo;

       #$this->funkydone ($_POST,$lingo,'ConfigurationItems','list',$val,'Accounts',$bodywidth);

       #echo $container_bottom;

       # ConfigurationItems
       ###################################################
       # Members

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = "Account Members"; // container_title
       $container_params[4] = 'Members'; // container_label

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;
  
       $this->funkydone ($_POST,$lingo,'Contacts','list',$val,'Accounts',$bodywidth);

       #echo $container_bottom;

          }

       # Members
       ###################################################
       # Services

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = "Account Services"; // container_title
       $container_params[4] = 'AccountsServices'; // container_label

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;
  
       $this->funkydone ($_POST,$lingo,'AccountsServices','list',$val,'Accounts',$bodywidth);

       #echo $container_bottom;

       # Services
       ###################################################
       # Resellers
/*
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_title = "Resellers";

       $container = $funky_gear->make_container ($bodyheight,$bodywidth,$container_title,'Resellers');
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;
  
       $this->funkydone ($_POST,$lingo,'Resellers','list',$val,'Accounts',$bodywidth);

       # End Resellers
       ###################################################
       # Start Make Embedded Object Link

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $title = "Embedd";

       $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'Embedd');
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $params = array();
       $params[0] = $account_name;
       $funky_gear->makeembedd ($do,'view',$val,$do,$params);

       # End Make Embedded Object Link
       ###################################################
       # External Sources  - Check if External Sources Recorded (SugarCRM)

       if ($sess_contact_id == $account_admin_id && $sess_contact_id != NULL){

          $container = "";  
          $container_top = "";
          $container_middle = "";
          $container_bottom = "";

          $container_title = "External Service Sources";

          $container = $funky_gear->make_container ($bodyheight,$bodywidth,$container_title,'ExternalSources');
          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];

          echo $container_middle;

          $this->funkydone ($_POST,$lingo,'ExternalSources','list',$val,'Accounts',$bodywidth);

          }
*/
       # External Sources
       ###################################################
       # Business Services

       if ($val == $sess_account_id || $auth==3){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[3] = "Business Services"; // container_title
       $container_params[4] = 'BusinessServices'; // container_label

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $business_services = "<div style=\"".$divstyle_grey."\"><center><h2>Tools, Services, Consultants, Providers and Vendors</h2></center></div>";

       $business_services .= "<div style=\"".$divstyle_white."\"><img src=images/file.gif height=16> Documents, Calendar, Email, Virtual Desktops</div>";
       $business_services .= "<div style=\"".$divstyle_white."\"><img src=images/icons/i_register_domain.gif> Domain Registration, Hosting and Homepage Building Services</div>";
//       $services .= "<div style=\"".$divstyle_white."\"><img src=images/icons/i_support_man.gif> Government Building Consulting Services</div>";
//       $services .= "<div style=\"".$divstyle_white."\"><img src=images/icons/i_businessdirector.gif> Government Tenders</div>";
//       $services .= "<div style=\"".$divstyle_white."\"><img src=images/icons/infrastructure_16.gif> Government Service Providers</div>";
/*
       $services .= "<div style=\"".$divstyle_white."\"><a href=http://esd.element5.com/product.html?cart=1&productid=300376136&languageid=1&backlink=http%3A%2F%2Fwww.realpolitika.org&cookies=1&affiliateid=200151581 target=spreed>Spreed for Video Conferences and Meetings</a></div>";
*/    
       echo $business_services;

       echo $container_bottom;

       # End Business Services
       ###################################################

       } 

       ###################################################
       # Edit
       /*
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $account_name; // container_title
       $container_params[4] = 'Account'; // container_label
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

       echo $container_bottom;

       # End Edit
       ###################################################
  
       */
    #} # if view

    if ($action == 'view' || $action == 'edit'){

       $params = array();
       $params[0] = $account_name;
       echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

       }

   break; // end add/edit
   case 'process':

    if (!$_POST['name']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["AccountName"]."</font><P>";
       }
     
    if (!$error){
     
       $process_object_type = "Accounts";
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       $process_params[] = array('name'=>'phone_office','value' => $_POST['phone_office']);
       $process_params[] = array('name'=>'website','value' => $_POST['website']);
       $process_params[] = array('name'=>'phone_fax','value' => $_POST['phone_fax']);
       $process_params[] = array('name'=>'billing_address_street','value' => $_POST['billing_address_street']);
       $process_params[] = array('name'=>'billing_address_city','value' => $_POST['billing_address_city']);
       $process_params[] = array('name'=>'billing_address_state','value' => $_POST['billing_address_state']);
       $process_params[] = array('name'=>'billing_address_postalcode','value' => $_POST['billing_address_postalcode']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);
       $process_params[] = array('name'=>'status_c','value' => $_POST['status_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'email_system_c','value' => $_POST['email_system_c']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       $this_account_id = $result['id'];

       if ($this_account_id != NULL && $_POST['id']==NULL){

          $this_account_id = $result['id'];

          // Create relation to Contact! when adding there is no sent_id

          $process_object_type = "Relationships";
          $process_action = "set_modules_soap";

          $process_params = array();
          $process_params[0] = "Accounts";
          $process_params[1] = $this_account_id;
          $process_params[2] = "Contacts";
          $process_params[3] = $sess_contact_id;

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          if ($_POST['id']==NULL){

             // Set Parent Relationship
             $process_params = array();
             $process_params[0] = "Accounts";
             $process_params[1] = $_POST['account_id_c'];
             $process_params[2] = "Accounts";
             $process_params[3] = $this_account_id;

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             // Add Account relationship
             $ci_object_type = "Accounts";
             $ci_action = "select";
             $ci_params[0] = " id='".$_POST['account_id_c']."' ";
             $ci_params[1] = ""; // select array
             $ci_params[2] = ""; // group;
             $ci_params[3] = ""; // order;
             $ci_params[4] = ""; // limit
  
             $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

             if (is_array($ci_items)){

                for ($cnt=0;$cnt < count($ci_items);$cnt++){

                    //$id = $ci_items[$cnt]['id'];
                    $parent_name = $ci_items[$cnt]['name'];

                    }
                }

             $name = $parent_name." -> ".$_POST['name'];
             $description = $name; 

             $process_object_type = "AccountRelationships";
             $process_action = "update";

             $process_params = array();  
             $process_params[] = array('name'=>'name','value' => $name);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'description','value' => $description);
             $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id);
             $process_params[] = array('name'=>'account_id1_c','value' => $this_account_id);
             $process_params[] = array('name'=>'entity_type','value' => $entity_type);

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             // Add Administrator to the Account
             $process_params = array(
              array('name'=>'id','value' => $sess_contact_id),
              array('name'=>'account_id','value' => $this_account_id),
              ); 

             $process_object_type = "Contacts";
             $process_action = "update";

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             } // end if add

          } # if

       $process_message = $strings["SubmissionSuccess"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$valtype."&action=view&value=".$this_account_id."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else {

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process
   
   } // End Accounts actions switch

# break; // End Accounts
##########################################################
?>