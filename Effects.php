<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Index 
##########################################################
# case 'Effects':

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     #if (!$sendiv){
     #   $sendiv = $BodyDIV;
     #   }
     }

###################################
# Start Realpolitika Objects

/*

Normally, these objects would be created by an api - but have added here for expdiency

*/

  $source_object_id = "b7fad3bf-eb81-c556-0274-4e2ab5f5b529"; // Realpolitika
//  $shared_object_id = $val;

  switch ($valtype){

   case 'Causes':

     $source_object_id = "32de2c8a-9ac7-ddcd-e605-4df92f481822"; // normally call-back from API

   break;
   case 'ConstitutionArticles':

     $source_object_id = "f1efce15-dbd0-aede-ec39-4df888f8a2fd"; // normally call-back from API

   break;
   case 'ConstitutionalAmendments':

     $source_object_id = "6ec72a47-4075-69bf-54bd-51583cae4aab"; // normally call-back from API

   break;
   case 'Events':

     $source_object_id = "ac89ea60-b96f-406b-2d91-4df8887de347"; // normally call-back from API

   break;
   case 'PoliticalPartyPolicies':
   case 'GovernmentPolicies':

     $valtype = "GovernmentPolicies";
     $source_object_id = "b75057f8-0c8a-a273-f49d-4df4c97d2d49"; // normally call-back from API

   break;
   case 'Statutes':

     $source_object_id = "7031e472-c655-6f2b-d47b-4df546361968"; // normally call-back from API

   break;
   case 'LawCases':

     $source_object_id = "32587d87-ed26-bd4f-891a-4e089bf44c6d"; // normally call-back from API

   break;
   case 'Laws':

     $source_object_id = "a33493b3-4d7f-8464-8dad-517073cfb896"; // normally call-back from API

   break;
   case 'News':

     $source_object_id = "e8092d5b-ed02-726c-048d-4e61c3aaf2e2"; // normally call-back from API

   break;

  } // switch

# End Realpolitika Objects
###################################

if ($source_object_id){

   #$addsfxeffect = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=".$valtype."&source_object_id=".$source_object_id."&external_source_id=".$external_source_id."&action_name=".$action_name."');return false\"><font color=#151B54><B>".$strings["SideEffects_add_new_effect"]." for ".$action_name."</B></font></a></div>";

   // Find the action related to this object and any effects
   $check_action_object_type = "Events";
   $check_action = "select";
   $check_action_params = array();
   $check_action_params[0] = " source_object_id='".$source_object_id."' && object_id='".$val."' ";
   $check_action_params[1] = " id ";
   $check_action_params[2] = "";
   $check_action_params[3] = "";
   $check_action_params[3] = "";
   
   $check_events = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $check_action_object_type, $check_action, $check_action_params);

    if (is_array($check_events)){

       // get effects
       for ($cnt=0;$cnt < count($check_events);$cnt++){

           $sclm_events_id_c = $check_events[$cnt]['id'];

/*
           $name = $check_events[$cnt]['name'];
           $sfx_externalsources_id_c = $check_events[$cnt]['sfx_externalsources_id_c'];
           $contact_id_c = $check_events[$cnt]['contact_id_c'];
           $sfx_sourceobjects_id_c = $check_events[$cnt]['sfx_sourceobjects_id_c'];
           $sourceobject = $check_events[$cnt]['sourceobject'];
           $object_id = $check_events[$cnt]['object_id'];
*/
           $object_return_params[0] = " deleted=0 && sclm_events_id_c ='".$sclm_events_id_c."'";
//           $valtype = "Actions";
//           $val = $id;

           } // for

       } else {// if array

       #$object_return_params[0] = " deleted=0 && sclm_events_id_c ='mamamamamamamama' "; // nothing
       $object_return_params[0] = " deleted=0 "; // nothing

       }

   } // end if sfx_sourceobjects_id_c

  if (($valtype == 'Events' || $valtype == 'Effects') && $val != NULL){
     $object_return_params[0] .= " && sclm_events_id_c ='".$val."'";
     if ($action == 'add'){
        $sclm_events_id_c = $val;
        }
     }

  if ($action == 'view_related' || $action == 'list_aggregate'){
     $lister = 'list_aggregate';
     } else {
     $lister = 'list';
     } 

  $contentdiv = $_POST['contentdiv'];
  if (!$contentdiv){
     $contentdiv = $_GET['contentdiv'];
     }

  switch ($action){

   case $lister:
   case 'search':

   #########################
   # Related Events function

   function related_events ($related_params){

    global $funky_gear,$portalcode,$BodyDIV,$lingo,$strings,$divstyle_white,$standard_statuses_closed,$auth,$sess_contact_id ;

    $event_id = $related_params[0];
    $this_effects_stats_summary = $related_params[1];
    $total_count = $related_params[2];
    $lister = $related_params[3];
    $inner_id = $related_params[4];
    $sfx = $related_params[5];
    $total_positivity = $related_params[6];
    $total_probability = $related_params[7];

    $effects_vote_stats = $this_effects_stats_summary[0];
    $effects_stats = $this_effects_stats_summary[1];
    $packages = $this_effects_stats_summary[2];

    $sfx_object_type = "Events";
    $sfx_action = "select";

    if ($lister == 'list_aggregate' && $inner_id != ""){
       $sfx_params[0] = "sclm_events_id_c='".$event_id."'";
       } else {
       $sfx_params[0] = "id='".$event_id."'";
       }

    #echo "Query $sfx_params[0]<BR>";

    $sfx_params[1] = "";
    $sfx_params[2] = "";
    $sfx_params[3] = "";
   
    $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);

    if (is_array($effects)){
       #echo "Is array<BR>";

       for ($cnt=0;$cnt < count($effects);$cnt++){

           $event_image_url = "";

           $id = $effects[$cnt]['id'];
           $name = $effects[$cnt]['name'];
           $value_type_value = $effects[$cnt]['value'];
           $positivity = $effects[$cnt]['positivity'];
           $probability = $effects[$cnt]['probability'];

           $cmn_statuses_id_c = $effects[$cnt]['cmn_statuses_id_c'];

           $start_date = $effects[$cnt]['start_date'];

           $sclm_events_id_c = $effects[$cnt]['sclm_events_id_c'];
           $parent_event_name = $effects[$cnt]['parent_event_name'];

           $group_type_id = $effects[$cnt]['group_type_id'];
           $group_type = $effects[$cnt]['group_type_name'];

           $value_type_id = $effects[$cnt]['value_type_id'];
           $value_type = $effects[$cnt]['value_type_name'];

           $purpose_id = $effects[$cnt]['purpose_id'];
           $purpose = $effects[$cnt]['purpose'];

           $emotion_id = $effects[$cnt]['emotion_id'];
           $emotion = $effects[$cnt]['emotion'];

           $ethics_id = $effects[$cnt]['ethics_id'];
           $ethics = $effects[$cnt]['ethics'];

           $view_count = $effects[$cnt]['view_count'];

           $contact_id_c = $effects[$cnt]['contact_id_c'];

           if ($valtype == 'GlobalResults'){
              $contact = $strings["User"];    
              } else {
              $contact = $effects[$cnt]['contact_name'];    
              }

           $cmn_countries_id_c = $effects[$cnt]['cmn_countries_id_c'];
           $country = $funky_gear->makecountry ($cmn_countries_id_c,$portalcode,$BodyDIV,$lingo);

           $cmn_newscategories_id_c = $effects[$cnt]['cmn_newscategories_id_c'];
 
           $sibaseunit_id = $effects[$cnt]['sibaseunit_id'];
           $sibaseunit = $effects[$cnt]['sibaseunit'];

           $time_frame_id = $effects[$cnt]['time_frame_id'];
           $time_frame = $effects[$cnt]['time_frame'];

           $event_image_url = $effects[$cnt]['event_image_url'];

           $total_positivity = $total_positivity + $positivity;
           $total_count = $total_count + 1;
           $total_probability = $total_probability + $probability;

           # Check for admin
           if ($contact_id_c == $sess_contact_id && $sess_contact_id != NULL){
              $is_admin = TRUE;
              $show_content = 1;
              }

           $summary_params[0] = $id;
           $summary_params[1] = $name;
           $summary_params[2] = $contact_id_c;
           $summary_params[3] = $contact;
           $summary_params[4] = $probability;
           $summary_params[5] = $positivity;
           $summary_params[6] = $value_type_value;
           $summary_params[7] = $group_type_id;
           $summary_params[8] = $group_type;
           $summary_params[9] = $purpose_id;
           $summary_params[10] = $purpose;
           $summary_params[11] = $emotion_id;
           $summary_params[12] = $emotion;
           $summary_params[13] = $ethics_id;
           $summary_params[14] = $ethics;
           $summary_params[15] = $value_type_id;
           $summary_params[16] = $value_type;
           $summary_params[17] = $effects_vote_stats;
           $summary_params[18] = $effects_stats;
           $summary_params[19] = $packages;

           $this_effects_stats_summary = summarise ($summary_params);
           $effects_vote_stats = $this_effects_stats_summary[0];
           $effects_stats = $this_effects_stats_summary[1];
           $packages = $this_effects_stats_summary[2];

           # Prepare link bundle
           $total_positivity = $total_positivity + $positivity;
           $total_count = $total_count + 1 + $inner_counter;
           $total_probability = $total_probability + $probability;

           $used_events[] = $id;

           # Check for admin
           $edit = "";
           if (($sess_contact_id == $contact_id_c && $sess_contact_id != NULL) || $auth == 3){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit&value=".$id."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=2 color=RED><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $show_probability = ROUND($probability*100,2);

           $showdate = substr($start_date, 0, -9);

           if ($event_image_url){
              $startdiv = "<div style=\"float:left;margin-left:0px;float:left;width:20%;height:55px;border-radius:0px;padding-left:2px;padding-top:2px;padding-right:2px;padding-bottom:2px;overflow: hidden;\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$id."&valuetype=Effects');return false\"><img src=".$event_image_url." width=98%></a></center>";
              $middiv = "</div><div style=\"float:left;margin-left:0px;float:left;width:75%;height:55px;border-radius:0px;padding-left:2px;padding-top:2px;padding-right:2px;padding-bottom:2px;\">";
              $enddiv = "</div>";
              } else {
              $event_image_url = "";
              $startdiv = "";
              $middiv = "";
              $enddiv = "";
              } 

           $sfx .= "<div style=\"".$divstyle_white."\">".$startdiv.$middiv.$edit." <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$id."&valuetype=Effects&sendiv=".$BodyDIV."');return false\"><font color=#151B54 size=3><B>[".$time_frame."] ".$showdate." - ".$name."</B></font> (".$strings["Views"].": ".$view_count.") <font color=#151B54 size=2>[".$strings["Purpose"].": ".$purpose.", ".$strings["Probability"].": ".$show_probability."%, ".$strings["Positivity"].": ".$positivity.", ".$strings["AffectedGroupType"].": ".$group_type.", ".$strings["ValueType"].": ".$value_type."]</font></a>".$enddiv."</div>";

           #$group_type = $packages[0];
           #echo "Group Type: $group_type <BR>";

           # Repackage and do for any child events
           if ($lister == 'list_aggregate'){

              $this_related_params[0] = $id;
              $this_related_params[1] = $this_effects_stats_summary;
              $this_related_params[2] = $total_count;
              $this_related_params[3] = $lister;
              $this_related_params[4] = $lister;
              $this_related_params[5] = $sfx;
              $this_related_params[6] = $total_positivity;
              $this_related_params[7] = $total_probability;

              $this_related_returner = related_events ($this_related_params);
              $this_effects_stats_summary = $this_related_returner[0];
              #$inner_counter = $this_related_returner[1];

              $used_events_query = join(', ',$used_events);

              $ci_object_type = 'ConfigurationItems';
              $ci_action = "select";
              if (count($used_events)>1){
                 $ci_params[0] = "sclm_configurationitemtypes_id_c='e8fba75e-14a2-2056-f4ef-550b222f36fc' && name='".$id."' && name NOT IN ('$used_events_query') && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
                 } else {
                 $ci_params[0] = "sclm_configurationitemtypes_id_c='e8fba75e-14a2-2056-f4ef-550b222f36fc' && name='".$id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
                 }
              $ci_params[1] = "id,name"; // select array
              $ci_params[2] = ""; // group;
              $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
              $ci_params[4] = ""; // limit
  
              $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

              if (is_array($ci_items)){

                 for ($cnt=0;$cnt < count($ci_items);$cnt++){

                     $ci_wrapper_id = $ci_items[$cnt]['id'];

                     } # for

                 } # is array

              if ($ci_wrapper_id != NULL){

                 echo "ci_wrapper_id $ci_wrapper_id  <BR>";

                 # Gather any related items
                 $ci_events_object_type = 'ConfigurationItems';
                 $ci_events_action = "select";
                 if (count($used_events)>1){
                    $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && name NOT IN ('$used_events_query') && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
                    } else {
                    $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
                    }
                 #$ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' "; # parent
                 $ci_events_params[1] = "id,name"; // select array
                 $ci_events_params[2] = ""; // group;
                 $ci_events_params[3] = " name, date_entered DESC "; // order;
                 $ci_events_params[4] = ""; // limit
  
                 $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

                 if (is_array($ci_events_items)){          

                    for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

                        $ci_event_id = $ci_events_items[$ci_events_cnt]['id'];
                        $sclm_events_id_c = $ci_events_items[$ci_events_cnt]['name'];

                        $this_related_params[0] = $sclm_events_id_c;
                        $this_related_params[1] = $this_effects_stats_summary;
                        $this_related_params[2] = $total_count;
                        $this_related_params[3] = $lister;
                        $this_related_params[4] = $lister;
                        $this_related_params[5] = $sfx;
                        $this_related_params[6] = $total_positivity;
                        $this_related_params[7] = $total_probability;

                        $this_related_returner = related_events ($this_related_params);
                        $this_effects_stats_summary = $this_related_returner[0];

                        } # for

                    } # is array

                 } # is ci_wrapper_id

              # Get the reverse based on just wrapper - but not this particular event
              # Show backwards relationships that this event may be included in
              $ci_events_object_type = 'ConfigurationItems';
              $ci_events_action = "select";

              if (count($used_events)>1){

                 $ci_events_params[0] = "deleted=0 && name='".$id."' && name NOT IN ('$used_events_query') && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent

                 } else {

                 $ci_events_params[0] = "deleted=0 && name='".$id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
                 } 

              $ci_events_params[1] = "id,sclm_configurationitems_id_c"; // select array
              $ci_events_params[2] = ""; // group;
              $ci_events_params[3] = " name, date_entered DESC "; // order;
              $ci_events_params[4] = ""; // limit
  
              $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

              if (is_array($ci_events_items)){          

                 for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

                     $reverse_wrapper_id = $ci_events_items[$ci_events_cnt]['sclm_configurationitems_id_c'];

                     $ci_object_type = 'ConfigurationItems';
                     $ci_action = "select";
                     $ci_params[0] = "id='".$reverse_wrapper_id."' ";
                     $ci_params[1] = "id,name,account_id_c"; // select array
                     $ci_params[2] = ""; // group;
                     $ci_params[3] = " name, date_entered DESC "; // order;
                     $ci_params[4] = ""; // limit
  
                     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

                     if (is_array($ci_items)){          

                        for ($cnt=0;$cnt < count($ci_items);$cnt++){

                            $related_ci_id = $ci_items[$cnt]['id'];
                            $related_event_id = $ci_items[$cnt]['name'];

                            $this_related_params[0] = $related_event_id;
                            $this_related_params[1] = $this_effects_stats_summary;
                            $this_related_params[2] = $total_count;
                            $this_related_params[3] = $lister;
                            $this_related_params[4] = $lister;
                            $this_related_params[5] = $sfx;
                            $this_related_params[6] = $total_positivity;
                            $this_related_params[7] = $total_probability;
    
                            $this_related_returner = related_events ($this_related_params);
                            $this_effects_stats_summary = $this_related_returner[0];

                            } # for

                        } # is array

                     } # for

                 } # is array

              } # list aggregate 

           } # for

       } # is array

   $related_returner[0] = $this_effects_stats_summary;
   $related_returner[1] = $total_count;
   $related_returner[2] = $sfx;
   $related_returner[3] = $total_positivity;
   $related_returner[4] = $total_probability;

   return $related_returner;

   } # end function

   # Related Events function
   #########################
   # Summary function

   function summarise ($summary_params){

    global $funky_gear;

    $id = $summary_params[0];
    $name = $summary_params[1];
    $contact_id_c = $summary_params[2];
    $contact = $summary_params[3];
    $probability = $summary_params[4];
    $positivity = $summary_params[5];
    $value_type_value = $summary_params[6];
    $group_type_id = $summary_params[7];
    $group_type = $summary_params[8];
    $purpose_id = $summary_params[9];
    $purpose = $summary_params[10];
    $emotion_id = $summary_params[11];
    $emotion = $summary_params[12];
    $ethics_id = $summary_params[13];
    $ethics = $summary_params[14];
    $value_type_id = $summary_params[15];
    $value_type = $summary_params[16];
    $effects_vote_stats = $summary_params[17];
    $effects_stats = $summary_params[18];
    $re_packages = $summary_params[19];

    $group_type_package = $re_packages[0];
    $purpose_package = $re_packages[1];
    $emotions_package = $re_packages[2];
    $ethics_package = $re_packages[3];
    $value_type_package = $re_packages[4];

    #echo "group_type_package $group_type_package <BR>";

    ####################################
    # Check for voting power - per effect vote strength needs to be added

    $effect_object_type = "Votes";
    $effect_action = "select";
    $effect_params = array();
    $effect_params[0] = "sclm_events_id_c = '".$id."'";
    $effect_params[1] = "";
    $effect_params[2] = "";
    $effect_params[3] = "";
  
    $effects_votes = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $effect_object_type, $effect_action, $effect_params);
   
    if (is_array($effects_votes)){

       $effect_vote_count = count($effects_votes);

       $total_effect_vote_count = $total_effect_vote_count + $effect_vote_count;

       $effect_vote = "";
       $total_effect_vote = "";
       $total_effect_vote_positivity = "";
       $total_effect_vote_probability = "";

       for ($effects_cnt=0;$effects_cnt < count($effects_votes);$effects_cnt++){

           $effect_vote = $effects_votes[$effects_cnt]['vote'];
           $total_effect_vote = $total_effect_vote + $effect_vote;
           $total_effect_vote_positivity = $total_effect_vote_positivity + $positivity;
           $total_effect_vote_probability = $total_effect_vote_probability + $probability;

           } // for votes loop

       $total_average_vote = $total_effect_vote/$total_effect_vote_count;
       $total_average_vote_positivity = $total_effect_vote_positivity/$total_effect_vote_count;
       $total_average_vote_probability = $total_effect_vote_probability/$total_effect_vote_count;

       // When a value type is different - need to add them here and then present as stats..for loop again..
       $stats_type_label = "Vote(s)";
       $stats_label = $name;
       $stats_value = ($total_effect_vote*$effect_vote_count)*10;
       $item_count = $effect_vote_count; // make one when not comparing
       $positivity = ROUND(($total_effect_vote/$effect_vote_count),0);
       $stat_params = array();
       $stat_params[0] = "Votes";
       $stat_params[1] = "";

       $effects_vote_stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

       } // end if array of votes for effects

    #########################################
    # Collect by purposes, emotions, valuetypes
    # Start Contacts

    if ($contact_id_c != NULL){

       if (count($effects_stats['contacts'])>0){

          foreach ($effects_stats['contacts'] as $zakey => $zavalue){


                  $exists = FALSE;
                  $exists = $funky_gear->variable_id_checker ($effects_stats['contacts'],$contact_id_c);

                  if ($exists){


                     $effects_stats['contacts'][$contact_id_c]['contact_id_c'] = $contact_id_c;
                     $effects_stats['contacts'][$contact_id_c]['name'] = $contact;
                     $effects_stats['contacts'][$contact_id_c]['probability'] = $effects_stats['contacts'][$contact_id_c]['probability'] + $probability;
                     $effects_stats['contacts'][$contact_id_c]['positivity'] = $effects_stats['contacts'][$contact_id_c]['positivity'] + $positivity;
                     $effects_stats['contacts'][$contact_id_c]['value'] = $effects_stats['contacts'][$contact_id_c]['value'] + $value_type_value;

                     $effects_stats['contacts'][$contact_id_c]['count'] = $effects_stats['contacts'][$contact_id_c]['count'] + 1;

                     } else {

                     $effects_stats['contacts'][$contact_id_c]['contact_id_c'] = $contact_id_c;
                     $effects_stats['contacts'][$contact_id_c]['name'] = $contact;
                     $effects_stats['contacts'][$contact_id_c]['probability'] = $probability;
                     $effects_stats['contacts'][$contact_id_c]['positivity'] = $positivity;
                     $effects_stats['contacts'][$contact_id_c]['value'] = $value_type_value;
                     $effects_stats['contacts'][$contact_id_c]['count'] = 1;
                     $effects_stats['contacts'][$contact_id_c]['unique_count'] = $effects_stats['contacts'][$contact_id_c]['unique_count'] + 1;

                     }

                  } // foreach

          } else {

          $effects_stats['contacts'][$contact_id_c]['contact_id_c'] = $contact_id_c;
          $effects_stats['contacts'][$contact_id_c]['name'] = $contact;
          $effects_stats['contacts'][$contact_id_c]['probability'] = $probability;
          $effects_stats['contacts'][$contact_id_c]['positivity'] = $positivity;
          $effects_stats['contacts'][$contact_id_c]['value'] = $value_type_value;
          $effects_stats['contacts'][$contact_id_c]['count'] = 1;
          $effects_stats['contacts'][$contact_id_c]['unique_count'] = 1;

          } // if value but no count in the array - should add

       } // if is value

    # End Contacts
    #########################################
    # Start Group Types

    if ($group_type_id != NULL){

       if (count($effects_stats['sfx_group_types'])>0){

          foreach ($effects_stats['sfx_group_types'] as $zakey => $zavalue){

                  $exists = FALSE;
                  $exists = $funky_gear->variable_id_checker ($effects_stats['sfx_group_types'],$group_type_id);

                  if ($exists){

                     $effects_stats['sfx_group_types'][$group_type_id]['group_type_id'] = $group_type_id;
                     $effects_stats['sfx_group_types'][$group_type_id]['name'] = $group_type;
                     $effects_stats['sfx_group_types'][$group_type_id]['probability'] = $effects_stats['sfx_group_types'][$group_type_id]['probability'] + $probability;
                     $effects_stats['sfx_group_types'][$group_type_id]['positivity'] = $effects_stats['sfx_group_types'][$group_type_id]['positivity'] + $positivity;
                     $effects_stats['sfx_group_types'][$group_type_id]['value'] = $effects_stats['sfx_group_types'][$group_type_id]['value'] + $value_type_value;

                     $effects_stats['sfx_group_types'][$group_type_id]['count'] = $effects_stats['sfx_group_types'][$group_type_id]['count'] + 1;

                     } else {

                     $effects_stats['sfx_group_types'][$group_type_id]['group_type_id'] = $group_type_id;
                     $effects_stats['sfx_group_types'][$group_type_id]['name'] = $group_type;
                     $effects_stats['sfx_group_types'][$group_type_id]['probability'] = $probability;
                     $effects_stats['sfx_group_types'][$group_type_id]['positivity'] = $positivity;
                     $effects_stats['sfx_group_types'][$group_type_id]['value'] = $value_type_value;
                     $effects_stats['sfx_group_types'][$group_type_id]['count'] = 1;
                     $effects_stats['sfx_group_types'][$group_type_id]['unique_count'] = $effects_stats['sfx_group_types'][$group_type_id]['unique_count'] + 1;
                     $group_type_package = $group_type_package.", ".$group_type;

                     } # if exists

                  } # foreach

          } else {

          # if count = 0 
          $effects_stats['sfx_group_types'][$group_type_id]['group_type_id'] = $group_type_id;
          $effects_stats['sfx_group_types'][$group_type_id]['name'] = $group_type;
          $effects_stats['sfx_group_types'][$group_type_id]['probability'] = $probability;
          $effects_stats['sfx_group_types'][$group_type_id]['positivity'] = $positivity;
          $effects_stats['sfx_group_types'][$group_type_id]['value'] = $value_type_value;
          $effects_stats['sfx_group_types'][$group_type_id]['count'] = 1;
          $effects_stats['sfx_group_types'][$group_type_id]['unique_count'] = 1;

          $group_type_package = $group_type;

          } // if value but no count in the array - should add

       } // if is value

    # End Group Types
    #########################################
    # Start Purposes

    if ($purpose_id != NULL){

       if (count($effects_stats['sfx_purposes'])>0){

          foreach ($effects_stats['sfx_purposes'] as $zakey => $zavalue){

                  $exists = FALSE;
                  $exists = $funky_gear->variable_id_checker ($effects_stats['sfx_purposes'],$purpose_id);

                  if ($exists){

                     $effects_stats['sfx_purposes'][$purpose_id]['probability'] = $effects_stats['sfx_purposes'][$purpose_id]['probability'] + $probability;
                     $effects_stats['sfx_purposes'][$purpose_id]['positivity'] = $effects_stats['sfx_purposes'][$purpose_id]['positivity'] + $positivity;
                     $effects_stats['sfx_purposes'][$purpose_id]['value'] = $effects_stats['sfx_purposes'][$purpose_id]['value'] + $value_type_value;
                     $effects_stats['sfx_purposes'][$purpose_id]['name'] = $purpose;
                     $effects_stats['sfx_purposes'][$purpose_id]['count'] = $effects_stats['sfx_purposes'][$purpose_id]['count'] + 1;

                     } else {

                     $effects_stats['sfx_purposes'][$purpose_id]['name'] = $purpose;
                     $effects_stats['sfx_purposes'][$purpose_id]['probability'] = $probability;
                     $effects_stats['sfx_purposes'][$purpose_id]['positivity'] = $positivity;
                     $effects_stats['sfx_purposes'][$purpose_id]['value'] = $value_type_value;
                     $effects_stats['sfx_purposes'][$purpose_id]['count'] = 1;
                     $effects_stats['sfx_purposes'][$purpose_id]['unique_count'] = $effects_stats['sfx_purposes'][$purpose_id]['unique_count'] + 1;

                     $purpose_package = $purpose_package.", ".$purpose;

                     }

                  } // foreach

          } else {

          $effects_stats['sfx_purposes'][$purpose_id]['name'] = $purpose;
          $effects_stats['sfx_purposes'][$purpose_id]['probability'] = $probability;
          $effects_stats['sfx_purposes'][$purpose_id]['positivity'] = $positivity;
          $effects_stats['sfx_purposes'][$purpose_id]['value'] = $value_type_value;
          $effects_stats['sfx_purposes'][$purpose_id]['count'] = 1;
          $effects_stats['sfx_purposes'][$purpose_id]['unique_count'] = 1;

          $purpose_package = $purpose;

          } // if value but no count in the array - should add

       } // if is value

    # End Purposes
    #########################################
    # Start Emotions

    if ($emotion_id != NULL){

       if (count($effects_stats['sfx_emotions'])>0){

          foreach ($effects_stats['sfx_emotions'] as $zakey => $zavalue){

                  $exists = FALSE;
                  $exists = $funky_gear->variable_id_checker ($effects_stats['sfx_emotions'],$emotion_id);

                  if ($exists){


                     $effects_stats['sfx_emotions'][$emotion_id]['probability'] = $effects_stats['sfx_emotions'][$emotion_id]['probability'] + $probability;
                     $effects_stats['sfx_emotions'][$emotion_id]['positivity'] = $effects_stats['sfx_emotions'][$emotion_id]['positivity'] + $positivity;
                     $effects_stats['sfx_emotions'][$emotion_id]['value'] = $effects_stats['sfx_emotions'][$emotion_id]['value'] + $value_type_value;

                     $effects_stats['sfx_emotions'][$emotion_id]['name'] = $emotion;
                     $effects_stats['sfx_emotions'][$emotion_id]['count'] = $effects_stats['sfx_emotions'][$emotion_id]['count'] + 1;

                     } else {

                     $effects_stats['sfx_emotions'][$emotion_id]['name'] = $emotion;
                     $effects_stats['sfx_emotions'][$emotion_id]['probability'] = $probability;
                     $effects_stats['sfx_emotions'][$emotion_id]['positivity'] = $positivity;
                     $effects_stats['sfx_emotions'][$emotion_id]['value'] = $value_type_value;
                     $effects_stats['sfx_emotions'][$emotion_id]['count'] = 1;
                     $effects_stats['sfx_emotions'][$emotion_id]['unique_count'] = $effects_stats['sfx_emotions'][$emotion_id]['unique_count'] + 1;

                     $emotions_package = $emotions_package.", ".$emotion;

                     }

                  } // foreach

          } else {

          $effects_stats['sfx_emotions'][$emotion_id]['name'] = $emotion;
          $effects_stats['sfx_emotions'][$emotion_id]['probability'] = $probability;
          $effects_stats['sfx_emotions'][$emotion_id]['positivity'] = $positivity;
          $effects_stats['sfx_emotions'][$emotion_id]['value'] = $value_type_value;
          $effects_stats['sfx_emotions'][$emotion_id]['count'] = 1;
          $effects_stats['sfx_emotions'][$emotion_id]['unique_count'] = 1;

          $emotions_package = $emotion;

          } // if value but no count in the array - should add

       } // if is value

    # End Emotions
    #########################################
    # Start Ethics

    if ($ethics_id != NULL){

       if (count($effects_stats['sfx_ethics'])>0){

          foreach ($effects_stats['sfx_ethics'] as $zakey => $zavalue){

                  $exists = FALSE;
                  $exists = $funky_gear->variable_id_checker ($effects_stats['sfx_ethics'],$ethics_id);

                  if ($exists){

                     $effects_stats['sfx_ethics'][$ethics_id]['probability'] = $effects_stats['sfx_ethics'][$ethics_id]['probability'] + $probability;
                     $effects_stats['sfx_ethics'][$ethics_id]['positivity'] = $effects_stats['sfx_ethics'][$ethics_id]['positivity'] + $positivity;
                     $effects_stats['sfx_ethics'][$ethics_id]['value'] = $effects_stats['sfx_ethics'][$ethics_id]['value'] + $value_type_value;
                     $effects_stats['sfx_ethics'][$ethics_id]['name'] = $ethics;
                     $effects_stats['sfx_ethics'][$ethics_id]['count'] = $effects_stats['sfx_ethics'][$ethics_id]['count'] + 1;

                     } else {

                     $effects_stats['sfx_ethics'][$ethics_id]['name'] = $ethics;
                     $effects_stats['sfx_ethics'][$ethics_id]['probability'] = $probability;
                     $effects_stats['sfx_ethics'][$ethics_id]['positivity'] = $positivity;
                     $effects_stats['sfx_ethics'][$ethics_id]['value'] = $value_type_value;
                     $effects_stats['sfx_ethics'][$ethics_id]['count'] = 1;
                     $effects_stats['sfx_ethics'][$ethics_id]['unique_count'] = $effects_stats['sfx_ethics'][$ethics_id]['unique_count'] + 1;

                     $ethics_package = $ethics_package.", ".$ethics;

                     }

                  } // foreach

          } else {

          $effects_stats['sfx_ethics'][$ethics_id]['name'] = $ethics;
          $effects_stats['sfx_ethics'][$ethics_id]['probability'] = $probability;
          $effects_stats['sfx_ethics'][$ethics_id]['positivity'] = $positivity;
          $effects_stats['sfx_ethics'][$ethics_id]['value'] = $value_type_value;
          $effects_stats['sfx_ethics'][$ethics_id]['count'] = 1;
          $effects_stats['sfx_ethics'][$ethics_id]['unique_count'] = 1;

          $ethics_package = $ethics;

          } // if value but no count in the array - should add

       } // if is value

    # End Ethics
    #########################################
    # Start Value Types

    if ($value_type_id != NULL){

       if (count($effects_stats['sfx_valuetypes'])>0){

          foreach ($effects_stats['sfx_valuetypes'] as $zakey => $zavalue){

                  $exists = FALSE;
                  $exists = $funky_gear->variable_id_checker ($effects_stats['sfx_valuetypes'],$value_type_id);

                  if ($exists){

                     $effects_stats['sfx_valuetypes'][$value_type_id]['probability'] = $effects_stats['sfx_valuetypes'][$value_type_id]['probability'] + $probability;

                     $effects_stats['sfx_valuetypes'][$value_type_id]['positivity'] = $effects_stats['sfx_valuetypes'][$value_type_id]['positivity'] + $positivity;

                     $effects_stats['sfx_valuetypes'][$value_type_id]['value'] = $effects_stats['sfx_valuetypes'][$value_type_id]['value'] + $value_type_value;

                     $effects_stats['sfx_valuetypes'][$value_type_id]['name'] = $value_type;
                     $effects_stats['sfx_valuetypes'][$value_type_id]['count'] = $effects_stats['sfx_valuetypes'][$value_type_id]['count'] + 1;

                     } else {

                     $effects_stats['sfx_valuetypes'][$value_type_id]['name'] = $value_type;
                     $effects_stats['sfx_valuetypes'][$value_type_id]['probability'] = $probability;
                     $effects_stats['sfx_valuetypes'][$value_type_id]['positivity'] = $positivity;
                     $effects_stats['sfx_valuetypes'][$value_type_id]['value'] = $value_type_value;
                     $effects_stats['sfx_valuetypes'][$value_type_id]['count'] = 1;

                     $value_type_package = $value_type_package.", ".$value_type;

                     } # exists

                  } // foreach

          } else {

          $effects_stats['sfx_valuetypes'][$value_type_id]['name'] = $value_type;
          $effects_stats['sfx_valuetypes'][$value_type_id]['probability'] = $probability;
          $effects_stats['sfx_valuetypes'][$value_type_id]['positivity'] = $positivity;
          $effects_stats['sfx_valuetypes'][$value_type_id]['value'] = $value_type_value;
          $effects_stats['sfx_valuetypes'][$value_type_id]['count'] = 1;

          $value_type_package = $value_type;

          } // if value but no count in the array - should add and if is value

       } // if is value

    # End Value Types
    #########################################

    $packages[0] = $group_type_package;
    $packages[1] = $purpose_package;
    $packages[2] = $emotions_package;
    $packages[3] = $ethics_package;
    $packages[4] = $value_type_package;

    $summary[0] = $effects_vote_stats;
    $summary[1] = $effects_stats;
    $summary[2] = $packages;

    return $summary;

   } # end summary function

   # End Summary function
   #########################

   if ($sendiv == 'lightform'){
      echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
      }

   $sfx_object_type = "Events";
   $sfx_action = "select";
   $sfx_params = array();

   if ($action != 'search'){
      $object_return_params[0] .= " && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
      }

   if ($action == 'search'){

      $search_date = $_POST['search_date'];
      if (!$search_date){
         $search_date = $_GET['search_date'];
         }

      $search_keyword = $_POST['keyword'];
      if ($search_keyword == NULL){
         $search_keyword = $_GET['keyword'];
         }

      if ($search_keyword != NULL){
         $search_keyword = str_replace("'", "\\'", $search_keyword);
         #$search_keyword = mysql_real_escape_string($search_keyword);
         $object_return_params[0] = " (description like '%".$search_keyword."%' || name like '%".$search_keyword."%' )";
         }

      if ($search_date != NULL){
         $object_return_params[0] .= " && start_date like '%".$search_date."%' ";
         } 

      if ($auth < 3){

         $object_return_params[0] .= " && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";

         } # end auth

      } // if action search

   if ($valtype == 'Contacts' && $val != NULL && $action == 'list' && $sess_contact_id == $val){
      $object_return_params[0] = " deleted=0 && contact_id_c='".$val."' ";
      }

   $sfx_params[0] = $object_return_params[0];
   $sfx_params[1] = "id,name,sclm_events_id_c";
   $sfx_params[2] = "";
   $sfx_params[3] = " start_date DESC ";

   $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);

   $effects_stats['sfx_valuetypes'] = array();

   if (is_array($effects)){

      # Do nothing

      } else {

      if ($valtype == 'Effects' && $val != NULL){
         $sfx_params[0] = " id ='".$val."' ";
         $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);
         }

      } # is array

   if (is_array($effects)){

      $count = count($effects);
      $page = $_POST['page'];
      $glb_perpage_items = 30;

      $extraparams[0] = "&contentdiv=contentdiv";
      $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,"contentdiv",$extraparams);
      $lfrom = $navi_returner[0];
      $navi = $navi_returner[1];

      $sfx_params = array();
      $sfx_params[0] = $object_return_params[0];
      $sfx_params[1] = "id,name,sclm_events_id_c";
      $sfx_params[2] = "";
      $sfx_params[3] = " start_date DESC ";
      $sfx_params[4] = " $lfrom , $glb_perpage_items ";

      for ($cnt=0;$cnt < count($effects);$cnt++){

          $id = $effects[$cnt]['id'];

          # Begin the loop 
          $outer_related_params[0] = $id;
          $outer_related_params[1] = $effects_stats_summary;
          $outer_related_params[2] = $total_count;
          $outer_related_params[3] = $lister;
          $outer_related_params[4] = "";
          $outer_related_params[5] = $sfx;
          $outer_related_params[6] = $total_positivity;
          $outer_related_params[7] = $total_probability;

          $outer_effects_stats_returner = related_events ($outer_related_params);
          $effects_stats_summary = $outer_effects_stats_returner[0];
          $total_count = $outer_effects_stats_returner[1];
          $sfx = $outer_effects_stats_returner[2];
          $total_positivity = $outer_effects_stats_returner[3];
          $total_probability = $outer_effects_stats_returner[4];

          $event_name = $effects[$cnt]['name'];

          $sclm_events_id_c = $effects[$cnt]['sclm_events_id_c'];
          $parent_event_name = $effects[$cnt]['parent_event_name'];

          if ($cnt == 0){
             $parent_event_name = $parent_event_name;
             }

           } // end for

      # Unbundle
      $effects_vote_stats = $effects_stats_summary[0];
      $effects_stats = $effects_stats_summary[1];
      $packages = $effects_stats_summary[2];

      $group_type_package = $packages[0];
      $purpose_package = $packages[1];
      $emotions_package = $packages[2];
      $ethics_package = $packages[3];
      $value_type_package = $packages[4];

      # End Data Loop
      #########################################
      # Begin Report Presentation
      #########################################
      # Start Group Types Report

    if ($contentdiv != 'contentdiv'){

       $stats = "";
       $group_types_stats = "";

      foreach ($effects_stats['sfx_group_types'] as $key => $value){
   
              $total_sfx_group_types_probability = $total_sfx_group_types_probability + $value['probability'];
              $total_sfx_group_types_positivity = $total_sfx_group_types_positivity + $value['positivity'];
              $total_sfx_group_types_value = $total_sfx_group_types_value + $value['value'];
              $total_sfx_group_types_count = $total_sfx_group_types_count + $value['count'];
              $total_sfx_group_types_unique_count = $total_sfx_group_types_unique_count + $value['unique_count'];

              // When a value type is different - need to add them here and then present as stats..for loop again..
              $stats_type_label = $strings["Score(s)"];
              $stats_label = $value['name'];
              $stats_value = $value['probability'];
              $item_count = $value['count']; // make one when not comparing
              $positivity = ROUND($value['positivity']/$value['count'],0);
              $stat_params = array();
              $stat_params[0] = $strings["Probability"];
              $stat_params[1] = "";

              $stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

              } // end foreach

      $group_types_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["GroupTypes"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";
      $group_types_stats .= $stats."</table>";
      $report_breakdown .= $group_types_stats;

      // Value Type Totals
      $stats_type_label = $strings["Score(s)"];
      $stats_label = $strings["GroupTypes"]." ".$strings["Total"];
      $stats_value = $total_sfx_group_types_probability;
      $item_count = $total_sfx_group_types_count; // make one when not comparing
      $positivity = ROUND(($total_sfx_group_types_positivity/$total_sfx_group_types_count),0);
      $stat_params = "";
      $stat_params = array();
      $stat_params[0] = $strings["Probability"];
      $stat_params[1] = "";

      $total_sfx_group_types_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

      $total_group_types_stats .= "<table width=100%>".$total_sfx_group_types_stats."</table>";
      $report_breakdown .= $total_group_types_stats;

      # End Group Types Report
      #########################################
      # Start Contacts Report

      $stats = "";
      $contacts_stats = "";

      foreach ($effects_stats['contacts'] as $key => $value){
   
              $total_sfx_contacts_probability = $total_sfx_contacts_probability + $value['probability'];
              $total_sfx_contacts_positivity = $total_sfx_contacts_positivity + $value['positivity'];
              $total_sfx_contacts_value = $total_sfx_contacts_value + $value['value'];
              $total_sfx_contacts_count = $total_sfx_contacts_count + $value['count'];
              $total_sfx_contacts_unique_count = $total_sfx_contacts_unique_count + $value['unique_count'];

              // When a value type is different - need to add them here and then present as stats..for loop again..
              $stats_type_label = $strings["Score(s)"];
              $stats_label = $value['name'];
              $stats_value = $value['probability'];
              $item_count = $value['count']; // make one when not comparing
              $positivity = ROUND($value['positivity']/$value['count'],0);
              $stat_params = array();
              $stat_params[0] = $strings["Probability"];
              $stat_params[1] = "";

              $stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

              } // end foreach

      $contacts_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["Users"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";
      $contacts_stats .= $stats."</table>";
      $report_breakdown .= $contacts_stats;

      // Value Type Totals
      $stats_type_label = $strings["Score(s)"];
      $stats_label = $strings["Users"]." ".$strings["Total"];
      $stats_value = $total_sfx_contacts_probability;
      $item_count = $total_sfx_contacts_count; // make one when not comparing
      $positivity = ROUND(($total_sfx_contacts_positivity/$total_sfx_contacts_count),0);
      $stat_params = "";
      $stat_params = array();
      $stat_params[0] = $strings["Probability"];
      $stat_params[1] = "";

      $total_sfx_contacts_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);
      $total_contacts_stats .= "<table width=100%>".$total_sfx_contacts_stats."</table>";
      $report_breakdown .= $total_contacts_stats;

      # End Contacts Report
      #########################################
      # Start Emotions Report

      $stats = "";
      $emotions_stats = "";

      foreach ($effects_stats['sfx_emotions'] as $key => $value){
   
              $total_sfx_emotions_probability = $total_sfx_emotions_probability + $value['probability'];
              $total_sfx_emotions_positivity = $total_sfx_emotions_positivity + $value['positivity'];
              $total_sfx_emotions_value = $total_sfx_emotions_value + $value['value'];
              $total_sfx_emotions_count = $total_sfx_emotions_count + $value['count'];
              $total_sfx_emotions_unique_count = $total_sfx_emotions_unique_count + $value['unique_count'];

//echo "total_sfx_emotions_unique_count: ".$total_sfx_emotions_unique_count."<BR>";

              // When a value type is different - need to add them here and then present as stats..for loop again..
              $stats_type_label = $strings["Score(s)"];
              $stats_label = $value['name'];
              $stats_value = $value['probability'];
              $item_count = $value['count']; // make one when not comparing
              $positivity = ROUND($value['positivity']/$value['count'],0);
              $stat_params = array();
              $stat_params[0] = $strings["Probability"];
              $stat_params[1] = "";

              $stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

              } // end foreach

      if ($total_sfx_emotions_count >0){ 

         $emotions_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["Emotions"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";

         $emotions_stats .= $stats."</table>";
         $report_breakdown .= $emotions_stats;

         // Value Type Totals
         $stats_type_label = $strings["Score(s)"];
         $stats_label = $strings["Emotions"]." ".$strings["Total"];
         $stats_value = $total_sfx_emotions_probability;
         $item_count = $total_sfx_emotions_count; // make one when not comparing
         $positivity = ROUND(($total_sfx_emotions_positivity/$total_sfx_emotions_count),0);
         $stat_params = "";
         $stat_params = array();
         $stat_params[0] = $strings["Probability"];
         $stat_params[1] = "";

         $total_sfx_emotions_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);
         $total_emotions_stats .= "<table width=100%>".$total_sfx_emotions_stats."</table>";
         $report_breakdown .= $total_emotions_stats;

         }

      # End Emotions Report
      #########################################
      # Start Ethics Report

      $stats = "";
      $ethics_stats = "";

      if (is_array($effects_stats['sfx_ethics'])){

         foreach ($effects_stats['sfx_ethics'] as $key => $value){

                 $total_sfx_ethics_probability = $total_sfx_ethics_probability + $value['probability'];
                 $total_sfx_ethics_positivity = $total_sfx_ethics_positivity + $value['positivity'];
                 $total_sfx_ethics_value = $total_sfx_ethics_value + $value['value'];
                 $total_sfx_ethics_count = $total_sfx_ethics_count + $value['count'];
                 $total_sfx_ethics_unique_count = $total_sfx_ethics_unique_count + $value['unique_count'];

                 // When a value type is different - need to add them here and then present as stats..for loop again..
                 $stats_type_label = $strings["Score(s)"];
                 $stats_label = $value['name'];
                 $stats_value = $value['probability'];
                 $item_count = $value['count']; // make one when not comparing
                 $positivity = ROUND($value['positivity']/$value['count'],0);
                 $stat_params = array();
                 $stat_params[0] = $strings["Probability"];
                 $stat_params[1] = "";

                 $stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

                 } // end foreach

         if ($total_sfx_ethics_count >0){ 

            $ethics_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["Ethics"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";
           $ethics_stats .= $stats."</table>";
           $report_breakdown .= $ethics_stats;

           // Value Type Totals
           $stats_type_label = $strings["Score(s)"];
           $stats_label = $strings["Ethics"]." ".$strings["Total"];
           $stats_value = $total_sfx_ethics_probability;
           $item_count = $total_sfx_ethics_count; // make one when not comparing
           $positivity = ROUND(($total_sfx_ethics_positivity/$total_sfx_ethics_count),0);
           $stat_params = "";
           $stat_params = array();
           $stat_params[0] = $strings["Probability"];
           $stat_params[1] = "";

           $total_sfx_ethics_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);
           $total_ethics_stats .= "<table width=100%>".$total_sfx_ethics_stats."</table>";
           $report_breakdown .= $total_ethics_stats;

           }

         }

      # End Ethics Report
      #########################################
      # Start Purposes Report

      $stats = "";
      $purposes_stats = "";

      foreach ($effects_stats['sfx_purposes'] as $key => $value){

              $total_sfx_purposes_probability = $total_sfx_purposes_probability + $value['probability'];
              $total_sfx_purposes_positivity = $total_sfx_purposes_positivity + $value['positivity'];
              $total_sfx_purposes_value = $total_sfx_purposes_value + $value['value'];
              $total_sfx_purposes_count = $total_sfx_purposes_count + $value['count'];
              $total_sfx_purposes_unique_count = $total_sfx_purposes_unique_count + $value['unique_count'];

              // When a value type is different - need to add them here and then present as stats..for loop again..
              $stats_type_label = $strings["Score(s)"];
              $stats_label = $value['name'];
              $stats_value = $value['probability'];
              $item_count = $value['count']; // make one when not comparing
              $positivity = ROUND($value['positivity']/$value['count'],0);
              $stat_params = array();
              $stat_params[0] = $strings["Probability"];
              $stat_params[1] = "";

              $stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

              } // end foreach

      $purposes_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["Purposes"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";
      $purposes_stats .= $stats."</table>";
      $report_breakdown .= $purposes_stats;

      // Value Type Totals
      $stats_type_label = $strings["Score(s)"];
      $stats_label = $strings["Purposes"]." ".$strings["Total"];
      $stats_value = $total_sfx_purposes_probability;
      $item_count = $total_sfx_purposes_count; // make one when not comparing
      $positivity = ROUND(($total_sfx_purposes_positivity/$total_sfx_purposes_count),0);
      $stat_params = "";
      $stat_params = array();
      $stat_params[0] = $strings["Probability"];
      $stat_params[1] = "";

      $total_sfx_purposes_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

      $total_purposes_stats .= "<table width=100%>".$total_sfx_purposes_stats."</table>";
      $report_breakdown .= $total_purposes_stats;

      # End Purposes Report
      #########################################
      # Start Value Types Report

      $stats = "";
      $valuetype_stats = "";

      foreach ($effects_stats['sfx_valuetypes'] as $key => $value){
 
              // Only need the value-based value types - others already covered

              if ($key == 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2' || $key == '3566a485-0183-48a8-231b-54fd6e931b93' || $key == '19896b1b-d790-88b8-a2b4-54fd6eb21986' || $key == '5f803ea1-354c-800e-2cc7-54fd6e65da42' || $key == 'a308ec04-abe4-8121-14bb-54fd6e6d0a00' || $key == '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281' || $key == '1e81858f-ba15-a8c1-fc96-54fd6e510f39' || $key == 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe'){

                 $total_sfx_valuetypes_probability = $total_sfx_valuetypes_probability + $value['probability'];
                 $total_sfx_valuetypes_positivity = $total_sfx_valuetypes_positivity + $value['positivity'];
                 $total_sfx_valuetypes_value = $total_sfx_valuetypes_value + $value['value'];
                 $total_sfx_valuetypes_count = $total_sfx_valuetypes_count + $value['count'];
/*
                  $total_probability = $total_probability + $value['probability'];
                  $total_positivity = $total_positivity + $value['positivity'];
                  $total_value = $total_value + $value['value'];
                  $total_count = $total_count + $value['count'];
*/
                 // When a value type is different - need to add them here and then present as stats..for loop again..
                 $stats_type_label = $strings["Score(s)"];
                 $stats_label = $value['name'];
                 $stats_value = $value['probability'];
                 $item_count = $value['count']; // make one when not comparing
                 $positivity = ROUND($value['positivity']/$value['count'],0);
                 $stat_params = array();
                 $stat_params[0] = $strings["value"];
                 $stat_params[1] = number_format(ROUND($value['value'],0),0);


/*
            case 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2': # Monetary - P & L - Expense
            case '3566a485-0183-48a8-231b-54fd6e931b93': # Monetary - P & L - Revenue
            case '19896b1b-d790-88b8-a2b4-54fd6eb21986': # Monetary - B/S - Asset
            case '5f803ea1-354c-800e-2cc7-54fd6e65da42': # Monetary - B/S - Liability
            case 'a308ec04-abe4-8121-14bb-54fd6e6d0a00': # Monetary - General
            case '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281': # Quantity or Amount
            case '1e81858f-ba15-a8c1-fc96-54fd6e510f39': # Urgency
            case 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe': # Importance

*/
                 if ($key == 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe'){
                    $importance = $importance+$value['value'];
                    $importance_probability = $importance_probability+$value['probability'];
                    $importance_positivity = $importance_positivity+$value['positivity'];
                    $importance_count = $importance_count+$value['count'];

//echo "<P>Probability: ".$value['probability']."<P>";
                    $stats_value = ($value['value']*$value['probability'])/$value['count'];
                    $stats_value = $stats_value*10;
//echo "<P>Stats Value: ".$stats_value."<P>";
                    $stats_type_label = "Rating(s)"; //$strings["Score(s)"];
                    $stats_label = $strings["Importance"];
                    $positivity = ROUND($value['positivity']/$value['count'],0);
//                     $positivity = $importance_positivity/$importance_count;
                    $stat_params = array();
                    $stat_params[0] = $strings["Importance"];
                    $stat_params[1] = "";

                    $importance_stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$value['count'],$positivity,$stat_params);

                    }

                 if ($key == '1e81858f-ba15-a8c1-fc96-54fd6e510f39'){

                    $urgency = $urgency+$value['value'];

                    $stats_value = ($value['value']*$value['probability'])/$value['count'];
                    $stats_value = $stats_value*10;

                    $urgency_probability = $urgency_probability+$value['probability'];
                    $urgency_positivity = $urgency_positivity+$value['positivity'];
                    $urgency_count = $urgency_count+$value['count'];

                    $stats_type_label = "Rating(s)"; //$strings["Score(s)"];
                    $stats_label = $strings["Urgency"];
                    $positivity = ROUND($value['positivity']/$value['count'],0);
                    $stat_params = array();
                    $stat_params[0] = $strings["Urgency"];
                    $stat_params[1] = "";

                    $urgency_stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$value['count'],$positivity,$stat_params);

                    }


                 if ($key == '3566a485-0183-48a8-231b-54fd6e931b93'){
                    $quantity = $quantity+$value['value'];
                    $quantity_probability = $quantity_probability+$value['probability'];
                    $quantity_positivity = $quantity_positivity+$value['positivity'];
                    $quantity_count = $quantity_count+$value['count'];
                    }

                 if ($key == 'a308ec04-abe4-8121-14bb-54fd6e6d0a00'){
                    $general = $general+$value['value'];
                    $general_probability = $general_probability+$value['probability'];
                    $general_positivity = $general_positivity+$value['positivity'];
                    $general_count = $general_count+$value['count'];
                    }

                 if ($key == '3566a485-0183-48a8-231b-54fd6e931b93'){
                    $revenue = $revenue+$value['value'];
                    }

                 if ($key == 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2'){
                    $expenses = $expenses+$value['value'];
                    }

                 $profit_loss = $profit_loss+$revenue-$expenses;

                 if ($key == '3566a485-0183-48a8-231b-54fd6e931b93' || $key == 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2'){
                    $profit_loss_probability = $profit_loss_probability+$value['probability'];
                    $profit_loss_positivity = $profit_loss_positivity+$value['positivity'];
                    $profit_loss_count = $profit_loss_count+$value['count'];
                    }

                 if ($key == '19896b1b-d790-88b8-a2b4-54fd6eb21986'){
                    $assets = $assets+$value['value'];
                    }

                 if ($key == '5f803ea1-354c-800e-2cc7-54fd6e65da42'){
                    $liabilities = $liabilities+$value['value'];
                    }

                 $balance_sheet = $balance_sheet+$assets-$liabilities;

                 if ($key == '19896b1b-d790-88b8-a2b4-54fd6eb21986' || $key == '5f803ea1-354c-800e-2cc7-54fd6e65da42'){
                    $balance_sheet_probability = $balance_sheet_probability+$value['probability'];
                    $balance_sheet_positivity = $balance_sheet_positivity+$value['positivity'];
                    $balance_sheet_count = $balance_sheet_count+$value['count'];
                    }

                 $stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);
   
                 } // if monetary of figures

              } // end foreach

      if ($urgency_count>0){

         $urgencyfinal_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["Urgency"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";
         $urgencyfinal_stats .= $urgency_stats."</table>";
         $report_breakdown .= $urgencyfinal_stats;

         }

      if ($importance_count>0){

         $importancefinal_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["Importance"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";
         $importancefinal_stats .= $importance_stats."</table>";
         $report_breakdown .= $importancefinal_stats;

         }

      if ($total_average_vote>0){

         // When a value type is different - need to add them here and then present as stats..for loop again..
         $stats_type_label ="Total Votes";
         $stats_label = "Votes";
         $positivity = ROUND($total_average_vote_positivity,0);
/*
echo "total_average_vote ".$total_average_vote."<BR>";
echo "total_average_vote_positivity ".$total_average_vote_positivity."<BR>";
echo "total_average_vote_probability ".$total_average_vote_probability."<BR>";
*/
         #$stats_value = ROUND(($total_average_vote*$total_effect_vote_count)*10,0);
         $stats_value = ROUND(($total_average_vote)*10,0);
         $stat_params = array();
         $stat_params[0] = "Votes";
         $stat_params[1] = "";

         $effects_vote_stats .= $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$total_effect_vote_count,$positivity,$stat_params);
         $effects_votefinal_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>Vote Strength</B></font></center></font></div>
                </div>
               </td>
              </tr>";
         $effects_votefinal_stats .= $effects_vote_stats."</table>";
         $report_breakdown .= $effects_votefinal_stats;

         }

      if ($balance_sheet_count>0 || $profit_loss_count>0 || $quantity_count>0 || $general_count>0){       

         $valuetype_stats = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:".$portal_header_colour.";\">
                 <div style=\"float:left;padding-top:3px;width:25px;\"></div>
                 <div style=\"float:left;width:100%;padding-left:5px;margin-top:1px;margin-bottom:3px;\"><center><font size=3><B>".$strings["ValueTypes"]."</B></font></center></font></div>
                </div>
               </td>
              </tr>";

         $valuetype_stats .= $stats."</table>";
         $report_breakdown .= $valuetype_stats;

         }

      if ($profit_loss_count>0){
         $stats_type_label = $strings["Score(s)"];
         $stats_label = "Profit/Loss";
         $stats_value = $profit_loss_probability;
         $item_count = $profit_loss_count; // make one when not comparing
         $positivity = ROUND(($profit_loss_positivity/$profit_loss_count),0);
         $stat_params = array();
         $stat_params[0] = $strings["value"];
         $stat_params[1] = number_format(ROUND($profit_loss,0),0);
         $profit_loss_valuetypes_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);
   
         $total_profit_loss .= "<table width=100%>".$profit_loss_valuetypes_stats."</table>";
         $report_breakdown .= $total_profit_loss;
         }

      if ($balance_sheet_count>0){
         $stats_type_label = $strings["Score(s)"];
         $stats_label = "Balance Sheet";
         $stats_value = $balance_sheet_probability;
         $item_count = $balance_sheet_count; // make one when not comparing
         $positivity = ROUND(($balance_sheet_positivity/$balance_sheet_count),0);
         $stat_params = array();
         $stat_params[0] = $strings["value"];
         $stat_params[1] = number_format(ROUND($balance_sheet,0),0);
         $balance_sheet_valuetypes_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

         $total_balance_sheet .= "<table width=100%>".$balance_sheet_valuetypes_stats."</table>";
         $report_breakdown .= $total_balance_sheet;
         }

      if ($quantity_count>0){
         $stats_type_label = $strings["Score(s)"];
         $stats_label = "Quantity/Amount";
         $stats_value = $quantity_probability;
         $item_count = $quantity_count; // make one when not comparing
         $positivity = ROUND(($quantity_positivity/$quantity_count),0);
         $stat_params = array();
         $stat_params[0] = $strings["value"];
         $stat_params[1] = number_format(ROUND($quantity,0),0);
         $quantity_valuetypes_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

         $total_quantity .= "<table width=100%>".$quantity_valuetypes_stats."</table>";
         $report_breakdown .= $total_quantity;
         }

      if ($general_count>0){
         $stats_type_label = $strings["Score(s)"];
         $stats_label = "General Figures";
         $stats_value = $general_probability;
         $item_count = $general_count; // make one when not comparing
         $positivity = ROUND(($general_positivity/$general_count),0);
         $stat_params = array();
         $stat_params[0] = $strings["value"];
         $stat_params[1] = number_format(ROUND($general,0),0);
         $general_valuetypes_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

         $total_general .= "<table width=100%>".$general_valuetypes_stats."</table>";
         $report_breakdown .= $total_general;
         }

      if ($valuetype_stats != NULL){ 

         // Value Type Totals
         $stats_type_label = $strings["Score(s)"];
         $stats_label = $strings["ValueTypes"]." ".$strings["Total"];
         $stats_value = $total_sfx_valuetypes_probability;
         $item_count = $total_sfx_valuetypes_count; // make one when not comparing
         $positivity = ROUND(($total_sfx_valuetypes_positivity/$total_sfx_valuetypes_count),0);
         $stat_params = "";
         $stat_params = array();
         $stat_params[0] = $strings["value"];
         $stat_params[1] = "";

         $total_sfx_valuetypes_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

         $total_valuetypes_stats .= "<table width=100%>".$total_sfx_valuetypes_stats."</table>";
         $report_breakdown .= $total_valuetypes_stats;

         }

      # End Value Types Report
      #########################################
      # Start Final Report

      //echo "total_positivity: ".$total_positivity."<P>";

//      $positivity = ROUND(($total_positivity/$total_count)*100,0);
      $positivity = ROUND(($total_positivity/$total_count),0);

      if ($positivity>0){
         $final_positivity = "<font color=blue><B>".$strings["FinalReport_PositiveValueOf"].$positivity."</B></font>";
         } else {
         $final_positivity = "<font color=red><B>".$strings["FinalReport_NegativeValueOf"].$positivity."</B></font>";
         }

      if ($total_sfx_contacts_unique_count<2){
         $people_believe = $strings["FinalReport_PersonBelieves"];
         } else {
         $people_believe = $strings["FinalReport_PeopleBelieve"];
         }

      $total_probability = ROUND(($total_probability/$total_count)*100,2);

      if ($total_sfx_ethics_unique_count == 1){
         $ethics_shown = ", valuing one type of ethics ($ethics_package)";
         }
      if ($total_sfx_ethics_unique_count > 1){
         $ethics_shown = ", valuing a mixture of $total_sfx_ethics_unique_count ethics ($ethics_package)";
         }

      if ($total_sfx_emotions_unique_count == 1){
         $emotions_shown = ", expressing one emotion ($emotions_package)";
         }

      if ($total_sfx_emotions_unique_count > 1){
         $emotions_shown = ", expressing a mixture of $total_sfx_emotions_unique_count emotions ($emotions_package)";
         }


      # Create Effects Map
/*
       if ($valtype != 'GlobalResults'){

           if ($mapper_sclm_events_id_c != NULL){

              $map_params[0] = $mapper_sclm_events_id_c;
              $map_params[1] = 'Actions';
              $map_params[2] = $mapper_event_name;
              $map_params[3] = $mapper_id;
              $map_params[4] = $mapper_name;
              $map_params[5] = "";
              $map_params[6] = //array($mapper_sclm_events_id_c);
              $map_params[7] = //array($id);
              $map_params[8] = 1;
              $map_params[9] = "";
              $effects_map = $funky_gear->effects_mapper($map_params);

              }

              $map_params[0] = $mapper_id;
              $map_params[1] = 'Effects';
              $map_params[2] = $mapper_name;
              $map_params[3] = $mapper_id;
              $map_params[4] = $mapper_name;
              $map_params[5] = $effects_map;
              $map_params[6] = //array($sclm_events_id_c);
              $map_params[7] = //array($id);
              $map_params[8] = 1;
              $map_params[9] = //array($mapper_id);
              $effects_map = $funky_gear->effects_mapper($map_params);

 
           # Create Effects Map
           ####################################

             echo "<P><div style=\"".$divstyle_white."\">".$effects_map."</div>";

          } // if not global results
*/


      $container = "";  
      $container_top = "";
      $container_middle = "";
      $container_bottom = "";

      $container_params[0] = 'open'; // container open state
      $container_params[1] = $bodywidth; // container_width
      $container_params[2] = $bodyheight; // container_height
      #$container_params[3] = $go_last_month." <- Calendar"; // container_title
      $container_params[3] = $strings["SharedEffects"]; // container_title
      $container_params[4] = 'SharedEffects'; // container_label
      $container_params[5] = $portal_info; // portal info
      $container_params[6] = $portal_config; // portal configs
      $container_params[7] = $strings; // portal configs
      $container_params[8] = $lingo; // portal configs

      $container = $funky_gear->make_container ($container_params);

      $container_top = $container[0];
      $container_middle = $container[1];
      $container_bottom = $container[2];

      echo $container_top;
 
      if ($action == 'list' && $val == NULL || $action == 'search'){
         $parent_event_name = $strings["GlobalResults"];
         } elseif ($valtype == 'Contacts' && $val != NULL){
         $parent_event_name = "all my events";
         } 

      $advice = "<font size=3>".$strings["FinalReport_AccordingToThe"].$total_count.$strings["FinalReport_EffectsSubmitted"].$total_sfx_group_types_unique_count.$strings["FinalReport_GroupTypes"]."(".$group_type_package."), ".$total_sfx_contacts_unique_count.$people_believe.$total_probability.$strings["FinalReport_Probability"]."<B>\"".$parent_event_name."\"</B>".$strings["FinalReport_WillHaveAnAverage"].$final_positivity.$emotions_shown.$ethics_shown.".</font>";

      echo "<P><div><div style=\"background-image:url(images/AlbertEinsteinHead.png);margin-left:0px;float:left;width:150px;height:156px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\"></div><div style=\"margin-left:10px;float:left;width:300px;min-height:150px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\">".$advice."</div></div>";

      echo "<img src=images/blank.gif width=98% height=1>";

      echo "<P><div><div style=\"margin-left:0px;float:left;width:80px;min-height:60px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\"><center><a href='images/PositiveNegativeScale.png' rel=lightbox[Positive Negative Scale] title=\"Positive Negative Scale\"><img alt='Positive Negative Scale' src='images/PositiveNegativeScale.png' width='65' border='0' /></a></center></div><div style=\"margin-left:10px;float:left;width:380px;min-height:60px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\">".$strings["FinalReport_SeeBelow"]."</div></div>";

      echo $report_breakdown;

      echo $container_bottom;

      } # if not contentdiv

      # End Report Presentation
      #########################################
      # Close of the Array if data 

      } else { // end if (is_array($effects)){

        if ($valtype != 'GlobalResults'){
           $sfx = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";
           }

      } // end if array

   #########################################
   # Begin Closing Rows Presentation

   $subs = "";

   if ($val != NULL && $addsfxeffect == NULL && $sess_contact_id != NULL){
      # Empty list but sent from Effects or Actions
      $subs .= "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=Effects&sendiv=lightform');return false\"><font color=#151B54><B>".$strings["SideEffects_add_subeffect"]."</B></font></a></div>";

      }

   if (!$valtype){
      $valtype = 'Events';
      }

   if ($sess_contact_id != NULL){
     
      $addsfxeffect .= "<P>".$subs;

      } else {
      
      $addsfxeffect = "<P><div style=\"".$divstyle_orange_light."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
      }

   if ($valtype != 'GlobalResults'){

      ################################
      # Start Content

      $container = "";  
      $container_top = "";
      $container_middle = "";
      $container_bottom = "";

      $container_params[0] = 'open'; // container open state
      $container_params[1] = $bodywidth; // container_width
      $container_params[2] = $bodyheight; // container_height
      $container_params[3] = $strings["Search"]; // container_title
      $container_params[4] = 'Search'; // container_label
      $container_params[5] = $portal_info; // portal info
      $container_params[6] = $portal_config; // portal configs
      $container_params[7] = $strings; // portal configs
      $container_params[8] = $lingo; // portal configs

      $container = $funky_gear->make_container ($container_params);
  
      $container_top = $container[0];
      $container_middle = $container[1];
      $container_bottom = $container[2];

      $date = date("Y@m@d@G");
      $body_sendvars = $date."#Bodyphp";
      $body_sendvars = $funky_gear->encrypt($body_sendvars);

      $search_keyword = str_replace("\\'", "'", $search_keyword);

      $action_search_keyword = $strings["action_search_keyword"];
      $action_search = $strings["action_search"];

$effsearch = <<< EFFSEARCH
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="text" id="keyword" placeholder="$action_search_keyword" name="keyword" value="$search_keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="pg" name="pg" value="$body_sendvars" >
     <input type="hidden" id="value" name="value" value="$val" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="$do" >
     <input type="hidden" id="valuetype" name="valuetype" value="$valtype" >
     <input type="button" name="button" value="$action_search" onclick="javascript:loader('$BodyDIV');get(this.parentNode);return false" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
EFFSEARCH;

    if ($contentdiv != 'contentdiv'){
       echo $container_top;
       echo $effsearch;
       echo $container_bottom;
       echo "<P><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Individual Shared Effects Submissions</B></font></center></div><P>";
       }

      echo "<div id=contentdiv name=contentdiv style=\"margin-left:auto;margin-right:auto\"><center>".$navi.$addsfxeffect.$sfx.$navi."</center></div>";
      }

    # End Closing Rows Presentation
    #########################################

   break; // end list
   ##############################################################################################
   case 'view':
   case 'view_related':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    #echo "Val $val <P>";

    $object_type = "Events";
    $effects_action = "select";
    $effects_params = array();
    $effects_params[0] = "deleted=0 && id='".$val."' ";
    $effects_params[1] = "";
    $effects_params[2] = "";
    $effects_params[3] = "";

    $sideeffects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $effects_action, $effects_params);

    if (is_array($sideeffects)){

       for ($cnt=0;$cnt < count($sideeffects);$cnt++){
           //$id = $sideeffects[$cnt]['id'];
           $event_name = $sideeffects[$cnt]['name'];
           $start_date = $sideeffects[$cnt]['start_date'];
           $end_date = $sideeffects[$cnt]['end_date'];

           $description = $sideeffects[$cnt]['description'];
           $description = str_replace("\n", "<br>", $description);

           $value_type_value = $sideeffects[$cnt]['value'];
           $positivity = $sideeffects[$cnt]['positivity'];
           $probability = $sideeffects[$cnt]['probability'];
           $probability = $probability*100;

           $cmn_statuses_id_c = $sideeffects[$cnt]['cmn_statuses_id_c'];

           $sclm_events_id_c = $sideeffects[$cnt]['sclm_events_id_c'];
           $parent_event_name = $sideeffects[$cnt]['parent_event_name'];

           $group_type_id = $sideeffects[$cnt]['group_type_id'];
           $group_type = $sideeffects[$cnt]['group_type_name'];

           $value_type_id = $sideeffects[$cnt]['value_type_id'];
           $value_type = $sideeffects[$cnt]['value_type_name'];

           $purpose_id = $sideeffects[$cnt]['purpose_id'];
           $purpose = $sideeffects[$cnt]['purpose'];

           $emotion_id = $sideeffects[$cnt]['emotion_id'];
           $emotion = $sideeffects[$cnt]['emotion'];

           $ethics_id = $sideeffects[$cnt]['ethics_id'];
           $ethics = $sideeffects[$cnt]['ethics'];

           $view_count = $sideeffects[$cnt]['view_count'];
           $new_viewcount = $view_count+1;
           #$view_count_show = "[".$strings["Views"].": ".$new_viewcount."]";

           $account_id_c = $sideeffects[$cnt]['account_id_c'];
           $contact_id_c = $sideeffects[$cnt]['contact_id_c'];
           $contact = $sideeffects[$cnt]['contact_name'];

           $cmn_languages_id_c = $sideeffects[$cnt]['cmn_languages_id_c'];
           $cmn_countries_id_c = $sideeffects[$cnt]['cmn_countries_id_c'];

           $cmn_currencies_id_c = $sideeffects[$cnt]['cmn_currencies_id_c'];
           $currency = $sideeffects[$cnt]['currency'];

           $sibaseunit_id = $sideeffects[$cnt]['sibaseunit_id'];
           $sibaseunit = $sideeffects[$cnt]['sibaseunit'];

           $time_frame_id = $sideeffects[$cnt]['time_frame_id'];
           $time_frame = $sideeffects[$cnt]['time_frame'];

           $category_id = $sideeffects[$cnt]['category_id'];

           $event_image_url = $sideeffects[$cnt]['event_image_url'];

           $start_years = $sideeffects[$cnt]['start_years'];
           $end_years = $sideeffects[$cnt]['end_years'];

           $allow_joiners = $sideeffects[$cnt]['allow_joiners'];

           // Add View Count
           $vote_object_type = "Events";
           $vote_action = "update";
           $vote_params = array();  
           $vote_params = array(
               array('name'=>'id','value' => $val),
               array('name'=>'view_count','value' => $new_viewcount),
            );

           $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $vote_object_type, $vote_action, $vote_params);

           // Collect the vote scores for this side effect to add some perspective to it..

       # Current SideEffect either by initial parent action or another parent side-effect
       if ($sclm_events_id_c != NULL && $sclm_events_id_c != "" && $sclm_events_id_c != "NULL"){

          $par_object_type = "Events";
          $par_effects_action = "select";
          $par_effects_params = array();
          $par_effects_params[0] = "deleted=0 && id='".$sclm_events_id_c."' ";
          $par_effects_params[1] = "";
          $par_effects_params[2] = "";
          $par_effects_params[3] = "";

          $par_sideeffects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $par_object_type, $par_effects_action, $par_effects_params);

          if (is_array($par_sideeffects)){

             for ($parcnt=0;$parcnt < count($par_sideeffects);$parcnt++){
                 //$id = $sideeffects[$cnt]['id'];
                 $par_cmn_statuses_id_c = $par_sideeffects[$parcnt]['cmn_statuses_id_c'];

                 } # for

             } # is array

          } # if par

       if ($sclm_events_id_c != NULL && $sclm_events_id_c != "" && $sclm_events_id_c != "NULL" && ($sess_account_id != NULL && $sess_account_id==$account_id_c || $par_cmn_statuses_id_c != $standard_statuses_closed)){

          $this_returner = $funky_gear->object_returner ("Effects", $sclm_events_id_c);
          $object_return_name = $this_returner[0];
          $object_return = $this_returner[1];
          $object_return_title = $this_returner[2];
          $object_return_target = $this_returner[3];

          $parent_event_name = $object_return_target;

          } else {

          $this_returner = $funky_gear->object_returner ("Effects", $val);
          $object_return_name = $this_returner[0];
          $object_return = $this_returner[1];
          $object_return_title = $this_returner[2];
          $object_return_target = $this_returner[3];

          $parent_event_name = "None";

          } 

           if ($sess_contact_id == $contact_id_c || $auth == 3){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=2 color=RED><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $effect = "<div style=\"".$divstyle_white."\">";
           $effect .= "<div style=\"margin-left:4px;margin-right:4px;float:left; background: ".$body_color.";min-width:98%;min-height:100px;border:0;overflow:auto;\">";

           if ($sess_contact_id != NULL){

              $share_button = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"share\" id=\"share\" value=\"Share Event\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=Messages&action=add&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\">";

              # Social Networks

              $sn_params[0] = $do;
              $sn_params[1] = $val;
              $sn_params[2] = $account_id_c;
              $sn_params[3] = $contact_id_c;
              $sn_params[4] = $sess_account_id;
              $sn_params[5] = $sess_contact_id;

              #$social_network = $funky_gear->check_sn ($sn_params);
              #$status = $social_network[0];
              #$sn_button = $social_network[1];

              #$event_sn = "4e4233fd-bd1b-cf45-8baa-55220aeeadea";

              #$effect .= "<center>".$share_button." - ".$sn_button."</center><P>";
              $effect .= "<center>".$share_button."</center><P>";

              } # if contact

           $effect .= $strings["SideEffects_VotingMessage"]."<P>";

           $effect .= "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view_related&value=".$val."&valuetype=Effects');return false\"><font size=3 color=#151B54><B>Show All Related Shared Effects</B></font></a></center><P>";

           $anon_params[0] = $contact_id_c; # Content owner
           $anon_params[1] = $account_id_c; # account_owner
           $anon_params[2] = $sess_contact_id; #contact_viewer
           $anon_params[3] = $sess_account_id; #account_viewer
           $anon_params[4] = $do;
           $anon_params[5] = $valtype;
           $anon_params[6] = $val;
           $show_namer = $funky_gear->anonymity($anon_params);

           $show_name = $show_namer[0];
           $show_description = $show_namer[1];
           $profile_photo = $show_namer[2];
           $contact_profile = $show_namer[3];

           if ($show_description != NULL){
              $contact_description = str_replace("\n", "<br>", $show_description);
              }

           if (!$profile_photo){
              $profile_photo = "images/profile_photo_default.png";
              }

           $effect .= $contact_profile;

           $effect .= "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:4px;margin-bottom:4px;margin-left:4px;margin-right:4px; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Event Content</B></font></center></div>";

           if ($event_image_url){

              $effect .= "<BR><center><a href='".$event_image_url."' data-lightbox=\"".$do."\" title=\"".$event_name."\"><img src=".$event_image_url." width=400 style='margin: 5px;border: 2px solid ".$portal_header_colour.";border-radius:3px;'></a></center><BR>";

              }

           # Event Permissions & Settings
           #$effect .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;\" name=\"join\" id=\"join\" value=\"Allow viewers to join this event?\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=ConfigurationItemSets&action=view&value=".$val."&valuetype=EventPermissions&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><BR>";

           $effect .= "<font color=#FBB117 size=3><B>".$strings["Origin"].":</B></font> <font color=#151B54 size=3><B>".$parent_event_name."</B></font><BR>";

           if ($category_id != NULL){

              $category_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $category_id);
              $category_name = $category_returner[0];
              $category = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&value=".$val."&valuetype=Effects&lstsubval=".$category_id."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=3 color=#151B54><B>".$category_name."</B></font></a>";

              }


           $effect .= "<font color=#FBB117 size=3><B>".$strings["Category"].":</B></font> <font color=#151B54 size=3><B>".$category."</B></font><BR>";


           $effect .= "<font color=#FBB117 size=3><B>".$strings["Views"].":</B></font> <font color=#151B54 size=3><B>".$new_viewcount."</B></font><BR>";

           $effect .= "<font color=#FBB117 size=3><B>".$strings["Name"].":</B></font> ".$edit."<font color=#151B54 size=3><B>".$event_name."</B></font><BR>";

           if (($start_date == NULL || $start_date == '0000-00-00 00:00:00') && $start_years != NULL){
              $start_date = number_format($start_years,0);
              }

           $effect .= "<font color=#FBB117 size=3><B>".$strings["DateStart"].":</B></font> <font color=#151B54 size=3><B>".$start_date." [".$time_frame."]</B></font><BR>";

           if (($end_date == NULL || $end_date == '0000-00-00 00:00:00') && $end_years != NULL){
              $end_date = number_format($end_years,0);
              }

           $effect .= "<font color=#FBB117 size=3><B>".$strings["DateEnd"].":</B></font> <font color=#151B54 size=3><B>".$end_date."</B></font><BR>";

           # Calculate Time

           if ($end_date && $end_years == NULL){
              $end_years = date ("Y",$end_date);
              }

           if ($start_date && $start_years == NULL){
              $start_years = date ("Y",$start_date);
              }

           $total_years = $end_years-$start_years;
           $total_years = number_format($total_years,0);
           $end_years = number_format($end_years,0);
           $start_years = number_format($start_years,0);

           $effect .= "<font color=#FBB117 size=3><B>Start Years:</B></font> <font color=#151B54 size=3><B>".$start_years."</B></font><BR>";
           $effect .= "<font color=#FBB117 size=3><B>End Years:</B></font> <font color=#151B54 size=3><B>".$end_years."</B></font><BR>";
           $effect .= "<font color=#FBB117 size=3><B>Total Years:</B></font> <font color=#151B54 size=3><B>".$total_years."</B></font><BR>";

           $effect .= "<font color=#FBB117 size=3><B>".$strings["ValueType"].":</B></font> <font color=#151B54 size=3><B>".$value_type."</B></font><BR>";

           switch ($value_type_id){
   
            case 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2': # Monetary - P & L - Expense
            case '3566a485-0183-48a8-231b-54fd6e931b93': # Monetary - P & L - Revenue
            case '19896b1b-d790-88b8-a2b4-54fd6eb21986': # Monetary - B/S - Asset
            case '5f803ea1-354c-800e-2cc7-54fd6e65da42': # Monetary - B/S - Liability
            case 'a308ec04-abe4-8121-14bb-54fd6e6d0a00': # Monetary - General
            case '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281': # Quantity or Amount
            case '1e81858f-ba15-a8c1-fc96-54fd6e510f39': # Urgency
            case 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe': # Importance

              if ($currency != NULL){
                 $currency = "(".$currency.")";
                 }

              $show_value = number_format(ROUND($value_type_value,2));
              $effect .= "<font color=#FBB117 size=3><B>".$strings["Value"].":</B></font> <font color=#151B54 size=3><B>".$show_value." ".$currency."</B></font><BR>";

           break;

           } // end value switch

           if ($emotion != NULL){
              $effect .= "<font color=#FBB117 size=3><B>".$strings["Emotion"].":</B></font> <font color=#151B54 size=3><B>".$emotion."</B></font><BR>";
              $show_value = number_format(ROUND($value_type_value,0));
              $effect .= "<font color=#FBB117 size=3><B>".$strings["Value"].":</B></font> <font color=#151B54 size=3><B>".$show_value."</B></font><BR>";

              }

           if ($ethics != NULL){
              $effect .= "<font color=#FBB117 size=3><B>".$strings["Ethics"].":</B></font> <font color=#151B54 size=3><B>".$ethics."</B></font><BR>";

              $show_value = number_format(ROUND($value_type_value,0));
              $effect .= "<font color=#FBB117 size=3><B>".$strings["Value"].":</B></font> <font color=#151B54 size=3><B>".$show_value."</B></font><BR>";

              }


           $effect .= "<font color=#FBB117 size=3><B>".$strings["AffectedGroupType"].":</B></font> <font color=#151B54 size=3><B>".$group_type."</B></font><BR>";
           $effect .= "<font color=#FBB117 size=3><B>".$strings["Probability"].":</B></font> <font color=#151B54 size=3><B>".$probability."%</B></font><BR>";
           $effect .= "<font color=#FBB117 size=3><B>".$strings["Positivity"].":</B></font> <font color=#151B54 size=3><B>".$positivity."</B></font><BR>";
           $effect .= "<font color=#FBB117 size=3><B>".$strings["Purpose"].":</B></font> <font color=#151B54 size=3><B>".$purpose."</B></font><BR>";

           $map = "<a href=\"#\" onClick=\"Scroller();loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php', 'pc=".$portalcode."&do=Effects&action=map&value=".$val."&valuetype=Effects&sendiv=lightfull');document.getElementById('fade').style.display='block';return false\"><font size=3 color=#151B54><B>Show Map</B></font></a>";

           $close_map = "<a href=\"#\" onClick=\"cleardiv('lightfull');cleardiv('fade');document.getElementById('lightfull').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a>";

           $effect .= "<font color=#FBB117 size=3><B>Map:</B></font> ".$map." ".$close_map."<BR>";

           $effect .= "<P><font color=#151B54 size=2>".$description."</font><P>";

           $effect .= "<center>".$share_button."</center>";

           $effect .= "</div>";
           $effect .= "</div>";

           } // end for
     
       echo $object_return;

       ################################  

       $print_vote = $this->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$do,$bodywidth);

       ################################  

       echo "<div style=\"".$divstyle_blue."\"><center><font size=3><B>".$strings["SharedEffect"]."</B></font></center></div>";

       echo $effect;

       # Show any keywords
       # Keyword | ID: 5d462e35-1200-9cff-aabe-55d354a95501
       # Create Wrapper using Keyword CIT and Event ID as Name
       # Add related keywords within wrapper

       if (($sess_account_id != NULL && $sess_account_id == $account_id_c) || $auth==3){

          $project_cstm_object_type = 'Projects';
          $project_cstm_action = "select_cstm";
          $project_cstm_params[0] = " account_id_c='".$sess_account_id."' ";
          $project_cstm_params[1] = "id_c"; // select array
          $project_cstm_params[2] = ""; // group;
          $project_cstm_params[3] = ""; // order;
          $project_cstm_params[4] = ""; // limit
          $project_cstm_params[5] = $lingoname; // lingo
  
          $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

          if (is_array($project_cstm_items)){

             for ($projcnt=0;$projcnt < count($project_cstm_items);$projcnt++){

                 $project_id = $project_cstm_items[$projcnt]['id_c'];
                 $project_namer = $funky_gear->object_returner ("Projects", $project_id);
                 $project_name = $project_namer[0];
                 $addtask .= "<font color=#151B54><B>Project: ".$project_name."</B></font><BR>";
                 $addtask .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=add&value=".$project_id."&valuetype=Projects');return false\"><font color=#151B54><B>Add New Task</B></font></a><BR>";

                 $project_task_object_type = 'ProjectTasks';
                 $project_task_action = "select";
                 $project_task_params[0] = " project_task.deleted=0 && project_task.project_id='".$project_id."' ";
                 $project_task_params[1] = "id,name"; // select array
                 $project_task_params[2] = ""; // group;
                 $project_task_params[3] = ""; // order;
                 $project_task_params[4] = ""; // limit
  
                 $project_tasks = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

                 if (is_array($project_tasks)){

                    for ($taskcnt=0;$taskcnt < count($project_tasks);$taskcnt++){

                        $task_id = $project_tasks[$taskcnt]['id'];
                        $task_name = $project_tasks[$taskcnt]['name'];

                        if (!$tasks_sql){
                           $tasks_sql = "name='".$task_id."' ";
                           } else {
                           $tasks_sql = $tasks_sql." || name='".$task_id."'";
                           } 

                        #$dd_pack[$task_id] = $task_name;
                        $dd_pack[$val.'[]'.$task_id] = $task_name;

                        $addtask .= "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$task_id."&valuetype=Effects');return false\"><font color=#151B54><B>".$task_name.":</B></font></a> <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=add&value=".$task_id."&valuetype=ProjectTasks');return false\"><img src=images/icons/plus.gif width=16><font color=#151B54><B> Add Sub-task</B></font></a><BR>";

                        } # for

                    # List any existing relationships with tasks
                    # $event_projecttask_cit = '5fa66dca-fcf0-6886-999b-55f3092c0ec3';

                    $event_projecttask_cit = '5fa66dca-fcf0-6886-999b-55f3092c0ec3';

                    $eventtask_ci_object_type = 'ConfigurationItems';
                    $eventtask_ci_action = "select";
                    $eventtask_ci_params[0] = "sclm_configurationitemtypes_id_c='".$event_projecttask_cit."' && name='".$val."' ";
                    $eventtask_ci_params[1] = "id,name"; // select array
                    $eventtask_ci_params[2] = ""; // group;
                    $eventtask_ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
                    $eventtask_ci_params[4] = ""; // limit
  
                    $eventtask_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $eventtask_ci_object_type, $eventtask_ci_action, $eventtask_ci_params);

                    if (is_array($eventtask_ci_items)){

                       for ($eventtask_cnt=0;$eventtask_cnt < count($eventtask_ci_items);$eventtask_cnt++){

                           # Gather the wrapper ID
                           $eventtask_ci_wrapper_id = $eventtask_ci_items[$eventtask_cnt]['id'];

                           } # for

                       # Gather related tasks
                       $eventtasks_ci_object_type = 'ConfigurationItems';
                       $eventtasks_ci_action = "select";
                       $eventtasks_ci_params[0] = "sclm_configurationitems_id_c='".$eventtask_ci_wrapper_id."' && (".$tasks_sql.") ";
                       #echo "sclm_configurationitemtypes_id_c='".$eventtask_ci_wrapper_id."' && (".$tasks_sql.") ";
                       $eventtasks_ci_params[1] = "id,name"; // select array
                       $eventtasks_ci_params[2] = ""; // group;
                       $eventtasks_ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
                       $eventtasks_ci_params[4] = ""; // limit
  
                       $eventtasks_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $eventtasks_ci_object_type, $eventtasks_ci_action, $eventtasks_ci_params);

                       if (is_array($eventtasks_ci_items)){

                          for ($eventtasks_cnt=0;$eventtasks_cnt < count($eventtasks_ci_items);$eventtasks_cnt++){

                              $eventtask_id = $eventtasks_ci_items[$eventtasks_cnt]['name'];

                              # Remove this existing relationship from the array
                              $element = $val.'[]'.$eventtask_id;
                              unset($dd_pack[$element]);

                              $eventtask_namer = $funky_gear->object_returner ("ProjectTasks", $eventtask_id);
                              $eventtask_name = $eventtask_namer[0];
                              $eventtasks .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$eventtask_id."&valuetype=Effects');return false\"><font color=#151B54><B>".$eventtask_name."</B></font></a><BR>";

                              } # for

                          $projecttasks = "<div style=\"".$divstyle_white."\"><B>Related Project Tasks:</B><P>".$eventtasks."</div>";

                          } # is array

                       } # is array

                    # Tasks exist - build relater

                    $tblcnt = 0;

                    $tablefields[$tblcnt][0] = "sclm_event_id_c"; // Field Name
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
                    $tablefields[$tblcnt][11] = $val; // Field ID
                    $tablefields[$tblcnt][20] = "sclm_event_id_c"; //$field_value_id;
                    $tablefields[$tblcnt][21] = $val; //$field_value;   

                    $tblcnt++;

                    $tablefields[$tblcnt][0] = 'sentdata'; // Field Name
                    $tablefields[$tblcnt][1] = $strings["ProjectTask"]; // Full Name
                    $tablefields[$tblcnt][2] = 0; // is_primary
                    $tablefields[$tblcnt][3] = 0; // is_autoincrement
                    $tablefields[$tblcnt][4] = 0; // is_name
                    $tablefields[$tblcnt][5] = 'dropdown_jumper';//$field_type; //'INT'; // type
                    $tablefields[$tblcnt][6] = '255'; // length
                    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
                    $tablefields[$tblcnt][8] = ''; // default
                    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
                    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table    
                    $tablefields[$tblcnt][9][2] = 'id';
                    $tablefields[$tblcnt][9][3] = 'name';
                    $tablefields[$tblcnt][9][4] = ""; // Exceptions
                    $tablefields[$tblcnt][9][5] = ""; // Current Value
                    $tablefields[$tblcnt][9][6] = "";
                    $tablefields[$tblcnt][9][7] = "";
                    $tablefields[$tblcnt][9][8] = "";
                    $tablefields[$tblcnt][9][9] = $sentdata;
                    $tablefields[$tblcnt][10] = '1';//1; // show in view 
                    $tablefields[$tblcnt][11] = ''; // Field ID
                    $tablefields[$tblcnt][20] = 'sentdata';//$field_value_id;
                    $tablefields[$tblcnt][21] = ""; //$field_value;

                    if ($sess_contact_id == $contact_id_c){
                       $auth=2;
                       }

                    $relatevalpack = "";
                    #$do = 'ConfigurationItems';
                    $relatevalpack[0] = $do;
                    $relatevalpack[1] = 'select'; //
                    $relatevalpack[2] = $valtype;
                    $relatevalpack[3] = $tablefields;
                    $relatevalpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
                    $relatevalpack[6] = 'event_projecttask_add'; #

                    $relateform = $funky_gear->form_presentation($relatevalpack);

                    $projecttasks .= "<div style=\"".$divstyle_blue_light."\" name='RELATIONSHIPS' id='RELATIONSHIPS'>".$relateform."</div>";

                    } # is array

                 } # for

             #$this->funkydone ($_POST,$lingo,'ProjectTasks','list',$project_id,'Projects',$bodywidth);
             $projecttasks .= "<div style=\"".$divstyle_white."\">".$addtask."</div>";
             echo $projecttasks;

             } # is array

          } # is sess_account_id

       if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth==3){

          echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=Effects&sendiv=lightform&add_parent=1');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$strings["SideEffects_add_parenteffect"]."</B></font></a></div>";

          }

       if ($sess_contact_id != NULL){
     
          echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$strings["SideEffects_add_subeffect"]."</B></font></a></div>";

          echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_related&value=".$val."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Related Effect</B></font></a></div>";

          echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_virtual_related&value=".$val."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Virtual Related Effect</B></font></a></div>";

          echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_virtual_parent&value=".$val."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Virtual Parent Effect</B></font></a></div>";

          echo "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_virtual_child&value=".$val."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Virtual Sub Effect</B></font></a></div>";

          echo "<P><div style=\"".$divstyle_white."\">The owner of an event can attach a <B>Parent Effect</B>. If a parent effect already exists, it will be converted into a sub effect and the new parent effect will be set.<BR>The creation or manifestastion of <B>Sub Effects</B> are directly due to or a direct result or by-product of an existing event (the parent effect/event).<BR><B>Related Effects</B> are not direct sub-effects, but are associated in some way, such as by the subject (person) or some other important association.<BR><B>Virtual Effects</B> have the same intention as the actual events, though being virtual means they can be used as either prediction or simply non-fictional run-off versions.</div>";

          #########################
          # Allow people to join event

          if ($allow_joiners == 1){

             $container = "";  
             $container_top = "";
             $container_middle = "";
             $container_bottom = "";

             $container_params[0] = 'open'; // container open state
             $container_params[1] = $bodywidth; // container_width
             $container_params[2] = $bodyheight; // container_height
             $container_params[3] = "People Joining This Event"; // container_title
             $container_params[4] = 'PeopleJoining'; // container_label
             $container_params[5] = $portal_info; // portal info
             $container_params[6] = $portal_config; // portal configs
             $container_params[7] = $strings; // portal configs
             $container_params[8] = $lingo; // portal configs

             $container = $funky_gear->make_container ($container_params);
             $container_top = $container[0];
             $container_middle = $container[1];
             $container_bottom = $container[2];

             echo $container_bottom;

             echo "<img src=images/blank.gif width=98% height=5><BR>";

             echo $container_top;

#             if ($sess_contact_id != NULL && $sess_contact_id != $contact_id_c){
             if ($sess_contact_id != NULL){

                echo $this->funkydone ($_POST,$lingo,'Effects','list_joiners',$val,$do,$bodywidth);                
               
                } elseif ($sess_contact_id == NULL ) {# if session and not owner
                echo "<P><div style=\"".$divstyle_orange_light."\">To join this event, you must be logged in..</div>";
                }

             echo $container_bottom;

             } # allow_joiners

          # End joiners
          #########################

          if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth==3){

             $container = "";  
             $container_top = "";
             $container_middle = "";
             $container_bottom = "";

             $container_params[0] = 'open'; // container open state
             $container_params[1] = $bodywidth; // container_width
             $container_params[2] = $bodyheight; // container_height
             $container_params[3] = "Related People"; // container_title
             $container_params[4] = 'RelatedPeople'; // container_label
             $container_params[5] = $portal_info; // portal info
             $container_params[6] = $portal_config; // portal configs
             $container_params[7] = $strings; // portal configs
             $container_params[8] = $lingo; // portal configs

             $container = $funky_gear->make_container ($container_params);
             $container_top = $container[0];
             $container_middle = $container[1];
             $container_bottom = $container[2];
  
             echo "<img src=images/blank.gif width=98% height=5><BR>";

             echo $container_top;

             $sn_params[0] = $do;
             $sn_params[1] = "list";
             $sn_params[2] = $valtype;
             $sn_params[3] = $val;

             $extra_params[0] = "";
             $extra_params[1] = "";
             $sn_params[4] = $extra_params;
    
             $sn_returner = $funky_sn->sn_contacts ($sn_params);
             $rel_contacts = $sn_returner[0];
             echo $rel_contacts;

             #echo $this->funkydone ($_POST,$lingo,'Effects','event_contacts_list',$val,$do,$bodywidth);
   
             echo $container_bottom;

             }

          $container = "";  
          $container_top = "";
          $container_middle = "";
          $container_bottom = "";

          $container_params[0] = 'open'; // container open state
          $container_params[1] = $bodywidth; // container_width
          $container_params[2] = $bodyheight; // container_height
          $container_params[3] = "Related ".$strings["SharedEffects"]; // container_title
          $container_params[4] = 'RelatedSharedEffects'; // container_label
          $container_params[5] = $portal_info; // portal info
          $container_params[6] = $portal_config; // portal configs
          $container_params[7] = $strings; // portal configs
          $container_params[8] = $lingo; // portal configs

          $container = $funky_gear->make_container ($container_params);
          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];
  
          echo "<img src=images/blank.gif width=98% height=5><BR>";

          echo $container_top;

          #echo "<div style=\"".$divstyle_white."\"><center>".$warning."</center></div>";
          echo $this->funkydone ($_POST,$lingo,'Effects','list_related',$val,$do,$bodywidth);
   
          echo $container_bottom;

          $container = "";  
          $container_top = "";
          $container_middle = "";
          $container_bottom = "";

          $container_params[0] = 'open'; // container open state
          $container_params[1] = $bodywidth; // container_width
          $container_params[2] = $bodyheight; // container_height
          $container_params[3] = $strings["SharedEffects"]." Relation Builder"; // container_title
          $container_params[4] = 'RelatedSharedEffectsBuilder'; // container_label
          $container_params[5] = $portal_info; // portal info
          $container_params[6] = $portal_config; // portal configs
          $container_params[7] = $strings; // portal configs
          $container_params[8] = $lingo; // portal configs

          $container = $funky_gear->make_container ($container_params);
          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];

          echo "<img src=images/blank.gif width=98% height=5><BR>";

          echo $container_top;

          echo $this->funkydone ($_POST,$lingo,'Effects','build_relater',$val,$do,$bodywidth);

          echo $container_bottom;

          } else {
      
          echo "<P><div style=\"".$divstyle_orange_light."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
          }

       ################################  
       # Start Content

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
  
       echo "<img src=images/blank.gif width=98% height=5><BR>";

       echo $container_top;
       echo $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);
       echo $container_bottom;

       # End Content
       ################################
       # Start Effects SideEffects
    
       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["SharedEffects"]; // container_title
       $container_params[4] = 'SharedEffects'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo "<img src=images/blank.gif width=98% height=5><BR>";  

       #echo $container_top;

      if ($action == 'view_related'){
         $this_list = "list_aggregate";
         } else {
         $this_list = "list";
         }

       echo $this->funkydone ($_POST,$lingo,'Effects',$this_list,$val,$do,$bodywidth);

       #echo $container_bottom;

       # End Effects SideEffects
       ################################
       # Start Effects

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = "Related ".$strings["SharedEffects"]; // container_title
       $container_params[4] = 'RelatedSharedEffects'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       #$container = $funky_gear->make_container ($container_params);
       #$container_top = $container[0];
       #$container_middle = $container[1];
       #$container_bottom = $container[2];
  
       #echo "<img src=images/blank.gif width=98% height=5><BR>";

       #echo $container_top;
       #echo $this->funkydone ($_POST,$lingo,'Effects','list_related',$val,$do,$bodywidth);
       #echo $container_bottom;

       # End Effects
       ################################
       # Make Embedded Object Link

       $embedd_params = array();
       $embedd_params[0] = $name;
       $embedd_params[1] = $cmn_statuses_id_c;

       echo "<img src=images/blank.gif width=98% height=5><BR>";
       echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$embedd_params);

       #
       ################################

       } else { // end if array

         echo "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       } // end if array

   break; // end view
   ######################################
   case 'event_projecttask_add':

    # Get event, task - check for wrapper, set relationship

    $sentdata = $_POST['sentdata'];

    list ($sclm_events_id_c,$task_id) = explode("[]", $sentdata);

    if ($sclm_events_id_c != NULL && $task_id != NULL){

       $event_projecttask_cit = '5fa66dca-fcf0-6886-999b-55f3092c0ec3';

       $eventtask_ci_object_type = 'ConfigurationItems';
       $eventtask_ci_action = "select";
       $eventtask_ci_params[0] = "sclm_configurationitemtypes_id_c='".$event_projecttask_cit."' && name='".$sclm_events_id_c."' ";
       $eventtask_ci_params[1] = "id,name"; // select array
       $eventtask_ci_params[2] = ""; // group;
       $eventtask_ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
       $eventtask_ci_params[4] = ""; // limit
  
       $eventtask_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $eventtask_ci_object_type, $eventtask_ci_action, $eventtask_ci_params);

       if (is_array($eventtask_ci_items)){

          for ($eventtask_cnt=0;$eventtask_cnt < count($eventtask_ci_items);$eventtask_cnt++){

              # Gather the wrapper ID
              $eventtask_ci_wrapper_id = $eventtask_ci_items[$eventtask_cnt]['id'];
              }

          } else {# is array - end create wrapper

          $process_object_type = "ConfigurationItems";
          $process_action = "update";
      
          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $event_projecttask_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
          $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
   
          $wrapper_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $eventtask_ci_wrapper_id = $wrapper_result['id'];

          } 

       if ($eventtask_ci_wrapper_id != NULL){
          # Should be here if an array!
   
          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $task_id);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $eventtask_ci_wrapper_id);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
          $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

          $taskrel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
          $task_ci_relevent_id = $taskrel_result['id'];

          $projecttask_returner = $funky_gear->object_returner ("ProjectTasks", $task_id);
          $projecttask_return_name = $projecttask_returner[0];

          $projecttask_relate_result = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$task_id."&valuetype=".$valtype."&sendiv=lightform');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\"><font color=#151B54 size=3><B>".$projecttask_return_name."</font></a>";

          } # is array - end create wrapper

       $process_message = "<center><B>Creating the Project Task relationship was successful!</B></center><BR>";
       $process_message .= $projecttask_relate_result;

       echo $process_message;

       } # End if project task

   break; // end event_projecttask_add
   ######################################
   case 'event_contacts_list':

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "sclm_configurationitemtypes_id_c='f0bf777f-5346-d2e1-53c4-5551659b758d' && name='".$val."'";
    $ci_params[1] = "id,name"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_wrapper_id = $ci_items[$cnt]['id'];

           } # for

       } # is array

    if ($ci_wrapper_id != NULL){

       # Gather any related items
       $ci_events_object_type = 'ConfigurationItems';
       $ci_events_action = "select";

       if ($auth == 3){
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' "; # parent
          } elseif ($auth == 2) {
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
          } else {
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') "; # parent
          } 

       $ci_events_params[1] = "id,name,sclm_configurationitemtypes_id_c,account_id_c,contact_id_c,description"; // select array
       $ci_events_params[2] = ""; // group;
       $ci_events_params[3] = " name,date_entered DESC "; // order;
       $ci_events_params[4] = ""; // limit
  
       $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

       if (is_array($ci_events_items)){          

          for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

              $events_contact = "";

              $ci_event_id = $ci_events_items[$ci_events_cnt]['id'];
              $contact_info = $ci_events_items[$ci_events_cnt]['name'];
              $contact_type = $ci_events_items[$ci_events_cnt]['sclm_configurationitemtypes_id_c'];
              $account_id_c = $ci_events_items[$ci_events_cnt]['account_id_c'];
              $contact_id_c = $ci_events_items[$ci_events_cnt]['contact_id_c'];

              # Contact Info can be email address or ID
              # Configuration Item Types: Messaging Systems

              switch ($contact_type){
 
               case '821d3058-e575-b6fa-c3bb-5559de9489ce': # Account Contacts | ID: 821d3058-e575-b6fa-c3bb-5559de9489ce

                $account_contacts = "";
                $account_contacts = explode (",",$contact_info);

                foreach ($account_contacts as $contact_key=>$contact_id){

                        $anon_params[0] = $contact_id; # Content owner
                        $anon_params[1] = ""; # account_owner
                        $anon_params[2] = $sess_contact_id; #contact_viewer
                        $anon_params[3] = $sess_account_id; #account_viewer
                        $anon_params[4] = $do;
                        $anon_params[5] = $valtype;
                        $anon_params[6] = $val;

                        $show_namer = $funky_gear->anonymity($anon_params);

                        if ($show_namer != NULL){
                           $show_name = $show_namer[0];
                           $show_description = $show_namer[1];
                           $profile_photo = $show_namer[2];
                           $contact_profile = $show_namer[3];

                           $events_contact .= $contact_profile;

                           } # if not null

                        } # foreach

               break;
               case 'd8ba0615-94b3-78a5-51e4-5559de992b1c': # Email Contacts | ID: d8ba0615-94b3-78a5-51e4-5559de992b1c

                # Search the contact list for this email to make new connection
                $email_contacts = "";
                $contact_email = "";
                $rego_params = "";

                $email_contacts = explode (",",$contact_info);

                foreach ($email_contacts as $contact_key=>$contact_email){

                        if ($contact_email != NULL){

                           $rego_object_type = "Contacts";
                           $rego_action = "contact_by_email";
                           $rego_params = $contact_email; # query

                           $existing_contact_id = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $rego_object_type, $rego_action, $rego_params);

                           #echo "Exists: $existing_contact_id <BR>";

                           if ($existing_contact_id != NULL){
                              # Get Anonymity

                              $anon_params[0] = $existing_contact_id; # Content owner
                              $anon_params[1] = ""; # account_owner
                              $anon_params[2] = $sess_contact_id; #contact_viewer
                              $anon_params[3] = $sess_account_id; #account_viewer
                              $anon_params[4] = $do;
                              $anon_params[5] = $valtype;
                              $anon_params[6] = $val;

                              $show_namer = $funky_gear->anonymity($anon_params);

                              if ($show_namer != NULL){

                                 $show_name = $show_namer[0];
                                 $show_description = $show_namer[1];
                                 $profile_photo = $show_namer[2];
                                 $contact_profile = $show_namer[3];

                                 $events_contact .= "<div style=\"".$divstyle_white."\"><B>Contact Email: ".$contact_email."</B></div>";
                                 $events_contact .= $contact_profile;

                                 #echo "contact_profile: $contact_profile <BR>";

                                 } else {
                                 # if null
                                 $events_contact .= "";
                                 } 

                              } else {

                              $events_contact .= "<div style=\"".$divstyle_white."\"><B>".$contact_email."</B> is not currently a ".$portal_title." member.</div>";

                              } 

                           } else {

                           $events_contact .= "";

                           } 

                        } # foreach

               break;
               case '2e465f2e-57db-e22d-0b7c-5559e0aaeeaf': #  Facebook Contacts | ID: 2e465f2e-57db-e22d-0b7c-5559e0aaeeaf

                $events_contact = $contact_info;

               break;
               case '54cf2e2f-a525-85d0-ceff-5559e04f44f2': #  Google Contacts | ID: 54cf2e2f-a525-85d0-ceff-5559e04f44f2

                $email_contacts = "";
                $contact_email = "";
                $rego_params = "";

                $email_contacts = explode (",",$contact_info);

                foreach ($email_contacts as $contact_key=>$contact_email){

                        if ($contact_email != NULL){

                           $rego_object_type = "Contacts";
                           $rego_action = "contact_by_email";
                           $rego_params = $contact_email; # query

                           $existing_contact_id = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $rego_object_type, $rego_action, $rego_params);

                           #echo "Exists: $existing_contact_id <BR>";

                           if ($existing_contact_id != NULL){
                              # Get Anonymity

                              $anon_params[0] = $existing_contact_id; # Content owner
                              $anon_params[1] = ""; # account_owner
                              $anon_params[2] = $sess_contact_id; #contact_viewer
                              $anon_params[3] = $sess_account_id; #account_viewer
                              $anon_params[4] = $do;
                              $anon_params[5] = $valtype;
                              $anon_params[6] = $val;

                              $show_namer = $funky_gear->anonymity($anon_params);

                              if ($show_namer != NULL){

                                 $show_name = $show_namer[0];
                                 $show_description = $show_namer[1];
                                 $profile_photo = $show_namer[2];
                                 $contact_profile = $show_namer[3];

                                 $events_contact .= "<div style=\"".$divstyle_white."\"><B>Contact Email: ".$contact_email."</B></div>";
                                 $events_contact .= $contact_profile;

                                 #echo "contact_profile: $contact_profile <BR>";

                                 } else {
                                 # if null
                                 $events_contact .= "";
                                 } 

                              } else {

                              $events_contact .= "<div style=\"".$divstyle_white."\"><B>".$contact_email."</B> is not currently a ".$portal_title." member.</div>";

                              } 

                           } else {

                           $events_contact .= "";

                           } 

                        } # foreach

               break;
               case '18a8e733-f0e1-32a2-d5b3-5559e087dffb': #  LinkedIn Contacts | ID: 18a8e733-f0e1-32a2-d5b3-5559e087dffb

                $events_contact = $contact_info;

               break;
               case '33485c3e-4814-12a5-5a38-5559e204e411': #  Social Networks | ID: 33485c3e-4814-12a5-5a38-5559e204e411

                # Sharing events directly to the Social Networks in lifestyle categories
                $events_contact = $contact_info;

               break;
               case '7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e': #  Social Network Contacts | ID: 7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e

                # Connections that have been made directly with other members in the system

                $account_contacts = "";
                $account_contacts = explode (",",$contact_info);

                foreach ($account_contacts as $contact_key=>$contact_id){

                        $anon_params[0] = $contact_id; # Content owner
                        $anon_params[1] = ""; # account_owner
                        $anon_params[2] = $sess_contact_id; #contact_viewer
                        $anon_params[3] = $sess_account_id; #account_viewer
                        $anon_params[4] = $do;
                        $anon_params[5] = $valtype;
                        $anon_params[6] = $val;

                        $show_namer = $funky_gear->anonymity($anon_params);

                        if ($show_namer != NULL){
                           $show_name = $show_namer[0];
                           $show_description = $show_namer[1];
                           $profile_photo = $show_namer[2];
                           $contact_profile = $show_namer[3];

                           $events_contact .= $contact_profile;

                           } # if not null

                        } # foreach


               break;

              } # contact_description

              $edit = "";
              if ($sess_contact_id != NULL && $contact_id_c == $sess_contact_id || $auth==3){
                 $edit ="<a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=event_contacts_edit&value=".$ci_event_id."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red><B>[".$strings["action_edit"]."]</B></font></a>";
                 } 

              $rel_contact .= "<div style=\"".$divstyle_white."\"><img src=images/icons/i_users.gif width=16 border=0 alt=".$event_name."> ".$edit."<BR>".$events_contact."</div>";

              } # for

          $rel_contact .= "<div style=\"".$divstyle_blue."\"><a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=event_contacts_add&value=".$ci_wrapper_id."&valuetype=EffectsWrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=blue><B>[".$strings["action_addnew"]."]</B></font></a></div>";

          } else {# is array

          $rel_contact = "<div style=\"".$divstyle_white."\">There are no people connected to this event yet.</div><div style=\"".$divstyle_blue."\"><a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=event_contacts_add&value=".$ci_wrapper_id."&valuetype=EffectsWrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=blue><B>[".$strings["action_addnew"]."]</B></font></a></div>";

          }

       } else {# is ci_wrapper_id

       $rel_contact = "<div style=\"".$divstyle_white."\">There are no people connected to this event yet. </div><div style=\"".$divstyle_blue."\"><a href=\"\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=event_contacts_add&value=".$val."&valuetype=Effects&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=blue><B>[".$strings["action_addnew"]."]</B></font></a></div>";

       } 

    echo $rel_contact;

   break; // end event_contacts_list
   ######################################
   case 'event_contacts_add':
   case 'event_contacts_edit':

    # Social Networks -> Events -> Event Contacts
    # CIT: f0bf777f-5346-d2e1-53c4-5551659b758d
    # Add using FB, Google, Account, Connections, Other

    $closer = "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    if ($sendiv == 'lightform'){
       echo $closer;
       }

    if ($action == 'event_contacts_add' && $valtype == 'EffectsWrapper'){

       # Wrapper created for the event
       $sclm_configurationitems_id_c = $val; # parent
       $ci_object_type = 'ConfigurationItems';
       $ci_action = "select";
       $ci_params[0] = "id='".$sclm_configurationitems_id_c."'";
       $ci_params[1] = "id,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){          

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $sclm_events_id_c = $ci_items[$cnt]['name'];
              #echo "sclm_events_id_c $sclm_events_id_c ";

              } # for

         } # is array

       } elseif ($action == 'event_contacts_add' && $valtype == 'Effects'){

       # No wrapper created yet
       $sclm_events_id_c = $val;

       } elseif ($action == 'event_contacts_edit'){

         $ci_events_object_type = "ConfigurationItems";
         $ci_events_action = "select";
         $ci_events_params[0] = "id='".$val."'"; #
         $ci_events_params[1] = "id,name,description,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,account_id_c,contact_id_c,cmn_statuses_id_c"; // select array
         $ci_events_params[2] = ""; // group;
         $ci_events_params[3] = " name, date_entered DESC "; // order;
         $ci_events_params[4] = ""; // limit
  
         $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

         if (is_array($ci_events_items)){          

            for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

                $recipient_id = $ci_events_items[$ci_events_cnt]['id'];
                $recipient_contacts = $ci_events_items[$ci_events_cnt]['name'];
                $recipient_contacts_description = $ci_events_items[$ci_events_cnt]['description'];
                $account_id_c = $ci_events_items[$ci_events_cnt]['account_id_c'];
                $contact_id_c = $ci_events_items[$ci_events_cnt]['contact_id_c'];
                $cmn_statuses_id_c = $ci_events_items[$ci_events_cnt]['cmn_statuses_id_c'];
                $sclm_configurationitems_id_c = $ci_events_items[$ci_events_cnt]['sclm_configurationitems_id_c'];
                $sclm_configurationitemtypes_id_c = $ci_events_items[$ci_events_cnt]['sclm_configurationitemtypes_id_c'];

                } # for

            ##############
            # Get Event
            $ci_object_type = 'ConfigurationItems';
            $ci_action = "select";
            $ci_params[0] = "id='".$sclm_configurationitems_id_c."'";
            $ci_params[1] = "id,name"; // select array
            $ci_params[2] = ""; // group;
            $ci_params[3] = " name, date_entered DESC "; // order;
            $ci_params[4] = ""; // limit
  
            $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

            if (is_array($ci_items)){          

               for ($cnt=0;$cnt < count($ci_items);$cnt++){

                   $sclm_events_id_c = $ci_items[$cnt]['name'];            

                   } # for

               } # is array

            # Get Event
            ##############

            } # is array

         } # if edit

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "recipient_id"; // Field Name
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
    $tablefields[$tblcnt][20] = "recipient_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $recipient_id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
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
    $tablefields[$tblcnt][11] = "lightform"; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = 'lightform'; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_configurationitems_id_c"; // Field Name
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
    $tablefields[$tblcnt][20] = "sclm_configurationitems_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'recipient_types'; // Field Name
    $tablefields[$tblcnt][1] = "Event Contacts"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    if ($action == 'event_contacts_add'){
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       } else {
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       } 
    #$tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    $dd_pack = $funky_messaging->message_recipient_selections();

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $sclm_configurationitemtypes_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Current Value
    $tablefields[$tblcnt][9][7] = "recipient_types"; // reltable
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $sclm_configurationitemtypes_id_c; // Field ID
    $tablefields[$tblcnt][20] = "recipient_types"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_configurationitemtypes_id_c; //$field_value;     

    if ($action == 'event_contacts_edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "recipient_contacts"; // Field Name
       $tablefields[$tblcnt][1] = "Contact Value"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $recipient_contacts; // Field ID
       $tablefields[$tblcnt][20] = "recipient_contacts"; //$field_value_id;
       $tablefields[$tblcnt][21] = $recipient_contacts; //$field_value;   

       /*
       $tblcnt++;

       $tablefields[$tblcnt][0] = "recipient_contacts_description"; // Field Name
       $tablefields[$tblcnt][1] = "Contact Description"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $recipient_contacts_description; // Field ID
       $tablefields[$tblcnt][20] = "recipient_contacts_description"; //$field_value_id;
       $tablefields[$tblcnt][21] = $recipient_contacts_description; //$field_value;   

       */

       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "value"; // Field Name
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
    $tablefields[$tblcnt][20] = "value"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_events_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Effect"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = "sclm_events"; // If DB, dropdown_table, if List, then array, other related table    
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($auth == 3){

       $tablefields[$tblcnt][9][4] = " deleted=0 order by name, date_entered DESC  "; 

       } elseif ($auth == 2) {

       $tablefields[$tblcnt][9][4] = " deleted=0 && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') order by name, date_entered DESC  "; 
 
       } else {

       $tablefields[$tblcnt][9][4] = " deleted=0 && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') order by name, date_entered DESC  "; 
 
       } 

    $tablefields[$tblcnt][9][5] = $sclm_events_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = "";
    $tablefields[$tblcnt][9][7] = "";
    $tablefields[$tblcnt][9][8] = "";
    $tablefields[$tblcnt][9][9] = "";
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $sclm_events_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_events_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value;

    if ($action == 'add'){
       $account_id_c = $sess_account_id;
       }

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
    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " id='".$account_id_c."' "; // exception
       }
    $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

    if ($action == 'add'){
       $contact_id_c = $sess_contact_id;
       }

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
    $tablefields[$tblcnt][9][1] = 'accounts_contacts,contacts'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'first_name';

    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$account_id_c."' && accounts_contacts.contact_id=contacts.id "; // exception
       }

    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

    $tblcnt++;

    if (!$cmn_statuses_id_c){
       $cmn_statuses_id_c = $standard_statuses_closed;
       }

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
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
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "send_notification"; // Field Name
    $tablefields[$tblcnt][1] = "Send Notification?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $send_notification; // Field ID
    $tablefields[$tblcnt][20] = "send_notification"; //$field_value_id;
    $tablefields[$tblcnt][21] = $send_notification; //$field_value;

    ###########################################
    # To be added in future for additional permissions for added users
    # Event Contact Permissions | ID: a945556f-df9d-3805-6c99-555b6b8c50cd
    # Allow Access to Event Parent & Children | ID: 20afe70c-d7fe-0af9-67b4-555b6d928194
    ###########################################

    $valpack = "";
    $valpack[0] = 'Effects';
    $valpack[1] = 'custom'; //
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = 'event_contacts_process'; //
    $valpack[7] = "Add Contact";
    $valpack[8] = ""; 
    $valpack[10] = 'lightform';

    $relateform = $funky_gear->form_presentation($valpack);

    echo "<P><center><font size=3><B>Select from your contacts or use an email address to add contacts..</B></font></center><P>";

    echo $relateform;

    if ($sendiv == 'lightform'){
       echo $closer;
       }

   break; // end event_contacts_add
   ######################################
   case 'event_contacts_process':

    # Process the events' contacts
    $error = "";
    
    if ($_POST['recipient_types'] == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"]."Recipients</B></font><BR>";
       }

    if ($_POST['sclm_events_id_c'] == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Event"]."</B></font><BR>";
       }

    /*
    $closer = "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    if ($sendiv == 'lightform'){
       echo $closer;
       }

    $name = $_POST['name'];
    $sclm_events_id_c = $_POST['sclm_events_id_c'];
    $sclm_configurationitems_id_c = $_POST['sclm_configurationitems_id_c'];
    $event_contacts = $_POST['event_contacts'];

    echo "Contact Info: $name <BR>Event: $sclm_events_id_c <BR>Contact Type: $event_contacts<P>";


          $sclm_events_id_c = $_POST['sclm_events_id_c'];

          $message_link = "Body@".$lingo."@Effects@view@".$sclm_events_id_c."@Effects";
          $message_link = $funky_gear->encrypt($message_link);
          $message_link = "https://".$hostname."/?pc=".$message_link;

          $message_image = "https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-100x100.png";

          $message_title = "You have been tagged in a Shared Effects Event!";

          $message_body = "Hello NAMER,\n you have been included in an event posting on Shared Effects. Please go to the following link to check it out.";
          $message_body .= "\n\n#################\n\n".$message_link;
          $message_body .= "\n\n#################\n\nShared Effects is a new type of Social Collaboration service that allows you to manage events and sub-events that matter in your life. Just like evolution - we are the result of all that occured before us - and now you have a way to manage the path you have taken and the path you will take - collaboratively; with friends, family, colleagues and/or the general public.\n\n";

          $msg_params[0] = $_POST;
          $msg_params[1] = $message_title;
          $msg_params[2] = $message_body;
          $msg_params[3] = $message_link;
          $msg_params[4] = $message_image;
          $msg_params[5] = $do;
          $msg_params[6] = $action;
          $msg_params[7] = $valtype;
          $msg_params[8] = $val;

          $message_result = $funky_messaging->message_delivery ($msg_params);

          echo "Message result: ".$message_result."<P>";

          var_dump($message_result);

    exit;

    */

    if (!$error){

       if ($_POST['sclm_configurationitems_id_c'] == NULL){

          # Create wrapper first
          # Social Networking | ID: e2fe4359-2fe2-2d8a-2253-55217b8be532
          # Social Networks | ID: 427feba6-efdd-414d-a1c1-55217c33f71a
          # Events | ID: 4e4233fd-bd1b-cf45-8baa-55220aeeadea
          # Event Contacts | ID: f0bf777f-5346-d2e1-53c4-5551659b758d

          $cit = "f0bf777f-5346-d2e1-53c4-5551659b758d";

          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $_POST['sclm_events_id_c']);
          $process_params[] = array('name'=>'description','value' => $_POST['sclm_events_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

          $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
          $ci_wrapper_id = $rel_result['id'];

          } else {

          $ci_wrapper_id = $_POST['sclm_configurationitems_id_c'];

          } 

       # May just wish to include the user - but not to notify them

       $sclm_events_id_c = $_POST['sclm_events_id_c'];

       $message_link = "Body@".$lingo."@Effects@view@".$sclm_events_id_c."@Effects";
       $message_link = $funky_gear->encrypt($message_link);
       $message_link = "https://".$hostname."/?pc=".$message_link;

       $message_image = "https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-100x100.png";

       $message_title = "You have been tagged in a Shared Effects Event!";

       $message_body = "Hello,\n\nYou have been included in an event posting on Shared Effects. Please go to the following link to check it out.";
       $message_body .= "\n\n#################\n\n".$message_link;
       $message_body .= "\n\n#################\n\nShared Effects is a new type of Social Collaboration service that allows you to manage events and sub-events that matter in your life. Just like evolution - we are the result of all that occured before us - and now you have a way to manage the path you have taken and the path you will take - collaboratively; with friends, family, colleagues and/or the general public.\n\n";

       $msg_params[0] = $_POST;
       $msg_params[1] = $message_title;
       $msg_params[2] = $message_body;
       $msg_params[3] = $message_link;
       $msg_params[4] = $message_image;
       $msg_params[5] = $do;
       $msg_params[6] = $action;
       $msg_params[7] = $valtype;
       $msg_params[8] = $val;
       $extra_msg_params[0] = 'event_contacts';
       $extra_msg_params[1] = $ci_wrapper_id;
       $msg_params[9] = $extra_msg_params;

       $message_results = $funky_messaging->message_delivery ($msg_params);

       $process_message = $strings["SubmissionSuccess"]."<P>";

       $message_id = $message_results[0];
       $emailresult = $message_results[1];

       $sclm_events_id_c = $_POST['sclm_events_id_c'];
       $event_namer = $funky_gear->object_returner ($do, $sclm_events_id_c);
       $event_name = $event_namer[0];

       $process_message .= "<BR>".$emailresult;

       $process_message .= "<BR><a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$sclm_events_id_c."&valuetype=".$do."');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">".$event_name."</a><BR>";

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";  

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       } else {// no error

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       }

   break; // end event_contacts_process
   ######################################
   case 'list_joiners':

    # Events General CIT: 4e4233fd-bd1b-cf45-8baa-55220aeeadea

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "sclm_configurationitemtypes_id_c='4c0973ff-da08-27a2-746b-55e30d4ac3bd' && name='".$val."' ";
    $ci_params[1] = "id,name"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){ 

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_wrapper_id = $ci_items[$cnt]['id'];

           } # for

       } # is array

    if ($ci_wrapper_id != NULL){

       # Gather any related items
       $ci_events_object_type = 'ConfigurationItems';
       $ci_events_action = "select";

       if ($auth == 3){
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' "; # parent
          } elseif ($auth == 2){
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
          } else {
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_contact_id."') "; # parent
          }


       $ci_events_params[1] = "id,name,contact_id_c,account_id_c"; // select array
       $ci_events_params[2] = ""; // group;
       $ci_events_params[3] = " name, date_entered DESC "; // order;
       $ci_events_params[4] = ""; // limit
  
       $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

       $joined = FALSE;

       if (is_array($ci_events_items)){          

          for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

              $ci_event_id = $ci_events_items[$ci_events_cnt]['id'];
              $join_status = $ci_events_items[$ci_events_cnt]['name'];

              if ($join_status){
                 $event_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $join_status);
                 $join_status_name = $event_returner[0];
                 }

              $relcontact_id_c = $ci_events_items[$ci_events_cnt]['contact_id_c'];
              $relaccount_id_c = $ci_events_items[$ci_events_cnt]['account_id_c'];

              $anon_params[0] = $relcontact_id_c; # Content owner
              $anon_params[1] = ""; # account_owner
              $anon_params[2] = $sess_contact_id; #contact_viewer
              $anon_params[3] = $sess_account_id; #account_viewer
              $anon_params[4] = $do;
              $anon_params[5] = $valtype;
              $anon_params[6] = $val;

              $show_namer = $funky_gear->anonymity($anon_params);

              if ($show_namer != NULL){
                 $show_name = $show_namer[0];
                 $show_description = $show_namer[1];
                 $profile_photo = $show_namer[2];
                 $contact_profile = $show_namer[3];
                 $events_contact .= $contact_profile;
                 } else {
                 $show_name = "Empty";
                 } 


              if ($sess_account_id != NULL && $relaccount_id_c == $sess_account_id){
                 $joined = TRUE;
                 }

              $edit = "";
              if ($sess_account_id != NULL && $relaccount_id_c == $sess_account_id || $auth==3){
                 $edit ="<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit_joiner&value=".$ci_event_id."&valuetype=wrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                 } 

              if ($relcontact_id_c == $sess_contact_id){
                 $concatter = "are";
                 } else {
                 $concatter = "is";
                 }

              $rel_sfx .= "<div style=\"".$divstyle_white."\">". $edit." ".$show_name." ".$concatter." <B>".$join_status_name."</B></div>";

              } # for

          if ($joined == FALSE){
             $rel_sfx .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_joiner&value=".$ci_wrapper_id."&valuetype=wrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54 size=3><B>Join this event!</B></font></a></div>";
             }

          } else {# is array

          $rel_sfx .= "<div style=\"".$divstyle_white."\"><font color=#151B54 size=3><B>There are no joiners to this event yet</B></font></div>";
          $rel_sfx .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_joiner&value=".$ci_wrapper_id."&valuetype=wrapper&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54 size=3><B>Join this event!</B></font></a></div>";


          } 

       } else {# is ci_wrapper_id

       $rel_sfx .= "<div style=\"".$divstyle_white."\"><font color=#151B54 size=3><B>There are no joiners to this event yet</B></font></div>";
       $rel_sfx .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add_joiner&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54 size=3><B>Join this event!</B></font></a></div>";

       } 

   echo $rel_sfx;

   break; // end list_joiners
   ######################################
   case 'add_joiner':
   case 'edit_joiner':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    $cit = '4c0973ff-da08-27a2-746b-55e30d4ac3bd';

    if ($valtype == $do){

       $process_object_type = "ConfigurationItems";
       $process_action = "update";

       $process_params = array();
       #$process_params[] = array('name'=>'id','value' => $ci);
       $process_params[] = array('name'=>'name','value' => $val);
       $process_params[] = array('name'=>'description','value' => $val);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $cit);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
       $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
   
       $wrapper_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       $ci_wrapper_id = $wrapper_result['id'];

       } elseif ($valtype == 'wrapper' && $action == 'edit_joiner'){

       $joiner_id = $val;

       $ci_object_type = 'ConfigurationItems';
       $ci_action = "select";
       $ci_params[0] = "id='".$val."' ";
       $ci_params[1] = "id,name,sclm_configurationitems_id_c,account_id_c,contact_id_c,cmn_statuses_id_c"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name"; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){ 

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $joiner_status = $ci_items[$cnt]['name'];
              $ci_wrapper_id = $ci_items[$cnt]['sclm_configurationitems_id_c'];
              $account_id_c = $ci_items[$cnt]['account_id_c'];
              $contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];

              } # for

          } # is array

       } elseif ($valtype == 'wrapper' && $action == 'add_joiner'){

       $ci_wrapper_id = $val;

       } 

    $join_statuses = '7de34f29-7b9c-5ea6-175e-55e3b406fb13';

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "id"; // Field Name
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
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $joiner_id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
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
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sendiv; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "ci_wrapper_id"; // Field Name
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
    $tablefields[$tblcnt][20] = "ci_wrapper_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $ci_wrapper_id; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = "Join Status"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='".$join_statuses."'"; // Exceptions
    $tablefields[$tblcnt][9][5] = $joiner_status; // Current Value

    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $joiner_status; // Field ID
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $joiner_status; //$field_value;

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
    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " id='".$sess_account_id."' "; // exception
       }
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
    $tablefields[$tblcnt][9][1] = 'accounts_contacts,contacts'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'first_name';

    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$sess_account_id."' && accounts_contacts.contact_id=contacts.id "; //
       }

    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

    $tblcnt++;

    if (!$cmn_statuses_id_c){
       $cmn_statuses_id_c = $standard_statuses_closed;
       }

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
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
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "send_notification"; // Field Name
    $tablefields[$tblcnt][1] = "Send Update Email?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "send_notification"; //$field_value_id;
    $tablefields[$tblcnt][21] = ""; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'recipient_types'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Recipients"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = ''; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = "12db0c6d-cc58-cbef-c092-555ad724ebd7"; // Field ID
    $tablefields[$tblcnt][20] = "recipient_types"; //$field_value_id;
    $tablefields[$tblcnt][21] = "12db0c6d-cc58-cbef-c092-555ad724ebd7"; //$field_value;

    $tblcnt++;

    /*
    $object_type = "Contacts";
    $api_action = "select_soap";
    $params = array();
    $params[0] = "contacts.id='".$sess_contact_id."'"; // query
    $params[1] = array("first_name","last_name","description","email1");
    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $api_action, $params);
    if (is_array ($result)){

       for ($cnt=0;$cnt < count($result);$cnt++){    
           $first_name = $result[$cnt]['first_name'];
           $last_name = $result[$cnt]['last_name'];
           $description = $result[$cnt]['description'];
           $email = $result[$cnt]['email1'];
           } // end for

       } // if array
    */

    $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Recipients"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = ''; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $sess_contact_id; // Field ID
    $tablefields[$tblcnt][20] = "contact_id1_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;

    /*
    $tablefields[$tblcnt][0] = 'recipient_types'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Recipients"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    # Provide available share options
    $dd_pack = $funky_messaging->message_recipient_selections();

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $recipient_types; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Current Value
    $tablefields[$tblcnt][9][7] = "recipient_types"; // reltable
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $recipient_types; // Field ID
    $tablefields[$tblcnt][20] = "recipient_types"; //$field_value_id;
    $tablefields[$tblcnt][21] = $recipient_types; //$field_value;  
    */

    /*
    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Description"]." ".$strings["message_required"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $description; // Field ID
    $tablefields[$tblcnt][12] = '50'; # length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;
    */

    $valpack = "";
    $valpack[0] = 'Effects';
    $valpack[1] = 'custom'; //
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = 'process_joiner'; //
    $valpack[7] = "Join";
    $valpack[8] = ""; 
    $valpack[10] = 'lightform';

    $relateform = $funky_gear->form_presentation($valpack);

    echo "<P><center><font size=3><B>Select another Shared Effect to create a relationship</B></font></center><P>";

    echo $relateform;

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

   break; // end list_joiners
   ######################################
   case 'process_joiner':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    $joiner_status = $_POST['name'];

    if (!$joiner_status){
       $joiner_status = '28a09531-3d3f-940b-b541-55e3b5a7c7e8';
       }

    $process_object_type = "ConfigurationItems";
    $process_action = "update";
    $process_params = array();  
    $process_params[] = array('name'=>'id','value' => $_POST['id']);
    $process_params[] = array('name'=>'name','value' => $joiner_status);
    $process_params[] = array('name'=>'description','value' => $joiner_status);
    $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['ci_wrapper_id']);
    $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
    $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
    $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
    $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

    $join_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
    $ci_joiner_id = $join_result['id'];

    $wrapper_id = $_POST['ci_wrapper_id'];
    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "id='".$wrapper_id."' ";
    $ci_params[1] = "name"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name"; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){ 

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $event_id = $ci_items[$cnt]['name'];

           }
       }

    $event_returner = $funky_gear->object_returner ("Effects", $event_id);
    $event_return_name = $event_returner[0];

    $joiner_result = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$event_id."&valuetype=".$valtype."');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\"><font color=#151B54 size=3><B>".$event_return_name."</font></a>";

    $send_update = $_POST['send_notification'];

    if ($send_update == 1){

       $message_link = "Body@".$lingo."@Effects@view@".$event_id."@Effects";
       $message_link = $funky_gear->encrypt($message_link);
       $message_link = "https://".$hostname."/?pc=".$message_link;

       $message_image = "https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-100x100.png";

       $message_body .= "\n\nYou have joined the Shared Effects event, ".$event_return_name.". \n\n";

       $message_body .= "\n\nPlease access via the following link:\n\n";
       $message_body .= $message_link;

       # Check for additional recipients for Google/FB/LinkedIn

       $msg_params[0] = $_POST;
       $msg_params[1] = $message_title;
       $msg_params[2] = $message_body;
       $msg_params[3] = $message_link;
       $msg_params[4] = $message_image;
       $msg_params[5] = $do;
       $msg_params[6] = $action;
       $msg_params[7] = $valtype;
       $msg_params[8] = $event_id;
       $msg_params[9] = ""; # Extra params - used by Effects event-sharing recipients

       $message_results = $funky_messaging->message_delivery ($msg_params);

       $message_id = $message_results[0];
       $emailresult = $message_results[1];

       #$message_message .= "<BR>".$emailresult;

       }

    $process_message = "<center><B>Joining ".$joiner_result." was successful!</B></center><BR>";
    echo "<div style=\"".$divstyle_white."\">".$process_message.$emailresult."</div>";

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

   break; // end add_joiner
   ######################################
   case 'list_related':

    # Add related events (not child) - get wrapper

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    #$ci_params[0] = "sclm_configurationitemtypes_id_c='e8fba75e-14a2-2056-f4ef-550b222f36fc' && name='".$val."' ";
    $ci_params[0] = "(sclm_configurationitemtypes_id_c='e8fba75e-14a2-2056-f4ef-550b222f36fc' || sclm_configurationitemtypes_id_c='c45dccee-5eac-9816-fc50-54fd6ee2c6d7' || sclm_configurationitemtypes_id_c='55f17a75-0dc8-b1a6-5779-54fd6b19b1c1' || sclm_configurationitemtypes_id_c='7e756b2f-e4ac-aa81-9868-54fd6e2653f5') && name='".$val."' ";
    $ci_params[1] = "id,name"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){ 

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_wrapper_id = $ci_items[$cnt]['id'];

           } # for

       } # is array

    #echo "Wrapper $ci_wrapper_id <P>";

    if ($ci_wrapper_id != NULL){

       # Gather any related items
       $ci_events_object_type = 'ConfigurationItems';
       $ci_events_action = "select";

       if ($auth == 3){
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' "; # parent
          } else {
          $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
          }

       $ci_events_params[1] = "id,name,description,account_id_c"; // select array
       $ci_events_params[2] = ""; // group;
       $ci_events_params[3] = " name, date_entered DESC "; // order;
       $ci_events_params[4] = ""; // limit
  
       $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

       if (is_array($ci_events_items)){          

          for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

              $ci_event_id = $ci_events_items[$ci_events_cnt]['id'];
              $sclm_events_id_c = $ci_events_items[$ci_events_cnt]['name'];
              $description = $ci_events_items[$ci_events_cnt]['description'];
              if ($description){
                 $description = "<P>".$description;
                 }
              $account_id_c = $ci_events_items[$ci_events_cnt]['account_id_c'];
              $sclm_events_returner = $funky_gear->object_returner ("Effects", $sclm_events_id_c);
              $event_return_name = $sclm_events_returner[0];

              $edit = "";
              if ($sess_account_id != NULL && $account_id_c == $sess_account_id || $auth==3){
                 $edit ="<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit_relationship&value=".$ci_event_id."&valuetype=Effects&sendiv=lightform');return false\"><font color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                 } 

              $rel_sfx .= "<div style=\"".$divstyle_white."\"><img src=images/SharedEffects-Action-50x50.png width=16 border=0 alt=".$event_name."> ".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$sclm_events_id_c."&valuetype=".$valtype."');return false\"><font color=#151B54 size=3><B>".$event_return_name."</B></font></a>".$description."</div>";

              } # for

          } # is array

       } # is ci_wrapper_id

     # Show backwards relationships that this event may be included in
     $ci_events_object_type = 'ConfigurationItems';
     $ci_events_action = "select";
     $ci_events_params[0] = "deleted=0 && name='".$val."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
     $ci_events_params[1] = "id,sclm_configurationitems_id_c"; // select array
     $ci_events_params[2] = ""; // group;
     $ci_events_params[3] = " name, date_entered DESC "; // order;
     $ci_events_params[4] = ""; // limit
  
     $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

     if (is_array($ci_events_items)){          

        for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

            $reverse_wrapper_id = $ci_events_items[$ci_events_cnt]['sclm_configurationitems_id_c'];

            $ci_object_type = 'ConfigurationItems';
            $ci_action = "select";
            $ci_params[0] = "id='".$reverse_wrapper_id."' ";
            $ci_params[1] = "id,name,account_id_c"; // select array
            $ci_params[2] = ""; // group;
            $ci_params[3] = " name, date_entered DESC "; // order;
            $ci_params[4] = ""; // limit
  
            $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

            if (is_array($ci_items)){          

               for ($cnt=0;$cnt < count($ci_items);$cnt++){

                   $related_ci_id = $ci_items[$cnt]['id'];
                   $related_event_id = $ci_items[$cnt]['name'];
                   $description = $ci_items[$cnt]['description'];
                   if ($description){
                      $description = "<P>".$description;
                      }
                   $account_id_c = $ci_items[$cnt]['account_id_c'];
                   $related_events_returner = $funky_gear->object_returner ("Effects", $related_event_id);
                   $related_event_name = $related_events_returner[0];

                   $edit = "";
                   if ($sess_account_id != NULL && $account_id_c == $sess_account_id){
                      $edit ="<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit_relationship&value=".$related_ci_id."&valuetype=Effects&sendiv=lightform');return false\"><font color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                      } 

                   $rel_sfx .= "<div style=\"".$divstyle_white."\"><img src=images/SharedEffects-Action-50x50.png width=16 border=0 alt=".$event_name."> ".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$related_event_id."&valuetype=".$valtype."');return false\"><font color=#151B54 size=3><B>".$related_event_name."</B></font></a>".$description."</div>";

                   } # for

               } # is array

            } # for

        } # is array

    if ($fb_app_id != NULL && $fb_app_secret != NULL && $allow_fb_rego == TRUE){

       require_once ("api-facebook.php");

       $fb_params[0] = "return_event"; #fb_action;
       $fb_params[1] = $fb_session; # userid

       $fbevents_cit = "8a2658e3-3e56-743c-a656-55196e298a99";
       # First see if this wrapper exists
       $fbw_event_query = " sclm_configurationitemtypes_id_c='".$fbevents_cit."' && name='".$val."' ";

       $fbwevent_object_type = "ConfigurationItems";
       $fbwevent_action = "select";
       $fbwevent_params[0] = $fbw_event_query;
       $fbwevent_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
       $fbwevent_params[2] = ""; // group;
       $fbwevent_params[3] = " name, date_entered DESC "; // order;
       $fbwevent_params[4] = ""; // limit

       $fbwevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbwevent_object_type, $fbwevent_action, $fbwevent_params);

       if (is_array($fbwevent_items)){    

          for ($fbweventcnt=0;$fbweventcnt < count($fbwevent_items);$fbweventcnt++){

              $fbwrapper_id = $fbwevent_items[$fbweventcnt]['id'];

              } # for

          if ($fbwrapper_id != NULL){

             $rel_sfx .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Related Facebook Events</B></font></center></div>";

             $process_object_type = "ConfigurationItems";
             $process_action = "update";

             # First see if this event exists
             $fb_event_query = " sclm_configurationitemtypes_id_c='".$fbevents_cit."'  && sclm_configurationitems_id_c='".$fbwrapper_id."' ";
             $fbevent_object_type = "ConfigurationItems";
             $fbevent_params[0] = $fb_event_query;
             $fbevent_action = "select";
             $fbevent_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
             $fbevent_params[2] = ""; // group;
             $fbevent_params[3] = " name, date_entered DESC "; // order;
             $fbevent_params[4] = ""; // limit

             $fbevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbevent_object_type, $fbevent_action, $fbevent_params);

             if (is_array($fbevent_items)){    

                for ($fbeventcnt=0;$fbeventcnt < count($fbevent_items);$fbeventcnt++){

                    $fb_ci_id = $fbevent_items[$fbeventcnt]['id'];
                    $fb_params[2] = $fb_ci_id; # fb_ci_id

                    $fb_eventpack = do_facebook ($fb_params);

                    $fb_event = $fb_eventpack[0];

                    $fb_event_id = $fb_event['id'];
                    $fb_event_name = $fb_event['name'];

                    $fb_description = $fb_event['description'];
                    $end_time = $fb_event['end_time'];
                    $start_time = $fb_event['start_time'];
                    $updated_time = $value['updated_time'];
                    $is_date_only = $fb_event['is_date_only'];
                    $location = $fb_event['location'];

                    $owner_array = $fb_event['owner'];
                    $owner_id = $owner_array['id'];
                    $owner_name = $owner_array['name'];
                    $fb_privacy = $fb_event['privacy'];
                    $timezone = $value['timezone'];

                    $venue = $fb_event['venue'];
                    $venue_id = $venue['id'];
                    $city = $venue['city'];
                    $country = $venue['country'];
                    $latitude = $venue['latitude'];
                    $longitude = $venue['longitude'];
                    $state = $venue['state'];
                    $street = $venue['street'];
                    $zip = $venue['zip'];

                    $fb_url = "";
                    $fb_url = "https://www.facebook.com/events/".$fb_event_id."/";
               
                    $rel_sfx .= "<div style=\"".$divstyle_white."\"><img src=images/icons/FacebookIcon.png width=16 border=0 alt=".$fb_ci_id."> <a href=".$fb_url." target=".$fb_url."><font color=#151B54 size=3><B>".$fb_event_name."</B></font></a> <font color=#151B54 size=2>".$fb_description."</font></div>";

                    } # for

                } # is_array

             } # fbwrapper_id

          } # fbwevent_items

       } # allow_fb_rego

     echo "<div style=\"".$divstyle_blue_light."\" name='RELATIONSHIPS' id='RELATIONSHIPS'>".$rel_sfx."</div>";

   break; // end view
   ######################################
   case 'build_relater':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    # Provide the types of relationships that can be built for any event  
    # Related Events | ID: e8fba75e-14a2-2056-f4ef-550b222f36fc
    # Virtual Parent Event | ID: 55f17a75-0dc8-b1a6-5779-54fd6b19b1c1
    # Virtual Related Event | ID: 7e756b2f-e4ac-aa81-9868-54fd6e2653f5
    # Virtual Sub Event | ID: c45dccee-5eac-9816-fc50-54fd6ee2c6d7

          /*
          $tblcnt = 0;

          $tablefields[$tblcnt][0] = "sendiv"; // Field Name
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
          $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
          $tablefields[$tblcnt][21] = 'lightform'; //$field_value;   
          */

          $tblcnt = 0;

          $tablefields[$tblcnt][0] = "value"; // Field Name
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
          $tablefields[$tblcnt][20] = "value"; //$field_value_id;
          $tablefields[$tblcnt][21] = $val; //$field_value;   

          $tblcnt++;

          # Need to remove existing relationships

          $ci_object_type = 'ConfigurationItems';
          $ci_action = "select";
          $ci_params[0] = "(sclm_configurationitemtypes_id_c='e8fba75e-14a2-2056-f4ef-550b222f36fc' || sclm_configurationitemtypes_id_c='c45dccee-5eac-9816-fc50-54fd6ee2c6d7' || sclm_configurationitemtypes_id_c='55f17a75-0dc8-b1a6-5779-54fd6b19b1c1' || sclm_configurationitemtypes_id_c='7e756b2f-e4ac-aa81-9868-54fd6e2653f5') && name='".$val."' ";
          $ci_params[1] = "id,name"; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = " name, date_entered DESC "; // order;
          $ci_params[4] = ""; // limit
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){          

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

                 $ci_wrapper_id = $ci_items[$cnt]['id'];

                 } # for

             } # is array

          if ($ci_wrapper_id != NULL){

             # Gather any related items
             $ci_events_object_type = 'ConfigurationItems';
             $ci_events_action = "select";

             if ($auth == 3){
                $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' "; # parent
                } else {
                $ci_events_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$ci_wrapper_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
                }

             $ci_events_params[1] = "id,name"; // select array
             $ci_events_params[2] = ""; // group;
             $ci_events_params[3] = " name, date_entered DESC "; // order;
             $ci_events_params[4] = ""; // limit
  
             $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

             if (is_array($ci_events_items)){          

                for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

                    $ci_event_id = $ci_events_items[$ci_events_cnt]['id'];
                    $sclm_events_id_c = $ci_events_items[$ci_events_cnt]['name'];

                    $exceptions .= " && id != '".$sclm_events_id_c."' ";

                    } # for

                } # is array

             } # if wrapper

          # Show backwards relationships that this event may NOT be included in
          $ci_events_object_type = 'ConfigurationItems';
          $ci_events_action = "select";
          $ci_events_params[0] = "deleted=0 && name='".$val."' "; # parent
          $ci_events_params[1] = "id,sclm_configurationitems_id_c"; // select array
          $ci_events_params[2] = ""; // group;
          $ci_events_params[3] = " name, date_entered DESC "; // order;
          $ci_events_params[4] = ""; // limit
  
          $ci_events_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_events_object_type, $ci_events_action, $ci_events_params);

          if (is_array($ci_events_items)){          

             for ($ci_events_cnt=0;$ci_events_cnt < count($ci_events_items);$ci_events_cnt++){

                 $reverse_wrapper_id = $ci_events_items[$ci_events_cnt]['sclm_configurationitems_id_c'];

                 $ci_object_type = 'ConfigurationItems';
                 $ci_action = "select";
                 $ci_params[0] = "id='".$reverse_wrapper_id."' ";
                 $ci_params[1] = "id,name"; // select array
                 $ci_params[2] = ""; // group;
                 $ci_params[3] = " name, date_entered DESC "; // order;
                 $ci_params[4] = ""; // limit
  
                 $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

                 if (is_array($ci_items)){          

                    for ($cnt=0;$cnt < count($ci_items);$cnt++){

                        $related_event_id = $ci_items[$cnt]['name'];

                        $exceptions .= " && id != '".$related_event_id."' ";
     
                        } # for

                    } # is array

                 } # for

             } # is array

          $ci_object_type = 'Events';
          $ci_action = "select";

          if ($auth == 3){

             $ci_params[0] = "id != '".$val."' ".$exceptions." "; 

             } elseif ($auth == 2) {

             $ci_params[0] = "id != '".$val."' ".$exceptions." && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; 
 
             } else {

             $ci_params[0] = "id != '".$val."' ".$exceptions." && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') "; 
 
             } 

          $ci_params[1] = "id,start_date,start_years,name"; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = "start_date,start_years, name DESC "; // order;
          $ci_params[4] = ""; // limit
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){          

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

                 $event_id = $ci_items[$cnt]['id'];
                 $event_name = $ci_items[$cnt]['name'];
                 $startdate = $ci_items[$cnt]['start_date'];
                 $start_years = $ci_items[$cnt]['start_years'];
                 if ($startdate == NULL){
                    $startdate = $start_years;
                    }
                 $dd_pack[$event_id] = $startdate.": ".$event_name;
           
                 } # for
      
            } # is array

          $tablefields[$tblcnt][0] = 'sclm_events_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Effect"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table    
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = '';
          $tablefields[$tblcnt][9][5] = ""; // Current Value
          $tablefields[$tblcnt][9][6] = "";
          $tablefields[$tblcnt][9][7] = "";
          $tablefields[$tblcnt][9][8] = "";
          $tablefields[$tblcnt][9][9] = "";
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ''; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_events_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = ""; //$field_value;

          $tblcnt++;

    # Related Events | ID: e8fba75e-14a2-2056-f4ef-550b222f36fc
    # Virtual Parent Event | ID: 55f17a75-0dc8-b1a6-5779-54fd6b19b1c1
    # Virtual Related Event | ID: 7e756b2f-e4ac-aa81-9868-54fd6e2653f5
    # Virtual Sub Event | ID: c45dccee-5eac-9816-fc50-54fd6ee2c6d7

          $rel_pack['e8fba75e-14a2-2056-f4ef-550b222f36fc'] = "Related Event (Actual)";
          $rel_pack['55f17a75-0dc8-b1a6-5779-54fd6b19b1c1'] = "Virtual Parent Event";
          $rel_pack['7e756b2f-e4ac-aa81-9868-54fd6e2653f5'] = "Virtual Related Event";
          $rel_pack['c45dccee-5eac-9816-fc50-54fd6ee2c6d7'] = "Virtual Sub Event";

          $tablefields[$tblcnt][0] = 'relationship_type'; // Field Name
          $tablefields[$tblcnt][1] = "Relationship Type"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $rel_pack; // If DB, dropdown_table, if List, then array, other related table    
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = '';
          $tablefields[$tblcnt][9][5] = ""; // Current Value
          $tablefields[$tblcnt][9][6] = "";
          $tablefields[$tblcnt][9][7] = "";
          $tablefields[$tblcnt][9][8] = "";
          $tablefields[$tblcnt][9][9] = "";
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ''; // Field ID
          $tablefields[$tblcnt][20] = 'relationship_type';//$field_value_id;
          $tablefields[$tblcnt][21] = ""; //$field_value;

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
          if ($auth == 3){
             $tablefields[$tblcnt][9][4] = ""; // exception
             } else {
             $tablefields[$tblcnt][9][4] = " id='".$sess_account_id."' "; // exception
             }
          $tablefields[$tblcnt][9][5] = $sess_account_id; // Current Value
          $tablefields[$tblcnt][9][6] = 'Accounts';
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sess_account_id; //$field_value;   

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
          $tablefields[$tblcnt][9][1] = 'accounts_contacts,contacts'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'first_name';

          if ($auth == 3){
             $tablefields[$tblcnt][9][4] = ""; // exception
             } else {
             $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$sess_account_id."' && accounts_contacts.contact_id=contacts.id "; //
             }

          $tablefields[$tblcnt][9][5] = $sess_contact_id; // Current Value
          $tablefields[$tblcnt][9][6] = 'Contacts';
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;   

          $tblcnt++;

          if (!$cmn_statuses_id_c){
             $cmn_statuses_id_c = $standard_statuses_closed;
             }

          $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
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
          #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
          $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = "description"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Description"]." ".$strings["message_required"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $description; // Field ID
          $tablefields[$tblcnt][12] = '50'; # length
          $tablefields[$tblcnt][20] = "description"; //$field_value_id;
          $tablefields[$tblcnt][21] = $description; //$field_value;

          $valpack = "";
          $valpack[0] = 'Effects';
          $valpack[1] = 'custom'; //
          $valpack[2] = $valtype;
          $valpack[3] = $tablefields;
          $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
          $valpack[5] = "";
          $valpack[6] = 'process_relationship'; //
          $valpack[7] = $strings["action_create_relationship"];
          $valpack[8] = ""; 
          #$valpack[10] = 'lightform';

          $relateform = $funky_gear->form_presentation($valpack);

          echo "<P><center><font size=3><B>Select another Shared Effect to create a relationship</B></font></center><P>";

          echo $relateform;


   break; // end build_relater
   ######################################
   case 'edit_relationship':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "id='".$val."' ";
    $ci_params[1] = "id,name,description,cmn_statuses_id_c,account_id_c,contact_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $description = $ci_items[$cnt]['description'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $sclm_events_id_c = $ci_items[$cnt]['name'];

           } # for

       } # is array

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "value"; // Field Name
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
    $tablefields[$tblcnt][20] = "value"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;   

    $tblcnt++;

    $ci_object_type = 'Events';
    $ci_action = "select";

    if ($auth == 3){

       $ci_params[0] = " "; 

       } elseif ($auth == 2) {

       $ci_params[0] = "(cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; 
 
       } else {

       $ci_params[0] = "(cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') "; 
 
       } 

    $ci_params[1] = "id,start_date,name"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = "start_date,name DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $event_id = $ci_items[$cnt]['id'];
           $event_name = $ci_items[$cnt]['name'];
           $start_date = $ci_items[$cnt]['start_date'];
           $dd_pack[$event_id] = $start_date.": ".$event_name;
     
           } # for

      } # is array

    $tablefields[$tblcnt][0] = 'sclm_events_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Effect"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table    
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][5] = $sclm_events_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = "";
    $tablefields[$tblcnt][9][7] = "";
    $tablefields[$tblcnt][9][8] = "";
    $tablefields[$tblcnt][9][9] = "";
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $sclm_events_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_events_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value;
    #$tablefields[$tblcnt][50] = " CONCAT(start_date, ': ', name) as 'namedate' ";

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
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
    $tablefields[$tblcnt][11] = 'lightform'; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = 'lightform'; //$field_value;   

    $tblcnt++;

    if (!$cmn_statuses_id_c){
       $cmn_statuses_id_c = $standard_statuses_closed;
       }

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
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
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

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
    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " id='".$account_id_c."' "; // exception
       }
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
    $tablefields[$tblcnt][9][1] = 'accounts_contacts,contacts'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'first_name';

    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$account_id_c."' && accounts_contacts.contact_id=contacts.id "; // exception
       }

    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Description"]." ".$strings["message_required"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $description; // Field ID
    $tablefields[$tblcnt][12] = '50'; # length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;

    $valpack = "";
    $valpack[0] = 'Effects';
    $valpack[1] = 'custom'; //
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = 'process_rel_edit'; //
    $valpack[7] = $strings["action_edit"];
    $valpack[8] = ""; 
    $valpack[9] = ""; 
    $valpack[10] = 'lightform';

    echo $funky_gear->form_presentation($valpack);

   break; // end edit_relationship
   case 'process_rel_edit':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $cmn_statuses_id_c = $_POST['cmn_statuses_id_c'];
    $sclm_events_id_c = $_POST['sclm_events_id_c'];
    $description = $_POST['description'];

     if ($val != NULL && $cmn_statuses_id_c != NULL){

        $process_object_type = "ConfigurationItems";
        $process_action = "update";
        $process_params = array();  
        $process_params[] = array('name'=>'id','value' => $val);
        $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
        $process_params[] = array('name'=>'description','value' => $description);
        $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id']);
        $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id']);
        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

        $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
        $ci_relevent_id = $rel_result['id'];

       $process_message = "<center><B>Editing the relationship was successful!</B></center><BR>";
       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";

       } # if vals

   break; // end edit_relationship
   case 'process_relationship':

    echo $object_return;

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    # Check if related events wrapper exists - if not, create!
    $par_event_id = $_POST['value'];
    $sclm_events_id_c = $_POST['sclm_events_id_c'];
    $cmn_statuses_id_c = $_POST['cmn_statuses_id_c'];
    $description = $_POST['description'];
    $relationship_type = $_POST['relationship_type'];

    if (!$cmn_statuses_id_c){
       $cmn_statuses_id_c = $standard_statuses_closed;
       }

    #echo "Par: $par_event_id & related $sclm_events_id_c  <BR>";

    if ($par_event_id != NULL && $sclm_events_id_c != NULL){

       $cit = $relationship_type; # Related CIT
       if ($relationship_type == NULL){
          $cit = 'e8fba75e-14a2-2056-f4ef-550b222f36fc'; # Related Events
          }

       # Related Events | ID: e8fba75e-14a2-2056-f4ef-550b222f36fc
       # Virtual Parent Event | ID: 55f17a75-0dc8-b1a6-5779-54fd6b19b1c1
       # Virtual Related Event | ID: 7e756b2f-e4ac-aa81-9868-54fd6e2653f5
       # Virtual Sub Event | ID: c45dccee-5eac-9816-fc50-54fd6ee2c6d7

       # Provide a selection of type of related event

       $ci_object_type = 'ConfigurationItems';
       $ci_action = "select";
       $ci_params[0] = "sclm_configurationitemtypes_id_c='".$cit."' && name='".$par_event_id."' ";
       $ci_params[1] = "id,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              # Gather the wrapper ID
              $ci_wrapper_id = $ci_items[$cnt]['id'];
              }

          } # is array - end create wrapper

       if ($ci_wrapper_id != NULL){
          # Should be here if an array!
   
          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
          $process_params[] = array('name'=>'description','value' => $description);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $ci_wrapper_id);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id']);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

          $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
          $ci_relevent_id = $rel_result['id'];

          $event_returner = $funky_gear->object_returner ("Effects", $par_event_id);
          $event_return_name = $event_returner[0];

          $relate_result = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$par_event_id."&valuetype=".$valtype."');return false\"><font color=#151B54 size=3><B>".$event_return_name."</font></a>";

          } else {
          # No wrapper exists - create
       
          $process_object_type = "ConfigurationItems";
          $process_action = "update";

          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $par_event_id);
          $process_params[] = array('name'=>'description','value' => $description);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
          $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
   
          $wrapper_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $ci_wrapper_id = $wrapper_result['id'];
 
          $process_object_type = "ConfigurationItems";
          $process_action = "update";
   
          $process_params = array();  
          #$process_params[] = array('name'=>'id','value' => $ci);
          $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
          $process_params[] = array('name'=>'description','value' => $description);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $ci_wrapper_id);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
          $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

          $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $ci_relevent_id = $rel_result['id'];
 
          $event_returner = $funky_gear->object_returner ("Effects", $par_event_id);
          $event_return_name = $event_returner[0];

          $relate_result = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$par_event_id."&valuetype=".$valtype."');return false\"><font color=#151B54 size=3><B>".$event_return_name."</font></a>";

          } # is array - end create wrapper

       $process_message = "<center><B>Creating the relationship was successful!</B></center><BR>";
       $process_message .= $relate_result."<BR>".$description;
       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";

       #echo $this->funkydone ($_POST,$lingo,'Effects','list_related',$par_event_id,$do,$bodywidth);
       #echo $this->funkydone ($_POST,$lingo,'Effects','build_relater',$par_event_id,$do,$bodywidth);

       } else {

       echo "<div style=\"".$divstyle_orange."\">No Parent or Child Events Values!</div>";

       }

   break; // end 
   ######################################
   case 'external_content':

    echo "<center><a href=\"#\" onClick=\"cleardiv('autoform');document.getElementById('autoform').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    #echo "<iframe src=auto-completer.php?value=".$val."&valuetype=".$valtype." height=270 width=98></iframe>";

    $orig_action = $_GET['orig_action'];
    if (!$orig_action){
       $orig_action = $_POST['orig_action'];
       }

    $add_parent = $_GET['add_parent'];
    if (!$add_parent){
       $add_parent = $_POST['add_parent'];
       }

    $external_menu = "<div style=\"".$divstyle_white."\"><center>";
    $external_menu .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wikipedia\" id=\"wikipedia\" value=\"Wikipedia\" onClick=\"loader('autoform');document.getElementById('autoform').style.display='block';doBPOSTRequest('autoform','Wikipedia.php','action=search&sendiv=autoform&value=".$val."&valuetype=".$do."&orig_action=".$orig_action."&add_parent=".$add_parent."');return false\">";

    if ($allow_google_rego == TRUE && $gg_session != NULL){
       $external_menu .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"gcal\" id=\"gcal\" value=\"Google Calendars\" onClick=\"loader('autoform');document.getElementById('autoform').style.display='block';doBPOSTRequest('autoform','Google.php','action=list_calenders&sendiv=autoform&value=".$val."&valuetype=".$do."&orig_action=".$orig_action."&add_parent=".$add_parent."');return false\">";
       }

    if ($allow_fb_rego == TRUE && $fb_session != NULL){
       $external_menu .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb\" id=\"fb\" value=\"Facebook Events\" onClick=\"loader('autoform');document.getElementById('autoform').style.display='block';doBPOSTRequest('autoform','Facebook.php','action=list_events&sendiv=autoform&value=".$val."&valuetype=".$do."&orig_action=".$orig_action."&add_parent=".$add_parent."');return false\">";
       }

    $external_menu .= "</center></div>";

    echo $external_menu;

    $external_content = "<div style=\"".$divstyle_white."\">";

    $external_content .= <<< EXTCONT
<p><font size=2>Please select your desired source for new content.</p>
* Events in Shared Effects can be based on any event in time - public or private
<BR>* First, do a search in Shared Effects to see if the event exists already
<BR>* Much of the public event content has been derived from Wikipedia and other online sources
<BR>* You can make private events (and sub-events) based on any public event
</font>

EXTCONT;

    $external_content .= "</div>";
    echo $external_content;

   break; // end 
   case 'add':
   case 'add_related':
   case 'add_virtual_related':
   case 'add_virtual_parent':
   case 'add_virtual_child':
   case 'edit':

    $add_parent = $_GET['add_parent'];
    if (!$add_parent){
       $add_parent = $_POST['add_parent'];
       }

    if ($sendiv == 'lightform'){

       echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       echo "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"external_content\" id=\"external_content\" value=\"Add External Content\" onClick=\"document.getElementById('autoform').style.display='block';doBPOSTRequest('autoform','Body.php','do=Effects&valuetype=Effects&value=".$val."&action=external_content&orig_action=".$action."&add_parent=".$add_parent."');return false\"></center></div>";

       }

    # Source = wikipedia/fb event, google calendar
    $source = $_GET['source'];
    if (!$source){
       $source = $_POST['source'];
       }

    if ($source != NULL){

       switch ($source){

        case 'wikipedia':

         $source_title = $_GET['source_title'];
         if (!$source_title){
            $source_title = $_POST['source_title'];
            }

         #echo "source_title: ".$source_title."<BR>";
         $url_keyword = urlencode($source_title);
         $url = "http://en.wikipedia.org/w/api.php?action=query&titles=".$url_keyword."&prop=extracts&rvsection=0&format=json";

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
         curl_setopt($ch, CURLOPT_USERAGENT, 'MyBot/1.0 (https://www.sharedeffects.com/)');

         $result = curl_exec($ch);

         if (!$result) {
            exit('cURL Error: '.curl_error($ch));
            } else {

            #Jekyll Island
            $content_array = json_decode($result, true);

            foreach ($content_array['query']['pages'] as $content){

                    #$pageid = $content['pageid'];
                    #echo "Page ID: ".$pageid."<BR>";
                    $title = $content['title'];
                    $description = $content['extract'];

                  } # foreach

            $site_keyword = $funky_gear->replacer(" ","_", $source_title);
            $external_url = "https://en.wikipedia.org/wiki/".$site_keyword;

            } # if result

        break;

       } # switch
       
       } # if source

    ###########################
    # DHTML Window for tips

//echo "<center><a href=\"#\" onClick=\"customFunctionCreateWindow(false,150,300,300,300);return false\"><B>Tips</B></a></center><P>";

    # DHTML Window for tips
    ###########################


    if ($action == 'edit'){

       $events_object_type = "Events";
       $events_action = "select";
       $events_params = array();
       $events_params[0] = " id ='".$val."' ";
       $events_params[1] = "";
       $events_params[2] = "";
       $events_params[3] = "";
       $events_params[4] = "";
   
       $events = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $events_object_type, $events_action, $events_params);

       if (is_array($events)){

          for ($cnt=0;$cnt < count($events);$cnt++){

              $id = $events[$cnt]['id'];
              $title = $events[$cnt]['name'];
              $date_entered = $events[$cnt]['date_entered'];
              $date_modified = $events[$cnt]['date_modified'];
              $modified_user_id = $events[$cnt]['modified_user_id'];
              $created_by = $events[$cnt]['created_by'];
              $description = $events[$cnt]['description'];
              $assigned_user_id = $events[$cnt]['assigned_user_id'];

              $account_id_c = $events[$cnt]['account_id_c'];
              $contact_id_c = $events[$cnt]['contact_id_c'];
              $contact_name = $events[$cnt]['contact_name'];

              $cmn_statuses_id_c = $events[$cnt]['cmn_statuses_id_c'];
              $cmn_languages_id_c = $events[$cnt]['cmn_languages_id_c'];
              $cmn_countries_id_c = $events[$cnt]['cmn_countries_id_c'];
              $cmn_currencies_id_c = $events[$cnt]['cmn_currencies_id_c'];
              $currency = $effects[$cnt]['currency'];

              $view_count = $events[$cnt]['view_count'];
              $time_frame_id = $events[$cnt]['time_frame_id'];
              $time_frame = $events[$cnt]['time_frame'];

              $sclm_events_id_c = $events[$cnt]['sclm_events_id_c'];
              $parent_event_name = $events[$cnt]['parent_event_name'];
 
              $start_date = $events[$cnt]['start_date'];
              $end_date = $events[$cnt]['end_date'];

              $object_type_id = $events[$cnt]['object_type_id'];
              $object_value = $events[$cnt]['object_value'];

              $street = $events[$cnt]['street'];
              $city = $events[$cnt]['city'];
              $state = $events[$cnt]['state'];
              $zip = $events[$cnt]['zip'];
              $latitude = $events[$cnt]['latitude'];
              $longitude = $events[$cnt]['longitude'];
              $fb_event_id = $events[$cnt]['fb_event_id'];
              $event_url = $events[$cnt]['event_url'];
              $location = $events[$cnt]['location'];

              $value_type_value = $events[$cnt]['value'];
              $positivity = $events[$cnt]['positivity'];
              $probability = $events[$cnt]['probability'];

              $group_type_id = $events[$cnt]['group_type_id'];
              $group_type_name = $events[$cnt]['group_type_name'];

              $value_type_id = $events[$cnt]['value_type_id'];
              $value_type_name = $events[$cnt]['value_type_name'];

              $purpose_id = $events[$cnt]['purpose_id'];
              $purpose = $events[$cnt]['purpose'];

              $emotion_id = $events[$cnt]['emotion_id'];
              $emotion = $events[$cnt]['emotion'];

              $ethics_id = $events[$cnt]['ethics_id'];
              $ethics = $events[$cnt]['ethics'];

              $sibaseunit_id = $events[$cnt]['sibaseunit_id'];
              $sibaseunit = $events[$cnt]['sibaseunit'];
 
              $external_source_id = $events[$cnt]['external_source_id'];
              $source_object_id = $events[$cnt]['source_object_id'];
              $source_object_item_id = $events[$cnt]['source_object_item_id'];
              $object_id = $events[$cnt]['object_id'];
              $external_url = $events[$cnt]['external_url'];
              $event_type = $events[$cnt]['event_type'];
              $rsvp_status = $events[$cnt]['rsvp_status'];
              $serial_number = $events[$cnt]['serial_number'];
              $category_id = $events[$cnt]['category_id'];

              $cmv_politicalparties_id_c = $events[$cnt]['cmv_politicalparties_id_c'];
              $cmv_politicalpartyroles_id_c = $events[$cnt]['cmv_politicalpartyroles_id_c'];

              $cmv_governments_id_c = $events[$cnt]['cmv_governments_id_c'];
              $cmv_governmentroles_id_c = $events[$cnt]['cmv_governmentroles_id_c'];
              $cmv_governmentpolicies_id_c = $events[$cnt]['cmv_governmentpolicies_id_c'];
              $cmv_governmentconstitutions_id_c = $events[$cnt]['cmv_governmentconstitutions_id_c'];

              $cmv_departmentagencies_id_c = $events[$cnt]['cmv_departmentagencies_id_c'];

              $cmv_branchbodies_id_c = $events[$cnt]['cmv_branchbodies_id_c'];
              $cmv_branchdepartments_id_c = $events[$cnt]['cmv_branchdepartments_id_c'];
   
              $cmv_causes_id_c = $events[$cnt]['cmv_causes_id_c'];

              $cmv_independentagencies_id_c = $events[$cnt]['cmv_independentagencies_id_c'];
              $cmv_organisations_id_c = $events[$cnt]['cmv_organisations_id_c'];

              $cmv_constitutionalarticles_id_c = $events[$cnt]['cmv_constitutionalarticles_id_c'];
              $cmv_constitutionalamendments_id_c = $events[$cnt]['cmv_constitutionalamendments_id_c'];

              $social_networking_id = $events[$cnt]['social_networking_id'];
              $portal_account_id = $events[$cnt]['portal_account_id'];

              $event_image_url = $events[$cnt]['event_image_url'];
              $menstruation_phase_id = $events[$cnt]['menstruation_phase_id'];

              $start_years = $events[$cnt]['start_years'];
              $end_years = $events[$cnt]['end_years'];

              $allow_joiners = $events[$cnt]['allow_joiners'];

              } # for

          $id = $val;

          } # if array

       } # edit

    if ($action == 'add' && ($valtype == 'Events' || $valtype == 'Effects')){

       $sclm_events_id_c = $val;

      }

    if ($action == 'add' && $valtype == 'Facebook' && $fb_app_id != NULL && $fb_app_secret != NULL && $allow_fb_rego == TRUE){

       require_once ("api-facebook.php");

       $fb_params[0] = "return_event"; #fb_action;
       $fb_params[1] = $fb_session; # userid
       $fb_params[2] = $val; # fb_ci_id

       $fb_eventpack = do_facebook ($fb_params);

       $fb_event = $fb_eventpack[0];

       $fb_event_id = $fb_event['id'];
       $title = $fb_event['name'];

       $description = $fb_event['description'];
       $end_date = $fb_event['end_time'];
       $start_date = $fb_event['start_time'];

       list ($start_datepart,$start_timepart) = explode ("T", $start_date);
       list ($start_time,$start_timezone) = explode ("+", $start_timepart);
       $start_date = $start_datepart." ".$start_time;
       list ($end_datepart,$end_timepart) = explode ("T", $end_date);
       list ($end_time,$end_timezone) = explode ("+", $end_timepart);
       $end_date = $end_datepart." ".$end_time;

       $updated_time = $fb_event['updated_time'];
       $is_date_only = $fb_event['is_date_only'];

       $location = $fb_event['location'];

       $owner_array = $fb_event['owner'];
       $owner_id = $owner_array['id'];
       $owner_name = $owner_array['name'];

       $fb_privacy = $fb_event['privacy'];
       $timezone = $fb_event['timezone'];

       $venue = $fb_event['venue'];
       $venue_id = $venue['id'];
       $city = $venue['city'];
       $country = $venue['country'];
       $latitude = $venue['latitude'];
       $longitude = $venue['longitude'];
       $state = $venue['state'];
       $street = $venue['street'];
       $zip = $venue['zip'];

       $show_venue = "Location: ".$location."<BR>Street: ".$street."<BR>City: ".$city."<BR>State: ".$state."<BR>Country: ".$country."<BR>Zip: ".$zip."<BR>Latitude: ".$latitude."<BR>Longitude: ".$longitude;

       $fb_url = "";
       $fb_url = "https://www.facebook.com/events/".$fb_event_id."/";
               
       $fb_url = "<a href=".$fb_url." target=".$fb_event_id."><font color=#151B54 size=3><B>".$title."</B></font></a>";

       $fb_message .= "<div style='width: 98%; max-height:300px;overflow:scroll; padding: 0.5em; resize: both;'><div style=\"".$divstyle_white."\"><img src=images/icons/FacebookIcon.png width=16 border=0 alt=".$fb_event_id."> ".$fb_url."<BR><font color=#151B54 size=2>".$description."<BR>".$show_venue."</font></div></div>";

       $fb_message = "<P>You have successfully grabbed a Facebook event to post to Shared Effects!";
       $fb_message = "<div style=\"".$divstyle_white."\">".$fb_message."</div>";  

       } elseif ($action == 'add' && $valtype == 'Google' && $gg_session != NULL){ # if

       require_once ("api-google.php");

       $this_cal = $_POST['cal'];

       $gg_params[0] = "view_event"; #
       $gg_params[1] = $gg_session; # use
       $gg_params[2] = $this_cal; # cal
       $gg_params[3] = $val; #event 
       #$gg_params[4] = $gg_end_date; 
       #$gg_params[5] = $search_keyword; 

       $google_cal_event = do_google ($gg_params);

       if (is_array($google_cal_event)){

          $gg_event_id = $google_cal_event['id'];

          $title = $google_cal_event['summary'];
          $description = $google_cal_event['description'];
          $start_date = $google_cal_event['start_date'];       
          $end_date = $google_cal_event['end_date'];
          $location = $google_cal_event['location'];           

          $etag = $google_cal_event['etag'];
          $created = $google_cal_event['created'];
          $updated = $google_cal_event['updated'];
          $status = $google_cal_event['status'];

          $creator = $google_cal_event['creator'];
          $creator_id = $google_cal_event['creator_id'];
          $creator_displayName = $google_cal_event['creator_displayName'];
          $attendees = $google_cal_event['attendees'];

          $gg_message = "<P>You have successfully grabbed a Google event to post to Shared Effects!";
          $gg_message = "<div style=\"".$divstyle_white."\">".$gg_message."</div>";  

          } # if array
   
       } # else

    $tblcnt = 0; // first set
      
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

    if ($valtype == 'SocialNetworking'){
       $social_networking_id = $val;
       }

    if ($valtype == 'ProjectTasks'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "project_task_id"; // Field Name
       $tablefields[$tblcnt][1] = "Project Task"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = "project_task_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;   

       }

    if ($action == 'add_related'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "add_related"; // Field Name
       $tablefields[$tblcnt][1] = "Add Related"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = "add_related"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;   

       } # add related

    if ($action == 'add_virtual_related'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "add_virtual_related"; // Field Name
       $tablefields[$tblcnt][1] = "Add Virtual Related"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = "add_virtual_related"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;   

       } # add add_virtual_related

    if ($action == 'add_virtual_parent'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "add_virtual_parent"; // Field Name
       $tablefields[$tblcnt][1] = "Add Virtual Parent"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = "add_virtual_parent"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;   

       } # add add_virtual_parent

    if ($action == 'add_virtual_child'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "add_virtual_child"; // Field Name
       $tablefields[$tblcnt][1] = "Add Virtual Child"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = "add_virtual_child"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;   

       } # add add_virtual_parent

    $tblcnt++;

    $tablefields[$tblcnt][0] = "social_networking_id"; // Field Name
    $tablefields[$tblcnt][1] = "social_networking_id"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $social_networking_id; // Field ID
    $tablefields[$tblcnt][20] = "social_networking_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $social_networking_id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "portal_account_id"; // Field Name
    $tablefields[$tblcnt][1] = "portal_account_id"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $portal_account_id; // Field ID
    $tablefields[$tblcnt][20] = "portal_account_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $portal_account_id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "view_count"; // Field Name
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
    $tablefields[$tblcnt][11] = $view_count; // Field ID
    $tablefields[$tblcnt][20] = "view_count"; //$field_value_id;
    $tablefields[$tblcnt][21] = $view_count; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
    $tablefields[$tblcnt][1] = "Sendiv"; // Full Name
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
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sendiv; //$field_value;   

    if (($valtype == 'Effects' || $valtype == 'Events') && ($action == 'add') && ($val != NULL) && ($sclm_events_id_c == NULL)){
       $sclm_events_id_c = $val;
       }
       
    $add_parent = $_POST['add_parent'];

    if ($add_parent == 1){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "add_parent"; // Field Name
       $tablefields[$tblcnt][1] = "Parent"; // Full Name
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
       $tablefields[$tblcnt][20] = "add_parent"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value;   

       } else {

       $tblcnt++;

       $ci_object_type = 'Events';
       $ci_action = "select";

       if ($auth == 3){

          $ci_params[0] = " deleted=0 ";

          } elseif ($valtype == 'Effects' && $val != NULL && $action == "add") {

          $ci_params[0] = " id='".$val."'";

          } elseif ($auth == 2) {

          $ci_params[0] = "(cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; 
 
          } else {

          $ci_params[0] = "(cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') "; 
 
          } 

       $ci_params[1] = "id,deleted,start_date,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "start_date,name DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){          

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $event_id = $ci_items[$cnt]['id'];
              $event_name = $ci_items[$cnt]['name'];
              $startdate = $ci_items[$cnt]['start_date'];
              $dd_pack[$event_id] = $startdate.": ".$event_name;
     
              } # for

         } # is array

       $tablefields[$tblcnt][0] = 'sclm_events_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentEffect"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table    
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = '';
       $tablefields[$tblcnt][9][5] = $sclm_events_id_c; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $sclm_events_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_events_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value; 

       }
       
    $tblcnt++;

    if ($action == 'add'){

       # https://en.wikipedia.org/w/api.php
    
       $tablefields[$tblcnt][0] = "name"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Title"]." ".$strings["message_required"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'autocomplete';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $title; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $title; //$field_value;      
       
       } else {
       
       $tablefields[$tblcnt][0] = "name"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Title"]." ".$strings["message_required"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $title; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $title; //$field_value;      
       
       } 

    $tblcnt++;

    if ($action == 'edit' || $action == 'add'){

       $tablefields[$tblcnt][0] = "event_image_url"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_gallery';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list';//$dropdown_table; // related table
 
       # Get content owned by this account

       #########################
       # Looper Content Wrapper

       $ci_object_type = 'Content';
       $ci_action = "select";

       if ($auth == 3){
          $ci_params[0] = " account_id_c='".$account_id_c."' && deleted=0 && content_type='1b7369c3-dd78-a8a3-2a79-523876ce70fe' && sclm_events_id_c='".$val."' ";
          } else {
          $ci_params[0] = " account_id_c='".$sess_account_id."' && deleted=0 && content_type='1b7369c3-dd78-a8a3-2a79-523876ce70fe' && sclm_events_id_c='".$val."' ";
          }

       $ci_params[1] = "id,name,deleted,account_id_c,content_url,content_thumbnail"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $content_url = $ci_items[$cnt]['content_url'];
              $content_thumbnail = $ci_items[$cnt]['content_thumbnail'];

              $packbits[0] = $name; # Title
              $packbits[1] = $content_thumbnail; # Image
              $packbits[2] = $content_url; # Content
              if ($image == $content_url){
                 $checkstate = 1;
                 } else {
                 $checkstate = "";
                 }
              $packbits[3] = $checkstate;
              $packbits[4] = ""; # Details

              $ddpack[$id] = $packbits;

              } // for

          } // array

       $tablefields[$tblcnt][9][1] = $ddpack;
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";
       $tablefields[$tblcnt][9][5] = $event_image_url; // Current Value
       $tablefields[$tblcnt][9][6] = 'Content';
       $tablefields[$tblcnt][9][7] = 'Content';
       $tablefields[$tblcnt][9][10] = 'radio';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "event_image_url"; //$field_value_id;
       $tablefields[$tblcnt][21] = $event_image_url; //$field_value;   

       } else {

       $tablefields[$tblcnt][0] = "image"; // Field Name
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
       $tablefields[$tblcnt][20] = "image"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image; //$field_value;   

       }

    $date = $_POST['date'];
    $today = date("Y-m-d G:i:s");

    if (!$start_date){
       if (!$date){
          $start_date = $today;
          } else {
          $start_date = $date;
          } 
       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "start_date"; // Field Name
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
    $tablefields[$tblcnt][11] = $start_date; // Field ID
    $tablefields[$tblcnt][12] = '20'; # length
    $tablefields[$tblcnt][20] = "start_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $start_date; //$field_value;      

    $tblcnt++;

    $tablefields[$tblcnt][0] = "end_date"; // Field Name
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
    $tablefields[$tblcnt][11] = $end_date; // Field ID
    $tablefields[$tblcnt][12] = '20'; # length
    $tablefields[$tblcnt][20] = "end_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $end_date; //$field_value;  

    $tblcnt++;

    if ($start_date != NULL && $start_years == NULL){
       $start_years = date ("Y",$start_date);
       }

    $tablefields[$tblcnt][0] = "start_years"; // Field Name
    $tablefields[$tblcnt][1] = "Start Years"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'int';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $start_years; // Field ID
    $tablefields[$tblcnt][12] = '30'; # length
    $tablefields[$tblcnt][20] = "start_years"; //$field_value_id;
    $tablefields[$tblcnt][21] = $start_years; //$field_value;      

    $tblcnt++;

    if ($end_date != NULL && $end_years == NULL){
       $end_years = date ("Y",$end_date);
       }

    $tablefields[$tblcnt][0] = "end_years"; // Field Name
    $tablefields[$tblcnt][1] = "End Years"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'int';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $end_years; // Field ID
    $tablefields[$tblcnt][12] = '30'; # length
    $tablefields[$tblcnt][20] = "end_years"; //$field_value_id;
    $tablefields[$tblcnt][21] = $end_years; //$field_value;    

    if ($time_frame_id == NULL){

       if (strtotime($start_date) < strtotime($today)) {
          # older
          $time_frame_id = 'd1c0172c-4bc9-190f-0763-54fdd70f7c7d';
          } elseif (strtotime($start_date) == strtotime($today)) {
          # present
          $time_frame_id = 'e626690b-ba5f-5027-7a21-54fdd85ec2f2';
          } else {
          # future
          $time_frame_id = 'cb2106d0-f46d-7444-b950-54fdd8f24e93';
          }

       } # if time frame

    $tblcnt++;

    $tablefields[$tblcnt][0] = "time_frame_id"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TimeDimension"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='137d6d39-765e-6804-7085-54fdd7f84a57'"; // Exceptions
    $tablefields[$tblcnt][9][5] = $time_frame_id; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $time_frame_id; // Field ID
    $tablefields[$tblcnt][20] = "time_frame_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $time_frame_id; //$field_value; 

    # Lifestyle & State Categories | ID: a86cf661-d985-f7fc-3a72-5521d38a3700

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'categories'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Category"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
#    if ($action == 'add'){
#       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
#       } else {
#       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
#       } 
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    #echo "Cat $category_id <BR>";

    if ($category_id != NULL){

       $cat_object_type = "ConfigurationItemTypes";
       $cat_action = "select";
       $cat_params[0] = " id='".$category_id."' ";
       $cat_params[1] = "id,name,description,sclm_configurationitemtypes_id_c"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $catpar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($catpar_items)){

          for ($catparcnt=0;$catparcnt < count($catpar_items);$catparcnt++){
 
              $cat_name = $catpar_items[$catparcnt]['name'];
              $cat_pack[$category_id] = $cat_name;
              $cat_cit = $catpar_items[$catparcnt]['sclm_configurationitemtypes_id_c'];

              } # for

          $cat_object_type = "ConfigurationItemTypes";
          $cat_action = "select";
          $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$cat_cit."' ";
          $cat_params[1] = "id,name,description"; // select array
          $cat_params[2] = ""; // group;
          $cat_params[3] = "name ASC"; // order;
          $cat_params[4] = ""; // limit
  
          $cat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

          if (is_array($cat_items)){

             for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                 $cat_id = $cat_items[$cnt]['id'];
                 $cat = $cat_items[$cnt]['name'];
                 $cat_pack[$cat_id] = $cat;

                 } # for

             } # is array

          } else { # is array

          $cat_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $category_id);
          $cat_name = $cat_returner[0];
          $cat_pack[$category_id] = $cat_name;

          } 

       } else {# if cat

       $cat_cit = "a86cf661-d985-f7fc-3a72-5521d38a3700"; # Cats
 
       $cat_object_type = "ConfigurationItemTypes";
       $cat_action = "select";
       $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$cat_cit."' ";
       $cat_params[1] = "id,name,description"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $cat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($cat_items)){

          for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
              $cat_id = $cat_items[$cnt]['id'];
              $cat = $cat_items[$cnt]['name'];
              $cat_pack[$cat_id] = $cat;

              } # for

          } # for    

       } # end if not cat

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $cat_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $category_id; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Current Value
    $tablefields[$tblcnt][9][7] = "categories"; // reltable
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $category_id; // Field ID
    $tablefields[$tblcnt][20] = "categories"; //$field_value_id;
    $tablefields[$tblcnt][21] = $category_id; //$field_value;     

    $tblcnt++;

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
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
    #$tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'positivity'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Positivity"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '1'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
    $tablefields[$tblcnt][9][2] = 'positivity';
    $tablefields[$tblcnt][9][3] = $strings["Positivity"];
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $positivity; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $positivity; // Field ID
    $tablefields[$tblcnt][20] = 'positivity';//$field_value_id;
    $tablefields[$tblcnt][21] = $positivity; //$field_value;

//    if ($action == 'edit' && $time_frame_id != NULL && $time_frame_id != '9fdc02c3-fd24-58b8-8a96-515f8761ba2a'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = "probability"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Probability"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $funky_gear->makeprobability (); // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'probability';
    $tablefields[$tblcnt][9][3] = $strings["Probability"];
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $probability; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $probability; // Field ID
    $tablefields[$tblcnt][20] = "probability"; //$field_value_id;
    $tablefields[$tblcnt][21] = $probability; //$field_value;      

//    }

    if ($action == 'add' || $action == 'add_related' || $action == 'add_virtual_related' || $action == 'add_virtual_parent' || $action == 'add_virtual_child'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "value_type_id"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ValueType"]." ".$strings["message_required"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='e72f370a-31da-30ee-d745-54fd6ac0d208'"; // Exceptions
       $tablefields[$tblcnt][9][5] = $value_type_id; // Current Value
       $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // reltable
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $value_type_id; // Field ID
       $tablefields[$tblcnt][20] = "value_type_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $value_type_id; //$field_value;      

       }

    if ($action == 'edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "value_type_id"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ValueType"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='e72f370a-31da-30ee-d745-54fd6ac0d208'"; // Exceptions
       $tablefields[$tblcnt][9][5] = $value_type_id; // Current Value
       $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // reltable
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $value_type_id; // Field ID
       $tablefields[$tblcnt][20] = "value_type_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $value_type_id; //$field_value;    

/*
       $tablefields[$tblcnt][0] = "value_type_id"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ValueType"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $value_type_id; // Field ID
       $tablefields[$tblcnt][20] = "value_type_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $value_type_id; //$field_value;      
*/

       }

    if ($action == 'edit' && ($sibaseunit_id != NULL || $sibaseunit_id != NULL)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sibaseunit_id"; // Field Name
       $tablefields[$tblcnt][1] = $strings["SIBaseUnit"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='7c1c78c3-dfd3-0dab-f752-54fd71eb20d6'"; // Exceptions
       $tablefields[$tblcnt][9][5] = $sibaseunit_id; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $sibaseunit_id; // Field ID
       $tablefields[$tblcnt][20] = "sibaseunit_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sibaseunit_id; //$field_value;      

       }

    if ($action == 'edit' && ($emotion_id != NULL || $ethics_id != NULL || $menstruation_phase_id != NULL)){

       $tblcnt++;

       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][10] = '1';//1; // show in view 

       if ($emotion_id != NULL){

          $tablefields[$tblcnt][0] = "emotion_id"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Emotion"]; // Full Name
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='dc7577bf-a51e-28bf-0c3b-54fd63a431f0'"; // Exceptions
          $tablefields[$tblcnt][9][5] = $emotion_id; // Current Value
          $tablefields[$tblcnt][11] = $emotion_id; // Field ID
          $tablefields[$tblcnt][20] = "emotion_id"; //$field_value_id;
          $tablefields[$tblcnt][21] = $emotion_id; //$field_value;

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'value_type_value'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Emotion"]." ".$strings["Value"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '1'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
          $tablefields[$tblcnt][9][2] = 'value_type_value';
          $tablefields[$tblcnt][9][3] = $strings["Value"];
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $value_type_value; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $value_type_value; // Field ID
          $tablefields[$tblcnt][20] = 'value_type_value';//$field_value_id;
          $tablefields[$tblcnt][21] = $value_type_value; //$field_value;

          } // emotion_id

       if ($ethics_id != NULL){

          $tablefields[$tblcnt][0] = "ethics_id"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Ethics"]; // Full Name
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='a158f739-139f-4d8f-53ea-54fd7016af01'"; // Exceptions
          $tablefields[$tblcnt][9][5] = $ethics_id; // Current Value
          $tablefields[$tblcnt][11] = $ethics_id; // Field ID
          $tablefields[$tblcnt][20] = "ethics_id"; //$field_value_id;
          $tablefields[$tblcnt][21] = $ethics_id; //$field_value;

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'value_type_value'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Ethics"]." ".$strings["Value"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '1'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
          $tablefields[$tblcnt][9][2] = 'value_type_value';
          $tablefields[$tblcnt][9][3] = $strings["Value"];
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $value_type_value; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $value_type_value; // Field ID
          $tablefields[$tblcnt][20] = 'value_type_value';//$field_value_id;
          $tablefields[$tblcnt][21] = $value_type_value; //$field_value;

          } // ethics_id

       if ($menstruation_phase_id != NULL){

          $tablefields[$tblcnt][0] = "menstruation_phase_id"; // Field Name
          $tablefields[$tblcnt][1] = "Menstruation Phase"; // Full Name
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='2d6007d0-e401-4cba-b973-55642a67ed16'"; // Exceptions
          $tablefields[$tblcnt][9][5] = $menstruation_phase_id; // Current Value
          $tablefields[$tblcnt][11] = $menstruation_phase_id; // Field ID
          $tablefields[$tblcnt][20] = "menstruation_phase_id"; //$field_value_id;
          $tablefields[$tblcnt][21] = $menstruation_phase_id; //$field_value;

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'value_type_value'; // Field Name
          $tablefields[$tblcnt][1] = "Comfort Level ".$strings["Value"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '1'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
          $tablefields[$tblcnt][9][2] = 'value_type_value';
          $tablefields[$tblcnt][9][3] = $strings["Value"];
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $value_type_value; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $value_type_value; // Field ID
          $tablefields[$tblcnt][20] = 'value_type_value';//$field_value_id;
          $tablefields[$tblcnt][21] = $value_type_value; //$field_value;

          } // emotion_id

       } // end if edit

    if ($action == 'edit'){

       switch ($value_type_id){

/*

            case 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2': # Monetary - P & L - Expense
            case '3566a485-0183-48a8-231b-54fd6e931b93': # Monetary - P & L - Revenue
            case '19896b1b-d790-88b8-a2b4-54fd6eb21986': # Monetary - B/S - Asset
            case '5f803ea1-354c-800e-2cc7-54fd6e65da42': # Monetary - B/S - Liability
            case 'a308ec04-abe4-8121-14bb-54fd6e6d0a00': # Monetary - General
            case '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281': # Quantity or Amount
            case '1e81858f-ba15-a8c1-fc96-54fd6e510f39': # Urgency
            case 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe': # Importance

*/

        case 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2':
        case '3566a485-0183-48a8-231b-54fd6e931b93':
        case '19896b1b-d790-88b8-a2b4-54fd6eb21986':
        case '5f803ea1-354c-800e-2cc7-54fd6e65da42':
        case 'a308ec04-abe4-8121-14bb-54fd6e6d0a00':
        case '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281':

          $tblcnt++;

          $tablefields[$tblcnt][0] = "value_type_value"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Value"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'decimal';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $value_type_value; // Field ID
          $tablefields[$tblcnt][12] = '10'; # length
          $tablefields[$tblcnt][20] = "value_type_value"; //$field_value_id;
          $tablefields[$tblcnt][21] = $value_type_value; //$field_value;

          $tblcnt++;
       
          $tablefields[$tblcnt][0] = "cmn_currencies_id_c"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Currency"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'cmn_currencies'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $cmn_currencies_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $cmn_currencies_id_c; // Field ID
          $tablefields[$tblcnt][20] = 'cmn_currencies_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $cmn_currencies_id_c; //$field_value; 

        break;
        case '1e81858f-ba15-a8c1-fc96-54fd6e510f39':

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'value_type_value'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Urgency"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '1'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
          $tablefields[$tblcnt][9][2] = 'value_type_value';
          $tablefields[$tblcnt][9][3] = $strings["Value"];
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $value_type_value; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $value_type_value; // Field ID
          $tablefields[$tblcnt][20] = 'value_type_value';//$field_value_id;
          $tablefields[$tblcnt][21] = $value_type_value; //$field_value;

        break;
        case 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe':

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'value_type_value'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Importance"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '1'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
          $tablefields[$tblcnt][9][2] = 'value_type_value';
          $tablefields[$tblcnt][9][3] = $strings["Value"];
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $value_type_value; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $value_type_value; // Field ID
          $tablefields[$tblcnt][20] = 'value_type_value';//$field_value_id;
          $tablefields[$tblcnt][21] = $value_type_value; //$field_value;

        break;

        } // if valuetype of value

       } // end if edit


    $tblcnt++;
       
    $tablefields[$tblcnt][0] = "group_type_id"; // Field Name
    $tablefields[$tblcnt][1] = $strings["GroupType"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='f039ef41-187a-515d-88cb-54fd6fba9ef5'"; // Exceptions
    $tablefields[$tblcnt][9][5] = $group_type_id; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $group_type_id; // Field ID
    $tablefields[$tblcnt][20] = 'group_type_id';//$field_value_id;
    $tablefields[$tblcnt][21] = $group_type_id; //$field_value; 

    $tblcnt++;
       
    $tablefields[$tblcnt][0] = "purpose_id"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Purpose"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "sclm_configurationitemtypes_id_c='6fde4355-a06e-0b59-064d-5500fab42774'"; // Exceptions
    $tablefields[$tblcnt][9][5] = $purpose_id; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $purpose_id; // Field ID
    $tablefields[$tblcnt][20] = 'purpose_id';//$field_value_id;
    $tablefields[$tblcnt][21] = $purpose_id; //$field_value; 

    if ($action == 'add' || $action == 'add_related'){
       $account_id_c = $sess_account_id;
       }

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
    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " id='".$account_id_c."' "; // exception
       }
    $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

    if ($action == 'add' || $action == 'add_related'){
       $contact_id_c = $sess_contact_id;
       }

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

    if ($auth == 3){

       $acc_object_type = "Accounts";
       $acc_action = "select";
       $acc_params[0] = " deleted=0 ";
       $accounts = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($accounts)){

          for ($acc_cnt=0;$acc_cnt < count($accounts);$acc_cnt++){

              $exist_account_id = $accounts[$acc_cnt]['id'];
              $exist_account_name = $accounts[$acc_cnt]['name'];
              $ddpack[$exist_account_id]=$exist_account_name;

              } # for

          foreach ($ddpack as $an_account_id => $an_account_name){
            
                  $acc_object_type = "Accounts";
                  $acc_action = "select_contacts";
                  $acc_params[0] = " account_id='".$an_account_id."' ";
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
                         $conpack[$contact_id] = $an_account_name." -> ".$first_name." ".$last_name;

                         } // for

                     } // if

                  } //for each

          } # is array

       } elseif ($auth == 2) {

       $acc_object_type = "Accounts";
       $acc_action = "select_contacts";
       $acc_params[0] = " account_id='".$sess_account_id."' ";
       $acc_params[1] = ""; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = "";
       $acc_params[4] = ""; // 
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       $acc_returner = $funky_gear->object_returner ("Accounts", $sess_account_id);
       $this_account_name = $acc_returner[0];

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $contact_id = $acc_items[$acc_cnt]['contact_id'];
              $first_name = $acc_items[$acc_cnt]['first_name'];
              $last_name = $acc_items[$acc_cnt]['last_name'];
              $conpack[$contact_id] = $this_account_name." -> ".$first_name." ".$last_name;

              } // for

          } // if

       } else {

       $acc_object_type = "Accounts";
       $acc_action = "select_contacts";
       $acc_params[0] = "account_id='".$sess_account_id."' && contact_id='".$sess_contact_id."'";
       $acc_params[1] = ""; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = "";
       $acc_params[4] = ""; // 
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       $acc_returner = $funky_gear->object_returner ("Accounts", $sess_account_id);
       $this_account_name = $acc_returner[0];

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $contact_id = $acc_items[$acc_cnt]['contact_id'];
              $first_name = $acc_items[$acc_cnt]['first_name'];
              $last_name = $acc_items[$acc_cnt]['last_name'];
              $conpack[$contact_id] = $this_account_name." -> ".$first_name." ".$last_name;

              } // for

          } // if

       } # id user security

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $conpack; // 
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'firstlast';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   
    $tablefields[$tblcnt][50] = " CONCAT(accounts.name,'->',contacts.first_name,' ',contacts.last_name) as firstlast ";

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "source_object_id"; // Field Name
    $tablefields[$tblcnt][1] = "Source Object"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $source_object_id; // Field ID
    $tablefields[$tblcnt][20] = "source_object_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $source_object_id; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "external_source_id"; // Field Name
    $tablefields[$tblcnt][1] = "External Source"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $external_source_id; // Field ID
    $tablefields[$tblcnt][20] = "external_source_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $external_source_id; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "value"; // Field Name
    $tablefields[$tblcnt][1] = "Value"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = "value"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "valuetype"; // Field Name
    $tablefields[$tblcnt][1] = "Value Type"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $valtype; // Field ID
    $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;
     
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
    #$tablefields[$tblcnt][9][3] = 'language_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_languages_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_languages_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_languages_id_c; //$field_value; 

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "allow_joiners"; // Field Name
    $tablefields[$tblcnt][1] = "Allow people to join?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $allow_joiners; // Field ID
    $tablefields[$tblcnt][20] = "allow_joiners"; //$field_value_id;
    $tablefields[$tblcnt][21] = $allow_joiners; //$field_value;

    if ($action == 'add' || $location == NULL || $action == 'add_related'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "locations"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Location"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $loc_pack[1] = "Create New Location";
       $loc_pack[2] = "Use Existing Location";

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $loc_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // Exceptions
       $tablefields[$tblcnt][9][5] = $locations; // Current Value
       $tablefields[$tblcnt][9][6] = ""; // Current Value
       $tablefields[$tblcnt][9][7] = "locations"; // reltable
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $locations; // Field ID
       $tablefields[$tblcnt][20] = "locations"; //$field_value_id;
       $tablefields[$tblcnt][21] = $locations; //$field_value;      

       } else {

       if ($location != NULL){

          # Check if location name and owner exist as stored location for update..
          $locations_cit = "a6961896-8520-6458-f8a0-5500ecc82857";
          $check_location = $funky_gear->replacer("'","\'",$location);
          $location_query = " sclm_configurationitemtypes_id_c='".$locations_cit."' && name='".$check_location."' ";

          $ci_object_type = "ConfigurationItems";
          if ($auth == 3){
             $ci_params[0] = $location_query;
             } else {
             $ci_params[0] = $location_query." && account_id_c='".$sess_account_id."' ";
             }

          $ci_action = "select";
          $ci_params[1] = "id,name,date_entered,account_id_c"; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = " name, date_entered DESC "; // order;
          $ci_params[4] = ""; // limit

          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          $location_owner = FALSE;

          if (is_array($ci_items)){

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

                 $location_id = $ci_items[$cnt]['id'];

                 }

             $location_owner = TRUE;
             $loc_store_field_name = "update_location";
             $loc_store_name = "Update Location?";

             $tblcnt++;
    
             $tablefields[$tblcnt][0] = "location_id"; // Field Name
             $tablefields[$tblcnt][1] = "Location ID"; // Full Name
             $tablefields[$tblcnt][2] = 0; // is_primary
             $tablefields[$tblcnt][3] = 0; // is_autoincrement
             $tablefields[$tblcnt][4] = 0; // is_name
             $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
             $tablefields[$tblcnt][6] = '255'; // length
             $tablefields[$tblcnt][7] = '0'; // NULLOK?
             $tablefields[$tblcnt][8] = ''; // default
             $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
             $tablefields[$tblcnt][10] = '';//1; // show in view 
             $tablefields[$tblcnt][11] = $location_id; // Field ID
             $tablefields[$tblcnt][20] = "location_id"; //$field_value_id;
             $tablefields[$tblcnt][21] = $location_id; //$field_value;

             } else {

             $loc_store_field_name = "store_location";
             $loc_store_name = "Store Location?";

             } 

          } # if location not null

       if ($location == NULL || $location_owner == TRUE){

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = $loc_store_field_name; // Field Name
          $tablefields[$tblcnt][1] = $loc_store_name; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = 1; // Field ID
          $tablefields[$tblcnt][20] = $loc_store_field_name; //$field_value_id;
          $tablefields[$tblcnt][21] = 1; //$field_value;

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = "share_location"; // Field Name
          $tablefields[$tblcnt][1] = "Share Location"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = "share_location"; //$field_value_id;
          $tablefields[$tblcnt][21] = ""; //$field_value;

          } # end if location null

       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "location"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Location"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $location; // Field ID
       $tablefields[$tblcnt][12] = 50; // size
       $tablefields[$tblcnt][20] = "location"; //$field_value_id;
       $tablefields[$tblcnt][21] = $location; //$field_value;

       if ($location != NULL){
          $map_location = str_replace(" ", "+", $location);
          $map_location = "http://www.google.co.jp/maps/place/".$map_location;

          $showlocation = "<textarea id=\"embedLink\" name=\"embedLink\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$map_location."</textarea>";

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = "showlocation"; // Field Name
          $tablefields[$tblcnt][1] = $showlocation; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'radio';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][12] = 50; // size
          $tablefields[$tblcnt][20] = "showlocation"; //$field_value_id;
          $tablefields[$tblcnt][21] = ""; //$field_value;
          $tablefields[$tblcnt][41] = "1"; //$field_value;

          } # if location

       $tblcnt++;
       
       $tablefields[$tblcnt][0] = "latitude"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Venue"]." ".$strings["Latitude"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $latitude; // Field ID
       $tablefields[$tblcnt][12] = 30; // size
       $tablefields[$tblcnt][20] = "latitude"; //$field_value_id;
       $tablefields[$tblcnt][21] = $latitude; //$field_value; 

       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "longitude"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Venue"]." ".$strings["Longitude"];  // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $longitude; // Field ID
       $tablefields[$tblcnt][12] = 30; // size
       $tablefields[$tblcnt][20] = "longitude"; //$field_value_id;
       $tablefields[$tblcnt][21] = $longitude; //$field_value; 
    
       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "event_url"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Event"]." URL"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name

       if ($form_action == 'view'){
          $tablefields[$tblcnt][5] = 'external_link';//$field_type; //'INT'; // type
          } else {
          $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
          }

       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       if ($form_action == 'view'){
          $tablefields[$tblcnt][9][0] = $event_url; // Link
          $tablefields[$tblcnt][9][1] = $event_url; // Link Name
          $tablefields[$tblcnt][9][2] = "Saloob"; // Link Name
          } else {
          $tablefields[$tblcnt][9] = ""; // Link
          } 

       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $event_url; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "event_url"; //$field_value_id;
       $tablefields[$tblcnt][21] = $event_url; //$field_value; 
    
       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "street"; // Field Name
       $tablefields[$tblcnt][1] = "Venue Street"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "street"; //$field_value_id;
       $tablefields[$tblcnt][21] = $street; //$field_value;    

       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "city"; // Field Name
       $tablefields[$tblcnt][1] = "Venue City"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "city"; //$field_value_id;
       $tablefields[$tblcnt][21] = $city; //$field_value;  

       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "state"; // Field Name
       $tablefields[$tblcnt][1] = "Venue State"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "state"; //$field_value_id;
       $tablefields[$tblcnt][21] = $state; //$field_value;

       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "zip"; // Field Name
       $tablefields[$tblcnt][1] = "Venue Zip"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '10'; # length
       $tablefields[$tblcnt][20] = "zip"; //$field_value_id;
       $tablefields[$tblcnt][21] = $zip; //$field_value;    
         
       $tblcnt++;

       $tablefields[$tblcnt][0] = "cmn_countries_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Country"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmn_countries'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       #$tablefields[$tblcnt][9][3] = 'name_'.$lingo;
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ' deleted=0 order by name ASC '; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmn_countries_id_c; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmn_countries_id_c; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = 'cmn_countries_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $cmn_countries_id_c; //$field_value; 

       } # end if add

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "external_url"; // Field Name
    $tablefields[$tblcnt][1] = "URL"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name

    if ($form_action == 'view'){
       $tablefields[$tblcnt][5] = 'external_link';//$field_type; //'INT'; // type
       } else {
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       }

    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    if ($form_action == 'view'){
       $tablefields[$tblcnt][9][0] = $url; //$dropdown_table; // related table
       $tablefields[$tblcnt][9][1] = $url; //$dropdown_table; // related table
       $tablefields[$tblcnt][9][2] = 'Saloob'; 
       } else {
       $tablefields[$tblcnt][9] = ""; // Link
       } 

    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $external_url; // Field ID
    $tablefields[$tblcnt][12] = '50'; # length
    $tablefields[$tblcnt][20] = "external_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $external_url; //$field_value;

    if ($fb_session != NULL){

       $tblcnt++;
    
       $tablefields[$tblcnt][0] = "create_fb_feed"; // Field Name
       $tablefields[$tblcnt][1] = "Create and post a new Facebook feed based on this event?"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "create_fb_feed"; //$field_value_id;
       $tablefields[$tblcnt][21] = "0"; //$field_value;
       $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

       } # if FB

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Description"]." ".$strings["message_required"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $description; // Field ID
    $tablefields[$tblcnt][12] = '50'; # length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;

    # See if any external event services have been registered for this event
    if ($action == 'edit'){

       $event_wrapper_cit = "4f58a04e-eea7-0c32-d6db-552e893ac315";
       $ggevents_cit = "a007a200-4cef-1938-6671-552e818965d1";
       $fbevents_cit = "8a2658e3-3e56-743c-a656-55196e298a99";

       # First see if this wrapper exists
       $wrapper_event_query = " sclm_configurationitemtypes_id_c='".$event_wrapper_cit."' && name='".$val."' ";
       $wrapper_event_object_type = "ConfigurationItems";
       $wrapper_event_action = "select";
       $wrapper_event_params[0] = $wrapper_event_query;
       $wrapper_event_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
       $wrapper_event_params[2] = ""; // group;
       $wrapper_event_params[3] = " name, date_entered DESC "; // order;
       $wrapper_event_params[4] = ""; // limit

       $wrapper_event_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wrapper_event_object_type, $wrapper_event_action, $wrapper_event_params);

       if (is_array($wrapper_event_items)){    

          for ($wrapper_eventcnt=0;$wrapper_eventcnt < count($wrapper_event_items);$wrapper_eventcnt++){
   
              $wrapper_id = $wrapper_event_items[$wrapper_eventcnt]['id'];

              } # for

          # Wrapper exists!
          $ext_message = "<P>An external event service wrapper exists for this event.";

          $process_object_type = "ConfigurationItems";
          $process_action = "update";

          # See which services have been registered for this event
          $ext_event_query = " sclm_configurationitems_id_c='".$wrapper_id."' ";

          $ext_event_object_type = "ConfigurationItems";
          $ext_event_params[0] = $ext_event_query;
          $ext_event_action = "select";
          $ext_event_params[1] = "id,description,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
          $ext_event_params[2] = ""; // group;
          $ext_event_params[3] = " name, date_entered DESC "; // order;
          $ext_event_params[4] = ""; // limit

          $ext_event_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ext_event_object_type, $ext_event_action, $ext_event_params);

          if (is_array($ext_event_items)){    
   
             for ($ext_eventcnt=0;$ext_eventcnt < count($ext_event_items);$ext_eventcnt++){

                 $ext_ci_id = $ext_event_items[$ext_eventcnt]['id'];
                 $ext_cit = $ext_event_items[$ext_eventcnt]['sclm_configurationitemtypes_id_c'];
                 $ext_service_id = $ext_event_items[$ext_eventcnt]['name'];

                 switch ($ext_cit){

                  case $ggevents_cit:
                   $ext_message .= "<P>A Google event has been registered for this event.";
                   $gg_event_id = $ext_service_id;
                   $gg_cal_id = $ext_event_items[$ext_eventcnt]['description'];
                  break;
                  case $fbevents_cit:
                   $ext_message .= "<P>A Facebook event has been registered for this event.";
                   $fb_event_id = $ext_service_id;
                  break;

                 } # switch service

                 } # for

             $ext_message = "<div style=\"".$divstyle_white."\">".$ext_message."</div>";  

             } else {# is array

             $ext_message = "<div style=\"".$divstyle_white."\"><P>No external events have been registered for this event.</div>";

             } # no 

          } else { # is array

          $ext_message = "<div style=\"".$divstyle_white."\"><P>No external events have been registered for this event.</div>";

          } 

       } # if edit

    if ($fb_session != NULL){

       require_once ("api-facebook.php");

       $fb_params[0] = "return_events"; #fb_action;
       $fb_params[1] = $fb_session; # userid

       $fbevents = do_facebook ($fb_params);

       $fbevents_list = $fbevents['data'];

       for ($event_cnt=0;$event_cnt < count($fbevents_list);$event_cnt++){

           $fbevent_start_time = $fbevents_list[$event_cnt]['start_time'];
           $fbevent_end_time = $fbevents_list[$event_cnt]['end_time'];
           $fbevent_location = $fbevents_list[$event_cnt]['location'];
           $fbevent_name = $fbevents_list[$event_cnt]['name'];
           $fbevent_timezone = $fbevents_list[$event_cnt]['timezone'];
           $fbevent_id = $fbevents_list[$event_cnt]['id'];
           $fbevent_rsvp_status = $fbevents_list[$event_cnt]['rsvp_status'];

           list ($start_datepart,$start_timepart) = explode ("T", $fbevent_start_time);
           list ($start_time,$start_timezone) = explode ("+", $start_timepart);
           list ($end_datepart,$end_timepart) = explode ("T", $fbevent_end_time);
           list ($end_time,$end_timezone) = explode ("+", $end_timepart);
           $map_location = str_replace(" ", "+", $fbevent_location);
           $map_location = "http://www.google.co.jp/maps/place/".$map_location;

           $fbevent_show = "<B>Connect Facebook Event:</B> ".$fbevent_name. " [Start Date/Time: ".$start_datepart."/".$start_time." End Date/Time: ".$end_datepart."/".$end_time."  @ ".$fbevent_location." in ".$fbevent_timezone.". Attendance: ".$fbevent_rsvp_status."<BR><textarea id=\"embedLink\" name=\"embedLink\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$map_location."</textarea>";

           $tblcnt++;
    
           $tablefields[$tblcnt][0] = "fb_event_id_".$fbevent_id; // Field Name
           $tablefields[$tblcnt][1] = $fbevent_show; // Full Name
           $tablefields[$tblcnt][2] = 0; // is_primary
           $tablefields[$tblcnt][3] = 0; // is_autoincrement
           $tablefields[$tblcnt][4] = 0; // is_name
           $tablefields[$tblcnt][5] = 'radio';//$field_type; //'INT'; // type
           $tablefields[$tblcnt][6] = '255'; // length
           $tablefields[$tblcnt][7] = '0'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = '1';//1; // show in view 
           $tablefields[$tblcnt][11] = ''; // Field ID
           $tablefields[$tblcnt][12] = '50'; # length
           $tablefields[$tblcnt][20] = "fb_event_id_".$fbevent_id; //$field_value_id;

           # $fb_event_id could be pre-registered event
           if ($fb_event_id != NULL){
              if (($val != NULL && $val == $fbevent_id && $valtype == 'Facebook') || ($fbevent_id == $fb_event_id)){
                 $tablefields[$tblcnt][21] = 1; //$field_value;
                 } else {
                 $tablefields[$tblcnt][21] = ""; //$field_value;
                 }
              } else {

              # No pre-registered event - just sent from FB event links
              if ($val != NULL && $val == $fbevent_id && $valtype == 'Facebook'){
                 $tablefields[$tblcnt][21] = 1; //$field_value;
                 } else {
                 $tablefields[$tblcnt][21] = ""; //$field_value;
                 }
              }

           $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

           } # for events

       $tblcnt++;

       $tablefields[$tblcnt][0] = "create_fb_post"; // Field Name
       $tablefields[$tblcnt][1] = "Post to Facebook?"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "create_fb_post"; //$field_value_id;
       $tablefields[$tblcnt][21] = 0; //$field_value;
       #$tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

       } else {
 
       $fb_message = "<div style=\"".$divstyle_white."\">You are not logged in with Facebook and can not link events there.. Try adding your Facebook account in Account Details...<P></div>";

       } 

    if (($action == 'add' || $action == 'edit') && $valtype != 'Google' && $gg_session != NULL){ # if

       require_once ("api-google.php");

       $gg_params[0] = "get_cal_list"; #gg_action;
       $gg_params[1] = $gg_session; # userid

       $google_cals = do_google ($gg_params);

       if (is_array($google_cals)){

          for ($cnt=0;$cnt < count($google_cals);$cnt++){
 
              $gcal_id = $google_cals[$cnt]['id'];
              #$etag = $google_cals[$cnt]['etag'];
              #$timeZone = $google_cals[$cnt]['timeZone'];
              #$location = $google_cals[$cnt]['location'];
              #$colorId = $google_cals[$cnt]['colorId'];
              #$backgroundColor = $google_cals[$cnt]['backgroundColor'];
              #$foregroundColor = $google_cals[$cnt]['foregroundColor'];
              #$accessRole = $google_cals[$cnt]['accessRole'];
              #$description = $google_cals[$cnt]['description'];
              $summary = $google_cals[$cnt]['summary'];

              #$cals .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Google&action=view_calendar&value=".$id."&valuetype=Google&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$summary."</B> (".$timeZone.")</font></a> [".$id."]</div><P>";

              $gcal_pack[$gcal_id] = $summary;

              } # for

          } # is array

       if ($gg_event_id != NULL){
          # Has been pre-registered and posted to Google from here
          # The Calendar ID should be stored in the description field..

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = "gg_event_id"; // Field Name
          $tablefields[$tblcnt][1] = "Google Event"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '';//1; // show in view 
          $tablefields[$tblcnt][11] = $gg_event_id; // Field ID
          $tablefields[$tblcnt][20] = "gg_event_id"; //$field_value_id;
          $tablefields[$tblcnt][21] = $gg_event_id; //$field_value;

          }

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'gg_cal_id'; // Field Name
       $tablefields[$tblcnt][1] = "Google Calendar"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $gcal_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // Exceptions
       $tablefields[$tblcnt][9][5] = $gg_cal_id; // Current Value
       $tablefields[$tblcnt][9][6] = ""; // Current Value
       $tablefields[$tblcnt][9][7] = "gg_cal_id"; // reltable
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $gg_cal_id; // Field ID
       $tablefields[$tblcnt][20] = "gg_cal_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $gg_cal_id; //$field_value;     

       $tblcnt++;

       $tablefields[$tblcnt][0] = "create_google_event"; // Field Name
       if ($gg_event_id != NULL){
          $tablefields[$tblcnt][1] = "Posted to Google! (Update?)"; // Full Name
          } else {
          $tablefields[$tblcnt][1] = "Post to Google?"; // Full Name
          }
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][12] = '50'; # length
       $tablefields[$tblcnt][20] = "create_google_event"; //$field_value_id;

       if ($gg_event_id != NULL){
          # Has been pre-registered and posted to Google from here
          $tablefields[$tblcnt][21] = 1; //$field_value;
          } else {
          $tablefields[$tblcnt][21] = ""; //$field_value;
          }

       } elseif(($action == 'add' || $action == 'edit') && $valtype != 'Google' && $gg_session != NULL) {# if google

       $gg_message .= "<div style=\"".$divstyle_white."\">You are logged in with Google and can post events there.. <P></div>";

       } elseif (($action == 'add' || $action == 'edit') && $gg_session == NULL){

       $gg_message .= "<div style=\"".$divstyle_white."\">You are not logged in with Google and can not post events there.. Try adding your Google account in Account Details...<P></div>";

       }

    if ($sess_contact_id == $contact_id_c && $sess_contact_id != NULL){
       $auth=2;
       }

    $valpack = "";
    $valpack[0] = 'Effects';
    if ($action == 'add_related' || $action == 'add_virtual_related' || $action == 'add_virtual_parent' || $action == 'add_virtual_child'){
       $valpack[1] = 'add';
       } else {
       $valpack[1] = $action;
       }
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // Provide Add button
    $valpack[6] = ""; // Next Action
    $valpack[10] = $sendiv; # div for edit links

    switch ($action){

     case 'add':
     case 'add_related':
     case 'add_virtual_related':
     case 'add_virtual_parent':
     case 'add_virtual_child':
      $valpack[7] = $strings["action_AddNew"]; // Action Button
     break;
     case 'edit':
      $valpack[7] = $strings["action_update"]; // Action Button
     break;
 
    } # switch

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);
    
    #echo $object_return;

    #echo "<img src=images/blank.gif width=98% height=5><BR>";
    echo "<img src=images/blank.gif width=98% height=5><BR>";

    echo $ext_message;
    echo $fb_message;
    echo $gg_message;

    echo $zaform;

    # Keyword | ID: 5d462e35-1200-9cff-aabe-55d354a95501

    #echo "<img src=images/blank.gif width=550 height=10><BR>";

    #echo "<div style=\"".$divstyle_orange_light."\">".$strings["Effects_Explanation"]."</div>";

//    echo "<img src=images/blank.gif width=550 height=20><BR>";
      

   break;
   ####################################################
   case 'map':

    # Set up the column headers
    $divstyle_params[0] = "150px"; // minwidth
    $divstyle_params[1] = "120px"; // minheight
    $divstyle_params[2] = "2px"; // margin_left
    $divstyle_params[3] = "2px"; // margin_right
    $divstyle_params[4] = "2px"; // padding_left
    $divstyle_params[5] = "2px"; // padding_right
    $divstyle_params[6] = "2px"; // margin_top
    $divstyle_params[7] = "2px"; // margin_bottom
    $divstyle_params[8] = "2px"; // padding_top
    $divstyle_params[9] = "2px"; // padding_bottom
    $divstyle_params[10] = "#FFFFFF"; // custom_color_back
    #$divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
    $divstyle_params[11] = "#d3d3d3"; // custom_color_border
    $divstyle_params[12] = "left"; // custom_float
    $divstyle_params[13] = "150px"; // maxwidth
    $divstyle_params[14] = "100px"; // maxheight
    $divstyle_params[15] = "10px"; // top_radius
    $divstyle_params[16] = "10px"; // bottom_radius

    $divstyle = $funky_gear->makedivstyles ($divstyle_params);
    $block_style = $divstyle[5];

    #
    #################
    #

    function child_mapper ($child_params){

     global $portal_header_colour,$BodyDIV,$block_style,$divstyle_blue,$funky_gear,$auth,$standard_statuses_closed,$sess_account_id,$sess_contact_id;

     $blank = "<img src=images/blank.gif width=98% height=5>";

     # Limit the items on one page
     $max_items = 50;

     $par_event_id = $child_params[0];
     $item_count = $child_params[1];
     $child_mapblocks = $child_params[2];
     $block_style = $child_params[3];
     $layercount = $child_params[4];
     $lastsize = $child_params[5];

     $item_count++;

     $remining_items = $max_items-$item_count;

     # Collect the number of items below the parent to structure the blocks
     $sub_effects_object_type = "Events";
     $sub_effects_action = "select";
     $sub_effects_params = array();

     if ($auth == 3){
        $sub_effects_params[0] = "deleted=0 && sclm_events_id_c='".$par_event_id."' "; # system
        } elseif ($auth == 2){
        $sub_effects_params[0] = "deleted=0 && sclm_events_id_c='".$par_event_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') "; # parent
        } elseif ($auth == 1){
        $sub_effects_params[0] = "deleted=0 && sclm_events_id_c='".$par_event_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_contact_id."') "; # member
        } else {
        $sub_effects_params[0] = "deleted=0 && sclm_events_id_c='".$par_event_id."' && cmn_statuses_id_c != '".$standard_statuses_closed."' "; #
        }

     $sub_effects_params[1] = "id,name,start_date,event_image_url";
     $sub_effects_params[2] = "start_date ASC ";
     $sub_effects_params[3] = "";
     $sub_effects_params[4] = $remining_items;

     $sub_sideeffects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sub_effects_object_type, $sub_effects_action, $sub_effects_params);

     # Begin collecting children for building

     if (is_array($sub_sideeffects)){

        #$layercount++;
        #echo "layercount: $layercount<BR>";

        $blockcount = count($sub_sideeffects);
        if ($blockcount<$lastsize){
           # Do nothing
           } else {
           $lastsize = $blockcount;
           }

        #$blocksize = $lastsize*160;

        #echo "blocksize: $blocksize<BR>";

        #$child_mapblocks = "";

        # Set up the column headers
        $divstyle_params[0] = "160px"; // minwidth
        $divstyle_params[1] = "135px"; // minheight
        $divstyle_params[2] = "auto"; // margin_left
        $divstyle_params[3] = "auto"; // margin_right
        $divstyle_params[4] = "2px"; // padding_left
        $divstyle_params[5] = "2px"; // padding_right
        $divstyle_params[6] = "2px"; // margin_top
        $divstyle_params[7] = "2px"; // margin_bottom
        $divstyle_params[8] = "2px"; // padding_top
        $divstyle_params[9] = "2px"; // padding_bottom
        $divstyle_params[10] = "#e6ebf8"; // custom_color_back
        $divstyle_params[11] = "#d3d3d3"; // custom_color_border
        $divstyle_params[12] = "left"; // custom_float
        #$divstyle_params[13] = $blocksize."px"; // maxwidth
        $divstyle_params[13] = "160px"; // maxwidth
        $divstyle_params[13] = "98%"; // maxwidth
        $divstyle_params[14] = "98%"; // maxheight
        $divstyle_params[15] = "5px"; // top_radius
        $divstyle_params[16] = "5px"; // bottom_radius

        $divstyle = $funky_gear->makedivstyles ($divstyle_params);
        $wrapper_block_style = $divstyle[5];

        $child_mapblocks .= "<div style=\"".$wrapper_block_style."\">";

        for ($subcnt=0;$subcnt < count($sub_sideeffects);$subcnt++){

            #echo "Counter: $item_count<BR>";

            $sub_id = $sub_sideeffects[$subcnt]['id'];
            $sub_event_name = $sub_sideeffects[$subcnt]['name'];
            $sub_event_start = $sub_sideeffects[$subcnt]['start_date'];
            $event_image_url = $sub_sideeffects[$subcnt]['event_image_url'];
            $sub_event_start = date('Y-m-d', strtotime($sub_event_start));

            $image = "";
            if ($event_image_url != NULL){
               $image = "<BR><div style=\"width:100%;height:100%;\"><center><a href='".$event_image_url."' data-lightbox=\"Effects\" title=\"".$sub_event_name."\"><img src=".$event_image_url." width=100 style='margin: 5px;border: 2px solid ".$portal_header_colour.";border-radius:3px;'></a></center></div>";
               }

            $viewfull = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');document.getElementById('".$BodyDIV."').style.display='block';doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$sub_id."&valuetype=Effects');cleardiv('lightfull');cleardiv('fade');document.getElementById('lightfull').style.display='none';document.getElementById('fade').style.display='none';return false\">View Effect</a>";

            $child_mapblocks .= "<div style=\"".$block_style."\"><a href=\"#\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php', 'pc=".$portalcode."&do=Effects&action=map&value=".$sub_id."&valuetype=Effects&sendiv=lightfull');return false\"><font size=2 color=#151B54><B>".$sub_event_start.":</B> ".$sub_event_name."</font></a><BR>".$viewfull.$image."</div>";

            if ($subcnt == (count($sub_sideeffects)-1)){
               # Last one - add the parent wrapper
               #$child_mapblocks .= "</div>";
               #$child_mapblocks .= "<BR><img src=images/blank.gif width=98% height=5><BR>";
               #$event_blocks .= "<div style=\"".$wrapper_block_style."\">".$child_mapblocks."</div>";
               # Parent and children complete - send back for next layer
               #$event_blocks .= "<div style=\"".$wrapper_block_style."\"><center><B>".$this_par_name."</B><BR>".$child_mapblocks."</center></div><P>";
               #$event_blocks .= "<div style=\"".$wrapper_block_style."\">".$child_mapblocks."</div>";
               #$event_blocks .= "<div style=\"".$divstyle_blue."\">".$sub_event_name."<BR>".$sub_event_blocks."</div>";
               #$event_blocks .= $mapblockwrapper_start.$child_mapblocks.$mapblockwrapper_end;
               } 

            /*
            $innermap_params[0] = $sub_id;
            $innermap_params[1] = $item_count;
            $innermap_params[2] = $child_mapblocks;
            $innermap_params[3] = $block_style;
            $innermap_params[4] = $layercount;
            $innermap_params[5] = $lastsize;

            $inner_event_blocks = child_mapper ($innermap_params);
            $item_count = $inner_event_blocks[0];
            $child_mapblocks .= $inner_event_blocks[1];
            $layercount = $inner_event_blocks[2];
            $lastsize = $inner_event_blocks[3];
            */
            } # for

        $child_mapblocks .= $blank."</div>";

        } else {

        $child_mapblocks = "";

        } # is array

    $return_event_blocks[0] = $item_count;
    $return_event_blocks[1] = $child_mapblocks;
    $return_event_blocks[2] = $layercount;
    $return_event_blocks[3] = $lastsize;

    return $return_event_blocks;

    } # end child mapper

    #
    ##############
    #

    function mapper ($params){

     global $sess_account_id,$custom_portal_divstyle,$divstyle_white,$divstyle_blue,$funky_gear,$portal_font_colour,$standard_statuses_closed;

     # Limit the items on one page
     $max_items = 50;

     $par_event_id = $params[0];
     $item_count = $params[1];
     $event_blocks = $params[2];
     $block_style = $params[3];
     $wrapper_block_style = $params[4];

     $remining_items = $max_items-$item_count;

     $effects_object_type = "Events";
     $effects_action = "select";
     $effects_params = array();
     $effects_params[0] = "deleted=0 && id='".$par_event_id."' "; # Query
     $effects_params[1] = "account_id_c,name,start_date,sclm_events_id_c,cmn_statuses_id_c"; # Select
     $effects_params[2] = ""; # Order
     $effects_params[3] = ""; # Group by
     $effects_params[4] = $remining_items; # Limit

     $sideeffects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $effects_object_type, $effects_action, $effects_params);
     $sub_count = count($sideeffects);

     if (is_array($sideeffects)){

        $parent = "";
        $sclm_events_id_c = "";

        for ($cnt=0;$cnt < count($sideeffects);$cnt++){

            $sclm_events_id_c = $sideeffects[$cnt]['sclm_events_id_c'];
            $account_id_c = $sideeffects[$cnt]['account_id_c'];
            $event_name = $sideeffects[$cnt]['name'];
            $event_start = $sideeffects[$cnt]['start_date'];
            $cmn_statuses_id_c = $sideeffects[$cnt]['cmn_statuses_id_c'];
            $event_start = date('Y-m-d', strtotime($event_start));
            #echo $event_name."<BR>";

            # Begin collecting data to set up children for building
            # Has at least one child

            #$sub_count_evenodd = $funky_gear->isEven($sub_count);

            if ($sub_count == 1){

               $par_mapdiv = $custom_portal_divstyle;

               } elseif ($sub_count == 2){

               $par_mapdiv = $custom_portal_divstyle;

               } 

            if ($sub_count > $remining_items){

               # There will be items not shown...

               }

            } # for parent - just once

        $innermap_params[0] = $par_event_id;
        $innermap_params[1] = $item_count;
        $innermap_params[2] = $event_blocks;
        $innermap_params[3] = $block_style;
        $innermap_params[4] = 0;

        $inner_event_blocks = child_mapper ($innermap_params);
        $item_count = $inner_event_blocks[0];
        $child_blocks = $inner_event_blocks[1];
        $layer_count = $inner_event_blocks[2];

        # Wrap the set of children
        #$mapblockwrapper_start = "<div style='width: 98%; max-height:98%;overflow:scroll; padding: 0.5em; resize: both;margin-left: auto;margin-right: auto;'>";
        $mapblockwrapper_start = "<div style=\"".$divstyle_white."\">";
        $mapblockwrapper_end = "</div>";

        if ($sclm_events_id_c != NULL && $sclm_events_id_c != "" && $sclm_events_id_c != "NULL" && ($sess_account_id != NULL && $sess_account_id==$account_id_c || $cmn_statuses_id_c != $standard_statuses_closed)){

           $event_returner = $funky_gear->object_returner ("Effects", $sclm_events_id_c);
           $parent_name = $event_returner[0];
           $parent = "<a href=\"#\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php', 'pc=".$portalcode."&do=Effects&action=map&value=".$sclm_events_id_c."&valuetype=Effects&sendiv=lightfull');return false\"><font size=2 color=".$portal_font_colour."><B>View Parent Map: ".$parent_name."</B></font></a><BR>";
           }

        #$current = "<a href=\"#\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php', 'pc=".$portalcode."&do=Effects&action=map&value=".$par_event_id."&valuetype=Effects&sendiv=lightfull');return false\"><font size=3 color=".$portal_font_colour."><B>Current Map: ".$event_name."</B></font></a><BR>";

        $par_mapblock = "<div style=\"".$custom_portal_divstyle."\"><center>".$parent.$current."<font size=3 color=".$portal_font_colour."><B>".$event_start.": ".$event_name."</B></font></center></div>";

        $event_blocks = $par_mapblock.$mapblockwrapper_start.$child_blocks.$mapblockwrapper_end;

        } # is par array

     return $event_blocks;

     } # mapper function

    $map_params[0] = $val;
    $map_params[1] = 0;
    $map_params[2] = "";
    $map_params[3] = $block_style;
    $map_params[4] = $wrapper_block_style;

    $map = mapper ($map_params);

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightfull');cleardiv('fade');document.getElementById('lightfull').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center><P>";

    echo $map;

   break;
   ####################################################
   case 'process':

    $error = "";

    if ($_POST['value_type_id'] == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["ValueType"]."</B></font><BR>";
       }
    
    if ($_POST['name'] == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Name"]."</B></font><BR>";
       }

    if ($_POST['description'] == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Description"]."</B></font><BR>";
       }

    // If effect has been sent from an external site
    // Look up source obejcts for actions - if no corresponding action, then create...
    #$sfx_externalsources_id_c = $_POST['sfx_externalsources_id_c'];
    #$sfx_sourceobjects_id_c = $_POST['sfx_sourceobjects_id_c'];

    #if ($source_object_id != NULL && $external_source_id != NULL && $sclm_events_id_c == NULL){

    if (!$error){

       // Check for Source Object 

       $object_type = "Events";
       $process_action = "update";
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'view_count','value' => $_POST['view_count']);
       $process_params[] = array('name'=>'start_date','value' => $_POST['start_date']);
       $process_params[] = array('name'=>'end_date','value' => $_POST['end_date']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);
       $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'value_type_id','value' => $_POST['value_type_id']);
       $process_params[] = array('name'=>'group_type_id','value' => $_POST['group_type_id']);
       $process_params[] = array('name'=>'emotion_id','value' => $_POST['emotion_id']);
       $process_params[] = array('name'=>'purpose_id','value' => $_POST['purpose_id']);
       $process_params[] = array('name'=>'positivity','value' => $_POST['positivity']);
       $process_params[] = array('name'=>'probability','value' => $_POST['probability']);
       $process_params[] = array('name'=>'sibaseunit_id','value' => $_POST['sibaseunit_id']);
       $process_params[] = array('name'=>'time_frame_id','value' => $_POST['time_frame_id']);
       $process_params[] = array('name'=>'ethics_id','value' => $_POST['ethics_id']);
       $process_params[] = array('name'=>'external_source_id','value' => $_POST['external_source_id']); // Should have been sent
       $process_params[] = array('name'=>'source_object_id','value' => $_POST['source_object_id']); // Should have been sent
       $process_params[] = array('name'=>'source_object_item_id','value' => $_POST['source_object_item_id']);
       $process_params[] = array('name'=>'object_id','value' => $_POST['object_id']); // The value of the object
       $process_params[] = array('name'=>'external_url','value' => $_POST['external_url']);

       $process_params[] = array('name'=>'fb_event_id','value' => $_POST['fb_event_id']);

       $process_params[] = array('name'=>'street','value' => $_POST['street']);
       $process_params[] = array('name'=>'city','value' => $_POST['city']);
       $process_params[] = array('name'=>'state','value' => $_POST['state']);
       $process_params[] = array('name'=>'zip','value' => $_POST['zip']);
       $process_params[] = array('name'=>'latitude','value' => $_POST['latitude']);
       $process_params[] = array('name'=>'longitude','value' => $_POST['longitude']);
       $process_params[] = array('name'=>'event_url','value' => $_POST['event_url']);
       $process_params[] = array('name'=>'location','value' => $_POST['location']);
       $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);

       $process_params[] = array('name'=>'category_id','value' => $_POST['category_id']);

       $process_params[] = array('name'=>'social_networking_id','value' => $_POST['social_networking_id']);
       $process_params[] = array('name'=>'portal_account_id','value' => $_POST['portal_account_id']);

       $event_image_url = $_POST['event_image_url'];
       #if ($event_image_url != NULL){
          #$event_image_url = urlencode($event_image_url);
       #   }
       $process_params[] = array('name'=>'event_image_url','value' => $event_image_url);

       $add_parent = $_POST['add_parent'];

       if ($add_parent == NULL){
          $process_params[] = array('name'=>'sclm_events_id_c','value' => $_POST['sclm_events_id_c']);
          }

       $process_params[] = array('name'=>'value','value' => $_POST['value_type_value']);

       $process_params[] = array('name'=>'menstruation_phase_id','value' => $_POST['menstruation_phase_id']);

       $process_params[] = array('name'=>'start_years','value' => $_POST['start_years']);
       $process_params[] = array('name'=>'end_years','value' => $_POST['end_years']);
       $process_params[] = array('name'=>'allow_joiners','value' => $_POST['allow_joiners']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $process_action, $process_params);

       $sclm_events_id_c = $result['id'];

       $cmn_statuses_id_c = $_POST['cmn_statuses_id_c'];

       if (!$cmn_statuses_id_c){
          $cmn_statuses_id_c = $standard_statuses_closed;
          }

       # Make ProjectTask/Event relationship
       $project_task_id = $_POST['project_task_id'];

       if ($project_task_id != NULL){

          $event_projecttask_cit = '5fa66dca-fcf0-6886-999b-55f3092c0ec3';

          $eventtask_ci_object_type = 'ConfigurationItems';
          $eventtask_ci_action = "select";
          $eventtask_ci_params[0] = "sclm_configurationitemtypes_id_c='".$event_projecttask_cit."' && name='".$sclm_events_id_c."' ";
          $eventtask_ci_params[1] = "id,name"; // select array
          $eventtask_ci_params[2] = ""; // group;
          $eventtask_ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
          $eventtask_ci_params[4] = ""; // limit
  
          $eventtask_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $eventtask_ci_object_type, $eventtask_ci_action, $eventtask_ci_params);

          if (is_array($eventtask_ci_items)){

             for ($eventtask_cnt=0;$eventtask_cnt < count($eventtask_ci_items);$eventtask_cnt++){

                 # Gather the wrapper ID
                 $eventtask_ci_wrapper_id = $eventtask_ci_items[$eventtask_cnt]['id'];
                 }

             } else {# is array - end create wrapper

             $process_object_type = "ConfigurationItems";
             $process_action = "update";
      
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => $ci);
             $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $event_projecttask_cit);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
   
             $wrapper_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             $eventtask_ci_wrapper_id = $wrapper_result['id'];

             } 

          if ($eventtask_ci_wrapper_id != NULL){
             # Should be here if an array!
   
             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => $ci);
             $process_params[] = array('name'=>'name','value' => $project_task_id);
             $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $eventtask_ci_wrapper_id);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

             $taskrel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
             $task_ci_relevent_id = $taskrel_result['id'];

             $projecttask_returner = $funky_gear->object_returner ("ProjectTasks", $project_task_id);
             $projecttask_return_name = $projecttask_returner[0];

             $projecttask_relate_result = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$project_task_id."&valuetype=".$valtype."&sendiv=lightform');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\"><font color=#151B54 size=3><B>".$projecttask_return_name."</font></a>";

             } # is array - end create wrapper

             $process_message = "<center><B>Creating the Project Task relationship was successful!</B></center><BR>";
             $process_message .= $projecttask_relate_result;

          } # End if project task

       # Adding a new event that is related to another, not parent
       $add_related = $_POST['add_related'];
       $add_virtual_related = $_POST['add_virtual_related'];
       $add_virtual_parent = $_POST['add_virtual_parent'];
       $add_virtual_child = $_POST['add_virtual_child'];

       if ($add_related != NULL || $add_virtual_related != NULL || $add_virtual_parent != NULL || $add_virtual_child != NULL){

          # Check if related events wrapper exists - if not, create!
          #$par_event_id = $_POST['value'];
          #$sclm_events_id_c = $_POST['sclm_events_id_c'];

          if ($add_related != NULL){
             $cit = 'e8fba75e-14a2-2056-f4ef-550b222f36fc'; # Related CIT
             } elseif ($add_virtual_related != NULL){
             $cit = '7e756b2f-e4ac-aa81-9868-54fd6e2653f5'; # Related CIT
             $add_related = $add_virtual_related;
             } elseif ($add_virtual_parent != NULL){
             $cit = '55f17a75-0dc8-b1a6-5779-54fd6b19b1c1'; # Related CIT
             $add_related = $add_virtual_parent;
             } elseif ($add_virtual_child != NULL){
             $cit = 'c45dccee-5eac-9816-fc50-54fd6ee2c6d7'; # Related CIT
             $add_related = $add_virtual_child;
             }

          $ci_object_type = 'ConfigurationItems';
          $ci_action = "select";
          $ci_params[0] = "sclm_configurationitemtypes_id_c='".$cit."' && name='".$add_related."' ";
          $ci_params[1] = "id,name"; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
          $ci_params[4] = ""; // limit
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

                 # Gather the wrapper ID
                 $ci_wrapper_id = $ci_items[$cnt]['id'];
                 }

             } # is array - end create wrapper

          if ($ci_wrapper_id != NULL){
             # Should be here if an array!
   
             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => $ci);
             $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
             $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $ci_wrapper_id);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

             $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
   
             $ci_relevent_id = $rel_result['id'];

             $event_returner = $funky_gear->object_returner ("Effects", $add_related);
             $event_return_name = $event_returner[0];

             $relate_result = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$add_related."&valuetype=".$valtype."&sendiv=lightform');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\"><font color=#151B54 size=3><B>".$event_return_name."</font></a>";

             } else {
             # No wrapper exists - create
                   
             $process_object_type = "ConfigurationItems";
             $process_action = "update";
      
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => $ci);
             $process_params[] = array('name'=>'name','value' => $add_related);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $cit);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
   
             $wrapper_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             $ci_wrapper_id = $wrapper_result['id'];
 
             $process_object_type = "ConfigurationItems";
             $process_action = "update";
   
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => $ci);
             $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
             $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $ci_wrapper_id);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);

             $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $ci_relevent_id = $rel_result['id'];
 
             $event_returner = $funky_gear->object_returner ("Effects", $add_related);
             $event_return_name = $event_returner[0];
      
             $relate_result = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$add_related."&valuetype=".$valtype."&sendiv=lightform');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\"><font color=#151B54 size=3><B>".$event_return_name."</font></a>";

             } # is array - end create wrapper

             $process_message = "<center><B>Creating the relationship was successful!</B></center><BR>";
             $process_message .= $relate_result;
       
          } # add related

       if ($add_parent != NULL){

          # First get the parent of the new parent - this will be the parent of this fresh event
          $check_action_object_type = "Events";
          $check_action = "select";
          $check_action_params = array();
          $check_action_params[0] = " id='".$add_parent."' ";
          $check_action_params[1] = "sclm_events_id_c";
          $check_action_params[2] = "";
          $check_action_params[3] = "";
          $check_action_params[4] = "";
   
          $check_events = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $check_action_object_type, $check_action, $check_action_params);

           if (is_array($check_events)){

              # get parent effects
              for ($cnt=0;$cnt < count($check_events);$cnt++){

                  $orig_par_event_id = $check_events[$cnt]['sclm_events_id_c'];

                  } # for

              if ($orig_par_event_id != NULL){

                 $object_type = "Events";
                 $process_action = "update";
                 $process_params = "";
                 $process_params = array();
                 $process_params[] = array('name'=>'id','value' => $sclm_events_id_c);
                 $process_params[] = array('name'=>'sclm_events_id_c','value' => $orig_par_event_id);
                 $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $process_action, $process_params);

                 } # if original par event

              } # is array

          $object_type = "Events";
          $process_action = "update";
          $process_params = "";
          $process_params = array();
          $process_params[] = array('name'=>'id','value' => $add_parent);
          $process_params[] = array('name'=>'sclm_events_id_c','value' => $sclm_events_id_c);
          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $process_action, $process_params);

          #
          }

       $store_location = $_POST['store_location'];
       $share_location = $_POST['share_location'];
       $update_location = $_POST['update_location'];
       $location_id = $_POST['location_id'];

       #echo "store_location: $store_location <BR>";
       #echo "share_location: $share_location <BR>";
       #echo "update_location: $update_location <BR>";
       #echo "location_id: $location_id <BR>";

       if ($share_location == 1){
          $share_status = $standard_statuses_open;
          } else {
          $share_status = $standard_statuses_closed;
          }

       if ($store_location == 1 || ($location_id != NULL && $update_location ==1)){

          $process_object_type = "ConfigurationItems";
          $process_action = "update";

          $locations_cit = "a6961896-8520-6458-f8a0-5500ecc82857";

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $location_id);
          $process_params[] = array('name'=>'name','value' => $_POST['location']);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'description','value' => $_POST['location']);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $locations_cit);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $loc_wrapp_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
          $loc_wrapp_id = $loc_wrapp_result['id'];

          # Use the wrapper to store each location part

          $city_cit = "8c3069fc-53d0-ec7e-12c8-5500ed6023c0";
          $country_cit = "a73167d6-3a49-50a1-a701-5500ed03f14c";
          $event_url_cit = "5cc37cdb-9e6b-b5c4-9a9d-550c5af2afb1";
          $latitude_cit = "92e5c9b0-c016-305c-b25d-5500ed1511ae";
          $longitude_cit = "6937587f-b655-3954-1641-5500ed1bf0e9";
          $state_cit = "6dea2c99-7b16-e6f3-2023-5500edf2dc7c";
          $zip_cit = "e367d79e-9bed-119f-1f8d-5500ed5339d7";
          $street_cit = "4f3a85bd-0a6a-7325-9016-550c775b2e70";

          if ($location_id != NULL){

             # Capture the existing

             $location_query = " sclm_configurationitems_id_c='".$location_id."' && (sclm_configurationitemtypes_id_c='".$city_cit."' || sclm_configurationitemtypes_id_c='".$country_cit."' || sclm_configurationitemtypes_id_c='".$event_url_cit."' || sclm_configurationitemtypes_id_c='".$latitude_cit."' || sclm_configurationitemtypes_id_c='".$longitude_cit."' || sclm_configurationitemtypes_id_c='".$state_cit."' || sclm_configurationitemtypes_id_c='".$zip_cit."' || sclm_configurationitemtypes_id_c='".$street_cit."') ";

             $ci_object_type = "ConfigurationItems";
             $ci_params[0] = $location_query;
             $ci_action = "select";
             $ci_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
             $ci_params[2] = ""; // group;
             $ci_params[3] = " name, date_entered DESC "; // order;
             $ci_params[4] = ""; // limit

             $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

             if (is_array($ci_items)){    

                for ($cnt=0;$cnt < count($ci_items);$cnt++){

                    $ci_id = $ci_items[$cnt]['id'];
                    $name = $ci_items[$cnt]['name'];
                    $cit_id = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
                    #$record_owner = $ci_items[$cnt]['contact_id_c'];

                    if ($cit_id == $event_url_cit){
                       $event_url_id = $ci_id;
                       } # if event_url

                    if ($cit_id == $latitude_cit){
                       $latitude_id = $ci_id;
                       } # if latitude

                    if ($cit_id == $longitude_cit){
                       $longitude_id = $ci_id;
                       } # if longitude

                    if ($cit_id == $street_cit){
                       $street_id = $ci_id;
                       } # if street

                    if ($cit_id == $city_cit){
                       $city_id = $ci_id;
                       } # if city

                    if ($cit_id == $state_cit){
                       $state_id = $ci_id;
                       } # if state

                    if ($cit_id == $country_cit){
                       $country_id = $ci_id;
                       } # if Country
 
                    if ($cit_id == $zip_cit){
                       $zip_id = $ci_id;
                       } # zip

                    } # for

                } # is array

             } # if ($location_id

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $street_id);
          $process_params[] = array('name'=>'name','value' => $_POST['street']);
          $process_params[] = array('name'=>'description','value' => $_POST['street']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $street_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $city_id);
          $process_params[] = array('name'=>'name','value' => $_POST['city']);
          $process_params[] = array('name'=>'description','value' => $_POST['city']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $city_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $state_id);
          $process_params[] = array('name'=>'name','value' => $_POST['state']);
          $process_params[] = array('name'=>'description','value' => $_POST['state']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $state_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $zip_id);
          $process_params[] = array('name'=>'name','value' => $_POST['zip']);
          $process_params[] = array('name'=>'description','value' => $_POST['zip']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $zip_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $latitude_id);
          $process_params[] = array('name'=>'name','value' => $_POST['latitude']);
          $process_params[] = array('name'=>'description','value' => $_POST['latitude']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $latitude_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $longitude_id);
          $process_params[] = array('name'=>'name','value' => $_POST['longitude']);
          $process_params[] = array('name'=>'description','value' => $_POST['longitude']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $longitude_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $event_url_id);
          $process_params[] = array('name'=>'name','value' => $_POST['event_url']);
          $process_params[] = array('name'=>'description','value' => $_POST['event_url']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $event_url_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $process_params = "";
          $process_params = array();  
          $process_params[] = array('name'=>'id','value' => $country_id);
          $process_params[] = array('name'=>'name','value' => $_POST['cmn_countries_id_c']);
          $process_params[] = array('name'=>'description','value' => $_POST['cmn_countries_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $country_cit);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $loc_wrapp_id);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $share_status);

          $street_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          } # end storing location


       foreach ($_POST as $fbkey=>$fbvalue){

               # echo "Key $fbkey value $fbvalue <BR>";
               $newkey = str_replace("fb_event_id_","",$fbkey);
               if ($newkey != $fbkey && $fbvalue == 1){
                  $fb_event_id = $newkey;
                  } 

              } # foreach

       # Connect this event to the FB event
       # Facebook Events CIT: 8a2658e3-3e56-743c-a656-55196e298a99
       # External Event Service Management | ID: 4b500488-f58b-5c3b-67b2-552e89d0880f
       # General Event Wrapper | ID: 4f58a04e-eea7-0c32-d6db-552e893ac315

       if ($fb_event_id != NULL){

          $event_wrapper_cit = "4f58a04e-eea7-0c32-d6db-552e893ac315";
          $fbevents_cit = "8a2658e3-3e56-743c-a656-55196e298a99";

          # First see if this wrapper exists
          $wrapper_event_query = " account_id_c='".$_POST['account_id_c']."' && sclm_configurationitemtypes_id_c='".$event_wrapper_cit."' && name='".$sclm_events_id_c."' ";

          $wrapper_event_object_type = "ConfigurationItems";
          $wrapper_event_action = "select";
          $wrapper_event_params[0] = $wrapper_event_query;
          $wrapper_event_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
          $wrapper_event_params[2] = ""; // group;
          $wrapper_event_params[3] = " name, date_entered DESC "; // order;
          $wrapper_event_params[4] = ""; // limit

          $wrapper_event_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wrapper_event_object_type, $wrapper_event_action, $wrapper_event_params);

          if (is_array($wrapper_event_items)){    

             for ($wrapper_eventcnt=0;$wrapper_eventcnt < count($wrapper_event_items);$wrapper_eventcnt++){

                 $wrapper_id = $wrapper_event_items[$wrapper_eventcnt]['id'];

                 } # for

             } else {# is array

             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = "";
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => "");
             $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'description','value' => $sclm_events_id_c);
             $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
             $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $event_wrapper_cit);
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

             $wrapp_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $wrapper_id = $wrapp_result['id'];

             } # no wrapper

          if ($wrapper_id != NULL){

             $process_object_type = "ConfigurationItems";
             $process_action = "update";

             # First see if this event exists
             $fb_event_query = " account_id_c='".$_POST['account_id_c']."' && sclm_configurationitemtypes_id_c='".$fbevents_cit."'  && sclm_configurationitems_id_c='".$wrapper_id."' && name='".$fb_event_id."' ";

             $fbevent_object_type = "ConfigurationItems";
             $fbevent_params[0] = $fb_event_query;
             $fbevent_action = "select";
             $fbevent_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
             $fbevent_params[2] = ""; // group;
             $fbevent_params[3] = " name, date_entered DESC "; // order;
             $fbevent_params[4] = ""; // limit

             $fbevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbevent_object_type, $fbevent_action, $fbevent_params);

             if (is_array($fbevent_items)){    

                for ($fbeventcnt=0;$fbeventcnt < count($fbevent_items);$fbeventcnt++){

                    $fb_ci_id = $fbevent_items[$fbeventcnt]['id'];

                    } # for

                $process_object_type = "ConfigurationItems";
                $process_action = "update";
                $process_params = "";
                $process_params = array();  
                $process_params[] = array('name'=>'id','value' => $fb_ci_id);
                #$process_params[] = array('name'=>'name','value' => $fb_event_id);
                #$process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                #$process_params[] = array('name'=>'description','value' => $fb_event_id);
                #$process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                #$process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                #$process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $fbwrapper_id);
                #$process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $fbevents_cit);
                $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                $fb_event_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $fb_ci_id = $fb_event_result['id'];    

                } else {# is array           

                $process_object_type = "ConfigurationItems";
                $process_action = "update";
                $process_params = "";
                $process_params = array();  
                #$process_params[] = array('name'=>'id','value' => "");
                $process_params[] = array('name'=>'name','value' => $fb_event_id);
                $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                $process_params[] = array('name'=>'description','value' => $fb_event_id);
                $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $wrapper_id);
                $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $fbevents_cit);
                $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                $fb_event_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $fb_ci_id = $fb_event_result['id'];                

                } # not exist

             } # if wrapper

          $fb_message = "<P>The Facebook Event has been connected to this event<P>";

          } # if FB event

       if ($_POST['create_fb_feed'] != NULL){

          require_once ("api-facebook.php");

          $fb_params[0] = "post_feed"; #fb_action;
          $fb_params[1] = $fb_session; # userid

          $fb_params[2] = $_POST['name'];
          $fb_params[3] = $_POST['name']." on ".$portal_title;

          $message_link = "Body@".$lingo."@Effects@view@".$sclm_events_id_c."@Effects";
          $message_link = $funky_gear->encrypt($message_link);
          $message_link = "http://".$hostname."/?pc=".$message_link;

          $fb_params[4] = $message_link;

          $message = $_POST['name']." on ".$portal_title.": [Start Date: ".$_POST['start_date'].", End Date: ".$_POST['end_date']."] @ ".$_POST['location']." (".$_POST['timezone'].")";
          $fb_params[5] = $message;

          $fb_feed_return = do_facebook ($fb_params);

          $fb_feed_id = $fb_feed_return[0];
          $return_message = $fb_feed_return[1];

          /*
          $fbevents_return = do_facebook ($fb_params);

          $new_fbevent_id = $fbevents_return[0];
          $return_message = $fbevents_return[1];

          $fb_message .= "<P>".$return_message."<P>";

          if ($new_fbevent_id != NULL){

             $fb_message .= "<P>This event has been posted to Facebook<P>";

             $fbevents_cit = "8a2658e3-3e56-743c-a656-55196e298a99";

             # First see if this wrapper exists
             $fbw_event_query = " account_id_c='".$_POST['account_id_c']."' && sclm_configurationitemtypes_id_c='".$fbevents_cit."' && name='".$sclm_events_id_c."' ";

             $fbwevent_object_type = "ConfigurationItems";
             $fbwevent_action = "select";
             $fbwevent_params[0] = $fbw_event_query;
             $fbwevent_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
             $fbwevent_params[2] = ""; // group;
             $fbwevent_params[3] = " name, date_entered DESC "; // order;
             $fbwevent_params[4] = ""; // limit

             $fbwevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbwevent_object_type, $fbwevent_action, $fbwevent_params);

             if (is_array($fbwevent_items)){    

                for ($fbweventcnt=0;$fbweventcnt < count($fbwevent_items);$fbweventcnt++){

                    $fbwrapper_id = $fbwevent_items[$fbweventcnt]['id'];

                    } # for

                } else {# is array

                # Create the wrapper
                $process_object_type = "ConfigurationItems";
                $process_action = "update";
                $process_params = "";
                $process_params = array();  
                #$process_params[] = array('name'=>'id','value' => "");
                $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
                $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                $process_params[] = array('name'=>'description','value' => $sclm_events_id_c);
                $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $fbevents_cit);
                $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                $fb_wrapp_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $fbwrapper_id = $fb_wrapp_result['id'];

                } # no wrapper

             if ($fbwrapper_id != NULL){

                $process_object_type = "ConfigurationItems";
                $process_action = "update";

                # First see if this event exists
                $fb_event_query = " account_id_c='".$_POST['account_id_c']."' && sclm_configurationitemtypes_id_c='".$fbevents_cit."'  && sclm_configurationitems_id_c='".$fbwrapper_id."' && name='".$new_fbevent_id."' ";

                $fbevent_object_type = "ConfigurationItems";
                $fbevent_params[0] = $fb_event_query;
                $fbevent_action = "select";
                $fbevent_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
                $fbevent_params[2] = ""; // group;
                $fbevent_params[3] = " name, date_entered DESC "; // order;
                $fbevent_params[4] = ""; // limit

                $fbevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fbevent_object_type, $fbevent_action, $fbevent_params);

                if (is_array($fbevent_items)){    

                   for ($fbeventcnt=0;$fbeventcnt < count($fbevent_items);$fbeventcnt++){

                       $fb_ci_id = $fbevent_items[$fbeventcnt]['id'];

                       } # for

                   $process_object_type = "ConfigurationItems";
                   $process_action = "update";
                   $process_params = "";
                   $process_params = array();  
                   $process_params[] = array('name'=>'id','value' => $fb_ci_id);
                   #$process_params[] = array('name'=>'name','value' => $fb_event_id);
                   #$process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                   #$process_params[] = array('name'=>'description','value' => $fb_event_id);
                   #$process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                   #$process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                   #$process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $fbwrapper_id);
                   #$process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $fbevents_cit);
                   $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                   $fb_event_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                   $fb_ci_id = $fb_event_result['id'];    

                   } else {# is array           

                   $process_object_type = "ConfigurationItems";
                   $process_action = "update";
                   $process_params = "";
                   $process_params = array();  
                   #$process_params[] = array('name'=>'id','value' => "");
                   $process_params[] = array('name'=>'name','value' => $new_fbevent_id);
                   $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                   $process_params[] = array('name'=>'description','value' => $new_fbevent_id);
                   $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                   $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                   $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $fbwrapper_id);
                   $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $fbevents_cit);
                   $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                   $fb_event_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                   $fb_ci_id = $fb_event_result['id'];                

                   } # not exist

                } # if wrapper

             } # if new_fbevent_id
          */          

          } # if post to FB

       $gg_cal_id = $_POST['gg_cal_id'];
       $create_google_event = $_POST['create_google_event'];

       if ($gg_cal_id != NULL && $create_google_event != NULL){

          require_once ("api-google.php");

          $summary = $_POST['name'];
          $description = $_POST['description'];
          $start_date = $_POST['start_date'];
          $end_date = $_POST['end_date'];

          $street = $_POST['street'];
          $city = $_POST['city'];
          $state = $_POST['state'];
          $zip = $_POST['zip'];
          $latitude = $_POST['latitude'];
          $longitude = $_POST['longitude'];
          $event_url = $_POST['event_url'];
          $location = $_POST['location'];

          $gg_event_id = $_POST['gg_event_id'];

          $location = $location." ".$street." ".$city." ".$state." ".$zip;

          $cmn_countries_id_c = $_POST['cmn_countries_id_c'];

          $gg_start_date = $funky_gear->date3339($start_date);
          $gg_end_date = $funky_gear->date3339($end_date);

          # Should update event if exists already using event ID
          $gg_params[0] = "post_event"; #gg_action;
          $gg_params[1] = $gg_session; # gg_session
          $gg_params[2] = $summary; # summary
          $gg_params[3] = $location; # location
          $gg_params[4] = $gg_start_date; # gg_start_date
          $gg_params[5] = $gg_end_date; # gg_end_date
          $gg_params[6] = $attendee1; # attendee1
          $gg_params[7] = $gg_cal_id; # gg_cal_id
          $gg_params[8] = $description; # description
          $gg_params[9] = $gg_event_id; # gg_event_id

          $google_event_id = do_google ($gg_params);

          if ($google_event_id != NULL && $gg_event_id == NULL){

             #Google Events | ID: a007a200-4cef-1938-6671-552e818965d1

             $event_wrapper_cit = "4f58a04e-eea7-0c32-d6db-552e893ac315";
             $ggevents_cit = "a007a200-4cef-1938-6671-552e818965d1";

             # First see if this wrapper exists
             $wrapper_event_query = " account_id_c='".$_POST['account_id_c']."' && sclm_configurationitemtypes_id_c='".$event_wrapper_cit."' && name='".$sclm_events_id_c."' ";

             $wrapper_event_object_type = "ConfigurationItems";
             $wrapper_event_action = "select";
             $wrapper_event_params[0] = $wrapper_event_query;
             $wrapper_event_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
             $wrapper_event_params[2] = ""; // group;
             $wrapper_event_params[3] = " name, date_entered DESC "; // order;
             $wrapper_event_params[4] = ""; // limit

             $wrapper_event_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $wrapper_event_object_type, $wrapper_event_action, $wrapper_event_params);

             if (is_array($wrapper_event_items)){    

                for ($wrapper_eventcnt=0;$wrapper_eventcnt < count($wrapper_event_items);$wrapper_eventcnt++){
   
                    $wrapper_id = $wrapper_event_items[$wrapper_eventcnt]['id'];

                    } # for

                } else {# is array

                $process_object_type = "ConfigurationItems";
                $process_action = "update";
                $process_params = "";
                $process_params = array();  
                #$process_params[] = array('name'=>'id','value' => "");
                $process_params[] = array('name'=>'name','value' => $sclm_events_id_c);
                $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                $process_params[] = array('name'=>'description','value' => $sclm_events_id_c);
                $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $event_wrapper_cit);
                $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                $wrapp_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $wrapper_id = $wrapp_result['id'];

                } # no wrapper

             if ($wrapper_id != NULL){

                $process_object_type = "ConfigurationItems";
                $process_action = "update";

                # First see if this event exists
                $gg_event_query = " account_id_c='".$_POST['account_id_c']."' && sclm_configurationitemtypes_id_c='".$ggevents_cit."'  && sclm_configurationitems_id_c='".$wrapper_id."' && name='".$google_event_id."' ";

                $ggevent_object_type = "ConfigurationItems";
                $ggevent_params[0] = $gg_event_query;
                $ggevent_action = "select";
                $ggevent_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
                $ggevent_params[2] = ""; // group;
                $ggevent_params[3] = " name, date_entered DESC "; // order;
                $ggevent_params[4] = ""; // limit

                $ggevent_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ggevent_object_type, $ggevent_action, $ggevent_params);

                if (is_array($ggevent_items)){    
   
                   for ($ggeventcnt=0;$ggeventcnt < count($ggevent_items);$ggeventcnt++){

                       $gg_ci_id = $ggevent_items[$ggeventcnt]['id'];

                       } # for

                   $process_object_type = "ConfigurationItems";
                   $process_action = "update";
                   $process_params = "";
                   $process_params = array();  
                   $process_params[] = array('name'=>'id','value' => $gg_ci_id);
                   #$process_params[] = array('name'=>'name','value' => $fb_event_id);
                   #$process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                   #$process_params[] = array('name'=>'description','value' => $fb_event_id);
                   #$process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                   #$process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                   #$process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $fbwrapper_id);
                   #$process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $fbevents_cit);
                   $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                   $gg_event_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                   $gg_ci_id = $gg_event_result['id'];    

                   } else {# is array           

                   $process_object_type = "ConfigurationItems";
                   $process_action = "update";
                   $process_params = "";
                   $process_params = array();  
                   #$process_params[] = array('name'=>'id','value' => "");
                   $process_params[] = array('name'=>'name','value' => $google_event_id);
                   $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                   $process_params[] = array('name'=>'description','value' => $gg_cal_id);
                   $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                   $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                   $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $wrapper_id);
                   $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $ggevents_cit);
                   $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);

                   $gg_event_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                   $gg_ci_id = $gg_event_result['id'];                

                   } # not exist

                } # if wrapper

             $gg_message = "<P>The Google Event has been connected to this event<P>";

             } # if ID

          } # if google

       $process_message .= $strings["SubmissionSuccess"]."<P>";

       $process_message .= "<BR><B>".$strings["Name"].":</B> <a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$sclm_events_id_c."&valuetype=".$do."');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">".$_POST['name']."</a><BR>";

       $sent_description = str_replace("\n", "<br>", $_POST['description']);
       $process_message .= "<B>".$strings["Description"].":</B> ".$sent_description."<BR>";

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       $process_message .= $fb_message.$gg_message;

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";  

       } else {// no error

       if ($sendiv == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";


       }

   break; // end process

  } // end actions

# break; // End Effects
##########################################################
?>