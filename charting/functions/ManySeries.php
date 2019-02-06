<?php

/**
*
* <p>Title: ManySeries class</p>
*
* <p>Description: Internal use. Base class for multiple Series function
* calculations</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class ManySeries extends Functions
{

   protected function calculateValue($result, $value) {
      return 0;
   }


   /**
   * Performs function operation on list of series (SourceSeriesList).<br>
   * The ValueIndex parameter defines ValueIndex of point in each Series
   * in list. <br>
   * You can override CalculateMany function to perform customized
   * calculation on list of SourceSeries. <br>
   *
   * @param sourceSeries ArrayList
   * @param valueIndex int
   * @return double
   */
   public function calculateMany($sourceSeries, $valueIndex) {
      $tmpFirst = true;
      $result = 0;

      for($t = 0; $t < sizeof($sourceSeries); $t++) {
         $v = $this->valueList($sourceSeries[$t]);
         if($v->count > $valueIndex){
            if($tmpFirst) {
               $result = $v->value[$valueIndex];
               $tmpFirst = false;
            }
            else {
               $result = $this->calculateValue($result, $v->value[$valueIndex]);
            }
         }
      }
      return $result;
   }
}

?>