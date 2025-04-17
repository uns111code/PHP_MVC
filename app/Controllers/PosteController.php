<?php
namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\Response;
use App\Core\Route;
use App\Models\Poste;

class PosteController extends AbstractController
{
    #[Route('app.poste.show', '/postes/details/([0-9]+)', ['GET'])]

    public function show(int $id): Response
    {
        $poste = (new Poste)->find($id);

        // var_dump($poste);
        // require_once DIR_ROOT . '/Views/postes/show.php';

        return $this->render('postes/show.php', [
            'poste' => $poste,
        ]);
    }
}