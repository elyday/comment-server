<?php

namespace App\Http\Controllers;

use App\Blog;
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

    public function getBlog($hash)
    {
        $blog = new Blog();
        $return = $blog->where("hash", $hash)->first();
        return $return != null ? FormatHelper::formatData($return) : FormatHelper::formatData(array(), FALSE);
    }
}