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

        $_SESSION['csrf_token'] = bin2hex(random_bytes(56));

        return $this->render('backend/poste/index.php', [
            'postes' => $postes,
            'token' => $_SESSION['csrf_token'],
            'meta' => [
                'title' => 'Administration des postes',
            ],
            
            'scripts' => [
                '/assets/js/switchVisibilityPoste.js',
            ],
            // 'styles' => [   
            //     '/assets/styles/poste.css',
            // ]
        ]);

        // return $this->render('backend/poste/index.php', [
        //     'postes' => $postes,
        // ]);
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
                ->setUserId($_SESSION['USER']['id'])
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

    #[Route('app.poste.edit', '/admin/postes/([0-9]+)/edit', ['GET', 'POST'])]
    public function update(int $id): Response
    {

        //on recupere le poste à modifier


        /**
         * @var ?Poste $poste  (pour patcher les warning lié à VS Code)
         */


        $poste = (new Poste)->find($id);

        //Si le poste n'existe pas on redirige ver l'index avec un message d'erreur
        if (!$poste) {
            $this->addFlash('danger', 'le poste n\'existe pas !');

            return $this->redirectToRoute('app.poste.index');
        }

        //on instancie le formulaire
        $form = new PosteForm($poste);

        //on verifie si le formulaire à été soumis et qu'il soit valide
        if ($form->validate(['title', 'description'], $_POST)) {
            //On recupere et nettoie les données du formulaire
            $title = strip_tags(trim($_POST['title']));
            $description = strip_tags(trim($_POST['description']));
            $enabled = isset($_POST['enabled']) ? true : false;

            //On met à jour l'objet poste et on persist en BDD
            $poste
                ->setTitle($title)
                ->setDescription($description)
                ->setEnabled($enabled)
                ->update()
            ;

            //On redirigie vers la page d'index avec un message de succès
            $this->addFlash('success', "Le poste a été modifié avec succès !");
            return $this->redirectToRoute('app.poste.index');
        }
        return $this->render('backend/poste/update.php', [
            'form' => $form->createForm(),
        ]);
    }

    #[Route('admin.poste.delete', '/admin/postes/([0-9]+)/delete', ['POST'])]

    public function delete(int $id): Response
    {
        // on récupére le poste à supprimer
        $poste = (new Poste)->find($id);

        // si
        if (!$poste) {
            $this->addFlash('danger', 'le poste n\'existe pas !');

            return $this->redirectToRoute('app.poste.index');
        }

        // on vérifie le token scrf
        if ($_SESSION['csrf_token'] === $_POST['csrf_token'] ?? '') {
            $poste->delete();

            $this->addFlash('success', 'le poste a été supprimé avec succès !');
        } else {
            $this->addFlash('danger', 'le token CSRF est invalide !');
        }

        return $this->redirectToRoute('app.poste.index');
    }

    #[Route('app.poste.switch', '/admin/api/postes/([0-9]+)/switch', ['GET'])]
    public function switch(int $id) : Response 
    {
        // on récupère le poste à modifier
        $poste = (new Poste)->find($id);

        // si le poste n'existe pas, on renvoie une erreur 404
        if (!$poste) {
            $content = [
                'status' => 'error',
                'message' => 'Le poste n\'existe pas !',
            ];

            return new Response(
                json_encode($content),
                404,
                ['Content-Type' => 'application/json']
            );
        }
    }
}
