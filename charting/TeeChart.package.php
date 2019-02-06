<?php

   /**
   *  This file is part of Steema Sopftware
   *
   *  Copyright (c) 2010 Steema Software <info@steema.com>
   *
   */

   require_once("vcl/vcl.inc.php");

   use_unit("designide.inc.php");
   use_unit("templateplugins.inc.php");

   setPackageTitle("TeeChart for PHP Components");
   setIconPath("./icons");

   registerComponents("TeeChart",array("TChartObj"),"tchart.inc.php");
   registerAsset(array("TChartObj"),array("teechart/sources"));

   // List of Properties for Object inspector
   registerBooleanProperty("TChartObj","View3D");
   registerBooleanProperty("TChartObj","AxisBehind");
   registerBooleanProperty("TChartObj","AxisVisible");
   registerBooleanProperty("TChartObj","ClipPoints");
//   registerProperty("TChartObj","BackImage");
   registerBooleanProperty("TChartObj","BackImageInside");

//   registerProperty("TChartObj","BackImageMode");
//   registerBooleanProperty("TChartObj","BackImageTransp");

//   registerBooleanProperty("TChartObj","BackWall.Visible");
//    registerPropertyEditor("TChartObj","BackWall.Visible","TSamplePropertyEditor","native");
//    registerPropertyEditor("TChartObj","Walls.Left","TSamplePropertyEditor","native");
//    registerPropertyEditor("TChartObj","Walls.Bottom","TStringListPropertyEditor","native");
//    registerBooleanProperty('TChartObj','BackWall.Width');
//    registerBooleanProperty('TChartObj','Walls.Vertical');

   registerComponentEditor("TChartObj","TChartObjEditor","tchart.ide.inc.php");
?>