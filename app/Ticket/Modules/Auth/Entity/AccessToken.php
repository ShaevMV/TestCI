<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Entity;

use App\Ticket\Entity\AbstractionEntity;

/**
 * Class AccessToken
 *
 * @package App\Ticket\Modules\Auth\Entity
 */
final class AccessToken extends AbstractionEntity
{
    /** @var string  Ключ клиента */
    protected string $passwordKey;

    /** @var int  Идентификатор клиента */
    protected int $clientId;

    /**
     * @param string $passwordKey
     * @return AccessToken
     */
    public function setPasswordKey(string $passwordKey): AccessToken
    {
        $this->passwordKey = $passwordKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordKey(): string
    {
        return $this->passwordKey;
    }

    public static function fromState(array $data)
    {
        // TODO: Implement fromState() method.
    }

    /**
     * @param int $clientId
     * @return AccessToken
     */
    public function setClientId(int $clientId): AccessToken
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }
}
