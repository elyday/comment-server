<?php

namespace App\Http\Controllers;

use App\BlogArticle;
use App\Comments;
use App\Helper\FormatHelper;

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
        $articleResult = $article->where("hash", $articleHash)->first();

        if ($articleResult != null) {
            $comment = new Comments();
            $articleResult["comments"] = $comment->where("articleHash", $articleHash)->orderBy("created_at")->get();

            return FormatHelper::formatData($articleResult);
        } else {
            return FormatHelper::formatData(array(), false);
        }
    }
}