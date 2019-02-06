<?
####################################################################
# MyCMV Synch API
# To connect to and receive data for added-value services
# Saloob, Inc. All rights reserved 2010+
# Author: Matthew Edmond
# Date: 2010-09-20
# URL: http://www.saloob.com
# Email: sales@saloob.com
####################################################################
# External API Function

###################################
# Present

if (!$_SESSION){
    session_start();
}

$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$gender = $_GET['gender'];
$locale = $_GET['locale'];
$source_id = $_GET['source_id'];

?>
<html>
<head>
<title>MyCMV</title>
</head>
<body>
<span name="myspan" id="myspan">
<FORM ACTION="register_do.php" METHOD=POST>
 <table align="center">
  <tr>
   <td>First Name:
   </td>
   <td>
   <?php echo $first_name; ?>
   </td>
  </tr>
  <tr>
   <td>Last Name:
   </td>
   <td>
   <?php echo $last_name; ?>
   </td>
  </tr>
  <tr>
   <td>Email: *
   </td>
   <td>
   <INPUT type="text" id="email" name="email"  value="">
   </td>
  </tr>
  <tr>
   <td>
   * Required Field   
   <INPUT type="hidden" id="source_id" name="source_id" value="<?php echo $source_id; ?>">      
   <INPUT type="hidden" id="gender" name="gender" value="<?php echo $gender; ?>">
   <INPUT type="hidden" id="locale" name="locale" value="<?php echo $locale; ?>">
   <INPUT type="hidden" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
   <INPUT type="hidden" id="last_name" name="last_name" value="<?php echo $last_name; ?>">      
   </td>
   <td>
   <input type="submit" value="Submit">
   </td>  
  </tr> 
   </table>
   </form>
  </span>
 </body>
</html> 
<?

# End register
#####################################################
?>
