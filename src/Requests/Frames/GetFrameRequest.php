<?php

namespace CodebarAg\Miro\Requests\Frames;

use CodebarAg\Miro\Dto\Frames\FrameDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetFrameRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $boardId,
        protected string $itemId
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/frames/{$this->itemId}";
    }

    public function createDtoFromResponse(Response $response): FrameDto
    {
        return FrameDto::fromResponse((array) $response->json());
    }
}
