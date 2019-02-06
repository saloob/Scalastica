<?php

/**
 * CandleStyle Class
 *
 * Description: Describes the possible values of Candle.Style
 *
 * @author
 * @copyright Copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class CandleStyle
{
   /**
   * Candle points represented by vertical rectangles with Open and Close
   * vertical tick marks.
   */
   public static $CANDLESTICK = 0;
   /**
   * Candle points represented by vertical lines with Open and Close
   * horizontal tick marks.
   */
   public static $CANDLEBAR = 1;
   /**
   * Candle points represented by vertical rectangles without Open and Close
   * vertical tick marks.
   */
   public static $OPENCLOSE = 2;
   /**
   * Candle points represented by a line.
   */
   public static $LINE = 3;

   function CandleStyle()
   {
   }
}
?>