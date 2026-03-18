<?php

use CodebarAg\Miro\Dto\Frames\CreateFrameDto;

it('serializes all fields to correct nested structure', function () {
    $dto = new CreateFrameDto(
        title: 'Sprint 1',
        fillColor: '#ffffff',
        positionX: 10.0,
        positionY: 20.0,
        positionOrigin: 'center',
        width: 800.0,
        height: 600.0,
        parentId: 'parent_frame_1',
    );

    expect($dto->toArray())->toBe([
        'data' => ['title' => 'Sprint 1'],
        'style' => ['fillColor' => '#ffffff'],
        'position' => ['x' => 10.0, 'y' => 20.0, 'origin' => 'center'],
        'geometry' => ['width' => 800.0, 'height' => 600.0],
        'parent' => ['id' => 'parent_frame_1'],
    ]);
});

it('omits null nested sections entirely', function () {
    expect((new CreateFrameDto(title: 'Sprint 1'))->toArray())->toBe([
        'data' => ['title' => 'Sprint 1'],
    ]);
});
