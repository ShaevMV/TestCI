<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\Auth\Entity\AccessToken;
use App\Ticket\Modules\Auth\Model\OauthClientsModel;
use App\Ticket\Repository\BaseRepository;

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
     */
    public function getApiAccessToken(): AccessToken
    {
        $data = $this->model
            ->where('password_client', '=', true)
            ->first();

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
