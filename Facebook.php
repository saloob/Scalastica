<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-03-28
# Page: Facebook.php
##########################################################
# case 'Facebook':

  if (!function_exists('get_param')){
     include ("common.php");
     }

  if (!class_exists('funky')){
     include ("funky.php");
     $funky_gear = new funky ();   
     }

   require_once( 'Facebook/HttpClients/FacebookHttpable.php' );
   require_once( 'Facebook/HttpClients/FacebookCurl.php' );
   require_once( 'Facebook/HttpClients/FacebookCurlHttpClient.php' );
   require_once( 'Facebook/Entities/AccessToken.php' );
   require_once( 'Facebook/Entities/SignedRequest.php' );
   require_once( 'Facebook/FacebookSession.php' );
   require_once( 'Facebook/FacebookRedirectLoginHelper.php' );
   require_once( 'Facebook/FacebookRequest.php' );
   require_once( 'Facebook/FacebookResponse.php' );
   require_once( 'Facebook/FacebookSDKException.php' );
   require_once( 'Facebook/FacebookRequestException.php' );
   require_once( 'Facebook/FacebookOtherException.php' );
   require_once( 'Facebook/FacebookAuthorizationException.php' );
   require_once( 'Facebook/GraphObject.php' );
   require_once( 'Facebook/GraphSessionInfo.php' );

   use Facebook\HttpClients\FacebookHttpable;
   use Facebook\HttpClients\FacebookCurl;
   use Facebook\HttpClients\FacebookCurlHttpClient;
   use Facebook\Entities\AccessToken;
   use Facebook\Entities\SignedRequest;
   use Facebook\FacebookSession;
   use Facebook\FacebookRedirectLoginHelper;
   use Facebook\FacebookRequest;
   use Facebook\FacebookResponse;
   use Facebook\FacebookSDKException;
   use Facebook\FacebookRequestException;
   use Facebook\FacebookOtherException;
   use Facebook\FacebookAuthorizationException;
   use Facebook\GraphObject;
   use Facebook\GraphSessionInfo; 


  switch ($action){

   case 'Login':

    if ($fb_app_id != NULL && $fb_app_secret != NULL && $fb_session == NULL){

       require_once ("api-facebook.php");

       ################################
       # Start Body Content

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $external_service_title; // container_title
       $container_params[4] = $external_service_label; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);
  
       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       echo "<div style=\"".$divstyle_white."\">".$external_service_return."</div>";       

       echo $container_bottom;

       # End Body Content
       ################################

       } # $fb_app_id != NULL && $fb_app_secret != NULL 

   break; # end FB Login/Rego
   #
   ################################
   #
   case 'SetApp':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "sclm_configurationitems_id_c='".$val."' && account_id_c='".$portal_account_id."'";
    $ci_params[1] = "id,name,cmn_statuses_id_c,account_id_c,contact_id_c,sclm_configurationitemtypes_id_c"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){          

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $ci_type_id = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];

           if ($ci_type_id == '96a1aa15-7655-90ad-c64a-551675847b8d'){ # 

              $fb_app_id_cid = $ci_items[$cnt]['id'];
              $fb_app_id = $ci_items[$cnt]['name'];

              } elseif ($ci_type_id == '16423725-a2bd-8ed9-7f49-55167500faea'){ # 

              $fb_app_secret_cid = $ci_items[$cnt]['id'];
              $fb_app_secret = $ci_items[$cnt]['name'];

              }

           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $account_id_c = $ci_items[$cnt]['account_id_c'];
           $contact_id_c = $ci_items[$cnt]['contact_id_c'];

           } # for

       } # is array

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "par_ci_id"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = "par_ci_id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;   

    $tblcnt++;

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
    $tablefields[$tblcnt][11] = 'lightform'; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = 'lightform'; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "fb_app_id_cid"; // Field Name
    $tablefields[$tblcnt][1] = "APP ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = 'fb_app_id_cid'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $fb_app_id_cid; //$field_value_id;
    $tablefields[$tblcnt][21] = $fb_app_id_cid; //$field_value;
    $tblcnt++;

    $tablefields[$tblcnt][0] = "fb_app_id"; // Field Name
    $tablefields[$tblcnt][1] = "APP ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'fb_app_id'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $fb_app_id; //$field_value_id;
    $tablefields[$tblcnt][21] = $fb_app_id; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "fb_app_secret_cid"; // Field Name
    $tablefields[$tblcnt][1] = "APP Secret"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'fb_app_secret_cid'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $fb_app_secret_cid; //$field_value_id;
    $tablefields[$tblcnt][21] = $fb_app_secret_cid; //$field_value; 
  
    $tblcnt++;

    $tablefields[$tblcnt][0] = "fb_app_secret"; // Field Name
    $tablefields[$tblcnt][1] = "APP Secret"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = 'fb_app_secret'; // Field ID
    $tablefields[$tblcnt][12] = 40; // Field ID
    $tablefields[$tblcnt][20] = $fb_app_secret; //$field_value_id;
    $tablefields[$tblcnt][21] = $fb_app_secret; //$field_value;   

    /*
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
       $tablefields[$tblcnt][9][4] = " id='".$account_id_c."' "; // exception
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
    $tablefields[$tblcnt][9][1] = 'accounts_contacts,contacts'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'first_name';

    if ($auth == 3){
       $tablefields[$tblcnt][9][4] = ""; // exception
       } else {
       $tablefields[$tblcnt][9][4] = " accounts_contacts.account_id='".$account_id_c."' && accounts_contacts.contact_id=contacts.id "; // exception
       }

    $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Contacts';
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

    $valpack = "";
    $valpack[0] = 'Facebook';
    $valpack[1] = 'custom'; //
    $valpack[2] = 'Facebook';
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = "";
    $valpack[6] = 'SetAppProcess'; // next_action
    $valpack[7] = $strings["action_edit"];
    $valpack[8] = ""; 
    $valpack[9] = ""; 
    $valpack[10] = 'lightform';

    echo $funky_gear->form_presentation($valpack);

   break; # end SetApp
   #
   ################################
   #
   case 'SetAppProcess':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $par_ci_id = $_POST['par_ci_id'];

    $fb_app_id_cid = $_POST['fb_app_id_cid'];
    $fb_app_id = $_POST['fb_app_id'];

    $fb_app_secret_cid = $_POST['fb_app_secret_cid'];
    $fb_app_secret = $_POST['fb_app_secret'];

    $cmn_statuses_id_c = $_POST['cmn_statuses_id_c'];
    $contact_id_c = $_POST['contact_id_c'];
    $account_id_c = $_POST['account_id_c'];

    #echo "par_ci_id $par_ci_id fb_app_id $fb_app_id fb_app_secret $fb_app_secret    ";
    $process_object_type = "ConfigurationItems";
    $process_action = "update";

    if ($_POST['fb_app_id'] && $_POST['par_ci_id'] && $_POST['contact_id_c'] && $_POST['account_id_c']){

       $process_message = $strings["SubmissionSuccess"]."<P>";

       $process_params = "";
       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['fb_app_id_cid']);
       $process_params[] = array('name'=>'name','value' => $_POST['fb_app_id']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['fb_app_id']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       #$process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['par_ci_id']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '96a1aa15-7655-90ad-c64a-551675847b8d');
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
       $process_message .= "FB App ID: ".$_POST['fb_app_id']."<P>";

       }

    if ($_POST['fb_app_secret'] && $_POST['par_ci_id'] && $_POST['contact_id_c'] && $_POST['account_id_c']){

       $process_params = "";
       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['fb_app_secret_cid']);
       $process_params[] = array('name'=>'name','value' => $_POST['fb_app_secret']);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $_POST['fb_app_secret']);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       #$process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['par_ci_id']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '16423725-a2bd-8ed9-7f49-55167500faea');
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
       $process_message .= "FB Secret ID: ".$_POST['fb_app_secret']."<P>";

       }

    #$process_message .= $strings["SubmissionSuccess"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$_POST['account_id_c']."&valuetype=".$valtype."');return false\"> ".$strings["action_view_here"]."</a><P>";
     echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";        

   break; # end SetAppProcess
   #
   ################################
   #
   case 'list_events':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);
       $facebook_session = new FacebookSession($facebook_session);

       /* PHP SDK v4.0.0 */
       /* make the API call */

       $request = new FacebookRequest($facebook_session,'GET','/'.$fb_session.'/events');
       $response = $request->execute();

       #$request = new FacebookRequest( $facebook_session, 'GET', '/me' );
       #$response = $request->execute();

       $graphObject = $response->getGraphObject();

       #echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';

       #var_dump($returnpack);

       #$returnpack = json_decode($returnpack, true);
       #$returnpack = json_decode($graphObject,true);
       #$returndata = get_object_vars($returnpack);

       $returnpack = $funky_gear->object_to_array($graphObject);
 
       foreach ($returnpack as $key=>$value) {

               #echo "$key => $value <BR>";
 
               foreach ($value as $keys=>$values) {

                       #echo "$keys => $values <BR>";

                       if ($keys == 'data'){
                          $data = $values;
                          }
                       if ($keys == 'paging'){
                          $paging = $values;
                          }

                       } # foreach 2

               } # foreach 1

       #var_dump($data);

       if (is_array($data)){
 
          for ($event_cnt=0;$event_cnt < count($data);$event_cnt++){

              $end_time = $data[$event_cnt]['end_time'];
              $location = $data[$event_cnt]['location'];
              $name = $data[$event_cnt]['name'];
              $start_time = $data[$event_cnt]['start_time'];
              $timezone = $data[$event_cnt]['timezone'];
              $id = $data[$event_cnt]['id'];
              $rsvp_status = $data[$event_cnt]['rsvp_status'];

              echo "ID: $id <BR>";
              echo "Name: $name <BR>";
              echo "Start Time: $start_time <BR>";
              echo "End Time: $end_time <BR>";
              echo "Location: $location <BR>";
              echo "Timezone: $timezone <BR>";
              echo "RSVP Status: $rsvp_status <BR>";

              } # for         

          } # is array

       } else {

       echo "Your Facebook session needs refreshing.. Please log out and back in again... <P>";

       } 

   break; # end list_events
   case 'return_events':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);
       $facebook_session = new FacebookSession($facebook_session);

       $request = new FacebookRequest($facebook_session,'GET','/'.$fb_session.'/events');
       $response = $request->execute();

       $graphObject = $response->getGraphObject();

       $returnpack = $funky_gear->object_to_array($graphObject);

       foreach ($returnpack as $key=>$value) {

               foreach ($value as $keys=>$values) {

                       if ($keys == 'data'){
                          $data = $values;
                          }
                       if ($keys == 'paging'){
                          $paging = $values;
                          }
 
                       } # foreach 2

               } # foreach 1

       if (is_array($data)){

          echo $data;

          } # is array

       } # if session

   break; # end return_events

  } # end switch for FB

# break; // End FB
##########################################################

?>