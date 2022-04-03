<?php

namespace App\Libs;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class SwiftMailer implements \App\Contracts\MailerInterface
{
	private $mailer;
	private $message;
	private $adminEmail;

	public function __construct(array $smtpSettings, string $adminEmail)
	{
		$required = ['host', 'port', 'username', 'password', 'secure'];
		extract($smtpSettings);

		foreach ($required as $setting) {
			if (!isset($setting)) {
				throw new InvalidArgumentException("The '{$setting}' is required!");
			}
		}

		$transport = new Swift_SmtpTransport($host, $port, $secure);
		$transport->setUsername($username)->setPassword($password);

		$this->mailer = new Swift_Mailer($transport);
		$this->message = new Swift_Message();
		$this->adminEmail = $adminEmail;
	}

	public function mail($to, $subject, $textPlain, $textHtml): void
	{
		try {
			$this->message->setTo([$to]);
			$this->message->setSubject($subject);
			$this->message->setBody($textPlain, 'text/plain');
			$this->message->addPart($textHtml, 'text/html');
			$this->message->setFrom([$this->adminEmail]);
			$this->mailer->send($this->message);

		} catch(Exception $e) {
			echo 'Что-то пошло не так, не удалось отправить эл. письмо.';

			if (DEV_MODE) {
				echo $e->getMessage();
			}

			exit;
		}
	}
}
