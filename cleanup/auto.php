#!/usr/bin/php
<?php
####################################################################
# Saloob scalastica #!/usr/bin/php
# To receive live content and map it to locations
# Saloob, Inc. All rights reserved 2007+
# Author: Matthew Edmond
# Date: 2009-08-20
# URL: http://www.saloob.com
# Email: sales@saloob.com
####################################################################
# 

//$auto_hostname = $_GET['hostname'];

$auto_account_id = $_GET['acc'];
#HP=81d48510-cd53-b831-baf6-51d779c1ff9d

//echo $auto_hostname;

include ("/var/www/vhosts/scalastica.com/httpdocs/common.php");


$host = $portal_email_server;
$user = $portal_email;
$pass = $portal_email_password;
$smtp_port = $portal_email_smtp_port;
$smtp_auth = $portal_email_smtp_auth;

$date = date("Y-m-d G:i:s");

#
#############################
# Set Opening of email
// Debugging - use smtp to keep the emails there

#$autester = TRUE;
$autester = FALSE;

if ($autester == TRUE){

   $emailparams[0] = $portal_email;
   $emailparams[1] = $portal_email_password;
   $emailparams[2] = "imap.gmail.com";
   $emailparams[3] = 993;
   $emailparams[4] = 0; //delete
   $emailparams[5] = 391;
   $emailparams[6] = "";
   $emailparams[7] = TRUE;
   $emailparams[8] = 'test_filter_single_debug';

   } else {

   $emailparams[0] = $portal_email;
   $emailparams[1] = $portal_email_password;
   $emailparams[2] = "imap.gmail.com";
   $emailparams[3] = 993;
   $emailparams[4] = 1; //delete
   $emailparams[5] = 1; // always get the first one..
   $emailparams[6] = "";
   $emailparams[7] = FALSE;
   $emailparams[8] = 'test_filter_all_live';
   
   } 

$lingo = "ja";
$bodyfiledate = date('Y-m-d-H-i-s');
$log_location = "/var/www/vhosts/scalastica.com/httpdocs";
$log_name = "Scalastica";
$log_link = "content/".$portal_account_id."/".$log_name.".log";

$do_logger = FALSE;
#$do_logger = TRUE;
                         ############################
                         # Do Logger
                         if ($do_logger == TRUE){
                            $log_content = "Entered Auto for Account ['".$auto_account_id."'] :".$emailparams[8]. "@".$bodyfiledate;
                            $logparams[0] = $log_location;
                            $logparams[1] = $log_name;
                            $logparams[2] = $log_content;
                            $funky_gear->funky_logger ($logparams);
                            }
                         # End Logger 
                         ############################

// Call the filter function 
$filterparams[0] = 'Auto';
$filterparams[1] = $emailparams;
$email_return = $funky_gear->do_filters ($filterparams);

# End Filters
###########################
# Auto ticketing - monthly recurring

# App End
#############################
?>