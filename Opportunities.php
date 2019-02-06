<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Opportunities.php 
##########################################################
# case 'Opportunities':

  $lingoname = "name_".$lingo."_c";
  $lingodesc = "description_".$lingo."_c";

  if ($auth == 3){
     #$object_return_params[0] = " deleted=0";
     } else {
     if ($sess_account_id != NULL){
        $object_return_params[0] = " (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."' ) ";
        } else {
        $object_return_params[0] = " cmn_statuses_id_c != '".$standard_statuses_closed."' ";
        }
     }

  switch ($valtype){

   case '':

   break;
   case 'Accounts':

    $object_return_params[0] = " account_id_c='".$val."' ";

   break;

  }

  if ($valtype == 'Search'){
     $keyword = $val;
     $vallength = strlen($keyword);
     $trimval = substr($keyword, 0, -1);

     $object_return_params[0] .= " && ($lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || $lingodesc like '%".$trimval."%' || $lingoname like '%".$trimval."%') ";

     } // end if

  switch ($action){
   
   case 'list':
   
    ################################
    # List
    
    if ($valtype == 'Search' || $val != NULL){
       echo "<div style=\"".$divstyle_grey."\"><center><font size=3><B>".$strings["Opportunities"]."</B></font></center></div>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       echo "<center><img src=images/icons/i_businessdirector_med.gif width=50 border=0 alt=\"".$strings["ProjectTasks"]."\"></center></div>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       }

    $opp_object_type = $do;
    $opp_action = "select_cstm";

    $opp_params[0] = $object_return_params[0];
    $opp_params[1] = ""; // select array
    $opp_params[2] = ""; // group;
    $opp_params[3] = ""; // order;
    $opp_params[4] = ""; // limit
  
    $opps_cstm = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $opp_object_type, $opp_action, $opp_params);

    if (is_array($opps_cstm)){

       $count = count($opps_cstm);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $opp_params[4] = " $lfrom , $glb_perpage_items "; 

       $opps_cstm = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $opp_object_type, $opp_action, $opp_params);

       for ($cnt_cstm=0;$cnt_cstm < count($opps_cstm);$cnt_cstm++){

           $id_c = $opps_cstm[$cnt_cstm]['id_c'];
           $contact_id_c = $opps_cstm[$cnt_cstm]['contact_id_c'];
           $account_id_c = $opps_cstm[$cnt_cstm]['account_id_c'];

           $opp_object_type = $do;
           $opp_action = "select";
           $opp_params[0] = " id='".$id_c."' ";
           $opp_params[1] = ""; // select array
           $opp_params[2] = ""; // group;
           $opp_params[3] = ""; // order;
           $opp_params[4] = ""; // limit

           $opp = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $opp_object_type, $opp_action, $opp_params);

           for ($cnt=0;$cnt < count($opp);$cnt++){

               $id = $opp[$cnt]['id'];
               $date_entered = $opp[$cnt]['date_entered'];
               $date_modified = $opp[$cnt]['date_modified'];
               $modified_user_id = $opp[$cnt]['modified_user_id'];
               $created_by = $opp[$cnt]['created_by'];
               $name = $opp[$cnt]['name'];
               $description = $opp[$cnt]['description'];
               $deleted = $opp[$cnt]['deleted'];
               $assigned_user_id = $opp[$cnt]['assigned_user_id'];

               $contact_id_c = $opp[$cnt]['contact_id_c'];
               $account_id_c = $opp[$cnt]['account_id_c'];

               $opportunity_type = $opp[$cnt]['opportunity_type'];
               $campaign_id = $opp[$cnt]['campaign_id'];
               $lead_source = $opp[$cnt]['lead_source'];
               $amount = $opp[$cnt]['amount'];
               $currency_id = $opp[$cnt]['currency_id'];
               $date_closed = $opp[$cnt]['date_closed'];
               $next_step = $opp[$cnt]['next_step'];
               $sales_stage = $opp[$cnt]['sales_stage'];
               $probability = $opp[$cnt]['probability'];

/*
           $project_id_c = $opp[$cnt]['project_id_c'];
           $projecttask_id_c = $opp[$cnt]['projecttask_id_c'];
*/
               if ($opp[$cnt][$lingoname] != NULL){
                  $name = $opp[$cnt][$lingoname];
                  }

    //           $cmn_languages_id_c = $opp[$cnt]['cmn_languages_id_c'];
               $cmn_statuses_id_c = $opp[$cnt]['cmn_statuses_id_c'];

               if ($sess_contact_id != NULL && $sess_contact_id==$contact_id_c){
                  $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
                  }

               $opps .= "<div style=\"".$divstyle_white."\"> ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a></div>";

               } // end for

           } // end for

       } else { // end if array

       $opps = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL && $auth>1){    
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($sow)>10){
       echo $addnew.$opps.$addnew;
       } else {
       echo $opps.$addnew;
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

       $opp_object_type = $do;
       $opp_action = "select";
       $opp_params[0] = " id='".$val."' ";
       $opp_params[1] = ""; // select array
       $opp_params[2] = ""; // group;
       $opp_params[3] = ""; // order;
       $opp_params[4] = ""; // limit
  
       $opp = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $opp_object_type, $opp_action, $opp_params);

       if (is_array($opp)){

          for ($cnt=0;$cnt < count($opp);$cnt++){

              $id = $opp[$cnt]['id'];
              $name = $opp[$cnt]['name'];
              $date_entered = $opp[$cnt]['date_entered'];
              $date_modified = $opp[$cnt]['date_modified'];
              $modified_user_id = $opp[$cnt]['modified_user_id'];
              $created_by = $opp[$cnt]['created_by'];
              $description = $opp[$cnt]['description'];
              $deleted = $opp[$cnt]['deleted'];
              $assigned_user_id = $opp[$cnt]['assigned_user_id'];
              $contact_id_c = $opp[$cnt]['contact_id_c'];
              $account_id_c = $opp[$cnt]['account_id_c'];
              $cmn_statuses_id_c = $opp[$cnt]['cmn_statuses_id_c'];

/*
              $project_id_c = $opp[$cnt]['project_id_c'];
              $projecttask_id_c = $opp[$cnt]['projecttask_id_c'];
              $cmn_languages_id_c = $opp[$cnt]['cmn_languages_id_c'];
*/   

              $opportunity_type = $opp[$cnt]['opportunity_type'];
              $campaign_id = $opp[$cnt]['campaign_id'];
              $lead_source = $opp[$cnt]['lead_source'];
              $amount = $opp[$cnt]['amount'];
              $currency_id = $opp[$cnt]['currency_id'];
              $date_closed = $opp[$cnt]['date_closed'];
              $next_step = $opp[$cnt]['next_step'];
              $sales_stage = $opp[$cnt]['sales_stage'];
              $probability = $opp[$cnt]['probability'];

              } // end for projects

          $field_lingo_pack = $funky_gear->lingo_data_pack ($opp, $name, $description, $name_field_base,$desc_field_base);

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
    $container_params[3] = $strings['Opportunity']; // container_title
    $container_params[4] = 'Opportunities'; // container_label
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
  
    echo $zaform;

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[3] = 'Related Items'; // container_title
    $container_params[4] = 'RelatedItems'; // container_label

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'ConfigurationItems','list',$val,$do,$bodywidth);

    echo $container_bottom;

    #
    ###################
    #

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
/*
    echo $container_top;

    $this->funkydone ($_POST,$lingo,'Projects','list',$project_id_c,$do,$bodywidth);       

    echo $container_bottom;
*/
    }

    if ($action == 'view' || $action == 'edit' ){ 

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

/*    echo $container_top;

    $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);       

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["SOWItems"]; // container_title
    $container_params[4] = 'SOWItems'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs
   
    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'SOWItems','list',$val,$do,$bodywidth);       

//    echo $container_bottom;

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

//$lingoname = "name_".$lingo;

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
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
/*
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);

*/
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

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

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