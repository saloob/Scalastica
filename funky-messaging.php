<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-19
# Page: funky-messaging.php 
##########################################################

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

  if (!function_exists('api_sugar')){
     include ("api-sugarcrm.php");
     }

  if (!class_exists('funky')){
     include ("funky.php");
     $funky_gear = new funky ();   
     }

class funky_messaging {

 #
 ###################################
 # 

 function message_recipient_selections (){

  global $strings,$sess_contact_id,$sess_account_id,$fb_session,$gg_session,$li_session;

  #$msg_object = $msg_params[0];
  #$msg_action = $msg_params[1];
  #$msg_title = $msg_params[2];
  #$msg_body = $msg_params[3];

  ############################################################
  # Messaging | ID: 4c1f71f9-7e84-964c-7cc8-555a9b6fa1d7
  ############################################################
  # Account Contacts | ID: 821d3058-e575-b6fa-c3bb-5559de9489ce
  # Email Contacts | ID: d8ba0615-94b3-78a5-51e4-5559de992b1c
  # Facebook Contacts | ID: 2e465f2e-57db-e22d-0b7c-5559e0aaeeaf
  # Facebook Post | ID: 8718bbf3-bf47-a358-21c7-555aa3a9cce8
  # Google Contacts | ID: 54cf2e2f-a525-85d0-ceff-5559e04f44f2
  # Google+ Post | ID: ea3bfead-baf4-8133-8e3b-555aa3b66c6a
  # LinkedIn Contacts | ID: 18a8e733-f0e1-32a2-d5b3-5559e087dffb
  # LinkedIn Post | ID: 4facb76a-e1f6-e73f-ac38-555aa36978fb
  # Personal Social Network Contacts | ID: 7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e
  # Social Network Contacts | ID: 33485c3e-4814-12a5-5a38-5559e204e411
  ############################################################

  if ($fb_session != NULL){

     # Un-comment this when facebook has allowed access to friends
     #$dd_pack['2e465f2e-57db-e22d-0b7c-5559e0aaeeaf'] = "Select Facebook Friend(s)";
     $dd_pack['8718bbf3-bf47-a358-21c7-555aa3a9cce8'] = "Post to Facebook";

     }

  if ($gg_session != NULL){
     $dd_pack['54cf2e2f-a525-85d0-ceff-5559e04f44f2'] = "Select Google Contact(s)";
     $dd_pack['ea3bfead-baf4-8133-8e3b-555aa3b66c6a'] = "Post to Google+";
     }

  if ($li_session != NULL){
     $dd_pack['18a8e733-f0e1-32a2-d5b3-5559e087dffb'] = "Select LinkedIn Contact(s)";
     $dd_pack['4facb76a-e1f6-e73f-ac38-555aa36978fb'] = "Post to LinkedIn";
     }

  if ($sess_contact_id != NULL){
     $dd_pack['821d3058-e575-b6fa-c3bb-5559de9489ce'] = "Account Contact(s)";
     $dd_pack['d8ba0615-94b3-78a5-51e4-5559de992b1c'] = "Add Email Contact(s)";
     $dd_pack['7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e'] = "My Private Connection(s)";
     $dd_pack['33485c3e-4814-12a5-5a38-5559e204e411'] = "My Social Network Contact(s)";
     }

  return $dd_pack;

 } # end function message_recipient_selections

 #
 ###################################
 # 

 function message_recipient_builder ($msg_params){

  global $funky_gear,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$strings,$sess_contact_id,$sess_account_id,$fb_session,$gg_session,$li_session,$portal_title,$portal_header_colour,$portal_body_colour,$portal_footer_colour,$portal_border_colour,$portal_font_colour;

  $recipient_type = $msg_params[0];
  $type_field = $msg_params[1];
  $do = $msg_params[2];
  $action = $msg_params[3];
  $next_action = $msg_params[4];
  $valtype = $msg_params[5];
  $val = $msg_params[6];

  $hidden_object = "<input type=\"hidden\" id=\"".$type_field."\" name=\"".$type_field."\" value=\"".$recipient_type."\">";
  $returner = "<a href=\"#\" onClick=\"loader('".$type_field."');getjax('getjax.php?do=".$do."&action=".$action."&tbl=".$type_field."&id=return&valuetype=".$valtype."&value=".$val."','".$type_field."');return false\"><img src=images/DirUp.gif border=0 alt='".$strings["Return"]."'>".$strings["Return"]."</a>";

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

  $multiple_contacts = "";

  switch ($recipient_type){

     #####################
     case '821d3058-e575-b6fa-c3bb-5559de9489ce': # Shared Effects Account Contacts

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

             $multiple_contacts .= $contact_id.",";

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

         $form_object .= "<BR><font size=2><B>You do not have any other contacts in your account, please select another method.</B></font>";

         } 

      $form_item = $divlbl_front."".$portal_title. "Contacts </font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     #####################
     case '12db0c6d-cc58-cbef-c092-555ad724ebd7': # Contact Me!

      # When the profile or object contact me link appears to send a message

     break;
     #####################
     case 'd8ba0615-94b3-78a5-51e4-5559de992b1c': # Event Email Contacts

      $fieldname = "email_contacts";
      $textboxsize = 50;
      $textareacols = 50;
      $length = "";
      $formobjectheight = "50px";

      $thisvalue = "";
      $field_id = $thisvalue;

      $form_object = $funky_gear->form_objects ($do,$next_action,$valtype,$fieldname,'varchar',$length,$textboxsize,$textareacols,$thisvalue,$field_id);

      $form_object .= "<BR><font size=2><B>An email will be sent to this recipient...</B></font>";

      $form_item = $divlbl_front."Email Contacts</font></div>
          ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     #####################
     case '2e465f2e-57db-e22d-0b7c-5559e0aaeeaf': # Event Facebook friends

      require_once ("api-facebook.php");      

      $fb_params[0] = "taggable_friends"; #fb_action;
      $fb_params[1] = $fb_session; # userid

      $fbfriends = do_facebook ($fb_params);

      #var_dump($fbfriends);
      #exit;

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

         } else { // is array uid

         $form_object .= "<BR><font size=2><B>Your Facebook friends are not available, please select another method.</B></font>";

         } 
 
      $form_item = $divlbl_front."Facebook ".$strings["Contact"]."</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break;
     #####################
     # Post moment to Facebook
     case '8718bbf3-bf47-a358-21c7-555aa3a9cce8':

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
      
     break;  # End Post to Facebook
     #####################
     case '54cf2e2f-a525-85d0-ceff-5559e04f44f2': # Event Google Contacts

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
     #####################
     case 'ea3bfead-baf4-8133-8e3b-555aa3b66c6a': # Google+ Moment

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
      
     break; # End Post moment to Google+
     #####################
     case '18a8e733-f0e1-32a2-d5b3-5559e087dffb': # Event LinkedIn Contacts

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
     #####################
     case '4facb76a-e1f6-e73f-ac38-555aa36978fb':  # Post to LinkedIn

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
      
     break; # End Post to LinkedIn
     #####################
     case '7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e': # Shared Effects Personal Social Network Contacts

      # My Private Connections: 24ac8d1e-9a9a-4f88-98c9-55500353563d 
      $ci_object_type = "ConfigurationItems";
      $ci_action = "select";
      $ci_params[0] = " deleted=0 && (contact_id_c='".$sess_contact_id."' || name='".$sess_contact_id."') && sclm_configurationitemtypes_id_c='24ac8d1e-9a9a-4f88-98c9-55500353563d'";
      $ci_params[1] = ""; // select array
      $ci_params[2] = ""; // group;
      $ci_params[3] = ""; // order;
      $ci_params[4] = ""; // limit
  
      $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

      if (is_array($ci_items)){

         for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
             $id = $ci_items[$cnt]['id'];
             $name = $ci_items[$cnt]['name'];
             $contact_id_c = $ci_items[$cnt]['contact_id_c'];

             if ($name != $sess_contact_id){
                $friend_contact_id = $name;
                }

             if ($contact_id_c != $sess_contact_id){
                $friend_contact_id = $contact_id_c;
                }

             if ($friend_contact_id != NULL){

                $multiple_contacts .= $friend_contact_id.",";

                $anonymity_params[0] = $friend_contact_id;
                $anonymity_params[1] = "";
                $anonymity_params[2] = $sess_contact_id;
                $anonymity_params[3] = $sess_account_id;
                $anonymity_params[4] = $do;
                $anonymity_params[5] = $valtype;
                $anonymity_params[6] = $val;

                $profile_info = $funky_gear->anonymity($anonymity_params);

                $anonymity_name = $profile_info[0];
                $description = $profile_info[1];
                $profile_photo = $profile_info[2];
                $contact_profile = $profile_info[3];
                $anonymity_names = $profile_info[4]; # all types embedded in array

                $check_object_type = "Contacts";
                $check_action = "get_contact_email";
                $check_params = "";
                $check_params = $friend_contact_id; // query

                $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_object_type, $check_action, $check_params);

                $ddvalue[0] = $anonymity_name;

                if (!$profile_photo){
                   $profile_photo = "images/blank.gif";
                   }

                $ddvalue[1] = $profile_photo;#$image;
                $ddvalue[2] = ""; # Content
                $ddvalue[3] = ""; #$checkstate;
                $ddvalue[4] = ""; #$country;
                $dd_pack[$email] = $ddvalue;

                } # if friend

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

         $form_object .= "<BR><font size=2<B>This message will be posted to your selected ".$portal_title." Connections</B></font>";

         } else {# is array

         $form_object .= "<BR><font size=2><B>You do not have any private connections, please select another method.</B></font>";

         } 

      $form_item = $divlbl_front."".$portal_title. "Connections </font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";
 
     break;
     #####################
     case '33485c3e-4814-12a5-5a38-5559e204e411': # Social Network Contacts 

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

      if (is_array($dd_pack)){

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

         } else {

         $form_object .= "<BR><font size=2><B>You have not yet joined any Social Networks - please select another method.</B></font><BR>";

         }  

      $form_item = $divlbl_front."Social Network</font></div>
        ".$divval_front."
         $form_object $hidden_object $returner
        </div>";

     break; # 
     #####################

    } // end id switch for

  if ($multiple_contacts != NULL){

     $form_item .= "<input type=\"hidden\" id=\"multiple_contacts\" name=\"multiple_contacts\" value=\"".$multiple_contacts."\">";

     }

  return $form_item;

 } # end function message_recipients

 #
 ###################################
 # 

  ############################################################
  # Messaging | ID: 4c1f71f9-7e84-964c-7cc8-555a9b6fa1d7
  ############################################################
  # Account Contacts | ID: 821d3058-e575-b6fa-c3bb-5559de9489ce
  # Email Contacts | ID: d8ba0615-94b3-78a5-51e4-5559de992b1c
  # Facebook Contacts | ID: 2e465f2e-57db-e22d-0b7c-5559e0aaeeaf
  # Facebook Post | ID: 8718bbf3-bf47-a358-21c7-555aa3a9cce8
  # Google Contacts | ID: 54cf2e2f-a525-85d0-ceff-5559e04f44f2
  # Google+ Post | ID: ea3bfead-baf4-8133-8e3b-555aa3b66c6a
  # LinkedIn Contacts | ID: 18a8e733-f0e1-32a2-d5b3-5559e087dffb
  # LinkedIn Post | ID: 4facb76a-e1f6-e73f-ac38-555aa36978fb
  # Personal Social Network Contacts | ID: 7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e
  # Social Network Contacts | ID: 33485c3e-4814-12a5-5a38-5559e204e411
  ############################################################

 function message_delivery ($msg_params){

  global $funky_gear,$strings,$lingo,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$crm_api_user2,$crm_api_pass2,$crm_wsdl_url2,$sess_contact_id,$sess_account_id,$fb_session,$gg_session,$li_session,$portal_title,$portal_email,$portal_email_password,$portal_email_server,$portal_email_smtp_port,$portal_email_smtp_auth,$assigned_user_id,$hostname,$standard_statuses_closed;

  $from_name = $portal_title;
  $from_email = $portal_email;
  $from_email_password = $portal_email_password;

  $ZAPOST = $msg_params[0];
  $message_title = $msg_params[1];
  $message_body = $msg_params[2];
  $message_link = $msg_params[3];
  $message_image = $msg_params[4];
  $do = $msg_params[5];
  $action = $msg_params[6];
  $valtype = $msg_params[7];
  $val = $msg_params[8];
  $extra_msg_params = $msg_params[9];

  $recipient_types = $ZAPOST['recipient_types'];

  $multiple_contacts = $ZAPOST['multiple_contacts'];

  $process_params = array();  

  switch ($recipient_types){

     #####################
     case  '821d3058-e575-b6fa-c3bb-5559de9489ce': # Account Contacts

      # Replace the name if available
      #$message = str_replace("NAMER","",$message);
 
      foreach ($ZAPOST as $acc_key=>$acc_value){

              $acc_email = str_replace("account_contacts_key_","",$acc_key);

              if ($acc_value != NULL && ($acc_email != $acc_key)){

                 $acc_addressees[$acc_value] = $acc_value;
                 $recipient_contacts .= $acc_value.",";

                 } // if acc

              } // end foreach

     break;
     #####################
     case '12db0c6d-cc58-cbef-c092-555ad724ebd7': # Contact Me!

      # When the profile or object contact me link appears to send a message

      $contact_object_type = "Contacts";
      $contact_action = "select_soap";
      $contact_params = array();
      $contact_params[0] = "contacts.id='".$ZAPOST['contact_id1_c']."'"; // query
      $contact_params[1] = array("first_name","last_name","email1");

      $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
      for ($cnt=0;$cnt < count($contact_info);$cnt++){

          $first_name = $contact_info[$cnt]['first_name'];
          $last_name = $contact_info[$cnt]['last_name'];
          $to_email = $contact_info[$cnt]['email1'];

          } # for

      $to_name = $first_name." ".$last_name;

      $to_addressees[$to_email] = $to_name;
      $to_addressees[$from_email] = $portal_email;

      $recipient_contacts .= $to_email;

      if ($ZAPOST['message_lingo'] != NULL){
         $lingo = $ZAPOST['message_lingo'];
         #echo "Desired Lingo: ".$lingo."<BR>";
         }

      $account_id1_c = $ZAPOST['account_id1_c'];

      # Check to see if the user has their own hostname to access by

      if ($account_id1_c != NULL){

         $ci_hostname_id = 'ad2eaca7-8f00-9917-501a-519d3e8e3b35';

         $ci_object_type = "ConfigurationItems";
         $ci_action = "select";
         $ci_params[0] = " deleted=0 && account_id_c='".$account_id1_c."' && sclm_configurationitemtypes_id_c='".$ci_hostname_id."' ";
         $ci_params[1] = ""; // select array
         $ci_params[2] = ""; // group;
         $ci_params[3] = ""; // order;
         $ci_params[4] = ""; // limit
  
         $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

         if (is_array($ci_items)){

            for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
                #$id = $ci_items[$cnt]['id'];
                $provider_hostname = $ci_items[$cnt]['name'];
   
                } # for

            if ($provider_hostname != NULL){

               $extra_message_link = "Body@".$lingo."@".$valtype."@view@".$val."@".$valtype;
               $extra_message_link = $funky_gear->encrypt($extra_message_link);
               $extra_message_link = "https://".$provider_hostname."/?pc=".$extra_message_link;

               $message_body .= "\n\n############\n\nYou may also log into your own portal and check your messages.
\n\n".$extra_message_link;

               } # provider_hostname

            } # is array
       
         } # if ci_account_id_c != NULL

     break;
     #####################
     case 'd8ba0615-94b3-78a5-51e4-5559de992b1c': # Email Contacts
 
      # May need more length than name
      $email_contacts = $ZAPOST['email_contacts'];
      $recipient_contacts .= $email_contacts;

      $addressees = explode(',',$email_contacts);

      foreach ($addressees as $to_key=>$to_value){

              $bcc_addressees[$to_value] = $to_value;

              } # foreach

      #list ($email_name,$domain) = explode ("@",$contact_info);
      # Replace the name if available
      #$message = str_replace("NAMER",$email_name,$message);

     break;
     #####################
     case '2e465f2e-57db-e22d-0b7c-5559e0aaeeaf': # Facebook Contacts

      # Requires FB to allow access to friends
      $recipient_contacts .= $fb_friends;

     break;
     #####################
     case '8718bbf3-bf47-a358-21c7-555aa3a9cce8': # Facebook Post

      require_once ("api-facebook.php");

      $fb_params[0] = "post_feed"; #
      $fb_params[1] = $fb_session; # user
      $fb_params[2] = $message_title;
      $fb_params[3] = $message_image; # caption
      $fb_params[4] = $message_link;
      $fb_params[5] = $message_body;

      $fb_post = do_facebook ($fb_params);

      $recipient_contacts .= "Facebook Post: ".$fb_post;

     break;
     #####################
     case 'ea3bfead-baf4-8133-8e3b-555aa3b66c6a': # Google+ Moment

      require_once ("api-google.php");

      $gg_params[0] = "post_moment"; #
      $gg_params[1] = $gg_session; # user
      $gg_params[2] = $message_title;
      $gg_params[3] = $message_body;
      $gg_params[4] = $message_image;
      $gg_params[5] = $message_link;

      $google_moment = do_google ($gg_params);

      $recipient_contacts .= "Google Moment: ".$google_moment;

     break;
     #####################
     case '54cf2e2f-a525-85d0-ceff-5559e04f44f2': # Google Contacts

      foreach ($ZAPOST as $gg_key=>$gg_value){

              $gg_email = str_replace("google_contacts_key_","",$gg_key);

              if ($gg_value != NULL && ($gg_email != $gg_key)){

                 $gg_addressees[$gg_value] = $gg_value;
                 $recipient_contacts .= $gg_value.",";

                 } // if gg_email

              } // end foreach

     break;
     #####################
     case '18a8e733-f0e1-32a2-d5b3-5559e087dffb': # LinkedIn Contacts

      foreach ($ZAPOST as $li_key=>$li_value){

              $li_id = str_replace("linkedin_contacts_key_","",$li_key);
              if ($li_value != NULL && ($li_id != $li_key)){
                 $li_ids[] = $li_value;
                 $recipient_contacts .= $li_value.",";
                 } // if li_id

              } // end foreach

      if (is_array($li_ids)){

         require_once ("api-linkedin.php");

         $li_params[0] = "message_contacts"; #
         $li_params[1] = $li_session; # user
         $li_params[2] = $message_title;
         $li_params[3] = $message_image; # caption
         $li_params[4] = $message_link;
         $li_params[5] = $message_body;
         $li_params[6] = $li_ids;

         $li_post = do_linkedin ($li_params);

         } # li_ids
            
     break;
     #####################
     case '7f9d6a5d-7dcf-9e21-08ca-5559e4eac64e': # Private Network Connections

      foreach ($ZAPOST as $acc_key=>$acc_value){

              $acc_email = str_replace("account_contacts_key_","",$acc_key);

              if ($acc_value != NULL && ($acc_email != $acc_key)){

                 $acc_addressees[$acc_value] = $acc_value;
                 $recipient_contacts .= $acc_value.",";

                 } // if acc

              } // end foreach

     break;
     #####################
     case '33485c3e-4814-12a5-5a38-5559e204e411': # Social Networks

      # set the message details of sn type
      $sn_pack = $ZAPOST['social_network'];
      list($sn_type_id, $sn_object_id) = explode ("_",$sn_pack);

      $process_params[] = array('name'=>'sn_cit','value' => $sn_type_id);
      $process_params[] = array('name'=>'sn_object_id','value' => $sn_object_id);

      # Get all the contacts attached to the Social Network and send message?
      # Config Item where cit = $sn_type_id & name = object
      $sclm_sn_object_type = "ConfigurationItems";
      $sclm_sn_action = "select";
      $sclm_sn_params[0] = " sclm_configurationitemtypes_id_c='".$sn_type_id."' && name='".$sn_object_id."' ";
      $sclm_sn_params[1] = "id";
      $sclm_sn_params[2] = "";
      $sclm_sn_params[3] = "";
      $sclm_sn_params[4] = "";

      $sclm_sn_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_sn_object_type, $sclm_sn_action, $sclm_sn_params);

      if (is_array($sclm_sn_rows)){

         for ($cnt=0;$cnt < count($sclm_sn_rows);$cnt++){
             $sn_par_ci = $sclm_sn_rows[$cnt]['id'];
             } # for

         $process_params[] = array('name'=>'sn_ci','value' => $sn_par_ci);

         $snprofile_object_type = "ConfigurationItems";
         $snprofile_action = "select";
         $snprofile_params[0] = " sclm_configurationitems_id_c='".$sn_par_ci."' ";
         $snprofile_params[1] = "contact_id_c";
         $snprofile_params[2] = "";
         $snprofile_params[3] = "";
         $snprofile_params[4] = "";

         $snprofile_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $snprofile_object_type, $snprofile_action, $snprofile_params);

         if (is_array($snprofile_rows)){

            for ($snprofilecnt=0;$snprofilecnt < count($snprofile_rows);$snprofilecnt++){

                $contact_id_c = $snprofile_rows[$snprofilecnt]['contact_id_c'];

                $multiple_contacts .= $contact_id_c.",";
                $recipient_contacts .= $contact_id_c.",";

                $check_object_type = "Contacts";
                $check_action = "get_contact_email";
                $check_params = "";
                $check_params = $contact_id_c; // query

                $email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_object_type, $check_action, $check_params);

                $sn_addressees[$email] = $email;
                #$recipient_contacts .= $email.",";

                } # for profiles

            } # is array for profiles

        } # is array

     break;
     #####################
     } # switch contact type

  if ($ZAPOST['extra_addressees']!= NULL){
     $extra_addressees = $ZAPOST['extra_addressees'];
     $addressees = explode(',',$extra_addressees);

     foreach ($addressees as $to_key=>$to_value){
             $bcc_addressees[$to_value] = $to_value;
             } # foreach

     } # if extra

  if ($gg_addressees != NULL){
     $bcc_addressees = $gg_addressees;
     } 

  if ($acc_addressees != NULL){ 
     $bcc_addressees = $acc_addressees;
     } 

  if ($sn_addressees != NULL){ 
     $bcc_addressees = $sn_addressees;
     } 

  if ($extra_addressees != NULL){
     $process_params[] = array('name'=>'extra_addressees','value' => $extra_addressees);
     }

  #
  #############################
  # Prepare Messaging Record

  if ($multiple_contacts != NULL){
     # To show the contacts in the events
     $recipient_contacts = $multiple_contacts;
     }

  #
  #############################
  # If relating contact(s) to an object (Event)

  if (is_array($msg_params[9])){

     $extra_msg_params = $msg_params[9];
     $msg_type = $extra_msg_params[0];
     $msg_type_id = $extra_msg_params[1];
     $ci_wrapper_id = $msg_type_id;

     }

  if ($ci_wrapper_id != NULL){

     $process_object_type = "ConfigurationItems";
     $process_action = "update";
     $process_params = array();  
     $process_params[] = array('name'=>'id','value' => $ZAPOST['recipient_id']);

     if ($ZAPOST['recipient_contacts'] != NULL){
        $process_params[] = array('name'=>'name','value' => $ZAPOST['recipient_contacts']);
        $process_params[] = array('name'=>'description','value' => $ZAPOST['recipient_contacts']);
        } else {
        $process_params[] = array('name'=>'name','value' => $recipient_contacts);
        $process_params[] = array('name'=>'description','value' => $recipient_contacts);
        }
   
     $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $ci_wrapper_id);
     $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $ZAPOST['recipient_types']);
     $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
     $process_params[] = array('name'=>'account_id_c','value' => $ZAPOST['account_id_c']);
     $process_params[] = array('name'=>'contact_id_c','value' => $ZAPOST['contact_id_c']);
     $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $ZAPOST['cmn_statuses_id_c']);

     $rel_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
     $ci_relevent_id = $rel_result['id'];

     } # end relating

  #
  #############################
  # Prepare Messaging Record

  $process_object_type = "Messages";
  $process_action = "update";

  $process_params[] = array('name'=>'id','value' => $ZAPOST['id']);

  if ($ZAPOST['name'] != NULL){
     $process_params[] = array('name'=>'name','value' => $ZAPOST['name']);
     } else {
     $process_params[] = array('name'=>'name','value' => $message_title);
     }

  $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);

  if ($ZAPOST['description'] != NULL){
     $process_params[] = array('name'=>'description','value' => $ZAPOST['description']);
     } else {
     $process_params[] = array('name'=>'description','value' => $message_body);
     }

  $process_params[] = array('name'=>'account_id_c','value' => $ZAPOST['account_id_c']);
  $process_params[] = array('name'=>'contact_id_c','value' => $ZAPOST['contact_id_c']);

  $process_params[] = array('name'=>'project_id_c','value' => $ZAPOST['project_id_c']);
  $process_params[] = array('name'=>'projecttask_id_c','value' => $ZAPOST['projecttask_id_c']);

  if ($ZAPOST['id'] != $ZAPOST['sclm_messages_id_c'] && $ZAPOST['sclm_messages_id_c'] != NULL && $ZAPOST['id'] != NULL){
     $process_params[] = array('name'=>'sclm_messages_id_c','value' => $ZAPOST['sclm_messages_id_c']);
     }

  $process_params[] = array('name'=>'has_been_read','value' => $ZAPOST['has_been_read']);
  $process_params[] = array('name'=>'has_been_replied','value' => $ZAPOST['has_been_replied']);

  if ($ZAPOST['cmn_statuses_id_c'] != NULL){
     $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $ZAPOST['cmn_statuses_id_c']);
     } else {
     $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);
     }

  foreach ($ZAPOST as $name_key=>$name_value){

          $name_lingo = str_replace("name_","",$name_key);

          if ($name_lingo != NULL && in_array($name_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$name_key,'value' => $name_value);

                  } // if namelingo

               } // end foreach

  foreach ($ZAPOST as $desc_key=>$desc_value){

          $desc_lingo = str_replace("description_","",$desc_key);

          if ($desc_lingo != NULL && in_array($desc_lingo,$_SESSION['lingobits'])){

             $process_params[] = array('name'=>$desc_key,'value' => $desc_value);

             } // if namelingo

          } // end foreach

  /*

  Not yet set in DB

  if ($ZAPOST['cmn_languages_id_c'] != NULL){
     $process_params[] = array('name'=>'cmn_languages_id_c','value' => $ZAPOST['cmn_languages_id_c']);
     } else {
     $process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
     }
  */

  $send_notification = $ZAPOST['send_notification'];

  $multiple_contacts = explode (",",$multiple_contacts);

  if (is_array($multiple_contacts)){

     # Should loop through for multiple recipients
     foreach ($multiple_contacts as $contact_key=>$contact_id1_c){

             $process_params[] = array('name'=>'contact_id1_c','value' => $contact_id1_c);

             # Get account entry - with contact
             $accid_object_type = "Contacts";
             $accid_action = "get_account_id";
             $accid_params = "";
             $accid_params[0] = $contact_id1_c;
             $accid_params[1] = "account_id";

             $account_id1_c = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $accid_object_type, $accid_action, $accid_params);
             
             $process_params[] = array('name'=>'account_id1_c','value' => $account_id1_c);

             if ($send_notification == 1){
                $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
                $message_id = $result['id'];
                }

             } # foreach

     } else {

     $process_params[] = array('name'=>'account_id1_c','value' => $ZAPOST['account_id1_c']);
     $process_params[] = array('name'=>'contact_id1_c','value' => $ZAPOST['contact_id1_c']);

     if ($send_notification == 1){
        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
        $message_id = $result['id'];
        }

     } # multiple_contacts

  if ($send_notification == 1){
     #$result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);
     #$message_id = $result['id'];
     /*
     $extra_message_link = "Body@".$lingo."@Messages@view@".$message_id."@Messages";
     $extra_message_link = $funky_gear->encrypt($extra_message_link);
     $extra_message_link = "https://".$hostname."/?pc=".$extra_message_link;

     $message_body .= "\n\n############\n\nView this message at the following link;
\n\n".$extra_message_link;
     */
     } # if send notification

  # Set as replied if there is a parent to this

  if ($ZAPOST['sclm_messages_id_c'] != NULL && $ZAPOST['has_been_replied']==0){

     $process_params = "";
     $process_params[] = array('name'=>'id','value' => $ZAPOST['sclm_messages_id_c']);
     $process_params[] = array('name'=>'has_been_replied','value' => '1');

     $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

     if ($result['id'] != NULL){
        #echo "Replied: ".$result['id'];
        }

     } # if parent_message

  # End Prepare Record
  #############################
  # Send Message

  if ($send_notification == 1 && is_array($bcc_addressees)){

     $type = 1;

     $mailparams[0] = $from_name;
     #$mailparams[1] = $recipient;
     $mailparams[2] = $from_email;
     $mailparams[3] = $from_email_password;
     #$mailparams[4] = $recipient;
     $mailparams[5] = $type;
     $mailparams[6] = $lingo;
     $mailparams[7] = $message_title;
     $mailparams[8] = $message_body;
     $mailparams[9] = $portal_email_server;
     $mailparams[10] = $portal_email_smtp_port;
     $mailparams[11] = $portal_email_smtp_auth;
     #$mailparams[12] = $to_addressees;
     #$mailparams[13] = $cc_addressees;
     $mailparams[14] = $bcc_addressees;

     $emailresult = $funky_gear->do_email ($mailparams);

     } # end send message

  # End Send Message
  #############################
  # Return Pack

  $returnpack[0] = $message_id;
  $returnpack[1] = $emailresult;

  return $returnpack;

  # Return Pack
  #############################

 } # end function message_delivery

 #
 ###################################
 # 

} # end class funky_messaging

##########################################################
?>