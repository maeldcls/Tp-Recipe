<?php

namespace App\Controller;

use App\Entity\FeedBack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\FetchRecipeService;
use App\Service\FeedBackService;
use App\Form\FeedBackType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(FetchRecipeService $fetchrecipe, FeedBackService $feedBackService,Request $request, SessionInterface $session): Response
    {
      
        if ($session->has('recipeId')) {
            $recipeId = $session->get('recipeId');
            $recipe = $fetchrecipe->getRecipeById($recipeId);
        }
        else{
            $recipe = $fetchrecipe->getRandomRecipe();
            $session->set('recipeId', $recipe['id']);
        }
 
        $form = $this->createForm(FeedBackType::class, null);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data['feedback'] = $form->getData();
            $data['recipe'] = $recipe;
            $feedBackService->writeComment($data);

            return $this->redirectToRoute('app_feedback');
        }

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
            'recipe' => $recipe,
            'form' => $form->createView(),
        ]);
    }
}
