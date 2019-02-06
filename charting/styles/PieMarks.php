<?php

/**
* <p>Title: PieMarks class</p>
*
* <p>Description: Customized pie series marks with additional properties.</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*
*/

class PieMarks extends TeeBase
{
   private $vertcenter = false;
   private $legsize = 0;

   public $series = null;

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

   /**
   * The class constructor.
   */
   public function PieMarks($c, $s)
   {
      parent::__construct($c);

      if($this->series == null)
      {
         $this->series = $s;
      }
   }

   public function getVertCenter()
   {
      return $this->vertcenter;
   }

   public function setVertCenter($value)
   {
      if($this->vertcenter != $value)
      {
         $this->vertcenter = $value;
         if($this->series != null) $this->series->refreshSeries();
      }
   }

   public function getLegSize()
   {
      return $this->legsize;
   }

   public function setLegSize($value)
   {
      if($this->legsize != $value)
      {
         $this->legsize = $value;
         if($this->series != null) $this->series->refreshSeries();
      }
   }
}

?>