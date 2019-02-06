<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-06-08
# Page: LifePlanning.php 
##########################################################
# case 'LifePlanning':

  switch ($action){

   case 'view':

   $lp .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Life Planning</B></font></center></div>";
   echo $lp;

   break; # end view

  } # switch action

# break; # End LifePlanning
##########################################################
?>