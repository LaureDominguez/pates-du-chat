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
        $check = $this->findOne($req, $params);
        return $check;
    }
}