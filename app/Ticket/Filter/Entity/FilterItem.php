<?php

namespace App\Ticket\Filter\Entity;

use InvalidArgumentException;

/**
 * Класс для создания
 *
 * Class FilterItem
 *
 * @package App\Ticket\Filter\Entity
 */
final class FilterItem
{
    /** @const string Разделитель страки */
    private const DELIMITER = '.';

    /** @var string|array Значения для фильтра */
    private $value;

    /** @var string Поле фильтра */
    private $field;

    /** @var string Таблица в которой осуществляеться поиск */
    private $table;

    /** @var string Тип фильтрации */
    private $type;

    /** @var string */
    private $operation = '=';

    /**
     * @return string|array
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
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
     * Проверка наличие в страке разделителя
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