<?php
    require "configs/DBConnection.php";
    require "models/User.php";
    class UserService{
        // Chứa các hàm tương tác và xử lý dữ liệu

        public function getAllUser(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            $showAllUserSql = "SELECT * FROM user order by ten_dnhap";
            $stmt = $conn->getConnection()->prepare($showAllUserSql);
            $stmt->execute();
            // $users = [];
            // while($row = $stmt->fetch()){
            //     $user = new User($row['ten_dnhap'], $row['mat_khau'], $row['email'], $row['ngay_dki'], $row['admin']);
            //     array_push($users,$user);
            // }
            $users = [];
            while($row = $stmt->fetch()){
                $user = new User($row['ten_dnhap'], $row['mat_khau'], $row['email'], $row['ngay_dki'], $row['admin'], $row['hashCode'], $row['active'] );
                $array = $user->convertToArray();
                array_push($users,$array);
            }
            return $users;
        
            
            return $users;
        }

        public function processAddUser(){
 
            $conn = new DBConnection();
            $txtUserName= $_POST['txtUserName'];
            $txtUserPass= $_POST['txtUserPass'];
            $txtUserEmail= $_POST['txtUserEmail'];
            $txtUserAdmin= $_POST['txtUserAdmin'];    
            $txtActive= $_POST['txtUserActive'];  
            $addUserSql = "INSERT INTO user(ten_dnhap,mat_khau,email,ngay_dki,admin,active) VALUES ('$txtUserName','$txtUserPass','$txtUserEmail',current_timestamp(), '$txtUserAdmin','$txtUserActive')";
            $stmt = $conn->getConnection()->prepare($addUserSql);
            if($stmt->execute()){
                header("Location: index.php?controller=user&action=index");
    
              echo "OK";
            }
         
         }

        public function selectEditUser(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            $getId = $_GET['id'];            
            $showUserWithId = "SELECT * FROM user WHERE ten_dnhap = '$getId'";
            
            $stmt = $conn->getConnection()->prepare($showUserWithId);
            $stmt->execute();
            // $userWithId = $stmt->fetch();
            // $user = new User($userWithId['ten_dnhap'], $userWithId['mat_khau'], $userWithId['email'], $userWithId['ngay_dki'], $userWithId['admin']);
            // return $user;
            $userSelect = $stmt->fetch();
            // $users = [];
            $user = new User($userSelect['ten_dnhap'], $userSelect['mat_khau'], $userSelect['email'], $userSelect['ngay_dki'], $userSelect['admin'], $userSelect['hashCode'], $userSelect['active'] );
            $array = $user->convertToArray();
            
            return $array;

        }

        public function processEditUser(){
 
            $conn = new DBConnection();
            $userName = $_POST['txtUserName'];
            $password = $_POST['txtPasword'];
            $email = $_POST['txtEmail'];
            $admin = $_POST['txtAdmin'];     
            $active = $_POST['txtActive'];
            $updateUserSql = "UPDATE user SET mat_khau = '$password', email = '$email', admin = '$admin',active = $active WHERE ten_dnhap =  '$userName'";
            $stmt = $conn->getConnection()->prepare($updateUserSql);
            $stmt->execute();
            if($stmt->execute()){
                header("Location: index.php?controller=user&action=index");
            }

            
            
         }

        public function deleteUser(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            $getId = $_GET['id'];
            // echo $getId;
            $deleteCategorySql = "DELETE FROM user WHERE ten_dnhap = '$getId'  ";
            $stmt = $conn->getConnection()->prepare( $deleteCategorySql);
            $stmt->execute();
            // Bước 03: Trả về dữ liệu
            if($stmt->execute()){
                header("Location: index.php?controller=user&action=index");
            }
            
            
        }

        public function userLogin(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            session_start();
            if(isset($_POST['txtUser'])) 
            {
                $user = $_POST['txtUser'];
                $password = $_POST['txtPassword'];           
            //tìm trong db bản ghi có tên đăng nhập và mật khẩu giống với người dùng nhập vào
                $getUserPassword = "SELECT ten_dnhap, mat_khau, active FROM `user` WHERE ten_dnhap = '$user ' AND mat_khau = '$password'";
                $stmt = $conn->getConnection()->prepare( $getUserPassword);
                $stmt->execute();
                $row = $stmt->fetch();
                // Bước 03: Trả về dữ liệu               
                if($row){
                    if($row['active'] != 1) {
                        header("Location: index.php?controller=login&action=index&error=not actived yet");
                    }
                    $_SESSION['user'] = $user;
                    header("Location: index.php?controller=admin&action=index");
                }
                else {
                    header("Location: index.php?controller=login&action=index&error=invalid user or password");
                }
                if(!empty($_POST["remember"])) {
                    setcookie ("username",$user,time()+ 3600);
                    setcookie ("password",$password,time()+ 3600);
                } else {
                    setcookie("username","");
                    setcookie("password","");
                }
            }
            
        }

        
        public function getUserLogin(){
            // Bước 01: Kết nối DB Server
            //require db
            $conn = new DBConnection();
            // Bước 02: Truy vấn DL
            // session_start();
            $userName = $_SESSION['user'];
            $isAdminSql = "SELECT * FROM `user` WHERE ten_dnhap='$userName'";
            
            $stmt = $conn->getConnection()->prepare($isAdminSql);
            $stmt->execute();
            $userLogin = $stmt->fetch();
            // $users = [];
            $user = new User($userLogin['ten_dnhap'], $userLogin['mat_khau'], $userLogin['email'], $userLogin['ngay_dki'], $userLogin['admin'], $userLogin['hashCode'], $userLogin['active'] );
            $array = $user->convertToArray();
            if($array['active']!=1){
                header("Location: index.php?controller=login&action=index&error=user not active");
            }
            else{
                return $array;

            }
            // $isAdmin = $userLogin['admin'];
            // return $isAdmin;
        }

        public function countUser(){
            $conn = new DBConnection();           
            $countUserSql = "SELECT COUNT(user.ten_dnhap)  FROM `user` ";
            $stmt = $conn->getConnection()->prepare($countUserSql);
            $stmt->execute(); 
            $userCounted = $stmt->fetchColumn();
                     
            return $userCounted;
            
        }
        public function processRegister() {
            $temp = explode('\\', dirname(__FILE__, 2));
            $lastItem = end($temp);
            include 'Utilities/email_sender.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                
                $userName = $_POST['txtUser'];
                $password = $_POST['txtPassword'];
                $email = $_POST['txtEmail'];
                
                $hash = rand(1000, 9999);
        
                $addUser = "INSERT INTO user(ten_dnhap, mat_khau, email,ngay_dki, hashCode) VALUES ('$userName','$password','$email',current_timestamp(), '$hash')";
                $dbConn = new DBConnection();
                $conn = $dbConn->getConnection();
        
                $stmt = $conn->prepare($addUser);
                $stmt->execute();
        
                $emailServer = new MyEmailServer();
                $emailSender = new EmailSender($emailServer);
                $emailSender->send($email, "This is a registration email", "http://localhost/" . $lastItem . "/index.php?controller=signUp&action=active&ten_dnhap=$userName&hashCode=$hash");
                
            }
        }

        public function activeRegisterUser(){
            $conn = new DBConnection(); 
            if(isset($_GET['ten_dnhap'])) {
                $getUserName = $_GET['ten_dnhap'];
                $getHashCode = $_GET['hashCode'];
                // echo $getUserName;
                // echo $getHashCode;
                $sqlUpdateActive = "SELECT * from user where ten_dnhap = '$getUserName' ";
                $stmt = $conn->getConnection()->prepare( $sqlUpdateActive);
                $stmt->execute();
                $row= $stmt->fetch();
                $user = new User($row['ten_dnhap'], $row['mat_khau'], $row['email'], $row['ngay_dki'], $row['admin'], $row['hashCode'], $row['active'] );
                $array = $user->convertToArray();
                // echo $array['hashCode'];
                if($getHashCode == $array['hashCode']) {
                    $updateUser = "UPDATE user SET active = '1' WHERE ten_dnhap =  '$getUserName'";
                    $stmt = $conn->getConnection()->prepare($updateUser);
                    $stmt->execute();
                    echo "Ban da dang ki thanh cong";
                    header("Location: index.php?controller=login&action=index");
                }
            } else {
                echo "Kích hoạt thất bại";
            }
     
        }
        // public function signUpUser(){
        //     $conn = new DBConnection();       
        //     if(isset($_POST['txtUser'])) 
        //     {
        //     $txtUserNameSU = $_POST['txtUser'];
        //     $txtUserPassSU = $_POST['txtPassword'];
        //     $txtEmailSU = $_POST['txtEmail'];                  
        //     $checkExitUserSql = "SELECT * FROM user";
        //     $stmt = $conn->getConnection()->prepare($checkExitUserSql);
        //     $row = $stmt->fetchAll();
        //     $stmt->execute();
        //     $foundName = false;
        //     $foundEmail = false;
        //     $users = [];
        //     while($row = $stmt->fetch()){
        //         $user = new User($row['ten_dnhap'], $row['mat_khau'], $row['email'], $row['ngay_dki'], $row['admin']);
        //         array_push($users,$user);
        //     }
              
        //     foreach($users as $value) {
        //         //echo $value->getTenDangNhap();
        //         if ($value->getTenDangNhap() == $txtUserNameSU ) {
        //             $foundName = true; // trùng lặp đánh dấu true
        //             break ; // thoát khỏi cả hai vòng lặp while và foreach
        //         }
                
        //         if ($value->getEmail() == $txtEmailSU ) {
        //             $foundEmail = true; // trùng lặp đánh dấu true
        //             break ; // thoát khỏi cả hai vòng lặp while và foreach
        //         }
        //         }
        //         echo $foundName;
                
            
           

        //     if($foundName){                   
        //         echo "<script>
        //             alert('Tên đăng nhập đã tồn tại');
        //             window.location.href = 'index.php?controller=signUp&action=index';
        //         </script> " ;
        //     }              
        //     if ($foundEmail) { 
        //         echo "<script>
        //             alert('Tên đăng nhập đã tồn tại');
        //             window.location.href = 'index.php?controller=signU&action=index';
        //         </script> " ;
        //     }
            
        //     else{
        //         $pushUserSql = "INSERT INTO user(ten_dnhap,mat_khau,email,ngay_dki) VALUES ('$txtUserNameSU','$txtUserPassSU','$txtEmailSU',current_timestamp())";
        //         $stmt = $conn->getConnection()->prepare($pushUserSql);
        //         if($stmt->execute()){
        //             header("Location: index.php?controller=login&action=index");
        //         }
                
        //         }
           
        // }
        // }
        public function countArticle(){
            $conn = new DBConnection();           
            $countArticleSql = "SELECT COUNT(baiviet.ma_bviet)  FROM `baiviet` ";
            $stmt = $conn->getConnection()->prepare($countArticleSql);
            $stmt->execute();
            $articleCounted = $stmt->fetchColumn();           
            return $articleCounted;
            
        }
        public function countAuthor(){
            $conn = new DBConnection();           
            $countAuthorSql = "SELECT COUNT(tacgia.ma_tgia)  FROM `tacgia` ";
            $stmt = $conn->getConnection()->prepare($countAuthorSql);
            $stmt->execute();
            $authorCounted = $stmt->fetchColumn();           
            return $authorCounted;
            
        }
        public function countCategory(){
            $conn = new DBConnection();           
            $countCategorySql = "SELECT COUNT(theloai.ma_tloai)  FROM `theloai` ";
            $stmt = $conn->getConnection()->prepare($countCategorySql);
            $stmt->execute();
            $categoryCounted = $stmt->fetchColumn();           
            return $categoryCounted;
            
        }

        public function userLogOut(){            
            session_start();
            if(isset($_SESSION['user'])){
                unset($_SESSION['user']);

            }
            

        }
    }

?>
