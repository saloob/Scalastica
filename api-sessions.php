<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-03-28
# Page: api-sessions.php
##########################################################
# api-sessions':

if (!function_exists('get_param')){
   include ("common.php");
   }

# Collecting various sessions to be able to synchronise them when registering or logging-in.
# If any particular session is active, and another is being tried, then should use the SAME account..
# Relate by email is probably the only way..

# These should be the userids

$sess_contact_id = $_SESSION['contact_id'];
$sess_account_id = $_SESSION['account_id'];

$rego_params[1]['portal_contact'] = $sess_contact_id; 
$rego_params[1]['portal_account'] = $sess_account_id; 

$sc_session = $_SESSION['scalastica'];
$fb_session = $_SESSION['facebook'];
$li_session = $_SESSION['linkedin'];
$gg_session = $_SESSION['google'];

$rego_params[1]['scalastica'] = $sc_session;
$rego_params[1]['facebook'] = $fb_session;
$rego_params[1]['linkedin'] = $li_session;
$rego_params[1]['google'] = $gg_session;

# The various APIs will include this and pass it to the rego function

# sessions
##########################################################

?>