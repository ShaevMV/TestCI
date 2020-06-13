<?php

namespace App\Ticket\Filter\Service\Factory;

use Illuminate\Database\Query\Builder;
use InvalidArgumentException;

/**
 * По целому числу
 *
 * Class FilterInteger
 *
 * @package App\Tackit\Filter\Fields
 */
final class FilterInteger extends FilterFieldsAbstract
{
    /**
     * Выдать значения для фильтрации
     *
     * @param $value
     *
     * @throws InvalidArgumentException
     * @return mixed
     *
     */
    protected static function getValidValue($value)
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException("{$value} not Intel Type");
        }

        return $value;
    }

    static private function isValidValue($value): bool
    {
        return is_numeric($value);
    }

    /**
     * Фильтрация
     *
     * @param Builder $builder
     * @return Builder
     */
    public function filtration(Builder $builder): Builder
    {
        $value = $this->filterItem->getValue();
        return $builder->where($this->getFieldForWhere(), '=', $this->getValidValue($value));
    }
}