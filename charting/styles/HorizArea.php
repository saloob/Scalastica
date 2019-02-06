<?php

/**
*
* <p>Title: HorizArea class</p>
*
* <p>Description: HorizArea series.</p>
*
*  <p>Example:
*  <pre><font face="Courier" size="4">
*  areaSeries = new com.steema.teechart.styles.HorizArea(myChart.getChart());
*  areaSeries.setStairs(false);
*  areaSeries.getPointer().setVisible(false);
*  areaSeries.fillSampleValues(6);
*  </font></pre></p>
*
*  <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
*  Reserved.</p>
*
* <p>Company: Steema Software SL</p><br>

*/

class HorizArea extends Area
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

   public function HorizArea($c = null)
   {
      parent::Area($c);
      
      $this->setHorizontal();
      $this->getXValues()->setOrder(ValueListOrder::$NONE);
      $this->getYValues()->setOrder(ValueListOrder::$ASCENDING);
      /* TODO
      $tmpGradientDirection = new GradientDirection();
      $this->getGradient()->setDirection($tmpGradientDirection->HORIZONTAL);
      */
   }

   protected function numSampleValues()
   {
      return 10;
   }

   protected function drawMark($valueIndex, $st, $aPosition)
   {
      $difH = $aPosition->height / 2;
      $difW = $this->getMarks()->getCallout()->getLength() + $this->getMarks()->getCallout()->getDistance();

      $aPosition->leftTop->setY($aPosition->arrowTo->getY() - $difH);
      $aPosition->leftTop->setX($aPosition->leftTop->getX() + $difW + ($aPosition->width / 2));
      $aPosition->arrowTo->setX($aPosition->arrowTo->getX() + $difW);
      $aPosition->arrowFrom->setY($aPosition->arrowTo->getY());

      $aPosition->arrowFrom->setX($aPosition->arrowFrom->getX() + $this->getMarks()->getCallout()->getDistance());

      parent::drawMark($valueIndex, $st, $aPosition);
   }

   /**
   * Gets descriptive text.
   *
   * @return String
   */
   public function getDescription()
   {
      return Language::getString("HorizAreaSeries");
   }
}

?>