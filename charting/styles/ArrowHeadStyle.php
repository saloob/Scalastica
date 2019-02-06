<?php

/**
 * ArrowHeadStyle Class
 *
 * Description: Arrow head styles
 *
 * @author
 * @copyright Copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class ArrowHeadStyle {

   /**
   * Do not display an arrow head.
   */
   public static $NONE = 0;

   /**
   * Display an arrow head made with two lines.
   */
   public static $LINE = 1;

   /**
   * Display a filled arrow head.
   */
   public static $SOLID = 2;

   public function ArrowHeadStyle()
   {}

   public function fromValue($value)
   {
      switch($value)
      {
         case 0:
            return self::$NONE;
         case 1:
            return self::$LINE;
         default:
            return self::$SOLID;
      }
   }
}
?>