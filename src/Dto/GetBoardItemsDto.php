<?php

namespace CodebarAg\Miro\Dto;

class GetBoardItemsDto
{
    public function __construct(
        public readonly ?int $limit = null,
        public readonly ?string $cursor = null,
        public readonly ?string $type = null,
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
