<?php

/**
 * DashStyle class
 *
 * Description: Dash styles
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

class DashStyle
{

   public static $SOLID = 0;
   public static $DOT = 1;
   public static $DASH = 2;
   public static $DASHDOT = 3;
   public static $DASHDOTDOT = 4;

   /**
   * The class constructor.
   */
   public function DashStyle()    {}

   public function fromValue($value)
   {
      switch($value)
      {
         case 0:
            return self::$SOLID;
         case 1:
            return Self::$DOT;
         case 2:
            return self::$DASH;
         case 3:
            return self::$DASHDOT;
         default:
            return self::$DASHDOTDOT;
      }
   }

   /**  TODO
   * Returns an array of values that determines the number of filled and
   * non-filled pixels of the Pen dash.
   *
   * @return float[]

   public function getDash() {
   switch ($this->getValue()) {
   case 1:
   return new float[] {$this->dashWidth, $this->dashWidth};
   case 2:
   return new float[] {$this->dashWidth * 3, $this->dashWidth};
   case 3:
   return new float[] {$this->dashWidth * 3, $this->dashWidth, $this->dashWidth, $this->dashWidth};
   case 4:
   return new float[] {$this->dashWidth * 3, $this->dashWidth, $this->dashWidth, $this->dashWidth, $this->dashWidth, $this->dashWidth};
   default:
   return new float[] {1};
   }
   }
   */
}

?>