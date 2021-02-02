<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Service\Factory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterString
 *
 * Не точная фильтрация по строке
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
     * Проверить на строку
     *
     * @param string $value
     *
     * @return bool
     */
    private static function isValidValue(string $value): bool
    {
        return is_string($value);
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

        return $builder->where($this->getFieldForWhere(), 'like', "%{$this->getValidValue($value)}%");
    }
}
