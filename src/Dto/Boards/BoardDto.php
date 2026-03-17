<?php

namespace CodebarAg\Miro\Dto\Boards;

use WendellAdriel\ValidatedDTO\ValidatedDTO;

class BoardDto extends ValidatedDTO
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

    /** @return array<string, mixed> */
    protected function defaults(): array
    {
        return [
            'description' => null,
            'teamId' => null,
            'projectId' => null,
            'createdAt' => null,
            'modifiedAt' => null,
        ];
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'description' => 'string',
            'type' => 'string',
            'viewLink' => 'string',
            'teamId' => 'string',
            'projectId' => 'string',
            'createdAt' => 'string',
            'modifiedAt' => 'string',
        ];
    }

    /** @return array<string, array<int, string>> */
    protected function rules(): array
    {
        return [
            'id' => ['required', 'string'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'viewLink' => ['required', 'string'],
            'teamId' => ['nullable', 'string'],
            'projectId' => ['nullable', 'string'],
            'createdAt' => ['nullable', 'string'],
            'modifiedAt' => ['nullable', 'string'],
        ];
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
