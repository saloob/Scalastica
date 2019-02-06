<?php

/**
 * Utils class
 *
 * Description: Chart utility procedures
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage misc
 * @link http://www.steema.com
 */

 class Utils {

    private $TicksPerMillisecond = 10000;
    private $TicksPerSecond;
    private $TicksPerMinute;
    private $TicksPerHour;
    private $TicksPerDay;

    // Number of milliseconds per time unit
    private $MillisPerSecond = 1000;
    private $MillisPerMinute;
    private $MillisPerHour;
    private $MillisPerDay;

    private $DaysPerYear = 365;
    // Number of days in 4 years
    private $DaysPer4Years;
    // Number of days in 100 years
    private $DaysPer100Years;
    // Number of days in 400 years
    private $DaysPer400Years;

    // Number of days from 1/1/0001 to 12/31/1600
    //static final int DaysTo1601 = DaysPer400Years * 4;

    // Number of days from 1/1/0001 to 12/30/1899
    private $DaysTo1899;
    private $DoubleDateOffset;
    // The minimum OA date is 0100/01/01 (Note it's year 100).
    // The maximum OA date is 9999/12/31
    private $OADateMinAsTicks;


    // Converts RGB color to Hex
    static function rgbhex($red,$green,$blue) {
      $red = dechex($red);
      $green = dechex($green);
      $blue = dechex($blue);

      return "#".strtoupper($red.$green.$blue);
    }

    // Hex to RGB color
    static function hex2rgb($color) {
        $color = str_replace('#','',$color);
        $s = strlen($color) / 3;
        $r=hexdec(str_repeat(substr($color,0,$s),2/$s));
        $g=hexdec(str_repeat(substr($color,$s,$s),2/$s));
        $b=hexdec(str_repeat(substr($color,2*$s,$s),2/$s));

        return new Color($r,$g,$b);
    }

        /**
          * Evaluates and returns a steema.<!-- -->teechart.<!-- -->DateTimeStep
          * value as an Axis double scale that may be used to set the
          * steema.<!-- -->teechart.<!-- -->Axis.<!-- -->Increment.
          *
          *
          * @param value DateTimeStep
          * @return double
          */

    public function getDateTimeStep($value) {
        $tmpDateTimeStep = new DateTimeStep();
        return (int) $tmpDateTimeStep->STEP[$value];
    }

    public function Utils() {
        $this->TicksPerSecond = $this->TicksPerMillisecond * 1000;
        $this->TicksPerMinute = $this->TicksPerSecond * 60;
        $this->TicksPerHour = $this->TicksPerMinute * 60;
        $this->TicksPerDay = $this->TicksPerHour * 24;
        $this->MillisPerMinute = $this->MillisPerSecond * 60;
        $this->MillisPerHour = $this->MillisPerMinute * 60;
        $this->MillisPerDay = $this->MillisPerHour * 24;
        $this->DaysPer4Years = $this->DaysPerYear * 4 + 1;
        $this->DaysPer100Years = $this->DaysPer4Years * 25 - 1;
        $this->DaysPer400Years = $this->DaysPer100Years * 4 + 1;
        $this->DaysTo1899 = $this->DaysPer400Years * 4 + $this->DaysPer100Years * 3 - 367;
        $this->DoubleDateOffset = $this->DaysTo1899 * $this->TicksPerDay;
        $this->OADateMinAsTicks = ($this->DaysPer100Years - $this->DaysPerYear) * $this->TicksPerDay;
    }


    /**
     * Recursively delete a directory
     *
     * @param string $dir Directory name
     * @param boolean $deleteRootToo Delete specified top-level directory as well
     */
    static function unlinkRecursive($dir, $deleteRootToo)
{
      if(!$dh = @opendir($dir))
      {
          return;
      }
      while (false !== ($obj = readdir($dh)))
      {
        if($obj == '.' || $obj == '..')
        {
            continue;
        }

        if (!@unlink($dir . '/' . $obj))
        {
            unlinkRecursive($dir.'/'.$obj, true);
        }
      }

      closedir($dh);
   
      if ($deleteRootToo)
      {
        @rmdir($dir);
      }
   
      return;
    } 
    
    // Copied from Microsoft's SSCLI sources.
    static private function ticksToOADate($value) /* todo throws Exception*/ {
        if ($value == 0) {
            return 0.0; // Returns OleAut's zero'ed date value.
        }

        if ($value < $this->TicksPerDay) { // This is a fix for VB. They want the default day to be 1/1/0001 rathar then 12/30/1899.
            $value += $this->DoubleDateOffset; // We could have moved this fix down but we would like to keep the bounds check.
        }
        if ($value < $this->OADateMinAsTicks) {
            throw new Exception("Arg_OleAutDateInvalid");
        }

        // Currently, our max date == OA's max date (12/31/9999), so we don't
        // need an overflow check in that direction.
        $millis = ($value - $this->DoubleDateOffset) / $this->TicksPerMillisecond;
        if ($millis < 0) {
            $frac = $millis % $this->MillisPerDay;
            if ($frac != 0) {
                $millis -= ($this->MillisPerDay + $frac) * 2;
            }
        }
        return (double) $millis / $this->MillisPerDay;
    }

    // return double
    static public function stringToDouble($text, $value) {
        if (strlen($text) == 0) {
            return $value;
        } else {
            try {
                return (double)$text;
            } catch (NumberFormatException $e) {
                return $value;
//            } catch (FormatException e) {
//                return value;
//            } catch (OverflowException e) {
//                return value;
            }
        }
    }

    static public function swapInteger($a, $b)
    {
       $tmpA = round($b);
       $b = $a;
       $a = $tmpA;
    }

    static private function privateSort($l, $r, $c, $s) {
        $i = round($l);
        $j = round($r);
        $x = round(($i + $j) / 2);
        while ($i < $j) {
            while ($c->compare($i, $x) < 0) {
                $i++;
            } while ($c->compare($x, $j) < 0) {
                $j--;
            }
            if ($i < $j) {
                $s->swap($i, $j);
                if ($i == $x) {
                    $x = $j;
                } else if ($j == $x) {
                    $x = $i;
                }
            }
            if ($i <= $j) {
                $i++;
                $j--;
            }
        }
        if ($l < $j) {
            $this->privateSort($l, $j, $c, $s);
        }
        if ($i < $r) {
            $this->privateSort($i, $r, $c, $s);
        }
    }

    static public function sort($startIndex, $endIndex, $c, $s) {
        self::privateSort($startIndex, $endIndex, $c, $s);
    }

/* TODO    static public void sort(final int[] x, int startIndex, int endIndex,
                            Comparator c) {
        sort(startIndex, endIndex, c, new Swapper() {
            public void swap(int a, int b) {
                int tmp = x[a];
                x[a] = x[b];
                x[b] = tmp;
            };
        });
    }
*/

    /**
     * Make a recursive copy of an array
     *
     * @param array $aSource
     * @return array    copy of source array
     */
    static function  array_copy ($aSource) {
        // check if input is really an array
        if (!is_array($aSource)) {
            throw new Exception("Input is not an Array");
        }
       
        // initialize return array
        $aRetAr = array();
       
        // get array keys
        $aKeys = array_keys($aSource);
        // get array values
        $aVals = array_values($aSource);
       
        // loop through array and assign keys+values to new return array
        for ($x=0;$x<count($aKeys);$x++) {
            // clone if object
            if (is_object($aVals[$x])) {
                $aRetAr[$aKeys[$x]]=clone $aVals[$x];
            // recursively add array
            } elseif (is_array($aVals[$x])) {
                $aRetAr[$aKeys[$x]]=array_copy ($aVals[$x]);
            // assign just a plain scalar value
            } else {
                $aRetAr[$aKeys[$x]]=$aVals[$x];
            }
        }
       
        return $aRetAr;
    }

    /**
     * Number of chart Tool types.
     */
    public static $TOOLTYPESCOUNT = 19; //CDI ExtraLegend + GridBand (+2)

    /**
     * List of chart Tool classes.
     */
/* TODO    final static public Class[] toolTypesOf = {
                                              Annotation.class,
                                              Rotate.class,
                                              ChartImage.class,
                                              CursorTool.class,
                                              DragMarks.class,
                                              AxisArrow.class,
                                              ColorLine.class,
                                              ColorBand.class,
                                              DrawLine.class,
                                              NearestPoint.class,
                                              MarksTip.class,
                                              ExtraLegend.class,
                                              DragPoint.class,
                                              SeriesAnimation.class,
                                              PieTool.class,
                                              GridTranspose.class,
                                              GanttTool.class,
                                              GridBand.class,
//                                        AxisScrollEditor.class,
//                                        AxisToolEdit.class,
//                                        HotSpotEditor.class,
//                                        LightToolEditor.class,
//                                        ScrollBarEditor.class,
//                                        SurfaceNearestToolEditor.class,
//                                        ToolSeriesEditor.class,
//                                        ZoomToolEditor.class
                                              PageNumber.class
    };
*/

    /**
     * Returns the index in ToolTypesOf list of a given tool instance.
     *
     * @param tool Tool to search its type in list
     * @return int
     */
/* tODO    static public int toolTypeIndex(Tool tool) {
        for (int t = 0; t < Utils.TOOLTYPESCOUNT; t++) {
            if (Utils.toolTypesOf[t] == tool.getClass()) {
                return t;
            }
        }
        return -1;
    }
*/
    /**
     * Number of chart Function types.
     */
    public static $FUNCTIONTYPESCOUNT = 37;

    /**
     * List of chart Function types.
     */
/* tODO    final static public Class[] functionTypesOf = {
                                                  Add.class, //0
                                                  Subtract.class, //0
                                                  Multiply.class, //0
                                                  Divide.class, //0
                                                  High.class, //0
                                                  Low.class, //0
                                                  Average.class, //0
                                                  Count.class, //0
                                                  Momentum.class,  //2
                                                  MomentumDivision.class,  //2
                                                  Cumulative.class,  //1
                                                  ExpAverage.class,  //1
                                                  Smoothing.class,  //3
                                                  Custom.class,  //3
                                                  RootMeanSquare.class,  //1
                                                  StdDeviation.class,  //1
                                                  Stochastic.class,  //2
                                                  ExpMovAverage.class,  //2
                                                  Performance.class,  //2
                                                  CrossPoints.class,  //3
                                                  CompressOHLC.class,  //2
                                                  CLV.class,  //2
                                                  OBV.class,  //2
                                                  CCI.class,  //2
                                                  MovingAverage.class,  //1
                                                  PVO.class,  //2
                                                  DownSampling.class,  //3
                                                  Trend.class,  //3
                                                  Correlation.class,  //1
                                                  Variance.class,  //1
                                                  Perimeter.class,  //3
                                                  CurveFitting.class,  //3
                                                  ADX.class,  //2
                                                  Bollinger.class,  //2
                                                  MACD.class,  //2
                                                  SAR.class,  //2
                                                  RSI.class  //2
    };

    final static public int[] functionGalleryPage = {
            0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 1,
            1, 3, 3, 1, 1, 2, 2, 2, 3, 2, 2,
            2,
            2,
            1, 2, 3, 3, 1,
            1, 3, 3 , 2, 2, 2, 2, 2
    };

    static public int seriesTypesIndex(ISeries s) {
        return seriesTypesIndex(s.getClass());
    }

    static public int seriesTypesIndex(Class seriesType) {
        for (int t = 0; t < SERIESTYPESCOUNT; t++) {
            if (seriesTypesOf[t] == seriesType) {
                return t;
            }
        }
        return -1;
    }
*/
    public static $SERIESTYPESCOUNT = 46;
/* tODO
    final static public int[] seriesGalleryCount = {
            2, 2, 2, 2, 2, 2, 2, 1, 3
            , 1, 1, 1,
            1, 1, 1, 1, 1, 2, 2, 1, 1, 1, 1, 1,
            1, 1, 1, 1, 1, 1, 1, 2, 2, 1, 1, 1,
            1, 1, 1, 2, 1, 1, 1, 1, 1, 1
    };

    final static public int[] seriesGalleryPage = {
            0, 0, 0, 0, 0, 0, 0, 0, 0,
            3, 0, 0,
            2, 3, 2, 4, 4, 3, 3, 5, 5, 3, 4, 5,
            5, 4, 4, 1, 1, 1, 4, 3, 5, 1, 4, 1,
            1, 1, 0, 4, 2, 3, 4, 3, 3, 5
    };

    */
    /*final*/ static public /*Class[]*/ $seriesTypesOf = Array(
                                                Line,
                                                Points,
                                                Area,
                                                FastLine,
                                                HorizLine,
                                                Bar,
                                                HorizBar,
                                                Pie,
                                                Shape,
                                                Arrow,
                                                Bubble,
                                                Gantt,
                                                Candle,
                                                Donut,
                                                Volume,
                                                Bar3D,
                                                Points3D,
                                                Polar,
                                                Radar,
                                                Clock,
                                                WindRose,
                                                Pyramid,
                                                Surface,
                                                LinePoint,
                                                BarJoin,
                                                ColorGrid,
                                                Waterfall,
                                                Histogram,
                                                Error,
                                                ErrorBar,
                                                Contour,
                                                Smith,
                                                Calendar,
                                                HighLow,
                                                TriSurface,
                                                Funnel,
                                                Box,
                                                HorizBox,
                                                HorizArea,
                                                Tower,
                                                PointFigure,
                                                Gauges,
                                                Vector3D,
                                                Map,
                                                Bezier,
                                                ImageBar
    );
    /*
    public static InputStream downloadURLStream(String url) throws
            MalformedURLException, IOException {
        return new URL(url).openStream();
    }

    public static String downloadURLString(String url) throws IOException {

        Reader reader = new InputStreamReader(downloadURLStream(url), "UTF-8");

        int c;
        StringBuffer sb = new StringBuffer();
        while ((c = reader.read()) != -1) {
            sb.append((char) c);
        }

        return sb.toString();
    }


    static public function MulDiv($a, $b, $c) {
        (int) $nMul = $a * $b,
                   nMod = nMul % c,
                          nRes = nMul / c;

        if (nMod >= c / 2) { // Round up if >= 0.5
            nRes++;
        }
        return nRes;
    }

    static public String dateTimeToStr(double datetime) {
        return new DateTime(datetime).toShortDateString();
    }

    static public String dateTimeToStr(DateTime datetime) {
        return datetime.toShortDateString();
    }

    static public String dateTimeToDateTimeStr(DateTime datetime) {
        return datetime.toShortDateString() + " " + datetime.toShortTimeString();
    }


    static public String timeToStr(double datetime) {
        return new com.steema.teechart.DateTime(datetime).toShortTimeString();
    }

    static public String timeToStr(DateTime datetime) {
        return datetime.toShortTimeString();
    }

    static public String arrayToString(String[] a) {
        return arrayToString(a, '\n');
    }

    static public String arrayToString(String[] a, char separator) {
        StringBuffer result = new StringBuffer();
        if (a.length > 0) {
            result.append(a[0]);
            for (int i = 1; i < a.length; i++) {
                result.append(separator);
                result.append(a[i]);
            }
        }
        return result.toString();
    }

    static public void drawCheckBox(int x, int y, IGraphics3D g,
                                    boolean drawChecked, boolean CheckBox,
                                    java.awt.Color backColor) {

        int TeeCheckBoxSize = 11;

        g.getPen().setStyle(DashStyle.SOLID);
        g.getPen().setWidth(1);
        g.getPen().setColor(Color.GRAY);
        g.line(x + TeeCheckBoxSize, y, x, y);
        g.line(x, y, x, y + TeeCheckBoxSize + 1);

        g.getPen().setColor(Color.lightGray);
        g.line(x, y + TeeCheckBoxSize + 1, x + TeeCheckBoxSize + 1,
               y + TeeCheckBoxSize + 1);
        g.line(x + TeeCheckBoxSize + 1, y + TeeCheckBoxSize + 1,
               x + TeeCheckBoxSize + 1, y);

        g.getPen().setColor(Color.BLACK);
        g.line(x + 1, y + 1, x + TeeCheckBoxSize, y + 1);
        g.line(x + 1, y + 1, x + 1, y + TeeCheckBoxSize);

        if (drawChecked) {
            g.getPen().setStyle(DashStyle.SOLID);
            g.getPen().setColor(Color.BLACK);
            for (int t = 1; t < 4; t++) {
                g.line(x + 2 + t, y + 4 + t, x + 2 + t, y + 7 + t);
            }
            for (int t = 1; t < 5; t++) {
                g.line(x + 5 + t, y + 7 - t, x + 5 + t, y + 10 - t);
            }
        }
    }  */
}

?>
