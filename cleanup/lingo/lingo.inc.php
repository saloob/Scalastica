<?php

// Language Manipulation File

// Core Lingo File
// To add a new supported lingo xxxxx;
// 1) Translate the English base file /lingo/lingo.english.inc.php to /lingo/lingo.xxxxx.inc.php
// 2) Copy the last array list for the lingo xxxx
// 3) Add the language translation for the language word within the arrays

  // English
  $lingos[0][0][0][0][0][0][0] = 'en';
  $lingos[0][1][0][0][0][0][0] = '1';
  $lingos[0][1][1][0][0][0][0] = 'English';
  $lingos[0][1][1][1][0][0][0] = array('ja'=>'英語','ru'=>'English', 'ch'=>'English');
  $lingos[0][1][1][1][1][0][0] = 'images/flags/flag_au.jpg';
  $lingos[0][1][1][1][1][1][0] = 'en-AU';
  $lingos[0][1][1][1][1][1][1] = 'en'; // name used for the lingo file

  // Japanese
  $lingos[1][0][0][0][0][0][0] = 'ja';
  $lingos[1][1][0][0][0][0][0] = '2';
  $lingos[1][1][1][0][0][0][0] = '日本語';
  $lingos[1][1][1][1][0][0][0] = array('en'=>'Japanese', 'ru'=>'Japanese', 'ch'=>'Japanese');
  $lingos[1][1][1][1][1][0][0] = 'images/flags/flag_ja.gif';
  $lingos[1][1][1][1][1][1][0] = 'ja-JP';
  $lingos[1][1][1][1][1][1][1] = 'ja'; // name used for the lingo file
  
/*  
//Chinese
  $lingos[2][0][0][0][0][0][0] = 'ch';
  $lingos[2][1][0][0][0][0][0] = '2';
  $lingos[2][1][1][0][0][0][0] = 'Chinese';
  $lingos[2][1][1][1][0][0][0] = array('e'=>'Chinese', 'ru'=>'Chinese', 'j'=>'Chinese');
  $lingos[2][1][1][1][1][0][0] = 'images/flags/flag_cn.gif';
  $lingos[2][1][1][1][1][1][0] = 'ch';
  $lingos[2][1][1][1][1][1][1] = 'ch'; // name used for the lingo file

  // Russian

  $lingos[2][0][0][0][0][0][0] = 'ru';
  $lingos[2][1][0][0][0][0][0] = '3';
  $lingos[2][1][1][0][0][0][0] = 'Russian';
  $lingos[2][1][1][1][0][0][0] = array('en'=>'Russian', 'ja'=>'Russian');
  $lingos[2][1][1][1][1][0][0] = 'images/flags/flag_ru.gif';
  $lingos[2][1][1][1][1][1][0] = 'ru';
  $lingos[2][1][1][1][1][1][1] = 'ru'; // name used for the lingo file
*/

###############################
# Language Selector

function language_selector($section,$lingo, $variables,$page,$LeftDIV,$BodyDIV,$RightDIV){

global $lingos,$funky_gear;

$_SESSION['lingo'] = $lingo;

list ($page,$lingo,$do,$action,$val,$valtype) = explode ("@", $variables);

  $navi_count = 0;

  for ($x=0;$x<count($lingos);$x++) {

      $extension = $lingos[$x][0][0][0][0][0][0];
      $id = $lingos[$x][1][0][0][0][0][0];
      $language = $lingos[$x][1][1][0][0][0][0];
      $languages = $lingos[$x][1][1][1][0][0][0];
      $image = $lingos[$x][1][1][1][1][0][0];
      $int = $lingos[$x][1][1][1][1][1][0];
      $pagebit = $lingos[$x][1][1][1][1][1][1];
      
      if ($lingo == $extension){
         $language = $lingos[$x][1][1][0][0][0][0];
         $language_bit = "<img src=".$image." width=18 height=12 border=0 alt='".$language."'>";
         } else {
         $language_array = $lingos[$x][1][1][1][0][0][0];
         foreach ($language_array as $key => $value) {
                 if ($key == $x && $x != $lingo){
		            $language = $value;
                    } // end if

         } // end for

         if ($LeftDIV != NULL && $LeftDIV != NULL){

            $sendvars = "Body@".$extension."@".$do."@".$action."@".$val."@".$valtype;
            $sendvars = $funky_gear->encrypt($sendvars);

            $left_sendvars = "Left@".$extension."@".$do."@".$action."@".$val."@".$valtype;
            $left_sendvars = $funky_gear->encrypt($left_sendvars);

            $right_sendvars = "Right@".$extension."@".$do."@".$action."@".$val."@".$valtype;
            $right_sendvars = $funky_gear->encrypt($right_sendvars);

            $language_bit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','tr.php','sv=$sendvars');loader('".$LeftDIV."');doLPOSTRequest('".$LeftDIV."','tr.php','sv=$left_sendvars');loader('".$RightDIV."');doRPOSTRequest('".$RightDIV."','tr.php','sv=$right_sendvars');timedRefresh(10000);return false\"><img src=".$image." border=0 width=18 height=12 alt='".$language."'></a>";
            } else {

            $sendvars = "Body@".$extension."@".$do."@".$action."@".$val."@".$valtype;
            $sendvars = $funky_gear->encrypt($sendvars);

            $language_bit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','tr.php','sv=$sendvars');timedRefresh(10000);return false\"><img src=".$image." border=0 width=18 height=12 alt='".$language."'></a>";
            } 

         } // end if

      if ($navi_count < 1){
         $language_pack = $language_bit;
         } else {
         $language_pack .= $language_bit;
         }
      $navi_count++;

  } // end foreach

  return $language_pack;

} // end lingo function

#
###############################
#

function set_lingo(){

global $glb_doc_root, $lingos, $default_lingo, $lingo;

$lingo = $_SESSION['lingo'];

if ($lingo == NULL && isset($default_lingo)){
	$lingo = $default_lingo;
	}

$lang_file = "";

$browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

if ($lingo == NULL){
   $lingo = $_SESSION['lingo'];
   if ($lingo == NULL){
      $lingo = $browser_lingo;
      $_SESSION['lingo'] = $browser_lingo;
      } // end if not session
   }
   
if ($lingo == NULL){
   $lingo = $default_lingo;
   }
   
$_SESSION['lingo'] = $lingo;

for ($x=0;$x<count($lingos);$x++) {

    $extension = $lingos[$x][0][0][0][0][0][0];
    $id = $lingos[$x][1][0][0][0][0][0];
    $language = $lingos[$x][1][1][0][0][0][0];
    $languages = $lingos[$x][1][1][1][0][0][0];
    $image = $lingos[$x][1][1][1][1][0][0];
    $int = $lingos[$x][1][1][1][1][1][0];
    $pagebit = $lingos[$x][1][1][1][1][1][1];

    $lingobits[]=$extension;

    if ($lingo == $extension){
       $lingofile = $pagebit;
       } // end if
    } // end forloop

$lang_file = $glb_doc_root."lingo/lingo.".$lingofile.".php";

$_SESSION['lingobits'] = $lingobits;

return $lang_file;

}

?>