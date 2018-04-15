<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogArticle
 *
 * @package App
 * @property int $id
 * @property int $blogId
 * @property string $title
 * @property string $author
 * @property string $url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder|BlogArticle whereAuthor($value)
 * @method static Builder|BlogArticle whereBlogId($value)
 * @method static Builder|BlogArticle whereCreatedAt($value)
 * @method static Builder|BlogArticle whereId($value)
 * @method static Builder|BlogArticle whereTitle($value)
 * @method static Builder|BlogArticle whereUpdatedAt($value)
 * @method static Builder|BlogArticle whereUrl($value)
 * @mixin \Eloquent
 */
class BlogArticle extends Model
{
    protected $table = "blog_article";

    protected $fillable = [
        'blogId', 'title', 'author', 'url'
    ];

    protected $hidden = [];
}