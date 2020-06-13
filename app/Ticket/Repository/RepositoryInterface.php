<?php

namespace App\Ticket\Repository;

use App\Ticket\Entity\EntityInterface;
use Webpatser\Uuid\Uuid;

/**
 * Interface RepositoryInterface
 *
 * @package App\Ticket\Repository
 */
interface RepositoryInterface
{
    /**
     * Сохронить данные в базу
     *
     * @param EntityInterface $entity
     *
     * @return Uuid|null
     */
    public function create($entity): ?Uuid;

    /**
     * Вывести список entity
     *
     * @return EntityInterface[]|null
     */
    public function getList(): ?array;

    /**
     * Обновить данные в моделе
     *
     * @param Uuid $id
     * @param EntityInterface $data
     *
     * @return bool
     */
    public function update(Uuid $id, EntityInterface $data): bool;

    /**
     * Найти запись в базе по его id
     *
     * @param Uuid $id
     *
     * @return mixed
     */
    public function findById(Uuid $id);
}
