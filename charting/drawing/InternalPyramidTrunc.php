<?php

/**
 * InternalPyramidTrunc Class
 *
 * Description:
 *
 * @author
 * @copyright Copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage drawing
 * @link http://www.steema.com
 */

 class InternalPyramidTrunc {

   // TODO review protected
    public /*protected*/ $r;
    protected $midX;
    protected $midZ;
    public /*protected*/ $truncX;
    public /*protected*/ $truncZ;
    public /*protected*/ $startZ;
    public /*protected*/ $endZ;
    protected $g;

    private function frontWall($startZ, $endZ) {
        $p = Array(new TeePoint($this->midX - $this->truncX, $this->r->y),
                   new TeePoint($this->midX + $this->truncX, $this->r->y),
                   new TeePoint($this->r->getRight(), $this->r->getBottom()),
                   new TeePoint($this->r->x, $this->r->getBottom()));

        $this->g->planeFour3D($startZ, $endZ, $p);
    }

    private function sideWall($horizPos1, $horizPos2, $startZ, $endZ) {
        $tmp = Array($this->g->calc3DPoint($horizPos2, $this->r->y, $this->midZ - $this->truncZ),
                      $this->g->calc3DPoint($horizPos2, $this->r->y, $this->midZ + $this->truncZ),
                      $this->g->calc3DPoint($horizPos1, $this->r->getBottom(), $endZ),
                      $this->g->calc3DPoint($horizPos1, $this->r->getBottom(), $startZ)
        );
        $this->g->polygon($tmp);
    }

    private function bottomCover() {
        $this->g->rectangleY($this->r->x, $this->r->getBottom(), $this->r->getRight(), $this->startZ, $this->endZ);
    }

    private function topCover() {
        if ($this->truncX != 0) {
            $this->g->rectangleY($this->midX - $this->truncX, $this->r->y, $this->midX + $this->truncX, $this->midZ - $this->truncZ,
                         $this->midZ + $this->truncZ);
        }
    }

    public function draw($gr) {
        $this->g = $gr;
        $this->midX = ($this->r->x + $this->r->getRight()) / 2;
        $this->midZ = ($this->startZ + $this->endZ) / 2;

        if ($this->r->getBottom() > $this->r->y) {
            $this->bottomCover();
        } else {
            $this->topCover();
        }

        $this->frontWall($this->midZ + $this->truncZ, $this->endZ);
        $this->sideWall($this->r->x, $this->midX - $this->truncX, $this->startZ, $this->endZ);
        $this->frontWall($this->midZ - $this->truncZ, $this->startZ);
        $this->sideWall($this->r->getRight(), $this->midX + $this->truncX, $this->startZ, $this->endZ);

        if ($this->r->getBottom() > $this->r->y) {
            $this->topCover();
        } else {
            $this->bottomCover();
        }
    }
}
?>