<?php

namespace CodebarAg\Miro\Dto\StickyNotes;

class GetStickyNotesDto
{
    public function __construct(
        public readonly ?int $limit = null,
        public readonly ?string $cursor = null,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'limit' => $this->limit,
            'cursor' => $this->cursor,
        ], fn ($v) => $v !== null);
    }
}
