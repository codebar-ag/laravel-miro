<?php

namespace CodebarAg\Miro\Dto\Frames;

class CreateFrameDto
{
    public function __construct(
        public string $title,
        public ?string $fillColor = null,
        public ?float $positionX = null,
        public ?float $positionY = null,
        public ?string $positionOrigin = null,
        public ?float $width = null,
        public ?float $height = null,
        public ?string $parentId = null,
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        $result = [
            'data' => ['title' => $this->title],
        ];

        $style = array_filter([
            'fillColor' => $this->fillColor,
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
            $result['position'] = $position;
        }

        $geometry = array_filter([
            'width' => $this->width,
            'height' => $this->height,
        ], fn ($v) => $v !== null);

        if ($geometry !== []) {
            $result['geometry'] = $geometry;
        }

        if ($this->parentId !== null) {
            $result['parent'] = ['id' => $this->parentId];
        }

        return $result;
    }
}
