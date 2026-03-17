<?php

namespace CodebarAg\Miro\Dto\Boards;

class CreateBoardDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $teamId = null,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'teamId' => $this->teamId,
        ], fn ($v) => $v !== null);
    }
}
