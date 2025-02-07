<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

use PDO;
use PDOException;

class Article extends Model {
    protected $table = 'articles';
    public $title;
    public $content;
    public $Author_id;

    public function save()
    {
        $db = Database::getInstance();
        $query = $db->getConnection()->prepare("INSERT INTO " . $this->getTable() . " (title, content,author_id) VALUES (:title, :content, :author_id)");
        $query->bindParam(':title', $this->title);
        $query->bindParam(':content', $this->content);
        $query->bindParam(':author_id', $this->Author_id);

        if ($query->execute()) {
            return $db->getConnection()->lastInsertId();
        } else {
            return false;
        }
    }
    public function fetch() {
        $db = Database::getInstance();
        $conn = $db->getConnection();
    
        if (!$conn) {
            die("Database connection failed!");
        }
    
        try {
            $query = $conn->prepare("SELECT * FROM articles");
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!$result) {
                die ("No records found!");
            }
            return $result;
        } catch (PDOException $e) {
            die("Fetch Error: " . $e->getMessage());
        }
    }

    function deleteArticle($id)
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }




}
