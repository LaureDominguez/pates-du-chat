<?php 

namespace Models;

class Categories extends Database {

    public function getAllCategories()
    {
        $req = "SELECT * FROM categories";
        return $this->findAll($req);
    }

    public function getAllCategoriesWithProducts()
    {
        $req = "SELECT DISTINCT categories.id, categories.name, categories.descript, categories.active 
            FROM `categories`
            INNER JOIN products ON categories.id = products.cat_id";
        return $this->findAll($req);
    }

    public function countProductsFromCat($id): array | bool
    {
        $req = "SELECT categories.id, categories.name, 
            products.id AS productID, products.name AS productName, 
            COUNT(products.id) AS nbProducts
            FROM `categories` 
            INNER JOIN products ON categories.id = products.cat_id
            WHERE categories.id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
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
        header('Location: index.php?route=admin');
        exit();
    }
    
    public function updateCategory($newData)
    {
        $this->updateOne("categories", $newData, 'id', $newData['id']);
        header('Location: index.php?route=admin');
        exit();
    }
}