<?php

namespace CodebarAg\Miro\Requests\Frames;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteFrameRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $boardId,
        protected string $itemId
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/frames/{$this->itemId}";
    }
}
