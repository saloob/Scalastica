<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: ProjectTasks.php 
##########################################################
# case 'ProjectTasks':

   $this_module = 'daee409c-7ec2-5990-dd63-541ef86047b4';
   $security_params[0] = $this_module;
   $security_params[1] = $lingo;
   $security_params[2] = $_SESSION['contact_id'];
   $security_check = $funky_gear->check_security($security_params);
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

   $lingoname = "name_".$lingo."_c";
   $lingodesc = "description_".$lingo."_c";
   $name_field_base = "name_x_c";
   $desc_field_base = "description_x_c";

 if ($action != 'list' || $action != 'process'){

    $acc_object_type = "AccountRelationships";
    $acc_action = "select";
    $acc_params[0] = " account_id_c='".$portal_account_id."' ";
    $acc_params[1] = " account_id1_c "; // select array
    $acc_params[2] = ""; // group;
    $acc_params[3] = " account_id1_c "; // order;
    $acc_params[4] = "300"; // limit
  
    $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

    if (is_array($acc_items)){

       for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

           $child_account_id = $acc_items[$acc_cnt]['child_account_id'];
           $child_account_name = $acc_items[$acc_cnt]['child_account_name'];
           $ddpack[$child_account_id]=$child_account_name;

           }
       }

    $acc_object_type = "AccountRelationships";
    $acc_action = "select";
    $acc_params[0] = " account_id1_c='".$portal_account_id."' ";
    $acc_params[1] = " account_id_c "; // select array
    $acc_params[2] = ""; // group;
    $acc_params[3] = " account_id_c "; // order;
    $acc_params[4] = ""; // limit
  
    $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

    if (is_array($acc_items)){

       for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

           $parent_account_id = $acc_items[$acc_cnt]['parent_account_id'];
           $parent_account_name = $acc_items[$acc_cnt]['parent_account_name'];
           $ddpack[$parent_account_id]=$parent_account_name;

           }
       }

    $acc_returner = $funky_gear->object_returner ("Accounts", $account_id_c);
    $object_return_name = $acc_returner[0];
    $ddpack[$account_id_c]=$object_return_name;

    if (is_array($ddpack)){

       foreach ($ddpack as $parent_account_id => $parent_account_name){
            
               $acc_object_type = "Accounts";
               $acc_action = "select_contacts";
               $acc_params[0] = " account_id='".$parent_account_id."' ";
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
                      $conpack[$contact_id] = $parent_account_name." -> ".$first_name." ".$last_name;

                      } // for

                  } // if


               } //for each

       } // is array

    } // end if not list


   $sendiv = $_POST['sendiv'];
   if (!$sendiv){
      $sendiv = $_GET['sendiv'];
      }

   switch ($valtype){

    case 'Accounts':
     $project_cstm_params[0] = " project_task.deleted=0 && project_task_cstm.account_id_c='".$val."'  && project_task.id=project_task_cstm.id_c ";
     $record_account_id_c = $val;
    break;
    case 'Effects':
     $project_cstm_params[0] = " project_task.deleted=0 && project_task_cstm.account_id_c='".$sess_account_id."'  && project_task.id=project_task_cstm.id_c ";
     $record_account_id_c = $sess_account_id;
    break;
    case 'Contacts':
     $project_cstm_params[0] = " project_task.deleted=0 && project_task_cstm.contact_id_c='".$val."'  && project_task.id=project_task_cstm.id_c ";
     $record_contact_id_c = $val;
    break;
    case 'ProjectTasks':
     $project_cstm_params[0] = " project_task.deleted=0 && project_task_cstm.projecttask_id_c='".$val."'  && project_task.id=project_task_cstm.id_c ";
     $record_projecttask_id_c = $val;
    break;
    case 'Projects':
    $project_task_params[0] = " project_task.deleted=0 && project_task.project_id='".$val."' && project_task.id=project_task_cstm.id_c ";
     $record_project_id_c = $val;
    break;

    }

  if (!$record_account_id_c){
     $record_account_id_c == $account_id_c;
     }

  if (!$record_contact_id_c){
     $record_contact_id_c == $contact_id_c;
     }

if ($valtype == 'Search'){
   $keyword = $val;
   $vallength = strlen($keyword);
   $trimval = substr($keyword, 0, -1);

   if ($account_id_c){
      $object_return_params[0] = " ($lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || $lingodesc like '%".$trimval."%' || $lingoname like '%".$trimval."%') && (cmn_statuses_id_c!= '".$standard_statuses_closed."' || account_id_c='".$account_id_c."') ";
      } else {
      $object_return_params[0] = " ($lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || $lingodesc like '%".$trimval."%' || $lingoname like '%".$trimval."%') && cmn_statuses_id_c!= '".$standard_statuses_closed."' ";
      } 

   }

    $today = date("Y-m-d");
    $this_year = date("Y");
    $this_month = date("m");
    $this_yearmonth = date("Y-m");
    if ($this_month <=12 && $this_month > 2){
       $last_month = $this_month-1;
       }

    $nowdate = date("Y-m-d H:i:s");
    $difference = $funky_gear->timeDiff($date_entered,$nowdate);
    $years = abs(floor($difference / 31536000));
    $days = abs(floor(($difference-($years * 31536000))/86400));
    $hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));
    $mins = abs(floor(($difference-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);
    $new_accumulated_minutes = floor(($difference)/60); 

    switch ($auth){

     case 1:

      #$task_menu = "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=".$val."&valuetype=".$valtype."&summarytype=total');return false\"><font size=4><B>".$strings["ProjectTaskSummary"]."</B></font></a></center>";
      $task_menu .= "<center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=".$today."&valuetype=date');return false\"><font size=4><B>".$today."</B></font></a></center>";

      $task_params[0] .= $project_task_params[0]." && project_task_cstm.account_id_c = '".$account_id_c."' ";

     break;
     case 2:

      #$task_menu = "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=".$val."&valuetype=".$valtype."&summarytype=total');return false\"><font size=4><B>".$strings["ProjectTaskSummary"]."</B></font></a></center>";
      $task_params[0] .= $project_task_params[0]." && project_task_cstm.account_id_c = '".$account_id_c."' ";

     break;
     case 3:

      #$task_menu = "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=".$val."&valuetype=".$valtype."&summarytype=total');return false\"><font size=4><B>".$strings["ProjectTaskSummary"]."</B></font></a></center>";
      $task_params[0] .= $project_task_params[0];

     break;

    } // end auth switch

    $task_menu .= "<BR><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."');return false\"><font size=4><B>".$strings["ProjectTasks"]."</B></font></a></center>";

  switch ($action){
   
   case 'summary':

    require_once "charting/libTeeChart.php";

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["ProjectTaskSummary"]."</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo $task_menu;
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    $summarytype = $_POST['summarytype'];
    if (!$summarytype){
       $summarytype = $_GET['summarytype'];
       }

    switch ($summarytype){

     case '':
     case 'total':
     case 'date':

     $task_object_type = $do;
     $task_action = "select";
//     $task_params[0] = ""; // select array
     $task_params[1] = ""; // select array
     $task_params[2] = ""; // group;
     $task_params[3] = " project_task.name, project_task.date_entered DESC "; // order;
     $task_params[4] = ""; // limit
     $task_params[5] = ",project_task_cstm"; // lingo
     $task_params[6] = $lingoname; // lingo

     $task_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $task_object_type, $task_action, $task_params);

     if (is_array($task_list)){

        for ($cnt=0;$cnt < count($task_list);$cnt++){

            $id = $task_list[$cnt]["id"];
            $name = $task_list[$cnt]["name"];
            $status = $task_list[$cnt]['status'];
            $status_image = $task_list[$cnt]['status_image'];
            $status_name = $task_list[$cnt]['status_name'];
            $status_name_ja = $task_list[$cnt]['status_name_ja'];

            $date_entered = substr($date_entered, 0,10);

            $fullsummarypack[$cnt]['date_start'] = $task_list[$cnt]['date_start'];
            $fullsummarypack[$cnt]['name'] = $name;
            $fullsummarypack[$cnt]['status'] = $status;
            $fullsummarypack[$cnt]['status_name'] = $status_name;
//            $fullsummarypack[$cnt]['status_name_ja'] = $status_name_ja;
            $fullsummarypack[$cnt]['status_image'] = $status_image;

            } // for

        } // if

    ######################

    function getcount ($pack,$checkvalue,$label){

      foreach ($pack as $key => $value){

              if ($checkvalue == $value[$label]){
                 $check_count++;
                 $barvalues = $check_count." ".$checkvalue;
                 }

              }

     $returnvalues[0] = $check_count;
     $returnvalues[1] = $barvalues;

     return $returnvalues;

    } // end checkcount function

    ######################

    foreach ($fullsummarypack as $key => $value){

            $date = $value['date_start'];
            if (!in_array($date,$dates)){
               $datereturned = getcount ($fullsummarypack,$date,'date_start');
               $datecount[] = $datereturned[0];
               $datepack[] = $datereturned[1];
               $dates[] = $date;
               }

            $status = $value['status'];
            $status_name = $value['status_name'];
//            $status_name_ja = $value['status_name_ja'];
            $status_image = $value['status_image'];
            if (!in_array($status,$statuses)){
               $statusreturned = getcount ($fullsummarypack,$status_name,'status_name');
               $statuscount = $statusreturned[0];
               $statuscounter[] = $statusreturned[0];
               $statuspack[] = $statusreturned[1];
               $statuses[] = $status;
               $statusnames[] = $status_name;
/*
               if ($lang == 'ja'){
                  $status_images .= "<img src=".$status_image." width=16> ".$status_name_ja."[".$statuscount."]<BR>";
                  } else {
                  $status_images .= "<img src=".$status_image." width=16> ".$status_name."[".$statuscount."]<BR>";
                  } 
*/
               } // if statuses

            } // foreach

    ######################

//    echo "<div style=\"".$formtitle_divstyle_white."\">".$strings["TicketSummaryMessage"]."</div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
   
    ######################

        $chart2 = new TChart(400,250);
//Until fix mojobake
//        $chart2->getChart()->getHeader()->setText($strings["TicketSummaryByDate"]);
        $chart2->getChart()->getHeader()->setText("Task Summary by Date");
        $horizBar=new HorizBar($chart2->getChart());
        $horizBar->addArray($datepack);
        $chart2->getChart()->getSeries(0)->setColorEach(true);
 
        $taskbydate = "content/tmp/TaskByDate-".$chartdate."-".$account_id_c.".png";

        $chart2->render($taskbydate);

        echo "<center><a href=\"".$taskbydate."\" data-lightbox=\"".$valtype."\" title=\"".$strings["TaskSummaryByDate"]."\"><img alt=\"".$strings["TaskSummaryByDate"]."\" src=\"".$taskbydate."\" width=450 style=\"border: 1px solid gray;\"/></a></center>";

    ######################

        $chart3 = new TChart(400,250);
//Until fix mojobake
//        $chart2->getChart()->getHeader()->setText($strings["TicketSummaryByStatus"]);
        $chart3->getChart()->getHeader()->setText("Task Summary by Status");
        $horizBar=new HorizBar($chart3->getChart());
        $horizBar->addArray($statuspack);
        $chart3->getChart()->getSeries(0)->setColorEach(true);

        $taskbystatus = "content/tmp/TaskByStatus-".$chartdate."-".$account_id_c.".png";

        $chart3->render($taskbystatus);

        echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
        echo "<center><a href=\"".$taskbystatus."\" data-lightbox=\"".$valtype."\" title=\"".$strings["TaskSummaryByStatus"]."\"><img alt=\"".$strings["TaskSummaryByStatus"]."\" src=\"".$taskbystatus."\" width=450 style=\"border: 1px solid gray;\"/></a></center>";

    ######################

   break;

   } // end type

   break;
   case 'list':
   
    ################################
    # List

    function wrap_tasks ($task_params){

     global $portal_config,$divstyle_white,$divstyle_orange_light,$divstyle_blue,$BodyDIV,$portalcode,$valtype,$strings;

     $lingoname = $task_params[1];
     $divstyle_colour = $task_params[2];
     $divwidth = $task_params[3];
     $security_level = $task_params[4];
     $project_id = $task_params[5];

     $border_color = $portal_config['portalconfig']['portal_border_color'];

     if (!$divstyle_colour){
        $divstyle_colour = $divstyle_blue;
        }

     if (!$divwidth){
        $divwidth = 10;
        }

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
 
            $record_account_id = $project_task_items[$task_cnt]['account_id_c'];
            $contact_id_c = $project_task_items[$task_cnt]['contact_id_c'];
            $task_number = $project_task_items[$task_cnt]['task_number'];
            $date_start = $project_task_items[$task_cnt]['date_start'];
            $date_due = $project_task_items[$task_cnt]['date_due'];
            $date_finish = $project_task_items[$task_cnt]['date_finish'];
            $status = $project_task_items[$task_cnt]['status'];
            $status_image = $project_task_items[$task_cnt]['status_image'];
            $status_name = $project_task_items[$task_cnt]['status_name'];
            $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";
            #$sess_contact_id == $contact_id_c
            $percent_complete = $project_task_items[$task_cnt]['percent_complete'];
            #$project_id = $project_task_items[$task_cnt]['project_id'];

            $edit = "";
            $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$task_id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a>";

            $edit .= " <a href=\"#Top\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=edit&value=".$task_id."&valuetype=".$valtype."&sendiv=lightfull');document.getElementById('fade').style.display='block';return false\"><font size=2 color=red><B>[Quick ".$strings["action_edit"]."]</B></font></a> ";

            #########################
            # Get list of all ServiceSLARequests this account owns

            #echo "Status: ".$status."<BR>";

            if ($status != '14426db8-71c8-5789-e887-52a448a782b0'){

               /*
               if ($project_id != NULL && $task_id != NULL){
                  $query = "&& (project_id_c='".$project_id."' || projecttask_id_c='".$task_id."') ";
                  } elseif ($project_id == NULL && $task_id != NULL){
                  $query = "&& projecttask_id_c='".$task_id."' ";
                  }
               */

               $query = "&& projecttask_id_c='".$task_id."' ";

               $ci_object_type = "ServiceSLARequests";
               $ci_action = "select";
               $ci_params[0] = " deleted=0 && account_id_c='".$record_account_id."' ".$query; 
               $ci_params[1] = "id,name"; // select array
               $ci_params[2] = ""; // group;
               $ci_params[3] = "name ASC"; // order;
               $ci_params[4] = ""; // limit
  
               #echo "params: ".$ci_params[0]."<BR>";

               $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

               $createticket = "";

               if (is_array($ci_items)){

                  #echo "Array<BR>";

                  for ($slareqcnt=0;$slareqcnt < count($ci_items);$slareqcnt++){

                      $sla_req_id = $ci_items[$slareqcnt]['id'];
                      $sla_req_name = $ci_items[$slareqcnt]['name'];

                      $createticket .= "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&value=".$task_id."&valuetype=ProjectTasks&sclm_serviceslarequests_id_c=".$sla_req_id."');return false\"><img src=images/icons/SupportTicket.jpg width=16><font color=#151B54><B>Create Ticket [".$sla_req_name."]</B></font></a>";

                      } // for

                  $createticket .= "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$task_id."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";

                  #$createticket = "<div style=\"border:1px solid ".$border_color.";border-radius:1px;width:100%;float:left;padding-top:5;overflow:auto;max-height:45px;\">".$createticket."</div><BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$task_id."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";

                  } else { // if
                  # No SLA Request for this task - allow to create one
                  $createticket = "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$task_id."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";
                  }

               $addsubtask = "<BR><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=add&value=".$task_id."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/plus.gif width=16><font color=#151B54><B>Add Sub-task</B></font></a>";

               $addevent = "<BR><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$task_id."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/plus.gif width=16><font color=#151B54><B>Add Event</B></font></a>";

               } # status

             # End Provide Create Ticket link based on SLA Requests
            ########################

            if ($security_level){

               switch ($security_level){

                case '':
   
                 $edit = "";
   
                break;
                case 0:
   
                 $edit = "";
   
                break;
                case 1:
   
                 $edit = "";
   
                break;
                case 2:
   
                 #$edit = "";
   
                break;
   
               } // end switch

               } else {
               # Security not set
               if ($record_account_id != $sess_account_id){
                  $edit = "";
                  }
               }

            #$border = "border:2px solid; border-radius:3";
            $border = "border:0px";

            /*
            $task_divstyle_params[0] = "98%"; // minwidth
            $task_divstyle_params[1] = "25px"; // minheight
            $task_divstyle_params[2] = "1%"; // margin_left
            $task_divstyle_params[3] = "1%"; // margin_right
            $task_divstyle_params[4] = "2px"; // padding_left
            $task_divstyle_params[5] = "2px"; // padding_right
            $task_divstyle_params[6] = "0px"; // margin_top
            $task_divstyle_params[7] = "0px"; // margin_bottom
            $task_divstyle_params[8] = "5px"; // padding_top
            $task_divstyle_params[9] = "2px"; // padding_bottom

            $task_divstyles = $funky_gear->makedivstyles ($task_divstyle_params);
            $divstyle_blue = $divstyles[0];
            $divstyle_grey = $divstyles[1];
            $divstyle_white = $divstyles[2];
            $divstyle_orange = $divstyles[3];
            $divstyle_orange_light = $divstyles[4];
            */

            $projecttasks .= "<div style=\"".$divstyle_colour."\"><div style=\"".$border.";width:".$divwidth."%;float:left;padding-top:5;\"><center><img src=images/icons/forward.png></center></div><div style=\"".$border.";width:20%;float:left;padding-top:5;\"><center>".$status_image."<BR><font size=2>[".$status_name."]</font></center></div><div style=\"".$border.";width:60%;float:left;padding-top:3;\">[".$date_start."]->[".$date_due."]<BR>[#".$task_number."] [".$percent_complete."%] ".$edit."<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=view&value=".$task_id."&valuetype=".$valtype."');return false\"><B>".$task_name."</B></a>".$addsubtask.$createticket.$addevent."</div></div>";

            $newtask_params[0] = " projecttask_id_c='".$task_id."' ";
            $newtask_params[1] = $lingoname;
            $newtask_params[2] = $divstyle_orange_light;
            $newtask_params[3] = 20;
            $newtask_params[4] = $security_level;
            $newtask_params[5] = $project_id;
            $parent_projecttasks = wrap_tasks ($newtask_params);

            if ($parent_projecttasks){
               $projecttasks .= $parent_projecttasks;
               }

            } // end for

        } else {// end if array

        $projecttasks = "";

        } 

    return $projecttasks;

    } // end function
    
    if ($valtype == 'Search' || $val != NULL){
       echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["ProjectTasks"]."</B></font></center></div>";
       #echo "<img src=images/blank.gif width=50% height=5><BR>";
       #echo "<center><img src=images/icons/Balance.png width=100 border=0 alt=\"".$strings["ProjectTasks"]."\"></center></div>";
       echo "<img src=images/blank.gif width=98% height=5><BR>";
       }

    #echo "<BR><img src=images/blank.gif width=90% height=10><BR>";
    #echo $task_menu;
    #echo "<BR><img src=images/blank.gif width=90% height=10><BR>";

    echo "<P><center><a href=\"#Top\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=gantt&value=".$val."&valuetype=".$valtype."&sendiv=lightfull');document.getElementById('fade').style.display='block';return false\"><B>GANTT CHART</B><P><img src=images/icons/Balance.png width=50 border=0></a></center><P>";

  switch ($valtype){

   case 'Accounts':
   case 'Contacts':
   case 'ProjectTasks':

    $project_cstm_object_type = 'ProjectTasks';
    $project_cstm_action = "select_cstm";
    $project_cstm_params[0] = $object_return_params[0]; // select array
    $project_cstm_params[1] = ""; // select array
    $project_cstm_params[2] = ""; // group;
    $project_cstm_params[3] = ""; // order;
    $project_cstm_params[4] = ""; // limit
  
    $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

    if (is_array($project_cstm_items)){

       $count = count($project_cstm_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $project_cstm_params[4] = " $lfrom , $glb_perpage_items "; 

       $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

       for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

           $id_c = $project_cstm_items[$cnt]['id_c'];
           $record_contact_id_c = $project_cstm_items[$cnt]['contact_id_c'];
           $record_account_id_c = $project_cstm_items[$cnt]['account_id_c'];
           $itil_stage_c = $project_cstm_items[$cnt]['itil_stage_c'];
           $itil_stage_process_c = $project_cstm_items[$cnt]['itil_stage_process_c'];
           $record_projecttask_id_c = $project_cstm_items[$cnt]['projecttask_id_c'];
           $grandparent_projecttask_id_c = $project_cstm_items[$cnt]['parent_projecttask_id_c'];
           $pm_provider = $project_cstm_items[$cnt]['account_id1_c'];
           $pm_contact = $project_cstm_items[$cnt]['contact_id1_c'];
           $pm_assignee = $project_cstm_items[$cnt]['contact_id2_c'];

           // Get Standard content

           $project_task_object_type = "ProjectTasks";
           $project_task_action = "select";
           $project_task_params[0] = " id='".$id_c."' ";
           $project_task_params[1] = ""; // select array
           $project_task_params[2] = ""; // group;
           $project_task_params[3] = ""; // order;
           $project_task_params[4] = ""; // limit
  
           $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

           if (is_array($project_task_items)){

              for ($taskcnt=0;$taskcnt < count($project_task_items);$taskcnt++){

                  $id = $project_task_items[$taskcnt]['id'];
                  $name = $project_task_items[$taskcnt]['name'];
                  $date_entered = $project_task_items[$taskcnt]['date_entered'];
                  $date_modified = $project_task_items[$taskcnt]['date_modified'];
                  $project_id = $project_task_items[$taskcnt]['project_id'];
                  $project_task_id = $project_task_items[$taskcnt]['project_task_id'];
                  $name = $project_task_items[$taskcnt]['name'];
                  $status = $project_task_items[$taskcnt]['status'];
                  $status_image = $project_task_items[$taskcnt]['status_image'];
                  $status_name = $project_task_items[$taskcnt]['status_name'];
                  $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";

                  $description = $project_task_items[$taskcnt]['description'];
                  $predecessors = $project_task_items[$taskcnt]['predecessors'];
                  $date_start = $project_task_items[$taskcnt]['date_start'];
                  $time_start = $project_task_items[$taskcnt]['time_start'];
                  $time_finish = $project_task_items[$taskcnt]['time_finish'];
                  $date_finish = $project_task_items[$taskcnt]['date_finish'];
                  $duration = $project_task_items[$taskcnt]['duration'];
                  $duration_unit = $project_task_items[$taskcnt]['duration_unit'];
                  $actual_duration = $project_task_items[$taskcnt]['actual_duration'];
                  $percent_complete = $project_task_items[$taskcnt]['percent_complete'];
                  $date_due = $project_task_items[$taskcnt]['date_due'];
                  $time_due = $project_task_items[$taskcnt]['time_due'];
                  $parent_task_id = $project_task_items[$taskcnt]['parent_task_id'];
                  $assigned_user_id = $project_task_items[$taskcnt]['assigned_user_id'];
                  $modified_user_id = $project_task_items[$taskcnt]['modified_user_id'];
                  $priority = $project_task_items[$taskcnt]['priority'];
                  $created_by = $project_task_items[$taskcnt]['created_by'];
                  $milestone_flag = $project_task_items[$taskcnt]['milestone_flag'];
                  $order_number = $project_task_items[$taskcnt]['order_number'];
                  $task_number = $project_task_items[$taskcnt]['task_number'];
                  $estimated_effort = $project_task_items[$taskcnt]['estimated_effort'];
                  $actual_effort = $project_task_items[$taskcnt]['actual_effort'];
                  $deleted = $project_task_items[$taskcnt]['deleted'];
                  $utilization = $project_task_items[$taskcnt]['utilization'];

                  $edit = "";

                  if ($sess_contact_id != NULL && $sess_contact_id==$record_contact_id_c || $sess_contact_id != NULL && $sess_contact_id==$account_admin){
                     $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";

                     $edit .= " <a href=\"#Top\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=edit&value=".$id."&valuetype=".$valtype."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=2 color=red><B>[Quick ".$strings["action_edit"]."]</B></font></a> ";
                     }

                  $grandparent_task = "";
                  $parent_task = "";
/*
                  if ($grandparent_projecttask_id_c != NULL){
                     $grandparent_task_returner = $funky_gear->object_returner ('ProjectTasks', $grandparent_projecttask_id_c);
                     $grandparent_task_object_return_name = $grandparent_task_returner[0];
                     $grandparent_task_link = $grandparent_task_returner[3];
                     $grandparent_task = $grandparent_task_link." -> ";
                     }

                  if ($record_projecttask_id_c != NULL){
                     $parent_task_returner = $funky_gear->object_returner ('ProjectTasks', $record_projecttask_id_c);
                     $parent_task_object_return_name = $parent_task_returner[0];
                     $parent_task_link = $parent_task_returner[3];
//                     $parent_task = $strings["ParentTask"]." -> ".$parent_task_link." -> ";
                     $parent_task = $grandparent_task.$parent_task_link." -> ";
                     }
*/
                  if ($project_cstm_items[$cnt][$lingoname] != NULL){
                     $name = $project_cstm_items[$cnt][$lingoname];
                     }


                  #########################
                  # Get list of all ServiceSLARequests this account owns

                  if ($status != '14426db8-71c8-5789-e887-52a448a782b0'){

                     /*
                     if ($project_id != NULL && $id_c != NULL){
                        $query = "&& (project_id_c='".$project_id."' || projecttask_id_c='".$id_c."') ";
                        } elseif ($project_id == NULL && $id_c != NULL){
                        $query = "&& projecttask_id_c='".$id_c."' ";
                        } 
                     */

                     $query = "&& projecttask_id_c='".$id_c."' ";

                     $ci_object_type = "ServiceSLARequests";
                     $ci_action = "select";
                     $ci_params[0] = " deleted=0 && account_id_c='".$record_account_id_c."' ".$query; 
                     $ci_params[1] = "id,name"; // select array
                     $ci_params[2] = ""; // group;
                     $ci_params[3] = "name ASC"; // order;
                     $ci_params[4] = ""; // limit
  
                     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

                     $createticket = "";

                     if (is_array($ci_items)){

                        for ($slareqcnt=0;$slareqcnt < count($ci_items);$slareqcnt++){
   
                            $sla_req_id = $ci_items[$slareqcnt]['id'];
                            $sla_req_name = $ci_items[$slareqcnt]['name'];
                            $createticket .= "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&value=".$id_c."&valuetype=ProjectTasks&sclm_serviceslarequests_id_c=".$sla_req_id."');return false\"><img src=images/icons/SupportTicket.jpg width=16><font color=#151B54><B>Create Ticket [".$sla_req_name."]</B></font></a>";

                            } // for

                        $createticket .= "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$id_c."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";

                        #$createticket = "<div style=\"border:1px solid ".$border_color.";border-radius:1px;width:100%;float:left;padding-top:5;overflow:auto;max-height:45px;\">".$createticket."</div><BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$id_c."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";

                        } else { // if
                        # No SLA Request for this task - allow to create one
                        $createticket = "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$id_c."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";
                        }

                     $addsubtask = "<BR><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=add&value=".$id."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/plus.gif width=16><font color=#151B54><B>Add Sub-task</B></font></a>";

                     $addevent = "<BR><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$id."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/calendar.png width=16><font color=#151B54><B>Add Event</B></font></a>";

                     } # if status

                  $projecttasks .= "<div style=\"".$divstyle_white."\"><div style=\"width:20%;float:left;padding-top:5;\"><center>".$status_image."<BR><font size=2>[".$status_name."]</font></center></div><div style=\"width:80%;float:left;padding-top:3;\">[".$date_start."]->[".$date_due."]<BR>[#".$task_number."] [".$percent_complete."%] ".$edit." <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a>".$addsubtask.$createticket.$addevent."</div></div>";

                  $task_params[0] = " projecttask_id_c='".$id."' ";
                  $task_params[1] = $lingoname;
                  $task_params[2] = $divstyle_blue;
                  $task_params[3] = "";
                  $task_params[4] = $security_level;
                  $task_params[5] = $project_id;
                  $parent_projecttasks = wrap_tasks ($task_params);
                  $projecttasks .= $parent_projecttasks;

                  } // end for

              } // end if

           } // end for
      
       } else { // end if array

       $projecttasks = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

       }

    if (count($project_cstm_items)>10){
       echo $addnew.$projecttasks.$addnew;
       } else {
       echo $projecttasks.$addnew;
       }
   
    echo $navi;

//    $this->funkydone ($_POST,$lingo,'Content','view','76bed5bc-ab35-7523-d01b-5240743cf4cd','Services',$bodywidth);

    # End List
    ################################

   break; // Accounts
   case 'Projects':

    $project_task_object_type = 'ProjectTasks';
    $project_task_action = "select";
//    $project_task_params[0] = " project_task.project_id='".$val."' && project_task_cstm.projecttask_id_c='' && project_task.id=project_task_cstm.id_c ";
    $project_task_params[0] = " project_task.project_id='".$val."' && (project_task_cstm.projecttask_id_c='' || project_task_cstm.projecttask_id_c IS NULL || project_task_cstm.projecttask_id_c ='NULL') && project_task.id=project_task_cstm.id_c ";
//    $project_task_params[0] = " project_task.project_id='".$val."' && project_task.id=project_task_cstm.id_c ";
    $project_task_params[1] = ""; // select array
    $project_task_params[2] = ""; // group;
    $project_task_params[3] = " project_task.date_finish ASC, project_task_cstm.cmn_statuses_id_c ASC"; // order;
    $project_task_params[4] = ""; // limit
    $project_task_params[5] = ",project_task_cstm"; // prequery
  
    $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

    if (is_array($project_task_items)){

       $count = count($project_task_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       echo $navi;

       $project_task_params[4] = " $lfrom , $glb_perpage_items "; 

       $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

       for ($cnt=0;$cnt < count($project_task_items);$cnt++){

           $id = $project_task_items[$cnt]['id'];
           $name = $project_task_items[$cnt]['name'];
           $date_entered = $project_task_items[$cnt]['date_entered'];
           $date_modified = $project_task_items[$cnt]['date_modified'];
           $project_id = $project_task_items[$cnt]['project_id'];
           $project_task_id = $project_task_items[$cnt]['project_task_id'];

           $status = $project_task_items[$cnt]['status'];
           $status_image = $project_task_items[$cnt]['status_image'];
           $status_name = $project_task_items[$cnt]['status_name'];
           $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";

           $description = $project_task_items[$cnt]['description'];
           $predecessors = $project_task_items[$cnt]['predecessors'];
           $date_start = $project_task_items[$cnt]['date_start'];
           $time_start = $project_task_items[$cnt]['time_start'];
           $time_finish = $project_task_items[$cnt]['time_finish'];
           $date_finish = $project_task_items[$cnt]['date_finish'];
           $duration = $project_task_items[$cnt]['duration'];
           $duration_unit = $project_task_items[$cnt]['duration_unit'];
           $actual_duration = $project_task_items[$cnt]['actual_duration'];
           $percent_complete = $project_task_items[$cnt]['percent_complete'];
           $date_due = $project_task_items[$cnt]['date_due'];
           $time_due = $project_task_items[$cnt]['time_due'];
           $parent_task_id = $project_task_items[$cnt]['parent_task_id'];
           $assigned_user_id = $project_task_items[$cnt]['assigned_user_id'];
           $modified_user_id = $project_task_items[$cnt]['modified_user_id'];
           $priority = $project_task_items[$cnt]['priority'];
           $created_by = $project_task_items[$cnt]['created_by'];
           $milestone_flag = $project_task_items[$cnt]['milestone_flag'];
           $order_number = $project_task_items[$cnt]['order_number'];
           $task_number = $project_task_items[$cnt]['task_number'];
           $estimated_effort = $project_task_items[$cnt]['estimated_effort'];
           $actual_effort = $project_task_items[$cnt]['actual_effort'];
           $deleted = $project_task_items[$cnt]['deleted'];
           $utilization = $project_task_items[$cnt]['utilization'];

           // Get Custom content

           $record_contact_id_c = $project_task_items[$cnt]['contact_id_c'];
           $record_account_id_c = $project_task_items[$cnt]['account_id_c'];
           $itil_stage_c = $project_task_items[$cnt]['itil_stage_c'];
           $itil_stage_process_c = $project_task_items[$cnt]['itil_stage_process_c'];
           $record_projecttask_id_c = $project_task_items[$cnt]['projecttask_id_c'];
           $grandparent_projecttask_id_c = $project_task_items[$cnt]['parent_projecttask_id_c'];
           $pm_provider = $project_task_items[$cnt]['account_id1_c'];
           $pm_contact = $project_task_items[$cnt]['contact_id1_c'];
           $pm_assignee = $project_task_items[$cnt]['contact_id2_c'];


            ####################
            # Get list of all ServiceSLARequests this account owns

            if ($status != '14426db8-71c8-5789-e887-52a448a782b0'){

               /*
               if ($project_id != NULL && $id != NULL){
                  $query = "&& (project_id_c='".$project_id."' || projecttask_id_c='".$id."') ";
                  } elseif ($project_id == NULL && $id != NULL){
                  $query = "&& projecttask_id_c='".$id."' ";
                  } 
               */

               $query = "&& projecttask_id_c='".$id."' ";

               $ci_object_type = "ServiceSLARequests";
               $ci_action = "select";
               $ci_params[0] = " deleted=0 && account_id_c='".$record_account_id_c."' ".$query; 
               $ci_params[1] = "id,name"; // select array
               $ci_params[2] = ""; // group;
               $ci_params[3] = "name ASC"; // order;
               $ci_params[4] = ""; // limit
  
               $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

               $createticket = "";

               if (is_array($ci_items)){

                  for ($slareqcnt=0;$slareqcnt < count($ci_items);$slareqcnt++){

                      $sla_req_id = $ci_items[$slareqcnt]['id'];
                      $sla_req_name = $ci_items[$slareqcnt]['name'];
                      $createticket .= "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&value=".$id."&valuetype=ProjectTasks&sclm_serviceslarequests_id_c=".$sla_req_id."');return false\"><img src=images/icons/SupportTicket.jpg width=16><font color=#151B54><B>Create Ticket [".$sla_req_name."]</B></font></a>";

                      #$dd_pack['683bb5f7-e1c7-4796-8d23-52b0df65369f[]'.$val.'[]'.$id.'[]RELATIONSHIPS'] = $strings["ServiceSLARequests"]." : ".$name;

                      } // for

                  $createticket .= "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$id."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";

                  #$createticket = "<div style=\"border:1px solid ".$border_color.";border-radius:1px;width:100%;float:left;padding-top:5;overflow:auto;max-height:45px;\">".$createticket."</div><BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$id."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";

                  } else { // if
                  # No SLA Request for this task - allow to create one
                  $createticket = "<BR><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$id."&valuetype=ProjectTasks');return false\"><img src=images/icons/uu.png width=16><font color=#151B54><B>Find Service for Task</B></font></a>";
                  }

               $addevent = "<BR><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$id."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/calendar.png width=16><font color=#151B54><B>Add Event</B></font></a>";

               } # if status

           $edit = "";
           if ($sess_contact_id != NULL && $sess_contact_id==$record_contact_id_c || $sess_contact_id != NULL && $sess_contact_id==$account_admin || $sess_contact_id != NULL && $sess_contact_id==$pm_contact || $sess_contact_id != NULL && $sess_contact_id==$pm_assignee){
              $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              $edit .= " <a href=\"#Top\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=edit&value=".$id."&valuetype=".$valtype."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font size=2 color=red><B>[Quick ".$strings["action_edit"]."]</B></font></a> ";
              } 

           $grandparent_task = "";
           $parent_task = "";
/*
           if ($grandparent_projecttask_id_c != NULL){
              $grandparent_task_returner = $funky_gear->object_returner ('ProjectTasks', $grandparent_projecttask_id_c);
              $grandparent_task_object_return_name = $grandparent_task_returner[0];
              $grandparent_task_link = $grandparent_task_returner[3];
              $grandparent_task = $grandparent_task_link." -> ";
              }

           if ($record_projecttask_id_c != NULL){
              $parent_task_returner = $funky_gear->object_returner ('ProjectTasks', $record_projecttask_id_c);
              $parent_task_object_return_name = $parent_task_returner[0];
              $parent_task_link = $parent_task_returner[3];
              $parent_task = $grandparent_task.$parent_task_link." -> ";
              }
*/
           if ($project_task_items[$cnt][$lingoname] != NULL){
              $name = $project_task_items[$cnt][$lingoname];
              }

            if ($status != '14426db8-71c8-5789-e887-52a448a782b0'){

               $addsubtask = "<BR><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=ProjectTasks&action=add&value=".$id."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><img src=images/icons/plus.gif width=16><font color=#151B54><B>Add Sub-task</B></font></a>";

               }

           $projecttasks .= "<div style=\"".$divstyle_white."\"><div style=\"width:20%;float:left;padding-top:5;\"><center>".$status_image."<BR><font size=2>[".$status_name."]</font></center></div><div style=\"width:80%;float:left;padding-top:3;\"> [".$date_start."]->[".$date_due."]<BR>[#".$task_number."] [".$percent_complete."%] ".$edit." <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a>".$addsubtask.$createticket.$addevent."</div></div>";


           ################################
           # Sub Tasks

           $task_params[0] = " projecttask_id_c='".$id."' ";
           $task_params[1] = $lingoname;
           $task_params[2] = $divstyle_blue;
           $task_params[3] = "";
           $task_params[4] = $security_level;
           $task_params[5] = $project_id;

           $parent_projecttasks = wrap_tasks ($task_params);
           $projecttasks .= $parent_projecttasks;

           } // end for
      
       } else { // end if array

       $projecttasks = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";

       }

    if (count($project_task_items)>10){
       echo $addnew.$projecttasks.$addnew;
       } else {
       echo $projecttasks.$addnew;
       }
   
    echo $navi;


   break; // end if projects

  }

   break; // end list
   case 'gantt':

    echo "<link rel=\"stylesheet\" href=\"gantti/styles/css/screen.css\" />";
    echo "<link rel=\"stylesheet\" href=\"gantti/styles/css/gantti.css\" />";

    require('gantti/lib/gantti.php'); 

    date_default_timezone_set('Asia/Tokyo');
    setlocale(LC_ALL, 'en_US');

    $data = array();

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightfull');cleardiv('fade');document.getElementById('lightfull').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    #echo "<input type=\"button\" value=\"Print\" onclick=\"PrintElem('#lightfull','".$portal_title."')\" />";

    $val = $_POST['value'];
    $valtype = $_POST['valuetype'];

    #echo "Valtype $valtype <P>";

    if ($valtype == "ProjectTasks"){

       $project_cstm_object_type = 'ProjectTasks';
       $project_cstm_action = "select";
       $project_cstm_params[0] = "id='".$val."' ";
       $project_cstm_params[1] = "project_id"; // select array
       $project_cstm_params[2] = ""; // group;
       $project_cstm_params[3] = ""; // order;
       $project_cstm_params[4] = ""; // limit
       #$project_cstm_params[5] = ",project_task_cstm"; // prequery
  
       #echo $project_cstm_params[0];

       $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

       if (is_array($project_cstm_items)){

          for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

              $project_id = $project_cstm_items[$cnt]['project_id'];

              }
          }

       } elseif ($valtype == "Projects"){ // if valtype is Projects

       $project_id = $val;

       }

    $project_cstm_object_type = 'ProjectTasks';
    $project_cstm_action = "select_cstm";
    $project_cstm_params[0] = " project_task.project_id='".$project_id."' && project_task.id=project_task_cstm.id_c ";
    $project_cstm_params[1] = ""; // select array
    $project_cstm_params[2] = ""; // group;
#    $project_cstm_params[3] = "project_task_cstm.projecttask_id_c, project_task.date_start ASC"; // order;
#    $project_cstm_params[3] = "project_task_cstm.projecttask_id_c"; // order;
    $project_cstm_params[3] = "project_task.date_start ASC"; // order;
    $project_cstm_params[4] = ""; // limit
    $project_cstm_params[5] = ",project_task"; // prequery

    $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

    if (is_array($project_cstm_items)){

       for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

           $id_c = $project_cstm_items[$cnt]['id_c'];
           $record_contact_id_c = $project_cstm_items[$cnt]['contact_id_c'];
           $record_account_id_c = $project_cstm_items[$cnt]['account_id_c'];
           $itil_stage_c = $project_cstm_items[$cnt]['itil_stage_c'];
           $itil_stage_process_c = $project_cstm_items[$cnt]['itil_stage_process_c'];
           $record_projecttask_id_c = $project_cstm_items[$cnt]['projecttask_id_c'];
           $grandparent_projecttask_id_c = $project_cstm_items[$cnt]['parent_projecttask_id_c'];

           // Get Standard content

           $project_task_object_type = "ProjectTasks";
           $project_task_action = "select";
           $project_task_params[0] = " id='".$id_c."' ";
           $project_task_params[1] = ""; // select array
           $project_task_params[2] = ""; // group;
           $project_task_params[3] = "date_start ASC"; // order;
           $project_task_params[4] = ""; // limit
  
           $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

           if (is_array($project_task_items)){

              for ($taskcnt=0;$taskcnt < count($project_task_items);$taskcnt++){

                  $id = $project_task_items[$taskcnt]['id'];
                  $name = $project_task_items[$taskcnt]['name'];
                  $date_entered = $project_task_items[$taskcnt]['date_entered'];
                  $date_modified = $project_task_items[$taskcnt]['date_modified'];
                  $project_id = $project_task_items[$taskcnt]['project_id'];
                  $project_task_id = $project_task_items[$taskcnt]['project_task_id'];
                  $name = $project_task_items[$taskcnt]['name'];
                  $status = $project_task_items[$taskcnt]['status'];
                  $status_image = $project_task_items[$taskcnt]['status_image'];
                  $status_name = $project_task_items[$taskcnt]['status_name'];
                  $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";

                  $description = $project_task_items[$taskcnt]['description'];
                  $predecessors = $project_task_items[$taskcnt]['predecessors'];
                  $date_start = $project_task_items[$taskcnt]['date_start'];
                  $time_start = $project_task_items[$taskcnt]['time_start'];
                  $time_finish = $project_task_items[$taskcnt]['time_finish'];
                  $date_finish = $project_task_items[$taskcnt]['date_finish'];
                  $duration = $project_task_items[$taskcnt]['duration'];
                  $duration_unit = $project_task_items[$taskcnt]['duration_unit'];
                  $actual_duration = $project_task_items[$taskcnt]['actual_duration'];
                  $percent_complete = $project_task_items[$taskcnt]['percent_complete'];
                  $date_due = $project_task_items[$taskcnt]['date_due'];
                  $time_due = $project_task_items[$taskcnt]['time_due'];
                  $parent_task_id = $project_task_items[$taskcnt]['parent_task_id'];
                  $assigned_user_id = $project_task_items[$taskcnt]['assigned_user_id'];
                  $modified_user_id = $project_task_items[$taskcnt]['modified_user_id'];
                  $priority = $project_task_items[$taskcnt]['priority'];
                  $created_by = $project_task_items[$taskcnt]['created_by'];
                  $milestone_flag = $project_task_items[$taskcnt]['milestone_flag'];
                  $order_number = $project_task_items[$taskcnt]['order_number'];
                  $task_number = $project_task_items[$taskcnt]['task_number'];
                  $estimated_effort = $project_task_items[$taskcnt]['estimated_effort'];
                  $actual_effort = $project_task_items[$taskcnt]['actual_effort'];
                  $deleted = $project_task_items[$taskcnt]['deleted'];
                  $utilization = $project_task_items[$taskcnt]['utilization'];
                  $pm_provider = $project_task_items[$taskcnt]['account_id1_c'];
                  $pm_contact = $project_task_items[$taskcnt]['contact_id1_c'];
                  $pm_assignee = $project_task_items[$taskcnt]['contact_id2_c'];

                  if ($project_cstm_items[$cnt][$lingoname] != NULL){
                     $name = $project_cstm_items[$cnt][$lingoname];
                     }

                  #$todaydatetime = date("Y-m-d H:i:s");
                  $todaydate = date("Y-m-d");

                  if ($todaydate > $date_due && $percent_complete < 100){
                     $graphstatus = "urgent";
                     } elseif ($date_finish > $date_due){
                     $graphstatus = "important";
                     } else {
                     $graphstatus = "";
                     }

                  #$name = "<a href=\"#\" onClick=\"cleardiv('lightfull');cleardiv('fade');document.getElementById('lightfull').style.display='none';document.getElementById('fade').style.display='none';loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a>";

                  $name = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=red>[".$strings["action_edit"]."]</font></a> <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><font color=white><B>".$name."</B></font></a>";

                  $data[] = array(
                   'label' => $name,
                   'percentage' => $percent_complete,
                   'start' => $date_start, 
                   'end'   => $date_due,
                   'class' => $graphstatus,
                  );
/*
                  $task_params[0] = " projecttask_id_c='".$id."' ";
                  $task_params[1] = $lingoname;
                  $task_params[2] = $divstyle_blue;
                  $task_params[3] = "";
                  $task_params[4] = $security_level;
                  $parent_projecttasks = wrap_tasks ($task_params);
                  $projecttasks .= $parent_projecttasks;
*/
                  } // end for

              } // end if

           } // end for

       $gantti = new Gantti($data, array(
       'title'      => 'Project Tasks',
       'cellwidth'  => 25,
       'cellheight' => 35
       ));

       echo $gantti;
       
       #$ganttipdf = "<html><head><title>Project Gantt</title><meta charset=\"utf-8\"/><link rel=\"stylesheet\" href=\"gantti/styles/css/screen.css\" /><link rel=\"stylesheet\" href=\"gantti/styles/css/gantti.css\" /></head><body>".$gantti."</body></html>";
/*
       require 'pdfcrowd/pdfcrowd.php';

       try {  

       $client = new Pdfcrowd("Scalastica", "b791b696285d852740d444f89d195c56");

       #$pdf = $client->convertHtml($gantti);

       // set HTTP response headers
       #header("Content-Type: application/pdf");
       #header("Cache-Control: max-age=0");
       #header("Accept-Ranges: none");
       #header("Content-Disposition: attachment; filename=\"gantt.pdf\"");
       $out_filedate = date("Y-m-d_H-i-s");
       $out_filename = "gantt-".$out_filedate.".pdf";
       $out_file = fopen("content/".$out_filename, "wb");
       $client->convertHtml($ganttipdf, $out_file);
       fclose($out_file);

       echo "<a href=content/".$out_filename." target=new>".$out_filename."</a>";

       echo $gantti;

       } catch(PdfcrowdException $why) {

       echo "PDF Error: " . $why;

       }
*/
       } else { // end if array

       echo "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    switch ($valtype){
     case 'Projects':
       $project_id = $val;
     break;
     case 'ProjectTasks':

       $record_projecttask_id_c = $val;
       $project_task_object_type = "ProjectTasks";
       $project_task_action = "select";
       $project_task_params[0] = " id='".$record_projecttask_id_c."' ";
       $project_task_params[1] = ""; // select array
       $project_task_params[2] = ""; // group;
       $project_task_params[3] = ""; // order;
       $project_task_params[4] = ""; // limit
  
       $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

       if (is_array($project_task_items)){

          for ($taskcnt=0;$taskcnt < count($project_task_items);$taskcnt++){
              $project_id = $project_task_items[$taskcnt]['project_id'];
              }

          }
     break;
    }

    if ($action == 'edit' || $action == 'view'){ 

       $project_task_object_type = $do;
       $project_task_action = "select";
       $project_task_params[0] = " id='".$val."' ";
       $project_task_params[1] = ""; // select array
       $project_task_params[2] = ""; // group;
       $project_task_params[3] = ""; // order;
       $project_task_params[4] = ""; // limit
  
       $project_task_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_task_object_type, $project_task_action, $project_task_params);

       if (is_array($project_task_items)){

          for ($cnt=0;$cnt < count($project_task_items);$cnt++){

              $id = $project_task_items[$cnt]['id'];
              $date_entered = $project_task_items[$cnt]['date_entered'];
              $date_modified = $project_task_items[$cnt]['date_modified'];
              $project_id = $project_task_items[$cnt]['project_id'];
              $project_task_id = $project_task_items[$cnt]['project_task_id'];
              $name = $project_task_items[$cnt]['name'];

              $status = $project_task_items[$cnt]['status'];
              $status_image = $project_task_items[$cnt]['status_image'];
              $status_name = $project_task_items[$cnt]['status_name'];

              $description = $project_task_items[$cnt]['description'];
              $predecessors = $project_task_items[$cnt]['predecessors'];
              $date_start = $project_task_items[$cnt]['date_start'];
              $time_start = $project_task_items[$cnt]['time_start'];
              $time_finish = $project_task_items[$cnt]['time_finish'];
              $date_finish = $project_task_items[$cnt]['date_finish'];
              $duration = $project_task_items[$cnt]['duration'];
              $duration_unit = $project_task_items[$cnt]['duration_unit'];
              $actual_duration = $project_task_items[$cnt]['actual_duration'];
              $percent_complete = $project_task_items[$cnt]['percent_complete'];
              $date_due = $project_task_items[$cnt]['date_due'];
              $time_due = $project_task_items[$cnt]['time_due'];
              $parent_task_id = $project_task_items[$cnt]['parent_task_id'];
              $assigned_user_id = $project_task_items[$cnt]['assigned_user_id'];
              $modified_user_id = $project_task_items[$cnt]['modified_user_id'];
              $priority = $project_task_items[$cnt]['priority'];
              $created_by = $project_task_items[$cnt]['created_by'];
              $milestone_flag = $project_task_items[$cnt]['milestone_flag'];
              $order_number = $project_task_items[$cnt]['order_number'];
              $task_number = $project_task_items[$cnt]['task_number'];
              $estimated_effort = $project_task_items[$cnt]['estimated_effort'];
              $actual_effort = $project_task_items[$cnt]['actual_effort'];
              $deleted = $project_task_items[$cnt]['deleted'];
              $utilization = $project_task_items[$cnt]['utilization'];

              // Get Custom content

              $record_contact_id_c = $project_task_items[$cnt]['contact_id_c'];
              $record_account_id_c = $project_task_items[$cnt]['account_id_c'];
              $itil_stage_c = $project_task_items[$cnt]['itil_stage_c'];
              $itil_stage_process_c = $project_task_items[$cnt]['itil_stage_process_c'];
              $record_projecttask_id_c = $project_task_items[$cnt]['projecttask_id_c'];
              $cmn_statuses_id_c = $project_task_items[$cnt]['cmn_statuses_id_c'];
              $pm_provider = $project_task_items[$cnt]['account_id1_c'];
              $pm_contact = $project_task_items[$cnt]['contact_id1_c'];
              $pm_assignee = $project_task_items[$cnt]['contact_id2_c'];

              } // end for projects

          $field_lingo_pack = $funky_gear->lingo_data_pack ($project_task_items, $name, $description, $name_field_base,$desc_field_base);

          } // is array

       } // if action

    if ($record_contact_id_c == NULL){
       $record_contact_id_c = $contact_id_c;
       }

    if ($record_account_id_c == NULL){
       $record_account_id_c = $account_id_c;
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

    if ($sendiv){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sendiv"; // Field Name
       $tablefields[$tblcnt][1] = "sendiv"; // Full Name
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

       }

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "milestone_flag"; // Field Name
    $tablefields[$tblcnt][1] = $strings["milestone_flag"]; // Full Name
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
    $tablefields[$tblcnt][12] = "10"; // Object Length
    $tablefields[$tblcnt][20] = "milestone_flag"; //$field_value_id;
    $tablefields[$tblcnt][21] = $milestone_flag; //$field_value; 

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "task_number"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TaskNumber"]; // Full Name
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
    $tablefields[$tblcnt][12] = "10"; // Object Length
    $tablefields[$tblcnt][20] = "task_number"; //$field_value_id;
    $tablefields[$tblcnt][21] = $task_number; //$field_value; 

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
    $tablefields[$tblcnt][12] = "50"; // Object Length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_statuses_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["PublicStatus"]; // Full Name
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
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    $tblcnt++;

    if ($status != NULL){
       $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";
       }

    $tablefields[$tblcnt][0] = 'status'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='4e5d68c1-07a0-dd2d-d17c-52a440c52da9' "; // status
    $tablefields[$tblcnt][9][5] = $status; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'status';//$field_value_id;
    $tablefields[$tblcnt][21] = $status; //$field_value;
//    $tablefields[$tblcnt][41] = 1; // flipfields - label/fieldvalue
//    $tablefields[$tblcnt][42] = 1; // no label
    $tablefields[$tblcnt][43] = "<img src=images/blank.gif width=10 height=3>".$status_image; // field extras

//    if ($action == 'view' || $auth == 3){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'project_id'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Project"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
//       $tablefields[$tblcnt][9][1] = 'project,project_cstm'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][1] = 'project,project_cstm'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
//       $tablefields[$tblcnt][9][4] = " project.id='".$project_id."' "; // exception;

       if ($portal_account_id != $sess_account_id){
          # They have the rights to log into the portal
          # Do they have the rights to view tickets?

          $sharing_params[0] = $portal_account_id;
          $sharing_params[1] = $sess_account_id;
          $sharing_info = $funky_gear->portal_sharing ($sharing_params);

          $shared_portal_ticketing = $sharing_info['shared_portal_ticketing'];
          $shared_portal_projects = $sharing_info['shared_portal_projects'];
          $shared_portal_projects_sql = $sharing_info['shared_portal_projects_sql'];
          $shared_portal_slarequests = $sharing_info['shared_portal_slarequests'];
          $shared_portal_slarequest_sql = $sharing_info['shared_portal_slarequest_sql'];

          if ($shared_portal_projects_sql != NULL){
             # add project.id=
             $shared_portal_projects_sql = $funky_gear->replacer("id_c=","project.id=",$shared_portal_projects_sql);
             $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && (".$shared_portal_projects_sql." || project_cstm.account_id_c='".$sess_account_id."') ";
             } else {# if ticketing
             $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$sess_account_id."'";
             } 

          } else {# if not portal_account_id 
          $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$sess_account_id."'";
          }

       #$tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$account_id_c."' ";//$exception;
//       $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$account_id_c."' "; // exception;
       $tablefields[$tblcnt][9][5] = $project_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'Projects';
       $tablefields[$tblcnt][9][7] = "project"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Projects'; //new do
       $tablefields[$tblcnt][9][9] = $project_id; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'project_id';//$field_value_id;
       $tablefields[$tblcnt][21] = $project_id; //$field_value;   

//       } else {

/*
       $tblcnt++;

       $tablefields[$tblcnt][0] = "project_id"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Project"]; // Full Name
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
       $tablefields[$tblcnt][20] = "project_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $project_id; //$field_value;   
*/
//       } 

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'itil_stage_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ITILStage"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='18b8b399-51fb-f9af-c741-52477bc183ab' ";//$exception;
    $tablefields[$tblcnt][9][5] = $itil_stage_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $itil_stage_c; // Current Value
//    $params['ci_data_type'] = $ci_data_type;
//    $params['ci_name_field'] = "name";
//    $params['ci_name'] = $name;
//    $tablefields[$tblcnt][9][10] = $params; // Various Params
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'itil_stage_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $itil_stage_c; //$field_value;

    if ($itil_stage_c){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'itil_stage_process_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ITILStageProcess"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitems_id_c='".$itil_stage_c."' ";//$exception;
    $tablefields[$tblcnt][9][5] = $itil_stage_process_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $itil_stage_process_c; // Current Value
//    $params['ci_data_type'] = $ci_data_type;
//    $params['ci_name_field'] = "name";
//    $params['ci_name'] = $name;
//    $tablefields[$tblcnt][9][10] = $params; // Various Params
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'itil_stage_process_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $itil_stage_process_c; //$field_value;

    }

//    if ($record_projecttask_id_c != NULL && ($action == 'view' || $auth == 3)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'projecttask_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentTask"]; // Full Name
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
//       $tablefields[$tblcnt][9][4] = " project_task_cstm.account_id_c='".$record_account_id_c."' && project_task_cstm.id_c=project_task.id "; // exception
       $tablefields[$tblcnt][9][4] = " project_task.id=project_task_cstm.id_c && project_task_cstm.account_id_c='".$account_id_c."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $record_projecttask_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ProjectTasks';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $record_projecttask_id_c; //$field_value;   

//       }

/*
    if ($auth < 3 && ($action == 'add' || $action == 'edit')){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'projecttask_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ParentTask"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][10] = '0';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $record_projecttask_id_c; //$field_value;   

       } 
*/

    $tblcnt++;

    $tablefields[$tblcnt][0] = "percent_complete"; // Field Name
    $tablefields[$tblcnt][1] = $strings["percent_complete"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type

    $dd_pack = $funky_gear->makepercentage ();
    
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list';
    $tablefields[$tblcnt][9][1] = $dd_pack;//$dropdown_table; // related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";
    $tablefields[$tblcnt][9][5] = $percent_complete; // Current Value
    $tablefields[$tblcnt][9][6] = "";

    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = ""; // Object Length
    $tablefields[$tblcnt][20] = "percent_complete"; //$field_value_id;
    $tablefields[$tblcnt][21] = $percent_complete; //$field_value;   

    $tblcnt++;

    if ($date_start==NULL){
       $date_start = date("Y-m-d");
       }

    $tablefields[$tblcnt][0] = "date_start"; // Field Name
    $tablefields[$tblcnt][1] = $strings["date_start"]; // Full Name
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
    $tablefields[$tblcnt][12] = "20"; // Object Length
    $tablefields[$tblcnt][20] = "date_start"; //$field_value_id;
    $tablefields[$tblcnt][21] = $date_start; //$field_value;   

    $tblcnt++;

    if (!$time_start){
       $time_start = date("H:i:s");
       }

    $tablefields[$tblcnt][0] = "time_start"; // Field Name
    $tablefields[$tblcnt][1] = $strings["time_start"]; // Full Name
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
    $tablefields[$tblcnt][12] = "20"; // Object Length
    $tablefields[$tblcnt][20] = "time_start"; //$field_value_id;
    $tablefields[$tblcnt][21] = $time_start; //$field_value;   

    $tblcnt++;

    if ($date_finish==NULL){
       $date_finish = date("Y-m-d");
       }

    $tablefields[$tblcnt][0] = "date_finish"; // Field Name
    $tablefields[$tblcnt][1] = $strings["date_finish"]; // Full Name
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
    $tablefields[$tblcnt][12] = "20"; // Object Length
    $tablefields[$tblcnt][20] = "date_finish"; //$field_value_id;
    $tablefields[$tblcnt][21] = $date_finish; //$field_value;   

    $tblcnt++;

    if (!$time_finish){
       $time_finish = date("H:i:s");
       }

    $tablefields[$tblcnt][0] = "time_finish"; // Field Name
    $tablefields[$tblcnt][1] = $strings["time_finish"]; // Full Name
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
    $tablefields[$tblcnt][12] = "20"; // Object Length
    $tablefields[$tblcnt][20] = "time_finish"; //$field_value_id;
    $tablefields[$tblcnt][21] = $time_finish; //$field_value;   

    $tblcnt++;

    if (!$date_due){
       $date_due = date("Y-m-d");
       }

    $tablefields[$tblcnt][0] = "date_due"; // Field Name
    $tablefields[$tblcnt][1] = $strings["date_due"]; // Full Name
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
    $tablefields[$tblcnt][12] = "20"; // Object Length
    $tablefields[$tblcnt][20] = "date_due"; //$field_value_id;
    $tablefields[$tblcnt][21] = $date_due; //$field_value;  

    $tblcnt++;

    if (!$time_due){
       $time_due = date("H:i:s");
       }

    $tablefields[$tblcnt][0] = "time_due"; // Field Name
    $tablefields[$tblcnt][1] = $strings["time_due"]; // Full Name
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
    $tablefields[$tblcnt][12] = "20"; // Object Length
    $tablefields[$tblcnt][20] = "time_due"; //$field_value_id;
    $tablefields[$tblcnt][21] = $time_due; //$field_value;   

    if ($record_account_id_c != NULL && ($action == 'view' || $auth == 3)){

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
//       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][4] = " id='".$portal_account_id."' "; // exception
       $tablefields[$tblcnt][9][5] = $record_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $record_account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id && accounts_contacts.account_id='".$record_account_id_c."' "; // exception
//       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $record_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $record_contact_id_c; //$field_value;   

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Account"]; // Full Name
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
       $tablefields[$tblcnt][21] = $record_account_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["User"]; // Full Name
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
       $tablefields[$tblcnt][21] = $record_contact_id_c; //$field_value;   

       }

    ####################################
    # For Agents

    # -> Service Provider Account

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServicesProvider"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $ddpack;
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";
    $tablefields[$tblcnt][9][5] = $pm_provider; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $pm_provider; //$field_value;   

    # -> Service Provider Contact

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
    $tablefields[$tblcnt][1] = "PM"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $conpack; // 
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][5] = $pm_contact; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "firstlast";
    $tablefields[$tblcnt][21] = $pm_contact;
    $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'contact_id2_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Agent"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $conpack; // 
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][5] = $pm_assignee; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "firstlast";
    $tablefields[$tblcnt][21] = $pm_assignee;
    $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

    # For Agents
    ####################################

    $tblcnt++;

    if (!$send_email){
       $send_email=0;
       }

    $tablefields[$tblcnt][0] = "send_email"; // Field Name
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
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = '30'; //length
    $tablefields[$tblcnt][20] = "send_email"; //$field_value_id;
    $tablefields[$tblcnt][21] = $send_email; //$field_value;  


    $taskfields[0] = 'predecessors';
    $taskfields[1] = 'time_start';
    $taskfields[2] = 'time_finish';
    $taskfields[3] = 'duration';
    $taskfields[4] = 'duration_unit';
    $taskfields[5] = 'percent_complete';
    $taskfields[6] = 'date_due';
    $taskfields[7] = 'time_due';
    $taskfields[8] = 'parent_task_id';
    $taskfields[9] = 'assigned_user_id';
    $taskfields[10] = 'modified_user_id';
    $taskfields[11] = 'priority';
    $taskfields[12] = 'created_by';
    $taskfields[13] = 'milestone_flag';
    $taskfields[14] = 'order_number';
    $taskfields[15] = 'task_number';
    $taskfields[16] = 'estimated_effort';
    $taskfields[17] = 'actual_effort';
    $taskfields[18] = 'deleted';
    $taskfields[19] = 'utilization';
      
/* 
    for ($fieldcnt=0;$fieldcnt < count($taskfields);$fieldcnt++){

        $tblcnt++;

        $tablefields[$tblcnt][0] = $taskfields[$fieldcnt]; // Field Name
        $tablefields[$tblcnt][1] = $strings[$taskfields[$fieldcnt]]; // Full Name
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
        $tablefields[$tblcnt][12] = "30"; // Object Length
        $tablefields[$tblcnt][20] = $taskfields[$fieldcnt]; //$field_value_id;
        $tablefields[$tblcnt][21] = ${$taskfields[$fieldcnt]}; //$field_value;   

        }
*/

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
    $tablefields[$tblcnt][12] = "65"; // Object Length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   

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
      $tablefields[$tblcnt][4] = 1; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '100'; // length
      $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][12] = "50"; // Object Length
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
      $tablefields[$tblcnt][11] = ""; // Field ID
      $tablefields[$tblcnt][12] = "65"; // Object Length
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
    $valpack[5] = "1"; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    #
    ###################
    #

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["ProjectTask"]; // container_title
    $container_params[4] = 'ProjectTask'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    if (!$sendiv){
       $returner = $funky_gear->object_returner ('Accounts', $account_id_c);
       $object_return = $returner[1];
       echo $object_return;
       }

    if (($action == 'view' || $action == 'edit') || ($action == 'add' && $project_id != NULL) && !$sendiv){

       $returner = $funky_gear->object_returner ('Projects', $project_id);
       $object_return = $returner[1];
       echo $object_return;
       }

    if (($action == 'view' || $action == 'edit') || ($action == 'add' && $record_projecttask_id_c != NULL) && !$sendiv){
       $returner = $funky_gear->object_returner ('ProjectTasks', $val);
       $object_return = $returner[1];
       echo $object_return;

       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";
       echo "<center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$parent_account_id."&valuetype=Parent&source=".$do."&sourceval=".$val."');return false\" class=\"css3button\"><B>".$strings["AttachServicesTask"]."</B></a></center>";

//       echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=list&value=".$val."&valuetype=".$do."');return false\" class=\"css3button\"><B>".$strings["AttachServicesTask"]."</B></a></center>";
       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";
       }

    echo $container_top;
  
    echo $zaform;

    echo $container_bottom;

    #
    ###################
    #

    if ($action == 'view' || $action == 'edit' && !$sendiv){

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["Effects"]; // container_title
       $container_params[4] = 'Effects'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       # Gather related tasks
       $eventtasks_ci_object_type = 'ConfigurationItems';
       $eventtasks_ci_action = "select";
       $eventtasks_ci_params[0] = "name='".$val."'";
       $eventtasks_ci_params[1] = "sclm_configurationitems_id_c"; // select array
       $eventtasks_ci_params[2] = ""; // group;
       $eventtasks_ci_params[3] = " sclm_configurationitems_id_c, name, date_entered DESC "; // order;
       $eventtasks_ci_params[4] = ""; // limit
  
       $eventtasks_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $eventtasks_ci_object_type, $eventtasks_ci_action, $eventtasks_ci_params);

       if (is_array($eventtasks_ci_items)){

          for ($eventtasks_cnt=0;$eventtasks_cnt < count($eventtasks_ci_items);$eventtasks_cnt++){

              $eventtask_wrapper_id = $eventtasks_ci_items[$eventtasks_cnt]['sclm_configurationitems_id_c'];

              $events_ci_object_type = 'ConfigurationItems';
              $events_ci_action = "select";
              $events_ci_params[0] = "id='".$eventtask_wrapper_id."'";
              $events_ci_params[1] = "name"; // select array
              $events_ci_params[2] = ""; // group;
              $events_ci_params[3] = " name, date_entered DESC "; // order;
              $events_ci_params[4] = ""; // limit
  
              $events_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $events_ci_object_type, $events_ci_action, $events_ci_params);
              if (is_array($events_ci_items)){

                 for ($events_cnt=0;$events_cnt < count($events_ci_items);$events_cnt++){

                     $event_id = $events_ci_items[$events_cnt]['name'];

                     $event_namer = $funky_gear->object_returner ("Events", $event_id);
                     $event_name = $event_namer[0];
                     $events .= "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$event_id."&valuetype=ProjectTasks');return false\"><font color=#151B54><B>".$event_name."</B></font></a><BR>";

                     } # for

                 $projecttasksevents = "<B>Related Events:</B><P>".$events;
                 $projecttasksevents .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Another Related Effect/Event</B></font></a></div>";

                 } else {# is array
                 $projecttasksevents = "<B>There are no related events for this task..</B><BR>";
                 $projecttasksevents .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Related Effect/Event</B></font></a></div>";
                 }

              } # for

          } else {# is array
          $projecttasksevents = "<B>There are no related events for this task..</B>";
          $projecttasksevents .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&value=".$val."&valuetype=ProjectTasks&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Add Related Effect/Event</B></font></a></div>";
          }

       echo $container_top;

       echo "<div style=\"".$divstyle_white."\">".$projecttasksevents."</div>";

       echo $container_bottom;


       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["RelatedTasks"]; // container_title
       $container_params[4] = 'RelatedTasks'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;
   
       $this->funkydone ($_POST,$lingo,'ProjectTasks','list',$val,$do,$bodywidth);       

       echo $container_bottom;

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["ServiceSLARequests"]; // container_title
       $container_params[4] = 'TasksServiceSLARequests'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'ServiceSLARequests','list',$val,$do,$bodywidth);       

       echo $container_bottom;

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["Tickets"]; // container_title
       $container_params[4] = 'Tickets'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'Ticketing','list',$val,$do,$bodywidth);       

       echo $container_bottom;

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

       echo $container_top;
   
       $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);     

       echo $container_bottom;

       } # if view

    #
    ###################

   break; // end view
   case 'process':

    if ($sendiv == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       #$BodyDIV = $sendiv;
       }

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
       $process_params[] = array('name'=>'assigned_user_id','value' => 1);
       $process_params[] = array('name'=>'date_entered','value' => $_POST['date_entered']);
       $process_params[] = array('name'=>'date_modified','value' => $_POST['date_modified']);
       $process_params[] = array('name'=>'project_id','value' => $_POST['project_id']);
       $process_params[] = array('name'=>'project_task_id','value' => $_POST['project_task_id']);
       $process_params[] = array('name'=>'status','value' => $_POST['status']);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'predecessors','value' => $_POST['predecessors']);
       $process_params[] = array('name'=>'date_start','value' => $_POST['date_start']);
       $process_params[] = array('name'=>'time_start','value' => $_POST['time_start']);
       $process_params[] = array('name'=>'time_finish','value' => $_POST['time_finish']);
       $process_params[] = array('name'=>'date_finish','value' => $_POST['date_finish']);
       $process_params[] = array('name'=>'duration','value' => $_POST['duration']);
       $process_params[] = array('name'=>'duration_unit','value' => $_POST['duration_unit']);
       $process_params[] = array('name'=>'actual_duration','value' => $_POST['actual_duration']);
       $process_params[] = array('name'=>'percent_complete','value' => $_POST['percent_complete']);
       $process_params[] = array('name'=>'date_due','value' => $_POST['date_due']);
       $process_params[] = array('name'=>'time_due','value' => $_POST['time_due']);
       $process_params[] = array('name'=>'parent_task_id','value' => $_POST['parent_task_id']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       $process_params[] = array('name'=>'modified_user_id','value' => $_POST['modified_user_id']);
       $process_params[] = array('name'=>'priority','value' => $_POST['priority']);
       $process_params[] = array('name'=>'created_by','value' => $_POST['created_by']);
       $process_params[] = array('name'=>'milestone_flag','value' => $_POST['milestone_flag']);
       $process_params[] = array('name'=>'order_number','value' => $_POST['order_number']);
       $process_params[] = array('name'=>'task_number','value' => $_POST['task_number']);
       $process_params[] = array('name'=>'estimated_effort','value' => $_POST['estimated_effort']);
       $process_params[] = array('name'=>'actual_effort','value' => $_POST['actual_effort']);
       $process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
       $process_params[] = array('name'=>'utilization','value' => $_POST['utilization']);

       # Get Custom content
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'itil_stage_c','value' => $_POST['itil_stage_c']);
       $process_params[] = array('name'=>'itil_stage_process_c','value' => $_POST['itil_stage_process_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
       $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
       $process_params[] = array('name'=>'contact_id2_c','value' => $_POST['contact_id2_c']);

       foreach ($_POST as $name_key=>$name_value){

               $name_lingo = str_replace("name_","",$name_key);
               $name_lingo = str_replace("_c","",$name_lingo);

               if ($name_lingo != NULL && in_array($name_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$name_key,'value' => $name_value);

                  } // if namelingo

               } // end foreach

       foreach ($_POST as $desc_key=>$desc_value){

               $desc_lingo = str_replace("description_","",$desc_key);
               $desc_lingo = str_replace("_c","",$desc_lingo);

               if ($desc_lingo != NULL && in_array($desc_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$desc_key,'value' => $desc_value);

                  } // if namelingo

               } // end foreach

  
       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       if ($_POST['send_email']==1){

          # Notify assignee of task
          $assignee = $_POST['contact_id2_c'];

          if ($assignee != NULL){

             $contact_object_type = "Contacts";
             $contact_action = "select_soap";
             $contact_params = array();
             $contact_params[0] = "contacts.id='".$assignee."'"; // query
             $contact_params[1] = array("first_name","last_name","email1");

             $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
             for ($cntcon=0;$cntcon < count($contact_info);$cntcon++){

                 $first_name = $contact_info[$cntcon]['first_name'];
                 $last_name = $contact_info[$cntcon]['last_name'];
                 $to_email = $contact_info[$cntcon]['email1'];
                 $to_name = $first_name." ".$last_name;
                 $notification_addressees[$to_email] = $to_name;

                 } // for

             $from_name = $portal_title;
             $from_email = $portal_email;
             $from_email_password = $portal_email_password;

             $type = 1;

             $mailparams[0] = $from_name;
             #$mailparams[1] = $to_name;
             $mailparams[2] = $from_email;
             $mailparams[3] = $from_email_password;
             #$mailparams[4] = $to_email;
             $mailparams[5] = $type;
             $mailparams[6] = $lingo;

             # Used if needing to send clean email based on vendor code
             $mailparams[7] = "Project Task Assignment: ".$_POST['name'];

             $message_link = "Body@".$lingo."@ProjectTasks@view@".$val."@ProjectTasks";
             $message_link = $funky_gear->encrypt($message_link);
             $message_link = "http://".$hostname."/?pc=".$message_link;

             $mailparams[8] = $_POST['description']."\n\n".$strings["action_view_here"].":\n\n".$message_link;
             $mailparams[9] = $portal_email_server;
             $mailparams[10] = $portal_email_smtp_port;
             $mailparams[11] = $portal_email_smtp_auth;
             $mailparams[12] = $notification_addressees;
             #$mailparams[20] = $attachments;

             $emailresult = $funky_gear->do_email ($mailparams);

             $process_message .= "<P>Email Result for Tasks Assignee: ".$emailresult."<P>";

             } # end get assignee info

          } # end send notifications

    if ($sendiv == 'lightform'){

       $process_message = $strings["SubmissionSuccess"]."<P><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">".$strings["action_edit"]."</a> || <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">".$strings["action_view_here"]."</a><P>";

       } else {

       $process_message = $strings["SubmissionSuccess"]."<P><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_edit"]."</a> || <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

       }

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