<?php

namespace App\Core;

// use RegexIterator;

class Router
{
    private array $routes = [];

    public function addRoute(array $route): self
    {
        $this->routes[] = $route;
        return $this;
    }

    public function initRouter(): void
    {
        $directory = new \RecursiveDirectoryIterator(DIR_ROOT. '/Controllers');
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach ($files as $file) {

            // on récupére seulement la propriété pathName de l'objet $file
            $file = $file[0];

            // /app/Controllers/HomeController.php
            // App\Controllers\HomeController

            // on enlève le / du début du chemin
            $file = substr($file,  1);

            // on remplce les / par des \
            $file = str_replace('/', '\\', $file);

            // on enlève l'extension .php
            $file = substr($file, 0, -4);

            // première lettre en majuscule
            $file = ucfirst($file);

            if (class_exists($file)) {
                $classes[] = $file;
            }
            // var_dump($file);
        }
        // on boucle sur les classes
        foreach ($classes as $class) {
            $methodes = get_class_methods($class);

            foreach ($methodes as $method) {
                // var_dump(Route::class);
                $attributes = (new \ReflectionMethod($class, $method))->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    $route 
                        ->setController($class)
                        ->setAction($method);
                    // var_dump($route); 

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
    }

    public function handleRequest(string $url, string $method): void
    {
        // on parcours les routes (dans le tableau $this->routes)
        foreach ($this->routes as $route) {
            // on vérifie si l'url de navigateur correspond à l'url de la route
            // on vérifie si la méthode deu navigateur correspond aux méthodes authorisées de la route
            if (preg_match("#^$route[url]$#", $url, $matches) && in_array($method, $route['methods'])) {
                // var_dump($matches);
                $controllerName = $route['controller'];

                // on instancie le controller de la route
                $controller = new $controllerName();
                // on exécute la méthode de la route
                $actionName = $route['action'];
                // $contrloller = new HomeController();
                // $actionName = 'index';

                // on supprime le premier élément du tableau $matches
                $params = array_slice($matches, 1);



                $response = $controller->$actionName(...$params);

                $response->send();
                return;
            }
        }

        // si aucune route ne correspond, on renvoie une erreur 404
         http_response_code(404);
         echo "404 Not Found";
         exit(404);
    }
}