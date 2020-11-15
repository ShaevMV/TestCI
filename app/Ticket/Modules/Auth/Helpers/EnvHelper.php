<?php

declare(strict_types=1);

namespace App\Ticket\Modules\Auth\Helpers;

class EnvHelper
{
    /** @var string Ключ клиента */
    public const KEY_API = "MIX_PUSHER_APP_KEY_API";

    /** @var string Идентификатор клиента */
    public const KEY_CLIENT_ID = "MIX_CLIENT_ID";

    public const ARRAY_KEYS = [
        'passwordKey' => self::KEY_API,
        'clientId' => self::KEY_CLIENT_ID,
    ];
}
