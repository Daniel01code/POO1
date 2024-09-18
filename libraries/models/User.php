<?php
namespace Models; 
  
class User extends Model {

    protected $table="users";

    /******************************************fonction user****************************************************** */

    function verify_input_register($username,$email,$password,$confir_password){
        // Pseudo--------------------------------
        if (!isset($username) || !preg_match("#^[a-zA-Z0-9_]+$#", $_POST['username'])) {
        
        
         return $errors = "Pseudo non valide";
        
        } else{
        
            $query = "SELECT * FROM users WHERE username = ?";
            $req = $this->pdo->prepare($query);
            $req->execute([$username]);
            if ($req->fetch()) {
            
            return $errors = "Ce pseudo n'est plus disponible";
            
            }
        }
        

        // Email---------------------------------------
        if (!isset($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            
            return $errors = "Email non valide";

        } else {
            // SELECT * FROM users WHERE email = post
            $query = "SELECT * FROM users WHERE email = ?";
            $req = $this->pdo->prepare($query);
            $req->execute([$email]);
                if ($req->fetch()) {
                return $errors = "Cet email est déjà pris";
                }
        }

        // Password-----------------------------------------
        if (!isset($password)) {
            return $errors = "Vous devez entrer un mot de passe ";
        } else if ($password !== $confir_password) {
            return $errors = "Votre mot de passe ne correspond pas !";
        }

    }

    function register_user($username,$mail,$password,){
        $password=password_hash($password, PASSWORD_BCRYPT);

        // INSERT INTO------------------------------------------
        $query = "INSERT INTO users(username,email,password) VALUES(?,?,?)";
        $req = $this->pdo->prepare($query);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $req->execute([$username, $mail, $password]);


    }
    function user_existe($email,$password){
        // Vérification des informations de connexion
            $query = "SELECT * FROM users
            WHERE (email = :email OR username =:email)";
            $query = $this->pdo->prepare($query);
            $query->execute([
                'email' => $email, 
                'password' => $password
            ]);
     return $user = $query->fetch();
    }


}
