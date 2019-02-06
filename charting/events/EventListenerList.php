<?php

 /**
 * EventListenerList class
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

class EventListenerList {
/* todo remove

  protected $listeners = array();

  function add($listener) {
    $this->listeners[] = $listener;
  }

  function getRaw() {
    return $this->listeners;
  }
*/

     private $events;

     public function __construct()
     {
          $this->events = new ArrayObject();
     }

     public function Add($event)
     {
          if (!$this->Contains($event))
              $this->events->Append($event);
     }

     public function Contains($event)
     {
          foreach ($this->events as $e)
          {
              if ($e->GetName() == $event)
                   return true;
          }
     }

}
?>