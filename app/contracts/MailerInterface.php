<?php

namespace App\Contracts;

interface MailerInterface
{
    public function mail($to, $subject, $textPlain, $textHtml): void;
}
