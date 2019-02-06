<?php

/**
 * Point3D class
 *
 * Description: XYZ Point holder
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Point3D {

    public $x;
    public $y;
    public $z;

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

    public function Point3D($x=0, $y=0, $z=0) {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * The X location in pixels.
     *
     * @return int
     */
    public function getX() {
        return $this->x;
    }

    /**
     * Sets the X location in pixels.
     *
     * @param value int
     */
    public function setX($value) {
        $this->x = $value;
    }

    /**
     * The Y location in pixels.
     *
     * @return int
     */
    public function getY() {
        return $this->y;
    }

    /**
     * Sets the Y location in pixels.
     *
     * @param value int
     */
    public function setY($value) {
        $this->y = $value;
    }

    /**
     * The Z location in pixels.
     *
     * @return int
     */
    public function getZ() {
        return $this->z;
    }

    /**
     * Sets the Z location in pixels.
     *
     * @param value int
     */
    public function setZ($value) {
        $this->z = $value;
    }
}

?>