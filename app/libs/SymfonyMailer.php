<?php

namespace App\Libs;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class SymfonyMailer implements \App\Contracts\MailerInterface
{
    private $mailer;
    private $adminEmail;

    public function __construct(array $smtpSettings, string $adminEmail)
    {
        $required = ['host', 'port', 'username', 'password', 'secure'];
        extract($smtpSettings);

        foreach ($required as $setting) {
            if (!isset($setting)) {
                throw new InvalidArgumentException("Required parameter is missing!");
            }
        }

        $dsn = "smtp://{$username}:{$password}@{$host}:{$port}";

        $transport = Transport::fromDsn($dsn);
        $this->mailer = new Mailer($transport);

        $this->adminEmail = $adminEmail;
    }

    public function mail($to, $subject, $textPlain, $textHtml): void
    {
        try {
            $email = (new Email())
                ->from($this->adminEmail)
                ->to($to)
                ->priority(Email::PRIORITY_HIGHEST)
                ->subject($subject)
                ->text($textPlain)
                ->html($textHtml);

            $this->mailer->send($email);

        } catch(Exception $e) {

			if (DEV_MODE) {
				echo $e->getMessage();
			} else {
                echo 'Что-то пошло не так, не удалось отправить эл. письмо.';
            }

			exit;
		}
    }
}
