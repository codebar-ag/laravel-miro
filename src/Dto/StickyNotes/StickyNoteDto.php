<?php

namespace CodebarAg\Miro\Dto\StickyNotes;

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

    /**
     * @param  array{id: string, type?: string, data?: array{content?: string|null, shape?: string|null}, style?: array{fillColor?: string|null, textAlign?: string|null, textAlignVertical?: string|null}, position?: array{x?: float, y?: float}, geometry?: array{width?: float, height?: float}, parent?: array{id?: string|null}, createdAt?: string|null, modifiedAt?: string|null}  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'] ?? 'sticky_note',
            content: $data['data']['content'] ?? null,
            shape: $data['data']['shape'] ?? null,
            fillColor: $data['style']['fillColor'] ?? null,
            textAlign: $data['style']['textAlign'] ?? null,
            textAlignVertical: $data['style']['textAlignVertical'] ?? null,
            positionX: $data['position']['x'] ?? null,
            positionY: $data['position']['y'] ?? null,
            width: $data['geometry']['width'] ?? null,
            height: $data['geometry']['height'] ?? null,
            parentId: $data['parent']['id'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            modifiedAt: $data['modifiedAt'] ?? null,
        );
    }
}
