<?php

namespace App\Http\Middleware;

use App\Blog;
use App\Comments;
use App\Helper\FormatHelper;
use Closure;
use Illuminate\Http\Request;

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
        $captcha = $request->input("captcha");
        $spam = $request->input("computer");


        if ($method == "POST" && $requestPath == "/api/comment/add") {
            if ($spam != null) {
                $returnArray["error-code"] = "bot-detected";
                $returnStatus = 403;
            } else if ($captcha == null) {
                $returnArray["error-code"] = "captcha-missing";
                $returnStatus = 400;
            } else if ($captcha != getenv("CAPTCHA_SECRET")) {
                $returnArray["error-code"] = "captcha-wrong";
                $returnStatus = 400;
            } else {
                $blogHash = $request->input("blogHash");
                $articleHash = $request->input("articleHash");
                $blogResult = $blog->where("hash", $blogHash)->first();

                $articleTitle = $request->input("articleTitle");
                $articleAuthor = $request->input("articleAuthor");
                $articleUrl = $request->input("articleUrl");

                if ($blogHash == null || $articleHash == null || $articleTitle == null || $articleAuthor == null || $articleUrl == null || $authorName == null || $content == null) {
                    $returnArray["error-code"] = "invalid-request";
                    $returnStatus = 400;
                } else if ($blogResult == null) {
                    $returnArray["error-code"] = "blog-not-found";
                    $returnStatus = 404;
                }
            }
        } else if ($method == "PUT" && $requestPath == "/api/comment") {
            $hash = $request->input("hash");
            $commentResult = $comment->where("hash", $hash)->first();
            if ($commentResult == null) {
                $returnArray["error-code"] = "comment-not-found";
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
