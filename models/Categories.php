<?php 

namespace Models;

class Categories extends Database {

    public function getAllCategories(){
        $req = "SELECT * FROM categories";
        return $this->findAll($req);
    }

    public function creatNew($params)
    {
        $this->addOne("categories", "name, descript", "?, ?", $params);
    }
}