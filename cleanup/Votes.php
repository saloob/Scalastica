<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Votes 
##########################################################
# case 'Votes':
 
  switch ($action){
   
   ###########################
   case 'edit':
   
    ################################
    # Start Vote Edit

    $object_type = "Votes";
    $action = "select";
    $params = array();
    $params[0] = "deleted=0 && id='".$val."'";
    $params[1] = "";

    $the_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    $tblcnt = 0;

    for ($cnt=0;$cnt < count($the_rows);$cnt++){

//        $id = $the_rows[$cnt]['id'];
        $name = $the_rows[$cnt]['name'];
        $date_entered = $the_rows[$cnt]['date_entered'];
        $date_modified = $the_rows[$cnt]['date_modified'];
        $modified_user_id = $the_rows[$cnt]['modified_user_id'];
        $created_by = $the_rows[$cnt]['created_by'];
        $description = $the_rows[$cnt]['description'];
        $deleted = $the_rows[$cnt]['deleted'];        
        $assigned_user_id = $the_rows[$cnt]['assigned_user_id'];
        $ip_address = $the_rows[$cnt]['ip_address'];
        $contact_id_c = $the_rows[$cnt]['contact_id_c'];
        $vote = $the_rows[$cnt]['vote'];
        $contact_id1_c = $the_rows[$cnt]['contact_id1_c']; // Incumbant contact
        $cmv_comments_id_c = $the_rows[$cnt]['cmv_comments_id_c'];
        $cmv_governments_id_c = $the_rows[$cnt]['cmv_governments_id_c'];
        $cmv_governmentpolicies_id_c = $the_rows[$cnt]['cmv_governmentpolicies_id_c'];
        $cmv_constitutionalarticles_id_c = $the_rows[$cnt]['cmv_constitutionalarticles_id_c'];
        $cmv_politicalparties_id_c = $the_rows[$cnt]['cmv_politicalparties_id_c'];
        $cmv_governmenttypes_id_c = $the_rows[$cnt]['cmv_governmenttypes_id_c'];
        $cmv_constitutionalamendments_id_c = $the_rows[$cnt]['cmv_constitutionalamendments_id_c'];
        $contact_id2_c = $the_rows[$cnt]['contact_id2_c'];
        $cmv_politicalpartyroles_id_c = $the_rows[$cnt]['cmv_politicalpartyroles_id_c'];
        $cmv_governmentroles_id_c = $the_rows[$cnt]['cmv_governmentroles_id_c'];
        $cmv_countries_id_c = $the_rows[$cnt]['cmv_countries_id_c']; 
        $cmv_governmentconstitutions_id_c = $the_rows[$cnt]['cmv_governmentconstitutions_id_c']; 
        $cmv_nominees_id_c = $the_rows[$cnt]['cmv_nominees_id_c']; 
        $sfx_effects_id_c = $the_rows[$cnt]['sfx_effects_id_c']; 
        $sfx_actions_id_c = $the_rows[$cnt]['sfx_actions_id_c']; 
        $cmv_causes_id_c = $the_rows[$cnt]['cmv_causes_id_c']; 
        $cmv_content_id_c = $the_rows[$cnt]['cmv_content_id_c']; 
        $cmv_countries_id1_c = $the_rows[$cnt]['cmv_countries_id1_c']; 
        $account_id_c = $the_rows[$cnt]['account_id_c'];
        $cmv_events_id_c = $the_rows[$cnt]['cmv_events_id_c'];

        if ($cmv_content_id_c != NULL){
           $returnvaltype = "Content";
           $returnval = $cmv_content_id_c;
           }

        if ($cmv_causes_id_c != NULL){
           $returnvaltype = "Causes";
           $returnval = $cmv_causes_id_c;
           }

        if ($cmv_constitutionalarticles_id_c != NULL){
           $returnvaltype = "ConstitutionArticles";
           $returnval = $cmv_constitutionalarticles_id_c;
           }

        if ($cmv_constitutionalamendments_id_c != NULL){
           $returnvaltype = "ConstitutionAmendments";
           $returnval = $cmv_constitutionalamendments_id_c;
           }

        if ($cmv_comments_id_c != NULL){
           $returnvaltype = "Comments";
           $returnval = $cmv_comments_id_c;
           }

        if ($contact_id1_c != NULL){
           $returnvaltype = "Contacts";
           $returnval = $contact_id1_c;
           }

        if ($cmv_countries_id1_c != NULL){
           $returnvaltype = "Countries";
           $returnval = $cmv_countries_id1_c;
           }

        if ($cmv_events_id_c != NULL){
           $returnvaltype = "Events";
           $returnval = $cmv_events_id_c;
           }

        if ($cmv_governments_id_c != NULL){
           $returnvaltype = "Governments";
           $returnval = $cmv_governments_id_c;
           }

        if ($cmv_governmentconstitutions_id_c != NULL){
           $returnvaltype = "GovernmentConstitutions";
           $returnval = $cmv_governmentconstitutions_id_c;
           }

        if ($cmv_governmentpolicies_id_c != NULL){
           $returnvaltype = "GovernmentPolicies";
           $returnval = $cmv_governmentpolicies_id_c;
           }

        if ($cmv_governmentroles_id_c != NULL){
           $returnvaltype = "GovernmentRoles";
           $returnval = $cmv_governmentroles_id_c;
           }

        if ($cmv_governmenttypes_id_c != NULL){
           $returnvaltype = "GovernmentTypes";
           $returnval = $cmv_governmenttypes_id_c;
           }

        if ($cmv_politicalparties_id_c != NULL){
           $returnvaltype = "PoliticalParties";
           $returnval = $cmv_politicalparties_id_c;
           }

        if ($cmv_politicalpartyroles_id_c != NULL){
           $returnvaltype = "PoliticalPartyRoles";
           $returnval = $cmv_politicalpartyroles_id_c;
           }

        if ($sfx_actions_id_c != NULL){
           $returnvaltype = "Actions";
           $returnval = $sfx_actions_id_c;
           }

        if ($sfx_effects_id_c != NULL){
           $returnvaltype = "Effects";
           $returnval = $sfx_effects_id_c;
           }

        if ($account_id_c != NULL){
           $returnvaltype = "Accounts";
           $returnval = $account_id_c;
           }


        $tablefields[$tblcnt][0] = 'id'; // Field Name
        $tablefields[$tblcnt][1] = "ID"; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '0';//1; // show in view 
        $tablefields[$tblcnt][11] = $val; // Field ID
        $tablefields[$tblcnt][20] = 'id';//$field_value_id;
        $tablefields[$tblcnt][21] = $val; //$field_value;  
     
        $tblcnt++;

        $tablefields[$tblcnt][0] = 'value'; // Field Name
        $tablefields[$tblcnt][1] = ""; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '';//1; // show in view 
        $tablefields[$tblcnt][11] = $val; // Field ID
        $tablefields[$tblcnt][20] = 'value';//$field_value_id;
        $tablefields[$tblcnt][21] = $val; //$field_value; 

        $tblcnt++;

        $tablefields[$tblcnt][0] = 'valuetype'; // Field Name
        $tablefields[$tblcnt][1] = ""; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '';//1; // show in view 
        $tablefields[$tblcnt][11] = $returnvaltype; // Field ID
        $tablefields[$tblcnt][20] = 'valuetype';//$field_value_id;
        $tablefields[$tblcnt][21] = $returnvaltype; //$field_value; 

        $tblcnt++;

        $tablefields[$tblcnt][0] = 'name'; // Field Name
        $tablefields[$tblcnt][1] = $strings["Name"]; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = $name; // Field ID
        $tablefields[$tblcnt][20] = 'name';//$field_value_id;
        $tablefields[$tblcnt][21] = $name; //$field_value;  

        $tblcnt++;

        $tablefields[$tblcnt][0] = 'vote'; // Field Name
        $tablefields[$tblcnt][1] = $strings["Vote"]; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '1'; // length
        $tablefields[$tblcnt][7] = ''; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
        $tablefields[$tblcnt][9][1] = $funky_gear->makepositivity ();
        $tablefields[$tblcnt][9][2] = 'vote';
        $tablefields[$tblcnt][9][3] = $strings["Vote"];
        $tablefields[$tblcnt][9][4] = ''; // Exceptions
        $tablefields[$tblcnt][9][5] = $vote; // Current Value
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = $vote; // Field ID
        $tablefields[$tblcnt][20] = 'vote';//$field_value_id;
        $tablefields[$tblcnt][21] = $vote; //$field_value;  

        $tblcnt++;

        $tablefields[$tblcnt][0] = 'description'; // Field Name
        $tablefields[$tblcnt][1] = $strings["Description"]; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = $description; // Field ID
        $tablefields[$tblcnt][20] = 'description';//$field_value_id;
        $tablefields[$tblcnt][21] = $description; //$field_value; 

        $valpack = "";
        $valpack[0] = 'Votes';
        $valpack[1] = 'edit'; 
        $valpack[2] = $valtype;
        $valpack[3] = $tablefields;
        $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)

        // Build parent layer
        $zaform = "";
        $zaform = $funky_gear->form_presentation($valpack);

        $country = $funky_gear->makecountry ($cmv_countries_id_c,$realpolitikacode,$BodyDIV,$lingo);

        } // end for

//    echo "<P>Return Valtype: ".$returnvaltype." VAL - $returnval<P>";

    $returner = $funky_gear->object_returner ($returnvaltype, $returnval);
    $object_return_name = $returner[0];
    $object_return = $returner[1];
     
    echo $object_return;

    echo "<div style=\"".$divstyle_white."\">";
    echo "<P>".$strings["message_vote_edit"]."<P>";
    echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Votes&action=view_all&value=".$returnval."&valuetype=".$returnvaltype."');return false\"><font size=3 color=#151B54><B>".$strings["action_click_here_to_view_full_votes"]."</B></font></a></center><P>";
    echo "<font color=#FBB117 size=3><B>".$strings["Country"].":</B></font> ".$country."<BR>";
    echo "<font color=#FBB117 size=3><B>".$strings["Vote"].":</B></font><font=#151B54><B> ".$vote."</B></font><BR>";
 
    $present_description = str_replace("\n", "<br>", $description);
    echo "<font color=#FBB117 size=3><B>".$strings["Description"].":</font></B><font color=#151B54 size=2>  ".$present_description."</font><P>";
    echo "</div>";

    echo "<BR><img src=images/blank.gif width=550 height=15><BR>";

    echo $zaform;

   break; // end edit
   ###########################
   case 'process':

    echo $object_return;
    echo "<img src=images/blank.gif width=550 height=10><BR>";

    $error = "";
    
    if ($sent_name == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Name"]."</B></font><BR>";
       }

    if ($sent_description == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Description"]."</B></font><BR>";
       }

    if ($sent_vote == NULL){
       $error .= "<font color=red><B>".$strings["SubmissionErrorEmptyItem"].$strings["Vote"]."</B></font><BR>";
       }

    if (!$error){

       $object_type = "Votes";
       $action = "update";
       $params = array();
       $params = array(
        array('name'=>'id','value' => $sent_id),
        array('name'=>'name','value' => $sent_name),
        array('name'=>'description','value' => $sent_description),
        array('name'=>'vote','value' => $sent_vote),
        ); 

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);

       $process_message = "Vote Update Submission was a success! Please look at the votes <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Votes&action=edit&value=".$sent_id."&valuetype=Votes');return false\">here!</a><P>";

       $process_message .= "<B>".$strings["Vote"].":</B> ".$sent_vote."<BR>";
       $process_message .= "<B>".$strings["Name"].":</B> ".$sent_name."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$sent_description."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";

       } else {// no error

       echo "<div style=\"".$divstyle_organge."\">".$error."</div>";

       }  

   break; // end process
   ###########################
   case 'list':

/*   
    function id_to_check ($check_pack,$object,$id_to_check){

     $counter = 0;

     for ($chkcnt=0;$chkcnt < count($check_pack);$chkcnt++){

         $this_id = $check_pack[$chkcnt][$object];

         if ($id_to_check == $this_id){

            $counter++;

            } 

         } // end forloop

     return $counter;

     }

*/
/*
function multidimensional_search($parents, $searched) { 
  if (empty($searched) || empty($parents)) { 
    return false; 
  } 
  
  foreach ($parents as $key => $value) { 
    $exists = true; 
    foreach ($searched as $skey => $svalue) { 
      $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue); 
    } 
    if($exists){ return $key; } 
  } 
  
  return false; 
} 
*/

    $object_type = "Votes";
    $action = "select";
    $votes_params = array();

    switch ($portal_config['portalconfig']['glb_domain']){

     case 'realpolitika.org':

      $votes_params[0] = "deleted=0 && cmv_statuses_id_c != '".$standard_statuses_closed."' && sfx_effects_id_c IS NULL && sfx_actions_id_c IS NULL ";
      $votes_params[1] = "";
//    $params[1] = "contact_id_c,contact_id1_c,cmv_governments_id_c,cmv_governmenttypes_id_c,cmv_politicalparties_id_c,cmv_countries_id_c,cmv_countries_id1_c,cmv_causes_id_c";
      $votes_params[2] = "";
//    $params[2] = "cmv_governments_id_c,cmv_governmenttypes_id_c,cmv_politicalparties_id_c,cmv_countries_id1_c,cmv_causes_id_c,contact_id1_c";
      $votes_params[3] = "date_entered DESC";
      $votes_params[4] = "";
      $params[4] = "30";

     break;
     case 'sharedeffects.com':

      $votes_params[0] = "deleted=0 && cmv_statuses_id_c != '".$standard_statuses_closed."' && (sfx_effects_id_c != NULL || sfx_actions_id_c != NULL) ";
      $votes_params[1] = "";
//    $params[1] = "contact_id_c,contact_id1_c,cmv_governments_id_c,cmv_governmenttypes_id_c,cmv_politicalparties_id_c,cmv_countries_id_c,cmv_countries_id1_c,cmv_causes_id_c";
      $votes_params[2] = "";
//    $params[2] = "cmv_governments_id_c,cmv_governmenttypes_id_c,cmv_politicalparties_id_c,cmv_countries_id1_c,cmv_causes_id_c,contact_id1_c";
      $votes_params[3] = "date_entered DESC";
      $votes_params[4] = "";
      $params[4] = "30";

     break;

    } // end portal switch



function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }

    arsort($sorter);

    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}

function vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt){

  global $BodyDIV,$realpolitikacode,$funky_gear;

  $exists = $funky_gear->multidimensional_search($vote_pack, array('object'=>$vote_object,'id'=>$vote_object_id));

  if (!$exists){

     $vote_object_returner = $funky_gear->object_returner ($vote_object, $vote_object_id);
     $vote_object_name = $vote_object_returner[0];
     $vote_object_name = substr($vote_object_name, 0, 24);

     $vote_count = $funky_gear->id_to_check ($VoteList,$object_field,$vote_object_id);
     $vote_pack[$vcnt]['id'] = $vote_object_id;
     $vote_pack[$vcnt]['object'] = $vote_object;
     $vote_pack[$vcnt]['link'] = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=".$vote_object."&action=view&value=".$vote_object_id."&valuetype=".$vote_object."');return false\"><font color=#FBB117><B>".$vote_object_name."</B></font></a>";
     $vote_pack[$vcnt]['cnt'] = $vote_count;

     }

  return $vote_pack;

}

    $VoteList = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $votes_params);
    
    if (is_array($VoteList)){

       $vote_objects = array();
       $country_votes_total = array();

       $vote_pack = array();

       $vcnt = 0;

       for ($cnt=0;$cnt < count($VoteList);$cnt++){

           $id = $VoteList[$cnt]['id'];
           $vote_object_id = "";
           $exists = FALSE;

           ################################

        if ($portal_config['portalconfig']['glb_domain'] == 'sharedeffects.com'){

           $object_field = 'sfx_actions_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Actions";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              }

           ################################

           $object_field = 'sfx_effects_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Effects";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              }

           } // if sharedeffects

           ################################

        if ($portal_config['portalconfig']['glb_domain'] == 'realpolitika.org'){

           ################################

           $object_field = 'account_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Accounts";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_governments_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Governments";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_governmentconstitutions_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "GovernmentConstitutions";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_constitutionalarticles_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "ConstitutionalArticles";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_constitutionalamendments_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "ConstitutionalAmendments";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_governmenttypes_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "GovernmentTypes";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_news_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "News";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_events_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Events";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_content_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Content";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_politicalparties_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "PoliticalParties";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_governmentpolicies_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "GovernmentPolicies";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_causes_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Causes";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_comments_id_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Comments";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'cmv_countries_id1_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Countries";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           ################################

           $object_field = 'contact_id1_c';
           $vote_object_id = $VoteList[$cnt][$object_field];

           if ($vote_object_id != NULL){

              $vote_object = "Contacts";

              $vote_pack = vote_packer ($VoteList,$vote_pack,$vote_object,$object_field,$vote_object_id,$vcnt);

              } // if object

           } // if realpolitika

           ################################

           $vcnt++;

           } // end for

       // Present the results

       for ($vcnt=0;$vcnt < count($vote_pack);$vcnt++){

        if ($portal_config['portalconfig']['glb_domain'] == 'sharedeffects.com'){

           if ($vote_pack[$vcnt]['object'] == 'Actions'){
              $actions .= $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>";
              }

           if ($vote_pack[$vcnt]['object'] == 'Effects'){
              $effects .= $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>";
              }

           }


        if ($portal_config['portalconfig']['glb_domain'] == 'realpolitika.org'){

           if ($vote_pack[$vcnt]['object'] == 'Accounts'){
              $Accounts[] = array('type' => 'Accounts', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'Content'){
              $Content[] = array('type' => 'Content', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'Events'){
              $Events[] = array('type' => 'Events', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'News'){
              $News[] = array('type' => 'News', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'Contacts'){
              $Contacts[] = array('type' => 'Contacts', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'Causes'){
              $Causes[] = array('type' => 'Causes', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'Comments'){
              $Comments[] = array('type' => 'Comments', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'GovernmentConstitutions' || $vote_pack[$vcnt]['object'] == 'Constitutions'){
              $GovernmentConstitutions[] = array('type' => 'GovernmentConstitutions', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'ConstitutionArticles' || $vote_pack[$vcnt]['object'] == 'ConstitutionalArticles'){
              $ConstitutionalArticles[] = array('type' => 'ConstitutionalArticles', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'ConstitutionAmendments' || $vote_pack[$vcnt]['object'] == 'ConstitutionalAmendments'){
              $ConstitutionalAmendments[] = array('type' => 'ConstitutionalAmendments', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);

              }

           if ($vote_pack[$vcnt]['object'] == 'Governments'){
              $Governments[] = array('type' => 'Governments', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'GovernmentPolicies'){
              $GovernmentPolicies[] = array('type' => 'GovernmentPolicies', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'GovernmentTypes'){
              $GovernmentTypes[] = array('type' => 'GovernmentTypes', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'PoliticalParties'){
              $PoliticalParties[] = array('type' => 'PoliticalParties', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

           if ($vote_pack[$vcnt]['object'] == 'Countries'){
              $Countries[] = array('type' => 'Countries', 'link' => $vote_pack[$vcnt]['link']." [".$vote_pack[$vcnt]['cnt']."]<BR>", 'cnt' => $vote_pack[$vcnt]['cnt']);
              }

            } // end if rp

           } // end for

        if ($portal_config['portalconfig']['glb_domain'] == 'sharedeffects.com'){

           echo "<B>".$strings["Actions"]."</B><BR>".$actions."<P>"; 
           echo "<B>".$strings["Effects"]."</B><BR>".$effects."<P>"; 

           }

        if ($portal_config['portalconfig']['glb_domain'] == 'realpolitika.org'){

           if (is_array($Accounts)){
           aasort($Accounts,"cnt");
           echo "<BR><B>".$strings['Accounts']."</B><BR>"; 
           foreach ($Accounts as $key => $row) {
                   echo $Accounts[$key]['link'];
                   }
              }

           if (is_array($Contacts)){
           aasort($Contacts,"cnt");
           echo "<BR><B>".$strings['Members']."</B><BR>"; 
           foreach ($Contacts as $key => $row) {
                   echo $Contacts[$key]['link'];
                   }
              }

           if (is_array($News)){              
           aasort($News,"cnt");
           echo "<BR><B>".$strings['News']."</B><BR>"; 
           foreach ($News as $key => $row) {
                   echo $News[$key]['link'];
                   }
           }
           
           if (is_array($Events)){           
           aasort($Events,"cnt");
           echo "<BR><B>".$strings['Events']."</B><BR>"; 
           foreach ($Events as $key => $row) {
                   echo $Events[$key]['link'];
                   }
           }

           if (is_array($Content)){           
           aasort($Content,"cnt");
           echo "<BR><B>".$strings['Content']."</B><BR>"; 
           foreach ($Content as $key => $row) {
                   echo $Content[$key]['link'];
                   }
           }

           if (is_array($Comments)){           
           aasort($Comments,"cnt");
           echo "<BR><B>".$strings['Comments']."</B><BR>"; 
           foreach ($Comments as $key => $row) {
                   echo $Comments[$key]['link'];
                   }
           }
           
           if (is_array($Causes)){           
           aasort($Causes,"cnt");
           echo "<BR><B>".$strings['Causes']."</B><BR>"; 
           foreach ($Causes as $key => $row) {
                   echo $Causes[$key]['link'];
                   }
           }

           if (is_array($Governments)){
           aasort($Governments,"cnt");
           echo "<BR><B>".$strings['Governments']."</B><BR>"; 
           foreach ($Governments as $key => $row) {
                   echo $Governments[$key]['link'];
                   }
           }
           
           if (is_array($GovernmentConstitutions)){
           aasort($GovernmentConstitutions,"cnt");
           echo "<BR><B>".$strings['GovernmentConstitutions']."</B><BR>"; 
           foreach ($GovernmentConstitutions as $key => $row) {
                   echo $GovernmentConstitutions[$key]['link'];
                   }
           }

           if (is_array($ConstitutionalArticles)){
           aasort($ConstitutionalArticles,"cnt");
           echo "<BR><B>".$strings['ConstitutionalArticles']."</B><BR>"; 
           foreach ($ConstitutionalArticles as $key => $row) {
                   echo $ConstitutionalArticles[$key]['link'];
                   }
           }

           if (is_array($ConstitutionalAmendments)){
           aasort($ConstitutionalAmendments,"cnt");
           echo "<BR><B>".$strings['ConstitutionalAmendments']."</B><BR>"; 
           foreach ($ConstitutionalAmendments as $key => $row) {
                   echo $ConstitutionalAmendments[$key]['link'];
                   }
           }
           
           if (is_array($GovernmentTypes)){
           aasort($GovernmentTypes,"cnt");
           echo "<BR><B>".$strings['GovernmentTypes']."</B><BR>"; 
           foreach ($GovernmentTypes as $key => $row) {
                   echo $GovernmentTypes[$key]['link'];
                   }
           }
           
           if (is_array($PoliticalParties)){
           aasort($PoliticalParties,"cnt");
           echo "<BR><B>".$strings['PoliticalParties']."</B><BR>"; 
           foreach ($PoliticalParties as $key => $row) {
                   echo $PoliticalParties[$key]['link'];
                   }
           }
           
           if (is_array($GovernmentPolicies)){
           aasort($GovernmentPolicies,"cnt");
           echo "<BR><B>".$strings['PoliticalPartyPolicies']."</B><BR>"; 
           foreach ($GovernmentPolicies as $key => $row) {
                   echo $GovernmentPolicies[$key]['link'];
                   }
           }                   

           if (is_array($Countries)){
           aasort($Countries,"cnt");
           echo "<BR><B>".$strings['Countries']."</B><BR>"; 
           foreach ($Countries as $key => $row) {
                   echo $Countries[$key]['link'];
                   }
           }

           } // end if

       } // if array

   break;
   ###########################
   case 'get_vote_count':

    $object_type = "Votes";
    $action = "select";
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $object_return_params[0];
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    
    return count($voterows);

   break; // end get
   ###########################
   case 'view_all':
   
    echo "<div style=\"".$divstyle_white."\"><center><P><font color=#FBB117 size=3><B>".$strings["ViewFullVotes"]."</B></font> ".$object_return_target."</div><img src=images/blank.gif width=500 height=10><BR>";

    $query = $object_return_params[0];
            
    $object_type = "Votes";
    $action = "select";

    // Get unique user count
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] =  $query;
    $voteparams[1] = "DISTINCT(contact_id_c)";
    $voteparams[2] = "";
    $voteparams[3] = "";
    $voteparams[4] = "";

    $voterows = "";          

// All votes must be unique users!
/*
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $contact_vote = count($voterows);
       } else {
       $contact_vote = 0;
       }
*/

    $valid_vote_count = 0; //Add only if there is a count - to give the divisible for the total ratio
    $valid_vote_value = 0;
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] =  $query." && `vote`='-10'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_ten_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-10);
       } else {
       $minus_ten_vote = 0;
       }
    // next will be to go through by country...
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." &&  `vote`='-9'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_nine_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-9);
       } else {
       $minus_nine_vote = 0;
       }
     // next will be to go through by country... 
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-8'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_eight_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-8);
       } else {
       $minus_eight_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-7'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_seven_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-7);
       } else {
       $minus_seven_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-6'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_six_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-6);
       } else {
       $minus_six_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-5'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_five_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-5);
       } else {
       $minus_five_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-4'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_four_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-4);
       } else {
       $minus_four_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-3'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_three_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-3);
       } else {
       $minus_three_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-2'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_two_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-2);
       } else {
       $minus_two_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='-1'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $minus_one_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*-1);
       } else {
       $minus_one_vote = 0;
       }
     // next will be to go through by country...           

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='0'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $zero_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*1);
       } else {
       $zero_vote = 0;
       }
     // next will be to go through by country...           
        
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='1'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $one_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*1);
       } else {
       $one_vote = 0;
       }
     // next will be to go through by country...           
        
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='2'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $two_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*2);
       } else {
       $two_vote = 0;
       }
     // next will be to go through by country... 

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='3'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $three_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*2);
       } else {
       $three_vote = 0;
       }
     // next will be to go through by country... 
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='4'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $four_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*4);
       } else {
       $four_vote = 0;
       }
     // next will be to go through by country... 

    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='5'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $five_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*5);
       } else {
       $five_vote = 0;
       }
     // next will be to go through by country... 
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." &&  `vote`='6'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $six_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*6);
       } else {
       $six_vote = 0;
       }
     // next will be to go through by country... 
        
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='7'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $seven_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*7);
       } else {
       $seven_vote = 0;
       }
     // next will be to go through by country... 
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='8'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $eight_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*8);
       } else {
       $eight_vote = 0;
       }
     // next will be to go through by country... 
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='9'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $nine_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*9);
       } else {
       $nine_vote = 0;
       }
     // next will be to go through by country... 
     
    $voteparams = "";
    $voteparams = array();
    $voteparams[0] = $query." && `vote`='10'";
    $voteparams[1] = "";
    $voterows = "";          
    $voterows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $voteparams);
    if (is_array($voterows)){
       $ten_vote = count($voterows);
       $valid_vote_value = $valid_vote_value + (count($voterows)*10);
       } else {
       $ten_vote = 0;
       }
     // next will be to go through by country... 

     $total_votes = $minus_ten_vote + $minus_nine_vote + $minus_eight_vote + $minus_seven_vote + $minus_six_vote + $minus_four_vote + $minus_five_vote + $minus_three_vote + $minus_two_vote + $minus_one_vote + $zero_vote + $one_vote + $two_vote + $three_vote + $four_vote + $five_vote + $six_vote + $seven_vote + $eight_vote + $nine_vote + $ten_vote;

    $stat_params = "";     
    $stats_type_label = "";
    $stats_label = $strings["Votes"];
    $item_count = $total_votes;

    $stats_value = (($minus_ten_vote/$total_votes)*$minus_ten_vote)*100;
    $positivity = '-10';
    $item_count = $minus_ten_vote;

    $minus_ten_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_nine_vote/$total_votes)*$minus_nine_vote)*100;
    $positivity = '-9';
    $item_count = $minus_nine_vote;

    $minus_nine_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_eight_vote/$total_votes)*$minus_eight_vote)*100;
    $positivity = '-8';
    $item_count = $minus_eight_vote;

    $minus_eight_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_seven_vote/$total_votes)*$minus_seven_vote)*100;
    $positivity = '-7';
    $item_count = $minus_seven_vote;

    $minus_seven_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_six_vote/$total_votes)*$minus_six_vote)*100;
    $positivity = '-6';
    $item_count = $minus_six_vote;

    $minus_six_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_five_vote/$total_votes)*$minus_five_vote)*100;
    $positivity = '-5';
    $item_count = $minus_five_vote;

    $minus_five_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_four_vote/$total_votes)*$minus_four_vote)*100;
    $positivity = '-4';
    $item_count = $minus_four_vote;

    $minus_four_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_three_vote/$total_votes)*$minus_three_vote)*100;
    $positivity = '-3';
    $item_count = $minus_three_vote;
 
    $minus_three_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_two_vote/$total_votes)*$minus_two_vote)*100;
    $positivity = '-2';
    $item_count = $minus_two_vote;
 
    $minus_two_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($minus_one_vote/$total_votes)*$minus_one_vote)*100;
    $positivity = '-1';
    $item_count = $minus_one_vote;
 
    $minus_one_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($zero_vote/$total_votes)*$zero_vote)*100;
    $positivity = '0';
    $item_count = $zero_vote;
 
    $zero_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($one_vote/$total_votes)*$one_vote)*100;
    $positivity = '1';
    $item_count = $one_vote;

    $one_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($two_vote/$total_votes)*$two_vote)*100;
    $positivity = '2';
    $item_count = $two_vote;

    $two_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($three_vote/$total_votes)*$three_vote)*100;
    $positivity = '3';
    $item_count = $three_vote;
 
    $three_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($four_vote/$total_votes)*$four_vote)*100;
    $positivity = '4';
    $item_count = $four_vote;
 
    $four_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($five_vote/$total_votes)*$five_vote)*100;
    $positivity = '5';
    $item_count = $five_vote;
  
    $five_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($six_vote/$total_votes)*$six_vote)*100;
    $positivity = '6';
    $item_count = $six_vote;
  
    $six_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($seven_vote/$total_votes)*$seven_vote)*100;
    $positivity = '7';
    $item_count = $seven_vote;

    $seven_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);
         
    $stats_value = (($eight_vote/$total_votes)*$eight_vote)*100;
    $positivity = '8';
    $item_count = $eight_vote;

    $eight_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($nine_vote/$total_votes)*$nine_vote)*100;
    $positivity = '9';
    $item_count = $nine_vote;

    $nine_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $stats_value = (($ten_vote/$total_votes)*$ten_vote)*100;
    $positivity = '10';
    $item_count = $ten_vote;

    $ten_vote_stats = $funky_gear->makestats ($stats_type_label,$stats_label,$stats_value,$item_count,$positivity,$stat_params);

    $report_breakdown = "<table width=100%><tr><td width=400>
                <div style=\"float:left;width:100%;border:1px solid #60729b;background-color:#FFFFFF;\">
                 <div style=\"float:left;padding-top:3px;width:25px;background-color:#C0C0C0;\"><center><B>-+</B></font></center></div>
                 <div style=\"float:left;padding-left:5px;margin-top:3px;\"><center><B>".$strings["Total"]." ".$strings["Votes"]."</B></center></font></div>
                </div>
               </td>
              </tr>";

    $report_breakdown .= $ten_vote_stats;
    $report_breakdown .= $nine_vote_stats;
    $report_breakdown .= $eight_vote_stats;
    $report_breakdown .= $seven_vote_stats;
    $report_breakdown .= $six_vote_stats;
    $report_breakdown .= $five_vote_stats;
    $report_breakdown .= $four_vote_stats;
    $report_breakdown .= $three_vote_stats;
    $report_breakdown .= $two_vote_stats;
    $report_breakdown .= $one_vote_stats;
    $report_breakdown .= $zero_vote_stats;
    $report_breakdown .= $minus_one_vote_stats;
    $report_breakdown .= $minus_two_vote_stats;
    $report_breakdown .= $minus_three_vote_stats;
    $report_breakdown .= $minus_four_vote_stats;
    $report_breakdown .= $minus_five_vote_stats;
    $report_breakdown .= $minus_six_vote_stats;
    $report_breakdown .= $minus_seven_vote_stats;
    $report_breakdown .= $minus_eight_vote_stats;
    $report_breakdown .= $minus_nine_vote_stats;
    $report_breakdown .= $minus_ten_vote_stats;
    $report_breakdown .= "</table>";

    if ($total_votes >1 ){
       $people_believe = $strings["VoteReport_PeopleBelieve"];
       } else {
       $people_believe = $strings["VoteReport_PersonBelieves"];
       }

    $total_valid_vote_value = ROUND($valid_vote_value/$total_votes,0);
    if ($total_valid_vote_value > 0 ){
       $total_valid_vote_value = "<font color=blue><B>+".$total_valid_vote_value."</B></font>";
       } else {
       $total_valid_vote_value = "<font color=red><B>".$total_valid_vote_value."</B></font>";
       }

    echo "<div style=\"".$divstyle_blue."\"><P><font size=3><B>".$strings["VoteReport_AccordingToThe"].$total_votes.$strings["VoteReport_VotesSubmitted"].$total_votes.$people_believe.$total_valid_vote_value.$strings["VoteReport_ForThis"]." ".$strings["FinalReport_SeeBelow"]."</B></font><P></div><img src=images/blank.gif width=98% height=10><BR>";

    echo $report_breakdown;

    echo "<BR><img src=images/blank.gif width=500 height=10><BR>";

    // Make Embedded Object Link
    $params = array();
    $params[0] = $valuetype_name;
    echo $funky_gear->makeembedd ($do,'view_all',$val,$valtype,$params);

   break;  // end print vote stats
   ###########################
   case 'print_vote':

    if ($sess_contact_id){

       for ($cnt=-10;$cnt < 11;$cnt++){

           $voteval = $cnt;

           switch ($voteval){

            case -10:
             $votecolor = "#C11B17";
            break;
            case -9:
             $votecolor = "#E42217";
            break;
            case -8:
             $votecolor = "#F62817";
            break;
            case -7:
             $votecolor = "#FF0000";
            break;
            case -6:
             $votecolor = "#7E2217";
            break;
            case -5:
             $votecolor = "#7E3117";
            break;
            case -4:
             $votecolor = "#C35617";
            break;
            case -3:
             $votecolor = "#F88017";
            break;
            case -2:
             $votecolor = "#C34A2C";
            break;
            case -1:
             $votecolor = "#F88158";
            break;
            case 0:
             $votecolor = "#F9966B";
            break;
            case 1:
             $votecolor = "#4CC417";
            break;
            case 2:
             $votecolor = "#4E8975";
            break;
            case 3:
             $votecolor = "#5E767E";
            break;
            case 4:
             $votecolor = "#A0CFEC";
            break;
            case 5:
             $votecolor = "#82CAFA";
            break;
            case 6:
             $votecolor = "#6698FF";
            break;
            case 7:
             $votecolor = "#488AC7";
            break;
            case 8:
             $votecolor = "#1569C7";
            break;
            case 9:
             $votecolor = "#2B60DE";
            break;
            case 10:
             $votecolor = "#2554C7";
            break;

           } // end vote font color switch
         
           $val_show = $voteval;

           if ($voteval > 0){
              $val_show = "+".$voteval;
              }

           $returnpack .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','rp=".$realpolitikacode."&do=Votes&action=check_vote&value=".$val."&valuetype=".$valtype."&vote=".$voteval."');\"><font size=2 color=".$votecolor.">".$val_show."</font></a> ";
         
           } // end for
         
         $returnpack = "<center>(-10 is lowest score (really don't like) and +10 is highest score)<P>".$returnpack."</center>";

       } else {

       $returnpack = "<center><font color=red><B>".$strings["message_not_logged-in_cant_add"]."</B></font></center>";

       }

    $returnpack = "<div style=\"".$divstyle_white."\"><div><center><font color=#FF8040 size=3><B>".$strings["action_Vote_for"].": ".$object_return_target."</B></font></center></div><P>".$returnpack."<P><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Votes&action=view_all&value=".$val."&valuetype=".$valtype."');return false\"><font size=3 color=#151B54>".$strings["action_click_here_to_view_full_votes"]."</font></a></center><P></div>";

    echo $returnpack;
      
    break; // end print_vote
    case 'check_vote':
     
     $vote_value = $_POST['vote'];
      
      // Perform switch for voted object type
      // Must first check the related government constitutional articles for election rules: contains_election_rules
/*

Voting Rules:

* Does the constitution deal with elections to provide for a Political Party to lead the Government?
* Is there a per-citizen voting frequency limit based within a set time period (1 year, 2 years, 4 years, etc.)?
Per Citizen Voting Frequency Limit
 per_citizen_voting_freq_limit
* What are the from and to dates for voting frequency limitations?
 voting_period_date_from Voting Period Date From
 voting_period_date_to Voting Period Date To
* Government Term Months
 government_term_months
* Is there a nationality limit for the vote?
 nationality_voting_restriction Nationality Voting Restriction
* Is there an age limit for the vote?
 age_voting_restriction Age Voting Restriction
* What is the desired nationality verification method?
* Is there a residential limit for the vote?

Assumptions:

* Elected Party Head becomes Government Head
* Government Branch Heads over-rule departments and agencies under them with regards to;
 -> Method of hiring for roles (popular vote WITHIN the Department or Agency
 -> Voted by popular citizen vote
 -> Hired based on qualifications

Nominee Rules:

* Must the nominees for Government Roles have the same nationality of the Government Nationality?
* Is there a minimum age requirement to be a nominee?

government_role_minimum_age Government Role Minimum Age


Incumbants

*/
     ###############################################
     # Start switch for vote_objects

     $cmv_comments_id_c = "";
     $cmv_events_id_c = "";
     $cmv_content_id_c = "";
     $cmv_governments_id_c = "";
     $cmv_governmentpolicies_id_c = "";
     $cmv_governmentconstitutions_id_c = "";
     $cmv_constitutionalarticles_id_c = "";
     $cmv_politicalparties_id_c = "";
     $cmv_governmenttypes_id_c = "";
     $cmv_constitutionalamendments_id_c = "";
     $cmv_politicalpartyroles_id_c = "";
     $cmv_governmentroles_id_c = "";
     $cmv_nominees_id_c = "";
     $account_id_c = "";
     $contact_id1_c = "";
     $cmv_causes_id_c = "";
     $sfx_actions_id_c = "";
     $sfx_effects_id_c = "";
     $cmv_countries_id_c = "";
     $cmv_countries_id1_c = "";


     switch ($valtype){
       
      case 'Accounts':
       
       $object_type = "Accounts";
       $vote_object = $object_type;
       $object = "Accounts";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name";
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `account_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $account_id_c = $val;

      break;
      case 'Actions':
       
       $object_type = "Actions";
       $vote_object = $object_type;
       $object = "Actions";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name";
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `sfx_actions_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $sfx_actions_id_c = $val;

      break;
      case 'Causes':
       
       $object_type = "Causes";
       $vote_object = $object_type;
       $object = "Causes";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "title_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_causes_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_causes_id_c = $val;

      break;
      case 'Comments':
       
       $object_type = "Comments";
       $vote_object = $object_type;
       $object = "Comments";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name";
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_comments_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_comments_id_c = $val;

      break;
      case 'ConstitutionArticles':
       
       // contains_election_rules
       $object_type = "ConstitutionArticles";
       $vote_object = $object_type;
       $object = "Constitution Articles";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "title_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_constitutionalarticles_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_constitutionalarticles_id_c = $val;

      break;
      case 'GovernmentConstitutions':
      case 'Constitutions':
       
       $object_type = "GovernmentConstitutions";
       $vote_object = $object_type;
       $object = "Government Constitution";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "constitution_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_governmentconstitutions_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_governmentconstitutions_id_c = $val;

      break;
      case 'ConstitutionArticles':
      case 'ConstitutionalArticles':
       
       $object_type = "ConstitutionalArticles";
       $vote_object = $object_type;
       $object = "Constitution Articles";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "article_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_constitutionalarticles_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_constitutionalarticles_id_c = $val;

      break;
      case 'ConstitutionAmendments':
      case 'ConstitutionalAmendments':
       
       $object_type = "ConstitutionalAmendments";
       $vote_object = $object_type;
       $object = "Constitutional Amendments";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "amendment_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_constitutionalamendments_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_constitutionalamendments_id_c = $val;

      break;
      case 'Contacts':
       
       $object_type = "Contacts";
       $vote_object = $object_type;
       $object = "Contacts";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name";
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `contact_id1_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $contact_id1_c = $val;

      break;
      case 'Content':
       
       $object_type = "Content";
       $vote_object = $object_type;
       $object = "Content";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name";
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_content_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_content_id_c = $val;

      break;
      case 'Countries':
       
       $object_type = "Countries";
       $vote_object = $object_type;
       $object = "Countries";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_countries_id1_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_countries_id1_c = $val;

      break;
      case 'Events':
       
       $object_type = "Events";
       $vote_object = $object_type;
       $object = "Events";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name_".$lingo;
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `cmv_events_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $cmv_events_id_c = $val;

      break;
      case 'GovernmentElection':
       
       // Get constitutional limits
       $object_type = "GovernmentConstitutions";
       $action = "select_by_gov";
       $params = array();
       $params[0] = "cmv_govern0bc5rnments_idb='".$val."'";
       $params[1] ="";

       $const_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params); 
        
       if (is_array($const_list)){
          //arsort ($const_list);
          for ( $cnt=0;$cnt < count($const_list);$cnt++){
              $id = $const_list[$cnt]['id'];
              $const_name = "title_".$lingo;           
              $const_name = $const_list[$cnt][$const_name];
              $constitution = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','do.php', 'rp=".$realpolitikacode."&do=Constitutions&action=view&value=".$id."&valuetype=Constitutions');return false\"><font=#151B54><B>".$const_name."</B></font></a><BR>";
              $per_citizen_voting_freq_limit = $const_list[$cnt]['per_citizen_voting_freq_limit'];
              $voting_period_date_from = $const_list[$cnt]['voting_period_date_from'];
              $voting_period_date_to = $const_list[$cnt]['voting_period_date_to'];
              $nationality_voting_restriction = $const_list[$cnt]['nationality_voting_restriction'];
              $age_voting_restriction = $const_list[$cnt]['age_voting_restriction'];
              $government_role_minimum_age = $const_list[$cnt]['government_role_minimum_age'];
              $government_term_months = $const_list[$cnt]['government_term_months'];
           
              // check GovernmentElections for voting period
 
              } // end for
           
          } // end array
       
      break;
      case 'GovernmentTypes':
       
        $per_citizen_voting_freq_limit = 1;
        $object_type = "GovernmentTypes";
        $vote_object = $object_type;
        $object = "Government Type";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "name_".$lingo;
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_governmenttypes_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_governmenttypes_id_c = $val;

      break;
      case 'Governments':

        // Get Basic Gov Info
        $object_type = "Governments";
        $vote_object = $object_type;
        $object = "Government";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "government_".$lingo;
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_governments_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_governments_id_c = $val;
            
      break;
      case 'PoliticalParties':

        $object_type = "PoliticalParties";
        $vote_object = $object_type;
        $object = "Political Party";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "party_name_".$lingo;
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_politicalparties_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_politicalparties_id_c = $val;
       
      break;
      case 'GovernmentPolicies':
      case 'PoliticalPartyPolicies':

        $object_type = "GovernmentPolicies";
        $vote_object = $object_type;
        $object = "Political Party Policy";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "policy_title_".$lingo;
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_governmentpolicies_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_governmentpolicies_id_c = $val;
       
      break;
      case 'GovernmentRoles':
       
        $object_type = "GovernmentRoles";
        $vote_object = $object_type;
        $object = "Government Role";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "role_".$lingo;
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_governmentroles_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_governmentroles_id_c = $val;

      break;
      case 'GovernmentRoleIncumbants':
       
        $object_type = "GovernmentRoles";
        $vote_object = $object_type;
        $object = "Government Role Incumbant";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `contact_id_c`='".$val."'"; // The roles actual person
        $vote_object_params[1] = "";
        $vote_object_name = "name";
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `contact_id1_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $contact_id1_c = $val;
       
      break;
      case 'News':
       
        $object_type = "News";
        $vote_object = $object_type;
        $object = "News";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "name";
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_news_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_news_id_c = $val;
       
      break;
      case 'Nominees':
       
        $object_type = "Nominees";
        $vote_object = $object_type;
        $object = "Nominee";
        $vote_object_params = array();
        $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
        $vote_object_params[1] = "";
        $vote_object_name = "name";
        $vote_check_params = array();
        $vote_check_params[0] ="`deleted`=0 && `cmv_nominees_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
        $cmv_nominees_id_c = $val;
       
      break;
      case 'Effects':
       
       // contains_election_rules
       $object_type = "Effects";
       $vote_object = $object_type;
       $object = "Effects";
       $vote_object_params = array();
       $vote_object_params[0] ="`deleted`=0 && `id`='".$val."'";
       $vote_object_params[1] = "";
       $vote_object_name = "name";
       $vote_check_params = array();
       $vote_check_params[0] ="`deleted`=0 && `sfx_effects_id_c`='".$val."' && `contact_id_c`='".$sess_contact_id."' ";
       $sfx_effects_id_c = $val;

      break;
       
      } // end vote object switch 

      // Use above values to perform the vote
/*
      $api_user = "";
      $api_pass = "";
      $crm_wsdl_url = "";

      $action = "select";
      $vote_object_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $vote_object_params);

      if (is_array($vote_object_list)){

         for ($cnt=0;$cnt < count($vote_object_list);$cnt++){

             $vote_object_name = $vote_object_list[$cnt][$vote_object_name];
          
             } // end for 
         }
*/

       $returner = $funky_gear->object_returner ($valtype, $val);
       $object_return_name = $returner[0];
       $object_return = $returner[1];
       $object_return_title = $returner[2];
       $object_return_target = $returner[3];
       $object_return_params = $returner[4];
       $object_return_completion = $returner[5];

       // General Vote - only once - See if exists in vote before going further
       $object_type = "Votes";
       $action = "select";
       $vote_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $vote_check_params);
                
       if (is_array($vote_list)){
          // This person has already voted for this object - so no more!
          for ($cnt=0;$cnt < count($vote_list);$cnt++){

              $id = $vote_list[$cnt]['id'];
              $vote = $vote_list[$cnt]['vote'];
          
              $returnpack[$cnt]['vote_id'] = $id;
              $returnpack[$cnt]['vote'] = $vote;
              $returnpack[$cnt]['vote_object_name'] = $object_return_name;
              $returnpack[$cnt]['vote_message'] = "<img src=images/blank.gif width=550 height=1><BR><font size=3><B>You have already voted for the <font size=3 color=#FBB117>".$object.":</font>  ".$object_return_target."<font size=3>. Click <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Votes&action=edit&value=".$id."&valuetype=".$vote_object."&vote=".$vote."');return false\">here</a> to edit the results.</B></font>";
          
              } // end for

          echo $returnpack[0]['vote_message'];
         
          } else {
          
          // This person CAN vote for this object - use SOAP!

          $name = $object." Vote: ".$object_return_name;
          $date_entered = "";
          $date_modified = "";
          $modified_user_id = "";
          $created_by = "1";
          $description = "Vote has been created for ".$object_return_name;
          $deleted = "0";
          $assigned_user_id = "1";
          $ip_address = $_SERVER['REMOTE_ADDR'];
          $country = "";
          if (!$cmv_countries_id_c){
             if (!empty($ip_address)) {
                $country = file_get_contents('http://api.hostip.info/country.php?ip='.$ip_address);
                }
             if (!empty($country)) {
                $cmv_countries_id_c = dlookup("cmv_countries", "id", "two_letter_code='".$country."'");
                }
             }

          $cmv_statuses_id_c = $standard_statuses_open_public;

          $object_type = "Votes";
          $action = "do_vote";
          $params = array(
          array('name'=>'created_by','value' => $created_by),
          array('name'=>'name','value' => $name),          
          array('name'=>'description','value' => $description),
          array('name'=>'deleted','value' => $deleted),
          array('name'=>'assigned_user_id','value' => $assigned_user_id),
          array('name'=>'ip_address','value' => $ip_address),
          array('name'=>'cmv_governments_id_c','value' => $cmv_governments_id_c),
          array('name'=>'contact_id_c','value' => $sess_contact_id),
          array('name'=>'vote','value' => $vote_value),
          array('name'=>'cmv_causes_id_c','value' => $cmv_causes_id_c),
          array('name'=>'cmv_statuses_id_c','value' => $cmv_statuses_id_c),
          array('name'=>'contact_id1_c','value' => $contact_id1_c),
          array('name'=>'cmv_governmentpolicies_id_c','value'=>$cmv_governmentpolicies_id_c),
          array('name'=>'cmv_constitutionalarticles_id_c','value'=>$cmv_constitutionalarticles_id_c),
          array('name'=>'cmv_politicalparties_id_c','value'=>$cmv_politicalparties_id_c),
          array('name'=>'cmv_governmenttypes_id_c','value'=>$cmv_governmenttypes_id_c),
          array('name'=>'cmv_governmentconstitutions_id_c','value'=>$cmv_governmentconstitutions_id_c),
          array('name'=>'cmv_constitutionalamendments_id_c','value'=>$cmv_constitutionalamendments_id_c),
          array('name'=>'cmv_politicalpartyroles_id_c','value'=>$cmv_politicalpartyroles_id_c),
          array('name'=>'cmv_governmentroles_id_c','value'=>$cmv_governmentroles_id_c),
          array('name'=>'cmv_countries_id_c','value'=>$cmv_countries_id_c),
          array('name'=>'cmv_governmentconstitutions_id_c','value'=>$cmv_governmentconstitutions_id_c),
          array('name'=>'cmv_comments_id_c','value'=>$cmv_comments_id_c),
          array('name'=>'cmv_nominees_id_c','value'=>$cmv_nominees_id_c),
          array('name'=>'sfx_actions_id_c','value'=>$sfx_actions_id_c),
          array('name'=>'sfx_effects_id_c','value'=>$sfx_effects_id_c),
          array('name'=>'cmv_content_id_c','value'=>$cmv_content_id_c),
          array('name'=>'cmv_countries_id1_c','value'=>$cmv_countries_id1_c),
          array('name'=>'cmv_news_id_c','value'=>$cmv_news_id_c),
          array('name'=>'account_id_c','value' => $account_id_c),
          array('name'=>'cmv_events_id_c','value' => $cmv_events_id_c),
         ); 

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
                  
         $id = $result['id'];  
         $returnpack[0]['vote_id'] = $id;
         $returnpack[0]['vote'] = $vote;
         $returnpack[0]['vote_object_name'] = $vote_object_name;         
         $returnpack[0]['vote_message'] = "<img src=images/blank.gif width=550 height=1><BR><font size=3><B>You voted for the <font color=#FBB117>".$object.":</font> ".$object_return_target."<font size=3>. Click <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Votes&action=edit&value=". $id."&valuetype=".$vote_object."&vote=".$vote."');return false\">here</a> to view the results.</font></B>";

         echo $returnpack[0]['vote_message'];

         } // end if not voted yet
          
    break; // end check_vote
    
  } // end votes action switch

# break; // End Votes
##########################################################
?>