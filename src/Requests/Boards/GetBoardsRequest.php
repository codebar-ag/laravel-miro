<?php

namespace CodebarAg\Miro\Requests\Boards;

use CodebarAg\Miro\Dto\Boards\BoardDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetBoardsRequest extends Request
{
    protected Method $method = Method::GET;

    /** @param array<string, mixed> $params */
    public function __construct(protected array $params = []) {}

    public function resolveEndpoint(): string
    {
        return '/v2/boards';
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return $this->params;
    }

    /** @return BoardDto[] */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array<int, array<string, mixed>> $data */
        $data = is_array($r = $response->json('data')) ? $r : [];

        return array_map(fn (array $board) => BoardDto::fromResponse($board), $data);
    }
}
