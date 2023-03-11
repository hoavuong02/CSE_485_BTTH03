<?php
    require_once 'vendor/autoload.php';
    include("services/UserService.php");
    require 'configs/includes/auth.php';
    define('APP_ROOT', dirname(__FILE__, 2));  
    
    class AdminController{
        public function index(){
            
            $userName = $_SESSION['user']; 
            $loader = new \Twig\Loader\FilesystemLoader("templates");
            $twig = new Twig\Environment($loader);
            $userService = new UserService();
            $userLogined = $userService-> getUserLogin();
            $userCount = $userService->countUser();
            $articleCount = $userService->countArticle();
            $authorCount = $userService->countAuthor();
            $categoryCount = $userService->countCategory();
            
          
            echo $twig->render('/admin/index.html',[
                'countUser'=> $userCount,
                'countCategory'=> $categoryCount,
                'countAuthor'=> $authorCount,
                'countArticle'=> $articleCount,
                'userLogined' => $userLogined 
                
            ]) ;
            
            // if( $checkAdmin->isAdmin()==1){
            //     echo 'TRue';
            // }
            // include("views/admin/index.php");
        }

        
    }
?>   