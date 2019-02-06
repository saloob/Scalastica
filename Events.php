<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-03-08
# Page: Index 
##########################################################
# case 'Events':

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     if (!$sendiv){
        $sendiv = $BodyDIV;
        }
     }

if ($action == 'add'){

   if ($valtype == 'Events'){
      $sclm_events_id_c = $val;
      }

   if ($valtype == 'Effects'){
      $sclm_effects_id_c = $val;
      }

   if ($valtype == 'BranchBodies'){
      $cmv_branchbodies_id_c = $val;
      }

   if ($valtype == 'BranchBodyDepartmentAgencies'){
      $cmv_departmentagencies_id_c = $val;
      }

   if ($valtype == 'BranchBodyIndependentAgencies'){
      $cmv_independentagencies_id_c = $val;
      }

   if ($valtype == 'BranchBodyDepartments'){
      $cmv_branchdepartments_id_c = $val;
      }

   if ($valtype == 'PoliticalParties'){
      $cmv_politicalparties_id_c = $val;
      }

   if ($valtype == 'PoliticalPartyRoles'){
      $cmv_politicalpartyroles_id_c = $val;
      }

   if ($valtype == 'GovernmentRoles'){
      $cmv_governmentroles_id_c = $val;
      }

   if ($valtype == 'Governments'){
      $cmv_governments_id_c = $val;
      }

   if ($valtype == 'DepartmentAgencies'){
      $cmv_governments_id_c = $val;
      }

   if ($valtype == 'Causes'){
      $cmv_causes_id_c = $val;
      }

   if ($valtype == 'GovernmentPolicies'){
      $cmv_governmentpolicies_id_c = $val;
      }

   if ($valtype == 'GovernmentConstitutions'){
      $cmv_governmentconstitutions_id_c = $val;
      }

   if ($valtype == 'ConstitutionalArticles' || $valtype == 'ConstitutionArticles'){
      $cmv_constitutionalarticles_id_c = $val;
      }

  } // end if add

if ($valtype == NULL && $val == NULL){
   $object_return_params[0] = " delete=0 && (sclm_events_id_c='' || sclm_events_id_c IS NULL) ";
   }

if ($action == 'edit' || $action == 'view' || $action == 'list'){

   $event_params = array();

   if ($action == 'edit' || $action == 'view'){

      $event_params[0] = " id='".$val."' ";

      } else {

      $event_params[0] = $object_return_params[0];

      if ($valtype == 'Search'){
 
         //$event_params[0] .= " && (".$new_title_field." like '%".$val."%' || ".$news_content_field." like '%".$val."%')";

         }

      }

   } // end if edt/view/list

    if ($latitude && $longitude){
       
       $event_map = "<P><div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"changemapwidth();GMAPLL($venue_latitude,$venue_longitude);return false\"><font color=red><B>View Map</B></font></a></div><P>";
             
       }

  switch ($action){

   case 'list':

    if ($val != NULL){
       echo $object_return;
       echo "<img src=images/blank.gif width=450 height=10><BR>";
       }

    echo "<div style=\"".$divstyle_orange_light."\">".$strings["Events_Usage"]."</div>";
    echo "<BR><img src=images/blank.gif width=450 height=10><BR>";
    
    $object_type = "Events";
          
    $event_action = "select";

    $event_params = array();

    if ($valtype == 'Search'){
       $event_params[0] = $object_return_params[0];
       } else {
       $event_params[0] = $object_return_params[0];
       }

    if ($event_params[0] == NULL){
       $event_params[0] = " deleted=0 ";
       }

    $event_params[0] .= " && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') ";
    $event_params[1] = "*";
    $event_params[2] = "";
    $event_params[3] = " start_date DESC ";
    $event_params[4] = "";

    $the_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $event_action, $event_params);

    if (is_array($the_list)){

       $count = count($the_list);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $extraparams = "";

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV,$extraparams);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       $event_params = array();
       $event_params[0] = $object_return_params[0];

       if ($event_params[0] == NULL){
          $event_params[0] = " deleted=0 ";
          }

       #$event_params[0] .= " && cmn_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'";
       $event_params[1] = "*";
       $event_params[2] = "";
       $event_params[3] = " start_date DESC ";
       $event_params[4] = " $lfrom , $glb_perpage_items ";

       $the_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $event_action, $event_params);

       $i = 1; // Column counter starts at 1 - will always be one except for images.

       $addevent = "";
     
       for ($cnt=0;$cnt < count($the_list);$cnt++){

           $object_return_target = "";

           $id = $the_list[$cnt]['id'];
           $name = $the_list[$cnt]['name'];
           $date_entered = $the_list[$cnt]['date_entered'];
           $date_modified = $the_list[$cnt]['date_modified'];
           $modified_user_id = $the_list[$cnt]['modified_user_id'];
           $created_by = $the_list[$cnt]['created_by'];
           $description = $the_list[$cnt]['description'];
           $assigned_user_id = $the_list[$cnt]['assigned_user_id'];

           $account_id_c = $the_list[$cnt]['account_id_c'];
           $contact_id_c = $the_list[$cnt]['contact_id_c'];

           $cmn_statuses_id_c = $the_list[$cnt]['cmn_statuses_id_c'];
           $cmn_languages_id_c = $the_list[$cnt]['cmn_languages_id_c'];
           $cmn_countries_id_c = $the_list[$cnt]['cmn_countries_id_c'];
           $cmn_currencies_id_c = $the_list[$cnt]['cmn_currencies_id_c'];

           $view_count = $the_list[$cnt]['view_count'];
           $time_frame_id = $the_list[$cnt]['time_frame_id'];
           $sclm_events_id_c = $the_list[$cnt]['sclm_events_id_c'];
           $date_start = $the_list[$cnt]['start_date'];
           $date_end = $the_list[$cnt]['end_date'];

           $object_type_id = $the_list[$cnt]['object_type_id'];
           $object_value = $the_list[$cnt]['object_value'];

           $street = $the_list[$cnt]['street'];
           $city = $the_list[$cnt]['city'];
           $state = $the_list[$cnt]['state'];
           $zip = $the_list[$cnt]['zip'];
           $latitude = $the_list[$cnt]['latitude'];
           $longitude = $the_list[$cnt]['longitude'];
           $fb_event_id = $the_list[$cnt]['fb_event_id'];
           $event_url = $the_list[$cnt]['event_url'];
           $location = $the_list[$cnt]['location'];

           $value = $the_list[$cnt]['value'];
           $positivity = $the_list[$cnt]['positivity'];
           $probability = $the_list[$cnt]['probability'];
           $group_type_id = $the_list[$cnt]['group_type_id'];
           $value_type_id = $the_list[$cnt]['value_type_id'];
           $purpose_id = $the_list[$cnt]['purpose_id'];
           $emotion_id = $the_list[$cnt]['emotion_id'];
           $ethics_id = $the_list[$cnt]['ethics_id'];
           $sibaseunit_id = $the_list[$cnt]['sibaseunit_id'];
           $external_source_id = $the_list[$cnt]['external_source_id'];
           $source_object_id = $the_list[$cnt]['source_object_id'];
           $source_object_item_id = $the_list[$cnt]['source_object_item_id'];
           $object_id = $the_list[$cnt]['object_id'];
           $external_url = $the_list[$cnt]['external_url'];
           $event_type = $the_list[$cnt]['event_type'];
           $rsvp_status = $the_list[$cnt]['rsvp_status'];
           $serial_number = $the_list[$cnt]['serial_number'];
           $news_category_id = $the_list[$cnt]['news_category_id'];

           $cmv_politicalparties_id_c = $the_list[$cnt]['cmv_politicalparties_id_c'];
           $cmv_politicalpartyroles_id_c = $the_list[$cnt]['cmv_politicalpartyroles_id_c'];

           $cmv_governments_id_c = $the_list[$cnt]['cmv_governments_id_c'];
           $cmv_governmentroles_id_c = $the_list[$cnt]['cmv_governmentroles_id_c'];
           $cmv_governmentpolicies_id_c = $the_list[$cnt]['cmv_governmentpolicies_id_c'];
           $cmv_governmentconstitutions_id_c = $the_list[$cnt]['cmv_governmentconstitutions_id_c'];

           $cmv_departmentagencies_id_c = $the_list[$cnt]['cmv_departmentagencies_id_c'];

           $cmv_branchbodies_id_c = $the_list[$cnt]['cmv_branchbodies_id_c'];
           $cmv_branchdepartments_id_c = $the_list[$cnt]['cmv_branchdepartments_id_c'];

           $cmv_causes_id_c = $the_list[$cnt]['cmv_causes_id_c'];

           $cmv_independentagencies_id_c = $the_list[$cnt]['cmv_independentagencies_id_c'];
           $cmv_organisations_id_c = $the_list[$cnt]['cmv_organisations_id_c'];

           $cmv_constitutionalarticles_id_c = $the_list[$cnt]['cmv_constitutionalarticles_id_c'];
           $cmv_constitutionalamendments_id_c = $the_list[$cnt]['cmv_constitutionalamendments_id_c'];

           $browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 1);

           // Language
           $language = 'language_'.$lingo;
           if (!empty($cmn_languages_id_c)) {
              #$language = dlookup("cmn_languages", "$language", "id='".$cmn_languages_id_c."'");
              $language = dlookup("cmn_languages", "name", "id='".$cmn_languages_id_c."'");
              } else {
              $browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 1);
              #$language = dlookup("cmn_languages", "$language", "ext='".$browser_lingo."'");        
              #$language = dlookup("cmn_languages", "name", "ext='".$browser_lingo."'");        
              }

           if ($cmv_independentagencies_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('BranchBodyIndependentAgencies',$cmv_independentagencies_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "BranchBodyIndependentAgencies";
//              $val = $cmv_independentagencies_id_c;
              }

           if ($cmv_branchdepartments_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('BranchBodyDepartments',$cmv_branchdepartments_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "BranchBodyDepartments";
//              $val = $cmv_branchdepartments_id_c;
              }

           if ($cmv_politicalparties_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('PoliticalParties',$cmv_politicalparties_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "PoliticalParties";
//              $val = $cmv_politicalparties_id_c;
              }

           if ($cmv_politicalpartyroles_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('PoliticalPartyRoles',$cmv_politicalpartyroles_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "PoliticalPartyRoles";
//              $val = $cmv_politicalpartyroles_id_c;
              }

           if ($cmv_governmentroles_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('GovernmentRoles',$cmv_governmentroles_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "GovernmentRoles";
//              $val = $cmv_governmentroles_id_c;
              }

           if ($cmv_governments_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('Governments',$cmv_governments_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "Governments";
//              $val = $cmv_governments_id_c;
              }

           if ($cmv_departmentagencies_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('DepartmentAgencies',$cmv_departmentagencies_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "DepartmentAgencies";
//              $val = $cmv_departmentagencies_id_c;
              }

           if ($cmv_causes_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('Causes',$cmv_causes_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "Causes";
//              $val = $cmv_causes_id_c;
              }

           if ($cmv_governmentpolicies_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('GovernmentPolicies',$cmv_governmentpolicies_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "GovernmentPolicies";
//              $val = $cmv_governmentpolicies_id_c;
              }

           if ($cmv_governmentconstitutions_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('GovernmentConstitutions',$cmv_governmentconstitutions_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "GovernmentConstitutions";
//              $val = $cmv_governmentconstitutions_id_c;
              }

           if ($cmv_constitutionalarticles_id_c != NULL){
              $comment_object_returner = $funky_gear->object_returner ('ConstitutionArticles',$cmv_constitutionalarticles_id_c);
              $object_return_target .= $comment_object_returner[3]." + ";
//              $valtype = "ConstitutionArticles";
//              $val = $cmv_constitutionalarticles_id_c;
              }

           if ($cmn_countries_id_c != NULL && $valtype == NULL){
//              $valtype = "Countries";
//              $val = $cmv_countries_id_c;
              }

           if ($cmn_countries_id_c) {
              $country = $funky_gear->makecountry ($cmn_countries_id_c,$portalcode,$BodyDIV,$lingo);
              $object_return_target .= $country." + ";
              }

           $pic = "";
       
           if ($pic){
              $pic = "<img src=$pic>";
              } else {
              $pic = "<img src=images/cal.gif>";
              }
       
           if ($fb_event_id){
              $fb_event = " - <a href=\"http://www.facebook.com/event.php?eid=".$fb_event_id."&index=1\" target=\"Facebook\"><B> Also on Facebook! :)</B></a>";
              } else {
              $fb_event = "";
              }
       
           // Check Admin for Edit
           if ($sess_contact_id == $contact_id_c && $sess_contact_id != NULL){
     
              $editevent = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$do."');return false\"><font color=#151B54><B>(".$strings["action_edit"].")</B></font></a>";
     
              } else {// end if admin

              $editevent = "";
     
              } 

           // View
           list ($event_date_start,$event_start_time) = explode (" ", $date_start);
           list ($event_date_end,$event_end_time) = explode (" ", $date_end);

           $this_event = $pic." ".$fb_event."<BR>
<B>".$strings["Event"].":</B> <a href=\"#Events\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><font=#151B54>".$name."</font></a> ".$editevent."<BR>
<B>".$strings["Location"].":</B> ".$location."<BR>
<B>".$strings["Country"].":</B> ".$country."<BR>
<B>".$strings["Language"].":</B> ".$language."<BR>
<B>".$strings["DateStart"].":</B> ".$event_date_start." - <B>".$strings["TimeStart"].": </B> ".$event_start_time."<BR>
<B>".$strings["DateEnd"].":</B> ".$event_date_end." - <B>".$strings["TimeEnd"].": </B> ".$event_end_time."<BR>";

/*
Dont show all for listings
<B>Owner:</B> ".$event_owner."<BR>
<B>Tagline:</B> ".$event_tagline."<BR>
<B>Description:</B> ".$event_description."<BR>
<B>Type:</B> ".$event_type."<BR>
<B>Sub Type:</B> ".$event_subtype."<BR>

      if ($venue_street){
      $this_event = "<B>Venue Street:</B> ".$venue_street."<BR>
<B>Venue City:</B> ".$venue_city."<BR>
<B>Venue State:</B> ".$venue_state."<BR>
<B>Venue Zip :</B> ".$venue_zip ."<BR>
<B>Venue Country:</B> ".$venue_country."<BR>
<B>Venue Latitude:</B> ".$venue_latitude."<BR>
<B>Venue Longitude:</B> ".$venue_longitude."<BR>";
       }
*/

           $events .= "<div style=\"".$divstyle_white."\">".$this_event."<P>".$object_return_target."</div>";
      
           } // end for
      
       } else { // end if array

         $events = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }  
    
//    if ($sess_contact_id != NULL && $valtype != NULL && $valtype != 'Search'){
    if ($sess_contact_id != NULL && $valtype != 'Search'){
     
       $addevent = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$portalcode."&do=Events&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
     
       } else {
      
       $addevent = "<P><div style=\"".$divstyle_orange_light."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }

    if ($valtype == 'Search'){
       $addevent = "";
       }
     
       ################################
       # Start Search

       echo $this->funkydone ($_POST,$lingo,'Search','create_form_basic',$val,'Events',$bodywidth);

       # End Search
       ################################

       echo $navi;

    if (count($the_list)>10){
       echo $addevent."<P>".$events."".$addevent;
       } else {
       echo $events."<P>".$addevent;
       }
   
       echo $navi;

    # End List Events
    ################################

   break; // end List events
 
   case 'add': 
   case 'edit':
   case 'view':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    if ($action == 'view' || $action == 'edit'){

       $object_type = "Events";
       $event_action = "select";    

       $event_params[0] = "id='".$val."' ";
       $event_params[1] = "";
       $event_params[2] = "";
       $event_params[3] = "";
       $event_params[4] = "";

       $the_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $event_action, $event_params);
           
       if (is_array($the_list)){

          for ($cnt=0;$cnt < count($the_list);$cnt++){

              $id = $the_list[$cnt]['id'];
              $name = $the_list[$cnt]['name'];
              $date_entered = $the_list[$cnt]['date_entered'];
              $date_modified = $the_list[$cnt]['date_modified'];
              $modified_user_id = $the_list[$cnt]['modified_user_id'];
              $created_by = $the_list[$cnt]['created_by'];
              $description = $the_list[$cnt]['description'];
              $assigned_user_id = $the_list[$cnt]['assigned_user_id'];

              $account_id_c = $the_list[$cnt]['account_id_c'];
              $contact_id_c = $the_list[$cnt]['contact_id_c'];

              $cmn_statuses_id_c = $the_list[$cnt]['cmn_statuses_id_c'];
              $cmn_languages_id_c = $the_list[$cnt]['cmn_languages_id_c'];
              $cmn_countries_id_c = $the_list[$cnt]['cmn_countries_id_c'];
              $cmn_currencies_id_c = $the_list[$cnt]['cmn_currencies_id_c'];

              $view_count = $the_list[$cnt]['view_count'];
              $time_frame_id = $the_list[$cnt]['time_frame_id'];
              $sclm_events_id_c = $the_list[$cnt]['sclm_events_id_c'];
              $date_start = $the_list[$cnt]['start_date'];
              $date_end = $the_list[$cnt]['end_date'];

              $object_type_id = $the_list[$cnt]['object_type_id'];
              $object_value = $the_list[$cnt]['object_value'];

              $street = $the_list[$cnt]['street'];
              $city = $the_list[$cnt]['city'];
              $state = $the_list[$cnt]['state'];
              $zip = $the_list[$cnt]['zip'];
              $latitude = $the_list[$cnt]['latitude'];
              $longitude = $the_list[$cnt]['longitude'];
              $fb_event_id = $the_list[$cnt]['fb_event_id'];
              $event_url = $the_list[$cnt]['event_url'];
              $location = $the_list[$cnt]['location'];

              $value = $the_list[$cnt]['value'];
              $positivity = $the_list[$cnt]['positivity'];
              $probability = $the_list[$cnt]['probability'];
              $group_type_id = $the_list[$cnt]['group_type_id'];
              $value_type_id = $the_list[$cnt]['value_type_id'];
              $purpose_id = $the_list[$cnt]['purpose_id'];
              $emotion_id = $the_list[$cnt]['emotion_id'];
              $ethics_id = $the_list[$cnt]['ethics_id'];
              $sibaseunit_id = $the_list[$cnt]['sibaseunit_id'];
              $external_source_id = $the_list[$cnt]['external_source_id'];
              $source_object_id = $the_list[$cnt]['source_object_id'];
              $source_object_item_id = $the_list[$cnt]['source_object_item_id'];
              $object_id = $the_list[$cnt]['object_id'];
              $external_url = $the_list[$cnt]['external_url'];
              $event_type = $the_list[$cnt]['event_type'];
              $rsvp_status = $the_list[$cnt]['rsvp_status'];
              $serial_number = $the_list[$cnt]['serial_number'];
              $news_category_id = $the_list[$cnt]['news_category_id'];

              $cmv_politicalparties_id_c = $the_list[$cnt]['cmv_politicalparties_id_c'];
              $cmv_politicalpartyroles_id_c = $the_list[$cnt]['cmv_politicalpartyroles_id_c'];

              $cmv_governments_id_c = $the_list[$cnt]['cmv_governments_id_c'];
              $cmv_governmentroles_id_c = $the_list[$cnt]['cmv_governmentroles_id_c'];
              $cmv_governmentpolicies_id_c = $the_list[$cnt]['cmv_governmentpolicies_id_c'];
              $cmv_governmentconstitutions_id_c = $the_list[$cnt]['cmv_governmentconstitutions_id_c'];

              $cmv_departmentagencies_id_c = $the_list[$cnt]['cmv_departmentagencies_id_c'];

              $cmv_branchbodies_id_c = $the_list[$cnt]['cmv_branchbodies_id_c'];
              $cmv_branchdepartments_id_c = $the_list[$cnt]['cmv_branchdepartments_id_c'];

              $cmv_causes_id_c = $the_list[$cnt]['cmv_causes_id_c'];

              $cmv_independentagencies_id_c = $the_list[$cnt]['cmv_independentagencies_id_c'];
              $cmv_organisations_id_c = $the_list[$cnt]['cmv_organisations_id_c'];

              $cmv_constitutionalarticles_id_c = $the_list[$cnt]['cmv_constitutionalarticles_id_c'];
              $cmv_constitutionalamendments_id_c = $the_list[$cnt]['cmv_constitutionalamendments_id_c'];

              $view_count = $the_list[$cnt]['view_count'];
              $new_viewcount = $view_count+1;
      
              } // end for

           } // end if array

       } // if add/edit

    $tblcnt = 0; // first set

    // If logged into FB - get Events
    if ($fbme && $action == 'edit') {
  
       $fbevents = $facebook->api('/me/events');
         
       $event = array();  

       if (is_array($fbevents['data']) && count($fbevents['data'])) {  
     
          $tablefields[$tblcnt][0] = 'fb_event_id'; // Field Name
          $tablefields[$tblcnt][1] = "Facebook ".$strings["Event"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list';//$dropdown_table; // related table
     
          $dd_pack[NULL] = $strings["action_select_fb"];
         
          foreach ($fbevents['data'] as $event) {

                  $dd_name = "";
                  $eid = $event['id'];
                  //$pic = $event['pic_small'];
                  //$event_owner = $event['owner'];
                  $event_name = $event['name'];
                  //$event_tagline = $event['tagline'];
                  //$event_description = $event['description'];
                  //$event_type = $event['event_type'];
                  //$event_subtype = $event['event_subtype'];
                  //$event_location = $event['location'];
                  $event_date_start = $event['start_time'];
                  $event_date_end = $event['end_time'];
                  $event_rsvp_status = $event['rsvp_status'];
     
                  //2011-04-15T09:00:00
                  list ($event_date_start,$event_start_time) = explode ("T", $event_date_start);
                  list ($event_date_end,$event_end_time) = explode ("T", $event_date_end);
      
                  $dd_name = $event_name." - ".$event_rsvp_status." - Start: ".$event_date_start." - End: ".$event_date_end;
                  //echo "EID:".$eid." ".$dd_name."<BR>";
                  $dd_pack[$eid] = $dd_name;
         
                  }
      
          $tablefields[$tblcnt][9][1] = $dd_pack;  // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'fb_event_id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $fb_event_id; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = 'fb_event_id'; // Field ID
          $tablefields[$tblcnt][20] = '';//$field_value_id;
          $tablefields[$tblcnt][21] = $fb_event_id; //$field_value;
 
          $tblcnt++;

          } else {
     
          $tablefields[$tblcnt][0] = 'create_fb_event'; // Field Name
          $tablefields[$tblcnt][1] = "Facebook ".$strings["Event"]." ".$strings["action_create"]."?"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = '1'; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $fb_event_id; // Field ID
          $tablefields[$tblcnt][20] = 'create_fb_event';//$field_value_id;
          $tablefields[$tblcnt][21] = $fb_event_id; //$field_value;  
      
          $tblcnt++;

          } // end if no fb events
     
       } else {
     
       if ($fb_event_id != NULL){

          $tablefields[$tblcnt][0] = 'nofb'; // Field Name
          $tablefields[$tblcnt][1] = "Facebook"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = 'You are not logged into Facebook'; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $fb_event_id; // Field ID
          $tablefields[$tblcnt][20] = 'nofb';//$field_value_id;
          $tablefields[$tblcnt][21] = $fb_event_id; //$field_value; 
      
          $tblcnt++;

          }
 
       } // end if not logged into FB

    if ($fb_event_id != NULL && $action == 'view') {
              
       $tablefields[$tblcnt][0] = 'fb_event_id'; // Field Name
       $tablefields[$tblcnt][1] = "Facebook ".$strings["Event"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'external_link';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = "http://www.facebook.com/event.php?eid=".$fb_event_id."&index=1"; //$dropdown_table; related table, external link
       $tablefields[$tblcnt][9][1] = $event_name;  // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = "Facebook";
       $tablefields[$tblcnt][9][3] = '';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = ''; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = 'fb_event_id'; // Field ID
       $tablefields[$tblcnt][20] = '';//$field_value_id;
       $tablefields[$tblcnt][21] = $fb_event_id; //$field_value;

       $tblcnt++;
              
       } // end if fb
       
    if ($action == 'edit' || $action == 'view'){

       $tablefields[$tblcnt][0] = "id"; // Field Name
       $tablefields[$tblcnt][1] = $strings["ID"]; // Full Name
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
       $tablefields[$tblcnt][20] = "id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;   

       $tblcnt++;

       } // if action
    
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

    if ($sclm_events_id_c != NULL){

       if ($action == 'view'){

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = "sclm_events_id_c"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Event"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_events'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = $sclm_events_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Events'; // Object
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = $sclm_events_id_c; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_events_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value; 

          } else {

          $tblcnt++;
    
          $tablefields[$tblcnt][0] = "sclm_events_id_c"; // Field Name
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
          $tablefields[$tblcnt][11] = $sclm_events_id_c; // Field ID
          $tablefields[$tblcnt][20] = "sclm_events_id_c"; //$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value;

          } 

       }

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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "valuetype"; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;

    $tblcnt++;

    if ($action == 'add'){

       # https://en.wikipedia.org/w/api.php
    
       $tablefields[$tblcnt][0] = "name"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Title"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'autocomplete';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $name; // Field ID
       $tablefields[$tblcnt][20] = "name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;      
      
　     } else {
    
       $tablefields[$tblcnt][0] = "name"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Title"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $name; // Field ID
       $tablefields[$tblcnt][20] = "name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;      
      
　     } 

    $tblcnt++;
    
    $date = $_POST['date'];

    if (!$start_date){
       if (!$date){
          $start_date = date("Y-m-d G:i:s");
          } else {
          $start_date = $date;
          } 
       }

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

    if (!$end_date){
       if (!$date){
          $end_date = date("Y-m-d G:i:s");
          } else {
          $end_date = $date;
          } 
       }
    
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
    
    if ($sess_contact_id == $contact_id_c && $sess_contact_id != NULL && $action == 'edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "related_objects"; // Field Name
       $tablefields[$tblcnt][1] = $strings["RelatedContent"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();
/*
       $dd_pack['Actions'] = 'Actions';
       $dd_pack['Effects'] = 'Effects';
       $dd_pack['News'] = 'News';
       $dd_pack['Causes'] = 'Causes';
       $dd_pack['Events'] = 'Events';
       $dd_pack['Content'] = 'Content';
       $dd_pack['Governments'] = 'Governments';
       $dd_pack['PoliticalParties'] = 'PoliticalParties';
       $dd_pack['PoliticalPartyPolicies'] = 'PoliticalPartyPolicies';
       $dd_pack['PoliticalPartyRoles'] = 'PoliticalPartyRoles';
*/

       $dd_pack['Events'] = 'Events';
       #$dd_pack['Causes'] = 'Causes';
       #$dd_pack['Governments'] = 'Governments';
       #$dd_pack['PoliticalParties'] = 'PoliticalParties';

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $related_objects; // Current Value
       $tablefields[$tblcnt][9][6] = ""; // Link
       $tablefields[$tblcnt][9][7] = "related_objects"; // reltable
       $tablefields[$tblcnt][9][8] = "Objects"; // New DO
       $tablefields[$tblcnt][9][9] = $val; //$core_object_value;
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $related_objects; // Field ID
       $tablefields[$tblcnt][20] = "related_objects"; //$field_value_id;
       $tablefields[$tblcnt][21] = $related_objects; //$field_value;      

       } 

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
    $tablefields[$tblcnt][9][3] = "name"; #'status_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = ''; // Object
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value; 

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
    $tablefields[$tblcnt][9][3] = "name"; #'language_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_languages_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = ''; // Object
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_languages_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_languages_id_c; //$field_value; 
    
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
    $tablefields[$tblcnt][12] = '20'; # length
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
    $tablefields[$tblcnt][12] = '20'; # length
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
    $tablefields[$tblcnt][12] = '60'; # length
    $tablefields[$tblcnt][20] = "event_url"; //$field_value_id;
    $tablefields[$tblcnt][21] = $event_url; //$field_value; 
    
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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][12] = '60'; # length
    $tablefields[$tblcnt][20] = "location"; //$field_value_id;
    $tablefields[$tblcnt][21] = $location; //$field_value; 

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
    $tablefields[$tblcnt][12] = '60'; # length
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
    $tablefields[$tblcnt][12] = '60'; # length
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
    $tablefields[$tblcnt][12] = '60'; # length
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
    $tablefields[$tblcnt][1] = "Venue Country"; // Full Name
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
    $tablefields[$tblcnt][9][3] = "name"; #'name_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_countries_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Countries'; // Object
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_countries_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_countries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_countries_id_c; //$field_value; 
  
/*  
    if ($cmv_actions_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_actions_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Action"];// Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_actions'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_actions_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Actions'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_actions_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_actions_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_actions_id_c; //$field_value;  
       
       }
*/
    if ($cmv_governments_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Government"];// Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governments'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governments_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Governments'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governments_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governments_id_c; //$field_value;  
       
       }

    if ($cmv_governmentroles_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentroles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentRole"];// Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentroles'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentroles_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentRoles'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governmentroles_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentroles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentroles_id_c; //$field_value;  
       
       }

    if ($cmv_politicalparties_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_politicalparties_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["PoliticalParty"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_politicalparties'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_politicalparties_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'PoliticalParties'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_politicalparties_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalparties_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_politicalparties_id_c; //$field_value;  
       
       }

    if ($cmv_politicalpartyroles_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_politicalpartyroles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["PoliticalPartyRole"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_politicalpartyroles'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_politicalpartyroles_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'PoliticalPartyRoles'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_politicalpartyroles_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalpartyroles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_politicalpartyroles_id_c; //$field_value;  
       
       }

    if ($cmv_governmentbranches_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentbranches_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Branch"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentbranches'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentbranches_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentBranches'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governmentbranches_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentbranches_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentbranches_id_c; //$field_value;  
       
       }

    if ($cmv_branchbodies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_branchbodies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["BranchBody"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_branchbodies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_branchbodies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentBranchBodies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_branchbodies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_branchbodies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_branchbodies_id_c; //$field_value;  
       
       }

    if ($cmv_branchdepartments_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_branchdepartments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Department"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_branchdepartments'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_branchdepartments_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'BranchDepartments'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_branchdepartments_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_branchdepartments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_branchdepartments_id_c; //$field_value;  
       
       }

    if ($cmv_independentagencies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_independentagencies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "Branch Body Independent Agencies"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_independentagencies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_independentagencies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'BranchBodyIndependentAgencies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_independentagencies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_independentagencies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_independentagencies_id_c; //$field_value;  
       
       }

    if ($cmv_departmentagencies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_departmentagencies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "Agency/Office/Bureau"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_departmentagencies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_departmentagencies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'DepartmentAgencies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_departmentagencies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_departmentagencies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_departmentagencies_id_c; //$field_value;  
       
       }


    if ($cmv_governmentpolicies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentpolicies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentPolicy"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentpolicies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentpolicies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentPolicies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_governmentpolicies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentpolicies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentpolicies_id_c; //$field_value;  
       
       }

    if ($cmv_governmentconstitutions_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentconstitutions_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentConstitution"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentconstitutions'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentconstitutions_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentConstitutions'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_governmentconstitutions_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentconstitutions_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentconstitutions_id_c; //$field_value;  
       
       }

    if ($cmv_constitutionalarticles_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_constitutionalarticles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ConstitutionArticle"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_constitutionalarticles'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_constitutionalarticles_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConstitutionArticles'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_constitutionalarticles_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_constitutionalarticles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_constitutionalarticles_id_c; //$field_value;  
       
       }

    if ($cmv_causes_id_c != NULL){

//echo "Cause: ".$cmv_causes_id_c."<BR>";

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_causes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Causes"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_causes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_causes_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Causes'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_causes_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_causes_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_causes_id_c; //$field_value;  
       
       }
      	
    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = "Description"; // Full Name
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
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;    

    if ($sess_contact_id == $contact_id_c && $sess_contact_id != NULL){

       $admin = 1;

       } else {
       $admin = "";
       } 

    if ($sess_contact_id){
       $addnew = 1;
       } else {
       $addnew = "";
       } 

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = $addnew; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    if ($action == 'view'){

       #$print_vote = $this->funkydone ($_POST,$lingo,'Votes','print_vote',$val,$do,$bodywidth);
       #echo $print_vote; 
       #echo "<BR><img src=images/blank.gif width=450 height=10><BR>";

       }

    #
    ################################
    #

    echo $object_return;

    if ($action == 'view' || $action == 'edit'){
       echo $event_map;
       echo "<BR><center><div id=\"map_canvas\" style=\"width: 0px; height: 0px\"></div></center><BR>";
       }

    echo $zaform;
               
    if ($action == 'view'){

       // Add View Count
       $action = "update";
       $params = array();  
       $params = array(
          array('name'=>'id','value' => $val),
          array('name'=>'view_count','value' => $new_viewcount),
         );

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);

    #
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
  
    if ($action == 'view' || $action == 'edit'){

       echo $container_top;

       echo $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);

       echo $container_bottom;

       }

    # End Content
    ################################  
    # Start Side Effects

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["SideEffects"]; // container_title
    $container_params[4] = 'SideEffects'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
  
    echo $container_top;
   
    echo $this->funkydone ($_POST,$lingo,'SideEffects','list',$val,$do,$bodywidth);

    echo $container_bottom;

    # End Side Effects
    ################################
    # Start News

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["News"]; // container_title
    $container_params[4] = 'News'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];  

    echo $container_top;
    
    echo $this->funkydone ($_POST,$lingo,'News','list',$val,$do,$bodywidth);

    echo $container_bottom;
    # End News
    ################################
    # Start Comments

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["Comments"]; // container_title
    $container_params[4] = 'Comments'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];  

    echo $container_top;
    
    echo $this->funkydone ($_POST,$lingo,'Comments','list',$val,$do,$bodywidth);

    echo $container_bottom;

    # End Comments
    ################################
    # Start Make Embedded Object Link

    $params = array();
    $params[0] = $event_name;
    echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);

    # End Make Embedded Object Link
    ################################

       } // end if view
          
   break; // end edit event
   case 'search':

   $keyword = $_POST['value'];
   $date = date("Y-m-d G:i:s");

   $this->funkydone ($_POST,$lingo,'Search','search_record',$keyword,'Events',$bodywidth);

   echo $this->funkydone ($_POST,$lingo,'Events','list',$keyword,'Search',$bodywidth);
   echo $this->funkydone ($_POST,$lingo,'Effects','list',$keyword,'Search',$bodywidth);

   break; // end search
   case 'process':
       
    //$sent_name = $funky_gear->cleantext ($sent_name,$do,$val);
    //$sent_description = $funky_gear->cleantext ($sent_description,$do,$val);

    if (!$sent_name){
     $error .= "<font color=red size=3>Name value can not be empty...</font><P>";
     }

    if (!$sent_description){
     $error .= "<font color=red size=3>Description value can not be empty...</font><P>";
     }
     
    if (!$sent_start_date){
     $error .= "<font color=red size=3>Start Date value can not be empty...</font><P>";
     }
     
    if (!$sent_end_date){
     $error .= "<font color=red size=3>End Date value can not be empty...</font><P>";
     }

    if (!$assigned_user_id){
     $assigned_user_id = 1;
     }
     
    if (!$error){
     
     $process_object_type = "Events";
     $process_action = "update";
     $process_params[] = array('name'=>'id','value' => $sent_id);
     $process_params[] = array('name'=>'name','value' => $sent_name);
     $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
     $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
     $process_params[] = array('name'=>'fb_event_id','value' => $sent_fb_event_id);
     $process_params[] = array('name'=>'object_type','value' => $valtype);
     $process_params[] = array('name'=>'object_value','value' => $val);
     $process_params[] = array('name'=>'location','value' => $sent_location);
     $process_params[] = array('name'=>'street','value' => $sent_venue_street);
     $process_params[] = array('name'=>'city','value' => $sent_venue_city);
     $process_params[] = array('name'=>'state','value' => $sent_venue_state);
     $process_params[] = array('name'=>'zip','value' => $sent_venue_zip);
     $process_params[] = array('name'=>'latitude','value' => $sent_venue_latitude);
     $process_params[] = array('name'=>'longitude','value' => $sent_venue_longitude);
     $process_params[] = array('name'=>'cmv_politicalparties_id_c','value' => $sent_cmv_politicalparties_id_c);
     $process_params[] = array('name'=>'cmv_politicalpartyroles_id_c','value' => $sent_cmv_politicalpartyroles_id_c);
     $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $sent_cmn_statuses_id_c);
     $process_params[] = array('name'=>'cmv_governments_id_c','value' => $sent_cmv_governments_id_c);
     $process_params[] = array('name'=>'cmv_governmentroles_id_c','value' => $sent_cmv_governmentroles_id_c);
     $process_params[] = array('name'=>'cmv_departmentagencies_id_c','value' => $sent_cmv_departmentagencies_id_c);
     $process_params[] = array('name'=>'cmv_branchdepartments_id_c','value' => $sent_cmv_branchdepartments_id_c);
     $process_params[] = array('name'=>'cmv_causes_id_c','value' => $sent_cmv_causes_id_c);
     $process_params[] = array('name'=>'cmv_governmentpolicies_id_c','value' => $sent_cmv_governmentpolicies_id_c);
     $process_params[] = array('name'=>'start_date','value' => $sent_start_date);
     $process_params[] = array('name'=>'end_date','value' => $sent_end_date);
     $process_params[] = array('name'=>'description','value' => $sent_description);
     $process_params[] = array('name'=>'cmn_languages_id_c','value' => $sent_cmn_languages_id_c);
     $process_params[] = array('name'=>'cmn_countries_id_c','value' => $sent_cmn_countries_id_c);
     $process_params[] = array('name'=>'cmv_independentagencies_id_c','value' => $sent_cmv_independentagencies_id_c);
     $process_params[] = array('name'=>'event_url','value' => $sent_event_url);
     $process_params[] = array('name'=>'cmv_governmentconstitutions_id_c','value' => $sent_cmv_governmentconstitutions_id_c);
     $process_params[] = array('name'=>'cmv_constitutionalarticles_id_c','value' => $sent_cmv_constitutionalarticles_id_c);

     if ($sent_sfx_actions_id_c){
        $process_params[] = array('name'=>'sclm_events_id_c','value' => $sclm_events_id_c);
        }

     $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($sent_id){
       $event_id = $sent_id;
       } else {
       $event_id = $result['id'];
       } 
  
     if ($sent_fb_event_id){
     
      echo "<BR>Facebook event has been related - ID: ".$fb_event_id ."<BR>";
     
      } else {
      
      if ($sent_create_fb_event){
      
       echo "<BR>Facebook event will be created/updated<BR>";
     
       } // end if create FB
      
      } // end if no fb related
      
       $process_message = "Your Event Submission was a success! Please review here <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$portalcode."&do=".$do."&action=view&value=".$event_id."&valuetype=".$do."');return false\">here!</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$sent_name."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$sent_description."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

    
     } else { // end if no error
    
       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";
   
     } // end if error
     
//     echo  "<a href=\"#\" onClick=\"loader('".$BodyDIV."');makePOSTRequest('".$BodyDIV."','Body.php', 'rp=".$portalcode."&do=Dashboard&action=&value=&valuetype=id&return_do=Events&action=');return false\"><font=#151B54><B>".$strings["DashboardReturn"]."</B></font></a><P>";
    
   break; // end process

  } // end actions

# break; // End Events
##########################################################
?>