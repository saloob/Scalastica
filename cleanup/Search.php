<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-09-14
# Page: Search.php 
##########################################################
# case 'Search':

//   $keyword = $_POST['keyword'];
   $keyword = $_POST['value'];
//   $keyword = $val;
   $date = date("Y-m-d G:i:s");

   //$keyword = str_replace(" ", "_", $keyword);

 switch ($action){

  case 'search':
  case 'search_record':

   if ($sess_contact_id == NULL){

      $search_contact_id = 'ceadfac1-d392-7883-d2b4-52355c9bc961'; // Null Contact created under the Scalastica Account.

      } else {

      $search_contact_id = $sess_contact_id;

      }

   // Record the keyword
   if ($keyword != NULL){
      // First look to see if it exists
      $search_object_type = "SearchKeywords";
      $search_action = "select";
      $search_params = array();
      $search_params[0] = "name='".$keyword."' && sclm_leadsources_id_c='".$sess_leadsources_id_c."' ";
      $search_params[1] = ' id,name,search_count ';
      $search_params[2] = "";

      $keyword_result = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $search_object_type, $search_action, $search_params);

      if (is_array($keyword_result)){

         //echo "Keyword result exists: <P>";
         //var_dump($keyword_result);

         for ($cnt=0;$cnt < count($keyword_result);$cnt++){

             $keyword_id = $keyword_result[$cnt]['id'];
             $name = $keyword_result[$cnt]['name'];
             $search_count = $keyword_result[$cnt]['search_count'];

             //echo "CNT: $search_count ID: $keyword_id <P>";

             } // end foreach

         $new_count = $search_count+1;

         // Simply update with date

         $search_object_type = "SearchKeywords";
         $search_action = "update";
         $search_params = array();  
         $search_params = array(
        array('name'=>'id','value' => $keyword_id),
        array('name'=>'date_modified','value' => $date),
        array('name'=>'search_count','value' => $new_count),
        ); 
        
         $keyword_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $search_object_type, $search_action, $search_params);

         //echo "Keyword result updated: <P>";
         //var_dump($keyword_result);

         // Create related stats for this keyword if not exist for this user

         $search_object_type = "SearchKeywordStats";
         $search_action = "select";
         $search_params = array();
         $search_params[0] = "cmn_searchkeywords_id_c='".$keyword_id."' && contact_id_c='".$search_contact_id."' ";
         $search_params[1] = 'id,cmn_searchkeywords_id_c,name,contact_id_c,search_count';
         $search_params[2] = "";

         $contact_keyword_result = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $search_object_type, $search_action, $search_params);

         if (is_array($contact_keyword_result)){

            //echo "Keyword result exists: <P>";
            //var_dump($contact_keyword_result);

            for ($cnt=0;$cnt < count($contact_keyword_result);$cnt++){

                $contact_keyword_id = $contact_keyword_result[$cnt]['id'];
                //$contact_keyword = $contact_keyword_result[$cnt]['name'];
                $contact_search_count = $contact_keyword_result[$cnt]['search_count'];

                //echo "CNT: $contact_search_count ID: $contact_keyword_id <P>";

                $new_contact_count = $contact_search_count+1;

                $search_object_type = "SearchKeywordStats";
                $search_action = "update";
                $search_params = array();  
                $search_params = array(
        array('name'=>'id','value' => $contact_keyword_id),
        array('name'=>'date_modified','value' => $date),
        array('name'=>'search_count','value' => $new_contact_count),
        ); 
        
                $contact_keywordstats_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $search_object_type, $search_action, $search_params);

                //echo "Keyword Stats Updated: <P>";
                //var_dump($contact_keywordstats_result);

                } // end foreach

            } else {

            // Keyword exists but no stats by same user
            $assigned_user_id = 1;

            $search_object_type = "SearchKeywordStats";
            $search_action = "update";
            $search_params = array();  
            $search_params = array(
        array('name'=>'name','value' => $keyword),
        array('name'=>'assigned_user_id','value' => $assigned_user_id),
        array('name'=>'date_entered','value' => $date),
        array('name'=>'description','value' => "Keyword: ".$keyword." from Country: ".$country_name." with IP: ".$ip_address." by Contact: ".$search_contact_id),
        array('name'=>'cmn_searchkeywords_id_c','value' => $keyword_id),
        array('name'=>'ip','value' => $ip_address),
        array('name'=>'cmv_countries_id_c','value' => $cmn_countries_id_c),
        array('name'=>'contact_id_c','value' => $search_contact_id),
        array('name'=>'search_count','value' => 1),
        ); 
        
            $contact_keyword_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $search_object_type, $search_action, $search_params);

            //echo "contact_Keyword Stats created: <P>";
            //var_dump($contact_keyword_result);

            } // new stat for new user

         } else {// end if count

         // Create new keyword with 1 count

         $assigned_user_id = 1;
         $date = date("Y-m-d G:i:s");

         $search_object_type = "SearchKeywords";
         $search_action = "update";
         $search_params = array();  
         $search_params = array(
        array('name'=>'name','value' => $keyword),
        array('name'=>'sclm_leadsources_id_c','value' => $sess_leadsources_id_c),
        array('name'=>'assigned_user_id','value' => $assigned_user_id),
        array('name'=>'date_entered','value' => $date),
        array('name'=>'description','value' =>  "Keyword: ".$keyword." from Country: ".$country_name." with IP: ".$ip_address." by Contact: ".$search_contact_id),        array('name'=>'search_count','value' => 1),
        ); 
        
         $keyword_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $search_object_type, $search_action, $search_params);
         $keyword_id = $keyword_result['id'];

         //echo "Keyword result created - ID: $keyword_id <P>";
         //var_dump($keyword_result);

         // Create related stats for this keyword
         
         $search_object_type = "SearchKeywordStats";
         $search_action = "update";
         $search_params = array();  
         $search_params = array(
        array('name'=>'name','value' => $keyword),
        array('name'=>'assigned_user_id','value' => $assigned_user_id),
        array('name'=>'date_entered','value' => $date),
        array('name'=>'description','value' => "Keyword: ".$keyword." from Country: ".$country_name." with IP: ".$ip_address." by Contact: ".$search_contact_id),
        array('name'=>'cmv_searchkeywords_id_c','value' => $keyword_id),
        array('name'=>'ip','value' => $ip_address),
        array('name'=>'cmn_countries_id_c','value' => $cmv_countries_id_c),
        array('name'=>'contact_id_c','value' => $search_contact_id),
        array('name'=>'search_count','value' => 1),
        ); 
        
         $keywordstats_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $search_object_type, $search_action, $search_params);

         //echo "Keyword Stats created: <P>";
         //var_dump($keywordstats_result);

         } // end if no count

      } // end if keyword

   if ($action == 'search'){

   $container = "";  
   $container_top = "";
   $container_middle = "";
   $container_bottom = "";

   $container_params[0] = 'open'; // container open state
   $container_params[1] = "95%"; // container_width
   $container_params[2] = $bodyheight; // container_height
   $container_params[3] = $strings["action_search"].": ".$keyword; // container_title
   $container_params[4] = 'Search'; // container_label
   $container_params[5] = $portal_info; // portal info
   $container_params[6] = $portal_config; // portal configs
   $container_params[7] = $strings; // portal configs
   $container_params[8] = $lingo; // portal configs

   $container = $funky_gear->make_container ($container_params);
   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

   echo $container_top;

   ################################
   # Start 

   // Save keywords and use count
   echo "<center><img src=images/icons/Search.png width=100 border=0 alt=\"".$strings["action_search"]."\"></center>";
   $message = str_replace("XXXXXX","<B>".$keyword."</B>", $strings["SearchMessage"]);
   echo "<P><center>".$message."</center><P>";

   echo $container_bottom;

   # End Keyword
   ################################
   # Start Services Data

   $container = "";  
   $container_middle = "";

   $container_params[0] = 'open'; // container open state
   $container_params[1] = "95%"; // container_width
   $container_params[2] = $bodyheight; // container_height
   $container_params[3] = $strings["Services"]; // container_title
   $container_params[4] = 'Services'; // container_label
   $container_params[5] = $portal_info; // portal info
   $container_params[6] = $portal_config; // portal configs
   $container_params[7] = $strings; // portal configs
   $container_params[8] = $lingo; // portal configs

   $container = $funky_gear->make_container ($container_params);
   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

//   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'AccountsServices','list',$keyword,'Search',$bodywidth);  

   # End Services Data
   ################################
   #  Search Advisory

   $container = "";  
   $container_middle = "";

   $container_params[0] = 'open'; // container open state
   $container_params[1] = "95%"; // container_width
   $container_params[2] = $bodyheight; // container_height
   $container_params[3] = $strings["Advisory"]; // container_title
   $container_params[4] = 'Advisory'; // container_label
   $container_params[5] = $portal_info; // portal info
   $container_params[6] = $portal_config; // portal configs
   $container_params[7] = $strings; // portal configs
   $container_params[8] = $lingo; // portal configs

   $container = $funky_gear->make_container ($container_params);
   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

//   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'Advisory','list',$keyword,'Search',$bodywidth);  

   # End Search Advisory
   ################################
   #  Search Industries

   $container = "";  
   $container_middle = "";

   $container_params[0] = 'open'; // container open state
   $container_params[1] = "95%"; // container_width
   $container_params[2] = $bodyheight; // container_height
   $container_params[3] = $strings["Industries"]; // container_title
   $container_params[4] = 'Industries'; // container_label
   $container_params[5] = $portal_info; // portal info
   $container_params[6] = $portal_config; // portal configs
   $container_params[7] = $strings; // portal configs
   $container_params[8] = $lingo; // portal configs

   $container = $funky_gear->make_container ($container_params);
   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

//   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'Industries','list',$keyword,'Search',$bodywidth);  

   # End  Search Industries
   ################################

   # Start Content Data

   $container = "";  
   $container_middle = "";

   $title = $strings["Content"];

//   echo $container_middle;

//   echo $title." ".$strings["action_search_via_keyword"].": ".$keyword."<P>";
   echo $this->funkydone ($_POST,$lingo,'Content','list',$keyword,'Search',$bodywidth);  

   echo $this->funkydone ($_POST,$lingo,'Opportunities','list',$keyword,'Search',$bodywidth);

   echo $this->funkydone ($_POST,$lingo,'Projects','list',$keyword,'Search',$bodywidth);

   echo $this->funkydone ($_POST,$lingo,'ProjectTasks','list',$keyword,'Search',$bodywidth);

   # End Content Data
   ################################
   #  Search Countries

   $container = "";  
   $container_middle = "";

   $container_params[0] = 'open'; // container open state
   $container_params[1] = "95%"; // container_width
   $container_params[2] = $bodyheight; // container_height
   $container_params[3] = $strings["Countries"]; // container_title
   $container_params[4] = 'Countries'; // container_label
   $container_params[5] = $portal_info; // portal info
   $container_params[6] = $portal_config; // portal configs
   $container_params[7] = $strings; // portal configs
   $container_params[8] = $lingo; // portal configs

   $container = $funky_gear->make_container ($container_params);
   $container_top = $container[0];
   $container_middle = $container[1];
   $container_bottom = $container[2];

//   echo $container_middle;

   echo $this->funkydone ($_POST,$lingo,'Countries','list',$keyword,'Search',$bodywidth);  

   # End  Search Countries
   ################################
   #  Search Events

   $container = "";  
   $container_middle = "";

   $title = $strings["Events"];

//   $container = $funky_gear->make_container ($bodyheight,$container_width,$title,'Events');
   $container_middle = $container[1];

//   echo $container_middle;

//   echo $this->funkydone ($_POST,$lingo,'Events','list',$keyword,'Search',$bodywidth);  

   # End Search Events
   ################################
   # Search Comments

   $container = "";  
   $container_middle = "";

   $title = $strings["Comments"];


//   echo $container_middle;

//   echo $this->funkydone ($_POST,$lingo,'Comments','list',$keyword,'Search',$bodywidth);  

   // if linkedin
   //$searchParam        =   "company-name={$keyword}&current-company=true&start=0&count=25&sort=distance";
   //$search_response    =   $linkedin->search("?$searchParam");
  
   # End Search Comments
   ################################
   #  Search News

   $container = "";  
   $container_middle = "";

   $title = $strings["News"];


//   echo $container_middle;
  
//   echo $this->funkydone ($_POST,$lingo,'News','list',$keyword,'Search',$bodywidth);
    
   # End Search News
   ################################

//   echo $container_bottom;

   } // end if action = search

  break;
  case 'create_form_basic':

   echo "<div style=\"".$divstyle_Body."\">";

$action_search = $strings["action_search"];

$searchform = <<< SEARCHFORM
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <input type="text" id="value" name="value" value="$val" size="10">
     <input type="hidden" id="pg" name="pg" value="$Body" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="$valtype" >
     <input type="button" name="button" value="$action_search" onclick="javascript:loader('$BodyDIV');get(this.parentNode);">
    </div>
   </form>
</center>
SEARCHFORM;

echo $searchform;

   echo "</div>";

/*

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "value"; // Field Name
    $tablefields[$tblcnt][1] = $strings["action_search"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '100'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = $keyword; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "value";//$field_value_id;
    $tablefields[$tblcnt][21] = $keyword; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = "pg"; // Field Name
    $tablefields[$tblcnt][1] = "Page"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = $Body; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '0';//1; // show in view 
    $tablefields[$tblcnt][11] = $Body; // Field ID
    $tablefields[$tblcnt][20] = "pg"; //$field_value_id;
    $tablefields[$tblcnt][21] = $Body; //$field_value;

/*
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmv_newscategories_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Category"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_newscategories'; // If DB, dropdown_table, if List, then array, other related table    
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'category_'.$lingo;
    $tablefields[$tblcnt][9][4] = ""; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_newscategories_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = ""; // Linkable Object
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_newscategories_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_newscategories_id_c; //$field_value;
*/

/*
    $valpack = "";
    $valpack[0] = $valtype;
    $valpack[1] = "search"; 
    $valpack[2] = "";
    $valpack[3] = $tablefields;
    $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // provide add new button
    $valpack[7] = $strings["action_search"];

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    echo $zaform;

   echo $container_bottom;
*/

  break;
  case 'ticketing':

   echo "<div style=\"".$divstyle_Body."\">";

   $today = date("Y-m-d");
   $encdate = date("Y@m@d@G");
   $body_sendvars = $encdate."#Bodyphp";
   $body_sendvars = $funky_gear->encrypt($body_sendvars);
  
   $this_yearmonth = date("Y-m");     
?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     <?php echo $strings["Ticket"].": "; ?><input type="text" id="ticket_id" name="ticket_id" value="<?php echo $ticket_id; ?>" size="20">
     <?php echo $strings["action_search_keyword"].": "; ?><input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
     <?php echo $strings["Date"].":"; ?><input type="text" id="date" name="date" value="<?php echo $this_yearmonth; ?>" size="20">
     <?php echo "Format = [".$today."]"; ?>
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="rows" name="rows" value="500" >
     <input type="hidden" id="sendiv" name="sendiv" value="GRID" >
     <input type="hidden" id="do" name="do" value="Ticketing" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('GRID');get(this.parentNode);">
    </div>
   </form>
</center>
<P>

<?php

  break;

  } // end action switch 

# break; // End Search
##########################################################
?>