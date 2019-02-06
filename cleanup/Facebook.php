<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Index 
##########################################################
# case 'Facebook':

if (!function_exists('get_param')){
   include ("common.php");
   }

include ("global/global.php");

include_once "fbmain.php";

$action = $_GET['action'];
if (!$action){
   $action = $_POST['action'];
   }

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml itemscope itemtype="http://schema.org/Article"">
 <head>
  <title><?=$page_title?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="robots" content="ALL,index,follow">
 </head>
   <body>
<?

  switch ($action){

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
         appId  : '<?=$fbconfig['appid']?>',
         status : true, // check login status
         cookie : true, // enable cookies to allow the server to access the session
         xfbml  : true  // parse XFBML
       });
     </script>


<fb:serverFbml condensed="true" style="width:400px;">
    <script type="text/fbml">
      <fb:fbml>
          <fb:request-form
                    action="<?=$config['baseurl']?>"
                    target="_top"
                    method="POST"
                    invite="true"
                    type="<?=$portal_title?>"
                    content="<?=$_GET["msg"]?>"
                    label="Accept"
                    <fb:multi-friend-selector
                    showborder="false" exclude_ids="<?=$friends?>"
                    actiontext="<?=$_GET["msg"]?>">
        </fb:request-form>
      </fb:fbml>
    </script>
  </fb:serverFbml>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<script>
FB.init({
appId:'<?=$fbconfig['appid']?>',
cookie:true,
status:true,
xfbml:true
});

function FacebookInviteFriends()
{
FB.ui({
method: 'apprequests',
message: '<?=$_GET["msg"]?>'
});
}
</script>

<div id="fb-root"></div>
<a href='#' onclick="FacebookInviteFriends();">Click here to select which Facebook friends to invite to this Action</a>

<?

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

<?

# break; // End Governments Data
##########################################################

?>