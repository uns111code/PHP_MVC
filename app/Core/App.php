<?php

namespace App\Core;

class App
{

    public function __construct(
        private Router $router = new Router(),
        ) {

        }
    /**
     * demarrer l'application
     * @return void
     */

    public function start(): void
    {
        session_start();
        // echo "App started!";
        // var_dump($_GET);

        // on stock l'url du navigateur dans une variable
        $url = $_SERVER['REQUEST_URI'];

        // on va vérifier si l'url n'est pas juste un / et s'elle termine pas par un /
        if (!empty($url) && $url !== '/' && $url[-1] === '/') {
            $url = substr($url, 0, -1);

            // on redirige vers l'url sans le /
            http_response_code(301);
            header('Location: ' . $url);
            exit(301);
        }

        // Init du routeur
        $this->router->initRouter();
        // on va vérifier si l'url de navigateur correspond à une route
        $this->router->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

}