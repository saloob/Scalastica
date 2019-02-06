<?php

 /**
 * ImageExportFormat class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage exports
 * @link http://www.steema.com
 */

 class ImageExportFormat extends TeeBase {

    private $width;
    private $height;
    public $fileExtension = "";
    protected $format = null;

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

    public function ImageExportFormat($chart) {
        parent::__construct($chart);
        $r = $chart->getChartBounds();
        $this->width = $r->width;
        $this->height = $r->height;

        /*
                 if ((height != 0) && (width != 0)) {
            chart.getExport().chartWidthHeightRatio = (double) width /
                    (double) height;
                 }
         */
    }

    public function getHeight() {
        return $this->height;
    }

    public function getWidth() {
        return $this->width;
    }

    public function setWidth($value) {
        $this->width = $value;
    }

    public function setHeight($value) {
        $this->height = $value;
    }

/*    public function save($fileName) /*throws IOException {
        $outfile = new File($fileName);
        $ios = $this->ImageIO->createImageOutputStream($outfile);
        $this->save2($ios);
        $ios->close();
    }
*/

    public function save($ios) /* TODO throws IOException*/ {
    }        
}
?>