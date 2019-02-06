<?php

/**
  * <p>Title: PieAngle class</p>
  *
  * <p>Description: </p>
  *
  * <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
  * Reserved.</p>
  *
  * <p>Company: Steema Software SL</p>
  *
  */

 class PieAngle {

    public $StartAngle;
    public $EndAngle;
    public $MidAngle;

    public function contains($value) {
        return ($value>=$this->StartAngle) && ($value<=$this->EndAngle);
    }
 }

?>