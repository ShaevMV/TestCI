<?php

namespace Tests\Unit\Response\ForAdmin;

use App\Ticket\Filter\Entity\FilterItem;
use App\Ticket\Filter\FilterList;
use App\Ticket\Filter\Service\FilterFactoryService;
use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Repository\FestivalRepository;
use App\Ticket\Pagination\Pagination;
use App\Ticket\Response\ForAdmin\ResponseList;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

class ResponseListTest extends TestCase
{
    private ResponseList $responseList;
    private FestivalRepository $festivalRepository;
    private FilterList $filterList;

    /**
     * Вывести результат в виде json
     */
    public function testResponse(): void
    {
        $pagination = new Pagination(1, 10);

        $filterItems = (new FilterItem())
            ->setValue((string)FestivalStatus::STATE_DRAFT_ID)
            ->setFieldAndTable('festivals.status')
            ->setType('int');

        $this->filterList->setFilterFields([FilterFactoryService::initFilter($filterItems)]);

        $entityList = $this->festivalRepository
            ->setFilter($this->filterList)
            ->setPagination($pagination)
            ->getList();

        $this->assertEquals(6, $pagination->getTotal());
        $this->assertNotNull($entityList);
        $this->assertJson($this->responseList->getJson($entityList ?? [], $pagination));
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->festivalRepository = $this->app->make(FestivalRepository::class);
        $this->responseList = $this->app->make(ResponseList::class);
        $this->filterList = $this->app->make(FilterList::class);
    }
}
