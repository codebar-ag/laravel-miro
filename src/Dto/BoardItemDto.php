<?php

namespace CodebarAg\Miro\Dto;

use Illuminate\Support\Arr;

class BoardItemDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly ?array $data,
        public readonly ?array $position,
        public readonly ?array $geometry,
        public readonly ?string $createdAt,
        public readonly ?string $modifiedAt,
        public readonly ?string $parentId,
    ) {}

    public static function fromResponse(array $data): static
    {
        return new static(
            id: Arr::get($data, 'id', ''),
            type: Arr::get($data, 'type', ''),
            data: Arr::get($data, 'data'),
            position: Arr::get($data, 'position'),
            geometry: Arr::get($data, 'geometry'),
            createdAt: Arr::get($data, 'createdAt'),
            modifiedAt: Arr::get($data, 'modifiedAt'),
            parentId: Arr::get($data, 'parent.id'),
        );
    }
}
