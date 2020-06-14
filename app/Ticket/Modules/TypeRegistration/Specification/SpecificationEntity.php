<?php

namespace App\Ticket\Modules\TypeRegistration\Specification;

/**
 * Class SpecificationEntity
 *
 * Сущность спецификации
 *
 * @package App\Ticket\Modules\TypeRegistration\Specification
 */
final class SpecificationEntity
{
    /**
     * Количество билетов
     *
     * @var int
     */
    private $count;

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     *
     * @return $this
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
