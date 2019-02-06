<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: ConfigurationItemSets.php 
##########################################################
# case 'ConfigurationItemSets':

//echo "<iframe src=\"jquery.formbuilder-master/\" width=99% height=500></iframe>";

  function create_setitem ($setparams){

    $id = $setparams[0];
    $name = $setparams[1];
    $account_id_c = $setparams[2];
    $contact_id_c = $setparams[3];
    $valtype = $setparams[4];
    $description = $setparams[5];
    $do = $setparams[6];
    $action = $setparams[7];

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


      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "valuetype"; // Field Name
      $tablefields[$tblcnt][1] = "valuetype"; // Full Name
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
      $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
      $tablefields[$tblcnt][21] = $valtype; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'sclm_configurationitemtypes_id_c'; // Field Name
      $tablefields[$tblcnt][1] = "Configuration Item Type"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
      $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
      $tablefields[$tblcnt][9][2] = 'id';
      $tablefields[$tblcnt][9][3] = 'name';
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='a172e63a-8d26-ab84-2aee-526fbe56f621' "; // Configuration Item Sets
      $tablefields[$tblcnt][9][5] = $sclm_configurationitemtypes_id_c; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItemTypes';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItemSets'; //new do
      $tablefields[$tblcnt][9][9] = $sclm_configurationitemtypes_id_c; // Current Value
      $params['ci_data_type'] = 'a39735f4-b558-5214-1d07-52593e7f39da'; // Service Assets
      $params['ci_type_id'] = '45f10141-c75f-8871-c8a0-51c6e9b687e7'; // Service Assets
      $params['ci_name'] = "sclm_configurationitemtypes_id_c";
      $tablefields[$tblcnt][9][10] = $params; // Various Params
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'sclm_configurationitemtypes_id_c';//$field_value_id;
      $tablefields[$tblcnt][21] = $sclm_configurationitemtypes_id_c; //$field_value;

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
      $valpack[2] = 'ConfigurationItemSets';
      $valpack[3] = $tablefields;
      $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
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
      $container_params[3] = 'Infrastructure Configuration Items'; // container_title
      $container_params[4] = 'InfrastructureConfigurationItems'; // container_label
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

  }  // end function create setitem

  $configurationitemsets = 'a172e63a-8d26-ab84-2aee-526fbe56f621';
  $service_assets = 'a39735f4-b558-5214-1d07-52593e7f39da';
  $portal_items  = 'a33b0e31-b982-2957-9ffe-5255d9fcdd97';
  $credentials  = 'b6aefc07-66ca-d68e-b4c5-527323a836ec';

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
//  $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$configurationitemsets."' ";
  if ($val){
     $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$val."' ";
     } else {
     $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$service_assets."' ";
     }
  $ci_params[1] = ""; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         $id = $ci_items[$cnt]['id'];

         $ci_types_treestate = $treepart.$id;
         $ci_types_gottreestate = $_POST[$ci_types_treestate];

         $name = $ci_items[$cnt]['name'];
         $description = $ci_items[$cnt]['description'];
/*
         $date_entered = $ci_items[$cnt]['date_entered'];
         $date_modified = $ci_items[$cnt]['date_modified'];
         $modified_user_id = $ci_items[$cnt]['modified_user_id'];
         $created_by = $ci_items[$cnt]['created_by'];
         $deleted = $ci_items[$cnt]['deleted'];
         $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
*/
         $ci_type_id = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
         $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
         $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
         $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];

         if ($ci_items[$cnt][$lingoname] != NULL){
            $name = $ci_items[$cnt][$lingoname];
            }

         $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

         $ci_types .= "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\">[".$name."]</a>";

/*
         if ($ci_types_gottreestate == ""){

            $ci_types .= "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$ci_types_treestate."=1');return false\"><img src=images/icons/plus.gif> [".$name."]</a>";

            } else {

            #############################

            $ci_object_type = "ConfigurationItemTypes";
            $ci_action = "select";
            $ci_params_two[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id."' ";
            $ci_params_two[1] = ""; // select array
            $ci_params_two[2] = ""; // group;
            $ci_params_two[3] = ""; // order;
            $ci_params_two[4] = ""; // limit
  
            $ci_items_two = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params_two);

            if (is_array($ci_items_two)){

               for ($cnt=0;$cnt < count($ci_items_two);$cnt++){
 
                   $id_two = $ci_items_two[$cnt]['id'];

                   $ci_types_two_treestate = $treepart.$id_two;
                   $ci_types_two_gottreestate = $_POST[$ci_types_two_treestate];

                   $name_two = $ci_items_two[$cnt]['name'];
//                   $description = $ci_items[$cnt]['description'];
                   $ci_type_id = $ci_items_two[$cnt]['sclm_configurationitemtypes_id_c'];
                   $sclm_configurationitems_id_c = $ci_items_two[$cnt]['sclm_configurationitems_id_c'];
                   $account_id_c = $ci_items_two[$cnt]['account_id_c'];
                   $contact_id_c = $ci_items_two[$cnt]['contact_id_c'];

                   if ($ci_items_two[$cnt][$lingoname] != NULL){
                      $name_two = $ci_items_two[$cnt][$lingoname];
                      }

                   if ($ci_types_two_gottreestate == ""){

                      $ci_types_two .= "<BR><img src=images/blank.gif width=20 height=5><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$ci_types_two_treestate."=1');return false\"><img src=images/icons/plus.gif> [".$name_two."]</a>";

                      } else {

                      #############################

                      $cis_object_type = "ConfigurationItems";
                      $cis_action = "select";
                      if ($auth==3){
//                         $cis_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c IS NULL ";
                         $cis_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c ='NULL' ";
                         } else {
//                         $cis_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c IS NULL && account_id_c='".$account_id_c."' ";
                         $cis_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c ='NULL'";
  
                         }
                      $cis_params[1] = ""; // select array
                      $cis_params[2] = ""; // group;
                      $cis_params[3] = ""; // order;
                      $cis_params[4] = ""; // limit
  
                      $cis_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

                      if (is_array($cis_items)){

                         for ($cnt=0;$cnt < count($cis_items);$cnt++){
 
                             $ci_id = $cis_items[$cnt]['id'];

                             $cis_treestate = $treepart.$ci_id;
                             $cis_gottreestate = $_POST[$cis_treestate];

                             $cis_name = $cis_items[$cnt]['name'];
                             $cis_image_url = $cis_items[$cnt]['image_url'];
//                   $description = $ci_items[$cnt]['description'];
                             $ci_type_id = $cis_items[$cnt]['sclm_configurationitemtypes_id_c'];
                             $sclm_configurationitems_id_c = $cis_items[$cnt]['sclm_configurationitems_id_c'];
                             $account_id_c = $cis_items[$cnt]['account_id_c'];
                             $contact_id_c = $cis_items[$cnt]['contact_id_c'];

                             if ($cis_items[$cnt][$lingoname] != NULL){
                                $cis_name = $cis_items[$cnt][$lingoname];
                                }

                             if (!$cis_image_url){
                                $cis_image_url = "images/icons/env_repair_16.gif";
                                }

                             if ($cis_gottreestate == ""){

                                $cis .= "<BR><img src=images/blank.gif width=40 height=5><img src=".$cis_image_url." width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$cis_treestate."=1');return false\"><img src=images/icons/plus.gif> [".$cis_name."]</a>";

                                } else {

                                #############################

                                $cis_two_object_type = "ConfigurationItems";
                                $cis_two_action = "select";
                                if ($auth==3){
                                   $cis_two_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c='".$ci_id."' ";
                                   } else {
//                                   $cis_two_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c='".$ci_id."' && account_id_c='".$account_id_c."' ";
                                   $cis_two_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' && sclm_configurationitems_id_c='".$ci_id."' ";
                                   }

                                $cis_two_params[1] = ""; // select array
                                $cis_two_params[2] = ""; // group;
                                $cis_two_params[3] = ""; // order;
                                $cis_two_params[4] = ""; // limit
  
                                $cis_two_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_two_object_type, $cis_two_action, $cis_two_params);

                                if (is_array($cis_two_items)){

                                   for ($cnt=0;$cnt < count($cis_two_items);$cnt++){
 
                                       $ci_two_id = $cis_two_items[$cnt]['id'];

                                       $cis_two_treestate = $treepart.$ci_two_id;
                                       $cis_two_gottreestate = $_POST[$cis_two_treestate];

                                       $cis_two_name = $cis_two_items[$cnt]['name'];
                                       $cis_two_image_url = $cis_two_items[$cnt]['image_url'];
//                   $description = $ci_items[$cnt]['description'];
                                       $ci_two_type_id = $cis_two_items[$cnt]['sclm_configurationitemtypes_id_c'];
                                       $sclm_configurationitems_id_c_two = $cis_two_items[$cnt]['sclm_configurationitems_id_c'];
                                       $cis_two_account_id_c = $cis_two_items[$cnt]['account_id_c'];
                                       $cis_two_contact_id_c = $cis_two_items[$cnt]['contact_id_c'];

                                       if ($account_id_c == $cis_two_account_id_c){

                                          $setparams[0] = $id;
                                          $setparams[1] = $name;
                                          $setparams[2] = $account_id_c;
                                          $setparams[3] = $contact_id_c;
                                          $setparams[4] = $valtype;
                                          $setparams[5] = $description;
                                          $setparams[6] = $do;
                                          $setparams[7] = $action;

                                          create_setitem ($setparams);

                                          }

                                       if ($cis_two_items[$cnt][$lingoname] != NULL){
                                          $cis_two_name = $cis_two_items[$cnt][$lingoname];
                                          }

                                       if (!$cis_two_image_url){
                                          $cis_two_image_url = "images/icons/env_repair_16.gif";
                                          }

                                       if ($cis_two_gottreestate == ""){

                                          $cis_two .= "<BR><img src=images/blank.gif width=50 height=5><img src=".$cis_two_image_url." width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$cis_two_treestate."=1');return false\"><img src=images/icons/plus.gif> [".$cis_two_name."]</a>";

                                          } else {

                                          $cis_two .= "<BR><img src=images/blank.gif width=50 height=5><img src=".$cis_two_image_url." width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$cis_two_treestate."=');return false\"><img src=images/icons/minus.gif> [".$cis_two_name."]</a>";

                                          } // end if treestate
          
                                       } // end for

                                   } // is array


                              $cis .= "<BR><img src=images/blank.gif width=40 height=5><img src=".$cis_image_url." width=16> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$cis_treestate."=');return false\"><img src=images/icons/minus.gif> [".$cis_name."]</a>".$cis_two;

                                } // end if treestate
          
                             } // end for

                         } // is array

                      $ci_object_type = "ConfigurationItemTypes";
                      $ci_action = "select";
                      $ci_params_three[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id_two."' ";
                      $ci_params_three[1] = ""; // select array
                      $ci_params_three[2] = ""; // group;
                      $ci_params_three[3] = ""; // order;
                      $ci_params_three[4] = ""; // limit
  
                      $ci_items_three = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params_three);

                      if (is_array($ci_items_three)){

                         for ($cnt=0;$cnt < count($ci_items_three);$cnt++){
 
                             $id_three = $ci_items_three[$cnt]['id'];

                             $ci_types_three_treestate = $treepart.$id_three;
                             $ci_types_three_gottreestate = $_POST[$ci_types_three_treestate];

                             $name_three = $ci_items_three[$cnt]['name'];
//                   $description = $ci_items[$cnt]['description'];
                             $ci_type_id = $ci_items_three[$cnt]['sclm_configurationitemtypes_id_c'];
                             $sclm_configurationitems_id_c = $ci_items_three[$cnt]['sclm_configurationitems_id_c'];
                             $account_id_c = $ci_items_three[$cnt]['account_id_c'];
                             $contact_id_c = $ci_items_three[$cnt]['contact_id_c'];

                             if ($ci_items_three[$cnt][$lingoname] != NULL){
                                $name_three = $ci_items_three[$cnt][$lingoname];
                                }

                             if ($ci_types_three_gottreestate == ""){

                                $ci_types_three .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$ci_types_three_treestate."=1');return false\"><img src=images/icons/plus.gif> [".$name_three."]</a>";

                                } else {

                                $ci_types_three .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$ci_types_three_treestate."=');return false\"><img src=images/icons/minus.gif> [".$name_three."]</a>";

                                } // end if treestate
          
                             } // end for

                         } // is array

                      ###############################

                      $ci_types_two .= "<BR><img src=images/blank.gif width=20 height=5><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$ci_types_two_treestate."=');return false\"><img src=images/icons/minus.gif> [".$name_two."]</a>".$cis."<BR><img src=images/blank.gif width=30 height=5>".$ci_types_three;

                      } // end if treestate
          
                   } // end for

               } // is array

            ###############################

            $ci_types .= "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype.$collapsables."&".$ci_types_treestate."=');return false\"><img src=images/icons/minus.gif> [".$name."]</a>".$ci_types_two;

            } // end if treestate
*/

         } // end for

     echo "<div style=\"".$divstyle_white."\">".$ci_types. "</div>";

     } else {// is array

echo "NAIN";

     } 


//  $system_access = FALSE;

//  $system_access = TRUE;

  $ci_object_type = "ConfigurationItems";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && account_id_c='".$account_id_c."' ";
  $ci_params[1] = ""; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  switch ($valtype){
   
   case 'Infrastructure':

    echo "Infrastructure";

    $ci_object_type = "AccountsConfigurationItems";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && account_id_c='".$account_id_c."' ";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    switch ($action){

     case 'list':

echo "LIST";

     break;
     case 'add':
     case 'edit':
     case 'view':

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
             $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];

             } // end for

         } // is array

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


      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "valuetype"; // Field Name
      $tablefields[$tblcnt][1] = "valuetype"; // Full Name
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
      $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
      $tablefields[$tblcnt][21] = $valtype; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'sclm_configurationitems_id_c'; // Field Name
      $tablefields[$tblcnt][1] = "Configuration Item"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
      $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
      $tablefields[$tblcnt][9][2] = 'id';
      $tablefields[$tblcnt][9][3] = 'name';
      if ($action == 'add'){
         $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='7827074f-a7d3-9ae5-e473-5255d64e5c73' ";
         } else {
         $tablefields[$tblcnt][9][4] = "";
         } 
      $tablefields[$tblcnt][9][5] = $sclm_configurationitems_id_c; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $sclm_configurationitems_id_c; // Current Value
//      $params['ci_data_type'] = $ci_data_type;
//      $params['ci_name'] = $external_source_type;
//      $tablefields[$tblcnt][9][10] = $params; // Various Params
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'sclm_configurationitems_id_c';//$field_value_id;
      $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;

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
      $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
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
      $container_params[3] = 'Infrastructure Configuration Items'; // container_title
      $container_params[4] = 'InfrastructureConfigurationItems'; // container_label
      $container_params[5] = $portal_info; // portal info
      $container_params[6] = $portal_config; // portal configs
      $container_params[7] = $strings; // portal configs
      $container_params[8] = $lingo; // portal configs

      $container = $funky_gear->make_container ($container_params);

      $container_top = $container[0];
      $container_middle = $container[1];
      $container_bottom = $container[2];

      $returner = $funky_gear->object_returner ("Accounts", $account_id_c);
      $object_return_name = $returner[0];
      $object_return = $returner[1];

      echo $object_return;

      echo $container_top;
  
      echo $zaform;

      echo $container_bottom;

     break;
     case 'process':

      $sent_assigned_user_id = 1;

      $process_object_type = "ConfigurationItems";
      $process_action = "update";

      if ($_POST['external_account']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['external_account_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['external_account']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['external_account']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'b656325e-95ce-cc9f-9e80-5219c4a9b430');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      $process_message = "Configuration Items Submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$_POST['account_id_c']."&valuetype=".$valtype."');return false\">here!</a><P>";

      $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
      $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

      echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

     break; // end portal set

    } // end vartype switch for process action

   break; // Infrastructure
   case 'ExternalSystem':

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

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
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

             if ($ci_type_id == 'b656325e-95ce-cc9f-9e80-5219c4a9b430'){
                $external_account = $name;
                $external_account_id = $id;
                }

             if ($ci_type_id == '9254a5ad-698a-2254-6127-51a9da598e45'){
                $external_admin_name = $name;
                $external_admin_name_id = $id;
                }

             if ($ci_type_id == '4dae87e1-3127-d7f1-d963-51a9da793fe5'){
                $external_admin_password = $name;
                $external_admin_password_id = $id;
                }

             if ($ci_type_id == '6321083c-f187-736c-0f59-51aa7d8d0e1d'){
                $external_source_type = $name;
                $external_source_type_id = $id;
                }

             if ($ci_type_id == 'b96c3687-8203-9f05-ab21-51a9dae3ad9f'){
                $external_url = $name;
                $external_url_id = $id;
                }

             } // end for

         } // is array

      $tblcnt = 0;

      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "valuetype"; // Field Name
      $tablefields[$tblcnt][1] = "valuetype"; // Full Name
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
      $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
      $tablefields[$tblcnt][21] = $valtype; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "child_id"; // Field Name
      $tablefields[$tblcnt][1] = "child_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "child_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $child_id; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_account"; // Field Name
      $tablefields[$tblcnt][1] = "External Account"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_account"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_account; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_account_id"; // Field Name
      $tablefields[$tblcnt][1] = "external_account_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_account_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_account_id; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_admin_name"; // Field Name
      $tablefields[$tblcnt][1] = "External Admin Name"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_admin_name"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_admin_name; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_admin_name_id"; // Field Name
      $tablefields[$tblcnt][1] = "external_admin_name_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_admin_name_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_admin_name_id; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_admin_password"; // Field Name
      $tablefields[$tblcnt][1] = "External Admin Password"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_admin_password"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_admin_password; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_admin_password_id"; // Field Name
      $tablefields[$tblcnt][1] = "external_admin_password_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_admin_password_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_admin_password_id; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'external_source_type'; // Field Name
      $tablefields[$tblcnt][1] = "External Source Type"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='6321083c-f187-736c-0f59-51aa7d8d0e1d' && account_id_c='NULL' "; // $exception external_source_types ;
      $tablefields[$tblcnt][9][5] = $external_source_type; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $external_source_type; // Current Value
//      $params['ci_data_type'] = $ci_data_type;
//      $params['ci_name'] = $external_source_type;
//      $tablefields[$tblcnt][9][10] = $params; // Various Params
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'external_source_type';//$field_value_id;
      $tablefields[$tblcnt][21] = $external_source_type; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_source_type_id"; // Field Name
      $tablefields[$tblcnt][1] = "External Source Type"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_source_type_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_source_type_id; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_url"; // Field Name
      $tablefields[$tblcnt][1] = "External URL"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_url"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_url; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "external_url_id"; // Field Name
      $tablefields[$tblcnt][1] = "external_url_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "external_url_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $external_url_id; //$field_value;   

      $admin = 1;

      $valpack = "";
      $valpack[0] = $do;
      $valpack[1] = $action;
      $valpack[2] = $valtype;
      $valpack[3] = $tablefields;
      $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
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
       $container_params[3] = 'External System'; // container_title
       $container_params[4] = 'ExternalSystem'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       $returner = $funky_gear->object_returner ("Accounts", $account_id_c);
       $object_return_name = $returner[0];
       $object_return = $returner[1];
       $object_return_title = $returner[2];
       $object_return_target = $returner[3];
       $object_return_params = $returner[4];
       $object_return_completion = $returner[5];
       $object_return_voter = $returner[6];

       echo $object_return;

       echo $container_top;
  
       echo $zaform;

       echo $container_bottom;

     break;
     case 'process':

      $sent_assigned_user_id = 1;

      $process_object_type = "ConfigurationItems";
      $process_action = "update";

      if ($_POST['external_account']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['external_account_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['external_account']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['external_account']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'b656325e-95ce-cc9f-9e80-5219c4a9b430');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['external_admin_name']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['external_admin_name_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['external_admin_name']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['external_admin_name']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '9254a5ad-698a-2254-6127-51a9da598e45');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['external_admin_password']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['external_admin_password_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['external_admin_password']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['external_admin_password']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '4dae87e1-3127-d7f1-d963-51a9da793fe5');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['external_source_type']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['external_source_type_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['external_source_type']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['external_source_type']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '6321083c-f187-736c-0f59-51aa7d8d0e1d');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['external_url']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['external_url_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['external_url']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['external_url']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'b96c3687-8203-9f05-ab21-51a9dae3ad9f');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      $process_message = "Configuration Items Submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$_POST['account_id_c']."&valuetype=".$valtype."');return false\">here!</a><P>";

      $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
      $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

      echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

     break; // end portal set

    } // end vartype switch for process action

   break; // Infrastructure
   case 'PortalSet':

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      $portal_email = "";
      $portal_email_password = "";

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
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

             if ($ci_type_id == 'ea0de164-0803-4551-8cc1-51fdc1881db6'){
                $allow_engineer_rego = $name;
                $allow_engineer_rego_id = $id;
                }

             if ($ci_type_id == 'c964c341-ebef-c62b-07f5-51a9cea93d17'){ //portal_title
                $portal_title = $name;
                $portal_title_id = $id;
                }

             if ($ci_type_id == '723305fd-5711-83d6-1158-51aa0cfcb607'){ //portal_logo
                $portal_logo = $name;
                $portal_logo_id = $id;
                }

             if ($ci_type_id == '571f4cd2-1d12-d165-a8c7-5205833eb24c'){ //portal_email_server
                $portal_email_server = $name;
                $portal_email_server_id = $id;
                }

             if ($ci_type_id == '795f11f8-ab63-3948-aac3-51d777dd433c'){ //portal_email
                $portal_email = $name;
                $portal_email_id = $id;
                }

             if ($ci_type_id == '12e4272a-e571-1067-44f3-51d7787a4045'){ //portal_email_password
                $portal_email_password = $name;
                $portal_email_password_id = $id;
                }

//             if ($ci_type_id == 'c0fed5ce-05ba-66e2-e9ae-51b2f2446f68'){ // portal_skins
             if ($ci_type_id == '9dc21c7b-6279-dfd3-3663-51b2f0489807'){ // portal_skins
                $portal_skin = $name;
                $portal_skin_id = $id;
                }

             if ($ci_type_id == 'ad2eaca7-8f00-9917-501a-519d3e8e3b35'){ //hostname
                $hostname = $name;
                $hostname_id = $id;
                }
      
             } // end for

         } // is array

      $tblcnt = 0;

      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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
      $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
      $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "valuetype"; // Field Name
      $tablefields[$tblcnt][1] = "valuetype"; // Full Name
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
      $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
      $tablefields[$tblcnt][21] = $valtype; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = "child_id"; // Field Name
      $tablefields[$tblcnt][1] = "child_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "child_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $child_id; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'allow_engineer_rego'; // Field Name
      $tablefields[$tblcnt][1] = "Allow Engineer Registrations"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'allow_engineer_rego';//$field_value_id;
      $tablefields[$tblcnt][21] = $allow_engineer_rego; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'allow_engineer_rego_id'; // Field Name
      $tablefields[$tblcnt][1] = "Allow Engineer Registrations ID"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'allow_engineer_rego_id';//$field_value_id;
      $tablefields[$tblcnt][21] = $allow_engineer_rego_id; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = "hostname"; // Field Name
      $tablefields[$tblcnt][1] = "Portal Hostname (Sub/Domain)"; // Full Name
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
      $tablefields[$tblcnt][20] = "hostname"; //$field_value_id;
      $tablefields[$tblcnt][21] = $hostname; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "hostname_id"; // Field Name
      $tablefields[$tblcnt][1] = "hostname_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "hostname_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $hostname_id; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_title"; // Field Name
      $tablefields[$tblcnt][1] = "Portal Title"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_title"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_title; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_title_id"; // Field Name
      $tablefields[$tblcnt][1] = "portal_title_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_title_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_title_id; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_logo"; // Field Name
      $tablefields[$tblcnt][1] = "Portal Logo"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_logo"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_logo; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_logo_id"; // Field Name
      $tablefields[$tblcnt][1] = "portal_logo_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_logo_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_logo_id; //$field_value; 


      $tblcnt++;

      $tablefields[$tblcnt][0] = 'portal_email_server'; // Field Name
      $tablefields[$tblcnt][1] = "Portal Email Server"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='571f4cd2-1d12-d165-a8c7-5205833eb24c' ";
      $tablefields[$tblcnt][9][5] = $portal_email_server; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $portal_email_server; // Current Value
//      $params['ci_data_type'] = $ci_data_type;
//      $params['ci_name'] = $external_source_type;
//      $tablefields[$tblcnt][9][10] = $params; // Various Params
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'portal_email_server';//$field_value_id;
      $tablefields[$tblcnt][21] = $portal_email_server; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_email_server_id"; // Field Name
      $tablefields[$tblcnt][1] = "portal_email_server_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_email_server_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_email_server_id; //$field_value; 

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_email"; // Field Name
      $tablefields[$tblcnt][1] = "Portal Email"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_email"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_email; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_email_id"; // Field Name
      $tablefields[$tblcnt][1] = "portal_email_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_email_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_email_id; //$field_value; 

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_email_password"; // Field Name
      $tablefields[$tblcnt][1] = "Portal Email Password"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_email_password"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_email_password; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_email_password_id"; // Field Name
      $tablefields[$tblcnt][1] = "portal_email_password_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_email_password_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_email_password_id; //$field_value; 

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'portal_skin'; // Field Name
      $tablefields[$tblcnt][1] = "Portal Skin"; // Full Name
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
//      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='9dc21c7b-6279-dfd3-3663-51b2f0489807' && account_id_c='NULL' ";
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='9dc21c7b-6279-dfd3-3663-51b2f0489807' ";
//      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='c0fed5ce-05ba-66e2-e9ae-51b2f2446f68' ";
      $tablefields[$tblcnt][9][5] = $portal_skin; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $portal_skin; // Current Value
//      $params['ci_data_type'] = $ci_data_type;
//      $params['ci_name'] = $external_source_type;
//      $tablefields[$tblcnt][9][10] = $params; // Various Params
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'portal_skin';//$field_value_id;
      $tablefields[$tblcnt][21] = $portal_skin; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = "portal_skin_id"; // Field Name
      $tablefields[$tblcnt][1] = "portal_skin_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "portal_skin_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $portal_skin_id; //$field_value; 

      $admin = 1;

      $valpack = "";
      $valpack[0] = $do;
      $valpack[1] = $action;
      $valpack[2] = $valtype;
      $valpack[3] = $tablefields;
      $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
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
       $container_params[3] = 'Portal Details'; // container_title
       $container_params[4] = 'PortalDetails'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       $returner = $funky_gear->object_returner ("Accounts", $account_id_c);
       $object_return_name = $returner[0];
       $object_return = $returner[1];
       $object_return_title = $returner[2];
       $object_return_target = $returner[3];
       $object_return_params = $returner[4];
       $object_return_completion = $returner[5];
       $object_return_voter = $returner[6];

       echo $object_return;

       echo $container_top;
  
       echo $zaform;

       echo $container_bottom;

     break; //
     case 'process':

      $sent_assigned_user_id = 1;

      $process_object_type = "ConfigurationItems";
      $process_action = "update";

      if ($_POST['hostname']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['hostname_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['hostname']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['hostname']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'ad2eaca7-8f00-9917-501a-519d3e8e3b35');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_title']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_title_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_title']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_title']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'c964c341-ebef-c62b-07f5-51a9cea93d17');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_logo']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_logo_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_logo']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_logo']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '723305fd-5711-83d6-1158-51aa0cfcb607');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email_server']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_server_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_server']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_server']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '571f4cd2-1d12-d165-a8c7-5205833eb24c');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '795f11f8-ab63-3948-aac3-51d777dd433c');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email_password']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_password_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_password']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_password']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '12e4272a-e571-1067-44f3-51d7787a4045');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_skins']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_skins_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_skins']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_skins']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '9dc21c7b-6279-dfd3-3663-51b2f0489807');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['allow_engineer_rego']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['allow_engineer_rego_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['allow_engineer_rego']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['allow_engineer_rego']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'ea0de164-0803-4551-8cc1-51fdc1881db6');

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      $process_message = "Configuration Items Submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$_POST['account_id_c']."&valuetype=".$valtype."');return false\">here!</a><P>";

      $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
      $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

      echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

     break; // end portal set

    } // end vartype switch for process action

   break; // end PortalSet

  } // end vartype switch

# break; // End
##########################################################
?>