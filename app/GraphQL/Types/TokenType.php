<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TokenType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Token',
        'description' => 'Token for auth user',
    ];

    public function fields(): array
    {
        return [
            'access_token' => [
                'type' => Type::string(),
                'description' => 'Token for auth user',
            ],
            'token_type' => [
                'type' => Type::string(),
                'description' => 'Type token',
            ],
            'expires_in' => [
                'type' => Type::int(),
                'description' => 'Time live token',
            ],
        ];
    }
}
