<?php

namespace App\Controllers\front;

use App\Core\Controller;
use App\Core\Session;
use App\models\Article;
use App\Core\Auth;

session_start();
class ArticleController extends Controller {

        public function CreateArticle(): void
        {

                $title = $_POST['title']; 
                $content = $_POST['content'];
                $article = new Article();
                $article->title = $title;
                $article->content = $content;
                $article->Author_id = $_SESSION["user_id"];
                $article->save();

                header('location: \home');

        }

        public function FetchArticle(): void
        {
            $session = new Session();
            $user_role = $session->get('user_role');
            $article = new Article();
            $articles = $article->fetch();

            $this->view('home', [
                'user_role' => $user_role,
                'articles' => $articles
            ]);
        }

    public function deleteArticle($id)
    {
        $article = new Article();
        $article->deleteArticle($id);
        header('location: \home');
    }


}
