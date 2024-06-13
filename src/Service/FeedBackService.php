<?php
namespace App\Service;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;
use App\Command\ParseRecipesCommand;
use App\Entity\FeedBack;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\User;
use App\Repository\FeedbackRepository;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class FeedBackService
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function writeComment(array $data)
    {
        $recipeRepository = $this->entityManager->getRepository(Recipe::class);
        $feedBackRepository = $this->entityManager->getRepository(FeedBack::class);

        $feedBack = new FeedBack();
        $recipeId = $data['recipe']['id'];
        $user = $this->security->getUser();

        // $recipe = $recipeRepository->find($recipeId);
        $recipeReference = $this->entityManager->getReference(Recipe::class, $recipeId);

        $feedBackExists = $feedBackRepository->findOneBy(['username' => $user, 'recipe' => $recipeReference]);

        if($feedBackExists == null){
            $feedBack->setComment($data['feedback']->getComment());
            $feedBack->setRate($data['feedback']->getRate());
            $feedBack->setUserName($user);
            $feedBack->setRecipe($recipeReference);
            $this->entityManager->persist($feedBack);
            $this->entityManager->flush();
            return;
        }
    }

    public function getFeedBackByUser()
    {
        $user = $this->security->getUser();
        $feedBackRepository = $this->entityManager->getRepository(FeedBack::class);
        return $feedBackRepository->findFeedBackByUser($user);
    }
}