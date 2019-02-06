<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-09-20
# Page: AccountsServicesSLAs.php 
##########################################################
# case 'AccountsServicesSLAs':

  if ($valtype == 'ConfigurationItems'){
     $object_return_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && (parent_service_type='".$val."' || service_type='".$val."') " ;
     }

  if ($valtype == 'Services'){
     $sclm_services_id_c = $val;
     echo $object_return;
     }

  if ($do == 'AccountsServicesSLAs' && $val != NULL && ($action == 'edit' || $action == 'view')){
     $sclm_accountsservicesslas_id_c = $val;
     #$sersla_returner = $funky_gear->object_returner ("AccountsServicesSLAs", $val);
     #echo $sersla_returner[1];
     }

  if ($valtype == 'AccountsServices' && $action == 'add' && $val != NULL){

     $sclm_accountsservices_id_c = $val;
     #echo $object_return;

     $ci_object_type = $do;
     $ci_action = "select";

     $ci_params[1] = ""; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = ""; // order;
     $ci_params[4] = ""; // limit
  
     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($ci_items)){

        for ($cnt=0;$cnt < count($ci_items);$cnt++){

            #$id = $ci_items[$cnt]['id'];
            $name = $ci_items[$cnt]['name'];
            $image = $ci_items[$cnt]['image'];
            $date_entered = $ci_items[$cnt]['date_entered'];
            $date_modified = $ci_items[$cnt]['date_modified'];
            $modified_user_id = $ci_items[$cnt]['modified_user_id'];
            $created_by = $ci_items[$cnt]['created_by'];
            $description = $ci_items[$cnt]['description'];
            $deleted = $ci_items[$cnt]['deleted'];
            $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];

            $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
            #$sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];

            $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];

            $market_value = $ci_items[$cnt]['market_value'];
            $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
            $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];

            $service_account_id_c = $ci_items[$cnt]['service_account_id_c'];
            $service_contact_id_c = $ci_items[$cnt]['service_contact_id_c'];

            $parent_service_type = $ci_items[$cnt]['parent_service_type'];
            $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
            $service_type = $ci_items[$cnt]['service_type'];
            $service_type_name = $ci_items[$cnt]['service_type_name'];
            $service_tier = $ci_items[$cnt]['service_tier'];

            } # for

        } # is array

     } # if acc serv

  if ($valtype == 'SLA'){
     $sclm_sla_id_c = $val;
     }


  if ($_SESSION['ProjectTasks']){
     $project_task = $_SESSION['ProjectTask'];
     $returner = $funky_gear->object_returner ('ProjectTasks', $project_task);
     $object_return = $returner[1];
     echo $object_return;
     }

  if ($_SESSION['Project']){
     $project_id = $_SESSION['Project'];
     $returner = $funky_gear->object_returner ('Projects', $project_id);
     $object_return = $returner[1];
     echo $object_return;
     }

  switch ($action){
   
   case 'list':
   
    #echo "Role: ".$_SESSION["security_role"]."<BR>";

    ################################
    # List
    
    $ci_object_type = 'AccountsServicesSLAs';
    $ci_action = "select";

    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $ci_params[4] = " $lfrom , $glb_perpage_items "; 

       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $date_entered = $ci_items[$cnt]['date_entered'];
           $date_modified = $ci_items[$cnt]['date_modified'];
           $modified_user_id = $ci_items[$cnt]['modified_user_id'];
           $created_by = $ci_items[$cnt]['created_by'];
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
           $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
           $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];

           # Get list to check if remaining
           $servslalist[] = $sclm_servicessla_id_c;
           // Get capacity of Engineers available for each services SLA
           $service_capacity = 0;

           $capacity_object_type = "ContactsServicesSLA";
           $capacity_action = "select";
           $capacity_params[0] = " sclm_servicessla_id_c='".$sclm_servicessla_id_c."' ";
           $capacity_params[1] = ""; // select array
           $capacity_params[2] = ""; // group;
           $capacity_params[3] = ""; // order;
           $capacity_params[4] = ""; // limit
  
           $capacity_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $capacity_object_type, $capacity_action, $capacity_params);

           if (is_array($capacity_items)){
              $service_capacity = count($capacity_items);
              }
/*
              for ($cnt=0;$cnt < count($capacity_items);$cnt++){
                  $cap_contact_id_c = "";
                  $cap_contact_id_c = $capacity_items[$cnt]['contact_id_c'];
                  $own_capacity = "";
                  if ($sess_contact_id == $cap_contact_id_c){
                     $own_capacity = "<BR><img src=images/blank.gif width=30 height=3><img src=images/icons/ok.gif width=16> You have selected you have capacity for this<BR>"; 
                     $cap_account_id_c = $capacity_items[$cnt]['account_id_c'];

                     } // end if sess            

                  } // end for

              } // end if is array
*/

/*
           $market_value = $ci_items[$cnt]['market_value'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $parent_service_type_id = $ci_items[$cnt]['parent_service_type_id'];
           $service_type_id = $ci_items[$cnt]['service_type_id'];
           $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
           $service_type_name = $ci_items[$cnt]['service_type_name'];
*/
           // Get capacity of Engineers available for each service
//           $service_capacity = 0;
/*
           $capacity_object_type = "ContactsServices";
           $capacity_action = "select";
           $capacity_params[0] = " sclm_services_id_c='".$id."' ";
           $capacity_params[1] = ""; // select array
           $capacity_params[2] = ""; // group;
           $capacity_params[3] = ""; // order;
           $capacity_params[4] = ""; // limit
  
           $capacity_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $capacity_object_type, $capacity_action, $capacity_params);

           if (is_array($capacity_items)){
              $service_capacity = count($capacity_items);
              }
*/
          #echo "$sess_account_id != NULL && $ci_account_id_c != NULL && $sess_account_id==$ci_account_id_c && $auth>1";

           $edit = "";
           if (($sess_account_id != NULL && $ci_account_id_c != NULL) && ($sess_account_id==$ci_account_id_c) && $auth>1){
#           if ($sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              } else {
              $edit = "";
              }

//           $cis .= "<div style=\"".$divstyle_white."\">".$edit." [<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$parent_service_type_id."&valuetype=ConfigurationItems');return false\">".$parent_service_type_name." -></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$service_type_id."&valuetype=ConfigurationItems');return false\">".$service_type_name."</a>] <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a> [Capacity: ".$service_capacity."]</div>";
           $cis .= "<div style=\"".$divstyle_white."\">".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a> [Capacity: ".$service_capacity."]".$own_capacity."</div>";

           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       $servslalist = array(); # make it empty, so should show all available below for adding

       }

    if ($sess_account_id != NULL && ($sess_account_id == $ci_account_id_c) && $auth>1 && $sclm_services_id_c != NULL){
       # Should only add new ones if no SLAs remain

       $sersla_object_type = 'ServicesSLA';
       $sersla_action = "select";
       $sersla_params[0] = "sclm_services_id_c='".$sclm_services_id_c."' && id NOT IN ('".implode($servslalist,"', '")."') ";
       $sersla_params[1] = "id"; // select array
       $sersla_params[2] = ""; // group;
       $sersla_params[3] = " name, date_entered DESC "; // order;
       $sersla_params[4] = ""; // limit
  
       $sersla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sersla_object_type, $sersla_action, $sersla_params);

       if (is_array($sersla_items)){

          # Array = items left to choose from

          $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

          } # if array

       } # if sess

    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;

    # End List
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){ 

       $ci_object_type = $do;
       $ci_action = "select";
       $ci_params[0] = " id='".$val."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $description = $ci_items[$cnt]['description'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
              $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];

              } // end for

          if ($valtype == 'AccountsServices'){
             # This ID is the SLA - need to get the AS ID
             $returner = $funky_gear->object_returner ($valtype, $sclm_accountsservices_id_c);
             $object_return = $returner[1];
             }

          } // is array

       } // if action

    if (!$ci_account_id_c){
       $ci_account_id_c = $sess_account_id; #$portal_account_id;
       }

    if (!$ci_contact_id_c){
       $ci_contact_id_c = $sess_contact_id; #$portal_admin;
       }
/*
    if (!$ci_account_id1_c){
       $ci_account_id1_c = $sess_account_id;
       }
    if (!$ci_contact_id1_c){
       $ci_contact_id1_c = $sess_contact_id;
       }
*/

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

    if ($account_id_c == $portal_account_id){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'sclm_services_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["BaseService"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_services'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = "name"; //$lingoname;
       if ($sclm_services_id_c != NULL){
          $tablefields[$tblcnt][9][4] = "id='".$sclm_services_id_c."' ";//$exception;
          }
       $tablefields[$tblcnt][9][5] = $sclm_services_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Services';
       $tablefields[$tblcnt][9][7] = "sclm_services"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Services'; //new do
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_services_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sclm_services_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "sclm_services_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;   

       } 

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_accountsservices_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["CatalogService"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_accountsservices'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = "name"; //$lingoname;
    if ($sclm_accountsservices_id_c != NULL){
       $tablefields[$tblcnt][9][4] = "id='".$sclm_accountsservices_id_c."' ";//$exception;
       }
    $tablefields[$tblcnt][9][5] = $sclm_accountsservices_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'AccountsServices';
    $tablefields[$tblcnt][9][7] = "sclm_accountsservices"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'AccountsServices'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_accountsservices_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_accountsservices_id_c; //$field_value;

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
//    $tablefields[$tblcnt][9][7] = "cmn_statuses"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_servicessla_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLA"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_servicessla'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($sclm_services_id_c != NULL && ($action == 'add' || $action == 'edit')){
       # Don't show any existing ones - no need to double-up at all

       $servsla_object_type = 'AccountsServicesSLAs';
       $servsla_action = "select";
       $servsla_params[0] = " sclm_services_id_c='".$sclm_services_id_c."' && account_id_c='".$sess_account_id."' ";
       $servsla_params[1] = "sclm_servicessla_id_c"; // select array
       $servsla_params[2] = ""; // group;
       $servsla_params[3] = " name, date_entered DESC "; // order;
       $servsla_params[4] = ""; // limit
  
       $servsla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $servsla_object_type, $servsla_action, $servsla_params);

       if (is_array($servsla_items)){

          for ($servslacnt=0;$servslacnt < count($servsla_items);$servslacnt++){

              #echo "servsla".$servsla_items[$servslacnt]['id']."<BR>";
              $servslalist[] = $servsla_items[$servslacnt]['sclm_servicessla_id_c'];

              }# for

          } else {# is array

          $servslalist = array(); #empty

          } 

       #var_dump($servslalist);

       if ($action == 'add'){
          $tablefields[$tblcnt][9][4] = "sclm_services_id_c='".$sclm_services_id_c."' && id NOT IN ('".implode($servslalist,"', '")."') ";
          } elseif ($action == 'edit' && $sclm_servicessla_id_c != NULL){
          $tablefields[$tblcnt][9][4] = "id='".$sclm_servicessla_id_c."' ";
          } elseif ($action == 'edit' && $sclm_servicessla_id_c == NULL){
          $tablefields[$tblcnt][9][4] = " sclm_services_id_c='".$sclm_services_id_c."'  ";
          }

       #echo "params: ".$tablefields[$tblcnt][9][4]."<BR>";

       #$tablefields[$tblcnt][9][4] = "(sclm_accountsservicesslas.sclm_servicessla_id_c != sclm_servicessla.id) && (sclm_servicessla.sclm_services_id_c='".$sclm_services_id_c."') && (sclm_accountsservicesslas.account_id_c='".$sess_account_id."')";
       }

    $tablefields[$tblcnt][9][5] = $sclm_servicessla_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServicesSLA';
    $tablefields[$tblcnt][9][7] = "sclm_servicessla"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ServicesSLA'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_servicessla_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_servicessla_id_c; //$field_value;

    /*
    // Check individual fields
    $field_module = '33fb9883-f2c5-f6c3-4026-52885904a74a'; // account_id_c
    $field_security_params[0] = $field_module;
    $field_security_params[1] = $lingo;
    $field_security_params[2] = $sess_contact_id;
    $field_security_check = check_security($field_security_params);
    $field_security_access = $field_security_check[0];
    $field_security_level = $field_security_check[1];
    $field_security_role = $field_security_check[2];
    $field_system_action_add = $field_security_check[3];
    $field_system_action_delete = $field_security_check[4];
    $field_system_action_edit = $field_security_check[5];
    $field_system_action_export = $field_security_check[6];
    $field_system_action_import = $field_security_check[7];
    $field_system_action_view = $field_security_check[8];
    $field_system_action_list = $field_security_check[9];

    if (($field_system_action_add == $action_rights_all || $field_system_action_add == $action_rights_owner || $field_system_action_add == $action_rights_account) || ($field_system_action_edit == $action_rights_all || $field_system_action_edit == $action_rights_owner || $field_system_action_edit == $action_rights_account) || ($field_system_action_view == $action_rights_all || $field_system_action_view == $action_rights_owner || $field_system_action_view == $action_rights_account)) {
    */

    if ($ci_account_id_c == $sess_account_id && $action == 'view' || $auth == 3){

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
       $tablefields[$tblcnt][9][5] = $ci_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;  

      } 

    /*
    // Check individual fields
    $field_module = 'edbfc85e-62c9-568e-3d68-52885b575ae7'; // contact_id_c
    $field_security_params[0] = $field_module;
    $field_security_params[1] = $lingo;
    $field_security_params[2] = $sess_contact_id;
    $field_security_check = check_security($field_security_params);
    $field_security_access = $field_security_check[0];
    $field_security_level = $field_security_check[1];
    $field_security_role = $field_security_check[2];
    $field_system_action_add = $field_security_check[3];
    $field_system_action_delete = $field_security_check[4];
    $field_system_action_edit = $field_security_check[5];
    $field_system_action_export = $field_security_check[6];
    $field_system_action_import = $field_security_check[7];
    $field_system_action_view = $field_security_check[8];
    $field_system_action_list = $field_security_check[9];

    if (($field_system_action_add == $action_rights_all || $field_system_action_add == $action_rights_owner || $field_system_action_add == $action_rights_account) || ($field_system_action_edit == $action_rights_all || $field_system_action_edit == $action_rights_owner || $field_system_action_edit == $action_rights_account) || ($field_system_action_view == $action_rights_all || $field_system_action_view == $action_rights_owner || $field_system_action_view == $action_rights_account)) {

    */

    if ($ci_account_id_c == $sess_account_id && $action == 'view' || $auth == 3){

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
       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

       } else {

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
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

       }

    if ($action == 'add'){

       /*
       $service_types['9a2ee7f9-67b6-9f72-c133-52ad302dfdc0'] = 'DC Floor (ID, Name)';
       $service_types['63fef2c9-9acf-fbd1-56c7-52ad300f480f'] = 'Rack (ID, Name)';
       $service_types['de350370-d2d3-e84b-13c1-52ad5f2fb2ab'] = 'Rack Unit Space (ID, Name)';
       $service_types['94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4'] = 'Blade Enclosure (ID, Name)';
       $service_types['cd287492-19ce-99b3-6ead-52e0c97a6e83'] = 'Blade Enclosure Hostname';
       $service_types['5601009c-5ebd-bc31-3659-52e0e4b16ffb'] = 'Blade Enclosure Interconnect Bay';
       $service_types['3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889'] = 'Blade Enclosure Interconnect Bay Switch';
       $service_types['49ff2505-7d08-cb5c-64e8-52e0e490c0dc'] = 'Blade Enclosure Interconnect Bay Switch Hostname';
       $service_types['617ab884-61b5-d7a1-1de7-52ad61df4cae'] = 'Blade';
       $service_types['34647ae4-154c-68f3-74ea-52b0c8abc3dc'] = 'Blade Hostname';
       $service_types['b3621853-e25d-0e38-84ff-52c286ae0de9'] = 'Blade VM';
       $service_types['3f6d75b7-c0f5-1739-c66d-52c2989ce02d'] = 'Blade VM Hostname';
       $service_types['77c9dccf-a0a7-05fc-a05f-52ad62515fc7'] = 'Rack Server - 1U';
       $service_types['7835c8b9-f7d5-5d0a-be10-52ad9c866856'] = 'Unit Hostname';
       $service_types['711d9da0-c885-6a0d-1a2c-52c286bd762d'] = 'Unit VM';
       $service_types['7ef914c8-09f8-82c9-d4b9-52c29793ef85'] = 'Unit VM Hostname';
       $service_types['7b5baafb-6f98-5d25-d9c8-541fca790cea'] = 'Rack Storage Unit';
       $service_types['8c8a3231-1d86-0117-4680-541fcbab4f6a'] = 'Rack Storage Hostname';
       $service_types['c194460c-0e8d-ca8e-0aa9-541fc5785016'] = 'Switch Unit';
       $service_types['388b56dc-771e-b743-e63b-541fc6070ab9'] = 'Switch Hostname';
       */

       $service_types = $funky_gear->get_infra();

      /* For testing array - also found in the funky do_filters and Infrastructure 

      if (is_array($service_types)){

         $maintsrv_types_count = count($service_types);
         $current_cnt = 0;

         foreach ($service_types as $serv_key=>$serv_name){

             if ($current_cnt==0){
                $maintsrv_types_arr = "(sclm_configurationitemtypes_id_c='".$serv_key."' "; 
                } elseif ($current_cnt == $maintsrv_types_count-1){
                $maintsrv_types_arr .= "|| sclm_configurationitemtypes_id_c='".$serv_key."') "; 
                 } else {
                $maintsrv_types_arr .= "|| sclm_configurationitemtypes_id_c='".$serv_key."' "; 
                }

             $current_cnt = $current_cnt+1;

             } # for

         } # is array $service_types

        #$maintsrv_types_arr;

       */

       $tblcnt++;

       $tablefields[$tblcnt][0] = "instances"; // Field Name
       $tablefields[$tblcnt][1] = "Number of Inventory Instances (Per Selected SLA)"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'decimal';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '15'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][12] = "15"; // Field ID
       $tablefields[$tblcnt][20] = "instances"; //$field_value_id;
       $tablefields[$tblcnt][21] = $instances; //$field_value;  

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'service_type'; // Field Name
       $tablefields[$tblcnt][1] = "Inventory Service Type"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $service_types; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       #$tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $service_type; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'service_type';//$field_value_id;
       $tablefields[$tblcnt][21] = $service_type; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       $tblcnt++;

       $tablefields[$tblcnt][0] = "service_name"; // Field Name
       $tablefields[$tblcnt][1] = "Inventory Service Name"; // Full Name
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
       $tablefields[$tblcnt][12] = "50"; // Field ID
       $tablefields[$tblcnt][20] = "service_name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $service_name; //$field_value;   

       } # if add

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
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    if ($ci_account_id_c == $account_id_c || $auth==3){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } else {
       $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } 
    $valpack[5] = ""; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["AccountServicesSLAs"]; // container_title
    $container_params[4] = 'ServiceSLA'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $object_return;
    echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

    echo $container_top;
  
    echo $zaform;

    ##########################
    # Show Instances of SLA

    if ($action == 'edit' || $action == 'view' && $sclm_accountsservices_id_c != NULL){

       # Select which CIs relate to the instance with the Account Service ID
       # CIT: 542be154-a211-98cf-84e0-54e6207213bc
       # $val = Accounts Services service_ci_id

       $acc_serv_object_type = "ConfigurationItems";
       $acc_serv_action = "select";
       $acc_serv_params[0] = "name='".$sclm_accountsservices_id_c."' && sclm_configurationitemtypes_id_c='542be154-a211-98cf-84e0-54e6207213bc' && account_id_c='".$sess_account_id."' ";
       $acc_serv_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
       $acc_serv_params[2] = ""; // group;
       $acc_serv_params[3] = ""; // order;
       $acc_serv_params[4] = ""; // limit
  
       $acc_serv_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_serv_object_type, $acc_serv_action, $acc_serv_params);

       if (is_array($acc_serv_items)){

          for ($acc_serv_cnt=0;$acc_serv_cnt < count($acc_serv_items);$acc_serv_cnt++){

              # Account Service CI
              $acc_service_ci_id = $acc_serv_items[$acc_serv_cnt]['id'];
              $acc_service_ci_name = $acc_serv_items[$acc_serv_cnt]['name']; # the Acc Serv ID
                    
              $acc_service_returner = $funky_gear->object_returner ("AccountsServices", $acc_service_ci_name);
              $acc_service_name = $acc_service_returner[0];

              $acc_serv_instance = "Account Service: ".$acc_service_name." -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_service_ci_id."&valuetype=ConfigurationItems');return false\">View Instance Wrapper</a><BR>";

              # Collect the SLA CI Instances under this

              $acc_servsla_object_type = "ConfigurationItems";
              $acc_servsla_action = "select";
              $acc_servsla_params[0] = "sclm_configurationitems_id_c='".$acc_service_ci_id."' && name='".$val."' ";
              $acc_servsla_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
              $acc_servsla_params[2] = ""; // group;
              $acc_servsla_params[3] = ""; // order;
              $acc_servsla_slaparams[4] = ""; // limit
  
              $acc_servsla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_servsla_object_type, $acc_servsla_action, $acc_servsla_params);

              if (is_array($acc_servsla_items)){

                 for ($acc_servsla_cnt=0;$acc_servsla_cnt < count($acc_servsla_items);$acc_servsla_cnt++){

                     # Account Service CI
                     $servicesla_ci_id = $acc_servsla_items[$acc_servsla_cnt]['id'];
                     $servicesla_ci_name = $acc_servsla_items[$acc_servsla_cnt]['name']; # the Acc Serv SLA ID

                     $servicesla_returner = $funky_gear->object_returner ("AccountsServicesSLAs", $servicesla_ci_name);
                     $servicesla_name = $servicesla_returner[0];

                     #$servicesla_ci_type = $acc_servsla_items[$acc_servsla_cnt]['sclm_configurationitemtypes_id_c'];
                     #$acc_serv_instance .= " -> ".$servicesla_name." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$servicesla_ci_id."&valuetype=ConfigurationItems');return false\">View Instance</a><BR>";

                     $acc_serv_instance .= " -> Allocate ".$servicesla_name."<BR>"; 

                     } # for

                 } # is array

              } # for

          $acc_serv_instance = "<div style=\"border:1px solid ".$border_color.";border-radius:1px;width:100%;float:left;padding-top:5;overflow:auto;max-height:200px;\">".$acc_serv_instance."</div>";

          echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Service Instances for Allocation</B></font></center></div>";
          echo "<BR><img src=images/blank.gif width=90% height=5><BR>";


          echo "<div style=\"".$divstyle_white."\">".$acc_serv_instance."</div>";

          } # is array

       # Show Instances of SLA
       ##########################

       } # edit/view

    # Present Features
    /*

    Product Components
    -> CIT: Accounts Services SLA Features: 399a1a2c-5038-8d99-20bf-54e8c81f35a9
       -> CI: Accounts Services SLAs ID (name) as parent
          -> CI: Selected Colours (with Colours as CIT) as children
    -> CIT: Product Colours
       -> CI: Colours

    */
    if ($action != 'add' && $sess_account_id != NULL && $sess_account_id==$ci_account_id_c){

       $sendiv = "FEATURES";

       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Offer Features</B></font></center></div>";
       echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
       echo "<div style=\"".$divstyle_blue."\" name='FEATURES' id='FEATURES'></div>";
       echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

       $slafeature_object_type = "ConfigurationItems";
       $slafeature_action = "select";
       $feature_type_id = '399a1a2c-5038-8d99-20bf-54e8c81f35a9';
       $slafeature_params[0] = " name='".$val."' && sclm_configurationitemtypes_id_c='".$feature_type_id."' ";
       $slafeature_params[1] = "id"; // select array
       $slafeature_params[2] = ""; // group;
       $slafeature_params[3] = ""; // order;
       $slafeature_params[4] = ""; // limit
  
       $slafeatures = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slafeature_object_type, $slafeature_action, $slafeature_params);    

       if (is_array($slafeatures)){

          for ($slafcnt=0;$slafcnt < count($slafeatures);$slafcnt++){

              $par_ci_id = $slafeatures[$slafcnt]['id']; # The feature wrapper

              # Select any feature types that are under this SLA

              $featurebit_object_type = "ConfigurationItems";
              $featurebit_action = "select";
              $featurebit_params[0] = " sclm_configurationitems_id_c='".$par_ci_id."' ";
              $featurebit_params[1] = "id,name,enabled,account_id_c,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
              $featurebit_params[2] = ""; // group;
              $featurebit_params[3] = ""; // order;
              $featurebit_params[4] = ""; // limit
  
              $featurebits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $featurebit_object_type, $featurebit_action, $featurebit_params);    
              if (is_array($featurebits)){

                 for ($fcnt=0;$fcnt < count($featurebits);$fcnt++){

                     $ci_id = $featurebits[$fcnt]['id'];
                     $feature_nameparts = $featurebits[$fcnt]['name'];
                     $ci_account_id_c = $featurebits[$fcnt]['account_id_c'];
                     $enabled = $featurebits[$fcnt]['enabled'];
                     $enabled = "[Enabled: <B>".$funky_gear->yesno($enabled)."</B>] ";

                     list($feature_type_id,$feature_name_id) = explode('[XXX]',$feature_nameparts);
                     #$feature_type_id = $featurebits[$fcnt]['sclm_configurationitemtypes_id_c'];
                     $feature_returner = $funky_gear->object_returner ("ConfigurationItems", $feature_name_id);
                     $feature_name = $feature_returner[0];
                     $featuretype_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $feature_type_id);
                     $feature_type_name = $featuretype_returner[0];

                     if ($sess_account_id != NULL && $sess_account_id==$ci_account_id_c){
                        $edit = "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$ci_id."&valuetype=ConfigurationItems&parent_ci=".$par_ci_id."&sendiv=".$sendiv."');return false\"><font color=red>[".$strings["action_edit"]."]</font></a>";
                        }

                     #$sla_feature[$feature_type_id][] = $feature_id;

                     if ($feature_type_id == 'e027d211-75c9-d360-17cb-54e8577757ca'){# if colours
                        # Colours
                        list($colourname,$hex) = explode('_',$feature_name);
                        $featurelink .= $enabled."Feature: ".$feature_type_name.": ".$edit." <font color=".$hex."><B>".$colourname."</B></font><BR>";

                        } elseif ($feature_type_id == 'a4b786aa-5f30-2258-8226-52ad30ae0f35'){ # if OS

                        $featurelink .= $enabled."Feature: ".$feature_type_name.":  ".$edit." <B>".$feature_name."</B><BR>";

                        }

                     } # for

                 } else {# is array

                 }

              # Provide links to add features within the wrapper
              $featurelink .= "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=e027d211-75c9-d360-17cb-54e8577757ca&valuetype=ConfigurationItemTypes&parent_ci=".$par_ci_id."&sendiv=".$sendiv."');return false\"><img src=images/icons/plus.gif width=16 border=0><B>Add Colours</B></a><BR>";
              $featurelink .= "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=a4b786aa-5f30-2258-8226-52ad30ae0f35&valuetype=ConfigurationItemTypes&parent_ci=".$par_ci_id."&sendiv=".$sendiv."');return false\"><img src=images/icons/plus.gif width=16 border=0><B>Add OS</B></a><BR>";

              } # for

          } else { # is array
          
          # Provide add sla wrapper

          $featurelink .= "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$feature_type_id."&valuetype=ConfigurationItemTypes&accservsla=".$val."&sendiv=".$sendiv."');return false\"><img src=images/icons/plus.gif width=16 border=0><B>Add SLA Feature Wrapper</B></a>";

          } 

       } # end if not add

    $featurelink = "<div style=\"".$divstyle_white."\">".$featurelink."</div>";

    echo $featurelink;

    echo $container_bottom;

    #
    ###################
    #

    if ($action == 'view' && $sess_account_id != NULL && ($ci_account_id_c == $sess_account_id || $auth==3)){

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

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'Tickets','list',$val,$do,$bodywidth);

       echo $container_bottom;

       #
       ###################
       #

       }

/*

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Related SLAs'; // container_title
       $container_params[4] = 'SLAs'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'ServicesSLA','list',$val,"ServicesSLA",$bodywidth);
*/
       #
       ###################
       #
/*
       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Available Resources'; // container_title
       $container_params[4] = 'ContactsServicesSLA'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'ContactsServicesSLA','list',$sclm_servicessla_id_c,'ServicesSLA',$bodywidth);

       echo $container_bottom;
*/

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

    if (!$_POST['sclm_accountsservices_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["AccountsService"]."</font><P>";
       }   

    if (!$error){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
       $process_params[] = array('name'=>'sclm_servicessla_id_c','value' => $_POST['sclm_servicessla_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'sclm_accountsservices_id_c','value' => $_POST['sclm_accountsservices_id_c']);

       $accountsservicesslas_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($accountsservicesslas_result['id'] != NULL){
          $accountsservicesslas_id_c = $accountsservicesslas_result['id'];
          }

       $sclm_accountsservices_id_c = $_POST['sclm_accountsservices_id_c'];

       $process_message = $do." submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$accountsservicesslas_id_c."&valuetype=".$valtype."');return false\">here!</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

       #######################
       # Newly added Account Service - add an instance regardless

       $instances = $_POST['instances'];
       $service_type = $_POST['service_type'];
       $service_name = $_POST['service_name'];

       if ($_POST['id'] == NULL && $sclm_accountsservices_id_c != NULL && $accountsservicesslas_id_c != NULL){

          # Select which CIs relate to the instance with the Account Service ID
          # CIT: 542be154-a211-98cf-84e0-54e6207213bc
          # $val = Accounts Services service_ci_id

          $acc_serv_object_type = "ConfigurationItems";
          $acc_serv_action = "select";
          $acc_serv_params[0] = "name='".$sclm_accountsservices_id_c."' && sclm_configurationitemtypes_id_c='542be154-a211-98cf-84e0-54e6207213bc' && account_id_c='".$sess_account_id."' ";
          $acc_serv_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
          $acc_serv_params[2] = ""; // group;
          $acc_serv_params[3] = ""; // order;
          $acc_serv_params[4] = ""; // limit
  
          $acc_serv_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_serv_object_type, $acc_serv_action, $acc_serv_params);

          if (is_array($acc_serv_items)){

             for ($acc_serv_cnt=0;$acc_serv_cnt < count($acc_serv_items);$acc_serv_cnt++){

                 # Account Service CI
                 $acc_service_ci_id = $acc_serv_items[$acc_serv_cnt]['id'];
                 $acc_service_ci_name = $acc_serv_items[$acc_serv_cnt]['name']; # the Acc Serv ID
                    
                 #$acc_service_returner = $funky_gear->object_returner ("AccountsServices", $acc_service_ci_name);
                 #$acc_service_name = $acc_service_returner[0];

                 } # for

             } else {

             # Instance doesn't exist - must create

             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = "";
             $process_params = array();

             $acc_service_instance = '542be154-a211-98cf-84e0-54e6207213bc';
             $acc_service_image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_service_instance);
             $acc_service_image_url = $acc_service_image_returner[7];

             $acc_service_returner = $funky_gear->object_returner ("AccountsServices", $sclm_accountsservices_id_c);
             $acc_service_name = $acc_service_returner[1];
             $instance_name = $acc_service_name." -> Instances";

             $process_params[] = array('name'=>'name','value' => $sclm_accountsservices_id_c); # Acc Service ID
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'description','value' => $instance_name);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_service_instance);
             $process_params[] = array('name'=>'image_url','value' => $acc_service_image_url);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
             #$process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
             #$process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
             #$process_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
             #$process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
             #$process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
             $process_params[] = array('name'=>'enabled','value' => 1);

             $acc_service_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $acc_service_ci_id = $acc_service_result['id'];

             } # is array 

          if ($acc_service_ci_id != NULL && $service_type != NULL && $accountsservicesslas_id_c != NULL){
             $acc_servicesla_image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $service_type);
             $acc_servicesla_image_url = $acc_servicesla_image_returner[7];

             # Account Service Instance to be parent CI for actual service types (infra)

             if ($instances == NULL){
                $instances = 1;
                }

             # Number of instances per Account Service SLA

             for ($accsla_cnt=0;$accsla_cnt < $instances;$accsla_cnt++){

                 $acc_serv_process_object_type = "ConfigurationItems";
                 $acc_serv_process_action = "update";
                 $acc_serv_process_params = "";
                 $acc_serv_process_params = array();  

                 #$acc_serv_process_params[] = array('name'=>'id','value' => );
                 $acc_serv_sla_name = $service_name."-".$accsla_cnt;
                 $acc_serv_process_params[] = array('name'=>'name','value' => $accountsservicesslas_id_c); # CI name for child
                 $acc_serv_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                 $acc_serv_process_params[] = array('name'=>'description','value' => $acc_serv_sla_name);
                 $acc_serv_process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                 $acc_serv_process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                 #acc_serv_process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
                 $acc_serv_process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $service_type);
                 $acc_serv_process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $acc_service_ci_id); # Becomes Parent CI
                 $acc_serv_process_params[] = array('name'=>'image_url','value' => $acc_servicesla_image_url);
                 $acc_serv_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                 #acc_serv_process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
                 #acc_serv_process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
                 #acc_serv_process_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
                 #$acc_serv_process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
                 #$acc_serv_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
                 $acc_serv_process_params[] = array('name'=>'enabled','value' => 1);
                      
                 $acc_serv_sla_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $acc_serv_process_object_type, $acc_serv_process_action, $acc_serv_process_params);

                 if ($acc_serv_sla_result['id'] != NULL){
                    $acc_serv_sla_id = $acc_serv_sla_result['id'];

                    $process_message .= $acc_serv_sla_name." Service Type Instance submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_serv_sla_id."&valuetype=AccountsServices');return false\">here!</a><BR>";

                    } # if added

                 } # for number of instances

             } # if $acc_service_ci_id 

          } # if !post

       # Service Types
       #######################

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>