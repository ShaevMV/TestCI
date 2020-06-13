<?php

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Entity\EntityDataInterface;
use Carbon\Carbon;
use InvalidArgumentException;

/**
 * Class FestivalDate
 *
 * @package App\Ticket\Festival\Entity
 */
final class FestivalDate implements EntityDataInterface
{
    /** @var Carbon Дата */
    private $date;

    /**
     * FestivalDate constructor.
     *
     * @param Carbon $date
     */
    private function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * @param string $carbonDate
     *
     * @return FestivalDate
     *
     * @throws InvalidArgumentException
     */
    public static function getInstance(string $carbonDate): FestivalDate
    {
        $date = new Carbon($carbonDate);

        if (count($date::getLastErrors()['errors']) > 0) {
            throw new InvalidArgumentException(
                "{$carbonDate} not DateType. Error: " . implode(PHP_EOL, $date::getLastErrors()['errors'])
            );
        }

        return new self($date);
    }

    /**
     * Сравнения даты
     *
     * @param Carbon $dateMore
     *
     * @return int
     */
    public function isMore(Carbon $dateMore): int
    {
        if (!empty($this->date)) {
            return $this->date->diffInDays($dateMore);
        }

        throw new InvalidArgumentException(__Class__ . " Date is empty");
    }

    /**
     * @return null|string
     */
    public function __toString(): ?string
    {
        return $this->date->toDateString() ?? null;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return $this->date;
    }

    /**
     * @param Carbon $date
     *
     * @return FestivalDate
     */
    public function setDate(Carbon $date): self
    {
        $this->date = $date;

        return $this;
    }
}
