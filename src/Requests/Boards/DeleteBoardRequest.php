<?php

namespace CodebarAg\Miro\Requests\Boards;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteBoardRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(protected string $boardId)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}";
    }
}
