<?php

namespace App\Command;

use App\DTO\ScrapeCategoryDTO;
use App\Service\ScrapingService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:scrape-category',
    description: 'Scrape products from a category',
)]
class ScrapeCategoryCommand extends Command
{
    public function __construct(
        private readonly ScrapingService $scrapingService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('type', 't', InputOption::VALUE_REQUIRED, 'Scraper type (ebay, amazon)', 'ebay')
            ->addOption('category', 'c', InputOption::VALUE_REQUIRED, 'Category to scrape')
            ->addOption('pages', 'p', InputOption::VALUE_REQUIRED, 'Number of pages to scrape', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $scrapeCategoryDTO = new ScrapeCategoryDTO(
            scraperType: $input->getOption('type'),
            category: $input->getOption('category'),
            pages: (int) $input->getOption('pages'),
        );

        $this->scrapingService->scrapeCategory($scrapeCategoryDTO);

        return Command::SUCCESS;
    }
}
