<?php

namespace Controllers;

use \Models\Recipes;
use \Models\Products;

class RecipesController{
    public function displayAllRecipes(){
        $modelRecipes = new Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "recipes/index.phtml";
        include_once'views/layout.phtml';
    }
    public function displayOneRecipe($id)
    {
        $modelRecipes = new Recipes();
        $recipe = $modelRecipes->getOneRecipe($id);

        $modelProducts = new Products();
        $product = $modelProducts->getOneProduct($recipe['product_id']);

        $template = "recipes/detail.phtml";
        include_once 'views/layout.phtml';
    }
}