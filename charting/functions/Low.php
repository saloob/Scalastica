<?php

/**
*
* <p>Title: Low class</p>
*
* <p>Description: Low Function. Returns lowest value.</p>
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $lowFunction = Low();
* $lowFunction->setChart($myChart->getChart());
* $lowFunction->setPeriod(0); //all points
*
* $lineSeries->setDataSource($barSeries);
* $lineSeries->setFunction($lowFunction);
* </font></pre></p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class Low extends Functions
{

   // Interceptors
   function __get($property)
   {
      $method = "get{$property}";
      if(method_exists($this, $method))
      {
         return $this->$method();
      }
   }

   function __set($property, $value)
   {
      $method = "set{$property}";
      if(method_exists($this, $method))
      {
         return $this->$method($value);
      }
   }

   /**
   * Performs function operation on SourceSeries series.<br>
   * First and Last parameters are ValueIndex of first and last point used
   * in calculation. <br>
   * You can override Calculate function to perform customized calculation
   * on one SourceSeries. <br>
   *
   * @param sourceSeries Series
   * @param firstIndex int
   * @param lastIndex int
   * @return double
   */
   public function calculate($sourceSeries, $firstIndex, $lastIndex)
   {
      $v = $this->valueList($sourceSeries);
      if($firstIndex == - 1)
      {
         return $v->getMinimum();
      }
      else
      {
         $result = $v->value[$firstIndex];
         for($t = $firstIndex + 1; $t <= $lastIndex; $t++)
         {
            $tmp = $v->value[$t];
            if($tmp < $result)
            {
               $result = $tmp;
            }
         }
         return $result;
      }
   }

   /**
   * Performs function operation on list of series (SourceSeriesList).
   * The ValueIndex parameter defines ValueIndex of point in each Series in
   * list. <br>
   * You can override CalculateMany function to perform customized
   * calculation on list of SourceSeries.
   *
   * @param sourceSeriesList ArrayList
   * @param valueIndex int
   * @return double
   */
   public function calculateMany($sourceSeriesList, $valueIndex)
   {
      $result = 0;

      for($t = 0; $t < sizeof($sourceSeriesList); $t++)
      {
         $v = $this->valueList($sourceSeriesList->offsetget($t));
         if(sizeof($v) > $valueIndex)
         {
            $tmp = $v->value[$valueIndex];
            if(($t == 0) || ($tmp < $result))
            {
               $result = $tmp;
            }
         }
      }
      return $result;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("FunctionLow");
   }
}
?>