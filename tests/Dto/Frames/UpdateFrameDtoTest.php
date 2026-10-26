<?php

use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;

it('serializes all fields to correct nested structure', function () {
    $dto = new UpdateFrameDto(
        title: 'Renamed',
        fillColor: '#cccccc',
        positionX: 5.0,
        positionY: 15.0,
        width: 1024.0,
        height: 768.0,
        parentId: 'parent_frame_1',
    );

    expect($dto->toArray())->toBe([
        'data' => ['title' => 'Renamed'],
        'style' => ['fillColor' => '#cccccc'],
        'position' => ['x' => 5.0, 'y' => 15.0],
        'geometry' => ['width' => 1024.0, 'height' => 768.0],
        'parent' => ['id' => 'parent_frame_1'],
    ]);
});

it('omits null nested sections entirely', function () {
    expect((new UpdateFrameDto(title: 'Renamed'))->toArray())->toBe([
        'data' => ['title' => 'Renamed'],
    ]);
});

it('returns empty array when all fields are null', function () {
    expect((new UpdateFrameDto)->toArray())->toBe([]);
});
