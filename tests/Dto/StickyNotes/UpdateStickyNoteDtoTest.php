<?php

use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;

it('serializes all fields to correct nested structure', function () {
    $dto = new UpdateStickyNoteDto(
        content: 'Updated',
        shape: 'rectangle',
        fillColor: 'light_pink',
        textAlign: 'left',
        textAlignVertical: 'middle',
        positionX: 5.0,
        positionY: 15.0,
        width: 320.0,
        parentId: 'frame_2',
    );

    expect($dto->toArray())->toBe([
        'data' => ['content' => 'Updated', 'shape' => 'rectangle'],
        'style' => ['fillColor' => 'light_pink', 'textAlign' => 'left', 'textAlignVertical' => 'middle'],
        'position' => ['x' => 5.0, 'y' => 15.0],
        'geometry' => ['width' => 320.0],
        'parent' => ['id' => 'frame_2'],
    ]);
});

it('omits null nested sections entirely', function () {
    expect((new UpdateStickyNoteDto(content: 'Updated'))->toArray())->toBe([
        'data' => ['content' => 'Updated'],
    ]);
});

it('returns empty array when all fields are null', function () {
    expect((new UpdateStickyNoteDto)->toArray())->toBe([]);
});
