<?php

declare(strict_types=1);

namespace App\Ticket\Response\ForAdmin;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Pagination\Pagination;
use RuntimeException;

/**
 * Класс для вывода ответа из массива entity в виде json одного типа
 *
 * Class ResponseForJson
 *
 * @package App\Ticket\Response\TableList
 */
class ResponseList
{
    /**
     * Вывести ответ в виде json
     *
     * @param EntityInterface[] $entityList
     * @param Pagination|null $pagination
     *
     * @throw RuntimeException
     *
     * @return string
     */
    public function getJson(array $entityList, ?Pagination $pagination = null): string
    {
        $result = [
            'items' => [
                'columns' => $this->getColumns($entityList),
                'rows' => $this->getRows($entityList),
            ],
            'pagination' => $this->getDataPagination($pagination),
        ];

        $jsonResult = json_encode($result);
        if (!$jsonResult) {
            throw new RuntimeException('Response list not correct');
        }

        return $jsonResult;
    }

    /**
     * Вывести массив колонок
     *
     * @param EntityInterface[] $entityList
     *
     * @return array
     */
    private function getColumns(array $entityList): array
    {
        if (0 === count($entityList)) {
            return [];
        }

        $itemEntity = end($entityList);

        return $itemEntity->getColumns();
    }

    /**
     * Вывести массив записей
     *
     * @param EntityInterface[] $entityList
     *
     * @return array
     */
    private function getRows(array $entityList): array
    {
        if (0 === count($entityList)) {
            return [];
        }

        $result = [];
        foreach ($entityList as $entity) {
            $result[] = $entity->toJson();
        }

        return $result;
    }

    private function getDataPagination(?Pagination $pagination): array
    {
        if (null === $pagination) {
            return [];
        }

        return [
            'page' => $pagination->getPage(),
            'limit' => $pagination->getLimit(),
            'total' => $pagination->getTotal(),
        ];
    }
}
