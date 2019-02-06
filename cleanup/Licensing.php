<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-01-16
# Page: Licensing.php 
##########################################################
# case 'Licensing':

/*
  # Security Checker
  $this_module = '741b8036-525d-959a-ea9a-54b88cd9e512'; # Licensing
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
*/


/*

 This module should allow for;
 1) Assigning a Service SLA Request to a License module (CIT)
    -> SLA Request to be a dropdown item -> CI - parent empty
    -> When instances of the licenses are created a CI of the License (CIT) is created 
       -> The parent should be the SLA CI 
 2) Selecting metrics for any calculations
    -> 
 3) Providing menus based on licensing for a particular account/user
    -> When menus are to be presented, they will check with licensing to enable
 4) Providing an output of licensing for billing purposes

 

 Licensing Metrics | ID: bc660289-159d-f8c2-c759-54b6604fd630

 Module Licensing | ID: 8251ddbc-cd5c-a23c-fc58-53da6f001002

 Account Licensing | ID: 8e3ff812-8fdd-7797-5cfe-54b64bbf679c
 Activity Licensing | ID: 469b1a65-d8b5-69c2-398e-54b88a9c17b0
 Contacts Licensing | ID: 4e5d6794-a96e-610e-ca1a-53da6f999945
 Content Licensing | ID: 8dc70254-4c2a-49ff-7605-54b899dbe239
 Email Filtering Licensing | ID: b1ec5fc3-1154-06a5-d20f-54b64b958d0e
 Infrastructure Licensing | ID: 10270906-ba22-4c42-ca1d-54b66213c795
 Project Licensing | ID: 9b7266a8-6896-33fd-07aa-54b64a4c0759
 Service Licensing | ID: d2ef598d-7db6-2685-85ba-54b662f69f4c
 Ticket Licensing | ID: 8bb68b8c-1d16-c9a4-f4e6-54b64b529598
 Workflow Licensing | ID: 80d45f1b-b608-b123-41d6-54b64caea0bc

*/


  $lic_params[0] = " deleted=0 ";

  $lic_cit = '8251ddbc-cd5c-a23c-fc58-53da6f001002';
  $lic_cit_accounts = '8e3ff812-8fdd-7797-5cfe-54b64bbf679c';
  $lic_cit_contacts  = '4e5d6794-a96e-610e-ca1a-53da6f999945';
  $lic_cit_content  = '8dc70254-4c2a-49ff-7605-54b899dbe239';
  $lic_cit_filters = 'b1ec5fc3-1154-06a5-d20f-54b64b958d0e';
  $lic_cit_infra = '10270906-ba22-4c42-ca1d-54b66213c795';
  $lic_cit_projects = '9b7266a8-6896-33fd-07aa-54b64a4c0759';
  $lic_cit_ticketing = 'd2ef598d-7db6-2685-85ba-54b662f69f4c';
  $lic_cit_activities = '469b1a65-d8b5-69c2-398e-54b88a9c17b0';
  $lic_cit_workflows = '80d45f1b-b608-b123-41d6-54b64caea0bc';
  $lic_cit_services = '8bb68b8c-1d16-c9a4-f4e6-54b64b529598';
  $lic_cit_emails = '74244077-62e2-6538-6b44-54dd86b18d66';

  $lic_cit_array[] = $lic_cit_accounts;
  $lic_cit_array[] = $lic_cit_contacts;
  $lic_cit_array[] = $lic_cit_content;
  $lic_cit_array[] = $lic_cit_filters;
  $lic_cit_array[] = $lic_cit_infra;
  $lic_cit_array[] = $lic_cit_projects;
  $lic_cit_array[] = $lic_cit_ticketing;
  $lic_cit_array[] = $lic_cit_activities;
  $lic_cit_array[] = $lic_cit_workflows;
  $lic_cit_array[] = $lic_cit_services;
  $lic_cit_array[] = $lic_cit_emails;

  switch ($valtype){
   
   case '':
   case 'Billing':

    $lic_params[0] .= " && (sclm_configurationitemtypes_id_c='".$lic_cit_accounts."' || sclm_configurationitemtypes_id_c='".$lic_cit_contacts."' || sclm_configurationitemtypes_id_c='".$lic_cit_content."' || sclm_configurationitemtypes_id_c='".$lic_cit_filters."' || sclm_configurationitemtypes_id_c='".$lic_cit_infra."' || sclm_configurationitemtypes_id_c='".$lic_cit_projects."' || sclm_configurationitemtypes_id_c='".$lic_cit_ticketing."' || sclm_configurationitemtypes_id_c='".$lic_cit_activities."' || sclm_configurationitemtypes_id_c='".$lic_cit_workflows."' || sclm_configurationitemtypes_id_c='".$lic_cit_services."' || sclm_configurationitemtypes_id_c='".$lic_cit_emails."') "; 

   break;
   case 'Accounts':

    # Parent Item has to be the Account ID.
    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_accounts."' "; 
    $this_lic = $lic_cit_accounts;

    $default_lic_cit = $lic_cit_accounts;

   break;
   case 'XXXXXXXXXX':

    # Parent Item has to be all.
    #$lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_accounts."' "; 
    #$this_lic = $lic_cit_accounts;
    #$default_lic_cit = $lic_cit_accounts;

   break;
   case 'Contacts':

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_contacts."' "; 
    $this_lic = $lic_cit_contacts;

    $default_lic_cit = $lic_cit_contacts;

   break;
   case 'Content':

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_content."' "; 
    $this_lic = $lic_cit_content;

    $default_lic_cit = $lic_cit_content;

   break;
   case 'Filtering':

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_filters."' "; 
    $this_lic = $lic_cit_filters;

    $default_lic_cit = $lic_cit_filters;

   break;
   case 'Infrastructure':

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_infra."' "; 
    $this_lic = $lic_cit_infra;

    $default_lic_cit = $lic_cit_infra;

   break;
   case 'Projects':    

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_projects."' "; 
    $this_lic = $lic_cit_projects;

    $default_lic_cit = $lic_cit_projects;

   break;
   case 'Ticketing':    

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_ticketing."' "; 
    $this_lic = $lic_cit_ticketing;

    $default_lic_cit = $lic_cit_ticketing;

   break;
   case 'TicketingActivities':    

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_activities."' "; 
    $this_lic = $lic_cit_activities;

    $default_lic_cit = $lic_cit_activities;

   break;
   case 'Workflows':    

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_workflows."' "; 
    $this_lic = $lic_cit_workflows;

    $default_lic_cit = $lic_cit_workflows;

   break;
   case 'Services':    

    $lic_params[0] .= " && sclm_configurationitemtypes_id_c='".$lic_cit_services."' "; 
    $this_lic = $lic_cit_services;

    $default_lic_cit = $lic_cit_services;

   break;

  } //  end valtype switch

/*
 if ($auth == 3){
    $lic_params[0] .= " && account_id_c='".$sess_account_id."' "; 
    } elseif ($auth == 2) {
    $lic_params[0] .= " && (account_id_c='".$sess_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') "; 
    } elseif ($auth == 1) {
    $lic_params[0] .= " && (account_id_c='".$sess_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') "; 

    } 
*/
  $scalastica_account_id = 'de8891b2-4407-b4c4-f153-51cb64bac59e';

  $lic_params[0] .= " && account_id_c='".$scalastica_account_id."' "; 

  #echo "<P>Query: ".$lic_params[0]."<P>";

  ##########################
  # Lics 

  function quick_slareq_updates ($params){

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

  # Quick SLA Requester
  ##########################
  # Lics 

  function get_lics_components($these_lic_params){

     global $sess_account_id,$auth,$funky_gear,$divstyle_white,$divstyle_orange_light,$divstyle_blue,$BodyDIV,$portalcode,$valtype,$strings,$lingoname;

     $this_ci = $these_lic_params[0];
     $this_cit = $these_lic_params[1];
     $valtype = $these_lic_params[2];

     # License: Account Licensing -> Scalastica (CI) -> CIT = Account License [8e3ff812-8fdd-7797-5cfe-54b64bbf679c]

     # Return any other CITs and their respective CIs related to this CIT passed in
     # License Components = Service SLA Request - should have metrics in the SLA
     # CI name should contain the SLA Request ID
     # Record the datetime stamp (if required) in the description of the CI based on the instance of this CIT
     # Ticket creation date represents the date instance of service was created
     # SLA metrics should contain any time limitations of service consumption
     # When expired, customer to make a new ticket of SLA
     # SLA metrics could contain count 

     # Metrics CITs
     # Licensing Metrics | ID: bc660289-159d-f8c2-c759-54b6604fd630 (Child of Licensing CIT)
     # Service+SLA -> AccountsServicesSLA -> Service SLA Request
     # License Service SLA | ID: 2be3cda0-a296-9c0f-7598-54b8c5fc2c3f (Child of metrics CIT)

     $lic_object_type = "ConfigurationItems";
     $lic_action = "select";
     $lic_params[0] = " sclm_configurationitems_id_c='".$this_ci."' ";
     $lic_params[1] = "id,enabled,name,image_url,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
     $lic_params[2] = ""; // group;
     $lic_params[3] = ""; // order;
     $lic_params[4] = ""; // limit

     $lic_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lic_object_type, $lic_action, $lic_params);

     if (is_array($lic_array)){
 
        #var_dump($lic_array);

        #$inner_lics = "<font color=#151B54 size=3><B>Service SLA's & Requests for this License</font></B>";

        for ($cnt=0;$cnt < count($lic_array);$cnt++){

            $ci_id = $lic_array[$cnt]['id']; // CIT
            $ci_name = $lic_array[$cnt]['name']; // CIT Name

            $enabled = $lic_array[$cnt]['enabled']; 

             if ($enabled == 1){
                $enabled = "Yes";
                } else {
                $enabled = "No";
                }

            $ci_image_url = $lic_array[$cnt]['image_url'];
            $record_contact_id_c = $lic_array[$cnt]['contact_id_c'];
            $record_account_id_c = $lic_array[$cnt]['account_id_c'];
            $cit = $lic_array[$cnt]['sclm_configurationitemtypes_id_c'];

            if (!$ci_image_url){
               $lic_image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
               $ci_image_url = $lic_image_returner[7];
               }

            if ($ci_image_url != NULL){
               $ci_img = "<img src=".$ci_image_url." width=16 border=0>";
               }

            if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){

               $edit = "<a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$ci_id."&valuetype=ConfigurationItems&sendiv=lic');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($auth == 3){
               $show_id = " | ID: ".$ci_id;
               } else {
               $show_id = "";
               }

            # License Service SLA | ID: 2be3cda0-a296-9c0f-7598-54b8c5fc2c3f
            # This will pick up any 
            if ($cit == '2be3cda0-a296-9c0f-7598-54b8c5fc2c3f' && $ci_name != NULL){
               $label = "Service SLAs";
               $acc_service_sla_id = $ci_name;
               # $ci_name =  from dropdown of available ones (Service SLA's from Parent and Account's own)
               $lic_returner = $funky_gear->object_returner ("AccountsServicesSLAs", $ci_name);
               $service_sla_name = $lic_returner[0];
               $image_url = $lic_returner[7];

               if (!$image_url){
                  $lic_image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $cit);
                  $image_url = $lic_image_returner[7];
                  }
 
               #$inner_lics .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$service_sla_name;

               $inner_lics .= "<div style=\"".$divstyle_white."\"><img src=".$image_url." width=16><B>".$label.":</B> ".$service_sla_name;

              if ($valtype == 'Billing'){
                 $inner_lics .= "<BR>";
                 } else {
                 # No need to show to end users
                 $inner_lics .= "<BR>Enabled: ".$enabled."<BR>";
                 } 

              if ($valtype == 'Billing'){

                 # Collect any Service SLA Requests for this Service SLA for this Account

                 $slareq_object_type = 'ServiceSLARequests';
                 $slareq_action = "select";
                 $slareq_params[0] = "sclm_accountsservicesslas_id_c='".$acc_service_sla_id."' && account_id_c='".$sess_account_id."' ";
                 $slareq_params[1] = ""; // select array
                 $slareq_params[2] = ""; // group;
                 $slareq_params[3] = " sclm_accountsservicesslas_id_c,sclm_servicessla_id_c,sclm_services_id_c, name, date_entered DESC "; // order;
                 $slareq_params[4] = ""; // limit

                 $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

                 if (is_array($slareq_items)){

                    for ($slareq_cnt=0;$slareq_cnt < count($slareq_items);$slareq_cnt++){
             
                        $slareq_id = $slareq_items[$slareq_cnt]['id'];
                        $slareq_name = $slareq_items[$slareq_cnt]['name'];
                        $inner_lics .= "<div style=\"".$divstyle_blue."\">".$slareq_name;
                        $inner_lics .= "<BR>Tickets based on this SLA Request";

                        } # for

                    } else {# is array

                    $inner_lics .= "<div style=\"".$divstyle_blue."\">Set SLA Request for ".$service_sla_name;
                    #$inner_lics .= "<BR>Click here to Request";
                    /*
                    $req_params = "";
                    $req_params[0] = "checkbox";
                    $req_params[1] = $acc_service_sla_id;
                    $req_params[2] = $service_sla_name;
                    $req_params[3] = $do;
                    $req_params[4] = $id;
                    $req_params[5] = 'QuickSLAReqUpdates';
                    $req_params[6] = 'Click here to Request';

                    $slareq_setting = quick_slareq_updates ($req_params);

                    */
                    # Select from available prices for this

                    # Get the underlying sclm_servicessla_id_c to get pricing
                    # Should show for multiple services if cloning allowed
                    # Account affiliates?

                    $slaprices_object_type = 'AccountsServicesSLAs';
                    $slaprices_action = "select";
                    $slaprices_params[0] = "id='".$acc_service_sla_id."' ";
                    $slaprices_params[1] = "sclm_servicessla_id_c"; // select array
                    $slaprices_params[2] = ""; // group;
                    $slaprices_params[3] = " sclm_services_id_c,sclm_servicessla_id_c,account_id_c,name, date_entered DESC ";
                    $slaprices_params[4] = ""; // limit
  
                    $sla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slaprices_object_type, $slaprices_action, $slaprices_params);
                    if (is_array($sla_items)){

                       for ($sla_cnt=0;$sla_cnt < count($sla_items);$sla_cnt++){

                           $sclm_servicessla_id_c = $sla_items[$sla_cnt]['sclm_servicessla_id_c'];
                           $sclm_accountsservices_id_c = $sla_items[$sla_cnt]['sclm_accountsservices_id_c'];

                           } # for($sla_items)

                       # Collect any prices for the services
    
                       $slaprices_object_type = 'ServicesPrices';
                       $slaprices_action = "select";
                       $slaprices_params[0] = "sclm_servicessla_id_c='".$sclm_servicessla_id_c."' ";
                       $slaprices_params[1] = ""; // select array
                       $slaprices_params[2] = ""; // group;
                       $slaprices_params[3] = " sclm_services_id_c,sclm_servicessla_id_c,cmn_currencies_id_c,cmn_countries_id_c,cmn_languages_id_c,name, date_entered DESC ";
                       $slaprices_params[4] = ""; // limit
  
                       $slaprices_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slaprices_object_type, $slaprices_action, $slaprices_params);

                       if (is_array($slaprices_items)){

                          #$slareq_setting = "";

                          for ($slaprices_cnt=0;$slaprices_cnt < count($slaprices_items);$slaprices_cnt++){

                              $slaprices_id = $slaprices_items[$slaprices_cnt]['id'];
                              $slaprices_name = $slaprices_items[$slaprices_cnt]['name'];

                              if ($slareq_setting != NULL){

                                 $slareq_setting .= "<BR>";

                                 } # if

                              $slareq_setting .= $slaprices_name."<BR><a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=add&value=".$slaprices_id."&valuetype=ServicesPrices&sourcevaltype=AccountsServices&sourceval=".$sclm_accountsservices_id_c."&sendiv=lic');return false\"><font color=red><B>Request this SLA</B></font></a>";

                              } # for

                          } # is array

                       $inner_lics .= "<div style=\"".$divstyle_white."\">".$slareq_setting."</div>";

                       } # is array($sla_items)

                    #$slareq_setting = "<a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=add&value=".$acc_service_sla_id."&valuetype=AccountsServices&sendiv=lic');return false\"><font size=2 color=red>Click here to Request</font></a> ";

                    } # end if no SLA Requests
                 
                 switch ($service_sla_id){

                  case '':

                 } # end switch

                 $inner_lics .= "</div>";
                 $inner_lics .= "</div>";
                 #$inner_lics .= "</div></div>";

                 } else {

               $inner_lics .= $edit." <a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."<BR><B>License Service SLA:</B> <a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=2be3cda0-a296-9c0f-7598-54b8c5fc2c3f&valuetype=ConfigurationItemTypes&sendiv=lic&clonevaluetype=ConfigurationItems&clonevalue=".$service_sla_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                 } # if not billing

               } else {// if licbit_cit
               $service_sla_bits = FALSE;
               }

            } # for CI Level1

        } else {// end if is array

        # License Service SLA | ID: 2be3cda0-a296-9c0f-7598-54b8c5fc2c3f
        if ($valtype != 'Billing'){

           $inner_lics .= "<div style=\"".$divstyle_white."\"><B>License Service SLA:</B> <a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=2be3cda0-a296-9c0f-7598-54b8c5fc2c3f&valuetype=ConfigurationItemTypes&sendiv=lic&clonevaluetype=ConfigurationItems&clonevalue=".$service_sla_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

           } # Billing

        } // if not service_sla_bits

    return $inner_lics;

    } // end get_lics_components function

  # End slics function
  ##########################
  # Actions

  switch ($action){

   case 'list':

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Licensing</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    # Get License Instance
    $lic_object_type = "ConfigurationItems";
    $lic_action = "select";
    # Will loop through license instances based on admin selections of Service SLAs and accompanying Accounts Service SLA's
    # Currently only selectable by Admin - but prices can be selected by the user
    # Currently prices only set by Admin
    $lic_params[1] = "id,name,enabled,image_url,contact_id_c,account_id_c,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname";
    $lic_params[2] = ""; // group;
    $lic_params[3] = ""; // order;
    $lic_params[4] = ""; // limit
  
    $lic_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lic_object_type, $lic_action, $lic_params);

    #var_dump($lic_array);

    if (is_array($lic_array)){

       for ($cnt=0;$cnt < count($lic_array);$cnt++){

           $id = $lic_array[$cnt]['id']; // Instance ID
           $name = $lic_array[$cnt]['name']; // Instance Name
           $enabled = $lic_array[$cnt]['enabled']; 

           if ($enabled == 1){
              $enabled = "Yes";
              } else {
              $enabled = "No";
              }

           $record_contact_id_c = $lic_array[$cnt]['contact_id_c'];
           $record_account_id_c = $lic_array[$cnt]['account_id_c'];
           $image_url = $lic_array[$cnt]['image_url'];
           $sclm_configurationitems_id_c = $lic_array[$cnt]['sclm_configurationitems_id_c'];

           $edit = "";
           if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
              $edit = "<a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$id."&valuetype=ConfigurationItems&sendiv=lic&partype=".$lic_cit."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           if ($lic_array[$cnt][$lingoname] != NULL){
              $name = $lic_array[$cnt][$lingoname];
              }

           if ($auth == 3){
              $show_id = " | ID: ".$id;
              } else {
              $show_id = "";
              }

           $lics .= "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>License:</B> ".$name;

           if ($valtype == 'Billing'){
              $lics .= "<BR>";
              } else {
              # No need to show to end users
              $lics .= "<BR>Enabled: ".$enabled."<BR>";
              } 

           if ($valtype == 'Billing'){

              foreach ($lic_cit_array as $lic_key=>$lic_val){

                      $lic_params[0] = $id;
                      $lic_params[1] = $lic_val;
                      $lic_params[2] = $valtype;

                      $inner_lics = get_lics_components($lic_params);

                      } # foreach

              $lics .= $inner_lics."</div></div>";

              } else {

              $lics .= $edit."<a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$id."&valuetype=ConfigurationItems&sendiv=lic&partype=".$lic_cit."');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a> <a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=Licensing&action=build&value=".$id."&valuetype=Licensing&sendiv=lic');return false\"> <img src=images/icons/objects-16x16x32b.png width=16 border=0><font size=2 color=blue> <B>[".$strings["Build"]."]</B></font></a>".$show_id."</div></div>";

              } # end if not billing

           } // for Licenses

       if ($valtype != 'Billing'){

          $lics .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$default_lic_cit."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$id."&sendiv=lic&partype=".$lic_cit."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>License ->".$strings["action_addnew"]." Instance</B></font></a></div>";

          } # end if not billing

       } else {// if array

       # There should be a license for certain types - such as Services, SLAs.
       # Others can be added as wished
       if ($valtype != 'Billing'){

          # End customers only have access to licensing from Billing
          # Otherwise, Admin can get access from menu link and add new as required, or edit...

          $lics = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lic');doBPOSTRequest('lic','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$default_lic_cit."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=&sendiv=lic&partype=".$lic_cit."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>License ->".$strings["action_addnew"]."</B></font></a></div>";

          } # end if not billing

       } // end if lic Instances

    # End License presentation
    ########################################

    echo "<div style=\"".$divstyle_blue."\" name='lic' id='lic'></div>";

    echo $lics;

    #echo "<div style=\"".$divstyle_blue."\" name='lic' id='lic'><B>Hiroko, I love you.</B></div>";

   break;
   #
   ############################
   #
   case 'build':

    ########################################
    # Use License Instance to get components
    $licbit_object_type = "ConfigurationItems";
    $licbit_action = "select";
    $licbit_params[0] = " id='".$val."' ";
    $licbit_params[1] = "id,enabled, contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
    $licbit_params[2] = ""; // group;
    $licbit_params[3] = ""; // order;
    $licbit_params[4] = ""; // limit
  
    $licbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $licbit_object_type, $licbit_action, $licbit_params);

    if (is_array($licbits)){

       $icondivwidth = "16";
       $iconheight = "3";
       $rowdivwidth = "90%";

       for ($cntlic=0;$cntlic < count($licbits);$cntlic++){
 
           #$licbit_id = $licbits[$cntlic]['id'];

            $enabled = $licbits[$cntlic]['enabled']; 

             if ($enabled == 1){
                $enabled = "Yes";
                } else {
                $enabled = "No";
                }

           $record_contact_id_c = $licbits[$cntlic]['contact_id_c'];
           $record_account_id_c = $licbits[$cntlic]['account_id_c'];
           $licbit_cit = $licbits[$cntlic]['sclm_configurationitemtypes_id_c'];

           ##########################################
           # Use License to get Components
           $lic_params[0] = $val;
           $lic_params[1] = $licbit_cit;
           $lic_params[2] = $valtype;

           $lics = get_lics_components($lic_params);

           } // for licbits

       } // end if array

       # End Actions
       ##########################################


    #$lics = "<div style=\"".$divstyle_white."\">".$lics."</div>";

    echo $lics;

   break;

  } // end action switch



# break; // End
##########################################################
?>