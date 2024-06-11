<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\FetchRecipeService;

#[AsCommand(
    name: 'app:parse-recipes',
    description: 'Add a short description for your command',
)]
class ParseRecipesCommand extends Command
{
    private $fetchRecipeService;

    public function __construct(FetchRecipeService $fetchRecipeService)
    {
        parent::__construct();
        $this->fetchRecipeService = $fetchRecipeService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->fetchRecipeService->jsonToDatabase(dirname(__DIR__,2),'/public/utils/recipes.json');
            $io->success('Recipes have been successfully imported.');
            
        } catch (\Exception $e) {
            $io->error('Error importing recipes: ' . $e->getMessage());
            return Command::FAILURE;
        }
        return Command::SUCCESS;
        // if (!empty($recipesArray)) {
        //     $io->writeln('Found '.count($recipesArray).' recipes');
        //     $io->listing($recipesArray);
        //     $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        //     return Command::SUCCESS;
        // } else {
        //     $io->error('No recipes found');
        //     return Command::FAILURE;
        // }
    }
}
