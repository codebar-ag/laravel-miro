<?php

namespace CodebarAg\Miro\Dto\BoardItems;

class BoardItemDto
{
    /**
     * @param  array<string, mixed>|null  $data
     * @param  array<string, mixed>|null  $position
     * @param  array<string, mixed>|null  $geometry
     */
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

    /**
     * @param  array{id: string, type: string, data?: array<string, mixed>|null, position?: array<string, mixed>|null, geometry?: array<string, mixed>|null, createdAt?: string|null, modifiedAt?: string|null, parent?: array{id?: string|null}}  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'],
            data: $data['data'] ?? null,
            position: $data['position'] ?? null,
            geometry: $data['geometry'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            modifiedAt: $data['modifiedAt'] ?? null,
            parentId: $data['parent']['id'] ?? null,
        );
    }
}
