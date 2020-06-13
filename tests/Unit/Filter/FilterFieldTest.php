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
    const TYPE_INDEX = "type";
    const FIELD_INDEX = "index";
    const VALUE_INDEX = "value";

    /**
     * Создать фильтр из данных
     *
     * @dataProvider dataProviderFilter
     * @param string $class
     * @param array $data
     * @return void
     */
    public function testCreateFilter(array $data, string $class)
    {
        $filter = (new FilterItem())
            ->setValue($data[self::VALUE_INDEX])
            ->setFieldAndTable($data[self::FIELD_INDEX])
            ->setType($data[self::TYPE_INDEX]);

        $this->assertInstanceOf($class, FilterFactoryService::initFilter($filter));
    }

    /**
     * Создать набор фильтров
     *
     * @dataProvider dataProviderFilter
     *
     * @param array $data
     */
    public function testCreateFilterList(array $data)
    {
        static $filters = [];

        $filter = (new FilterItem())
            ->setValue($data[self::VALUE_INDEX])
            ->setFieldAndTable($data[self::FIELD_INDEX])
            ->setType($data[self::TYPE_INDEX]);

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
     */
    public function testFiltration(array $data)
    {
        static $filters = [];

        $filterItems = (new FilterItem())
            ->setValue($data[self::VALUE_INDEX])
            ->setFieldAndTable($data[self::FIELD_INDEX])
            ->setType($data[self::TYPE_INDEX]);

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
        return [
            [[
                self::TYPE_INDEX => FilterFactoryService::INTEGER_TYPE,
                self::FIELD_INDEX => 'festivals.status',
                self::VALUE_INDEX => FestivalSeeder::STATUS_FOR_TEST,
            ], FilterInteger::class],
            [[
                self::TYPE_INDEX => FilterFactoryService::STRING_TYPE,
                self::FIELD_INDEX => 'festivals.title',
                self::VALUE_INDEX => FestivalSeeder::TITLE_FOR_TEST,
            ], FilterString::class],
            [[
                self::TYPE_INDEX => FilterFactoryService::DATE_TYPE,
                self::FIELD_INDEX => 'festivals.date_start',
                self::VALUE_INDEX => FestivalSeeder::DATE_START_FOR_TEST,
            ], FilterDate::class],
            [[
                self::TYPE_INDEX => FilterFactoryService::DATE_BETWEEN_TYPE,
                self::FIELD_INDEX => 'festivals.date_start',
                self::VALUE_INDEX => [
                    FestivalSeeder::DATE_START_FOR_TEST,
                    FestivalSeeder::DATE_END_FOR_TEST,
                ]
            ], FilterDateBetween::class],
            [[
                self::TYPE_INDEX => FilterFactoryService::INTEGER_TYPE,
                self::FIELD_INDEX => 'typeRegistration.price',
                self::VALUE_INDEX => TypeRegistrationSeeder::PRICE_FOR_TEST
            ], FilterInteger::class],
            [[
                self::TYPE_INDEX => FilterFactoryService::STRING_TYPE,
                self::FIELD_INDEX => 'typeRegistration.title',
                self::VALUE_INDEX => TypeRegistrationSeeder::TITLE_FOR_TEST
            ], FilterString::class],
        ];
    }
}
