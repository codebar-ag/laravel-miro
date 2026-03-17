<?php

namespace CodebarAg\Miro\Dto\Boards;

use Illuminate\Support\Arr;

class BoardDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description,
        public string $type,
        public string $viewLink,
        public ?string $teamId,
        public ?string $projectId,
        public ?string $createdAt,
        public ?string $modifiedAt,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', ''),
            name: Arr::get($data, 'name', ''),
            description: Arr::get($data, 'description'),
            type: Arr::get($data, 'type', 'board'),
            viewLink: Arr::get($data, 'viewLink', ''),
            teamId: Arr::get($data, 'team.id'),
            projectId: Arr::get($data, 'project.id'),
            createdAt: Arr::get($data, 'createdAt'),
            modifiedAt: Arr::get($data, 'modifiedAt'),
        );
    }
}
