<?php

 /**
 * AxisLabelStyle class
 *
 * Description: Defines the possible values of Axis->getLabels()->getStyle()
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class AxisLabelStyle
{

   /**
   * Chooses the Style automatically
   */
   public static $AUTO = 0;

   /**
   * No label. This will trigger the event with empty strings
   */
   public static $NONE = 1;

   /**
   * Axis labeling is based on axis Minimum and Maximum properties.
   */
   public static $VALUE = 2;

   /**
   * Each Series point will have a Label using SeriesMarks style.
   */
   public static $MARK = 3;

   /**
   * Each Series point will have a Label using Series.XLabels strings
   */
   public static $TEXT = 4;

   public function AxisLabelStyle()
   {
   }

   public function fromValue($value)
   {
      switch ($value)
      {
         case 0:
            return self::$AUTO;
         case 1:
            return self::$NONE;
         case 2:
            return self::$VALUE;
         case 3:
            return self::$MARK;
         default :
            return self::$TEXT;
      }
   }
}

?>