<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: ModulesController.php 
##########################################################
# case 'ModulesController':

mb_language('uni');
mb_internal_encoding('UTF-8');

class ModulesController extends AbstractController
{
    
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */

    /**
     * Modules CITs
     *
     * @var variable type
     */

    protected $module_cit_id = '14b6fa7f-165c-ff20-3c9a-5866ee12e3b1';

    public function get($request){

     global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c,$standard_statuses_closed;

     $module_params = $request->parameters;
     $access_token = $module_params['access_token'];

     if ($access_token){

        $http_code = $this->checkToken($access_token);

         if ($http_code === 200) {

             switch (count($request->url_elements)) {

                     case 1:

                       $module_params['id'] = "";
                       $portal_modules = $this->readModules($module_params);

                     break;
                     case 2:

                       $id = $request->url_elements[1];
                       $module_params['id'] = $id;
                       $portal_modules = $this->readModules($module_params);

                     break;

                    } # end switch

            } else {// bad token

            $portal_modules['api_response'] = 'NG';
            $portal_modules['api_message'] = "Sorry, no proper access token passed for this API..";
            $portal_modules['modules'] = "";

            }

         } else {// has no token

         $portal_modules['api_response'] = 'NG';
         $portal_modules['api_message'] = "Sorry, no access token passed for this API..";
         $portal_modules['modules'] = "";

         }

      return $portal_modules;

    } # end get function

    protected function checkToken($token)
    {

         $auth_url = "http://www.scalastica.com/oauth2/resource.php";

         $ch = curl_init(); 
           curl_setopt($ch, CURLOPT_URL, $auth_url);
           curl_setopt($ch, CURLOPT_POST, 1);
           curl_setopt($ch, CURLOPT_POSTFIELDS, "access_token=".$token);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $output = curl_exec($ch);
         $info = curl_getinfo($ch);
         curl_close($ch); 

         $http_code = $info['http_code'];

      return $http_code;

    } # end checkToken function

    protected function readModules($module_params)
    {

        ############################
        # Show listing based on details sent

        $id = $module_params['id'];
        $sess_account_id = $module_params['sess_acc'];
        $sess_contact_id = $module_params['sess_con'];
        $access_token = $module_params['access_token'];
        $search_keyword = $module_params['search_keyword'];
        $auth = $module_params['auth'];

        $cit_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$this->module_cit_id."' ";

        if ($id != NULL){
           $cit_params[0] .= " && id='".$id."' ";
           } elseif ($sess_contact_id != NULL){
           $cit_params[0] .= " && contact_id_c='".$sess_contact_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."' ";
           } else {
           $cit_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
           }

        if ($search_keyword != NULL){
           $cit_params[0] .= " && (description like '%".$search_keyword."%' || name like '%".$search_keyword."%' )";
           }

        # Would use keyword search here
 
        $cit_object = "ConfigurationItemTypes";
        $cit_action = "select";
        $cit_params[1] = "id,name,description"; // select array
        $cit_params[2] = ""; // group;
        $cit_params[3] = "name ASC"; // order;
        $cit_params[4] = ""; // limit
  
        $cit_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cit_object, $cit_action, $cit_params);

        if (is_array($cit_items)){

           for ($cnt=0;$cnt < count($cit_items);$cnt++){
 
               $cit_pack[$cnt]['id'] = $cit_items[$cnt]['id'];
               $cit_pack[$cnt]['name'] = $cit_items[$cnt]['name'];
               $cit_pack[$cnt]['description'] = $cit_items[$cnt]['description'];

               } # for

           $cit_package['api_response'] = 'OK';
           $cit_package['api_message'] = "Awesome! Modules found!";
           $cit_package['modules'] = $cit_pack;

           } else {# if is array

           $cit_package['api_response'] = 'NG';
           $cit_package['api_message'] = "Sorry, no Modules found!";
           $cit_package['modules'] = "";

           } # if no array

        if (is_array($cit_items)){

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

           } # end ci array

        return $cit_package;

    } # end modules
    
    /**
     * POST action.
     *
     * @param  $request
     * @return null
     */
    public function post($request){

     global $strings,$funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

     $module_params = $request->parameters;
     $access_token = $module_params['access_token'];

     if ($access_token){

        $http_code = $this->checkToken($access_token);

         if ($http_code === 200) {

            switch (count($request->url_elements)) {

                    case 1:

                      $module_params['id'] = "";
                      $portal_modules = $this->writeModules($module_params);

                    break;
                    case 2:
      
                      $module_id = $request->url_elements[1];
                      $module_params['id'] = $module_id;
                      $portal_modules = $this->writeModules($module_params);

                    break;

                   } # end switch

            } else {// bad token

            $portal_modules['api_response'] = 'NG';
            $portal_modules['api_message'] = "Sorry, no proper access token passed for this API..";
            $portal_modules['modules'] = "";

            }

         } else {// has no token

         $portal_modules['api_response'] = 'NG';
         $portal_modules['api_message'] = "Sorry, no access token passed for this API..";
         $portal_modules['modules'] = "";

         }

      return $portal_modules;

    } # end post

    protected function writeModules($module_params)
    {

     global $strings,$funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

        ############################
        # Show listing based on details sent

        /*
        $module_params['sess_acc'] = $request->parameters['sess_acc'];
        $module_params['sess_con'] = $request->parameters['sess_con'];
        $module_params['search_keyword'] = $request->parameters['search_keyword'];
        $module_params['auth'] = $request->parameters['auth'];
        */

        $id = $module_params['id'];
        $ids = $module_params['ids'];
        $idArray = explode(",",$ids);
        $name = $module_params['name'];
        $description = $module_params['description'];
        $access_token = $module_params['access_token'];

        # Either ID or name must be sent
        if ($id != NULL || $name != NULL){

           $process_object = "ConfigurationItemTypes";
           $process_action = "update";
           $process_params[] = array('name'=>'id','value' => $id);
           $process_params[] = array('name'=>'name','value' => $name);
           $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $this->module_cit_id);

           if ($assigned_user_id != NULL){
              $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
              }

           if ($description != NULL){
              $process_params[] = array('name'=>'description','value' => $description);
              }

           $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object, $process_action, $process_params);

           if ($result['id'] != NULL){
              $id = $result['id'];
              }

           $cit_pack[0]['id'] = $id;
           $cit_pack[0]['name'] = $name;

           $cit_package['api_response'] = 'OK';
           $cit_package['api_message'] = "Awesome! Module written for ".$name;
           $cit_package['modules'] = $cit_pack;

           } elseif (is_array($idArray)) {# if is array

           $mod_cnt = 1;

           foreach ($idArray as $id){

                   if ($id != NULL){
                      $cit_pack[$mod_cnt]['id'] = $id;
                      $cit_pack[$mod_cnt]['name'] = "Blah - order [".$mod_cnt."] for ".$id;
                      $mod_cnt ++;
                      }
                   }

           $cit_package['api_response'] = 'OK';
           $cit_package['api_message'] = "Awesome! Module written";
           $cit_package['modules'] = $cit_pack;

           } else {# if is array

           $cit_package['api_response'] = 'NG';
           $cit_package['api_message'] = "Sorry, Module not written";
           $cit_package['modules'] = "";

           } # if no array

      return $cit_package;

    } # end write

} # End class