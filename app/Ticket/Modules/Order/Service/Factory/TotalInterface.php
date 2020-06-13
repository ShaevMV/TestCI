<?php

namespace App\Ticket\Modules\Order\Service\Factory;

use App\Ticket\Modules\TypeRegistration\Entity\Price;

interface TotalInterface
{
    public function getTotal(Price $price, int $count): Price;
}
