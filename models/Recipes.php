<?php 

namespace Models;

class Recipes extends Database {

    public function getAllRecipes(){
        $req = "SELECT * FROM recipes";
        return $this->findAll($req);
    }

    public function creatNew($params)
    {
        $this->addOne("recipes", "name, product_id, difficulty, time, thermostat, portions, recipe, image", "?, ?, ?, ?, ?, ?, ?, ?", $params);
    }
}