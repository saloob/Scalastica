<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2013-06-20
# Page: ConfigurationItems.php 
##########################################################
# case 'ConfigurationItems':

  if (!$lingo){
      $lingo = "en";
      }
  if (!$lingoname){
     $lingoname = "name_".$lingo;
     }


  $this_module = 'd1dc8a9a-03d2-d3a5-a5b4-52762db27594';
  $security_params[0] = $this_module;
  $security_params[1] = $lingo;
  $security_params[2] = $_SESSION['contact_id'];
  $security_check = $funky_gear->check_security($security_params);
  $security_access = $security_check[0];
  $security_level = $security_check[1];
  $security_role = $security_check[2];
  $system_action_add = $security_check[3];
  $system_action_delete = $security_check[4];
  $system_action_edit = $security_check[5];
  $system_action_export = $security_check[6];
  $system_action_import = $security_check[7];
  $system_action_view = $security_check[8];
  $system_action_list = $security_check[9];

/*
  $object_return_params[0] = " deleted=0 ";

  switch ($system_action_list){

   case $action_rights_all:
    $object_return_params[0] .= " && (account_id_c = '".$_SESSION['account_id']."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
   break;
   case $action_rights_none:
    $object_return_params[0] .= " && cmn_statuses_id_c = 'ZZZZZZZZZZZZZZZZZZ' ";
   break;
   case $action_rights_owner:
    $object_return_params[0] .= " && contact_id_c = '".$_SESSION['contact_id']."' ";
   break;
   case $action_rights_account:
    $object_return_params[0] .= " && account_id_c = '".$_SESSION['account_id']."' ";
   break;

  } // end system_action_list
*/

  #echo "Query $object_return_params[0] <P>";

  $object_return_params[0] = "";

  if ($valtype == 'ConfigurationItems' && $val != NULL){

     $ci_object_type = 'ConfigurationItems';
     $ci_action = "select";

     $ci_params[0] = "deleted=0 && id='".$val."' ";
     $ci_params[1] = "enabled,cmn_statuses_id_c,sclm_configurationitemtypes_id_c"; // select array
     $ci_params[2] = ""; // group;
     $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
     $ci_params[4] = "500"; // limit
  
     $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

     if (is_array($ci_items)){

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $enabled = $ci_items[$cnt]['enabled'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];

           } # for

        } # is array

     } # if CI

  if (!$object_return_params[0]){
     $object_return_params[0] = " deleted=0 ";
     }

  if (!$_SESSION['contact_id'] && $cmn_statuses_id_c != '".$standard_statuses_closed."' && $enabled !=1 && $action == 'view'){
     echo "<P><a href=\"#\" onClick=\"doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Login&action=logout&value=&valuetype=');return false\"><B>Your Session has ended - please log in again..</B></a>";
     exit;
     }

  if ($auth < 2){
     $object_return_params[0] .= " && (contact_id_c='".$sess_contact_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
     }

  #echo $valtype;

  switch ($valtype){
   
   case 'Accounts':

    if ($auth < 3){
       //$object_return_params[0] .= " && (account_id_c='".$val."'  || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
       $object_return_params[0] .= " && (account_id_c='".$sess_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') "; 
       } else {
       $object_return_params[0] .= " && account_id_c='".$val."' "; 
       } 

   break;
   case 'ConfigurationItems':

    $sclm_configurationitems_id_c = $val; 

    if ($auth < 3){

//       $object_return_params[0] .= " && sclm_configurationitems_id_c='".$val."' && (account_id_c='".$account_id_c."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
       $object_return_params[0] .= " && sclm_configurationitems_id_c='".$val."' && (account_id_c='".$sess_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') ";
 
       } else {

       $object_return_params[0] .= " && sclm_configurationitems_id_c='".$val."' ";

       } 


   break;
   case 'ConfigurationItemTypes':

    $ci_type_id = $val; 

    if ($auth < 3){

       $object_return_params[0] .= " && sclm_configurationitemtypes_id_c='".$val."' && (account_id_c='".$sess_account_id."'  || cmn_statuses_id_c != '".$standard_statuses_closed."' )";

       } else {

       $object_return_params[0] .= " && sclm_configurationitemtypes_id_c='".$val."' ";

       } 

   break;
   case 'Opportunities':

    $ci_type_id = $val; 

    if ($auth < 3){

       $object_return_params[0] .= " && opportunity_id_c='".$val."' && (account_id_c='".$sess_account_id."'  || cmn_statuses_id_c != '".$standard_statuses_closed."' )";

       } else {

       $object_return_params[0] .= " && opportunity_id_c='".$val."' ";

       } 

   break;

  }

$keyword = $_POST['keyword'];
if ($keyword == NULL){
   $keyword = $_GET['keyword'];
   }

$search_id = $_POST['search_id'];
if ($search_id == NULL){
   $search_id = $_GET['search_id'];
   }

$ci_type_id = $_POST['ci_type_id'];
if ($ci_type_id == NULL){
   $ci_type_id = $_GET['ci_type_id'];
   }

$extra_params[0] = "";

if ($action == 'search'){

   if ($keyword != NULL){
      $vallength = strlen($keyword);
      $trimval = substr($keyword, 0, -1);
      $object_return_params[0] = "deleted=0 && (description like '%".$keyword."%' || name like '%".$keyword."%' || description like '%".$trimval."%' || name like '%".$trimval."%'  )";
      $extra_params[0] = "&keyword=".$keyword;
      }

   if ($search_id != NULL){
      $object_return_params[0] = " deleted=0 && id='".$search_id."' ";
      $extra_params[0] .= "&id=".$search_id;
      }

   if ($auth < 3){

      $object_return_params[0] .= " && cmn_statuses_id_c != '".$standard_statuses_closed."' ";

      } # end auth

   } # search

  if (($search_id != NULL || $keyword != NULL) && $ci_type_id != NULL){
      $object_return_params[0] .= " && sclm_configurationitemtypes_id_c='".$ci_type_id."' ";
      $extra_params[0] .= "&ci_type_id=".$ci_type_id;
      } elseif ($ci_type_id != NULL){
      $object_return_params[0] = " deleted=0 && sclm_configurationitemtypes_id_c='".$ci_type_id."' ";
      $extra_params[0] .= "&ci_type_id=".$ci_type_id;
      }

  $lingoname = "name_".$lingo;
  $lingodesc = "description_".$lingo;

  #Provide arrays for use in add/edit/view and process


    $cit_array[] = 'df940500-4cb3-b830-d6be-53e1f2801616'; # Binding

    # Account Sharing
    $cit_array[] = '3172f9e9-3915-b709-fc58-52b38864eaf6'; # Related Account Shares
    $cit_array[] = '8ff4c847-2c82-9789-f085-52b3897c8bf6'; # Related Account
    $cit_array[] = 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f'; # acc_shared_type_projects
    $cit_array[] = '39ffa1e6-2b7c-7aaa-3370-52b389684442'; # acc_shared_type_slarequests
    $cit_array[] = '562695ff-00d4-8ead-e3c2-52b3897ef61e'; # acc_shared_type_ticketing
    $cit_array[] = 'e2affd29-d116-caa8-6f0c-52fa4d034cf5'; # acc_shared_type_portalaccess
    $cit_array[] = '5195ecc6-ec22-1fdd-0fd5-54d898ab38ed'; # acc_shared_type_portaladmin
    $cit_array[] = 'a8d97830-b100-e03e-c445-54d8be1ae651'; # acc_shared_type_portalemails
    $cit_array[] = 'c4f8a9b2-b8f2-8e42-995b-54d8d7e192c1'; # acc_shared_type_infra
    $cit_array[] = '58a896be-c277-844b-f051-54ebedac5dd4'; # acc_shared_type_pricing

    $cit_array[] = '399a1a2c-5038-8d99-20bf-54e8c81f35a9'; # Accounts Services SLA Features

    # Licensing
    $lic_array[] = '8251ddbc-cd5c-a23c-fc58-53da6f001002';
    $lic_array[] = '8e3ff812-8fdd-7797-5cfe-54b64bbf679c';
    $lic_array[] = '4e5d6794-a96e-610e-ca1a-53da6f999945';
    $lic_array[] = '8dc70254-4c2a-49ff-7605-54b899dbe239';
    $lic_array[] = 'b1ec5fc3-1154-06a5-d20f-54b64b958d0e';
    $lic_array[] = '10270906-ba22-4c42-ca1d-54b66213c795';
    $lic_array[] = '9b7266a8-6896-33fd-07aa-54b64a4c0759';
    $lic_array[] = 'd2ef598d-7db6-2685-85ba-54b662f69f4c';
    $lic_array[] = '469b1a65-d8b5-69c2-398e-54b88a9c17b0';
    $lic_array[] = '80d45f1b-b608-b123-41d6-54b64caea0bc';
    $lic_array[] = '2be3cda0-a296-9c0f-7598-54b8c5fc2c3f';

    $cit_array = array_merge($cit_array,$lic_array);

    # Scheduling
    $schedule_array[] = '9afa5bc2-9a1f-c831-b032-57122091b780';
    $cit_array = array_merge($cit_array,$schedule_array);

    # VIA Character Strengths - to set value

    $via_array[] = '765a3bfa-a4d0-4e8f-4153-54ea144528e5'; # Bravery | ID: 
    $via_array[] = 'c84d558f-5b4e-0e80-20b0-54ecc0c31761'; # Honesty | ID: 
    $via_array[] = '457e6dfb-6ccf-0181-91ee-54ecc03754f2'; # Perseverance | ID: 
    $via_array[] = '22510bd0-25c0-c1b5-c08e-54ecc1d75bb4'; # Zest  | ID: 
    $via_array[] = 'f1c2f556-ae34-0193-9ab7-54ecc2059496'; # Kindness  | ID: 
    $via_array[] = 'e362dd02-f638-7b9a-e836-54ecc1cde8c9'; # Love | ID: 
    $via_array[] = 'b55fdb63-31b7-5deb-404e-54ecc2dc0c4a'; # Social Intelligence  | ID: 
    $via_array[] = '7a519305-97f5-93ad-82b3-54ecc3d500a1'; #  Fairness | ID: 
    $via_array[] = 'bb3fa52f-31d4-f28e-68e3-54ecc38eb5fe'; # Leadership | ID: 
    $via_array[] = 'ec358874-5f7b-549e-b963-54ecc3fabddd'; # Teamwork  | ID: 
    $via_array[] = '7a8001fc-480d-8eb3-c069-54ecc431ae11'; #  Forgiveness | ID: 
    $via_array[] = '3a9963ed-48fa-1d80-5599-54ecc4033726'; # Humility | ID: 
    $via_array[] = '2c8e8a55-6e64-5f09-d22b-54ecc42c1a09'; # Prudence | ID: 
    $via_array[] = 'd492fa70-9aa7-ea73-cdbf-54ecc4f069de'; # Self-Regulation  | ID: 
    $via_array[] = '30aed2ba-7ca4-2063-ce6c-54ecc55c7d4d'; #  Appreciation of Beauty and Excellence  | ID: 
    $via_array[] = '67cd5fb7-25d9-1451-acce-54ecc5f4cb20'; # Gratitude | ID: 
    $via_array[] = '3f3ad669-f5c5-7e7d-78ec-54ecc52d422b'; # Hope | ID: 
    $via_array[] = '26e41f55-bae6-adc9-f8c9-54ecc63a1044'; # Humor | ID: 
    $via_array[] = 'b7497a9c-dd71-be28-c4b7-54ecc6457975'; # Spirituality  | ID: 
    $via_array[] = 'ca93fdde-240b-5442-9106-54ea127e78d6'; #  Creativity  | ID: 
    $via_array[] = '4f125431-d54f-c510-8b20-54ea1261057c'; # Curiosity  | ID: 
    $via_array[] = 'ce496b67-dd35-27c3-94bd-54ea13c190a8'; # Judgment  | ID: 
    $via_array[] = '8be2b0b6-5e5a-55cb-3648-54ea13d1c4ab'; # Love of Learning | ID: 
    $via_array[] = 'b9339e24-a6a7-93a5-5e91-54ea13b8f60c'; # Perspective  | ID: 

    $cit_array = array_merge($cit_array,$via_array); 

    # PESH
    # Emotional Capital | ID: ab8a88b5-8e7a-a8c7-e5c7-55217fc38b0a
    $pesh_array[] = '31ba0986-2579-f2df-a098-5524943036a8'; # Dominant Focus
    $pesh_array[] = 'e82d34d0-b86c-2b00-3011-5524945be13c'; # State of mind - stability
    # Human Capital | ID: dfa5491e-946c-dac0-e3eb-55217fc70d90
    $pesh_array[] = '5b151fb5-509c-0805-03c9-552496d39170'; # Level of (required/relevant) Skills
    $pesh_array[] = '9047f495-ff71-b8f9-fda5-5524952a32ae'; # Level of Knowledge
    $pesh_array[] = 'b3cbe1c0-3279-d6ca-48ec-552496a76210'; # Propensity to focus on Strengths

    # Psychological Capital | ID: ae7f39c2-9953-b507-5a4f-55217ff77332
    $pesh_array[] = '4bd948e1-1987-3de4-2a0e-552493131c4c'; # Ability/Tendency/Propensity to/for Hope
    $pesh_array[] = '6a76a91e-bf29-25cc-e954-5524935e209d'; # Propensity for being resilient
    $pesh_array[] = 'c24ab0b8-ac4d-ee21-13db-5524931d09f7'; # Propensity for Efficacy - pursue mastery experiences
    $pesh_array[] = 'bf7e895e-4ba3-5101-a709-552494d708c4'; # Propensity for Optimism – visit & visualize the future

    # Social Capital | ID: 1a80e8c3-7e68-b2c5-5f0f-55217f5c834b
    $pesh_array[] = '9e57f42c-1ece-b1cf-4257-5524952f0974'; # Meaningful Relationships
    $pesh_array[] = '71ee018d-4964-7025-f3d5-552495305c73'; # Propensity for asking what’s right, not what’s wrong
    $pesh_array[] = '2076b579-907b-5610-4be0-55249537c9c2'; # Prosocial behavior – Ask one more question

    $cit_array = array_merge($cit_array,$pesh_array); 

    $perma_array[] = 'debb2e41-45ed-d465-adea-5521821c80dd'; # Accomplishment/Achievement
    $perma_array[] = '713920b6-e19e-c268-7815-5521820f59ad'; # Engagement
    $perma_array[] = '1f89d8b4-a6bf-44bd-e124-552182f53585'; # Meaningfulness
    $perma_array[] = '62ada2bc-2053-2b77-7f42-55218253c0f7'; # Positive Emotions
    $perma_array[] = '1ef726c0-8209-0648-6084-552182278071'; # Relationships

    $cit_array = array_merge($cit_array,$perma_array); 

    # Create Resourceful Change: d94d9461-9e5b-f6cb-58ff-55218721e030
    $leadership_array[] = '57f9cdaf-c63b-7741-87df-5521cebe1e87'; # Create micro-moves for organisational change
    $leadership_array[] = 'c8af72a2-c17b-56c6-063d-5521ce97aa06'; # Create opportunity from crisis
    $leadership_array[] = '8eb11a5d-0de3-6f68-bcc9-5521ce1c9be6'; # Cultivate Hope
    $leadership_array[] = 'ce5cd066-da02-ebe5-977a-5521ced63c44'; # Treat employees as resources - not resisters

    # Foster Positive Relationships | ID: 6bb5fe7f-62a5-119c-e3e5-55218672a94a
    $leadership_array[] = '95eb35ee-86a3-7383-b7ed-5521cc9ad933'; # Build High-Quality Connections
    $leadership_array[] = '9f02cbe1-8f4b-83b3-0c04-5521cd0dd8b6'; # Negotiate Mindfully
    $leadership_array[] = 'bf7a5760-45d0-b51b-6ff4-5521cdf55002'; # Outsource Inspiration

    # Tap into the Good | ID: edbdf79d-bac7-997f-b406-55218722ea88
    $leadership_array[] = '8f688633-2737-9db0-0508-5521cd369284'; # Activate Virtuousness
    $leadership_array[] = '28571903-b0fe-49b2-74ca-5521ce5f1842'; # Imbue the organisation with a higher purpose
    $leadership_array[] = '2d84e36d-b2b2-6c99-b2f0-5521cd7de568'; # Lead an ethical organisation

    # Unlock Resources from Within | ID: a1943896-2f4f-ecaf-6669-5521871a94a8
    $leadership_array[] = '63f920a2-d975-ffa0-8eca-5521cd0b5309'; # Cultivate Positive Identies
    $leadership_array[] = '5b015a98-8323-ffc3-2d50-5521cdc2894c'; # Enable thriving at work
    $leadership_array[] = '3d1577ab-9740-aabb-7732-5521cdfea9f6'; # Engage in job crafting

    $cit_array = array_merge($cit_array,$leadership_array); 

    # Appreciative Inquiry | ID: 128def00-ce41-4ff8-e9b0-552184cc5e63
    $ai_array[] = 'af0c0abf-c5a0-97c8-8bf6-5521858281ed'; # 1 - Choose the positive as the focus of inquiry
    $ai_array[] = '1013ee12-c355-a59c-1dab-5521853721a6'; # 2 - Inquire into exceptionally positive moments
    $ai_array[] = '995e9a1e-5afc-5230-e4ab-5521851ea21e'; # 3 - Share the stories and identify life-giving forces
    $ai_array[] = '47e9cb8e-f4ee-48c3-c3e4-5521853fcc4a'; # 4 - Create shared images of a preferred future
    $ai_array[] = '2c05d1b8-ceb8-be7c-a644-552186c6ea26'; # 5 - Innovate and improvise ways to create that future

    $cit_array = array_merge($cit_array,$ai_array); 

    # The Cloudsultant's Profile | ID: 9e786955-c6f1-5420-fda9-5521ce8daa5e
    $cloudsultancy_array[] = 'cca9638c-86c6-929a-0d7d-5521d0f157f4'; # Being a Consultant
    $cloudsultancy_array[] = '1389c1fa-7f2a-1e97-f366-5521d0f52e12'; # Being a Developer
    $cloudsultancy_array[] = 'd7a08412-90d5-7459-d8d9-5521cf24906d'; # Being a Product Manager
    $cloudsultancy_array[] = '3a660f35-3f61-0865-38d8-5521cfd093b2'; # Being a Product Marketing Manager
    $cloudsultancy_array[] = '46795768-4a6c-cede-07eb-5521cf365b19'; # Being a Project Manager
    $cloudsultancy_array[] = 'e0ec91d1-821c-5879-2ace-5521ce4fc07b'; # Being a Salesperson
    $cloudsultancy_array[] = '9108cafa-fd39-6979-810c-5521cfe4e968'; # Being a Service Delivery Manager
    $cloudsultancy_array[] = '4baa82e6-b7f2-67c3-a6fb-5521cff5dd28'; # Being a Solution Architect
    $cloudsultancy_array[] = '6dbc5ee4-da57-f9e6-d73f-5521cff9774b'; # Being a Technologist
    $cloudsultancy_array[] = '8e550296-0696-df64-90c2-5521cf1995fc'; # Being a Transition Manager
    $cloudsultancy_array[] = 'c9ed3886-6355-564a-cfca-5521d0d67dce'; # Being an Engineer

    $cit_array = array_merge($cit_array,$cloudsultancy_array); 

    $sn_array[] = '6898e8d5-e6b5-eda3-b1bc-55220a1b5037'; # Accounts
    $sn_array[] = '140cf7f9-fc5c-cb9c-2082-55220a924268'; # Contacts
    $sn_array[] = '4e4233fd-bd1b-cf45-8baa-55220aeeadea'; # Events
    $sn_array[] = '8be14b88-4b94-8325-ccd4-55220b6319d9'; # Lifestyle & State Categories
    $sn_array[] = '347e25e9-e3af-e3cc-e33c-55220ab84201'; # Products & Services

    $cit_array = array_merge($cit_array,$sn_array);

    #$infracerts_array[] = 'cb0c2f17-2e39-9eae-dae1-5579c42ad70c'; # cit
    $infracerts_array[] = 'bb129d1f-97d0-4e34-ec15-557a324fafaa'; # network
    $infracerts_array[] = '745ec33b-00d8-ab25-e346-557a32217132'; # dc
    $infracerts_array[] = 'd9a1644a-5257-f0cc-1bcc-557a33a16b8a'; # hosting
    $infracerts_array[] = '252f5955-ae3b-f057-efb0-557a3404c565'; # hardware
    $infracerts_array[] = 'e6b8cb44-9140-c74d-fbff-557a344eb57c'; # cpu 
    $infracerts_array[] = '484ddba9-c5b6-a551-326f-557a34d6610d'; # storage
    $infracerts_array[] = 'dfd0c0ee-f03f-d481-7777-557a35b5781a'; # os
    $infracerts_array[] = 'cdaf24fc-e485-0ed9-8eef-557a350f0f3c'; # infra_vz
    $infracerts_array[] = '62f5d3ed-3494-e4a9-d7e8-557a353d91b7'; # infra_db
    $infracerts_array[] = '978fc3bc-c757-b88e-b01f-557a36ffe5da'; # app

    $cit_array = array_merge($cit_array,$infracerts_array);

    if ($sendiv == 'FEATURES'){
       $cit_array[] = 'e027d211-75c9-d360-17cb-54e8577757ca'; # Colours
       $cit_array[] = 'a4b786aa-5f30-2258-8226-52ad30ae0f35'; # OS
       }

  switch ($action){
   
   case 'list':
   case 'search':

    ################################
    # List
    
    echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$strings["ConfigurationItems"]."</B></font></center></div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<center><img src=images/icons/objects-48x48x32b.png width=48></center>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";
    echo "<div style=\"".$formtitle_divstyle_white."\">".$strings["ConfigurationItemsMessage"]."</div>";
    echo "<BR><img src=images/blank.gif width=90% height=5><BR>";

    $ci_object_type = 'ConfigurationItems';
    $ci_action = "select";
    #echo "CI Query $object_return_params[0] <BR>";
    $ci_params[0] = $object_return_params[0];
    $ci_params[1] = "id,name,sclm_configurationitemtypes_id_c,account_id_c,contact_id_c,image_url"; // select array
    $ci_params[2] = ""; // group;
    $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
    $ci_params[4] = "500"; // limit
  
    $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

    if (is_array($ci_items)){

       $count = count($ci_items);
       $page = $_POST['page'];
       $glb_perpage_items = 30;

       #$navi_returner = $funky_gear->navigator ($count,$do,"list",$val,$valtype,$page,$glb_perpage_items,$BodyDIV);
       $navi_returner = $funky_gear->navigator ($count,$do,$action,$val,$valtype,$page,$glb_perpage_items,$BodyDIV,$extra_params);
       #echo "$count,$do,$action,$val,$valtype,$page,$glb_perpage_items,$BodyDIV,$extra_params";

       $lfrom = $navi_returner[0];
       $navi = $navi_returner[1];

       $date = date("Y@m@d@G");
       $body_sendvars = $date."#Bodyphp";
       $body_sendvars = $funky_gear->encrypt($body_sendvars);

?>
<P>
<center>
   <form action="javascript:get(document.getElementById('myform'));" name="myform" id="myform">
    <div>
     Keyword: <input type="text" id="keyword" name="keyword" value="<?php echo $keyword; ?>" size="20">
      ID: <input type="text" id="search_id" name="search_id" value="<?php echo $search_id; ?>" size="30"><BR>
     Type ID: <input type="text" id="ci_type_id" name="ci_type_id" value="<?php echo $ci_type_id; ?>" size="30">
     <input type="hidden" id="pg" name="pg" value="<?php echo $body_sendvars; ?>" >
     <input type="hidden" id="value" name="value" value="<?php echo $val; ?>" >
     <input type="hidden" id="action" name="action" value="search" >
     <input type="hidden" id="do" name="do" value="<?php echo $do; ?>" >
     <input type="hidden" id="valuetype" name="valuetype" value="<?php echo $valtype; ?>" >
     <input type="button" name="button" value="<?php echo $strings["action_search"]; ?>" onclick="javascript:loader('<?php echo $BodyDIV; ?>');get(this.parentNode);">
    </div>
   </form>
</center>
<P>
<?php

       echo $object_return;

       echo $navi;

       $ci_params[4] = " $lfrom , $glb_perpage_items "; 

       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       for ($cnt=0;$cnt < count($ci_items);$cnt++){

           $id = $ci_items[$cnt]['id'];
           $name = $ci_items[$cnt]['name'];
           $date_entered = $ci_items[$cnt]['date_entered'];
           $date_modified = $ci_items[$cnt]['date_modified'];
           $modified_user_id = $ci_items[$cnt]['modified_user_id'];
           $created_by = $ci_items[$cnt]['created_by'];
           $description = $ci_items[$cnt]['description'];
           $deleted = $ci_items[$cnt]['deleted'];
           $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
           $child_id = $ci_items[$cnt]['child_id'];
           $child_name = $ci_items[$cnt]['child_name'];	
           $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
           $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
           $ci_type_id = $ci_items[$cnt]['ci_type_id'];
           $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
           $project_id_c = $ci_items[$cnt]['project_id_c'];
           $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
           $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
           $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];

           $ci_type_name = $ci_items[$cnt]['ci_type_name'];
           $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
           $parent_ci_name = $ci_items[$cnt]['parent_ci_name'];
           $image_url = $ci_items[$cnt]['image_url'];
           $enabled = $ci_items[$cnt]['enabled'];

           if ($image_url != NULL){
              $image = "<img src=".$image_url." width=16>";
              } else {
              $image = "";
              } 

           #$parent_service_type = $ci_items[$cnt]['parent_service_type'];
           #$service_type = $ci_items[$cnt]['service_type'];
           if ($auth == 3 || ($sess_account_id != NULL && $sess_account_id==$ci_account_id_c)){
              $edit = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$id."&valuetype=".$valtype."');return false\"><font size=2 color=red><B>[".$strings["action_edit"]."]</B></font></a> ";
              }

           $lingoname = "name_".$lingo;

           if ($ci_items[$cnt][$lingoname] != NULL){
              $name = $ci_items[$cnt][$lingoname];
              }

           if ($auth == 3){
              $show_id = " | ID: ".$id;
              } else {
              $show_id = "";
              }

#           $cis .= "<div style=\"".$divstyle_white."\">".$image." ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemTypes&action=view&value=".$ci_type_id."&valuetype=".$valtype."');return false\"> [".$ci_type_name."]</a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a>".$show_id."</div>";
 
           $cis .= "<div style=\"".$divstyle_white."\">".$image." ".$edit." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=".$action."&value=&valuetype=".$valtype."&ci_type_id=".$ci_type_id."&search_id=".$search_id."&keyword=".$keyword."');return false\"> [".$ci_type_name."]</a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$id."&valuetype=".$valtype."');return false\"><B>".$name."</B></a>".$show_id."</div>";
      
           } // end for
      
       } else { // end if array

       $cis = "<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";

       }
    
    if ($sess_contact_id != NULL){
       $addnew = "<div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addnew"]."</B></font></a></div>";
       }
       
    if (count($ci_items)>10){
       echo $addnew.$cis.$addnew;
       } else {
       echo $cis.$addnew;
       }
   
    echo $navi;

   # End List
   ################################
   break;
   ################################
   # Start Add/Edit/View
   case 'bind':

    # binding

   break;
   case 'add':
   case 'edit':
   case 'view':

#    if (($action == 'add' || $action == 'edit') && $val == NULL){
    if ($action == 'edit' && $val == NULL){
       exit;
       }

    $sendiv = $_POST['sendiv'];
    if ($sendiv){
       $BodyDIV = $sendiv;
       }

    if ($_POST['sendiv'] == 'lightform'){
       echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
       }

    $clonevaluetype = $_POST['clonevaluetype'];
    $clonevalue = $_POST['clonevalue'];

    if ($action == 'add' && ($valtype == 'ConfigurationItemTypes' && $val != NULL || $valtype == 'ConfigurationItems' && $val != NULL || $clonevaluetype == 'ConfigurationItems' && $clonevalue != NULL)){       

       if ($valtype == 'ConfigurationItems' && $val != NULL){
          $sclm_configurationitems_id_c = $val;
          }

       $ci_object_type = $do;
       $ci_action = "select";

       // clone from filters and others
       if ($clonevaluetype == 'ConfigurationItems' && $clonevalue != NULL){
          $clone_sclm_configurationitems_id_c = $clonevalue;
          $ci_params[0] = " id='".$clone_sclm_configurationitems_id_c."' ";
          } elseif ($valtype == 'ConfigurationItemTypes' && $val != NULL){
          $ci_params[0] = " sclm_configurationitemtypes_id_c='".$val."' && account_id_c='".$sess_account_id."' ";          
          } 

       if ($_POST['parent_ci']){
          $sclm_configurationitems_id_c = $_POST['parent_ci'];
          $ci_params[0] = " sclm_configurationitems_id_c='".$sclm_configurationitems_id_c."' && account_id_c='".$sess_account_id."' "; 
          }

       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = " sclm_configurationitemtypes_id_c, name, date_entered DESC "; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              #$id = $ci_items[$cnt]['id'];
              #$name = $ci_items[$cnt]['name'];
              $name = "New CI Name";
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              #$description = $ci_items[$cnt]['description'];
              $description = "New CI Description";
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $child_id = $ci_items[$cnt]['child_id'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
#echo " ACC: $ci_account_id_c <P>";
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
              if ($clonevaluetype == 'ConfigurationItems' && $clonevalue != NULL){
                 #$ci_type_id = $ci_items[$cnt]['ci_type_id'];
                 }
              $ci_data_type = $ci_items[$cnt]['ci_data_type'];
              $image_url = $ci_items[$cnt]['image_url'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
              $project_id_c = $ci_items[$cnt]['project_id_c'];
              $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
              $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
              $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
              $enabled = $ci_items[$cnt]['enabled'];
      
              } // end for

          } // is array

       } // end cloning

    if ($action == 'edit' || $action == 'view'){

       $show_details = TRUE;

       $ci_object_type = $do;
       $ci_action = "select";
       $ci_params[0] = " id='".$val."' ";
       $ci_params[1] = ""; // select array
       $ci_params[2] = ""; // group;
       $ci_params[3] = ""; // order;
       $ci_params[4] = ""; // limit
  
       $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

       if (is_array($ci_items)){

          for ($cnt=0;$cnt < count($ci_items);$cnt++){

              $id = $ci_items[$cnt]['id'];
              $name = $ci_items[$cnt]['name'];
              $date_entered = $ci_items[$cnt]['date_entered'];
              $date_modified = $ci_items[$cnt]['date_modified'];
              $modified_user_id = $ci_items[$cnt]['modified_user_id'];
              $created_by = $ci_items[$cnt]['created_by'];
              $description = $ci_items[$cnt]['description'];
              $deleted = $ci_items[$cnt]['deleted'];
              $assigned_user_id = $ci_items[$cnt]['assigned_user_id'];
              $child_id = $ci_items[$cnt]['child_id'];
              $ci_account_id_c = $ci_items[$cnt]['account_id_c'];
              $ci_contact_id_c = $ci_items[$cnt]['contact_id_c'];
              $ci_type_id = $ci_items[$cnt]['ci_type_id'];
              $ci_data_type = $ci_items[$cnt]['ci_data_type'];
              $image_url = $ci_items[$cnt]['image_url'];
              $cmn_statuses_id_c = $ci_items[$cnt]['cmn_statuses_id_c'];
              $sclm_configurationitems_id_c = $ci_items[$cnt]['sclm_configurationitems_id_c'];
              $project_id_c = $ci_items[$cnt]['project_id_c'];
              $projecttask_id_c = $ci_items[$cnt]['projecttask_id_c'];
              $sclm_sow_id_c = $ci_items[$cnt]['sclm_sow_id_c'];
              $sclm_sowitems_id_c = $ci_items[$cnt]['sclm_sowitems_id_c'];
              $enabled = $ci_items[$cnt]['enabled'];

              if ($action == 'view'){

                 if ($ci_items[$cnt][$lingoname] != NULL){
                    $navi_name = $ci_items[$cnt][$lingoname];
                    } else {
                    $navi_name = $name;
                    }

                 if ($ci_items[$cnt][$lingodesc] != NULL){
                    $navi_description = $ci_items[$cnt][$lingodesc];
                    } else {
                    $navi_description = $description;
                    }

                 } elseif ($action == 'edit'){

                 for ($x=0;$x<count($lingos);$x++) {

                     $extension = $lingos[$x][0][0][0][0][0][0];

                     if ($name_field_base == "name_x_c"){

                        $name_field_lingo = "name_".$extension."_c";
                        $content_field_lingo = "description_".$extension."_c";
          
                        } else {

                        $name_field_lingo = $name_field_base.$extension;
                        $content_field_lingo = $content_field_base.$extension;

                        } 

                     if ($ci_items[$cnt][$name_field_lingo] == NULL){
                        $name_field_lingo = $ci_items[$cnt]['name'];
                        } else {
                        $name_field_lingo = $ci_items[$cnt][$name_field_lingo];
                        } 

                     if ($ci_items[$cnt][$content_field_lingo] == NULL){
                        $content_field_lingo = $ci_items[$cnt]['description']; 
                        } else {
                        $content_field_lingo = $ci_items[$cnt][$content_field_lingo];
                        } 

                     } # for lingos

                 } # if edit

              } // end for

          #echo "$lingoname,$lingodesc<P>";

          $field_lingo_pack = $funky_gear->lingo_data_pack ($ci_items, $name, $description, $name_field_base,$desc_field_base);

          } // is array

       } // if action

    #$navi_name = $name;

    if (!$ci_account_id_c){
       if (!$sess_account_id){
          $ci_account_id_c = $account_id_c;
          } else {
          $ci_account_id_c = $sess_account_id;
          }
       }

    if (!$ci_contact_id_c){
       if (!$sess_contact_id){
          $ci_contact_id_c = $contact_id_c;
          } else {
          $ci_contact_id_c = $sess_contact_id;
          }
       }

    if ($action == 'add' && $valtype == 'ConfigurationItemTypes' && $val != NULL){ 
       $ci_type_id = $val;
       }


    # Accounts Services SLAs Features
    $features[] = 'e027d211-75c9-d360-17cb-54e8577757ca'; # Colours
    $features[] = 'a4b786aa-5f30-2258-8226-52ad30ae0f35'; # OS

    if (in_array($ci_type_id, $cit_array)){
       $show_fields = FALSE;
       $show_details = FALSE;
       $do_scroller = FALSE;
       } else {
       $show_fields = TRUE;
       $show_details = TRUE;
       $do_scroller = TRUE;
       }

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
    $infra_array[] = '7827074f-a7d3-9ae5-e473-5255d64e5c73';
    $infra_array[] = '7d2f42a9-9de7-224d-712c-52ad30da69fd';
    $infra_array[] = '9a2ee7f9-67b6-9f72-c133-52ad302dfdc0';
    $infra_array[] = '63fef2c9-9acf-fbd1-56c7-52ad300f480f';
    $infra_array[] = 'de350370-d2d3-e84b-13c1-52ad5f2fb2ab';
    $infra_array[] = '9065cbc6-177f-9848-1ada-52ad30451c3f';
    $infra_array[] = '94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4';
    $infra_array[] = 'cd287492-19ce-99b3-6ead-52e0c97a6e83';
    $infra_array[] = '5601009c-5ebd-bc31-3659-52e0e4b16ffb';
    $infra_array[] = '3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889';
    $infra_array[] = '49ff2505-7d08-cb5c-64e8-52e0e490c0dc';
    $infra_array[] = '617ab884-61b5-d7a1-1de7-52ad61df4cae';
    $infra_array[] = '34647ae4-154c-68f3-74ea-52b0c8abc3dc';
    $infra_array[] = 'b3621853-e25d-0e38-84ff-52c286ae0de9';
    $infra_array[] = '3f6d75b7-c0f5-1739-c66d-52c2989ce02d';
    $infra_array[] = 'cb455d67-8335-df81-1d3b-52ad67c4977e';
    $infra_array[] = '77c9dccf-a0a7-05fc-a05f-52ad62515fc7';
    $infra_array[] = '52784a42-d442-9e71-8d09-529304d1d518';
    $infra_array[] = '7835c8b9-f7d5-5d0a-be10-52ad9c866856';
    $infra_array[] = '711d9da0-c885-6a0d-1a2c-52c286bd762d';
    $infra_array[] = '7ef914c8-09f8-82c9-d4b9-52c29793ef85';
    $infra_array[] = '7b5baafb-6f98-5d25-d9c8-541fca790cea';
    $infra_array[] = '8c8a3231-1d86-0117-4680-541fcbab4f6a';
    $infra_array[] = 'c194460c-0e8d-ca8e-0aa9-541fc5785016';
    $infra_array[] = '388b56dc-771e-b743-e63b-541fc6070ab9';
    #$infra_array[] = '';

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

    $tablefields[$tblcnt][0] = 'enabled'; // Field Name
    $tablefields[$tblcnt][1] = "Enabled"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'enabled';//$field_value_id;
    $tablefields[$tblcnt][21] = $enabled; //$field_value;

    if ($sendiv){

       $tblcnt++;
       $tablefields[$tblcnt][0] = "sendiv"; // Field Name
       $tablefields[$tblcnt][1] = "SENDIV"; // Full Name
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
       $tablefields[$tblcnt][20] = "sendiv"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sendiv; //$field_value;   

       }

    $tblcnt++;

    #################################
    # Parent CI & CIT Preparation

    #echo "ci_type_id $ci_type_id <P>";

    if ($_POST['parent_ci']){
       $sclm_configurationitems_id_c = $_POST['parent_ci'];
       }

    if ($_POST['partype']){
       $par_ci_type_id = $_POST['partype'];
       $par_ci_type = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
       //echo "PAR CI TYPE:".$par_ci_type."<P>";
       #$par_ci_type .= " && id='".$par_ci_type."' ";
       } elseif (in_array($par_ci_type_id,$infra_array)){
       $par_ci_type_id = $_POST['partype'];
       #echo "PARCIT: ".$par_ci_type_id."<P>";
       $par_ci_type = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";

       } elseif ($ci_type_id == "ad1d9ad1-0a25-0e49-3c18-54eb24956766"){

       #$par_ci_type_id = $_POST['partype'];
##       $par_ci_type = " && sclm_configurationitemtypes_id_c='".$ci_type_id."' && account_id_c='".$ci_account_id_c."' ";
       #$par_ci_type = " && sclm_configurationitemtypes_id_c='".$ci_type_id."' ";

       } else {
       $par_ci_type = "";
       } 

    # Security Module used to allow content relationships
    $ci_array[] = '3ab6d66b-e867-8c14-11a4-527377ce9e86'; // Accounts
    $ci_array[] = '2abc3625-4ee1-78ed-42a8-52b4f5e1f7c0'; // Contacts
    $ci_array[] = '6244acfb-1ade-84f4-e35f-5277c7416024'; // Ticketing 
    $ci_array[] = '3ac28d96-bebc-9385-7b79-530a144e8e8b'; // Ticketing Activities
    $ci_array[] = '4e6954f5-ceef-c569-ca52-541ef3412e25'; // SOW 
    $ci_array[] = '823dd4fc-1100-d776-1848-541ef361ed65'; // SOW Items 
    $ci_array[] = '605010ff-9fb4-941d-2e3c-541ef814c585'; // Projects
    $ci_array[] = 'daee409c-7ec2-5990-dd63-541ef86047b4'; // Project Tasks 
    $ci_array[] = '9eb64f6a-6428-91f7-713f-541ef94bdff8'; // Content 

    #################################
    # Parent CI

    if ($_POST['sclm_content_id_c'] != NULL || in_array($_POST['sclm_configurationitemtypes_id_c'], $ci_array)){


       $tablefields[$tblcnt][0] = 'sclm_configurationitems_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Content"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_content'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($auth == 3){
          $tablefields[$tblcnt][9][4] = " name IS NOT NULL ORDER BY name ASC ";//$exception;
          } else {
          if ($auth == 2){
             $tablefields[$tblcnt][9][4] = " (account_id_c='".$ci_account_id_c."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ".$par_ci_type." ORDER BY name ASC ";
             } else {
             $tablefields[$tblcnt][9][4] = " ((account_id_c='".$ci_account_id_c."' && contact_id_c='".$sess_contact_id."') || cmn_statuses_id_c !='".$standard_statuses_closed."') ORDER BY name ASC ";
             }
          }

       $tablefields[$tblcnt][9][5] = $_POST['sclm_content_id_c']; // Current Value
       $tablefields[$tblcnt][9][6] = 'Content';
       $tablefields[$tblcnt][9][7] = "sclm_content"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_configurationitems_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 

/*
       } elseif ($sclm_configurationitems_id_c != NULL && $val == 'df940500-4cb3-b830-d6be-53e1f2801616' && $valtype == 'ConfigurationItemTypes') {

        # Used to hide binding parent - not  necessary to show

        $tablefields[$tblcnt][0] = 'sclm_configurationitems_id_c'; // Field Name
        $tablefields[$tblcnt][1] = "Hidden"; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 1; // is_name
        $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = ''; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = ""; // Field ID
        $tablefields[$tblcnt][20] = 'sclm_configurationitems_id_c';//$field_value_id;
        $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;
*/
       } elseif ($show_fields) {

       $tablefields[$tblcnt][0] = 'sclm_configurationitems_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ConfigurationItemParent"];
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "dropdown";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($auth == 3){

          $tablefields[$tblcnt][9][4] = " name IS NOT NULL ".$par_ci_type." ORDER BY name ASC ";//$exception;

          } elseif ($auth == 2){

          $tablefields[$tblcnt][9][4] = " (account_id_c='".$ci_account_id_c."' || cmn_statuses_id_c !='".$standard_statuses_closed."') ".$par_ci_type." ORDER BY name ASC ";
          #$tablefields[$tblcnt][9][4] = " account_id_c='".$ci_account_id_c."' ".$par_ci_type." ORDER BY name ASC ";


          } else {

          $tablefields[$tblcnt][9][4] = " ((account_id_c='".$ci_account_id_c."' && contact_id_c='".$sess_contact_id."') || cmn_statuses_id_c !='".$standard_statuses_closed."') ".$par_ci_type." ORDER BY name ASC ";

          }

       $tablefields[$tblcnt][9][5] = $sclm_configurationitems_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_configurationitems_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 

       } elseif ($auth==3) {

       $tablefields[$tblcnt][0] = "sclm_configurationitems_id_c"; // Field Name
       $tablefields[$tblcnt][1] = "Parent CI"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][5] = $sclm_configurationitems_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItems';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitems"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ConfigurationItems'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_configurationitems_id_c; // Current Value
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "sclm_configurationitems_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;   

       } else {

       $tablefields[$tblcnt][0] = "sclm_configurationitems_id_c"; // Field Name
       $tablefields[$tblcnt][1] = "Parent CI"; // Full Name
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
       $tablefields[$tblcnt][20] = "sclm_configurationitems_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;   

       }

/*
echo " par_ci_type $par_ci_type <BR>";
echo " ci_account_id_c $ci_account_id_c <BR>";
echo " auth $auth <BR>";
echo " sess_contact_id $sess_contact_id <BR>";
echo " standard_statuses_closed $standard_statuses_closed <BR>";
echo "query: ".$tablefields[$tblcnt][9][4]."<BR>"; 
*/


    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'sclm_configurationitems_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $sclm_configurationitems_id_c; //$field_value;

    /*
     # Service Assets | ID: a39735f4-b558-5214-1d07-52593e7f39da (not scanned)
     # Infrastructure | ID: 7827074f-a7d3-9ae5-e473-5255d64e5c73 (not scanned)
    */

    if ($ci_type_id == '6de9b547-7c78-9ff4-83ea-52a8dc7f33f1'){ // Filter Server 

      $added_header .= "<div style=\"".$divstyle_white."\"><div style=\"width:16;float:left;padding-top:0;\"><img src=images/icons/plus.gif width=16></div><div style=\"width:90%;float:left;padding-top:2;margin-left:8;padding-left:2;\">
<a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7d2f42a9-9de7-224d-712c-52ad30da69fd&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=7827074f-a7d3-9ae5-e473-5255d64e5c73');return false\"><font color=#151B54><B>".$strings["action_addnew"]." DC</B></font></a><BR>
-> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=9a2ee7f9-67b6-9f72-c133-52ad302dfdc0&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=7d2f42a9-9de7-224d-712c-52ad30da69fd');return false\"><font color=#151B54><B>".$strings["action_addnew"]." DC Floor (ID, Name)</B></font></a><BR>
---> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=63fef2c9-9acf-fbd1-56c7-52ad300f480f&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=9a2ee7f9-67b6-9f72-c133-52ad302dfdc0');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Rack"]."</B></font></a><BR>
------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=9065cbc6-177f-9848-1ada-52ad30451c3f&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=63fef2c9-9acf-fbd1-56c7-52ad300f480f');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_System"]."</B></font></a><BR>
------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=de350370-d2d3-e84b-13c1-52ad5f2fb2ab&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=63fef2c9-9acf-fbd1-56c7-52ad300f480f');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_RackUnitSpace"]."</B></font></a><BR>
---------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=77c9dccf-a0a7-05fc-a05f-52ad62515fc7&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=de350370-d2d3-e84b-13c1-52ad5f2fb2ab');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_RackServerUnit"]."</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7835c8b9-f7d5-5d0a-be10-52ad9c866856&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=77c9dccf-a0a7-05fc-a05f-52ad62515fc7');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Server"]." ".$strings["CI_Host"]."</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=711d9da0-c885-6a0d-1a2c-52c286bd762d&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=77c9dccf-a0a7-05fc-a05f-52ad62515fc7');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Server"]." VM</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=7ef914c8-09f8-82c9-d4b9-52c29793ef85&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=711d9da0-c885-6a0d-1a2c-52c286bd762d');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Server"]." VM ".$strings["CI_Host"]."</B></font></a><BR>
---------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=de350370-d2d3-e84b-13c1-52ad5f2fb2ab');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]."</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=cd287492-19ce-99b3-6ead-52e0c97a6e83&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." ".$strings["CI_Host"]."</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=5601009c-5ebd-bc31-3659-52e0e4b16ffb&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." Interconnect Bay</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=5601009c-5ebd-bc31-3659-52e0e4b16ffb');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." Interconnect Bay Switch</B></font></a><BR>
------------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=49ff2505-7d08-cb5c-64e8-52e0e490c0dc&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=3d1e2b6e-d7a3-d50d-b8e1-52e0e4e61889');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_BladeChasis"]." Interconnect Bay Switch ".$strings["CI_Host"]."</B></font></a><BR>
------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=617ab884-61b5-d7a1-1de7-52ad61df4cae&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=94e5f1a2-6b20-2ac2-07c9-52ad30d13cc4');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]."</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=34647ae4-154c-68f3-74ea-52b0c8abc3dc&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=617ab884-61b5-d7a1-1de7-52ad61df4cae');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]." ".$strings["CI_Host"]."</B></font></a><BR>
---------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=b3621853-e25d-0e38-84ff-52c286ae0de9&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=617ab884-61b5-d7a1-1de7-52ad61df4cae');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]." VM</B></font></a><BR>
------------------> <a href=\"#\" onClick=\"loader('".$sendiv."');doBPOSTRequest('".$sendiv."','Body.php', 'pc=".$portalcode."&do=ConfigurationItems&action=add&value=3f6d75b7-c0f5-1739-c66d-52c2989ce02d&valuetype=ConfigurationItemTypes&clonevaluetype=ConfigurationItems&clonevalue=".$clone_sclm_configurationitems_id_c."&sendiv=".$sendiv."&partype=b3621853-e25d-0e38-84ff-52c286ae0de9');return false\"><font color=#151B54><B>".$strings["action_addnew"]." ".$strings["CI_Blade"]." VM ".$strings["CI_Host"]."</B></font></a><BR>
</div></div><P>";

       } // end if showing for servers in filters

    # May need to add a dropdown for certain embedded CIs for filters (par CIT)
    $funky_ci_array[] = '6de9b547-7c78-9ff4-83ea-52a8dc7f33f1'; // Filter Server
    $funky_ci_array[] = '83a83279-9e48-0bfe-3ca0-52b8d8300cc2'; // Filter Trigger(s) 
    $funky_ci_array[] = 'c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d'; // Filter Email Template 
    $funky_ci_array[] = 'be9692fa-5341-6934-7500-52ba77913179'; // TO
    $funky_ci_array[] = '45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0'; // CC
    $funky_ci_array[] = '47e1b49f-4059-3d14-94c7-52ba7891d1b5'; // BCC
    $funky_ci_array[] = '683bb5f7-e1c7-4796-8d23-52b0df65369f'; // Filter Service SLA Request 
    $funky_ci_array[] = 'a19083b1-25bd-65be-76e8-52def587f20f'; // Frequency Count
    $funky_ci_array[] = '278395e9-3127-dc1c-53ac-52def9c06c63'; // Frequency Time-span (Mins)
    $funky_ci_array[] = 'c3891c31-9198-476d-0a8a-52df0e00c722'; // Current Count
    $funky_ci_array[] = '39ffa1e6-2b7c-7aaa-3370-52b389684442'; // Shared Service SLA Requests
    $funky_ci_array[] = 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f'; // Shared Projects
    $funky_ci_array[] = '2be3cda0-a296-9c0f-7598-54b8c5fc2c3f'; // ServicesSLAs for Licenses
    $funky_ci_array[] = '9afa5bc2-9a1f-c831-b032-57122091b780'; // ServicesSLAs for scheduler
    $funky_ci_array[] = '3172f9e9-3915-b709-fc58-52b38864eaf6'; // Related Account Sharing

    # Common CIs using yesno
    $filter_yesno_array[] = '1078abaa-0615-06ef-9826-52b0d6f32290'; // Filter Create Ticket
    $filter_yesno_array[] = '99490a5c-8f51-6652-a121-52bfac638c32'; // Filter Create Email
    $filter_yesno_array[] = 'a686c273-cc87-9fc8-08f0-52c38fba62c1'; // Filter Create Activity
    $filter_yesno_array[] = '887f79ce-d835-772a-ef9a-52ce399970e4'; // Filter Auto-reply to Sender
    $filter_yesno_array[] = 'cc55a107-98ca-8261-9900-52ce36601cd0'; // Filter Date+Time Concat
    $filter_yesno_array[] = '423752fe-a632-9b4d-8c3b-52ccc968fe59'; // Live Status
    $filter_yesno_array[] = '2864a518-19f4-ddfa-366e-52ccd012c28b'; // Maintenance
    $filter_yesno_array[] = '562695ff-00d4-8ead-e3c2-52b3897ef61e'; // Shared Tickets
    $filter_yesno_array[] = 'e2affd29-d116-caa8-6f0c-52fa4d034cf5'; // Portal Access
    $filter_yesno_array[] = '5195ecc6-ec22-1fdd-0fd5-54d898ab38ed'; // Portal Admin
    $filter_yesno_array[] = 'a8d97830-b100-e03e-c445-54d8be1ae651'; // Portal Emails
    $filter_yesno_array[] = 'c4f8a9b2-b8f2-8e42-995b-54d8d7e192c1'; // Portal Infra
    $filter_yesno_array[] = '58a896be-c277-844b-f051-54ebedac5dd4'; // Portal Infra

    # Social Networks to join
    $filter_yesno_array = array_merge($filter_yesno_array,$sn_array);

    ####################################
    # Name field - most extensible field - can contain IDs of any objects or other CITs

    if (in_array($ci_type_id,$funky_ci_array)){

       $show_details = FALSE;

       # Default to be the partype
       $this_ci_type_id = $par_ci_type;

       switch ($ci_type_id){

        case '6de9b547-7c78-9ff4-83ea-52a8dc7f33f1':
         $label = $strings["CI_Server"];
         # These same items need to be updated in the funky.php do_filterbits function for checking for servers in email body
         # Also check servers in do_filters start
         $this_ci_type_id = "(sclm_configurationitemtypes_id_c='7835c8b9-f7d5-5d0a-be10-52ad9c866856' || sclm_configurationitemtypes_id_c='34647ae4-154c-68f3-74ea-52b0c8abc3dc' || sclm_configurationitemtypes_id_c='7ef914c8-09f8-82c9-d4b9-52c29793ef85' || sclm_configurationitemtypes_id_c='3f6d75b7-c0f5-1739-c66d-52c2989ce02d' || sclm_configurationitemtypes_id_c='cd287492-19ce-99b3-6ead-52e0c97a6e83' || sclm_configurationitemtypes_id_c='49ff2505-7d08-cb5c-64e8-52e0e490c0dc') ";
         $typelbl = 'ConfigurationItems';
         $typetbl = 'sclm_configurationitems';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        case '83a83279-9e48-0bfe-3ca0-52b8d8300cc2':
         $label = $strings["EmailFilterTrigger"];
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='83a83279-9e48-0bfe-3ca0-52b8d8300cc2'";
         $typelbl = 'ConfigurationItemTypes';
         $typetbl = 'sclm_configurationitemtypes';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        case 'c8d6bfc8-01b7-4b95-aa92-52ba659a7a2d':
         $label = $strings["EmailFilterTemplate"];
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='78b22b7d-48c5-737c-ffb6-52b8ded3345e'";
         $typelbl = 'ConfigurationItems';
         $typetbl = 'sclm_configurationitems';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        case 'be9692fa-5341-6934-7500-52ba77913179':
         $label = $strings["EmailFilterRecipients"].":TO";
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='cf3271fc-f361-22c8-0212-52b998d102ac'";
         $typelbl = 'ConfigurationItems';
         $typetbl = 'sclm_configurationitems';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        case '45f7af5c-7bc2-1830-b4b7-52ba78fdc9d0':
         $label = $strings["EmailFilterRecipients"].":CC";
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='4203105b-79b1-8330-b136-52b9985ddcf1'";
         $typelbl = 'ConfigurationItems';
         $typetbl = 'sclm_configurationitems';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        case '47e1b49f-4059-3d14-94c7-52ba7891d1b5':
         $label = $strings["EmailFilterRecipients"].":BCC";
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='c2bc3b5f-bfdd-a0ef-e399-52b998a94a28'";
         $typelbl = 'ConfigurationItems';
         $typetbl = 'sclm_configurationitems';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        # 2016-04-12 - Changed to ServiceSLAs to broaden the branding
        /*
        case '2be3cda0-a296-9c0f-7598-54b8c5fc2c3f':
         $label = "Account Service SLA";
         #$this_ci_type_id = "sclm_configurationitemtypes_id_c='683bb5f7-e1c7-4796-8d23-52b0df65369f' && cmn_statuses_id_c!='".$standard_statuses_closed."' ";
         $typelbl = 'AccountsServicesSLAs';
         $typetbl = 'sclm_accountsservicesslas';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
         $cit_exception = " && id='".$ci_type_id."' ";
        break;
        */
        # 2016-04-12 - Changed to ServiceSLAs to broaden the branding
        case '2be3cda0-a296-9c0f-7598-54b8c5fc2c3f':
        case '9afa5bc2-9a1f-c831-b032-57122091b780':
         $label = "Service SLA";
         #$this_ci_type_id = "sclm_configurationitemtypes_id_c='683bb5f7-e1c7-4796-8d23-52b0df65369f' && cmn_statuses_id_c!='".$standard_statuses_closed."' ";
         $typelbl = 'ServicesSLA';
         $typetbl = 'sclm_servicessla';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
         $cit_exception = " && id='".$ci_type_id."' ";
        break;
        case '683bb5f7-e1c7-4796-8d23-52b0df65369f':
        case '39ffa1e6-2b7c-7aaa-3370-52b389684442':
         $label = $strings["ServiceSLARequests"];
#         $this_ci_type_id = "sclm_configurationitemtypes_id_c='683bb5f7-e1c7-4796-8d23-52b0df65369f' && cmn_statuses_id_c!='".$standard_statuses_closed."' ";
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='683bb5f7-e1c7-4796-8d23-52b0df65369f' ";
         $typelbl = 'ServiceSLARequests';
         $typetbl = 'sclm_serviceslarequests';
         $arraytype = 'db';
         $addquery = " ORDER by name ASC "; 
        break;
        case '605010ff-9fb4-941d-2e3c-541ef814c585': // Used for content sharing purposes
        case 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f': // Used for account sharing purposes
         $label = $strings["Projects"];
         $typelbl = 'Projects';
         $typetbl = 'project,project_cstm';
         $arraytype = 'db';
         $addquery = " ORDER by project.name ASC "; 
        break;
/*
         case 'e95a1cfa-f6f9-c6d6-d84b-52b38884257f': //acc_shared_type_projects
          $typelbl = 'Projects';
          $typetbl = 'sclm_serviceslarequests';
          $arraytype = 'db';
         break;
      $acc_shared_type_slarequests = '39ffa1e6-2b7c-7aaa-3370-52b389684442';
      $acc_shared_type_ticketing = '562695ff-00d4-8ead-e3c2-52b3897ef61e';
*/
        case 'daee409c-7ec2-5990-dd63-541ef86047b4': // Used for content sharing purposes
         $label = $strings["ProjectTasks"];
         $typelbl = 'ProjectTasks';
         $typetbl = 'project_task';
         $arraytype = 'db';
         $addquery = " ORDER by project_task.name ASC "; 
        break;
        case '4e6954f5-ceef-c569-ca52-541ef3412e25': // Used for content sharing purposes
         $label = $strings["SOW"];
         $typelbl = 'SOW';
         $typetbl = 'sclm_sow';
         $arraytype = 'db';
         $addquery = " ORDER by sclm_sow.name ASC "; 
        break;
        case '823dd4fc-1100-d776-1848-541ef361ed65': // Used for content sharing purposes
         $label = $strings["SOWItems"];
         $typelbl = 'SOWItems';
         $typetbl = 'sclm_sowitems';
         $arraytype = 'db';
         $addquery = " ORDER by sclm_sowitems.name ASC "; 
        break;
        case '3172f9e9-3915-b709-fc58-52b38864eaf6': // Used for rel account sharing purposes
         $label = $strings["RelatedAccount"];
         $typelbl = 'AccountRelationships';
         $typetbl = 'sclm_accountrelationships';
         $arraytype = 'db';
         $addquery = " ORDER by sclm_accountrelationships.name ASC "; 
        break;
        case 'c3891c31-9198-476d-0a8a-52df0e00c722':
         $label = "Frequency Current Count"; //$strings["EmailFilterFrequencyCount"];
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='c3891c31-9198-476d-0a8a-52df0e00c722'";
         $typelbl = 'ConfigurationItems';

         $dd_pack[0]=0;
         $dd_pack[1]=1;
         $dd_pack[2]=2;
         $dd_pack[3]=3;
         $dd_pack[4]=4;
         $dd_pack[5]=5;
         $dd_pack[6]=6;
         $dd_pack[7]=7;
         $dd_pack[8]=8;
         $dd_pack[9]=9;
         $dd_pack[10]=10;
         $dd_pack[15]=15;
         $dd_pack[20]=20;
         $dd_pack[30]=30;

         $typetbl = $dd_pack;
         $arraytype = 'list';

        break;
        case 'a19083b1-25bd-65be-76e8-52def587f20f':
         $label = "Frequency Count"; //$strings["EmailFilterFrequencyCount"];
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='a19083b1-25bd-65be-76e8-52def587f20f'";
         $typelbl = 'ConfigurationItems';

         $dd_pack[0]=0;
         $dd_pack[1]=1;
         $dd_pack[2]=2;
         $dd_pack[3]=3;
         $dd_pack[4]=4;
         $dd_pack[5]=5;
         $dd_pack[6]=6;
         $dd_pack[7]=7;
         $dd_pack[8]=8;
         $dd_pack[9]=9;
         $dd_pack[10]=10;
         $dd_pack[15]=15;
         $dd_pack[20]=20;
         $dd_pack[30]=30;
         $dd_pack[40]=40;
         $dd_pack[50]=50;
         $dd_pack[60]=60;
         $dd_pack[70]=70;
         $dd_pack[80]=80;
         $dd_pack[90]=90;
         $dd_pack[100]=100;

         $typetbl = $dd_pack;
         $arraytype = 'list';

        break;
        case '278395e9-3127-dc1c-53ac-52def9c06c63':
         $label = "Frequency Time Span (min)"; //$strings["EmailFilterFrequencyCount"];
         $this_ci_type_id = "sclm_configurationitemtypes_id_c='278395e9-3127-dc1c-53ac-52def9c06c63'";
         $typelbl = 'ConfigurationItems';

         $dd_pack[1]=1;
         $dd_pack[2]=2;
         $dd_pack[3]=3;
         $dd_pack[4]=4;
         $dd_pack[5]=5;
         $dd_pack[6]=6;
         $dd_pack[7]=7;
         $dd_pack[8]=8;
         $dd_pack[9]=9;
         $dd_pack[10]=10;
         $dd_pack[15]=15;
         $dd_pack[20]=20;
         $dd_pack[30]=30;
         $dd_pack[60]=60;
         $dd_pack[120]=120;
         $dd_pack[180]=180;
         $dd_pack[240]=240;
         $dd_pack[480]=480;
         $dd_pack[960]=960;
         $dd_pack[1920]=1920;
         $dd_pack[3840]=3840;

         $typetbl = $dd_pack;
         $arraytype = 'list';

        break;

       } // $ci_type_id switch

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $label." * "; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = $arraytype; //'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $typetbl; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($action == 'add'){
  //        $addquery = " && id != '".$val."' ";
          }
       if ($action == 'edit' || $action == 'view'){
//          $addquery = " && id = '".$val."' ";
          }

       switch ($typelbl){
  
        case 'ConfigurationItems':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 && ".$this_ci_type_id." ".$addquery;//$exception;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && (account_id_c='".$sess_account_id."' || cmn_statuses_id_c != '".$standard_statuses_closed."') && ".$this_ci_type_id." ".$addquery;
            }

        break;
        case 'ConfigurationItemTypes':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 && ".$this_ci_type_id." ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && ".$this_ci_type_id." && cmn_statuses_id_c != '".$standard_statuses_closed."' ".$addquery;
            }

        break;
        case 'ServiceSLARequests':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && account_id_c='".$sess_account_id."' ".$addquery;
            }

        break;
        case 'Projects':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " project.deleted=0 ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project.deleted=0 && project_cstm.account_id_c='".$sess_account_id."' ".$addquery;
            }

        break;
        case 'ProjectTasks':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && account_id_c='".$sess_account_id."' ".$addquery;
            }

        break;
        case 'SOW':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && account_id_c='".$sess_account_id."' ".$addquery;
            }

        break;
        case 'SOWItems':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && account_id_c='".$sess_account_id."' ".$addquery;
            }

        break;
        case 'AccountRelationships':

         if ($auth == 3){
            $tablefields[$tblcnt][9][4] = " deleted=0 ".$addquery;
            #$tablefields[$tblcnt][9][4] = " deleted=0 && account_id_c='".$sess_account_id."' ".$addquery;
            } else {
            $tablefields[$tblcnt][9][4] = " deleted=0 && account_id_c='".$sess_account_id."' ".$addquery;
            }

        break;

       } //switch

       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][6] = $typelbl;
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name';//$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;

       } elseif (in_array($ci_type_id,$filter_yesno_array)) {

       $show_details = FALSE;
       $typelbl = 'ConfigurationItems';

       switch ($ci_type_id){

        case '1078abaa-0615-06ef-9826-52b0d6f32290':
         $label = $strings["FilterCreateTicket"]."?";
        break;
        case 'a686c273-cc87-9fc8-08f0-52c38fba62c1':
         $label = $strings["FilterCreateActivity"]."?";
        break;
        case '99490a5c-8f51-6652-a121-52bfac638c32':
         $label = $strings["FilterSendEmail"]."?";
        break;
        case '887f79ce-d835-772a-ef9a-52ce399970e4':
         $label = $strings["FilterAutoReplyToSender"]."?";
        break;
        case 'cc55a107-98ca-8261-9900-52ce36601cd0':
         $label = $strings["FilterDateTimeConcat"]."?";
        break;
        case '423752fe-a632-9b4d-8c3b-52ccc968fe59':
         $label = $strings["CI_ServerStatus"]."?";
        break;
        case '2864a518-19f4-ddfa-366e-52ccd012c28b':
         $label = $strings["CI_ServerStatusMaintenance"]."?";
        break;
        case '562695ff-00d4-8ead-e3c2-52b3897ef61e':
         $label = "Shared Ticketing";
        break;
        case 'e2affd29-d116-caa8-6f0c-52fa4d034cf5':
         $label = "Shared Portal Access";
        break;
        case '5195ecc6-ec22-1fdd-0fd5-54d898ab38ed':
         $label = "Shared Portal Admin";

       if ($auth<3){
          $cit_exception = " && id='".$ci_type_id."' ";
          } else {
          $cit_exception = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
          } 

        break;
        case 'a8d97830-b100-e03e-c445-54d8be1ae651':
         $label = "Shared Portal Emails";

       if ($auth<3){
          $cit_exception = " && id='".$ci_type_id."' ";
          } else {
          $cit_exception = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
          } 

        break;
        case 'c4f8a9b2-b8f2-8e42-995b-54d8d7e192c1':
         $label = "Shared Portal Infra";

       if ($auth<3){
          $cit_exception = " && id='".$ci_type_id."' ";
          } else {
          $cit_exception = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
          } 

        break;
        case '58a896be-c277-844b-f051-54ebedac5dd4':
         $label = "Shared Pricing";

       if ($auth<3){
          $cit_exception = " && id='".$ci_type_id."' ";
          } else {
          $cit_exception = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
          } 

        break;
       } // end switch

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $label." * "; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'yesno';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name';//$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;

       } elseif ($ci_type_id == 'bb105bd2-6d5d-e9b1-dc66-52ba021e1f63') { // day range

       $tblcnt++;

       $show_details = FALSE;
       $typelbl = 'ConfigurationItems';
       $label = $strings["FilterDayRange"];

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $label." * "; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dayrange';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name';//$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;

       } elseif ($ci_type_id == '291f5d67-13af-1b11-7e39-52b9d60288dc') { // time range

       $tblcnt++;

       $show_details = FALSE;
       $typelbl = 'ConfigurationItems';
       $label = $strings["FilterTimeRange"];

       list($start_time,$end_time) = explode("_", $name);

/*
        $tablefields[$tblcnt][0] = 'name'; // Field Name
        $tablefields[$tblcnt][1] = $label." * "; // Full Name
        $tablefields[$tblcnt][2] = 0; // is_primary
        $tablefields[$tblcnt][3] = 0; // is_autoincrement
        $tablefields[$tblcnt][4] = 1; // is_name
        $tablefields[$tblcnt][5] = 'timerange';//$field_type; //'INT'; // type
        $tablefields[$tblcnt][6] = '255'; // length
        $tablefields[$tblcnt][7] = ''; // NULLOK?
        $tablefields[$tblcnt][8] = ''; // default
        $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
        $tablefields[$tblcnt][10] = '1';//1; // show in view 
        $tablefields[$tblcnt][11] = ""; // Field ID
        $tablefields[$tblcnt][20] = 'name';//$field_value_id;
        $tablefields[$tblcnt][21] = $name; //$field_value;
*/
       $tablefields[$tblcnt][0] = 'start_time'; // Field Name
       $tablefields[$tblcnt][1] = $strings["time_start"]." * "; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'timerange';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'start_time';//$field_value_id;
       $tablefields[$tblcnt][21] = $start_time; //$field_value;

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'end_time'; // Field Name
       $tablefields[$tblcnt][1] = $strings["time_finish"]." * "; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'timerange';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = ''; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'end_time';//$field_value_id;
       $tablefields[$tblcnt][21] = $end_time; //$field_value;

       # Add datetime
       } elseif (in_array($ci_type_id,array('7a454f0d-3d12-7bc5-7607-52defc746103'))){

       $tblcnt++;

       if (!$name){
          $name = date('Y-m-d H:i:s');
          }

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Name"]." *"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '30'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   
        
       # end add date

       } elseif (in_array($ci_type_id,array('b38181b6-eb59-0bc3-bad3-52ecd65163f5','787ab970-8f2a-efed-3aca-52ecd566b16b'))){

       $tblcnt++;

       if (!$name){
          $name = date('Y-m-d H:i');
          }

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Name"]." *"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '30'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   
        
       # end add date

       } elseif ($ci_type_id == '8ff4c847-2c82-9789-f085-52b3897c8bf6') { // account

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $strings["RelatedAccount"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " account_id_c='".$sess_account_id."' ";
       $acc_params[1] = " account_id1_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id1_c "; // order;
       $acc_params[4] = ""; // limit
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $child_account_id = $acc_items[$acc_cnt]['child_account_id'];
              $child_account_name = $acc_items[$acc_cnt]['child_account_name'];
              $ddpack[$child_account_id] = "Child-> ".$child_account_name;

              }
          }

       $acc_object_type = "AccountRelationships";
       $acc_action = "select";
       $acc_params[0] = " account_id1_c='".$sess_account_id."' ";
       $acc_params[1] = " account_id_c "; // select array
       $acc_params[2] = ""; // group;
       $acc_params[3] = " account_id_c "; // order;
       $acc_params[4] = ""; // limit
  
       $acc_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_object_type, $acc_action, $acc_params);

       if (is_array($acc_items)){

          for ($acc_cnt=0;$acc_cnt < count($acc_items);$acc_cnt++){

              $parent_account_id = $acc_items[$acc_cnt]['parent_account_id'];
              $parent_account_name = $acc_items[$acc_cnt]['parent_account_name'];
              $ddpack[$parent_account_id] = $parent_account_name." <- Parent";
 
              }
          }

       #$acc_returner = $funky_gear->object_returner ("Accounts", $sess_account_id);
       #$object_return_name = $acc_returner[0];
       #$ddpack[$sess_account_id]=$object_return_name;

       $tablefields[$tblcnt][9][1] = $ddpack;
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name';//$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       } elseif ($ci_type_id == '5311a243-d557-b77c-ee65-541eebf4acb8') { // Content Relationships
/*

Decided to put the list of CI Types in the first call
So - not using this else - using above SOW/Projects CI Types

Configuration Item Sets
Configuration Item Types: System Security Modules and Fields

Accounts | ID: 3ab6d66b-e867-8c14-11a4-527377ce9e86
Contacts | ID: 2abc3625-4ee1-78ed-42a8-52b4f5e1f7c0

Ticketing | ID: 6244acfb-1ade-84f4-e35f-5277c7416024
Ticketing Activities | ID: 3ac28d96-bebc-9385-7b79-530a144e8e8b

Services | ID: 46f60922-a08d-96e7-5a86-52763ae9f9dc
Accounts Services | ID: 44ea091a-da13-83fe-a15c-52763b5d0ee8
AccountsServicesSLAs | ID: b7762036-0a36-248b-a7e8-52ac145be269

Module: SOW | ID: 4e6954f5-ceef-c569-ca52-541ef3412e25
Module: SOW Items | ID: 823dd4fc-1100-d776-1848-541ef361ed65

Module: Projects | ID: 605010ff-9fb4-941d-2e3c-541ef814c585
Module: Project Tasks | ID: daee409c-7ec2-5990-dd63-541ef86047b4

Module: Content | ID: 9eb64f6a-6428-91f7-713f-541ef94bdff8


*/

       } elseif ($par_ci_type_id == '8251ddbc-cd5c-a23c-fc58-53da6f001002') { // Licensing Modules

       if ($auth<3){
          $cit_exception = " && id='".$ci_type_id."' ";
          } else {
          $cit_exception = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
          } 

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "License Instance"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

/*
       } elseif ($par_ci_type_id == '2be3cda0-a296-9c0f-7598-54b8c5fc2c3f') { // License Service SLAs

       if ($auth<3){
          #$cit_exception = " && sclm_configurationitemtypes_id_c='8251ddbc-cd5c-a23c-fc58-53da6f001002' ";
          $cit_exception = " && id='".$ci_type_id."' ";
          } else {
          $cit_exception = " && sclm_configurationitemtypes_id_c='".$par_ci_type_id."' ";
          } 

*/
       } elseif ($par_ci_type_id == '445201ad-ef42-5003-a68b-549a7477da63') { // Workflows


##        } elseif ($ci_type_id == '445201ad-ef42-5003-a68b-549a7477da63' || $ci_type_id == '29d89b45-819c-bef7-befb-549b654f4f7c' || $ci_type_id == '42a7ccaf-180e-504b-c426-541249f85aed' || $ci_type_id == 'b650878b-1a2c-d25f-834a-5498d97e6244' || $ci_type_id == 'c1aac41e-7dd3-238d-5aaf-548d29106525' || $ci_type_id == '8b1b1a96-4348-9565-9629-548d2de65c3f' || $ci_type_id == '322b2fba-8999-a31f-0341-54124919308f') { // Workflows

/*        # Workflows
        case '445201ad-ef42-5003-a68b-549a7477da63':
        case '29d89b45-819c-bef7-befb-549b654f4f7c':
        case '42a7ccaf-180e-504b-c426-541249f85aed':
        case 'b650878b-1a2c-d25f-834a-5498d97e6244':
        case 'c1aac41e-7dd3-238d-5aaf-548d29106525':
        case '8b1b1a96-4348-9565-9629-548d2de65c3f':
        case '322b2fba-8999-a31f-0341-54124919308f':
*/

       $wf_cit = '445201ad-ef42-5003-a68b-549a7477da63';
       $wf_cit_custom = '29d89b45-819c-bef7-befb-549b654f4f7c';
       $wf_cit_accounts = '42a7ccaf-180e-504b-c426-541249f85aed';
       $wf_cit_engagements  = 'b650878b-1a2c-d25f-834a-5498d97e6244';
       $wf_cit_sla_requests = 'c1aac41e-7dd3-238d-5aaf-548d29106525';
       $wf_cit_sla_pricing = '8b1b1a96-4348-9565-9629-548d2de65c3f';
       $wf_cit_partner_onboarding = '322b2fba-8999-a31f-0341-54124919308f';

       $cit_exception = " && id='".$ci_type_id."' ";

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Workflow Instance"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       } elseif ($par_ci_type_id == 'df940500-4cb3-b830-d6be-53e1f2801616') { // Binding Elements

       if (!$name || $name == 'New CI Name'){
          $name = $_POST['bindable_element'];
          if (!$name){
             $name = $_GET['bindable_element'];
             }
          }

       #echo "Bindable_element: "$name."<P>";
/*
        if ($name){

           $bound_element_returner = $funky_gear->object_returner ("ConfigurationItems", $name);
           $bound_element_name = $bound_element_returner[0];
           $be_pack[$name] = $bound_element_name;

           }
*/
       # Use this in the CIT to limit to only this type
       $cit_exception = " && id='".$ci_type_id."' ";

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Binding Element"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitems'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "id='".$name."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $granpar_ci = $_POST['granpar_ci'];
       if (!$granpar_ci){
          $granpar_ci = $_GET['granpar_ci'];
          }

       if ($granpar_ci){

          $tblcnt++;

          $tablefields[$tblcnt][0] = 'granpar_ci'; // Field Name
          $tablefields[$tblcnt][1] = "granpar_ci"; // Full Name
          $tablefields[$tblcnt][2] = 0; // is_primary
          $tablefields[$tblcnt][3] = 0; // is_autoincrement
          $tablefields[$tblcnt][4] = 1; // is_name
          $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][6] = '70'; // length
          $tablefields[$tblcnt][7] = '0'; // NULLOK?
          $tablefields[$tblcnt][8] = ''; // default
          $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
          $tablefields[$tblcnt][10] = '';//1; // show in view 
          $tablefields[$tblcnt][11] = ""; // Field ID
          $tablefields[$tblcnt][20] = 'granpar_ci'; //$field_value_id;
          $tablefields[$tblcnt][21] = $granpar_ci; //$field_value;   

          }

       } elseif ($ci_type_id == '399a1a2c-5038-8d99-20bf-54e8c81f35a9' && $action == 'add') { # Accounts Services SLA Features

       if (!$name || $name == 'New CI Name'){
          $name = $_POST['accservsla'];
          if (!$name){
             $name = $_GET['accservsla'];
             }
          }

       $cit_exception = " && id='".$ci_type_id."' ";

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "SLA Features Wrapper"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_accountsservicesslas'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "id='".$name."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   


/*

This cause no name field to show when adding strins for filters!!

       } elseif ($par_ci_type_id == 'dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812') { // Filters

       # Use this in the CIT to limit to only this type
       $cit_exception = " && id='".$ci_type_id."' ";
*/
       } elseif ($ci_type_id == '399a1a2c-5038-8d99-20bf-54e8c81f35a9' && $action == 'edit') { # Accounts Services SLA Features

       if ($name != NULL){

          list($feature_type_id,$feature_name_id) = explode('[XXX]',$name);

          $feature_returner = $funky_gear->object_returner ("ConfigurationItems", $feature_name_id);
          $feature_name = $feature_returner[0];

          if ($feature_type_id == 'e027d211-75c9-d360-17cb-54e8577757ca'){# if colours
             # Colours

             #list($colourname,$hex) = explode('_',$feature_name);
             #$featurelink .= $enabled."Feature: ".$feature_type_name.": ".$edit." <font color=".$hex.">".$colourname."</font><BR>";

             } elseif ($feature_type_id == 'a4b786aa-5f30-2258-8226-52ad30ae0f35'){ # if OS

             #$featurelink .= $enabled."Feature: ".$feature_type_name.":  ".$edit." ".$feature_name."<BR>";

             }

          #$feature_nameparts = "".$feature_ci_type."[XXX]".$feature_ci_id."";
          $featuretype_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $feature_type_id);
          $label = $featuretype_returner[0];

          } # if name

       # Create a pack of feature ID and CIT

       $feature_object_type = "ConfigurationItems";
       $feature_action = "select";
       $feature_params[0] = " sclm_configurationitemtypes_id_c IN ('".implode($features,"', '")."') && sclm_configurationitemtypes_id_c='".$feature_type_id."' ";
       $feature_params[1] = " id,name,sclm_configurationitemtypes_id_c "; // select array
       $feature_params[2] = ""; // group;
       $feature_params[3] = " sclm_configurationitemtypes_id_c,name "; // order;
       $feature_params[4] = ""; // limit
  
       $feature_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $feature_object_type, $feature_action, $feature_params);

       if (is_array($feature_items)){

          for ($feature_cnt=0;$feature_cnt < count($feature_items);$feature_cnt++){

              $feature_ci_id = $feature_items[$feature_cnt]['id'];
              $feature_ci_name = $feature_items[$feature_cnt]['name'];
              $feature_ci_type = $feature_items[$feature_cnt]['sclm_configurationitemtypes_id_c'];
              $feature_nameparts = "".$feature_ci_type."[XXX]".$feature_ci_id."";
              #$feature_returner = $funky_gear->object_returner ("ConfigurationItems", $feature_ci_name);
              #$feature_name = $feature_returner[0];
              #$show_feature_nameparts = $feature_type_name.": ".$feature_ci_name;
              $show_feature_nameparts = $feature_ci_name;
              #list($colourname,$hex) = explode('_',$feature_name);
              $ddpack[$feature_nameparts]=$show_feature_nameparts;

              } # for

          } # is array

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $label; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $ddpack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       # Change to SLA wrapper
       $ci_type_id = '399a1a2c-5038-8d99-20bf-54e8c81f35a9';
       $cit_exception = " && id='".$ci_type_id."' ";
       #echo "par_ci_type: $par_ci_type <BR>";


       } elseif (in_array($ci_type_id, $features) && $sendiv =='FEATURES'){
       
       $featuretype_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $ci_type_id);
       $label = $featuretype_returner[0];

       # Create a pack of feature ID and CIT

       $feature_object_type = "ConfigurationItems";
       $feature_action = "select";
       $feature_params[0] = " sclm_configurationitemtypes_id_c IN ('".implode($features,"', '")."') && sclm_configurationitemtypes_id_c='".$ci_type_id."' ";
       $feature_params[1] = " id,name,sclm_configurationitemtypes_id_c "; // select array
       $feature_params[2] = ""; // group;
       $feature_params[3] = " sclm_configurationitemtypes_id_c,name "; // order;
       $feature_params[4] = ""; // limit
  
       $feature_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $feature_object_type, $feature_action, $feature_params);

       if (is_array($feature_items)){

          for ($feature_cnt=0;$feature_cnt < count($feature_items);$feature_cnt++){

              $feature_ci_id = $feature_items[$feature_cnt]['id'];
              $feature_ci_name = $feature_items[$feature_cnt]['name'];
              $feature_ci_type = $feature_items[$feature_cnt]['sclm_configurationitemtypes_id_c'];
              $feature_nameparts = "".$feature_ci_type."[XXX]".$feature_ci_id."";
              #$feature_returner = $funky_gear->object_returner ("ConfigurationItems", $feature_ci_name);
              #$feature_name = $feature_returner[0];
              #$show_feature_nameparts = $feature_type_name.": ".$feature_ci_name;
              $show_feature_nameparts = $feature_ci_name;
              #list($colourname,$hex) = explode('_',$feature_name);
              $ddpack[$feature_nameparts]=$show_feature_nameparts;

              } # for

          } # is array

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $label; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $ddpack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       # Change to SLA wrapper
       $ci_type_id = '399a1a2c-5038-8d99-20bf-54e8c81f35a9';
       $cit_exception = " && id='".$ci_type_id."' ";
       #echo "par_ci_type: $par_ci_type <BR>";

       } elseif (in_array($ci_type_id, $via_array)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "VIA Strength"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();

       $dd_pack[1]=1;
       $dd_pack[2]=2;
       $dd_pack[3]=3;
       $dd_pack[4]=4;
       $dd_pack[5]=5;
       $dd_pack[6]=6;
       $dd_pack[7]=7;
       $dd_pack[8]=8;
       $dd_pack[9]=9;
       $dd_pack[10]=10;
       $dd_pack[11]=11;
       $dd_pack[12]=12;
       $dd_pack[13]=13;
       $dd_pack[14]=14;
       $dd_pack[15]=15;
       $dd_pack[16]=16;
       $dd_pack[17]=17;
       $dd_pack[18]=18;
       $dd_pack[19]=19;
       $dd_pack[20]=20;
       $dd_pack[21]=21;
       $dd_pack[22]=22;
       $dd_pack[23]=23;
       $dd_pack[24]=24;

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } elseif (in_array($ci_type_id, $pesh_array)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Capital Level"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();

       $dd_pack[0]=0;
       $dd_pack[1]=1;
       $dd_pack[2]=2;
       $dd_pack[3]=3;
       $dd_pack[4]=4;
       $dd_pack[5]=5;
       $dd_pack[6]=6;
       $dd_pack[7]=7;
       $dd_pack[8]=8;
       $dd_pack[9]=9;
       $dd_pack[10]=10;

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } elseif (in_array($ci_type_id, $leadership_array)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Leadership Level"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();

       $dd_pack[0]=0;
       $dd_pack[1]=1;
       $dd_pack[2]=2;
       $dd_pack[3]=3;
       $dd_pack[4]=4;
       $dd_pack[5]=5;
       $dd_pack[6]=6;
       $dd_pack[7]=7;
       $dd_pack[8]=8;
       $dd_pack[9]=9;
       $dd_pack[10]=10;

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } elseif (in_array($ci_type_id, $ai_array)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "AI Level"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();

       $dd_pack[0]=0;
       $dd_pack[1]=1;
       $dd_pack[2]=2;
       $dd_pack[3]=3;
       $dd_pack[4]=4;
       $dd_pack[5]=5;
       $dd_pack[6]=6;
       $dd_pack[7]=7;
       $dd_pack[8]=8;
       $dd_pack[9]=9;
       $dd_pack[10]=10;

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } elseif (in_array($ci_type_id, $perma_array)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Level"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();

       $dd_pack[0]=0;
       $dd_pack[1]=1;
       $dd_pack[2]=2;
       $dd_pack[3]=3;
       $dd_pack[4]=4;
       $dd_pack[5]=5;
       $dd_pack[6]=6;
       $dd_pack[7]=7;
       $dd_pack[8]=8;
       $dd_pack[9]=9;
       $dd_pack[10]=10;

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } elseif (in_array($ci_type_id, $cloudsultancy_array)){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Cloudsultancy Level"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default

       $dd_pack = "";
       $dd_pack = array();

       $dd_pack[-10]=-10;
       $dd_pack[-9]=-9;
       $dd_pack[-8]=-8;
       $dd_pack[-7]=-7;
       $dd_pack[-6]=-6;
       $dd_pack[-5]=-5;
       $dd_pack[-4]=-4;
       $dd_pack[-3]=-3;
       $dd_pack[-2]=-2;
       $dd_pack[-1]=-1;
       $dd_pack[0]=0;
       $dd_pack[1]=1;
       $dd_pack[2]=2;
       $dd_pack[3]=3;
       $dd_pack[4]=4;
       $dd_pack[5]=5;
       $dd_pack[6]=6;
       $dd_pack[7]=7;
       $dd_pack[8]=8;
       $dd_pack[9]=9;
       $dd_pack[10]=10;

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } elseif (in_array($ci_type_id, $infracerts_array)){

       # 

       $infra_cit = 'cb0c2f17-2e39-9eae-dae1-5579c42ad70c';
       $infra_network = 'bb129d1f-97d0-4e34-ec15-557a324fafaa';
       $infra_dc = '745ec33b-00d8-ab25-e346-557a32217132';
       $infra_hosting = 'd9a1644a-5257-f0cc-1bcc-557a33a16b8a';
       $infra_hardware = '252f5955-ae3b-f057-efb0-557a3404c565';
       $infra_cpu = 'e6b8cb44-9140-c74d-fbff-557a344eb57c';
       $infra_storage = '484ddba9-c5b6-a551-326f-557a34d6610d';
       $infra_os = 'dfd0c0ee-f03f-d481-7777-557a35b5781a';
       $infra_vz = 'cdaf24fc-e485-0ed9-8eef-557a350f0f3c';
       $infra_db = '62f5d3ed-3494-e4a9-d7e8-557a353d91b7';
       $infra_app = '978fc3bc-c757-b88e-b01f-557a36ffe5da';

       # Must find services that align with these infracert categories
       # Sghould be built based on actual requested services via SLARequests

       switch ($ci_type_id){

        case $infra_cit:

         # Infracerts Services
         $service_type_query = "service_type='2f0e3788-e000-f34c-f639-557cecdf0a2d'";

        break;
        case $infra_network:

         # Network Services
         $service_type_query = "parent_service_type='19658e5c-4a81-04f5-99c7-557cdc313aba'";

        break;
        case $infra_dc:

         # DC Services
         $service_type_query = "parent_service_type='d4416d55-54c3-94a1-18b4-54e60964383e'"; # DC

        break;
        case $infra_hosting:

         # Hosting Services
         $service_type_query = "parent_service_type='69777dc3-4eca-6bc3-0cbf-557ce1bc1881' || parent_service_type='ae6dcff8-235c-9891-70ec-51d18458f9e9'"; #

        break;
        case $infra_hardware:

         # HW Services
         $service_type_query = "service_type='32c7135d-1eec-3490-6f13-54e608ced4f2'"; # Data Center Rack Units 

        break;
        case $infra_cpu:

         # CPU
         $service_type_query = "service_type='f0bf8662-badb-df4c-f4d5-557cdc07d8fe'"; # Product Type

        break;
        case $infra_storage:

         # Storage Services
         $service_type_query = "service_type='b32b99d0-ec60-6a59-c6d1-52234fb293a7'";

        break;
        case $infra_os:

         # OS Services
         $service_type_query = "parent_service_type='ce9f91e6-b8fe-d5c7-9d5d-557cd9d87d90'";
         #$service_type_query = "service_type="6d96fb4c-9ef0-27b8-0306-557cd9e87fdd' || service_type='67c433b5-1153-efb2-b416-557cda0a69ea' || service_type='b615493f-a12a-50ec-40e2-557cdaec7f3a' || service_type='117b6632-e311-2da3-4a96-557cdae7fcf2'";

        break;
        case $infra_vz:

         # Virtualisation Services
         $service_type_query = "parent_service_type='d3fcb956-7244-8584-6342-557cdb526580'";

        break;
        case $infra_db:

         # DB Services
         $service_type_query = "service_type='26c638b0-ff0e-a524-da32-557cd81335b9'";

        break;
        case $infra_app:

         # Apps Services
         $service_type_query = "service_type='4b546ab1-cac7-08c6-e303-523680332bfd'"; # SaaS

        break;

       } # end switch

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = "Service"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table

       # Services have the categories

       $dd_pack = "";
       $dd_pack = array();

       $services_object_type = "Services";
       $services_action = "select";
       $services_params[0] = $service_type_query;
       $services_params[1] = "id"; // select array
       $services_params[2] = ""; // group;
       $services_params[3] = " name ASC "; // order;
       $services_params[4] = ""; // limit
       $services = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $services_object_type, $services_action, $services_params);

       if (is_array($services)){

          for ($servcnt=0;$servcnt < count($services);$servcnt++){

              $services_id = $services[$servcnt]['id'];
              # Collect any AccounsServices that are based on this Service

              $acc_services_object_type = "AccountsServices";
              $acc_services_action = "select";
              $acc_services_params[0] = "sclm_services_id_c='".$services_id."'";
              $acc_services_params[1] = "id,name"; // select array
              $acc_services_params[2] = ""; // group;
              $acc_services_params[3] = " name ASC "; // order;
              $acc_services_params[4] = ""; // limit
              $acc_services = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $acc_services_object_type, $acc_services_action, $acc_services_params);

              if (is_array($acc_services)){

                 for ($accservcnt=0;$accservcnt < count($acc_services);$accservcnt++){

                     $acc_services_id = $acc_services[$accservcnt]['id'];
                     $acc_services_name = $acc_services[$accservcnt]['name'];
 
                     $dd_pack[$acc_services_id] = $acc_services_name;

                     } # for accountsservices

                 } # is accountsservices array

              } # for services

          } # is services array

       $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = $dd_pack; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = "";//$exception;
       $tablefields[$tblcnt][9][5] = $name; // Current Value
       $tablefields[$tblcnt][9][9] = $name; // Current Value
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       $cit_exception = " && id='".$ci_type_id."' ";

       } else {

       # If no dynamic fields or CITs in the name field
       # Finally if nothing special - show normal field

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'name'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Name"]." *"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 1; // is_name
       $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '70'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'name'; //$field_value_id;
       $tablefields[$tblcnt][21] = $name; //$field_value;   

       } // end if ct_type_id

    # End name field
    ####################################

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'cmn_statuses_id_c'; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]." *"; // Full Name
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
    $tablefields[$tblcnt][9][3] = 'name';
    $tablefields[$tblcnt][9][4] = "";//$exception;
    $tablefields[$tblcnt][9][5] = $cmn_statuses_id_c; // Current Value
    $tablefields[$tblcnt][9][6] = '';
    #$tablefields[$tblcnt][9][7] = "cmn_statuses"; // list reltablename
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = 'cmn_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmn_statuses_id_c; //$field_value;
    $tablefields[$tblcnt][41] = "0"; // flipfields - label/fieldvalue

    $tblcnt++;

    if ($image_url == NULL && $ci_type_id != NULL){
       $image_returner = $funky_gear->object_returner ("ConfigurationItemTypes", $ci_type_id);
       $image_url = $image_returner[7];
       }

    if ($action == 'view' && $image_url != NULL){

       $tablefields[$tblcnt][0] = "image_url"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'image';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "image_url"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image_url; //$field_value;   

       } elseif ($show_fields || $auth==3) {

       $tablefields[$tblcnt][0] = "image_url"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Image"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "varchar";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = '0'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = "1";//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = "image_url"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image_url; //$field_value;   

       } else {

       $tablefields[$tblcnt][0] = "image_url"; // Field Name
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
       $tablefields[$tblcnt][20] = "image_url"; //$field_value_id;
       $tablefields[$tblcnt][21] = $image_url; //$field_value;   

       }

    ####################################
    # CIT Dropdown

    if ($par_ci_type_id == 'dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812') { // Filters
       # Use this in the CIT to limit to only this type
       $cit_exception = " && id='".$ci_type_id."' ";
       $par_ci_type = "";
       } elseif (in_array($par_ci_type_id,$infra_array)){
       $par_ci_type = "";
       #$cit_exception = " && sclm_configurationitemtypes_id_c='".$ci_type_id."' ";
       $cit_exception = " && id='".$ci_type_id."' ";
       }

     #Navigation
    if ($ci_type_id == "ad1d9ad1-0a25-0e49-3c18-54eb24956766"){
       $cit_exception = " && id='".$ci_type_id."' ";
       }

    $tblcnt++;

    if ($action == 'add' || $action == 'edit' || $auth == 3){

       $tablefields[$tblcnt][0] = 'sclm_configurationitemtypes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ConfigurationItemType"]." *"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name

       if ($auth == 3){
          #$tablefields[$tblcnt][5] = 'dropdown_jaxer';//$field_type; //'INT'; // type
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          } else {
          $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
          } 

       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($auth == 3){
          $tablefields[$tblcnt][9][4] = " deleted=0 ".$par_ci_type." ".$cit_exception." ORDER BY name ASC ";//$exception;
          } else {
          #$tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$account_id_c."' ";//$exception;
          #$tablefields[$tblcnt][9][4] = " deleted=0 && cmn_statuses_id_c != '".$standard_statuses_closed."' ".$par_ci_type." ".$cit_exception." ORDER BY name ASC ";//$exception;
          #$tablefields[$tblcnt][9][4] = " deleted=0 && (cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$sess_account_id."') ".$par_ci_type." ".$cit_exception." ORDER BY name ASC ";//$exception;
          $tablefields[$tblcnt][9][4] = " deleted=0 ".$par_ci_type." ".$cit_exception." ORDER BY name ASC ";//$exception;

          #echo "Query  deleted=0 ".$par_ci_type." ".$cit_exception." ORDER BY name ASC  <BR>";

          }

       #echo "params: ".$tablefields[$tblcnt][9][4]."<BR>";

       $tablefields[$tblcnt][9][5] = $ci_type_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItemTypes';
       $tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ConfigurationItemTypes'; //new do
       $tablefields[$tblcnt][9][9] = $ci_type_id; // Current Value
       $params['ci_data_type'] = $ci_data_type;
       $params['ci_name_field'] = "name";
       $params['ci_name'] = $name;
       $tablefields[$tblcnt][9][10] = $params; // Various Params
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_configurationitemtypes_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_type_id; //$field_value;

       } else {

       $tablefields[$tblcnt][0] = 'sclm_configurationitemtypes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ConfigurationItemType"]." *"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_configurationitemtypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';

       if ($auth == 3){
          $tablefields[$tblcnt][9][4] = "";//$exception;
          } else {
          #$tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' || account_id_c='".$account_id_c."' ";//$exception;
          $tablefields[$tblcnt][9][4] = " cmn_statuses_id_c != '".$standard_statuses_closed."' ORDER BY name ASC ";//$exception;
          }

       $tablefields[$tblcnt][9][5] = $ci_type_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConfigurationItemTypes';

       #$tablefields[$tblcnt][9][7] = "sclm_configurationitemtypes"; // list reltablename
       #$tablefields[$tblcnt][9][8] = 'ConfigurationItemTypes'; //new do
       #$tablefields[$tblcnt][9][9] = $ci_type_id; // Current Value
       #$params['ci_data_type'] = $ci_data_type;
       #$params['ci_name'] = $name;
       #$tablefields[$tblcnt][9][10] = $params; // Various Params

       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_configurationitemtypes_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_type_id; //$field_value;

       } // end if ($action == 'add' || $action == 'edit' || $auth == 3){
   
    $tblcnt++;

    if ($show_fields || $auth==3){

       $tablefields[$tblcnt][0] = 'opportunity_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Opportunity"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "dropdown";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'opportunities,opportunities_cstm'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = " opportunities.id=opportunities_cstm.id_c && opportunities_cstm.account_id_c='".$ci_account_id_c."' ORDER BY name ASC ";//$exception;
       $tablefields[$tblcnt][9][5] = $opportunity_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Opportunities';
       $tablefields[$tblcnt][9][7] = "opportunities"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Opportunities'; //new do
       $tablefields[$tblcnt][9][9] = $opportunity_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'opportunity_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $opportunity_id_c; //$field_value;

       } else {

       $tablefields[$tblcnt][0] = "opportunity_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "opportunity_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $opportunity_id_c; //$field_value;   

       }

    $tblcnt++;

    if ($show_fields || $auth==3){

       $tablefields[$tblcnt][0] = 'project_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Project"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "dropdown";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'project,project_cstm'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = " project.id=project_cstm.id_c && project_cstm.account_id_c='".$ci_account_id_c."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $project_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Projects';
       $tablefields[$tblcnt][9][7] = "project"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'Projects'; //new do
       $tablefields[$tblcnt][9][9] = $project_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'project_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $project_id_c; //$field_value;

       } else {

       $tablefields[$tblcnt][0] = "project_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "project_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $project_id_c; //$field_value;   

       }

    $tblcnt++;

    if ($show_fields || $auth==3){

       $tablefields[$tblcnt][0] = 'projecttask_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ProjectTask"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "dropdown";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'project_task,project_task_cstm'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = " project_task.id=project_task_cstm.id_c && project_task_cstm.account_id_c='".$ci_account_id_c."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $projecttask_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ProjectTasks';
       $tablefields[$tblcnt][9][7] = "project_task"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'ProjectTasks'; //new do
       $tablefields[$tblcnt][9][9] = $projecttask_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'projecttask_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $projecttask_id_c; //$field_value;

       } else {

       $tablefields[$tblcnt][0] = "projecttask_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "projecttask_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $projecttask_id_c; //$field_value;   

       }

    $tblcnt++;

    if ($show_fields || $auth==3){

       $tablefields[$tblcnt][0] = 'sclm_sow_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["SOW"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "dropdown";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_sow'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = " account_id_c='".$ci_account_id_c."' ";//$exception;
       $tablefields[$tblcnt][9][5] = $sclm_sow_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'SOW';
       $tablefields[$tblcnt][9][7] = "sclm_sow"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'SOW'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_sow_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_sow_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_sow_id_c; //$field_value;

       } else {

       $tablefields[$tblcnt][0] = "sclm_sow_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "sclm_sow_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_sow_id_c; //$field_value;   

       }

    $tblcnt++;

    if ($show_fields || $auth==3){

       $tablefields[$tblcnt][0] = 'sclm_sowitems_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["SOWItem"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = "dropdown";//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
   
       if ($action == 'add' || $action == 'edit'){

          $ddpack = "";

          $tablefields[$tblcnt][9][0] = 'list'; // dropdown type (DB Table, Array List, Other)

          $sowparitems_object_type = "SOWItems";
          $sowparitems_action = "select";

          if ($sclm_sow_id_c != NULL){
             $sowparitems_params[0] = " sclm_sowitems_id_c='' && account_id_c='".$ci_account_id_c."' && sclm_sow_id_c='".$sclm_sow_id_c."' ";
             } else {
             $sowparitems_params[0] = " sclm_sowitems_id_c='' && account_id_c='".$ci_account_id_c."' ";
             }

          $sowparitems_params[1] = "id,item_number,name"; // select array
          $sowparitems_params[2] = ""; // group;
          $sowparitems_params[3] = "item_number,name ASC"; // order;
          $sowparitems_params[4] = ""; // limit
  
          $sowpar_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sowparitems_object_type, $sowparitems_action, $sowparitems_params);

          if (is_array($sowpar_items)){

             for ($sowpar_cnt=0;$sowpar_cnt < count($sowpar_items);$sowpar_cnt++){

                 $sow_parent_id = $sowpar_items[$sowpar_cnt]['id'];
                 $sow_parent_name = "#".$sowpar_items[$sowpar_cnt]['item_number'].": ".$sowpar_items[$sowpar_cnt]['name'];              
                 $sowitems_object_type = "SOWItems";
                 $sowitems_action = "select";
                 $sowitems_params[0] = " sclm_sowitems_id_c='".$sow_parent_id."' ";
                 $sowitems_params[1] = "id,item_number,name"; // select array
                 $sowitems_params[2] = ""; // group;
                 $sowitems_params[3] = "item_number,name ASC"; // order;
                 $sowitems_params[4] = ""; // limit

                 $sow_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $sowitems_object_type, $sowitems_action, $sowitems_params);

                 if (is_array($sow_items)){

                    for ($sow_cnt=0;$sow_cnt < count($sow_items);$sow_cnt++){

                        $sow_id = $sow_items[$sow_cnt]['id'];
                        $sow_name = $sow_parent_name." -> #".$sow_items[$sow_cnt]['item_number'].": ".$sow_items[$sow_cnt]['name'];
                        $ddpack[$sow_id]=$sow_name;

                        } // for
   
                    } // if 

                 } // for

             } // if array

          $tablefields[$tblcnt][9][1] = $ddpack; // If DB, dropdown_table, if List, then array, other related table

          } else {// action

          // view
          $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
          $tablefields[$tblcnt][9][1] = 'sclm_sowitems'; // If DB, dropdown_table, if List, then array, other related table

          if ($sclm_sow_id_c != NULL){
             $tablefields[$tblcnt][9][4] = " account_id_c='".$ci_account_id_c."' && sclm_sow_id_c='".$sclm_sow_id_c."' ";
             } else {
             $tablefields[$tblcnt][9][4] = " account_id_c='".$ci_account_id_c."' ";
             }

          } // action

       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][5] = $sclm_sowitems_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'SOWItems';
       $tablefields[$tblcnt][9][7] = "sclm_sowitems"; // list reltablename
       $tablefields[$tblcnt][9][8] = 'SOWItems'; //new do
       $tablefields[$tblcnt][9][9] = $sclm_sowitems_id_c; // Current Value
       $tablefields[$tblcnt][10] = "1";//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'sclm_sowitems_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_sowitems_id_c; //$field_value;

       } else {

       $tablefields[$tblcnt][0] = "sclm_sowitems_id_c"; // Field Name
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
       $tablefields[$tblcnt][20] = "sclm_sowitems_id_c"; //$field_value_id;
       $tablefields[$tblcnt][21] = $sclm_sowitems_id_c; //$field_value;   

       }


    if (($action == 'view' || $auth == 3) && $show_details){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'child_id'; // Field Name
       $tablefields[$tblcnt][1] = "Child System"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sclm_scalasticachildren'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $child_id; // Current Value
       $tablefields[$tblcnt][9][6] = 'ScalasticaChildren';
       $tablefields[$tblcnt][10] = 1;//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'child_id';//$field_value_id;
       $tablefields[$tblcnt][21] = $child_id; //$field_value;   

       } else {

       $tblcnt++;

       $tablefields[$tblcnt][0] = "child_id"; // Field Name
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
       $tablefields[$tblcnt][20] = "child_id"; //$field_value_id;
       $tablefields[$tblcnt][21] = $child_id; //$field_value;   

       } 

    if (!$ci_account_id_c){
       if (!$sess_account_id){
          $ci_account_id_c = $account_id_c;
          } else {
          $ci_account_id_c = $sess_account_id;
          }
       }

    if ($action == 'view' || $auth == 3){

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
       $tablefields[$tblcnt][9][5] = $ci_account_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Accounts';
       $tablefields[$tblcnt][10] = 1;//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'account_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   

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
       $tablefields[$tblcnt][21] = $ci_account_id_c; //$field_value;   

       } 


    if (!$ci_contact_id_c){
       if (!$sess_contact_id){
          $ci_contact_id_c = $contact_id_c;
          } else {
          $ci_contact_id_c = $sess_contact_id;
          }
       }

    if ($action == 'view' || $auth == 3){

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
       #$tablefields[$tblcnt][9][3] = " CONCAT('first_name',' ','last_name') ";
       $tablefields[$tblcnt][9][3] = "first_name";
       $tablefields[$tblcnt][9][4] = ""; // exception
       $tablefields[$tblcnt][9][5] = $ci_contact_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Contacts';
       $tablefields[$tblcnt][10] = 1;//1; // show in view 
       $tablefields[$tblcnt][11] = ""; // Field ID
       $tablefields[$tblcnt][20] = 'contact_id_c';//$field_value_id;
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

       } else {

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
       $tablefields[$tblcnt][21] = $ci_contact_id_c; //$field_value;   

       }

    #$navi_description = $description;

    if ($show_details){

       $tblcnt++;

       $tablefields[$tblcnt][0] = "description"; // Field Name
       $tablefields[$tblcnt][1] = $strings["Description"]." *"; // Full Name
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
       $tablefields[$tblcnt][20] = "description"; //$field_value_id;
       $tablefields[$tblcnt][21] = $description; //$field_value;   

       }

    ################################
    # Loop for allowed languages

    if ($action == 'edit' && $show_details==TRUE){

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
           $tablefields[$tblcnt][5] = "varchar";//$field_type; //'INT'; // type
           $tablefields[$tblcnt][6] = '255'; // length
           $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = "1";//1; // show in view 
           $tablefields[$tblcnt][11] = $name_content; // Field ID
           $tablefields[$tblcnt][20] = $name_field;//$field_value_id;
           $tablefields[$tblcnt][21] = $name_content; //$field_value; 

           $tblcnt++;

           $tablefields[$tblcnt][0] = $desc_field; // Field Name
           $tablefields[$tblcnt][1] = $strings["Description"]." (".$language.")"; // Full Name
           $tablefields[$tblcnt][2] = 0; // is_primary
           $tablefields[$tblcnt][3] = 0; // is_autoincrement
           $tablefields[$tblcnt][4] = 0; // is_name
           $tablefields[$tblcnt][5] = "textarea";//$field_type; //'INT'; // type
           $tablefields[$tblcnt][6] = '255'; // length
           $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
           $tablefields[$tblcnt][8] = ''; // default
           $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
           $tablefields[$tblcnt][10] = "1";//1; // show in view 
           $tablefields[$tblcnt][11] = $desc_content; // Field ID
           $tablefields[$tblcnt][20] = $desc_field;//$field_value_id;
           $tablefields[$tblcnt][21] = $desc_content; //$field_value;

           } // end for languages

       } // if edit

    $valpack = "";
    $valpack[0] = $do;
    $valpack[1] = $action;
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;

    if ($auth == 3 || $sess_contact_id != NULL && $sess_contact_id==$ci_contact_id_c){
       $valpack[4] = $auth; // $auth; // user level authentication (3,2,1 = admin,client,user)
       $valpack[5] = "1"; // provide add new button
       }

    $valpack[11] = $do_scroller;

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

//    echo "<img src=images/blank.gif width=95% height=20><BR>";

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Configuration Item'; // container_title
       $container_params[4] = 'ConfigurationItem'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       $custom_navi_cit = "ad1d9ad1-0a25-0e49-3c18-54eb24956766";

       if ($object_return && $show_fields && ($ci_type_id != $custom_navi_cit || $action == 'edit')){

          echo $object_return;
          echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

          } elseif ($valtype == 'EmailFilteringSet' && ($ci_type_id != $custom_navi_cit || $action == 'edit')){

          $returner = $funky_gear->object_returner ('ConfigurationItems', $val);
          $object_return_name = $returner[0];
//          $object_return = $returner[1];
//          $object_return_title = $returner[2];
//          $object_return_target = $returner[3];
//          $object_return_params = $returner[4];
//          $object_return_completion = $returner[5];
//          $object_return_voter = $returner[6];

          echo "<P><a href=\"#\" onClick=\"loader('FILTER');doBPOSTRequest('FILTER','Body.php', 'pc=".$portalcode."&do=EmailFilteringSet&action=view&value=".$val."&valuetype=".$valtype."');return false\">View ".$object_return_name."</a><P>";
          $BodyDIV = 'FILTER';

          }

       $sendiv = $_POST['sendiv'];
       if (!$sendiv){
          $sendiv = $_GET['sendiv'];
          }

       if ($action == 'edit' && (!in_array($sendiv,$cit_array)) && (!in_array($ci_type_id,$cit_array))){ 

          echo "<center><input onclick=\"createEditor();\" type=\"button\" class=\"css3button\" value=\"".$strings["HTMLEditorShow"]."\"><input onclick=\"removeEditor();\" type=\"button\" class=\"css3button\" value=\"".$strings["HTMLEditorHide"]."\"><BR>".$strings["HTMLEditorCopyMessage"]."</center><P>";

          }

#       if ($ci_type_id != $custom_navi_cit || $action == 'add' && $action == 'edit'){
       if ($ci_type_id != $custom_navi_cit){

          echo $container_top;
          echo $added_header;
          echo "<div style=\"".$divstyle_white."\"><center><font size=3><B>".$strings["RequiredMessage"]."</B></font></center></div>";
          echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

          echo $zaform;

          echo $container_bottom;

          } elseif ($ci_type_id == $custom_navi_cit && ($action == 'add' || $action == 'edit' || ($action == 'view' && $sess_account_id == $ci_account_id_c))){
          # To show when logged in so can edit/view all components

          echo $container_top;

          echo $added_header;
          echo "<div style=\"".$divstyle_white."\"><center><font size=3><B>".$strings["RequiredMessage"]."</B></font></center></div>";
          echo "<BR><img src=images/blank.gif width=98% height=5><BR>";

          echo $zaform;

          echo $container_bottom;

          }

       if ($ci_type_id == $custom_navi_cit && $action == 'view'){

          $desc_length = strlen($navi_description);
          $desc_length_strip = strlen(strip_tags($navi_description));

          if ($desc_length != $desc_length_strip){
             # IS change from stripping tags
             if ($navi_description == str_replace("<br>", "", $navi_description)){
                # no breaks;
                $navi_description = str_replace("</br>", "", $navi_description);
                #$navi_description = str_replace("\n", "<br>", $navi_description);
                }

             if ($navi_description != str_replace("<p>", "", $navi_description)){

                $srv_part_start = "<p style";
                $srv_part_end = "</p>";

                $startcheck = "";
                $endcheck = "";
                $startcheck = "";
                $endcheck = "";
                $startcheck = $funky_gear->replacer($srv_part_start, "", $navi_description);
                $endcheck = $funky_gear->replacer($srv_part_end, "", $navi_description);

                if ($startcheck == $navi_description || $endcheck == $navi_description){
                   # Do nothing - they don't exist
                   } else {
                   $startsAt = strpos($navi_description, $srv_part_start) + strlen($srv_part_start);
                   $endsAt = strpos($navi_description, $srv_part_end, $startsAt);
                   $inner_content = substr($navi_description, $startsAt, $endsAt - $startsAt);
                   $navi_description = str_replace($inner_content, "ZAZAZAZAZAZAZAZAZA", $navi_description);
                   $navi_description = str_replace("<p>", "", $navi_description);
                   $navi_description = str_replace("</p>", "", $navi_description);
                   $inner_content = "<p style".$inner_content."</p>";
                   $navi_description = str_replace("ZAZAZAZAZAZAZAZAZA", $inner_content, $navi_description);
                   } 

                } # if 

             } else {
             # No change - check for line breaks
             $navi_description = str_replace("\n", "<br>", $navi_description);
             }

          # Replaces all links with blank target!
          $navi_description = preg_replace('|<a (.+?)>|i', '<a $1 target="_blank">', $navi_description);

          #$navi_description = preg_replace('|<img src(.+?)>|i', '<a $1 data-lightbox=CI title=\"".$name."\"><img src$1 target="_blank">', $navi_description);

          #echo "<center><a href='".$image."' data-lightbox=\"".$valtype."\" title=\"".$name."\"><img src='".$image."'></a></center>";

          $container = "";  
          $container_top = "";
          $container_middle = "";
          $container_bottom = "";

          $container_params[0] = 'open'; // container open state
          $container_params[1] = $bodywidth; // container_width
          $container_params[2] = $bodyheight; // container_height
          $container_params[3] = $navi_name; // container_title
          $container_params[4] = 'Navigation'; // container_label
          $container_params[5] = $portal_info; // portal info
          $container_params[6] = $portal_config; // portal configs
          $container_params[7] = $strings; // portal configs
          $container_params[8] = $lingo; // portal configs

          $container = $funky_gear->make_container ($container_params);

          $container_top = $container[0];
          $container_middle = $container[1];
          $container_bottom = $container[2];

          echo $container_top;

          #echo "<div style=\"".$formtitle_divstyle_grey."\"><center><font size=3><B>".$navi_name."</B></font></center></div>";
          #echo "<div style=\"".$divstyle_white."\">".$navi_description."</div>";
          echo $navi_description;

          echo $container_bottom;

          } # end if navi show


       if ($ci_type_id == $custom_navi_cit && $action == 'edit'){

          ###################
          #

          $container_params[0] = 'open'; // container open state
          $container_params[1] = $bodywidth; // container_width
          $container_params[2] = $bodyheight; // container_height
          $container_params[3] = $strings["Content"]; // container_title
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
   
          $this->funkydone ($_POST,$lingo,'Content','list',$val,$do,$bodywidth);       

          echo $container_bottom;

          } # end if navi show

    if (($action == 'view' || $action == 'edit') && ((($ci_type_id != $custom_navi_cit) && $show_fields) || $auth==3)){

       ###################################################
       # For sub-pages? 

       $container = "";  
       $container_top = "";
       $container_middle = "";
       $container_bottom = "";

       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = $strings["RelatedConfigurationItems"]; // container_title
       $container_params[4] = 'RelatedItems'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       $container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_top;

       $this->funkydone ($_POST,$lingo,"ConfigurationItems",'list',$val,"ConfigurationItems",$bodywidth);

/*
       $container_params[0] = 'open'; // container open state
       $container_params[1] = $bodywidth; // container_width
       $container_params[2] = $bodyheight; // container_height
       $container_params[3] = 'Associated Services'; // container_title
       $container_params[4] = 'AssociatedServices'; // container_label
       $container_params[5] = $portal_info; // portal info
       $container_params[6] = $portal_config; // portal configs
       $container_params[7] = $strings; // portal configs
       $container_params[8] = $lingo; // portal configs

       $container = $funky_gear->make_container ($container_params);

       //$container_top = $container[0];
       $container_middle = $container[1];
       $container_bottom = $container[2];

       echo $container_middle;

       $this->funkydone ($_POST,$lingo,'Services','list',$val,$do,$bodywidth);
*/
       echo $container_bottom;

       # End
       ###################################################

       } elseif ($ci_type_id != $custom_navi_cit && $action == 'view') {

       echo $container_bottom;

       }

   break; // end view
   case 'process':

    if (!$sent_assigned_user_id){
       $sent_assigned_user_id = 1;
       }

    if ($_POST['sclm_configurationitemtypes_id_c']=='1078abaa-0615-06ef-9826-52b0d6f32290' || $_POST['sclm_configurationitemtypes_id_c']=='99490a5c-8f51-6652-a121-52bfac638c32'){
       // Create Ticket/Email
       if ($_POST['name']==NULL){
          $name = 0;
          }

       }

    if ($_POST['start_time'] && $_POST['end_time']){
       $name = $_POST['start_time']."_".$_POST['end_time'];
       }

    if (!$name){
       if ($_POST['name']==NULL){
          $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Name"]."</font><P>";
          } else {
          $name = $_POST['name'];
          } 
       }

    if (!$_POST['description']){
       $description = $name;
//       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"].$strings["Description"]."</font><P>";
       } else {
       $description = $_POST['description']; 
       }

    if (!$_POST['sclm_configurationitemtypes_id_c']){
       $error .= "<font color=red size=3>".$strings["SubmissionErrorEmptyItem"]."Configuration Item Type</font><P>";
       }   

    if (!$error){

       $process_object_type = $do;
       $process_action = "update";

       $process_params = array();  
       $process_params[] = array('name'=>'id','value' => $_POST['id']);
       $process_params[] = array('name'=>'name','value' => $name);
       $process_params[] = array('name'=>'assigned_user_id','value' => $_POST['assigned_user_id']);
       $process_params[] = array('name'=>'description','value' => $description);
       $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
       $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
       $process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
       $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $_POST['sclm_configurationitemtypes_id_c']);
       $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $_POST['sclm_configurationitems_id_c']);
       $process_params[] = array('name'=>'image_url','value' => $_POST['image_url']);
       $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
       $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
       $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
       $process_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
       $process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
       $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
       $process_params[] = array('name'=>'enabled','value' => $_POST['enabled']);

       foreach ($_POST as $name_key=>$name_value){

               $name_lingo = str_replace("name_","",$name_key);

               if ($name_lingo != NULL && in_array($name_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$name_key,'value' => $name_value);

                  } // if namelingo

               } // end foreach

       foreach ($_POST as $desc_key=>$desc_value){

               $desc_lingo = str_replace("description_","",$desc_key);

               if ($desc_lingo != NULL && in_array($desc_lingo,$_SESSION['lingobits'])){

                  $process_params[] = array('name'=>$desc_key,'value' => $desc_value);

                  } // if namelingo

               } // end foreach

       #var_dump($process_params);
       #exit;

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

       if ($result['id'] != NULL){
          $val = $result['id'];
          }

       #################
       # Auto-add any related CIs
       
       if (!$_POST['id'] && $result['id'] != NULL){
          # No ID = add = first time

          switch ($_POST['sclm_configurationitemtypes_id_c']){
          # Switch based on CITs

           case '3172f9e9-3915-b709-fc58-52b38864eaf6':

            # RelatedAccountSharing -> capture name = AccountRelationships ID
            $acc_rel_id = $name;
            # Get child ID to add from id

            $ci_object_type = "AccountRelationships";
            $ci_params[0] = " id='".$acc_rel_id."' ";
            $ci_action = "select";
            $ci_params[1] = "id,name,date_entered,account_id_c,account_id1_c,entity_type"; // select array
            $ci_params[2] = ""; // group;
            $ci_params[3] = " name, date_entered DESC "; // order;
            $ci_params[4] = ""; // limit
  
            $ci_items = api_sugar ($crm_api_user, $crm_api_pass, $crm_wsdl_url, $ci_object_type, $ci_action, $ci_params);

            if (is_array($ci_items)){    

               for ($cnt=0;$cnt < count($ci_items);$cnt++){

                   $id = $ci_items[$cnt]['id'];
                   $name = $ci_items[$cnt]['name'];
                   $parent_account_id = $ci_items[$cnt]['parent_account_id'];
                   $child_account_id = $ci_items[$cnt]['child_account_id'];
                   $entity_type = $ci_items[$cnt]['entity_type'];

                   if ($child_account_id){

                      $shared_account_cit = '8ff4c847-2c82-9789-f085-52b3897c8bf6';

                      $process_object_type = $do;
                      $process_action = "update";

                      $process_params = "";
                      $process_params = array();  
                      #$process_params[] = array('name'=>'id','value' => );
                      $process_params[] = array('name'=>'name','value' => $child_account_id); # CI name for child
                      $process_params[] = array('name'=>'assigned_user_id','value' => $assigned_user_id);
                      $process_params[] = array('name'=>'description','value' => $description);
                      $process_params[] = array('name'=>'account_id_c','value' => $_POST['account_id_c']);
                      $process_params[] = array('name'=>'contact_id_c','value' => $_POST['contact_id_c']);
                      #$process_params[] = array('name'=>'sclm_scalasticachildren_id_c','value' => $_POST['child_id']);
                      $process_params[] = array('name'=>'sclm_configurationitemtypes_id_c','value' => $shared_account_cit);
                      $process_params[] = array('name'=>'sclm_configurationitems_id_c','value' => $result['id']); # Becomes Parent CI
                      $process_params[] = array('name'=>'image_url','value' => $_POST['image_url']);
                      $process_params[] = array('name'=>'cmn_statuses_id_c','value' => $_POST['cmn_statuses_id_c']);
                      $process_params[] = array('name'=>'project_id_c','value' => $_POST['project_id_c']);
                      $process_params[] = array('name'=>'projecttask_id_c','value' => $_POST['projecttask_id_c']);
                      $process_params[] = array('name'=>'opportunity_id_c','value' => $_POST['opportunity_id_c']);
                      $process_params[] = array('name'=>'sclm_sow_id_c','value' => $_POST['sclm_sow_id_c']);
                      $process_params[] = array('name'=>'sclm_sowitems_id_c','value' => $_POST['sclm_sowitems_id_c']);
                      $process_params[] = array('name'=>'enabled','value' => $_POST['enabled']);
                      
                      $subci_result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $process_object_type, $process_action, $process_params);

                      if ($subci_result['id'] != NULL){
                         $subci_val = $subci_result['id'];
                         }

                      # Need to change for build link..
                      $_POST['sclm_configurationitems_id_c'] = '3172f9e9-3915-b709-fc58-52b38864eaf6';

                      } # If child exists

                   } # For

               } # end if is array

           break;

          } # end switch

          } # end if adding

       # End auto-add any related CIs
       #################
       # Add any div build links

       if ($_POST['sendiv'] == 'lightform'){
          echo "<center><a href=\"#\" onClick=\"cleardiv('lightform');cleardiv('fade');document.getElementById('lightform').style.display='none';document.getElementById('fade').style.display='none';\"><font size=2 color=BLUE><B>[".$strings["Close"]."]</B></font></a></center>";
          }

       if ($_POST['sendiv']){
          $BodyDIV = $_POST['sendiv'];
          $sclm_configurationitems_id_c = $_POST['sclm_configurationitems_id_c'];

          switch ($BodyDIV){

           case 'CIS':

            $addbuild = " | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=build&value=".$sclm_configurationitems_id_c."&valuetype=RelatedAccountSharing&sendiv=".$BodyDIV."');return false\"><font size=2 color=blue><B>".$strings["Build"]."</B></font></a><P>";

           break; // end infra
           case 'INFRA':

            $addbuild = " | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=build&value=".$sclm_configurationitems_id_c."&valuetype=InfrastructureMaintenance&sendiv=".$BodyDIV."');return false\"><font size=2 color=blue><B>".$strings["Build"]."</B></font></a><P>";

           break; // end infra
           case 'FILTER':
   
            if ($_POST['sclm_configurationitemtypes_id_c'] == 'dbcb0dbb-c3b8-8edb-1bd6-52b8e31ff812'){
               # Not a component, but a filter..
               $sclm_configurationitems_id_c = $val;
               }

            $granpar_ci = $_POST['granpar_ci'];
            if (!$granpar_ci){
               $granpar_ci = $_GET['granpar_ci'];
               }

            if ($granpar_ci){
               $sclm_configurationitems_id_c = $granpar_ci;
               }

            $addbuild = " | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=ConfigurationItemSets&action=build&value=".$sclm_configurationitems_id_c."&valuetype=EmailFilteringSet&sendiv=".$BodyDIV."');return false\"><font size=2 color=blue><B>".$strings["Build"]."</B></font></a><P>";

           break; // end filters
           case 'WF':

            $addbuild = " | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Workflows&action=build&value=".$val."&valuetype=Workflows&sendiv=WF');return false\"><font size=2 color=blue><B>[".$strings["Build"]."]</B></font></a><P>";

           break; // end infra
           case 'lic':
   
            if ($_POST['sclm_configurationitems_id_c']){

               $sclm_configurationitems_id_c = $_POST['sclm_configurationitems_id_c'];
               $addbuild = " | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Licensing&action=build&value=".$sclm_configurationitems_id_c."&valuetype=Licensing&sendiv=".$BodyDIV."');return false\"><font size=2 color=blue><B>".$strings["Build"]."</B></font></a><P>";

               } else {
               
               $addbuild = " | <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=Licensing&action=build&value=".$val."&valuetype=Licensing&sendiv=".$BodyDIV."');return false\"><font size=2 color=blue><B>".$strings["Build"]."</B></font></a><P>";
               }

           break; // end infra
           case 'FEATURES':

            if ($_POST['sclm_configurationitemtypes_id_c'] == '399a1a2c-5038-8d99-20bf-54e8c81f35a9'){

               $sla_id = $_POST['name'];
               $sclm_configurationitemtypes_id_c = '399a1a2c-5038-8d99-20bf-54e8c81f35a9';
               $addbuild = "<BR><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=AccountsServicesSLAs&action=view&value=".$sla_id."&valuetype=AccountsServicesSLAs&sendiv=FEATURE');return false\"><font size=2 color=blue><B>[".$strings["Build"]."]</B></font></a>";

               }

           break; // end features

          } // end switch

          } // if div

       # End adding any div build links
       #################
       # Present final messages

       if ($BodyDIV == 'FEATURES'){

          $process_message = $strings["SubmissionSuccess"];

          } elseif (in_array($_POST['sendiv'],$via_array) || in_array($_POST['sendiv'],$pesh_array) || in_array($_POST['sendiv'],$leadership_array) || in_array($_POST['sendiv'],$ai_array) || in_array($_POST['sendiv'],$perma_array)){
 
          $BodyDIV = $_POST['sendiv'];

          $config_type_id = $_POST['sclm_configurationitemtypes_id_c'];
          $config_type_return = $funky_gear->object_returner ("ConfigurationItemTypes", $config_type_id);
          $config_type = $config_type_return[0];

          $process_message = "<a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."&sendiv=".$sendiv."');return false\"><font color=red><B>[".$name."]</B></font></a> <font color=blue><B>".$config_type."</B></font>";

          } else {

          $process_message = $strings["SubmissionSuccess"]."<P><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=edit&value=".$val."&valuetype=".$valtype."&sendiv=".$sendiv."');return false\"><font color=red>[".$strings["action_edit"]."]</font></a> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'pc=".$portalcode."&do=".$do."&action=view&value=".$val."&valuetype=".$valtype."&sendiv=".$sendiv."');return false\"> ".$strings["action_view_here"]."</a>".$addbuild."<BR>";

          $description = str_replace("\n", "<br>", $description);
          $process_message .= "<B>".$strings["Name"].":</B> ".$name."<BR>";
          $process_message .= "<B>".$strings["Description"].":</B> ".$description."<BR>";

          } # end if features

       echo "<div style=\"".$divstyle_white."\">".$process_message."</div>";       

       } else { // if no error

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";

       }

       # End presenting final messages
       #################

   break; // end process

   } // end action switch

# break; // End
##########################################################
?>
