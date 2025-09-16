<?php

namespace App\Http\Controllers;

use App\Traits\DataConversion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client;

class NewsScraperController extends Controller
{
    use DataConversion;

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false, // Only for demo sites
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);
    }


    public function scrapeNews(Request $request)
    {
        //http://127.0.0.1:8000/api/news/fa/search?query=ایران
        $wordSearch = $request->query('query');
        $codeSearch = urlencode($wordSearch);
        $sourceUrl = 'https://www.tasnimnews.com';
        $baseUrl = $sourceUrl . '/fa/search?query=' . $codeSearch;

        // Step 1: Get number of pages

        $firstPage = $this->client->get($baseUrl);
        $baceHtml = $firstPage->getBody()->getContents();
        $crawler = new Crawler($baceHtml);
        $pages = $crawler->filter('.pagination a')->each(fn($node) => (int)$node->text());
        $totalPages = max($pages);
        $record = 0;
        $maxRecord = 40;
        Log::info("Total pages found: $totalPages");
        $newsDatabace=[];

        // Step 2: Crawling through each page of results
        try {
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($record >= $maxRecord) {
                    break;
                }
                $url = $baseUrl . '&page=' . $i;
                $response = $this->client->get($url);
                $html = $response->getBody()->getContents();
                $pageCrawler = new Crawler($html);
                $news = [];
                $postsUrl = [];
                $newsData=[];

                //Step 3: Extract url Searched news in page
                $pageCrawler->filter('.list-item')->each(function (Crawler $node) use (&$postsUrl) {
                    $postUrlPage = [
                        'news_url' => $node->filter('a')->count() ? $node->filter('a')->attr('href') : null,
                    ];
                    $postsUrl[] = $postUrlPage;
                });
                //Step 4: Extract full post news
                foreach ($postsUrl as &$item) {
                    $urlPost = $sourceUrl . $item['news_url'];
                    $responsePost = $this->client->get($urlPost);
                    $htmlPost = $responsePost->getBody()->getContents();
                    $postCrawler = new Crawler($htmlPost);
                    $postCrawler->filter('.single-news')->each(function (Crawler $node) use (&$news, $urlPost) {
                        $post = [
                            'title' => $this->safeExtract($node, '.title'),
                            'lead' => $this->safeExtract($node, '.lead'),
                            'body' => $this->safeExtract($node, '.story'),
                            'image_url' => $node->filter('img')->count() ? $node->filter('img')->attr('src') : null,
                            'news_url' => $urlPost,
                            'published_at' => $node->filter('.time')->count() ? $node->filter('.time')->text() : null,

                        ];
                        $news[] = $post;
                    });
                }
                Log::info("story pages found:", $news);

                //Step 5: update number of max page
                $pages = $pageCrawler->filter('.pagination a')->each(fn($node) => (int)$node->text());
                $totalPages = max($pages);
                $record = $record + count($news);


                //Step 6: Save extracted news posts in the database
                foreach ($news as $dbNews) {
                    $newsData[]=[
                            'title' => $dbNews['title'],
                            'lead' => $dbNews['lead'],
                            'body' => $dbNews['body'],
                            'image_url' => $dbNews['image_url'],
                            'url' => $dbNews['news_url'],
                            'published_at' => $this->persianStringToDate($dbNews['published_at']),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    ;
                }
                $newsDatabace=DB::table('scraped_news')->insertOrIgnore($newsData);
            };
            return response()->json([
                'success' => true,
                'news' => $newsDatabace,
                'count' => count($news),
                'record' => $record,
                'url' => $baseUrl,
            ]);


        } catch
        (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    private function safeExtract(Crawler $node, $selector)
    {
        $element = $node->filter($selector);
        return $element->count() ? trim($element->text()) : null;
    }
}
