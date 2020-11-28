<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Service;

use App\Ticket\Modules\Auth\Dto\EnvDto;
use InvalidArgumentException;
use RuntimeException;

final class WriteInEnv
{
    /**
     * Изменить значения в файле env
     *
     * @param EnvDto[] $envsDto
     * @return bool
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function editValue(array $envsDto): bool
    {
        $path = base_path('.env');

        if (!$this->validateEnv($path)) {
            throw new RuntimeException("Файл .env отсутствует");
        }

        foreach ($envsDto as $envDto) {
            if (!$this->write($path, $envDto->getKey(), $envDto->getValue())) {
                throw new RuntimeException("Не возможно записать {$envDto->getKey()}={$envDto->getValue()}");
            }
        }

        return true;
    }

    /**
     * Проверка наличие файла
     *
     * @param string $path
     * @return bool
     */
    private function validateEnv(string $path): bool
    {
        return file_exists($path);
    }

    /**
     * Запись пары ключ значение
     *
     * @param string $path
     * @param string $key
     * @param string|null $value
     * @return bool
     */
    private function write(string $path, string $key, ?string $value): bool
    {
        $filePath = file_get_contents($path);

        if (false !== $filePath && $this->isIsset($key, $filePath)) {
            return file_put_contents($path, str_replace(
                "{$key}=" . env($key) ?? null,
                "{$key}={$value}",
                $filePath
            )) !== false;
        } else {
            return file_put_contents($path, "{$key}={$value}", FILE_APPEND) !== false;
        }
    }

    /**
     * Проверка на наличие ключа в env файле
     *
     * @param string $key
     * @param string $fileEnv
     * @return bool
     */
    private function isIsset(string $key, string $fileEnv): bool
    {
        return strripos($fileEnv, $key) !== false;
    }
}
