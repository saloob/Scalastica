<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Linkedin.php 
##########################################################
# case 'Linkedin':

if ($action == NULL){
   $action = $_GET['action'];
   }

if ($action == NULL){
   $action = $_POST['action'];
   }

  switch ($action){
 
   ################################
   # Embedd

   case 'embedd':

    $link = $_GET['link'];
    $name = $_GET['name'];
    $vartype = $_GET['vartype'];
    $page_title = $_GET['page_title'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
 </head>
 <body>

<?

    switch ($vartype){
 
     case 'Share':

       $linkedin = "<script src=\"http://platform.linkedin.com/in.js\" type=\"text/javascript\"></script><script type=\"IN/Share\" data-url=\"".$link."\" data-counter=\"right\">";

     break;
     case 'Contacts':

       $linkedin = "<script src=\"http://platform.linkedin.com/in.js\" type=\"text/javascript\"></script><script type=\"IN/MemberProfile\" data-id=\"http://www.linkedin.com/pub/".$linkedin_name_c."\" data-format=\"hover\" data-text=\"".$name."\">";

       $linkedin .= "<BR><script type=\"IN/MemberProfile\" data-id=\"http://www.linkedin.com/in/".$linkedin_name_c."\" data-format=\"inline\"></script>";

     break;

    } // vartpe switch

    echo $linkedin;
?>
 </body>
</html>
<?
   # End embedd
   ################################

   break;
   case 'Login':

   ################################
   # Login

   ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
 </head>
 <body>
  <form id="linkedin_connect_form" action="linkedin/auth.php" method="get">
   <input type="submit" value="Connect to LinkedIn" />
  </form>
  <?php
/*
echo "Source: ".$_SESSION["source_id"]."<BR>";
echo "Contact: ".$_SESSION["contact_id"]."<BR>";
echo "Lead Source: ".$_SESSION["cmv_leadsources_id_c"]."<BR>";
*/

/*
  $embedd = "Linkedin@initiate@initiate@lType";
  $embedd = $this->encrypt($embedd);
  $glb_home_url = $portal_config['portalconfig']['glb_home_url'];
  $link = $glb_home_url."/?rp=".$embedd;
  echo $link;
*/
   ?>
 </body>
</html>
   <?

   # End Login
   ################################

   break;
   case 'prepare_message':

   ################################
   # Start Prepare Message

    $sess_source_id = $_SESSION["source_id"];
    $sess_contact_id = $_SESSION["contact_id"];
    $sess_service_leadsources_id_c = $_SESSION["cmv_leadsources_id_c"];

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_title = "Prepare LinkedIn Message";

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$container_title,'PrepareMessage');
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    if ($sess_source_id != NULL && $sess_service_leadsources_id_c == 'dc35866e-079c-4232-8027-4d972ddd96a3'){ 

       require_once ('config.php');

       $config['baseurl'] = $portal_config['portalconfig']['baseurl'];
       $config['base_url']             =   $portal_config['portalconfig']['baseurl'].'linkedin/auth.php';
       $config['callback_url']         =   $portal_config['portalconfig']['baseurl'].'linkedin/auth2.php';
       $config['linkedin_access']      =   $portal_config['linkedin']['apikey']; 
       $config['linkedin_secret']      =   $portal_config['linkedin']['secret'];

       include ("linkedin/linkedin.php");

       $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );

       $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
       $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
       $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);

       $connectionsParams = array();
       $connectionsParams[0] = 'by-id';
       $connectionsParams[1] = $sess_source_id;
       $connections_response = $linkedin->get_connections($connectionsParams);

       if ($connections_response != NULL){

          $connections_array = new SimpleXMLElement($connections_response);

          $cnt = 0;

/*
Key1: person & Value1: 
Key2: id & Value2: NGPMLSbR70
Key2: first-name & Value2: Stanislav
Key2: last-name & Value2: A. Shunin
Key2: headline & Value2: Department Manager at Parallels
Key2: api-standard-profile-request & Value2: 
Key2: site-standard-profile-request & Value2: 
Key2: location & Value2: 
Key2: industry & Value2: Computer Software
*/
          foreach ($connections_array as $connkey => $connval) {

                //echo "Key1: ".$connkey." & Value1: ".$connval."<BR>";

                foreach ($connval as $key2 => $val2) {

                        //echo "Key2: ".$key2." & Value2: ".$val2."<BR>";

                        if ($key2 == 'id'){
                           $linkedin_id = $val2;
                           }
                        if ($key2 == 'first-name'){
                           $first_name = $val2;
                           }
                        if ($key2 == 'last-name'){
                           $last_name = $val2;
                           }
                        if ($key2 == 'headline'){
                           $headline = $val2;
                           }
                        if ($key2 == 'industry'){
                           $industry = $val2;
                           }

                        }  // for each 2
/*
                $my_connections[$cnt]['linkedin_id'] = $linkedin_id;
                $my_connections[$cnt]['first_name'] = $first_name;
                $my_connections[$cnt]['last_name'] = $last_name;
                $my_connections[$cnt]['headline'] = $headline;
                $my_connections[$cnt]['industry'] = $industry;
*/
                $my_connections["$linkedin_id"] = $first_name." ".$last_name;

                $cnt++;

                } // end for each

          $tblcnt = 0;

          $tablefields[$tblcnt][0] = 'linkedin_connection_id'; // Field Name
          $tablefields[$tblcnt][1] = "Connection"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = $my_connections; // If DB, dropdown_table, if List, then array, other related table    
          $tablefields[$tblcnt][9][2] = 'linkedin_connection_id';
          $tablefields[$tblcnt][9][3] = 'LinkedIn';
          $tablefields[$tblcnt][9][4] = ''; // Exceptions
          $tablefields[$tblcnt][9][5] = ''; // Current Value
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = ''; // Field ID
          $tablefields[$tblcnt][20] = 'linkedin_connection_id';//$field_value_id;
          $tablefields[$tblcnt][21] = ""; //$field_value;

          $tblcnt++;

          $subject = "Collaborate on ".$object_return_name." using Shared Effects.";

          $tablefields[$tblcnt][0] = 'subject'; // Field Name
          $tablefields[$tblcnt][1] = "Subject"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 1; // is_name
          $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '100'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = 'subject'; // Field ID
          $tablefields[$tblcnt][20] = '';//$field_value_id;
          $tablefields[$tblcnt][21] = $subject; //$field_value; 

          $tblcnt++;

          if (!$val){
             $val = 'NULL';
             }

          $embedd = $valtype."@view@".$val."@".$valtype;
          $embedd = $funky_gear->encrypt($embedd);
          $glb_home_url = $portal_config['portalconfig']['glb_home_url'];
          $embedd = $glb_home_url."/?rp=".$embedd;

          $message = "I would like to invite you to ".$object_return_name." and collaborate using Shared Effects.
Click on the following link to access:
$embedd
";

          $tablefields[$tblcnt][0] = 'message'; // Field Name
          $tablefields[$tblcnt][1] = "Message"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '1';//1; // show in view 
          $tablefields[$tblcnt][11] = 'message'; // Field ID
          $tablefields[$tblcnt][20] = '';//$field_value_id;
          $tablefields[$tblcnt][21] = $message; //$field_value; 

          $tblcnt++;
     
          $tablefields[$tblcnt][0] = 'valuetype'; // Field Name
          $tablefields[$tblcnt][1] = "Related Object"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '';//1; // show in view 
          $tablefields[$tblcnt][11] = $valtype; // Field ID
          $tablefields[$tblcnt][20] = 'valuetype';//$field_value_id;
          $tablefields[$tblcnt][21] = $valtype; //$field_value;

          $tblcnt++;
     
          $tablefields[$tblcnt][0] = 'value'; // Field Name
          $tablefields[$tblcnt][1] = "Related Value"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 0; // is_name
          $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '255'; // length
          $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '';//1; // show in view 
          $tablefields[$tblcnt][11] = $val; // Field ID
          $tablefields[$tblcnt][20] = 'value';//$field_value_id;
          $tablefields[$tblcnt][21] = $val; //$field_value;

          $valpack = "";
          $valpack[0] = 'LinkedIn';
          $valpack[1] = 'send_message'; //
          $valpack[2] = $valtype;
          $valpack[3] = $tablefields;
          $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)
          $valpack[5] = ""; // 
          $valpack[6] = "send_message"; // Next Action
          $valpack[7] = "Send Message"; // Button Text

          $linkedin_form = "";
          $linkedin_form = $funky_gear->form_presentation($valpack);
  
          echo $object_return;

          echo "<BR><img src=\"images/blank.gif\" width=300 height=10><BR>";

          $linkedin_form = "<center><B><font size=3>You are connected to your LinkedIn Account - select a Contact to send a message to</font></B></center><P>".$linkedin_form."<P>";

          echo $linkedin_form;

          } // end if no connection response

     } // end if sess source

    echo $container_bottom;

   # End Prepare Message
   ################################

   break;
   case 'send_message':

   ################################
   # Start Send Message

    $targetUser = $_POST['linkedin_connection_id'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];

    echo $object_return;

    echo "<BR><img src=\"images/blank.gif\" width=300 height=10><BR>";

    if ($targetUser != NULL && $message != NULL && $subject != NULL){

       require_once ('config.php');

       $config['baseurl'] = $portal_config['portalconfig']['baseurl'];
       $config['base_url']             =   $portal_config['portalconfig']['baseurl'].'linkedin/auth.php';
       $config['callback_url']         =   $portal_config['portalconfig']['baseurl'].'linkedin/auth2.php';
       $config['linkedin_access']      =   $portal_config['linkedin']['apikey']; 
       $config['linkedin_secret']      =   $portal_config['linkedin']['secret'];

       include ("linkedin/linkedin.php");

       $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['callback_url'] );

       $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
       $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
       $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);

       $apiCallStatus = $linkedin->sendMessageById($targetUser, FALSE, $subject, $message);
 
       if (empty($apiCallStatus)){
          echo "Message sent successfully!";
          } else {
          $apiXMLResponse = simplexml_load_string($apiCallStatus);
          echo "<pre>";
          print_r($apiXMLResponse);
          echo "</pre>";
          }

       } // end if connection sent

   # End Send Message
   ################################

   break;
   case 'AddPost':

   ################################
   # Start AddPost Message


   # End AddPost Message
   ################################

   break;

  } // end action switch

# break; // End Linkedin
##########################################################
?>