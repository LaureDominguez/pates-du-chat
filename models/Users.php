<?php 

namespace Models;

class Users extends Database {
    private string $email;
    private string $pswd;


    public function creatNew($params)
    {
        global $session;
        // var_dump('coucou4');
        // var_dump($_GET);
        // die;
        return $this->addOne("users", "email, pswd", "?, ?", $params);
        var_dump('coucou5');
        var_dump($_COOKIE);
        var_dump($session);
        die;
        // header('Location: index.php?route=login');
        // exit();
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

    public function updateUser($name)
    {
        $newData = [
            'name'  => $name
        ];
        $this->updateOne('users', $newData, 'id', $_SESSION['user']['id']);
        return $name;
    }
    
}