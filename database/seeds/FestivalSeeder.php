<?php

use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use Illuminate\Database\Seeder;

class FestivalSeeder extends Seeder
{
    public const ID_FOR_TEST = "6b344490-5f06-11ea-a349-23f49f069486";
    public const TITLE_FOR_TEST = "For test";
    public const STATUS_FOR_TEST = FestivalStatus::STATE_PUBLISHED_ID;
    public const DATE_START_FOR_TEST = "2020-01-03";
    public const DATE_END_FOR_TEST = "2020-12-03";

    public const ID_FOR_TEST_NOT_ACTIVE = "7d240d20-92d4-11ea-9c08-7dbd77e1988c";
    public const TITLE_FOR_TEST_NOT_ACTIVE = "For test not active";
    public const STATUS_FOR_TEST_NOT_ACTIVE = FestivalStatus::STATE_DRAFT_ID;
    public const DATE_START_FOR_TEST_NOT_ACTIVE = "2020-01-03";
    public const DATE_END_FOR_TEST_NOT_ACTIVE = "2020-12-03";

    /**
     * @throws Exception
     */
    public function run()
    {
        (new FestivalModel())->insert([
            'title' => self::TITLE_FOR_TEST,
            'id' => self::ID_FOR_TEST,
            'status' => self::STATUS_FOR_TEST,
            'date_start' => self::DATE_START_FOR_TEST,
            'date_end' => self::DATE_END_FOR_TEST,
        ]);

        (new FestivalModel())->insert([
            'title' => self::TITLE_FOR_TEST_NOT_ACTIVE,
            'id' => self::ID_FOR_TEST_NOT_ACTIVE,
            'status' => self::STATUS_FOR_TEST_NOT_ACTIVE,
            'date_start' => self::DATE_START_FOR_TEST_NOT_ACTIVE,
            'date_end' => self::DATE_END_FOR_TEST_NOT_ACTIVE,
        ]);

        (new FestivalModel())
            ->find(self::ID_FOR_TEST)
            ->typeRegistration()
            ->syncWithoutDetaching([
                TypeRegistrationSeeder::ID_FOR_TEST => [
                    'price' => (string)TypeRegistrationSeeder::PRICE_FOR_TEST,
                ]
            ]);

        (new FestivalModel())
            ->find(self::ID_FOR_TEST)
            ->typeRegistration()
            ->syncWithoutDetaching([
                TypeRegistrationSeeder::ID_FOR_TEST_COUNT => [
                    'price' => (string)TypeRegistrationSeeder::PRICE_FOR_TEST_COUNT,
                    'params' => json_encode(TypeRegistrationSeeder::PARAMS_FOR_TEST_COUNT)
                ]
            ]);

        factory(FestivalModel::class, 4)
            ->create()
            ->each(function (FestivalModel $festivalModel) {
                $typeRegistrationFirst = factory(TypeRegistrationModule::class)->make();
                $festivalModel->typeRegistration()->save($typeRegistrationFirst, [
                    'price' => random_int(1000, 2000)
                ]);

                $typeRegistrationLast = factory(TypeRegistrationModule::class)->make();
                $festivalModel->typeRegistration()->save($typeRegistrationLast, [
                    'price' => random_int(1000, 2000)
                ]);
            });
    }
}
