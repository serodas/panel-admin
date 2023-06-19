<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CommentProcessor
{
    public function __construct(
        private Security $security,
        private CommentRepository $commentRepository
    ) {
    }

    public function __invoke(Comment $comment, Post $post): Comment
    {
        $comment->setPost($post);
        $comment->setUser($this->security->getUser());
        $this->commentRepository->save($comment, true);
        return $comment;
    }
}
