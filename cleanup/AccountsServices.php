<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: AccountsServices.php 
##########################################################
# case 'AccountsServices':

  #####################################
  # Check Security

  $this_module = '44ea091a-da13-83fe-a15c-52763b5d0ee8';
  $security_params[0] = $this_module;
  $security_params[1] = $lingo;
  $security_params[2] = $sess_contact_id;

  #var_dump($security_params);

  #>>
   #>>
    #>
     $security_check = check_security($security_params); #GO->>>
    #>
   #>>
  #>>

  #var_dump($security_check);

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

  # Check Security
  #####################################
  #

  if (($valtype == 'Parent' || $valtype == 'Accounts') && $action != 'search' && $valtype != 'Global' && $val != NULL){

     $ci_params[0] = " deleted=0 && account_id_c = '".$val."' ";

     $source = $_POST['source'];
     $sourceval = $_POST['sourceval'];

     if (!$source){
        $source = $_GET['source'];
        $sourceval = $_GET['sourceval'];
        }

     if ($source){
        $valtype = $source;
        $val = $sourceval;
        }

     } elseif ($action != 'search' && $valtype != 'Global' && $valtype != 'Services'){

     $ci_params[0] = " deleted=0 && account_id_c = '".$portal_account_id."' ";

     } elseif ($valtype == 'Services'){

     $ci_params[0] = " deleted=0 && sclm_services_id_c = '".$val."' ";     

     } 

 if (!$ci_params[0]){
    $ci_params[0] = " deleted=0 ";
    }

  #echo "<P>Acc: ".$account_id_c." , POR: ".$portal_account_id."<P>";
  #echo "<P>Valtype: ".$valtype." , Val: ".$val."<P>";

  switch ($system_action_list){

   case $action_rights_all:

    if ($account_id_c =! $portal_account_id){
       $ci_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
       }

   break;
   case $action_rights_none:
    $ci_params[0] .= " && cmn_statuses_id_c = 'ZZZZZZZZZZZZZZZZZZ' ";
   break;
   case $action_rights_owner:
    $ci_params[0] .= " && contact_id_c = '".$_SESSION['contact_id']."' ";
   break;
   case $action_rights_account:
    if ($valtype == 'Parent'){
       $ci_params[0] .= " && (account_id_c = '".$_SESSION['account_id']."' || account_id_c = '".$val."' ) ";
       } else {

       $ci_params[0] .= " && account_id_c = '".$_SESSION['account_id']."' ";

       }

   break;

  } // end system_action_list

  if ($valtype == 'Global'){
     #$ci_params[0] = " deleted=0 && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
     $ci_params[0] = " deleted=0 && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
     }

  if ($valtype == 'ConfigurationItems'){
     $ci_params[0] .= " && (parent_service_type='".$val."' || service_type='".$val."') " ;
     }

  if ($valtype == 'Services'){
     $sclm_services_id_c = $val;
     }

  if ($valtype == 'AccountsServices' && $action == 'view'){
     #$sclm_accountsservices_id_c = $val;
     $sclm_services_id_c = $_POST['sclm_services_id_c'];
     }

  if ($valtype == 'Projects'){
     $_SESSION['Project'] = $val;
     $object_returner = $funky_gear->object_returner ('Projects', $val);
     echo $object_returner[1]; //$object_return;
     }

  if ($valtype == 'ProjectTasks'){
     $_SESSION['ProjectTask'] = $val;
     $object_returner = $funky_gear->object_returner ('ProjectTasks', $val);
     echo $object_returner[1]; //$object_return;
     }

  if ($valtype == 'SOW'){
     $_SESSION['SOW'] = $val;
     $object_returner = $funky_gear->object_returner ('SOW', $val);
     echo $object_returner[1]; //$object_return;
     }

  if ($valtype == 'SOWItems'){
     $_SESSION['SOWItem'] = $val;
     $object_returner = $funky_gear->object_returner ('SOWItems', $val);
     echo $object_returner[1]; //$object_return;
     }

/*
  if ($_SESSION['ProjectTask'] != NULL){
     $projecttask_id_c = $_SESSION['ProjectTask'];
     $returner = $funky_gear->object_returner ('ProjectTasks', $projecttask_id_c);
     $object_return_name = $returner[0];
     $object_return = $returner[1];
     echo $object_return;
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
*/

  $keyword = $_POST['keyword'];

  if (!$keyword){
     $keyword = $_GET['keyword'];
     }

  if ($action == 'search' && $keyword != NULL){
     $vallength = strlen($keyword);
     $trimval = substr($keyword, 0, -1);

     if ($sess_account_id){
        $ci_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%' ) && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
        } else {
        $ci_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%' ) && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
        } 

     } # in search and keyword

   /*
     $ci_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' || $lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";
  */

  #echo "<P>Valtype: ".$valtype." || Query: ".$ci_params[0]."<P>";

  switch ($action){
   
   case 'list':
   case 'search':
   
    ################################
    # List
    
    if ($valtype == 'AccountsServices'){
       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["BaseServices"]."</B></font></center></div>";
       } else {
       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["CatalogServices"]."</B></font></center></div>";
       }

    $ci_object_type = 'AccountsServices';
    $ci_action = "select";

    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
//    $ci_params[3] = " service_tier, name, date_entered DESC "; // order;
    $ci_params[3] = " sclm_services_id_c DESC, name ASC, date_modified DESC "; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_params = "";

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV,$navi_params);

       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       $date = date("Y@m@d@G");
       $body_sendvars = $date."#Bodyphp";
       $body_sendvars = $funky_gear->encrypt($body_sendvars);

?>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<?php

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
           $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];

           $market_value = $ci_items[$cnt]['market_value'];
           $service_name = $ci_items[$cnt]['service_name'];
           $service_account_id_c = $ci_items[$cnt]['service_account_id_c'];
           $service_contact_id_c = $ci_items[$cnt]['service_contact_id_c'];
           $parent_service_type = $ci_items[$cnt]['parent_service_type_id'];
           $service_type = $ci_items[$cnt]['service_type'];
           $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
           $service_type_name = $ci_items[$cnt]['service_type_name'];
           $service_tier = $ci_items[$cnt]['service_tier'];
           $service_tier_name = $ci_items[$cnt]['service_tier_name'];
           $image = $ci_items[$cnt]['image'];

           // Get capacity of Engineers available for each service
/*
           $service_capacity = 0;

           $capacity_object_type = "ContactsServicesSLA";
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

           switch ($system_action_edit){

//            case $action_rights_all:
            case $action_rights_owner:

             if ($sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c){
                $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
                }

            break;
            case $action_rights_account:

             if ($sess_account_id == $account_id_c){
                $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
                }

            break;

           } // end edit switch

           // Get SLAs for each service
           $sla = 0;
/*
           $sla_object_type = "ServicesSLA";
           $sla_action = "select";
           $sla_params[0] = " sclm_services_id_c='".$id."' ";
           $sla_params[1] = ""; // select array
           $sla_params[2] = ""; // group;
           $sla_params[3] = ""; // order;
           $sla_params[4] = ""; // limit
  
           $sla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sla_object_type, $sla_action, $sla_params);

           $sla_bundle = "";

           if (is_array($sla_items)){

              $sla_bundle = "<P>";

              for ($cnt=0;$cnt < count($sla_items);$cnt++){

                  $sclm_sla_id_c = $sla_items[$cnt]['sclm_sla_id_c'];
                  $sclm_sla_name = $sla_items[$cnt]['sclm_sla_name'];
                  $sla_bundle .= "<img src=images/blank.gif width=30 height=3><B>-> SLA: ".$sclm_sla_name."</B><BR>";

                  } // end for

              } // end if is array
*/
           if ($service_tier){
//              $tier = "[<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$service_tier."&valuetype=ConfigurationItems');return false\">".$service_tier_name."</a>] ";
              $tier = "[".$service_tier_name."] ";
              }

              $cis .= "<div style=\"".$divstyle_white."\"><div style=\"margin-left:0px;float:left;width:98%;height:60px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\"><div style=\"margin-left:0px;float:left;width:55px;height:55px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><img src=".$image." width=50 border=0></a></div><div style=\"margin-left:0px;float:left;width:80%;height:35px;border-radius:0px;padding-left:5px;padding-top:15px;padding-right:5px;padding-bottom:5px;\">".$tier."[".$parent_service_type_name." -> ".$service_type_name."]<BR>".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a><BR>".$strings["Capacity"].": ".$service_capacity."".$sla_bundle."</div></div></div><BR><img src=images/blank.gif height=5 width=98%>";

//           $cis .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><img src=".$image." width=50 border=0></a> ".$edit."".$tier."[<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$parent_service_type."&valuetype=ConfigurationItems');return false\">".$parent_service_type_name." -></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$service_type."&valuetype=ConfigurationItems');return false\">".$service_type_name."</a>] <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a> [Capacity: ".$service_capacity."]".$sla_bundle."</div>";

           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL && $auth > 1){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;

//    $this->funkydone ($_POST,$lingo,'Content','view','76bed5bc-ab35-7523-d01b-5240743cf4cd','Services',$bodywidth);

    # End List
    ################################

   break; // end list
   case 'add':
   case 'edit':
   case 'view':

    if ($action == 'add'){ 

       switch ($system_action_add){

        case $action_rights_all:
         #$ci_params[0] = " id = '".$val."' && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
        break;
        case $action_rights_none:
         #$ci_params[0] = " id = 'ZZZZZZZZZZZZZZZZZZ' ";
        break;
        case $action_rights_owner:
         #$ci_params[0] = " id = '".$val."' && contact_id_c = '".$_SESSION['contact_id']."' ";
        break;
        case $action_rights_account:
         #$ci_params[0] = " id = '".$val."' && account_id_c = '".$_SESSION['account_id']."' ";
        break;

       } // end switch system_action_view_list

       } // end if action

    if ($action == 'edit'){ 

       switch ($system_action_edit){

        case $action_rights_all:
         $ci_params[0] = " id = '".$val."' && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
        break;
        case $action_rights_none:
         $ci_params[0] = " id = 'ZZZZZZZZZZZZZZZZZZ' ";
        break;
        case $action_rights_owner:
         $ci_params[0] = " id= '".$val."' && contact_id_c = '".$_SESSION['contact_id']."' ";
        break;
        case $action_rights_account:
         $ci_params[0] = " id= '".$val."' && account_id_c = '".$_SESSION['account_id']."' ";
        break;

       } // end switch system_action_view_list

       } // end if action

    if ($action == 'view'){ 

       switch ($system_action_view){

        case $action_rights_all:
         $ci_params[0] = " id = '".$val."' && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
        break;
        case $action_rights_none:
         $ci_params[0] = " id = 'ZZZZZZZZZZZZZZZZZZ' ";
        break;
        case $action_rights_owner:
         $ci_params[0] = " id = '".$val."' && contact_id_c = '".$_SESSION['contact_id']."' ";
        break;
        case $action_rights_account:
         $ci_params[0] = " id = '".$val."' && account_id_c = '".$_SESSION['account_id']."' ";
        break;

       } // end switch system_action_view_list

       }

    if ($valtype == 'Services' && $val != NULL){

       $ci_object_type = 'Services';
       $ci_action = "select";

       $ci_params[0] = " id='".$val."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

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
              $market_value = $ci_items[$cnt]['market_value'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $parent_service_type = $ci_items[$cnt]['parent_service_type_id'];
              $service_type = $ci_items[$cnt]['service_type'];
              $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
              $service_type_name = $ci_items[$cnt]['service_type_name'];
              $service_tier = $ci_items[$cnt]['service_tier'];
              $service_tier_name = $ci_items[$cnt]['service_tier_name'];
              $image = $ci_items[$cnt]['image'];

              } # for       
   
          } # is array

       } # if Services

    if ($ci_params[0] != NULL){

       $ci_object_type = $do;
       $ci_action = "select";

       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $image = $ci_items[$cnt]['image'];
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $description = $ci_items[$cnt]['description'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];

              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];

              $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];

              $market_value = $ci_items[$cnt]['market_value'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];

              $service_account_id_c = $ci_items[$cnt]['service_account_id_c'];
              $service_contact_id_c = $ci_items[$cnt]['service_contact_id_c'];

              $parent_service_type = $ci_items[$cnt]['parent_service_type'];
              $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
              $service_type = $ci_items[$cnt]['service_type'];
              $service_type_name = $ci_items[$cnt]['service_type_name'];
              $service_tier = $ci_items[$cnt]['service_tier'];


/*
              // Get capacity of Engineers available for each service
              $service_capacity = 0;

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

              } // end for

          } // is array

       } // if action

    if ($action == "add"){
       $ci_account_id_c = $sess_account_id;
       $ci_contact_id_c = $sess_contact_id;
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
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

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
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

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
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

/*
    $tblcnt++;

    if ($action == 'edit' || $action == 'add'){

       $tablefields[$tblcnt][0] = "image"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
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
       $tablefields[$tblcnt][20] = "image"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image; //$field_value;   

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
*/
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_services_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["BaseService"]."#1"; // Full Name
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
    $tablefields[$tblcnt][9][9] = $sclm_services_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_services_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

#    if (($action == 'view' || $action == 'edit') && ($sclm_accountsservices_id_c != NULL || $sclm_accountsservices_id_c != 'NULL')){ 
   if (($action == 'view' || $action == 'edit') && $sclm_accountsservices_id_c != "NULL" && $sclm_accountsservices_id_c != NULL){ 

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'sclm_accountsservices_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["BaseService"]."#2"; // Full Name
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
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $sclm_accountsservices_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'AccountsServices';
       $tablefields[$tblcnt][9][7] = "sclm_accountsservices"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'AccountsServices'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_accountsservices_id_c; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_accountsservices_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_accountsservices_id_c; //$field_value;
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       } # if view/null

    // Check individual fields
    $field_module = '33fb9883-f2c5-f6c3-4026-52885904a74a'; // account_id_c
    $field_security_params[0] = $field_module;
    $field_security_params[1] = $lingo;
    $field_security_params[2] = $sess_contact_id;
    $field_security_check = check_security($field_security_params);
    $field_security_access = $field_security_check[0];
    $field_security_level = $field_security_check[1];
    $field_security_role = $field_security_check[2];
    $field_system_action_add = $field_security_check[3];
    $field_system_action_delete = $field_security_check[4];
    $field_system_action_edit = $field_security_check[5];
    $field_system_action_export = $field_security_check[6];
    $field_system_action_import = $field_security_check[7];
    $field_system_action_view = $field_security_check[8];
    $field_system_action_list = $field_security_check[9];

    if (($field_system_action_add == $action_rights_all || $field_system_action_add == $action_rights_owner || $field_system_action_add == $action_rights_account) || ($field_system_action_edit == $action_rights_all || $field_system_action_edit == $action_rights_owner || $field_system_action_edit == $action_rights_account) || ($field_system_action_view == $action_rights_all || $field_system_action_view == $action_rights_owner || $field_system_action_view == $action_rights_account)) {

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
       $tablefields[$tblcnt][9][4] = " id='".$ci_account_id_c."' "; // exception
       $tablefields[$tblcnt][9][5] = $ci_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

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
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       } // end 

    // Check individual fields
    $field_module = 'edbfc85e-62c9-568e-3d68-52885b575ae7'; // contact_id_c
    $field_security_params[0] = $field_module;
    $field_security_params[1] = $lingo;
    $field_security_params[2] = $sess_contact_id;
    $field_security_check = check_security($field_security_params);
    $field_security_access = $field_security_check[0];
    $field_security_level = $field_security_check[1];
    $field_security_role = $field_security_check[2];
    $field_system_action_add = $field_security_check[3];
    $field_system_action_delete = $field_security_check[4];
    $field_system_action_edit = $field_security_check[5];
    $field_system_action_export = $field_security_check[6];
    $field_system_action_import = $field_security_check[7];
    $field_system_action_view = $field_security_check[8];
    $field_system_action_list = $field_security_check[9];


    #if (($field_system_action_add == $action_rights_all || $field_system_action_add == $action_rights_owner || $field_system_action_add == $action_rights_account) || ($field_system_action_edit == $action_rights_all || $field_system_action_edit == $action_rights_owner || $field_system_action_edit == $action_rights_account) || ($field_system_action_view == $action_rights_all || $field_system_action_view == $action_rights_owner || $field_system_action_view == $action_rights_account)) {

    if ($ci_contact_id_c == $sess_contact_id){

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
//       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$ci_account_id_c."' && contacts.id=accounts_contacts.contact_id "; // exception
       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       } else {

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
       $tablefields[$tblcnt][10] = '0';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       }

    if ($action == 'add'){

       # Service Assets | ID: a39735f4-b558-5214-1d07-52593e7f39da (not scanned)
       # Infrastructure | ID: 7827074f-a7d3-9ae5-e473-5255d64e5c73 (not scanned)
       # Data Center | ID: 7d2f42a9-9de7-224d-712c-52ad30da69fd (not scanned)
       # DC Floor (ID, Name) | ID: 9a2ee7f9-67b6-9f72-c133-52ad302dfdc0 (not scanned)
       # -> Rack (ID, Name) | ID: 63fef2c9-9acf-fbd1-56c7-52ad300f480f (not scanned)
       #    -> Rack Unit Space (ID, Name) | ID: de350370-d2d3-e84b-13c1-52ad5f2fb2ab (not scanned)
       #       -> System Name | ID: 9065cbc6-177f-9848-1ada-52ad30451c3f (not scanned)
       #       -> Blade Enclosure (ID, Name) | ID: 94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4 (not scanned)
       #          -> Blade Enclosure Hostnames | ID: cd287492-19ce-99b3-6ead-52e0c97a6e83 (scanned)
       #          -> Blade Enclosure Interconnect Bay | ID: 5601009c-5ebd-bc31-3659-52e0e4b16ffb (not scanned)
       #             -> Blade Enclosure Interconnect Bay Switch | ID: 3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889 (not scanned)
       #                -> Blade Enclosure Interconnect Bay Switch Hostname | ID: 49ff2505-7d08-cb5c-64e8-52e0e490c0dc  (scanned)
       #          -> Blades | ID: 617ab884-61b5-d7a1-1de7-52ad61df4cae (not scanned)
       #             -> Blade Hostname | ID: 34647ae4-154c-68f3-74ea-52b0c8abc3dc (scanned)
       #             -> Blade VM | ID: b3621853-e25d-0e38-84ff-52c286ae0de9 (not scanned)
       #                -> Blade VM Hostname | ID: 3f6d75b7-c0f5-1739-c66d-52c2989ce02d (scanned)
       #       -> Purpose | ID: cb455d67-8335-df81-1d3b-52ad67c4977e (not scanned)
       #       -> Rack Server - 1U | ID: 77c9dccf-a0a7-05fc-a05f-52ad62515fc7 (not scanned)
       #          -> Product Components | ID: 52784a42-d442-9e71-8d09-529304d1d518 (not scanned)
       #          -> Unit Host Name | ID: 7835c8b9-f7d5-5d0a-be10-52ad9c866856 (scanned)
       #          -> Unit VM | ID: 711d9da0-c885-6a0d-1a2c-52c286bd762d (not scanned)
       #             -> Unit VM Hostname | ID: 7ef914c8-09f8-82c9-d4b9-52c29793ef85 (scanned)
       #       -> Rack Storage Unit | ID: 7b5baafb-6f98-5d25-d9c8-541fca790cea (not scanned)
       #          -> Rack Storage Hostname | ID: 8c8a3231-1d86-0117-4680-541fcbab4f6a (scanned)
       #       -> Switch Unit | ID: c194460c-0e8d-ca8e-0aa9-541fc5785016 (not scanned)
       #          -> Switch Hostname | ID: 388b56dc-771e-b743-e63b-541fc6070ab9 (scanned)        

       # If edit - then must check any CIs that relate to this Account Service
       # When a Service SLA Request is added - will create an instance of this
       /*
       $service_types['9a2ee7f9-67b6-9f72-c133-52ad302dfdc0'] = 'DC Floor (ID, Name)';
       $service_types['63fef2c9-9acf-fbd1-56c7-52ad300f480f'] = 'Rack (ID, Name)';
       $service_types['de350370-d2d3-e84b-13c1-52ad5f2fb2ab'] = 'Rack Unit Space (ID, Name)';
       $service_types['94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4'] = 'Blade Enclosure (ID, Name)';
       $service_types['cd287492-19ce-99b3-6ead-52e0c97a6e83'] = 'Blade Enclosure Hostname';
       $service_types['5601009c-5ebd-bc31-3659-52e0e4b16ffb'] = 'Blade Enclosure Interconnect Bay';
       $service_types['3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889'] = 'Blade Enclosure Interconnect Bay Switch';
       $service_types['49ff2505-7d08-cb5c-64e8-52e0e490c0dc'] = 'Blade Enclosure Interconnect Bay Switch Hostname';
       $service_types['617ab884-61b5-d7a1-1de7-52ad61df4cae'] = 'Blade';
       $service_types['34647ae4-154c-68f3-74ea-52b0c8abc3dc'] = 'Blade Hostname';
       $service_types['b3621853-e25d-0e38-84ff-52c286ae0de9'] = 'Blade VM';
       $service_types['3f6d75b7-c0f5-1739-c66d-52c2989ce02d'] = 'Blade VM Hostname';
       $service_types['77c9dccf-a0a7-05fc-a05f-52ad62515fc7'] = 'Rack Server - 1U';
       $service_types['7835c8b9-f7d5-5d0a-be10-52ad9c866856'] = 'Unit Hostname';
       $service_types['711d9da0-c885-6a0d-1a2c-52c286bd762d'] = 'Unit VM';
       $service_types['7ef914c8-09f8-82c9-d4b9-52c29793ef85'] = 'Unit VM Hostname';
       $service_types['7b5baafb-6f98-5d25-d9c8-541fca790cea'] = 'Rack Storage Unit';
       $service_types['8c8a3231-1d86-0117-4680-541fcbab4f6a'] = 'Rack Storage Hostname';
       $service_types['c194460c-0e8d-ca8e-0aa9-541fc5785016'] = 'Switch Unit';
       $service_types['388b56dc-771e-b743-e63b-541fc6070ab9'] = 'Switch Hostname';
       */

       $service_types = $funky_gear->get_infra();

       $tblcnt++;

       $tablefields[$tblcnt][0] = "instances"; // Field Name
       $tablefields[$tblcnt][1] = "Number of Inventory Instances (Per Selected SLA)"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'decimal';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '15'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][12] = "15"; // Field ID
       $tablefields[$tblcnt][20] = "instances"; //$field_value_id;
       $tablefields[$tblcnt][21] = $instances; //$field_value;  

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'service_type'; // Field Name
       $tablefields[$tblcnt][1] = "Inventory Service Type"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $service_types; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       #$tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $service_type; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'service_type';//$field_value_id;
       $tablefields[$tblcnt][21] = $service_type; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

       $tblcnt++;

       $tablefields[$tblcnt][0] = "service_name"; // Field Name
       $tablefields[$tblcnt][1] = "Inventory Service Name"; // Full Name
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
       $tablefields[$tblcnt][12] = "50"; // Field ID
       $tablefields[$tblcnt][20] = "service_name"; //$field_value_id;
       $tablefields[$tblcnt][21] = $service_name; //$field_value;   

       } # if add

       if ($action == 'add'){

          $sla_object_type = 'ServicesSLA';
          $sla_params[0] = " deleted=0 && sclm_services_id_c ='".$sclm_services_id_c."' ";    
//          $sla_params[0] = $object_return_params[0];

          $sla_action = "select";
          $sla_params[1] = "id,name"; // select array
          $sla_params[2] = ""; // group;
          $sla_params[3] = ""; // order;
          $sla_params[4] = ""; // limit
  
          $sla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sla_object_type, $sla_action, $sla_params);

          if (is_array($sla_items)){

             for ($cnt=0;$cnt < count($sla_items);$cnt++){

                 $tblcnt++;

                 $slaid = $sla_items[$cnt]['id'];
                 $slaname = $sla_items[$cnt]['name'];

                 $tablefields[$tblcnt][0] = "sclm_servicessla_id_c_".$slaid; // Field Name
                 $tablefields[$tblcnt][1] = $slaname; // Full Name
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
                 $tablefields[$tblcnt][20] = "sclm_servicessla_id_c_".$slaid; //$field_value_id;
                 $tablefields[$tblcnt][21] = "0"; //$field_value;
                 $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

                 } // for

             }  // if array

          } // if add

       if ($action == 'edit' || $action == 'view'){

          // Get the available SLAs for this service from base system to select from for use with own branded services/SLAs

          $sla_object_type = 'ServicesSLA';
          $sla_params[0] = " deleted=0 && sclm_services_id_c ='".$sclm_services_id_c."' && cmn_statuses_id_c != '".$standard_statuses_closed."' && cmn_statuses_id_c IS NOT NULL && cmn_statuses_id_c != '' && cmn_statuses_id_c != 'NULL' ";    
          $sla_action = "select";
          $sla_params[1] = "id,name"; // select array
          $sla_params[2] = ""; // group;
          $sla_params[3] = ""; // order;
          $sla_params[4] = ""; // limit
  
          $sla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sla_object_type, $sla_action, $sla_params);

          #var_dump($sla_items);

          if (is_array($sla_items)){

             for ($slacnt=0;$slacnt < count($sla_items);$slacnt++){
 
                 $slaid = $sla_items[$slacnt]['id'];
                 $slaname = $sla_items[$slacnt]['name'];

                 $accsla_items = "";

                 $accsla_object_type = 'AccountsServicesSLAs';
                 $accsla_action = "select";
                 $accsla_params[0] = " deleted=0 && sclm_servicessla_id_c ='".$slaid."' && account_id_c='".$ci_account_id_c."' && cmn_statuses_id_c IS NOT NULL && cmn_statuses_id_c != ''  ";
                 $accsla_params[1] = "id,name,cmn_statuses_id_c"; // select array
                 $accsla_params[2] = ""; // group;
                 $accsla_params[3] = ""; // order;
                 $accsla_params[4] = ""; // limit
  
                 $accsla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accsla_object_type, $accsla_action, $accsla_params);

                 if (is_array($accsla_items)){

                    for ($accslacnt=0;$accslacnt < count($accsla_items);$accslacnt++){
  
                        $accountsservicesslas_id = $accsla_items[$accslacnt]['id'];
                        $accountsservicesslas_name = $accsla_items[$accslacnt]['name'];
                        $cmn_statuses_id_c = $accsla_items[$accslacnt]['cmn_statuses_id_c'];

                        $tblcnt++;

                        $tablefields[$tblcnt][0] = "sclm_accountsservicesslas_id_c_".$accountsservicesslas_id; // Field Name
                        $tablefields[$tblcnt][1] = $accountsservicesslas_name; // Full Name
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
                        $tablefields[$tblcnt][20] = "sclm_accountsservicesslas_id_c_".$accountsservicesslas_id; //$field_value_id;

                        if ($cmn_statuses_id_c == $standard_statuses_open_public){
                           $tablefields[$tblcnt][21] = "1"; //$field_value;
                           } else {
                           $tablefields[$tblcnt][21] = "0"; //$field_value;
                           }

                        $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

                        } // end for
 
                    } else {

                    $tblcnt++;
 
                    $tablefields[$tblcnt][0] = "sclm_servicessla_id_c_".$slaid; // Field Name
                    $tablefields[$tblcnt][1] = $slaname; // Full Name
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
                    $tablefields[$tblcnt][20] = "sclm_servicessla_id_c_".$slaid; //$field_value_id;
                    $tablefields[$tblcnt][21] = "0"; //$field_value;
                    $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

                    } // end if selection found

                 } // for

             } // is array

          } // if edit/view

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
    $tablefields[$tblcnt][12] = "70"; // Field ID
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = "";

    if ($sess_account_id == $account_id_c){
       $valpack[4] = $auth;
       }

    switch ($system_action_view){

      case ($action_rights_all || ($action_rights_owner && $sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c) || ($action_rights_account && $sess_account_id == $account_id_c)):

       #$valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)

      break;

      } // end auth switch

    $valpack[5] = ""; // provide add new button

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
    $container_params[1] = "97%"; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $name;//'Service Catalog Item'; // container_title
    $container_params[4] = 'ServiceCatalogItem'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $object_return;
//    echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

//    if (($action == 'edit' || $action == 'view') && $account_id_c != NULL && $sess_contact_id != NULL){
    if (($action == 'edit' || $action == 'view') && $ci_account_id_c != NULL && $sess_contact_id != NULL){

       echo "<BR><img src=images/blank.gif width=98% height=15><BR>";
       echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServicesPrices&action=add&value=".$sclm_services_id_c."&valuetype=".$do."');return false\" class=\"css3button\"><B>".$strings["SetServiceSLAPricing"]."</B></a>";

       # SLA Requests can only be made using active SLA Prices
       #echo "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=add&value=".$val."&valuetype=".$do."&sclm_services_id_c=".$sclm_services_id_c."&ci_contact_id_c=".$ci_contact_id_c."&ci_account_id_c=".$ci_account_id_c."');return false\" class=\"css3button\"><B>".$strings["ServiceSLARequest"]."</B></a></center>";
       echo "<BR><img src=images/blank.gif width=98% height=1><BR>";

       }

    if ($action != 'add'){

       $accserv_object_type = 'AccountsServices';
       $accserv_action = "select";
//       $accserv_params[0] = " account_id_c='".$_SESSION['account_id']."' && sclm_services_id_c='".$sclm_services_id_c."' && id='".$val."' ";
       $accserv_params[0] = " account_id_c='".$_SESSION['account_id']."' && sclm_services_id_c='".$sclm_services_id_c."' ";
       $accserv_params[1] = ""; // select array
       $accserv_params[2] = ""; // group;
       $accserv_params[3] = ""; // order;
       $accserv_params[4] = ""; // limit
  
       $accserv_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accserv_object_type, $accserv_action, $accserv_params);

       if (!is_array($accserv_items)){

          if ($sess_contact_id != NULL) {

             echo "<BR><img src=images/blank.gif width=98% height=3><BR>";
             echo "<center><img src=images/ServiceCatalogFlows-AddingToCatalog-".$lingo.".png></center>";
             echo "<BR><img src=images/blank.gif width=98% height=3><BR>";
             echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=add&value=".$val."&valuetype=".$do."&sclm_services_id_c=".$sclm_services_id_c."');return false\" class=\"css3button\"><B>".$strings["CatalogServicesAddTo"]."</B></a></center>";
             echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

             }

          }

       }

    echo $container_top;

    if (($action == 'edit' || $action == 'view') && $image != NULL){
       echo "<center><img src=".$image." width=50%></center><BR>"; 
       }

    echo $zaform;

    ##########################
    # Show Instances of SLA

    if ($action == 'edit' || $action == 'view' ){

       # Select which CIs relate to the instance with the Account Service ID
       # CIT: 542be154-a211-98cf-84e0-54e6207213bc
       # $val = Accounts Services service_ci_id

       $acc_serv_object_type = "ConfigurationItems";
       $acc_serv_action = "select";
       $acc_serv_params[0] = "name='".$val."' && sclm_configurationitemtypes_id_c='542be154-a211-98cf-84e0-54e6207213bc' && account_id_c='".$sess_account_id."' ";
       $acc_serv_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
       $acc_serv_params[2] = ""; // group;
       $acc_serv_params[3] = ""; // order;
       $acc_serv_params[4] = ""; // limit
  
       $acc_serv_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_serv_object_type, $acc_serv_action, $acc_serv_params);

       if (is_array($acc_serv_items)){

          for ($acc_serv_cnt=0;$acc_serv_cnt < count($acc_serv_items);$acc_serv_cnt++){

              # Account Service CI
              $acc_service_ci_id = $acc_serv_items[$acc_serv_cnt]['id'];
              $acc_service_ci_name = $acc_serv_items[$acc_serv_cnt]['name']; # the Acc Serv ID
                    
              $acc_service_returner = $funky_gear->object_returner ("AccountsServices", $acc_service_ci_name);
              $acc_service_name = $acc_service_returner[0];

              $acc_serv_instance = "Account Service: ".$acc_service_name." -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_service_ci_id."&valuetype=ConfigurationItems');return false\">View Instance Wrapper</a><BR>";

              # Collect the SLA CI Instances under this

              $acc_servsla_object_type = "ConfigurationItems";
              $acc_servsla_action = "select";
              $acc_servsla_params[0] = "sclm_configurationitems_id_c='".$acc_service_ci_id."' ";
              $acc_servsla_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
              $acc_servsla_params[2] = ""; // group;
              $acc_servsla_params[3] = ""; // order;
              $acc_servsla_slaparams[4] = ""; // limit
  
              $acc_servsla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_servsla_object_type, $acc_servsla_action, $acc_servsla_params);

              if (is_array($acc_servsla_items)){

                 for ($acc_servsla_cnt=0;$acc_servsla_cnt < count($acc_servsla_items);$acc_servsla_cnt++){

                     # Account Service CI
                     $servicesla_ci_id = $acc_servsla_items[$acc_servsla_cnt]['id'];
                     $servicesla_ci_name = $acc_servsla_items[$acc_servsla_cnt]['name']; # the Acc Serv SLA ID

                     $servicesla_returner = $funky_gear->object_returner ("AccountsServicesSLAs", $servicesla_ci_name);
                     $servicesla_name = $servicesla_returner[0];

                     #$servicesla_ci_type = $acc_servsla_items[$acc_servsla_cnt]['sclm_configurationitemtypes_id_c'];
                     #$acc_serv_instance .= " -> ".$servicesla_name." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$servicesla_ci_id."&valuetype=ConfigurationItems');return false\">View Instance</a><BR>";

                     $acc_serv_instance .= " -> Allocate ".$servicesla_name."<BR>"; 

                     } # for

                 } # is array

              } # for

          $acc_serv_instance = "<div style=\"border:1px solid ".$border_color.";border-radius:1px;width:100%;float:left;padding-top:5;overflow:auto;max-height:200px;\">".$acc_serv_instance."</div>";

          echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>Service Instances for Allocation</B></font></center></div>";
          echo "<BR><img src=images/blank.gif width=90% height=5><BR>";


          echo "<div style=\"".$divstyle_white."\">".$acc_serv_instance."</div>";

          } # is array

       # Show Instances of SLA
       ##########################

       /*
       $tblcnt++;

       $tablefields[$tblcnt][0] = "acc_service_ci_id"; // Field Name
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
       $tablefields[$tblcnt][20] = "acc_service_ci_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $acc_service_ci_id; //$field_value;   
       $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue
       */

       } # edit/view

    echo $container_bottom;

    #
    ###################
    #

    if ($action == 'view' || $action == 'edit'){ 

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = "97%"; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["AccountsServicesSLAs"]; // container_title
       $container_params[4] = 'ServiceSLA'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs
   
       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'AccountsServicesSLAs','list',$val,$do,$bodywidth);

//       echo $container_bottom;

       #
       ###################
       #

       $container_params[0] = 'open'; // container open state
       $container_params[1] = "97%"; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["ServiceSLAPrices"]; // container_title
       $container_params[4] = 'ServicesPrices'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];
   
       echo $container_middle;

       #$sendparams[2] = "AccountsServices";
       #$sendparams[3] = $val;

       #$this->funkydone ($_POST,$lingo,'ServicesPrices','list',$sclm_services_id_c,"Services",$sendparams);
       $this->funkydone ($_POST,$lingo,'ServicesPrices','list',$val,$do,$bodywidth);

       echo $container_bottom;

    } // end view

    #
    ###################

    if ($action == 'view' || $action == 'edit'){

       $params = array();
       $params[0] = $name;
       echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

       }


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
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'sclm_accountsservices_id_c','value' => $_POST['sclm_accountsservices_id_c']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          $sclm_accountsservices_id_c = $result['id'];
          } elseif ($_POST['id'] != NULL){
          $val = $_POST['id'];
          $sclm_accountsservices_id_c = $_POST['id'];
          }

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">".$strings["action_view_here"]."</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$_POST['name']."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$_POST['description']."<BR>";

       #######################
       # Newly added Account Service - add an instance regardless

       if ($_POST['id'] == NULL){

          $process_object_type = "ConfigurationItems";
          $process_action = "update";
          $process_params = "";
          $process_params = array();

          $acc_service_instance = '542be154-a211-98cf-84e0-54e6207213bc';
          $acc_service_image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_service_instance);
          $acc_service_image_url = $acc_service_image_returner[7];

          $process_params[] = array('name'=>'name','value' => $sclm_accountsservices_id_c); # Acc Service ID
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'description','value' => $_POST['name']." -> Instances");
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_service_instance);
          $process_params[] = array('name'=>'image_url','value' => $acc_service_image_url);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
          #$process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
          #$process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
          #$process_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
          #$process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
          #$process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
          $process_params[] = array('name'=>'enabled','value' => 1);

          $acc_service_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
          $acc_service_id = $acc_service_result['id'];

          } # ($_POST['id'] 

       # Service Types
       #######################

       $instances = $_POST['instances'];
       $service_type = $_POST['service_type'];
       $service_name = $_POST['service_name'];

       if ($acc_service_id != NULL && $service_type != NULL && $accountsservicesslas_id_c != NULL){
          $acc_servicesla_image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $service_type);
          $acc_servicesla_image_url = $acc_servicesla_image_returner[7];
          }

       foreach ($_POST as $key=>$value){

               $sclm_servicessla_id_c = str_replace("sclm_servicessla_id_c_","",$key);
               $sclm_accountsservicesslas_id_c = str_replace("sclm_accountsservicesslas_id_c_","",$key);

               #$key_length = strlen($key);

               # First check to see if this is a new one or edit within this POST loop 
               if ($sclm_servicessla_id_c != $key){
                  $sclm_accountsservicesslas_id_c = "";
                  } elseif ($sclm_accountsservicesslas_id_c != $key){
                  $sclm_servicessla_id_c = "";
                  }

               $process_params = array();  

               # Set up the values for whichever items was selected
               if ($value == 1 && $sclm_accountsservicesslas_id_c != NULL){
                  # Existing one with value now set to open
                  $cmn_statuses_id_c = $standard_statuses_open_public;
                  $sla_returner = $funky_gear->object_returner ('AccountsServicesSLAs', $sclm_accountsservicesslas_id_c);
                  $requested_service_sla_name = $sla_returner[0];
                  $requested_service_sla_desc = $requested_service_sla_name;
                  $process_message .= "<B>".$requested_service_sla_name.":</B> value now set to open<BR>";
                  } elseif ($value == 0 && $sclm_accountsservicesslas_id_c != NULL){
                  # Existing one with value now set to closed
                  $cmn_statuses_id_c = $standard_statuses_closed;
                  $sla_returner = $funky_gear->object_returner ('AccountsServicesSLAs', $sclm_accountsservicesslas_id_c);
                  $requested_service_sla_name = $sla_returner[0];
                  $requested_service_sla_desc = $requested_service_sla_name;
                  $process_message .= "<B>".$requested_service_sla_name.":</B> value now set to closed<BR>";
                  } elseif ($value == 1 && $sclm_servicessla_id_c != NULL){
                  # New one with value set to open
                  $cmn_statuses_id_c = $standard_statuses_open_public;
                  $sla_returner = $funky_gear->object_returner ('ServicesSLA', $sclm_servicessla_id_c);
                  $sla_name = $sla_returner[0];
                  $requested_service_sla_name = $sla_name;
                  $requested_service_sla_desc = $requested_service_sla_name;
                  $process_message .= "<B>".$requested_service_sla_name.":</B> now added<BR>";
                  $process_params[] = array('name'=>'name','value' => $requested_service_sla_name);
                  $process_params[] = array('name'=>'description','value' => $requested_service_sla_desc);
                  $process_params[] = array('name'=>'sclm_servicessla_id_c','value' => $sclm_servicessla_id_c);
                  }

//               if ($value == 1 && ($sclm_servicessla_id_c != NULL || $sclm_accountsservicesslas_id_c != NULL)){
               if (($sclm_servicessla_id_c != NULL && $value == 1) || ($sclm_accountsservicesslas_id_c != NULL && ($value == 1 || $value == 0))){

                  $accountsservicesslas_id_c = "";

                  $process_object_type = "AccountsServicesSLAs";
                  $process_action = "update";

                  $process_params[] = array('name'=>'id','value' => $sclm_accountsservicesslas_id_c);
                  $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                  $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
                  $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                  $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                  $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
                  $process_params[] = array('name'=>'sclm_accountsservices_id_c','value' => $sclm_accountsservices_id_c);

                  $accountsservicesslas_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                  $accountsservicesslas_id_c = $accountsservicesslas_result['id'];

                  if ($accountsservicesslas_id_c != NULL){

                     $process_message .= $requested_service_sla_name." Account Service SLA submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServicesSLAs&action=view&value=".$accountsservicesslas_id_c."&valuetype=AccountsServices');return false\">here!</a><BR>";

                     ####################
                     # Instances generated per SLA

                     if ($acc_service_id != NULL && $service_type != NULL){

                        # Account Service Instance to be parent CI for actual service types (infra)

                        if ($instances == NULL){
                           $instances = 1;
                           }

                        # Number of instances per Account Service SLA

                        for ($accsla_cnt=0;$accsla_cnt < $instances;$accsla_cnt++){

                            $acc_serv_process_object_type = "ConfigurationItems";
                            $acc_serv_process_action = "update";
                            $acc_serv_process_params = "";
                            $acc_serv_process_params = array();  

                            #$acc_serv_process_params[] = array('name'=>'id','value' => );
                            $acc_serv_sla_name = $service_name."-".$accsla_cnt;
                            $acc_serv_process_params[] = array('name'=>'name','value' => $accountsservicesslas_id_c); # CI name for child
                            $acc_serv_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                            $acc_serv_process_params[] = array('name'=>'description','value' => $acc_serv_sla_name);
                            $acc_serv_process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                            $acc_serv_process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                            #acc_serv_process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
                            $acc_serv_process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $service_type);
                            $acc_serv_process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $acc_service_id); # Becomes Parent CI
                            $acc_serv_process_params[] = array('name'=>'image_url','value' => $acc_servicesla_image_url);
                            $acc_serv_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                            #acc_serv_process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
                            #acc_serv_process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
                            #acc_serv_process_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
                            #$acc_serv_process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
                            #$acc_serv_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
                            $acc_serv_process_params[] = array('name'=>'enabled','value' => 1);
                      
                            $acc_serv_sla_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $acc_serv_process_object_type, $acc_serv_process_action, $acc_serv_process_params);

                            if ($acc_serv_sla_result['id'] != NULL){
                               $acc_serv_sla_id = $acc_serv_sla_result['id'];

                               $process_message .= $acc_serv_sla_name." Service Type Instance submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$acc_serv_sla_id."&valuetype=AccountsServices');return false\">here!</a><BR>";

                               } # if added

                            } # for number of instances

                        } # if $acc_service_id != NULL && $service_type != NULL

                     #
                     ####################

                     } # ($result['id'] != NULL)

                  } // end if

               } // end foreach

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>