<?php

namespace CodebarAg\Miro\Requests\Frames;

use CodebarAg\Miro\Support\PathSegment;
use Saloon\Enums\Method;
use Saloon\Http\Request;

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
        return '/v2/boards/'.PathSegment::encode($this->boardId).'/frames';
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return $this->params;
    }
}
