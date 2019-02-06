<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Projects.php 
##########################################################
# case 'Projects':

   $lingoname = "name_".$lingo."_c";
   $lingodesc = "description_".$lingo."_c";
   $name_field_base = "name_x_c";
   $desc_field_base = "description_x_c";

   if ($action != 'list' || $action != 'process'){

      $acc_object_type = "AccountRelationships";
      $acc_action = "select";
      $acc_params[0] = " account_id_c='".$portal_account_id."' ";
      $acc_params[1] = " account_id1_c "; // select array
      $acc_params[2] = ""; // group;
      $acc_params[3] = " account_id1_c "; // order;
      $acc_params[4] = "300"; // limit
  
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
      $acc_params[0] = " account_id1_c='".$sess_account_id."' ";
      $acc_params[1] = " account_id_c "; // select array
      $acc_params[2] = ""; // group;
      $acc_params[3] = " account_id_c "; // order;
      $acc_params[4] = ""; // limit
  
      $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

      if (is_array($acc_items)){

         for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

             $parent_accounts_id = $acc_items[$acc_cnt]['parent_account_id'];
             $parent_accounts_name = $acc_items[$acc_cnt]['parent_account_name'];
             $ddpack[$parent_accounts_id]=$parent_accounts_name;

             }
         }

      $acc_returner = $funky_gear->object_returner ("Accounts", $account_id_c);
      $object_return_name = $acc_returner[0];
      $ddpack[$account_id_c]=$object_return_name;

      if (is_array($ddpack)){

         foreach ($ddpack as $contact_account_id => $contact_account_name){
            
                 $acc_object_type = "Accounts";
                 $acc_action = "select_contacts";
                 $acc_params[0] = " account_id='".$contact_account_id."' ";
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
                        $conpack[$contact_id] = $contact_account_name." -> ".$first_name." ".$last_name;

                        } // for

                    } // if

                 } //for each

         } // is array

      } // end if not list

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
         $shared_portal_projects_sql = $sharing_info['shared_portal_projects_sql'];
         $shared_portal_slarequests = $sharing_info['shared_portal_slarequests'];
         $shared_portal_slarequest_sql = $sharing_info['shared_portal_slarequest_sql'];

         if ($shared_portal_projects_sql != NULL){
            $object_return_params[0] = " (".$shared_portal_projects_sql.") ";
            } else {# if ticketing
            $object_return_params[0] = " account_id_c = '".$sess_account_id."' ";
            } 

         } else {# if not portal_account_id 
         $object_return_params[0] = " account_id_c = '".$sess_account_id."' ";
         }

      }# End if list

   # End Shared Access
   ################################

  switch ($valtype){

   case '':

   break;
   case 'Accounts':

    $object_return_params[0] .= " && account_id_c='".$val."' ";

   break;
   case 'Emails':

    $object_return_params[0] .= " && sclm_emails_id_c='".$val."' ";

   break;
   case 'SOW':

    $object_return_params[0] .= " && id_c='".$val."' ";

   break;
   case 'SOWItems':

    $object_return_params[0] .= " && id_c='".$val."' ";

   break;

  }

if ($valtype == 'Search'){
   $keyword = $val;
   $vallength = strlen($keyword);
   $trimval = substr($keyword, 0, -1);

   if ($account_id_c){
      $object_return_params[0] = " ($lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || $lingodesc like '%".$trimval."%' || $lingoname like '%".$trimval."%') && (cmn_statuses_id_c!= '".$standard_statuses_closed."' || account_id_c='".$account_id_c."') ";
      } else {
      $object_return_params[0] = " ($lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || $lingodesc like '%".$trimval."%' || $lingoname like '%".$trimval."%') && cmn_statuses_id_c!= '".$standard_statuses_closed."' ";
      } 

   }

  switch ($action){
   
   case 'list':
   
    ################################
    # List

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["Projects"]."</B></font></center></div>";
    echo "<img src=images/blank.gif width=50% height=5><BR>";
    echo "<center><img src=images/icons/i_hspcservices_med.gif width=50 border=0 alt=\"".$strings["Projects"]."\"></center>";
    echo "<img src=images/blank.gif width=50% height=5><BR>";

    #echo "object_return_params: ".$object_return_params[0]."<P>";

    $project_cstm_object_type = 'Projects';
    $project_cstm_action = "select_cstm";
    $project_cstm_params[0] = $object_return_params[0];
    $project_cstm_params[1] = ""; // select array
    $project_cstm_params[2] = ""; // group;
    $project_cstm_params[3] = ""; // order;
    $project_cstm_params[4] = ""; // limit
    $project_cstm_params[5] = $lingoname; // lingo
  
    $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

    if (is_array($project_cstm_items)){

       $count = count($project_cstm_items);

       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $project_cstm_params[4] = " $lfrom , $glb_perpage_items "; 

       $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

       for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

           $id_c = $project_cstm_items[$cnt]['id_c'];
           $contact_id_c = $project_cstm_items[$cnt]['contact_id_c'];
           $account_id_c = $project_cstm_items[$cnt]['account_id_c'];
//           $name_en_c = $project_cstm_items[$cnt]['name_en_c'];
//           $name_ja_c = $project_cstm_items[$cnt]['name_ja_c'];
//           $description_en_c = $project_cstm_items[$cnt]['description_en_c'];
//           $description_ja_c = $project_cstm_items[$cnt]['description_ja_c'];
           $project_process_stage_c = $project_cstm_items[$cnt]['project_process_stage_c'];
           $itil_stage_c = $project_cstm_items[$cnt]['itil_stage_c'];
           $cmn_statuses_id_c = $project_cstm_items[$cnt]['cmn_statuses_id_c'];
           $pm_provider = $project_cstm_items[$cnt]['account_id1_c'];
           $pm_contact = $project_cstm_items[$cnt]['contact_id1_c'];

/*
           if ($project_cstm_items[$cnt][$lingoname] != NULL){
              $name = $project_cstm_items[$cnt][$lingoname];
              }
*/

           // Get Custom content

           $project_object_type = "Projects";
           $project_action = "select";
           $project_params[0] = " id='".$id_c."' ";
           $project_params[1] = ""; // select array
           $project_params[2] = ""; // group;
           $project_params[3] = ""; // order;
           $project_params[4] = ""; // limit
  
           $project_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_object_type, $project_action, $project_params);

           if (is_array($project_items)){

              for ($prj_cnt=0;$prj_cnt < count($project_items);$prj_cnt++){

                  $name = "";
                  $id = $project_items[$prj_cnt]['id'];
                  $name = $project_items[$prj_cnt]['name'];
                  $date_entered = $project_items[$prj_cnt]['date_entered'];
                  $date_modified = $project_items[$prj_cnt]['date_modified'];
                  $modified_user_id = $project_items[$prj_cnt]['modified_user_id'];
                  $created_by = $project_items[$prj_cnt]['created_by'];
                  $description = $project_items[$prj_cnt]['description'];
                  $deleted = $project_items[$prj_cnt]['deleted'];
                  $assigned_user_id = $project_items[$prj_cnt]['assigned_user_id'];
                  $estimated_start_date = $project_items[$prj_cnt]['estimated_start_date'];
                  $estimated_end_date = $project_items[$prj_cnt]['estimated_end_date'];
                  $status = $project_items[$prj_cnt]['status'];
                  $status_image = "";
                  $status_image = $project_items[$prj_cnt]['status_image'];
                  $status_name = $project_items[$prj_cnt]['status_name'];
                  if ($status_image != NULL){
                     $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";
                     }

                  $priority = $project_items[$prj_cnt]['priority'];

                  if ($project_items[$prj_cnt][$lingoname] != NULL){
                     $name = $project_items[$prj_cnt][$lingoname];
                     }

                  $edit = "";
                  if ($sess_contact_id != NULL && $sess_contact_id==$contact_id_c || $sess_contact_id != NULL && $sess_contact_id==$account_admin || $sess_contact_id != NULL && $sess_contact_id==$pm_contact){
                     $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
                     }

                  $project_pack .= "<div style=\"".$divstyle_white."\">".$status_image." [".$status_name."] ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a></div>";

                  } // end for

              } // end if

           } // end for
      
       } else { // end if array

       $project_pack = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL){    
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($project_cstm_items)>10){
       echo $addnew.$project_pack.$addnew;
       } else {
       echo $project_pack.$addnew;
       }
   
    echo $navi;

    if (!$val){
       echo "<img src=images/blank.gif width=200 height=1><BR>";
       $this->funkydone ($_POST,$lingo,'Content','view','b48bd8cb-33bc-66b8-1aa5-525477be579a','Content',$bodywidth);
       }

    # End List
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){ 

       $project_object_type = $do;
       $project_action = "select";
       $project_params[0] = " id='".$val."' ";
       $project_params[1] = ""; // select array
       $project_params[2] = ""; // group;
       $project_params[3] = ""; // order;
       $project_params[4] = ""; // limit
  
       $project_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_object_type, $project_action, $project_params);

       if (is_array($project_items)){

          for ($cnt=0;$cnt < count($project_items);$cnt++){

              $id = $project_items[$cnt]['id'];
              $name = $project_items[$cnt]['name'];
              $date_entered = $project_items[$cnt]['date_entered'];
              $date_modified = $project_items[$cnt]['date_modified'];
              $modified_user_id = $project_items[$cnt]['modified_user_id'];
              $created_by = $project_items[$cnt]['created_by'];
              $description = $project_items[$cnt]['description'];
              $deleted = $project_items[$cnt]['deleted'];
              $assigned_user_id = $project_items[$cnt]['assigned_user_id'];
              $estimated_start_date = $project_items[$cnt]['estimated_start_date'];
              $estimated_end_date = $project_items[$cnt]['estimated_end_date'];
              $status = $project_items[$cnt]['status'];
              $status_image = $project_items[$cnt]['status_image'];
              $status_name = $project_items[$cnt]['status_name'];

              $priority = $project_items[$cnt]['priority'];

              $project_cstm_object_type = $do;
              $project_cstm_action = "select_cstm";
              $project_cstm_params[0] = " id_c='".$val."' ";
              $project_cstm_params[1] = ""; // select array
              $project_cstm_params[2] = ""; // group;
              $project_cstm_params[3] = ""; // order;
              $project_cstm_params[4] = ""; // limit
  
              $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

              if (is_array($project_cstm_items)){

                 for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

                     $id_c = $project_cstm_items[$cnt]['id_c'];
                     $contact_id_c = $project_cstm_items[$cnt]['contact_id_c'];
                     $account_id_c = $project_cstm_items[$cnt]['account_id_c'];
                     $project_process_stage_c = $project_cstm_items[$cnt]['project_process_stage_c'];
                     $itil_stage_c = $project_cstm_items[$cnt]['itil_stage_c'];
                     $cmn_statuses_id_c = $project_cstm_items[$cnt]['cmn_statuses_id_c'];
                     $pm_provider = $project_cstm_items[$cnt]['account_id1_c'];
                     $pm_contact = $project_cstm_items[$cnt]['contact_id1_c'];

                     } // end for cstm

                 $field_lingo_pack = $funky_gear->lingo_data_pack ($project_cstm_items, $name, $description, $name_field_base,$desc_field_base);

                 } // is array for cstm

              } // end for projects

          } // is array

       } // if action

    $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";

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
    $tablefields[$tblcnt][12] = '50'; // object length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_statuses_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["PublicStatus"]; // Full Name
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

    $tablefields[$tblcnt][0] = 'itil_stage_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ITILStage"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='18b8b399-51fb-f9af-c741-52477bc183ab' ";//$exception;
    $tablefields[$tblcnt][9][5] = $itil_stage_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $itil_stage_c; // Current Value
//    $params['ci_data_type'] = $ci_data_type;
//    $params['ci_name_field'] = "name";
//    $params['ci_name'] = $name;
//    $tablefields[$tblcnt][9][10] = $params; // Various Params
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'itil_stage_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $itil_stage_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'project_process_stage_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ProjectProcess"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='4bd3c491-8262-b4e8-521b-52589019666b' "; //$exception;
    $tablefields[$tblcnt][9][5] = $project_process_stage_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $project_process_stage_c; // Current Value
//    $params['ci_data_type'] = $ci_data_type;
//    $params['ci_name_field'] = "name";
//    $params['ci_name'] = $name;
//    $tablefields[$tblcnt][9][10] = $params; // Various Params
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'project_process_stage_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $project_process_stage_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'status'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]." ".$status_image; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='4e5d68c1-07a0-dd2d-d17c-52a440c52da9' "; //ticket status
    $tablefields[$tblcnt][9][5] = $status; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'status';//$field_value_id;
    $tablefields[$tblcnt][21] = $status; //$field_value;

    $tblcnt++;

    if ($estimated_start_date==NULL){
       $estimated_start_date = date("Y-m-d");
       }

    $tablefields[$tblcnt][0] = "estimated_start_date"; // Field Name
    $tablefields[$tblcnt][1] = $strings["DateStart"]; // Full Name
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
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "estimated_start_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $estimated_start_date; //$field_value;   

    $tblcnt++;

    if ($estimated_end_date==NULL){
       $estimated_end_date = date("Y-m-d");
       }

    $tablefields[$tblcnt][0] = "estimated_end_date"; // Field Name
    $tablefields[$tblcnt][1] = $strings["DateEnd"]; // Full Name
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
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "estimated_end_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $estimated_end_date; //$field_value;   
/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'service_tier'; // Field Name
    $tablefields[$tblcnt][1] = "Service Tier"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='4f01b406-b96d-273b-8508-52400531e2e2' ";//$exception;
    $tablefields[$tblcnt][9][5] = $service_tier; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItemTypes'; //new do
    $tablefields[$tblcnt][9][9] = $service_tier; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'service_tier';//$field_value_id;
    $tablefields[$tblcnt][21] = $service_tier; //$field_value;

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
       $tablefields[$tblcnt][9][1] = 'contacts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'first_name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

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

       }

    ####################################
    # For Agents

    # -> Service Provider Account

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServicesProvider"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $ddpack;
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";
    $tablefields[$tblcnt][9][5] = $pm_provider; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $pm_provider; //$field_value;   

    # -> Service Provider Contact

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Agent"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $conpack; // 
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][5] = $pm_contact; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "firstlast";
    $tablefields[$tblcnt][21] = $pm_contact;
    $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

    # For Agents
    ####################################


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
    $tablefields[$tblcnt][12] = "65"; // Object Length
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

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
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
    $container_params[3] = $strings["Project"]; // container_title
    $container_params[4] = 'Project'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    $returner = $funky_gear->object_returner ('Accounts', $account_id_c);
    $object_return = $returner[1];
    echo $object_return;

    if ($val){
       $returner = $funky_gear->object_returner ('Projects', $val);
       $object_return = $returner[1];
       echo $object_return;
       }

    if (($action == 'view' || $action == 'edit') && $sess_contact_id != NULL){ 
       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";
       echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$parent_account_id."&valuetype=Parent&source=".$do."&sourceval=".$val."');return false\" class=\"css3button\"><B>".$strings["AttachServicesProject"]."</B></a></center>";
       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";
       }

    echo $container_top;
  
    echo $zaform;

    echo $container_bottom;

    #
    ###################
    #

    if ($action == 'view' || $action == 'edit'){ 

    ###################
    #

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["ServiceSLARequests"]; // container_title
    $container_params[4] = 'TasksServiceSLARequests'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
   
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

//    echo $container_top;

    $this->funkydone ($_POST,$lingo,'ServiceSLARequests','list',$val,$do,$bodywidth);       

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["SOW"]; // container_title
    $container_params[4] = 'SOW'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
   
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

//    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'SOW','list',$val,$do,$bodywidth);       

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["ProjectTasks"]; // container_title
    $container_params[4] = 'ProjectTasks'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
   
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

//    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'ProjectTasks','list',$val,$do,$bodywidth);       

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

//    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);       

//    echo $container_bottom;

    ###################################################
    # RelatedConfigurationItems
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

       foreach ($_POST as $name_key=>$name_value){

               $name_lingo = str_replace("name_","",$name_key);
               $name_lingo = str_replace("_c","",$name_lingo);

               if ($name_lingo != NULL && in_array($name_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$name_key,'value' => $name_value);

                  } // if namelingo

               } // end foreach

       foreach ($_POST as $desc_key=>$desc_value){

               $desc_lingo = str_replace("description_","",$desc_key);
               $desc_lingo = str_replace("_c","",$desc_lingo);

               if ($desc_lingo != NULL && in_array($desc_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$desc_key,'value' => $desc_value);

                  } // if namelingo

               } // end foreach

       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'estimated_start_date','value' => $_POST['estimated_start_date']);
       $process_params[] = array('name'=>'estimated_end_date','value' => $_POST['estimated_end_date']);
       $process_params[] = array('name'=>'status','value' => $_POST['status']);
       $process_params[] = array('name'=>'priority','value' => $_POST['priority']);
       $process_params[] = array('name'=>'itil_stage_c','value' => $_POST['itil_stage_c']);
       $process_params[] = array('name'=>'project_process_stage_c','value' => $_POST['project_process_stage_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
       $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);

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