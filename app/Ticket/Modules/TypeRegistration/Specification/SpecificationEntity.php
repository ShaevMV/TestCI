<?php

namespace App\Ticket\Modules\TypeRegistration\Specification;

final class SpecificationEntity
{
    /** @var int */
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
