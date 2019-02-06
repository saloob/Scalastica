<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-03-28
# Page: Facebook.php
##########################################################
# case 'Facebook':

#include_once "fbmain.php";
#require_once('Facebook/FacebookSession.php'); 
#echo "fb_source_id $fb_source_id fb_app_id $fb_app_id fb_app_secret $fb_app_secret<BR>";

  if (!function_exists('get_param')){
     include ("common.php");
     }

# FB 
$service_leadsources_id_c = "c3b95266-d158-bd41-f241-55169e31dbc7";

if (!$action){
   $action = 'Login';
   require_once( '../Facebook/HttpClients/FacebookHttpable.php' );
   require_once( '../Facebook/HttpClients/FacebookCurl.php' );
   require_once( '../Facebook/HttpClients/FacebookCurlHttpClient.php' );
   require_once( '../Facebook/Entities/AccessToken.php' );
   require_once( '../Facebook/Entities/SignedRequest.php' );
   require_once( '../Facebook/FacebookSession.php' );
   require_once( '../Facebook/FacebookRedirectLoginHelper.php' );
   require_once( '../Facebook/FacebookRequest.php' );
   require_once( '../Facebook/FacebookResponse.php' );
   require_once( '../Facebook/FacebookSDKException.php' );
   require_once( '../Facebook/FacebookRequestException.php' );
   require_once( '../Facebook/FacebookOtherException.php' );
   require_once( '../Facebook/FacebookAuthorizationException.php' );
   require_once( '../Facebook/GraphObject.php' );
   require_once( '../Facebook/GraphSessionInfo.php' );

   } else {
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
   } 

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

    $baseurl = "https://".$hostname;

    #echo "Base URL: $baseurl <BR>";

    #session_start(); 
    #require_once( 'autoload.php' );

    #new Facebook_FacebookSession();

    ################################
    # Start Content

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = "Facebook Login for ".$portal_title; // container_title
    $container_params[4] = 'FacebookLogin'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);
  
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    #echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
   
    $api_key = $fb_app_id;
    $api_secret = $fb_app_secret;

    #echo "key $api_key secret $api_secret <P>";

    $embedd = "Body@".$lingo."@".$do."@Login@@".$do;
    $embedd = $funky_gear->encrypt($embedd);
    #$redirect_login_url = $baseurl."/?pc=".$embedd;
    $redirect_login_url = $baseurl."/fb/index.php";

    #echo "URL: ".$redirect_login_url."<BR>";

    #$error_code = $_GET['code'];
    #$error_status = $_POST['status'];
    #echo "Code: $error_code<P>";

    # initialize your app using your key and secret
    FacebookSession::setDefaultApplication($api_key, $api_secret);
 
    // create a helper opject which is needed to create a login URL
    // the $redirect_login_url is the page a visitor will come to after login
    $helper = new FacebookRedirectLoginHelper( $redirect_login_url);
 
    // First check if this is an existing PHP session
    if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
       // create new session from the existing PHP sesson
       $fb_session = new FacebookSession( $_SESSION['fb_token'] );

       try {
           // validate the access_token to make sure it's still valid
           if ( !$fb_session->validate() ) $fb_session = null;
              } catch ( Exception $e ) {
              // catch any exceptions and set the sesson null
              $fb_session = null;
              echo 'No session: '.$e->getMessage();
              echo $container_bottom;
              }

       }  elseif ( empty( $fb_session ) ) {
       // the session is empty, we create a new one
       try {
           // the visitor is redirected from the login, let's pickup the session
           $fb_session = $helper->getSessionFromRedirect();
           } catch( FacebookRequestException $e ) {
           // Facebook has returned an error
           echo 'Facebook (session) request error: '.$e->getMessage();
           echo $container_bottom;

           } catch( Exception $e ) {
           // Any other error
           echo 'Other (session) request error: '.$e->getMessage();
           echo $container_bottom;

           } # try

       }  # isset

    if ( isset( $fb_session ) ) {
       // store the session token into a PHP session
       $_SESSION['fb_token'] = $fb_session->getToken();
       // and create a new Facebook session using the cururent token
       // or from the new token we got after login
       $fb_session = new FacebookSession( $fb_session->getToken() );

       // graph api request for user data
       $request = new FacebookRequest( $fb_session, 'GET', '/me' );
       $response = $request->execute();
       // get response
       $graphObject = $response->getGraphObject()->asArray();
       // print profile data
       #echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';

       $fbui = $graphObject[id];
       $email = $graphObject[email];

       #echo "FB UID $fbui $email<BR>";

       // print logout url using session and redirect_uri (logout.php page should destroy the session)
       #echo '<a href="' . $helper->getLogoutUrl( $fb_session, $redirect_login_url ) . '">Logout</a>';

       #var_dump($fb_session);


       /*
       try {
           # with this session I will post a message to my own timeline
           $request = new FacebookRequest(
           $fb_session,
           'POST',
           '/me/feed',
           array(
           'link' => $baseurl,
           'message' => 'Shared Effects - for enhanced meaning, event-driven social collaboration...'
           )
           );
           $response = $request->execute();
           $graphObject = $response->getGraphObject();
           # the POST response object
           echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
           echo $container_bottom;

           $msgid = $graphObject->getProperty('id');

           } catch ( FacebookRequestException $e ) {
           # show any error for this facebook request
           echo 'Facebook (post) request error: '.$e->getMessage();
           echo $container_bottom;

          } # try

       if ( isset ( $msgid ) ) {

          # we only need to the sec. part of this ID
          $parts = explode('_', $msgid);

          try {

              $request2 = new FacebookRequest(
              $session,
              'GET',
              '/'.$parts[1]
              );
              $response2 = $request2->execute();
              $graphObject2 = $response2->getGraphObject();
              # the GET response object
              echo '<pre>' . print_r( $graphObject2, 1 ) . '</pre>';
              echo $container_bottom;

              } catch ( FacebookRequestException $e ) {

              # show any error for this facebook request
              echo 'Facebook (get) request error: '.$e->getMessage();
              echo $container_bottom;

              } #try

          } # if msg

       */

       $sess_contact_id = $_SESSION['contact_id'];
       $sess_account_id = $_SESSION['account_id'];

       $role_c = "9f9eac92-9527-b7fe-926c-527329fc72e1";
       $security_level = 2;

       # Every portal owner can have their own FB access details
       $sess_fb_source_id = $_SESSION['fb_source_id'];
       $sess_fb_userid = $_SESSION["fb_userid"];

       if ($sess_fb_source_id == NULL && $fb_source_id != NULL){
   
          $_SESSION['fb_source_id'] = $fb_source_id;
          $sess_fb_source_id = $_SESSION['fb_source_id'];

          }

       if ($sess_contact_id != NULL && $sess_fb_source_id != NULL && $sess_fb_userid != NULL) {
          $access = TRUE;
          }

       // login or logout url will be needed depending on current user state.
       if ($graphObject && !$access) {
 
          $fb_userid = $graphObject[id];
          $name = $graphObject[name];
          $first_name = $graphObject[first_name];
          $last_name = $graphObject[last_name];
          $link = $graphObject[link];
          $hometown = $graphObject[hometown];
          $hometown_id = $hometown[id];
          $hometown_name = $hometown[name];
          $gender = $graphObject[gender];
          $email = $graphObject[email];

          $process_message .= "<P>Welcome to ".$portal_title.", ".$name."!<P>";
          $process_message .= "<P>Your Registered Email: ".$email."<P>";
          $process_message .= "<P>Your Facebook ID: ".$fb_userid."<P>";
   
          $timezone = $graphObject[timezone];
          $locale = $graphObject[locale];
          $verified = $graphObject[verified];
          $updated_time = $graphObject[updated_time];

          $fb_object_type = "ConfigurationItems";
          $fb_action = "select";
          $fb_params = "";
          $fb_params[0] = " deleted=0 && sclm_configurationitems_id_c='".$fb_source_id."' && name='".$fb_userid."' ";
          $fb_params[1] = "id,name,contact_id_c,account_id_c";
          $fb_params[2] = "";
          $fb_params[3] = "";
          $fb_params[4] = "";
   
          $fb_rows = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $fb_object_type, $fb_action, $fb_params);

          if (is_array($fb_rows)){

             for ($fb_cnt=0;$fb_cnt < count($fb_rows);$fb_cnt++){

                 $fb_ci_id = $fb_rows[$fb_cnt]['id'];
                 #$fb_userid = $fb_rows[$fb_cnt]['name'];
                 $fb_contact_id_c = $fb_rows[$fb_cnt]['contact_id_c'];
                 $fb_account_id_c = $fb_rows[$fb_cnt]['account_id_c'];

                 } # for

             if ($fb_contact_id_c != NULL){
  
                $process_message .= "Your Facebook Account is registered with ".$portal_title."!<P>";
       
                $_SESSION["fb_userid"] = $fb_userid;
                $_SESSION["contact_id"] = $fb_contact_id_c;
                $_SESSION["account_id"] = $fb_account_id_c;
                $_SESSION["fb_source_id"] = $fb_source_id;  
                $_SESSION['security_level'] = $security_level;
                $_SESSION['security_role'] = $role_c;
   
                $process_message .= "<a href=".$baseurl." target=_parent>Click here</a> to continue...";
          
                }

             if ($fb_contact_id_c == NULL && $fb_userid != NULL){
   
                $process_message .= "Your Facebook Account has been registered with ".$portal_title." - but an account was not created, we will do so now...<P>";

                # The account wasn't created for some reason...

                $object_type = "Contacts";
                $action = "create";
                $params = array(
                            array('name'=>'first_name','value' => $first_name),
                            array('name'=>'last_name','value' => $last_name),
                            array('name'=>'email1','value' => $email),
                            array('name'=>'role_c', 'value' => $role_c) // Account Admin
                            );

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);

                $fb_contact_id_c = $result['id'];

                $_SESSION['security_level'] = $security_level;
                $_SESSION['security_role'] = $role_c;

                $rego_object_type = "Accounts";
                $rego_action = "create";
                $rego_params = array();
                $rego_params = array(
                    array('name'=>'id','value' => ""),
                    array('name'=>'name','value' => $first_name),
                    ); 

                $acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                $fb_account_id_c = $acc_result['id'];     

                $_SESSION['account_id'] = $fb_account_id_c;
                $sess_account_id = $fb_account_id_c;

                $rego_object_type = "Relationships";
                $rego_action = "set_modules_soap";
                $rego_params = array();
                $rego_params[0] = "Accounts";
                $rego_params[1] = $fb_account_id_c;
                $rego_params[2] = "Contacts";
                $rego_params[3] = $fb_contact_id_c;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Set Parent Account
                $process_params = array();
                $process_params[0] = "Accounts";
                $process_params[1] = $parent_account_id;
                $process_params[2] = "Accounts";
                $process_params[3] = $fb_account_id_c;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                // Add Administrator to the Account
                $rego_object_type = "Accounts";
                $rego_action = "update";

                $rego_params = array(
                array('name'=>'id','value' => $fb_account_id_c),
                array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                array('name'=>'account_id_c','value' => $parent_account_id),
                ); 

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Add Administrator to the Account
                $rego_params = array(
                array('name'=>'id','value' => $fb_contact_id_c),
                array('name'=>'account_id','value' => $fb_account_id_c),
                ); 

                $rego_object_type = "Contacts";
                $rego_action = "update";

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Add Account relationship
                $par_account_returner = $funky_gear->object_returner ("Accounts", $parent_account_id);
                $par_account_name = $par_account_returner[0];
                $ar_name = $par_account_name. " (Parent) -> ".$first_name." (Child)";
                $description = $ar_name; 

                $process_object_type = "AccountRelationships";
                $process_action = "update";

                $process_params = array();  
                $process_params[] = array('name'=>'name','value' => $ar_name);
                $process_params[] = array('name'=>'assigned_user_id','value' => '1');
                $process_params[] = array('name'=>'description','value' => $description);
                $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id);
                $process_params[] = array('name'=>'account_id1_c','value' => $account_id);
                $process_params[] = array('name'=>'entity_type','value' => $entity_type);

                $ar_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $account_rel_id = $ar_result['id'];


                # Create fbuser entry - with contact

                $object_type = "ConfigurationItems";
                $action = "update";
                $params = "";
                $params = array(
                            array('name'=>'name','value' => $fb_userid),
                            array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                            array('name'=>'account_id_c','value' => $fb_account_id_c),
                            array('name'=>'sclm_configurationitems_id_c','value' => $fb_source_id),
                            #array('name'=>'sclm_configurationitemtypes_id_c','value' => '90b3d066-c1b4-7e42-8f2b-54fe44936c60'),
                            array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed),
                            );   

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
                $source_id = $result['id'];    

                $object_type = "Contacts";
                $action = "create_sclm_ContactsSources";
                $params = "";
                $params = array(
                   array('name'=>'name','value' => $first_name." on ".$portal_title." via Facebook"),
                   array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                   array('name'=>'account_id_c','value' => $fb_account_id_c),
                   array('name'=>'source_id','value' => $source_id),
                   array('name'=>'sclm_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
    
                $process_message .= "You have successfully linked your Facebook Account to ".$portal_title."...<P>";
       
                $_SESSION["source_id"] = $source_id;
                $_SESSION["contact_id"] = $fb_contact_id_c;
                #$_SESSION["sclm_leadsources_id_c"] = $service_leadsources_id_c;
    
                $process_message .= "<a href=".$baseurl." target=_parent>Click here</a> to continue...";

                } // end if no contact
   
             } else {
   
             // Not - must create
             $process_message .= "Your Facebook Account is not yet registered with ".$portal_title." - we will now check if your email (".$email." & FBID: ".$fb_userid.") exists with us...<P>";
   
             $object_type = "Contacts";
             $action = "contact_by_email";
             $params = $email; // query

             $fb_contact_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
             $count = $result['result_count'];

             if ($count > 0){
 
                $process_message .= "Your Facebook Account email (".$email.") exists with us already - we will now link it to ".$portal_title."...<P>";
                # Create account entry - with contact
                $accid_object_type = "Contacts";
                $accid_action = "get_account_id";
                $accid_params[0] = $fb_contact_id_c;
                $accid_params[1] = "account_id";
                $fb_account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

                if ($fb_account_id_c != NULL){
   
                   $_SESSION['account_id'] = $fb_account_id_c;
                   $sess_account_id = $fb_account_id_c;

                   } else {

                   $rego_object_type = "Accounts";
                   $rego_action = "create";
                   $rego_params = array();
                   $rego_params = array(
                       array('name'=>'id','value' => ""),
                       array('name'=>'name','value' => $first_name),
                       ); 

                   $acc_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                   $fb_account_id_c = $acc_result['id'];     

                   $_SESSION['account_id'] = $fb_account_id_c;
                   $sess_account_id = $fb_account_id_c;

                   } # end create account

                $rego_object_type = "Relationships";
                $rego_action = "set_modules_soap";
                $rego_params = array();
                $rego_params[0] = "Accounts";
                $rego_params[1] = $fb_account_id_c;
                $rego_params[2] = "Contacts";
                $rego_params[3] = $fb_contact_id_c;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Set Parent Account
                $process_params = array();
                $process_params[0] = "Accounts";
                $process_params[1] = $parent_account_id;
                $process_params[2] = "Accounts";
                $process_params[3] = $fb_account_id_c;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                // Add Administrator to the Account
                $rego_object_type = "Accounts";
                $rego_action = "update";

                $rego_params = array(
                array('name'=>'id','value' => $fb_account_id_c),
                array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                array('name'=>'account_id_c','value' => $parent_account_id),
                ); 

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Add Administrator to the Account
                $rego_params = array(
                array('name'=>'id','value' => $fb_contact_id_c),
                array('name'=>'account_id','value' => $fb_account_id_c),
                ); 

                $rego_object_type = "Contacts";
                $rego_action = "update";

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Add Account relationship
                $par_account_returner = $funky_gear->object_returner ("Accounts", $parent_account_id);
                $par_account_name = $par_account_returner[0];
                $ar_name = $par_account_name. " (Parent) -> ".$first_name." (Child)";
                $description = $ar_name; 

                $process_object_type = "AccountRelationships";
                $process_action = "update";

                $process_params = array();  
                $process_params[] = array('name'=>'name','value' => $ar_name);
                $process_params[] = array('name'=>'assigned_user_id','value' => '1');
                $process_params[] = array('name'=>'description','value' => $description);
                $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id);
                $process_params[] = array('name'=>'account_id1_c','value' => $fb_account_id_c);
                $process_params[] = array('name'=>'entity_type','value' => $entity_type);

                $ar_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $account_rel_id = $ar_result['id'];

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
                   $accparams[0] = "id_c='".$parent_account_id."' ";
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
                   $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id); # Parent owns this 
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
                   $process_params[] = array('name'=>'name','value' => $fb_account_id_c);
                   $process_params[] = array('name'=>'enabled','value' => 1);
                   $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $rel_acc_id);
                   $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $shared_account_ci);
                   $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                   $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id); # Parent owns this 
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
                   $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id); # Parent owns this 
                   $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
                   $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                   $process_params[] = array('name'=>'image_url','value' => $image_url);

                   $port_access_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                   $port_access_id = $port_access_result['id'];

                   } # end is_array($ci_items

                $object_type = "ConfigurationItems";
                $action = "update";
                $params = "";
                $params = array(
                            array('name'=>'name','value' => $fb_userid),
                            array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                            array('name'=>'account_id_c','value' => $fb_account_id_c),
                            array('name'=>'sclm_configurationitems_id_c','value' => $fb_source_id),
                            array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed),
                            );   

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
                $source_id = $result['id'];    

                $object_type = "Contacts";
                $action = "create_sclm_ContactsSources";
                $params = array(
                   array('name'=>'name','value' => $first_name." from ".$portal_title." on Facebook"),
                   array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                   array('name'=>'account_id_c','value' => $fb_account_id_c),
                   array('name'=>'source_id','value' => $source_id),
                   array('name'=>'sclm_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 
   
                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
       
                $process_message .= "Your existing Account has now been linked to your Facebook account and ".$portal_title."...<P>";
       
                $_SESSION["source_id"] = $source_id;
                $_SESSION["contact_id"] = $fb_contact_id_c;
                #$_SESSION['account_id'] = $fb_account_id_c;
                $_SESSION["sclm_leadsources_id_c"] = $service_leadsources_id_c;

                $_SESSION["fb_userid"] = $fb_userid;
                $_SESSION["fb_source_id"] = $fb_source_id;  
    
                $process_message .= "<a href=".$baseurl." target=_parent>Click here</a> to continue...";

                echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

                } else {// is count by email 
    
                // Assume this is not in our DB for anything - and create new completely
                // User doesn't exist by email - create new contact
                $rego_object_type = "Contacts";
                $rego_action = "create";
                $rego_params = array(
                            array('name'=>'first_name','value' => $first_name),
                            array('name'=>'last_name','value' => $last_name),
                            array('name'=>'email1','value' => $email),
                            array('name'=>'role_c', 'value' => $role_c) // Account Admin
                            );   

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);
                $fb_contact_id_c = $result['id'];

                $_SESSION["source_id"] = $source_id;
                $_SESSION["contact_id"] = $fb_contact_id_c;

                # Create account entry - with contact
                $accid_object_type = "Contacts";
                $accid_action = "get_account_id";
                $accid_params[0] = $fb_contact_id_c;
                $accid_params[1] = "account_id";
                $fb_account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

                if ($fb_account_id_c != NULL){

                   $_SESSION['account_id'] = $fb_account_id_c;
                   $sess_account_id = $fb_account_id_c;

                   }

                $rego_object_type = "Relationships";
                $rego_action = "set_modules_soap";
                $rego_params = array();
                $rego_params[0] = "Accounts";
                $rego_params[1] = $fb_account_id_c;
                $rego_params[2] = "Contacts";
                $rego_params[3] = $fb_contact_id_c;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Set Parent Account
                $process_params = array();
                $process_params[0] = "Accounts";
                $process_params[1] = $parent_account_id;
                $process_params[2] = "Accounts";
                $process_params[3] = $fb_account_id_c;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                // Add Administrator to the Account
                $rego_object_type = "Accounts";
                $rego_action = "update";

                $rego_params = array(
                array('name'=>'id','value' => $fb_account_id_c),
                array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                array('name'=>'account_id_c','value' => $parent_account_id),
                ); 

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Add Administrator to the Account
                $rego_params = array(
                array('name'=>'id','value' => $fb_contact_id_c),
                array('name'=>'account_id','value' => $fb_account_id_c),
                ); 

                $rego_object_type = "Contacts";
                $rego_action = "update";

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Add Account relationship
                $par_account_returner = $funky_gear->object_returner ("Accounts", $parent_account_id);
                $par_account_name = $par_account_returner[0];
                $ar_name = $par_account_name. " (Parent) -> ".$first_name." (Child)";
                $description = $ar_name; 

                $process_object_type = "AccountRelationships";
                $process_action = "update";

                $process_params = array();  
                $process_params[] = array('name'=>'name','value' => $ar_name);
                $process_params[] = array('name'=>'assigned_user_id','value' => '1');
                $process_params[] = array('name'=>'description','value' => $description);
                $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id);
                $process_params[] = array('name'=>'account_id1_c','value' => $fb_account_id_c);
                $process_params[] = array('name'=>'entity_type','value' => $entity_type);

                $ar_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $account_rel_id = $ar_result['id'];

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
                   $accparams[0] = "id_c='".$parent_account_id."' ";
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
                   $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id); # Parent owns this 
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
                   $process_params[] = array('name'=>'name','value' => $fb_account_id_c);
                   $process_params[] = array('name'=>'enabled','value' => 1);
                   $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $rel_acc_id);
                   $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $shared_account_ci);
                   $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                   $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id); # Parent owns this 
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
                   $process_params[] = array('name'=>'account_id_c','value' => $parent_account_id); # Parent owns this 
                   $process_params[] = array('name'=>'contact_id_c','value' => $account_admin_id); # Parent owns this
                   $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
                   $process_params[] = array('name'=>'image_url','value' => $image_url);

                   $port_access_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                   $port_access_id = $port_access_result['id'];

                   } # end is_array($ci_items

                $object_type = "ConfigurationItems";
                $action = "update";
                $params = "";
                $params = array(
                            array('name'=>'name','value' => $fb_userid),
                            array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                            array('name'=>'account_id_c','value' => $fb_account_id_c),
                            array('name'=>'sclm_configurationitems_id_c','value' => $fb_source_id),
                            array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed),
                            );   

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
                $source_id = $result['id'];   

                // Create Password entry

                $rego_object_type = "Contacts";
                $rego_action = "update_password";
                $rego_params = array();
                $rego_params[0] = $fb_contact_id_c;
                $randpass = $funky_gear->createRandomPassword();
                $rego_params[1] = $randpass;

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);

                // Create cmv_ContactsSources entry - with existing contact
    
                $rego_object_type = "Contacts";
                $rego_action = "create_sclm_ContactsSources";
                $rego_params = array(
                   array('name'=>'name','value' => $first_name." on ".$portal_title." via Facebook"),
                   array('name'=>'contact_id_c','value' => $fb_contact_id_c),
                   array('name'=>'account_id_c','value' => $fb_account_id_c),
                   array('name'=>'source_id','value' => $source_id),
                   array('name'=>'sclm_leadsources_id_c','value' => $service_leadsources_id_c) 
                   ); 

                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $rego_object_type, $rego_action, $rego_params);
    
                $process_message .= "You have successfully linked your Facebook Account to ".$portal_title."...<P>";
    
                $_SESSION["source_id"] = $source_id;
                $_SESSION["contact_id"] = $fb_contact_id_c;
                $_SESSION["sclm_leadsources_id_c"] = $service_leadsources_id_c;
                $_SESSION["fb_userid"] = $fb_userid;
                $_SESSION["fb_source_id"] = $fb_source_id;  

                // Send rego email
                $lingo = "en";
                $type = 1;
                $subject = $portal_title." Account Registration";
                $body = $first_name.", you have tried to register with ".$portal_title." with the following email address;\n
          Email: ".$email."\n
          Please use the following password to access your account;\n
          Password: ".$randpass." \n
          URL: ".$baseurl." \n
          Enyoy using ".$portal_title."!";
                $from_name = $portal_shortname;
                $from_email = $portal_email;

                $to_name = $first_name." ".$last_name;

                $from_name = $portal_title;
                $from_email = $portal_email;
                $from_email_password = $portal_email_password;

                $mailparams[0] = $from_name;
                #$mailparams[1] = $to_name;
                $mailparams[2] = $from_email;
                $mailparams[3] = $from_email_password;
                #$mailparams[4] = $to_email;
                $type = 1;
                $mailparams[5] = $type;
                $mailparams[6] = $lingo;
                $mailparams[7] = $subject;
                $mailparams[8] = $body;
                $mailparams[9] = $portal_email_server;
                $mailparams[10] = $portal_email_smtp_port;
                $mailparams[11] = $portal_email_smtp_auth;

                $internal_to_addressees[$email] = $to_name;
                $mailparams[12] = $internal_to_addressees;
                $mailparams[20] = $attachments;

                $emailresult = $funky_gear->do_email ($mailparams);

                if ($emailresult[0] == 'OK'){

                   $process_message .= "<P><B><font size=3>Account Created Successfully! Please check your email to get your password - it has been sent there.</font></B><P>";

                   #$fb_sendvars = "Body@".$lingo."@Contacts@view@".$fb_contact_id_c."@Facebook";
                   #$fb_sendvars = $funky_gear->encrypt($fb_sendvars);
                   #$process_message .= "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"fb_connect_form\" value=\"Facebook\" onClick=\"loader('lightform');doBPOSTRequest('lightform','tr.php', 'pc=".$portalcode."&sv=".$fb_sendvars."&sendiv=lightform');cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';return false\">";

                   } else {

                   $process_message .= "<P><B><font size=3>There seems to be a problem sending to this email - please check with the Administrator by contacting directly by email to: ".$portal_email.".</font></B><P>";

                   }
        
                } // end creating new source and contact
   
             } // end if not in DB

          } else { // end if not ($graphObject && !$access)

          $fb_userid = $graphObject[id];
          $name = $graphObject[name];
          $first_name = $graphObject[first_name];
          $last_name = $graphObject[last_name];
          $link = $graphObject[link];
          $hometown = $graphObject[hometown];
          $hometown_id = $hometown[id];
          $hometown_name = $hometown[name];
          $gender = $graphObject[gender];
          $email = $graphObject[email];

          $process_message .= "<P><B><font size=3>Account Exists! Welcome back!</font></B><P>";

          $process_message .= "<P>Welcome back to ".$portal_title.", ".$name."!<P>";
          $process_message .= "<P>Your Registered Email: ".$email."<P>";
          $process_message .= "<P>Your Facebook ID: ".$fb_userid."<P>";
   
          $timezone = $graphObject[timezone];
          $locale = $graphObject[locale];
          $verified = $graphObject[verified];
          $updated_time = $graphObject[updated_time];

          $process_message .= "<a href=".$baseurl." target=_parent>Click here</a> to continue...";

          } 

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";        
       echo $container_bottom;

       } else {

       # we need to create a new session, provide a login link

       $process_message .= 'No session, please <a href="' . $helper->getLoginUrl( array( 'email', 'user_friends','user_birthday','status_update','publish_stream','publish_actions' ) ) . '">Login</a>';

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";   
       echo $container_bottom;

       } # no FB Access

   break;
   case 'SetApp':

    echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    $ci_params[0] = "sclm_configurationitems_id_c='".$val."' ";
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

   break;
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

   break;
   case 'AddPost':

    //update user's status using graph api
    $message = $sent_params[0];
    if ($message != NULL){
     try {
      $statusUpdate = $facebook->api('/me/feed', 'post', array('message'=> $message, 'cb' => ''));
      } catch (FacebookApiException $e) {
      d($e);
      }
     } // end status update
     
   break; // end update status
   case 'Comment':
   
    //SELECT comments FROM stream WHERE post_id = '21554873967_159387837420472'"
   
   break; // end comment
   case 'AddPhoto':

    $app_id = "YOUR_APP_ID";
    $app_secret = "YOUR_APP_SECRET"; 
    $my_url = "YOUR_POST_LOGIN_URL"; 
 
    $code = $_REQUEST["code"];

    if (empty($code)) {
       $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
        . $app_id . "&redirect_uri="  . urlencode($my_url) 
        . "&scope=publish_stream";
       echo("<script>top.location.href='" . $dialog_url . "'</script>");
       }

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
    . $app_id . "&redirect_uri=" . urlencode($my_url) 
    . "&client_secret=" . $app_secret . "&code=" . $code;

    $access_token = file_get_contents($token_url);
   
    $batched_request = '[{"method":"POST", "relative_url":"me/photos",' 
    . ' "body" : "message=My cat photo", "attached_files":"file1"},'
    . '{"method":"POST", "relative_url":"me/photos",' 
    . ' "body" : "message=My dog photo", "attached_files":"file2"}]';
 
    $post_url = "https://graph.facebook.com/" . "?batch="
    .  urlencode($batched_request) . "&". $access_token 
    . "&method=post";
  
    echo ' <form enctype="multipart/form-data" action="'.$post_url.'" 
       method="POST">';
    echo 'Please choose 2 files:';
    echo '<input name="file1" type="file">';
    echo '<input name="file2" type="file">';
    echo '<input type="submit" value="Upload" />';
    echo '</form>';

   break;
   case 'AddVideo':

$app_id = "YOUR_APP_ID";
$app_secret = "YOUR_APP_SECRET"; 
$my_url = "YOUR_POST_LOGIN_URL"; 
$video_title = "YOUR_VIDEO_TITLE";
$video_desc = "YOUR_VIDEO_DESCRIPTION";

$code = $_REQUEST["code"];

if(empty($code)) {
   $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
     . $app_id . "&redirect_uri=" . urlencode($my_url) 
     . "&scope=publish_stream";
    echo("<script>top.location.href='" . $dialog_url . "'</script>");
}

$token_url = "https://graph.facebook.com/oauth/access_token?client_id="
    . $app_id . "&redirect_uri=" . urlencode($my_url) 
    . "&client_secret=" . $app_secret 
    . "&code=" . $code;
$access_token = file_get_contents($token_url);
 
$post_url = "https://graph-video.facebook.com/me/videos?"
    . "title=" . $video_title. "&description=" . $video_desc 
    . "&". $access_token;

echo '<form enctype="multipart/form-data" action=" '.$post_url.' "  
     method="POST">';
echo 'Please choose a file:';
echo '<input name="file" type="file">';
echo '<input type="submit" value="Upload" />';
echo '</form>';

   break;
   case 'InviteFriends':

    echo $_GET["msg"]."<P>";

    $fbuserid = $fbme[id];
    $fbname = $fbme[name];

    // Retrieve array of friends who've already added the app.  
    $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.') AND has_added_app = 1'; 
    $_friends = $facebook->api(array(
    'method' => 'fql.query',
    'query' =>$fbfriendquery,
    ));
 
    // Extract the user ID's returned in the FQL request into a new array.  
    $friends = array();  
    if (is_array($_friends) && count($_friends)) {  
       foreach ($_friends as $friend) {  
                $friends[] = $friend['uid'];  
                }  
       }  
  
     // Convert the array of friends into a comma-delimeted string.  
     $friends = implode(',', $friends);  
  
     // Prepare the invitation text that all invited users will receive.  
     $sNextUrl = urlencode("&refuid=".$fbuid);

?>

    <div id="fb-root"></div>
    <script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
     <script type="text/javascript">
       FB.init({
         appId  : '<?php echo $fb_app_id; ?>',
         status : true, // check login status
         cookie : true, // enable cookies to allow the server to access the session
         xfbml  : true  // parse XFBML
       });
     </script>


<fb:serverFbml condensed="true" style="width:400px;">
    <script type="text/fbml">
      <fb:fbml>
          <fb:request-form
                    action="<?php echo $config['baseurl']; ?>"
                    target="_top"
                    method="POST"
                    invite="true"
                    type="<?php echo $portal_title; ?>"
                    content="<?php echo$_GET["msg"]; ?>"
                    label="Accept"
                    <fb:multi-friend-selector
                    showborder="false" exclude_ids="<?=$friends?>"
                    actiontext="<?php echo$_GET["msg"]; ?>">
        </fb:request-form>
      </fb:fbml>
    </script>
  </fb:serverFbml>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<script>
FB.init({
appId:'<?php echo $fbconfig['appid']; ?>',
cookie:true,
status:true,
xfbml:true
});

function FacebookInviteFriends()
{
FB.ui({
method: 'apprequests',
message: '<?php echo $_GET["msg"]; ?>'
});
}
</script>

<div id="fb-root"></div>
<a href='#' onclick="FacebookInviteFriends();">Click here to select which Facebook friends to invite to this Action</a>

<?php

   break;
   case 'ShowFriendsList':

    $config['baseurl'] = $portal_config['portalconfig']['baseurl']; 

    $app_id = $fbconfig['appid'];
    $app_secret = $fbconfig['secret'];
    $my_app_url = $config['baseurl'];
    $fbapikey = $fbconfig['api'];

echo "app_id  $app_id <P>";

    $code = $_REQUEST["code"];

    if (empty($code)) {

       }

//var_dump ($fbme);

    echo "Hello " . $fbname."<P>";

    // Retrieve array of friends who've already added the app.  
    // $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.') AND has_added_app = 1'; 

    // Retrieve array of friends who have not added the app
    $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.') AND has_added_app = 0'; 
    $_friends = $facebook->api(array(
'method' => 'fql.query',
'query' =>$fbfriendquery,
));

    // Extract the user ID's returned in the FQL request into a new array.  
    $friends = array();  
    $frcnt = 0;

    $tablefields = "";
    $tblcnt = 0;

//var_dump ($_friends);

    if (is_array($_friends) && count($_friends)) {  

       foreach ($_friends as $friend) {  

               $this_friend_id = $friend['uid']; 

               echo "Friend's ID: ".$this_friend_id."<BR>";
               $friends[$frcnt]['uid'] = $friendsdata['uid']; 
               $frcnt++;
               }

       for ($tblcnt=0;$tblcnt < count($friends);$tblcnt++){

           $uid = $friends[$tblcnt]['uid'];

           $newfbfriendquery = "SELECT uid,name,email FROM user WHERE uid='".$uid."'"; 
           $_friendsdata = $facebook->api(array(
'method' => 'fql.query',
'query' =>$newfbfriendquery,
));
           if (is_array($_friendsdata) && count($_friendsdata)) {  

              foreach ($_friendsdata as $friendsdata) {  

                      $myfriends[$frcnt]['uid'] = $friendsdata['uid']; 
                      $myfriends[$frcnt]['name'] = $friendsdata['name']; 
                      $myfriends[$frcnt]['email'] = $friendsdata['email'];

                      $frcnt++;

                      } // for each

              } // if is array

           } // for uid

       } // is array uid

    for ($tblcnt=0;$tblcnt < count($myfriends);$tblcnt++){

        $uid = $myfriends[$tblcnt]['uid'];
        $name = $myfriends[$tblcnt]['name'];
        $email = $myfriends[$tblcnt]['email'];

        $tablefields[$tblcnt][0] = "uid-".$uid; // Field Name
        $tablefields[$tblcnt][1] = $name; // Full Name
        $tablefields[$tblcnt][2] = 1; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 0; // is_name
        $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = '0'; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
        $tablefields[$tblcnt][10] = '';//1; // show in view 
        $tablefields[$tblcnt][11] = ''; // Field ID
        $tablefields[$tblcnt][20] = "uid-".$uid; //$field_value_id;
        $tablefields[$tblcnt][21] = 1; //$field_value;   

/*
           $tblcnt++;

           $tablefields[$tblcnt][0] = "uid"; // Field Name
           $tablefields[$tblcnt][1] = $friend['uid']; // Full Name
           $tablefields[$tblcnt][2] = 0; // is_primary
           $tablefields[$tblcnt][3] = 0; // is_autoincrement
           $tablefields[$tblcnt][4] = 0; // is_name
           $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$tblcnt][6] = '255'; // length
           $tablefields[$tblcnt][7] = '0'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = '1';//1; // show in view 
           $tablefields[$tblcnt][11] = ''; // Field ID
           $tablefields[$tblcnt][20] = "uid"; //$field_value_id;
           $tablefields[$tblcnt][21] = $friend['uid']; //$field_value;   

           $tblcnt++;
*/
        } // end for loop
  
    $valpack = "";
    $valpack[0] = 'Facebook';
    $valpack[1] = "add"; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = ""; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = 1; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);
    
    echo "<img src=images/blank.gif width=550 height=10><BR>";

    echo $zaform;

       // Convert the array of friends into a comma-delimeted string.  
       //$friends = implode(',', $friends);  
  
       // Prepare the invitation text that all invited users will receive.  
       //$sNextUrl = urlencode("&refuid=".$fbuid);

   break;

  } // end action switch  
 
?>

 </body>
</html>

<?php

# break; // End Governments Data
##########################################################

?>