<?PHP

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

date_default_timezone_set('Asia/Tokyo');

if (!function_exists('get_param')){
   include ("common.php");
   }

$screenwidth = "65em";

?>
<!doctype html>
<html lang="en">
<head>
  <title><?php echo $portal_title;?></title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="google-site-verification" content="F8yDhS86LIY3eSdMBPztrEs5kfdzyxCgZufnf9Rlqpw" />
  <meta name="robots" content="ALL,index,follow">
  <meta name="keywords" content="<?php echo $strings["HTML_Keywords"];?>">
  <meta name="description" content="<?php echo $strings["HTML_Description"];?>">
  <meta name="resource-type" content="document">
  <meta name="revisit-after" content="3 Days">
  <meta name="classificaton" content="Service Provider">
  <meta name="distribution" content="Global">
  <meta name="rating" content="Safe For Kids">
  <meta name="author" content="Scalastica">
  <meta http-equiv="reply-to" content="<?php echo $portal_email; ?>">
  <meta http-equiv="imagetoolbar" content="no">
  <link rel="stylesheet" type="text/css" href="<?php echo $portal_style; ?>">
  <link href="css/<?php echo $portal_skin;?>/general.css" rel="stylesheet">
  <link href="css/<?php echo $portal_skin;?>/layout.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="css/vader/style.css">
  <script>
  $(function() {
    $( "#tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible.");
        });
      }
    });
  });
  </script>
  <script>
  $(function() {
    $( "#toptabs li" ).addClass( "ui-corner-top" ).removeClass( "ui-corner-left" );
    $( "#toptabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible." );
        });
      }
    });
  });

  </script>
  <style>
  .ui-toptabs { width: 100%; min-height:100px; margin:auto;}
  </style>

  <style>
  .ui-tabs-vertical { width:65em; margin:auto; overflow:yes;}
  .ui-tabs-vertical > .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
  .ui-tabs-vertical > .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
  .ui-tabs-vertical > .ui-tabs-nav li a { display:block; }
  .ui-tabs-vertical > .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
  .ui-tabs-vertical > .ui-tabs-panel { padding: 1em; float: right; width: 50em; min-height:100px;}
  </style>

</head>
<body>

  <div style="width:72em;margin-left: auto;margin-right: auto;">
   <div class="screenLayout">
    <div class="headerContainer">
     <div class="pageHeader">
      <div>
       <a href="<?php echo $baseurl; ?>" target="<?php echo $portal_title; ?>" title="<?php echo $portal_title; ?>" class="topLogo"><img src="<?php echo $portal_logo; ?>" name="logo" border="0" title="<?php echo $portal_title; ?>"></a><div id="topTxtBlock"><span id="topCopyright"><a href=<?php echo $portal_copyright_url; ?> target="_blank">&copy; <?php echo $portal_copyright_text; ?></a></span>
      </div>
     </div>
    </div>
   </div>

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Top</a></li>
    <li><a href="#tabs-2">Sign in</a></li>
    <li><a href="#tabs-3">About Us</a></li>
    <li><a href="#tabs-4">Developers</a></li>
    <li><a href="#tabs-5">Investors</a></li>
  </ul>
  <div id="tabs-1">

  <?PHP

  $access = TRUE;

  if ($access){

     $content_sendvars = "Body@".$lingo."@Content@list@".$val."@".$valtype;
     $content_sendvars = $funky_gear->encrypt($content_sendvars);
     $messages_sendvars = "Body@".$lingo."@Messages@list@".$val."@".$valtype;
     $messages_sendvars = $funky_gear->encrypt($messages_sendvars);
     $contacts_sendvars = "Body@".$lingo."@Contacts@list@".$val."@".$valtype;
     $contacts_sendvars = $funky_gear->encrypt($contacts_sendvars);
     $search_sendvars = "Body@".$lingo."@Search@ticketing@".$val."@".$valtype;
     $search_sendvars = $funky_gear->encrypt($search_sendvars);

   ?>
   <div id="toptabs">
     <ul>
       <li><a href="#hometab">Home</a></li>
       <li><a id="#content" title="content" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $content_sendvars; ?>">Content</a></li>
       <li><a id="#contacts" title="contacts" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $contacts_sendvars; ?>">Contacts</a></li>
       <li><a id="#messages" title="messages" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $messages_sendvars; ?>">Messages</a></li>
       <li><a id="#search" title="search" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $search_sendvars; ?>">Ticket Search</a></li>
     </ul>
   </div>
   <div id="hometab">
   <?php 

    $sent_params[0] = "hometab";
    $funkydo_gear->funkydone ($MYPOST,$lingo,'Content','view',$portal_account_id,'Accounts',$sent_params); 

   ?>	
   </div>

  <div id="GRID"></div>
  <div id="editor"></div>

  <?php 

  } else { // end if access for special tabs

  ?>
  <?php 

  $sent_params[0] = "tabs-1";
  $funkydo_gear->funkydone ($MYPOST,$lingo,'Content','view',$portal_account_id,'Accounts',$sent_params); 

  }

  ?>
  </div>
  <div id="tabs-2">
  <?PHP

   #<h2>Sign in</h2>
   $sent_params[0] = "tabs-2";
   $funkydo_gear->funkydone ($MYPOST,$lingo,'Login','login','','',$sent_params); 

  ?>
  </div>
  <div id="tabs-3">
  <?PHP
 
   #<h2>About Us</h2>
   $sent_params[0] = "tabs-3";
   $funkydo_gear->funkydone ($MYPOST,$lingo,'Accounts','view',$portal_account_id,'',$sent_params); 
  
  ?>
  </div>
  <div id="tabs-4">
   <h2>Developers</h2>
  </div>
  <div id="tabs-5">
   <h2>Investors</h2>
  </div>

</div>

</body>
</html>

<?PHP

#echo $funkydo_gear->funkydone ($_POST,$lingo,$do,$action,$val,$valtype,$sent_params);

exit;

##########################

$freq_timestamp_list = "2014-01-22 11:59:37
2014-09-29 15:32:48
2014-09-29 15:34:43
2014-09-29 15:36:08
2014-09-29 15:37:44
2014-09-30 14:27:50
2014-09-30 14:29:13
2014-10-04 17:59:16
2014-10-06 15:06:03
2014-10-07 15:49:16
2014-10-07 15:52:22
2014-10-07 19:01:19
2014-10-09 10:07:09
2014-10-09 10:08:50
2014-10-09 15:42:05
2014-10-09 15:44:11
2014-10-09 21:09:58
2014-10-09 21:15:57
2014-10-10 08:27:09
2014-10-10 08:28:09
2014-10-10 08:29:07
2014-10-10 08:30:07
2014-10-10 13:08:10
2014-10-10 13:11:40
2014-10-12 17:42:55
2014-10-13 13:10:09
2014-10-13 13:16:11
2014-10-13 17:52:48
2014-10-13 18:31:18
2014-10-13 18:33:50
2014-10-14 15:13:30
2014-10-14 15:15:29
2014-10-15 03:34:29
2014-10-16 00:44:29
2014-10-16 00:46:29
2014-10-16 00:48:29";

echo "portal_email ".$portal_email."<P>";

#$lines_arr = preg_split('/\n|\r/',$freq_timestamp_list);
$lines_arr = preg_split('/\n/',$freq_timestamp_list);
$num_newlines = count($lines_arr);
$freq_timespan = 30;

#var_dump($lines_arr);

foreach ($lines_arr as $thisfreq_timestamp){
 
        #$thisfreq_timestamp = $lines_array[];
        #echo "thisfreq_timestamp ".$thisfreq_timestamp."<BR>";

        }

$listcount = 0;

$email_timestamp = date('Y-m-d H:i:s');

             if ($num_newlines>1 && is_array($lines_arr)){

                foreach ($lines_arr as $thisfreq_timestamp){

                    #$thisfreq_timestamp = $lines_arr[$cnt_lines];
                    if ($thisfreq_timestamp != NULL){
                       echo "thisfreq_timestamp ".$thisfreq_timestamp."<BR>";
                       $thisfreq_timespan = $freq_timespan+1;
                       #$thisfreq_timespan = " +".$thisfreq_timespan." minutes"; // total time we are looking for
                       echo "thisfreq_timespan ".$thisfreq_timespan."<BR>";

                       $time = new DateTime($thisfreq_timestamp);
                       $time->add(new DateInterval('PT' . $thisfreq_timespan . 'M'));
                       $freq_timestamp_plus_span = $time->format('Y-m-d H:i:s');

                       #$freq_timestamp_plus_span = date("Y-m-d H:i:s", strtotime($thisfreq_timestamp.$thisfreq_timespan));
                       echo "freq_timestamp_plus_span ".$freq_timestamp_plus_span."<P>";

                       if ($email_timestamp <= $freq_timestamp_plus_span){

                          echo "This is within the span - should be counted<BR>";
                          # This is within the span - should be counted
                          # Any new subsequent emails that match will have a timestamp added
                          # If those accumulates timestamps are within span, then we will have our jackpot!
                          $listcount = $listcount+1;

                          echo "listcount $listcount<BR>";

                          } else {// if email timestamp is less than the looped timestamp

                          echo "Any timestamps not within span have no meaning now<BR>";
                          # Any timestamps not within span have no meaning now
                          $removefromlist .= $thisfreq_timestamp."\n";

                          } // end if within timespan

                       } // not null

                    } // end for

                } // end if array

echo "Removable lines <P>";

$removefromlist = $funky_gear->replacer("\n", "<br>", $removefromlist);
echo $removefromlist;

echo "<P>";

exit;

$subject = "";
$ticket_id = "";
$ticket = "";
$ticket_date = "2014-02-01_09-57-17";

$ticket_info = $funky_gear->replacer($ticket_date,"", $subject);
echo $ticket_info;
#$newsubject = implode("",mb_split($string, $subject));



$string = " T180SOZPSCOAP1";
echo "String:".$string."<BR>";
$string = rtrim($string);
$string = ltrim($string);
echo "String:".$string."<BR>";

$update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['par_id'] = 'c3891c31-9198-476d-0a8a-52df0e00c722';
$update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['type_id'] = 'AAAA';
$update_ci['c3891c31-9198-476d-0a8a-52df0e00c722']['value'] = '0';
$update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['par_id'] = '7a454f0d-3d12-7bc5-7607-52defc746103';
$update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['type_id'] = 'BBB';
$update_ci['7a454f0d-3d12-7bc5-7607-52defc746103']['value'] = '1';

foreach ($update_ci as $ci_info){
 
        $par_id = $ci_info['par_id'];
        $type_id = $ci_info['type_id'];
        $value = $ci_info['value'];

        echo "Par: ".$par_id." -> ".$type_id." -> ".$value."<BR>";

        }


$body = <<< BODY
<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-2022-jp">
<meta name="Generator" content="Microsoft Word 12 (filtered medium)">
</div>
</body>
</html>

BODY;

#echo $body;
$body = htmlspecialchars(strip_tags($body), ENT_QUOTES, 'utf-8');
$body = $funky_gear->replacer("\n", "<br>", $body);
$body = $funky_gear->replacer("&amp;nbsp;", "", $body);
#echo $body;

#$string = "";
#$newbody = $funky_gear->replacer($string, "", $body);

$string = "kazuhiro.fujimoto@hp.com";
$newbody = $funky_gear->replacer($string, "", $body);

#echo "New Body: ".$newbody."<P>";

$subject = "";

$string = "";
$string = "Operations Manager";
$string = "";

$newsubject = $funky_gear->replacer($string, "", $subject);

#echo "New Subject: ".$newsubject."<P>";

$newsubject = implode("",mb_split($string, $subject));
#$newsubject = mb_split($string, $subject);

echo "New Subject: ".$newsubject."<P>";

$this_country = 'JPN';
#include ("dates/Dates.php");

#$holdays = new Date_Holidays_Driver_Japan();
#$japan_holidays = $holdays->_buildHolidays();

$datemonth = date("Y-m");

echo "DATE: ".$datemonth."<P>";

$date = date ("Y-m-d G:i:s");
echo "DATE G: ".$date."<P>";
$date = date ("Y-m-d H:i:s");
echo "DATE H: ".$date."<P>";

echo "<P>Move<P>";

        ###############################
        # Move email to ticketed folder

        $filter_folder = "Development/Test-In";
        $ticket_folder = "Admin/0 - Auto-Tickets";
        $portal_imap_port = "993";
        $portal_imap_server = "imap.gmail.com";
        $portal_email = "hp-agc@scalastica.com";
        $portal_email_password = "MMMnnn777";
/*
        $filteredhost = "{".$portal_imap_server.":".$portal_imap_port."/imap/ssl}".$filter_folder;

        $report .= $debugger." Filterhost: ".$filteredhost."<BR>";

        $filteredinbox = imap_open($filteredhost,$portal_email,$portal_email_password) or die('Cannot connect to Gmail: ' . imap_last_error());

        $filteredemails = imap_search($filteredinbox,'ALL');

        if ($filteredemails) {

           $mailcnt = 0;

           foreach ($filteredemails as $filteredemail_number) {

                   $headers = imap_header($filteredinbox,$filteredemail_number);
                   $thisemail_id = $headers->message_id;

                   echo " Check if this Email ID (".$email_id.") == This Email ID (".$thisemail_id.")<BR>";
 
                   #if (in_array($thisemail_id,$previous_email_ids)){

                      $report .= $debugger." Check if this Email ID (".$email_id.") == This Email ID (".$thisemail_id.")<BR>";

                      #imap_mail_move($filteredinbox, $filteredemail_number,$ticket_folder);
                      #imap_delete($filteredinbox, $filteredemail_number);

                      #} // if msgno

                   } // foreach

           imap_close($filteredinbox);

           } // if filteredemails

        # End move email
        ###############################
*/

echo "<P>Check<P>";

$subject = "The cat chased the mouse";
$keyword = "The cat";
$subject = "邵ｺ諛翫・邵ｺ阮吮ｲ郢晞亂縺懃ｹ晄ｺ假ｽ帝ｬ滓ｺ倪・邵ｺ・ｾ邵ｺ蜉ｱ笳・ｸｲ繝ｻ";
$keyword = "邵ｺ繝ｻ縲・";

#echo preg_quote($keyword, $subject);
echo preg_quote($keyword, $subject)."<BR>";
#echo mb_split($keyword, $subject);
echo mb_split($keyword, $subject)."<BR>";
#echo implode("繝ｻ・ｰ繝ｻ・ｰ繝ｻ・ｰ",mb_split($keyword, $subject));
$check_subject = implode("繝ｻ・ｰ繝ｻ・ｰ繝ｻ・ｰ",mb_split($keyword, $subject));
echo $check_subject."<P>";

echo "<P>Add Mins<P>";

$freq_timespan = 30;
$freq_timespan = $freq_timespan+1;
$freq_timespan = " +".$freq_timespan." minute";
$freq_timestamp = '2014-01-22 12:39:00';
$freq_timestamp_plus_span = date("Y-m-d H:i:s", strtotime($freq_timestamp.$freq_timespan));
$email_timestamp = date('Y-m-d H:i:s');

echo "<P>Freq_timestamp: $freq_timestamp && Freq_timespan: $freq_timespan && Freq_timestamp_plus_span: $freq_timestamp_plus_span && Email_timestamp $email_timestamp<P>";

echo "<P>Holidays<P>";



var_dump($japan_holidays);

echo "<P>Holidays over<P>";

if (is_array($japan_holidays['_internalNames'])){

var_dump($japan_holidays['_internalNames']);
//   foreach ($japan_holidays as )
   }

$recp_to_list = 'takasi-akiyama@agc.com,satoru-harada@agc.com,takasi-moriwaki@agc.com,takasi-inoue@agc.com';

                                     $recp_to_array = explode(',',$recp_to_list); //split string into array seperated by ','
                                     foreach ($recp_to_array as $recp_to_value){
echo "TO: ".$recp_to_value."<BR>";
                                             $to_addressees[$recp_to_value] = $recp_to_value;

                                             }
                                      // end if recp_cc_list
echo "NEXT<BR>";

var_dump($to_addressees);


echo "NEXT<BR>";

if (is_array($to_addressees)){


   foreach ($to_addressees as $email => $name){

echo "Email: ".$email." and name ".$name."<BR>";

           $AddAddress[] = array($email => $name);

           }

   } // if array

echo "NEXT<BR>";

var_dump($AddAddress);

echo "NEXT<BR>";

$start_day = "Friday";
$end_day = "Monday";
$date = "2013-12-29 07:41";

                                      $emailday = date("l", strtotime($date)); // Day of the email
echo "Email day = $emailday <P>";
                                      $emailday_date = date('Y-m-d', strtotime($date));

echo "Email date = $emailday_date <P>";

                                      $emaildate_plus_one_day = date('Y-m-d', strtotime($date .' +1 day'));

echo "Email date plus_one_day = $emaildate_plus_one_day <P>";

                                      $emaildate_plus_two_days = date('Y-m-d', strtotime($date .' +2 days'));
                                      $emaildate_plus_three_days = date('Y-m-d', strtotime($date .' +3 days'));
                                      $emaildate_plus_four_days = date('Y-m-d', strtotime($date .' +4 days'));
                                      $emaildate_plus_five_days = date('Y-m-d', strtotime($date .' +5 days'));
                                      $emaildate_plus_six_days = date('Y-m-d', strtotime($date .' +6 days'));

                                      $emaildate_minus_one_day = date('Y-m-d', strtotime($date .' -1 day'));

echo "Email date minus_one_day = $emaildate_minus_one_day <P>";

                                      $emaildate_minus_two_days = date('Y-m-d', strtotime($date .' -2 days'));
                                      $emaildate_minus_three_days = date('Y-m-d', strtotime($date .' -3 days'));
                                      $emaildate_minus_four_days = date('Y-m-d', strtotime($date .' -4 days'));
                                      $emaildate_minus_five_days = date('Y-m-d', strtotime($date .' -5 days'));
                                      $emaildate_minus_six_days = date('Y-m-d', strtotime($date .' -6 days'));

                                      if ($emailday == $end_day){
                                         $end_day_date = $emailday_date;
                                         } elseif ($end_day == date('l', strtotime($date .' +1 day'))){
                                            $end_day_date = $emaildate_plus_one_day;

echo "end_day_date = $end_day_date and Email Date plus_one_day = $emaildate_plus_one_day <P>";

                                         } elseif ($end_day == date('l', strtotime($date .' +2 days'))){
                                            $end_day_date = $emaildate_plus_two_days; 
                                         } elseif ($end_day == date('l', strtotime($date .' +3 days'))){
                                            $end_day_date = $emaildate_plus_three_days; 
                                         } elseif ($end_day == date('l', strtotime($date .' +4 days'))){
                                            $end_day_date = $emaildate_plus_four_days; 
                                         } elseif ($end_day == date('l', strtotime($date .' +5 days'))){
                                            $end_day_date = $emaildate_plus_five_days; 
                                         } elseif ($end_day == date('l', strtotime($date .' +6 days'))){
                                            $end_day_date = $emaildate_plus_six_days; 
                                         }

echo "start_day = $start_day and Email Date minus_one_day = $emaildate_minus_one_day <P>";
echo "start_day = $start_day and Email Date minus_two_days = $emaildate_minus_two_days <P>";
echo "start_day = $start_day and Email Date minus_three_days = $emaildate_minus_three_days <P>";

                                      if ($emailday == $start_day){
                                         $start_day_date = $emailday_date;
                                         } elseif ($start_day == date('l', strtotime($date .' -1 day'))){
                                            $start_day_date = $emaildate_minus_one_day;
                                         } elseif ($start_day == date('l', strtotime($date .' -2 days'))){
                                            $start_day_date = $emaildate_minus_two_days; 
                                         } elseif ($start_day == date('l', strtotime($date .' -3 days'))){
                                            $start_day_date = $emaildate_minus_three_days; 
                                         } elseif ($start_day == date('l', strtotime($date .' -4 days'))){
                                            $start_day_date = $emaildate_minus_four_days; 
                                         } elseif ($start_day == date('l', strtotime($date .' -5 days'))){
                                            $start_day_date = $emaildate_minus_five_days; 
                                         } elseif ($start_day == date('l', strtotime($date .' -6 days'))){
                                            $start_day_date = $emaildate_minus_six_days; 
                                         }


?>