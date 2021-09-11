<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Core\Controller\AController;

class CommentController extends AController
{
    public function validate($id) {
        $data = [
            'id' => $id,
            'validated' => 1
        ];

        $commentRepository = new CommentRepository();
        $commentRepository->edit($data);

        $this->redirect('/' . $_SESSION['last-route']);
    }

    public function delete($id) {
        $commentRepository = new CommentRepository();
        $commentRepository->delete($id);

        $this->redirect('/' . $_SESSION['last-route']);
    }
}