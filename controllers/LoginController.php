<?php
    include("services/UserService.php");
    require_once 'vendor/autoload.php';
  
    class LoginController{
        public function index(){
            // include("views/login/login.php");
            $loader = new \Twig\Loader\FilesystemLoader("templates");
            $twig = new Twig\Environment($loader);
            $error = $_GET['error'] ?? "";
            $cookieUN = $_COOKIE["username"] ?? "";
            $cookiePS = $_COOKIE["password"] ?? "";
            echo $twig->render('/login/index.html',[
                'cookieUsername'=>$cookieUN,
                'cookiePassword'=>$cookiePS,
                'error' => $error,
            ]);
            
        }

        // public function showAllUser(){
        //     $userService = new UserService();
        //     $user = $userService-> getAllUser();
            
        //     include("views/user/user.php");
        // }

        public function processLogin(){
            $userService = new UserService();
            $processLogin = $userService-> userLogin();
            
        }
      
    }
?>   