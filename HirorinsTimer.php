<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-24
# Page: HirorinsTimer.php 
##########################################################
# case 'HirorinsTimer':

  switch ($action){

   case 'view':

    # Use the parent CI as the wrapper for other items
    # Hirorin's Timer | ID: 915e05bc-2a28-490e-fb53-5562b607702d

    /*
    $ci_object_type = "ConfigurationItems";
    $ci_action = "select";

    if ($valtype == 'Contacts'){

       $timer_contact = $val;

       $ci_params[0] = "sclm_configurationitemtypes_id_c='915e05bc-2a28-490e-fb53-5562b607702d' && name=1 && contact_id_c='".$val."'";
       $ci_params[1] = "id"; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $par_ci = $ci_items[$cnt]['id'];

              } # for

          } # is array

       } elseif ($valtype == 'HirokosTimer'){
       $par_ci = $val;
       }
    */

    # 
    ##################
    # Hirorin's Timer | ID: 915e05bc-2a28-490e-fb53-5562b607702d
    # Get presentation info

    $cit_object_type = "ConfigurationItemTypes";
    $cit_action = "select";
    $cit_params[0] = "id='915e05bc-2a28-490e-fb53-5562b607702d'";
    $cit_params[1] = "name,description"; // select array
    $cit_params[2] = ""; // group;
    $cit_params[3] = ""; // order;
    $cit_params[4] = ""; // limit
  
    $cit_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cit_object_type, $cit_action, $cit_params);

    if (is_array($cit_items)){

       for ($cnt=0;$cnt < count($cit_items);$cnt++){

           $timer_name = $cit_items[$cnt]['name'];
           $timer_description = $cit_items[$cnt]['description'];

           } # for

       } # is array

    if ($sess_contact_id != NULL && $sess_contact_id == $val){
       $share_button = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"share\" id=\"share\" value=\"Share Timer\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','pc=".$portalcode."&do=Messages&action=add&value=".$val."&valuetype=".$do."&sendiv=lightform');document.getElementById('fade').style.display='block';return false\">";       }

    $anon_params[0] = $val; # Content owner
    $anon_params[1] = ""; # account_owner
    $anon_params[2] = $sess_contact_id; #contact_viewer
    $anon_params[3] = $sess_account_id; #account_viewer
    $anon_params[4] = $do;
    $anon_params[5] = $valtype;
    $anon_params[6] = $val;
    $show_namer = $funky_gear->anonymity($anon_params);

    $show_name = $show_namer[0];
    $show_description = $show_namer[1];
    $profile_photo = $show_namer[2];
    $contact_profile = $show_namer[3];

    $timer_name = $timer_name." for ".$show_name;

    $ht .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$timer_name."</B></font></center></div>";

    $timer_description = str_replace("\n", "<br>", $timer_description);
    $description = "<div style=\"float:left;height:300px;margin-left:1%;width:98%;overflow: auto;\">".$timer_description."</div>";
    $ht .= "<div style=\"".$divstyle_white."\">".$description."</div>";

    $ht .= "<div style=\"".$divstyle_white."\">".$contact_profile."</div>";
    #$ht .= $contact_profile;

    $ht .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Shared Contacts</B></font></center></div>";

    # Get any accessible contacts
    $sn_params[0] = $do;
    $sn_params[1] = "list";
    $sn_params[2] = $valtype;
    $sn_params[3] = $val;

    $extra_params[0] = "";
    $extra_params[1] = "";
    $sn_params[4] = $extra_params;
    
    $sn_returner = $funky_sn->sn_contacts ($sn_params);
    $rel_contacts = $sn_returner[0];
    $ht .= $rel_contacts;

    $ht .= "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>Other Hirorin Timers shared with me</B></font></center></div>";

    # Get any accessible contacts
    $sn_params[0] = $do;
    $sn_params[1] = "shared";
    $sn_params[2] = $valtype;
    $sn_params[3] = $val;

    $extra_params[0] = "";
    $extra_params[1] = "";
    $sn_params[4] = $extra_params;
    
    $sn_returner = $funky_sn->sn_contacts ($sn_params);
    $rel_contacts = $sn_returner[0];
    $ht .= $rel_contacts;    

    # Hirorin's Timer Settings | ID: 1e2e3b10-ef13-2442-be7d-5564299704f0
    # -> Average Days of Menstruation Cycle | ID: d9831c83-288e-119b-4b9c-5564292b1573
    # -> Last Menstruation Start Date | ID: 8e0c79c0-80e2-ac70-4a10-55642ac20771

    # Accessible Contacts | ID: 8b1ecebb-2c78-2e6c-f5d0-5562ba12a9a0

    # Uterine (Menstrual) Cycle | ID: ac9d7bde-859e-5eb0-65ff-5562be7544fc
    # -> Premenstrual Phase | ID: a69d8f03-d735-5c45-160c-5562c0b5f03a
    # -> Menstruation (Period) | ID: 67c18ee8-c28f-e913-7f64-5562c1646ec3
    # -> Proliferative Phase | ID: d8ce1b88-fd09-9ff9-e9e9-5562c2a19f2e
    # -> Secretory Phase | ID: 30a1df71-7165-5e97-8b15-5562c203204c

    # Ovarian (Menstrual) Cycle | ID: e498eca7-2027-f544-c62c-5562c3336ce8
    # -> Follicular Phase | ID: cac80d93-7ebe-8fcf-0f63-5562c4d1d3e0
    # -> Ovulation | ID: dafb329f-ecc5-150d-ec7a-5562c75d1587
    # -> Luteal Phase | ID: d06cd4a3-f920-1089-4871-5562c9bd617b

    # Daily Menstrual Events | ID: 63bc612b-d5e5-ec99-9b59-5564262ddfc7
    
    # Effects Value Type - Menstruation Cycle
    # -> Menstruation Begins | ID: 191da2c0-1db9-5f1c-f673-55642c5ffc8f
    # -> Menstruation Ends | ID: a796188b-9215-fb17-9949-55642dbb476b
    # Length of cycle is from start to start events
    $events_object_type = "Events";
    $events_action = "select";
    $events_params = array();
    $events_params[0] = "menstruation_phase_id='191da2c0-1db9-5f1c-f673-55642c5ffc8f' && contact_id_c='".$val."'";
    $events_params[1] = "id,name,start_date,end_date";
    $events_params[2] = "";
    $events_params[3] = "start_date ASC";
    $events_params[4] = "";
   
    $events = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $events_object_type, $events_action, $events_params);

    if (is_array($events)){

       $cycle_count = count($events);

       if ($cycle_count>1){

          $days = 0;

          for ($cnt=0;$cnt < count($events);$cnt++){
  
              $id = $events[$cnt]['id'];
              $menstru_name = $events[$cnt]['name'];
              $start_date = $events[$cnt]['start_date'];
              $end_date = $events[$cnt]['end_date'];

              $menstru .=  "<div style=\"".$divstyle_orange."\"><B>".$start_date." -> ".$end_date.": ".$menstru_name."</B></div>";

              # Need to add extra code to check whether previous month was actually previous month or skipped..
              if ($previous_end_date){
                 $strtime_previous_end_date = strtotime($previous_end_date);
                 $strtime_start_date = strtotime($start_date);
                 $datediff = $strtime_start_date - $strtime_previous_end_date;
                 $days = $days + floor($datediff/(60*60*24));
                 }

              $previous_start_date = $start_date;
              $previous_end_date = $end_date;

              } # for

          # Average
          $fertility_cycle = $days/count($events);
          #$fertility_cycle = 28;

          # Should end loop with latest start date
          $latest_date = $start_date;

          $ht .= "<div style=\"".$divstyle_white."\">You have created numerous menstrual events, with the latest one starting on ".$latest_date." - we have calculated the time between your menstruation periods to arrive at your <B>average menstruation cycle of ".$fertility_cycle." days</B>. Please continue to record menstrual events regularly to improve these calculations.</div>";

          } else {# if count>1

          $latest_date = $events[0]['start_date'];
          $fertility_cycle = 28;

          $ht .= "<div style=\"".$divstyle_white."\">You have created only one menstrual event on ".$latest_date.", but we can not calculate the time between periods to get your average period cycle. Please create a previous or next recent menstrual event with the date when it began. For now, we will use the <B>global average of ".$fertility_cycle." days</B> to calculate the menstrual schedule for the month since your recorded period. Please continue to record menstrual events regularly to improve these calculations.</div>";

          } # else 

       $ht .= $menstru;

       } else {# is array

       $latest_date = date("Y-m-d");
       $fertility_cycle = 28;

       $ht .=  "<div style=\"".$divstyle_white."\">You have not created any menstrual events yet. Create at least two menstrual events, using the date when your menstrual cycles began each time. For now, we will use the <B>global average of ".$fertility_cycle." days</B> to calculate the menstrual schedule, also using today, ".$latest_date." as an example date for the beginning of your menstruation schedule. Please continue to record menstrual events regularly to improve these calculations.</div>";

       } # end no events

    # Begin building event schedule
 
    $ovulation_days = $fertility_cycle-14; # 12
    $fertile_window_end_days = $ovulation_days+1; # 13
    $fertile_window_start_days = $fertile_window_end_days-6; # 7

    $ht .=  "<div style=\"".$divstyle_white."\">Ovulation Begins: ".$ovulation_days." days after period begins...</div>";
    $ht .=  "<div style=\"".$divstyle_white."\">Fertility Window Begins: ".$fertile_window_start_days." days after period begins...</div>";
    $ht .=  "<div style=\"".$divstyle_white."\">Fertility Window Ends: ".$fertile_window_end_days." days after period begins...</div>";

    # Build 7 days before latest period
    for ($daycnt=100;$daycnt < 108;$daycnt++){

        if ($daycnt==1){
           $schedule_date = date('Y-m-d', strtotime($latest_date.' -'.$daycnt.' day'));
           } else {
           $schedule_date = date('Y-m-d', strtotime($latest_date.' -'.$daycnt.' days'));
           }

        #echo "latest_date: ".$latest_date." schedule_date: ".$schedule_date." Day: ".$daycnt."<BR>";
 
        $newdaycnt = "-".$daycnt;
        #$newdaycnt = intval($newdaycnt);
        #$schedule[$daycnt]['day'] = $newdaycnt;
        #$schedule[$daycnt]['date'] = $schedule_date;

        #$minus_seven_days = date('Y-m-d', strtotime($date .' -7 days'));
        #$schedule[0]['date'] = $minus_seven_days; 

        } # for

    # Re-order the schedule based on the daycnt
    #$schedule = krsort($schedule);

    #foreach ($schedule as $key => $row) {
    #  $day[$key]  = $row['day'];
    #  $date[$key] = $row['date'];
    #}

    #array_multisort($day, SORT_DESC, $date, SORT_ASC, $schedule);

    # Build cycle from start date
    for ($daycnt=1;$daycnt < $fertility_cycle+1;$daycnt++){

        # schedule daycnt starts from 1
        $schedule_date = date('Y-m-d', strtotime($latest_date.' +'.$daycnt.' days'));
        $schedule[$daycnt]['day'] = $daycnt;
        $schedule[$daycnt]['date'] = $schedule_date;

        } # for

    # Build 7 days after cycle ends

    for ($daycnt=1;$daycnt < 7;$daycnt++){

        # get schedule date from previous loop
        $extradays = $fertility_cycle+$daycnt;
        if ($daycnt==1){
           $schedule_date = date('Y-m-d', strtotime($schedule_date.' +'.$daycnt.' day'));
           } else {
           $schedule_date = date('Y-m-d', strtotime($schedule_date.' +'.$daycnt.' days'));
           } 
        # schedule daycnt plus previous
        $schedule[$extradays]['day'] = $extradays;
        $schedule[$extradays]['date'] = $schedule_date;

        } # for


    /*
    $ci_params = "";
    $ci_params[0] = "sclm_configurationitems_id_c='".$par_ci."' && sclm_configurationitemtypes_id_c='8b1ecebb-2c78-2e6c-f5d0-5562ba12a9a0' "; 
    $ci_params[1] = ""; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $shared_contact_ci = $ci_items[$cnt]['id'];
           $shared_contact_id = $ci_items[$cnt]['name'];

           } # for

        $ht .=  "<div style=\"".$divstyle_white."\">Your Timer has been shared with the following connections. ".$share_button."</div>";

       } else {# is array

        $ht .=  "<div style=\"".$divstyle_white."\">Your Timer has not been shared with any connections yet. ".$share_button."</div>";

       } 
    */
    # Check events for value types of menstruation - begin/end
    # Cycle #1 number of days from beginning to end
    # Average number of days of all cycles
    # Show at least 7 days before the cycle starts again and 7 days after..

    for ($daycnt=1;$daycnt < count($schedule);$daycnt++){

        $day_num = $schedule[$daycnt]['day'];
        $schedule_date = $schedule[$daycnt]['date'];
        $day_word = date('l', strtotime($schedule_date));

        if ($day_num == 1){

           # Check from DB when ready - also collect any events near this date owned or shared with this user

           $schedule_lines .= "<div style=\"".$divstyle_orange."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Menstruation begins - there will be a bit of bleeding for the next 2-6 days..</div>";

           } elseif ($day_num == 2 || $day_num == 3 || $day_num == 4 || $day_num == 5){

           $schedule_lines .= "<div style=\"".$divstyle_orange."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Menstruation ...</div>";

           } elseif ($day_num == 6){

           $schedule_lines .= "<div style=\"".$divstyle_orange_light."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Menstrual bleeding stops... Hormones start stimulting ovarian follicles to form and grow in one of the two ovaries. Estrogen begins being secreted..</div>";

           } elseif ($day_num > 6 &&  $day_num < $fertile_window_start_days){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - </div>";

           } elseif ($day_num == $fertile_window_start_days){

           $schedule_lines .= "<div style=\"".$divstyle_grey."\"><B>Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Fertile Window Begins..</B></div>";

           } elseif ($day_num > $fertile_window_start_days && $day_num < $fertile_window_end_days){

           # A lot going on here
           if ($day_num == $fertile_window_start_days+1){

              $schedule_lines .= "<div style=\"".$divstyle_grey."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - sperm can survive for up to 5 days...</div>";

              } elseif ($day_num == $fertile_window_start_days+2 && $day_num != $ovulation_days){

              $schedule_lines .= "<div style=\"".$divstyle_grey."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - More hormones are being secreted...</div>";

              } elseif ($day_num == $fertile_window_start_days+3 && $day_num != $ovulation_days){

              $schedule_lines .= "<div style=\"".$divstyle_grey."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - Hormones ramping up...</div>";

              } elseif ($day_num == $fertile_window_start_days+4 && $day_num != $ovulation_days){

              $schedule_lines .= "<div style=\"".$divstyle_grey."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - Hormone drive ovaries to secrete higher levels of estrogen - aiming to mature the ovum...</div>";

              } elseif ($day_num == $fertile_window_start_days+5 && $day_num != $ovulation_days){

              $schedule_lines .= "<div style=\"".$divstyle_blue."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - Hormones are peaking - ovulation takes place...</div>";

              } elseif ($day_num == $fertile_window_start_days+6 && $day_num != $ovulation_days){

              $schedule_lines .= "<div style=\"".$divstyle_blue."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - ...</div>";

              } elseif ($day_num == $ovulation_days){

              # Add schedule notification option to notify IF any related contacts
              $schedule_lines .= "<div style=\"".$divstyle_blue."\"><B>Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - The mature egg has ovulated and released into the fallopian tube to travel towards the uterus. If no sperm can reach the egg and break through and fertilise it, the egg will dissolve after about one day after ovulation...</B></div>";

              } elseif ($day_num == $ovulation_days+1){

              $schedule_lines .= "<div style=\"".$divstyle_blue."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - The egg may have been fertilised...</div>";

              } elseif ($day_num == $ovulation_days+2){

              $schedule_lines .= "<div style=\"".$divstyle_grey."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - The fertility period lasts about 3 days and then the progesterone signals the cervix to produce mucus that builds a plug to block the cervix entrance. If fertilised, this plug will stay in place and menstruation will stop.../div>";

              } else {

              $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Sexual activity can cause pregnancy - ...</div>";

              }

           # end pre-ovulation

           } elseif ($day_num == $fertile_window_end_days){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Fertile Window Ends. Lower chance that sexual activity can cause pregnancy...</div>";

           } elseif ($day_num == $fertile_window_end_days+1){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If not fertilised, the egg will now dissolve...</div>";

           } elseif ($day_num == $fertile_window_end_days+1){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If not fertilised, progesterone will last only a few more days. Minimal chance that sexual activity can cause pregnancy...</div>";

           } elseif ($day_num == $fertile_window_end_days+1){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Fertilization by a spermatozoon, when it occurs, usually takes place in the ampulla, the widest section of the fallopian tubes. A fertilized egg immediately begins the process of embryogenesis, or development...</div>";

           } elseif ($day_num == $fertile_window_end_days+1){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If fertilised, the ovum continues to move along towards the uterus, pushed along by small follicles...</div>";

           } elseif ($day_num == $fertile_window_end_days+2){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If fertilised, the developing embryo will have taken these three days to reach the uterus...</div>";

           } elseif ($day_num == $fertile_window_end_days+2){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If not fertilised, progesterone and estrogen levels will be reducing...</div>";

           } elseif ($day_num == $fertile_window_end_days+3){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If not fertilised, the secretion of progesterone should stop by now...</div>";

           } elseif ($day_num == $fertile_window_end_days+4){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Reduced changes to the uterus walls...</div>";

           } elseif ($day_num == $fertile_window_end_days+5){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If fertilised, the developing embryo will have implanted into the endometrium...</div>";

           } elseif ($day_num > $fertile_window_end_days+5 && $day_num < $fertility_cycle-2){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - You may experience discomfort or other symptoms of PMS...</div>";

           } elseif ($day_num == $fertility_cycle-2){

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - The falling levels of progesterone and estrogen trigger the  shedding of the uterine lining...</div>";

           } elseif ($day_num == $fertility_cycle-1){

           $schedule_lines .= "<div style=\"".$divstyle_orange_light."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Shedding of the uterine lining begins...</div>";

           } elseif ($day_num == $fertility_cycle){

           $schedule_lines .= "<div style=\"".$divstyle_orange."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Menstruation should begin - there will be a bit of bleeding for the next 2-6 days..</div>";

           $next_menstrual_date = $schedule_date;
           $next_menstrual_day_word = $day_word;

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - If your menstruation cycle is usually quite stable and your menstruation does not begin within the next week, please consider checking for pregnancy...</div>";

           } elseif ($day_num == $fertility_cycle+1 || $day_num == $fertility_cycle+2 || $day_num == $fertility_cycle+3 || $day_num == $fertility_cycle+4 || $day_num ==  $fertility_cycle+5){

           $schedule_lines .= "<div style=\"".$divstyle_orange."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Menstruation ...</div>";

           } elseif ($day_num == $fertility_cycle+6){

           $schedule_lines .= "<div style=\"".$divstyle_orange_light."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - Menstrual bleeding stops... Hormones start stimulting ovarian follicles to form and grow in one of the two ovaries. Estrogen begins being secreted..</div>";

           } else {# end if outer

           $schedule_lines .= "<div style=\"".$divstyle_white."\">Day ".$day_num." - [".$schedule_date."] [".$day_word."] - XXX </div>";

           } 

        } # end for schedule

    $future_menstrual_date = date('Y-m-d', strtotime($next_menstrual_date.' +'.$fertility_cycle.' days'));
    $future_ovulation_date = date('Y-m-d', strtotime($future_menstrual_date.' -14 days'));
    $fertile_window_end_date = date('Y-m-d', strtotime($future_ovulation_date.' +1 days'));
    $fertile_window_start_date = date('Y-m-d', strtotime($fertile_window_end_date.' -6 days'));

    $ht .= "<div style=\"".$divstyle_white."\">Based on your menstruation events, your average cycle length is ".$fertility_cycle." days.</div>";
    $ht .= "<div style=\"".$divstyle_white."\">It is estimated that your next menstrual cycle will begin on ".$next_menstrual_date." [".$next_menstrual_day_word."]</div>";
    $ht .= "<div style=\"".$divstyle_blue."\">It is estimated that your next fertility window begins on <B>".$fertile_window_start_date." until ".$fertile_window_end_date."</B></div>";


/*
    $ht .= "<div style=\"".$divstyle_white."\">Day 01 - May 06 (Wed) - Menstruation begins - there is a bit of bleeding for 2-6 days..</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 02 - May 07 (Thu) - Menstruation...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 03 - May 08 (Fri) - Menstruation...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 04 - May 09 (Sat) - Menstruation...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 05 - May 10 (Sun) - Menstruation...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 06 - May 11 (Mon) - Menstrual bleeding stops... Hormones start stimulting ovarian follicles to form and grow in one of the two ovaries. Estrogen begins being secreted.</div>";

    $ht .= "<div style=\"".$divstyle_white."\"><B>Day 07 - May 12 (Tue) - Fertile Window Begins..</B></div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 08 - May 13 (Wed) - Sexual activity can cause pregnancy - sperm can survive for up to 5 days...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 09 - May 14 (Thu) - Sexual activity can cause pregnancy - More hormones are being secreted..</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 10 - May 15 (Fri) - Sexual activity can cause pregnancy - Hormones ramping up..</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 11 - May 16 (Sat) - Sexual activity can cause pregnancy - Hormone drive ovaries to secrete higher levels of estrogen - aiming to mature the ovum.</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 12 - May 17 (Sun) - Sexual activity can cause pregnancy - Hormones are peaking - ovulation takes place..</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 12 - May 17 (Sun) - Sexual activity can cause pregnancy - The mature egg is released into the fallopian tube to travel towards the uterus. If no sperm can reach the egg and break through and fertilise it, the egg will dissolve after about one day after ovulation..</div>";

    $ht .= "<div style=\"".$divstyle_white."\"><B>Day 12 - May 17 (Sun) - Sexual activity can cause pregnancy - Egg IS or is NOT fertilised..</B></div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 13 - May 18 (Mon) - Sexual activity can cause pregnancy - The fertility period lasts about 3 days and then the progesterone signals the cervix to produce mucus that builds a plug to block the cervix entrance. If fertilised, this plug will stay in place and menstruation will stop...</div>";

    $ht .= "<div style=\"".$divstyle_white."\"><B>Day 13 - May 18 (Mon) - Fertile Window Ends. Lower chance that sexual activity can cause pregnancy...</B></div>";

    $ht .= "<div style=\"".$divstyle_white."\"><B>Day 14 - May 19 (Tue) - If not fertilised, the egg will now dissolve...</B></div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 14 - May 19 (Tue) - If not fertilised, progesterone will last only a few more days. Minimal chance that sexual activity can cause pregnancy...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 14 - May 19 (Tue) - Fertilization by a spermatozoon, when it occurs, usually takes place in the ampulla, the widest section of the fallopian tubes. A fertilized egg immediately begins the process of embryogenesis, or development...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 14 - May 19 (Tue) - If fertilised, the ovum continues to move along towards the uterus, pushed along by small follicles...</div>"; 

    $ht .= "<div style=\"".$divstyle_white."\">Day 15 - May 20 (Wed) - If not fertilised, progesterone and estrogen levels will be reducing...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 15 - May 20 (Wed) - If fertilised, the developing embryo will have taken these three days to reach the uterus...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 16 - May 21 (Thu) - If not fertilised, the secretion of progesterone should stop by now...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 17 - May 22 (Fri) - Reduced changes to the uterus walls...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 18 - May 23 (Sat) - If fertilised, the developing embryo will have implanted into the endometrium...</div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 19 - May 24 (Sun) - </div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 20 - May 25 (Mon) - </div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 21 - May 26 (Tue) - </div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 22 - May 27 (Wed) - </div>";

    $ht .= "<div style=\"".$divstyle_white."\">Day 23 - May 28 (Thu) - The falling levels of progesterone and estrogen trigger the  shedding of the uterine lining..</div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 24 - May 29 (Fri) - </div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 25 - May 30 (Sat) - Shedding of the uterine lining..</div>";
    $ht .= "<div style=\"".$divstyle_white."\">Day 26 - May 31 (Sun) - Menstruation begins - there is a bit of bleeding for 2-6 days..</div>";
    $ht .= "<div style=\"".$divstyle_white."\"><B>Day 26 - May 31 (Sun) - If menstruation does not begin within the next week, consider checking if pregnant..</B></div>";
*/

    $ht .= $pms;
    $ht .= $schedule_lines;

    if ($sess_contact_id != $val){
       $ht = str_replace("you", $show_name, $ht);
       $ht = str_replace("You", $show_name, $ht);
       $ht = str_replace($show_name."r", $show_name."'s", $ht);
       }

    $ht .= "<div style=\"".$divstyle_white."\"></div>";

    echo $ht;

    ################################
    # Make Embedded Object Link

    $embedd_params = array();
    $embedd_params[0] = $timer_name;
    $embedd_params[1] = $val;

    echo "<img src=images/blank.gif width=98% height=5><BR>";
    echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$embedd_params);

    #
    ################################

   break; # end view

  } # switch action

# break; // End HirorinsTimer
##########################################################
?>