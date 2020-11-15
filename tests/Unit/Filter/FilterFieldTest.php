<?php

namespace Tests\Unit\Filter;

use App\Ticket\Filter\Entity\FilterItem;
use App\Ticket\Filter\FilterList;
use App\Ticket\Filter\Service\Factory\FilterDate;
use App\Ticket\Filter\Service\Factory\FilterDateBetween;
use App\Ticket\Filter\Service\Factory\FilterInteger;
use App\Ticket\Filter\Service\Factory\FilterString;
use App\Ticket\Filter\Service\FilterFactoryService;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use FestivalSeeder;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;
use TypeRegistrationSeeder;

//use Illuminate\Foundation\Testing\WithFaker;
//use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class FilterFieldTest
 * @package Tests\Unit\Filter
 *
 * + Создать фильтр из данных
 * + Создать набор фильтров
 * + Реализовать запрос по фильтру
 */
class FilterFieldTest extends TestCase
{
    private const TYPE_INDEX = "type";
    private const FIELD_INDEX = "index";
    private const VALUE_INDEX = "value";

    /**
     * Создать фильтр из данных
     *
     * @dataProvider dataProviderFilter
     *
     * @param object $class
     * @param array $data
     *
     * @return void
     */
    public function testCreateFilter(array $data, object $class): void
    {
         $filter = (new FilterItem())
            ->setValue($data[self::VALUE_INDEX])
            ->setFieldAndTable((string)$data[self::FIELD_INDEX])
            ->setType((string)$data[self::TYPE_INDEX]);

        $this->assertInstanceOf(get_class($class), FilterFactoryService::initFilter($filter));
    }

    /**
     * Создать набор фильтров
     *
     * @dataProvider dataProviderFilter
     *
     * @param array $data
     *
     * @return void
     * @throws BindingResolutionException
     *
     */
    public function testCreateFilterList(array $data): void
    {
        static $filters = [];

        $filter = (new FilterItem())
            ->setValue($data[self::VALUE_INDEX])
            ->setFieldAndTable((string)$data[self::FIELD_INDEX])
            ->setType((string)$data[self::TYPE_INDEX]);

        $filters[] = FilterFactoryService::initFilter($filter);

        $filterList = $this->app->make(FilterList::class, [
            'filterFields' => $filters
        ]);

        $this->assertInstanceOf(FilterList::class, $filterList);
        $this->assertIsArray($filterList->getFilterFields());
        $this->assertCount(count($filters), $filterList->getFilterFields());
    }

    /**
     * Реализовать запрос по фильтру
     *
     * @dataProvider dataProviderFilter
     *
     * @param array $data
     *
     * @return void
     * @throws BindingResolutionException
     *
     */
    public function testFiltration(array $data): void
    {
        static $filters = [];

        $filterItems = (new FilterItem())
            ->setValue($data[self::VALUE_INDEX])
            ->setFieldAndTable((string)$data[self::FIELD_INDEX])
            ->setType((string)$data[self::TYPE_INDEX]);

        $filters[] = FilterFactoryService::initFilter($filterItems);

        $festival = new FestivalModel();

        $filterList = $this->app->make(FilterList::class, [
            'filterFields' => $filters
        ]);

        $fromFiltered = $filterList->filtration($festival->getQuery(), $festival)->get();

        $this->assertTrue($fromFiltered->count() > 0);
        $this->assertNotEquals($festival->count(), $fromFiltered->count());
    }

    /**
     * @return array
     */
    public function dataProviderFilter()
    {
        $filterItem = new FilterItem();

        return [
            [[
                self::TYPE_INDEX => FilterFactoryService::INTEGER_TYPE,
                self::FIELD_INDEX => 'festivals.status',
                self::VALUE_INDEX => FestivalSeeder::STATUS_FOR_TEST,
            ], new FilterInteger($filterItem)],
            [[
                self::TYPE_INDEX => FilterFactoryService::STRING_TYPE,
                self::FIELD_INDEX => 'festivals.title',
                self::VALUE_INDEX => FestivalSeeder::TITLE_FOR_TEST,
            ], new FilterString($filterItem)],
            [[
                self::TYPE_INDEX => FilterFactoryService::DATE_TYPE,
                self::FIELD_INDEX => 'festivals.date_start',
                self::VALUE_INDEX => FestivalSeeder::DATE_START_FOR_TEST,
            ], new FilterDate($filterItem)],
            [[
                self::TYPE_INDEX => FilterFactoryService::DATE_BETWEEN_TYPE,
                self::FIELD_INDEX => 'festivals.date_start',
                self::VALUE_INDEX => [
                    FestivalSeeder::DATE_START_FOR_TEST,
                    FestivalSeeder::DATE_END_FOR_TEST,
                ]
            ], new FilterDateBetween($filterItem)],
            [[
                self::TYPE_INDEX => FilterFactoryService::INTEGER_TYPE,
                self::FIELD_INDEX => 'typeRegistration.price',
                self::VALUE_INDEX => TypeRegistrationSeeder::PRICE_FOR_TEST
            ], new FilterInteger($filterItem)],
            [[
                self::TYPE_INDEX => FilterFactoryService::STRING_TYPE,
                self::FIELD_INDEX => 'typeRegistration.title',
                self::VALUE_INDEX => TypeRegistrationSeeder::TITLE_FOR_TEST
            ], new FilterString($filterItem)],
        ];
    }
}
