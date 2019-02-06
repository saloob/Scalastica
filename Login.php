<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-05-26
# Page: Login.php 
##########################################################
# case 'Login':
 
  switch ($action){
 
   case 'confirm':

    if (!$sess_contact_id){
  
       session_start();
       session_unset();
       session_destroy();

       $process_message = "<input type=\"button\" value=\"".$strings["action_clicktologin"]."\" onClick=\"timedRefresh(100);loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=&action=view&value=&valuetype=');return false\"></a>";

       echo "<div style=\"".$divstyle_white."\"><center>".$process_message."</center></div>";

       exit;

       }
   
   break;
   case 'loader':
  
    echo "<img src=images/loading.gif>";
   
   break;
   case '':
   case 'login':

    $em = $_GET['em'];
    $pw = $_GET['pw'];

    if (!$em){
       $em = $_COOKIE['email'];
       }

    if (!$pw){
       $pw = $_COOKIE['password'];
       }

    $tblcnt = 0; // first set
    
    $tablefields[$tblcnt][0] = "em"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Email"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $em; // Field ID
    $tablefields[$tblcnt][12] = "50"; // Object Length
    $tablefields[$tblcnt][20] = "em"; //$field_value_id;
    $tablefields[$tblcnt][21] = $em; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "pw"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Password"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'password';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $pw; // Field ID
    $tablefields[$tblcnt][12] = "50"; // Object Length
    $tablefields[$tblcnt][20] = "pw"; //$field_value_id;
    $tablefields[$tblcnt][21] = $pw; //$field_value;

    $valpack = "";
    $valpack[0] = 'Login';
    $valpack[1] = "do_login"; 
    $valpack[2] = $valtype; 
    $valpack[3] = $tablefields;
    $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = "do_login"; // next action
    $valpack[7] = $strings["Login"];

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);
 
    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = ""; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $strings["action_login"]; // container_title
    $container_params[4] = 'Login'; // container_label
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

    echo "<P><center><font color=blue size=3><B>".$strings["NeedAnAccount"]."</font></B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','tr.php', 'pg=".$Body."&pc=".$portalcode."&sv=".$sendvars."&do=Login&action=register&value=".$val."&valuetype=".$valtype."');return false;\"><font size=3 color=\"#6e89dd\"><B>".$strings["RegisterHere"]."</B></font></a><P>";

    echo "<P><center><font color=blue size=3><B>".$strings["AccessProblems"]."</font></B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','tr.php', 'pg=".$Body."&pc=".$portalcode."&sv=".$sendvars."&do=Login&action=forgotten&value=".$val."&valuetype=".$valtype."');return false;\"><font size=3 color=\"#6e89dd\"><B>".$strings["RetrieveHere"]."</B></font></a><P>";

    # Provide Google Login

    echo $container_bottom;
   
   if ($fbme != NULL && $access != NULL) {

      echo "<P><center><h2>".$strings["AccountInformation"]."</h2></center><P>";

      $userid = $fbme[id];
      $name = $fbme[name];
      $first_name = $fbme[first_name];
      $last_name = $fbme[last_name];
      $link = $fbme[link];
      $hometown = $fbme[hometown];
      $hometown_id = $hometown[id];
      $hometown_name = $hometown[name];
      $gender = $fbme[gender];
      $email = $fbme[email];
      $timezone = $fbme[timezone];
      $locale = $fbme[locale];
      $verified = $fbme[verified];
      $updated_time = $fbme[updated_time];
  
      echo "Welcome back, ".$first_name.". To update your details, please do so within <a href=http://apps.facebook.com/straightgov/ target=FB>Facebook</a><P>";
      echo "Facebook ID: ".$sess_source_id."<BR>";
      echo $portal_title." ID: ".$sess_contact_id."<BR>";
      echo $portal_title." Key: ".$sess_leadsources_id_c."<BR>";  
      echo "First Name: ".$first_name."<BR>";
      echo "Last Name: ".$last_name."<BR>";
      echo "Email: ".$email."<BR>";
      echo "Timezone: ".$timezone."<BR>";
      echo "Locale: ".$locale."<BR>";
      echo "Current IP: ".$ip_address."<BR>";
   
      if (!empty($country)) {
         //$cmv_country = dlookup("cmv_countries", "id", "two_letter_code='".$country."'");
         $country = dlookup("cmv_countries", "name", "two_letter_code='".$country."'");   
         }
    
      echo "IP-based Country: ".$country."<BR>"; 
  
      echo "<P>";
 
      echo "<center><h2>Tools, Services, Consultants, Providers and Vendors</h2></center><P>";
      echo "<img src=images/file.gif height=16> Documents, Calendar, Email, Virtual Desktops<BR>";
      echo "<img src=images/icons/i_register_domain.gif> Domain Registration, Hosting and Homepage Building Services<BR>";
      echo "<img src=images/icons/i_support_man.gif> Government Building Consulting Services<BR>";
      echo "<img src=images/icons/i_businessdirector.gif> Government Tenders<BR>";
      echo "<img src=images/icons/infrastructure_16.gif> Government Service Providers<BR>";
  
      } # enf FB access
  
   break;
   case 'logout':

    session_start();
    session_unset();
    session_destroy();

   break;
   case 'do_login':

    # Get login fields and take action

    if ($sess_leadsources_id_c == NULL){
       $sclm_leadsources_id_c = $portal_config['portalconfig']['default_service_leadsources_id_c'];
       } else {
       $sclm_leadsources_id_c = $sess_leadsources_id_c;
       }

    # Allow Scalastica Portal Signups
    # 8a5c8fb2-dd32-d0b4-3af1-5516a8746b5e

    $email = $_POST['em'];
    $password = $_POST['pw'];

    $error = "";
  
    if ($email == NULL){
       $error .= "<B><font color=red size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["Email"]."</font></B><BR>";
       }

    if ($password == NULL){
       $error .= "<B><font color=red size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["Password"]."</font></B><BR>";
       }

    if ($error == NULL){

       # Check by email to get id
       $login_object_type = "Contacts";
       $login_action = "contact_by_email";
       $login_params = $email; // query
       $contact_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $login_object_type, $login_action, $login_params);

       #######################
       # If Contact

       if ($contact_id_c != NULL){

          # Get Password info and name
          $login_object_type = "Contacts";
          $login_action = "contact_by_id";
          $login_params = $contact_id_c; // query

          $loginresult = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $login_object_type, $login_action, $login_params);

          # Create an email to remind
          foreach ($loginresult['entry_list'] as $gotten){

                  $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                  $fn =  $fieldarray['first_name'];
                  $realpass =  $fieldarray['password_c'];
                  $role_c = $fieldarray['role_c'];

                  } // end for each

          if ($realpass == $password){
             # Email and password OK
             # Check Account ID

             $accid_object_type = "Contacts";
             $accid_action = "get_account_id";
             $accid_params[0] = $contact_id_c;
             $accid_params[1] = "account_id";
             $account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

             if ($account_id_c != NULL){

                $_SESSION['account_id'] = $account_id_c;
                $sess_account_id = $account_id_c;

                }

             if ($sess_account_id != NULL && $sess_account_id != $portal_account_id){

                # IF NOT hostname owner, check in related company CI for shared access rights
                # Logged-in account set for sharing??

                $sharing_params[0] = $portal_account_id;
                $sharing_params[1] = $sess_account_id;
                $sharinginfo = $funky_gear->portal_sharing ($sharing_params);
                $shared_portal_access = $sharinginfo['shared_portal_access'];

                #var_dump($sharinginfo);
                #echo "shared_portal_access $shared_portal_access <BR>";

                if ($shared_portal_access != 1){
                   $portal_error = "You do not have portal access rights, please contact the portal administrator.";
                   } // if portalaccess

                } # No need for any special tricks for their own portal

             } # end if pass

          # echo " (($realpass == $password) && ($account_id_c != NULL) && (($account_id_c == $portal_account_id) || ($account_id_c != $portal_account_id && $shared_portal_access == 1)))";

          if (($realpass == $password) && ($account_id_c != NULL) && (($account_id_c == $portal_account_id) || ($account_id_c != $portal_account_id && $shared_portal_access == 1))){

             # Access to the portal has been granted
             # Have contact by email - check lead source

             $login_object_type = "Contacts";
             $login_action = "contact_by_source";
             $login_params = array();
             $login_params[0] = $sclm_leadsources_id_c; // query
             $login_params[1] = $contact_id_c; // query

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $login_object_type, $login_action, $login_params);

             foreach ($result['entry_list'] as $gotten){

                     $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                     $contact =  $fieldarray['contact_id_c'];

                     } // end foreach..

             if ($contact == NULL){

                # Contact doesn't exist - create Contact Source
                $login_object_type = "Contacts";
                $login_action = "create_sclm_ContactsSources";
                $login_params = array();      
                $login_params = array(
                 array('name'=>'name','value' => $fn." from ".$portal_title),
                 array('name'=>'contact_id_c','value' => $contact_id_c),
                 array('name'=>'source_id','value' => $contact_id_c),
                 array('name'=>'sclm_leadsources_id_c','value' => $sclm_leadsources_id_c) 
                ); 

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $login_object_type, $login_action, $login_params);

                $do = "Login";

                } // end set Contact Source

             # All set to prepare access

             if (!isset($_COOKIE["email"])) {

                #$year = time() + 31536000;
                $twomonth = time() + 5256000;
                #setcookie('remember_me', $_POST['username'], $year);
                setcookie("email",$email, $twomonth, "/","", 0);
                setcookie("password",$password, $twomonth, "/","", 0);

                } # is cookie

             $_SESSION["contact_id"] = $contact_id_c;
             $_SESSION["scalastica"] = $contact_id_c;
             $_SESSION["sclm_leadsources_id_c"] = $sclm_leadsources_id_c;
             # $_SESSION["cmv_targetmarkets_id_c"] = $cmv_targetmarkets_id_c;

             if ($role_c == NULL){
                $role_c = "9f9eac92-9527-b7fe-926c-527329fc72e1"; # Account admin
                }

             $security_level = $funky_gear->get_security ($role_c);

             $_SESSION['security_level'] = $security_level;
             $_SESSION['security_role'] = $role_c;

             echo "<center><div><button type=\"button\" name=\"button\" value=\"".$strings["action_clicktologin"]."\" onClick=\"timedRefresh(2);\" class=\"css3button\">".$strings["l_Login_Success"]."</div></center>";

             } else {

             echo "<div style=\"".$divstyle_white."\"><P><B><font color=red size=4>".$strings["l_Login_Error"]." [ERR:01] <P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Login&action=forgotten&em=".$email."');return false\"></B></font> <font size=2 color=\"#6e89dd\">".$strings["action_click_here_to_retrieve"]."</font></a><P>".$portal_error."</div>";

             } // end else if realpass

          } else { // end if no ID

          echo "<div style=\"".$divstyle_white."\"><P><B><font color=red size=4>".$strings["l_Login_Error"]." [ERR:02] <P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Login&action=forgotten&em=".$email."');return false\"></B></font><font size=4 color=\"#6e89dd\"><B>".$strings["action_click_here_to_retrieve"]."</B></font></a></div>";

          } # if contact 

       # If Contact
       #######################

       } else {// end if no error

       echo "<div style=\"".$divstyle_white."\"><P><B>3: <font color=red size=4>".$strings["l_Login_Error"]." [ERR:03] </B></font><P>".$error."<P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Login&action=forgotten&em=".$email."');cleardiv('logindiv');return false\"><font size=2 color=\"#6e89dd\">".$strings["action_click_here_to_try_again"]."</font></a></div>";     
    
       } // end do login
    
   break; // end do_login
   case 'do_register':
   
    ##############################################
    # Collect Core Data to create Contact
 
    $account_name = $_POST['account_name'];
    $role_c = $_POST['role_c'];
    $first_name = $_POST['fn'];
    $last_name = $_POST['ln'];
    $email = $_POST['em'];
    $password = $_POST['pw'];
    $entity_type = $_POST['entity_type'];
    $portal_hostname = $_POST['portal_hostname'];
    $hostname_type = $_POST['hostname'];

    $agree = $_POST['agree'];

    $error = "";

    switch ($hostname_type){

     case 'sub':
      # Check whether it is available or not 

      $sublist = array();
      $sublist[] = 'hp';
      $sublist[] = 'ajs';
      $sublist[] = 'www';
      $sublist[] = 'transware';
      $sublist[] = 'agc';
      $sublist[] = 'zadara';
      $sublist[] = 'nextit';
      $sublist[] = 'computec';

      if (!in_array($portal_hostname,$sublist)){
         #echo $_POST['portal_hostname']." is available!";
         } else {
         $error .= "<B><font color=WHITE size=4>".$portal_hostname." is not available - please try another sub-domain.</font></B><BR>";
         }

    } // end switch

    if (!$agree){
       $error .= "<B><font color=WHITE size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["Agreement"]."</font></B><BR>";
       }

    if (!$account_name){
       $error .= "<B><font color=WHITE size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["AccountName"]."</font></B><BR>";
       }

    if (!$first_name){
       $error .= "<B><font color=WHITE size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["FirstName"]."</font></B><BR>";
       }

    if (!$last_name){
       $error .= "<B><font color=WHITE size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["LastName"]."</font></B><BR>";
       }

    if (!$email){
       $error .= "<B><font color=WHITE size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["Email"]."</font></B><BR>";
       }

    if (!$password){
       $error .= "<B><font color=WHITE size=4>".$strings["SubmissionErrorEmptyItem"]." ".$strings["Password"]."</font></B><BR>";
       }

    if ($portal_hostname){

       switch ($hostname_type){

        case 'sub':
        # Check whether it is available or not 

         $sublist = array();
         $sublist[] = 'hp';
         $sublist[] = 'ajs';
         $sublist[] = 'www';
         $sublist[] = 'transware';
         $sublist[] = 'agc';
         $sublist[] = 'zadara';
         $sublist[] = 'nextit';
         $sublist[] = 'computec';

         if (!in_array($portal_hostname,$sublist)){
            #
            } else {
            $error .= "<B><font color=WHITE size=4>".$portal_hostname." is not available - please try another one.</font></B><BR>";
            }

         break;
         case 'own':
          # Nothing to do 
         break;
         case 'reg':
          # Nothing to do
         break;
             
         } // end switch

       } // if portal_hostname

    if (!$error){

       # check if email exists
       $rego_object_type = "Contacts";
       $rego_action = "contact_by_email";
       $rego_params = $email; // query

       $this_contact_id = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $rego_object_type, $rego_action, $rego_params);

       if ($this_contact_id != NULL){
          # Email exists

          $process_message .= "<B><font color=red size=4>".$strings["SubmissionErrorAlreadyExists"]." ".$strings["Email"]."</B></font><P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Login&action=forgotten&em=".$email."');return false\"><font size=2 color=\"##6e89dd\">".$strings["action_click_here_to_retrieve"]."</font></a>";

          echo "<div style=\"".$divstyle_orange."\">".$process_message."</div>";       

          } else {// end if ID not null = email exists
          // Email doesn't exist

          $rego_object_type = "Contacts";
          $rego_action = "create";
          $rego_params = array();
          $rego_params[0] = $last_name;
          $rego_params[1] = $first_name;
          $rego_params[2] = $email;
          $rego_params[3] = $role_c;

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);
          $contact_id = $result['id'];

          $rego_object_type = "Contacts";
          $rego_action = "update_password";
          $rego_params = array();
          $rego_params[0] = $contact_id;
          $rego_params[1] = $password;

          $rego_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

          $rego_object_type = "Accounts";
          $rego_action = "create";
          $rego_params = array();
          $rego_params = array(
              array('name'=>'name','value' => $account_name),
              array('name'=>'status_c','value' => $standard_statuses_closed),
              array('name'=>'cmn_countries_id_c','value' => $cmn_countries_id_c)
              ); 

          $acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

          $account_id = $acc_result['id'];     

          $rego_object_type = "Relationships";
          $rego_action = "set_modules_soap";
          $rego_params = array();
          $rego_params[0] = "Accounts";
          $rego_params[1] = $account_id;
          $rego_params[2] = "Contacts";
          $rego_params[3] = $contact_id;

          $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

          # Registering on the portal_account based on hostname
          # Set Parent Account
          $process_params = array();
          $process_params[0] = "Accounts";
          $process_params[1] = $portal_account_id;
          $process_params[2] = "Accounts";
          $process_params[3] = $account_id;

          $par_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

          // Add Administrator to the Account
          $rego_object_type = "Accounts";
          $rego_action = "update";

          $rego_params = array(
          array('name'=>'id','value' => $account_id),
          array('name'=>'contact_id_c','value' => $contact_id),
          array('name'=>'account_id_c','value' => $portal_account_id)
          ); 

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

          # Add Administrator to the Account
          $rego_object_type = "Contacts";
          $rego_action = "update";

          $rego_params = array(
          array('name'=>'id','value' => $contact_id),
          array('name'=>'account_id','value' => $account_id),
          array('name'=>'cmn_countries_id_c','value' => $cmn_countries_id_c)
          ); 

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

          // Add Account relationship
          $par_account_returner = $funky_gear->object_returner ("Accounts", $portal_account_id);
          $par_account_name = $par_account_returner[0];
          $ar_name = $par_account_name. " (Parent) -> ".$account_name." (Child)";
          $description = $ar_name; 

          $process_object_type = "AccountRelationships";
          $process_action = "update";

          $process_params = array();  
          $process_params[] = array('name'=>'name','value' => $ar_name);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'description','value' => $description);
          $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id);
          $process_params[] = array('name'=>'account_id1_c','value' => $account_id);
          $process_params[] = array('name'=>'entity_type','value' => $entity_type);

          $ar_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
          $account_rel_id = $ar_result['id'];

          if ($portal_hostname){

             switch ($hostname_type){

              case 'sub':
               # Check whether it is available or not 

               $sublist = array();
               $sublist[] = 'hp';
               $sublist[] = 'ajs';
               $sublist[] = 'www';
               $sublist[] = 'transware';
               $sublist[] = 'agc';
               $sublist[] = 'zadara';
               $sublist[] = 'nextit';
               $sublist[] = 'computec';

               if (!in_array($portal_hostname,$sublist)){
                  echo $portal_hostname." is available!";
                  $portal_hostname = $portal_hostname.".scalastica.com";
                  } else {
                  echo $portal_hostname." is not available - please try another one...";
                  }

              break;
              case 'own':
               # Nothing to do 
              break;
              case 'reg':
               # Nothing to do
              break;
             
             } // end switch

             $process_object_type = "ConfigurationItems";
             $process_action = "update";

             $process_params = "";
             $process_params = array();  
             #$process_params[] = array('name'=>'id','value' => $_POST['hostname_id']);
             $process_params[] = array('name'=>'name','value' => $portal_hostname);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'description','value' => $portal_hostname);
             $process_params[] = array('name'=>'account_id_c','value' => $account_id);
             $process_params[] = array('name'=>'contact_id_c','value' => $contact_id);
             #$process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => 'ad2eaca7-8f00-9917-501a-519d3e8e3b35');
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

             } # if portal_hostname

          # Portal Registration Auto Access: cafad60b-6fab-dbd2-66d6-54d7a1988a3e
          # Check to see if allows for portal auto-access - otherwise admin must add manually
          # Needed if the client chooses no domain but still needs access - normal multi-tenancy

          $ci_object_type = "ConfigurationItems";
          $ci_action = "select";
          $ci_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && sclm_configurationitemtypes_id_c='cafad60b-6fab-dbd2-66d6-54d7a1988a3e' && name=1";
          $ci_params[1] = ""; // select array
          $ci_params[2] = ""; // group;
          $ci_params[3] = ""; // order;
          $ci_params[4] = ""; // limit
  
          $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

          if (is_array($ci_items)){

             # If Portal Access Allowed 
             # Get acc admin

             $object_type = "Accounts";
             $acc_action = "select_cstm";
             $accparams[0] = "id_c='".$portal_account_id."'";
             $accparams[1] = ""; // select
             $accparams[2] = ""; // group;
             $accparams[3] = ""; // order;
             $accparams[4] = ""; // limit

             $account_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $acc_action, $accparams);

             if (is_array($account_info)){
      
                for ($cnt=0;$cnt < count($account_info);$cnt++){

                    $account_admin_id = $account_info[$cnt]['contact_id_c']; // Administrator

                    } // for

                } // if array

             # Related Account Sharing Set: 3172f9e9-3915-b709-fc58-52b38864eaf6
             $acc_sharing_set = '3172f9e9-3915-b709-fc58-52b38864eaf6';

             $image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_sharing_set);
             $image_url = $image_returner[7];

             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = "";
             $process_params = array();
             $process_params[] = array('name'=>'name','value' => $account_rel_id);
             $process_params[] = array('name'=>'enabled','value' => 1);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_sharing_set);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id); # Parent owns this 
             $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
             $process_params[] = array('name'=>'image_url','value' => $image_url);

             $rel_acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $rel_acc_id = $rel_acc_result['id'];    

             # Allowed Shared Account
             $shared_account_ci = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

             $image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $shared_account_ci);
             $image_url = $image_returner[7];

             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = "";
             $process_params = array();
             $process_params[] = array('name'=>'name','value' => $account_id_c);
             $process_params[] = array('name'=>'enabled','value' => 1);
             $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $rel_acc_id);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $shared_account_ci);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id); # Parent owns this 
             $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
             $process_params[] = array('name'=>'image_url','value' => $image_url);

             $sh_acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $shared_acc_id = $sh_acc_result['id'];

             # Allow Parent Portal Access
             $acc_shared_type_portalaccess = 'e2affd29-d116-caa8-6f0c-52fa4d034cf5';

             $image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $acc_shared_type_portalaccess);
             $image_url = $image_returner[7];

             $process_object_type = "ConfigurationItems";
             $process_action = "update";
             $process_params = "";
             $process_params = array();
             $process_params[] = array('name'=>'name','value' => 1);
             $process_params[] = array('name'=>'enabled','value' => 1);
             $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $shared_acc_id);
             $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $acc_shared_type_portalaccess);
             $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
             $process_params[] = array('name'=>'account_id_c','value' => $portal_account_id); # Parent owns this 
             $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
             $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
             $process_params[] = array('name'=>'image_url','value' => $image_url);

             $port_access_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
             $port_access_id = $port_access_result['id'];

             } # end is_array($ci_items
          
          $_SESSION["account_id"] = $account_id;
          $_SESSION["contact_id"] = $contact_id;
          $_SESSION["scalastica"] = $contact_id;
          $_SESSION["role_c"] = $role_c;
          $_SESSION["security_level"] = 2;

          if (!$portal_hostname){
             $portal_hostname = $hostname;
             }

          # Send rego email
          $lingo = "ja";
          $type = 1;
          $subject = $portal_title." ".$strings["RegoSubject_Registration"];
          $body = $first_name." ".$strings["EmailDeliverySubject_BodyP1"]." ".$portal_title." ".$strings["EmailDeliverySubject_BodyP2"]."\n
          ".$strings["Email"].": ".$email."\n
          ".$strings["EmailDeliverySubject_BodyP3"]."\n
          ".$strings["Password"].": ".$password." \n
          URL: https://".$portal_hostname." \n
          ".$strings["EmailDeliverySubject_BodyP4"]." ".$portal_title."!";
          $from_name = $portal_title;
          $from_email = $portal_email;

          $mailparams[0] = $from_name;
          $mailparams[1] = $first_name." ".$last_name;
          $mailparams[2] = $from_email;
          $mailparams[3] = $portal_email_password;
          $mailparams[4] = $email;
          $mailparams[5] = $type;
          $mailparams[6] = $lingo;
          $mailparams[7] = $subject;
          $mailparams[8] = $body;
          $mailparams[9] = $portal_email_server;
          $mailparams[10] = $portal_email_smtp_port;
          $mailparams[11] = $portal_email_smtp_auth;
          #$mailparams[12] = $internal_to_addressees;

          $emailresult = $funky_gear->do_email ($mailparams);

          if ($emailresult[0] == 'OK'){

             $process_message .= "<P><B><font size=3>".$strings["RegistrationSuccess"]."</font></B><P>";
             $process_message .= "<input type=\"button\" value=\"".$strings["action_clicktologin"]."\" onClick=\"timedRefresh(100);loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Contacts&action=view&value=".$contact_id."&valuetype=id');return false\">".$strings["action_clicktologin"]."</a>";

             echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

             } else {

             $process_message .= "<P><B><font size=3>".$strings["LoginEmailDeliveryProblem"].": ".$portal_email.".</font></B><P>";

             echo "<div style=\"".$divstyle_orange."\">".$process_message."</div>";       

             }

          } // end if email doesn't exist and normal creation goes forth

       # There is an error
       } else {

       $process_message .= $error."<P>";
       $process_message .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Login&action=register&fn=".$first_name."&ln=".$last_name."&em=".$email."');return false\"><font size=2 color=\"##6e89dd\">".$strings["action_click_here_to_try_again"]."</font></a>";     echo "<div style=\"".$divstyle_orange."\">".$process_message."</div>";

       } 

    # End Collect Core Data to create Contact
    ##############################################
  
   break; // end send_internal_process
   case 'do_forgotten':

    $email = $_POST['em'];

    if ($email != NULL){

       $process_message .= "<P>".$strings["EmailForgottenPass_P1"]." ".$email." ".$strings["EmailForgottenPass_P2"]."<P>";

       $rego_object_type = "Contacts";
       $rego_action = "contact_by_email";
       $rego_params = $email; // query

       $this_contact_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

       if ($this_contact_id != NULL){

          // Email exists - send an email with the password
          $rego_object_type = "Contacts";
          $rego_action = "contact_by_id";
          $rego_params = $this_contact_id; // query

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

          foreach ($result['entry_list'] as $gotten){

                  $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                  #$id =  $fieldarray['id'];
                  $first_name =  $fieldarray['first_name'];
                  $last_name =  $fieldarray['last_name'];
                  $password =  $fieldarray['password_c'];

                  } // end for each

          $funky_gear = new funky ();

          if ($password == NULL){

             $password = $funky_gear->createRandomPassword();
             # Create and Set new password

             $rego_object_type = "Contacts";
             $rego_action = "update_password";
             $rego_params = array();
             $rego_params[0] = $this_contact_id;
             $rego_params[1] = $password;

             $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

             }

          # Send rego email
          $lingo = "ja";
          $type = 1;

          $subject = $portal_title." ".$strings["EmailDeliverySubject_Registration"];

          $body = $first_name."".$strings["EmailDeliverySubject_BodyP1"]." ".$portal_title." ".$strings["EmailDeliverySubject_BodyP2"]."\n
          ".$strings["Email"].": ".$email."\n
          ".$strings["EmailDeliverySubject_BodyP3"]."\n
          ".$strings["Password"].": ".$password." \n
          URL: https://".$hostname." \n
          ".$strings["EmailDeliverySubject_BodyP4"]." ".$portal_title."!";

          $from_name = $portal_title;
          $from_email = $portal_email;

          $mailparams[0] = $from_name;
          $mailparams[1] = $first_name." ".$last_name;
          $mailparams[2] = $from_email;
          $mailparams[3] = $portal_email_password;
          $mailparams[4] = $email;
          $mailparams[5] = $type;
          $mailparams[6] = $lingo;
          $mailparams[7] = $subject;
          $mailparams[8] = $body;
          $mailparams[9] = $portal_email_server;
          $mailparams[10] = $portal_email_smtp_port;
          $mailparams[11] = $portal_email_smtp_auth;
          #$mailparams[12] = $internal_to_addressees;

          $emailresult = $funky_gear->do_email ($mailparams);

          if ($emailresult[0] == 'OK'){
             $process_message .= "<P><B><font size=3>".$strings["LoginEmailSubmissionSuccess"]."</font></B><P>";
             echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       
             } else {
             $process_message .= "<P><B><font size=3>".$strings["LoginEmailDeliveryProblem"]." ".$portal_email.".</font></B><P>";
             echo "<div style=\"".$divstyle_orange."\">".$process_message."</div>";       
             }

          } else {// end if email exists

          $process_message .= "<P><font size=4><B>".$strings["LoginErrorEmailNoAccount"]."</B></font><P>";
          echo "<div style=\"".$divstyle_orange."\">".$process_message."</div>";       

          }

       } else {// end if email is not null

       $process_message .= "<font size=4><B>".$strings["LoginErrorEmail"]."</B></font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php','pc=".$portalcode."&do=Login&action=forgotten&em=".$email."');return false\"><font size=4 color=\"#6e89dd\"><B>".$strings["action_click_here_to_try_again"]."</B></font></a>";

       echo "<div style=\"".$divstyle_orange."\">".$process_message."</div>";       

       } // email is null

   break; // end do_forgotten
   case 'register':

    $fn = $_GET['fn'];
    $ln = $_GET['ln'];
    $em = $_GET['em'];

    $tblcnt = 0; // first set

    $tablefields[$tblcnt][0] = "entity_type"; // Field Name
    $tablefields[$tblcnt][1] = $strings["AccountType"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default

    if ($valtype == 'entity_types'){
       $entity_type = $val;
       }

    $dd_pack = "";
    $dd_pack = array();

    $ci_object_type = "ConfigurationItems";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && (sclm_configurationitemtypes_id_c='5e7c49e5-e48d-f53e-9c4a-54d719f5fedb' || sclm_configurationitemtypes_id_c='2f6a1ad8-2501-c5d7-025f-54d71a110296' || sclm_configurationitemtypes_id_c='1d3da104-6fad-d1d8-719a-54d71a00b7d0') && name=1";
    $ci_params[1] = "id,name,description,sclm_configurationitemtypes_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit

    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $sclm_configurationitemtypes_id_c = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

           switch ($sclm_configurationitemtypes_id_c){

            case '5e7c49e5-e48d-f53e-9c4a-54d719f5fedb':

             $provider_details = $funky_gear->object_returner ('ConfigurationItems', 'de438478-a493-51ad-ec49-51ca1a3aca3e');
             $provider_name = $provider_details[0];
             $dd_pack['de438478-a493-51ad-ec49-51ca1a3aca3e'] = $provider_name;

            break;
            case '2f6a1ad8-2501-c5d7-025f-54d71a110296':

             $reseller_details = $funky_gear->object_returner ('ConfigurationItems', 'f2aa14f0-dc5e-16ce-87c9-51ca1af657fe');
             $reseller_name = $reseller_details[0];
             $dd_pack['f2aa14f0-dc5e-16ce-87c9-51ca1af657fe'] = $reseller_name;

            break;
            case '1d3da104-6fad-d1d8-719a-54d71a00b7d0':

             $client_details = $funky_gear->object_returner ('ConfigurationItems', 'e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3');
             $client_name = $client_details[0];
             $dd_pack['e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3'] = $client_name;

            break;

           } # switch

           } # for

       } # if array
    
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = '';
    $tablefields[$tblcnt][9][5] = $entity_type;
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $entity_type; // Field ID
    $tablefields[$tblcnt][12] = ""; // Object Length
    $tablefields[$tblcnt][20] = "entity_type"; //$field_value_id;
    $tablefields[$tblcnt][21] = $entity_type; //$field_value;    

    $tblcnt++;

    $tablefields[$tblcnt][0] = "account_name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["AccountName"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $account_name; // Field ID
    $tablefields[$tblcnt][12] = "40"; // Object Length
    $tablefields[$tblcnt][20] = "account_name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $account_name; //$field_value;

    # Provide hostname options
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'portal_hostname'; // Field Name
    $tablefields[$tblcnt][1] = "Portal Hostname Options"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

    $hostnameoptionpack['sub'] = "Create a scalastica.com sub-domain";
    $hostnameoptionpack['own'] = "Use your own, existing domain";
    $hostnameoptionpack['reg'] = "Register a new domain";

    $tablefields[$tblcnt][9][1] = $hostnameoptionpack; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = ""; // Current Value
    $tablefields[$tblcnt][9][6] = 'Login';
    $tablefields[$tblcnt][9][7] = "hostname"; // list reltablename
//    $tablefields[$tblcnt][9][8] = 'Countries'; //new do
//    $tablefields[$tblcnt][9][9] = $cmn_countries_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'portal_hostname';//$field_value_id;
    $tablefields[$tblcnt][21] = ""; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "role_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Role"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = '9f9eac92-9527-b7fe-926c-527329fc72e1'; // Field ID
    $tablefields[$tblcnt][12] = "50"; // Object Length
    $tablefields[$tblcnt][20] = "role_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = '9f9eac92-9527-b7fe-926c-527329fc72e1'; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "fn"; // Field Name
    $tablefields[$tblcnt][1] = $strings["FirstName"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $fn; // Field ID
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "fn"; //$field_value_id;
    $tablefields[$tblcnt][21] = $fn; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "ln"; // Field Name
    $tablefields[$tblcnt][1] = $strings["LastName"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $ln; // Field ID
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "ln"; //$field_value_id;
    $tablefields[$tblcnt][21] = $ln; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "em"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Email"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $em; // Field ID
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "em"; //$field_value_id;
    $tablefields[$tblcnt][21] = $em; //$field_value;

    $tblcnt++;
    
    $tablefields[$tblcnt][0] = "pw"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Password"]." *"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'password';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $pw; // Field ID
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "pw"; //$field_value_id;
    $tablefields[$tblcnt][21] = $pw; //$field_value;

    $tblcnt++;
    
    #$Agreement = $funky_gear->replacer("BodyDIV",$BodyDIV,$strings["Agreement"]);

    $tablefields[$tblcnt][0] = "agree"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Agreement"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $agree; // Field ID
    $tablefields[$tblcnt][12] = "30"; // Object Length
    $tablefields[$tblcnt][20] = "agree"; //$field_value_id;
    $tablefields[$tblcnt][21] = $agree; //$field_value;
    $tablefields[$tblcnt][41] = "1"; // flipfields - label/fieldvalue

    $valpack = "";
    $valpack[0] = 'Login';
    $valpack[1] = "register"; 
    $valpack[2] = "register"; 
    $valpack[3] = $tablefields;
    $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = "do_register"; // next action
    $valpack[7] = $strings["Register"];

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
    $container_params[3] = $strings["Register"]; // container_title
    $container_params[4] = 'Register'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
   
    echo $container_top;

    echo "<P><div style=\"".$divstyle_orange_light."\">".$strings["Register_Info"]."</div>";
    echo "<img src=images/blank.gif width=95% height=10><BR>";
    echo $zaform;

    echo $container_bottom;
    
   break; // end register
   case 'forgotten':
   
    $em = $_GET['em'];

    $tblcnt = 0; // first set
    
    $tablefields[$tblcnt][0] = "em"; // Field Name
    $tablefields[$tblcnt][1] = "Email"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $em; // Field ID
    $tablefields[$tblcnt][20] = "em"; //$field_value_id;
    $tablefields[$tblcnt][21] = $em; //$field_value;

    $valpack = "";
    $valpack[0] = 'Login';
    $valpack[1] = "forgotten"; 
    $valpack[2] = "forgotten"; 
    $valpack[3] = $tablefields;
    $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = "do_forgotten"; // next action
    $valpack[7] = $strings["action_login_retrieve"];

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
    $container_params[3] = $strings["Login_Forgot"]; // container_title
    $container_params[4] = 'Login_Forgot'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
   
    echo $container_top;
    
    echo "<P><div style=\"".$divstyle_orange_light."\"><font size=4><B>".$strings["Login_ForgotProvideEmail"]."</B></font></div>";
    echo "<img src=images/blank.gif width=95% height=10><BR>";

    echo $zaform;

    echo $container_bottom;

   break; // end forgotten
   
   } // End Login actions switch

# break; // End Login
##########################################################
?>