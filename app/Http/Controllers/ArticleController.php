<?php

namespace App\Http\Controllers;

use App\BlogArticle;
use App\Comments;
use App\Helper\FormatHelper;
use Illuminate\Http\Request;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    public function getArticlesByBlog($blogHash)
    {
        $blogArticle = new BlogArticle();
        $articleResult = $blogArticle->where("blogHash", $blogHash)->orderBy("created_at")->get();

        return FormatHelper::formatData($articleResult);
    }

    public function addArticle(Request $request)
    {
        $article = new BlogArticle();

        $blogHash = $request->input("blogHash");
        $title = $request->input("title");
        $author = $request->input("author");
        $url = $request->input("url");

        $articleHash = md5(time());
        $dataArray = array(
            "hash" => $articleHash,
            "blogHash" => $blogHash,
            "title" => $title,
            "author" => $author,
            "url" => $url
        );
        $article->create($dataArray);
        return $dataArray;
    }

    public function editArticle(Request $request)
    {
        $article = new BlogArticle();

        $articleHash = $request->input("blogHash");
        $title = $request->input("title");
        $author = $request->input("author");
        $url = $request->input("url");

        $dataArray = array();

        if ($title != null) {
            $dataArray["title"] = $title;
        }

        if ($author != null) {
            $dataArray["author"] = $author;
        }

        if ($url != null) {
            $dataArray["url"] = $url;
        }

        $article->where("hash", $articleHash)->update($dataArray);

        return $dataArray;
    }

    public function deleteArticle($articleHash)
    {
        $comment = new Comments();

        $article = new BlogArticle();
        $articleResult = $article->where("hash", $articleHash)->first();
        if ($articleResult != null) {
            $comment->where("articleHash", $articleHash)->delete();
            $articleResult->delete();
            return FormatHelper::formatData(array(), true);
        } else {
            return FormatHelper::formatData(array("errorCode" => "article-not-found"), false, 404);
        }
    }
}