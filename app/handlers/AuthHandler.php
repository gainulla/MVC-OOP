<?php

namespace App\Handlers;

use App\Repository\UserR;
use App\Repository\UserCUD;
use App\Core\Form;
use App\Models\UserModel;

class AuthHandler extends Handler
{
    public function login(array $params, Form $form)
    {
        $this->renderer->render('auth/login', ['form' => $form]);
    }

    public function loginForm(array $params, UserR $userR, Form $form)
    {
        $email = $form->getInputs('email');
        $password = $form->getInputs('password');

        $user = $userR->findByEmail($email, ['passwordHash', 'username']);

        if (!$user || !password_verify($password, $user->getAttr('passwordHash'))) {
            $errors[] = 'Неверный эл. адрес или пароль.';
            $this->renderer->render('auth/login', ['errors' => $errors]);
        } else {
            $this->session->set('username', $user->getAttr('username'));
            $this->redirect('home/index');
        }
    }

    public function register(array $params, Form $form)
    {
        $this->renderer->render('auth/register', ['form' => $form]);
    }

    public function registerForm(array $params, UserR $userR, UserCUD $userCUD, Form $form)
    {
        $form->validate($userR, UserModel::validationRules());

        if ($form->validationPassed()) {
            $user = new UserModel($form->getInputs());

            $userCUD->save($user);
            $this->redirect('home/index');
        }

        $this->renderer->render('auth/register', [
            'form'   => $form,
        ]);
    }

    public function logout()
    {
        $this->session->clear();
        $this->redirect('home/index');
    }
}
