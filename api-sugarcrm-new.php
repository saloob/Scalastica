<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-23
# Page: api-sugarcrm-new.php 
##########################################################
# Convert Name/Values

if (!$_SESSION){
 session_start();
 }

if (!function_exists('nameValuePairToSimpleArray')){

   function nameValuePairToSimpleArray($array){

      $my_array=array();

      while (list($name,$value)=each($array)){

            $my_array[$value['name']]=$value['value'];

            } # while

    return $my_array;

   } # end function

   } # end if

# End Convert Name/Values
##################################
# SugarCRM SOAP Session

function sugarsession ($api_user, $api_pass, $crm_wsdl_url){

 require_once ("nusoap/nusoap.php");

 $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass), 'version' => '0.1'),'Scalastica');

 $soapclient = new nusoap_client($crm_wsdl_url);
 $login_results = $soapclient->call('login',$auth_array);
 $sugar_session_id = $login_results['id'];

 $soapreturn = array();
 $soapreturn[0] = $soapclient;
 $soapreturn[1] = $sugar_session_id;
 
 return $soapreturn;  

 } // end sugarsession function

# End sessioner
##################################
# Core Function

function api_sugar ($api_user, $api_pass, $api_url, $object_type, $action, $params){

 global $lingos, $lingo, $strings, $crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $funky_gear;

  if (!$lingo){
      $lingo = "en";
      }
  if (!$lingoname){
     $lingoname = "name_".$lingo;
     }

  if ($api_user != NULL){
 
     define('sugarEntry', TRUE);  

     # Provide for non-SOAP access - SLOOOOW
     $sessiontype = "soap";

     # Set up session with timeout check
     $soaper = sugarsession ($api_user, $api_pass, $api_url);
     $soapclient = $soaper[0];
     $sugar_session_id = $soaper[1];
 
     } else {
    
     global $db,$db_name,$db_user,$db_pass,$db_host;

     $sessiontype = "db";

     } # if API user
 
 # End Database Initialise
 ##################################
 # Begin switch

 $returnpack = "";

 /*
 $returnpack[0]['id'] = "1";
 $returnpack[0]['name'] = "Inside Sugar Function!";
 $returnpack[1]['id'] = "2";
 $returnpack[1]['name'] = "Wooop";
 */

 switch ($object_type){
  
  ###################################
  case 'Events':

   switch ($action){
    
    case 'select':    

     if (is_array($params)){
        $query = $params[0];
        $select = $params[1];
        $group = $params[2];
        $order = $params[3];
        $limit = $params[4];
        } else {
        $query = "";
        $select = "";
        $order = "";
        $group = "";
        $limit = "";
        }
 
     if ($query != NULL){
        $query = "WHERE ".$query." ";
        }

     if ($select == NULL){
        $select = "*";
        }

     if ($group != NULL){
        $group = " GROUP BY ".$group." ";
        } 

     if ($order != NULL){
        $order = " ORDER BY ".$order." ";
        }

     if ($limit != NULL){
        $limit = " LIMIT ".$limit." ";
        }

     $events_db = new DB_Sql();
     $events_db->Database = DATABASE_NAME;
     $events_db->User     = DATABASE_USER;
     $events_db->Password = DATABASE_PASSWORD;
     $events_db->Host     = DATABASE_HOST;

     $fullquery = "SELECT $select FROM `sclm_events` $query $group $order $limit";
     #echo "Full Query $fullquery <P>";

     $events_db->query($fullquery);
     $the_list = $events_db->resultset();

     #var_dump($the_list);

     $cnt = 0;
  
     foreach ($the_list as $the_row) {

             $returnpack[$cnt]['id'] = $the_row['id'];
             $returnpack[$cnt]['name'] = $the_row['name'];
             $returnpack[$cnt]['date_entered'] = $the_row['date_entered'];
             $returnpack[$cnt]['date_modified'] = $the_row['date_modified'];
             $returnpack[$cnt]['modified_user_id'] = $the_row['modified_user_id'];
             $returnpack[$cnt]['created_by'] = $the_row['created_by'];
             $returnpack[$cnt]['description'] = $the_row['description'];
             $returnpack[$cnt]['deleted'] = $the_row['deleted'];        
             $returnpack[$cnt]['assigned_user_id'] = $the_row['assigned_user_id'];

             $returnpack[$cnt]['account_id_c'] = $the_row['account_id_c'];
             $returnpack[$cnt]['contact_id_c'] = $the_row['contact_id_c'];

             $returnpack[$cnt]['cmn_statuses_id_c'] = $the_row['cmn_statuses_id_c'];
             $returnpack[$cnt]['cmn_countries_id_c'] = $the_row['cmn_countries_id_c'];
             $returnpack[$cnt]['cmn_languages_id_c'] = $the_row['cmn_languages_id_c'];
             $returnpack[$cnt]['cmn_currencies_id_c'] = $the_row['cmn_currencies_id_c'];

             $returnpack[$cnt]['view_count'] = $the_row['view_count'];
             $returnpack[$cnt]['time_frame_id'] = $the_row['time_frame_id'];
             if ($the_row['time_frame_id']){
                $returnpack[$cnt]['time_frame'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['time_frame_id']."'");
                }

             $returnpack[$cnt]['sclm_events_id_c'] = $the_row['sclm_events_id_c'];
             if ($the_row['sclm_events_id_c']){
                $returnpack[$cnt]['parent_event_name'] = dlookup("sclm_events", "name", "id='".$the_row['sclm_events_id_c']."'");
                }

             $returnpack[$cnt]['start_date'] = $the_row['start_date'];
             $returnpack[$cnt]['end_date'] = $the_row['end_date'];

             $returnpack[$cnt]['object_type_id'] = $the_row['object_type_id'];
             $returnpack[$cnt]['object_value'] = $the_row['object_value'];

             $returnpack[$cnt]['street'] = $the_row['street'];
             $returnpack[$cnt]['city'] = $the_row['city'];
             $returnpack[$cnt]['state'] = $the_row['state'];
             $returnpack[$cnt]['zip'] = $the_row['zip'];
             $returnpack[$cnt]['latitude'] = $the_row['latitude'];
             $returnpack[$cnt]['longitude'] = $the_row['longitude'];
             $returnpack[$cnt]['fb_event_id'] = $the_row['fb_event_id'];
             $returnpack[$cnt]['event_url'] = $the_row['event_url'];
             $returnpack[$cnt]['location'] = $the_row['location'];

             $returnpack[$cnt]['value'] = $the_row['value'];
             $returnpack[$cnt]['positivity'] = $the_row['positivity'];
             $returnpack[$cnt]['probability'] = $the_row['probability'];

             $returnpack[$cnt]['group_type_id'] = $the_row['group_type_id'];
             if ($the_row['group_type_id']){
                $returnpack[$cnt]['group_type_name'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['group_type_id']."'");
                }

             $returnpack[$cnt]['value_type_id'] = $the_row['value_type_id'];
             if ($the_row['value_type_id']){
                $returnpack[$cnt]['value_type_name'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['value_type_id']."'");
                }

             $returnpack[$cnt]['purpose_id'] = $the_row['purpose_id'];
             if ($the_row['purpose_id']){
                $returnpack[$cnt]['purpose'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['purpose_id']."'");
                }

             $returnpack[$cnt]['emotion_id'] = $the_row['emotion_id'];
             if ($the_row['emotion_id']){
                $returnpack[$cnt]['emotion'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['emotion_id']."'");
                }

             $returnpack[$cnt]['ethics_id'] = $the_row['ethics_id'];
             if ($the_row['ethics_id']){
                $returnpack[$cnt]['ethics'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['ethics_id']."'");
                }

             $returnpack[$cnt]['sibaseunit_id'] = $the_row['sibaseunit_id'];
             if ($the_row['sibaseunit_id']){
                $returnpack[$cnt]['sibaseunit'] = dlookup("sclm_configurationitemtypes", "name", "id='".$the_row['sibaseunit_id']."'");
                }

             $returnpack[$cnt]['external_source_id'] = $the_row['external_source_id'];
             $returnpack[$cnt]['source_object_id'] = $the_row['source_object_id'];
             $returnpack[$cnt]['source_object_item_id'] = $the_row['source_object_item_id'];
             $returnpack[$cnt]['object_id'] = $the_row['object_id'];
             $returnpack[$cnt]['external_url'] = $the_row['external_url'];
             $returnpack[$cnt]['event_type'] = $the_row['event_type'];
             $returnpack[$cnt]['rsvp_status'] = $the_row['rsvp_status'];
             $returnpack[$cnt]['serial_number'] = $the_row['serial_number'];
             $returnpack[$cnt]['category_id'] = $the_row['category_id'];

             $returnpack[$cnt]['cmv_politicalparties_id_c'] = $the_row['cmv_politicalparties_id_c'];
             $returnpack[$cnt]['cmv_politicalpartyroles_id_c'] = $the_row['cmv_politicalpartyroles_id_c'];

             $returnpack[$cnt]['cmv_governments_id_c'] = $the_row['cmv_governments_id_c'];
             $returnpack[$cnt]['cmv_governmentroles_id_c'] = $the_row['cmv_governmentroles_id_c'];
             $returnpack[$cnt]['cmv_governmentpolicies_id_c'] = $the_row['cmv_governmentpolicies_id_c'];
             $returnpack[$cnt]['cmv_governmentconstitutions_id_c'] = $the_row['cmv_governmentconstitutions_id_c'];

             $returnpack[$cnt]['cmv_departmentagencies_id_c'] = $the_row['cmv_departmentagencies_id_c'];

             $returnpack[$cnt]['cmv_branchbodies_id_c'] = $the_row['cmv_branchbodies_id_c'];
             $returnpack[$cnt]['cmv_branchdepartments_id_c'] = $the_row['cmv_branchdepartments_id_c'];
 
             $returnpack[$cnt]['cmv_causes_id_c'] = $the_row['cmv_causes_id_c'];
     
             $returnpack[$cnt]['cmv_independentagencies_id_c'] = $the_row['cmv_independentagencies_id_c'];
             $returnpack[$cnt]['cmv_organisations_id_c'] = $the_row['cmv_organisations_id_c'];

             $returnpack[$cnt]['cmv_constitutionalarticles_id_c'] = $the_row['cmv_constitutionalarticles_id_c'];
             $returnpack[$cnt]['cmv_constitutionalamendments_id_c'] = $the_row['cmv_constitutionalamendments_id_c'];

             $returnpack[$cnt]['social_networking_id'] = $the_row['social_networking_id'];
             $returnpack[$cnt]['portal_account_id'] = $the_row['portal_account_id'];

             $returnpack[$cnt]['event_image_url'] = $the_row['event_image_url'];

             $cnt++;
     
             } // end foreach
    
    break; // end select action
    case 'update':

     $set_entry_params = array(
    'session' => $sugar_session_id,
               'module_name' => 'sclm_Events',
               'name_value_list'=> $params
     );

     $returnpack = $soapclient->call('set_entry',$set_entry_params);
    
    break;
   
   } // end actions switch
  
  break;
  ###################################

 } # end switch

 return $returnpack;

} # end API function

##########################################################
?>