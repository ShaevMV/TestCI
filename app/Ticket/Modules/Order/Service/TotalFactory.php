<?php

namespace App\Ticket\Modules\Order\Service;

use App\Ticket\Modules\Order\Service\Factory\CollectiveTicketTotal;
use App\Ticket\Modules\Order\Service\Factory\DefaultTotal;
use App\Ticket\Modules\Order\Service\Factory\TotalInterface;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;

final class TotalFactory
{
    public function getTotalStrategy(TypeRegistration $typeRegistration): TotalInterface
    {
        $params = $typeRegistration->getParams();

        if (!empty($params) && in_array(SpecificationService::KEY_COUNT, array_keys($params->toArray()))) {
            return new CollectiveTicketTotal();
        }

        return new DefaultTotal();
    }
}
