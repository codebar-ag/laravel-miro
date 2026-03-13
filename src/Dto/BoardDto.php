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
        public readonly ?SharingPolicyDto $sharingPolicy,
        public readonly ?string $teamId,
        public readonly ?string $projectId,
        public readonly ?string $createdAt,
        public readonly ?string $modifiedAt,
    ) {
    }

    public static function fromResponse(array $data): static
    {
        return new static(
            id: Arr::get($data, 'id', ''),
            name: Arr::get($data, 'name', ''),
            description: Arr::get($data, 'description'),
            type: Arr::get($data, 'type', 'board'),
            viewLink: Arr::get($data, 'viewLink', ''),
            sharingPolicy: Arr::has($data, 'sharingPolicy')
                ? SharingPolicyDto::fromResponse(Arr::get($data, 'sharingPolicy', []))
                : null,
            teamId: Arr::get($data, 'team.id'),
            projectId: Arr::get($data, 'project.id'),
            createdAt: Arr::get($data, 'createdAt'),
            modifiedAt: Arr::get($data, 'modifiedAt'),
        );
    }
}
