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

    public function getBlog($blogHash)
    {
        $blog = new Blog();
        $return = $blog->where("hash", $blogHash)->first();
        return $return != null ? FormatHelper::formatData($return) : FormatHelper::formatData(array(), FALSE);
    }

    public function getBlogWithArticles($blogHash)
    {
        $blog = new Blog();
        $blogResult = $blog->where("hash", $blogHash)->first();

        if ($blogResult != null) {
            $blogArticle = new BlogArticle();
            $return = $blogArticle->where("blogId", $blogResult["id"])->get();

            return $return != null ? FormatHelper::formatData($return) : FormatHelper::formatData(array(), FALSE);
        } else {
            return FormatHelper::formatData(array(), false);
        }
    }
}