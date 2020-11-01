<?php

namespace App\Ticket\Modules\PromoCode\Repository;

use App\Ticket\Entity\EntityInterface;
use App\Ticket\Modules\PromoCode\Entity\PromoCode;
use App\Ticket\Modules\PromoCode\Model\PromoCodeModel;
use App\Ticket\Repository\BaseRepository;

class PromoCodeRepository extends BaseRepository
{
    /**
     * PromoCodeRepository constructor.
     *
     * @param PromoCodeModel $promoCodeModel
     */
    public function __construct(PromoCodeModel $promoCodeModel)
    {
        $this->model = $promoCodeModel;
    }

    /**
     * Выдать сущность
     *
     * @param array $data
     *
     * @return EntityInterface
     */
    protected function build(array $data): EntityInterface
    {
        return PromoCode::fromState($data);
    }
}
