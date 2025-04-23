<?php

namespace App\Core;

class Router
{
    private const ADMIN_URL = '/admin';
    private const LOGIN_URL = '/login';

    private array $routes = [];

    public function addRoute(array $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function initRouter(): void
    {
        $directory = new \RecursiveDirectoryIterator(DIR_ROOT . '/Controllers');
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($files as $file) {
            // On récupère seulement la propriété pathName de l'objet $file
            $file = $file[0];

            // /app/Controllers/HomeController.php
            // App\Controllers\HomeController

            // On enlève le / du début
            $file = substr($file, 1);

            // On remplace les / par des \
            $file = str_replace('/', '\\', $file);

            // On enlève l'extension .php
            $file = substr($file, 0, -4);

            $file = ucfirst($file);

            if (class_exists($file)) {
                $classes[] = $file;
            }
        }

        foreach ($classes as $class) {
            $methods = get_class_methods($class);

            foreach ($methods as $method) {
                $attributes = (new \ReflectionMethod($class, $method))->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $route
                        ->setController($class)
                        ->setAction($method);

                    // On ajoute la route au tableau $this->routes
                    $this->addRoute([
                        'url' => $route->getUrl(),
                        'methods' => $route->getMethods(),
                        'controller' => $route->getController(),
                        'action' => $route->getAction(),
                        'name' => $route->getName(),
                    ]);
                }
            }
        }

        $_SESSION['routes'] = $this->routes;
    }

    public function handleRequest(string $url, string $method): void
    {
        // On vérifie si l'url du navigateur commence par /admin
        if (preg_match("~^" . self::ADMIN_URL . "~", $url)) {
            // On vérifie si l'utilisateur n'est pas connecté OU qu'il n'a pas le rôle admin
            if (empty($_SESSION['USER']) || !in_array('ROLE_ADMIN', $_SESSION['USER']['roles'])) {
                $_SESSION['flash']['danger'] = "Vous n'avez pas accès à cette zone, connecté avec un compte Admin";

                // On redirige vers la page de connexion
                $response = new Response('', 403, ['Location' => self::LOGIN_URL]);
                $response->send();

                return;
            }
        }

        // On parcourt les routes (dans le tableau $this->routes)
        foreach ($this->routes as $route) {
            // On vérifie si l'url du navigateur correspond à l'url de la route
            // On vérifie si la méthode du navigateur correspond aux méthodes authorisées de la route
            if (preg_match("#^$route[url]$#", $url, $matches) && in_array($method, $route['methods'])) {
                $controllerName = $route['controller'];

                // On instancie le contrôleur de la route
                $controller = new $controllerName();

                // On exexute la méthode de la route
                $actionName = $route['action'];

                // On supprime le premier élément du tableau $matches
                $params = array_slice($matches, 1);

                $response = $controller->$actionName(...$params);

                $response->send();

                return;
            }
        }

        // Si aucune route ne correspond, on renvoie une erreur 404
        http_response_code(404);
        echo '404 - Page Not Found';
        exit(404);
    }

    public function getUrl(string $name): ?string
    {
        foreach ($_SESSION['routes'] ?? [] as $route) {
            if ($route['name'] === $name) {
                return $route['url'];
            }
        }

        return null;
    }
}
