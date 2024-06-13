<?php

namespace App\Controller;

use App\Service\FeedBackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FeedBackController extends AbstractController
{
    #[Route('/feedback', name: 'app_feedback')]
    public function index(FeedBackService $feedBackService): Response
    {
        $feedback = $feedBackService->getFeedBackByUser();

        return $this->render('feed_back/index.html.twig', [
            'controller_name' => 'FeedBackController',
            'feedbacks' => $feedback,
        ]);
    }
}
