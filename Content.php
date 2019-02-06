<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Content.php 
##########################################################
# case 'Content':

  if ($valtype == 'ConfigurationItems' && $val != NULL){
#     $object_return_params[0] .= " && content_type='".$val."' " ;
     }

  if ($object_return_params[0] == NULL){
     $object_return_params[0] = " deleted=0 ";
     }

  if (!$valtype){

     if ($sess_account_id != NULL){
        $valtype = 'Accounts';
        $object_return_params[0] .= " && account_id_c='".$sess_account_id."' ";
        }

     }

  if ($action != 'view' && $sess_account_id != NULL){
    # $object_return_params[0] = " deleted=0 && (account_id_c='".$sess_account_id."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ";
     $object_return_params[0] .= " && account_id_c='".$sess_account_id."' ";

     } elseif ($action != 'view' && $sess_account_id == NULL && $portal_account_id != NULL){
#     $object_return_params[0] = " deleted=0 && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ";
     $object_return_params[0] .= " && account_id_c='".$portal_account_id."' ";
#    } elseif ($action != 'view' && $sess_account_id != NULL && $auth < 3){
#     $object_return_params[0] = " deleted=0 ";
     } else {
     $object_return_params[0] .= " && cmn_statuses_id_c !='".$standard_statuses_closed."' ";
     } 

  if (($valtype == 'Events' || $valtype == 'Effects') && $val != NULL){
     $sclm_events_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('Effects', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'Projects' && $val != NULL && $val != ''){
     $project_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('Projects', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'ProjectTasks' && $val != NULL){
     $projecttask_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('ProjectTasks', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'SOW' && $val != NULL){
     $sclm_sow_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('SOW', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'ServicesPrices' && $val != NULL){
     $sclm_servicesprices_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ($valtype, $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'Services' && $val != NULL){
     $sclm_services_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ($valtype, $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'AccountsServices' && $val != NULL){
     $sclm_accountsservices_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ($valtype, $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'Advisory' && $val != NULL){
     $sclm_advisory_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ($valtype, $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'SOWItems' && $val != NULL){
     $sclm_sowitems_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('SOWItems', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'ConfigurationItemTypes' && $val != NULL){
     $sclm_configurationitemtypes_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('ConfigurationItemTypes', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'SocialNetworking' && $val != NULL){
     $social_networking_id = $val;
     $object_return_params[0] = " deleted=0 && social_networking_id='".$val."' ";
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('ConfigurationItems', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  if ($valtype == 'ConfigurationItems' && $val != NULL){
     $sclm_configurationitems_id_c = $val;
     if ($action == 'add'){
        $returner = $funky_gear->object_returner ('ConfigurationItems', $val);
        $object_return_name = $returner[0];
        $object_return = $returner[1];
        echo $object_return;
        }
     }

  $keyword = $_POST['keyword'];
  if (!$keyword){
     $keyword = $_GET['keyword'];
     }

  if ($action == 'search' && $keyword != NULL){

     $vallength = strlen($keyword);
     $object_return_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' )";

     if ($sess_account_id != NULL){
        $object_return_params[0] .= " && account_id_c='".$sess_account_id."' ";
        } else {
        $object_return_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
        } 

     } # if search

  if (!$lingo){
     $lingo = "en";
     }

  $contentdiv = $_POST['contentdiv'];
  if (!$contentdiv){
     $contentdiv = $_GET['contentdiv'];
     }

  $lingoname = "name_".$lingo;

  # Set up the column headers
  $divstyle_params[0] = "152px"; // minwidth
  $divstyle_params[1] = "160px"; // minheight
  $divstyle_params[2] = "2px"; // margin_left
  $divstyle_params[3] = "2px"; // margin_right
  $divstyle_params[4] = "2px"; // padding_left
  $divstyle_params[5] = "2px"; // padding_right
  $divstyle_params[6] = "2px"; // margin_top
  $divstyle_params[7] = "2px"; // margin_bottom
  $divstyle_params[8] = "2px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom
  $divstyle_params[10] = $portal_header_colour; // custom_color_back
  #$divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
  $divstyle_params[11] = "#d3d3d3"; // custom_color_border
  $divstyle_params[12] = "left"; // custom_float
  $divstyle_params[13] = "152px"; // maxwidth
  $divstyle_params[14] = "160px"; // maxheight
  $divstyle_params[15] = "10px"; // top_radius
  $divstyle_params[16] = "10px"; // bottom_radius

  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $block_style = $divstyle[5];

  # Set up the column headers
  $divstyle_params[0] = "140px"; // minwidth
  $divstyle_params[1] = "70px"; // minheight
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
  $divstyle_params[13] = "140px"; // maxwidth
  $divstyle_params[14] = "70px"; // maxheight
  $divstyle_params[15] = "5px"; // top_radius
  $divstyle_params[16] = "5px"; // bottom_radius
  $divstyle_params[17] = "hidden"; // oveflow

  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $image_block_style = $divstyle[5];

  switch ($action){
   
   case 'list':
   case 'list_all':
   case 'search':

   if (is_array($sent_params)){    
      $list_type = $sent_params[0];
      }

   if ($list_type == NULL){
      $list_type = "list";
      }

    ################################
    # List

    if ($action == 'search' || $keyword != NULL){
       }

    if ($valtype == 'Content'){
       echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["Content"]."</B></font></center></div>";
       echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
       echo "<center><img src=images/icons/camera_48.png width=48></center>";
       }
 
    $date = date("Y@m@d@G");
    $body_sendvars = $date."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

    $action_search_keyword = $strings["action_search_keyword"];
    $DateStart = $strings["DateStart"];
    $action_search = $strings["action_search"];

$consearch = <<< CONSEARCH
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="text" id="keyword" placeholder="$action_search_keyword" name="keyword" value="$keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="pg" name="pg" value="$body_sendvars" >
     <input type="hidden" id="value" name="value" value="$val" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="$do" >
     <input type="hidden" id="valuetype" name="valuetype" value="$valtype" >
     <input type="button" name="button" value="$action_search" onclick="javascript:loader('$BodyDIV');get(this.parentNode);return false" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
CONSEARCH;

    if ($contentdiv != 'contentdiv'){
       echo $consearch;
       }

    $tasklingoname = "name_".$lingo."_c";

    #########################
    # Looper Content Wrapper

    function wrap_content ($content_params){

    global $divstyle_white,$lingoname,$BodyDIV,$portalcode,$valtype,$sess_contact_id,$strings;
 
    $valtype = $content_params[1];

    $ci_object_type = 'Content';
    $ci_action = "select";
    $ci_params[0] = $content_params[0];
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = $listlimit; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       #$ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

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
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
           $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
           $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
           $content_type = $ci_items[$cnt]['content_type'];
           $content_type_image = $ci_items[$cnt]['content_type_image'];
           $content_type_name = $ci_items[$cnt]['content_type_name'];
           $project_id_c = $ci_items[$cnt]['project_id_c'];
           $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
           $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
           $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
           $content_url = $ci_items[$cnt]['content_url'];
           $content_thumbnail = $ci_items[$cnt]['content_thumbnail'];
           $sclm_emails_id_c = $ci_items[$cnt]['sclm_emails_id_c'];
           $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
           $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
           $sclm_servicesprices_id_c = $ci_items[$cnt]['sclm_servicesprices_id_c'];
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $sclm_events_id_c = $ci_items[$cnt]['sclm_events_id_c'];
           $sclm_configurationitemtypes_id_c = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
           $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];

           $channel = $ci_items[$cnt]['channel'];
           $url = $ci_items[$cnt]['url'];
           $object_type = $ci_items[$cnt]['object_type'];
           $object_value = $ci_items[$cnt]['object_value'];
           $fee_type_id = $ci_items[$cnt]['fee_type_id'];
           $media_type_id = $ci_items[$cnt]['media_type_id'];
           $view_count = $ci_items[$cnt]['view_count'];
           $cmv_newscategories_id_c = $ci_items[$cnt]['cmv_newscategories_id_c'];
           $cmv_newstypes_id_c = $ci_items[$cnt]['cmv_newstypes_id_c'];
           $cmv_causes_id_c = $ci_items[$cnt]['cmv_causes_id_c'];
           $cmv_governments_id_c = $ci_items[$cnt]['cmv_governments_id_c'];
           $cmv_governmenttypes_id_c = $ci_items[$cnt]['cmv_governmenttypes_id_c'];
           $cmv_governmenttenders_id_c = $ci_items[$cnt]['cmv_governmenttenders_id_c'];
           $cmv_governmentroles_id_c = $ci_items[$cnt]['cmv_governmentroles_id_c'];
           $cmv_governmentpolicies_id_c = $ci_items[$cnt]['cmv_governmentpolicies_id_c'];
           $cmv_governmentlevels_id_c = $ci_items[$cnt]['cmv_governmentlevels_id_c'];
           $cmv_governmentconstitutions_id_c = $ci_items[$cnt]['cmv_governmentconstitutions_id_c'];
           $cmv_governmentbranches_id_c = $ci_items[$cnt]['cmv_governmentbranches_id_c'];
           $cmv_independentagencies_id_c = $ci_items[$cnt]['cmv_independentagencies_id_c'];
           $cmv_politicalparties_id_c = $ci_items[$cnt]['cmv_politicalparties_id_c'];
           $cmv_politicalpartyroles_id_c = $ci_items[$cnt]['cmv_politicalpartyroles_id_c'];
           $cmv_branchbodies_id_c = $ci_items[$cnt]['cmv_branchbodies_id_c'];
           $cmv_branchdepartments_id_c = $ci_items[$cnt]['cmv_branchdepartments_id_c'];
           $cmv_constitutionalamendments_id_c = $ci_items[$cnt]['cmv_constitutionalamendments_id_c'];
           $sclm_content_id_c = $ci_items[$cnt]['sclm_content_id_c'];
           $cmv_news_id_c = $ci_items[$cnt]['cmv_news_id_c'];
           $cmv_organisations_id_c = $ci_items[$cnt]['cmv_organisations_id_c'];
           $cmv_constitutionalarticles_id_c = $ci_items[$cnt]['cmv_constitutionalarticles_id_c'];

           $social_networking_id = $ci_items[$cnt]['social_networking_id'];
           $portal_account_id = $ci_items[$cnt]['portal_account_id'];


           if ($content_type_image != NULL){
              $content_type_image = "<img src=".$content_type_image." width=16 border=0>";
              } else {
              $content_type_image = "<img src=images/icons/page.gif width=16 border=0>";
              }

           if ($content_thumbnail != NULL){

              $content_thumbnail = "<a href='".$content_url."' data-lightbox=\"".$valtype."\" title=\"".$name."\"><img src='".$content_thumbnail."' width=32></a></center>";

              } else {

              $content_thumbnail = "";
              $content_type_image = "<a href='".$content_url."' title=\"".$name."\" target=\"".$name."\">".$content_type_image."</a>";
              }

           #echo "$sess_contact_id != NULL && $sess_contact_id == $contact_id_c <BR>";

           $edit = "";
           if ($sess_contact_id != NULL && $sess_contact_id == $contact_id_c || $auth == 3){
              $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=edit&value=".$id."&valuetype=Content');return false\"><font color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           if ($ci_items[$cnt][$lingoname] != NULL){
              $name = $ci_items[$cnt][$lingoname];
              }

           $cis .= "<div style=\"".$divstyle_white."\"><img src=images/blank.gif width=40 height=1>".$content_type_image." ".$content_thumbnail." ".$edit." <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$id."&valuetype=Content');return false\"><B>".$name."</B></a></div>";


           } // for

       } // array

    return $cis;

    } // wrap content

    #########################
    # Looper Task Wrapper

    function wrap_ctasks ($task_params){

     global $divstyle_white,$BodyDIV,$portalcode,$valtype,$strings,$sess_content_id;

     $lingoname = $task_params[1];

     $valtype = "ProjectTasks";

     $project_task_object_type = 'ProjectTasks';
     $project_task_action = "select_cstm";
     $project_task_params[0] = $task_params[0];
     $project_task_params[1] = ""; // select array
     $project_task_params[2] = ""; // group;
     $project_task_params[3] = ""; // order;
     $project_task_params[4] = ""; // limit
 
     $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);
     $projecttasks = "";

     if (is_array($project_task_items)){

        $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

        for ($task_cnt=0;$task_cnt < count($project_task_items);$task_cnt++){

            $task_id = $project_task_items[$task_cnt]['id_c'];
            $task_name = $project_task_items[$task_cnt][$lingoname];
            if (!$task_name){
               $task_name = $project_task_items[$task_cnt]['name'];
               }

            $projecttasks .= "<div style=\"".$divstyle_white."\"><img src=images/blank.gif width=50 height=1><img src=images/icons/folderopen.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$task_id."&valuetype=".$valtype."');return false\"><B>".$task_name."</B></a></div>";

            $content_params[0] = " deleted=0 && projecttask_id_c='".$task_id."' ";
            $projecttasks_content = wrap_content ($content_params);

            if ($projecttasks_content){
               $projecttasks .= $projecttasks_content;
               }

            } // end for

        } else {// end if array

        $projecttasks = "";

        } 

    return $projecttasks;

    } // end function

    # Function
    ############################
    # Start List All of Projects

    if ($action == 'list_all'){

       $list_menu = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list_all&value=Projects&valuetype=listtype');return false\"><font size=4><B>".$strings['Projects']."</B></font></a>";
       $list_menu .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list_all&value=ProjectTasks&valuetype=listtype');return false\"><font size=4><B>".$strings['ProjectTasks']."</B></font></a>";

       $top_content .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Top Content</B></font></center></div>";
       $top_content .= "<BR><img src=images/blank.gif width=90% height=5><BR>";

       $top_portal_content_type = '4afdc2bb-7359-d4d9-b3e5-52643fce9c30';
       $topdiv_portal_content_type = '69c77ef3-f622-6866-79ca-55006b8d2836';
       $top_content_params[0] = " deleted=0 && (portal_content_type='".$top_portal_content_type."' || portal_content_type='".$topdiv_portal_content_type."' ) && account_id_c='".$sess_account_id."' ";
       $top_content_params[1] = "Content";
       $top_content .= wrap_content ($top_content_params);

       $project_cstm_object_type = 'Projects';
       $project_cstm_action = "select_cstm";
       $project_cstm_params[0] = " account_id_c='".$sess_account_id."' ";
       $project_cstm_params[1] = ""; // select array
       $project_cstm_params[2] = ""; // group;
       $project_cstm_params[3] = ""; // order;
       $project_cstm_params[4] = ""; // limit
       $project_cstm_params[5] = $lingoname; // lingo
  
       $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

       if (is_array($project_cstm_items)){
   
          $count = count($project_cstm_items);

          for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

              $project_id = $project_cstm_items[$cnt]['id_c'];
              $contact_id_c = $project_cstm_items[$cnt]['contact_id_c'];
              $account_id_c = $project_cstm_items[$cnt]['account_id_c'];       
              $project_process_stage_c = $project_cstm_items[$cnt]['project_process_stage_c'];
              $itil_stage_c = $project_cstm_items[$cnt]['itil_stage_c'];

              $project_object_type = "Projects";
              $project_action = "select";
              $project_params[0] = " id='".$project_id."' ";
              $project_params[1] = ""; // select array
              $project_params[2] = ""; // group;
              $project_params[3] = ""; // order;
              $project_params[4] = ""; // limit
  
              $project_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_object_type, $project_action, $project_params);

              if (is_array($project_items)){

                 $project_pack .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Project Content</B></font></center></div>";
                 $project_pack .= "<BR><img src=images/blank.gif width=90% height=5><BR>";

                 for ($prj_cnt=0;$prj_cnt < count($project_items);$prj_cnt++){

                     $project_name = "";
                     $project_id = $project_items[$prj_cnt]['id'];
                     $project_name = $project_items[$prj_cnt]['name'];

                     if ($project_items[$prj_cnt][$lingoname] != NULL){
                        $project_name = $project_items[$prj_cnt][$lingoname];
                        }

                     $project_task_object_type = 'ProjectTasks';
                     $project_task_action = "select";
                     $project_task_params[0] = " project_id='".$project_id."' ";
                     $project_task_params[1] = ""; // select array
                     $project_task_params[2] = ""; // group;
                     $project_task_params[3] = ""; // order;
                     $project_task_params[4] = ""; // limit
  
                     $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);
                     $projecttasks = "";

                     if (is_array($project_task_items)){

                        $count = count($project_task_items);
                        $page = $_POST['page'];
                        $glb_perpage_items = 50;

                        $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
                        $lfrom = $navi_returner[0];
                        $navi = $navi_returner[1];

                        $project_pack .= $navi;

                        $project_task_params[4] = " $lfrom , $glb_perpage_items "; 

                        $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);
                        for ($task_cnt=0;$task_cnt < count($project_task_items);$task_cnt++){

                            $task_id = $project_task_items[$task_cnt]['id'];
                            $task_name = $project_task_items[$task_cnt]['name'];

                            $projecttasks .= "<div style=\"".$divstyle_white."\"><img src=images/blank.gif width=20><img src=images/icons/folderopen.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$task_id."&valuetype=".$valtype."');return false\"><B>".$task_name."</B></a></div>";

                            $content_params[0] = " deleted=0 && projecttask_id_c='".$task_id."' ";
                            $content_params[1] = "ProjectTasks";
                            $projecttasks_content = wrap_content ($content_params);

                            if ($projecttasks_content){
                               $projecttasks .= $projecttasks_content;
                               }

                            $task_params[0] = " projecttask_id_c='".$task_id."' ";
                            $task_params[1] = $tasklingoname;
                            $parent_projecttasks = wrap_ctasks ($task_params);
                            $projecttasks .= $parent_projecttasks;

                            } // end for

                        $projects_content_params[0] = " deleted=0 && project_id_c='".$project_id."' ";
                        $projects_content_params[1] = "Projects";
                        $projects_content = wrap_content ($projects_content_params);

                        } else {// end if array

                        $project_pack .= "<div style=\"".$divstyle_white."\"><img src=images/icons/folder.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Projects&action=view&value=".$project_id."&valuetype=".$valtype."');return false\"><B>".$project_name."</B></a></div>";

                        } 

                     } // end for

                 } // end if

              $sow_object_type = 'SOW';
              $sow_action = "select";
              $sow_params[0] = "project_id_c='".$project_id."' ";
              $sow_params[1] = "id,name"; // select array
              $sow_params[2] = ""; // group;
              $sow_params[3] = ""; // order;
              $sow_params[4] = ""; // limit
  
              $sow = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sow_object_type, $sow_action, $sow_params);

              if (is_array($sow)){

                 $sowitems_content .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>SOW Content</B></font></center></div>";
                 $sowitems_content .= "<BR><img src=images/blank.gif width=90% height=5><BR>";

                 for ($cnt=0;$cnt < count($sow);$cnt++){

                     $sow_id = $sow[$cnt]['id'];
                     $sow_name = $sow[$cnt]['name'];

                     $sowitems_content .= "<div style=\"".$divstyle_white."\"><img src=images/blank.gif width=20><img src=images/icons/folderopen.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SOW&action=view&value=".$sow_id."&valuetype=".$valtype."');return false\"><B>".$sow_name."</B></a></div>";
                     // Get Items
 
                     $sow_items_object_type = 'SOWItems';
                     $sow_items_action = "select";
                     $sow_items_params[0] = "sclm_sow_id_c='".$sow_id."' ";
                     $sow_items_params[1] = "id,name"; // select array
                     $sow_items_params[2] = ""; // group;
                     $sow_items_params[3] = ""; // order;
                     $sow_items_params[4] = ""; // limit
  
                     $sow_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sow_items_object_type, $sow_items_action, $sow_items_params);

                     if (is_array($sow_items)){

                        for ($sow_items_cnt=0;$sow_items_cnt < count($sow_items);$sow_items_cnt++){

                            $sclm_sowitems_id_c = $sow_items[$sow_items_cnt]['id'];
                            $sclm_sowitems_name = $sow_items[$sow_items_cnt]['name'];

                            $sowitems_content .= "<div style=\"".$divstyle_white."\"><img src=images/blank.gif width=20><img src=images/icons/folderopen.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=SOW&action=view&value=".$sclm_sowitems_id_c."&valuetype=".$valtype."');return false\"><B>".$sclm_sowitems_name."</B></a></div>";

                            $sow_content_params[0] = " deleted=0 && sclm_sowitems_id_c='".$sclm_sowitems_id_c."' ";
                            $sow_content_params[1] = "SOWItems";
                            $sowitems_content .= wrap_content ($sow_content_params);                         

                            } // for sow_items

                        } // is array

                     } // for sow

                 } // is array

              } // end for

          } // is array

       if ($top_content != NULL || $projects_content != NULL || $projecttasks != NULL || $sowitems_content != NULL){
          
          $project_pack = $top_content.$project_pack;
          $project_pack .= "<div style=\"".$divstyle_white."\"><img src=images/icons/folderopen.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Projects&action=view&value=".$project_id."&valuetype=".$valtype."');return false\"><B>".$project_name."</B></a></div>".$projects_content.$projecttasks.$sowitems_content;

          } elseif ($sess_account_id != NULL && ($projects_content == NULL && $projecttasks == NULL && $sowitems_content == NULL)) {

          $acc_content_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' ";
          $acc_content_params[1] = "Accounts";
          $accounts_content = wrap_content ($acc_content_params);   
          $acc_returner = $funky_gear->object_returner ("Accounts", $sess_account_id);
          $acc_name = $acc_returner[0];

          echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Account Content</B></font></center></div>";
          echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

          $project_pack .= "<div style=\"".$divstyle_white."\"><img src=images/icons/folderopen.gif><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=".$sess_account_id."&valuetype=".$valtype."');return false\"><B>".$acc_name."</B></a></div>".$accounts_content;

          }

       echo $project_pack;

       } // if action = list_all

    # 
    ##############################
    # Content Listing

    #echo "Query: ".$object_return_params[0]."<BR>";

    if ($action == 'list'){

       $ci_object_type = 'Content';
       $ci_action = "select";
       $ci_params[0] = " deleted=0 && ".$object_return_params[0];
       $ci_params[1] = "id,name,name_en,name_ja,content_type,content_url,content_thumbnail,account_id_c,contact_id_c,media_type_id,view_count,channel,name_en,name_ja"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = $listlimit; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          $count = count($ci_items);
          $page = $_POST['page'];
          $glb_perpage_items = 20;

          $extraparams[0] = "&contentdiv=contentdiv";
          $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,'contentdiv',$extraparams);
          $lfrom = $navi_returner[0];
          $navi = $navi_returner[1];

          #echo $navi;

          $ci_params[4] = " $lfrom , $glb_perpage_items "; 

          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $account_id_c = $ci_items[$cnt]['account_id_c'];
              $contact_id_c = $ci_items[$cnt]['contact_id_c'];

              $content_type = $ci_items[$cnt]['content_type'];
              $content_type_image = $ci_items[$cnt]['content_type_image'];
              $content_type_name = $ci_items[$cnt]['content_type_name'];

              $content_url = $ci_items[$cnt]['content_url'];
              $content_thumbnail = $ci_items[$cnt]['content_thumbnail'];

              $channel = $ci_items[$cnt]['channel'];

              /*
              $url = $ci_items[$cnt]['url'];
              $object_type = $ci_items[$cnt]['object_type'];
              $object_value = $ci_items[$cnt]['object_value'];
              $fee_type_id = $ci_items[$cnt]['fee_type_id'];

              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $description = $ci_items[$cnt]['description'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];

              $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
              $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
              $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
              $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];

              $project_id_c = $ci_items[$cnt]['project_id_c'];
              $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
              $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
              $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
              $sclm_emails_id_c = $ci_items[$cnt]['sclm_emails_id_c'];
              $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
              $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
              $sclm_servicesprices_id_c = $ci_items[$cnt]['sclm_servicesprices_id_c'];
              $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
              $sclm_events_id_c = $ci_items[$cnt]['sclm_events_id_c'];
              $sclm_configurationitemtypes_id_c = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
              $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];

              $cmv_newscategories_id_c = $ci_items[$cnt]['cmv_newscategories_id_c'];
              $cmv_newstypes_id_c = $ci_items[$cnt]['cmv_newstypes_id_c'];
              $cmv_causes_id_c = $ci_items[$cnt]['cmv_causes_id_c'];
              $cmv_governments_id_c = $ci_items[$cnt]['cmv_governments_id_c'];
              $cmv_governmenttypes_id_c = $ci_items[$cnt]['cmv_governmenttypes_id_c'];
              $cmv_governmenttenders_id_c = $ci_items[$cnt]['cmv_governmenttenders_id_c'];
              $cmv_governmentroles_id_c = $ci_items[$cnt]['cmv_governmentroles_id_c'];
              $cmv_governmentpolicies_id_c = $ci_items[$cnt]['cmv_governmentpolicies_id_c'];
              $cmv_governmentlevels_id_c = $ci_items[$cnt]['cmv_governmentlevels_id_c'];
              $cmv_governmentconstitutions_id_c = $ci_items[$cnt]['cmv_governmentconstitutions_id_c'];
              $cmv_governmentbranches_id_c = $ci_items[$cnt]['cmv_governmentbranches_id_c'];
              $cmv_independentagencies_id_c = $ci_items[$cnt]['cmv_independentagencies_id_c'];
              $cmv_politicalparties_id_c = $ci_items[$cnt]['cmv_politicalparties_id_c'];
              $cmv_politicalpartyroles_id_c = $ci_items[$cnt]['cmv_politicalpartyroles_id_c'];
              $cmv_branchbodies_id_c = $ci_items[$cnt]['cmv_branchbodies_id_c'];
              $cmv_branchdepartments_id_c = $ci_items[$cnt]['cmv_branchdepartments_id_c'];
              $cmv_constitutionalamendments_id_c = $ci_items[$cnt]['cmv_constitutionalamendments_id_c'];
              $sclm_content_id_c = $ci_items[$cnt]['sclm_content_id_c'];
              $cmv_news_id_c = $ci_items[$cnt]['cmv_news_id_c'];
              $cmv_organisations_id_c = $ci_items[$cnt]['cmv_organisations_id_c'];
              $cmv_constitutionalarticles_id_c = $ci_items[$cnt]['cmv_constitutionalarticles_id_c'];
           */

              $media_type_id = $ci_items[$cnt]['media_type_id'];
              $view_count = $ci_items[$cnt]['view_count'];


              if ($content_type_image != NULL){
                 $content_type_image = "<img src=".$content_type_image." width=16 border=0>";
                 } else {
                 $content_type_image = "<img src=images/icons/page.gif width=16 border=0>";
                 }

              if ($content_type == '1b7369c3-dd78-a8a3-2a79-523876ce70fe' && $content_thumbnail != NULL){

                 $content_thumbnail = "<a href='".$content_url."' data-lightbox=\"".$valtype."\" title=\"".$name."\"><img src='".$content_thumbnail."' width=128 alt=\"".$name."\"></a>";

                 } elseif ($content_type != '1b7369c3-dd78-a8a3-2a79-523876ce70fe' && $content_thumbnail != NULL) {

                 $content_thumbnail = "<img src='".$content_thumbnail."' width=128 alt=\"".$name."\">";

                 } else {

                 $content_thumbnail = "<img src=images/blank.gif width=128>";
                 $content_type_image = "<a href='".$content_url."' title=\"".$name."\" target=\"".$name."\">".$content_type_image."</a>";
   
                 }

              if ($ci_items[$cnt][$lingoname] != NULL){
                 $name = $ci_items[$cnt][$lingoname];
                 }

               if ($auth >= 3){
                  $show_id = "[".$id."]";
                  }

              $edit = "";

              if ($sess_contact_id != NULL && $sess_contact_id==$contact_id_c){
   
                 $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";

                 }

              #$date_modified = substr($date_modified, 0, 16);
              #$cis .= "<div style=\"".$divstyle_white."\">".$content_type_image." ".$content_thumbnail." ".$date_modified." ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$content_type."&valuetype=ConfigurationItems');return false\">".$content_type_name."</a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a>".$show_id."</div>";

              #$cis .= "<div style=\"".$divstyle_white."\">".$content_type_image." ".$content_thumbnail." ".$date_modified." ".$edit." ".$content_type_name." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a>".$show_id."</div>";
              $cis .= "<div style=\"".$block_style."\"><div style=\"".$image_block_style."\"><center>".$content_thumbnail."</center></div><BR><div style=\"".$image_block_style."\">".$content_type_image." ".$date_modified." ".$edit." ".$content_type_name." <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a>".$show_id."</div></div>";

              } // end for
      
          } else { // end if array

          $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

          }

       if ($sess_contact_id != NULL){    
          $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
          }

       echo "<div id=contentdiv name=contentdiv style=\"margin-left:auto;margin-right:auto\"><center>".$navi.$addnew.$cis.$navi."</center></div>";

       } // end if list

    ##############################
    # Content Listing

    if ($sess_contact_id != NULL && $valtype != NULL && $val != NULL && $contentdiv != 'contentdiv'){

       $content_sendvars = "Uploader@".$lingo."@".$do."@".$action."@".$val."@".$valtype."@".$sess_contact_id."@".$sess_account_id;

       $content_sendvars = $funky_gear->encrypt($content_sendvars);

       echo "<iframe src='tr.php?cn=".$content_sendvars."' height=200 width=98%></iframe>";

       } elseif ($sess_account_id != NULL && $contentdiv != 'contentdiv'){

       $content_sendvars = "Uploader@".$lingo."@".$do."@".$action."@".$sess_account_id."@Accounts@".$sess_contact_id."@".$sess_account_id;
       $content_sendvars = $funky_gear->encrypt($content_sendvars);

       echo "<iframe src='tr.php?cn=".$content_sendvars."' height=200 width=98%></iframe>";

       } 

   # End List
   ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    $ci_object_type = "Content";
    $ci_action = "select";

    if ($action == 'edit'){ 

       echo "<center><input onclick=\"createEditor();\" type=\"button\" class=\"css3button\" value=\"".$strings["HTMLEditorShow"]."\"><input onclick=\"removeEditor();\" type=\"button\" class=\"css3button\" value=\"".$strings["HTMLEditorHide"]."\"><BR>".$strings["HTMLEditorCopyMessage"]."</center><P>";

       #echo "<center><a href=\"#Top\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Content&action=load_editor&value=".$val."&valuetype=Content&sendiv=light');document.getElementById('fade').style.display='block';return false\">Load Content with Editor</a></center><P>";

#echo "<center><a href=\"#Top\" class=\"button\" pg=\"Body.php?pc=".$portalcode."&do=Content&action=load_editor&value=".$val."&valuetype=Content&sendiv=light\" divid=\"".$BodyDIV."\">Load Content with Editor</a></center><P>";

       $ci_params[0] = " id='".$val."' ";

       } elseif ($action == 'view'){

       # IF first time and content available
       # Portal No Login Content (Top Div) | ID: 69c77ef3-f622-6866-79ca-55006b8d2836
       $top_portal_content_type = '4afdc2bb-7359-d4d9-b3e5-52643fce9c30';

       if ($valtype == 'Accounts'){

          $ci_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && portal_content_type='".$top_portal_content_type."' && account_id_c='".$val."' " ;

          } else {# if account

          $ci_params[0] = " id='".$val."' ";

          } # if acc

       } else {# edit/view
       $ci_params[0] = "id='ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ'";
       } 

    if ($_POST['div'] == 'light'){

       echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       } # light div

/*
 <div id="mychat"></div>
<script type="text/javascript">
  $('#mychat').phpfreechat({ serverUrl: 'chat/server' });
</script>
*/



       #$ci_params[1] = "id,name,date_entered,date_modified,modified_user_id,created_by,description,deleted,assigned_user_id,account_id_c,contact_id_c,cmn_industries_id_c,cmn_countries_id_c,cmn_languages_id_c,sclm_advisory_id_c,portal_content_type,content_type,cmn_statuses_id_c,project_id_c,projecttask_id_c,sclm_sow_id_c,sclm_sowitems_id_c,content_url,content_thumbnail,sclm_ticketing_id_c,sclm_ticketingactivities_id_c,sclm_advisory_id_c,sclm_accountsservices_id_c,sclm_servicesprices_id_c,sclm_services_id_c,sclm_events_id_c,sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,channel,url,object_type,object_value,fee_type_id,media_type_id,view_count,cmv_causes_id_c,sclm_content_id_c,name,name_en,name_ja,description,description_en,description_ja"; // select array
       $ci_params[1] = "*";
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       $name_field_base = "name_";
       $content_field_base = "description_";

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $content_id = $id;
              $name = $ci_items[$cnt]['name'];
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $description = $ci_items[$cnt]['description'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $account_id_c = $ci_items[$cnt]['account_id_c'];
              $contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
              $parent_industry_id = $ci_items[$cnt]['parent_industry_id'];
              $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
              $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
              $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
              $portal_content_type = $ci_items[$cnt]['portal_content_type'];
              $content_type = $ci_items[$cnt]['content_type'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $project_id_c = $ci_items[$cnt]['project_id_c'];
              $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
              $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
              $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];

              $content_url = $ci_items[$cnt]['content_url'];
              $content_thumbnail = $ci_items[$cnt]['content_thumbnail'];

              $sclm_ticketing_id_c = $ci_items[$cnt]['sclm_ticketing_id_c'];
              $sclm_ticketingactivities_id_c = $ci_items[$cnt]['sclm_ticketingactivities_id_c'];
              $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
              $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
              $sclm_servicesprices_id_c = $ci_items[$cnt]['sclm_servicesprices_id_c'];
              $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
              $sclm_events_id_c = $ci_items[$cnt]['sclm_events_id_c'];
              $sclm_configurationitemtypes_id_c = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
              $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];

              $channel = $ci_items[$cnt]['channel'];
              $url = $ci_items[$cnt]['url'];
              $object_type = $ci_items[$cnt]['object_type'];
              $object_value = $ci_items[$cnt]['object_value'];
              $fee_type_id = $ci_items[$cnt]['fee_type_id'];
              $media_type_id = $ci_items[$cnt]['media_type_id'];
              $view_count = $ci_items[$cnt]['view_count'];
              $cmv_causes_id_c = $ci_items[$cnt]['cmv_causes_id_c'];
              $sclm_content_id_c = $ci_items[$cnt]['sclm_content_id_c'];

              /*
              $cmv_newscategories_id_c = $ci_items[$cnt]['cmv_newscategories_id_c'];
              $cmv_newstypes_id_c = $ci_items[$cnt]['cmv_newstypes_id_c'];
              $cmv_governments_id_c = $ci_items[$cnt]['cmv_governments_id_c'];
              $cmv_governmenttypes_id_c = $ci_items[$cnt]['cmv_governmenttypes_id_c'];
              $cmv_governmenttenders_id_c = $ci_items[$cnt]['cmv_governmenttenders_id_c'];
              $cmv_governmentroles_id_c = $ci_items[$cnt]['cmv_governmentroles_id_c'];
              $cmv_governmentpolicies_id_c = $ci_items[$cnt]['cmv_governmentpolicies_id_c'];
              $cmv_governmentlevels_id_c = $ci_items[$cnt]['cmv_governmentlevels_id_c'];
              $cmv_governmentconstitutions_id_c = $ci_items[$cnt]['cmv_governmentconstitutions_id_c'];
              $cmv_governmentbranches_id_c = $ci_items[$cnt]['cmv_governmentbranches_id_c'];
              $cmv_independentagencies_id_c = $ci_items[$cnt]['cmv_independentagencies_id_c'];
              $cmv_politicalparties_id_c = $ci_items[$cnt]['cmv_politicalparties_id_c'];
              $cmv_politicalpartyroles_id_c = $ci_items[$cnt]['cmv_politicalpartyroles_id_c'];
              $cmv_branchbodies_id_c = $ci_items[$cnt]['cmv_branchbodies_id_c'];
              $cmv_branchdepartments_id_c = $ci_items[$cnt]['cmv_branchdepartments_id_c'];
              $cmv_constitutionalamendments_id_c = $ci_items[$cnt]['cmv_constitutionalamendments_id_c'];
              $cmv_news_id_c = $ci_items[$cnt]['cmv_news_id_c'];
              $cmv_organisations_id_c = $ci_items[$cnt]['cmv_organisations_id_c'];
              $cmv_constitutionalarticles_id_c = $ci_items[$cnt]['cmv_constitutionalarticles_id_c'];
              */
 
              $social_networking_id = $ci_items[$cnt]['social_networking_id'];
              $portal_account_id = $ci_items[$cnt]['portal_account_id'];

              # Get lingo

              if ($action == 'view'){

                 if ($ci_items[$cnt][$lingoname] != NULL){
                    $show_name = $ci_items[$cnt][$lingoname];
                    } else {
                    $show_name = $name;
                    }

                 if ($ci_items[$cnt][$lingodesc] != NULL){
                    $show_description = $ci_items[$cnt][$lingodesc];
                    } else {
                    $show_description = $description;
                    }

                 } elseif ($action == 'edit'){

                 for ($x=0;$x<count($lingos);$x++) {

                     $extension = $lingos[$x][0][0][0][0][0][0];

                     if ($name_field_base == "name_x_c"){

                        $name_field_lingo = "name_".$extension."_c";
                        $content_field_lingo = "description_".$extension."_c";
          
                        } else {

                        $name_field_lingo = $name_field_base.$extension;
                        $content_field_lingo = $content_field_base.$extension;

                        } 

                     if ($ci_items[$cnt][$name_field_lingo] == NULL){
                        $name_field_lingo = $ci_items[$cnt]['name'];
                        } else {
                        $name_field_lingo = $ci_items[$cnt][$name_field_lingo];
                        } 

                     if ($ci_items[$cnt][$content_field_lingo] == NULL){
                        $content_field_lingo = $ci_items[$cnt]['description']; 
                        } else {
                        $content_field_lingo = $ci_items[$cnt][$content_field_lingo];
                        } 

                     } # for lingos

                 } # if edit

              # Get lingo

              } // end for

          # Gather data

          $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$content_field_base);

          } elseif ($action != 'add') {// is array

          # Nothing to view or edit
          $this->funkydone ($POST,$lingo,'Content','list',$portal_account_id,'Accounts',$sent_params);
          exit;

          } 

    /*
    $anon_params[0] = $contact_id_c;
    $show_names = $funky_gear->anonymity($anon_params);
    $show_name = $show_names['default_name'];
    $anonymity = $show_names['default_name_anonymity'];

    if ($contact_id_c != NULL && $anonymity == $anonymity_Fullname){

       #$object_type = "Contacts";
       #$contact_action = "get_account_id";
       #$contact_action_params = array();
       #$contact_action_params[0] = $contact_id_c;
       #$account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $contact_action, $contact_action_params);

       if ($account_id_c != NULL){

          $account_object_returner = $funky_gear->object_returner ('Accounts',$account_id_c);
          $account_info = $account_object_returner[0];
          $object_return_targets .= $account_object_returner[1]." + ";

          } # if

       } # if contact

    */

    if ($sclm_events_id_c != NULL){
       $content_object_returner = $funky_gear->object_returner ('Effects',$sclm_events_id_c);
       $object_return_targets .= $content_object_returner[1];
       }

    if ($cmn_countries_id_c != NULL){
       $content_object_returner = $funky_gear->object_returner ('Countries',$cmn_countries_id_c);
       $object_return_targets .= $content_object_returner[1];
       }

    if ($cmv_causes_id_c != NULL){
       $content_object_returner = $funky_gear->object_returner ('Causes',$cmv_causes_id_c);
       $object_return_targets .= $content_object_returner[1];
       }

    $content_object_returner = $funky_gear->object_returner ('Contacts',$contact_id_c);
    $contact_info = $content_object_returner[0];

    # Prepare content for adding or editing

    if (($sess_account_id != NULL && ($action == 'edit' || $action == 'add')) || ($action == 'view')){

       ##########################################
       # Begin Form Building

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

       if ($valtype == 'SocialNetworking'){
          $social_networking_id = $val;
          }

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
       $tablefields[$tblcnt][12] = "50"; // Field Length
       $tablefields[$tblcnt][20] = "name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

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

       #echo "sclm_events_id_c $sclm_events_id_c <BR>";
       #echo "action $action <BR>";

       if ($sclm_events_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_events_id_c'; // Field Name
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

          if ($auth==3){
             $tablefields[$tblcnt][9][4] = "";//$exception;
             } elseif ($auth==2) { 
             $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."' ";
             } else {
             $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."' ";
             }

          $tablefields[$tblcnt][9][5] = $sclm_events_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Events';
          $tablefields[$tblcnt][9][7] = "sclm_events"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'Events'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_events_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_events_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_events_id_c; //$field_value;

          }

       if ($sclm_services_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_services_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Services"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_services'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_services_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Services';
          $tablefields[$tblcnt][9][7] = "sclm_services"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'Services'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_services_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_services_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;

          }

       if ($sclm_accountsservices_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_accountsservices_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["AccountsServices"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_accountsservices'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_accountsservices_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'AccountsServices';
          $tablefields[$tblcnt][9][7] = "sclm_accountsservices"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'AccountsServices'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_accountsservices_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_accountsservices_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_accountsservices_id_c; //$field_value;

          }

       if ($sclm_servicesprices_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_servicesprices_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["ServicesPrices"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_servicesprices'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_servicesprices_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'ServicesPrices';
          $tablefields[$tblcnt][9][7] = "sclm_servicesprices"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'ServicesPrices'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_servicesprices_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_servicesprices_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_servicesprices_id_c; //$field_value;

          }

       if ($sclm_advisory_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_advisory_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Advisory"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_advisory'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_advisory_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Advisory';
          $tablefields[$tblcnt][9][7] = "sclm_advisory"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'Advisory'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_advisory_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_advisory_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_advisory_id_c; //$field_value;

          }

       if ($project_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'project_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["Project"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'project,project_cstm'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$sess_account_id."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $project_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Projects';
          $tablefields[$tblcnt][9][7] = "project"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'Projects'; //new do
          $tablefields[$tblcnt][9][9] = $project_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'project_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $project_id_c; //$field_value;

          }

       if ($projecttask_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'projecttask_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["ProjectTask"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'project_task,project_task_cstm'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " project_task.id=project_task_cstm.id_c && project_task_cstm.account_id_c='".$account_id_c."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $projecttask_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'ProjectTasks';
          $tablefields[$tblcnt][9][7] = "project_task"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'ProjectTasks'; //new do
          $tablefields[$tblcnt][9][9] = $projecttask_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $projecttask_id_c; //$field_value;

          }

       if ($sclm_sow_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_sow_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["SOW"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_sow'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_sow_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'SOW';
          $tablefields[$tblcnt][9][7] = "sclm_sow"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'SOW'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_sow_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_sow_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_sow_id_c; //$field_value;

          }

       if ($sclm_sowitems_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_sowitems_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["SOWItem"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = ''; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_sowitems'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'name';
          $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_sowitems_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'SOWItem';
          $tablefields[$tblcnt][9][7] = "sclm_sowitems"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'SOWItems'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_sowitems_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_sowitems_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_sowitems_id_c; //$field_value;

          }

       if ($sclm_configurationitemtypes_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_configurationitemtypes_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["ConfigurationItemType"]; // Full Name
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
          #$tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_configurationitemtypes_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'ConfigurationItemTypes';
          $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'ConfigurationItemTypes'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_configurationitemtypes_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_configurationitemtypes_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_configurationitemtypes_id_c; //$field_value;

          }

       if ($sclm_configurationitems_id_c != NULL){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'sclm_configurationitemtypes_id_c'; // Field Name
          $tablefields[$tblcnt][1] = $strings["ConfigurationItem"]; // Full Name
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
          $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' ";//$exception;
          $tablefields[$tblcnt][9][5] = $sclm_configurationitems_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
          $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
          $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
          $tablefields[$tblcnt][9][9] = $sclm_configurationitems_id_c; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'sclm_configurationitems_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;

          }

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmn_industries_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Industry"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmn_industries'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($action == 'add'){
          $tablefields[$tblcnt][9][4] = " cmn_industries_id_c='' ";//$exception;
          } else {
          if ($parent_industry_id){
             $tablefields[$tblcnt][9][4] = " cmn_industries_id_c='".$parent_industry_id."' ";//$exception;
             } else {
             $tablefields[$tblcnt][9][4] = "";//$exception;
             } 
          }

       $tablefields[$tblcnt][9][5] = $cmn_industries_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Industries';
       $tablefields[$tblcnt][9][7] = "cmn_industries"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Industries'; //new do
       #$tablefields[$tblcnt][9][9] = $industries_id_c; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'cmn_industries_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $cmn_industries_id_c; //$field_value;

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'portal_content_type'; // Field Name
       $tablefields[$tblcnt][1] = $strings["PortalContentType"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='556c2dbf-b408-8b02-b145-52643eb03113' "; //portal content types;
       $tablefields[$tblcnt][9][5] = $portal_content_type; // Current Value
       #$tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       #$tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       #$tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
       #$tablefields[$tblcnt][9][9] = $content_type; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'portal_content_type';//$field_value_id;
       $tablefields[$tblcnt][21] = $portal_content_type; //$field_value;

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'content_type'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ContentType"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='3b7a44af-b706-4bf4-bbb5-52387652127c' "; //content type;
       $tablefields[$tblcnt][9][5] = $content_type; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       #$tablefields[$tblcnt][9][8] = 'Content'; //new do
       #$tablefields[$tblcnt][9][9] = $content_type; // Current Value
       #$params['content_type'] = $content_type;
       #$params['content_name_field'] = "name";
       #$params['content_name'] = $name;
       #$tablefields[$tblcnt][9][10] = $params; // Various Params
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'content_type';//$field_value_id;
       $tablefields[$tblcnt][21] = $content_type; //$field_value;

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'media_type_id'; // Field Name
       $tablefields[$tblcnt][1] = $strings["MediaType"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       if ($action == 'add'){
          $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
          } else {
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          } 
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='e5744b5d-b34d-ebf3-3c79-54c05f9300d5' "; //content type;
       $tablefields[$tblcnt][9][5] = $media_type_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItemTypes';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
       #$tablefields[$tblcnt][9][8] = 'Content'; //new do
       #$tablefields[$tblcnt][9][9] = $content_type; // Current Value
       #$params['content_type'] = $content_type;
       #$params['content_name_field'] = "name";
       #$params['content_name'] = $name;
       #$tablefields[$tblcnt][9][10] = $params; // Various Params
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'media_type_id';//$field_value_id;
       $tablefields[$tblcnt][21] = $media_type_id; //$field_value;

       if ($action == 'view'){

          $tblcnt++;

          $tablefields[$tblcnt][0] = "content_url"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Content"]; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'external_link';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          #$tablefields[$tblcnt][9][0] = "http://".$hostname."/".$content_url;
          $tablefields[$tblcnt][9][0] = $content_url;
          $tablefields[$tblcnt][9][1] = $name; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = $name;
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = "content_url"; //$field_value_id;
          $tablefields[$tblcnt][21] = $content_url; //$field_value;   

          if ($content_thumbnail){

             $tblcnt++;

             $tablefields[$tblcnt][0] = "content_thumbnail"; // Field Name
             $tablefields[$tblcnt][1] = $strings["Thumbnail"]; // Full Name
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
             $tablefields[$tblcnt][20] = "content_thumbnail"; //$field_value_id;
             $tablefields[$tblcnt][21] = $content_thumbnail; //$field_value;   

             } # if thumbnail

          } elseif ($action == 'edit') {

          $tblcnt++;

          $tablefields[$tblcnt][0] = "content_url"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Content"]; // Full Name
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
          $tablefields[$tblcnt][20] = "content_url"; //$field_value_id;
          $tablefields[$tblcnt][21] = $content_url; //$field_value;   

          $tblcnt++;

          $tablefields[$tblcnt][0] = "content_thumbnail"; // Field Name
          $tablefields[$tblcnt][1] = $strings["Thumbnail"]; // Full Name
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
          $tablefields[$tblcnt][20] = "content_thumbnail"; //$field_value_id;
          $tablefields[$tblcnt][21] = $content_thumbnail; //$field_value;   

          } # if edit/add

      if  ($action == 'view' || $action == 'edit' && ($auth==3 || $sess_account_id == $account_id_c)){

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

          if ($action == 'add'){
             if ($auth==3){
                $tablefields[$tblcnt][9][4] = ""; // exception
                } else {
                $tablefields[$tblcnt][9][4] = "id='".$sess_account_id."'"; // exception
                } 
             } elseif ($action == 'edit'){
             if ($auth==3){
                $tablefields[$tblcnt][9][4] = ""; // exception
                } else {
                $tablefields[$tblcnt][9][4] = "id='".$account_id_c."'"; // exception
                } 
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
          $tablefields[$tblcnt][9][1] = 'contacts'; // If DB, dropdown_table, if List, then array, other related table
          $tablefields[$tblcnt][9][2] = 'id';
          $tablefields[$tblcnt][9][3] = 'first_name';

          if ($action == 'add'){
             if ($auth==3){
                $tablefields[$tblcnt][9][4] = ""; // exception
                } else {
                $tablefields[$tblcnt][9][4] = "id='".$sess_contact_id."'"; // exception
                } 
             } elseif ($action == 'edit'){
             if ($auth==3){
                $tablefields[$tblcnt][9][4] = ""; // exception
                } else {
                $tablefields[$tblcnt][9][4] = "id='".$contact_id_c."'"; // exception
                } 
             } 

          $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Contacts';
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

          } else {

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
       $tablefields[$tblcnt][12] = '65'; // Field Length
       $tablefields[$tblcnt][20] = "description"; //$field_value_id;

       if ($action == 'view'){
          $tablefields[$tblcnt][21] = $show_description; //$field_value;   
          } else {
          $tablefields[$tblcnt][21] = $description; //$field_value;   
          }

       if ($action == 'edit'){

          ################################
          # Loop for allowed languages

          for ($x=0;$x<count($field_lingo_pack);$x++) {

              $name_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0];
              $desc_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0];

              $name_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0];
              $desc_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1];

              $language = $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0];
   
              $tblcnt++;

              $tablefields[$tblcnt][0] = $name_field; // Field Name
              $tablefields[$tblcnt][1] = $strings["Name"]." (".$language.")"; // Full Name
              $tablefields[$tblcnt][2] = 0; // is_primary
              $tablefields[$tblcnt][3] = 0; // is_autoincrement
              $tablefields[$tblcnt][4] = 0; // is_name
              $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
              $tablefields[$tblcnt][6] = '100'; // length
              $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
              $tablefields[$tblcnt][8] = ''; // default
              $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
              $tablefields[$tblcnt][10] = '1';//1; // show in view 
              $tablefields[$tblcnt][11] = $name_content; // Field ID
              $tablefields[$tblcnt][12] = '50'; // Field Length
              $tablefields[$tblcnt][20] = $name_field;//$field_value_id;
              $tablefields[$tblcnt][21] = $name_content; //$field_value; 

              $tblcnt++;

              $tablefields[$tblcnt][0] = $desc_field; // Field Name
              $tablefields[$tblcnt][1] = $strings["Description"]." (".$language.")"; // Full Name
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
              $tablefields[$tblcnt][20] = $desc_field;//$field_value_id;
              $tablefields[$tblcnt][21] = $desc_content; //$field_value;

              } // end for languages

          } // end if edit

       $valpack = "";
       $valpack[0] = $do;
       $valpack[1] = $action;
       $valpack[2] = $valtype;
       $valpack[3] = $tablefields;
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $valpack[5] = ""; // provide add new button

       # Build parent layer
       $zaform = "";
       $zaform = $funky_gear->form_presentation($valpack);

       # End Form Building
       ##########################################

       } # if session

       # Now show for non-owner for normal content view

       switch ($media_type_id){

               case '552529a3-0ebd-286d-b1bc-4e0a0a5fdf8a': // RSS

                $media_type = "RSS";
                $media = "";

               break;
               case '9a69a58c-e552-87a2-fc56-4e09e918ac4e': // RSS

                $media_type = "Link";
                $media = "<a href=\"".$content_url."\" target=\"$portal_title\">".$title."</a>";

               break;
               case 'd66f04ca-fa89-891b-7f75-4e09e9f94e44': // YouTube

                $media_type = "You Tube";
                $media = "<iframe width=\"425\" height=\"349\" src=\"https://www.youtube.com/embed/".$content_url."\" frameborder=\"0\" allowfullscreen></iframe><img src=images/blank.gif width=\"300\" height=\"10\">";

               break;
               case 'edfa1627-fd3c-2ff3-288d-4e09e848d675': // Image

                $media_type = "Photo";

                list($original_width, $original_height, $type, $attr) = getimagesize($content_url);

                $width_ratio = $original_width/450;

                if ($width_ratio>1){
                   $width = 450;
                   $height = ROUND($original_height/$width_ratio,0);
                   } else {
                   $width = $original_width;
                   $height = $original_height;
                   }

                $media = "<a href=\"".$content_url."\" rel=\"lightbox[$id]\" title=\"$title. Photo: $contact_info $account_info \"><img src=\"".$content_url."\" width=\"".$width."\" border=1></a>";

                #$media = "<a href=\"".$media_source."\" rel=\"lightbox[$id]\" title=\"$title. Photo: $contact_info $account_info \"><img src=\"".$media_source."\" border=1></a>";

               break;
               case 'ba090113-6c25-244e-5f4c-4e09fbc5ae84': // Gallery Images

                list($original_width, $original_height, $type, $attr) = getimagesize($content_url);

                $width_ratio = $original_width/450;

                if ($width_ratio>1){
                   $width = 450;
                   $height = ROUND($original_height/$width_ratio,0);
                   } else {
                   $width = $original_width;
                   $height = $original_height;
                   }
 
                $media_type = "Photo";

                $media = "<a href=\"".$content_url."\" rel=\"lightbox[$id]\" title=\"$title. Photo: $contact_info $account_info \"><img src=\"".$content_url."\" width=\"".$width."\" border=1></a>";

                #$media = "<a href=\"".$media_source."\" rel=\"lightbox[$id]\" title=\"$title. Photo: $contact_info $account_info \"><img src=\"".$media_source."\" border=1></a>";

                #$media = "<a href=\"#\" rel=\"lightbox[$id]\" title=\"$title. Photo: $contact_info $account_info \" onClick=\"getjax('embedd.php?do=Content&action=view&valuetype=$valtype&value=$val','".$BodyDIV."');return false\"><img src=\"".$media_source."\" height=\"".$height."\" border=1></a>";

               break;
               case '4f0d4556-68ed-a88b-dad6-4ec501d69ce1': // www.thedailyshow.com

                $media_type = "Daily Show";
                $media = "<embed src=\"".$content_url."\" width=\"425\" height=\"239\" type=\"application/x-shockwave-flash\" allowFullScreen=\"true\" allowScriptAccess=\"always\" base=\".\" flashVars=\"\"></embed>";

               break;
               case 'd125f2f9-38c7-6ddc-26a7-4efcd350d037': // any iframe content

                $media_type = "Content";
                $media = "<iframe width=\"425\" height=\"329\" src=\"".$content_url."\" style=\"border:0;outline:0\" frameborder=\"0\" scrolling=\"no\"></iframe>";

               break;
               case 'e8ec8824-cd43-a71d-959d-5149ec5e67ba': // CNN Videos

                $media_type = "CNN Videos";
                $media = "<object width=\"416\" height=\"234\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" id=\"ep_1055\">
<param name=\"allowfullscreen\" value=\"true\" />
<param name=\"allowscriptaccess\" value=\"always\" />
<param name=\"wmode\" value=\"transparent\" />
<param name=\"movie\" value=\"http://i.cdn.turner.com/cnn/.element/apps/cvp/3.0/swf/cnn_embed_2x_container.swf?site=cnn&profile=desktop&context=embed&videoId=".$content_url."&contentId=".$content_url."\" />
<param name=\"bgcolor\" value=\"#000000\" />
<embed src=\"http://i.cdn.turner.com/cnn/.element/apps/cvp/3.0/swf/cnn_embed_2x_container.swf?site=cnn&profile=desktop&context=embed&videoId=".$content_url."&contentId=".$content_url."\" type=\"application/x-shockwave-flash\" bgcolor=\"#000000\" allowfullscreen=\"true\" allowscriptaccess=\"always\" width=\"416\" wmode=\"transparent\" height=\"234\"></embed></object>";

               break;
               case '454b0f3e-f406-d3ba-3039-4f09a7cefecd': // Guardian Videos

                $media_type = "Guardian Videos";

                $media = "<object width=\"460\" height=\"370\">
	<param name=\"movie\" value=\"http://www.guardian.co.uk/video/embed\"></param>
	<param name=\"allowFullScreen\" value=\"true\"></param>
	<param name=\"allowscriptaccess\" value=\"always\"></param>
	<param name=\"flashvars\" value=\"endpoint=".$content_url."\"></param>
	<embed src=\"http://www.guardian.co.uk/video/embed\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"460\" height=\"370\" flashvars=\"endpoint=".$content_url."\"></embed>
</object>";

               break;
               case '23132202-44c0-2516-952e-51966fde1497': // TEDt

                $media_type = "TED Videos";

                $media = "<iframe src=\"".$content_url."\" width=\"560\" height=\"315\" frameborder=\"0\" scrolling=\"no\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";

               break;
               case 'saloob':

                 // nothing yet

       /*
       $saloobtv_pack = new saloobtv_api ();
       $prov_info = $saloobtv_pack->get_info($prov_url);

       foreach ($prov_info as $za_prov) {
          $api_access = $za_prov['api_access'];
          }
       */  
                list($width, $height, $type, $attr) = getimagesize($content_url);
                if (($width/450)<1){
                   $height = ($width/450)*$height;
                   }


                $media = "<img src=\"".$content_url."\" height=\"".$height."\">";
 
               break; // end if image

              } // end switch

       $new_viewcount = $view_count+1;
       $view_count_show = "[".$strings["Views"].": ".$new_viewcount."]";

       $stream = "<div style=\"background:white;margin-left:2%;margin-right:2%;min-height:40px;border:1px dotted #555;border-radius: 3px; padding: 5px 5px 5px 5px;\"><center><B>".$name." ".$view_count_show."</B></center></div><div style=\"background:white;margin-left:2%;margin-right:2%;min-height:415px;border:1px dotted #555;border-radius: 3px; padding: 5px 5px 5px 5px;\"><center>".$media."<P><B>".$media_type.": ".$contact_info." for ".$account_info." </B></center></div><div style=\"background:white;margin-left:2%;margin-right:2%;border:1px dotted #555;border-radius: 3px; padding: 5px 5px 5px 5px;text-align:left;\">".$buynow_link."</div>";

       # End show for non-owner for normal content view
       ##########################################
       # Final Presentation

       ##################
       # Add View Count

       $content_object_type = "Content";
       $content_action = "update";
       $content_params = array();  
       $content_params = array(
         array('name'=>'id','value' => $val),
         array('name'=>'view_count','value' => $new_viewcount),
       );

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $content_object_type, $content_action, $content_params);

       # End View Count
       ##################
       # Check for HTML

       $desc_length = strlen($show_description);
       $desc_length_strip = strlen(strip_tags($show_description));

       if ($desc_length != $desc_length_strip){
          # IS change from stripping tags
          if ($show_description == str_replace("<br>", "", $show_description)){
             # no breaks;
             #$show_description = str_replace("</br>", "", $show_description);
             #$show_description = str_replace("\n", "<br>", $show_description);
             }

          if ($show_description != str_replace("<p>", "", $show_description)){

             $srv_part_start = "<p style";
             $srv_part_end = "</p>";

             $startcheck = "";
             $endcheck = "";
             $startcheck = "";
             $endcheck = "";
             $startcheck = $funky_gear->replacer($srv_part_start, "", $show_description);
             $endcheck = $funky_gear->replacer($srv_part_end, "", $show_description);

             if ($startcheck == $show_description || $endcheck == $show_description){
                # Do nothing - they don't exist
                } else {
                $startsAt = strpos($show_description, $srv_part_start) + strlen($srv_part_start);
                $endsAt = strpos($show_description, $srv_part_end, $startsAt);
                $inner_content = substr($show_description, $startsAt, $endsAt - $startsAt);
                $show_description = str_replace($inner_content, "ZAZAZAZAZAZAZAZAZA", $show_description);
                $show_description = str_replace("<p>", "", $show_description);
                $show_description = str_replace("</p>", "", $show_description);
                $inner_content = "<p style".$inner_content."</p>";
                $show_description = str_replace("ZAZAZAZAZAZAZAZAZA", $inner_content, $show_description);
                } 

             } 

          } else {
          # No change - check for line breaks
          $show_description = str_replace("\n", "<br>", $show_description);
          }

       # Check for HTML
       ###################
       # Check for Links

       $show_description = preg_replace('|<a (.+?)>|i', '<a $1 target="_blank">', $show_description);

       # End Check for Links
       ###################
       # Check for Image

       if ($content_type_image != NULL){
          $content_type_image = "<img src=".$content_type_image." width=16 border=0>";
          } else {
          $content_type_image = "<img src=images/icons/page.gif width=16 border=0>";
          }

       if ($content_thumbnail != NULL){

          $content_thumbnail = "<a href='".$content_url."' data-lightbox=\"".$valtype."\" title=\"".$name."\"><img src='".$content_thumbnail."' width=32></a></center>";

          } else {

          $content_thumbnail = "";

          if ($valtype == 'Accounts'){
             # Do nothing
             } elseif ($portal_content_type != '69c77ef3-f622-6866-79ca-55006b8d2836') {

             $content_type_image = "<a href='".$content_url."' title=\"".$name."\" target=\"".$name."\">Get raw content: ".$content_type_image."</a>";

             } 

          } # if no thumbnail

       if ($valtype == 'Accounts'){
          # Do nothing
          } elseif ($portal_content_type != '69c77ef3-f622-6866-79ca-55006b8d2836') {

          $edit = "";
          if ($sess_account_id == $account_id_c || $auth==3){
             $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=edit&value=".$val."&valuetype=Content');return false\"><font color=red><B>Edit</B></font></a> ";
             }

          $show_description .= "<div style=\"".$divstyle_white."\"><img src=images/blank.gif width=40 height=1>".$content_type_image." ".$content_thumbnail." ".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Content&action=view&value=".$val."&valuetype=Content');return false\"><B>".$name."</B></a></div>";

          } 

       # End Check for Image
       ###################
       # [Portal Content Types] Portal No Login Content (Top Div) 69c77ef3-f622-6866-79ca-55006b8d2836 

       if ($portal_content_type != '69c77ef3-f622-6866-79ca-55006b8d2836'){
          $content_title = "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$name."</B></font></center></div>";
          $contentform = $content_title."<BR><div style=\"".$divstyle_white."\">".$show_description."</div>";
          } else {
          $contentform = $show_description;
          }

    # End if session user
    ###################
    # Check for Image

    if ($action == 'view' && ($sess_account_id == NULL || $sess_account_id != $account_id_c)) {
       $zaform = $contentform;
       } elseif ($action == 'view' && $sess_account_id == $account_id_c){
       $zaform = $contentform."<BR><img src=images/blank.gif width=98% height=5><BR>".$zaform;
       } elseif ($action == 'edit'){
       $zaform = $zaform;
       } 

    ###################
    # Provide Relationship Connector

    $tablefields = "";

    # Show for everything but top page content - requires no relationships and is annoying!
    if (($sess_contact_id != NULL && $account_id_c == $sess_account_id || $auth==3) && ($action == 'edit' || $action == 'view') && $portal_content_type != '4afdc2bb-7359-d4d9-b3e5-52643fce9c30' && $portal_content_type != '69c77ef3-f622-6866-79ca-55006b8d2836'){

       $warning = "<P>WARNING: Do NOT select from this dropdown list if you do not wish to relate other objects to this content - it is automatically added after you touch the dropdown list.<P>";

       echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$font_color."><B>".$strings["RelatedContent"]."</B></font>".$warning."</center></div>";
       # Show list of related objects
       $ci_object_type = "ConfigurationItems";
       $ci_action = "select";
       $ci_params[0] = " (sclm_configurationitemtypes_id_c='683bb5f7-e1c7-4796-8d23-52b0df65369f' || sclm_configurationitemtypes_id_c='e95a1cfa-f6f9-c6d6-d84b-52b38884257f' || sclm_configurationitemtypes_id_c='daee409c-7ec2-5990-dd63-541ef86047b4' || sclm_configurationitemtypes_id_c='4e6954f5-ceef-c569-ca52-541ef3412e25' || sclm_configurationitemtypes_id_c='823dd4fc-1100-d776-1848-541ef361ed65' ) && account_id_c='".$sess_account_id."' && description='".$val."'"; 
       $ci_params[1] = "id,name,account_id_c,description,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $this_val = $ci_items[$cnt]['name'];
              #$sclm_content_id_c = $ci_items[$cnt]['description'];
              $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
              $sclm_configurationitemtypes_id_c = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

              switch ($sclm_configurationitemtypes_id_c){

               case '683bb5f7-e1c7-4796-8d23-52b0df65369f':

                $this_valuetype = 'ServiceSLARequests';
                $ignore .= " && id != '".$this_val."' ";

               break;
               case 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f':

                $this_valuetype = 'Projects';
                $project_ignore .= " && id_c != '".$this_val."' ";

               break;
               case 'daee409c-7ec2-5990-dd63-541ef86047b4':

                $this_valuetype = 'ProjectTasks';
                $projecttask_ignore .= " && id_c != '".$this_val."' ";

               break;
               case '4e6954f5-ceef-c569-ca52-541ef3412e25':

                $this_valuetype = 'SOW';
                $ignore .= " && id != '".$this_val."' ";

               break;
               case '823dd4fc-1100-d776-1848-541ef361ed65':

                $this_valuetype = 'SOWItems';
                $ignore .= " && id != '".$this_val."' ";

               break;

              } // end switch

              $this_returner = $funky_gear->object_returner ($this_valuetype, $this_val);
              $this_link = $this_returner[1];
              $cis .= "<div style=\"".$divstyle_white."\">".$this_link."</a></div>";

              } // end for

          } // is array

       echo $cis;

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
       $tablefields[$tblcnt][21] = 'RELATIONSHIPS'; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'sentdata'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Module"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jumper';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       # Get list of all ServiceSLARequests this account owns, list them in the ddpack as a selection with explosion

       $ci_object_type = "ServiceSLARequests";
       $ci_action = "select";
       $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' ".$ignore; 
       $ci_params[1] = "id,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "name ASC"; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $dd_pack['683bb5f7-e1c7-4796-8d23-52b0df65369f[]'.$val.'[]'.$id.'[]RELATIONSHIPS'] = $strings["ServiceSLARequests"]." : ".$name;

              } // for

          } // if

       $ci_object_type = "Projects";
       $ci_action = "select_cstm";
       $ci_params[0] = " account_id_c='".$sess_account_id."' ".$project_ignore; 
       $ci_params[1] = "id_c,account_id_c,name_en_c"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "name_en_c ASC"; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id_c'];
              $name = $ci_items[$cnt]['name_en_c'];
              $dd_pack['e95a1cfa-f6f9-c6d6-d84b-52b38884257f[]'.$val.'[]'.$id.'[]RELATIONSHIPS'] = $strings["Projects"]." : ".$name;

              } // for

          } // if

       $ci_object_type = "ProjectTasks";
       $ci_action = "select_cstm";
       $ci_params[0] = " account_id_c='".$sess_account_id."' ".$projecttask_ignore; 
       $ci_params[1] = "id_c,account_id_c,name_en_c"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "name_en_c ASC"; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id_c'];
              $name = $ci_items[$cnt]['name_en_c'];
              $dd_pack['daee409c-7ec2-5990-dd63-541ef86047b4[]'.$val.'[]'.$id.'[]RELATIONSHIPS'] = $strings["ProjectTasks"]." : ".$name;

              } // for

          } // if

       $ci_object_type = "SOW";
       $ci_action = "select";
       $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' ".$ignore; 
       $ci_params[1] = "id,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "name ASC"; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $dd_pack['4e6954f5-ceef-c569-ca52-541ef3412e25[]'.$val.'[]'.$id.'[]RELATIONSHIPS'] = $strings["SOW"]." : ".$name;

              } // for

          } // if

       $ci_object_type = "SOWItems";
       $ci_action = "select";
       $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' ".$ignore; 
       $ci_params[1] = "id,name"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "name ASC"; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $dd_pack['823dd4fc-1100-d776-1848-541ef361ed65[]'.$val.'[]'.$id.'[]RELATIONSHIPS'] = $strings["SOWItems"]." : ".$name;

              } // for

          } // if

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
       $relatevalpack[0] = 'Content';
       $relatevalpack[1] = 'select'; //
       $relatevalpack[2] = $valtype;
       $relatevalpack[3] = $tablefields;
       $relatevalpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $relatevalpack[6] = 'relate'; #

       $relateform = $funky_gear->form_presentation($relatevalpack);

       echo "<div style=\"".$divstyle_blue_light."\" name='RELATIONSHIPS' id='RELATIONSHIPS'>".$relateform."</div>";

       } // end if relationships

    # End Relationships
    #################################
    # 

    if ($content_type == '1b7369c3-dd78-a8a3-2a79-523876ce70fe' && ($action == 'view' || $action == 'edit')){
       #echo "<center><a href=\"".$content_url."\" data-lightbox=\"".$name."\" title=\"".$name."\"><img src=\"".$content_url."\" width=\"400\" border=\"1\"></a></center>";
  
       }

    #if ($sess_contact_id != NULL && $account_id_c == $sess_account_id && ($action == 'edit' || $action == 'view') && $portal_content_type != '4afdc2bb-7359-d4d9-b3e5-52643fce9c30'){

    if (($action == 'edit' || $action == 'view') && $portal_content_type != '4afdc2bb-7359-d4d9-b3e5-52643fce9c30' && $portal_content_type != '69c77ef3-f622-6866-79ca-55006b8d2836' && $val != '9d35be2b-7c56-9a39-b7af-540bc4ce781b' && $val != 'c3593693-a0a4-c389-7d05-541ed5abdfbf'){

       echo $this->funkydone ($_POST,$lingo,'Votes','print_vote',$val,'Content',$bodywidth);
       echo "<BR><img src=\"images/blank.gif\" width=98 height=5><BR>";
       echo $object_return_targets;

       }

    ##############################
    # Top First View Div

    if ($portal_content_type == '69c77ef3-f622-6866-79ca-55006b8d2836'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightpres');cleardiv('fade');document.getElementById('lightpres').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    # End Top First View Div
    ##############################

    if ($content_type != '69c2b932-2e0f-c22c-4313-523876b382ce' && $content_type != '34cf7647-dffa-8516-b25a-527c0b3c5590' && $content_type != '' && $content_type != NULL && $content_type != 'NULL'){
       echo "<BR><img src=\"images/blank.gif\" width=98 height=5><BR>";
       echo $stream;
       echo "<BR><img src=\"images/blank.gif\" width=98 height=5><BR>";
       }

    echo $zaform;

    if ($portal_content_type != '69c77ef3-f622-6866-79ca-55006b8d2836'){

       $params = array();
       $params[0] = $name;
       echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

       }

    #
    ###################
    #

    if ($sess_contact_id != NULL && $account_id_c == $sess_account_id && ($action == 'edit' || $action == 'view') && $sclm_ticketing_id_c != NULL){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Ticketing'; // container_title
       $container_params[4] = 'Ticketing'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'Ticketing','list',$sclm_ticketing_id_c,$do,$bodywidth); 

       echo $container_bottom;

       } // end if contact and account to view extra goodies

//    $params = array();
//    $params[0] = $show_name;
//    echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

    #
    ###################
    #

    /*
    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["Files"]; // container_title
    $container_params[4] = 'Files'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;


    echo $filer_return;

    echo $container_bottom;
    */

    #
    ###################

   break; // end view
   case 'load_editor':

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

   # $ci_object_type = $do;
    #$ci_action = "select";
    #$ci_params[0] = " id='".$val."' ";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    #$content_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($content_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $val = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $date_entered = $ci_items[$cnt]['date_entered'];
           $date_modified = $ci_items[$cnt]['date_modified'];
           $modified_user_id = $ci_items[$cnt]['modified_user_id'];
           $created_by = $ci_items[$cnt]['created_by'];
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
           $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
           $parent_industry_id = $ci_items[$cnt]['parent_industry_id'];
           $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
           $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
           $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
           $portal_content_type = $ci_items[$cnt]['portal_content_type'];
           $content_type = $ci_items[$cnt]['content_type'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $project_id_c = $ci_items[$cnt]['project_id_c'];
           $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
           $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
           $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
           $content_url = $ci_items[$cnt]['content_url'];
           $content_thumbnail = $ci_items[$cnt]['content_thumbnail'];

           if ($ci_items[$cnt][$lingoname] != NULL){
              $show_name = $ci_items[$cnt][$lingoname];
              } else {
              $show_name = $name;
              }

           if ($ci_items[$cnt][$lingodesc] != NULL){
              $show_description = $ci_items[$cnt][$lingodesc];
              } else {
              $show_description = $description;
              }

           } // end for

       $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);

       } // is array

   $header_color = $portal_config['portalconfig']['portal_header_color'];
   $body_color = $portal_config['portalconfig']['portal_body_color'];
   $footer_color = $portal_config['portalconfig']['portal_footer_color'];
   $border_color = $portal_config['portalconfig']['portal_border_color'];

   $divwidth = 470;
   $tdlabelwidth = 85;
   $tdvaluewidth = 350;
   $textboxsize = 68;
   $textareacols = 20;
   $skinfont = "WHITE";

    $form_header = "<form action=\"javascript:get(document.getElementById('".$BodyDIV."'));\" ".$multipart." id=\"Funky\">
<table width=\"95%\" border=\"0\" cellspacing=\"1\" cellpadding=\"1\">";

#    $formobject = "<textarea id=\"".$fieldname."\" name=\"".$fieldname."\"  cols=$textboxsize rows=$textareacols>".$thisvalue."</textarea>";

    $formobject = "";


    $formobject .= "<script type=\"text/javascript\">
	CKEDITOR.replace('description');
</script>";

    $form = "<tr>
 <td>
    <div style=\"max-width:".$divwidth."px;\">
        <div style=\"margin-left:0px;float: left; background:".$header_color."; width:".$tdlabelwidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
            <font color=$skinfont>Description</font></div>
        <div style=\"margin-left:5px;float:left; background:".$body_color."; width:".$tdvaluewidth."px;min-height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;\">
         <textarea id=\"description\" name=\"description\" cols=".$textboxsize." rows=".$textareacols.">".$show_description."</textarea>
         <script type=\"text/javascript\">
	  CKEDITOR.inline('description');
         </script>
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>";

    $button_text = "Edit";

    $button_style ='<style type=\"text/css\">
        .css3button {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #050505;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#ebebeb 50%,
		#dbdbdb 50%,
		#b5b5b5);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#ffffff),
		color-stop(0.50, #ebebeb),
		color-stop(0.50, #dbdbdb),
		to(#b5b5b5));
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	border: 1px solid #949494;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.2),
		0px 1px 0px rgba(255,255,255,1);
}
</style>';


    $formend = "<tr>
 <td>
    <div style=\"width:500px;\">
        <div style=\"margin-left:0px;float: left; width: 115px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
   <input type=hidden id=next_action name=next_action value=process>
   <input type=hidden id=do name=do value=$do>
   <input type=hidden id=rp name=rp value=$portalcode>
  </div>
        <div style=\"float: right; width:400px;height:35;border-radius: 5px; padding: 5px 5px 5px 5px;\">
        </div>
        <div style=\"clear: both;\">
        </div>
    </div>
 </td>
</tr>
</table>".$button_style."
<div><button type=\"button\" name=\"button\" value=\"".$button."\" onclick=\"Scroller();get(this.form);return false\" class=\"css3button\">".$button_text."</div>
</form>";

    echo "  <script src=\"//code.jquery.com/jquery-1.9.1.js\"></script>
  <script src=\"//code.jquery.com/ui/1.10.4/jquery-ui.js\"></script>
  <script src=\"ckeditor/ckeditor.js\"></script>";

    echo "<div style=\"padding-left:1%;\">".$form_header.$form.$formend."</div>";

   break; // end view
   case 'relate':

    $sentdata = $_POST['sentdata'];

    list ($sclm_configurationitemtypes_id_c,$sclm_content_id_c,$id,$sendiv) = explode("[]", $sentdata);

    # Record the new relationship as
    # name = sclm_content_id_c
    # description = related object id
    # type = CI Type

    switch ($sclm_configurationitemtypes_id_c){

     case '683bb5f7-e1c7-4796-8d23-52b0df65369f':

      $this_valuetype = 'ServiceSLARequests';
      #$process_params[] = array('name'=>'project_id_c','value' => $id);

     break;
     case 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f':

      $this_valuetype = 'Projects';
      #$process_params[] = array('name'=>'project_id_c','value' => $id);

     break;
     case 'daee409c-7ec2-5990-dd63-541ef86047b4':

      $this_valuetype = 'ProjectTasks';
      #$process_params[] = array('name'=>'projecttask_id_c','value' => $id);

     break;
     case '4e6954f5-ceef-c569-ca52-541ef3412e25':

      $this_valuetype = 'SOW';
      #$process_params[] = array('name'=>'sclm_sow_id_c','value' => $id);

     break;
     case '823dd4fc-1100-d776-1848-541ef361ed65':

      $this_valuetype = 'SOWItems';
      #$process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $id);

     break;

    } // end switch

    $content_returner = $funky_gear->object_returner ('Content', $sclm_content_id_c);
    $content_name = $content_returner[0];
    $content_return = $content_returner[1];
    echo $content_return;

    $returner = $funky_gear->object_returner ($this_valuetype, $id);
    $object_name = $returner[0];
    $object_return = $returner[1];
    echo $object_return;

    $process_object_type = "ConfigurationItems";
    $process_action = "update";

    $process_params = array();  
    $process_params[] = array('name'=>'id','value' => $_POST['id']);
    $process_params[] = array('name'=>'name','value' => $id);
    $process_params[] = array('name'=>'assigned_user_id','value' => 1);
    $process_params[] = array('name'=>'description','value' => $sclm_content_id_c);
#    $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => );
    $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
    $process_params[] = array('name'=>'account_id_c','value' => $sess_account_id);
    $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $sclm_configurationitemtypes_id_c);

    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($result['id'] != NULL){
       $val = $result['id'];
       }

    $process_message = $strings["SubmissionSuccess"]." for recording relationship of $this_valuetype [$object_name] for Content [$content_name] - <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$this_valuetype."&action=view&value=".$id."&valuetype=".$this_valuetype."');return false\">".$strings["action_view_here"]."</a><P>";

    echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

   break; // end view
   case 'process':

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
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);

       foreach ($_POST as $name_key=>$name_value){

               $name_lingo = str_replace("name_","",$name_key);

               if ($name_lingo != NULL && in_array($name_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$name_key,'value' => $name_value);

                  } // if namelingo

               } // end foreach

       foreach ($_POST as $desc_key=>$desc_value){

               $desc_lingo = str_replace("description_","",$desc_key);

               if ($desc_lingo != NULL && in_array($desc_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$desc_key,'value' => $desc_value);

                  } // if namelingo

               } // end foreach

       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'content_type','value' => $_POST['content_type']);
       $process_params[] = array('name'=>'portal_content_type','value' => $_POST['portal_content_type']);
       $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);
       $process_params[] = array('name'=>'cmn_industries_id_c','value' => $_POST['cmn_industries_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'sclm_advisory_id_c','value' => $_POST['sclm_advisory_id_c']);
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
       $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
       $process_params[] = array('name'=>'content_url','value' => $_POST['content_url']);
       $process_params[] = array('name'=>'content_thumbnail','value' => $_POST['content_thumbnail']);
       $process_params[] = array('name'=>'sclm_advisory_id_c','value' => $_POST['sclm_advisory_id_c']);
       $process_params[] = array('name'=>'sclm_accountsservices_id_c','value' => $_POST['sclm_accountsservices_id_c']);
       $process_params[] = array('name'=>'sclm_servicesprices_id_c','value' => $_POST['sclm_servicesprices_id_c']);
       $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
       $process_params[] = array('name'=>'sclm_events_id_c','value' => $_POST['sclm_events_id_c']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $_POST['sclm_configurationitemtypes_id_c']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['sclm_configurationitems_id_c']);

       #$process_params[] = array('name'=>'channel','value' => $_POST['channel']);
       #$process_params[] = array('name'=>'url','value' => $_POST['url']);
       #$process_params[] = array('name'=>'object_type','value' => $_POST['object_type']);
       #$process_params[] = array('name'=>'object_value','value' => $_POST['object_value']);
       #$process_params[] = array('name'=>'fee_type_id','value' => $_POST['fee_type_id']);
       $process_params[] = array('name'=>'media_type_id','value' => $_POST['media_type_id']);
       #$process_params[] = array('name'=>'view_count','value' => $_POST['view_count']);

       $process_params[] = array('name'=>'cmv_causes_id_c','value' => $_POST['cmv_causes_id_c']);
       $process_params[] = array('name'=>'sclm_content_id_c','value' => $_POST['sclm_content_id_c']);

       $process_params[] = array('name'=>'social_networking_id','value' => $_POST['social_networking_id']);
       $process_params[] = array('name'=>'portal_account_id','value' => $_POST['portal_account_id']);

       /*
       $process_params[] = array('name'=>'cmv_newscategories_id_c','value' => $_POST['cmv_newscategories_id_c']);
       $process_params[] = array('name'=>'cmv_newstypes_id_c','value' => $_POST['cmv_newstypes_id_c']);
       $process_params[] = array('name'=>'cmv_governments_id_c','value' => $_POST['cmv_governments_id_c']);
       $process_params[] = array('name'=>'cmv_governmenttypes_id_c','value' => $_POST['cmv_governmenttypes_id_c']);
       $process_params[] = array('name'=>'cmv_governmenttenders_id_c','value' => $_POST['cmv_governmenttenders_id_c']);
       $process_params[] = array('name'=>'cmv_governmentroles_id_c','value' => $_POST['cmv_governmentroles_id_c']);
       $process_params[] = array('name'=>'cmv_governmentpolicies_id_c','value' => $_POST['cmv_governmentpolicies_id_c']);
       $process_params[] = array('name'=>'cmv_governmentlevels_id_c','value' => $_POST['cmv_governmentlevels_id_c']);
       $process_params[] = array('name'=>'cmv_governmentconstitutions_id_c','value' => $_POST['cmv_governmentconstitutions_id_c']);
       $process_params[] = array('name'=>'cmv_governmentbranches_id_c','value' => $_POST['cmv_governmentbranches_id_c']);
       $process_params[] = array('name'=>'cmv_independentagencies_id_c','value' => $_POST['cmv_independentagencies_id_c']);
       $process_params[] = array('name'=>'cmv_politicalparties_id_c','value' => $_POST['cmv_politicalparties_id_c']);
       $process_params[] = array('name'=>'cmv_politicalpartyroles_id_c','value' => $_POST['cmv_politicalpartyroles_id_c']);
       $process_params[] = array('name'=>'cmv_branchbodies_id_c','value' => $_POST['cmv_branchbodies_id_c']);
       $process_params[] = array('name'=>'cmv_branchdepartments_id_c','value' => $_POST['cmv_branchdepartments_id_c']);
       $process_params[] = array('name'=>'cmv_constitutionalamendments_id_c','value' => $_POST['cmv_constitutionalamendments_id_c']);
       $process_params[] = array('name'=>'cmv_news_id_c','value' => $_POST['cmv_news_id_c']);
       $process_params[] = array('name'=>'cmv_organisations_id_c','value' => $_POST['cmv_organisations_id_c']);
       $process_params[] = array('name'=>'cmv_constitutionalarticles_id_c','value' => $_POST['cmv_constitutionalarticles_id_c']);
       */

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($_POST['id'] == NULL && $result['id'] != NULL){
          $val = $result['id'];
          } else {
          $val = $_POST['id'];
          }

       $process_message = $strings["SubmissionSuccess"]."<P><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$do."');return false\">".$strings["action_edit"]."</a> || <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$do."');return false\">".$strings["action_view_here"]."</a><P>";

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