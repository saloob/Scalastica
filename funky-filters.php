<?php
##############################################
# Form Builder
# Author: Matthew Edmond, Saloob
# Date: 2011-02-24
# Page: funky-filters.php
############################################## 
# Namespace

/**
 * Scalastica Funky Filters
 *
 * @category ScalasticaFunctions
 * @package  funky_filters
 * @author   Matthew Edmond <saloobinc@gmail.com>
 * @license  http://www.saloob.com/ Apache License 2.0
 * @link     http://www.saloob.com/
 */

#
#############################
# Global Functions

date_default_timezone_set('Asia/Tokyo');

mb_language('uni');
mb_internal_encoding('UTF-8');

class funky_filters
{

#################################
# Do Filterbits

 function do_filterbits ($filterbit_params){

  date_default_timezone_set('Asia/Tokyo');

  #ob_start('fatal_error_handler');

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  if (!function_exists('get_param')){
     include ("common.php");
     }

  global $funky_gear,$assigned_user_id,$portal_account_id,$portal_email_server,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c;
 
  $mushi = FALSE;

  $filterbits = $filterbit_params[0];
  $subject = $filterbit_params[1];
  $from_mailname = $filterbit_params[2];
  $body = $filterbit_params[3];
  $date = $filterbit_params[4];
  $udate = $filterbit_params[5];
  $filespack = $filterbit_params[6][0];
  $contentpack = $filterbit_params[6][1];
  $report = $filterbit_params[7];
  $match = $filterbit_params[8];
  $debug = $filterbit_params[9];
  $filter_id = $filterbit_params[10];
  $do_catchall = $filterbit_params[11];
  $catchall = $filterbit_params[12];
  $check_maint_servers = $filterbit_params[13];
  $previous_ticket = $filterbit_params[14];
  $previous_title = $filterbit_params[15];
  $previous_subject = $filterbit_params[16];
  $email_id = $filterbit_params[17];
  $received_to = $filterbit_params[18];
  $received_cc = $filterbit_params[19];
  $triggercount = $filterbit_params[20];
  $replyparams = $filterbit_params[21];
  $precheckparams = $filterbit_params[22];

  if ($replyparams != NULL){
     $create_activity_ticket_id = $replyparams[0];
     $create_activity_email_ticket_id = $replyparams[1];
     $create_activity_email_ticket_status = $replyparams[2];
     }

  $server_replace = $precheckparams[0];
  $message_pass = $precheckparams[1];
  $message_source = $precheckparams[2];
  $event_source = $precheckparams[3];
  $event_category = $precheckparams[4];
  $nameupper = $precheckparams[5];
  $namelower = $precheckparams[6];
  $server_pack = $precheckparams[7];

  $debugger = "<img src=http://".$hostname."/images/icons/bug.png width=16> <B>Debug:</B>";

  # If final message, then came from pre-catch-all = requires report...maybe...
  if ($debug == TRUE){
     $create_report = TRUE;
     }

  if ($create_report == TRUE){
     $inner_report .= $debugger." Previous_ticket: <B>".$previous_ticket."</B> Title: ".$previous_title." Subject: ".$previous_subject."<BR>"; 
     }

  if ($create_report == TRUE){
     $inner_report .= $debugger." Filter Trigger Count to be met to either ignore or create a ticket: <B>".$triggercount."</B><BR>";
     }

  ##########################################
  # Use Filtering Set to get SLA Request

  for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

      $filterbit_id = $filterbits[$cntfb]['id'];
      $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

      if ($filterbit_configurationitemtypes_id_c == '683bb5f7-e1c7-4796-8d23-52b0df65369f'){
         $sla_filter_sla_id = $filterbits[$cntfb]['name']; // the actual ID of the SLA item
         $sla_returner = $funky_gear->object_returner ("ServiceSLARequests", $sla_filter_sla_id);
         $sla_filter_name = $sla_returner[0];

         if ($create_report == TRUE){
            $inner_report .= $debugger." Found SLA Filter: <B>".$sla_filter_name."</B> [ID: ".$sla_filter_sla_id."]<BR>";
            }

         // Must pack in array for later use in checking within emails for server name
         $sla_pack[$sla_filter_sla_id]=$sla_filter_name;

         } // end sla for

      } // end for filterbits

   if (is_array($sla_pack)){

      foreach ($sla_pack as $sla_id => $sla_name){ 

              $sla_object_type = "ServiceSLARequests";
              $sla_action = "select";
              $sla_params[0] = " id='".$sla_id."' ";
              $sla_params[1] = ""; // select array
              $sla_params[2] = ""; // group;
              $sla_params[3] = ""; // order;
              $sla_params[4] = ""; // limit
  
              $sla_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sla_object_type, $sla_action, $sla_params);

              if (is_array($sla_list)){

                 for ($sla_cnt=0;$sla_cnt < count($sla_list);$sla_cnt++){

                     $sclm_sla_id_c = $sla_list[$sla_cnt]['sclm_sla_id_c'];

                     if ($sclm_sla_id_c != NULL){

                        $sla_params[5] = $sclm_sla_id_c;
                        $sla_params[11] = $date;
                        $sla_return = $funky_gear->check_sla ($sla_params);
                        $sla_status = $sla_return[0];

                        if ($sla_status == 1){
                           $sclm_serviceslarequests_id_c = $sla_id;

                           if ($create_report == TRUE){
                               $inner_report .= $debugger."SLA Live Status for selected SLA <B>[".$sla_name."]</B><BR>";
                               }

                           } // if sla status OK

                        } // if sclm_sla_id_c

                     } // for sla

                 } // if array

              } // foreach

      } // is array sla_pack

  # End get sla
  ##########################################
  # If reply activity is set

  if ($create_activity_ticket_id != NULL){

     $michimail = FALSE;
     $match = TRUE;
     $create_activity = TRUE;
     $create_ticket = FALSE;
     $create_email = TRUE;

     } else {

     if ($do_catchall != TRUE){
        $match = FALSE;
        }

     # Set the count for the triggers that must be met to satisfy the filter conditions
     $trigger_rate = 0;

     #########################################
     # Use Filtering Set to get servers

     $servertrigger = "";
     $servermatch = "";

     for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

         $filterbit_id = $filterbits[$cntfb]['id'];
         $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

         # Filter Server CIT
         if ($filterbit_configurationitemtypes_id_c == '6de9b547-7c78-9ff4-83ea-52a8dc7f33f1'){

            $servertrigger = TRUE;

            $server_filter_server_id = $filterbits[$cntfb]['name'];
            if ($server_filter_server_id){
               $server_returner = $funky_gear->object_returner ("ConfigurationItems", $server_filter_server_id);
               $server_filter_name = $server_returner[0];

               if ($create_report == TRUE){
                  $inner_report .= $debugger." Found Server Filter: <B>".$server_filter_name."</B> [ID: ".$server_filter_server_id."]<BR>"; 
                  }

               # Must pack in array for later use in checking within emails for server name
               $server_show .= $server_filter_name."<BR>";
               $server_pack[$server_filter_server_id]=$server_filter_name;

               if ($body != $funky_gear->replacer($server_filter_name, "", $body)){
                  $servermatch = TRUE;
                  $filterbit_touched = TRUE;

                  if ($create_report == TRUE){
                     $inner_report .= $debugger."Server Filter found in email ([ID: ".$email_id."]: <B>".$server_filter_name."</B><BR>"; 
                     }

                  } elseif ($funky_gear->replacer(strtolower($server_filter_name),"",$body) != $body){

                  $servermatch = TRUE;
                  $filterbit_touched = TRUE;

                  if ($create_report == TRUE){
                     $inner_report .= $debugger." Server Filter (lowercase) found in email: <B>".$server_filter_name."</B><BR>";
                     }

                  } elseif ($funky_gear->replacer(strtoupper($server_filter_name),"",$body) != $body){

                  $servermatch = TRUE;
                  $filterbit_touched = TRUE;

                  if ($create_report == TRUE){
                     $inner_report .= $debugger." Server Filter (lowercase) found in email: <B>".$server_filter_name."</B><BR>";
                     }

                  } else {

                  if ($create_report == TRUE){
                     $inner_report .= $debugger." Server Filter (UPPER or LOWER) NOT matching: <B>".$server_filter_name."</B><BR>";
                     }

                  }

               } else {

               if ($create_report == TRUE){
                  $inner_report .= $debugger." Error Found Server Filter but no ID in name field: <B>".$server_filter_name."</B><BR>";
                  }

               } // end else if

           } // end if server

         } // end for filterbits

     if ($servertrigger == TRUE && $servermatch == FALSE){
        $match = FALSE;

        if ($create_report == TRUE){
           $inner_report .= $debugger." Server Filter does NOT match<BR>";
           }

        } elseif ($servertrigger == TRUE && $servermatch == TRUE) {

        $match = TRUE;

        $trigger_rate = $trigger_rate + 1;

        if ($create_report == TRUE){
           $inner_report .= $debugger." Server Filter DOES match<BR>";
           }

       if ($create_report == TRUE){
          $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
          }

        } // end if no server match


      # End get servers
      ##########################################
      # Use Filtering Set to get Sender

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '97ea1d7a-3243-4df3-38f4-52a8dc5793b4'){
          $sender = $filterbits[$cntfb]['name']; // the actual ID of the sender item

          # Convert from_mailname to lower case
          $sender = strtolower($sender);

          if ($sender){
             #$sender_returner = $funky_gear->object_returner ("ConfigurationItems", $sender_filter_sender_id);
             #$sender_filter_name = $sender_returner[0];

             if ($create_report == TRUE){
                $inner_report .= $debugger." Found Sender Filter: <B>".$sender."</B><BR>";
                }

             // Must pack in array for later use in checking within emails for server name
             $sender_pack[]=$sender;

             if (!$addressees_pack){
                $addressees_pack = $sender;
                } else {
                $addressees_pack = $addressees_pack.",".$sender;
                }

             } else {// end if sender_filter_sender_id

             if ($create_report == TRUE){
                $inner_report .= $debugger." Error Found Sender Filter but no ID in name field: <B>".$sender."</B><BR>";
                }

             }

          } // end if Sender

       # Add a feature to reply to sender??
       # Add Sender to email/ticket info - may be more than one, but 
       # $process_params[] = array('name'=>'extra_addressees','value' => $addressees_pack);

       } // end for filterbits

   # End get sender
   ##########################################
   # Check for filter string

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '98aa39a2-85bc-a8d6-e4e6-52a8dbecfd68'){
          $filter_string = $filterbits[$cntfb]['name'];
          $filter_strings[] = $filter_string; 

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter String: <B>".$filter_string."</B><BR>";
             } 

          } // if filter_string

       } // end for filterbits

   # End check for string
   ##########################################
   # Check for filter non-strings

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'afc56334-a00e-12d3-66ce-52d0f6cf46ec'){
          $filter_nonstring = $filterbits[$cntfb]['name'];
          $filter_nonstrings[] = $filter_nonstring; 

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter Non-String: <B>".$filter_nonstring."</B><BR>";
             } 

          } // if filter_string

       } // end for filterbits

   # End check for non-strings
   ##########################################
   # Check for filter Server/IPs

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'ef1bdff1-4df1-1562-7bd9-52c04ed4dae7'){
          $filter_ipserver_set_name = $filterbits[$cntfb]['name'];
          $filter_ipservers = $filterbits[$cntfb]['description'];

          if ($filter_ipservers != NULL){

             $ipservers_to_array = explode(',',$filter_ipservers); //split string into array seperated by ','

             foreach ($ipservers_to_array as $ipserver){
                     $ipserver_show .= "Server/IP: ".$ipserver."<BR>";
                     $ipserver_pack[] = $ipserver;

                     } // end for

             } // end if recp_cc_list

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter Server/IP Set: <B>".$filter_ipserver_set_name."</B><BR>";
             }

          } // if filter_string

       } // end for filterbits

   # End check for IPs
   ##########################################
   # Check for filter non-Servers/IPs

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'd3ce77c0-aa02-e4e3-8e67-52d1ef420dde'){
          $filter_nonipserver_set_name = $filterbits[$cntfb]['name'];
          $filter_nonipservers = $filterbits[$cntfb]['description'];

          if ($filter_nonipservers != NULL){
             $nonipservers_to_array = explode(',',$filter_nonipservers); //split string into array seperated by ','
             foreach ($nonipservers_to_array as $nonipserver){
                     $nonipserver_show .= "Non-Server/IP: ".$nonipserver."<BR>";
                     $nonipserver_pack[] = $nonipserver;
                     }
             } // end if recp_cc_list

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter OUT Server/IP Set: <B>".$filter_nonipserver_set_name."</B><BR>";
             }

          } // if filter_string

       } // end for filterbits

   # End check for IPs
   ##########################################
   # Check for filter triggers

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       $sender_match = "";
       $subject_match = "";
       $subod_match = "";
       $body_match = "";
       $mm_match = "";

       if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2'){
  
          $filter_trigger = $filterbits[$cntfb]['name'];

          # Convert from_mailname to lower case
          $from_mailname = strtolower($from_mailname);

          switch ($filter_trigger){

           ##################################
           # Trigger->Sender Match

           case '4f3d2814-e8ff-18a0-3d0f-52b8d841b39e': // sender email only

            if (is_array($sender_pack)){
               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE;
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger -> Email only: <B>".$from_mailname."=".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               #$match = FALSE;
               } 

            if ($sender_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               } 

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break; 
           # End Trigger->email only filter check
           ##################################
           # Trigger->Sender and Body String Match
           case 'a5d69649-6e50-56e1-d52c-52b8ddb43cd0':

            if (is_array($sender_pack)){

               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched One!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; 
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger -> Email: <B>".$from_mailname." with ".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               $sender_match = FALSE;
               }

            if (is_array($filter_strings)){

               foreach ($filter_strings as $filter_string){

                       if ($body != $funky_gear->replacer($filter_string,"",$body)){
                          $body_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$body_match = FALSE;
                          $bodystring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger -> AND Body String: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if is_array($filter_strings)

            if ($sender_match == TRUE && $body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->Sender and Body String Match
           ##################################
           # Trigger->Subject or Body String Match
           case '275f496d-eab4-6cf3-3add-52e191ce3241':

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($body != $funky_gear->replacer($filter_string,"",$body)){
                          $body_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          //$match = FALSE; 
                          $bodystring_result = "Not Matched!";
                        
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  Body String Match: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if string array

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $funky_gear->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; // also thus negates the above if TRUE
                          $subjectstring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  Subject($subject) not exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE || $body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->Subject or Body String Match
           ##################################
           # Trigger->Sender and Subject Exact String Match
           case '6e27808f-9fa0-f469-d04d-52b8dcb4bc8a':

            if (is_array($sender_pack)){

               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$sender_match = FALSE; 
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger -> Email: <B>".$from_mailname." with ".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               $sender_match = FALSE;
               } 
                                            
            if (is_array($filter_strings)){

               foreach ($filter_strings as $filter_string){

                       if ($filter_string == $subject){
                          $subject_match = TRUE;
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                         //$subject_match = FALSE; 
                          $subjectstring_result = "Not Matched!";
                          }

                       } // foreach

               } // if is array

            if ($sender_match == TRUE && $subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

            if ($create_report == TRUE){
               $inner_report .= $debugger." Filter Trigger ->  Subject Exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->Sender and Subject Exact String Match
           ##################################
           # Trigger->Sender and Subject Not Exact String Match
           case '9dcd893b-93bb-ade3-57d5-52d08a4cdb09':

            $subject_match = FALSE;
            $sender_match = FALSE;

            if (is_array($sender_pack)){

               foreach ($sender_pack as $sender_email){

                       if ($from_mailname == $sender_email){
                          $sender_match = TRUE;
                          $sender_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; 
                          $sender_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger -> Email: <B>".$from_mailname." with ".$sender_email."</B> ".$sender_result."<BR>";
                          }

                       } // for each

               } else {// is senders
               $sender_match = FALSE;
               } 
                                            
            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $funky_gear->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$match = FALSE; // also thus negates the above if TRUE
                          $subjectstring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  Subject($subject) not exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE && $sender_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->Sender and Subject Not Exact String Match
           ##################################
           # Trigger->String Exactly Matches Subject Only
           case '9dc67d76-b728-5a03-f8bf-52b8daf4da69':

            $subject_match = FALSE;

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($filter_string != $subject){
                          //$subject_match = FALSE;
                          $subjectstring_result = "Not Matched!";
                          } else {
                          $subject_match = TRUE; 
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          }

                       } // foreach

               } // if is array

            if ($create_report == TRUE){
               $inner_report .= $debugger." Filter Trigger ->  Subject Exact String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
               }

            if ($subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break; 
           # End Trigger->String Exactly Matches Subject Only
           ##################################
           # Trigger->String in Body
           case '50be0484-2daf-dd18-0b6b-52b8da93e1df':

            $body_match = FALSE;

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($body != $funky_gear->replacer($filter_string,"",$body)){
                          $body_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          //$match = FALSE; 
                          $bodystring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  Body String Match: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if

            if ($body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {
               $match = FALSE;
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->String in Body
           ##################################
           # Trigger->Multiple Strings in Body-any OK
           case '21a5e0a4-e760-351b-e606-52c8e5f5ce89':

            if (is_array($filter_strings)){

               $mm_match = FALSE;

               foreach ($filter_strings as $filter_string){

                       if ($body != $funky_gear->replacer($filter_string,"",$body)){
                          $mm_match = TRUE; // also thus negates the above if TRUE
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          //$match = FALSE; 
                          $bodystring_result = "Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  Body String Match (Multiple): <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // if is array

            if ($mm_match == TRUE){
               $match = TRUE;
               $bodystring_result = "Final Match!";
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               $bodystring_result = "Finally NO Match!";
               } 

            if ($create_report == TRUE){
               $inner_report .= $debugger." Filter Trigger ->  Body String Match (Multiple): <B>".$bodystring_result."</B><BR>";
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->Multiple Strings in Body-any OK
           ##################################
           # Trigger->String in Subject Only
           case 'b52694ac-cf4d-839e-3a74-52b8da5eb6c0':

            # Look for any bound elements

            $subject_match = FALSE;

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $funky_gear->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result .= $filter_string." Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          #$subject_match = FALSE; // also thus negates the above if previously TRUE or ignores if after this
                          $subjectstring_result .= $filter_string." Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  String in Subject ($subject) String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               } 

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->String in Subject Only
           ##################################
           # Trigger->All Strings must be in Subject
           case '6ffb1f7d-273e-6bc9-9688-532706510ec4': 

            $subject_nomatch_count = 0;
            $subject_match = FALSE;

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($subject != $funky_gear->replacer($filter_string,"",$subject)){
                          $subject_match = TRUE; 
                          $subjectstring_result .= " Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          $subject_match = FALSE; // also thus negates the above if previously TRUE or ignores if after this
                          $subject_nomatch_count++;
                          $subjectstring_result .= " Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  String in Subject ($subject) String Match: <B>".$filter_string."</B> ".$subjectstring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($subject_nomatch_count == 0 && $subject_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               } 

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->String in Subject Only
           ##################################
           # Trigger->String NOT in Subject or Body
           case 'ec244f7a-9ba9-7de6-2ead-52d08b86f607':

            # Non-servers are designed to remove rubbish more than to act upon - so are not for a trigger count
            $triggercount = $triggercount-1;

            if ($create_report == TRUE){
               $inner_report .= $debugger." Filter Trigger ->  Checking for Non-String in Subject or Body<BR>";
               }

            if (is_array($filter_nonstrings)){

               foreach ($filter_nonstrings as $filter_nonstring){

                       if ($subject != $funky_gear->replacer($filter_nonstring,"",$subject)){
                          //$match = TRUE;
                          $subod_match = FALSE;
                          $nostring = TRUE;
                          $subjectstring_result = "Matched!";
                          $filterbit_touched = TRUE;

                          if ($create_report == TRUE){
                             $inner_report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") FOUND in Subject<BR>";
                             }

                          } elseif ($subject != $funky_gear->replacer (strtoupper($filter_nonstring),"",$subject)) {
                            $subod_match = FALSE;
                            $nostring = TRUE;
                            $filterbit_touched = TRUE;

                            if ($create_report == TRUE){
                               $inner_report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") CAPS FOUND in Subject<BR>";
                               }

                          } elseif ($subject != $funky_gear->replacer (strtolower($filter_nonstring),"",$subject)) {
                            $subod_match = FALSE;
                            $nostring = TRUE;
                            $filterbit_touched = TRUE;

                            if ($create_report == TRUE){
                               $inner_report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") LOWER FOUND in Subject<BR>";
                               }

                          } // if

                       if ($body != $funky_gear->replacer($filter_nonstring,"",$body)){
                          //$match = TRUE; // also thus negates the above if TRUE
                          $subod_match = FALSE; 
                          $bodystring_result = "Matched!";
                          $filterbit_touched = TRUE;
                          $nostring = TRUE;

                          if ($create_report == TRUE){
                             $inner_report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") FOUND in Body<BR>";
                             }

                          } // if

                       } // foreach

               } // is array strings

            if ($subod_match == FALSE){
               $match = FALSE;
               #$trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!

               if ($create_report == TRUE){
                  $inner_report .= $debugger." Filter Trigger ->  Non-String (".$filter_nonstring.") NOT in Subject or Body<BR>";
                  }

               } 

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->String NOT in Subject or body
           ##################################
           # Trigger->Filter OUT Servers/IPs from List
           case 'a0faabd3-32ce-1495-9616-52d1f105cac5':

            # Non-servers are designed to remove rubbish more than to act upon
            $triggercount = $triggercount-1;

            if (is_array($nonipserver_pack)){

               $subjectstring_result = "";
               $noipserverstring = "";

               foreach ($nonipserver_pack as $filter_nonserverip){

                       if ($body != $funky_gear->replacer($filter_nonserverip,"",$body)){
                          $body_match = FALSE; 
                          $filterbit_touched = TRUE;
                          $noipserverstring = TRUE;
                          $subjectstring_result .= $filter_nonserverip.": Matched!<BR>";
                          } elseif ($body != $funky_gear->replacer (strtoupper ($filter_nonserverip),"",$body)) {
                            $body_match = FALSE;
                            $noipserverstring = TRUE;
                            $filterbit_touched = TRUE;
                            $subjectstring_result .= strtoupper ($filter_nonserverip).": Matched!<BR>";
                          } elseif ($body != $funky_gear->replacer(strtolower ($filter_nonserverip),"",$body)) {
                            $body_match = FALSE;
                            $filterbit_touched = TRUE;
                            $noipserverstring = TRUE;
                            $subjectstring_result .= strtolower ($filter_nonserverip).": Matched!<BR>";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  Non-Server/IP (".$filter_nonserverip.") <B>".$subjectstring_result."</B><BR>";
                          }

                       } // foreach

               } // is array filter_nonserverips

            if ($body_match == FALSE){
               $match = FALSE;
               #$trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               //$match = TRUE;
               } 

            if ($noipserverstring == TRUE){
               $nostring = TRUE;
               }

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger->filter_nonserverips in Body
           ##################################
           # Trigger->All Strings must be in Body
           case '5baf4830-c7c5-7a99-0149-54091ff99022':

            $body_match = FALSE;
            $body_nomatch_count = 0;

            if (is_array($filter_strings)){
               foreach ($filter_strings as $filter_string){

                       if ($body != $funky_gear->replacer($filter_string,"",$body)){
                          $body_match = TRUE;
                          $bodystring_result = " Matched!";
                          $filterbit_touched = TRUE;
                          } else {
                          $body_match = FALSE; // also thus negates the above if previously TRUE or ignores if after this
                          $body_nomatch_count++;
                          $bodystring_result = " Not Matched!";
                          }

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Filter Trigger ->  String in Body String Match: <B>".$filter_string."</B> ".$bodystring_result."<BR>";
                          }

                       } // foreach

               } // is array strings

            if ($body_nomatch_count == 0 && $body_match == TRUE){
               $match = TRUE;
               $trigger_rate = $trigger_rate + 1;
               } else {// if not true - then false!
               $match = FALSE;
               } 

           if ($create_report == TRUE){
              $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
              }

           break;
           # End Trigger-> All Strings must be found in body
           ##################################
           # Trigger->catch-all
           case 'a51b8e41-bb1b-f729-2c59-52ccc314bc0a':
           # Catch-all
           # If no match - collect any remining email based on senders and create ticket

            $addreport = TRUE;

            if ($create_report == TRUE){
               $inner_report .= $debugger." Filter Trigger Catch-All - based on other rules in the Filter for Email: <B>".$from_mailname." with Subject: ".$subject."</B>. If the rules in this filter are FALSE - then no email will be delivered.<BR>";
               }

           break;

           # End Trigger->catch-all
           ##################################

          } // switch

          } // if filtertriggers

       } // end for filterbits

   # End check for filtertriggers
   ##########################################
   # If Servers are TRUE - then all else good - other wise, not completely true!

   if ($match == TRUE && $servertrigger == TRUE && $servermatch == TRUE){
      $match = TRUE;
      } elseif ($match == TRUE && $servertrigger == TRUE && $servermatch == FALSE){
      $match = FALSE;
      } elseif ($match == FALSE && $servertrigger == TRUE && $servermatch == TRUE){ // if any other triggers are true
      $match = FALSE;
      } elseif ($match == FALSE && $servertrigger == FALSE){
      $match = FALSE;
      } elseif ($match == FALSE){
      $match = FALSE;
      } else {
      $match = $match;
      }

   # End If Servers are TRUE
   ##########################################
   # May find other text, but if no IPs or servers found, then no match

   if (is_array($ipserver_pack)){

      foreach ($ipserver_pack as $check_ipserver){
  
              if ($body != $funky_gear->replacer($check_ipserver,"",$body)){
                 $ipservermatch = TRUE; 
                 $filterbit_touched = TRUE;
                 $ipbodystring_result .= "Matched $check_ipserver!<BR>";
                 } elseif ($body != $funky_gear->replacer(strtoupper ($check_ipserver),"",$body)){
                 $ipservermatch = TRUE; 
                 $filterbit_touched = TRUE;
                 $ipbodystring_result .= "Matched UPPERCASE ".strtoupper ($check_ipserver)."!<BR>";
                 } elseif ($body != $funky_gear->replacer(strtolower ($check_ipserver),"",$body)){
                 $ipservermatch = TRUE; 
                 $filterbit_touched = TRUE;
                 $ipbodystring_result .= "Matched lowercase ".strtolower ($check_ipserver)."!<BR>";
                 }

              } // foreach ip_pack

      if ($ipservermatch == TRUE){

         # 2016-06-18 - fixed - make servers found as TRUE
         #$match = TRUE;

         # There was no other hit so just a server is not good enough to make TRUE
         if ($match != FALSE){
            $match = TRUE;
            } else {

            if ($create_report == TRUE){
               $inner_report .= $debugger." There was no other hit but just a server hit is good enough to make TRUE<BR>";
               }

            }

         $trigger_rate = $trigger_rate + 1;
         } else {// if not true - then false!
         $match = FALSE;
         $ipbodystring_result = "No Match!";
         }

      if ($create_report == TRUE){
         $inner_report .= $debugger." Filter Server/IP Set: <B>".$ipbodystring_result."</B><BR>";
         $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";
         }


      } // is array IPs

   # End check for ips
   ##########################################
   # Check for time ranges

   $beforedatesmatch = $match;

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '291f5d67-13af-1b11-7e39-52b9d60288dc'){
          $filter_timerange = $filterbits[$cntfb]['name'];
          list($start_time,$end_time) = explode("_", $filter_timerange);
                                      
          $start_time = date('H:i', strtotime($start_time));
          $end_time = date('H:i', strtotime($end_time));
          $emailtime = date('H:i', strtotime($date));
          #list($email_hour,$email_minute) = explode(":", $emailtime);

          if ($emailtime > $start_time && $emailtime < $end_time){
             $timematch = TRUE;
             $filterbit_touched = TRUE;
             $trigger_rate = $trigger_rate + 1;
             $email_between_time_range_match = TRUE;
             $email_between_time_range_debug = "Time Range is a match!";
             } else {
             $timematch = FALSE;
             $email_between_time_range_match = FALSE;
             $email_between_time_range_debug = "Time Range is not a match!";
             }

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter Time Range: <B>".$filter_timerange."</B> if ($emailtime > $start_time && $emailtime < $end_time){ for;<BR>
Email: ".$emailtime."<BR> 
Start Time: ".$start_time."<BR>
End Time: ".$end_time."<BR>
Result: ".$email_between_time_range_debug."<BR>";

             $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";

             } // if create report

          } // if filter_timerange

       } // end for filterbits

   # End check for time ranges
   ##########################################
   # Check for date ranges
   # if ((is_array($filter_strings) || is_array($filter_nonstrings)) && $match != FALSE){

   $datematch = "";

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'ecf521df-6ff1-aa5c-0069-52b9d605f284'){
          $filter_daterange = $filterbits[$cntfb]['name'];
          list($start_date,$end_date) = explode("_", $filter_daterange);
          $start_date = date('d/m/Y', strtotime($start_day));
          $end_date = date('d/m/Y', strtotime($end_day));
          $email_date = date('d/m/Y', strtotime($date));

          if ($email_date >= $start_date && $email_date <= $end_date){
             $datematch = TRUE;
             $filterbit_touched = TRUE;
             $trigger_rate = $trigger_rate + 1;
             $email_between_date_range_match = TRUE;
             $email_between_date_range_debug = "Date Range is a match!";
             } else {
             $datematch = FALSE;
             $email_between_date_range_match = FALSE;
             $email_between_date_range_debug = "Date Range is not a match!";
             }

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter Date Range: <B>".$filter_daterange."</B> ($email_date > $start_date && $email_date < $end_date) <BR>
Start Date: ".$start_date."<BR>
End Date: ".$end_date."<BR>
Email Date: ".$email_date."<BR>
Result: ".$email_between_date_range_debug."<BR>";

             $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";

             } // if create report

          } // if filter_daterange

       } // end for filterbits

   # End check for date ranges
   ##########################################
   # Check for day ranges

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == 'bb105bd2-6d5d-e9b1-dc66-52ba021e1f63'){
          $filter_dayrange = $filterbits[$cntfb]['name'];
          list($start_day,$end_day) = explode("_", $filter_dayrange);
          $emailday = date("l", strtotime($date)); // Day of the email
          $emailday_date = date('Y-m-d', strtotime($date));

          #$date = date('Y-m-d H:i:s', $udate);
          $emaildate_plus_one_day = date('Y-m-d', strtotime($date .' +1 day'));
          $emaildate_plus_two_days = date('Y-m-d', strtotime($date .' +2 days'));
          $emaildate_plus_three_days = date('Y-m-d', strtotime($date .' +3 days'));
          $emaildate_plus_four_days = date('Y-m-d', strtotime($date .' +4 days'));
          $emaildate_plus_five_days = date('Y-m-d', strtotime($date .' +5 days'));
          $emaildate_plus_six_days = date('Y-m-d', strtotime($date .' +6 days'));

          $emaildate_minus_one_day = date('Y-m-d', strtotime($date .' -1 day'));
          $emaildate_minus_two_days = date('Y-m-d', strtotime($date .' -2 days'));
          $emaildate_minus_three_days = date('Y-m-d', strtotime($date .' -3 days'));
          $emaildate_minus_four_days = date('Y-m-d', strtotime($date .' -4 days'));
          $emaildate_minus_five_days = date('Y-m-d', strtotime($date .' -5 days'));
          $emaildate_minus_six_days = date('Y-m-d', strtotime($date .' -6 days'));

          if ($emailday == $start_day){
             $start_day_date = $emailday_date;
             } elseif ($start_day == date('l', strtotime($date .' -1 day'))){
             $start_day_date = $emaildate_minus_one_day;
             } elseif ($start_day == date('l', strtotime($date .' -2 days'))){
             $start_day_date = $emaildate_minus_two_days; 
             } elseif ($start_day == date('l', strtotime($date .' -3 days'))){
             $start_day_date = $emaildate_minus_three_days; 
             } elseif ($start_day == date('l', strtotime($date .' -4 days'))){
             $start_day_date = $emaildate_minus_four_days; 
             } elseif ($start_day == date('l', strtotime($date .' -5 days'))){
             $start_day_date = $emaildate_minus_five_days; 
             } elseif ($start_day == date('l', strtotime($date .' -6 days'))){
             $start_day_date = $emaildate_minus_six_days; 
             }

          # Work out the start date and then add the end date from that
          if ($end_day == $start_day){
             $end_day_date = $start_day_date;
             } elseif ($end_day == date('l', strtotime($start_day_date .' +1 day'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +1 day'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +2 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +2 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +3 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +3 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +4 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +4 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +5 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +5 days'));
             } elseif ($end_day == date('l', strtotime($start_day_date .' +6 days'))){
             $end_day_date = date('Y-m-d', strtotime($start_day_date .' +6 days'));
             }

          if ($emailday_date >= $start_day_date && $emailday_date <= $end_day_date){
             $daymatch = TRUE;
             $filterbit_touched = TRUE;
             $email_between_day_range_match = TRUE;
             $email_between_day_range_debug = "Day Range is a match!";
             $trigger_rate = $trigger_rate + 1;
             } else {
             $daymatch = FALSE;
             $email_between_day_range_match = FALSE;
             $email_between_day_range_debug = "Day Range is not a match!";
             }

          if ($create_report == TRUE){
             $inner_report .= $debugger." Filter Day Range: <B>".$filter_dayrange."</B> with ($emailday_date > $start_day_date && $emailday_date < $end_day_date) for;<BR>
Email Day: ".$emailday." = ".$emailday_date."<BR>
Start: ".$start_day." = ".$start_day_date."<BR>
End: ".$end_day." = ".$end_day_date."<BR>
Result: ".$email_between_day_range_debug."<BR>";

             $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";

             } // if create report

          } // if filter_dayrange

       } // end for filterbits

   # End check for day ranges
   ##########################################
   # Check for time AND day ranges if exists first, then if concat

   $do_datetimeconcat = FALSE;

   if ($start_time && $end_time && $start_day_date && $end_day_date){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
 
          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          if ($filterbit_configurationitemtypes_id_c == 'cc55a107-98ca-8261-9900-52ce36601cd0'){

             $filter_datetimeconcat = $filterbits[$cntfb]['name'];

             $full_start_date = $start_day_date." ".$start_time;
             $full_end_date = $end_day_date." ".$end_time;

             if ($filter_datetimeconcat == 1){
                # This is available and thus requires concat check
                $do_datetimeconcat = TRUE;
                } // if filter_datetimeconcat

             } // end if ($filterbit_configurationitemtypes_id_c

          } // end for filterbits

      if ($do_datetimeconcat == TRUE){

         $email_datetime = date('Y-m-d H:i', strtotime($date));

         if ($email_datetime >= $full_start_date && $email_datetime <= $full_end_date){
            $timedateday = TRUE;
            $email_between_datetime_range_debug = "Datetime Range is a match!";
            #if ($timematch == FALSE){
               # Matt - no idea why this was put - time can be right or wrong - irresepctive of date/day
               #$trigger_rate = $trigger_rate + 2;
             #  } else {
               $trigger_rate = $trigger_rate + 1;
              # }
            } else {
            $timedateday = FALSE;
            $email_between_datetime_range_debug = "Datetime is not a Match!";
            }

         if ($create_report == TRUE){
            $inner_report .= $debugger." We see both a Filter Date AND Time Range, so we have to put them together and see if that becomes a match: <B>if ($email_datetime > $full_start_date && $email_datetime < $full_end_date){</B><BR>
Start Date: ".$full_start_date."<BR>
End Date: ".$full_end_date."<BR>
Email Date: ".$email_datetime."<BR>
Result: ".$email_between_datetime_range_debug."<BR>";

            $inner_report .= $debugger." Total Filter Trigger Rate: ".$trigger_rate."<BR>";

            } // if create report

         } else { // end if ($do_datetimeconcat

         } 

      if ($do_datetimeconcat == FALSE && ($filter_timerange != NULL || $filter_daterange != NULL || $filter_dayrange != NULL)) { 

         $inner_report .= $debugger." No Concat checker<BR>";

         if ($daymatch == FALSE || $timematch == FALSE){

            $timedateday = FALSE;

            if ($create_report == TRUE){
               $inner_report .= $debugger." Day no match, time no match: FALSE<BR>";
               }

            } elseif ($daymatch == TRUE && $timematch == TRUE){

            $timedateday = TRUE;

            if ($create_report == TRUE){
               $inner_report .= $debugger." Day is match, time is match: TRUE<BR>";
               }

            } elseif ($daymatch == FALSE && $timematch == TRUE){

            $timedateday = FALSE;

            if ($create_report == TRUE){
               $inner_report .= $debugger." Day no match, time is match: FALSE<BR>";
               }

            } elseif ($daymatch == TRUE && $timematch == FALSE){

            $timedateday = FALSE;

            if ($create_report == TRUE){
               $inner_report .= $debugger." Day is match, time no match: FALSE<BR>";
               }

            } else {// if day and time are false then false
            $timedateday = FALSE;
            }

         } // end else if datetime check

      } elseif ($filter_timerange != NULL || $filter_daterange != NULL || $filter_dayrange != NULL) {

      # First check to see if such time rules exist before true and false check

      if ($create_report == TRUE){
         $inner_report .= $debugger." No Day and Time parts together - must see if seperately and if true/false<BR>";
         }

      if ($daymatch == TRUE && ($filter_timerange == NULL && $filter_daterange == NULL)){
     
         $timedateday = TRUE;
         $timedateday_show = "1-TRUE";

         if ($create_report == TRUE){
            $inner_report .= $debugger." IS Day Match Only:".$timedateday_show."<BR>";
            }

         } else {
         #$timedateday = "";
         $timedateday_show = "2-Nothing";

         if ($create_report == TRUE){
            $inner_report .= $debugger." No Day Match Only:".$timedateday_show."<BR>";
            }

         } // end if true


      if ($timematch == TRUE && ($filter_daterange == NULL && $filter_dayrange == NULL)){// if exist to check
       
         $timedateday = TRUE;
         $timedateday_show = "3-TRUE";

         if ($create_report == TRUE){
            $inner_report .= $debugger." IS Time Match Only:".$timedateday_show."<BR>";
            }

         } else {// end else
         #$timedateday = "";
         $timedateday_show = "4-Nothing";

         if ($create_report == TRUE){
            $inner_report .= $debugger." No Time Match Only:".$timedateday_show."<BR>";
            }

         } // end if true

      if ($datematch == TRUE && ($filter_timerange == NULL && $filter_dayrange == NULL)){// if exist to check
         $timedateday = TRUE;
         $timedateday_show = "5-TRUE";

         if ($create_report == TRUE){
            $inner_report .= $debugger." IS Time Match Only:".$timedateday_show."<BR>";
            }

         } else {// end else
         #$timedateday = "";
         $timedateday_show = "6-Nothing";

         if ($create_report == TRUE){
            $inner_report .= $debugger." No Date Match Only:".$timedateday_show."<BR>";
            }

         } // end if true

      } // end else

   $start_time = "";
   $end_time = "";
   $start_day_date = "";
   $end_day_date = "";

   # End Check for time AND day ranges
   ##########################################
   # Filters are not based on only dates
   # There must be some argument not true for dates to have any meaning.

   if ($ipservermatch == TRUE && $timedateday == TRUE){
      $beforedatesmatch = TRUE;
      }

   if ($create_report == TRUE){
      $inner_report .= $debugger." BEFORE DATE MATCH VALUE  $beforedatesmatch and timedateday: $timedateday<P>";
      }

   if ($beforedatesmatch == NULL && $beforedatesmatch != TRUE && $beforedatesmatch != FALSE){
      $beforedatesmatch = FALSE;
      }

   $timedateday_show = "";
   if ($timedateday == TRUE || $timedateday == FALSE && ($filter_timerange != NULL || $filter_daterange != NULL || $filter_dayrange != NULL)){
      if ($timedateday == TRUE && $beforedatesmatch == FALSE){
         $match = FALSE;
         $timedateday_show = "5FALSE";
         } elseif ($timedateday == TRUE && $beforedatesmatch == TRUE){
         $match = TRUE;
         $timedateday_show = "6TRUE";
         } elseif ($timedateday == FALSE && $beforedatesmatch == FALSE){
         $match = FALSE;
         $timedateday_show = "7FALSE";
         } elseif ($timedateday == FALSE && $beforedatesmatch == TRUE){
         $match = FALSE;
         $timedateday_show = "8FALSE";
         }
      } else {
      #$match = FALSE;
      #$timedateday_show = "FALSE";
      }

   if ($create_report == TRUE){
      $inner_report .= $debugger." FINAL DATE MATCH VALUE: [$timedateday] Match: [$match] $timedateday_show<P>";
      }

   if ($nostring == TRUE){
      $match = FALSE;
      }

   ##########################################
   # Trigger Count

   if ($create_report == TRUE){
      $inner_report .= $debugger." FINAL TRIGGER COUNT = ".$trigger_rate." && EXPECTED = ".$triggercount."<P>";
      }
  
   # 2016-06-18 - Changes start

   if ($trigger_rate == $triggercount && $catchall == FALSE){

      #$do_catchall = FALSE;
      #$match = FALSE;

      }

   if ($trigger_rate != $triggercount){

      #$do_catchall = FALSE;
      $match = FALSE;

      }

   # 2016-06-18 - Changes end

   # End Trigger Count
   ##########################################
   # Check for create ticket

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '1078abaa-0615-06ef-9826-52b0d6f32290'){
          $filter_createticket = $filterbits[$cntfb]['name'];
          if ($filter_createticket == 1){
             $create_ticket = TRUE;
             }

          if ($create_report == TRUE){
             $filter_createticket_show = $funky_gear->yesno($filter_createticket);
             $inner_report .= $debugger." Filter Create Ticket: <B>".$filter_createticket_show."</B><BR>";
             }

          } // if filter_createticket

       } // end for filterbits

   # End check for create ticket
   ##########################################
   # Check for create email

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){
       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '99490a5c-8f51-6652-a121-52bfac638c32'){
          $filter_createmail = $filterbits[$cntfb]['name'];

          if ($filter_createmail == 1){
             $create_email = TRUE;
             }

          if ($create_report == TRUE){
             $filter_createmail_show = $funky_gear->yesno($filter_createmail);
             $inner_report .= $debugger." Filter Create Email: <B>".$filter_createmail_show."</B><BR>";
             }

          } // if filter_createmail

       } // end for filterbits

   # End check for create email
   ###################################
   # Check for servers status as a filter item

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2'){
          $filter_trigger = $filterbits[$cntfb]['name'];

          switch ($filter_trigger){

           case 'ebf1233d-4415-a3b8-f8aa-52cee1526e02': // Multiple Servers are down 

            if ($create_report == TRUE){
               $inner_report .= $debugger." Checking if Multiple Servers are down <BR>";
               }

            if (is_array($server_pack)){

               $matchcnt=0;

               foreach ($server_pack as $filter_server_id=>$filter_server_name){
                                                       
                       # Check the server status and count them >1

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Checking for Server: <B>".$filter_server_name."</B><BR>";
                          }

                       $serverbit_object_type = "ConfigurationItems";
                       $serverbit_action = "select";
                       # parent CI will be the registered server (also a CI)
                       # not the filter as we may use this filter for other purposes
                       # The type is Live Status 1/0
                       $serverbit_type_id = '423752fe-a632-9b4d-8c3b-52ccc968fe59';
                       $serverbit_params[0] = " sclm_configurationitems_id_c='".$filter_server_id."' && sclm_configurationitemtypes_id_c='".$serverbit_type_id."' ";
                       $serverbit_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname"; // select array
                       $serverbit_params[2] = ""; // group;
                       $serverbit_params[3] = ""; // order;
                       $serverbit_params[4] = ""; // limit
  
                       $serverbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $serverbit_object_type, $serverbit_action, $serverbit_params);

                       if (is_array($serverbits)){

                          for ($srvbitcnt=0;$srvbitcnt < count($serverbits);$srvbitcnt++){
 
                              $server_status_id = $serverbits[$srvbitcnt]['id'];
                              $record_contact_id_c = $serverbits[$srvbitcnt]['contact_id_c'];
                              $server_status = $serverbits[$srvbitcnt]['name']; // 1/0

                              switch ($server_status){

                               case '':
                                $server_status_show = "NA";
                                #$matchcnt++;
                               break;
                               case '1':
                                $server_status_show = $strings["CI_ServerStatusOnline"];
                                #$matchcnt++;
                               break;
                               case '0':
                                $server_status_show = $strings["CI_ServerStatusOffline"];
                                $matchcnt++;
                               break;

                              } // switch

                              if ($create_report == TRUE){
                                 $inner_report .= $debugger." Server Status Check($matchcnt): <B>".$server_status_show."</B><BR>";
                                 }

                              } // foreach serverbits

                          } // if serverbits array

                       } // foreach server_pack

               if ($matchcnt>1){
                  $match = TRUE; //  Send out the email/ticket
                  $server_status_show = "Send out the email/ticket";
                  $trigger_rate = $trigger_rate + 1;
                  } else {
                  $match = FALSE; //  Don't Send out the email/ticket
                  $server_status_show = "Don't Send out the email/ticket";
                  } // end cnt

               if ($create_report == TRUE){
                  $inner_report .= $debugger." Server More than one is down Check: <B>".$server_status_show."</B><BR>";
                  }

               } // if server_pack array

           break; // end multiple servers

           } // switch for triggers

          } // if trigger type

       } // for filterbitsr

   # End Check for servers status as a filter item
   ##########################################
   # Check for Frequency trigger

   for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

       $filterbit_id = $filterbits[$cntfb]['id'];
       $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

       # Get triggers if some other string has been found
       if ($filterbit_configurationitemtypes_id_c == '83a83279-9e48-0bfe-3ca0-52b8d8300cc2' && $match == TRUE){
  
          $filter_trigger = $filterbits[$cntfb]['name'];

          if ($filter_trigger == '4241fe8d-450a-6ce6-87c2-52def2358317'){ // Frequency Count Match

             if ($create_report == TRUE){
                $inner_report .= $debugger." Frequency Count Match Check Started<BR>";
                }

             # Get related timestamp IF available
             $freq_ts_object_type = "ConfigurationItems";
             $freq_ts_action = "select";
             $freq_ts_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='7a454f0d-3d12-7bc5-7607-52defc746103' ";
             $freq_ts_params[1] = "id,name,description"; // select array
             $freq_ts_params[2] = ""; // group;
             $freq_ts_params[3] = ""; // order;
             $freq_ts_params[4] = ""; // limit
  
             $freq_ts_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_ts_object_type, $freq_ts_action, $freq_ts_params);

             if (is_array($freq_ts_bits)){
                for ($cnt_tsfrq=0;$cnt_tsfrq < count($freq_ts_bits);$cnt_tsfrq++){
                    $freq_timestamp = $freq_ts_bits[$cnt_tsfrq]['name']; 
                    $freq_timestamp_list = $freq_ts_bits[$cnt_tsfrq]['description']; 
                    } // for freq_bits

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Timestamp Found: <B>".$freq_timestamp."</B><BR>";
                   }

                } else {// if freq_bits array
                # Must create first timestamp to start with
                $freq_ts_params[0] = $filter_id;
                $freq_timestamp = date('Y-m-d H:i:s', strtotime($date)); // use email date
                $freq_ts_params[1] = $freq_timestamp;
                $freq_ts_params[2] = 'frequency_timestamp';
                $freq_ts_params[3] = $freq_timestamp; // accumulated list of items
                $freq_timestamp_list = $freq_timestamp;
                $freq_ts_updated = "";
                $freq_ts_updated = $funky_gear->update_items($freq_ts_params);

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Timestamp Created: <B>".$freq_timestamp."</B><BR>";
                   }

                } // else create timestamp

             # Should have timestamp - now get current count
             $freq_cnt_object_type = "ConfigurationItems";
             $freq_cnt_action = "select";
             $freq_cnt_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='c3891c31-9198-476d-0a8a-52df0e00c722' ";
             $freq_cnt_params[1] = "id,name,description"; // select array
             $freq_cnt_params[2] = ""; // group;
             $freq_cnt_params[3] = ""; // order;
             $freq_cnt_params[4] = ""; // limit
  
             $freq_cnt_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_cnt_object_type, $freq_cnt_action, $freq_cnt_params);

             if (is_array($freq_cnt_bits)){

                for ($cnt_cntfrq=0;$cnt_cntfrq < count($freq_cnt_bits);$cnt_cntfrq++){
                    $freq_curr_cnt = $freq_cnt_bits[$cnt_cntfrq]['name']; 
                    } // for freq_bits

                $firstround = FALSE;

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Count Found: <B>".$freq_curr_cnt."</B><BR>";
                   }

                } else {// if freq_bits array
                # Must create first count to start with

                $firstround = TRUE;
                $freq_cnt_params[0] = $filter_id;
                $freq_curr_cnt = 1; // start count
                $freq_cnt_params[1] = $freq_curr_cnt;
                $freq_cnt_params[2] = 'frequency_count';
                $freq_cnt_updated = "";
                $freq_cnt_updated = $funky_gear->update_items($freq_cnt_params);

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Count Created: <B>".$freq_curr_cnt."</B><BR>";
                   }

                } // else create count

             # Should have timestamp and current count - now check if within the timestamp and count range
             # First get time-span
             $freq_sp_object_type = "ConfigurationItems";
             $freq_sp_action = "select";
             $freq_sp_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='278395e9-3127-dc1c-53ac-52def9c06c63' ";
             $freq_sp_params[1] = "id,name,description"; // select array
             $freq_sp_params[2] = ""; // group;
             $freq_sp_params[3] = ""; // order;
             $freq_sp_params[4] = ""; // limit
  
             $freq_sp_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_sp_object_type, $freq_sp_action, $freq_sp_params);

             if (is_array($freq_sp_bits)){

                for ($cnt_spfrq=0;$cnt_spfrq < count($freq_sp_bits);$cnt_spfrq++){
                    $freq_timespan = $freq_sp_bits[$cnt_spfrq]['name']; 
                    } // for freq_bits

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Time-span Found: <B>".$freq_timespan."</B><BR>";
                   }

                } else {// if freq_bits array
                # If not provided - use a default - send alert...
                $freq_timespan = 30; // default

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Default Time-span Set: <B>".$freq_timespan."</B><BR>";
                   }

                } // else count range

             # First get count range
             $freq_rng_object_type = "ConfigurationItems";
             $freq_rng_action = "select";
             $freq_rng_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && sclm_configurationitemtypes_id_c='a19083b1-25bd-65be-76e8-52def587f20f' ";
             $freq_rng_params[1] = "id,name,description"; // select array
             $freq_rng_params[2] = ""; // group;
             $freq_rng_params[3] = ""; // order;
             $freq_rng_params[4] = ""; // limit
  
             $freq_rng_bits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $freq_rng_object_type, $freq_rng_action, $freq_rng_params);

             if (is_array($freq_rng_bits)){

                for ($cnt_rngfrq=0;$cnt_rngfrq < count($freq_rng_bits);$cnt_rngfrq++){
                    $freq_cnt_range = $freq_rng_bits[$cnt_rngfrq]['name']; 
                    } // for freq_bits

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Count Range Found: <B>".$freq_cnt_range."</B><BR>";
                   }

                } else {// if freq_bits array
                # If not provided - use a default - send alert...
                $freq_cnt_range = 5; // default

                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Default Count Range Set: <B>".$freq_cnt_range."</B><BR>";
                   }

                } // else count range

             #$freq_timestamp_plus_span = date("Y-m-d H:i:s", strtotime($freq_timestamp.' +$freq_timespan minutes'));
             $email_timestamp = date('Y-m-d H:i:s', strtotime($date));

             # Do the actual check based on timestamp list
             # Loop through the list of timestamps and see how many actually match the conditions
             #$lines_arr = preg_split('/\n|\r/',$freq_timestamp_list);
             $lines_arr = preg_split('/\n/',$freq_timestamp_list);
             $num_newlines = count($lines_arr);
             #$num_newlines = count( explode(PHP_EOL, $str) )

             # Must count the number of timestamps in the list that match conditions
             $listcount = 0;

             if ($num_newlines>1 && is_array($lines_arr)){

#                for ($cnt_lines=0;$cnt_lines < count($lines_arr);$cnt_lines++){
                foreach ($lines_arr as $thisfreq_timestamp){

                    #$thisfreq_timestamp = $lines_arr[$cnt_lines];
                    # Add span ans one minute for cronjob
                    $thisfreq_timespan = $freq_timespan+1;
                    #$thisfreq_timespan = " +".$thisfreq_timespan." minute"; // total time we are looking for
                    #$freq_timestamp_plus_span = date("Y-m-d H:i:s", strtotime($thisfreq_timestamp.$thisfreq_timespan));

                    $time = new DateTime($thisfreq_timestamp);
                    $time->add(new DateInterval('PT' . $thisfreq_timespan . 'M'));
                    $freq_timestamp_plus_span = $time->format('Y-m-d H:i:s');

                    # Check each timestamp to see if it matches the conditions
                    # The first one to match from the list is the new starting point to start the count
                    # Everything before that is now out of conditions
                    if ($email_timestamp <= $freq_timestamp_plus_span){

                       # This is within the span - should be counted
                       # Any new subsequent emails that match will have a timestamp added
                       # If those accumulates timestamps are within span, then we will have our jackpot!
                       $listcount = $listcount+1;

                       } else {// if email timestamp is less than the looped timestamp

                       # Any timestamps not within span have no meaning now
                       $removefromlist .= $thisfreq_timestamp."\n";

                       } // end if within timespan

                    } // end for

                } // end if array

             # Use the listcount to see if we have hit the desired count range
             # Do not have to do until after
             if ($listcount < $freq_cnt_range){

                # Not met - Update the current count of actuals
                $freq_new_cnt_params[0] = $filter_id;
                $freq_new_cnt_params[1] = $listcount;
                $freq_new_cnt_params[2] = 'frequency_count';
                $freq_new_cnt_updated = "";
                $freq_new_cnt_updated = $funky_gear->update_items($freq_new_cnt_params);

                # Add current timestamp of current email to the list
                $freq_re_params[0] = $filter_id;
                $freq_timestamp = date('Y-m-d H:i:s', strtotime($date)); // use email date
                $freq_re_params[1] = $freq_timestamp;
                $freq_re_params[2] = 'frequency_timestamp';
                # Must add to current list
                $freq_re_params[3] = $freq_timestamp_list."\n".$freq_timestamp;
                $freq_re_updated = "";
                $freq_re_updated = $funky_gear->update_items($freq_re_params);

                $freq_match = FALSE;

                } elseif ($listcount == $freq_cnt_range) {// if 

                # Has met exactly - create tickets - should never be more of actuals
                $trigger_rate = $trigger_rate + 1;
                if ($create_report == TRUE){
                   $inner_report .= $debugger." Frequency Count Matched! Beauty!!<B>Time: ".$email_timestamp." || Expected Count: ".$freq_cnt_range." || Current List Count: ".$listcount."</B><BR>";
                   }

                # Re-set the counter to 0;
                $freq_re_params[0] = $filter_id;
                $freq_curr_cnt = 0; // new count
                $freq_re_params[1] = $freq_curr_cnt;
                $freq_re_params[2] = 'frequency_count';
                $freq_re_updated = "";
                $freq_re_updated = $funky_gear->update_items($freq_re_params);

                # Re-set the timestamps to one and current;
                $freq_re_params[0] = $filter_id;
                $freq_timestamp = date('Y-m-d H:i:s', strtotime($date)); // use email date
                $freq_re_params[1] = $freq_timestamp;
                $freq_re_params[2] = 'frequency_timestamp';
                $freq_re_params[3] = $freq_timestamp; // resets list
                $freq_re_updated = "";
                $freq_re_updated = $funky_gear->update_items($freq_re_params);

                # Set as true
                $freq_match = TRUE;

                } // elseif
/*
             if ($email_timestamp <= $freq_timestamp_plus_span){
                # Check/Add a count
                if ($freq_curr_cnt < $freq_cnt_range){
                   # Not jackpot :(
                   # Add counter if not firstround
                   if ($firstround == FALSE){

                      $freq_new_cnt_params[0] = $filter_id;
                      $freq_curr_cnt++; // use email date
                      $freq_new_cnt_params[1] = $freq_curr_cnt;
                      $freq_new_cnt_params[2] = 'frequency_count';
                      $freq_new_cnt_updated = "";
                      $freq_new_cnt_updated = $funky_gear->update_items($freq_new_cnt_params);

                      } // add count

                   $freq_match = FALSE;

                   } elseif ($freq_curr_cnt >= $freq_cnt_range){ 
                     # Jackpot!! :))

                   $trigger_rate = $trigger_rate + 1;

                   if ($create_report == TRUE){
                      $inner_report .= $debugger." Frequency Count Matched! Beauty!!<B>Time: ".$email_timestamp." || Expected Count: ".$freq_cnt_range." || Current Count: ".$freq_curr_cnt."</B><BR>";
                      }

                     # Re-set the counter to 0;
                     $freq_re_params[0] = $filter_id;
                     $freq_curr_cnt = 0; // use email date
                     $freq_re_params[1] = $freq_curr_cnt;
                     $freq_re_params[2] = 'frequency_count';
                     $freq_re_updated = "";
                     $freq_re_updated = $funky_gear->update_items($freq_re_params);

                     # Set as true
                     $freq_match = TRUE;

                   } // end count check

                } elseif ($email_timestamp > $freq_timestamp_plus_span){// if over timestamp span

                  if ($create_report == TRUE){
                     $inner_report .= $debugger." Frequency Count Time Over - Re-set! Email Time ".$email_timestamp." || TimeSpan: ".$freq_timestamp_plus_span." </B><BR>";
                     }

                  # Must re-set the timestamp
                  $freq_re_params[0] = $filter_id;
                  $freq_timestamp = date('Y-m-d H:i:s', strtotime($date)); // use email date
                  $freq_re_params[1] = $freq_timestamp;
                  $freq_re_params[2] = 'frequency_timestamp';
                  $freq_re_updated = "";
                  $freq_re_updated = $funky_gear->update_items($freq_re_params);

                  # Re-set the counter to 0  - missed its chance!!
                  $freq_recnt_params[0] = $filter_id;
                  $freq_curr_cnt = 0; // use email date
                  $freq_recnt_params[1] = $freq_curr_cnt;
                  $freq_recnt_params[2] = 'frequency_count';
                  $freq_recnt_updated = "";
                  $freq_recnt_updated = $funky_gear->update_items($freq_recnt_params);

                  $freq_match = FALSE; // better luck next time!!

                } // over timestamp
*/

             if ($freq_match == TRUE){

                $match = TRUE;

                if ($create_email == TRUE){
                   $create_email = TRUE;
                   }

                if ($create_ticket == TRUE){
                   $create_ticket = TRUE;
                   }

                } else {

                $match = FALSE;
                $create_email = FALSE;
                $create_ticket = FALSE;

                }

             } // if Frequency Count Match

          } // if triggers

       } // end for filterbits

   # End Frequency trigger
   ##########################################
   # Check for create activity - only to be nullified if the ticket states so

     } // end else if do create activity

   # End check for create activity based on an email
   ##########################################
   # Catch-all must be TRUE

   if ($do_catchall == TRUE){
      $match = TRUE;
      $create_email = TRUE;
      }

   # End Catch-all
   ##########################################
   # Use Filtering Set to get Notification Templates

   if ($match == TRUE && $create_email == TRUE){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          $server_links = "";

          if ($filterbit_configurationitemtypes_id_c == 'c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d'){

             $templ_id = $filterbits[$cntfb]['name']; // actual template ID
             $templ_filter_object_type = "ConfigurationItems";
             $templ_filter_action = "select";
             $templ_filter_params[0] = " id='".$templ_id."' ";
             $templ_filter_params[1] = "id,name,description"; // select array
             $templ_filter_params[2] = ""; // group;
             $templ_filter_params[3] = ""; // order;
             $templ_filter_params[4] = ""; // limit
  
             $templ_filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $templ_filter_object_type, $templ_filter_action, $templ_filter_params);

             if (is_array($templ_filters)){

                for ($cnttmplfltr=0;$cnttmplfltr < count($templ_filters);$cnttmplfltr++){

                    $templ_name = $templ_filters[$cnttmplfltr]['name'];
                    $templ_content = $templ_filters[$cnttmplfltr]['description']; 
                    $email_content = $funky_gear->replacer("\n", "<BR>", $templ_content);

                    # Strip Title of Email based on XXXXX
                    $startcheck = "";
                    $endcheck = "";
                    $startcheck = "";
                    $endcheck = "";
                    $message_pass = "";
                    $startcheck = $funky_gear->replacer("[TITLE_START]", "", $templ_content);
                    $endcheck = $funky_gear->replacer("[TITLE_END]", "", $templ_content);
                    if ($startcheck == $templ_content || $endcheck == $templ_content){
                       # Do nothing - they don't exist
                       } else {
                       $titlestartsAt = strpos($templ_content, "[TITLE_START]") + strlen("[TITLE_START]");
                       $titleendsAt = strpos($templ_content, "[TITLE_END]", $titlestartsAt);
                       $email_title = substr($templ_content, $titlestartsAt, $titleendsAt - $titlestartsAt);
                       $templ_content = $funky_gear->replacer("[TITLE_START]", "", $templ_content);
                       $templ_content = $funky_gear->replacer("[TITLE_END]", "", $templ_content);
                       $templ_content = $funky_gear->replacer($email_title, "", $templ_content);

                       if ($create_report == TRUE){
                          $inner_report .= $debugger." Email Title: <B>".$email_title."</B><BR>";
                          }

                       } // end if title components exist

                    # General placeholders
                    #[TITLE_START] Email Title [TITLE_END]
                    #AGC-MT-009:
                    #->[DATEFROM]
                    #->[DATETO]
                    #->[VIRUS_COUNT]
                    #AGC-MT-011:
                    #->[COMPANY][CONTACT]

                    # Add email links for actual servers found
                    if (is_array($server_pack)){
                       // Create a pack of links for the email and ticket for reference
                       foreach ($server_pack as $server_filter_server_id=>$server_filter_name){
                                                        
                               $server_link = "Body@".$lingo."@ConfigurationItems@view@".$server_filter_server_id."@ConfigurationItems";
                               $server_link = $funky_gear->encrypt($server_link);
                               $server_links .= "\n".$server_filter_name.": http://".$hostname."/?pc=".$server_link;
                               }
                                                
                       } // if server array

                    if (is_array($ip_pack)){
                       #$server_replace .= $ip_show;
                       } // if server array

                    if ($server_links != NULL){
                       //$server_links .= "\n".$ip_show; // 
                       } // if server array

                    if ($server_links == NULL && $server_replace != NULL){
                       $server_links .= "\n".$server_replace;
                       }

                    if ($create_activity == TRUE){

                       $bodyarr = explode("\n", $body);
                       foreach ($bodyarr as $bodykey => $bodyvalue) {
                               $bodyarr[$bodykey] = '> ' . $bodyarr[$bodykey];
                               }

                       $body = implode("\n", $bodyarr);

                       } else { // end if activity

                       $email_title = $funky_gear->replacer("[SERVER]", $server_replace, $email_title);
                       $email_title = $email_title.": ".$subject;
                       $templ_content = $funky_gear->replacer("[SERVER]", $server_replace, $templ_content);

                       } 

                    if ($templ_content != $funky_gear->replacer("[ALERT_MESSAGE]","",$templ_content)){
                       $email_content = $funky_gear->replacer("[ALERT_MESSAGE]", $body, $templ_content);
                       } else {
                       $email_content = $email_content."\\".$body;
                       } 

                    #$email_content = str_replace("Event originator:", "Event originator:XXXXXXXXXX", $email_content);
                    #$email_content = str_replace("Event Severity:", "XXXXXXXXXXEvent Severity:", $email_content);
                    # Crude way to extract and implant the server names - assumes in above area..
                    # list($extracted_servers,$other) = explode("XXXXXXXXXX", $email_content);
                    # Use Server pack to search text
                    $bodydate_year = date('Y',strtotime($date));
                    $bodydate_month = date('m',strtotime($date));
                    $bodydate_day = date('d',strtotime($date));
                    $bodydate_hour = date('H',strtotime($date));
                    $bodydate_minute = date('i',strtotime($date));
                    $bodydate_second = date('s',strtotime($date));
                    //date('Y-m-d H:i:s'
                    if ($lingo == 'ja'){
                       $bodydate = $bodydate_year."年".$bodydate_month."月".$bodydate_day."日 ".$bodydate_hour."時".$bodydate_minute."分".$bodydate_second."秒";
                       } else {
                       $bodydate = $date;
                       }
 
                    $email_content = $funky_gear->replacer("[DATE]", $bodydate, $email_content);

                    if ($server_links != NULL){
                       $email_content .= "\n".$strings["CI_Servers"]."\n".$server_links;
                       } else {
                       $email_content .= "\nThere were no servers identified in this message\n";
                       } 

                    if ($debug == TRUE){
                       $email_content = $funky_gear->replacer("\n", "<br>", $email_content);
                       }

                    if ($create_report == TRUE){
                       $inner_report .= $debugger." Found Filter Template: <B>".$templ_name."</B><P>".$email_content."<BR>";
                       }

                    } // end templ for

                } // end templ array

             } // end templ type

          } // end for filterbits

      } // end if $create_email == TRUE

   # End get templ
   ############################################
   # Add File Attachments

   if ($match == TRUE){

      if (is_array($filespack)){

         $email_content .= "\nView raw attachments in browser:\n";

         foreach ($filespack as $fname=>$flink){
                                             
                 $email_content .= "\n".$flink;
         
                 if ($create_report == TRUE){
                    $inner_report .= $debugger." Filename: ".$fname.": ".$flink."<BR>";
                    }
         
                 } // foreach

         } // is array

      if (is_array($contentpack)){

         $email_content .= "\nView attachments as portal Content pages:\n";

         foreach ($contentpack as $fid=>$fileid){

                 $content_link = "Body@".$lingo."@Content@view@".$fid."@Content";
                 $content_link = $funky_gear->encrypt($content_link);
                 $email_content .= "\nhttp://".$hostname."/?pc=".$content_link;
 
                 } // foreach

         } // is contentarray

      } // match

   # End Add File Attachments
   ##########################################
   # Check for Recipients: TO/CC/BCC

   if ($match == TRUE && $create_email == TRUE){

      for ($cntfb=0;$cntfb < count($filterbits);$cntfb++){

          $filterbit_id = $filterbits[$cntfb]['id'];
          $filterbit_configurationitemtypes_id_c = $filterbits[$cntfb]['sclm_configurationitemtypes_id_c'];

          if ($filterbit_configurationitemtypes_id_c == 'be9692fa-5341-6934-7500-52ba77913179'){
             $recipient_to_id = $filterbits[$cntfb]['name'];

             $recip_to_object_type = "ConfigurationItems";
             $recip_to_action = "select";
             $recip_to_params[0] = " id='".$recipient_to_id."' ";
             $recip_to_params[1] = "id,name,description"; // select array
             $recip_to_params[2] = ""; // group;
             $recip_to_params[3] = ""; // order;
             $recip_to_params[4] = ""; // limit
  
             $recip_tos = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_to_object_type, $recip_to_action, $recip_to_params);

             if (is_array($recip_tos)){

                for ($cntrecpto=0;$cntrecpto < count($recip_tos);$cntrecpto++){

                    $recp_to_name = $recip_tos[$cntrecpto]['name'];
                    $recp_to_list = $recip_tos[$cntrecpto]['description']; 

                    if ($create_report == TRUE){
                       $inner_report .= $debugger." Filter Recipient TO: <B>".$recp_to_name."</B> List: [".$recp_to_list."]<BR>";
                       }

                    } // end recipient_to_id for

                } // end recipient_to_id array

             } // if recipient_to_id

             # Check for Recipients: CC

          if ($filterbit_configurationitemtypes_id_c == '45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0'){
             $recipient_cc_id = $filterbits[$cntfb]['name'];

             $recip_cc_object_type = "ConfigurationItems";
             $recip_cc_action = "select";
             $recip_cc_params[0] = " id='".$recipient_cc_id."' ";
             $recip_cc_params[1] = "id,name,description"; // select array
             $recip_cc_params[2] = ""; // group;
             $recip_cc_params[3] = ""; // order;
             $recip_cc_params[4] = ""; // limit
  
             $recip_ccs = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_cc_object_type, $recip_cc_action, $recip_cc_params);

             if (is_array($recip_ccs)){

                for ($cntrecpcc=0;$cntrecpcc < count($recip_ccs);$cntrecpcc++){

                    $recp_cc_name = $recip_ccs[$cntrecpcc]['name'];
                    $recp_cc_list = $recip_ccs[$cntrecpcc]['description']; 

                    if ($create_report == TRUE){
                       $inner_report .= $debugger." Filter Recipient CC: <B>".$recp_cc_name."</B> List: [".$recp_cc_list."]<BR>";
                       }

                    } // end recipient_cc_id for

                } // end recipient_cc_id array

             } // if recipient_cc_id

             # Check for Recipients: BCC

          if ($filterbit_configurationitemtypes_id_c == '47e1b49f-4059-3d14-94c7-52ba7891d1b5'){
             $recipient_bcc_id = $filterbits[$cntfb]['name'];

             $recip_bcc_object_type = "ConfigurationItems";
             $recip_bcc_action = "select";
             $recip_bcc_params[0] = " id='".$recipient_bcc_id."' ";
             $recip_bcc_params[1] = "id,name,description"; // select array
             $recip_bcc_params[2] = ""; // group;
             $recip_bcc_params[3] = ""; // order;
             $recip_bcc_params[4] = ""; // limit
  
             $recip_bccs = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $recip_bcc_object_type, $recip_bcc_action, $recip_bcc_params);

             if (is_array($recip_bccs)){

                for ($cntrecpbcc=0;$cntrecpbcc < count($recip_bccs);$cntrecpbcc++){

                    $recp_bcc_name = $recip_bccs[$cntrecpbcc]['name'];
                    $recp_bcc_list = $recip_bccs[$cntrecpbcc]['description']; 

                    if ($create_report == TRUE){
                       $inner_report .= $debugger." Filter Recipient BCC: <B>".$recp_bcc_name."</B> List: [".$recp_bcc_list."]<BR>";
                       }

                    } // end recipient_bcc_id for

                } // end recipient_bcc_id array

             } // if recipient_bcc_id

          } // end for filterbits

      } // end if $create_email == TRUE

   # End check for recipient_to_id
   ##########################################
   # Actions to take before closing loop for each filter

   if ($create_report == TRUE){
      $inner_report .= $debugger." Total Filter Hit-Rate=<font color=red size=5><B>".$filterbit_rate."</B></font><BR>";
      }

   $subject = mb_convert_encoding($subject, 'UTF-8', 'UTF-8');

   # Create Ticket if Match and TRUE
   ###################################
   # Check if this is a response to an existing ticket - should add activity

   if ($match == TRUE && ($create_ticket == TRUE || $create_activity == TRUE)){

      # Create a ticket - get ticket ID
      $config_object_type = 'ConfigurationItems';
      $config_action = "select";
#      $config_params[0] = " sclm_configurationitemtypes_id_c='6cc00767-12da-3666-9081-52826ae1cea5' && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
      $config_params[0] = " sclm_configurationitemtypes_id_c='6cc00767-12da-3666-9081-52826ae1cea5' && account_id_c='".$portal_account_id."'";
 
      $config_params[1] = "id,sclm_configurationitems_id_c,name"; // select array
      $config_params[2] = ""; // group;
      $config_params[3] = " name, date_entered DESC "; // order;
      $config_params[4] = ""; // limit
  
      $config_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $config_object_type, $config_action, $config_params);

      if (is_array($config_items)){

         for ($configcnt=0;$configcnt < count($config_items);$configcnt++){
            
             # $id = $config_items[$configcnt]['id'];
             $ticket_id = $config_items[$configcnt]['name'];

             if ($create_report == TRUE){
                $inner_report .= $debugger." TicketActivity ID: ".$ticket_id."<BR>";
                }

             } // end for

         } else {// end if
         $ticket_id = "[SDaaS+AMS]";
         } 

      if ($create_report == TRUE){
         $inner_report .= $debugger." Create Ticket/Activity<BR>";
         }

      if ($sclm_serviceslarequests_id_c){

         $svcslar_object_type = 'ServiceSLARequests';
         $svcslar_action = "select";
         $svcslar_params[0] = " id ='".$sclm_serviceslarequests_id_c."' ";
         $svcslar_params[1] = ""; // select array
         $svcslar_params[2] = ""; // group;
         $svcslar_params[3] = ""; // order;
         $svcslar_params[4] = ""; // limit

         $svcslar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $svcslar_object_type, $svcslar_action, $svcslar_params);

         if (is_array($svcslar_items)){

            for ($svcslarcnt=0;$svcslarcnt < count($svcslar_items);$svcslarcnt++){

                $sclm_services_id_c = $svcslar_items[$svcslarcnt]['sclm_services_id_c'];
                $account_id_c = $svcslar_items[$svcslarcnt]['account_id_c'];
                $contact_id_c = $svcslar_items[$svcslarcnt]['contact_id_c'];
                $cmn_statuses_id_c = $svcslar_items[$svcslarcnt]['cmn_statuses_id_c'];
                $sclm_servicessla_id_c = $svcslar_items[$svcslarcnt]['sclm_servicessla_id_c'];
                $sclm_accountsservices_id_c = $svcslar_items[$svcslarcnt]['sclm_accountsservices_id_c'];
                $sclm_accountsservicesslas_id_c = $svcslar_items[$svcslarcnt]['sclm_accountsservicesslas_id_c'];
                $project_id_c = $svcslar_items[$svcslarcnt]['project_id_c'];
                $projecttask_id_c = $svcslar_items[$svcslarcnt]['projecttask_id_c'];
                $sclm_sowitems_id_c = $svcslar_items[$svcslarcnt]['sclm_sowitems_id_c'];
                $sclm_sla_id_c = $svcslar_items[$svcslarcnt]['sclm_sla_id_c'];

                } // for svcslar_items

            } // is array svcslar_items

         } // if sla

      $email_content = $funky_gear->replacer("</ br>", '', $email_content);
      $email_content = $funky_gear->replacer("</br>", '', $email_content);
      #$email_content = $funky_gear->replacer("<br>", "", $email_content);
      #$email_content = $funky_gear->replacer("<br>", '\n', $email_content);
      $email_content = $funky_gear->replacer("<br />",'\n',$email_content);
      $email_content = $funky_gear->replacer("<BR>", '\n', $email_content);

      $email_title = $funky_gear->replacer("</ br>", "", $email_title);
      $email_title = $funky_gear->replacer("</br>", "", $email_title);
      $email_title = $funky_gear->replacer("<br />", "", $email_title);
      $email_title = $funky_gear->replacer("<br>", "", $email_title);

      #if ($create_activity == TRUE && $create_activity_email_ticket_id != NULL){
      if ($create_activity == TRUE){
         # Create Activity
         #$ticket_date = date("Y-m-d-H-i-s");
         #$ticket_id = $ticket_id.$ticket_date;

         $email_title = $subject;

         #$email_title = $funky_gear->replacer("[TICKET]", $create_activity_email_ticket_id, $email_title);
         $email_content = $funky_gear->replacer("[TICKET]", $create_activity_email_ticket_id, $email_content);
         if (!$email_content){
            $email_content = $email_title;
            }

         $autoupdate = $date." - Auto-reply ticket activity update";

         $act_process_object_type = "TicketingActivities";
         $act_process_action = "update";

         $act_process_params = array();  
         $act_process_params[] = array('name'=>'name','value' => $email_title);
         $act_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $act_process_params[] = array('name'=>'description','value' => $email_content);
         $act_process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $sclm_serviceslarequests_id_c);
         $act_process_params[] = array('name'=>'date_entered','value' => $date);
         $act_process_params[] = array('name'=>'date_modified','value' => $date);
         $act_process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
         $act_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
         $act_process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $create_activity_ticket_id);
         #$tick_process_params[] = array('name'=>'service_operation_process','value' => $_POST['service_operation_process']);
         $act_process_params[] = array('name'=>'accumulated_minutes','value' => 0);
         #$act_process_params[] = array('name'=>'status','value' => $create_activity_email_ticket_status);
         $act_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
         $act_process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
         $act_process_params[] = array('name'=>'filter_id','value' => $filter_id);
         $act_process_params[] = array('name'=>'ticket_update','value' => $autoupdate);

         #$act_process_params[] = array('name'=>'to_addressees','value' => );
         #$act_process_params[] = array('name'=>'cc_addressees','value' => );
         #$act_process_params[] = array('name'=>'bcc_addressees','value' => $_POST['bcc_addressees']);
         $act_process_params[] = array('name'=>'extra_addressees','value' => $from_mailname.",".$received_to);
         $act_process_params[] = array('name'=>'extra_addressees_cc','value' => $received_cc);
         #$act_process_params[] = array('name'=>'extra_addressees_bcc','value' => $_POST['extra_addressees_bcc']);

         if ($create_report == TRUE){
            $inner_report .= $debugger." About to create Ticket Activity<BR>";
            }

         if ($debug == TRUE){
            # Do nothing
            } else {
            $act_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $act_process_object_type, $act_process_action, $act_process_params);                                                    

            }
      
         if ($act_result['id'] != NULL){
            $sclm_ticketingactivities_id_c = $act_result['id'];

            $message_link = "Body@".$lingo."@TicketingActivities@view@".$sclm_ticketingactivities_id_c."@TicketingActivities";
            $message_link = $funky_gear->encrypt($message_link);
            $message_link = "http://".$hostname."/?pc=".$message_link;

            }

         } else {

         ###########################
         # Create Ticket

         $ticket_date = date("Y-m-d_H-i-s",strtotime($date));
         #$ticket_id = $ticket_date;

         $email_title = $funky_gear->replacer("[TICKET]", $ticket_date, $email_title);
         $email_content = $funky_gear->replacer("[TICKET]", $ticket_date, $email_content);

         if ($email_title == NULL){
            $email_title = $ticket_id."[".$ticket_date."]".$subject;
            } 

         if ($email_content == NULL){
            $email_content = $body;
            }

         $tick_process_object_type = "Ticketing";
         $tick_process_action = "update";

         $tick_process_params = array();  
         $tick_process_params[] = array('name'=>'name','value' => $email_title);
         $tick_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
         $tick_process_params[] = array('name'=>'description','value' => $email_content);
         #$tick_process_params[] = array('name'=>'deleted','value' => $_POST['deleted']);
         $tick_process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $sclm_serviceslarequests_id_c);
         $tick_process_params[] = array('name'=>'date_entered','value' => $date);
         $tick_process_params[] = array('name'=>'date_modified','value' => $date);

         $tick_process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
         $tick_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
         #$tick_process_params[] = array('name'=>'account_id1_c','value' => $_POST['account_id1_c']);
         #$tick_process_params[] = array('name'=>'contact_id1_c','value' => $_POST['contact_id1_c']);
         #$tick_process_params[] = array('name'=>'service_operation_process','value' => $_POST['service_operation_process']);
         $tick_process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
         $tick_process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
         $tick_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
         $tick_process_params[] = array('name'=>'ticket_id','value' => $ticket_date);
         $tick_process_params[] = array('name'=>'ticket_source','value' => '544567e9-f0e5-85a0-8d85-52b0e7704312');
         $tick_process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $filter_server_id);
         $tick_process_params[] = array('name'=>'accumulated_minutes','value' => 0);
         $tick_process_params[] = array('name'=>'status','value' => $status);
         $tick_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
         $tick_process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
         $tick_process_params[] = array('name'=>'filter_id','value' => $filter_id);
         $tick_process_params[] = array('name'=>'extra_addressees','value' => $from_mailname.",".$received_to);
         $tick_process_params[] = array('name'=>'extra_addressees_cc','value' => $received_cc);
         #$tick_process_params[] = array('name'=>'extra_addressees_bcc','value' => $received_bcc);

         if ($create_report == TRUE){
            $inner_report .= $debugger." About to create Ticket<BR>";
            }

         if ($debug == TRUE){
            # Do nothing
            } else {
            # Try to stop duplications
            if ($previous_ticket != $ticket_date){

               $tick_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $tick_process_object_type, $tick_process_action, $tick_process_params);

               } // if previous_ticket

            } // if debug
      
         if ($tick_result['id'] != NULL){

            $sclm_ticketing_id_c = $tick_result['id'];

            $message_link = "Body@".$lingo."@Ticketing@view@".$sclm_ticketing_id_c."@Ticketing";
            $message_link = $funky_gear->encrypt($message_link);
            $message_link = "http://".$hostname."/?pc=".$message_link;

            } # $tick_result['id'] != NULL

         } // ticket or activity

      } // end if ($match == TRUE && $create_ticket == TRUE)

   # End ticket or activity
   ###############################
   # Move email to ticketed folder

   $debug_filter_folder = "";
   $debug_ticket_folder = "";

   if ($create_ticket == TRUE || $create_activity == TRUE){
      #$create_email = TRUE;
      }

   if ($debug == TRUE && $create_ticket == TRUE && $create_activity == FALSE && (($match == TRUE && ($trigger_rate >= $triggercount)) || $do_catchall)){
   #if ($debug == TRUE && $create_ticket == TRUE && $create_activity == FALSE && ($match == TRUE || $do_catchall)) {// if debug for moving emails

      $debug_filter_folder = "Development/Test-In";
      $debug_ticket_folder = "Development/Test-Auto-Ticket";

      if ($do_catchall == TRUE){
         $debug_ticket_folder = "Development/Test-Auto-Michi";
         }

      } elseif ($debug == TRUE && $create_activity == TRUE && $match == TRUE){

      $debug_filter_folder = "Development/Test-In";
      $debug_ticket_folder = "Development/Test-Auto-Activity";

      } elseif ($debug == TRUE && $create_ticket == FALSE && $create_activity == FALSE && $match == TRUE && ($trigger_rate >= $triggercount)){

      $debug_filter_folder = "Development/Test-In";
      $debug_ticket_folder = "Development/Test-Auto-Mushi";

      $mushi = TRUE;

      #echo $inner_report;
      #echo "<P>";
      #exit;

      } else {

      $catchall = TRUE;

      #$debug_filter_folder = "Development/Test-In";
      #$debug_ticket_folder = "Development/Test-Auto-Michi";

      }

   if ($debug_filter_folder != NULL && $debug_ticket_folder != NULL){

      $portal_imap_port = "993";
      $portal_imap_server = "imap.gmail.com";

      $moveparams[0] = $portal_imap_port;
      $moveparams[2] = $portal_imap_server;
      $moveparams[3] = $debug_filter_folder;
      $moveparams[4] = $debug_ticket_folder;
      $moveparams[5] = $email_id;
      $moveparams[6] = $portal_email;
      $moveparams[7] = $portal_email_password;
      $moveparams[8] = $inner_report;
      $moveparams[9] = $create_report;

      $inner_report = $funky_gear->move_emails($moveparams);

      if ($debug_ticket_folder == "Development/Test-Auto-Mushi"){
         #break1;
         }

      } // $debug_filter_folder != NULL && $debug_ticket_folder != NULL)

   # End debug filer
   ###############################
   # Move auto email to ticketed folder

   if ($debug != TRUE){
      $real_filter_folder = "";
      $real_ticket_folder = "";
      $catchall = FALSE;
      }

   if ($debug != TRUE && $create_ticket == TRUE && $create_activity == FALSE && (($match == TRUE && ($trigger_rate >= $triggercount)) || $do_catchall)){
   #if ($debug != TRUE && $create_ticket == TRUE && $create_activity == FALSE && ($match == TRUE || $do_catchall)) {// if debug for moving emails

      $real_filter_folder = "Admin/0 - Auto-Filtered";
      $real_ticket_folder = "Admin/0 - Auto-Tickets";

      if ($do_catchall == TRUE){
         $real_ticket_folder = "Admin/0 - Auto-Michi";
         }

      } elseif ($debug != TRUE && $create_activity == TRUE && $match == TRUE) {// if debug for moving emails

      $real_filter_folder = "Admin/0 - Auto-Filtered";
      $real_ticket_folder = "Admin/0 - Auto-Activities";

      } elseif ($debug != TRUE && $create_ticket == FALSE && $create_activity == FALSE && $match == TRUE && ($trigger_rate >= $triggercount)){

      $real_filter_folder = "Admin/0 - Auto-Filtered";
      $real_ticket_folder = "Admin/0 - Auto-Mushi";

       #echo $inner_report;

      $mushi = TRUE;

      } else {

       # Not picked up by anything but still found its way to this end point - must call it catch-all if available.
       $catchall = TRUE;

       #$real_filter_folder = "Admin/0 - Auto-Filtered";
       #$real_ticket_folder = "Admin/0 - Auto-Michi";

      }


   if ($real_filter_folder != NULL && $real_ticket_folder != NULL){

      ###############################
      # Move email to ticketed folder

      $portal_imap_port = "993";
      $portal_imap_server = "imap.gmail.com";

      $moveparams[0] = $portal_imap_port;
      $moveparams[2] = $portal_imap_server;
      $moveparams[3] = $real_filter_folder;
      $moveparams[4] = $real_ticket_folder;
      $moveparams[5] = $email_id;
      $moveparams[6] = $portal_email;
      $moveparams[7] = $portal_email_password;
      $moveparams[8] = $inner_report;
      $moveparams[9] = $create_report;

      $inner_report = $funky_gear->move_emails($moveparams);

      if ($real_ticket_folder == "Admin/0 - Auto-Mushi"){
         #break1;
         }

      } // end if debug and move

   if ($debug == TRUE && $mushi == TRUE){

      #echo $inner_report;
      #echo "<P>";
      #var_dump($filterbit_params); 
      #exit;

      }

   # End move email
   ###############################
   # Prepare Emails
   # If this is a response to an existing ticket - should add activity

   if ($match == TRUE && $create_email == TRUE){

      $type = 1;

      $from_name = $portal_title;
      $from_email = $portal_email;
      $from_email_password = $portal_email_password;

      # To send based on sla lists before filter lists

      if ($sclm_serviceslarequests_id_c){

         if ($create_report == TRUE){
            $inner_report .= $debugger." Have Service SLA Request - to get notifiees. ID: ".$sclm_serviceslarequests_id_c."<BR>";
            }

         $cnotifications_object_type = "ContactsNotifications";
         $cnotifications_action = "select";
         $cnotifications_params[0] = " sclm_serviceslarequests_id_c='".$sclm_serviceslarequests_id_c."' && cmn_statuses_id_c='".$standard_statuses_open_public."' ";
         $cnotifications_params[1] = ""; // select array
         $cnotifications_params[2] = ""; // group;
         $cnotifications_params[3] = ""; // order;
         $cnotifications_params[4] = ""; // limit
  
         $cnotifications = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $cnotifications_object_type, $cnotifications_action, $cnotifications_params);

         if (is_array($cnotifications)){

            for ($cnt=0;$cnt < count($cnotifications);$cnt++){

                $notify_contact_id_c = $cnotifications[$cnt]['contact_id_c'];

                $contact_object_type = "Contacts";
                $contact_action = "select_soap";
                $contact_params = array();
                $contact_params[0] = "contacts.id='".$notify_contact_id_c."'"; // query
                $contact_params[1] = array("first_name","last_name","email1");
                #$contact_params[1] = array("email1");

                $contact_info = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
     
                for ($cnt=0;$cnt < count($contact_info);$cnt++){

                    $first_name = $contact_info[$cnt]['first_name'];
                    $last_name = $contact_info[$cnt]['last_name'];
                    $to_email = $contact_info[$cnt]['email1'];
                    $to_name = $first_name." ".$last_name;
                    $internal_to_addressees[$to_email] = $to_name;

                    } // end for contact info

                } // end for cnotifications

            } // end is_array($cnotifications

         } else {// end if sclm_serviceslarequests_id_c to get 

         $inner_report .= $debugger." Has NO Service SLA Request - will not send to any notifiees. <BR>";

         } // no sla - no notifications

      # Get lists found
      if ($recp_to_list != NULL){
         $recp_to_array = explode(',',$recp_to_list); //split string into array seperated by ','
         foreach ($recp_to_array as $recp_to_value){
                 $to_addressees[$recp_to_value] = $recp_to_value;
                 }
         } // end if recp_cc_list

      if ($recp_cc_list != NULL){
         $recp_cc_array = explode(',',$recp_cc_list); //split string into array seperated by ','
         foreach ($recp_cc_array as $recp_cc_value){
                 $cc_addressees[$recp_cc_value] = $recp_cc_value;
                 }
         } // end if recp_cc_list

      if ($recp_bcc_list != NULL){
         $recp_bcc_array = explode(',',$recp_bcc_list); //split string into array seperated by ','
         foreach ($recp_bcc_array as $recp_bcc_value){
                 $bcc_addressees[$recp_bcc_value] = $recp_bcc_value;
                 }
         } // end if recp_bcc_list

      # End Preparing recipients
      #########################################
      # Build Email

      $mailparams[0] = $from_name;
      #$mailparams[1] = $to_name;
      $mailparams[2] = $from_email;
      $mailparams[3] = $from_email_password;
      #$mailparams[4] = $to_email;
      $mailparams[5] = $type;
      $mailparams[6] = $lingo;
      $email_title = $funky_gear->replacer("<br>", '', $email_title);
      $mailparams[7] = $email_title;
      # may have to remove <BR> with \n
      $email_content = $funky_gear->replacer("<br>", '\n', $email_content);
      $email_content = $funky_gear->replacer("<BR>", '\n', $email_content);
      #$email_content = $funky_gear->replacer("<BR>", '', $email_content);
      $email_content = $funky_gear->replacer("<br />", '\n', $email_content);
      $email_content = $funky_gear->replacer("&nbsp;",'',$email_content);

      # Catch-all report
      if ($addreport == TRUE){
         #$inner_report = $final_message;
         }
      #$mailparams[8] = $email_content."\n".$strings["action_view_here"].":\n".$message_link."\n".$inner_report;
      $mailparams[8] = $email_content."\n".$strings["action_view_here"].":\n".$message_link."\n";
      $mailparams[9] = $portal_email_server;
      $mailparams[10] = $portal_email_smtp_port;
      $mailparams[11] = $portal_email_smtp_auth;

      if ($create_report == TRUE){
$inner_report .= $debugger." Send Email out to recipients Ticket<P>
Email sent with newly created Ticket<BR>
To: ".$recp_to_list."<BR>
CC: ".$recp_cc_list."<BR>
BCC: ".$recp_bcc_list."<BR>
From: ".$from_name." Email: ".$from_email."<BR>
Type: ".$type."<BR>
Lingo: ".$lingo."<BR>
Portal Email Server: ".$portal_email_server."<BR>
Subject: ".$mailparams[7]."<BR>Body:".$email_content."<BR>";
         }

      if ($debug == TRUE){

         # Do nothing
 
         } else {

         if ($previous_title != $email_title){

            if ($sclm_serviceslarequests_id_c && is_array($internal_to_addressees)){

               $mailparams[12] = "";
               $mailparams[12] = $internal_to_addressees; // array
               $emailresult = $funky_gear->do_email ($mailparams);
 
               }

            if (is_array($to_addressees)){

               $mailparams[12] = "";
               $mailparams[12] = $to_addressees; // array
               $mailparams[13] = $cc_addressees; // array
               $mailparams[14] = $bcc_addressees; // array

               $emailresult = $funky_gear->do_email ($mailparams);

               } // TO/CC/BCC

            } // if title not same

         } // end if not debugging

      } // ($match == TRUE && $create_email == TRUE){

   # End Preparing recipients
   #########################################
   # Check create_activity

   if ($create_report == TRUE){
      $inner_report .= $debugger." Check create_activity ($create_activity == TRUE) && create_activity_ticket_id ($create_activity_ticket_id != NULL)<BR>";
      }

   if ($create_activity == TRUE && $create_activity_ticket_id != NULL){
      # Check to see if an email exists with the parent ticket
      $sclm_ticketing_id_c = $create_activity_ticket_id;

      $check_email_object_type = 'Emails';
      $check_email_action = "select";
      $check_email_params[0] = " sclm_ticketing_id_c='".$create_activity_ticket_id."' ";
      $check_email_params[1] = "id,name,sclm_ticketing_id_c"; // select array
      $check_email_params[2] = ""; // group;
      $check_email_params[3] = ""; // order;
      $check_email_params[4] = ""; // limit
  
      $check_email = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $check_email_object_type, $check_email_action, $check_email_params);

      if (is_array($check_email)){
   
         for ($chkmlcnt=0;$chkmlcnt < count($check_email);$chkmlcnt++){

             $sclm_emails_id_c = $check_email[$chkmlcnt]['id'];
             $sclm_emails_name = $check_email[$chkmlcnt]['name'];

             if ($create_report == TRUE){
                $inner_report .= $debugger." Found Parent Email [".$sclm_emails_name."]<BR>";  
                }

             } // end for

         } // end is array

      } // end if activity

   # End Preparing recipients
   #########################################
   #Create/Activity

   if ($match == TRUE && ($create_ticket == TRUE || $create_activity == TRUE)){
      # Store Email Locally

      if ($create_report == TRUE){
         $inner_report .= $debugger." Store Email Content Locally<BR>"; 
         }

      $process_object_type = "Emails";
      $process_action = "update";
      $process_params[] = array('name'=>'name','value' => $subject);
      $process_params[] = array('name'=>'date_entered','value' => $date);
      $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
      $process_params[] = array('name'=>'description','value' => $body);
      $process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
      $process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
      $process_params[] = array('name'=>'message_id','value' => $message_id);
      $process_params[] = array('name'=>'sender','value' => $from_mailname);
      $process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
      $process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
      $process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
      $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
      $process_params[] = array('name'=>'encode','value' => $encode);
      $process_params[] = array('name'=>'original_date','value' => $udate);
      $process_params[] = array('name'=>'receiver','value' => $portal_email);
      $process_params[] = array('name'=>'message_number','value' => $message_number);
      $process_params[] = array('name'=>'sclm_serviceslarequests_id_c','value' => $sclm_serviceslarequests_id_c);
      $process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $sclm_ticketing_id_c);
      $process_params[] = array('name'=>'sclm_ticketingactivities_id_c','value' => $sclm_ticketingactivities_id_c);
      $process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);
      $process_params[] = array('name'=>'filter','value' => $filter_id);
      $process_params[] = array('name'=>'filter_id','value' => $filter_id);

      if ($create_report == TRUE){
         $inner_report .= $debugger." Skipped storing email<BR>"; 
         }

      if ($debug == TRUE){

         # Do nothing

         } else {

         if ($previous_subject != $subject){

            $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

            if ($result['id'] != NULL){

               $sclm_emails_id_c = $result['id'];

               if ($create_activity == TRUE){

                  $act_process_object_type = "TicketingActivities";
                  $act_process_action = "update";
                  $act_process_params = array(); 
                  $act_process_params[] = array('name'=>'id','value' => $sclm_ticketingactivities_id_c); 
                  $act_process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);

                  $act_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $act_process_object_type, $act_process_action, $act_process_params);       

                  } elseif ($create_ticket == TRUE) {
                  $tick_process_object_type = "Ticketing";
                  $tick_process_action = "update";
                  $tick_process_params = array(); 
                  $tick_process_params[] = array('name'=>'id','value' => $sclm_ticketing_id_c); 
                  $tick_process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);

                  $tick_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $tick_process_object_type, $tick_process_action, $tick_process_params);
                  }

               }

            } // end if no duplicate

         # Add the Ticketing info to the Content - attached file

         if (is_array($contentpack)){

            $attach_cit_relater_object_type = "ConfigurationItems";
            $attach_cit_relater_action = "update";

            # Prepare the pack of params for use with all attachments if added
            $attach_cit_relater_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
            $attach_cit_relater_params[] = array('name'=>'account_id_c','value' => $account_id_c);
            $attach_cit_relater_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
            $attach_cit_relater_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => '36727261-b9ce-9625-2063-54bf15bb668b');
            #$attach_cit_relater_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['sclm_configurationitems_id_c']);
            $attach_cit_relater_params[] = array('name'=>'cmn_statuses_id_c','value' => $cmn_statuses_id_c);
            $attach_cit_relater_params[] = array('name'=>'project_id_c','value' => $project_id_c);
            $attach_cit_relater_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
            #$attach_cit_relater_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
            $attach_cit_relater_params[] = array('name'=>'sclm_sow_id_c','value' => $sclm_sow_id_c);
            $attach_cit_relater_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
            $attach_cit_relater_params[] = array('name'=>'enabled','value' => 1);

            $file_process_object_type = "Content";
            $file_process_action = "update";

            foreach ($contentpack as $fid=>$fileid){

                    $file_process_params[] = array('name'=>'id','value' => $fid);
                    $file_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
                    $file_process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
                    $file_process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
                    $file_process_params[] = array('name'=>'sclm_sow_id_c','value' => $sclm_sow_id_c);
                    $file_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
                    #$file_process_params[] = array('name'=>'sclm_messages_id_c','value' => $sclm_messages_id_c);
                    $file_process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);
                    #$file_process_params[] = array('name'=>'content_url','value' => $content_url);
                    #$file_process_params[] = array('name'=>'content_thumbnail','value' => $content_thumbnail);
                    $file_process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $sclm_ticketing_id_c);
                    $file_process_params[] = array('name'=>'sclm_ticketingactivities_id_c','value' => $sclm_ticketingactivities_id_c);

                    $file_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $file_process_object_type, $file_process_action, $file_process_params);

                    $attach_object_type = "Content";
                    $attach_action = "select";
                    $attach_params[0] = " id = '".$fid."' ";
                    $attach_params[1] = "id,name,content_thumbnail,content_url,account_id_c"; // select array
                    $attach_params[2] = ""; // group;
                    $attach_params[3] = " name ASC "; // order;
                    $attach_params[4] = ""; // limit
                    $attach_params[5] = $lingoname; // lingo
  
                    $attach_items = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $attach_object_type, $attach_action, $attach_params);

                    if (is_array($attach_items)){

                       # Build a list of items to work out the URL      
                       for ($dropcnt=0;$dropcnt < count($attach_items);$dropcnt++){

                           $za_id = $attach_items[$dropcnt]["id"];
                           $za_title = $attach_items[$dropcnt]["name"];

                           $za_image = $attach_items[$dropcnt]["content_thumbnail"];
                           $content_type_image = $attach_items[$dropcnt]['content_type_image'];

                           if (!$za_image){

                              if ($content_type_image != NULL){
                                 $za_image = $content_type_image;
                                 } else {
                                 $za_image = "images/icons/page.gif";
                                 }

                              } # if no image

                          } # for

                       } # is array

                    if ($create_ticket == TRUE){
                       $attach_cit_relater = "Ticketing_".$sclm_ticketing_id_c."_".$fid;
                       } else {
                       $attach_cit_relater = "TicketingActivities_".$sclm_ticketingactivities_id_c."_".$fid;
                       }

                    $attach_cit_relater_params[] = array('name'=>'name','value' => $attach_cit_relater);
                    $attach_cit_relater_params[] = array('name'=>'description','value' => $attach_cit_relater);
                    $attach_cit_relater_params[] = array('name'=>'image_url','value' => $za_image);

                    $attach_cit_relater_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $attach_cit_relater_object_type, $attach_cit_relater_action, $attach_cit_relater_params);

                    } // foreach

            } // is contentarray

         } // end if no debug

      } // end if $create_mail == TRUE)

   # End Create Ticket if Match and TRUE
   # End Actions to take before closing loop for each filter
   #########################################
   # Whatever rule combinations are producing catch-alls incorrectly should be here to avoide erronious catch-alls

   if ($catchall == TRUE){
      $inner_report .= $debugger."<P> DO perform catch-all - filters missed or ignored this and must be checked..<P>";
      } else {
      $catchall = FALSE; // will result in false, but not a stray email to send in
      }

   if ($debug == TRUE){

/*
      # Try to output the results in real-time
      # http://manzzup.blogspot.jp/2013/11/real-time-updating-of-php-output-using.html
      // Turn off output buffering
      ini_set('output_buffering', 'off');
      // Turn off PHP output compression
      ini_set('zlib.output_compression', false);
         
      //Flush (send) the output buffer and turn off output buffering
      while (@ob_end_flush());
         
      // Implicitly flush the buffer(s)
      ini_set('implicit_flush', true);
      ob_implicit_flush(true);

      echo str_repeat(" ", 256);
      echo $inner_report;
      echo str_pad("",2048," ");

      echo "<br />";

      ob_flush();
      flush();
*/

      } # end debug real-time output

   $previous_ticket = $ticket_date;
   $previous_title = $email_title;
   $previous_subject = $subject;

   $filterbit_returner[0] = $report."<P>".$inner_report;
   $filterbit_returner[1] = $match;
   $filterbit_returner[2] = $create_mail;
   $filterbit_returner[3] = $create_ticket;
   $filterbit_returner[4] = $create_activity;
   $filterbit_returner[5] = $catchall;
   $filterbit_returner[6] = $previous_ticket;
   $filterbit_returner[7] = $previous_title;
   $filterbit_returner[8] = $previous_subject;
   $filterbit_returner[9] = $trigger_rate;
   $filterbit_returner[10] = $triggercount;
   $filterbit_returner[11] = $mushi;

  return $filterbit_returner;

 } // end do_filterbits function

# End Do Filterbits
##################################################################################
# Do Filters (Filterstart)

 function do_filters ($params){

  mb_language('uni');
  mb_internal_encoding('UTF-8');

  if (!function_exists('get_param')){
     include ("common.php");
     }

  global $funky_gear,$assigned_user_id,$portal_email_server,$portal_account_id,$portal_email_password,$portal_email,$portal_title,$hostname,$db_host,$db_name,$db_user,$db_pass,$strings,$lingo,$lingoname,$divstyle_white,$divstyle_grey,$divstyle_blue,$divstyle_orange,$crm_api_user,$crm_api_pass,$crm_wsdl_url,$BodyDIV,$portalcode,$crm_api_user2, $crm_api_pass2, $crm_wsdl_url2,$account_id_c,$contact_id_c,$cmn_languages_id_c,$cmn_statuses_id_c,$cmn_countries_id_c;

  if (!$account_id_c){
     $account_id_c = $portal_account_id;
     }

  $source = $params[0]; // Email, other
  $emailparams = $params[1]; // Email, other

  switch ($source){

   case 'Auto':

    $debug = $emailparams[7];

   break;
   case 'Emails':

    $debug = $emailparams[7];

   break;

  }

  #$debug_makefile = TRUE;
  $debug_makefile = FALSE;
  #$do_logger = FALSE;
  #$do_logger = TRUE;

  $content_location = "/var/www/vhosts/scalastica.com/httpdocs/content/".$portal_account_id;
  $log_location = "/var/www/vhosts/scalastica.com/httpdocs";
  $log_name = "Scalastica";
  $log_link = "content/".$portal_account_id."/".$log_name.".log";

  $bodyfiledate = date('Y-m-d-H-i-s');
  $bodyfile_location = "/var/www/vhosts/scalastica.com/httpdocs/content/".$bodyfiledate."-body.txt";

  $valtype = $emailparams[8];

  $debugger = "<img src=http://".$hostname."/images/icons/bug.png width=16> <B>Debug:</B>";

  $imapemails = $funky_gear->get_email ($emailparams);

  #echo "<P>Get IMAP<P>";
  #var_dump($imapemails);
  #echo "<P>Got IMAP<P>";
  #if (is_array($imapemails)){

  if ($imapemails != FALSE){

     #echo "Still here!!";

     ############################
     # Do Logger
     if ($do_logger == TRUE){
        #$log_content = "From Auto Params - 0 $emailparams[0] 1 $emailparams[1] 2 $emailparams[2] 3 $emailparams[3] 4 $emailparams[4] 5 $emailparams[5] 6 $emailparams[6] 7 $emailparams[7] 8 $emailparams[7] Array: ".$imapemails." [".$bodyfiledate."]";
        $logparams[0] = $log_location;
        $logparams[1] = $log_name;
        $logparams[2] = $log_content;
        #$funky_gear->funky_logger ($logparams);
        }
     # End Logger 
     ############################

     #var_dump($imapemails);

     $mailcount = count($imapemails);

     if ($emailparams[6]){
        echo "<P><B>Keyword: <font color=red>".$val." [CNT:".count($imapemails)."]</font></B><P>";
        }

     # Check all servers in system
     # Configuration Item Sets (not scanned)
     # Service Assets | ID: a39735f4-b558-5214-1d07-52593e7f39da (not scanned)
     # Infrastructure | ID: 7827074f-a7d3-9ae5-e473-5255d64e5c73 (not scanned)
     # Data Center | ID: 7d2f42a9-9de7-224d-712c-52ad30da69fd (not scanned)
     # DC Floor (ID, Name) | ID: 9a2ee7f9-67b6-9f72-c133-52ad302dfdc0 (not scanned)
     # -> Rack (ID, Name) | ID: 63fef2c9-9acf-fbd1-56c7-52ad300f480f (not scanned)
     #    -> Rack Unit Space (ID, Name) | ID: de350370-d2d3-e84b-13c1-52ad5f2fb2ab (not scanned)
     #       -> System Name | ID: 9065cbc6-177f-9848-1ada-52ad30451c3f (not scanned)
     #       -> Blade Enclosure (ID, Name) | ID: 94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4 (not scanned)
     #          -> Blade Enclosure Hostnames | ID: cd287492-19ce-99b3-6ead-52e0c97a6e83 (scanned)
     #          -> Blade Enclosure Interconnect Bay | ID: 5601009c-5ebd-bc31-3659-52e0e4b16ffb (not scanned)
     #             -> Blade Enclosure Interconnect Bay Switch | ID: 3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889 (not scanned)
     #                -> Blade Enclosure Interconnect Bay Switch Hostname | ID: 49ff2505-7d08-cb5c-64e8-52e0e490c0dc  (scanned)
     #          -> Blades | ID: 617ab884-61b5-d7a1-1de7-52ad61df4cae (not scanned)
     #             -> Blade Hostname | ID: 34647ae4-154c-68f3-74ea-52b0c8abc3dc (scanned)
     #             -> Blade VM | ID: b3621853-e25d-0e38-84ff-52c286ae0de9 (not scanned)
     #                -> Blade VM Hostname | ID: 3f6d75b7-c0f5-1739-c66d-52c2989ce02d (scanned)
     #       -> Purpose | ID: cb455d67-8335-df81-1d3b-52ad67c4977e (not scanned)
     #       -> Rack Server - 1U | ID: 77c9dccf-a0a7-05fc-a05f-52ad62515fc7 (not scanned)
     #          -> Product Components | ID: 52784a42-d442-9e71-8d09-529304d1d518 (not scanned)
     #          -> Unit Host Name | ID: 7835c8b9-f7d5-5d0a-be10-52ad9c866856 (scanned)
     #          -> Unit VM | ID: 711d9da0-c885-6a0d-1a2c-52c286bd762d (not scanned)
     #             -> Unit VM Hostname | ID: 7ef914c8-09f8-82c9-d4b9-52c29793ef85 (scanned)
     #       -> Rack Storage Unit | ID: 7b5baafb-6f98-5d25-d9c8-541fca790cea (not scanned)
     #          -> Rack Storage Hostname | ID: 8c8a3231-1d86-0117-4680-541fcbab4f6a (scanned)
     #       -> Switch Unit | ID: c194460c-0e8d-ca8e-0aa9-541fc5785016 (not scanned)
     #          -> Switch Hostname | ID: 388b56dc-771e-b743-e63b-541fc6070ab9 (scanned)
     # 
     $maintsrv_object_type = "ConfigurationItems";
     $maintsrv_action = "select";

     # Server types need to be updated in Infrastructure
     $service_types = $funky_gear->get_infra();

     if (is_array($service_types)){

        $maintsrv_types_count = count($service_types);
        $current_cnt = 0;

        foreach ($service_types as $serv_key=>$serv_name){

            if ($current_cnt==0){
               $maintsrv_types = "(sclm_configurationitemtypes_id_c='".$serv_key."' "; 
               } elseif ($current_cnt == $maintsrv_types_count-1){
               $maintsrv_types .= "|| sclm_configurationitemtypes_id_c='".$serv_key."') "; 
                } else {
               $maintsrv_types .= "|| sclm_configurationitemtypes_id_c='".$serv_key."' "; 
               }

            $current_cnt = $current_cnt+1;

            } # for

        } # is array $service_types

     #echo $maintsrv_types_arr;

     #$maintsrv_types = "(sclm_configurationitemtypes_id_c='7835c8b9-f7d5-5d0a-be10-52ad9c866856' || sclm_configurationitemtypes_id_c='34647ae4-154c-68f3-74ea-52b0c8abc3dc' || sclm_configurationitemtypes_id_c='7ef914c8-09f8-82c9-d4b9-52c29793ef85' || sclm_configurationitemtypes_id_c='3f6d75b7-c0f5-1739-c66d-52c2989ce02d' || sclm_configurationitemtypes_id_c='cd287492-19ce-99b3-6ead-52e0c97a6e83' || sclm_configurationitemtypes_id_c='49ff2505-7d08-cb5c-64e8-52e0e490c0dc' || sclm_configurationitemtypes_id_c='388b56dc-771e-b743-e63b-541fc6070ab9' || sclm_configurationitemtypes_id_c='8c8a3231-1d86-0117-4680-541fcbab4f6a')";

     $maintsrv_params[0] = " deleted=0 && account_id_c='".$account_id_c."' && $maintsrv_types ";

     $maintsrv_params[1] = "id,name,description"; // select array
     $maintsrv_params[2] = ""; // group;
     $maintsrv_params[3] = ""; // order;
     $maintsrv_params[4] = ""; // limit
  
     $maintservers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $maintsrv_object_type, $maintsrv_action, $maintsrv_params);

     if (is_array($maintservers)){
        $check_maint_servers = $maintservers;
        }

     #########################################
     # Begin looping through each email available

     for ($mailcnt=0;$mailcnt < count($imapemails);$mailcnt++){

         $number = $imapemails[$mailcnt]['number'];
         $msgno = $imapemails[$mailcnt]['Msgno'];
         $email_id = $imapemails[$mailcnt]['id'];
         $to = $imapemails[$mailcnt]['to'];
         $cc = $imapemails[$mailcnt]['cc'];
         $email_id = $funky_gear->replacer("<", "", $email_id);
         $email_id = $funky_gear->replacer(">", "", $email_id);
         $encode = $imapemails[$mailcnt]['encode'];
         $read = $imapemails[$mailcnt]['read'];
         $subject = $imapemails[$mailcnt]['subject'];
         $charset = $imapemails[$mailcnt]['charset'];
         $from = $imapemails[$mailcnt]['from'];
         $fromaddress = $imapemails[$mailcnt]['fromaddress'];
         $date = $imapemails[$mailcnt]['date'];
         $udate = $imapemails[$mailcnt]['udate'];
         $body = $imapemails[$mailcnt]['body'];
         $attachments = $imapemails[$mailcnt]['attachments'];

         if (!$subject){

            ############################
            # Do Logger
            if ($do_logger == TRUE){
               $log_content = "No subject at [".$bodyfiledate."] - break early!";
               $logparams[0] = $log_location;
               $logparams[1] = $log_name;
               $logparams[2] = $log_content;
               $funky_gear->funky_logger ($logparams);
               }
            # End Logger 
            ############################

            break;

            }

         ############################
         # Do Logger
         if ($do_logger == TRUE){
            $log_content = "For Mail Loop [Cnt: ".$mailcount."] - Start for Subject [".$bodyfiledate."]: ".$subject;
            $logparams[0] = $log_location;
            $logparams[1] = $log_name;
            $logparams[2] = $log_content;
            $funky_gear->funky_logger ($logparams);
            }
         # End Logger 
         ############################

         if (is_array($from)){

            foreach ($from as $fromid => $object) {
                    $from_name = $object->personal;
                    #$from_name_encode = mb_encode_mimeheader($from_name,"UTF-8", 'Q');
                    #echo "From name: ".$fromname." -> Encode: ".$from_name_encode."<P>";
                    $from_mailname = $object->mailbox . "@" . $object->host;
                    }

            } else {// end if array from

            $from_name = "No Name";
            $from_mailname = "NoName@NoDomain";

            } 

         $topack = "";
         $tolist = "";
         $usabletopack = "";
         $ccpack = "";
         $cclist = "";
         $usableccpack = "";

         if (is_array($to)){

            $tocount = count($to);

            foreach ($to as $id => $object) {

                    $to_name = $object->personal;
                    $to_mailname = $object->mailbox."@".$object->host;

                    if ($to_mailname != $portal_email){
                       # Don't include own portal email address from to list - we KNOW it is to us because we are here!! :)))
                       # Also will go into a perpetual loop..

                       if ($tocount == 0 || $tocount == 1 || $tocount == -1){
                          $toender = "";
                          } else {
                          $toender = ",";
                          } 

                       $topack .= $to_name." [".$to_mailname."]".$toender;
                       $tolist .= $to_mailname.$toender;
                       $usabletopack[]['name'] = $to_name;
                       $usabletopack[]['mailname'] = $to_mailname;

                       $tocount = $tocount-1;

                       } // end else mailname = portal mail

                    } // for each

            } else {// if to array
            #echo "Not array - TO: ".$to."<BR>";
            }

         if (is_array($cc)){

            $cccount = count($cc);

            foreach ($cc as $id => $object) {

                    $cc_name = $object->personal;
                    $cc_mailname = $object->mailbox."@".$object->host;

                    if ($cccount == 1){
                       $ccender = "";
                       } else {
                       $ccender = ",";
                       } 

                    $ccpack .= $cc_name." [".$cc_mailname."]".$ccender;
                    $cclist .= $cc_mailname.$ccender;
                    $usableccpack[]['name'] = $cc_name;
                    $usableccpack[]['mailname'] = $cc_mailname;

                    $cccount = $cccount-1;

                    }

            } // if cc array

         $files = "";

         $file_process_object_type = "Content";
         $file_process_action = "update";
       
         $imagearray = array("jpg","png","gif","jpeg","JPG","JPEG","PNG","BMP","bmp","GIF");
         $moviearray = array("mov","mpeg","mpeg4","avi","wmv","mp3","mp4");

         $file_content_type = '34cf7647-dffa-8516-b25a-527c0b3c5590';

         if (is_array($attachments)){

            foreach ($attachments as $attaid => $object) {

                    $filename = $object['filename'];
                    $file = $object['filedata'];
                    $content_type = $object['content_type'];

                    if (!is_dir($content_location)){
                       mkdir($content_location, '777');
                       }

                    $file_location = $content_location."/".$filename;

                    if (!file_exists($file_location)){
                       $file_location = $content_location."/".$filename;
                       $fp = fopen($file_location, 'w');
                       $file_link = "content/".$portal_account_id."/".$filename;
                       fputs($fp, $file);
                       fclose($fp);
                       } else {
                       $filedate = date('Y-m-d_H-i-s',$udate);
                       #$filedate = date('Y-m-d-H-i-s');
                       $filename = $filedate."-".$filename;
                       $file_location = $content_location."/".$filename;
                       $file_link = "content/".$portal_account_id."/".$filename;
                       $fp = fopen($file_location, 'w');
                       fputs($fp, $file);
                       fclose($fp);
                       }

                    $new_file_location = "http://".$hostname."/".$file_link;

                    if ($debug == FALSE){

                       #$extension = pathinfo($file_location, PATHINFO_EXTENSION);
                       $fileinfo = pathinfo($file_location);
                       $extension = $fileinfo['extension'];

                       if (in_array($extension,$imagearray)){

                         $file_content_type = '1b7369c3-dd78-a8a3-2a79-523876ce70fe';
                         $extensionlessname = str_replace(".".$extension, '', $filename);
                         $original_thumb = $content_location."/".$extensionlessname."_thumb.".$extension;
                         $content_thumbnail = $original_thumb;
                         $thumb_name = $extensionlessname."_thumb.".$extension;
                         $thumb_path = $content_location."/";
                         $thumb_location = "http://".$hostname."/content/".$portal_account_id."/".$thumb_name;
   		         $maxheight = 300;
      		         $maxwidth = 200;
                         $thumbPostfix = '_thumb'; 

                         # Get new dimensions
                         list($width_orig, $height_orig) = getimagesize($file_location);

                         if ($width_orig>0 && $height_orig>0){
		   	    $ratioX	= $maxwidth/$width_orig;
		   	    $ratioY	= $maxheight/$height_orig;
		   	    $ratio 	= min($ratioX, $ratioY);
			    $ratio	= ($ratio==0)?max($ratioX, $ratioY):$ratio;
			    $newW	= $width_orig*$ratio;
			    $newH	= $height_orig*$ratio;
		            $quality	= 75;

			    // Resample
			    $thumb = imagecreatetruecolor($newW, $newH);
			    $image = imagecreatefromstring(file_get_contents($file_location));
				
			    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $newW, $newH, $width_orig, $height_orig);
	
			    // Output
			    switch (strtolower($extension)) {
		             case 'png':
		             	imagepng($thumb, $thumb_path.$thumb_name, 9);
		             break;
						
		             case 'gif':
		          	imagegif($thumb, $thumb_path.$thumb_name);
		             break;
						
		             default:
		          	imagejpeg($thumb, $thumb_path.$thumb_name, $quality);;
	          	     break;

			    } // end switch

			    imagedestroy($image);
			    imagedestroy($thumb);

		            }

                        } elseif (in_array($extension,$moviearray)){

                         $file_content_type = 'cccba116-c398-0acb-7778-523876243cd9';

                        } else {# (!in_array($extension,$imagearray) && !in_array($extension,$moviearray)):

                         $file_content_type = '34cf7647-dffa-8516-b25a-527c0b3c5590';

                        }

                       $cmn_industries_id_c = '3ab902b1-5fe9-b06d-3e0a-522a8aa49f16'; // Business Services
                       $portal_content_type = "";
 
                       $file_process_params = array();
                       $file_process_params[] = array('name'=>'name','value' => $filename);
                       $file_process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                       $file_process_params[] = array('name'=>'description','value' => $filename);
                       $file_process_params[] = array('name'=>'account_id_c','value' => $account_id_c);
                       $file_process_params[] = array('name'=>'contact_id_c','value' => $contact_id_c);
                       $file_process_params[] = array('name'=>'content_type','value' => $file_content_type);
                       $file_process_params[] = array('name'=>'portal_content_type','value' => $portal_content_type);
                       $file_process_params[] = array('name'=>'cmn_countries_id_c','value' => $cmn_countries_id_c);
                       $file_process_params[] = array('name'=>'cmn_languages_id_c','value' => $cmn_languages_id_c);
                       $file_process_params[] = array('name'=>'cmn_industries_id_c','value' => $cmn_industries_id_c);
                       $file_process_params[] = array('name'=>'cmn_statuses_id_c','value' => $standard_statuses_closed);

                       # Some of the following items picked up by the ticketing functions
                       #$file_process_params[] = array('name'=>'sclm_advisory_id_c','value' => $sclm_advisory_id_c);
                       #$file_process_params[] = array('name'=>'project_id_c','value' => $project_id_c);
                       #$file_process_params[] = array('name'=>'projecttask_id_c','value' => $projecttask_id_c);
                       #$file_process_params[] = array('name'=>'sclm_sow_id_c','value' => $sclm_sow_id_c);
                       #$file_process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $sclm_sowitems_id_c);
                       #$file_process_params[] = array('name'=>'sclm_messages_id_c','value' => $sclm_messages_id_c);
                       #$file_process_params[] = array('name'=>'sclm_emails_id_c','value' => $sclm_emails_id_c);
                       $file_process_params[] = array('name'=>'content_url','value' => $new_file_location);
                       $file_process_params[] = array('name'=>'content_thumbnail','value' => $thumb_location);
                       #$file_process_params[] = array('name'=>'sclm_ticketing_id_c','value' => $sclm_ticketing_id_c);
                       #$file_process_params[] = array('name'=>'sclm_ticketingactivities_id_c','value' => $sclm_ticketingactivities_id_c);
   
                       $file_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $file_process_object_type, $file_process_action, $file_process_params);

                       if ($file_result['id'] != NULL){
                          $file_id = $file_result['id'];
                          }
                    
                       $contentpack[$file_id] = $file_id;

                       } // end if debug

                    $files .= "<a href='http://".$hostname."/".$file_link."' target=File>".$filename."</a><BR>";
                    #$filespack[$filename] = "<a href=http://".$hostname."/".$file_link." target=File>".$filename."</a>";
                    $filespack[$filename] = $filename.": 'http://".$hostname."/".$file_link."'";
                    
                    } // end foreach attachments

            } // if attachments array

         if ($debug_makefile == TRUE){
            $fp = fopen($bodyfile_location, 'w');
            fputs($fp, $body);
            fclose($fp);
            }

         $date = date('Y-m-d H:i:s',$udate);

         if ($read == 0){
            $read = $strings["MessageUnread"];
            } else {
            $read = $strings["MessageRead"];
            }

         if ($body != NULL){

            $original_body = $body;

            # This is potentially messing up things..

            $body = $funky_gear->replacer("{", "[", $body);
            $body = $funky_gear->replacer("}", "]", $body);

            $has_html = "";

            if ($body != strip_tags($body)) {
               # contains HTML
               $has_html = "Has HTML!";
               #echo "Is HTML<BR>";
               #$body = htmlspecialchars(strip_tags($body), ENT_QUOTES, 'utf-8');
               $body = $funky_gear->replacer("<BR>", "SCALASTICABR", $body); # Break
               $body = $funky_gear->replacer("<br>", "SCALASTICABR", $body); # Break
               $body = $funky_gear->replacer("\n", "SCALASTICANL", $body); # New Line
               #$body = $funky_gear->replacer("\n", "<br>", $body);
               $body = strip_tags($body);
               #$body = $funky_gear->replacer("\n", "<br>", $body);
               if ($source == 'Emails'){
                  #$body = $funky_gear->replacer("SCALASTICABR", "\n", $body);
                  $body = $funky_gear->replacer("SCALASTICABR", "", $body);
                  $body = $funky_gear->replacer("SCALASTICANL", "\n", $body);
                  } else {
                  #$body = $funky_gear->replacer("SCALASTICABR", "\n", $body);
                  $body = $funky_gear->replacer("SCALASTICABR", "", $body);
                  $body = $funky_gear->replacer("SCALASTICANL", "\n", $body);
                  }
               #$body = $funky_gear->replacer("SCALASTICA", "<br>", $body);
               $body = $funky_gear->replacer("&amp;nbsp;", "&", $body);
               #$body = $funky_gear->replacer("&amp;", "", $body);
               #$body = $funky_gear->replacer("nbsp;", "", $body);
               } else {
               $has_html = "Doesn't Have HTML";
               #$body = $funky_gear->replacer("\n", "<br>", $body);
               }
            }

         if ($debug == 1){
            $debug = TRUE;
            $create_report = TRUE;
            }

         # Prepare to send in link to create tickets
         $html_subject = urlencode ($subject);
         $html_body = urlencode ($body);
         $html_date = urlencode ($date);

         $imap_emails .= "<div style=\"".$divstyle_white."\">
<B>Assigned to:</B> ".$assigned_user_id."<BR>
<B>#:</B> ".$number."<BR>
<B>Msgno:</B> ".$msgno."<BR>
<B>Encode:</B> ".$encode."<BR>
<B>Charset:</B> ".$charset."<BR>
<B>HTML:</B> ".$has_html."<BR>
<B>ID:</B> ".$email_id."<BR>
<B>Date:</B> ".$date."<BR>
<B>TO:</B> ".$topack."<BR>
<B>From:</B> ".$from_name." [".$from_mailname."] <BR>
<B>CC:</B> ".$ccpack."<BR>
<B>Subject:</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=".$number."&valuetype=view_email');return false\"><font color=red><B>".$subject."</B></font></a><BR>
<B>Testing:</B> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=".$number."&valuetype=test_filter_single_debug');return false\"><font color=red><B>Debug</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Emails&action=list&value=".$number."&valuetype=test_filter_single_live');return false\"><font color=red><B>Live</B></font></a> | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Ticketing&action=add&value=".$number."&valuetype=IMAPEmails&fromemail_subject=".$htmlsubject."&fromemail_body=".$htmlbody."&fromemail_date=".$html_date."');return false\"><font size=2 color=red><B>->".$strings["EmailConvertToTicket"]."</B></font></a><BR>";

         $convert = "";

         if ($files){
            $imap_emails .= "<div style=\"".$divstyle_blue."\"><B>Attachments:</B><BR>".$files."</div>";
            }

         if ($debug == TRUE){
            $showbody = $funky_gear->replacer("\n", "<br>", $body);
            #$showbody = $funky_gear->replacer("<br>", "\n", $body);
            } else {
            #$showbody = $funky_gear->replacer("<br>", "\n", $body);
            $showbody = $funky_gear->replacer("\n", "<br>", $body);
            #$showbody = $body;
            }

         $imap_emails .= "<B>Body:</B><P>".$showbody."</div>";

         if ($debug_makefile == TRUE){
            #$fp = fopen($bodyfile_location, 'w');
            #fputs($fp, $body);
            #fclose($fp);
            }

         ##########################################
         # If set to debug or go live

         if ($valtype == 'test_filter_all_live' || $valtype == 'test_filter_all_debug' || $valtype == 'test_filter_single_debug' || $valtype == 'test_filter_single_live'){

            if ($create_report == TRUE){
               $report  = "<div style=\"".$divstyle_orange."\"><center><B>Debug for Email: ".$subject."</B></center></div>";
               }

            ##########################################
            # Get list of keywords to scan body to determine auto downtime status

            $status_down_keywords_citype = '9c2d0f4b-1f1f-5de1-692e-52ceeab416c6';

            # Use Filter to collect components
            $prtlstatuskwds_object_type = "ConfigurationItems";
            $prtlstatuskwds_action = "select";
            $prtlstatuskwds_params[0] = " sclm_configurationitemtypes_id_c='".$status_down_keywords_citype."' && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ";
            $prtlstatuskwds_params[1] = "id,sclm_configurationitems_id_c,name,sclm_configurationitemtypes_id_c";
            $prtlstatuskwds_params[2] = ""; // group;
            $prtlstatuskwds_params[3] = ""; // order;
            $prtlstatuskwds_params[4] = ""; // limit

            $prtlstatuskwds = "";
            $prtlstatuskwds = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $prtlstatuskwds_object_type, $prtlstatuskwds_action, $prtlstatuskwds_params);

            if (is_array($prtlstatuskwds)){
                              
               for ($prtkwdcnt=0;$prtkwdcnt < count($prtlstatuskwds);$prtkwdcnt++){

                   # Got the portal 
                   $keyword_check = "";
                   $filter_keyword = "";
                   $filter_keyword = $prtlstatuskwds[$prtkwdcnt]['name'];                                   

                   if ($create_report == TRUE){
                      $report .= $debugger." Server Status Check with: <B>".$filter_keyword."</B><BR>";
                      }

                   if ($body != $funky_gear->replacer($filter_keyword, "", $body)){

                      # keyword exists in body - check for servers
                      if (is_array($server_pack)){

                         $server_check = "";

                         foreach ($server_pack as $server_id=>$server_name){
 
                                 if ($body == $funky_gear->replacer($server_name,"", $body)){
                                    # keyword doesnt exist in body - do nothing
                                    } else {//  end if 
                                    # keyword exists in body - check for servers
                                    $srvupdateparams[0] = $server_id;
                                    $srvupdateparams[1] = 0;
                                    $srvupdateparams[2] = 'live_status';
                                    $updated = "";
                                    $updated = $funky_gear->update_items($srvupdateparams);
   
                                    if ($create_report == TRUE){
                                       $report .= $debugger." Server Status Updated: <B>OFF: ".$updated."</B><BR>";
                                       }

                                    } // Server updated!

                                 } // foreach ($server_pack)

                         } // is_array($server_pack)

                      } // if keyword matches

                   } // for

               } // is array $prtlstatuskwds

            # End list of keywords to scan body to determine auto downtime status
            ##########################################
            # Get list of keywords to scan body to determine auto uptime status

            $status_up_keywords_citype = '8e83ef85-41e5-5f35-e239-52ceea6db03f';

            # Use Filter to collect components
            $prtlstatuskwds_object_type = "ConfigurationItems";
            $prtlstatuskwds_action = "select";
            $prtlstatuskwds_params[0] = " sclm_configurationitemtypes_id_c='".$status_up_keywords_citype."' && (account_id_c='".$portal_account_id."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ";
            $prtlstatuskwds_params[1] = "id,sclm_configurationitems_id_c,name,sclm_configurationitemtypes_id_c";
            $prtlstatuskwds_params[2] = ""; // group;
            $prtlstatuskwds_params[3] = ""; // order;
            $prtlstatuskwds_params[4] = ""; // limit

            $prtlstatuskwds = "";
            $prtlstatuskwds = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $prtlstatuskwds_object_type, $prtlstatuskwds_action, $prtlstatuskwds_params);

            if (is_array($prtlstatuskwds)){
                               
               for ($prtkwdcnt=0;$prtkwdcnt < count($prtlstatuskwds);$prtkwdcnt++){

                   # Got the portal 
                   $keyword_check = "";
                   $filter_keyword = "";
                   $filter_keyword = $prtlstatuskwds[$prtkwdcnt]['name'];                                   

                   if ($create_report == TRUE){
                      $report .= $debugger." Server Status Check with: <B>".$filter_keyword."</B><BR>";
                      }
      
                   if ($body != $funky_gear->replacer($filter_keyword, "", $body)){
                      # keyword exists in body - check for servers

                      if (is_array($server_pack)){

                         $server_check = "";

                         foreach ($server_pack as $server_id=>$server_name){
 
                                 if ($body == $funky_gear->replacer($server_name,"", $body)){
                                    # keyword doesnt exist in body - do nothing
                                    } else {//  end if 
                                    # keyword exists in body - check for servers
                                    $srvupdateparams[0] = $server_id;
                                    $srvupdateparams[1] = 1;
                                    $srvupdateparams[2] = 'live_status';
                                    $updated = "";
                                    $updated = $funky_gear->update_items($srvupdateparams);

                                    if ($create_report == TRUE){
                                       $report .= $debugger." Server Status Updated: <B>ON: ".$updated."</B><BR>";
                                       }

                                    } // Server updated!
   
                                 } // foreach ($server_pack)

                         } // is_array($server_pack)
   
                      } // if keyword matches

                   } // for

               } // is array $prtlstatuskwds

            # End list of keywords to scan body to determine auto uptime status
            ##########################################
            # Specific for AGC - should be included in some rules
            # Server Capture Strings | CIT: 17697341-0e34-26d8-a677-54d90fca5790

            $srvcap_object_type = "ConfigurationItems";
            $srvcap_action = "select";
            $srvcap_params[0] = " enabled=1 && sclm_configurationitemtypes_id_c='17697341-0e34-26d8-a677-54d90fca5790' && account_id_c='".$portal_account_id."' ";
            $srvcap_params[1] = "id,enabled,account_id_c,sclm_configurationitems_id_c,name,sclm_configurationitemtypes_id_c";
            $srvcap_params[2] = ""; // group;
            $srvcap_params[3] = ""; // order;
            $srvcap_params[4] = ""; // limit

            $srvcap_strings = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $srvcap_object_type, $srvcap_action, $srvcap_params);

            if (is_array($srvcap_strings)){
                               
               for ($srvcap_cnt=0;$srvcap_cnt < count($srvcap_strings);$srvcap_cnt++){

                   # Got the portal 
                   $srv_string = $srvcap_strings[$srvcap_cnt]['name'];     
                   list($srv_part_start,$srv_part_end) = explode('[XXXX]',$srv_string);

                   $startcheck = "";
                   $endcheck = "";
                   $startcheck = "";
                   $endcheck = "";
                   $message_source = "";
                   $startcheck = $funky_gear->replacer($srv_part_start, "", $body);
                   $endcheck = $funky_gear->replacer($srv_part_end, "", $body);

                   if ($startcheck == $body || $endcheck == $body){
                      # Do nothing - they don't exist
                      } else {
                      $startsAt = strpos($body, $srv_part_start) + strlen($srv_part_start);
                      $endsAt = strpos($body, $srv_part_end, $startsAt);
                      $srv_replace = substr($body, $startsAt, $endsAt - $startsAt);
                      $srv_replace = $funky_gear->replacer("\n", "", $srv_replace);
                      $srv_replace = $funky_gear->replacer(".agc.jp", "", $srv_replace);
                      $srv_replace = $funky_gear->replacer(" ", "", $srv_replace);
                      $server_replace .= $srv_replace;
                      } 

                   } # for

              } # is array

            # We need to search for it by hostname (caps) and add it to the pack
            $server_replace = rtrim($server_replace);
            $server_replace = ltrim($server_replace);

            $server_replace = $funky_gear->replacer("\n","",$server_replace);
            $server_replace = mb_convert_encoding($server_replace, "HTML-ENTITIES", "UTF-8");
            $server_replace = strip_tags($server_replace);
            $server_replace = htmlspecialchars($server_replace, ENT_QUOTES, "UTF-8");
            $server_replace = $funky_gear->replacer("nbsp;", "", $server_replace);
            $server_replace = $funky_gear->replacer("&amp;", "", $server_replace);
            $server_replace = rtrim($server_replace);
            $server_replace = ltrim($server_replace);

            $nameupper = strtoupper ($server_replace);
            $namelower = strtolower ($server_replace);

            # End Server Capture Strings
            ##########################################

            /*
            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $message_source = "";
            $startcheck = $funky_gear->replacer("ソース:", "", $body);
            $endcheck = $funky_gear->replacer("パス:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "ソース:") + strlen("ソース:");
               $endsAt = strpos($body, "パス: ", $startsAt);
               $message_source = substr($body, $startsAt, $endsAt - $startsAt);
               $message_source = $funky_gear->replacer("\n", "", $message_source);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $message_pass = "";
            $startcheck = $funky_gear->replacer("パス:", "", $body);
            $endcheck = $funky_gear->replacer("イベント日時:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "パス:") + strlen("パス:");
               $endsAt = strpos($body, "イベント日時:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $funky_gear->replacer("\n", "", $server_replace);
               $server_replace = $funky_gear->replacer(" ", "", $server_replace);
               $message_pass = $server_replace;
               $server_replace = $funky_gear->replacer(".agc.jp", "", $server_replace);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $funky_gear->replacer("Server :", "", $body);
            $endcheck = $funky_gear->replacer("ErrorCode :", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "Server :") + strlen("Server :");
               $endsAt = strpos($body, "ErrorCode :", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $funky_gear->replacer("\n", "", $server_replace);
               $server_replace = $funky_gear->replacer(".agc.jp", "", $server_replace);
               $server_replace = $funky_gear->replacer(" ", "", $server_replace);
               } 
          
            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $funky_gear->replacer("エージェント:", "", $body);
            $endcheck = $funky_gear->replacer("時刻:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "エージェント:") + strlen("エージェント:");
               $endsAt = strpos($body, "時刻:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $funky_gear->replacer("\n", "", $server_replace);
               $server_replace = $funky_gear->replacer(".agc.jp", "", $server_replace);
               $server_replace = $funky_gear->replacer(" ", "", $server_replace);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $funky_gear->replacer("コンピューター:", "", $body);
            $endcheck = $funky_gear->replacer("イベントソース:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "コンピューター:") + strlen("コンピューター:");
               $endsAt = strpos($body, "イベントソース:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $funky_gear->replacer("\n", "", $server_replace);
               $server_replace = $funky_gear->replacer(".agc.jp", "", $server_replace);
               $server_replace = $funky_gear->replacer(" ", "", $server_replace);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $startcheck = $funky_gear->replacer("Event originator:", "", $body);
            $endcheck = $funky_gear->replacer("Event Severity:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "Event originator:") + strlen("Event originator:");
               $endsAt = strpos($body, "Event Severity:", $startsAt);
               $server_replace = substr($body, $startsAt, $endsAt - $startsAt);
               $server_replace = $funky_gear->replacer("\n", "", $server_replace);
               $server_replace = $funky_gear->replacer(".agc.jp", "", $server_replace);
               $server_replace = $funky_gear->replacer(" ", "", $server_replace);
               }

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $event_source = "";
            $startcheck = $funky_gear->replacer("イベントソース:", "", $body);
            $endcheck = $funky_gear->replacer("イベントディスプレイNo.:","", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "イベントソース:") + strlen("イベントソース:");
               $endsAt = strpos($body, "イベントディスプレイNo.:", $startsAt);
               $event_source = substr($body, $startsAt, $endsAt - $startsAt);
               $event_source = $funky_gear->replacer("\n", "", $event_source);
               } 

            $startcheck = "";
            $endcheck = "";
            $startcheck = "";
            $endcheck = "";
            $event_category = "";
            $startcheck = $funky_gear->replacer("イベントカテゴリー:", "", $body);
            $endcheck = $funky_gear->replacer("コンピューター:", "", $body);
            if ($startcheck == $body || $endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $startsAt = strpos($body, "イベントカテゴリー:") + strlen("イベントカテゴリー:");
               $endsAt = strpos($body, "コンピューター:", $startsAt);
               $event_category = substr($body, $startsAt, $endsAt - $startsAt);
               $event_category = $funky_gear->replacer("\n", "", $event_category);
               } 

            if ($create_report == TRUE){
               $report .= $debugger." Server Found in Body/Subject: <B>".$server_replace."</B><BR>";
               }
            */

            ###############################
            # Pre-pack for sending in for replies and normal filters

            $precheckparams[0] = $server_replace;
            $precheckparams[1] = $message_pass;
            $precheckparams[2] = $message_source;
            $precheckparams[3] = $event_source;
            $precheckparams[4] = $event_category;
            $precheckparams[5] = $nameupper;
            $precheckparams[6] = $namelower;
   
            # End Pre-pack
            ###############################
            # We have the server now - lets see if it is in the server array or maybe pick it up

            if ($server_replace != NULL){

               if ($create_report == TRUE){
                  $report .= $debugger." name like '%".$server_replace."%' || name like '%".$nameupper."%' || name like '%".$namelower."%' <BR>";
                  }

               # Try to get the Infra DB ID
               $server_object_type = "ConfigurationItems";
               $server_action = "select";
               # These same items need to be updated in the ConfigurationItems.php add action switch ($ci_type_id)
               $server_params[0] = " (name like '%".$server_replace."%' || name like '%".$nameupper."%' || name like '%".$namelower."%') && $maintsrv_types ";
               $server_params[1] = "id,name,sclm_configurationitemtypes_id_c"; // array
               $server_params[2] = ""; // group;
               $server_params[3] = ""; // order;
               $server_params[4] = ""; // limit

               $find_server = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $server_object_type, $server_action, $server_params);
               if (is_array($find_server)){

                  for ($cntsrvr=0;$cntsrvr < count($find_server);$cntsrvr++){

                      $found_server_id = $find_server[$cntsrvr]['id'];
                      $found_server_name = $find_server[$cntsrvr]['name'];
                      # Add to the pack
                      $server_pack[$found_server_id] = $found_server_name;
       
                      if ($create_report == TRUE){
                         $report .= $debugger." Found server within Infra DB [".$found_server_name." - ".$found_server_id."]<BR>";
                         }
   
                      } // for servers found
       
                  } else {// is an array - for servers found
       
                  } // was not in the infra db

               $precheckparams[7] = $server_pack;

               } // if server found

            # End checking email for servers and other key tags
            ###############################
            # Check for vendor code

            $ticket_object_type = "Ticketing";
            $ticket_action = "select";
			//Added by vivek
            #  [Ticket Statuses] Cancelled | ID: 72b33850-b4b0-c679-f988-52c2eb40a5de
            #  [Ticket Statuses] Closed | ID: bbed903c-c79a-00a6-00fe-52802db36ba9
            $ticket_params[0] = " account_id_c='".$account_id_c."' && vendor_code != 'NULL' && status != 'bbed903c-c79a-00a6-00fe-52802db36ba9' ";
            $ticket_params[1] = "name,ticket_id,status,filter_id,id,account_id_c,date_entered,vendor_code"; // select array
            $ticket_params[2] = ""; // group;
            $ticket_params[3] = " date_entered DESC "; // order;
            $ticket_params[4] = ""; // limit
            $ticket_params[5] = "name_en"; // lingo

            $vend_ticket_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ticket_object_type, $ticket_action, $ticket_params);

            if (is_array($vend_ticket_items)){

               for ($vendcnt=0;$vendcnt < count($vend_ticket_items);$vendcnt++){

                   $vendor_code = $vend_ticket_items[$vendcnt]["vendor_code"];

                   if ($subject != $funky_gear->replacer($vendor_code,"",$subject)){

                      $tick_id = $vend_ticket_items[$vendcnt]['id'];
                      $ticket_id = $vend_ticket_items[$vendcnt]['ticket_id'];
                      $reply_filter_id = $vend_ticket_items[$vendcnt]['filter_id'];
                      $existticket_name = $vend_ticket_items[$vendcnt]['name'];
                      $ticket_status = $vend_ticket_items[$vendcnt]['status'];

                      if ($create_report == TRUE){
                         $report .= $debugger." Found Vendor Code: [".$vendor_code."] & Ticket: [".$ticket_id."]<BR>";
                         }

                      $michimail = FALSE;
                      $match = TRUE;
                      $create_activity = TRUE;
                      $create_email = TRUE;
                      $create_activity_ticket_id = $tick_id;
                      $create_activity_email_ticket_id = $ticket_id;
                      $create_activity_email_ticket_status = $ticket_status;

                      break;

                      } // if code

                   } // for

               } // if array

            #echo "Found Vendor Code: [".$vendor_code."] & Ticket: [".$ticket_id."]<BR>";

            # Check for vendor code
            ###############################
            # Check for create activity - only to be nullified if the ticket states so
            # Get specific ticket ID

            if ($ticket_id == NULL){

               $create_activity = FALSE;

               $exist_object_type = 'ConfigurationItems';
               $exist_action = "select";
               $exist_params[0] = " sclm_configurationitemtypes_id_c='6cc00767-12da-3666-9081-52826ae1cea5' && account_id_c='".$account_id_c."' && cmn_statuses_id_c != '".$standard_statuses_closed."' ";
               $exist_params[1] = "id,sclm_configurationitems_id_c,name"; // select array
               $exist_params[2] = ""; // group;
               $exist_params[3] = " name, date_entered DESC "; // order;
               $exist_params[4] = ""; // limit
  
               $exist_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $exist_object_type, $exist_action, $exist_params);

               if (is_array($exist_items)){

                  for ($exist_cnt=0;$exist_cnt < count($exist_items);$exist_cnt++){
            
                      # $id = $config_items[$configcnt]['id'];
                      $exist_ticket_id = $exist_items[$exist_cnt]['name'];

                      if ($create_report == TRUE){
                         $report  .= $debugger." Existing TicketActivity ID: ".$exist_ticket_id."<BR>";
                         }

                      } // end for

                  } else {// end if
                  $exist_ticket_id = "SDaaS+AMS-";
                  } 
      
               if ($create_report == TRUE){
                  $report  .= $debugger." Ticket ID to auto-create activities... [".$exist_ticket_id."]<BR>";
                  }

               } // if not vendor and chheck for ticket reply

            # End finding auto ID
            #########################
            # ID is already pre-filtered
            # Check if ID is in the subject - this has to be the key to continue for activities

            if ($subject != $funky_gear->replacer($exist_ticket_id, "", $subject)){

               $create_activity = TRUE;
               # Includes the ticket ID

               if ($create_report == TRUE){
                  $report  .= $debugger." Found Ticket ID in subject!!<BR>";
                  }

               # Look if subject in ticket name
               if ($create_activity != FALSE){
                  #########################
                  # Check based on a ticket - if a ticket exists with same subject
  
                  if ($create_report == TRUE){
                     $report  .= $debugger." No activity restrictions - check if subject is in ticket ID...<BR>";
                     }

                  $this_year = date("Y");
                  $this_month = date("m");
                  if ($this_month == 1){
                     $last_month = 12;
                     $last_month_year = $this_year-1;
                     } else {
                     $last_month = $this_month-1;
                     $last_month_year = $this_year;
                     }

                  if (strlen($last_month)<2){
                     $last_month = "0".$last_month;
                     }

                  if (strlen($this_month)<2){
                     $this_month = "0".$this_month;
                     }

                  $last_month_ticket = $last_month_year."-".$last_month; // to the month 
                  $this_month_ticket = $this_year."-".$this_month; // to the month 
                  #$exist_ticket_day = date("Y-m-d"); // to the month
                  $ticket_id_type_one = $exist_ticket_id."[".$last_month_ticket;
                  $ticket_id_type_two = $exist_ticket_id."[".$this_month_ticket;

                  # Allow for at least one week either way - by which time the ticket should be closed..
                  /*
                  $exist_ticket_day_plus_one_day = date('Y-m-d', strtotime($exist_ticket_day .' +1 day'));
                  $exist_ticket_day_minus_six_days = date('Y-m-d', strtotime($exist_ticket_day .' -6 days'));
                  $exist_ticket_day_minus_five_days = date('Y-m-d', strtotime($exist_ticket_day .' -5 days'));
                  $exist_ticket_day_minus_four_days = date('Y-m-d', strtotime($exist_ticket_day .' -4 days'));
                  $exist_ticket_day_minus_three_days = date('Y-m-d', strtotime($exist_ticket_day .' -3 days'));
                  $exist_ticket_day_minus_two_days = date('Y-m-d', strtotime($exist_ticket_day .' -2 days'));
                  $exist_ticket_day_minus_one_day = date('Y-m-d', strtotime($exist_ticket_day .' -1 day'));
                  $exist_ticket_day_plus_two_days = date('Y-m-d', strtotime($exist_ticket_day .' +2 days'));
                  $exist_ticket_day_plus_three_days = date('Y-m-d', strtotime($exist_ticket_day .' +3 days'));
                  $exist_ticket_day_plus_four_days = date('Y-m-d', strtotime($exist_ticket_day .' +4 days'));
                  $exist_ticket_day_plus_five_days = date('Y-m-d', strtotime($exist_ticket_day .' +5 days'));
                  $exist_ticket_day_plus_six_days = date('Y-m-d', strtotime($exist_ticket_day .' +6 days'));
                  */

                  $acttickets_object_type = "Ticketing";
                  $acttickets_action = "select";
                  $acttickets_params[0] = " name LIKE '%".$ticket_id_type_one."%' || name LIKE '%".$ticket_id_type_two."%'  ";
                  $acttickets_params[1] = "id,filter_id,account_id_c,ticket_id,name,status"; // select array
                  $acttickets_params[2] = ""; // group;
                  $acttickets_params[3] = ""; // order;
                  $acttickets_params[4] = ""; // limit
                  $acttickets_params[5] = $lingoname; // limit
  
                  $acttickets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acttickets_object_type, $acttickets_action, $acttickets_params);

                  if (is_array($acttickets)){
      
                     if ($create_report == TRUE){
                        $report .= $debugger." Tickets potentially exist like ".$ticket_id_type_one." OR like ".$ticket_id_type_two." to attach this new Activity to.<BR>";   
                        }

                     for ($cntactkt=0;$cntactkt < count($acttickets);$cntactkt++){
                         $tick_id = $acttickets[$cntactkt]['id'];
                         $ticket_id = $acttickets[$cntactkt]['ticket_id'];
                         $reply_filter_id = $acttickets[$cntactkt]['filter_id'];
                         $existticket_name = $acttickets[$cntactkt]['name'];
                         $ticket_status = $acttickets[$cntactkt]['status'];

                         if ($create_report == TRUE){
                            $report .= $debugger." Ticket potentially exists: ".$ticket_id."<BR>";
                            }


                         # This will only work IF the engineers use the ticketing system, key AND it is registered in the DB
                         if ($subject != $funky_gear->replacer($ticket_id,"",$subject)){
                            # We have a hit - the subject/body resembles an existing ticket

                            if ($create_report == TRUE){
                               $report .= $debugger." Ticket found: ".$ticket_id."<BR>";
                               }

                            $michimail = FALSE;
                            $match = TRUE;
                            $create_activity = TRUE;
                            $create_email = TRUE;
                            $create_activity_ticket_id = $tick_id;
                            $create_activity_email_ticket_id = $ticket_id;
                            $create_activity_email_ticket_status = $ticket_status;

                            break;

                            } else {// end if ($subject != $funky_gear->replacer($ticket_id,"",$subject)){
                             $create_activity = FALSE;
                            }

                         } // for based on like

                     } // if array

                  } // if found ticket_id

               } // if exist_ticket_id

            #########################
            # If by vendor ID or by ticket

            if ($create_activity != FALSE){
               #########################
               # Just keeping structure

               if ($create_activity != FALSE){
                  #########################
                  # Just keeping structure

                  if ($create_activity != FALSE){
                     #########################
                     # If reply - create activity

                     if ($reply_filter_id == NULL){

                        # Have to find a filter rule that provide default activity info
                        $checkfilter_object_type = "ConfigurationItems";
                        $checkfilter_action = "select";
                        $checkfilter_params[0] = " name='DefaultActivityFilter' && account_id_c='".$account_id_c."' ";
                        $checkfilter_params[1] = "id,name,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,$lingoname";
                        $checkfilter_params[2] = ""; // group;
                        $checkfilter_params[3] = ""; // order;
                        $checkfilter_params[4] = ""; // limit
  
                        $checkfilters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $checkfilter_object_type, $checkfilter_action, $checkfilter_params);

                        if (is_array($checkfilters)){

                           # Default exists for this account = NEW Filterbits for sending

                           for ($chkfltrcnt=0;$chkfltrcnt < count($checkfilters);$chkfltrcnt++){
 
                               $reply_filter_id = $checkfilters[$chkfltrcnt]['id'];

                               } // end for

                           } // if array checkfilters

                        } // if filter_id

                     if ($reply_filter_id != NULL){

                        # Use Filter to collect components
                        $filterbit_object_type = "ConfigurationItems";
                        $filterbit_action = "select";
                        $filterbit_params[0] = " sclm_configurationitems_id_c='".$reply_filter_id."' && enabled=1 ";
                        $filterbit_params[1] = "";
                        $filterbit_params[2] = ""; // group;
                        $filterbit_params[3] = ""; // order;
                        $filterbit_params[4] = ""; // limit
                        $replyfilterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

                        if ($create_report == TRUE){
                           $report .= $debugger." Filter Base Ticket: <B>".$existticket_name." [".$ticket_id."] and filter ".$filter_id."</B><BR>";
                           }

                        ############################
                        # Do Logger
                        if ($do_logger == TRUE){
                           $log_content = "Email Reply with ticket info [".$bodyfiledate."]: ".$ticket_id;
                           $logparams[0] = $log_location;
                           $logparams[1] = $log_name;
                           $logparams[2] = $log_content;
                           $funky_gear->funky_logger ($logparams);
                           }
                        # End Logger 
                        ############################

                        if ($create_report == TRUE){
                           $report  .= $debugger." Doing Filterbit for filter ".$reply_filter_id."<BR>";
                           }

                        $dofilterbit_params[0] = $replyfilterbits;
                        $dofilterbit_params[1] = $subject;
                        $dofilterbit_params[2] = $from_mailname;
                        $dofilterbit_params[3] = $body;
                        $dofilterbit_params[4] = $date;
                        $dofilterbit_params[5] = $udate;
                        $dofilterbit_params[6][0] = $filespack;
                        $dofilterbit_params[6][1] = $contentpack;
                        $dofilterbit_params[7] = $report;
                        $dofilterbit_params[8] = $match;
                        $dofilterbit_params[9] = $debug;
                        $dofilterbit_params[10] = $reply_filter_id;
                        $dofilterbit_params[11] = FALSE;
                        $dofilterbit_params[12] = FALSE;
                        $dofilterbit_params[13] = $check_maint_servers;
                        $dofilterbit_params[14] = "";//$previous_ticket;
                        $dofilterbit_params[15] = "";//$previous_title;
                        $dofilterbit_params[16] = "";//$previous_subject;
                        $dofilterbit_params[17] = $email_id;
                        $dofilterbit_params[18] = $tolist;
                        $dofilterbit_params[19] = $cclist;
                        $dofilterbit_params[20] = 0; //count($filterbit_triggers);

                        $replyparams[0] = $create_activity_ticket_id;
                        $replyparams[1] = $create_activity_email_ticket_id;
                        $replyparams[2] = $create_activity_email_ticket_status;

                        $dofilterbit_params[21] = $replyparams; // is reply
                        $dofilterbit_params[22] = $precheckparams; // is reply
 
                        ##########################################
                        # Begin doing filterbits

                        $filterbit_returns = $this->do_filterbits ($dofilterbit_params);
                        $report = $filterbit_returns[0];
                        $match = $filterbit_returns[1];
                        $create_mail = $filterbit_returns[2];
                        $create_ticket = $filterbit_returns[3];
                        $create_activity = $filterbit_returns[4];
                        $catchall = $filterbit_returns[5];
                        $previous_ticket = $filterbit_returner[6];
                        $previous_title = $filterbit_returner[7];
                        $previous_subject = $filterbit_returner[8];
                        $trigger_rate = $filterbit_returner[9];
                        $thistriggercount = $filterbit_returner[10];
   
                        $emailreply = TRUE;

                        $break;

                        } else {

                        # No filter - problem if we have come to this point!!
 
                        if ($create_report == TRUE){
                           $report .= $debugger." No Filter ID!!<BR>";
                           }

                        } // end if filter

                     } else { // if array based on like

                     $create_activity = FALSE;

                     if ($create_report == TRUE){
                         $report  .= $debugger." No Tickets Exist to attach Activity to...<BR>";
                         }
   
                     } // end if check

                  } // if do create activity

               } // end if key is in subject

            # End check for create activity based on an email
            ##########################################
            # Maintenance

            if ($found_server_id && $create_activity == FALSE){

               # Check Maintenance
               $maintenance = FALSE;
               # Nullify the server in the email if in Maintenance
               $maintenance_window = "";

               # Check the email current datetime
               $email_datetime = date('Y-m-d H:i', strtotime($date));
               # Collect any maintenance start/end times if available
               if ($create_report == TRUE){
                  $report .= $debugger." Checking Maintenance window for Server: <B>".$server_replace."</B><BR>";
                  }
  
               # Start DateTime
               $ci_type = '787ab970-8f2a-efed-3aca-52ecd566b16b';
               $mnt_object_type = 'ConfigurationItems';
               $mnt_action = "select";
               $mnt_params[0] = " sclm_configurationitems_id_c='".$found_server_id."' && sclm_configurationitemtypes_id_c='".$ci_type."' ";
               $mnt_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,$lingoname";
               $mnt_params[2] = ""; // group;
               $mnt_params[3] = "";
               $mnt_params[4] = ""; // limit
       
               $mnt_items = "";    
               $mnt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mnt_object_type, $mnt_action, $mnt_params);

               $mnt_id = "";
               $maintenance_startdatetime = "";

               if (is_array($mnt_items)){

                  for ($mntcnt=0;$mntcnt < count($mnt_items);$mntcnt++){

                      #$mnt_id = $mnt_items[$mntcnt]['id']; // The live status
                      $maintenance_startdatetime = $mnt_items[$mntcnt]['name']; // The live status

                      if ($create_report == TRUE){
                         $report .= $debugger." Maintenance start: <B>".$maintenance_startdatetime."</B><BR>";
                         }

                      } // end for
                    
                  } // end if

               # End DateTime
               $ci_type = 'b38181b6-eb59-0bc3-bad3-52ecd65163f5';
               $mnt_object_type = 'ConfigurationItems';
               $mnt_action = "select";
               $mnt_params[0] = " sclm_configurationitems_id_c='".$found_server_id."' && sclm_configurationitemtypes_id_c='".$ci_type."' ";
               $mnt_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,$lingoname";
               $mnt_params[2] = ""; // group;
               $mnt_params[3] = "";
               $mnt_params[4] = ""; // limit

               $mnt_items = "";  
               $mnt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mnt_object_type, $mnt_action, $mnt_params);

               $mnt_id = "";
               $maintenance_enddatetime = "";

               if (is_array($mnt_items)){

                  for ($mntcnt=0;$mntcnt < count($mnt_items);$mntcnt++){
       
                      #$mnt_id = $mnt_items[$mntcnt]['id']; // The live status
                      $maintenance_enddatetime = $mnt_items[$mntcnt]['name']; // The live status

                      if ($create_report == TRUE){
                         $report .= $debugger." Maintenance end: <B>".$maintenance_enddatetime."</B><BR>";
                         }
   
                      } // end for

                  } // end if

               if ($maintenance_startdatetime != NULL && $maintenance_enddatetime != NULL){

                  if ($email_datetime >= $maintenance_startdatetime && $email_datetime <= $maintenance_enddatetime){

                     # Within the maintenance window
                     $maintenance = TRUE;
                     $match = FALSE;

                     if ($create_report == TRUE){
                        $report .= $debugger." IS IN Maintenance!!<BR>";
                        }

                     } else {
      
                     if ($create_report == TRUE){
                        $report .= $debugger." NOT IN Maintenance!!<BR>";
                        }
         
                     }

                  } else {// if null

                  $ci_type = '2864a518-19f4-ddfa-366e-52ccd012c28b';

                  if ($create_report == TRUE){
                     $report .= $debugger." Checking Maintenance for Individual Server: <B>".$server_replace."</B><BR>";
                     }

                  $mnt_object_type = 'ConfigurationItems';
                  $mnt_action = "select";
                  $mnt_params[0] = " sclm_configurationitems_id_c='".$found_server_id."' && sclm_configurationitemtypes_id_c='".$ci_type."' ";
                  $mnt_params[1] = "id,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,$lingoname";
                  $mnt_params[2] = ""; // group;
                  $mnt_params[3] = "";
                  $mnt_params[4] = ""; // limit

                  $mnt_items = "";  
                  $mnt_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mnt_object_type, $mnt_action, $mnt_params);

                  $mnt_id = "";
                  $maintenance_status = "";

                  if (is_array($mnt_items)){

                     for ($mntcnt=0;$mntcnt < count($mnt_items);$mntcnt++){

                         #$mnt_id = $mnt_items[$mntcnt]['id']; // The live status
                         $maintenance_status = $mnt_items[$mntcnt]['name']; // The live status

                         if ($maintenance_status == 1){
                            $maintenance = TRUE;
                            $match = FALSE;
 
                            if ($create_report == TRUE){
                               $report .= $debugger." Maintenance IN for Server: <B>".$server_replace."</B><BR>";
                               }
   
                            } elseif ($maintenance_status == 0){// in maintenance

                            #$match = TRUE;
                            if ($create_report == TRUE){
                               $report .= $debugger." Maintenance OUT for Server: <B>".$server_replace."</B><BR>";
                               }
                    
                            } else { // end else

                            if ($create_report == TRUE){
                               $report .= $debugger." Maintenance not set for Server: <B>".$server_replace."</B><BR>";
                               }
                    
                            } // end status check

                         } // end for

                     } // end if array

                  } // end else check for individual server status

               } // if $found_server_id and not activity

            ###############################
            # Move email to ticketed folder

            $portal_imap_port = "993";
            $portal_imap_server = "imap.gmail.com";

            if ($debug == TRUE && $maintenance == TRUE){
               $nocatchall = TRUE; // will result in false, but not a stray email to send in
               $report .= $debugger." Do NOT perform catch-all - Maintenance ON and FALSE is correct result..<BR>";

               $from_folder = "Development/Test-In";
               $to_folder = "Development/Test-Auto-Maintenance";

               $moveparams[0] = $portal_imap_port;
               $moveparams[2] = $portal_imap_server;
               $moveparams[3] = $from_folder;
               $moveparams[4] = $to_folder;
               $moveparams[5] = $email_id;
               $moveparams[6] = $portal_email;
               $moveparams[7] = $portal_email_password;
               $moveparams[8] = $report;
               $moveparams[9] = $create_report;

               $report = $funky_gear->move_emails($moveparams);
      
               } elseif ($debug != TRUE && $maintenance == TRUE) {

               $from_folder = "Admin/0 - Auto-Filtered";
               $to_folder = "Admin/0 - Auto-Maintenance";
   
               $moveparams[0] = $portal_imap_port;
               $moveparams[2] = $portal_imap_server;
               $moveparams[3] = $from_folder;
               $moveparams[4] = $to_folder;
               $moveparams[5] = $email_id;
               $moveparams[6] = $portal_email;
               $moveparams[7] = $portal_email_password;
               $moveparams[8] = $report;
               $moveparams[9] = $create_report;

               $report = $funky_gear->move_emails($moveparams);

               break;

               }

            # End Moving mintenance emails
            ###############################
            # Setting Maintenance Window

         if ($create_activity == FALSE){

            if ($create_report == TRUE){
               $report  .= $debugger." Checking for Maintenance Window<BR>";
               }

            $maintenance_setting = FALSE;

            $maintenance_startdatetime = "";
            $maintenance_startcheck = "";
            $maintenance_endcheck = "";
            $maintenance_startsAt = "";
            $maintenance_endsAt = "";
            $maintenance_startcheck = $funky_gear->replacer("[Maintenance_Start_DateTime]", "", $body);
            $maintenance_endcheck = $funky_gear->replacer("[EndMaintenance_Start_DateTime]", "", $body);
            if ($maintenance_startcheck == $body || $maintenance_endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $maintenance_startsAt = strpos($body, "[Maintenance_Start_DateTime]") + strlen("[Maintenance_Start_DateTime]");
               $maintenance_endsAt = strpos($body, "[EndMaintenance_Start_DateTime]", $maintenance_startsAt);
               $maintenance_startdatetime = substr($body, $maintenance_startsAt, $maintenance_endsAt - $maintenance_startsAt);
               $maintenance_startdatetime = $funky_gear->replacer("\n", "", $maintenance_startdatetime);
               #$maintenance_startdatetime = $funky_gear->replacer(" ", "", $maintenance_startdatetime);
               } 

            $maintenance_enddatetime = "";
            $maintenance_startcheck = "";
            $maintenance_endcheck = "";
            $maintenance_startsAt = "";
            $maintenance_endsAt = "";
            $maintenance_startcheck = $funky_gear->replacer("[Maintenance_End_DateTime]", "", $body);
            $maintenance_endcheck = $funky_gear->replacer("[EndMaintenance_End_DateTime]", "", $body);
            if ($maintenance_startcheck == $body || $maintenance_endcheck == $body){
               # Do nothing - they don't exist
               } else {
               $maintenance_startsAt = strpos($body, "[Maintenance_End_DateTime]") + strlen("[Maintenance_End_DateTime]");
               $maintenance_endsAt = strpos($body, "[EndMaintenance_End_DateTime]", $maintenance_startsAt);
               $maintenance_enddatetime = substr($body, $maintenance_startsAt, $maintenance_endsAt - $maintenance_startsAt);
               $maintenance_enddatetime = $funky_gear->replacer("\n", "", $maintenance_enddatetime);
               #$maintenance_enddatetime = $funky_gear->replacer(" ", "", $maintenance_enddatetime);
               } 

            if ($maintenance_startdatetime != NULL && $maintenance_enddatetime != NULL){
         
               $maintenance_setting = TRUE;

               if ($create_report == TRUE){
                  $report  .= $debugger." Maintenance Window Found (".$maintenance_startdatetime." to ".$maintenance_enddatetime.") <BR>";
                  }

               # Update the servers in the email with new maintenance windows
               if (is_array($check_maint_servers)){

                  for ($cntmntsrvr=0;$cntmntsrvr < count($check_maint_servers);$cntmntsrvr++){
      
                      $server_id = $check_maint_servers[$cntmntsrvr]['id'];
                      $server_name = $check_maint_servers[$cntmntsrvr]['name'];

                      $server_check = $funky_gear->replacer($server_name,"", $body);

                      $nameupper = strtoupper ($server_name);

                      $server_check_upper = $funky_gear->replacer($nameupper,"", $body);

                      $namelower = strtolower ($server_name);

                      $server_check_lower = $funky_gear->replacer($namelower,"", $body);

                      if (($server_check != $body || $server_check_upper != $body || $server_check_lower != $body ) && $server_id != NULL){
                         # keyword exists in body - check for servers
                         $srvupdateparams[0] = $server_id;
                         $srvupdateparams[1] = 1;
                         $srvupdateparams[2] = 'maintenance_window';
                         $srvupdateparams[3] = $maintenance_startdatetime;
                         $srvupdateparams[4] = $maintenance_enddatetime;
                         $updated = "";
                         $updated = $funky_gear->update_items($srvupdateparams);

                         if ($create_report == TRUE){
                            $report  .= $debugger." Maintenance Window set for <B>".$server_name."</B><BR>";
                            }
      
                         } // if server in email

                      } // end for all server check

                  } // if array 

               } // end if maintenance window provided
      
            # End Setting Maintenance Window
            ##########################################
            # Checking Individual Maintenance

            $update_status = "";
            $keyword_check = "";
            $keyword_check = $funky_gear->replacer("Server_Maintenance_In","",$body);

            $maintenanceIN = FALSE;
            $maintenanceOUT = FALSE;

            if ($keyword_check != $body){
               $update_status = 1;
               $maintenanceIN = TRUE;

               if ($create_report == TRUE){
                  $report .= $debugger." Found Server Maintenance Status Command: <B>Turn ON</B><BR>";
                  }

               } // end if keyword for IN

            $keyword_check = $funky_gear->replacer("Server_Maintenance_Out","",$body);

            if ($keyword_check != $body){
               $update_status = 0;
               $maintenanceOUT = TRUE;
   
               if ($create_report == TRUE){
                  $report .= $debugger." Found Server Maintenance Status Command: <B>Turn OFF</B><BR>";
                  }

               } // end if keyword for OUT

            if ($maintenanceIN == TRUE || $maintenanceOUT == TRUE){

               $maintenance_setting = TRUE;
               # keyword exists in body - check for servers
               # Check all servers in system

               if (is_array($check_maint_servers)){

                  for ($cntmntsrvr=0;$cntmntsrvr < count($check_maint_servers);$cntmntsrvr++){
                      $server_id = $check_maint_servers[$cntmntsrvr]['id'];
                      $server_name = $check_maint_servers[$cntmntsrvr]['name'];

                      $maint_server_check = $funky_gear->replacer($server_name,"", $body);
      
                      if ($maint_server_check != $body && $maintenanceIN == TRUE){
                         # keyword exists in body - check for servers
                         $srvupdateparams[0] = $server_id;
                         $srvupdateparams[1] = 1;
                         $srvupdateparams[2] = 'maintenance_status';
                         $updated = "";
                         $updated = $funky_gear->update_items($srvupdateparams);

                         if ($create_report == TRUE){
                            $report  .= $debugger."ALL Servers Maintenance Status Updated for $server_name: <B>: ".$updated."</B><BR>";
                            }

                         } // Server updated!

                      if ($server_check != $body && $maintenanceOUT == TRUE){
                         # keyword exists in body - check for servers
                         $srvupdateparams[0] = $server_id;
                         $srvupdateparams[1] = 0;
                         $srvupdateparams[2] = 'maintenance_status';
                         $updated = "";
                         $updated = $funky_gear->update_items($srvupdateparams);

                         if ($create_report == TRUE){
                            $report  .= $debugger."ALL Servers Maintenance Status Updated for $server_name: <B>: ".$updated."</B><BR>";
                            }

                         } // Server updated!

                      } // for

                  } // is_array($server_pack)

               } // if keyword matches

            # End Check maintenance
            #################################################
            # Perform Filter

            # First see if a similar email has arrived in the last 2 minutes
            #$date = date('Y-m-d H:i:s', $udate);
            $emailmins = date("Y-m-d H:i:s",strtotime($date));
            $checktime_minus_mins = date('Y-m-d H:i:s', strtotime($emailmins .' -3 minutes'));
            $previous_date_minus_mins = date('Y-m-d H:i:s', strtotime($previous_date .' -3 minutes'));

            # Check previous email
            $end_time = date("Y-m-d H:i:s", strtotime($previous_date.' +4 minutes'));
            $start_time = date("Y-m-d H:i:s", strtotime($previous_date.' -4 minutes'));
            $emailtime = date("Y-m-d H:i:s", strtotime($date));
            #list($email_hour,$email_minute) = explode(":", $emailtime);
 
            $duplicate = FALSE;

            if (($emailtime >= $start_time && $emailtime <= $end_time) && ($subject == $previous_subject)){
               # if (($emailtime == $previous_date) && $subject == $previous_subject)){

               if ($create_report == TRUE){
                  $report  .= "<div style=\"".$divstyle_orange."\">($emailtime >= $start_time && $emailtime <= $end_time) && ($subject == $previous_subject)</div>";
                  }

               $duplicate = TRUE;

               } // end if not same email/subject in time-frame

            $mailcheck_object_type = "Emails";
            $mailcheck_action = "select";
            #$tickcheck_params[0] = " (status='e47fc565-c045-fef9-ef4f-52802bfc479c' || status='320138e7-3fe4-727e-8bac-52802c62a4b6') && account_id_c='".$portal_account_id."' ";
            #$mailcheck_params[0] = " name='".$subject."' && account_id_c='".$portal_account_id."' && ('".$checktime_minus_five_mins."' <= DATE_FORMAT(date_entered,'%Y-%m-%d %H-%i') AND '".$emailmins."' >=DATE_FORMAT(date_entered,'%Y-%m-%d %H-%i')) ";
            #$mailcheck_params[0] = " name='".$subject."' && account_id_c='".$portal_account_id."' && ('".$checktime_minus_mins."' <= date_entered AND '".$emailmins."' >= date_entered) ";
            # If Existing Email Date is greater than the New Email Date minus 3 Minutes  
            #$mailcheck_params[0] = " name='".$subject."' && account_id_c='".$portal_account_id."' && (date_entered >= '".$checktime_minus_mins."') ";
            #select * from myTable where Login_time > date_sub(now(), interval 3 minute) ;
            $mailchecksubject = $funky_gear->replacer('\\','\\\\',$subject);
            #$mailcheckbody = $body;
			//Added by vivek
			//addslashes
            $mailcheck_params[0] = " deleted=0 && name='".addslashes($mailchecksubject)."' && account_id_c='".$portal_account_id."' && (date_entered >= '".$checktime_minus_mins."' AND date_entered <= '".$emailmins."') && debug_mode=0 ";
            #$mailcheck_params[0] = " description='".$mailcheckbody."' && account_id_c='".$portal_account_id."' && (date_entered >= '".$checktime_minus_mins."' AND date_entered <= '".$emailmins."') ";
  
            $mailcheck_params[1] = "id,date_entered,name,description,account_id_c,sclm_ticketing_id_c,debug_mode"; // select array
            $mailcheck_params[2] = ""; // group;
            $mailcheck_params[3] = ""; // order;
            $mailcheck_params[4] = ""; // limit

            $mailcheck = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $mailcheck_object_type, $mailcheck_action, $mailcheck_params);

            $recentemails = 0;
            $recentemails = count($mailcheck);

            $check_email_id = "";

            if (is_array($mailcheck)){

               for ($mlckcnt=0;$mlckcnt < count($mailcheck);$mlckcnt++){

                   $check_email_id = $mailcheck[$mlckcnt]['id'];
                   $check_email_date = $mailcheck[$mlckcnt]['date_entered'];
                   $check_email_name = $mailcheck[$mlckcnt]['name'];
                   $check_email_ticket_id = $mailcheck[$mlckcnt]['sclm_ticketing_id_c'];
                   # Need to get the filter ID to check what other strings may exist in body as subject may be same, but body diff

                   $checkedmails .= "Date: ".$check_email_date." Subject: ".$check_email_name."<BR>";

                   } // for

               } // if

            if ($create_report == TRUE){
               $report .= $debugger." Check Query (".$mailcheck_params[0].") for recent similar emails [Count: ".$recentemails."] with Subject and date within minutes (Email time:".$emailmins." to check within ".$checktime_minus_mins." - if true - then ignore!!";

               if ($check_email_id != NULL){
                  $report .= $debugger." <P><font color=red>Email already Exists!<P>".$checkedmails."<P>If you wish to debug this, please search for the original email and switch it to debug=ON...</font><P>";
                  }

               }

            $filterset_object_type = "ConfigurationItems";
            $filterset_action = "select";
            $filterset_params[0] = " sclm_configurationitemtypes_id_c='d2313332-261a-cfe2-4fbe-528f0a6bb9a1' && account_id_c='".$portal_account_id."' ";
            $filterset_params[1] = ""; // select array
            $filterset_params[2] = ""; // group;
            $filterset_params[3] = ""; // order;
            $filterset_params[4] = ""; // limit
  
            $filtersets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterset_object_type, $filterset_action, $filterset_params);

            if ($create_report == TRUE){
               $report .= $debugger." Check for Filter Sets<BR>";
               }

            if ($duplicate == TRUE){

               if ($create_report == TRUE){
                  $report .= $debugger."<div style=\"".$divstyle_orange."\">The Previous Body (Subject: $previous_subject & Date: $previous_date) is same as this Body - we ain't gonna do it!!!</div>";
                  }

               } // if duplicate

            #################################################
            # Have Filter Sets

            if (is_array($filtersets) && ($check_email_id==NULL) && ($duplicate != TRUE) && ($maintenance_setting == FALSE) && ($emailreply != TRUE)){
               #if (is_array($filtersets) && ($check_email_id==NULL) && ($duplicate != TRUE)){

               for ($cnt=0;$cnt < count($filtersets);$cnt++){
                   # Second loop for Filtersets - PER email

                   $filterset_id = $filtersets[$cnt]['id'];
                   $filterset_name = $filtersets[$cnt]['name'];

                   ############################
                   # Do Logger
                   if ($do_logger == TRUE){
                      $log_content = "For Filterset Loop Start for Filterset [".$bodyfiledate." CNT[".count($filtersets)."]]: ".$filterset_name;
                      $logparams[0] = $log_location;
                      $logparams[1] = $log_name;
                      $logparams[2] = $log_content;
                      $funky_gear->funky_logger ($logparams);
                      }
                   # End Logger 
                   ############################

                   if ($create_report == TRUE){
                      $report .= "<div style=\"".$divstyle_blue."\"><center><B>Debug for Filter Set: ".$filterset_name."</B></center></div>";
                      $report .= $debugger." Found a Filter Set: ".$filterset_name." ID: ".$filterset_id."<BR>";
                      }

                   ##########################################
                   # Use Filtering Set to get Filters

                   # Find the catch-all component as part of a filter to remove it
                   $catch_all_filter_object_type = "ConfigurationItems";
                   $catch_all_filter_action = "select";
                   $catch_all_filter_params[0] = " name='a51b8e41-bb1b-f729-2c59-52ccc314bc0a' && enabled=1 && account_id_c='".$portal_account_id."' ";
                   $catch_all_filter_params[1] = "id,enabled,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c";
                   $catch_all_filter_params[2] = ""; // group;
                   $catch_all_filter_params[3] = ""; // order;
                   $catch_all_filter_params[4] = ""; // limit
  
                   $catch_all_filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $catch_all_filter_object_type, $catch_all_filter_action, $catch_all_filter_params);

                   if (is_array($catch_all_filters)){

                      for ($catch_all_cntfltr=0;$catch_all_cntfltr < count($catch_all_filters);$catch_all_cntfltr++){
   
                          $catch_all_filter_id = $catch_all_filters[$catch_all_cntfltr]['sclm_configurationitems_id_c'];
                          $catch_all_filterbit_id = $catch_all_filters[$catch_all_cntfltr]['id'];

                         if ($create_report == TRUE){
                            $returner = $funky_gear->object_returner ("ConfigurationItems", $catch_all_filter_id);
                            $catch_all_filter_name = $returner[0];
                            $report .= $debugger." Catch-all filter ".$catch_all_filter_name." found<BR>";
                            }

                          # Check if this filter is within the filter set - $filterset_id

                          $catch_all_filterset_object_type = "ConfigurationItems";
                          $catch_all_filterset_action = "select";
                          $catch_all_filterset_params[0] = " id='".$catch_all_filter_id ."' ";
                          $catch_all_filterset_params[1] = "id,enabled,sclm_configurationitems_id_c";
                          $catch_all_filterset_params[2] = ""; // group;
                          $catch_all_filterset_params[3] = ""; // order;
                          $catch_all_filterset_params[4] = ""; // limit
                          
                          $catch_all_filtersets = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $catch_all_filterset_object_type, $catch_all_filterset_action, $catch_all_filterset_params);

                          if (is_array($catch_all_filtersets)){

                             for ($catch_all_cntfltrset=0;$catch_all_cntfltrset < count($catch_all_filtersets);$catch_all_cntfltrset++){
   
                                 $catch_all_filterset_id = $catch_all_filtersets[$catch_all_cntfltrset]['sclm_configurationitems_id_c'];

                                 if ($catch_all_filterset_id == $filterset_id){
                                    # The catch-all filter is part of this filterset

                                    if ($create_report == TRUE){
                                       $report .= "<div style=\"".$divstyle_orange."\"><center><B>Catch-All Filter Found for Filterset</B></center></div>";
                                       }

                                    break1;

                                    } else {

                                    $catch_all_filter_id = "";
                                    $catch_all_filterbit_id = "";

                                    } // end else 

                                 } // end for

                             } // end if

                          } // end for

                      if ($catch_all_filter_id != NULL){
                         $catch_all_query = " && id != '".$catch_all_filter_id."' ";

                         if ($create_report == TRUE){
                            $report .= $debugger." Catch-all filter ".$catch_all_filter_name." to be used last<BR>";
                            }

                         } else {
                         $catch_all_query = "";
                         }

                      } // end if array

                   # End find Check-all Filters
                   ##########################################
                   # Get Filters

                   $filter_object_type = "ConfigurationItems";
                   $filter_action = "select";
                   $filter_params[0] = " sclm_configurationitems_id_c='".$filterset_id."' && enabled=1 && sclm_configurationitemtypes_id_c='dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812' ".$catch_all_query;
                   $filter_params[1] = "id,enabled,sclm_configurationitems_id_c,sclm_configurationitemtypes_id_c,name,account_id_c,contact_id_c,project_id_c,projecttask_id_c"; // select array
                   $filter_params[2] = ""; // group;
                   $filter_params[3] = ""; // order;
                   $filter_params[4] = ""; // limit
  
                   $filters = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filter_object_type, $filter_action, $filter_params);

                   if ($create_report == TRUE || $catch_all_filter_id != NULL){
                      $report .= $debugger." Looking for Filters (Catch-all query: ".$catch_all_query.")<BR>";
                      }

                   ##########################################
                   # Have Filters

                   #$match = FALSE;
                   #$match = "";

                   if (is_array($filters)){
   
                      for ($cntfltr=0;$cntfltr < count($filters);$cntfltr++){
                          # Third loop - each filter and filterbits PER email

                          $filter_createticket = "";
                          $create_ticket = "";
                          $create_email = "";
                          $ip_pack = "";
                          $ip_show = "";
                          $server_pack = "";
                          $server_show = "";
                          $sla_pack = "";
                          $filter_strings = "";
                          $filter_string = "";
                          $filter_nonstrings = "";
                          $filter_nonstring = "";
                          $filter_nonserverips = "";

                          $filter_createactivity = "";
                          $create_activity = "";
                          $sender_pack = "";

                          $filter_id = $filters[$cntfltr]['id'];
                          $filter_name = $filters[$cntfltr]['name'];

                          ############################
                          # Do Logger
                          if ($do_logger == TRUE){
                             $log_content = "For Filter Loop Start for Filter [".$bodyfiledate." CNT [".$cntfltr." of ".count($filters)."]]: ".$filter_name;
                             $logparams[0] = $log_location;
                             $logparams[1] = $log_name;
                             $logparams[2] = $log_content;
                             $funky_gear->funky_logger ($logparams);
                             }
                          # End Logger 
                          ############################
                          
                          if ($match != TRUE){
                             #$match = FALSE;
                             }

                          if ($debug == TRUE || $check_all_filter_id != NULL){
                             $filter_message = "<div style=\"".$divstyle_grey."\"><center><B>Debug for Filter: ".$filter_name."</B></center></div>";
                             $filter_message .= $debugger." Found Filter: <B>".$filter_name."</B> - need to collect filter components<BR>";
                             }

                          # Use Filter to collect components
                          $filterbit_object_type = "ConfigurationItems";
                          $filterbit_action = "select";
                          $filterbit_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && enabled=1 ";
                          $filterbit_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c";
                          $filterbit_params[2] = ""; // group;
                          $filterbit_params[3] = ""; // order;
                          $filterbit_params[4] = ""; // limit
  
                          $filterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

                          ##########################################
                          # Have Filterbits - use filterbits function to loop through for each

                          if (is_array($filterbits)){
   
                             # How many triggers must be met to be true
                             $filterbit_trigger_object_type = "ConfigurationItems";
                             $filterbit_trigger_action = "select";
                             # Filter Trigger(s) | ID: 83a83279-9e48-0bfe-3ca0-52b8d8300cc2
                             # The following are held under Email Filtering & Actions
			     # Filter Time Range | ID: 291f5d67-13af-1b11-7e39-52b9d60288dc
			     # Filter Date Range | ID: ecf521df-6ff1-aa5c-0069-52b9d605f284
			     # Filter Day Range | ID: bb105bd2-6d5d-e9b1-dc66-52ba021e1f63
			     # Filter Date+Time Concat | ID: cc55a107-98ca-8261-9900-52ce36601cd0
                             # Filter Servers | ID: 6de9b547-7c78-9ff4-83ea-52a8dc7f33f1 
                             # Multiple Strings in Body - ALL must match | ID: 5baf4830-c7c5-7a99-0149-54091ff99022
                             # All strings must be in Subject | ID: 6ffb1f7d-273e-6bc9-9688-532706510ec4
                             # Multiple Strings in Body (Any OK) | ID: 21a5e0a4-e760-351b-e606-52c8e5f5ce89
                             # Sender and Body String Match | ID: a5d69649-6e50-56e1-d52c-52b8ddb43cd0
                             # Sender and Subject (not exact) String Match | ID: 9dcd893b-93bb-ade3-57d5-52d08a4cdb09
                             # Sender and Subject Exact String Match | ID: 6e27808f-9fa0-f469-d04d-52b8dcb4bc8a
                             # Sender Email Only | ID: 4f3d2814-e8ff-18a0-3d0f-52b8d841b39e
                             # String Exactly Matches Subject Only | ID: 9dc67d76-b728-5a03-f8bf-52b8daf4da69
                             # String in Body | ID: 50be0484-2daf-dd18-0b6b-52b8da93e1df
                             # String in Subject Only | ID: b52694ac-cf4d-839e-3a74-52b8da5eb6c0
                             # String in Subject or Body | ID: 275f496d-eab4-6cf3-3add-52e191ce3241

                             # IPs/Servers | ID: ef1bdff1-4df1-1562-7bd9-52c04ed4dae7
                             # Counter match triggers not included because it depends on the count each alert
                             # - not based on the count of filterbits per filter to decide whether to role onwards to catch all or not.

                             $filterbit_trigger_params[0] = " sclm_configurationitems_id_c='".$filter_id."' && enabled=1 && (sclm_configurationitemtypes_id_c='83a83279-9e48-0bfe-3ca0-52b8d8300cc2' || sclm_configurationitemtypes_id_c='291f5d67-13af-1b11-7e39-52b9d60288dc' || sclm_configurationitemtypes_id_c='ecf521df-6ff1-aa5c-0069-52b9d605f284' || sclm_configurationitemtypes_id_c='bb105bd2-6d5d-e9b1-dc66-52ba021e1f63' || sclm_configurationitemtypes_id_c='cc55a107-98ca-8261-9900-52ce36601cd0' || sclm_configurationitemtypes_id_c='5baf4830-c7c5-7a99-0149-54091ff99022' || sclm_configurationitemtypes_id_c='6de9b547-7c78-9ff4-83ea-52a8dc7f33f1' || sclm_configurationitemtypes_id_c='6ffb1f7d-273e-6bc9-9688-532706510ec4' || sclm_configurationitemtypes_id_c='21a5e0a4-e760-351b-e606-52c8e5f5ce89' || sclm_configurationitemtypes_id_c='a5d69649-6e50-56e1-d52c-52b8ddb43cd0' || sclm_configurationitemtypes_id_c='9dcd893b-93bb-ade3-57d5-52d08a4cdb09' || sclm_configurationitemtypes_id_c='6e27808f-9fa0-f469-d04d-52b8dcb4bc8a' || sclm_configurationitemtypes_id_c='4f3d2814-e8ff-18a0-3d0f-52b8d841b39e' || sclm_configurationitemtypes_id_c='9dc67d76-b728-5a03-f8bf-52b8daf4da69' || sclm_configurationitemtypes_id_c='50be0484-2daf-dd18-0b6b-52b8da93e1df' || sclm_configurationitemtypes_id_c='b52694ac-cf4d-839e-3a74-52b8da5eb6c0' || sclm_configurationitemtypes_id_c='275f496d-eab4-6cf3-3add-52e191ce3241' || sclm_configurationitemtypes_id_c='ef1bdff1-4df1-1562-7bd9-52c04ed4dae7') ";

                             $filterbit_trigger_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c"; // select array
                             $filterbit_trigger_params[2] = ""; // group
                             $filterbit_trigger_params[3] = ""; // order
                             $filterbit_trigger_params[4] = ""; // limit
                             $filterbit_triggers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_trigger_object_type, $filterbit_trigger_action, $filterbit_trigger_params);

                             $triggercount = count($filterbit_triggers);
                   
                             $filterbit_params[0] = $filterbits;
                             $filterbit_params[1] = $subject;
                             $filterbit_params[2] = $from_mailname;
                             $filterbit_params[3] = $body;
                             $filterbit_params[4] = $date;
                             $filterbit_params[5] = $udate;
#                             $filterbit_params[6] = $filespack;
                             $filterbit_params[6][0] = $filespack;
                             $filterbit_params[6][1] = $contentpack;
                             $report = $report.$filter_message;
                             $filterbit_params[7] = $report;
                             $filterbit_params[8] = $match;
                             $filterbit_params[9] = $debug;
                             $filterbit_params[10] = $filter_id;

                             if ($check_all_filter_id != NULL){
                                $filterbit_params[11] = TRUE;
                                }

                             # 2016-06-18 - updated
                             # $filterbit_params[12] = #$catchall;
                             $filterbit_params[12] = FALSE;
                             $filterbit_params[13] = $check_maint_servers;
                             $filterbit_params[14] = $previous_ticket;
                             $filterbit_params[15] = $previous_title;
                             $filterbit_params[16] = $previous_subject;
                             $filterbit_params[17] = $email_id;
                             $filterbit_params[18] = $tolist;
                             $filterbit_params[19] = $cclist;
                             $filterbit_params[20] = count($filterbit_triggers);
                             $filterbit_params[22] = $precheckparams;

                             ##########################################
                             # Begin doing filterbits

                             if ($debug == TRUE){

                                #echo $report;
                                #echo "<P>";
                                #var_dump($filterbit_params); 
                                #xit;

                                }

                             $filterbit_returns = $this->do_filterbits ($filterbit_params);
                             $report = $filterbit_returns[0];
                             $match = $filterbit_returns[1];
                             $create_mail = $filterbit_returns[2];
                             $create_ticket = $filterbit_returns[3];
                             $create_activity = $filterbit_returns[4];
                             $catchall = $filterbit_returns[5];
                             $previous_ticket = $filterbit_returner[6];
                             $previous_title = $filterbit_returner[7];
                             $previous_subject = $filterbit_returner[8];
                             $trigger_rate = $filterbit_returner[9];
                             $thistriggercount = $filterbit_returner[10];
                             $thismushi = $filterbit_returner[11];

                             } // if is_array($filterbits)

                          # End Filterbits Array Loop
                          ##########################################
                          # If TRUE, then no need to continue filters

		          #if ($create_mail == TRUE || $create_ticket == TRUE || $create_activity == TRUE){

                          if ($debug == TRUE){
                             #echo $report;
                             #ob_flush();
                             #flush();
                             }

		          if ($thismushi == TRUE){

                             $catchall = FALSE; 
                             break;

                             }

		          if ($match == TRUE){

                             $catchall = FALSE; 
                             break;

                             } #elseif ($cntfltr == count($filters)-1 && $catchall == TRUE){

                             #elseif ($trigger_rate < $thistriggercount && $match == FALSE){
                             #$catchall = TRUE; 
                             #break1;

                             #} // end elseif
                             

                          } // for ($cntfltr=0;$cntfltr < count($filters);$cntfltr++){

                      # End for Filters
                      ###################################
                      } // array filters

                   ##########################################
                   # Have Filters - do again to check for catch-all

                   if ($catch_all_filter_id != NULL && $catchall == TRUE){

                      # Use Filter to collect components
                      $filterbit_object_type = "ConfigurationItems";
                      $filterbit_action = "select";
                      $filterbit_params[0] = " sclm_configurationitems_id_c='".$catch_all_filter_id."' ";
                      $filterbit_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c";
                      $filterbit_params[2] = ""; // group;
                      $filterbit_params[3] = ""; // order;
                      $filterbit_params[4] = ""; // limit
  
                      $filterbits = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_object_type, $filterbit_action, $filterbit_params);

                      ##########################################
                      # Have Filter Bits

                      if (is_array($filterbits)){

                         if ($debug == TRUE || $catch_all_filter_id != NULL){
                            $report .= "<div style=\"".$divstyle_grey."\"><center><B>Debug for Catch-all Filter: ".$catch_all_filter_name."</B></center></div>";
                            $report .= $debugger." Catch All Filter Run: <B>".$catch_all_filter_name."</B> - need to collect filter components<BR>";
                            } 

                         # How many triggers must be met to be true
                         $filterbit_trigger_object_type = "ConfigurationItems";
                         $filterbit_trigger_action = "select";
                         $trigger_type = "83a83279-9e48-0bfe-3ca0-52b8d8300cc2";
                         $filterbit_trigger_params[0] = " sclm_configurationitems_id_c='".$catch_all_filter_id."' && enabled=1 && sclm_configurationitemtypes_id_c='".$trigger_type."' ";
                         $filterbit_trigger_params[1] = "id,sclm_configurationitems_id_c,name,description,sclm_configurationitemtypes_id_c";
                         $filterbit_trigger_params[2] = ""; // group
                         $filterbit_trigger_params[3] = ""; // order
                         $filterbit_trigger_params[4] = ""; // limit
                         $filterbit_triggers = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $filterbit_trigger_object_type, $filterbit_trigger_action, $filterbit_trigger_params);

                         $triggercount = count($filterbit_triggers);

                         ############################
                         # Do Logger
                         if ($do_logger == TRUE){
                            $log_content = "For Catch-all Filter [".$bodyfiledate."]: ".$catch_all_filter_name;
                            $logparams[0] = $log_location;
                            $logparams[1] = $log_name;
                            $logparams[2] = $log_content;
                            $funky_gear->funky_logger ($logparams);
                            }
                         # End Logger 
                         ############################
     
                         $filterbit_params[0] = $filterbits;
                         $filterbit_params[1] = $subject;
                         $filterbit_params[2] = $from_mailname;
                         $filterbit_params[3] = $body;
                         $filterbit_params[4] = $date;
                         $filterbit_params[5] = $udate;
#                         $filterbit_params[6] = $filespack;
                         $filterbit_params[6][0] = $filespack;
                         $filterbit_params[6][1] = $contentpack;
                         $filterbit_params[7] = $report;
                         $filterbit_params[8] = TRUE;
                         $filterbit_params[9] = $debug;
                         $filterbit_params[10] = $catch_all_filter_id;
                         $filterbit_params[11] = TRUE;
                         $filterbit_params[12] = TRUE;
                         $filterbit_params[13] = $check_maint_servers;
                         $filterbit_params[14] = $previous_ticket;
                         $filterbit_params[15] = $previous_title;
                         $filterbit_params[16] = $previous_subject;
                         $filterbit_params[17] = $email_id;
                         $filterbit_params[18] = $tolist;
                         $filterbit_params[19] = $cclist;
                         $filterbit_params[20] = count($filterbit_triggers);
                         $filterbit_params[21] = "";
                         $filterbit_params[22] = $precheckparams;

                         $filterbit_returns = $this->do_filterbits ($filterbit_params);
                         $report = $filterbit_returns[0];
                         $match = $filterbit_returns[1];
                         $create_mail = $filterbit_returns[2];
                         $create_ticket = $filterbit_returns[3];
                         $create_activity = $filterbit_returns[4];
                         $catchall = $filterbit_returns[5];
                         $previous_ticket = $filterbit_returner[6];
                         $previous_title = $filterbit_returner[7];
                         $previous_subject = $filterbit_returner[8];
                         $trigger_rate = $filterbit_returner[9];
                         $thistriggercount = $filterbit_returner[10];

                         } // is array filterbits

                      # End Have Filter Bits
                      ##########################################
   
                      } // if match false
   
                   # End Catch-all
                   ##########################################
                   # Get ride of any files not used with no match

                   if (is_array($filespack) && $match == FALSE && ($create_mail == FALSE || $create_ticket == FALSE || $create_activity == FALSE || $catch_all_filter_id == NULL || $catchall == TRUE)){
                               
                      foreach ($filespack as $filename->$link){
                                            
                              $email_content .= $filename.": ".$link."\n";
                              $this_file_location = "/var/www/vhosts/scalastica.com/httpdocs/content/".$portal_account_id."/".$filename;

                              if ($debug == TRUE || $check_all_filter_id != NULL){
                                 $report .= $debugger." Delete Filename: ".$this_file_location.": ".$link."<BR>";
                                 }

                              unlink($this_file_location);

                              } // foreach

                      } // files

                   # End Get rid of any files not used with no match
                   ##########################################

                   } // for filter sets

               } else { // array filter sets       

               # Duplicate Exists
               if ($debug == TRUE){
                  #
                  }

               } // end filtersets

            } // end if ($valtype == 'test_filter_all_live'

            } // end if create activity

         # if perform
         #################################################

         $previous_body = $body; // check for duplicates
         $previous_date = $date;
         $previous_subject = $subject;

         } // end looping through imap emails

     #########################################
     # End looping through each email available

     $final_messages .= "<div style=\"".$divstyle_white."\">".$report."</div>";
     $report = "";
     $final_message = "";
     $filter_message = "";
     $header_message = "";

     $imap_emails = "<div style=\"overflow:auto;min-height:200px;max-height:500px;width:98%;\">".$imap_emails."</div>";

     } else { // if array emails

     $imap_emails = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

     }

  $filterreturner[0] = $imap_emails;
  $filterreturner[1] = $final_messages;

  return $filterreturner;

 } // end do_filters function

# do_filters
#####################

}

# End Functions
########################
?>