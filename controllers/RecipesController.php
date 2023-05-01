<?php

namespace Controllers;

use \Models\Recipes;
use \Models\Products;

class RecipesController{
    public function displayAllRecipes()
    {//affiche toutes les recettes
        $modelRecipes = new Recipes();
        $recipes = $modelRecipes->getAllRecipes();

        $template = "recipes/index.phtml";
        include_once'views/layout.phtml';
    }
    public function displayOneRecipe($id)
    {//affiche une recette
        $modelRecipes = new Recipes();
        $recipe = $modelRecipes->getOneRecipe($id);

        $modelProducts = new Products();
        $product = $modelProducts->getOneProduct($recipe['product_id']);

        $template = "recipes/detail.phtml";
        include_once 'views/layout.phtml';
    }
}