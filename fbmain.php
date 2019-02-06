<?php
			
    require 'api-facebook.php';

  if (!function_exists('get_param')){
     include ("common.php");
     }

    $fbconfig['appid'] = $fb_app_id; #$portal_config['facebook']['appid'];
    $fbconfig['api'] = 'a0100d90201960e75716aa9687fcda04'; #$portal_config['facebook']['api'];
    $fbconfig['secret'] = $fb_app_secret;#$portal_config['facebook']['secret'];

    // Create our Application instance.
    $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => true,
    ));


echo "fb_app_id $fb_app_id fb_app_secret $fb_app_secret<BR>";

    // We may or may not have this data based on a $_GET or $_COOKIE based session.
    // If we get a session here, it means we found a correctly signed session using
    // the Application Secret only Facebook and the Application know. We dont know
    // if it is still valid until we make an API call using the session. A session
    // can become invalid if it has already expired (should not be getting the
    // session back in this case) or if the user logged out of Facebook.
    $fbsession = $facebook->getSession();
 
    $fbme = null;
    // Session based graph API call.
    if ($fbsession) {
      try {
        $fbuid = $facebook->getUser();
        $fbme = $facebook->api('/me');
      } catch (FacebookApiException $e) {
          error_log($e);
      }
    }
  
	if ($fbme) {
	$logoutUrl = $facebook->getLogoutUrl();
	} else {
	$loginUrl = $facebook->getLoginUrl();
	}
		
?>