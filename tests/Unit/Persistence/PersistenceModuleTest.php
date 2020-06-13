<?php

namespace Tests\Unit\Persistence;

use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use Carbon\Carbon;
use FestivalSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

/*use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;*/

/**
 * Class FestivalModuleTest
 * @package Tests\Unit\Module
 *
 * + записать данные в базу / найти запись по его id
 * + обновить данные
 * + Удалить
 * + Поиск
 */
class PersistenceModuleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var FestivalModel
     */
    private $model;

    /**
     * @var int;
     */
    private $id;


    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new FestivalModel();
        $this->id = FestivalSeeder::ID_FOR_TEST;
    }

    /**
     * Записать данные в базу / найти запись по его id
     *
     * @return void
     */
    public function testCreate()
    {
        $id = uniqid();
        $this->assertTrue($this->model->insert([
            'id' => $id,
            'title' => 'тест из теста',
            'date_start' => Carbon::today()->toDateString(),
            'date_end' => Carbon::today()->addDays(5)->toDateString(),
            'status' => FestivalStatus::STATE_PUBLISHED_ID
        ]));
        $this->assertNotEmpty($this->model->find($id));

        $this->assertTrue($this->model->insert([]));
        $this->assertNull($this->model->find($id . '21'));

    }

    /**
     * обновить данные фестиваля
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->assertTrue($this->model
                ->where('id', '=', $this->id)
                ->update([
                    'status' => '1'
                ]) > 0);

        $this->assertEquals(1, $this->model->find($this->id)->status);
    }

    /**
     * Удалить
     */
    public function testDelete()
    {
        $this->assertEquals(1, $this->model->whereId($this->id)->delete());
        $this->assertNull($this->model->find($this->id));
    }

    /**
     * Поиск
     */
    public function testWhereAndGet()
    {
        $this->assertInstanceOf(FestivalModel::class, $this->model->where('id', '=', $this->id)->first());
        $this->assertInstanceOf(Collection::class, $this->model->where('id', '=', $this->id)->get());
        $this->assertEmpty($this->model->where('id', '=', $this->id . '54')->get()->toArray());
    }
}
