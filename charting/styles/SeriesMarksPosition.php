<?php

/**
*
* <p>Title: SeriesMarksPosition class</p>
*
* <p>Description: Series Mark Position</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights
* Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class SeriesMarksPosition
{

   public $arrowFix;
   public $arrowFrom = null;
   public $arrowTo = null;
   public $custom = false;
   public $height = 0;
   public $leftTop = null;
   public $width = 0;


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

   public function SeriesMarksPosition()
   {
      $this->arrowFrom = new TeePoint();
      $this->arrowTo = new TeePoint();
      $this->leftTop = new TeePoint();
   }

   /**
   * Returns the bounding rectangle of the indexed Mark.
   *
   * @return Rectangle
   */
   public function getBounds()
   {
      return new Rectangle($this->leftTop->getX(), $this->leftTop->getY(),$this->width, $this->height);
   }

   public function assign($source)
   {
      $this->arrowFrom->setX($source->arrowFrom->getX());
      $this->arrowFrom->setY($source->arrowFrom->getY());
      $this->arrowTo->setX($source->arrowTo->getX());
      $this->arrowTo->setY($source->arrowTo->getY());
      $this->leftTop->setX($source->leftTop->getX());
      $this->leftTop->setY($source->leftTop->getY());
      $this->height = $source->height;
      $this->width = $source->width;
   }
}

?>