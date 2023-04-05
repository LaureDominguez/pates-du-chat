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
        $check = $this->isItUsed($req, $params);
        $free = false;
        if ($check['free'] == true) {
            $free = true;
            return $free;
        } else {
            return $free;
        }
    }
}