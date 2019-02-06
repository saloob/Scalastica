<?php

/**
*
* <p>Title: MarksStyle class</p>
*
* <p>Description: Describes the possible values of Series Marks Style.</p>
*
* @see SeriesMarks#getStyle
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*/

class MarksStyle
{
   /**
   * Shows the point value.
   */
   public static $VALUE = 0;
   /**
   * Shows the percent the point value represents.
   */
   public static $PERCENT = 1;
   /**
   * Shows the associated Point Label.
   */
   public static $LABEL = 2;
   /**
   * Shows the point Label and the percent value the point represents.
   */
   public static $LABELPERCENT = 3;
   /**
   * Shows the point Label and the point value.
   */
   public static $LABELVALUE = 4;
   /**
   * Shows whatever is shown at Chart Legend.
   */
   public static $LEGEND = 5;
   /**
   * Shows the percent the point represents together with the "of" word and
   * the sum of all points absolute values.
   */
   public static $PERCENTTOTAL = 6;
   /**
   * Shows the point Label toghether with the resulting "PercentTotal" style.
   */
   public static $LABELPERCENTTOTAL = 7;
   /**
   * Shows the point XValue.
   */
   public static $XVALUE = 8;
   /**
   * Shows the point XValue and YValue.
   */
   public static $XY = 9;

   private function MarksStyle(/*$value*/)
   {
   //   parent::MarksStyle($value);
   }

   public function fromInt($value)
   {
      switch($value)
      {
         case 0:
            return self::$VALUE;
         case 1:
            return self::$PERCENT;
         case 2:
            return self::$LABEL;
         case 3:
            return self::$LABELPERCENT;
         case 4:
            return self::$LABELVALUE;
         case 5:
            return self::$LEGEND;
         case 6:
            return self::$PERCENTTOTAL;
         case 7:
            return self::$LABELPERCENTTOTAL;
         case 8:
            return self::$XVALUE;
         default:
            return self::$XY;
      }
   }
}

?>