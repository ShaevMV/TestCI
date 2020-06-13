<?php

namespace App\Ticket\Modules\Festival\Model;

use App\Ticket\Model\Model;
use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * App\Ticket\Festival\Model\FestivalModel
 *
 * @property string $title Название фестиваля
 * @property string $date_start Начала фестиваля
 * @property string $date_end Оканчание фестиваля
 * @property int $status Статус фестиваля
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $id
 *
 * @method static Builder|FestivalModel newModelQuery()
 * @method static Builder|FestivalModel newQuery()
 * @method static Builder|FestivalModel query()
 * @method static Builder|FestivalModel whereCreatedAt($value)
 * @method static Builder|FestivalModel whereDateEnd($value)
 * @method static Builder|FestivalModel whereDateStart($value)
 * @method static Builder|FestivalModel whereId($value)
 * @method static Builder|FestivalModel whereStatus($value)
 * @method static Builder|FestivalModel whereTitle($value)
 * @method static Builder|FestivalModel whereUpdatedAt($value)
 *
 * @property-read Collection|TypeRegistrationModule[] $typeRegistration
 * @property-read int|null $type_registration_count
 *
 * @mixin Eloquent
 */
class FestivalModel extends Model
{
    protected $table = "festivals";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'date_start',
        'date_end',
        'status',
    ];

    public function typeRegistration()
    {
        return $this->belongsToMany(
            TypeRegistrationModule::class,
            'type_registration_festival',
            'festival_id',
            'type_registration_id'
        )->withPivot([
            'price',
            'params'
        ]);
    }
}
