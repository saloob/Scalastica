<?php

 /**
 * EventHandler class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */

class EventHandler {

     private $event;
     private $callback;

     public function GetEventName()
     {
          return $this->event->GetName();
     }

     public function __construct($event, $callback)
     {
          $this->event = $event;
          $this->callback = $this->PrepareCallback($callback);
     }

     public function Raise($sender, $args)
     {
          if ($this->callback)
              eval($this->callback);
     }

     private function PrepareCallback($callback)
     {
          if ($pos = strpos($callback, '('))
              $callback = substr($callback, 0, $pos);

          $callback .= '($sender, $args);';

          return $callback;
     }
}
?>