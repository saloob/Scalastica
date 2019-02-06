<?php

/**
 * Footer class
 *
 * Description:Text displayed below Chart
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Footer extends Title
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

   public function Footer($c)
   {
      parent::Title($c);

      TChart::$controlName .= 'Footer_';        
              
      $tmpColor = new Color(255, 0, 0);// RED
      $this->getFont()->getBrush()->setDefaultColor($tmpColor);
      $this->onTop = false;
   }

   protected function readResolve()
   {
      $this->onTop = false;
      return $this;
   }

}
?>