<?php

namespace CodebarAg\Miro\Dto\Boards;

class UpdateBoardDto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $description = null,
    ) {}

    /** @return array<string, string> */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
        ], fn ($v) => $v !== null);
    }
}
