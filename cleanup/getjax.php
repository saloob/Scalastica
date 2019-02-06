<?php
####################################################################
# Real Poltika
# To receive live content and map it to locations
# Saloob, Inc. All rights reserved 2007+
# Author: Matthew Edmond
# Date: 2009-08-20
# URL: http://www.saloob.com
# Email: sales@saloob.com
####################################################################
# 

if (!$_SESSION){
    session_start();
}

date_default_timezone_set('Asia/Tokyo');

if (!function_exists('get_param')){
   require_once ("common.php");
   }

include ("global/global.php");
include ("css/style.php");

if (!function_exists('set_lingo')){
   include ("global/lingo.inc.php");
   include (set_lingo());
   }

if (!class_exists('funky')){
   include ("funky.php");
   }

$funky_gear = new funky ();

if (!function_exists('api_sugar')){
   include ("api-sugarcrm.php");
   }

if (!class_exists('gallery')){
   include ("api-gallery.php");
   }

//include_once "fbmain.php";

$saloob_service_leadsources_id_c = $portal_config['portalconfig']['saloob_service_leadsources_id_c'];
    
$config['baseurl'] = $portal_config['portalconfig']['baseurl'];
$my_app_url = $config['baseurl'];
 
// Facebook 
$facebook_service_leadsources_id_c = $portal_config['facebook']['facebook_service_leadsources_id_c'];
$facebook_app_url = $portal_config['facebook']['facebook_app_url'];
$fbappid = $fbconfig['appid'];

$funky_gallery = new gallery ();

#global $val,$lingo,$strings,$portal_config;

$header_color = $portal_config['portalconfig']['portal_header_color'];
$body_color = $portal_config['portalconfig']['portal_body_color'];

$pagesdivs = $funky_gear->makedivs ();
$BodyDIV = $pagesdivs['body_div'];
$NavDIV = $pagesdivs['nav_div'];

$tdlabelwidth = 85;
$tdvaluewidth = 350;

$divlbl_front = "<div style=\"margin-left:0px;float:left;background:".$header_color."; width:".$tdlabelwidth."px;height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;overflow:no\">";
$divval_front = "<div style=\"margin-left:5px;float:left;background:".$body_color."; width:".$tdvaluewidth."px;height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 5px 5px 5px 5px;overflow:yes\">";

#
#####################
# Start HTML

#
#####################
#

foreach ($_GET as $key=>$value){
 
#echo "Field: ".$key." - Value: ".$value."<BR>";
 
} // end for post each 

#
#####################
# PHP SOAP SESSION

function GetSugarSessionId($myUsername,$myPassword,$myURL){

if (!function_exists('nusoap_client')){
   require_once ("nusoap/nusoap.php");
   }

    $soapclient = new nusoap_client($myURL); // create a PHP SOAP object that uses SUGAR WSDL definitions in remote soap.php file
    
    // setup parameters to send to function through the SOAP object
    $auth_array = array('user_auth' => array ('user_name' => $api_user, 'password' => md5($api_pass), 'version' => '0.1'));

    $application = "RealPolitika.org";

    $login_results = $soapclient->call('login',$auth_array,$application);
    $session_id = $login_results['id'];

    return $session_id;

    echo "<P>SESSION: $session_id <P>";

}  

#
#####################
#

$sess_contact_id = $_SESSION['contact_id'];

$do = $_GET['do'];
$next_action = $_GET['next_action'];
if ($next_action == NULL){
   $next_action = "add";
   }

$valtype = $_GET['valuetype'];
$val = $_GET['value'];
$action = $_GET['action'];

#
#####################
# Start Switch

switch ($do){

 #####################
 # DO Actions
 case 'Actions':


 break; // end Actions do
 #####################
 case 'BBAN':

  #####################
  # Actions

  switch ($action){

   case 'create_party':

    $returner = "<a href=\"#\" onClick=\"loader('BBAN');getjax('getjax.php?do=BBAN&page=top&action=create_party&id=return&valuetype$valtype&value=$val','BBAN');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # valtype

    switch ($valtype){

     #####################
     # Start Returner

     case 'return': // re-do

      $form_item = "<a href=\"#\" onClick=\"loader('BBAN');getjax('getjax.php?do=BBAN&page=top&action=create_party&valuetype=Countries&value=$val','BBAN');return false\"><img src=images/BodyBanner-CreatePoliticalParty-400x200.png border=0></a>";

     break;

     #####################
     # Start Countries

     case 'Countries':

      $form_item = $returner."<P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Countries&action=list&value=&valuetype=');return false\"><img src=images/BodyBanner-CreatePoliticalPartyByCountry-400x200.png border=0></a>";

     # End Countries
     #####################

     break;

    } // end valtype switch

   # End create_party
   #####################

   break;

   #####################
   #

  } // end Actions switch;

  # End Actions
  #####################

 break; // end BBAN do
 #####################
 case 'ConfigurationItems':
 case 'ConfigurationItemTypes':
 case 'AccountRelationships':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sclm_configurationitemtypes':
   case 'sclm_configurationitems':

    $id = $_GET['id'];
    $ci_type_id = $_GET['ci_type_id'];
    $ci_data_type = $_GET['ci_data_type'];
    $ci_name_field = $_GET['ci_name_field'];
    $ci_name = $_GET['ci_name'];

    if ($id != NULL && $ci_data_type == NULL){
       // New selection - not chosen yet - must decide if text box or dropdown, etc.
       $ci_data_type = dlookup("sclm_configurationitemtypes", "ci_data_type", "id='".$id."'");
       }

    $hidden_object = "<input type=\"hidden\" id=\"sclm_configurationitemtypes_id_c\" name=\"sclm_configurationitemtypes_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=ConfigurationItemTypes&action=$action&tbl=sclm_configurationitemtypes&id=return&valuetype=$valtype&value=$val&ci_data_type=$ci_data_type&ci_name=$ci_name&ci_name_field=$ci_name_field&ci_type_id=$ci_type_id','sclm_configurationitemtypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "sclm_configurationitemtypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      if ($ci_type_id){
         $thisvalue[4] = " id = '".$ci_type_id."' ";
         } else {
         $thisvalue[4] = "";
         }
      $thisvalue[5] = $sclm_configurationitemtypes_id_c;
      $thisvalue[9] = $val;
      $params['ci_data_type'] = $ci_data_type;
      $params['ci_name_field'] = $ci_name_field;
      $params['ci_name'] = $ci_name;
      $thisvalue[10] = $params; // Various Params

      $field_id = $sclm_configurationitemtypes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ConfigurationItemTypes']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;

     # End Returner
     #####################
     # Start Other Types

     case ($id != 'return'):

      switch ($ci_data_type){

       case '': //dropdown
       case '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca': //dropdown

        $fieldname = $ci_name_field;
        $textareacols = "";
        $textboxsize = "";
        $length = "";
        $formobjectheight = "50px";

        $thisvalue[0] = "db";
        $thisvalue[1] = "sclm_configurationitems";
        $thisvalue[2] = "id";
        $thisvalue[3] = "name";
        $thisvalue[4] = " sclm_configurationitemtypes_id_c='".$id."' ";
        $thisvalue[5] = $ci_name;
        $thisvalue[9] = $ci_name;
        $field_id = $ci_name;

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
        $form_item = $divlbl_front.$strings['ConfigurationItems']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'a46886c9-a870-ba85-c747-51c2f6be922f': //textbox

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case '2f5dc8c1-9898-5ffd-1b4c-51c2f631b449': //textarea

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'textarea',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'dbdecd86-53f2-e852-e02c-51d04ea175bb': //data set

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Data Set Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case '45b5e951-e65b-9ef4-075e-51fdc2f00ace': //checkbox

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'checkbox',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'de5db7f0-b87f-3dfd-637f-51fdc240f5fe': //yesno

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;

      } // end data type

     # End other types
     #####################

    } // end id switch

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ConfigurationItemTypes
 #####################
 case 'ConfigurationItemSets':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sclm_configurationitemsets':
   case 'sclm_configurationitemtypes':
   case 'sclm_configurationitems':

    $id = $_GET['id'];
    $ci_type_id = $_GET['ci_type_id'];
    $ci_data_type = $_GET['ci_data_type'];
    $ci_name_field = $_GET['ci_name_field'];
    $ci_name = $_GET['ci_name'];

    if ($id != NULL && $ci_data_type == NULL){
       // New selection - not chosen yet - must decide if text box or dropdown, etc.
       $ci_data_type = dlookup("sclm_configurationitemtypes", "ci_data_type", "id='".$id."'");
       }

    $hidden_object = "<input type=\"hidden\" id=\"sclm_configurationitemtypes_id_c\" name=\"sclm_configurationitemtypes_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=ConfigurationItemSets&action=$action&tbl=sclm_configurationitemtypes&id=return&valuetype=$valtype&value=$val&ci_data_type=$ci_data_type&ci_name=$ci_name&ci_name_field=$ci_name_field&ci_type_id=$ci_type_id','sclm_configurationitemtypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "sclm_configurationitemtypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      if ($ci_type_id){
         $thisvalue[4] = " sclm_configurationitemtypes_id_c = '".$ci_type_id."' ";
         } else {
         $thisvalue[4] = " sclm_configurationitemtypes_id_c = 'a172e63a-8d26-ab84-2aee-526fbe56f621'"; // Configuration Item Sets
         }
      $thisvalue[5] = $sclm_configurationitemtypes_id_c;
      $thisvalue[9] = $val;
      $params['ci_data_type'] = $ci_data_type;
      $params['ci_name_field'] = $ci_name_field;
      $params['ci_name'] = $ci_name;
      $thisvalue[10] = $params; // Various Params

      $field_id = $sclm_configurationitemtypes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ConfigurationItemTypes']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;

     # End Returner
     #####################
     # Start Other Types

     case ($id != 'return'):

      switch ($ci_data_type){

       case 'b6aefc07-66ca-d68e-b4c5-527323a836ec': // Credentials

        $ci_data_type_returner = $funky_gear->object_returner ('ConfigurationItemTypes', $ci_data_type);
        $ci_data_type_name = $ci_data_type_returner[0];

        $form_item = $divlbl_front.$ci_data_type_name."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'a33b0e31-b982-2957-9ffe-5255d9fcdd97': // Portal Items

        $ci_data_type_returner = $funky_gear->object_returner ('ConfigurationItemTypes', $ci_data_type);
        $ci_data_type_name = $ci_data_type_returner[0];

        $form_item = $divlbl_front.$ci_data_type_name."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'a39735f4-b558-5214-1d07-52593e7f39da': // Service Assets

        $ci_data_type_returner = $funky_gear->object_returner ('ConfigurationItemTypes', $ci_data_type);
        $ci_data_type_name = $ci_data_type_returner[0];

        $fieldname = "sclm_configurationitemtypes_id_c";
        $textareacols = "";
        $textboxsize = "";
        $length = "";
        $formobjectheight = "50px";

        $thisvalue[0] = "db";
        $thisvalue[1] = "sclm_configurationitemtypes";
        $thisvalue[2] = "id";
        $thisvalue[3] = "name";

        if ($ci_type_id){
           $thisvalue[4] = " sclm_configurationitemtypes_id_c = '".$ci_type_id."' ";
           } else {
           $thisvalue[4] = " sclm_configurationitemtypes_id_c = '45f10141-c75f-8871-c8a0-51c6e9b687e7'";
           }

        $thisvalue[5] = $sclm_configurationitemtypes_id_c;
        $thisvalue[9] = $val;
        $params['ci_data_type'] = $ci_data_type;
        $params['ci_name_field'] = $ci_name_field;
        $params['ci_name'] = $ci_name;
        $thisvalue[10] = $params; // Various Params

        $field_id = $sclm_configurationitemtypes_id_c;

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
        $form_item = $divlbl_front.$ci_data_type_name."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;

       case '': //dropdown
       case '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca': //dropdown

        $fieldname = $ci_name_field;
        $textareacols = "";
        $textboxsize = "";
        $length = "";
        $formobjectheight = "50px";

        $thisvalue[0] = "db";
        $thisvalue[1] = "sclm_configurationitems";
        $thisvalue[2] = "id";
        $thisvalue[3] = "name";
        $thisvalue[4] = " sclm_configurationitemtypes_id_c='".$id."' ";
        $thisvalue[5] = $ci_name;
        $thisvalue[9] = $ci_name;
        $field_id = $ci_name;

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
        $form_item = $divlbl_front.$strings['ConfigurationItems']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'a46886c9-a870-ba85-c747-51c2f6be922f': //textbox

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case '2f5dc8c1-9898-5ffd-1b4c-51c2f631b449': //textarea

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'textarea',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'dbdecd86-53f2-e852-e02c-51d04ea175bb': //data set

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Data Set Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case '45b5e951-e65b-9ef4-075e-51fdc2f00ace': //checkbox

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'checkbox',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'de5db7f0-b87f-3dfd-637f-51fdc240f5fe': //yesno

        $fieldname = $ci_name_field;
        $textboxsize = 50;
        $textareacols = 50;
        $length = "";
        $formobjectheight = "50px";

        $thisvalue = $ci_name;
        $field_id = "";

        $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

        $form_item = $divlbl_front."Name</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;

      } // end data type

     # End other types
     #####################

    } // end id switch

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ConfigurationItemSets
 #####################
 case 'Contacts':

  // This is not used at all - dummy content for later use that needs changing completely..

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'cmv_mediatypes':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"cmv_mediatypes_id_c\" name=\"cmv_mediatypes_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Content&action=$action&tbl=cmv_mediatypes&id=return&valuetype=$valtype&value=$val','cmv_mediatypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "cmv_mediatypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmv_mediatypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $cmv_mediatypes_id_c;
      $thisvalue[9] = $val;
      $field_id = $cmv_mediatypes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['MediaTypes']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;

     # End Returner
     #####################
     # Link

     case '552529a3-0ebd-286d-b1bc-4e0a0a5fdf8a': // Link

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Link</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Social Networks
     #####################

    } // end id switch for message_recipients

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end Contacts
 #####################
 case 'Login':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'hostname':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"hostname\" name=\"hostname\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','hostname');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "portal_hostname";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $hostnameoptionpack['sub'] = "Create a scalastica.com sub-domain";
      $hostnameoptionpack['own'] = "Use your own, existing domain";
      $hostnameoptionpack['reg'] = "Register a new domain";

      $thisvalue[1] = $hostnameoptionpack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "hostname";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front."<font color=white>Portal Hostname Options</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break; // return
     case 'sub': // Create a scalastica.com sub-domain

      $fieldname = "portal_hostname";
      $textboxsize = 40;
      $textareacols = 40;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

/*
      $form_object = "
<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css\">
<script src=\"//code.jquery.com/jquery-1.10.2.js\"></script>
<script src=\"//code.jquery.com/ui/1.10.4/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\">
<script>
$(function() {
var availableTags = [
\"ActionScript\",
\"AppleScript\",
\"Scheme\"
];
$( \"#tags\" ).autocomplete({
source: availableTags
});
});
</script><div class=\"ui-widget\">
<label for=\"tags\">Tags: </label>
<input id=\"tags\">
</div>";

<script>
$(function() { show_alert(); function show_alert() { alert(\"Inside the jQuery ready\"); } });
</script>

*/

      $form_item = $divlbl_front."<font color=white>Check to see if available</font></div>
        ".$divval_front."
         $form_object.scalastica.com $hidden_object $returner
        </div>";   

     break; // Create a scalastica.com sub-domain
     case 'own': // Use your own, existing domain

      $fieldname = "portal_hostname";
      $textboxsize = 40;
      $textareacols = 40;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = "1) Input your existing domain in the textbox below<BR>2) Set your domain's DNS with an A-Record pointing at Scalastica (IP:119.27.35.191).<P>";

      $form_object .= $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
      $form_item = $divlbl_front."<font color=white>Use your own, existing domain</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break; // Use your own, existing domain
     case 'reg': // Register a new domain

      $fieldname = "portal_hostname";
      $textboxsize = 40;
      $textareacols = 40;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = "<a href=https://www.godaddy.com/?isc=cjc1off30&utm_campaign=affiliates_cj_new30&utm_source=Commission%20Junction&utm_medium=External%2BAffil&utm_content=cjc1off30 target=GODADDY>1) Click here to register your new domain at GoDaddy<BR>2) Return back here and input your new domain in the textbox below<BR>3) Set your domain's DNS with an A-Record pointing at Scalastica (IP:119.27.35.191).<P><img src=https://img1.wsimg.com/pc/img/1/country/en-us/GD_logo_NYE.jpg border=0></a><P>";

      $form_object .= $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."<font color=white>Register a new domain</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // Register a new domain

    } // id switch

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end Hostnames
 #####################
 case 'Messages':

  $tbl = $_GET['tbl'];

  #####################
  # Effects Tables

  switch ($tbl){

   case 'message_recipient_types':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"message_recipients\" name=\"message_recipients\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"loader('".$tbl."');getjax('getjax.php?do=".$do."&action=$action&tbl=message_recipient_types&id=return&valuetype=$valtype&value=$val','message_recipient_types');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do
     case 'NULL': // re-do

      $fieldname = "message_recipients";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $dd_pack = "";
      $dd_pack = array();
      $dd_pack['email'] = "Email";

      // Check if logged in with Facebook
      if ($fbme) {
         $dd_pack['facebook'] = "Facebook ".$strings["action_post"];
//         $dd_pack['facebook_friend'] = "Facebook ".$strings["Friend"];
         $dd_pack['facebook_friends'] = $strings["Multiple"]." "."Facebook ".$strings["Friends"];
         } else {
         $dd_pack['null'] = "You are not logged into Facebook";
         }

      $dd_pack['portal_friends'] = $portal_title." Friends";

      // Check if has any Social Networks
      $object_type = "SocialNetworkMembers";
      $action = "select";
      $params = array();
      $params[0] = "";
      $params[1] = "";
      $params[2] = "";
      $params[3] = "";

      $params[0] = "deleted=0 && contact_id_c='".$sess_contact_id."' ";
      $MySocialNetworks = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

      if (is_array($MySocialNetworks)>0){
         $dd_pack['portal_social_network_members'] = $portal_title." Social Network Members";
         } else {
         $dd_pack['null'] = "You are not a member of any ".$portal_title." Social Networks";
         } 

      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "message_recipients";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $message_recipients;
      $thisvalue[6] = 'Messages';
      $thisvalue[7] = 'message_recipient_types';
      $thisvalue[9] = $val;
      $field_id = $message_recipients;

      $strings['Recipients'] = "Recipients";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Recipients']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break;
     # End Returner
     #####################
     # Email
     case 'email': // Email

      $fieldname = "recipient_email";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Email</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Email
     #####################
     # Facebook
     case 'facebook': // Facebook

      $fieldname = "facebook";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "1";
      $field_id = $thisvalue;

      $fbapikey = $fbconfig['api'];
      $app_secret = $fbconfig['secret'];
      $app_id = $fbconfig['appid'];

//echo "fbapikey $fbapikey + app_id $app_id + app_secret $app_secret<P>";

     $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
     $form_object .= "<font size=2><B>".$strings["Facebook_MessagePost"]."</B></font>";

      $form_item = $divlbl_front."Facebook</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Facebook
     #####################
     # Facebook Friend
     case 'facebook_friend': // Facebook

      $fieldname = "facebook_friend_id";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $app_id = $fbconfig['appid'];
      $app_secret = $fbconfig['secret'];
      $my_app_url = $config['baseurl'];
      $fbapikey = $fbconfig['api'];

      $fbuserid = $fbme[id];

      $fbfriendquery = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.')'; 

      $_friends = $facebook->api(array(
'method' => 'fql.query',
'query' =>$fbfriendquery,
));


      $friends = array();  


      if (is_array($_friends) && count($_friends)) {  

         foreach ($_friends as $friend) {  

                 $uid = $friend['uid'];

                 $newfbfriendquery = "SELECT uid,name FROM user WHERE uid='".$uid."'"; 
                 $_friendsdata = $facebook->api(array(
                  'method' => 'fql.query',
                  'query' =>$newfbfriendquery,
                  ));

                 if (is_array($_friendsdata) && count($_friendsdata)) {  

                    foreach ($_friendsdata as $friendsdata) {  

                            $fuid = $friendsdata['uid'];
                            $dd_pack[$fuid] = $friendsdata['name'];

                            } // foreach

                    } // if is array

                 } // foreach

         } // is array uid

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "facebook_friend_id";
      $thisvalue[3] = "Facebook ".$strings["Friend"];
      $thisvalue[4] = "";
      $thisvalue[5] = $thisvalue;
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Facebook ".$strings["Friend"]."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Facebook Friend
     #####################
     # Facebook Friend
     case 'facebook_friends': // Facebook

      $fieldname = "facebook_friends";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "1";
      $field_id = $thisvalue;

//      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
//      $form_object .= "<font size=2><B>".$strings["Facebook_MessagePostPrivate"]."</B></font>";

      $app_id = $fbconfig['appid'];
      $app_secret = $fbconfig['secret'];
      $my_app_url = $config['baseurl'];
      $fbapikey = $fbconfig['api'];

      $fbuserid = $fbme[id];

      $fbfriendquery = 'SELECT uid,username,name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$fbuserid.')'; 

      $_friends = $facebook->api(array(
       'method' => 'fql.query',
       'query' =>$fbfriendquery,
       ));

      $friends = array();  

      if (is_array($_friends) && count($_friends)) {  

         $check = "";
         $checkmate = "";

         foreach ($_friends as $friend) {  

//                 $fuid = $friend['uid'];

//echo "FBUID: $fuid <BR>";

/*
                 $newfbfriendquery = "SELECT uid,name FROM user WHERE uid='".$uid."'"; 
                 $_friendsdata = $facebook->api(array(
                  'method' => 'fql.query',
                  'query' =>$newfbfriendquery,
                  ));

                 if (is_array($_friendsdata) && count($_friendsdata)) {  

                    foreach ($_friendsdata as $friendsdata) {  

                            $fuid = $friendsdata['uid'];

                            $check = "";
                            $check = "<input type=\"checkbox\" name=\"fbfriends_".$fuid."\" id=\"fbfriends_".$fuid."\" value=\"".$fuid."\">".$friendsdata['name'];
                            $checkmate .= "<tr><td width=150px height=15>".$check."</td></tr>";

                            } // for each

                    } // if is array
*/

                $check_fbuid = "";
                $check_fbusername = "";
                $check_fbname = "";
                $check_fbuid = "<input type=\"checkbox\" name=\"".$friend['uid']."\" id=\"".$friend['uid']."\" value=\"fbuid\">".$friend['name'];
//                $check_fbusername = "<input type=\"hidden\" name=\"".$friend['username']."\" id=\"".$friend['username']."\" value=\"fbusername\">";
//                $check_fbname = "<input type=\"hidden\" name=\"".$friend['name']."\" id=\"".$friend['name']."\" value=\"fbname\">";
                $checkmate .= "<tr><td width=250px height=15>".$check_fbuid.$check_fbusername.$check_fbname."</td></tr>";

                } // for uid

            } // is array uid

      $form_object = "<div style=\"margin-left:0px;float:left; background: white;min-width:95%;height:300px;border:1px dotted #555;border-radius: 3px; padding: 5px 5px 5px 5px;overflow:auto;\"><table>". $checkmate."</table></div>";

      $form_item = $divlbl_front."Facebook ".$strings["Friends"]."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Facebook Friends
     #####################
     # Portal Friends
     case 'portal_friends': // Portal Friends

      $fieldname = "message_recipients";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

     //$form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
     $form_object = "<font size=2 color=white><B>A message will be posted to all your ".$portal_title." Friends</B></font>";

      $form_item = $divlbl_front."Friends</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Portal Friends
     #####################
     # Portal Social Network Members
     case 'portal_social_network_members': // Portal Social Network Members

      $object_type = "SocialNetworkMembers";
      $action = "select";
      $params = array();
      $params[0] = " deleted=0 && contact_id_c='".$sess_contact_id."' ";
      $params[1] = " date_entered DESC ";
//      $params[2] = " social_network_type ";
      $params[2] = "";
      $params[3] = "id,name,social_network_type,social_network_type_id";
      $params[4] = "";

      $MySocialNetworks = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);
    
      if (is_array($MySocialNetworks)){
    
         for ($cnt=0;$cnt < count($MySocialNetworks);$cnt++){
     
             $id = $MySocialNetworks[$cnt]['id'];
             $name = $MySocialNetworks[$cnt]['name'];
             $social_network_type = $MySocialNetworks[$cnt]['social_network_type'];
             $social_network_type_id = $MySocialNetworks[$cnt]['social_network_type_id'];
             $social_network_returner = $funky_gear->object_returner ($social_network_type, $social_network_type_id);
             $social_network_name = $social_network_returner[0];
//             $social_network_name = $name;

//echo $name." ID: ".$id."<BR>";
//echo $social_network_name." ID: ".$id."<BR>";

             $social_network_name = $social_network_type.": ".$social_network_name;

//echo "Type $social_network_type <BR>";

             $social_network_link = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=SocialNetworks&action=view&value=".$id."&valuetype=SocialNetworks');return false\"><font color=#FBB117><B>".$social_network_name."</B></font></a>";

             switch ($social_network_type){

              case 'Causes':

               $dd_pack[$id] = $social_network_name;
//             $causes_networks .= $social_network_link."<BR>";

              break;
              case 'Contacts':

//               $contact_name_returner = $funky_gear->object_returner ('Contacts', $social_network_type_id);
//               $social_network_name = $contact_name_returner[0];
/*
               $social_network_name_type = $MySocialNetworks[$cnt]['social_network_name_type'];
               $first_name = $MySocialNetworks[$cnt]['first_name'];
               $last_name = $MySocialNetworks[$cnt]['last_name'];
               $nickname = $MySocialNetworks[$cnt]['nickname'];
               $cloakname = $MySocialNetworks[$cnt]['cloakname'];

               switch ($social_network_name_type){

                case '':
                case 'bcee7073-c7c1-3fda-08ae-4e0e75ffa4dd':
                 $social_network_name = $strings["Anonymous"];
                break;
                case '7805a076-80e7-8b7c-2b5f-4e0e757c1d1d': // Full Name
                 $social_network_name = $first_name." ".$last_name;
                break;
                case '178af3ac-57f1-63d9-60b0-4e0e7534ec7b': // Nickname
                 $social_network_name = $nickname;
                break;
                case '8aa7e22a-4769-caba-7711-4e0e7510ddc8': // Cloakname
                 $social_network_name = $cloakname;
                break;

               } // end contacts naming
*/

//             $social_network_link = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=SocialNetworks&action=view&value=".$social_network_type_id."&valuetype=".$social_network_type."');return false\"><font color=#FBB117><B>".$social_network_name."</B></font></a>";

//             $contacts_networks .= $social_network_link."<BR>";
               $dd_pack[$id] = $social_network_name;

//echo $social_network_name." ID: ".$id."<BR>";

              break; // end Contacts
              case 'Governments':

//             $gov_networks .= $social_network_link."<BR>";
               $dd_pack[$id] = $social_network_name;

              break;
              case 'GovernmentTypes':

//             $govtype_networks .= $social_network_link."<BR>";
               $dd_pack[$id] = $social_network_name;

              break;
              case 'PoliticalParties':

//             $party_networks .= $social_network_link."<BR>";
               $dd_pack[$id] = $social_network_name;

              break;
              case 'Countries':

//             $country_networks .= $social_network_link."<BR>";
               $dd_pack[$id] = $social_network_name;

              break;
              case 'BranchBodyDepartmentAgencies':

//             $agency_networks .= $social_network_link."<BR>";
               $dd_pack[$id] = $social_network_name;

              break;

             } // end switch

             } // end for
/*
       if ($causes_networks != NULL){
          $social_networks .= "<B>".$strings["Causes"].":</B><BR>".$causes_networks."<P>";
          }

       if ($contacts_networks != NULL){
          $social_networks .= "<B>".$strings["Member"].":</B><BR>".$contacts_networks."<P>";
          }

       if ($gov_networks != NULL){
          $social_networks .= "<B>".$strings["Governments"].":</B><BR>".$gov_networks."<P>";
          }

       if ($govtype_networks != NULL){
          $social_networks .= "<B>".$strings["GovernmentTypes"].":</B><BR>".$govtype_networks."<P>";
          }

       if ($party_networks != NULL){
          $social_networks .= "<B>".$strings["PoliticalParties"].":</B><BR>".$party_networks."<P>";
          }

       if ($country_networks != NULL){
          $social_networks .= "<B>".$strings["Countries"].":</B><BR>".$country_networks."<P>";
          }

       if ($agency_networks != NULL){
          $social_networks .= "<B>".$strings["Agencies"].":</B><BR>".$agency_networks."<P>";
          }
 
       echo $social_networks;
*/

         } // end if array

      $fieldname = "social_network";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "90px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "social_networks";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $thisvalue;
      $thisvalue[6] = "SocialNetworks"; // Object
      $thisvalue[7] = "social_networks"; // Object

//var_dump ($dd_pack);

      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_object_text = "<font size=2 color=white><B>A message will be posted to all your ".$portal_title." Social Network Members - please select your Social Network...</B></font><BR>";

      $form_item = $divlbl_front."Social Network</div>
        ".$divval_front."
         $form_object_text $form_object $hidden_object $returner
        </div>";

     break;
     # End Social Networks
     #####################

    } // end id switch for message_recipients

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for message_recipients
  #####################

 break; // end Messages do
 #####################
 case 'Content':

  $tbl = $_GET['tbl'];
  $id = $_GET['id'];

  #echo "<P>TBL $tbl and ID: $id<P>";

  $currentval = $_GET['currval'];
  if ($currentval == NULL){
     $currentval = $_POST['currval'];
     }

  #####################
  # Effects Tables

  switch ($tbl){

   case 'sclm_configurationitemtypes':

    #$id = $_GET['id'];
    $mediatypes = $id;

    $hidden_object = "<input type=\"hidden\" id=\"sclm_configurationitemtypes\" name=\"sclm_configurationitemtypes\" value=\"$id\"><input type=\"hidden\" id=\"currval\" name=\"currval\" value=\"$currentval\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Content&action=$action&tbl=sclm_configurationitemtypes&id=return&valuetype=$valtype&value=$val&currval=$currentval','sclm_configurationitemtypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "attachments";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " sclm_configurationitemtypes_id_c='e5744b5d-b34d-ebf3-3c79-54c05f9300d5' ";
      $thisvalue[5] = $currentval;
      $thisvalue[9] = $currentval;
      $field_id = $currentval;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."<font color=white>".$strings['MediaTypes']."</font></div>
        ".$divval_front."
          $hidden_object $form_object
        </div>";   

     break;

     # End Returner
     #####################
     # Link

     case '552529a3-0ebd-286d-b1bc-4e0a0a5fdf8a': // Link

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Link</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End Link
     #####################
     # RSS

     case '9a69a58c-e552-87a2-fc56-4e09e918ac4e': // RSS

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."RSS</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End RSS
     #####################
     # Related Content

     case '19417a52-926b-f211-b09e-518df04bd46f': // Related Content

      $fieldname = "sfx_actions_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_effects";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
//      $query_two = " && ".$query_two."sfx_effects_id_c IS NULL ";
      $order = " order by sfx_effects.date_modified DESC";
//      $thisvalue[4] = "sfx_effects.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[4] = "sfx_effects.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$order; // Exceptions
      $thisvalue[5] = $sfx_effects_id_c;
      $field_id = $sfx_effects_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Effect']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End Related Content
     #####################
     # YouTube

     case 'd66f04ca-fa89-891b-7f75-4e09e9f94e44': // YouTube

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."You Tube</div>
        ".$divval_front."
         $form_object <BR>Just add the video ID. Ex: <B>Ee0no3SuWhs</B> from the URL like below:<BR>http://www.youtube.com/watch?v=<B>Ee0no3SuWhs</B><BR>$hidden_object $returner
        </div>";

     break;

     # End YouTube
     #####################
     # TED

     case '23132202-44c0-2516-952e-51966fde1497': // TED

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."TED Videos</div>
        ".$divval_front."
         $form_object <BR>Just add the video link (Ex: <B>http://embed.ted.com/talks/sergey_brin_and_larry_page_on_google.html</B>) from the embedd text.<BR>$hidden_object $returner
        </div>";

     break;

     # End TED
     #####################
     # www.thedailyshow.com

     case '4f0d4556-68ed-a88b-dad6-4ec501d69ce1': // www.thedailyshow.com

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."The Daily Show</div>
        ".$divval_front."
         $form_object <BR>Just add the video URL from the embedd source like below:<BR>embed src=\"<B>http://media.mtvnservices.com/mgid:cms:video:thedailyshow.com:402366</B>\"<BR>$hidden_object $returner
        </div>";

     break;

     # End www.thedailyshow.com
     #####################
     # iFrame

     case 'd125f2f9-38c7-6ddc-26a7-4efcd350d037': // iFrame

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."iFrame</div>
        ".$divval_front."
         $form_object <BR>$hidden_object $returner
        </div>";

     break;

     # End iFrame
     #####################
     # Guardian Videos

     case '454b0f3e-f406-d3ba-3039-4f09a7cefecd': // Guardian Videos

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Guardian Videos</div>
        ".$divval_front."
         $form_object <BR>Just add the video URL from the embedd source like below:<BR>embed src=\"<B>http://www.guardian.co.uk/world/video/2011/dec/19/north-korea-kim-jong-il-dies-video/json</B>\"<BR>$hidden_object $returner
        </div>";

     break;

     # End Guardian Videos
     #####################
     # CNN Videos

     case 'e8ec8824-cd43-a71d-959d-5149ec5e67ba': // CNN Videos

      $fieldname = "media_source";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."CNN Videos</div>
        ".$divval_front."
         $form_object <BR>Just add the video URL from the embedd source like below:<BR>embed src=\"<B>crime/2013/03/17/sotu-harlow-steubenville-rape-trial-verdict.cnn</B>\"<BR>$hidden_object $returner
        </div>";

     break;
     # End CNN Videos
     #####################
     # Image
     case 'edfa1627-fd3c-2ff3-288d-4e09e848d675': // Image

         $fieldname = "media_source";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner 
        </div>";

     break; // end Image

     # End Image
     #####################
     # Upload

     case 'cc505f5f-5a24-ddb6-a8b6-51844f51f0e0': // Upload

         $fieldname = "media_source_upload";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'upload',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner 
        </div>";

     break; // end Upload

     # End Upload
     #####################
     # Gallery Images

     case 'ba090113-6c25-244e-5f4c-4e09fbc5ae84': // Gallery Images

      // See if the User has a Gallery ID - usually only provided manually to Journalists 
      $gallery_object_type = 'contacts';
      $gallery_action = 'select_cstm';
    
      $gallery_params = array();
      $gallery_params[0] = "id_c='".$sess_contact_id."'";
      $gallery_params[1] =  "id_c,gallery_id_c";
       
      $the_gallery_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $gallery_object_type, $gallery_action, $gallery_params);
    
      if (is_array($the_gallery_list)){
      
         for ($cnt=0;$cnt < count($the_gallery_list);$cnt++){

             $gallery_id_c = $the_gallery_list[$cnt]['gallery_id_c'];

             } // end for

         } // end if array

      if ($gallery_id_c != NULL){

         $dd_pack = "";

         $gallery_object_type = "Items";
         $gallery_action = "select";

         $gallery_params = array();
         $gallery_params[0] = "WHERE owner_id=".$gallery_id_c." && type='photo' order by created DESC "; // GROUP BY parent_id 
         $za_list = $funky_gallery->api_gallery ($gallery_object_type, $gallery_action, $gallery_params);

         if (is_array($za_list)){

            $count = count($za_list);
//            $page = $_POST['page'];
            $page = $_GET['page'];
            $glb_perpage_items = 10;

            $gallery_params[0] = 'id'; // key
            $gallery_params[1] = 'ba090113-6c25-244e-5f4c-4e09fbc5ae84'; // value
            $gallery_params[2] = $action;

            $navi_returner = $funky_gear->navigator ($count,$do,$gallery_params,$val,$valtype,$page,$glb_perpage_items,'cmv_mediatypes');
            $lfrom = $navi_returner[0];
            $navi = $navi_returner[1];

            $form_item .= $navi;

            $gallery_object_type = "Items";
            $gallery_action = "select";

            $gallery_params = array();
            $gallery_params[0] = "WHERE owner_id=".$gallery_id_c." && type='photo' order by created DESC limit  $lfrom , $glb_perpage_items "; // GROUP BY parent_id 
            $za_list = $funky_gallery->api_gallery ($gallery_object_type, $gallery_action, $gallery_params);

            // Build a list of Parents albums to work out the URL      
            for ($dropcnt=0;$dropcnt < count($za_list);$dropcnt++){
 
                $za_id = $za_list[$dropcnt]["id"];
                $za_title = $za_list[$dropcnt]["title"];
                $za_image = $za_list[$dropcnt]["name"];
                $relative_path_cache = $za_list[$dropcnt]["relative_path_cache"];
                $updated = $za_list[$dropcnt]["updated"];

                //echo $relative_path_cache;

                $dd_values[0] = $za_title;
                $dd_values[1] = "http://www.realpolitika.org/gallery/var/thumbs/".$relative_path_cache."?m=".$updated;
                $dd_pack[$za_id] = $dd_values;

                } // end for

            $fieldname = "media_source";
            $textareacols = "";
            $textboxsize = "";
            $length = "";
            $formobjectheight = "200px";

            $thisvalue[0] = "list";
            $thisvalue[1] = $dd_pack;
            $thisvalue[2] = "media_source";
            $thisvalue[3] = $strings["GalleryImage"];
            $thisvalue[4] = "";
            $thisvalue[5] = $media_source;
            $thisvalue[9] = $val;

            $field_id = "";

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item .= $divlbl_front.$strings["GalleryImage"]."</div>
             ".$divval_front."
         $returner $form_object $hidden_object $returner
        </div>";

            $form_item .= $navi;

            } else {// no array! just let them use an image

            $fieldname = "media_source";
            $textboxsize = 50;
            $textareacols = 50;
            $length = "";
            $formobjectheight = "50px";

            $thisvalue = "";
            $field_id = $thisvalue;

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

            } // end if no gallery

         } else { // if no gallery ID

         $fieldname = "media_source";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item = $divlbl_front.$strings['Image']."</div>
          ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

         } // end if no gallery

     break;
     # End Gallery
     #####################
     # General Content
     # Media Types CIT: e5744b5d-b34d-ebf3-3c79-54c05f9300d5
     # General Content | ID: 48f00382-9b6f-5a09-bac6-54c0613701eb
     case '48f00382-9b6f-5a09-bac6-54c0613701eb': # General Content

      $dd_pack = "";

      # If a current value is sent
      list ($currvaltype, $currval) = explode ("_", $currentval);

      # Get a list of content to choose from
      # Then must select from the already-attached list from CIs as related attachments
      # Attachments CIT = 36727261-b9ce-9625-2063-54bf15bb668b

      # Prepare the list of existing attachments for this account - could end up being a lot...
      $attcitrel_object_type = "ConfigurationItems";
      $attcitrel_action = "select"; 
      $attcitrel_params[0] = " sclm_configurationitemtypes_id_c = '36727261-b9ce-9625-2063-54bf15bb668b' && account_id_c='".$portal_account_id."' ";
      $attcitrel_params[1] = "id,name"; // select array
      $attcitrel_params[2] = ""; // group;
      $attcitrel_params[3] = " name ASC "; // order;
      $attcitrel_params[4] = ""; // limit
      $attcitrel_params[5] = $lingoname; // lingo

      $attcitrel_result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $attcitrel_object_type, $attcitrel_action, $attcitrel_params);

      $query_ext = "";

      $keyword = $_GET['keyword'];
      if ($keyword == NULL){
         $keyword = $_POST['keyword'];
         }

      if ($keyword != NULL){
         $query_ext = " && (name like '%".$keyword."%' || description like '%".$keyword."%' || content_url like '%".$keyword."%' || content_thumbnail like '%".$keyword."%') ";
         } # end if search action

      $attach_object_type = "Content";
      $attach_action = "select";
#      $attach_params[0] = " ((account_id_c='".$portal_account_id."' && cmn_statuses_id_c != '".$standard_statuses_closed."') || account_id_c='".$sess_account_id."') && portal_content_type != '4afdc2bb-7359-d4d9-b3e5-52643fce9c30' && content_type != '69c2b932-2e0f-c22c-4313-523876b382ce' ";
#      $attach_params[0] = " account_id_c='".$portal_account_id."' && portal_content_type != '4afdc2bb-7359-d4d9-b3e5-52643fce9c30' && content_type != '69c2b932-2e0f-c22c-4313-523876b382ce' ";
      $attach_params[0] = " account_id_c='".$portal_account_id."'  ".$query_ext;
      $attach_params[1] = "id,name,content_thumbnail,content_url,account_id_c"; // select array
      $attach_params[2] = ""; // group;
      $attach_params[3] = " date_entered DESC, name ASC "; // order;
      $attach_params[4] = ""; // limit
      $attach_params[5] = $lingoname; // lingo
  
      $attach_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $attach_object_type, $attach_action, $attach_params);

      if (is_array($attach_items)){

         $count = count($attach_items);

         $page = $_GET['page'];
         if ($page == NULL){
            $page = $_POST['page'];
            }

         $glb_perpage_items = 10;

         $gallery_params[0] = 'id'; // key
         $gallery_params[1] = '48f00382-9b6f-5a09-bac6-54c0613701eb'; // value
         $gallery_params[2] = $action;

         $navi_returner = $funky_gear->navigator ($count,$do,$gallery_params,$val,$valtype,$page,$glb_perpage_items,'sclm_configurationitemtypes',$extra_nav_params);
         #$navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
         $lfrom = $navi_returner[0];
         $navi = $navi_returner[1];

/*
         $date = date("Y@m@d@G");
         $body_sendvars = $date."#getjaxphp";
         $body_sendvars = $funky_gear->encrypt($body_sendvars);


    ?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="sclm_configurationitemtypes" name="sclm_configurationitemtypes" value="<?php echo $id; ?>" >
     <input type="hidden" id="id" name="id" value="sclm_configurationitemtypes" >
     <input type="hidden" id="page" name="page" value="<?php echo $page; ?>" >
     <input type="hidden" id="tbl" name="tbl" value="sclm_configurationitemtypes" >
     <input type="hidden" id="action" name="action" value="<?php echo $action; ?>" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="hidden" id="currval" name="currval" value="<?php echo $currentval; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('sclm_configurationitemtypes');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
    <?php
*/
         $form_item .= $navi;

         $attach_params[4] = " $lfrom , $glb_perpage_items "; // limit

         $attach_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $attach_object_type, $attach_action, $attach_params);

         # Build a list of items to work out the URL      
         for ($dropcnt=0;$dropcnt < count($attach_items);$dropcnt++){
 
             $za_id = $attach_items[$dropcnt]["id"];
             $za_title = $attach_items[$dropcnt]["name"];
             $za_image = $attach_items[$dropcnt]["content_thumbnail"];

             if (is_array($attcitrel_result)){

                $dd_values[3] = ""; 

                # Build a list of items to work out the URL      
                for ($attrelci=0;$attrelci < count($attcitrel_result);$attrelci++){

                    $attrelci_id = $attcitrel_result[$attrelci]["id"];
                    $attrelci_name = $attcitrel_result[$attrelci]["name"];

                    list ($valtypepart, $valpart, $contentpart) = explode ("_", $attrelci_name);

                    if ($za_id == $contentpart && $currval == $valpart && $currvaltype == $valtypepart){
                       $dd_values[3] = "1";
                       $dd_values[4] = $valtypepart;
                       }

                    } # end for

                } # end is array

             if ($za_image != str_replace("uploads/","",$za_image)){
                # This is an uploads - do nothing, it will add the hostname currently viewed automatically
                #$contentpart = str_replace("uploads","",$content_url);
                } elseif ($za_image != str_replace("/content/","",$za_image)){
                list ($hostnamepart, $contentpart) = explode ("/content/", $za_image);
                $za_image = "content/".$contentpart;
                }

             $content_type_image = $attach_items[$dropcnt]['content_type_image'];

             if (!$za_image){
                if ($content_type_image != NULL){
                   $za_image = $content_type_image;
                   } else {
                   $za_image = "images/icons/page.gif";
                   }
                }

             $content_url = $attach_items[$dropcnt]["content_url"];

             if ($content_url != str_replace("uploads/","",$content_url)){
                # This is an uploads - do nothing, it will add the hostname currently viewed automatically
                #$contentpart = str_replace("uploads","",$content_url);
                } elseif ($content_url != str_replace("/content/","",$content_url)){
                list ($hostnamepart, $contentpart) = explode ("/content/", $content_url);
                $content_url = "content/".$contentpart;
                }

             $content_link = "Body@".$lingo."@Content@view@".$za_id."@Content";
             $content_link = $funky_gear->encrypt($content_link);
             $content_link_basic = "http://".$hostname."/?pc=".$content_link;
             $content_link_html = "";
             $content_link_html = " <a href=http://".$hostname."/?pc=".$content_link." target=Content>View in another window..</a>";

             if ($dd_values[3] == "1"){

                switch ($dd_values[4]){

                 case 'Ticketing':
                  $valtypetext = "Ticket";
                 break;
                 case 'TicketingActivities':
                  $valtypetext = "Activity";
                 break;
                 case 'Messaging':
                  $valtypetext = "Message";
                 break;

                } # end switch

                $dd_values[4] = "<font color=red>This Content has already been attached to this ".$valtypetext."</font>".$content_link_html;

                } else {# end if dd_values[3] == "1"

                $dd_values[4] = "<font color=blue>This Content has not yet been attached to this ".$valtypetext."</font>".$content_link_html;

                } 

             $dd_values[0] = $za_title;
             $dd_values[1] = $za_image;
             $dd_values[2] = $content_url;

             $dd_pack[$za_id] = $dd_values;

             } # end for

            $fieldname = "attachments";
            $textareacols = "";
            $textboxsize = "";
            $length = "";
            $formobjectheight = "200px";

            $thisvalue[0] = "list";
            $thisvalue[1] = $dd_pack;
            $thisvalue[2] = "attachments";
            $thisvalue[3] = "Attachment";
            $thisvalue[4] = "";
            $thisvalue[5] = $currentval;
            $thisvalue[9] = $currentval;

            $field_id = "";

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item .= $divlbl_front."<font color=white>Attachment</font></div>
             ".$divval_front."
         $returner $form_object $hidden_object $returner
        </div>";

            $form_item .= $navi;

         } # end is array

     break; # Content

    } // end id switch for cmv_mediatypes

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for Media Types
  #####################

 break; // end Content do
 #####################
 case 'Effects':

  $tbl = $_GET['tbl'];

  #####################
  # Effects Tables

  switch ($tbl){

   case 'sfx_valuetypes':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"sfx_valuetypes_id_c\" name=\"sfx_valuetypes_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=sfx_valuetypes&id=return&valuetype=$valtype&val=$val','sfx_valuetypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "sfx_valuetypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_valuetypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_valuetypes_id_c;
      $thisvalue[9] = $val;
      $field_id = $sfx_valuetypes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ValueTypes']."</div>
        ".$divval_front."
         $form_object
        </div>";   


     # End Returner
     #####################
     break;
     #####################
     # SI Base Units

     case '27b1b1ce-377a-115d-944f-515f884f5fa2': //

      $fieldname = "sfx_sibaseunits_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_sibaseunits";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_sibaseunits_id_c;
      $thisvalue[9] = $val;
      $field_id = $sfx_sibaseunits_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['SIBaseUnit']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   


     # End Returner
     #####################
     break;
     #####################
     # Emotions

     case '53056798-4871-55c4-a4f7-4df5658ba401': // Emotions

      $fieldname = "sfx_emotions_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_emotions";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_emotions_id_c;
      $field_id = $sfx_emotions_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Emotions']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Emotions
     #####################
     break; // end Emotions type
     #####################
     # Urgency

     case 'be58451d-6281-ea0c-db11-510d31d88f6e': // Urgency

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = $strings["Urgency"];
      $thisvalue[4] = "";
      $thisvalue[5] = $urgency;
      $field_id = $value_type_value;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Urgency']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Urgency
     #####################
     break; // end Urgency type
     #####################
     # Importance

     case 'bbf759bf-76c6-9508-affd-510d31381088': // Importance

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = $strings["Importance"];
      $thisvalue[4] = "";
      $thisvalue[5] = $importance;
      $field_id = $value_type_value;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Importance']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Importance
     #####################
     break; // end Importance type
     #####################
     # Start Quantity

     case '53d8df93-31bd-cd79-9b2f-4df560958c2c': // Quantity or Amount

      $fieldname = "value_type_value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $value_type_fieldname = "sfx_valuetypes_id_c";
      $value_type_thisvalue = $id;
      $value_type_field_id = $id;
      $hidden_value_type = $funky_gear->form_objects ($do,$next_action,$valtype,$value_type_fieldname,'hidden',$length,$textboxsize,$textareacols,$value_type_thisvalue,$value_type_field_id);


      $form_item = $divlbl_front.$strings['Quantity']."</div>
        ".$divval_front."
         $form_object $hidden_object $hidden_value_type $returner
        </div>";

     # End Quantity
     #####################
     break; // end Quantity type
     #####################
     # Start Ethics

     case '363c931c-f7e0-2c21-9d95-4df55f8f591e': // Ethics

      $fieldname = "sfx_ethics_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_ethics";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_ethics_id_c;
      $field_id = $sfx_ethics_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Ethics']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Ethics
     #####################
     break; // end Ethics type
     #####################
     # Start Monetary
/*
734d7a8c-459a-aa0a-7d17-4df55f00f5c8 | Monetary - P & L - Expense
7c0e0474-9b0c-c2aa-fd18-50ec0b86dfee | Monetary - P & L - Revenue
a4ae0bb9-12bc-b535-d8b5-50ec0b2b2cfd | Monetary - B/S - Asset
c3efcb4d-efe5-2a88-d18c-50ec0be756ff | Monetary - B/S - Liability
6909472a-4b8c-7369-d53e-50ec0cea8c79 | Monetary - General
*/
     case ('734d7a8c-459a-aa0a-7d17-4df55f00f5c8' || '7c0e0474-9b0c-c2aa-fd18-50ec0b86dfee' || 'a4ae0bb9-12bc-b535-d8b5-50ec0b2b2cfd' || 'c3efcb4d-efe5-2a88-d18c-50ec0be756ff' || '6909472a-4b8c-7369-d53e-50ec0cea8c79'): // Monetary

      $fieldname = "value_type_value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $value_type_fieldname = "sfx_valuetypes_id_c";
      $value_type_thisvalue = $id;
      $value_type_field_id = $id;
      $hidden_value_type = $funky_gear->form_objects ($do,$next_action,$valtype,$value_type_fieldname,'hidden',$length,$textboxsize,$textareacols,$value_type_thisvalue,$value_type_field_id);

      $fieldname = "cmv_currencies_id_c";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmv_currencies";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = 'ddd07ef1-8ce6-2188-ae4e-5157be0c437e';
      $field_id = "cmv_currencies";

      $currency_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings['Monetary']."</div>
          ".$divval_front."
           $form_object 
           </div>
          ".$divlbl_front.$strings['Currency']."
           </div>
        ".$divval_front."
         $currency_object $hidden_object $hidden_value_type $returner
        </div>";

     # End Monetary
     #####################
     break; // end Monetary type

    } // end id switch for sfx_valuetypes

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for Effects
  #####################

 break; // end Effects
 #####################
 case 'Industries':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'cmn_industries':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"cmn_industries_id_c\" name=\"cmn_industries_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Industries&action=$action&tbl=cmn_industries&id=return&valuetype=$valtype&value=$val','cmn_industries');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "cmn_industries_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_industries";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " cmn_industries_id_c='' "; // Exceptions
      $thisvalue[5] = $id; // Current Value
      $thisvalue[6] = 'Industries';
      $thisvalue[7] = "cmn_industries"; // list reltablename
      $thisvalue[8] = 'Industries'; //new do
      $thisvalue[9] = "";

      $field_id = $cmn_industries_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Industry</div>
        ".$divval_front."
         $form_object
        </div>";

     break;
     # End Returner
     #####################
     case ($id != NULL):

      $fieldname = "cmn_industries_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_industries";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " cmn_industries_id_c='".$id."' "; // Exceptions
      $thisvalue[5] = $id; // Current Value
      $thisvalue[9] = $id;

      $field_id = $cmn_industries_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Industry</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";


     break;
     # End sent
     #####################

    } // end id switch for 

   # End value types
   #####################
   break; // 
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end Industries
 #
#####################

 case 'SIBaseUnits':

  $tbl = $_GET['tbl'];

  #####################
  # Base Tables

  switch ($tbl){

   case 'sfx_sibaseunits':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"sfx_sibaseunits_id_c\" name=\"sfx_sibaseunits_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=sfx_sibaseunits&id=return&valuetype=$valtype&val=$val','sfx_sibaseunits');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";
    $vt_returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=sfx_valuetypes&id=return&valuetype=$valtype&val=$val','sfx_valuetypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "sfx_sibaseunits_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_sibaseunits";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_sibaseunits_id_c;
      $thisvalue[9] = $val;
      $field_id = $sfx_sibaseunits_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['SIBaseUnit']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     # End Returner
     #####################
     break;
     #####################
     # SI Base Units

     case '744bc173-b735-003e-d9b3-515f87c5de54': // Substance Amount
     case '18bf3801-3acf-3a46-aee0-515f87624492': // Luminous Intensity
     case '7fc5b4aa-8e49-a110-431f-515f87b5d9ac': // Temperature (Kelvin)
     case '558b7726-b19d-40e8-d81e-515f87e5e552': // Electric Current (Ampere)
     case '15d27ec8-b370-15e6-c6ce-515f87908ab1': // Time (Seconds)
     case '85421152-5aa2-ade9-6c79-515f87cd7353': // Mass (Kilogram)
     case 'ca5f2a82-8f69-d5fa-0990-515f86976acd': // Length (Metre)

     if ($id == '744bc173-b735-003e-d9b3-515f87c5de54'){
        $label = "Substance Amount (mol,N)";
        $definition = "The amount of substance of a system which contains as many elementary entities as there are atoms in 0.012 kilogram of carbon 12.
N";
        }

     if ($id == '18bf3801-3acf-3a46-aee0-515f87624492'){
        $label = "Luminous Intensity (candela,cd)";
        $definition = "The candela is the luminous intensity, in a given direction, of a source that emits monochromatic radiation of frequency 540×1012 hertz and that has a radiant intensity in that direction of 1/683 watt per steradian.";
        }

     if ($id == '7fc5b4aa-8e49-a110-431f-515f87b5d9ac'){
        $label = "Temperature (kelvin,K)";
        $definition = "The kelvin, unit of thermodynamic temperature, is the fraction 1 ⁄ 273.16 of the thermodynamic temperature of the triple point of water. This definition refers to water having the isotopic composition defined exactly by the following amount of substance ratios: 0.000 155 76 mole of 2H per mole of 1H, 0.000 379 9 mole of 17O per mole of 16O, and 0.002 005 2 mole of 18O per mole of 16O.";
        }

     if ($id == '558b7726-b19d-40e8-d81e-515f87e5e552'){
        $label = "Electric Current (ampere,A)";
        $definition = "The ampere is that constant current which, if maintained in two straight parallel conductors of infinite length, of negligible circular cross-section, and placed 1 metre apart in vacuum, would produce between these conductors a force equal to 2 × 10−7 newton per metre of length.";
        }

     if ($id == '15d27ec8-b370-15e6-c6ce-515f87908ab1'){
        $label = "Time (second,s)";
        $definition = "The second is the duration of 9,192,631,770 periods of the radiation corresponding to the transition between the two hyperfine levels of the ground state of the caesium 133 atom. This definition refers to a caesium atom at rest at a temperature of 0 K.";
        }

     if ($id == '85421152-5aa2-ade9-6c79-515f87cd7353'){
        $label = "Mass (kilogram,KG)";
        $definition = "The kilogram is the unit of mass (note: not the gram); it is equal to the mass of the international prototype of the kilogram.";
        }

     if ($id == 'ca5f2a82-8f69-d5fa-0990-515f86976acd'){
        $label = "Length (Metre/Meter,m)";
        $definition = "The metre is the length of the path travelled by light in vacuum during a time interval of 1 ⁄ 299,792,458 of a second.";
        }

      $fieldname = "value_type_value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$label."</div>
          ".$divval_front."
           $form_object $definition $hidden_object $returner
        </div>";

     # End Substance Amount
     #####################
     break; // end Monetary type

    } // end id switch for sfx_valuetypes

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for Effects
  #####################

 break; // end Effects
 #####################
 case 'ExternalSources':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sfx_externalsourcetypes':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"sfx_externalsourcetypes_id_c\" name=\"sfx_externalsourcetypes_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=ExternalSources&action=$action&tbl=sfx_externalsourcetypes&id=return&valuetype=$valtype&val=$val','sfx_externalsourcetypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "sfx_externalsourcetypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_externalsourcetypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "enabled=1"; // Exceptions
      $thisvalue[5] = $id; // Current Value
      $thisvalue[9] = $val;

      $field_id = $sfx_externalsourcetypes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."External Source Type</div>
        ".$divval_front."
         $form_object
        </div>";

     break;

     # End Returner
     #####################
     # SugarCRM

     case 'bbd8fef5-9674-d435-a40d-4df4bb52e385':

      // Also want to add pre-registerable objects - such as Opportunities, Projects and Project Tasks

      // Need to add the sfx_externalsourcetypes_id_c field as well as the checkboxes
      $fieldname = "sfx_externalsourcetypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_externalsourcetypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "enabled=1"; // Exceptions
      $thisvalue[5] = $id; // Current Value
      $thisvalue[9] = $val;

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."External Source Type</div>
       ".$divval_front."
         $form_object $hidden_object $returner
        </div><BR><img src=images/blank.gif width=500 height=1><BR>";

      // Provide checkbox for SugarCRM Project to pre-register as an object - only used when adding
      // Not provided when editing as we would have to check to see if it has already been registered as an object = mendokusai!!

      $fieldname = "pre-register-sugarcrm-projects";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "";

      $thisvalue = 1;
      $field_id = 1;

      $next_action = "process";

      $project_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'checkbox',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Pre-register SugarCRM Projects Object?</div>
       ".$divval_front."
         $project_form_object $hidden_object <BR><img src=images/blank.gif width=150 height=10><BR>
        </div><BR><img src=images/blank.gif width=500 height=1><BR>";

      $fieldname = "pre-register-sugarcrm-project-tasks";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "";

      $thisvalue = 1;
      $field_id = 1;

      $next_action = "process";

      $project_tasks_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'checkbox',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Pre-register SugarCRM Project Tasks Object?</div>
       ".$divval_front."
         $project_tasks_form_object $hidden_object <BR><img src=images/blank.gif width=150 height=10><BR>
        </div><BR><img src=images/blank.gif width=500 height=1><BR>";

      $fieldname = "pre-register-sugarcrm-opportunities";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "";

      $thisvalue = 1;
      $field_id = 1;

      $next_action = "process";

      $opportunity_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'checkbox',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Pre-register SugarCRM Opportunities Object?</div>
       ".$divval_front."
         $opportunity_form_object $hidden_object <BR><img src=images/blank.gif width=150 height=10><BR>
        </div>";

     break;

     # End CRM info sent
     #####################

    } // end id switch for message_recipients

   # End value types
   #####################
   break; // 
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ExternalSources
 #####################
 case 'Projects':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'content_type':

    $id = $_GET['id'];


    $id = $_GET['id'];
    $content_type = $_GET['content_type'];
    $content_name_field = $_GET['content_name_field'];
    $content_name = $_GET['content_name'];

    if ($id != NULL && $content_type == NULL){
       // New selection - not chosen yet - must decide if text box or dropdown, etc.
//       $content_type = dlookup("sclm_configurationitemtypes", "ci_data_type", "id='".$id."'");
       }

    $hidden_object = "<input type=\"hidden\" id=\"content_type\" name=\"content_type\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val&content_type=$content_type&content_name=$content_name&content_name_field=$content_name_field','content');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "content_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $file_pack[] = "No File";
      $file_pack[] = "No File again";

      $thisvalue[1] = $file_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "image";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'file_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;
     case ($id != 'return'):


foreach ($_FILE as $filekey=>$filevalue){
 
echo "File Field: ".$filekey." - Value: ".$filevalue."<BR>";
 
} // end for post each 

      $output_dir = "uploads/";
 
      if (isset($_FILES["myfile"])){
         //Filter the file types , if you want.
         if ($_FILES["myfile"]["error"] > 0){
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
            //move the uploaded file to uploads folder;
            move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
            echo "Uploaded File :".$_FILES["myfile"]["name"];
            }
         }

      $fieldname = "image";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $file_pack[] = "No File";
      $file_pack[] = "No File again";

      $thisvalue[1] = $file_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "image";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'file_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break;

    } // id switch

   break; // end credits

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end Projects
 #####################
 case 'Services':


#foreach ($_GET as $key=>$value){
#echo "Field: ".$key." - Value: ".$value."<BR>";
#} // end for post each 

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sclm_configurationitems':

    $id = $_GET['id'];

    $service_type = $_GET['service_type'];
    if (!$service_type){
       $service_type = $_POST['service_type'];
       }

    $hidden_object = "<input type=\"hidden\" id=\"sclm_configurationitems\" name=\"sclm_configurationitems\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','sclm_configurationitems');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "parent_service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitems";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' && sclm_configurationitems_id_c='' ORDER BY name ASC";
      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front."<font color=white>Parent Service Type</font></div>
        ".$divval_front."
         $form_object
        </div>";   

     break;
     case ($id != 'return'):

      $fieldname = "parent_service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitems";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' && sclm_configurationitems_id_c=''  ORDER BY name ASC ";
      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $field_id = $id;

      $par_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

      $form_item = $divlbl_front."<font color=white>Parent Service Type</font></div>
        ".$divval_front."
         $returner <P> $par_form_object $hidden_object
        </div>";  

      $fieldname = "service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitems";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " sclm_configurationitems_id_c='".$id."' ";
      $thisvalue[5] = $service_type;
      $thisvalue[9] = $service_type;

      $field_id = $service_type;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item .= $divlbl_front."<font color=white>Child Service Type</font></div>
        ".$divval_front."
        $form_object
        </div>";   

     break;

    } // id switch

   break; // end credits
   case 'images':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"images\" name=\"images\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','images');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "image";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $file_pack[] = "No File";
      $file_pack[] = "No File again";

      $thisvalue[1] = $file_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "image";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'file_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;
     case ($id != 'return'):

      $fieldname = "image";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $file_pack[] = "No File";
      $file_pack[] = "No File again";

      $thisvalue[1] = $file_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "image";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'file_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Image']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break;

    } // id switch

   break; // end credits

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ServicePrices
 #####################
 case 'ServicesPrices':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'credits':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"credits\" name=\"credits\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','credits');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "cmn_countries_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      for ($list=1;$list < 9001;$list++){
    
          $creditlistpack[$list] = $list;

          }

      $thisvalue[1] = $creditlistpack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "credits";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Credits']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;
     case ($id != 'return'):

      $fieldname = "credits";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      for ($list=1;$list < 1000000;$list+5){
    
          $creditlistpack[$list] = $list;

          }

      # Partner share requires check of custom settings
      # Also used by ServicesPrices

      $thisvalue[1] = $creditlistpack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = "";
      $thisvalue[7] = "credits";

      #$partner_credit_value = $credits_base_rate*$credits_partner_share;
      #$creditvalue = $id*$partner_credit_value;
      #$creditvalue = number_format($creditvalue);
      $creditvalue = number_format($id);

      $field_id = $id;
      $strings["BaseValue"] = "Base Value";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Credits']."</div>
        ".$divval_front."
         $form_object ".$strings["BaseValue"].": JPY ".$creditvalue."  $hidden_object $returner
        </div>";   

     break;

    } // id switch

   break; // end credits
   case 'cmn_countries':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"cmn_countries_id_c\" name=\"cmn_countries_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','cmn_countries');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "cmn_countries_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_countries";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " name IS NOT NULL ORDER BY name ";
      $thisvalue[5] = $cmn_countries_id_c;
      $thisvalue[6] = "Countries";

      $field_id = $cmn_countries_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front.$strings['Country']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;

     # End Returner
     #####################
     # Start Other Types

     case ($id != 'return'):

      $fieldname = "cmn_countries_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_countries";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " name IS NOT NULL ORDER by name ";
      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $country_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

      $cmn_currencies_id_c = dlookup("cmn_countries", "cmn_currencies_id_c","id='".$id."' ");

      $tz_pack = $funky_gear->get_timezones($id);

/*
      $country_code = dlookup("cmn_countries", "two_letter_code","id='".$id."' ");

      $region_code_csv = fopen('region_codes.csv', 'r');

      while (($codes = fgetcsv($region_code_csv)) !== FALSE) {
            //$codes is an array of the csv elements
            #list($country_codes[], $regiona_code[], $country_name[]) = $codes;
            $these_codes[] = $codes;

            } // while
  
      fclose($region_code_csv);

      $system_timezone = 'Asia/Tokyo';
      date_default_timezone_set($system_timezone);
      $date = date ("Y-m-d G:i:s");
      #$all_timezones = timezone_identifiers_list();

      #var_dump($all_timezones);

      $tz_pack = "";
      $tz_pack = array();

      if (is_array($these_codes)){

            foreach ($these_codes AS $key => $value){
                     $this_country_code = $value[0];
                     $this_region_code = $value[1];
                     $this_region_name = $value[2];
                     if ($this_country_code == $country_code && $country_code != 'US' && $country_code != 'SG'){
                        #echo "Key: ".$key." Country Code: ".$this_country_code."<BR>";
                        #if ($this_region_name != "Armed Forces Americas" && $this_region_name != "Armed Forces Europe, Middle East, & Canada" && $this_region_name != "Armed Forces Pacific"){
                        if ($this_country_code != NULL && $this_region_code != NULL){
                           if (geoip_time_zone_by_country_and_region($this_country_code,$this_region_code)){
                              $this_timezone = geoip_time_zone_by_country_and_region($this_country_code,$this_region_code);
                              }
                           }
                        if ($this_timezone != 'America/Argentina'){
                           $tz_date = new DateTime($date, new DateTimeZone($system_timezone) );
                           $tz_date->setTimeZone(new DateTimeZone($this_timezone));
                           $new_date = $tz_date->format('Y-m-d H:i:s');
                           } else {
                           $new_date = $date;
                           }
 
                        $tz_pack[$this_timezone] = $this_timezone." -> ".$new_date;

                        } // if key

                     } //foreach
          } // is array

      if (!$this_timezone){
         $all_timezones = timezone_identifiers_list();
         $tzi = 0;
         foreach ($all_timezones AS $zone) {
                 $zone = explode('/',$zone);
                 $zonen[$tzi]['continent'] = isset($zone[0]) ? $zone[0] : '';
                 $zonen[$tzi]['city'] = isset($zone[1]) ? $zone[1] : '';
                 $zonen[$tzi]['subcity'] = isset($zone[2]) ? $zone[2] : '';
                 $this_timezone = $zonen[$tzi]['continent']."/".$zonen[$tzi]['city'];

#                 if ($this_timezone != 'America/Argentina'){
#                    $tz_date = new DateTime($date, new DateTimeZone($system_timezone) );
#                    $tz_date->setTimeZone(new DateTimeZone($this_timezone));
#                    $new_date = $tz_date->format('Y-m-d H:i:s');
#                    } else {
#                    $new_date = $date;
#                    }

                 #$tz_pack[$this_timezone] = "Timezone: ".$this_timezone." -> ".$new_date;
                 $tz_pack[$this_timezone] = $this_timezone;
                 $tzi++;

                 }
         }

      # Use country name to try and get timezone parts

      $tzi = 0;
      foreach ($all_timezones AS $zone) {
              $zone = explode('/',$zone);
              $zonen[$tzi]['continent'] = isset($zone[0]) ? $zone[0] : '';
	      $zonen[$tzi]['city'] = isset($zone[1]) ? $zone[1] : '';
              $zonen[$tzi]['subcity'] = isset($zone[2]) ? $zone[2] : '';
              $timezone_bit = $zonen[$tzi]['continent']."/".$zonen[$tzi]['city'];

              if ($country_name){

                 if ($zonen[$tzi]['continent'] == $country_name){
                    # Pack country-related timezones

                    if (!$timezone == 'America/Argentina'){
	               $tz_date = new DateTime($date, new DateTimeZone($system_timezone) );
                       $tz_date->setTimeZone(new DateTimeZone($timezone));
	               $new_date = $tz_date->format('Y-m-d H:i:s');
	               } else {
	               $new_date = $date;
	               }

                    $tz_pack[$timezone_bit] = $timezone_bit." -> ".$new_date;

                    } else {

                    # Pack all timezones

                    } // if country = tz country

                 } //  if country

	      #echo "Continent: ".$zonen[$i]['continent']." + City: ".$zonen[$i]['city']." + Subcity: ".$zonen[$i]['subcity']." + ".$new_date."\n\n";
              $tzi++;

              } // foreach
*/

      $fieldname = "timezone";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";
      $thisvalue[0] = "list";
      $thisvalue[1] = $tz_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " cmn_countries_id_c='".$id."' ";
      $thisvalue[5] = $timezone;
      $thisvalue[9] = $timezone;
      $timezone_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

      $fieldname = "cmn_currencies_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_currencies";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = " cmn_countries_id_c='".$id."' ";
      $thisvalue[5] = $cmn_currencies_id_c;
      $thisvalue[9] = $cmn_currencies_id_c;

      $currency_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
        $form_item = $divlbl_front.$strings['Country']."</div>
        ".$divval_front."
         $country_object $hidden_object
        <BR>Timezone: ".$timezone_object."
        <BR>".$strings['Currency'].": ".$currency_object."
        </div>";

     break;

   } // id switch

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ServicePrices
 #####################

/*
 case 'SideEffects':

  $tbl = $_GET['tbl'];

  #####################
  # Effects Tables

  switch ($tbl){

   case 'sfx_valuetypes':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"sfx_valuetypes_id_c\" name=\"sfx_valuetypes_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=SideEffects&action=embedd&tbl=sfx_valuetypes&id=return&valuetype=$valtype&value=$val','sfx_valuetypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     case 'return': // re-do

      $fieldname = "sfx_valuetypes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_valuetypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_valuetypes_id_c;
      $thisvalue[9] = $val;
      $field_id = $sfx_valuetypes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ValueTypes']."</div>
        ".$divval_front."
         $form_object
        </div>";   

     break;
     #####################
     # Importance
     #####################
     case 'bbf759bf-76c6-9508-affd-510d31381088': // Importance

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $value_type_value;
      $field_id = $value_type_value;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Importance</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Importance
     #####################
     break; // end Urgency type
     #####################
     # Urgency
     #####################
     case 'be58451d-6281-ea0c-db11-510d31d88f6e': // Urgency

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $value_type_value;
      $field_id = $value_type_value;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Urgency</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Urgency
     #####################
     break; // end Urgency type
     #####################
     # Emotions
     #####################
     case '53056798-4871-55c4-a4f7-4df5658ba401': // Emotions

      $fieldname = "sfx_emotions_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

$dd_pack = "";
$dd_pack = array();

$dd_pack['6c87777a-1fc8-72ae-d3d8-4df5534ff5f7'] = 'Affection';
$dd_pack['7454f620-f08f-5af8-147a-4df553769de1'] = 'Anger';
$dd_pack['7513e0df-c6a8-02c1-9d6f-4df553b0d5a8'] = 'Angst';
$dd_pack['75d17d81-af09-167a-a376-4df5536fb68c'] = 'Annoyance';
$dd_pack['76900347-de37-1145-68ee-4df55359b76d'] = 'Anxiety';
$dd_pack['774e4266-3280-43b9-54dd-4df553d5b7c4'] = 'Apathy';
$dd_pack['780c7222-585a-9b0e-4d0a-4df5534c469c'] = 'Aroused';
$dd_pack['78c9ed1d-6e14-3d15-d867-4df5538ddb52'] = 'Awe';
$dd_pack['7987f871-d84c-3511-c2af-4df553e0f3cd'] = 'Contempt';
$dd_pack['7a46a2a7-9c86-e051-b74d-4df553cd009e'] = 'Curiosity';
$dd_pack['7b04aad6-d849-9f47-6eda-4df553fd56c7'] = 'Boredom';
$dd_pack['7bc240ff-4a4f-71bb-ca6e-4df553f060ac'] = 'Depression';
$dd_pack['7c59542d-ad31-6de6-e529-4df553d74e56'] = 'Desire';
$dd_pack['7cf004c2-be71-435e-f1cb-4df553201632'] = 'Despair';
$dd_pack['7d86e5ff-2c72-fb27-54e3-4df553075ca0'] = 'Disappointment';
$dd_pack['7e1d5525-394c-5ecd-7783-4df5539f0126'] = 'Disgust';
$dd_pack['7eb399b6-6c71-ca07-9a08-4df5531cf0c0'] = 'Dread';
$dd_pack['7f4a3e00-c146-ffb4-7c62-4df55326d28b'] = 'Ecstasy';
$dd_pack['7fe0cb58-ba5b-1b94-0a9f-4df553906664'] = 'Embarrassment';
$dd_pack['8077715d-836b-9d6f-090f-4df553c25ac2'] = 'Empathy';
$dd_pack['810d6ef1-3024-de59-87bd-4df5535f5815'] = 'Envy';
$dd_pack['81a46a49-0f86-df68-a76d-4df5535b0c2a'] = 'Euphoria';
$dd_pack['823b990a-aed0-ae3b-44b0-4df55316e3d2'] = 'Fear';
$dd_pack['82d30d6f-1e14-cadf-5c81-4df553881fac'] = 'Fretful';
$dd_pack['836ba39e-cac0-af6e-4ca4-4df5538a2a97'] = 'Frustration';
$dd_pack['8401b9a6-669e-f997-778e-4df5538e2e1f'] = 'Gratitude';
$dd_pack['849873a5-7f35-dc20-88de-4df553b8d49a'] = 'Grief';
$dd_pack['852e36d8-068e-33c8-fbe3-4df553868365'] = 'Guilt';
$dd_pack['85c5090c-6f29-88eb-acf5-4df553416fc3'] = 'Happiness';
$dd_pack['865b156d-e5e9-3b68-442c-4df553413474'] = 'Hatred';
$dd_pack['86f1cd32-3895-bba8-f42a-4df55321f018'] = 'Hope';
$dd_pack['8788a3fd-6454-e312-740f-4df5531aefb1'] = 'Horror';
$dd_pack['881f6788-9d84-7fe1-b077-4df553023385'] = 'Hostility';
$dd_pack['88ece6bb-1685-5769-813b-4df553d8e391'] = 'Hysteria';
$dd_pack['89831d40-c7e1-9c7d-6c10-4df553edfdb8'] = 'Indifference';
$dd_pack['8a19e8f0-3636-449a-d4c1-4df5539fedbf'] = 'Interest';
$dd_pack['8ab2a907-0240-22a5-56a5-4df553e032ca'] = 'Jealousy';
$dd_pack['8b4b185f-b0d4-f90b-e756-4df553cf69e0'] = 'Loathing';
$dd_pack['8be1cc66-d53b-1978-ee16-4df5532f8cdb'] = 'Loneliness';
$dd_pack['8c78a096-8a6e-20b7-b5a0-4df55322a05c'] = 'Love';
$dd_pack['8d0fdd35-3b4f-6f0f-f003-4df55347299f'] = 'Lust';
$dd_pack['8da6932f-252c-7e8a-96be-4df553c35f50'] = 'Misery';
$dd_pack['8e3d0285-8acd-83c4-f865-4df55300adbd'] = 'Pity';
$dd_pack['8ed4eafb-7249-babe-f101-4df553399b3e'] = 'Pride';
$dd_pack['8f6f6278-2479-4376-4cd1-4df5534e3e9f'] = 'Rage';
$dd_pack['90054559-1ecc-ed77-c4e5-4df5533875b8'] = 'Regret';
$dd_pack['909d7f55-6b86-ea62-0ad0-4df553cee1c5'] = 'Remorse';
$dd_pack['91360b02-8ef9-dc8c-708c-4df55300ea79'] = 'Sadness';
$dd_pack['91cdde9b-3958-eae5-9011-4df553306a10'] = 'Satisfied';
$dd_pack['9264f0ba-3910-b8ee-10cc-4df553f09213'] = 'Shame';
$dd_pack['92fa97ea-c13a-cbb5-f8aa-4df553b0589d'] = 'Shock';
$dd_pack['9390f737-d943-2333-a04d-4df5535c4a68'] = 'Shyness';
$dd_pack['9427a93b-a6fd-9869-3fac-4df553584704'] = 'Sober';
$dd_pack['94be884f-fce9-e7c1-1123-4df553544a36'] = 'Sorrow';
$dd_pack['9554dff7-d90c-40e0-034f-4df553b174c3'] = 'Suffering';
$dd_pack['95eb62c2-7743-e1b2-04b3-4df55398fe66'] = 'Surprise';
$dd_pack['9683f739-0718-9a97-1fee-4df55337f16d'] = 'Wonder';
$dd_pack['971a7a5a-45f5-37db-ec60-4df5531b2207'] = 'Worry';

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_emotions_id_c;
      $field_id = $sfx_emotions_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Emotions']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Emotions
     #####################
     break; // end Emotions type
     #####################
     # Start Quantity

     case '53d8df93-31bd-cd79-9b2f-4df560958c2c': // Quantity or Amount

      $fieldname = "value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings['Quantity']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Quantity
     #####################
     break; // end Quantity type
     #####################
     # Start Ethics

     case '363c931c-f7e0-2c21-9d95-4df55f8f591e': // Ethics

      $fieldname = "sfx_ethics_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

$dd_pack = "";
$dd_pack = array();

$dd_pack['99961289-6993-a55f-c470-4dff54c1388b'] = 'Ethical Relativism - Depends on the Group';
$dd_pack['81d7dc2a-f051-5e7c-667c-4dff54073f4d'] = 'Utilitarianism - The greatest good for the greatest number';
$dd_pack['16522c3f-71f9-5cb2-5dd2-4dff5545e425'] = 'Deontological - Do not harm minorities';

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $sfx_ethics_id_c;

      $field_id = $sfx_ethics_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Ethics']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Ethics
     #####################
     break; // end Ethics type
     #####################
     # Start Monetary

     case '734d7a8c-459a-aa0a-7d17-4df55f00f5c8': // Monetary - P & L - Expense
     case '7c0e0474-9b0c-c2aa-fd18-50ec0b86dfee': // Monetary - P & L - Revenue
     case 'a4ae0bb9-12bc-b535-d8b5-50ec0b2b2cfd': // Monetary - B/S - Asset
     case 'c3efcb4d-efe5-2a88-d18c-50ec0be756ff': // Monetary - B/S - Liability
     case '6909472a-4b8c-7369-d53e-50ec0cea8c79': // Monetary - General

//$dd_pack['bbf759bf-76c6-9508-affd-510d31381088'] = 'Importance';
//$dd_pack['be58451d-6281-ea0c-db11-510d31d88f6e'] = 'Urgency';

      $fieldname = "value_type_value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings['Monetary']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Monetary
     #####################
     break; // end Monetary type

    } // end id switch for sfx_valuetypes

   # End value types
   #####################
   break;
   #####################
   #

  } // end tables switch;

  # End Tables for Effects
  #####################

 break; // end SideEffects
*/
 #####################
 case 'SourceObjects':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sfx_externalsources':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"sfx_externalsources_id_c\" name=\"sfx_externalsources_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=SourceObjects&action=$action&tbl=sfx_externalsources&id=return&valuetype=$valtype&value=$val','sfx_externalsources');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

//echo "<P>ID: $id <P>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "sfx_externalsources_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $source_type = 'bbd8fef5-9674-d435-a40d-4df4bb52e385'; // SugarCRM

      $get_object_type = "Contacts";
      $get_action = "get_account_id";
      $accparams[0] = $sess_contact_id;
      $accparams[1] = "account_id";
      $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $get_object_type, $get_action, $accparams);

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_externalsources";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "account_id_c='".$account_id."' && sfx_externalsourcetypes_id_c='".$source_type."' "; // Exceptions
      $thisvalue[5] = $sfx_externalsources_id_c; // Current Value
      $thisvalue[9] = $val;

      $field_id = $sfx_externalsources_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Source Objects</div>
        ".$divval_front."
         $form_object
        </div>";

     break;

     # End Returner
     #####################
     # Link

     case ($id != NULL && $id != 'return'):

      // Get CRM modules as selections - have already submitted ones pre-checked.
      $extsrc_object_type = "ExternalSources";
      $extsrc_action = "select";
      $extsrc_params[0] = " id='".$id."' ";
      $extsrc_params[1] = ""; // select
      $extsrc_params[2] = ""; // group;
      $extsrc_params[3] = ""; // order;
      $extsrc_params[4] = ""; // limit

      $source_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $extsrc_object_type, $extsrc_action, $extsrc_params);

      if (is_array($source_info)){
      
         for ($cnt=0;$cnt < count($source_info);$cnt++){

             $val = $source_info[$cnt]['id'];
             $name = $source_info[$cnt]['name'];
             $api_url = $source_info[$cnt]['api_url'];
             $account_id = $source_info[$cnt]['account_id_c'];
             $api_username = $source_info[$cnt]['api_username'];
             $api_password = $source_info[$cnt]['api_password'];
             $secret_key = $source_info[$cnt]['secret_key'];
             $sfx_externalsourcetypes_id_c = $source_info[$cnt]['sfx_externalsourcetypes_id_c'];
             $description = $source_info[$cnt]['description'];

             } // for

         } // if array

      if ($api_url != NULL && $api_username != NULL && $api_password != NULL){

         // use above details to access the users crm - collect any modules as options
         $api_object_type = "Modules";
         $api_action = "get_all";
         $api_params = array();

	if (!function_exists('nusoap_client')){
	   require_once ("nusoap/nusoap.php");
	}

         $crm_api_user2 = $api_username;
         $crm_api_pass2 = $api_password;
         $crm_wsdl_url2 = $api_url;

         $api_params[0] = $crm_api_user2;
         $api_params[1] = $crm_api_pass2;
         $api_params[2] = $crm_wsdl_url2;
         $api_params[3] = "";
  
//echo "HOST: ".$crm_wsdl_url2."<BR>";
//echo "USER: ".$crm_api_user2."<BR>";
//echo "PASS: ".$crm_api_pass2."<BR>";

  	 $auth_array = array('user_auth' => array ('user_name' => $crm_api_user2, 'password' => md5($crm_api_pass2), 'version' => '0.1'));

	 $soapclient = new nusoap_client($crm_wsdl_url2);
	 $login_results = $soapclient->call('login',$auth_array,'RealPolitika.org');

	 $sugar_session_id = $login_results['id'];

 	 $limit = "";
       
	 $result = $soapclient->call('get_available_modules', array('session'=>$sugar_session_id,'max_results'=>$limit,'deleted'=>'0'));

//var_dump($ddpack);

         $fieldname = "name";
         $textboxsize = "";
         $textareacols = "";
         $length = "";
         $formobjectheight = "50px";

         $dd_pack = "";
         $dd_pack = array();

	 foreach ($result['modules'] as $key => $value){

//            echo "Key: $key | Value: $value <BR>";
//        	 $ddpack[$key] = $value;
        	 $ddpack[$value] = $value;

	         } // foreach

         $thisvalue[0] = "list";
         $thisvalue[1] = $ddpack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = ""; // Exceptions
         $thisvalue[5] = $sfx_sourceobjects_id_c; // Current Value

         $field_id = $sfx_sourceobjects_id_c;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         } else {// end if crm config available

         $fieldname = "name";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = "";

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         }

      $form_item = $divlbl_front."Sugar Module:</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End CRM info sent
     #####################

    } // end id switch for message_recipients

   # End value types
   #####################
   break; // 
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ExternalSources
 #####################
 case 'SourceObjectItems':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sfx_externalsources':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"sfx_externalsources_id_c\" name=\"sfx_externalsources_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=SourceObjects&action=$action&tbl=sfx_externalsources&id=return&valuetype=$valtype&value=$val','sfx_externalsources');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

//echo "<P>ID: $id <P>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "sfx_externalsources_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $source_type = 'bbd8fef5-9674-d435-a40d-4df4bb52e385'; // SugarCRM

      $get_object_type = "Contacts";
      $get_action = "get_account_id";
      $accparams[0] = $sess_contact_id;
      $accparams[1] = "account_id";
      $account_id = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $get_object_type, $get_action, $accparams);

      $thisvalue[0] = "db";
      $thisvalue[1] = "sfx_externalsources";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "account_id_c='".$account_id."' && sfx_externalsourcetypes_id_c='".$source_type."' "; // Exceptions
      $thisvalue[5] = $sfx_externalsources_id_c; // Current Value
      $thisvalue[9] = $val;

      $field_id = $sfx_externalsources_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Source Objects</div>
        ".$divval_front."
         $form_object
        </div>";

     break;
     # End Returner
     #####################
     case "";

     break;
     # End sent
     #####################

    } // end id switch for message_recipients

   # End value types
   #####################
   break; // 
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end ExternalSourceObject Items
 #
 #####################
 # Provide a list of objects to make relations
 case 'Objects':

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'related_objects':

    $id = $_GET['id'];
 
/*

      $dd_pack = "";
      $dd_pack = array();

      $dd_pack['Actions'] = 'Actions';
      $dd_pack['Effects'] = 'Effects';
      $dd_pack['News'] = 'News';
      $dd_pack['Causes'] = 'Causes';
      $dd_pack['Events'] = 'Events';
      $dd_pack['Content'] = 'Content';
      $dd_pack['Governments'] = 'Governments';
      $dd_pack['PoliticalParties'] = 'PoliticalParties';
      $dd_pack['PoliticalPartyPolicies'] = 'PoliticalPartyPolicies';
      $dd_pack['PoliticalPartyRoles'] = 'PoliticalPartyRoles';

*/
    switch ($valtype){
 
     case 'Actions':

      $fieldname = "cmv_actions_id_c";
      $query_one = "sfx_actions,";
      $query_two = "sfx_actions.";

      $dd_pack['Events'] = 'Events';
      $dd_pack['Causes'] = 'Causes';

     break;
     case 'Effects':

      $fieldname = "cmv_effects_id_c";
      $query_one = "sfx_effects,";
      $query_two = "sfx_effects.";

      $dd_pack['Effects'] = 'Effects';
      $dd_pack['Actions'] = 'Actions';

     break;
     case 'Events':

      $fieldname = "cmv_events_id_c";
      $query_one = "cmv_events,";
      $query_two = "cmv_events.";

      $dd_pack['Actions'] = 'Actions';
      $dd_pack['Causes'] = 'Causes';
      $dd_pack['Governments'] = 'Governments';
      $dd_pack['PoliticalParties'] = 'PoliticalParties';

     break;
     case 'Causes':

      $fieldname = "cmv_causes_id_c";
      $query_one = "cmv_causes,";
      $query_two = "cmv_causes.";

      $dd_pack['Governments'] = 'Governments';
      $dd_pack['PoliticalParties'] = 'PoliticalParties';
      $dd_pack['GovernmentConstitutions'] = 'GovernmentConstitutions';
      $dd_pack['ConstitutionalArticles'] = 'ConstitutionalArticles';
      $dd_pack['ConstitutionalAmendments'] = 'ConstitutionalAmendments';
      $dd_pack['Bills'] = 'Bills';
      $dd_pack['Statutes'] = 'Statutes';

     break;
     case 'Content':

      $fieldname = "cmv_content_id_c";
      $query_one = "cmv_content,";
      $query_two = "cmv_content.";

      $dd_pack['Actions'] = 'Actions';
      $dd_pack['Effects'] = 'Effects';
      $dd_pack['Causes'] = 'Causes';
      $dd_pack['Events'] = 'Events';
      $dd_pack['Governments'] = 'Governments';
      $dd_pack['News'] = 'News';
      $dd_pack['PoliticalParties'] = 'PoliticalParties';
      $dd_pack['GovernmentConstitutions'] = 'GovernmentConstitutions';
      $dd_pack['ConstitutionalArticles'] = 'ConstitutionalArticles';
      $dd_pack['ConstitutionalAmendments'] = 'ConstitutionalAmendments';
      $dd_pack['Bills'] = 'Bills';
      $dd_pack['Statutes'] = 'Statutes';

     break;
     case 'Governments':

      $fieldname = "cmv_governments_id_c";

     break;
     case 'PoliticalParties':

      $fieldname = "cmv_politicalparties_id_c";

     break;
     case 'GovernmentConstitutions':

      $fieldname = "cmv_governmentconstitutions_id_c";

     break;
     case 'ConstitutionalArticles':

      $fieldname = "cmv_constitutionalarticles_id_c";

     break;
     case 'ConstitutionalAmendments':

      $fieldname = "cmv_constitutionalamendments_id_c";

     break;
     case 'Bills':

      $fieldname = "cmv_bills_id_c";

     break;
     case 'Statutes':

      $fieldname = "cmv_statutes_id_c";

     break;

    } // end original_do switch

    $hidden_object = "<input type=\"hidden\" id=\"related_objects\" name=\"related_objects\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Objects&action=$action&tbl=related_objects&id=return&valuetype=$valtype&value=$val','related_objects');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";


    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "related_objects";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";


      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $related_objects;
      $thisvalue[6] = ""; // Link
      $thisvalue[7] = "related_objects"; // New DO
      $thisvalue[8] = "Objects"; // New DO
      $thisvalue[9] = $val; // Object Val
      //$do = "Objects"; // New DO

      $field_id = $related_objects;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Related Type</div>
        ".$divval_front."
         $form_object $hidden_object
        </div>";

     break;

     # End Returner
     #####################
     # Actions

     case "Actions":

      $fieldname = "sfx_actions_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."sfx_actions";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."sfx_actions_id_c IS NULL ";
      $order = " order by sfx_actions.date_modified DESC";
      $thisvalue[4] = "sfx_actions.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $sfx_actions_id_c;
      $field_id = $sfx_actions_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Action']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Actions

     # End Actions
     #####################
     # Effects

     case "Effects":

      $fieldname = "sfx_actions_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."sfx_effects";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
//      $query_two = " && ".$query_two."sfx_effects_id_c IS NULL ";
      $order = " order by sfx_effects.date_modified DESC";
//      $thisvalue[4] = "sfx_effects.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[4] = "sfx_effects.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$order; // Exceptions
      $thisvalue[5] = $sfx_effects_id_c;
      $field_id = $sfx_effects_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Effect']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Effects

     # End Effects
     #####################
     # Causes

     case "Causes":

      $fieldname = "cmv_causes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_causes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."cmv_causes_id_c IS NULL ";
      $order = " order by cmv_causes.date_modified DESC";
      $thisvalue[4] = "cmv_causes.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_causes_id_c;
      $field_id = $cmv_causes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Causes']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Actions

     # End Causes
     #####################
     # Events

     case "Events":

      $fieldname = "cmv_events_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_events";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."cmv_events_id_c IS NULL ";
      $order = " order by cmv_events.date_modified DESC";
      $thisvalue[4] = "cmv_events.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_events_id_c;
      $field_id = $cmv_events_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Event']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Events

     # End Events
     #####################
     # Governments

     case "Governments":

      $fieldname = "cmv_governments_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_governments";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
//      $query_two = " && ".$query_two."cmv_governments_id_c IS NULL ";
      $order = " order by cmv_governments.date_modified DESC ";
      $thisvalue[4] = "cmv_governments.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$order; // Exceptions
      $thisvalue[5] = $cmv_governments_id_c;
      $field_id = $cmv_governments_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Governments']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Governments

     # End Governments
     #####################
     # PoliticalParties

     case "PoliticalParties":

      $fieldname = "cmv_politicalparties_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_politicalparties";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."cmv_politicalparties_id_c IS NULL ";
      $order = " order by cmv_politicalparties.date_modified DESC ";
      $thisvalue[4] = "cmv_politicalparties.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_politicalparties_id_c;
      $field_id = $cmv_politicalparties_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['PoliticalParty']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end PoliticalParties

     # End PoliticalParties
     #####################
     # GovernmentConstitutions

     case "GovernmentConstitutions":

      $fieldname = "cmv_governmentconstitutions_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_governmentconstitutions";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
//      $query_two = " && ".$query_two."cmv_governmentconstitutions_id_c IS NULL ";
      $query_two = $query_two."cmv_governmentconstitutions_id_c IS NULL ";
      $order = " order by cmv_governmentconstitutions.date_modified DESC ";
//      $thisvalue[4] = "cmv_governmentconstitutions.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[4] = $query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_governmentconstitutions_id_c;
      $field_id = $cmv_governmentconstitutions_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['GovernmentConstitution']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end GovernmentConstitutions

     # End GovernmentConstitutions
     #####################
     # ConstitutionalArticles

     case "ConstitutionalArticles":

      $fieldname = "cmv_constitutionalarticles_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_constitutionalarticles";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."cmv_constitutionalarticles_id_c IS NULL ";
      $order = " order by cmv_constitutionalarticles.date_modified DESC ";
      $thisvalue[4] = "cmv_constitutionalarticles.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_constitutionalarticles_id_c;
      $field_id = $cmv_constitutionalarticles_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ConstitutionalArticle']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end ConstitutionalArticles

     # End ConstitutionalArticles
     #####################
     # ConstitutionalAmendments

     case "ConstitutionalAmendments":

      $fieldname = "cmv_constitutionalamendments_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_constitutionalamendments";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = $query_two."cmv_constitutionalamendments_id_c IS NULL ";
      $order = " order by cmv_constitutionalamendments.date_modified DESC ";
//      $thisvalue[4] = "cmv_constitutionalamendments.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[4] = $query_two.$query_three.$order; // Exception
      $thisvalue[5] = $cmv_constitutionalamendments_id_c;
      $field_id = $cmv_constitutionalamendments_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ConstitutionalAmendment']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end ConstitutionalAmendments

     # End ConstitutionalAmendments
     #####################
     # Bills

     case "Bills":

      $fieldname = "cmv_bills_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_bills";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."cmv_bills_id_c IS NULL ";
      $order = " order by cmv_bills.date_modified DESC ";
      $thisvalue[4] = "cmv_bills.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_bills_id_c;
      $field_id = $cmv_bills_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Bill']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Bills

     # End Bills
     #####################
     # Statutes

     case "Statutes":

      $fieldname = "cmv_statutes_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = $query_one."cmv_statutes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $query_two = " && ".$query_two."cmv_statutes_id_c IS NULL ";
      $order = " order by cmv_statutes.date_modified DESC ";
      $thisvalue[4] = "cmv_statutes.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[5] = $cmv_statutes_id_c;
      $field_id = $cmv_statutes_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Statute']."</div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; // end Statutes

     # End Statutes
     #####################

    } // end id switch 

   # End value types
   #####################
   break; // 
   #####################
   #

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end Objects
 #####################

} // end do switch

#
#####################

echo $form_item;

# End
#####################
?>
