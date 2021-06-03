<?php

namespace App\Entity;

use Core\Entity\AModel;

class Post extends AModel
{

    public function getPosts () {
        return $this->sql('SELECT * FROM posts');
    }

    public function getPost($slug) {
        $params = ['slug' => $slug];
        return $this->sql('SELECT * FROM posts WHERE slug = :slug', $params);
    }

}