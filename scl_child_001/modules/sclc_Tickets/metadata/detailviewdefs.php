<?php
// created: 2013-07-25 07:37:18
$viewdefs['sclc_Tickets']['DetailView'] = array (
  'templateMeta' => 
  array (
    'form' => 
    array (
      'buttons' => 
      array (
        0 => 'EDIT',
        1 => 'DUPLICATE',
        2 => 'DELETE',
        3 => 'FIND_DUPLICATES',
      ),
    ),
    'maxColumns' => '2',
    'widths' => 
    array (
      0 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
      1 => 
      array (
        'label' => '10',
        'field' => '30',
      ),
    ),
    'tabDefs' => 
    array (
      1 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      2 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      3 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      4 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      5 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
      6 => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    0 => 
    array (
      0 => 'sclc_tickets_number',
      1 => 'assigned_user_name',
    ),
    1 => 
    array (
      0 => 'priority',
    ),
    2 => 
    array (
      0 => 'resolution',
      1 => 'status',
    ),
    3 => 
    array (
      0 => 
      array (
        'name' => 'date_entered',
        'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
        'label' => 'LBL_DATE_ENTERED',
      ),
      1 => 
      array (
        'name' => 'date_modified',
        'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
        'label' => 'LBL_DATE_MODIFIED',
      ),
    ),
    4 => 
    array (
      0 => 
      array (
        'name' => 'name',
        'label' => 'LBL_SUBJECT',
      ),
    ),
    5 => 
    array (
      0 => 'description',
    ),
    6 => 
    array (
      0 => 'work_log',
    ),
  ),
);