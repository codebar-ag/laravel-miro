<?php

namespace CodebarAg\Miro\Requests\Items;

use CodebarAg\Miro\Dto\BoardItemDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetBoardItemsRequest extends Request
{
    protected Method $method = Method::GET;

    /** @param array<string, mixed> $params */
    public function __construct(
        protected string $boardId,
        protected array $params = []
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/items";
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return $this->params;
    }

    /** @return BoardItemDto[] */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array<int, array<string, mixed>> $data */
        $data = is_array($r = $response->json('data')) ? $r : [];

        return array_map(fn (array $item) => BoardItemDto::fromResponse($item), $data);
    }
}
