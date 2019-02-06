<?php

include ("common.php");

foreach ($_POST as $key=>$value){
 
        if ($key == 'd'){
           $do = $value;
           }

        if ($key == 'a'){
           $account_id_c = $value;
           }

        if ($key == 'c'){
           $contact_id_c = $value;
           }

        if ($key == 'vt'){
           $valtype = $value;
           }

        if ($key == 'v'){
           $val = $value;
           }

       } // end for post each 

switch ($valtype){

 case 'Advisory':
  $sclm_advisory_id_c = $val;
 break;
 case 'ConfigurationItems':
  $sclm_sowitems_id_c = $val;
 break;
 case 'Projects':
  $project_id_c = $val;
 break;
 case 'ProjectTasks':
  $projecttask_id_c = $val;
 break;
 case 'SOW':
  $sclm_sow_id_c = $val;
 break;
 case 'SOWItems':
  $sclm_sowitems_id_c = $val;
 break;
 case 'Content':
  $sclm_content_id_c = $val;
 break;
 case 'Messages':
  $sclm_messages_id_c = $val;
 break;
 case 'Emails':
  $sclm_emails_id_c = $val;
 break;
 case 'Ticketing':
  $sclm_ticketing_id_c = $val;
 break;
 case 'TicketingActivities':
  $sclm_ticketingactivities_id_c = $val;
 break;

} // end content type

if ($val != NULL){
   $returner = $funky_gear->object_returner ($valtype, $val);
   $object_return_name = $returner[0];
   $object_return = $returner[1];
   }

foreach ($_POST['ax-uploaded-files'] as $id=>$name){
 
//echo "ID: ".$id." - Name: ".$name."<BR>";

// uploads/81d48510-cd53-b831-baf6-51d779c1ff9d/11cb81f8-c74f-11ad-0a1c-51d77971d211/2013-11-09-19-06-53[]2013-11-09-19-06-50[]IMG_1059.JPG
// 2013-11-09-19-06-53[]2013-11-09-19-06-50[]IMG_1059.JPG

$path = "uploads/".$account_id_c."/".$contact_id_c."/";

list($uploadchunk,$filename) = explode($path, $name);

//echo "Filename: ".$filename."<P>";

//list($frontdate,$middate,$original_name) = explode("[]", $filename);
//list($frontdate,$original_name) = explode("[]", $filename);
//echo "frontdate: ".$frontdate."<BR>";
//echo "middate: ".$middate."<BR>";
$original_name = $filename;
//echo "original_name: ".$original_name."<BR>";

$path_parts = pathinfo($name);

/*
$path_parts = pathinfo($name);
$extension = $path_parts['extension'];
$dirname = $path_parts['dirname'];
$basename = $path_parts['basename'];
$filename = $path_parts['filename'];
*/
$extension = $path_parts['extension'];

#echo "extension: ".$extension."<BR>";

$contentdate = date("Y-m-d-G-i-s");
//$newname = $id."_[]_".$contentdate.".".$extension;
//$newname = $filename;
//$newname = $name;
/*
echo "Newname: ".$newname."<BR>";
echo "newthumb: ".$newthumb."<BR>";
echo "original_thumb: ".$original_thumb."<BR>";
*/

//copy($name, $path.$newname);
//@unlink($name);
//$content_url = $path.$newname;
$content_url = $name;

//echo "Content URL: ".$content_url."<BR>";

       $process_object_type = "Content";
       $process_action = "update";
       
       $imagearray = array("jpg","png","gif","jpeg","JPG","JPEG","PNG","BMP","bmp","GIF");
       $moviearray = array("mov","mpeg","mpeg4","avi","wmv","mp3","mp4");

       if (in_array($extension,$imagearray)){

          $content_type = '1b7369c3-dd78-a8a3-2a79-523876ce70fe';
          $extensionlessname = str_replace(".".$extension, '', $original_name);
          $original_thumb = $path.$extensionlessname."_thumb.".$extension;
//         $thumbdate = date("Y-m-d-G-i-s");
//         $thisthumb = $id."_[]_".$thumbdate."_thumb.".$extension;
//         $content_thumbnail = $path.$thisthumb;
          $content_thumbnail = $original_thumb;
//         echo "Original Thumb: ".$original_thumb." -> Content Thumb: ".$content_thumbnail."<BR>";
//         copy($original_thumb, $content_thumbnail);
//         @unlink($original_thumb);

          } elseif (in_array($extension,$moviearray)){

          $content_type = 'cccba116-c398-0acb-7778-523876243cd9';

          } else {
          # (!in_array($extension,$imagearray) && !in_array($extension,$moviearray)):

          $content_type = '34cf7647-dffa-8516-b25a-527c0b3c5590';

          } // end elseif

//       $cmn_countries_id_c = $cmn_countries_id_c;
//       $cmn_languages_id_c = '';
       $cmn_industries_id_c = '3ab902b1-5fe9-b06d-3e0a-522a8aa49f16'; // Business Services
       $cmn_statuses_id_c = $standard_statuses_open_public;

       #$assigned_user_id = 1;
       $portal_content_type = "";
 
       $process_params = array();
//       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $original_name);
       $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
       $process_params[] = array('name'=>'description','value' => $original_name);
       $process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
       $process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
       $process_params[] = array('name'=>'content_type','value' => $content_type);
       $process_params[] = array('name'=>'portal_content_type','value' => $portal_content_type);
       $process_params[] = array('name'=>'cmn_countries_id_c','value' => $cmn_countries_id_c);
       $process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
       $process_params[] = array('name'=>'cmn_industries_id_c','value' => $cmn_industries_id_c);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
       $process_params[] = array('name'=>'sclm_advisory_id_c','value' => $sclm_advisory_id_c);
       $process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
       $process_params[] = array('name'=>'sclm_sow_id_c','value' => $sclm_sow_id_c);
       $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
       $process_params[] = array('name'=>'sclm_messages_id_c','value' => $sclm_messages_id_c);
       $process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);
       $process_params[] = array('name'=>'content_url','value' => $content_url);
       $process_params[] = array('name'=>'content_thumbnail','value' => $content_thumbnail);
       $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $sclm_ticketing_id_c);
       $process_params[] = array('name'=>'sclm_ticketingactivities_id_c','value' => $sclm_ticketingactivities_id_c);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       //$process_message .= $strings["SubmissionSuccess"]."<a href=\"#\" target=\"_top\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$do."');return false\">".$strings["action_view_here"]."</a><P>";

       $process_message .= $strings["SubmissionSuccess"]."<P>";

       $process_message .= "<B>".$strings["Name"].":</B> ".$original_name."<P>";

       $process_message .= str_replace("XXXX","<B>".$object_return_name."</B>", $strings["ImageUploadCompleteRefresh"]);

//       $process_message .= "<B>".$strings["Description"].":</B> ".$original_name."<BR>";

       echo "<div style=\"".$divstyle_white."\">".$process_message."<P></div><P>";


} // end for post each 

?>