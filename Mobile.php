<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-05-23
# Page: Mobile.php 
##########################################################
# Included from index.php - includes common.php 

if (!function_exists('dlookup')){
   include ("common-new.php");
   }

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

 function loadpage(thediv,thepage) {
     document.getElementById(thediv).innerHTML = thepage;
 }

 function loader(thediv) {
     document.getElementById(thediv).innerHTML = '<img src="images/loading.gif">';
 }

 function Scroller(x,y) {

     if (x == "" || y == "") {
        window.scrollTo(0,0);
        } else {
        window.scrollTo(x,y);
        } 
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

</script>

<style>
form { display: block; margin: 20px auto; background: #eee; border-radius: 10px; padding: 15px }
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
  <script type="text/javascript">
   SyntaxHighlighter.all({toolbar:false});
  </script>

<?php
# AJAX Tranceiver
echo $jsgear;
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
        .lightform {
            display: none;
            position: fixed;
            top: 10%;
            left: 28%;
            width: 600px;
            height: 70%;
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
            left: 0%;
            width: 98%;
            height: 70%;
            padding: 5px;
            border: 5px solid <?PHP echo $portal_header_colour;?>;
            border-radius:10px;
            background-color: white;
            z-index:1002;
            overflow: auto;
            resize: both;
        }
    </style>

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
</head>
<body>

<?PHP

  ################################
  # Start Body

    #$ticketing_sendvars = "Body@".$lingo."@Ticketing@gridlist@".$val."@".$valtype;
    #$ticketing_sendvars = $funky_gear->encrypt($ticketing_sendvars);
    $events_sendvars = "Body_Mobile@".$lingo."@Events@list@".$val."@".$valtype;
    $events_sendvars = $funky_gear->encrypt($events_sendvars);
    $content_sendvars = "Body_Mobile@".$lingo."@Content@list@".$val."@".$valtype;
    $content_sendvars = $funky_gear->encrypt($content_sendvars);
    $messages_sendvars = "Body_Mobile@".$lingo."@Messages@list@".$val."@".$valtype;
    $messages_sendvars = $funky_gear->encrypt($messages_sendvars);
    $contacts_sendvars = "Body_Mobile@".$lingo."@Contacts@list@".$val."@".$valtype;
    $contacts_sendvars = $funky_gear->encrypt($contacts_sendvars);
    $search_sendvars = "Body_Mobile@".$lingo."@Search@ticketing@".$val."@".$valtype;
    $search_sendvars = $funky_gear->encrypt($search_sendvars);

  ?>
 <div style="width:100%;height:55px;margin-left:0px;margin-right:0px;margin-bottom:5px;margin-top:0px;padding-bottom:5px;padding-left:0px;padding-right:0px;background:#000000;">
  <div style="width:98%;height:55px;margin-left: auto;margin-right: auto;padding-top:5px;padding-bottom:5px;margin-bottom:5px;">
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
 <div style="width:98%;height:100%;margin-left: auto;margin-right: auto;">
   <div id="tabs">
     <ul>
       <li><a href="#hometab">Home</a></li>
       <li><a id="#events" title="events" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $events_sendvars; ?>">Events</a></li>
       <li><a id="#content" title="content" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $content_sendvars; ?>">Content</a></li>
       <li><a id="#contacts" title="contacts" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $contacts_sendvars; ?>">Contacts</a></li>
       <li><a id="#messages" title="messages" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $messages_sendvars; ?>">Messages</a></li>
       <li><a id="#search" title="search" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $search_sendvars; ?>">Ticket Search</a></li>
     </ul>
   </div>
   <div id="hometab"><p>Welcome! These tabs will provide quick access to handy features.</p></div>
   <div id="GRID"></div>
   <div id="editor"></div>
    <div id="lightfull" class="lightfull"></div>
    <div id="lightform" class="lightform"></div>
    <div id="light" class="light"></div>
   </div>
<?php 

  # End Body
  ################################
  ?>
  <script src="js/lightbox-2.6.min.js"></script>
  <div id="fade" class="black_overlay"></div>
</body>
</html>
<?PHP
##########################################################
?>