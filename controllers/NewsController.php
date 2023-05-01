<?php

namespace Controllers;

use DateTime;
use DateTimeInterface;
use \Models\News;

class NewsController
{//affiche toutes les actus
    public function displayAllNews(){
        $modelNews = new News();
        $news = $modelNews->getAllNews();

        $template = "news/index.phtml";
        include_once'views/layout.phtml';
    }

    public function displayOneActu($id)
    {//affiche une actu
        $modelNews = new News();
        $actu = $modelNews->getOneActu($id);

        $template = "news/detail.phtml";
        include_once 'views/layout.phtml';
    }
}