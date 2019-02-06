<?php

/**
*
* <p>Title: ShapeXYStyle class</p>
*
* <p>Description: Describes the possible values of the Shape.XYStyle
* method.</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class ShapeXYStyle
{
   /**
   * Position relative to Chart Panel. 0,0 is Panel Left, Top.
   */
   public static $PIXELS = 0;
   /**
   * Position in Axis units.
   */
   public static $AXIS = 1;
   /**
   * Use Left,Top (X0,Y0) to set the Axis origin in Axis units. Right,
   * Bottom sets width and height in Pixels.
   */
   public static $AXISORIGIN = 2;

   public function ShapeXYStyle() {}
}
?>