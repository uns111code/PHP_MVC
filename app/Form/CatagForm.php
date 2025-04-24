<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Catag;

class CatagForm extends Form
{
    public function __construct(?Catag $catag = null, string $action = '#')
    {
        $this
            ->startForm($action, 'POST', ['class' => 'form card p-3 w-75 mx-auto'])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('name', 'Name:', ['class' => 'form-label'])
            ->addInput('text', 'name', [
                'class' => 'form-control',
                'id' => 'name',
                'placeholder' => 'Titre du Catag',
                'required' => true,
                'value' => $catag?->getName(),
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('description', 'Description:', ['class' => 'form-label'])
            ->addTextarea('description', $catag?->getDescription(), [
                'class' => 'form-control',
                'id' => 'description',
                'rows' => 10,
                'placeholder' => 'Description du catag',
                'required' => true,
            ])
            ->endDiv()

            ->addButton(isset($catag) ? 'Modifier' : 'Créer', [
                'class' => 'btn btn-primary',
                'type' => 'submit',
            ])
            ->endForm();
    }
}