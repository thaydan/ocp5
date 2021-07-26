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
            $_POST['published_date'] = date("Y-m-d H:i:s");

            if(!$slug) {
                $slug = $this->slugify($_POST['title']);
            }

            $post = $postRepository->findOneBy(['slug' => $slug]);
            if($post) {
                $post = $postRepository->edit($slug, $_POST);
            }
            else {
                $post = $postRepository->add($slug, $_POST);
            }

            $this->redirect('/blog/' . $slug);
        }

        if ($slug) {
            $post = $postRepository->findOneBy(['slug' => $slug]);
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
            return 'new-post-'. date("Y-m-d-H-i-s");
        }

        return $text;
    }

}