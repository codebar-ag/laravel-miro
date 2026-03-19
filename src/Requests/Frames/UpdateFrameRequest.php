<?php

namespace CodebarAg\Miro\Requests\Frames;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateFrameRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    /** @param array<string, mixed> $data */
    public function __construct(
        protected string $boardId,
        protected string $itemId,
        protected array $data
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/frames/{$this->itemId}";
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
