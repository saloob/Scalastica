<?php

/**
*
* <p>Title: PeriodAlign class</p>
*
* <p>Description: Descibes how a function is aligned with respect to the
* source series.</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*/

class PeriodAlign
{
   /**
   * Aligns the function with the first point of the function period.
   */
   public static $FIRST = 0;
   /**
   * Aligns the function with the centre point of the function period.
   */
   public static $CENTER = 1;
   /**
   * Aligns the function with the last point of the function period.
   */
   public static $LAST = 2;

   public function PeriodAlign()   {}
}
?>