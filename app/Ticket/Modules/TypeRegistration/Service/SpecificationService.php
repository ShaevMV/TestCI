<?php

namespace App\Ticket\Modules\TypeRegistration\Service;

use App\Ticket\Modules\TypeRegistration\Entity\Parameter;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationCount;
use App\Ticket\Modules\TypeRegistration\Specification\SpecificationInterface;
use InvalidArgumentException;

final class SpecificationService
{
    public const KEY_COUNT = 'count';

    private const ARRAY_KEY = [
        self::KEY_COUNT,
    ];


    /**
     * @param Parameter|null $parameter
     *
     * @return SpecificationInterface[]
     */
    public function createList(?Parameter $parameter): array
    {
        $result = [];

        foreach ($parameter->toArray() as $key => $value) {
            switch ($key) {
                case self::KEY_COUNT:
                    $result[] = new SpecificationCount($value);
                    break;
                default:
                    throw new InvalidArgumentException(
                        "Invalid key specification {$key}. The array " .
                        implode(" ", self::ARRAY_KEY) . " does not contain"
                    );
                    break;
            }
        }

        return $result;
    }
}
