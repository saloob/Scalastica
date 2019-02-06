<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-05-26
# Page: Tickets.php 
##########################################################
# case 'Tickets':

  $this_module = '6244acfb-1ade-84f4-e35f-5277c7416024';
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

  $lingoname = "name_en";

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = "GRID";
     }

/*
  $ci_params[0] = " deleted=0 ";

  switch ($system_action_list){

   case $action_rights_all:
    $ci_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
   break;
   case $action_rights_none:
    $ci_params[0] .= " && cmn_statuses_id_c = 'ZZZZZZZZZZZZZZZZZZ' ";
   break;
   case $action_rights_owner:
    $ci_params[0] .= " && contact_id_c = '".$_SESSION['contact_id']."' ";
   break;
   case $action_rights_account:
    $ci_params[0] .= " && account_id_c = '".$_SESSION['account_id']."' ";
   break;

  } // end system_action_list
*/

  if (!$account_id_c){
     $account_id_c = $portal_account_id;
     }

  if (!$contact_id_c){
     $contact_id_c = $portal_admin;
     }

  if (!$ci_contact_id_c){
     $ci_contact_id_c = $contact_id_c;
     }

  if (!$ci_account_id_c){
     $ci_account_id_c = $account_id_c;
     }

  if (!$ci_account_id1_c){
     $ci_account_id1_c = $sess_account_id;
     }

  if (!$ci_contact_id1_c){
     $ci_contact_id1_c = $sess_contact_id;
     }

  if ($sendiv != NULL){
     #$BodyDIV = $sendiv;
     }

  $glb_perpage_items = $_POST['rows'];
  if (!$glb_perpage_items){
     $glb_perpage_items = 100;
     }

  if ($action != 'list' && $action != 'gridlist'){

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " account_id_c='".$portal_account_id."' ";
       $acc_params[1] = " account_id1_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id1_c "; // order;
       $acc_params[4] = ""; // limit
  
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

     } // end if not lists

  if (!$_SESSION['contact_id']){
     echo "<P><a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=logout&value=&valuetype=');return false\"><B>Your Session has ended - please log in again..</B></a>";
     exit;
     }

    $today = date("Y-m-d");
    $this_year = date("Y");
    $this_month = date("m");
    $this_yearmonth = date("Y-m");
    if ($this_month <=12 && $this_month > 2){
       $last_month = $this_month-1;
       }

   ################################
   # Shared Access

   if ($action == 'list' || $action == 'gridlist' || $action == 'search'){

      if ($portal_account_id != $sess_account_id){
         # They have the rights to log into the portal
         # Do they have the rights to view tickets?

         $sharing_params[0] = $portal_account_id;
         $sharing_params[1] = $sess_account_id;
         $sharing_info = $funky_gear->portal_sharing ($sharing_params);

         $shared_portal_ticketing = $sharing_info['shared_portal_ticketing'];
         $shared_portal_projects = $sharing_info['shared_portal_projects'];
         $shared_portal_slarequests = $sharing_info['shared_portal_slarequests'];
         $shared_portal_slarequest_sql = $sharing_info['shared_portal_slarequest_sql'];

         #var_dump($shared_portal_slarequest_sql);
         #echo "<P>shared_portal_ticketing: ".$shared_portal_ticketing." && shared_portal_slarequests: ".$shared_portal_slarequest_sql."<P>";

         if ($shared_portal_ticketing == 1 && $shared_portal_slarequest_sql != NULL){
            $ticket_params[0] = " deleted=0 && (".$shared_portal_slarequest_sql.") ";
            } else {# if ticketing
            $ticket_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
            } 

         } else {# if not portal_account_id 
         $ticket_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
         }

      } else {# End if list
      $ticket_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
      } 

   # End Shared Access
   ################################

   if ($action == 'view'){
      #$back = "<center><a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=gridlist&value=".$val."&valuetype=".$valtype."');return false\"><font size=4><B>".$strings["Tickets"]." [Grid]</B></font></a></center>";
      }

   if ($sendiv){
      #$rowmaker = "<center><font size=3><B>[".$glb_perpage_items."]</B></font> <a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=gridlist&value=".$val."&valuetype=".$valtype."&rows=15&sendiv=GRID');return false\"><font size=3><B>[15]</B></font></a> <a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=gridlist&value=".$val."&valuetype=".$valtype."&rows=50&sendiv=GRID');return false\"><font size=3><B>[50]</B></font></a> <a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=gridlist&value=".$val."&valuetype=".$valtype."&rows=100&sendiv=GRID');return false\"><font size=3><B>[100]</B></font></a> </center>";
      } else {
      # $rowmaker = "<center><font size=3><B>[".$glb_perpage_items."]</B></font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."&rows=15');return false\"><font size=3><B>[15]</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."&rows=50');return false\"><font size=3><B>[50]</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."&rows=100');return false\"><font size=3><B>[100]</B></font></a></center>";
      }

#    $ticket_return = " <center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."');return false\"><font size=4><B>".$strings["Tickets"]."</B></font></a> || <a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=gridlist&value=".$val."&valuetype=".$valtype."&sendiv=GRID');return false\"><font size=4><B>".$strings["Tickets"]." [Grid]</B></font></a></center> ".$rowmaker;

    #$ticket_return = " <center><a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=gridlist&value=".$val."&valuetype=".$valtype."&sendiv=GRID');return false\"><font size=4><B>".$strings["Tickets"]."</B></font></a></center> ".$rowmaker;

    # Keep not null for now - disabled above sql code until account-based tickets is set
    #$shared_ticket_params = "check";

   switch ($auth){

    case 1:

     #$ticket_menu = "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=&valuetype=total');return false\"><font size=4><B>".$strings["TicketSummary"]."</B></font></a></center>";
     #$ticket_menu .= "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=".$today."&valuetype=date');return false\"><font size=4><B>".$today."</B></font></a></center>";

    break;
    case 2:

     #$ticket_menu = "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=&valuetype=total');return false\"><font size=4><B>".$strings["TicketSummary"]."</B></font></a></center> ".$ticket_return;

     #$ticket_menu = $ticket_return;

    break;
    case 3:

     #$ticket_menu = "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=summary&value=&valuetype=total');return false\"><font size=4><B>".$strings["TicketSummary"]."</B></font></a></center> ".$ticket_return;

     $ticket_menu = $ticket_return;

    break;

   } // end auth switch

   $search_date = $_POST['date'];
   if (!$search_date){
      $search_date = $_GET['date'];
      }

   $search_ticket_id = $_POST['ticket_id'];
   $search_keyword = $_POST['keyword'];

   if ($action == 'search'){

      # Leave status search until later to keep full summary list of statuses
      if ($search_ticket_id != NULL){
         $ticket_params[0] .= " && ticket_id like '%".$search_ticket_id."%' ";
         }

      if ($search_keyword != NULL){
         $vallength = strlen($search_keyword);
         $trimval = substr($search_keyword, 0, -1);
         $ticket_params[0] .= " && (description like '%".$search_keyword."%' || name like '%".$search_keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%' )";
         }

      if ($search_keyword == NULL && $search_ticket_id == NULL && $search_date != NULL){
         $ticket_params[0] .= " && date_entered like '%".$search_date."%' ";
         } elseif ($search_keyword == NULL && $search_ticket_id == NULL && $search_date == NULL) {
         $ticket_params[0] .= " && date_entered like '%".$today."%' ";
         } 

      } // if action search

   if ($action != 'search' && $search_date == NULL){
      $ticket_params[0] .= " && date_entered like '%".$today."%' ";
      }

   switch ($valtype){

    case 'Content':
     $ticket_params[0] .= " && id='".$val."' ";
     $sclm_ticketing_id_c = $val;
    break;
    case 'Emails':
     $ticket_params[0] .= " && sclm_emails_id_c='".$val."' ";
     $sclm_emails_id_c = $val;
    break;
    case 'ServiceSLARequests':
     $ticket_params[0] .= " && sclm_serviceslarequests_id_c='".$val."' ";
     $sclm_serviceslarequests_id_c = $val;
    break;
    case 'SOWItems':
     $ticket_params[0] .= " && sclm_sowitems_id_c='".$val."' ";
     $sclm_sowitems_id_c = $val;
    break;
    case 'ProjectTasks':
     $ticket_params[0] .= " && projecttask_id_c='".$val."' ";
     $projecttask_id_c = $val;
    break;
    case 'Projects':
     $ticket_params[0] .= " && project_id_c='".$val."' ";
     $project_id_c = $val;
    break;

    }

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

    function status_summary ($fullsummarypack,$extraparams){

    global $BodyDIV,$do,$portalcode,$action;

    $search_date = $extraparams[0];

    foreach ($fullsummarypack as $key => $value){

            $date = $value['date_entered'];
            if (!in_array($date,$dates)){
               $datereturned = getcount ($fullsummarypack,$date,'date_entered');
               $datecount[] = $datereturned[0];
               $datepack[] = $datereturned[1];
               $dates[] = $date;
               }

            $status = $value['status'];
            $status_name = $value['status_name'];
            $status_name_ja = $value['status_name_ja'];
            $status_image = $value['status_image'];
            #if (is_array($statuses) && !in_array($status,$statuses)){
            if (!in_array($status,$statuses)){
               $statusreturned = getcount ($fullsummarypack,$status_name,'status_name');
               $statuscount = $statusreturned[0];
               $statuscounter[] = $statusreturned[0];
               $statuspack[] = $statusreturned[1];
               $statuses[] = $status;
               $statusnames[] = $status_name;
/*
               if ($action == 'gridlist'){
                  $thisdiv = "GRID";
                  } else {
                  $thisdiv = $BodyDIV;
                  }
*/
               $thisdiv = "GRID";

               if ($lang == 'ja'){
                  $status_images .= "<img src=".$status_image." width=16> <a href=\"#\" onClick=\"loader('".$thisdiv."');doBPOSTRequest('".$thisdiv."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=search&value=".$status."&valuetype=status&date=".$search_date."');return false\">".$status_name_ja."[".$statuscount."]</a> | ";
                  } else {
                  $status_images .= "<img src=".$status_image." width=16> <a href=\"#\" onClick=\"loader('".$thisdiv."');doBPOSTRequest('".$thisdiv."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=search&value=".$status."&valuetype=status&date=".$search_date."');return false\">".$status_name."[".$statuscount."]</a> | ";
                  } 
               } // if statuses

            } // foreach

     $summaryinfo[0] = $statuspack;
     $summaryinfo[1] = $datepack;
     $summaryinfo[2] = $status_images;

     return $summaryinfo;

    } // end function status_summary ($fullsummarypack)

    #
    ######################

  #
  #################################################
  # Start Actions

  switch ($action){
   
   #####################################
   # Charts and other summary items

   case 'summary':

   
/*

Series Type

No. of variables	
Datasource Properties

 	  	 
Basic

 	 
Line

2	
XValues, YValues, XLabel

Fast Line

2	
XValues, YValues, XLabel

Bar

2	
XValues, YValues (called Bar), XLabel

HorizBar

2	
XValues, YValues (called Bar), XLabel

Area

2	
XValues, YValues, XLabel

Point

2	
Xvalues, YValues, XLabel

Pie

1	
PieValues, XLabel

Arrow

4	
StartXValues, StartYValues, XLabel, EndXValues, EndYValues

Bubble

3	
Xvalues, YValues, XLabel, RadiusValues

Gantt

3	
StartValues, EndValues, AY (Y axis level), AXLabel (Label optionally shown on Y-axis or as mark)

Shape

4	
X0 (Top), Y0 (Bottom), X1 (Left), Y1 (Right)

Extended

 	 
Bezier

2	
XValues, YValues, XLabel

Candle

5	
OpenValues, CloseValues, HighValues, LowValues, DateValues

Contour

3	
XValues, YValues, XLabel, ZValues

Error Bar

3	
XValues, YValues, XLabel, ErrorValues

Point3D

3	
XValues, YValues, XLabel, ZValues

Polar

2	
XValues, YValues, Labels (Polar has Angle and Radius)

Radar

2	
XValues, YValues, Labels (Radar has Angle and Radius)

3D Surface

3	
XValues, YValues, ZValues

Volume

2	
XValues, YValues (VolumeValues), XLabel

Labelling can be used to extend the value of a 2 variable Series Type. See the example below that uses 3 instances of the Bar Series type in the same Chart.

Example

Uses Bar Series types

Product code	Month	Quantity produced
10	Jan	300
10	Feb	325
10	Mar	287
12	Jan	175
12	Feb	223
12	Mar	241
14	Jan	461
14	Feb	470
14	Mar	455


*/

    require_once "charting/libTeeChart.php";

    #echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["TicketSummary"]."</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo $ticket_menu;
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    switch ($valuetype){

     case '':
     case 'total':
     case 'date':

     $ticket_object_type = $do;
     $ticket_action = "select";
     $ticket_params[1] = ""; // select array
     $ticket_params[2] = ""; // group;
     $ticket_params[3] = " service_operation_process, name, date_entered DESC "; // order;
     $ticket_params[4] = "2000"; // limit
     #Until fix mojobake
     #$ticket_params[5] = $lingoname; // lingo
     $ticket_params[5] = "name_en"; // lingo

     $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

     if (is_array($ticket_items)){

        for ($cnt=0;$cnt < count($ticket_items);$cnt++){

            $id = $ticket_items[$cnt]["id"];
            $name = $ticket_items[$cnt]["name"];
            $date_entered = $ticket_items[$cnt]['date_entered'];
            $date_modified = $ticket_items[$cnt]['date_modified'];
            $modified_user_id = $ticket_items[$cnt]['modified_user_id'];
            $created_by = $ticket_items[$cnt]['created_by'];
            $description = $ticket_items[$cnt]['description'];
            $deleted = $ticket_items[$cnt]['deleted'];
            $assigned_user_id = $ticket_items[$cnt]['assigned_user_id'];
            $ci_account_id_c = $ticket_items[$cnt]['account_id_c'];
            $ci_contact_id_c = $ticket_items[$cnt]['contact_id_c'];
            $ci_account_id1_c = $ticket_items[$cnt]['account_id1_c'];
            $ci_contact_id1_c = $ticket_items[$cnt]['contact_id1_c'];
            $ci_type_id = $ticket_items[$cnt]['ci_type_id']; // parent item
            $service_operation_process = $ticket_items[$cnt]['service_operation_process'];
            $service_operation_process_name = $ticket_items[$cnt]['service_operation_process_name'];
            $ticket_id = $ticket_items[$cnt]['ticket_id'];
            $sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];
            $project_id_c = $ticket_items[$cnt]['project_id_c']; 
            $projecttask_id_c = $ticket_items[$cnt]['projecttask_id_c']; 
            $sclm_sowitems_id_c = $ticket_items[$cnt]['sclm_sowitems_id_c'];
            $status = $ticket_items[$cnt]['status'];
            $status_image = $ticket_items[$cnt]['status_image'];
            $status_name = $ticket_items[$cnt]['status_name'];
            $status_name_ja = $ticket_items[$cnt]['status_name_ja'];

            $date_entered = substr($date_entered, 0,10);

            $fullsummarypack[$cnt]['date_entered'] = $date_entered;
            $fullsummarypack[$cnt]['name'] = $name;
            $fullsummarypack[$cnt]['status'] = $status;
            $fullsummarypack[$cnt]['status_name'] = $status_name;
            $fullsummarypack[$cnt]['status_name_ja'] = $status_name_ja;
            $fullsummarypack[$cnt]['status_image'] = $status_image;

            } // for

        } // if

/*
        $chart1 = new TChart(400,250);

        $chart1->getChart()->getHeader()->setText($strings["TicketSummaryFull"]);
        $chart1->getChart()->getAspect()->setChart3DPercent(45);

        $pie=new Pie($chart1->getChart());
        $pie->getMarks()->setVisible(true);
        $pie->getMarks()->setTransparent(true);
        $pie->getMarks()->setArrowLength(-65);
        $pie->getMarks()->getArrow()->setVisible(false);
        $pie->setCircled(true);
        ThemesList::applyTheme($chart1->getChart(),1);  // BlackIsBack 
        $pie->getMarks()->getFont()->setColor(Color::White());
                
        // Setup the Pie
        $pie->setBevelPercent(20);
        $pie->addArray($ydata);
        $pie->setLabels($labels);

        $chart1->getChart()->getSeries(0)->setColorEach(true);

        $chart_temp_directory = 'tmp';  
        
        // Create the Chart and write to file 
        //$chart1->render($chart_temp_directory . '/' . 'chart.png');    
        //$data['chart'] = $chart_temp_directory . '/' . 'chart.png';
        //$this->load->view('chart_view', $data);  
        $chartdate = date("Y-m-d");
        $ticketsummaryfull = "content/tmp/TicketSummaryFull-".$chartdate."-".$account_id_c.".png";
        $chart1->render($ticketsummaryfull);

        echo "<center><img alt=\"".$strings["TicketSummaryFull"]."\" src=\"".$ticketsummaryfull."\" style=\"border: 1px solid gray;\"/></center>";

$chart = new TChart(500,500);
$chart->getAspect()->setView3D(false); 
$chart->getHeader()->setText($strings["TicketSummaryFull"]); 
$chart->getHeader()->setVisible(false); 

$chart->getLegend()->setVisible(false); 

$chart->getAxes()->getBottom()->setMinimumOffset(10); 
$chart->getAxes()->getBottom()->setMaximumOffset(10); 
$chart->getAxes()->getTop()->setMinimumOffset(10); 
$chart->getAxes()->getTop()->setMaximumOffset(10); 

$line1=new HorizBar($chart->getChart());   
//$data = Array(66,35,55,49,40,50,82,90,95,86,65,50,65,35,175,125,200,175); 
$line1->addArray($ydata); 

$labels = Array('James','John','Chris','Alison','Henri','Jason','Eddi','Joseph', 'Yngvart','Jorn','Sally', 
    'Sam','Jeremy','Charles','Tom','Albert','Thomas','Janet'); 

$line1->setLabels($labels); 
$line1->setColor(new Color(47,54,153)); 
$chart->getAxes()->getLeft()->getLabels()->setStyle(AxisLabelStyle::$TEXT); 
$chart->getAxes()->getLeft()->getLabels()->setAlign(AxisLabelAlign::$OPPOSITE); 

$line1->getMarks()->getArrow()->setVisible(false); 
$line1->getMarks()->setArrowLength(-52); 
$line1->getMarks()->setTransparent(true); 
$line1->getMarks()->getFont()->setColor(Color::BLACK()); 

$chart->getAxes()->getLeft()->setGridCentered(true); 
$line1->setHorizontalAxis(HorizontalAxis::$BOTH); 
$chart->getAxes()->getBottom()->getTitle()->setText($strings["Tickets"]); 
$chart->getAxes()->getTop()->getTitle()->setText($strings["Tickets"]); 

$chartdate = date("Y-m-d");
$ticketsummaryfull = "content/tmp/TicketSummaryFull-".$chartdate."-".$account_id_c.".png";

$chart->render($ticketsummaryfull); 

//$rand=rand(); 
//print '<img src="chart1.png?rand='.$rand.'">';    
    echo "<center><a href=\"".$ticketsummaryfull."\" data-lightbox=\"".$valtype."\" title=\"".$name."\"><img alt=\"".$strings["TicketSummaryFull"]."\" src=\"".$ticketsummaryfull."\" width=450 style=\"border: 1px solid gray;\"/></a></center>";
*/


    echo "<div style=\"".$formtitle_divstyle_white."\">".$strings["TicketSummaryMessage"]."</div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="keyword" name="keyword" value="<?php echo $search_keyword; ?>" size="20">
     <input type="text" id="date" name="date" value="<?php echo $today; ?>" size="20">
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
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


    $extraparams[0] = $search_date;
    $summaryinfo = status_summary ($fullsummarypack,$extraparams);
    $statuspack = $summaryinfo[0];
    $datepack = $summaryinfo[1];
    $status_images = $summaryinfo[2];

    echo "<div style=\"".$formtitle_divstyle_white."\">".$status_images."</div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    ######################
/*
    $chart = new TChart(500,500);
    $chart->getAspect()->setView3D(false); 
    $chart->getHeader()->setText($strings["TicketSummaryFull"]); 
    $chart->getHeader()->setVisible(false); 

    $chart->getLegend()->setVisible(false); 

    $chart->getAxes()->getBottom()->setMinimumOffset(10); 
    $chart->getAxes()->getBottom()->setMaximumOffset(10); 
    $chart->getAxes()->getTop()->setMinimumOffset(10); 
    $chart->getAxes()->getTop()->setMaximumOffset(10); 

    $line1=new HorizBar($chart->getChart());   
    //$line1->addArray($ydata); 
    $line1->addArray($statuscounter); 
//    $line1->setLabels($labels); 
    $line1->setLabels($statusnames); 
    $line1->setColor(new Color(47,54,153)); 
    $chart->getAxes()->getLeft()->getLabels()->setStyle(AxisLabelStyle::$TEXT); 
    $chart->getAxes()->getLeft()->getLabels()->setAlign(AxisLabelAlign::$OPPOSITE); 

    $line1->getMarks()->getArrow()->setVisible(false); 
    $line1->getMarks()->setArrowLength(-52); 
    $line1->getMarks()->setTransparent(true); 
    $line1->getMarks()->getFont()->setColor(Color::BLACK()); 

    $chart->getAxes()->getLeft()->setGridCentered(true); 
    $line1->setHorizontalAxis(HorizontalAxis::$BOTH); 
    $chart->getAxes()->getBottom()->getTitle()->setText($strings["Tickets"]); 
    $chart->getAxes()->getTop()->getTitle()->setText($strings["Tickets"]); 

    $chartdate = date("Y-m-d");
    $ticketsummaryfull = "content/tmp/TicketSummaryFull-".$chartdate."-".$account_id_c.".png";

    $chart->render($ticketsummaryfull); 

    echo "<center><a href=\"".$ticketsummaryfull."\" data-lightbox=\"".$valtype."\" title=\"".$name."\"><img alt=\"".$strings["TicketSummaryFull"]."\" src=\"".$ticketsummaryfull."\" width=450 style=\"border: 1px solid gray;\"/></a></center>";
*/
    ######################

        $chart2 = new TChart(400,250);
//Until fix mojobake
//        $chart2->getChart()->getHeader()->setText($strings["TicketSummaryByDate"]);
        $chart2->getChart()->getHeader()->setText("Ticket Summary by Date");
        $horizBar=new HorizBar($chart2->getChart());
        $horizBar->addArray($datepack);
        $chart2->getChart()->getSeries(0)->setColorEach(true);
 
        $ticketbydate = "content/tmp/TicketByDate-".$chartdate."-".$account_id_c.".png";

        $chart2->render($ticketbydate);

        echo "<center><a href=\"".$ticketbydate."\" data-lightbox=\"".$valtype."\" title=\"".$strings["TicketSummaryByDate"]."\"><img alt=\"".$strings["TicketSummaryByDate"]."\" src=\"".$ticketbydate."\" width=450 style=\"border: 1px solid gray;\"/></a></center>";

    ######################

        $chart3 = new TChart(400,250);
//Until fix mojobake
//        $chart2->getChart()->getHeader()->setText($strings["TicketSummaryByStatus"]);
        $chart3->getChart()->getHeader()->setText("Ticket Summary by Status");
        $horizBar=new HorizBar($chart3->getChart());
        $horizBar->addArray($statuspack);
        $chart3->getChart()->getSeries(0)->setColorEach(true);

        $ticketbystatus = "content/tmp/TicketByStatus-".$chartdate."-".$account_id_c.".png";

        $chart3->render($ticketbystatus);

        echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
        echo "<center><a href=\"".$ticketbystatus."\" data-lightbox=\"".$valtype."\" title=\"".$strings["TicketSummaryByStatus"]."\"><img alt=\"".$strings["TicketSummaryByStatus"]."\" src=\"".$ticketbystatus."\" width=450 style=\"border: 1px solid gray;\"/></a></center>";

    ######################

   break;

   } // end type

   break; // summary
   case 'list':
   case 'gridlist':
   case 'search':

    $titlewidth = "420px";
    $idwidth = "80px";
    $processwidth = "50px";
    $datewidth = "80px";
    $accumwidth = "30px";
    $iconwidth = "16px";
    $filterwidth = "150px";

    if ($action == 'gridlist' || $sendiv == 'GRID'){

       #echo "<center><a href=\"#\" onClick=\"loader('GRID');cleardiv('GRID');document.getElementById('GRID').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

       # Set up the column headers
       $divstyle_params[0] = $titlewidth; // minwidth
       $divstyle_params[1] = "40px"; // minheight
       $divstyle_params[2] = "0px"; // margin_left
       $divstyle_params[3] = "2px"; // margin_right
       $divstyle_params[4] = "4px"; // padding_left
       $divstyle_params[5] = "2px"; // padding_right
       $divstyle_params[6] = "0px"; // margin_top
       $divstyle_params[7] = "0px"; // margin_bottom
       $divstyle_params[8] = "5px"; // padding_top
       $divstyle_params[9] = "2px"; // padding_bottom
       #$divstyle_params[10] = "#FFFFFF"; // custom_color_back
       $divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
       #$divstyle_params[10] = "#e6ebf8 50% 50% repeat-x"; // custom_color_back
       $divstyle_params[11] = "#d3d3d3"; // custom_color_border
       $divstyle_params[12] = "left"; // custom_float
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth

       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_title = $divstyle[5];

       $divstyle_params[0] = $idwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_id = $divstyle[5];

       $divstyle_params[0] = $datewidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_date = $divstyle[5];

       $divstyle_params[0] = $processwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_process = $divstyle[5];

       $divstyle_params[0] = $accumwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_accum = $divstyle[5];

       $divstyle_params[0] = $filterwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_filter = $divstyle[5];

       $divstyle_params[0] = $iconwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_icon = $divstyle[5];

       $ticketheader = "<div style=\"".$div_icon."\"> </div>";
       $ticketheader .= "<div style=\"".$div_date."\"><B>".$strings["Date"]."</B></div>";
       $ticketheader .= "<div style=\"".$div_id."\"><B>ID</B></div>";
       $ticketheader .= "<div style=\"".$div_process."\"><B>".$strings["ServiceOperationProcess"]."</B></div>";
       $ticketheader .= "<div style=\"".$div_accum."\"><B>".$strings["AccumulatedMinutes"]."</B></div>";
       $ticketheader .= "<div style=\"".$div_title."\"><B>".$strings["Title"]."</B></div>";
       $ticketheader .= "<div style=\"".$div_filter."\"><B>".$strings["Filter"]."</B></div>";

       # Set up the column headers
       $divstyle_params[0] = $titlewidth; // minwidth
       $divstyle_params[1] = "100px"; // minheight
       $divstyle_params[2] = "0px"; // margin_left
       $divstyle_params[3] = "2px"; // margin_right
       $divstyle_params[4] = "4px"; // padding_left
       $divstyle_params[5] = "2px"; // padding_right
       $divstyle_params[6] = "0px"; // margin_top
       $divstyle_params[7] = "0px"; // margin_bottom
       $divstyle_params[8] = "5px"; // padding_top
       $divstyle_params[9] = "2px"; // padding_bottom
       $divstyle_params[10] = "#FFFFFF"; // custom_color_back
       #$divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
       #$divstyle_params[10] = "#e6ebf8 50% 50% repeat-x"; // custom_color_back
       $divstyle_params[11] = "#d3d3d3"; // custom_color_border
       $divstyle_params[12] = "left"; // custom_float
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth

       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_title = $divstyle[5];

       $divstyle_params[0] = $idwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_id = $divstyle[5];

       $divstyle_params[0] = $datewidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_date = $divstyle[5];

       $divstyle_params[0] = $processwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_process = $divstyle[5];

       $divstyle_params[0] = $accumwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_accum = $divstyle[5];

       $divstyle_params[0] = $iconwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_icon = $divstyle[5];

       $divstyle_params[0] = $filterwidth; // minwidth
       $divstyle_params[13] = $divstyle_params[0]; // maxwidth
       $divstyle = $funky_gear->makedivstyles ($divstyle_params);
       $div_filter = $divstyle[5];

       }

    ################################
    # List

    #echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["Tickets"]."</B></font></center></div>";
    #echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    //echo "<center></center>";
    #echo "<div style=\"".$divstyle_orange."\"><div style=\"width:14%;float:left;padding-top:1;\"><img src=images/icons/SupportTicket.jpg width=60></div><div style=\"width:84%;float:left;\">".$strings["SLATicketingMessage"]."</div></div>";
    echo "<BR><img src=images/blank.gif width=90% height=10><BR>";
    echo $ticket_menu;
    #echo "<BR><img src=images/blank.gif width=90% height=10><BR>";

    #echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=sharedlist&value=".$val."&valuetype=".$valtype."');return false\"><font size=4><B>Shared ".$strings["Tickets"]."</B></font></a></center>";

    ##############################
    # Service Operation Configuration Item: 959c09e9-c980-458c-9b1d-5258a462b8da

    #echo "Params: ".$ticket_params[0]."<P>";

    $summ_ticket_object_type = $do;
    $summ_ticket_action = "select";
    $summ_ticket_params[0] = $ticket_params[0]; //" && status != '72b33850-b4b0-c679-f988-52c2eb40a5de' ";
    $summ_ticket_params[1] = "id,name,date_entered,status"; // select array
    $summ_ticket_params[2] = ""; // group;
    $summ_ticket_params[3] = " date_entered DESC,status,service_operation_process, name  DESC "; // order;
    $summ_ticket_params[4] = "2000"; // limit
    #$ticket_params[5] = $lingoname; // lingo
    $summ_ticket_params[5] = "name_en"; // lingo

    #$sess_summary = $_SESSION['summary'];
    $do_summary = TRUE;
    if ($do_summary == TRUE){
    #if (!$sess_summary){

       $summ_ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $summ_ticket_object_type, $summ_ticket_action, $summ_ticket_params);

       if (is_array($summ_ticket_items)){

          for ($cnt=0;$cnt < count($summ_ticket_items);$cnt++){

              $id = $summ_ticket_items[$cnt]["id"];
              $name = $summ_ticket_items[$cnt]["name"];
              $date_entered = $summ_ticket_items[$cnt]['date_entered'];
              $status = $summ_ticket_items[$cnt]['status']; 
              $status_image = $summ_ticket_items[$cnt]['status_image']; 
              $status_name = $summ_ticket_items[$cnt]['status_name'];
              $status_name_ja = $summ_ticket_items[$cnt]['status_name_ja'];
              $date_entered = substr($date_entered, 0,10);
              $fullsummarypack[$cnt]['date_entered'] = $date_entered;
              $fullsummarypack[$cnt]['name'] = $name;
              $fullsummarypack[$cnt]['status'] = $status;
              $fullsummarypack[$cnt]['status_name'] = $status_name;
              $fullsummarypack[$cnt]['status_name_ja'] = $status_name_ja;
              $fullsummarypack[$cnt]['status_image'] = $status_image;

              #$_SESSION['summary'] = $fullsummarypack;

              } // for

          } // if array

       } // end if sess

    $ticket_object_type = $do;
    $ticket_action = "select";

    # Got Statuses above so can now limit query by status if sent

    if ($valtype == 'status'){
       $ticket_params[0] .= " && status = '".$val."' ";
       $sent_status = $val;

       } elseif ($search_ticket_id != NULL || $search_keyword != NULL || $search_date != NULL) {

       # do nothing

       } else {

       $tick_status_cancelled = '72b33850-b4b0-c679-f988-52c2eb40a5de';
       $tick_status_open = 'e47fc565-c045-fef9-ef4f-52802bfc479c';
       $tick_status_closed = 'bbed903c-c79a-00a6-00fe-52802db36ba9';
       $ticket_params[0] .= " || (status != '".$tick_status_cancelled."' && status != '".$tick_status_closed."' && account_id_c='".$account_id_c."' ) "; 
       }

    $service_operation_process = $_POST['service_operation_process'];
    if ($service_operation_process != NULL){
       $ticket_params[0] .= " && service_operation_process like '%".$service_operation_process."%' ";
       }

    #echo "<P>Query:".$ticket_params[0]."<P>";

    $ticket_params[1] = "id,date_entered,status,service_operation_process, name"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = " date_entered DESC,status,service_operation_process, name  DESC "; // order;
    $ticket_params[4] = "2000"; // limit
    #$ticket_params[5] = $lingoname; // lingo
    $ticket_params[5] = "name_en"; // lingo

    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){

       $ticket_count = count($ticket_items);
       $page = $_POST['page'];

       # Send extra params to the navigator
       $extraparams[0] = "&date=".$search_date."&keyword=".$search_keyword."&ticket_id=".$search_ticket_id."&service_operation_process=".$service_operation_process."&status=".$sent_status;
       #echo "<P>Extra Params: ".$extraparams[0]."<P>";

       #echo "Page: ".$page."<P>";

       $navi_returner = $funky_gear->navigator ($ticket_count,$do,$action,$val,$valtype,$page,$glb_perpage_items,'GRID',$extraparams);
       #$navi_returner = $funky_gear->navigator ($ticket_count,$do,$action,$val,$valtype,$page,$glb_perpage_items,$BodyDIV);

       $lfrom = $navi_returner[0];

       #echo "lfrom: ".$lfrom."<P>";

       $navi = $navi_returner[1];
	
       $today = date("Y-m-d");
       $encdate = date("Y@m@d@G");
       $body_sendvars = $encdate."#Bodyphp";
       $body_sendvars = $funky_gear->encrypt($body_sendvars);
       
?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <?php echo $strings["Ticket"].": "; ?><input type="text" id="ticket_id" name="ticket_id" value="<?php echo $search_ticket_id; ?>" size="20">
     <?php echo $strings["action_search_keyword"].": "; ?><input type="text" id="keyword" name="keyword" value="<?php echo $search_keyword; ?>" size="20">
      <?php
       if ($action == 'list'){
          echo "<BR>";
          }
      ?>
     <?php echo $strings["Date"].":"; ?><input type="text" id="date" name="date" value="<?php echo $this_yearmonth; ?>" size="20">
     <?php echo "Format = [".$search_date."]"; ?>
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="rows" name="rows" value="<?php echo $glb_perpage_items; ?>" >
      <?php
       if ($action == 'gridlist' || $sendiv == 'GRID'){
          echo "<input type=\"hidden\" id=\"sendiv\" name=\"sendiv\" value=\"GRID\" >";
          }
      ?>
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
      <?php
       if ($action == 'gridlist' || $sendiv == 'GRID'){
      ?>
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('GRID');get(this.parentNode);">
      <?php
          } else {
      ?>
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
      <?php
          }
      ?>

    </div>
   </form>
</center>
<P>
<?php

       if ($fullsummarypack != NULL){
       #if ($sess_summary != NULL){
          #$extraparams[0] = $search_date;
          $summaryinfo = status_summary ($fullsummarypack,$extraparams);
          #$summaryinfo = status_summary ($sess_summary);
          }

       $statuspack = $summaryinfo[0];
       $datepack = $summaryinfo[1];
       $status_images = $summaryinfo[2];

       #echo "<P>Query :".$ticket_params[0]."<P>";

       $ticket_params[1] = "";
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = "  date_entered DESC,status,service_operation_process, name  DESC  "; // order;
       $ticket_params[4] = " $lfrom , $glb_perpage_items ";
       #$ticket_params[4] = "2000"; // limit
       #$ticket_params[5] = $lingoname; // lingo
       #$ticket_params[5] = "name_en"; // lingo 

       $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           $id = $ticket_items[$cnt]["id"];
           $name = $ticket_items[$cnt]["name"];
           $date_entered = $ticket_items[$cnt]['date_entered'];
           $date_modified = $ticket_items[$cnt]['date_modified'];
           $modified_user_id = $ticket_items[$cnt]['modified_user_id'];
           $created_by = $ticket_items[$cnt]['created_by'];
           $description = $ticket_items[$cnt]['description'];
           $deleted = $ticket_items[$cnt]['deleted'];
           $assigned_user_id = $ticket_items[$cnt]['assigned_user_id'];
           $ci_account_id_c = $ticket_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ticket_items[$cnt]['contact_id_c'];
           $ci_account_id1_c = $ticket_items[$cnt]['account_id1_c'];
           $ci_contact_id1_c = $ticket_items[$cnt]['contact_id1_c'];
           $ci_type_id = $ticket_items[$cnt]['ci_type_id']; // parent item
           $service_operation_process = $ticket_items[$cnt]['service_operation_process'];
           $service_operation_process_name = $ticket_items[$cnt]['service_operation_process_name'];
           $ticket_id = $ticket_items[$cnt]['ticket_id'];
           $sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];
           $project_id_c = $ticket_items[$cnt]['project_id_c']; 
           $projecttask_id_c = $ticket_items[$cnt]['projecttask_id_c']; 
           $sclm_sowitems_id_c = $ticket_items[$cnt]['sclm_sowitems_id_c']; 
           $status = $ticket_items[$cnt]['status']; 
           $status_image = $ticket_items[$cnt]['status_image']; 
           $sclm_emails_id_c = $ticket_items[$cnt]['sclm_emails_id_c'];
           $cmn_languages_id_c = $ticket_items[$cnt]['cmn_languages_id_c'];
           $filter_id = $ticket_items[$cnt]['filter_id'];

           $status_name = $ticket_items[$cnt]['status_name'];
           $status_name_ja = $ticket_items[$cnt]['status_name_ja'];

           if ($filter_id != NULL){
              #$filter_returner = $funky_gear->object_returner ("ConfigurationItems", $filter_id);
              #$ci_object_return_name = $ci_returner[0];
              #$ci_object_return = $ci_returner[1];
              #$ci_object_return_title = $ci_returner[2];
              #$filter = $filter_returner[3];
              $filter = $ticket_items[$cnt]['filter_name'];
              $filter = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$filter_id."&valuetype=ConfigurationItems');return false\"><B>".$filter."</B></a> ";
              }

           ##################################
           # Ticketing Activities

           if ($status != 'e47fc565-c045-fef9-ef4f-52802bfc479c'){
/*
              $ticketact_object_type = "TicketingActivities";
              $ticketact_action = "select";
              $ticketact_params[0] = " sclm_ticketing_id_c='".$id."' ";
              $ticketact_params[1] = "id"; // select array
              $ticketact_params[2] = ""; // group;
              $ticketact_params[3] = ""; // order;
              $ticketact_params[4] = ""; // limit
              $ticketact_params[5] = $lingoname; // lingo
              $ticketactivities = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticketact_object_type, $ticketact_action, $ticketact_params);
              if (is_array($ticketactivities)){
                 $actcount = " | Activity Count [".count($ticketactivities)."] ";
                 }
*/
              $activity_count = $ticket_items[$cnt]['activity_count'];
              $actcount = " | Activity Count [".$activity_count."] ";
              } // if status

           # Ticketing Activities
           ##################################

           $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=edit&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";

           $addactivity = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=TicketingActivities&action=add&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>[".$strings["action_add"]." ".$strings["TicketingActivity"]."]</B></font></a> ";

           $cancel = "<a href=\"#\" onClick=\"confirmer('Cancel?');doBPOSTRequest('".$id."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=cancel&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>[".$strings["Cancel"]."]</B></font></a> ";

           $sendmessage = "";
           if ($ci_contact_id1_c){
              $agent_name = $ticket_items[$cnt]['agent_name'];
              #$agent_returner = $funky_gear->object_returner ("Contacts", $ci_contact_id1_c);
              #$agent_name = $agent_returner[0];
              $sendmessage = " <a href=\"#Top\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$ci_contact_id1_c."&valuetype=Contacts&sendiv=light&related=Ticketing&relval=".$id."');document.getElementById('fade').style.display='block';loader('contactdiv');doRPOSTRequest('contactdiv','Body.php','pc=".$portalcode."&do=Contacts&action=view&value=".$ci_contact_id1_c."&valuetype=Contacts');return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'>".$agent_name."</a> ";
              }

           $sdm_edits = "";

           if ($security_role == $role_SDM && $status == 'bbed903c-c79a-00a6-00fe-52802db36ba9'){

              $sdm_edits = $icon_star."<a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=sdm_edit&value=".$id."&valuetype=".$do."');document.getElementById('fade').style.display='block';loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$do."&action=reference&value=".$id."&valuetype=".$valtype."');return false\"><font size=3 color=BLUE><B>SDM Edits</B></font></a> ";

              } // end sdm edits

           $quick_edits = "";
           $quick_edits = $icon_star." <a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=quick_edit&value=".$id."&valuetype=".$do."');document.getElementById('fade').style.display='block';loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$do."&action=reference&value=".$id."&valuetype=".$valtype."');return false\"><font size=3 color=BLUE><B>Quick Edit</B></font></a> ";

           $quick_activity = "";
           $quick_activity = $icon_star." <a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=quick_activity&value=".$id."&valuetype=".$do."');document.getElementById('fade').style.display='block';loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$do."&action=reference&value=".$id."&valuetype=".$valtype."');return false\"><font size=3 color=BLUE><B>Quick Activity</B></font></a> ";

           switch ($status){

            case 'bbed903c-c79a-00a6-00fe-52802db36ba9': //closed

             #$addactivity = "";
             #$quick_activity = "";

            break;
            case '320138e7-3fe4-727e-8bac-52802c62a4b6': //In-progress

             //

            break;
            case 'b0f00652-47aa-5a8e-74fb-52802e7fc3ec': //In-progress - SLA Warning

             //

            break;
            case 'e47fc565-c045-fef9-ef4f-52802bfc479c': //Open - Unclaimed

             #$addactivity = "";
             $delete = "<a href=\"#\" onClick=\"confirmer('Delete?');doBPOSTRequest('".$id."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=delete&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>[".$strings["Delete"]."]</B></font></a> ";

            break;
            case 'e3307ebb-6255-505c-99b2-52802c68ec75': //Pending

             //

            break;
            case '4e5ce2e0-8a86-8473-df52-52802cb14285': //Problem-Frozen

             #$addactivity = "";
             #$quick_activity = "";

            break;
            case 'ed0606e3-b8fe-1ff3-253d-52802daea6af': //Revisit

             //

            break;
            case '72b33850-b4b0-c679-f988-52c2eb40a5de': //Cancelled

             $addactivity = "";
             $quick_activity = "";

            break;

           } // end status switch
 
           #$lingoname = "name_".$lingo;
           $lingoname = "name_en";

           if ($ticket_items[$cnt][$lingoname] != NULL){
              $name = $ticket_items[$cnt][$lingoname];
              }

           $status_image = "<img src=".$status_image." width=16>";

           if ($status != 'e47fc565-c045-fef9-ef4f-52802bfc479c'){
              # Check SLA for icon colouring by date created
              $metric_count = $ticket_items[$cnt]['metric_count']; 
              $count_type = $ticket_items[$cnt]['count_type']; 
              $start_time = $ticket_items[$cnt]['start_time']; 
              $end_time = $ticket_items[$cnt]['end_time']; 
              $slaminutes = $ticket_items[$cnt]['slaminutes']; 
              $remaining_sla_mins = $ticket_items[$cnt]['remaining_sla_mins']; 

              # If ticket status is closed - this becomes the figure shown
              $accumulated_minutes = $ticket_items[$cnt]['accumulated_minutes']; 

              } // if status

           if ($status == 'bbed903c-c79a-00a6-00fe-52802db36ba9' || $status == 'e3307ebb-6255-505c-99b2-52802c68ec75' || $status == '4e5ce2e0-8a86-8473-df52-52802cb14285'){
              // Clock to be frozen - use accumulated minutes
              $accum = $accumulated_minutes;

              } elseif ($status != 'e47fc565-c045-fef9-ef4f-52802bfc479c') {

              if ($remaining_sla_mins < 0){
                 $remaining_sla_mins = number_format($remaining_sla_mins);
                 $accum = "<B><font color=red>[".$remaining_sla_mins." ".$strings["Minutes"]."]</font></B>";
                 } else {
                 $remaining_sla_mins = number_format($remaining_sla_mins);
                 $accum = "<B><font color=blue>[".$remaining_sla_mins." ".$strings["Minutes"]."]</font></B>";
                 }

              } // end if status frozen

           if ($action == 'list'){

              $tickets .= "<div id=\"".$id."\" name=\"".$id."\" style=\"".$divstyle_white."\"><div style=\"width:5%;float:left;padding-top:20;\">".$status_image."</div>
<div style=\"width:93%;float:left;\">
<B>".$strings["ServiceOperationProcess"].":</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."&process=".$service_operation_process."');return false\">[".$service_operation_process_name."]</a><BR>
<B>ID:</B> [".$ticket_id."]<BR>
<B>".$strings["Date"].":</B> [".$date_entered."]<BR>
<B>".$strings["AccumulatedMinutes"].":</B> ".$accum ."<BR>
".$sdm_edits.$edit.$quick_edits.$quick_activity.$delete.$cancel.$addactivity.$actcount.$sendmessage."<BR>
<B>".$strings["Filter"].":</B> ".$filter."<BR>
<B>".$strings["action_view"].":</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$do."&action=reference&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a>
</div>
</div>"; 

              } elseif ($action == 'gridlist' || $sendiv == 'GRID'){

              $process = "<a href=\"#\" onClick=\"loader('GRID');doBPOSTRequest('GRID','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$val."&valuetype=".$valtype."&process=".$service_operation_process."&sendiv=GRID');return false\">".$service_operation_process_name."</a>";

              $title = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."&sendiv=GRID');loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$do."&action=reference&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a>";

              if ($filter == NULL){
                 $filter = "NA";
                 }

              $tickets .= "<div id=\"".$id."\" name=\"".$id."\">";
              $tickets .= "<div style=\"".$div_icon."\">".$status_image."</div>";
              $tickets .= "<div style=\"".$div_date."\">".$date_entered."</div>";
              $tickets .= "<div style=\"".$div_id."\">".$ticket_id."</div>";
              $tickets .= "<div style=\"".$div_process."\">".$process."</div>";
              $tickets .= "<div style=\"".$div_accum."\">".$accum ."</B></div>";
              $tickets .= "<div style=\"".$div_title."\">".$title."<BR>".$sdm_edits.$quick_edits.$quick_activity.$edit.$delete.$cancel.$addactivity.$actcount.$sendmessage."</div>";
              $tickets .= "<div style=\"".$div_filter."\">".$filter."</B></div>";
              $tickets .= "</div><P><img src=images/blank.gif width=500 height=1><BR>"; 

              } 

          /* This is not used for grouping yet

           switch ($status){

            case 'bbed903c-c79a-00a6-00fe-52802db36ba9': //closed

             $Closed_tickets .= $this_ticket;

            break;
            case '320138e7-3fe4-727e-8bac-52802c62a4b6': //In-progress

             $Inprogress_tickets .= $this_ticket;

            break;
            case 'b0f00652-47aa-5a8e-74fb-52802e7fc3ec': //In-progress - SLA Warning

             $Inprogress_sla_warning_tickets .= $this_ticket;

            break;
            case 'e47fc565-c045-fef9-ef4f-52802bfc479c': //Open - Unclaimed

             $Open_Unclaimed_tickets .= $this_ticket;

            break;
            case 'e3307ebb-6255-505c-99b2-52802c68ec75': //Pending

             $Pending_tickets .= $this_ticket;

            break;
            case '4e5ce2e0-8a86-8473-df52-52802cb14285': //Problem-Frozen

             $Problem_Frozen_tickets .= $this_ticket;

            break;
            case 'ed0606e3-b8fe-1ff3-253d-52802daea6af': //Revisit

             $Revisit_tickets .= $this_ticket;

            break;
            case '72b33850-b4b0-c679-f988-52c2eb40a5de': //Cancelled

             $Cancelled_tickets .= $this_ticket;

            break;

           } // end status switch

          */

          // $tickets .= $this_ticket;

           } // end foreach

       } // if array    

    if ($sess_contact_id != NULL){
     
//       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$do."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
     
       } else {
      
       #$addnew = "<div style=\"".$divstyle_white."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }
     
    //$tickets = $Open_Unclaimed_tickets."<P>".$Pending_tickets."<P>".$Inprogress_tickets."<P>".$Inprogress_sla_warning_tickets."<P>".$Problem_Frozen_tickets."<P>".$Revisit_tickets."<P>".$Closed_tickets."<P>".$Cancelled_tickets;

    if (count($ticket_items)>10){
#       echo $addnew."<P>".$ticketheader."<P>".$tickets."<P>".$addnew;
       } else {
#       echo $addnew."<P>".$tickets;
       }

    echo "<div style=\"".$formtitle_divstyle_white."\">".$status_images."</div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo $navi;

    if ($action == 'gridlist' || $sendiv == 'GRID'){
       echo "<div style=\"".$formtitle_divstyle_white."\">".$ticketheader."</div>";
       }

    echo "<div style=\"".$formtitle_divstyle_white."\">".$tickets."</div>";
   
    echo $navi;

   break; // end list
   # End List Tickets
   ################################
   # Reference of handy info for the right column
   case 'reference':

    # Add Advisory based on keywords

    $ci_object_type = 'Ticketing';
    $ci_action = "select";
    $ci_params[0] = " id= '".$val."' ";
    $ci_params[1] = "name,description,filter_id"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
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
           $ci_contact_id1_c = $ci_items[$cnt]['contact_id1_c'];
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

    $external_link = "Body@".$lingo."@Ticketing@view@".$val."@Ticketing";
    $external_link = $funky_gear->encrypt($external_link);
    $external_link = "View Ticket in new window:<BR><a href=http://".$hostname."/?pc=".$external_link." target=Ticketing>".$name."</a><P>";

    $ticket_object_type = "TicketingActivities";
    $ticket_action = "select";
    $ticket_params[0] = "sclm_ticketing_id_c='".$val."' ";
    $ticket_params[1] = "id,contact_id1_c,sclm_ticketing_id_c,ticket_update"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = " date_entered DESC "; // order;
    $ticket_params[4] = ""; // limit
    $ticket_params[5] = $lingoname; // lingo
  
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           $id = $ticket_items[$cnt]["id"];
           $ticket_update = $ticket_items[$cnt]["ticket_update"];
           $ci_contact_id1_c = $ticket_items[$cnt]["contact_id1_c"];

           $sendmessage = "";

           if ($ticket_update != NULL){

              if ($ci_contact_id1_c){
                 $agent_returner = $funky_gear->object_returner ("Contacts", $ci_contact_id1_c);
                 $agent_name = $agent_returner[0];
                 $sendmessage = " <a href=\"#Top\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$ci_contact_id1_c."&valuetype=Contacts&sendiv=light&related=Ticketing&relval=".$val."');document.getElementById('fade').style.display='block';loader('contactdiv');doRPOSTRequest('contactdiv','Body.php','pc=".$portalcode."&do=Contacts&action=view&value=".$ci_contact_id1_c."&valuetype=Contacts');return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'>".$agent_name."</a> ";
                 }


              $ticket_update = $funky_gear->replacer("\n", "<BR>", $ticket_update);
              $activities .= "<div style=\"".$divstyle_white."\">".$ticket_update."<BR>".$sendmessage."</div>";
              }

           } // for

       } // if array

    $today = date("Y-m-d");
    $encdate = date("Y@m@d@G");
    $body_sendvars = $encdate."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>Ticket Search</font></B></center></div>";
       
?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <div style="float:left;width:30;padding-top:5;">
     <?php echo $strings["Ticket"].": "; ?></div><div style="width:80;"><input type="text" id="ticket_id" name="ticket_id" value="<?php echo $search_ticket_id; ?>" size="20"></div><BR>
     <div style="float:left;width:30;padding-top:5;">
     <?php echo $strings["action_search_keyword"].": "; ?></div><div style="width:80;"><input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20"></div><BR>
     <div style="float:left;width:30;padding-top:5;">
     <?php echo $strings["Date"].": "; ?></div><div style="width:80;"><input type="text" id="date" name="date" value="<?php echo $date; ?>" size="20"></div><BR>
     <?php echo "Format = [".$today."]"; ?><BR>
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="sendiv" name="sendiv" value="GRID" >
     <input type="hidden" id="rows" name="rows" value="30" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="value" name="value" value="" >
     <input type="hidden" id="valuetype" name="valuetype" value="" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('GRID');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B>".$strings["Updates"]."</B></center></div>";
    echo $activities;


    if ($filter_id){

       

       } // end if filter

    #$strings["Updates"] = "Parent Ticket";
    #echo "<div style=\"".$divstyle_grey."\"><center><B>".."</B></center></div>";
    #echo $activities;  


   break; // end reference
   # End Reference
   ################################
   # SDM Edits
   case 'sdm_edit':

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ticket_object_type = $do;
    $ticket_action = "select";
    $ticket_params[0] = "id='".$val."' ";
    $ticket_params[1] = "id,sclm_serviceslarequests_id_c,service_operation_process, name,sdm_confirmed,billing_count"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = ""; // order;
    $ticket_params[4] = ""; // limit
    $ticket_params[5] = $lingoname; // lingo
  
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           #$id = $ticket_items[$cnt]["id"];
           #$ci_account_id2_c = $ticket_items[$cnt]['account_id2_c'];
           #$ci_contact_id2_c = $ticket_items[$cnt]['contact_id2_c'];
           $name = $ticket_items[$cnt]['name'];
           $sdm_confirmed = $ticket_items[$cnt]['sdm_confirmed'];
           $billing_count = $ticket_items[$cnt]['billing_count'];
           $service_operation_process = $ticket_items[$cnt]['service_operation_process'];
           $sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];

           }  // end for

       }  // is array


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
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;

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
    $tablefields[$tblcnt][11] = $name; // Field ID
    $tablefields[$tblcnt][12] = '110'; //length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value; 

    $tblcnt++;

    if ($sdm_confirmed == NULL){
       $sdm_confirmed = 0;
       }

    $tablefields[$tblcnt][0] = "sdm_confirmed"; // Field Name
    $tablefields[$tblcnt][1] = "SDM Confirmed ".$icon_star; // Full Name
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
    $tablefields[$tblcnt][12] = '30'; //length
    $tablefields[$tblcnt][20] = "sdm_confirmed"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sdm_confirmed; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "billing_count"; // Field Name
    $tablefields[$tblcnt][1] = "Billing Count ".$icon_star; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'decimal';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = '20'; //length
    $tablefields[$tblcnt][20] = "billing_count"; //$field_value_id;
    $tablefields[$tblcnt][21] = $billing_count; //$field_value;

    $tblcnt++;

    if (!$service_operation_process){
       $service_operation_process = 'e81b088c-a1a9-cc53-a49e-526c6c2ab05b';
       }

    $tablefields[$tblcnt][0] = 'service_operation_process'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceOperationProcess"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitems_id_c= '959c09e9-c980-458c-9b1d-5258a462b8da' ";//$exception;
    $tablefields[$tblcnt][9][5] = $service_operation_process; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $service_operation_process; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'service_operation_process';//$field_value_id;
    $tablefields[$tblcnt][21] = $service_operation_process; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_serviceslarequests_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLARequest"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_serviceslarequests'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' ";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_serviceslarequests_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServiceSLARequests';
    $tablefields[$tblcnt][9][7] = "sclm_serviceslarequests"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ServiceSLARequests'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_serviceslarequests_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "sclm_serviceslarequests_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_serviceslarequests_id_c; //$field_value;   

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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][12] = '20'; //length
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = "light"; //$field_value;

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = "custom";
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // provide add new button
    $valpack[6] = "sdm_process"; // provide add new button
    $valpack[7] = $strings["Edit"];

    # Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    echo $zaform;

   break;
   # End SDM Edits
   ################################
   # SDM Process
   case 'sdm_process':

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $process_object_type = $do;
    $process_action = "update";

    $process_params = array();  
    $process_params[] = array('name'=>'id','value' => $_POST['id']);
    $process_params[] = array('name'=>'name','value' => $_POST['name']);
    $process_params[] = array('name'=>'sdm_confirmed','value' => $_POST['sdm_confirmed']);
    $process_params[] = array('name'=>'billing_count','value' => $_POST['billing_count']);
    $process_params[] = array('name'=>'service_operation_process','value' => $_POST['service_operation_process']);
    $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $_POST['sclm_serviceslarequests_id_c']);

    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($result['id'] != NULL){
       $val = $result['id'];
       }

    $process_message = "<P>".$strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

    echo $process_message;

   break;
   # End SDM Process
   ################################
   # Quick Edits
   case 'quick_edit':

  if (!$ci_account_id1_c){
     $ci_account_id1_c = $sess_account_id;
     }

  if (!$ci_contact_id1_c){
     $ci_contact_id1_c = $sess_contact_id;
     }


    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ticket_object_type = $do;
    $ticket_action = "select";
    $ticket_params[0] = "id='".$val."' ";
    $ticket_params[1] = "id,status,name,vendor_code,contact_id1_c,account_id1_c,sclm_ticketing_id_c"; // select array
    $ticket_params[2] = ""; // group;
    $ticket_params[3] = " service_operation_process, name, date_entered DESC "; // order;
    $ticket_params[4] = ""; // limit
    $ticket_params[5] = $lingoname; // lingo
  
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){
  
       for ($cnt=0;$cnt < count($ticket_items);$cnt++){

           #$id = $ticket_items[$cnt]["id"];
           $ci_account_id1_c = $ticket_items[$cnt]['account_id1_c'];
           $ci_contact_id1_c = $ticket_items[$cnt]['contact_id1_c'];
           $vendor_code = $ticket_items[$cnt]['vendor_code'];
           $name = $ticket_items[$cnt]['name'];
           $status = $ticket_items[$cnt]['status'];
           $sclm_ticketing_id_c = $ticket_items[$cnt]['sclm_ticketing_id_c'];

           }  // end for

       }  // is array

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
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_ticketing_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Parent"]." ".$strings["Ticket"]." ".$icon_star; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_ticketing'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' ORDER BY date_entered DESC ";
    $tablefields[$tblcnt][9][5] = $sclm_ticketing_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Ticketing';
    $tablefields[$tblcnt][9][7] = "sclm_ticketing"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Ticketing'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_ticketing_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = '20'; //length
    $tablefields[$tblcnt][20] = "sclm_ticketing_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_ticketing_id_c; //$field_value;   

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
    $tablefields[$tblcnt][11] = $name; // Field ID
    $tablefields[$tblcnt][12] = '110'; //length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "vendor_code"; // Field Name
    $tablefields[$tblcnt][1] = "Vendor Code ".$icon_star; // Full Name
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
    $tablefields[$tblcnt][12] = '30'; //length
    $tablefields[$tblcnt][20] = "vendor_code"; //$field_value_id;
    $tablefields[$tblcnt][21] = $vendor_code; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'status'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]." *"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='d918bc49-f7df-8b75-1e4d-52802a2db21c' "; //ticket status
    $tablefields[$tblcnt][9][5] = $status; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'status';//$field_value_id;
    $tablefields[$tblcnt][21] = $status; //$field_value;
    $tablefields[$tblcnt][43] = "<img src=images/blank.gif width=10 height=3>".$status_image; // field extras

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
    $tablefields[$tblcnt][9][5] = $ci_account_id1_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $ci_account_id1_c; //$field_value;   

    $tblcnt++;
    $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
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
    $tablefields[$tblcnt][9][5] = $ci_contact_id1_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "firstlast";
    $tablefields[$tblcnt][21] = $ci_contact_id1_c;
    $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

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
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][12] = '20'; //length
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = "light"; //$field_value;

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = "custom";
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // provide add new button
    $valpack[6] = "quick_process"; // provide add new button
    $valpack[7] = $strings["Edit"];

    # Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    echo $zaform;

   break;
   # End Quick Edits
   ################################
   # Quick Process
   case 'quick_process':

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $process_object_type = $do;
    $process_action = "update";

    $process_params = array();  
    $process_params[] = array('name'=>'id','value' => $_POST['id']);
    $process_params[] = array('name'=>'name','value' => $_POST['name']);
    $process_params[] = array('name'=>'vendor_code','value' => $_POST['vendor_code']);
    $process_params[] = array('name'=>'status','value' => $_POST['status']);
    $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
    $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
    $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $_POST['sclm_ticketing_id_c']);

    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($result['id'] != NULL){
       $val = $result['id'];
       }

    $process_message = "<P>".$strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

    echo $process_message;

   break;
   # End Quick Process
   ################################
   # Quick Activity
   case 'quick_activity':

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

   $this->funkydone ($_POST,$lingo,'TicketingActivities','quicklist',$val,$do,$bodywidth);

   break;
   # End Quick Activity
   ################################
   # Start View Tickets

   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){

       echo $ticket_menu;

       // Service Operation Configuration Item: 959c09e9-c980-458c-9b1d-5258a462b8da
       $ticket_object_type = $do;
       $ticket_action = "select";
       $ticket_params[0] = "id='".$val."' ";
       $ticket_params[1] = ""; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = " service_operation_process, name, date_entered DESC "; // order;
       $ticket_params[4] = ""; // limit
       $ticket_params[5] = $lingoname; // lingo
  
       $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

       if (is_array($ticket_items)){
  
          for ($cnt=0;$cnt < count($ticket_items);$cnt++){

              $id = $ticket_items[$cnt]["id"];
              $name = $ticket_items[$cnt]["name"];
              $date_entered = $ticket_items[$cnt]['date_entered'];
              $date_modified = $ticket_items[$cnt]['date_modified'];
              $modified_user_id = $ticket_items[$cnt]['modified_user_id'];
              $created_by = $ticket_items[$cnt]['created_by'];
              $description = $ticket_items[$cnt]['description'];
              $deleted = $ticket_items[$cnt]['deleted'];
              $assigned_user_id = $ticket_items[$cnt]['assigned_user_id'];
              $ci_account_id_c = $ticket_items[$cnt]['account_id_c'];
              $ci_account_id1_c = $ticket_items[$cnt]['account_id1_c'];
              $ci_contact_id_c = $ticket_items[$cnt]['contact_id_c'];
              $ci_contact_id1_c = $ticket_items[$cnt]['contact_id1_c'];
              $service_operation_process = $ticket_items[$cnt]['service_operation_process'];
              $service_operation_process_name = $ticket_items[$cnt]['service_operation_process_name'];
              $ticket_id = $ticket_items[$cnt]['ticket_id'];
              $sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];
              $project_id_c = $ticket_items[$cnt]['project_id_c']; 
              $projecttask_id_c = $ticket_items[$cnt]['projecttask_id_c']; 
              $sclm_sowitems_id_c = $ticket_items[$cnt]['sclm_sowitems_id_c']; 
              $accumulated_minutes = $ticket_items[$cnt]['accumulated_minutes']; 
              $ticket_id = $ticket_items[$cnt]['ticket_id']; 
              $sclm_configurationitems_id_c = $ticket_items[$cnt]['sclm_configurationitems_id_c']; 
              $ticket_source = $ticket_items[$cnt]['ticket_source']; 
              $status = $ticket_items[$cnt]['status'];
              $status_image = $ticket_items[$cnt]['status_image']; 

              $metric_count = $ticket_items[$cnt]['metric_count']; 
              $count_type = $ticket_items[$cnt]['count_type']; 
              $start_time = $ticket_items[$cnt]['start_time']; 
              $end_time = $ticket_items[$cnt]['end_time']; 
              $slaminutes = $ticket_items[$cnt]['slaminutes']; 
              $remaining_sla_mins = $ticket_items[$cnt]['remaining_sla_mins']; 

              $sclm_emails_id_c = $ticket_items[$cnt]['sclm_emails_id_c'];
              $cmn_statuses_id_c = $ticket_items[$cnt]['cmn_statuses_id_c'];
              $cmn_languages_id_c = $ticket_items[$cnt]['cmn_languages_id_c'];
              $extra_addressees = $ticket_items[$cnt]['extra_addressees'];
              $extra_addressees_cc = $ticket_items[$cnt]['extra_addressees_cc'];
              $extra_addressees_bcc = $ticket_items[$cnt]['extra_addressees_bcc'];
              $filter_id = $ticket_items[$cnt]['filter_id'];
              $to_addressees = $ticket_items[$cnt]['to_addressees'];
              $cc_addressees = $ticket_items[$cnt]['cc_addressees'];
              $bcc_addressees = $ticket_items[$cnt]['bcc_addressees'];
              $sdm_confirmed = $ticket_items[$cnt]['sdm_confirmed'];
              $billing_count = $ticket_items[$cnt]['billing_count'];
              $vendor_code = $ticket_items[$cnt]['vendor_code'];
              $sclm_ticketing_id_c = $ticket_items[$cnt]['sclm_ticketing_id_c'];

              }  // end for

          $field_lingo_pack = $funky_gear->lingo_data_pack ($ticket_items, $name, $description, $name_field_base,$desc_field_base);

          }  // is array

       }  // if edit

    $nowdate = date("Y-m-d H:i:s");
    # Use the modified date to show the time since the last update
    # $difference = $funky_gear->timeDiff($date_entered,$nowdate);
    $difference = $funky_gear->timeDiff($date_modified,$nowdate);
    $years = abs(floor($difference / 31536000));
    $days = abs(floor(($difference-($years * 31536000))/86400));
    $hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));
    $mins = abs(floor(($difference-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);
    #$new_accumulated_minutes = floor(($difference)/60); 

    // Calculate accum minutes based on status
    if ($action == 'add'){
       $new_accumulated_minutes = 0;
       $date_entered = $nowdate;

       } else {

       if ($status == 'bbed903c-c79a-00a6-00fe-52802db36ba9' || $status == 'e3307ebb-6255-505c-99b2-52802c68ec75' || $status == '4e5ce2e0-8a86-8473-df52-52802cb14285'){
          $new_accumulated_minutes = $accumulated_minutes;

          } else {
          
          $new_accumulated_minutes = floor(($difference)/60);

          }  // end if status

       } 

    if ($action == 'add'){

       if ($valtype == 'Emails'){

          $email_object_type = $do;
          $email_action = "select";
          $email_params[0] = " id='".$val."' ";
          $email_params[1] = ""; // select array
          $email_params[2] = ""; // group;
          $email_params[3] = ""; // order;
          $email_params[4] = ""; // limit
  
          $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $email_object_type, $email_action, $email_params);

          if (is_array($email)){

             for ($cnt=0;$cnt < count($email);$cnt++){

//                $id = $email[$cnt]['id'];
                 $name = $email[$cnt]['name'];
/*
                 $date_entered = $email[$cnt]['date_entered'];
                 $date_modified = $email[$cnt]['date_modified'];
                 $modified_user_id = $email[$cnt]['modified_user_id'];
                 $created_by = $email[$cnt]['created_by'];
*/
                 $description = $email[$cnt]['description'];
//                 $deleted = $email[$cnt]['deleted'];
                 $assigned_user_id = $email[$cnt]['assigned_user_id'];
                 $ci_contact_id_c = $email[$cnt]['contact_id_c'];
                 $ci_account_id_c = $email[$cnt]['account_id_c'];
                 $project_id_c = $email[$cnt]['project_id_c'];
                 $projecttask_id_c = $email[$cnt]['projecttask_id_c'];
                 $cmn_languages_id_c = $email[$cnt]['cmn_languages_id_c'];
                 $cmn_statuses_id_c = $email[$cnt]['cmn_statuses_id_c'];
//                 $sclm_ticketing_id_c = $email[$cnt]['sclm_ticketing_id_c'];
//                 $sclm_ticketingactivities_id_c = $email[$cnt]['sclm_ticketingactivities_id_c'];
      
                 } // end for

              } // if array

          // Check the email and see if email ticketing SLA is in place..
          echo "This ticket will be created from the content of the email (".$name.")<P>";

          } // if email valtype

       if ($valtype == 'IMAPEmails'){

          $name = $_POST['fromemail_subject'];
          $description = $_POST['fromemail_body'];
          $date = $_POST['fromemail_date'];

          }

       $sclm_serviceslarequests_id_c = $_POST['sclm_serviceslarequests_id_c'];

       if ($sclm_serviceslarequests_id_c){

          $ci_object_type = 'ServiceSLARequests';
          $ci_action = "select";
          $ci_params[0] = " id= '".$sclm_serviceslarequests_id_c."' ";
          $ci_params[1] = ""; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = " name, date_entered DESC "; // order;
          $ci_params[4] = ""; // limit
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

//                 $id = $ci_items[$cnt]['id'];
//                 $name = $ci_items[$cnt]['name'];
//                 $date_entered = $ci_items[$cnt]['date_entered'];
//                 $date_modified = $ci_items[$cnt]['date_modified'];
//                 $modified_user_id = $ci_items[$cnt]['modified_user_id'];
//                 $created_by = $ci_items[$cnt]['created_by'];
//                 $description = $ci_items[$cnt]['description'];
//                 $deleted = $ci_items[$cnt]['deleted'];
                 $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
                 $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
//                 $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
//                 $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
//                 $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
                 $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
//                 $start_date = $ci_items[$cnt]['start_date'];
//                 $end_date = $ci_items[$cnt]['end_date'];
                 $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
                 $sclm_accountsservicesslas_id_c = $ci_items[$cnt]['sclm_accountsservicesslas_id_c'];
                 $project_id_c = $ci_items[$cnt]['project_id_c'];
                 $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
                 $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
                 $sclm_emails_id_c = $ci_items[$cnt]['sclm_emails_id_c'];
//                 $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];

                 } // end for

//             $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);
          
             } // if is array

          } // if sclm_serviceslarequests_id_c

       } // if add

  if (!$ci_contact_id_c){
     $ci_contact_id_c = $contact_id_c;
     }

  if (!$ci_account_id_c){
     $ci_account_id_c = $account_id_c;
     }

  if (!$ci_account_id1_c){
     $ci_account_id1_c = $sess_account_id;
     }

  if (!$ci_contact_id1_c){
     $ci_contact_id1_c = $sess_contact_id;
     }

  $status_image = "<img src=".$status_image." width=16>";

  if ($project_id_c != NULL){
     $object_returner = $funky_gear->object_returner ('Projects', $project_id_c);
     echo $object_returner[1];
     }

  if ($projecttask_id_c != 'NULL'){
     $object_returner = $funky_gear->object_returner ('ProjectTasks', $projecttask_id_c);
     echo $object_returner[1];
     }

  if ($sclm_sowitems_id_c != 'NULL'){
     $object_returner = $funky_gear->object_returner ('SOWItems', $sclm_sowitems_id_c);
     echo $object_returner[1];
     }

  if ($sclm_accountsservices_id_c != NULL){
     $object_returner = $funky_gear->object_returner ('AccountsServices', $sclm_accountsservices_id_c);
     echo $object_returner[1];
     }

  if ($sclm_accountsservicesslas_id_c != NULL){
     $object_returner = $funky_gear->object_returner ('AccountsServicesSLAs', $sclm_accountsservicesslas_id_c);
     echo $object_returner[1];
     }

    // Need to set the status
/*
    if (){
      }
*/
    if ($filter_id != NULL){

       // Use Filter to collect components
       $filter_object_type = "ConfigurationItems";
       $filter_action = "select";
       $filter_params[0] = " id='".$filter_id."' ";
       $filter_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c"; // select array
       $filter_params[2] = ""; // group;
       $filter_params[3] = ""; // order;
       $filter_params[4] = ""; // limit
  
       $filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filter_object_type, $filter_action, $filter_params);

       if (is_array($filters)){

          for ($cntfb=0;$cntfb < count($filters);$cntfb++){

//              $filter_configurationitemtypes_id_c = $filters[$cntfb]['sclm_configurationitemtypes_id_c'];
              $filter_description = $filters[$cntfb]['description'];
              $filter_description = str_replace("\n","<BR>",$filter_description);
              echo "<div style=\"".$divstyle_orange."\"><B>".$strings["EmailFiltering"]."</B><P>".$filter_description."</div>"; 

              } // for

          } // if array

       } // if filter

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

    if ($action == 'edit' || $action == 'view' ){
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = "id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;    
       } else {
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "id"; //$field_value_id;
       $tablefields[$tblcnt][21] = ""; //$field_value;    
       }

    if ($action == 'add' || ($action == 'edit' && $name == NULL)){

       $config_object_type = 'ConfigurationItems';
       $config_action = "select";
       $config_params[0] = " sclm_configurationitemtypes_id_c='6cc00767-12da-3666-9081-52826ae1cea5' && (account_id_c='".$account_id_c."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
       $config_params[1] = ""; // select array
       $config_params[2] = ""; // group;
       $config_params[3] = " name, date_entered DESC "; // order;
       $config_params[4] = ""; // limit
  
       $config_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $config_object_type, $config_action, $config_params);

       if (is_array($config_items)){

          for ($configcnt=0;$configcnt < count($config_items);$configcnt++){

//              $id = $config_items[$configcnt]['id'];
              $ticket_id_bit = $config_items[$configcnt]['name'];

              } // end for

          } else {// end if
            $ticket_id_bit = "SDaaS+AMS-";
          }

       $ticket_date = date("Y-m-d H-i-s");

       } // end add

    if (!$ticket_id){
       $ticket_id = date("Y-m-d_H-i-s");
       $name = $ticket_id_bit."[".$ticket_id."]";
       }

    if ($action == 'edit'){
       $name = "Re: ".$name;
       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_ticketing_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Parent"]." ".$strings["Ticket"]." ".$icon_star; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_ticketing'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."'  ";
    $tablefields[$tblcnt][9][5] = $sclm_ticketing_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Ticketing';
    $tablefields[$tblcnt][9][7] = "sclm_ticketing"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Ticketing'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_ticketing_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = '20'; //length
    $tablefields[$tblcnt][20] = "sclm_ticketing_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_ticketing_id_c; //$field_value;   

    if ($security_role == $role_SDM){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "sdm_confirmed"; // Field Name
       $tablefields[$tblcnt][1] = "SDM Confirmed ".$icon_star; // Full Name
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
       $tablefields[$tblcnt][20] = "sdm_confirmed"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sdm_confirmed; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "billing_count"; // Field Name
       $tablefields[$tblcnt][1] = "Billing Count ".$icon_star; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'decimal';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][12] = '20'; //length
       $tablefields[$tblcnt][20] = "billing_count"; //$field_value_id;
       $tablefields[$tblcnt][21] = $billing_count; //$field_value;   

       } // SDM 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "ticket_id"; // Field Name
    $tablefields[$tblcnt][1] = "Ticket ID"; // Full Name
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
    $tablefields[$tblcnt][12] = '30'; //length
    $tablefields[$tblcnt][20] = "ticket_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $ticket_id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "vendor_code"; // Field Name
    $tablefields[$tblcnt][1] = "Vendor Code ".$icon_star; // Full Name
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
    $tablefields[$tblcnt][12] = '30'; //length
    $tablefields[$tblcnt][20] = "vendor_code"; //$field_value_id;
    $tablefields[$tblcnt][21] = $vendor_code; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'message_lingo'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Email"]." : ".$strings["Language"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
 
    for ($x=0;$x<count($lingos);$x++) {
        $extension = $lingos[$x][0][0][0][0][0][0];
        $language = $lingos[$x][1][1][0][0][0][0];
        $lingoddpack[$extension]=$language;
        $lingo_id = $lingos[$x][1][0][0][0][0][0];
        }

    $tablefields[$tblcnt][9][1] = $lingoddpack;
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";
    $tablefields[$tblcnt][9][5] = $lingo; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'message_lingo';//$field_value_id;
    $tablefields[$tblcnt][21] = $lingo; //$field_value;   

    $tblcnt++;

    if (!$send_email){
       $send_email = 0;
       }

    $tablefields[$tblcnt][0] = "send_email"; // Field Name
    $tablefields[$tblcnt][1] = $strings["FilterSendEmail"]." ?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $send_email; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "send_email"; //$field_value_id;
    $tablefields[$tblcnt][21] = $send_email; //$field_value;

    $tblcnt++;
          
    if (!$cmn_languages_id_c){
       $cmn_languages_id_c=$lingo_id;
       }

    $tablefields[$tblcnt][0] = "cmn_languages_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Content"]." : ".$strings["Language"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_languages_id_c; // Current Value
    $tablefields[$tblcnt][10] = '0';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_languages_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_languages_id_c; //$field_value; 

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
    $tablefields[$tblcnt][11] = $name; // Field ID
    $tablefields[$tblcnt][12] = '70'; //length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value;   

    $tblcnt++;

    if (!$send_extra_addresses){
       $send_extra_addresses=0;
       }

    $tablefields[$tblcnt][0] = "send_extra_addresses"; // Field Name
    $tablefields[$tblcnt][1] = "Send Extra Addresses? ".$icon_star; // Full Name
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
    $tablefields[$tblcnt][20] = "send_extra_addresses"; //$field_value_id;
    $tablefields[$tblcnt][21] = $send_extra_addresses; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "extra_addressees"; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailExtraAddressees"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $extra_addressees; // Field ID
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "extra_addressees"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_addressees; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "extra_addressees_cc"; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailExtraAddressees"]." CC"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $extra_addressees_cc; // Field ID
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "extra_addressees_cc"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_addressees_cc; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "extra_addressees_bcc"; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailExtraAddressees"]." BCC"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $extra_addressees_bcc; // Field ID
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "extra_addressees_bcc"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_addressees_bcc; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'to_addressees'; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailRecipients"]." TO"; // Full Name
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
    if ($filter_id != NULL){
//       $tablefields[$tblcnt][9][4] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='be9692fa-5341-6934-7500-52ba77913179' ";
       $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' && sclm_configurationitemtypes_id_c='cf3271fc-f361-22c8-0212-52b998d102ac' && enabled!=0 ";
       } else {
       $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' && sclm_configurationitemtypes_id_c='cf3271fc-f361-22c8-0212-52b998d102ac' && enabled!=0 ";
       }
    $tablefields[$tblcnt][9][5] = $to_addressees; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $to_addressees; // Current Value       $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'to_addressees';//$field_value_id;
    $tablefields[$tblcnt][21] = $to_addressees; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cc_addressees'; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailRecipients"]." CC"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' && sclm_configurationitemtypes_id_c='4203105b-79b1-8330-b136-52b9985ddcf1' && enabled!=0 ";
    $tablefields[$tblcnt][9][5] = $cc_addressees; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $cc_addressees; // Current Value       $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cc_addressees';//$field_value_id;
    $tablefields[$tblcnt][21] = $cc_addressees; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'bcc_addressees'; // Field Name
    $tablefields[$tblcnt][1] = $strings["EmailRecipients"]." BCC"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' && sclm_configurationitemtypes_id_c='c2bc3b5f-bfdd-a0ef-e399-52b998a94a28' && enabled!=0 ";
    $tablefields[$tblcnt][9][5] = $bcc_addressees; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $bcc_addressees; // Current Value       $tablefields[$tblcnt][9][6] = '';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'bcc_addressees';//$field_value_id;
    $tablefields[$tblcnt][21] = $bcc_addressees; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    # Start Attachmentiser
    # Media Types CIT: e5744b5d-b34d-ebf3-3c79-54c05f9300d5
    # General Content | ID: 48f00382-9b6f-5a09-bac6-54c0613701eb

    if ($action == 'edit'){

       # Must select from the already-attached list from CIs as related attachments
       # Attachments CIT = 36727261-b9ce-9625-2063-54bf15bb668b - 

       } # end if edit

    $tblcnt++;

    if ($action == 'add'){
       $currval = $valtype."_".$val;
       } else {
       $currval = $do."_".$val;
       }

    $tablefields[$tblcnt][0] = 'attachments'; // Field Name
    $tablefields[$tblcnt][1] = "Add Attachment"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = "sclm_configurationitemtypes"; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='e5744b5d-b34d-ebf3-3c79-54c05f9300d5' ";
    $tablefields[$tblcnt][9][5] = $currval; // Current Value
    $tablefields[$tblcnt][9][6] = 'Content';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Content'; //new do
    $tablefields[$tblcnt][9][9] = $currval; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'attachments';//$field_value_id;
    $tablefields[$tblcnt][21] = $currval; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    if ($filter_id != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'filter_id'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Filter"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = " account_id_c='".$account_id_c."' && sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' ";
       $tablefields[$tblcnt][9][5] = $filter_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
       $tablefields[$tblcnt][9][9] = $filter_id; // Current Value       $tablefields[$tblcnt][9][6] = '';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'filter_id';//$field_value_id;
       $tablefields[$tblcnt][21] = $filter_id; //$field_value;
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       }  // if filter

    if (!$cmn_statuses_id_c){
       $cmn_statuses_id_c = $standard_statuses_closed;
       }

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

    if ($action == 'edit' || $action == 'view'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'status'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]." *"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='d918bc49-f7df-8b75-1e4d-52802a2db21c' "; //ticket status
    $tablefields[$tblcnt][9][5] = $status; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'status';//$field_value_id;
    $tablefields[$tblcnt][21] = $status; //$field_value;
    $tablefields[$tblcnt][43] = "<img src=images/blank.gif width=10 height=3>".$status_image; // field extras

    }

    if ($action == 'add'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "date_entered"; // Field Name
       $tablefields[$tblcnt][1] = $strings["date_start"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '30'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $nowdate; // Field ID
       $tablefields[$tblcnt][20] = "date_entered"; //$field_value_id;
       $tablefields[$tblcnt][21] = $nowdate; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "date_modified"; // Field Name
       $tablefields[$tblcnt][1] = $strings["date_start"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $nowdate; // Field ID
       $tablefields[$tblcnt][20] = "date_modified"; //$field_value_id;
       $tablefields[$tblcnt][21] = $nowdate; //$field_value;   

       }

    if ($action == 'edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "date_modified"; // Field Name
       $tablefields[$tblcnt][1] = $strings["date_start"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $nowdate; // Field ID
       $tablefields[$tblcnt][20] = "date_modified"; //$field_value_id;
       $tablefields[$tblcnt][21] = $nowdate; //$field_value;  

       }

    if ($action == 'view'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "date_entered"; // Field Name
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
       $tablefields[$tblcnt][11] = $date_entered; // Field ID
       $tablefields[$tblcnt][20] = "date_entered"; //$field_value_id;
       $tablefields[$tblcnt][21] = $date_entered; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "current_date"; // Field Name
       $tablefields[$tblcnt][1] = $strings["DateCurrent"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $nowdate; // Field ID
       $tablefields[$tblcnt][20] = "current_date"; //$field_value_id;
       $tablefields[$tblcnt][21] = $nowdate; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       $tblcnt++;

       $tablefields[$tblcnt][0] = "accumulated_minutes"; // Field Name
       $tablefields[$tblcnt][1] = "<B>".$strings["AccumulatedMinutes"]." ".$strings["duration"].": " . $years . " ".$strings["Years"].", " . $days . " ".$strings["Days"].", " . $hours . " ".$strings["Hours"].", " . $mins . " ".$strings["Minutes"].".</B>"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'decimal';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][12] = '20'; //length
       $tablefields[$tblcnt][20] = "accumulated_minutes"; //$field_value_id;
       $tablefields[$tblcnt][21] = $new_accumulated_minutes; //$field_value;   
       $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "accumulated_minutes"; // Field Name
       $tablefields[$tblcnt][1] = $strings["AccumulatedMinutes"]; // Full Name
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
       $tablefields[$tblcnt][12] = '20'; //length
       $tablefields[$tblcnt][20] = "accumulated_minutes"; //$field_value_id;
       $tablefields[$tblcnt][21] = $new_accumulated_minutes; //$field_value;   

       }

    $tblcnt++;

    if (!$service_operation_process){
       $service_operation_process = 'e81b088c-a1a9-cc53-a49e-526c6c2ab05b';
       }

    $tablefields[$tblcnt][0] = 'service_operation_process'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceOperationProcess"]; // Full Name
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
    $tablefields[$tblcnt][9][3] = $lingoname;
    $tablefields[$tblcnt][9][4] = " sclm_configurationitems_id_c= '959c09e9-c980-458c-9b1d-5258a462b8da' ";//$exception;
    $tablefields[$tblcnt][9][5] = $service_operation_process; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
    $tablefields[$tblcnt][9][9] = $service_operation_process; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'service_operation_process';//$field_value_id;
    $tablefields[$tblcnt][21] = $service_operation_process; //$field_value;


/*
    if ($action == 'add'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Account"];; // Full Name
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
       $tablefields[$tblcnt][21] = $portal_account_id; //$field_value;   

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
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

       } else {
*/
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
          $tablefields[$tblcnt][9][4] = " id='".$portal_account_id."' "; // exception
          }
       $tablefields[$tblcnt][9][5] = $portal_account_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $portal_account_id; //$field_value;   

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
          $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$portal_account_id."' && accounts_contacts.contact_id=contacts.id "; // exception
          }

       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

       #}

       ####################################
       # For Agents

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
       $tablefields[$tblcnt][9][5] = $ci_account_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id1_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'contact_id1_c'; // Field Name
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
       $tablefields[$tblcnt][9][5] = $ci_contact_id1_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "firstlast";
       $tablefields[$tblcnt][21] = $ci_contact_id1_c;
       $tablefields[$tblcnt][50] = " CONCAT(contacts.first_name,' ',contacts.last_name) as firstlast ";

       # For Agents
       ####################################

//    if ($action == 'edit' && $auth==3 || $action == 'view'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_serviceslarequests_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLARequest"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_serviceslarequests'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' ";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_serviceslarequests_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServiceSLARequests';
    $tablefields[$tblcnt][9][7] = "sclm_serviceslarequests"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ServiceSLARequests'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_serviceslarequests_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "sclm_serviceslarequests_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_serviceslarequests_id_c; //$field_value;   

/*
       } else {

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_serviceslarequests_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLARequest"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "sclm_serviceslarequests_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_serviceslarequests_id_c; //$field_value;   

    }
*/

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
    $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$portal_account_id."' ";//$exception;
    $tablefields[$tblcnt][9][5] = $project_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Projects';
    $tablefields[$tblcnt][9][7] = "project"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Projects'; //new do
    $tablefields[$tblcnt][9][9] = $project_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'project_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $project_id_c; //$field_value;

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
    $tablefields[$tblcnt][9][4] = " project_task.id=project_task_cstm.id_c && project_task_cstm.account_id_c='".$portal_account_id."' ";//$exception;
    $tablefields[$tblcnt][9][5] = $projecttask_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ProjectTasks';
    $tablefields[$tblcnt][9][7] = "project_task"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ProjectTasks'; //new do
    $tablefields[$tblcnt][9][9] = $projecttask_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $projecttask_id_c; //$field_value;

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

    if ($action == 'add' || $action == 'edit'){

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       $sowparitems_object_type = "SOWItems";
       $sowparitems_action = "select";
       if ($sclm_sow_id_c != NULL){
          $sowparitems_params[0] = " sclm_sowitems_id_c='' && account_id_c='".$portal_account_id."' && sclm_sow_id_c='".$sclm_sow_id_c."' ";
          } else {
          $sowparitems_params[0] = " sclm_sowitems_id_c='' && account_id_c='".$portal_account_id."' ";
          }
       $sowparitems_params[1] = "id,item_number,name"; // select array
       $sowparitems_params[2] = ""; // group;
       $sowparitems_params[3] = "item_number,name ASC"; // order;
       $sowparitems_params[4] = ""; // limit
  
       $sowpar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sowparitems_object_type, $sowparitems_action, $sowparitems_params);

       if (is_array($sowpar_items)){

          for ($sowpar_cnt=0;$sowpar_cnt < count($sowpar_items);$sowpar_cnt++){

              $sow_parent_id = $sowpar_items[$sowpar_cnt]['id'];
              $sow_parent_name = "#".$sowpar_items[$sowpar_cnt]['item_number'].": ".$sowpar_items[$sowpar_cnt]['name'];              
              $sowitems_object_type = "SOWItems";
              $sowitems_action = "select";
              $sowitems_params[0] = " sclm_sowitems_id_c='".$sow_parent_id."' ";
              $sowitems_params[1] = "id,item_number,name"; // select array
              $sowitems_params[2] = ""; // group;
              $sowitems_params[3] = "item_number,name ASC"; // order;
              $sowitems_params[4] = ""; // limit

              $sow_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sowitems_object_type, $sowitems_action, $sowitems_params);

              if (is_array($sow_items)){

                 for ($sow_cnt=0;$sow_cnt < count($sow_items);$sow_cnt++){

                     $sow_id = $sow_items[$sow_cnt]['id'];
                     $sow_name = $sow_parent_name." -> #".$sow_items[$sow_cnt]['item_number'].": ".$sow_items[$sow_cnt]['name'];
                     $ddpack[$sow_id]=$sow_name;

                     } // for

                 } // if 

              } // for

          } // if array

       $tablefields[$tblcnt][9][1] = $ddpack; // If DB, dropdown_table, if List, then array, other related table

       } else {// action

       // view
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_sowitems'; // If DB, dropdown_table, if List, then array, other related table
       if ($sclm_sow_id_c != NULL){
          $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' && sclm_sow_id_c='".$sclm_sow_id_c."' ";
          } else {
          $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' ";
          }

       } // action

    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][5] = $sclm_sowitems_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'SOWItems';
    $tablefields[$tblcnt][9][7] = "sclm_sowitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'SOWItems'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_sowitems_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_sowitems_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_sowitems_id_c; //$field_value;

    $tblcnt++;

    $nowdate = date("Y-m-d H:i:s");
    if ($action == 'edit'){
#       $description = "###########  Update Start  ############\nDate: ".$nowdate."\n\n\n###########  Update End  ##############\n\n\n".$description;
       }

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
    $tablefields[$tblcnt][12] = '65'; //length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   

    ################################
    # Loop for allowed languages

    if ($action == 'edit'){

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
           $tablefields[$tblcnt][6] = '255'; // length
           $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = '1';//1; // show in view 
           $tablefields[$tblcnt][11] = $name_content; // Field ID
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
           $tablefields[$tblcnt][20] = $desc_field;//$field_value_id;
           $tablefields[$tblcnt][21] = $desc_content; //$field_value;

           } // end for languages

       } // if edit

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if ($ci_account_id_c == $account_id_c || $ci_account_id1_c == $account_id1_c || $auth==3 || $security_role == $role_SDM){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } else {
       $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
       }

    $valpack[5] = ""; // provide add new button
    if ($action == 'add'){
       $valpack[7] = $strings["Create"];
       } elseif ($action == 'edit'){
       $valpack[7] = $strings["Edit"];
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
    $container_params[3] = $strings["Ticket"]; // container_title
    $container_params[4] = 'Ticket'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    if ($action == 'view' || $action == 'edit'){
       $returner = $funky_gear->object_returner ('Ticketing', $val);
       $object_return = $returner[1];
       echo $object_return;

       }

    echo $container_top;
  
    echo "<div style=\"".$divstyle_blue."\" name='ADVISORY' id='ADVISORY'></div>";
    echo "<a href=\"#\" onClick=\"loader('ADVISORY');doBPOSTRequest('ADVISORY','Body.php', 'pc=".$portalcode."&do=Advisory&action=add&value=".$val."&valuetype=Ticketing&div=ADVISORY');return false\"><B>Add Advisory (FAQ)</B></a>";

    #echo "<BR><center><img src=images/icons/clock.png width=50></center><BR>";
    #echo "<center><div id=\"clockDisplay\" class=\"clockStyle\"></div></center>";
    #echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    echo $zaform;

    if ($action == 'view' || $action == 'edit'){

       $params = array();
       $params[0] = $name;
       echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

       }

    # Activities
    if ($action == 'view'){

       $ticket_object_type = "TicketingActivities";
       $ticket_action = "select";
       $ticket_params[0] = "sclm_ticketing_id_c='".$val."' ";
       $ticket_params[1] = "id,ticket_update"; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = " date_entered DESC "; // order;
       $ticket_params[4] = ""; // limit
       $ticket_params[5] = $lingoname; // lingo
  
       $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

       if (is_array($ticket_items)){
  
          for ($cnt=0;$cnt < count($ticket_items);$cnt++){

              $id = $ticket_items[$cnt]["id"];
              $ticket_update = $ticket_items[$cnt]["ticket_update"];

              if ($ticket_update != NULL){
                 $ticket_update = $funky_gear->replacer("\n", "<BR>", $ticket_update);
                 $activities .= "<div style=\"".$divstyle_white."\">".$ticket_update."</div>";
                 }

              } // for

          } // if array

       } // if action

    echo "<div style=\"".$divstyle_grey."\"><center><B>".$strings["Updates"]."</B></center></div>";
    echo $activities;

    # End Activities

    echo $container_bottom;

    if ($action == 'view' || $action == 'edit'){

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["TicketingActivities"]; // container_title
       $container_params[4] = 'TicketingActivities'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'TicketingActivities','list',$val,$do,$bodywidth);

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["Emails"]; // container_title
       $container_params[4] = 'TicketingEmails'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'Emails','list',$val,$do,$bodywidth);

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

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);

       echo $container_bottom;


       }

   break; // end Tickets add
   case 'cancel':

    if ($val){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $val);
       $process_params[] = array('name'=>'status','value' => '72b33850-b4b0-c679-f988-52c2eb40a5de');

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){

          $val = $result['id'];
          echo "Record cancelled successfully!";

          }

       } // end if val

   break; // end Tickets delete
   case 'delete':

    if ($val){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $val);
       $process_params[] = array('name'=>'deleted','value' => 1);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){

          $val = $result['id'];
          echo "Record deleted successfully!";

          }

       } // end if val

   break; // end Tickets delete

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

       $nowdate = date("Y-m-d H:i:s");

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       if (!$_POST['id']){
          $process_params[] = array('name'=>'date_entered','value' => $nowdate);
          }
       $process_params[] = array('name'=>'date_modified','value' => $_POST['date_modified']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
       $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $_POST['sclm_serviceslarequests_id_c']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
       $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
       $process_params[] = array('name'=>'service_operation_process','value' => $_POST['service_operation_process']);
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
       $process_params[] = array('name'=>'ticket_id','value' => $_POST['ticket_id']);
       $process_params[] = array('name'=>'ticket_source','value' => $_POST['ticket_source']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['sclm_configurationitems_id_c']);
       $process_params[] = array('name'=>'accumulated_minutes','value' => $_POST['accumulated_minutes']);
       $process_params[] = array('name'=>'status','value' => $_POST['status']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);
       $process_params[] = array('name'=>'filter_id','value' => $_POST['filter_id']);
       $process_params[] = array('name'=>'to_addressees','value' => $_POST['to_addressees']);
       $process_params[] = array('name'=>'cc_addressees','value' => $_POST['cc_addressees']);
       $process_params[] = array('name'=>'bcc_addressees','value' => $_POST['bcc_addressees']);
       $process_params[] = array('name'=>'extra_addressees','value' => $_POST['extra_addressees']);
       $process_params[] = array('name'=>'extra_addressees_cc','value' => $_POST['extra_addressees_cc']);
       $process_params[] = array('name'=>'extra_addressees_bcc','value' => $_POST['extra_addressees_bcc']);
       $process_params[] = array('name'=>'vendor_code','value' => $_POST['vendor_code']);
       $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $_POST['sclm_ticketing_id_c']);

       $sdmconfirm = $_POST['sdm_confirmed'];
       if ($sdmconfirm != NULL){
          $process_params[] = array('name'=>'sdm_confirmed','value' => $_POST['sdm_confirmed']);
          $process_params[] = array('name'=>'billing_count','value' => $_POST['billing_count']);
          }

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

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
       $showdesc = str_replace("\n","<BR>",$_POST['description']);
       $process_message .= "<B>".$strings["Description"].":</B> ".$showdesc."<BR>";

       # Check for attachments
       # Attachments CIT = 36727261-b9ce-9625-2063-54bf15bb668b

       $attachments = "";

       $attach_cit_relater_object_type = "ConfigurationItems";
       $attach_cit_relater_action = "update";

       # Prepare the pack of params for use with all attachments if added
       $attach_cit_relater_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $attach_cit_relater_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $attach_cit_relater_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $attach_cit_relater_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '36727261-b9ce-9625-2063-54bf15bb668b');
       #$attach_cit_relater_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['sclm_configurationitems_id_c']);
       $attach_cit_relater_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $attach_cit_relater_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $attach_cit_relater_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $attach_cit_relater_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
       $attach_cit_relater_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
       $attach_cit_relater_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
       $attach_cit_relater_params[] = array('name'=>'enabled','value' => 1);

       # Prepare the list of existing attachments for this account - could end up being a lot...
       $attach_cit_related_object_type = "ConfigurationItems";
       $attach_cit_related_action = "select"; 
       $attach_cit_related_params[0] = " sclm_configurationitemtypes_id_c = '36727261-b9ce-9625-2063-54bf15bb668b' && account_id_c='".$_POST['account_id_c']."' ";
       $attach_cit_related_params[1] = "id,sclm_configurationitemtypes_id_c,name"; // select array
       $attach_cit_related_params[2] = ""; // group;
       $attach_cit_related_params[3] = " name ASC "; // order;
       $attach_cit_related_params[4] = ""; // limit
       $attach_cit_related_params[5] = $lingoname; // lingo

       $attach_cit_related_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $attach_cit_related_object_type, $attach_cit_related_action, $attach_cit_related_params);

       foreach ($_POST as $key=>$value){

               if ($value != NULL){

                  $sclm_content_id_c = str_replace("attachments_key_","",$key);

                  if ($sclm_content_id_c == $value){
                     # A content attachment was sent - must make the CI relationship and package for email delivery
                     # Get the content location
                     # If web url content, should temp wget and add - but not yet

                     $attach_object_type = "Content";
                     $attach_action = "select";
                     $attach_params[0] = " id = '".$sclm_content_id_c."' ";
                     $attach_params[1] = "id,name,content_thumbnail,content_url,account_id_c"; // select array
                     $attach_params[2] = ""; // group;
                     $attach_params[3] = " name ASC "; // order;
                     $attach_params[4] = ""; // limit
                     $attach_params[5] = $lingoname; // lingo
  
                     $attach_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $attach_object_type, $attach_action, $attach_params);

                     if (is_array($attach_items)){

                        # Build a list of items to work out the URL      
                        for ($dropcnt=0;$dropcnt < count($attach_items);$dropcnt++){

                            $za_id = $attach_items[$dropcnt]["id"];
                            $za_title = $attach_items[$dropcnt]["name"];

                            $za_image = $attach_items[$dropcnt]["content_thumbnail"];
                            $content_type_image = $attach_items[$dropcnt]['content_type_image'];

                            if (!$za_image){
                               if ($content_type_image != NULL){
                                  $za_image = $content_type_image;
                                  } else {
                                  $za_image = "images/icons/page.gif";
                                  }
                               }

                            $content_url = $attach_items[$dropcnt]["content_url"];
                            #must remove the hostname by separating from content
    
                            if ($content_url != str_replace("uploads/","",$content_url)){
                               # This is an uploads
                               $content_location = "/var/www/vhosts/scalastica.com/httpdocs/".$content_url;
                               } elseif ($content_url != str_replace("/content/","",$content_url)){
                               list ($hostnamepart, $contentpart) = explode ("content", $content_url);
                               $content_location = "/var/www/vhosts/scalastica.com/httpdocs/content".$contentpart;
                               }

                            $attachments[$za_title] = $content_location;

                            $process_message .= "<P>Attachment, ".$za_title." , added to email<P>";

                            # Attachments CIT = 36727261-b9ce-9625-2063-54bf15bb668b

                            $attach_cit_relater = "Ticketing_".$val."_".$sclm_content_id_c;
                            $attrelci_name_exists = FALSE;

                            # Need to search CIs to see if this combination exists and if not add it...else - do not add it again
                            if (is_array($attach_cit_related_result)){

                               # Build a list of items to work out the URL      
                               for ($attrelci=0;$attrelci < count($attach_cit_related_result);$attrelci++){

                                   $attrelci_id = $attach_cit_related_result[$attrelci]["id"];
                                   $attrelci_name = $attach_cit_related_result[$attrelci]["name"];

                                   #list ($valtypepart, $valpart, $contentpart) = explode ("_", $attrelci_name);

                                   if ($attach_cit_relater == $attrelci_name){
                                      $attrelci_name_exists = TRUE;
                                      } 

                                   } # end for

                               } # end is array

                            if ($attrelci_name_exists == FALSE){

                               $attach_cit_relater_params[] = array('name'=>'name','value' => $attach_cit_relater);
                               $attach_cit_relater_params[] = array('name'=>'description','value' => $attach_cit_relater);
                               $attach_cit_relater_params[] = array('name'=>'image_url','value' => $za_image);

                               $attach_cit_relater_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $attach_cit_relater_object_type, $attach_cit_relater_action, $attach_cit_relater_params);

                               if ($attach_cit_relater_result['id'] != NULL){
                                  $attach_cit_relater_id = $attach_cit_relater_result['id'];
                                  }

                               } # end if attrelci_name_exists == FALSE

                            } # end for

                        } # is array
                     
                     } # if is key

                  } # if value selected

               } # End foreach for attachments

       # End if attachments
       #########################################
       # Prepare Emails

       $message_link = "Body@".$lingo."@Ticketing@view@".$val."@Ticketing";
       $message_link = $funky_gear->encrypt($message_link);
       $message_link = "http://".$hostname."/?pc=".$message_link;

       $type = 1;

       $from_name = $portal_title;
       $from_email = $portal_email;
       $from_email_password = $portal_email_password;

       if ($_POST['message_lingo'] != NULL){
          $lingo = $_POST['message_lingo'];
          #echo "Desired Lingo: ".$lingo."<BR>";
          }

       if ($_POST['sclm_serviceslarequests_id_c'] && $_POST['send_email']==1){

          $cnotifications_object_type = "ContactsNotifications";
          $cnotifications_action = "select";
          $cnotifications_params[0] = " sclm_serviceslarequests_id_c='".$_POST['sclm_serviceslarequests_id_c']."' && cmn_statuses_id_c='".$standard_statuses_open_public."' ";
          $cnotifications_params[1] = ""; // select array
          $cnotifications_params[2] = ""; // group;
          $cnotifications_params[3] = ""; // order;
          $cnotifications_params[4] = ""; // limit
  
          $cnotifications = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cnotifications_object_type, $cnotifications_action, $cnotifications_params);

          if (is_array($cnotifications)){

             for ($cnt=0;$cnt < count($cnotifications);$cnt++){

                 $contact_id_c = $cnotifications[$cnt]['contact_id_c'];

                 $contact_object_type = "Contacts";
                 $contact_action = "select_soap";
                 $contact_params = array();
                 $contact_params[0] = "contacts.id='".$contact_id_c."'"; // query
                 $contact_params[1] = array("first_name","last_name","email1");

                 $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
                 for ($cntcon=0;$cntcon < count($contact_info);$cntcon++){

                     $first_name = $contact_info[$cntcon]['first_name'];
                     $last_name = $contact_info[$cntcon]['last_name'];
                     $to_email = $contact_info[$cntcon]['email1'];
                     $to_name = $first_name." ".$last_name;
                     $internal_to_addressees[$to_email] = $to_name;

                     } // for

                 } // for cnotifications

             $mailparams[0] = $from_name;
             #$mailparams[1] = $to_name;
             $mailparams[2] = $from_email;
             $mailparams[3] = $from_email_password;
             #$mailparams[4] = $to_email;
             $mailparams[5] = $type;
             $mailparams[6] = $lingo;
             $mailparams[7] = $_POST['name'];
             $mailparams[8] = $_POST['description']."\n".$strings["action_view_here"].":\n".$message_link;
             $mailparams[9] = $portal_email_server;
             $mailparams[10] = $portal_email_smtp_port;
             $mailparams[11] = $portal_email_smtp_auth;
             $mailparams[12] = $internal_to_addressees;
             $mailparams[20] = $attachments;

             $emailresult = $funky_gear->do_email ($mailparams);

             $process_message .= "Email Result for internal/SLA-based Addressees: ".$emailresult."<P>";

             } // if array cnotifications

          } // if service sla request

       #
       ###########################
       #

       if ($_POST['send_email']==1){

          if ($_POST['extra_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
             $extra_addressees = $_POST['extra_addressees'];
             $extra_addressees = trim($extra_addressees);
             $extra_addressees = str_replace(" ","", $extra_addressees);
             $extra_addressees = str_replace("　","", $extra_addressees);
             } // is addressees

          if ($_POST['to_addressees'] != NULL){

             $recip_to_object_type = "ConfigurationItems";
             $recip_to_action = "select";
             $recip_to_params[0] = " id='".$_POST['to_addressees']."' ";
             $recip_to_params[1] = "id,name,description"; // select array
             $recip_to_params[2] = ""; // group;
             $recip_to_params[3] = ""; // order;
             $recip_to_params[4] = ""; // limit
  
             $recip_tos = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_to_object_type, $recip_to_action, $recip_to_params);

             if (is_array($recip_tos)){

                for ($cntrecpto=0;$cntrecpto < count($recip_tos);$cntrecpto++){

                    $recp_to_name = $recip_tos[$cntrecpto]['name'];
                    $recp_to_list = $recip_tos[$cntrecpto]['description']; 

                    } // for to_addressees

                if ($_POST['extra_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_to_list = $recp_to_list.",".$extra_addressees;
                   }

                } else {// if array extra_addressees

                if ($_POST['extra_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_to_list = $extra_addressees;
                   } 

                } 

             } else {// if $_POST['extra_addressees']!= NULL

             if ($_POST['extra_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                $recp_to_list = $extra_addressees;
                }

             } 

          #
          ###########################
          #

          if ($_POST['extra_addressees_cc'] != NULL && $_POST['send_extra_addresses'] == 1){
             $extra_addressees_cc = $_POST['extra_addressees_cc'];
             $extra_addressees_cc = trim($extra_addressees_cc);
             $extra_addressees_cc = str_replace(" ","", $extra_addressees_cc);
             $extra_addressees_cc = str_replace("　","", $extra_addressees_cc);
             }

          if ($_POST['cc_addressees'] != NULL){
   
             $recip_cc_object_type = "ConfigurationItems";
             $recip_cc_action = "select";
             $recip_cc_params[0] = " id='".$_POST['cc_addressees']."' ";
             $recip_cc_params[1] = "id,name,description"; // select array
             $recip_cc_params[2] = ""; // group;
             $recip_cc_params[3] = ""; // order;
             $recip_cc_params[4] = ""; // limit
  
             $recip_ccs = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_cc_object_type, $recip_cc_action, $recip_cc_params);

             if (is_array($recip_ccs)){

                for ($cntrecpcc=0;$cntrecpcc < count($recip_ccs);$cntrecpcc++){

                    $recp_cc_name = $recip_ccs[$cntrecpcc]['name'];
                    $recp_cc_list = $recip_ccs[$cntrecpcc]['description']; 

                    } // for cc_addressees

                if ($_POST['extra_addressees_cc'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_cc_list = $recp_cc_list.",".$extra_addressees_cc;
                   }

                } else {// if array cc_addressees

                if ($_POST['extra_addressees_cc'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_cc_list = $extra_addressees_cc;
                   }

                } 

             } else {// if $_POST['cc_addressees']!= NULL

             if ($_POST['extra_addressees_cc'] != NULL && $_POST['send_extra_addresses'] == 1){
                $recp_cc_list = $extra_addressees_cc;
                }

             } 

          #
          ###########################
          #

          if ($_POST['extra_addressees_bcc'] != NULL && $_POST['send_extra_addresses'] == 1){
             $extra_addressees_bcc = $_POST['extra_addressees_bcc'];
             $extra_addressees_bcc = trim($extra_addressees_bcc);
             $extra_addressees_bcc = str_replace(" ","", $extra_addressees_bcc);
             $extra_addressees_bcc = str_replace("　","", $extra_addressees_bcc);
             }

          if ($_POST['bcc_addressees'] != NULL){

             $recip_bcc_object_type = "ConfigurationItems";
             $recip_bcc_action = "select";
             $recip_bcc_params[0] = " id='".$_POST['bcc_addressees']."' ";
             $recip_bcc_params[1] = "id,name,description"; // select array
             $recip_bcc_params[2] = ""; // group;
             $recip_bcc_params[3] = ""; // order;
             $recip_bcc_params[4] = ""; // limit
  
             $recip_bccs = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_bcc_object_type, $recip_bcc_action, $recip_bcc_params);

             if (is_array($recip_bccs)){

                for ($cntrecpbcc=0;$cntrecpbcc < count($recip_bccs);$cntrecpbcc++){

                    $recp_bcc_name = $recip_bccs[$cntrecpbcc]['name'];
                    $recp_bcc_list = $recip_bccs[$cntrecpbcc]['description']; 

                    } // for cc_addressees

                if ($_POST['extra_addressees_bcc'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_bcc_list = $recp_bcc_list.",".$extra_addressees_bcc;
                   }

                } else {// if array cc_addressees

                if ($_POST['extra_addressees_bcc'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_bcc_list = $extra_addressees_bcc;
                   }

                } 

             } else {// if $_POST['cc_addressees']!= NULL

             if ($_POST['extra_addressees_bcc'] != NULL && $_POST['send_extra_addresses'] == 1){
                $recp_bcc_list = $extra_addressees_bcc;
                }

             } 

          #
          ###########################
          # Get lists found

          if ($recp_to_list != NULL){
             $recp_to_array = explode(',',$recp_to_list); //split string into array seperated by ','
             foreach ($recp_to_array as $recp_to_value){
                     $recp_to_value = trim($recp_to_value);
                     $to_addressees[$recp_to_value] = $recp_to_value;
                     }
             } // end if recp_cc_list

           if ($recp_cc_list != NULL){
              $recp_cc_array = explode(',',$recp_cc_list); //split string into array seperated by ','
              foreach ($recp_cc_array as $recp_cc_value){
                      $recp_cc_value = trim($recp_cc_value);
                      $cc_addressees[$recp_cc_value] = $recp_cc_value;
                      }
              } // end if recp_cc_list

          if ($recp_bcc_list != NULL){
             $recp_bcc_array = explode(',',$recp_bcc_list); //split string into array seperated by ','
             foreach ($recp_bcc_array as $recp_bcc_value){
                     $recp_bcc_value = trim($recp_bcc_value);
                     $bcc_addressees[$recp_bcc_value] = $recp_bcc_value;
                     }
             } // end if recp_bcc_list

          if ($recp_to_list != NULL || $recp_cc_list != NULL || $recp_bcc_list != NULL) {

             $mailparams[0] = $from_name;
             #$mailparams[1] = $to_name;
             $mailparams[2] = $from_email;
             $mailparams[3] = $from_email_password;
             #$mailparams[4] = $to_email;
             $mailparams[5] = $type;
             $mailparams[6] = $lingo;
             $mailparams[7] = $_POST['name'];
             $mailparams[8] = $_POST['description']."\n".$strings["action_view_here"].":\n".$message_link;
             $mailparams[9] = $portal_email_server;
             $mailparams[10] = $portal_email_smtp_port;
             $mailparams[11] = $portal_email_smtp_auth;
             $mailparams[12] = $to_addressees; // array
             $mailparams[13] = $cc_addressees; // array
             $mailparams[14] = $bcc_addressees; // array
             $mailparams[20] = $attachments;

             $emailresult = $funky_gear->do_email ($mailparams);

             $process_message .= "Email Result for TO/CC/BCC Addressees: ".$emailresult."<P>";

             } // if either list OK

          } // end if $_POST['send_email']==1

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end Tickets process

   } // end Tickets switch

# // End Tickets
##########################################################
?>
