<?php

namespace App\Models;

use App\Core\Database;

/**
 * @property-read int $id  // config vs code
 */

abstract class Model extends Database
{
    protected ?string $table = null;

    protected ?Database $db = null;


    public function findAll(): array
    {
        $pdoStatement = $this
            ->runQuery('SELECT * FROM ' . $this->table)
            ->fetchAll();
        return $this->fetchHydrate($pdoStatement);
    }

    public function find(int $id): bool|object
    {
        // SELECT * FROM table WHERE id = :id
        $pdoStatement = $this
            ->runQuery(
                "SELECT * FROM $this->table WHERE id = :id",
                [
                    'id' => $id
                ]
            )->fetch();

        return  $this->fetchHydrate($pdoStatement);
    }

    public function findBy(array $filters): array
    {
        /**
         * [
         *   'id' => 1,
         *  'name' => 'toto'
         *      'enabled' => 1]
         */
        /**
         * Select * from table where id = :id and name = :name and enabled = :enabled
         */

        // on crée un tableau vide qui va stocker les champs avec les marqueurs sql
        $champs = [];
        // on crée un tableau vide qui va stocker les valeurs (tableau associatif execute)
        $params = [];

        // on boucle sur le tableau qui stock les filters
        foreach ($filters as $champ => $value) {
            // on ajoute le champ avec le marqueur sql
            $champs[] = "$champ = :$champ";
            // on ajoute la valeur dans le tableau des valeurs
            $params[$champ] = $value;
            /**
             *  $db->execute([
             *      'id' => 1,
             *      'name' => 'toto',
             *      'enabled' => 1
             *  ]);
             */
        }

        // var_dump($champs, $params);
        $listChamps = implode(' AND ', $champs);
        // var_dump($listChamps);

        // on crée la requête

        $pdoStatement = $this
            ->runQuery(
                "SELECT * FROM $this->table WHERE $listChamps",
                $params
            )
            ->fetchAll();
        return $this->fetchHydrate($pdoStatement);
    }

    public function create(): ?\PDOStatement
    {
        // INSERT INTO postes (title, description, enabled) VALUES (:title, :description, :enabled)

        $champs = [];
        $markers = [];
        $params = [];
        // on boucle sur les propriétés de l'objet
        foreach ($this as $champ => $value) {
            // on vérifie si la propriété n'est pas null
            if ($champ === 'db' || $champ === 'table' || $value === null) {
                continue;
            }
            $champs[] = $champ;
            $markers[] = ":$champ";

            // on gére les contextes particulier entre php et mysql
            if (gettype($value) === 'boolean') {
                // on transforme le booléen en entier
                $value = (int) $value;
            } else if (gettype($value) === 'array') {
                // on transforme le tableau en json
                $value = json_encode($value);
            } else if ($value instanceof \DateTime) {
                // on transforme la date en format sql
                $value = $value->format('Y-m-d H:i:s');
            }
            $params[$champ] = $value;
        }

        $listChamps = implode(', ', $champs);
        $listMarkers = implode(', ', $markers);

        return $this
            ->runQuery(
                "INSERT INTO $this->table ($listChamps) VALUES ($listMarkers)",
                $params,
            );
    }

    public function update(): ?\PDOStatement
    {
        // UPDATE postes SET title = :title, description = :description, enabled = :enabled WHERE id = :id
        $champs = [];
        $params = [];
        // on boucle sur les propriétés de l'objet
        foreach ($this as $champ => $value) {
            // on vérifie si la propriété n'est pas null
            if ($champ === 'db' || $champ === 'table' || $value === null || $champ === 'id') {
                continue;
            }
            $champs[] = "$champ = :$champ";

            // on gére les contextes particulier entre php et mysql
            if (gettype($value) === 'boolean') {
                // on transforme le booléen en entier
                $value = (int) $value;
            } else if (gettype($value) === 'array') {
                // on transforme le tableau en json
                $value = json_encode($value);
            } else if ($value instanceof \DateTime) {
                // on transforme la date en format sql
                $value = $value->format('Y-m-d H:i:s');
            }
            $params[$champ] = $value;
        }



        $listChamps = implode(', ', $champs);
        $params['id'] = $this->id;

        return $this
            ->runQuery(
                "UPDATE $this->table SET $listChamps WHERE id = :id",
                $params,
            );
    }

    public function delete(): ?\PDOStatement
    {
        // DELETE FROM postes WHERE id = :id
        return $this
            ->runQuery(
                "DELETE FROM $this->table WHERE id = :id",
                [
                    'id' => $this->id
                ]
            );
    }


    public function hydrate(array|object $data): static
    {
        // on boucle sur le tableau associatif (tableau de données)
        foreach ($data as $key => $value) {
            // on vérifie si la méthode existe
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {

                if ($key === 'createdAt') {
                    // on transforme la date en format objet DateTime
                    $value = new \DateTime($value);
                }
                // on appelle la méthode
                $this->$method($value);
            }
        }

        return $this;
    }


    public function fetchHydrate(mixed $query): array|static|bool
    {
        // on verifie si $query est un tableau et qu'il contient au moins un élément
        if (is_array($query) && count($query) > 0) {
            // Boucle sur le tableau de résultats pour instancier chaque objet

            // 1. foreach
            // $data = [];

            // foreach ($query as $object) {
            //     $data[] = (new static())->hydrate($object);
            // }

            // return $data;

            // 2. map
            // return array_map(
            //     function(object $object): static {
            //         return (new static())->hydrate($object);
            //     },
            //     $query,
            // );

            // 3. map avec une fonction fléchée
            return array_map(
                fn(object $object): static => (new static())->hydrate($object),
                $query,
            );
            // on verifie si $query est un objet
        } else if (!empty($query)) {
            // On a un objet standard dans $query -> on instancie un objet de la classe et on hydrate
            return (new static())->hydrate($query);
        } else {
            return $query;
        }
    }


    // Requête simple -> Select * from table
    // Requête préparee -> select * from table where id = :id

    // Quelle est l'objectif de la méthode ?
    protected function runQuery(string $sql, ?array $params = null): ?\PDOStatement
    {
        /*
            $sql = 'SELECT * FROM' . $this->table . 'WHEER id = :id';
            $params = [
            'id' => 1
            ];


            $sqlStatement = $this->prepare($sql);
            $sqlStatement ->execute($params);

            $sqlStatement => $this->db->query($sql);
        */

        // on récupère la connexion en BDD
        $this->db = Database::getInstance();

        // On vérifie si la requête est préparée ou non
        if ($params !== null) {
            // Requête préparée
            $query = $this->db->prepare($sql);
            // on exécute la requête
            $query->execute($params);

            return $query;
        } else {
            // Requête simple
            return $this->db->query($sql);
        }
    }
}
