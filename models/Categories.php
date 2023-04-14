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
    
    public function countProducts(){
        // $req = "SELECT products.id, products.name, products.descript, products.price, products.img, products.active, 
        //     categories.name AS category FROM `products` 
        //     INNER JOIN categories ON products.cat_id = categories.id";
        // return $this->findAll($req);
    }
}