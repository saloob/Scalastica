<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-08-12
# Page: Workflows.php 
##########################################################
# case 'Workflows':

/*
  # Security Checker
  $this_module = 'd1dc8a9a-03d2-d3a5-a5b4-52762db27594';
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

Flowchart Symbols

Action or Process Symbol | ID: bcb701a2-5be4-0bea-dd28-549b53fcbc83
Collate Symbol | ID: b749d139-9be3-f071-1e84-549b55463632
Connector Symbol | ID: 91300fe9-5fe2-fae9-7fe5-549b5422267c
Data Storage / Stored Data Symbol | ID: e4cb50da-700e-965b-3dcf-549b5692c8d2
Database Symbol | ID: aff3dd30-5a95-359b-cf97-549b56f8d6b1
Decision Symbol | ID: 2b73b13b-998c-e565-4827-549b53518dbd
Delay Symbol | ID: d1f0307f-b9dc-d3bd-1714-549b5513e74b
Display Symbol | ID: e5874943-4441-a963-3121-549b5604df2f
Document Symbol | ID: bfc7f3cd-ea69-67b8-5721-549b537784b1
Input/Output Symbol | ID: c35eaf59-114e-61da-e0b1-549b5451f6cd
Internal Storage Symbol | ID: f1be241f-c2e9-255c-b390-549b56732cf4
Loop Limit Symbol | ID: 93ca0c75-327d-9cfb-2a93-549b55fcba3b
Manual Input Symbol | ID: 74e00040-3128-3b1c-4186-549b540735c3
Manual Loop Symbol | ID: ecbaeb7e-6e25-489a-0281-549b552e223e
Merge Symbol | ID: 6ae4025f-4d36-3de3-5a0d-549b55554ecc
Multiple Documents Symbol | ID: ef321320-9723-395f-5c52-549b53e06d4c
Off Page | ID: 300ad5d0-275e-c8a1-7176-549b565859a5
Or Symbol | ID: 3d68d720-a537-90d5-8c22-549b544d8450
Preparation Symbol | ID: 9c97d3ce-21fb-ca66-7b76-549b54244d58
Sort Symbol | ID: f1bf678a-ea49-a29e-3d63-549b55464779
Start/End Symbol | ID: 3de7cb62-38fd-75c7-325c-549b53eabdef
Subroutine Symbol | ID: 1cfb7b7d-db66-0271-b9eb-549b55d5ea40
Summoning Junction Symbol | ID: e247c930-6a6f-2692-1a81-549b54683cc8

Workflow Actions

Execute Shell Script | ID: 72f92a8f-2af0-25e9-e3f4-549ad0a3606d
Initiate Another Workflow | ID: 7c285d55-2525-3d5a-20a1-549ad200e92e
Next Workflow Item (CIT) | ID: d420099f-3955-e6b5-caa0-549ad2652861
Requires Another CI | ID: 2be8d440-0fa3-0f01-2499-549a75193b61
Send Notification | ID: 4bc517d1-6de6-7601-6b68-549ad0c34f15
Use REST API | ID: 46c6b06c-a43e-164d-171c-549ad1f2dc26

Workflows

Account Set-up Workflow | ID: 42a7ccaf-180e-504b-c426-541249f85aed
Custom Workflows | ID: 29d89b45-819c-bef7-befb-549b654f4f7c
Customer Engagements | ID: b650878b-1a2c-d25f-834a-5498d97e6244
Requesting Service SLAs | ID: c1aac41e-7dd3-238d-5aaf-548d29106525
Service SLA Pricing | ID: 8b1b1a96-4348-9565-9629-548d2de65c3f
Support Partner Onboarding | ID: 322b2fba-8999-a31f-0341-54124919308f

*/


  $wf_params[0] = " deleted=0 ";

  if ($auth < 3){
     $wf_params[0] .= " && (contact_id_c='".$sess_contact_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
     } elseif ($auth > 2){
     #$object_return_params[0] .= " ";
     } 

  $wf_cit = '445201ad-ef42-5003-a68b-549a7477da63';
  $wf_cit_custom = '29d89b45-819c-bef7-befb-549b654f4f7c';
  $wf_cit_accounts = '42a7ccaf-180e-504b-c426-541249f85aed';
  $wf_cit_engagements  = 'b650878b-1a2c-d25f-834a-5498d97e6244';
  $wf_cit_sla_requests = 'c1aac41e-7dd3-238d-5aaf-548d29106525';
  $wf_cit_sla_pricing = '8b1b1a96-4348-9565-9629-548d2de65c3f';
  $wf_cit_partner_onboarding = '322b2fba-8999-a31f-0341-54124919308f';

  switch ($valtype){
   
   case '':

    $wf_params[0] .= " && sclm_configurationitemtypes_id_c='".$wf_cit_custom."' "; 
    $this_wf = $wf_cit;

    $default_wf_cit = $wf_cit_custom;

   break;
   case 'Accounts':

    # Parent Item has to be the Account ID.
    $wf_params[0] .= " && sclm_configurationitemtypes_id_c='".$wf_cit_accounts."' "; 
    $this_wf = $wf_cit_accounts;

    if ($auth < 3){
       //$object_return_params[0] .= " && (account_id_c='".$val."'  || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
       $wf_params[0] .= " && (account_id_c='".$val."' || cmn_statuses_id_c != '".$standard_statuses_closed."') "; 
       } else {
       $wf_params[0] .= " && account_id_c='".$val."' "; 
       } 

    $default_wf_cit = $wf_cit_accounts;

   break;
   case 'Engagements':    

    $wf_params[0] .= " && sclm_configurationitemtypes_id_c='".$wf_cit_engagements."' "; 
    $this_wf = $wf_cit_engagements;

    $default_wf_cit = $wf_cit_engagements;

   break;
   case 'SLARequests':    

    $wf_params[0] .= " && sclm_configurationitemtypes_id_c='".$wf_cit_sla_requests."' "; 
    $this_wf = $wf_cit_sla_requests;

    $default_wf_cit = $wf_cit_sla_requests;

   break;
   case 'SLAPricing':    

    $wf_params[0] .= " && sclm_configurationitemtypes_id_c='".$wf_cit_sla_pricing."' "; 
    $this_wf = $wf_cit_sla_pricing;

    $default_wf_cit = $wf_cit_sla_pricing;

   break;
   case 'PartnerOnboarding':    

    $wf_params[0] .= " && sclm_configurationitemtypes_id_c='".$wf_cit_partner_onboarding."' "; 
    $this_wf = $wf_cit_partner_onboarding;

    $default_wf_cit = $wf_cit_partner_onboarding;

   break;

  } //  end valtype switch

  switch ($action){

   case 'list':

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Workflows</B></font></center></div>";
    #echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    // Get Workflow Instance
    $wf_object_type = "ConfigurationItems";
    $wf_action = "select";

    $wf_params[1] = "id,name,image_url,contact_id_c,account_id_c,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,account_id_c,$lingoname"; // select array
    $wf_params[2] = ""; // group;
    $wf_params[3] = ""; // order;
    $wf_params[4] = ""; // limit
  
    $wf_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wf_object_type, $wf_action, $wf_params);

    if (is_array($wf_array)){

       for ($cnt=0;$cnt < count($wf_array);$cnt++){

           $id = $wf_array[$cnt]['id']; // Instance ID
           $name = $wf_array[$cnt]['name']; // Instance Name
           $record_contact_id_c = $wf_array[$cnt]['contact_id_c'];
           $record_account_id_c = $wf_array[$cnt]['account_id_c'];
           $image_url = $wf_array[$cnt]['image_url'];
           $sclm_configurationitems_id_c = $wf_array[$cnt]['sclm_configurationitems_id_c'];

           $edit = "";
           if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
              $edit = "<a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$id."&valuetype=ConfigurationItems&sendiv=WF&partype=".$wf_cit."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           if ($wf_array[$cnt][$lingoname] != NULL){
              $name = $wf_array[$cnt][$lingoname];
              }

           if ($auth == 3){
              $show_id = " | ID: ".$id;
              } else {
              $show_id = "";
              }

           $wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=".$image_url." width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>Workflow:</B> ".$name."<BR>".$edit."<a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$id."&valuetype=ConfigurationItems&sendiv=WF&partype=".$wf_cit."');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a> <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=Workflows&action=build&value=".$id."&valuetype=Workflows&sendiv=WF');return false\"><img src=images/icons/objects-16x16x32b.png width=16 border=0><font size=2 color=blue><B>[".$strings["Build"]."]</B></font></a>".$show_id."</div></div>";

           } // for Workflows

       $wfs .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$default_wf_cit."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$id."&sendiv=WF&partype=".$wf_cit."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Workflow ->".$strings["action_addnew"]."</B></font></a></div>";

       } else {// if array

       # There should be a workflow for certain types - such as Services, SLAs.
       # Others can be added as wished

       $wfs = "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$default_wf_cit."&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=&sendiv=WF&partype=".$wf_cit."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Workflow ->".$strings["action_addnew"]."</B></font></a></div>";

       } // end if WF Instances

    # End Workflow presentation
    ########################################

    echo "<div style=\"".$divstyle_blue."\" name='WF' id='WF'></div>";

    echo $wfs;

   break;
   #
   ############################
   #
   case 'build':

    function get_wfs_components($these_wf_params){

     global $divstyle_white,$divstyle_orange_light,$divstyle_blue,$BodyDIV,$portalcode,$valtype,$strings,$lingoname;

     $this_ci = $these_wf_params[0];
     $this_cit = $these_wf_params[1];

     # Return any other CITs and their respective CIs related to this CIT passed in

     $wf_object_type = "ConfigurationItemTypes";
     $wf_action = "select";
     $wf_params[0] = " sclm_configurationitemtypes_id_c='".$this_cit."' ";
     $wf_params[1] = "id,name,image_url,sclm_configurationitemtypes_id_c,$lingoname"; // select array
     $wf_params[2] = ""; // group;
     $wf_params[3] = ""; // order;
     $wf_params[4] = ""; // limit
   
     $wf_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wf_object_type, $wf_action, $wf_params);

     if (is_array($wf_array)){
 
        for ($cnt=0;$cnt < count($wf_array);$cnt++){

            $cit_id = $wf_array[$cnt]['id']; // CIT
            $cit_name = $wf_array[$cnt]['name']; // CIT Name
            $cit_image_url = $wf_array[$cnt]['image_url'];
            #$cit = $wf_array[$cnt]['sclm_configurationitemtypes_id_c'];
            if ($cit_image_url){
               $cit_img = "<img src=".$cit_image_url." width=16 border=0>";
               }

            $inner_wfs .= $cit_img." <font color=#151B54 size=3><B>".$cit_name."</font></B>";

            # Must get an instance of this CIT for this user if available and any related CI's using that as Par

            # Get the CIs for this - if any based on the account ID
            $wfci_object_type = "ConfigurationItems";
            $wfci_action = "select";
            $wfci_params[0] = " sclm_configurationitems_id_c='".$this_ci."' && sclm_configurationitemtypes_id_c='".$cit_id."'";
            $wfci_params[1] = "id,name,image_url,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
            $wfci_params[2] = ""; // group;
            $wfci_params[3] = ""; // order;
            $wfci_params[4] = ""; // limit
   
            $instance_exists = FALSE;

            $wfci_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wfci_object_type, $wfci_action, $wfci_params);

            if (is_array($wfci_array)){

               $inner_wfs .= "<BR>";

               for ($cicnt=0;$cicnt < count($wfci_array);$cicnt++){

                   $ci_id = $wfci_array[$cicnt]['id']; // CIT
                   $ci_name = $wfci_array[$cicnt]['name']; // CIT Name
                   $record_contact_id_c = $wfci_array[$cicnt]['contact_id_c'];
                   $record_account_id_c = $wfci_array[$cicnt]['account_id_c'];
                   $image_url = $wfci_array[$cicnt]['image_url'];
                   if ($image_url){
                      $ci_img = "<img src=".$image_url." width=16 border=0>";
                      }

                   if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$record_account_id_c)){
                      $edit = "<a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$ci_id."&valuetype=ConfigurationItems&sendiv=WF');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                      }

                   if ($auth == 3){
                      $show_id = " | ID: ".$ci_id;
                      } else {
                      $show_id = "";
                      }

                   $inner_wfs .= "<div style=\"".$divstyle_white."\">".$ci_img." ".$edit." ".$ci_name.$show_id."</div>";
                   $instance_exists = TRUE;

                   } // for

               } else {// if array

               # Instance for this CIT doesn't exist - allow to create one
               $inner_wfs .= " <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$cit_id."&valuetype=ConfigurationItemTypes&sendiv=WF&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>Create Instance</B></font></a><BR>";

               } 

/*
Workflow Actions | ID: 4d9be2de-bd32-c378-e42c-549a72a0f03d

Execute Shell Script | ID: 72f92a8f-2af0-25e9-e3f4-549ad0a3606d
Initiate Another Workflow | ID: 7c285d55-2525-3d5a-20a1-549ad200e92e
Next Workflow Item (CIT) | ID: d420099f-3955-e6b5-caa0-549ad2652861
Requires Another CI | ID: 2be8d440-0fa3-0f01-2499-549a75193b61
Send Notification | ID: 4bc517d1-6de6-7601-6b68-549ad0c34f15
Use REST API | ID: 46c6b06c-a43e-164d-171c-549ad1f2dc26
*/

             # Execute Shell Script | ID: 72f92a8f-2af0-25e9-e3f4-549ad0a3606d
             if ($this_cit == '72f92a8f-2af0-25e9-e3f4-549ad0a3606d' && $ci_name != NULL && $instance_exists){
                $label = $cit_name;
                # $ci_name = shellexec from dropdown of available ones (CIs)
                # Collect name of shellexec -> CI
                $wf_returner = $funky_gear->object_returner ("ConfigurationItems", $ci_name);
                $wf_name = $wf_returner[0];
                $wfimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
                $image_url = $wfimage_returner[7];
 
                $inner_wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$wf_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_name."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                } else {// if wfbit_cit
                $shellexec_bits = FALSE;
                }

             # Initiate Another Workflow | ID: 7c285d55-2525-3d5a-20a1-549ad200e92e
             if ($this_cit == '72f92a8f-2af0-25e9-e3f4-549ad0a3606d' && $ci_name != NULL && $instance_exists){
                $label = $cit_name;
                # $ci_name = usewf from dropdown of available ones (CIs)
                # Collect name of usewf -> CI
                $wf_returner = $funky_gear->object_returner ("ConfigurationItems", $ci_name);
                $wf_name = $wf_returner[0];
                $wfimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
                $image_url = $wfimage_returner[7];
 
                $inner_wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$wf_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_name."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                } else {// if wfbit_cit
                $usewf_bits = FALSE;
                }

             # Use API | ID: 46c6b06c-a43e-164d-171c-549ad1f2dc26
             if ($this_cit == '46c6b06c-a43e-164d-171c-549ad1f2dc26' && $ci_name != NULL && $instance_exists){
                $label = $cit_name;
                # $ci_name = REST API from dropdown of available ones (CIs)
                # Collect name of API -> CI
                $wf_returner = $funky_gear->object_returner ("ConfigurationItems", $ci_name);
                $wf_name = $wf_returner[0];
                $wfimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
                $image_url = $wfimage_returner[7];
 
                $inner_wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$wf_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_name."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                } else {// if wfbit_cit
                $api_bits = FALSE;
                }

             # Requires Another CI | ID: 2be8d440-0fa3-0f01-2499-549a75193b61
             if ($this_cit == '2be8d440-0fa3-0f01-2499-549a75193b61' && $ci_name != NULL && $instance_exists){
                $label = $cit_name;
                # $ci_name = REST API from dropdown of available ones (CIs)
                # Collect name of API -> CI
                $wf_returner = $funky_gear->object_returner ("ConfigurationItems", $ci_name);
                $wf_name = $wf_returner[0];
                $wfimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
                $image_url = $wfimage_returner[7];
 
                $inner_wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$wf_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_name."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                } else {// if wfbit_cit
                $requires_ci_bits = FALSE;
                }

             # Send Notification | ID: 4bc517d1-6de6-7601-6b68-549ad0c34f15
             if ($this_cit == '4bc517d1-6de6-7601-6b68-549ad0c34f15' && $ci_name != NULL && $instance_exists){
                $label = $cit_name;
                # $ci_name = REST API from dropdown of available ones (CIs)
                # Collect name of API -> CI
                $wf_returner = $funky_gear->object_returner ("ConfigurationItems", $ci_name);
                $wf_name = $wf_returner[0];
                $wfimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
                $image_url = $wfimage_returner[7];
 
                $inner_wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$wf_name."<BR>".$edit." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_name."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                } else {// if wfbit_cit
                $send_notif_bits = FALSE;
                }

             # Next Workflow Item (CIT) | ID: d420099f-3955-e6b5-caa0-549ad2652861
             if ($this_cit == 'd420099f-3955-e6b5-caa0-549ad2652861' && $ci_name != NULL && $instance_exists){
                $label = $cit_name;
                # $ci_name = REST API from dropdown of available ones (CIs)
                # Collect name of API -> CI
                $wf_returner = $funky_gear->object_returner ("ConfigurationItems", $ci_name);
                $wf_api = $wf_returner[0];
                $wfimage_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $this_cit);
                $image_url = $wfimage_returner[7];
 
                $inner_wfs .= "<div style=\"".$divstyle_white."\"><div style=\"width:".$iconwidth.";float:left;padding-top:".$iconheight.";\"><img src=".$image_url." width=16></div><div style=\"width:".$rowdivwidth.";float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$label.":</B> ".$wf_api."<BR>".$edit." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$ci_name."&valuetype=ConfigurationItems');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id." <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_name."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div></div>";

                } else {// if wfbit_cit
                $next_wf_item_bits = FALSE;
                }

            # Get the CITs for this - if any based on the account ID
            #$wfs .= get_wfs_components($cit_id);

            if (!$shellexec_bits && $instance_exists){
  
               # Use Shell Exe | ID: 72f92a8f-2af0-25e9-e3f4-549ad0a3606d

               $inner_wfs .= "<div style=\"".$divstyle_white."\"><B>Execute Shell Script:</B> <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
#&partype=72f92a8f-2af0-25e9-e3f4-549ad0a3606d

               } // if not shellexec_bits

            if (!$usewf_bits && $instance_exists){
  
               # Use Another WF | ID: 7c285d55-2525-3d5a-20a1-549ad200e92e

               $inner_wfs .= "<div style=\"".$divstyle_white."\"><B>Use Another Workflow:</B> <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
#&partype=7c285d55-2525-3d5a-20a1-549ad200e92e
               } // if not shellexec_bits


            if (!$api_bits && $instance_exists){
  
               # Use API | ID: 46c6b06c-a43e-164d-171c-549ad1f2dc26

               $inner_wfs .= "<div style=\"".$divstyle_white."\"><B>Use API:</B> <a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
#&partype=4d9be2de-bd32-c378-e42c-549a72a0f03d
               } // if not api_bits

            if (!$requires_ci_bits && $instance_exists){
  
               # Requires Another CI | ID: 2be8d440-0fa3-0f01-2499-549a75193b61

               $inner_wfs .= "<div style=\"".$divstyle_white."\"><B>Requires CI: </B><a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
#&partype=4d9be2de-bd32-c378-e42c-549a72a0f03d
               } // if not Requires Another CI

            if (!$send_notif_bits && $instance_exists){
  
               # Send Notification | ID: 4bc517d1-6de6-7601-6b68-549ad0c34f15

               $inner_wfs .= "<div style=\"".$divstyle_white."\"><B>Send Notification: </B><a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
#&partype=4d9be2de-bd32-c378-e42c-549a72a0f03d
               } // if not Requires Another CI

            if (!$next_wf_item_bits && $instance_exists){
  
               # Next Workflow Item (CIT) | ID: d420099f-3955-e6b5-caa0-549ad2652861

               $inner_wfs .= "<div style=\"".$divstyle_white."\"><B>Next Workflow Item: </B><a href=\"#\" onClick=\"loader('WF');doBPOSTRequest('WF','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$this_cit."&valuetype=ConfigurationItemTypes&sendiv=WF&clonevaluetype=ConfigurationItems&clonevalue=".$ci_id."&parent_ci=".$this_ci."');return false\"><img src=images/blank.gif width=5 height=5><img src=images/icons/plus.gif width=16> <font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
#&partype=4d9be2de-bd32-c378-e42c-549a72a0f03d
               } // if not Next Workflow Item (CIT)

            } // end for

        } // end if is array

    return $inner_wfs;

    } // end get_wfs_components function

    ########################################
    # Use Workflow Instance to get components
    $wfbit_object_type = "ConfigurationItems";
    $wfbit_action = "select";
    $wfbit_params[0] = " id='".$val."' ";
    $wfbit_params[1] = "id,contact_id_c,account_id_c,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
    $wfbit_params[2] = ""; // group;
    $wfbit_params[3] = ""; // order;
    $wfbit_params[4] = ""; // limit
  
    $wfbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wfbit_object_type, $wfbit_action, $wfbit_params);

    if (is_array($wfbits)){

       $icondivwidth = "16";
       $iconheight = "3";
       $rowdivwidth = "90%";

       for ($cntwf=0;$cntwf < count($wfbits);$cntwf++){
 
           $wfbit_id = $wfbits[$cntwf]['id'];
           $record_contact_id_c = $wfbits[$cntwf]['contact_id_c'];
           $record_account_id_c = $wfbits[$cntwf]['account_id_c'];
           $wfbit_cit = $wfbits[$cntwf]['sclm_configurationitemtypes_id_c'];

           ##########################################
           # Use Workflow to get Components
           $wf_params[0] = $val;
           $wf_params[1] = $wfbit_cit;

           $wfs = get_wfs_components($wf_params);

           } // for wfbits

       } // end if array

       # End Actions
       ##########################################


    $wfs = "<div style=\"".$divstyle_white."\">".$wfs."</div>";

    echo $wfs;

   break;

  } // end action switch


# break; // End Workflows
##########################################################
?>