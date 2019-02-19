<?php
    

    // $con = mysqli_connect("localhost","my_user","my_password","my_db");

class Login {

    protected $localhost = 'localhost';
    protected $user = 'fabiovalinhos';
    protected $password = 'cebola';
    protected $db = 'conn';
    public $errors = array();


    protected $conn;

    function __construct(){
        $this->conn = mysqli_connect($this->localhost, $this->user, $this->password, $this->db);

        if (mysqli_connect_errno()) {
            die("Conexão falhou: " . mysqli_connect_errno());
        }
    }

    protected function checkInput($var){

        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripslashes($var);

        return $var;
    }

    public function insertIntoTb($username, $password) {

        $username = $this->checkInput($username);
        $pass = $this->checkInput($password);


        if ($this->checkErrors($username, $pass)) {

           if ($this->checkUsersname($username)){

                if ($this->insertDB($username, $password)) {
                    $this->errors = ["Succesfully insert data in DB"];
                }
            }
        }

    }

    protected function checkErrors($username, $password) {
        if ( strlen($username) > 10 || strlen($username) < 4 ) {
            array_push($this->errors, 'This username should be between 4 and 10 characters' );

            return false;
        }

        if ( strlen($password) < 4 || strlen($password) > 8 ) {
            array_push($this->errors, 'Password should be between 4 and 8 characters' );

            return false;
        }

        return true;
    }

    protected function insertDB($username, $password) {
        $query = "INSERT INTO users(username, password) ";
        $query .= "VALUES ('{$username}', '{$password}')";

        mysqli_query($this->conn, $query);

        if (mysqli_affected_rows($this->conn) > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkUsersname($username) {
        $query = "SELECT username FROM users WHERE username = '{$username}'";

        mysqli_query($this->conn, $query);

        if (mysqli_affected_rows($this->conn) > 0) {

            echo "<br>";
            array_push($this->errors, "Username already in our DB");
            return false;

        } else {

            return true;

        } 
    }
}

?>