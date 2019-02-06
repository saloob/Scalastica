<?php

//include ("../common.php");

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
			$account_id_c = $_GET['acc'];
			$contact_id_c = $_GET['con'];
			$remotepath = "../uploads/".$account_id_c."/".$contact_id_c."/";
			include 'form.php';
			?>
		</div>
	</body>
</html>	