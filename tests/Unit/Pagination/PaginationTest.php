<?php

namespace Tests\Unit\Pagination;

use App\Ticket\Pagination\Pagination;
use Tests\TestCase;

/**
 * Class PaginationTest
 *
 * @package Tests\Unit\Pagination
 */
class PaginationTest extends TestCase
{
    const PAGE = 1;
    const LIMIT = 1;

    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $this->assertInstanceOf(Pagination::class, $this->pagination);
        $this->assertEquals(self::PAGE, $this->pagination->getPage());
        $this->assertEquals(self::LIMIT, $this->pagination->getLimit());
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->pagination = Pagination::getInstance(self::PAGE, self::LIMIT);
    }
}
