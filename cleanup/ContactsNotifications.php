<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: ContactsNotifications.php 
##########################################################
# case 'ContactsNotifications':

  switch ($valtype){

   case '':

    if ($account_id_c != NULL){
       $valtype = 'Accounts';
       $object_return_params[0] = " account_id_c='".$account_id_c."' ";
       } else {
       $object_return_params[0] = " account_id_c='' ";
       } 

   break;
   case 'Accounts':

    $object_return_params[0] = " account_id_c='".$val."' ";

   break;
   case 'ServiceSLARequests':

    $returner = $funky_gear->object_returner ('ServiceSLARequests', $val);
    $object_return = $returner[1];
    echo $object_return;

   break;

  }

//echo "Params $object_return_params[0] <P>";


  switch ($action){
   
   case 'list':
   
    ################################
    # List
    
    if ($valtype == 'Search' || $val != NULL){
       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["NotificationContacts"]."</B></font></center></div>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       echo "<center><img src=images/icons/Email-100x100.png width=50 border=0 alt=\"".$strings["NotificationContacts"]."\"></center>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       }

    $sow_object_type = $do;
    $sow_action = "select";
    $sow_params[0] = $object_return_params[0];
    $sow_params[1] = ""; // select array
    $sow_params[2] = ""; // group;
    $sow_params[3] = ""; // order;
    $sow_params[4] = ""; // limit
  
    $sow = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sow_object_type, $sow_action, $sow_params);

    if (is_array($sow)){

       $count = count($sow);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $sow_params[4] = " $lfrom , $glb_perpage_items "; 

       $sow = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sow_object_type, $sow_action, $sow_params);

       for ($cnt=0;$cnt < count($sow);$cnt++){

           $id = $sow[$cnt]['id'];
           $date_entered = $sow[$cnt]['date_entered'];
           $date_modified = $sow[$cnt]['date_modified'];
           $modified_user_id = $sow[$cnt]['modified_user_id'];
           $created_by = $sow[$cnt]['created_by'];

           $name = $sow[$cnt]['name'];
           $description = $sow[$cnt]['description'];

           $deleted = $sow[$cnt]['deleted'];
           $assigned_user_id = $sow[$cnt]['assigned_user_id'];
           $sclm_serviceslarequests_id_c = $sow[$cnt]['sclm_serviceslarequests_id_c'];
           $contact_id_c = $sow[$cnt]['contact_id_c'];
           $account_id_c = $sow[$cnt]['account_id_c'];

           if ($sow[$cnt][$lingoname] != NULL){
              $name = $sow[$cnt][$lingoname];
              }

           $cmn_languages_id_c = $sow[$cnt]['cmn_languages_id_c'];
           $cmn_statuses_id_c = $sow[$cnt]['cmn_statuses_id_c'];
           if ($cmn_statuses_id_c){
              $status = $sow[$cnt]['cmn_statuses_name'];
              }

           $edit = "";
           if ($sess_contact_id != NULL && $sess_contact_id==$contact_id_c){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $sows .= "<div style=\"".$divstyle_white."\"> ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>[".$status."] ".$name."</B></a></div>";

           } // end for

       } else { // end if array

       $sows = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL){    
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($sow)>10){
       echo $addnew.$sows.$addnew;
       } else {
       echo $sows.$addnew;
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

    if ($action == 'add' || $valtype == 'ServiceSLARequests'){ 
       $sclm_serviceslarequests_id_c = $val;
       }

    if ($action == 'edit' || $action == 'view'){ 

       $sow_object_type = $do;
       $sow_action = "select";
       $sow_params[0] = " id='".$val."' ";
       $sow_params[1] = ""; // select array
       $sow_params[2] = ""; // group;
       $sow_params[3] = ""; // order;
       $sow_params[4] = ""; // limit
  
       $sow = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sow_object_type, $sow_action, $sow_params);

       if (is_array($sow)){

          for ($cnt=0;$cnt < count($sow);$cnt++){

              $id = $sow[$cnt]['id'];
              $name = $sow[$cnt]['name'];
              $date_entered = $sow[$cnt]['date_entered'];
              $date_modified = $sow[$cnt]['date_modified'];
              $modified_user_id = $sow[$cnt]['modified_user_id'];
              $created_by = $sow[$cnt]['created_by'];
              $description = $sow[$cnt]['description'];
              $deleted = $sow[$cnt]['deleted'];
              $assigned_user_id = $sow[$cnt]['assigned_user_id'];
              $contact_id_c = $sow[$cnt]['contact_id_c'];
              $account_id_c = $sow[$cnt]['account_id_c'];
              $sclm_serviceslarequests_id_c = $sow[$cnt]['sclm_serviceslarequests_id_c'];
              $cmn_languages_id_c = $sow[$cnt]['cmn_languages_id_c'];
              $cmn_statuses_id_c = $sow[$cnt]['cmn_statuses_id_c'];
   
              } // end for projects

          $field_lingo_pack = $funky_gear->lingo_data_pack ($sow, $name, $description, $name_field_base,$desc_field_base);

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

    if ($action == 'view'){

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

    }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_serviceslarequests_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLARequest"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_serviceslarequests'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' ";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_serviceslarequests_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServiceSLARequests';
    $tablefields[$tblcnt][9][7] = "sclm_serviceslarequests"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ServiceSLARequests'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_serviceslarequests_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "sclm_serviceslarequests_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_serviceslarequests_id_c; //$field_value;   

/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_serviceslarequests_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLARequests"]; // Full Name
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
    $tablefields[$tblcnt][20] = "sclm_serviceslarequests_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_serviceslarequests_id_c; //$field_value;   
    $tablefields[$tblcnt][41] = 0;
*/
    if ($action == 'add'){

       ##############################
       # Related Account Contacts

       $ci_object_type = "AccountRelationships";
       $ci_action = "select";
       $ci_params[0] = " account_id_c='".$account_id_c."' || account_id1_c='".$account_id_c."' ";
       $ci_params[1] = "id,name,account_id_c,account_id1_c"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $account_name = $ci_items[$cnt]['name'];
/*
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $description = $ci_items[$cnt]['description'];
              $deleted = $ci_items[$cnt]['deleted'];
*/
              $parent_account_id = $ci_items[$cnt]['parent_account_id'];
              $child_account_id = $ci_items[$cnt]['child_account_id'];
//            $entity_type = $ci_items[$cnt]['entity_type'];

              #########################################
              #

              $contact_object_type = "Accounts";
              $contact_action = "select_contacts";

              if ($account_id_c == $parent_account_id){
                 $contact_params[0] = " deleted=0 && account_id='".$child_account_id."' ";
                 }

              if ($account_id_c == $child_account_id){
                 $contact_params[0] = " deleted=0 && account_id='".$parent_account_id."' ";
                 }
              
              $contact_params[1] = "*";
              $contact_params[2] = "";
              $contact_params[3] = "";
              $contact_params[4] = "";
 
              $items_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);

              $rel_contacts = "";

              for ($relcnt=0;$relcnt < count($items_list);$relcnt++){

                  $contact_id = $items_list[$relcnt]['contact_id'];
                  $first_name = $items_list[$relcnt]['first_name'];
                  $last_name = $items_list[$relcnt]['last_name'];
                  $ddpack[$contact_id] = $account_name.": <B>".$first_name." ".$last_name."</B>";

                  }

              } // end for AccountRelationships

          } // end is arrauy AccountRelationships

       // Add array of own account contacts for selection also
       $contact_object_type = "Accounts";
       $contact_action = "select_contacts";
       $contact_params[0] = " deleted=0 && account_id='".$account_id_c."' ";
       $contact_params[1] = "*";
       $contact_params[2] = "";
       $contact_params[3] = "";
       $contact_params[4] = "";
 
       $items_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);

       $acc_returner = $funky_gear->object_returner ("Accounts", $account_id_c);
       $account_name = $acc_returner[0];

       for ($relcnt=0;$relcnt < count($items_list);$relcnt++){

           $contact_id = $items_list[$relcnt]['contact_id'];
           $first_name = $items_list[$relcnt]['first_name'];
           $last_name = $items_list[$relcnt]['last_name'];
           $ddpack[$contact_id] = $account_name.": <B>".$first_name." ".$last_name."</B>";

           }

       // Search CIs to see if type 
       if (is_array($ddpack)){

          foreach ($ddpack as $contact_id => $contact_name){

                  $tblcnt++;

                  $tablefields[$tblcnt][0] = "contact_id_".$contact_id; // Field Name
                  $tablefields[$tblcnt][1] = $contact_name; // Full Name
                  $tablefields[$tblcnt][2] = 0; // is_primary
                  $tablefields[$tblcnt][3] = 0; // is_autoincrement
                  $tablefields[$tblcnt][4] = 0; // is_name
                  $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
                  $tablefields[$tblcnt][6] = '255'; // length
                  $tablefields[$tblcnt][7] = '0'; // NULLOK?
                  $tablefields[$tblcnt][8] = ''; // default
                  $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
                  $tablefields[$tblcnt][10] = '1';//1; // show in view 
                  $tablefields[$tblcnt][11] = ""; // Field ID
                  $tablefields[$tblcnt][20] = "contact_id_".$contact_id; //$field_value_id;

                  // Check to see if already in this sla request
                  $cr_object_type = "ContactsNotifications";
                  $cr_action = "select";
                  $cr_params[0] = " sclm_serviceslarequests_id_c='".$val."' && contact_id_c='".$contact_id."' ";
                  $cr_params[1] = "sclm_serviceslarequests_id_c,contact_id_c,cmn_statuses_id_c"; // select array
                  $cr_params[2] = ""; // group;
                  $cr_params[3] = ""; // order;
                  $cr_params[4] = ""; // limit

                  $cr_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cr_object_type, $cr_action, $cr_params);

                  if (is_array($cr_items)){
                     // Does exist
                     for ($irelcnt=0;$irelcnt < count($cr_items);$irelcnt++){
                         $notify_cmn_statuses_id_c = $cr_items[$irelcnt]['cmn_statuses_id_c'];
                         // Does exist
                         if ($notify_cmn_statuses_id_c == $standard_statuses_closed){
                            $tablefields[$tblcnt][21] = "0"; //$field_value;
                            } else {
                            $tablefields[$tblcnt][21] = "1"; //$field_value;
                            }
                         } // for

                     } else {

                     $tablefields[$tblcnt][21] = "0"; //$field_value;

                     } 

                  $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

                  } // end foreach

          } // end if array

       } else { // end if action add

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
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " account_id_c='".$portal_account_id."' ";
       $acc_params[1] = " account_id1_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id1_c "; // order;
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
       $acc_params[1] = " account_id_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id_c "; // order;
       $acc_params[4] = ""; // limit
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $parent_account_id = $acc_items[$acc_cnt]['parent_account_id'];
              $parent_account_name = $acc_items[$acc_cnt]['parent_account_name'];
              $ddpack[$parent_account_id]=$parent_account_name;

              }
          }

       $acc_returner = $funky_gear->object_returner ("Accounts", $account_id_c);
       $object_return_name = $acc_returner[0];
//       $object_return = $returner[1];
//       $object_return_title = $acc_returner[2];
       $ddpack[$account_id_c]=$object_return_name;

       $tablefields[$tblcnt][9][1] = $ddpack;
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
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       if (is_array($ddpack)){

          foreach ($ddpack as $parent_account_id => $parent_account_name){
            
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
       $tablefields[$tblcnt][9][3] = 'first_name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

       }

    if ($action == 'view'){

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

    }

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // provide add new button
    $valpack[7] = $strings["NotificationContactsSet"];

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
    $container_params[3] = $strings["NotificationContacts"]; // container_title
    $container_params[4] = 'NotificationContacts'; // container_label
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

    #
    ###################

   break; // end view
   case 'process':

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if (!$_POST['sclm_serviceslarequests_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["ServiceSLARequest"]."</font><P>";
       }

    $process_object_type = $do;
    $process_action = "update";

    if (!$error){

       if (!$_POST['id']){

          foreach ($_POST as $contact_id_key=>$contact_id_value){

               $contact_id = str_replace("contact_id_","",$contact_id_key);

               if ($contact_id){
                  // Check to see if already in this sla request
                  $cr_object_type = "ContactsNotifications";
                  $cr_action = "select";
                  $cr_params[0] = " sclm_serviceslarequests_id_c='".$_POST['sclm_serviceslarequests_id_c']."' && contact_id_c='".$contact_id."' ";
                  $cr_params[1] = "id,sclm_serviceslarequests_id_c,contact_id_c,cmn_statuses_id_c"; // select array
                  $cr_params[2] = ""; // group;
                  $cr_params[3] = ""; // order;
                  $cr_params[4] = ""; // limit

                  $cr_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cr_object_type, $cr_action, $cr_params);

                  if (is_array($cr_items)){
                     // Does exist
                     if ($contact_id_value == 1){
                        $notify_cmn_statuses_id_c = $standard_statuses_open_public;
                        } else {
                        $notify_cmn_statuses_id_c = $standard_statuses_closed;
                        }

                     // Update with status
                     $sla_returner = $funky_gear->object_returner ('ServiceSLARequests', $_POST['sclm_serviceslarequests_id_c']);
                     $firstname_returner = $funky_gear->object_returner ('Contacts', $contact_id);
                     $firstname = $firstname_returner[0];
                     $notification_name = $firstname."->".$sla_returner[0]." ".$strings["NotificationContacts"];
                     $notification_desc = $notification_name;

                     for ($irelcnt=0;$irelcnt < count($cr_items);$irelcnt++){

                         $id = $cr_items[$irelcnt]['id'];

                         $process_params = array();  
                         $process_params[] = array('name'=>'id','value' => $id);
                         $process_params[] = array('name'=>'name','value' => $notification_name);
                         $process_params[] = array('name'=>'description','value' => $notification_desc);
                         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $notify_cmn_statuses_id_c);

                         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                         if ($result['id'] != NULL){

                            $val = $result['id'];
                            $process_message .= $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";
                            $process_message .= "<B>".$strings["Name"].":</B> ".$notification_name;

                            } // if result
 
                         } // for

                     } else {
   
                     if ($contact_id_value == 1){

                        $accid_object_type = "Contacts";
                        $accid_action = "get_account_id";
                        $accid_params[0] = $contact_id;
                        $accid_params[1] = "account_id";
                        $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);
 
                        $sla_returner = $funky_gear->object_returner ('ServiceSLARequests', $_POST['sclm_serviceslarequests_id_c']);
                        $firstname_returner = $funky_gear->object_returner ('Contacts', $contact_id);
                        $firstname = $firstname_returner[0];
                        $notification_name = $firstname."->".$sla_returner[0]." ".$strings["NotificationContacts"];
                        $notification_desc = $notification_name;

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $notification_name);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
                        $process_params[] = array('name'=>'description','value' => $notification_desc);
                        $process_params[] = array('name'=>'contact_id_c','value' => $contact_id);
                        $process_params[] = array('name'=>'account_id_c','value' => $account_id);
                        $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $_POST['sclm_serviceslarequests_id_c']);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
                        $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
 
                        if ($result['id'] != NULL){

                           $val = $result['id'];
                           $process_message .= $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";
                           $process_message .= "<B>".$strings["Name"].":</B> ".$notification_name;

                           } // if result

                        } // if contact value=1

                     } // if array

                  } // if contact
 
               } // foreach

          } else {

          if (!$_POST['account_id_c']){
             $accid_object_type = "Contacts";
             $accid_action = "get_account_id";
             $accid_params[0] = $_POST['contact_id_c'];
             $accid_params[1] = "account_id";
             $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);
             } else {
             $account_id = $_POST['account_id_c'];
             } 
 
          $sla_returner = $funky_gear->object_returner ('ServiceSLARequests', $_POST['sclm_serviceslarequests_id_c']);
          $firstname_returner = $funky_gear->object_returner ('Contacts', $_POST['contact_id_c']);
          $firstname = $firstname_returner[0];
          $notification_name = $firstname."->".$sla_returner[0]." ".$strings["NotificationContacts"];
          $notification_desc = $notification_name;

          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $_POST['id']);
          $process_params[] = array('name'=>'name','value' => $notification_name);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $notification_desc);
          $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $_POST['sclm_serviceslarequests_id_c']);
          $process_params[] = array('name'=>'account_id_c','value' => $account_id);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
          $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          if ($result['id'] != NULL){
             $val = $result['id'];

             $process_message .= $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

             $process_message .= "<B>".$strings["Name"].":</B> ".$notification_name."<BR>";

             } // if result

          } // if id

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>