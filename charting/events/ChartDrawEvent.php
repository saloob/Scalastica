<?php

 /**
 * ChartDrawEvent class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage events
 * @link http://www.steema.com
 */

class ChartDrawEvent extends ChartEvent {

    public static $PAINT_FIRST;
    public static $PAINTING;
    public static $PAINTED;
    public static $PRINTING;
    public static $PRINTED;
    public static $PAINT_LAST;

    public static $CHART  = 1;
    public static $AXES   = 2;
    public static $SERIES = 3;

    private $drawPart;

    /**
     * Creates a new instance of ChartDrawEvent
     */
    public function ChartDrawEvent($source, $id, $drawPart) {

        self::$PAINT_FIRST = ChartEvent::$CHART_LAST + 1;
        self::$PAINTING    = self::$PAINT_FIRST;
        self::$PAINTED     = self::$PAINT_FIRST + 1;
        self::$PRINTING    = self::$PAINT_FIRST + 2;
        self::$PRINTED     = self::$PAINT_FIRST + 3;
        self::$PAINT_LAST  = self::$PAINT_FIRST + 3;

        parent::__construct($source, $id);

        $this->drawPart = $drawPart;
    }

    public function getDrawPart() {
        return $this->drawPart;
    }

}

?>