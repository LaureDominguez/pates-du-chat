<?php

namespace Controllers;

class RecipesController{
    public function displayAllRecipes(){
        $modelRecipes = new \Models\Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "recipes/index.phtml";
        $css = [
            "public/css/recipes.css",
            "public/css/rating.css"
        ];
        include_once'views/layout.phtml';
    }
    public function displayOneRecipe($id)
    {
        $modelRecipes = new \Models\Recipes();
        $recipe = $modelRecipes->getOneRecipe($id);

        $modelProducts = new \Models\Products();
        $product = $modelProducts->getOneProduct($recipe['product_id']);

        $template = "recipes/detail.phtml";
        $css = [
            "public/css/recipes.css",
            "public/css/rating.css"
        ];
        include_once 'views/layout.phtml';
    }
}