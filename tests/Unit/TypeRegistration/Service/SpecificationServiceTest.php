<?php

namespace Tests\Unit\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Service\SpecificationService;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationAnd;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationCount;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationEntity;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;
use TypeRegistrationSeeder;

/**
 * Class TypeRegistrationParameterServiceTest
 *
 * @package Tests\Unit\TypeRegistration\Service
 *
 * + Вывод нужного объекта параметров
 * + Проверка спицификацию для параметров
 * + Проверить список спицификаций по логическуму AND
 *
 */
class SpecificationServiceTest extends TestCase
{
    /**
     * @var SpecificationService|mixed
     */
    private $specificationService;

    /**
     * Вывод нужного объекта параметров
     *
     * @dataProvider getParams
     *
     * @param array $data
     * @param string $class
     */
    public function testCreateList(array $data, string $class)
    {
        $parameter = Parameter::fromState(json_encode($data));
        $specificationList = $this->specificationService->createList($parameter);

        $this->assertIsArray($specificationList);
        $this->assertInstanceOf($class, end($specificationList));
    }

    public function getParams(): array
    {
        return [
            [
                TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT,
                SpecificationCount::class,
            ],
        ];
    }

    public function testIsSatisfiedByCount()
    {
        $count = TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT[SpecificationService::KEY_COUNT];
        $specification = new SpecificationCount($count);

        $this->assertTrue(
            $specification->isSatisfiedBy(
                (new SpecificationEntity)
                    ->setCount($count)
            )
        );

        $this->assertFalse(
            $specification->isSatisfiedBy(
                (new SpecificationEntity)
                    ->setCount($count - 1)
            )
        );
    }

    /**
     * Проверить список спицификаций по логическуму AND
     *
     * @param array $data
     *
     * @dataProvider getParams
     */
    public function testListAndSpecification(array $data)
    {
        $parameter = Parameter::fromState(json_encode($data));
        $specificationList = $this->specificationService->createList($parameter);
        $specificationAnd = new SpecificationAnd($specificationList);
        $count = TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT[SpecificationService::KEY_COUNT];

        $this->assertTrue(
            $specificationAnd->isSatisfiedBy(
                (new SpecificationEntity)
                    ->setCount($count)
            )
        );

        $this->assertFalse(
            $specificationAnd->isSatisfiedBy(
                (new SpecificationEntity)
                    ->setCount($count - 1)
            )
        );
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->specificationService = $this->app->make(SpecificationService::class);
    }
}
