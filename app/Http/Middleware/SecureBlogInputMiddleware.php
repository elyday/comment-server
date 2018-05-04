<?php

namespace App\Http\Middleware;


use App\Blog;
use Closure;
use Illuminate\Http\Request;

class SecureBlogInputMiddleware
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
        $method = $request->getMethod();
        $requestPath = $request->getRequestUri();
        $returnArray = array();
        $returnStatus = 0;


        if ($method == "POST" && $requestPath == "/api/blog/add") {
            $name = $request->input("name");
            $description = $request->input("description");
            $url = $request->input("url");

            if ($name == null && $description == null && $url == null) {
                $returnArray["error-code"] = "invalid-request";
                $returnStatus = 400;
            }
        } else if ($method == "PUT" && strpos($requestPath, "/api/blog/edit/") !== false) {
            $hash = $request->route()[2]["hash"];
            $blogResult = $blog->where("hash", $hash)->first();
            if ($blogResult == null) {
                $returnArray["error-code"] = "blog-not-found";
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