<?php 

namespace App\Controllers\Backend;

use App\Core\AbstractController;
use App\Core\Response;
use App\Core\Route;
use App\Models\Poste;

class PosteContrller extends AbstractController
{
    #[Route('app.poste.index', '/admin/postes', ['GET'])]
    public function index(): Response
    {
        $postes = (new Poste)->findAll();

        return $this->render('backend/poste/index.php', [
            'postes' => $postes,
        ]);
    }
}