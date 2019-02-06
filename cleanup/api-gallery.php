<?php
######################################
# Gallery API
# Saloob, Inc
# Real Politika
#
######################################
#

class gallery {

// Begin Core function

 var $dbLink_ID = 0;

#####################################################
# Database Connection Definition

function dbconnect ($db_name,$db_host,$db_user,$db_pass){

 $this->dbLink_ID = mysql_pconnect($db_host,$db_user,$db_pass);
 mysql_query("SET NAMES utf8");

if (!$this->dbLink_ID) {
   echo "connect($Host, $User, \$Password) failed.";
   return 0;
   }

 @mysql_select_db($db_name,$this->dbLink_ID);

 }

# End Database Connection Definition
#####################################################
# Core Function

function api_gallery ($object_type, $action, $params){

global $lingo,$strings;

/*
$db_host = $realpolitika_config['gallery_config']['gallery_db_host_name'];
$db_name = $realpolitika_config['gallery_config']['gallery_db_name'];
$db_user = $realpolitika_config['gallery_config']['gallery_db_user_name'];
$db_pass = $realpolitika_config['gallery_config']['gallery_db_password'];
*/

$db_host = "192.168.1.22";
$db_name = "realpolitika_gallery";
$db_user = "realpolitikan";
$db_pass = "spiceoflife72";

$table_prefix = "rp_";

$returnpack = array();

# End Extract Database Information from App
################################################
switch ($object_type){

 ###############################################
 case 'Items':

  $table = $table_prefix."items";

  switch ($action){

   ############################################
   case 'get_parent':

    if (is_array($params)){
       $query = $params[0];
       $items = $params[1];
       $orderby = $params[2];
       }

       if (!$query){
          $query = "";
          }

       if (!$orderby){
          $orderby = "";
          }

       if (!$items){
          $items = "*";
          }


    $zaquery = "SELECT $items FROM $table $query $orderby ";
    
    $this->dbconnect ($db_name,$db_host,$db_user,$db_pass);

    $the_list = mysql_query($zaquery);
     
    $cnt = 0;
  
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
          $returnpack[$cnt]['name'] = $the_row['name'];

          $cnt++;

          } // end while

   break;
   ############################################
   case 'select':

    if (is_array($params)){
       $query = $params[0];
       $items = $params[1];
       $order = $params[2];
       }

       if (!$query){
          $query = "";
          }

       if (!$order){
          $order = "";
          }

       if (!$items){
          $items = "*";
          }


    $zaquery = "SELECT $items FROM $table $query $order ";

    $this->dbconnect ($db_name,$db_host,$db_user,$db_pass);

    $the_list = mysql_query($zaquery);
     
    $cnt = 0;
  
    while ($the_row = mysql_fetch_array ($the_list)){

          $returnpack[$cnt]['id'] = $the_row['id'];
          $returnpack[$cnt]['album_cover_item_id'] = $the_row['album_cover_item_id'];
          $returnpack[$cnt]['captured'] = $the_row['captured'];
          $returnpack[$cnt]['created'] = $the_row['created'];
          $returnpack[$cnt]['description'] = $the_row['description'];
          $returnpack[$cnt]['height'] = $the_row['height'];
          $returnpack[$cnt]['left_ptr'] = $the_row['left_ptr'];
          $returnpack[$cnt]['level'] = $the_row['level'];
          $returnpack[$cnt]['mime_type'] = $the_row['mime_type'];
          $returnpack[$cnt]['name'] = $the_row['name'];
          $returnpack[$cnt]['owner_id'] = $the_row['owner_id'];
          $returnpack[$cnt]['parent_id'] = $the_row['parent_id'];
          $returnpack[$cnt]['rand_key'] = $the_row['rand_key'];
          $returnpack[$cnt]['relative_path_cache'] = $the_row['relative_path_cache'];
          $returnpack[$cnt]['relative_url_cache'] = $the_row['relative_url_cache'];
          $returnpack[$cnt]['resize_dirty'] = $the_row['resize_dirty'];
          $returnpack[$cnt]['resize_height'] = $the_row['resize_height'];
          $returnpack[$cnt]['resize_width'] = $the_row['resize_width'];
          $returnpack[$cnt]['right_ptr'] = $the_row['right_ptr'];
          $returnpack[$cnt]['slug'] = $the_row['slug'];
          $returnpack[$cnt]['sort_column'] = $the_row['sort_column'];
          $returnpack[$cnt]['sort_order'] = $the_row['sort_order'];
          $returnpack[$cnt]['thumb_dirty'] = $the_row['thumb_dirty'];
          $returnpack[$cnt]['thumb_height'] = $the_row['thumb_height'];
          $returnpack[$cnt]['thumb_width'] = $the_row['thumb_width'];
          $returnpack[$cnt]['title'] = $the_row['title'];
          $returnpack[$cnt]['type'] = $the_row['type'];
          $returnpack[$cnt]['updated'] = $the_row['updated'];
          $returnpack[$cnt]['view_count'] = $the_row['view_count'];
          $returnpack[$cnt]['weight'] = $the_row['weight'];
          $returnpack[$cnt]['width'] = $the_row['width'];
          $returnpack[$cnt]['view_1'] = $the_row['view_1'];
          $returnpack[$cnt]['view_2'] = $the_row['view_2'];
          $returnpack[$cnt]['view_3'] = $the_row['view_3'];

          $cnt++;

          } // end while

   break; // end select Items
   ############################################

  } // end Items actions

 break; // end Items
 ###############################################
 case 'Users':

  $table = $table_prefix."users";

  switch ($action){

   ############################################
   case 'select':

    //rp_users

   break;
   ############################################

  } // end Users actions

 break; // end Users
 ###############################################

 } // end switch

 return $returnpack;

 } // end function

} // end gallery class

# End API
######################################
?>
