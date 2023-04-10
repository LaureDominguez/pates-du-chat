<?php 

namespace Models;

class Categories extends Database {

    public function getAllCategories(){
        $req = "SELECT * FROM categories";
        return $this->findAll($req);
    }

    public function getOneCategory($id): array | bool
    {
        $req = "SELECT * FROM categories WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNewCat($params)
    {
        $this->addOne("categories", "name, descript", "?, ?", $params);
    }
}