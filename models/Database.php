<?php 

namespace Models;

require_once __DIR__ . "/../config/config.php";

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

    public function findOne(string $req, array $params = []): array | bool
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

        //auto connexion pour les nouveaux users
        return $this->bdd->lastInsertId($id = null);
        // if (isset($_SESSION['visitor']) && !isset($_SESSION['user']))
        //     $_SESSION['visitor']['id'] = $newID;
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

    protected function deleteOne(string $table, int $uniq): bool
    {
        $query = $this->bdd->prepare("DELETE FROM $table WHERE id = :uniq");
        $query->bindParam(':uniq', $uniq, \PDO::PARAM_INT);
        $success = $query->execute();
        $query->closeCursor();
        return $success;
    }
}


