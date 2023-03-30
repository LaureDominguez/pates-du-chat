<?php

namespace Controllers;

class AdminController{
    public function displayDashboard(){
        $template = "dashboard.phtml";
        include_once'views/layout.phtml';
    }
}