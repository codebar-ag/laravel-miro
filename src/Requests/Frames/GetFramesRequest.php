<?php

namespace CodebarAg\Miro\Requests\Frames;

use CodebarAg\Miro\Dto\Frames\FrameDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetFramesRequest extends Request
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
        return "/v2/boards/{$this->boardId}/frames";
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return $this->params;
    }

    /** @return FrameDto[] */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array<int, array<string, mixed>> $data */
        $data = is_array($r = $response->json('data')) ? $r : [];

        return array_map(fn (array $item) => FrameDto::fromResponse($item), $data);
    }
}
