<?php

 /**
 * DepthAxis class
 *
 * Description: Z plane Axis characteristics.
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage axis
 * @link http://www.steema.com
 */

 class DepthAxis extends Axis {

    /**
    * The class constructor.
    */
    public function DepthAxis($horiz, $isOtherSide, $c) {
        parent::Axis($horiz, $isOtherSide, $c);

        $this->isDepthAxis = true;
        $this->bVisible = false;
    }
}

?>