<?php 

namespace Models;

class Gallery extends Database {

    public function getAllImages()
    {
        $req = "SELECT * FROM `images`";
        return $this->findAll($req);
    }

    public function getOneImage($id): array | bool
    {
        $req = "SELECT * FROM images WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function creatNew($params)
    {
        $this->addOne("images", "name, img", "?, ?", $params);
        // header('Location: index.php?route=admin');
        // exit();
    }

    public function updateImage($newData)
    {
        $this->updateOne('images', $newData, 'id', $newData['id']);        
        header('Location: index.php?route=admin');
        exit();
    }
}