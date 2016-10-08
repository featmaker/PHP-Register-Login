<?php 
/**
* Captcha
*/
class Captcha
{
	private $codeNum;
	private $width;
	private $height;
	private $img;
	private $lineFlag;
	private $piexFlag;
	private $fontSize;
	private $code;
	private $string;
	private $font;
	function __construct($codeNum = 4,$height = 50,$width = 150,$fontSize = 20,$lineFlag = true,$piexFlag = true)
	{
		$this->string = 'qwertyupmkjnhbgvfcdsxa123456789';
		$this->codeNum = $codeNum;
		$this->height = $height;
		$this->width = $width;
		$this->lineFlag = $lineFlag;
		$this->piexFlag = $piexFlag;
		$this->font = dirname(__FILE__).'/fonts/consola.ttf';
		$this->fontSize = $fontSize;
	}

	public function createImage(){
		$this->img = imagecreate($this->width, $this->height);
		imagecolorallocate($this->img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
	}

	public function createCode(){
		$strlen = strlen($this->string)-1;
		for ($i=0; $i < $this->codeNum; $i++) { 
			$this->code .= $this->string[mt_rand(0,$strlen)];
		}

		$diff = $this->width/$this->codeNum;
		for ($i=0; $i < $this->codeNum; $i++) { 
			$txtColor = imagecolorallocate($this->img,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
			imagettftext($this->img, $this->fontSize, mt_rand(-30,30), $diff*$i+mt_rand(3,8), mt_rand(20,$this->height-10), $txtColor, $this->font, $this->code[$i]);
		}
	}

	public function createLines(){
		for ($i=0; $i < 4; $i++) { 
			$color = imagecolorallocate($this->img,mt_rand(0,155),mt_rand(0,155),mt_rand(0,155));
			imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color); 
		}
	}

	public function createPiex(){
		for ($i=0; $i < 100; $i++) { 
			$color = imagecolorallocate($this->img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
		}
	}

	public function show()
	{
		$this->createImage();
		$this->createCode();
		if ($this->lineFlag) {
			$this->createLines();
		}
		if ($this->piexFlag) {
			$this->createPiex();
		}
		$_SESSION['code'] = $this->code;
		header('Content-type:image/png');
		imagepng($this->img);
		imagedestroy($this->img);
	}

	public function getCode(){
		return $this->code;
	}
}
session_start();
$captcha = new Captcha();
$captcha->show();