<?php


/**
  *
  * <p>Title: MultiAreas class</p>
  *
  * <p>Description: Describes the possible values of Area.MultiArea.</p>
  *
  * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights Reserved.</p>
  *
  * <p>Company: Steema Software SL</p>
  *
  * @see com.steema.teechart.styles.Area#getMultiArea
  */

 class MultiAreas {
    /**
    * Areas will be drawn one behind the other.
    */
    public static $NONE = 0;
    /**
    * Draws each Area on top of previous one.
    */
    public static $STACKED = 1;
    /**
    * Adjusts each individual point to a common 0..100 axis scale.
    */
    public static $STACKED100 = 2;

    private function MultiAreas() {}
}
?>