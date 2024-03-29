<?php 

namespace Models;

// require_once('../models/Database.php');

class Users extends Database {
    private string $email;
    private string $pswd;


    public function creatNew($params)
    {
        return $this->addOne("users", "email, pswd, token, expiration", "?, ?, ?, ?", $params);
    }

    public function checkEmail($email): array | bool
    {
        $req = "SELECT id FROM users WHERE email = :email";
        $params = ["email"=> $email];
        return $this->findOne($req, $params);
    }

    public function getUser($id):array | bool
    {
        $req = "SELECT * FROM users WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }

    public function updateUser($newData)
    {
        // $this->updateOne('users', $newData, 'id', $_SESSION['user']['id']);
        
        $this->updateOne('users', $newData, 'id', $newData['id']);
        return $newData;
    }
    
}