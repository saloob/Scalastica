<?php

 /**
 * Language class
 *
* Description: Internationalization i18n language selection
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage languages
 * @link http://www.steema.com
 */

 class Language {

    public static $ENGLISH=0;

    private $language = 0; // English

    private $currentLanguage="English";
    private $bundle;

    private function Language() {}


    public function activate() {
        $this->currentLanguage = $this->language;
/*
        try {
            //$this->bundle = $this->ResourceBundle->getBundle($this->languages, $this->currentLocale);

         } catch (
         }
*/
    }

    public static function getString($text) {
        // Read string depending of the language choosed , english by default
        return Texts::${$text};
    }
}
?>