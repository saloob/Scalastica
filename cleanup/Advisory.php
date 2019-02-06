<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Advisory.php 
##########################################################
# case 'Advisory':

//  $system_access = FALSE;

//  $system_access = TRUE;


    // Get Characters and Images
    $advisory_object_type = "ConfigurationItems";
    $advisory_action = "select";
    $advisory_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='7a908258-f1d2-b3b4-2a1d-526fb8b295af' && account_id_c='".$portal_account_id."' ";
    $advisory_params[1] = ""; // select array
    $advisory_params[2] = ""; // group;
    $advisory_params[3] = ""; // order;
    $advisory_params[4] = ""; // limit
  
    $advisory_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisory_object_type, $advisory_action, $advisory_params);

    if (is_array($advisory_items)){

       for ($cnt=0;$cnt < count($advisory_items);$cnt++){
 
           $id = $advisory_items[$cnt]['id'];
           $name = $advisory_items[$cnt]['name'];

           if ($name != NULL){

              $advisoryimage_object_type = "ConfigurationItems";
              $advisoryimage_action = "select";
              $advisoryimage_params[0] = " id='".$name."' ";
              $advisoryimage_params[1] = ""; // select array
              $advisoryimage_params[2] = ""; // group;
              $advisoryimage_params[3] = ""; // order;
              $advisoryimage_params[4] = ""; // limit
  
              $advisoryimage_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisoryimage_object_type, $advisoryimage_action, $advisoryimage_params);

              if (is_array($advisoryimage_items)){

                 for ($cnt=0;$cnt < count($advisoryimage_items);$cnt++){
 
                     $image_url = $advisoryimage_items[$cnt]['image_url'];

                     } // for

                 } // if

              } // if name

           } // for

       } // is array

       if (!$image_url){
          $image_url = 'images/icons/tech_support_icon.png';
          } 

  switch ($action){
   


    // Not logged in - provide some other communication tool
    // Free - tid-bits
    // Paid as below


//   break;
   case 'chat':


    // Chat Content

   break;
   case 'voip':

    if ($val != NULL){
       $zingaya = "http://zingaya.com/widget/".$val;
       } else {
       $zingaya = "http://zingaya.com/widget/87d8bedc58af0aed0134ca0b4c90cdca";
       }

    # VoIP Content
    echo "<center><a href=\"".$zingaya."\" onclick=\"window.open(this.href+'?referrer='+escape(window.location.href)+'', '_blank', 'width=236,height=220,resizable=no,toolbar=no,menubar=no,location=no,status=no'); return false\" class=\"css3button\">".$strings["VoIPCallOnline"]."</a></center><BR>";
    #echo "<img src=images/blank.gif width=50 height=10><BR>";

   break;
   case 'keywords':

/*
$keyword_object_type = "SearchKeywords";
$keyword_action = "select";
$keyword_params = array();
$keyword_params[0] = " sclm_leadsources_id_c='".$sess_leadsources_id_c."' ";
$keyword_params[1] = 'id,name,search_count';
$keyword_params[2] = "";
$keyword_params[3] = "search_count DESC";
$keyword_params[4] = "10";

$keyword_result = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $keyword_object_type, $keyword_action, $keyword_params);

if (is_array($keyword_result)){

echo "<div style=\"".$divstyle_blue."\"><center><B>".$strings["TopSearchedKeywords"]."</B></center>";

   for ($cnt=0;$cnt < count($keyword_result);$cnt++){

       $search_count = $keyword_result[$cnt]['search_count'];
       $total_count = $total_count+$search_count;

       } // end foreach

   $average = $total_count/count($keyword_result);

   for ($cnt=0;$cnt < count($keyword_result);$cnt++){

       $name = $keyword_result[$cnt]['name'];
       $search_count = $keyword_result[$cnt]['search_count'];
       $average_count = round(($search_count/$average),2);

       $average_count = round(($average_count*100),0);

//       $average_count = $average_count;
       switch ($average_count){

        case ($average_count > 200):

         $font_size = 6;
         $font_color = "#C11B17";

        break;
        case ($average_count > 100 && $average_count < 200):

         $font_size=5;
         $font_color = "#E42217";

        break;
        case ($average_count > 80 && $average_count < 100):

         $font_size=4;
         $font_color = "#F62817";

        break;
        case ($average_count > 60 && $average_count < 80):

         $font_size=3;
         $font_color = "#FF0000";

        break;
        case ($average_count > 40 && $average_count < 60):

         $font_size=2;
         $font_color = "#7E2217";

        break;
        case ($average_count > 20 && $average_count < 40):

         $font_size=1;
         $font_color = "#7E3117";

        break;
        case ($average_count > 0 && $average_count < 20):

         $font_size=.5;
         $font_color = "#C35617";

        break;

       } // end switch

       echo "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Search&action=search&value=".$name."&valuetype=keyword');return false\"><font size=".$font_size.">".$name." (".$search_count.")</font></a> ";

       } // end foreach

   echo "</div>";

  } // end if keywords
*/
   break;
   case 'welcome':

    $name = "";

    if ($valtype != 'Search'){

       if ($sess_contact_id){

          $contacts_object_type = "Contacts";
          $contacts_action = "select";
          $contacts_params[0] = " id='".$sess_contact_id."' "; // query
          $contacts_params[1] = "";
          $contacts_params[2] = "";
          $contacts_params[3] = "";
          $contacts_params[4] = "";

          $contacts_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contacts_object_type, $contacts_action, $contacts_params);

          for ($cnt=0;$cnt < count($contacts_info);$cnt++){

              $first_name = $contacts_info[$cnt]['first_name'];

              } // end for

          # Get Characters and Images
          $advisory_object_type = "ConfigurationItems";
          $advisory_action = "select";
          $advisory_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='db691e92-801b-5e74-1b04-530bc8da32a9' && account_id_c='".$portal_account_id."' ";
          $advisory_params[1] = ""; // select array
          $advisory_params[2] = ""; // group;
          $advisory_params[3] = ""; // order;
          $advisory_params[4] = ""; // limit
  
          $advisory_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisory_object_type, $advisory_action, $advisory_params);

          if (is_array($advisory_items)){

             for ($cnt=0;$cnt < count($advisory_items);$cnt++){

                 $id = $advisory_items[$cnt]['id'];
                 $name = $advisory_items[$cnt]['name'];

                 if ($advisory_items[$cnt][$lingoname] != NULL){
                    $name = $advisory_items[$cnt][$lingoname];
                    }

                 if ($advisory_items[$cnt][$lingodesc] != NULL){
                    $description = $advisory_items[$cnt][$lingodesc];
                    }

                 } // for

             } // if

          if ($name){

             $welcome = str_replace("XXXXXX",$first_name,$name);

             } else {
          
             $welcome = str_replace("XXXXXX",$first_name,$strings["AdvisoryWelcomeBack"]);

             } 

          if ($description){

             $click_action = str_replace("XXXXXX",$first_name,$description);

             } else {

             $click_action = str_replace("XXXXXX",$first_name,$strings["AdvisoryMemberClickToViewAdvisory"]);

             } 


          } else {

          # Not signed-in - no name
          # Get Characters and Images
          $advisory_object_type = "ConfigurationItems";
          $advisory_action = "select";
          $advisory_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='e57e1bbd-89dc-336a-ea74-530bc77ac017' && account_id_c='".$portal_account_id."' ";
          $advisory_params[1] = ""; // select array
          $advisory_params[2] = ""; // group;
          $advisory_params[3] = ""; // order;
          $advisory_params[4] = ""; // limit
  
          $advisory_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisory_object_type, $advisory_action, $advisory_params);

          if (is_array($advisory_items)){

             for ($cnt=0;$cnt < count($advisory_items);$cnt++){

                 $id = $advisory_items[$cnt]['id'];
                 $name = $advisory_items[$cnt]['name'];

                 if ($advisory_items[$cnt][$lingoname] != NULL){
                    $name = $advisory_items[$cnt][$lingoname];
                    }

                 if ($advisory_items[$cnt][$lingodesc] != NULL){
                    $description = $advisory_items[$cnt][$lingodesc];
                    }

                 } // for

             } // if

          if ($name){

             $welcome = $name;

             } else {
          
             $welcome = $strings["AdvisoryWelcomeFriend"];

             } // if name

          if ($description){

             $click_action = $description;

             } else {

             $click_action = $strings["AdvisoryFriendClickToViewAdvisory"];

             } // if description


          } 

    echo "<div style=\"".$divstyle_white."\">";
    echo $funkydo_gear->funkydone ($_POST,$lingo,'Advisory','keywords',$val,$do,$bodywidth);
    echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Advisory&action=list&value=&valuetype=".$valtype."');return false\"><img src=".$image_url." width=150 border=0 alt=\"".$click_action."\"></a><BR><font size=3><B>".$welcome."</B></font></center>";
//    echo "<center><img src=images/AliAdvisory.png border=0 alt='Click me to view our Advisory section'><BR><font size=3><B>".$welcome."</B></font></center>";

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
     <input type="hidden" id="do" name="do" value="Search" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php

  echo "</div>";

  } // end if not search

//    $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

//    echo $addnew;
   
   break;
   case 'list':

    ################################
    # List
    
    if ($valtype == 'search' || $val != NULL){
       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["Advisory"]."</B></font></center></div>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       #echo "<div style=\"".$divstyle_white."\"><center><img src=".$image_url." width=150 border=0 alt=\"".$click_action."\"></center><font size=3>".$strings["AdvisoryIntro"]."</font></div>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       } else {
       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>".$strings["Advisory"]."</font></B></center></div>";
       echo "<img src=images/blank.gif width=50% height=5><BR>";
       }

    $ci_object_type = 'Advisory';
    $ci_action = "select";

    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " cmn_industries_id_c, name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $ci_params[4] = " $lfrom , $glb_perpage_items "; 

       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

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
           $summary = $ci_items[$cnt]['summary'];
           $account_id = $ci_items[$cnt]['account_id'];
           $contact_id = $ci_items[$cnt]['contact_id'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];

           if ($ci_items[$cnt]['cmn_industries_id_c']){
              $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
              $cmn_industries_name = $ci_items[$cnt]['cmn_industries_name'];
              $cmn_industry = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Industries&action=view&value=".$cmn_industries_id_c."&valuetype=".$valtype."');return false\">".$cmn_industries_name."</a>";

              if ($ci_items[$cnt]['parent_industry_id']){

                 $parent_industry_id = $ci_items[$cnt]['parent_industry_id'];
                 $parent_industry_name = $ci_items[$cnt]['parent_industry_name'];
                 $parent_industry_name = $parent_industry_name."";
                 $cmn_par_industry = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Industries&action=view&value=".$parent_industry_id."&valuetype=".$valtype."');return false\">".$parent_industry_name."</a> -> ";
                 }

              $industry_names = "";
              $industry_names .=  " [".$cmn_par_industry.$cmn_industry."]";

              }

           if ($sess_contact_id != NULL && $sess_contact_id==$contact_id){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Advisory&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
              }
     
           $cis .= "<div style=\"".$divstyle_white."\">".$edit." ".$industry_names." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Advisory&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a></div>";
      
           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($auth==3){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;


    # End List
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){ 

       $ci_object_type = $do;
       $ci_action = "select";
       $ci_params[0] = " id='".$val."' ";
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
              $summary = $ci_items[$cnt]['summary'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $account_id_c = $ci_items[$cnt]['account_id_c'];
              $contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
              $parent_industry_id = $ci_items[$cnt]['parent_industry_id'];

              } // end for

          } // is array

       } elseif ($action == 'add'){ // if action

       # Get related info to create new advisory

        switch ($valtype){

         case 'Ticketing':

          echo "Please remove any company-related information and make this Advisory generic so other Customers can get value from it. Try to clearly identify the problem, research actions and solution. This will also help you and other engineers in future to quickly identify solutions and respond to customers faster - raising our quality and value.<P>";

          echo "<a href=\"#\" onClick=\"cleardiv('ADVISORY');\"><B>".$strings["Close"]."</B></a></div>";

          $ci_object_type = 'Ticketing';
          $ci_action = "select";
          $ci_params[0] = " id= '".$val."' ";
          $ci_params[1] = "name,description,filter_id"; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = ""; // order;
          $ci_params[4] = ""; // limit
          $ci_params[5] = $lingoname;
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

                 #$id = $ci_items[$cnt]['id'];
                 $name = $ci_items[$cnt]['name'];
                 #$date_entered = $ci_items[$cnt]['date_entered'];
                 #$date_modified = $ci_items[$cnt]['date_modified'];
                 #$modified_user_id = $ci_items[$cnt]['modified_user_id'];
                 #$created_by = $ci_items[$cnt]['created_by'];
                 $description = $ci_items[$cnt]['description'];
                 #$deleted = $ci_items[$cnt]['deleted'];
                 #$assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
                 #$sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
                 #$ci_account_id_c = $ci_items[$cnt]['account_id_c'];
                 #$ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
                 #$ci_account_id1_c = $ci_items[$cnt]['account_id1_c'];
                 #$ci_contact_id1_c = $ci_items[$cnt]['contact_id1_c'];
                 #$cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
                 #$sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
                 #$start_date = $ci_items[$cnt]['start_date'];
                 #$end_date = $ci_items[$cnt]['end_date'];
                 #$sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
                 #$sclm_accountsservicesslas_id_c = $ci_items[$cnt]['sclm_accountsservicesslas_id_c'];
                 #$project_id_c = $ci_items[$cnt]['project_id_c'];
                 #$projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
                 #$sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
                 #$ticket_accumulated_minutes = $ci_items[$cnt]['accumulated_minutes']; 
                 #$extra_addressees = $ci_items[$cnt]['extra_addressees'];
                 #$extra_cc_addressees = $ci_items[$cnt]['extra_cc_addressees'];
                 #$extra_bcc_addressees = $ci_items[$cnt]['extra_bcc_addressees'];
                 $filter_id = $ci_items[$cnt]['filter_id'];
                 #$to_addressees = $ci_items[$cnt]['to_addressees'];
                 #$cc_addressees = $ci_items[$cnt]['cc_addressees'];
                 #$bcc_addressees = $ci_items[$cnt]['bcc_addressees'];

                 } // end for

              #$field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);
          
             } // if is array

         break;

        } // end switch

       } // action   

    if ($contact_id_c == NULL){
       $contact_id_c = $sess_contact_id;
       }

    if ($account_id_c == NULL){
       $accid_object_type = "Contacts";
       $accid_action = "get_account_id";
       $accid_params[0] = $sess_contact_id;
       $accid_params[1] = "account_id";
       $account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);
       }

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

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_industries_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Industry"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name

    if ($action == 'edit'){
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       } else {
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       } 

    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_industries'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($parent_industry_id){
       $tablefields[$tblcnt][9][4] = " cmn_industries_id_c='".$parent_industry_id."' ";//$exception;
       } else {
       $tablefields[$tblcnt][9][4] = " cmn_industries_id_c='' ";//$exception;
       }

    $tablefields[$tblcnt][9][5] = $cmn_industries_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][9][7] = "cmn_industries"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Industries'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_industries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_industries_id_c; //$field_value;

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
    $tablefields[$tblcnt][9][7] = "cmn_statuses"; // list reltablename
    $tablefields[$tblcnt][9][8] = ''; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;


    if ($action != 'view' || $auth==3){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'child_id'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ChildSystem"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_scalasticachildren'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $child_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ScalasticaChildren';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'child_id';//$field_value_id;
       $tablefields[$tblcnt][21] = $child_id; //$field_value;   

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

       $tablefields[$tblcnt][0] = "child_id"; // Field Name
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
       $tablefields[$tblcnt][20] = "child_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $child_id; //$field_value;   

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

    $tablefields[$tblcnt][0] = "summary"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Summary"]; // Full Name
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
    $tablefields[$tblcnt][20] = "summary"; //$field_value_id;
    $tablefields[$tblcnt][21] = $summary; //$field_value;   

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
    if ($auth==3){
       $valpack[5] = "1"; // provide add new button
       }

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

    echo $container_top;
    echo $zaform;
    echo $container_bottom;

    if ($action == 'view' || $action == 'edit'){

       ###################################################
       # Start 

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_title = "Related Items";

       //$container = $funky_gear->make_container ($bodyheight,$bodywidth,$container_title,'RelatedItems');
       //$container_top = $container[0];
      // $container_middle = $container[1];
       //$container_bottom = $container[2];

       //echo $container_top;

       //$this->funkydone ($_POST,$lingo,$do,'list',$val,$valtype,$bodywidth);

       //echo $container_bottom;

       # End
       ###################################################

       }

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
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'summary','value' => $_POST['summary']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'cmn_industries_id_c','value' => $_POST['cmn_industries_id_c']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       $process_message = $strings["SubmissionSuccess"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

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