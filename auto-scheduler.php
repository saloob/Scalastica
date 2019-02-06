#!/usr/bin/php
<?php
####################################################################
# Saloob scalastica #!/usr/bin/php
# To receive live content and map it to locations
# Saloob, Inc. All rights reserved 2007+
# Author: Matthew Edmond
# Date: 2016-04-08
# URL: http://www.saloob.com
# Email: sales@saloob.com
####################################################################
# Cron jobs - should be adjusted for global times
# 0 4 * * * wget -O - -q -t 1 http://www.scalastica.com/auto-scheduler.php &> /dev/null
# 0 2 * * * .... 2am
# 30 2 * * * .... 2:30am
# 0 22 * * * .... 10pm
# 0 22 * * * .... 10pm

include ("/var/www/vhosts/scalastica.com/httpdocs/common.php");

#
#############################
# Invoicing
# Set a cron job to kick off at 4am

$now_hour = date('H');
echo "Now hour: ".$now_hour;

#if ($now_hour > 3 && $now_hour < 5){
if ($now_hour > 22){

   $slareq_package = $funky_gear->do_scheduler();
   # Auto-check expired ServiceSALRequests
   #$funky_gear->check_slarequest_expiry ($slareq_package);

   # Auto-create orders based on enabled and scheduled SLA Requests
   $funky_gear->do_ordering ($slareq_package);

   # Auto-create tickets for enabled System-level SLA Requests
   #$funky_gear->do_ticketing ($package);

   # Only the invoicing cron job is set for 4am
   # If the particular invoice day is correct or not, depends on the account config

   #$package[0] = 0; # purpose = auto
   #$package[1] = ""; # account_id
   #$package[2] = ""; # sla_req_id
   #$funky_gear->do_invoices ($package);

   } # if within hours

# App End
#############################
?>