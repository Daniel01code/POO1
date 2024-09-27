<?php

namespace controllers;

class user extends controller{
    protected $model_name = \Models\User::class;

    public function register(){
    
        if (isset($_POST['register'])) {

            $username=htmlspecialchars($_POST['username']);
            $mail=htmlspecialchars($_POST['email']);
            $password=$_POST['password'];
            $confir_password =$_POST['confirm_password'];
              $errors = "";
              $errors = $this->model->verify_input_register($username,$mail,$password,$confir_password);
           
             if (!$errors){
                $this->model->register_user($username,$mail,$password,);

                \Http::redirect("login");
             }
        }
           
          
        // require"templates/articles/register_html.php";
          
        \Renderer::render('articles/register');
          
}
public function login(){

        session_start();

        if (isset($_POST['login'])) {
            $errors = "";
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (!empty( $email) && !empty($password)) {
        
                $user = $this->model->user_existe($email,$password);

                
                
                // Si les informations de connexion sont correctes, on crée une session et on redirige vers la page d'accueil de l'admin ou l'utilisateur
        
                if ($user &&  password_verify($_POST['password'], $user['password'])) {
                    // var_dump($user);
                    // die();
                    // $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['auth'] = $user;
                    $_SESSION['id'] = $user['id'];
                    
                   
        
                    // Redirection en fonction du rôle
                    switch ($user['role']) {
                        case 'admin':
                            // header("Location: admin_dashboard.php?id=" . $_SESSION['auth']['id']);
        
                            \Http::redirect("admin_dashboard.php");
                            
                            break;
        
                        default:
                            // header("Location: user_dashboard.php?id=" . $_SESSION['auth']['id']);  
                            \Http::redirect("user_dashboard.php");
                            break;
                    }
                } else {
                    $errors = "Email ou mot de passe incorrect.";
                }
            }else{
                $errors = "Tous les champs doivent être remplis.";
            }
        }
        
        \Renderer::render('articles/login');
        
        
}
public function logout(){
        session_start();
        session_unset();
        session_destroy();
        // header("location: index.php");
        // exit();
        \Http::redirect("index.php");

}
public function userdahbord(){
        session_start();

        $articleModel = new \Models\Article();


        if($_SESSION['role'] !== 'default'){

            \Http::redirect("index.php");
        }
        // var_dump($_SESSION['auth']);
        // die();

        //recuperation des articles

        $articles = $articleModel->find_all("created_at DESC");

        // require"templates/users/user_dashboard_html.php";


        \Renderer::render('users/user_dashboard', compact('articles'));

}


}