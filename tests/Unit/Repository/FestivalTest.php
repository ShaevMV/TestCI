<?php

namespace Tests\Unit\Repository;

use App\Ticket\Filter\Entity\FilterItem;
use App\Ticket\Filter\FilterList;
use App\Ticket\Filter\Service\FilterFactoryService;
use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Modules\Festival\Entity\FestivalDate;
use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Repository\TypeRegistrationRepository;
use App\Ticket\Pagination\Pagination;
use Carbon\Carbon;
use FestivalSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use TypeRegistrationSeeder;
use Webpatser\Uuid\Uuid;

/*use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;*/

/**
 * Class FestivalTest
 *
 * @package Tests\Unit\Repository
 *
 * + Записать фестиваль / получить фестиваль по его id
 * + Обновить данные фестеваля
 * + Получить активный фестеваль который проходит сейчас
 * + Вывести список всех фестивалей
 * TODO: Добавить класс для проверки корректности
 */
class FestivalTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var string
     */
    private $id;

    /**
     * @var FestivalRepository
     */
    private $festivalRepository;

    /**
     * @var TypeRegistrationRepository
     */
    private $typeRegistrationRepository;

    /**
     * Записать фестиваль / получить фестиваль по его id
     *
     * @return void
     */
    public function testCreate()
    {
        $festival = (new Festival())
            ->setTitle("Test")
            ->setDateStart(FestivalDate::getInstance(Carbon::today()->toDateString()))
            ->setDateEnd(FestivalDate::getInstance(Carbon::today()->addDay()->toDateString()))
            ->setStatus(FestivalStatus::fromString(FestivalStatus::STATE_PUBLISHED));

        $id = $this->festivalRepository->create($festival);
        $this->assertInstanceOf(Uuid::class, $id);

        $festival->setId($id);
        $this->assertEquals($festival, $this->festivalRepository->findById($id));
    }

    /**
     * Обновить данные фестиваля
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $id = Uuid::import($this->id);
        $festival = new Festival();
        $festival->setStatus(FestivalStatus::fromInt(FestivalStatus::STATE_PUBLISHED_ID));
        $this->assertTrue($this->festivalRepository->update($id, $festival));
        $this->assertEquals($festival->getStatus(), $this->festivalRepository->findById($id)->getStatus());
    }

    /**
     * Связать проходку с фестивалем
     *
     * @return void
     */
    public function testJoinTypeRegistrationTable(): void
    {
        $price = (new Price())
            ->setPrice(1000);
        $this->assertTrue($this->festivalRepository->joinTypeRegistration(
            Uuid::import(FestivalSeeder::ID_FOR_TEST),
            Uuid::import(TypeRegistrationSeeder::ID_FOR_TEST),
            $price
        ));
    }

    /**
     * Получить активный фестеваль который проходит сейчас
     *
     * @return void
     */
    public function testGetActive(): void
    {
        $festival = $this->festivalRepository->getActive();
        $typeRegistrationList = $this->typeRegistrationRepository->getTypeRegistrationForFestival($festival->getId());
        $this->assertIsArray($typeRegistrationList);

        $festival->setTypeRegistration($typeRegistrationList);

        $this->assertInstanceOf(get_class(new Festival()), $festival);
    }

    /**
     * Получить список фестивалей
     *
     * @return void
     */
    public function testGetList(): void
    {
        $filter[] = FilterFactoryService::initFilter((new FilterItem())
            ->setType(FilterFactoryService::STRING_TYPE)
            ->setFieldAndTable('festivals.id')
            ->setValue(FestivalSeeder::ID_FOR_TEST));

        $festivalList = $this->festivalRepository
            ->setPagination(Pagination::getInstance(1, 1))
            ->setFilter($this->app->make(FilterList::class, [
                'filterFields' => $filter
            ]))
            ->getList();

        $this->assertIsArray($festivalList);
        $this->assertCount(1, $festivalList);

        /** @var Festival $festivalItem */
        $festivalItem = end($festivalList);
        $this->assertInstanceOf(Festival::class, $festivalItem);
        $this->assertEquals(FestivalSeeder::ID_FOR_TEST, $festivalItem->getId());
    }


    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->festivalRepository = $this->app->make(FestivalRepository::class);
        $this->typeRegistrationRepository = $this->app->make(TypeRegistrationRepository::class);
        $this->id = FestivalSeeder::ID_FOR_TEST;
    }
}
