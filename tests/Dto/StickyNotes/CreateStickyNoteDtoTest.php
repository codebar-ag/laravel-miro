<?php

use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;

it('serializes all fields to correct nested structure', function () {
    $dto = new CreateStickyNoteDto(
        content: 'Hello',
        shape: 'square',
        fillColor: 'light_yellow',
        textAlign: 'center',
        textAlignVertical: 'top',
        positionX: 10.0,
        positionY: 20.0,
        positionOrigin: 'center',
        width: 199.0,
        parentId: 'frame_1',
    );

    expect($dto->toArray())->toBe([
        'data' => ['content' => 'Hello', 'shape' => 'square'],
        'style' => ['fillColor' => 'light_yellow', 'textAlign' => 'center', 'textAlignVertical' => 'top'],
        'position' => ['x' => 10.0, 'y' => 20.0, 'origin' => 'center'],
        'geometry' => ['width' => 199.0],
        'parent' => ['id' => 'frame_1'],
    ]);
});

it('omits null nested sections entirely', function () {
    expect((new CreateStickyNoteDto(content: 'Hello'))->toArray())->toBe([
        'data' => ['content' => 'Hello'],
    ]);
});

it('returns empty array when all fields are null', function () {
    expect((new CreateStickyNoteDto())->toArray())->toBe([]);
});
