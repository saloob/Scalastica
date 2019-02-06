<?PHP

###

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

include ("common.php");

   $cit = $_POST['cit'];
   if (!$cit){
      $cit = $_GET['cit'];
      }

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
 case 'manage':

  echo "<P>Selected CIT: ".$cit."<P>";
  $items = $_POST['items'];

?>
<form method="POST" action="CSV.php">
<INPUT TYPE="hidden" name="do"  id="do" VALUE="CSV">
<INPUT TYPE="hidden" name="action" id="action" VALUE="manage">
<INPUT TYPE="hidden" name="cit" id="cit" value="<?php echo $cit; ?>">
<textarea name="items" id="items" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;" cols="70" rows="20"><?php echo $items; ?></textarea><BR>
<button name="submit" type="submit" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">Load Items</button>
</form>

<?php

 # Collect Items

 $items = $_POST['items'];
 $data_rows = explode("\n", $items);
 $data_columns = explode("\t", $items);
 #echo $items_array[0]."<P>";
 #echo $items_array[1];
 /*
 for ($i=0;$i<count($items_array);$i++){
     if ($length < strlen($array[$i])){
        $length = strlen($array[$i]);
        }
     }
 */

 #unset($array);
 ini_set('auto_detect_line_endings',TRUE);

 echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\">";

 $data = rtrim($items, "\n");
 $data = explode("\n", $data);

 $rows = count($data);

 echo "rows $rows<BR>";

 $level0['cb0ce2a0-56d8-f6ea-cf06-552a8cf7d6af'] = "Animals & Pet Supplies";
 $level0['54d387e0-38b3-1d24-91d7-552a8c5f6054'] = "Apparel & Accessories";
 $level0['a9c726d0-c6c4-4158-61c1-552a8c0bc819'] = "Arts & Entertainment";
 $level0['9390069b-8028-b5ab-4477-552a8c3b4dad'] = "Baby & Toddler";
 $level0['56f79f4d-97cd-362f-4004-552a8cb7b40f'] = "Business & Industrial";
 $level0['b20355e0-1078-dbf4-5c43-552a8c5a21f7'] = "Cameras & Optics";
 $level0['1a11f95a-6c58-78a9-dad5-552a8c76c06c'] = "Electronics";
 $level0['7938ba3b-6120-e3f2-ab38-552a8cda13f2'] = "Food, Beverages & Tobacco";
 $level0['c584151d-7575-fa07-0297-552a8cc24949'] = "Furniture";
 $level0['a18ffcfa-459c-c2f5-edd1-552a8cbe091a'] = "Hardware";
 $level0['3c986d86-8a41-edf4-1155-552a8c1a3de7'] = "Health & Beauty";
 $level0['8d4b9f74-7033-c1d7-059a-552a8cc15d88'] = "Home & Garden";
 $level0['d3b6b025-a93f-f7dc-24dc-552a8ca23c75'] = "Luggage & Bags";
 $level0['2f3f17a4-0e1a-11b0-4eb7-552a8c8af8c4'] = "Mature";
 $level0['7ce28986-c4d8-3420-f40d-552a8cb6f0f1'] = "Media";
 $level0['c6443086-1dc8-5ccb-3282-552a8c25292c'] = "Office Supplies";
 $level0['4440a347-3e19-c5c7-b97c-552a8c5102d0'] = "Religious & Ceremonial";
 $level0['7e2fe3df-b40d-75bf-d24f-51d184c49e5c'] = "Software";
 $level0['e3aec6f6-c6fc-a4cd-f066-552a8c138e68'] = "Sporting Goods";
 $level0['3b734b47-a814-f625-8144-552a8cf4bf78'] = "Toys & Games";
 $level0['8d02f3b8-c0a1-bb8e-6300-552a8c4d1936'] = "Vehicles & Parts";

 foreach ($data as $rowcount => $row){

         #echo "$string<br><br>";
         $package_rows = "";

         $column_count = "";

         #$columns = array_filter($columns);

         $package_fields = "";

         $row = rtrim($row);
         $cols = preg_split('/\t+/', $row,-1,PREG_SPLIT_NO_EMPTY);
         $column_count = count($cols);

         #echo "column_count $column_count<BR>";
         $count = "";
         foreach (array_filter($cols) as $count => $item){

                  if ($count == 0){
                     $parci = array_search($item,$level0);
                     if ($parci){
                        # Do nothing - is in level0
                        # && !in_array($item,$level0)){
                     # New Level 0
                        echo "level 0 exists $parci<BR>";
                        } else {

                        echo "new level 0 $item<BR>";
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$cit."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level0[$ci_id] = $item;

                        }

                     $parci = "";
                     $itemer0[$rowcount] = $item;

                     } elseif ($count == 1){

                     if ($item == 'Office Instruments'){
                        $parci = '7b4645e1-85f8-df81-4449-552b689f27fd';
                        if (!in_array($item,$level1)){
                           echo "$item not in array<P>";
                           $level1[$parci] = $item;
                           } else {
                           echo "$item is in array<P>";
                           }
                        } else {
                        $parci = array_search($item,$level1);
                        } 

                     if ($parci){
                        echo "level 1 exists $parci<BR>";
                        } else {
                        # New Level 1
                        echo "new level 1 $item for last 0 $itemer0[$rowcount] <BR>";
                        $parci = array_search($itemer0[$rowcount],$level0);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level1[$ci_id] = $item;
                        #$level1["NEWL-1-ID"] = $item;
                        }

                     $parci = "";
                     $itemer1[$rowcount] = $item;

                     } elseif ($count == 2){

                     if ($item == 'Writing & Drawing Instruments'){
                        $parci = '697b9a4f-93db-64f4-d623-552b68d03e1e';
                        if (!in_array($item,$level2)){
                           echo "$item not in array<P>";
                           $level2[$parci] = $item;
                           } else {
                           echo "$item is in array<P>";
                           }
                        } else {
                        $parci = array_search($item,$level2);
                        } 

                     if ($parci){
                        echo "level 2 exists $parci<BR>";
                        } else {
                         # New Level 2
                        echo "new level 2 $item for $itemer1[$rowcount] <BR>";
                        $parci = array_search($itemer1[$rowcount],$level1);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level2[$ci_id] = $item;
                        #$level1["NEWL-1-ID"] = $item;
                        }

                     $parci = "";
                     $itemer2[$rowcount] = $item;

                     } elseif ($count == 3){
                     # New Level 3

                     if ($item == 'Pens & Pencils'){
                        $parci = '1da96f59-67e1-ade6-cd68-552b688ffc4f';
                        if (!in_array($item,$level3)){
                           echo "$item not in array<P>";
                           $level3[$parci] = $item;
                           } else {
                           echo "$item is in array<P>";
                           }
                        } else {
                        $parci = array_search($item,$level3);
                        } 

                     if ($parci){
                        echo "level 3 exists $parci<BR>";
                        } else {
                        # New Level 3
                        echo "new level 3 $item for $itemer2[$rowcount] <BR>";
                        $parci = array_search($itemer2[$rowcount],$level2);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level3[$ci_id] = $item;
                        #$level1["NEWL-1-ID"] = $item;
                        }

                     $parci = "";
                     $itemer3[$rowcount] = $item;

                     } elseif ($count == 4){
                     # New Level 4

                     $parci = array_search($item,$level4);

                     if ($parci){
                         echo "level 4 exists $parci<BR>";
                        } else {
                        # New Level 1
                        echo "new level 4 $item for $itemer3[$rowcount] <BR>";
                        $parci = array_search($itemer3[$rowcount],$level3);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level4[$ci_id] = $item;

                        }

                     $parci = "";
                     $itemer4[$rowcount] = $item;

                     } elseif ($count == 5){
                     # New Level 2
                     $parci = array_search($item,$level5);

                     if ($parci){
                         echo "level 5 exists $parci<BR>";
                        } else {
                        # New Level 5
                        echo "new level 5 $item for $itemer4[$rowcount] <BR>";
                        $parci = array_search($itemer4[$rowcount],$level4);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level5[$ci_id] = $item;

                        }

                     $parci = "";
                     $itemer5[$rowcount] = $item;

                     } elseif ($count == 6){
                     # New Level 2
                     $parci = array_search($item,$level6);

                     if ($parci){
                         echo "level 6 exists $parci<BR>";
                        } else {
                        # New Level 6
                        echo "new level 6 $item for $itemer5[$rowcount] <BR>";
                        $parci = array_search($itemer5[$rowcount],$level5);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level6[$ci_id] = $item;

                        }

                     $parci = "";
                     $itemer6[$rowcount] = $item;

                     } elseif ($count == 7){
                     # New Level 2
                     $parci = array_search($item,$level7);

                     if ($parci){
                         echo "level 7 exists $parci<BR>";
                        } else {
                        # New Level 7
                        echo "new level 7 $item for $itemer6[$rowcount] <BR>";
                        $parci = array_search($itemer6[$rowcount],$level6);
                        $sql .= "INSERT INTO `sclm_configurationitemtypes` SET (sclm_configurationitemtypes_id_c,sclm_configurationitems_id_c,name,description) = VALUES ('1dea7f68-6f6a-662f-fb43-54f829549bd9','".$parci."','".$item."','".$item."')<BR>";

                        $process_object_type = "ConfigurationItems";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'account_id_c','value' => 'de8891b2-4407-b4c4-f153-51cb64bac59e');
                        $process_params[] = array('name'=>'contact_id_c','value' => 'a7e555f8-2ad4-1694-2489-51cb651d38dc');
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '1dea7f68-6f6a-662f-fb43-54f829549bd9');
                        $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $parci);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'enabled','value' => 1);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level7[$ci_id] = $item;

                        }

                     $parci = "";
                     $itemer7[$rowcount] = $item;

                     } 

                  $package_fields .="<td bgcolor=\"#5E6A7B\" height=\"25\"><font size=2><B>[".$count."] ".$item."</B></font></td>";

                 } # columns

         $package_rows = "<tr>".$package_fields."</tr>";
         echo $package_rows;
         } # rows

 echo "</table>";

 echo "<P>SQL<P>".$sql."<BR>";

 break;
 case 'sports':

  $sports_cit = "5f3e23c2-1e1d-0afb-13ad-5521d4dcb65e";

  $items = $_POST['items'];

?>
<form method="POST" action="CSV.php">
<INPUT TYPE="hidden" name="do"  id="do" VALUE="CSV">
<INPUT TYPE="hidden" name="action" id="action" VALUE="sports">
<INPUT TYPE="hidden" name="cit" id="cit" value="<?php echo $cit; ?>">
<textarea name="items" id="items" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;" cols="70" rows="20"><?php echo $items; ?></textarea><BR>
<button name="submit" type="submit" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">Load Items</button>
</form>

<?php

 # Collect Items

 $items = $_POST['items'];
 $data_rows = explode("\n", $items);
 $data_columns = explode("\t", $items);

 ini_set('auto_detect_line_endings',TRUE);

 echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\">";

 $data = rtrim($items, "\n");
 $data = explode("\n", $data);

 $rows = count($data);

 echo "rows $rows<BR>";

 foreach ($data as $rowcount => $row){

         $package_rows = "";
         $column_count = "";
         $package_fields = "";

         $row = rtrim($row);
         $cols = preg_split('/\t+/', $row,-1,PREG_SPLIT_NO_EMPTY);
         $column_count = count($cols);

         $count = "";
         foreach (array_filter($cols) as $count => $item){

                  if ($count == 0){

                     $parci = array_search($item,$level0);

                     if ($parci){
                        echo "level 0 exists $parci<BR>";
                        } else {
                        echo "new level 0 $item<BR>";

                        $process_object_type = "ConfigurationItemTypes";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'name_en','value' => $item);
                        $process_params[] = array('name'=>'name_ja','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'description_en','value' => $item);
                        $process_params[] = array('name'=>'description_ja','value' => $item);
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $sports_cit);
                        #$process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
                        #$process_params[] = array('name'=>'external_data_id','value' => $occ_code);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];

                        $level0[$ci_id] = $item;
                        #$level0[$item] = $item;

                        }

                     $parci = "";
                     $itemer0[$rowcount] = $item;

                     } elseif ($count == 1){

                     $parci = array_search($item,$level1);

                     if ($parci){
                        echo "level 1 exists $parci<BR>";
                        } else {
                        # New Level 1
                        echo "new level 1 $item for last 0 $itemer0[$rowcount] <BR>";
                        $parci = array_search($itemer0[$rowcount],$level0);

                        $process_object_type = "ConfigurationItemTypes";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'name_en','value' => $item);
                        $process_params[] = array('name'=>'name_ja','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'description_en','value' => $item);
                        $process_params[] = array('name'=>'description_ja','value' => $item);
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $parci);
                        #$process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
                        #$process_params[] = array('name'=>'external_data_id','value' => $occ_code);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];
                        $level1[$ci_id] = $item;
                        #$level1[$item] = $item;

                        }

                     $parci = "";
                     $itemer1[$rowcount] = $item;

                     } elseif ($count == 2){

                     $parci = array_search($item,$level2);

                     if ($parci){
                        echo "level 2 exists $parci<BR>";
                        } else {
                         # New Level 2
                        echo "new level 2 $item for $itemer1[$rowcount] <BR>";
                        $parci = array_search($itemer1[$rowcount],$level1);

                        $process_object_type = "ConfigurationItemTypes";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'name_en','value' => $item);
                        $process_params[] = array('name'=>'name_ja','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'description_en','value' => $item);
                        $process_params[] = array('name'=>'description_ja','value' => $item);
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $parci);
                        #$process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
                        #$process_params[] = array('name'=>'external_data_id','value' => $occ_code);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];
                        $level2[$ci_id] = $item;
                        #$level2[$item] = $item;

                        }

                     $parci = "";
                     $itemer2[$rowcount] = $item;

                     } elseif ($count == 3){
                     # New Level 3

                     $parci = array_search($item,$level3);

                     if ($parci){
                        echo "level 3 exists $parci<BR>";
                        } else {
                        # New Level 3
                        echo "new level 3 $item for $itemer2[$rowcount] <BR>";
                        $parci = array_search($itemer2[$rowcount],$level2);

                        $process_object_type = "ConfigurationItemTypes";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'name_en','value' => $item);
                        $process_params[] = array('name'=>'name_ja','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'description_en','value' => $item);
                        $process_params[] = array('name'=>'description_ja','value' => $item);
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $parci);
                        #$process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
                        #$process_params[] = array('name'=>'external_data_id','value' => $occ_code);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];
                        $level3[$ci_id] = $item;
                        #$level3[$item] = $item;

                        }

                     $parci = "";
                     $itemer3[$rowcount] = $item;

                     } elseif ($count == 4){
                     # New Level 4

                     $parci = array_search($item,$level4);

                     if ($parci){
                         echo "level 4 exists $parci<BR>";
                        } else {
                        # New Level 1
                        echo "new level 4 $item for $itemer3[$rowcount] <BR>";
                        $parci = array_search($itemer3[$rowcount],$level3);

                        $process_object_type = "ConfigurationItemTypes";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'name_en','value' => $item);
                        $process_params[] = array('name'=>'name_ja','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'description_en','value' => $item);
                        $process_params[] = array('name'=>'description_ja','value' => $item);
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $parci);
                        #$process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
                        #$process_params[] = array('name'=>'external_data_id','value' => $occ_code);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];
                        $level4[$ci_id] = $item;
                        #$level4[$item] = $item;

                        }

                     $parci = "";
                     $itemer4[$rowcount] = $item;

                     } elseif ($count == 5){
                     # New Level 2
                     $parci = array_search($item,$level5);

                     if ($parci){
                         echo "level 5 exists $parci<BR>";
                        } else {
                        # New Level 5
                        echo "new level 5 $item for $itemer4[$rowcount] <BR>";

                        $parci = array_search($itemer4[$rowcount],$level4);

                        $process_object_type = "ConfigurationItemTypes";
                        $process_action = "update";

                        $process_params = array();  
                        $process_params[] = array('name'=>'name','value' => $item);
                        $process_params[] = array('name'=>'name_en','value' => $item);
                        $process_params[] = array('name'=>'name_ja','value' => $item);
                        $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                        $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
                        $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
                        $process_params[] = array('name'=>'description','value' => $item);
                        $process_params[] = array('name'=>'description_en','value' => $item);
                        $process_params[] = array('name'=>'description_ja','value' => $item);
                        $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $parci);
                        #$process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
                        #$process_params[] = array('name'=>'external_data_id','value' => $occ_code);

                        $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                        $ci_id = $result['id'];
                        $level5[$ci_id] = $item;
                        #$level5[$item] = $item;

                        }

                     $parci = "";
                     $itemer5[$rowcount] = $item;

                     } # else

                  $package_fields .="<td bgcolor=\"#5E6A7B\" height=\"25\"><font size=2><B>[".$count."] ".$item."</B></font></td>";

                 } # columns

         $package_rows = "<tr>".$package_fields."</tr>";
         echo $package_rows;
         } # rows

 echo "</table>";

 break;
 case 'jobs':

  $jobs_cit = "8a367b62-6c44-aa2c-25b6-5521e7524292";

  $items = $_POST['items'];

?>
<form method="POST" action="CSV.php">
<INPUT TYPE="hidden" name="do"  id="do" VALUE="CSV">
<INPUT TYPE="hidden" name="action" id="action" VALUE="jobs">
<INPUT TYPE="hidden" name="cit" id="cit" value="<?php echo $cit; ?>">
<textarea name="items" id="items" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;" cols="70" rows="20"><?php echo $items; ?></textarea><BR>
<button name="submit" type="submit" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1">Load Items</button>
</form>

<?php

 # Collect Items

 $items = $_POST['items'];
 $data_rows = explode("\n", $items);
 $data_columns = explode("\t", $items);

 ini_set('auto_detect_line_endings',TRUE);

 echo "<table border=\"1\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\">";

 $data = rtrim($items, "\n");
 $data = explode("\n", $data);

 $rows = count($data);

 echo "rows $rows<BR>";

 # start data

#$previous_occ_major[] = "3dcaf1e8-d4d8-95d1-0039-552d21901af6";
#$previous_occ_minor[] = "291e0110-9b23-8ea0-0f2e-552d21cf33f8";
#$previous_occ_broad[] = "ac60c05b-8995-65ee-fd32-552d2131ac41";
#$previous_occ_detailed[] = "229d19a7-d610-fffe-b635-552d2157489d";

 foreach ($data as $rowcount => $row){

         $package_rows = "";
         $column_count = "";
         $package_fields = "";

         $row = rtrim($row);
         $cols = preg_split('/\t+/', $row,-1,PREG_SPLIT_NO_EMPTY);
         $column_count = count($cols);

         $count = "";
         foreach (array_filter($cols) as $count => $item){

                  if ($count == 0){
                     $occ_group = $item;
                     $jobarray[$rowcount]['occ_group'] = $occ_group;
                     }

                  if ($count == 1){
                     $occ_code = $item;
                     $jobarray[$rowcount]['occ_code'] = $occ_code;
                     }

                  if ($count == 2){
                     $occ_title = $item;
                     $jobarray[$rowcount]['occ_title'] = $occ_title;
                     }

                  if ($count == 3){
                     $occ_desc = $item;
                     $jobarray[$rowcount]['occ_desc'] = "US Total Employed: ".$occ_desc;
                     }


                 } # columns

          } # rows

 foreach ($jobarray as $newrow => $content){

         $occ_group = $content['occ_group'];
         $occ_code = $content['occ_code'];
         $occ_title = $content['occ_title'];
         $occ_desc = $occ_group.": ".$occ_title." [".$content['occ_desc']."]";

         #echo "Row :".$newrow." OCC Group: ".$occ_group." && ".$occ_code." && ".$occ_title." - ".$occ_desc."<BR>";

         if ($occ_group == 'major'){
            # parent has to be jobs
            $sclm_configurationitemtypes_id_c = $jobs_cit;
            #echo "parent of major = $jobs_cit <BR>";
            } elseif ($occ_group == 'minor'){
            # parent has to be last major
            $last_major = end($previous_occ_major);
            $sclm_configurationitemtypes_id_c = $last_major;
            #echo "parent of minor = $last_major <BR>";
            } elseif ($occ_group == 'broad'){
            # parent has to be last minor
            $last_minor = end($previous_occ_minor);
            $sclm_configurationitemtypes_id_c = $last_minor;
            #echo "parent of broad = $last_minor <BR>";
            } elseif ($occ_group == 'detailed'){
            # parent has to be last broad
            $last_broad = end($previous_occ_broad);
            $sclm_configurationitemtypes_id_c = $last_broad;
            #echo "parent of detailed = $last_broad <BR>";
            }

         $process_object_type = "ConfigurationItemTypes";
         $process_action = "update";

         $process_params = array();  
         $process_params[] = array('name'=>'name','value' => $occ_title);
         $process_params[] = array('name'=>'name_en','value' => $occ_title);
         $process_params[] = array('name'=>'name_ja','value' => $occ_title);
         $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_open_public);
         $process_params[] = array('name'=>'ci_data_type','value' => '608723f5-d1d3-6f3e-d37f-51c2f6e8f1ca');
         $process_params[] = array('name'=>'description','value' => $occ_desc);
         $process_params[] = array('name'=>'description_en','value' => $occ_desc);
         $process_params[] = array('name'=>'description_ja','value' => $occ_desc);
         $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $sclm_configurationitemtypes_id_c);
         $process_params[] = array('name'=>'external_source','value' => '138bfe41-6ff1-722f-06a5-552d1c5b570b');
         $process_params[] = array('name'=>'external_data_id','value' => $occ_code);

         $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

         $ci_id = $result['id'];

         # Need to put the ID into this - for now, use the title
         if ($occ_group == 'major'){
            $previous_occ_major[] = $ci_id;
            } elseif ($occ_group == 'minor'){
            $previous_occ_minor[] = $ci_id;
            } elseif ($occ_group == 'broad'){
            $previous_occ_broad[] = $ci_id;
            } elseif ($occ_group == 'detailed'){
            $previous_occ_detailed[] = $ci_id;
            }

         } # for

 break;

 } # switch

?>