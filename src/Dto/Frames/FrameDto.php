<?php

namespace CodebarAg\Miro\Dto\Frames;

class FrameDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly ?string $title,
        public readonly ?string $fillColor,
        public readonly ?float $positionX,
        public readonly ?float $positionY,
        public readonly ?float $width,
        public readonly ?float $height,
        public readonly ?string $parentId,
        public readonly ?string $createdAt,
        public readonly ?string $modifiedAt,
    ) {}

    /**
     * @param  array{id: string, type?: string, data?: array{title?: string|null}, style?: array{fillColor?: string|null}, position?: array{x?: float, y?: float}, geometry?: array{width?: float, height?: float}, parent?: array{id?: string|null}, createdAt?: string|null, modifiedAt?: string|null}  $data
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'] ?? 'frame',
            title: $data['data']['title'] ?? null,
            fillColor: $data['style']['fillColor'] ?? null,
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
