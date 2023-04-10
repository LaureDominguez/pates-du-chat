<?php 

namespace Models;

class Recipes extends Database {

    public function getAllRecipes(){
        $req = "SELECT * FROM recipes";
        return $this->findAll($req);
    }

    public function getOneRecipe($id): array | bool
    {
        $req = "SELECT * FROM recipes WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNew($params)
    {
        $this->addOne("recipes", "name, product_id, difficulty, time, thermostat, portions, recipe, image", "?, ?, ?, ?, ?, ?, ?, ?", $params);
    }
}