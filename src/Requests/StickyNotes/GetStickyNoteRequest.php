<?php

namespace CodebarAg\Miro\Requests\StickyNotes;

use CodebarAg\Miro\Dto\StickyNoteDto;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetStickyNoteRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $boardId,
        protected string $itemId
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/sticky_notes/{$this->itemId}";
    }

    public function createDtoFromResponse(Response $response): StickyNoteDto
    {
        return StickyNoteDto::fromResponse((array) $response->json());
    }
}
