<?php

namespace App\Console\Commands;

use App\Services\NewsService;
use Illuminate\Console\Command;

class NewsCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:search {search-keyword} {-} {number-of-last-days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape news by keyword and save to database';


    public function handle(NewsService $newsService): int
    {
//        $newsService->getNews(
//            keyWord: $this->getInput('search-keyword') ,
//            numberOfDays: $this->getInput('Number-of-last-days'),
//        );

        $keyWord = $this->argument('search-keyword') ;
        $numberOfLastDays = $this->argument('number-of-last-days') ?? 7;
        $newsService->getNews(
            keyWord: $keyWord,
            numberOfLastDays: $numberOfLastDays,
        );
        $this->components->info('created successfully!');
        return self::SUCCESS;
    }
}
