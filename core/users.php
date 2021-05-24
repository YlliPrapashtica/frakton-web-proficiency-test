<?php

class SignUp{

    private $conn;
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $isAuthed;


    public function __construct($db){
        $this->conn = $db;
    }

    public function createUser(){
        //Create New User
        $query = 'INSERT INTO users SET first_name = :first_name, last_name = :last_name, email = :email, password = :password ';

        $stmt = $this->conn->prepare($query);

        //Extract User Data From Instance
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        //Bind User Parameters
        $stmt->bindParam(':first_name',$this->first_name);
        $stmt->bindParam(':last_name',$this->last_name);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':password',$this->password);

        if($stmt->execute()){
            //User Created
            return true;
        }
        //User Not Created
        printf('Error %s. \n', $stmt->error);
        return false;

    }


}
