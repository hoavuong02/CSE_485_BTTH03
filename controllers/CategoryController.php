<?php
require_once 'vendor/autoload.php';
include("services/CategoryService.php");
// include("models/Article.php");
require 'configs/includes/auth.php';
class CategoryController{
    public function index(){
            
            $loader = new \Twig\Loader\FilesystemLoader("templates");
            $twig = new Twig\Environment($loader);
            // Nhiệm vụ 1: Tương tác với Services/Models
            $categoryService = new CategoryService();
            $categorys = $categoryService-> getAllCategory();
            $data['category'] = $categorys;
            echo $twig->render('/category/index.html', $data); 
    }

    
   //add
    public function add(){
        $categoryService = new CategoryService();
        $nameCategory = $categoryService -> addCategorySql();
        header("Location: index.php?controller=category");
    }

    public function Routeradd(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        echo $twig->render('/category/add_category.html'); 
    }

    //delete
    public function delete(){

        $categoryService = new CategoryService();
        $delcategory = $categoryService -> deleteCategorySql();

        // echo $twig->render('/category/index.html'); 
        header("Location: index.php?controller=category&success");

        // if(isset($_GET['success'])){
        //     echo '
        //     <div class="container mt-3">
        //            <div class="alert alert-success alert-dismissible">
        //                 <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        //                 <strong>Success!</strong> Xóa Thành Công
        //             </div>
        //         </div>
        //     ';
        // }
    }

    //edit

    public function Routeredit(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $categoryService = new CategoryService();
        $editCategoryId = $categoryService ->editCategorySql();
        $data['category'] = $editCategoryId;
        // print_r($data['category']);
        echo $twig->render('/category/edit_category.html',$data); 
    }

    public function edit(){
        
        $categoryService = new CategoryService();
        $processCategory =  $categoryService ->processEditCategory();

        header("Location: index.php?controller=category");
    }


}
// echo "đây là ArticleController";
?>
