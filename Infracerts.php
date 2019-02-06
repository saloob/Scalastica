<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-06-12
# Page: Infracerts.php 
##########################################################
# case 'Infracerts':
# Infracerts | ID: cb0c2f17-2e39-9eae-dae1-5579c42ad70c
# -> Network | ID: bb129d1f-97d0-4e34-ec15-557a324fafaa
# -> DC | ID: 745ec33b-00d8-ab25-e346-557a32217132
# -> Hosting | ID: d9a1644a-5257-f0cc-1bcc-557a33a16b8a
# -> Hardware | ID: 252f5955-ae3b-f057-efb0-557a3404c565
# -> CPU | ID: e6b8cb44-9140-c74d-fbff-557a344eb57c
# -> Storage | ID: 484ddba9-c5b6-a551-326f-557a34d6610d
# -> OS | ID: dfd0c0ee-f03f-d481-7777-557a35b5781a
# -> Virtualisation | ID: cdaf24fc-e485-0ed9-8eef-557a350f0f3c
# -> Data Base | ID: 62f5d3ed-3494-e4a9-d7e8-557a353d91b7
# -> Application | ID: 978fc3bc-c757-b88e-b01f-557a36ffe5da
# -> 

  $infra_cit = 'cb0c2f17-2e39-9eae-dae1-5579c42ad70c';
  $infra_network = 'bb129d1f-97d0-4e34-ec15-557a324fafaa';
  $infra_dc = '745ec33b-00d8-ab25-e346-557a32217132';
  $infra_hosting = 'd9a1644a-5257-f0cc-1bcc-557a33a16b8a';
  $infra_hardware = '252f5955-ae3b-f057-efb0-557a3404c565';
  $infra_cpu = 'e6b8cb44-9140-c74d-fbff-557a344eb57c';
  $infra_storage = '484ddba9-c5b6-a551-326f-557a34d6610d';
  $infra_os = 'dfd0c0ee-f03f-d481-7777-557a35b5781a';
  $infra_vz = 'cdaf24fc-e485-0ed9-8eef-557a350f0f3c';
  $infra_db = '62f5d3ed-3494-e4a9-d7e8-557a353d91b7';
  $infra_app = '978fc3bc-c757-b88e-b01f-557a36ffe5da';

/*
            $hw = $cert_row['hw_id'];
            $cpu = $cert_row['cpu_id'];
            $os = $cert_row['os_id'];
            $vz = $cert_row['vz_id'];
            $cp = $cert_row['cp_id'];
            $asp = $cert_row['asp_id'];
            $show_asp = $cert_row['show_asp'];
            $approved = $cert_row['approved'];
            $auth_status = $cert_row['auth_status_id'];
            $auth_service = $cert_row['auth_service_id'];
*/

   switch ($action){

    case 'list':

     $infracerts .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Infracerts</B></font></center></div>";

     $infracerts .= "<div id=INFRACERT name=INFRACERT style=\"".$divstyle_orange."\"></div>";

     # CIT as wrapper for the sub-components based on the other layers
     if ($auth == 3){
        $infra_params[0] = "deleted=0 && sclm_configurationitemtypes_id_c='".$infra_cit."'";
        } elseif ($auth == 2){
        $infra_params[0] = "deleted=0 && sclm_configurationitemtypes_id_c='".$infra_cit."' && account_id_c='".$sess_account_id."'";
        } else {
        $infra_params[0] = "deleted=0 && sclm_configurationitemtypes_id_c='".$infra_cit."' && contact_id_c='".$sess_contact_id."'";
        }

     $infra_object_type = "ConfigurationItems";
     $infra_action = "select";
     $infra_params[1] = "id,name,contact_id_c,account_id_c,enabled,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,description"; // select array
     $infra_params[2] = ""; // group;
     $infra_params[3] = " name ASC "; // order;
     $infra_params[4] = ""; // limit
     $infracert_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $infra_object_type, $infra_action, $infra_params);

     if (is_array($infracert_list)){

        for ($infracnt=0;$infracnt < count($infracert_list);$infracnt++){

            $infracert_id = $infracert_list[$infracnt]['id'];
            $infracert_name = $infracert_list[$infracnt]['name'];
            $infracert_configurationitemtypes_id_c = $infracert_list[$infracnt]['sclm_configurationitemtypes_id_c'];
            $infracert_contact_id_c = $infracert_list[$infracnt]['contact_id_c'];
            $infracert_account_id_c = $infracert_list[$infracnt]['account_id_c'];
            $enabled_id = $infracert_list[$infracnt]['enabled'];
            $enabled = $funky_gear->yesno ($enabled_id);

            if ($auth == 3 || (($sess_account_id != NULL && $sess_account_id==$infracert_account_id_c) || ($sess_contact_id != NULL && $sess_contact_id==$infracert_contact_id_c))){

               $edit = "<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$infracert_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($auth == 3){
               $show_id = " | ID: ".$infracert_id;
               } else {
               $show_id = "";
               }

            $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$infracert_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_view"]."]</B></font></a> <a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$infracert_id."&valuetype=".$do."&sendiv=INFRACERT');return false\"><B>".$infracert_name."</B></a> <a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=".$do."&action=build&value=".$infracert_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\"><font size=2 color=blue><B>[".$strings["Build"]."]</B></font></a>".$show_id."</div>";

            } # for


        } else {# array

        $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_cit."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Infracert]</B></font></a></div>";
        
        } 

     echo $infracerts;

    break; # end list
    case 'build':

     $infracerts .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Infracert Builder</B></font></center></div>";

     # CIT as wrapper for the sub-components based on the other layers
     $infra_object_type = "ConfigurationItems";
     $infra_action = "select";
     $infra_params[0] = "deleted=0 && sclm_configurationitems_id_c='".$val."'";
     $infra_params[1] = "id,name,contact_id_c,account_id_c,enabled,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,description"; // select array
     $infra_params[2] = ""; // group;
     $infra_params[3] = " name ASC "; // order;
     $infra_params[4] = ""; // limit
     $infracert_bit_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $infra_object_type, $infra_action, $infra_params);

     if (is_array($infracert_bit_list)){

        $exists_network = FALSE;
        $exists_dc = FALSE;
        $exists_hosting = FALSE;
        $exists_hardware = FALSE;
        $exists_cpu = FALSE;
        $exists_storage = FALSE;
        $exists_os = FALSE;
        $exists_vz = FALSE;
        $exists_db = FALSE;
        $exists_app = FALSE;

        for ($infracnt=0;$infracnt < count($infracert_bit_list);$infracnt++){

            $infracert_bit_id = $infracert_bit_list[$infracnt]['id'];
            $infracert_bit_name = $infracert_bit_list[$infracnt]['name'];
            $infracert_bit_cit = $infracert_bit_list[$infracnt]['sclm_configurationitemtypes_id_c'];
            $infracert_bit_contact_id_c = $infracert_bit_list[$infracnt]['contact_id_c'];
            $infracert_bit_account_id_c = $infracert_bit_list[$infracnt]['account_id_c'];
            $enabled_id = $infracert_bit_list[$infracnt]['enabled'];
            $enabled = $funky_gear->yesno ($enabled_id);

            if ($auth == 3 || (($sess_account_id != NULL && $sess_account_id==$infracert_bit_account_id_c) || ($sess_contact_id != NULL && $sess_contact_id==$infracert_bit_contact_id_c))){

               $edit = "<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
               }

            if ($auth == 3){
               $show_id = " | ID: ".$infracert_id;
               } else {
               $show_id = "";
               }

            if ($infracert_bit_cit == $infra_network){
               $exists_network = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_dc){
               $exists_dc = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_hosting){
               $exists_hosting = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_hardware){
               $exists_hardware = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_cpu){
               $exists_cpu = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_storage){
               $exists_storage = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_os){
               $exists_os = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_vz){
               $exists_vz = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_db){
               $exists_dp = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            if ($infracert_bit_cit == $infra_app){
               $exists_app = TRUE;
               $infracerts .= "<div style=\"".$divstyle_white."\">".$edit."<a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=view&value=".$infracert_bit_id."&valuetype=ConfigurationItems&sendiv=INFRACERT');return false\">".$infracert_name."</a>".$show_id."</div>";
               }

            } # for

        } else {# array

        #$infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_cit."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Infracert]</B></font></a></div>";
        
        } 

   if ($exists_network == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_network."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Network Service]</B></font></a></div>";
      }

   if ($exists_dc == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_dc."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." DC Service]</B></font></a></div>";
      }

   if ($exists_hosting == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_hosting."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Hosting Service]</B></font></a></div>";
      }

   if ($exists_hardware == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_hardware."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Hardware Service]</B></font></a></div>";
      }

   if ($exists_cpu == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_cpu."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." CPU Service]</B></font></a></div>";
      }

   if ($exists_storage == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_storage."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Storage Service]</B></font></a></div>";
      }

   if ($exists_os == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_os."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." OS Service]</B></font></a></div>";
      }

   if ($exists_vz == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_vz."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." Virtualisation Service]</B></font></a></div>";
      }

   if ($exists_db == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_db."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." DB Service]</B></font></a></div>";
      }

   if ($exists_app == FALSE){
      $infracerts .= "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('INFRACERT');doBPOSTRequest('INFRACERT','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$infra_app."&valuetype=ConfigurationItemTypes&sendiv=INFRACERT');return false\"><font size=2 color=red><B>[".$strings["action_addnew"]." App Service]</B></font></a></div>";
      }

    echo $infracerts;

    break; # end build
    case 'view':

     $infracert .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Infracerts</B></font></center></div>";
     echo $infracert;



            if ($idc != NULL){

            $idc_ent = dlookup("items", "entity_id", "item_id=$idc");
            $idc_ent_img = dlookup("entities", "logo_url_j", "entity_id=$idc_ent");
            $idc_img = dlookup("items", "image_url_j", "item_id=$idc");
            $idc_img = make_image ($idc_ent, $idc, $idc_img);
            $idc_url = dlookup("items", "product_url_j", "item_id=$idc");
            $idc = "<tr>
  <td align=center><img src=http://".$certifier."/certs/1_IDC.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$idc_ent target=INFRACERT><img src=$idc_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$idc_url target=INFRACERT><img src=$idc_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $idc = "<tr>
  <td align=center><img src=http://".$certifier."/certs/1_IDC.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 
            if ($hosting != NULL){
            $hosting_ent = dlookup("items", "entity_id", "item_id=$hosting");
            $hosting_ent_img = dlookup("entities", "logo_url_j", "entity_id=$hosting_ent");
            $hosting_img = dlookup("items", "image_url_j", "item_id=$hosting");
            $hosting_img = make_image ($hosting_ent, $hosting, $hosting_img);
            $hosting_url = dlookup("items", "product_url_j", "item_id=$hosting");
            $hosting = "<tr>
  <td align=center><img src=http://".$certifier."/certs/2_HOSTING.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$hosting_ent target=INFRACERT><img src=$hosting_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$hosting_url target=INFRACERT><img src=$hosting_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $hosting = "<tr>
  <td align=center><img src=http://".$certifier."/certs/2_HOSTING.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 
            if ($hw != NULL){
            $hw_ent = dlookup("items", "entity_id", "item_id=$hw");
            $hw_ent_img = dlookup("entities", "logo_url_j", "entity_id=$hw_ent");
            $hw_img = dlookup("items", "image_url_j", "item_id=$hw");
            $hw_img = make_image ($hw_ent, $hw, $hw_img);
            $hw_url = dlookup("items", "product_url_j", "item_id=$hw");
            $hw = "<tr>
  <td align=center><img src=http://".$certifier."/certs/3_HARDWARE.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$hw_ent target=INFRACERT><img src=$hw_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$hw_url target=INFRACERT><img src=$hw_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $hw = "<tr>
  <td align=center><img src=http://".$certifier."/certs/3_HARDWARE.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 

            if ($cpu != NULL){
            $cpu_ent = dlookup("items", "entity_id", "item_id=$cpu");
            $cpu_ent_img = dlookup("entities", "logo_url_j", "entity_id=$cpu_ent");
            $cpu_img = dlookup("items", "image_url_j", "item_id=$cpu");
            $cpu_img = make_image ($cpu_ent, $cpu, $cpu_img);
            $cpu_url = dlookup("items", "product_url_j", "item_id=$cpu");
            $cpu = "<tr>
  <td align=center><img src=http://".$certifier."/certs/4_CPU.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$cpu_ent target=INFRACERT><img src=$cpu_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$cpu_url target=INFRACERT><img src=$cpu_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $cpu = "<tr>
  <td align=center><img src=http://".$certifier."/certs/4_CPU.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 
//            $os_ent = dlookup("items", "entity_id", "item_id=$os");
//            $os_ent_img = dlookup("entities", "logo_url_j", "entity_id=$os_ent");
//            $os_img = dlookup("items", "image_url_j", "item_id=$os");
            if ($vz != NULL){
            $vz_ent = dlookup("items", "entity_id", "item_id=$vz");
            $vz_ent_img = dlookup("entities", "logo_url_j", "entity_id=$vz_ent");
            $vz_img = dlookup("items", "image_url_j", "item_id=$vz");
            $vz_img = make_image ($vz_ent, $vz, $vz_img);
            $vz_url = dlookup("items", "product_url_j", "item_id=$vz");
            $vz = "<tr>
  <td align=center><img src=http://".$certifier."/certs/5_VZ.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$vz_ent target=INFRACERT><img src=$vz_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$vz_url target=INFRACERT><img src=$vz_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $vz = "<tr>
  <td align=center><img src=http://".$certifier."/certs/5_VZ.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 
            if ($os != NULL){
            $os_ent = dlookup("items", "entity_id", "item_id=$os");
            $os_ent_img = dlookup("entities", "logo_url_j", "entity_id=$os_ent");
            $os_img = dlookup("items", "image_url_j", "item_id=$os");
            $os_img = make_image ($os_ent, $os, $os_img);
            $os_url = dlookup("items", "product_url_j", "item_id=$os");
            $os = "<tr>
  <td align=center><img src=http://".$certifier."/certs/6_OS.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$os_ent target=INFRACERT><img src=$os_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$os_url target=CERTS><img src=$os_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $os = "<tr>
  <td align=center><img src=http://".$certifier."/certs/6_OS.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            }
             if ($cp != NULL){
            $cp_ent = dlookup("items", "entity_id", "item_id=$cp");
            $cp_ent_img = dlookup("entities", "logo_url_j", "entity_id=$cp_ent");
            $cp_img = dlookup("items", "image_url_j", "item_id=$cp");
            $cp_img = make_image ($cp_ent, $cp, $cp_img);
            $cp_url = dlookup("items", "product_url_j", "item_id=$cp");
            $cp = "<tr>
  <td align=center><img src=http://".$certifier."/certs/7_CP.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$cp_ent target=INFRACERT><img src=$cp_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$cp_url target=INFRACERT><img src=$cp_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $cp = "<tr>
  <td align=center><img src=http://".$certifier."/certs/7_CP.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 
            if ($asp != NULL && $show_asp == 1){
            $asp_ent = dlookup("items", "entity_id", "item_id=$asp");
            $asp_ent_img = dlookup("entities", "logo_url_j", "entity_id=$asp_ent");
            $asp_img = dlookup("items", "image_url_j", "item_id=$asp");
            $asp_img = make_image ($asp_ent, $asp, $asp_img);
            $asp_url = dlookup("items", "product_url_j", "item_id=$asp");
            $asp = "<tr>
  <td align=center><img src=http://".$certifier."/certs/8_ASP.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$asp_ent target=INFRACERT><img src=$asp_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$asp_url target=INFRACERT><img src=$asp_img border=0 width=$scalewidth></td>
 </tr>";
            }
            if ($asp != NULL && $show_asp == 0){
            $asp = "<tr>
  <td align=center><img src=http://".$certifier."/certs/8_ASP.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 
            if ($asp == NULL && $show_asp == 0){
            $asp = "";
            } 
            if ($auth_service != NULL){
            $auth_service_ent = dlookup("items", "entity_id", "item_id=$auth_service");
            $auth_service_ent_img = dlookup("entities", "logo_url_j", "entity_id=$auth_service_ent");
            $auth_service_img = dlookup("items", "image_url_j", "item_id=$auth_service");
            $auth_service_img = make_image ($auth_service_ent, $auth_service, $auth_service_img);
            $auth_service_url = dlookup("items", "product_url_j", "item_id=$auth_service");
            $auth = "<tr>
  <td align=center><img src=http://".$certifier."/certs/9_AUTH.jpg width=$scalewidth></td>
  <td align=center><a href=http://www.saloob.com/ViewPartner.php?e=$auth_service_ent target=INFRACERT><img src=$auth_service_ent_img border=0 width=$scalewidth></td>
  <td align=center><a href=$auth_service_url target=INFRACERT><img src=$auth_service_img border=0 width=$scalewidth></td>
 </tr>";
            } else {
            $auth = "<tr>
  <td align=center><img src=http://".$certifier."/certs/9_AUTH.jpg width=$scalewidth></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
  <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white><B>NA</font></B></td>
 </tr>";
            } 

$this_width = $scalewidth/200;
$tbl = $this_width*750;
$td1 = $this_width*150;
$td2 = $this_width*600;

$cert ="
  <table border=1>
   <tr>
    <td bgcolor=#EF2121 align=center><font color=white size=$font><B>".$portal_title." Infracert</B></font></td>
   </tr>
  <tr>
   <td>
    <table border=1>
     <tr>
      <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white size=$font><B>Infra</font></B></td>
      <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white size=$font><B>Provider</font></B></td>
      <td bgcolor=#EF2121 align=center width=$scalewidth><font color=white size=$font><B>Service</font></B></td>
    </tr>
 ".$auth." 
 ".$asp."
 ".$cp."
 ".$os."
 ".$vz."
 ".$cpu."
 ".$hw."
 ".$hosting."
 ".$idc."
     </table>
    </td>
   </tr>
  </table>";


    break; # end view

  } # switch action

# break; # End Infracerts
##########################################################
?>