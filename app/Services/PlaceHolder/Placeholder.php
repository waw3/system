<?php namespace App\Services\PlaceHolder;


/**
 * Class Placeholder
 * @package Samcrosoft\Placeholder
 */
class Placeholder
{
    const DEFAULT_BACKGROUND_COLOR = '#333';
    const DEFAULT_FOREGROUND_COLOR = '#fff';
    const DEFAULT_FONT_SIZE = 10;

    const DEFAULT_IMAGE_WIDTH = 100;
    const DEFAULT_IMAGE_HEIGHT = 100;
    const IMAGE_PNG_TYPE = 0x1;
    const IMAGE_JPG_TYPE = 0x2;

    protected $imgWidth;
    protected $imgHeight;
    protected $imgbgColor;
    protected $imgfgColor;
    protected $imgText;
    protected $imgTextHeight;


    /**
     * @param \Illuminate\Routing\Router $router
     * @param \Illuminate\Http\Request   $request
     */
    public function __construct()
    {
        $this->imgWidth = (request()->segment(2) ? request()->segment(2) : self::DEFAULT_IMAGE_WIDTH);
        $this->imgHeight = (request()->segment(3) ? request()->segment(3) : self::DEFAULT_IMAGE_HEIGHT);
        $this->imgbgColor = (request()->segment(4) ? request()->segment(4) : self::DEFAULT_BACKGROUND_COLOR);
        $this->imgfgColor = (request()->segment(5) ? request()->segment(5) : self::DEFAULT_FOREGROUND_COLOR);
        $this->imgText = (request()->segment(6) ? request()->segment(6) : null);
        $this->imgTextHeight = (request()->segment(7) ? request()->segment(7) : self::DEFAULT_FONT_SIZE);
    }




    /**
     * This will return the image text
     * @return string
     */
    public function getText()
    {
        $sDefault = implode("x", [$this->imgWidth, $this->imgHeight]);
        return urlencode(is_null($this->imgText) ? $sDefault : $this->imgText);
    }


    /**
     * Generate a placeholder using the query string parameters
     * @return resource
     */
    public function makePlaceholderFromURL(){
        return $this->makePlaceHolder();
    }


    /**
     * This will create a typed image and echo it out to the browser, the image content cant be trapped using
     * output buffering
     * @param int $iImageType
     */
    public function makeTypedPlaceHolderFromURL($iImageType = self::IMAGE_PNG_TYPE)
    {
        $oImage = $this->makePlaceholderFromURL();
        switch($iImageType){
            case self::IMAGE_JPG_TYPE:
                imagepng($oImage);
                break;
            case self::IMAGE_PNG_TYPE:
            default:
                imagejpeg($oImage);
                break;
        }

        imagedestroy($oImage);
    }

    /**
     * This is just an alias for placeholder from url with IMAGE_JPG_TYPE
     */
    public function makeJpegImageFromURL()
    {
        $this->makeTypedPlaceHolderFromURL(self::IMAGE_JPG_TYPE);
    }

    /**
     * This is just an alias for the default make placeholder from url method
     */
    public function makePngImageFromURL(){
        $this->makeTypedPlaceHolderFromURL();
    }


    /**
     * @param int $iWidth
     * @param int $iHeight
     * @param $sText
     * @param string $sBackColor
     * @param string $sForeColor
     * @return resource
     */
    protected function makePlaceHolder()
    {
        // make the image
        $oImage = $this->getImage();
        // add color to the image
        $aColorifyValues = $this->colorifyImage($oImage);

        // add text to the image
        $aForeColorInt = $aColorifyValues[0];
        $this->textifyImage($oImage, $aForeColorInt);
        return $oImage;
    }

    /**
     * @param int $iWidth
     * @param int $iHeight
     * @return resource
     */
    private function getImage()
    {
        $oImage = imagecreate($this->imgWidth, $this->imgHeight);
        return $oImage;
    }


    /**
     * @param resource $oImage
     * @param string $sBkColor
     * @param string $sFgColor
     * @return array
     */
    private function colorifyImage(&$oImage)
    {
        /*
         * Implement the background
         */
        $aBackColor = $this->hex2rgb($this->imgbgColor);
        list($iRed, $iGreen, $iBlue) = $aBackColor;
        $aBackColorInt = imagecolorallocate($oImage, $iRed, $iGreen, $iBlue);



        /*
         * Implement the foreground for text
         */
        $aForegroundColor = $this->hex2rgb($this->imgfgColor);
        list($iRed2, $iGreen2, $iBlue2) = $aForegroundColor;
        $aForeColorInt = imagecolorallocate($oImage, $iRed2, $iGreen2, $iBlue2);

        return [$aForeColorInt, $aBackColorInt];
    }

    /**
     * Simple helper class to get the RGB values from a hex string
     * @param $hex
     * @return array
     */
    private function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, $this->imgTextHeight, 2));
        }
        $aRGB = [$r, $g, $b];
        return $aRGB;
    }


    /**
     * This method will add text to the image
     * @param resource $oImage
     * @param string $sText
     * @param $aForeColorInt
     */
    protected function textifyImage(&$oImage, $aForeColorInt)
    {
        /*
         * Calculate the text positioning
         */
        $iFontSize = $this->imgTextHeight;
        $iFontWidth = imagefontwidth($iFontSize);
        $iFontHeight = imagefontheight($iFontSize);
        $length = strlen($this->getText());
        $fTextWidth = $length * $iFontWidth;
        $fxPos = (imagesx($oImage) - $fTextWidth) / 2;
        $fyPos = (imagesy($oImage) - $iFontHeight) / 2;

        // Generate text
        imagestring($oImage, $iFontSize, $fxPos, $fyPos, $this->getText(), $aForeColorInt);
    }
}
