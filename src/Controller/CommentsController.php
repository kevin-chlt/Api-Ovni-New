<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/comments")]
class CommentsController extends AbstractController
{
    #[Route("/send/{id}", methods: ['POST'])]
    public function sendComment (Request $request, Articles $articles) : JsonResponse
    {
        $comment = $request->getContent();
        //$articles->addComment($comment);

        return $this->json($comment);

    }

    #[Route("/{articles_id}", methods: ['GET'])]
    public function getComments (Request $request, Comments $comments) : JsonResponse
    {
        $comment = $request->getContent();
        //$articles->addComment($comment);

        return $this->json($comment);

    }
}