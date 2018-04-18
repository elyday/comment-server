<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogArticle;
use App\Comments;
use App\Helper\FormatHelper;
use Illuminate\Http\Request;

/**
 * Class CommentController
 *
 * @package App\Http\Controllers
 */
class CommentController extends Controller
{
    public function index($articleHash)
    {
        $article = new BlogArticle();
        $comment = new Comments();
        $articleResult = $article->where("hash", $articleHash)->first();

        if ($articleResult != null) {
            $articleResult["comments"] = $comment->where("articleHash", $articleHash)->orderBy("created_at")->get();

            return FormatHelper::formatData($articleResult);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }

    public function getComment($commentHash)
    {
        $article = new BlogArticle();
        $comment = new Comments();

        $commentResult = $comment->where("hash", $commentHash)->first();

        if ($commentResult != null) {
            $articleResult = $article->where("hash", $commentResult->articleHash)->first();
            $articleResult["comment"] = $commentResult;

            return FormatHelper::formatData($articleResult);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }

    public function addComment(Request $request)
    {
        $blog = new Blog();
        $article = new BlogArticle();
        $comment = new Comments();

        $blogHash = $request->input("blogHash");
        $articleHash = $request->input("articleHash");

        $articleTitle = $request->input("articleTitle");
        $articleAuthor = $request->input("articleAuthor");
        $articleUrl = $request->input("articleUrl");

        $authorName = $request->input("authorName");
        $authorMail = $request->input("authorMail");
        $title = $request->input("title");
        $content = $request->input("content");

        if ($blogHash != null && $articleHash != null && $articleTitle != null && $articleAuthor != null && $articleUrl != null && $authorName != null && $content != null) {
            $blogResult = $blog->where("hash", $blogHash)->first();
            $articleResult = $article->where("hash", $articleHash)->where("blogHash", $blogHash)->first();

            if ($blogResult != null) {
                if ($articleResult != null) {
                    $commentHash = md5(time());
                    $dataArray = array(
                        "hash" => $commentHash,
                        "articleHash" => $articleHash,
                        "authorName" => $authorName,
                        "authorMail" => $authorMail,
                        "title" => $title,
                        "content" => $content
                    );
                    $comment->create($dataArray);

                    return $this->getComment($commentHash);
                } else {
                    $articleHash = md5(time());
                    $dataArray = array(
                        "hash" => $articleHash,
                        "blogHash" => $blogHash,
                        "title" => $articleTitle,
                        "author" => $articleAuthor,
                        "url" => $articleUrl
                    );
                    $article->create($dataArray);

                    $commentHash = md5(time());
                    $dataArray = array(
                        "hash" => $commentHash,
                        "articleHash" => $articleHash,
                        "authorName" => $authorName,
                        "authorMail" => $authorMail,
                        "title" => $title,
                        "content" => $content
                    );
                    $comment->create($dataArray);

                    return $this->getComment($commentHash);
                }
            } else {
                return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
            }
        } else {
            return FormatHelper::formatData(array("errorCode" => "invalid-request"), false, 400);
        }
    }

    public function editComment(Request $request, $commentHash)
    {
        $comment = new Comments();

        $authorName = $request->input("authorName");
        $authorMail = $request->input("authorMail");
        $title = $request->input("title");
        $content = $request->input("content");

        $commentResult = $comment->where("hash", $commentHash)->first();
        if ($commentResult != null) {
            $dataArray = array();

            if ($authorName != null) {
                $dataArray["authorName"] = $authorName;
            }

            if ($authorMail != null) {
                $dataArray["authorMail"] = $authorMail;
            }

            if ($title != null) {
                $dataArray["title"] = $title;
            }

            if ($content != null) {
                $dataArray["content"] = $content;
            }

            $comment->where("hash", $commentHash)->update($dataArray);

            return $this->getComment($commentHash);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }

    public function deleteComment($commentHash)
    {
        $comment = new Comments();
        $commentResult = $comment->where("hash", $commentHash)->first();
        if ($commentResult != null) {
            $comment->where("hash", $commentHash)->delete();
            return FormatHelper::formatData(array("errorCode" => "comment-deleted"), true);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }
}