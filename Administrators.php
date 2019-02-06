<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Administrators.php 
##########################################################
# case 'Administrators':

$form_action = $action;

###################################################
# Get Admin Info if available

function check_role ($party_id){

	global $sess_contact_id, $api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params;

	if ($sess_contact_id != NULL){
		// Otherwise role was sent

		$object_type = "Administrators";
		$action = "check_admin";
		$params = array();
		$params[0] = $sess_contact_id;
		$params[1] = 'PoliticalParties';
		$params[2] = $party_id;

		$admin_status = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

		$contact_id_c = $admin_status['contact_id_c'];
		$current_contact_status = $admin_status['current_contact_status'];
		$allow_joiner_requests = $admin_status['allow_joiner_requests'];
		$access_level = $admin_status['access_level'];
		$pparty_admin = $admin_status['political_party_id'];
		$constitution_admin = $admin_status['constitution_id'];
		$government_id = $admin_status['government_id'];

	}

	return $admin_status;

} // end function

# End Check Administrators
###################################################

 
  switch ($valtype){

   case 'Governments':

    $cmv_governments_id_c = $val;

    $return_object = $valtype;
    $return_object_id = $val;
    $admin_object_returner = $funky_gear->object_returner ($return_object, $return_object_id);
    $admin_object_name = $admin_object_returner[0];
    $admin_object_target .= $admin_object_returner[3]."<BR>";

    $object_type = "Administrators";
    $action = "select";
    $params = array();
    $params[0] = $sess_contact_id;
    $params[1] = 'Governments';
    $params[2] = $cmv_governments_id_c;

    $admin_info = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);         

    $admin_id = $admin_info['id'];
    $admin_name = $admin_info['name'];      
    $description = $admin_info['description'];
    $cmv_politicalparties_id_c = $admin_info['cmv_politicalparties_id_c'];
    $access_level = $admin_info['access_level'];
    $allow_joiner_requests = $admin_info['allow_joiner_requests'];

    $list_members_params = array();
    $list_members_params[0] = $sess_contact_id;
    $list_members_params[1] = 'Governments';
    $list_members_params[2] = $val;


   break;
   case 'PoliticalParties':

    $cmv_politicalparties_id_c = $val;

    $return_object = $valtype;
    $return_object_id = $val;
    $admin_object_returner = $funky_gear->object_returner ($return_object, $return_object_id);
    $admin_object_name = $admin_object_returner[0];
    $admin_object_target .= $admin_object_returner[3]."<BR>";

    $object_type = "PoliticalParties";
    $action = "select";
    $params = array();
    $params[0] = "deleted=0 && id='".$cmv_politicalparties_id_c."'";
    $params[1] = "";

    $PoliticalParties = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    if (is_array($PoliticalParties)){
    
       for ($cnt=0;$cnt < count($PoliticalParties);$cnt++){
     
           $cmv_governmenttypes_id_c = $PoliticalParties[$cnt]['cmv_governmenttypes_id_c'];
           $cmv_governments_id_c = $PoliticalParties[$cnt]['cmv_governments_id_c'];

           } // end for

       } // end if array

    $object_type = "Administrators";
    $action = "select";
    $params = array();
    $params[0] = $sess_contact_id;
    $params[1] = 'PoliticalParties';
    $params[2] = $cmv_politicalparties_id_c;

    $admin_info = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);         

    $admin_id = $admin_info['id'];
    $admin_name = $admin_info['name'];      
    $description = $admin_info['description'];
    $cmv_politicalparties_id_c = $admin_info['cmv_politicalparties_id_c'];
    $access_level = $admin_info['access_level'];
    $allow_joiner_requests = $admin_info['allow_joiner_requests'];

    $list_members_params = array();
    $list_members_params[0] = $sess_contact_id;
    $list_members_params[1] = 'PoliticalParties';
    $list_members_params[2] = $val;

   break;

  } // end valtype switch

  switch ($form_action){
   
   case 'list_members':

   	if ($val != NULL && $valtype == 'PoliticalParties'){
   	
   		$admin_status = check_role ($val);
   	
   		$current_contact_status = $admin_status['current_contact_status'];
   		$access_level = $admin_status['access_level'];
   	
   	}
   	
    $list_members_object_type = "Administrators";
    $list_members_action = "select_contacts";

    $admin_contacts = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $list_members_object_type, $list_members_action, $list_members_params); 

//var_dump($admin_contacts);

/*
    $tablefields = ""; 

    $cnt=0; // Want to add the above set also
      
    if (is_array($admin_contacts)){
     
       for ($table_cnt=0;$table_cnt < count($admin_contacts);$table_cnt++){
               
           $id = $admin_info[$table_cnt]['id'];
           $fn = $admin_info[$table_cnt]['fn'];
                  // echo "FN:".$fn."<P>"
           $ln = $admin_info[$table_cnt]['ln'];
           $admin_name = $fn." ".$ln;
        
           echo "<P>".$admin_name."<P>";
        
           $tablefields[$cnt][0] = 'id'; // Field Name
           $tablefields[$cnt][1] = "ID"; // Full Name
           $tablefields[$cnt][2] = 1; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 0; // is_name
           $tablefields[$cnt][5] = 'hidden';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '';//1; // show in view 
           $tablefields[$cnt][11] = $id; // Field ID
           $tablefields[$cnt][20] = 'id';//$field_value_id;
           $tablefields[$cnt][21] = $id; //$field_value; 
        
           $cnt++;

           $tablefields[$cnt][0] = 'first_name'; // Field Name
           $tablefields[$cnt][1] = "First Name"; // Full Name
           $tablefields[$cnt][2] = 0; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 1; // is_name
           $tablefields[$cnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '1';//1; // show in view 
           $tablefields[$cnt][11] = $fn; // Field ID
           $tablefields[$cnt][20] = 'first_name';//$field_value_id;
           $tablefields[$cnt][21] = $fn; //$field_value; 
        
           $cnt++;

           $tablefields[$cnt][0] = 'last_name'; // Field Name
           $tablefields[$cnt][1] = "Last Name"; // Full Name
           $tablefields[$cnt][2] = 0; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 0; // is_name
           $tablefields[$cnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '1';//1; // show in view 
           $tablefields[$cnt][11] = $ln; // Field ID
           $tablefields[$cnt][20] = 'last_name';//$field_value_id;
           $tablefields[$cnt][21] = $ln; //$field_value; 
        
           $cnt++;

           } // end for each
             
       $valpack = "";
       $valpack[0] = 'Contacts';
       $valpack[1] = 'view_list'; 
       $valpack[2] = $valtype;
       $valpack[3] = $tablefields;
       $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $valpack[4] = 0; // add

       // Build parent layer
       $zaform = "";
       $zaform = $funky_gear->form_presentation($valpack);
      
       } else { // end if is array
      
       $zaform = "There are currently no Administrators set for this item";
      
       }
      
    echo $zaform;     
*/


    if (is_array($admin_contacts)){
    
       for ($cnt=0;$cnt < count($admin_contacts);$cnt++){
     
           $id = $admin_contacts[$cnt]['id'];
           $first_name = $admin_contacts[$cnt]['fn'];
           $last_name = $admin_contacts[$cnt]['ln'];

           $admin = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Contacts&action=view&value=".$id."&valuetype=".$list_members_params[1]."');return false\"><font color=#151B54><B>".$first_name." ".$last_name."</B></font></a><BR>";

           $administrators .= "<div style=\"".$divstyle_white."\">".$admin."</div>";
           
           } // end for
           
		} else { // end if array
           
          $administrators = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";
           
        }
        

	if ($current_contact_status){
        	 
     	$add_item = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=".$object_type."&action=add_member&value=".$val."&valuetype=".$object_type."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
        	 
        } else {
        
       	$add_item = "<div style=\"".$divstyle_white."\">".$strings["message_not_logged-in_cant_add"]."</div>";
        	 
        }
                 

    if (count($admin_contacts)>10){
    	echo "<P>".$add_item."<P>".$administrators."<P>".$add_item;
        } else {
    	echo "<P>".$add_item."<P>".$administrators;
         }
                   
   break;
   case 'add':
   case 'edit':

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $title = "Add ".$strings["Administrators"];

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'Administrators');
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
  
    echo $container_top;

    ################################


    $tablefields[$cnt][0] = 'admin_id'; // Field Name
    $tablefields[$cnt][1] = "Admin ID"; // Full Name
    $tablefields[$cnt][2] = 0; // is_primary
    $tablefields[$cnt][3] = 0; // is_autoincrement
    $tablefields[$cnt][4] = 0; // is_name
    $tablefields[$cnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$cnt][6] = '255'; // length
    $tablefields[$cnt][7] = ''; // NULLOK?
    $tablefields[$cnt][8] = ''; // default
    $tablefields[$cnt][9] = '';//$dropdown_table; // related table
    $tablefields[$cnt][10] = '1';//1; // show in view 
    $tablefields[$cnt][11] = $val; // Field ID
    $tablefields[$cnt][20] = 'admin_id';//$field_value_id;
    $tablefields[$cnt][21] = $val; //$field_value; 
        
           $cnt++;

           $tablefields[$cnt][0] = 'contact_id_c'; // Field Name
           $tablefields[$cnt][1] = "Contact"; // Full Name
           $tablefields[$cnt][2] = 0; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 0; // is_name
           $tablefields[$cnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '1';//1; // show in view 
           $tablefields[$cnt][11] = $contact_id_c; // Field ID
           $tablefields[$cnt][20] = 'contact_id_c';//$field_value_id;
           $tablefields[$cnt][21] = $contact_id_c; //$field_value; 
        
       if ($sess_contact_id == $contact_id_c){
        	$admin = 1;
           } else {
           	$admin = "";
           }
      
       $valpack = "";
       $valpack[0] = 'Administrators';
       $valpack[1] = 'add_member'; // process_members
       $valpack[2] = $valtype;
       $valpack[3] = $tablefields;
       $valpack[4] = $admin; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $valpack[5] = 1; // add

       // Build parent layer
       
       echo "<img src=images/blank.gif width=500 height=20><BR>";
       echo "<font color=#FBB117 size=3><B>".$strings["PoliticalPartyManageYouAreAdmin"]."</B></font> - <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=PoliticalParties&action=edit&value=".$val."&valuetype=PoliticalParties');return false\"><font color=red size=3><B>".$strings["PoliticalPartyManage"]."</B></font></a><P>";
       
       $zaform = "";
       $zaform = $funky_gear->form_presentation($valpack);

       echo "<img src=images/blank.gif width=500 height=20><BR>";
       
       echo $zaform;
       
       echo "<img src=images/blank.gif width=500 height=20><BR>";       

    echo $container_bottom;

   break;
   case 'manage':

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $title = $strings["Administrators"];

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'Administrators');
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
  
    echo $container_top;

    ################################
    # Start      
      
    // Get fields for form
      
    $tblcnt = 0;

    // Build for items from admin table 
    $tablefields[$tblcnt][0] = 'id'; // Field Name
    $tablefields[$tblcnt][1] = "Admin ID"; // Full Name
    $tablefields[$tblcnt][2] = 1; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = $admin_id; // Field ID
    $tablefields[$tblcnt][20] = 'id';//$field_value_id;
    $tablefields[$tblcnt][21] = $admin_id; //$field_value;       

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'name'; // Field Name
    $tablefields[$tblcnt][1] = "Name"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '155'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $admin_name; // Field ID
    $tablefields[$tblcnt][20] = 'name';//$field_value_id;
    $tablefields[$tblcnt][21] = $admin_name; //$field_value; 

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'description'; // Field Name
    $tablefields[$tblcnt][1] = "Description"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '155'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $description; // Field ID
    $tablefields[$tblcnt][20] = 'description';//$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;       

    $tblcnt++;
 
    if ($valtype == 'PoliticalParties'){

       $tablefields[$tblcnt][0] = 'cmv_politicalparties_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "Political Parties"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
      
       $object_type = "PoliticalParties";
       $action = "select";
       $params = array();
       $params[0] ="id='".$cmv_politicalparties_id_c."'";
       $params[1] = "";

       $party_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);      
      
       $dd_pack = "";
      
       if (is_array($party_list)){
          arsort ($party_list);
          for ($cnt=0;$cnt < count($party_list);$cnt++){
              $party_id = $party_list[$cnt]['id'];
              $party_name = "party_name_".$lingo;
              $party_name = $party_list[$cnt][$party_name];
              $dd_pack[$party_id] = $party_name;
         
              $view_parties .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=PoliticalParties&action=view&value=".$party_id."&valuetype=".$do."');return false\"><font=#151B54><B>".$party_name."</B></font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=PoliticalParties&action=edit&value=".$party_id."&valuetype=PoliticalParties');return false\"><font color=red><B>".$strings["action_edit"]."</B></font></a><BR>"; 
         
              } // end for

          $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table

          } // end if
       
       $tablefields[$tblcnt][9][2] = 'cmv_politicalparties_id_c';
       $tablefields[$tblcnt][9][3] = 'party_name_'.$lingo;
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_politicalparties_id_c; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_politicalparties_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalparties_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_politicalparties_id_c; //$field_value; 
  
       $tblcnt++;

       } // end if pparty

    $tablefields[$tblcnt][0] = 'cmv_governments_id_c'; // Field Name
    $tablefields[$tblcnt][1] = "Government"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_governments'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = "name";
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_governments_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_governments_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_governments_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_governments_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'access_level'; // Field Name
    $tablefields[$tblcnt][1] = "Access Level"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '1'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
    $dd_pack = "";
    $dd_pack = array();
    $dd_pack[1] = 1;
    $dd_pack[2] = 2;
    $dd_pack[3] = 3;
    $tablefields[$tblcnt][9][1] =$dd_pack;
    $tablefields[$tblcnt][9][2] = 'access_level';
    $tablefields[$tblcnt][9][3] = $strings["AccessLevel"];
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $access_level; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $access_level; // Field ID
    $tablefields[$tblcnt][20] = 'access_level';//$field_value_id;
    $tablefields[$tblcnt][21] = $access_level; //$field_value;  
      
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'allow_joiner_requests'; // Field Name
    $tablefields[$tblcnt][1] = "Allow Join Requests?"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'checkbox';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '1'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = '1'; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $allow_joiner_requests; // Field ID
    $tablefields[$tblcnt][20] = 'allow_joiner_requests';//$field_value_id;
    $tablefields[$tblcnt][21] = $allow_joiner_requests; //$field_value;
      
    $valpack = "";
    $valpack[0] = 'Administrators';
    $valpack[1] = 'edit'; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = 2; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = 0; // No add

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);
      
    echo "<font=#151B54><B>".$strings["action_edit"]." ".$admin_name."</B></font><P>";
    echo $zaform;

    # End
    ################################

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $title = $strings["Administrators"]." ".$strings["List"];

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'AdministratorsList');
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
  
    echo $container_middle;

    ################################
    # Start  Admin List
    
    $object_type = "Administrators";
    $action = "select_contacts";
    $params = array();
    $params[0] = $sess_contact_id;
    $params[1] = $valtype;
    $params[2] = $val;

    $admin_info = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    $tablefields = ""; 

    $cnt=0; // Want to add the above set also
      
    if (is_array($admin_info)){
     
       for ($table_cnt=0;$table_cnt < count($admin_info);$table_cnt++){
               
           $id = $admin_info[$table_cnt]['id'];
           $fn = $admin_info[$table_cnt]['fn'];
                  // echo "FN:".$fn."<P>"
           $ln = $admin_info[$table_cnt]['ln'];
           $admin_name = $fn." ".$ln;
        
           echo "<P>".$admin_name."<P>";
        
           $tablefields[$cnt][0] = 'id'; // Field Name
           $tablefields[$cnt][1] = "ID"; // Full Name
           $tablefields[$cnt][2] = 1; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 0; // is_name
           $tablefields[$cnt][5] = 'hidden';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '';//1; // show in view 
           $tablefields[$cnt][11] = $id; // Field ID
           $tablefields[$cnt][20] = 'id';//$field_value_id;
           $tablefields[$cnt][21] = $id; //$field_value; 
        
           $cnt++;

           $tablefields[$cnt][0] = 'first_name'; // Field Name
           $tablefields[$cnt][1] = "First Name"; // Full Name
           $tablefields[$cnt][2] = 0; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 1; // is_name
           $tablefields[$cnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '1';//1; // show in view 
           $tablefields[$cnt][11] = $fn; // Field ID
           $tablefields[$cnt][20] = 'first_name';//$field_value_id;
           $tablefields[$cnt][21] = $fn; //$field_value; 
        
           $cnt++;

           $tablefields[$cnt][0] = 'last_name'; // Field Name
           $tablefields[$cnt][1] = "Last Name"; // Full Name
           $tablefields[$cnt][2] = 0; // is_primary
           $tablefields[$cnt][3] = 0; // is_autoincrement
           $tablefields[$cnt][4] = 0; // is_name
           $tablefields[$cnt][5] = 'varchar';//$field_type; //'INT'; // type
           $tablefields[$cnt][6] = '255'; // length
           $tablefields[$cnt][7] = ''; // NULLOK?
           $tablefields[$cnt][8] = ''; // default
           $tablefields[$cnt][9] = '';//$dropdown_table; // related table
           $tablefields[$cnt][10] = '1';//1; // show in view 
           $tablefields[$cnt][11] = $ln; // Field ID
           $tablefields[$cnt][20] = 'last_name';//$field_value_id;
           $tablefields[$cnt][21] = $ln; //$field_value; 
        
           $cnt++;

           } // end for each
             
       $valpack = "";
       $valpack[0] = 'Contacts';
       $valpack[1] = 'view'; 
       $valpack[2] = $valtype;
       $valpack[3] = $tablefields;
       $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $valpack[5] = 1; // add

       // Build parent layer
       $zaform = "";
       $zaform = $funky_gear->form_presentation($valpack);
      
       } else { // end if is array
      
       $zaform = "There are currently no Administrators set for this item";
      
       }
      
    echo $zaform;     
    
    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $title = $strings["OtherItems"];

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'OtherItems');
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];
  
    echo $container_middle;

    ################################
    # Start  Other Parts
      
    echo "<font=#151B54><B>".$strings["PoliticalParty"].":</B></font> ".$view_parties." ".$edit_parties."<P>";
    echo "<font=#151B54><B>".$strings["Constitution"].":</B></font> ".$view_constitution." ".$edit_constitution."<P>";      
          
    # End 
    ################################

    echo $container_bottom;

   break;
   case 'process_member':

    $admin_val = $_POST['admin_id'];
    $contact_id = $_POST['contact_id_c'];

    $object_type = "Modules";
    $action = "set_modules";

    $params = array();
    $params[0] = "Administrators";
    $params[1] = $admin_val;
    $params[2] = "Contacts";
    $params[3] = $contact_id;

    $rel_result = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    $process_message = "The Administrator submission was a success! <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=".$do."&action=view&value=".$val."&valuetype=".$do."');return false\"> Please review here!</a><P>Please now take some time to check and update the content and add your policies - this will be the meat of your story which people will vote for - positively and/or negatively.<P>";

    $process_message .= "<B>".$strings["Name"].":</B> ".$sent_name."<BR>";
    $process_message .= "<B>".$strings["Description"].":</B> ".$sent_description."<BR>";

    echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";  


   break;
   case 'process':

    $sent_id = $_POST['id'];
    $sent_name = $_POST['name'];

    if (!$sent_name){

       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Name"]."</font><P>";
       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       } else {

       $sent_description = $_POST['description'];
       $sent_access_level = $_POST['access_level'];
       $sent_cmv_politicalparties_id_c = $_POST['cmv_politicalparties_id_c'];
       $sent_cmv_countries_id_c = $_POST['cmv_countries_id_c'];
       $sent_cmv_governments_id_c = $_POST['cmv_governments_id_c'];
//    $sent_cmv_languages_id_c = $_POST['cmv_languages_id_c'];
//    $sent_cmv_statuses_id_c = $_POST['cmv_statuses_id_c'];
       $sent_cmv_governmentconstitutions_id_c = $_POST['cmv_governmentconstitutions_id_c'];
       $sent_allow_joiner_requests = $_POST['allow_joiner_requests'];
       $sent_cmv_organisations_id_c = $_POST['cmv_organisations_id_c'];


       if (!$assigned_user_id){
          $assigned_user_id = 1;
          }

/*
    $default_access_level = 2;
    $default_allow_joiner_requests = 0;
    $default_name = "Administration for ".$sent_name;
*/

       $process_params = "";
       $process_params = array();

       $process_params[] = array('name'=>'id','value' => $sent_id);
       $process_params[] = array('name'=>'name','value' => $sent_name);
       $process_params[] = array('name'=>'description','value' => $sent_description);
       $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
       $process_params[] = array('name'=>'cmv_politicalparties_id_c','value' => $sent_cmv_politicalparties_id_c);
       $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
       $process_params[] = array('name'=>'access_level','value' => $sent_access_level);
       $process_params[] = array('name'=>'cmv_governments_id_c','value' => $sent_cmv_governments_id_c);
       $process_params[] = array('name'=>'cmv_governmentconstitutions_id_c','value' => $sent_cmv_governmentconstitutions_id_c);
       $process_params[] = array('name'=>'allow_joiner_requests','value' => $sent_allow_joiner_requests);
       $process_params[] = array('name'=>'cmv_organisations_id_c','value' => $sent_cmv_organisations_id_c);

       $object_type = "Administrators";
       $action = "update";
       $admin_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $process_params);

       $process_message = $sent_name." Administration was updated successfully.<P>";

       if ($sent_cmv_governments_id_c != NULL && $sent_cmv_politicalparties_id_c == NULL){
          $val = $sent_cmv_governments_id_c;
          $valtype = "Governments";
          $process_message .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=".$valtype."&action=edit&value=".$val."&valuetype=".$valtype."');return false\"><font color=red size=3><B>".$sent_name."</B></font></a><P>";
          }

       if ($sent_cmv_organisations_id_c != NULL){
          $val = $sent_cmv_organisations_id_c;
          $valtype = "Organisations";
          $process_message .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=".$valtype."&action=edit&value=".$val."&valuetype=".$valtype."');return false\"><font color=red size=3><B>".$sent_name."</B></font></a><P>";
          }

       if ($sent_cmv_politicalparties_id_c != NULL){
          $val = $sent_cmv_politicalparties_id_c;
          $valtype = "PoliticalParties";
          $process_message .= "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=".$valtype."&action=edit&value=".$val."&valuetype=".$valtype."');return false\"><font color=red size=3><B>".$sent_name."</B></font></a><P>";
          }

       $process_message .= "<B>".$strings["Name"].":</B> ".$sent_name."<BR>";
       $process_message .= "<B>".$strings["Description"].":</B> ".$sent_description."<BR>".$admin_object_target;

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";   

       } // end process

   break;
   case 'view-academia':

    echo "We are inviting the world's Universities' Political Science departments to join us and Sponsor the maintenance of their country's Government's content. In addition to the Universities' students receiving a hands-on way of learning about their Government, their University will also receive prominent exposure throughout Real Politika. We will also be running annual competitions for the most popular Political Party and Policies created by the students of Universities world-wide. Please see below for the list of Universities currently signed up and the Government they are maintaining.";

   break;

   } // end actions switch

# break; // End Administrators
##########################################################
?>