<?php

namespace Model;

require_once '../Model/Model.php';

class Post extends \Model {

    public function getPosts () {
        $sql = 'SELECT *
            FROM posts';
        $posts = $this->executeRequest($sql, []);
        return $posts->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPost($slug) {

        $sql = 'SELECT * FROM posts WHERE id = :id';
        $post = $this->executeRequest($sql, [':id' => $slug]);

        if ($post->rowCount() == 1) {
            return $post->fetch();
        }
        else {
            throw new \Exception("Aucun article ne correspond à l'identifiant '$slug'");
        }

    }

}