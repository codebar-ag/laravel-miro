<?php

namespace CodebarAg\Miro\Dto\Frames;

use Illuminate\Support\Arr;

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

    /** @param array<string, mixed> $data */
    public static function fromResponse(array $data): self
    {
        $px = Arr::get($data, 'position.x');
        $py = Arr::get($data, 'position.y');
        $w = Arr::get($data, 'geometry.width');
        $h = Arr::get($data, 'geometry.height');

        return new self(
            id: is_string($v = Arr::get($data, 'id', '')) ? $v : '',
            type: is_string($v = Arr::get($data, 'type', 'frame')) ? $v : 'frame',
            title: is_string($v = Arr::get($data, 'data.title')) ? $v : null,
            fillColor: is_string($v = Arr::get($data, 'style.fillColor')) ? $v : null,
            positionX: is_int($px) || is_float($px) ? (float) $px : null,
            positionY: is_int($py) || is_float($py) ? (float) $py : null,
            width: is_int($w) || is_float($w) ? (float) $w : null,
            height: is_int($h) || is_float($h) ? (float) $h : null,
            parentId: is_string($v = Arr::get($data, 'parent.id')) ? $v : null,
            createdAt: is_string($v = Arr::get($data, 'createdAt')) ? $v : null,
            modifiedAt: is_string($v = Arr::get($data, 'modifiedAt')) ? $v : null,
        );
    }
}
