<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: MessagesController.php 
##########################################################
# case 'MessagesController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class MessagesController extends AbstractController
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

      /*
      foreach ($http_params as $param=>$value){
              if ($param == 'action'){
                  $action = $value;
                  } elseif ($param == 'sess_acc'){
                  $sess_account_id = $value;
                  } elseif ($param == 'sess_con'){
                  $sess_contact_id = $value;
                  } elseif ($param == 'auth'){
                  $auth = $value;
                  }
              } # foreach for action

      */

      $action = $request->parameters['action'];
      $sess_account_id = $request->parameters['sess_acc'];
      $sess_contact_id = $request->parameters['sess_con'];
      $auth = $request->parameters['auth'];

      switch ($action){

       case 'list':

        # collect details
        /*
        foreach ($http_params as $val_param=>$val_value){
                if ($val_param == 'id'){
                   $event_id = $val_value;
                   } elseif ($val_param == 'search_date'){
                   $search_date = $val_value;
                   } elseif ($val_param == 'page'){
                   $page = $val_value;
                   } elseif ($val_param == 'keyword'){
                   $search_keyword = $val_value;
                   $search_keyword = str_replace("'", "\\'", $search_keyword);
                   } # end if 
                 } # inner foreach
        */

        $val = $request->parameters['val'];
        $valtype = $request->parameters['valtype'];
        #$event_id = $request->parameters['event_id'];
        $search_date = $request->parameters['search_date'];
        $page = $request->parameters['page'];
        $search_keyword = $request->parameters['keyword'];
        $search_keyword = str_replace("'", "\\'", $search_keyword);

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
        # Show listing based on details sent

        $event_params[0] = " deleted=0 ";

        switch ($valtype){

         case 'Events':

          if ($val != NULL){
             $event_id = $val;
             }

         break; # Events
         case 'ParEvents':

          if ($val != NULL){
             $par_event_id = $val;
             }

         break; # Events

        } # valtype switch

        if ($event_id != NULL){
           $event_params[0] = " id='".$event_id."' ";
           } elseif ($par_event_id != NULL){
           $event_params[0] = " sclm_events_id_c='".$par_event_id."' "; # Get children
           } elseif ($sess_contact_id != NULL){
           #$event_params[0] = " contact_id_c='".$sess_contact_id."' && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
           $event_params[0] .= " && (contact_id_c='".$sess_contact_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
           } else {
           $event_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
           }

        if ($search_date != NULL){
           $event_params[0] .= " && start_date like '%".$search_date."%' ";
           } 

        if ($search_keyword != NULL){
           $event_params[0] .= " && (description like '%".$search_keyword."%' || name like '%".$search_keyword."%' )";
           }

        $sfx_object_type = "Events";
        $sfx_action = "select";
        $sfx_params = "";
        $sfx_params = array();
        $sfx_params[0] = $event_params[0];
        $sfx_params[1] = "id";
        $sfx_params[2] = "";
        $sfx_params[3] = "";
        $sfx_params[4] = "";

        $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);        

        if (is_array($effects)){

           if ($page == ""){
              $page = 1;
              } # page

           $count = count($effects);
           $glb_perpage_items = 10;

           $mpage = floor($count / $glb_perpage_items);
           $rest = $count%$glb_perpage_items;
           if ($rest > 0){
              $mpage++;
              }

           $lfrom = ($page - 1) * $glb_perpage_items;

           } # if array

        $event_pack = array();
        $sfx_params = "";
        $sfx_params = array();
        $sfx_params[0] = $event_params[0];
        $sfx_params[1] = "id,name,start_date,end_date,sclm_events_id_c,description,category_id,cmn_statuses_id_c,event_image_url,location,latitude,longitude,street,city,state,zip,cmn_countries_id_c";
        $sfx_params[2] = "";
        $sfx_params[3] = " start_date DESC ";
        $sfx_params[4] = " $lfrom , $glb_perpage_items ";

        $effects = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);        

        if (is_array($effects)){

           for ($cnt=0;$cnt < count($effects);$cnt++){

               $id = $effects[$cnt]['id'];
               $event_name = $effects[$cnt]['name'];
               $sclm_events_id_c = $effects[$cnt]['sclm_events_id_c'];
               $parent_event_name = $effects[$cnt]['parent_event_name'];
               $event_description = $effects[$cnt]['description'];
               $event_location = $effects[$cnt]['location'];
               $event_latitude = $effects[$cnt]['latitude'];
               $event_longitude = $effects[$cnt]['longitude'];
               $event_street = $effects[$cnt]['street'];
               $event_city = $effects[$cnt]['city'];
               $event_state = $effects[$cnt]['state'];
               $cmn_countries_id_c = $effects[$cnt]['cmn_countries_id_c'];
               $start_date = $effects[$cnt]['start_date'];
               $end_date = $effects[$cnt]['end_date'];
               $category_id = $effects[$cnt]['category_id'];
               $event_image_url = $effects[$cnt]['event_image_url'];

               if ($event_image_url != NULL){
                  if ($event_image_url == $funky_gear->replacer("http","",$event_image_url)){

                     $event_image_url = "https://".$hostname."/".$event_image_url;

                     } # if any change

                  } # if image

               if ($category_id != NULL){
                  $cat_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $category_id);
                  $category_name = $cat_returner[0];
                  }

               if ($cmn_countries_id_c != NULL){
                  $country_returner = $funky_gear->object_returner ("Countries", $cmn_countries_id_c);
                  $event_country_id = $cmn_countries_id_c;
                  $event_country_name = $country_returner[0];
                  }


               $cmn_statuses_id_c = $effects[$cnt]['cmn_statuses_id_c'];

               $event_pack[$cnt]['event_id'] = $id;
               $event_pack[$cnt]['parent_id'] = $sclm_events_id_c;
               $event_pack[$cnt]['parent_name'] = $parent_event_name;
               $event_pack[$cnt]['name'] = $event_name;
               $event_pack[$cnt]['description'] = $event_description;
               $event_pack[$cnt]['event_image_url'] = $event_image_url;
               $event_pack[$cnt]['location'] = $event_location;
               $event_pack[$cnt]['latitude'] = $event_latitude;
               $event_pack[$cnt]['longitude'] = $event_longitude;
               $event_pack[$cnt]['street'] = $event_street;
               $event_pack[$cnt]['city'] = $event_city;
               $event_pack[$cnt]['state'] = $event_state;
               $event_pack[$cnt]['country_id'] = $event_country_id;
               $event_pack[$cnt]['country_name'] = $event_country_name;
               $event_pack[$cnt]['start_date'] = $start_date;
               $event_pack[$cnt]['end_date'] = $end_date;
               $event_pack[$cnt]['category_id'] = $category_id;
               $event_pack[$cnt]['category_name'] = $category_name;
               $event_pack[$cnt]['status_id'] = $cmn_statuses_id_c;

               } # for

           $event_package['api_response'] = 'OK';
           $event_package['api_message'] = "Events found";
           $event_package['events'] = $event_pack;
           $event_package['links']['page']['first'] = 1;
           $event_package['links']['page']['last'] = $mpage;

           if ($page > 2){
              $ppage = $page-1;
              $event_package['links']['page']['prev'] = $ppage;
              }

           $npage = $page+1;
           if ($page < $mpage){
              if ($page < ($mpage-1)){ 
                 $event_package['links']['page']['next'] = $npage;
                 }
              }
           /*
           $event_package['paging_per_page'] = $glb_perpage_items;
           $event_package['paging_total_items'] = $count;
           $event_package['paging_total_pages'] = $mpage;
           $event_package['paging_requested_page'] = $page;
           $event_package['paging_current_items'] = $lfrom;
           $event_package['paging_remaining_pages'] = $rest;
           */

           } else {# is array

           $event_package['api_response'] = 'NG';
           $event_package['api_message'] = "No Events";
           $event_package['events'] = "";

           } 

        $response = $event_package;

        # Show listing
        ############################

       break; # list
       case 'add':

        #$event_id = $request->parameters['id'];
        #$event_name = $request->parameters['event_name'];
        #$event_name = $_GET['event_name'];
        #$description = $request->parameters['description'];
        #$category_id = $request->parameters['category_id'];

        $http_params = $request->parameters;
        foreach ($http_params as $val_param=>$val_value){
                if ($val_param == 'event_name'){
                   $event_name = $val_value;
                   } elseif ($val_param == 'description'){
                   $description = $val_value;
                   } elseif ($val_param == 'category_id'){
                   $category_id = $val_value;
                   } # end if 
                } # inner foreach

        $do_logger = TRUE;

        if ($do_logger == TRUE){

           $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
           $log_name = "Scalastica";
           #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

           $log_content = "action:".$action.",sess_acc:".$sess_account_id.",sess_con:".$sess_contact_id.",event_id:".$event_id.",name:".$event_name;

           $logparams[0] = $log_location;
           $logparams[1] = $log_name;
           $logparams[2] = $log_content;
           $funky_gear->funky_logger ($logparams);

           }

       $error = "";

       if ($event_name == NULL){
          $error .= $strings["SubmissionErrorEmptyItem"].$strings["Name"];
          }

       if (!$error){

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

          if ($event_id != NULL){
             $process_message .= $event_name." Event Updated";
             } else {
             $process_message .= $event_name." Event Added";
             }


          $process_message .= $event_name." Event Added";

          $event_package = array();
          $event_package['api_response'] = 'OK';
          $event_package['api_message'] = $process_message;
          $event_package['api_sess'] = $api_sess;
          $event_package['id'] = '71378dbc-943f-b0dc-3d6c-55cbebdc03c4';

          } else {

          $event_package = array();
          $event_package['api_response'] = 'NG';
          $event_package['api_message'] = $error;
          $event_package['api_sess'] = $api_sess;

          } 

        $response = $event_package;

       break; # add

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


     #parse_str(file_get_contents('php://input'), $request->parameters);
     #$data = file_get_contents('php://input');
     #$data = $request->parameters;
     #$data = $request;
     /*
     foreach ($data as $val_param=>$val_value){
             $log_content .= $val_param."=>".$val_value." | ";
             if ($val_param == 'parameters'){

                $log_content .= "params!!";

                foreach ($val_value as $xval_param=>$xval_value){                

                        $log_content .= $xval_param."=>".$xval_value." | ";

                        }

                }

             }
     */

     $val = $request->parameters['val'];
     $valtype = $request->parameters['valtype'];
     $sess_account_id = $request->parameters['sess_acc'];
     $sess_contact_id = $request->parameters['sess_con'];

        ############################
        # Do Logger

        $do_logger = TRUE;

        if ($do_logger == TRUE){

           $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
           $log_name = "Scalastica";
           #$log_link = "../content/".$portal_account_id."/".$log_name.".log";

           #$log_content = "request:".$request.",sess_acc:".$sess_account_id.",sess_con:".$sess_contact_id.",val:".$val;
           #$log_content = $logdata;

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

       break; # auth case action

       } # switch action

      $error = "";

      if (!$val){
         //$error .= $strings["SubmissionErrorEmptyItem"].$strings["Name"];
         $error .= $strings["SubmissionErrorEmptyItem"]." Val";
         }

      if (!$error){

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

          $event_package = array();
          $event_package['api_response'] = 'OK';
          $event_package['api_message'] = "Rock on!";
          $event_package['message_id'] = $message_id;

          } else {

          $event_package = array();
          $event_package['api_response'] = 'NG';
          $event_package['api_message'] = $error;
          $event_package['message_id'] = $message_id;

          } 

      $response = $event_package;

      return $response;

    } # end post

} # End class