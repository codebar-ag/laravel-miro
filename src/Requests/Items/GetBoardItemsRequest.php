<?php

namespace CodebarAg\Miro\Requests\Items;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBoardItemsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $boardId,
        protected array $params = []
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/items";
    }

    protected function defaultQuery(): array
    {
        return $this->params;
    }
}
