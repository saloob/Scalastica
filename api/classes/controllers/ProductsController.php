<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2016-02-17
# Page: ProductsController.php 
##########################################################
# case 'ProductsController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class ProductsController extends AbstractController
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
      $auth = $request->parameters['auth'];
      $page = $request->parameters['page'];

      switch ($action){

       case 'list':

        # collect details
        $accountsservices_id = $request->parameters['product_id'];
        $page = $request->parameters['page'];
        $keyword = $request->parameters['keyword'];
        $lifestyle_category_id = $request->parameters['lifestyle_category_id'];

        # Categories relate to the parent service - should inherit...

        $category_id = $request->parameters['category_id'];
        $parent_category_id = $request->parameters['parent_category_id'];

        $ci_params[0] = " deleted=0 ";

        if ($keyword){
           $keyword = str_replace("'", "\\'", $keyword);
           $ci_params[0] .= " && (description like '%".$keyword."%' || name like '%".$keyword."%' )";
           } # end if 

        if ($sess_account_id){
           $ci_params[0] .= " && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
           } else {
           $ci_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
           } 

        if ($lifestyle_category_id){
           $ci_params[0] .= " && lifestyle_category = '".$lifestyle_category_id."' ";
           }

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

        if ($parent_category_id == $category_id){
           $parent_category_id = "";
           }

        if ($parent_category_id != NULL){

           # Find all the child categories and run 
           $cat_object_type = "ConfigurationItems";
           $cat_action = "select";
           $cat_params[0] = " sclm_configurationitems_id_c='".$parent_category_id."' ";
           $cat_params[1] = "id,name,description,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c"; // select array
           $cat_params[2] = ""; // group;
           $cat_params[3] = "name ASC"; // order;
           $cat_params[4] = "100"; // limit
  
           $catpar_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

           if (is_array($catpar_items)){

              $serv_params[0] = " deleted=0 && (";

              for ($catparcnt=0;$catparcnt < count($catpar_items);$catparcnt++){
 
                  $category_id = $catpar_items[$catparcnt]['id'];

                  if ((count($catpar_items)>1) && ($catparcnt < (count($catpar_items)-1))){
                     $serv_params[0] .= " service_type = '".$category_id."' || ";
                     } elseif ($catparcnt == count($catpar_items)-1){
                     $serv_params[0] .= " service_type = '".$category_id."' ) ";
                     } 

                  } # for

              } # is array

           } elseif ($category_id != NULL){

           $serv_params[0] = " deleted=0  && service_type = '".$category_id."' ";

           }

        if ($serv_params[0] != NULL){

           $serv_object_type = "Services";
           $serv_action = "select";
           $serv_params[1] = "id"; // select array
           $serv_params[2] = ""; // group;
           $serv_params[3] = " name ASC, date_modified DESC "; // order;
           $serv_params[4] = ""; // limit
  
           $serv_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $serv_object_type, $serv_action, $serv_params);

           if (is_array($serv_items)){

              $ci_params[0] .= " && (";

              for ($servcnt=0;$servcnt < count($serv_items);$servcnt++){

                  $cats_sclm_services_id_c = $serv_items[$servcnt]['id'];

                  if ((count($serv_items)>1) && ($servcnt < (count($serv_items)-1))){
                     $ci_params[0] .= " sclm_services_id_c = '".$cats_sclm_services_id_c."' || ";
                     } elseif ($servcnt == count($serv_items)-1){
                     $ci_params[0] .= " sclm_services_id_c = '".$cats_sclm_services_id_c."' ) ";
                     } 

                  } # for

              } # is array

           } 

        # ( service_type = '933435a5-515a-c432-9547-56c4832d0e80' ||  service_type = '908ac347-d3fa-3897-5eeb-56c4840c92d2' ||  service_type = 'ec7c76bf-da35-895b-4be2-56c483a490df' )   

        $ci_object_type = "AccountsServices";
        $ci_action = "select";
        $ci_params[1] = "id,name,image,description,sclm_services_id_c,lifestyle_category,account_id_c"; // select array
        $ci_params[2] = ""; // group;
        $ci_params[3] = " sclm_services_id_c DESC, name ASC, date_modified DESC "; // order;
        $ci_params[4] = ""; // limit
  
        $ci_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

        if (is_array($ci_items)){

           $count = count($ci_items);
           $glb_perpage_items = 20;

           if ($page == ""){
              $page = 1;
              } # page

           $mpage = floor($count / $glb_perpage_items);
           $rest = $count%$glb_perpage_items;
           if ($rest > 0){
              $mpage++;
              }

           $lfrom = ($page - 1) * $glb_perpage_items;

           $ci_params[4] = " $lfrom , $glb_perpage_items "; 

           $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

           for ($cnt=0;$cnt < count($ci_items);$cnt++){

               $id = $ci_items[$cnt]['id'];
               $name = $ci_items[$cnt]['name'];
               $date_entered = $ci_items[$cnt]['date_entered'];
               $date_modified = $ci_items[$cnt]['date_modified'];
               $modified_user_id = $ci_items[$cnt]['modified_user_id'];
               $created_by = $ci_items[$cnt]['created_by'];
               $description = $ci_items[$cnt]['description'];
               $deleted = $ci_items[$cnt]['deleted'];
               $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
               $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
               $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
               $sclm_services_id_c = $ci_items[$cnt]['sclm_services_id_c'];
               $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
               $sclm_accountsservices_id_c = $ci_items[$cnt]['sclm_accountsservices_id_c'];

               $market_value = $ci_items[$cnt]['market_value'];
               $service_name = $ci_items[$cnt]['service_name'];
               $service_account_id_c = $ci_items[$cnt]['service_account_id_c'];
               $service_contact_id_c = $ci_items[$cnt]['service_contact_id_c'];
               $parent_service_type = $ci_items[$cnt]['parent_service_type'];
               $parent_service_type_name = $ci_items[$cnt]['parent_service_type_name'];
               $service_type = $ci_items[$cnt]['service_type'];
               $service_type_name = $ci_items[$cnt]['service_type_name'];
               $service_tier = $ci_items[$cnt]['service_tier'];
               $service_tier_name = $ci_items[$cnt]['service_tier_name'];
               $lifestyle_category = $ci_items[$cnt]['lifestyle_category'];

               if ($lifestyle_category != NULL){
                  $cat_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $lifestyle_category);
                  $lifestyle_category_name = $cat_returner[0];
                  }

               if ($ci_account_id_c != NULL){
                  $acc_returner = $funky_gear->object_returner ("Accounts", $ci_account_id_c);
                  $acc_name = $acc_returner[0];
                  }

               $image = $ci_items[$cnt]['image'];
               # For some reason the db shows this within the url???
               $image = str_replace("", "\"", $image);

               $pack[$cnt]['product_id'] = $id;
               $pack[$cnt]['product_name'] = $name;
               #$pack[$cnt]['product_name'] = "parcat = $parent_category_id && cat = $category_id";
               #$pack[$cnt]['product_name'] = $name." query :".$ci_params[0];
               $pack[$cnt]['product_description'] = $description;
               $pack[$cnt]['product_image'] = $image;
               $pack[$cnt]['product_lifestyle_category_id'] = $lifestyle_category;
               $pack[$cnt]['product_lifestyle_category_name'] = $lifestyle_category_name;
               $pack[$cnt]['product_category_id'] = $service_type;
               $pack[$cnt]['product_category_name'] = $service_type_name;
               $pack[$cnt]['product_account_id'] = $ci_account_id_c;
               $pack[$cnt]['product_account_name'] = $acc_name;

               } # for

           $package['api_response'] = 'OK';
           $package['api_message'] = "Products found";
           $package['products'] = $pack;

           if ($page > 2){
              $ppage = $page-1;
              $package['links']['page']['prev'] = $ppage;
              }

           $npage = $page+1;
           if ($page < $mpage){
              if ($page < ($mpage-1)){ 
                 $package['links']['page']['next'] = $npage;
                 }
              }

           /*
           $package['links']['page']['first'] = 1;
           $package['links']['page']['last'] = $mpage;

           if ($page > 2){
              $ppage = $page-1;
              $package['links']['page']['prev'] = $ppage;
              }

           $npage = $page+1;
           if ($page < $mpage){
              if ($page < ($mpage-1)){ 
                 $package['links']['page']['next'] = $npage;
                 }
              }
           */

           } else {# is array

           $package['api_response'] = 'NG';
           $package['api_message'] = "No Products";
           $package['products'] = "";

           } 

        $response = $package;

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