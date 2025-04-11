<?php

// use App\Autoloader;
// // use App\Models\Poste;
// use App\Models\User;

// require_once '/app/Autoloader.php';

// Autoloader::register();

//1.
// $postes = (new Poste())
//     ->findAll();

// var_dump($postes);


//2.
// $postes = (new Poste())
//     ->findBy([
//         'enabled' => true
//     ]);

// var_dump($postes);


//3.
// $postes = (new Poste())
//     ->find(1);

// var_dump($postes);



//4.
// $poste = new Poste();
// $poste
//     ->setTitle('Développeur Symfony')
//     ->setDescription('Développeur Symfony')
//     ->setEnabled(true);

// var_dump($poste);


//5.
// $poste = (new Poste())
//     ->setTitle('Développeur Symfony')
//     ->setDescription('Développeur Symfony')
//     ->setEnabled(true)
//     ->setCreatedAt(new \DateTime())
//     ->create();

// var_dump($poste);

//6.
// $donnes = [
//     'title' => 'Mon titre',
//     'description' => 'Ma description',
//     'enabled' => true,
//     'createdAt' => ('2023-10-01 12:00:00'),
// ];

// $poste = (new Poste())
//     ->hydrate($donnes)
//     ->create();
    
// var_dump($poste);

//7.
// $poste = (new Poste())->find(5);

// var_dump($poste);

// $poste = (new Poste)->hydrate($poste);

// var_dump($poste);

// $poste
//     ->setTitle('titre de poste')
//     ->update();
// var_dump($poste);

//8.
// $poste = (new Poste())->find(5);

// var_dump($poste);

// $poste = (new Poste)->hydrate($poste);

// var_dump($poste);

// $poste
//     ->delete();

// var_dump($poste);

//9.
// $poste = (new Poste())->findALL();

// var_dump($poste);



// user *************************

// $user = (new User())
//     ->setFirstName('Jean')
//     ->setLastName('Dupont')
//     ->setEmail('jean@test.com')
//     ->setPassword(
//         password_hash('Test1234', PASSWORD_ARGON2I)
//     )
//     ->setRoles(['ROLE_AdMIN'])
//     ->create();
//     var_dump($user);





use App\Autoloader;
use App\Core\App;

define('DIR_ROOT', dirname(__DIR__));

// var_dump(DIR_ROOT);

require_once '/app/Autoloader.php';

Autoloader::register();

// on va instancier l'objet App (qui représente notre application)

$app = new App();

// on va lancer l'application (méthode start)
$app->start();