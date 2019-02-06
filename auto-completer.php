<?PHP

header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

date_default_timezone_set('Asia/Tokyo');

if (!function_exists('get_param')){
   include ("common.php");
   }

?>
<!DOCTYPE html>
<html>
<head>
  <title>Auto-complete tutorial</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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

  <script src="js/auto-complete.js"></script>
  <script type="text/javascript">

 function cleardiv(thediv) {
     $("#thediv").hide('explode',1000);
     document.getElementById(thediv).innerHTML = '';
 }

</script>
</head>
<body>
<?PHP

    $wikipedia_sendvars = "Body@".$lingo."@Wikipedia@search@".$val."@".$valtype;
    $wikipedia_sendvars = $funky_gear->encrypt($wikipedia_sendvars);
    $gcal_sendvars = "Body@".$lingo."@Google@search@".$val."@".$valtype;
    $gcal_sendvars = $funky_gear->encrypt($gcal_sendvars);
    $fb_sendvars = "Body@".$lingo."@Facebook@search@".$val."@".$valtype;
    $fb_sendvars = $funky_gear->encrypt($fb_sendvars);

?>
   <div id="tabs">
     <ul>
       <li><a href="#hometab">Home</a></li>
       <li><a id="#wikipedia" title="wikipedia" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $wikipedia_sendvars; ?>">Wikipedia</a></li>
       <li><a id="#gcal" title="gcal" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $gcal_sendvars; ?>">Google Calendar</a></li>
       <li><a id="#fb" title="fb" href="tr.php?pc=<?php echo $portalcode; ?>&sv=<?php echo $fb_sendvars; ?>">Facebook Event</a></li>
     </ul>
   </div>
   <div id="hometab"><p><font size=2>Please select your desired source for new content.</p>
* Events in Shared Effects can be based on any event in time - public or private
<BR>* First, do a search in Shared Effects to see if the event exists already
<BR>* Much of the public event content has been derived from Wikipedia and other online sources
<BR>* You can make private events (and sub-events) based on any public event
</font>
  </div>
 </body>
</html>
<?PHP

?>