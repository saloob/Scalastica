<?php

/**
*
* <p>Title: BarStyle class</p>
*
* <p>Description: Describes the possible values of the CustomBar setBarStyle
* method</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $barSeries = new Bar($myChart->getChart());
* $barSeries->setBarStyle(BarStyle::$CONE);
* $barSeries->getMarks()->setVisible(true);
* $barSeries->getMarks()->setStyle(MarksStyle::$VALUE);
* $barSeries->fillSampleValues(5);
* $barSeries->setConePercent(30);
* </font></pre></p>
*
*/

class BarStyle
{
   /**
   * Defines a rectangle shape for each bar series point.
   */
   public static $RECTANGLE = 0;

   /**
   * Defines a pyramid shape for each bar series point.
   */
   public static $PYRAMID = 1;

   /**
   * Defines an inverted pyramid shape for each bar series point.
   */
   public static $INVPYRAMID = 2;

   /**
   * Defines a cylinder shape for each bar series point.
   */
   public static $CYLINDER = 3;
   /**
   * Defines an ellipse shape for each bar series point.
   */
   public static $ELLIPSE = 4;

   /**
   * Defines an arrow shape for each bar series point.
   */
   public static $ARROW = 5;

   /**
   * Defines a cone shape for each bar series point.
   */
   public static $CONE = 6;

   /**
   * Defines an inverted arrow shape for each bar series point.
   */
   public static $INVARROW = 7;

   /**
   * Defines an inverted cone shape for each bar series point.
   */
   // TODO public static $INVCONE = 8;

   /**
   * Defines a rectangle shape with a gradient for each bar series point.
   */
   // TODO public static $RECTGRADIENT = 9;
   

   public function BarStyle()
   {
   }

   public function fromValue($value)
   {
      switch ($value)
      {
         case 0:
            return self::$RECTANGLE;
         case 1:
            return self::$PYRAMID;
         case 2:
            return self::$INVPYRAMID;
         case 3:
            return self::$CYLINDER;
         case 4:
            return self::$ELLIPSE;
         case 5:
            return self::$ARROW;
         case 6:
            return self::$RECTGRADIENT;
         case 7:
            return self::$CONE;
         case 8:
            return self::$INVARROW;
         default :
            return self::$RECTANGLE;
      }
   }
}

?>