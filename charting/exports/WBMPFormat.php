<?php

 /**
 * WBMPFormat class
 *
 * Description: Chart Image export to WBMP
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class WBMPFormat extends ImageExportFormat {

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

    public function WBMPFormat($c) {
        parent::ImageExportFormat($c);

        $this->fileExtension = "wbmp";
    }

    public function getOptions() {
        return $this->format;
    }

    public function setOptions($params) {
        $this->format = $params;
    }

    public function save($ios) /* TODO throws IOException*/ {
        if ($this->width <= 0) {
            $this->width = 400;
        }

        if ($this->height <= 0) {
            $this->height = 300;
        }

        $img = $this->chart->image($this->width, $this->height);
        imagewbmp($this->chart->getGraphics3D()->img,$ios);
    }
}

?>