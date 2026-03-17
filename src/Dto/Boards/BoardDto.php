<?php

namespace CodebarAg\Miro\Dto\Boards;

use Illuminate\Support\Arr;
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
            id: $id,
            name: $name,
            description: $description,
            type: $type,
            viewLink: $viewLink,
            teamId: $teamId,
            projectId: $projectId,
            createdAt: $createdAt,
            modifiedAt: $modifiedAt,
        );
    }
}
