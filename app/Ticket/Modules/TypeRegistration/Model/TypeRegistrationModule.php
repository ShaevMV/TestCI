<?php

namespace App\Ticket\Modules\TypeRegistration\Model;

use App\Ticket\Model\Model;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule
 *
 * @property string $id
 * @property string $title Название оргвзноса
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|TypeRegistrationModule newModelQuery()
 * @method static Builder|TypeRegistrationModule newQuery()
 * @method static Builder|TypeRegistrationModule query()
 * @method static Builder|TypeRegistrationModule whereCreatedAt($value)
 * @method static Builder|TypeRegistrationModule whereId($value)
 * @method static Builder|TypeRegistrationModule whereTitle($value)
 * @method static Builder|TypeRegistrationModule whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class TypeRegistrationModule extends Model
{
    protected $table = 'type_registration';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];
}