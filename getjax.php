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

include ("css/style.php");

if (!function_exists('set_lingo')){
   include ("lingo/lingo.inc.php");
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

$header_color = $portal_header_colour;
$body_color = $portal_body_colour;
$footer_color = $portal_footer_colour;
$border_color = $portal_border_colour;
$font_color = $portal_font_colour;

$pagesdivs = $funky_gear->makedivs ();
$BodyDIV = $pagesdivs['body_div'];
$NavDIV = $pagesdivs['nav_div'];

$tdlabelwidth = 85;
$tdvaluewidth = 290;

$divlbl_front = "<div style=\"margin-left:0px;float:left;background:".$portal_header_colour."; width:".$tdlabelwidth."px;height:".$formobjectheight.";border-radius: 5px; padding: 5px 5px 5px 5px;overflow:no;\"><font color=\"".$portal_font_colour."\">";
$divval_front = "<div style=\"margin-left:5px;float:left;background:".$body_color."; width:".$tdvaluewidth."px;height:".$formobjectheight.";border:1px dotted #555;border-radius: 5px; padding: 5px 5px 5px 5px;overflow:yes;\">";

#
#####################
# Start HTML

#
#####################
#

#foreach ($_GET as $key=>$value){
 
#echo "Field: ".$key." - Value: ".$value."<BR>";
 
#} // end for post each 

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

    $application = "Scalastica";

    $login_results = $soapclient->call('login',$auth_array,$application);
    $session_id = $login_results['id'];

    return $session_id;

    #echo "<P>SESSION: $session_id <P>";

} # end function

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
 case 'Accounts':

  $tbl = $_GET['tbl'];

  switch ($tbl){
 
   #####################
   # Event Locations
   case 'category_id_c':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"category_id_c\" name=\"category_id_c\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Accounts&action=$action&tbl=category_id_c&id=return&valuetype=$valtype&val=$val','category_id_c');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "category_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

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
             $cat_pack[$cat_id] = $cat;

             } # for

         } # is array    

      $thisvalue[0] = "list";
      $thisvalue[1] = $cat_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "category_id_c"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings["Category"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Categories
     #####################
     break;
     case ($id != 'return'):
     #####################
     # 

      $fieldname = "category_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItemTypes";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id."' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "category_id_c"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown_jaxer';

         } else {# is array    

         $cat_object_type = "ConfigurationItemTypes";
         $cat_action = "select";
         $cat_params[0] = " deleted=0 && id='".$id."' ";
         $cat_params[1] = "id,name,description"; // select array
         $cat_params[2] = ""; // group;
         $cat_params[3] = "name ASC"; // order;
         $cat_params[4] = ""; // limit

         $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

         if (is_array($cat_items)){

            for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                $cat_id = $cat_items[$cnt]['id'];
                $cat = $cat_items[$cnt]['name'];
                $cat_pack[$cat_id] = $cat;

                } # for

            } # is array

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "category_id_c"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown';

         } 

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,$dropdowner,$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings["Category"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # 
     #####################
     break; // any 

    } // end id switch for sfx_valuetypes

   # End value types
   #####################
   break;

  } # end action switch

 break;
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
 
      $form_item = $divlbl_front.$strings['ConfigurationItemTypes']."</font></div>
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
 
        $form_item = $divlbl_front.$strings['ConfigurationItems']."</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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

        $form_item = $divlbl_front."Data Set Name</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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
 
      $form_item = $divlbl_front.$strings['ConfigurationItemTypes']."</font></div>
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

        $form_item = $divlbl_front.$ci_data_type_name."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

       break;
       case 'a33b0e31-b982-2957-9ffe-5255d9fcdd97': // Portal Items

        $ci_data_type_returner = $funky_gear->object_returner ('ConfigurationItemTypes', $ci_data_type);
        $ci_data_type_name = $ci_data_type_returner[0];

        $form_item = $divlbl_front.$ci_data_type_name."</font></div>
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
 
        $form_item = $divlbl_front.$ci_data_type_name."</font></div>
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
 
        $form_item = $divlbl_front.$strings['ConfigurationItems']."</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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

        $form_item = $divlbl_front."Data Set Name</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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

        $form_item = $divlbl_front."Name</font></div>
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
   case 'portal_hostname':
   #####################
   #

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"portal_hostname\" name=\"portal_hostname\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','portal_hostname');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

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
      $thisvalue[7] = "portal_hostname";

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front."Portal Hostname Options</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break; // return
     case 'sub': // Create a scalastica.com sub-domain

      $fieldname = "hostname";
      $textboxsize = 40;
      $textareacols = 40;
      $length = "";
      $formobjectheight = "50px";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

      $form_item = $divlbl_front."Check to see if available</font></div>
        ".$divval_front."
         $form_object.scalastica.com or .cloudjumbles.com or .sharedeffects.com $hidden_object $returner
        </div>";   

      $domainpack['scalastica.com']='scalastica.com';
      $domainpack['cloudjumbles.com']='cloudjumbles.com';
      $domainpack['sharedeffects.com']='sharedeffects.com';

      $fieldname = 'domain';
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $domainpack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $domain;
      $thisvalue[9] = $domain;
      $field_id = $domain;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item .= $divlbl_front."Usable Domain:</font></div>
        ".$divval_front."
         $form_object
        </div>";

     break; // Create a scalastica.com sub-domain
     case 'own': // Use your own, existing domain

      $fieldname = "hostname";
      $textboxsize = 40;
      $textareacols = 40;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = "1) Input your existing domain in the textbox below<BR>2) Set your domain's DNS with an A-Record pointing at Scalastica (IP:119.27.35.191).<P>";

      $form_object .= $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
      $form_item = $divlbl_front."Use your own, existing domain</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break; // Use your own, existing domain
     case 'reg': // Register a new domain

      $fieldname = "hostname";
      $textboxsize = 40;
      $textareacols = 40;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = "<a href=https://www.godaddy.com/?isc=cjc1off30&utm_campaign=affiliates_cj_new30&utm_source=Commission%20Junction&utm_medium=External%2BAffil&utm_content=cjc1off30 target=GODADDY>1) Click here to register your new domain at GoDaddy<BR>2) Return back here and input your new domain in the textbox below<BR>3) Set your domain's DNS with an A-Record pointing at Scalastica (IP:119.27.35.191).<P><img src=https://img1.wsimg.com/pc/img/1/country/en-us/GD_logo_NYE.jpg border=0></a><P>";

      $form_object .= $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Register a new domain</font></div>
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
 
      $form_item = $divlbl_front.$strings['MediaTypes']."</font></div>
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

      $form_item = $divlbl_front."Link</font></div>
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
 
      $form_item = $divlbl_front."Portal Hostname Options</font></div>
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

      $form_item = $divlbl_front."Check to see if available</font></div>
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
      $form_item = $divlbl_front."Use your own, existing domain</font></div>
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

      $form_item = $divlbl_front."Register a new domain</font></div>
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
  # Messages Tables

  switch ($tbl){

   case 'recipient_types':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"recipient_types\" name=\"recipient_types\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"loader('".$tbl."');getjax('getjax.php?do=".$do."&action=$action&tbl=recipient_types&id=return&valuetype=$valtype&value=$val','recipient_types');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do
     case 'NULL': // re-do

      $fieldname = "recipient_types";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";

      $dd_pack = "";
      $dd_pack = array();

      $dd_pack = $funky_messaging->message_recipient_selections();
 
      /*
      $dd_pack['email'] = "Email";
    
      if ($fb_session != NULL){
         $dd_pack['facebook'] = "Post to Facebook";
         #$dd_pack['facebook_friends'] = "Select Facebook Friends";
         }

      if ($gg_session != NULL){
         $dd_pack['google'] = "Post to Google+";
         $dd_pack['google_contacts'] = "Select Google Contacts";
         }

      if ($li_session != NULL){
         $dd_pack['linkedin'] = "Post to LinkedIn";
         $dd_pack['linkedin_contacts'] = "Select LinkedIn Contacts";
         }

      $dd_pack['account_contacts'] = "My ".$portal_title." Account Members";

      $dd_pack['social_network'] = "Post to a Social Network";

      */

      /*
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
      */

      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "recipient_types";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = $id;
      $thisvalue[6] = 'Messages';
      $thisvalue[7] = 'recipient_types';
      $thisvalue[9] = $id;
      $field_id = $id;

      $strings['Recipients'] = "Recipients";
      $primary_id = "";
      $object_bits = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);
 
      $form_item = $divlbl_front.$strings['Recipients']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break;
     # End Returner
     #####################
     # Email
     case ($id != 'return'):

      $msg_params[0] = $id;
      $msg_params[1] = "recipient_types";
      $msg_params[2] = $do;
      $msg_params[3] = $action;
      $msg_params[4] = $valtype;
      $msg_params[5] = $val;

      $form_item = $funky_messaging->message_recipient_builder($msg_params);      

     break;
     case 'email': // Email

      $fieldname = "recipient_email";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;
      $primary_id = "";
      $object_bits = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

      $form_object .= "<BR><font size=2><B>An email will be sent to this recipient...</B></font>";

      $form_item = $divlbl_front."Email</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Email
     #####################
     # Post moment to Facebook
     case 'facebook':

      $fieldname = "facebook";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "facebook";
      $field_id = $thisvalue;
      $primary_id = "";
      $object_bits = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

      $form_object .= "<BR><font size=2><B>".$strings["Facebook_MessagePost"]."</B></font>";

      $form_item = $divlbl_front."<B>Facebook Post</B></font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";
      
     # End Post to Facebook
     #####################
     break;
     #####################
     # Facebook Friend
     case 'facebook_friends': // Facebook

      require_once ("api-facebook.php");      

      $fb_params[0] = "taggable_friends"; #fb_action;
      $fb_params[1] = $fb_session; # userid

      $fbfriends = do_facebook ($fb_params);

      var_dump($fbfriends);

      exit;

      if (is_array($fbfriends) && count($fbfriends)) {  

         $check = "";
         $checkmate = "";

         foreach ($fbfriends as $friend) {

                 $fuid = $friend['uid'];
                 $username = $friend['username'];
                 $fbname = $friend['name'];
                 $email = $friend['email'];

                 $ddvalue[0] = $fbname." [".$email."]";
                 $ddvalue[1] = "images/blank.gif";#$image;
                 $ddvalue[2] = ""; # Content
                 $ddvalue[3] = ""; #$checkstate;
                 $ddvalue[4] = ""; #$country;
                 $dd_pack[$email] = $ddvalue;

                } // for uid

            } // is array uid

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "facebook_contact_email";
      $thisvalue[3] = "Facebook ".$strings["Contact"];
      $thisvalue[4] = "";
      $thisvalue[5] = $thisvalue;
      $field_id = $thisvalue;
      $primary_id = "";
      $object_bits = "";
      $fieldname = "facebook_contact_email";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);
 
      $form_item = $divlbl_front."Facebook ".$strings["Contact"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Facebook Friends
     #####################
     # Post moment to Google+
     case 'google':

      $fieldname = "google";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "google";
      $field_id = $thisvalue;
      $primary_id = "";
      $object_bits = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

      $form_object .= "<BR><font size=2><B>This message will be posted to Google+</B></font>";

      $form_item = $divlbl_front."<B>Google+ Moment Post</B></font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";
      
     break;
     # End Post moment to Google+
     #####################
     # Google Contacts
     case 'google_contacts': # Select Google Contacts

       require_once ("api-google.php");

       $gg_params[0] = "get_contacts"; #
       $gg_params[1] = $gg_session; # use
       $gg_params[2] = ""; # email

       $formaction = $_POST['formaction'];
       $search_keyword = $_POST['keyword'];
       if ($formaction == "search" && $search_keyword != NULL){
          $gg_params[3] = $search_keyword; # keyword
          } else {
          $gg_params[3] = ""; # keyword
          }

      #$date = date("Y@m@d@G");
      #$body_sendvars = $date."#Bodyphp";
      #$body_sendvars = $funky_gear->encrypt($body_sendvars);
      $action_search_keyword = $strings["action_search_keyword"];
      $DateStart = $strings["DateStart"];
      $action_search = $strings["action_search"];

$ggsearch = <<< GGSEARCH
<center>
   <form method=\"POST\" enctype=\"multipart/form-data\" action=\"getjax.php\" name=\"form_message_recipient_types\">
     <input type="text" id="keyword" placeholder="$action_search_keyword" name="keyword" value="$search_keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="id" name="id" value="google_contacts" >
     <input type="hidden" id="value" name="value" value="$val" >
     <input type="hidden" id="formaction" name="formaction" value="search" >
     <input type="hidden" id="action" name="action" value="$action" >
     <input type="hidden" id="do" name="do" value="$do" >
     <input type="hidden" id="sendiv" name="sendiv" value="message_recipient_types" >
     <input type="hidden" id="valuetype" name="valuetype" value="$valtype" >
     <input type="hidden" id="tbl" name="tbl" value="message_recipient_types" >
     <input type="button" name="button" value="$action_search" onclick="get(this.form);return false" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
GGSEARCH;

      #$form_item = $ggsearch;

      $google_contacts = do_google ($gg_params);

       for ($counter=0;$counter < count($google_contacts);$counter++){

            $title = $google_contacts[$counter]['title'];
            $email = $google_contacts[$counter]['email'];
            $phoneNumber = $google_contacts[$counter]['phoneNumber'];
            $street = $google_contacts[$counter]['street'];
            $neighborhood = $google_contacts[$counter]['neighborhood'];
            $pobox = $google_contacts[$counter]['pobox'];
            $postcode = $google_contacts[$counter]['postcode'];
            $city = $google_contacts[$counter]['city'];
            $region = $google_contacts[$counter]['region'];
            $country = $google_contacts[$counter]['country'];

            $ddvalue[0] = $title." [".$email."]";
            $ddvalue[1] = "images/blank.gif";#$image;
            $ddvalue[2] = ""; # Content
            $ddvalue[3] = ""; #$checkstate;
            $ddvalue[4] = ""; #$country;
            $dd_pack[$email] = $ddvalue;
 
            }

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "google_contacts";
      $thisvalue[3] = "Google ".$strings["Contact"];
      $thisvalue[4] = "";
      $thisvalue[5] = $thisvalue;
      $field_id = $thisvalue;
      $primary_id = "";
      $object_bits = "";
      $fieldname = "google_contacts";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

      $form_object .= "<BR><font size=2><B>This message will be posted to the selected Google contacts</B></font>";
 
      $form_item .= $divlbl_front."Google ".$strings["Contact"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Google Contacts
     #####################
     # Post to LinkedIn
     case 'linkedin':

      $fieldname = "linkedin";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "linkedin";
      $field_id = $thisvalue;

      $primary_id = "";
      $object_bits = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

      $form_object .= "<BR><font size=2><B>This message will be posted to LinkedIn</B></font>";

      $form_item = $divlbl_front."<B>LinkedIn Post</B></font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";
      
     break;
     # End Post to LinkedIn
     #####################
     # LinkedIn Contacts
     case 'linkedin_contacts': # Select LinkedIn Contacts

       require_once ("api-linkedin.php");

       $li_params[0] = "get_contacts"; #
       $li_params[1] = $li_session; # use
       $li_params[2] = ""; # email
       $li_params[3] = ""; # keyword

       $li_contacts = do_linkedin ($li_params);

       #var_dump($li_contacts);

       if (is_array($li_contacts)){

          for ($counter=0;$counter < count($li_contacts);$counter++){

              $linkedin_id = $li_contacts[$counter]['linkedin_id'];
              $first_name = $li_contacts[$counter]['first_name'];
              $last_name = $li_contacts[$counter]['last_name'];
              $email = $li_contacts[$counter]['email'];
              $headline = $li_contacts[$counter]['headline'];
              $industry = $li_contacts[$counter]['industry'];
              $picture = "";
              $picture = $li_contacts[$counter]['picture'];

              $ddvalue[0] = $first_name." ".$last_name." [ID: ".$linkedin_id."]";
              if (!$picture){
                 $picture = "images/blank.gif";
                 }
              $ddvalue[1] = $picture;#$image;
              $ddvalue[2] = ""; # Content
              $ddvalue[3] = ""; #$checkstate;
              $ddvalue[4] = ""; #$country;
              $dd_pack[$linkedin_id] = $ddvalue;
 
              } # for

          $thisvalue[0] = "list";
          $thisvalue[1] = $dd_pack;
          $thisvalue[2] = "linkedin_contacts";
          $thisvalue[3] = "LinkedIn ".$strings["Contact"];
          $thisvalue[4] = "";
          $thisvalue[5] = $thisvalue;
          $field_id = $thisvalue;
          $primary_id = "";
          $object_bits = "";
          $fieldname = "linkedin_contacts";

          $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

          $form_object .= "<BR><font size=2><B>This message will be posted to the selected LinkedIn contacts</B></font>";

          } else {# is array

          $form_object .= "<BR><font size=2><B>Your LinkedIn contacts are not available, please select another method.</B></font>";

          } 
 
      $form_item = $divlbl_front."LinkedIn ".$strings["Contact"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End LinkedIn Contacts
     #####################
     #Account Contacts
     case 'account_contacts': // Portal Friends

      $contact_object_type = "Accounts";
      $contact_action = "select_contacts";
      $contact_params = array();
      $contact_params[0] = " deleted=0 && account_id='".$sess_account_id."' ";
      $contact_params[1] = "*";
      $contact_params[2] = "";
      $contact_params[3] = " date_modified DESC ";
      $contact_params[4] = "";

      $contacts_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);

      if (is_array($contacts_list)){

         for ($cnt=0;$cnt < count($contacts_list);$cnt++){

             $contact_id = $contacts_list[$cnt]['contact_id'];
             $first_name = $contacts_list[$cnt]['first_name'];
             $last_name = $contacts_list[$cnt]['last_name'];
             $date_modified = $contacts_list[$cnt]['date_modified'];
             $picture = $contacts_list[$cnt]['profile_photo_c'];

             $check_object_type = "Contacts";
             $check_action = "get_contact_email";
             $check_params = "";
             $check_params = $contact_id; // query

             $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_object_type, $check_action, $check_params);

             $you = "";
             if ($sess_contact_id == $contact_id){
                $you = " (You!)";
                }

             $ddvalue[0] = $first_name." ".$last_name.$you;
              if (!$picture){
                 $picture = "images/blank.gif";
                 }
              $ddvalue[1] = $picture;#$image;
              $ddvalue[2] = ""; # Content
              $ddvalue[3] = ""; #$checkstate;
              $ddvalue[4] = ""; #$country;
              $dd_pack[$email] = $ddvalue;
 
              } # for

          $thisvalue[0] = "list";
          $thisvalue[1] = $dd_pack;
          $thisvalue[2] = "account_contacts";
          $thisvalue[3] = $portal_title." ".$strings["Contact"];
          $thisvalue[4] = "";
          $thisvalue[5] = $thisvalue;
          $field_id = $thisvalue;
          $primary_id = "";
          $object_bits = "";
          $fieldname = "account_contacts";

          $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

          $form_object .= "<BR><font size=2<B>This message will be posted to your selected ".$portal_title." Contacts</B></font>";

          } else {# is array

          $form_object .= "<BR><font size=2><B>Your LinkedIn contacts are not available, please select another method.</B></font>";

          } 

      $form_item = $divlbl_front."".$portal_title. "Contacts </font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     # End Portal Friends
     #####################
     # Portal Social Network Members
     case 'social_network': // Portal Social Network Members

       # Available SNs
       $sn_cits = " (sclm_configurationitemtypes_id_c='con6898e8d5-e6b5-eda3-b1bc-55220a1b5037' || sclm_configurationitemtypes_id_c='140cf7f9-fc5c-cb9c-2082-55220a924268' || sclm_configurationitemtypes_id_c='4e4233fd-bd1b-cf45-8baa-55220aeeadea' || sclm_configurationitemtypes_id_c='8be14b88-4b94-8325-ccd4-55220b6319d9' || sclm_configurationitemtypes_id_c='347e25e9-e3af-e3cc-e33c-55220ab84201') ";

       $sclm_object_type = "ConfigurationItems";
       $sclm_action = "select";
       $sclm_params[0] = " deleted=0 && ".$sn_cits;
       $sclm_params[1] = "id,name,sclm_configurationitemtypes_id_c";
       $sclm_params[2] = "";
       $sclm_params[3] = "";
       $sclm_params[4] = "";

       $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

       if (is_array($sclm_rows)){

          for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

              $id = $sclm_rows[$cnt]['id'];
              $sn_object_id = $sclm_rows[$cnt]['name']; # Event ID, Cat ID, Product ID, Account ID, Contact ID
              $sn_type_id = $sclm_rows[$cnt]['sclm_configurationitemtypes_id_c'];

              $sclm_sn_object_type = "ConfigurationItems";
              $sclm_sn_action = "select";
              $sclm_sn_params[0] = " deleted=0 && contact_id_c='".$sess_contact_id."' && sclm_configurationitems_id_c='".$id."' ";
              $sclm_sn_params[1] = "id,name,enabled";
              $sclm_sn_params[2] = "";
              $sclm_sn_params[3] = "";
              $sclm_sn_params[4] = "";

              $sclm_sn_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_sn_object_type, $sclm_sn_action, $sclm_sn_params);

              if (is_array($sclm_sn_rows)){

                 # Accounts | ID: 6898e8d5-e6b5-eda3-b1bc-55220a1b5037
                 # Contacts | ID: 140cf7f9-fc5c-cb9c-2082-55220a924268
                 # Events | ID: 4e4233fd-bd1b-cf45-8baa-55220aeeadea
                 # Lifestyle & State Categories | ID: 8be14b88-4b94-8325-ccd4-55220b6319d9
                 # Products & Services | ID: 347e25e9-e3af-e3cc-e33c-55220ab84201

                 switch ($sn_type_id){

                  case '6898e8d5-e6b5-eda3-b1bc-55220a1b5037': # Accounts

                   $sn_returner = $funky_gear->object_returner ("Accounts", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '140cf7f9-fc5c-cb9c-2082-55220a924268': # Accounts

                   $sn_returner = $funky_gear->object_returner ("Contacts", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '4e4233fd-bd1b-cf45-8baa-55220aeeadea': # Events

                   $sn_returner = $funky_gear->object_returner ("Events", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '8be14b88-4b94-8325-ccd4-55220b6319d9': # Lifestyle cat

                   $sn_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;
                  case '347e25e9-e3af-e3cc-e33c-55220ab84201': # AccountsServices

                   $sn_returner = $funky_gear->object_returner ("AccountsServices", $sn_object_id);
                   $sn_name = $sn_returner[0];                

                  break;

                 } # end sn types switch

                 $id_pack = $sn_type_id."_".$sn_object_id;
                 $dd_pack[$id_pack] = $sn_name;

                 } # is array

              } # for 

          } // end if array

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "social_network";
      $thisvalue[3] = "Social Network";
      $thisvalue[4] = "";
      $thisvalue[5] = $thisvalue;
      $field_id = $thisvalue;
      $primary_id = "";
      $object_bits = "";
      $fieldname = "social_network";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id,$object_bits);

      $form_object .= "<BR><font size=2><B>This message will be posted to your ".$portal_title." Social Network - please select your Social Network...</B></font><BR>";
 
      $form_item = $divlbl_front."Social Network</font></div>
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
  # Content Tables

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

      $fieldname = "content_url";
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
 
      $form_item = $divlbl_front.$strings['MediaTypes']."</font></div>
        ".$divval_front."
          $hidden_object $form_object
        </div>";   

     break;

     # End Returner
     #####################
     # Link

     case '552529a3-0ebd-286d-b1bc-4e0a0a5fdf8a': // Link

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Link</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End Link
     #####################
     # RSS

     case '9a69a58c-e552-87a2-fc56-4e09e918ac4e': // RSS

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."RSS</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End RSS
     #####################
     # Related Content

     case '19417a52-926b-f211-b09e-518df04bd46f': // Related Content

      $fieldname = "sclm_events_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_events";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
//      $query_two = " && ".$query_two."sfx_effects_id_c IS NULL ";
      #$order = " order by start_date DESC";
      $order = " order by name ASC";
//      $thisvalue[4] = "sfx_effects.cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b'".$query_two.$query_three.$order; // Exceptions
      $thisvalue[4] = " (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c = '".$sess_account_id."' ) ".$order; // Exceptions
      $thisvalue[5] = $sclm_events_id_c;
      $field_id = $sclm_events_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Effect']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;

     # End Related Content
     #####################
     # YouTube

     case 'd66f04ca-fa89-891b-7f75-4e09e9f94e44': // YouTube

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."You Tube</font></div>
        ".$divval_front."
         $form_object <BR>Just add the video ID. Ex: <B>Ee0no3SuWhs</B> from the URL like below:<BR>http://www.youtube.com/watch?v=<B>Ee0no3SuWhs</B><BR>$hidden_object $returner
        </div>";

     break;

     # End YouTube
     #####################
     # TED

     case '23132202-44c0-2516-952e-51966fde1497': // TED

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."TED Videos</font></div>
        ".$divval_front."
         $form_object <BR>Just add the video link (Ex: <B>http://embed.ted.com/talks/sergey_brin_and_larry_page_on_google.html</B>) from the embedd text.<BR>$hidden_object $returner
        </div>";

     break;

     # End TED
     #####################
     # www.thedailyshow.com

     case '4f0d4556-68ed-a88b-dad6-4ec501d69ce1': // www.thedailyshow.com

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."The Daily Show</font></div>
        ".$divval_front."
         $form_object <BR>Just add the video URL from the embedd source like below:<BR>embed src=\"<B>http://media.mtvnservices.com/mgid:cms:video:thedailyshow.com:402366</B>\"<BR>$hidden_object $returner
        </div>";

     break;

     # End www.thedailyshow.com
     #####################
     # iFrame

     case 'd125f2f9-38c7-6ddc-26a7-4efcd350d037': // iFrame

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."iFrame</font></div>
        ".$divval_front."
         $form_object <BR>$hidden_object $returner
        </div>";

     break;

     # End iFrame
     #####################
     # Guardian Videos

     case '454b0f3e-f406-d3ba-3039-4f09a7cefecd': // Guardian Videos

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Guardian Videos</font></div>
        ".$divval_front."
         $form_object <BR>Just add the video URL from the embedd source like below:<BR>embed src=\"<B>http://www.guardian.co.uk/world/video/2011/dec/19/north-korea-kim-jong-il-dies-video/json</B>\"<BR>$hidden_object $returner
        </div>";

     break;

     # End Guardian Videos
     #####################
     # CNN Videos

     case 'e8ec8824-cd43-a71d-959d-5149ec5e67ba': // CNN Videos

      $fieldname = "content_url";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "80px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."CNN Videos</font></div>
        ".$divval_front."
         $form_object <BR>Just add the video URL from the embedd source like below:<BR>embed src=\"<B>crime/2013/03/17/sotu-harlow-steubenville-rape-trial-verdict.cnn</B>\"<BR>$hidden_object $returner
        </div>";

     break;
     # End CNN Videos
     #####################
     # Image
     case 'edfa1627-fd3c-2ff3-288d-4e09e848d675': // Image

         $fieldname = "content_url";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item = $divlbl_front.$strings['Image']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner 
        </div>";

     break; // end Image

     # End Image
     #####################
     # Upload

     case 'cc505f5f-5a24-ddb6-a8b6-51844f51f0e0': // Upload

         $fieldname = "content_url";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'upload',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item = $divlbl_front.$strings['Image']."</font></div>
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

            $navi_returner = $funky_gear->navigator ($count,$do,$gallery_params,$val,$valtype,$page,$glb_perpage_items,'media_type_id');
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

            $fieldname = "content_url";
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

            $form_item .= $divlbl_front.$strings["GalleryImage"]."</font></div>
             ".$divval_front."
         $returner $form_object $hidden_object $returner
        </div>";

            $form_item .= $navi;

            } else {// no array! just let them use an image

            $fieldname = "content_url";
            $textboxsize = 50;
            $textareacols = 50;
            $length = "";
            $formobjectheight = "50px";

            $thisvalue = "";
            $field_id = $thisvalue;

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item = $divlbl_front.$strings['Image']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

            } // end if no gallery

         } else { // if no gallery ID

         $fieldname = "content_url";
         $textboxsize = 50;
         $textareacols = 50;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item = $divlbl_front.$strings['Image']."</font></div>
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

            $fieldname = "content_url";
            $textareacols = "";
            $textboxsize = "";
            $length = "";
            $formobjectheight = "200px";

            $thisvalue[0] = "list";
            $thisvalue[1] = $dd_pack;
            $thisvalue[2] = "content_url";
            $thisvalue[3] = "Attachment";
            $thisvalue[4] = "";
            $thisvalue[5] = $currentval;
            $thisvalue[9] = $currentval;

            $field_id = "";

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_gallery',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item .= $divlbl_front."Attachment</font></div>
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

   case 'sclm_configurationitemtypes':

   /*

    case 'f039ef41-187a-515d-88cb-54fd6fba9ef5': # Group Types | ID: 
    case '6fde4355-a06e-0b59-064d-5500fab42774': # Purposes | ID: 
    case 'e8fba75e-14a2-2056-f4ef-550b222f36fc': # Related Events | ID: 
    case '38f9590a-4aa3-e8bb-2eba-54fd788b5fff': # Risk Types | ID: 

    case '137d6d39-765e-6804-7085-54fdd7f84a57': # Time-frames | ID: 

    case 'e72f370a-31da-30ee-d745-54fd6ac0d208': # Value Types | ID: 

    case 'dc7577bf-a51e-28bf-0c3b-54fd63a431f0': # Emotions | ID: 
    case 'a158f739-139f-4d8f-53ea-54fd7016af01': # Ethics | ID: 
    case 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe': # Importance | ID: 
    case '19896b1b-d790-88b8-a2b4-54fd6eb21986': # Monetary - B/S - Asset | ID: 
    case '5f803ea1-354c-800e-2cc7-54fd6e65da42': # Monetary - B/S - Liability | ID: 
    case 'a308ec04-abe4-8121-14bb-54fd6e6d0a00': # Monetary - General | ID: 
    case 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2': # Monetary - P & L - Expense | ID: 
    case '3566a485-0183-48a8-231b-54fd6e931b93': # Monetary - P & L - Revenue | ID: 
    case '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281': # Quantity or Amount | ID: 
    case '7c1c78c3-dfd3-0dab-f752-54fd71eb20d6': # SI Base Units | ID: 
    case '1e81858f-ba15-a8c1-fc96-54fd6e510f39': # Urgency | ID: 
    case 'b05d9585-c588-df25-98dd-55d0407b1d98': # Thought
    */

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"value_type_id\" name=\"value_type_id\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=sclm_configurationitemtypes&id=return&valuetype=$valtype&val=$val','sclm_configurationitemtypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "value_type_id";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "sclm_configurationitemtypes_id_c='e72f370a-31da-30ee-d745-54fd6ac0d208'";
      $thisvalue[5] = $value_type_id;
      $thisvalue[9] = $val;
      $field_id = $value_type_id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['ValueTypes']."</font></div>
        ".$divval_front."
         $form_object
        </div>";   


     # End Returner
     #####################
     break;
     #####################
     # SI Base Units

     case '7c1c78c3-dfd3-0dab-f752-54fd71eb20d6': //

      $fieldname = "sibaseunit_id";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "sclm_configurationitemtypes_id_c='7c1c78c3-dfd3-0dab-f752-54fd71eb20d6'";
      $thisvalue[5] = $sibaseunit_id;
      $thisvalue[9] = $val;
      $field_id = $sibaseunit_id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['SIBaseUnit']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Returner
     #####################
     break;
     #####################
     # SI Base Units

     case '840a0c9a-860e-c99b-c62e-54fd72768ccd': # Electric Current (ampere,A) | ID:
     case '584307ab-b716-aa2f-81d6-54fd738b8456': # Length (metre/meter,m) | ID: 
     case '8e5f3412-8768-14ee-ac69-54fd73d2c145': # Luminous Intensity (candela,cd) | ID: 
     case 'c180c270-c47f-2672-a606-54fd7315ebfd': # Mass (kilogram,KG) | ID: 
     case 'f2a6cd01-3b70-b501-e36e-54fd73d3fc29': # Substance Amount (mol,N) | ID: 
     case '31cf1556-08ae-95aa-e8a1-54fd732e5e43': # Temperature (kelvin,K) | ID: 
     case '6503b9a6-3644-278c-1487-54fd730e2e5d': # Time (second,s) | ID: 

     if ($id == 'f2a6cd01-3b70-b501-e36e-54fd73d3fc29'){
        $label = "Substance Amount (mol,N)";
        $definition = "The amount of substance of a system which contains as many elementary entities as there are atoms in 0.012 kilogram of carbon 12.
N";
        }

     if ($id == '8e5f3412-8768-14ee-ac69-54fd73d2c145'){
        $label = "Luminous Intensity (candela,cd)";
        $definition = "The candela is the luminous intensity, in a given direction, of a source that emits monochromatic radiation of frequency 540×1012 hertz and that has a radiant intensity in that direction of 1/683 watt per steradian.";
        }

     if ($id == '31cf1556-08ae-95aa-e8a1-54fd732e5e43'){
        $label = "Temperature (kelvin,K)";
        $definition = "The kelvin, unit of thermodynamic temperature, is the fraction 1 ⁄ 273.16 of the thermodynamic temperature of the triple point of water. This definition refers to water having the isotopic composition defined exactly by the following amount of substance ratios: 0.000 155 76 mole of 2H per mole of 1H, 0.000 379 9 mole of 17O per mole of 16O, and 0.002 005 2 mole of 18O per mole of 16O.";
        }

     if ($id == '840a0c9a-860e-c99b-c62e-54fd72768ccd'){
        $label = "Electric Current (ampere,A)";
        $definition = "The ampere is that constant current which, if maintained in two straight parallel conductors of infinite length, of negligible circular cross-section, and placed 1 metre apart in vacuum, would produce between these conductors a force equal to 2 × 10−7 newton per metre of length.";
        }

     if ($id == '6503b9a6-3644-278c-1487-54fd730e2e5d'){
        $label = "Time (second,s)";
        $definition = "The second is the duration of 9,192,631,770 periods of the radiation corresponding to the transition between the two hyperfine levels of the ground state of the caesium 133 atom. This definition refers to a caesium atom at rest at a temperature of 0 K.";
        }

     if ($id == 'c180c270-c47f-2672-a606-54fd7315ebfd'){
        $label = "Mass (kilogram,KG)";
        $definition = "The kilogram is the unit of mass (note: not the gram); it is equal to the mass of the international prototype of the kilogram.";
        }

     if ($id == '584307ab-b716-aa2f-81d6-54fd738b8456'){
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

      $form_item = $divlbl_front.$label."</font></div>
          ".$divval_front."
           $form_object $definition $hidden_object $returner
        </div>";

     # End SI Base Units
     #####################
     break;
     #####################
     # Emotions
     case 'dc7577bf-a51e-28bf-0c3b-54fd63a431f0': // Emotions

      $fieldname = "emotion_id";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "sclm_configurationitemtypes_id_c='dc7577bf-a51e-28bf-0c3b-54fd63a431f0'";
      $thisvalue[5] = $emotion_id;
      $field_id = $emotion_id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Emotions']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = $strings["Emotion"];
      $thisvalue[4] = "";
      $thisvalue[5] = $urgency;
      $field_id = $value_type_value;

      $emotions_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Emotions']." Value</font></div>
        ".$divval_front."
         $emotions_form_object $hidden_object $returner
        </div>";

     # End Emotions
     #####################
     break; // end Emotions type
     #####################
     # Urgency
     case '1e81858f-ba15-a8c1-fc96-54fd6e510f39': // Urgency

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
 
      $form_item = $divlbl_front.$strings['Urgency']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; # end Urgency type
     # End Urgency
     #####################
     # Idea Conception
     case '420a708d-8ff7-5281-f2af-557511d61cf9': # Idea Conception

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = "Idea Uniqueness";
      $thisvalue[4] = "";
      $thisvalue[5] = $value_type_value;
      $field_id = $value_type_value;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Idea Uniqueness</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; # end Idea Conception
     # End Idea Conception
     #####################
     # Thought
     case 'b05d9585-c588-df25-98dd-55d0407b1d98': # Thought

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = "Thought Weighting";
      $thisvalue[4] = "";
      $thisvalue[5] = $value_type_value;
      $field_id = $value_type_value;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Thought Weighting</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; # end Thought
     # End Thought
     #####################
     case 'c4164726-ca6e-f591-9dcf-54fd6e3b03fe': // Importance

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
 
      $form_item = $divlbl_front.$strings['Importance']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     # End Importance
     #####################
     break; // end Importance type
     #####################
     # Start Menstruation Cycle
     case '2d6007d0-e401-4cba-b973-55642a67ed16': # Menstruation

      $fieldname = "menstruation_phase_id";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "sclm_configurationitemtypes_id_c='2d6007d0-e401-4cba-b973-55642a67ed16'";
      $thisvalue[5] = $sibaseunit_id;
      $thisvalue[9] = $val;
      $field_id = $sibaseunit_id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Menstruation Cycle Stage</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = "Comfort Level";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $field_id = $value_type_value;

      $comfort_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Comfort Level</font></div>
        ".$divval_front."
         $comfort_form_object $hidden_object $returner
        </div>";

     break; # end Menstruation
     #
     #####################
     # Menstruation Phases
     /*
     case ('191da2c0-1db9-5f1c-f673-55642c5ffc8f' || 'a796188b-9215-fb17-9949-55642dbb476b'): # Menstruation Phases

      if ($id == '191da2c0-1db9-5f1c-f673-55642c5ffc8f'){
         $label = "Menstruation Begins";
         $definition = "The period or menstruation is the body's way to remove un-fertilised eggs and other non-utilised material, such as the uterus wall-lining, which is shed... Menstruation last from 5-6 days on average..";
         }

      if ($id == 'a796188b-9215-fb17-9949-55642dbb476b'){
         $label = "Menstruation Ends";
         $definition = "The period or menstruation is the body's way to remove un-fertilised eggs and other non-utilised material, such as the uterus wall-lining, which is shed... Menstruation last from 5-6 days on average..";
         }

     break; # end Menstruation Phases
     */
     #####################
     # Start Quantity
     case '7ccdcf3e-a3a3-4d09-2347-54fd6ef80281': // Quantity or Amount

      $fieldname = "value_type_value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $value_type_fieldname = "value_type_id";
      $value_type_thisvalue = $id;
      $value_type_field_id = $id;
      $hidden_value_type = $funky_gear->form_objects ($do,$next_action,$valtype,$value_type_fieldname,'hidden',$length,$textboxsize,$textareacols,$value_type_thisvalue,$value_type_field_id);


      $form_item = $divlbl_front.$strings['Quantity']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $hidden_value_type $returner
        </div>";

     # End Quantity
     #####################
     break; // end Quantity type
     #####################
     # Start Ethics

     case 'a158f739-139f-4d8f-53ea-54fd7016af01': // Ethics

      $fieldname = "ethics_id";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "sclm_configurationitemtypes_id_c='a158f739-139f-4d8f-53ea-54fd7016af01'";
      $thisvalue[5] = $ethics_id;
      $field_id = $ethics_id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front.$strings['Ethics']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "value_type_value";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "list";
      $thisvalue[1] = $funky_gear->makepositivity ();
      $thisvalue[2] = "value_type_value";
      $thisvalue[3] = "Ethics Level";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $field_id = $value_type_value;

      $comfort_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Ethics Level</font></div>
        ".$divval_front."
         $comfort_form_object $hidden_object $returner
        </div>";

     # End Ethics
     #####################
     break; // end Ethics type
     #####################
     # Start Monetary
/*
    case '19896b1b-d790-88b8-a2b4-54fd6eb21986': # Monetary - B/S - Asset | ID: 
    case '5f803ea1-354c-800e-2cc7-54fd6e65da42': # Monetary - B/S - Liability | ID: 
    case 'a308ec04-abe4-8121-14bb-54fd6e6d0a00': # Monetary - General | ID: 
    case 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2': # Monetary - P & L - Expense | ID: 
    case '3566a485-0183-48a8-231b-54fd6e931b93': # Monetary - P & L - Revenue | ID: 

*/
     case ('19896b1b-d790-88b8-a2b4-54fd6eb21986' || '5f803ea1-354c-800e-2cc7-54fd6e65da42' || 'a308ec04-abe4-8121-14bb-54fd6e6d0a00' || 'ea17b4f3-a6e8-9df1-77a3-54fd6eec87e2' || '3566a485-0183-48a8-231b-54fd6e931b93'): // Monetary

      $fieldname = "value_type_value";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'decimal',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
      /*
      $value_type_fieldname = "value_type_id";
      $value_type_thisvalue = $id;
      $value_type_field_id = $id;
      $hidden_value_type = $funky_gear->form_objects ($do,$next_action,$valtype,$value_type_fieldname,'hidden',$length,$textboxsize,$textareacols,$value_type_thisvalue,$value_type_field_id);
      */

      $fieldname = "cmn_currencies_id_c";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_currencies";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      #$thisvalue[5] = 'ddd07ef1-8ce6-2188-ae4e-5157be0c437e';
      $field_id = "cmn_currencies";

      $currency_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings['Monetary']."</font></div>
          ".$divval_front."
           $form_object 
           </div>
          ".$divlbl_front.$strings['Currency']."</font>
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
   # Event Locations
   case 'categories':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"categories\" name=\"categories\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=categories&id=return&valuetype=$valtype&val=$val','categories');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "categories";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

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
             $cat_pack[$cat_id] = $cat;

             } # for

         } # is array    

      $thisvalue[0] = "list";
      $thisvalue[1] = $cat_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "categories"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings["Category"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Categories
     #####################
     break;
     case ($id != 'return'):
     #####################
     # 

      $fieldname = "category_id";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItemTypes";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id."' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "categories"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown_jaxer';

         } else {# is array    

         $cat_object_type = "ConfigurationItemTypes";
         $cat_action = "select";
         $cat_params[0] = " deleted=0 && id='".$id."' ";
         $cat_params[1] = "id,name,description"; // select array
         $cat_params[2] = ""; // group;
         $cat_params[3] = "name ASC"; // order;
         $cat_params[4] = ""; // limit

         $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

         if (is_array($cat_items)){

            for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                $cat_id = $cat_items[$cnt]['id'];
                $cat = $cat_items[$cnt]['name'];
                $cat_pack[$cat_id] = $cat;

                } # for

            } # is array

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "categories"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown';

         } 

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,$dropdowner,$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings["Category"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # 
     #####################
     break; // any 

    } // end id switch for sfx_valuetypes

   # End value types
   #####################
   break;
   #####################
   # Event Contacts
   case 'recipient_types':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"recipient_types\" name=\"recipient_types\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=recipient_types&id=return&valuetype=$valtype&val=$val','recipient_types');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': # return

      $fieldname = "recipient_types";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $dd_pack = "";
      $dd_pack = array();

      $dd_pack = $funky_messaging->message_recipient_selections();

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "recipient_types"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Event Contacts</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Returner
     #####################
     break;
     case ($id != 'return'):

      $msg_params[0] = $id;
      $msg_params[1] = "recipient_types";
      $msg_params[2] = $do;
      $msg_params[3] = $action;
      $msg_params[4] = $next_action;
      $msg_params[5] = $valtype;
      $msg_params[6] = $val;

      $form_item = $funky_messaging->message_recipient_builder($msg_params);      

     break;

    } // end id switch for 

   # End value types
   #####################
   break;
   #####################
   # Event title
   case 'title':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"title\" name=\"title\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=title&id=return&valuetype=$valtype&val=$val','title');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "name";
      $textboxsize = 60;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $data = array("alpaca", "buffalo", "cat", "tiger");
      $date = json_encode($data);

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= "<script src=\"//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>
  <script src=\"js/auto-complete.js\"></script>";

      $form_item .= $divlbl_front.$strings['Title']."</font></div>
        ".$divval_front."
         $form_object";

     break;

    } # end switch

   break;
   #####################
   # Event Locations
   case 'locations':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"locations\" name=\"locations\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=locations&id=return&valuetype=$valtype&val=$val','locations');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "locations";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $loc_pack[1] = "Create New Location";
      $loc_pack[2] = "Use Existing Location";

      $thisvalue[0] = "list";
      $thisvalue[1] = $loc_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = ""; // Exceptions
      $thisvalue[5] = $locations; // Current Value
      $thisvalue[6] = "";
      $thisvalue[7] = "locations"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = $locations;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
      $form_item = $divlbl_front."Location</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     break;
     case 1: # Create New

      $fieldname = "store_location";
      $textboxsize = 60;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = 1;
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Store Location?</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "share_location";
      $textboxsize = 60;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = 1;
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front."Share Location?</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "location";
      $textboxsize = 60;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Location']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "event_url";
      $textboxsize = 60;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['EventURL']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "latitude";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = $latitude;
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Latitude']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "longitude";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = $longitude;
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Longitude']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "street";
      $textboxsize = 50;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Street']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "city";
      $textboxsize = 30;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['City']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "state";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['State']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "cmn_countries_id_c";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "cmn_countries";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = ""; // Exceptions
      $thisvalue[5] = $cmn_countries_id_c; // Current Value
      $thisvalue[6] = 'Countries';
      $thisvalue[7] = "cmn_countries"; // list reltablename
      $thisvalue[8] = 'Countries'; //new do
      $thisvalue[9] = "";

      $field_id = $cmn_countries_id_c;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Country']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

      $fieldname = "zip";
      $textboxsize = 20;
      $textareacols = 9;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item .= $divlbl_front.$strings['Zip']."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

     break;
     case 2: # Use Existing

      # Find available - selection should be initially limited if none exist
      # Existing ones could be owned or public
      # Search for location wrappers first CIs - sub-parts will be children of the CI
      $locations_cit = "a6961896-8520-6458-f8a0-5500ecc82857";
      $location_query = " sclm_configurationitemtypes_id_c='".$locations_cit."' ";

      $ci_object_type = "ConfigurationItems";

      if ($auth == 3){
         $ci_params[0] = $location_query;
         } elseif ($auth == 2){
         $ci_params[0] = $location_query." && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ";
         } else {
         $ci_params[0] = $location_query." && (cmn_statuses_id_c != '".$standard_statuses_closed."' || contact_id_c='".$sess_contact_id."') ";
         }

      $ci_action = "select";
      $ci_params[1] = "id,name,date_entered,account_id_c"; // select array
      $ci_params[2] = ""; // group;
      $ci_params[3] = " name, date_entered DESC "; // order;
      $ci_params[4] = ""; // limit

      $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

      if (is_array($ci_items)){    

         for ($cnt=0;$cnt < count($ci_items);$cnt++){

             $location_wrapper_id = $ci_items[$cnt]['id'];
             $location_wrapper_name = $ci_items[$cnt]['name'];

             # Build selection list 
             $location_list[$location_wrapper_id] = $location_wrapper_name;

             } # for

         $fieldname = "location_id";
         $textareacols = "";
         $textboxsize = "";
         $length = "";
         $formobjectheight = "50px";

         $thisvalue[0] = "list";
         $thisvalue[1] = $location_list;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $location_id;
         $thisvalue[6] = "";
         $thisvalue[7] = "locations";
         $thisvalue[8] = "";
         $thisvalue[9] = "";

         $field_id = $location_id;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);
 
         $form_item = $divlbl_front.$strings['Location']."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         } else {# is array

         # No locations available - show manual

         $fieldname = "store_location";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = 1;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front."Store Location?</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "share_location";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = 1;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front."Share Location?</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "location";
         $textboxsize = 20;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Location']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "event_url";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['EventURL']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "latitude";
         $textboxsize = 40;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $latitude;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Latitude']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "longitude";
         $textboxsize = 40;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $latitude;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Longitude']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "street";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Street']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "city";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['City']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "state";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['State']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "cmn_countries_id_c";
         $textareacols = "";
         $textboxsize = "";
         $length = "";
         $formobjectheight = "50px";

         $thisvalue[0] = "db";
         $thisvalue[1] = "cmn_countries";
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = ""; // Exceptions
         $thisvalue[5] = $cmn_countries_id_c; // Current Value
         $thisvalue[6] = 'Countries';
         $thisvalue[7] = "cmn_countries"; // list reltablename
         $thisvalue[8] = 'Countries'; //new do
         $thisvalue[9] = "";

         $field_id = $cmn_countries_id_c;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Country']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "zip";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);


         $form_item .= $divlbl_front.$strings['Zip']."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         } 

     break;
     case ($id != 'return' && $id != 1 && $id != 2): # Use Existing

      # Anything else will be a location wrapper ID

      $city_cit = "8c3069fc-53d0-ec7e-12c8-5500ed6023c0";
      $country_cit = "a73167d6-3a49-50a1-a701-5500ed03f14c";
      $event_url_cit = "5cc37cdb-9e6b-b5c4-9a9d-550c5af2afb1";
      $latitude_cit = "92e5c9b0-c016-305c-b25d-5500ed1511ae";
      $longitude_cit = "6937587f-b655-3954-1641-5500ed1bf0e9";
      $state_cit = "6dea2c99-7b16-e6f3-2023-5500edf2dc7c";
      $zip_cit = "e367d79e-9bed-119f-1f8d-5500ed5339d7";
      $street_cit = "4f3a85bd-0a6a-7325-9016-550c775b2e70";

      $location_query = " sclm_configurationitems_id_c='".$id."' && (sclm_configurationitemtypes_id_c='".$city_cit."' || sclm_configurationitemtypes_id_c='".$country_cit."' || sclm_configurationitemtypes_id_c='".$event_url_cit."' || sclm_configurationitemtypes_id_c='".$latitude_cit."' || sclm_configurationitemtypes_id_c='".$longitude_cit."' || sclm_configurationitemtypes_id_c='".$state_cit."' || sclm_configurationitemtypes_id_c='".$zip_cit."' || sclm_configurationitemtypes_id_c='".$street_cit."') ";

      $ci_object_type = "ConfigurationItems";
      $ci_params[0] = $location_query;
      $ci_action = "select";
      $ci_params[1] = "id,name,date_entered,contact_id_c,account_id_c,sclm_configurationitemtypes_id_c"; // select array
      $ci_params[2] = ""; // group;
      $ci_params[3] = " name, date_entered DESC "; // order;
      $ci_params[4] = ""; // limit

      $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

      if (is_array($ci_items)){    

         for ($cnt=0;$cnt < count($ci_items);$cnt++){

             $ci_id = $ci_items[$cnt]['id'];
             $name = $ci_items[$cnt]['name'];
             $cit_id = $ci_items[$cnt]['sclm_configurationitemtypes_id_c'];
             $record_owner = $ci_items[$cnt]['contact_id_c'];

             if ($cit_id == $event_url_cit){
                $event_url = $name;
                } # if event_url

             if ($cit_id == $latitude_cit){
                $latitude = $name;
                } # if latitude

             if ($cit_id == $longitude_cit){
                $longitude = $name;
                } # if longitude

             if ($cit_id == $street_cit){
                $street = $name;
                } # if street

             if ($cit_id == $city_cit){
                $city = $name;
                } # if city

             if ($cit_id == $state_cit){
                $state = $name;
                } # if state

             if ($cit_id == $country_cit){
                $cmn_countries_id_c = $name;
                } # if Country
 
             if ($cit_id == $zip_cit){
                $zip = $name;
                } # zip

             } # for

         # Get location name (wrapper)

         $ci_object_type = "ConfigurationItems";
         $ci_params[0] = "id='".$id."' ";
         $ci_action = "select";
         $ci_params[1] = "id,name,date_entered,account_id_c"; // select array
         $ci_params[2] = ""; // group;
         $ci_params[3] = " name, date_entered DESC "; // order;
         $ci_params[4] = ""; // limit

         $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

         if (is_array($ci_items)){    

            for ($cnt=0;$cnt < count($ci_items);$cnt++){

                #$location_wrapper_id = $ci_items[$cnt]['id'];
                $location = $ci_items[$cnt]['name'];

                } # for

            } # is array

         if ($sess_contact_id == $record_owner || $auth == 3){

            # Add the wrapper ID to make updates - provide comment

            $fieldname = "location_id";
            $textboxsize = 60;
            $textareacols = 9;
            $length = "";
            $formobjectheight = "50px";

            $thisvalue = $id;
            $field_id = $thisvalue;

            $location_id_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'hidden',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $fieldname = "share_location";
            $textboxsize = 60;
            $textareacols = 9;
            $length = "";
            $formobjectheight = "50px";

            $thisvalue = 0;
            $field_id = $thisvalue;

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item .= $divlbl_front."Share Location?</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

            $fieldname = "update_location";
            $textboxsize = 60;
            $textareacols = 9;
            $length = "";
            $formobjectheight = "50px";

            $thisvalue = "";
            $field_id = $thisvalue;

            $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'yesno',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

            $form_item .= $divlbl_front."Update Location?</font></div>
        ".$divval_front."
         $form_object $location_id_form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

            } # if session owner

         $fieldname = "location";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $location;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Location']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "event_url";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $event_url;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['EventURL']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "latitude";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $latitude;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Latitude']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "longitude";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $longitude;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Longitude']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "street";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $street;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Street']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "city";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $city;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['City']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "state";
         $textboxsize = 60;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $state;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['State']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "cmn_countries_id_c";
         $textboxsize = 20;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = "";
         $thisvalue[0] = "db";
         $thisvalue[1] = "cmn_countries";
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         if ($auth == 3){
            $thisvalue[4] = ""; // Exceptions
            } else {
            $thisvalue[4] = "id='".$cmn_countries_id_c."'"; // Exceptions
            } 
         $thisvalue[5] = $cmn_countries_id_c; // Current Value
         $thisvalue[6] = 'Countries';
         $thisvalue[7] = "cmn_countries"; // list reltablename
         $thisvalue[8] = 'Countries'; //new do
         $thisvalue[9] = "";

         $object_bits[0] = "id,name";
         $primary = "";

         $field_id = $cmn_countries_id_c;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary,$object_bits);

         $form_item .= $divlbl_front.$strings['Country']."</font></div>
        ".$divval_front."
         $form_object
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         $fieldname = "zip";
         $textboxsize = 20;
         $textareacols = 9;
         $length = "";
         $formobjectheight = "50px";

         $thisvalue = $zip;
         $field_id = $thisvalue;

         $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

         $form_item .= $divlbl_front.$strings['Zip']."</font></div>
        ".$divval_front."
         $form_object $hidden_object<BR> $returner
        </div><BR><img src=images/blank.gif width=98% height=1><BR>";

         } # is array
      
     break; # end for locations

    } # switch

   break;

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
 
      $form_item = $divlbl_front."Industry</font></div>
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
 
      $form_item = $divlbl_front."Industry</font></div>
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
 
      $form_item = $divlbl_front."External Source Type</font></div>
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

      $form_item = $divlbl_front."External Source Type</font></div>
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

      $form_item .= $divlbl_front."Pre-register SugarCRM Projects Object?</font></div>
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

      $form_item .= $divlbl_front."Pre-register SugarCRM Project Tasks Object?</font></div>
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

      $form_item .= $divlbl_front."Pre-register SugarCRM Opportunities Object?</font></div>
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
 
      $form_item = $divlbl_front.$strings['Image']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Image']."</font></div>
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
 case 'AccountsServices':
 case 'Services':

#foreach ($_GET as $key=>$value){
#echo "Field: ".$key." - Value: ".$value."<BR>";
#} // end for post each 

  $tbl = $_GET['tbl'];

  switch ($tbl){

   case 'sclm_configurationitemtypes':

    $id = $_GET['id'];

    $service_type = $_GET['service_type'];
    if (!$service_type){
       $service_type = $_POST['service_type'];
       }

    $hidden_object = "<input type=\"hidden\" id=\"sclm_configurationitemtypes\" name=\"sclm_configurationitemtypes\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=$tbl&id=return&valuetype=$valtype&value=$val','sclm_configurationitemtypes');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    switch ($id){

     #####################
     # Start Returner

     case 'return': // re-do

      $fieldname = "product_selection";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $thisvalue[0] = "db";
      $thisvalue[1] = "sclm_configurationitemtypes";
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      #$thisvalue[4] = " sclm_configurationitemtypes_id_c='a6e4ed9d-a63f-d23e-e787-54f82a7a4548' ORDER BY name ASC";
      #$thisvalue[4] = "  sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9' ORDER BY name ASC";
      $thisvalue[4] = " (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL' ORDER BY name ASC ";//$exception;

      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front."Product Type</font></div>
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
      $thisvalue[4] = " sclm_configurationitemtypes_id_c='".$id."'  ORDER BY name ASC ";
      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $field_id = $id;

      $par_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

      $form_item = $divlbl_front."Parent Service Type</font></div>
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
      $thisvalue[4] = " sclm_configurationitemtypes_id_c='".$id."' && sclm_configurationitems_id_c IS NOT NULL";
      $thisvalue[5] = $service_type;
      $thisvalue[9] = $service_type;

      $field_id = $service_type;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item .= $divlbl_front."Child Service Type</font></div>
        ".$divval_front."
        $form_object
        </div>";   

     break;

    } // id switch

   break; // end sclm_configurationitemtypes
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
      #$thisvalue[4] = " sclm_configurationitems_id_c='a6e4ed9d-a63f-d23e-e787-54f82a7a4548' ORDER BY name ASC";
      $thisvalue[4] = "  sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9' ORDER BY name ASC";
      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $field_id = $id;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);
 
      $form_item = $divlbl_front."Parent Service Type</font></div>
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
      $thisvalue[4] = " id='".$id."'  ORDER BY name ASC ";
      $thisvalue[5] = $id;
      $thisvalue[9] = $id;

      $field_id = $id;

      $par_form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id,$primary_id);

      $form_item = $divlbl_front."Parent Service Type</font></div>
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
 
      $form_item .= $divlbl_front."Child Service Type</font></div>
        ".$divval_front."
        $form_object
        </div>";   

     break;

    } // id switch

   break;
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
 
      $form_item = $divlbl_front.$strings['Image']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Image']."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";   

     break;

    } // id switch

   break; // end images
   case 'lifestyle_category':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"lifestyle_category\" name=\"lifestyle_category\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=lifestyle_category&id=return&valuetype=$valtype&val=$val','lifestyle_category');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "lifestyle_category";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

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
             $cat_pack[$cat_id] = $cat;

             } # for

         } # is array    

      $thisvalue[0] = "list";
      $thisvalue[1] = $cat_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "lifestyle_category"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings["Category"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Monetary
     #####################
     break;
     case ($id != 'return'):
     #####################
     # 

      $fieldname = "lifestyle_category";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItemTypes";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$id."' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "lifestyle_category"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown_jaxer';

         } else {# is array    

         $cat_object_type = "ConfigurationItemTypes";
         $cat_action = "select";
         $cat_params[0] = " deleted=0 && id='".$id."' ";
         $cat_params[1] = "id,name,description"; // select array
         $cat_params[2] = ""; // group;
         $cat_params[3] = "name ASC"; // order;
         $cat_params[4] = ""; // limit

         $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

         if (is_array($cat_items)){

            for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                $cat_id = $cat_items[$cnt]['id'];
                $cat = $cat_items[$cnt]['name'];
                $cat_pack[$cat_id] = $cat;

                } # for

            } # is array

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "lifestyle_category"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown';

         } 

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,$dropdowner,$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front.$strings["Category"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     break;

    } // id switch

   # 
   #####################
   break; // any 
   case 'parent_service_type':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"parent_service_type\" name=\"parent_service_type\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=parent_service_type&id=return&valuetype=$valtype&val=$val','parent_service_type');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "parent_service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItems";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         } # is array    

      $thisvalue[0] = "list";
      $thisvalue[1] = $cat_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "parent_service_type"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Parent Service Type</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Monetary
     #####################
     break;
     case ($id != 'return'):
     #####################
     # 

      $fieldname = "parent_service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItems";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && sclm_configurationitems_id_c='".$id."' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "parent_service_type"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown_jaxer';

         } else {# is array    

         $cat_object_type = "ConfigurationItems";
         $cat_action = "select";
         $cat_params[0] = " id='".$id."' ";
         $cat_params[1] = "sclm_configurationitems_id_c"; // select array
         $cat_params[2] = ""; // group;
         $cat_params[3] = "name ASC"; // order;
         $cat_params[4] = ""; // limit

         $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

         if (is_array($cat_items)){

            for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                $sclm_configurationitems_id_c = $cat_items[$cnt]['sclm_configurationitems_id_c'];

                $cat_object_type = "ConfigurationItems";
                $cat_action = "select";
                $cat_params[0] = " id='".$sclm_configurationitems_id_c."' ";
                $cat_params[1] = "id,name,description"; // select array
                $cat_params[2] = ""; // group;
                $cat_params[3] = "name ASC"; // order;
                $cat_params[4] = ""; // limit

                $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

                if (is_array($cat_items)){

                   for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                       $cat_id = $cat_items[$cnt]['id'];
                       $cat = $cat_items[$cnt]['name'];

                       $cat_pack[$cat_id] = $cat;

                       } # for

                   } # is array

                } # for

            } # is array

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "parent_service_type"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown';

         } 

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,$dropdowner,$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Parent Service Type</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # 
     #####################
     break; // any 

    } // end id switch for service_type

   # End value types
   #####################
   break;
   case 'service_type':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"service_type\" name=\"service_type\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=$do&action=$action&tbl=service_type&id=return&valuetype=$valtype&val=$val','service_type');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': // re-do

      $fieldname = "service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItems";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && sclm_configurationitems_id_c='NULL' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         } # is array    

      $thisvalue[0] = "list";
      $thisvalue[1] = $cat_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "service_type"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Service Type</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Monetary
     #####################
     break;
     case ($id != 'return'):
     #####################
     # 

      $fieldname = "service_type";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $cat_object_type = "ConfigurationItems";
      $cat_action = "select";
      $cat_params[0] = " deleted=0 && sclm_configurationitems_id_c='".$id."' ";
      $cat_params[1] = "id,name,description"; // select array
      $cat_params[2] = ""; // group;
      $cat_params[3] = "name ASC"; // order;
      $cat_params[4] = ""; // limit

      $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

      if (is_array($cat_items)){

         for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
             $cat_id = $cat_items[$cnt]['id'];
             $cat = $cat_items[$cnt]['name'];
             $cat_pack[$cat_id] = $cat;

             } # for

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "service_type"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown_jaxer';

         } else {# is array    

         $cat_object_type = "ConfigurationItems";
         $cat_action = "select";
         $cat_params[0] = " deleted=0 && id='".$id."' ";
         $cat_params[1] = "id,name,description"; // select array
         $cat_params[2] = ""; // group;
         $cat_params[3] = "name ASC"; // order;
         $cat_params[4] = ""; // limit

         $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

         if (is_array($cat_items)){

            for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                $cat_id = $cat_items[$cnt]['id'];
                $cat = $cat_items[$cnt]['name'];
                $cat_pack[$cat_id] = $cat;

                } # for

            } # is array

         $thisvalue[0] = "list";
         $thisvalue[1] = $cat_pack;
         $thisvalue[2] = "id";
         $thisvalue[3] = "name";
         $thisvalue[4] = "";
         $thisvalue[5] = $id;
         $thisvalue[6] = "";
         $thisvalue[7] = "service_type"; // list reltablename
         $thisvalue[8] = ""; //new do
         $thisvalue[9] = $id;
         $field_id = $id;

         $dropdowner = 'dropdown';

         $cat_object_type = "ConfigurationItems";
         $cat_action = "select";
         $cat_params[0] = " id='".$id."' ";
         $cat_params[1] = "sclm_configurationitems_id_c"; // select array
         $cat_params[2] = ""; // group;
         $cat_params[3] = "name ASC"; // order;
         $cat_params[4] = ""; // limit

         $cat_items = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $cat_object_type, $cat_action, $cat_params);

         if (is_array($cat_items)){

            for ($cnt=0;$cnt < count($cat_items);$cnt++){
 
                $sclm_configurationitems_id_c = $cat_items[$cnt]['sclm_configurationitems_id_c'];

                } # for

            } # array

         } 

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,$dropdowner,$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $parent_service_type = "<input type=\"hidden\" id=\"parent_service_type\" name=\"parent_service_type\" value=\"$sclm_configurationitems_id_c\">";

      $form_item = $divlbl_front."Service Type</font></div>
        ".$divval_front."
         $form_object $hidden_object $parent_service_type <BR>$returner
        </div>";

     # 
     #####################
     break; // any 

    } // end id switch for service_type

   # End value types
   #####################
   break;

  } // end tables switch;

  # End Tables for 
  #####################

 break; // end Services
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
 
      $form_item = $divlbl_front.$strings['Credits']."</font></div>
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

      for ($list=1;$list < 10000;$list++){
    
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
 
      $form_item = $divlbl_front.$strings['Credits']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Country']."</font></div>
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
 
        $form_item = $divlbl_front.$strings['Country']."</font></div>
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
 case 'SocialNetworking':

  $tbl = $_GET['tbl'];

  #####################
  # Effects Tables

  switch ($tbl){

   case 'recipient_types':

    $id = $_GET['id'];

    $hidden_object = "<input type=\"hidden\" id=\"recipient_types\" name=\"recipient_types\" value=\"$id\">";
    $returner = "<a href=\"#\" onClick=\"getjax('getjax.php?do=Effects&action=$action&tbl=recipient_types&id=return&valuetype=$valtype&val=$val','recipient_types');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

    #####################
    # Table ID

    switch ($id){

     #####################
     # Returner

     case 'return': # return

      $fieldname = "recipient_types";
      $textareacols = "";
      $textboxsize = "";
      $length = "";
      $formobjectheight = "50px";

      $dd_pack = "";
      $dd_pack = array();

      $dd_pack = $funky_messaging->message_recipient_selections();

      $thisvalue[0] = "list";
      $thisvalue[1] = $dd_pack;
      $thisvalue[2] = "id";
      $thisvalue[3] = "name";
      $thisvalue[4] = "";
      $thisvalue[5] = "";
      $thisvalue[6] = "";
      $thisvalue[7] = "recipient_types"; // list reltablename
      $thisvalue[8] = ""; //new do
      $thisvalue[9] = "";

      $field_id = "";

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'dropdown_jaxer',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_item = $divlbl_front."Contacts</font></div>
        ".$divval_front."
         $form_object $hidden_object <BR>$returner
        </div>";

     # End Returner
     #####################
     break;
     case ($id != 'return'):

      $msg_params[0] = $id;
      $msg_params[1] = "recipient_types";
      $msg_params[2] = $do;
      $msg_params[3] = $action;
      $msg_params[4] = $next_action;
      $msg_params[5] = $valtype;
      $msg_params[6] = $val;

      $form_item = $funky_messaging->message_recipient_builder($msg_params);      

     break;

    } // end id switch for 

   # End value types
   #####################
   break;

  } // end tables switch;

 break;
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
 
      $form_item = $divlbl_front."Source Objects</font></div>
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

      $form_item = $divlbl_front."Sugar Module:</font></div>
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
 
      $form_item = $divlbl_front."Source Objects</font></div>
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
 
      $form_item = $divlbl_front."Related Type</font></div>
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
 
      $form_item = $divlbl_front.$strings['Action']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Effect']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Causes']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Event']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Governments']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['PoliticalParty']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['GovernmentConstitution']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['ConstitutionalArticle']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['ConstitutionalAmendment']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Bill']."</font></div>
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
 
      $form_item = $divlbl_front.$strings['Statute']."</font></div>
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
