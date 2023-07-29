<?php 

namespace Models;


class Horaires extends Database {

    public function getAllDates(): array | bool
    {
        $req = "SELECT * FROM horaires";
        return $this->findAll($req);
    }

    public function getOneDate($id): array | bool
    {
        $req = "SELECT * FROM horaires WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    // public function creatDate($params)
    // {
    //     $this->addOne("horaires", "day, time, city, place", "?, ?, ?, ?", $params);
    //     header('Location: index.php?route=admin');
    //     exit();
    // }

    public function updateDate($newData)
    {
        $this->updateOne('horaires', $newData, 'id', $newData['id']);
        header('Location: index.php?route=admin');
        exit();
    }

    // public function deleteOneDate($id)
    // {
    //     $this->deleteOne("horaires", $id);
    // }
}