<?php 

namespace Models;

// define("DB_HOST", 'db.3wa.io');
// define("DB_NAME", 'argon71hotmailfr_mysociety');
// define("DB_USER", 'argon71hotmailfr');
// define("DB_PASS", '1b6d9c41e962f51b032b2fbc3a06cba1');
define('DB_HOST', '127.0.0.1');
define('DB_DATABASE', 'projet-rattrapage');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

class Database {

    protected $bdd;

    public function __construct()
    {
        $this->bdd = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_USERNAME, DB_PASSWORD, [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, // retourne un tableau indexé par le nom de la colonne
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // lance PDOExeptions
        ]);
    }

    protected function findAll(string $req, array $params = []) : array | bool
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetchAll(); // Récupérer les enregistrements
    }

    protected function findOne(string $req, array $params = []): array | bool
    {
        $query = $this->bdd->prepare($req);
        $query->execute($params);
        return $query->fetch(); // Récupérer les enregistrements
    }

    protected function addOne(string $table, string $columns, string $values, $data)
    {
        $query = $this->bdd->prepare('INSERT INTO ' . $table . '(' . $columns . ') values (' . $values . ')');
        $query->execute($data);
        $query->closeCursor();
        // return $this->bdd->lastInsertId();
    }

    protected function updateOne($table, $newData, $condition, $uniq)
    {
        $sets = '';

        foreach ($newData as $key => $value) {
            $sets .= "$key = :$key,";
        }

        $sets = substr($sets, 0, -1);
        $query = $this->bdd->prepare("UPDATE $table SET $sets WHERE $condition = :$condition");

        foreach ($newData as $key => $value) {
            $query->bindvalue(":$key", $value);
        }

        $query->bindvalue(":$condition", $uniq);
        $query->execute();
        $query->closeCursor();
    }

    protected function deleteOne(string $table, int $uniq)
    {
        $query = $this->bdd->prepare("DELETE FROM $table WHERE id = $uniq");
        $query->execute();
        $query->closeCursor();
    }
}


