<?php

declare(strict_types=1);

namespace App\Ticket\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Entity\EntityService;
use App\Ticket\Filter\FilterList;
use App\Ticket\Model\Model;
use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Pagination\Pagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as BuilderQuery;
use InvalidArgumentException;
use OutOfBoundsException;
use Webpatser\Uuid\Uuid;

/**
 * Class BaseRepository
 *
 * Базовый класс репозитория
 *
 * @package App\Ticket\Repository
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * Модель в базе данных
     *
     * @var Model
     */
    protected $model;

    /**
     * Builder для работы с базой данных
     *
     * @var Builder|BuilderQuery
     */
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
        if ($this->model->whereId((string)$id)->exists() === false) {
            throw new OutOfBoundsException(self::class . ' with id ' . (string)$id . ' does not exist');
        }

        $update = EntityService::getNotEmptyFields($data);

        return $this->model
                ->where('id', '=', (string)$id)
                ->update($update) > 0;
    }

    /**
     * Выполнить пагинацию в модели
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
     * Выполнить фильтрацию в модели
     *
     * @param FilterList|null $fields
     *
     * @return $this
     */
    public function setFilter(?FilterList $fields): self
    {
        if ($fields !== null && $builder = $fields->filtration($this->getBuilder(), $this->model)) {
            $this->setBuilder($builder);
        }

        return $this;
    }

    /**
     * @return Builder|BuilderQuery
     */
    public function getBuilder()
    {
        if (null === $this->builder) {
            $this->builder = $this->model->getQuery();
        }

        return $this->builder;
    }

    /**
     * @param Builder|BuilderQuery $builder
     */
    public function setBuilder($builder): void
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

    /**
     * Выдать сущность
     *
     * @param array $data
     *
     * @return EntityInterface
     */
    abstract protected function build(array $data): EntityInterface;

    public function create(EntityInterface $entity): ?Uuid
    {
        $create = $this->model->create($entity->toArray() ?? []);

        return isset($create->id) ? Uuid::import($create->id) : null;
    }

    /**
     * Найти Фестиваль по его id
     *
     * @param Uuid $id
     *
     * @return EntityInterface|Festival
     */
    public function findById(Uuid $id)
    {
        try {
            $arrayData = $this->model->findorfail((string)$id);
        } catch (OutOfBoundsException $e) {
            throw new OutOfBoundsException($this->model->getTable() . ' with id ' . (string)$id . ' does not exist');
        }

        return $this->build($arrayData->toArray() ?? []);
    }

    /**
     * Удаление записи
     *
     * @param Uuid $id
     *
     * @return bool
     */
    public function remove(Uuid $id): bool
    {
        return $this->model->destroy((string)$id) > 0;
    }
}
