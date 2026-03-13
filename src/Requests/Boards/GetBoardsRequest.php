<?php

namespace CodebarAg\Miro\Requests\Boards;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBoardsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected array $params = []) {}

    public function resolveEndpoint(): string
    {
        return '/v2/boards';
    }

    protected function defaultQuery(): array
    {
        return $this->params;
    }
}
