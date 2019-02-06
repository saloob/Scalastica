<?php

/**
 * Divide class
 *
 * Description: Divide Function
 *
 * Example:
 * $divideFunction = new Divide();
 * $divideFunction->setChart($myChart->getChart());
 * $divideFunction->setPeriod(0); //all points
 *
 * $tmpArray = Array();
 * $tmpArray->add($barSeries1);
 * $tmpArray->add($barSeries2);
 * $lineSeries->setDataSource($tmpArray);
 * $lineSeries->setFunction($divideFunction);
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage functions
 * @link http://www.steema.com
 */

class Divide extends ManySeries
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
      return($value == 0) ? $result : $result / $value;
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("FunctionDivide");
   }
}
?>