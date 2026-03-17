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
        $id = Arr::get($data, 'id', '');
        $name = Arr::get($data, 'name', '');
        $description = Arr::get($data, 'description');
        $type = Arr::get($data, 'type', 'board');
        $viewLink = Arr::get($data, 'viewLink', '');
        $teamId = Arr::get($data, 'team.id');
        $projectId = Arr::get($data, 'project.id');
        $createdAt = Arr::get($data, 'createdAt');
        $modifiedAt = Arr::get($data, 'modifiedAt');

        return new self(
            id: is_string($id) ? $id : '',
            name: is_string($name) ? $name : '',
            description: is_string($description) ? $description : null,
            type: is_string($type) ? $type : 'board',
            viewLink: is_string($viewLink) ? $viewLink : '',
            teamId: is_string($teamId) ? $teamId : null,
            projectId: is_string($projectId) ? $projectId : null,
            createdAt: is_string($createdAt) ? $createdAt : null,
            modifiedAt: is_string($modifiedAt) ? $modifiedAt : null,
        );
    }
}
