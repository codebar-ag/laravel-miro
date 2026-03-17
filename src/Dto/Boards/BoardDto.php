<?php

namespace CodebarAg\Miro\Dto\Boards;

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
    ) {
    }

    /**
     * @param  array{id: string, name: string, description?: string|null, type?: string, viewLink?: string, team?: array{id?: string|null}, project?: array{id?: string|null}, createdAt?: string|null, modifiedAt?: string|null}  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'] ?? null,
            type: $data['type'] ?? 'board',
            viewLink: $data['viewLink'] ?? '',
            teamId: $data['team']['id'] ?? null,
            projectId: $data['project']['id'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            modifiedAt: $data['modifiedAt'] ?? null,
        );
    }
}
