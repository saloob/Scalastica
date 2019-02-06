<?php


/**
  *
  * <p>Title: SeriesEventStyle class</p>
  *
  * <p>Description: For internal use by Series instances to notify changes.</p>
  *
  * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights Reserved.</p>
  *
  * <p>Company: Steema Software SL</p>
  *
  */
 class SeriesEventStyle /*extends Enum*/ {

    public $ADD = 0;
    public $REMOVE = 1;
    public $REMOVEALL = 2;
    public $CHANGETITLE = 3;
    public $CHANGECOLOR = 4;
    public $SWAP = 5;
    public $CHANGEACTIVE = 6;
    public $DATACHANGED = 7;

    public function SeriesEventStyle() {

       // parent::Enum;
    }
}

?>