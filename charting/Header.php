<?php

/**
 * Header class
 *
 * Description: Text displayed above Chart
 *
 * @author
 * @copyright (c) 1995-2010 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @link http://www.steema.com
 */

class Header extends Title
{
   /**
   * The class constructor.
   */
   function Header($c)
   {
      parent::Title($c);
      
      TChart::$controlName .= 'Header_';        

      $this->getFont()->getBrush()->setDefaultColor(new Color(70,70,70));    // (0,0,255)
   }
}
?>