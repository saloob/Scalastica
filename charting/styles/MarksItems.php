<?php

/**
 * MarksItems class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MarksItems extends ArrayObject
{

   public /*protected*/ $iMarks;

   // Will be used when saving the items for design time
   public /*protected*/ $iLoadingCustom = false;

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

   public function __construct($s)
   {
      parent::__construct();
   }

   /**
   * Returns the formatting object for the Index'th mark.
   *
   * @param index int
   * @return MarksItem
   */
   public function getItem($index)
   {
      while($index >= sizeof($this))
      {
         $this->add(null);
      }

      if (!isset($this[$index]))
      {
         $tmp = new MarksItem($this->iMarks->chart);

         //$tmp->getShadow()->setDefaultVisible(true);
         //$tmp->getShadow()->setSize(1);
         $tmpColor = new Color(130, 130, 130);// GRAY
         $tmp->getShadow()->setColor($tmpColor);
         $this[$index]=$tmp;
      }

      return $this[$index];
      //parent::offsetget($index);
   }

   public function clear()
   {
      unset($this);
// tODO review      $this->iMarks->invalidate();
   }
}
?>