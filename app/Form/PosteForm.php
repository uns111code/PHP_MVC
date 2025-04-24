<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Poste;
// use App\Models\Catag;







class PosteForm extends Form
{
    
    public function __construct(?Poste $poste = null, string $action = '#')
    {
        $this
            ->startForm($action, 'POST', ['class' => 'form card p-3 w-75 mx-auto'])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('title', 'Titre:', ['class' => 'form-label'])
            ->addInput('text', 'title', [
                'class' => 'form-control',
                'id' => 'title',
                'placeholder' => 'Titre du poste',
                'required' => true,
                'value' => $poste?->getTitle(),
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('description', 'Description:', ['class' => 'form-label'])
            ->addTextarea('description', $poste?->getDescription(), [
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
                'id' => 'enabled',
                'checked' => $poste ? $poste->getEnabled() : false
            ])
            ->addLabel('enabled', 'Actif', ['class' => 'form-check-label'])
            ->endDiv()
            // ->addSelect('categorie', $catag, [
            //     'class' => 'form-select form-select-sm',
            //     'id' => 'categorie',
            // ], $selectedCategoryId ?? '')
            ->addButton(isset($poste) ? 'Modifier' : 'Créer', [
                'class' => 'btn btn-primary',
                'type' => 'submit',
            ])
            ->endForm();
    }
}


// 'class' => 'form-select form-select-xs mt-3 mb-3'