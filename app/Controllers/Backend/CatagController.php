<?php

namespace App\Controllers\Backend;

use App\Core\AbstractController;
use App\Core\Response;
use App\Core\Route;
use App\Form\catagForm;
use App\Models\Catag;

class CatagController extends AbstractController
{
    #[Route('app.catag.index', '/admin/catags', ['GET'])]
    public function indexCatag(): Response
    {


        $catags = (new Catag)->findAll();

        $_SESSION['csrf_token'] = bin2hex(random_bytes(56));

        return $this->render('backend/catag/index.php', [
            'catags' => $catags,
            'token' => $_SESSION['csrf_token'],
            'meta' => [
                'title' => 'Administration des Catags',
            ]
        ]);
    }


    #[Route('app.catag.create', '/admin/catags/create', ['GET', 'POST'])]
    public function create(): Response
    {
        $form = new catagForm();

        if ($form->validate(['name', 'description'], $_POST)) {
            $name = strip_tags((trim($_POST['name'])));
            $description = strip_tags(trim($_POST['description']));

            // on envoie en BDD
            (new catag)
                ->setName($name)
                ->setDescription($description)
                ->create()
            ;

            // oon redirige vers la page d'inex avec un message de succèss
            $this->addFlash('success', 'La catégorie a été créé avec succès !');

            return $this->redirectToRoute('app.catag.index');
        }

        return $this->render('backend/catag/create.php', [
            'form' => $form->createForm(),
        ]);
    }


    #[Route('app.catag.edit', '/admin/catags/([0-9]+)/edit', ['GET', 'POST'])]
    public function update(int $id): Response
    {

        //on recupere le catag à modifier


        /**
         * @var ?Catag $catag  (pour patcher les warning lié à VS Code)
         */


        $catag = (new Catag)->find($id);

        //Si le catag n'existe pas on redirige ver l'index avec un message d'erreur
        if (!$catag) {
            $this->addFlash('danger', 'le catag n\'existe pas !');

            return $this->redirectToRoute('app.catag.index');
        }

        //on instancie le formulaire
        $form = new CatagForm($catag);

        //on verifie si le formulaire à été soumis et qu'il soit valide
        if ($form->validate(['name', 'description'], $_POST)) {
            //On recupere et nettoie les données du formulaire
            $name = strip_tags(trim($_POST['name']));
            $description = strip_tags(trim($_POST['description']));
            $enabled = isset($_POST['enabled']) ? true : false;

            //On met à jour l'objet catag et on persist en BDD
            $catag
                ->setName($name)
                ->setDescription($description)
                ->update()
            ;

            //On redirigie vers la page d'index avec un message de succès
            $this->addFlash('success', "Le catag a été modifié avec succès !");
            return $this->redirectToRoute('app.catag.index');
        }
        return $this->render('backend/catag/update.php', [
            'form' => $form->createForm(),
        ]);
    }


    #[Route('admin.catag.delete', '/admin/catags/([0-9]+)/delete', ['POST'])]
    public function delete(int $id): Response
    {
        // on récupére le catag à supprimer
        $catag = (new Catag)->find($id);

        // si
        if (!$catag) {
            $this->addFlash('danger', 'le catag n\'existe pas !');

            return $this->redirectToRoute('app.catag.index');
        }

        // on vérifie le token scrf
        if ($_SESSION['csrf_token'] === $_POST['csrf_token'] ?? '') {
            $catag->delete();

            $this->addFlash('success', 'le catag a été supprimé avec succès !');
        } else {
            $this->addFlash('danger', 'le token CSRF est invalide !');
        }

        return $this->redirectToRoute('app.catag.index');
    }
}
