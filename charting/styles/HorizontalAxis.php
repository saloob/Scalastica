<?php

/**
*
* <p>Title: HorizontalAxis class</p>
*
* <p>Description: Describes the possible values of Series.HorizAxis.</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class HorizontalAxis
{
   /**
   * Associates the series with the top axis.
   */
   public static $TOP = 0;
   /**
   * Associates the series with the bottom axis.
   */
   public static $BOTTOM = 1;
   /**
   * Associates the series with both the top and bottom axes.
   */
   public static $BOTH = 2;
   /**
   * Associates the series with a custom axis.
   */
   public static $CUSTOM = 3;

   public function HorizontalAxis()    { }

   public function fromInt($value)
   {
      switch($value)
      {
         case 0:
            return self::$TOP;
         case 1:
            return self::$BOTTOM;
         case 2:
            return self::$BOTH;
         default:
            return self::$CUSTOM;
      }
   }
}
?>