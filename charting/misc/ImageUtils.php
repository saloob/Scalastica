<?php

/**
 * ImageUtils class
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

class ImageUtils {

    // Interceptors
    function __get( $property ) {
      $method ="get{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method();
      }
    }

    function __set ( $property,$value ) {
      $method ="set{$property}";
      if ( method_exists( $this, $method ) ) {
        return $this->$method($value);
      }
    }

    /**
     * Returns a newly created image using contents read from stream.
     * Might return a null image if the boolean flag cannot be read.
     *
     * @param stream ObjectInputStream
     * @return Image
     * @throws IOException
     * @throws ClassNotFoundException
     */
 /*   public static Image readImage(ObjectInputStream stream) throws
            IOException, ClassNotFoundException {
        if (stream.readBoolean()) {
            Dimension dim = (Dimension) stream.readObject();

            int[] pix = (int[]) stream.readObject();

            return Toolkit.getDefaultToolkit().createImage(
                    new MemoryImageSource(dim.width, dim.height,
                                          pix, 0, dim.width));
        } else {
            return null;
        }
    }
*/
    /**
     * Stores an image contents to stream.
     *
     * @param stream ObjectOutputStream
     * @param image Image
     */
/*    public static function writeImage(ObjectOutputStream stream, Image image, IGraphics3D g)  throws
            IOException {
        if (image == null) {
            stream.writeBoolean(false);
        } else {
            stream.writeBoolean(true);

            stream.writeObject(new Dimension(image.getWidth(null), image.getHeight(null)));
            stream.writeObject(g.getImagePixels(image));
        }
    }
*/
    public static function getImage($imagefile, $c) {
        //Toolkit toolkit = Toolkit.getDefaultToolkit();
        //Image image = toolkit.createImage(imagefile);
        //waitForImage(image, c);

        $image = imagecreatefrompng($imagefile);

/*        imagesavealpha($image, true);
        $trans_colour = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $trans_colour);
        imagealphablending($image, TRUE);
        imagealphablending($image, TRUE);

        $trnprt_indx = imagecolortransparent($image);
        imagecolortransparent($image, $trnprt_indx);
*/
        return $image;
    }

/*    public static Image getImage(URL imageURL, Component c) {
        Toolkit toolkit = Toolkit.getDefaultToolkit();
        Image image = toolkit.createImage(imageURL);
        waitForImage(image, c);
        return image;
    }

    public static boolean waitForImage(Image image, Component c) {
        MediaTracker tracker = new MediaTracker(c);
        tracker.addImage(image, 0);
        try {
            tracker.waitForID(0);
        } catch(InterruptedException ie) {
            System.out.println("loading interrupted");
        }
        return (!tracker.isErrorAny());
    }*/
}

?>