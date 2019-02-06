<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-13
# Page: Tranceiver
############################################## 
# 

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

date_default_timezone_set('Asia/Tokyo');

session_start();

if (!function_exists('get_param')){
   include ("common.php");
   }
###############################################
# Debugging - show variables

#foreach ($_POST as $key=>$value){

#        echo "TR Key: ".$key." - TR Value: ".$value."<BR>";

#        }

#
###############################################

if ($page != NULL){
   # decrypt the page
   #$date = date("Y@m@d");
   # echo "page: ".$pagepart."<P>";
   #$sentdate= $funky_gear->decrypt($datepart);
   #$page = $funky_gear->decrypt($pagepart);
   #	if ($date == $datepart){
   #	include ($pagepart);
   #   } // date same - within same hr
    include ($page.".php");
   } // end if page sent
?>