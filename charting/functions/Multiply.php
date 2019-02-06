<?php

/**
*
* <p>Title: Multiply class</p>
*
* <p>Description: Multiply Function.</p>
*
* <p>Example:
* <pre><font face="Courier" size="4">
* $multiplyFunction = new Multiply();
* $multiplyFunction->setChart($myChart->getChart());
* $multiplyFunction->setPeriod(0); //all points
*
* $tmp={$barSeries1,$barSeries2};
* $lineSeries->setDataSource($tmp);
*
* $lineSeries->setFunction($multiplyFunction);
* </font></pre></p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class Multiply extends ManySeries
{
    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

   protected function calculateValue($result, $value)
   {
      return $result * $value;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("FunctionMultiply");
   }
}
?>