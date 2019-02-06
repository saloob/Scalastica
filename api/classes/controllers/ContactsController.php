<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: api.php 
##########################################################
# case 'ContactsController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class ContactsController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    public function get($request){

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$standard_statuses_closed;

      $module = $request->url_elements[0];
      $http_method = $request->method;
      $http_params = $request->parameters;

      $action = $request->parameters['action'];
      $sess_account_id = $request->parameters['sess_acc'];
      $sess_contact_id = $request->parameters['sess_con'];
      $contact_id = $request->parameters['contact_id'];
      $account_id = $request->parameters['account_id'];
      $keyword = $request->parameters['keyword'];
      $page = $request->parameters['page'];
      $valtype = $request->parameters['valtype'];
      $val = $request->parameters['val'];

      switch ($action){

       case 'list':

        # collect details

        if ($keyword){
           $keyword = str_replace("'", "\\'", $keyword);
           } # end if 

        ############################
        # Do Logger

        /*

        $do_logger = FALSE;

        if ($do_logger == TRUE){

           $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
           $log_name = "Scalastica";
           #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

           $log_content = "action:".$action.",sess_acc:".$sess_account_id.",sess_con:".$sess_contact_id.",event_id:".$event_id;

           $logparams[0] = $log_location;
           $logparams[1] = $log_name;
           $logparams[2] = $log_content;
           $funky_gear->funky_logger ($logparams);

           }

        */

        # End Logger 
        ############################
        # Show listing based on details sent

        switch ($valtype){

         case '':

          $contact_params[0] = " id='XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX' ";

         break;
         case 'Contacts':

          $contact_params[0] = " deleted=0 ";

          if ($contact_id != NULL){
             $contact_params[0] .= " && id='".$contact_id."' ";
             } elseif ($sess_contact_id != NULL){
             $contact_params[0] .= " && id='".$sess_contact_id."' ";
             } elseif ($sess_account_id != NULL){
             $contact_params[0] .= " && account_id='".$sess_account_id."' ";
             } else {
             $contact_params[0] .= " && id='XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX' ";
             }

         break;

        } # end switch

        if ($keyword != NULL){
           $contact_params[0] .= " && (first_name like '%".$keyword."%' || last_name like '%".$keyword."%' )";
           }

        $contact_object_type = 'Contacts';
        $contact_action = "select";
        $contact_params[1] = "*";
        $contact_params[2] = "";
        $contact_params[3] = "";
        $contact_params[4] = "";
 
        $contacts_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url,$contact_object_type, $contact_action, $contact_params);
     
        if (is_array($contacts_list)){

            for ($cnt=0;$cnt < count($contacts_list);$cnt++){

                $contact_id = $contacts_list[$cnt]['id'];
                $first_name = $contacts_list[$cnt]['first_name'];
                $last_name = $contacts_list[$cnt]['last_name'];
                $date_modified = $contacts_list[$cnt]['date_modified'];
                $pack[$cnt]['id'] = $contact_id;
                $pack[$cnt]['first_name'] = $first_name;
                $pack[$cnt]['last_name'] = $last_name;
                $pack[$cnt]['date_modified'] = $date_modified;

                } # for

           $contact_package['api_response'] = 'OK';
           $contact_package['api_message'] = "Contact(s) found";
           $contact_package['contacts'] = $pack;

           } else {# if no data

           # Would use keyword search here

           $contact_package['api_response'] = 'NG';
           $contact_package['api_message'] = "No Contact(s) found";
           $contact_package['contacts'] = "";

           } # end if not cat

        $response = $contact_package;

        # Show listing
        ############################

       break; # list

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

     global $strings,$funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

     #var_dump($request);
     $module = $request->url_elements[0];
     $http_method = $request->method;
     $http_params = $request->parameters;

     #var_dump($http_method);
     #var_dump($http_params);

     foreach ($http_params as $param=>$value){

             if ($param == 'action'){
                $action = $value;
                } elseif ($param == 'id'){
                $event_id = $value;
                } elseif ($param == 'sess_acc'){
                $sess_account_id = $value;
                } elseif ($param == 'sess_con'){
                $sess_contact_id = $value;
                } elseif ($param == 'auth'){
                $auth = $value;
                } 

             } # foreach for action

        ############################
        # Do Logger

        $do_logger = FALSE;

        if ($do_logger == TRUE){

           $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
           $log_name = "Scalastica";
           #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

           $log_content = "action:".$action.",sess_acc:".$sess_account_id.",sess_con:".$sess_contact_id.",event_id:".$event_id;

           $logparams[0] = $log_location;
           $logparams[1] = $log_name;
           $logparams[2] = $log_content;
           $funky_gear->funky_logger ($logparams);

           }

        # End Logger 
        ############################

     switch ($action){

      case 'add':

       # collect details

       foreach ($http_params as $val_param=>$val_value){
               if ($val_param == 'name'){
                  $event_name = $val_value;
                  } elseif ($val_param == 'description'){
                  $description = $val_value;
                  } elseif ($val_param == 'category_id'){
                  $category_id = $val_value;
                  } # end if 
               } # inner foreach

      $error = "";

      if ($event_name == NULL){
         $error .= $strings["SubmissionErrorEmptyItem"].$strings["Name"];
         }

      if (!$error){

         $process_message .= $_POST['name'];

          /*
          $object_type = "Events";
          $process_action = "update";
          $process_params[] = array('name'=>'id','value' => $_POST['id']);
          $process_params[] = array('name'=>'name','value' => $_POST['name']);
          $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
          $process_params[] = array('name'=>'description','value' => $_POST['description']);
          $process_params[] = array('name'=>'view_count','value' => $_POST['view_count']);
          $process_params[] = array('name'=>'start_date','value' => $_POST['start_date']);
          $process_params[] = array('name'=>'end_date','value' => $_POST['end_date']);
          $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
          $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
          $process_params[] = array('name'=>'cmn_languages_id_c','value' => $_POST['cmn_languages_id_c']);
          $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);
          $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
          $process_params[] = array('name'=>'value_type_id','value' => $_POST['value_type_id']);
          $process_params[] = array('name'=>'group_type_id','value' => $_POST['group_type_id']);
          $process_params[] = array('name'=>'emotion_id','value' => $_POST['emotion_id']);
          $process_params[] = array('name'=>'purpose_id','value' => $_POST['purpose_id']);
          $process_params[] = array('name'=>'positivity','value' => $_POST['positivity']);
          $process_params[] = array('name'=>'probability','value' => $_POST['probability']);
          $process_params[] = array('name'=>'sibaseunit_id','value' => $_POST['sibaseunit_id']);
          $process_params[] = array('name'=>'time_frame_id','value' => $_POST['time_frame_id']);
          $process_params[] = array('name'=>'ethics_id','value' => $_POST['ethics_id']);
          $process_params[] = array('name'=>'external_source_id','value' => $_POST['external_source_id']); // Should have been sent
          $process_params[] = array('name'=>'source_object_id','value' => $_POST['source_object_id']); // Should have been sent
          $process_params[] = array('name'=>'source_object_item_id','value' => $_POST['source_object_item_id']);
          $process_params[] = array('name'=>'object_id','value' => $_POST['object_id']); // The value of the object
          $process_params[] = array('name'=>'external_url','value' => $_POST['external_url']);

          $process_params[] = array('name'=>'fb_event_id','value' => $_POST['fb_event_id']);

          $process_params[] = array('name'=>'street','value' => $_POST['street']);
          $process_params[] = array('name'=>'city','value' => $_POST['city']);
          $process_params[] = array('name'=>'state','value' => $_POST['state']);
          $process_params[] = array('name'=>'zip','value' => $_POST['zip']);
          $process_params[] = array('name'=>'latitude','value' => $_POST['latitude']);
          $process_params[] = array('name'=>'longitude','value' => $_POST['longitude']);
          $process_params[] = array('name'=>'event_url','value' => $_POST['event_url']);
          $process_params[] = array('name'=>'location','value' => $_POST['location']);
          $process_params[] = array('name'=>'cmn_countries_id_c','value' => $_POST['cmn_countries_id_c']);

          $process_params[] = array('name'=>'category_id','value' => $_POST['category_id']);

          $process_params[] = array('name'=>'social_networking_id','value' => $_POST['social_networking_id']);
          $process_params[] = array('name'=>'portal_account_id','value' => $_POST['portal_account_id']);

          $process_params[] = array('name'=>'event_image_url','value' => $_POST['event_image_url']);

          $add_parent = $_POST['add_parent'];

          if ($add_parent == NULL){
             $process_params[] = array('name'=>'sclm_events_id_c','value' => $_POST['sclm_events_id_c']);
             }

          $process_params[] = array('name'=>'value','value' => $_POST['value_type_value']);

          $process_params[] = array('name'=>'menstruation_phase_id','value' => $_POST['menstruation_phase_id']);

          $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $process_action, $process_params);

          $process_message .= $strings["SubmissionSuccess"];

          */

          $response = null;

          } else {# is array

          return null;
          $response = null;

          } 

        #$response = $event_package;

       break; # auth case action

       } # switch action

      return $response;

    } # end post

} # End class