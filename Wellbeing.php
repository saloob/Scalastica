<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-04-07
# Page: Wellbeing.php 
##########################################################
# case 'Wellbeing':

#####################
# CMV

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     if (!$sendiv){
        $sendiv = $BodyDIV;
        }
     }

  if ($sendiv == 'lightform'){
     $blockbits = "document.getElementById('".$sendiv."').style.display='block';";
     }

  #######################
  # Present the wellbeing answers
  
  switch ($action){
  
   case 'by_account': # Get own values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = $val; # Account
    $wb_params[2] = ""; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country
      
   break;
   case 'by_accounts_all': # Get own values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = ""; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country 
      
   break;
   case 'by_contact': # Get own values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = $val; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country 
      
   break;
   case 'by_contacts_all': # Get ALL values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = ""; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country 
      
   break;
   case 'by_product': # Get own values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = ""; # Contact
    $wb_params[3] = $val; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country   
      
   break;
   case 'by_category': # Get own values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = ""; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = $val; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country     
      
   break;
   case 'by_event': # Get own values

    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = ""; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = $val; # Event
    $wb_params[6] = ""; # Country     
      
   break;
   case 'by_contact_category': # Get additional values

    $contact_id = $_POST['contact_id'];
    $category_id = $_POST['category_id'];
     
    $wb_params[0] = $action; # Type   
    $wb_params[1] = ""; # Account
    $wb_params[2] = $contact_id; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = $category_id; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country     
      
   break;
   case 'by_contact_events': # Get additional values

    $contact_id = $_POST['contact_id'];
    $event_id = $_POST['event_id'];

    $wb_params[0] = $action; # Type        
    $wb_params[1] = ""; # Account
    $wb_params[2] = $contact_id; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = $event_id; # Event
    $wb_params[6] = ""; # Country     
      
   break;
   case 'by_contact_to_contact': # Get additional values

    $contact_id_a = $_POST['contact_id_a'];
    $contact_id_b = $_POST['contact_id_b'];

    $contacts[0] = $contact_id_a;
    $contacts[1] = $contact_id_b;
     
    $wb_params[0] = $action; # Type        
    $wb_params[1] = ""; # Account
    $wb_params[2] = $contacts; # Contact
    $wb_params[3] = ""; # Product/Service
    $wb_params[4] = ""; # Category
    $wb_params[5] = ""; # Event
    $wb_params[6] = ""; # Country   
      
   break;
   
  } # action switch

  # Finally use the params to grab the contents
  #$wellbeing_score_vals = wellbeing($wb_params);
  #$score_list = $wellbeing_score_vals[0];
  #$total_score = $wellbeing_score_vals[1];
  #$total_count = $wellbeing_score_vals[2];
  #$avg_score = $wellbeing_score_vals[3];

  #$via_result = "<div style=\"".$divstyle_white."\">".$via_score_list."</div>"; # show any results as links
  
  # Present the actual circles with values 
  # Present other results as circles;
  # SN - contact-to-contact = two circles with average strength between the two
  # Present within layered, coloured divs with main circle at the top, going down in strength
  # 500 - 400 || 300-399 || 200-299 || 100-199 || 0-99 
  
# End wellbeing
##########################


  switch ($action){

   case 'view':

    $refresh = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"Refresh\" onClick=\"loader('lightfull');".$blockbits."doBPOSTRequest('lightfull','Body.php','do=Wellbeing&action=view&value=".$val."&valuetype=".$valtype."&sendiv=lightfull');return false\">";

    $closer = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wellbeing\" id=\"wellbeing\" value=\"".$strings["Close"]."\" onClick=\"cleardiv('lightfull');cleardiv('fade');document.getElementById('lightfull').style.display='none';document.getElementById('fade').style.display='none';return false\">";

    if ($sendiv == 'lightform'){
       echo "<center>".$closer." - ".$refresh."</center><P>";
       }

    ##############################
    # Whatever results come back to put into a scrollable div
    # Provide a link to show the values in the circles relative to Account || Global || Country || Gender

    $wb_params = "";

    switch ($valtype){

     case 'Contacts':

      $wb_action = 'by_contact';
      $wb_params[0] = $wb_action; # Type
      $wb_params[1] = ""; # Account
      $wb_params[2] = $val; # Contact
      $wb_params[3] = ""; # Product/Service
      $wb_params[4] = ""; # Category
      $wb_params[5] = ""; # Event
      $wb_params[6] = ""; # Country 

     break;

    } # switch valtype

    $via_results = $funky_wellbeing->via($wb_params);
    $via_content = $via_results[0];
    $via_total_score = $via_results[1];
    $via_total_count = $via_results[2];
    $via_avg_score = $via_results[3];

    $pesh_results = $funky_wellbeing->pesh($wb_params);
    $pesh_content = $pesh_results[0];
    $pesh_total_score = $pesh_results[1];
    $pesh_total_count = $pesh_results[2];
    $pesh_avg_score = $pesh_results[3];

    $perma_results = $funky_wellbeing->perma($wb_params);
    $perma_content = $perma_results[0];
    $perma_total_score = $perma_results[1];
    $perma_total_count = $perma_results[2];
    $perma_avg_score = $perma_results[3];

    $leadership_results = $funky_wellbeing->leadership($wb_params);
    $leadership_content = $leadership_results[0];
    $leadership_total_score = $leadership_results[1];
    $leadership_total_count = $leadership_results[2];
    $leadership_avg_score = $leadership_results[3];

    $ai_results = $funky_wellbeing->ai($wb_params);
    $ai_content = $ai_results[0];
    $ai_total_score = $ai_results[1];
    $ai_total_count = $ai_results[2];
    $ai_avg_score = $ai_results[3];

    $cloudsultancy_results = $funky_wellbeing->cloudsultancy($wb_params);
    $cloudsultancy_content = $cloudsultancy_results[0];
    $cloudsultancy_total_score = $cloudsultancy_results[1];
    $cloudsultancy_total_count = $cloudsultancy_results[2];
    $cloudsultancy_avg_score = $cloudsultancy_results[3];

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

    $wellbeing_score = $pesh_avg_score*(($via_avg_score+$perma_avg_score+$ai_avg_score+$leadership_avg_score+$lifestyle_avg_score+$cloudsultancy_avg_score)/6);

    $wellbeing_score = ROUND($wellbeing_score,2);

    # 
    ##############################
    # Provide selections box for types;

    if ($auth == 3){
       $wb_selections .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Admin Well-being Variations</B></font></center></div>";  
       $wb_selections .= "<div style=\"".$divstyle_white."\"> All Contacts</div>"; #by_contacts_all
       $wb_selections .= "<div style=\"".$divstyle_white."\"> All Accounts</div>"; #by_accounts_all
       }  
  
    $wb_selections .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Show Well-being values based on;</B></font></center></div>";  

    if ($valtype == 'Contacts' && $val == $sess_contact_id){
       $wb_selections .= "<div style=\"".$divstyle_white."\">My well-being value (".$wellbeing_score.")</div>"; # by_contact (me)
       } else {
       $wb_selections .= "<div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"Scroller();loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Wellbeing&action=view&value=".$sess_contact_id."&valuetype=Contacts&sendiv=".$BodyDIV."');return false\">My well-being value</a></div>"; # by_contact (me)
       }

    $wb_selections .= "<div style=\"".$divstyle_white."\"> My Account (Family/Company)</div>"; # by_account (all contacts)  
    $wb_selections .= "<div style=\"".$divstyle_white."\"> People Connected to me (My Social Circle)</div>"; # by_contact_sn (me)
    $wb_selections .= "<div style=\"".$divstyle_white."\"> Social Networks I Have Joined (All)</div>"; # by_contact_sn (me)

    #
    ##############################
    # Prepare the well-being circles

    $lg_crcl_rad = "200px";
    $sm_crcl_rad = "100px";

    $one_left = ($sm_crcl_rad+10)."px";
    $one_top = (round($sm_crcl_rad/2,0))."px";
    $two_left = (round($sm_crcl_rad*.75,0))."px";
    $two_top = (round(($lg_crcl_rad*(1/3)),0))."px";
    $three_left = (round($sm_crcl_rad/2,0))."px";
    $three_top = ($sm_crcl_rad+10)."px";
    $four_right = (round($sm_crcl_rad*.75,0))."px";
    $four_top = (round(($lg_crcl_rad*(1/3)),0))."px";

    $link_wb = "<B><font size=3>Well-being [".$wellbeing_score."]</B></font>";

    $link_via = "<a href=\"#via\"><B><font size=3>VIA [".$via_avg_score."]</font></B></a>";

    $link_lead = "<a href=\"#leadership\"><B><font size=3>Leadership [".$leadership_avg_score."]</font></B></a>";

    $link_pesh = "<a href=\"#pesh\"><B><font size=3>PESH [".$pesh_avg_score."]</font></B></a>";

    $link_perma = "<a href=\"#perma\"><B><font size=3>PERMA [".$perma_avg_score."]</font></B></a>";

    # Not showing until ready
    $link_life = "<a href=\"#lifestyle\"><B><font size=3>Lifestyle [".$lifestyle_avg_score."]</font></B></a>";
    $link_life = "";

    $link_ai = "<a href=\"#ai\"><B><font size=3>AI [".$ai_avg_score."]</font></B></a>";

    $link_cloudsultancy = "<a href=\"#cloudsultancy\"><B><font size=3>Cloudsultancy [".$cloudsultancy_avg_score."]</font></B></a>";

    # Not showing until ready
    $link_cmv = "<a href=\"#cmv\"><B><font size=3>CMV [".$cmv_avg_score."]</font></B></a>";
    $link_cmv = "";

    $charimage = <<< CHARIMAGE
<style>

.circle {
    border-radius: 50%;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    width: $sm_crcl_rad;
    height: $sm_crcl_rad;
    position: relative;
    display: inline-flex;
    justify-content: center;
    align-items: center;
}

.circle.center {
    width: $lg_crcl_rad;
    height: $lg_crcl_rad;
    background-color: #ac5;
    margin-top:120px;
    margin-left: auto;
    margin-right: auto;
    text-align: center;
}

.one {
    left: -$one_left;
    top: $one_top;
    background-color: #fc5e5e;
    position: absolute;
    text-align: center;
}


.two {
    left: -$two_left;
    top: -$two_top;
    background-color: #277bab;
    position: absolute;
    text-align: center;
}

.three {
    left: $three_left;
    top: -$three_top;
    background-color: #ac60ec;
    position: absolute;
    text-align: center;
}

.four {
    right: -$four_right;
    top: -$four_top;
    background-color: #ffc000;
    position: absolute;
    text-align: center;
}

.five {
    right: -$one_left;
    top: $one_top;
    background-color: #fc5e5e;
    position: absolute;
    text-align: center;
}

.six {
    left: -$two_left;
    bottom: -$two_top;
    background-color: #06c999;
    position: absolute;
    text-align: center;
}

.seven {
    left: $three_left;
    bottom: -$three_top;
    background-color: #ffde00;
    position: absolute;
    text-align: center;
}

.eight {
    right: -$four_right;
    bottom: -$four_top;
    background-color: #ffde00;
    position: absolute;
    text-align: center;
}

</style>
<div id="big-circle" class="circle center">$link_wb
    <div class="circle one">$link_via</div>
    <div class="circle two">$link_lead</div>
    <div class="circle three">$link_pesh</div>
    <div class="circle four">$link_perma</div>
    <div class="circle five">$link_life</div>
    <div class="circle six">$link_ai</div>
    <div class="circle seven">$link_cloudsultancy</div>
    <div class="circle eight">$link_cmv</div>
</div>
CHARIMAGE;

    #$fullreport = "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Well-being Values</B></font></center></div>";

    $wellbeing = "<center>".$charimage."</center>";

    $embedd_link = "Body@".$lingo."@Wellbeing@view@".$val."@".$valtype;
    $embedd_link = $funky_gear->encrypt($embedd_link);
    $embedd_link = "https://".$hostname."/?pc=".$embedd_link;

    $embedd = "<script language=\"JavaScript\" src=\"https://".$hostname."/js/sharedeffects.js\"></script>
<a href=\"javascript:andBoom('".$embedd_link."');return false\"><img src=\"https://".$hostname."/uploads/1b6f98f1-2b3c-2f7c-b83e-54fd819dc491/a7b2868b-75db-0506-f324-54fd81ab496b/SharedEffects-100x100.png\" border=0></a>";

    #$embedder = "Copy the below code and simply paste in your homepage to provide this map for your visitors.<BR>Your UserID will used to earn you money for ads clicked!<P><textarea id=\"embedCode\" name=\"embedCode\" cols=\"60\" rows=\"1\" onclick=\"this.select();\">".$embedd."</textarea><P>The image below is an example of the code that opens a new, expanding window.";
    #$embedder .= "<P>".$embedd."<P>";

    # Position the final div on the left of the circles nicely
    $fullreport .= "<a name=\"top\"></a><div style=\"width:100%;height:100%;margin-left: auto;margin-right: auto;\"><div style=\"float:left;margin-left:1%;width:98%;margin-botton:3%;\">".$wellbeing."</div><BR><img src=images/blank.gif width=98% height=100px><BR><div style=\"float:left;margin-top:3%;margin-left:1%;width:98%;max-height:100%;overflow: auto;\">".$embedder.$wb_selections.$via_content.$pesh_content.$perma_content.$leadership_content.$ai_content.$cloudsultancy_content."</div></div>"; # final results   

    echo $fullreport;

    #
    ##############################

    if ($sendiv == 'lightform'){
       echo "<P><center>".$closer." - ".$refresh."</center><P>";
       }
 
   break; #view

 } # switch

# break; // End Wellbeing
##########################################################
?>