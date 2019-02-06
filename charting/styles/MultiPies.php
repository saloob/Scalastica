<?php

/**
* <p>Title: MultiPies - enum constants</p>
*
* <p>Description: </p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class MultiPies
{
   /**
   * Multiple Pie series are displayed using an automatically
   * calculated chart space portion. (default)
   */
   public static $AUTOMATIC = 0;
   /**
   * Multiple Pie series are displayed using custom manual ChartRect
   * positions, or overlapped.
   */
   public static $DISABLED = 1;

   function MultiPies() {}
}
?>