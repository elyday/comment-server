<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static Builder|Blog whereCreatedAt($value)
 * @method static Builder|Blog whereDescription($value)
 * @method static Builder|Blog whereId($value)
 * @method static Builder|Blog whereName($value)
 * @method static Builder|Blog whereUpdatedAt($value)
 * @method static Builder|Blog whereUrl($value)
 * @method static Builder|Blog whereHash($value)
 * @mixin \Eloquent
 * @property string $hash
 */
class Blog extends Model
{
    protected $table = "blog";

    protected $fillable = [
        'name', 'description', 'url'
    ];

    protected $hidden = [
        'hash'
    ];
}