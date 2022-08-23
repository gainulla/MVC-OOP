<?php

namespace App\Handlers;

use App\Core\Captcha;

class CaptchaHandler extends Handler
{
    public function index(Captcha $captcha) {
        $captcha->create($this->session);
    }
}
