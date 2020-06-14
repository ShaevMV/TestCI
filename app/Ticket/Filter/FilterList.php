<?php

namespace App\Ticket\Filter;

use App\Ticket\Filter\Service\Factory\FilterFieldsAbstract;
use App\Ticket\Filter\Service\FilterService;
use App\Ticket\Model\Model;
use App\Ticket\Model\Service\ModelJoinService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;

/**
 * Class Filter
 *
 * Класс для фильтрации по массовым фильтрам
 *
 * @package App\Ticket\Filter
 */
final class FilterList
{
    /**
     * Массив фильтров
     *
     * @var FilterFieldsAbstract[]
     */
    private $filterFields = [];

    /**
     * Сервис для связи модели
     *
     * @var ModelJoinService
     */
    private $joinService;

    /**
     * Сервис для работы с фильтром в базе
     *
     * @var FilterService
     */
    private $filterService;

    /**
     * Filter constructor.
     *
     * @param FilterFieldsAbstract[] $filterFields
     * @param ModelJoinService $joinService
     * @param FilterService $filterService
     */
    public function __construct(
        array $filterFields,
        ModelJoinService $joinService,
        FilterService $filterService
    ) {
        $this->filterFields = $filterFields;
        $this->joinService = $joinService;
        $this->filterService = $filterService;
    }

    /**
     * @return FilterFieldsAbstract[]
     */
    public function getFilterFields(): array
    {
        return $this->filterFields;
    }

    /**
     * Фильтрация
     *
     * @param BuilderQuery|Builder $builder
     * @param Model $model
     *
     * @return Builder|BuilderQuery|null
     */
    public function filtration($builder, Model $model)
    {
        $result = null;

        foreach ($this->filterFields as $field) {
            if ($field->getFilterItem()->getTable() !== $model->getTable()) {
                $result = $this->joinService->getModel(
                    $model,
                    $field->getFilterItem()->getTable(),
                    $this->filterService->getWhere($field)
                );
            } else {
                $result = $field->filtration($builder);
            }
        }

        return $result;
    }
}