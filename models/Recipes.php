<?php 

namespace Models;

class Recipes extends Database {

    public function getAllRecipes(){
        $req = "SELECT * FROM recipes";
        return $this->findAll($req);
    }

    public function getOneRecipe($id): array | bool
    {
        $req = "SELECT recipes.id, recipes.product_id, recipes.name, recipes.difficulty, recipes.time, recipes.thermostat, recipes.portions, recipes.recipe, recipes.image, recipes.created_at, recipes.updated_at, products.id AS productID, products.name AS productName FROM `recipes`
        INNER JOIN products ON product_id = products.id
        WHERE recipes.id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNew($params)
    {
        $this->addOne("recipes", "name, product_id, difficulty, time, thermostat, portions, recipe, image", "?, ?, ?, ?, ?, ?, ?, ?", $params);
        header('Location: index.php?route=admin');
        exit();
    }
}