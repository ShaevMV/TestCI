<?php

namespace App\Ticket\Modules\Festival\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\Festival\Entity\Festival;
use App\Ticket\Modules\Festival\Entity\FestivalStatus;
use App\Ticket\Modules\Festival\Model\FestivalModel;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Repository\BaseRepository;
use Carbon\Carbon;
use Exception;
use OutOfBoundsException;
use Webpatser\Uuid\Uuid;
use App\Ticket\Model\Model;

final class FestivalRepository extends BaseRepository
{
    public function __construct(FestivalModel $festivalModel)
    {
        $this->model = $festivalModel;
    }

    /**
     * @param Festival $festival
     *
     * @return Uuid|null
     */
    public function create($festival): ?Uuid
    {
        $create = $this->model->create([
            'title' => $festival->getTitle(),
            'date_start' => (string)$festival->getDateStart(),
            'date_end' => (string)$festival->getDateEnd(),
            'status' => $festival->getStatus()
        ]);

        return isset($create->id) ? Uuid::import($create->id) : null;
    }


    /**
     * Найти Фестиваль по его id
     *
     * @param Uuid $id
     *
     * @return Festival
     */
    public function findById(Uuid $id)
    {
        try {
            $arrayData = $this->model->find((string)$id);
        } catch (OutOfBoundsException $e) {
            throw new OutOfBoundsException('Festival with id ' . (string)$id . ' does not exist');
        }

        return Festival::fromState($arrayData->toArray());
    }

    /**
     * Вывести фестиваль который проходит в данный момент
     *
     * @throws OutOfBoundsException
     *
     * @return Festival|null
     */
    public function getActive(): ?Festival
    {
        $arrayData = $this->model
            ->where('date_start', '<=', Carbon::today()->toDateString())
            ->where('date_end', '>=', Carbon::today()->toDateString())
            ->where('status', '=', FestivalStatus::STATE_PUBLISHED_ID)
            ->first();

        if ($arrayData instanceof Model) {
            return Festival::fromState($arrayData->toArray());
        } else {
            throw new OutOfBoundsException('Active festival not found');
        }
    }

    /**
     * Связать фестиваль и тип проходки
     *
     * @param Uuid $idTypeRegistration
     * @param Uuid $idFestival
     * @param Price $price
     *
     * @throws OutOfBoundsException
     *
     * @return bool
     */
    public function joinTypeRegistration(Uuid $idFestival, Uuid $idTypeRegistration, Price $price): bool
    {
        try {
            /** @var FestivalModel $sync */
            $sync = $this->model::findOrFail((string)$idFestival);

            $sync->typeRegistration()
                ->syncWithoutDetaching([
                    (string)$idTypeRegistration => [
                        'price' => (string)$price
                    ]
                ]);
        } catch (Exception $exception) {
            throw new OutOfBoundsException($exception->getMessage());
        }

        return !empty($sync);
    }

    protected function build(array $data): EntityInterface
    {
        return Festival::fromState($data);
    }
}
