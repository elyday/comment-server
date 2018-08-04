<?php

namespace App\Http\Middleware;

use App\BlogArticle;
use App\Helper\FormatHelper;
use Closure;
use Illuminate\Http\Request;

/**
 * Class SecureArticleInputMiddleware
 * @package App\Http\Middleware
 */
class SecureArticleInputMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $article = new BlogArticle();
        $method = $request->getMethod();
        $requestPath = $request->getRequestUri();
        $returnArray = array();
        $returnStatus = 0;

        if ($method == "POST" && $requestPath == "/api/article") {
            $blogHash = $request->input("blogHash");
            $title = $request->input("title");
            $author = $request->input("author");
            $url = $request->input("url");

            if ($blogHash == null || $title == null || $author == null || $url == null) {
                $returnArray["error-code"] = "invalid-request";
                $returnStatus = 400;
            }
        } else if ($method == "PUT" && $requestPath == "/api/article") {
            $hash = $request->input("hash");
            $articleResult = $article->where("hash", $hash)->first();
            if ($articleResult == null) {
                $returnArray["error-code"] = "article-not-found";
                $returnStatus = 404;
            }
        } else {
            $returnArray["error-code"] = "request-not-found";
            $returnStatus = 400;
        }

        if (!empty($returnArray)) {
            return FormatHelper::formatData($returnArray, false, $returnStatus);
        }

        return $next($request);
    }
}