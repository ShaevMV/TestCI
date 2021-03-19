<?php

declare(strict_types=1);

namespace App\Ticket\Modules\User\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\User\Entity\UserEntity;
use App\Ticket\Repository\BaseRepository;
use App\User;

class UserRepository extends BaseRepository
{
    /**
     * @var User
     */
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    protected function build(array $data): EntityInterface
    {
        return UserEntity::fromState($data);
    }
}
