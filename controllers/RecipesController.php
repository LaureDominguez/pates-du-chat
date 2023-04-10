<?php

namespace Controllers;

class RecipesController{
    public function displayAllRecipes(){
        $model = new \Models\Recipes();
        $recipes = $model->getAllRecipes();

        $template = "recipes/index.phtml";
        include_once'views/layout.phtml';
    }
    public function displayOneRecipe($id)
    {
        $model = new \Models\Recipes();
        $recipe = $model->getOneRecipe($id);

        $template = "recipes/detail.phtml";
        include_once 'views/layout.phtml';
    }
}