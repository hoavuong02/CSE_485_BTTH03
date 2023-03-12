<?php
require_once 'vendor/autoload.php';
include("services\ArticleService.php");



class HomeController{
    // Hàm xử lý hành động index
    public function index(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        // Nhiệm vụ 1: Tương tác với Services/Models
        $articelService = new ArticleService();
        $articles = $articelService->getAllArticles();
        $data['article'] = $articles;
        echo $twig->render('/home/index.html', $data); 

    }
    
}
