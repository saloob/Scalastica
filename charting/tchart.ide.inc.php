<?php

  /**
  *  This file is part of Steema Software
  *  It generates the design time TChart component.
  *
  *  Copyright (c) 2010 Steema Software <info@steema.com>
  */

  require_once("vcl/vcl.inc.php");
  use_unit("designide.inc.php");

  /**
  * Component editor for the TChartObj component
  *
  */
  class TChartObjEditor extends ComponentEditor
  {
      function getVerbs()
      {
            // echo "Edit...\n";
            echo "About...\n";
      }

      function executeVerb($verb)
      {
          switch($verb)
          {
            case 0:
				      echo "TeeChart for PHP v 1.1 Component. ,\n";
				      echo "Copyright (c) 2010 Steema Software.\n";
              echo "All Rights Reserved.\n";
              break;
            }
      }

  }
?>