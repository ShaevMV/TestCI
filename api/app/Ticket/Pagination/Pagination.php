<?php

declare(strict_types=1);

namespace App\Ticket\Pagination;

use InvalidArgumentException;

/**
 * Class Pagination
 *
 * Пагинация
 *
 * @package App\Ticket\Pagination
 */
final class Pagination
{
    /**
     * Количество объектов на странице
     *
     * @const int
     */
    private const DEFAULT_LIMIT = 15;

    /**
     * Текущая страница
     *
     * @var int
     */
    private int $page;

    /**
     * Лимит записей
     *
     * @var int
     */
    private int $limit;

    /**
     * Pagination constructor.
     *
     * @param int $page
     * @param int $limit
     */
    public function __construct(int $page, int $limit = self::DEFAULT_LIMIT)
    {
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Вывести объект пагинации
     *
     * @param int|null $page
     * @param int|null $limit
     *
     * @return Pagination|null
     */
    public static function getInstance(?int $page, ?int $limit): ?Pagination
    {
        if ($page !== null) {
            self::isPageValid($page);
            self::isLimitValid($limit ?? self::DEFAULT_LIMIT);

            return new self($page, $limit ?? self::DEFAULT_LIMIT);
        }

        return null;
    }

    /**
     * Проверить верность значения у страницы
     *
     * @param int $page
     *
     * @return void
     */
    private static function isPageValid(int $page): void
    {
        if ($page <= 0) {
            throw new InvalidArgumentException('Invalid page given');
        }
    }

    /**
     * Проверить верность у значения лимита
     *
     * @param int $limit
     *
     * @example InvalidArgumentException
     *
     * @return void
     */
    private static function isLimitValid(int $limit): void
    {
        if ($limit <= 0) {
            throw new InvalidArgumentException('Invalid limit given');
        }
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return Pagination
     */
    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return Pagination
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }
}
