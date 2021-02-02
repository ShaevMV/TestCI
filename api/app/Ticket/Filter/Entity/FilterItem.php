<?php

declare(strict_types=1);

namespace App\Ticket\Filter\Entity;

use InvalidArgumentException;

/**
 * Class FilterItem
 *
 * Класс для сущности фильтра
 *
 * @package App\Ticket\Filter\Entity
 */
final class FilterItem
{
    /**
     * Разделитель старки между названием таблицы и полем
     *
     * @const string
     */
    private const DELIMITER = '.';

    /**
     * Значения для фильтра
     *
     * @var string|array
     */
    private $value;

    /**
     * Поле фильтрации
     *
     * @var string
     */
    private string $field;

    /**
     * Таблица в которой осуществляется поиск
     *
     * @var string
     */
    private string $table;

    /**
     * Тип фильтрации
     *
     * @var string
     */
    private string $type;

    /**
     * Оператор для фильтрации
     *
     * @var string
     */
    private string $operation = '=';

    /**
     * @return string|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|array $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Получения данных поля и имени таблицы
     *
     * @param string $field
     *
     * @return FilterItem
     */
    public function setFieldAndTable(string $field): self
    {
        if ($arrFieldAndTable = self::getDelimiter($field)) {
            list($this->table, $this->field) = $arrFieldAndTable;
        } else {
            throw new InvalidArgumentException("{$field} not found DELIMITER '" . self::DELIMITER . "'");
        }

        return $this;
    }

    /**
     * Проверка наличие в старке разделителя
     *
     * @param string $str
     *
     * @return array|bool
     */
    private static function getDelimiter(string $str)
    {
        return strripos($str, self::DELIMITER) !== false ? explode(self::DELIMITER, $str) : false;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param string $field
     *
     * @return $this
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $operation
     *
     * @return $this
     */
    public function setOperation(string $operation = '='): self
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperation(): string
    {
        return $this->operation;
    }
}
