<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminat\Support\Facades\DB;

class Scp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scraping something';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = 'https://tenshoku.mynavi.jp/list/pg3';
        $crawler = \Goutte::request('GET', $url);
        $urls = $crawler->filter('.cassetteRecruit__copy > a')->each(function ($node) {
            $href = $node->attr('href');
            return [
                'url' => substr($href, 0, strpos($href, '/', 1) + 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ];
            });

            \DB::table('mynavi_urls')->insert($urls);
        }
    }

    // $href = $node->attr('href');
    // dump();

    // $crawler = Goutte::request('GET', 'https://duckduckgo.com/html/?q=Laravel');
    // $crawler->filter('.result__title .result__a')->each(function ($node) {
    //     dump($node->text());
    // });

    // $str = 'today is rainy. It will rain tomorrow.';

    // //検索する文字列
    // $search = 'rain';

    // //指定した文字列を検索する

    // // $pos = strpos($str, $search, 14) + 1; //文字列の14番目からrainを探す 24番目が出力
    // $pos = strpos($str, $search) + 1; //文字列先頭からrainを探す 9番目が出力

    // echo '文字列'.$search.'の位置は'.$pos.'番目です。';
