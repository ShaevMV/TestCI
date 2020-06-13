<?php


namespace App\Ticket\Modules\TypeRegistration\Specification;


final class SpecificationAnd implements SpecificationInterface
{
    /**
     * @var SpecificationInterface[]
     */
    private $specifications;

    /**
     * @param SpecificationInterface[] $specifications
     */
    public function __construct(array $specifications)
    {
        $this->specifications = $specifications;
    }

    public function isSatisfiedBy(SpecificationEntity $entity): bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($entity)) {
                return false;
            }
        }

        return true;
    }
}