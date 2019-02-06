<?php



/**
  *
  * <p>Title: HorizLine class</p>
  *
  * <p>Description: Horizontal Line Series.</p>
  *
  * <p>Example:
  * <pre><font face="Courier" size="4">
  *  lineSeries = new com.steema.teechart.styles.HorizLine(myChart.getChart());
  *  lineSeries.fillSampleValues(8);
  *  lineSeries.getPointer().setVisible(true);
  * </font></pre></p>
  *
  * <p>Copyright (c) 2005-2007 by Steema Software SL. All Rights
  *  Reserved.</p>
  *
  * <p>Company: Steema Software SL</p>
  *
  */
 class HorizLine extends Line {

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


    public function HorizLine($c=null) {
        parent::Line($c);
        
        $this->setHorizontal();
        $this->getPointer()->setDefaultVisible(false);
        $this->calcVisiblePoints = false;
        $this->getXValues()->setOrder(ValueListOrder::$NONE);
        $this->getYValues()->setOrder(ValueListOrder::$ASCENDING);
    }

        /**
          * Gets descriptive text.
          *
          * @return String
          */
    public function getDescription() {
        return Language::getString("GalleryHorizLine");
    }
}

?>
