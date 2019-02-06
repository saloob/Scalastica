<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Security.php 
##########################################################
# case 'Security':

  $this_module = 'a0cff0a9-fd8d-c65c-3bfa-52762f7f733a';
  $security_params[0] = $this_module;
  $security_params[1] = $lingo;
  $security_params[2] = $_SESSION['contact_id'];
  $security_check = $funky_gear->check_security($security_params);
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

  $ci_params[0] = " deleted=0 ";

  switch ($system_action_list){

   case $action_rights_all:
//    $ci_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
   break;
   case $action_rights_none:
    $ci_params[0] .= " && cmn_statuses_id_c = 'ZZZZZZZZZZZZZZZZZZ' ";
   break;
   case $action_rights_owner:
    $ci_params[0] .= " && contact_id_c = '".$_SESSION['contact_id']."' ";
   break;
   case $action_rights_account:
    $ci_params[0] .= " && account_id_c = '".$_SESSION['account_id']."' ";
   break;

  } // end system_action_list

  switch ($valtype){
   
   case 'Accounts':

    $ci_params[0] .= " && account_id_c='".$val."' "; 

   break;
   case 'ConfigurationItems':

    $sclm_configurationitems_id_c = $val; 

   break;
   case 'role':

    $ci_params[0] .= " && role='".$val."' ";

   break;
   case 'system_module':

    $ci_params[0] .= " && system_module='".$val."' ";

   break;
   case 'security_level':

    $ci_params[0] .= " && security_level='".$val."' ";

   break;
   case 'security_item_type':

    $ci_params[0] .= " && security_item_type='".$val."' ";

   break;

  }

if ($auth != 3){
 
   $ci_params[0] .= " && (account_id_c='".$account_id_c."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";

   }

if ($action == 'search'){
   $keyword = $val;
   $vallength = strlen($keyword);
   $trimval = substr($keyword, 0, -1);
/*
   $ci_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || $lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";
*/
   $ci_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";

   }

  switch ($action){
   
   case 'list':
   case 'search':
   
    ################################
    # List

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["Security"]."</B></font></center></div>";
    echo "<center><img src=images/icons/Sheild_green.png width=100></center>";
    echo "<P><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=list&value=e89cd945-f75c-7c2e-c8ea-5273770dee68&valuetype=ConfigurationItemTypes');return false\"><font size=3 color=BLUE><B>".$strings["Security"].":".$strings["Modules"]."</B></font></a></center><P>";
    
    $ci_object_type = 'Security';
    $ci_action = "select";

    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, system_module, role, security_level, security_item_type, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
    $ci_params[5] = $lingoname; 
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       $date = date("Y@m@d@G");
       $body_sendvars = $date."#Bodyphp";
       $body_sendvars = $funky_gear->encrypt($body_sendvars);

?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="value" name="value" value="<?php echo $keyword; ?>" size="20">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php


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
           $ci_account_id = $ci_items[$cnt]['account_id'];
           $ci_contact_id = $ci_items[$cnt]['contact_id'];
           $system_module = $ci_items[$cnt]['system_module'];
           $system_action_create = $ci_items[$cnt]['system_action_create'];
           $system_action_delete = $ci_items[$cnt]['system_action_delete'];
           $system_action_edit = $ci_items[$cnt]['system_action_edit'];
           $system_action_export = $ci_items[$cnt]['system_action_export'];
           $system_action_import = $ci_items[$cnt]['system_action_import'];
           $system_action_view_details = $ci_items[$cnt]['system_action_view_details'];
           $system_action_view_list = $ci_items[$cnt]['system_action_view_list'];
           $role = $ci_items[$cnt]['role'];
           $access = $ci_items[$cnt]['access'];
           $security_item_type = $ci_items[$cnt]['security_item_type'];
           $security_item_type_name = $ci_items[$cnt]['security_item_type_name'];

           $system_module_name = $ci_items[$cnt]['system_module_name'];
           $system_action_create_name = $ci_items[$cnt]['system_action_create_name'];
           $system_action_delete_name = $ci_items[$cnt]['system_action_delete_name'];
           $system_action_edit_name = $ci_items[$cnt]['system_action_edit_name'];
           $system_action_export_name = $ci_items[$cnt]['system_action_export_name'];
           $system_action_import_name = $ci_items[$cnt]['system_action_import_name'];
           $system_action_view_details_name = $ci_items[$cnt]['system_action_view_details_name'];
           $system_action_view_list_name = $ci_items[$cnt]['system_action_view_list_name'];
           $role_name = $ci_items[$cnt]['role_name'];
           $access_name = $ci_items[$cnt]['access_name'];
           $this_security_level = $ci_items[$cnt]['security_level'];

           $image_url = $ci_items[$cnt]['image_url'];

           if ($image_url != NULL){
              $image = "<img src=".$image_url." width=16>";
              } else {
              $image = "<img src=images/icons/i_securitymanager.gif width=16>";
              } 

//           $parent_service_type = $ci_items[$cnt]['parent_service_type'];
//           $service_type = $ci_items[$cnt]['service_type'];
           if ($auth == 3 || ($sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c)){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

//           if ($ci_items[$cnt][$lingoname] != NULL){
//              $name = $ci_items[$cnt][$lingoname];
//              }

           if ($auth == 3){
              $show_id = " | ID: ".$id;
              } else {
              $show_id = "";
              }

           // $strings["SecurityItemType"]

           $cis .= "<div style=\"".$divstyle_white."\">".$image." ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Security&action=list&value=".$security_item_type."&valuetype=security_item_type');return false\"><B>".$security_item_type_name."</B> -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Security&action=list&value=".$system_module."&valuetype=system_module');return false\"><B>".$system_module_name."</B></a> -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Security&action=list&value=".$this_security_level."&valuetype=security_level');return false\">".$strings["SecurityLevel"]." [".$this_security_level."]</a> -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Security&action=list&value=".$role."&valuetype=role');return false\">".$role_name."</a> -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"> ".$access_name." -><BR>[".$strings["Create"].":".$system_action_create_name."] [".$strings["Delete"].":".$system_action_delete_name."] [".$strings["Edit"].":".$system_action_edit_name."] [".$strings["Export"].":".$system_action_export_name."] [".$strings["Import"].":".$system_action_import_name."] [".$strings["ViewDetails"].":".$system_action_view_details_name."] [".$strings["ViewList"].":".$system_action_view_list_name."]</a></div>";
      
           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }
    
    $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
          
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
       $ci_params[5] = $lingoname; // lingo
  
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
              $system_module = $ci_items[$cnt]['system_module'];
              $system_action_create = $ci_items[$cnt]['system_action_create'];
              $system_action_delete = $ci_items[$cnt]['system_action_delete'];
              $system_action_edit = $ci_items[$cnt]['system_action_edit'];
              $system_action_export = $ci_items[$cnt]['system_action_export'];
              $system_action_import = $ci_items[$cnt]['system_action_import'];
              $system_action_view_details = $ci_items[$cnt]['system_action_view_details'];
              $system_action_view_list = $ci_items[$cnt]['system_action_view_list'];
              $role = $ci_items[$cnt]['role'];
              $access = $ci_items[$cnt]['access'];
              $security_item_type = $ci_items[$cnt]['security_item_type'];

              $this_security_level = $ci_items[$cnt]['security_level'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
      
              } // end for

//          $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);

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

    $tablefields[$tblcnt][0] = "security_level"; // Field Name
    $tablefields[$tblcnt][1] = $strings["SecurityLevel"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

    if ($security_level>2){
       $secpack[0]=0;
       $secpack[1]=1;
       $secpack[2]=2;
       $secpack[3]=3;
       $secpack[4]=4;
       $secpack[5]=5;
       } else {
       $secpack[0]=0;
       $secpack[1]=1;
       $secpack[2]=2;
       $secpack[3]=3;
       $secpack[4]=4;
       $secpack[5]=5;
       }

    $tablefields[$tblcnt][9][1] = $secpack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";// exception;
    $tablefields[$tblcnt][9][5] = $this_security_level; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][9][7] = ""; // list reltablename
    $tablefields[$tblcnt][9][8] = ''; //new do
    $tablefields[$tblcnt][9][9] = $this_security_level; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $this_security_level; // Field ID
    $tablefields[$tblcnt][20] = "security_level"; //$field_value_id;
    $tablefields[$tblcnt][21] = $this_security_level; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'security_item_type'; // Field Name
    $tablefields[$tblcnt][1] = $strings["SecurityItemType"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= '691f0f03-4758-bba5-a0cb-52ac70dceca0' ";//$exception;
    $tablefields[$tblcnt][9][5] = $security_item_type; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $security_item_type; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'security_item_type';//$field_value_id;
    $tablefields[$tblcnt][21] = $security_item_type; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_module'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Module"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'e89cd945-f75c-7c2e-c8ea-5273770dee68' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_module; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_module; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_module';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_module; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'role'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Role"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'e95b1f0d-034e-0d4c-7754-527329f5b975' ";//$exception;
    $tablefields[$tblcnt][9][5] = $role; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $role; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'role';//$field_value_id;
    $tablefields[$tblcnt][21] = $role; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'access'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Access"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'b19f7c3e-f0d7-eabb-17d6-52732429ca24' ";//$exception;
    $tablefields[$tblcnt][9][5] = $access; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $access; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'access';//$field_value_id;
    $tablefields[$tblcnt][21] = $access; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_create'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Create"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_create; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_create; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_create';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_create; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_delete'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Delete"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_delete; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_delete; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_delete';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_delete; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_edit'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Edit"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_edit; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_edit; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_edit';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_edit; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_export'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Export"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_export; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_export; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_export';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_export; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_import'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Import"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_import; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_import; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_import';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_import; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_view_details'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ViewDetails"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_view_details; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_view_details; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_view_details';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_view_details; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'system_action_view_list'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ViewList"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c= 'adce4134-cc68-83d8-f286-5273276ee9fe' ";//$exception;
    $tablefields[$tblcnt][9][5] = $system_action_view_list; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $system_action_view_list; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'system_action_view_list';//$field_value_id;
    $tablefields[$tblcnt][21] = $system_action_view_list; //$field_value;

/*
    $tblcnt++;

    if ($action == 'view' && $image_url != NULL){

    $tablefields[$tblcnt][0] = "image_url"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'image';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "image_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $image_url; //$field_value;   

       } else {

    $tablefields[$tblcnt][0] = "image_url"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
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
    $tablefields[$tblcnt][20] = "image_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $image_url; //$field_value;   

       } 
*/

    if ($action == 'view' || $auth == 3){

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
//       $tablefields[$tblcnt][9][3] = " CONCAT('first_name',' ','last_name') ";
       $tablefields[$tblcnt][9][3] = "first_name";
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

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

    ################################
    # Loop for allowed languages
/*
    if ($action == 'edit'){

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
    $tablefields[$tblcnt][6] = '255'; // length
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

    } // if edit
*/

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if ($auth == 3 || $sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $valpack[5] = "1"; // provide add new button
       }

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

//    echo "<img src=images/blank.gif width=95% height=20><BR>";

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["Security"]; // container_title
       $container_params[4] = 'Security'; // container_label
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

//    echo "<img src=images/blank.gif width=95% height=10><BR>";

    if ($action == 'view' || $action == 'edit'){

       ###################################################
       # Start 
/*
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Related Items'; // container_title
       $container_params[4] = 'RelatedItems'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,$do,'list',$val,$do,$bodywidth);

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Associated Services'; // container_title
       $container_params[4] = 'AssociatedServices'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       //$container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'Services','list',$val,$do,$bodywidth);

       echo $container_bottom;
*/
       # End
       ###################################################

       }

   break; // end view
   case 'process':

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if (!$_POST['role']){
       $error .= "<font color=white size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Role"]."</font><P>";
       }

    if (!$_POST['access']){
       $error .= "<font color=white size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Access"]."</font><P>";
       }

    if (!$_POST['system_module']){
       $error .= "<font color=white size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Module"]."</font><P>";
       }

    if (!$error){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
//       $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
//       $process_params[] = array('name'=>'image_url','value' => $_POST['image_url']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

       $process_params[] = array('name'=>'system_action_create','value' => $_POST['system_action_create']);
       $process_params[] = array('name'=>'system_action_delete','value' => $_POST['system_action_delete']);
       $process_params[] = array('name'=>'system_action_edit','value' => $_POST['system_action_edit']);
       $process_params[] = array('name'=>'system_action_export','value' => $_POST['system_action_export']);
       $process_params[] = array('name'=>'system_action_import','value' => $_POST['system_action_import']);
       $process_params[] = array('name'=>'system_action_view_details','value' => $_POST['system_action_view_details']);
       $process_params[] = array('name'=>'system_action_view_list','value' => $_POST['system_action_view_list']);
       $process_params[] = array('name'=>'role','value' => $_POST['role']);
       $process_params[] = array('name'=>'access','value' => $_POST['access']);
       $process_params[] = array('name'=>'system_module','value' => $_POST['system_module']);
       $process_params[] = array('name'=>'security_level','value' => $_POST['security_level']);
       $process_params[] = array('name'=>'security_item_type','value' => $_POST['security_item_type']);

       $security_item_type_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['security_item_type']);
       $security_item_type_name = $security_item_type_returner[0];
       $this_name = $this_name." [".$strings["SecurityItemType"].":".$security_item_type_name."]";

       $system_module_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_module']);
       $system_module_name = $system_module_returner[0];
       $this_name = $this_name." -> ".$system_module_name;

       $role_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['role']);
       $role_name = $role_returner[0];
       $this_name = $this_name." -> ".$role_name;

       $access_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['access']);
       $access_name = $access_returner[0];
       $this_name = $this_name." -> ".$access_name;

       $this_name = $this_name." -> ".$strings["SecurityLevel"]." [".$_POST['security_level']."] ->";

       $system_action_create_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_create']);
       $system_action_create_name = $system_action_create_returner[0];
       $this_name = $this_name." [".$strings["Create"].":".$system_action_create_name."]";

       $system_action_delete_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_delete']);
       $system_action_delete_name = $system_action_delete_returner[0];
       $this_name = $this_name." [".$strings["Delete"].":".$system_action_delete_name."]";

       $system_action_edit_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_edit']);
       $system_action_edit_name = $system_action_edit_returner[0];
       $this_name = $this_name." [".$strings["Edit"].":".$system_action_edit_name."]";

       $system_action_export_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_export']);
       $system_action_export_name = $system_action_export_returner[0];
       $this_name = $this_name." [".$strings["Export"].":".$system_action_export_name."]";

       $system_action_import_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_import']);
       $system_action_import_name = $system_action_import_returner[0];
       $this_name = $this_name." [".$strings["Import"].":".$system_action_import_name."]";

       $system_action_view_details_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_view_details']);
       $system_action_view_details_name = $system_action_view_details_returner[0];
       $this_name = $this_name." [".$strings["ViewDetails"].":".$system_action_view_details_name."]";

       $system_action_view_list_returner = $funky_gear->object_returner ('ConfigurationItems', $_POST['system_action_view_list']);
       $system_action_view_list_name = $system_action_view_list_returner[0];
       $this_name = $this_name." [".$strings["ViewList"].":".$system_action_view_list_name."]";

       $process_params[] = array('name'=>'name','value' => $this_name);
       $process_params[] = array('name'=>'description','value' => $this_name);
//       $process_params[] = array('name'=>'description','value' => $_POST['description']);

/*
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
*/
       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

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