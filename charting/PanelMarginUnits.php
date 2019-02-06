<?php

/**
 * PanelMarginUnits class
 *
 * Description: Describes the possible values of Panel.MarginUnits
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

final class PanelMarginUnits {

    private $upperBound=0;
    private $values = Array();

    /**
     * Defines units as a percentage of the panel size.
     */
    public static $PERCENT = 0;

    /**
     * Defines units in pixels.
     */
    public static $PIXELS = 1;

    public function size() {
        return $this->upperBound;
    }

    public function atIndex($index) {
        return $values->get($index);
    }

    function PanelMarginUnits() {
        $this->values = array();
        $this->upperBound++;
        $this->values[] = $this;
    }
}
?>