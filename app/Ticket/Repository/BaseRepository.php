<?php

namespace App\Ticket\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Entity\EntityService;
use App\Ticket\Filter\FilterList;
use App\Ticket\Model\Model;
use App\Ticket\Pagination\Pagination;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;
use OutOfBoundsException;
use Webpatser\Uuid\Uuid;

abstract class BaseRepository implements RepositoryInterface
{
    /** @var Model */
    protected $model;

    /** @var Builder */
    protected $builder;

    /**
     * Обновить данные
     *
     * @param Uuid $id
     * @param EntityInterface $data
     *
     * @throws OutOfBoundsException
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    public function update(Uuid $id, EntityInterface $data): bool
    {
        if (!$this->model->whereId((string)$id)->exists()) {
            throw new OutOfBoundsException(self::class . ' with id ' . (string)$id . ' does not exist');
        }

        $update = EntityService::getNotEmptyFields($data);

        return $this->model
                ->where('id', '=', (string)$id)
                ->update($update) > 0;
    }

    /**
     * Выполнить пагинацию в моделе
     *
     * @param Pagination|null $pagination
     *
     * @return $this
     */
    public function setPagination(Pagination $pagination = null): self
    {
        if (!empty($pagination)) {
            $builder = $this->getBuilder();
            $builder->forPage($pagination->getPage(), $pagination->getPage());
            $this->setBuilder($builder);
        }

        return $this;
    }

    /**
     * Выполнить фильтрацию в моделе
     *
     * @param FilterList|null $fields
     *
     * @return $this
     */
    public function setFilter(?FilterList $fields): self
    {
        if ($fields !== null) {
            $this->setBuilder($fields->filtration($this->getBuilder(), $this->model));
        }

        return $this;
    }

    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        if (null === $this->builder) {
            $this->builder = $this->model->getQuery();
        }

        return $this->builder;
    }

    /**
     * @param Builder $builder
     */
    public function setBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    public function getList(): ?array
    {
        $result = [];
        foreach ($this->getBuilder()->get() as $item) {
            $result[] = $this->build((array)$item);
        }

        return empty($result) ? null : $result;
    }

    abstract protected function build(array $data): EntityInterface;
}
