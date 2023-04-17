<?php 

namespace Models;

class News extends Database {

    public function getAllNews(): array | bool
    {
        $req = "SELECT * FROM news
        ORDER BY created_at DESC";
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
        $this->addOne("news", "title, message", "?, ?", $params);
        header('Location: index.php?route=admin');
        exit();
    }

    public function updateNews($newData)
    {
        $this->updateOne('news', $newData, 'id', $newData['id']);
        header('Location: index.php?route=admin');
        exit();
    }

    public function deleteOneActu($id)
    {
        $this->deleteOne("news", $id);
    }
}