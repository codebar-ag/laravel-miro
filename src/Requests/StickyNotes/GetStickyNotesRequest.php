<?php

namespace CodebarAg\Miro\Requests\StickyNotes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetStickyNotesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $boardId,
        protected array $params = []
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v2/boards/{$this->boardId}/items";
    }

    protected function defaultQuery(): array
    {
        return array_merge(['type' => 'sticky_note'], $this->params);
    }
}
