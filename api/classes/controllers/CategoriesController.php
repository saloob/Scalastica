<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: api.php 
##########################################################
# case 'CategoriesController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class CategoriesController extends AbstractController
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
      $category_id = $request->url_elements[1];
      $http_method = $request->method;
      $http_params = $request->parameters;
	  /*
      echo "Request Elements:<P>";
      var_dump($request);
      echo "URL Elements:<P>";
      var_dump($request->url_elements);     
      echo "Module:<P>";
      var_dump($module);
      echo "Category:<P>";
      var_dump($category_id);      
      echo "<P>Method:<P>";
      var_dump($http_method);
      echo "<P>HTTP Params:<P>";
      var_dump($http_params);
      */
      
      $action = $request->parameters['action'];
      $sess_account_id = $request->parameters['sess_acc'];
      $sess_contact_id = $request->parameters['sess_con'];
      $auth = $request->parameters['auth'];

      switch ($action){

       case 'list':

        # collect details
        //$category_id = $request->parameters['id'];
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

        $cat_params[0] = " deleted=0 ";

        if ($category_id != NULL){
           $cat_params[0] .= " && id='".$category_id."' ";
           } elseif ($sess_contact_id != NULL){
           $cat_params[0] .= " && contact_id_c='".$sess_contact_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."' ";
           } else {
           $cat_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
           }

        if ($search_keyword != NULL){
           $cat_params[0] .= " && (description like '%".$search_keyword."%' || name like '%".$search_keyword."%' )";
           }

        if ($category_id != NULL && $category_id != ''){

           $cat_object_type = "ConfigurationItemTypes";
           $cat_action = "select";
           $cat_params[0] = " id='".$category_id."' ";
           $cat_params[1] = "id,name,description,sclm_configurationitemtypes_id_c"; // select array
           $cat_params[2] = ""; // group;
           $cat_params[3] = "name ASC"; // order;
           $cat_params[4] = ""; // limit
  
           $catpar_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

           if (is_array($catpar_items)){

              for ($catparcnt=0;$catparcnt < count($catpar_items);$catparcnt++){
 
                  $category_id = $catpar_items[$catparcnt]['id'];
                  $cat_name = $catpar_items[$catparcnt]['name'];
                  #$cat_cit = $catpar_items[$catparcnt]['sclm_configurationitemtypes_id_c'];
                  #$cat_pack[$category_id] = $cat_name;
                  $cat_pack[$catparcnt]['id'] = $category_id;
                  $cat_pack[$catparcnt]['name'] = $cat_name;

                  } # for

              $subcat_object_type = "ConfigurationItemTypes";
              $subcat_action = "select";
              $subcat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$category_id."' ";
              $subcat_params[1] = "id,name,description"; // select array
              $subcat_params[2] = ""; // group;
              $subcat_params[3] = "name ASC"; // order;
              $subcat_params[4] = ""; // limit
  
              $subcat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $subcat_object_type, $subcat_action, $subcat_params);

              if (is_array($subcat_items)){

                 for ($subcnt=0;$subcnt < count($subcat_items);$subcnt++){
 
                     $subcat_id = $subcat_items[$subcnt]['id'];
                     $subcat = $subcat_items[$subcnt]['name'];
                     #$subcat_pack[$subcat_id] = $subcat;
                     #$subcat_pack[$cnt]['id'] = $subcat_id;
                     #$subcat_pack[$cnt]['name'] = $subcat;
                     $cat_pack[$subcnt]['id'] = $subcat_id;
                     $cat_pack[$subcnt]['name'] = $subcat;

                     } # for

                 } # is array

              } # if category_id

           } else {# if no cat

           # Would use keyword search here

           $cat_cit = "a86cf661-d985-f7fc-3a72-5521d38a3700"; # Cats
 
           $cat_object_type = "ConfigurationItemTypes";
           $cat_action = "select";
           $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$cat_cit."' ";
           $cat_params[1] = "id,name,description"; // select array
           $cat_params[2] = ""; // group;
           $cat_params[3] = "name ASC"; // order;
           $cat_params[4] = ""; // limit
  
           $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

           if (is_array($cat_items)){

              for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                  $cat_id = $cat_items[$cnt]['id'];
                  $cat = $cat_items[$cnt]['name'];
                  $cat_pack[$cnt]['id'] = $cat_id;
                  $cat_pack[$cnt]['name'] = $cat;

                  } # for

              } else {# if is array

              $cat_package['api_response'] = 'NG';
              $cat_package['api_message'] = "No Categories";
              $cat_package['cats'] = "";

              } # if no array

           } # end if not cat

        if (is_array($cat_pack)){

           $cat_package['api_response'] = 'OK';
           $cat_package['api_message'] = "Categories found";
           $cat_package['cats'] = $cat_pack;

           /*
           $cat_package['links']['page']['first'] = 1;
           $cat_package['links']['page']['last'] = $mpage;

           if ($page > 2){
              $ppage = $page-1;
              $cat_package['links']['page']['prev'] = $ppage;
              }

           $npage = $page+1;
           if ($page < $mpage){
              if ($page < ($mpage-1)){ 
                 $cat_package['links']['page']['next'] = $npage;
                 }
              }
           */

           } # end cat array

        $response = $cat_package;

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