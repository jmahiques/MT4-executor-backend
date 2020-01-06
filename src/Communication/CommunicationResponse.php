<?php

namespace App\Communication;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class CommunicationResponse
{
    private static function createResponse(int $status, ?string $content): ResponseInterface
    {
        return $content
            ?  new Response($status, ['Content-Type' => 'text/plain'], $content)
            : new Response($status);
    }

    public static function OK(?string $content = null): ResponseInterface
    {
        return self::createResponse(200, $content);
    }

    public static function NOT_FOUND(): ResponseInterface
    {
        return self::createResponse(404, null);
    }

    public static function INVALID_REQUEST(?string $content = null): ResponseInterface
    {
        return self::createResponse(406, $content);
    }

    public static function STOP_REACHED()
    {
        return self::OK('STOP_REACHED');
    }

    public static function PARTIAL_STOP_REACHED()
    {
        return self::OK('PARTIAL_STOP_REACHED');
    }

    public static function PROFIT_REACHED()
    {
        return self::OK('PROFIT_REACHED');
    }

    public static function PARTIAL_PROFIT_REACHED()
    {
        return self::OK('PARTIAL_PROFIT_REACHED');
    }
}
