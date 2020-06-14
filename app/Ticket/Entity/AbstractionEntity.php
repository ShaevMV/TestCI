<?php

namespace App\Ticket\Entity;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

/**
 * Class AbstractionEntity
 *
 * Абстрактный класс для реализации toArray
 *
 * @package App\Ticket\Entity
 */
abstract class AbstractionEntity implements EntityInterface
{
    /**
     * Вывести сущность в виде массива
     *
     * @return array
     */
    public function toArray(): array
    {
        $vars = get_object_vars($this);

        $array = [];
        foreach ($vars as $key => $value) {
            if ($value instanceof EntityInterface) {
                $array = array_merge($array, $value->toArray());
            } elseif ($value instanceof EntityDataInterface || $value instanceof Uuid || $value instanceof Carbon) {
                //TODO: Вынести в отдельный класс, перебросить зависимость на детей
                $array[ltrim($key)] = (string)$value;
            } else {
                $array[ltrim($key)] = $value;
            }
        }

        return $array;
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function __get(string $name)
    {
        $methodName = "get{$name}";

        return method_exists($this, $methodName) ? $this->$methodName() : null;
    }
}
