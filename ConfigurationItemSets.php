<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: ConfigurationItemSets.php 
##########################################################
# case 'ConfigurationItemSets':

  if (!$lingo){
      $lingo = "en";
      }

  if (!$lingoname){
     $lingoname = "name_".$lingo;
     }

  function quick_ci_updates ($params){

   global $portalcode,$assigned_user_id,$strings;

   $data_type = $params[0];
   $cit = $params[1];
   $currval = $params[2];
   $do = $params[3];
   $val = $params[4];
   $valtype = $params[5];
   $text = $params[6];

   $confirmtext_enable = "Enable";
   $confirmtext_disable = "Disable";

   switch ($data_type){

    case '':
    case 'checkbox':
    case 'onoff':
    case 'yesno':

     if ($currval == 1){
        $ci = "<div id=\"".$cit."\" name=\"".$cit."\"><a href=\"#\" onClick=\"if(confirmer('".$confirmtext_disable."?')){loader('".$cit."');doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=".$do."&action=update&valuetype=".$valtype."&ci=".$val."&cit=".$cit."&ci_val=0&ci_txt=".$text."');return false;}\"><img src=images/icons/GreenTick.gif width=16 border=0> ".$text."</a></div>";
        } else {
        $ci = "<div id=\"".$cit."\" name=\"".$cit."\"><a href=\"#\" onClick=\"if(confirmer('".$confirmtext_enable."?')){loader('".$cit."');doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=".$do."&action=update&valuetype=".$valtype."&ci=".$val."&cit=".$cit."&ci_val=1&ci_txt=".$text."');return false;}\"><img src=images/icons/off.gif width=16 border=0> ".$text."</a></div>";
        }

    break;

   } # end switch

  return $ci;

  } # end function

  function create_setitem ($setparams){

    if (!$lingo){
       $lingo = "en";
       }
    if (!$lingoname){
       $lingoname = "name_".$lingo;
       }

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


/*

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
  
//  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

//  if (is_array($ci_items)){

//     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
/*
         $id = $ci_items[$cnt]['id'];
         $ci_types_treestate = $treepart.$id;
         $ci_types_gottreestate = $_POST[$ci_types_treestate];

         $name = $ci_items[$cnt]['name'];
         $description = $ci_items[$cnt]['description'];
         $date_entered = $ci_items[$cnt]['date_entered'];
         $date_modified = $ci_items[$cnt]['date_modified'];
         $modified_user_id = $ci_items[$cnt]['modified_user_id'];
         $created_by = $ci_items[$cnt]['created_by'];
         $deleted = $ci_items[$cnt]['deleted'];
         $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];

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

//         } // end for

//     echo "<div style=\"".$divstyle_white."\">".$ci_types. "</div>";

//     } else {// is array


//     } 


  switch ($valtype){

   ###############################
   # Set: Infrastructure

   // deprecated
   case 'OLDInfrastructure':

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

//echo "LIST";

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

   # Set End: Infrastructure
   ###############################
   # Set: ExternalSystem

   case 'ExternalSystem':

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' ";
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

   break; // ExternalSystem

   # Set End: ExternalSystem
   ###############################
   # Set: AdvisorySet

   case 'AdvisorySet':

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      $portal_email = "";
      $portal_email_password = "";

      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && (sclm_configurationitemtypes_id_c='8c6aaf99-04d9-f378-9904-52992a052162' || sclm_configurationitemtypes_id_c='7a908258-f1d2-b3b4-2a1d-526fb8b295af' || sclm_configurationitemtypes_id_c='d98f9873-5ccb-d4be-e587-52f5d1201f77' || sclm_configurationitemtypes_id_c='db691e92-801b-5e74-1b04-530bc8da32a9' || sclm_configurationitemtypes_id_c='e57e1bbd-89dc-336a-ea74-530bc77ac017') ";
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
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

             if ($ci_type_id == '8c6aaf99-04d9-f378-9904-52992a052162'){ // Right Side-Bar 
                $advisory_right_sidebar = $name;
                $advisory_right_sidebar_id = $id;
                }

             if ($ci_type_id == '7a908258-f1d2-b3b4-2a1d-526fb8b295af'){ // Advisory Characters 
                $advisory_character = $name;
                $advisory_character_id = $id;
                }

             if ($ci_type_id == 'd98f9873-5ccb-d4be-e587-52f5d1201f77'){ // Zingaya VoIP Button Account
                $zingaya_voip_button = $name;
                $zingaya_voip_button_id = $id;
                }

             if ($ci_type_id == 'db691e92-801b-5e74-1b04-530bc8da32a9'){ // advisory_text_logged_in_name
                $advisory_text_logged_in_name = $name;
                $advisory_text_logged_in_description = $description;
                $advisory_text_logged_in_id = $id;

                }

             if ($ci_type_id == 'e57e1bbd-89dc-336a-ea74-530bc77ac017'){ // advisory_text_notlogged_in_name
                $advisory_text_notlogged_in_name = $name;
                $advisory_text_notlogged_in_description = $description;
                $advisory_text_notlogged_in_id = $id;
                }


/*
            if ($ci_items[$cnt][$lingoname] != NULL){
               $lingo_name = $ci_items[$cnt][$lingoname];
               }

            if ($ci_items[$cnt][$lingodesc] != NULL){
               $lingo_description = $ci_items[$cnt][$lingodesc];
               }
*/
            } // end for

         } // is array

      $tblcnt = 0;

      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
      $tablefields[$tblcnt][21] = $valtype; //$field_value;  

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'advisory_right_sidebar'; // Field Name
      $tablefields[$tblcnt][1] = "Enable Advisory Side-bar"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'advisory_right_sidebar';//$field_value_id;
      $tablefields[$tblcnt][21] = $advisory_right_sidebar; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'advisory_right_sidebar_id'; // Field Name
      $tablefields[$tblcnt][1] = "Enable Advisory Side-bar ID"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][10] = '0';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'advisory_right_sidebar_id';//$field_value_id;
      $tablefields[$tblcnt][21] = $advisory_right_sidebar_id; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'advisory_character'; // Field Name
      $tablefields[$tblcnt][1] = $strings["AdvisoryCharacter"]; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'dropdown_gallery';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = ''; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default

      // Get Characters and Images
      $advisory_object_type = "ConfigurationItems";
      $advisory_action = "select";
      $advisory_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='7a908258-f1d2-b3b4-2a1d-526fb8b295af' && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
      $advisory_params[1] = ""; // select array
      $advisory_params[2] = ""; // group;
      $advisory_params[3] = ""; // order;
      $advisory_params[4] = ""; // limit
  
      $advisory_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisory_object_type, $advisory_action, $advisory_params);

      if (is_array($advisory_items)){

         for ($cnt=0;$cnt < count($advisory_items);$cnt++){
 
             $id = $advisory_items[$cnt]['id'];
             $name = $advisory_items[$cnt]['name'];
             $image_url = $advisory_items[$cnt]['image_url'];

             if ($advisory_items[$cnt][$lingoname] != NULL){
                $name = $advisory_items[$cnt][$lingoname];
                }

             $dd_values[0] = $name;
             $dd_values[1] = $image_url;
             $dd_pack[$id] = $dd_values;

             } // for

         } // if

      $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
      $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
      $tablefields[$tblcnt][9][2] = 'advisory_character';
      $tablefields[$tblcnt][9][3] = $strings["AdvisoryCharacter"];
      $tablefields[$tblcnt][9][4] = "";
      $tablefields[$tblcnt][9][5] = $advisory_character; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $advisory_character; // Current Value
      $tablefields[$tblcnt][9][10] = "radio"; // Current Value

      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'advisory_character';//$field_value_id;
      $tablefields[$tblcnt][21] = $advisory_character; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = "advisory_character_id"; // Field Name
      $tablefields[$tblcnt][1] = "advisory_character_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "advisory_character_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $advisory_character_id; //$field_value; 

      $tblcnt++;

      $tablefields[$tblcnt][0] = "zingaya_voip_button"; // Field Name
      $tablefields[$tblcnt][1] = "Zingaya VoIP Button ID <a href=http://www.zingaya.com/ target=parent>http://www.zingaya.com/</a>";
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
      $tablefields[$tblcnt][20] = "zingaya_voip_button"; //$field_value_id;
      $tablefields[$tblcnt][21] = $zingaya_voip_button; //$field_value; 

      $tblcnt++;

      $tablefields[$tblcnt][0] = "zingaya_voip_button_id"; // Field Name
      $tablefields[$tblcnt][1] = "zingaya_voip_button_id"; // Full Name
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
      $tablefields[$tblcnt][20] = "zingaya_voip_button_id"; //$field_value_id;
      $tablefields[$tblcnt][21] = $zingaya_voip_button_id; //$field_value; 

         $tblcnt++;

         $tablefields[$tblcnt][0] = "advisory_text_logged_in_id"; // Field Name
         $tablefields[$tblcnt][1] = "advisory_text_logged_in_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "advisory_text_logged_in_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $advisory_text_logged_in_id; //$field_value; 

         $tblcnt++;

         if (!$advisory_text_logged_in_name){
            $advisory_text_logged_in_name = $strings["AdvisoryWelcomeBack"];
            }

         $tablefields[$tblcnt][0] = 'advisory_text_logged_in_name'; // Field Name
         $tablefields[$tblcnt][1] = "Advisory Text - Logged In: Intro (Default)"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 1; // is_name
         $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '100'; // length
         $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = $advisory_text_logged_in_name; // Field ID
         $tablefields[$tblcnt][12] = '50'; // Field Length
         $tablefields[$tblcnt][20] = 'advisory_text_logged_in_name';//$field_value_id;
         $tablefields[$tblcnt][21] = $advisory_text_logged_in_name; //$field_value; 

         $tblcnt++;

         if (!$advisory_text_logged_in_description){
            $advisory_text_logged_in_description = $strings["AdvisoryMemberClickToViewAdvisory"];
            }

         $tablefields[$tblcnt][0] = 'advisory_text_logged_in_description'; // Field Name
         $tablefields[$tblcnt][1] = "Advisory Text - Logged In: Statement (Default)"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '255'; // length
         $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = $advisory_text_logged_in_description; // Field ID
         $tablefields[$tblcnt][12] = '65'; // Field Length
         $tablefields[$tblcnt][20] = 'advisory_text_logged_in_description';//$field_value_id;
         $tablefields[$tblcnt][21] = $advisory_text_logged_in_description; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "advisory_text_notlogged_in_id"; // Field Name
         $tablefields[$tblcnt][1] = "advisory_text_notlogged_in_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "advisory_text_notlogged_in_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $advisory_text_notlogged_in_id; //$field_value; 

         $tblcnt++;

         if (!$advisory_text_notlogged_in_name){
            $advisory_text_notlogged_in_name = $strings["AdvisoryWelcomeFriend"];
            }

         $tablefields[$tblcnt][0] = 'advisory_text_notlogged_in_name'; // Field Name
         $tablefields[$tblcnt][1] = "Advisory Text - NOT Logged In: Intro (Default)"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 1; // is_name
         $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '100'; // length
         $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = $advisory_text_notlogged_in_name; // Field ID
         $tablefields[$tblcnt][12] = '50'; // Field Length
         $tablefields[$tblcnt][20] = 'advisory_text_notlogged_in_name';//$field_value_id;
         $tablefields[$tblcnt][21] = $advisory_text_notlogged_in_name; //$field_value; 

         $tblcnt++;

         if (!$advisory_text_notlogged_in_description){
            $advisory_text_notlogged_in_description = $strings["AdvisoryFriendClickToViewAdvisory"];
            }

         $tablefields[$tblcnt][0] = 'advisory_text_notlogged_in_description'; // Field Name
         $tablefields[$tblcnt][1] = "Advisory Text - NOT Logged In: Statement (Default)"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '255'; // length
         $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = $advisory_text_notlogged_in_description; // Field ID
         $tablefields[$tblcnt][12] = '65'; // Field Length
         $tablefields[$tblcnt][20] = 'advisory_text_notlogged_in_description';//$field_value_id;
         $tablefields[$tblcnt][21] = $advisory_text_notlogged_in_description; //$field_value;

      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && sclm_configurationitemtypes_id_c='db691e92-801b-5e74-1b04-530bc8da32a9' ";
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
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

            if ($ci_items[$cnt][$lingoname] != NULL){
               $lingo_name = $ci_items[$cnt][$lingoname];
               }

            if ($ci_items[$cnt][$lingodesc] != NULL){
               $lingo_description = $ci_items[$cnt][$lingodesc];
               }

             # Advisory Text - Logged In
             #$advisory_text_logged_in_intro = $name;
             #$advisory_text_logged_in_statement = $description;
             #$advisory_text_logged_in_id = $id;

            } // end for

         $name_field_base = 'name_';
         $desc_field_base = 'description_';

         $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);

         ################################
         # Loop for allowed languages

         for ($x=0;$x<count($field_lingo_pack);$x++) {

             $name_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0];
             $desc_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0];

             $name_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0];
             $desc_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1];

             $language = $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0];

             $tblcnt++;

             $tablefields[$tblcnt][0] = "advisory_text_logged_in_".$name_field; // Field Name
             $tablefields[$tblcnt][1] = "Advisory Text - Logged In: Intro (".$language.")"; // Full Name
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
             $tablefields[$tblcnt][12] = '50'; // Field Length
             $tablefields[$tblcnt][20] = "advisory_text_logged_in_".$name_field;//$field_value_id;
             $tablefields[$tblcnt][21] = $name_content; //$field_value; 

             $tblcnt++;

             $tablefields[$tblcnt][0] = "advisory_text_logged_in_".$desc_field; // Field Name
             $tablefields[$tblcnt][1] = "Advisory Text - Logged In: Statement (".$language.")"; // Full Name
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
             $tablefields[$tblcnt][12] = '65'; // Field Length
             $tablefields[$tblcnt][20] = "advisory_text_logged_in_".$desc_field;//$field_value_id;
             $tablefields[$tblcnt][21] = $desc_content; //$field_value;

             } // end for languages

         } // is array

      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && sclm_configurationitemtypes_id_c='e57e1bbd-89dc-336a-ea74-530bc77ac017' ";
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
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

            if ($ci_items[$cnt][$lingoname] != NULL){
               $lingo_name = $ci_items[$cnt][$lingoname];
               }

            if ($ci_items[$cnt][$lingodesc] != NULL){
               $lingo_description = $ci_items[$cnt][$lingodesc];
               }

             # Advisory Text - Not Logged In
             #$advisory_text_notlogged_in_intro = $name;
             #$advisory_text_notlogged_in_statement = $description;
             #$advisory_text_notlogged_in_id = $id;

            } // end for

         $name_field_base = 'name_';
         $desc_field_base = 'description_';

         $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);

         ################################
         # Loop for allowed languages

         for ($x=0;$x<count($field_lingo_pack);$x++) {

             $name_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0];
             $desc_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0];

             $name_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0];
             $desc_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1];

             $language = $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0];

             $tblcnt++;

             $tablefields[$tblcnt][0] = "advisory_text_notlogged_in_".$name_field; // Field Name
             $tablefields[$tblcnt][1] = "Advisory Text - NOT Logged In: Intro (".$language.")"; // Full Name
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
             $tablefields[$tblcnt][12] = '50'; // Field Length
             $tablefields[$tblcnt][20] = "advisory_text_notlogged_in_".$name_field;//$field_value_id;
             $tablefields[$tblcnt][21] = $name_content; //$field_value; 

             $tblcnt++;

             $tablefields[$tblcnt][0] = "advisory_text_notlogged_in_".$desc_field; // Field Name
             $tablefields[$tblcnt][1] = "Advisory Text - NOT Logged In: Statement (".$language.")"; // Full Name
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
             $tablefields[$tblcnt][12] = '65'; // Field Length
             $tablefields[$tblcnt][20] = "advisory_text_notlogged_in_".$desc_field;//$field_value_id;
             $tablefields[$tblcnt][21] = $desc_content; //$field_value;

             } // end for languages

         } // is array

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
      $container_params[3] = $strings["Advisory"]; // container_title
      $container_params[4] = 'Advisory'; // container_label
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
  
       echo "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=edit&value=".$val."&valuetype=AdvisorySet');return false\"><font size=2 color=BLUE><B>".$strings["AdvisorySettings"]."</B></font></a></div>";

      echo $zaform;

      echo $container_bottom;

     break; //
     case 'process':

      $sent_assigned_user_id = 1;

      $process_object_type = "ConfigurationItems";
      $process_action = "update";

      if (!$_POST['advisory_right_sidebar']){
         $advisory_right_sidebar = 0;
         } else {
         $advisory_right_sidebar = 1;
         }

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['advisory_right_sidebar_id']);
         $process_params[] = array('name'=>'name','value' => $advisory_right_sidebar);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $advisory_right_sidebar);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '8c6aaf99-04d9-f378-9904-52992a052162');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

      if ($_POST['advisory_character']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['advisory_character_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['advisory_character']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['advisory_character']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '7a908258-f1d2-b3b4-2a1d-526fb8b295af');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['zingaya_voip_button']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['zingaya_voip_button_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['zingaya_voip_button']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['zingaya_voip_button']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'd98f9873-5ccb-d4be-e587-52f5d1201f77');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['advisory_text_logged_in_name']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['advisory_text_logged_in_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['advisory_text_logged_in_name']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['advisory_text_logged_in_description']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'db691e92-801b-5e74-1b04-530bc8da32a9');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       foreach ($_SESSION['lingobits'] as $name_lingo){

               #echo "key $name_key => value $name_value <BR>";

               $name = "advisory_text_logged_in_name_".$name_lingo;
               $name_value = $_POST[$name];

               if ($name_value){

                  $namefield = "name_".$name_lingo;
                  $process_params[] = array('name'=>$namefield,'value' => $name_value);

                  } // if namelingo

               $desc = "advisory_text_logged_in_description_".$name_lingo;
               $desc_value = $_POST[$desc];

               if ($desc_value){

                  $descfield = "description_".$name_lingo;
                  $process_params[] = array('name'=>$descfield,'value' => $desc_value);

                  } // if namelingo

               } // end foreach


         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
         }

      if ($_POST['advisory_text_notlogged_in_name']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['advisory_text_notlogged_in_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['advisory_text_notlogged_in_name']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['advisory_text_notlogged_in_description']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'e57e1bbd-89dc-336a-ea74-530bc77ac017');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       foreach ($_SESSION['lingobits'] as $name_lingo){

               $name = "advisory_text_notlogged_in_name_".$name_lingo;
               $name_value = $_POST[$name];

               if ($name_value){

                  $namefield = "name_".$name_lingo;
                  $process_params[] = array('name'=>$namefield,'value' => $name_value);

                  } // if namelingo

               $desc = "advisory_text_notlogged_in_description_".$name_lingo;
               $desc_value = $_POST[$desc];

               if ($desc_value){

                  $descfield = "description_".$name_lingo;
                  $process_params[] = array('name'=>$descfield,'value' => $desc_value);

                  } // if namelingo

               } // end foreach


         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
         }

      $process_message = $strings["SubmissionSuccess"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$_POST['account_id_c']."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

      echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

     break; // end portal set

    } // end vartype switch for process action

   break; //

   # Set End: AdvisorySet
   ###############################
   # Set: RelatedAccountSharing

   case 'RelatedAccountSharing':

    # Account sharing is only one aspect of acc relationships - may be other non-sharing data collectable
    # Use the account realtionship ID as par CI with acc_sharing_set CIT

    # Related Account Sharing: 3172f9e9-3915-b709-fc58-52b38864eaf6
    # Portal Access | ID: e2affd29-d116-caa8-6f0c-52fa4d034cf5
    # Shared Projects | ID: e95a1cfa-f6f9-c6d6-d84b-52b38884257f
    # Shared Service SLA Requests | ID: 39ffa1e6-2b7c-7aaa-3370-52b389684442
    # Shared Tickets | ID: 562695ff-00d4-8ead-e3c2-52b3897ef61e
    # Shared with Account | ID: 8ff4c847-2c82-9789-f085-52b3897c8bf6

    $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';
    $shared_account_cit = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

    switch ($action){

     case 'list':

      echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["RelatedAccountSharing"]."</B></font></center></div>";

      echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
      echo "<center><img src=images/icons/Partnership.png width=48></center>";
      echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
      echo "The following are Account Sharing Sets for the various related Accounts";
      echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

      // Get Accounts Sharing Set
      $cis_object_type = "ConfigurationItems";
      $cis_action = "select";

/*
      if ($auth == 3){
         $cis_params[0] = " sclm_configurationitemtypes_id_c='".$acc_sharing_set."' ";
         } else {
         $cis_params[0] = " sclm_configurationitemtypes_id_c='".$acc_sharing_set."' && account_id_c='".$sess_account_id."' ";
         }
*/
      #echo "<P>Val: ".$val."<P>";
      # $val = acc rel ID
      $cis_params[0] = " sclm_configurationitemtypes_id_c='".$acc_sharing_set."' && name='".$val."' ";
      $cis_params[1] = "id,name,image_url,contact_id_c,account_id_c,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,account_id_c,$lingoname"; // select array
      $cis_params[2] = ""; // group;
      $cis_params[3] = ""; // order;
      $cis_params[4] = ""; // limit
  
      $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

      if (is_array($cis_list)){

         #var_dump($cis_list);

         for ($ciscnt=0;$ciscnt < count($cis_list);$ciscnt++){

             $cis_id = $cis_list[$ciscnt]['id'];
             $name = $cis_list[$ciscnt]['name'];

             $rel_acc_returner = $funky_gear->object_returner ("AccountRelationships", $val);
             $rel_account_name = $rel_acc_returner[0];
             #$ar_name = $par_account_name. " (Parent) -> ".$account_name." (Child)";

             $record_contact_id_c = $cis_list[$ciscnt]['contact_id_c'];
             $record_account_id_c = $cis_list[$ciscnt]['account_id_c'];
             $image_url = $cis_list[$ciscnt]['image_url'];
             $sclm_configurationitems_id_c = $cis_list[$ciscnt]['sclm_configurationitems_id_c'];

             $edit = "";
             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$cis_id."&valuetype=ConfigurationItems&sendiv=CIS');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$cis_id;
                } else {
                $show_id = "";
                }

             $cis .= "<div style=\"".$divstyle_orange."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>Related Account Set:</B> ".$rel_account_name."<BR>".$edit."<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$cis_id."&valuetype=ConfigurationItems&sendiv=CIS');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

             ##########################################
             # Use Set to get Shared Accounts

             $cis_acc_object_type = "ConfigurationItems";
             $cis_acc_action = "select";
             $cis_acc_params[0] = " sclm_configurationitems_id_c='".$cis_id."' && sclm_configurationitemtypes_id_c='".$shared_account_cit."' ";
             $cis_acc_params[1] = "id,contact_id_c,account_id_c,name,image_url,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
             $cis_acc_params[2] = ""; // group;
             $cis_acc_params[3] = ""; // order;
             $cis_acc_params[4] = ""; // limit
  
             $cis_acc_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_acc_object_type, $cis_acc_action, $cis_acc_params);

             if (is_array($cis_acc_list)){

                #var_dump($cis_acc_list);

                for ($cntcisacc=0;$cntcisacc < count($cis_acc_list);$cntcisacc++){
 
                    $cis_acc_id = $cis_acc_list[$cntcisacc]['id'];
                    $cis_account_id = $cis_acc_list[$cntcisacc]['name'];
                    $cis_account_returner = $funky_gear->object_returner ("Accounts", $cis_account_id);
                    $cis_account_name = $cis_account_returner[0];
                    $cis_acc_contact_id_c = $cis_acc_list[$cntcisacc]['contact_id_c'];
                    $cis_acc_account_id_c = $cis_acc_list[$cntcisacc]['account_id_c'];
                    $cis_acc_image_url = $cis_acc_list[$cntcisacc]['image_url'];

                    $edit = "";
                    if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$cis_acc_account_id_c)){
                       $edit = "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$cis_acc_id."&valuetype=ConfigurationItems&sendiv=CIS');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                       }

                    if ($auth == 3){
                       $show_id = " | ID: ".$cis_acc_id;
                       } else {
                       $show_id = "";
                       }

                    $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:7%;float:left;padding-top:0;\"><img src=images/blank.gif width=15 height=5><img src=".$image_url." width=16></div><div style=\"width:91%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>Account:</B> ".$cis_account_name."<BR>".$edit."<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$cis_acc_id."&valuetype=ConfigurationItems&sendiv=CIS');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a> <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=build&value=".$cis_acc_id."&valuetype=RelatedAccountSharing&sendiv=CIS');return false\"><font size=2 color=blue><B>[".$strings["Build"]."]</B></font></a>".$show_id."</div></div>";

                    } // for cis_acc_id

                #$cis .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=8ff4c847-2c82-9789-f085-52b3897c8bf6&valuetype=ConfigurationItemTypes&sendiv=CIS');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Related Account -> ".$strings["action_addnew"]."</B></font></a></div>";

                } else { // is_array for cis_acc_id

                #No need to add another one for same account
                $cis .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$shared_account_cit."&valuetype=ConfigurationItemTypes&parent_ci=".$cis_id."&sendiv=CIS');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Related Account -> ".$strings["action_add"]."</B></font></a></div>";

                }

             } // for cis_list

         # $cis .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_sharing_set."&valuetype=ConfigurationItemTypes&sendiv=CIS');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Related Account Set -> ".$strings["action_addnew"]."</B></font></a></div>";

         } else {// is_array for cis_list

         $cis = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_sharing_set."&valuetype=ConfigurationItemTypes&sendiv=CIS');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Related Account Set -> ".$strings["action_add"]."</B></font></a></div>";

         } 

      echo "<div style=\"".$divstyle_blue."\" name='CIS' id='CIS'></div>";

      echo $cis;

      #echo "<div style=\"".$divstyle_orange_light."\">".$strings["FilterExplanation"]."</div>";
    
     break;
     case 'build':

      # Build based on the shared account under the relationship CI
      #Shared Projects | ID: e95a1cfa-f6f9-c6d6-d84b-52b38884257f
      #Shared Service SLA Requests | ID: 39ffa1e6-2b7c-7aaa-3370-52b389684442
      #Shared Tickets | ID: 562695ff-00d4-8ead-e3c2-52b3897ef61e
      #Shared Portal Administration | ID: 5195ecc6-ec22-1fdd-0fd5-54d898ab38ed

      $acc_shared_type_projects = 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f';
      $acc_shared_type_slarequests = '39ffa1e6-2b7c-7aaa-3370-52b389684442';
      $acc_shared_type_ticketing = '562695ff-00d4-8ead-e3c2-52b3897ef61e';
      $acc_shared_type_portalaccess = 'e2affd29-d116-caa8-6f0c-52fa4d034cf5';
      $acc_shared_type_portaladmin = '5195ecc6-ec22-1fdd-0fd5-54d898ab38ed';
      $acc_shared_type_portalemails = 'a8d97830-b100-e03e-c445-54d8be1ae651';
      $acc_shared_type_infra = 'c4f8a9b2-b8f2-8e42-995b-54d8d7e192c1';
      $acc_shared_type_pricing = '58a896be-c277-844b-f051-54ebedac5dd4'; # Shared Partner Pricing (Within own portal) 

      $returner = $funky_gear->object_returner ("ConfigurationItems", $val);
      $object_return_name = $returner[0];
      $returner = $funky_gear->object_returner ("Accounts", $object_return_name);
      $object_return_name = $returner[0];
      #$object_return = $returner[1];
      #echo $object_return_name;

      # Get record owner info
      $cis_ro_object_type = "ConfigurationItems";
      $cis_ro_action = "select";
      $cis_ro_params[0] = " id='".$val."' ";
      $cis_ro_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname";
      $cis_ro_params[2] = ""; // group;
      $cis_ro_params[3] = "sclm_configurationitemtypes_id_c ASC"; // order;
      $cis_ro_params[4] = ""; // limit
  
      $cis_ro_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_ro_object_type, $cis_ro_action, $cis_ro_params);

      if (is_array($cis_ro_list)){

         for ($cis_ro_cnt=0;$cis_ro_cnt < count($cis_ro_list);$cis_ro_cnt++){

             #$acc_sharebit_id = $cis_ro_list[$cis_ro_cnt]['id'];
             $record_contact_id_c = $cis_ro_list[$cis_ro_cnt]['contact_id_c'];
             $record_account_id_c = $cis_ro_list[$cis_ro_cnt]['account_id_c'];

             } # For

         } # IS array
 
      $cis_object_type = "ConfigurationItems";
      $cis_action = "select";
      $cis_params[0] = " sclm_configurationitems_id_c='".$val."' ";
      $cis_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname";
      $cis_params[2] = ""; // group;
      $cis_params[3] = "sclm_configurationitemtypes_id_c ASC"; // order;
      $cis_params[4] = ""; // limit
  
      $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

      if (is_array($cis_list)){

         $shared_project_bits = FALSE;
         $shared_slarequest_bits = FALSE;
         $shared_ticket_bits = FALSE;
         $shared_portal_access_bits = FALSE;
         $shared_portal_admin_bits = FALSE;
         $shared_portal_email_bits = FALSE;
         $shared_portal_infra_bits = FALSE;
         $shared_pricing_bits = FALSE;

         $icondivwidth = "16";
         $iconheight = "3";
         $rowdivwidth = "90%";

         for ($ciscnt=0;$ciscnt < count($cis_list);$ciscnt++){

             $acc_sharebit_id = $cis_list[$ciscnt]['id'];
             $record_contact_id_c = $cis_list[$ciscnt]['contact_id_c'];
             $record_account_id_c = $cis_list[$ciscnt]['account_id_c'];
             $acc_sharebit_configurationitemtypes_id_c = $cis_list[$ciscnt]['sclm_configurationitemtypes_id_c'];

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$acc_sharebit_id."&valuetype=ConfigurationItems&sendiv=CIS');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$acc_sharebit_id;
                } else {
                $show_id = "";
                }

             ############################
             # Projects

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_projects){

                $label = "Shared Project";
                $project_shared_id = $cis_list[$ciscnt]['name'];
                $project_shared_returner = $funky_gear->object_returner ("Projects", $project_shared_id);
                $project_shared_name = $project_shared_returner[0];
                $project_shared_link = $project_shared_returner[1];
                $project_type_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $project_type_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$project_shared_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id;

                if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                   $cis .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_sharebit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$acc_sharebit_id."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                   } else {
                   $cis .= "</div></div>";
                   } 

                $shared_project_bits = TRUE;

                } // if ticketing sharedbits

             # End Projects
             ############################
             # SLA Requests

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_slarequests){

                $label = "Shared SLA Requests";
                $slarequests_id = $cis_list[$ciscnt]['name'];
                $slarequests_returner = $funky_gear->object_returner ("ServiceSLARequests", $slarequests_id);
                $slarequests_name = $slarequests_returner[0];
                $slarequests_link = $slarequests_returner[1];
                $slarequests_shared_status_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $slarequests_shared_status_returner[7];

                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$slarequests_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id;

                if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                   $cis .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_sharebit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$acc_sharebit_id."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";
                   } else {
                   $cis .= "</div></div>";
                   } 

                $shared_slarequest_bits = TRUE;

                } // if Requests sharedbits

             # End SLA Requests
             ############################
             # Ticketing

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_ticketing){

                $label = "Ticketing Shared Status";
                $ticket_shared_status = $cis_list[$ciscnt]['name'];
                $ticket_shared_status = $funky_gear->yesno($ticket_shared_status);
                $ticket_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $ticket_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$ticket_shared_status."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $shared_ticket_bits = TRUE;

                } // if ticketing sharedbits

             # End Ticketing
             ############################
             # Portal Access

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_portalaccess){

                $label = "Shared Portal Access Status";
                $portal_shared_status = $cis_list[$ciscnt]['name'];
                $portal_shared_status = $funky_gear->yesno($portal_shared_status);
                $portal_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $portal_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$portal_shared_status."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $shared_portal_access_bits = TRUE;

                } // if Portal Access sharedbits

             # End Portal Access
             ############################
             # Portal Admin

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_portaladmin){

                $label = "Shared Portal Admin Status";
                $portal_shared_status = $cis_list[$ciscnt]['name'];
                $portal_shared_status = $funky_gear->yesno($portal_shared_status);
                $portal_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $portal_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$portal_shared_status."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $shared_portal_admin_bits = TRUE;

                } // if Portal Admin

             # End Portal Admin
             ############################
             # Portal Infra

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_infra){

                $label = "Shared Portal Infra Status";
                $portal_shared_status = $cis_list[$ciscnt]['name'];
                $portal_shared_status = $funky_gear->yesno($portal_shared_status);
                $portal_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $portal_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$portal_shared_status."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $shared_portal_infra_bits = TRUE;

                } // if Portal Admin

             # End Portal Admin
             ############################
             # Portal Emails

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_portalemails){

                $label = "Shared Portal Email Status";
                $portal_shared_status = $cis_list[$ciscnt]['name'];
                $portal_shared_status = $funky_gear->yesno($portal_shared_status);
                $portal_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $portal_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$portal_shared_status."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $shared_portal_email_bits = TRUE;

                } // if Portal Emails

             # End Portal Emails
             ############################
             # Shared Partner Pricing (Within own portal) 

             if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_pricing){

                $label = "Shared Pricing Status";
                $portal_shared_status = $cis_list[$ciscnt]['name'];
                $portal_shared_status = $funky_gear->yesno($portal_shared_status);
                $portal_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharebit_configurationitemtypes_id_c);
                $image_url = $portal_returner[7];
 
                $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$portal_shared_status."<BR>".$edit." <a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_sharebit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $shared_pricing_bits = TRUE;

                } // if Portal Emails

             # End Shared Partner Pricing (Within own portal) 
             ############################

             } // end for cis_list

         } else {// end is array cis_list

         # No Account-based items

         } //

      if ($shared_portal_access_bits == FALSE && $record_account_id_c == $sess_account_id){
         $cis_add = "<img src=images/blank.gif width=200 height=5><BR><a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_portalaccess."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Portal Access: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($shared_portal_admin_bits == FALSE && $record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_portaladmin."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Portal Admin: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($shared_portal_infra_bits == FALSE && $record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_infra."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Portal Infra: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($shared_portal_email_bits == FALSE && $record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_portalemails."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Portal Email: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($shared_ticket_bits == FALSE && $record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_ticketing."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Ticketing: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_projects."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Projects: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_slarequests."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared SLA Requests: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      if ($shared_pricing_bits == FALSE && $record_account_id_c == $sess_account_id){
         $cis_add .= "<a href=\"#\" onClick=\"loader('CIS');doBPOSTRequest('CIS','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$acc_shared_type_pricing."&valuetype=ConfigurationItemTypes&sendiv=CIS&clonevaluetype=ConfigurationItems&clonevalue=".$val."&parent_ci=".$val."&partype=".$acc_sharing_set."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Shared Partner's Pricing in Portal: ".$strings["action_addnew"]."</B></font></a><BR>";
         }

      echo $cis_add.$cis;

     break;

     } // end build

   break; // End set

   # Set End: SharedAccountFeatures
   ###############################
   # Set: EmailFilteringSet

   case 'EmailFilteringSet':

    switch ($action){

     case 'list':

      echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["EmailFiltering"]."</B></font></center></div>";

      echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
      echo "<center><img src=images/icons/Search.png width=48></center>";
      echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

      // Get Accounts Filtering Set
      $filterset_object_type = "ConfigurationItems";
      $filterset_action = "select";

      if ($auth == 3){
         $filterset_params[0] = " sclm_configurationitemtypes_id_c='d2313332-261a-cfe2-4fbe-528f0a6bb9a1' ";
         } else {
         $filterset_params[0] = " sclm_configurationitemtypes_id_c='d2313332-261a-cfe2-4fbe-528f0a6bb9a1' && account_id_c='".$sess_account_id."' ";
         }

      $filterset_params[1] = "id,enabled,name,image_url,contact_id_c,account_id_c,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,account_id_c,$lingoname"; // select array
      $filterset_params[2] = ""; // group;
      $filterset_params[3] = ""; // order;
      $filterset_params[4] = ""; // limit
  
      $filtersets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterset_object_type, $filterset_action, $filterset_params);

      if (is_array($filtersets)){

         $total_filtersets = count($filtersets);

         for ($cnt=0;$cnt < count($filtersets);$cnt++){

             $id = $filtersets[$cnt]['id'];
             $name = $filtersets[$cnt]['name'];
             $enabled = $filtersets[$cnt]['enabled'];
             if ($enabled == 1){
                $enabled = "Yes";
                } else {
                $enabled = "No";
                }
             $record_contact_id_c = $filtersets[$cnt]['contact_id_c'];
             $record_account_id_c = $filtersets[$cnt]['account_id_c'];
             $image_url = $filtersets[$cnt]['image_url'];
             $sclm_configurationitems_id_c = $filtersets[$cnt]['sclm_configurationitems_id_c'];

             $edit = "";
             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($filtersets[$cnt][$lingoname] != NULL){
                $name = $filtersets[$cnt][$lingoname];
                }

             if ($auth == 3){
                $show_id = " | ID: ".$id;
                } else {
                $show_id = "";
                }

             $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$strings["FilterSet"].":</B> ".$name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

             ##########################################
             # Use Filtering Set to get Filters

             $filter_object_type = "ConfigurationItems";
             $filter_action = "select";
             $filter_params[0] = " sclm_configurationitems_id_c='".$id."' && sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' ";
//            $filterpart_params[1] = "id,name,image_url,sclm_configurationitems_id_c,contact_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
             $filter_params[1] = "id,enabled,contact_id_c,account_id_c,name,image_url,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
             $filter_params[2] = ""; // group;
             $filter_params[3] = ""; // order;
             $filter_params[4] = ""; // limit
  
             $filter_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filter_object_type, $filter_action, $filter_params);

             $total_filters = 0;

             if (is_array($filter_list)){

                $total_filters = count($filter_list);

                for ($cntfltr=0;$cntfltr < count($filter_list);$cntfltr++){
 
                    $filter_id = $filter_list[$cntfltr]['id'];
                    $filter_name = $filter_list[$cntfltr]['name'];
                    $enabled = $filter_list[$cntfltr]['enabled'];

                    if ($enabled == 1){
                       $enabled = "Yes";
                       $total_enabled_filters++;
                       } else {
                       $enabled = "No";
                       }

                    $filter_contact_id_c = $filter_list[$cntfltr]['contact_id_c'];
                    $filter_account_id_c = $filter_list[$cntfltr]['account_id_c'];
                    $image_url = $filter_list[$cntfltr]['image_url'];
	
                    $edit = "";
                    if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$filter_account_id_c)){
                       $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filter_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                       }

                    if ($auth == 3){
                       $show_id = " | ID: ".$filter_id;
                       } else {
                       $show_id = "";
                       }

                    $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:7%;float:left;padding-top:0;\"><img src=images/blank.gif width=15 height=5><img src=".$image_url." width=16></div><div style=\"width:91%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$strings["Filter"].":</B> ".$filter_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filter_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a> <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=build&value=".$filter_id."&valuetype=EmailFilteringSet&sendiv=FILTER');return false\"><font size=2 color=blue><B>[".$strings["Build"]."]</B></font></a>".$show_id."</div></div>";

                    } // for filters

                $filters .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["Filter"]."->".$strings["action_addnew"]."</B></font></a></div>";

                } else {// is_array for filters

                $filters .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["Filter"]."->".$strings["action_addnew"]."</B></font></a></div>";

                } 

             # Add Server Capturer
             ##########################################
             # Use Filtering Set to get Filters

             $srv_object_type = "ConfigurationItems";
             $srv_action = "select";
             $srv_params[0] = " sclm_configurationitems_id_c='".$id."' && sclm_configurationitemtypes_id_c='17697341-0e34-26d8-a677-54d90fca5790' ";

             $srv_params[1] = "id,enabled,contact_id_c,account_id_c,name,image_url,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
             $srv_params[2] = ""; // group;
             $srv_params[3] = ""; // order;
             $srv_params[4] = ""; // limit
  
             $srv_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $srv_object_type, $srv_action, $srv_params);

             if (is_array($srv_list)){

                $total_servcapture = count($srv_list);

                for ($srv_cnt=0;$srv_cnt < count($srv_list);$srv_cnt++){
 
                    $srv_id = $srv_list[$srv_cnt]['id'];
                    $srv_name = $srv_list[$srv_cnt]['name'];
                    $enabled = $srv_list[$srv_cnt]['enabled'];

                    if ($enabled == 1){
                       $enabled = "Yes";
                       } else {
                       $enabled = "No";
                       }

                    $srv_contact_id_c = $srv_list[$srv_cnt]['contact_id_c'];
                    $srv_account_id_c = $srv_list[$srv_cnt]['account_id_c'];
                    $srv_url = $srv_list[$srv_cnt]['image_url'];
	
                    $edit = "";
                    if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$srv_account_id_c)){
                       $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$srv_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                       }

                    if ($auth == 3){
                       $show_id = " | ID: ".$srv_id;
                       } else {
                       $show_id = "";
                       }

                    $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:7%;float:left;padding-top:0;\"><img src=images/blank.gif width=15 height=5><img src=".$image_url." width=16></div><div style=\"width:91%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>Server Capture Strings:</B> ".$srv_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$srv_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                    } # for

                } # is_array

             # Add new server capture string
             $filters .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=17697341-0e34-26d8-a677-54d90fca5790&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$srv_id."&parent_ci=".$id."&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Server Capture Strings ->".$strings["action_addnew"]."</B></font></a></div>";

             } // for filter sets

         $filters .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=d2313332-261a-cfe2-4fbe-528f0a6bb9a1&valuetype=ConfigurationItemTypes&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterSet"]."->".$strings["action_addnew"]."</B></font></a></div>";

         } else {// array filter sets

         $filters = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=d2313332-261a-cfe2-4fbe-528f0a6bb9a1&valuetype=ConfigurationItemTypes&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterSet"]."->".$strings["action_add"]."</B></font></a></div>";

         } 

      # End filter presentation
      ########################################

      echo "<div style=\"".$divstyle_blue."\" name='FILTER' id='FILTER'></div>";
      echo $filters;
      echo "<div style=\"".$divstyle_blue."\">Total Filtersets:".$total_filtersets."<BR>Total Enabled Filters: ".$total_enabled_filters."<BR>Total Filters: ".$total_filters."<BR>Total Server Captures: ".$total_servcapture."</div>";

      echo "<div style=\"".$divstyle_orange_light."\">".$strings["FilterExplanation"]."</div>";
    
     break;
     case 'build':

/*

General: Auto-Notification Email Templates: 78b22b7d-48c5-737c-ffb6-52b8ded3345e

Use sender to determine the filters - if any
Email Filtering & Actions: d2313332-261a-cfe2-4fbe-528f0a6bb9a1
-> Filter Email Recipient(s) (Destination): 86c0b57a-4fde-3998-1744-52a8dc19de41
   -> TO: cf3271fc-f361-22c8-0212-52b998d102ac
   -> CC: 4203105b-79b1-8330-b136-52b9985ddcf1
   -> BCC: c2bc3b5f-bfdd-a0ef-e399-52b998a94a28
-> Filter Server: 6de9b547-7c78-9ff4-83ea-52a8dc7f33f1
-> Filter Email Sender (Source): 97ea1d7a-3243-4df3-38f4-52a8dc5793b4
-> Filter SLA Request: 683bb5f7-e1c7-4796-8d23-52b0df65369f
-> Filter: dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812
   -> Filter Email Templates: c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d
   -> Filter Date Range: ecf521df-6ff1-aa5c-0069-52b9d605f284
   -> Filter Time Range: 291f5d67-13af-1b11-7e39-52b9d60288dc
   -> Filter Day Range: bb105bd2-6d5d-e9b1-dc66-52ba021e1f63
   -> Create Ticket: 1078abaa-0615-06ef-9826-52b0d6f32290
   -> Filter String: 98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68
   -> Filter Trigger(s): 83a83279-9e48-0bfe-3ca0-52b8d8300cc2
      -> Email Only: 4f3d2814-e8ff-18a0-3d0f-52b8d841b39e
      -> Sender and Body String Match: a5d69649-6e50-56e1-d52c-52b8ddb43cd0
      -> Sender and Subject Exact String Match: 6e27808f-9fa0-f469-d04d-52b8dcb4bc8a
      -> String Exactly Matches Subject Only: 9dc67d76-b728-5a03-f8bf-52b8daf4da69
      -> String in Body: 50be0484-2daf-dd18-0b6b-52b8da93e1df
      -> String in Subject Only: b52694ac-cf4d-839e-3a74-52b8da5eb6c0
      -> All Strings must be in Subject: 6ffb1f7d-273e-6bc9-9688-532706510ec4
   -> Filter Recipients: 70f40a89-6522-fc86-6706-52ba755146b3
      -> TO: be9692fa-5341-6934-7500-52ba77913179
      -> CC: 45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0
      -> BCC: 47e1b49f-4059-3d14-94c7-52ba7891d1b5


Set up the filtering based on the Filter components and trigger type

*/
      $returner = $funky_gear->object_returner ($valtype, $val);
      $filter_id = $val;
      $object_return_name = $returner[0];
      $object_return = $returner[1];

      echo $object_return;
/*
      $object_return_title = $returner[2];
      $object_return_target = $returner[3];
      $object_return_params = $returner[4];
      $object_return_completion = $returner[5];
      $object_return_voter = $returner[6];
*/
      // Use Filtering Set to get filters
      $filterbit_object_type = "ConfigurationItems";
      $filterbit_action = "select";
      $filterbit_params[0] = " sclm_configurationitems_id_c='".$val."' ";
      $filterbit_params[1] = "id,enabled,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
      $filterbit_params[2] = ""; // group;
      $filterbit_params[3] = ""; // order;
      $filterbit_params[4] = ""; // limit
  
      $filterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

      $filterbit_id = "";
      $record_contact_id_c = "";
      $record_account_id_c = "";
      $filterbit_configurationitemtypes_id_c = "";
      $enabled = 0;

      if (is_array($filterbits)){

         $server_bits = FALSE;
         $ip_bits = FALSE;
         $sla_bits = FALSE;
         $sender_bits = FALSE;
         $time_bits = FALSE;
         $date_bits = FALSE;
         $day_bits = FALSE;
         $datetimeconcat_bits = FALSE;
         $string_bits = FALSE;
         $nonstring_bits = FALSE;
         $nonserverip_bits = FALSE;
         $frequency_count_bits = FALSE;
         $frequency_currcount_bits = FALSE;
         $frequency_timespan_bits = FALSE;
         $frequency_timestamp_bits = FALSE;
         $trigger_Email_Only_bits = FALSE;
         $trigger_Sender_Body_String_Match_bits = FALSE;
         $trigger_Subject_Body_NonString_Match_bits = FALSE;
         $trigger_Body_NonServerIP_Match_bits = FALSE;
         $trigger_Sender_Subject_Exact_String_Match_bits = FALSE;
         $trigger_Sender_Subject_NotExact_String_Match_bits = FALSE;
         $trigger_String_Exactly_Matches_Subject_Only_bits = FALSE;
         $trigger_String_in_Body_bits = FALSE;
         $trigger_MulitpleString_in_Body_bits = FALSE;
         $trigger_String_in_SubjectOrBody_bits = FALSE;
         $trigger_String_in_Subject_Only_bits = FALSE;
         $trigger_All_Strings_in_Subject_bits = FALSE;
         $trigger_nomatchcatchall_bits = FALSE;
         $trigger_frequencycount_bits = FALSE;
         $trigger_multiservercheck_bits = FALSE;
         $createtick_bits = FALSE;
         $createact_bits = FALSE;
         $createemail_bits = FALSE;
         $autoreply_bits = FALSE;
         $notify_bits = FALSE;
         $to_bits = FALSE;
         $cc_bits = FALSE;
         $bcc_bits = FALSE;

         ########################################
         # Servers

         $icondivwidth = "16";
         $iconheight = "3";
         $rowdivwidth = "90%";

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
 
             $filterbit_id = "";
             $record_contact_id_c = "";
             $record_account_id_c = "";
             $filterbit_configurationitemtypes_id_c = "";
             $enabled_id = 0;

             $filterbit_id = $filterbits[$cntfb]['id'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             /*
             if ($enabled_id == 1){
                $enabled = "Yes";
                } elseif ($enabled_id == 0){
                $enabled = "No";
                } else {
                $enabled = "Not set";
                } 

             #echo "Enabled: ".$enabled_id."<BR>";
             */

             $edit = "";
             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["CI_Server"];

             if ($filterbit_configurationitemtypes_id_c == '6de9b547-7c78-9ff4-83ea-52a8dc7f33f1'){
                $filter_server_id = $filterbits[$cntfb]['name']; // server actual CI ID
                // Use email to collect servers and filter strings
                // Need to collect name of server -> CI
                $filter_returner = $funky_gear->object_returner ("ConfigurationItems", $filter_server_id);
                $filter_server = $filter_returner[0];
                $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filterbit_configurationitemtypes_id_c);
                $image_url = $filterimage_returner[7];

                $enabled_id = $filterbits[$cntfb]['enabled'];
                $enabled = $funky_gear->yesno ($enabled_id);

 
                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_server."<BR>Enabled: ".$enabled."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                ##########################################
                # Get server-related switches

                $subicondivwidth = "26";
                $subiconheight = "3";
                $subrowdivwidth = "80%";

                $serverbit_object_type = "ConfigurationItems";
                $serverbit_action = "select";
                // parent CI will be the registered server (also a CI) - not the filter as we may use this filter for other purposes
                // The type is Live Status 1/0
                $serverbit_type_id = '423752fe-a632-9b4d-8c3b-52ccc968fe59';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit
  
                $serverbits = "";
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = $strings["CI_ServerStatus"];

                $addserver = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER&parent_ci=".$filter_server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_status_id = $serverbits[$srvbitcnt]['id'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $server_status = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_status_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_status_id;
                          } else {
                          $show_id = "";
                          }

                          switch ($server_status){

                           case '':
                            $server_status_show = "NA";
                            $thisdivstyle_orange = $divstyle_white;
                           break;
                           case '1':
                            $server_status_show = $strings["CI_ServerStatusOnline"];
                            $addserver = "";
                            $thisdivstyle_orange = $divstyle_blue;
                           break;
                           case '0':
                            $server_status_show = $strings["CI_ServerStatusOffline"];
                            $addserver = "";
                            $thisdivstyle_orange = $divstyle_orange;
                           break;

                          } // switch

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];

                       $filters .= "<div style=\"".$thisdivstyle_orange."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_status_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addserver."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $server_status_show = "NA";
                   $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B>NA<BR> ".$addserver."</div></div>";

                   } // else array

                # End get server-related switches
                ##########################################
                # Get server-related switches

                $subicondivwidth = "26";
                $subiconheight = "3";
                $subrowdivwidth = "80%";

                $serverbit_object_type = "ConfigurationItems";
                $serverbit_action = "select";
                # Parent CI will be the registered server (also a CI) - not the filter as we may use this filter for other purposes
                # The type is Maintenance 1/0
                $serverbit_type_id = '2864a518-19f4-ddfa-366e-52ccd012c28b';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit

                $serverbits = "";  
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = $strings["CI_ServerStatusMaintenance"];

                $addservermaintenance = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER&parent_ci=".$filter_server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_maintenance_status_id = $serverbits[$srvbitcnt]['id'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $server_maintenance_status = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_maintenance_status_id."&valuetype=".$valtype."&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_maintenance_status_id;
                          } else {
                          $show_id = "";
                          }

                          switch ($server_maintenance_status){

                           case '':
                            $server_status_show = "NA";
                            $thisdivstyle_orange = $divstyle_white;
                           break;
                           case '1':
                            $server_status_show = "ON";
                            $addservermaintenance = "";
                            $thisdivstyle_orange = $divstyle_orange;
                           break;
                           case '0':
                            $server_status_show = "OFF";
                            $addservermaintenance = "";
                            $thisdivstyle_orange = $divstyle_blue;
                           break;

                          } // switch

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];

                       $filters .= "<div style=\"".$thisdivstyle_orange."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_status_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addservermaintenance."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $server_status_show = "NA";
                   $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B>NA<BR> ".$addservermaintenance."</div></div>";

                   } // else array

                # Maintenance Window DateTime Start
                $serverbit_type_id = '787ab970-8f2a-efed-3aca-52ecd566b16b';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit

                $serverbits = "";
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = "Maintenance Window Start DateTime"; //$strings["CI_ServerStatusMaintenance"];

                $addservermaintenance = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER&parent_ci=".$filter_server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_maintenance_start_datetime_id = $serverbits[$srvbitcnt]['id'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $server_maintenance_start_datetime = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_maintenance_start_datetime_id."&valuetype=".$valtype."&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_maintenance_start_datetime_id;
                          } else {
                          $show_id = "";
                          }

                          if ($server_maintenance_start_datetime){
                             $start_datetime_show = $server_maintenance_start_datetime;
                             $thisdivstyle = $divstyle_light_orange;
                             } else {
                             $start_datetime_show = "NA";
                             $addservermaintenance = "";
                             $thisdivstyle = $divstyle_white;
                             } 

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];

                       $filters .= "<div style=\"".$thisdivstyle."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$start_datetime_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_start_datetime_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addservermaintenance."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B>NA<BR> ".$addservermaintenance."</div></div>";

                   } // else array

                # Maintenance Window DateTime End
                $serverbit_type_id = 'b38181b6-eb59-0bc3-bad3-52ecd65163f5';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit

                $serverbits = "";
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = "Maintenance Window End DateTime"; //$strings["CI_ServerStatusMaintenance"];

                $addservermaintenance = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER&parent_ci=".$filter_server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_maintenance_end_datetime_id = $serverbits[$srvbitcnt]['id'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $server_maintenance_end_datetime = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_maintenance_end_datetime_id."&valuetype=".$valtype."&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_maintenance_end_datetime_id;
                          } else {
                          $show_id = "";
                          }

                          if ($server_maintenance_end_datetime){
                             $end_datetime_show = $server_maintenance_end_datetime;
                             $thisdivstyle = $divstyle_light_orange;
                             } else {
                             $end_datetime_show = "NA";
                             $addservermaintenance = "";
                             $thisdivstyle = $divstyle_white;
                             } 

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];

                       $filters .= "<div style=\"".$thisdivstyle."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$end_datetime_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_end_datetime_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addservermaintenance."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B>NA<BR> ".$addservermaintenance."</div></div>";

                   } // else array

                # End get server-related switches
                ##########################################
                # Get server-related back-up details
                # Back-up Day: 67a6bcaf-4e45-42d6-79da-52d4df16784c
                # Back-up End Time: 913315fd-34d5-036e-0c52-52d4d91550d9
                # Back-up Job Name: 8802ae00-1abe-9819-558f-52d4d74b6ca2
                # Back-up Start Time: 4d440215-68e1-efe3-158e-52d4d808e6b1
                # Back-up Status: 530ae095-b3e7-c9fe-61fb-52d5aee0a272
                # Back-up Status Keyword(s): 56291976-233c-912a-b10e-52d4dfc8357c
                # Execution Server: 91694cfa-3f33-6505-d894-52d4d84722c0
                # Target Server: 734f02a8-5821-86f1-3229-52d4d80696ac

                $subicondivwidth = "26";
                $subiconheight = "3";
                $subrowdivwidth = "80%";

                # parent CI will be the registered server (also a CI) - not the filter as we may use this filter for other purposes
                # The type is Maintenance 1/0
                $serverbit_type_id = '530ae095-b3e7-c9fe-61fb-52d5aee0a272';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit

                $serverbits = "";  
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = $strings["CI_ServerStatusBackup"];

                $addserverbackup = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=FILTER&parent_ci=".$filter_server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_backup_status_id = $serverbits[$srvbitcnt]['id'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $server_backup_status = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_backup_status_id."&valuetype=".$valtype."&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_backup_status_id;
                          } else {
                          $show_id = "";
                          }

                          switch ($server_backup_status){

                           case '':
                            $server_status_show = "NA";
                            $thisdivstyle_orange = $divstyle_grey;
                           break;
                           case '1':
                            $server_status_show = "OK";
                            $addserverbackup = "";
                            $thisdivstyle_orange = $divstyle_blue;
                           break;
                           case '0':
                            $server_status_show = "NG";
                            $addserverbackup = "";
                            $thisdivstyle_orange = $divstyle_orange;
                           break;

                          } // switch

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];


                       $filters .= "<div style=\"".$thisdivstyle_orange."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_backup_status_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addserverbackup."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $server_status_show = "NA";
                   $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR> ".$addserverbackup."</div></div>";

                   } // else array

                # End get server-related switches
                ##########################################

                $server_bits = TRUE;

                } // if filterbit_configurationitemtypes_id_c

             } // for filterbits

         # End Servers
         ##########################################
         # Check for filter Non-Server/IPs

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["Filter"]." Non-Server/IPs";

             if ($filterbit_configurationitemtypes_id_c == 'd3ce77c0-aa02-e4e3-8e67-52d1ef420dde'){
                $filter_ipset = $filterbits[$cntfb]['name'];
                $filter_ipset_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_ipset_returner[7];

                $enabled_id = $filterbits[$cntfb]['enabled'];
                $enabled = $funky_gear->yesno ($enabled_id);

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_ipset."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                $nonserverip_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for Non-Server/IPs
         ##########################################
         # Check for filter IPs

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["Filter"]." IPs";

             if ($filterbit_configurationitemtypes_id_c == 'ef1bdff1-4df1-1562-7bd9-52c04ed4dae7'){
                $filter_ipset = $filterbits[$cntfb]['name'];
                $filter_ipset_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_ipset_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_ipset."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                $ip_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for IPs
         ##########################################
         # Use Filtering Set to get SLA Request

         $slcnt = "";
         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             if ($filterbit_configurationitemtypes_id_c == '683bb5f7-e1c7-4796-8d23-52b0df65369f'){
                $slcnt++;
                } // if 
             }

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["ServiceSLARequest"];

             if ($filterbit_configurationitemtypes_id_c == '683bb5f7-e1c7-4796-8d23-52b0df65369f'){
                $sla_filter_sla_id = $filterbits[$cntfb]['name']; // the actual ID of the SLA item
                $sla_returner = $funky_gear->object_returner ("ServiceSLARequests", $sla_filter_sla_id);
                $sla_filter_name = $sla_returner[0];
                $sla_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filterbit_configurationitemtypes_id_c);
                $image_url = $sla_returner[7];

               if ($slcnt >= 2){
                  $sla_bits = FALSE;
                  } else {
                  $sla_bits = TRUE;
                  $addsla = " <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";
                  }

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$sla_filter_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id.$addsla."</div></div>";

                } // if 

             } // for filterbits

         # End get sla
         ##########################################
         # Use Filtering Set to get Sender

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["EmailFilterSender"];

             if ($filterbit_configurationitemtypes_id_c == '97ea1d7a-3243-4df3-38f4-52a8dc5793b4'){
                $sender_address = $filterbits[$cntfb]['name']; // the actual ID of the sender item
                $sender_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filterbit_configurationitemtypes_id_c);
//                $sender_filter_name = $sender_returner[0];
                $image_url = $sender_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$sender_address."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                $sender_bits = TRUE;

               // Must pack in array for later use in checking within emails for server name
/*
                              $sender_pack[$sender_filter_sender_id]=$sender_filter_name;
                              if (!$addressees_pack){
                                 $addressees_pack = $sender_filter_name;
                                 } else {
                                 $addressees_pack = $addressees_pack.",".$sender_filter_name;
                                 }
*/

                } // if 

             } // for filterbits

         # End get sender
         ##########################################
         # Check for time ranges

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["FilterTimeRange"];

             if ($filterbit_configurationitemtypes_id_c == '291f5d67-13af-1b11-7e39-52b9d60288dc'){
                $filter_timerange = $filterbits[$cntfb]['name'];
                list($start_time,$end_time) = explode("_", $filter_timerange);
                $emailtime = date('H:i', strtotime($date));
//                                      list($email_hour,$email_minute) = explode(":", $emailtime);
                $filter_timerange_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_timerange_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_timerange."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                $time_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for time ranges
         ##########################################
         # Check for date ranges

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["FilterDateRange"];

             if ($filterbit_configurationitemtypes_id_c == 'ecf521df-6ff1-aa5c-0069-52b9d605f284'){
                $filter_daterange = $filterbits[$cntfb]['name'];
                $filter_daterange_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_daterange_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_daterange."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                $date_bits = TRUE;

                 } // if 

             } // for filterbits

         # End check for date ranges
         ##########################################
         # Check for day ranges

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> "; 
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["FilterDayRange"];

             if ($filterbit_configurationitemtypes_id_c == 'bb105bd2-6d5d-e9b1-dc66-52ba021e1f63'){
                $filter_dayrange = $filterbits[$cntfb]['name'];
                $filter_dayrange_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_dayrange_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_dayrange."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                $day_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for day ranges
         ##########################################
         # Check for daytime check

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == 'cc55a107-98ca-8261-9900-52ce36601cd0'){
                $filter_datetimeconcat = $filterbits[$cntfb]['name'];
                $datetimeconcat = $funky_gear->yesno ($filter_datetimeconcat);
                $filter_datetimeconcat_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_datetimeconcat_returner[7];

                $label = $strings["FilterDateTimeConcat"];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$datetimeconcat."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";
 
                $datetimeconcat_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for daytime check
         ##########################################
         # Check for filter string

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = $strings["FilterString"];

             if ($filterbit_configurationitemtypes_id_c == '98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68'){
                $filter_string = $filterbits[$cntfb]['name'];
                $filter_string_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_string_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_string."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

               // $string_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for string
         ##########################################
         # Check for filter NOT include string

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = "Filter Non-Strings"; //$strings["FilterString"];

             if ($filterbit_configurationitemtypes_id_c == 'afc56334-a00e-12d3-66ce-52d0f6cf46ec'){
                $filter_string = $filterbits[$cntfb]['name'];
                $filter_string_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_string_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_string."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$filterbit_configurationitemtypes_id_c."&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$filterbit_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

               // $string_bits = TRUE;

                } // if 

             } // for filterbits

         # End check for NOT include string
         ##########################################
         # Check for filter Frequency Count

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = "Frequency Count #"; //$strings["FilterString"];

             if ($filterbit_configurationitemtypes_id_c == 'a19083b1-25bd-65be-76e8-52def587f20f'){
                $filter_count = $filterbits[$cntfb]['name'];
                $filter_string_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_string_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_count."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $frequency_count_bits = TRUE;
                $frequencycount_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for Frequency Count
         ##########################################
         # Check for filter Frequency Current Count

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = "Frequency Current Count #"; //$strings["FilterString"];

             if ($filterbit_configurationitemtypes_id_c == 'c3891c31-9198-476d-0a8a-52df0e00c722'){
                $filter_currcount = $filterbits[$cntfb]['name'];
                $filter_string_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_string_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_currcount."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $frequency_currcount_bits = TRUE;
                $frequencycurrcount_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for Frequency Count
         ##########################################
         # Check for filter Frequency Timer

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = "Frequency Time-Span"; //$strings["FilterString"];

             if ($filterbit_configurationitemtypes_id_c == '278395e9-3127-dc1c-53ac-52def9c06c63'){
                $filter_timespan = $filterbits[$cntfb]['name'];
                $filter_string_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_string_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_timespan."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $frequency_timespan_bits = TRUE;
                $frequencytimespan_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for Frequency Timer
         ##########################################
         # Check for filter Frequency Timestamp

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             $label = "Frequency Timestamp (from)"; //$strings["FilterString"];

             if ($filterbit_configurationitemtypes_id_c == '7a454f0d-3d12-7bc5-7607-52defc746103'){
                $filter_timestamp = $filterbits[$cntfb]['name'];
                $filter_string_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_string_returner[7];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B> ".$label.":</B> ".$filter_timestamp."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $frequency_timestamp_bits = TRUE;
                $frequencytimestamp_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for Frequency Timestamp
         ##########################################
         # Check for filter triggers

         $element_binder = 'df940500-4cb3-b830-d6be-53e1f2801616';
         # Element binders are types that bind some other element to another
         # String to trigger - trigger is parent to the binder CI, CI name is ID of the bound element (string CI)

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             # Triggers

             if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2'){
                $filter_trigger = $filterbits[$cntfb]['name'];

                $enabled_id = $filterbits[$cntfb]['enabled'];
                $enabled = $funky_gear->yesno ($enabled_id);

                switch ($filter_trigger){

                 case '4f3d2814-e8ff-18a0-3d0f-52b8d841b39e': // email only

                  $label = $strings["FilterTriggerSenderEmailOnly"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit." <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_Email_Only_bits = TRUE;
                  $trigger_Email_Only_clone_id = $filterbit_id;

                 break; // end email only filter check
                 case 'a5d69649-6e50-56e1-d52c-52b8ddb43cd0': // Sender and Body String Match

                  $label = $strings["FilterTriggerSenderStringBodyMatch"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_Sender_Body_String_Match_bits = TRUE;
                  $trigger_Sender_Body_String_Match_clone_id = $filterbit_id;

                 break; // Sender and Body String Match
                 case 'ec244f7a-9ba9-7de6-2ead-52d08b86f607': // Subject and Body Non-String Match

                  $label = "Subject & Body Non-String Matching";// $strings["FilterTriggerSenderStringBodyMatch"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_Subject_Body_NonString_Match_bits = TRUE;
                  $trigger_Subject_Body_NonString_Match_clone_id = $filterbit_id;

                 break; // Sender and Body Non-String Match
                 case 'a0faabd3-32ce-1495-9616-52d1f105cac5': # Body Non-Server/IP Matching

                  $label = "Non-Server/IP Matching";

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_Body_NonServerIP_Match_bits = TRUE;
                  $trigger_Body_NonServerIP_Match_clone_id = $filterbit_id;

                 break; # Body Non-Server/IP Matching
                 case '6e27808f-9fa0-f469-d04d-52b8dcb4bc8a': # Sender and Subject Exact String Match

                  $label = $strings["FilterTriggerSenderStringSubjectExactMatch"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_Sender_Subject_Exact_String_Match_bits = TRUE;
                  $trigger_Sender_Subject_Exact_String_Match_clone_id = $filterbit_id;

                 break; # Sender and Subject Exact String Match
                 case '9dcd893b-93bb-ade3-57d5-52d08a4cdb09': // Sender and Subject NotExact String Match

                  #$label = $strings["FilterTriggerSenderStringSubjectNotExactMatch"];
                  $label = "Sender and Subject Not Exact Match";

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_Sender_Subject_NotExact_String_Match_bits = TRUE;
                  $trigger_Sender_Subject_NotExact_String_Match_clone_id = $filterbit_id;

                 break; //  Sender and Subject Exact String Match
                 case '9dc67d76-b728-5a03-f8bf-52b8daf4da69': // String Exactly Matches Subject Only

                  # Select the string to apply to the subject

                  $label = $strings["FilterTriggerStringSubjectExactMatchOnly"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";


                  $trigger_String_Exactly_Matches_Subject_Only_bits = TRUE;
                  $trigger_String_Exactly_Matches_Subject_Only_clone_id = $filterbit_id;

                 break; // String Exactly Matches Subject Only
                 case '50be0484-2daf-dd18-0b6b-52b8da93e1df': // String in Body

                  $label = $strings["FilterTriggerStringBody"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_String_in_Body_bits = TRUE;
                  $trigger_String_in_Body_bits_clone_id = $filterbit_id;

                 break; // String in Body
                 case '21a5e0a4-e760-351b-e606-52c8e5f5ce89': // Multiuple Strings in Body - any OK

                  $label = $strings["FilterTriggerStringBodyMultipleAnyOK"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_MulitpleString_in_Body_bits = TRUE;
                  $trigger_MulitpleString_in_Body_bits_clone_id = $filterbit_id;

                 break; // Multiple Strings in Body - any OK
                 case '5baf4830-c7c5-7a99-0149-54091ff99022': // Multiuple Strings in Body - ALL must match
                  $label = "All strings must match"; #$strings["FilterTriggerStringBodyMultipleAnyOK"];
                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];
                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";
                  $trigger_MulitpleString_in_Body_ALL_Match_bits = TRUE;
                  $trigger_MulitpleString_in_Body_ALL_Match_bits_clone_id = $filterbit_id;
                 break; // Multiple Strings in Body - ALL must match
                 case '275f496d-eab4-6cf3-3add-52e191ce3241': // Strings in Subject or Body - any OK

                  $label = "Strings in Subject or Body - any OK";//$strings["FilterTriggerStringBodyMultipleAnyOK"];

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_String_in_SubjectOrBody_bits = TRUE;
                  $trigger_String_in_SubjectOrBody_bits_clone_id = $filterbit_id;

                 break; // String in Body
                 case 'b52694ac-cf4d-839e-3a74-52b8da5eb6c0': // String in Subject Only

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $label = $strings["FilterTriggerStringSubjectOnly"];

                  # Check for any element binders
                  $be_params[0] = $filterbit_id; // binder_ci
                  $be_params[1] = $element_binder; // binder_tci
                  $be_params[2] = $filterbits; // ci_array
                  $be_params[3] = '98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68'; // be_type - string
                  $be_params[4] = 'FILTER'; // senddiv
                  $be_params[5] = $filter_id; // granpar_ci

                  $bounding_elements = $funky_gear->bounding_elements ($be_params);
                  $bound_elements_show = $bounding_elements[0];
                  $bound_elements = $bounding_elements[1];
                  $bindable_elements_show = $bounding_elements[2];
                  $bindable_elements = $bounding_elements[3];

                  $binders = "<div style=\"".$divstyle_white."\" id=\"$filter_string_ci_id\">".$bound_elements_show."".$bindable_elements_show."</div>";

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."<P>".$binders."</div></div>";

                  $trigger_String_in_Subject_Only_bits = TRUE;
                  $trigger_String_in_Subject_Only_clone_id = $filterbit_id;

                 break; // String in Subject Only
                 case '6ffb1f7d-273e-6bc9-9688-532706510ec4': // All Strings must be in Subject

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $label = "All ".$strings["FilterTriggerStringSubjectOnly"];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_All_Strings_in_Subject_bits = TRUE;
                  $trigger_All_Strings_in_Subject_clone_id = $filterbit_id;

                 break; // All Strings must be in Subject
                 case 'ebf1233d-4415-a3b8-f8aa-52cee1526e02': // Multiple Servers Down Check

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $label = "Multiple Servers Down Check"; //$strings["FilterTriggerNoMatchCatchAll"];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_multiservercheck_bits = TRUE;
                  $trigger_multiservercheck_clone_id = $filterbit_id;

                 break; // Multiple Servers Down Check
                 case 'a51b8e41-bb1b-f729-2c59-52ccc314bc0a': // Catch-all No Match Action 

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  $label = $strings["FilterTriggerNoMatchCatchAll"];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_nomatchcatchall_bits = TRUE;
                  $trigger_nomatchcatchall_clone_id = $filterbit_id;

                 break; // FilterTriggerNoMatchCatchAll
                 case '4241fe8d-450a-6ce6-87c2-52def2358317': // Frequency Count Match

                  $filter_trigger_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $filter_trigger);
                  $filter_trigger_name = $filter_trigger_returner[0];
                  $image_url = $filter_trigger_returner[7];

                  # Get Count
                  $freqbit_object_type = "ConfigurationItems";
                  $freqbit_action = "select";
                  $freqbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='7a454f0d-3d12-7bc5-7607-52defc746103' ";
                  $freqbit_params[1] = "id,contact_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                  $freqbit_params[2] = ""; // group;
                  $freqbit_params[3] = ""; // order;
                  $freqbit_params[4] = ""; // limit
  
                  $freqbit_timestamps = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freqbit_object_type, $freqbit_action, $freqbit_params);

                  if (is_array($freqbit_timestamps)){

                     for ($freqbitcnt=0;$freqbitcnt < count($freqbit_timestamps);$freqbitcnt++){
                         $timestamp = $freqbit_timestamps[$freqbitcnt]['name'];
                         }

                     } // if

                  # Get Timer-span
                  $freqbit_object_type = "ConfigurationItems";
                  $freqbit_action = "select";
                  $freqbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='278395e9-3127-dc1c-53ac-52def9c06c63' ";
                  $freqbit_params[1] = "id,contact_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                  $freqbit_params[2] = ""; // group;
                  $freqbit_params[3] = ""; // order;
                  $freqbit_params[4] = ""; // limit
  
                  $freqbit_timespan = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freqbit_object_type, $freqbit_action, $freqbit_params);

                  if (is_array($freqbit_timespan)){

                     for ($freqspncnt=0;$freqspncnt < count($freqbit_timespan);$freqspncnt++){
                         $timespan = $freqbit_timespan[$freqspncnt]['name'];
                         }

                     } // if

                  # Get Expected Count
                  $freqbit_object_type = "ConfigurationItems";
                  $freqbit_action = "select";
                  $freqbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='a19083b1-25bd-65be-76e8-52def587f20f' ";
                  $freqbit_params[1] = "id,contact_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                  $freqbit_params[2] = ""; // group;
                  $freqbit_params[3] = ""; // order;
                  $freqbit_params[4] = ""; // limit
  
                  $freqbit_expcnt = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freqbit_object_type, $freqbit_action, $freqbit_params);

                  if (is_array($freqbit_expcnt)){

                     for ($freqexpcnt=0;$freqexpcnt < count($freqbit_expcnt);$freqexpcnt++){
                         $expectedcnt = $freqbit_expcnt[$freqexpcnt]['name'];
                         }

                     } // if

                  # Get Current Count
                  $freqbit_object_type = "ConfigurationItems";
                  $freqbit_action = "select";
                  $freqbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='c3891c31-9198-476d-0a8a-52df0e00c722' ";
                  $freqbit_params[1] = "id,contact_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                  $freqbit_params[2] = ""; // group;
                  $freqbit_params[3] = ""; // order;
                  $freqbit_params[4] = ""; // limit
  
                  $freqbit_currcnt = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freqbit_object_type, $freqbit_action, $freqbit_params);

                  if (is_array($freqbit_currcnt)){

                     for ($freqcurrcnt=0;$freqcurrcnt < count($freqbit_currcnt);$freqcurrcnt++){
                         $currentcnt = $freqbit_currcnt[$freqcurrcnt]['name'];
                         }

                     } // if

                  $label = "Frequency Count Match [Current Timestamp: ".$timestamp."][Time-Span: ".$timespan."][Expected Count:".$expectedcnt."][Current Count:".$currentcnt."] for - "; //$strings["FilterTriggerNoMatchCatchAll"];

                  $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label."</B> ".$filter_trigger_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  $trigger_frequencycount_bits = TRUE;
                  $trigger_frequencycount_clone_id = $filterbit_id;

                 break; // Frequency Count Match

                } // switch

                } // if 

             } // for filterbits

         # End check for filtertriggers
         ##########################################
         # Check for create ticket

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == '1078abaa-0615-06ef-9826-52b0d6f32290'){
                $filter_createticket = $filterbits[$cntfb]['name'];
                $create_ticket = $funky_gear->yesno ($filter_createticket);
                $filter_createticket_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_createticket_returner[7];

                $label = $strings["FilterCreateTicket"];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$create_ticket."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";
 
                $createtick_bits = TRUE;
                $createtick_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for create ticket
         ##########################################
         # Check for create Activitiy

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == 'a686c273-cc87-9fc8-08f0-52c38fba62c1'){
                $filter_createactivity = $filterbits[$cntfb]['name'];
                $create_activity = $funky_gear->yesno ($filter_createactivity);
                $filter_createactivity_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_createactivity_returner[7];

                $label = $strings["FilterCreateActivity"];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$create_activity."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";
 
                $createact_bits = TRUE;
                $createact_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for create ticket
         ##########################################
         # Check for create email

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == '99490a5c-8f51-6652-a121-52bfac638c32'){
                $filter_createemail = $filterbits[$cntfb]['name'];
                $create_email = $funky_gear->yesno ($filter_createemail);
                $filter_createemail_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_createemail_returner[7];

                $label = $strings["FilterSendEmail"];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$create_email."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";
 
                $createemail_bits = TRUE;
                $createemail_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for create email
         ##########################################
         # Check for auto-reply email

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == '887f79ce-d835-772a-ef9a-52ce399970e4'){
                $filter_autoreply = $filterbits[$cntfb]['name'];
                $autoreply = $funky_gear->yesno ($filter_autoreply);
                $filter_autoreply_returner = $funky_gear->object_returner ("ConfigurationItems", $filterbit_id);
                $image_url = $filter_autoreply_returner[7];

                $label = $strings["FilterAutoReplyToSender"];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$autoreply."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";
 
                $autoreply_bits = TRUE;
                $autoreply_clone_id = $filterbit_id;

                } // if 

             } // for autoreply_bits

         # End check for create email
         ##########################################
         # Use Filtering Set to get Notification Templates

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == 'c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d'){
                $templ_id = $filterbits[$cntfb]['name']; // actual template ID
                $filter_templ_returner = $funky_gear->object_returner ("ConfigurationItems", $templ_id);
                $templ_name = $filter_templ_returner[0];
                $image_url = $filter_templ_returner[7];

                $label = $strings["EmailTemplate"];

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$templ_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $notify_bits = TRUE;
                $notify_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End get templ
         ##########################################
         # Check for Recipients: TO

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == 'be9692fa-5341-6934-7500-52ba77913179'){
                $recipient_to_id = $filterbits[$cntfb]['name'];
                $recipient_to_returner = $funky_gear->object_returner ("ConfigurationItems", $recipient_to_id);
                $recipient_to_name = $recipient_to_returner[0];
                $image_url = $recipient_to_returner[7];

                $label = $strings["EmailRecipients"]." [TO]";

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$recipient_to_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $to_bits = TRUE;
                $to_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for recipient_to_id
         ##########################################
         # Check for Recipients: CC

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){

                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == '45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0'){
                $recipient_cc_id = $filterbits[$cntfb]['name'];
                $recipient_cc_returner = $funky_gear->object_returner ("ConfigurationItems", $recipient_cc_id);
                $recipient_cc_name = $recipient_cc_returner[0];
                $image_url = $recipient_cc_returner[7];

                $label = $strings["EmailRecipients"]." [CC]";

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$recipient_cc_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $cc_bits = TRUE;
                $cc_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for recipient_cc_id
         ##########################################
         # Check for Recipients: BCC

         for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

             $filterbit_id = $filterbits[$cntfb]['id'];
             $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];
             $record_contact_id_c = $filterbits[$cntfb]['contact_id_c'];
             $record_account_id_c = $filterbits[$cntfb]['account_id_c'];

             $enabled_id = $filterbits[$cntfb]['enabled'];
             $enabled = $funky_gear->yesno ($enabled_id);

             if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                $edit = "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                }

             if ($auth == 3){
                $show_id = " | ID: ".$filterbit_id;
                } else {
                $show_id = "";
                }

             if ($filterbit_configurationitemtypes_id_c == '47e1b49f-4059-3d14-94c7-52ba7891d1b5'){
                $recipient_bcc_id = $filterbits[$cntfb]['name'];
                $recipient_bcc_returner = $funky_gear->object_returner ("ConfigurationItems", $recipient_bcc_id);
                $recipient_bcc_name = $recipient_bcc_returner[0];
                $image_url = $recipient_bcc_returner[7];

                $label = $strings["EmailRecipients"]." [BCC]";

                $filters .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$recipient_bcc_name."<BR>Enabled: ".$enabled."<BR>".$edit."<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filterbit_id."&valuetype=ConfigurationItems&sendiv=FILTER');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                $bcc_bits = TRUE;
                $bcc_clone_id = $filterbit_id;

                } // if 

             } // for filterbits

         # End check for recipient_bcc_id
         ##########################################
         # Space to add new Filter Bits

         } // is_array filterbits

      if ($cntfb - count($filterbits) == 0 || !is_array($filterbits)){

         // No more loops - check to see which bits need an add field
         $filters .= "<div style=\"".$divstyle_white."\">";

         if (!$server_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=6de9b547-7c78-9ff4-83ea-52a8dc7f33f1&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$server_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Infra Server: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$ip_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=ef1bdff1-4df1-1562-7bd9-52c04ed4dae7&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$ip_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Bulk Servers/IPs: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$sla_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=683bb5f7-e1c7-4796-8d23-52b0df65369f&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$sla_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Service SLA Request: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         #if (!$sender_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=97ea1d7a-3243-4df3-38f4-52a8dc5793b4&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$sender_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Sender: ".$strings["action_addnew"]."</B></font></a><BR>";
          #  }

         if (!$time_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=291f5d67-13af-1b11-7e39-52b9d60288dc&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$time_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Time Range: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$date_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=ecf521df-6ff1-aa5c-0069-52b9d605f284&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$date_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Date Range: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$day_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=bb105bd2-6d5d-e9b1-dc66-52ba021e1f63&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$day_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterDayRange"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$datetimeconcat_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=cc55a107-98ca-8261-9900-52ce36601cd0&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$datetimeconcat_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterDateTimeConcat"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$string_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$string_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>String: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$nonstring_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=afc56334-a00e-12d3-66ce-52d0f6cf46ec&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$nonstring_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Non-String: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$nonserverip_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=d3ce77c0-aa02-e4e3-8e67-52d1ef420dde&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$nonserverip_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Non-Server/IP List: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$frequency_count_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=a19083b1-25bd-65be-76e8-52def587f20f&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$frequencycount_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Frequency Count: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$frequency_currcount_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=c3891c31-9198-476d-0a8a-52df0e00c722&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$frequencycurrcount_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Frequency Current Count: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$frequency_timespan_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=278395e9-3127-dc1c-53ac-52def9c06c63&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$frequencytimespan_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Frequency Time-span: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$frequency_timestamp_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7a454f0d-3d12-7bc5-7607-52defc746103&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$frequencytimestamp_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Frequency Timestamp: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_Email_Only_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_Email_Only_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Email Only Match: ".$strings["action_addnew"]."</B></font></a><BR>";
            }
 
         if (!$trigger_Sender_Body_String_Match_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_Sender_Body_String_Match_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Sender Body String Match: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_Sender_Body_NonString_Match_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_Sender_Body_NonString_Match_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Subject & Body Non-String Match: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_Body_NonServerIP_Match_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_Body_NonServerIP_Match_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Body Non-ServerIP Match: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_Sender_Subject_Exact_String_Match_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_Sender_Subject_Exact_String_Match_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Sender and Subject Exact String Match: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_Sender_Subject_NotExact_String_Match_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_Sender_Subject_NotExact_String_Match_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Sender and Subject Not Exact String Match: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_String_Exactly_Matches_Subject_Only_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_String_Exactly_Matches_Subject_Only_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->String Exactly Matches Subject Only: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_MulitpleString_in_Body_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_MulitpleString_in_Body_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Multiple Strings in Body: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_MulitpleString_in_Body_ALL_Match_bits){

            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_MulitpleString_in_Body_ALL_Match_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Multiple Strings in Body (ALL must match): ".$strings["action_addnew"]."</B></font></a><BR>";

            }

         if (!$trigger_String_in_SubjectOrBody_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_String_in_SubjectOrBody_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->Strings in Subject or Body: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_String_in_Body_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_String_in_Body_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->String in Body: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_String_in_Subject_Only_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_String_in_Subject_Only_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->String in Subject Only: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_All_Strings_in_Subject_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_All_Strings_in_Subject_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->ALL Strings in Subject Only: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_nomatchcatchall_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_nomatchcatchall_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->".$strings["FilterTriggerNoMatchCatchAll"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_multiservercheck_bits){

            $strings["FilterTriggerMultipleServerCheck"] = "Multiple Servers Check";

            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_multiservercheck_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->".$strings["FilterTriggerMultipleServerCheck"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$trigger_frequencycount_bits){

            $strings["FilterTriggerFrequencyCountMatch"] = "Frequency Count Match";

            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$trigger_frequencycount_bits_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Trigger->".$strings["FilterTriggerFrequencyCountMatch"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$createtick_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=1078abaa-0615-06ef-9826-52b0d6f32290&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$createtick_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterCreateTicket"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$createact_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=a686c273-cc87-9fc8-08f0-52c38fba62c1&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$createact_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterCreateActivity"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$createemail_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=99490a5c-8f51-6652-a121-52bfac638c32&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$createemail_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterSendEmail"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$autoreply_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=887f79ce-d835-772a-ef9a-52ce399970e4&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$autoreply_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["FilterAutoReplyToSender"].": ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$notify_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$notify_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Template: ".$strings["action_addnew"]."</B></font></a> -> <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=78b22b7d-48c5-737c-ffb6-52b8ded3345e&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["EmailFilterTemplate"]."</B></font></a> -> <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=f38d40a9-384c-274d-a30c-528be2b71049&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." Ticketing ID</B></font></a><BR>";
            }

         if (!$to_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=be9692fa-5341-6934-7500-52ba77913179&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$to_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>TO Recipients: ".$strings["action_addnew"]."</B></font></a> -> <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=cf3271fc-f361-22c8-0212-52b998d102ac&valuetype=ConfigurationItemTypes&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>TO Recipient List: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$cc_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$cc_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>CC Recipients: ".$strings["action_addnew"]."</B></font></a> -> <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=4203105b-79b1-8330-b136-52b9985ddcf1&valuetype=ConfigurationItemTypes&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>CC Recipient List: ".$strings["action_addnew"]."</B></font></a><BR>";
            }

         if (!$bcc_bits){
            $filters .= "<a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=47e1b49f-4059-3d14-94c7-52ba7891d1b5&valuetype=ConfigurationItemTypes&sendiv=FILTER&clonevaluetype=ConfigurationItems&clonevalue=".$bcc_clone_id."&parent_ci=".$filter_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>BCC Recipients: ".$strings["action_addnew"]."</B></font></a> -> <a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=c2bc3b5f-bfdd-a0ef-e399-52b998a94a28&valuetype=ConfigurationItemTypes&sendiv=FILTER');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>BCC Recipient List: ".$strings["action_addnew"]."</B></font></a>";
            }

         $filters .= "</div>";

         } // at end of filterbit trip

      # End filter presentation
      ########################################

      echo $filters;
    
     break;
     case 'add':
     case 'edit':
     case 'view':

      $content = "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=images/icons/plus.gif width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\">
<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=d2313332-261a-cfe2-4fbe-528f0a6bb9a1&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["EmailFilterSet"]."</B></font></a><BR>
<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=83a83279-9e48-0bfe-3ca0-52b8d8300cc2&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["EmailFilterTrigger"]."</B></font></a><BR>
<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=97ea1d7a-3243-4df3-38f4-52a8dc5793b4&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["EmailFilterSender"]."</B></font></a><BR>
<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["EmailFilterString"]."</B></font></a><BR>
<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=78b22b7d-48c5-737c-ffb6-52b8ded3345e&valuetype=ConfigurationItemTypes');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["EmailFilterTemplate"]."</B></font></a><BR>
</div></div>";

//      echo $content;


      $tblcnt = 0;

      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_set'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Set"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='d2313332-261a-cfe2-4fbe-528f0a6bb9a1' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_set; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_set; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_set';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_set; //$field_value;

      if ($action == 'add'){

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_name"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Name"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '60'; // length
      $tablefields[$tblcnt][7] = '0'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_name"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_name; //$field_value;   

//dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_daterange"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Date Range (2013-12-25_2013-12-29)"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '30'; // length
      $tablefields[$tblcnt][7] = '0'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_daterange"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_daterange; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_dayrange"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Day Range (Friday_Monday)"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '30'; // length
      $tablefields[$tblcnt][7] = '0'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_dayrange"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_dayrange; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_timerange"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Time Range (15:00-09:00)"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '30'; // length
      $tablefields[$tblcnt][7] = '0'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_timerange"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_timerange; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_create_ticket"; // Field Name
      $tablefields[$tblcnt][1] = "Create Filter Ticket?"; // Full Name
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
      $tablefields[$tblcnt][20] = "filter_create_ticket"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_create_ticket; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_string"; // Field Name
      $tablefields[$tblcnt][1] = "Filter String"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '60'; // length
      $tablefields[$tblcnt][7] = '0'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_string"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_string; //$field_value;  

      } else {

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_name"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Name"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_name; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_name; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_name"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_name; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_daterange"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Date Range (2013-12-25_2013-12-29)"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='ecf521df-6ff1-aa5c-0069-52b9d605f284' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_daterange; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_daterange; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_daterange"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_daterange; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_dayrange"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Day Range (Friday_Monday)"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='bb105bd2-6d5d-e9b1-dc66-52ba021e1f63' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_dayrange; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_dayrange; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_dayrange"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_dayrange; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_timerange"; // Field Name
      $tablefields[$tblcnt][1] = "Filter Time Range (15:00-09:00)"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='291f5d67-13af-1b11-7e39-52b9d60288dc' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_timerange; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_timerange; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_timerange"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_timerange; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_create_ticket"; // Field Name
      $tablefields[$tblcnt][1] = "Create Filter Ticket?"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='1078abaa-0615-06ef-9826-52b0d6f32290' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_create_ticket; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_create_ticket; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_create_ticket"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_create_ticket; //$field_value;   

      $tblcnt++;

      $tablefields[$tblcnt][0] = "filter_string"; // Field Name
      $tablefields[$tblcnt][1] = "Filter String"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_create_ticket; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_create_ticket; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = "filter_string"; //$field_value_id;
      $tablefields[$tblcnt][21] = $filter_string; //$field_value;  

      } 

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_email_template'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Email Template"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='78b22b7d-48c5-737c-ffb6-52b8ded3345e' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_email_template; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_email_template; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_email_template';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_email_template; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_trigger'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Trigger"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='83a83279-9e48-0bfe-3ca0-52b8d8300cc2' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_trigger; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_trigger; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_trigger';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_trigger; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_recipients_to'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Recipients (TO)"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='cf3271fc-f361-22c8-0212-52b998d102ac' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_recipients_to; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_recipients_to; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_recipients_to';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_recipients_to; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_recipients_cc'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Recipients (CC)"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='4203105b-79b1-8330-b136-52b9985ddcf1' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_recipients_cc; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_recipients_cc; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_recipients_cc';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_recipients_cc; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_recipients_bcc'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Recipients (BCC)"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='c2bc3b5f-bfdd-a0ef-e399-52b998a94a28' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_recipients_bcc; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_recipients_bcc; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_recipients_bcc';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_recipients_bcc; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_server'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Server"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='6de9b547-7c78-9ff4-83ea-52a8dc7f33f1' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_server; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_server; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_server';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_server; //$field_value;

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'filter_service_sla_request'; // Field Name
      $tablefields[$tblcnt][1] = "Filter Service SLA Request"; // Full Name
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
      $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='683bb5f7-e1c7-4796-8d23-52b0df65369f' && account_id_c='".$account_id_c."' && sclm_configurationitems_id_c='".$val."' ";
      $tablefields[$tblcnt][9][5] = $filter_service_sla_request; // Current Value
      $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
      $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
      $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
      $tablefields[$tblcnt][9][9] = $filter_service_sla_request; // Current Value
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][20] = 'filter_service_sla_request';//$field_value_id;
      $tablefields[$tblcnt][21] = $filter_service_sla_request; //$field_value;

      $admin = 1;

      $valpack = "";
      $valpack[0] = $do;
      $valpack[1] = "add";
      $valpack[2] = $valtype;
      $valpack[3] = $tablefields;
      $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
      $valpack[5] = ""; // provide add new button

      // Build parent layer
      $zaform = "";
      $zaform = $funky_gear->form_presentation($valpack);

      echo $zaform;

     break; // end portal set
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
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }


     break; // end portal set

    } // end vartype switch for process action

   break; // EmailFilteringSet

   # Set End: EmailFilteringSet
   ###############################
   # Set: InfrastructureMaintenance

   case 'InfrastructureMaintenance':

    function check_servers ($serv_params){

     global $lingo,$divstyle_white,$divstyle_blue,$divstyle_orange,$divstyle_grey,$strings,$crm_api_user, $crm_api_pass, $crm_wsdl_url,$funky_gear,$sess_account_id,$sess_contact_id;

     #$lingoname = "name_ja";
     $lingoname = "name_".$lingo;

     $server_id = $serv_params[0];
     $server_name = $serv_params[1];
     $server_type = $serv_params[2];

     ##########################################
     # Get server-related switches

     $subicondivwidth = "26";
     $subiconheight = "3";
     $subrowdivwidth = "80%";

     $serverbit_object_type = "ConfigurationItems";
     $serverbit_action = "select";
     // parent CI will be the registered server (also a CI) - not the filter as we may use this filter for other purposes
     // The type is Live Status 1/0
     $serverbit_type_id = '423752fe-a632-9b4d-8c3b-52ccc968fe59';
     $serverbit_params[0] = " sclm_configurationitems_id_c='".$server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
     $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
     $serverbit_params[2] = ""; // group;
     $serverbit_params[3] = ""; // order;
     $serverbit_params[4] = ""; // limit
  
     $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

     $label = $strings["CI_ServerStatus"];

     $addserver = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=INFRA&parent_ci=".$server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$server_name.": ".$strings["action_addnew"]."</B></font></a>";

     if (is_array($serverbits)){

        for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
            $server_status_id = $serverbits[$srvbitcnt]['id'];
            $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
            $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
            $server_status = $serverbits[$srvbitcnt]['name']; // 1/0
                      
            $edit = "";
            $show_id = "";

            if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
               $edit = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_status_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($auth == 3){
               $show_id = " | ID: ".$server_status_id;
               } else {
               $show_id = "";
               }

            switch ($server_status){

             case '':
              $server_status_show = "NA";
              $thisdivstyle_orange = $divstyle_white;
             break;
             case '1':
              $server_status_show = $strings["CI_ServerStatusOnline"];
              $addserver = "";
              $thisdivstyle_orange = $divstyle_blue;
             break;
             case '0':
              $server_status_show = $strings["CI_ServerStatusOffline"];
              $addserver = "";
              $thisdivstyle_orange = $divstyle_orange;
             break;

            } // switch

            $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
            $image_url = $filterimage_returner[7];

            $servers .= "<div style=\"".$thisdivstyle_orange."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_status_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addserver."</div></div>";

            } // for serverbits

        } else {// if array

        $server_status_show = "NA";
        $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR> ".$addserver."</div></div>";

        } // else array

     # End get server-related switches
     ##########################################
     # Get server-related switches

     $subicondivwidth = "26";
     $subiconheight = "3";
     $subrowdivwidth = "80%";

     $serverbit_object_type = "ConfigurationItems";
     $serverbit_action = "select";
     // parent CI will be the registered server (also a CI) - not the filter as we may use this filter for other purposes
     // The type is Live Status 1/0
     $serverbit_type_id = '2864a518-19f4-ddfa-366e-52ccd012c28b';
     $serverbit_params[0] = " sclm_configurationitems_id_c='".$server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
     $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
     $serverbit_params[2] = ""; // group;
     $serverbit_params[3] = ""; // order;
     $serverbit_params[4] = ""; // limit
  
     $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

     $label = $strings["CI_ServerStatusMaintenance"];

     $addservermaintenance = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=INFRA&parent_ci=".$server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

     if (is_array($serverbits)){

        for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
            $server_maintenance_status_id = $serverbits[$srvbitcnt]['id'];
            $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
            $server_maintenance_status = $serverbits[$srvbitcnt]['name']; // 1/0
                      
            $edit = "";
            $show_id = "";

            if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
               $edit = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_maintenance_status_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($auth == 3){
               $show_id = " | ID: ".$server_maintenance_status_id;
               } else {
               $show_id = "";
               }

            switch ($server_maintenance_status){

             case '':
              $server_status_show = "NA";
              $thisdivstyle_orange = $divstyle_white;
              break;
             case '1':
              $server_status_show = "ON";
              $addservermaintenance = "";
              $thisdivstyle_orange = $divstyle_orange;
              $view = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_status_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id;
             break;
             case '0':
              $server_status_show = "OFF";
              $addservermaintenance = "";
              $thisdivstyle_orange = $divstyle_blue;
              $view = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_status_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id;
             break;

            } // switch

            $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
            $image_url = $filterimage_returner[7];

            $servers .= "<div style=\"".$thisdivstyle_orange."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR>".$edit.$view.$addservermaintenance."</div></div>";

            } // for serverbits

        } else {// if array

        $server_status_show = "NA";
        $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR> ".$addservermaintenance."</div></div>";

        } // else array

                # Maintenance Window DateTime Start
                $serverbit_type_id = '787ab970-8f2a-efed-3aca-52ecd566b16b';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit

                $serverbits = "";
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = "Maintenance Window Start DateTime"; //$strings["CI_ServerStatusMaintenance"];

                $addservermaintenance = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=INFRA&parent_ci=".$server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_maintenance_start_datetime_id = $serverbits[$srvbitcnt]['id'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $server_maintenance_start_datetime = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_maintenance_start_datetime_id."&valuetype=".$valtype."&sendiv=INFRA');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_maintenance_start_datetime_id;
                          } else {
                          $show_id = "";
                          }

                          if ($server_maintenance_start_datetime){
                             $start_datetime_show = $server_maintenance_start_datetime;
                             $thisdivstyle = $divstyle_orange;
                             $addservermaintenance = "";
                             } else {
                             $start_datetime_show = "NA";
                             $thisdivstyle = $divstyle_white;
                             } 

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];

                       $servers .= "<div style=\"".$thisdivstyle."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$start_datetime_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_start_datetime_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addservermaintenance."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B>NA<BR> ".$addservermaintenance."</div></div>";

                   } // else array

                # Maintenance Window DateTime End
                $serverbit_type_id = 'b38181b6-eb59-0bc3-bad3-52ecd65163f5';
                $serverbit_params[0] = " sclm_configurationitems_id_c='".$server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                $serverbit_params[2] = ""; // group;
                $serverbit_params[3] = ""; // order;
                $serverbit_params[4] = ""; // limit

                $serverbits = "";
                $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                $label = "Maintenance Window End DateTime"; //$strings["CI_ServerStatusMaintenance"];

                $addservermaintenance = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=INFRA&parent_ci=".$server_id."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

                if (is_array($serverbits)){

                   for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                       $server_maintenance_end_datetime_id = $serverbits[$srvbitcnt]['id'];
                       $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
                       $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                       $server_maintenance_end_datetime = $serverbits[$srvbitcnt]['name']; // 1/0
                      
                       $edit = "";
                       $show_id = "";

                       if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                          $edit = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_maintenance_end_datetime_id."&valuetype=".$valtype."&sendiv=INFRA');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                          }

                       if ($auth == 3){
                          $show_id = " | ID: ".$server_maintenance_end_datetime_id;
                          } else {
                          $show_id = "";
                          }

                          if ($server_maintenance_end_datetime){
                             $end_datetime_show = $server_maintenance_end_datetime;
                             $thisdivstyle = $divstyle_orange;
                             $addservermaintenance = "";
                             } else {
                             $end_datetime_show = "NA";
                             $thisdivstyle = $divstyle_white;
                             } 

                       $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
                       $image_url = $filterimage_returner[7];

                       $servers .= "<div style=\"".$thisdivstyle."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$end_datetime_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_maintenance_end_datetime_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addservermaintenance."</div></div>";

                       } // for serverbits

                   } else {// if array

                   $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B>NA<BR> ".$addservermaintenance."</div></div>";

                   } // else array


     # End get server-related switches
     ##########################################
     # Get server-related back-up details
     # Back-up Day: 67a6bcaf-4e45-42d6-79da-52d4df16784c
     # Back-up End Time: 913315fd-34d5-036e-0c52-52d4d91550d9
     # Back-up Job Name: 8802ae00-1abe-9819-558f-52d4d74b6ca2
     # Back-up Start Time: 4d440215-68e1-efe3-158e-52d4d808e6b1
     # Back-up Status: 530ae095-b3e7-c9fe-61fb-52d5aee0a272
     # Back-up Status Keyword(s): 56291976-233c-912a-b10e-52d4dfc8357c
     # Execution Server: 91694cfa-3f33-6505-d894-52d4d84722c0
     # Target Server: 734f02a8-5821-86f1-3229-52d4d80696ac

     $subicondivwidth = "26";
     $subiconheight = "3";
     $subrowdivwidth = "80%";

     $serverbit_object_type = "ConfigurationItems";
     $serverbit_action = "select";
     # parent CI will be the registered server (also a CI) - not the filter as we may use this filter for other purposes
     # The type is Maintenance 1/0
     $serverbit_type_id = '530ae095-b3e7-c9fe-61fb-52d5aee0a272';
     $serverbit_params[0] = " sclm_configurationitems_id_c='".$server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
     $serverbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
     $serverbit_params[2] = ""; // group;
     $serverbit_params[3] = ""; // order;
     $serverbit_params[4] = ""; // limit
  
     $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

     $label = $strings["CI_ServerStatusBackup"];

     $addserverbackup = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$serverbit_type_id."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$filter_id."&sendiv=INFRA&parent_ci=".$server_id."&partype=dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a>";

     if (is_array($serverbits)){

        for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
            $server_backup_status_id = $serverbits[$srvbitcnt]['id'];
            $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
            $record_account_id_c = $serverbits[$srvbitcnt]['account_id_c'];
            $server_backup_status = $serverbits[$srvbitcnt]['name']; // 1/0
                      
            $edit = "";
            $show_id = "";

            if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
               $edit = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$server_backup_status_id."&valuetype=".$valtype."&sendiv=INFRA');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($auth == 3){
               $show_id = " | ID: ".$server_backup_status_id;
               } else {
               $show_id = "";
               }

            switch ($server_backup_status){

             case '':
              $server_status_show = "NA";
              $thisdivstyle_orange = $divstyle_grey;
             break;
             case '1':
              $server_status_show = "OK";
              $addserverbackup = "";
              $thisdivstyle_orange = $divstyle_blue;
             break;
             case '0':
              $server_status_show = "NG";
              $addserverbackup = "";
              $thisdivstyle_orange = $divstyle_orange;
             break;

            } // switch

            $filterimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $serverbit_type_id);
            $image_url = $filterimage_returner[7];

            $servers .= "<div style=\"".$thisdivstyle_orange."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$subiconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$subrowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR>".$edit." <a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$server_backup_status_id."&valuetype=ConfigurationItems&sendiv=INFRA');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." ".$addserverbackup."</div></div>";

            } // for serverbits

        } else {// if array

          $server_status_show = "NA";
          $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$subiconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server_status_show."<BR> ".$addserverbackup."</div></div>";

        } // else array

      # End get server-related switches
      ##########################################

    return $servers;

    } // end function check_servers

    switch ($action){

     case 'list':

      if ($sess_account_id != NULL){

         # Check all servers in system
         $maintsrv_object_type = "ConfigurationItems";
         $maintsrv_action = "select";
         $maintsrv_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && (sclm_configurationitemtypes_id_c='7835c8b9-f7d5-5d0a-be10-52ad9c866856' || sclm_configurationitemtypes_id_c='34647ae4-154c-68f3-74ea-52b0c8abc3dc' || sclm_configurationitemtypes_id_c='7ef914c8-09f8-82c9-d4b9-52c29793ef85' || sclm_configurationitemtypes_id_c='3f6d75b7-c0f5-1739-c66d-52c2989ce02d' || sclm_configurationitemtypes_id_c='49ff2505-7d08-cb5c-64e8-52e0e490c0dc' || sclm_configurationitemtypes_id_c='388b56dc-771e-b743-e63b-541fc6070ab9' || sclm_configurationitemtypes_id_c='8c8a3231-1d86-0117-4680-541fcbab4f6a') ";
         $maintsrv_params[1] = "id,name,sclm_configurationitemtypes_id_c,description"; // select array
         $maintsrv_params[2] = ""; // group;
         $maintsrv_params[3] = " name ASC "; // order;
         $maintsrv_params[4] = ""; // limit
  
         $maintservers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $maintsrv_object_type, $maintsrv_action, $maintsrv_params);

         if (is_array($maintservers)){

            for ($cnt=0;$cnt < count($maintservers);$cnt++){

                $id = $maintservers[$cnt]['id'];
                $server_name = $maintservers[$cnt]['name'];
                $type = $maintservers[$cnt]['sclm_configurationitemtypes_id_c'];

                ########################################
                # Servers

                $icondivwidth = "16";
                $iconheight = "3";
                $rowdivwidth = "90%";

                $label = $strings["CI_Server"];

                $server = "";
                $server = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=view&value=".$id."&valuetype=InfrastructureMaintenance');return false\"><font size=3 color=BLUE><B>".$server_name."</B></font></a>";

                $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=images/icons/Server-Icon-53x53.png width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server."<BR></div></div>";

                } // for

            echo "<div style=\"".$divstyle_blue."\" name='INFRA' id='INFRA'></div>";
            echo $servers;

            } // is array

         } // if acc

     break;
     case 'view':

      if ($val != NULL){

         # Check all servers in system
         $maintsrv_object_type = "ConfigurationItems";
         $maintsrv_action = "select";
         $maintsrv_params[0] = " id='".$val."' ";
         $maintsrv_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
         $maintsrv_params[2] = ""; // group;
         $maintsrv_params[3] = ""; // order;
         $maintsrv_params[4] = ""; // limit
  
         $maintservers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $maintsrv_object_type, $maintsrv_action, $maintsrv_params);

         if (is_array($maintservers)){

            for ($cnt=0;$cnt < count($maintservers);$cnt++){

                $id = $maintservers[$cnt]['id'];
                $server_name = $maintservers[$cnt]['name'];
                $type = $maintservers[$cnt]['sclm_configurationitemtypes_id_c'];

                }
            }

         $serv_params[0] = $val;
         $serv_params[1] = $server_name;
         $serv_params[2] = $type;

         echo check_servers ($serv_params);

         }

     break;

    } // action

   break; // InfrastructureMaintenance

   # Set End: InfrastructureMaintenance
   ###############################
   # Set: Infrastructure

   case 'Infrastructure':

    // List up DCs from AccountCIs and provide form to add more

    ###################################################
    # Relationships

    echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["InfraConfiguration"]."</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<center><img src=images/icons/defender.png width=48></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=view&value=".$account_id_c."&valuetype=Infrastructure');return false\"><font size=4><B>".$strings["InfraConfiguration"]."</B></font></a></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    function package_ci ($cipack){

     global $strings,$BodyDIV,$divstyle_white,$portalcode,$auth,$lingo,$account_id_c,$standard_statuses_closed,$crm_api_user,$crm_api_pass,$crm_wsdl_url;

     $citype = $cipack[0];
     $cicnt = $cipack[1];
     $parci = $cipack[2];
//     $cis = $cipack[3];

     $ci_object_type = 'ConfigurationItems';
     $ci_action = "select";

     if ($auth < 3){

//        $object_return_params[0] = " sclm_configurationitemtypes_id_c='".$citype."' && (account_id_c='".$account_id_c."'  || cmn_statuses_id_c != '".$standard_statuses_closed."' )";

        $object_return_params[0] = " sclm_configurationitemtypes_id_c='".$citype."' && account_id_c='".$account_id_c."' ";

        } else {
 
        $object_return_params[0] = " sclm_configurationitemtypes_id_c='".$citype."' ";

        } 

     if ($parci != NULL){
        $object_return_params[0] .= " && sclm_configurationitems_id_c='".$parci."' ";
        }

     $lingoname = "name_".$lingo;

     $ci_params[0] = $object_return_params[0];
     $ci_params[1] = "id,name,$lingoname,sclm_configurationitemtypes_id_c,date_entered,image_url"; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
     $ci_params[4] = ""; // limit
  
     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($ci_items)){

        $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

        for ($cnt=0;$cnt < count($ci_items);$cnt++){

            $id = $ci_items[$cnt]['id'];
            $name = $ci_items[$cnt]['name'];
            $date_entered = $ci_items[$cnt]['date_entered'];
/*
            $date_modified = $ci_items[$cnt]['date_modified'];
            $modified_user_id = $ci_items[$cnt]['modified_user_id'];
            $created_by = $ci_items[$cnt]['created_by'];
            $description = $ci_items[$cnt]['description'];
            $deleted = $ci_items[$cnt]['deleted'];
            $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
            $child_id = $ci_items[$cnt]['child_id'];
            $child_name = $ci_items[$cnt]['child_name'];	
            $ci_account_id = $ci_items[$cnt]['account_id'];
            $ci_contact_id = $ci_items[$cnt]['contact_id'];
*/
            $ci_type_id = $ci_items[$cnt]['ci_type_id'];
            $ci_type_name = $ci_items[$cnt]['ci_type_name'];
            $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
/*
            $project_id_c = $ci_items[$cnt]['project_id_c'];
            $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
            $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
            $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
*/
            $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
            $parent_ci_name = $ci_items[$cnt]['parent_ci_name'];
            $image_url = $ci_items[$cnt]['image_url'];

            if ($image_url != NULL){
               $image = "<img src=".$image_url." width=16>";
               } else {
               $image = "";
               } 

//           $parent_service_type = $ci_items[$cnt]['parent_service_type'];
//           $service_type = $ci_items[$cnt]['service_type'];
            if ($auth == 3 || ($sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c)){
               $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($ci_items[$cnt][$lingoname] != NULL){
               $name = $ci_items[$cnt][$lingoname];
               }

            if ($auth == 3){
               $show_id = " | ID: ".$id;
               } else {
               $show_id = "";
               }

            $ci_image_width = $cicnt*5;
            $ci_width = 100-$ci_image_width;
            $ci_image = "<img src=images/blank.gif width=$ci_image_width height=5>";
            $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$ci_image_width."%;float:left;padding-top:5;\">".$ci_image."</div><div style=\"width:".$ci_width."%;float:left;padding-top:3;\">".$image." ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemTypes&action=view&value=".$ci_type_id."&valuetype=ConfigurationItemTypes');return false\"> [".$ci_type_name."]</a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$id."&valuetype=ConfigurationItems');return false\"><B>".$name."</B></a>".$show_id."</div></div>";

            $this_ci_pack[0] = "";

            switch ($citype){

             case '7d2f42a9-9de7-224d-712c-52ad30da69fd': // datacenter
              $this_ci_pack[0] = '9a2ee7f9-67b6-9f72-c133-52ad302dfdc0'; // Floors
              $this_ci_pack[1] = 1;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
             case '9a2ee7f9-67b6-9f72-c133-52ad302dfdc0': // DC Floor (ID, Name) 
              $this_ci_pack[0] = '63fef2c9-9acf-fbd1-56c7-52ad300f480f'; // Racks
              $this_ci_pack[1] = 2;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
             case '63fef2c9-9acf-fbd1-56c7-52ad300f480f': // DC Floor (ID, Name) 
              $this_ci_pack[0] = '9065cbc6-177f-9848-1ada-52ad30451c3f'; // Systems
              $this_ci_pack[1] = 3;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             case '63fef2c9-9acf-fbd1-56c7-52ad300f480f': // Racks
              $this_ci_pack[0] = 'de350370-d2d3-e84b-13c1-52ad5f2fb2ab'; // Rack Units
              $this_ci_pack[1] = 4;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             case 'de350370-d2d3-e84b-13c1-52ad5f2fb2ab': // Rack Units
              $this_ci_pack[0] = 'cb455d67-8335-df81-1d3b-52ad67c4977e'; // Purpose
              $this_ci_pack[1] = 5;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = '94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4'; // Chasis
              $this_ci_pack[1] = 5;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = '77c9dccf-a0a7-05fc-a05f-52ad62515fc7'; // Server
              $this_ci_pack[1] = 5;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
             case '94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4': // Chasis
              $this_ci_pack[0] = '617ab884-61b5-d7a1-1de7-52ad61df4cae'; // Blades
              $this_ci_pack[1] = 7;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
             case '617ab884-61b5-d7a1-1de7-52ad61df4cae': // Blade 
              $this_ci_pack[0] = '34647ae4-154c-68f3-74ea-52b0c8abc3dc'; // Blade Hostname
              $this_ci_pack[1] = 8;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = '597942d3-31f0-ff12-7d76-529306e7168d'; // Service ID
              $this_ci_pack[1] = 8;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = 'b9e770ab-6ddc-416a-0d1f-5293063e8b42'; // Serial Number
              $this_ci_pack[1] = 8;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = '52784a42-d442-9e71-8d09-529304d1d518'; // Product Components
              $this_ci_pack[1] = 8;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
             case '77c9dccf-a0a7-05fc-a05f-52ad62515fc7': // Server
              $this_ci_pack[0] = '7835c8b9-f7d5-5d0a-be10-52ad9c866856'; // Host
              $this_ci_pack[1] = 6;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = '597942d3-31f0-ff12-7d76-529306e7168d'; // Service ID
              $this_ci_pack[1] = 6;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = 'b9e770ab-6ddc-416a-0d1f-5293063e8b42'; // Serial Number
              $this_ci_pack[1] = 6;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
              $this_ci_pack[0] = '52784a42-d442-9e71-8d09-529304d1d518'; // Product Components
              $this_ci_pack[1] = 6;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
             case '52784a42-d442-9e71-8d09-529304d1d518': // Product Components
              $this_ci_pack[0] = 'b000fa33-faa3-a872-4c4f-52ad9fa925c1'; // Model
              $this_ci_pack[1] = 9;
              $this_ci_pack[2] = $id;
              $cis .= package_ci ($this_ci_pack);
             break;
            }

            } // end for

        } else { // if

/*
         $ci_image_width = $cicnt*5;
         $ci_width = 100-$ci_image_width;
         $cis .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$ci_image_width."%;float:left;padding-top:5;\">".$ci_image."</div><div style=\"width:".$ci_width."%;float:left;padding-top:3;\">".$addtype."</div></div>";
*/

        }

     return $cis;

     } // end package ci

    switch ($action){

     case 'add':

      $tblcnt = 0;

      $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
      $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
      $tablefields[$tblcnt][1] = "contact_id_c"; // Full Name
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


     break;
     case '':
     case 'edit':
     case 'view':

     $citype = $cipack[0];

     $datacenter = '7d2f42a9-9de7-224d-712c-52ad30da69fd';
     $ci_pack[0] = $datacenter;
     $ci_pack[1] = 0;
     $ci_package = package_ci ($ci_pack);

     echo $ci_package;


     break; // end portal set
     case 'process':

     break; // end portal set

    } // end vartype switch for process action


/*
    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["DataCenters"]; // container_title
    $container_params[4] = 'DataCenters'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;
  
    $datacenter = '7d2f42a9-9de7-224d-712c-52ad30da69fd';
  
    $this->funkydone ($_POST,$lingo,'ConfigurationItemItems','list',$datacenter,'ConfigurationItemTypes',$bodywidth);

    // Find if any DCs are selected - then look for floors
    
    $container_params[3] = $strings["DCFloors"]; // container_title
    $container_params[4] = 'DCFloors'; // container_label

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_middle;
  
    $dcfloors = '9a2ee7f9-67b6-9f72-c133-52ad302dfdc0';
  
    $this->funkydone ($_POST,$lingo,'ConfigurationItemItems','list',$dcfloors,'ConfigurationItemTypes',$bodywidth);

    echo $container_bottom;

    
*/
    # AccountRelationships
    ###################################################
/*
    $ci_object_type = "ConfigurationItemTypes";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && account_id_c='".$account_id_c."' ";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);


    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      

     break; // end portal set
     case 'process':

      $process_type = $_POST['process_type'];

      switch ($process_type){

       case 'DC':

      if ($_POST['portal_email_server_smtp_port']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_server_smtp_port_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_server_smtp_port']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_server_smtp_port']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '6fb14f09-71c7-ce07-c746-5291aa2c39c4');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }
        

       break; // DC

      } // $process_type
 
     break; // end portal set

    } // end vartype switch for process action
*/

   break; // Infrastructure
   # Set End: Infrastructure
   ###############################
   # Set: Quick CI Item Updates
   case 'QuickCIUpdates':

    # action = update

    $ci = $_POST['ci'];
    $cit = $_POST['cit'];
    $ci_val = $_POST['ci_val'];
    $ci_txt = $_POST['ci_txt'];

    # Get the CI's CIT and the type of CIT Data value (dropdown, checkbox)

    $cit_object_type = "ConfigurationItemTypes";
    $cit_action = "select";
    $cit_params[0] = " id='".$cit."' ";
    $cit_params[1] = "ci_data_type"; // select array
    $cit_params[2] = ""; // group;
    $cit_params[3] = ""; // order;
    $cit_params[4] = ""; // limit
  
    $cit_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cit_object_type, $cit_action, $cit_params);

      if (is_array($cit_items)){

         for ($citcnt=0;$citcnt < count($cit_items);$citcnt++){

             $ci_data_type = $cit_items[$citcnt]['ci_data_type'];

             } # end for

         } // if array

    switch ($ci_data_type){

     case '': # default
     case '45b5e951-e65b-9ef4-075e-51fdc2f00ace': # Checkbox
     case 'de5db7f0-b87f-3dfd-637f-51fdc240f5fe': # Yes/No
      $data_type = "checkbox";
     break;
     case 'dbdecd86-53f2-e852-e02c-51d04ea175bb': # Data Set
     case '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca': # Dropdown
     case '2f5dc8c1-9898-5ffd-1b4c-51c2f631b449': # Text Area
     case 'a46886c9-a870-ba85-c747-51c2f6be922f': # Text Box
      $data_type = "checkbox";
     break;

    } # end switch

/*
    $ci_object_type = "ConfigurationItems";
    $ci_action = "select";
    $ci_params[0] = " account_id_c='".$sess_account_id."' && sclm_configurationitemtypes_id_c='".$sclm_configurationitemtypes_id_c."' ";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

      if (is_array($ci_items)){
*/
       # Exists already - update, then present

    $process_object_type = "ConfigurationItems";
    $process_action = "update";

    $process_params = array();  
    $process_params[] = array('name'=>'id','value' => $ci);
    $process_params[] = array('name'=>'name','value' => $ci_val);
    $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $cit);
    $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
    $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
    $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);

    #var_dump ($process_params);

    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($ci == NULL && $result != NULL){
       $ci = $result['id'];
       }

    # Provide new button
    $params[0] = $data_type;
    $params[1] = $cit;
    $params[2] = $ci_val;
    $params[3] = $do;
    $params[4] = $ci;
    $params[5] = 'QuickCIUpdates';
    $params[6] = $ci_txt;

    $new_ci = quick_ci_updates ($params);

    echo $new_ci;

/*
    for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
        $id = $ci_items[$cnt]['id'];
        $name = $ci_items[$cnt]['name'];
        $date_entered = $ci_items[$cnt]['date_entered'];

             if ($ci_val == 1){
                

             } # End for

         } else {
         # Not an array - value does not yet exist

         } # End if not exists
*/
   break; // QuickCIUpdates

   # Set End: QuickCIUpdates
   ###############################
   # Character Strengths

   case 'CharacterStrengths':

      switch ($action){

       case 'list':
       case 'listvals':

        $char_strength_cit = "7c726fb7-2947-6d40-734a-54ea110fd7e9"; # Character Strengths

        $ci_object_type = "ConfigurationItemTypes";
        $ci_action = "select";
        $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$char_strength_cit."' ";
        $ci_params[1] = "id,name,image_url"; // select array
        $ci_params[2] = ""; // group;
        $ci_params[3] = "name ASC"; // order;
        $ci_params[4] = ""; // limit
  
        $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

        if (is_array($ci_items)){

           $layer_one = "";

           for ($cnt=0;$cnt < count($ci_items);$cnt++){

               # Get the first layer 
               $ci_charstrengths_id = $ci_items[$cnt]['id'];
               $ci_charstrengths_title = $ci_items[$cnt]['name'];
               $ci_image_url = $ci_items[$cnt]['image_url'];

               #$layer_one .= $ci_charstrengths_title."<BR>";

               $lo_object_type = "ConfigurationItemTypes";
               $lo_action = "select";
               $lo_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$ci_charstrengths_id."' ";
               $lo_params[1] = "id,name,description,image_url"; // select array
               $lo_params[2] = ""; // group;
               $lo_params[3] = "name ASC"; // order;
               $lo_params[4] = ""; // limit
         
               $lo_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lo_object_type, $lo_action, $lo_params);

               $charstrengths_totalvalue = "";

               if (is_array($lo_items)){

                  $layer_two = "";

                  for ($locnt=0;$locnt < count($lo_items);$locnt++){

                      # Get the second layer 
                      $lo_charstrengths_id = $lo_items[$locnt]['id'];
                      $lo_charstrengths_title = $lo_items[$locnt]['name'];
                      $image_url = $lo_items[$locnt]['image_url'];

                      #$charstrengths_description = $ci_items[$cnt]['description'];
                      #$layer_two .= $lo_charstrengths_title."<BR>";

                      # Need to check any CI values here for the current user
                      $lt_object_type = "ConfigurationItems";
                      $lt_action = "select";
                      $lt_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$lo_charstrengths_id."' && contact_id_c='".$sess_contact_id."'";
                      $lt_params[1] = "id,name,description"; // select array
                      $lt_params[2] = ""; // group;
                      $lt_params[3] = "name ASC"; // order;
                      $lt_params[4] = ""; // limit
         
                      $lt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lt_object_type, $lt_action, $lt_params);

                      if (is_array($lt_items)){

                         $lt_charstrengths = "";

                         for ($ltcnt=0;$ltcnt < count($lt_items);$ltcnt++){
 
                             $charstrengths_id = $lt_items[$ltcnt]['id'];
                             $charstrengths_value = $lt_items[$ltcnt]['name'];
                             $charstrengths_totalvalue = $charstrengths_totalvalue+$charstrengths_value;

                             $lt_charstrengths = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$charstrengths_id."&valuetype=ConfigurationItemTypes&sendiv=lightform');return false\"><font color=red><B>[".$charstrengths_value."]</B></font></a> <font color=BLUE><B>".$lo_charstrengths_title."</B></font></div>";

                             $listedvals[$charstrengths_value] = $lt_charstrengths;

                             } # for users

                         } else { # is array users

                         $lt_charstrengths = "<div style=\"".$divstyle_white."\"> <a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$lo_charstrengths_id."&valuetype=ConfigurationItemTypes&sendiv=lightform');return false\"><font color=red><B>Add Value</B></font></a> <font color=BLUE><B>for ".$lo_charstrengths_title."</B></font></div>";

                         } 

                      $layer_two .= "<div style=\"".$divstyle_blue."\"> <img src=".$image_url." width=16> <B>".$lo_charstrengths_title."</B>".$lt_charstrengths."</div>";

                      } # for L2

                  } # is array L2

               $layer_one .= "<div style=\"".$divstyle_white."\"> <img src=".$ci_image_url." width=16> <B>".$ci_charstrengths_title." [Total Score:".$charstrengths_totalvalue."]</B>".$layer_two."</div>";

               $final_total = $final_total+$charstrengths_totalvalue;

               $parlistedvals[$charstrengths_totalvalue] = "<div style=\"".$divstyle_white."\"> <img src=".$ci_image_url." width=16> <B>".$ci_charstrengths_title." [Total Score:".$charstrengths_totalvalue."]</B></div>";

               } # for L1

           } # is array L1

       if ($action == 'listvals'){
          #rsort ($listedvals);
          ksort ($listedvals);
          ksort ($parlistedvals);
          #array_multisort($listedvals);
          #sort($listedvals, ksort($listedvals));

          foreach ($listedvals as $strengthval=>$stregthshow){
                  #echo "Key  $strengthval <BR>";
                  $show_eachlayers .= $stregthshow;
                  }

          foreach ($parlistedvals as $parstrengthval=>$parstregthshow){
                  #echo "Key  $strengthval <BR>";
                  $show_parlayers .= $parstregthshow;
                  }
          $show_layers = $show_parlayers.$show_eachlayers;
          } else {
          $show_layers = $layer_one;
          }

       echo "<div style=\"".$divstyle_white."\"> <B>Total VIA Score: ".$final_total."</B>".$show_layers;

       break; # manage

      } # switch

   break; # CharacterStrengths
   # Character Strengths
   ###############################
   # Event Permsissions
   case 'EventPermissions':


    # Personal Profile | ID: 70212896-f1ba-bc72-ae79-55d6707b8bc5
    # Gender | ID: 80568993-d830-f22b-430e-55d67137492f
    # Female | ID: ee874cc3-6fad-dced-4b52-55d672d639cb
    # Male | ID: d5aa8939-4cfa-4e8e-8aee-55d672e1ddbe
    # 

    if (!$sess_contact_id){
       break;
       }

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      # Hiroko's Timer | ID: 915e05bc-2a28-490e-fb53-5562b607702d
 
      #$cits = "(sclm_configurationitemtypes_id_c='71529bf3-01ce-1a56-6f8f-554fe9490b75' || sclm_configurationitemtypes_id_c='915e05bc-2a28-490e-fb53-5562b607702d')";

      $cits = "sclm_configurationitemtypes_id_c='71529bf3-01ce-1a56-6f8f-554fe9490b75'";


      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && contact_id_c='".$sess_contact_id."' && ".$cits." ";
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
             $this_assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

             if ($this_assigned_user != NULL){
                $assigned_user_id = $this_assigned_user;
                }

             # Use ci_data_type to send
             if ($ci_type_id == '71529bf3-01ce-1a56-6f8f-554fe9490b75'){ # Show My Well-being? 

                $cit_params = "";
                $cit_params[0] = "checkbox";
                $cit_params[1] = $ci_type_id;
                $cit_params[2] = $name;
                $cit_params[3] = "ConfigurationItemSets";
                $cit_params[4] = $id;
                $cit_params[5] = 'QuickCIUpdates';
                $cit_params[6] = 'Show my Well-being?';

                $show_my_wellbeing = quick_ci_updates ($cit_params);
   
                $preform .= "<div style=\"".$divstyle_white."\">".$show_my_wellbeing."</div>";

                } 
/*
                } elseif ($ci_type_id == '915e05bc-2a28-490e-fb53-5562b607702d'){ # Hiroko's Timer
   
                $cit_params = "";
                $cit_params[0] = "checkbox";
                $cit_params[1] = $ci_type_id;
                $cit_params[2] = $name;
                $cit_params[3] = $do;
                $cit_params[4] = $id;
                $cit_params[5] = 'QuickCIUpdates';
                $cit_params[6] = "Enable Hirokos Timer?";
   
                $enable_hirokos_timer = quick_ci_updates ($cit_params);

                if ($name == 1){
                   $hiroko_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=HirokosTimer&action=view&value=".$id."&valuetype=HirokosTimer&sendiv=".$BodyDIV."');return false\"><font color=#151B54><B>Hiroko's Timer Settings</B></font></a></div><P>";
                   }

                $preform .= "<div style=\"".$divstyle_white."\">".$enable_hirokos_timer.$hiroko_settings."</div>";

                }
  */ 

#                  } elseif ($ci_type_id == '1d0df382-a9a7-7af3-0ce0-55263163f34f'){ # Allow Well-being

             } # for

         } # is array

      if (!$show_my_wellbeing){

         $cit_params = "";
         $cit_params[0] = "checkbox";
         $cit_params[1] = '71529bf3-01ce-1a56-6f8f-554fe9490b75';
         $cit_params[2] = "0";
         $cit_params[3] = "ConfigurationItemSets";
         $cit_params[4] = "";
         $cit_params[5] = 'QuickCIUpdates';
         $cit_params[6] = 'Show my Well-being?';

         $show_my_wellbeing = quick_ci_updates ($cit_params);

         $preform .= "<div style=\"".$divstyle_white."\">".$show_my_wellbeing."</div>";

         }
/*
      if (!$enable_hirokos_timer){

         $cit_params = "";
         $cit_params[0] = "checkbox";
         $cit_params[1] = '915e05bc-2a28-490e-fb53-5562b607702d';
         $cit_params[2] = "0";
         $cit_params[3] = "ConfigurationItemSets";
         $cit_params[4] = "";
         $cit_params[5] = 'QuickCIUpdates';
         $cit_params[6] = "Enable Hirokos Timer?";

         $enable_hirokos_timer = quick_ci_updates ($cit_params);

         $preform .= "<div style=\"".$divstyle_white."\">".$enable_hirokos_timer."</div>";

         }
*/
     echo $preform;

     break; # add

    } # switch action

   break; # EventPermissions
   # EventPermissions
   ###############################
   # Personal Account 
   case 'PersonalSet':


    # Personal Profile | ID: 70212896-f1ba-bc72-ae79-55d6707b8bc5
    # Gender | ID: 80568993-d830-f22b-430e-55d67137492f
    # Female | ID: ee874cc3-6fad-dced-4b52-55d672d639cb
    # Male | ID: d5aa8939-4cfa-4e8e-8aee-55d672e1ddbe
    # 

    if (!$sess_contact_id){
       break;
       }

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      # Hiroko's Timer | ID: 915e05bc-2a28-490e-fb53-5562b607702d
 
      #$cits = "(sclm_configurationitemtypes_id_c='71529bf3-01ce-1a56-6f8f-554fe9490b75' || sclm_configurationitemtypes_id_c='915e05bc-2a28-490e-fb53-5562b607702d')";
      #Gender | ID: 80568993-d830-f22b-430e-55d67137492f

      $cits = "(sclm_configurationitemtypes_id_c='71529bf3-01ce-1a56-6f8f-554fe9490b75' || sclm_configurationitemtypes_id_c='80568993-d830-f22b-430e-55d67137492f')";

      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && contact_id_c='".$sess_contact_id."' && ".$cits." ";
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
             $this_assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
             $child_id = $ci_items[$cnt]['child_id'];
             $account_id_c = $ci_items[$cnt]['account_id_c'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];
             $ci_type_id = $ci_items[$cnt]['ci_type_id'];
             $ci_data_type = $ci_items[$cnt]['ci_data_type'];

             if ($this_assigned_user != NULL){
                $assigned_user_id = $this_assigned_user;
                }

             # Use ci_data_type to send
             if ($ci_type_id == '71529bf3-01ce-1a56-6f8f-554fe9490b75'){ # Show My Well-being? 

                $cit_params = "";
                $cit_params[0] = "checkbox";
                $cit_params[1] = $ci_type_id;
                $cit_params[2] = $name;
                $cit_params[3] = "ConfigurationItemSets";
                $cit_params[4] = $id;
                $cit_params[5] = 'QuickCIUpdates';
                $cit_params[6] = 'Show my Well-being?';

                $show_my_wellbeing = quick_ci_updates ($cit_params);
   
                $preform .= "<div style=\"".$divstyle_white."\">".$show_my_wellbeing."</div>";

                } elseif ($ci_type_id == '80568993-d830-f22b-430e-55d67137492f'){ # Gender

                $gender = $name;
                $gender_id = $id;

                }

/*
                } elseif ($ci_type_id == '915e05bc-2a28-490e-fb53-5562b607702d'){ # Hiroko's Timer
   
                $cit_params = "";
                $cit_params[0] = "checkbox";
                $cit_params[1] = $ci_type_id;
                $cit_params[2] = $name;
                $cit_params[3] = $do;
                $cit_params[4] = $id;
                $cit_params[5] = 'QuickCIUpdates';
                $cit_params[6] = "Enable Hirokos Timer?";
   
                $enable_hirokos_timer = quick_ci_updates ($cit_params);

                if ($name == 1){
                   $hiroko_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=HirokosTimer&action=view&value=".$id."&valuetype=HirokosTimer&sendiv=".$BodyDIV."');return false\"><font color=#151B54><B>Hiroko's Timer Settings</B></font></a></div><P>";
                   }

                $preform .= "<div style=\"".$divstyle_white."\">".$enable_hirokos_timer.$hiroko_settings."</div>";

                }
  */ 

#                  } elseif ($ci_type_id == '1d0df382-a9a7-7af3-0ce0-55263163f34f'){ # Allow Well-being

             } # for

         } # is array

      if (!$show_my_wellbeing){

         $cit_params = "";
         $cit_params[0] = "checkbox";
         $cit_params[1] = '71529bf3-01ce-1a56-6f8f-554fe9490b75';
         $cit_params[2] = "0";
         $cit_params[3] = "ConfigurationItemSets";
         $cit_params[4] = "";
         $cit_params[5] = 'QuickCIUpdates';
         $cit_params[6] = 'Show my Well-being?';

         $show_my_wellbeing = quick_ci_updates ($cit_params);

         $preform .= "<div style=\"".$divstyle_white."\">".$show_my_wellbeing."</div>";

         }
/*
      if (!$enable_hirokos_timer){

         $cit_params = "";
         $cit_params[0] = "checkbox";
         $cit_params[1] = '915e05bc-2a28-490e-fb53-5562b607702d';
         $cit_params[2] = "0";
         $cit_params[3] = "ConfigurationItemSets";
         $cit_params[4] = "";
         $cit_params[5] = 'QuickCIUpdates';
         $cit_params[6] = "Enable Hirokos Timer?";

         $enable_hirokos_timer = quick_ci_updates ($cit_params);

         $preform .= "<div style=\"".$divstyle_white."\">".$enable_hirokos_timer."</div>";

         }
*/
     echo $preform;

         $tblcnt = 0;
   
         $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
         $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
         $tablefields[$tblcnt][21] = $sess_account_id; //$field_value;   

         $tblcnt++;

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
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
         $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;  

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
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
         $tablefields[$tblcnt][21] = $valtype; //$field_value;  

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'gender'; // Field Name
         $tablefields[$tblcnt][1] = "Gender"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type

         $dd_pack['ee874cc3-6fad-dced-4b52-55d672d639cb'] = "Female";
         $dd_pack['d5aa8939-4cfa-4e8e-8aee-55d672e1ddbe'] = "Male";

         $tablefields[$tblcnt][6] = '30'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9][0] = "list"; //'db'; // dropdown type (DB Table, Array List, Other)
         $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
         $tablefields[$tblcnt][9][2] = 'id';
         $tablefields[$tblcnt][9][3] = 'name';
         $tablefields[$tblcnt][9][4] = "";
         $tablefields[$tblcnt][9][5] = $gender; // Current Value
         $tablefields[$tblcnt][9][6] = "";
         $tablefields[$tblcnt][6] = '30'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "5"; // visible length
         $tablefields[$tblcnt][20] = 'gender';//$field_value_id;
         $tablefields[$tblcnt][21] = $gender; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'gender_id'; // Field Name
         $tablefields[$tblcnt][1] = "Gender ID"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '255'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = 'gender_id';//$field_value_id;
         $tablefields[$tblcnt][21] = $gender_id; //$field_value;

         $admin = $auth;

         $valpack = "";
         $valpack[0] = $do;
         $valpack[1] = "edit";
         $valpack[2] = $valtype;
         $valpack[3] = $tablefields;
         $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
         $valpack[5] = ""; // provide add new button

         # Build parent layer
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

         echo $container_top;

         echo $zaform;

         echo $container_bottom;


     break; # add
     case 'process':

      $process_object_type = "ConfigurationItems";
      $process_action = "update";

      if ($_POST['gender']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['gender_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['gender']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['gender']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         #$process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '80568993-d830-f22b-430e-55d67137492f');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }
      

     break;

    } # switch action

   break; # PersonalSet
   # Personal Account
   ###############################
   # Set: PortalSet
   case 'PortalSet':

    if (!$sess_account_id){
       break;
       }

    switch ($action){

     case 'add':
     case 'edit':
     case 'view':

      $portal_email = "";
      $portal_email_password = "";
      $zaform = "";
      $preform = "";

      # These CITs need to be updated in funky.php at the portaliser

      # Firstly, no portal settings can be made unless they have their own domain
      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && sclm_configurationitemtypes_id_c='ad2eaca7-8f00-9917-501a-519d3e8e3b35' ";

      $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

      if (is_array($ci_items)){

         for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
             $checked_portal_hostname_id = $ci_items[$cnt]['id'];
             $checked_portal_hostname = $ci_items[$cnt]['name'];

             } # for

         } # is array

      if ($checked_portal_hostname == NULL || $checked_portal_hostname != $hostname){

         # Is null - give them the option to add one before seeing any other portal config

         $tblcnt = 0;

         $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
         $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
         $tablefields[$tblcnt][21] = $sess_account_id; //$field_value;   

         $tblcnt++;

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
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
         $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;  

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
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
         $tablefields[$tblcnt][21] = $valtype; //$field_value;  

         if ($checked_portal_hostname != NULL){

            $hostname_message = "To be able to manage a branded portal, you must access this site from your registered hostname (".$checked_portal_hostname."). If you requested a sub-domain, the administration will be reviewing your request. You may also change this here at any time with your own registered address.";

            $tblcnt++;

            $tablefields[$tblcnt][0] = "current_hostname"; // Field Name
            $tablefields[$tblcnt][1] = "Current Portal Hostname (Sub/Domain)"; // Full Name
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
            $tablefields[$tblcnt][12] = "60"; // visible length
            $tablefields[$tblcnt][20] = "current_hostname"; //$field_value_id;
            $tablefields[$tblcnt][21] = $checked_portal_hostname; //$field_value;   

            } else {

            $hostname_message = "To be able to manage a branded portal, you must first set a proper hostname.";

            } 

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'hostname'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Hostname Options"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '255'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

         $hostnameoptionpack['sub'] = "Create a scalastica.com sub-domain";
         $hostnameoptionpack['own'] = "Use your own, existing domain";
         $hostnameoptionpack['reg'] = "Register a new domain";

         $tablefields[$tblcnt][9][1] = $hostnameoptionpack; // If DB, dropdown_table, if List, then array, other related table
         $tablefields[$tblcnt][9][2] = 'id';
         $tablefields[$tblcnt][9][3] = 'name';
         $tablefields[$tblcnt][9][4] = "";//$exception;
         $tablefields[$tblcnt][9][5] = $checked_portal_hostname; // Current Value
         $tablefields[$tblcnt][9][6] = 'ConfigurationItemSets';
         $tablefields[$tblcnt][9][7] = "portal_hostname"; // list reltablename
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = 'hostname';//$field_value_id;
         $tablefields[$tblcnt][21] = $checked_portal_hostname; //$field_value;

         $valpack = "";
         $valpack[0] = $do;
         $valpack[1] = $action;
         $valpack[2] = $valtype;
         $valpack[3] = $tablefields;
         $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
         $valpack[5] = ""; // provide add new button

         # Build parent layer
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

         echo $container_top;

         echo "<div style=\"".$divstyle_orange_light."\">".$hostname_message."</div>";

         echo $zaform;

         echo $container_bottom;

         } else {

         # Not null - allow to see all other portal config

         $cits = $funky_gear->get_portal_cits();

         $ci_object_type = "ConfigurationItems";
         $ci_action = "select";
         $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && ".$cits." ";

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
                $this_assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
                $child_id = $ci_items[$cnt]['child_id'];
                $account_id_c = $ci_items[$cnt]['account_id_c'];
                $contact_id_c = $ci_items[$cnt]['contact_id_c'];
                $ci_type_id = $ci_items[$cnt]['ci_type_id'];
                $ci_data_type = $ci_items[$cnt]['ci_data_type'];

                if ($this_assigned_user != NULL){
                   $assigned_user_id = $this_assigned_user;
                   }

                # Use ci_data_type to send

                if ($ci_type_id == '78fdc61d-6ce5-1172-a55a-52c7048a48c7'){ // invoice_day

                   $invoice_day = $name;
                   $invoice_day_id = $id;

                   } elseif ($ci_type_id == 'c964c341-ebef-c62b-07f5-51a9cea93d17'){ // portal_title
   
                   $portal_title = $name;
                   $portal_title_id = $id;

                   } elseif ($ci_type_id == '723305fd-5711-83d6-1158-51aa0cfcb607'){ // portal_logo

                   $portal_logo = $name;
                   $portal_logo_id = $id;

                   } elseif ($ci_type_id == '234cd0fc-fea8-bfb3-6253-5291aaa03b0c'){ // portal_email_server

                   $portal_email_server = $name;
                   $portal_email_server_id = $id;

                   } elseif ($ci_type_id == '571f4cd2-1d12-d165-a8c7-5205833eb24c'){ // smtp_auth
   
                   $portal_email_server_smtp_auth = $name;
                   $portal_email_server_smtp_auth_id = $id;

                   } elseif ($ci_type_id == '6fb14f09-71c7-ce07-c746-5291aa2c39c4'){ // smtp_port

                   $portal_email_server_smtp_port = $name;
                   $portal_email_server_smtp_port_id = $id;

                   } elseif ($ci_type_id == '795f11f8-ab63-3948-aac3-51d777dd433c'){ // portal_email

                   $portal_email = $name;
                   $portal_email_id = $id;

                   } elseif ($ci_type_id == '12e4272a-e571-1067-44f3-51d7787a4045'){ // portal_email_password
   
                   $portal_email_password = $name;
                   $portal_email_password_id = $id;

                   } elseif ($ci_type_id == 'c0fed5ce-05ba-66e2-e9ae-51b2f2446f68'){ // portal_skin

                   $portal_skin = $name;
                   $portal_skin_id = $id;

                   } elseif ($ci_type_id == 'ad2eaca7-8f00-9917-501a-519d3e8e3b35'){ // hostname

                   $portal_hostname = $name;
                   $portal_hostname_id = $id;
   
                   } elseif ($ci_type_id == '771c822d-0966-41d7-c00b-54e4c259bed1'){ # reseller commission

                   $commission = $name;
                   $commission_id = $id;

                   } elseif ($ci_type_id == 'b60c0862-9acd-fd4a-d64b-54fd9f023ed9'){ # Portal Body Colour
   
                   $portal_body_colour = $name;
                   $portal_body_colour_id = $id;

                   } elseif ($ci_type_id == '374e0ff5-c728-b849-5867-54fd9f775591'){ # Portal Border Colour

                   $portal_border_colour = $name;
                   $portal_border_colour_id = $id;

                   } elseif ($ci_type_id == '891105ec-400c-9b2b-f1f0-54fda0c49f24'){ # Portal Description
   
                   $portal_description = $name;
                   $portal_description_id = $id;

                   } elseif ($ci_type_id == '201e0ed5-cc50-0cfb-e264-54fd9f3794a7'){ # Portal Footer Colour

                   $portal_footer_colour = $name;
                   $portal_footer_colour_id = $id;

                   } elseif ($ci_type_id == '52fb4588-f0f2-ae8e-76c0-54fd9f9f5b6b'){ # Portal Header Colour 

                   $portal_header_colour = $name;
                   $portal_header_colour_id = $id;

                   } elseif ($ci_type_id == '2a060f28-75dc-c937-ccb7-54fdc47aaa2d'){ # Portal Font Colour 

                   $portal_font_colour = $name;
                   $portal_font_colour_id = $id;

                   } elseif ($ci_type_id == 'c1e37d9b-a6c9-0cd2-d6dd-54fda09a337a'){ # Portal Keywords 

                   $portal_keywords = $name;
                   $portal_keywords_id = $id;
   
                   } elseif ($ci_type_id == 'cafad60b-6fab-dbd2-66d6-54d7a1988a3e'){ # Rego Portal Auto Access
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow portal access on registration?';
   
                   $allow_portal_access_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_portal_access_ci."</div>";
   
                   } elseif ($ci_type_id == 'ea0de164-0803-4551-8cc1-51fdc1881db6'){ // allow_engineer_rego
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Engineer Registrations?';
   
                   $allow_engineer_rego_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_engineer_rego_ci."</div>";
   
                   } elseif ($ci_type_id == '1d0df382-a9a7-7af3-0ce0-55263163f34f'){ # Allow Well-being
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Well-being?';
   
                   $allow_wellbeing_rego_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_wellbeing_rego_ci."</div>";
   
                   } elseif ($ci_type_id == '5e7c49e5-e48d-f53e-9c4a-54d719f5fedb'){ // Allow Provider Registrations 
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Provider Registrations?';
   
                   $allow_provider_rego_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_provider_rego_ci."</div>";
   
                   } elseif ($ci_type_id == '2f6a1ad8-2501-c5d7-025f-54d71a110296'){ // Allow Reseller Registrations 
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Reseller Registrations?';
   
                   $allow_reseller_rego_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_reseller_rego_ci."</div>";
   
                   } elseif ($ci_type_id == '1d3da104-6fad-d1d8-719a-54d71a00b7d0'){ // Allow Client Registrations
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Client Registrations?';
   
                   $allow_client_rego_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_client_rego_ci."</div>";
   
                   } elseif ($ci_type_id == '4a67c6fb-42d0-8cb6-84b9-54deec34066b'){ // Allow Global Catalog
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Global Catalog?';
   
                   $allow_global_catalog_ci = quick_ci_updates ($cit_params);
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_global_catalog_ci."</div>";
   
                   } elseif ($ci_type_id == '6ba459d7-3800-59bf-c2ea-54df2f50dd66'){ // Allow Account Catalog
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Account Catalog?';
   
                   $allow_account_catalog_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_account_catalog_ci."</div>";
   
                   } elseif ($ci_type_id == 'b55e3f9f-ee16-3a5d-474d-54eb2973e625'){ // Show Custom Navigation

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Show Custom Navigation?';

                   $allow_custom_navigation_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_custom_navigation_ci."</div>";

                   } elseif ($ci_type_id == '8a5c8fb2-dd32-d0b4-3af1-5516a8746b5e'){ # Allow Scalastica Sign-ups

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow '.$portal_title.' Sign-ups?';
   
                   $allow_sc_ci = quick_ci_updates ($cit_params);

                   if ($name == 1){
                      #$sc_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Scalastica&action=SetApp&value=".$id."&valuetype=Scalastica&sendiv=lightform');return false\"><font color=#151B54><B>App Settings</B></font></a></div><P>";
                      }

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_sc_ci.$sc_settings."</div>";

                   } elseif ($ci_type_id == '90b3d066-c1b4-7e42-8f2b-54fe44936c60'){ # Allow Facebook Sign-ups
   
                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Facebook Sign-ups?';
   
                   $allow_facebook_ci = quick_ci_updates ($cit_params);

                   if ($name == 1){
                      $fb_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Facebook&action=SetApp&value=".$id."&valuetype=Facebook&sendiv=lightform');return false\"><font color=#151B54><B>App Settings</B></font></a></div><P>";
                      }

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_facebook_ci.$fb_settings."</div>";

                   } elseif ($ci_type_id == '185e7990-5681-98be-0d2d-54fe44be14b2'){ # Allow Google Sign-ups

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Google Sign-ups?';

                   $allow_google_ci = quick_ci_updates ($cit_params);

                   if ($name == 1){
                      $gg_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Google&action=SetApp&value=".$id."&valuetype=Google&sendiv=lightform');return false\"><font color=#151B54><B>App Settings</B></font></a></div><P>";
                      }

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_google_ci.$gg_settings."</div>";

                   } elseif ($ci_type_id == '881a41d2-2a73-1a75-bd02-54fe443417a5'){ # Allow LinkedIn Sign-ups

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow LinkedIn Sign-ups?';

                   $allow_linkedin_ci = quick_ci_updates ($cit_params);

                   if ($name == 1){
                      $li_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=LinkedIn&action=SetApp&value=".$id."&valuetype=LinkedIn&sendiv=lightform');return false\"><font color=#151B54><B>App Settings</B></font></a></div><P>";
                      }

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_linkedin_ci.$li_settings."</div>";

                   } elseif ($ci_type_id == '5ffacdc0-8d54-b786-eba2-55079c9d70b6'){ # Allow Shared Effects

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Shared Effects?';

                   $allow_sharedeffects_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_sharedeffects_ci."</div>";

                   } elseif ($ci_type_id == '48ac706c-658d-7c2c-7af0-5575167b902a'){ # Allow Life Planner

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = 'Allow Life Planner?';

                   $allow_lifeplanner_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_lifeplanner_ci."</div>";

                   } elseif ($ci_type_id == '915e05bc-2a28-490e-fb53-5562b607702d'){ # enable_hirorins_timer

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = "Enable Hirorins Timer?";
          
                   $enable_hirorins_timer = quick_ci_updates ($cit_params);
          
                   if ($name == 1){
                      $hirorins_settings = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=HirorinsTimer&action=view&value=".$id."&valuetype=HirorinsTimer&sendiv=".$BodyDIV."');return false\"><font color=#151B54><B>Hirorin's Timer Settings</B></font></a></div><P>";
                      }
   
                   $preform .= "<div style=\"".$divstyle_white."\">".$enable_hirorins_timer.$hirorins_settings."</div>";

                   } elseif ($ci_type_id == '11ca3637-558a-7600-13be-556d1758f2fa'){ # Show Partner Listing 

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = "Show Partners?";
          
                   $show_partners_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$show_partners_ci."</div>";

                   } elseif ($ci_type_id == '18cdeba5-6e31-a186-d472-556d56e2bec1'){ # Show Service Statistics

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = "Show Statistics?";
          
                   $show_statistics_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$show_statistics_ci."</div>";

                   } elseif ($ci_type_id == '10539d8a-aa52-5005-092f-557a4f7ba573'){ # Allow Infracerts

                   $cit_params = "";
                   $cit_params[0] = "checkbox";
                   $cit_params[1] = $ci_type_id;
                   $cit_params[2] = $name;
                   $cit_params[3] = $do;
                   $cit_params[4] = $id;
                   $cit_params[5] = 'QuickCIUpdates';
                   $cit_params[6] = "Allow Infracerts?";
          
                   $allow_infracerts_ci = quick_ci_updates ($cit_params);

                   $preform .= "<div style=\"".$divstyle_white."\">".$allow_infracerts_ci."</div>";
                   # Add Left/Right Column Showing

                   } # end if

                } // end for

            } // is array

         if (!$allow_portal_access_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = 'cafad60b-6fab-dbd2-66d6-54d7a1988a3e';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow portal access on registration?';

            $allow_portal_access_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_portal_access_ci."</div>";

            } 

         if (!$allow_engineer_rego_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = 'ea0de164-0803-4551-8cc1-51fdc1881db6';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Engineer Registrations?';

            $allow_engineer_rego_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_engineer_rego_ci."</div>";

            }

         if (!$allow_wellbeing_rego_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '1d0df382-a9a7-7af3-0ce0-55263163f34f';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Well-being?';

            $allow_wellbeing_rego_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_wellbeing_rego_ci."</div>";

            }

         if (!$allow_provider_rego_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '5e7c49e5-e48d-f53e-9c4a-54d719f5fedb';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Provider Registrations?';

            $allow_provider_rego_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_provider_rego_ci."</div>";

            }

         if (!$allow_reseller_rego_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '2f6a1ad8-2501-c5d7-025f-54d71a110296';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Reseller Registrations?';

            $allow_reseller_rego_ci = quick_ci_updates ($cit_params);
   
            $preform .= "<div style=\"".$divstyle_white."\">".$allow_reseller_rego_ci."</div>";
   
            }
   
         if (!$allow_client_rego_ci){
   
            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '1d3da104-6fad-d1d8-719a-54d71a00b7d0';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Client Registrations?';

            $allow_client_rego_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_client_rego_ci."</div>";

            }

         if (!$allow_global_catalog_ci){
   
            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '4a67c6fb-42d0-8cb6-84b9-54deec34066b';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Global Catalog?';

            $allow_global_catalog_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_global_catalog_ci."</div>";

            }

         if (!$allow_account_catalog_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '6ba459d7-3800-59bf-c2ea-54df2f50dd66';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Account Catalog?';

            $allow_account_catalog_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_account_catalog_ci."</div>";

            }

         if (!$allow_custom_navigation_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = 'b55e3f9f-ee16-3a5d-474d-54eb2973e625';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Show Custom Navigation?';
   
            $allow_custom_navigation_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_custom_navigation_ci."</div>";

            }

         if (!$allow_sc_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '8a5c8fb2-dd32-d0b4-3af1-5516a8746b5e';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow '.$portal_title.' Sign-in?';

            $allow_sc_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_sc_ci."</div>";

            }

         if (!$allow_facebook_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '90b3d066-c1b4-7e42-8f2b-54fe44936c60';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Facebook Sign-in?';

            $allow_facebook_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_facebook_ci."</div>";

            }
   
         if (!$allow_google_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '185e7990-5681-98be-0d2d-54fe44be14b2';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Google Sign-in?';

            $allow_google_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_google_ci."</div>";

            }

         if (!$allow_linkedin_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '881a41d2-2a73-1a75-bd02-54fe443417a5';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow LinkedIn Sign-in?';

            $allow_linkedin_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_linkedin_ci."</div>";

            }

         if (!$allow_sharedeffects_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '5ffacdc0-8d54-b786-eba2-55079c9d70b6';
            $cit_params[2] = "0";
            $cit_params[3] = $do;
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = 'Allow Shared Effects?';

            $allow_sharedeffects_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_sharedeffects_ci."</div>";

            }

         if (!$enable_hirorins_timer){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '915e05bc-2a28-490e-fb53-5562b607702d';
            $cit_params[2] = "0";
            $cit_params[3] = "ConfigurationItemSets";
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = "Enable Hirorins Timer?";

            $enable_hirorins_timer = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$enable_hirorins_timer."</div>";

            }

         if (!$show_statistics_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '18cdeba5-6e31-a186-d472-556d56e2bec1';
            $cit_params[2] = "0";
            $cit_params[3] = "ConfigurationItemSets";
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = "Show Statistics?";

            $show_statistics_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$show_statistics_ci."</div>";

            }

         if (!$show_partners_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '11ca3637-558a-7600-13be-556d1758f2fa';
            $cit_params[2] = "0";
            $cit_params[3] = "ConfigurationItemSets";
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = "Show Partners?";

            $show_partners_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$show_partners_ci."</div>";

            }

         if (!$allow_lifeplanner_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '48ac706c-658d-7c2c-7af0-5575167b902a';
            $cit_params[2] = "0";
            $cit_params[3] = "ConfigurationItemSets";
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = "Allow Life Planner?";

            $allow_lifeplanner_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_lifeplanner_ci."</div>";

            }

         if (!$allow_infracerts_ci){

            $cit_params = "";
            $cit_params[0] = "checkbox";
            $cit_params[1] = '10539d8a-aa52-5005-092f-557a4f7ba573';
            $cit_params[2] = "0";
            $cit_params[3] = "ConfigurationItemSets";
            $cit_params[4] = "";
            $cit_params[5] = 'QuickCIUpdates';
            $cit_params[6] = "Allow Infracerts?";

            $allow_infracerts_ci = quick_ci_updates ($cit_params);

            $preform .= "<div style=\"".$divstyle_white."\">".$allow_infracerts_ci."</div>";

            }

         $tblcnt = 0;
   
         $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
         $tablefields[$tblcnt][1] = "account_id_c"; // Full Name
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
         $tablefields[$tblcnt][21] = $sess_account_id; //$field_value;   

         $tblcnt++;

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
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
         $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;  

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
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
         $tablefields[$tblcnt][21] = $valtype; //$field_value;  

         $tblcnt++;

         $tablefields[$tblcnt][0] = "child_id"; // Field Name
         $tablefields[$tblcnt][1] = "child_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "child_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $child_id; //$field_value;  

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'invoice_day'; // Field Name
         $tablefields[$tblcnt][1] = "Invoice Day"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '30'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "5"; // visible length
         $tablefields[$tblcnt][20] = 'invoice_day';//$field_value_id;
         $tablefields[$tblcnt][21] = $invoice_day; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'invoice_day_id'; // Field Name
         $tablefields[$tblcnt][1] = "invoice_day ID"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '255'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = 'invoice_day_id';//$field_value_id;
         $tablefields[$tblcnt][21] = $invoice_day_id; //$field_value;

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
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "60"; // visible length
         $tablefields[$tblcnt][20] = "hostname"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_hostname; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "hostname_id"; // Field Name
         $tablefields[$tblcnt][1] = "hostname_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "hostname_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_hostname_id; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_title"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Title"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '40'; // length
         $tablefields[$tblcnt][7] = '0'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "60"; // visible length
         $tablefields[$tblcnt][20] = "portal_title"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_title; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_title_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_title_id"; // Full Name
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
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "60"; // visible length
         $tablefields[$tblcnt][20] = "portal_logo"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_logo; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_logo_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_logo_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_logo_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_logo_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_body_colour"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Body Colour"; // Full Name
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
         $tablefields[$tblcnt][12] = "10"; // Field ID
         $tablefields[$tblcnt][20] = "portal_body_colour"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_body_colour; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_body_colour_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_body_colour_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_body_colour_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_body_colour_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_border_colour"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Border Colour"; // Full Name
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
         $tablefields[$tblcnt][12] = "10"; // Field ID
         $tablefields[$tblcnt][20] = "portal_border_colour"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_border_colour; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_border_colour_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_border_colour_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_border_colour_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_border_colour_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_header_colour"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Header Colour"; // Full Name
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
         $tablefields[$tblcnt][12] = "10"; // Field ID
         $tablefields[$tblcnt][20] = "portal_header_colour"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_header_colour; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_header_colour_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_header_colour_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_header_colour_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_header_colour_id; //$field_value;
   
         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_footer_colour"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Footer Colour"; // Full Name
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
         $tablefields[$tblcnt][12] = "10"; // Field ID
         $tablefields[$tblcnt][20] = "portal_footer_colour"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_footer_colour; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_footer_colour_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_footer_colour_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_footer_colour_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_footer_colour_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_font_colour"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Font Colour"; // Full Name
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
         $tablefields[$tblcnt][12] = "10"; // Field ID
         $tablefields[$tblcnt][20] = "portal_font_colour"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_font_colour; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_font_colour_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_font_colour_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_font_colour_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_font_colour_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'portal_keywords'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Keywords"; // Full Name
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
         $tablefields[$tblcnt][12] = "60"; // Field ID
         $tablefields[$tblcnt][20] = 'portal_keywords';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_keywords; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_keywords_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_keywords_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_keywords_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_keywords_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'portal_description'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Meta Description"; // Full Name
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
         $tablefields[$tblcnt][12] = "60"; // Field ID
         $tablefields[$tblcnt][20] = 'portal_description';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_description; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_description_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_description_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_description_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_description_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'portal_email_server'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email Server Host"; // Full Name
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
         $tablefields[$tblcnt][12] = "60"; // Field ID
         $tablefields[$tblcnt][20] = 'portal_email_server';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_server; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'portal_email_server_id'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email Server Host"; // Full Name
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
         $tablefields[$tblcnt][20] = 'portal_email_server_id';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_server_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'portal_email_server_smtp_auth'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email Server SMTP Auth"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '40'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
         $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
         $tablefields[$tblcnt][9][2] = 'id';
         $tablefields[$tblcnt][9][3] = 'name';
         $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='571f4cd2-1d12-d165-a8c7-5205833eb24c' && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
         $tablefields[$tblcnt][9][5] = $portal_email_server_smtp_auth; // Current Value
         $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
         $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
         $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
         $tablefields[$tblcnt][9][9] = $portal_email_server_smtp_auth; // Current Value
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = 'portal_email_server_smtp_auth';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_server_smtp_auth; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_email_server_smtp_auth_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_email_server_smtp_auth_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_email_server_smtp_auth_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_server_smtp_auth_id; //$field_value; 

         $tblcnt++;

         if (!$portal_email_server_smtp_port){

            $portal_email_server_smtp_port = 465;

            }

         $tablefields[$tblcnt][0] = 'portal_email_server_smtp_port'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email Server SMTP Port"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '10'; // length
         $tablefields[$tblcnt][7] = '0'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "6"; // Field Length
         $tablefields[$tblcnt][20] = 'portal_email_server_smtp_port';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_server_smtp_port; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = 'portal_email_server_smtp_port_id'; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email Server Port"; // Full Name
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
         $tablefields[$tblcnt][20] = 'portal_email_server_smtp_port_id';//$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_server_smtp_port_id; //$field_value;

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_email"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '30'; // length
         $tablefields[$tblcnt][7] = '0'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][12] = "40"; // Field Length
         $tablefields[$tblcnt][20] = "portal_email"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_email_id"; // Field Name
         $tablefields[$tblcnt][1] = "portal_email_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "portal_email_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_email_id; //$field_value; 

         $tblcnt++;

         $tablefields[$tblcnt][0] = "portal_email_password"; // Field Name
         $tablefields[$tblcnt][1] = "Portal Email Password"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'password';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '20'; // length
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
         $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
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
         $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='9dc21c7b-6279-dfd3-3663-51b2f0489807' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."')";
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
         $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
         $tablefields[$tblcnt][6] = '255'; // length
         $tablefields[$tblcnt][7] = '0'; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
         $tablefields[$tblcnt][10] = '';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "portal_skin_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $portal_skin_id; //$field_value; 

         $tblcnt++;

         $tablefields[$tblcnt][0] = "commission"; // Field Name
         $tablefields[$tblcnt][1] = "Reseller Commission"; // Full Name
         $tablefields[$tblcnt][2] = 0; // is_primary
         $tablefields[$tblcnt][3] = 0; // is_autoincrement
         $tablefields[$tblcnt][4] = 0; // is_name
         $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type

         $dd_pack = $funky_gear->makepercentage ();

         # The percentage function shows full numbers..
         if ($commission){
            $commission = $commission*100;
            }

         $tablefields[$tblcnt][6] = '30'; // length
         $tablefields[$tblcnt][7] = ''; // NULLOK?
         $tablefields[$tblcnt][8] = ''; // default
         $tablefields[$tblcnt][9][0] = "list"; //'db'; // dropdown type (DB Table, Array List, Other)
         $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
         $tablefields[$tblcnt][9][2] = 'id';
         $tablefields[$tblcnt][9][3] = 'name';
         $tablefields[$tblcnt][9][4] = "";
         $tablefields[$tblcnt][9][5] = $commission; // Current Value
         $tablefields[$tblcnt][9][6] = "";
         $tablefields[$tblcnt][10] = '1';//1; // show in view 
         $tablefields[$tblcnt][11] = ""; // Field ID
         $tablefields[$tblcnt][20] = "commission"; //$field_value_id;
         $tablefields[$tblcnt][21] = $commission; //$field_value;   

         $tblcnt++;

         $tablefields[$tblcnt][0] = "commission_id"; // Field Name
         $tablefields[$tblcnt][1] = "commission_id"; // Full Name
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
         $tablefields[$tblcnt][20] = "commission_id"; //$field_value_id;
         $tablefields[$tblcnt][21] = $commission_id; //$field_value; 

         $admin = $auth;

         $valpack = "";
         $valpack[0] = $do;
         $valpack[1] = $action;
         $valpack[2] = $valtype;
         $valpack[3] = $tablefields;
         $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
         $valpack[5] = ""; // provide add new button

         # Build parent layer
         $zaform .= $funky_gear->form_presentation($valpack);

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

         #$returner = $funky_gear->object_returner ("Accounts", $sess_account_id);
         #$object_return_name = $returner[0];
         #$object_return = $returner[1];
         #$object_return_title = $returner[2];
         #$object_return_target = $returner[3];
         #$object_return_params = $returner[4];
         #$object_return_completion = $returner[5];
         #$object_return_voter = $returner[6];

         #echo $object_return;

         $colour_divstyle_params[0] = "400px"; // minwidth
         $colour_divstyle_params[1] = "15px"; // minheight
         $colour_divstyle_params[2] = "1%"; // margin_left
         $colour_divstyle_params[3] = "1%"; // margin_right
         $colour_divstyle_params[4] = "2px"; // padding_left
         $colour_divstyle_params[5] = "2px"; // padding_right
         $colour_divstyle_params[6] = "0px"; // margin_top
         $colour_divstyle_params[7] = "0px"; // margin_bottom
         $colour_divstyle_params[8] = "2px"; // padding_top
         $colour_divstyle_params[9] = "2px"; // padding_bottom
         $colour_divstyle_params[12] = "left"; // custom_float
         $colour_divstyle_params[13] = "450px"; // maxwidth
         $colour_divstyle_params[14] = "20px"; // maxheight

         # Show colours in div
         $colours_object_type = "ConfigurationItems";
         $colours_action = "select";
         $colours_params[0] = " sclm_configurationitemtypes_id_c='e027d211-75c9-d360-17cb-54e8577757ca' ";
         $colours_params[1] = ""; // select array
         $colours_params[2] = ""; // group;
         $colours_params[3] = ""; // order;
         $colours_params[4] = ""; // limit
  
         $colours_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $colours_object_type, $colours_action, $colours_params);

         if (is_array($colours_items)){

            for ($colourscnt=0;$colourscnt < count($colours_items);$colourscnt++){
 
                #$id = $colours_items[$colourscnt]['id'];
                $colour = $colours_items[$colourscnt]['name'];
                list($colourname,$hex) = explode('_',$colour);
                $colour_divstyle_params[10] = $hex." 50% 50% repeat-x"; // custom_color_back
                $colour_divstyle_params[11] = "BLACK"; // custom_color_border
                $colour_divstyles = $funky_gear->makedivstyles ($colour_divstyle_params);
                $custom_portal_divstyle = $colour_divstyles[5];

                $showcolours .= "<div style=".$custom_portal_divstyle."><div style='width: 100%; max-height:20px;overflow:no; padding: 0.5em;'><font size=2 color=black>".$colourname." [".$hex."] - </font> <font size=2 color=WHITE> - ".$colourname." [".$hex."]</font></div></div><BR><img src=images/blank.gif width=98% height=1><BR>";

                } # for

            } # is array

         echo $container_top;

         echo "<div style='width: 98%; max-height:300px;overflow:scroll; padding: 0.5em; resize: both;'>".$showcolours."</div>";

         # Only accounts with a correct hostname can re-cache
         echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=recache&value=".$portal_hostname."&valuetype=PortalSet&sendiv=lightform');return false\"><font color=#151B54><B>Re-cache Portal Configuration</B></font></a></div>";

         echo $preform;

         echo $zaform;

         echo $container_bottom;

      } # end if has hostname

     break; //
     case 'recache':

      echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

      $hostname_md = md5($hostname);
      $cachelink = "/tmp/cache_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_top_en_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_top_ja_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_left_out_en_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_left_in_en_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_left_out_ja_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_left_in_ja_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_right_out_en_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_right_in_en_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_right_out_ja_".$hostname_md;
      unlink($cachelink);
      $cachelink = "/tmp/cache_right_in_ja_".$hostname_md;
      unlink($cachelink);

      echo "You have successfully re-cached your portal configuration!";

     break; //
     case 'process':

      $process_object_type = "ConfigurationItems";
      $process_action = "update";

      if ($_POST['invoice_day']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['invoice_day_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['invoice_day']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['invoice_day']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '78fdc61d-6ce5-1172-a55a-52c7048a48c7');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      $requested_hostname = $_POST['hostname'];
      if (!$requested_hostname){
         $requested_hostname = $_POST['portal_hostname'];
         }

      if ($requested_hostname != NULL){

         $selected_domain = $_POST['domain'];

         if ($selected_domain != NULL){
            # For use with subdomains of domains owned by scalastica

            $requested_hostname = $requested_hostname.".".$selected_domain;

            }

         # Edit - but must make sure not changing to another existing one
         $ci_object_type = "ConfigurationItems";
         $ci_params[0] = "name='".$requested_hostname."'";
         $ci_action = "select";
         $ci_params[1] = "id,name,date_entered,account_id_c"; // select array
         $ci_params[2] = ""; // group;
         $ci_params[3] = " name, date_entered DESC "; // order;
         $ci_params[4] = ""; // limit

         $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

         if (is_array($ci_items)){    

            # Found the same hostname

            for ($cnt=0;$cnt < count($ci_items);$cnt++){

                $actual_id = $ci_items[$cnt]['id'];
                $owner_account = $ci_items[$cnt]['account_id_c'];

                } # for

            if ($actual_id != NULL && $_POST['hostname_id'] != NULL && ($actual_id == $_POST['hostname_id'])){

               # No change - do nothing - same ID means same hostname, ID and most likely owner

               } elseif ($actual_id != NULL && $_POST['hostname_id'] != NULL && ($actual_id != $_POST['hostname_id'])) {

               # Different ID for sent hostname - different owner
               $process_message = "<div style=\"".$divstyle_orange."\">".$requested_hostname." Exists - please choose another.</div>";
                  
               } 

            } else {# is array

            # Hostname not found - could be a new/updated one not taken

            $process_params = array();  
            $process_params[] = array('name'=>'id','value' => $_POST['hostname_id']);
            $process_params[] = array('name'=>'name','value' => $requested_hostname);
            $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
            $process_params[] = array('name'=>'description','value' => $requested_hostname);
            $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
            $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
            $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
            $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'ad2eaca7-8f00-9917-501a-519d3e8e3b35');
            $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

            $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

            $hostname_id = $result['id'];

            if ($selected_domain != NULL){

               $type = 1;
               $type = "ja";

               $from_name = $portal_title;
               $from_email = $portal_email;
               $from_email_password = $portal_email_password;

               $mailparams[0] = $from_name;
               $mailparams[1] = "Scalastica";
               $mailparams[2] = $from_email;
               $mailparams[3] = $from_email_password;
               $mailparams[4] = "jyoho@scalastica.com";
               $mailparams[5] = $type;
               $mailparams[6] = $lingo;
               $subdomain = $_POST['hostname'];
               $mailparams[7] = "Sub-domain [".$subdomain."] under ".$selected_domain." has been requested.";

               $this_message_link = "Body@".$lingo."@ConfigurationItems@view@".$hostname_id."@ConfigurationItems";
               $this_message_link = $funky_gear->encrypt($this_message_link);
               $this_message_link = "https://".$hostname."/?pc=".$this_message_link;

               $mailparams[8] = $mailparams[7]."\n".$strings["action_view_here"].":\n".$this_message_link."\n\n";
               $mailparams[9] = $portal_email_server;
               $mailparams[10] = $portal_email_smtp_port;
               $mailparams[11] = $portal_email_smtp_auth;

               $emailresult = $funky_gear->do_email ($mailparams);

               } # if domain

            } # update/add

         } # if hostname

      if ($_POST['portal_title']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_title_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_title']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_title']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'c964c341-ebef-c62b-07f5-51a9cea93d17');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_logo']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_logo_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_logo']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_logo']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '723305fd-5711-83d6-1158-51aa0cfcb607');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email_server']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_server_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_server']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_server']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '234cd0fc-fea8-bfb3-6253-5291aaa03b0c');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email_server_smtp_auth']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_server_smtp_auth_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_server_smtp_auth']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_server_smtp_auth']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '571f4cd2-1d12-d165-a8c7-5205833eb24c');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email_server_smtp_port']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_server_smtp_port_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_server_smtp_port']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_server_smtp_port']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '6fb14f09-71c7-ce07-c746-5291aa2c39c4');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['commission']){

         $commission = $_POST['commission'];
         $commission = $commission/100;

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['commission_id']);
         $process_params[] = array('name'=>'name','value' => $commission);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $commission);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '771c822d-0966-41d7-c00b-54e4c259bed1');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '795f11f8-ab63-3948-aac3-51d777dd433c');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_email_password']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_email_password_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_email_password']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_email_password']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '12e4272a-e571-1067-44f3-51d7787a4045');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_skin']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_skin_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_skin']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_skin']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'c0fed5ce-05ba-66e2-e9ae-51b2f2446f68');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_body_colour']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_body_colour_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_body_colour']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_body_colour']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'b60c0862-9acd-fd4a-d64b-54fd9f023ed9');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_border_colour']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_border_colour_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_border_colour']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_border_colour']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '374e0ff5-c728-b849-5867-54fd9f775591');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_description']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_description_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_description']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_description']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '891105ec-400c-9b2b-f1f0-54fda0c49f24');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_footer_colour']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_footer_colour_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_footer_colour']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_footer_colour']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '201e0ed5-cc50-0cfb-e264-54fd9f3794a7');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_header_colour']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_header_colour_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_header_colour']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_header_colour']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '52fb4588-f0f2-ae8e-76c0-54fd9f9f5b6b');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_font_colour']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_font_colour_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_font_colour']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_font_colour']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '2a060f28-75dc-c937-ccb7-54fdc47aaa2d');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      if ($_POST['portal_keywords']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['portal_keywords_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['portal_keywords']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['portal_keywords']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'c1e37d9b-a6c9-0cd2-d6dd-54fda09a337a');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }


      if ($_POST['allow_engineer_rego']){

         $process_params = array();  
         $process_params[] = array('name'=>'id','value' => $_POST['allow_engineer_rego_id']);
         $process_params[] = array('name'=>'name','value' => $_POST['allow_engineer_rego']);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'description','value' => $_POST['allow_engineer_rego']);
         $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
         $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
         $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'ea0de164-0803-4551-8cc1-51fdc1881db6');
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         }

      $process_message .= $strings["SubmissionSuccess"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$_POST['account_id_c']."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

      echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

     break; // end portal set

    } // end vartype switch for process action

   break; // end PortalSet

   # Set End: PortalSet
   ###############################
   # Set: XXXXXX

  } // end vartype switch

# break; // End
##########################################################
?>
