<?php

namespace App\Core;

class Form
{
    /**
     * Propriété pour stocker le code HTML du formulaire
     */
    protected string $formCode = '';

    public static function validate(array $requireFields, array $submitFields): bool
    {
        // ['email', 'password', 'lastname', 'firstname']
        // ['email' => 'test@test.com', 'password' => 'test', 'lastname' => 'Doe', 'firstname' => 'John']
        // On boucle sur le tableau de champs obligatoires
        foreach ($requireFields as $requireField) {
            if (empty($submitFields[$requireField]) || strlen(trim($submitFields[$requireField])) === 0) {
                return false;
            }
        }

        return true;
    }

    public function startForm(string $action, string $method = "POST", array $attributs = []): static
    {
        // <form action="#" method="POST">
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        // On ajoute les attributs HTML potentiel
        $this->formCode .= $this->addAttributs($attributs) . '>';

        return $this;
    }

    public function endForm(): static
    {
        $this->formCode .= '</form>';

        return $this;
    }

    public function startDiv(array $attributs = []): static
    {
        $this->formCode .= '<div' . $this->addAttributs($attributs) . '>';

        return $this;
    }

    public function endDiv(): static
    {
        $this->formCode .= '</div>';

        return $this;
    }

    public function addLabel(string $for, string $text, array $attributs = []): static
    {
        // <label for="email">Email:</label>
        $this->formCode .= "<label for=\"$for\"" . $this->addAttributs($attributs) . ">$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributs = []): static
    {
        // <input type="email" name="email" id="email" />
        $this->formCode .= "<input type=\"$type\" name=\"$name\"" . $this->addAttributs($attributs) . '/>';

        return $this;
    }

    public function addTextarea(string $name, ?string $content = null, array $attributs = []): static
    {
        // <textarea name="description" id="description">CONTENU PAR DÉFAUT</textarea>
        $this->formCode .= "<textarea name=\"$name\"" . $this->addAttributs($attributs) . ">$content</textarea>";

        return $this;
    }





    public function addSelect(string $name, array $options = [], array $attributs = [], string $selectedValue = ''): static
    {
        $this->formCode .= "<select name=\"$name\"" . $this->addAttributs($attributs) . ">";
    
        foreach ($options as $value => $label) {
            $selected = $value == $selectedValue ? ' selected' : '';
            $this->formCode .= "<option value=\"$value\"$selected>$label</option>";
        }
    
        $this->formCode .= "</select>";
    
        return $this;
    }







    public function addButton(string $text, array $attributs = []): static
    {
        // <button type="submit" class="btn btn-primary">Envoyer</button>
        $this->formCode .= "<button type=\"submit\"" . $this->addAttributs($attributs) . ">$text</button>";

        return $this;
    }

    public function addAttributs(array $attributs): string
    {
        // On crée une chaîne de caractères vide
        $attributsString = '';

        $courts = ['checked', 'disabled', 'readonly', 'selected', 'multiple', 'required'];

        foreach ($attributs as $key => $value) {
            if ($value) {
                // On vérifie si c'est un attribut court
                if (in_array($key, $courts)) {
                    $attributsString .= " $key";
                } else {
                    $attributsString .= " $key=\"$value\"";
                }
            }
        }

        return $attributsString;
    }

    /**
     * Renvoie le code HTML du formulaire stocké dans la propriété $formCode
     * 
     * @return string
     */
    public function createForm(): string
    {
        return $this->formCode;
    }
}