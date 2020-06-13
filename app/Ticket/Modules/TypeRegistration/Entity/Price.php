<?php

namespace App\Ticket\Modules\TypeRegistration\Entity;

use App\Ticket\Entity\EntityDataInterface;
use InvalidArgumentException;

/**
 * Class Price
 *
 * @package App\Ticket\TypeRegistration\Entity
 */
final class Price implements EntityDataInterface
{
    /** @var int */
    private $price;

    /**
     * @return int
     */
    public function getInt(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     *
     * @return Price
     */
    public function setPrice(int $price): Price
    {
        if (!self::isValid($price)) {
            throw new InvalidArgumentException("{$price} price not valid");
        }

        $this->price = $price;
        return $this;
    }

    /**
     * Проверка на положительную цену
     *
     * @param int $price
     *
     * @return bool
     */
    private static function isValid(int $price): bool
    {
        return $price >= 0;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return (string)$this->price;
    }

    /**
     * @param int $price
     *
     * @return static
     */
    public static function fromState(int $price): self
    {
        return (new self())
            ->setPrice($price);
    }
}