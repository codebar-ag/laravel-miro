<?php

namespace CodebarAg\Miro\Dto\BoardItems;

use Illuminate\Support\Arr;

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
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function fromResponse(array $data): self
    {
        $rawData = Arr::get($data, 'data');
        /** @var array<string, mixed>|null $itemData */
        $itemData = is_array($rawData) ? $rawData : null;

        $rawPosition = Arr::get($data, 'position');
        /** @var array<string, mixed>|null $position */
        $position = is_array($rawPosition) ? $rawPosition : null;

        $rawGeometry = Arr::get($data, 'geometry');
        /** @var array<string, mixed>|null $geometry */
        $geometry = is_array($rawGeometry) ? $rawGeometry : null;

        return new self(
            id: is_string($v = Arr::get($data, 'id', '')) ? $v : '',
            type: is_string($v = Arr::get($data, 'type', '')) ? $v : '',
            data: $itemData,
            position: $position,
            geometry: $geometry,
            createdAt: is_string($v = Arr::get($data, 'createdAt')) ? $v : null,
            modifiedAt: is_string($v = Arr::get($data, 'modifiedAt')) ? $v : null,
            parentId: is_string($v = Arr::get($data, 'parent.id')) ? $v : null,
        );
    }
}
