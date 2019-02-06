<?php

/**
 * ShapeBorders class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class ShapeBorders extends TeeBase {

    private $topLeft;
    private $bottomLeft;
    private $topRight;
    private $bottomRight;
    private $visible=false;

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

    public function __construct($c) {
        parent::__construct($c);
       
        $this->topLeft = new TopLeftBorder($c, $this);
        $this->bottomLeft = new BottomLeftBorder($c, $this);
        $this->topRight = new TopRightBorder($c, $this);
        $this->bottomRight = new BottomRightBorder($c, $this);
    }


    public function getTopLeft() {
        return $this->topLeft;
    }

    public function getBottomLeft() {
        return $this->bottomLeft;
    }

    public function getTopRight() {
        return $this->topRight;
    }

    public function getBottomRight() {
        return $this->bottomRight;
    }

    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($value) {
        $this->visible = $this->setBooleanProperty($this->visible, $value);
    }
}


class TopLeftBorder extends ShapeBorder {

        function __construct($c, $b) {
            parent::__contruct();
        }

}

class BottomLeftBorder extends ShapeBorder {

        function __construct($c, $b) {
            parent::__contruct();
        }

}

class TopRightBorder extends ShapeBorder {

        function __construct($c, $b) {
            parent::__contruct();
        }

}

class BottomRightBorder extends ShapeBorder {

        function __construct($c, $b) {
            parent::__contruct();
        }
        
}


class ShapeBorder  {

        protected $bBorderRound=0;

        function __contruct() {}

        // Radius border
        public function getBorderRound() {
            return $this->bBorderRound;
        }

        public function setBorderRound($value) {
            $this->bBorderRound=$value;
        }
}

?>