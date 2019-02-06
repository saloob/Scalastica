<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-10-01
# Page: Body 
############################################## 
/*
 * Connect to CRM to view fields, allow editing
 * 
 */

if (!function_exists('get_param')){
   include ("common.php");
   }

echo $funkydo_gear->funkydone ($_POST,$lingo,$do,$action,$val,$valtype,$sent_params);

?>