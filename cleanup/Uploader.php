<?php

//include ("common.php");

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Uploader</title>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Real Ajax Uploader - a jQuery multi uploader" />
        <meta name="keywords" content="ajax file uploader, uploader ajax, iframe upload, file upload, multiupload" />
		<meta name="author" content="Alban Xhaferllari" />
		<!-- PAGE CSS -->
        <link rel="stylesheet" type="text/css" href="codebrush/css/demo.css" />
		
		<!-- SET UP AXUPLOADER  -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/ajaxupload-min.js"></script>
		
		
		<!-- This is just for the demo code  -->
		<link rel="stylesheet" href="codebrush/css/shCore.css" type="text/css" media="all" />
		<link rel="stylesheet" href="codebrush/css/shThemeEclipse.css" type="text/css" media="all" />
		<link rel="stylesheet" href="codebrush/css/shCoreDefault.css" type="text/css"/>
		<script src="codebrush/shCore.js" type="text/javascript"></script>
		<script src="codebrush/shBrushJScript.js"  type="text/javascript" ></script>
		<script src="codebrush/shBrushXml.js"  type="text/javascript" ></script>
		<script type="text/javascript">
			SyntaxHighlighter.all({toolbar:false});
		</script>
		
	</head>
	<body>
		<div>
			<?php
//			$account_id_c = $_GET['acc'];
//			$contact_id_c = $_GET['con'];
			$remotepath = "uploads/".$owner_account_id_c."/".$owner_contact_id_c."/";
?>
			<link rel="stylesheet" type="text/css" href="css/baseTheme/style.css" />
			<table class="options">
				<tr>
					<th style="width:100%"><center><?php echo $strings["UploadFile"]; ?></center></th>
				</tr>
				<tr>
					<td>
						<div id="uploader_div"></div>

						<form action="Receiver.php" method="post" id="THEFORM">
<?php

/*
    $tblcnt = 0;

    $tablefields[$tblcnt][0] = "id"; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 1; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "id"; //$field_value_id;
    $tablefields[$tblcnt][21] = $id; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Name"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][12] = "50"; // Field Length
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $name; //$field_value;   

    $tblcnt++;

    $tablefields[$tblcnt][0] = "cmn_statuses_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_statuses'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
//    $tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmn_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;    

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'project_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Project"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'project'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $project_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Projects';
    $tablefields[$tblcnt][9][7] = "project"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Projects'; //new do
    $tablefields[$tblcnt][9][9] = $project_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'project_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $project_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'projecttask_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ProjectTask"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'project_task'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $projecttask_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'ProjectTasks';
    $tablefields[$tblcnt][9][7] = "project_task"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'ProjectTasks'; //new do
    $tablefields[$tblcnt][9][9] = $projecttask_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $projecttask_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_sow_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["SOW"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_sow'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_sow_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'SOW';
    $tablefields[$tblcnt][9][7] = "sclm_sow"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'SOW'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_sow_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_sow_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_sow_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'sclm_sowitems_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["SOWItem"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_sowitems'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $sclm_sowitems_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'SOWItem';
    $tablefields[$tblcnt][9][7] = "sclm_sowitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'SOWItem'; //new do
    $tablefields[$tblcnt][9][9] = $sclm_sowitems_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_sowitems_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_sowitems_id_c; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_industries_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Industry"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmn_industries'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';

    if ($action == 'add'){
       $tablefields[$tblcnt][9][4] = " cmn_industries_id_c='' ";//$exception;
       } else {
       if ($parent_industry_id){
          $tablefields[$tblcnt][9][4] = " cmn_industries_id_c='".$parent_industry_id."' ";//$exception;
          } else {
          $tablefields[$tblcnt][9][4] = "";//$exception;
          } 
       }

    $tablefields[$tblcnt][9][5] = $cmn_industries_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = 'Industries';
    $tablefields[$tblcnt][9][7] = "cmn_industries"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Industries'; //new do
//    $tablefields[$tblcnt][9][9] = $industries_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_industries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_industries_id_c; //$field_value;

    if ($action == 'add' || $action == 'edit'){

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'portal_content_type'; // Field Name
    $tablefields[$tblcnt][1] = $strings["PortalContentType"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='556c2dbf-b408-8b02-b145-52643eb03113' "; //portal content types;
    $tablefields[$tblcnt][9][5] = $portal_content_type; // Current Value
//    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
//    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
//    $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
//    $tablefields[$tblcnt][9][9] = $content_type; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'portal_content_type';//$field_value_id;
    $tablefields[$tblcnt][21] = $portal_content_type; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'content_type'; // Field Name
    $tablefields[$tblcnt][1] = $strings["ContentType"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'file_jaxer';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = " sclm_configurationitemtypes_id_c='3b7a44af-b706-4bf4-bbb5-52387652127c' "; //content type;
    $tablefields[$tblcnt][9][5] = $content_type; // Current Value
    $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
    $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
    $tablefields[$tblcnt][9][8] = 'Content'; //new do
    $tablefields[$tblcnt][9][9] = $content_type; // Current Value
    $params['content_type'] = $content_type;
    $params['content_name_field'] = "name";
    $params['content_name'] = $name;
    $tablefields[$tblcnt][9][10] = $params; // Various Params

    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'content_type';//$field_value_id;
    $tablefields[$tblcnt][21] = $content_type; //$field_value;

    }


    if ($action == 'view'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "content_url"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Content"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "content_url"; //$field_value_id;
       $tablefields[$tblcnt][21] = $content_url; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "content_thumbnail"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Thumbnail"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "content_thumbnail"; //$field_value_id;
       $tablefields[$tblcnt][21] = $content_thumbnail; //$field_value;   

       }

    if ($action == 'view' && $system_access){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'account_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Account"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'accounts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'contact_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["User"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'contacts'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'first_name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "account_id_c"; // Field Name
       $tablefields[$tblcnt][1] = "ID"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "account_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $account_id_c; //$field_value;   

       $tblcnt++;

       $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
       $tablefields[$tblcnt][1] = "ID"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $contact_id_c; //$field_value;   

       }


    $tblcnt++;

    $tablefields[$tblcnt][0] = "description"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Description"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][12] = '65'; // Field Length
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;   
//    $tablefields[$tblcnt][42] = '1'; //no label   

    if ($action == 'edit'){

    ################################
    # Loop for allowed languages

    for ($x=0;$x<count($field_lingo_pack);$x++) {

      $name_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][0][0][0];
      $desc_field = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][0][0];

      $name_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][0];
      $desc_content = $field_lingo_pack[$x][1][1][1][1][1][1][1][1][1][1];

      $language = $field_lingo_pack[$x][1][1][0][0][0][0][0][0][0][0];

      $tblcnt++;

      $tablefields[$tblcnt][0] = $name_field; // Field Name
      $tablefields[$tblcnt][1] = $strings["Name"]." (".$language.")"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 1; // is_name
      $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '100'; // length
      $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = $name_content; // Field ID
      $tablefields[$tblcnt][12] = '50'; // Field Length
      $tablefields[$tblcnt][20] = $name_field;//$field_value_id;
      $tablefields[$tblcnt][21] = $name_content; //$field_value; 

      $tblcnt++;

      $tablefields[$tblcnt][0] = $desc_field; // Field Name
      $tablefields[$tblcnt][1] = $strings["Description"]." (".$language.")"; // Full Name
      $tablefields[$tblcnt][2] = 0; // is_primary
      $tablefields[$tblcnt][3] = 0; // is_autoincrement
      $tablefields[$tblcnt][4] = 0; // is_name
      $tablefields[$tblcnt][5] = 'textarea';//$field_type; //'INT'; // type
      $tablefields[$tblcnt][6] = '255'; // length
      $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
      $tablefields[$tblcnt][8] = ''; // default
      $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
      $tablefields[$tblcnt][10] = '1';//1; // show in view 
      $tablefields[$tblcnt][11] = $desc_content; // Field ID
      $tablefields[$tblcnt][12] = '65'; // Field Length
      $tablefields[$tblcnt][20] = $desc_field;//$field_value_id;
      $tablefields[$tblcnt][21] = $desc_content; //$field_value;

      } // end for languages

      } // end if edit

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
    $valpack[5] = ""; // provide add new button

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    ###################
    #

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $container_params[0] = 'open'; // container open state
    $container_params[1] = $bodywidth; // container_width
    $container_params[2] = $bodyheight; // container_height
    $container_params[3] = $show_name; // container_title
    $container_params[4] = 'Content'; // container_label
    $container_params[5] = $portal_info; // portal info
    $container_params[6] = $portal_config; // portal configs
    $container_params[7] = $strings; // portal configs
    $container_params[8] = $lingo; // portal configs

    $container = $funky_gear->make_container ($container_params);

    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;

    echo $zaform;

*/


?>
 							<input type="hidden" value="<?php echo $do; ?>" name="d" />
							<input type="hidden" value="<?php echo $valtype; ?>" name="vt" />
							<input type="hidden" value="<?php echo $val; ?>" name="v" />
							<input type="hidden" value="<?php echo $owner_account_id_c; ?>" name="a" />
							<input type="hidden" value="<?php echo $owner_contact_id_c; ?>" name="c" />
<?php
//    echo $container_bottom;

?>

							<input type="submit" value="<?php echo $strings["UploadFile"]; ?>" />
						</form>
						
					</td>
				</tr>
			</table>
					<script type="text/javascript">
		$('#uploader_div').ajaxupload({
			url:'Upload.php',
			editFilename:true,
			form:'#THEFORM',
			remotePath:'<?php echo $remotepath; ?>',
			thumbHeight:300,
			thumbWidth:200,
                        thumbPostfix:'_thumb', 
                        thumbPath:'<?php echo $remotepath; ?>',
                        thumbFormat:'',

		});

                //if we want to make mandatory file upload
                $('#THEFORM').submit(function(){
                         var AU_class = $('#uploader_div').data('AU'); //get the uploader class
                         //we can use also $('#uploader_div').ajaxupload('getFiles');
                         var selected_file = AU_class.files; //access selected files
		
                        //if there not are file ready to upload, then do not submit the form
                        if (selected_file.length==0){
                           alert('Please select any file before send');
                           return false;
		           }

		return true;

		});
		</script>
		</div>
	</body>
</html>	