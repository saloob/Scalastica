<?PHP

$file = "latest.json";
$app_id = "30c42832e35445d88dbcbb232dcec12d";
$curr_url = "https://openexchangerates.org/api/".$file."?app_id=".$app_id;
#$ch = curl_init("https://openexchangerates.org/api/{$file}?app_id={$appId}&symbols={$currencies}");
$ch = curl_init($curr_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

# Get the data:
$json = curl_exec($ch);
curl_close($ch);

# Decode JSON response:
$exchangeRates = json_decode($json);

#var_dump($exchangeRates);

$disclaimer = $exchangeRates->disclaimer;
$license = $exchangeRates->license;
$timestamp = $exchangeRates->timestamp;
$base = $exchangeRates->base;
$rates = $exchangeRates->rates;
$USD = $rates->USD;
$AUD = $rates->AUD;
$JPY = $rates->JPY;

#var_dump($rates);

foreach ($rates as $curr=>$rate){
        #echo $curr.": ".$rate."<BR>";
        $currencies .= $curr.",";
        }

echo $currencies;
echo "USD: ".$USD;
echo "AUD: ".$AUD;
echo "JPY: ".$JPY;

exit;

$tldlist = $_GET["tlds"];
#$tldlist = ".net[].de[].ch";

$tlds = explode("[]",$tldlist);

if (is_array($tlds)){

    foreach ($tlds as $tld){

        echo "tld: ".$tld."<BR>";

        }

     }

#exit;

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

date_default_timezone_set('Asia/Tokyo');

if (!function_exists('get_param')){
   include ("common.php");
   }


#$check_acc_id = "2c769bfc-584b-59a3-f41f-51b2b64d02b3";
/*
     if ($check_acc_id != NULL){

        echo "<P>check_acc_id $check_acc_id <P>";

        $pricing_package[0] = $check_acc_id;
        $relaccquery = $funky_gear->get_pricing_partners ($pricing_package);
        var_dump($relaccquery);

        } # if accservice_owner_id
*/

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

  <script>

    function Registration_elementsEvents() {
        $(document).on("click", "a :input,a a,a fieldset label", function(event) {
            event.stopPropagation();
        });

        $(document).off("click", '#Registration_mobileheader [name="mobilebutton_35"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    Apperyio.navigateTo('startScreen', {
                        reverse: false
                    });

                }
            },
        }, '#Registration_mobileheader [name="mobilebutton_35"]');

    };

  </script>
  <script>
  function CallMethod(url, parameters, successCallback) {
                //show loading... image

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: JSON.stringify(parameters),
                    contentType: 'application/json;',
                    dataType: 'json',
                    success: successCallback,
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('error');
                    }
                });
            }

CallMethod(url, pars, onSuccess);

function onSuccess(param) {
    //remove loading... image
    //do something with the response
}

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

  <style>
body {
    overflow: auto;
}

a {
    outline: none;
    color: black;
    -webkit-touch-callout: none;
}

td {
    vertical-align: top;
}

.ui-field-contain {
    padding: 0;
    border-bottom-width: 0px;
}

.ui-selectmenu {
    z-index: 1001 !important;
}

.ui-btn.ui-btn-right:not(.ui-btn-icon-notext) {
    text-align: right;
}

.ui-btn.ui-btn-left:not(.ui-btn-icon-notext) {
    text-align: left;
}

.ui-mobile-viewport textarea.ui-input-text {
    margin: 0;
}

.ui-mobile-viewport .ui-footer .ui-body {
    clear: none;
}

.ui-mobile-viewport .ui-header div.ui-navbar,
.ui-mobile-viewport .ui-footer div.ui-navbar {
    position: absolute;
    width: 100%;
    bottom: 0px;
}

.ui-field-contain div.ui-input-text,
.ui-field-contain textarea.ui-input-text,
.ui-field-contain div.ui-input-search,
.ui-field-contain div.ui-slider:not(.ui-slider-switch),
.ui-field-contain div.ui-select {
    width: 100%;
    display: block;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
}

/* see ETST-20022 */
.ui-field-contain div.ui-select.ui-btn-inline{
    display: inline-block;
}

/* Listview */

.ui-listview > li a > h3 {
    margin: 0;
}

.ui-listview .ui-li-has-thumb > .ui-btn > img:first-child:not([dsid]) {
    height: 5em;
    width: 5em;
}

ol.ui-listview > li span.ui-li-count {
    margin-top: -.88em;
    text-indent: inherit;
}

/* see ETST-11565 */
li div.ui-li-static-container.ui-btn{
    margin:0;
    overflow: overlay;
    -webkit-border-radius: inherit;
    -moz-border-radius: inherit;
    border-radius: inherit;
    border-bottom-width: 0;
    border-right-width: 0;
    text-align: left;
}

li.ui-last-child div.ui-li-static-container.ui-btn {
    border-bottom-width: 1px;   
    border-bottom-right-radius: 0;   
} 
li.ui-first-child div.ui-li-static-container.ui-btn {
    border-top-right-radius: 0;   
} 

.ui-listview li.ui-li-has-thumb div.ui-li-static-container.ui-btn > img:first-child:not([dsid]){
    position: absolute;
    top: 50%;
    left:0;
    max-width: 5em;
    max-height: 5em;
    margin-top: -2.5em;   
}

.ui-listview li.ui-li-has-icon div.ui-li-static-container.ui-btn > img:first-child:not([dsid]){
    position: absolute;
    top: 50%;
    left:10px;
    max-width: 1em;
    max-height: 1em;
    margin-top: -0.5em;   
}  

.ui-listview > li.ui-li-has-icon img:first-child:not([dsid]) {
    -webkit-border-radius: 0;
    border-radius: 0;
}

.ui-listview .ui-li-has-thumb > img[dsid]:first-child, .ui-listview .ui-li-has-thumb > .ui-btn > img[dsid]:first-child {
    position: static ; 
    max-height: none ; 
    max-width: none ; 
}

.ui-listview a.ui-btn.ul-li-custom-split-button {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    width: 40px;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    z-index: 2; 
}

.ui-listview a.ui-btn.ul-li-custom-split-button:focus, 
.ui-listview li.ui-btn:focus {
     z-index: 3; 
}

.ui-listview li.ui-btn:after {
    z-index: 4; /*ETST-20410*/
}

.ui-listview li.ui-last-child .ui-btn.ul-li-custom-split-button {
    -moz-border-bottom-right-radius: inherit;
    -webkit-border-bottom-right-radius: inherit;
    border-bottom-right-radius: inherit;
    -moz-border-bottom-left-radius: 0;
    -webkit-border-bottom-left-radius: 0;
    border-bottom-left-radius: 0;
}

.ui-listview li.ui-first-child .ui-btn.ul-li-custom-split-button {
    -moz-border-top-right-radius: inherit;
    -webkit-border-top-right-radius: inherit;
    border-top-right-radius: inherit;
    -moz-border-top-left-radius: 0;
    -webkit-border-top-left-radius: 0;
    border-top-left-radius: 0;
}

.ui-btn-icon-right.ui-icon-none:after{
    display:none;
}

ol.ui-listview li.ui-btn .ui-li-static-container.ui-btn:before {
    display: none;
}
ol.ui-listview > li .ui-li-static-container img:first-child + * {
    display: inherit;
}
ol.ui-listview > li img:first-child + * ~ * {
    text-indent: inherit;
} 
ol.ui-listview > li.ui-li-static h1,
ol.ui-listview > li.ui-li-static h2,
ol.ui-listview > li.ui-li-static h3,
ol.ui-listview > li.ui-li-static h4,
ol.ui-listview > li.ui-li-static h5,
ol.ui-listview > li.ui-li-static h6 {
    display: block;
}

/* ETST-17856 */
ol.ui-listview > li > a > h3 {
    width: 100%;
    text-indent: 2em;
    margin-left: -2em;
}

/* see ETST-7646 */
@media all and (min-width: 28em) {
    .ui-mobile-viewport .ui-field-contain .ui-controlgroup-controls {
        display: block;
        width: auto;
        float: none;
    }
}

/* ETST-7532 */
.ui-icon.ui-icon-none {
    background: none;
    background-image: none;
}

.ui-icon-shadow.ui-icon-none {
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
}

.tiggzi-mobiletemplate {
    background-color: transparent;
    padding: 0px;
}

/* ETST-10870 */
.ui-header > .ui-btn-left,
.ui-header > .ui-btn-right {
    max-width: 30%;
}

/* ETST-12129 */
.ui-collapsible > .ui-collapsible-content {
    border-top: 1px solid transparent;
    margin-top: -1px;
}

/* ETST-14349 */
.content-secondary .ui-collapsible-content ul[data-role="listview"] {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.content-secondary .ui-collapsible-content [data-role="listview"] .ui-li.ui-first-child {
    border-top-width: 1px;
}

.content-secondary .ui-scrollview-view > .ui-collapsible {
    margin-top: 0px;
}

.content-secondary .ui-collapsible .hasDatepicker {
    width: 100%;
}

/* ETST-17778 */
.ui-header .ui-btn:not(.ui-input-clear-hidden) {
    display: block;
}

/* ETST-17901 */
.ui-icon-none.ui-btn-icon-left:after,
.ui-icon-none.ui-btn-icon-right:after,
.ui-icon-none.ui-btn-icon-top:after,
.ui-icon-none.ui-btn-icon-bottom:after,
.ui-icon-none.ui-btn-icon-notext:after {
    background-color: transparent;
}

/* ETST-17941 */
.ui-mobile .ui-input-text, .ui-mobile .ui-input-search {
    margin: 0;
}

/* ETST-17802 */
div[data-role="panel"] div.hasDatepicker { 
    width: 100%;
}

/* ETST-19652 */
div.ui-navbar ul.ui-grid-solo li.ui-block-a {
	margin-left: 0;
	margin-right: 0;
}

/* ETST-20351 */
.ui-popup .ui-slider {
	min-width:110px;
}

/* ETST-20352 */
.ui-popup [apperytype="object"]:not([apperyclass="carousel"]){
	min-width: 150px;
}

/* ETST-20172 */
.ui-btn-icon-right.ui-btn-icon-left:after {
	left: auto;
    right: .5625em;
}
.ui-btn-icon-right.ui-btn-icon-left {
    padding-left: 1em;
}

/* ETST-20407 */
.ui-li-static h3.ui-collapsible-heading {
    margin-top: -1px;
    margin-bottom: 0;
    overflow: visible;
}

div[data-role="popup"], .ui-popup-content-wrapper {
    max-width: inherit;
}

/* ETST-20447 */
div[data-role="popup"] > .ui-popup-content-wrapper > div > table{
    table-layout:auto;
}

/* ETST-21103 */
.ui-controlgroup-vertical .ui-controlgroup-controls .cell-wrapper .ui-btn {
    border-bottom-width: 1px;
}

/* We need "html.ui-mobile>body.ui-mobile-viewport" prefix to make selector heavy enough to override casual displays */
html.ui-mobile > body.ui-mobile-viewport [data-appery-tpl='true'] {
    display: none;
}
/* Define default spinner */
.ui-icon-loading {
	background: url("files/resources/lib/jquerymobile/1.4.4/images/ajax-loader.gif") repeat scroll 0 0 / 46px 46px transparent!important;
}
/* mobilebutton_35 */
#Registration_mobilebutton_35 {

}
.ui-btn.Registration_mobilebutton_35 {

}
/* mobilecontainer */
.ui-content.Registration_mobilecontainer {
	padding: 15px 15px 15px 15px;
}
/* account_name */
.Registration_account_name {
	margin: 4px 0px 4px 0px;
}
/* username */
.Registration_username {
	margin: 4px 0px 4px 0px;
}
/* password */
.Registration_password {
	margin: 4px 0px 4px 0px;
}
/* first_name */
.Registration_first_name {
	margin: 4px 0px 4px 0px;
}
/* last_name */
.Registration_last_name {
	margin: 4px 0px 4px 0px;
}
/* email */
.Registration_email {
	margin: 4px 0px 4px 0px;
}
/* button_register */
#Registration_button_register {

}
.ui-btn.Registration_button_register {
	margin: 4px 5px 4px 5px;
}
/* rego_message */
.Registration_rego_message {
	text-decoration: none; font-weight: normal; font-style: italic; text-align: left; font-family: Helvetica; font-size: 16px;
	margin: 4px 0px 4px 0px;
	display: none;
	word-wrap: break-word;
	white-space: normal;
}
/* mobilefooter */
.Registration_mobilefooter {
	min-height:38px;
}

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

$fbtoken = $_SESSION['fb_token'];
#echo "<P>FB: ".$fbtoken."<P>";

?>
        <div data-role="page" style="min-height:480px;" dsid="Registration" id="Registration"
        class="type-interior" data-theme="b">
            <!-- mobileheader -->
            <div data-role="header" data-position="fixed" data-add-back-btn="false" data-back-btn-text="Back"
            data-theme="b" name="mobileheader" id="Registration_mobileheader" class="Registration_mobileheader">
                <h1 dsid="mobileheader">
                    Registration
                </h1>
                <!-- mobilebutton_35 --><!--
                --><a data-role="button" name="mobilebutton_35" dsid="mobilebutton_35" class="Registration_mobilebutton_35 ui-btn-left"
                style='min-height:16px; ' id="Registration_mobilebutton_35" data-corners="true" data-icon="home"
                data-iconpos="left" x-apple-data-detectors="false" data-inline='true' data-mini='true'
                data-theme="b" tabindex="16">
                &nbsp;
                </a>
            </div>
        </div>
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