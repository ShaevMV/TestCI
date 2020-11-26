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

    /** @var string  Идентификатор клиента */
    protected string $clientId;

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
     * @param string $clientId
     * @return AccessToken
     */
    public function setClientId(string $clientId): AccessToken
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }
}
