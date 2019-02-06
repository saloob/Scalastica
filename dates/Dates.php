<?PHP
#################################
# Date function for holidays

switch ($this_country){

 case 'JPN':
 case 'JP':

  if (!class_exists('Date_Holidays_Driver_Japan')){
     include ("Japan.php");
     }
  $holdays = new Date_Holidays_Driver_Japan();
  $now_holidays = $holdays->_buildHolidays();

 break;
 case 'AUS':
 case 'AU':

  if (!class_exists('Date_Holidays_Driver_Australia')){
     include ("Australia.php");
     }
  $holdays = new Date_Holidays_Driver_Australia();
  $now_holidays = $holdays->_buildHolidays();

 break;

}

# End Date function
#################################
?>