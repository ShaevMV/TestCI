<?php

namespace App\Ticket\Filter\Service\Factory;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;

/**
 * Филтраци промежутка дат
 *
 * Class FilterDateBetween
 *
 * @package App\Tackit\Filter\Fields
 */
final class FilterDateBetween extends FilterFieldsAbstract
{

    /**
     * Выдать значения для фильтрации
     *
     * @param string[] $value
     *
     * @return Carbon[]
     *
     * @throws InvalidArgumentException
     */
    protected static function getValidValue($value): array
    {
        $result = [];
        foreach ($value as $item) {
            $date = new Carbon($item);

            if (count($date::getLastErrors()['errors']) > 0) {
                throw new InvalidArgumentException("{$item} not DateType. Error: {$date::getLastErrors()['errors']}");
                break;
            }

            $result[] = $date;
        }

        return $result;
    }

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

        $dateArray = array_map(function (Carbon $item) {
            return $item->toDateString();
        }, $this->getValidValue($value));

        return $builder->whereBetween($this->getFieldForWhere(), $dateArray);
    }
}