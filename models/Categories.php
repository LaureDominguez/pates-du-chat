<?php 

namespace Models;

class Categories extends Database {

    // public function getAllCategories(){
    //     $req = "SELECT * FROM categories";
    //     return $this->findAll($req);
    // }

    public function getAllCategories()
    {
        $req = "SELECT DISTINCT categories.id, categories.name, categories.descript 
            FROM `categories`
            INNER JOIN products ON categories.id = products.cat_id";
        return $this->findAll($req);
    }

    public function getOneCategory($id): array | bool
    {
        $req = "SELECT * FROM categories WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    // public function countProductsOfCategory($id){
    //     $req = "SELECT 
    //             categories.id,
    //             categories.name,
    //             count(products.id) AS nbProducts
    //         FROM `categories` WHERE id = :id
    //         INNER JOIN products ON categories.id = products.cat_id";
    //     $params = ["id" => $id];
    //         return $this->findOne($req, $params);
    // }

    public function creatNewCat($params)
    {
        $this->addOne("categories", "name, descript", "?, ?", $params);
        header('Location: index.php?route=admin');
        exit();
    }
    
    public function countProducts(){

        // $req = "SELECT products.id, products.name, products.descript, products.price, products.img, products.active, 
        //     categories.name AS category FROM `products` 
        //     INNER JOIN categories ON products.cat_id = categories.id";
        // return $this->findAll($req);
    }
}