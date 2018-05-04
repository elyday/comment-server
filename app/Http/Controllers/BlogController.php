<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogArticle;
use App\Helper\FormatHelper;
use Request;

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

    public function getArticle($articleHash)
    {
        $article = new BlogArticle();
        $articleResult = $article->where("hash", $articleHash)->first();

        if ($articleResult != null) {
            return FormatHelper::formatData($articleResult);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }

    public function addBlog(Request $request)
    {
        $blog = new Blog();

        $name = $request->input("name");
        $description = $request->input("description");
        $url = $request->input("url");

        $blogHash = md5(time());
        $dataArray = array(
            "hash" => $blogHash,
            "name" => $name,
            "description" => $description,
            "url" => $url
        );
        $blog->create($dataArray);
    }

    public function editBlog(Request $request, $blogHash)
    {
        $blog = new Blog();

        $name = $request->input("name");
        $description = $request->input("description");
        $url = $request->input("url");

        $dataArray = array();

        if ($name != null) {
            $dataArray["name"] = $name;
        }

        if ($description != null) {
            $dataArray["description"] = $description;
        }

        if ($url != null) {
            $dataArray["url"] = $url;
        }

        $blog->where("hash", $blogHash)->update($dataArray);

        return $dataArray;
    }

    public function deleteBlog($blogHash)
    {
        $blog = new Blog();
        $blogResult = $blog->where("hash", $blogHash)->first();
        if ($blogResult != null) {
            $blogResult->delete();
            return FormatHelper::formatData(array("errorCode" => "blog-deleted"), true);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }
}