<?php

namespace CodebarAg\Miro\Requests\StickyNotes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteStickyNoteRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        protected string $boardId,
        protected string $itemId
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/sticky_notes/{$this->itemId}";
    }
}
