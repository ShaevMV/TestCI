<?php

namespace App\Ticket\Modules\TypeRegistration\Entity;

use App\Ticket\Entity\EntityInterface;
use Webpatser\Uuid\Uuid;

/**
 * Class TypeRegistration
 *
 * @package App\Ticket\TypeRegistration\Entity
 */
final class TypeRegistration implements EntityInterface
{
    /** @var Uuid */
    private $id;

    /** @var  string */
    private $title;

    /** @var Price */
    private $price;

    /** @var Parameter */
    private $params;

    public static function fromState(array $data): self
    {
        $result = (new self())
            ->setId(Uuid::import($data['id']))
            ->setTitle($data['title']);

        if (isset($data['pivot'])) {
            $price = Price::fromState((int)$data['pivot']['price']);
            $params = Parameter::fromState($data['pivot']['params']);
            $result->setPrice($price)
                ->setParams($params);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return TypeRegistration
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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
     * @return TypeRegistration
     */
    public function setId(Uuid $id): TypeRegistration
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @param Price $price
     *
     * @return TypeRegistration
     */
    public function setPrice(Price $price): TypeRegistration
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return array|null
     */
    public function toArray(): ?array
    {
        $vars = get_object_vars($this);
        $array = [];
        foreach ($vars as $key => $value) {
            $array[ltrim($key)] = $value;
        }

        return $array;
    }

    /**
     * @return Parameter|null
     */
    public function getParams(): ?Parameter
    {
        return $this->params;
    }

    /**
     * @param Parameter $params
     *
     * @return $this
     */
    public function setParams(Parameter $params): self
    {
        $this->params = $params;

        return $this;
    }
}