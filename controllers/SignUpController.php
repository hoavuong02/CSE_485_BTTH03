<?php
    include("services/UserService.php");
    require_once 'vendor/autoload.php';
    class SignUpController{
        public function index(){
            include("templates/signup/index.html");
            
        }

        public function processSignUp(){
            $userService = new UserService();
            $processSignUpUser = $userService->processRegister();
          
        }
       
        public function active(){
            // $getUserName = $_GET['ten_dnhap'];
            // $getHashCode = $_GET['hashCode'];
            // echo $getUserName;
            // echo $getHashCode;
            $userService = new UserService();
            $emailActive = $userService->activeRegisterUser();
        }
    }
?>   