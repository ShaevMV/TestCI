<?php

namespace App\Ticket\Modules\PromoCode\Entity;

use App\Ticket\Date\DateBetween;
use App\Ticket\Entity\AbstractionEntity;
use Webpatser\Uuid\Uuid;

/**
 * Class PromoCode
 *
 * сущность промокода
 *
 * @package App\Ticket\Modules\PromoCode\Entity
 */
final class PromoCode extends AbstractionEntity
{
    /**
     * Идентификатор
     *
     * @var Uuid
     */
    protected $id;

    /**
     * Промо код
     *
     * @var string
     */
    protected $name;

    /**
     * Изменения цены
     *
     * @var DeltaPrice
     */
    protected $delta;

    /**
     * Дата действия промо кода
     *
     * @var DateBetween
     */
    protected $date;

    /**
     * Активность
     *
     * @var bool
     */
    protected $active;

    /**
     * Идентификатор фестиваля
     *
     * @var Uuid
     */
    protected $festival_id;

    public static function fromState(array $data): PromoCode
    {
        return (new self())
            ->setId(Uuid::import($data['id']))
            ->setName($data['name'])
            ->setDate(DateBetween::fromState($data))
            ->setActive($data['active'])
            ->setFestivalId(Uuid::import($data['festival_id']))
            ->setDelta(DeltaPrice::fromState($data));
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @param Uuid $id
     *
     * @return PromoCode
     */
    public function setId(Uuid $id): PromoCode
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return PromoCode
     */
    public function setName(string $name): PromoCode
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DeltaPrice
     */
    public function getDelta(): DeltaPrice
    {
        return $this->delta;
    }

    /**
     * @param DeltaPrice $delta
     *
     * @return PromoCode
     */
    public function setDelta(DeltaPrice $delta): PromoCode
    {
        $this->delta = $delta;

        return $this;
    }

    /**
     * @return DateBetween
     */
    public function getDate(): DateBetween
    {
        return $this->date;
    }

    /**
     * @param DateBetween $date
     *
     * @return PromoCode
     */
    public function setDate(DateBetween $date): PromoCode
    {
        $this->date = $date;

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
     * @return PromoCode
     */
    public function setActive(bool $active): PromoCode
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param Uuid $festivalId
     *
     * @return PromoCode
     */
    public function setFestivalId(Uuid $festivalId): PromoCode
    {
        $this->festival_id = $festivalId;

        return $this;
    }

    /**
     * @return Uuid
     */
    public function getFestivalId(): Uuid
    {
        return $this->festival_id;
    }
}
