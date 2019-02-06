<?php

 /**
 * EventHandlerCollection class
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

class EventHandlerCollection {
     private $handlers;

     public function __construct()
     {
          $this->handlers = new ArrayObject();
     }

     public function Add($handler)
     {
          $this->handlers->Append($handler);
     }

     public function RaiseEvent($event, $sender, $args)
     {
          foreach ($this->handlers as $handler)
          {
              if ($handler->GetEventName() == $event)
                   $handler->Raise($sender, $args);
          }
     }
}
?>