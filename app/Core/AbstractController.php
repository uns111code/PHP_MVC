<?php 

namespace App\Core;

abstract class AbstractController
{
    protected function render(string $view, array $data = []): Response
    {
        // var_dump($view, $data);

        // Extraire les données pour les rendre accessibles dans la vue
        // var_dump($data);
        extract($data, EXTR_SKIP);
        // var_dump($poste);

        // Rendre la vue
        // Démarrer le buffer de sortie pour mettre en mémoire le contenu sans l'afficher
        ob_start();

        // Inclure le fichier de la vue
        require DIR_ROOT . '/Views/' . $view;

        // On stock le contenu du buffer dans une variable
        $content = ob_get_clean();

        //on redémarre le buffer de sortie
        ob_start();
        // On inclut le template de base
        require DIR_ROOT . '/Views/base.php';

        // On stock le contenu du buffer dans une variable
        $finalContent = ob_get_clean();

        // var_dump($finalContent);

        return new Response(
            $finalContent,
            200,
        );
    }
}
