<?php 
namespace Core\Controllers;

use Core\Views\View;
use Core\Models\Article;
use Core\Models\User;

class ArticleController extends Controller{

    public function show($id)
    {
       $article = Article::getById($id);
       if(!$article){
            View::render('errors/404', [], 404);
            return;
       }

       //$author = User::getById($article->user_id);

       View::render('articles/show', compact('article'));
    }
    
    public function edit($id)
    {
        $article = Article::getById($id);
        if(!$article){
            View::render('errors/404', [], 404);
            return;
        }
        $article->name = 'New article';
        $article->text = 'Tex for New article';
        $this->dump($article);
    }
}

//ORM - Object Relation Mapping

//Singletone - создаеться только один экземпляр класса

