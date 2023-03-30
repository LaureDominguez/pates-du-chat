<?php 

namespace Models;

class Products extends Database {

    public function getAllProducts(){
        $req = "SELECT * FROM products";
        return $this->findAll($req);
    }
}