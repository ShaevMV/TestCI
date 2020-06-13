<?php

namespace Tests\Unit\Order\Service;

use App\Ticket\Modules\Order\Entity\TotalEntity;
use App\Ticket\Modules\Order\Service\Factory\CollectiveTicketTotal;
use App\Ticket\Modules\Order\Service\Factory\DefaultTotal;
use App\Ticket\Modules\Order\Service\TotalFactory;
use App\Ticket\Modules\Order\Service\TotalService;
use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;
use TypeRegistrationSeeder;

class TotalServiceTest extends TestCase
{
    /** @var TotalService|mixed */
    private $totalService;

    /** @var TotalFactory|mixed */
    private $totalFactoryStrategy;

    /**
     * @dataProvider typeRegistrationProvider
     *
     * @param TypeRegistration $typeRegistration
     * @param string $class
     */
    public function testGetStrategy(TypeRegistration $typeRegistration, string $class)
    {
        $this->assertInstanceOf($class, $this->totalFactoryStrategy->getTotalStrategy($typeRegistration));
    }

    /**
     * @dataProvider typeRegistrationProvider
     *
     * @param TypeRegistration $typeRegistration
     * @param string $class
     * @param TotalEntity $totalEntity
     */
    public function testGetTotal(TypeRegistration $typeRegistration, string $class, TotalEntity $totalEntity)
    {
        $this->assertEquals($this->totalService->getTotal($typeRegistration, $totalEntity->getCount()), $totalEntity);
    }

    public function typeRegistrationProvider()
    {
        return [
            [
                (new TypeRegistration())
                    ->setPrice(Price::fromState(1000)),
                DefaultTotal::class,
                TotalEntity::fromSate(
                    Price::fromState(1000),
                    3,
                    Price::fromState(3000)
                ),
            ],
            [
                (new TypeRegistration())
                    ->setPrice(Price::fromState(1000))
                    ->setParams(Parameter::fromState(json_encode(TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT))),
                CollectiveTicketTotal::class,
                TotalEntity::fromSate(
                    Price::fromState(1000),
                    3,
                    Price::fromState(1000)
                )
            ]
        ];
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->totalService = $this->app->make(TotalService::class);
        $this->totalFactoryStrategy = $this->app->make(TotalFactory::class);
    }
}