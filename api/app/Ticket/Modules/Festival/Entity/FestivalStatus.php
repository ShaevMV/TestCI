<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Festival\Entity;

use App\Ticket\Entity\EntityDataInterface;
use InvalidArgumentException;

/**
 * Class FestivalStatus
 *
 * Статус у фестиваля
 *
 * @package App\Ticket\Festival\Entity
 */
final class FestivalStatus implements EntityDataInterface
{
    /**
     * Идентификатор статуса черновик
     *
     * @const int
     */
    public const STATE_DRAFT_ID = 1;

    /**
     * Идентификатор статуса запущенного фестиваля
     *
     * @const int
     */
    public const STATE_PUBLISHED_ID = 2;

    /**
     * Названия статуса черновик
     *
     * @const string
     */
    public const STATE_DRAFT = 'draft';

    /**
     * Названия статуса запущенного фестиваля
     *
     * @const string
     */
    public const STATE_PUBLISHED = 'published';

    /**
     * Список статусов
     *
     * @var array
     */
    public const STATE_LIST = [
        self::STATE_DRAFT_ID => self::STATE_DRAFT,
        self::STATE_PUBLISHED_ID => self::STATE_PUBLISHED,
    ];

    /**
     * Идентификатор статуса
     *
     * @var int|null
     */
    private ?int $id;

    /**
     * Названия статуса
     *
     * @var string|null
     */
    private ?string $name;

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
     * Создать объект по ID статуса
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

        return new self((int)$state, $status);
    }

    /**
     * @return string|null
     */
    public function __toString(): ?string
    {
        return (string)$this->id;
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
