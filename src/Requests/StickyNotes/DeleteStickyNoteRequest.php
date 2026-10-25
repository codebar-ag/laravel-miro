<?php

namespace CodebarAg\Miro\Requests\StickyNotes;

use CodebarAg\Miro\Support\PathSegment;
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
        return '/v2/boards/'.PathSegment::encode($this->boardId).'/sticky_notes/'.PathSegment::encode($this->itemId);
    }
}
