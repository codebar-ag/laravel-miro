<?php

namespace CodebarAg\Miro\Dto;

use Illuminate\Support\Arr;

class StickyNoteDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly ?string $content,
        public readonly ?string $shape,
        public readonly ?string $fillColor,
        public readonly ?string $textAlign,
        public readonly ?string $textAlignVertical,
        public readonly ?float $positionX,
        public readonly ?float $positionY,
        public readonly ?float $width,
        public readonly ?float $height,
        public readonly ?string $parentId,
        public readonly ?string $createdAt,
        public readonly ?string $modifiedAt,
    ) {}

    public static function fromResponse(array $data): static
    {
        return new static(
            id: Arr::get($data, 'id', ''),
            type: Arr::get($data, 'type', 'sticky_note'),
            content: Arr::get($data, 'data.content'),
            shape: Arr::get($data, 'data.shape'),
            fillColor: Arr::get($data, 'style.fillColor'),
            textAlign: Arr::get($data, 'style.textAlign'),
            textAlignVertical: Arr::get($data, 'style.textAlignVertical'),
            positionX: Arr::get($data, 'position.x'),
            positionY: Arr::get($data, 'position.y'),
            width: Arr::get($data, 'geometry.width'),
            height: Arr::get($data, 'geometry.height'),
            parentId: Arr::get($data, 'parent.id'),
            createdAt: Arr::get($data, 'createdAt'),
            modifiedAt: Arr::get($data, 'modifiedAt'),
        );
    }
}
