<?php

namespace App\Ticket\Modules\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\DTO\TypeRegistrationViewDTO;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationAnd;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationEntity;

final class TypeRegistrationListService
{
    /** @var SpecificationService */
    private $specificationService;

    public function __construct(SpecificationService $specificationService)
    {
        $this->specificationService = $specificationService;
    }

    /**
     * @param TypeRegistration[] $typeRegistration
     * @param SpecificationEntity $specificationEntity
     *
     * @return TypeRegistrationViewDTO[]
     */
    public function getList(array $typeRegistration, SpecificationEntity $specificationEntity): array
    {
        $result = [];

        foreach ($typeRegistration as $item) {
            $active = $this->isActive($item, $specificationEntity);
            $result[] = (new TypeRegistrationViewDTO())
                ->setTypeRegistration($item)
                ->setActive($active);
        }

        return $result;
    }

    private function isActive(TypeRegistration $typeRegistration, SpecificationEntity $specificationEntity): bool
    {
        $listSpecification = $this->specificationService
            ->createList($typeRegistration->getParams());

        return (new SpecificationAnd($listSpecification))
            ->isSatisfiedBy($specificationEntity);
    }
}