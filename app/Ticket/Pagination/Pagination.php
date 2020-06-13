<?php

namespace App\Ticket\Pagination;

use InvalidArgumentException;

/**
 * Class Pagination
 *
 * @package App\Ticket\Pagination
 */
final class Pagination
{
    /** @const int Количество объектов на странице */
    const DEFAULT_LIMIT = 15;

    /** @var int Текущая страница */
    private $page;

    /** @var int Лимит записей */
    private $limit;

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
     */
    private static function isPageValid(int $page)
    {
        if ($page <= 0) {
            throw new InvalidArgumentException('Invalid page given');
        }
    }

    /**
     * Проверить верность у занчения лимита
     *
     * @param int $limit
     *
     * @example InvalidArgumentException
     */
    private static function isLimitValid(int $limit)
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