<?php

/**
  *
  * <p>Title: ZoomDirections class</p>
  *
  * <p>Description: Describes the possible values of Zoom.Direction method.</p>
  *
  * <p>Copyright (c) 2005-2010 by Steema Software SL. All Rights
  * Reserved.</p>
  *
  * <p>Company: Steema Software SL</p>
  */

 class ZoomDirections {
    /**
    * Allows only Horizontal Zooming.
    */
    public $HORIZONTAL = 0;
    /**
    * Allows only Vertical Zooming.
    */
    public $VERTICAL = 1;
    /**
    * Allows both Horizontal and Vertical Zooming.
    */
    public $BOTH = 2;

    public function ZoomDirections($value) {
    }
}
?>