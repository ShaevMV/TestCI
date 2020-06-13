<?php

namespace App\Ticket\Modules\TypeRegistration\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Model\Model;
use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Entity\Price;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Model\TypeRegistrationModule;
use App\Ticket\Repository\BaseRepository;
use OutOfBoundsException;
use Webpatser\Uuid\Uuid;

final class TypeRegistrationRepository extends BaseRepository
{
    public function __construct(TypeRegistrationModule $typeRegistrationModule)
    {
        $this->model = $typeRegistrationModule;
    }

    /**
     *
     * @param TypeRegistration $entity
     *
     * @return Uuid|null
     */
    public function create($entity): ?Uuid
    {
        /** @var Model $create */
        $create = $this->model->create([
            'title' => $entity->getTitle()
        ]);

        return isset($create->id) ? Uuid::import($create->id) : null;
    }

    /**
     * @inheritDoc
     */
    public function findById(Uuid $id)
    {
        try {
            $arrayData = $this->model->find((string)$id);
        } catch (OutOfBoundsException $e) {
            throw new OutOfBoundsException($this->model->getTable() . ' with id ' . (string)$id . ' does not exist');
        }

        return (new TypeRegistration())
            ->setId(Uuid::import($arrayData['id']))
            ->setTitle($arrayData['title']);
    }

    /**
     * Выдать список типов проходок у определённого фестиваля
     *
     * @param Uuid $idFestival
     *
     * @return TypeRegistration[]
     */
    public function getTypeRegistrationForFestival(Uuid $idFestival): array
    {
        $typeRegistrationList = $this->model
            ->leftJoin('type_registration_festival', 'type_registration_id', '=', 'id')
            ->where('type_registration_festival.festival_id', '=', (string)$idFestival)
            ->get()
            ->toArray();

        $typeRegistration = [];

        foreach ($typeRegistrationList as $item) {
            $typeRegistration[] = (new TypeRegistration())
                ->setId(Uuid::import($item['id']))
                ->setTitle($item['title'])
                ->setPrice(Price::fromState($item['price']))
                ->setParams(Parameter::fromState($item['params']));
        }

        return $typeRegistration;
    }

    protected function build(array $data): EntityInterface
    {
        return TypeRegistration::fromState($data);
    }
}
