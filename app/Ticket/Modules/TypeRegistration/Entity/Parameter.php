<?php

namespace App\Ticket\Modules\TypeRegistration\Entity;

use InvalidArgumentException;

final class Parameter
{
    /** @var string|null */
    private $params;

    public static function fromState(?string $params): self
    {
        if ($params !== null && !self::isValidate($params)) {
            throw new InvalidArgumentException("{$params} not format json");
        }

        return (new self())
            ->setParams($params);
    }

    private static function isValidate(string $params): bool
    {
        json_decode($params);

        return json_last_error() == JSON_ERROR_NONE;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->params, true) ?? [];
    }

    /**
     * @param string|null $params
     *
     * @return $this
     */
    public function setParams(?string $params): self
    {
        $this->params = $params;

        return $this;
    }
}
