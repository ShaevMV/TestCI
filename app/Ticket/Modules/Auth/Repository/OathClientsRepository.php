<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\Auth\Entity\AccessToken;
use App\Ticket\Modules\Auth\Model\OauthClientsModel;
use App\Ticket\Repository\BaseRepository;
use RuntimeException;

final class OathClientsRepository extends BaseRepository
{
    /**
     * OathClientsRepository constructor.
     * @param OauthClientsModel $clientsModel
     */
    public function __construct(OauthClientsModel $clientsModel)
    {
        $this->model = $clientsModel;
    }

    /**
     * @return AccessToken
     * @throws RuntimeException
     */
    public function getApiAccessToken(): AccessToken
    {
        $data = $this->model
            ->where('password_client', '=', true)
            ->first();

        if (count($data) === 0) {
            throw new RuntimeException("Ключи в базе не записаны");
        }

        return (new AccessToken())
            ->setClientId($data['id'])
            ->setPasswordKey($data['secret']);
    }

    protected function build(array $data): EntityInterface
    {
        return (new AccessToken())
            ->setPasswordKey($data['secret']);
    }
}
