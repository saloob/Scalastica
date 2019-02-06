<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-09-20
# Page: ServicesPrices.php 
##########################################################
# case 'ServicesPrices':

  if ($valtype == 'ConfigurationItems'){
     $object_return_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && (parent_service_type='".$val."' || service_type='".$val."') " ;
     }

  if ($valtype == 'Services'){
     $sclm_services_id_c = $val;
     }

  if ($valtype == 'AccountsServices'){

     $sclm_accountsservices_id_c = $val;

     $ci_object_type = 'AccountsServices';
     $ci_action = "select";
     $ci_params[0] = " id='".$val."' "; // select array
     $ci_params[1] = "sclm_services_id_c,account_id_c"; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = ""; // order;
     $ci_params[4] = ""; // limit
  
     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($ci_items)){

        #var_dump($ci_items);

        for ($cnt=0;$cnt < count($ci_items);$cnt++){

            $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
            $accservice_owner_id = $ci_items[$cnt]['account_id_c'];

            } # for

        $object_return_params[0] = " deleted=0 && sclm_services_id_c='".$sclm_services_id_c."' " ;

        } # is array

     } # if valtype

    #######################
    # Need to check allowed pricing partners
    # 1) If Related Partner
    # 2) If can share partner pricing
    # Allow the AccountService owner to provide pricing

    #echo "accservice_owner_id $accservice_owner_id";
    /*
    if ($sess_account_id != NULL){
       $check_acc_id = $sess_account_id;
       } else {
       $check_acc_id = $portal_account_id;
       }
    */

    if ($portal_account_id != NULL){

       $ci_object_type = "AccountRelationships";
       $ci_action = "select";
       $ci_params[1] = "parent_account_id='".$portal_account_id."' ";
       $ci_params[1] = "id,account_id_c,account_id1_c"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';
          $shared_account_cit = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $acc_rel_id = $ci_items[$cnt]['id'];
              $child_account_id = $ci_items[$cnt]['child_account_id'];

              # Get Accounts Sharing Set
              $cis_object_type = "ConfigurationItems";
              $cis_action = "select";
              # Check if this acc allowed to share prices
              $cis_params[0] = " sclm_configurationitemtypes_id_c='".$acc_sharing_set."' && name='".$acc_rel_id."' ";
              $cis_params[1] = "id"; // select array
              $cis_params[2] = ""; // group;
              $cis_params[3] = ""; // order;
              $cis_params[4] = ""; // limit 

              $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

              if (is_array($cis_list)){

                 for ($ciscnt=0;$ciscnt < count($cis_list);$ciscnt++){

                     $cis_id = $cis_list[$ciscnt]['id'];

                     $cis_acc_object_type = "ConfigurationItems";
                     $cis_acc_action = "select";
                     $cis_acc_params[0] = " sclm_configurationitems_id_c='".$cis_id."' && sclm_configurationitemtypes_id_c='".$shared_account_cit."' ";
                     $cis_acc_params[1] = "id"; // select array
                     $cis_acc_params[2] = ""; // group;
                     $cis_acc_params[3] = ""; // order;
                     $cis_acc_params[4] = ""; // limit
  
                     $cis_acc_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_acc_object_type, $cis_acc_action, $cis_acc_params);

                     if (is_array($cis_acc_list)){

                        $acc_shared_type_pricing = '58a896be-c277-844b-f051-54ebedac5dd4'; # Shared Partner Pricing (Within own portal) 

                        for ($cntcisacc=0;$cntcisacc < count($cis_acc_list);$cntcisacc++){
 
                            $cis_acc_id = $cis_acc_list[$cntcisacc]['id'];

                            $cis_object_type = "ConfigurationItems";
                            $cis_action = "select";
                            $cis_params[0] = " sclm_configurationitems_id_c='".$cis_acc_id."' ";
                            $cis_params[1] = "sclm_configurationitemtypes_id_c";
                            $cis_params[2] = ""; // group;
                            $cis_params[3] = "sclm_configurationitemtypes_id_c ASC"; // order;
                            $cis_params[4] = ""; // limit
  
                            $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

                            if (is_array($cis_list)){

                               for ($ciscnt=0;$ciscnt < count($cis_list);$ciscnt++){

                                   $acc_sharebit_configurationitemtypes_id_c = $cis_list[$ciscnt]['sclm_configurationitemtypes_id_c'];

                                   if ($acc_sharebit_configurationitemtypes_id_c == $acc_shared_type_pricing){

                                      if (!in_array($child_account_id,$allowed_accounts_arr)){
                                         $allowed_accounts_arr[] = $child_account_id;
                                         }

                                      } # if

                                   } # for
  
                               } # is array

                            } # for
 
                        } # is array

                     } # for

                 } # is array

              } // end for
      
          } # is array

       } # if accservice_owner_id

  if (is_array($allowed_accounts_arr)){

     $allowed_accs = count($allowed_accounts_arr);
     $allcount = 0;

     $relaccquery = " && (account_id_c='".$portal_account_id."' ";

     if ($accservice_owner_id != NULL){
        $relaccquery = " || account_id_c='".$accservice_owner_id."' ";
        }

     foreach ($allowed_accounts_arr as $allkey=>$child_acc_id){

             if ($allcount == 0 && $allowed_accs>1){
                $relaccquery .= "|| account_id_c='".$child_acc_id."' ";
                } elseif ($allowed_accs==1){
                $relaccquery .= "|| account_id_c='".$child_acc_id."' )";
                } elseif (($allcount == $allowed_accs-1) && $allowed_accs>1) {
                $relaccquery .= "|| account_id_c='".$child_acc_id."' )";
                } else {
                $relaccquery .= "|| account_id_c='".$child_acc_id."' ";
                }

             $allcount++;

             } # foreach

     } elseif ($portal_account_id != NULL){

     if ($accservice_owner_id != NULL){
        $relaccquery = " && (account_id_c='".$portal_account_id."' || account_id_c='".$accservice_owner_id."') ";
        } else {
        $relaccquery = " && account_id_c='".$portal_account_id."' ";
        } 

     } 

    #echo "<P>Extra Allowed Accs: ".$relaccquery."<P>";

    $object_return_params[0] .= $relaccquery;

    # End check allowed pricing partners
    #######################

  if ($valtype == 'SLA'){
     $sclm_sla_id_c = $val;
     }


  if ($_SESSION['ProjectTasks']){
     $project_task = $_SESSION['ProjectTask'];
     $returner = $funky_gear->object_returner ('ProjectTasks', $project_task);
     $object_return = $returner[1];
     echo $object_return;
     }

  if ($_SESSION['Project']){
     $project_id = $_SESSION['Project'];
     $returner = $funky_gear->object_returner ('Projects', $project_id);
     $object_return = $returner[1];
     echo $object_return;
     }

  /*
  if ($valtype != 'Services'){
     echo "<div style=\"".$divstyle_grey."\"><center><font color=#151B54 size=4><B>".$strings["ServicesPrices"]."</B></font></center></div>";
     }
  */

  switch ($action){
   
   case 'list':
   
    ################################
    # List
    
    $ci_object_type = 'ServicesPrices';
    $ci_action = "select";

    #echo "Auth: ".$auth."<P>";

    switch ($auth){

     case '':
      #$object_return_params[0] .= " && account_id_c='XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX' ";
     break;
     case 1:
      #$object_return_params[0] .= " && account_id_c='".$sess_account_id."' ";
     break;
     case 2:
      #$object_return_params[0] .= " && account_id_c='".$sess_account_id."' ";
     break;
     case 3:
      #$object_return_params[0] .= " account_id_c='".$sess_account_id."' ";
     break;

    } // auth switch


    #echo $object_return_params[0];

    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " sclm_services_id_c,sclm_servicessla_id_c,cmn_currencies_id_c,cmn_countries_id_c,cmn_languages_id_c,name, date_entered DESC ";
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $full_count = count($ci_items);
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
           $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
           $cmn_currencies_id_c = $ci_items[$cnt]['cmn_currencies_id_c'];
           $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
           $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
           $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
           $credits = $ci_items[$cnt]['credits'];

           $credit_params[0] = $credits;
           $credit_params[1] = $cmn_currencies_id_c;
           $credit_params[2] = $ci_account_id_c;
           $credits_pack = $funky_gear->creditisor ($credit_params);

           $credit_value = $credits_pack[0];
           $provider_share = $credits_pack[1];
           $partner_share = $credits_pack[2];
           $currency_name = $credits_pack[3];
           $iso_code = $credits_pack[4];
           $currency_country = $credits_pack[5];
           $timezone = $ci_items[$cnt]['timezone'];

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

           $total_credits = $total_credits+$credit_value;

           // Get capacity of Engineers available for each service
/*
           $service_capacity = 0;

           $capacity_object_type = "ContactsServicesSLA";
           $capacity_action = "select";
           $capacity_params[0] = " sclm_servicessla_id_c='".$id."' ";
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
           $edit = "";

           if ($sess_account_id != NULL && $ci_account_id_c != NULL && $sess_account_id==$ci_account_id_c && $auth>1){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$do."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           if ($sess_account_id == $portal_account_id){

              $acc_returner = $funky_gear->object_returner("Accounts",$ci_account_id_c);
              #$provider_name = $acc_returner[3];
              $provider_link = $acc_returner[3]." -> ";

              # Provide a quick link to establish a relationship with this account if none yet

              $accrel_object_type = "AccountRelationships";
              $accrel_action = "select";
              $accrel_params[0] = " account_id_c='".$sess_account_id."' && account_id1_c='".$ci_account_id_c."' ";
              $accrel_params[1] = "id,name,date_entered,account_id_c,account_id1_c,entity_type"; // select array
              $accrel_params[2] = ""; // group;
              $accrel_params[3] = " name, date_entered DESC "; // order;
              $accrel_params[4] = ""; // limit
  
              $accrel_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accrel_object_type, $accrel_action, $accrel_params);

              if (is_array($accrel_items)){              

                 $provider_link .= "[Already Partner] -> ";
   
                 } else { # is array

                 $provider_link .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountRelationships&action=add&value=".$ci_account_id_c."&valuetype=".$do."');return false\"><font size=2 color=red><B>[Make Partner]</font></B></a> -> ";
   
                 }

              } # if portal owner

           $sendmessage = "";

           if ($ci_contact_id_c != NULL && $sess_contact_id != NULL){
              $agent_returner = $funky_gear->object_returner("Contacts",$ci_contact_id_c);
              $agent_name = $agent_returner[0];

              $sendmessage = "<BR>Contact this provider: <a href=\"#Top\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=Messages&action=add&value=".$ci_contact_id_c."&valuetype=Contacts&sendiv=light&related=ServicesPrices&relval=".$id."');document.getElementById('fade').style.display='block';loader('contactdiv');doRPOSTRequest('contactdiv','Body.php','pc=".$portalcode."&do=Contacts&action=view&value=".$ci_contact_id_c."&valuetype=Contacts');return false\"><img src=images/icons/MessagesIcon-100x100.png width=16 alt='".$strings["Message"]."'>".$agent_name."</a> ";

              }


//           $cis .= "<div style=\"".$divstyle_white."\">".$edit." [<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$parent_service_type_id."&valuetype=ConfigurationItems');return false\">".$parent_service_type_name." -></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Services&action=list&value=".$service_type_id."&valuetype=ConfigurationItems');return false\">".$service_type_name."</a>] <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a> [Capacity: ".$service_capacity."]</div>";

           if ($sess_account_id != NULL && $valtype == 'AccountsServices'){
              $request = "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=add&value=".$id."&valuetype=".$do."&sourcevaltype=".$valtype."&sourceval=".$val."');return false\"><font color=red><B>Request this SLA</B></font></a> ";
              } elseif ($sess_account_id != NULL){
              $request = "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServiceSLARequests&action=add&value=".$id."&valuetype=".$do."&sourcevaltype=".$valtype."&sourceval=".$val."');return false\"><font color=red><B>Request this SLA</B></font></a> ";
              }

          switch ($auth){

           case 1:
            #$object_return_params[0] .= " account_id_c='".$sess_account_id."' ";
            #$account_namer = $funky_gear->object_returner ('Accounts', $ci_account_id_c);
            #$account_name = $account_namer[1];
            #$account_name = $account_name." -> ";
           break;
           case 2:
            #$object_return_params[0] .= " account_id_c='".$sess_account_id."' ";
            #$account_namer = $funky_gear->object_returner ('Accounts', $ci_account_id_c);
            #$account_name = $account_namer[1];
            #$account_name = $account_name." -> ";
           break;
           case 3:
            #$object_return_params[0] .= " account_id_c='".$sess_account_id."' ";
            #$account_namer = $funky_gear->object_returner ('Accounts', $ci_account_id_c);
            #$account_name = $account_namer[0];
            #$account_name = $account_name." -> ";

           break;

          } // auth switch


           $cis .= "<div style=\"".$divstyle_white."\">".$edit." ".$provider_link."<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$do."');return false\"><B>".$account_name.$name."</B></a>".$show_value.$request." ".$sendmessage."</div>";

           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }

    if ($sess_contact_id != NULL && $auth > 1){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }

    if ($sess_contact_id == NULL){
       echo "<div style=\"".$divstyle_orange."\">".$strings["ServicesPrices_RequireLogin"]."</div>";
       }

    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;

    if ($auth==3){
    
       $totalfees = "Total Count: ".$full_count."<BR>";
       $totalfees .= "Total Credits: ".$total_credits."<BR>";
       $average = number_format($total_credits/$full_count);
       $totalfees .= "Average Credits: ".$average."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$totalfees."</div>";

       }

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
              $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
              $cmn_currencies_id_c = $ci_items[$cnt]['cmn_currencies_id_c'];
              $cmn_countries_id_c = $ci_items[$cnt]['cmn_countries_id_c'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $sclm_servicessla_id_c = $ci_items[$cnt]['sclm_servicessla_id_c'];
              $cmn_languages_id_c = $ci_items[$cnt]['cmn_languages_id_c'];
              $credits = $ci_items[$cnt]['credits'];
              $timezone = $ci_items[$cnt]['timezone'];

              } // end for

          if ($valtype == 'ServicesPrices'){
             $returner = $funky_gear->object_returner ('Services', $sclm_services_id_c);
             $object_return = $returner[1];
             }

          } // is array

       } // if action


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

    if ($action == 'view'){

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

    }

    if ($action == 'edit' ||$action == 'view'){

       $credit_params[0] = $credits;
       $credit_params[1] = $cmn_currencies_id_c;
       $credit_params[2] = $ci_account_id_c;
       $credits_pack = $funky_gear->creditisor ($credit_params);

       #var_dump($credits_pack);

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

       #$show_value = ": ".$show_value;

       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = "credits"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Credits"]; // Full Name
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
    $tablefields[$tblcnt][20] = "credits"; //$field_value_id;
    $tablefields[$tblcnt][21] = $credits; //$field_value;  

    /*

    if ($action == 'add' ||$action == 'edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'credits'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Credits"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       for ($list=1;$list < 9001;$list++){
    
           $creditlistpack[$list] = $list;

           }

       $tablefields[$tblcnt][9][1] = $creditlistpack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $credits; // Current Value

       $tablefields[$tblcnt][9][7] = "credits"; // list reltablename
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'credits';//$field_value_id;
       $tablefields[$tblcnt][21] = $credits; //$field_value;

       $cmn_countries_id_c = "";

       }

    */

    if ($action == 'add'){

       $cmn_countries_id_c = "";

       }

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_countries_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Country"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
//    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_countries'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " name IS NOT NULL ORDER BY name ";//$exception;
    $tablefields[$tblcnt][9][5] = $cmn_countries_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Countries';
    $tablefields[$tblcnt][9][7] = "cmn_countries"; // list reltablename
//    $tablefields[$tblcnt][9][8] = 'Countries'; //new do
//    $tablefields[$tblcnt][9][9] = $cmn_countries_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_countries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_countries_id_c; //$field_value;

    if ($action == 'edit'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "cmn_currencies_id_c"; // Field Name
       $tablefields[$tblcnt][1] = "ID"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmn_currencies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $cmn_currencies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Countries';
       $tablefields[$tblcnt][9][7] = "cmn_countries"; // list reltablename
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "cmn_currencies_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmn_currencies_id_c; //$field_value;   

       }

    if ($action == 'edit' && $timezone != NULL && $cmn_countries_id_c != NULL){

       $tz_pack = $funky_gear->get_timezones($cmn_countries_id_c);

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'timezone'; // Field Name
       $tablefields[$tblcnt][1] = "Timezone"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $tz_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = " cmn_countries_id_c='".$cmn_countries_id_c."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $timezone; // Current Value
       $tablefields[$tblcnt][9][9] = $timezone; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'timezone';//$field_value_id;
       $tablefields[$tblcnt][21] = $timezone; //$field_value;

       }

    if ($action == 'add' || $action == 'edit'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_services_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Service"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
//    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
/*
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_services'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_services_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Services';
    $tablefields[$tblcnt][9][7] = "sclm_services"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Services'; //new do
*/
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_services_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;

    } else {

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_services_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Service"]; // Full Name
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
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_services_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Services';
    $tablefields[$tblcnt][9][7] = "sclm_services"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Services'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_services_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_services_id_c; //$field_value;

    } 

    #echo "sclm_servicessla_id_c $sclm_servicessla_id_c <P>";

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_servicessla_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ServiceSLA"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
//    $tablefields[$tblcnt][9][1] = 'sclm_servicessla,sclm_servicesprices'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][1] = 'sclm_servicessla'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($action == 'add'){

       $tablefields[$tblcnt][9][4] = " id='".$sclm_servicessla_id_c."' ";

       #$tablefields[$tblcnt][9][4] = " sclm_servicessla.sclm_services_id_c='".$sclm_services_id_c."' AND NOT (sclm_servicesprices.sclm_servicessla_id_c = sclm_servicessla.id && sclm_servicessla.sclm_services_id_c='".$sclm_services_id_c."' && sclm_servicesprices.sclm_services_id_c='".$sclm_services_id_c."' && sclm_servicesprices.account_id_c='".$sess_account_id_c."') && sclm_servicessla.cmn_statuses_id_c != '".$standard_statuses_closed."' ";

       #$tablefields[$tblcnt][9][4] = " sclm_servicessla.sclm_services_id_c='".$sclm_services_id_c."' AND sclm_servicessla.account_id_c='".$sess_account_id_c."' AND (sclm_servicessla.sclm_services_id_c IS NOT sclm_servicessla.sclm_services_id_c) ";
       #$tablefields[$tblcnt][9][4] = " sclm_servicessla.sclm_services_id_c='".$sclm_services_id_c."' ";
 
       } elseif ($action == 'edit'){

       $tablefields[$tblcnt][9][4] = " id='".$sclm_servicessla_id_c."' ";

       } 

    #$tablefields[$tblcnt][9][4] = " sclm_servicesprices.sclm_services_id_c='".$sclm_services_id_c."' ";
    $tablefields[$tblcnt][9][5] = $sclm_servicessla_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ServicesSLA';
    $tablefields[$tblcnt][9][7] = "sclm_servicessla"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ServicesSLA'; //new do
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_servicessla_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_servicessla_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_languages_id_c'; // Field Name
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
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " approved=1 ";//$exception;
    $tablefields[$tblcnt][9][5] = $cmn_languages_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_languages_id_c; //$field_value;

    if ($action == 'view'){

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
       #$tablefields[$tblcnt][9][4] = " id='".$sess_account_id."' "; // exception
       $tablefields[$tblcnt][9][5] = $ci_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   

       if ($auth >= 3 || $sess_account_id == $ci_account_id_c){

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
          $tablefields[$tblcnt][9][4] = " accounts_contacts.contact_id=contacts.id && accounts_contacts.account_id='".$sess_account_id."' "; // exception
          $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
          $tablefields[$tblcnt][9][6] = 'Contacts';
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
          $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

          } // if auth

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
    $tablefields[$tblcnt][12] = "60"; // Field ID
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    if ($sess_account_id != NULL && $ci_account_id_c != NULL && $sess_account_id==$ci_account_id_c && $auth>1){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       }
    $valpack[5] = ""; // provide add new button

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
    $container_params[3] = 'Service Price'; // container_title
    $container_params[4] = 'ServicePrice'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $object_return;

    if ($action == 'edit' || $action == 'view' && $sess_contact_id != NULL){
   
       echo "<BR><img src=images/blank.gif width=200 height=15><BR>";

       echo "<center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ServicesPrices&action=add&value=".$sclm_services_id_c."&valuetype=Services');return false\" class=\"css3button\"><B>Set New Service SLA Pricing</B></a></center>";

       echo "<BR><img src=images/blank.gif width=200 height=5><BR>";

       }

    echo $container_top;
  
    echo $zaform;

    #echo $show_value;

    echo $container_bottom;

    #
    ###################
    #

    ###################
    #

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Related SLAs'; // container_title
       $container_params[4] = 'SLAs'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,'ServicesSLA','list',$sclm_services_id_c,"Services",$bodywidth);

    #
    ###################

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

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'ServicesPrices','list',$sclm_services_id_c,"Services",$bodywidth);

    #
    ###################
    #

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Partner Services'; // container_title
       $container_params[4] = 'PartnerServices'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'AccountsServices','list',$sclm_services_id_c,"Services",$bodywidth);

       echo $container_bottom;

    #
    ###################
    #


       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Available Resources'; // container_title
       $container_params[4] = 'ContactsServicesSLA'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

//       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

//       echo $container_top;

//       $this->funkydone ($_POST,$lingo,'ContactsServicesSLA','list',$val,$do,$bodywidth);

//       echo $container_bottom;

    #
    ###################
    #


   break; // end view
   case 'process':

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if (!$_POST['credits']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Credits"]."</font><P>";
       }   

    if (!$_POST['sclm_services_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Service"]."</font><P>";
       }   

    if (!$_POST['cmn_countries_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Country"]."</font><P>";
       }   

    if (!$_POST['sclm_servicessla_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["ServiceSLA"]."</font><P>";
       }   

    if (!$_POST['cmn_languages_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["ServiceSLA"]."</font><P>";
       }   

    if (!$error){

       
//       $service_returner = $funky_gear->object_returner ('Services', $_POST['sclm_services_id_c']);
//       $service_name = $service_returner[0];

       $accounts_returner = $funky_gear->object_returner ('Accounts', $_POST['account_id_c']);
       #$accounts_name = $accounts_returner[0];
       #$this_name = $accounts_name;

       $servicesla_returner = $funky_gear->object_returner ('ServicesSLA', $_POST['sclm_servicessla_id_c']);
       $servicesla_name = $servicesla_returner[0];
       #$this_name = $this_name." -> ".$servicesla_name;
       $this_name = $servicesla_name;

       $country_returner = $funky_gear->object_returner ('Countries', $_POST['cmn_countries_id_c']);
       $country_name = $country_returner[0];
       $this_name = $this_name." -> ".$country_name;

       $timezone = $_POST['timezone'];
       $this_name = $this_name." -> ".$timezone;

       $language_returner = $funky_gear->object_returner ('Languages', $_POST['cmn_languages_id_c']);
       $language_name = $language_returner[0];
       $this_name = $this_name." -> ".$language_name;

       //$partner_credit_value = 2500*.85;
       //$creditvalue = number_format($_POST['credits']*$partner_credit_value);

       $currency_returner = $funky_gear->object_returner ('Currencies', $_POST['cmn_currencies_id_c']);
       $currency_name = $currency_returner[0];
//       $this_name = $this_name." -> ".$currency_name." ".$creditvalue;
       $this_name = $this_name." -> ".$currency_name;

       #$credit_params[0] = $_POST['credits'];
       #$credit_params[1] = $_POST['cmn_currencies_id_c'];
       #$credits_pack = $funky_gear->creditisor ($credit_params);

       #$credit_value = $credits_pack[0];
       #$provider_share = $credits_pack[1];
       #$partner_share = $credits_pack[2];
       #$currency_name = $credits_pack[3];
       #$iso_code = $credits_pack[4];
       #$currency_country = $credits_pack[5];

       $credit_value = $_POST['credits'];
       $show_credit_value = number_format($credit_value);
       $this_name = $this_name." -> ".$show_credit_value;

       /*
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
       */

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $this_name);
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       if (!$_POST['description']){
          $process_params[] = array('name'=>'description','value' => $this_name);
          $description = $this_name;
          } else {
          $process_params[] = array('name'=>'description','value' => $_POST['description']);
          $description = $_POST['description'];
          } 
       $process_params[] = array('name'=>'sclm_services_id_c','value' => $_POST['sclm_services_id_c']);
       $process_params[] = array('name'=>'cmn_currencies_id_c','value' => $_POST['cmn_currencies_id_c']);
       $process_params[] = array('name'=>'timezone','value' => $_POST['timezone']);
       $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_servicessla_id_c','value' => $_POST['sclm_servicessla_id_c']);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);
       $process_params[] = array('name'=>'credits','value' => $_POST['credits']);

//var_dump($process_params);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       $process_message = $do." submission was a success! Please review <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."');return false\">here!</a><P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$this_name."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$description."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>
