<?php
namespace App\Controllers;

use App\Core\Route;
use App\Models\Poste;

class PosteController
{
    #[Route('app.poste.show', '/postes/details/([0-9]+)', ['GET'])]

    public function show(int $id): void
    {
        $poste = (new Poste)->find($id);

        var_dump($poste);
    }
}