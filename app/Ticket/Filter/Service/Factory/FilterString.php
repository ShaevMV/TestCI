<?php

namespace App\Ticket\Filter\Service\Factory;

use Illuminate\Database\Query\Builder;
use InvalidArgumentException;

/**
 * Не точная фильтрация по строке
 *
 * Class FilterString
 *
 * @package App\Tackit\Filter\Fields
 */
final class FilterString extends FilterFieldsAbstract
{
    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     *
     * @return string
     */
    protected static function getValidValue($value): string
    {
        if (!self::isValidValue($value)) {
            throw new InvalidArgumentException("{$value} not string");
        }

        return $value;
    }

    /**
     * @param string $value
     * @return bool
     */
    static private function isValidValue($value): bool
    {
        return is_string($value);
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

        return $builder->where($this->getFieldForWhere(), 'like', "%{$this->getValidValue($value)}%");
    }
}