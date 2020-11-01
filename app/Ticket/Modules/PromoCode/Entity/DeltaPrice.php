<?php

namespace App\Ticket\Modules\PromoCode\Entity;

use App\Ticket\Entity\AbstractionEntity;
use App\Ticket\Entity\EntityDataInterface;
use App\Ticket\Modules\PromoCode\Entity\Enum\DeltaTypeEnum;
use InvalidArgumentException;

/**
 * Class DeltaPrice
 *
 * Сущность цены промо-кода
 *
 * @package App\Ticket\Modules\PromoCode\Entity
 */
final class DeltaPrice extends AbstractionEntity implements EntityDataInterface
{
    /**
     * Изменения цены
     *
     * @var int
     */
    protected $delta_price;

    /**
     * Тип изменения цены (процент, скалярная)
     *
     * @var string
     */
    protected $delta_type;

    /**
     * Получения сущности из статики
     *
     * @param array $data
     *
     * @return DeltaPrice
     */
    public static function fromState(array $data): DeltaPrice
    {
        if (!self::ensureIsValidDeltaType($data['delta_type'])) {
            throw new InvalidArgumentException("Type {$data['delta_type']} not valid");
        }

        if (!self::ensureIsValidDeltaPrice($data['delta_price'])) {
            throw new InvalidArgumentException("Price {$data['delta_price']} not valid");
        }

        return (new self())
            ->setDeltaType($data['delta_type'])
            ->setDeltaPrice($data['delta_price']);
    }

    /**
     * Проверить валидность типов
     *
     * @param string $deltaType
     *
     * @return bool
     */
    public static function ensureIsValidDeltaType(string $deltaType): bool
    {
        return DeltaTypeEnum::getKey($deltaType) !== false;
    }

    /**
     * Проверить валидность изменения цены
     *
     * @param int $deltaPrice
     *
     * @return bool
     */
    public static function ensureIsValidDeltaPrice(int $deltaPrice): bool
    {
        return $deltaPrice >= 0;
    }

    /**
     * Вывести строку из сущности
     *
     * @return mixed|string
     */
    public function __toString()
    {
        return (string)$this->delta_price;
    }

    /**
     * @return int
     */
    public function getDeltaPrice(): int
    {
        return $this->delta_price;
    }

    /**
     * @param int $deltaPrice
     *
     * @return DeltaPrice
     */
    public function setDeltaPrice(int $deltaPrice): DeltaPrice
    {
        $this->delta_price = $deltaPrice;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeltaType(): string
    {
        return $this->delta_type;
    }

    /**
     * @param string $deltaType
     *
     * @return DeltaPrice
     */
    public function setDeltaType(string $deltaType): DeltaPrice
    {
        $this->delta_type = $deltaType;

        return $this;
    }
}
