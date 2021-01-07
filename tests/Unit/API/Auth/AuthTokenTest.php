<?php

namespace Tests\Unit\API\Auth;

use App\Ticket\Modules\Auth\Dto\EnvDto;
use App\Ticket\Modules\Auth\Entity\AccessToken;
use App\Ticket\Modules\Auth\Helpers\EnvHelper;
use App\Ticket\Modules\Auth\Repository\OathClientsRepository;
use App\Ticket\Modules\Auth\Service\WriteInEnv;
use App\Ticket\Modules\Auth\Service\WriteTokenInEnvService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

/**
 * Class AuthTokenTest
 *
 * @package Tests\Unit\API\Auth
 *
 *  + Получить внешний ключ
 *  + Изменить запись в env
 *  + Записать в env файл реальный ключ
 */
class AuthTokenTest extends TestCase
{
    private OathClientsRepository $oathClientsRepository;
    private WriteInEnv $writeInEnv;
    private WriteTokenInEnvService $writeTokenInEnvService;

    /**
     * Получить внешний ключ
     */
    public function testGetToken(): void
    {
        $this->assertInstanceOf(get_class(new AccessToken()), $this->oathClientsRepository->getApiAccessToken());
    }

    /**
     * Изменить запись в env
     */
    public function testEditValue(): void
    {
        $this->assertTrue($this->writeInEnv->editValue([
            (new EnvDto())
                ->setKey(EnvHelper::KEY_API)
                ->setValue('0oWJvtgCY3E3JkEvu4DruF6VYUOuiaBlXOPkHsjn')
        ], WriteInEnv::PATH_FRONTEND));
    }

    /**
     * Записать в env файл реальный ключ
     */
    public function testWriteRealToken(): void
    {
        $this->assertTrue($this->writeTokenInEnvService->init());
    }

    /**
     * @throws BindingResolutionException
     */
    protected function setUp(): void
    {
        parent::setUp();
        /** @var OathClientsRepository $oathClientsRepository */
        $this->oathClientsRepository = $this->app->make(OathClientsRepository::class);
        $this->writeInEnv = $this->app->make(WriteInEnv::class);
        $this->writeTokenInEnvService = $this->app->make(WriteTokenInEnvService::class);
    }
}
