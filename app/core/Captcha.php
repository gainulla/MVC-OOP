<?php

namespace App\Core;

use App\Core\UrlManager;
use App\Core\SessionManager;

final class Captcha
{
    private $captchaDir;

    public function __construct($captchaDir) {
        $this->captchaDir = $captchaDir;
    }

    public function create($session) {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        $captcha = substr(str_shuffle($string), 0, 6);
        //$this->session->set('code', $captcha);
        $image = imagecreatefrompng($this->captchaDir . '/background.png');
        $color = imagecolorallocate($image, 200, 240, 240);
        $font = $this->captchaDir . '/oswald.ttf';
        $rotate = rand(-10, 10);
        imagettftext($image, 18, $rotate, 28, 32, $color, $font, $captcha);
        header('Content-type: image/png');
        imagepng($image);
    }
}
