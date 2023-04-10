<?php 

namespace Models;

class Products extends Database {

    public function getAllProducts(){
        $req = "SELECT * FROM products";
        return $this->findAll($req);
    }

    public function creatNew($params)
    {
        $this->addOne("products", "name, cat_id, descript, price, img", "?, ?, ?, ?, ?", $params);
    }
}