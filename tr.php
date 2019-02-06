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

#$datetime = date("Y-m-d G:i:s");
#$decdatetime = $funky_gear->decrypt($sent_portalcode);
#if ($page != NULL && (strtotime($datetime) < strtotime($decdatetime)+20)){
if ($page != NULL){
   include ($page.".php");
   } 
?>