<?php

namespace CodebarAg\Miro\Requests\Frames;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateFrameRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /** @param array<string, mixed> $data */
    public function __construct(
        protected string $boardId,
        protected array $data
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/frames";
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
