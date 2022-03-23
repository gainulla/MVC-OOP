<?php

namespace App\Handlers;

use App\Core\Form;
use App\Core\Token;
use App\Repository\UserR;
use App\Repository\UserCUD;
use App\Libs\Swiftmailer;

class PasswordHandler extends Handler
{
    public function index(Form $form)
    {
        $this->renderer->render('password/reset', [
            'form' => $form
        ]);
    }

    public function resetForm(
        Token $token,
        UserR $userR,
        UserCUD $userCUD,
        Form $form,
        Swiftmailer $mailer
    ) {
        $email = $form->getInputs('email');
        $user = $userR->findByEmail($email, ['id','email']);

        if ($user->attr('id')) {
            $passwordResetToken = $userCUD->startPasswordReset($user, $token);

			if ($passwordResetToken) {
                $url = $this->url->for('/password/reset/' . $passwordResetToken);

                $text = "Please click here to reset your password: " . $url;
                $html = "<h1>Password reset</h1>";
                $html .= "<p>Please, <a href=\"" . $url . "\">";
                $html .= "click here to reset your password.";
                $html .= "</a></p>";

                try {
                  $mailer->mail($email, 'Password reset', $text, $html);
                } catch(Exception $e) {
                  exit('Swiftmailer fail to mail. Something wrong with SMTP.');
                }

                echo 'Yep!';
                //redirect_to(url_for('password/forgot.php?r=reset'));
                //$this->url->for('home/index');
			}
        } else {
            echo 'Oops!';
        }
    }
}
