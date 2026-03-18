<?php

use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;

it('maps all fields from response', function () {
    $dto = StickyNoteDto::fromResponse([
        'id' => '3458764591589797401',
        'type' => 'sticky_note',
        'data' => ['content' => 'Hello Miro!', 'shape' => 'square'],
        'style' => ['fillColor' => 'light_yellow', 'textAlign' => 'center', 'textAlignVertical' => 'top'],
        'position' => ['x' => 10.0, 'y' => 20.0],
        'geometry' => ['width' => 199.0, 'height' => 199.0],
        'parent' => ['id' => 'frame_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($dto->id)->toBe('3458764591589797401')
        ->and($dto->type)->toBe('sticky_note')
        ->and($dto->content)->toBe('Hello Miro!')
        ->and($dto->shape)->toBe('square')
        ->and($dto->fillColor)->toBe('light_yellow')
        ->and($dto->textAlign)->toBe('center')
        ->and($dto->textAlignVertical)->toBe('top')
        ->and($dto->positionX)->toBe(10.0)
        ->and($dto->positionY)->toBe(20.0)
        ->and($dto->width)->toBe(199.0)
        ->and($dto->height)->toBe(199.0)
        ->and($dto->parentId)->toBe('frame_1')
        ->and($dto->createdAt)->toBe('2024-01-01T00:00:00Z')
        ->and($dto->modifiedAt)->toBe('2024-06-01T00:00:00Z');
});

it('sets optional fields to null when absent', function () {
    $dto = StickyNoteDto::fromResponse([
        'id' => '3458764591589797401',
        'type' => 'sticky_note',
    ]);

    expect($dto->content)->toBeNull()
        ->and($dto->shape)->toBeNull()
        ->and($dto->fillColor)->toBeNull()
        ->and($dto->textAlign)->toBeNull()
        ->and($dto->textAlignVertical)->toBeNull()
        ->and($dto->positionX)->toBeNull()
        ->and($dto->positionY)->toBeNull()
        ->and($dto->width)->toBeNull()
        ->and($dto->height)->toBeNull()
        ->and($dto->parentId)->toBeNull()
        ->and($dto->createdAt)->toBeNull()
        ->and($dto->modifiedAt)->toBeNull();
});
