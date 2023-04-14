<?php

namespace Controllers;

class NewsController{
    public function displayAllNews(){
        $modelNews = new \Models\News();
        $news = $modelNews->getAllNews();

        $template = "news/index.phtml";
        $css = [
            "public/css/news.css"
        ];
        include_once'views/layout.phtml';
    }

    public function displayOneActu($id)
    {
        $modelNews = new \Models\News();
        $actu = $modelNews->getOneActu($id);

        $template = "news/detail.phtml";
        $css = [
            "public/css/news.css"
        ];
        
        include_once 'views/layout.phtml';
    }
}