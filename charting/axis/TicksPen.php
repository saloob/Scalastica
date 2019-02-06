<?php

 /**
 * TicksPen class
 *
 * Description: Determines the kind of Pen used to draw Axis marks along
 * the Axis line
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */


class TicksPen extends ChartPen
{

   public $length;// TODO  protected
   public $defaultLength;// TODO  protected


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
   public function TicksPen($c)
   {
      parent::ChartPen($c);
      $tmpColor = new Color(120, 120, 120);// DARK_GRAY
      $this->setDefaultColor($tmpColor);
   }

   private function shouldSerializeLength()
   {
      return $this->length != $this->defaultLength;
   }

   /**
   * Length of Axis Ticks in pixels.
   *
   * @return int
   */
   public function getLength()
   {
      return $this->length;
   }

   /**
   * Sets the length of Axis Ticks in pixels.
   *
   * @param value int
   */
   public function setLength($value)
   {
      $this->length = $this->setIntegerProperty($this->length, $value);
   }
}

?>