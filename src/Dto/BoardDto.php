<?php

namespace CodebarAg\Miro\Dto;

use Illuminate\Support\Arr;

class BoardDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $description,
        public readonly string $type,
        public readonly string $viewLink,
        public readonly ?string $teamId,
        public readonly ?string $projectId,
        public readonly ?string $createdAt,
        public readonly ?string $modifiedAt,
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: is_string($v = Arr::get($data, 'id', '')) ? $v : '',
            name: is_string($v = Arr::get($data, 'name', '')) ? $v : '',
            description: is_string($v = Arr::get($data, 'description')) ? $v : null,
            type: is_string($v = Arr::get($data, 'type', 'board')) ? $v : '',
            viewLink: is_string($v = Arr::get($data, 'viewLink', '')) ? $v : '',
            teamId: is_string($v = Arr::get($data, 'team.id')) ? $v : null,
            projectId: is_string($v = Arr::get($data, 'project.id')) ? $v : null,
            createdAt: is_string($v = Arr::get($data, 'createdAt')) ? $v : null,
            modifiedAt: is_string($v = Arr::get($data, 'modifiedAt')) ? $v : null,
        );
    }
}
