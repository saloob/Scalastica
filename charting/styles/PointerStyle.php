<?php

/**
*
* <p>Title: PointerStyle class</p>
*
* <p>Description: Describes the pointer style of a series pointer.</p>
*
* <p>Copyright (c) 2005-2008 by Steema Software SL. All Rights Reserved.</p>
*
* <p>Company: Steema Software SL</p>
*/

class PointerStyle
{

   private $upperBound = 0;

   /**
   * Defines the pointer as a rectangle.
   */
   public static $RECTANGLE = 0;
   /**
   * Defines the pointer as a circle.
   */
   public static $CIRCLE = 1;
   /**
   * Defines the pointer as a triangle.
   */
   public static $TRIANGLE = 2;
   /**
   * Defines the pointer as a down pointing triangle.
   */
   public static $DOWNTRIANGLE = 3;
   /**
   * Defines the pointer as a cross.
   */
   public static $CROSS = 4;
   /**
   * Defines the pointer as a diagonal cross.
   */
   public static $DIAGCROSS = 5;
   /**
   * Defines the pointer as a star.
   */
   public static $STAR = 6;
   /**
   * Defines the pointer as a diamond.
   */
   public static $DIAMOND = 7;
   /**
   * Defines the pointer as a small dot.
   */
   public static $SMALLDOT = 8;
   /**
   * Defines the pointer as no shape.
   */
   public static $NOTHING = 9;
   /**
   * Defines the pointer as a left triangle.
   */
   public static $LEFTTRIANGLE = 10;
   /**
   * Defines the pointer as a right triangle.
   */
   public static $RIGHTTRIANGLE = 11;
   /**
   * Defines the pointer as a graded sphere.
   */
   public static $SPHERE = 12;
   /**
   * Defines the pointer as a polished sphere.
   */
   public static $POLISHEDSPHERE = 13;


   public function PointerStyle()
   {
      $this->upperBound++;
   }

   public function size() { return $this->upperBound; }

   public function fromInt($value)
   {
      switch($value)
      {
         case 0:
            return self::$RECTANGLE;
         case 1:
            return self::$CIRCLE;
         case 2:
            return self::$TRIANGLE;
         case 3:
            return self::$DOWNTRIANGLE;
         case 4:
            return self::$CROSS;
         case 5:
            return self::$DIAGCROSS;
         case 6:
            return self::$STAR;
         case 7:
            return self::$DIAMOND;
         case 8:
            return self::$SMALLDOT;
         case 9:
            return self::$NOTHING;
         case 10:
            return self::$LEFTTRIANGLE;
         case 11:
            return self::$RIGHTTRIANGLE;
         case 12:
            return self::$SPHERE;
         default:
            return self::$POLISHEDSPHERE;
      }
   }
}
?>