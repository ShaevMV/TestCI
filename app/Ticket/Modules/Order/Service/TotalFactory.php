<?php

namespace App\Ticket\Modules\Order\Service;

use App\Ticket\Modules\Order\Service\Factory\CollectiveTicketTotal;
use App\Ticket\Modules\Order\Service\Factory\DefaultTotal;
use App\Ticket\Modules\Order\Service\Factory\TotalInterface;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class TotalFactory
 *
 * Фабрика получения стратегии стоимости
 *
 * @package App\Ticket\Modules\Order\Service
 */
final class TotalFactory
{
    /**
     * DI
     *
     * @var Container
     */
    private $container;

    /**
     * TotalFactory constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Получения стратегии для получения стоимости
     *
     * @param TypeRegistration $typeRegistration
     *
     * @throws BindingResolutionException
     *
     * @return TotalInterface
     */
    public function getTotalStrategy(TypeRegistration $typeRegistration): TotalInterface
    {
        $params = $typeRegistration->getParams();

        if (!empty($params) && in_array(SpecificationService::KEY_COUNT, array_keys($params->toArray()))) {
            return $this->container->make(CollectiveTicketTotal::class);
        }

        return new DefaultTotal();
    }
}
