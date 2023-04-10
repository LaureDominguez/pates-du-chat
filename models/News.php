<?php 

namespace Models;

class News extends Database {

    public function getAllNews(){
        $req = "SELECT * FROM news";
        return $this->findAll($req);
    }

    public function getOneActu($id): array | bool
    {
        $req = "SELECT * FROM news WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNew($params)
    {
        $this->addOne("news", "titre", "?, ?", $params);
    }
}