<?php

namespace App\Form;

use App\Core\Form;

class PosteForm extends Form
{
    public function __construct(string $action = '#')
    {
        $this
            ->startForm($action, 'POST', ['class' => 'form card p-3 w-75 mx-auto'])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('title', 'Titre:', ['class' => 'form-label'])
            ->addInput('text', 'title', [
                'class' => 'form-control',
                'id' => 'title'
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('description', 'Description:', ['class' => 'form-label'])
            ->addTextarea('description', '', [
                'class' => 'form-control',
                'id' => 'description',
                'rows' => 10,
                'placeholder' => 'Description du poste',
                'required' => true,
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3 form-check form-switch'])
            ->addInput('checkbox', 'enababled', [
                'class' => 'form-check-input',
                'id' => 'enabled'
            ])
            ->addLabel('enabled', 'Actif', ['class' => 'form-check-label'])
            ->endDiv()
            ->addButton('Créer', [
                'class' => 'btn btn-primary',
                'type' => 'submit',
            ])
            ->endForm();
    }
}