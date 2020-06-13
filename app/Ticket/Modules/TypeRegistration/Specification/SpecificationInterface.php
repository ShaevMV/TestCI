<?php

namespace App\Ticket\Modules\TypeRegistration\Specification;

interface SpecificationInterface
{
    /**
     * @param SpecificationEntity $entity
     *
     * @return bool
     */
    public function isSatisfiedBy(SpecificationEntity $entity): bool;
}