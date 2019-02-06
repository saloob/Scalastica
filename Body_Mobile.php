<?php 
##############################################
# Scalastica Mobile
# Author: Matthew Edmond, Saloob
# Date: 2015-05-23
# Page: Body_Mobile.php 
##########################################################
# case 'Body_Mobile':

if (!function_exists('dlookup')){
   include ("common-new.php");
   }

echo "oi";

 switch ($do){

  case '':

   echo "Nothing";

  break;
  case 'Events':

   include ("Events_Mobile.php");

  break;

 } # end switch

# break; // End Body_Mobile
##########################################################
?>