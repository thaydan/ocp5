<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Core\Controller\AController;

class CommentController extends AController
{
    public function validate($id) {
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($id);

        $data = [
            'id' => $id,
            'validated' => 1
        ];
        $commentRepository->edit($data);

        $postRepository = new PostRepository();
        $post = $postRepository->find($comment->id_post);

        $this->redirect('/blog/'. $post->slug);
    }

    public function delete($id) {
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->find($id);

        $postRepository = new PostRepository();
        $post = $postRepository->find($comment->id_post);

        $commentRepository->delete($id);

        $this->redirect('/blog/'. $post->slug);
    }
}