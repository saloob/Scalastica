<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-21
# Page: funky-wellbeing.php 
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

  if (!class_exists('funky_messaging')){
     include ("funky-messaging.php");
     $funky_messaging = new funky_messaging ();   
     }

class funky_wellbeing {

function cmv ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

 # Collect the CMV based around Lifestyle



} # end function

# CMV
#####################
# Pesh

function pesh ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;
  
  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

  # These factors will enable/accelerate PERMA in all activities
  # Vote power by those within close circles can further validate one's PESH
  
  # Switch type
  
  switch ($type){
  
   case 'by_contact':
    
    # Total of ALL emotions
    $query = " && contact_id_c='".$contacts."' && name IS NOT NULL "; 
    
   break; # By Contact 
   case 'by_account':
    
    # Total of ALL emotions
    $query = " && account_id_c='".$accounts."' "; 
    
   break; # By Account 
  
  } # switch

  $total_count = 0;
  $total_score = 0;
  $score_list = "";
   
  # First level to get main headings
  $cit_pesh = "b29c9896-2712-359b-38a8-55217fe0ca20"; # Capitalisation

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$cit_pesh."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $pesh_title = $ci_items[$cnt]['name'];
         $pesh_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $pesh_description = str_replace("\n", "<br>", $pesh_description);

  $link_top = "<a href=\"#top\"><B><font size=2 color=".$portal_font_colour.">[Top]</font></B></a> ";

  $pesh_content = "<a name=\"pesh\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour.">".$link_top."<B>".$pesh_title."</B></font></center></div>";
  $pesh_content .= "<div style=\"".$divstyle_blue."\"><center><B>Higher PESH scores represent your strongest areas...</B></center></div>";
  $pesh_content .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $pesh_content .= $pesh_description;
  $pesh_content .= "</div>";

  $cis_object_type = "ConfigurationItemTypes";
  $cis_action = "select";  
  $cis_params[0] = "sclm_configurationitemtypes_id_c='".$cit_pesh."' ";
  $cis_params[1] = "id,name";
  $cis_params[2] = "";
  $cis_params[3] = "name ASC";
  $cis_params[4] = "";
  
  $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

  if (is_array($cis_list)){

     $parlistedvals = "";

     for ($cnt=0;$cnt < count($cis_list);$cnt++){

         $paramount = "";
     
         $cit = $cis_list[$cnt]['id'];
         $pesh_heading = $cis_list[$cnt]['name'];

         # Sub-headings of Pesh - used to get individual items

         $cis_head_object_type = "ConfigurationItemTypes";
         $cis_head_action = "select";  
         $cis_head_params[0] = "sclm_configurationitemtypes_id_c='".$cit."' ";
         $cis_head_params[1] = "id,name,description";
         $cis_head_params[2] = "";
         $cis_head_params[3] = "name ASC";
         $cis_head_params[4] = "";
  
         $cis_head_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_head_object_type, $cis_head_action, $cis_head_params);
  
         if (is_array($cis_head_list)){

            $this_subtotal_count = ""; 
            $this_subtotal = "";
  
            for ($headcnt=0;$headcnt < count($cis_head_list);$headcnt++){
     
                $sub_cit = $cis_head_list[$headcnt]['id'];
                $pesh_subheading = $cis_head_list[$headcnt]['name'];
                $pesh_description = $cis_head_list[$headcnt]['description'];
                # Get CI values for subheadings

                $val_object_type = "ConfigurationItems";
                $val_action = "select";  
                $cis_val_params[0] = "sclm_configurationitemtypes_id_c='".$sub_cit."' ".$query;
                $cis_val_params[1] = "id,name,contact_id_c,account_id_c";
                $cis_val_params[2] = "";
                $cis_val_params[3] = "name ASC";
                $cis_val_params[4] = "";
 
                $cis_val_list = api_sugar($crm_api_user, $crm_api_pass, $crm_wsdl_url, $val_object_type, $val_action, $cis_val_params);

                if (is_array($cis_val_list)){

                   $this_value = "";

                   for ($valcnt=0;$valcnt < count($cis_val_list);$valcnt++){
     
                       $sub_ci = $cis_val_list[$valcnt]['id'];
                       $this_value = $cis_val_list[$valcnt]['name'];
                       $contact_id_c = $cis_val_list[$valcnt]['contact_id_c'];
                       
                       $namer = "";

                       if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth == 3){

                          $namer = "<a href=\"#\" onClick=\"loader('".$sub_cit."');".$blockbits."doBPOSTRequest('".$sub_cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$sub_ci."&valuetype=ConfigurationItemTypes&sendiv=".$sub_cit."');return false\"><font color=red><B>[".$this_value."]</B></font></a>";

                          } else {# if 

                          $namer = "<font color=blue><B>[".$this_value."]</B></font>";

                          } # if contact/auth
                          
                       $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$sub_cit."\" name=\"".$sub_cit."\">".$namer." <font color=blue><B>".$pesh_heading." -> ".$pesh_subheading."</B></font> - ".$pesh_description."</div>";

                       $total_score = $total_score + $this_value;
                       $total_count++;

                       $this_subtotal_count++; 
                       $this_subtotal = $this_subtotal+$this_value;

                       } # for values
                
                   } else {# is array values

                   $namer = "";

                   switch ($type){
  
                    case 'by_contact':
    
                     # Total of ALL emotions
                     if ($sess_contact_id != NULL && $sess_contact_id == $contacts || $auth == 3){
                        $namer = "<a href=\"#\" onClick=\"loader('".$sub_cit."');".$blockbits."doBPOSTRequest('".$sub_cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$sub_cit."&valuetype=ConfigurationItemTypes&sendiv=".$sub_cit."');return false\"><font color=red><B>Add Value</B></font></a>";
                        } else {
                        $namer = "No Value";
                        }     

                    break; # By Contact 
                    case 'by_account':
    
                     # Total of ALL emotions
                     if ($sess_account_id != NULL && $sess_account_id == $accounts || $auth == 3){
                        $namer = "<a href=\"#\" onClick=\"loader('".$sub_cit."');".$blockbits."doBPOSTRequest('".$sub_cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$sub_cit."&valuetype=ConfigurationItemTypes&sendiv=".$sub_cit."');return false\"><font color=red><B>Add Value</B></font></a>";
                        } else {
                        $namer = "No Value";
                        }     
                     
                    break; # By Account 
  
                   } # switch

                   $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$sub_cit."\" name=\"".$sub_cit."\">".$namer." <font color=BLUE><B>".$pesh_heading." -> ".$pesh_subheading."</B></font> - ".$pesh_description."</div>";
                   
                   } # if no value

                #$this_subtotal_count++; 
                #$this_subtotal = $this_subtotal+$this_value;

                } # for subheadings

            } # is array subheadings

         $partotal_count++;
         $paramount = round(($this_subtotal/$this_subtotal_count),2);
         $parlistedvals[$partotal_count]['count'] = $paramount;
         $parlistedvals[$partotal_count]['content'] = "<div style=\"".$divstyle_blue."\"><B>".$pesh_heading." [Total Score: ".$paramount."]</B></div>";               
         #echo $pesh_heading.": ".$this_subtotal."<BR>";  

         } # for headings
         
     } # is array headings
     
  if ($total_count>0){
     $avg_score = round($total_score/$total_count,0);
     } else {
     $total_count = 0;
     $total_score = 0;
     $avg_score = 0;
     } 

  foreach ($parlistedvals as $key => $row) {
          $count[$key]  = $row['count'];
          }

  array_multisort($count, SORT_DESC, $parlistedvals);

  foreach ($parlistedvals as $parstrengthval=>$parstregthshow){
          #echo "Key  $parstrengthval <BR>";
          $show_parlayers .= $parstregthshow['content'];
          }

  $pesh_content .= $show_parlayers.$score_list;

  $return_values[0] = $pesh_content;
  $return_values[1] = $total_score;
  $return_values[2] = $total_count;
  $return_values[3] = $avg_score;

  return $return_values; 

}# end pesh function

# Pesh
#####################
# PERMA

function perma ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];
  
  # First - Capture the total positivity resulting from events for a Contact/Account/Category
  # Switch type
  
  switch ($type){
  
   case 'by_contact':
    
    # Total of ALL emotions
    $query = " && contact_id_c='".$contacts."' "; 

   break; # By Contact 
   case 'by_account':
    
    # Total of ALL emotions
    $query = " && account_id_c='".$accounts."' "; 
    
   break; # By Account 
   case 'by_contact_category':
    
    # Total of ALL emotions
    $query = " && contact_id_c='".$contacts."' && category_id='".$categories."' "; 
    
   break; # By Category for Contact 
   case 'by_account_category':
    
    # Total of ALL emotions
    $query = " && account_id_c='".$accounts."' && category_id='".$categories."' "; 
    
   break; # By Category for Account 
  
  } # switch

  $perma_cit = "5eaf205f-8d6e-0ed8-aa5e-552181f1e373";

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$perma_cit."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $perma_title = $ci_items[$cnt]['name'];
         $perma_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $perma_description = str_replace("\n", "<br>", $perma_description);

  $link_top = "<a href=\"#top\"><B><font size=2 color=".$portal_font_colour.">[Top]</font></B></a> ";

  $perma .= "<a name=\"perma\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour.">".$link_top."<B>".$perma_title."</B></font></center></div>";
  $perma .= "<div style=\"".$divstyle_blue."\"><center><B>Higher PERMA values represent greater levels...</B></center></div>";
  $perma .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $perma .= $perma_description;
  $perma .= "</div>";

  #|| sclm_configurationitemtypes_id_c='62ada2bc-2053-2b77-7f42-55218253c0f7' # positive emotions

  $subquery = " && (id='debb2e41-45ed-d465-adea-5521821c80dd' || id='713920b6-e19e-c268-7815-5521820f59ad' || id='1f89d8b4-a6bf-44bd-e124-552182f53585' || id='1ef726c0-8209-0648-6084-552182278071') ";

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 ".$subquery;
  $ci_params[1] = "id,name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         $cit = $ci_items[$cnt]['id'];
         $perma_title = $ci_items[$cnt]['name'];
         $perma_description = $ci_items[$cnt]['description'];
         $perma_description = str_replace("\n", "<br>", $perma_description);

         $val_object_type = "ConfigurationItems";
         $val_action = "select";  
         $cis_val_params[0] = "sclm_configurationitemtypes_id_c='".$cit."' ".$query;
         $cis_val_params[1] = "id,name,contact_id_c,account_id_c";
         $cis_val_params[2] = "";
         $cis_val_params[3] = "name ASC";
         $cis_val_params[4] = "";
 
         $cis_val_list = api_sugar($crm_api_user, $crm_api_pass, $crm_wsdl_url, $val_object_type, $val_action, $cis_val_params);

         if (is_array($cis_val_list)){

            $this_value = "";

            for ($valcnt=0;$valcnt < count($cis_val_list);$valcnt++){
     
                $sub_ci = $cis_val_list[$valcnt]['id'];
                $this_value = $cis_val_list[$valcnt]['name'];
                $contact_id_c = $cis_val_list[$valcnt]['contact_id_c'];
                       
                $namer = "";

                if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth == 3){

                   $namer = "<a href=\"#\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$sub_ci."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>[".$this_value."]</B></font></a>";

                   } else {# if 

                   $namer = "<font color=blue><B>[".$this_value."]</B></font>";

                   } # if contact/auth
                          
                $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$cit."\" name=\"".$cit."\">".$namer." <font color=blue><B>".$perma_title."</B></font> - ".$perma_description."</div>";

                $total_score = $total_score + $this_value;
                $total_count++;

                } # for values
                
            } else {# is array values

            $namer = "";

            switch ($type){
  
             case 'by_contact':
    
              # Total of ALL emotions
              if (($sess_contact_id != NULL && $sess_contact_id == $contacts) || $auth == 3){
                 $namer = "<a href=\"#\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$cit."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>Add Value</B></font></a>";
                 } else {
                 $namer = "No Value";
                 } 

             break; # By Contact 
             case 'by_account':
              
              # Total of ALL emotions
              if (($sess_account_id != NULL && $sess_account_id == $accounts) || $auth == 3){
                 $namer = "<a href=\"#\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$cit."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>Add Value</B></font></a>";
                 } else {
                 $namer = "No Value";
                 } 
    
             break; # By Account 

           } # switch

            $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$cit."\" name=\"".$cit."\">".$namer." <font color=BLUE><B>".$perma_title."</B></font> - ".$perma_description."</div>";
                   
            } # if no value

         } # for

     } # for

  $perma .= $score_list;
  $perma_total = $total_score;
  $perma_count = $total_count;

  # PERMA Intro
  ###############################
  # Start events-driven positivity

  switch ($type){
  
   case 'by_contact':
    
    # Total of ALL emotions
    $query = " contact_id_c='".$contacts."' && emotion_id IS NOT NULL "; 

   break; # By Contact 
   case 'by_account':
    
    # Total of ALL emotions
    $query = " account_id_c='".$accounts."' && emotion_id IS NOT NULL "; 
        
   break; # By Account 
   case 'by_contact_category':
    
    # Total of ALL emotions
    $query = " contact_id_c='".$contacts."' && emotion_id IS NOT NULL && category_id='".$categories."' "; 
    
   break; # By Category for Contact 
   case 'by_account_category':
    
    # Total of ALL emotions
    $query = " account_id_c='".$accounts."' && emotion_id IS NOT NULL && category_id='".$categories."' "; 
    
   break; # By Category for Account 
  
  } # switch

  $sfx_cit = "d10ec6fe-4e7c-7f16-7399-54fd63d09435"; # Shared Effects & Events

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$sfx_cit."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $sfx_title = $ci_items[$cnt]['name'];
         $sfx_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $sfx_description = str_replace("\n", "<br>", $sfx_description);

  $sfx = "<a name=\"positivity\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$sfx_title."</B></font></center></div>";
  $sfx .= "<div style=\"".$divstyle_blue."\"><center><B>Higher values represent greater positivity...</B></center></div>";
  $sfx .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $sfx .= $sfx_description;
  $sfx .= "</div>";
  
  $total_count = 0;
  $total_score = 0;
  $score_list = "";
  
  $sfx_object_type = "Events";
  $sfx_action = "select";
  $sfx_params[0] = $query;
  $sfx_params[1] = "id,name,value,emotion_id,category_id,positivity,probability,start_date";
  $sfx_params[2] = "";
  $sfx_params[3] = "start_date DESC";
  $sfx_params[4] = "";
  
  $sfx_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sfx_object_type, $sfx_action, $sfx_params);

  if (is_array($sfx_list)){

     for ($cnt=0;$cnt < count($sfx_list);$cnt++){
     
         $cid = $sfx_list[$cnt]['id'];
         $emotion_id = $sfx_list[$cnt]['emotion_id'];
         $category_id = $sfx_list[$cnt]['category_id'];
         $name = $sfx_list[$cnt]['name'];
         $value = $sfx_list[$cnt]['value']; # Strength of the emotion
         $positivity = $sfx_list[$cnt]['positivity']; #
         $probability = $sfx_list[$cnt]['probability']; # likelihood of this emotion...
         $start_date = $sfx_list[$cnt]['start_date']; 

         $event_start = date('Y-m-d', strtotime($start_date));

         if ($cit == $cit_being_sales){
            # Only required if this is a special value
            }
         
         $this_score = 0;
         
         $emotion_ret = $funky_gear->object_returner ("ConfigurationItemTypes", $emotion_id);
         $emotion = $emotion_ret[0];
        
         $this_score = ($value*$positivity)*$probability;
         $show_probability = round($probability*100,2);
         $show_probability = $show_probability." %";

         switch ($type){

          case 'by_contact':
    
           # Total of ALL emotions
            if (($sess_contact_id != NULL && $sess_contact_id == $contacts) || $auth == 3){
               $event_list .= "<div style=\"".$divstyle_white."\"><B>".$event_start.":</B> ".$emotion." Positivity of [".$positivity."] With a strength of [".round($value,2)."] With a likelihood of [".$show_probability."] for \"".$name."\"</div>";
               } else {
               $event_list .= "<div style=\"".$divstyle_white."\"><B>".$event_start.":</B> ".$emotion." Positivity of [".$positivity."] With a strength of [".round($value,2)."] With a likelihood of [".$show_probability."] for \"Closed Event\"</div>";
               }     

           break; # By Contact 
           case 'by_account':
    
            # Total of ALL emotions
            if (($sess_account_id != NULL && $sess_account_id == $accounts) || $auth == 3){
               $event_list .= "<div style=\"".$divstyle_white."\"><B>".$event_start.":</B> ".$emotion." Positivity of [".$positivity."] With a strength of [".round($value,2)."] With a likelihood of [".$show_probability."] for \"".$name."\"</div>";
               } else {
               $event_list .= "<div style=\"".$divstyle_white."\"><B>".$event_start.":</B> ".$emotion." Positivity of [".$positivity."] With a strength of [".round($value,2)."] With a likelihood of [".$show_probability."] for \"Closed Event\"</div>";
               } 
        
           break; # By Account 

         } # type switch

         $total_score = $total_score + $this_score;
         $total_count++;
         
         } # for
         
     $avg_score = round($total_score/$total_count,0);
      
     } # is array

  $perma_total = $perma_total+$total_score;
  $perma_count = $perma_total+$total_count;
  $perma_avg = round ($perma_total/$total_count,2);
     
  $sfx .= $event_list;

  $perma .= $sfx;

  # End events-driven positivity
  ###############################
  # Accomplishment/Achievement: debb2e41-45ed-d465-adea-5521821c80dd

  # Subjective Answer

  # 
  ###############################
  # Engagement: 713920b6-e19e-c268-7815-5521820f59ad

  # Subjective answer

  # 
  ###############################
  # Meaningfulness: 1f89d8b4-a6bf-44bd-e124-552182f53585

  # Captured by Events' Meaning/Purpose?

  # 
  ###############################
  # Positive Emotions: 62ada2bc-2053-2b77-7f42-55218253c0f7

  # Captured by Events

  # 
  ###############################
  # Relationships: 1ef726c0-8209-0648-6084-552182278071

  # Captured by Social Network Connections and shared Well-being

  # 
  ###############################
  # Wrap up PERMA

  $return_values[0] = $perma;
  $return_values[1] = $perma_total;
  $return_values[2] = $perma_count;
  $return_values[3] = $perma_avg;

  return $return_values; 
  
} # end perma function  
  
# PERMA
#####################
# VIA

function via ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

  # VIA values in comparison to Contact/Account/SN/Global
  # My Knowledge = 2, Global Average = 10 - score = (2/10)*10;
  # Get from current form

  /*
  $via_array[] = '765a3bfa-a4d0-4e8f-4153-54ea144528e5'; # Bravery | ID: 
  $via_array[] = 'c84d558f-5b4e-0e80-20b0-54ecc0c31761'; # Honesty | ID: 
  $via_array[] = '457e6dfb-6ccf-0181-91ee-54ecc03754f2'; # Perseverance | ID: 
  $via_array[] = '22510bd0-25c0-c1b5-c08e-54ecc1d75bb4'; # Zest  | ID: 
  $via_array[] = 'f1c2f556-ae34-0193-9ab7-54ecc2059496'; # Kindness  | ID: 
  $via_array[] = 'e362dd02-f638-7b9a-e836-54ecc1cde8c9'; # Love | ID: 
  $via_array[] = 'b55fdb63-31b7-5deb-404e-54ecc2dc0c4a'; # Social Intelligence  | ID: 
  $via_array[] = '7a519305-97f5-93ad-82b3-54ecc3d500a1'; #  Fairness | ID: 
  $via_array[] = 'bb3fa52f-31d4-f28e-68e3-54ecc38eb5fe'; # Leadership | ID: 
  $via_array[] = 'ec358874-5f7b-549e-b963-54ecc3fabddd'; # Teamwork  | ID: 
  $via_array[] = '7a8001fc-480d-8eb3-c069-54ecc431ae11'; #  Forgiveness | ID: 
  $via_array[] = '3a9963ed-48fa-1d80-5599-54ecc4033726'; # Humility | ID: 
  $via_array[] = '2c8e8a55-6e64-5f09-d22b-54ecc42c1a09'; # Prudence | ID: 
  $via_array[] = 'd492fa70-9aa7-ea73-cdbf-54ecc4f069de'; # Self-Regulation  | ID: 
  $via_array[] = '30aed2ba-7ca4-2063-ce6c-54ecc55c7d4d'; #  Appreciation of Beauty and Excellence  | ID: 
  $via_array[] = '67cd5fb7-25d9-1451-acce-54ecc5f4cb20'; # Gratitude | ID: 
  $via_array[] = '3f3ad669-f5c5-7e7d-78ec-54ecc52d422b'; # Hope | ID: 
  $via_array[] = '26e41f55-bae6-adc9-f8c9-54ecc63a1044'; # Humor | ID: 
  $via_array[] = 'b7497a9c-dd71-be28-c4b7-54ecc6457975'; # Spirituality  | ID: 
  $via_array[] = 'ca93fdde-240b-5442-9106-54ea127e78d6'; #  Creativity  | ID: 
  $via_array[] = '4f125431-d54f-c510-8b20-54ea1261057c'; # Curiosity  | ID: 
  $via_array[] = 'ce496b67-dd35-27c3-94bd-54ea13c190a8'; # Judgment  | ID: 
  $via_array[] = '8be2b0b6-5e5a-55cb-3648-54ea13d1c4ab'; # Love of Learning | ID: 
  $via_array[] = 'b9339e24-a6a7-93a5-5e91-54ea13b8f60c'; # Perspective  | ID: 
  */

  $via_cits = "sclm_configurationitemtypes_id_c='".$cit_contact_contact."' || ";

  switch ($type){

   case 'by_contact': # my own

    $query = " && contact_id_c='".$contacts."' "; 
    #$compare_action = "by_contacts_all";

    $country_params[0] = 'by_contact';
    $country_params[1] = $contacts;
    $country_details = $funky_gear->get_country($country_params);
    $country_id = $country_details[0];
    $country_name = $country_details[1];
  
   break;
   case 'by_contact_to_contact':

    $contact_a = $contacts[0];
    $contact_b = $contacts[1];

    $query = " && sclm_configurationitemtypes_id_c='".$cit_contact_contact."' && (contact_id_c='".$contact_a."' && name='".$contact_b."' || contact_id_c='".$contact_b."' && name='".$contact_a."' ) "; 

    #$compare_action = "by_contact";
    $compare_params[0] = $compare_action;
    $compare_params[1] = ""; # account
    $compare_params[2] = $contact_b; # contact
    $compare_params[3] = "";
    $compare_params[4] = "";       
    $compare_params[5] = "";
    $compare_params[6] = "";

   break; # $cit_contact_contact 
   case 'by_contacts_by_country': # my own
   
    $query = ""; 
       
   break;
   case 'by_contacts_all': # my own
   
    $query = ""; 
       
   break;  

  } # switch

  if ($compare_action != NULL){
     $compare_values = via ($compare_params);
     } # compare results
    
  $char_strength_cit = "7c726fb7-2947-6d40-734a-54ea110fd7e9"; # Character Strengths

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$char_strength_cit."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $charstrengths_title = $ci_items[$cnt]['name'];
         $charstrengths_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $charstrengths_description = str_replace("\n", "<br>", $charstrengths_description);

  #$viewall = "<a href=\"#\" onClick=\"loader('strengths');doBPOSTRequest('strengths','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=list&value=".$sess_contact_id."&valuetype=CharacterStrengths&sendiv=strengths');return false\"><font color=BLUE><B>Manage Character Strengths</B></font></a> <a href=\"#\" onClick=\"loader('strengths');doBPOSTRequest('strengths','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=listvals&value=".$sess_contact_id."&valuetype=CharacterStrengths&sendiv=strengths');return false\"><font color=BLUE><B>List Strengths</B></font></a>";

  #$charstrengths = "<div style=\"".$divstyle_white."\"><center><input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"Manage Wellbeing\" onClick=\"loader('lightfull');document.getElementById('lightfull').style.display='block';doBPOSTRequest('lightfull','Body.php','do=Wellbeing&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=lightfull');return false\"></center></div>";

  $link_top = "<a href=\"#top\"><B><font size=2 color=".$portal_font_colour.">[Top]</font></B></a> ";

  $charstrengths = "<a name=\"via\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour.">".$link_top."<B>".$charstrengths_title."</B></font></center></div>";

  $charstrengths .= "<div style=\"".$divstyle_blue."\"><center><B>Lower VIA scores represent your strongest areas...</B></center></div>";
  $charstrengths .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $charstrengths .= $charstrengths_description;
  $charstrengths .= "</div>";

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$char_strength_cit."' ";
  $ci_params[1] = "id,name,image_url"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = "name ASC"; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     $layer_one = "";

     for ($cnt=0;$cnt < count($ci_items);$cnt++){

         # Get the first layer 
         $ci_charstrengths_id = $ci_items[$cnt]['id'];
         $ci_charstrengths_title = $ci_items[$cnt]['name'];
         $ci_image_url = $ci_items[$cnt]['image_url'];

         #$layer_one .= $ci_charstrengths_title."<BR>";

         $lo_object_type = "ConfigurationItemTypes";
         $lo_action = "select";
         $lo_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$ci_charstrengths_id."' ";
         $lo_params[1] = "id,name,description,image_url"; // select array
         $lo_params[2] = ""; // group;
         $lo_params[3] = "name ASC"; // order;
         $lo_params[4] = ""; // limit
         
         $lo_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lo_object_type, $lo_action, $lo_params);

         $charstrengths_totalvalue = "";

         if (is_array($lo_items)){

            $layer_two = "";

            for ($locnt=0;$locnt < count($lo_items);$locnt++){

                # Get the second layer 
                $lo_charstrengths_id = $lo_items[$locnt]['id'];
                $lo_charstrengths_title = $lo_items[$locnt]['name'];
                $image_url = $lo_items[$locnt]['image_url'];
                $charstrengths_description = $lo_items[$locnt]['description'];

                #$layer_two .= $lo_charstrengths_title."<BR>";

                # Need to check any CI values here for the current user
                $lt_object_type = "ConfigurationItems";
                $lt_action = "select";
                $lt_params[0] = " deleted=0 && enabled=1 && sclm_configurationitemtypes_id_c='".$lo_charstrengths_id."' ".$query;
                $lt_params[1] = "id,name,description,contact_id_c,account_id_c"; // select array
                $lt_params[2] = ""; // group;
                $lt_params[3] = "name ASC"; // order;
                $lt_params[4] = ""; // limit
         
                $lt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lt_object_type, $lt_action, $lt_params);

                if (is_array($lt_items)){

                   $lt_charstrengths = "";

                   for ($ltcnt=0;$ltcnt < count($lt_items);$ltcnt++){
 
                       $charstrengths_id = $lt_items[$ltcnt]['id'];
                       $charstrengths_value = $lt_items[$ltcnt]['name'];
                       $charstrengths_totalvalue = $charstrengths_totalvalue+$charstrengths_value;

                       # Get country details of contact
                       $contact_id_c = $lt_items[$ltcnt]['contact_id_c'];
                       $account_id_c = $lt_items[$ltcnt]['account_id_c'];

                       if ($type != 'by_contact'){
                          $country_params[0] = 'by_contact';
                          $country_params[1] = $contact_id_c;
                          $country_details = $funky_gear->get_country($country_params);
                          $country_id = $country_details[0];
                          $country_name = $country_details[1];
                          }

                       # One Value - one count for each VIA strength
                       $own_score[$country_id][$charstrengths_value][$lo_charstrengths_id]['count']=1;

                       # One Value - aggregate number of VIA strength counts within the group
                       $global_score[$country_id][$charstrengths_value][$lo_charstrengths_id]['count']++;

                       if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth == 3){
                          $lt_charstrengths = "<div style=\"".$divstyle_white."\" id=\"".$lo_charstrengths_id."\" name=\"".$lo_charstrengths_id."\"><a href=\"#\" onClick=\"loader('".$lo_charstrengths_id."');".$blockbits."doBPOSTRequest('".$lo_charstrengths_id."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$charstrengths_id."&valuetype=ConfigurationItemTypes&sendiv=".$lo_charstrengths_id."');return false\"><font color=red><B>[".$charstrengths_value."]</B></font></a> <font color=BLUE><B>".$lo_charstrengths_title."</B></font> - ".$charstrengths_description."</div>";
                          } else {
                          $lt_charstrengths = "<div style=\"".$divstyle_white."\" id=\"".$lo_charstrengths_id."\" name=\"".$lo_charstrengths_id."\"><font color=BLUE><B>[".$charstrengths_value."]</B></font> <font color=BLUE><B>".$lo_charstrengths_title."</B></font> - ".$charstrengths_description."</div>";
                          }

                       $listedvals[$charstrengths_value] = $lt_charstrengths;

                       $total_count++;

                       } # for users

                   } else { # is array users

                     switch ($type){

                      case 'by_contact': # my own

                       if (($sess_contact_id != NULL && $sess_contact_id == $contacts) || $auth == 3){
                          $lt_charstrengths = "<div style=\"".$divstyle_white."\" id=\"".$lo_charstrengths_id."\" name=\"".$lo_charstrengths_id."\"> <a href=\"#\" onClick=\"loader('".$lo_charstrengths_id."');".$blockbits."doBPOSTRequest('".$lo_charstrengths_id."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$lo_charstrengths_id."&valuetype=ConfigurationItemTypes&sendiv=".$lo_charstrengths_id."');return false\"><font color=red><B>Add Value</B></font></a> <font color=BLUE><B>for ".$lo_charstrengths_title."</B></font> - ".$charstrengths_description."</div>";
                          } else {
                          $lt_charstrengths = "<div style=\"".$divstyle_white."\" id=\"".$lo_charstrengths_id."\" name=\"".$lo_charstrengths_id."\"> <font color=red><B>No Value</B></font> <font color=BLUE><B>for ".$lo_charstrengths_title."</B></font> - ".$charstrengths_description."</div>";

                          } 

                      break; # if contact

                     } # switch
                   
                   } # else 

                #$layer_two .= "<div style=\"".$divstyle_blue."\"> <img src=".$image_url." width=16> <B>".$lo_charstrengths_title."</B>".$lt_charstrengths."</div>";
                $layer_two .= $lt_charstrengths;

                } # for L2

            } # is array L2

         $layer_one .= "<div style=\"".$divstyle_blue."\"> <img src=".$ci_image_url." width=16> <B>".$ci_charstrengths_title." [Total Score:".$charstrengths_totalvalue."]</B>".$layer_two."</div>";

         $final_total = $final_total+$charstrengths_totalvalue;

         $parlistedvals[$charstrengths_totalvalue] = "<div style=\"".$divstyle_blue."\"> <img src=".$ci_image_url." width=16> <B>".$ci_charstrengths_title." [Total Score:".$charstrengths_totalvalue."]</B></div>";

         } # for L1

     } # is array L1

  #rsort ($listedvals);
  ksort ($listedvals);
  ksort ($parlistedvals);
  #array_multisort($listedvals);
  #sort($listedvals, ksort($listedvals));

  foreach ($listedvals as $strengthval=>$stregthshow){
          #echo "Key  $strengthval <BR>";
          $show_eachlayers .= $stregthshow;
          }

  foreach ($parlistedvals as $parstrengthval=>$parstregthshow){
          #echo "Key  $strengthval <BR>";
          $show_parlayers .= $parstregthshow;
          }

  $charstrengths .= $show_parlayers.$show_eachlayers.$layer_one;
  #$charstrengths .= $show_parlayers.$show_eachlayers;

  # One Value - one count for each VIA strength
  #$own_score[$country_id][$charstrengths_value][$lo_charstrengths_id]['count']=1;

  #var_dump($own_score);

  foreach ($own_score as $country_id => $country_vals){

          $country_details = $funky_gear->object_returner ("Countries", $country_id);
          $country_name = $country_details[0];
          #echo "Country  $country_name<BR>";

          ksort ($country_vals);

          foreach ($country_vals as $strengthval => $strengthval_cit_array){

                  #echo "Value  $strengthval<BR>";

                  foreach ($strengthval_cit_array as $strength_cit => $strength_count){

                          #echo "CIT  ".$strength_cit." [".$strength_count['count']."]<BR>";

                          }

                  } # foreach

          } # foreach

  # One Value - aggregate number of VIA strength counts within the group
  #$global_score[$country_id][$charstrengths_value][$lo_charstrengths_id]['count']++;

  #var_dump($global_score);

  foreach ($global_score as $globalscorevals){

          #$globalscorevals

          } # foreach

  #echo "<div style=\"".$divstyle_white."\"> <B>Total VIA Score: ".$final_total."</B>".$show_layers;

  # Do this for all 24 values
  #$compare_score_one = $compare_values[0];
  #$score_one = ($my_score_one/$compare_score_one)*10;
  #$final_score = ($score_one+$score_two+$score_three+++++)/24;

  #$via_content .= "<div style='width: 98%; max-height:500px;overflow:scroll; padding: 0.5em; resize: both;'>".$show_layers."</div>";

  $total_score = $final_total;
  $avg_score = $total_score/$total_count;

  $return_values[0] = $charstrengths;
  $return_values[1] = $total_score;
  $return_values[2] = $total_count;
  $return_values[3] = $avg_score;

return $return_values; 

} # end function
  
# VIA
#####################
# Leadership

function leadership ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

  switch ($type){

   case 'by_contact': # my own

    $query = " && contact_id_c='".$contacts."' "; 
    #$compare_action = "by_contacts_all";

    $country_params[0] = 'by_contact';
    $country_params[1] = $contacts;
    $country_details = $funky_gear->get_country($country_params);
    $country_id = $country_details[0];
    $country_name = $country_details[1];
  
   break;
   case 'by_contact_to_contact':

    $contact_a = $contacts[0];
    $contact_b = $contacts[1];

    $query = " && sclm_configurationitemtypes_id_c='".$cit_contact_contact."' && (contact_id_c='".$contact_a."' && name='".$contact_b."' || contact_id_c='".$contact_b."' && name='".$contact_a."' ) "; 

    #$compare_action = "by_contact";
    $compare_params[0] = $compare_action;
    $compare_params[1] = ""; # account
    $compare_params[2] = $contact_b; # contact
    $compare_params[3] = "";
    $compare_params[4] = "";       
    $compare_params[5] = "";
    $compare_params[6] = "";

   break; # $cit_contact_contact 
   case 'by_contacts_by_country': # my own
   
    $query = ""; 
       
   break;
   case 'by_contacts_all': # my own
   
    $query = ""; 
       
   break;  

  } # switch


  # An important measure of an individual and a company's total leadership value
  # Members should be able to grade/vote for each other

  $leadership_cit = "41505b3d-0041-a748-ba99-552186d26088"; # Positive Leadership

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$leadership_cit."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $leadership_title = $ci_items[$cnt]['name'];
         $leadership_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $leadership_description = str_replace("\n", "<br>", $leadership_description);

  $link_top = "<a href=\"#top\"><B><font size=2 color=".$portal_font_colour.">[Top]</font></B></a> ";

  $leadership = "<a name=\"leadership\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour.">".$link_top."<B>".$leadership_title."</B></font></center></div>";
  $leadership .= "<div style=\"".$divstyle_blue."\"><center><B>Higher scores represent your strongest areas...</B></center></div>";
  $leadership .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $leadership .= $leadership_description;
  $leadership .= "</div>";

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$leadership_cit."' ";
  $ci_params[1] = "id,name,image_url"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = "name ASC"; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     $layer_one = "";

     for ($cnt=0;$cnt < count($ci_items);$cnt++){

         # Get the first layer 
         $ci_leadership_id = $ci_items[$cnt]['id'];
         $ci_leadership_title = $ci_items[$cnt]['name'];
         $ci_image_url = $ci_items[$cnt]['image_url'];

         #$layer_one .= $ci_charstrengths_title."<BR>";

         $lo_object_type = "ConfigurationItemTypes";
         $lo_action = "select";
         $lo_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$ci_leadership_id."' ";
         $lo_params[1] = "id,name,description,image_url"; // select array
         $lo_params[2] = ""; // group;
         $lo_params[3] = "name ASC"; // order;
         $lo_params[4] = ""; // limit
         
         $lo_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lo_object_type, $lo_action, $lo_params);

         $leadership_totalvalue = "";

         if (is_array($lo_items)){

            $layer_two = "";

            for ($locnt=0;$locnt < count($lo_items);$locnt++){

                # Get the second layer 
                $lo_leadership_id = $lo_items[$locnt]['id'];
                $lo_leadership_title = $lo_items[$locnt]['name'];
                $image_url = $lo_items[$locnt]['image_url'];
                $lo_leadership_description = $lo_items[$locnt]['description'];

                #$layer_two .= $lo_charstrengths_title."<BR>";

                # Need to check any CI values here for the current user
                $lt_object_type = "ConfigurationItems";
                $lt_action = "select";
                $lt_params[0] = " deleted=0 && enabled=1 && sclm_configurationitemtypes_id_c='".$lo_leadership_id."' ".$query;
                $lt_params[1] = "id,name,contact_id_c,account_id_c"; // select array
                $lt_params[2] = ""; // group;
                $lt_params[3] = "name ASC"; // order;
                $lt_params[4] = ""; // limit
         
                $lt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $lt_object_type, $lt_action, $lt_params);

                if (is_array($lt_items)){

                   $lt_leadership = "";

                   for ($ltcnt=0;$ltcnt < count($lt_items);$ltcnt++){
 
                       $leadership_id = $lt_items[$ltcnt]['id'];
                       $leadership_value = $lt_items[$ltcnt]['name'];
                       $leadership_totalvalue = $leadership_totalvalue+$leadership_value;

                       # Get country details of contact
                       $contact_id_c = $lt_items[$ltcnt]['contact_id_c'];
                       $account_id_c = $lt_items[$ltcnt]['account_id_c'];

                       if ($type != 'by_contact'){
                          $country_params[0] = 'by_contact';
                          $country_params[1] = $contact_id_c;
                          $country_details = $funky_gear->get_country($country_params);
                          $country_id = $country_details[0];
                          $country_name = $country_details[1];
                          }

                       # One Value - one count for each VIA strength
                       $own_score[$country_id][$leadership_value][$leadership_id]['count']=1;

                       # One Value - aggregate number of VIA strength counts within the group
                       $global_score[$country_id][$leadership_value][$leadership_id]['count']++;

                       if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth == 3){

                          $namer = "<a href=\"#\" onClick=\"loader('".$lo_leadership_id."');".$blockbits."doBPOSTRequest('".$lo_leadership_id."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$leadership_id."&valuetype=ConfigurationItemTypes&sendiv=".$lo_leadership_id."');return false\"><font color=red><B>[".$leadership_value."]</B></font></a>";

                          } else {# if 

                          $namer = "<font color=blue><B>[".$leadership_value."]</B></font>";

                          } # if contact/auth

                       $lt_leadership .= "<div style=\"".$divstyle_white."\" id=\"".$lo_leadership_id."\" name=\"".$lo_leadership_id."\">".$namer." <font color=BLUE><B>".$lo_leadership_title."</B></font> - ".$lo_leadership_description."</div>";

                       $listedvals[$leadership_value] = $lt_leadership;

                       $total_count++;

                       } # for users

                   } else { # is array users

                   $lt_leadership = "<div style=\"".$divstyle_white."\" id=\"".$lo_leadership_id."\" name=\"".$lo_leadership_id."\"> <a href=\"#\" onClick=\"loader('".$lo_leadership_id."');".$blockbits."doBPOSTRequest('".$lo_leadership_id."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$lo_leadership_id."&valuetype=ConfigurationItemTypes&sendiv=".$lo_leadership_id."');return false\"><font color=red><B>Add Value</B></font></a> <font color=BLUE><B>for ".$lo_leadership_title."</B></font> - ".$lo_leadership_description."</div>";

                   $leadership_value = "";
                   $listedvals[$leadership_value] = $lt_leadership;

                   } 

                $layer_two .= $lt_leadership;

                $lt_leadership = "";

                } # for L2

            } # is array L2

         $layer_one .= "<div style=\"".$divstyle_white."\"> <B>".$ci_leadership_title." [Total Score: ".$leadership_totalvalue."]</B>".$layer_two."</div>";

         $final_total = $final_total+$leadership_totalvalue;

         $parlistedvals[$leadership_totalvalue] = "<div style=\"".$divstyle_blue."\"> <B>".$ci_leadership_title." [Total Score: ".$leadership_totalvalue."]</B></div>";

         } # for L1

     } # is array L1

  #rsort ($listedvals);
  rsort ($listedvals);
  rsort ($parlistedvals);
  #array_multisort($listedvals);
  #sort($listedvals, ksort($listedvals));

  foreach ($listedvals as $strengthval=>$stregthshow){
          #echo "Key  $strengthval <BR>";
          $show_eachlayers .= $stregthshow;
          }

  foreach ($parlistedvals as $parstrengthval=>$parstregthshow){
          #echo "Key  $strengthval <BR>";
          $show_parlayers .= $parstregthshow;
          }

  $leadership .= $layer_one;
  #$leadership .= $show_parlayers.$show_eachlayers.$layer_two;
  #$leadership .= $show_parlayers.$show_eachlayers;

  # One Value - one count for each VIA strength
  #$own_score[$country_id][$charstrengths_value][$lo_charstrengths_id]['count']=1;

  #var_dump($own_score);

  #foreach ($own_score as $country_id => $country_vals){

          #$country_details = $funky_gear->object_returner ("Countries", $country_id);
          #$country_name = $country_details[0];
          #echo "Country  $country_name<BR>";

          #ksort ($country_vals);

          #foreach ($country_vals as $strengthval => $strengthval_cit_array){

                  #echo "Value  $strengthval<BR>";

                  #foreach ($strengthval_cit_array as $strength_cit => $strength_count){

                          #echo "CIT  ".$strength_cit." [".$strength_count['count']."]<BR>";

                         # }

                  #} # foreach

         # } # foreach

  # One Value - aggregate number of VIA strength counts within the group
  #$global_score[$country_id][$charstrengths_value][$lo_charstrengths_id]['count']++;

  #var_dump($global_score);

  #foreach ($global_score as $globalscorevals){

          #$globalscorevals

  #        } # foreach

  #echo "<div style=\"".$divstyle_white."\"> <B>Total VIA Score: ".$final_total."</B>".$show_layers;

  # Do this for all 24 values
  #$compare_score_one = $compare_values[0];
  #$score_one = ($my_score_one/$compare_score_one)*10;
  #$final_score = ($score_one+$score_two+$score_three+++++)/24;

  #$via_content .= "<div style='width: 98%; max-height:500px;overflow:scroll; padding: 0.5em; resize: both;'>".$show_layers."</div>";

  $total_score = $final_total;
  $avg_score = round($total_score/$total_count,2);

  $return_values[0] = $leadership;
  $return_values[1] = $total_score;
  $return_values[2] = $total_count;
  $return_values[3] = $avg_score;

  return $return_values; 
  
} # end function

# Leadership
#####################
# AI

function ai ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

  switch ($type){

   case 'by_contact': # my own

    $query = " && contact_id_c='".$contacts."' "; 
    #$compare_action = "by_contacts_all";

    $country_params[0] = 'by_contact';
    $country_params[1] = $contacts;
    $country_details = $funky_gear->get_country($country_params);
    $country_id = $country_details[0];
    $country_name = $country_details[1];
  
   break;
   case 'by_contact_to_contact':

    $contact_a = $contacts[0];
    $contact_b = $contacts[1];

    $query = " && sclm_configurationitemtypes_id_c='".$cit_contact_contact."' && (contact_id_c='".$contact_a."' && name='".$contact_b."' || contact_id_c='".$contact_b."' && name='".$contact_a."' ) "; 

    #$compare_action = "by_contact";
    $compare_params[0] = $compare_action;
    $compare_params[1] = ""; # account
    $compare_params[2] = $contact_b; # contact
    $compare_params[3] = "";
    $compare_params[4] = "";       
    $compare_params[5] = "";
    $compare_params[6] = "";

   break; # $cit_contact_contact 
   case 'by_contacts_by_country': # my own
   
    $query = ""; 
       
   break;
   case 'by_contacts_all': # my own
   
    $query = ""; 
       
   break;  

  } # switch

  $cit_ai = "128def00-ce41-4ff8-e9b0-552184cc5e63"; # Appreciative Inquiry

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$cit_ai."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $ai_title = $ci_items[$cnt]['name'];
         $ai_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $ai_description = str_replace("\n", "<br>", $ai_description);

  $link_top = "<a href=\"#top\"><B><font size=2 color=".$portal_font_colour.">[Top]</font></B></a> ";

  $ai_content = "<a name=\"ai\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour.">".$link_top."<B>".$ai_title."</B></font></center></div>";
  $ai_content .= "<div style=\"".$divstyle_blue."\"><center><B>Higher AI scores represent your strongest areas...</B></center></div>";
  $ai_content .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $ai_content .= $ai_description;
  $ai_content .= "</div>";

  $cis_object_type = "ConfigurationItemTypes";
  $cis_action = "select";  
  $cis_params[0] = "sclm_configurationitemtypes_id_c='".$cit_ai."' ";
  $cis_params[1] = "id,name";
  $cis_params[2] = "";
  $cis_params[3] = "name ASC";
  $cis_params[4] = "";
  
  $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cis_object_type, $cis_action, $cis_params);

  if (is_array($cis_list)){

     $this_subtotal_count = ""; 
     $this_subtotal = "";

     for ($cnt=0;$cnt < count($cis_list);$cnt++){

         $cit = $cis_list[$cnt]['id'];
         $ai_heading = $cis_list[$cnt]['name'];

         # Sub-headings of Pesh - used to get individual items

         $val_object_type = "ConfigurationItems";
         $val_action = "select";  
         $cis_val_params[0] = "sclm_configurationitemtypes_id_c='".$cit."' ".$query;
         $cis_val_params[1] = "id,name,contact_id_c,account_id_c";
         $cis_val_params[2] = "";
         $cis_val_params[3] = "name ASC";
         $cis_val_params[4] = "";
 
         $cis_val_list = api_sugar($crm_api_user, $crm_api_pass, $crm_wsdl_url, $val_object_type, $val_action, $cis_val_params);

         if (is_array($cis_val_list)){

            $this_value = "";

            for ($valcnt=0;$valcnt < count($cis_val_list);$valcnt++){
     
                $sub_ci = $cis_val_list[$valcnt]['id'];
                $this_value = $cis_val_list[$valcnt]['name'];
                $contact_id_c = $cis_val_list[$valcnt]['contact_id_c'];
                       
                $namer = "";

                if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth == 3){

                   $namer = "<a href=\"#ai\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$sub_ci."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>[".$this_value."]</B></font></a>";

                   } else {# if 

                   $namer = "<font color=blue><B>[".$this_value."]</B></font>";

                   } # if contact/auth
                          
                $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$cit."\" name=\"".$cit."\">".$namer." <font color=blue><B>".$ai_heading."</B></font></div>";

                $total_score = $total_score + $this_value;
                $total_count++;

                } # for values
                
            } else {# is array values

            $namer = "";

            if ($sess_contact_id != NULL || $auth == 3){

               $namer = "<a href=\"#ai\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$cit."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>Add Value</B></font></a>";

               } else { # if auth

               $namer = "No Value";

               }

            $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$cit."\" name=\"".$cit."\">".$namer." <font color=BLUE><B>".$ai_heading."</B></font></div>";
                   
            } # if no value

         } # for headings
         
     } # is array headings
     
  if ($total_count>0){
     $avg_score = round($total_score/$total_count,0);
     } else {
     $total_count = 0;
     $total_score = 0;
     $avg_score = 0;
     } 

  $ai_content .= $score_list;

  $return_values[0] = $ai_content;
  $return_values[1] = $total_score;
  $return_values[2] = $total_count;
  $return_values[3] = $avg_score;

  return $return_values; 

} # end function

# AI
#####################
# Cloudsultancy

function cloudsultancy ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];


  # The Cloudsultant's Profile | ID: 9e786955-c6f1-5420-fda9-5521ce8daa5e
  
  # Present based on Cloudsultancy Mix (CITs within a CIT - collect all)
  # Percentage as CI value based on CIT
  # Present as PIE Graph.. 
  # Sales Person %
  # Technologist %
  # Solution Architect %
  # Product Manager %
  # Product Marketing Manager %
  # Project Manager %
  # Transition Manager %
  # Service Delivery Manager %
  # Engineer %
  # Developer %

  # Being a Consultant | ID: cca9638c-86c6-929a-0d7d-5521d0f157f4
  # Being a Developer | ID: 1389c1fa-7f2a-1e97-f366-5521d0f52e12
  # Being a Product Manager | ID: d7a08412-90d5-7459-d8d9-5521cf24906d
  # Being a Product Marketing Manager | ID: 3a660f35-3f61-0865-38d8-5521cfd093b2
  # Being a Project Manager | ID: 46795768-4a6c-cede-07eb-5521cf365b19
  # Being a Salesperson | ID: e0ec91d1-821c-5879-2ace-5521ce4fc07b
  # Being a Service Delivery Manager | ID: 9108cafa-fd39-6979-810c-5521cfe4e968
  # Being a Solution Architect | ID: 4baa82e6-b7f2-67c3-a6fb-5521cff5dd28
  # Being a Technologist | ID: 6dbc5ee4-da57-f9e6-d73f-5521cff9774b
  # Being a Transition Manager | ID: 8e550296-0696-df64-90c2-5521cf1995fc
  # Being an Engineer | ID: c9ed3886-6355-564a-cfca-5521d0d67dce

  # First get particular contact-to-contact;
  switch ($type){

   case 'by_contact': # my own

    $query = " && contact_id_c='".$contacts."' "; 
    #$compare_action = "by_contacts_all";

    $country_params[0] = 'by_contact';
    $country_params[1] = $contacts;
    $country_details = $funky_gear->get_country($country_params);
    $country_id = $country_details[0];
    $country_name = $country_details[1];
  
   break;
   case 'by_contact_to_contact':

    $contact_a = $contacts[0];
    $contact_b = $contacts[1];

    $query = " && sclm_configurationitemtypes_id_c='".$cit_contact_contact."' && (contact_id_c='".$contact_a."' && name='".$contact_b."' || contact_id_c='".$contact_b."' && name='".$contact_a."' ) "; 

    #$compare_action = "by_contact";
    $compare_params[0] = $compare_action;
    $compare_params[1] = ""; # account
    $compare_params[2] = $contact_b; # contact
    $compare_params[3] = "";
    $compare_params[4] = "";       
    $compare_params[5] = "";
    $compare_params[6] = "";

   break; # $cit_contact_contact 
   case 'by_contacts_by_country': # my own
   
    $query = ""; 
       
   break;
   case 'by_contacts_all': # my own
   
    $query = ""; 
       
   break;  

  } # switch


  $cit_cloud = "9e786955-c6f1-5420-fda9-5521ce8daa5e"; # Cloud Consultancy

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && id='".$cit_cloud."' ";
  $ci_params[1] = "name,description"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($ci_items)){

     for ($cnt=0;$cnt < count($ci_items);$cnt++){
 
         #$charstrengths_id = $ci_items[$cnt]['id'];
         $cloud_title = $ci_items[$cnt]['name'];
         $cloud_description = $ci_items[$cnt]['description'];

         } # for

     } # for

  $cloud_description = str_replace("\n", "<br>", $cloud_description);

  $link_top = "<a href=\"#top\"><B><font size=2 color=".$portal_font_colour.">[Top]</font></B></a> ";

  $cloud_content = "<a name=\"cloudsultancy\"></a><div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour.">".$link_top."<B>".$cloud_title."</B></font></center></div>";
  $cloud_content .= "<div style=\"".$divstyle_blue."\"><center><B>Higher Cloudsultancy scores represent your strongest areas...</B></center></div>";
  $cloud_content .= "<div id=strengths name=strengths style=\"".$divstyle_orange_light."\">";
  $cloud_content .= $cloud_description;
  $cloud_content .= "</div>";

  $ci_object_type = "ConfigurationItemTypes";
  $ci_action = "select";
  $ci_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$cit_cloud."' ";
  $ci_params[1] = "id,name"; // select array
  $ci_params[2] = ""; // group;
  $ci_params[3] = ""; // order;
  $ci_params[4] = ""; // limit
  
  $total_count = 0;
  $total_score = 0;
  $score_list = "";
  
  $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($cis_list)){

     $this_subtotal_count = ""; 
     $this_subtotal = "";

     for ($cnt=0;$cnt < count($cis_list);$cnt++){

         $cit = $cis_list[$cnt]['id'];
         $cloud_heading = $cis_list[$cnt]['name'];

         # Sub-headings of Pesh - used to get individual items

         $val_object_type = "ConfigurationItems";
         $val_action = "select";  
         $cis_val_params[0] = "sclm_configurationitemtypes_id_c='".$cit."' ".$query;
         $cis_val_params[1] = "id,name,contact_id_c,account_id_c";
         $cis_val_params[2] = "";
         $cis_val_params[3] = "name ASC";
         $cis_val_params[4] = "";
 
         $cis_val_list = api_sugar($crm_api_user, $crm_api_pass, $crm_wsdl_url, $val_object_type, $val_action, $cis_val_params);

         if (is_array($cis_val_list)){

            $this_value = "";

            for ($valcnt=0;$valcnt < count($cis_val_list);$valcnt++){
     
                $sub_ci = $cis_val_list[$valcnt]['id'];
                $this_value = $cis_val_list[$valcnt]['name'];
                $contact_id_c = $cis_val_list[$valcnt]['contact_id_c'];
                       
                $namer = "";

                if (($sess_contact_id != NULL && $sess_contact_id == $contact_id_c) || $auth == 3){

                   $namer = "<a href=\"#cloudsultancy\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=edit&value=".$sub_ci."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>[".$this_value."]</B></font></a>";

                   } else {# if 

                   $namer = "<font color=blue><B>[".$this_value."]</B></font>";

                   } # if contact/auth
                          
                $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$cit."\" name=\"".$cit."\">".$namer." <font color=blue><B>".$cloud_heading."</B></font></div>";

                $total_score = $total_score + $this_value;
                $total_count++;

                } # for values
                
            } else {# is array values

            $namer = "";

            if ($sess_contact_id != NULL || $auth == 3){

               $namer = "<a href=\"#cloudsultancy\" onClick=\"loader('".$cit."');".$blockbits."doBPOSTRequest('".$cit."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=".$cit."&valuetype=ConfigurationItemTypes&sendiv=".$cit."');return false\"><font color=red><B>Add Value</B></font></a>";

               } else { # if auth

               $namer = "No Value";

               }

            $score_list .= "<div style=\"".$divstyle_white."\" id=\"".$cit."\" name=\"".$cit."\">".$namer." <font color=BLUE><B>".$cloud_heading."</B></font></div>";
                   
            } # if no value

         } # for headings
         
     } # is array headings
     
  if ($total_count>0){
     $avg_score = round($total_score/$total_count,0);
     } else {
     $total_count = 0;
     $total_score = 0;
     $avg_score = 0;
     } 

  $cloud_content .= $score_list;
      
  $return_values[0] = $cloud_content;
  $return_values[1] = $total_score;
  $return_values[2] = $total_count;
  $return_values[3] = $avg_score;

  return $return_values; 

} # end function 

# Cloudsultancy
#####################
# Lifestyle

  # Events can be created from a lifestyle category
  # Products can be "owned", liked and purchased/serviced from Lifestyle categories
  # Will provide CMV as well as opportunities, events and a marketplace
  # Lifestyle will provide character to the events and behaviour that will be enabled by each individual's PESH and PERMA
  
# Lifestyle
#####################
# Social Networking

function social_networking ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

  # Types = Contacts All (Contacts-Contacts) Contact-to-Contact || Account-to-Account (total of all Accounts' Contacts)
  $cit_contact_contact = '';
  
  # First get particular contact-to-contact;
  switch ($type){
  
   case 'by_contact_sn':
    
    $contact_a = $contacts[0];
    $contact_b = $contacts[1];
    
    $query = " sclm_configurationitemtypes_id_c='".$cit_contact_contact."' && (contact_id_c='".$contact_a."' && name='".$contact_b."' || contact_id_c='".$contact_b."' && name='".$contact_a."' ) "; 
    
   break; # $cit_contact_contact 
  
  } # switch

  $object_type = "ConfigurationItems";
  $action = "select";
  
  $total_count = 0;
  $total_score = 0;
  $score_list = "";
  
  $cis_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

  if (is_array($cis_list)){

     for ($cnt=0;$cnt < count($cis_list);$cnt++){
     
         $cid = $cis_list[$cnt]['id'];
         $cit = $cis_list[$cnt]['sclm_configurationitemtypes_id_c'];
         $name = "";

         if ($cit == $cit_being_sales){
            # Only required if this is a special value
            }
            
         $label_ret = object_return ($object_type, $cit);
         $label = $label_ret[0];
         $score_list .= "<div style=\"".$div_style_white."\"><B>".$label." [".$name."]</div>";
         $total_score = $total_score + $name;
         $total_count++;
         
         } # for
         
     $avg_score = round($total_score/$total_count,0);
      
     } # is array
    
$return_values[0] = $score_list;
$return_values[1] = $total_score;
$return_values[2] = $total_count;
$return_values[3] = $avg_score;

return $return_values; 

} # end function

# Social Network
#####################
# Wellbeing

function wellbeing ($params){

  global $funky_gear,$lingo, $auth, $sess_contact_id, $sess_account_id,$divstyle_blue,$divstyle_white,$divstyle_orange_light,$custom_portal_divstyle,$portal_font_colour,$blockbits;

  $type = $params[0];  
  $accounts = $params[1];
  $contacts = $params[2];
  $products = $params[3];
  $categories = $params[4];
  $events = $params[5];
  $country = $params[6];

  
  # Use CITs and CIs to gather the various data
  
  # CMV
  
  # SharedEffects
  
  # RealPolitika
  
  # Availability
   
  # Occupations
  
  # Certification
  
  # Education
  
  # Work Experience - Occupations
  
  # Present based on Customer Ratings
  
  # Present based on SLAs

  # Present based on VIA (Strengths & Weaknesses as CITs)
  # Score as CI value based on CIT
  # Sets - to allow for before/after/versions 
  
  # Contacts' own wellbeing
  # Algorithm
  # PESH are enablers or accelerators and thus influence the values within PERMA
  # PERMA values are 1/10 for each item and total is the average result
  # AI is same
  # Positive Leadership is same
  # Lifestyle captures positive emotions from events within each category

  $via_values = $this->via ($params); 
  $via_avg_score = $via_values[3];  

  $pesh_values = $this->pesh ($params); 
  $pesh_avg_score = $pesh_values[3];
  
  $perma_values = $this->perma ($params); 
  $perma_avg_score = $perma_values[3];
  
  $ai_values = $this->ai ($params); 
  $ai_avg_score = $ai_values[3];
  
  $leadership_values = $this->leadership ($params);
  $leadership_avg_score = $leadership_values[3];
    
  #$lifestyle_values = $this->lifestyle ($params); 
  #$lifestyle_avg_score = $lifestyle_values[3];

  $cloudsultancy_values = $this->cloudsultancy ($params); 
  $cloudsultancy_avg_score = $cloudsultancy_values[3];

  if (!$via_avg_score){
     $via_avg_score = 1;
     }

  if (!$pesh_avg_score){
     $pesh_avg_score = 1;
     }

  if (!$perma_avg_score){
     $perma_avg_score = 1;
     }

  if (!$ai_avg_score){
     $ai_avg_score = 1;
     }

  if (!$leadership_avg_score){
     $leadership_avg_score = 1;
     }

  if (!$lifestyle_avg_score){
     $lifestyle_avg_score = 1;
     }

  if (!$cloudsultancy_avg_score){
     $cloudsultancy_avg_score = 1;
     }

  # Provides the well-being for a selection - not relative to all available
  $wellbeing_score = $pesh_avg_score*(($via_avg_score+$perma_avg_score+$ai_avg_score+$leadership_avg_score+$lifestyle_avg_score+$cloudsultancy_avg_score)/6);
  #$wellbeing_score = $pesh_avg_score*(($via_avg_score+$perma_avg_score+$ai_avg_score+$leadership_avg_score+$cloudsultancy_avg_score)/5);

  $wellbeing_score = ROUND($wellbeing_score,2);

 
  # Collect average score globally to provide a globally relative score
  
  switch ($type){
  
   case 'by_account':
    $global_relater = 'by_accounts_all';
   break;
   case 'by_contact':
    $global_relater = 'by_contacts_all';
   break;
   case 'by_event':
    $global_relater = 'by_events_all';
   break;
   case 'by_category':
    $global_relater = 'by_categories_all';
   break;
   case 'by_product':
    $global_relater = 'by_products_all';
   break;
   case 'by_contact_sn':
    $global_relater = 'by_contacts_sn_all';
   break;
   case 'by_account_sn':
    $global_relater = 'by_accounts_sn_all';
   break;
     
  } # switch

  /*
  if ($global_relator != NULL){
  
     $gwb_params[0] = ""; # Account
     $gwb_params[1] = ""; # Contact
     $gwb_params[2] = ""; # Product/Service
     $gwb_params[3] = ""; # Category
     $gwb_params[4] = ""; # Event
     $gwb_params[5] = $global_relator; # Type

     $global_wellbeing_scores = wellbeing($gwb_params);

     $global_wb_pesh_score = $global_wellbeing_scores[0];
     $global_wb_perma_score = $global_wellbeing_scores[1];
     $global_wb_ai_score = $global_wellbeing_scores[2];
     $global_wb_leadership_score = $global_wellbeing_scores[3];
     $global_wb_lifestyle_score = $global_wellbeing_scores[4];
     $global_wb_score = $global_wellbeing_scores[6];
  
     } # if global relator

  */
   
  $return_values[0] = $pesh_avg_score;
  $return_values[1] = $perma_avg_score;
  $return_values[2] = $via_avg_score;
  $return_values[3] = $ai_avg_score;
  $return_values[4] = $leadership_avg_score;
  $return_values[5] = $lifestyle_avg_score;
  $return_values[6] = $cloudsultancy_avg_score;
  $return_values[7] = $wellbeing_score;
  $return_values[8] = $global_wb_score;

  return $return_values;

} # End function wellbeing

  # Wellbeing

} # end class funky_messaging

##########################################################
?>