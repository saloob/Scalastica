<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-05-21
# Page: Index 
############################################## 
# Start Includes

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

date_default_timezone_set('Asia/Tokyo');

if (!function_exists('get_param')){
   include ("common.php");
   }

if ($do == NULL && $action == NULL && $val == NULL && $valtype == NULL){

   $do = "Home";
   $action = $portal_type;
   $val = "";
   $valtype = "";

   $left_sendvars = "Left@".$lingo."@@".$portal_type."@@";
   $left_sendvars = $funky_gear->encrypt($left_sendvars);

   $body_sendvars = "Body@".$lingo."@Home@".$portal_type."@@";
   $body_sendvars = $funky_gear->encrypt($body_sendvars);

   $right_sendvars = "Right@".$lingo."@@".$portal_type."@@";
   $right_sendvars = $funky_gear->encrypt($right_sendvars);

   } else {

   $left_sendvars = "Left@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
   $left_sendvars = $funky_gear->encrypt($left_sendvars);

   $body_sendvars = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
   $body_sendvars = $funky_gear->encrypt($body_sendvars);

   $right_sendvars = "Right@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
   $right_sendvars = $funky_gear->encrypt($right_sendvars);

   }

switch ($portal_type){

 case 'system':

 break;
 case 'provider':

 break;
 case 'reseller':

 break;
 case 'client':

 break;

}

//$left_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$leftcolumnwidth.";\"><div id=\"".$LeftDIV."\"></div></div>";
#$leftcolumnwidth = "16%";
#$bodycolumnwidth = "56%";
#$rightcolumnwidth = "16%";

$left_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$leftcolumnwidth.";\" id=\"".$LeftDIV."Container\">
 <div class=\"".$LeftDIV."\" id=\"".$LeftDIV."\"></div>
</div>
<script type=\"text/javascript\">
 ajax_loadContent('$LeftDIV','tr.php?pc=$portalcode&sv=$left_sendvars');
</script>";

$body_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:2px;padding-right:2px;min-height:100px;width:".$bodycolumnwidth.";\" id=\"".$BodyDIV."Container\">
 <div class=\"".$BodyDIV."\" id=\"".$BodyDIV."\"></div>
</div>
<script type=\"text/javascript\">
           $(document).ready(function(){
               $('#$BodyDIV').load('tr.php?pc=$portalcode&sv=$body_sendvars');
           });
        </script>";

$right_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$rightcolumnwidth.";\" id=\"".$RightDIV."Container\">
 <div class=\"".$RightDIV."\" id=\"".$RightDIV."\"></div>
</div>
<script type=\"text/javascript\">
 ajax_loadContent('$RightDIV','tr.php?pc=$portalcode&sv=$right_sendvars');
</script>";

$rightload = "tr.php?pc=".$portalcode."&sv=".$right_sendvars;
#$right_part = "<script>$(\"#".$RightDIV."\").load(\"".$rightload."\");</script>";

//$body_part = "<div style=\"float:left;margin-top:0px;margin-left:2px;margin-right:2px;padding-top:0px;padding-left:4px;padding-right:0px;min-height:100px;width:".$bodycolumnwidth.";\"><div id=\"".$BodyDIV."\"></div></div>";

//$right_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$rightcolumnwidth.";\"><div id=\"".$RightDIV."\"></div></div>";

# End Host Management
########################
# AJAX Tranceiver

/*

Ajax script used in the javascript for body to perform something based on action
Immediately under;

 function doBPOSTRequest (bdiv,url,parameters){

    var params = parameters.split('&');
    for (var i=0;i<params.length;i++){
        var spl = params[i].split('=');
        key = spl[0];
        val = spl[1];

        if (key == 'action' && (val == 'add' || val == 'edit')) {
              //document.write('key=' + key + ' AND value='+val+'<BR>');
              //expander('expandiv');
              } else {
              //reducer('expandiv');
              }

        }


*/

$jsgear = <<< JSGEAR

<script type="text/javascript">

 var b_http_request;
 var v_http_request;
 var l_http_request;
 var r_http_request;
 var mtv_http_request;
 var thediv;
 var zaldiv;
 var zabdiv;
 var zardiv;

function jsleep(s){
 s=s*1000;
 var a=true;
 var n=new Date();
 var w;
 var sMS=n.getTime();
 while(a){
  w=new Date();
  wMS=w.getTime();
  if(wMS-sMS>s) a=false;
  }
}

function changeTitle (title){

  parent.document.title = title;

}

function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}


		var editor, html = '';

		function createEditor() {
			if ( editor )
				return;

			// Create a new editor inside the <div id="editor">, setting its value to html
			var config = {};
			editor = CKEDITOR.appendTo( 'editor', config, html );
		}

		function removeEditor() {
			if ( !editor )
				return;

			// Destroy the editor.
			editor.destroy();
			editor = null;
		}

function divtoggler(showHideDiv) {
	var ele = document.getElementById(showHideDiv);

        if (ele.style.display == "block") {
           ele.style.display = "none";
//	   text.innerHTML = "<font size=2><B>Show/Hide Content</B></font>";
  	   }
           else {
		ele.style.display = "block";
//		text.innerHTML = "<font size=2><B>Show/Hide Content</B></font>";
	        }
 }

function contentstoggler(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

        if (ele.style.display == "block") {
           ele.style.display = "none";
	   text.innerHTML = "<font size=2><B>Show/Hide Content</B></font>";
  	   }
           else {
		ele.style.display = "block";
		text.innerHTML = "<font size=2><B>Show/Hide Content</B></font>";
	        }
 }

function fbtoggler(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

        if (ele.style.display == "block") {
           ele.style.display = "none";
	   text.innerHTML = "<font size=2><B>Show/Hide Facebook Friends</B></font>";
  	   }
           else {
		ele.style.display = "block";
		text.innerHTML = "<font size=2><B>Show/Hide Facebook Friends</B></font>";
	        }
 }

function logintoggler(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

        if (ele.style.display == "block") {
   	   ele.style.display = "none";
	   text.innerHTML = "<font size=2><B>Show/Hide Login</B></font>";
           }
           else {
		ele.style.display = "block";
		text.innerHTML = "<font size=2><B>Show/Hide Login</B></font>";
	        }
 } 

function googletoggler(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

        if (ele.style.display == "block") {
   	   ele.style.display = "none";
	   text.innerHTML = "<font size=2><B>Show/Hide Google+</B></font>";
           }
           else {
		ele.style.display = "block";
		text.innerHTML = "<font size=2><B>Show/Hide Google+</B></font>";
	        }
 } 

function linkedintoggler(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

        if (ele.style.display == "block") {
   	   ele.style.display = "none";
	   text.innerHTML = "<font size=2><B>Show/Hide Linkedin</B></font>";
           }
           else {
		ele.style.display = "block";
		text.innerHTML = "<font size=2><B>Show/Hide Linkedin</B></font>";
	        }
 } 

function embeddtoggler(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

        if (ele.style.display == "block") {
   	   ele.style.display = "none";
	   text.innerHTML = "<font size=2><B>Show Embedded Services</B></font>";
           }
           else {
		ele.style.display = "block";
		text.innerHTML = "<font size=2><B>Hide Embedded Services</B></font>";
	        }
 } 


 function cleardiv(thediv) {
     $("#thediv").hide('explode',1000);
     document.getElementById(thediv).innerHTML = '';
 }
 function cleardiv2(thediv) {
     document.getElementById(thediv).innerHTML = '';
 }

 function loader(thediv) {
     document.getElementById(thediv).innerHTML = '<img src="images/loading.gif">';
 }

 function expander(thediv) {
     document.getElementById(thediv).innerHTML = '<img src="images/blank.gif" width=600 height=5>';
 }

function reducer(thediv) {
     document.getElementById(thediv).innerHTML = '<img src="images/blank.gif" width=450 height=5>';
 }

 function Scroller() {
     window.scrollTo(0,0);
 }

 function doLPOSTRequest (ldiv,url,parameters){

  zaldiv = ldiv;

  try{
     // Opera 8.0+, Firefox, Safari
     l_http_request = new XMLHttpRequest();
     } catch (e){
     // Internet Explorer Browsers
     try{
        l_http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
        try{
           l_http_request = new ActiveXObject("Microsoft.XMLHTTP");
           } catch (e){
           // Something went wrong
           alert("Your browser broke!");
           return false;
           }
        }
     }

  l_http_request.onreadystatechange = DoLContents;
  l_http_request.open('POST', url, true);
  l_http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  l_http_request.setRequestHeader("Content-length", parameters.length);
  l_http_request.setRequestHeader("Connection", "close");
  l_http_request.send(parameters);

}

 function DoLContents() {

  if (l_http_request.readyState == 4) {
     if (l_http_request.status == 200) {
        result = l_http_request.responseText;
        document.getElementById(zaldiv).innerHTML = result;
        } else {
          alert('There was a problem with the request.');
        }
     }
 }

 function doBPOSTRequest (bdiv,url,parameters){

  zabdiv = bdiv;

  try{
     // Opera 8.0+, Firefox, Safari
     b_http_request = new XMLHttpRequest();
     } catch (e){
     // Internet Explorer Browsers
     try{
        b_http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
        try{
           b_http_request = new ActiveXObject("Microsoft.XMLHTTP");
           } catch (e){
           // Something went wrong
           alert("Your browser broke!");
           return false;
           }
        }
     }

  b_http_request.onreadystatechange = DoBContents;
  b_http_request.open('POST', url, true);
  b_http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  b_http_request.setRequestHeader("Content-length", parameters.length);
  b_http_request.setRequestHeader("Connection", "close");
  b_http_request.send(parameters);
  Scroller();

}

 function DoBContents() {

  if (b_http_request.readyState == 4) {
     if (b_http_request.status == 200) {
        result = b_http_request.responseText;
        document.getElementById(zabdiv).innerHTML = result;
        } else {
          alert('There was a problem with the request.');
        }
     }
 }

 function doRPOSTRequest (rdiv,url,parameters){

  zardiv = rdiv;

  try{
     // Opera 8.0+, Firefox, Safari
     r_http_request = new XMLHttpRequest();
     } catch (e){
     // Internet Explorer Browsers
     try{
        r_http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
        try{
           r_http_request = new ActiveXObject("Microsoft.XMLHTTP");
           } catch (e){
           // Something went wrong
           alert("Your browser broke!");
           return false;
           }
        }
     }

  r_http_request.onreadystatechange = DoRContents;
  r_http_request.open('POST', url, true);
  r_http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  r_http_request.setRequestHeader("Content-length", parameters.length);
  r_http_request.setRequestHeader("Connection", "close");
  r_http_request.send(parameters);

}

 function DoRContents() {

  if (r_http_request.readyState == 4) {
     if (r_http_request.status == 200) {
        result = r_http_request.responseText;
        document.getElementById(zardiv).innerHTML = result;
        } else {
          alert('There was a problem with the request.');
        }
     }
 }

function FileSelectHandler(e) {

	// cancel event and hover styling
	FileDragHover(e);

	// fetch FileList object
	var files = e.target.files || e.dataTransfer.files;

	// process all File objects
	for (var i = 0, f; f = files[i]; i++) {
		ParseFile(f);
		UploadFile(f);
	}

}

// upload JPEG files
function UploadFile(file) {

  var xhr = new XMLHttpRequest();

  if (xhr.upload && file.type == "image/jpeg" && file.size <= $id("MAX_FILE_SIZE").value) {
		// start upload
		xhr.open("POST", $id("upload").action, true);
		xhr.setRequestHeader("X_FILENAME", file.name);
		xhr.send(file);

	}

}

 function get(obj) {

  var getstr = "";
  var thisdivid = "";

  for (i=0; i<obj.getElementsByTagName("input").length; i++) {

          if (obj.getElementsByTagName("input")[i].type == "hidden") {
             getstr += obj.getElementsByTagName("input")[i].name + "=" + obj.getElementsByTagName("input")[i].value + "&";
             if (obj.getElementsByTagName("input")[i].name == 'sendiv'){
                thisdivid = obj.getElementsByTagName("input")[i].value;
                }
             }

          if (obj.getElementsByTagName("input")[i].type == "password") {
             getstr += obj.getElementsByTagName("input")[i].name + "=" + obj.getElementsByTagName("input")[i].value + "&";
             }

          if (obj.getElementsByTagName("input")[i].type == "text") {
             obj.getElementsByTagName("input")[i].value = encodeURIComponent(obj.getElementsByTagName("input")[i].value);
             getstr += obj.getElementsByTagName("input")[i].name + "=" + obj.getElementsByTagName("input")[i].value + "&";
             }

          if (obj.getElementsByTagName("input")[i].type == "checkbox") {

             if (obj.getElementsByTagName("input")[i].checked) {
                getstr += obj.getElementsByTagName("input")[i].name + "=" + obj.getElementsByTagName("input")[i].value + "&";
                } else {
                getstr += obj.getElementsByTagName("input")[i].name + "=&";
                }
             }

          if (obj.getElementsByTagName("input")[i].type == "radio") {
             if (obj.getElementsByTagName("input")[i].checked) {
                getstr += obj.getElementsByTagName("input")[i].name + "=" + obj.getElementsByTagName("input")[i].value + "&";
                }
             }

          }


      for (i=0; i<obj.getElementsByTagName("textarea").length; i++) {
             obj.getElementsByTagName("textarea")[i].value = encodeURIComponent(obj.getElementsByTagName("textarea")[i].value);
             getstr += obj.getElementsByTagName("textarea")[i].name + "=" + obj.getElementsByTagName("textarea")[i].value + "&";

   }

      for (i=0; i<obj.getElementsByTagName("select").length; i++) {
             var sel = obj.getElementsByTagName("select")[i];
             getstr += sel.id + "=" + sel.options[sel.selectedIndex].value + "&";
   }

   if (thisdivid == ""){
      thisdivid = '$BodyDIV';
      }

	//Added by vivek
	document.getElementById(thisdivid).innerHTML = '<img src="images/loading.gif">';
    doBPOSTRequest(thisdivid,'tr.php','pg=$Body&'+getstr);

   }

function pc_startup (){

doLPOSTRequest('$LeftDIV','tr.php','pc=$portalcode&sv=$left_sendvars');
doBPOSTRequest('$BodyDIV','tr.php','pc=$portalcode&sv=$body_sendvars');
doRPOSTRequest('$RightDIV','tr.php','pc=$portalcode&sv=$right_sendvars');

}

function signinCallback(authResult) {
  if (authResult['access_token']) {
    // Successfully authorized
    // Hide the sign-in button now that the user is authorized, for example:
    document.getElementById('signinButton').setAttribute('style', 'display: none');
  } else if (authResult['error']) {
    // There was an error.
    // Possible error codes:
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatially log in the user
    // console.log('There was an error: ' + authResult['error']);
  }
}

</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
#progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
#bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
#percent { position:absolute; display:inline-block; top:3px; left:48%; }
</style>

JSGEAR;

# End AJAX Tranceiver
########################
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article" />
 <head> 
  <title><?php echo $portal_title;?></title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="google-site-verification" content="F8yDhS86LIY3eSdMBPztrEs5kfdzyxCgZufnf9Rlqpw" />
  <meta name="robots" content="ALL,index,follow">
  <meta name="keywords" content="<?php echo $strings["HTML_Keywords"];?>">
  <meta name="description" content="<?php echo $strings["HTML_Description"];?>">
  <meta name="revisit-after" content="3 Days">
  <meta name="rating" content="Safe For Kids">
  <meta name="author" content="Computec">
  <meta http-equiv="reply-to" content="<?php echo $portal_email; ?>" />
  <meta http-equiv="imagetoolbar" content="no">
  <script language="javascript" type="text/javascript" src="css/<?php echo $portal_skin;?>/frame.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $portal_style; ?>">
  <script language="javascript" type="text/javascript" src="js/common.js"></script>
  <link href="css/<?php echo $portal_skin;?>/custom.css" rel="stylesheet" type="text/css">
  <link href="css/<?php echo $portal_skin;?>/general.css" rel="stylesheet">
  <link href="css/<?php echo $portal_skin;?>/mpc.css" rel="stylesheet" type="text/css">
  <link href="css/<?php echo $portal_skin;?>/layout.css" rel="stylesheet" type="text/css">
  <!--[if IE]><link href="css/<?php echo $portal_skin;?>/ie.css" rel="stylesheet" type="text/css"><![endif]-->
  <link href="css/<?php echo $portal_skin;?>/misc.css" rel="stylesheet" type="text/nonsense">
  <link href="css/<?php echo $portal_skin;?>/<?php echo $portal_skin;?>.css" rel="stylesheet">
  <link id="favicon" rel="icon" type="image/png" href="favicon.ico" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.9.1.js"></script>
  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <script src="ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" type="text/css" href="chat/client/themes/default/pfc.min.css" />
  <script src="chat/client/pfc.min.js" type="text/javascript"></script>
  <script type="text/javascript">
   SyntaxHighlighter.all({toolbar:false});
  </script>

 <script type="text/javascript">

 $(document).ready(function(){

   $(".button").click(function){

   var pg = $(this).attr("pg");
   var divid = $(this).attr("divid");
   $("#"+divid).load(pg);

   )}

  )}

  </script>

  <style type="text/css">
  .center{
   margin:auto;
   width:100%;
   height:100%;
   }
  </style>

  <style>
  #GRID { width: 100%; max-height:500px;overflow:scroll; padding: 0.5em; resize: both; }
  #GRID h3 { text-align: center; margin: 0; }
  </style>

  <style>
  .shadow {
  -moz-box-shadow:    3px 3px 5px 6px #ccc;
  -webkit-box-shadow: 3px 3px 5px 6px #ccc;
  box-shadow:         3px 3px 5px 6px #ccc;
   }
  </style>

<?php
# AJAX Tranceiver
echo $jsgear;

// $google_map_api_key = $portal_config['portalconfig']['google_map_api_key'];
 //echo "google_map_api_key = $google_map_api_key ";
// $google_map = "<script src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=".$google_map_api_key."\" type=\"text/javascript\"></script>";

// echo $google_map;

include ("css/style.php");

?>
  <style type="text/css">
        .css3button {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #050505;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#ebebeb 50%,
		#dbdbdb 50%,
		#b5b5b5);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#ffffff),
		color-stop(0.50, #ebebeb),
		color-stop(0.50, #dbdbdb),
		to(#b5b5b5));
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	border: 1px solid #949494;
	-moz-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	-webkit-box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	box-shadow:
		0px 1px 3px rgba(000,000,000,0.5),
		inset 0px 0px 2px rgba(255,255,255,1);
	text-shadow:
		0px -1px 0px rgba(000,000,000,0.2),
		0px 1px 0px rgba(255,255,255,1);
}
  </style>
       <style>
        .black_overlay{
            display: none;
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 80%;
            background-color: black;
            z-index:1001;
            -moz-opacity: 0.8;
            opacity:.80;
            filter: alpha(opacity=80);
            resize: both;
        }
        .light {
            display: none;
            position: absolute;
            top: 10%;
            left: 10%;
            width: 80%;
            height: 50%;
            padding: 5px;
            border: 5px solid orange;
            background-color: white;
            z-index:1002;
            overflow: auto;
            resize: both;
        }
        .lightfull {
            display: none;
            position: absolute;
            top: 0%;
            left: 0%;
            width: 90%;
            height: 70%;
            padding: 5px;
            border: 5px solid orange;
            background-color: white;
            z-index:1002;
            overflow: auto;
            resize: both;
        }
    </style>
  <script language="JavaScript">
<!--
function ThumbWindow(mypage, myname, w, h, scroll){
var winl = (screen.width - w) / 2;
var wint = (screen.height - h) / 2;
winprops = 'height='+h+',width='+w+',top='+wint+',left='+winl+',scrollbars='+scroll+',resizable'
win = window.open(mypage, myname, winprops)
if (parseInt(navigator.appVersion) >= 4) {win.window.focus();}
}
//-->
  </script>
        <script type="text/javascript">
            function confirmer(message){
              var user_choice = window.confirm(message);
              if(user_choice==true) {
                return true;
                } else {
                return false;
                }
            }
        </script>

  <script language="JavaScript">
  <!--
  (function () {
    var canvas = document.createElement('canvas'),
        ctx,
        img = document.createElement('img'),
        link = document.getElementById('favicon').cloneNode(true),
        day = (new Date).getDate() + '';

    if (canvas.getContext) {
      canvas.height = canvas.width = 16; // set the size
      ctx = canvas.getContext('2d');
      img.onload = function () { // once the image has loaded
        ctx.drawImage(this, 0, 0);
        ctx.font = 'bold 9px "helvetica", sans-serif';
        ctx.fillStyle = 'BLACK';
        if (day.length == 1) day = '0' + day;
        ctx.fillText(day, 2, 12);
        link.href = canvas.toDataURL('image/png');
        document.body.appendChild(link);
      };
      img.src = 'favicon.ico';
    }

    })();

  //-->
  </script>

  <script>

   function getXMLHTTP() { //fuction to return the xml http object
    var xmlhttp=false;	
    try{
	xmlhttp=new XMLHttpRequest();
	}
	catch(e)	{
		try{
			xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			try{
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(e1){
				xmlhttp=false;
			}
		}
	}
	 	
	return xmlhttp;
   }	

   function getjax(strURL,jaxdiv) {		
    var req = getXMLHTTP();
    if (req) {
       req.onreadystatechange = function() {
       	if (req.readyState == 4) {
	          if (req.status == 200) {						
		     document.getElementById(jaxdiv).innerHTML=req.responseText;
		     } else {
		     alert("There was a problem while using XMLHTTP:\n" + req.statusText);
		     }
	   }
        }
       req.open("GET", strURL, true);
       req.send(null);
       }
   }
  </script>

  <script type="text/javascript">
<!--

function init ( )
{
  timeDisplay = document.createTextNode ( "" );
  document.getElementById("clock").appendChild ( timeDisplay );
}

function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}

// -->
</script>

<style type="text/css">
#clock { font-family: Arial, Helvetica, sans-serif; font-size: 0.8em; color: white; background-color: black; border: 2px solid purple; padding: 4px; }
</style>

<style type="text/css">
.clockStyle {
	background-color:#000;
	border:#999 2px inset;
	padding:6px;
	color:#0FF;
	font-family:"Arial Black", Gadget, sans-serif;
        font-size:16px;
        font-weight:bold;
	letter-spacing: 2px;
	display:inline;
}
</style>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-content.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
  <link rel="stylesheet" href="css/vader/style.css">
  <script>
  $(function() {
    $( "#tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.panel.html('<img src="images/loading.gif" />');
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible.");
        });
      }
    });
  });

$(".moreContent").click(function( event ){
    event.preventDefault();
    loadContent( this.href );
});
function loadContent( url ) {
    var selected = $tabs.tabs('option', 'selected');
    $tabs.tabs("url", selected , url ).tabs("load", selected);
}

   function LoadData(ths, d){ 
            var baseUrlpath ='<?php echo $hostname; ?>';
             var url = baseUrlpath + $(ths).attr('href'); 
             console.log(url); 
             $( "#"+d ).load(url, function() {
                 console.log( "Load was performed." );
             });

             return false;
      }
  </script>
  <style type='text/css'>
    #tabs .ui-tabs-panel {
    max-height: 300px;
    overflow: auto;
   }
  </style>

  <script>
function replaceScriptsRecurse(node) {                                                      
        if ( nodeScriptIs(node) ) {                                                         
                var script  = document.createElement("script");                             
                script.text = node.innerHTML;                                               

                node.parentNode.replaceChild(script, node);                                 
        }                                                                                   
        else {                                                                              
                var i        = 0;                                                           
                var children = node.childNodes;                                             
                while ( i < children.length) {                                              
                        replaceScriptsRecurse( children[i] );                               
                        i++;                                                                
                }                                                                           
        }                                                                                   

        return node;                                                                        
}                                                                                           
function nodeScriptIs(node) {                                                               
        return node.getAttribute && node.getAttribute("type") == "text/javascript";         
} 
  </script>

    <script type="text/javascript" src="http://github.com/erikzaadi/jQueryPlugins/raw/master/jQuery.printElement/jquery.printElement.min.js">
    </script>

<script type="text/javascript">

    function PrintElem(elem,title)
    {
        Popup($(elem).html());

    /*$('#elem').printElement({pageTitle:title, printMode:'popup', overrideElementCSS: ['gantti/css/gantti.css']});*/

    }

    function Popup(data) 
    {
        var mywindow = window.open('',thistitle, 'height=400,width=600');
        mywindow.document.write('<html><head><title>'+thistitle+'</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>

<script>
    $(function(){
        $('a.pageFetcher').click(function(){
            $('#<?php echo $BodyDIV;?> ').load($(this).attr('href'));
        });
    });
</script>

 </head>
 <!-- removed pc_startup function -->
 <body onload="pc_startup();initialize();updateClock();setInterval('updateClock()', 1000 )" onunload="GUnload()">

<script type="text/javascript" language="javascript">
function renderTime() {
	var currentTime = new Date();
	var diem = "AM";
	var h = currentTime.getHours();
	var m = currentTime.getMinutes();
    var s = currentTime.getSeconds();
	setTimeout('renderTime()',1000);
    if (h == 0) {
		h = 12;
	} else if (h > 12) { 
		h = h - 12;
		diem="PM";
	}
	if (h < 10) {
		h = "0" + h;
	}
	if (m < 10) {
		m = "0" + m;
	}
	if (s < 10) {
		s = "0" + s;
	}
    var myClock = document.getElementById('clockDisplay');
	myClock.textContent = h + ":" + m + ":" + s + " " + diem;
	myClock.innerText = h + ":" + m + ":" + s + " " + diem;
}
renderTime();
</script>

  <script type="text/javascript">

    function GMAPLL(Lat,Lng) {
     
      var map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(Lat, Lng), 3);
 
      // Select a map type which supports obliques
      map.setMapType(G_HYBRID_MAP);
      map.setUIToDefault();
 
      // Enable the additional map types within
      //the map type collection
      map.enableRotation();
    }
 

    function autoRotate() {
      // Determine if we're showing aerial imagery
      if (map.isRotatable()) {
        setTimeout('map.changeHeading(90)', 3000);
        setTimeout('map.changeHeading(180)',6000);
        setTimeout('map.changeHeading(270)',9000);
        setTimeout('map.changeHeading(0)',12000);
      }
    }
 
 function changemapwidth(){

 e=document.getElementById("map_canvas");
 e.style.width = 500 + 'px';
 e.style.height = 300 + 'px';

 }
    </script>
    <script type="text/javascript"> 
    

    function initialize() {
        map = new GMap2(document.getElementById("map_canvas"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 13);
        geocoder = new GClientGeocoder();
    }
 
    </script>
    <script type="text/javascript">
    //<![CDATA[
    
    if (GBrowserIsCompatible()) { 

      var map = new GMap(document.getElementById("map_canvas"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(20,0),13);
      
      // ====== Create a Client Geocoder ======
      var geo = new GClientGeocoder(); 

      // ====== Array for decoding the failure codes ======
      var reasons=[];
      reasons[G_GEO_SUCCESS]            = "Success";
      reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
      reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
      reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
      reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
      reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
      reasons[G_GEO_SERVER_ERROR]       = "Server error: The geocoding request could not be successfully processed.";
      
      // ====== Geocoding ======
      function GMAPADD() {
        var search = document.getElementById("address").value;
   
        // ====== Perform the Geocoding ======        
        geo.getLocations(search, function (result)
          { 
            // If that was successful
            if (result.Status.code == G_GEO_SUCCESS) {
              // How many resuts were found
              document.getElementById("message").innerHTML = "Found " +result.Placemark.length +" results";
              // Loop through the results, placing markers
              for (var i=0; i<result.Placemark.length; i++) {
                var p = result.Placemark[i].Point.coordinates;
                var marker = new GMarker(new GLatLng(p[1],p[0]));
                document.getElementById("message").innerHTML += "<br>"+(i+1)+": "+ result.Placemark[i].address + marker.getPoint();
                map.addOverlay(marker);
              }
              // centre the map on the first result
              var p = result.Placemark[0].Point.coordinates;
              map.setCenter(new GLatLng(p[1],p[0]),14);
            }
            // ====== Decode the error status ======
            else {
              var reason="Code "+result.Status.code;
              if (reasons[result.Status.code]) {
                reason = reasons[result.Status.code]
              } 
              alert('Could not find "'+search+ '" ' + reason);
            }
          }
        );
      }
    }
    
    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    //]]>
    </script>
 
    <script>
    var width = $(window).width();
    $.ajax({
    url: "screensize.php",
    data : {screenwidth:width} 
    }).done(function() {
    $(this).addClass("done");
    });
    </script>

  <?php

  switch ($_SESSION['screenwidth']){

   case ($_SESSION['screenwidth']>1200):

    $screenwidth = 980;

   break;
   case ($_SESSION['screenwidth']<1200 && $_SESSION['screenwidth']>900):

    $screenwidth = $_SESSION['screenwidth']+10;

   break;
   case ($_SESSION['screenwidth']<900):

    $screenwidth = 980;

   break;

  }

    $screenwidth = 980;

  ################################
  # Start Body

  ?>
  <div style="width:<?php echo $screenwidth; ?>;margin-left: auto;margin-right: auto;">
   <div class="screenLayout">
    <div class="headerContainer">
     <div class="pageHeader">
      <div>
       <a href="<?php echo $baseurl; ?>" target="<?php echo $portal_title; ?>" title="<?php echo $portal_title; ?>" class="topLogo"><img src="<?php echo $portal_logo; ?>" name="logo" border="0" title="<?php echo $portal_title; ?>"></a><div id="topTxtBlock"><span id="topCopyright"><a href=<?php echo $portal_copyright_url; ?> target="_blank">&copy; <?php echo $portal_copyright_text; ?></a></span>
      </div>
     </div>
    </div>
   </div>
   <div class="center">
<?php 

 if ($access){

# New pages for Tabs

#$ticketing_sendvars = "Body@".$lingo."@Ticketing@gridlist@".$val."@".$valtype;
#$ticketing_sendvars = $funky_gear->encrypt($ticketing_sendvars);
$content_sendvars = "Body@".$lingo."@Content@list@".$val."@".$valtype;
$content_sendvars = $funky_gear->encrypt($content_sendvars);
$messages_sendvars = "Body@".$lingo."@Messages@list@".$val."@".$valtype;
$messages_sendvars = $funky_gear->encrypt($messages_sendvars);
$contacts_sendvars = "Body@".$lingo."@Contacts@list@".$val."@".$valtype;
$contacts_sendvars = $funky_gear->encrypt($contacts_sendvars);
$search_sendvars = "Body@".$lingo."@Search@ticketing@".$val."@".$valtype;
$search_sendvars = $funky_gear->encrypt($search_sendvars);

?>
   <div id="tabs">
     <ul>
       <li><a href="#hometab">Home</a></li>
       <li><a id="#content" title="content" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $content_sendvars; ?>">Content</a></li>
       <li><a id="#contacts" title="contacts" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $contacts_sendvars; ?>">Contacts</a></li>
       <li><a id="#messages" title="messages" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $messages_sendvars; ?>">Messages</a></li>
       <li><a id="#search" title="search" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $search_sendvars; ?>">Ticket Search</a></li>
     </ul>
   </div>
   <div id="hometab"><p>Welcome! These tabs will provide quick access to handy features.</p></div>

 <div id="GRID"></div>
 <div id="editor"></div>

<?php 

 } // end if access for special tabs

?>
    <div id="lightfull" class="lightfull"></div>
    <div id="light" class="light"></div>
    <?php echo $left_part; ?>
    <?php echo $body_part; ?>
    <?php echo $right_part; ?>
   </div>
  </div>
  <?php
  # End Body
  ################################
  ?>
  <script src="js/lightbox-2.6.min.js"></script>
  <div id="fade" class="black_overlay"></div>
 </body>
</html>
<?php
# End
####################################################################
?>