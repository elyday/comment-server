<?php

namespace App\Http\Controllers;

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
        $comment = new Comments();

        $commentResult = $comment->where("hash", $commentHash)->first();

        if ($commentResult != null) {
            return FormatHelper::formatData($commentResult);
        } else {
            return FormatHelper::formatData(array("errorCode" => "not-found"), false, 404);
        }
    }

    public function addComment(Request $request)
    {
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

        $articleResult = $article->where("hash", $articleHash)->where("blogHash", $blogHash)->first();

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
    }

    public function editComment(Request $request, $commentHash)
    {
        $comment = new Comments();

        $authorName = $request->input("authorName");
        $authorMail = $request->input("authorMail");
        $title = $request->input("title");
        $content = $request->input("content");

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

    public function getAllComments()
    {
        return FormatHelper::formatData(Comments::all());
    }
}