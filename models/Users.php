<?php 

namespace Models;

class Users extends Database {

    public function creatNew($params)
    {
        $this->addOne("users", "email, psw", "?, ?", $params);
    }

    public function checkEmail($email){
        $req = "SELECT id FROM users WHERE email = :email";
        $params = ["email"=> $email];
        $check = $this->isUsed($req, $params);
        $free = false;
        if ($check['free'] == true) {
            $free = true;
            return $free;
            echo "libre";
        } else {
            return $free;
            echo "occupé";
        }


        // if ($stmt = $this->bdd->prepare($req)){
        //     $stmt->bindParam(":email", $email);
        //     return $this->checkEmail($req);

        // } else {
        //     echo "Oups une erreur s'est produite. Veuillez réessayer plus tard.";
        // }
        // unset($stmt);
    }
}