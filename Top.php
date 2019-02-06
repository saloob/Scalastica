<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2015-04-23
# Page: Top.php 
##########################################################
# case 'Top':

  if (!function_exists('get_param')){
     include ("common.php");
     }

  function do_top($val){
 
   global $standard_statuses_closed,$crm_api_user, $crm_api_pass, $crm_wsdl_url,$funky_gear,$custom_portal_divstyle,$portal_font_colour,$divstyle_white,$lingo,$strings;

   $name_field_base = "name_";
   $content_field_base = "description_";

   $name_field = "name_".$lingo;
   $content_field = "description_".$lingo;
  
    $top_portal_content_type = '4afdc2bb-7359-d4d9-b3e5-52643fce9c30';

    $ci_object_type = "Content";
    $ci_action = "select";
    $ci_params[0] = " deleted=0 && cmn_statuses_id_c !='".$standard_statuses_closed."' && portal_content_type='".$top_portal_content_type."' && account_id_c='".$val."' " ;

    $ci_params[1] = "id,name,description,$name_field,$content_field"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = ""; // order;
    $ci_params[4] = ""; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    #var_dump($ci_items);

    if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $description = $ci_items[$cnt]['description'];

           if ($ci_items[$cnt][$name_field] != NULL){
              $show_name = $ci_items[$cnt][$name_field];
              } else {
              $show_name = $name;
              }

           if ($ci_items[$cnt][$content_field] != NULL){
              $show_description = $ci_items[$cnt][$content_field];
              } else {
              $show_description = $description;
              }

           } # end for

       } # is array

    $desc_length = strlen($show_description);
    $desc_length_strip = strlen(strip_tags($show_description));

    if ($desc_length != $desc_length_strip){
       # IS change from stripping tags
       if ($show_description == str_replace("<br>", "", $show_description)){
          # no breaks;
          $show_description = str_replace("</br>", "", $show_description);
          $show_description = str_replace("\n", "<br>", $show_description);
          }

       if ($show_description != str_replace("<p>", "", $show_description)){

          $srv_part_start = "<p style";
          $srv_part_end = "</p>";

          $startcheck = "";
          $endcheck = "";
          $startcheck = "";
          $endcheck = "";
          $startcheck = $funky_gear->replacer($srv_part_start, "", $show_description);
          $endcheck = $funky_gear->replacer($srv_part_end, "", $show_description);

          if ($startcheck == $show_description || $endcheck == $show_description){
             # Do nothing - they don't exist
             } else {
             $startsAt = strpos($show_description, $srv_part_start) + strlen($srv_part_start);
             $endsAt = strpos($show_description, $srv_part_end, $startsAt);
             $inner_content = substr($show_description, $startsAt, $endsAt - $startsAt);
             $show_description = str_replace($inner_content, "ZAZAZAZAZAZAZAZAZA", $show_description);
             $show_description = str_replace("<p>", "", $show_description);
             $show_description = str_replace("</p>", "", $show_description);
             $inner_content = "<p style".$inner_content."</p>";
             $show_description = str_replace("ZAZAZAZAZAZAZAZAZA", $inner_content, $show_description);
             } 

          } # if

       } else {
       # No change - check for line breaks
       $show_description = str_replace("\n", "<br>", $show_description);
       }

    $show_description = preg_replace('|<a (.+?)>|i', '<a $1 target="_blank">', $show_description);

    $content_title = "<div style=\"".$custom_portal_divstyle."\"><center><font size=3 color=".$portal_font_colour."><B>".$name."</B></font></center></div>";
    $zaform = $content_title."<BR><div style=\"".$divstyle_white."\">".$show_description."</div>";

    return $zaform;

  } # end function

  $cache_time = 1;

  # return location and name for cache file
  $cache_file = "/tmp/cache_top_".$lingo."_".md5($hostname);

  # check that cache file exists and is not too old
  if (!file_exists($cache_file)){
     $zaform = do_top($val);
     file_put_contents($cache_file, $zaform);
     } elseif (filemtime($cache_file) < time() - $cache_time * 3600){
     $zaform = do_top($val);
     file_put_contents($cache_file, $zaform);
     } else {
     $zaform = file_get_contents($cache_file);
     } 

  echo $zaform;

# break; # End Top
##########################################################
?>