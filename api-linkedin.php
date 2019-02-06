<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-04-01
# Page: api-linkedin.php 
##########################################################
#

session_start();

  if (!function_exists('get_param')){
     include ("common.php");
     }

 include_once "linkedin/linkedin.php";

 ################################
 # Do LinkedIn

 function do_linkedin($li_params){

  global $li_source_id,$li_parci_id,$li_app_id,$li_app_secret,$portal_title,$hostname,$funky_gear,$portal_info,$portal_confid,$strings,$lingo;

  $li_action = $li_params[0];
  $li_userid = $li_params[1];

  $service_leadsources_id_c = "b072a533-4274-cdd8-5f64-5518f035719a";

  $callback_url = "https://".$hostname."/api-linkedin.php";

  $linkedin = new LinkedIn($li_app_id, $li_app_secret, $callback_url );

  $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
  $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
  $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);

  switch ($li_action){

   case 'login':

    # You now have a $linkedin->access_token and can make calls on behalf of the current member

    $external_service_return .= "We will now gather some of your information to initiate your account...<P> ";

    $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,email-address,headline,picture-url)");

    #$user = fetch('GET', '/v1/people/~:(first-name,last-name,location:(name,country:(code)),num-connections,headline,industry,specialties,summary,public-profile-url,email-address,interests,publications,languages,skills,three-current-positions,phone-numbers,main-address,twitter-accounts,primary-twitter-account,educations,num-recommenders)');
    #$search_response = $linkedin->search("?company-name=facebook&count=10");
    #$xml = simplexml_load_string($search_response);

    $linkedin_response = json_decode(json_encode((array)simplexml_load_string($xml_response)),1);

    $li_userid = $linkedin_response['id'];
    $first_name = $linkedin_response['first-name'];
    $last_name = $linkedin_response['last-name'];
    $email = $linkedin_response['email-address'];
    $headline = $linkedin_response['headline'];
    $picture_url = $linkedin_response['picture-url'];

    if ($li_userid != NULL){

       $external_service_return .= "<img src=".$picture_url." width=400><P>ID: ".$li_userid."<BR>Name: ".$first_name." ".$last_name."<BR>Email: ".$email."<BR>Headline: ".$headline."<P>";

       #########################
       # Build rego params

       $rego_params[0]['service_leadsources_id_c'] = $service_leadsources_id_c;
       $rego_params[0]['service_ci_source'] = $li_source_id; # This will act as the wrapper CI for any userids under it as parent
       $rego_params[0]['service_parci_id'] = $li_parci_id;
       $rego_params[0]['members_cit_id'] = "b888cb29-df91-08da-4da9-55476f3a99ff"; # LinkedIn Members to be used with parci

       # Collect any services sessions for sync
       require_once ('api-sessions.php');

       # End building rego params
       #########################
       # Pass the details onto the rego function

       #$_SESSION['linkedin'] = $li_userid;
       #$rego_params[1]['linkedin'] = $li_userid; # add the uid

       # The rego/login params will differ depending on the source
       $rego_params[2]['li_app_id'] = $li_app_id;
       $rego_params[2]['li_app_secret'] = $li_app_secret;

       $rego_params[3]['account_name'] = $headline;
       $rego_params[3]['userid'] = $li_userid;
       $rego_params[3]['name'] = $first_name." ".$last_name;
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
   
       $external_service_return .= "<P>We are trying to synchronise with your Linkedin account...<P>";    

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
   case 'get_info':

    $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,email-address,headline,picture-url)");

    $linkedin_response = json_decode(json_encode((array)simplexml_load_string($xml_response)),1);

    /*
    $li_userid = $linkedin_response['id'];
    $first_name = $linkedin_response['first-name'];
    $last_name = $linkedin_response['last-name'];
    $email = $linkedin_response['email-address'];
    $headline = $linkedin_response['headline'];
    $picture_url = $linkedin_response['picture-url'];
    */

    return $linkedin_response;

   break;
   case 'get_contacts':

    $connectionsParams = array();
    $connectionsParams[0] = 'all';
    $connectionsParams[1] = $li_userid;
    $xml_response = $linkedin->get_connections($connectionsParams);

    $connections_response = json_decode(json_encode((array)simplexml_load_string($xml_response)),1);

    if ($connections_response != NULL){

       #var_dump($connections_response);

       #$connections_array = new SimpleXMLElement($connections_response);

       $cnt = 0;

       foreach ($connections_response as $connkey => $connval) {

               #echo "Key1: ".$connkey." & Value1: ".$connval."<BR>";

               if ($connkey == 'person'){

                  foreach ($connval as $key1 => $val1) {

                  foreach ($val1 as $key2 => $val2) {

                          #echo "Key2: ".$key2." & Value2: ".$val2."<BR>";

                          if ($key2 == 'id'){
                             $linkedin_id = $val2;
                             }

                          if ($key2 == 'first-name'){
                             $first_name = $val2;
                             }

                          if ($key2 == 'last-name'){
                             $last_name = $val2;
                             }

                          if ($key2 == 'email-address'){
                             $email = $val2;
                             }

                          if ($key2 == 'headline'){
                             $headline = $val2;
                             }

                          if ($key2 == 'industry'){
                             $industry = $val2;
                             }

                          $picture = "";
                          if ($key2 == 'picture-url'){
                             $picture = $val2;
                             }

                          } # for each 2

                  $my_connections[$cnt]['linkedin_id'] = $linkedin_id;
                  $my_connections[$cnt]['first_name'] = $first_name;
                  $my_connections[$cnt]['last_name'] = $last_name;
                  $my_connections[$cnt]['email'] = $email;
                  $my_connections[$cnt]['headline'] = $headline;
                  $my_connections[$cnt]['industry'] = $industry;
                  $my_connections[$cnt]['picture'] = $picture;

                  $cnt++;

                          } # for each 1

                  #$my_connections["$linkedin_id"] = $first_name." ".$last_name;



                  }  # if person array

               } // end for each

       } else { # if

       $my_connections = "Not Available";

       } 

    return $my_connections;

   break;
   case 'message_contacts':

    $subject = $li_params[2];
    $message_image = $li_params[3]; # caption
    $this_message_link = $li_params[4];
    $message = $li_params[5];
    $li_ids = $li_params[6];

    if (is_array($li_ids)){

       foreach ($li_ids as $connkey => $targetUser) {

               $apiCallStatus = $linkedin->sendMessageById($targetUser, FALSE, $subject, $message);

               if (empty($apiCallStatus)){

                  $result .= "Message sent successfully!<BR>";

                  } else {

                  $apiXMLResponse = simplexml_load_string($apiCallStatus);
                  #echo "<pre>";
                  #print_r($apiXMLResponse);
                  #echo "</pre>";
                  $result .= $apiXMLResponse;

                  } # if status

               } # foreach

       } else {
       $result = "Contacts not selected - Message could not be sent!";
       } 

    return $result;

   break;
   case 'post':

    $xml_response = $linkedin->getProfile("~:(id,first-name,last-name,email-address,headline,picture-url)");

    $parameters = new stdClass;
    $parameters->comment = "Posting from the API using JSON";
    $parameters->content = new stdClass;
    $parameters->content->title = "A title for your share";
    $parameters->content->{'submitted-url'} = "http://www.linkedin.com";
    $parameters->content->{'submitted-image-url'} = "http://lnkd.in/Vjc5ec";
    $parameters->visibility = new stdClass;
    $parameters->visibility->code = 'anyone';
    $success = $client->CallAPI(
'http://api.linkedin.com/v1/people/~/shares',
'POST', $parameters, array('FailOnAccessError'=>true, 'RequestContentType'=>'application/json'), $user);

   break;

  } # end switch for LI

 } # end function

 # Do LinkedIn Function
 ################################
 # Start Body Content

 $external_service_title = "LinkedIn Login for ".$portal_title;
 $external_service_label = "LinkedInLogin";
    
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

 $oauth_token = $_GET['oauth_token'];
 if (!$oauth_token){
    $oauth_token = $_POST['oauth_token'];
    }

 $oauth_verifier = $_GET['oauth_verifier'];
 if (!$oauth_verifier){
    $oauth_verifier = $_POST['oauth_verifier'];
    }

 # End getting login info
 ################################
 # Package for presentation

 $callback_url = "https://".$hostname."/api-linkedin.php";

 if ($action == "login"){

    $external_service_return .= "We will try to create a fresh session for you...<P> ";

    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    $linkedin = new LinkedIn($li_app_id, $li_app_secret, $callback_url);

    # Now we retrieve a request token. It will be set as $linkedin->request_token
    $linkedin->getRequestToken();
    $_SESSION['requestToken'] = serialize($linkedin->request_token);
  
    # With a request token in hand, we can generate an authorization URL, which we'll direct the user to
    $external_service_return .= 'No session, please <a href="'.$linkedin->generateAuthorizeUrl().'">Login</a><P>';
    $sess_status = "NG";
    #header("Location: " . $linkedin->generateAuthorizeUrl());

    }

 if (isset($_REQUEST['oauth_verifier'])){

    $_SESSION['oauth_verifier'] = $_REQUEST['oauth_verifier'];

    $linkedin = new LinkedIn($li_app_id, $li_app_secret, $callback_url);

    $linkedin->request_token = unserialize($_SESSION['requestToken']);
    $linkedin->oauth_verifier = $_SESSION['oauth_verifier'];
    $linkedin->getAccessToken($_REQUEST['oauth_verifier']);

    $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);

    $sess_status = "OK";
    $external_service_return .= "Creating a fresh session was successful!<P> ";

    $li_params[0] = "login"; #action;
    $li_params[1] = ""; # userid
    $li_params[2] = ""; #$li_code;
    $li_params[3] = ""; #$li_state;

    $show_logindata = do_linkedin($li_params);

    $sess_status = $show_logindata[0]; 
    $external_service_return .= $show_logindata[1]; 

    } elseif ($action != 'login') {

    #$sess_status = "NG";
    #$external_service_return .= "Not set";

    }

 # End getting login info
 ################################
 # Package for presentation

 $body = $container_top;
 $body .= "<div style=\"".$divstyle_white."\">".$external_service_return."</div>";       
 $body .= $container_bottom;

 if ($sess_status == 'OK'){

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

    } elseif ($sess_status == 'NG') {# show_login
    echo $body;
    } 

 # End Presentation
 ################################

# End LinkedIn
##########################################################
?>