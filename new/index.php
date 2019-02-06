<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-06-14
# Page: Index 
############################################## 
# Start Includes


?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Scalastica</title>
<link rel="stylesheet" href="jquery-ui-1.10.4/css/smoothness/jquery-ui.css">
<link rel="stylesheet" href="jquery-ui-1.10.4/css/smoothness/jquery-ui-1.10.4.min.css">
<script src="jquery-ui-1.10.4/js/jquery-1.10.2.js"></script>
<script src="jquery-ui-1.10.4/js/jquery-ui-1.10.4.js"></script>
<link rel="stylesheet" href="jquery-ui-1.10.4/css/style.css">
<script>
$(function() {
$( "#tabs" ).tabs({
beforeLoad: function( event, ui ) {
ui.jqXHR.error(function() {
ui.panel.html(
"Couldn't load this tab. We'll try to fix this as soon as possible. " +
"If this wouldn't be a demo." );
});
}
});
});
</script>
</head>
<body>
<div id="tabs">
<ul>
<li><a href="#tabs-1">Preloaded</a></li>
<li><a href="../Body.php?">Tab 1</a></li>
<li><a href="../Body.php?">Tab 2</a></li>
<li><a href="../Body.php?">Tab 3 (slow)</a></li>
<li><a href="../Body.php?">Tab 4 (broken)</a></li>
</ul>
<div id="tabs-1">
<p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
</div>
</div>
</body>
</html>
<?php
# End
####################################################################
?>