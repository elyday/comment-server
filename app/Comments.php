<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comments
 *
 * @package App
 * @property string $hash
 * @property string $articleHash
 * @property string $authorName
 * @property string|null $authorMail
 * @property string|null $title
 * @property string $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder|Comments whereArticleHash($value)
 * @method static Builder|Comments whereAuthorMail($value)
 * @method static Builder|Comments whereAuthorName($value)
 * @method static Builder|Comments whereContent($value)
 * @method static Builder|Comments whereCreatedAt($value)
 * @method static Builder|Comments whereHash($value)
 * @method static Builder|Comments whereTitle($value)
 * @method static Builder|Comments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comments extends Model
{
    protected $table = "comments";

    protected $fillable = [
        'authorName', 'authorMail', 'title', 'content'
    ];

    protected $hidden = [];
}