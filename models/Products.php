<?php 

namespace Models;

class Products extends Database {

    public function getAllProducts()
    {
        $req = "SELECT products.id, products.cat_id, products.name, products.descript, products.ingredients, products.price, products.img, products.active, 
            categories.name AS category,
            categories.active AS categoryActive,
            images.img AS image,
            images.name AS imgTitle
            FROM `products` 
            INNER JOIN categories ON products.cat_id = categories.id
            LEFT JOIN images ON products.img = images.id";
        return $this->findAll($req);
    }

    public function getOneProduct($id): array | bool
    {
        $req =
        "SELECT products.id, products.cat_id, products.name, products.descript, products.ingredients, products.price, products.img, products.active, 
            categories.name AS categoryProduct,
            categories.active AS categoryActive,
            images.img AS image,
            images.name AS imgTitle
            FROM `products` 
            INNER JOIN categories ON products.cat_id = categories.id
            LEFT JOIN images ON products.img = images.id
        WHERE products.id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNew($params)
    {
        return $this->addOne("products", "name, cat_id, descript, ingredients, price, img", "?, ?, ?, ?, ?, ?", $params);
        // header('Location: index.php?route=admin');
        // exit();
    }

    public function updateProduct($newData)
    {
        return $this->updateOne('products', $newData, 'id', $newData['id']);        
        // header('Location: index.php?route=admin');
        // exit();
    }
}