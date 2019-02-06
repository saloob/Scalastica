<?php

/**
 * ToolSeries class
 *
 * Description: Base abstract class for Tool components with a Series method
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage tools
 * @link http://www.steema.com
 */

 class ToolSeries extends Tool {

    protected $iSeries;

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

    protected function ToolSeries($c=null,$s=null) {
        if ($s != null)
        {
           parent::Tool($s->getChart());
           $this->iSeries = $s;
        }
        else
          parent::Tool($c);
            
    }

    /**
    * Returns the associated Top or Bottom Chart Horizontal Axis.
    *
    * @return Axis
    */
    public function getHorizAxis() {
        return ($this->iSeries == null) ? $this->chart->getAxes()->getBottom() : $this->iSeries->getHorizAxis();
    }

    /**
    * Returns the associated Left or Right Chart Vertical Axis.
    *
    * @return Axis
    */
    public function getVertAxis() {
        return ($this->iSeries == null) ? $this->chart->getAxes()->getLeft() : $this->iSeries->getVertAxis();
    }

    /**
    * The Series with which Tools are associated.<br>
    * Default value: null
    *
    * @return Series
    */
    public function getSeries() {
        return $this->iSeries;
    }

    /**
    * Sets the Series with which Tools are associated.<br>
    * Default value: null
    *
    * @param value Series
    */
    public function setSeries($value) {
        $this->iSeries = $value;
        $this->invalidate();
    }
}

?>