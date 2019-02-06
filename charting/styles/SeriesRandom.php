<?php


/**
* <p>Title: SeriesRandom class</p>
*
* <p>Description: </p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class SeriesRandom
{
   /**
   * Used internally to add random values to a series.
   */
   // private $r;  TODO remove

   public $tmpX;
   public $StepX;
   public $tmpY;
   public $MinY;
   public $DifY;

   public function Random()
   {
      return (rand()%100);
   }

   public function SeriesRandom()   {}
}
?>