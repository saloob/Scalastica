<?php

session_start();

if ($_REQUEST['screenwidth']){
   $screenwidth = $_REQUEST['screenwidth'];
   $_SESSION['screenwidth'] = $screenwidth;
   } else {
   if (!$_SESSION['screenwidth']){
      $screenwidth = '1200';
      $_SESSION['screenwidth'] = $screenwidth;
      } else {
      $screenwidth = $_SESSION['screenwidth'];
      }
   }

echo $screenwidth;

?>