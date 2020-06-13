<?php

namespace App\Ticket\Entity;

interface EntityInterface
{
    /**
     * Преобразовать значения сущности в массив
     *
     * @return array|null
     */
    public function toArray(): ?array;
}
