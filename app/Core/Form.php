<?php

namespace App\Core;

class Form
{
    /**
     * Propriété pour stocker le code HTML du formulaire
     *
     */
    protected string $formCode = '';

    public static function validate(array $requireFields, array $submitFields): bool
    {
        // $requireFields ----> ['email', 'password', 'lastname', 'firstname']
        // $submitFields -----> ['email' => 'test@test.com', 'password' => '123456', 'lastname' => 'toto', 'firstname' => 'tata']
        // on boucle sur le tableau de champs obligatoires
        foreach ($requireFields as $requireFields) {
            if (empty($submitFields[$requireFields]) || strlen(trim($submitFields[$requireFields])) === 0) {
                // Si le champ est vide ou n'existe pas dans le tableau $submitFields, on retourne false
                return false;
            }
        }

        return true;
    }

    public function startForm(string $action, string $method = "POST", array $attributs = []): static
    {
        // <form action="#" method="post">
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        // on ajoute les attributs HTML potentiel
        $this->formCode .= $this->addAttributs($attributs) . '>';

        return $this;
    }

    public function endForm(): static
    {
        // </form>
        $this->formCode .= '</form>';

        return $this;
    }

    public function startDiv(array $attributs = []): static
    {
        // <div class="form-group">
        $this->formCode .= '<div' . $this->addAttributs($attributs) . '>';

        return $this;
    }

    public function endDiv(): static
    {
        // </div>
        $this->formCode .= '</div>';

        return $this;
    }
    public function addLabel(string $for, string $text, array $attributs = []): static
    {
        // <label for="email" class="form-label">Email</label>
        $this->formCode .= "<label for=\"$for\"" . $this->addAttributs($attributs) .  ">$text</label>";

        return $this;
    }

    public function addInput(string $type, string $name, array $attributs = []): static
    {
        // <input type="text" name="email" id="email" class="form-control" value="">
        $this->formCode .= "<input type=\"$type\" name=\"$name\" id=\"$name\"" . $this->addAttributs($attributs) . '/>';

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
        // on crée une chaine de caractères vide
        $attributsString = '';

        $courts = ['checked', 'disabled', 'readonly', 'selected', 'multiple', 'required'];
        // on boucle sur le tableau d'attributs
        foreach ($attributs as $key => $value) {
            // on verifie si c'est un attribut court
            if (in_array($key, $courts)) {
                // on ajoute l'attribut sans valeur
                $attributsString .= " $key";
            } else {
                // on ajoute l'attribut avec sa valeur
                $attributsString .= " $key=\"$value\"";
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
