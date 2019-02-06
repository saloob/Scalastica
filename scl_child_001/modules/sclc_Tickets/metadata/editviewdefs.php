<?php
// created: 2013-07-25 07:37:18
$viewdefs['sclc_Tickets']['EditView'] = array (
  'templateMeta' => 
  array (
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
      'DEFAULT' => 
      array (
        'newTab' => false,
        'panelDefault' => 'expanded',
      ),
    ),
  ),
  'panels' => 
  array (
    'default' => 
    array (
      0 => 
      array (
        0 => 
        array (
          'name' => 'sclc_tickets_number',
          'type' => 'readonly',
        ),
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
          'name' => 'name',
          'displayParams' => 
          array (
            'size' => 60,
          ),
        ),
      ),
      4 => 
      array (
        0 => 'description',
      ),
      5 => 
      array (
        0 => 'work_log',
      ),
    ),
  ),
);