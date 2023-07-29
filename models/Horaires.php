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

    public function updateDate($newData)
    {
        $this->updateOne('horaires', $newData, 'id', $newData['id']);
    }

}