<?php

declare(strict_types=1);

namespace App\Ticket\Entity;

use App\Ticket\Date\DateBetween;
use Webpatser\Uuid\Uuid;

/**
 * Interface EntityInterface
 *
 * Интерфейс для сущности
 *
 * @package App\Ticket\Entity
 *
 * @property Uuid $id
 * @property string $title
 */
interface EntityInterface
{
    /**
     * Преобразовать значения сущности в массив
     *
     * @return array|null
     */
    public function toArray(): ?array;


    /**
     * Создания сущности из массива
     *
     * @param array $data
     *
     * @return EntityInterface|DateBetween
     */
    public static function fromState(array $data);

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name);
}
