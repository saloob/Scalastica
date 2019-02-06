<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-13
# Page: Right
###############################################
# Debugging - show variables

foreach ($_POST as $key=>$value){

        //echo "Field: ".$key." - Value: ".$value."<BR>";

        }

#
############################################## 
# Provide Reseller Link

$section = "Body";
$page = "Body.php";
$sendvars = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
$lingobar = language_selector($section,$lingo, $sendvars, $page,$LeftDIV,$BodyDIV,$RightDIV);

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

 switch ($valtype){

  case 'Contacts':

   $this->funkydone ($_POST,$lingo,'Contacts','view',$val,'Contacts',$bodywidth);

  break;

 } // switch

if ($auth == NULL){

   # Account Preferences - Wish to provide Registration?

   $ci_object_type = "ConfigurationItems";
   $ci_action = "select";
   $ci_params[0] = " deleted=0 && account_id_c='".$portal_account_id."' && (sclm_configurationitemtypes_id_c='ea0de164-0803-4551-8cc1-51fdc1881db6' || sclm_configurationitemtypes_id_c='1d3da104-6fad-d1d8-719a-54d71a00b7d0' || sclm_configurationitemtypes_id_c='5e7c49e5-e48d-f53e-9c4a-54d719f5fedb' || sclm_configurationitemtypes_id_c='2f6a1ad8-2501-c5d7-025f-54d71a110296' && name=1) ";
   $ci_params[1] = ""; // select array
   $ci_params[2] = ""; // group;
   $ci_params[3] = ""; // order;
   $ci_params[4] = ""; // limit
  
   $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

   $allow_some_rego = FALSE;

   if (is_array($ci_items)){

      for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
          $id = $ci_items[$cnt]['id'];
          $name = $ci_items[$cnt]['name'];
          $ci_type_id = $ci_items[$cnt]['ci_type_id'];

          if ($ci_type_id == 'ea0de164-0803-4551-8cc1-51fdc1881db6'){ // allow_engineer_rego

             #$allow_some_rego = TRUE;
             #$rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=de438478-a493-51ad-ec49-51ca1a3aca3e&valuetype=entity_types');return false\"><B>Register as an Engineer</B></a></center></div>";

             } elseif ($ci_type_id == '5e7c49e5-e48d-f53e-9c4a-54d719f5fedb'){

             $allow_some_rego = TRUE;
             $rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=de438478-a493-51ad-ec49-51ca1a3aca3e&valuetype=entity_types');return false\"><B>".$strings["RegisterAsProvider"]."</B></a></center></div>";

             } elseif ($ci_type_id == '2f6a1ad8-2501-c5d7-025f-54d71a110296'){

             $allow_some_rego = TRUE;
             $rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=f2aa14f0-dc5e-16ce-87c9-51ca1af657fe&valuetype=entity_types');return false\"><B>".$strings["RegisterAsReseller"]."</B></a></center></div>";
 
             } elseif ($ci_type_id == '1d3da104-6fad-d1d8-719a-54d71a00b7d0'){

             $allow_some_rego = TRUE;
             $rego_types .= "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=register&value=e0b47bbe-2c2b-2db0-1c5d-51cf6970cdf3&valuetype=entity_types');return false\"><B>".$strings["RegisterAsClient"]."</B></a></center></div>";

             } # end else

          } # for

      if ($allow_some_rego == TRUE){

         echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>".$strings["RegoFormTitle"]."</font></B></center></div>";
         echo $rego_types;
         echo "<BR><img src=images/blank.gif width=200 height=10><BR>";

         }

      } # is array

   } else {// if auth

       $today = date("Y-m-d");
       $encdate = date("Y@m@d@G");
       $body_sendvars = $encdate."#Bodyphp";
       $body_sendvars = $funky_gear->encrypt($body_sendvars);

       echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>Ticket Search</font></B></center></div>";
?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <div style="float:left;width:30;padding-top:5;">
     <?php echo $strings["Ticket"].": "; ?></div><div style="width:80;"><input type="text" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>" size="20"></div><BR>
     <div style="float:left;width:30;padding-top:5;">
     <?php echo $strings["action_search_keyword"].": "; ?></div><div style="width:80;"><input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20"></div><BR>
     <div style="float:left;width:30;padding-top:5;">
     <?php echo $strings["Date"].": "; ?></div><div style="width:80;"><input type="text" id="date" name="date" value="<?php #echo $today; ?>" size="20"></div><BR>
     <?php echo "Format = [".$today."]"; ?><BR>
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="sendiv" name="sendiv" value="GRID" >
     <input type="hidden" id="rows" name="rows" value="30" >
     <input type="hidden" id="do" name="do" value="Ticketing" >
     <input type="hidden" id="value" name="value" value="" >
     <input type="hidden" id="valuetype" name="valuetype" value="" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('GRID');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php


   }

   # Get VoIP
   $zingaya_voip_button_object_type = "ConfigurationItems";
   $zingaya_voip_button_action = "select";
   $zingaya_voip_button_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='d98f9873-5ccb-d4be-e587-52f5d1201f77' && account_id_c='".$portal_account_id."' ";
   $zingaya_voip_button_params[1] = ""; // select array
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
   $advisory_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='8c6aaf99-04d9-f378-9904-52992a052162' && account_id_c='".$portal_account_id."' ";
   $advisory_params[1] = ""; // select array
   $advisory_params[2] = ""; // group;
   $advisory_params[3] = ""; // order;
   $advisory_params[4] = ""; // limit
  
   $advisory_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $advisory_object_type, $advisory_action, $advisory_params);

   if (is_array($advisory_items)){

      for ($cnt=0;$cnt < count($advisory_items);$cnt++){

          $id = $advisory_items[$cnt]['id'];
          $show_advisory = $advisory_items[$cnt]['name'];

          } // for

      } // if

   if ($show_advisory == 1){

      echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>".$strings["Advisory"]."</font></B></center></div>";
      echo $funkydo_gear->funkydone ($_POST,$lingo,'Advisory','welcome',$val,$do,$bodywidth);
      if ($zingaya_voip_button != NULL){

         #echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>".$strings["VoIPCallOnline"]."</font></B></center></div><P>";
         $funkydo_gear->funkydone ($_POST,$lingo,'Advisory','voip',$zingaya_voip_button,$do,$bodywidth);

         }

      }

    # Advisory
    ###################################################
    # Powered BY

    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><B><font size=3>Powered By</font></B></center></div>";
    #$poweredurl = "http://www.advantage24.co.jp/?locale=".$lingo;
    #echo "<div style=\"".$divstyle_white."\"><center><a href=".$poweredurl." parent=AD24><B>Advantage24</B><BR><img width=200 src=images/adv24_hor_rgb-7bbd71bace5a590cf1e14d3e4b920416.png border=0></center></div>";

    echo "<div style=\"".$divstyle_white."\"><center><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Accounts&action=view&value=6f120751-96d2-68a0-46c5-54e2d40f38cf&valuetype=Accounts');return false\"><B>Advantage24</B><BR><img width=200 src=images/adv24_hor_rgb-7bbd71bace5a590cf1e14d3e4b920416.png border=0></center></div>";

    # Powered BY
    ###################################################

#
############################################## 
?>