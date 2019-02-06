<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: Services.php 
##########################################################
# case 'Services':

  if ($valtype == 'ConfigurationItems'){
     $object_return_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && (parent_service_type='".$val."' || service_type='".$val."') " ;
     #$object_return_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && parent_service_type='".$val."' " ;
     }

//  $_SESSION["PROJECTTASK"]="";
//  $_SESSION["PROJECT"]="";

  if ($valtype == 'ProjectTasks'){
     $_SESSION['ProjectTask'] = $val;
     $object_return_params[0] = " deleted=0 ";
     }

  if ($valtype == 'Projects'){
     $_SESSION['Project'] = $val;
     $object_return_params[0] = " deleted=0 ";
     }

  if ($valtype == 'SLA'){
     #$_SESSION['SLA'] = $val;
     $object_return_params[0] = " deleted=0 && name='XXXXXXXXXXXXXXXXXXXXXXXX' ";
     }

  if ($valtype == 'AccountsServices'){
     $object_returner = $funky_gear->object_returner ('Services', $val);
     echo $object_returner[1]; //$object_return;
     }

  #echo "$valtype $val <P>";

  $keyword = $_POST['keyword'];
  if (!$keyword){
     $keyword = $_GET['keyword'];
     }

if ($action == 'search' && $keyword != NULL){
   $vallength = strlen($keyword);
   $trimval = substr($keyword, 0, -1);
   $object_return_params[0] = " deleted=0 && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";
   }

  $stypes = $_POST['stypes'];
  if (!$stypes){
     $stypes = $_GET['stypes'];
     }

if ($action == 'search_stypes'){
   $object_return_params[0] = " deleted=0 && (service_type='".$stypes."' || parent_service_type='".$stypes."') ";
   }

  $ltypes = $_POST['ltypes'];
  if (!$ltypes){
     $ltypes = $_GET['ltypes'];
     }

if ($action == 'search_lifestyle'){
   $object_return_params[0] = " deleted=0 && (lifestyle_category='".$ltypes."' || lifestyle_category='".$ltypes."') ";
   }

  switch ($action){
   
   case 'list':
   case 'search':
   case 'search_stypes':
   case 'search_lifestyle':
   
    ################################
    # List
    
    echo "<div style=\"".$divstyle_blue."\"><center><font size=3><B>Items & Services</B></font></center></div>";

    # Product Types | ID: 1dea7f68-6f6a-662f-fb43-54f829549bd9
    # Service Types | ID: cabebb61-5bef-f61c-fd3d-51d18355ccdb

    # Parent Types
    $service_ci_object_type = 'ConfigurationItems';
    $service_ci_action = "select";
    #$service_ci_params[0] = " (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && (sclm_configurationitems_id_c IS NULL || sclm_configurationitems_id_c='' || sclm_configurationitems_id_c='NULL') ";

    $service_ci_params[0] = " (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL'";

    $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
    $service_ci_params[2] = ""; // group;
    $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
    $service_ci_params[4] = ""; // limit

    $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

    if (is_array($service_ci_items)){

       $producttypes = " | ";
       $servicetypes = " | ";

       for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

           $id = $service_ci_items[$cnt]['id'];
           $name = $service_ci_items[$cnt]['name'];
           $partype = $service_ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

           if ($partype == '1dea7f68-6f6a-662f-fb43-54f829549bd9'){
              $producttypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_stypes&value=".$val."&stypes=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>".$name."</B></font></a> | ";
              } else {
              $servicetypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_stypes&value=".$val."&stypes=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>".$name."</B></font></a> | ";
              } # if

           } # for

       if ($action == 'search_stypes' && $stypes != NULL){

          $service_ci_object_type = 'ConfigurationItems';
          $service_ci_action = "select";
          $service_ci_params[0] = " sclm_configurationitems_id_c='".$stypes."' ";
          $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
          $service_ci_params[2] = ""; // group;
          $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
          $service_ci_params[4] = ""; // limit

          $service_ci_items = "";

          $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

          if (is_array($service_ci_items)){

             #$producttypes = " | ";
             #$servicetypes = " | ";
             $type = "";
             $hasproducttypes = FALSE;
             $hasservicetypes = FALSE;

             for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

                 $id = $service_ci_items[$cnt]['id'];
                 $name = $service_ci_items[$cnt]['name'];
                 $type = $service_ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
                 #$returner = $funky_gear->object_returner ('ConfigurationItems', $val);
                 #$object_return_name = $returner[0];

                 if ($type == '1dea7f68-6f6a-662f-fb43-54f829549bd9'){
                    $hasproducttypes = TRUE;
                    $producttypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_stypes&value=".$val."&stypes=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=BLUE><B>".$name."</B></font></a> | ";
                    } else {
                    $hasservicetypes = TRUE;
                    $servicetypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_stypes&value=".$val."&stypes=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=BLUE><B>".$name."</B></font></a> | ";
                    } # if

                 } # for

             $products_services_types .= "<div>";

             if ($hasproducttypes){
                $products_services_types .= "<div style=\"".$divstyle_white."\"><center><B>Child Items</B><BR>".$producttypes."</center></div>";
                }
             if ($hasservicetypes){
                $products_services_types .= "<div style=\"".$divstyle_white."\"><center><B>Child Services</B><BR>".$servicetypes."</center></div>";
                }

             $products_services_types .= "</div>";

             } # if array

          } # if subtypes

       # Lifestyle & State Categories: a86cf661-d985-f7fc-3a72-5521d38a3700
       $service_ci_object_type = 'ConfigurationItemTypes';
       $service_ci_action = "select";
       $service_ci_params[0] = " sclm_configurationitemtypes_id_c='a86cf661-d985-f7fc-3a72-5521d38a3700' ";
       $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
       $service_ci_params[2] = ""; // group;
       $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
       $service_ci_params[4] = ""; // limit

       $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

       for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

           $id = $service_ci_items[$cnt]['id'];
           $name = $service_ci_items[$cnt]['name'];

           $lifestyletypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_lifestyle&value=".$val."&ltypes=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>".$name."</B></font></a> | ";

           } # for

       # Sub Types
       if ($action == 'search_lifestyle' && $ltypes != NULL){

          $service_li_object_type = 'ConfigurationItemTypes';
          $service_li_action = "select";
          $service_li_params[0] = " sclm_configurationitemtypes_id_c='".$ltypes."' ";
          $service_li_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
          $service_li_params[2] = ""; // group;
          $service_li_params[3] = " name ASC, date_entered DESC "; // order;
          $service_li_params[4] = ""; // limit

          $service_li_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_li_object_type, $service_li_action, $service_li_params);
          $current_search = $funky_gear->object_returner ('ConfigurationItemTypes', $ltypes);
          $current_search_name = $current_search[0];

          $lifestyletypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_lifestyle&value=".$val."&ltypes=".$ltypes."&valuetype=".$valtype."');return false\"><font size=2 color=blue><B>".$current_search_name."</B></font></a> | ";

          if (is_array($service_li_items)){

             for ($lcnt=0;$lcnt < count($service_li_items);$lcnt++){

                 $id = $service_li_items[$lcnt]['id'];
                 $name = $service_li_items[$lcnt]['name'];

                 $lifestyletypes .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=search_lifestyle&value=".$val."&ltypes=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=blue><B>".$name."</B></font></a> | ";
   
                 } # for

             #$lifestyletypes .= "<BR><img src=images/blank.gif width=98% height=1><BR><div style=\"max-height:100px;width:98%;margin-left: auto;margin-right: auto;overflow:auto;\">".$lifestyleservicetypes."</div><BR><img src=images/blank.gif width=98% height=1><BR>";

             #$products_services_types .= "<div style=\"".$divstyle_white."\"><center><B>Lifestyle Services</B><BR>".$servicespack."</center></div>";

             } # is array

          } # lifestyle types

       $products_services_types = "<div>";
       $products_services_types .= "<div style=\"".$divstyle_white."\"><center><B>Items</B><BR>".$producttypes."</center></div>";
       $products_services_types .= "<div style=\"".$divstyle_white."\"><center><B>Services</B><BR>".$servicetypes."</center></div>";
       $products_services_types .= "<div style=\"".$divstyle_white."\"><center><B>Lifestyle Categories</B><BR>".$lifestyletypes."</center></div>";
       $products_services_types .= "</div>";

       } # is array


    $date = date("Y@m@d@G");
    $body_sendvars = $date."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

?>
<img src=images/blank.gif width=98% height=1>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="value" name="value" value="<?php echo $vale; ?>" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<img src=images/blank.gif width=98% height=1>
<?php

    echo "<center>".$products_services_types."</center>";

    $ci_object_type = 'Services';
    $ci_action = "select";

    $ci_params[0] = $object_return_params[0];
//    $ci_params[0] = " (sclm_services.id != sclm_accountsservices.sclm_services_id_c) && sclm_accountsservices.account_id_c != '".$account_id_c."' ";
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
//    $ci_params[3] = " service_tier, name, date_entered DESC "; // order;
    $ci_params[3] = " service_tier DESC, service_type ASC, sclm_services.name ASC, sclm_services.date_entered DESC "; // order;
    $ci_params[4] = ""; // limit
//    $ci_params[5] = "sclm_accountsservices"; // othertable
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 20;

       $navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

?>
<img src=images/blank.gif width=98% height=5>
<BR>
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
           $lifestyle_category = $ci_items[$cnt]['lifestyle_category'];

           // Get capacity of Engineers available for each service
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

           if ($sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c){
              $edit = "<a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>(".$strings["action_edit"].")</B></font></a> ";
              }

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

              $cis .= "<div style=\"".$divstyle_white."\"><div style=\"margin-left:0px;float:left;width:98%;height:60px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\"><div style=\"margin-left:0px;float:left;width:55px;height:55px;border-radius:0px;padding-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><img src=".$image." width=50 border=0></a></div><div style=\"margin-left:0px;float:left;width:80%;height:35px;border-radius:0px;padding-left:5px;padding-top:5px;padding-right:5px;padding-bottom:5px;\">".$tier."[".$parent_service_type_name." -> <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=search_stypes&value=".$service_type."&valuetype=ConfigurationItems');return false\">".$service_type_name."</a>]<BR>".$edit." <a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a><BR>Capacity: ".$service_capacity."".$sla_bundle."</div></div></div><BR><img src=images/blank.gif height=5 width=98%>";

//           $cis .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><img src=".$image." width=50 border=0></a> ".$edit."<BR>".$tier."[<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$parent_service_type."&valuetype=ConfigurationItems');return false\">".$parent_service_type_name." -></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$service_type."&valuetype=ConfigurationItems');return false\">".$service_type_name."</a>]<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$name."</B></a> [Capacity: ".$service_capacity."]".$sla_bundle."</div>";

           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL && $auth==3){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;

    #$this->funkydone ($_POST,$lingo,'Content','view','76bed5bc-ab35-7523-d01b-5240743cf4cd','Services',$bodywidth);

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
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $market_value = $ci_items[$cnt]['market_value'];
              $account_id_c = $ci_items[$cnt]['account_id_c'];
              $contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $parent_service_type = $ci_items[$cnt]['parent_service_type'];
              $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
              $service_type = $ci_items[$cnt]['service_type'];
              $service_type_name = $ci_items[$cnt]['service_type_name'];
              $service_tier = $ci_items[$cnt]['service_tier'];
              $image = $ci_items[$cnt]['image'];
              $lifestyle_category = $ci_items[$cnt]['lifestyle_category'];

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

    if ($contact_id_c == NULL){
       $contact_id_c = $sess_contact_id;
       }

    if ($account_id_c == NULL && $contact_id_c != NULL){
       $accid_object_type = "Contacts";
       $accid_action = "get_account_id";
       $accid_params[0] = $contact_id_c;
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

    if (!$image){
       $image = 'images/ServiceCatalog-Default.png'; 
       }

    if ($action == 'edit' || $action == 'add'){

       $tablefields[$tblcnt][0] = "image"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_gallery';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list';//$dropdown_table; // related table
 
       # Get content owned by this account

       #########################
       # Looper Content Wrapper

       $ci_object_type = 'Content';
       $ci_action = "select";
       $ci_params[0] = " account_id_c='".$sess_account_id."' && deleted=0 && content_type='1b7369c3-dd78-a8a3-2a79-523876ce70fe' && sclm_services_id_c='".$val."' ";
       $ci_params[1] = "id,name,deleted,account_id_c,content_url,content_thumbnail"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];

              #echo "ID: ".$id."<BR>";

              $name = $ci_items[$cnt]['name'];
              $content_url = $ci_items[$cnt]['content_url'];
              $content_thumbnail = $ci_items[$cnt]['content_thumbnail'];
              #$content_type = $ci_items[$cnt]['content_type'];
              #$description = $ci_items[$cnt]['description'];

              /*
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $account_id_c = $ci_items[$cnt]['account_id_c'];
              $contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $cmn_industries_id_c = $ci_items[$cnt]['cmn_industries_id_c'];
              $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
              $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
              $content_type_image = $ci_items[$cnt]['content_type_image'];
              $content_type_name = $ci_items[$cnt]['content_type_name'];
              $project_id_c = $ci_items[$cnt]['project_id_c'];
              $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
              $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
              $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
              $sclm_emails_id_c = $ci_items[$cnt]['sclm_emails_id_c'];
              $sclm_advisory_id_c = $ci_items[$cnt]['sclm_advisory_id_c'];
              $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];
              $sclm_servicesprices_id_c = $ci_items[$cnt]['sclm_servicesprices_id_c'];
              */

              $packbits[0] = $name; # Title
              $packbits[1] = $content_thumbnail; # Image
              $packbits[2] = $content_url; # Content
              if ($image == $content_url){
                 $checkstate = 1;
                 } else {
                 $checkstate = "";
                 }
              $packbits[3] = $checkstate;
              $packbits[4] = ""; # Details

              $ddpack[$id] = $packbits;

              } // for

          } // array

       $tablefields[$tblcnt][9][1] = $ddpack;
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";
       $tablefields[$tblcnt][9][5] = $image; // Current Value
       $tablefields[$tblcnt][9][6] = 'Content';
       $tablefields[$tblcnt][9][7] = 'Content';
       $tablefields[$tblcnt][9][10] = 'radio';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "image"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image; //$field_value;   

       /*
       $tablefields[$tblcnt][0] = "image"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'file_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       $file_pack[] = "No File";
       $file_pack[] = "No File again";

       $tablefields[$tblcnt][9][1] = $file_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $image; // Current Value
       $tablefields[$tblcnt][9][6] = '';
       $tablefields[$tblcnt][9][7] = 'images'; // list reltablename
       $tablefields[$tblcnt][9][8] = ''; //new do
       $tablefields[$tblcnt][9][9] = $image; // Current Value
//       $params['ci_data_type'] = $ci_data_type;
//       $params['ci_name_field'] = "name";
//       $params['ci_name'] = $name;
//       $tablefields[$tblcnt][9][10] = $params; // Various Params
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'image';//$field_value_id;
       $tablefields[$tblcnt][21] = $image; //$field_value;
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "image"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image; //$field_value;   

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
       */

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

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'lifestyle_category'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Category"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default


    if ($lifestyle_category != NULL){

       $cat_object_type = "ConfigurationItemTypes";
       $cat_action = "select";
       $cat_params[0] = " id='".$lifestyle_category."' ";
       $cat_params[1] = "sclm_configurationitemtypes_id_c"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $catpar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($catpar_items)){

          for ($catparcnt=0;$catparcnt < count($catpar_items);$catparcnt++){
 
              $cat_cit = $catpar_items[$catparcnt]['sclm_configurationitemtypes_id_c'];

              } # for

          $cat_object_type = "ConfigurationItemTypes";
          $cat_action = "select";
          $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$cat_cit."' ";
          $cat_params[1] = "id,name,description"; // select array
          $cat_params[2] = ""; // group;
          $cat_params[3] = "name ASC"; // order;
          $cat_params[4] = ""; // limit
  
          $cat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

          if (is_array($cat_items)){

             for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                 $cat_id = $cat_items[$cnt]['id'];
                 $cat = $cat_items[$cnt]['name'];
                 $cat_pack[$cat_id] = $cat;

                 } # for

             } # is array

          } # is array

       } else {# if cat

       $cat_cit = "a86cf661-d985-f7fc-3a72-5521d38a3700"; # Cats
 
       $cat_object_type = "ConfigurationItemTypes";
       $cat_action = "select";
       $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$cat_cit."' ";
       $cat_params[1] = "id,name,description"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $cat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($cat_items)){

          for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
              $cat_id = $cat_items[$cnt]['id'];
              $cat = $cat_items[$cnt]['name'];
              $cat_pack[$cat_id] = $cat;

              } # for

          } # for    


       } # end if not cat

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $cat_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $lifestyle_category; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Current Value
    $tablefields[$tblcnt][9][7] = "lifestyle_category"; // reltable
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $lifestyle_category; // Field ID
    $tablefields[$tblcnt][20] = "lifestyle_category"; //$field_value_id;
    $tablefields[$tblcnt][21] = $lifestyle_category; //$field_value;     

    $tblcnt++;

    $tablefields[$tblcnt][0] = "market_value"; // Field Name
    $tablefields[$tblcnt][1] = "Market Value"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'int';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "market_value"; //$field_value_id;
    $tablefields[$tblcnt][21] = $market_value; //$field_value;   

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
    $tablefields[$tblcnt][9][8] = 'ConfigurationItemTypes'; //new do
    $tablefields[$tblcnt][9][9] = $service_tier; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'service_tier';//$field_value_id;
    $tablefields[$tblcnt][21] = $service_tier; //$field_value;

/*
    if ($parent_service_type == NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'product_selection'; // Field Name
       $tablefields[$tblcnt][1] = "Product Type"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       #$tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9' ";//$exception;
       $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='a6e4ed9d-a63f-d23e-e787-54f82a7a4548' ";//$exception;
       $tablefields[$tblcnt][9][5] = $product_selection; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItemTypes';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Services'; //new do
       $tablefields[$tblcnt][9][9] = $product_selection; // Current Value
       #$extra_params['service_type'] = $service_type;
       #$tablefields[$tblcnt][9][10] = $extra_params; // Various Params
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'product_selection';//$field_value_id;
       $tablefields[$tblcnt][21] = $product_selection; //$field_value;

       }
*/
       /*

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'parent_service_type'; // Field Name
       $tablefields[$tblcnt][1] = "Parent Service Type"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       # Service Types: cabebb61-5bef-f61c-fd3d-51d18355ccdb
       # Product Types: 1dea7f68-6f6a-662f-fb43-54f829549bd9
       $tablefields[$tblcnt][9][4] = " (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL' ";//$exception;
       #$tablefields[$tblcnt][9][4] = " sclm_configurationitems_id_c='a6e4ed9d-a63f-d23e-e787-54f82a7a4548' ";//$exception;
       #$tablefields[$tblcnt][9][4] = "id='".$parent_service_type."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $parent_service_type; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Services'; //new do
       $tablefields[$tblcnt][9][9] = $parent_service_type; // Current Value
       $extra_params['service_type'] = $service_type;
       $tablefields[$tblcnt][9][10] = $extra_params; // Various Params
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'parent_service_type';//$field_value_id;
       $tablefields[$tblcnt][21] = $parent_service_type; //$field_value;
       */

    if ($action == 'view'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'parent_service_type'; // Field Name
    $tablefields[$tblcnt][1] = "Parent Service Type"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    if ($parent_service_type != NULL){

       $cat_object_type = "ConfigurationItems";
       $cat_action = "select";
       $cat_params[0] = " id='".$parent_service_type."' ";
       $cat_params[1] = "sclm_configurationitems_id_c"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $catpar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($catpar_items)){

          for ($catparcnt=0;$catparcnt < count($catpar_items);$catparcnt++){
 
              $cat_cit = $catpar_items[$catparcnt]['sclm_configurationitems_id_c'];

              } # for

          $cat_object_type = "ConfigurationItems";
          $cat_action = "select";
          $cat_params[0] = " deleted=0 && sclm_configurationitems_id_c='".$cat_cit."' ";
          $cat_params[1] = "id,name,description"; // select array
          $cat_params[2] = ""; // group;
          $cat_params[3] = "name ASC"; // order;
          $cat_params[4] = ""; // limit
  
          $scat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

          if (is_array($scat_items)){

             for ($scnt=0;$scnt < count($scat_items);$scnt++){
 
                 $scat_id = $scat_items[$scnt]['id'];
                 $scat = $scat_items[$scnt]['name'];
                 $scat_pack[$scat_id] = $scat;

                 } # for

             } # is array

          } # is array

       } else {# if cat

       $cat_object_type = "ConfigurationItems";
       $cat_action = "select";
       $cat_params[0] = " deleted=0 && (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL' ";
       $cat_params[1] = "id,name,description"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $scat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($scat_items)){

          for ($scnt=0;$scnt < count($scat_items);$scnt++){
 
              $scat_id = $scat_items[$scnt]['id'];
              $scat = $scat_items[$scnt]['name'];
              $scat_pack[$scat_id] = $scat;

              } # for

          } # for    

       } # end if not cat

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $scat_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $parent_service_type; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Current Value
    $tablefields[$tblcnt][9][7] = "parent_service_type"; // reltable
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $parent_service_type; // Field ID
    $tablefields[$tblcnt][20] = "parent_service_type"; //$field_value_id;
    $tablefields[$tblcnt][21] = $parent_service_type; //$field_value;     

    }

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'service_type'; // Field Name
    $tablefields[$tblcnt][1] = "Service Type"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    if ($service_type != NULL){

       $cat_object_type = "ConfigurationItems";
       $cat_action = "select";
       $cat_params[0] = " id='".$service_type."' ";
       $cat_params[1] = "sclm_configurationitems_id_c"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $catpar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($catpar_items)){

          for ($catparcnt=0;$catparcnt < count($catpar_items);$catparcnt++){
 
              $cat_cit = $catpar_items[$catparcnt]['sclm_configurationitems_id_c'];

              } # for

          $cat_object_type = "ConfigurationItems";
          $cat_action = "select";
          $cat_params[0] = " deleted=0 && sclm_configurationitems_id_c='".$cat_cit."' ";
          $cat_params[1] = "id,name,description"; // select array
          $cat_params[2] = ""; // group;
          $cat_params[3] = "name ASC"; // order;
          $cat_params[4] = ""; // limit
  
          $scat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

          if (is_array($scat_items)){

             for ($scnt=0;$scnt < count($scat_items);$scnt++){
 
                 $scat_id = $scat_items[$scnt]['id'];
                 $scat = $scat_items[$scnt]['name'];
                 $scat_pack[$scat_id] = $scat;

                 } # for

             } # is array

          } # is array

       } else {# if cat

       $cat_object_type = "ConfigurationItems";
       $cat_action = "select";
       $cat_params[0] = " deleted=0 && (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL' ";
       $cat_params[1] = "id,name,description"; // select array
       $cat_params[2] = ""; // group;
       $cat_params[3] = "name ASC"; // order;
       $cat_params[4] = ""; // limit
  
       $scat_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

       if (is_array($scat_items)){

          for ($scnt=0;$scnt < count($scat_items);$scnt++){
 
              $scat_id = $scat_items[$scnt]['id'];
              $scat = $scat_items[$scnt]['name'];
              $scat_pack[$scat_id] = $scat;

              } # for

          } # for    

       } # end if not cat

    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $scat_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $service_type; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Current Value
    $tablefields[$tblcnt][9][7] = "service_type"; // reltable
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $service_type; // Field ID
    $tablefields[$tblcnt][20] = "service_type"; //$field_value_id;
    $tablefields[$tblcnt][21] = $service_type; //$field_value;     

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

    if ($action == 'add' || $auth == 3){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "full_sla"; // Field Name
       $tablefields[$tblcnt][1] = "Create Full SLA Set?"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ''; // Field ID
       $tablefields[$tblcnt][20] = "full_sla"; //$field_value_id;
       $tablefields[$tblcnt][21] = $full_sla; //$field_value;   

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
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    if ($ci_account_id_c == $account_id_c || $auth==3){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } else {
       $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
       } 

    $valpack[5] = ""; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    #
    ###################
    # Check if Service SLAs exist

    if ($action != 'list'){

       $servsla_object_type = 'ServicesSLA';
       $servsla_action = "select";
       $servsla_params[0] = "sclm_services_id_c='".$val."' ";
       $servsla_params[1] = "id,name"; // select array
       $servsla_params[2] = ""; // group;
       $servsla_params[3] = " name, date_entered DESC "; // order;
       $servsla_params[4] = ""; // limit
  
       $servsla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $servsla_object_type, $servsla_action, $servsla_params);

       $slas_exist = FALSE;

       if (is_array($servsla_items)){
          $slas_exist = TRUE;
          }

      } # if not list

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
    $container_params[3] = 'Products & Services'; // container_title
    $container_params[4] = 'Service'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];


    if ($valtype != 'AccountsServices' && $action != 'add' && $sess_account_id != NULL){

       $accserv_object_type = 'AccountsServices';
       $accserv_action = "select";
       $accserv_params[0] = " account_id_c='".$sess_account_id."' && sclm_services_id_c='".$val."' ";
       $accserv_params[1] = ""; // select array
       $accserv_params[2] = ""; // group;
       $accserv_params[3] = ""; // order;
       $accserv_params[4] = ""; // limit
  
       $accserv_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accserv_object_type, $accserv_action, $accserv_params);

       if (is_array($accserv_items)){

          # Do nothing - exists

          } elseif ($sess_account_id != NULL && $slas_exist == TRUE) {
          
          echo "<center><img src=images/ServiceCatalogFlows-AddingToCatalog-".$lingo.".png></center>";
          echo "<BR><img src=images/blank.gif width=98% height=15><BR>";
          echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServices&action=add&value=".$val."&valuetype=".$do."');return false\" class=\"css3button\"><B>".$strings["CatalogServicesAddTo"]."</B></a></center>";
          echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

          }

       }

    echo $container_top;
  
    if (($action == 'edit' || $action == 'view') && $image != NULL){
       echo "<BR><img src=".$image." width=200><BR>"; 
       }

    echo $zaform;

    if ($action == 'view' || $action == 'edit'){

       $params = array();
       $params[0] = $name;
       echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

       }

    echo $container_bottom;

    #
    ###################

    if ($action == 'view' || $action == 'edit'){ 

       ###################
       # Content

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

       # Content
       ###################
       # Service SLA(s)

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Service SLA(s)'; // container_title
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

       $this->funkydone ($_POST,$lingo,'ServicesSLA','list',$val,$do,$bodywidth);       

       echo $container_bottom;

       } # if view/edit

    #
    ###################
    # Only show if there are actual SLAs for this service..

    if ($slas_exist == TRUE){

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Service Prices'; // container_title
       $container_params[4] = 'ServicesPrices'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'ServicesPrices','list',$val,$do,$bodywidth);

       echo $container_bottom;

       #
       ###################
       #

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Partner Services'; // container_title
       $container_params[4] = 'AccountsServices'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       #$container = $funky_gear->make_container ($container_params);

       #$container_top = $container[0];
       #$container_middle = $container[1];
       #$container_bottom = $container[2];

       #echo $container_middle;

       $this->funkydone ($_POST,$lingo,'AccountsServices','list',$val,$do,$bodywidth);

       #echo $container_bottom;

       } # if Service SLAs
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
    $container_params[3] = 'Available Resources'; // container_title
    $container_params[4] = 'ContactsServicesSLA'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_middle;

    $this->funkydone ($_POST,$lingo,'ContactsServicesSLA','list',$val,$do,$bodywidth);

    echo $container_bottom;
*/

    #
    ###################

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
       $process_params[] = array('name'=>'image','value' => $_POST['image']);
       $process_params[] = array('name'=>'assigned_user_id','value' => 1);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'market_value','value' => $_POST['market_value']);
       $process_params[] = array('name'=>'parent_service_type','value' => $_POST['parent_service_type']);
       $process_params[] = array('name'=>'service_type','value' => $_POST['service_type']);
       $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);
       $process_params[] = array('name'=>'lifestyle_category','value' => $_POST['lifestyle_category']);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       if ($_POST['full_sla'] != NULL){

          $process_object_type = "ServicesSLA";
          $process_action = "update";

          $sla_title = $_POST['name']." - Initial Response (Email, Ticket) - 8x5x1";
          $sla_descr = $sla_title;
          $sla = 'a10cda45-5257-d759-17f5-523fbd588bf4';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Initial Response (Email, Ticket) - 24x7x1";
          $sla_descr = $sla_title;
          $sla = 'f1b55bea-1820-72d6-4f9c-5241b4f39b9a';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Initial Response (Phone,Chat) - 8x5x1";
          $sla_descr = $sla_title;
          $sla = '718b7b4c-a592-2bb4-ac1b-5236ea2f9404';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Initial Response (Phone,Chat) - 24x7x1";
          $sla_descr = $sla_title;
          $sla = '483324ea-cf5b-7266-c6b4-5241b4a0eb22';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution - Before escalation to Tier 2 (20 minutes)";
          $sla_descr = $sla_title;
          $sla = '88cc5a3d-9068-0dcc-230d-523fc63048cd';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 1 hour (8x5x1)";
          $sla_descr = $sla_title;
          $sla = '55c5edf5-2b78-8895-cfc0-523fcae78262';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 1 hour (24x7x1)";
          $sla_descr = $sla_title;
          $sla = '84907c78-9c29-a4e1-d0f7-523fcac6dd50';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 2 hours (8x5x2)";
          $sla_descr = $sla_title;
          $sla = '2a98137b-1b18-836d-f857-523fc94e72ce';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 2 hours (24x7x2)";
          $sla_descr = $sla_title;
          $sla = '1df572a9-72c9-93e1-840b-523fca9c4c18';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 4 hours (8x5x4)";
          $sla_descr = $sla_title;
          $sla = '59b2c8f2-79a1-99de-1564-523fc9749fb1';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 4 hours (24x7x4)";
          $sla_descr = $sla_title;
          $sla = '67627773-e200-019b-9a3b-523fca0a1d95';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 8 hours (8x5x8)";
          $sla_descr = $sla_title;
          $sla = '622a0bc8-49e4-1672-4a45-523fc9249003';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Resolution within 8 hours (24x7x8)";
          $sla_descr = $sla_title;
          $sla = '1687b6be-1e50-536c-2437-523fcaa240b6';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          $sla_title = $_POST['name']." - Next Business Day Resolution during Local Business Hours (8x5xNBD)";
          $sla_descr = $sla_title;
          $sla = 'a0bc1cee-0032-363b-1eca-523fc80b9796';

          $process_params = array();
          $process_params[] = array('name'=>'name','value' => $sla_title);
          $process_params[] = array('name'=>'assigned_user_id','value' => 1);
          $process_params[] = array('name'=>'description','value' => $sla_descr);
          $process_params[] = array('name'=>'sclm_services_id_c','value' => $val);
          $process_params[] = array('name'=>'sclm_sla_id_c','value' => $sla);
          $process_params[] = array('name'=>'service_tier','value' => $_POST['service_tier']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          } // if do sla

       $process_message = $strings["SubmissionSuccess"]."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";

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