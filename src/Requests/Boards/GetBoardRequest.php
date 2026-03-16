<?php

namespace CodebarAg\Miro\Requests\Boards;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetBoardRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $boardId) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}";
    }
}
