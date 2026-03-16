<?php

namespace CodebarAg\Miro\Requests\StickyNotes;

use CodebarAg\Miro\Dto\StickyNoteDto;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

class CreateStickyNoteRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /** @param array<string, mixed> $data */
    public function __construct(
        protected string $boardId,
        protected array $data
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/sticky_notes";
    }

    /** @return array<string, mixed> */
    protected function defaultBody(): array
    {
        return $this->data;
    }

    public function createDtoFromResponse(Response $response): StickyNoteDto
    {
        return StickyNoteDto::fromResponse((array) $response->json());
    }
}
