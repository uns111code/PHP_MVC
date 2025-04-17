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
                // TODO ajouter un message d'erreur
                // on redirige vers la page de connexion
            }

            // on connecte l'utilisateur
            $user->connectUser();

            // TODO rediriger vers la page d'accueil ou la page de profil
        }

        return $this->render('security/login.php', [
            'form' => $form->createForm(),
            'title' => 'Connexion',
        ]);
    }
}