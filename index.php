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

$datetime = date("Y-m-d G:i:s");
$portalcode = $funky_gear->encrypt($datetime);

if (empty($_COOKIE['first_time'])) {

   # First check if top content is available
   if ($topgear_id != NULL){

      $topgear_sendvars = "Body@".$lingo."@Content@view@".$topgear_id."@Content";
      $topgear_sendvars = $funky_gear->encrypt($topgear_sendvars);
      $topgear = <<< TOPGEAR
      loader('lightpres');document.getElementById('lightpres').style.display='block';doBPOSTRequest('lightpres','tr.php', 'pc=$portalcode&sv=$topgear_sendvars');document.getElementById('fade').style.display='block';return false

TOPGEAR;
      } # is array

     setcookie("first_time", 1, time()+4320000);  /* expire in 50 days */

     } # if cookie

#echo "$do == NULL && $action == NULL && $val == NULL && $valtype == NULL";

#if ($do == NULL && $action == NULL && $val == NULL && $valtype == NULL){

##############################
# Mobile detection

$useragent=$_SERVER['HTTP_USER_AGENT'];
/*
if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){

   include ("Mobile.php");

   } else {
*/
   # Not mobile

if ($val == NULL){

   if ($sess_contact_id != NULL){
      $body_sendvars = "Body@".$lingo."@Contacts@edit@".$sess_contact_id."@Contacts";
      $body_sendvars = $funky_gear->encrypt($body_sendvars);
      } else {
      #$body_sendvars = "Body@".$lingo."@Content@view@".$portal_account_id."@Accounts";
      $body_sendvars = "Top@".$lingo."@Top@view@".$portal_account_id."@Accounts";
      $body_sendvars = $funky_gear->encrypt($body_sendvars);
      }

   $left_sendvars = "Left@".$lingo."@@".$portal_type."@@";
   $left_sendvars = $funky_gear->encrypt($left_sendvars);

   $right_sendvars = "Right@".$lingo."@@".$portal_type."@@";
   $right_sendvars = $funky_gear->encrypt($right_sendvars);

   } elseif ($do != NULL && $action != NULL && $val != NULL && $valtype != NULL){

   $body_sendvars = "Body@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
   $body_sendvars = $funky_gear->encrypt($body_sendvars);

   $left_sendvars = "Left@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
   $left_sendvars = $funky_gear->encrypt($left_sendvars);

   $right_sendvars = "Right@".$lingo."@".$do."@".$action."@".$val."@".$valtype;
   $right_sendvars = $funky_gear->encrypt($right_sendvars);

   $titler = $funky_gear->object_returner ($do, $val);
   $title = $titler[0];
   $portal_title = $portal_title.": ".$title;

   }

# Page structure - future to be customisable by portal owner

$leftcolumnwidth = "230px";
$rightcolumnwidth = "230px";
$bodycolumnwidth = "510px";

$body_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$bodycolumnwidth.";\" id=\"".$BodyDIV."\"></div>
<script type=\"text/javascript\">
 ajax_loadContent('$BodyDIV','tr.php?pc=$portalcode&sv=$body_sendvars');
</script>";

$left_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$leftcolumnwidth.";\" id=\"".$LeftDIV."\"></div>
<script type=\"text/javascript\">
 ajax_loadContent('$LeftDIV','tr.php?pc=$portalcode&sv=$left_sendvars');
</script>";

$right_part = "<div style=\"float:left;margin-top:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-left:0px;padding-right:0px;min-height:100px;width:".$rightcolumnwidth.";\" id=\"".$RightDIV."\"></div>
<script type=\"text/javascript\">
 ajax_loadContent('$RightDIV','tr.php?pc=$portalcode&sv=$right_sendvars');
</script>";

#$rightload = "tr.php?pc=".$portalcode."&sv=".$right_sendvars;

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

 function loadpage(thediv,thepage) {
     document.getElementById(thediv).innerHTML = thepage;
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

function getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
  
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
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

}

 //Scroller();
 
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

function createRequestObject() 
{
	var returnObj = false;
	
    if(window.XMLHttpRequest) {
        returnObj = new XMLHttpRequest();
    } else if(window.ActiveXObject) {
		try {
			returnObj = new ActiveXObject("Msxml2.XMLHTTP");

			} catch (e) {
			try {
			returnObj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {}
			}
			
    }
	return returnObj;
}

var http = createRequestObject();
var target;

// This is the function to call, give it the script file you want to run and
// the div you want it to output to.
function sendRequest(scriptFile, targetElement)
{	
	target = targetElement;
	try{
	http.open('get', scriptFile, true);
	}
	catch (e){
	document.getElementById(target).innerHTML = e;
	return;
	}
	http.onreadystatechange = handleResponse;
	http.send();	
}

function handleResponse()
{	
	if(http.readyState == 4) {		
	try{
		var strResponse = http.responseText;
		document.getElementById(target).innerHTML = strResponse;
		} catch (e){
		document.getElementById(target).innerHTML = e;
		}	
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

    document.getElementById(thisdivid).innerHTML = '<img src="images/loading.gif">';
    doBPOSTRequest(thisdivid,'tr.php','pg=$Body&'+getstr);

   }

function pc_startup (){

$topgear
//doBPOSTRequest('$BodyDIV','tr.php','pc=$portalcode&sv=$body_sendvars');
//doLPOSTRequest('$LeftDIV','tr.php','pc=$portalcode&sv=$left_sendvars');
//doRPOSTRequest('$RightDIV','tr.php','pc=$portalcode&sv=$right_sendvars');

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
<html xmlns="http://www.w3.org/1999/xhtml" itemscope itemtype="http://schema.org/Article">
 <head> 
  <title><?php echo $portal_title;?></title>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="google-site-verification" content="F8yDhS86LIY3eSdMBPztrEs5kfdzyxCgZufnf9Rlqpw" />
  <meta name="robots" content="ALL,index,follow">
  <meta name="keywords" content="<?php echo $portal_keywords; ?>">
  <meta name="description" content="<?php echo $portal_description; ?>">
  <meta name="revisit-after" content="3 Days">
  <meta name="rating" content="Safe For Kids">
  <meta name="author" content="Scalastica">
  <script type="text/javascript" src="css/<?php echo $portal_skin;?>/frame.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $portal_style; ?>">
  <script type="text/javascript" src="js/common.js"></script>
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
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/auto-complete.js"></script>
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

  <script>
    var width = $(window).width();
    $.ajax({
    url: "screensize.php",
    data : {screenwidth:width} 
    }).done(function() {
    $(this).addClass("done");
    });
  </script>

  <style type="text/css">
  .center{
   height:100%;
   width:980px;
   margin-left: auto;
   margin-right: auto;
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
            position: fixed;
            top: 0%;
            left: 0%;
            width: 100%;
            height:100%;
            background-color: black;
            z-index:1001;
            -moz-opacity: 0.8;
            opacity:.80;
            filter: alpha(opacity=80);
            resize: both;
        }
        .light {
            display: none;
            position: fixed;
            top: 10%;
            left: 10%;
            width: 80%;
            height: 50%;
            padding: 5px;
            border: 5px solid <?PHP echo $portal_header_colour;?>;
            border-radius:10px;
            background-color: white;
            z-index:1002;
            overflow: auto;
            resize: both;
        }
        .autoform {
            display: none;
            position: fixed;
            top: 10%;
            width: 500px;
            height: 300px;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 5px;
            border: 5px solid <?PHP echo $portal_header_colour;?>;
            border-radius:10px;
            background-color: white;
            z-index:1003;
            overflow: auto;
            resize: both;
        }
        .lightform {
            display: none;
            position: fixed;
            top: 10%;
            width: 600px;
            height: 70%;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 5px;
            border: 5px solid <?PHP echo $portal_header_colour;?>;
            border-radius:10px;
            background-color: white;
            z-index:1002;
            overflow: auto;
            resize: both;
        }
        .lightfull {
            display: none;
            position: absolute;
            top: 50px;
            width: 98%;
            height: 70%;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 5px;
            border: 5px solid <?PHP echo $portal_header_colour;?>;
            border-radius:10px;
            background-color: white;
            z-index:1002;
            overflow: auto;
            resize: both;
        }
        .lightpres {
            display: none;
            position: absolute;
            width: 450px;
            height: 400px;
            top:0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            padding: 5px;
            border: 5px solid <?PHP echo $portal_header_colour;?>;
            border-radius:10px;
            background-color: white;
            z-index:1002;
            overflow: none;
            resize: both;
        }
    </style>
  <script type="text/javascript">
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

  <script type="text/javascript">
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

<script type="text/javascript">
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
 
  <?php

    #$screenwidth = 980;
    #echo $screenwidth;
  ################################
  # Start Body
  /*
  <div style="width:<?php echo $screenwidth; ?>;margin-left: auto;margin-right: auto">
  </div>
  */
  ?>
 <div style="width:100%;height:55px;margin-left:0px;margin-right:0px;margin-bottom:5px;margin-top:0px;padding-bottom:5px;padding-left:0px;padding-right:0px;background:#000000;">
  <div style="width:980px;height:55px;margin-left: auto;margin-right: auto;padding-top:5px;padding-bottom:5px;margin-bottom:5px;">
   <div class="screenLayout">
    <div class="headerContainer">
     <div class="pageHeader">
      <div><a href="<?php echo $baseurl; ?>" target="<?php echo $portal_title; ?>" title="<?php echo $portal_title; ?>" class="topLogo"><img src="<?php echo $portal_logo; ?>" alt="<?php echo $portal_title; ?>" title="<?php echo $portal_title; ?>"></a><div id="topTxtBlock"><span id="topCopyright"><a href=<?php echo $portal_copyright_url; ?> target="_blank">&copy; <?php echo $portal_copyright_text; ?></a></span></div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <div style="width:980px;height:100%;margin-left: auto;margin-right: auto;">
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

    } # end if access for special tabs

    ?>
    <div id="lightfull" class="lightfull"></div>
    <div id="autoform" class="autoform"></div>
    <div id="lightform" class="lightform"></div>
    <div id="lightpres" class="lightpres"></div>
    <div id="light" class="light"></div>
    <?php echo $left_part; ?>
    <?php echo $body_part; ?>
    <?php echo $right_part; ?>
   </div>
  <?php
  # End Body
  ################################
  ?>
  <script src="js/lightbox-2.6.min.js"></script>
  <div id="fade" class="black_overlay"></div>
</body>
<?php
# End
####################################################################

  # } # end if not mobile

?>