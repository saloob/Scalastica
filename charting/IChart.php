<?php

 /**
 * IChart class
 *
 * Description: Common Chart characteristics interface
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

interface IChart {

    function checkBackground($sender, $e);    
    function checkGraphics();
    function doAfterDraw();
    function doAfterDrawSeries();
    function doAllowScroll($axis, $delta, $result);
    function doBeforeDraw();
    function doBeforeDrawAxes();
    function doBeforeDrawSeries();
    function doDrawImage($g);  
    function doInvalidate();
    function setChart($c);  
    function getControl();
    function pointToScreen($p);
    function refreshControl();
    function setToolTip($tool, $text); 
}
?>