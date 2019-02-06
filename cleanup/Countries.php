<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Countries.php 
##########################################################
# case 'Countries':

  switch ($action){
 
   case 'list': 
   ################################
   # Start view Countries
    
    $ci_object_type = 'Countries';
    $ci_action = 'select';
    
    if ($object_return_params[0] == NULL){
       $object_return_params[0] = " deleted=0 ";
       } else {
       $object_return_params[0] = $object_return_params[0]." && deleted=0 ";
       }

    $ci_params = array();
    $ci_params[0] = $object_return_params[0];
    $ci_params[1] =  "id,name,population,two_letter_code,flag_id,flag_image,view_count";
    $ci_params[2] =  "";
    $ci_params[3] = " view_count DESC "; // order
    $ci_params[4] = ""; // limit

    //$params[1] =  array('id','name','date_entered','date_modified','modified_user_id','created_by','description','deleted','assigned_user_id','name_e','name_j','name_ch','type','sub_type','sovereignty','capital','currency_code','currency_name','telephone_code','two_letter_code','three_letter_code','iso_number','tld','cmv_governments_id_c','latitude','longitude','population');
       
    //$the_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
    $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);
    
    if ($cmn_countries_id_c){
       $user_country = dlookup("cmn_countries", "name", "id='".$cmn_countries_id_c."'");   
       $user_two_letter_code = dlookup("cmn_countries", "two_letter_code", "id='".$cmn_countries_id_c."'");   
       }

    ####################################
    # Check current user to allow to create Party for this Country
/*
    if ($sess_contact_id){
   
       $contact_object_type = 'contacts';
       $contact_action = 'select_cstm';
    
       $contact_params = array();
       $contact_params[0] ="contacts_cstm.id_c='".$sess_contact_id."'";
    
       $contact_params[1] =  "id_c,create_party_count_c";
       //$contact_params[1] = array('id','create_party_count_c');
       
       //$contact_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
       $contact_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $contact_object_type, $contact_action, $contact_params);

       if (is_array($contact_list)){
      
          for ($cnt=0;$cnt < count($contact_list);$cnt++){
 
              $create_party_count_c = $contact_list[$cnt]['create_party_count_c'];     
              $create_party_count_c = intval($create_party_count_c);
 
              } // end for loop

          } // end if array

       } // end if contact
  */
  
    # End Check current user to allow to create Party for this Country
    ####################################
    
    if (is_array($the_list)){
      
     for ($cnt=0;$cnt < count($the_list);$cnt++){

      $id = $the_list[$cnt]['id'];
      $name = $the_list[$cnt]['name'];
      $population = $the_list[$cnt]['population'];
      $two_letter_code = $the_list[$cnt]['two_letter_code'];
//      $view_count = $the_list[$cnt]['view_count'];
//      $view_count_show = "[".$strings["Views"].": ".$view_count."]";

      $population = intval($population);

      $flag_id = $the_list[$cnt]['flag_id'];
      $flag_image = $the_list[$cnt]['flag_image'];

      if ($flag_image == 'NULL'){
         $flag = "<img src=\"images/blank.gif\" border=\"0\" width=\"16\" alt=\"".$name."\">";
         } else {
         if (substr($flag_image, 0, 4)=='http'){
            $flag = "<img src=\"".$flag_image."\" width=\"16\" border=\"0\" alt=\"".$name."\">";
            } else {
            $flag = "<img src=\"images/flags/".$flag_image."\" width=\"16\" border=\"0\" alt=\"".$name."\">";
            }
         }

      $world_population = $world_population+$population;
      
      $country = "";
      $country = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Countries&action=view&value=".$id."&valuetype=Countries');return false\">".$flag." <font=#151B54><B>".$name."</B></font></a>";

      $show_population = number_format($population);
      if ($population<2){
       $show_population = "...Checking... ";
       }

      if ($user_two_letter_code == $two_letter_code){
         $internet_country = "<font color=red><B>*Your Internet Country*</B></font> ";
         } else {
         $internet_country = "";
         } 

      if($create_party_count_c>0){      
        $create = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=PoliticalParties&action=add&value=".$id."&valuetype=Countries');return false\"><font color=red><B>-> Create Political Party</B></font></a>";
        } else {
        $create = "";
        } 

      $countries .= "<div style=\"".$divstyle_white."\">".$country." (".$two_letter_code.") ".$internet_country."-> <B>".$strings["Population"].":</B> ".$show_population." ".$create." ".$view_count_show."</div>";
      
     } // end for
     
    $world_population = number_format($world_population);

//    $countries = "<div style=\"margin-left:0px;float: left; background:#FFE4B5; width: 98%;height:100%;border:1px dotted #555;border-radius: 5px; padding: 5px 5px 5px 5px;\"><B>Your Internet Country -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Countries&action=view&value=".$id."&valuetype=id');return false\"><font=#151B54><B>".$user_country." (".$user_two_letter_code.")</B></font></a></div><div style=\"margin-left:0px;float: left; background:#FFE4B5; width: 98%;height:100%;border:1px dotted #555;border-radius: 5px; padding: 5px 5px 5px 5px;\"><B>World -> ".$strings["Population"].": ".$world_population."</B></div>".$countries;

    $countries = "<div style=\"".$divstyle_orange_light."\"><B>Your Internet Country -> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Countries&action=view&value=".$id."&valuetype=Countries');return false\"><font=#151B54><B>".$user_country." (".$user_two_letter_code.")</B></font></a></div>".$countries;
     
    } else {// end if
             
    $countries = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";
          
    } // end if no countries!
    
    echo $countries;

    echo "<img src=\"images/blank.gif\" border=\"0\" height=20 width=\"98%\" alt=\"".$name."\">";

    if ($valtype != 'Search'){
       // Make Embedded Object Link
       $params = array();
       $params[0] = $strings["Countries"];
  //     echo $funky_gear->makeembedd ($do,'list','NULL','NULL',$params);

       }
   
   break; // end list country
   case 'view':

    ################################
    # Start Countries View
    
    $ci_object_type = 'Countries';
    $ci_action = 'select';
    
    $ci_params = array();
    $ci_params[0] ="id='".$val."' ";
    $ci_params[1] = "*"; // selected fields
    $ci_params[2] = ""; //group
    $ci_params[3] = ""; // order
    $ci_params[4] = ""; // limit

    //$params[1] =  array('id','name','date_entered','date_modified','modified_user_id','created_by','description','deleted','assigned_user_id','name_e','name_j','name_ch','type','sub_type','sovereignty','capital','currency_code','currency_name','telephone_code','two_letter_code','three_letter_code','iso_number','tld','cmv_governments_id_c','latitude','longitude','population');
    
    //echo "User: ".$crm_api_user2." PASS: ".$crm_api_pass2." URL: ".$crm_wsdl_url2."<P>";
    
    //$the_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);
    $the_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);
    
    if (is_array($the_list)){

       // Flag about script

       for ($cnt=0;$cnt < count($the_list);$cnt++){

           //$id = $the_list[$cnt]['id'];
           $name = $the_list[$cnt]['name'];
           $population = $the_list[$cnt]['population'];
           $population = intval($population);
           $show_population = number_format($population);

           if ($population<2){
              $show_population = "-";
              }

           $date_entered = $the_list[$cnt]['date_entered'];
           $date_modified = $the_list[$cnt]['date_modified'];
           $modified_user_id = $the_list[$cnt]['modified_user_id'];
           $created_by = $the_list[$cnt]['created_by'];
           $description = $the_list[$cnt]['description'];
           $description = str_replace("\n", "<br>",  $description);

           $assigned_user_id = $the_list[$cnt]['assigned_user_id'];
//           $name_e = $the_list[$cnt]['name_e'];
//           $name_j = $the_list[$cnt]['name_j'];
//           $name_ch = $the_list[$cnt]['name_ch'];
           $type = $the_list[$cnt]['type'];
           $sub_type = $the_list[$cnt]['sub_type'];
           $sovereignty = $the_list[$cnt]['sovereignty'];
           $capital = $the_list[$cnt]['capital'];
           $currency_code = $the_list[$cnt]['currency_code'];
           $currency_name = $the_list[$cnt]['currency_name'];
           $telephone_code = $the_list[$cnt]['telephone_code'];
           $two_letter_code = $the_list[$cnt]['two_letter_code'];
           $three_letter_code = $the_list[$cnt]['three_letter_code'];
           $iso_number = $the_list[$cnt]['iso_number'];
           $tld = $the_list[$cnt]['tld'];
//           $cmv_governments_id_c = $the_list[$cnt]['cmv_governments_id_c'];
           $latitude = $the_list[$cnt]['latitude'];
           $longitude = $the_list[$cnt]['longitude'];
           $flag_id = $the_list[$cnt]['flag_id'];
           $flag_image = $the_list[$cnt]['flag_image'];
           $view_count = $the_list[$cnt]['view_count'];
 
           } // end for
     
       } // end if      

    if ($latitude && $longitude){
       
       $countries .= "<P><div style=\"".$divstyle_white."\"><a href=\"#\" onClick=\"changemapwidth();GMAPLL($latitude,$longitude);return false\"><font color=red><B>View Map</B></font></a></div><P>";
             
       } else { // end country map
      
       // Use Country name as address
       $country_add = str_replace("", "'", $name);
       $country_add = str_replace(" ", "+", $country_add);
       
          //$countries .= "<P><div style=\"margin-left:0px;float: left; background:white; width: 95%;height:100%;border:1px dotted #555;border-radius: 15px; padding: 5px 5px 5px 5px;\"><a href=\"#\" onClick=\"changemapwidth();GMAPADD('".$country_add."');return false\"><font color=red><B>View Map</B></font></a></div><P>";     
       }

    if ($flag_image == 'NULL'){
       $flag = "<img src=\"images/blank.gif\" border=\"0\" width=\"16\" alt=\"".$name."\">";
       } else {
       if (substr($flag_image, 0, 4)=='http'){
          $flag = "<img src=\"".$flag_image."\" width=\"150\" border=\"0\" alt=\"".$name."\">";
          } else {
          $flag = "<a href=\"https://www.cia.gov/library/publications/the-world-factbook/geos/".$flag_id.".html\" target=\"Flags\">View Country data at the CIA Website<BR><img src=\"images/flags/".$flag_image."\" width=\"150\" border=\"0\" alt=\"".$name."\"></a>";
          }
       }
      
    $country = "";
    $country .= $flag."<P>";
    $country .= "<B>".$strings["Country"].":</B> ".$name."<BR>";
    $country .= "<B>".$strings["Population"].":</B> ".$show_population."<BR>";

/*
    if ($cmv_governments_id_c){
       $government = dlookup("cmv_governments", "name","id='".$cmv_governments_id_c."'");
       $government = "<img src=images/Government-OrangeTransx50.gif width=10 alt=\"".$portal_title."\"> <a href=\"#\" onclick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Governments&value=".$cmv_governments_id_c."&valuetype=Governments&action=view');cleardiv('LDiv');cleardiv('RDiv');\"><font size=1>".$government."</font></a>";
       $country .= "<B>".$strings["Government"].":</B> ".$government."<BR>";
       }
*/
    $new_viewcount = $view_count+1;

    // Add View Count
    $ci_action = "update";
    $ci_params = array();  
    $ci_params = array(
      array('name'=>'id','value' => $val),
      array('name'=>'view_count','value' => $new_viewcount),
    );

//    $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $ci_object_type, $ci_action, $ci_params);

    ####################################
    # Check current user to allow to create Party for this Country
/*
    if ($sess_contact_id){
   
       $contact_object_type = 'contacts';
       $contact_action = 'select_cstm';
    
       $contact_params = array();
       $contact_params[0] ="contacts_cstm.id_c='".$sess_contact_id."'";
    
       $contact_params[1] =  "id_c,create_party_count_c";
       //$contact_params[1] = array('id','create_party_count_c');
       
       //$contact_list = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $contact_object_type, $contact_action, $contact_params);
       $contact_list = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $contact_object_type, $contact_action, $contact_params);

       if (is_array($contact_list)){
      
          for ($cnt=0;$cnt < count($contact_list);$cnt++){
 
              $create_party_count_c = $contact_list[$cnt]['create_party_count_c'];     
              $create_party_count_c = intval($create_party_count_c);
 
              } // end for loop

          } // end if array

       } // end if contact
  */
  
    # End Check current user to allow to create Party for this Country
    ####################################
/*
    if ($create_party_count_c>0){      

       $country .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=PoliticalParties&action=add&value=".$val."&valuetype=Countries');return false\"><font color=red><B>Create Political Party</B></font></a><BR>";

       } else {
     
       $country .= "<B>No Credits to create Political Parties</B><BR>";
     
       }
*/

    $country .= "<B>".$strings["Views"].":</B> ".$new_viewcount."<BR>";
    $country .= "<B>Type:</B> ".$type."<BR>";
    $country .= "<B>Sub Type:</B> ".$sub_type."<BR>";
    $country .= "<B>Sovereignty:</B> ".$sovereignty."<BR>";
    $country .= "<B>Capital:</B> ".$capital."<BR>";
    $country .= "<B>Currency Code:</B> ".$currency_code."<BR>";
    $country .= "<B>Currency Name:</B> ".$currency_name."<BR>";
    $country .= "<B>Telephone Code:</B> ".$telephone_code."<BR>";
    $country .= "<B>Two Letter Code :</B> ".$two_letter_code ."<BR>";
    $country .= "<B>ISO Number:</B> ".$iso_number."<BR>";
    $country .= "<B>Domain TLD:</B> ".$tld."<BR>";
    $country .= "<B>Latitude:</B> ".$latitude."<BR>";
    $country .= "<B>Longitude:</B> ".$longitude."<BR>";
    $country .= "<B>".$strings["Description"].":</B> ".$description."<BR>";

      
    //$countries .= "<div style=\"margin-left:0px;float: left; background:white; width: 98%;height:100%;border:1px dotted #555;border-radius: 15px; padding: 5px 5px 5px 5px;\">".$country." -> ".$strings["CountryCapital"].": ".$capital." -> ".$strings["Population"].": ".$population."</div>";
    $countries .= "<div style=\"".$divstyle_white."\">".$country."</div>";

       /*
      $countries .= "<P><div style=\"margin-left:0px;float: left; background:white; width: 95%;height:100%;border:1px dotted #555;border-radius: 15px; padding: 5px 5px 5px 5px;\"><form> 
      <p> 
        <input type=\"text\" size=\"50\" id=\"address\" name=\"address\" value=\"".$name."\" /> 
        <a href=\"#\" onClick=\"loader('map_canvas');changemapwidth();GMAPADD();\"><font color=red><B>Get Map</B></font></a>
      </p> 
      <div id=\"map_canvas\" style=\"width: 0px; height: 0px\"></div> 
    </form></div><P>";      
      */
     //$countries .= "<div id=\"map_canvas\" style=\"width: 0px; height: 0px\"></div>";

     
//    $print_vote = $this->funkydone ($_POST,$lingo,'Votes','print_vote',$val,'Countries',$bodywidth);

//    echo $print_vote; 
//    echo "<BR><img src=images/blank.gif width=500 height=10><BR>";

    echo "<P><div id=\"map_canvas\" style=\"width: 0px; height: 0px\"></div><P>";
    
    $countries = "<div style=\"".$divstyle_orange_light."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Countries&action=list&value=&valuetype=');return false\"><-".$strings["Countries"]."</a></div><div style=\"".$divstyle_white."\">".$countries."</div>";

    echo $object_return."<br>";

    echo $countries;

    echo "<img src=\"images/blank.gif\" border=\"0\" height=10 width=\"98%\" alt=\"".$name."\">";
    
    // Make Embedded Object Link
//    $params = array();
//    $params[0] = $name;
//    echo $funky_gear->makeembedd ($do,'view',$val,$valtype,$params);

//    echo "<img src=\"images/blank.gif\" border=\"0\" height=10 width=\"98%\" alt=\"".$name."\">";

    # End View Countries
    ################################
    # Start States

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";
/*
    $title = "States";

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'CountryStates');
    $container_top = $container[0];
    $container_bottom = $container[2];

    echo $container_top;

    echo $this->funkydone ($_POST,$lingo,'CountryStates','list',$val,$do,$bodywidth);
*/

    # End States
    ################################

   break;  // end view country
   case 'process':

    $process_params[] = array('name'=>'type','value' => $sent_type);
    $process_params[] = array('name'=>'sub_type','value' => $sent_sub_type);
    $process_params[] = array('name'=>'sovereignty','value' => $sent_sovereignty);
    $process_params[] = array('name'=>'capital','value' => $sent_capital);
    $process_params[] = array('name'=>'currency_code','value' => $sent_currency_code);
    $process_params[] = array('name'=>'currency_name','value' => $sent_currency_name);
    $process_params[] = array('name'=>'telephone_code','value' => $sent_telephone_code);
    $process_params[] = array('name'=>'two_letter_code','value' => $sent_two_letter_code);
    $process_params[] = array('name'=>'three_letter_code','value' => $sent_three_letter_code);
    $process_params[] = array('name'=>'iso_number','value' => $sent_iso_number);
    $process_params[] = array('name'=>'tld','value' => $sent_tld);
    $process_params[] = array('name'=>'latitude','value' => $sent_latitude);
    $process_params[] = array('name'=>'longitude','value' => $sent_longitude);
    $process_params[] = array('name'=>'population','value' => $sent_population);
    $process_params[] = array('name'=>'flag_id','value' => $sent_flag_id);
    $process_params[] = array('name'=>'flag_image','value' => $sent_flag_image);

   break;
   
  } // end actions

# break; // End Countries
##########################################################
?>