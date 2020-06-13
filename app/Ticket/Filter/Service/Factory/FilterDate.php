<?php

namespace App\Ticket\Filter\Service\Factory;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;

final class FilterDate extends FilterFieldsAbstract
{
    /**
     * Фильтрация
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function filtration(Builder $builder): Builder
    {
        $value = $this->filterItem->getValue();

        return $builder->whereDate(
            $this->getFieldForWhere(),
            '=',
            $this->getValidValue($value)->toDateString()
        );
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param $value
     *
     * @throws InvalidArgumentException
     * @return Carbon
     *
     */
    protected static function getValidValue($value): Carbon
    {
        $date = new Carbon($value);

        if (count($date::getLastErrors()['errors']) > 0) {
            throw new InvalidArgumentException("{$value} not DateType. Error: " . implode(PHP_EOL, $date::getLastErrors()['errors']));
        }

        return $date;
    }
}
