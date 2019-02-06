<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-02-10
# Page: Infrastructure.php 
##########################################################
# case 'Infrastructure':

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

   # End function check_servers
   ##########################################
   # Shared Access

   if ($action == 'list' || $action == 'search'){

      if ($portal_account_id != $sess_account_id){

         $sharing_params[0] = $portal_account_id;
         $sharing_params[1] = $sess_account_id;
         $sharing_info = $funky_gear->portal_sharing ($sharing_params);

         #$shared_portal_ticketing = $sharing_info['shared_portal_ticketing'];
         #$shared_portal_projects = $sharing_info['shared_portal_projects'];
         #$shared_portal_slarequests = $sharing_info['shared_portal_slarequests'];
         #$shared_portal_slarequest_sql = $sharing_info['shared_portal_slarequest_sql'];
         #$shared_portal_emails = $sharing_info['shared_portal_emails'];
         $shared_portal_infra = $sharing_info['shared_portal_infra'];

         if ($shared_portal_infra == 1){
            $object_return_params[0] = " deleted=0 && account_id_c = '".$parent_account_id."' ";
            } else {
            $object_return_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
            } 

         } else {# if not portal_account_id 
         $object_return_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
         }

      } # End if list

   # End Shared Access
   ################################
   # Start Actions

   if ($action == 'search'){
      $keyword = $val;
      $vallength = strlen($keyword);
      $trimval = substr($keyword, 0, -1);
      $object_return_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";

      $ci_type = $_POST['ci_type'];
      if ($ci_type != NULL){
         $object_return_params[0] .= " && sclm_configurationitemtypes_id_c='".$ci_type."' ";
         }

      } # if search


   switch ($action){

     case 'search':
     case 'list':

      echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Infrastructure Maintenance</B></font></center></div>";
      echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

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

      echo "<P><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=list&value=&valuetype=');return false\"><font size=3><B>List All</B></font></a></center><P>";

      $sendiv = "INFRA";

      echo "<div style=\"".$divstyle_blue."\" name='INFRA' id='INFRA'></div>";

      $added_header = "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=images/icons/plus.gif width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\">
<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7d2f42a9-9de7-224d-712c-52ad30da69fd&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=7827074f-a7d3-9ae5-e473-5255d64e5c73');return false\"><font color=#151B54><B>".$strings["action_addnew"]." DC</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=7d2f42a9-9de7-224d-712c-52ad30da69fd');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
-> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=9a2ee7f9-67b6-9f72-c133-52ad302dfdc0&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=7d2f42a9-9de7-224d-712c-52ad30da69fd');return false\"><font color=#151B54><B>".$strings["action_addnew"]." DC Floor (ID, Name)</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=9a2ee7f9-67b6-9f72-c133-52ad302dfdc0');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=63fef2c9-9acf-fbd1-56c7-52ad300f480f&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=9a2ee7f9-67b6-9f72-c133-52ad302dfdc0');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Rack"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=63fef2c9-9acf-fbd1-56c7-52ad300f480f');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=9065cbc6-177f-9848-1ada-52ad30451c3f&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=63fef2c9-9acf-fbd1-56c7-52ad300f480f');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_System"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=9065cbc6-177f-9848-1ada-52ad30451c3f');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=de350370-d2d3-e84b-13c1-52ad5f2fb2ab&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=63fef2c9-9acf-fbd1-56c7-52ad300f480f');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_RackUnitSpace"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=de350370-d2d3-e84b-13c1-52ad5f2fb2ab');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=77c9dccf-a0a7-05fc-a05f-52ad62515fc7&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=de350370-d2d3-e84b-13c1-52ad5f2fb2ab');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_RackServerUnit"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=77c9dccf-a0a7-05fc-a05f-52ad62515fc7');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7835c8b9-f7d5-5d0a-be10-52ad9c866856&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=77c9dccf-a0a7-05fc-a05f-52ad62515fc7');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Server"]." ".$strings["CI_Host"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=7835c8b9-f7d5-5d0a-be10-52ad9c866856');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=711d9da0-c885-6a0d-1a2c-52c286bd762d&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=77c9dccf-a0a7-05fc-a05f-52ad62515fc7');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Server"]." VM</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=711d9da0-c885-6a0d-1a2c-52c286bd762d');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7ef914c8-09f8-82c9-d4b9-52c29793ef85&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=711d9da0-c885-6a0d-1a2c-52c286bd762d');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Server"]." VM ".$strings["CI_Host"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=7ef914c8-09f8-82c9-d4b9-52c29793ef85');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=de350370-d2d3-e84b-13c1-52ad5f2fb2ab');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=cd287492-19ce-99b3-6ead-52e0c97a6e83&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." ".$strings["CI_Host"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=cd287492-19ce-99b3-6ead-52e0c97a6e83');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=5601009c-5ebd-bc31-3659-52e0e4b16ffb&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." Interconnect Bay</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=5601009c-5ebd-bc31-3659-52e0e4b16ffb');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=5601009c-5ebd-bc31-3659-52e0e4b16ffb');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." Interconnect Bay Switch</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=49ff2505-7d08-cb5c-64e8-52e0e490c0dc&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." Interconnect Bay Switch ".$strings["CI_Host"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=49ff2505-7d08-cb5c-64e8-52e0e490c0dc');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=617ab884-61b5-d7a1-1de7-52ad61df4cae&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=617ab884-61b5-d7a1-1de7-52ad61df4cae');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=34647ae4-154c-68f3-74ea-52b0c8abc3dc&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=617ab884-61b5-d7a1-1de7-52ad61df4cae');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]." ".$strings["CI_Host"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=34647ae4-154c-68f3-74ea-52b0c8abc3dc');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=b3621853-e25d-0e38-84ff-52c286ae0de9&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=617ab884-61b5-d7a1-1de7-52ad61df4cae');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]." VM</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=b3621853-e25d-0e38-84ff-52c286ae0de9');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
------------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=3f6d75b7-c0f5-1739-c66d-52c2989ce02d&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=b3621853-e25d-0e38-84ff-52c286ae0de9');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]." VM ".$strings["CI_Host"]."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Infrastructure&action=search&value=".$val."&valuetype=".$valtype."&keyword=".$keyword."&ci_type=3f6d75b7-c0f5-1739-c66d-52c2989ce02d');return false\"><font color=red><B>[".$strings["action_search"]." by ...]</B></font></a><BR>
</div></div><P>";

      echo $added_header;

      if ($sess_account_id != NULL){

         # Check all servers in system
         $maintsrv_object_type = "ConfigurationItems";
         $maintsrv_action = "select";
         #$maintsrv_params[0] = $object_return_params[0]." && (sclm_configurationitemtypes_id_c='7835c8b9-f7d5-5d0a-be10-52ad9c866856' || sclm_configurationitemtypes_id_c='34647ae4-154c-68f3-74ea-52b0c8abc3dc' || sclm_configurationitemtypes_id_c='7ef914c8-09f8-82c9-d4b9-52c29793ef85' || sclm_configurationitemtypes_id_c='3f6d75b7-c0f5-1739-c66d-52c2989ce02d' || sclm_configurationitemtypes_id_c='49ff2505-7d08-cb5c-64e8-52e0e490c0dc' || sclm_configurationitemtypes_id_c='388b56dc-771e-b743-e63b-541fc6070ab9' || sclm_configurationitemtypes_id_c='8c8a3231-1d86-0117-4680-541fcbab4f6a') ";

         $service_types = $funky_gear->get_infra();

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

         #echo $maintsrv_types_arr;

         #$maintsrv_params[0] = $object_return_params[0]." &&  sclm_configurationitemtypes_id_c IN ('".$array."') ");
         $maintsrv_params[0] = $object_return_params[0]." && ".$maintsrv_types_arr;
         $maintsrv_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,description"; // select array
         $maintsrv_params[2] = ""; // group;
         $maintsrv_params[3] = " name ASC "; // order;
         $maintsrv_params[4] = ""; // limit
  
         $maintservers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $maintsrv_object_type, $maintsrv_action, $maintsrv_params);

         if (is_array($maintservers)){

            $count = count($maintservers);
            $page = $_POST['page'];
            $glb_perpage_items = 100;

            $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
            $lfrom = $navi_returner[0];
            $navi = $navi_returner[1];

            echo $navi;

            $maintsrv_params[4] = " $lfrom , $glb_perpage_items "; 

            $maintservers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $maintsrv_object_type, $maintsrv_action, $maintsrv_params);

            for ($cnt=0;$cnt < count($maintservers);$cnt++){

                $id = $maintservers[$cnt]['id'];
                $server_name = $maintservers[$cnt]['name'];
                $type = $maintservers[$cnt]['sclm_configurationitemtypes_id_c'];
                $type_name = $maintservers[$cnt]['ci_type_name'];
                $parent_ci = $maintservers[$cnt]['sclm_configurationitems_id_c'];
                $parent_ci_name = $maintservers[$cnt]['parent_ci_name'];
                $parent_ci_type = $maintservers[$cnt]['parent_ci_type'];

                #echo "Parent CIT: ".$parent_ci_type."<P>";

                ########################################
                # Servers

                $icondivwidth = "16";
                $iconheight = "3";
                $rowdivwidth = "90%";

                $label = $type_name;#$strings["CI_Server"];

                # Need to check instances that relate to SLAs for allocation with Service SLA Requests
                if ($parent_ci_type == '542be154-a211-98cf-84e0-54e6207213bc'){
                   $label_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $parent_ci_type);
                   $label = $label_returner[0];

                   $server_name_id = $server_name;
                   #$id = $server_name_id; # the
                   $server_name_returner = $funky_gear->object_returner ("AccountsServicesSLAs", $server_name_id);
                   $server_name = $server_name_returner[0];

                   }

                $server = "";
                $server = "<a href=\"#\" onClick=\"loader('INFRA');doBPOSTRequest('INFRA','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=Infrastructure');return false\"><font size=3 color=BLUE><B>".$server_name."</B></font></a>";

                $servers .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=images/icons/Server-Icon-53x53.png width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$server."<BR></div></div>";

                } // for

            echo $servers;

            echo $navi;

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

# break; # End Infrastructure
##########################################################
?>