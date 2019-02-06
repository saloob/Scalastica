<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: RecipienttypesController.php 
##########################################################
# case 'RecipienttypesController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class RecipienttypesController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    public function get($request){

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$standard_statuses_closed,$fb_app_id,$fb_app_secret,$allow_fb_rego;

     $sess_fb = $request->parameters['sess_fb']; # Facebook
     $sess_gg = $request->parameters['sess_gg']; # Google
     $sess_li = $request->parameters['sess_li']; # LinkedIn
     $sess_tw = $request->parameters['sess_tw']; # Twitter
     $sess_acc = $request->parameters['sess_acc'];
     $sess_con = $request->parameters['sess_con'];
     $recipient_types = $request->parameters['recipient_types'];

     $do_logger = FALSE;

     if ($do_logger == TRUE){

        $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
        $log_name = "Scalastica";
        #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

        $log_content = "sess_fb:".$sess_fb.",sess_con:".$sess_con.",sess_li:".$sess_li.", sess_gg:".$sess_gg;

        $logparams[0] = $log_location;
        $logparams[1] = $log_name;
        $logparams[2] = $log_content;
        $funky_gear->funky_logger ($logparams);

        }

     $dd_pack = "";
     $cnt = 0;

     if (!$recipient_types){

        if ($sess_fb != NULL){

           # Un-comment this when facebook has allowed access to friends
           #$dd_pack[] = array ('id' => '2e465f2e-57db-e22d-0b7c-5559e0aaeeaf', 'type' => "Select Facebook Friend(s)", 'method'=>'restcall');
           $dd_pack[] = array ('id' => '8718bbf3-bf47-a358-21c7-555aa3a9cce8', 'type' => "Post to Facebook", 'method'=>'restcall');
           }

        if ($sess_gg != NULL){
           $dd_pack[] = array ('id' => '54cf2e2f-a525-85d0-ceff-5559e04f44f2', 'type' => "Select Google Contact(s)", 'method'=>'restcall');
           $dd_pack[] = array ('id' => 'ea3bfead-baf4-8133-8e3b-555aa3b66c6a', 'type' => "Post to Google+", 'method'=>'restcall');
           }
   
        if ($sess_li != NULL){
           $dd_pack[] = array ('id' => '18a8e733-f0e1-32a2-d5b3-5559e087dffb', 'type' => "Select LinkedIn Contact(s)", 'method'=>'restcall');
           $dd_pack[] = array ('id' => '18a8e733-f0e1-32a2-d5b3-5559e087dffb', 'type' => "Post to LinkedIn", 'method'=>'restcall');
           }

        if ($sess_con != NULL){
           $dd_pack[] = array ('id' => '821d3058-e575-b6fa-c3bb-5559de9489ce', 'type' => "Account Contact(s)", 'method'=>'restcall');
           $dd_pack[] = array ('id' => 'd8ba0615-94b3-78a5-51e4-5559de992b1c', 'type' => "Add Email Contact(s)", 'method'=>'textbox');
           $dd_pack[] = array ('id' => '7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e', 'type' => "My Private Connection(s)", 'method'=>'restcall');
           $dd_pack[] = array ('id' => '33485c3e-4814-12a5-5a38-5559e204e411', 'type' => "My Social Network Contact(s)", 'method'=>'restcall');

           }

        } else {

        switch ($recipient_types){

         case 'd8ba0615-94b3-78a5-51e4-5559de992b1c':
         break;

         } # end switch

        } #else


     if ($dd_pack){

        $za_package['api_response'] = 'OK';
        $za_package['api_message'] = "Recipient List Available!";
        $za_package['recipient_types'] = $dd_pack;

        } else {

        $za_package['api_response'] = 'NG';
        $za_package['api_message'] = "No Recipient List Available!";

        } # no recipient_types passed back

    $response = $za_package;

    return $response;

    } # end get function
    
} # End class