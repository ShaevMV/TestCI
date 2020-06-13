<?php

namespace App\Ticket\Filter\Service\Factory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
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
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    protected static function getValidValue($value)
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException("{$value} not Intel Type");
        }

        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    private static function isValidValue($value): bool
    {
        return is_numeric($value);
    }

    /**
     * Фильтрация
     *
     * @param Builder|BuilderQuery $builder
     *
     * @return Builder|BuilderQuery
     */
    public function filtration($builder)
    {
        $value = $this->filterItem->getValue();

        return $builder->where($this->getFieldForWhere(), '=', $this->getValidValue($value));
    }
}
