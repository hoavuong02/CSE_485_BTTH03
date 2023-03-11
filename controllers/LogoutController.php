<?php
    include("services/UserService.php");
    require_once 'vendor/autoload.php';
    class LogoutController{
        public function index(){
            $loader = new \Twig\Loader\FilesystemLoader("templates");
            $twig = new Twig\Environment($loader);
            $userService = new UserService();
            $userLogOut = $userService->userLogOut();
            // include("views/login/login.php");
            if(isset($_COOKIE["username"])){
                $cookieUN = $_COOKIE["username"];
                $cookiePS = $_COOKIE["password"];
                echo $twig->render('/login/index.html',[
                    'cookieUsername'=>$cookieUN,
                    'cookiePassword'=>$cookiePS,
                ]);
            }
            else{
                echo $twig->render('/login/index.html');
            }
            
            
            // echo $twig->render('/login/index.html');
        }
      
      
    }
?>   