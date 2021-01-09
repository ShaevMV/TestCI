<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Ticket\Filter\Service\FilterListService;
use App\Ticket\Modules\Festival\Service\FestivalService;
use App\Ticket\Pagination\Pagination;
use App\Ticket\Response\ForAdmin\ResponseList;
use Illuminate\Http\Request;

class FestivalAdminController extends Controller
{
    private FestivalService $festivalService;
    private FilterListService $filterListService;
    private ResponseList $responseList;

    public function __construct(
        FestivalService $festivalService,
        FilterListService $filterListService,
        ResponseList $responseList
    )
    {
        $this->middleware('auth:api');

        $this->festivalService = $festivalService;
        $this->filterListService = $filterListService;
        $this->responseList = $responseList;
    }

    /**
     * Вывести список фестивалей
     *
     * @param Request $request
     * @param int $page
     * @param int $limit
     *
     * @return string
     */
    public function getList(Request $request, int $page, int $limit = Pagination::DEFAULT_LIMIT): string
    {
        $pagination = new Pagination($page, $limit);
        /** @var array|null $arrFilterRaw */
        $arrFilterRaw = $request->post('filter');
        $filterList = $this->filterListService->getFilterListOfRaw($arrFilterRaw);

        $festivalList = $this->festivalService->getList($pagination, $filterList);

        return $this->responseList->getJson($festivalList ?? [], $pagination);
    }
}
