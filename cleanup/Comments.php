<?php 
##############################################
# realpolitika
# Author: Matthew Edmond, Saloob
# Date: 2011-02-01
# Page: Index 
##########################################################
# case 'Comments':

  switch ($action){
   
   case 'add':

    $tblcnt = 0;

    $tablefields[$tblcnt][0] = 'value'; // Field Name
    $tablefields[$tblcnt][1] = "Value"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = 'value';//$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;  
     
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'valuetype'; // Field Name
    $tablefields[$tblcnt][1] = "Value Type"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $valtype; // Field ID
    $tablefields[$tblcnt][20] = 'valuetype'; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;  

    if ($valtype == 'GovernmentTypes'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmenttypes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_governmenttypes_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmenttypes_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Governments'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_governments_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'ConstitutionalArticles'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_constitutionalarticles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_constitutionalarticles_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_constitutionalarticles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'PoliticalParties'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_politicalparties_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_politicalparties_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalparties_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'ConstitutionalAmendments'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_constitutionalamendments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_constitutionalamendments_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_constitutionalamendments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'GovernmentConstitutions'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentconstitutions_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_governmentconstitutions_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentconstitutions_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'GovernmentBranches'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentbranches_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_governmentbranches_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentbranches_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'BranchBodyDepartmentAgencies'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_department_agencies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_department_agencies_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_department_agencies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'News'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_news_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_news_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_news_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Organisations'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_organisations_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_organisations_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_organisations_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'GovernmentTenders'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_government_tenders_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_government_tenders_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_government_tenders_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'GovernmentRoles'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentroles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_governmentroles_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentroles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'BranchBodyIndependentAgencies'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_independentagencies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_independentagencies_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_independentagencies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'BranchBodyDepartments'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_branch_departments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_branch_departments_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_branch_departments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'PoliticalPartyRoles'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_politicalpartyroles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_politicalpartyroles_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalpartyroles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'GovernmentPolicies' || $valtype == 'PoliticalPartyPolicies'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentpolicies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_governmentpolicies_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentpolicies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Nominees'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_nominees_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_nominees_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_nominees_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Events'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_events_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_events_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_events_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Content'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_content_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_content_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_content_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Bills'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_bills_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_bills_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_bills_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Laws'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_laws_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_laws_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_laws_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Causes'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_causes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_causes_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_causes_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'Effects'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'sfx_effects_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "sfx_effects_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'sfx_effects_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    if ($valtype == 'LawCases'){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_lawcases_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "cmv_lawcases_id_c"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
       $tablefields[$tblcnt][10] = '';//1; // show in view 
       $tablefields[$tblcnt][11] = $val; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_lawcases_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $val; //$field_value;  
       
       }

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
    $tablefields[$tblcnt][1] = ""; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;  

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Title"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ''; // Field ID
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = ""; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "cmv_statuses_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_statuses'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_statuses_id_c; //$field_value; 
  
    $tblcnt++;
    
    $browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 1);
    if (!empty($browser_lingo)) {
       $cmv_language_id_c = dlookup("cmv_languages", "id", "ext='".$browser_lingo."'");     
       }
          
    $tablefields[$tblcnt][0] = "cmv_languages_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Language"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_languages'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'language_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_language_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_language_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_language_id_c; //$field_value; 
    
    $tblcnt++;
    
    $country = "";
    $ip_address = $_SERVER['REMOTE_ADDR'];

    if (!empty($ip_address)) {
     $country = file_get_contents('http://api.hostip.info/country.php?ip='.$ip_address);
     }
     
    if (!empty($country)) {
       $cmv_countries_id_c = dlookup("cmv_countries", "id", "two_letter_code='".$country."'");
       //$country = dlookup("cmv_countries", "name", "two_letter_code='".$country."'");   
       }
     
    $tablefields[$tblcnt][0] = "cmv_countries_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Country"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_countries'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_countries_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_countries_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_countries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_countries_id_c; //$field_value; 

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
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;    
    
    $valpack = "";
    $valpack[0] = 'Comments';
    $valpack[1] = 'add'; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    echo "<BR>".$object_return."<BR>";
    echo "<img src=images/blank.gif width=550 height=10><BR>";

    echo $zaform;
       
   break; // end add action
   case 'edit':

    $object_type = "Comments";
    $action = "select";
    $params = " id='".$val."' ";

    $comm_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    $comments = "";

    if (is_array($comm_list)){
  
       $comment = "";
    
       for ($cnt=0;$cnt < count($comm_list);$cnt++){    
           $comment_id = $comm_list[$cnt]['id'];
           $comment_title = $comm_list[$cnt]['name'];
           $language_id = $comm_list[$cnt]['language_id'];
           $contact_id_c = $comm_list[$cnt]['contact_id_c'];
           $first_name = $comm_list[$cnt]['first_name'];
           $last_name = $comm_list[$cnt]['last_name'];      
           $date_entered = $comm_list[$cnt]['date_entered'];
           $date_modified = $comm_list[$cnt]['date_modified'];
           $date_modified = substr($date_modified, 0, 10);
           $modified_user_id = $comm_list[$cnt]['modified_user_id'];
           $created_by =$comm_list[$cnt]['created_by'];
           $description = $comm_list[$cnt]['description'];
           $deleted = $comm_list[$cnt]['deleted'];
           $assigned_user_id = $comm_list[$cnt]['assigned_user_id'];
           $cmv_statuses_id_c = $comm_list[$cnt]['cmv_statuses_id_c'];
           $cmv_governmenttypes_id_c = $comm_list[$cnt]['cmv_governmenttypes_id_c'];
           $cmv_governments_id_c = $comm_list[$cnt]['cmv_governments_id_c'];
           $cmv_constitutionalarticles_id_c = $comm_list[$cnt]['cmv_constitutionalarticles_id_c'];
           $cmv_politicalparties_id_c = $comm_list[$cnt]['cmv_politicalparties_id_c'];
           $cmv_constitutionalamendments_id_c = $comm_list[$cnt]['cmv_constitutionalamendments_id_c'];
           $cmv_governmentconstitutions_id_c = $comm_list[$cnt]['cmv_governmentconstitutions_id_c'];
           $cmv_governmentbranches_id_c = $comm_list[$cnt]['cmv_governmentbranches_id_c'];
           $cmv_department_agencies_id_c = $comm_list[$cnt]['cmv_department_agencies_id_c'];
           $cmv_news_id_c = $comm_list[$cnt]['cmv_news_id_c'];
           $cmv_organisations_id_c = $comm_list[$cnt]['cmv_organisations_id_c'];
           $cmv_government_tenders_id_c = $comm_list[$cnt]['cmv_government_tenders_id_c'];
           $cmv_governmentroles_id_c = $comm_list[$cnt]['cmv_governmentroles_id_c'];
           $cmv_branch_departments_id_c = $comm_list[$cnt]['cmv_branch_departments_id_c'];
           $cmv_politicalpartyroles_id_c = $comm_list[$cnt]['cmv_politicalpartyroles_id_c'];
           $cmv_governmentpolicies_id_c = $comm_list[$cnt]['cmv_governmentpolicies_id_c'];
           $cmv_nominees_id_c = $comm_list[$cnt]['cmv_nominees_id_c'];    
           $cmv_events_id_c = $comm_list[$cnt]['cmv_events_id_c'];
           $cmv_content_id_c = $comm_list[$cnt]['cmv_content_id_c'];
           $cmv_bills_id_c = $comm_list[$cnt]['cmv_bills_id_c'];
           $cmv_laws_id_c = $comm_list[$cnt]['cmv_laws_id_c'];
           $cmv_statutes_id_c = $comm_list[$cnt]['cmv_statutes_id_c'];
           $cmv_causes_id_c = $comm_list[$cnt]['cmv_causes_id_c'];
           $sfx_effects_id_c = $comm_list[$cnt]['sfx_effects_id_c'];
           $cmv_lawcases_id_c = $comm_list[$cnt]['cmv_lawcases_id_c'];
           $cmv_comments_id_c = $comm_list[$cnt]['cmv_comments_id_c'];
           $cmv_countries_id_c = $comm_list[$cnt]['cmv_countries_id_c'];
           $sfx_actions_id_c = $comm_list[$cnt]['sfx_actions_id_c'];
           $cmv_independentagencies_id_c = $comm_list[$cnt]['cmv_independentagencies_id_c'];

           } // end for


    $tblcnt = 0;

    $tablefields[$tblcnt][0] = 'id'; // Field Name
    $tablefields[$tblcnt][1] = "ID"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = 'id';//$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;  

    $tblcnt++;

    $tablefields[$tblcnt][0] = 'value'; // Field Name
    $tablefields[$tblcnt][1] = "Value"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $val; // Field ID
    $tablefields[$tblcnt][20] = 'value';//$field_value_id;
    $tablefields[$tblcnt][21] = $val; //$field_value;  
     
    $tblcnt++;

    $tablefields[$tblcnt][0] = 'valuetype'; // Field Name
    $tablefields[$tblcnt][1] = "Value Type"; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = 'NULL'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $valtype; // Field ID
    $tablefields[$tblcnt][20] = 'valuetype'; //$field_value_id;
    $tablefields[$tblcnt][21] = $valtype; //$field_value;  

    if ($cmv_governmenttypes_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmenttypes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentType"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmenttypes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmenttypes_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentTypes'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governmenttypes_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmenttypes_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmenttypes_id_c; //$field_value;  
       
       }

    if ($cmv_governments_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Government"];// Full Name
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
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governments_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Governments'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governments_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governments_id_c; //$field_value;  
       
       }

    if ($cmv_constitutionalarticles_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_constitutionalarticles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ConstitutionArticle"];// Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_constitutionalarticles'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_constitutionalarticles_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConstitutionArticles'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_constitutionalarticles_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_constitutionalarticles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_constitutionalarticles_id_c; //$field_value;  
       
       }

    if ($cmv_politicalparties_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_politicalparties_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["PoliticalParty"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_politicalparties'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_politicalparties_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'PoliticalParties'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_politicalparties_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalparties_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_politicalparties_id_c; //$field_value;  
       
       }

    if ($cmv_constitutionalamendments_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_constitutionalamendments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["ConstitutionAmendment"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_constitutionalamendments'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_constitutionalamendments_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'ConstitutionalAmendments'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_constitutionalamendments_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_constitutionalamendments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_constitutionalamendments_id_c; //$field_value;  
       
       }

    if ($cmv_governmentconstitutions_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentconstitutions_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Constitution"];// Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentconstitutions'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentconstitutions_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentConstitutions'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governmentconstitutions_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentconstitutions_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentconstitutions_id_c; //$field_value;  
       
       }

    if ($cmv_governmentbranches_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentbranches_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Branch"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentbranches'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentbranches_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentBranches'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view 
       $tablefields[$tblcnt][11] = $cmv_governmentbranches_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentbranches_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentbranches_id_c; //$field_value;  
       
       }

    if ($cmv_department_agencies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_department_agencies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Agency"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_departmentagencies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_department_agencies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'DepartmentAgencies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_department_agencies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_department_agencies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_department_agencies_id_c; //$field_value;  
       
       }

    if ($cmv_news_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_news_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["News"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_news'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_news_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'News'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_news_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_news_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_news_id_c; //$field_value;  
       
       }

    if ($cmv_organisations_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_organisations_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Organisation"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_organisations'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_organisations_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Organisations'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_organisations_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_organisations_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_organisations_id_c; //$field_value;  
       
       }

    if ($cmv_government_tenders_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_government_tenders_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentTender"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmenttenders'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_government_tenders_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentTenders'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_government_tenders_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_government_tenders_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_government_tenders_id_c; //$field_value;  
       
       }

    if ($cmv_governmentroles_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentroles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentRole"];// Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentroles'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentroles_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentRoles'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_governmentroles_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentroles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentroles_id_c; //$field_value;  
       
       }

    if ($cmv_independentagencies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_independentagencies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = "Branch Body Independent Agencies"; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_independentagencies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_independentagencies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'BranchBodyIndependentAgencies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_independentagencies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_independentagencies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_independentagencies_id_c; //$field_value;  
       
       }

    if ($cmv_branch_departments_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_branch_departments_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Department"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_branchdepartments'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_branch_departments_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'BranchDepartments'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_branch_departments_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_branch_departments_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_branch_departments_id_c; //$field_value;  
       
       }

    if ($cmv_politicalpartyroles_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_politicalpartyroles_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["PartyRole"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_politicalpartyroles'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_politicalpartyroles_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'PoliticalPartyRoles'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_politicalpartyroles_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_politicalpartyroles_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_politicalpartyroles_id_c; //$field_value;  
       
       }

    if ($cmv_governmentpolicies_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_governmentpolicies_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["GovernmentPolicy"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_governmentpolicies'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_governmentpolicies_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'GovernmentPolicies'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_governmentpolicies_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_governmentpolicies_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_governmentpolicies_id_c; //$field_value;  
       
       }

    if ($cmv_nominees_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_nominees_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Nominee"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_nominees'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_nominees_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Nominees'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_nominees_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_nominees_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_nominees_id_c; //$field_value;  
       
       }

    if ($cmv_events_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_events_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Event"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_events'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_events_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Events'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_events_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_events_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_events_id_c; //$field_value;  
       
       }

    if ($cmv_content_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_content_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Content"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_content'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_content_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = ''; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_content_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_content_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_content_id_c; //$field_value;  
       
       }

    if ($cmv_bills_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_bills_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Bills"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_bills'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_bills_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Bills'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_bills_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_bills_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_bills_id_c; //$field_value;  
       
       }

    if ($cmv_laws_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_laws_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Laws"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_laws'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_laws_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Laws'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_laws_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_laws_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_laws_id_c; //$field_value;  
       
       }

    if ($cmv_causes_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_causes_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["Causes"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_causes'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_causes_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Causes'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_causes_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_causes_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_causes_id_c; //$field_value;  
       
       }

    if ($sfx_effects_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'sfx_effects_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["SideEffects"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'sfx_effects'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $sfx_effects_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'SharedEffects'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $sfx_effects_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'sfx_effects_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $sfx_effects_id_c; //$field_value;  
       
       }

    if ($cmv_lawcases_id_c != NULL){

       $tblcnt++;

       $tablefields[$tblcnt][0] = 'cmv_lawcases_id_c'; // Field Name
       $tablefields[$tblcnt][1] = $strings["LawCases"]; // Full Name
       $tablefields[$tblcnt][2] = 0; // is_primary
       $tablefields[$tblcnt][3] = 0; // is_autoincrement
       $tablefields[$tblcnt][4] = 0; // is_name
       $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
       $tablefields[$tblcnt][6] = '255'; // length
       $tablefields[$tblcnt][7] = ''; // NULLOK?
       $tablefields[$tblcnt][8] = ''; // default
       $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
       $tablefields[$tblcnt][9][1] = 'cmv_lawcases'; // If DB, dropdown_table, if List, then array, other related table
       $tablefields[$tblcnt][9][2] = 'id';
       $tablefields[$tblcnt][9][3] = 'name';
       $tablefields[$tblcnt][9][4] = ''; // Exceptions
       $tablefields[$tblcnt][9][5] = $cmv_lawcases_id_c; // Current Value
       $tablefields[$tblcnt][9][6] = 'Laws'; // Object
       $tablefields[$tblcnt][10] = '1';//1; // show in view
       $tablefields[$tblcnt][11] = $cmv_lawcases_id_c; // Field ID
       $tablefields[$tblcnt][20] = 'cmv_lawcases_id_c'; //$field_value_id;
       $tablefields[$tblcnt][21] = $cmv_lawcases_id_c; //$field_value;  
       
       }

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "contact_id_c"; // Field Name
    $tablefields[$tblcnt][1] = ""; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'hidden';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = ""; // Field ID
    $tablefields[$tblcnt][20] = "contact_id_c"; //$field_value_id;
    $tablefields[$tblcnt][21] = $sess_contact_id; //$field_value;  

    $tblcnt++;
     
    $tablefields[$tblcnt][0] = "name"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Title"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 1; // is_name
    $tablefields[$tblcnt][5] = 'varchar';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = '0'; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9] = '';//$dropdown_table; // related table
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $comment_title; // Field ID
    $tablefields[$tblcnt][20] = "name"; //$field_value_id;
    $tablefields[$tblcnt][21] = $comment_title; //$field_value;

    $tblcnt++;

    $tablefields[$tblcnt][0] = "cmv_statuses_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Status"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_statuses'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'status_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_statuses_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_statuses_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_statuses_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_statuses_id_c; //$field_value; 
  
    $tblcnt++;
    
    $browser_lingo = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 1);
    if (!empty($browser_lingo) && $cmv_language_id_c == NULL) {
       $cmv_language_id_c = dlookup("cmv_languages", "id", "ext='".$browser_lingo."'");     
       }
          
    $tablefields[$tblcnt][0] = "cmv_languages_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Language"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_languages'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'language_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_language_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_language_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_languages_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_language_id_c; //$field_value; 
    
    $tblcnt++;
         
    $tablefields[$tblcnt][0] = "cmv_countries_id_c"; // Field Name
    $tablefields[$tblcnt][1] = $strings["Country"]; // Full Name
    $tablefields[$tblcnt][2] = 0; // is_primary
    $tablefields[$tblcnt][3] = 0; // is_autoincrement
    $tablefields[$tblcnt][4] = 0; // is_name
    $tablefields[$tblcnt][5] = 'dropdown';//$field_type; //'INT'; // type
    $tablefields[$tblcnt][6] = '255'; // length
    $tablefields[$tblcnt][7] = ''; // NULLOK?
    $tablefields[$tblcnt][8] = ''; // default
    $tablefields[$tblcnt][9][0] = 'db'; // dropdown type (DB Table, Array List, Other)
    $tablefields[$tblcnt][9][1] = 'cmv_countries'; // If DB, dropdown_table, if List, then array, other related table
    $tablefields[$tblcnt][9][2] = 'id';
    $tablefields[$tblcnt][9][3] = 'name_'.$lingo;
    $tablefields[$tblcnt][9][4] = ''; // Exceptions
    $tablefields[$tblcnt][9][5] = $cmv_countries_id_c; // Current Value
    $tablefields[$tblcnt][10] = '1';//1; // show in view 
    $tablefields[$tblcnt][11] = $cmv_countries_id_c; // Field ID
    $tablefields[$tblcnt][20] = 'cmv_countries_id_c';//$field_value_id;
    $tablefields[$tblcnt][21] = $cmv_countries_id_c; //$field_value; 

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
    $tablefields[$tblcnt][11] = $description; // Field ID
    $tablefields[$tblcnt][20] = "description"; //$field_value_id;
    $tablefields[$tblcnt][21] = $description; //$field_value;    
    
    $valpack = "";
    $valpack[0] = 'Comments';
    $valpack[1] = 'edit'; 
    $valpack[2] = $valtype;
    $valpack[3] = $tablefields;
    $valpack[4] = 1; // $auth; // user level authentication (3,2,1 = admin,client,user)

    // Build parent layer
    $zaform = "";
    $zaform = $funky_gear->form_presentation($valpack);

    echo "<BR>".$object_return."<BR>";
    echo "<img src=images/blank.gif width=550 height=10><BR>";

    echo $zaform;

       } // end if

   break; // end edit action
   case 'list':
  
    $params = array();
    $params[0] = $object_return_params[0];
    $params[1] = "*";
    $params[2] = "";
    $params[3] = " date_modified ASC ";

    if ($valtype == 'Search'){
       // Nothing extra yet
       }

    if ($valtype == "MyAgencyTenderComments" || $valtype == "MyPolicyComments" || $valtype == "MyPoliticalPartyComments" || $valtype == "MyConstitutionArticleComments" || $valtype == "MyConstitutionComments" || $valtype == "MyConstitutionComments"){
       // Nothing extra yet
       } else {
       //$params[0] .= " && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' ";
       }

    $object_type = "Comments";
    $action = "select";
   
    $comm_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    $comments = "";

    if (is_array($comm_list)){
  
       $comment = "";
    
       for ($cnt=0;$cnt < count($comm_list);$cnt++){    
           $comment_id = $comm_list[$cnt]['id'];
           $comment_title = $comm_list[$cnt]['name'];
           $language_id = $comm_list[$cnt]['language_id'];
           $contact_id_c = $comm_list[$cnt]['contact_id_c'];
           $first_name = $comm_list[$cnt]['first_name'];
           $last_name = $comm_list[$cnt]['last_name'];      
           $date_entered = $comm_list[$cnt]['date_entered'];
           $date_modified = $comm_list[$cnt]['date_modified'];
           $date_modified = substr($date_modified, 0, 10);
           $modified_user_id = $comm_list[$cnt]['modified_user_id'];
           $created_by =$comm_list[$cnt]['created_by'];
           //$description = $comm_list[$cnt]['description'];
           $deleted = $comm_list[$cnt]['deleted'];
           $assigned_user_id = $comm_list[$cnt]['assigned_user_id'];
           $cmv_statuses_id_c = $comm_list[$cnt]['cmv_statuses_id_c'];
           $cmv_governmenttypes_id_c = $comm_list[$cnt]['cmv_governmenttypes_id_c'];
           $cmv_governments_id_c = $comm_list[$cnt]['cmv_governments_id_c'];
           $cmv_constitutionalarticles_id_c = $comm_list[$cnt]['cmv_constitutionalarticles_id_c'];
           $cmv_politicalparties_id_c = $comm_list[$cnt]['cmv_politicalparties_id_c'];
           $cmv_constitutionalamendments_id_c = $comm_list[$cnt]['cmv_constitutionalamendments_id_c'];
           $cmv_governmentconstitutions_id_c = $comm_list[$cnt]['cmv_governmentconstitutions_id_c'];
           $cmv_governmentbranches_id_c = $comm_list[$cnt]['cmv_governmentbranches_id_c'];
           $cmv_department_agencies_id_c = $comm_list[$cnt]['cmv_department_agencies_id_c'];
           $cmv_news_id_c = $comm_list[$cnt]['cmv_news_id_c'];
           $cmv_organisations_id_c = $comm_list[$cnt]['cmv_organisations_id_c'];
           $cmv_government_tenders_id_c = $comm_list[$cnt]['cmv_government_tenders_id_c'];
           $cmv_governmentroles_id_c = $comm_list[$cnt]['cmv_governmentroles_id_c'];
           $cmv_branch_departments_id_c = $comm_list[$cnt]['cmv_branch_departments_id_c'];
           $cmv_politicalpartyroles_id_c = $comm_list[$cnt]['cmv_politicalpartyroles_id_c'];
           $cmv_governmentpolicies_id_c = $comm_list[$cnt]['cmv_governmentpolicies_id_c'];
           $cmv_nominees_id_c = $comm_list[$cnt]['cmv_nominees_id_c'];    
           $cmv_events_id_c = $comm_list[$cnt]['cmv_events_id_c'];
           $cmv_content_id_c = $comm_list[$cnt]['cmv_content_id_c'];
           $cmv_bills_id_c = $comm_list[$cnt]['cmv_bills_id_c'];
           $cmv_laws_id_c = $comm_list[$cnt]['cmv_laws_id_c'];
           $cmv_statutes_id_c = $comm_list[$cnt]['cmv_statutes_id_c'];
           $cmv_causes_id_c = $comm_list[$cnt]['cmv_causes_id_c'];
           $sfx_effects_id_c = $comm_list[$cnt]['sfx_effects_id_c'];
           $cmv_lawcases_id_c = $comm_list[$cnt]['cmv_lawcases_id_c'];
           $cmv_comments_id_c = $comm_list[$cnt]['cmv_comments_id_c'];
           $sfx_actions_id_c = $comm_list[$cnt]['sfx_actions_id_c'];
           $cmv_countries_id_c = $comm_list[$cnt]['cmv_countries_id_c'];
           $cmv_independentagencies_id_c = $comm_list[$cnt]['cmv_independentagencies_id_c'];

           if ($language_id) {
              $language = dlookup("cmv_languages", "name", "id='".$language_id."'");     
              } else {
              $language = $strings["NA"];
              }
      
           // Target may not be provided if no val sent (my comments) - so must build per comment
              $object_return_target = "<font color=#FBB117 size=2><B>Related Items: </B></font>";

              if ($cmv_governmenttypes_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentTypes',$cmv_governmenttypes_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governments_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Governments',$cmv_governments_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_constitutionalarticles_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('ConstitutionArticles',$cmv_constitutionalarticles_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governmentbranches_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentBranches',$cmv_governmentbranches_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_department_agencies_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('BranchBodyDepartmentAgencies',$cmv_department_agencies_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_news_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('News',$cmv_news_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_organisations_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Organisations',$cmv_organisations_id_ce);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_government_tenders_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('AgencyTenders',$cmv_government_tenders_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_bills_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Bills',$cmv_bills_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_laws_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Laws',$cmv_laws_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governmentroles_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentRoles',$cmv_governmentroles_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_branch_departments_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('BranchBodyDepartments',$cmv_branch_departments_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_independentagencies_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('BranchBodyIndependentAgencies',$cmv_independentagencies_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_politicalpartyroles_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('PoliticalPartyRoles',$cmv_politicalpartyroles_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governmentpolicies_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentPolicies',$cmv_governmentpolicies_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_nominees_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Nominees',$cmv_nominees_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_events_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Events',$cmv_events_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_content_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Content',$cmv_content_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_countries_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Countries',$cmv_countries_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_lawcases_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('LawCases',$cmv_lawcases_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_statutes_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Statutes',$cmv_statutes_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_causes_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Causes',$cmv_causes_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($sfx_effects_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Effects',$sfx_effects_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($sfx_actions_id_c != NULL){
                 $comment_object_returner = $funky_gear->object_returner ('Actions',$sfx_actions_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }


           // Build the Comment for wrapping
           $comment = "<font size=2 color=#151B54><B>".$date_modified.":</B></font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Comments&action=view&value=".$comment_id."&valuetype=Comments');return false\"><font size=2 color=#151B54><B>".$comment_title."</B></font></a> (".$strings["Language"].": ".$language.")<BR>".$object_return_target;
       
           // if comment contact is current - allow to edit
           if ($contact_id_c == $sess_contact_id){
              $comment .= "<P><font size=2 color=#FBB117><B>".$strings["Member"].": </B></font>".$strings["Me"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Comments&action=edit&value=".$comment_id."&valuetype=Comments');return false\"><font size=2 color=red><B>".$strings["action_edit"]."</B></font></a>";

              } else {
      
              // If other user - check status
              switch ($cmv_statuses_id_c){
       
               case 'cf7e4020-cff4-81bf-1d88-4d48ffa7497b':
       
                $comment = "<font color=#FBB117>".$strings["Member"].": </font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Profile&action=view&value=".$contact_id_c."&valuetype=Profiles');return false\"><font color=#151B54><B>".$first_name." ".$last_name." (View Profile)</B></font></a><BR>".$comment."<P>";
       
               break;
               case 'dfc905da-7434-7375-86fd-4d48ff743f78':
       
                $comment = "<font color=#FBB117>".$strings["Member"].": </font>".$strings["CommentAnonymous"]."<BR>".$comment."<P>";
        
               break;
         
              } // end switch
         
              } // end else 
       
           $comments .= $object_return_title."<div style=\"".$divstyle_white."\">".$comment."</div>";

           } // end for
       
       } else {// end if array
    
         $comments = $object_return_title."<div style=\"".$divstyle_white."\">".$strings["Empty_Listed"]."</div>";
    
       } // end if no comments
    
    if ($sess_contact_id != NULL && $valtype != NULL){
     
       $addcomment = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Comments&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addNew"]."</B></font></a></div>";
     
       } else {
      
       $addcomment = "<div style=\"".$divstyle_white."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }

    if ($valtype == 'Search' || $valtype == "MyAgencyTenderComments" || $valtype == "MyPolicyComments" || $valtype == "MyPoliticalPartyComments" || $valtype == "MyConstitutionArticleComments" || $valtype == "MyConstitutionComments" || $valtype == "MyConstitutionComments"){

       $addcomment = "";

       }

    if (count($comm_list)>10){
       echo $addcomment."<P>".$comments."".$addcomment;
       } else {
       echo $comments."<P>".$addcomment;
       } 
    
   break; // end list action
   case 'view':
  
    $params[0] .= " deleted=0 && cmv_statuses_id_c != 'eb34ba8c-fb9b-4522-0e03-4d48ffdbb48b' && id='".$val."' ";
    $object_type = "Comments";
    $action = "select";
   
    $comm_list = api_sugar ($api_user, $api_pass, $crm_wsdl_url, $object_type, $action, $params);

    $comments = "";

    if (is_array($comm_list)){
  
       $comment = "";
    
       for ($cnt=0;$cnt < count($comm_list);$cnt++){    
           $comment_id = $comm_list[$cnt]['id'];
           $comment_title = $comm_list[$cnt]['name'];
           $language_id = $comm_list[$cnt]['language_id'];
           $contact_id_c = $comm_list[$cnt]['contact_id_c'];
           $first_name = $comm_list[$cnt]['first_name'];
           $last_name = $comm_list[$cnt]['last_name'];      
           $date_entered = $comm_list[$cnt]['date_entered'];
           $date_modified = $comm_list[$cnt]['date_modified'];
           $date_modified = substr($date_modified, 0, 10);
           $modified_user_id = $comm_list[$cnt]['modified_user_id'];
           $created_by =$comm_list[$cnt]['created_by'];
           $description = $comm_list[$cnt]['description'];
           $description = str_replace("\n","<BR>",$description);

           $deleted = $comm_list[$cnt]['deleted'];
           $assigned_user_id = $comm_list[$cnt]['assigned_user_id'];
           $cmv_statuses_id_c = $comm_list[$cnt]['cmv_statuses_id_c'];
           $cmv_governmenttypes_id_c = $comm_list[$cnt]['cmv_governmenttypes_id_c'];
           $cmv_governments_id_c = $comm_list[$cnt]['cmv_governments_id_c'];
           $cmv_constitutionalarticles_id_c = $comm_list[$cnt]['cmv_constitutionalarticles_id_c'];
           $cmv_politicalparties_id_c = $comm_list[$cnt]['cmv_politicalparties_id_c'];
           $cmv_constitutionalamendments_id_c = $comm_list[$cnt]['cmv_constitutionalamendments_id_c'];
           $cmv_governmentconstitutions_id_c = $comm_list[$cnt]['cmv_governmentconstitutions_id_c'];
           $cmv_governmentbranches_id_c = $comm_list[$cnt]['cmv_governmentbranches_id_c'];
           $cmv_department_agencies_id_c = $comm_list[$cnt]['cmv_department_agencies_id_c'];
           $cmv_news_id_c = $comm_list[$cnt]['cmv_news_id_c'];
           $cmv_organisations_id_c = $comm_list[$cnt]['cmv_organisations_id_c'];
           $cmv_government_tenders_id_c = $comm_list[$cnt]['cmv_government_tenders_id_c'];
           $cmv_governmentroles_id_c = $comm_list[$cnt]['cmv_governmentroles_id_c'];
           $cmv_branch_departments_id_c = $comm_list[$cnt]['cmv_branch_departments_id_c'];
           $cmv_politicalpartyroles_id_c = $comm_list[$cnt]['cmv_politicalpartyroles_id_c'];
           $cmv_governmentpolicies_id_c = $comm_list[$cnt]['cmv_governmentpolicies_id_c'];
           $cmv_nominees_id_c = $comm_list[$cnt]['cmv_nominees_id_c'];    
           $cmv_events_id_c = $comm_list[$cnt]['cmv_events_id_c'];
           $cmv_content_id_c = $comm_list[$cnt]['cmv_content_id_c'];
           $cmv_bills_id_c = $comm_list[$cnt]['cmv_bills_id_c'];
           $cmv_laws_id_c = $comm_list[$cnt]['cmv_laws_id_c'];
           $cmv_statutes_id_c = $comm_list[$cnt]['cmv_statutes_id_c'];
           $cmv_causes_id_c = $comm_list[$cnt]['cmv_causes_id_c'];
           $sfx_effects_id_c = $comm_list[$cnt]['sfx_effects_id_c'];
           $cmv_lawcases_id_c = $comm_list[$cnt]['cmv_lawcases_id_c'];
           $cmv_comments_id_c = $comm_list[$cnt]['cmv_comments_id_c'];
           $cmv_countries_id_c = $comm_list[$cnt]['cmv_countries_id_c'];
           $sfx_actions_id_c = $comm_list[$cnt]['sfx_actions_id_c'];
           $cmv_independentagencies_id_c = $comm_list[$cnt]['cmv_independentagencies_id_c'];

           $view_count = $comm_list[$cnt]['view_count'];
           $new_viewcount = $view_count+1;
           $view_count_show = "[".$strings["Views"].": ".$new_viewcount."]";

           // Add View Count
           $action = "update";
           $params = array();  
           $params = array(
            array('name'=>'id','value' => $val),
            array('name'=>'view_count','value' => $new_viewcount),
           );

           $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $action, $params);

           if ($language_id) {
              $language = dlookup("cmv_languages", "name", "id='".$language_id."'");     
              } else {
              $language = $strings["NA"];
              }
      
           // Target may not be provided if no val sent (my comments) - so must build per comment
           $object_return_target = "<font color=#FBB117 size=2><B>Related Items: </B></font>";

              if ($cmv_governmenttypes_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentTypes',$cmv_governmenttypes_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governments_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Governments',$cmv_governments_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_constitutionalarticles_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('ConstitutionArticles',$cmv_constitutionalarticles_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governmentbranches_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentBranches',$cmv_governmentbranches_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_department_agencies_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('BranchBodyDepartmentAgencies',$cmv_department_agencies_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_news_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('News',$cmv_news_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_organisations_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Organisations',$cmv_organisations_id_ce);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_government_tenders_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('AgencyTenders',$cmv_government_tenders_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_bills_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Bills',$cmv_bills_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_laws_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Laws',$cmv_laws_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governmentroles_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentRoles',$cmv_governmentroles_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_branch_departments_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('BranchBodyDepartments',$cmv_branch_departments_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_independentagencies_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('BranchBodyIndependentAgencies',$cmv_independentagencies_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }

              if ($cmv_politicalpartyroles_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('PoliticalPartyRoles',$cmv_politicalpartyroles_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_governmentpolicies_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('GovernmentPolicies',$cmv_governmentpolicies_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_nominees_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Nominees',$cmv_nominees_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_events_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Events',$cmv_events_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_content_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Content',$cmv_content_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_countries_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Countries',$cmv_countries_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_lawcases_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('LawCases',$cmv_lawcases_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_statutes_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Statutes',$cmv_statutes_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($cmv_causes_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Causes',$cmv_causes_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($sfx_effects_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Effects',$sfx_effects_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }
              if ($sfx_actions_id_c != NULL){
                 $comment_object_returner = "";
                 $comment_object_returner = $funky_gear->object_returner ('Actions',$sfx_actions_id_c);
                 $object_return_target .= $comment_object_returner[3]." + ";
                 }

           // Build the Comment for wrapping
           $comment = "<font size=2 color=#151B54><B>".$date_modified.":</B></font> <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Comments&action=view&value=".$comment_id."&valuetype=Comments');return false\"><font size=2 color=#151B54><B>".$comment_title."</B></font></a> (".$strings["Language"].": ".$language.") ".$view_count_show."<P>".$object_return_target;
       
           // if comment contact is current - allow to edit
           if ($contact_id_c == $sess_contact_id){
              $comment .= "<P><font size=2 color=#FBB117><B>".$strings["Member"].": </B></font>".$strings["Me"]." <a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Comments&action=edit&value=".$comment_id."&valuetype=Comments');return false\"><font size=2 color=red><B>".$strings["action_edit"]."</B></font></a>";

              } else {
      
              // If other user - check status
              switch ($cmv_statuses_id_c){
       
               case 'cf7e4020-cff4-81bf-1d88-4d48ffa7497b':
       
                $comment = "<font color=#FBB117>".$strings["Member"].": </font><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Profile&action=view&value=".$contact_id_c."&valuetype=Profiles');return false\"><font color=#151B54><B>".$first_name." ".$last_name." (View Profile)</B></font></a><P>".$comment."<P>";
       
               break;
               case 'dfc905da-7434-7375-86fd-4d48ff743f78':
       
                $comment = "<font color=#FBB117>".$strings["Member"].": </font>".$strings["CommentAnonymous"]."<P>".$comment."<P>";
        
               break;
         
              } // end switch
         
              } // end else 

           $comment .= "<P>".$description;       
           $comments .= $object_return_title."<div style=\"".$divstyle_white."\">".$comment."</div>";

           } // end for
       
       } else {// end if array
    
         $comments = $object_return_title."<div style=\"".$divstyle_orange_light."\">".$strings["Empty_Listed"]."</div>";
    
       } // end if no comments
    
    if ($sess_contact_id != NULL && $valtype != NULL){
     
       $addcomment = "<P><div style=\"".$divstyle_blue."\"><a href=\"#\" onClick=\"loader('".$BodyDIV."');doBPOSTRequest('".$BodyDIV."','Body.php', 'rp=".$realpolitikacode."&do=Comments&action=add&value=".$val."&valuetype=".$valtype."');return false\"><font color=#151B54><B>".$strings["action_addNew"]."</B></font></a></div>";
     
       } else {
      
       $addcomment = "<div style=\"".$divstyle_orange_light."\">".$strings["message_not_logged-in_cant_add"]."</div>";
     
       }

    if ($valtype == 'Search' || $valtype == "MyAgencyTenderComments" || $valtype == "MyPolicyComments" || $valtype == "MyPoliticalPartyComments" || $valtype == "MyConstitutionArticleComments" || $valtype == "MyConstitutionComments" || $valtype == "MyConstitutionComments"){

       $addcomment = "";

       }

     
    $print_vote = $this->funkydone ($_POST,$lingo,'Votes','print_vote',$val,'Comments',$bodywidth);

    echo $print_vote; 

    echo "<BR><img src=images/blank.gif width=500 height=10><BR>";
  
    echo $comments."<P>".$addcomment;

    echo "<BR><img src=images/blank.gif width=500 height=10><BR>";

  // Make Embedded Object Link
    $params = array();
    $params[0] = $comment_title;    
    echo $funky_gear->makeembedd ($do,'view',$val,'id',$params);  
  
//    echo "<BR><img src=images/blank.gif width=500 height=10><BR>";

//    echo $comments."<P>".$addcomment;

//    echo "<BR><img src=images/blank.gif width=500 height=10><BR>";

    ################################
    # Start Comment Comments

    $container = "";  
    $container_top = "";
    $container_middle = "";
    $container_bottom = "";

    $title = $strings["Comments"];

    $container = $funky_gear->make_container ($bodyheight,$bodywidth,$title,'CommentComments');
    $container_top = $container[0];
    $container_middle = $container[1];
    $container_bottom = $container[2];

    echo $container_top;
    
    echo $this->funkydone ($_POST,$lingo,'Comments','list',$val,'Comments',$bodywidth);

    echo $container_bottom;

    # End Comment Comments
    ################################
    
   break; // end view action
   case 'process':


    if ($sent_name == NULL){
       $error = "<font color=red size=2><B>".$strings["SubmissionErrorEmptyItem"].$strings["Name"]."</B></font><BR>";
       }

    if ($sent_description == NULL){
       $error .= "<font color=red size=2><B>".$strings["SubmissionErrorEmptyItem"].$strings["Description"]."</B></font><BR>";
       }

    echo "<div style=\"".$divstyle_blue."\">".$object_return."</div>";

    if (!$error){

//       $sent_description = str_replace("&","and",$sent_description);

       $process_params[] = array('name'=>'id','value' => $sent_id);
       $process_params[] = array('name'=>'name','value' => $sent_name);
       $process_params[] = array('name'=>'assigned_user_id','value' => $sent_assigned_user_id);
       $process_params[] = array('name'=>'contact_id_c','value' => $sess_contact_id);
       $process_params[] = array('name'=>'description','value' => $sent_description);
       $process_params[] = array('name'=>'cmv_countries_id_c','value' => $_POST['cmv_countries_id_c']);
       $process_params[] = array('name'=>'cmv_languages_id_c','value' => $_POST['cmv_languages_id_c']);
       $process_params[] = array('name'=>'cmv_statuses_id_c','value' => $_POST['cmv_statuses_id_c']);

       $process_params[] = array('name'=>'date_entered','value' => $_POST['date_entered']);
       $process_params[] = array('name'=>'date_modified','value' => $_POST['date_modified']);
       $process_params[] = array('name'=>'description','value' => $_POST['description']);
       $process_params[] = array('name'=>'cmv_governmenttypes_id_c','value' => $_POST['cmv_governmenttypes_id_c']);
       $process_params[] = array('name'=>'cmv_governments_id_c','value' => $_POST['cmv_governments_id_c']);
       $process_params[] = array('name'=>'cmv_constitutionalarticles_id_c','value' => $_POST['cmv_constitutionalarticles_id_c']);
       $process_params[] = array('name'=>'cmv_politicalparties_id_c','value' => $_POST['cmv_politicalparties_id_c']);
       $process_params[] = array('name'=>'cmv_constitutionalamendments_id_c','value' => $_POST['cmv_constitutionalamendments_id_c']);
       $process_params[] = array('name'=>'cmv_governmentconstitutions_id_c','value' => $_POST['cmv_governmentconstitutions_id_c']);
       $process_params[] = array('name'=>'cmv_governmentbranches_id_c','value' => $_POST['cmv_governmentbranches_id_c']);
       $process_params[] = array('name'=>'cmv_department_agencies_id_c','value' => $_POST['cmv_department_agencies_id_c']);
       $process_params[] = array('name'=>'cmv_news_id_c','value' => $_POST['cmv_news_id_c']);
       $process_params[] = array('name'=>'cmv_organisations_id_c','value' => $_POST['cmv_organisations_id_c']);
       $process_params[] = array('name'=>'cmv_government_tenders_id_c','value' => $_POST['cmv_government_tenders_id_c']);
       $process_params[] = array('name'=>'cmv_governmentroles_id_c','value' => $_POST['cmv_governmentroles_id_c']);
       $process_params[] = array('name'=>'cmv_branch_departments_id_c','value' => $_POST['cmv_branch_departments_id_c']);
       $process_params[] = array('name'=>'cmv_politicalpartyroles_id_c','value' => $_POST['cmv_politicalpartyroles_id_c']);
       $process_params[] = array('name'=>'cmv_governmentpolicies_id_c','value' => $_POST['cmv_governmentpolicies_id_c']);
       $process_params[] = array('name'=>'cmv_nominees_id_c','value' => $_POST['cmv_nominees_id_c']);    
       $process_params[] = array('name'=>'cmv_events_id_c','value' => $_POST['cmv_events_id_c']);
       $process_params[] = array('name'=>'cmv_content_id_c','value' => $_POST['cmv_content_id_c']);
       $process_params[] = array('name'=>'cmv_bills_id_c','value' => $_POST['cmv_bills_id_c']);
       $process_params[] = array('name'=>'cmv_laws_id_c','value' => $_POST['cmv_laws_id_c']);
       $process_params[] = array('name'=>'cmv_statutes_id_c','value' => $_POST['cmv_statutes_id_c']);
       $process_params[] = array('name'=>'cmv_causes_id_c','value' => $_POST['cmv_causes_id_c']);
       $process_params[] = array('name'=>'sfx_effects_id_c','value' => $_POST['sfx_effects_id_c']);
       $process_params[] = array('name'=>'cmv_lawcases_id_c','value' => $_POST['cmv_lawcases_id_c']);
       $process_params[] = array('name'=>'cmv_comments_id_c','value' => $_POST['cmv_comments_id_c']);
       $process_params[] = array('name'=>'sfx_actions_id_c','value' => $_POST['sfx_actions_id_c']);
       $process_params[] = array('name'=>'cmv_independentagencies_id_c','value' => $_POST['cmv_independentagencies_id_c']);


       $object_type = "Comments";
       $comment_action = "update";

    // Get related objects

       //var_dump($process_params);

       $result = api_sugar ($crm_api_user2, $crm_api_pass2, $crm_wsdl_url2, $object_type, $comment_action, $process_params);

       $process_content = "<font size=2><B>".$strings["Name"].":</B> ".$sent_name."</font><BR>";
       $sent_description = str_replace("\n","<BR>",$sent_description);
       $process_content .= "<font size=2><B>".$strings["Description"].":</B> ".$sent_description."</font><BR>";

       //var_dump($result);

       echo "<div style=\"".$divstyle_white."\">".$process_content."<P>".$object_return_targets."</div>";

       } else {

       echo "<div style=\"".$divstyle_orange."\">".$error."</div>";    

       }

   break; // end process action

  } // end action switch

# break; // End Comments
##########################################################
?>