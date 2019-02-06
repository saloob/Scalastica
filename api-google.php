<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-01-10
# Page: api-google.php 
##########################################################
# case 'Google':

session_start();

  if (!function_exists('get_param')){
     include ("common.php");
     }

$googleuserid = $_POST['gguid'];

if (!$googleuserid){
   $googleuserid = $_GET['gguid'];
   }

if ($googleuserid != NULL){
   $_SESSION['google'] = $googleuserid;
   $redirect = "Location: https://".$hostname;
   header($redirect);
   }

#    session_start();
#    session_unset();
#    session_destroy();

# include google api files
#require_once 'google/Config.php';
#require_once 'google/Utils.php';
#require_once 'google/Client.php';
#require_once 'google/Service.php';
#require_once 'google/Model.php';
#require_once "google/Collection.php";
require_once getcwd().'/google/Google/autoload.php';
 ################################
 # Do Google

 function fmt_gdate( $gdate ) {

  if ($val = $gdate->getDateTime()) {
  #  return (new DateTime($val))->format( 'd/m/Y H:i' );
     return (new DateTime($val))->format( 'Y-m-d H:i:s' );
  } else if ($val = $gdate->getDate()) {
  #  return (new DateTime($val))->format( 'd/m/Y' ) . ' (all day)';
    return (new DateTime($val))->format( 'Y-m-d' ) . ' (all day)';
  }

 } # date function


 function do_google($gg_params){

  global $gg_source_id,$gg_parci_id,$gg_app_id,$gg_app_secret,$portal_title,$hostname,$funky_gear,$portal_info,$portal_confid,$strings,$lingo;

  $gg_action = $gg_params[0];
  $gg_userid = $gg_params[1];

  require_once getcwd().'/google/Google/autoload.php';
  include_once getcwd().'/google/Google/Service/Oauth2.php';

  $service_leadsources_id_c = "52139b42-630e-d13f-9578-5518f0df3545";

  # Use this client for any function call

  $callback_url = "https://".$hostname."/api-google.php";

  $client = new Google_Client();
  $client->setApplicationName("Scalastica");
  $client->setDeveloperKey($gg_app_devkey);  
  $client->setClientId($gg_app_id);
  $client->setClientSecret($gg_app_secret);
  $client->setRedirectUri($callback_url);
  $client->setAccessType('offline');   // Gets us our refreshtoken
  $client->setApprovalPrompt('force');

  $client->setScopes(array(
'https://www.googleapis.com/auth/userinfo.email',
'https://www.googleapis.com/auth/userinfo.profile',
'https://www.googleapis.com/auth/calendar',
'https://www.googleapis.com/auth/plus.login',
'https://www.googleapis.com/auth/plus.me',
'https://www.googleapis.com/auth/contacts.readonly',
'https://www.google.com/m8/feeds'
));

  $client->setAccessToken($_SESSION['token']);
  $_SESSION['token'] = $client->getAccessToken();

  switch ($gg_action){

   case 'login':

    $external_service_return .= "We will now gather some of your information to initiate your account...<P> ";

    # Use client to get user data

    $oauth2 = new Google_Service_Oauth2($client);

    # For logged in user, get details from google using access token
    $user                 = $oauth2->userinfo->get();
    $gg_userid            = $user['id'];
    $user_name            = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email                = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    $last_name            = filter_var($user['familyName'], FILTER_SANITIZE_EMAIL);
    $first_name           = filter_var($user['givenName'], FILTER_SANITIZE_EMAIL);
    $gender               = filter_var($user['gender'], FILTER_SANITIZE_EMAIL);
    $profile_url          = filter_var($user['link'], FILTER_VALIDATE_URL);
    $profile_image_url    = filter_var($user['picture'], FILTER_VALIDATE_URL);
    #$personMarkup         = "$email<div><img src='$profile_image_url?sz=50'></div>";

    if ($gg_userid != NULL){

       $external_service_return .= "<center><img src=".$profile_image_url." width=400></center><P>ID: ".$gg_userid."<BR>Name: ".$first_name." ".$last_name."<BR>Email: ".$email."<P>";

       #########################
       # Build rego params

       $rego_params[0]['service_leadsources_id_c'] = $service_leadsources_id_c;
       $rego_params[0]['service_ci_source'] = $gg_source_id; # This will act as the wrapper CI for any userids under it as parent
       $rego_params[0]['service_parci_id'] = $gg_parci_id;
       $rego_params[0]['members_cit_id'] = "3a6d864c-d903-a569-11c4-55476e9197eb"; # Google Members to be used with parci

       # Collect any services sessions for sync
       require_once ('api-sessions.php');

       # End building rego params
       #########################
       # Pass the details onto the rego function

       #$_SESSION['google'] = $gg_userid;
       #$rego_params[1]['google'] = $gg_userid; # add the uid

       # The rego/login params will differ depending on the source
       #$rego_params[2]['gg_app_id'] = $gg_app_id;
       #$rego_params[2]['gg_app_secret'] = $gg_app_secret;
       #$rego_params[2]['gg_app_devkey'] = $gg_app_devkey;

       $rego_params[3]['account_name'] = $user_name;
       $rego_params[3]['userid'] = $gg_userid;
       $rego_params[3]['name'] = $user_name;
       $rego_params[3]['first_name'] = $first_name;
       $rego_params[3]['last_name'] = $last_name;
       $rego_params[3]['email'] = $email;
       $rego_params[3]['timezone'] = "";
       $rego_params[3]['locale'] = "";
       $rego_params[3]['password'] = "";

       $rego_params[4]['role_c'] = $role_AccountAdministrator; # all new ones
       $rego_params[4]['security_level'] = 2; # All new ones

       $rego_params[5] = "e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3"; # client

       $rego_params[6]['hostname'] = "";# used for business accounts
       $rego_params[6]['hostname_type'] = "";
   
       $external_service_return .= "<P>We are trying to synchronise with your Google account...<P>";    

       $external_service_return .= $funky_gear->do_rego($rego_params);
       $sess_status = "OK";

       } else {

       $external_service_return .= "No Session";
       $sess_status = "NG";

       }

    $returner[0] = $sess_status;
    $returner[1] = $external_service_return;
    $returner[2] = $gg_userid;

    return $returner;

   break;
   case 'get_contacts':

    #$gg_action = $gg_params[0];
    #$gg_userid = $gg_params[1];
    $gg_email = $gg_params[2];
    $gg_keyword = $gg_params[3];

    $access_token = json_decode($client->getAccessToken())->access_token;
    $max_results = 100;
    #$max_results = 1000;

    if ($gg_keyword != NULL){
       $ggcont_url = 'https://www.google.com/m8/feeds/contacts/default/full?q='.$gg_keyword.'&max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$access_token;
       } else {
       $ggcont_url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$access_token;
       }

    $xmlresponse =  file_get_contents($ggcont_url);
    $contacts = json_decode($xmlresponse,true);
    $counter = 0;

    #var_dump($contacts);

    foreach ($contacts['feed']['entry'] as $cnt) {

            #echo $cnt['title']['$t'] . " --- " . $cnt['gd$email']['0']['address'];
            $ggcontacts[$counter]['id'] = $cnt['id']['$t'];
            #echo "ID: ".$ggcontacts[$counter]['id']."<BR>";
            $ggcontacts[$counter]['title'] = $cnt['title']['$t'];
            $ggcontacts[$counter]['email'] = $cnt['gd$email']['0']['address'];

            if (isset($cnt['link'][0]['href'])){
               #$ggcontacts[$counter]['photo'] = $cnt['link'][0]['href'];
               #echo "photo: <img src=".$ggcontacts[$counter]['photo']." width=40><BR>";
               }

            if (isset($cnt['gd$name'][0]['gd$givenName'])){
               #$ggcontacts[$counter]['givenName'] = $cnt['gd$name'][0]['gd$givenName']['$t'];
               #echo "givenName: ".$ggcontacts[$counter]['givenName']."<BR>";
               }


            if (isset($cnt['gd$phoneNumber'])){
               $ggcontacts[$counter]['phoneNumber'] = $cnt['gd$phoneNumber'][0]['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$street'])){
               $ggcontacts[$counter]['street'] = $cnt['gd$structuredPostalAddress'][0]['gd$street']['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$neighborhood'])){
               $ggcontacts[$counter]['neighborhood'] = $cnt['gd$structuredPostalAddress'][0]['gd$neighborhood']['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$pobox'])){
               $ggcontacts[$counter]['pobox'] = $cnt['gd$structuredPostalAddress'][0]['gd$pobox']['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$postcode'])){
               $ggcontacts[$counter]['postcode'] = $cnt['gd$structuredPostalAddress'][0]['gd$postcode']['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$city'])){
               $ggcontacts[$counter]['city'] = $cnt['gd$structuredPostalAddress'][0]['gd$city']['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$region'])){
               $ggcontacts[$counter]['region'] = $cnt['gd$structuredPostalAddress'][0]['gd$region']['$t'];
               }

            if (isset($cnt['gd$structuredPostalAddress'][0]['gd$country'])){
               $ggcontacts[$counter]['country'] = $cnt['gd$structuredPostalAddress'][0]['gd$country']['$t'];
               }

           $counter++;

           }

    return $ggcontacts;

   break;
   case 'get_info':

    $oauth2 = new Google_Service_Oauth2($client);

    # For logged in user, get details from google using access token
    $user                 = $oauth2->userinfo->get();
    $gg_userid            = $user['id'];
    $user_name            = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $email                = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
    $last_name            = filter_var($user['familyName'], FILTER_SANITIZE_EMAIL);
    $first_name           = filter_var($user['givenName'], FILTER_SANITIZE_EMAIL);
    $gender               = filter_var($user['gender'], FILTER_SANITIZE_EMAIL);
    $link                 = filter_var($user['link'], FILTER_VALIDATE_URL);
    $picture              = filter_var($user['picture'], FILTER_VALIDATE_URL);
    #$personMarkup         = "$email<div><img src='$profile_image_url?sz=50'></div>";

    $rego_params[3]['userid'] = $gg_userid;
    $rego_params[3]['name'] = $user_name;
    $rego_params[3]['first_name'] = $first_name;
    $rego_params[3]['last_name'] = $last_name;
    $rego_params[3]['email'] = $email;
    $rego_params[3]['gender'] = $gender;
    $rego_params[3]['link'] = $link;
    $rego_params[3]['picture'] = $picture;
   
    return $rego_params;

   break;
   case 'get_cal_list':

    # Use client to get_cal_list 
    $service = new Google_Service_Calendar($client);    
	
    $calendarList = $service->calendarList->listCalendarList();

    $cnt = 0;
    while (true) {

          foreach ($calendarList->getItems() as $calendarListEntry) {

                  $cal[$cnt]['id'] = $calendarListEntry->id;
                  #echo "ID: ".$calendarListEntry->id."<BR>";
                  $cal[$cnt]['etag'] = $calendarListEntry->etag;
                  $cal[$cnt]['timeZone'] = $calendarListEntry->timeZone;
                  $cal[$cnt]['location'] = $calendarListEntry->location;
                  $cal[$cnt]['colorId'] = $calendarListEntry->colorId;
                  $cal[$cnt]['backgroundColor'] = $calendarListEntry->backgroundColor;
                  $cal[$cnt]['foregroundColor'] = $calendarListEntry->foregroundColor;
                  $cal[$cnt]['accessRole'] = $calendarListEntry->accessRole;
                  $cal[$cnt]['description'] = $calendarListEntry->description;
                  $cal[$cnt]['summary'] = $calendarListEntry->getSummary();

                  #$one_entry = $calendarListEntry;

                  $cnt++;

                  } # foreach

          $pageToken = $calendarList->getNextPageToken();

          if ($pageToken) {
             $optParams = array('pageToken' => $pageToken);
             $calendarList = $service->calendarList->listCalendarList($optParams);
             } else {
             break;
             }

          } # while true

    #var_dump($one_entry);

    return $cal;

   break; # end get_cal_list
   case 'view_calendar':

    #$gg_action = $gg_params[0];
    #$gg_userid = $gg_params[1];
    $gg_cal_id = $gg_params[2];
    $gg_start_date = $gg_params[3];
    $gg_end_date = $gg_params[4];
    $gg_keyword = $gg_params[5];

    $service = new Google_Service_Calendar($client);

    $params = array(
 'singleEvents' => TRUE,
 'timeMin' => $gg_start_date,
 'timeMax' => $gg_end_date,
 'orderBy' => 'startTime',
 'maxResults' => 100,
);

    if ($gg_keyword != NULL){
       $params['q'] = $gg_keyword;
       }

#echo "Start: $gg_start_date & End: $gg_end_date";


# 'timeMin' => (new DateTime())->format(DateTime::RFC3339),
# 'timeMax' => (new DateTime())->add(new DateInterval('P1W'))->format(DateTime::RFC3339),
#$event->getStart()->dateTime;

    #$events = $service->events->listEvents($gg_cal_id, $params);
    #$events = $service->events->listEvents('primary');
/*
$params = array(
 'singleEvents' => TRUE,
 'timeMin' => (new DateTime())->format(DateTime::RFC3339),
 'timeMax' => (new DateTime())->add(new DateInterval('P5W'))->format(DateTime::RFC3339),
);
*/
   $events = $service->events->listEvents($gg_cal_id, $params);

   while (true) {

         foreach ($events->getItems() as $event) {

                 $cal[$cnt]['id'] = $event->id;
                 #echo "ID: ".$event->id."<BR>";
                 $cal[$cnt]['etag'] = $event->etag;
                 $cal[$cnt]['start_date'] = fmt_gdate($event->getStart());
                 $cal[$cnt]['end_date'] = fmt_gdate($event->getEnd());
                 $cal[$cnt]['created'] = $event->created;
                 $cal[$cnt]['updated'] = $event->updated;
                 $cal[$cnt]['location'] = $event->getLocation();
                 $cal[$cnt]['status'] = $event->status;
                 $cal[$cnt]['description'] = $event->description;
                 $cal[$cnt]['summary'] = $event->getSummary();
                 $cal[$cnt]['creator'] = $event->getCreator();
                 $cal[$cnt]['creator_id'] = $event->getCreator->id;
                 $cal[$cnt]['creator_displayName'] = $event->getCreator->displayName;
                 $cal[$cnt]['attendees'] = $event->getAttendees();

                 $cnt++;

                 } # foreach

         $pageToken = $events->getNextPageToken();

         if ($pageToken) {
            #$optParams = array('pageToken' => $pageToken);
            $optParams = array(
 'pageToken' => $pageToken,
 'singleEvents' => TRUE,
 'timeMin' => $gg_start_date,
 'timeMax' => $gg_end_date,
 'orderBy' => 'startTime',
 'maxResults' => 100,
);
         if ($gg_keyword != NULL){
            $optParams['q'] = $gg_keyword;
            }

            $events = $service->events->listEvents($gg_cal_id, $optParams);
            #$events = $service->events->listEvents($optParams);
            } else {
            break;
            }

          } # while true

    return $cal;

   break; # end get_cal_list
   case 'view_event':

    $gg_cal_id = $gg_params[2];
    $gg_event_id = $gg_params[3];

    $service = new Google_Service_Calendar($client);

    $event = $service->events->get($gg_cal_id, $gg_event_id);

    $cal['id'] = $event->id;
    #echo "ID: ".$event->id."<BR>";
    $cal['etag'] = $event->etag;
    $cal['start_date'] = fmt_gdate($event->getStart());
    $cal['end_date'] = fmt_gdate($event->getEnd());
    $cal['created'] = $event->created;
    $cal['updated'] = $event->updated;
    $cal['location'] = $event->getLocation();
    $cal['status'] = $event->status;
    $cal['description'] = $event->description;
    $cal['summary'] = $event->getSummary();
    $cal['creator'] = $event->getCreator();
    $cal['creator_id'] = $event->getCreator->id;
    $cal['creator_displayName'] = $event->getCreator->displayName;
    $cal['attendees'] = $event->getAttendees();

    return $cal;

   break; # end get_cal_list
   case 'post_moment':

    $name = $gg_params[2];
    $description = $gg_params[3];
    $image = $gg_params[4];
    $url = $gg_params[5];

    $moment_body = new Google_Moment();
    $moment_body->setType("http://schema.org/AddAction");
    $item_scope = new Google_ItemScope();
    if ($url){
       $item_scope->setUrl($url);
       }
    $item_scope->setName($name);
    $item_scope->setDescription($description);
    if ($image){
       $item_scope->setImage($image);
       }
    $moment_body->setObject($item_scope);
    $momentResult = $plus->moments->insert('me', 'vault', $moment_body);

    return $momentResult;

   break; # end post_moment
   case 'post_event':

    $summary = $gg_params[2];
    $location = $gg_params[3];
    $startdate = $gg_params[4];
    $enddate = $gg_params[5];
    $attendee1 = $gg_params[6];
    $calendar_id = $gg_params[7];
    $description = $gg_params[8];
    $gg_event_id = $gg_params[9]; # Exists

    #googleCalendarEvent.Description = "I'm becoming one year older";
    # Set Remainder
/*
googleCalendarEvent.Reminders = new Event.RemindersData();
googleCalendarEvent.Reminders.UseDefault = false;
EventReminder reminder = new EventReminder();
reminder.Method = "popup";
reminder.Minutes = 60;
googleCalendarEvent.Reminders.Overrides = new List();
googleCalendarEvent.Reminders.Overrides.Add(reminder);
*/

    # Attendees
/*
googleCalendarEvent.Attendees.Add(new EventAttendee()
	{
		DisplayName = "Sebastian",
		Email = "my@email.com",
		ResponseStatus = "accepted"
	});
googleCalendarEvent.Attendees.Add(new EventAttendee()
	{
		DisplayName = "Fiona",
		Email = "fiona@email.com",
		ResponseStatus = "needsAction"
	});	

*/

    if ($calendar_id == NULL){
       $calendar_id = 'primary';
       } # calendar

    #$event = new Google_Service_Calendar_Event($client);
    #$event = new Google_CalendarService($client);
    #$event = new Google_Service_Calendar($client);

    $service = new Google_Service_Calendar($client);
    $event = new Google_Service_Calendar_Event();

    $event->setSummary($summary);
    $event->setLocation($location);

    $start = new Google_Service_Calendar_EventDateTime();
    $start->setDateTime($startdate);
    $event->setStart($start);

    $end = new Google_Service_Calendar_EventDateTime();
    $end->setDateTime($enddate);
    $event->setEnd($end);

    if ($description != NULL){
       $event->setDescription($description);
       }

    if ($attendee1 != NULL){

       $attendee1 = new Google_Service_Calendar_EventAttendee();
       $attendee1->setEmail($attendee1);
       $attendees = array($attendee1,
                  # ...
                  );
       $event->attendees = $attendees;

       } # if attendees

    if ($gg_event_id != NULL){
       #$event = $service->events->get('primary', 'eventId');
       $updatedEvent = $service->events->update($calendar_id, $gg_event_id,$event);
       $update_info = $updatedEvent->getUpdated();
       #$gg_event_id = $createdEvent->getId();
       } else {
       $createdEvent = $service->events->insert($calendar_id, $event);
       $gg_event_id = $createdEvent->getId();
       }

    return $gg_event_id;
    
   break; # end post_event

  } # end switch for GG

 } # end function

 # Do Google Function
 ################################
 # Start Body Content

 $external_service_title = "Google Login for ".$portal_title;
 $external_service_label = "GoogleLogin";
    
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

 #unset($_SESSION['token']); # Google
 #unset($_SESSION['google']); # Google

 if ($gg_app_devkey != NULL && $gg_app_id != NULL && $gg_app_secret != NULL){
 
    $callback_url = "https://".$hostname."/api-google.php";

    $client = new Google_Client();
    $client->setApplicationName("Scalastica");
    $client->setDeveloperKey($gg_app_devkey);  
    $client->setClientId($gg_app_id);
    $client->setClientSecret($gg_app_secret);
    $client->setRedirectUri($callback_url);
    $client->setAccessType('offline');   // Gets us our refreshtoken
    $client->setApprovalPrompt('force');

    $client->setScopes(array(
'https://www.googleapis.com/auth/userinfo.email',
'https://www.googleapis.com/auth/userinfo.profile',
'https://www.googleapis.com/auth/calendar',
'https://www.googleapis.com/auth/plus.login',
'https://www.googleapis.com/auth/plus.me',
'https://www.googleapis.com/auth/contacts.readonly',
'https://www.google.com/m8/feeds'
));

   }

 if ($action == "login" && (!isset($_SESSION['token']))){

    $external_service_return .= "We will try to create a fresh session for you...<P> ";

    # Google Auth Start
    $authUrl = $client->createAuthUrl();
    $external_service_return .= 'No session, please <a href="'.$authUrl.'">Login</a><P>';
    $sess_status = "NG";

    } # if login

 if (isset($_GET['code'])) {

    # Step 2: The user accepted your access now you need to exchange it.	
    $client->authenticate($_GET['code']);  
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));

    } # get code and create session

    #var_dump($_SESSION['token']);

 if (isset($_SESSION['token']) && $gg_session == NULL){

    # Step 3: We have access we can now create our service
    $client->setAccessToken($_SESSION['token']);

    $_SESSION['token'] = $client->getAccessToken();

    $external_service_return .= "Creating a fresh session was successful!<P> ";

    $gg_params[0] = "login"; #action;
    $gg_params[1] = ""; # userid
    $gg_params[2] = ""; #$gg_code;
    $gg_params[3] = ""; #$gg_state;

    $show_logindata = do_google($gg_params);

    $sess_status = $show_logindata[0]; 
    $external_service_return .= $show_logindata[1]; 
    #$googleuserid = $show_logindata[2];

    } elseif (isset($_SESSION['token']) && $gg_session != NULL) {

    # Can't do anything because the functions are being called
    #echo "oi";
    #$callback_url = "https://".$hostname."/api-google.php";    

    }
   # $sess_status = "NG";
    #$external_service_return .= "Session Not set<P>";

   # } elseif (isset($_SESSION['token']) && $gg_session != NULL) {

    #$sess_status = "OK";
    #$external_service_return .= "Session already exists<P>";
    #$external_service_return .= "<a href=\"https://".$hostname."\" target=\"".$portal_title."\">Click here</a> to continue...<P>";

    #}


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


# End Google
##########################################################
?>