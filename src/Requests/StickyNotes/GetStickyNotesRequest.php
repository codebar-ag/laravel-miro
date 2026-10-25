<?php

namespace CodebarAg\Miro\Requests\StickyNotes;

use CodebarAg\Miro\Support\PathSegment;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetStickyNotesRequest extends Request
{
    protected Method $method = Method::GET;

    /** @param array<string, mixed> $params */
    public function __construct(
        protected string $boardId,
        protected array $params = []
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/v2/boards/'.PathSegment::encode($this->boardId).'/items';
    }

    /** @return array<string, mixed> */
    protected function defaultQuery(): array
    {
        return array_merge(['type' => 'sticky_note'], $this->params);
    }
}
