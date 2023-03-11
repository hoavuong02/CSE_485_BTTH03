<?php
require_once 'vendor/autoload.php';
include("services/AuthorService.php");
// include("models/Article.php");
require 'configs/includes/auth.php';
class AuthorController{
    public function index(){
        // require 'configs/include/headerAdmin_global.php';
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);

        $authorService = new AuthorService();
        $authors = $authorService-> getAllAuthor();
        $data['author'] = $authors;
        echo $twig->render('/author/index.html', $data); 
        // header("Location: index.php?controller=category");
    }

    //add
    public function add(){
        $authorService = new AuthorService();
        $addAuthor =  $authorService -> addAuthorSql();
        header("Location: index.php?controller=author");
    }

    public function Routeradd(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        echo $twig->render('/author/add_author.html');
    }

    //delete
    public function delete(){
        $authorService = new AuthorService();
        $deleteAuthor =  $authorService -> deleteAuthorSql();
        // header("Location: index.php?controller=author");
    }

    //edit

    public function Routeredit(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);

        $AuthorService = new AuthorService();
        $editAuthorId = $AuthorService ->editAuthorSql();

        $data['author'] = $editAuthorId;
        echo $twig->render('/author/edit_author.html',$data); 
    }

    public function edit(){
        $AuthorService = new AuthorService();
        $processAuthor =  $AuthorService ->processEditAuthor();
        header("Location: index.php?controller=author");
    }



}

?>