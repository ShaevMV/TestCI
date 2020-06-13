<?php

namespace App\Ticket\Model;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Webpatser\Uuid\Uuid;

/**
 * Class Model
 *
 * @package App\Ticket\Model
 *
 * @property string $id
 *
 * @method static Builder|Model whereId($value)
 * @method static Builder|Model newModelQuery()
 * @method static Builder|Model newQuery()
 * @method static Builder|Model query()
 *
 * @mixin Eloquent
 */
class Model extends BaseModel
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (BaseModel $post) {
            $post->{$post->getKeyName()} = (string)Uuid::generate();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
