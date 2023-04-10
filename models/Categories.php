<?php 

namespace Models;

class Categories extends Database {

    public function getAllCategories(){
        $req = "SELECT * FROM categories";
        return $this->findAll($req);
    }

    // public function findCat($cat): array | bool
    // {
    //     $req = "SELECT id FROM categories WHERE name = :name";
    //     $params = ["name" => $cat];
    //     return $this->findOne($req, $params);
    // }

    public function creatNewCat($params)
    {
        $this->addOne("categories", "name, descript", "?, ?", $params);
    }
}