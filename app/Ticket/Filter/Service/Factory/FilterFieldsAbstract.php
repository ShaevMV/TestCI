<?php

namespace App\Ticket\Filter\Service\Factory;

use App\Ticket\Filter\Entity\FilterItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;

/**
 * Class FilterFieldsAbstract Общий класс для фильтров
 *
 * @package App\Tackit\Filter\Fields
 */
abstract class FilterFieldsAbstract
{
    /** @var FilterItem */
    protected $filterItem;

    public function __construct(FilterItem $filterItem)
    {
        $this->filterItem = $filterItem;
    }

    /**
     * Вывести поле с примапиной именем таблицы
     *
     * @return string table.fields
     */
    final protected function getFieldForWhere(): string
    {
        return "{$this->filterItem->getTable()}.{$this->filterItem->getField()}";
    }

    /**
     * @return FilterItem
     */
    final public function getFilterItem(): FilterItem
    {
        return $this->filterItem;
    }

    /**
     * @return mixed
     */
    final public function getValue()
    {
        return static::getValidValue($this->filterItem->getValue());
    }

    /**
     * Выдать значения для фильтрации
     *
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    abstract protected static function getValidValue($value);

    /**
     * Фильтрация
     *
     * @param Builder|BuilderQuery $builder
     *
     * @return Builder|BuilderQuery
     */
    abstract public function filtration($builder);
}
