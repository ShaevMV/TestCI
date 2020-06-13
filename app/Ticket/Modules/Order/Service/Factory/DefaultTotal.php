<?php

namespace App\Ticket\Modules\Order\Service\Factory;

use App\Ticket\Modules\TypeRegistration\Entity\Price;

final class DefaultTotal implements TotalInterface
{
    public function getTotal(Price $price, int $count): Price
    {
        return Price::fromState($price->getInt() * $count);
    }
}