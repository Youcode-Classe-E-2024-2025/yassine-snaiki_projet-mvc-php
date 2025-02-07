<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected $twig;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../views/front');
        $this->twig = new \Twig\Environment($loader);
    }

    public function view(string $view, array $data = [])
    {
        echo $this->twig->render($view . '.twig', $data); 
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
        exit;
    }
}
