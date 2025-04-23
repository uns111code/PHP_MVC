<?php

namespace App\Controllers\Backend;

use App\Core\AbstractController;
use App\Core\Response;
use App\Core\Route;
use App\Form\PosteForm;
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

    #[Route('app.poste.create', '/admin/postes/create', ['GET', 'POST'])]
    public function create(): Response
    {
        $form = new PosteForm();

        if ($form->validate(['title', 'description'], $_POST)) {
            $title = strip_tags((trim($_POST['title'])));
            $description = strip_tags(trim($_POST['description']));
            $enabled = isset($_POST['enabled']) ? true : false;

            // on envoie en BDD
            (new Poste)
                ->setTitle($title)
                ->setDescription($description)
                ->setEnabled($enabled)
                ->create()
            ;

            // oon redirige vers la page d'inex avec un message de succèss
            $this->addFlash('success', 'Le poste a été créé avec succès !');

            return $this->redirectToRoute('app.poste.index');
        }

        return $this->render('backend/poste/create.php', [
            'form' => $form->createForm(),
        ]);
    }
}
