<?php

namespace App\Components\Responser\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Facade;
use App\Components\Responser\Responser as ResponserComponent;

/**
 * @method static ResponserComponent setData(mixed $data)
 * @method static ResponserComponent setErrors(array $errors)
 * @method static ResponserComponent setErrorCode(int $errorCode)
 * @method static ResponserComponent setHttpCode(int $httpCode)
 * @method static ResponserComponent wrap(bool $wrap = true)
 * @method static JsonResponse error(string $message)
 * @method static JsonResponse success()
 */
class Responser extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'responser';
    }
}
