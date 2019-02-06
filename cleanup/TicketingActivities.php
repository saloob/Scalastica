<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-05-26
# Page: TicketingActivities.php 
##########################################################
# case 'TicketingActivities':

  $this_module = '3ac28d96-bebc-9385-7b79-530a144e8e8b';
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


     switch ($hostname){

      case 'sdaas-ams.kvhasia.com':

       #$parent_account_id = "2c769bfc-584b-59a3-f41f-51b2b64d02b3";

      break;
      case 'hp.scalastica.com':

       #$parent_account_id = "81d48510-cd53-b831-baf6-51d779c1ff9d";

      break;

     } // switch

 if ($action != 'list' || $action != 'quicklist'){

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

if (!$_SESSION['contact_id']){
   echo "<P><a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=logout&value=&valuetype=');return false\"><B>Your Session has ended - please log in again..</B></a>";
   exit;
   }

$lingoname = "name_".$lingo;

switch ($auth){

 case 1:
  $ticket_params[0] = " deleted=0 && account_id_c = '".$account_id_c."' ";
 break;
 case 2:
  $ticket_params[0] = " deleted=0 && account_id_c = '".$account_id_c."' ";
 break;
 case 3:
  $ticket_params[0] = " deleted=0 ";
 break;

} // end switch
 
if ($action == 'search'){
   $keyword = $val;
   $vallength = strlen($keyword);
   $trimval = substr($keyword, 0, -1);
   $ticket_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";
   }

   switch ($valtype){

    case 'Ticketing':
     $ticket_params[0] .= " && sclm_ticketing_id_c='".$val."' ";
     $sclm_ticketing_id_c = $val;
    break;
    case 'TicketingActivities':

     $ticket_object_type = $do;
     $ticket_action = "select";
     $ticket_params[0] = "id='".$val."' "; // select array
     $ticket_params[1] = "id,sclm_ticketing_id_c"; // select array
     $ticket_params[2] = ""; // group;
     #$ticket_params[3] = " service_operation_process, name, date_entered DESC "; // order;
     $ticket_params[3] = " date_entered DESC, name ASC "; // order;
     $ticket_params[4] = ""; // limit
     $ticket_params[5] = $lingoname; // lingo
  
     $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

     if (is_array($ticket_items)){

        for ($cnt=0;$cnt < count($ticket_items);$cnt++){
            $sclm_ticketing_id_c = $ticket_items[$cnt]["sclm_ticketing_id_c"];
            }
        }

     $ticket_params[0] .= " && sclm_ticketing_id_c='".$sclm_ticketing_id_c."' ";

    break;

    }

  if ($action == 'quicklist'){
     $sendiv = 'light';
     $BodyDIV = $sendiv;
     $action_addnew = 'quick_add';
     } else {
     $action_addnew = 'add';
     } 

  switch ($action){

   case 'quicklist':
   case 'list':
   case 'search':
   
    ################################
    # List

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["TicketingActivities"]."</B></font></center></div>";
    #echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    #echo "<center><img src=images/icons/SupportTicket.jpg width=60></center>";
    #echo "<div style=\"".$divstyle_orange."\">".$strings["SLATicketingMessage"]."</div>";

    // Service Operation Configuration Item: 959c09e9-c980-458c-9b1d-5258a462b8da
    $ticket_object_type = $do;
    $ticket_action = "select";
    $ticket_params[1] = ""; // select array
    $ticket_params[2] = ""; // group;
//    $ticket_params[3] = " service_operation_process, name, date_entered DESC "; // order;
    $ticket_params[3] = " date_entered DESC, name ASC "; // order;
    $ticket_params[4] = "300"; // limit
    $ticket_params[5] = $lingoname; // lingo
  
    $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

    if (is_array($ticket_items)){

       $count = count($ticket_items);
       $page = $_POST['page'];
       $glb_perpage_items = 50;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       if ($action != 'quicklist'){

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
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php

          } // end if not quicklist

       echo $navi;

       $ticket_params[4] = " $lfrom , $glb_perpage_items "; 

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
           $accumulated_minutes = $ticket_items[$cnt]['accumulated_minutes']; 
           $status = $ticket_items[$cnt]['status']; 
           $status_image = $ticket_items[$cnt]['status_image']; 
           $sclm_ticketing_id_c = $ticket_items[$cnt]['sclm_ticketing_id_c'];
           $filter_id = $ticket_items[$cnt]['filter_id'];
           $ticket_update = $ticket_items[$cnt]['ticket_update'];

           // Check Admin for Edit
           if (($sess_account_id == $ci_account_id_c && $sess_account_id != NULL) || $auth==3){
     
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
     
              } else {// end if admin
              $edit = "";
              }
 
           $lingoname = "name_".$lingo;

           if ($ticket_items[$cnt][$lingoname] != NULL){
              $name = $ticket_items[$cnt][$lingoname];
              }

           $sendmessage = "";

           if ($ci_contact_id1_c){
              $agent_returner = $funky_gear->object_returner ("Contacts", $ci_contact_id1_c);
              $agent_name = $agent_returner[0];
              $sendmessage = " <a href=\"#Top\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$ci_contact_id1_c."&valuetype=Contacts&sendiv=light&related=Ticketing&relval=".$id."');document.getElementById('fade').style.display='block';loader('contactdiv');doRPOSTRequest('contactdiv','Body.php','pc=".$portalcode."&do=Contacts&action=view&value=".$ci_contact_id1_c."&valuetype=Contacts');return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'>".$agent_name."</a> ";
              }


           switch ($status){

            case 'bbed903c-c79a-00a6-00fe-52802db36ba9': //closed
            break;
            case '320138e7-3fe4-727e-8bac-52802c62a4b6': //In-progress
            break;
            case 'b0f00652-47aa-5a8e-74fb-52802e7fc3ec': //In-progress - SLA Warning
            break;
            case 'e47fc565-c045-fef9-ef4f-52802bfc479c': //Open - Unclaimed
            break;
            case 'e3307ebb-6255-505c-99b2-52802c68ec75': //Pending
            break;
            case '4e5ce2e0-8a86-8473-df52-52802cb14285': //Problem-Frozen
            break;
            case 'ed0606e3-b8fe-1ff3-253d-52802daea6af': //Revisit
            break;

           } // end status switch

           $status_image = "<img src=".$status_image." width=16>";

           // Check SLA for icon colouring by date created

           $tickets .= "<div style=\"".$divstyle_white."\"><div style=\"width:50%;float:left;padding-top:20;\">".$ticket_update."</div><div style=\"width:48%;float:left;\">".$status_image." <B>[".$date_entered."]</B> ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a> ".$sendmessage."</div></div>";

           } // end foreach

       } // if array    

    if ($sess_contact_id != NULL){
     
       if ($action == 'quicklist'){
          $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');document.getElementById('light').style.display='block';doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action_addnew."&value=".$val."&valuetype=".$valtype."');document.getElementById('fade').style.display='block';loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','Body.php','pc=".$portalcode."&do=".$do."&action=reference&value=".$sclm_ticketing_id_c."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
          } else {     
          $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action_addnew."&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
          }

       } else {
      
       $addnew = "<div style=\"".$divstyle_white."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }
     
    if (count($ticket_items)>10){
       echo $addnew."<P>".$tickets."<P>".$addnew;
       } else {
       echo $addnew."<P>".$tickets;
       }
   
    echo $navi;

   break; // end list
   # End List Tickets
   ################################
   # Quick Add
   case 'quick_add':

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ci_object_type = 'Ticketing';
    $ci_action = "select";
    $ci_params[0] = " id= '".$val."' ";
    $ci_params[1] = "account_id_c,contact_id_c,account_id1_c,contact_id1_c,cmn_statuses_id_c,filter_id"; // select array
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
           $created_by = $ci_items[$cnt]['created_by'];
           $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $ci_account_id1_c = $ci_items[$cnt]['account_id1_c'];
           $ci_contact_id1_c = $ci_items[$cnt]['contact_id1_c'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           #$sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
           $filter_id = $ci_items[$cnt]['filter_id'];

           /*
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
           $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $start_date = $ci_items[$cnt]['start_date'];
           $end_date = $ci_items[$cnt]['end_date'];
           $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
           $sclm_accountsservicesslas_id_c = $ci_items[$cnt]['sclm_accountsservicesslas_id_c'];
           $project_id_c = $ci_items[$cnt]['project_id_c'];
           $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
           $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
           $ticket_accumulated_minutes = $ci_items[$cnt]['accumulated_minutes']; 
           $extra_addressees = $ci_items[$cnt]['extra_addressees'];
           $extra_cc_addressees = $ci_items[$cnt]['extra_cc_addressees'];
           $extra_bcc_addressees = $ci_items[$cnt]['extra_bcc_addressees'];
           $to_addressees = $ci_items[$cnt]['to_addressees'];
           $cc_addressees = $ci_items[$cnt]['cc_addressees'];
           $bcc_addressees = $ci_items[$cnt]['bcc_addressees'];

           $sclm_emails_id_c = $ci_items[$cnt]['sclm_emails_id_c']; 
           */

           } // end for

       #$field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);
         
       } // if is array

  #$status_image = "<img src=".$status_image." width=16>";

  if (!$ci_account_id_c){
     $ci_account_id_c = $portal_account_id;
     }

  if (!$ci_contact_id_c){
     $ci_contact_id_c = $portal_admin;
     }

  if (!$ci_account_id1_c){
     $ci_account_id1_c = $sess_account_id;
     }
  if (!$ci_contact_id1_c){
     $ci_contact_id1_c = $sess_contact_id;
     }

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
    $tablefields[$tblcnt][21] = ""; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
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
    $tablefields[$tblcnt][11] = $standard_statuses_closed; // Field ID
    $tablefields[$tblcnt][20] = "cmn_statuses_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $standard_statuses_closed; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_ticketing_id_c"; // Field Name
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
    $tablefields[$tblcnt][20] = "sclm_ticketing_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;

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

    $tablefields[$tblcnt][0] = 'status'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]." ".$status_image; // Full Name
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
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='d918bc49-f7df-8b75-1e4d-52802a2db21c' && sclm_configurationitems_id_c != '72b33850-b4b0-c679-f988-52c2eb40a5de' "; //ticket status
    $tablefields[$tblcnt][9][5] = $status; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'status';//$field_value_id;
    $tablefields[$tblcnt][21] = $status; //$field_value;

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

    $tablefields[$tblcnt][0] = "ticket_update"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Updates"]; // Full Name
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
    $tablefields[$tblcnt][20] = "ticket_update"; //$field_value_id;
    $tablefields[$tblcnt][21] = $ticket_update; //$field_value;   
    $tablefields[$tblcnt][50] = "";

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
    $tablefields[$tblcnt][12] = '65'; //length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   
    $tablefields[$tblcnt][50] = "";

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
    $valpack[5] = ""; 
    $valpack[6] = "quick_process"; 
    $valpack[7] = $strings["Create"];

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    echo $zaform;

   break;
   # End Quick Add
   ################################
   # Quick Process
   case 'quick_process':

    $process_object_type = $do;
    $process_action = "update";

    $process_params[] = array('name'=>'id','value' => $_POST['id']);
    $process_params[] = array('name'=>'name','value' => $_POST['name']);

    if (!$_POST['id']){
       $nowdate = date("Y-m-d H:i:s");
       $process_params[] = array('name'=>'date_entered','value' => $nowdate);
       }

    $process_params[] = array('name'=>'name','value' => $_POST['name']);
    $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
    $process_params[] = array('name'=>'description','value' => $_POST['description']);
    #$process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
    $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
    $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
    $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $_POST['sclm_ticketing_id_c']);
    $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
    $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
    #$process_params[] = array('name'=>'accumulated_minutes','value' => $_POST['accumulated_minutes']);
    $process_params[] = array('name'=>'status','value' => $_POST['status']);
    #$process_params[] = array('name'=>'filter_id','value' => $_POST['filter_id']);
    #$process_params[] = array('name'=>'to_addressees','value' => $_POST['to_addressees']);
    #$process_params[] = array('name'=>'cc_addressees','value' => $_POST['cc_addressees']);
    #$process_params[] = array('name'=>'bcc_addressees','value' => $_POST['bcc_addressees']);
    #$process_params[] = array('name'=>'extra_addressees','value' => $_POST['extra_addressees']);
    #$process_params[] = array('name'=>'extra_cc_addressees','value' => $_POST['extra_cc_addressees']);
    #$process_params[] = array('name'=>'extra_bcc_addressees','value' => $_POST['extra_bcc_addressees']);
    $process_params[] = array('name'=>'ticket_update','value' => $_POST['ticket_update']);

    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

    if ($result['id'] != NULL){
       $val = $result['id'];
       }

    echo "<center><a href=\"#\" onClick=\"cleardiv('light');cleardiv('fade');document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $process_message = "<P>".$strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";


   break;
   # End Quick Process
   ################################
   # Start View Tickets
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'edit' || $action == 'view'){

       // Service Operation Configuration Item: 959c09e9-c980-458c-9b1d-5258a462b8da
       $ticket_object_type = $do;
       $ticket_action = "select";
       $ticket_params[0] = "id='".$val."' ";
       $ticket_params[1] = ""; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = " name, date_entered DESC "; // order;
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
              $ci_contact_id_c = $ticket_items[$cnt]['contact_id_c'];
              $ci_account_id1_c = $ticket_items[$cnt]['account_id1_c'];
              $ci_contact_id1_c = $ticket_items[$cnt]['contact_id1_c'];
              $accumulated_minutes = $ticket_items[$cnt]['accumulated_minutes']; 
              $sclm_ticketing_id_c = $ticket_items[$cnt]['sclm_ticketing_id_c'];
              $status = $ticket_items[$cnt]['status'];
              $status_image = $ticket_items[$cnt]['status_image']; 
              $extra_addressees = $ticket_items[$cnt]['extra_addressees'];
              $extra_cc_addressees = $ticket_items[$cnt]['extra_cc_addressees'];
              $extra_bcc_addressees = $ticket_items[$cnt]['extra_bcc_addressees'];

              $filter_id = $ticket_items[$cnt]['filter_id'];

              $to_addressees = $ticket_items[$cnt]['to_addressees'];
              $cc_addressees = $ticket_items[$cnt]['cc_addressees'];
              $bcc_addressees = $ticket_items[$cnt]['bcc_addressees'];

              $ticket_update = $ticket_items[$cnt]['ticket_update'];

              }  // end for

          $field_lingo_pack = $funky_gear->lingo_data_pack ($ticket_items, $name, $description, $name_field_base,$desc_field_base);

          }  // is array

       }  // if edit
 
    if ($action == 'add'){

//       $sclm_ticketing_id_c = $_POST['sclm_ticketing_id_c'];

       if ($sclm_ticketing_id_c){

          $ci_object_type = 'Ticketing';
          $ci_action = "select";
          $ci_params[0] = " id= '".$sclm_ticketing_id_c."' ";
          $ci_params[1] = ""; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = " name, date_entered DESC "; // order;
          $ci_params[4] = ""; // limit
          $ci_params[5] = $lingoname;
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){

             for ($cnt=0;$cnt < count($ci_items);$cnt++){

                 //$id = $ci_items[$cnt]['id'];
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
                 $ci_account_id1_c = $ci_items[$cnt]['account_id1_c'];
                 $ci_contact_id1_c = $ci_items[$cnt]['contact_id1_c'];
                 $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
                 $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
                 $start_date = $ci_items[$cnt]['start_date'];
                 $end_date = $ci_items[$cnt]['end_date'];
                 $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
                 $sclm_accountsservicesslas_id_c = $ci_items[$cnt]['sclm_accountsservicesslas_id_c'];
                 $project_id_c = $ci_items[$cnt]['project_id_c'];
                 $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
                 $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
                 $ticket_accumulated_minutes = $ci_items[$cnt]['accumulated_minutes']; 

                 $extra_addressees = $ci_items[$cnt]['extra_addressees'];
                 $extra_cc_addressees = $ci_items[$cnt]['extra_addressees_cc']; // fields are different!
                 $extra_bcc_addressees = $ci_items[$cnt]['extra_addressees_bcc']; // fields are different!

                 $filter_id = $ci_items[$cnt]['filter_id'];

                 $to_addressees = $ci_items[$cnt]['to_addressees'];
                 $cc_addressees = $ci_items[$cnt]['cc_addressees'];
                 $bcc_addressees = $ci_items[$cnt]['bcc_addressees'];

                 $sclm_emails_id_c = $ci_items[$cnt]['sclm_emails_id_c']; 

                 } // end for

             $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);
          
             } // if is array

          } // if sclm_ticketing_id_c

       } // if add

  if ($status_image){
     $status_image = "<img src=".$status_image." width=16>";
     }

  if (!$ci_account_id_c){
     $ci_account_id_c = $portal_account_id;
     }

  if (!$ci_contact_id_c){
     $ci_contact_id_c = $portal_admin;
     }

  if (!$ci_account_id1_c){
     $ci_account_id1_c = $sess_account_id;
     }
  if (!$ci_contact_id1_c){
     $ci_contact_id1_c = $sess_contact_id;
     }

  if ($sclm_ticketing_id_c != NULL){
     $object_returner = $funky_gear->object_returner ('Ticketing', $sclm_ticketing_id_c);
     echo $object_returner[1];
     }

  if ($project_id_c != NULL){
     $object_returner = $funky_gear->object_returner ('Projects', $project_id_c);
     echo $object_returner[1];
     }

  if ($projecttask_id_c != NULL){
     $object_returner = $funky_gear->object_returner ('ProjectTasks', $projecttask_id_c);
     echo $object_returner[1];
     }

  if ($sclm_sowitems_id_c != NULL){
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

    $nowdate = date("Y-m-d H:i:s");
    $difference = $funky_gear->timeDiff($date_entered,$nowdate);
    $years = abs(floor($difference / 31536000));
    $days = abs(floor(($difference-($years * 31536000))/86400));
    $hours = abs(floor(($difference-($years * 31536000)-($days * 86400))/3600));
    $mins = abs(floor(($difference-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($difference / 60);
    $accumulated_minutes = floor(($difference)/60); 

    $name = "Re: ".$name;

    # Activities
    if ($action == 'add'){

       $ticketact_object_type = $do;
       $ticketact_action = "select";
       $ticketact_params[0] = "sclm_ticketing_id_c='".$sclm_ticketing_id_c."' ";
       $ticketact_params[1] = "id,description,ticket_update"; // select array
       $ticketact_params[2] = ""; // group;
       $ticketact_params[3] = " date_entered DESC "; // order;
       $ticketact_params[4] = "1"; // limit
       $ticketact_params[5] = $lingoname; // lingo
  
       $ticketing_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticketact_object_type, $ticketact_action, $ticketact_params);

       if (is_array($ticketing_items)){
  
          for ($cnt=0;$cnt < count($ticketing_items);$cnt++){

              $id = $ticketing_items[$cnt]["id"];
              $previous_description = $ticketing_items[$cnt]["description"];

              if ($previous_description != NULL){
                 #$previous_descriptions .= "<div style=\"".$divstyle_white."\">".$previous_description."</div>";
                 }

              } // for

          } // if array

       } // if action


    if ($action == 'add' || $action == 'edit'){
       $ticket_update = $nowdate." - ";
       }

    # Get latest content and make it as though replied
    if ($previous_description != NULL){
       $description = $previous_description;
       }

    if ($description != NULL && $action == 'edit'){

       $bodyarr = explode("\n", $description);

       foreach ($bodyarr as $bodykey => $bodyvalue) {

               $bodyarr[$bodykey] = '> ' . $bodyarr[$bodykey];

               }

               $description = implode("\n", $bodyarr);

        } // if descr


    if (!$filter_id){

       # Have to find a filter rule that provide default activity info
       $checkfilter_object_type = "ConfigurationItems";
       $checkfilter_action = "select";
       $checkfilter_params[0] = " name='DefaultActivityFilter' && account_id_c='".$ci_account_id_c."' ";
       $checkfilter_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname";
       $checkfilter_params[2] = ""; // group;
       $checkfilter_params[3] = ""; // order;
       $checkfilter_params[4] = ""; // limit

       $checkfilters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $checkfilter_object_type, $checkfilter_action, $checkfilter_params);

       if (is_array($checkfilters)){

          # Default exists for this account = NEW Filterbits for sending

          for ($chkfltrcnt=0;$chkfltrcnt < count($checkfilters);$chkfltrcnt++){
 
              $filter_id = $checkfilters[$chkfltrcnt]['id'];

              } // for

          } // if array checkfilters

       } // if filter_id

    if ($filter_id != NULL){

       if ($action == 'add' || $action == 'edit'){
          # Use Filter to collect components
          $filterbit_object_type = "ConfigurationItems";
          $filterbit_action = "select";
          $filterbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && enabled=1 ";
          $filterbit_params[1] = "";
          $filterbit_params[2] = ""; // group;
          $filterbit_params[3] = ""; // order;
          $filterbit_params[4] = ""; // limit
          $replyfilterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

          # Get template
          if (is_array($replyfilterbits)){

             for ($cntfb=0;$cntfb < count($replyfilterbits);$cntfb++){

                 $filterbit_id = $replyfilterbits[$cntfb]['id'];
                 $filterbit_configurationitemtypes_id_c = $replyfilterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

                 if ($filterbit_configurationitemtypes_id_c == 'c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d'){

                    $templ_id = $replyfilterbits[$cntfb]['name']; // actual template ID
                    $templ_filter_object_type = "ConfigurationItems";
                    $templ_filter_action = "select";
                    $templ_filter_params[0] = " id='".$templ_id."' ";
                    $templ_filter_params[1] = "id,name,description"; // select array
                    $templ_filter_params[2] = ""; // group;
                    $templ_filter_params[3] = ""; // order;
                    $templ_filter_params[4] = ""; // limit
  
                    $templ_filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $templ_filter_object_type, $templ_filter_action, $templ_filter_params);

                    if (is_array($templ_filters)){

                       for ($cnttmplfltr=0;$cnttmplfltr < count($templ_filters);$cnttmplfltr++){

                           #$templ_name = $templ_filters[$cnttmplfltr]['name'];
                           $email_content = $templ_filters[$cnttmplfltr]['description']; 
                           $email_content = $funky_gear->replacer("[ALERT_MESSAGE]","",$email_content);
                           $description = $email_content."\n".$description;

                           } // for templ

                       } // if templ

                    } // if filterbit_configurationitemtypes_id_c

                 } // for filterbits

              } // if array filterbits

          } // if action

       # Use Filter to collect components
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

              # $filter_configurationitemtypes_id_c = $filters[$cntfb]['sclm_configurationitemtypes_id_c'];
              $filter_description = $filters[$cntfb]['description'];
              $filter_description = str_replace("\n","<BR>",$filter_description);
              echo "<div style=\"".$divstyle_orange."\"><B>".$strings["EmailFiltering"]."</B><P>".$filter_description."</div>"; 

              } // for

          } // if array

       } // if filter_id

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

    if (($action == 'add' || $action == 'edit') && $sclm_emails_id_c != NULL){

       $subject_returner = $funky_gear->object_returner ("Emails", $sclm_emails_id_c);
       $original_subject = $subject_returner[0];

       }

    if (($action == 'add' || $action == 'edit') && $sclm_emails_id_c != NULL && $original_subject != NULL ){

       $tblcnt++;

       if ($original_subject == NULL){
          $send_original_subject = 0;
          }

       $tablefields[$tblcnt][0] = "send_original_subject"; // Field Name
       $tablefields[$tblcnt][1] = "Send with original Subject?"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $send_original_subject; // Field ID
       $tablefields[$tblcnt][12] = '50'; //length
       $tablefields[$tblcnt][20] = "send_original_subject"; //$field_value_id;
       $tablefields[$tblcnt][21] = $send_original_subject; //$field_value;

       $tblcnt++;

       $tablefields[$tblcnt][0] = "original_subject"; // Field Name
       $tablefields[$tblcnt][1] = "Original Subject"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $original_subject; // Field ID
       $tablefields[$tblcnt][12] = '70'; //length
       $tablefields[$tblcnt][20] = "original_subject"; //$field_value_id;
       $tablefields[$tblcnt][21] = $original_subject; //$field_value;   

       } // end if add/edit

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

    $tablefields[$tblcnt][0] = "assign_status_to_parent"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TicketStatusAssignToParent"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $assign_status_to_parent; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "assign_status_to_parent"; //$field_value_id;
    $tablefields[$tblcnt][21] = $assign_status_to_parent; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "assign_status_to_child_activities"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TicketStatusAssignToChildActivities"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $assign_status_to_child_activities; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "assign_status_to_child_activities"; //$field_value_id;
    $tablefields[$tblcnt][21] = $assign_status_to_child_activities; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "assign_status_to_child_tickets"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TicketStatusAssignToChildTickets"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $assign_status_to_child_tickets; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "assign_status_to_child_tickets"; //$field_value_id;
    $tablefields[$tblcnt][21] = $assign_status_to_child_tickets; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "assign_user_to_parent"; // Field Name
    $tablefields[$tblcnt][1] = $strings["TicketUserAssignToParent"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $assign_user_to_parent; // Field ID
    $tablefields[$tblcnt][12] = '50'; //length
    $tablefields[$tblcnt][20] = "assign_user_to_parent"; //$field_value_id;
    $tablefields[$tblcnt][21] = $assign_user_to_parent; //$field_value;   

    if ($action == 'add' || $action == 'edit' || $action == 'view'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'status'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]." ".$status_image; // Full Name
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
       $tablefields[$tblcnt][1] = $strings["Date"]; // Full Name
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

       $tblcnt++;

       $diff = "<p><B>".$strings["duration"].": " . $years . " ".$strings["Years"].", " . $days . " ".$strings["Days"].", " . $hours . " ".$strings["Hours"].", " . $mins . " ".$strings["Minutes"].".</B></p>";

       $tablefields[$tblcnt][0] = "accumulated_minutes"; // Field Name
       $tablefields[$tblcnt][1] = $strings["AccumulatedMinutes"].$diff; // Full Name
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
       $tablefields[$tblcnt][21] = $accumulated_minutes; //$field_value;   


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
       $tablefields[$tblcnt][21] = $accumulated_minutes; //$field_value;

       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "sclm_ticketing_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Ticket"]; // Full Name
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
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' ";
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

    if (!$cmn_languages_id_c){
       $cmn_languages_id_c=$lingo_id;
       }

    $tblcnt++;

    if (!$send_extra_addresses){
       $send_extra_addresses=0;
       }

    $tablefields[$tblcnt][0] = "send_extra_addresses"; // Field Name
    $tablefields[$tblcnt][1] = "Send Extra Addresses?"; // Full Name
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

    $tablefields[$tblcnt][0] = "extra_cc_addressees"; // Field Name
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
    $tablefields[$tblcnt][11] = $extra_cc_addressees; // Field ID
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "extra_cc_addressees"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_cc_addressees; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "extra_bcc_addressees"; // Field Name
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
    $tablefields[$tblcnt][11] = $extra_bcc_addressees; // Field ID
    $tablefields[$tblcnt][12] = '60'; //length
    $tablefields[$tblcnt][20] = "extra_bcc_addressees"; //$field_value_id;
    $tablefields[$tblcnt][21] = $extra_bcc_addressees; //$field_value;   

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
       $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='cf3271fc-f361-22c8-0212-52b998d102ac' && enabled !=0 ";
       } else {
       $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='cf3271fc-f361-22c8-0212-52b998d102ac' && enabled !=0 ";
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
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='4203105b-79b1-8330-b136-52b9985ddcf1' && enabled !=0 ";
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
    $tablefields[$tblcnt][9][4] = " account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='c2bc3b5f-bfdd-a0ef-e399-52b998a94a28' && enabled !=0 ";
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

    if ($action == 'add'){

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
       $tablefields[$tblcnt][9][4] = " id='".$portal_account_id."' "; // exception
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
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$portal_account_id."' && accounts_contacts.contact_id=contacts.id "; // exception
       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

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
    $tablefields[$tblcnt][9][5] = $ci_account_id1_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Accounts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $ci_account_id1_c; //$field_value;   

    # -> Service Provider Contact

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

    $tblcnt++;

    $tablefields[$tblcnt][0] = "ticket_update"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Updates"]; // Full Name
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
    $tablefields[$tblcnt][20] = "ticket_update"; //$field_value_id;
    $tablefields[$tblcnt][21] = $ticket_update; //$field_value;   
    $tablefields[$tblcnt][50] = "";

    if ($action == 'view'){

       $description = $funky_gear->replacer('\n', '<BR>', $description);

       }

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
    $tablefields[$tblcnt][12] = '65'; //length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   
    $tablefields[$tblcnt][50] = "";

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
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; 
    $valpack[6] = ""; 
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
    $container_params[3] = $strings["TicketingActivity"]; // container_title
    $container_params[4] = 'TicketingActivity'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    if ($action == 'view' || $action == 'edit'){
       #$returner = $funky_gear->object_returner ('Ticketing', $val);
       #$object_return = $returner[1];
       #echo $object_return;
       }

    echo $container_top;
  
    echo "<div style=\"".$divstyle_blue."\" name='TICKET' id='TICKET'><a href=\"#\" onClick=\"loader('TICKET');doBPOSTRequest('TICKET','Body.php', 'pc=".$portalcode."&do=Ticketing&action=view&value=".$sclm_ticketing_id_c."&valuetype=".$valtype."&div=TICKET');return false\"><B>".$name."</B></a></div><P>";

    #echo "<BR><center><img src=images/icons/clock.png width=50></center><BR>";
    #echo "<center><div id=\"clockDisplay\" class=\"clockStyle\"></div></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    echo $zaform;

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

       echo $container_bottom;

       }

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

   break; // end Tickets add
   case 'process':

    # Debugging purposes - remember to comments out exit when finished!
    /*
    foreach ($_POST as $key=>$value){

            #echo "Key: $key && Value: $value <BR>";

            if ($value != NULL){
               $sclm_content_id_c = str_replace("attachments_key_","",$key);
               if ($sclm_content_id_c == $value){
                  echo "A content attachment was sent for $key: $sclm_content_id_c<BR>";
                  } # if is key
               } # if value selected

            } # End foreach for attachments
    exit;
    */
    # End debugging

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

       if (!$_POST['id']){
          $nowdate = date("Y-m-d H:i:s");
          $process_params[] = array('name'=>'date_entered','value' => $nowdate);
          }

       $process_params[] = array('name'=>'name','value' => $_POST['name']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $_POST['sclm_ticketing_id_c']);
       $process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
       $process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
       $process_params[] = array('name'=>'accumulated_minutes','value' => $_POST['accumulated_minutes']);
       $process_params[] = array('name'=>'status','value' => $_POST['status']);
       $process_params[] = array('name'=>'filter_id','value' => $_POST['filter_id']);
       $process_params[] = array('name'=>'to_addressees','value' => $_POST['to_addressees']);
       $process_params[] = array('name'=>'cc_addressees','value' => $_POST['cc_addressees']);
       $process_params[] = array('name'=>'bcc_addressees','value' => $_POST['bcc_addressees']);
       $process_params[] = array('name'=>'extra_addressees','value' => $_POST['extra_addressees']);
       $process_params[] = array('name'=>'extra_cc_addressees','value' => $_POST['extra_cc_addressees']);
       $process_params[] = array('name'=>'extra_bcc_addressees','value' => $_POST['extra_bcc_addressees']);
       $process_params[] = array('name'=>'ticket_update','value' => $_POST['ticket_update']);

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

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_edit"]."</a> OR <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

       # Add same status to parent - maybe also add a counter for number of activities/actions..

       $ticket_process_object_type = "Ticketing";
       $ticket_process_action = "update";
       $ticket_process_params = array();  

       if ($_POST['assign_user_to_parent']==1){

          $ticket_process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
          $ticket_process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);

          $process_message .= "<P>Assigned current Agent to Parent Ticket<P>";

          }

       if ($_POST['assign_status_to_parent']==1){

          $ticket_process_params[] = array('name'=>'id','value' => $_POST['sclm_ticketing_id_c']);
          $ticket_process_params[] = array('name'=>'status','value' => $_POST['status']);

          $ticket_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $ticket_process_object_type, $ticket_process_action, $ticket_process_params);

          $process_message .= "<P>Parent Ticket status also updated<P>";

          }

       $parent_ticket = $_POST['sclm_ticketing_id_c'];

       if ($_POST['assign_status_to_child_activities']==1){

          $ticketact_object_type = $do;
          $ticketact_action = "select";
          $ticketact_params[0] = " sclm_ticketing_id_c='".$parent_ticket."' "; // select array
          $ticketact_params[1] = "id,name,sclm_ticketing_id_c"; // select array
          $ticketact_params[2] = ""; // group;
          $ticketact_params[3] = ""; // order;
          $ticketact_params[4] = ""; // limit
          $ticketact_params[5] = $lingoname; // lingo
  
          $ticketact_process_object_type = $do;
          $ticketact_process_action = "update";

          $ticketact_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticketact_object_type, $ticketact_action, $ticketact_params);

          if (is_array($ticketact_items)){

             for ($cnt=0;$cnt < count($ticketact_items);$cnt++){

                 $activity_id = $ticketact_items[$cnt]["id"];
                 $activity_name = $ticketact_items[$cnt]["name"];

                 $ticketact_process_params = "";
                 $ticketact_process_params = array();
                 $ticketact_process_params[] = array('name'=>'id','value' => $activity_id);
                 $ticketact_process_params[] = array('name'=>'status','value' => $_POST['status']);
                 $ticketact_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $ticketact_process_object_type, $ticketact_process_action, $ticketact_process_params);

                 $process_message .= "Child Activity, ".$activity_name.", status also updated..<BR>";

                 } // for

             } // if array

         } // if set children activities

       if ($_POST['assign_status_to_child_tickets']==1){

          $ticketact_object_type = "Ticketing";
          $ticketact_action = "select";
          $ticketact_params[0] = " sclm_ticketing_id_c='".$parent_ticket."' "; // select array
          $ticketact_params[1] = "id,name,sclm_ticketing_id_c"; // select array
          $ticketact_params[2] = ""; // group;
          $ticketact_params[3] = ""; // order;
          $ticketact_params[4] = ""; // limit
          $ticketact_params[5] = $lingoname; // lingo
  
          $ticketact_process_object_type = "Ticketing";
          $ticketact_process_action = "update";

          $ticketact_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticketact_object_type, $ticketact_action, $ticketact_params);

          if (is_array($ticketact_items)){

             for ($cnt=0;$cnt < count($ticketact_items);$cnt++){

                 $activity_id = $ticketact_items[$cnt]["id"];
                 $activity_name = $ticketact_items[$cnt]["name"];

                 $ticketact_process_params = "";
                 $ticketact_process_params = array();
                 $ticketact_process_params[] = array('name'=>'id','value' => $activity_id);
                 $ticketact_process_params[] = array('name'=>'status','value' => $_POST['status']);
                 $ticketact_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $ticketact_process_object_type, $ticketact_process_action, $ticketact_process_params);

                 $process_message .= "Child Ticket, ".$activity_name.", status also updated..<BR>";

                 } // for

             } // if array

         } // if set children

       # Used if needing to send clean email based on vendor code
       if ($_POST['send_original_subject']==1){
          $subject = $_POST['original_subject'];
          $process_message .= "Original subject, ".$subject.", used..<BR>";
          } else {
          $subject = $_POST['name'];
          } 

       $process_message .= "<B>".$strings["Name"].":</B> ".$subject."<BR>";
       $description = $_POST['description'];
       $description = $funky_gear->replacer("\n", "<BR>", $description);
       $process_message .= "<B>".$strings["Description"].":</B> ".$description."<BR>";

       # Check for attachments

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

                            $attach_cit_relater = "TicketingActivities_".$val."_".$sclm_content_id_c;
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

       // Get ticket and sla requests
       $ticket_object_type = "Ticketing";
       $ticket_action = "select";
       $ticket_params[0] = "id='".$_POST['sclm_ticketing_id_c']."' ";
       $ticket_params[1] = "id,sclm_serviceslarequests_id_c,ticket_id,filter_id"; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = ""; // order;
       $ticket_params[4] = ""; // limit
//       $ticket_params[5] = $lingoname; // lingo
  
       $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

       if (is_array($ticket_items)){
  
          for ($cnt=0;$cnt < count($ticket_items);$cnt++){

              $id = $ticket_items[$cnt]["id"];
              $sclm_serviceslarequests_id_c = $ticket_items[$cnt]['sclm_serviceslarequests_id_c'];
              $ticket_id = $ticket_items[$cnt]['ticket_id'];
              $filter_id = $ticket_items[$cnt]['filter_id'];

              } // for

          } // if

       if ($_POST['message_lingo'] != NULL){
          $lingo = $_POST['message_lingo'];
          #echo "Desired Lingo: ".$lingo."<BR>";
          }

       $message_link = "Body@".$lingo."@TicketingActivities@view@".$val."@TicketingActivities";
       $message_link = $funky_gear->encrypt($message_link);
       $message_link = "http://".$hostname."/?pc=".$message_link;

       $type = 1;

       $from_name = $portal_title;
       $from_email = $portal_email;
       $from_email_password = $portal_email_password;

       //echo "Send Email :".$_POST['send_email']."<P>";

       if ($sclm_serviceslarequests_id_c && $_POST['send_email']==1){

          $cnotifications_object_type = "ContactsNotifications";
          $cnotifications_action = "select";
          $cnotifications_params[0] = " sclm_serviceslarequests_id_c='".$sclm_serviceslarequests_id_c."' && cmn_statuses_id_c='".$standard_statuses_open_public."' ";
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

             # Used if needing to send clean email based on vendor code
             if ($_POST['send_original_subject']==1){
                $mailparams[7] = $_POST['original_subject'];
                } else {
                $mailparams[7] = $_POST['name'];
                } 

             $mailparams[8] = $_POST['description']."\n".$strings["action_view_here"].":\n".$message_link;
             $mailparams[9] = $portal_email_server;
             $mailparams[10] = $portal_email_smtp_port;
             $mailparams[11] = $portal_email_smtp_auth;
             $mailparams[12] = $internal_to_addressees;
             $mailparams[20] = $attachments;

             $emailresult = $funky_gear->do_email ($mailparams);

             $process_message .= "Email Result for internal/SLA-based Addressees: ".$emailresult."<P>";

             } // if array notifications

          } // end if $sclm_serviceslarequests_id_c && $_POST['send_email']==1

       if ($_POST['send_email']==1){
          #
          ###########################
          #
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

                } else {// if array cc_addressees

                if ($_POST['extra_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_to_list = $extra_addressees;
                   }

                } 

             } else {// if $_POST['cc_addressees']!= NULL

             if ($_POST['extra_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                $recp_to_list = $extra_addressees;
                }

             } 

          #
          ###########################
          #

          if ($_POST['extra_cc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
             $extra_cc_addressees = $_POST['extra_cc_addressees'];
             $extra_cc_addressees = trim($extra_cc_addressees);
             $extra_cc_addressees = str_replace(" ","", $extra_cc_addressees);
             $extra_cc_addressees = str_replace("　","", $extra_cc_addressees);
             }

          if ($_POST['cc_addressees']!= NULL){

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

                if ($_POST['extra_cc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_cc_list = $recp_cc_list.",".$extra_cc_addressees;
                   }

                } else {// if array cc_addressees

                if ($_POST['extra_cc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_cc_list = $extra_cc_addressees;
                   }

                } 

             } else {// if $_POST['cc_addressees']!= NULL

             if ($_POST['extra_cc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                $recp_cc_list = $extra_cc_addressees;
                }

             } 

          #
          ###########################
          #

          if ($_POST['extra_bcc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
             $extra_bcc_addressees = $_POST['extra_bcc_addressees'];
             $extra_bcc_addressees = trim($extra_bcc_addressees);
             $extra_bcc_addressees = str_replace(" ","", $extra_bcc_addressees);
             $extra_bcc_addressees = str_replace("　","", $extra_bcc_addressees);
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

                if ($_POST['extra_bcc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_bcc_list = $recp_bcc_list.",".$extra_bcc_addressees;
                   }

                } else {// if array cc_addressees

                if ($_POST['extra_bcc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                   $recp_bcc_list = $extra_bcc_addressees;
                   }

                } 

             } else {// if $_POST['cc_addressees']!= NULL

             if ($_POST['extra_bcc_addressees'] != NULL && $_POST['send_extra_addresses'] == 1){
                $recp_bcc_list = $extra_bcc_addressees;
                }

             } 

          #
          ###########################

          // Get lists found
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
//                                  $mailparams[1] = $to_name;
             $mailparams[2] = $from_email;
             $mailparams[3] = $from_email_password;
//                                  $mailparams[4] = $to_email;
             $mailparams[5] = $type;
             $mailparams[6] = $lingo;

             # Used if needing to send clean email based on vendor code
             if ($_POST['send_original_subject']==1){
                $mailparams[7] = $_POST['original_subject'];
                } else {
                $mailparams[7] = $_POST['name'];
                } 

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

          } // if $_POST['send_email']==1

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end Tickets process

   } // end Tickets switch

# // End Tickets
##########################################################
?>
