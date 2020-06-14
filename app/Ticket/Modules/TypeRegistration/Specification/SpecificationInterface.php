<?php

namespace App\Ticket\Modules\TypeRegistration\Specification;

/**
 * Interface SpecificationInterface
 *
 * Интерфейс спецификацйии
 *
 * @package App\Ticket\Modules\TypeRegistration\Specification
 */
interface SpecificationInterface
{
    /**
     * Проверка условий спецификаций
     *
     * @param SpecificationEntity $entity
     *
     * @return bool
     */
    public function isSatisfiedBy(SpecificationEntity $entity): bool;
}
