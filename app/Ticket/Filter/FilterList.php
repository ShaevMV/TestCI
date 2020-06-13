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
 * @package App\Ticket\Filter
 */
final class FilterList
{
    /** @var FilterFieldsAbstract[] фильтр поля */
    private $filterFields = [];

    /** @var ModelJoinService */
    private $joinService;

    /** @var FilterService */
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
    )
    {
        $this->filterFields = $filterFields;
        $this->joinService = $joinService;
        $this->filterService = $filterService;
    }

    /**
     * Выдать фильтр поля
     *
     * @return FilterFieldsAbstract[]
     */
    public function getFilterFields(): array
    {
        return $this->filterFields;
    }

    /**
     * Фильтрация
     *
     * @param BuilderQuery $builder
     * @param Model $model
     *
     * @return Builder|BuilderQuery
     */
    public function filtration(BuilderQuery $builder, Model $model)
    {
        foreach ($this->filterFields as $field) {
            if ($field->getFilterItem()->getTable() !== $model->getTable()) {
                $builder = $this->joinService->getModel(
                    $model,
                    $field->getFilterItem()->getTable(),
                    $this->filterService->getWhere($field)
                );
            } else {
                $builder = $field->filtration($builder);
            }
        }

        return $builder;
    }
}
