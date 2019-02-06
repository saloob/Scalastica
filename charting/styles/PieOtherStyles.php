<?php

/**
*
* <p>Title: PieOtherStyles class</p>
*
* <p>Description: Describes the possible values of the Style method of
* Pie.PieOtherSlice class.</p>
*
* <p>Copyright (c) 2005-2010 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*
* @see com.steema.teechart.styles.Pie.PieOtherSlice
*/

class PieOtherStyles
{
   /**
   * No "Other" slice is generated. (default)
   */
   public static $NONE = 0;
   /**
   * Slices with values below a percentage are grouped.
   */
   public static $BELOWPERCENT = 1;
   /**
   * Slices with values below a value are grouped.
   */
   public static $BELOWVALUE = 2;

   function PieOtherStyles() {}
}
?>