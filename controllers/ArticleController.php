<?php

    include("services\ArticleService.php");
class ArticleController{

    public function detail(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $serviceDetail = new ArticleService();
        $detailArticle = $serviceDetail->getDetailArticle();
        $nameCategory = $serviceDetail->getCategorybyArticle($detailArticle['ma_tloai']);
        $nameAuthor = $serviceDetail->getAuthorbyArticle($detailArticle['ma_tgia']);
        $data['article'] = $detailArticle;
        $data['nameCategory'] = $nameCategory;
        $data['nameAuthor'] = $nameAuthor;
        echo $twig->render('/article/detail.html', $data); 
    }

    public function search(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $serviceSearch = new ArticleService();
        $searchedlArticle = $serviceSearch->getSearchedArticles();
        $data['article'] = $searchedlArticle;
        echo $twig->render('/article/search.html', $data); 
    }

    public function list(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $serviceDetail = new ArticleService();
        $listArticles = $serviceDetail->getListArticles();
        $data['article'] = $listArticles;
        echo $twig->render('/article/list.html', $data); 
    }

    public function add(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $articleService = new ArticleService();
        $categorys = $articleService->getAllCategory();
        $authors = $articleService->getAllAuthor();
        $data['category'] = $categorys;
        $data['author'] = $authors;
        echo $twig->render('/article/add.html', $data); 
    }

    public function processAdd(){
        $articleService = new ArticleService();
        $processAdd = $articleService-> addArticle();
        header("Location: index.php?controller=article&action=list");
    }

    public function edit(){
        $loader = new \Twig\Loader\FilesystemLoader("templates");
        $twig = new Twig\Environment($loader);
        $serviceDetail = new ArticleService();
        $detailArticle = $serviceDetail->getDetailArticle();
        $nameCategory = $serviceDetail->getCategorybyArticle($detailArticle['ma_tloai']);
        $nameAuthor = $serviceDetail->getAuthorbyArticle($detailArticle['ma_tgia']);

        $nameCategoryExcept = $serviceDetail->getALLCategoryExcept($detailArticle['ma_tloai']);
        $nameAuthorExcept = $serviceDetail->getAllAuthorExcept($detailArticle['ma_tgia']);

        $data['article'] = $detailArticle;
        $data['nameCategory'] = $nameCategory;
        $data['nameAuthor'] = $nameAuthor;

        $data['nameCategoryExcept'] = $nameCategoryExcept;
        $data['nameAuthorExcept'] = $nameAuthorExcept;

        echo $twig->render('/article/edit.html', $data); 
    }

    public function processEdit(){
        $articleService = new ArticleService();
        $processEdit = $articleService-> processEditArticle(); 
    }

    public function delete(){
        $articleService = new ArticleService();
        $delete = $articleService-> deleteArticle(); 
    }
    

}