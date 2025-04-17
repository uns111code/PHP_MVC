<?php

namespace App\Controllers;

use App\Core\Route;
use App\Core\AbstractController;
use App\Core\Response;

class HomeController extends AbstractController
{
    #[Route('app.home', '/', ['GET'])]
    public function index(): Response
    {
        // echo "Page d'accueil";
        // require_once DIR_ROOT . '/Views/home/index.php';

        return $this->render('home/index.php');
    }

    // #[Route('app.test', '/test', ['GET'])]
    // public function test(): void
    // {
    //     echo "Page de test";
    // }

    // #[Route('app.login', '/login', ['GET'])]
    // public function login(): void
    // {
    //     echo "Page de login";
    // }
}