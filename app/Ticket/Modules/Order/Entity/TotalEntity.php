<?php

namespace App\Ticket\Modules\Order\Entity;

use App\Ticket\Modules\TypeRegistration\Entity\Price;
use InvalidArgumentException;

class TotalEntity
{
    /** @var Price */
    private $price;

    /** @var int */
    private $count;

    /** @var Price */
    private $total;

    /**
     * @param Price $price
     * @param int $count
     * @param Price $total
     *
     * @throws InvalidArgumentException
     *
     * @return $this
     */
    public static function fromSate(Price $price, int $count, Price $total): self
    {
        if (!self::isValidCount($count)) {
            throw new InvalidArgumentException("Count not valid");
        }

        return (new self())
            ->setPrice($price)
            ->setTotal($total)
            ->setCount($count);
    }

    private static function isValidCount(int $count): bool
    {
        return $count > 0;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return $this
     */
    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return Price
     */
    public function getTotal(): Price
    {
        return $this->total;
    }

    /**
     * @param Price $total
     *
     * @return $this
     */
    public function setTotal(Price $total): self
    {
        $this->total = $total;

        return $this;
    }

}
