<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Service\CommentProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(PostRepository $postRepository): Response
    {
        return $this->render('page/home.html.twig', [
            'posts' => $postRepository->findLatest()
        ]);
    }

    #[Route('/blog/{slug}', 'app_post')]
    public function post(
        Request $request,
        Post $post,
        CommentProcessor $commentProcessor
    ): Response {
        $form = $this->createForm(CommentType::class, null, [
            'action' => $this->generateUrl('app_post', [
                'slug' => $post->getSlug()
            ])
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $comment = ($commentProcessor)($data, $post);
            // dd($comment);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('page/post.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }
}
