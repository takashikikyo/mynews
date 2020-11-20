<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;
use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $posts = News::all()->sortByDesc('updated_at');
        //News::all() Eloquentを使った、全てのnewsテーブルを取得するというメソッド
        //sortByDesc() カッコの中の値（キー）でソート(並び替え)するためのメソッド

        if (count($posts) > 0) {
            $headline = $posts->shift();
            //shift() 配列の最初のデータを削除し、その値を返すメソッド
            //最新の記事を変数$headlineに代入し、$postsは代入された最新の記事以外の記事が格納されている
        } else {
            $headline = null;
        }

        // news/index.blade.php ファイルを渡している
        // また View テンプレートに headline、 posts、という変数を渡している
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}