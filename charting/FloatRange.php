<?php

/**
 * FloatRange class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class FloatRange {

    public $min;
    public $max;

    public function FloatRange($min=0, $max=0) {
        $this->min = $min;
        $this->max = $max;
    }
}
?>