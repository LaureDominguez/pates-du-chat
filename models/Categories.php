<?php 

namespace Models;

use PDO;
use PDOException;

class Categories extends Database {

    public function getAllCategories(){
        $req = "SELECT * FROM categories";
        return $this->findAll($req);
    }

    public function creatNew()
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

                $req = "INSERT INTO categories (name, descript) VALUES (:name, :descript)";
                $params = [
                    'name', $addCategory ['addName'], PDO::PARAM_STR,
                    'descript', $addCategory['addDescript'], PDO::PARAM_STR,
                ];

                var_dump($params);
                
                $this->creatOne($req, $params);

                // $sth->bindValue('name', $addCategory['addName'], PDO::PARAM_STR);
                // $sth->bindValue('descript', $addCategory['addDescript'], PDO::PARAM_STR);
                // if($sth->execute()){
                //     echo 'Nouvelle catégorie enregistrée';
                // } else {
                //     'Impossible de créer la catégorie';
                // }
            }
        } catch (PDOException $e) {
            $view = 'error';
            $errors[] = 'Une erreur a eu lieu : ' . $e->getMessage();
        }
    }
}