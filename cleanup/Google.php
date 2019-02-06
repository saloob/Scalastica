<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Google.php 
##########################################################
# case 'Google':

$clientLibraryPath = '/usr/lib/php/ZendGdata/library';
$oldPath = set_include_path(get_include_path() . PATH_SEPARATOR . $clientLibraryPath);

if ($action == NULL){
   $action = $_GET['action'];
   }

  switch ($action){
 
   case 'Auth':

    echo "here we are!";
    echo "<iframe src=\"gplus/signin.php\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; width:450px; height:80px\"></iframe>";

/*

   require_once 'config.php';

   require_once 'gplus/vendor/autoload.php';
   require_once 'gplus/google-api-php-client/src/Google_Client.php';
   require_once 'gplus/google-api-php-client/src/contrib/Google_PlusService.php';

   use Symfony\Component\HttpFoundation\Request;
   use Symfony\Component\HttpFoundation\Response;

   $base_url = $portal_config['portalconfig']['baseurl'];
   $google_client_id = $portal_config['google']['client_id'];

   echo "<div style=\"".$quickstyle."\"><center>
<span id=\"signinButton\">
  <span
    class=\"g-signin\"
    data-callback=\"signinCallback\"
    data-clientid=\"".$google_client_id."\"
    data-cookiepolicy=\"".$base_url."\"
    data-requestvisibleactions=\"http://schemas.google.com/AddActivity\"
    data-scope=\"https://www.googleapis.com/auth/plus.login,https://www.googleapis.com/auth/userinfo.email\">
  </span>
</span></center></div>";


   const CLIENT_ID = $portal_config['google']['client_id']; //"421467974652.apps.googleusercontent.com";
   const CLIENT_SECRET = $portal_config['google']['client_secret']; // "fMIzyQVqhrYHy9WLifNCMDrt";
   const APPLICATION_NAME = $portal_config['portalconfig']['portal_title']; // "Google+ PHP Quickstart";

   $client = new Google_Client();
   $client->setApplicationName(APPLICATION_NAME);
   $client->setClientId(CLIENT_ID);
   $client->setClientSecret(CLIENT_SECRET);
   $client->setScopes(array('https://www.googleapis.com/auth/plus.me'));
   $plus = new Google_PlusService($client);

   $app = new Silex\Application();
   $app['debug'] = true;
   
   $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__,
   ));
   $app->register(new Silex\Provider\SessionServiceProvider());

   // Initialize a session for the current user, and render index.html.
   $app->get('/', function () use ($app) {
       $state = md5(rand());
       $app['session']->set('state', $state);

       return $app['twig']->render('index.html', array(
           'CLIENT_ID' => CLIENT_ID,
           'STATE' => $state,
           'APPLICATION_NAME' => APPLICATION_NAME
       ));

   });

   $app->post('/connect', function (Request $request) use($app, $client, $oauth2Service) {

      $token = $app['session']->get('token');

      if (empty($token)) {

         if ($request->get('state') != ($app['session']->get('state'))) {
            return new Response('Invalid state parameter', 401);
            }

         $code = $request->getContent();
         $gPlusId = $request->get['gplus_id'];

echo "Gplus ID: ".$gPlusId."<P>"; 

         $client->authenticate($code);

         $token = json_decode($client->getAccessToken());

         // Exchange the OAuth 2.0 authorization code for user credentials.
         $client->authenticate($code);

         $token = json_decode($client->getAccessToken());
         //verify the token
         $reqUrl = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' . $token->access_token;
         $req = new Google_HttpRequest($reqUrl);

         $tokenInfo = json_decode($client::getIo()->authenticatedRequest($req)->getResponseBody());

         // If there was an error in the token info, abort.
         if ($tokenInfo->error) {
            return new Response($tokenInfo->error, 401);
            }

         // Make sure the token we got is for the intended user.
         if ($tokenInfo->userid != $gPlusId) {
            return new Response('Token\'s user ID doesn\'t match given user ID', 401);
            }

         // Make sure the token we got is for our app.
         if ($tokenInfo->audience != CLIENT_ID) {
            return new Response('Token\'s client ID does not match app\'s.', 401);
            }

         // Store the token in the session for later use.
         $app['session']->set('token', json_encode($token));
         $response = 'Successfully connected with token: ' . print_r($token, true);

         } // if empty token

      return new Response($response, 200);

   }); // end app post

   // Get list of people user has shared with this app.
   $app->get('/people', function () use ($app, $client, $plus) {
       $token = $app['session']->get('token');
       if (empty($token)) {
           return new Response('Unauthorized request', 401);
          }

       $client->setAccessToken($token);
       $people = $plus->people->listPeople('me', 'visible', array());
       return $app->json($people);
   });


   // Revoke current user's token and reset their session.
   $app->post('/disconnect', function () use ($app, $client) {
     $token = json_decode($app['session']->get('token'))->access_token;
     $client->revokeToken($token);
     // Remove the credentials from the user's session.
     $app['session']->set('token', '');
     return new Response('Successfully disconnected', 200);
   });

   $app->run();

   if ($client->getAccessToken()) {
      $me = $plus->people->get('me');

      // These fields are currently filtered through the PHP sanitize filters.
      // See http://www.php.net/manual/en/filter.filters.sanitize.php
      $url = filter_var($me['url'], FILTER_VALIDATE_URL);
      $img = filter_var($me['image']['url'], FILTER_VALIDATE_URL);
      $name = filter_var($me['displayName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";

      }

*/

   break;
   case 'embedd':

    $link = $_GET['link'];
    $name = $_GET['name'];
    $vartype = $_GET['vartype'];
    $page_title = $_GET['page_title'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article">
 <head>
  <title><?=$page_title?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="robots" content="ALL,index,follow">
  <meta name="description" content="Real Politika provides tools and services that promote democratic, transparent Government">
  <meta name="keywords" content="Real Politika,realpolitika,Democratic,Transparent,Government,Technology, Lobbyists, Japan, Australia, America,China">
  <meta name="resource-type" content="document">
  <meta name="revisit-after" content="3 Days">
  <meta name="classificaton" content="Service Provider">
  <meta name="distribution" content="Global">
  <meta name="rating" content="Safe For Kids">
  <meta name="author" content="realPolitika">
  <meta http-equiv="reply-to" content="info@realpolitika.org">
  <meta http-equiv="imagetoolbar" content="no">
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
 </head>
 <body>

<?

    switch ($vartype){
 
     case 'Share':

      $google = "<g:plusone annotation=\"inline\" href=\"".$link."\"></g:plusone><span itemprop=\"name\">".$name."</span><span itemprop=\"description\">".$name."</span>";

     break;
     case 'Contacts':

       $google = "";

     break;

    } // vartpe switch

    echo $google;
?>
 </body>
</html>
<?
   break;

  } // end action switch

# break; // End Google
##########################################################
?>