<?php

/**
 * ValuesLists class
 *
 * Description: ValueLists is a collection of ValueList objects.
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

 class ValuesLists extends ArrayObject {

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

    public function getValueList($index) {
        return parent::offsetGet($index);
    }

    public function indexOf($value) {
        for ( $t = 0; $t < sizeof($this); $t++) {
            if ($this->getValueList($t) == $value) {
                return $t;
            }
        }
        return -1;
    }
}
?>