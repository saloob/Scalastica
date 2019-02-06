<?
####################################################################
# MyCMV Synch API
# To connect to and receive data for added-value services
# Saloob, Inc. All rights reserved 2010+
# Author: Matthew Edmond
# Date: 2010-09-20
# URL: http://www.saloob.com
# Email: sales@saloob.com
####################################################################
# External API Function

###################################
# Present

if (!$_SESSION){
    session_start();
}

$source_id = $_GET['source_id'];
$contact_id = $_GET['contact_id'];
$menu = $_GET['menu'];

if ($menu == ""){
   $menu = 'Home';
   }

// Various Functions

function openstate ($open_state){
	
	switch ($open_state){
		
		// With AJAX -shall make a link in div
		
		case 0:
			return "Closed";
		break;
		case 1:
			return "Open";
		break;
	}
	
} // end openstate

?>
<html>
<head>
<title>MyCMV</title>
<script type="text/javascript" language="javascript">

   var http_request = false;
   function makePOSTRequest(url, parameters) {
      http_request = false;
      if (window.XMLHttpRequest) { // Mozilla, Safari,...
         http_request = new XMLHttpRequest();
         if (http_request.overrideMimeType) {
         	// set type accordingly to anticipated content type
            //http_request.overrideMimeType('text/xml');
            http_request.overrideMimeType('text/html');
         }
      } else if (window.ActiveXObject) { // IE
         try {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
            try {
               http_request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
         }
      }
      if (!http_request) {
         alert('Cannot create XMLHTTP instance');
         return false;
      }

      http_request.onreadystatechange = alertContents;
      http_request.open('POST', url, true);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.setRequestHeader("Content-length", parameters.length);
      http_request.setRequestHeader("Connection", "close");
      http_request.send(parameters);
   }

   function alertContents() {
      if (http_request.readyState == 4) {
         if (http_request.status == 200) {
           // alert(http_request.responseText);
            result = http_request.responseText;
            document.getElementById('myspan').innerHTML = result;
         } else {
            alert('There was a problem with the request.');
         }
      }
   }

   function get(obj) {
      var getstr = "";
      for (i=0; i<obj.getElementsByTagName("input").length; i++) {

          if (obj.getElementsByTagName("input")[i].type == "hidden") {
             getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
             }

          if (obj.getElementsByTagName("input")[i].type == "password") {
             getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
             }
             
          if (obj.getElementsByTagName("input")[i].type == "text") {
             getstr += obj.getElementsByTagName("input")[i].name + "=" +
                   obj.getElementsByTagName("input")[i].value + "&";
             }

          if (obj.getElementsByTagName("input")[i].type == "checkbox") {

             if (obj.getElementsByTagName("input")[i].checked) {
                getstr += obj.getElementsByTagName("input")[i].name + "=" +
                obj.getElementsByTagName("input")[i].value + "&";
                } else {
                getstr += obj.getElementsByTagName("input")[i].name + "=&";
                }
             }

          if (obj.getElementsByTagName("input")[i].type == "radio") {
             if (obj.getElementsByTagName("input")[i].checked) {
                getstr += obj.getElementsByTagName("input")[i].name + "=" +
                obj.getElementsByTagName("input")[i].value + "&";
                }
             }

          if (obj.getElementsByTagName("input")[i].tagName == "SELECT") {
             var sel = obj.getElementsByTagName("input")[i];
             getstr += sel.name + "=" + sel.options[sel.selectedIndex].value + "&";
             }
          }

      //alert(getstr);
      makePOSTRequest('contact_do.php', getstr);

   }

</script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajax-dynamic-content.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<span name="myspan" id="myspan">
<?
switch ($menu){

 case 'Home':
   // 
 break;
 case 'Rankings':
   // 
 break;
 case 'Personal':
   // 
 break;
 case 'Family':
   // 
 break;
 case 'Friends':
   // 
 break;
 case 'Psychology':
   // 
 break;
 case 'Financial':
   // 
 break;
 case 'Sports':
   // 
 break;
 case 'HobbiesInterests':
   // 
 break;
 case 'Education':
   // 
 break;
 case 'Work':
   // 
 break;
 case 'About':
   // 
 break;

} // end menu switch

?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="float:center;" bgcolor="#FFFFFF">
   <tr valign="middle">
<?

$object_type = "contacts";
$action = "contact_by_source";
$params[0] = "Facebook - MyCMV"; // query
$params[1] = $source_id_c; // query
//$params[1] = "638717843"; // query

function update_personal ($params){
	
		$name_value_list = array(	
                            array('name'=>'id','value'=>$contact_id),
                            array('name'=>'first_name','value'=>$params[1]),
                            array('name'=>'last_name','value'=>$params[2]),
                            array('name'=>'email1','value'=>$params[3]),
                            array('name'=>'phone_work','value'=>$params[4]),
                            array('name'=>'phone_fax','value'=>$params[5]),
                            array('name'=>'primary_address_street','value'=>$params[6]),
                            array('name'=>'primary_address_city','value'=>$params[7]),
                            array('name'=>'primary_address_state','value'=>$params[8]),
                            array('name'=>'primary_address_country','value'=>$params[9]),
                            array('name'=>'primary_address_postalcode','value'=>$params[10]),

                            );     
return $param_bundle;                            

} //end update personal

$result = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $object_type, $action, $params);

	foreach ($result['entry_list'] as $gotten){

		$fieldarray = nameValuePairToSimpleArray($gotten['name_value_list']);
	    	
		$first_name =  $fieldarray['first_name'];
		$last_name =  $fieldarray['last_name'];		
		$personal_cmv_last_name_c = $fieldarray['personal_cmv_last_name_c'];
		$personal_open_last_name_c = $fieldarray['personal_open_last_name_c'];
		$personal_open_last_name = openstate ($personal_open_last_name_c);
		$personal_dcmv_last_name_c = $fieldarray['personal_dcmv_last_name_c'];
		$personal_dcmv_first_name_c = $fieldarray['personal_dcmv_first_name_c'];
		$personal_open_first_name_c = $fieldarray['personal_open_first_name_c'];
		$personal_open_first_name = openstate ($personal_open_first_name_c);
		$personal_cmv_first_name_c = $fieldarray['personal_cmv_first_name_c'];
		
		}
		

$personal_cmv_profile = 1110.00;
$personal_cmv_fbuid = 110.00;
$personal_cmv_first_name = 10.00;
$personal_cmv_last_name = 40.00;
$personal_cmv_locale = 10.00;
$personal_cmv_current_location = 110.00;
$personal_cmv_affiliations = 210.00;
$personal_cmv_profile_url = 330.00;
$personal_cmv_gender  = 210.00;

$personal_open_profile = "Closed";
$personal_open_fbuid = "Closed";
//$personal_open_first_name = "Closed";
//$personal_open_last_name = "Closed";
$personal_open_locale = "Closed";
$personal_open_current_location = "Closed";
$personal_open_affiliations = "Closed";
$personal_open_profile_url = "Closed";
$personal_open_gender = "Closed";		

$ziscontents = "
<form action=\"javascript:get(document.getElementById('myform'));\" name=\"myform\" id=\"myform\">
 <table align=\"center\">
  <tr>
   <td>First Name</td>
   <td><INPUT type=\"text\" id=\"first_name\" name=\"first_name\"  value=\"".$first_name."\"></td>
  </tr>
  <tr>
   <td>Last Name</td>
   <td><INPUT type=\"text\" id=\"last_name\" name=\"last_name\"  value=\"".$last_name."\"></td>
  </tr>
  <tr>
   <td>Email</td>
   <td><INPUT type=\"text\" id=\"email\" name=\"email\"  value=\"".$email."\">
   </td>
   <INPUT type=\"hidden\" id=\"source_id_c\" name=\"source_id_c\" value=\"".$source_id_c."\">      
  </tr>
  <tr>
  <td></td>
  <td>
   </td>
  </tr>
  <input type=\"button\" name=\"button\" value=\"Submit\" onclick=\"javascript:get(this.parentNode);\">
   </table>
</form>";

echo $ziscontents;
?>

<table width=100%>
 <tr valign=top>
  <td>
   <table style="border-collapse: collapse; width: 100%;">
    <tbody>
      <tr>
       <td style="border: 1px solid rgb(0, 0, 0);">Home
       </td>
       <td style="border: 1px solid rgb(0, 0, 0);">Rankings
       </td>
       <td style="border: 1px solid rgb(0, 0, 0);">Personal
       </td>       
       <td style="border: 1px solid rgb(0, 0, 0);">Family
       </td>              
       <td style="border: 1px solid rgb(0, 0, 0);">Friends
       </td>              
       <td style="border: 1px solid rgb(0, 0, 0);">Psychology
       </td>       
       <td style="border: 1px solid rgb(0, 0, 0);">Financial
       </td>       
       <td style="border: 1px solid rgb(0, 0, 0);">Sports
       </td>       
       <td style="border: 1px solid rgb(0, 0, 0);">Hobbies & Interests
       </td>            
       <td style="border: 1px solid rgb(0, 0, 0);">Education
       </td>              
       <td style="border: 1px solid rgb(0, 0, 0);">Work
       </td>              
       <td style="border: 1px solid rgb(0, 0, 0);">About
       </td>              
      </tr>
     </tbody>
   </table>
   <table style="border-collapse: collapse; width: 100%;">
    <tbody>
      <tr>
       <td style="border: 1px solid rgb(0, 0, 0);">Information Item
       </td>
       <td style="border: 1px solid rgb(0, 0, 0);">Information
       </td>
      <td style="border: 1px solid rgb(0, 0, 0);">CMV
      </td>       
      <td style="border: 1px solid rgb(0, 0, 0);">Open Status
      </td>
     </tr>       
     <tr>
       <td style="border: 1px solid rgb(0, 0, 0);">Personal Information Profile
       </td>
       <td style="border: 1px solid rgb(0, 0, 0);">Aggregate CMV
       </td>
       <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_profile; ?>
      </td>           
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_profile; ?>
      </td>         
     </tr>          
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Facebook Number
      </td>
       <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $userid; ?>
       </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_fbuid; ?>
      </td>           
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_fbuid; ?>
      </td>       
     </tr>   
      <tr>
       <td style="border: 1px solid rgb(0, 0, 0);">First Name
       </td>
       <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $first_name; ?>
       </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_first_name; ?>
      </td>           
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_first_name; ?>
      </td>             
     </tr>
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Last Name
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $last_name; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_last_name; ?>
      </td>         
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_last_name; ?>
      </td>             
     </tr>
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Locale
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $locale; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_locale; ?>
      </td>    
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_locale; ?>
      </td>             
     </tr>
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Current Location
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $current_location; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_current_location; ?>
      </td>    
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_current_location; ?>
      </td>             
     </tr>
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Affiliations
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $affiliations; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_affiliations; ?>
      </td>        
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_affiliations; ?>
      </td>             
     </tr>
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Profile URL
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $profile_url; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_profile_url; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_profile_url; ?>
      </td>             
     </tr>  
     <tr>
      <td style="border: 1px solid rgb(0, 0, 0);">Gender
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $gender; ?>
      </td>
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_cmv_gender; ?>
      </td>        
      <td style="border: 1px solid rgb(0, 0, 0);"><?php echo $personal_open_gender; ?>
      </td>             
     </tr>            
    </tbody>
   </table>
  </td>
 </tr>
</table>
 <P></P>

    </tr>
  </table>
 </span>
</body>
</html> 
<?

# End register
#####################################################
?>
