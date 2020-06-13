<?php

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\TypeRegistration\Entity\TypeRegistration;
use Webpatser\Uuid\Uuid;

/**
 * Class Festival
 *
 * @package App\Ticket\Festival\Entity
 */
final class Festival implements EntityInterface
{
    /** @var Uuid Индификатор */
    private $id;

    /** @var FestivalStatus Статус */
    private $status;

    /** @var string Заголовок */
    private $title;

    /** @var FestivalDate Дата начала */
    private $date_start;

    /** @var FestivalDate Дата окончания */
    private $date_end;

    /** @var TypeRegistration[]|null */
    private $typeRegistration;

    /**
     * Получить фестиваль из данных БД
     *
     * @param array $state
     *
     * @return Festival
     */
    public static function fromState(array $state): Festival
    {
        return (new self())
            ->setId(Uuid::import($state['id']))
            ->setTitle($state['title'])
            ->setDateStart(FestivalDate::getInstance($state['date_start']))
            ->setDateEnd(FestivalDate::getInstance($state['date_end']))
            ->setStatus(FestivalStatus::fromInt($state['status']));
    }

    /**
     * Вывести сущность в виде массива
     *
     * @return array
     */
    public function toArray(): array
    {
        $vars = get_object_vars($this);
        $array = [];
        foreach ($vars as $key => $value) {
            if (!is_array($value)) {
                $array[ltrim($key)] = $value;
            }
        }

        return $array;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return FestivalDate
     */
    public function getDateEnd(): FestivalDate
    {
        return $this->date_end;
    }

    /**
     * @return FestivalDate
     */
    public function getDateStart(): FestivalDate
    {
        return $this->date_start;
    }

    /**
     * @return FestivalStatus|null
     */
    public function getStatus(): ?FestivalStatus
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
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
     * @param FestivalStatus $status
     *
     * @return Festival
     */
    public function setStatus(FestivalStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param FestivalDate $date_end
     *
     * @return Festival
     */
    public function setDateEnd(FestivalDate $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * @param FestivalDate $date_start
     *
     * @return Festival
     */
    public function setDateStart(FestivalDate $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    /**
     * @param string $title
     *
     * @return Festival
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param TypeRegistration[] typeRegistration
     *
     * @return Festival
     */
    public function setTypeRegistration(array $typeRegistration): Festival
    {
        $this->typeRegistration = $typeRegistration;

        return $this;
    }

    /**
     * @return TypeRegistration[]
     */
    public function getTypeRegistration(): ?array
    {
        return $this->typeRegistration;
    }
}