<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: api.php 
##########################################################
# case 'FacebookController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class FacebookauthController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    public function get($request){

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$standard_statuses_closed,$fb_app_id,$fb_app_secret,$allow_fb_rego;


     #$data = json_decode(file_get_contents('php://input'), true);
     #$request->parameters = $_POST;
     $fb_access_token = $request->parameters['fb_access_token'];

        #$fb_sess = $_COOKIE['fb_sess'];
        #$fb_sess = $_SESSION['fb_token'];
        $fbsessfile = "/tmp/fbsess";
        $fh = fopen($fbsessfile,'r');
        while ($line = fgets($fh)) {
              list($fbsess,$sess_con,$sess_acc) = explode ("[]",$line);
              #$sess_acc = substr($sess_acc, 0, $length);
              $sess_acc = str_replace("\n", "", $sess_acc);
              #list($sess_acc,$nothing) = explode ("\n",$sess_acc_parts);
              if ($fbsess == $fb_access_token && $sess_con != NULL && $sess_acc != NULL){
                 break 1;
                 }
              }

        fclose($fh);

          $do_logger = TRUE;

          if ($do_logger == TRUE){

             $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
             $log_name = "Scalastica";
             #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

             $log_content .= "FacebookauthController [fb_access_token:".$fb_access_token.",sess_acc:".$sess_acc.",sess_con:".$sess_con.", FBSESS:".$fbsess."]";

             $logparams[0] = $log_location;
             $logparams[1] = $log_name;
             $logparams[2] = $log_content;
             $funky_gear->funky_logger ($logparams);

             }

        $fixfb_access_token = $fb_access_token."D";

        if ($fbsess == $fixfb_access_token){
           $fb_access_token = $fixfb_access_token;
           }

        if ($fb_access_token){
           # Token returned - check if wrapped session exists with same token
           if ($fbsess == $fb_access_token){
              #list ($fb_token,$sess_acc,$sess_con) = explode ("[]",$fb);
              $fb_package['api_response'] = 'OK';
              $fb_package['api_message'] = "Facebook Token Received and Sessions Exist!";
              $fb_package['fb_token'] = $fb_access_token;
              $fb_package['sess_con'] = $sess_con;
              $fb_package['sess_acc'] = $sess_acc;

              } else {

              $fb_package['api_response'] = 'NG';
              $fb_package['api_message'] = "Facebook Token Received but Token Session Doesn't Exist or Match!";
              $fb_package['fb_token'] = "";
              $fb_package['sess_con'] = "";
              $fb_package['sess_acc'] = "";

              }

           } else {

           $fb_package['api_response'] = 'NG';
           $fb_package['api_message'] = "No Facebook Token Passed Back!";
           $fb_package['fb_token'] = "";
           $fb_package['sess_con'] = "";
           $fb_package['sess_acc'] = "";

           } # no FB token passed back

        $response = $fb_package;

    return $response;

    } # end get function
    
} # End class