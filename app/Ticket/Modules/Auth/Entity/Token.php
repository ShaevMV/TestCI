<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Entity;

use App\Ticket\Entity\AbstractionEntity;

/**
 * Class Token
 *
 * Сущность токена
 *
 * @package App\Ticket\Modules\Auth\Entity
 */
final class Token extends AbstractionEntity
{
    /** @var string токен */
    protected string $access_token;

    /** @var string тип токена */
    protected string $token_type = 'bearer';

    /** @var int время жизни токена */
    protected int $expires_in;

    public static function fromState(array $data): self
    {
        return (new self())
            ->setAccessToken($data['access_token'])
            ->setExpiresIn($data['token_type'])
            ->setExpiresIn($data['expires_in']);
    }

    /**
     * @param string $access_token
     *
     * @return self
     */
    public function setAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->access_token;
    }

    /**
     * @param string $token_type
     *
     * @return self
     */
    public function setTokenType(string $token_type): self
    {
        $this->token_type = $token_type;

        return $this;
    }

    /**
     * @param int $expires_in
     *
     * @return self
     */
    public function setExpiresIn(int $expires_in): self
    {
        $this->expires_in = $expires_in;

        return $this;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->token_type;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expires_in;
    }
}
