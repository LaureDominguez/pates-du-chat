<?php 

namespace Models;

use PDO;
use PDOException;

class Categories extends Database {

    public function getAllCategories(){
        $req = "SELECT * FROM categories";
        return $this->findAll($req);
    }

    public function verifForm()
    {

        $addCategory = [
            'addName' => '',
            'addDescript' => ''
        ];
        try {
            if (array_key_exists('name', $_POST)) {
                $addCategory = [
                    'addName' => trim($_POST['name']),
                    'addDescript' => trim($_POST['descript'])
                ];
                $dbh = dbConnexion();
                $sth = $dbh->prepare("INSERT INTO categories (name, descript) VALUES (:name, :descript)");
                $sth->bindValue('name', $addCategory['addName'], PDO::PARAM_STR);
                $sth->bindValue('descript', $addCategory['addDescript'], PDO::PARAM_STR);
                $sth->execute();
            }
        } catch (PDOException $e) {
            $view = 'error';
            $errors[] = 'Une erreur a eu lieu : ' . $e->getMessage();
        }
    }
}