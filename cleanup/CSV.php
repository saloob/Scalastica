<?PHP

###

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

include ("common.php");

   $module = $_POST['module'];
   if (!$module){
      $module = $_GET['module'];
      }

   $has_header = $_POST['has_header'];
   if (!$has_header){
      $has_header = $_GET['has_header'];
      }

  switch ($action){
   
   case 'csv_get':

    $size_limit = "yes"; //do you want a size limit yes or no.
    $limit_size = 100000; //How big do you want size limit to be in bytes
    $limit_ext = "yes";
    $ext_count = "1"; //total number of extensions in array below
    $extensions = array(".csv"); //List extensions you want files uploaded to be

    /*
    $allowedExtensions = array("txt","csv","htm","html","xml",
    "css","doc","xls","rtf","ppt","pdf","swf","flv","avi",
    "wmv","mov","jpg","jpeg","gif","png"); 
    */

    ?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
  <td bgcolor="#5E6A7B" height="25">
   <p align="center"><font size="2"><b>Upload Approach CSV</b></font></td>
  </tr>
  <tr>
   <td bgcolor="#818EA0"><font size="2">The following restrictions apply:</font><ul type="square">
    <li><font size="2">File extension must be <b>

    <?PHP

    if (($extensions == "") or ($extensions == " ") or ($ext_count == "0") or ($ext_count == "") or ($limit_ext != "yes") or ($limit_ext == "")) {

       # Any file echo "any extension";

       } else {

       $ext_count2 = $ext_count+1;

       for ($counter=0; $counter<$ext_count; $counter++) {

           echo "&nbsp; $extensions[$counter]";

           } # for

       } #else

    if (($limit_size == "") or ($size_limit != "yes")) {
       $limit_size = "any size";
       } else {
       $limit_size .= " bytes";
       }

    #$action
    $dd_pack["ConfurationItems"] = "ConfurationItems";
    $current_value = $module;
    $label = "module";
    $object = "CSV";
    $dropdowner = $funky_gear->dropdown ($action, $dd_pack, $current_value, $label, $object);
    ?>

     </b></font></li>
        <li><font size="2">You MUST save the file as UTF-8 before importing</font></li>
        <li><font size="2">Maximum file size is <?PHP echo $limit_size; ?></font></li>
        <li><font size="2">No spaces in the filename</font></li>
        <li><font size="2">Filename cannot contain illegal characters and MUST be in ENGLISH (/,*,,etc)</font><BR></li>
        <li><font size="2">This Application will add the content from your Approach Files</font></li>
      </ul>
  </td>
 </tr>
</table>

<form method="POST" action="CSV.php" enctype="multipart/form-data">
<INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="<?PHP echo $limit_size;?>">
<?PHP echo $dropdowner; ?><BR>
<INPUT TYPE="hidden" name="do"  id="do" VALUE="CSV">
<INPUT TYPE="checkbox" name="has_header" value="<?PHP echo $has_header; ?>">File has a header row<BR>
<INPUT TYPE="hidden" name="action" id="action" VALUE="csv_get">
<INPUT TYPE="hidden" name="upload" id="upload" value="true">
<INPUT TYPE="file" name="csvfile" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1"><BR>
<button name="submit" type="submit" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">Upload CSV</button>
</form>

    <?PHP

    $allowedExtensions = array("csv"); 

    foreach ($_FILES as $file) {
            if ($file['tmp_name'] > '') {
               if (!in_array(end(explode(".",strtolower($file['name']))),$allowedExtensions)) {
                  die($file['name'].' is an invalid file type!<br/><a href="javascript:history.go(-1);">&lt;&lt Go Back</a>');
                  }
              }
            } 

@$ftmp = $_FILES['csvfile']['tmp_name'];
@$oname = $_FILES['csvfile']['name'];
@$fname = $_FILES['csvfile']['name'];
@$fsize = $_FILES['csvfile']['size'];
@$ftype = $_FILES['csvfile']['type'];

####################
#

if (ISSET($ftmp)){

   $ext = strrchr($fname,'.');

   if ($module){
      echo "<B>Selected Module: ".$module."</B><P>";
      }

   if ($ext == '.csv'){

      echo "<B>".$fname." is a .csv file </B><P>";

      $row = 0;

      $length = 10000000;
      $array = file($ftmp);
      for ($i=0;$i<count($array);$i++){
          if ($length < strlen($array[$i])){
             $length = strlen($array[$i]);
             }
          }

      unset($array);

      #echo "PHP_INT_MAX:".PHP_INT_MAX."<P>";
      #echo "LENGTH: ".$length."<P>";
      #$data = longTail($ftmp, $numLines = 100)

      # Preparing for Windows/Mac: http://stackoverflow.com/questions/4348802/how-can-i-output-a-utf-8-csv-in-php-that-excel-will-read-properly

      ini_set('auto_detect_line_endings',TRUE);

      $fp = fopen ($ftmp,'r');

      while (($data = fgetcsv($fp,$length, ",")) !== FALSE) {

            #$data = array_map("utf8_encode", $data); //added
            #$content_encode = mb_detect_encoding($data);
            #echo "Encode: ".$content_encode."<P>";
            #$data = mb_convert_encoding($data, 'UTF-8', $content_encode);

            $num = count ($data);

            switch ($module){

             case 'ConfurationItems':

              $expected_field_count = 10;
              # $num = number of fields
              if ($num != $expected_field_count){
                 $error = "Cannot proceed - field count is incorrect..<P>";
                 }

             break;

            } # switch

            $row++;

            $package_fields = "";

            for ($c=0; $c<$num; $c++) {

                if (!$data[$c]){
                   $data[$c] = "NULL";
                   } else {

                   } 

                if ($row == 1 && $has_header==1){
                   $header = str_replace('"',"",$data[$c]);
                   #$header = mb_convert_encoding($header, "UTF-8", $content_encode);
                   #$header = iconv($content_encode, "UTF-8", $header);
                   $package_fields .="<td bgcolor=\"#5E6A7B\" height=\"25\"><font size=2><B>".$header."</B></font></td>";
                   } else {
                   $fieldval = str_replace('"',"",$data[$c]);
                   #$fieldval = mb_convert_encoding($fieldval, "UTF-8", $content_encode);
                   #$fieldval = iconv($content_encode, "UTF-8", $fieldval);
                   $package_fields .="<td bgcolor=\"WHITE\" height=\"15\"><font size=1>".$fieldval."</font></td>";
                   }

                } # for

                $package .= "<tr>".$package_fields."</tr>";

            } # end while

      fclose ($fp);

      } else { # end if .csv

        echo "NOT CSV!";

      } # ext

      echo $error;
      echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\">".$package."</table>";

   } // isset

 break;

 } # switch

?>