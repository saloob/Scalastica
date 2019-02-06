<?php

 /**
 * AxisLinePen class
 *
 * Description: Determines the pen used to draw the axis lines
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

class AxisLinePen extends ChartPen
{
   /**
   * The class constructor.
   */
   public function AxisLinePen($c)
   {
      $tmpColor = new Color(0, 0, 0);
      parent::ChartPen($c, $tmpColor, true, 2);
   }
}
?>