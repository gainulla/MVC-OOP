<?php

namespace App\Handlers;

use App\Core\Form;
use App\Core\Token;
use App\Repository\UserR;
use App\Repository\UserCUD;
use App\Models\UserModel;
use App\Libs\SymfonyMailer;

class PasswordResetHandler extends Handler
{
    public function index(Form $form)
    {
        $this->renderer->render('password-reset/email-form', [
            'form' => $form
        ]);
    }

    public function emailForm(
        Token $token,
        UserR $userR,
        UserCUD $userCUD,
        Form $form,
        SymfonyMailer $mailer
    )
    {
        $email = $form->input('email');
        $user = $userR->findByEmail($email, ['id','email']);

        if ($user->attr('id')) {
            $resetToken = $userCUD->addPasswordResetHash($token, $user);
            $this->session->set('reset_token', $resetToken);

			if ($resetToken) {
                $resetUrl = $this->url->for("password-reset/reset/{$resetToken}");

                $plain = $this->renderer->getTemplate('password-reset/email/plain', [
                    'resetUrl' => $resetUrl
                ]);

                $html = $this->renderer->getTemplate('password-reset/email/html', [
                    'resetUrl' => $resetUrl
                ]);

                $mailer->mail($email, 'Password reset', $plain, $html);
                $this->session->set('check_your_email', 1);

                $this->redirect('password-reset/check-your-email');
			}
        }
    }

    public function checkYourEmail()
    {
        if ($this->session->get('check_your_email', true)) {
            $this->renderer->render('password-reset/check-your-email');
        }
    }

    public function reset(
        Token $token,
        UserR $userR,
        UserCUD $userCUD,
        Form $form
    )
    {
        $form->fromSession('reset_form', $this->session);
        $resetToken = $this->getParam(0);

        if ($resetToken) {
            $user = $userR->getByPasswordResetHash($token, $resetToken, [
                'id',
                'passwordResetExpiresAt'
            ]);

            if ($user->attr('id')) {
                if (strtotime($user->attr('passwordResetExpiresAt')) > time()) {
                    $this->renderer->render('password-reset/reset-form', [
                        'token' => $resetToken,
                        'form'  => $form
                    ]);
                } else {
                    $this->renderer->render('password-reset/token-expired');
                }
            }
        }
    }

    public function resetForm(
        Token $token,
        UserR $userR,
        UserCUD $userCUD,
        Form $form
    )
    {
        $resetToken = $form->input('token');
        $password = $form->input('password');

        $user = $userR->getByPasswordResetHash($token, $resetToken);

        if ($user->attr('id')) {
            $form->validate($userR, UserModel::validationRules());

            if ($form->validationPassed()) {
                $user->fill(['password' => $form->input('password')]);
                $userCUD->save($user);
                $this->redirect('password-reset/reset-success');
            } else {
                $form->intoSession('reset_form', $this->session);
                $this->redirect("password-reset/reset/{$resetToken}");
            }
        }
    }

    public function resetSuccess()
    {
        $this->renderer->render('password-reset/reset-success');
    }
}
