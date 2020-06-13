<?php

namespace App\Ticket\Modules\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;

final class TotalService
{
    /**
     * @param TypeRegistration $typeRegistration
     * @param int $count
     *
     * @return Price
     */
    public function getPrice(TypeRegistration $typeRegistration, int $count = 1): Price
    {
        return Price::fromState($typeRegistration->getPrice()->getInt() * $count);
    }
}
