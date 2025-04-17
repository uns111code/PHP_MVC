<?php

namespace App\Form;

use App\Core\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        $this
            ->startForm('/login', 'POST', [
                'class' => 'form card p-3 w-50 mx-auto',
                'id' => 'login-form',
            ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email:', [
                'class' => 'form-label',
            ])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'placeholder' => 'john@example.com',
                'required' => true,
                ])

            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe:', [
                'class' => 'form-label',
            ])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'placeholder' => 'Mot de passe',
                'required' => true,
            ])

            ->endDiv()
            ->addButton('Se connecter', [
                'class' => 'btn btn-primary',
            ])
            ->endForm();
    }
}