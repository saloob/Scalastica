<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-04-10
# Page: Lifestyles.php 
##########################################################
# case 'Lifestyles':

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     if (!$sendiv){
        $sendiv = $BodyDIV;
        }
     }

 $sn_id = "8be14b88-4b94-8325-ccd4-55220b6319d9"; # Lifestyle & State Categories

     $container = "";  
     $container_top = "";
     $container_middle = "";
     $container_bottom = "";

     $container_params[0] = 'open'; // container open state
     $container_params[1] = "97%"; // container_width
     $container_params[2] = $bodyheight; // container_height
     $container_params[3] = "Products"; // container_title
     $container_params[4] = 'Products'; // container_label
     $container_params[5] = $portal_info; // portal info
     $container_params[6] = $portal_config; // portal configs
     $container_params[7] = $strings; // portal configs
     $container_params[8] = $lingo; // portal configs
     
     #$container = $funky_gear->make_container ($container_params);
  
     $container_top = $container[0];
     $container_middle = $container[1];
     $container_bottom = $container[2];

     #echo $container_top;

     #$this->funkydone ($_POST,$lingo,$do,'prodcats',$val,$do,$bodywidth);

     #echo $container_bottom;


   switch ($action){

    case 'view':

     $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('".$sendiv."');cleardiv('fade');document.getElementById('".$sendiv."').style.display='none';document.getElementById('fade').style.display='none';return false\">";

     if ($sendiv == 'lightform'){
        echo "<center>".$closer."</center><P>";
        $blockbits = "document.getElementById('".$sendiv."').style.display='block';";
        }

     $lstsub1val = $_POST['lstsub1val'];
     $lstsub2val = $_POST['lstsub2val'];
     $lstsub3val = $_POST['lstsub3val'];
     $lstsub4val = $_POST['lstsub4val'];

     if ($lstsub1val != NULL){
        $wblinkval = $lstsub1val;
        }

     if ($lstsub2val != NULL){
        $wblinkval = $lstsub2val;
        }

     if ($lstsub3val != NULL){
        $wblinkval = $lstsub3val;
        }

     if ($lstsub4val != NULL){
        $wblinkval = $lstsub4val;
        }

     if ($wblinkval == NULL){
        $wblinkval = $lsttopval;
        }

    if ($sess_contact_id != NULL && $wblinkval != NULL){

       $sn_params[0] = $do;
       $sn_params[1] = $wblinkval;
       $sn_params[2] = $account_id;
       $sn_params[3] = $contact_id;
       $sn_params[4] = $sess_account_id;
       $sn_params[5] = $sess_contact_id;
       $sn_params[6] = "lightform";

       $social_network = $funky_gear->check_sn ($sn_params);
       $status = $social_network[0];
       $sn_button = $social_network[1];

       $socialnetwork = "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Social Networking</B></font></center></div>";

       $socialnetwork .= "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">Social Networking with Shared Effects allows you to join Social Networks that suit your lifestyle - the empowerment of your well-being.</div>";

       $socialnetwork .= "<div style=\"width:98%;margin-left: auto;margin-right: auto;\"><CENTER>".$sn_button."</CENTER></div>";

       echo $socialnetwork;

       } elseif ($sess_contact_id != NULL && $wblinkval == NULL) {# if contact

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

          $sns_wrap = "<div style=\"background-color: ".$portal_header_colour.";float:left;height:25px;padding-top:4px;padding-left:5%;padding-right:5%;width:200px;overflow: auto;border: 1px solid #ffcc66;margin-left: 3%;\"><center><font size=3 color=".$portal_font_colour."><B>Social Networks</B></font></center></div><div style=\"background-color:".$portal_header_colour.";padding-left:2%;padding-right:2%;width:200px;height:25px;padding-top:4px;overflow: auto;border: 1px solid #ffcc66;margin-right: 2%;\"><center><font size=3 color=".$portal_font_colour."><B>My Profiles</B></font></center></div>";

          for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

              $sns = "";
              $id = $sclm_rows[$cnt]['id'];
              $sn_object_id = $sclm_rows[$cnt]['name'];
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

                 $sns = "";

                 for ($sn_cnt=0;$sn_cnt < count($sclm_sn_rows);$sn_cnt++){

                     $sn_profile_id = $sclm_sn_rows[$sn_cnt]['id'];
                     $sn_profile_title = $sclm_sn_rows[$sn_cnt]['name'];

                     $sns .= "<a href=\"#\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=SocialNetworking&action=view&value=".$sn_profile_id."&valuetype=SocialNetworking&sendiv=".$sendiv."');return false\"><B>".$sn_profile_title."</B></a>";
                     } # for 

                 # Get SN Name
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

                 } # end type switch

                 $sns_wrap .= "<div style=\"background-color:#FFFFFF;float:left;height:40px;padding-top:4px;padding-left:5%;padding-right:5%;width:200px;overflow: auto;border: 1px solid #ffcc66;margin-left: 3%;\"><center><B>".$sn_name."</B></center></div><div style=\"background-color:#FFFFFF;padding-left:2%;padding-right:2%;width:200px;height:40px;padding-top:4px;overflow: auto;border: 1px solid #ffcc66;margin-right: 2%;\"><center>".$sns."</center></div>";

                 } # is array

              } # for 

          # Should be SN options available - only wrapped if they are in one
          $socialnetwork = "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Social Networking</B></font></center></div>";

          if ($sns_wrap != NULL){

             $socialnetwork .= "<div name=\"wellbeing\" id=\"wellbeing\" style=\"width:98%;min-height:28px;margin-left: auto;margin-right: auto;\">".$sns_wrap."</div>";

             } else {

             $socialnetwork .= "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">Social Networking with Shared Effects allows you to join Social Networks that suit your lifestyle - the empowerment of your well-being. To join a Social Network, you need to select a Lifestyle sub-category from the below list.</div>";

             } # Logged-in but needs to select

          } # is array

       echo $socialnetwork;

       } elseif ($sess_contact_id == NULL && $wblinkval == NULL) {

       $socialnetwork = "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Social Networking</B></font></center></div>";

       $socialnetwork .= "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">Social Networking with Shared Effects allows you to join Social Networks that suit your lifestyle - the empowerment of your well-being. To join a Social Network, you need to be logged-in and select a Lifestyle sub-category from the below list.</div>";

       echo $socialnetwork;

       } 

     ###################
     # Lifestyle Links

     $top_cit = "a86cf661-d985-f7fc-3a72-5521d38a3700"; # Lifestyle & State Categories

     $lsttopval = $_POST['lsttopval'];

     $sclm_object_type = "ConfigurationItemTypes";
     $sclm_action = "select";
     $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$top_cit."' ";
     $sclm_params[1] = "id,name";
     $sclm_params[2] = "";
     $sclm_params[3] = "name ASC";
     $sclm_params[4] = "";

     $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

     if (is_array($sclm_rows)){

        for ($cnt=0;$cnt < count($sclm_rows);$cnt++){
          
            $lst_id = $sclm_rows[$cnt]['id'];
            $name = $sclm_rows[$cnt]['name'];

            if ($lsttopval == $lst_id){
               $buttoncolour = $portal_header_colour;
               } else {
               $buttoncolour = "#1560BD";
               } 

            $toplinks .= "<a href=\"#l2\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; max-width:98%;max-height:20px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&lsttopval=".$lst_id."&valuetype=Lifestyles&sendiv=".$sendiv."');return false\"><B>".$name."</B></a> ";

            } # for top links

        } # is array

     $links .= $toplinks;

     # Lifestyle Links
     ###################
     # Sublinks1 Links

     if ($lsttopval != NULL){

        $sclm_object_type = "ConfigurationItemTypes";
        $sclm_action = "select";
        $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$lsttopval."' ";
        $sclm_params[1] = "id,name";
        $sclm_params[2] = "";
        $sclm_params[3] = "name ASC";
        $sclm_params[4] = "";

        $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

        if (is_array($sclm_rows)){

           for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

               $lssub1_id = $sclm_rows[$cnt]['id'];
               $name = $sclm_rows[$cnt]['name'];

               if ($lstsub1val == $lssub1_id){
                  $buttoncolour = $portal_header_colour;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

               $sublinks1 .= "<a href=\"#l2\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; max-width:98%;max-height:20px;margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&lstsub1val=".$lssub1_id."&lsttopval=".$lsttopval."&valuetype=Lifestyles&sendiv=".$sendiv."');return false\"><B>".$name."</B></a> ";

               } # for

            }# is array

        } # if sublinks

     $links .= $sublinks1;

     # Sublinks1 Links
     ###################
     # Sublinks2 Links

     if ($lstsub1val != NULL){

        $sclm_object_type = "ConfigurationItemTypes";
        $sclm_action = "select";
        $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$lstsub1val."' ";
        $sclm_params[1] = "id,name";
        $sclm_params[2] = "";
        $sclm_params[3] = "name ASC";
        $sclm_params[4] = "";

        $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

        if (is_array($sclm_rows)){

           for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

               $lssub2_id = $sclm_rows[$cnt]['id'];
               $name = $sclm_rows[$cnt]['name'];

               if ($lstsub2val == $lssub2_id){
                  $buttoncolour = $portal_header_colour;
                  } else {
                  $buttoncolour = "#3B7A57";
                  } 

               $sublinks2 .= "<a href=\"#l2\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; max-width:98%;max-height:20px;margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&lstsub1val=".$lstsub1val."&lstsub2val=".$lssub2_id."&lsttopval=".$lsttopval."&valuetype=Lifestyles&sendiv=".$sendiv."');return false\"><B>".$name."</B></a> ";

               } # for

            }# is array

        } # if sublinks

     $links .= $sublinks2;

     # Sublinks2 Links
     ###################
     # Sublinks3 Links

     if ($lstsub2val != NULL){

        $sclm_object_type = "ConfigurationItemTypes";
        $sclm_action = "select";
        $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$lstsub2val."' ";
        $sclm_params[1] = "id,name";
        $sclm_params[2] = "";
        $sclm_params[3] = "name ASC";
        $sclm_params[4] = "";

        $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

        if (is_array($sclm_rows)){

           for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

               $lssub3_id = $sclm_rows[$cnt]['id'];
               $name = $sclm_rows[$cnt]['name'];

               if ($lstsub3val == $lssub3_id){
                  $buttoncolour = $portal_header_colour;
                  } else {
                  $buttoncolour = "#008000";
                  } 

               $sublinks3 .= "<a href=\"#l2\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; max-width:98%;max-height:20px;margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&lstsub1val=".$lstsub1val."&lstsub2val=".$lstsub2val."&lstsub3val=".$lssub3_id."&lsttopval=".$lsttopval."&valuetype=Lifestyles&sendiv=".$sendiv."');return false\"><B>".$name."</B></a> ";

               } # for

            }# is array

        } # if sublinks

     $links .= $sublinks3;

     # Sublinks3 Links
     ###################
     # Sublinks4 Links

     if ($lstsub3val != NULL){

        $sclm_object_type = "ConfigurationItemTypes";
        $sclm_action = "select";
        $sclm_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$lstsub3val."' ";
        $sclm_params[1] = "id,name";
        $sclm_params[2] = "";
        $sclm_params[3] = "name ASC";
        $sclm_params[4] = "";

        $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

        if (is_array($sclm_rows)){

           for ($cnt=0;$cnt < count($sclm_rows);$cnt++){

               $lssub4_id = $sclm_rows[$cnt]['id'];
               $name = $sclm_rows[$cnt]['name'];

               if ($lstsub4val == $lssub4_id){
                  $buttoncolour = $portal_header_colour;
                  } else {
                  $buttoncolour = "#3B444B";
                  } 

               $sublinks4 .= "<a href=\"#l2\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; max-width:98%;max-height:20px;margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"Scroller();loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=view&lstsub1val=".$lstsub1val."&lstsub2val=".$lstsub2val."&lstsub3val=".$lstsub3val."&lstsub4val=".$lssub4_id."&lsttopval=".$lsttopval."&valuetype=Lifestyles&sendiv=".$sendiv."');return false\"><B>".$name."</B></a> ";

               } # for

            }# is array

        } # if sublinks

     $links .= $sublinks4;

     # Sublinks4 Links
     ###################
     # Lifestyle Content

     $sclm_object_type = "ConfigurationItemTypes";
     $sclm_action = "select";
     $sclm_params[0] = " deleted=0 && id='".$top_cit."' ";
     $sclm_params[1] = "name,description";
     $sclm_params[2] = "";
     $sclm_params[3] = "name ASC";
     $sclm_params[4] = "";

     $sclm_rows = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $sclm_object_type, $sclm_action, $sclm_params);

     if (is_array($sclm_rows)){

        for ($cnt=0;$cnt < count($sclm_rows);$cnt++){
          
            #$id = $sclm_rows[$cnt]['id'];
            $lifestyle_title = $sclm_rows[$cnt]['name'];
            $lifestyle_description = $sclm_rows[$cnt]['description'];

            } # for top links

        $lifestyle_description = str_replace("\n", "<br>", $lifestyle_description);
        $lifestyle_description = "<div style=\"font-family: v; font-size: 12pt; background-color: #FFFFFF; border: 1px solid #5E6A7B; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px;color:#5E6A7B;text-decoration: none;display:block;\">".$lifestyle_description."</div>";

        } # is array

     # Lifestyle Content
     $lifestyle = "<div style=\"font-family: v; font-size: 12pt; background-color: ".$portal_header_colour."; border: 1px solid #ffcc66; border-radius:5px;width:95%; margin-top:2px;margin-bottom:2px;margin-left:2%;margin-right:2%; padding-left:4px; padding-right:4px; padding-top:4px; padding-bottom:4px; color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>Lifestyle</B></font></center></div>";

     # Collect the Lifestyle-related well-being
     # Events with categories

     $wb_action = 'by_contact';
     $wb_params[0] = $wb_action; # Type
     $wb_params[1] = ""; # Account
     $wb_params[2] = $sess_contact_id; # Contact
     $wb_params[3] = ""; # Product/Service
     $wb_params[4] = ""; # Category
     $wb_params[5] = ""; # Event
     $wb_params[6] = ""; # Country 

     $wb_results = $funky_wellbeing->wellbeing($wb_params);
     $wellbeing_score = $wb_results[7];

     $ls_crcl_rad = "100px";
     $wb_crcl_rad = "150px";
     $link_wb = "<B><font size=3>Well-being [".$wellbeing_score."]</B></font>";
     $wb = <<< WB
<style>

.wbcircle {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    width: $ls_crcl_rad;
    height: $ls_crcl_rad;
    position: relative;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

.wbcircle.wb {
    width: $wb_crcl_rad;
    height: $wb_crcl_rad;
    background-color: #ac5;
    margin-top:10px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}
</style>
<div id="wb-circle" class="wbcircle wb">$link_wb
</div>
WB;

     $wblinks = "<input style=\"font-family: v; font-size: 10pt;text-align: center;font-weight: bold; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px;width:80%;height:20px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" name=\"sn\" id=\"sn\" value=\"Add Shared Effect Event\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=Effects&action=add&lifestyleval=".$wblinkval."&valuetype=Lifestyles&sendiv=lightform');document.getElementById('fade').style.display='block';return false\">";

     $wblinks .= "<input style=\"font-family: v; font-size: 10pt;text-align: center;font-weight: bold; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px;width:80%;height:20px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" name=\"sn\" id=\"sn\" value=\"Show My Connections\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=SocialNetworking&action=list_connections&lifestyleval=".$wblinkval."&valuetype=Lifestyles&sendiv=lightform');document.getElementById('fade').style.display='block';return false\">";

     $wellbeing .= "<center>".$wb.$wblinks."</center>";

     $lifestyle .= "<div name=\"wellbeing\" id=\"wellbeing\" style=\"width:100%;height:100%;margin-left: auto;margin-right: auto;\"><div style=\"float:left;height:100%;margin-left:1%;width:50%;overflow: auto;\">".$wellbeing.$lifestyle_description."</div><div style=\"margin-left:2%;width:49%;height:100%;overflow: auto;\">".$links."</div></div>";

    echo $lifestyle;

    # Social Networks
    #echo $socialnetwork;

    break;
    # End  Well-being
    #########################
    # SFX
    case 'sfx':

     # Collect any category-related events

    break;
    # SFX
    #########################
    # Product Categories
    case 'prodcats':

     # Product Types | ID: 1dea7f68-6f6a-662f-fb43-54f829549bd9
     # Service Types | ID: cabebb61-5bef-f61c-fd3d-51d18355ccdb
 
     $service_ci_object_type = 'ConfigurationItems';
     $service_ci_action = "select";

     $prodcat_value = $_POST['prodcat_value'];
  
     $service_ci_params[0] = " (sclm_configurationitemtypes_id_c='cabebb61-5bef-f61c-fd3d-51d18355ccdb' || sclm_configurationitemtypes_id_c='1dea7f68-6f6a-662f-fb43-54f829549bd9') && (sclm_configurationitems_id_c IS NULL || sclm_configurationitems_id_c='' || sclm_configurationitems_id_c='NULL') ";

     $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
     $service_ci_params[2] = ""; // group;
     $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
     $service_ci_params[4] = ""; // limit

     $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

     if (is_array($service_ci_items)){

        for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

            $prodcat_id = $service_ci_items[$cnt]['id'];
            $prodcat_names = $service_ci_items[$cnt]['name'];

            if ($prodcat_value == $prodcat_id){
               $buttoncolour = $portal_header_colour;
               $subcat_name = $prodcat_names;
               } else {
               $buttoncolour = "#1560BD";
               } 

            $product_topcats .= "<a href=\"#l2\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px;width:100%; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left:5px; padding-right:5px; padding-top: 2px; padding-bottom:2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodlinks');doBPOSTRequest('prodlinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodlinks');return false\"><B>".$prodcat_names."</B></a> ";

            } # for

        } # is array

     #$product_topcats .= "<div style=\"width:500px;margin-left: auto;margin-right: auto;\"><CENTER>".$prodcats."</CENTER></div>";

     #$prodlinks .= $product_cats;

     $prodsubcat_value = $_POST['prodsubcat_value'];

     if ($prodcat_value != NULL){

        $service_ci_params[0] = " sclm_configurationitems_id_c='".$prodcat_value."' ";
        $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
        $service_ci_params[2] = ""; // group;
        $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
        $service_ci_params[4] = ""; // limit

        $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

        if (is_array($service_ci_items)){

           for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

               $prodcat_id = $service_ci_items[$cnt]['id'];
               $prodcat_names = $service_ci_items[$cnt]['name'];

               if ($prodsubcat_value == $prodcat_id){
                  $buttoncolour = "#1560BD";
                  $subcat2_name = $prodcat_names;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

              $prodsubcats .= "<a href=\"#l3\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px;padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px; color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodsublinks');doBPOSTRequest('prodsublinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_value."&prodsubcat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodsublinks');return false\"><B>".$prodcat_names."</B></a> ";

               } # for

           } # is array

        $prodsub_cats = "<div style=\"font-family: v; font-size: 10pt; background-color: ".$portal_header_colour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$subcat_name."</B></font></center></div>";

        $prodsub_cats .= "<div style=\"width:100%;margin-left: auto;margin-right: auto;\">".$prodsubcats."</div>";

        $prodlinks .= $prodsub_cats;

        } # if prodcats

     $prodsub2cat_value = $_POST['prodsub2cat_value'];

     if ($prodsubcat_value != NULL){

        $service_ci_params[0] = " sclm_configurationitems_id_c='".$prodsubcat_value."' ";
        $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
        $service_ci_params[2] = ""; // group;
        $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
        $service_ci_params[4] = ""; // limit

        $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

        if (is_array($service_ci_items)){

           for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

               $prodcat_id = $service_ci_items[$cnt]['id'];
               $prodcat_names = $service_ci_items[$cnt]['name'];

               if ($prodsub2cat_value == $prodcat_id){
                  $buttoncolour = "#1560BD";
                  $subcat3_name = $prodcat_names;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

              $prodsub2cats .= "<a href=\"#l4\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px; color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodsublinks');doBPOSTRequest('prodsublinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_value."&prodsubcat_value=".$prodsubcat_value."&prodsub2cat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodsublinks');return false\"><B>".$prodcat_names."</B></a> ";

               } # for

           } # is array

        $prodsub2_cats = "<div style=\"font-family: v; font-size: 10pt; background-color: ".$portal_header_colour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$subcat2_name."</B></font></center></div>";
        $prodsub2_cats .= "<div style=\"width:100%;margin-left: auto;margin-right: auto;\">".$prodsub2cats."</div>";

        $prodlinks .= $prodsub2_cats;

        } # if prodcats

     $prodsub3cat_value = $_POST['prodsub3cat_value'];

     if ($prodsub2cat_value != NULL){

        $service_ci_params[0] = " sclm_configurationitems_id_c='".$prodsub2cat_value."' ";
        $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
        $service_ci_params[2] = ""; // group;
        $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
        $service_ci_params[4] = ""; // limit

        $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

        if (is_array($service_ci_items)){

           for ($cnt=0;$cnt < count($service_ci_items);$cnt++){
  
               $prodcat_id = $service_ci_items[$cnt]['id'];
               $prodcat_names = $service_ci_items[$cnt]['name'];

               if ($prodsub3cat_value == $prodcat_id){
                  $buttoncolour = "#1560BD";
                  $subcat4_name = $prodcat_names;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

              $prodsub3cats .= "<a href=\"#l5\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4px; padding-right: 4px; padding-top: 2px; padding-bottom: 2px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodsublinks');doBPOSTRequest('prodsublinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_value."&prodsubcat_value=".$prodsubcat_value."&prodsub2cat_value=".$prodsub2cat_value."&prodsub3cat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodsublinks');return false\"><B>".$prodcat_names."</B></a> ";

               } # for
  
           } # is array

        $prodsub3_cats = "<div style=\"font-family: v; font-size: 10pt; background-color: ".$portal_header_colour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$subcat3_name."</B></font></center></div>";
        $prodsub3_cats .= "<div style=\"width:100%;margin-left: auto;margin-right: auto;\">".$prodsub3cats."</div>";

        $prodlinks .= $prodsub3_cats;

        } # if prodcats

     $prodsub4cat_value = $_POST['prodsub4cat_value'];

     if ($prodsub3cat_value != NULL){

        $service_ci_params[0] = " sclm_configurationitems_id_c='".$prodsub3cat_value."' ";
        $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
        $service_ci_params[2] = ""; // group;
        $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
        $service_ci_params[4] = ""; // limit

        $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);
  
        if (is_array($service_ci_items)){

           for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

               $prodcat_id = $service_ci_items[$cnt]['id'];
               $prodcat_names = $service_ci_items[$cnt]['name'];

               if ($prodsub4cat_value == $prodcat_id){
                  $buttoncolour = "#1560BD";
                  $subcat5_name = $prodcat_names;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

              $prodsub4cats .= "<a href=\"#l5\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodsublinks');doBPOSTRequest('prodsublinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_value."&prodsubcat_value=".$prodsubcat_value."&prodsub2cat_value=".$prodsub2cat_value."&prodsub3cat_value=".$prodsub3cat_value."&prodsub4cat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodsublinks');return false\"><B>".$prodcat_names."</B></a> ";

               } # for

           } # is array

        $prodsub4_cats = "<div style=\"font-family: v; font-size: 10pt; background-color: ".$portal_header_colour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$subcat4_name."</B></font></center></div>";
        $prodsub4_cats .= "<div style=\"width:100%;margin-left: auto;margin-right: auto;\">".$prodsub4cats."</div>";
  
        $prodlinks .= $prodsub4_cats;

        } # if prodcats

     $prodsub5cat_value = $_POST['prodsub5cat_value'];

     if ($prodsub4cat_value != NULL){

        $service_ci_params[0] = " sclm_configurationitems_id_c='".$prodsub4cat_value."' ";
        $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
        $service_ci_params[2] = ""; // group;
        $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
        $service_ci_params[4] = ""; // limit

        $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

        if (is_array($service_ci_items)){

           for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

               $prodcat_id = $service_ci_items[$cnt]['id'];
               $prodcat_names = $service_ci_items[$cnt]['name'];

               if ($prodsub5cat_value == $prodcat_id){
                  $buttoncolour = "#1560BD";
                  $subcat6_name = $prodcat_names;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

               $prodsub5cats .= "<a href=\"#l5\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodsublinks');doBPOSTRequest('prodsublinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_value."&prodsubcat_value=".$prodsubcat_value."&prodsub2cat_value=".$prodsub2cat_value."&prodsub3cat_value=".$prodsub3cat_value."&prodsub4cat_value=".$prodsub4cat_value."&prodsub5cat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodsublinks');return false\"><B>".$prodcat_names."</B></a> ";

               } # for

           } # is array

        $prodsub5_cats = "<div style=\"font-family: v; font-size: 10pt; background-color: ".$portal_header_colour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$subcat5_name."</B></font></center></div>";
        $prodsub5_cats .= "<div style=\"width:100%;margin-left: auto;margin-right: auto;\">".$prodsub5cats."</div>";

        $prodlinks .= $prodsub5_cats;

        } # if prodcats

     $prodsub6cat_value = $_POST['prodsub6cat_value'];
  
     if ($prodsub5cat_value != NULL){

        $service_ci_params[0] = " sclm_configurationitems_id_c='".$prodsub5cat_value."' ";
        $service_ci_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // select array
        $service_ci_params[2] = ""; // group;
        $service_ci_params[3] = " name ASC, date_entered DESC "; // order;
        $service_ci_params[4] = ""; // limit

        $service_ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $service_ci_object_type, $service_ci_action, $service_ci_params);

        if (is_array($service_ci_items)){

           for ($cnt=0;$cnt < count($service_ci_items);$cnt++){

               $prodcat_id = $service_ci_items[$cnt]['id'];
               $prodcat_names = $service_ci_items[$cnt]['name'];
  
               if ($prodsub6cat_value == $prodcat_id){
                  $buttoncolour = "#1560BD";
                  $subcat7_name = $prodcat_names;
                  } else {
                  $buttoncolour = "#1E90FF";
                  } 

              $prodsub6cats .= "<a href=\"#l5\" style=\"font-family: v; font-size: 10pt; background-color: ".$buttoncolour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\" onClick=\"loader('prodsublinks');doBPOSTRequest('prodsublinks','Body.php', 'pc=".$portalcode."&do=Lifestyles&action=prodcats&prodcat_value=".$prodcat_value."&prodsubcat_value=".$prodsubcat_value."&prodsub2cat_value=".$prodsub2cat_value."&prodsub3cat_value=".$prodsub3cat_value."&prodsub4cat_value=".$prodsub4cat_value."&prodsub5cat_value=".$prodsub5cat_value."&prodsub6cat_value=".$prodcat_id."&lifestyle_value=".$lifestyle_value."&valuetype=Lifestyles&sendiv=prodsublinks');return false\"><B>".$prodcat_names."</B></a> ";

               } # for

           } # is array

        $prodsub6_cats = "<div style=\"font-family: v; font-size: 10pt; background-color: ".$portal_header_colour."; border: 1px solid #5E6A7B; border-radius:5px; margin-top:2px;margin-bottom:2px;margin-left:2px;margin-right:2px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:200px;color:#FFFFFF;text-decoration: none;display:block;\"><center><font size=3 color=".$portal_font_colour."><B>".$subcat6_name."</B></font></center></div>";
        $prodsub6_cats .= "<div style=\"width:100%;margin-left: auto;margin-right: auto;\">".$prodsub6cats."</div>";

        $prodlinks .= $prodsub6_cats;

        } # if prodcats

     # Product Categories
     #########################
     # Final Package

     if ($valtype == 'AccountsServices'){
        $sclm_accountsservices_id_c = $val;
        $object_returner = $funky_gear->object_returner ('AccountsServices', $val);
        echo $object_returner[1];
        }

     if ($valtype == 'Effects'){
        #$sclm_events_id_c = $_POST['event_id'];
        #$object_returner = $funky_gear->object_returner ('Effects', $sclm_events_id_c);
        #echo $object_returner[1];
        }

     $product = "<div name=prodlinks id=prodlinks style=\"width:98%;max-height:305px;margin-left: auto;margin-right: auto;\"><div style=\"float:left;max-height:300px;margin-left:3%;width:48%;overflow: auto;\">".$product_topcats."</div><div name=prodsublinks id=prodsublinks style=\"margin-left:5%;width:48%;max-height:300px;overflow: auto;\">".$prodlinks."</div></div>"; 

     echo $product;
  
     echo "<a name=\"l1\"></a><a name=\"l2\"></a><a name=\"l3\"></a><a name=\"l4\"></a><a name=\"l5\"></a><a name=\"l6\"></a><a name=\"l7\"></a>";

    break;

    } # switch

   #
   ###################  

# break; End Lifestyles
##########################################################
?>