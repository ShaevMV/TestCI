<?php

namespace App\Ticket\Modules\TypeRegistration\Model;

use App\Ticket\Model\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule
 *
 * Сущность типа билета
 *
 * @property string $id
 * @property string $title Типа билета
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at

 * @method static Builder|TypeRegistrationModule newModelQuery()
 * @method static Builder|TypeRegistrationModule newQuery()
 * @method static Builder|TypeRegistrationModule query()
 * @method static Builder|TypeRegistrationModule whereCreatedAt($value)
 * @method static Builder|TypeRegistrationModule whereId($value)
 * @method static Builder|TypeRegistrationModule whereTitle($value)
 * @method static Builder|TypeRegistrationModule whereUpdatedAt($value)
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