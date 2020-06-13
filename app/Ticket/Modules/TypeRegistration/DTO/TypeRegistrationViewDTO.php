<?php

namespace App\Ticket\Modules\TypeRegistration\DTO;

use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;

final class TypeRegistrationViewDTO
{
    /** @var TypeRegistration */
    private $typeRegistration;

    /** @var bool */
    private $active;

    /**
     * @return TypeRegistration
     */
    public function getTypeRegistration(): TypeRegistration
    {
        return $this->typeRegistration;
    }

    /**
     * @param TypeRegistration $typeRegistration
     *
     * @return $this
     */
    public function setTypeRegistration(TypeRegistration $typeRegistration): self
    {
        $this->typeRegistration = $typeRegistration;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
