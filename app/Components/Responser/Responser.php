<?php

namespace App\Components\Responser;


use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class Responser
{
    private int $httpCode = SymfonyResponse::HTTP_OK;

    private int $errorCode = 0;
    private array $errors = [];

    private mixed $data = [];

    public function success(): JsonResponse
    {
        if ($this->httpCode < 200 || $this->httpCode > 299) {
            $this->httpCode = SymfonyResponse::HTTP_OK;
        }

        return $this->makeResponse(['data' => $this->data]);
    }

    public function error(string $message): JsonResponse
    {
        if ($this->httpCode < 400 || $this->httpCode > 599) {
            $this->httpCode = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $this->makeResponse([
            'http_code' => $this->httpCode,
            'error_code' => $this->errorCode,
            'message' => $message,
            'data' => $this->data,
            'errors' => $this->errors,
        ]);
    }

    /**
     * @throws InvalidArgumentException In case when HTTP code is less than 100 or greater than 599
     * @param int $httpCode
     * @return $this
     */
    public function setHttpCode(int $httpCode): Responser
    {
        if ($httpCode < 100 || $httpCode > 599) {
            throw new InvalidArgumentException('HTTP code must be less than 599 and greater than 99', 500);
        }

        $this->httpCode = $httpCode;
        return $this;
    }

    public function setErrorCode(int $errorCode): Responser
    {
        $this->errorCode = $errorCode;
        return $this;
    }

    public function setErrors(array $errors): Responser
    {
        $this->errors = $errors;
        return $this;
    }

    public function setData(mixed $data): Responser
    {
        $this->data = $data;
        return $this;
    }

    private function makeResponse(mixed $data): JsonResponse
    {
        return response()->json($data, $this->httpCode);
    }
}
