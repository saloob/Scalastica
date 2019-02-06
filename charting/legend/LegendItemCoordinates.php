<?php

/**
 * LegendItemCoordinates class
 *
 * Description: Legend Position
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage legend
 * @link http://www.steema.com
 */

class LegendItemCoordinates
{

   public $xColor;
   private $idx;
   private $x, $y;

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

   /**
   * The class constructor.
   */
   public function LegendItemCoordinates($index, $x, $y, $xColor)
   {
      $this->idx = $index;
      $this->x = $x;
      $this->y = $y;
      $this->xColor = $xColor;
   }

   /* todo public function LegendItemCoordinates($c) {
   parent::();
   $this->idx = $c->getIndex();
   $this->x = $c->getX();
   $this->y = $c->getY();
   $this->xColor = $c->getXColor();
   }       */

   /**
   * The Index of the Legend item.
   *
   * @return int
   */
   public function getIndex()
   {
      return $this->idx;
   }
   /**
   * The specific X coordinate of the Legend item.
   *
   * @return int
   */
   public function getX()
   {
      return $this->x;
   }

   /**
   * Sts the specific X coordinate of the Legend item.
   *
   * @param value int
   */
   public function setX($value)
   {
      $this->x = $value;
   }
   /**
   * The specific Y coordinate of the Legend item.
   *
   * @return int
   */
   public function getY()
   {
      return $this->y;
   }

   /**
   * Sets the specific Y coordinate of the Legend item.
   *
   * @param value int
   */
   public function setY($value)
   {
      $this->y = $value;
   }
   /**
   * The specific XColor coordinate of the Legend item.
   *
   * @return int
   */
   public function getXColor()
   {
      return $this->xColor;
   }

   /**
   * Sets the specific XColor coordinate of the Legend item.
   *
   * @param value int
   */
   public function setXColor($value)
   {
      $this->xColor = $value;
   }
}

?>