<?php

declare(strict_types=1);

namespace CodebarAg\Miro\Responses;

use Saloon\Http\Response;

abstract class MiroResponse
{
    protected function __construct(protected readonly Response $response)
    {
    }

    public function successful(): bool
    {
        return $this->response->successful();
    }

    public function failed(): bool
    {
        return ! $this->successful();
    }

    public function status(): int
    {
        return $this->response->status();
    }

    public function error(): ?string
    {
        if ($this->successful()) {
            return null;
        }

        $message = $this->response->json('message');

        return is_string($message) ? $message : null;
    }

    public function errorCode(): ?string
    {
        if ($this->successful()) {
            return null;
        }

        $code = $this->response->json('code');

        return is_string($code) ? $code : null;
    }
}
