<?php

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Date\DateBetween;
use App\Ticket\Entity\AbstractionEntity;
use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use Webpatser\Uuid\Uuid;

/**
 * Class Festival
 *
 * Сущность фестиваля
 *
 * @package App\Ticket\Festival\Entity
 */
final class Festival extends AbstractionEntity
{
    /**
     * Идентификатор
     *
     * @var Uuid
     */
    protected $id;

    /**
     * Статус
     *
     * @var FestivalStatus
     */
    protected $status;

    /**
     * Заголовок - названия
     *
     * @var string
     */
    protected $title;

    /**
     * Даты проведения
     *
     * @var DateBetween
     */
    protected $date;

    /**
     * Описание
     *
     * @var string|null
     */
    protected $description;

    /**
     * Типы билетов
     *
     * @var TypeRegistration[]|null
     */
    protected $typeRegistration;

    /**
     * @param array $data
     *
     * @return DateBetween|EntityInterface|Festival
     */
    public static function fromState(array $data)
    {
        return (new self())
            ->setId(Uuid::import($data['id']))
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setDate(DateBetween::fromState($data))
            ->setStatus(FestivalStatus::fromInt($data['status']));
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
     * @return Festival
     */
    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return FestivalStatus|null
     */
    public function getStatus(): ?FestivalStatus
    {
        return $this->status;
    }

    /**
     * @param FestivalStatus $status
     *
     * @return self
     */
    public function setStatus(FestivalStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return TypeRegistration[]
     */
    public function getTypeRegistration(): ?array
    {
        return $this->typeRegistration;
    }

    /**
     * @param TypeRegistration[] $typeRegistration
     *
     * @return self
     */
    public function setTypeRegistration(array $typeRegistration): Festival
    {
        $this->typeRegistration = $typeRegistration;

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
     * @return self
     */
    public function setDate(DateBetween $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
