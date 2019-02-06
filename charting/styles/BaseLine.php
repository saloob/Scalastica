<?php
/**
 *
 * <p>Title: BaseLine class</p>
 *
 * <p>Description: Abstract Series class inherited by a number of TeeChart
 * series styles.</p>
 *
 * <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
 * Reserved.</p>
 *
 * <p>Company: Steema Software SL</p>
 *
 */

abstract class BaseLine extends Series {

    protected $linePen;

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

    protected function BaseLine($c=null) {
        parent::Series($c);
    }

    public function assign($source) {
        if ($source instanceof BaseLine) {
            $tmp = $source;
            if ($tmp->linePen != null) {
                $this->getLinePen()->assign($tmp->linePen);
            }
        }
        parent::assign($source);
    }

    public function setChart($c) {
        parent::setChart($c);
        $this->getLinePen()->setChart($c);
    }

    /**
     * Determines pen to draw the line connecting all points.<br>
     *
     * @return ChartPen
     */
    public function getLinePen() {
        if ($this->linePen == null) {
            $this->linePen = new ChartPen($this->chart, new Color (0,0,0,0,true));
        }
        return $this->linePen;
    }
}
?>