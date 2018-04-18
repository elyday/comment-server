<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogArticle;
use App\Helper\FormatHelper;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    public function index()
    {
        return FormatHelper::formatData(Blog::all());
    }

    public function getBlogWithArticles($blogHash)
    {
        $blog = new Blog();
        $blogResult = $blog->where("hash", $blogHash)->first();

        if ($blogResult != null) {
            $blogArticle = new BlogArticle();
            $blogResult["articles"] = $blogArticle->where("blogHash", $blogHash)->orderBy("created_at")->get();

            return FormatHelper::formatData($blogResult);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }

    public function getArticleWithBlogInformation($articleHash)
    {
        $blog = new Blog();
        $article = new BlogArticle();
        $articleResult = $article->where("hash", $articleHash)->first();

        if ($articleResult != null) {
            $blogResult = $blog->where("hash", $articleResult->blogHash)->orderBy("created_at")->first();
            $blogResult["article"] = $articleResult;

            return FormatHelper::formatData($blogResult);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }
}