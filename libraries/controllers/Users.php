<?php

namespace controllers;
require_once('libraries/models/Model.php');  
require_once"libraries/utils.php";


class user extends Model{

public function register(){
    $userModel = new \Model\user();
        if (isset($_POST['register'])) {

            $username=htmlspecialchars($_POST['username']);
            $mail=htmlspecialchars($_POST['email']);
            $password=$_POST['password'];
            $confir_password =$_POST['confirm_password'];
              $errors = "";
              $errors = $userModel->verify_input_register($username,$mail,$password,$confir_password);
           
             if (!$errors){
                $userModel->register_user($username,$mail,$password,);

              redirect("login");
             }
        }
           
          
        // require"templates/articles/register_html.php";
          
    render('articles/register'/*, compact('errors')*/);
          
}
public function login(){
    $userModel = new \Model\user();

        session_start();

        if (isset($_POST['login'])) {
            $errors = "";
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (!empty( $email) && !empty($password)) {
        
                $user = $userModel->user_existe($email,$password);
        
                
                // Si les informations de connexion sont correctes, on crée une session et on redirige vers la page d'accueil de l'admin ou l'utilisateur
        
                if ($user && $user = $userModel->password_verify($_POST['password'], $user['password'])) {
                    // $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['auth'] = $user;
                    $_SESSION['id'] = $user['id'];
                   
        
                    // Redirection en fonction du rôle
                    switch ($user['role']) {
                        case 'admin':
                            // header("Location: admin_dashboard.php?id=" . $_SESSION['auth']['id']);
        
                            redirect("admin_dashboard.php?id=" . $_SESSION['auth']['id']);
                            
                            break;
        
                        default:
                            // header("Location: user_dashboard.php?id=" . $_SESSION['auth']['id']);
                            redirect("user_dashboard.php?id=" . $_SESSION['auth']['id']);
                            break;
                    }
                } else {
                    $errors = "Email ou mot de passe incorrect.";
                }
            }else{
                $errors = "Tous les champs doivent être remplis.";
            }
        }
        
        render('articles/login');
        
        
}
public function logout(){
        session_start();
        session_unset();
        session_destroy();
        // header("location: index.php");
        // exit();
        redirect("index.php");

}

}