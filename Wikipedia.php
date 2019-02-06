<?php
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-07-29
# Page: Wikipedia.php 
##########################################################
# case 'Wikipedia':

if (!function_exists('get_param')){
   include ("common.php");
   }

if ($action == NULL){
   $action = $_GET['action'];
   }

if ($action == NULL){
   $action = $_POST['action'];
   }

$sendiv = $_GET['sendiv'];
if ($sendiv == NULL){
   $sendiv = $_POST['sendiv'];
   }

  switch ($action){
   
   case 'search':

    echo "<center><a href=\"#\" onClick=\"cleardiv('autoform');document.getElementById('autoform').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";

    # https://en.wikipedia.org/w/api.php

    $date = date("Y@m@d@G");
    $body_sendvars = $date."#Bodyphp";
    $body_sendvars = $funky_gear->encrypt($body_sendvars);

    $action_search_keyword = $strings["action_search_keyword"];
    $DateStart = $strings["DateStart"];
    $action_search = $strings["action_search"];

    $keyword = $_POST['keyword'];
    if (!$keyword){
       $keyword = $_GET['keyword'];
       }

    # Original Action needs to be sent back
    $orig_action = $_POST['orig_action'];
    if (!$orig_action){
       $orig_action = $_GET['orig_action'];
       }

    $consearch = <<< CONSEARCH
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
     <input type="text" id="keyword" placeholder="$action_search_keyword" name="keyword" value="$keyword" size="20" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
     <input type="hidden" id="pg" name="pg" value="$body_sendvars" >
     <input type="hidden" id="value" name="value" value="$val" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="sendiv" name="sendiv" value="autoform" >
     <input type="hidden" id="do" name="do" value="Wikipedia" >
     <input type="hidden" id="orig_action" name="orig_action" value="$orig_action" >
     <input type="hidden" id="valuetype" name="valuetype" value="$valtype" >
     <input type="button" name="button" value="$action_search" onclick="javascript:loader('autoform');get(this.parentNode);return false" style="font-family: v; font-size: 10pt; color: #5E6A7B; border: 1px solid #5E6A7B; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1;">
   </form>
</center>
CONSEARCH;

    echo $consearch;

    #echo "valtype: ".$valtype."<BR>";
    #echo "val: ".$val."<BR>";

    if ($keyword != NULL){

       $url_keyword = urlencode($keyword);
       $url = "http://en.wikipedia.org/w/api.php?action=query&titles=".$url_keyword."&prop=extracts&rvsection=0&format=json";

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
       curl_setopt($ch, CURLOPT_USERAGENT, 'MyBot/1.0 (https://www.sharedeffects.com/)');

       $result = curl_exec($ch);

       if (!$result) {
          exit('cURL Error: '.curl_error($ch));
          } else {

          #Jekyll Island
          $content_array = json_decode($result, true);

          foreach ($content_array['query']['pages'] as $content){

                  #$pageid = $content['pageid'];
                  #echo "Page ID: ".$pageid."<BR>";
                  $title = $content['title'];
                  $title = "<input type=\"button\" style=\"font-family: v; font-size: 10pt; background-color: #1560BD; border: 1px solid #5E6A7B; border-radius:10px; padding-left: 4; padding-right: 4; padding-top: 1; padding-bottom: 1; width:150px;color:#FFFFFF;\" name=\"wikipedia\" id=\"wikipedia\" value=\"Use ".$title."\" onClick=\"loader('lightform');document.getElementById('lightform').style.display='block';doBPOSTRequest('lightform','Body.php','do=".$valtype."&action=".$orig_action."&sendiv=lightform&value=".$val."&valuetype=".$valtype."&source=wikipedia&source_title=".$url_keyword."');cleardiv('autoform');document.getElementById('autoform').style.display='none';return false\">";
                  echo $title."<BR>";
                  $extract = $content['extract'];
                  echo $extract;

                  }
 
        /*
	foreach($json_array['query']['pages'] as $page){

		if(count($page['images']) > 0){
		    foreach($page['images'] as $image){
		    	$title = str_replace(" ", "_", $image["title"]);
		    	$imageinfourl = "http://en.wikipedia.org/w/api.php?action=query&titles=".$title."&prop=imageinfo&iiprop=url&format=json";
		    	$imageinfo = curl($imageinfourl);
		    	$iamge_array = json_decode($imageinfo, true);
		    	$image_pages = $iamge_array["query"]["pages"];
				foreach($image_pages as $a){
					$results[] = $a["imageinfo"][0]["url"];
				}
			}
		}

	}
        */

          #var_dump($result);

          } # if result
       
         } # if keyword

   break; # search

  } # action switch

# break; End Wikipedia
##########################################################
?>