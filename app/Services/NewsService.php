<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use App\Traits\DataConversion;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class NewsService
{
    use DataConversion;

    protected $newsRepository;
    protected $client;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false, // Only for demo sites
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);
    }


    public function getNews($keyWord, $numberOfLastDays)
    {
        //http://127.0.0.1:8000/api/news/fa/search?query=ایران
        $sourceUrl = 'https://www.tasnimnews.com';

Log::info('day'.$numberOfLastDays);
        Log::info('keyWord'.$keyWord);
        $keyWordStatus=$this->newsRepository->isCategoryUnique($keyWord);
        if ($keyWordStatus) {
            Log::info('keyWordStatus True');
        }else {
            Log::info('keyWordStatus False');
            if ($numberOfLastDays===null){
                return 
            }
        }
$fromDatetime=Carbon::now()->subDays($numberOfLastDays);
Log::info('fromDatetime'.$fromDatetime);
       /* $firstPage = $this->client->get($baseUrl);
        $baceHtml = $firstPage->getBody()->getContents();
        $crawler = new Crawler($baceHtml);
        $pages = $crawler->filter('.pagination a')->each(fn($node) => (int)$node->text());
        $totalPages = max($pages);
        $record = 0;
        $maxRecord = 5000;
        $news = [];
        $dbNews = null;
        $postsUrl = [];
        try {
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($record >= $maxRecord) {
                    break;
                }
                $url = $baseUrl . '&page=' . $i;
                $response = $this->client->get($url);
                $html = $response->getBody()->getContents();
                $pageCrawler = new Crawler($html);
                $pageCrawler->filter('.list-item')->each(function (Crawler $node) use (&$postsUrl, $sourceUrl) {
                    $postUrlPage = [
                        'news_url' => $sourceUrl . $node->filter('a')->count() ? $node->filter('a')->attr('href') : null,
                    ];
                    $postsUrl[] = $postUrlPage;
                });
                Log::info('url fined' . count($postsUrl));
                $pages = $pageCrawler->filter('.pagination a')->each(fn($node) => (int)$node->text());
                $totalPages = max($pages);
            }

//                foreach ($postsUrl as &$item) {
//                    $urlPost = $sourceUrl . $item['news_url'];
//                    if ($this->newsRepository->isUrlUnique($urlPost)) {
//                        $approvedUrls[] = $urlPost;

//                        $responsePost = $this->client->get($urlPost);
//                        $htmlPost = $responsePost->getBody()->getContents();
//                        $postCrawler = new Crawler($htmlPost);
//                        $dbNews = $postCrawler->filter('.single-news')->each(function (Crawler $node) use (&$urlPost) {
//                            return [
//                                'title' => $this->safeExtract($node, '.title'),
//                                'lead' => $this->safeExtract($node, '.lead'),
//                                'body' => $this->safeExtract($node, '.story'),
//                                'image_url' => $node->filter('img')->count() ? $node->filter('img')->attr('src') : null,
//                                'news_url' => $urlPost,
//                                'published_at' => $this->persianStringToDate($node->filter('.time')->count() ? $node->filter('.time')->text() : null),
//                            ];
//                        });
                        $record = $record + 1;
                        Log::info('number record' . $record);
//                        $newsRow = $dbNews[0];
//                        $news = $this->newsRepository->create($newsRow);



//                    } else {
//                        Log::info('not news');
//                        break 2;
//                    }





            return response()->json([
                'success' => true,
//                'news' => $news,
                'Urls' => count($postsUrl),
                'number of record'=>$record,
            ]);

        } catch
        (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
       */
    }

    private function safeExtract(Crawler $node, $selector)
    {
        $element = $node->filter($selector);
        return $element->count() ? trim($element->text()) : null;
    }
}
