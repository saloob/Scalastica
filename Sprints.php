<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2016-12-24
# Page: Sprints.php 
/**
* File/Directory Sprints.php
*
* PHP versions 4 and 5
*
* @category   Productivity
* @package    Sprints
* @author     Matthew Edmond <matt@saloob.com>
* @copyright  2013+ The Authors
* @license    Saloob
* @version    CVS: $Id: Sprints.php 313024 2011-07-06 19:51:24Z dufuz $
* @link       http://www.scalastica.com/Sprints.php
* @since      File available since Release 0.1
*/
##########################################################
# case 'Sprints':
?>
<!doctype html>
<html lang="en">
<head>
 
<style>
#makeMeDraggable { float: left; width: 300px; height: 300px; background: red; }
#makeMeDroppable { float: right; width: 300px; height: 300px; border: 1px solid #999; }
</style>
 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
 
<script type="text/javascript">
 
$( init );
 
function init() {
  $('#makeMeDraggable').draggable();
  $('#makeMeDroppable').droppable( {
    drop: handleDropEvent
  } );
}
 
function handleDropEvent( event, ui ) {
  var draggable = ui.draggable;
  alert( 'The square with ID "' + draggable.attr('id') + '" was dropped onto me!' );
}
 
</script>
 
</head>
<body>
 
<div id="content" style="height: 400px;">
 
  <div id="makeMeDraggable"> </div>
  <div id="makeMeDroppable"> </div>
 
</div>
 
</body>
</html>
<?
# break; # End Sprints
##########################################################
?>