<?php

/**
 * ArrowPoint class
 *
 * Description: ArrowPoint characteristics
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

 class ArrowPoint {

    public $x;
    public $y;
    public $z;
    public $sinA;
    public $cosA;
    public $g;

    public function calc() {
        $p = new TeePoint(MathUtils::round($this->x * $this->cosA + $this->y * $this->sinA),
              MathUtils::round( -$this->x * $this->sinA + $this->y * $this->cosA));

        return $this->g->calc3DPoint($p->getX(), $p->getY(), $this->z);
    }
}
?>