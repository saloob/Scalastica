<?php

 /**
 * LineCap class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

 class LineCap {

    /**
      * Defines a beveled union style between line segments
      */
    public static $BEVEL = 0; // BasicStroke.JOIN_BEVEL

    /**
      * Defines a miter union style between line segments
      */
    public static $MITER = 1; //BasicStroke.JOIN_MITER

    /**
      * Defines a round union style between line segments
      */
    public static $ROUND = 2; //BasicStroke.JOIN_ROUND

    public function LineCap() {
    }

    public function fromValue($value) {
        switch ($value) {
        case 0:
            return self::$BEVEL;
        case 1:
            return self::$MITER;
        default:
            return self::$ROUND;
        }
    }
}

?>