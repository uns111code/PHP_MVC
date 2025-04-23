<?php

namespace App\Controllers\Security;

use App\Core\AbstractController;
use App\Core\Response;
use App\Core\Route;
use App\Form\LoginForm;
use App\Models\User;

class SecurityController extends AbstractController
{
    #[Route('app.security.login', '/login', ['GET', 'POST'])]
    public function login(): Response
    {
        // on instancie le formulaire
        $form = new LoginForm();
        // on verifie si le formulaire est soumis et valide
        if ($form->validate(['email', 'password'], $_POST)) {
            // on recupere et nettoie les données du formulaire
            $email = strip_tags($_POST['email']);
            $password = $_POST['password'];

            // var_dump($email);

            // on verifie si l'utilisateur existe en BDD
            $user = (new User)->findOneByEmail($email);

            // var_dump($user);

            // on verifie si l'utilisateur existe et si le mot de passe est correct
            if (!$user || !password_verify($password, $user->getPassword())) {
                $this->addFlash('danger', 'Identifiants incorrects');
                // on redirige vers la page de connexion
                return $this->redirectToRoute('app.security.login');
            }

            // on connecte l'utilisateur
            $user->connectUser();

            $this->addFlash('success', 'Vous êtes connecté !');

            // on redirige vers la page d'accueil
            return $this->redirectToRoute('app.home');

        }

        return $this->render('security/login.php', [
            'form' => $form->createForm(),
            'title' => 'Connexion',
        ]);
    }

    #[Route('app.security.logout', '/logout', ['GET'])]
    public function logout(): Response
    {
        unset($_SESSION['USER']);

        return $this->redirectToRoute('app.home');
    }
}