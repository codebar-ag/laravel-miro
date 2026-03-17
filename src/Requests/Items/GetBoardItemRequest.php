<?php

namespace CodebarAg\Miro\Requests\Items;

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

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

    public function createDtoFromResponse(Response $response): BoardItemDto
    {
        return BoardItemDto::fromResponse((array) $response->json());
    }
}
