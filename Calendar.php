<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-10-01
# Page: Calander.php 
############################################## 
# Calander

  $sendiv = $_POST['sendiv'];
  if (!$sendiv){
     $sendiv = $_GET['sendiv'];
     if (!$sendiv){
        $sendiv = $BodyDIV;
        }
     }

  if (!$action){
     $action = 'list';
     }

  function get_days_in_month($monthyear){

   return date("t",strtotime($monthyear));

  }

  $search_date = $_POST['date'];

  if ($search_date){
     $search_year = date('Y', strtotime($search_date));
     $search_month = date('m', strtotime($search_date));
     $search_day = date('d', strtotime($search_date));
     $this_month_max_days = get_days_in_month($search_date);
     } else {
     $this_month_max_days = date('t');
     } 


  $day_view = $_POST['day_view'];
  if (!$day_view){
     $day_view = $_GET['day_view'];
     if (!$day_view){
        $day_view = 7;
        }
     }

  if ($day_view == 1){
     $block_width = "450px";
     $block_height = "450px";
     $row_height = "452px";
     } elseif ($day_view == 5){
     $block_width = "90px";
     $block_height = "90px";
     $row_height = "92px";
     } elseif ($day_view == 7){
     $block_width = "64px";
     $block_height = "90px";
     $row_height = "92px";
     }

  $max_columns = $day_view;

  # Set up the column headers
  $divstyle_params[0] = $block_width; // minwidth
  #$divstyle_params[1] = $block_height; // minheight
  $divstyle_params[1] = "90px"; // minheight
  $divstyle_params[2] = "0px"; // margin_left
  $divstyle_params[3] = "0px"; // margin_right
  $divstyle_params[4] = "2px"; // padding_left
  $divstyle_params[5] = "2px"; // padding_right
  $divstyle_params[6] = "0px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "2px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom
  #$divstyle_params[10] = "#FFFFFF"; // custom_color_back
  $divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
  #$divstyle_params[10] = "#e6ebf8 50% 50% repeat-x"; // custom_color_back
  $divstyle_params[11] = "#d3d3d3"; // custom_color_border
  $divstyle_params[12] = "left"; // custom_float
  $divstyle_params[13] = $block_width; // maxwidth
  $divstyle_params[14] = $block_height; // maxheight
  #$divstyle_params[14] = ""; // maxheight
  $divstyle_params[15] = "3"; // top_radius
  $divstyle_params[16] = "3"; // bottom_radius
  #$divstyle_params[17] = "auto"; // overflow

  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $block_style = $divstyle[5];

  $divstyle_params[10] = "#e6ebf8 50% 50% repeat-x"; // custom_color_back
  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $today_block_style = $divstyle[5];

  $divstyle_params[0] = "450"; // minwidth
  #$divstyle_params[1] = $block_height; // minheight
  $divstyle_params[1] = "90px"; // minheight
  $divstyle_params[2] = "0px"; // margin_left
  $divstyle_params[3] = "0px"; // margin_right
  $divstyle_params[4] = "2px"; // padding_left
  $divstyle_params[5] = "2px"; // padding_right
  $divstyle_params[6] = "0px"; // margin_top
  $divstyle_params[7] = "0px"; // margin_bottom
  $divstyle_params[8] = "2px"; // padding_top
  $divstyle_params[9] = "2px"; // padding_bottom
  $divstyle_params[10] = "#FFFFFF"; // custom_color_back
  #$divstyle_params[10] = "#e6e6e6 50% 50% repeat-x"; // custom_color_back
  #$divstyle_params[10] = "#e6ebf8 50% 50% repeat-x"; // custom_color_back
  $divstyle_params[11] = "#d3d3d3"; // custom_color_border
  $divstyle_params[12] = "left"; // custom_float
  $divstyle_params[13] = "450"; // maxwidth
  $divstyle_params[14] = $row_height; // maxheight
  #$divstyle_params[14] = ""; // maxheight
  $divstyle_params[15] = "3"; // top_radius
  $divstyle_params[16] = "3"; // bottom_radius
  $divstyle_params[17] = "no"; // overflow

  $divstyle = $funky_gear->makedivstyles ($divstyle_params);
  $row_style = $divstyle[5];

  $row_cols = 1;

  $divisor = $this_month_max_days/$day_view;
  $divisor = round($divisor,0);
  $lastrow = $this_month_max_days-($divisor*$day_view);
  $timestamp = time();

  if (!$search_date){
     $today = date("Y-m-d");
     $this_year = date("Y");
     $this_month = date("m");
     $this_day = date("d");
     } else {
     $today = $search_date;
     $this_year = date('Y', strtotime($search_date));
     $this_month = date('m', strtotime($search_date));
     $this_day = date('d', strtotime($search_date));
     }

  /*
  if ($this_month <= 11 && $this_month > 2){
     $previous_month = $this_month-1;
     $previous_month_year = $this_year;
     $this_month_year = $this_year;
     $next_month = $this_month+1;
     $next_month_year = $this_year;
     } elseif ($this_month == 1){
     $previous_month = 12;
     $previous_month_year = $this_year-1;
     $next_month = 2;
     $next_month_year = $this_year;
     } elseif ($this_month == 12){
     $next_month = 1;
     $previous_month = 11;
     $previous_month_year = $this_year-1;
     $this_month_year = $this_year;
     $next_month_year = $this_year+1;
     }
  */

  #$go_previous_month_year = strtotime(date("Y-m-d", strtotime($this_month_year)) . "-1 months");
  #$go_next_month_year = strtotime(date("Y-m-d", strtotime($this_month_year)) . "+1 months");
  $go_previous_month_year = strtotime(date("Y-m-d", strtotime($today)) . "-1 months");
  $go_previous_month_year = date("Y-m-d", $go_previous_month_year);
  $go_next_month_year = strtotime(date("Y-m-d", strtotime($today)) . "+1 months");
  $go_next_month_year = date("Y-m-d", $go_next_month_year);

  #$go_previous_month_year = $previous_month_year."-".$previous_month;
  #$go_next_month_year = $next_month_year."-".$next_month;

  $this_month_days = get_days_in_month($this_month_year);
  $previous_month_days = get_days_in_month($go_previous_month_year);
  $next_month_days = get_days_in_month($go_next_month_year);

  #echo "$next_month, $next_month_year <BR>";
  #echo "thismonth_days $this_month_days last_month_days $last_month_days next_month_days $next_month_days<BR>";

  #echo "this_month_max_days: ".$this_month_max_days." | max columns: ".$max_columns." | divisor: ".$divisor."| lastrow: ".$lastrow."<BR>";

  $go_previous_month = "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$go_previous_month_year."&day_view=".$day_view."');return false\"><font size=2>Previous Month [".$go_previous_month_year."]<font></a>";
  $go_next_month = "<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$go_next_month_year."&day_view=".$day_view."');return false\"><font size=2>Next Month [".$go_next_month_year."]<font></a>";

  function get_items ($check_date){

    global $do,$portalcode,$strings,$sess_account_id,$sess_contact_id,$auth;

    $cal_object_type = "Meetings";
    $cal_action = "select";
    $cal_params[0] = " date_start like '%".$check_date."%' ";
    /*
    if ($auth == 3){
       $cal_params[0] = " date_start like '%".$check_date."%' ";
       } elseif ($auth == 2) {
       $cal_params[0] = " date_start like '%".$check_date."%' && account_id_c='".$sess_account_id."'";
       } else {
       $cal_params[0] = " date_start like '%".$check_date."%' && contact_id_c='".$sess_contact_id."'";
       }
    */
    $cal_params[1] = "id,name,date_start"; // select array
    $cal_params[2] = ""; // group;
    $cal_params[3] = ""; // order;
    $cal_params[4] = ""; // limit
    $cal_params[5] = $lingoname; // lingo

    $cal_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cal_object_type, $cal_action, $cal_params);

    if (is_array($cal_items)){
 
       for ($cnt=0;$cnt < count($cal_items);$cnt++){
   
           $id = $cal_items[$cnt]['id'];
           $name = $cal_items[$cnt]['name'];
           $date_entered = $cal_items[$cnt]['date_entered'];
           $date_modified = $cal_items[$cnt]['date_modified'];
           $modified_user_id = $cal_items[$cnt]['modified_user_id'];
           $created_by = $cal_items[$cnt]['created_by'];
           /*
           $description = $cal_items[$cnt]['description'];
           $deleted = $cal_items[$cnt]['deleted'];
           $location = $cal_items[$cnt]['location'];
           $password = $cal_items[$cnt]['password'];
           $join_url = $cal_items[$cnt]['join_url'];
           $host_url = $cal_items[$cnt]['host_url'];
           $displayed_url = $cal_items[$cnt]['displayed_url'];
           $creator = $cal_items[$cnt]['creator'];
           $external_id = $cal_items[$cnt]['external_id'];
           $duration_hours = $cal_items[$cnt]['duration_hours'];
           $duration_minutes = $cal_items[$cnt]['duration_minutes'];
           */
           $date_start = $cal_items[$cnt]['date_start'];
           $date_end = $cal_items[$cnt]['date_end'];
           /*
           $parent_type = $cal_items[$cnt]['parent_type'];
           $status = $cal_items[$cnt]['status'];
           $type = $cal_items[$cnt]['type'];
           $parent_id = $cal_items[$cnt]['parent_id'];
           $reminder_time = $cal_items[$cnt]['reminder_time'];
           $email_reminder_time = $cal_items[$cnt]['email_reminder_time'];
           $email_reminder_sent = $cal_items[$cnt]['email_reminder_sent'];
           $outlook_id = $cal_items[$cnt]['outlook_id'];
           $sequence = $cal_items[$cnt]['sequence'];
           $repeat_type = $cal_items[$cnt]['repeat_type'];
           $repeat_interval = $cal_items[$cnt]['repeat_interval'];
           $repeat_dow = $cal_items[$cnt]['repeat_dow'];
           $repeat_until = $cal_items[$cnt]['repeat_until'];
           $repeat_count = $cal_items[$cnt]['repeat_count'];
           $repeat_parent_id = $cal_items[$cnt]['repeat_parent_id'];
           $recurring_source = $cal_items[$cnt]['recurring_source'];
           */

           $edit = "";

           if ($sess_contact_id != NULL){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=edit&value=".$id."&valuetype=".$do."&sendiv=lightform&day_view=".$day_view."');return false\"><font size=1 color=RED>".$strings["action_edit"]."</font></a>";
             }

           $cal_name .= "<font size=1 color=RED>[M]</font> ".$edit." <a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=view&value=".$id."&valuetype=".$do."&sendiv=lightform&day_view=".$day_view."');return false\"><font size=1 color=BLUE>".$name."</font></a><BR>";

           }  # end for

       }  # is array

    $cal_object_type = "Events";
    $cal_action = "select";

    if ($auth == 3){
       $cal_params[0] = " start_date like '%".$check_date."%' ";
       } elseif ($auth == 2) {
       $cal_params[0] = " start_date like '%".$check_date."%' && account_id_c='".$sess_account_id."'";
       } else {
       $cal_params[0] = " start_date like '%".$check_date."%' && contact_id_c='".$sess_contact_id."'";
       }

    $cal_params[1] = "id,name,start_date"; // select array
    $cal_params[2] = ""; // group;
    $cal_params[3] = ""; // order;
    $cal_params[4] = ""; // limit
    $cal_params[5] = $lingoname; // lingo

    $cal_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cal_object_type, $cal_action, $cal_params);

    if (is_array($cal_items)){
 
       for ($cnt=0;$cnt < count($cal_items);$cnt++){
   
           $id = $cal_items[$cnt]['id'];
           $name = $cal_items[$cnt]['name'];
           $start_date = $sideeffects[$cnt]['start_date'];
           $end_date = $sideeffects[$cnt]['end_date'];

           $edit = "";

           if ($sess_contact_id != NULL){
              $edit = "<a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=edit&value=".$id."&valuetype=".$do."&sendiv=lightform&day_view=".$day_view."');return false\"><font size=1 color=RED>".$strings["action_edit"]."</font></a>";
             }

           $cal_name .= "<font size=1 color=RED>[M]</font> ".$edit." <a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=view&value=".$id."&valuetype=".$do."&sendiv=lightform&day_view=".$day_view."');return false\"><font size=1 color=BLUE>".$name."</font></a><BR>";

           }  # end for

       }  # is array

  return $cal_name;

  } # end function

?>
<style>
.menu{
display:block;
width:<?php echo $block_width; ?>px;
height:80px;
#background-image:url(../images/menu.svg);
background-size:cover;
background-position:center;
overflow:auto;
}
 .menu:hover{
display:block;
width:<?php echo $block_width; ?>px;
height:80px;
#background-image:url(../images/menu2.svg);
background-size:cover;
background-position:center;
  }

.drop{
position:absolute;
background:#000;
margin:0;
padding:10px;
font-family: 'Exo 2', sans-serif;
color:#FFF;
visibility:hidden;
}

.menu:hover+.drop,.drop:hover{
/*_________^_________^___________*/
position:absolute;
background:#000;
margin:0;
padding:10px;
font-family: 'Exo 2', sans-serif;
color:#FFF;
visibility:visible;
 }
</style>

<?PHP

  switch ($action){

   case 'list':

    for ($daycnt=1; $daycnt <= ($this_month_max_days); $daycnt++){

        #echo "row_cols: ".$row_cols." | day: ".$daycnt."<BR>";

       $check_year = date('Y', strtotime($today));
       $check_month = date('m', strtotime($today));

       #echo "$daycnt == ".date("d")." && $check_year == ".date("Y")." && $check_month == ".date("m")."<BR>";

       if ($daycnt < 10){
          $show_daycnt = "0".$daycnt;
          } else {
          $show_daycnt = $daycnt;
          }

       $check_date = $this_year."-".$this_month."-".$show_daycnt;
       $meetings = get_items ($check_date);
       $daytext = date('D', strtotime($check_date));

       #echo $meetings;

       if ($meetings){
          $meetings = "<BR>".$meetings;
          }

       if ($daycnt == date("d") && $check_year == date("Y") && $check_month == date("m")){

          $dayblock_style = $today_block_style;

          #$day_link = "<a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$check_date."&valuetype=".$do."');return false\"><font size=2 color=RED>".$show_daycnt."</font></a><BR>".$meetings;

          $day_link = "<div id=\"".$check_date."\">
<span class=\"menu\"><font size=2 color=RED>".$show_daycnt." - ".$daytext."</font>".$meetings."</span>
    <nav class=\"drop\">
        <li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=add&value=".$check_date."&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["Meeting_add"]."</font></a></li>
        <li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Events&action=add&date=".$check_date."&value=&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["Event_add"]."</font></a></li>
        <li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&date=".$check_date."&value=&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["Effect_add"]."</font></a></li>
        <li>Add Project Task</li>
        <li>Add Call</li>
    </nav>
</div>";

          } else {

          $dayblock_style = $block_style;
          #$day_link = "<a href=\"#\" onClick=\"loader('light');document.getElementById('light').style.display='block';doBPOSTRequest('light','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$check_date."&valuetype=".$do."');return false\"><font size=2 color=BLUE>".$show_daycnt."</font></a><BR>".$meetings;

          $day_link = "<div id=\"".$check_date."\">
<span class=\"menu\"><font size=2 color=BLUE>".$show_daycnt." - ".$daytext."</font>".$meetings."</span>
    <nav class=\"drop\">
        <li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Meetings&action=add&value=".$check_date."&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["Meeting_add"]."</font></a></li>
        <li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Events&action=add&date=".$check_date."&value=&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["Event_add"]."</font></a></li>
        <li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=Effects&action=add&date=".$check_date."&value=&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$strings["Effect_add"]."</font></a></li>
        <li>Add Project Task</li>
        <li>Add Call</li>
    </nav>
</div>";

          } 

        $calblocks .= "<div style=\"".$dayblock_style."\">".$day_link."</div>";
      
        if ($row_cols == $max_columns){
           $row_cols = 0;
           $calrows .= "<div style=\"".$row_style."\">".$calblocks."</div>";
           $calblocks = "";
           } elseif ($daycnt == $this_month_max_days){
           #$row_cols = 0;
           $calrows .= "<div style=\"".$row_style."\">".$calblocks."</div>";
           $calblocks = "";
           } 

        $row_cols++;

        } # for

    /*
    # Provide 24 months prior
    for ($mnthcnt=1; $mnthcnt <= (24); $mnthcnt++){

        $past_date = strtotime(date("Y-m-d", strtotime($today)) . "-$mnthcnt months");
        $past_date = date("Y-m-d", $past_date);
        $months_links .= "<li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=&date=".$past_date."&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$past_date."</font></a></li>";
        #$dd_pack[$past_date] = $past_date;
        #$dd_pack .= $past_date." => ".$past_date.",";
        #$dd_pack[$past_date] = $past_date;

        } # 

    #$dd_pack[$today] = $today;
    #$dd_pack .= $today." => ".$today.",";
    #$dd_pack[$today] = $today;
    $months_links .= "<li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=&date=".$today."&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$today."</font></a></li>";
    #echo "today: ".$today."<BR>";

    # Provide 24 months future
    for ($mnthcnt=1; $mnthcnt <= (24); $mnthcnt++){

        $new_date = strtotime(date("Y-m-d", strtotime($today)) . "+$mnthcnt months");
        $new_date = date("Y-m-d", $new_date);
        #$dd_pack[$new_date] = $new_date;
        #$dd_pack[$new_date] = $new_date;
        $months_links .= "<li><a href=\"#\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php', 'pc=".$portalcode."&do=".$do."&action=list&value=&date=".$new_date."&valuetype=".$do."&sendiv=lightform');return false\"><font size=2 color=RED>".$new_date."</font></a></li>";

        } # 

    #$dd_pack = array($dd_pack);

    rsort ($months_links);

    #var_dump($dd_pack);

    #while (list($key, $value) = each($dd_pack)){

          #echo "Key: ".$key." value: ".$value."<P>";

    #      }


    $months_link = "<div id=\"MonthsLink\">
<span class=\"menu\"><font size=2 color=RED>Show 24 Months</font></span>
    <nav class=\"drop\">
      ".$months_links."
    </nav>
</div>";

    */

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "sendiv"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sendiv; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "date"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Month"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = '12'; //length
    $tablefields[$tblcnt][20] = "date"; //$field_value_id;
    $tablefields[$tblcnt][21] = $today; //$field_value;   

    /*
    $tablefields[$tblcnt][0] = 'date'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Month"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jumper';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table    
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $today; // Current Value
    $tablefields[$tblcnt][9][6] = "";
    $tablefields[$tblcnt][9][7] = "";
    $tablefields[$tblcnt][9][8] = "";
    $tablefields[$tblcnt][9][9] = $today;
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = 'date';//$field_value_id;
    $tablefields[$tblcnt][21] = $today; //$field_value;
    */

    $valpack = "";
    #$do = 'ConfigurationItems';
    $valpack[0] = $do;
    $valpack[1] = 'custom'; //
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ''; //
    $valpack[6] = 'list'; //
    $valpack[7] = 'Select'; //
    $valpack[10] = "lightform"; # div for edit links

    $monthsform = $funky_gear->form_presentation($valpack);

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    #$container_params[3] = $go_last_month." <- Calendar"; // container_title
    $container_params[3] = $today; // container_title
    $container_params[4] = 'Calendar'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    echo "<P>";
    echo "<center>".$go_previous_month." | ".$go_next_month."</center><BR>";
    echo "<center><a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$today."&day_view=1');return false\"><font size=2>1 Column<font></a> | <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$today."&day_view=5');return false\"><font size=2>5 Columns<font></a> | <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=".$do."&action=".$action."&value=".$val."&valuetype=".$valtype."&date=".$today."&day_view=7');return false\"><font size=2>7 Columns<font></a></center>";
    echo "<center>".$monthsform."</center>";
    #echo "<center>".$months_link."</center>";

    echo $calrows;

    echo "<P><div style=\"".$divstyle_white."\">";
    echo "<B>Legend</B><BR>";
    echo "[M] = Meeting<BR>";
    echo "[T] = Project Task<BR>";
    echo "[C] = Call<BR>";
    echo "</div>";

    echo $container_bottom;

   break;

 } # switch

?>