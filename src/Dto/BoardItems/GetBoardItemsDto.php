<?php

namespace CodebarAg\Miro\Dto\BoardItems;

class GetBoardItemsDto
{
    public function __construct(
        public ?int $limit = null,
        public ?string $cursor = null,
        public ?string $type = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'limit' => $this->limit,
            'cursor' => $this->cursor,
            'type' => $this->type,
        ], fn ($v) => $v !== null);
    }
}
