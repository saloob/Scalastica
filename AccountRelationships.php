<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: AccountRelationships.php 
##########################################################
# case 'AccountRelationships':

  #echo "SESS: ".$sess_account_id." AND ACC:".$account_id_c." AND PAR: ".$parent_account_id." AND POR: ".$portal_account_id."<P>"; 

  if (!$val){
     $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' || account_id1_c='".$sess_account_id."' ";
     } else {
     $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' || account_id1_c='".$val."' ";
     }

  switch ($action){
   
   case 'list':
   
    ################################
    # List
    
    $ci_object_type = $do;
    $ci_action = "select";
    $ci_params[1] = "id,name,date_entered,account_id_c,account_id1_c,entity_type"; // select array
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
/*
           $date_entered = $ci_items[$cnt]['date_entered'];
           $date_modified = $ci_items[$cnt]['date_modified'];
           $modified_user_id = $ci_items[$cnt]['modified_user_id'];
           $created_by = $ci_items[$cnt]['created_by'];
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
*/

           $par_account_id = $ci_items[$cnt]['parent_account_id'];
           $child_account_id = $ci_items[$cnt]['child_account_id'];
           $entity_type = $ci_items[$cnt]['entity_type'];

           if ($auth == 3){
              $show_id = "<BR>Relationship ID: ".$id."<BR>Parent ID: ".$parent_account_id."<BR>Child ID: ".$child_account_id;
              } else {
              $show_id = "";
              }

           $edit = "";
           if ($sess_account_id != NULL && $sess_account_id == $par_account_id){
              $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $cis .= "<div style=\"".$divstyle_grey."\">".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a>".$show_id."</div>";

           #########################################
           # Show contacts for Entities

           if ($valtype == 'Contacts'){

              $contact_object_type = "Accounts";
              $contact_action = "select_contacts";

              if ($account_id_c == $par_account_id){
                 $contact_params[0] = " deleted=0 && account_id='".$child_account_id."' ";
                 }

              if ($account_id_c == $child_account_id){
                 $contact_params[0] = " deleted=0 && account_id='".$par_account_id."' ";
                 }
              
              $contact_params[1] = "*";
              $contact_params[2] = "";
              $contact_params[3] = " date_modified DESC ";
              $contact_params[4] = " $lfrom , $glb_perpage_items ";
 
              $items_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);

              $rel_contacts = "";

              for ($relcnt=0;$relcnt < count($items_list);$relcnt++){

                  $rel_contact_id = $items_list[$relcnt]['contact_id'];
                  $rel_first_name = $items_list[$relcnt]['first_name'];
                  $rel_last_name = $items_list[$relcnt]['last_name'];

                  if (($sess_contact_id == $rel_contact_id && $sess_contact_id != NULL) || $auth==3 || $is_admin==TRUE){
     
                     $rel_edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=edit&value=".$rel_contact_id."&valuetype=Contacts');return false\"><font color=RED><B> [".$strings["action_edit"]."] </B></font></a>";

                     } else {// end if admin
                     $rel_edit = "";
                     } 

                  $sendmessage = "";
                  $sendmessage = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$rel_contact_id."&valuetype=Contacts&sendiv=lightform&related=".$valtype."&relval=".$val."');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'></a>";

                  $rel_contacts .= $rel_edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$rel_contact_id."&valuetype=Contacts');return false\"><font color=#151B54>".$rel_first_name." ".$rel_last_name."</font></a> ".$sendmessage."<BR>";

                  } // end for

              $cis .= "<div style=\"".$divstyle_white."\">".$rel_contacts."</div>";

              } // end if

           # End showing Contacts
           #########################################
      
           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }
    
    if ($portal_account_id == $account_id_c || $auth==3){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$do."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       } else {
       $addnew = "";
       } 

    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;

    # End List Entities
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    #echo "val $val <P>";

    if ($action == 'add'){ 
       $record_account_id = $sess_account_id;
       $child_account_id = $val;
       }

    if ($action == 'edit' || $action == 'view'){ 

       $ci_object_type = $do;
       $ci_action = "select";
       $ci_params[0] = " id='".$val."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
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
              $par_account_id = $ci_items[$cnt]['parent_account_id'];
              $record_account_id = $par_account_id;
              $child_account_id = $ci_items[$cnt]['child_account_id'];
              $entity_type = $ci_items[$cnt]['entity_type'];
              $ci_type_id = $ci_items[$cnt]['ci_type_id'];
              $ci_data_type = $ci_items[$cnt]['ci_data_type'];

              } // end for

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
    $tablefields[$tblcnt][11] = $id; // Field ID
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
    $tablefields[$tblcnt][11] = $name; // Field ID
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value;   

    $tblcnt++;

    if ($action == 'view' || $auth==3){

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = "Parent Account"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'accounts_cstm,accounts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($auth == 3){
          $tablefields[$tblcnt][9][4] = ""; //exception;
          } elseif ($auth < 3){
#          $tablefields[$tblcnt][9][4] = "accounts.id=accounts_cstm.id_c && (accounts.id='".$sess_account_id."' || accounts_cstm.status_c != '".$standard_statuses_closed."') "; //exception;
          if ($sess_account_id){
             $tablefields[$tblcnt][9][4] = "accounts.id=accounts_cstm.id_c && (accounts.id='".$sess_account_id."' || accounts_cstm.status_c != '".$standard_statuses_closed."') "; //exception; 
             } else {
             $tablefields[$tblcnt][9][4] = "accounts.id=accounts_cstm.id_c && accounts_cstm.status_c != '".$standard_statuses_closed."') "; //exception; 
             }
          } 

       $tablefields[$tblcnt][9][5] = $record_account_id; // Current Value
       $tablefields[$tblcnt][9][6] = "Accounts";
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "account_id_c";//$field_value_id;
       $tablefields[$tblcnt][21] = $record_account_id; //$field_value; 

       } else {

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = ""; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $record_account_id; // Field ID
       $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $record_account_id; //$field_value;   

       }

    $tblcnt++;

    $acc_object_type = "Accounts";
    $acc_action = "select";

    if ($child_account_id != NULL){
       $acc_params[0] = "id='".$child_account_id."'";    
       } else {
       $acc_params[0] = "deleted=0";
       } 

    $items_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

    if (is_array($items_list)){

       for ($cnt=0;$cnt < count($items_list);$cnt++){

           $search_params = "";
           $acc_cstm_params = "";

           $id = $items_list[$cnt]['id'];
           $name = $items_list[$cnt]['name'];

           $acc_cstm_object_type = "Accounts";
           $acc_cstm_action = "select_cstm";

           if ($auth == 3){
              $acc_cstm_params[0] = ""; //exception;
              } elseif ($auth < 3){
              if ($sess_account_id){
                 $acc_cstm_params[0] = "id_c='".$sess_account_id."' || accounts_cstm.status_c != '".$standard_statuses_closed."'";
                 } else {
                 $acc_cstm_params[0] = " accounts_cstm.status_c != '".$standard_statuses_closed."' ";
                 }
              } 

           # = "id_c='".$id."' && status_c !='".$standard_statuses_closed."'";
           $acc_cstm_params[1] = ""; // select
           $acc_cstm_params[2] = ""; // group;
           $acc_cstm_params[3] = ""; // order;
           $acc_cstm_params[4] = ""; // limit

           $account_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_cstm_object_type, $acc_cstm_action, $acc_cstm_params);

           if (is_array($account_cstm_info)){

              $dd_pack[$id] = $name;

              } # is array

           } # for

       } # is array

    $tablefields[$tblcnt][0] = "account_id1_c"; // Field Name
    $tablefields[$tblcnt][1] = "Child Account"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";
    $tablefields[$tblcnt][9][5] = $child_account_id; // Current Value
    $tablefields[$tblcnt][9][6] = "Accounts";
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $child_account_id; // Field ID
    $tablefields[$tblcnt][20] = "account_id1_c";//$field_value_id;
    $tablefields[$tblcnt][21] = $child_account_id; //$field_value;   

    $tblcnt++;

    if ($action == 'add' || $action == 'edit' || $system_access){

    $tablefields[$tblcnt][0] = 'entity_type'; // Field Name
    $tablefields[$tblcnt][1] = "Account Type"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='a867fcdd-218a-34be-d0f2-51ca18235609' ";//$exception;
    $tablefields[$tblcnt][9][5] = $entity_type; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
/*
    $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItemTypes'; //new do
    $tablefields[$tblcnt][9][9] = $ci_type_id; // Current Value
    $params['ci_type_id'] = 'a867fcdd-218a-34be-d0f2-51ca18235609';
    $params['ci_data_type'] = $ci_data_type;
    $params['ci_name_field'] = "entity_type";
    $params['ci_name'] = $entity_type;
    $tablefields[$tblcnt][9][10] = $params; // Various Params
*/
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'entity_type';//$field_value_id;
    $tablefields[$tblcnt][21] = $entity_type; //$field_value;

    } else {

    $tablefields[$tblcnt][0] = 'entity_type'; // Field Name
    $tablefields[$tblcnt][1] = "Account Type"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='a867fcdd-218a-34be-d0f2-51ca18235609' ";//$exception;
    $tablefields[$tblcnt][9][5] = $entity_type; // Current Value
/*    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $entity_type; // Current Value
    $params['ci_type_id'] = 'a867fcdd-218a-34be-d0f2-51ca18235609';
    $params['ci_data_type'] = $ci_data_type;
    $params['ci_name_field'] = "entity_type";
    $params['ci_name'] = $entity_type;
    $tablefields[$tblcnt][9][10] = $params; // Various Params
*/
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'entity_type';//$field_value_id;
    $tablefields[$tblcnt][21] = $entity_type; //$field_value;

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

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if (($sess_account_id != NULL && $sess_account_id == $par_account_id && $sess_contact_id != NULL) || $auth==3){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } else {
       $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } 
    $valpack[5] = ""; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    #echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["AccountRelationships"]."</B></font></center></div>";

    $returner = $funky_gear->object_returner ('Accounts', $parent_account_id);
    $object_return = $returner[1];
    echo $object_return;

    if ($sess_account_id != $child_account_id){
       $returner = $funky_gear->object_returner ('Accounts', $child_account_id);
       $object_return = $returner[1];
       echo $object_return;    
       }

    #echo "<img src=images/blank.gif width=95% height=10><BR>";
    #echo "<div style=\"".$divstyle_white."\">".$strings["AccountRelationshipDetails"]."</div>";
    #echo "<img src=images/blank.gif width=95% height=10><BR>";

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = "Related Accounts"; // container_title
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
  
    echo $zaform;

    echo $container_bottom;

    # End Main Container
    ###################################################


    if ($action == 'view'){

       ###################################################
       # Start 

       $this->funkydone ($_POST,$lingo,"ConfigurationItemSets",'list',$val,"RelatedAccountSharing",$bodywidth);

       if ($parent_account_id == $sess_account_id){

          # If parent = current session account - should NOT show other accopunt relationships unless they wish to
          # No current feature for this except open/closed

          $container = "";  
          $container_top = "";
          $container_middle = "";
          $container_bottom = "";

          $container_params[0] = 'open'; // container open state
          $container_params[1] = $bodywidth; // container_width
          $container_params[2] = $bodyheight; // container_height
          $container_params[3] = "Account Relationships"; // container_title
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
  
          echo $this->funkydone ($_POST,$lingo,"AccountRelationships",'list',$account_id_c,"Accounts",$bodywidth);

          echo $container_bottom;

          } # end if parent = current session account

       # End
       ###################################################

       }

   break; // end view
   case 'process':

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if (!$_POST['account_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]."Parent Account not selected</font><P>";
       } else {

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
       }

    if ($_POST['account_id1_c'] == 'NULL'){
       //$error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]."Child Account not selected</font><P>";
       // Creating a new sub-account (Reseller or Client)
       $rego_object_type = "Accounts";
       $rego_action = "create";
       $rego_params = array();
       $account_name = $_POST['name'];
       $rego_params = array(
           array('name'=>'id','value' => ""),
           array('name'=>'name','value' => $account_name),
           ); 

       $acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);
       $account_id = $acc_result['id'];    
       $child_name = $account_name;
       $account_id1_c = $account_id;

       } else {

       $account_id1_c = $_POST['account_id1_c'];

       $ci_object_type = "Accounts";
       $ci_action = "select";
       $ci_params[0] = " id='".$_POST['account_id1_c']."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              //$id = $ci_items[$cnt]['id'];
              $child_name = $ci_items[$cnt]['name'];

              }
          }
       }  

    if (!$error){

       // Set Parent Relationship
       $process_params = array();
       $process_params[0] = "Accounts";
       $process_params[1] = $_POST['account_id_c'];
       $process_params[2] = "Accounts";
       $process_params[3] = $_POST['account_id1_c'];

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       $name = $parent_name." -> ".$child_name;
       $description = $name; 

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $name);
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       $process_params[] = array('name'=>'description','value' => $description);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'account_id1_c','value' => $account_id1_c);
       $process_params[] = array('name'=>'entity_type','value' => $_POST['entity_type']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       if ($_POST['id'] == NULL && $result['id'] != NULL){

          $account_rel_id = $result['id'];
          $account_id_c = $_POST['account_id_c'];
          # Newly added relationship
          # Related Account Sharing Set: 3172f9e9-3915-b709-fc58-52b38864eaf6
          $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';

          $image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharing_set);
          $image_url = $image_returner[7];

          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = "";
          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $account_rel_id);
          $process_params[] = array('name'=>'enabled','value' => 1);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_sharing_set);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id); # Parent owns this 
          $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id); # Parent owns this
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
          $process_params[] = array('name'=>'image_url','value' => $image_url);

          $rel_acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
          $rel_acc_id = $rel_acc_result['id'];    

          # Allowed Shared Account
          $shared_account_ci = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

          $image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $shared_account_ci);
          $image_url = $image_returner[7];

          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = "";
          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $account_id_c);
          $process_params[] = array('name'=>'enabled','value' => 1);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $rel_acc_id);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $shared_account_ci);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id); # Parent owns this 
          $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id); # Parent owns this
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
          $process_params[] = array('name'=>'image_url','value' => $image_url);

          $sh_acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
          $shared_acc_id = $sh_acc_result['id'];

          } # end if new rel acc

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$name."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$description."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End AccountRelationships
##########################################################
?>