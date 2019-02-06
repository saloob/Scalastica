<?php

/**
 * MarksItem class
 *
 * Description:
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class MarksItem extends TextShape
{
   public $MARKCOLOR = null;

   public function MarksItem($c = null)
   {
      $this->MARKCOLOR = new Color(255, 255, 200);//LIGHT_YELLOW
      parent::TextShape($c);

      $this->setColor($this->MARKCOLOR);
      unset($this->MARKCOLOR);
   }
}
?>