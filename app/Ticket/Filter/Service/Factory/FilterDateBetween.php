<?php

namespace App\Ticket\Filter\Service\Factory;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
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
     * Фильтрация
     *
     * @param Builder|BuilderQuery $builder
     *
     * @throws Exception
     *
     * @return Builder|BuilderQuery
     */
    public function filtration($builder)
    {
        $value = $this->filterItem->getValue();

        $dateArray = array_map(function (Carbon $item) {
            return $item->toDateString();
        }, $this->getValidValue($value));

        return $builder->whereBetween($this->getFieldForWhere(), $dateArray);
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException|Exception
     *
     * @return Carbon[]
     */
    protected static function getValidValue($value): array
    {
        $result = [];
        foreach ($value as $item) {
            $date = new Carbon($item);

            if (count($date::getLastErrors()['errors']) > 0) {
                throw new InvalidArgumentException("{$item} not DateType. Error: {$date::getLastErrors()['errors']}");
            }

            $result[] = $date;
        }

        return $result;
    }
}
