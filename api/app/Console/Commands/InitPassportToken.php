<?php

namespace App\Console\Commands;

use App\Ticket\Modules\Auth\Service\WriteTokenInEnvService;
use Illuminate\Console\Command;

class InitPassportToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Запись токина passport авторизации в .env файл';

    private WriteTokenInEnvService $writeTokenInEnvService;

    /**
     * Create a new command instance.
     *
     * @param WriteTokenInEnvService $writeTokenInEnvService
     */
    public function __construct(WriteTokenInEnvService $writeTokenInEnvService)
    {
        parent::__construct();

        $this->writeTokenInEnvService = $writeTokenInEnvService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->writeTokenInEnvService->init();

        return 0;
    }
}
