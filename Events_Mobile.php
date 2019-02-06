<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-24
# Page: Events_Mobile.php 
##########################################################
# case 'Events_Mobile':

  switch ($action){

   case 'list':

    echo "List";

   break;
   case 'view':
   case 'view_related':

    echo "<h2>Effects</h2>";

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

           if ($sess_contact_id == $contact_id_c || $auth == 3){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=2 color=RED><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $effect = "<div style=\"".$divstyle_white."\">";
           $effect .= "<div style=\"margin-left:4px;margin-right:4px;float:left; background: ".$body_color.";min-width:98%;min-height:100px;border:0;overflow:auto;\">";

           if ($sess_contact_id != NULL){

              $share_button = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"share\" id=\"share\" value=\"Share Event\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=Messages&action=add&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\">";

              $effect .= "<center>".$share_button."</center><P>";

              } # if contact

           $effect .= $contact_profile;

           $effect .= "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:4px;margin-bottom:4px;margin-left:4px;margin-right:4px; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Event Content</B></font></center></div>";

           if ($event_image_url){

              $effect .= "<BR><center><a href='".$event_image_url."' data-lightbox=\"".$do."\" title=\"".$event_name."\"><img src=".$event_image_url." width=400></a></center><BR>";

              }

           if ($category_id != NULL){

              $#category_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $category_id);
              #$category_name = $category_returner[0];
              $category = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&value=".$val."&valuetype=Effects&lstsubval=".$category_id."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=3 color=#151B54><B>".$category_name." ".$category_id."</B></font></a>";

              }

           $effect .= "<font color=#FBB117 size=3><B>".$strings["Category"].":</B></font> <font color=#151B54 size=3><B>".$category."</B></font><BR>";


           $effect .= "<font color=#FBB117 size=3><B>".$strings["Views"].":</B></font> <font color=#151B54 size=3><B>".$new_viewcount."</B></font><BR>";

           $effect .= "<font color=#FBB117 size=3><B>".$strings["Name"].":</B></font> ".$edit."<font color=#151B54 size=3><B>".$event_name."</B></font><BR>";

           $effect .= "<font color=#FBB117 size=3><B>".$strings["DateStart"].":</B></font> <font color=#151B54 size=3><B>".$start_date." [".$time_frame."]</B></font><BR>";

           if ($end_date){
              $effect .= "<font color=#FBB117 size=3><B>".$strings["DateEnd"].":</B></font> <font color=#151B54 size=3><B>".$end_date."</B></font><BR>";
              }

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

           #$effect .= "<font color=#FBB117 size=3><B>Map:</B></font> ".$map." ".$close_map."<BR>";

           $effect .= "<P><font color=#151B54 size=2>".$description."</font><P>";

           $effect .= "<center>".$share_button."</center>";

           $effect .= "</div>";
           $effect .= "</div>";

           } // end for

       ################################  

       ################################  

       echo "<div style=\"".$divstyle_blue."\"><center><font size=3><B>".$strings["SharedEffect"]."</B></font></center></div>";

       echo $effect;

   break; # view

  }

# break; // End Events_Mobile
##########################################################
?>