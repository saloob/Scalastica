<?php

/**
 * StringBuilder class
 *
 * Description: string utility procedures
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

 class StringBuilder {

    private $text = "";

    public function StringBuilder($value=null) {
        $this->text = $value;
    }

    public function append($value) {
        $this->text = $this->text . $value;
    }

    public function toString() {
        return $this->text;
    }

    public function length() {
        return strlen($this->text);
    }

    public function delete($start, $end) {
        $this->text =  substr($this->text, 0, $start) .
               substr($this->text,$start + $end, strlen($this->text)-($end-$start));
    }
}
?>