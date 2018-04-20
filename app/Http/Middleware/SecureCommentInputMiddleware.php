<?php

namespace App\Http\Middleware;

use App\Blog;
use App\Comments;
use App\Helper\FormatHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SecureCommentInputMiddleware
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
        $blog = new Blog();
        $comment = new Comments();
        $method = $request->getMethod();
        $requestPath = $request->getRequestUri();
        $returnArray = array();
        $returnStatus = 0;

        $authorName = $request->input("authorName");
        $content = $request->input("content");

        if ($method == "POST" && $requestPath == "/api/comment/add") {
            $blogHash = $request->input("blogHash");
            $articleHash = $request->input("articleHash");
            $blogResult = $blog->where("hash", $blogHash)->first();

            $articleTitle = $request->input("articleTitle");
            $articleAuthor = $request->input("articleAuthor");
            $articleUrl = $request->input("articleUrl");

            if ($blogHash == null && $articleHash == null && $articleTitle == null && $articleAuthor == null && $articleUrl == null && $authorName == null && $content == null) {
                $returnArray["error-code"] = "invalid-request";
                $returnStatus = 400;
            } else if ($blogResult == null) {
                $returnArray["error-code"] = "not-found";
                $returnStatus = 404;
            }
        } else if ($method == "PUT" && strpos($requestPath, "/api/comment/edit/") !== false) {
            $hash = $request->route()[2]["hash"];
            $commentResult = $comment->where("hash", $hash)->first();
            if ($commentResult == null) {
                $returnArray["error-code"] = "not-found";
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
