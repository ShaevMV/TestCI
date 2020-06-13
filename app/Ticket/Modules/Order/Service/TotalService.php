<?php

namespace App\Ticket\Modules\Order\Service;

use App\Ticket\Modules\Order\Entity\TotalEntity;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;

final class TotalService
{
    /** @var TotalFactory */
    private $typeOrderFactory;

    public function __construct(TotalFactory $typeOrderFactory)
    {
        $this->typeOrderFactory = $typeOrderFactory;
    }

    public function getTotal(TypeRegistration $typeRegistration, int $count): TotalEntity
    {
        $total = $this->typeOrderFactory->getTotalStrategy($typeRegistration)
            ->getTotal($typeRegistration->getPrice(), $count);

        return (new TotalEntity())
            ->setCount($count)
            ->setPrice($typeRegistration->getPrice())
            ->setTotal($total);
    }
}
