<?php

namespace Tests\Unit\Repository;

use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Repository\TypeRegistrationRepository;
use FestivalSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use TypeRegistrationSeeder;
use Webpatser\Uuid\Uuid;

//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class TypeRegistrationTest
 * @package Tests\Unit\Repository
 *
 * + Создать новый тип проходки
 * + Сменить названия у типа проходки
 * + Вывести все типы проходок в фестевале
 */
class TypeRegistrationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var TypeRegistrationRepository;
     */
    protected $typeRegistrationRepository;

    /**
     * Создать новый тип проходки
     *
     * @return void
     */
    public function testCreate()
    {
        $typeRegistration = (new TypeRegistration())
            ->setTitle('Test');

        $id = $this->typeRegistrationRepository->create($typeRegistration);

        $this->assertInstanceOf(Uuid::class, $id);
        $this->assertNotEmpty((string)$id);

        $typeRegistration->setId($id);

        $this->assertEquals($this->typeRegistrationRepository->findById($id), $typeRegistration);
    }

    /**
     * Сменить названия у типа проходки
     *
     * @return void
     */
    public function testUpdate()
    {
        $typeRegistration = (new TypeRegistration())
            ->setTitle('Test2');

        $id = Uuid::import(TypeRegistrationSeeder::ID_FOR_TEST);
        $this->typeRegistrationRepository
            ->update(
                $id,
                $typeRegistration
            );
        $typeRegistration->setId($id);

        $this->assertEquals($this->typeRegistrationRepository->findById($id), $typeRegistration);
        $this->assertEquals('Test2', $this->typeRegistrationRepository->findById($id)->getTitle());
    }

    /**
     * Вывести все типы проходок в фестевале
     *
     * @return void
     */
    public function testGetAllTypeRegistration(): void
    {
        $listTypeRegistration = $this->typeRegistrationRepository
            ->getTypeRegistrationForFestival(Uuid::import(FestivalSeeder::ID_FOR_TEST));

        $this->assertIsArray($listTypeRegistration);
        $this->assertCount(2, $listTypeRegistration);
        $this->assertInstanceOf(TypeRegistration::class, end($listTypeRegistration));
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->typeRegistrationRepository = $this->app->make(TypeRegistrationRepository::class);
    }
}
