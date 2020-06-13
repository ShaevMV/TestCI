<?php

namespace App\Ticket\Modules\TypeRegistration\Specification;

final class SpecificationCount implements SpecificationInterface
{
    /**
     * @var int
     */
    private $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function isSatisfiedBy(SpecificationEntity $entity): bool
    {
        return $entity->getCount() >= $this->count;
    }
}