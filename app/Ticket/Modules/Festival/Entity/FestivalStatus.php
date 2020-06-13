<?php

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Entity\EntityDataInterface;
use InvalidArgumentException;

/**
 * Статус у фестиваля
 *
 * Class FestivalStatus
 *
 * @package App\Ticket\Festival\Entity
 */
final class FestivalStatus implements EntityDataInterface
{
    /** @const ID */
    const STATE_DRAFT_ID = 1;
    const STATE_PUBLISHED_ID = 2;

    /** @const Name */
    const STATE_DRAFT = 'draft';
    const STATE_PUBLISHED = 'published';

    /** @var array Список статусов */
    public const STATE_LIST = [
        self::STATE_DRAFT_ID => self::STATE_DRAFT,
        self::STATE_PUBLISHED_ID => self::STATE_PUBLISHED,
    ];

    /** @var int|null */
    private $id = null;

    /** @var string|null */
    private $name = null;

    /**
     * FestivalStatus constructor.
     *
     * @param int $id
     * @param string $name
     */
    private function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Создать объект по ID сатуса
     *
     * @param int $statusId
     *
     * @return FestivalStatus
     *
     * @throws InvalidArgumentException
     */
    public static function fromInt(int $statusId)
    {
        if (!self::ensureIsValidId($statusId)) {
            throw new InvalidArgumentException('Invalid status id given');
        }

        return new self($statusId, self::STATE_LIST[$statusId]);
    }

    /**
     * Создать объект из название
     *
     * @param string $status
     *
     * @return FestivalStatus
     *
     * @throws InvalidArgumentException
     */
    public static function fromString(string $status)
    {
        if (!self::ensureIsValidName($status)) {
            throw new InvalidArgumentException('Invalid state given!');
        }

        $state = array_search($status, self::STATE_LIST);
        return new self($state, $status);
    }

    public function __toString(): ?string
    {
        return $this->id;
    }

    /**
     * Активировать
     *
     * @return void
     */
    public function active(): void
    {
        $this->id = self::STATE_PUBLISHED_ID;
        $this->name = self::STATE_PUBLISHED;
    }

    /**
     * Снять активацию
     */
    public function cancel(): void
    {
        $this->id = self::STATE_DRAFT_ID;
        $this->name = self::STATE_DRAFT;
    }


    /**
     * Проверка валидности по ID
     *
     * @param int $status
     *
     * @return bool
     */
    private static function ensureIsValidId(int $status): bool
    {
        return in_array($status, array_keys(self::STATE_LIST), true);
    }

    /**
     * Проверка валидности по названию статуса
     *
     * @param string $status
     *
     * @return bool
     */
    private static function ensureIsValidName(string $status): bool
    {
        return in_array($status, self::STATE_LIST, true);
    }
}