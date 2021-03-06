<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Core\Controller\AController;
use App\Entity\Post;
use Core\Security\Auth;
use Core\Upload\Upload;

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
            // set update date and author
            $_POST['updated_datetime'] = date("Y-m-d H:i:s");
            $_POST['author_id'] = Auth::getUser()->getID();

            $post = $postRepository->findOneBy(['id' => $_POST['id']]);

            // check slug
            $_POST['slug'] = trim($_POST['slug']);
            if (!$_POST['slug']) {
                $_POST['slug'] = $this->slugify($_POST['title']);
            }
            $postsWithSameSlug = $postRepository->findOneBy(['slug' => $_POST['slug']]);
            while ($postsWithSameSlug && $postsWithSameSlug->id != $_POST['id']) {
                $_POST['slug'] .= '-1';
                $postsWithSameSlug = $postRepository->findOneBy(['slug' => $_POST['slug']]);
            }

            // upload image
            if ($_FILES['featured-image']['size']) {
                $upload = new Upload();
                $upload->setFile($_FILES['featured-image']);
                $uploaded = $upload->run($_POST['slug']);
                if ($uploaded) {
                    if ($post) $upload->removeFile($post->featured_image); // if
                    $_POST['featured_image'] = $upload->getTargetFile();
                }
            }

            // save post
            if ($post) {
                $postRepository->edit($_POST);
            } else {
                $postRepository->add($_POST);
            }

            $this->redirect('/blog/' . $_POST['slug']);
        }

        if ($slug) {
            $post = $postRepository->findOneBy(['slug' => $slug]);
            if (!$post) throw new \Exception('Aucun article ne correspond ?? cet identifiant');

            $userRepo = new UserRepository();
            $post->author = (array)$userRepo->find($post->author_id, ['id', 'first_name']);
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
        $post = $postRepository->findOneBy(['slug' => $slug]);

        /* remove image file */
        if ($post->featured_image) {
            $upload = new Upload();
            $removed = $upload->removeFile($post->featured_image);
            if (!$removed) {
                throw new \Exception("Une erreur est survenue lors de la suppression de l'image li?? ?? cet article.<br>La suppression de l'article est annul??e");
            }
        }

        /* remove comments */
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->findBy(['id_post' => $post->id]);
        foreach ($comments as $comment) {
            $commentRepository->delete($comment->id);
        }

        $postRepository->deleteBySlug($slug);
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