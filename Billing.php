<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-01-05
# Page: Billing.php 
##########################################################
# case 'Billing':

   $sendiv = $_POST['sendiv'];
   if ($sendiv == NULL){
      $sendiv = $_GET['sendiv'];
      if ($sendiv != NULL){
         $BodyDIV = $sendiv;
         }
      }

   $today_date = date('Y-m-d H:i:s');

   $this_year = date('Y');
   $this_day = date('d');
   $this_month = date('m');

   $last_month = $this_month-1;
   if ($last_month == 0){
      $last_month = 12;
      $last_year = $this_year-1;
      $last_month_full = $last_year."-".$last_month;
      } else {

      if ($last_month<10){
         $last_month = "0".$last_month;
         }

      $last_month_full = $this_year."-".$last_month;
      }

   $last_year = $this_year-1;

   $this_month_full = date('Y')."-".$this_month;

   $this_month_last_year = $last_year."-".$this_month;

   $this_day_last_year = $last_year."-".$this_month."-".$this_day;
   $this_day_last_month = $this_year."-".$last_month."-".$this_day;

   for ($yrcnt=0;$yrcnt < 5;$yrcnt++){
       $billing_year = $this_year-$yrcnt;
       // echo "Billing Year: ".$billing_year;
       }

   $today_plus_one = date('Y-m-d', strtotime($date .' +1 day'));

   $template_block = "<div style='width:100;'></div>";
   $billing_body = str_replace($template_block,"[BLOCK]",$billing_body);

   # singlebyte strings
   # $result = substr($myStr, 0, 5);
   # multibyte strings
   # $result = mb_substr($myStr, 0, 5);

   function get_thirdcond ($thirdcond_in){
 
    #echo "Third IN: ".$thirdcond_in."<P>";

    $thirdcond = substr($thirdcond_in, 0, 4); // ONLY
    if ($thirdcond != 'ONLY'){
       $thirdcond = substr($thirdcond_in, 0, 6); //ANDNOT
       if ($thirdcond != 'ANDNOT'){
          $thirdcond = substr($thirdcond_in, 0, 3); //AND
          }
       }

    #echo "Third OUT: ".$thirdcond."<P>";

    return $thirdcond;

   }

   $tickets_filter = " && deleted = 0";

   $status = $_POST['status'];

   if ($status != NULL){

      #echo "Status: ".$status."<P>";
      #exit;

      list ($firstcond,$secondcond,$thirdcond) = explode ("_",$status);

      #echo "First: ".$firstcond. " && Second: ".$secondcond." && Third: ".$thirdcond."<P>";
      #exit;

      $thirdcond_a = get_thirdcond ($thirdcond);

      #echo "Third Condition: ".$thirdcond_a."<P>";
      #exit;

      if ($firstcond == 'ISALL'){

         # Do nothing
         #$tickets_filter .= "";

         } elseif ($firstcond == 'IS'){

         if ($thirdcond_a == 'ONLY'){

            $tickets_filter .= " && status = '".$secondcond."' ";

            } elseif ($thirdcond_a == 'AND'){
              # Check to see what third consists of
              # $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_AND[]320138e7-3fe4-727e-8bac-52802c62a4b6[]ONLY']= "IS Closed AND In-progress";
              list ($firstcond_b,$secondcond_b,$thirdcond_b) = explode ("[]",$thirdcond);
              $thirdcond_c = get_thirdcond ($thirdcond_b);
              if ($thirdcond_c == 'ONLY'){
                 $tickets_filter .= " && status = '".$secondcond."' && status = '".$secondcond_b."' ";
                 } elseif ($thirdcond_c == 'AND'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status = '".$secondcond."' && status = '".$secondcond_b."' && status = '".$secondcond_c."' ";
                 } elseif ($thirdcond_c == 'ANDNOT'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status = '".$secondcond."' && status = '".$secondcond_b."' && status != '".$secondcond_c."' ";
                 }

            # close AND
            } elseif ($thirdcond_a == 'ANDNOT'){

              # Check to see what third consists of
              # $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_AND[]320138e7-3fe4-727e-8bac-52802c62a4b6[]ONLY']= "IS Closed AND In-progress";
              list ($firstcond_b,$secondcond_b,$thirdcond_b) = explode ("[]",$thirdcond);
              $thirdcond_c = get_thirdcond ($thirdcond_b);
              if ($thirdcond_c == 'ONLY'){
                 $tickets_filter .= " && status = '".$secondcond."' && status != '".$secondcond_b."' ";
                 } elseif ($thirdcond_c == 'AND'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status = '".$secondcond."' && status != '".$secondcond_b."' && status = '".$secondcond_c."' ";
                 } elseif ($thirdcond_c == 'ANDNOT'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status = '".$secondcond."' && status != '".$secondcond_b."' && status != '".$secondcond_c."' ";
                 }

            } # close ANDNOT

         # close IS
         } elseif ($firstcond == 'ISNOT'){

         # $ddpack['ISNOT_bbed903c-c79a-00a6-00fe-52802db36ba9_ONLY']= "IS NOT Closed";
         if ($thirdcond_a == 'ONLY'){

            $tickets_filter .= " && status != '".$secondcond."' ";

            } elseif ($thirdcond_a == 'AND'){
              # Check to see what third consists of
              # $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_AND[]320138e7-3fe4-727e-8bac-52802c62a4b6[]ONLY']= "IS Closed AND In-progress";
              list ($firstcond_b,$secondcond_b,$thirdcond_b) = explode ("[]",$thirdcond);
              $thirdcond_c = get_thirdcond ($thirdcond_b);
              if ($thirdcond_c == 'ONLY'){
                 $tickets_filter .= " && status != '".$secondcond."' && status = '".$secondcond_b."' ";
                 } elseif ($thirdcond_c == 'AND'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status != '".$secondcond."' && status = '".$secondcond_b."' && status = '".$secondcond_c."' ";
                 } elseif ($thirdcond_c == 'ANDNOT'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status != '".$secondcond."' && status = '".$secondcond_b."' && status != '".$secondcond_c."' ";
                 }

            # close AND
            } elseif ($thirdcond_a == 'ANDNOT'){

              # Check to see what third consists of
              # $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_AND[]320138e7-3fe4-727e-8bac-52802c62a4b6[]ONLY']= "IS Closed AND In-progress";
              list ($firstcond_b,$secondcond_b,$thirdcond_b) = explode ("[]",$thirdcond);

              #echo "First: ".$firstcond_b. " && Second: ".$secondcond_b." && Third: ".$thirdcond_b."<P>";
              #exit;

              $thirdcond_c = get_thirdcond ($thirdcond_b);

              if ($thirdcond_c == 'ONLY'){
                 $tickets_filter .= " && status != '".$secondcond."' && status != '".$secondcond_b."' ";
                 } elseif ($thirdcond_c == 'AND'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status != '".$secondcond."' && status != '".$secondcond_b."' && status = '".$secondcond_c."' ";
                 } elseif ($thirdcond_c == 'ANDNOT'){
                 list ($firstcond_c,$secondcond_c,$thirdcond_c) = explode ("#",$thirdcond_b);
                 $tickets_filter .= " && status != '".$secondcond."' && status != '".$secondcond_b."' && status != '".$secondcond_c."' ";
                 }

            } # close ANDNOT

         } # close ISNOT

      # echo "Filter: ".$tickets_filter."<P>";
      #exit;

      } else {

      # Use as default if no status is sent
      $tick_status_cancelled = '72b33850-b4b0-c679-f988-52c2eb40a5de';
      $tick_status_open = 'e47fc565-c045-fef9-ef4f-52802bfc479c';
      $ignorestatuses[] = $tick_status_cancelled;
      $ignorestatuses[] = $tick_status_open;
      $status = "ISNOT_e47fc565-c045-fef9-ef4f-52802bfc479c_ANDNOT[]72b33850-b4b0-c679-f988-52c2eb40a5de[]ONLY"; # "IS NOT Open AND IS NOT Cancelled
      $tickets_filter .= " && (status != '".$tick_status_cancelled."' && status != '".$tick_status_open."' )"; 

      }
   
   ########################
   # 1: Check existing Service SLA Requests for tickets
   # 2: Select tickets for inclusion in billing
   # 3: Build Invoice based on Templates and (1) and (2)

   $zaform = "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$strings["Billing"]."</B></font></center></div>";
   $zaform .= "<BR><img src=images/blank.gif width=90% height=5><BR>";
   $zaform .= "<BR><center><img src=images/icons/Accounting.png width=150></center><BR>";
   $zaform .= "<BR><img src=images/blank.gif width=90% height=5><BR>";

   $zaform .= "<center>
<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$last_month_full."&valuetype=bydate&sendiv=".$BodyDIV."');return false\"><font size=3><B>".$last_month_full."</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=".$this_month_full."&valuetype=bydate&sendiv=".$BodyDIV."');return false\"><font size=3><B>".$this_month_full."</B></font></a></center><P>";

  $zaform .= "<div style=\"".$divstyle_white."\"><center>For billing purposes, it is recommended to not include tickets with the following statuses:<BR><B>Cancelled, Open Un-claimed</B></center></div>";

  # Start form objects

  if ($_POST['account_id1_c']){
     $selected_provider = $_POST['account_id1_c'];
     }

   $tblcnt = 0;

   if ($valtype == 'bydate'){
      $searchdate_from = $val;
      $searchdate_to = date('l', strtotime($searchdate_from .' +28 days'));
      }

   if ($_POST['date_from']){
      $searchdate_from = $_POST['date_from'];
      } else {
      if ($last_month == 12){
         $use_year = $this_year-1;
         } else {
         $use_year = $this_year;
         }
     # $searchdate_from = $use_year."-".$last_month."-26 00:00:00";
      $searchdate_from = $use_year."-".$last_month."-26";
      }

   if ($_POST['date_to']){
      $searchdate_to = $_POST['date_to'];
      } else {
      # $searchdate_to = $this_year."-".$this_month."-25 59:59:59";
      $searchdate_to = $this_year."-".$this_month."-26";
      }

   $tablefields[$tblcnt][0] = "date_from"; // Field Name
   $tablefields[$tblcnt][1] = "Date From"; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '10'; // length
   $tablefields[$tblcnt][7] = '0'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = $searchdate_from; // Field ID
   $tablefields[$tblcnt][12] = '10'; // object length
   $tablefields[$tblcnt][20] = "date_from"; //$field_value_id;
   $tablefields[$tblcnt][21] = $searchdate_from; //$field_value; 

   $tblcnt++;

   $tablefields[$tblcnt][0] = "date_to"; // Field Name
   $tablefields[$tblcnt][1] = "Date To"; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '10'; // length
   $tablefields[$tblcnt][7] = '0'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = $searchdate_to; // Field ID
   $tablefields[$tblcnt][12] = '10'; // object length
   $tablefields[$tblcnt][20] = "date_to"; //$field_value_id;
   $tablefields[$tblcnt][21] = $searchdate_to; //$field_value; 

   $tblcnt++;

   $sdm_confirmed = $_POST['sdm_confirmed'];
   if (!$sdm_confirmed){
      $sdm_confirmed = "";
      }

   $tablefields[$tblcnt][0] = "sdm_confirmed"; // Field Name
   $tablefields[$tblcnt][1] = "SDM Confirmed?"; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '30'; // length
   $tablefields[$tblcnt][7] = '0'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = $sdm_confirmed; // Field ID
   $tablefields[$tblcnt][20] = "sdm_confirmed"; //$field_value_id;
   $tablefields[$tblcnt][21] = $sdm_confirmed; //$field_value;

   $tblcnt++;

   $download = $_POST['download'];
   if (!$download){
      $download = "";
      }

   $tablefields[$tblcnt][0] = "download"; // Field Name
   $tablefields[$tblcnt][1] = "Download?"; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '30'; // length
   $tablefields[$tblcnt][7] = '0'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = $download; // Field ID
   $tablefields[$tblcnt][20] = "download"; //$field_value_id;
   $tablefields[$tblcnt][21] = $download; //$field_value;  

   $tblcnt++;

   $tablefields[$tblcnt][0] = "sendiv"; // Field Name
   $tablefields[$tblcnt][1] = #$strings["date"]; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '30'; // length
   $tablefields[$tblcnt][7] = '0'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
   $tablefields[$tblcnt][10] = '';//1; // show in view 
   $tablefields[$tblcnt][11] = $BodyDIV; // Field ID
   $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
   $tablefields[$tblcnt][21] = $BodyDIV; //$field_value; 

   $acc_object_type = "AccountRelationships";
   $acc_action = "select";
   $acc_params[0] = " account_id_c='".$sess_account_id."' ";
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

          } // end for

      } // end if array
  
   $acc_object_type = "AccountRelationships";
   $acc_action = "select";
   $acc_params[0] = " account_id1_c='".$sess_account_id."' ";
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

          } // end for

      } // end if array

   $acc_returner = $funky_gear->object_returner ("Accounts", $sess_account_id);
   $object_return_name = $acc_returner[0];
   $ddpack[$account_id_c]=$object_return_name;

   $tblcnt++;

   $tablefields[$tblcnt][0] = 'account_id_c'; // Field Name
   $tablefields[$tblcnt][1] = $strings["AccountTypeCustomer"]; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '255'; // length
   $tablefields[$tblcnt][7] = ''; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default

   if ($security_role == $role_SDM){

      $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
      $tablefields[$tblcnt][9][1] = $ddpack;
      $tablefields[$tblcnt][9][2] = 'id';
      $tablefields[$tblcnt][9][3] = 'name';
      $tablefields[$tblcnt][9][4] = "";
      $tablefields[$tblcnt][9][5] = $sess_account_id; // Current Value
      $tablefields[$tblcnt][9][6] = 'Accounts';
      } else {
      $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
      $tablefields[$tblcnt][9][1] = 'accounts';
      $tablefields[$tblcnt][9][2] = 'id';
      $tablefields[$tblcnt][9][3] = 'name';
      $tablefields[$tblcnt][9][4] = " id='".$sess_account_id."' ";
      $tablefields[$tblcnt][9][5] = $sess_account_id; // Current Value
      $tablefields[$tblcnt][9][6] = 'Accounts';
      } 

   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = ""; // Field ID
   $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
   $tablefields[$tblcnt][21] = $sess_account_id; //$field_value;   

   $tblcnt++;

   $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
   $tablefields[$tblcnt][1] = $strings["AccountServiceProvider"]; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '255'; // length
   $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
   $tablefields[$tblcnt][9][1] = $ddpack; // If DB, dropdown_table, if List, then array, other related table    
   $tablefields[$tblcnt][9][2] = 'id';
   $tablefields[$tblcnt][9][3] = 'name';
   $tablefields[$tblcnt][9][4] = ""; // Exceptions
   $tablefields[$tblcnt][9][5] = $selected_provider; // Current Value
   $tablefields[$tblcnt][9][6] = "";
   $tablefields[$tblcnt][9][7] = "";
   $tablefields[$tblcnt][9][8] = "";
   $tablefields[$tblcnt][9][9] = "";
   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = ''; // Field ID
   $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
   $tablefields[$tblcnt][21] = $selected_provider; //$field_value;

   ####################################
   # Get Providers for billing purposes
/*
   $ci_object_type = 'Ticketing';
   $ci_action = "select";

   if ($auth==3){
      $ci_params[0] = " deleted=0 ";
      } else {
      $ci_params[0] = " deleted=0 && account_id_c='".$sess_account_id."' && account_id1_c != '' && account_id1_c != 'NULL' && account_id1_c != '".$sess_account_id."' ".$tickets_filter;
      }

   $ci_params[1] = "id,name,account_id_c,account_id1_c,status"; // select array
   $ci_params[2] = "account_id1_c"; // group;
   $ci_params[3] = " date_entered DESC ";
   $ci_params[4] = ""; // limit

   $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

   if (is_array($ci_items)){

      for ($cnt=0;$cnt < count($ci_items);$cnt++){

          $provider_id = $ci_items[$cnt]['account_id1_c'];
          $provider_return = $funky_gear->object_returner ("Accounts", $provider_id);
          $provider_name = $provider_return[0];
          $providers[$provider_id] = $provider_name;

          } // end for

      } // end if is array

   if (is_array($providers)){

      $cnt = 0;

      foreach ($providers as $provider_id=>$provider){

              if ($cnt == 0){
                 $providersql = " (id='".$provider_id."' ";
                 } else {
                 $providersql .= " || id='".$provider_id."' ";
                 } 

              $cnt++;

              } // foreach

      $providersql = $providersql.")";

      $tblcnt++;

      $tablefields[$tblcnt][0] = 'account_id1_c'; // Field Name
      $tablefields[$tblcnt][1] = $strings["AccountServiceProvider"]; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
      $tablefields[$tblcnt][9][1] = 'accounts'; // If DB, dropdown_table, if List, then array, other related table    
      $tablefields[$tblcnt][9][2] = 'id';
      $tablefields[$tblcnt][9][3] = 'name';
      $tablefields[$tblcnt][9][4] = $providersql; // Exceptions
      $tablefields[$tblcnt][9][5] = ""; // Current Value
      $tablefields[$tblcnt][9][6] = "";
      $tablefields[$tblcnt][9][7] = "";
      $tablefields[$tblcnt][9][8] = "";
      $tablefields[$tblcnt][9][9] = "";
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = ''; // Field ID
      $tablefields[$tblcnt][20] = 'account_id1_c';//$field_value_id;
      $tablefields[$tblcnt][21] = ""; //$field_value;

      } // is providers
   # End getting Providers
*/

   # Provide list of status options

   $tblcnt++;

   $ddpack = "";

   $ddpack['ISALL_BLAH_ONLY']= "IS ALL";
   $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_ONLY']= "IS Closed";
   $ddpack['IS_320138e7-3fe4-727e-8bac-52802c62a4b6_ONLY']= "IS In-progress";
   $ddpack['IS_b0f00652-47aa-5a8e-74fb-52802e7fc3ec_ONLY']= "IS In-progress - SLA Warning";
   $ddpack['IS_e47fc565-c045-fef9-ef4f-52802bfc479c_ONLY']= "IS Open - Unclaimed";
   $ddpack['IS_e3307ebb-6255-505c-99b2-52802c68ec75_ONLY']= "IS Pending";
   $ddpack['IS_4e5ce2e0-8a86-8473-df52-52802cb14285_ONLY']= "IS Problem-Frozen";
   $ddpack['IS_ed0606e3-b8fe-1ff3-253d-52802daea6af_ONLY']= "IS Revisit";
   $ddpack['IS_72b33850-b4b0-c679-f988-52c2eb40a5de_ONLY']= "IS Cancelled";
   $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_AND[]320138e7-3fe4-727e-8bac-52802c62a4b6[]ONLY']= "IS Closed AND In-progress";
   $ddpack['ISNOT_bbed903c-c79a-00a6-00fe-52802db36ba9_ONLY']= "IS NOT Closed";
   $ddpack['ISNOT_e47fc565-c045-fef9-ef4f-52802bfc479c_ANDNOT[]72b33850-b4b0-c679-f988-52c2eb40a5de[]ONLY']= "IS NOT Open AND IS NOT Cancelled";
   $ddpack['IS_bbed903c-c79a-00a6-00fe-52802db36ba9_ANDNOT[]e3307ebb-6255-505c-99b2-52802c68ec75[]ANDNOT#320138e7-3fe4-727e-8bac-52802c62a4b6#ONLY']= "IS Closed AND NOT Pending AND NOT In-progress";
   $ddpack['ISNOT_bbed903c-c79a-00a6-00fe-52802db36ba9_ANDNOT[]72b33850-b4b0-c679-f988-52c2eb40a5de[]ONLY']= "IS NOT Closed AND NOT Cancelled";
   $ddpack['ISNOT_bbed903c-c79a-00a6-00fe-52802db36ba9_ANDNOT[]72b33850-b4b0-c679-f988-52c2eb40a5de[]ANDNOT#e3307ebb-6255-505c-99b2-52802c68ec75#ONLY']= "IS NOT Closed AND NOT Cancelled AND NOT Pending";

   $tablefields[$tblcnt][0] = 'status'; // Field Name
   $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
   $tablefields[$tblcnt][2] = 0; // is_primary
   $tablefields[$tblcnt][3] = 0; // is_autoincrement
   $tablefields[$tblcnt][4] = 0; // is_name
   $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
   $tablefields[$tblcnt][6] = '255'; // length
   $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
   $tablefields[$tblcnt][8] = ''; // default
   $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
   $tablefields[$tblcnt][9][1] = $ddpack; // If DB, dropdown_table, if List, then array, other related table    
   $tablefields[$tblcnt][9][2] = 'id';
   $tablefields[$tblcnt][9][3] = 'name';
   $tablefields[$tblcnt][9][4] = ""; // Exceptions
   $tablefields[$tblcnt][9][5] = $status; // Current Value
   $tablefields[$tblcnt][9][6] = "";
   $tablefields[$tblcnt][9][7] = "";
   $tablefields[$tblcnt][9][8] = "";
   $tablefields[$tblcnt][9][9] = "";
   $tablefields[$tblcnt][10] = '1';//1; // show in view 
   $tablefields[$tblcnt][11] = ''; // Field ID
   $tablefields[$tblcnt][20] = 'status';//$field_value_id;
   $tablefields[$tblcnt][21] = $status; //$field_value;

   $valpack = "";
   $valpack[0] = 'Billing';
   $valpack[1] = 'search'; //
   $valpack[2] = $valtype;
   $valpack[3] = $tablefields;
   $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
   $valpack[5] = "";
   $valpack[6] = "";
   $valpack[7] = "Search";
   #$valpack[8] = "";
   #$valpack[9] = $BodyDIV;

   #$zaform = "";
   $zaform .= $funky_gear->form_presentation($valpack);

   #echo "<P>".$zaform;
   #echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
   #echo "<div style=\"".$divstyle_orange."\">".$strings["ServiceSLARequestMessage"]."</div>";

  if (!$val){
     $val = $this_month_full;
     }

  $sent_account_id = $_POST['account_id_c'];

  if ($sent_account_id){
     $customer_account_id = $sent_account_id;
     } elseif ($sess_account_id) {
     $customer_account_id = $sess_account_id;
     } else {
     $customer_account_id = $account_id;
     }

  if ($customer_account_id != NULL && $customer_account_id != 'NULL'){

     $tickets_filter .= " && account_id_c='".$customer_account_id."' ";

     $object_type = "Accounts";
     $acc_action = "select";
     $accparams[0] = "id='".$customer_account_id."' ";
     $accparams[1] = ""; // select
     $accparams[2] = ""; // group;
     $accparams[3] = ""; // order;
     $accparams[4] = ""; // limit

     $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $acc_action, $accparams);

     if (is_array($account_info)){
      
        for ($cnt=0;$cnt < count($account_info);$cnt++){

            $customer_account_name = $account_info[$cnt]['name'];
            $customer_phone_office = $account_info[$cnt]['phone_office'];
            $customer_website = $account_info[$cnt]['website'];
            $customer_phone_fax = $account_info[$cnt]['phone_fax'];
            $customer_billing_address_street = $account_info[$cnt]['billing_address_street'];
            $customer_billing_address_city = $account_info[$cnt]['billing_address_city'];
            $customer_billing_address_state = $account_info[$cnt]['billing_address_state'];
            $customer_billing_address_postalcode = $account_info[$cnt]['billing_address_postalcode'];
            #$provider_description = $account_info[$cnt]['description'];

           } // for     

        } // is array 

     } // if account

  if ($selected_provider != NULL && $selected_provider != 'NULL'){
 
     $tickets_filter .= " && account_id1_c='".$selected_provider."' ";

     $object_type = "Accounts";
     $acc_action = "select";
     $accparams[0] = "id='".$selected_provider."' ";
     $accparams[1] = ""; // select
     $accparams[2] = ""; // group;
     $accparams[3] = ""; // order;
     $accparams[4] = ""; // limit

     $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $acc_action, $accparams);

     if (is_array($account_info)){
      
        for ($cnt=0;$cnt < count($account_info);$cnt++){

            $provider_account_name = $account_info[$cnt]['name'];
            $provider_phone_office = $account_info[$cnt]['phone_office'];
            $provider_website = $account_info[$cnt]['website'];
            $provider_phone_fax = $account_info[$cnt]['phone_fax'];
            $provider_billing_address_street = $account_info[$cnt]['billing_address_street'];
            $provider_billing_address_city = $account_info[$cnt]['billing_address_city'];
            $provider_billing_address_state = $account_info[$cnt]['billing_address_state'];
            $provider_billing_address_postalcode = $account_info[$cnt]['billing_address_postalcode'];
            #$provider_description = $account_info[$cnt]['description'];

           } // for     

        } // is array 

     } else {// if account
     #$tickets_filter .= " && account_id1_c IS NULL ";
     } 

  if ($_POST['date_from']){

     $selected_date_from = $_POST['date_from'];
     $zaform .= "<P><center><B>Selected From Date: ".$selected_date_from."</B><P>";

     }

  if ($_POST['date_to']){

     $selected_date_to = $_POST['date_to'];
     $zaform .= "<P><center><B>Selected To Date: ".$selected_date_to."</B><P>";

     }

  if ($selected_date_from != NULL && $selected_date_to != NULL){
     #$selected_date_from = date('Y-m-d H:i:s', strtotime($selected_date_from));
     #$selected_date_to = date('Y-m-d H:i:s', strtotime($selected_date_to . ' + 1 day'));
     #$selected_date_to = date('Y-m-d H:i:s', strtotime($selected_date_to));
     # DATE_FORMAT($selected_date_to,'%Y-%m-%d %H:%i:%S');
     $tickets_filter .= " && (date_entered >= '".$selected_date_from."' && date_entered <= '".$selected_date_to."') ";
     #$tickets_filter .= " && (DATE_FORMAT(date_entered,'%Y-%m-%d %H:%i:%S') >= '".$selected_date_from."' && DATE_FORMAT(date_entered,'%Y-%m-%d %H:%i:%S') <= '".$selected_date_to."') ";
     #$tickets_filter .= " && (date_entered BETWEEN '".$selected_date_from."' AND '".$selected_date_to."') ";
     $title_daytext_from = date('d', strtotime($selected_date_from))." (".date('D', strtotime($selected_date_from)).")";
     $title_monthtext_from = date('F', strtotime($selected_date_from));
     $title_yeartext_from = date('Y', strtotime($selected_date_from));

     $title_daytext_to = date('d', strtotime($selected_date_to))." (".date('D', strtotime($selected_date_to)).")";
     $title_monthtext_to = date('F', strtotime($selected_date_to));
     $title_yeartext_to = date('Y', strtotime($selected_date_to));
     $title_monthyeartext = $title_daytext_from." ".$title_monthtext_from." ".$title_yeartext_from." to ".$title_daytext_to." ".$title_monthtext_to." ".$title_yeartext_to;

     } elseif ($selected_date_from != NULL && $selected_date_to == NULL){
     #$tickets_filter .= " && (date_entered >= $selected_date_from && date_entered <= $selected_date_to) ";
     $tickets_filter .= " && date_entered LIKE '%".$selected_date_from."%' ";
     $title_monthtext_from = date('F', strtotime($selected_date_from));
     $title_yeartext_from = date('Y', strtotime($selected_date_from));
     $title_monthyeartext = $title_monthtext_from." ".$title_yeartext_from;
     }

  $divstyle_params[0] = "285px"; // minwidth
  $divstyle_params[1] = "20px"; // minheight
  $divstyle_params[2] = "0px"; // margin_left
  $divstyle_params[3] = "2px"; // margin_right
  $divstyle_params[4] = "4px"; // padding_left
  $divstyle_params[5] = "2px"; // padding_right
  $divstyle_params[6] = "0px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "5px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom
  $divstyle_params[10] = "#FFFFFF"; // custom_color_back
  $divstyle_params[11] = "#d3d3d3"; // custom_color_border
  $divstyle_params[12] = "left"; // custom_float
  $divstyle_params[13] = $divstyle_params[0]; // maxwidth

  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $billstyle_tickets = $divstyle[5];

  $divstyle_params[0] = "60px"; // minwidth
  $divstyle_params[13] = $divstyle_params[0]; // maxwidth
  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $billstyle_price = $divstyle[5];
  $billstyle_quantity = $divstyle[5];
  $billstyle_sum = $divstyle[5];
  $divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $billstyle_total = $divstyle[5];

  $divstyle_params[0] = "425px"; // minwidth
  $divstyle_params[13] = $divstyle_params[0]; // maxwidth
  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $billstyle_total_label = $divstyle[5];

  $divstyle_params[0] = "245px"; // minwidth
  $divstyle_params[10] = "#e6ebf8 50% 50% repeat-x"; // custom_color_back
  $divstyle_params[13] = $divstyle_params[0]; // maxwidth
  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $billstyle_account_details = $divstyle[5];

  function convert_to_csv($input_array, $output_file_name, $delimiter){
    /** open raw memory as file, no need for temp files */
    $temp_memory = fopen('php://memory', 'w');
    /** loop through array  */
    foreach ($input_array as $line) {
        /** default php csv handler **/
        fputcsv($temp_memory, $line, $delimiter);
    }
    /** rewrind the "file" with the csv lines **/
    fseek($temp_memory, 0);
    /** modify header to be downloadable csv file **/
    header('Content-Type: application/csv');
    header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
    /** Send file to browser for download */
    fpassthru($temp_memory);

    }

  #######################
  # Do Licensing

  function get_licenses ($lic_params){

    global $funky_gear,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$lingoname,$strings,$divstyle_blue,$billstyle_price,$billstyle_sum,$billstyle_quantity,$billstyle_tickets;

    $sdm_confirmed = $lic_params[0];


  } # do lics

  # Do Licensing
  #######################
  # Spin Tickets

  function spin_tickets ($tick_params){

    global $funky_gear,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$lingoname,$strings,$divstyle_blue,$billstyle_price,$billstyle_sum,$billstyle_quantity,$billstyle_tickets;

    $sdm_confirmed = $tick_params[0];
    $sclm_serviceslarequests_id_c = $tick_params[1];
    $sclm_serviceslarequests_name = $tick_params[2];
    $price = $tick_params[3];
    $tickets_filter = $tick_params[4];
    $selected_provider = $tick_params[5];
    $stats = $tick_params[6];
    $csv = $tick_params[7];
    $serviceslarequests_total = $tick_params[8];
    $serviceslarequests_show = $tick_params[9];
    $provider_account_name = $tick_params[10];

    if ($sdm_confirmed == 1){
       $sdm_confirmed = "sdm_confirmed=1 && ";
       }

    if ($sclm_serviceslarequests_id_c != ""){

       $tickets_params[0] = $sdm_confirmed."sclm_serviceslarequests_id_c='".$sclm_serviceslarequests_id_c."' ".$tickets_filter;

       $serviceslarequests_show .= "<div style=\"".$divstyle_blue."\"><B>".$strings["ServiceSLARequest"].":</B> ".$sclm_serviceslarequests_name."</div><div style=\"".$billstyle_tickets."\"><B>Service</B></div><div style=\"".$billstyle_price."\"><center>Price</center></div><div style=\"".$billstyle_quantity."\"><center>Quantity</center></div><div style=\"".$billstyle_sum."\"><center>Sum</center></div>";

       } else {

       $tickets_params[0] = $sdm_confirmed."sclm_serviceslarequests_id_c ='' ".$tickets_filter;

       $serviceslarequests_show .= "<div style=\"".$divstyle_blue."\"><B>".$strings["ServiceSLARequest"].":</B> EMPTY</div><div style=\"".$billstyle_tickets."\"><B>Service</B></div><div style=\"".$billstyle_price."\"><center>Price</center></div><div style=\"".$billstyle_quantity."\"><center>Quantity</center></div><div style=\"".$billstyle_sum."\"><center>Sum</center></div>";

       } # end if SLA query

    #echo "<P>Full query: ".$tickets_params[0]."<P>";

    $tickets_object_type = "Ticketing";
    $tickets_action = "select";

    $tickets_params[1] = "id,sdm_confirmed,sclm_serviceslarequests_id_c,account_id_c,account_id1_c,ticket_id,name,status,date_entered,billing_count"; // select array
    $tickets_params[2] = ""; // group;
    $tickets_params[3] = " date_entered DESC "; // order;
    $tickets_params[4] = ""; // limit
    $tickets_params[5] = $lingoname; // limit
  
    $tickets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $tickets_object_type, $tickets_action, $tickets_params);
    $tickets_show = "";

    if (is_array($tickets)){

       $serviceslarequests_total = "";

       for ($cntactkt=0;$cntactkt < count($tickets);$cntactkt++){

           $tick_id = $tickets[$cntactkt]['id'];
           $ticket_id = $tickets[$cntactkt]['ticket_id'];
           $account_id1_c = $tickets[$cntactkt]['account_id1_c'];
           if ($account_id1_c != NULL && $selected_provider == 'NULL'){
              $provider_returner = $funky_gear->object_returner ("Accounts", $account_id1_c);
              $provider = $provider_returner[0];
              } elseif ($account_id1_c == NULL && $selected_provider == 'NULL'){
              $provider = "EMPTY";
              } elseif ($selected_provider != 'NULL') {
              $provider = $provider_account_name;
              } 

           $ticket_date = $tickets[$cntactkt]['date_entered'];
           #$ticket_date = date('Y-m-d H:i:s', strtotime($ticket_date));
           $day = date('l', strtotime($ticket_date));
           $stats[$day]++;

           $ticket_name = $tickets[$cntactkt]['name'];
           $ticket_status = $tickets[$cntactkt]['status'];
           $status_image = $tickets[$cntactkt]['status_image']; 
           $billing_count = $tickets[$cntactkt]['billing_count']; 
           $status_image = "<img src=".$status_image." width=16>";

           if (!$billing_count){
              $billing_count=1;
              }

           $servicesum = $price*$billing_count;

           $tickets_show .= "<div style=\"".$billstyle_tickets."\">".$status_image." [".$ticket_date."][".$ticket_id."] <B>".$ticket_name."</B></div><div style=\"".$billstyle_price."\"><center>\\".number_format($price)."</center></div><div style=\"".$billstyle_quantity."\"><center>".$billing_count."</center></div><div style=\"".$billstyle_sum."\"><center>\\".number_format($servicesum)."</center></div>";

           if ($_POST['download']){

              switch ($ticket_status){

               case 'bbed903c-c79a-00a6-00fe-52802db36ba9': //closed

                $show_status = "CLOSED";

               break;
               case '320138e7-3fe4-727e-8bac-52802c62a4b6': //In-progress

                $show_status = "IN_PROGRESS";

               break;
               case 'b0f00652-47aa-5a8e-74fb-52802e7fc3ec': //In-progress - SLA Warning

                $show_status = "IN_PROGRESS_SLA_WARNING";

               break;
               case 'NULL':
               case '':
               case 'e47fc565-c045-fef9-ef4f-52802bfc479c': //Open - Unclaimed

                $show_status = "OPEN_UNCLAIMED";

               break;
               case 'e3307ebb-6255-505c-99b2-52802c68ec75': //Pending

                $show_status = "PENDING";

               break;
               case '4e5ce2e0-8a86-8473-df52-52802cb14285': //Problem-Frozen
      
                $show_status = "PROBLEM_FROZEN";

               break;
               case 'ed0606e3-b8fe-1ff3-253d-52802daea6af': //Revisit

                $show_status = "REVISITING";

               break;
               case '72b33850-b4b0-c679-f988-52c2eb40a5de': //Cancelled

                $show_status = "CANCELLED";

               break;

              } // end status switch

              # Currently outputs directly to screen - want to push out to a browser
              #$csv[] = Array($ticket_id,$ticket_date,$ticket_name,$show_status,$billing_count,$price,$servicesum);
              $csv .= "\"$ticket_id\",\"$ticket_date\",\"$ticket_name\",\"$show_status\",\"$name\",\"$provider\",\"$billing_count\",\"$price\",\"$servicesum\"\n";

              } # end csv download

           } // end for tickets

       $serviceslarequests_total = $serviceslarequests_total + $servicesum;
       $serviceslarequests_show .= $tickets_show."<div style=\"".$billstyle_total_label."\"><B>".$name." Total</B></div><div style=\"".$billstyle_total."\"><center><B>\\".number_format($serviceslarequests_total)."</B></center></div>";

       } // is array

   $tick_results[0] = $stats;
   $tick_results[1] = $csv;
   $tick_results[2] = $serviceslarequests_total;
   $tick_results[3] = $serviceslarequests_show;

   return $tick_results;

   } # end spin ticktes

  # End Spin Tickets
  #######################

  $sdm_confirmed = $POST['sdm_confirmed'];

  # Present licensing - as Billing valtype

  #$this->funkydone ($_POST,$lingo,'Licensing','list',$customer_account_id,$do,$bodywidth);

  #######################
  # Present Invoices - as Billing valtype
  # Add tweaks later to customise the filtering and viewing

  #$package[0] = 1; # purpose = auto
  #$package[1] = $customer_account_id; # account_id
  #$package[2] = ""; # sla_req_id
  #$funky_gear->do_invoices ($package);

  # End invoices
  #######################

  switch ($action){
   
   case 'list':

    echo "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Orders</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    # List Orders | CIT: 39bf5057-c37f-086f-12b3-5712c42f3e93

    echo "<div style=\"".$divstyle_orange_light."\">Orders are created automatically every month based on your or your parent's set invoice day. Orders include licenses payable to your parent.</div>";

    echo "<div style=\"".$divstyle_blue."\" name='orders' id='orders'></div>";

    ############################
    # Gather
 
    $orders_cit = '39bf5057-c37f-086f-12b3-5712c42f3e93';

    $ord_object_type = "ConfigurationItems";
    $ord_action = "select";
    $ord_params[0] = " sclm_configurationitemtypes_id_c='".$orders_cit."' ";
    $ord_params[1] = "id,enabled,name,image_url,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; # select
    $ord_params[2] = ""; // group;
    $ord_params[3] = ""; // order;
    $ord_params[4] = ""; // limit
   
    $ord_array = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ord_object_type, $ord_action, $ord_params);
   
    if (is_array($sch_array)){
   
       for ($ord_cnt=0;$ord_cnt < count($ord_params);$ord_cnt++){

           $ord_id = $ord_params[$ord_cnt]['id']; # Instance ID
           $ord_title = $ord_params[$ord_cnt]['name']; # Service SLA ID
           $ord_contents = $ord_params[$ord_cnt]['description']; 

           $sch_sla_returner = $funky_gear->object_returner ("ServicesSLA", $sch_service_sla_id);
           $sch_service_sla_name = $sch_sla_returner[0];

           # Add Edit..
           $orders .= "<div style=\"".$divstyle_white."\">".$ord_title."</div>";

           } # for

       # is array    
       } else {

       $orders = "<div style=\"".$divstyle_white."\">";
       $orders .= "There are no orders yet.";
       $orders .= "<P><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Billing&action=selectServiceSLARequests&value=&valuetype=Billing&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=#151B54><B>Create an order</B></font></a>";

       $orders .= "</div>";

       }

    echo $orders;

    # End Orders
    #########################
    # Present search form after listing up orders

    echo "<P>".$zaform;
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    # End Search form
    #########################

   break;
   case 'selectServiceSLARequests':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $sent_cust_account_id = $_POST['cust_account_id'];

    #echo "sent_cust_account_id $sent_cust_account_id<P>";

    # Collect all the Accounts SLAs that can be managed by this account
    $accssla_object_type = 'AccountsServicesSLAs';
    $accssla_action = "select";
    $accssla_params[0] = "account_id_c='".$sess_account_id."' && name IS NOT NULL";
    $accssla_params[1] = "id,name,date_entered,date_modified,account_id_c"; // select array
    $accssla_params[2] = ""; // group;
    $accssla_params[3] = " name, date_entered DESC "; // order;
    $accssla_params[4] = ""; // limit
  
    $accssla_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $accssla_object_type, $accssla_action, $accssla_params);
    $cust_array = array();

    if (is_array($accssla_items)){

       for ($accssla_cnt=0;$accssla_cnt < count($accssla_items);$accssla_cnt++){

           $accsla_id = $accssla_items[$accssla_cnt]['id'];
           $accsla_name = $accssla_items[$accssla_cnt]['name'];
           #$date_entered = $accssla_items[$accssla_cnt]['date_entered'];
           #$date_modified = $accssla_items[$accssla_cnt]['date_modified'];    

           #$ssla .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('lightform');doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$accsla_id."&valuetype=AccountsServicesSLAs&sendiv=lightform');return false\"><B>".$accsla_name."</B></a></div>";

           #$ssla .= "<div style=\"".$divstyle_blue."\"><B>".$accsla_name."</B></div>";

           $servslareq_object_type = 'ServiceSLARequests';
           $servslareq_action = "select";
           if ($cust_account_id){
              $servslareq_params[0] = " sclm_accountsservicesslas_id_c='".$accsla_id."' && name IS NOT NULL && account_id_c='".$cust_account_id."' ";
              } else {
              $servslareq_params[0] = " sclm_accountsservicesslas_id_c='".$accsla_id."' && name IS NOT NULL ";
              } 

           $servslareq_params[1] = "id,name,date_entered,date_modified,account_id_c"; // select array
           $servslareq_params[2] = ""; // group;
           $servslareq_params[3] = " sclm_servicessla_id_c,sclm_services_id_c, name, date_entered DESC "; // order;
           $servslareq_params[4] = ""; // limit

           $servslareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $servslareq_object_type, $servslareq_action, $servslareq_params);

           $slareqs = "";

           if (is_array($servslareq_items)){

              for ($srvslareqcnt=0;$srvslareqcnt < count($servslareq_items);$srvslareqcnt++){

                  $srvslareq_id = $servslareq_items[$srvslareqcnt]['id'];
                  $srvslareq_name = $servslareq_items[$srvslareqcnt]['name'];
                  $customer_acc_id = $servslareq_items[$srvslareqcnt]['account_id_c'];
                  $customer_namer = "";
                  $customer_name = "";
                  $customer_namer = $funky_gear->object_returner ('Accounts', $customer_acc_id);
                  $customer_name = $customer_namer[0];

                  if (!in_array($customer_acc_id,$cust_array)){
                     if ($sent_cust_account_id == $customer_acc_id){
                        $customers .= "<option SELECTED id=\"".$customer_acc_id."\" value=\"".$customer_acc_id."\">".$customer_name."</option>";
                        } else {
                        $customers .= "<option id=\"".$customer_acc_id."\" value=\"".$customer_acc_id."\">".$customer_name."</option>";
                        }
                     #array_push($cust_array, $customer_acc_id);
                     $cust_array[] = $customer_acc_id;
                     }

                  #$servslareqs .= "<div style=\"".$divstyle_white."\"><input type=\"checkbox\" name=\"servslareq_".$srvslareq_id."\" id=\"servslareq_".$srvslareq_id."\" value=\"".$srvslareq_id."\"\"> <a href=\"#\" onClick=\"loader('lightform');doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$srvslareq_id."&valuetype=".$valtype."&sendiv=lightform');return false\"><B>".$srvslareq_name."</B></a></div>";
                  if ($srvslareq_name != NULL){
                     if ($sent_cust_account_id != NULL && $sent_cust_account_id == $customer_acc_id){
                        $slareqs .= "<div style=\"".$divstyle_white."\"><input type=\"checkbox\" name=\"servslareq_".$srvslareq_id."\" id=\"servslareq_".$srvslareq_id."\" value=\"".$srvslareq_id."\"\" checked>".$customer_name." -> <B>".$srvslareq_name."</B></div>";
                        } else {
                        #$slareqs .= "<div style=\"".$divstyle_white."\"><input type=\"checkbox\" name=\"servslareq_".$srvslareq_id."\" id=\"servslareq_".$srvslareq_id."\" value=\"".$srvslareq_id."\"\">".$customer_name." -> <B>".$srvslareq_name."</B></div>";
                        }
                     } 

                  } // for serv sla reqs

              if ($accsla_name != NULL && $slareqs != NULL){
                 $ssla .= "<div style=\"".$divstyle_blue."\"><B>".$accsla_name."</B></div>";
                 }

              } else { // end if array

              #$slareqs = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";
              $slareqs = "";

              } //

           if ($slareqs != NULL){
              $ssla .= $slareqs;
              }

           } # for $accssla_items

       # is_array($accssla_items

       } else { // end if array

       #$ssla = "<div style=\"".$divstyle_blue."\">".$strings["Empty_Listed"]."</div>";

       }

    $today = date("Y-m-d");
    $encdate = date("Y@m@d@G");
    $body_sendvars = $encdate."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);
    $date_from = date("Y-m-d");
    $date_to = strtotime ( '+1 month' , strtotime ( $date_from ) ) ;
    $date_to = date ( 'Y-m-d' , $date_to );

    ?>

    <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="hidden" id="sendiv" name="sendiv" value="lightform" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="action" name="action" value="selectServiceSLARequests" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <select id="cust_account_id"><?php echo $customers; ?></select><BR>
    <input type="button" name="button" value="Select Customer" onclick="javascript:loader('lightform');get(this.parentNode);return false" class="css3button">
   </form>

    <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="hidden" id="sendiv" name="sendiv" value="lightform" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="action" name="action" value="BuildOrder" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >

    <?PHP

    echo $ssla;

    ?>

    <input type="text" placeholder="Date From" id="date_from" name="date_from" value="<?php echo $date_from; ?>" size="20"><BR>
    <input type="text" placeholder="Date To"  id="date_to" name="date_to" value="<?php echo $date_to; ?>" size="20"><BR>
    <input type="button" name="button" value="Managed Selected Requests" onclick="if(confirmer('Proceed?')){javascript:loader('lightform');get(this.parentNode);return false}" class="css3button">
   </form>

   <?PHP

   echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

   break;
   case 'BuildOrder':

    echo "<center><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Billing&action=selectServiceSLARequests&value=&valuetype=Billing&sendiv=lightform');document.getElementById('fade').style.display='block';return false\"><font color=BLUE><B>Return to order creation</B></font></a><P>";

    echo "<a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $date_from = $_POST['date_from'];
    $date_to = $_POST['date_to'];

    # Check if multiple deletions submitted
    # Key = servslareq_XXXXXXXXXXXXXXXXXXX

    $total_tickets = 1;

    foreach ($_POST as $multi_key=>$multi_val){

            if (str_replace("servslareq_","",$multi_key) != $multi_key){
               $servslareq_id = str_replace("servslareq_","",$multi_key);
               } else {
               $servslareq_id = "";
               }  

            if ($servslareq_id == $multi_val && $servslareq_id != NULL){

               $ticket_object_type = "Ticketing";
               $ticket_action = "select";
               $ticket_params[0] = "sclm_serviceslarequests_id_c='".$servslareq_id."' && (date_entered >= '".$date_from."' && date_entered <= '".$date_to."') ";
               $ticket_params[1] = "id,sclm_serviceslarequests_id_c,service_operation_process, name,sdm_confirmed,billing_count"; // select array
               $ticket_params[2] = ""; // group;
               $ticket_params[3] = ""; // order;
               $ticket_params[4] = ""; // limit
               $ticket_params[5] = $lingoname; // lingo
  
               $ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

               if (is_array($ticket_items)){

                  $slatickets = count($ticket_items);

                  $servslareqs = $funky_gear->object_returner ('ServiceSLARequests', $servslareq_id);
                  $servslareq_name = $servslareqs[0];

                  $slareq_object_type = 'ServiceSLARequests';
                  $slareq_action = "select";
                  $slareq_params[0] = " id='".$servslareq_id."' ";
                  $slareq_params[1] = "provider_price,reseller_price,customer_price,sclm_servicesprices_id_c"; // select array
                  $slareq_params[2] = ""; // group;
                  $slareq_params[3] = ""; // order;
                  $slareq_params[4] = ""; // limit
  
                  $slareq_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $slareq_object_type, $slareq_action, $slareq_params);

                  $provider_price = "";
                  $reseller_price = "";
                  $customer_price = "";
                  $sclm_servicesprices_id_c = "";

                  if (is_array($slareq_items)){

                     for ($slareq_cnt=0;$slareq_cnt < count($slareq_items);$slareq_cnt++){

                         $provider_price = $slareq_items[$slareq_cnt]['provider_price'];
                         $reseller_price = $slareq_items[$slareq_cnt]['reseller_price'];
                         $customer_price = $slareq_items[$slareq_cnt]['customer_price'];
                         $sclm_servicesprices_id_c = $slareq_items[$slareq_cnt]['sclm_servicesprices_id_c'];

                         } # for

                     } # is_array

                  $slareqs .= "<div style=\"".$divstyle_blue."\"><B>[".$slatickets."] Tickets for SLA Request: ".$servslareq_name."</B><BR>Price ID: $sclm_servicesprices_id_c<BR>Provider Price: ".$provider_price."<BR>Reseller Price: ".$reseller_price."<BR>Customer Price: ".$customer_price."</div>";

                  $tickets = "";

                  for ($ticket_cnt=0;$ticket_cnt < count($ticket_items);$ticket_cnt++){

                      #$id = $ticket_items[$ticket_cnt]["id"];
                      #$ci_account_id2_c = $ticket_items[$ticket_cnt]['account_id2_c'];
                      #$ci_contact_id2_c = $ticket_items[$ticket_cnt]['contact_id2_c'];
                      $ticket_name = $ticket_items[$ticket_cnt]['name'];
                      $tickets .= "<div style=\"".$divstyle_white."\">Ticket [".$total_tickets."]: ".$ticket_name."</div>";

                      $total_tickets++; 

                      } # for $ticket_items

                  } # is_array $ticket_items

               $slareqs .= $tickets;

               } # is servslareq_id

            } # foreach

    $total_tickets = $total_tickets-1;
    $totals = "<div style=\"".$divstyle_grey."\"><B>Date From: ".$date_from."</B><BR><B>Date To: ".$date_to."</B><BR><B>Total Tickets: ".$total_tickets."</B></div>";

    echo $totals.$slareqs.$totals;

   break;
   case 'search':

    #########################
    # Present search form after listing up orders

    echo "<P>".$zaform;
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
 
    # End Search form
    #########################
    
    if ($_POST['download']){

       #$csv[] = Array("TICKET","DATE_CREATED","TITLE","STATUS","BILLING_COUNT","SLA_PRICE","SUM");
       $csv = "TICKET,DATE_CREATED,TITLE,STATUS,SLA,PROVIDER,BILLING_COUNT,SLA_PRICE,SUM\n";

       } # end csv download

    $ci_object_type = 'ServiceSLARequests';
    $ci_action = "select";

    if ($auth==3){
       $ci_params[0] = " deleted=0 ";
       } else {
       $ci_params[0] = " deleted=0 && account_id_c='".$customer_account_id."' ";
       }

    $ci_params[0] .= " && name IS NOT NULL ";

    $ci_params[1] = "id,name,date_entered,provider_price,reseller_price,customer_price,sclm_servicesprices_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " date_entered ASC ";
    $ci_params[4] = ""; // limit

    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    # Start SLA

    if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $servicesum = 0;

           $provider_price = 0;
           $reseller_price = 0;
           $customer_price = 0;

           # Will need to remove any monthly SLA type tickets as these are usually charged based on monthly fee, not per ticket
           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           #$serviceslarequests[$id]=$name; # Why was this array of names put here?!
           $provider_price = $ci_items[$cnt]['provider_price'];
           $reseller_price = $ci_items[$cnt]['reseller_price'];
           $customer_price = $ci_items[$cnt]['customer_price'];
           $sclm_servicesprices_id_c = $ci_items[$cnt]['sclm_servicesprices_id_c'];

           if ($sclm_servicesprices_id_c){

              $credits_object_type = "ServicesPrices";
              $credits_action = "select";
              $credits_params[0] = " id='".$sclm_servicesprices_id_c."' ";
              $credits_params[1] = "id,credits"; // select array
              $credits_params[2] = ""; // group;
              $credits_params[3] = ""; // order;
              $credits_params[4] = ""; // limit

              $credits_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $credits_object_type, $credits_action, $credits_params);
              if (is_array($credits_list)){

                 for ($cntcrd=0;$cntcrd < count($credits_list);$cntcrd++){
                     $credits = $credits_list[$cntcrd]['credits'];

                     } // for

                 } // if

              } // if

           $serviceslaaverage=1;

           if ($credits){
              $provider_price = $credits*$provider_price;
              $reseller_price = $credits*$reseller_price;
              $customer_price = $credits*$customer_price;
              } else {
              $provider_price = $serviceslaaverage*$provider_price;
              $reseller_price = $serviceslaaverage*$reseller_price;
              $customer_price = $serviceslaaverage*$customer_price;
              }


           # Portal type is incorrect as it only represents SLAs based on the immediate parent relationship
           # Not all SLAs are from the parent - they may come from other partners or providers

           switch ($portal_type){

            case 'system':

             $price = $provider_price;

            break;
            case 'provider':

             $price = $provider_price;

            break;
            case 'reseller':

             $price = $reseller_price;

            break;
            case 'client':

             $price = $customer_price;

            break;
           } // end switch

           $tick_params[0] = $sdm_confirmed;
           $tick_params[1] = $id;
           $tick_params[2] = $name;
           $tick_params[3] = $price;
           $tick_params[4] = $tickets_filter;
           $tick_params[5] = $selected_provider;
           $tick_params[6] = $stats;
           $tick_params[7] = $csv;
           $tick_params[8] = $serviceslarequests_total;
           $tick_params[9] = $serviceslarequests_show;
           $tick_params[10] = $provider_account_name;

           $sla_ticks = spin_tickets ($tick_params);
           $stats = $sla_ticks[0]; 
           $csv = $sla_ticks[1]; 
           $serviceslarequests_total = $sla_ticks[2]; 
           $serviceslarequests_show = $sla_ticks[3]; 

           $final_total = $final_total+$serviceslarequests_total;

           } // end for sla
      
       } // is array sla

     # Do for non-SLA-based tickets

    $tick_params[0] = $sdm_confirmed;
    $tick_params[1] = "";
    $tick_params[2] = "";
    $tick_params[3] = 0;
    $tick_params[4] = $tickets_filter;
    $tick_params[5] = $selected_provider;
    $tick_params[6] = $stats;
    $tick_params[7] = $csv;
    $tick_params[8] = $serviceslarequests_total;
    $tick_params[9] = $serviceslarequests_show;
    $tick_params[10] = $provider_account_name;

    $sla_ticks = spin_tickets ($tick_params);
    $stats = $sla_ticks[0]; 
    $csv = $sla_ticks[1]; 
    $serviceslarequests_total = $sla_ticks[2]; 
    $serviceslarequests_show = $sla_ticks[2]; 

    echo "<P>";

    foreach ($stats as $day => $daycount) {
            $totaltickets = $totaltickets+$daycount;
            }

    foreach ($stats as $day => $daycount) {
            $percentage = 100*($daycount/$totaltickets);
            $percentage = round($percentage,2);
            $newstats[$day] = $percentage;
            $daydata[] = array ('day' => $day, 'percentage' => $percentage, 'count' => $daycount);
            echo $day."'s: ".$daycount." tickets (".$percentage."%)<BR>";
            }
/*
    foreach ($daydata as $thiskey => $thisrow) {
            $day[$thiskey] = $thisrow['day'];
            $per[$thiskey] = $thisrow['percentage'];
            $cnt[$thiskey] = $thisrow['count'];
            }
*/

    function sortByOrder($a, $b) {
             return $a['percentage'] - $b['percentage'];
             }

    usort($daydata, 'sortByOrder');

    #array_multisort($per, SORT_ASC, $day, SORT_DESC, $daydata);

    foreach ($daydata as $thiskey => $thisrow) {
            #$day[$thiskey] = $thisrow['day'];
            #$per[$thiskey] = $thisrow['percentage'];
            #$cnt[$thiskey] = $thisrow['count'];
            $thisday = $thisrow['day'];
            $this_percentage = $thisrow['percentage'];
            $this_count = $thisrow['count'];
            }

    echo "<P><font color=red><B>The most active day in this period was on ".$thisday."'s with ".$this_count." tickets (".$this_percentage."%) </B></font><P>";

    echo "<P>Total Tickets: ".$totaltickets."<BR>";


#    for ($daycnt=0;$daycnt < count($stats);$daycnt++){
#        $stats[$day]
#        }

    if ($_POST['download']){
       # Use SQL to package the CSV
       #$csv

      if ($selected_date_from != NULL && $selected_date_to != NULL){
         $csv_name = "TICKET_SUMMARY_FROM_".$selected_date_from."_TO_".$selected_date_to;
         } elseif ($selected_date_from != NULL && $selected_date_to == NULL){
         $csv_name = "TICKET_SUMMARY_".$selected_date_from;
         } else {
         $csv_name = "TICKET_SUMMARY_";
         }

       echo "<P><img src=images/download-icon.gif width=16 border=0> <font color=blue size=3><B>Recommended Name</B></font><P>";

       #convert_to_csv($csv, $csv_name, ',');
       #echo ":<P>";
       echo "<textarea id=\"downloadcsvname\" name=\"downloadcsvname\" cols=\"80\" rows=\"1\" onclick=\"this.select();\">".$csv_name.".csv</textarea>";
       echo "<P><img src=images/download-icon.gif width=16 border=0> <font color=blue size=3><B>Copy CSV from textbox below...</B></font><P>";
       echo "<textarea id=\"downloadcsv\" name=\"downloadcsv\" cols=\"80\" rows=\"15\" onclick=\"this.select();\">".$csv."</textarea>";

       }
 
    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=4><B>Customer Invoice for ".$title_monthyeartext."</B></font></center></div>";
    echo "<div style=\"".$billstyle_account_details."\"><center><B>".$provider_account_name."</B></center><P>".$provider_billing_address_street."<BR>".$provider_billing_address_city."<BR>".$provider_billing_address_state."<BR>".$provider_billing_address_postcode."</div><div style=\"".$billstyle_account_details."\"><center><B>".$customer_account_name."</B></center><P>".$customer_billing_address_street."<BR>".$customer_billing_address_city."<BR>".$customer_billing_address_state."<BR>".$customer_billing_address_postcode."</div></div>";
    echo $serviceslarequests_show."<div style=\"".$billstyle_total_label."\"><center><B>Total</B></center></div><div style=\"".$billstyle_total."\"><center><B>\\".number_format($final_total)."</B></center></div>";

   break;

  } // action switch 

?>