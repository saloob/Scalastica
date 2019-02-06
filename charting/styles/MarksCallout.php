<?php

/**
*
* <p>Title: MarksCallout class</p>
*
* <p>Description: </p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. </p>
* <p>All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*/

class MarksCallout extends Callout
{

   protected $length = 8;
   private $defaultLength=0;

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

   public function MarksCallout($s)
   {
      parent::Callout($s);
      
      $this->readResolve();
      $this->setDefaultVisible(false);
   }

   protected function readResolve()
   {
      $this->defaultLength = 8;
      return parent::readResolve();
   }

   /**
   * Length between series data points and Marks.
   *
   * @return int
   */
   public function getLength()
   {
      return $this->length;
   }

   /**
   * Specifies the Length between series data points and Marks.
   *
   * @param value int
   */
   public function setLength($value)
   {
      if($this->length != $value)
      {
         $this->length = $value;
         $this->invalidate();
      }
   }

   function setDefaultLength($value)
   {
      $this->defaultLength = $value;
      $this->length = $value;
   }

}

?>