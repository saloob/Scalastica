<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-09-20
# Page: ServiceSLARequests.php 
##########################################################
# case 'ServiceSLARequests':

   #echo "Params: ".$object_return_params[0]."<P>";

   ################################
   # Shared Access

   if ($action == 'list'){

      if ($portal_account_id != $sess_account_id){

         $sharing_params[0] = $portal_account_id;
         $sharing_params[1] = $sess_account_id;
         $sharing_info = $funky_gear->portal_sharing ($sharing_params);

         $shared_portal_ticketing = $sharing_info['shared_portal_ticketing'];
         $shared_portal_projects = $sharing_info['shared_portal_projects'];
         $shared_portal_slarequests = $sharing_info['shared_portal_slarequests'];
         $shared_portal_slarequest_sql = $sharing_info['shared_portal_slarequest_sql'];

         if ($shared_portal_slarequests != NULL){

            $lastitem = array_slice($shared_portal_slarequests, -1, 1, true);

            foreach ($lastitem as $lastkey => $lastsr) { 
                    $lastval = $lastsr;
                    }

            foreach ($shared_portal_slarequests as $key => $sr) { 

                    if ($lastval != $sr){
                       $srquery .= " id='".$sr."' || ";
                       } else {# if not last val
                       $srquery .= " id='".$sr."' ";
                       } 

                    } # foreach

            $object_return_params[0] = " deleted=0 && (".$srquery.") ";
            } else {# if ticketing
            $object_return_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
            } 

         } else {# if not portal_account_id 
         $object_return_params[0] = " deleted=0 && account_id_c = '".$sess_account_id."' ";
         }

      } # End if list

   # End Shared Access
   ################################

  if ($valtype == 'ConfigurationItems'){
     $object_return_params[0] .= " && cmn_statuses_id_c !='".$standard_statuses_closed."' && (parent_service_type='".$val."' || service_type='".$val."') " ;
     }

  if ($valtype == 'ServicesPrices'){
     $sent_sclm_servicesprices_id_c = $val;
     }

  if ($valtype == 'Services'){
     $sclm_services_id_c = $val;
     }

  # Account Management is for Owners

  switch ($valtype){

   case 'byaccount':
    $search_params = " && account_id_c = '".$val."' ";
   break;

  } // switch

  #echo "$valtype";

  if ($auth == 3){

     if ($search_params != NULL){
        $account_query = " && account_id_c IS NOT NULL ".$search_params;
        } else {
        $account_query = " && account_id_c IS NOT NULL && account_id_c = '".$portal_account_id."' ";
        } 

     #$object_return_params[0] .= " && ".$account_query." "; 

     } else {

     if ($search_params != NULL){
        $account_query = " && account_id_c IS NOT NULL ".$search_params;
        #$account_query = " account_id_c = '".$sess_account_id."' ";
        #$account_query = " account_id_c = '".$parent_account_id."' ";
        #$account_query = " account_id_c = '".$portal_account_id."' ";
        } else {
        #$account_query = " account_id_c = '".$sess_account_id."' ";
        #$account_query = " account_id_c = '".$portal_account_id."' ";
        } 

     $object_return_params[0] .= $account_query." && cmn_statuses_id_c !='".$standard_statuses_closed."' ";

     }

  if ($valtype == 'AccountsServices'){
     $sclm_accountsservices_id_c = $val;
     $sclm_services_id_c = $_POST['sclm_services_id_c'];
     $ci_account_id_c = $_POST['ci_account_id_c'];
     $ci_contact_id_c = $_POST['ci_contact_id_c'];
     }

  if ($valtype == 'ProjectTasks' && $val != NULL){
     $object_return_params[0] .= " && projecttask_id_c ='".$val."' ";
     }

  if ($_SESSION['ProjectTask'] != NULL){
     $projecttask_id_c = $_SESSION['ProjectTask'];
     $returner = $funky_gear->object_returner ('ProjectTasks', $projecttask_id_c);
     $object_return_name = $returner[0];
     $object_return = $returner[1];
     echo $object_return;
     }

  if ($valtype == 'Projects' && $val != NULL){
     $object_return_params[0] .= " && project_id_c ='".$val."' ";
     }

  if ($_SESSION['Project'] != NULL){
     $project_id_c = $_SESSION['Project'];
     $returner = $funky_gear->object_returner ('Projects', $project_id_c);
     $object_return_name = $returner[0];
     $object_return = $returner[1];
     echo $object_return;
     }

  if ($_SESSION['SOWItem'] != NULL){
     $sclm_sowitems_id_c = $_SESSION['SOWItem'];
     $returner = $funky_gear->object_returner ('SOWItems', $sclm_sowitems_id_c);
     $object_return_name = $returner[0];
     $object_return = $returner[1];
     echo $object_return;
     }

if ($action == 'search'){

   $keyword = $_POST['keyword'];
   $vallength = strlen($keyword);
   $trimval = substr($keyword, 0, -1);
   #$object_return_params[0] = " deleted=0 ";
   $object_return_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%' ) ";
   #$object_return_params[0] .= " && account_id_c='".$sess_account_id."' ";

   }

  switch ($action){
   
   case 'manage':

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Manage ".$strings["ServiceSLARequest"]."</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<BR><center><img src=images/icons/heart.png width=50></center><BR>";
    echo "<center><div id=\"clockDisplay\" class=\"clockStyle\"></div></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    # Collect all the Accounts SLAs that can be managed by this account
    $ci_object_type = 'AccountsServicesSLAs';
    $ci_action = "select";
    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = "id,name,date_entered,date_modified,account_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $date_entered = $ci_items[$cnt]['date_entered'];
           $date_modified = $ci_items[$cnt]['date_modified'];
           $record_account_id_c = $ci_items[$cnt]['account_id_c'];

           if ($auth==3){

              if (!in_array($record_account_id_c,$service_accounts)){

                 $service_accounts[] = $record_account_id_c;

                 } // if

              } // if auth

           } // for accounts service sla

       } // is array

    if ($auth==3){

       if (is_array($service_accounts)){

          foreach ($service_accounts as $account_id){

                  $acc_returner = $funky_gear->object_returner ('Accounts', $account_id);
                  $acc_name = $acc_returner[0];
                  //$acc_link = $acc_returner[3];
                  $acc_link = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=manage&value=".$account_id."&valuetype=byaccount');return false\"><font size=2 color=red><B>".$acc_name."</B></font></a>";

                  $account_pack .= $acc_link."<BR>";

                  } // foreach

           echo "<div style=\"overflow:auto;min-height:100px;max-height:150px;width:98%;\"><div style=\"".$divstyle_white."\">".$account_pack."</div></div>";

          } // is array

       } // if auth

    $ci_object_type = 'AccountsServicesSLAs';
    $ci_action = "select";
    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = "id,name,date_entered,date_modified,account_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;
       $extraparams = "";

       $navi_returner = $funky_gear->navigator ($count,$do,"manage",$val,$valtype,$page,$glb_perpage_items,$BodyDIV,$extraparams);
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
           $record_account_id_c = $ci_items[$cnt]['account_id_c'];

           if (($sess_account_id != NULL && $sess_account_id==$record_account_id_c) || $auth==3){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServicesSLAs&action=edit&value=".$id."&valuetype=AccountsServicesSLAs');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              } else {
              $edit = "";
              }

           if ($auth == 3){
              $show_id = " | ACC SLA ID: ".$id;
              } else {
              $show_id = "";
              }

           $cis .= "<div style=\"".$divstyle_blue."\">".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServicesSLAs&action=view&value=".$id."&valuetype=AccountsServicesSLAs');return false\"><B>".$name."</B></a>".$show_id."</div>";

           $servslareq_object_type = 'ServiceSLARequests';
           $servslareq_action = "select";
           $servslareq_params[0] = " sclm_accountsservicesslas_id_c='".$id."' ";
           $servslareq_params[1] = "id,name,date_entered,date_modified,account_id_c"; // select array
           $servslareq_params[2] = ""; // group;
           $servslareq_params[3] = " sclm_servicessla_id_c,sclm_services_id_c, name, date_entered DESC "; // order;
           $servslareq_params[4] = ""; // limit

           $servslareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $servslareq_object_type, $servslareq_action, $servslareq_params);

/*
           if (is_array($servslareq_items)){
              $servslareq_count = count($servslareq_items);
              }
*/

           if (is_array($servslareq_items)){
/*
              $count = count($servslareq_items);
              $page = $_POST['page'];
              $glb_perpage_items = 20;

              $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
              $lfrom = $navi_returner[0];
              $navi = $navi_returner[1];

              echo $navi;

              $ci_params[4] = " $lfrom , $glb_perpage_items "; 
       
              $servslareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

*/       
              for ($srvslareqcnt=0;$srvslareqcnt < count($servslareq_items);$srvslareqcnt++){

                  $srvslareq_id = $servslareq_items[$srvslareqcnt]['id'];
                  $srvslareq_name = $servslareq_items[$srvslareqcnt]['name'];
/*
                  $date_entered = $servslareq_items[$srvslareqcnt]['date_entered'];
                  $date_modified = $servslareq_items[$srvslareqcnt]['date_modified'];
                  $modified_user_id = $servslareq_items[$srvslareqcnt]['modified_user_id'];
                  $created_by = $servslareq_items[$srvslareqcnt]['created_by'];
                  $description = $servslareq_items[$srvslareqcnt]['description'];
                  $deleted = $servslareq_items[$srvslareqcnt]['deleted'];
                  $assigned_user_id = $servslareq_items[$srvslareqcnt]['assigned_user_id'];
                  $sclm_services_id_c = $servslareq_items[$srvslareqcnt]['sclm_services_id_c'];
                  $ci_account_id_c = $servslareq_items[$srvslareqcnt]['account_id_c'];
                  $ci_contact_id_c = $servslareq_items[$srvslareqcnt]['contact_id_c'];
                  $cmn_statuses_id_c = $servslareq_items[$srvslareqcnt]['cmn_statuses_id_c'];
                  $sclm_servicessla_id_c = $servslareq_items[$srvslareqcnt]['sclm_servicessla_id_c'];
                  $start_date = $servslareq_items[$srvslareqcnt]['start_date'];
                  $end_date = $servslareq_items[$srvslareqcnt]['end_date'];
                  $sclm_accountsservices_id_c = $servslareq_items[$srvslareqcnt]['sclm_accountsservices_id_c'];
                  $sclm_accountsservicesslas_id_c = $servslareq_items[$srvslareqcnt]['sclm_accountsservicesslas_id_c'];
                  $project_id_c = $servslareq_items[$srvslareqcnt]['project_id_c'];
                  $projecttask_id_c = $servslareq_items[$srvslareqcnt]['projecttask_id_c'];
                  $sclm_sowitems_id_c = $servslareq_items[$srvslareqcnt]['sclm_sowitems_id_c'];
                  $sclm_sla_id_c = $servslareq_items[$srvslareqcnt]['sclm_sla_id_c'];
*/

                  if ($auth == 3){
                     $srvslareq_show_id = " | SLA Req ID: ".$srvslareq_id;
                     } else {
                     $srvslareq_show_id = "";
                     }

                  if (($sess_account_id != NULL && $sess_account_id==$record_account_id_c) || $auth==3){
                     $srvslareq_edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$srvslareq_id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
                     }

                  $servslareqs .= "<div style=\"".$divstyle_white."\">".$srvslareq_edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$srvslareq_id."&valuetype=".$valtype."');return false\"><B>".$srvslareq_name."</B></a>".$srvslareq_show_id."</div>";

                  } // for serv sla reqs

              } else { // end if array

              $servslareqs = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

              } //

           $cis .= $servslareqs;

           } // for accounts service sla

       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    echo $cis;

    echo $navi;

   break;
   case 'list':
   case 'search':
   
    ################################
    # List
    
    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["ServiceSLARequest"]."</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<BR><center><img src=images/icons/heart.png width=50></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

       $date = date("Y@m@d@G");
       $body_sendvars = $date."#Bodyphp";
       $body_sendvars = $funky_gear->encrypt($body_sendvars);

?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<center><div id=\"clockDisplay\" class=\"clockStyle\"></div></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<div style=\"".$divstyle_orange."\">".$strings["ServiceSLARequestMessage"]."</div>";

    $ci_object_type = 'ServiceSLARequests';
    $ci_action = "select";

    #$object_return_params[0] .= " && (name <=> NULL || name IS NOT NULL || name != '' || name != 'NULL') ";

    #echo "Params: ".$object_return_params[0]."<P>";

    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " sclm_accountsservicesslas_id_c,sclm_servicessla_id_c,sclm_services_id_c, name, date_entered DESC "; // order;
    $ci_params[4] = ""; // limit

    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 30;

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
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
           $start_date = $ci_items[$cnt]['start_date'];
           $end_date = $ci_items[$cnt]['end_date'];
           $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
           $sclm_accountsservicesslas_id_c = $ci_items[$cnt]['sclm_accountsservicesslas_id_c'];
           $project_id_c = $ci_items[$cnt]['project_id_c'];
           $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
           $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
           $sclm_sla_id_c = $ci_items[$cnt]['sclm_sla_id_c'];
           $timezone = $ci_items[$cnt]['timezone'];

           // Get capacity of Engineers available for each service
           $service_capacity = 0;

           $capacity_object_type = "ContactsServicesSLA";
           $capacity_action = "select";
           $capacity_params[0] = " sclm_servicessla_id_c='".$sclm_servicessla_id_c."' ";
           $capacity_params[1] = ""; // select array
           $capacity_params[2] = ""; // group;
           $capacity_params[3] = ""; // order;
           $capacity_params[4] = ""; // limit
  
           $capacity_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $capacity_object_type, $capacity_action, $capacity_params);

           if (is_array($capacity_items)){
              $service_capacity = count($capacity_items);
              }
/*
              for ($cnt=0;$cnt < count($capacity_items);$cnt++){
                  $cap_contact_id_c = "";
                  $cap_contact_id_c = $capacity_items[$cnt]['contact_id_c'];
                  $own_capacity = "";
                  if ($sess_contact_id == $cap_contact_id_c){
                     $own_capacity = "<BR><img src=images/blank.gif width=30 height=3><img src=images/icons/ok.gif width=16> You have selected you have capacity for this<BR>"; 
                     $cap_account_id_c = $capacity_items[$cnt]['account_id_c'];

                     } // end if sess            

                  } // end for

              } // end if is array
*/

/*
           $market_value = $ci_items[$cnt]['market_value'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $parent_service_type_id = $ci_items[$cnt]['parent_service_type_id'];
           $service_type_id = $ci_items[$cnt]['service_type_id'];
           $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
           $service_type_name = $ci_items[$cnt]['service_type_name'];
*/
           // Get capacity of Engineers available for each service
//           $service_capacity = 0;
/*
           $capacity_object_type = "ContactsServices";
           $capacity_action = "select";
           $capacity_params[0] = " sclm_services_id_c='".$id."' ";
           $capacity_params[1] = ""; // select array
           $capacity_params[2] = ""; // group;
           $capacity_params[3] = ""; // order;
           $capacity_params[4] = ""; // limit
  
           $capacity_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $capacity_object_type, $capacity_action, $capacity_params);

           if (is_array($capacity_items)){
              $service_capacity = count($capacity_items);
              }
*/
           if (($sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c) || $auth==3){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

//           $cis .= "<div style=\"".$divstyle_white."\">".$edit." [<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$parent_service_type_id."&valuetype=ConfigurationItems');return false\">".$parent_service_type_name." -></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$service_type_id."&valuetype=ConfigurationItems');return false\">".$service_type_name."</a>] <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a> [Capacity: ".$service_capacity."]</div>";
           $sla_status = 0;

           $sla_params = "";

           $sla_params[0] = $do;
           $sla_params[1] = $valtype;
           $sla_params[2] = $val;
           $sla_params[3] = $action;
           $sla_params[4] = $id;
           $sla_params[5] = $sclm_sla_id_c;
           $sla_params[7] = $start_date;
           $sla_params[8] = $end_date;
//           $sla_params[9] = $sclm_accountsservices_id_c;
//           $sla_params[10] = $sclm_accountsservicesslas_id_c;
           $sla_params[11] = ""; // checkdate
           $sla_params[12] = ""; // country
           $sla_params[13] = $timezone;

           $sla_return = "";
           $sla_return = $funky_gear->check_sla ($sla_params);

           $sla_status = $sla_return[0];

           $create_ticket = "";

//           $notifications = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=notifications&value=".$id."&valuetype=".$do."');return false\" class=\"css3button\"><img src=images/icons/gear.png width=16 border=0><font size=4 color=BLUE><B>Set Notifications</B></font></a>";

           // Services Offered
           $services_object_type = 'AccountsServices';
           $services_action = "select";
           if ($sclm_accountsservices_id_c){
              $services_params[1] = " id='".$sclm_accountsservices_id_c."' "; // select array
              } else {
              $services_params[1] = " account_id_c='".$account_id_c."' "; // select array
              }
           $services_params[2] = ""; // group;
       //    $services_params[3] = " service_tier, name, date_entered DESC "; // order;
           $services_params[3] = " id,sclm_services_id_c DESC, name ASC, date_modified DESC "; // order;
           $services_params[4] = ""; // limit

           $service_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $services_object_type, $services_action, $services_params);

           if (is_array($service_list)){

              for ($svccnt=0;$svccnt < count($service_list);$svccnt++){

                  //$id = $ci_items[$cnt]['id'];
                  $accountsservices_name = $service_list[$svccnt]['name'];

                  //$services .= "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=images/ServiceCatalog-Default.png width=16></div><div style=\"width:98%;float:left;padding-top:2;margin-left:8;padding-left:2;\"><B>".$accountsservices_name."</B><BR>".$edit."<a href=\"#\" onClick=\"loader('SLAs');doBPOSTRequest('SLAs','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=list&value=".$sclm_accountsservices_id_c."&valuetype=AccountsServices');return false\"><font size=2 color=black><B>[".$strings["action_view"]."]</B></font></a>".$show_id."</div></div>";

                  }

              }
                  
           $notifications = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ContactsNotifications&action=list&value=".$id."&valuetype=".$do."');return false\" class=\"css3button\"><img src=images/icons/gear.png width=16 border=0></a>";

           if ($sla_status == 1){

              $stat = "<img src=images/icons/stat_ok.gif>";
              $create_ticket_off = "";
              $create_ticket_on = " <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&sclm_serviceslarequests_id_c=".$id ."&child_id=".$child_id."&value=".$val."&valuetype=".$do."');return false\" class=\"css3button\"><img src=images/icons/new.png width=16 border=0><font size=4 color=RED><B>".$strings["TicketCreate"]."</B></font></a>";

              } else {
              $create_ticket_on = "";
              $stat = "<img src=images/icons/stat_progress.gif>";
              $create_ticket_off = "<div style=\"width:178px;float:left;padding-top:0;\"><div class=\"css3button\"><center><font color=BLACK>".$strings["SLABoundaryHit"]."</font></center></div></div>";
//              $create_ticket = " <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\" class=\"css3button\"><font size=4 color=BLACK>".$strings["SLABoundaryHit"]."</font></a>";


              }

           if ($create_ticket_on != NULL){
              $cis_on .= "<div style=\"".$divstyle_white."\"><div style=\"width:5%;float:left;padding-top:5;\">".$stat."</div><div style=\"width:95%;float:left;padding-top:10;\">".$create_ticket_on." ".$notifications."</div><BR><div style=\"".$divstyle_blue."\"><B>".$strings["ServiceSLA"].":</B>".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a></div></div>";
              } // on

           if ($create_ticket_off != NULL){
              $cis_off .= "<div style=\"".$divstyle_white."\"><div style=\"width:5%;float:left;padding-top:5;\">".$stat."</div><div style=\"width:95%;float:left;padding-top:10;\">".$create_ticket_off." ".$notifications."</div><BR><div style=\"".$divstyle_blue."\"><B>".$strings["ServiceSLA"].":</B>".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a></div></div>";
              } // on

           } // end for
      
       } else { // end if array

       $cis_on = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";
       #$cis_off = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL){    
//       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    echo $services;
    echo "<div style=\"".$divstyle_blue."\" id=SLAs name=SLAs></div>";

    if (count($ci_items)>10){
       echo $addnew.$cis_on.$addnew;
       echo $addnew.$cis_off.$addnew;
       } else {
       echo $cis_on.$addnew;
       echo $cis_off.$addnew;
       }
   
    echo $navi;

    # End List
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view' ){

       $ci_object_type = 'ServiceSLARequests';
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
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
              $start_date = $ci_items[$cnt]['start_date'];
              $end_date = $ci_items[$cnt]['end_date'];
              $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
              $sclm_accountsservicesslas_id_c = $ci_items[$cnt]['sclm_accountsservicesslas_id_c'];
              $project_id_c = $ci_items[$cnt]['project_id_c'];
              $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
              $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
              $provider_price = $ci_items[$cnt]['provider_price'];
              $reseller_price = $ci_items[$cnt]['reseller_price'];
              $customer_price = $ci_items[$cnt]['customer_price'];
              $sclm_servicesprices_id_c = $ci_items[$cnt]['sclm_servicesprices_id_c'];

              } // end for

          } // is array

       } // is edit/view

    if ($sclm_servicesprices_id_c == NULL && $sent_sclm_servicesprices_id_c != NULL && $valtype == "ServicesPrices"){
       $sclm_servicesprices_id_c = $sent_sclm_servicesprices_id_c;
       # This ID is the SLA - need to get the AS ID
       $returner = $funky_gear->object_returner ($valtype, $sclm_servicesprices_id_c);
       $object_return = $returner[1];
       echo $object_return;

       $ci_object_type = 'ServicesPrices';
       $ci_action = "select";
       $ci_params[0] = " id='".$sclm_servicesprices_id_c."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = "";
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           #$id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $date_entered = $ci_items[$cnt]['date_entered'];
           $date_modified = $ci_items[$cnt]['date_modified'];
           $modified_user_id = $ci_items[$cnt]['modified_user_id'];
           $created_by = $ci_items[$cnt]['created_by'];
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
           $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $cmn_currencies_id_c = $ci_items[$cnt]['cmn_currencies_id_c'];
           $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
           $price_account_id_c = $ci_items[$cnt]['account_id_c'];
           $price_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
           $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
           $credits = $ci_items[$cnt]['credits'];

           $credit_params[0] = $credits;
           $credit_params[1] = $cmn_currencies_id_c;
           $credit_params[2] = $price_account_id_c;
           $credits_pack = $funky_gear->creditisor ($credit_params);

           $customer_price = $credits_pack[0];
           $provider_price = $credits_pack[1];
           $reseller_price = $credits_pack[2];
           $currency_name = $credits_pack[3];
           $iso_code = $credits_pack[4];
           $currency_country = $credits_pack[5];
           #$timezone = $ci_items[$cnt]['timezone'];

           $sourcevaltype = $_POST['sourcevaltype'];
           $sourceval = $_POST['sourceval'];

           if ($sourcevaltype == 'AccountsServices'){

              $sclm_accountsservices_id_c = $sourceval;

              } #if acc service

           } # for

       } # if

    if (!$ci_account_id_c){
       $ci_account_id_c = $account_id_c;
       }
    if (!$ci_contact_id_c){
       $ci_contact_id_c = $contact_id_c;
       }

    # If global services allowed
    $global_object_type = "ConfigurationItems";
    $global_action = "select";

    $global_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && sclm_configurationitemtypes_id_c='4a67c6fb-42d0-8cb6-84b9-54deec34066b' && name=1";
    $global_params[1] = "id,name,description,sclm_configurationitemtypes_id_c"; // select array
    $global_params[2] = ""; // group;
    $global_params[3] = ""; // order;
    $global_params[4] = ""; // limit

    $global_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $global_object_type, $global_action, $global_params);

    $global_status = FALSE;

    if (is_array($global_items)){

       $global_status = TRUE;

       } # if array

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
    $tablefields[$tblcnt][41] = 0;

    if ($action == "edit" || $action == "view" ){

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
       $tablefields[$tblcnt][41] = 0;

       } # edit

    if ($price_account_id_c == $sess_account_id){

       # Only the price owner may adjust price and commissions

       $tblcnt++;

       $tablefields[$tblcnt][0] = "provider_price"; // Field Name
       $tablefields[$tblcnt][1] = "Provider Price"; // Full Name
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
       $tablefields[$tblcnt][20] = "provider_price"; //$field_value_id;
       $tablefields[$tblcnt][21] = $provider_price; //$field_value;   
       $tablefields[$tblcnt][41] = 0;

       $tblcnt++;

       $tablefields[$tblcnt][0] = "reseller_price"; // Field Name
       $tablefields[$tblcnt][1] = "Reseller Price"; // Full Name
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
       $tablefields[$tblcnt][20] = "reseller_price"; //$field_value_id;
       $tablefields[$tblcnt][21] = $reseller_price; //$field_value;   
       $tablefields[$tblcnt][41] = 0;

       $tblcnt++;

       $tablefields[$tblcnt][0] = "customer_price"; // Field Name
       $tablefields[$tblcnt][1] = "Customer Price"; // Full Name
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
       $tablefields[$tblcnt][20] = "customer_price"; //$field_value_id;
       $tablefields[$tblcnt][21] = $customer_price; //$field_value;   
       $tablefields[$tblcnt][41] = 0;

       } # if price owner

    $tblcnt++;

    if ($cmn_statuses_id_c == NULL || $cmn_statuses_id_c == 'NULL'){
       $cmn_statuses_id_c = $standard_statuses_open;
       }

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
//    $tablefields[$tblcnt][9][7] = "cmn_statuses"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    if ($action == 'view' || $system_access){

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
       $tablefields[$tblcnt][9][5] = $ci_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

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

    if ($start_date==NULL){
       $start_date = date("Y-m-d");
       }

    $tablefields[$tblcnt][0] = "start_date"; // Field Name
    $tablefields[$tblcnt][1] = $strings["DateStart"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '30'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "start_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $start_date; //$field_value;   

    $tblcnt++;

    if ($end_date==NULL){
       $end_date_year = date("Y");
       $end_date_month = date("m");
       $end_date_day = date("d");
       $end_date_year = $end_date_year + 1;
//       $date = date("Y-m-d G:i:s", strtotime($checkdate));
       $end_date = $end_date_year."-".$end_date_month."-".$end_date_day;
       }

    $tablefields[$tblcnt][0] = "end_date"; // Field Name
    $tablefields[$tblcnt][1] = $strings["DateEnd"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '30'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "end_date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $end_date; //$field_value;   

/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'service_tier'; // Field Name
    $tablefields[$tblcnt][1] = "Service Tier"; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='4f01b406-b96d-273b-8508-52400531e2e2' ";//$exception;
    $tablefields[$tblcnt][9][5] = $service_tier; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'service_tier';//$field_value_id;
    $tablefields[$tblcnt][21] = $service_tier; //$field_value;
    $tablefields[$tblcnt][41] = 0;
*/
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_services_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["BaseService"]."*"; // Full Name
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
    if ($sclm_services_id_c != NULL){
       $tablefields[$tblcnt][9][4] = "id='".$sclm_services_id_c."' ";//$exception;
       }
    $tablefields[$tblcnt][9][5] = $sclm_services_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Services';
    $tablefields[$tblcnt][9][7] = "sclm_services"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Services'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_services_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;
    $tablefields[$tblcnt][41] = 0;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_servicessla_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLA"]."*"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_servicessla'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    if ($sclm_servicessla_id_c != NULL){
       $tablefields[$tblcnt][9][4] = "id='".$sclm_servicessla_id_c."' ";//$exception;
       }
    $tablefields[$tblcnt][9][5] = $sclm_servicessla_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServicesSLA';
    $tablefields[$tblcnt][9][7] = "sclm_servicessla"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ServicesSLA'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_servicessla_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_servicessla_id_c; //$field_value;
    $tablefields[$tblcnt][41] = 0;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_accountsservices_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["CatalogService"]."*"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    if ($sclm_accountsservices_id_c != NULL){
       $tablefields[$tblcnt][9][1] = 'sclm_accountsservices'; // If DB, dropdown_table, if List, then array, other related table
       } else {
       $tablefields[$tblcnt][9][1] = 'sclm_accountsservices,sclm_servicesprices'; // If DB, dropdown_table, if List, then array, other related table
       }
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($sclm_accountsservices_id_c != NULL){

       $tablefields[$tblcnt][9][4] = " id='".$sclm_accountsservices_id_c."' ";

       } else {

       if ($global_status){
          $global_query = " sclm_accountsservices.cmn_statuses_id_c != '".$standard_statuses_closed."' && sclm_accountsservices.cmn_statuses_id_c IS NOT NULL && sclm_accountsservices.cmn_statuses_id_c != '' ";
          } else {
          $global_query = " sclm_accountsservices.account_id_c='".$portal_account_id."' && sclm_accountsservices.cmn_statuses_id_c IS NOT NULL && sclm_accountsservices.cmn_statuses_id_c != '' ";
          }

       if ($sclm_services_id_c != NULL){
          $tablefields[$tblcnt][9][4] = " sclm_servicesprices.sclm_services_id_c=sclm_accountsservices.sclm_services_id_c && sclm_accountsservices.sclm_services_id_c='".$sclm_services_id_c."' && ".$global_query;
          } else {
          $tablefields[$tblcnt][9][4] = " sclm_servicesprices.sclm_services_id_c=sclm_accountsservices.sclm_services_id_c && ".$global_query;
          }

       } # if sclm_accountsservices_id_c

    $tablefields[$tblcnt][9][5] = $sclm_accountsservices_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'AccountsServices';
    $tablefields[$tblcnt][9][7] = "sclm_accountsservices"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'AccountsServices'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_accountsservices_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_accountsservices_id_c; //$field_value;
    $tablefields[$tblcnt][41] = 0;

    $tblcnt++;

    if ($sclm_accountsservicesslas_id_c == NULL && $sclm_servicessla_id_c != NULL && $sclm_accountsservices_id_c != NULL){

       #echo "$sclm_accountsservicesslas_id_c == NULL && $sclm_servicessla_id_c != NULL && $sclm_accountsservices_id_c != NULL <P>";

       # If price sent, use that sclm_accountsservicesslas_id_c as the current as default

       $accservsla_object_type = "AccountsServicesSLAs";
       $accservsla_action = "select";
       $accservsla_params[0] = " sclm_servicessla_id_c='".$sclm_servicessla_id_c."' && sclm_accountsservices_id_c='".$sclm_accountsservices_id_c."' ";
       $accservsla_params[1] = "id"; // select array
       $accservsla_params[2] = ""; // group;
       $accservsla_params[3] = ""; // order;
       $accservsla_params[4] = ""; // limit

       $accservsla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accservsla_object_type, $accservsla_action, $accservsla_params);

       if (is_array($accservsla_items)){

          #echo "is array <P>";

          for ($accservsla_cnt=0;$accservsla_cnt < count($accservsla_items);$accservsla_cnt++){

              $sclm_accountsservicesslas_id_c = $accservsla_items[$accservsla_cnt]['id'];

              } // end for

          } // is array

       } # if not sclm_accountsservicesslas_id_c

    #echo "sclm_accountsservicesslas_id_c $sclm_accountsservicesslas_id_c <P>";

    $tablefields[$tblcnt][0] = 'sclm_accountsservicesslas_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["AccountServicesSLAs"]."*"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_accountsservicesslas'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($sclm_accountsservicesslas_id_c != NULL){
       $tablefields[$tblcnt][9][4] = " id='".$sclm_accountsservicesslas_id_c."' ";
       } elseif ($sclm_servicessla_id_c != NULL && $sclm_accountsservices_id_c != NULL){
       $tablefields[$tblcnt][9][4] = " sclm_accountsservices_id_c='".$sclm_accountsservices_id_c."' && sclm_servicessla_id_c='".$sclm_servicessla_id_c."' ";
       } elseif ($sclm_accountsservices_id_c != NULL && $sclm_servicessla_id_c == NULL ){
       $tablefields[$tblcnt][9][4] = " sclm_accountsservices_id_c='".$sclm_accountsservices_id_c."' ";
       } elseif ($sclm_servicessla_id_c != NULL && $sclm_accountsservices_id_c == NULL){
       $tablefields[$tblcnt][9][4] = " sclm_servicessla_id_c='".$sclm_servicessla_id_c."' ";
       }

    $tablefields[$tblcnt][9][5] = $sclm_accountsservicesslas_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'AccountsServicesSLAs*';
    $tablefields[$tblcnt][9][7] = "sclm_accountsservicesslas"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'AccountsServicesSLAs'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_accountsservicesslas_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_accountsservicesslas_id_c; //$field_value;
    $tablefields[$tblcnt][41] = 0;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_servicesprices_id_c'; // Field Name
    $tablefields[$tblcnt][1] = "Selected Price"; // Full Name
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
    if ($sclm_services_id_c != NULL){
       $tablefields[$tblcnt][9][4] = " sclm_services_id_c='".$sclm_services_id_c."' ";//$exception;
       } else {
       $tablefields[$tblcnt][9][4] = "";//$exception;
       }
    $tablefields[$tblcnt][9][5] = $sclm_servicesprices_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServicesPrices';
    #$tablefields[$tblcnt][9][7] = "cmn_statuses"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_servicesprices_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_servicesprices_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue


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
    $tablefields[$tblcnt][9][1] = 'project_cstm,project'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
//    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$account_id_c."' "; // exception;
    $tablefields[$tblcnt][9][5] = $project_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Project';
    $tablefields[$tblcnt][9][7] = "project"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Project'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'project_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $project_id_c; //$field_value;
    $tablefields[$tblcnt][41] = 0;

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
    $tablefields[$tblcnt][9][4] = " project_task.id=project_task_cstm.id_c && project_task_cstm.account_id_c='".$account_id_c."' "; // exception;
    $tablefields[$tblcnt][9][5] = $projecttask_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ProjectTasks';
    $tablefields[$tblcnt][9][7] = "project_task"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ProjectTasks'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $projecttask_id_c; //$field_value;
    $tablefields[$tblcnt][41] = 0;

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
          $sowparitems_params[0] = " sclm_sowitems_id_c='' && account_id_c='".$ci_account_id_c."' && sclm_sow_id_c='".$sclm_sow_id_c."' ";
          } else {
          $sowparitems_params[0] = " sclm_sowitems_id_c='' && account_id_c='".$ci_account_id_c."' ";
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
          $tablefields[$tblcnt][9][4] = " account_id_c='".$ci_account_id_c."' && sclm_sow_id_c='".$sclm_sow_id_c."' ";
          } else {
          $tablefields[$tblcnt][9][4] = " account_id_c='".$ci_account_id_c."' ";
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
    $tablefields[$tblcnt][21] = $description; //$field_value;   
//    $tablefields[$tblcnt][42] = '1'; //no label   


    if ($action == 'add' || $action == 'edit '){

       # Adding SLA's based on the pricing - which ones relate to the base product

       ######################################
       # Show All Related SLAs

       $sla_object_type = 'AccountsServicesSLAs';
       $sla_action = "select";
       if ($sclm_accountsservices_id_c != NULL){
          $sla_params[0] = " deleted=0 && sclm_accountsservices_id_c ='".$sclm_accountsservices_id_c."' ";    
          } elseif ($sclm_servicessla_id_c != NULL) {
          $sla_params[0] = " deleted=0 && sclm_servicessla_id_c='".$sclm_servicessla_id_c."' && ".$global_query;
          } elseif ($sclm_services_id_c != NULL) {
          $sla_params[0] = " deleted=0 && sclm_services_id_c='".$sclm_services_id_c."' && ".$global_query;
          }

       $sla_params[1] = "id,name,sclm_services_id_c"; // select array
       $sla_params[2] = ""; // group;
       $sla_params[3] = ""; // order;
       $sla_params[4] = ""; // limit
  
       $sla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sla_object_type, $sla_action, $sla_params);

       if (is_array($sla_items)){

          for ($cnt=0;$cnt < count($sla_items);$cnt++){

              $accountsservicesslas_id = $sla_items[$cnt]['id'];
              $accountsservicesslas_name = $sla_items[$cnt]['name'];
              $sclm_services_id_c = $sla_items[$cnt]['sclm_services_id_c'];

              if (!in_array($sclm_services_id_c,$services)){
                 $services[] = $sclm_services_id_c;
                 }

              # Must check if exists based on the PRICING - that is the end SLA point..
              # Only if editing will SLA Requests show up - otherwise else

              $slareq_object_type = 'ServiceSLARequests';
              $slareq_action = "select";
              $slareq_params[0] = " sclm_accountsservicesslas_id_c ='".$accountsservicesslas_id."' && account_id_c='".$account_id_c."' ";
              $slareq_params[1] = "id,name,sclm_servicesprices_id_c,cmn_statuses_id_c"; // select array
              $slareq_params[2] = ""; // group;
              $slareq_params[3] = ""; // order;
              $slareq_params[4] = ""; // limit
     
              $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);
   
              if (is_array($slareq_items)){

                 for ($svcslareqcnt=0;$svcslareqcnt < count($slareq_items);$svcslareqcnt++){

                     $slareq_id = $slareq_items[$svcslareqcnt]['id'];
                     $slareq_name = $slareq_items[$svcslareqcnt]['name'];
                     $slareq_servicesprices_id_c = $slareq_items[$svcslareqcnt]['sclm_servicesprices_id_c'];
                     $slareq_cmn_statuses_id_c = $slareq_items[$svcslareqcnt]['cmn_statuses_id_c'];

                     if ($slareq_servicesprices_id_c != NULL){

                        $remove_price_query .= " && id != '".$slareq_servicesprices_id_c."' ";

                        $servicesla_prices_returner = $funky_gear->object_returner ('ServicesPrices', $slareq_servicesprices_id_c);
                        $servicesla_prices_name = $servicesla_prices_returner[3];

                        $tblcnt++;

                        $tablefields[$tblcnt][0] = "slareq_".$slareq_id;
                        $tablefields[$tblcnt][1] = "Existing SLA (Price Set): ".$servicesla_prices_name; // Full Name
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
                        $tablefields[$tblcnt][20] = "slareq_".$slareq_id;

                        if ($slareq_cmn_statuses_id_c != $standard_statuses_closed){
                           $tablefields[$tblcnt][21] = "1"; //$field_value;
                           } else {
                           $tablefields[$tblcnt][21] = "0"; //$field_value;
                           } // end if selection found

                        } else {

                        $tblcnt++;

                        if ($sess_contact_id != NULL && $sess_account_id==$ci_account_id_c && $auth>1){
                           $slareq_name = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=edit&value=".$slareq_id."&valuetype=');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=edit&value=".$slareq_id."&valuetype=');return false\">".$slareq_name."</a>";
                           }

                        #$slareq_name = 

                        $tablefields[$tblcnt][0] = "slareq_".$slareq_id;
                        $tablefields[$tblcnt][1] = "Existing SLA (No Price): ".$slareq_name; // Full Name
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
                        $tablefields[$tblcnt][20] = "slareq_".$slareq_id;

                        if ($slareq_cmn_statuses_id_c != $standard_statuses_closed){
                           $tablefields[$tblcnt][21] = "1"; //$field_value;
                           } else {
                           $tablefields[$tblcnt][21] = "0"; //$field_value;
                           } // end if selection found

                        } # else no price

                     $tablefields[$tblcnt][41] = 1; // flipfields - label/fieldvalue

                     } // end for

                 } else { // not in array yet


                 } # is array

              } // end for

          foreach ($services as $serv_key=>$serv_val){

                  # No SLA Requests - good to provide for add new 
                  $slareq_object_type = 'ServicesPrices';
                  $slareq_action = "select";
                  $slareq_params[0] = " sclm_services_id_c ='".$serv_val."' ".$remove_price_query;
                  $slareq_params[1] = "id,name,account_id_c,cmn_currencies_id_c,credits"; // select array
                  $slareq_params[2] = ""; // group;
                  $slareq_params[3] = ""; // order;
                  $slareq_params[4] = ""; // limit
     
                  $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);
   
                  if (is_array($slareq_items)){

                     for ($svcslareqcnt=0;$svcslareqcnt < count($slareq_items);$svcslareqcnt++){

                         $servicesla_servicesprices_id_c = $slareq_items[$svcslareqcnt]['id'];
                         $servicesla_prices_name = $slareq_items[$svcslareqcnt]['name'];
                         $slaprice_account_id_c = $slareq_items[$svcslareqcnt]['account_id_c'];
                         $slaprice_currencies_id_c = $slareq_items[$svcslareqcnt]['cmn_currencies_id_c'];
                         $slaprice_credits = $slareq_items[$svcslareqcnt]['credits'];

                         $credit_params[0] = $credits;
                         $credit_params[1] = $cmn_currencies_id_c;
                         $credits_pack = $funky_gear->creditisor ($credit_params);

                         $credit_value = $credits_pack[0];
                         $provider_share = $credits_pack[1];
                         $partner_share = $credits_pack[2];
                         $currency_name = $credits_pack[3];
                         $iso_code = $credits_pack[4];
                         $currency_country = $credits_pack[5];

                         switch ($portal_type){

                          case 'system':

                           $show_value = "<BR>".$strings["AccountTypeCustomer"].": ".number_format($credit_value)."<BR>".$strings["AccountTypeProviderPartner"].": ".number_format($provider_share)."<BR>".$strings["AccountTypeResellerPartner"].": ".number_format($partner_share);

                          break;
                          case 'provider':

                           $show_value = "<BR>".$strings["AccountTypeCustomer"].": ".number_format($credit_value)."<BR>".$strings["AccountTypeProviderPartner"].": ".number_format($provider_share)."<BR>".$strings["AccountTypeResellerPartner"].": ".number_format($partner_share);

                          break;
                          case 'reseller':

                           $show_value = "<BR>".$strings["AccountTypeCustomer"].": ".number_format($credit_value)."<BR>".$strings["AccountTypeResellerPartner"].": ".number_format($partner_share);

                          break;
                          case 'client':

                           $show_value = "<BR>".$strings["AccountTypeCustomer"].": ".number_format($credit_value);

                          break;

                         }

                         $account_namer = $funky_gear->object_returner ('Accounts', $slaprice_account_id_c);
                         $account_name = "<B>Provider: ".$account_namer[0]."</B><BR>";

                         $tblcnt++;

                         $tablefields[$tblcnt][0] = "sclm_servicesprices_id_c_".$servicesla_servicesprices_id_c; // Field Name
                         $tablefields[$tblcnt][1] = "Add: ".$account_name.$servicesla_prices_name.$show_value; // Full Name
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
                         $tablefields[$tblcnt][20] = "sclm_servicesprices_id_c_".$servicesla_servicesprices_id_c; //$field_value_id;

                         if ($sclm_servicesprices_id_c != NULL && $servicesla_servicesprices_id_c==$sclm_servicesprices_id_c){
                            $tablefields[$tblcnt][21] = "1"; //$field_value;
                            } else {
                            $tablefields[$tblcnt][21] = "0"; //$field_value;
                            } // end if selection found
 
                         $tablefields[$tblcnt][41] = 1; // flipfields - label/fieldvalue

                         } # for

                     } else { # is array slareq_items

                     $tblcnt++;

                     $tablefields[$tblcnt][0] = "requestpricing"; // Field Name
                     $tablefields[$tblcnt][1] = "Request Pricing from Providers"; // Full Name
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
                     $tablefields[$tblcnt][20] = "requestpricing"; //$field_value_id;
                     $tablefields[$tblcnt][21] = "1"; //$field_value; 
                     $tablefields[$tblcnt][41] = 1; // flipfields - label/fieldvalue

                     } # end if no pricing set

                  } # foreach service

          } // end if is array

       } // if add

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "0"; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = .98; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["ServiceSLARequest"]; // container_title
    $container_params[4] = 'SelectServiceSLA'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    if ($sclm_services_id_c != NULL){
       $service_returner = $funky_gear->object_returner ('Services', $sclm_services_id_c);
       $service_linkblock = $service_returner[1];
       echo $service_linkblock;
       }

    if ($sclm_accountsservices_id_c != NULL){
       $accservice_returner = $funky_gear->object_returner ('AccountsServices', $sclm_accountsservices_id_c);
       $accservice_linkblock = $accservice_returner[1];
       echo $accservice_linkblock;
       }

    if ($sclm_accountsservicesslas_id_c != NULL){
       $accservicesla_returner = $funky_gear->object_returner ('AccountsServicesSLAs', $sclm_accountsservicesslas_id_c);
       $accservicesla_linkblock = $accservicesla_returner[1];
       echo $accservicesla_linkblock;
       }

    echo "<div style=\"".$divstyle_white."\">".$strings["ServiceSLARequestMessage"]."</div>";
    echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

    echo $container_top;

    echo $zaform;

    echo $container_bottom;

    #
    ###################
    #

    if ($action == 'view'){

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

       #
       ###################
       #

       $this->funkydone ($_POST,$lingo,'Ticketing','list',$val,$do,$bodywidth);

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["ConfigurationItems"]; // container_title
       $container_params[4] = 'ConfigurationItems'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'ConfigurationItems','list',$val,$do,$bodywidth);

       echo $container_bottom;

       #
       ###################
       #

       }

   break; // end view
   case 'process':

    /*
    foreach ($_POST as $posted_key=>$posted_value){
            echo "key: ".$posted_key." and val:".$posted_value."<BR>";
            }
    */
    $error = "";

    if (!$_POST['sclm_services_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]." Base Service</font><P>";
       }   

    if (!$_POST['sclm_accountsservices_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]." Catalog Service</font><P>";
       }

    if (!$_POST['sclm_servicessla_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]." Base Service SLA</font><P>";
       }   

    if (!$_POST['sclm_accountsservicesslas_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]." Account Service's SLA</font><P>";
       }   

    # Edit

    if ($_POST['id'] != NULL && $error == NULL){

       $process_object_type = $do;
       $process_action = "update";
       $process_params = array();  

       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_servicessla_id_c','value' => $_POST['sclm_servicessla_id_c']);
       $process_params[] = array('name'=>'start_date','value' => $_POST['start_date']);
       $process_params[] = array('name'=>'end_date','value' => $_POST['end_date']);
       $process_params[] = array('name'=>'sclm_accountsservices_id_c','value' => $_POST['sclm_accountsservices_id_c']);
       $process_params[] = array('name'=>'sclm_accountsservicesslas_id_c','value' => $_POST['sclm_accountsservicesslas_id_c']);
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
       $process_params[] = array('name'=>'provider_price','value' => $_POST['provider_price']);
       $process_params[] = array('name'=>'reseller_price','value' => $_POST['reseller_price']);
       $process_params[] = array('name'=>'customer_price','value' => $_POST['customer_price']);
       $process_params[] = array('name'=>'sclm_servicesprices_id_c','value' => $_POST['sclm_servicesprices_id_c']);

       $serviceslarequest_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($serviceslarequest_result['id'] != NULL){

          $val = $serviceslarequest_result['id'];

          $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";

          $process_message = $strings["SubmissionSuccess"]."<BR>".$edit."<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";
          echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";

          } # if result

       } elseif ($_POST['id'] == NULL && $error == NULL) {# end if edit

       # Collect any other SLA Reqs desired
       # Should not check for any accountsservicesslas or prices that are already managed by this SLA Reqs
       # sclm_accountsservicesslas_id_c && sclm_servicesprices_id_c

       foreach ($_POST as $posted_key=>$posted_value){

               # After stripping, if ID sent, should not be the same as the posted key
               # "sclm_servicesprices_id_c_".$slareq_servicesprices_id_c."_slaexistprice_"$slareq_id;
               #list($acc_serv_sla_key,$slareq_id) = explode("_slaexistnoprice_", $posted_key);
               #echo "key: ".$posted_key." and val:".$posted_value."<BR>";

               $slareq_id = str_replace("slareq_","",$posted_key);
               $new_servicesprices_id_c = str_replace("sclm_servicesprices_id_c_","",$posted_key);

               #echo "slareq_id: ".$slareq_id." or new_servicesprices_id_c:".$new_servicesprices_id_c."<BR>";   

               if ($slareq_id != NULL && $slareq_id != $posted_key){

                  # The SLA Request exists - could even be same as above one - just update status if changed
                  # Need to update with the value

                  #echo "<B>slareq_id: ".$slareq_id."</B><BR>";   

                  if ($posted_value == 1){
                     $posted_statuses_id_c = $standard_statuses_open_public;
                     } else {
                     $posted_statuses_id_c = $standard_statuses_closed;
                     }

                  # No price available
                  $process_params = array();
                  $process_params[] = array('name'=>'id','value' => $slareq_id);
                  $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $posted_statuses_id_c);

                  $serviceslarequest_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                  # end existing sla req with potential updated status

                  } elseif ($new_servicesprices_id_c != NULL && $new_servicesprices_id_c != $posted_key && $posted_value == 1) {

                  #echo "<B>new_servicesprices_id_c:".$new_servicesprices_id_c."</B><BR>";   

                  $posted_statuses_id_c = $standard_statuses_open_public;

                  # newly added sla req from pricing selection IF selected $posted_value == 1
                  # Create name based on acc name
                  $account_id_c = $_POST['account_id_c'];
                  $account_returner = $funky_gear->object_returner ('Accounts', $account_id_c);
                  $account_name = $account_returner[0];

                  # Get pricing info for naming
                  $price_returner = $funky_gear->object_returner ('ServicesPrices', $new_servicesprices_id_c);
                  $slareq_name = $account_name." -> ".$price_returner[0];

                  $process_object_type = $do;
                  $process_action = "update";
                  $process_params = array();  

                  $process_params[] = array('name'=>'name','value' => $slareq_name);
                  $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $posted_statuses_id_c);
                  $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                  $process_params[] = array('name'=>'description','value' => $slareq_name);
                  $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
                  $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                  $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                  $process_params[] = array('name'=>'sclm_servicessla_id_c','value' => $_POST['sclm_servicessla_id_c']);
                  $process_params[] = array('name'=>'start_date','value' => $_POST['start_date']);
                  $process_params[] = array('name'=>'end_date','value' => $_POST['end_date']);
                  $process_params[] = array('name'=>'sclm_accountsservices_id_c','value' => $_POST['sclm_accountsservices_id_c']);
                  $process_params[] = array('name'=>'sclm_accountsservicesslas_id_c','value' => $_POST['sclm_accountsservicesslas_id_c']);
                  $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
                  $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
                  $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
                  $process_params[] = array('name'=>'provider_price','value' => $_POST['provider_price']);
                  $process_params[] = array('name'=>'reseller_price','value' => $_POST['reseller_price']);
                  $process_params[] = array('name'=>'customer_price','value' => $_POST['customer_price']);
                  $process_params[] = array('name'=>'sclm_servicesprices_id_c','value' => $new_servicesprices_id_c);

                  $serviceslarequest_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                  if ($serviceslarequest_result['id'] != NULL){

                     $val = $serviceslarequest_result['id'];

                     $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";

                     $process_message .= $strings["SubmissionSuccess"]."<BR>".$edit."<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

                     } // if processed OK

                  } // if new_servicesprices_id_c sent

               } // end foreach post

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";

       } elseif ($error != NULL) {# if not post id and others

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       } # end error

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>
