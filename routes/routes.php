<?php

use App\Controllers\back\UserController;
use App\Controllers\front\ArticleController;

use App\Core\Router;

$router = new Router();


$router->get('/', [UserController::class, 'register']);
$router->get('/register', [UserController::class, 'register']);
$router->post('/register', [UserController::class, 'handleRegister']);

$router->get('/login', [UserController::class, 'login']);
$router->post('/login', [UserController::class, 'handleLogin']);

$router->get('/logout', [UserController::class, 'logout']);
$router->get('/home', [ArticleController::class, 'FetchArticle']);

$router->post('/createArticle', [ArticleController::class, 'CreateArticle']);
$router->get('/deleteArticle/{id}', [ArticleController::class, 'deleteArticle']);

$router->dispatch();
