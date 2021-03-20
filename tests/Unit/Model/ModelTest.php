<?php

namespace Tests\Unit\Model;

use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use Carbon\Carbon;
use Database\Seeders\FestivalSeeder;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var FestivalModel
     */
    private $model;

    /**
     * @var string;
     */
    private $id;

    /**
     * Записать данные в базу / найти запись по его id
     *
     * @return void
     */
    public function testCreate(): void
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
        /** @var FestivalModel $festival */
        $festival = $this->model->find($this->id);

        $this->assertEquals(1, $festival->status);
    }

    /**
     * Удалить
     *
     * @return void
     * @throws Exception
     *
     */
    public function testDelete(): void
    {
        $this->assertEquals(1, $this->model->whereId($this->id)->delete());
        $this->assertNull($this->model->find($this->id));
    }

    /**
     * Поиск
     *
     * @return void
     */
    public function testWhereAndGet(): void
    {
        $this->assertInstanceOf(FestivalModel::class, $this->model->where('id', '=', $this->id)->first());
        $this->assertInstanceOf(Collection::class, $this->model->where('id', '=', $this->id)->get());
        $this->assertEmpty($this->model->where('id', '=', $this->id . '54')->get()->toArray());
    }

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new FestivalModel();
        $this->id = FestivalSeeder::ID_FOR_TEST;
    }
}
