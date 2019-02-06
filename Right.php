<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-13
# Page: Right
###############################################
# Debugging - show variables

#foreach ($_POST as $key=>$value){

        //echo "Field: ".$key." - Value: ".$value."<BR>";

 #       }

  if (!function_exists('get_param')){
     include ("common.php");
     }
#
############################################## 
# Provide Reseller Link

#$section = "Body";
#$page = "Body.php";
#$sendvars = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
#$lingobar = language_selector($section,$lingo, $sendvars, $page,$LeftDIV,$BodyDIV,$RightDIV);

/*
 switch ($portal_type){

  case 'system':

//   echo "System";

  break;
  case 'provider':

//   echo "Provider";

  break;
  case 'reseller':

//   echo "Reseller";

  break;
  case 'client':

//   echo "Client";

  break;

 }

*/

    ###################################################
    # Advisory
/*
    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = "300px"; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = 'Ali Advisory'; // container_title
    $container_params[4] = 'RightAdvisory'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;
*/

 #switch ($valtype){

  #case 'Contacts':

   #$this->funkydone ($_POST,$lingo,'Contacts','view',$val,'Contacts',$bodywidth);

  #break;

 #} // switch

if ($auth == NULL){

   if ($allow_engineer_rego){
      #$allow_some_rego = TRUE;
      #$rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=de438478-a493-51ad-ec49-51ca1a3aca3e&valuetype=entity_types');return false\"><B>Register as an Engineer</B></a></center></div>";
      }

   if ($allow_provider_rego){

      $allow_some_rego = TRUE;
      #$rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=de438478-a493-51ad-ec49-51ca1a3aca3e&valuetype=entity_types');return false\"><B>".$strings["RegisterAsProvider"]."</B></a></center></div>";

      $rego_types .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"RegisterAsProvider\" id=\"RegisterAsProvider\" value=\"".$strings["RegisterAsProvider"]."\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=de438478-a493-51ad-ec49-51ca1a3aca3e&valuetype=entity_types');return false\"></center></div>";

      }

   if ($allow_reseller_rego){

      $allow_some_rego = TRUE;
      #$rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=f2aa14f0-dc5e-16ce-87c9-51ca1af657fe&valuetype=entity_types');return false\"><B>".$strings["RegisterAsReseller"]."</B></a></center></div>";
      $rego_types .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"RegisterAsReseller\" id=\"RegisterAsReseller\" value=\"".$strings["RegisterAsReseller"]."\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=f2aa14f0-dc5e-16ce-87c9-51ca1af657fe&valuetype=entity_types');return false\"></center></div>";

      }

   if ($allow_client_rego){

      $allow_some_rego = TRUE;
      #$rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3&valuetype=entity_types');return false\"><B>".$strings["RegisterAsClient"]."</B></a></center></div>";
      $rego_types .= "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"RegisterAsClient\" id=\"RegisterAsClient\" value=\"".$strings["RegisterAsClient"]."\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3&valuetype=entity_types');return false\"></center></div>";

      }

   if ($allow_some_rego == TRUE){

      echo "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["RegoFormTitle"]."</font></B></center></div>";
      echo $rego_types;
      echo "<BR><img src=images/blank.gif width=90% height=10><BR>";

      }

   } else {// if auth

    $today = date("Y-m-d");
    $encdate = date("Y@m@d@G");
    $body_sendvars = $encdate."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

    echo "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["Ticket"]." ".$strings["action_search"]."</font></B></center></div>";

    $action_search_keyword = $strings["action_search_keyword"];
    $DateStart = $strings["Date"];
    $action_search = $strings["action_search"];
    $ticket_label = $strings["Ticket"];

    $ticksearch = <<< TICKSEARCH
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="text" id="ticket_id" placeholder="$ticket_label ID" name="ticket_id" value="$ticket_id" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <BR><input type="text" id="keyword" placeholder="$action_search_keyword" name="keyword" value="$search_keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <BR><input type="text" id="search_date" placeholder="$DateStart" name="search_date" value="$search_date" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="pg" name="pg" value="$body_sendvars" >
     <input type="hidden" id="value" name="value" value="" >
     <input type="hidden" id="sendiv" name="sendiv" value="GRID" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="Ticketing" >
     <input type="hidden" id="valuetype" name="valuetype" value="" >
     <BR><input type="button" name="button" value="$action_search" onclick="javascript:loader('GRID');get(this.parentNode);" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
TICKSEARCH;

    echo "<div style=\"".$divstyle_white."\">".$ticksearch."</div>";
    echo "<BR><img src=images/blank.gif width=90% height=10><BR>";

   }

   # Get VoIP
   $zingaya_voip_button_object_type = "ConfigurationItems";
   $zingaya_voip_button_action = "select";
   $zingaya_voip_button_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='d98f9873-5ccb-d4be-e587-52f5d1201f77' && account_id_c='".$portal_account_id."' ";
   $zingaya_voip_button_params[1] = "id,name,account_id_c,deleted,sclm_configurationitemtypes_id_c"; // select array
   $zingaya_voip_button_params[2] = ""; // group;
   $zingaya_voip_button_params[3] = ""; // order;
   $zingaya_voip_button_params[4] = ""; // limit
  
   $zingaya_voip_button_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $zingaya_voip_button_object_type, $zingaya_voip_button_action, $zingaya_voip_button_params);

   if (is_array($zingaya_voip_button_items)){

      for ($cnt=0;$cnt < count($zingaya_voip_button_items);$cnt++){

          $zingaya_voip_button_id = $zingaya_voip_button_items[$cnt]['id'];
          $zingaya_voip_button = $zingaya_voip_button_items[$cnt]['name'];

          } // for

      } // if

   # Account Preferences - Wish to provide Advisory?

   # Get Characters and Images
   $advisory_object_type = "ConfigurationItems";
   $advisory_action = "select";
   $advisory_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='8c6aaf99-04d9-f378-9904-52992a052162' && account_id_c='".$portal_account_id."' && name=1";
   #$advisory_params[1] = "id,name,account_id_c,deleted,sclm_configurationitemtypes_id_c"; // select array
   $advisory_params[1] = "id"; // select array
   $advisory_params[2] = ""; // group;
   $advisory_params[3] = ""; // order;
   $advisory_params[4] = ""; // limit
  
   $advisory_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisory_object_type, $advisory_action, $advisory_params);

   if (is_array($advisory_items)){

      #for ($cnt=0;$cnt < count($advisory_items);$cnt++){

      #    $id = $advisory_items[$cnt]['id'];
      #    $show_advisory = $advisory_items[$cnt]['name'];

      #    } // for
      echo "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">".$strings["Advisory"]."</font></B></center></div>";
      echo $funkydo_gear->funkydone ($_POST,$lingo,'Advisory','welcome',$val,$do,$bodywidth);

      if ($zingaya_voip_button != NULL){

         #echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>".$strings["VoIPCallOnline"]."</font></B></center></div><P>";
         $funkydo_gear->funkydone ($_POST,$lingo,'Advisory','voip',$zingaya_voip_button,$do,$bodywidth);

         }

      echo "<BR><img src=images/blank.gif width=90% height=10><BR>";

      } # is array

    # Advisory
    ###################
    # Powered BY

    echo "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">Powered By</font></B></center></div>";
    #$poweredurl = "http://www.advantage24.co.jp/?locale=".$lingo;
    #echo "<div style=\"".$divstyle_white."\"><center><a href=".$poweredurl." parent=AD24><B>Advantage24</B><BR><img width=200 src=images/adv24_hor_rgb-7bbd71bace5a590cf1e14d3e4b920416.png border=0></center></div>";

    echo "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=6f120751-96d2-68a0-46c5-54e2d40f38cf&valuetype=Accounts');return false\"><B>Advantage24</B><BR><img width=200 src=images/adv24_hor_rgb-7bbd71bace5a590cf1e14d3e4b920416.png border=0></a></center></div>";

    # Powered BY
    ###################
    # Tickets

  function do_right ($portal_account_id){

   global $funky_gear,$portal_account_id,$sess_account_id,$BodyDIV,$strings,$crm_api_user, $crm_api_pass, $crm_wsdl_url,$divstyle_white,$divstyle_blue,$custom_portal_divstyle,$portal_font_colour,$lingo,$show_statistics,$show_partners,$standard_statuses_closed;

    if ($show_statistics == TRUE){

       $ticketing = "<BR><img src=images/blank.gif width=90% height=10><BR>";
       $ticketing .= "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">Service Statistics</font></B></center></div>";

       #$ticketing .= "<div style=\"".$divstyle_white."\">";

       $ticketing .= "<div style=\"".$divstyle_white."\"><B>Service Start Date: 2013-12-31</B></div>";

       $ticket_object_type = "Ticketing";
       $ticket_action = "count";
       $ticket_params[0] = "deleted=0"; #date_entered
       $ticket_params[1] = "id"; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = ""; // order;
       $ticket_params[4] = ""; // limit

       $ticket_count = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
       $ticketing .= "<div style=\"".$divstyle_white."\"><B>Tickets To Date: ".number_format($ticket_count,0)."</B></div>";

       $ticket_params[0] = "deleted=0 && date_entered like '%2015%'";
       $ticket_count = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
       $ticketing .= "<div style=\"".$divstyle_white."\"><B>Tickets In 2015: ".number_format($ticket_count,0)."</B></div>";
 
       #$ticket_params[0] = "deleted=0 && date_entered like '%2014%'";
       #$ticket_count = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
       $ticket_count = "19328";
       $ticketing .= "<div style=\"".$divstyle_white."\"><B>Tickets In 2014: ".number_format($ticket_count,0)."</B></div>";

       #$ticket_params[0] = "deleted=0 && date_entered like '%2013%'";
       #$ticket_count = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
       #$ticketing .= "<B>Tickets In 2013: ".number_format($ticket_count,0)."</B><P>";

       $ticket_object_type = "TicketingActivities";
       $ticket_action = "count";
       $ticket_params[0] = "deleted=0"; #date_entered
       $ticket_params[1] = "id"; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = ""; // order;
       $ticket_params[4] = ""; // limit

       $ticket_count = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
       $ticketing .= "<div style=\"".$divstyle_white."\"><B>Activities To Date: ".number_format($ticket_count,0)."</B></div>";

       $ticket_object_type = "Emails";
       $ticket_action = "count";
       $ticket_params[0] = "deleted=0"; #date_entered
       $ticket_params[1] = "id"; // select array
       $ticket_params[2] = ""; // group;
       $ticket_params[3] = ""; // order;
       $ticket_params[4] = ""; // limit

       $ticket_count = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);
       $ticketing .= "<div style=\"".$divstyle_white."\"><B>Emails Processed: ".number_format($ticket_count,0)."</B></div>";

       #$ticketing .= "</div>";

       }

       # Check for partner listing
    if ($show_partners == TRUE){

       $partners = "<BR><img src=images/blank.gif width=90% height=10><BR>";
       $partners .= "<div style=\"".$custom_portal_divstyle."\"><center><B><font size=3 color=".$portal_font_colour.">Partners</font></B></center></div>";
       $partners .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=list&value=".$portal_account_id."&valuetype=Accounts');return false\"><img src=uploads/9fdf8d07-48d4-5124-7226-54a5988b5239/6da70a2f-c653-1a4d-a5cc-54a598fdcf95/shutterstock_178217606-partners-shaking-hands_thumb.png width=98%></a></center></div>";

       $partners .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=list&value=".$portal_account_id."&valuetype=Accounts');return false\"><B>List All -> </B></a></div>";

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " deleted=0 && (account_id_c='".$portal_account_id."' || account_id1_c='".$portal_account_id."') ";
       $acc_params[1] = "id,name,date_entered,account_id_c,account_id1_c"; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " name, date_entered DESC "; // order;
       $acc_params[4] = "15"; // limit

       $accounts = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($accounts)){

          for ($cnt=0;$cnt < count($accounts);$cnt++){

              $status_c = "";
              $partner_id = "";
              $partner_name = "";
              $account_cstm_info = "";
              $par_account_id = "";
              $child_account_id = "";

              #$partner_rel_id = $accounts[$cnt]['id'];
              #$partner_rel_name = $accounts[$cnt]['name'];
              #$partner_rel_account_id_c = $accounts[$cnt]['account_id_c'];
              #$partner_rel_account_id1_c = $accounts[$cnt]['account_id1_c'];
              $par_account_id = $accounts[$cnt]['parent_account_id'];
              $child_account_id = $accounts[$cnt]['child_account_id'];

              if ($par_account_id == $portal_account_id){
                 $partner_id = $child_account_id;
                 } elseif ($child_account_id == $portal_account_id) {
                 $partner_id = $par_account_id;
                 }

              if ($partner_id != NULL){

                 $acc_cstm_object_type = "Accounts";
                 $acc_cstm_action = "select_cstm";
                 $acc_cstm_params[0] = "id_c='".$partner_id."' && status_c!='".$standard_statuses_closed."'";
                 $acc_cstm_params[1] = ""; // select
                 $acc_cstm_params[2] = ""; // group;
                 $acc_cstm_params[3] = ""; // order;
                 $acc_cstm_params[4] = ""; // limit

                 $account_cstm_info = "";

                 $account_cstm_info = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_cstm_object_type, $acc_cstm_action, $acc_cstm_params);

                 if (is_array($account_cstm_info)){

                    /*
                    for ($cstm_cnt=0;$cstm_cnt < count($account_cstm_info);$cstm_cnt++){

                        $status_c = "";
                        $status_c = $account_cstm_info[$cstm_cnt]['status_c'];
                        echo "PID: ".$partner_id." - Status: ".$status_c." - ".$standard_statuses_closed."<BR>";
                        } # for
                    */
                 #if ($status_c != NULL && $status_c != $standard_statuses_closed){

                    $acc_returner = $funky_gear->object_returner ("Accounts", $partner_id);
                    $partner_name = $acc_returner[0];
                    $partners .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=".$partner_id."&valuetype=Accounts');return false\"><B>".$partner_name."</B></a></div>";
                    } # is array

                 } # if partner

              } # for

          } # is array

       $partners .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=list&value=".$portal_account_id."&valuetype=Accounts');return false\"><B>List All -></B></a></div>";

       } # show partners
 
    # add any other parts
    $right_gear = $ticketing.$partners;

    return $right_gear;

    } # end function

  #########################
  # how long to keep the cache files (hours)

  $cache_time = 1;

  # return location and name for cache file
  #echo "$sess_account_id == $portal_account_id";

  if ($sess_account_id != NULL && $sess_account_id == $portal_account_id){
     $right_cache_file = "/tmp/cache_right_in_".$lingo."_".md5($hostname);
     } elseif ($sess_account_id == NULL){
     $right_cache_file = "/tmp/cache_right_out_".$lingo."_".md5($hostname);
     }

  # check that cache file exists and is not too old
  if (!file_exists($right_cache_file)){
     $right_gear = do_right($portal_account_id);
     file_put_contents($right_cache_file, $right_gear);
     } elseif (filemtime($right_cache_file) < time() - $cache_time * 3600){
     $right_gear = do_right($portal_account_id);
     file_put_contents($right_cache_file, $right_gear);
     } else {
     $right_gear = file_get_contents($right_cache_file);
     } 

  echo $right_gear;

  #
  #############################

#
############################################## 
?>