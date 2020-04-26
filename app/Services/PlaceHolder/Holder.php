<?php namespace App\Services\PlaceHolder;

use Intervention\Image\AbstractFont;
use Intervention\Image\ImageManager;

/**
 * Holder class.
 */
class Holder
{

    const DEFAULT_BACKGROUND_COLOR = '#333';
    const DEFAULT_IMAGE_WIDTH = 100;
    const DEFAULT_IMAGE_HEIGHT = 100;
    const DEFAULT_FONT_SIZE = 10;

    protected $imgWidth;
    protected $imgHeight;
    protected $imgbgColor;


	/**
	 * make function.
	 *
	 * @access public
	 * @param mixed $height
	 * @param mixed $width
	 * @param string $color (default: 'ccc')
	 * @return void
	 */
	public function make()
	{

        $this->imgWidth = (request()->segment(2) ? request()->segment(2) : self::DEFAULT_IMAGE_WIDTH);
        $this->imgHeight = (request()->segment(3) ? request()->segment(3) : self::DEFAULT_IMAGE_HEIGHT);
        $this->imgbgColor = (request()->segment(4) ? request()->segment(4) : self::DEFAULT_BACKGROUND_COLOR);
        $this->imgText = null;
        $this->imgTextHeight = self::DEFAULT_FONT_SIZE;



		// validate
/*
		$color  = ctype_xdigit($color) ? $color : 'ccc';
		$height = $height < 1 ? 1 : $height;
		$width  = $width < 1 ? 1 : $width;
*/

		// set up proportions and adjustments
		$min  = $this->imgHeight > $this->imgWidth ? $this->imgWidth : $this->imgHeight;
		$rate = 3.5;
/*         $rate = 2; */
		$size = $min * .2;

		// params
		$textX = ($this->imgWidth / 2) - ($size / $rate);
		$textY = ($this->imgHeight / 2) - ($size / $rate);




		// generate
		$image = (new ImageManager)->canvas($this->imgWidth, $this->imgHeight, $this->imgbgColor);


		$iFontSize = $size;
        $iFontWidth = imagefontwidth($iFontSize);
        $iFontHeight = imagefontheight($iFontSize);
        $length = strlen($this->getText());
        $fTextWidth = $length * $iFontWidth;
        $textX = (imagesx($image->getCore())) / 2;
        $textY = (imagesy($image->getCore())) / 2;

		$image->text($this->getText(), $textX, $textY, function (AbstractFont $font) use ($size) {
			$font->file(__DIR__ . '/fonts/alegreya-regular.ttf');
			$font->size($size);
			$font->color($this->invertColor($this->imgbgColor));
			$font->align('center');
			$font->valign('center');
			$font->angle(0);
		});

		// response
		return $image;
	}

	/**
     * This will return the image text
     * @return string
     */
    public function getText()
    {
        $sDefault = implode(" x ", [$this->imgWidth, $this->imgHeight]);
/*         return urlencode(is_null($this->imgText) ? $sDefault : $this->imgText); */
        return is_null($this->imgText) ? $sDefault : $this->imgText;
    }

	/**
	 * invertColor function.
	 *
	 * @access private
	 * @param mixed $color
	 * @return void
	 */
	private function invertColor($color)
	{

		$color = strlen($color) === 3 ? $color . $color : $color;

		$color = str_replace('#', '', $color);
		if (strlen($color) != 6) {
			return 'ccc';
		}
		$rgb = '';
		for ($x = 0; $x < 3; ++$x) {
			$c = 255 - hexdec(substr($color, (2 * $x), 2));
			$c = ($c < 0) ? 0 : dechex($c);
			$rgb .= (strlen($c) < 2) ? '0' . $c : $c;
		}

		return '#' . $rgb;
	}
}
