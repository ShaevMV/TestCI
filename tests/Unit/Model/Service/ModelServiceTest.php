<?php

namespace Tests\Unit\Model\Service;

use App\Ticket\Model\Model;
use App\Ticket\Model\Service\ModelJoinService;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use BadMethodCallException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionException;
use ReflectionMethod;
use Tests\TestCase;
use TypeRegistrationSeeder;

/**
 * Class ModelServiceTest
 * @package Tests\Unit\Model\Service
 *
 * + Провериь наличие связоной функции
 * + Получить функцию связоной модель
 * + Проверить вызов исключения
 * - Получить связаную модель
 * - Получить выборку из связоной модели
 */
class ModelServiceTest extends TestCase
{
    /** @var ModelJoinService|mixed */
    private $modelService;

    /**
     * Провериь наличие связоной функции
     *
     * @dataProvider getModelProvider
     *
     * @param string $joinTable
     * @param Model $model
     *
     * @throws ReflectionException
     */
    public function testIsCallFunction(string $joinTable, Model $model)
    {
        $reflectionMethod = new ReflectionMethod($this->modelService, 'isCallFunction');
        $reflectionMethod->setAccessible(true);

        $this->assertTrue($reflectionMethod->invokeArgs($this->modelService, [
            'model' => $model,
            'joinTable' => $joinTable,
        ]));

        $this->assertFalse($reflectionMethod->invokeArgs($this->modelService, [
            'model' => $model,
            'joinTable' => $joinTable . 's',
        ]));
    }

    /**
     * Получить функцию связоной модель без выборки
     * Проверить вызов исключения
     *
     * @dataProvider getModelProvider
     *
     * @param string $joinTable
     * @param Model $model
     * @param callable|null $where
     *
     * @return void
     */
    public function testGetModel(string $joinTable, Model $model, ?callable $where): void
    {
        $this->assertInstanceOf(
            Builder::class,
            $this->modelService->getModel($model, $joinTable, $where)
        );

        $this->assertInstanceOf(
            Collection::class,
            $this->modelService->getModel($model, $joinTable, $where)->get()
        );

        $this->expectException(BadMethodCallException::class);
        $this->modelService->getModel($model, $joinTable . 's', $where);
    }


    public function testExceptionGetModel()
    {
        /** @var MockObject|FestivalModel $model */
        $model = $this->createMock(FestivalModel::class);

        $model->method('typeRegistration')
            ->willReturn(new FestivalModel());

        $this->expectException(BadMethodCallException::class);
        (new ModelJoinService)->getModel($model, 'typeRegistration');
    }

    public function getModelProvider(): array
    {
        return [
            [
                'typeRegistration',
                new FestivalModel(),
                function (Builder $builder) {
                    return $builder->where('type_registration_id', '=', TypeRegistrationSeeder::ID_FOR_TEST);
                },
            ],
        ];
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->modelService = $this->app->make(ModelJoinService::class, [
            'model' => new FestivalModel()
        ]);
    }
}