<?php 

namespace Models;

class Users extends Database {

    public function creatNew($params)
    {
        $this->addOne("users", "email, pswd", "?, ?", $params);
    }

    public function checkEmail($email){
        $req = "SELECT id FROM users WHERE email = :email";
        $params = ["email"=> $email];
        return $this->findOne($req, $params);
    }

    public function findUser($id){
        $req = "SELECT * FROM users WHERE id = :id";
        $params = ["id" => $id];
        return $this->findOne($req, $params);
    }
}