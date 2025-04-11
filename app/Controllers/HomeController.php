<?php

namespace App\Controllers;

use App\Core\Route;

class HomeController
{
    #[Route('app.home', '/', ['GET'])]
    public function index(): void
    {
        echo "Page d'accueil";
    }

    #[Route('app.test', '/test', ['GET'])]
    public function test(): void
    {
        echo "Page de test";
    }

    #[Route('app.login', '/login', ['GET'])]
    public function login(): void
    {
        echo "Page de login";
    }
}