<?php
/*
require_once 'appinclude.php';

    $my_url = $app_callbackurl;

    $code = $_REQUEST["code"];

    if(empty($code)) {
        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
            . $app_id . "&redirect_uri=" . urlencode($my_url);

        echo("<script> top.location.href='" . $dialog_url . "'</script>");
    }

    $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret="
        . $app_secret . "&code=" . $code;

    $access_token = file_get_contents($token_url);

    $graph_url = "https://graph.facebook.com/me?" . $access_token;

    $user = json_decode(file_get_contents($graph_url));

    echo("Hello " . $user->name);
*/
/*

$userid = $facebook->require_login();

$user_details = $facebook->api_client->users_getInfo($userid, array('name','last_name','first_name','locale','current_location','affiliations','profile_url','sex'));

$fb_name = $user_details[0]['name'];
$fb_fname = $user_details[0]['first_name'];
$fb_lname = $user_details[0]['last_name'];
$fb_locale = $user_details[0]['locale'];
//$fb_current_location = $user_details[0]['current_location'];
//$fb_affiliations = $user_details[0]['affiliations'];
$fb_profile_url = $user_details[0]['profile_url'];
$fb_gender = $user_details[0]['sex'];

// Need to check if registered in CRM - must use Source and source ID (new fields)
// source_c = Facebook - MyCMV
// cmv_leadsources_id_c = 85b88fa2-1f14-4042-5f2d-4c96a93c941e
// Use lead source to add to the Facebook Leads when creating a new contact

if (!function_exists('set_lingo')){
   include ("../global/lingo.inc.php");
   include (set_lingo());
   }

global $strings;

$crm_wsdl_url = 'http://www.saloob.jp/crm/soap.php?wsdl';
$crm_api_user = 'matt@saloob.com';
$crm_api_pass = 'zacross1972';

if (!function_exists('api_sugar')){
   include ("../api-sugarcrm.php");
}

$cmv_leadsources_id_c = "85b88fa2-1f14-4042-5f2d-4c96a93c941e";

$object_type = "contacts";
$action = "contact_by_source";
$params = array();
$params[0] = $cmv_leadsources_id_c; // query
$params[1] = $userid; // query
//$params[1] = "638717843"; // query

$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

foreach ($result['entry_list'] as $gotten){

		$fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);   	
		$contact =  $fieldarray['contact_id_c'];

		}
		
?>

<?php 		

if ($contact != NULL){


	// Do all of them - otherwise not existing
	$url = "http://www.saloob.com/yourcmv/fwd.php?cmv_leadsources_id_c=".$cmv_leadsources_id_c."&contact_id=".$contact."&source_id=".$userid;

//	echo "<fb:share-button class=\"url\" href=\"http://apps.new.facebook.com/yourcmv/\"/><font color=blue size=2><center><B>Welcome back ".$fb_fname.".</B></font></center>";
	echo "<iframe src='".$url."' width=100% height=800 scroll=0></iframe>";
	
	} else { // Doesn't exist/

// echo $strings["content_home"];

?>
<table width=100%>
 <tr valign=top>
  <td><img src="http://www.saloob.com/yourcmv/images/Welcome.png"></td>
  <td>
   <div><font size=3><center><B><? echo $fb_fname; ?> - Welcome to YourCMV!</B></font></center></div>
<P>
   <div><B>YourCMV</B> is a free service that allows you to manage your information and automatically calculates the Current Market Value (CMV) of that information.<BR></BR>
   Why would you want to know your information's CMV?<BR></BR>
	1: It is interesting to know how much your information is worth in today's digitaly-connected world.<BR></BR>
	2: It is possible to make money from your information while keeping OWNERSHIP - rest assured - you choose exactly how to o rnot share your own information.<BR></BR>
	3: We are getting spammed all the time and you are not getting exactly the information you want about products and services. This can not happen at YourCMV - YourCMV enables you to get information about the things that you are interested in - only if you want to.
<BR><B>Enjoy using YourCMV!</B>
   </div>
  </td>
 </tr>
</table>
<?
	// Prepare simple AJAX form - prepopulated with FB data as much as possible
	
	echo "<P><center><font color=blue size=3><B>Next is just to confirm your email to get started with YourCMV</B></font></center><BR>";
	$url = "http://www.saloob.com/yourcmv/fb/register.php?first_name=".$fb_fname."&last_name=".$fb_lname."&gender=".$fb_gender."&locale=".$fb_locale."&source_id=".$userid;
	echo "<iframe src='".$url."' width=98% height=140 scroll=0></iframe>";
	
}
		
$rs = $facebook->api_client->fql_query("SELECT uid FROM user WHERE has_added_app=1 and uid IN (SELECT uid2 FROM friend WHERE uid1 = $userid)");

$arFriends = "";
$myappfriends = "";

if ($rs) {
   $arFriends .= $rs[0]["uid"];

   for ( $i = 1; $i < count($rs); $i++ ) {

       if ( $arFriends != "" ){
          $arFriends .= ",";
          $arFriends .= $rs[$i]["uid"];

          } // if ar
       } // end for
   } // if rs

// Construct a next url for referrals
$sNextUrl = urlencode("&refuid=".$userid);

$invfbml = <<<FBML
You've been invited to join YourCMV for Facebook!
<fb:name uid="$userid" firstnameonly="true" shownetwork="false"/> wants you join in using YourCMV so that you can also know your true Current Market Value <fb:pronoun possessive="true" uid="$userid"/>. <fb:req-choice url="http://www.facebook.com/add.php?api_key=$appapikey&next=$sNextUrl" label="Join YourCMV!" /> 
FBML;

?>

    <fb:request-form type="YourCMV" action="index.php?c=skipped" content="<?=htmlentities($invfbml)?>" invite="true">
    <fb:multi-friend-selector max="100" actiontext="Below are your friends who don't know their Current Market Value.
Invite them so they can also know their true CMV!" showborder="true" rows="5" exclude_ids="<?=$arFriends?>">
    </fb:request-form>

*/
?>
<html>
    <head>
        <title>Straight Government on Facebook</title>
    </head>
    <body>
        <script>

        var appId = "146780268715192";

        if(window.location.hash.length == 0)
        {
            url = "https://www.facebook.com/dialog/oauth?client_id=" + 
                     appId  + "&redirect_uri=" + window.location +
                     "&scope=email,read_stream&response_type=token";
            window.open(url);

        } else {
            accessToken = window.location.hash.substring(1);
            graphUrl = "https://graph.facebook.com/me?" + accessToken +
                        "&callback=displayUser"

            //use JSON-P to call the graph
            var script = document.createElement("script");
            script.src = graphUrl;
            document.body.appendChild(script);  
        }

        function displayUser(user) {
            userName.innerText = user.name;
        }
        </script>
        <p id="userName"></p>

      <div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js"></script>
      <script>
         FB.init({ 
            appId:'146780268715192', cookie:true, 
            status:true, xfbml:true 
         });
      </script>
      <fb:login-button perms="email,user_checkins">
         Login with Facebook
      </fb:login-button>
    </body>
</html>

<?

?>