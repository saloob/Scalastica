<?php

/**
 * AnnotationPosition class
 *
 * Description: Describes the possible values of the Annotation.Position
* method
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

class AnnotationPosition
{
   /**
   * Draws the Annotation Tool in the top left of the Chart Panel.
   */
   public static $LEFTTOP = 0;

   /**
   * Draws the Annotation Tool in the bottom left of the Chart Panel.
   */
   public static $LEFTBOTTOM = 1;

   /**
   * Draws the Annotation Tool in the top right of the Chart Panel.
   */
   public static $RIGHTTOP = 2;

   /**
   * Draws the Annotation Tool in the bottom right of the Chart Panel.
   */
   public static $RIGHTBOTTOM = 3;

   function AnnotationPosition() {}
}

?>