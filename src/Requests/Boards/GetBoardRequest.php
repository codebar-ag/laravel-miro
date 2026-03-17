<?php

namespace CodebarAg\Miro\Requests\Boards;

use CodebarAg\Miro\Dto\Boards\BoardDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetBoardRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected string $boardId) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}";
    }

    public function createDtoFromResponse(Response $response): BoardDto
    {
        return BoardDto::fromResponse((array) $response->json());
    }
}
