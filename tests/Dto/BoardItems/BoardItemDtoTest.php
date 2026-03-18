<?php

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;

it('maps all fields from response', function () {
    $dto = BoardItemDto::fromResponse([
        'id' => '3458764591589797401',
        'type' => 'sticky_note',
        'data' => ['content' => 'Hello'],
        'position' => ['x' => 10.0, 'y' => 20.0, 'origin' => 'center'],
        'geometry' => ['width' => 199.0, 'height' => 199.0],
        'parent' => ['id' => 'frame_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($dto->id)->toBe('3458764591589797401')
        ->and($dto->type)->toBe('sticky_note')
        ->and($dto->data)->toBe(['content' => 'Hello'])
        ->and($dto->position)->toBe(['x' => 10.0, 'y' => 20.0, 'origin' => 'center'])
        ->and($dto->geometry)->toBe(['width' => 199.0, 'height' => 199.0])
        ->and($dto->parentId)->toBe('frame_1')
        ->and($dto->createdAt)->toBe('2024-01-01T00:00:00Z')
        ->and($dto->modifiedAt)->toBe('2024-06-01T00:00:00Z');
});

it('sets optional fields to null when absent', function () {
    $dto = BoardItemDto::fromResponse([
        'id' => '3458764591589797401',
        'type' => 'sticky_note',
    ]);

    expect($dto->data)->toBeNull()
        ->and($dto->position)->toBeNull()
        ->and($dto->geometry)->toBeNull()
        ->and($dto->parentId)->toBeNull()
        ->and($dto->createdAt)->toBeNull()
        ->and($dto->modifiedAt)->toBeNull();
});
