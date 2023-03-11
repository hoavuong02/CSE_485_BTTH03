<?php
include("services/UserService.php");
require_once 'vendor/autoload.php';
require 'configs/includes/auth.php';
class UserController{
    public function index(){              
        $userName = $_SESSION['user']; 
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $userService = new UserService();
        $users = $userService-> getAllUser();
        // include("views/user/user.php");
        $data['user'] = $users;
        // var_dump($data);
        echo $twig->render('/user/index.html',$data);
    }


    // public function showAllUser(){
    //     $userService = new UserService();
    //     $user = $userService-> getAllUser();
        
    //     include("views/user/user.php");
    // }
    public function Add(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
    //    include("views/user/add_user.php");
        echo $twig->render('/user/add_user.html');
    }

    public function processAdd(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $userService = new UserService();
        $processAdd = $userService-> processAddUser();
       // include("views/user/add_user.php");
    }

    public function edit(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $userService = new UserService();
        $userWithId = $userService->selectEditUser();
        // include("views/user/edit_user.php");
        $data['UserWithId'] = $userWithId;
        echo $twig->render('/user/edit_user.html',$data);
    }

    public function processEdit(){
        // $loader = new \Twig\Loader\FilesystemLoader("templates");
        // $twig = new Twig\Environment($loader);
        $userService = new UserService();
        $processEdit = $userService-> processEditUser();
        
    }

    public function delete(){
        // $loader = new \Twig\Loader\FilesystemLoader("templates");
        // $twig = new Twig\Environment($loader);
        $userService = new UserService();
        $userDelete = $userService-> deleteUser();
        // include("views/user/user.php");
        
    }
}
?>