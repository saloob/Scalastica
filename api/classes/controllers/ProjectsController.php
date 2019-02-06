<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-03-04
# Page: ProjectsController.php 
##########################################################
# case 'ProjectsController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class ProjectsController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    public function get($request){

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$standard_statuses_closed;

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

       case 'list':

        # collect details

     ############################
     # Do Logger

     $do_logger = FALSE;

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

        foreach ($http_params as $val_param=>$val_value){
    
                if ($val_param == 'sess_acc'){

                   $sess_account_id = $val_value;

                   } elseif ($val_param == 'sess_con'){

                   $sess_contact_id = $val_value;

                   } elseif ($val_param == 'keyword'){

                   $keyword = $val_value;

                   } # end if 

                 } # foreach

        # Get projects content
        #$vallength = strlen($keyword);
        #$trimval = substr($keyword, 0, -1);

        $lingoname = "name_".$lingo."_c";
        $lingodesc = "description_".$lingo."_c";
        $name_field_base = "name_x_c";
        $desc_field_base = "description_x_c";

        if ($keyword){
           $object_return_params[0] = " ($lingodesc like '%".$keyword."%' || $lingoname like '%".$keyword."%') && ";
           } else {
           $object_return_params[0] = "";
           } 

        if ($sess_account_id){
           $object_return_params[0] .= " (cmn_statuses_id_c!= '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
           } else {
           $object_return_params[0] .= " cmn_statuses_id_c!= '".$standard_statuses_closed."' ";
           } 

        $project_cstm_object_type = 'Projects';
        $project_cstm_action = "select_cstm";
        $project_cstm_params[0] = $object_return_params[0];
        $project_cstm_params[1] = ""; // select array
        $project_cstm_params[2] = ""; // group;
        $project_cstm_params[3] = ""; // order;
        $project_cstm_params[4] = ""; // limit
        $project_cstm_params[5] = $lingoname; // lingo
  
        $project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

        if (is_array($project_cstm_items)){

           #$count = count($project_cstm_items);

           #$page = $_POST['page'];
           #$glb_perpage_items = 20;

           #$navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
           #$lfrom = $navi_returner[0];
           #$navi = $navi_returner[1];

           #$project_listings = $navi;

           #$project_cstm_params[4] = " $lfrom , $glb_perpage_items "; 

           #$project_cstm_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_cstm_object_type, $project_cstm_action, $project_cstm_params);

           for ($cnt=0;$cnt < count($project_cstm_items);$cnt++){

               $id_c = $project_cstm_items[$cnt]['id_c'];
               $contact_id_c = $project_cstm_items[$cnt]['contact_id_c'];
               $account_id_c = $project_cstm_items[$cnt]['account_id_c'];
               $project_process_stage_c = $project_cstm_items[$cnt]['project_process_stage_c'];
               $itil_stage_c = $project_cstm_items[$cnt]['itil_stage_c'];
               $cmn_statuses_id_c = $project_cstm_items[$cnt]['cmn_statuses_id_c'];
               $pm_provider = $project_cstm_items[$cnt]['account_id1_c'];
               $pm_contact = $project_cstm_items[$cnt]['contact_id1_c'];

               // Get Custom content

               $project_object_type = "Projects";
               $project_action = "select";
               $project_params[0] = " id='".$id_c."' ";
               $project_params[1] = ""; // select array
               $project_params[2] = ""; // group;
               $project_params[3] = ""; // order;
               $project_params[4] = ""; // limit
  
               $project_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $project_object_type, $project_action, $project_params);
    
               if (is_array($project_items)){

                  for ($prj_cnt=0;$prj_cnt < count($project_items);$prj_cnt++){

                      $name = "";
                      $id = $project_items[$prj_cnt]['id'];
                      $name = $project_items[$prj_cnt]['name'];
                      $date_entered = $project_items[$prj_cnt]['date_entered'];
                      $date_modified = $project_items[$prj_cnt]['date_modified'];
                      $modified_user_id = $project_items[$prj_cnt]['modified_user_id'];
                      $created_by = $project_items[$prj_cnt]['created_by'];
                      $description = $project_items[$prj_cnt]['description'];
                      $deleted = $project_items[$prj_cnt]['deleted'];
                      $assigned_user_id = $project_items[$prj_cnt]['assigned_user_id'];
                      $estimated_start_date = $project_items[$prj_cnt]['estimated_start_date'];
                      $estimated_end_date = $project_items[$prj_cnt]['estimated_end_date'];
                      $status = $project_items[$prj_cnt]['status'];
                      $status_image = "";
                      $status_image = $project_items[$prj_cnt]['status_image'];
                      $status_name = $project_items[$prj_cnt]['status_name'];
                      if ($status_image != NULL){
                         $status_image = "<img src=".$status_image." width=16 alt=".$status_name." title=".$status_name.">";
                         }

                      $priority = $project_items[$prj_cnt]['priority'];

                      if ($project_items[$prj_cnt][$lingoname] != NULL){
                         $name = $project_items[$prj_cnt][$lingoname];
                         }

                      $pack[$cnt]['id'] = $id;
                      $pack[$cnt]['name'] = $name;
                      $pack[$cnt]['description'] = $description;
                      $pack[$cnt]['date_entered'] = $date_entered;
                      $pack[$cnt]['date_modified'] = $date_modified;
                      $pack[$cnt]['estimated_start_date'] = $estimated_start_date;
                      $pack[$cnt]['estimated_end_date'] = $estimated_end_date;
                      $pack[$cnt]['status'] = $status;
                      $pack[$cnt]['status_image'] = $status_image;
                      $pack[$cnt]['priority'] = $priority;
                      $pack[$cnt]['contact_id_c'] = $contact_id_c;
                      $pack[$cnt]['account_id_c'] = $account_id_c;
                      $pack[$cnt]['project_process_stage_c'] = $project_process_stage_c;
                      $pack[$cnt]['itil_stage_c'] = $itil_stage_c;
                      $pack[$cnt]['cmn_statuses_id_c'] = $cmn_statuses_id_c;
                      $pack[$cnt]['pm_provider'] = $pm_provider;
                      $pack[$cnt]['pm_contact'] = $pm_contact;

                      } // end for

                  } // end if

               } // end for

           $package['api_response'] = 'OK';
           $package['api_message'] = "Projects found";
           $package['projects'] = $pack;
      
           } else { // end if array

           $package['api_response'] = 'NG';
           $package['api_message'] = "No Projects";
           $package['projects'] = "";

           }

        $response = $package;

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

      $module = $request->url_elements[0];
      $http_method = $request->method;
      $http_params = $request->parameters;

      foreach ($http_params as $param=>$value){

              if ($param == 'action'){
                  $action = $value;
                  }

              } # foreach for action

      switch ($action){

       case 'add':


       break; # auth case action

       } # switch action

      return $response;

    }
    
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