<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-15
# Page: funkydo
############################################## 

// $encoded = $funky_gear->encrypt($code);
// $decoded = $funky_gear->decrypt($encoded);
// $yesnoval = $funky_gear->yesno ($fieldval);

//session_start();
 
class funkydo {

function funkydone ($MYPOST,$lingo,$do,$action,$val,$valtype,$sent_params) {

//date_default_timezone_set('Asia/Tokyo');
    
   if (!function_exists('get_param')){
      include ("common.php");
      }

####################################
# Title
/*
if ($do != NULL && $action != NULL && $val != NULL && $valtype != NULL){
   $returner = $funky_gear->object_returner ($valtype, $val);
   $object_return_name = $returner[0];
   $page_title = $portal_title." ".$do.": ".$object_return_name;
   } else {
   $page_title = $portal_title;
   }
*/

# End Title
###############################################
# Debugging - show variables

#foreach ($MYPOST as $key=>$value){
#        echo "Funkydo Key: ".$key." - Value: ".$value."<BR>";
#       }

#
###############################################

  # Params Sent in $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$sent_params);

   if (is_array($sent_params)){
      $sentdiv = $sent_params[0];
      $BodyDIV = $sentdiv;
      $listlimit = $sent_params[1];
      } else {
      $bodywidth = $sent_params;
      }

   global $assigned_user_id,$portal_type,$portalcode,$lingos,$lingo,$db,$fbuid,$fbsession,$fbconfig,$facebook,$fbme,$access,$strings,$crm_api_user2,$crm_api_pass2,$crm_wsdl_url2,$portal_skin,$portal_title,$portal_config,$external_source_params,$Body,$GridDIV,$DoDIV,$BodyDIV,$LeftDIV,$RightDIV,$MTVDIV,$social_network_types,$divstyles,$glb_home_url,$standard_statuses_open_public,$standard_statuses_open_anonymous,$standard_statuses_closed,$portal_email,$portal_email_password,$portal_email_server,$portal_email_smtp_auth,$portal_email_smtp_port,$anonymity_params,$funky_gear,$funkydo_gear,$funky_messaging,$funky_wellbeing,$funky_sn,$portal_info,$sess_account_id,$sess_contact_id,$sess_source_id,$sess_leadsources_id_c,$sess_targetmarkets_id_c,$divstyle_blue,$divstyle_grey,$divstyle_white,$divstyle_orange,$divstyle_orange_light,$formtitle_divstyle_blue,$formtitle_divstyle_grey,$formtitle_divstyle_white,$formtitle_divstyle_orange,$formtitle_divstyle_orange_light,$cmn_countries_id_c,$country,$cmn_languages_id_c,$latitude,$longitude,$ip_address,$object_return_name,$object_return,$object_return_title,$object_return_target,$object_return_params,$object_return_completion,$object_return_voter,$account_admin,$auth,$contact_id_c,$account_id_c,$credits_base_rate,$credits_base_currency,$credits_partner_share,$hostname,$parent_account_id,$portal_account_id,$lingoname,$lingodesc,$name_field_base,$desc_field_base,$access_enabled,$access_disabled,$action_rights_all,$action_rights_none,$action_rights_owner,$action_rights_account,$role_AccountAdministrator,$role_AccountMember,$role_DivisionAdministrator,$role_Guest,$role_SystemAdministrator,$role_TeamLeader,$role_SDM,$icon_star,$sentdiv,$listlimit,$sent_params,$security_role,$custom_portal_divstyle,$portal_body_colour,$portal_border_colour,$portal_footer_colour,$portal_header_colour,$portal_font_colour,$topgear_id,$allow_engineer_rego,$allow_provider_rego,$allow_reseller_rego,$allow_client_rego,$fb_source_id,$fb_parci_id,$allow_fb_rego,$fb_app_id,$fb_app_secret,$fb_session,$li_source_id,$li_parci_id,$allow_linkedin_rego,$li_app_id,$li_app_secret,$li_session,$sc_source_id,$sc_parci_id,$sc_session,$gg_source_id,$gg_parci_id,$allow_google_rego,$gg_app_id,$gg_app_secret,$gg_app_devkey,$gg_session,$allow_wellbeing,$enable_hirorins_timer,$show_partners,$show_statistics,$allow_lifeplanner,$allow_infracerts,$require_rego_email_confirm,$rego_email_confirm_parcit;

   if ($valtype != NULL && $val != NULL){
      $returner = $funky_gear->object_returner ($valtype, $val);
      $object_return_name = $returner[0];
      $object_return = $returner[1];
      $object_return_title = $returner[2];
      $object_return_target = $returner[3];
      $object_return_params = $returner[4];
      $object_return_completion = $returner[5];
      $object_return_voter = $returner[6];
      }

   if ($_POST['next_action'] != NULL){
      $action = $_POST['next_action'];
      }

   if (is_array($sent_params)){
      $sentdiv = $sent_params[0];
      $BodyDIV = $sentdiv;
      $listlimit = $sent_params[1];
      } else {
      $bodywidth = $sent_params;
      }

####################################################
# Build Collapsable Tree

/*
$treepart = 'tree_';

foreach ($_POST as $treename=>$treevalue){
 
 // get the first parts - tree_branch_
 $checkname = substr($treename, 0, 5);
 
 if ($checkname == $treepart){
   
  $newtreebit = "&".$treename."=1";
  
  if ($treevalue == NULL){
     $collapsables .= str_replace($newtreebit, "", $collapsables);
     } else {
     $collapsables .= $newtreebit;
     }
  
  }

} // end for post each 
*/

# End Build Collapsable Tree
####################################################

switch ($do){

 ##########################################################
 case '':
 case 'Home':

  $this->funkydone ($MYPOST,$lingo,'Content','view',$portal_account_id,'Accounts',$sent_params);

 /*
  switch ($portal_type){

   case 'system':

    $Content_Welcome = str_replace('BodyDIV', $BodyDIV, $strings["Content_Welcome"]);
    echo "<div style=\"".$divstyle_white."\">".$Content_Welcome."</div>";

    // Make Embedded Object Link
//    $params = array();
//    $params[0] = "Welcome to ".$portal_title;
//    echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);  

   break; // system

  }
*/

 break;
 ##########################################################
 case 'Clear':
 
  //Nothingness

 break;
 ##########################################################
 case 'About':
            
  echo $strings["Content_About"];
  
  // Make Embedded Object Link
  $params = array();
  $params[0] = "About ".$portal_title;
//  echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);
  
 break;
 ##########################################################
 case 'Accounts':
 case 'Providers':
 case 'Resellers':
 case 'Clients':

/*
  if ($val != NULL && $sess_account_id != NULL && ($val == $sess_account_id || $auth==3)){

     include ("Accounts.php");

     } elseif ($val == NULL && $sess_account_id != NULL){

     include ("Accounts.php");

     } elseif ($val != NULL && $sess_account_id != NULL && $val != $sess_account_id && $auth < 3){
     
     $acc_cstm_object_type = "Accounts";
     $acc_cstm_action = "select_cstm";
     $acc_cstm_params[0] = "id_c='".$val."' ";
     $acc_cstm_params[1] = ""; // select
     $acc_cstm_params[2] = ""; // group;
     $acc_cstm_params[3] = ""; // order;
     $acc_cstm_params[4] = ""; // limit

     $account_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_cstm_object_type, $acc_cstm_action, $acc_cstm_params);

     if (is_array($account_cstm_info)){
      
        for ($cstm_cnt=0;$cstm_cnt < count($account_cstm_info);$cstm_cnt++){
            $status_c = $account_cstm_info[$cstm_cnt]['status_c'];
            } # for
        } # is array

     if ($status_c == $standard_statuses_closed && $auth < 3){

        echo "<div style=\"".$divstyle_white."\">This account is currently not publicly open</div>";

        } else {

        include ("Accounts.php");

        }

     } else {# if val
     include ("Accounts.php");
     } 
*/

  include ("Accounts.php");

 break;  // End Accounts
 ##########################################################
 case 'AccountRelationships':

  include ("AccountRelationships.php");
 
 break;  // End AccountRelationships
 ##########################################################
 case 'AccountsServices':

  include ("AccountsServices.php");
 
 break;  // End AccountsServices
 ##########################################################
 case 'AccountsServicesSLAs':

  include ("AccountsServicesSLAs.php");
 
 break;  // End AccountsServicesSLAs
 ##########################################################
 case 'Activity':

  include ("Activity.php");
 
 break;  // End Activity
 ##########################################################
 case 'Administrators':

  include ("Administrators.php");
 
 break;  // End Administrators
 ##########################################################
 case 'Advisory':

  include ("Advisory.php");

 break;
 ##########################################################
 case 'Billing':

  include ("Billing.php");

 break;
 ##########################################################
 case 'BusinessAccounts':
            
  echo $strings["Content_BusinessAccounts"];
  
  // Make Embedded Object Link
  $params = array();
  $params[0] = $strings["BusinessAccounts"];
  echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);
  
 break;
 ##########################################################
 case 'Calendar':

  include ("Calendar.php");

 break;
 ##########################################################
 case 'Comments':

  include ("Comments.php");  
 
 break; 
 ##########################################################
 case 'ConfigurationItems':

  include ("ConfigurationItems.php");

 break;
 ##########################################################
 case 'ConfigurationItemSets':

  include ("ConfigurationItemSets.php");

 break;
 ##########################################################
 case 'ConfigurationItemTypes':

  include ("ConfigurationItemTypes.php");

 break;
 ##########################################################
 case 'Contacts': 

if (!$_SESSION['contact_id']){

   session_start();
   session_unset();
   session_destroy();
   unset($_SESSION['token']); # Google

   echo "Your session has expired, please log in again! <input type=\"button\" value=\"".$strings["action_clicktologin"]."\" onClick=\"timedRefresh(1000);loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=login&value=&valuetype=');return false\">";

   } else {

    include ("Contacts.php");

   }
 
 break;
 ##########################################################
 case 'ContactsServices': 

  include ("ContactsServices.php");

 break;
 ##########################################################
 case 'ContactsServicesSLA': 

  include ("ContactsServicesSLA.php");

 break;
 ##########################################################
 case 'Content': 

  include ("Content.php");

 break;
 ##########################################################
 case 'Countries':

  include ("Countries.php");

 break;
 ##########################################################
 case 'Developers':

  switch ($action){
   
   case 'About':
   
    echo $strings["Content_Developers"];
    
    // Make Embedded Object Link
    $params = array();
    $params[0] = 'Developers';
    echo $funky_gear->makeembedd ($do,'About',$val,$valtype,$params);

   break; // end view
      
   } // end action switch
   
 break;
 ##########################################################
 case 'Emails':

  include ("Emails.php");

 break;
 ##########################################################
 case 'Events':

  include ("Events.php");

 break;
 ##########################################################
 case 'ExternalSources':

  include ("ExternalSources.php");

 break; //End ExternalSources
 ##########################################################
 case 'Facebook':

  include ("Facebook.php");
 
 break;
 ##########################################################
 case 'Google':

  include ("Google.php");
 
 break;
 ##########################################################
 case 'HirorinsTimer':

  include ("HirorinsTimer.php");

 break;
 ##########################################################
 case 'Industries':

  include ("Industries.php");

 break;
 ##########################################################
 case 'Infracerts':

  include ("Infracerts.php");

 break;
 ##########################################################
 case 'Infrastructure':

  include ("Infrastructure.php");

 break;
 ##########################################################
 case 'Licensing':

  include ("Licensing.php");

 break;
 ##########################################################
 case 'Lifestyles':

  include ("Lifestyles.php");

 break;
 ##########################################################
 case 'LifePlanning':

  include ("LifePlanning.php");

 break;
 ##########################################################
 case 'LinkedIn':

  include ("Linkedin.php");

 break;
 ##########################################################
 case 'Login':

  include ("Login.php");  
 
 break;  // End Login do
 ##########################################################
 case 'Meetings':

  include ("Meetings.php");

 break;
 ##########################################################
 case 'Messages':

  include ("Messages.php");

 break;
 ##########################################################
 case 'ContactsNotifications':

  include ("ContactsNotifications.php");

 break;
 ##########################################################
 case 'Opportunities':

  include ("Opportunities.php");

 break;
 ##########################################################
 case 'Orders':

  include ("Orders.php");

 break;
 ##########################################################
 case 'PrivacyPolicy':

  switch ($action){
   
   case 'view':
   
    echo $strings["Content_PrivacyPolicy"];

   break;

  } // end actions

 break; // end PrivacyPolicy
 ##########################################################
 case 'Projects':

 include ("Projects.php");

 break; // end Projects
 ##########################################################
 case 'ProjectTasks':

 include ("ProjectTasks.php");

 break; // end ProjectTasks
 ##########################################################
 case 'Quoting':

  include ("Quoting.php");

 break;
 ##########################################################
 case 'Search':

 include ("Search.php");

 break; // end search
 ##########################################################
 case 'Security':

 include ("Security.php");

 break; // end Security
 ##########################################################
 case 'Services':

 include ("Services.php");

 break; // end Services
 ##########################################################
 case 'ServicesPrices':

 include ("ServicesPrices.php");

 break; // end ServicesPrices
 ##########################################################
 case 'ServicesSLA':

 include ("ServicesSLA.php");

 break; // end ServicesSLA
 ##########################################################
 case 'ServiceSLARequests':

 include ("ServiceSLARequests.php");

 break; // end ServicesSLA
 ##########################################################
 case 'Effects':
 case 'SideEffects':

 include ("Effects.php");

 break; // end SideEffects
 ##########################################################
 case 'SLA':

 include ("SLA.php");

 break; // end SLA
 ##########################################################
 case 'SocialNetworking':

  include ("SocialNetworking.php");

 break;
 ##########################################################
 case 'SourceObjects':

  include ("SourceObjects.php");

 break;
 ##########################################################
 case 'SOW':

  include ("SOW.php");

 break;
 ##########################################################
 case 'SOWItems':

  include ("SOWItems.php");

 break;
 ##########################################################
 case 'Sprints':

  include ("Sprints.php");

 break;
 ##########################################################
 case 'TasksServiceSLARequests':

  include ("TasksServiceSLARequests.php");

 break;
 ##########################################################
 case 'Ticketing':

  include ("Ticketing.php");

 break;
 ##########################################################
 case 'TicketingActivities':

  include ("TicketingActivities.php");

 break;
 ##########################################################
 case 'TermsOfUse':

  switch ($action){
   
   case 'view':
   
    echo $strings["Content_TermsOfUse"];

   break;

  } // end actions

 break; // end TermsOfUse
 ##########################################################
 case 'Top': 

  include ("Top.php");

 break;
 ##########################################################
 case 'Voip':

  include ("Voip.php");

 break;
 ##########################################################
 case 'Votes':

  include ("Votes.php");

 break;
 ##########################################################
 case 'Wellbeing':

  include ("Wellbeing.php");

 break;
 ##########################################################
 case 'Wikipedia':

  include ("Wikipedia.php");

 break;
 ##########################################################
 case 'Workflows':

  include ("Workflows.php");

 break;
 ##########################################################

 } // end do switch

} // end funtion
#
###########################
} // end funkydo class

?>