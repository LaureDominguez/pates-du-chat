<?php 

namespace Models;

class Products extends Database {

    public function getAllProducts(){
        $req = "SELECT products.id, products.cat_id, products.name, products.descript, products.price,  products.img, products.active, 
            categories.name AS category,
            categories.active AS categoryActive FROM `products` 
            INNER JOIN categories ON products.cat_id = categories.id";
        return $this->findAll($req);
    }

    public function getOneProduct($id): array | bool
    {
        $req = "SELECT * FROM products WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNew($params)
    {
        $this->addOne("products", "name, cat_id, descript, price, img", "?, ?, ?, ?, ?", $params);
        header('Location: index.php?route=admin');
        exit();
    }
}