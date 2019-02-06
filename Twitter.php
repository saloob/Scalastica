<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Twitter.php 
##########################################################
# case 'Twitter':

if ($action == NULL){
   $action = $_GET['action'];
   }

  switch ($action){
 
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

       $twitter = "<a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-url=\"".$link."\" data-count=\"horizontal\" data-via=\"".$name."\">Tweet</a><script type=\"text/javascript\" src=\"//platform.twitter.com/widgets.js\"></script>";

     break;
     case 'Contacts':

       $twitter = "<a href=\"https://twitter.com/".$name."\" class=\"twitter-follow-button\">Follow @".$name."</a>
<script src=\"//platform.twitter.com/widgets.js\" type=\"text/javascript\"></script>";

     break;

    } // vartpe switch

    echo $twitter;
?>
 </body>
</html>
<?
   break;

  } // end action switch

# break; // End Twitter
##########################################################
?>