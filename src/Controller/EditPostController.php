<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Core\Controller\AController;
use App\Entity\Post;

class EditPostController extends AController
{

    private $post;

    public function __construct()
    {
        $this->post = new Post();
    }

    public function edit($slug = null)
    {

        $post = [
            'title' => 'Nouvel article',
            'description' => 'Description du nouvel article',
            'content' => 'Contenu du nouvel article'
        ];

        $headTitle = 'Nouvel article - Romain Royer';

        $postRepository = new PostRepository();

        if ($_POST) {
            /*var_dump($_POST, $_FILES);
            die();

            if($_FILES['featured-image']) {
                var_dump($_FILES);
                $tmpName = $_FILES['featured-image']['tmp_name'];
                $name = $_FILES['featured-image']['name'];
                $size = $_FILES['featured-image']['size'];
                $error = $_FILES['featured-image']['error'];
                $targetDir = "uploads/";
                $filename = $book->getCoverFile()->getFilename();
                $targetFile = $targetDir . uniqid() . '-' . basename($filename);
                $book->getCoverFile()->moveTo($targetFile);
                $book->setCoverFilename($filename);
            }*/

            $_POST['published_date'] = date("Y-m-d H:i:s");

            if (!$_POST['slug']) {
                $_POST['slug'] = $this->slugify($_POST['title']);
            }
            $slug = $_POST['slug'];

            $post = $postRepository->findOneBy(['id' => $_POST['id']]);
            if ($post) {
                $post = $postRepository->edit($_POST);
            } else {
                $post = $postRepository->add($_POST);
            }

            var_dump($post);
            $this->redirect('/blog/' . $post['slug']);
        }

        if ($slug) {
            $post = $postRepository->findOneBy(['slug' => $slug]);
            if (!$post) throw new \Exception('Aucun article ne correspond à cet identifiant');
            $headTitle = $post->title . ' - Romain Royer';
        }

        $this->render('edit-post.html.twig', [
            'headTitle' => $headTitle,
            'post' => $post
        ]);
    }

    public function delete($slug)
    {
        $postRepository = new PostRepository();
        $postRepository->delete($slug);
        $this->redirect('/blog');
    }

    public static function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'new-post-' . date("Y-m-d-H-i-s");
        }

        return $text;
    }

}