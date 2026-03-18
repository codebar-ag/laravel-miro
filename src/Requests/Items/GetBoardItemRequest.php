<?php

namespace CodebarAg\Miro\Requests\Items;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBoardItemRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $boardId,
        protected string $itemId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/items/{$this->itemId}";
    }
}
