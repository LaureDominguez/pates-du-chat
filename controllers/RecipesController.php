<?php

namespace Controllers;

class RecipesController{
    public function displayAllRecipes(){
        $model = new \Models\Recipes();
        $recipes = $model->getAllRecipes();

        $template = "recipes/index.phtml";
        include_once'views/layout.phtml';
    }
}