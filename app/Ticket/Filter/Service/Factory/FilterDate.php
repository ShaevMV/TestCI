<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service\Factory;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterDate
 *
 * Класс фильтрации по дате
 *
 * @package App\Ticket\Filter\Service\Factory
 */
final class FilterDate extends FilterFieldsAbstract
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

        return $builder->whereDate(
            $this->getFieldForWhere(),
            '=',
            $this->getValidValue($value)->toDateString()
        );
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     * @throws Exception
     *
     * @return Carbon
     */
    protected static function getValidValue($value): Carbon
    {
        $date = new Carbon($value);

        if (count($date::getLastErrors()['errors']) > 0) {
            throw new InvalidArgumentException(
                "{$value} not DateType. Error: " . implode(PHP_EOL, $date::getLastErrors()['errors'])
            );
        }

        return $date;
    }
}
