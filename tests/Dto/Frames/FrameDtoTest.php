<?php

use CodebarAg\Miro\Dto\Frames\FrameDto;

it('maps all fields from response', function () {
    $dto = FrameDto::fromResponse([
        'id' => '3458764591589797501',
        'type' => 'frame',
        'data' => ['title' => 'Sprint 1'],
        'style' => ['fillColor' => '#ffffff'],
        'position' => ['x' => 10.0, 'y' => 20.0],
        'geometry' => ['width' => 800.0, 'height' => 600.0],
        'parent' => ['id' => 'parent_frame_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($dto->id)->toBe('3458764591589797501')
        ->and($dto->type)->toBe('frame')
        ->and($dto->title)->toBe('Sprint 1')
        ->and($dto->fillColor)->toBe('#ffffff')
        ->and($dto->positionX)->toBe(10.0)
        ->and($dto->positionY)->toBe(20.0)
        ->and($dto->width)->toBe(800.0)
        ->and($dto->height)->toBe(600.0)
        ->and($dto->parentId)->toBe('parent_frame_1')
        ->and($dto->createdAt)->toBe('2024-01-01T00:00:00Z')
        ->and($dto->modifiedAt)->toBe('2024-06-01T00:00:00Z');
});

it('sets optional fields to null when absent', function () {
    $dto = FrameDto::fromResponse([
        'id' => '3458764591589797501',
        'type' => 'frame',
    ]);

    expect($dto->title)->toBeNull()
        ->and($dto->fillColor)->toBeNull()
        ->and($dto->positionX)->toBeNull()
        ->and($dto->positionY)->toBeNull()
        ->and($dto->width)->toBeNull()
        ->and($dto->height)->toBeNull()
        ->and($dto->parentId)->toBeNull()
        ->and($dto->createdAt)->toBeNull()
        ->and($dto->modifiedAt)->toBeNull();
});
