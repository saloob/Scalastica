<?php

/**
 * ValueListOrder class
 *
 * Description: Describes the possible values of the ValueList.Order
 * method
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class ValueListOrder
{
   /**
   * Values are ordered in the order in which they were added to the
   * ValueList.
   */
   public static $NONE = 0;
   /**
   * Values are ordered in ascending numerical order.
   */
   public static $ASCENDING = 1;
   /**
   * Values are ordered in descending numerical order.
   */
   public static $DESCENDING = 2;

   public function ValueListOrder() {}
}

?>