<?php

namespace CodebarAg\Miro\Dto\StickyNotes;

use Illuminate\Support\Arr;

class CreateStickyNoteDto
{
    public function __construct(
        public readonly ?string $content = null,
        public readonly ?string $shape = null,
        public readonly ?string $fillColor = null,
        public readonly ?string $textAlign = null,
        public readonly ?string $textAlignVertical = null,
        public readonly ?float $positionX = null,
        public readonly ?float $positionY = null,
        public readonly ?string $positionOrigin = null,
        public readonly ?float $width = null,
        public readonly ?string $parentId = null,
    ) {}

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $result = [];

        $data = array_filter([
            'content' => $this->content,
            'shape' => $this->shape,
        ], fn ($v) => $v !== null);

        if ($data !== []) {
            $result['data'] = $data;
        }

        $style = array_filter([
            'fillColor' => $this->fillColor,
            'textAlign' => $this->textAlign,
            'textAlignVertical' => $this->textAlignVertical,
        ], fn ($v) => $v !== null);

        if ($style !== []) {
            $result['style'] = $style;
        }

        $position = array_filter([
            'x' => $this->positionX,
            'y' => $this->positionY,
            'origin' => $this->positionOrigin,
        ], fn ($v) => $v !== null);

        if ($position !== []) {
            Arr::set($result, 'position', $position);
        }

        if ($this->width !== null) {
            Arr::set($result, 'geometry', ['width' => $this->width]);
        }

        if ($this->parentId !== null) {
            Arr::set($result, 'parent', ['id' => $this->parentId]);
        }

        return $result;
    }
}
