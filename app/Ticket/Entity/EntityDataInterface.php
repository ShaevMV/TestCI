<?php

namespace App\Ticket\Entity;

/**
 *
 * Interface EntityDataInterface
 *
 * Интерфейс дата сущности
 *
 * @package App\Ticket\Entity
 */
interface EntityDataInterface
{
    /**
     * Преобразовать значение сущности в строку
     *
     * @return mixed
     */
    public function __toString();
}