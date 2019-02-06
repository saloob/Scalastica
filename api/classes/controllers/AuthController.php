<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: api.php 
##########################################################
# case 'NewsController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class AuthController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    public function get($request){

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

      #var_dump($request);
      #var_dump($portal_account_id);

      $module = $request->url_elements[0];
      $http_method = $request->method;
      $http_params = $request->parameters;

      #var_dump($http_params);

      $action = $request->parameters['action'];

/*      foreach ($http_params as $param=>$value){

              if ($param == 'action'){
                  $action = $value;
                  }

              } # foreach for action

*/


      #var_dump($action);

      switch ($action){

       case 'auth':

        # collect details

        foreach ($http_params as $val_param=>$val_value){
    
                if ($val_param == 'auth'){

                   $val_value = str_replace('{','',$val_value);
                   $val_value = str_replace('}','',$val_value);
           
                   list ($sent_email,$sent_password) = explode(':',$val_value);
 
                   } elseif ($val_param == 'api_key'){

                   $api_key = $val_value;

                   } elseif ($val_param == 'api_sess'){

                   $api_sess = $val_value;

                   } # end if 

                 } # inner foreach

     ############################
     # Do Logger

     $do_logger = TRUE;

     if ($do_logger == TRUE){

        $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
        $log_name = "Scalastica";
        #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

        $log_content = "action:".$action.",email:".$sent_email.",password:".$sent_password.",api_key:".$api_key;

        $logparams[0] = $log_location;
        $logparams[1] = $log_name;
        $logparams[2] = $log_content;
        $funky_gear->funky_logger ($logparams);

        }

     # End Logger 
     ############################

        $auth_params[0] = $sent_email;
        $auth_params[1] = $sent_password;
        $auth_params[2] = $api_key;
        $auth_params[3] = $api_sess;

        #var_dump($sent_password);

        $check_response = $this->authenticate($auth_params);
        $success = $check_response[0];
        $check_pack = $check_response[1]; 
        #$response['success'] = $success;
        #$response['api'] = 'Scalastica';
        #$response['auth'] = $check_pack;
        $response = $check_pack;

       break; # auth case action

       } # switch action

      return $response;


    } # end get function
    
    /**
     * POST action.
     *
     * @param  $request
     * @return null
     */
    public function post($request){

     global $sc_source_id,$sc_parci_id,$parent_account_id,$funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$portal_email_server,$portal_email_smtp_port,$portal_email_smtp_auth;

     /*
     parse_str(file_get_contents('php://input'), $request->parameters);
     #$rawdata = file_get_contents('php://input');
     #$urldecoded = urldecode($rawdata);
     #parse_str($urldecoded, $data);

     #$data = $parsed['data'];

     $data = $request->parameters;

     #/*
     foreach ($data as $val_param=>$val_value){

             if ($val_param == 'email'){
                $email = $val_value;
                } elseif ($val_param == 'account_name'){
                $account_name = $val_value;
                } elseif ($val_param == 'first_name'){
                $first_name = $val_value;
                } elseif ($val_param == 'last_name'){
                $last_name = $val_value;
                } elseif ($val_param == 'username'){
                $username = $val_value;
                } elseif ($val_param == 'password'){
                $password = $val_value;
                } 

             #$logdata .= "param: ".$val_param." => ".$val_value." | ";

             } # foreach for action
             
     */
     $email = $request->parameters['email'];
     $account_name = $request->parameters['account_name'];
     $first_name = $request->parameters['first_name'];
     $last_name = $request->parameters['last_name'];
     $username = $request->parameters['username'];
     $password = $request->parameters['password'];
     $account_type = $request->parameters['account_type'];
     $api_key = $request->parameters['api_key'];
     
     
     ############################
     # Do Logger

     $do_logger = TRUE;

     if ($do_logger == TRUE){

        $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
        $log_name = "Scalastica";
        $log_content = "action:".$action.",email:".$email.",password:".$password.",api_key:".$api_key.", username:".$username;

        $logparams[0] = $log_location;
        $logparams[1] = $log_name;
        $logparams[2] = $log_content;
        $funky_gear->funky_logger ($logparams);

        }

     # End Logger 
     ############################

     $error = "";

     if ($email == NULL){
        $error .= $strings["SubmissionErrorEmptyItem"].$strings["Email"].". ";
        }

     if ($password == NULL){
        $error .= $strings["SubmissionErrorEmptyItem"].$strings["Password"].". ";
        }

     if ($first_name == NULL){
        $error .= $strings["SubmissionErrorEmptyItem"].$strings["FirstName"].". ";
        }

     if ($last_name == NULL){
        $error .= $strings["SubmissionErrorEmptyItem"].$strings["LastName"].". ";
        }

     if (!$error){

        $rego_params[0]['service_leadsources_id_c'] = "d2dc840e-c041-d08d-9f53-51bf7aac9cb7";
        $rego_params[0]['service_ci_source'] = $sc_source_id; # This will act as the wrapper CI for any userids under it as parent
        $rego_params[0]['service_parci_id'] = $sc_parci_id;
        $rego_params[0]['members_cit_id'] = "7ce9e892-9aa0-c228-3d9d-55ed0467e9df"; # Scalastica Members to be used with parci

        require_once ('../api-sessions.php');

        /*
        $auth_params[0] = $sent_email;
        $auth_params[1] = $sent_password;
        $auth_params[2] = $api_key;
        $auth_params[3] = $api_sess;

        $check_response = $this->authenticate($auth_params);
        $success = $check_response[0];
        $check_pack = $check_response[1]; 
        #$response['success'] = $success;
        #$response['api'] = 'Scalastica';
        #$response['auth'] = $check_pack;
        #$response = $check_pack;

        */

        # End building rego params
        #########################
        # Pass the details onto the rego function

        
        $sc_userid = $_SESSION['scalastica'];
        $rego_params[1]['scalastica'] = $sc_userid; # add the uid

        # The rego/login params will differ depending on the source
        $rego_params[2]['sc_app_id'] = $sc_app_id;
        $rego_params[2]['sc_app_secret'] = $sc_app_secret;

        $rego_params[3]['account_name'] = $account_name;
        $rego_params[3]['userid'] = $username;
        $rego_params[3]['name'] = $first_name." ".$last_name;
        $rego_params[3]['first_name'] = $first_name;
        $rego_params[3]['last_name'] = $last_name;
        $rego_params[3]['email'] = $email;
        $rego_params[3]['timezone'] = $timezone;
        $rego_params[3]['locale'] = $locale;
        $rego_params[3]['password'] = $password;

        $rego_params[4]['role_c'] = $role_AccountAdministrator; # all new ones
        $rego_params[4]['security_level'] = 2; # All new ones

        #$rego_params[5] = "e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3"; # client || account_type
        $rego_params[5] = $account_type;
        
        $rego_params[6]['hostname'] = "";# used for business accounts
        $rego_params[6]['hostname_type'] = "";
   
        $process_message = $funky_gear->do_rego($rego_params);

        $rego_status = $process_message['rego_status'];
        $rego_contact_id = $process_message['rego_contact_id'];
        $rego_account_id = $process_message['rego_account_id'];
        $rego_security_level = $process_message['rego_security_level'];
        $rego_security_role = $process_message['rego_security_role'];
        $rego_messages = $process_message['rego_messages']; 
    
        if ($rego_status == 'OK'){
          
           $rego_package = array();
           $rego_package['api_response'] = 'OK';
           $rego_package['api_message'] = $rego_messages;
           $rego_package['sess_con'] = $rego_contact_id;
           $rego_package['sess_acc'] = $rego_account_id;
          
           } elseif ($rego_status == 'NG') {

           $rego_package = array();
           $rego_package['api_response'] = 'NG';
           $rego_package['api_message'] = $rego_messages;
           $rego_package['sess_con'] = "";
           $rego_package['sess_acc'] = "";
          
           } else {
             
           $rego_package = array();
           $rego_package['api_response'] = 'NG';
           $rego_package['api_message'] = "Empty";
           $rego_package['sess_con'] = "";
           $rego_package['sess_acc'] = "";
           
           }
        
        } else {

        $rego_package = array();
        $rego_package['api_response'] = 'NG';
        $rego_package['api_message'] = $error;
        $rego_package['sess_con'] = '';
        $rego_package['sess_acc'] = '';

        } 

    return $rego_package;

    }

    protected function authenticate($auth_params){

      # Check to see if sess sent and if it is correct or login info

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

      $sent_email = $auth_params[0];
      $sent_password = $auth_params[1];
      $api_key = $auth_params[2];
      $api_sess = $auth_params[3];

      if ($api_key != NULL){

         $confirm_key = $this->check_key($api_key);

         } else {

         $confirm_key = FALSE;

         } 

      #var_dump($confirm_key);

      if ($sent_email != NULL && $sent_password != NULL && $confirm_key && $api_sess == NULL){

         # Try login

         $object_type = "Contacts";
         $login_action = "contact_by_email";
         $login_params = $sent_email; // query

         $contact_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $login_action, $login_params);

         if ($contact_id_c != NULL){

            # Get Password info and name
            $object_type = "Contacts";
            $login_action = "contact_by_id";
            $login_params = $contact_id_c; // query

            $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $login_action, $login_params);

            # Create an email to remind

            foreach ($result['entry_list'] as $gotten){

                    $fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);    
                    # $id =  $fieldarray['id'];
                    $fn =  $fieldarray['first_name'];
                    # $ln =  $fieldarray['last_name'];
                    $realpass =  $fieldarray['password_c'];
                    $role_c =  $fieldarray['role_c'];

                    } // end for each

            if (md5($realpass) == $sent_password){
            #if ($realpass == $sent_password){

            # echo -n "sprekkenze72" | md5sum
            # aa831fa527fdd7daaaba87bb1a899532
            # {matt@saloob.com:aa831fa527fdd7daaaba87bb1a899532}

               # Password must be sent with MD5 conversion
               # Email and password OK
               # Check Account ID
               $accid_object_type = "Contacts";
               $accid_action = "get_account_id";
               $accid_params[0] = $contact_id_c;
               $accid_params[1] = "account_id";
               $account_id_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);

               if ($account_id_c != NULL){

                  $_SESSION['account_id'] = $account_id_c;

                  $sess_account_id = $account_id_c;

                  $check_pack = array();
                  $check_pack['api_response'] = 'OK';
                  $check_pack['api_message'] = "Credentials Correct.";
                  #$response['api_message'] = "Credentials Correct! [".md5($sent_password)."]";
                  $check_pack['api_sess'] = $sess_account_id;
                  $check_pack['sess_con'] = $contact_id_c;
                  $check_pack['sess_acc'] = $sess_account_id;
                  $response[0] = TRUE;
                  $response[1] = $check_pack;

                  } else {

                  # if account_id_c != NULL

                  $check_pack = array();
                  $check_pack['api_response'] = 'NG';
                  $check_pack['api_message'] = "Credentials Incorrect - no account";
                  $check_pack['api_sess'] = "";
                  $check_pack['sess_con'] = "";
                  $check_pack['sess_acc'] = "";
                  $response[0] = FALSE;
                  $response[1] = $check_pack;

                  } # end if account

               } else {

               # Email and password OK

               $check_pack = array();
               $check_pack['api_response'] = 'NG';
               #$check_pack['api_message'] = "Email or Password Incorrect [".md5($realpass)."]";
               $check_pack['api_message'] = "Email or Password Incorrect";
               $check_pack['api_sess'] = "";
               $check_pack['sess_con'] = "";
               $check_pack['sess_acc'] = "";
               $response[0] = FALSE;
               $response[1] = $check_pack;

               } # if real pass is ok

            } else {

            # if contact_id_c != NULL 

            $check_pack = array();
            $check_pack['api_response'] = 'NG';
            $check_pack['api_message'] = "Email Does Not Exist.";
            $check_pack['api_sess'] = "";
            $check_pack['sess_con'] = "";
            $check_pack['sess_acc'] = "";
            $response[0] = FALSE;
            $response[1] = $check_pack;

            } # if real pass is ok

         } elseif ($sent_email == NULL && $sent_password == NULL && $api_sess != NULL && $confirm_key){

         # auth params not null
         # Check api_key

         $api_sess = TRUE;

         if ($api_sess == TRUE){

            $check_pack = array();
            $check_pack['api_response'] = 'OK';
            $check_pack['api_message'] = "Credentials [SESS] Correct.";
            $check_pack['api_sess'] = $api_sess;
            $check_pack['sess_con'] = $_SESSION['contact_id'];
            $check_pack['sess_acc'] = $api_sess;
            $response[0] = FALSE;
            $response[1] = $check_pack;

            } else {

            $check_pack = array();
            $check_pack['api_response'] = 'NG';
            $check_pack['api_message'] = "Credentials Incorrect.";
            $check_pack['api_sess'] = "";
            $check_pack['sess_con'] = "";
            $check_pack['sess_acc'] = "";
            $response[0] = FALSE;
            $response[1] = $check_pack;

            } # if not $api_sess == $api_key


         } elseif ($sent_email != NULL && $sent_password != NULL && !$confirm_key){

         # no key sent

         $check_pack = array();
         $check_pack['api_response'] = 'NG';
         $check_pack['api_message'] = "No API Key.";
         $check_pack['api_sess'] = "";
         $check_pack['sess_con'] = "";
         $check_pack['sess_acc'] = "";
         $response[0] = FALSE;
         $response[1] = $check_pack;

#         } elseif ($sent_email == NULL && $sent_password == NULL && $confirm_key == NULL && $api_sess == NULL){
         } elseif ($sent_email == NULL && $sent_password == NULL){

         # no auth sent

         $check_pack = array();
         $check_pack['api_response'] = 'NG';
         $check_pack['api_message'] = "No Credentials Sent.";
         $check_pack['api_sess'] = "";
         $check_pack['sess_con'] = "";
         $check_pack['sess_acc'] = "";
         $response[0] = FALSE;
         $response[1] = $check_pack;

         } # nothing

      #serialize($request)

      return $response;

    } # end Auth public function
    
    /**
     * Read articles.
     *
     * @return array
     */

    protected function check_key($key) {

     # Check if this API Key is OK for use
     # Return TRUE of OK or FALSE

     return TRUE;

    } # End function check_key($key)


    protected function readGear() {

     #$articles = unserialize(file_get_contents($this->content));
     #if (empty($content)) {
     # $this->writeGear($content);
     #return $content;

    }
    
    /**
     * Write articles.
     *
     * @param  string $articles
     * @return boolean
     */
    protected function writeGear($content){

        #file_put_contents($this->content, serialize($content));
        #return true;

    } # write

} # End class