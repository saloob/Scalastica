<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2016-08-26
# Page: api.php 
##########################################################
# case 'HirecoController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class HirecoController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    public function get($request){

     global $db,$funky,$hireco;
     #global $db,$funky,$funky_db,$hireco;

     #global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$standard_statuses_closed;

      $module = $request->url_elements[0];
      $http_method = $request->method;
      $http_params = $request->parameters;

      $action = $request->parameters['action'];
      $sess_account_id = $request->parameters['sess_acc'];
      $sess_contact_id = $request->parameters['sess_con'];
      $auth = $request->parameters['auth'];

      $bodypart_id = $request->parameters['bodypart_id'];

      $profile_id = 1;

      # Future to collect from DB

      $bodypart_params['bodypart_id'] = $bodypart_id;
      $bodypart_location = $hireco->locate_bodypart ($bodypart_params);
      $bodypart_name = $bodypart_location['name'];
      $bodypart_origin = $bodypart_location['origin'];
      $bodypart_sub_origin = $bodypart_location['sub_origin'];

      $hireco_pack[0]['profile_id'] = $profile_id;
      $hireco_pack[0]['bodypart_id'] = $bodypart_id;
      $hireco_pack[0]['name'] = $bodypart_name;
      $hireco_pack[0]['origin'] = $bodypart_origin;
      $hireco_pack[0]['sub_origin'] = $bodypart_sub_origin;

      $stimulustypes = $hireco->stimulus_types ();

      $hireco_pack[0]['stimulus_types'] = $stimulustypes;

      switch ($action){

       case 'bodypart':

        if (is_array($hireco_pack)){

           $hireco_package['api_response'] = 'OK';
           $hireco_package['api_message'] = "Bodyparts found";
           $hireco_package['bodyparts'] = $hireco_pack;

           } # if array

        $response = $hireco_package;

       break; # bodypart
       case 'stimulus':

        $stimuli = $request->parameters['stimuli'];
        $stimuli_strength = $request->parameters['stimuli_strength'];

        # Future to collect from DB

        $hireco_pack[0]['target'] = 'brain';
        $hireco_pack[0]['sub_target'] = '';
        $hireco_pack[0]['stimuli'] = $stimuli;
        $hireco_pack[0]['stimuli_strength'] = $stimuli_strength;

        $hireco_params['profile_id'] = $profile_id;
        $hireco_params['bodypart_id'] = $bodypart_id;
        $hireco_params['origin'] = $hireco_pack[0]['origin'];
        $hireco_params['sub_origin'] = $hireco_pack[0]['sub_origin'];
        $hireco_params['target'] = $hireco_pack[0]['target'];
        $hireco_params['sub_target'] = $hireco_pack[0]['sub_target'];
        $hireco_params['stimuli'] = $stimuli;
        $hireco_params['stimuli_strength'] = $stimuli_strength;

        $hireco_data = $hireco->init ($hireco_params);

        $hireco_pack[0]['hireco_data'] = $hireco_data;

        if (is_array($hireco_pack)){

           $hireco_package['api_response'] = 'OK';
           $hireco_package['api_message'] = "Stimulus found";
           $hireco_package['stimuli'] = $hireco_pack;

           } # if array

        ############################
        # Do Logger

        $do_logger = FALSE;

        if ($do_logger == TRUE){

           $log_location = "/var/www/html";
           $log_name = "hireco";
           $log_content = serialize($hireco_package);

           $logparams[0] = $log_location;
           $logparams[1] = $log_name;
           $logparams[2] = $log_content;

           $funky->event_recorder ($logparams);

           }

        # End Logger 
        ############################

        $response = $hireco_package;

       break;
       case 'list':

        # collect details
        $profile_id = $request->parameters['profile_id'];
        $origin = $request->parameters['origin'];
        $sub_origin = $request->parameters['sub_origin'];
        $target = $request->parameters['target'];
        $stimuli = $request->parameters['stimuli'];

        $page = $request->parameters['page'];
        $search_keyword = $request->parameters['keyword'];

        if ($search_keyword){
           $search_keyword = str_replace("'", "\\'", $search_keyword);
           } # end if 

        ############################
        # Do Logger

        /*
        $do_logger = FALSE;

        if ($do_logger == TRUE){

           $log_location = "/var/www/html";
           $log_name = "hireco";
           $log_content = json_encode($hireco_params);

           $logparams[0] = $log_location;
           $logparams[1] = $log_name;
           $logparams[2] = $log_content;
           $funky->event_logger ($logparams);

           }
        */

        # End Logger 
        ############################
        # Show listing based on details sent

        $hireco_params['profile_id'] = $profile_id;
        $hireco_params['origin'] = $origin;
        $hireco_params['sub_origin'] = $sub_origin;
        $hireco_params['target'] = $target;
        $hireco_params['sub_target'] = $sub_target;
        $hireco_params['stimuli'] = $stimuli;

        $myhireco = $hireco->init ($hireco_params);

        if (is_array($cit_pack)){

           if ($cit_pack){

               $profiles_pack[$profile_cnt]['id'] = $profile_id;
               $profiles_pack[$profile_cnt]['name'] = $cit_name;
               $profiles_pack[$profile_cnt]['description'] = $cit_description;
               $profiles_pack[$profile_cnt]['cit_id'] = $par_cit_id;
               $profiles_pack[$profile_cnt]['data_type_id'] = $data_type_id;
               $profiles_pack[$profile_cnt]['data_bucket'] = $data_bucket;

               } # for

           } else {# if is array

             $profiles_package['api_response'] = 'NG';
             $profiles_package['api_message'] = "No Profiles";
             $profiles_package['profiles'] = "";

           } # if no array

        if (is_array($cit_pack)){

           $profiles_package['api_response'] = 'OK';
           $profiles_package['api_message'] = "Profiles found";
           $profiles_package['profiles'] = $profiles_pack;

           /*
           $cit_package['links']['page']['first'] = 1;
           $cit_package['links']['page']['last'] = $mpage;

           if ($page > 2){
              $ppage = $page-1;
              $cit_package['links']['page']['prev'] = $ppage;
              }

           $npage = $page+1;
           if ($page < $mpage){
              if ($page < ($mpage-1)){ 
                 $cit_package['links']['page']['next'] = $npage;
                 }
              }
           */

           } # end cit array

        $response = $profiles_package;

        # Show listing
        ############################

       break; # list

     } # end switch

    return $response;

    } # end get function

    
    /**
     * POST action.
     *
     * @param  $request
     * @return null
     */
    public function post($request){

     global $db,$funky_db;

     $module = $request->url_elements[0];
     $http_method = $request->method;
     $http_params = $request->parameters;

     switch ($action){

      case 'add':

       $error = "";

       if (!$error){

          $response = null;

          } else {# is array

          return null;
          $response = null;

          } 

       break; # auth case action

       } # switch action

      return $response;

    } # end post

} # End class
