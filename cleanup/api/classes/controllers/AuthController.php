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

      foreach ($http_params as $param=>$value){

              if ($param == 'action'){
                  $action = $value;
                  }

              } # foreach for action


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

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

     #header('HTTP/1.1 201 Created');
     #header('Location: /news/'.$id);

     #var_dump($request);

      $module = $request->url_elements[0];
      $http_method = $request->method;
      $http_params = $request->parameters;

      foreach ($http_params as $param=>$value){

              if ($param == 'action'){
                  $action = $value;
                  }

              } # foreach for action

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
        $response = $check_pack;

       break; # auth case action

       } # switch action

      return $response;

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
                  $response[0] = TRUE;
                  $response[1] = $check_pack;

                  } else {

                  # if account_id_c != NULL

                  $check_pack = array();
                  $check_pack['api_response'] = 'NG';
                  $check_pack['api_message'] = "Credentials Incorrect - no account";
                  $check_pack['api_sess'] = "";
                  $response[0] = FALSE;
                  $response[1] = $check_pack;

                  } # end if account

               } else {

               # Email and password OK

               $check_pack = array();
               $check_pack['api_response'] = 'NG';
               $check_pack['api_message'] = "Email or Password Incorrect.";
               $check_pack['api_sess'] = "";
               $response[0] = FALSE;
               $response[1] = $check_pack;

               } # if real pass is ok

            } else {

            # if contact_id_c != NULL 

            $check_pack = array();
            $check_pack['api_response'] = 'NG';
            $check_pack['api_message'] = "Email Does Not Exist.";
            $check_pack['api_sess'] = "";
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
            $response[0] = FALSE;
            $response[1] = $check_pack;

            } else {

            $check_pack = array();
            $check_pack['api_response'] = 'NG';
            $check_pack['api_message'] = "Credentials Incorrect.";
            $check_pack['api_sess'] = "";
            $response[0] = FALSE;
            $response[1] = $check_pack;

            } # if not $api_sess == $api_key


         } elseif ($sent_email != NULL && $sent_password != NULL && !$confirm_key){

         # no key sent

         $check_pack = array();
         $check_pack['api_response'] = 'NG';
         $check_pack['api_message'] = "No API Key.";
         $check_pack['api_sess'] = "";
         $response[0] = FALSE;
         $response[1] = $check_pack;

         } elseif ($sent_email == NULL && $sent_password == NULL && $confirm_key == NULL && $api_sess == NULL){

         # no auth sent

         $check_pack = array();
         $check_pack['api_response'] = 'NG';
         $check_pack['api_message'] = "No Credentials Sent.";
         $check_pack['api_sess'] = "";
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