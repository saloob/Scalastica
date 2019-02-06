<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-03-28
# Page: api-facebook.php
##########################################################
# api-facebook':

# To be included at index.php - should thus include all common.php params

session_start();

  if (!function_exists('get_param')){
     include ("common.php");
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
#   require_once( 'Facebook/FacebookPermissionException.php' );
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
#   use Facebook\FacebookPermissionException;
   use Facebook\FacebookOtherException;
   use Facebook\FacebookAuthorizationException;
   use Facebook\GraphObject;
   use Facebook\GraphSessionInfo; 

 ################################
 # Do Facebook

 function do_facebook($fb_params){

  global $fb_source_id,$fb_parci_id,$fb_app_id,$fb_app_secret,$portal_title,$hostname,$funky_gear,$portal_info,$portal_confid,$strings,$lingo;

  $fb_action = $fb_params[0];
  $fb_userid = $fb_params[1];

  $service_leadsources_id_c = "c3b95266-d158-bd41-f241-55169e31dbc7";

  switch ($fb_action){

   case 'login':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       $fb_action = $fb_params[0];
       $fb_userid = $fb_params[1];
       $code = $fb_params[2];
       $status = $fb_params[3];

       # If the portal owner has set these features, then initiate
       # Will differ depending on the source (li,g, etc)
       # graph api request for user data
       $external_service_return .= "We will now gather some of your information to initiate your account...<P> ";

       $request = new FacebookRequest( $facebook_session, 'GET', '/me' );
       $response = $request->execute();
       # get response
       $graphObject = $response->getGraphObject()->asArray();
       # print profile data
       #echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
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
       $timezone = $graphObject[timezone];
       $locale = $graphObject[locale];
       $verified = $graphObject[verified];
       $updated_time = $graphObject[updated_time];

       #########################
       # Build rego params

       $rego_params[0]['service_leadsources_id_c'] = $service_leadsources_id_c;
       $rego_params[0]['service_ci_source'] = $fb_source_id; # This will act as the wrapper CI for any userids under it as parent
       $rego_params[0]['service_parci_id'] = $fb_parci_id;
       $rego_params[0]['members_cit_id'] = "b00eaa8c-eeb3-d3a9-cf77-55476eee92c8"; # Facebook Members to be used with parci

       # Collect any services sessions for sync
       require_once ('api-sessions.php');

       # End building rego params
       #########################
       # Pass the details onto the rego function

       $_SESSION['facebook'] = $fb_userid;
       $rego_params[1]['facebook'] = $fb_userid; # add the uid

       # The rego/login params will differ depending on the source
       $rego_params[2]['fb_app_id'] = $fb_app_id;
       $rego_params[2]['fb_app_secret'] = $fb_app_secret;

       $rego_params[3]['account_name'] = $name;
       $rego_params[3]['userid'] = $fb_userid;
       $rego_params[3]['name'] = $name;
       $rego_params[3]['first_name'] = $first_name;
       $rego_params[3]['last_name'] = $last_name;
       $rego_params[3]['email'] = $email;
       $rego_params[3]['timezone'] = $timezone;
       $rego_params[3]['locale'] = $locale;
       $rego_params[3]['password'] = "";

       $rego_params[4]['role_c'] = $role_AccountAdministrator; # all new ones
       $rego_params[4]['security_level'] = 2; # All new ones

       $rego_params[5] = "e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3"; # client

       $rego_params[6]['hostname'] = "";# used for business accounts
       $rego_params[6]['hostname_type'] = "";
   
       $external_service_return .= "<P>We are trying to synchronise with your Facebook account...<P>";    

       $external_service_return .= $funky_gear->do_rego($rego_params);
       $sess_status = "OK";

       # Show the permissions
       #$request = new FacebookRequest($facebook_session,'GET','/'.$fb_userid.'/permissions');
       #$response = $request->execute();
       #$graphObject = $response->getGraphObject()->asArray();

       } else {

       $external_service_return .= "No Session";
       $sess_status = "NG";

       }

    $returner[0] = $sess_status;
    $returner[1] = $external_service_return;

    return $returner;

   break;
   case 'taggable_friends':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       $request = new FacebookRequest($facebook_session,'GET','/'.$fb_userid.'/taggable_friends');

       $response = $request->execute();
       $graphObject = $response->getGraphObject()->asArray();

       $returnpack = $funky_gear->object_to_array($graphObject);

       return $returnpack;

       } # if session

   break;
   case 'return_permissions':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       $request = new FacebookRequest($facebook_session,'GET','/'.$fb_userid.'/permissions');
       $response = $request->execute();
       $graphObject = $response->getGraphObject()->asArray();

       $returnpack = $funky_gear->object_to_array($graphObject);

       return $returnpack;

       } # if session

   break;
   case 'return_picture':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       $request = new FacebookRequest($facebook_session, 'GET', '/'.$fb_userid.'/picture?type=large&redirect=false');
       $response = $request->execute();
       $picture = $response->getGraphObject()->asArray();

       return $picture;

       } # sess

   break;
   case 'return_events':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       $request = new FacebookRequest($facebook_session,'GET','/'.$fb_userid.'/events');
       $response = $request->execute();

       #$graphObject = $response->getGraphObject();
       $graphObject = $response->getGraphObject()->asArray();

       $returnpack = $funky_gear->object_to_array($graphObject);

       return $returnpack;

       } # if session

   break; # end return_events
   case 'return_event':

    $eventid = $fb_params[2];

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       if ( isset ( $eventid ) ) {

          try {

              $request = new FacebookRequest($facebook_session,'GET','/'.$eventid);
              $response = $request->execute();
              #$graphObject = $response->getGraphObject();
              $graphObject = $response->getGraphObject()->asArray();
              $returnpack = $funky_gear->object_to_array($graphObject);
              # the GET response object
              $return_message .= "<pre>".print_r( $graphObject, 1 )."</pre>";

              $returner[0] = $returnpack;
              $returner[1] = $return_message;

              } catch ( FacebookRequestException $e ) {

              # show any error for this facebook request
              $return_message .= "Facebook (get) request error: ".$e->getMessage();

              $returner[0] = "";
              $returner[1] = $return_message;

              } #try

          } # if msg

       return $returner;

       } # is sess

   break; # end return_event
   case 'post_event':

    $link_url = $fb_params[2];
    $message = $fb_params[3];

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       try {

           $response = (new FacebookRequest(
           $facebook_session, 'POST', '/'.$fb_userid.'/feed',
           array(
           'link' => $link_url,
           'message' => $message)))->execute()->getGraphObject();

           $return_message .= "Posted with id: " . $response->getProperty('id');

           $returner[0] = $response->getProperty('id');
           $returner[1] = $return_message;

           } catch(FacebookRequestException $e) {

           $return_message .= "Exception occured, code: " . $e->getCode();
           $return_message .= " with message: " . $e->getMessage();

           $returner[0] = "";
           $returner[1] = $return_message;

           } #posted

       return $returner;

       } # is sess

   break; # end post_event
   case 'post_feed':

    $name = $fb_params[2];
    $caption = $fb_params[3];
    $link = $fb_params[4];
    $message = $fb_params[5];

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       try {
           # with this session I will post a message to my own timeline
           $request = new FacebookRequest($facebook_session,'POST','/'.$fb_userid.'/feed',
           array(
           'name' => $name,
           'caption' => $caption,
           'link' => $link,
           'message' => $message));

           $response = $request->execute();
           $graphObject = $response->getGraphObject();
           # the POST response object
           $return_message .= "<pre>". print_r( $graphObject, 1 )."</pre>";
           $msgid = $graphObject->getProperty('id');

           } catch ( FacebookRequestException $e ) {
           # show any error for this facebook request
           $return_message .= "Facebook (post) request error: ".$e->getMessage();

           } # try

       } # is sess

   break; # end post_feed
   case 'return_feeds':

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       $request = new FacebookRequest($facebook_session,'GET','/'.$fb_userid.'/feeds');
       $response = $request->execute();

       #$graphObject = $response->getGraphObject();
       $graphObject = $response->getGraphObject()->asArray();

       $returner[0] = $graphObject;
       $returner[1] = $return_message;

       return $returner;

       } # is sess

   break; # end return_feeds
   case 'return_feed':

    $msgid = $fb_params[2];

    $facebook_session = $_SESSION['fb_token'];

    if ($facebook_session != NULL) {

       FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

       $facebook_session = new FacebookSession($facebook_session);

       if ( isset ( $msgid ) ) {

          # we only need to the sec. part of this ID
          $parts = explode('_', $msgid);

          try {

              $request2 = new FacebookRequest($facebook_session,'GET','/'.$parts[1]);
              $response2 = $request2->execute();
              $graphObject2 = $response2->getGraphObject();
              # the GET response object
              $return_message .= "<pre>".print_r( $graphObject2, 1 )."</pre>";

              $returner[0] = $graphObject2;
              $returner[1] = $return_message;

              } catch ( FacebookRequestException $e ) {

              # show any error for this facebook request
              $return_message .= "Facebook (get) request error: ".$e->getMessage();

              $returner[0] = "";
              $returner[1] = $return_message;

              } #try

          } # if msg

       return $returner;

       } # is sess

   break; # end return_feed

  } # end switch for FB

 } # end function


function autoload_class($class_name) {
    $directories = array(
        'api/classes/',
        'api/classes/controllers/',
        'api/classes/models/'
    );
    foreach ($directories as $directory) {
        $filename = $directory . $class_name . '.php';
        if (is_file($filename)) {
            require($filename);
            break;
        }
    }
}


 # Do Facebook Function
 ################################
 # Start Body Content

 $external_service_title = "Facebook Login for ".$portal_title;
 $external_service_label = "FacebookLogin";
    
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

 # End Body Content
 ################################
 # Use as default action if passed in from menu

 $action = $_GET['action'];
 if (!$action){
    $action = $_POST['action'];
    }

 $fb_code = $_GET['code'];
 if (!$fb_code){
    $fb_code = $_POST['code'];
    }

 $fb_state = $_GET['state'];
 if (!$fb_state){
    $fb_state = $_POST['state'];
    }

 # mobileapp
 $source = $_GET['source'];
 if (!$source){
    $source = $_POST['source'];
    }
 if (!$source){
    $source = "browserapp";
    }

 ################################
 # Begin the login actions
 if ($action == "login" || $action == "mlogin"){
    $_SESSION['login'] = $action;
    }

 if (($action == "login" || $action == "mlogin" || ($fb_code != NULL && $fb_state != NULL)) && $fb_app_id != NULL && $fb_app_secret != NULL){

    $redirect_login_url = "https://".$hostname."/api-facebook.php";

    $external_service_return .= "We will try to create a fresh session for you...<P> ";

    # initialize your app using your key and secret
    FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);
 
    # create a helper opject which is needed to create a login URL
    # the $redirect_login_url is the page a visitor will come to after login
    $helper = new FacebookRedirectLoginHelper( $redirect_login_url);
 
    # First check if this is an existing PHP session
    if ( isset( $_SESSION ) && isset( $_SESSION['fb_token'] ) ) {
       # create new session from the existing PHP sesson
       $external_service_return .= "We will try to create a fresh session for you...<P> ";
       $facebook_session = new FacebookSession( $_SESSION['fb_token'] );

       try {
           // validate the access_token to make sure it's still valid
           if ( !$facebook_session->validate() ) $facebook_session = null;
              } catch ( Exception $e ) {
              // catch any exceptions and set the sesson null
              $facebook_session = null;
              $external_service_return .= "No session: ".$e->getMessage()."<P>";
              $sess_status = "NG";
              }

       }  elseif ( empty( $facebook_session ) ) {
       // the session is empty, we create a new one
       try {
           # the visitor is redirected from the login, let's pickup the session
           # Will send to top page - should collect the code/status and make the Body div with FB Login
           $facebook_session = $helper->getSessionFromRedirect();
           } catch( FacebookRequestException $e ) {
           # Facebook has returned an error
           $external_service_return .= "Facebook (session) request error: ".$e->getMessage()."<P>";
           $sess_status = "NG";
           } catch( Exception $e ) {
           # Any other error
           $sess_status = "NG";
           $external_service_return .= "Other (session) request error: ".$e->getMessage()."<P>";

           } # try
    
       }  # isset

    if ( isset( $facebook_session ) ) {
       # store the session token into a PHP session
       $_SESSION['fb_token'] = $facebook_session->getToken();
       # and create a new Facebook session using the cururent token
       # or from the new token we got after login
       $facebook_session = new FacebookSession( $facebook_session->getToken() );

       $sess_status = "OK";
       $external_service_return .= "Creating a fresh session was successful!<P> ";

       $fb_params[0] = "login"; #action;
       $fb_params[1] = ""; # userid
       $fb_params[2] = ""; #$fb_code;
       $fb_params[3] = ""; #$fb_state;

       #$fb_params[1] = $fb_userid;
       $show_logindata = do_facebook($fb_params);

       $sess_status = $show_logindata[0]; 
       $external_service_return = $show_logindata[1]; 

       } else {# end if session

#       $external_service_return .= 'No session, please <a href="' . $helper->getLoginUrl( array( 'email', 'user_friends','user_birthday','status_update','publish_stream','publish_actions','read_stream' ) ) . '">Login</a><P>';
       $external_service_return .= 'No session, please.<P><a href="' . $helper->getLoginUrl( array( 'email', 'user_friends','user_birthday','publish_actions','read_stream' ) ) . '"><font size=4><B>Login with Facebook</B></font></a><P>';
  
      $sess_status = "NG";

       } # end else

    } elseif ($do == NULL) {# No FB details - shouldnt be able to try and log-in unless made available by portal owner

    $external_service_return .= "No Facebook app details - please contact the ".$portal_title." administrator...<P>";
    $sess_status = "NG";

    }

 if ( isset( $_SESSION['fb_token']) && $fb_code != NULL && $fb_state != NULL ) {

    $fb_params[0] = "login"; #action;
    $fb_params[1] = ""; # userid
    $fb_params[2] = ""; #$fb_code;
    $fb_params[3] = ""; #$fb_state;

    #$fb_params[1] = $fb_userid;
    $show_logindata = do_facebook($fb_params);

    $sess_status = $show_logindata[0]; 
    $external_service_return = $show_logindata[1]; 

    }

 # End getting login info
 ################################
 # Package for presentation

 $body = $container_top;
 $body .= "<div style=\"".$divstyle_white."\">".$external_service_return."</div>";       
 $body .= $container_bottom;

 #
 #####################################
 #

 if ($sess_status == 'OK' && $_SESSION['login'] == 'login'){

    $leftcolumnwidth = "230px";
    $rightcolumnwidth = "230px";
    $bodycolumnwidth = "510px";

    $left_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$leftcolumnwidth.";\" id=\"".$LeftDIV."\"></div>
<script type=\"text/javascript\">
 ajax_loadContent('$LeftDIV','tr.php?pc=$portalcode&sv=$left_sendvars');
</script>";

    $body_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$bodycolumnwidth.";\" id=\"".$BodyDIV."\">";

    $body_part .= $body;

    $body_part .= "</div>";

    $right_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$rightcolumnwidth.";\" id=\"".$RightDIV."\"></div>
<script type=\"text/javascript\">
 ajax_loadContent('$RightDIV','tr.php?pc=$portalcode&sv=$right_sendvars');
</script>";

 # End Packaging
 ########################
 # Present

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article">
 <head> 
  <title><?php echo $portal_title;?></title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="google-site-verification" content="F8yDhS86LIY3eSdMBPztrEs5kfdzyxCgZufnf9Rlqpw" />
  <meta name="robots" content="ALL,index,follow">
  <meta name="keywords" content="<?php echo $portal_keywords; ?>">
  <meta name="description" content="<?php echo $portal_description; ?>">
  <meta name="revisit-after" content="3 Days">
  <meta name="rating" content="Safe For Kids">
  <meta name="author" content="Scalastica">
  <script type="text/javascript" src="css/<?php echo $portal_skin;?>/frame.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $portal_style; ?>">
  <script type="text/javascript" src="js/common.js"></script>
  <link href="css/<?php echo $portal_skin;?>/custom.css" rel="stylesheet" type="text/css">
  <link href="css/<?php echo $portal_skin;?>/general.css" rel="stylesheet">
  <link href="css/<?php echo $portal_skin;?>/mpc.css" rel="stylesheet" type="text/css">
  <link href="css/<?php echo $portal_skin;?>/layout.css" rel="stylesheet" type="text/css">
  <!--[if IE]><link href="css/<?php echo $portal_skin;?>/ie.css" rel="stylesheet" type="text/css"><![endif]-->
  <link href="css/<?php echo $portal_skin;?>/misc.css" rel="stylesheet" type="text/nonsense">
  <link href="css/<?php echo $portal_skin;?>/<?php echo $portal_skin;?>.css" rel="stylesheet">
  <link id="favicon" rel="icon" type="image/png" href="favicon.ico" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" type="text/css" href="chat/client/themes/default/pfc.min.css" />
  <script src="chat/client/pfc.min.js" type="text/javascript"></script>
  <script type="text/javascript">
   SyntaxHighlighter.all({toolbar:false});
  </script>

 <script type="text/javascript">

 $(document).ready(function(){

   $(".button").click(function){

   var pg = $(this).attr("pg");
   var divid = $(this).attr("divid");
   $("#"+divid).load(pg);

   )}

  )}

  </script>

  <script>
    var width = $(window).width();
    $.ajax({
    url: "screensize.php",
    data : {screenwidth:width} 
    }).done(function() {
    $(this).addClass("done");
    });
  </script>

  <style type="text/css">
  .center{
   height:100%;
   width:980px;
   margin-left: auto;
   margin-right: auto;
   }
  </style>

  <style>
  #GRID { width: 100%; max-height:500px;overflow:scroll; padding: 0.5em; resize: both; }
  #GRID h3 { text-align: center; margin: 0; }
  </style>

  <style>
  .shadow {
  -moz-box-shadow:    3px 3px 5px 6px #ccc;
  -webkit-box-shadow: 3px 3px 5px 6px #ccc;
  box-shadow:         3px 3px 5px 6px #ccc;
   }
  </style>

<?php

include ("css/style.php");

  ?>
 <div style="width:100%;height:55px;margin-left:0px;margin-right:0px;margin-bottom:5px;margin-top:0px;padding-bottom:5px;padding-left:0px;padding-right:0px;background:#000000;">
  <div style="width:98%;height:55px;margin-left: auto;margin-right: auto;padding-top:5px;padding-bottom:5px;margin-bottom:5px;">
   <div class="screenLayout">
    <div class="headerContainer">
     <div class="pageHeader">
      <div><a href="<?php echo $baseurl; ?>" target="<?php echo $portal_title; ?>" title="<?php echo $portal_title; ?>" class="topLogo"><img src="<?php echo $portal_logo; ?>" alt="<?php echo $portal_title; ?>" title="<?php echo $portal_title; ?>"></a><div id="topTxtBlock"><span id="topCopyright"><a href=<?php echo $portal_copyright_url; ?> target="_blank">&copy; <?php echo $portal_copyright_text; ?></a></span></div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <div style="width:98%;height:100%;margin-left: auto;margin-right: auto;">
<?php 

    echo $left_part;
    echo $body_part;
    echo $right_part;

  ?>
 </div>
  <?php

    } elseif ($sess_status == 'OK' && $_SESSION['login'] == 'mlogin'){

    # mobile app return
    
    #$rego_package = array();
    #$rego_package['api_response'] = 'OK';
    #$rego_package['api_message'] = $external_service_return;
    #$rego_package['sess_con'] = $_SESSION['contact_id'];
    #$rego_package['sess_acc'] = $_SESSION['account_id'];
    #$rego_package['facebook'] = $_SESSION['facebook'];

    /**
     * Register autoloader functions.
     */
    #spl_autoload_register('autoload_class');

    #$response_obj = Response::create($rego_package, $_SERVER['HTTP_ACCEPT']);
    #$final_response = $response_obj->render();
    #$final_response = mb_convert_encoding($final_response, "UTF-8", "AUTO");
    #echo $final_response;

    #$url = "https://appery.io/app/view/4f47d7f5-362a-4b3c-8a2f-a4014ed03a5d/Facebook_Me.html?fb_access_token=".$_SESSION['fb_token']."&sess_acc=".$_SESSION['account_id']."&sess_con=".$_SESSION['contact_id'];
    #$url = "https://".$hostname."/test.php";

      $fb_sess = $_SESSION['fb_token'];

        $do_logger = true;

        if ($do_logger == TRUE){

           $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
           $log_name = "Scalastica";
           #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

           $log_content = "api-facebook.php [sess_acc:".$sess_account_id.",sess_con:".$sess_contact_id.", FBSESS:".$fb_sess."]";

           $logparams[0] = $log_location;
           $logparams[1] = $log_name;
           $logparams[2] = $log_content;
           $funky_gear->funky_logger ($logparams);

           }

    #$year = time() + 31536000;
    #$oneday = time() + 93857;
    #setcookie('remember_me', $_POST['username'], $year);
    #setcookie("fb_sess",$fb_sess, $oneday, "/","", 0);

    $logfile = "/tmp/fbsess";
    $fh = fopen ($logfile, 'a');
    $writesess = $fb_sess."[]".$sess_contact_id."[]".$sess_account_id."\n";
    fwrite ($fh, $writesess);
    fclose ($fh);

    #$fb_token = $_COOKIE['fb_sess'];
    #echo $fb_token;
    #exit;

    $url = "https://".$hostname."/mobile/Facebook_Return.html?fb_access_token=".$fb_sess;
    #$url = "http://appery.io/app/view/4f47d7f5-362a-4b3c-8a2f-a4014ed03a5d/Facebook_Return.html?fb_access_token=".$fb_sess;
    header( "Location: $url" );

    } elseif ($sess_status == 'NG' && $_SESSION['login'] == 'login') {# show_login
 #
 #####################################
 #

    echo $body;

    } elseif ($sess_status == 'NG' && $_SESSION['login'] == 'mlogin'){

    echo $body;

    # mobile app return
    /*
    $rego_package = array();
    $rego_package['api_response'] = 'NG';
    $rego_package['api_message'] = $external_service_return;
    $rego_package['sess_con'] = "";
    $rego_package['sess_acc'] = "";
    $rego_package['facebook'] = "";

    spl_autoload_register('autoload_class');

    $response_obj = Response::create($rego_package, $_SERVER['HTTP_ACCEPT']);
    $final_response = $response_obj->render();
    $final_response = mb_convert_encoding($final_response, "UTF-8", "AUTO");
    echo $final_response;
    */

    } 

 # End Presentation
 ################################

# End api-facebook.php
##########################################################
?>