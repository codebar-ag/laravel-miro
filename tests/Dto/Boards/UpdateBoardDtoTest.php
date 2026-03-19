<?php

use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;

it('serializes provided fields', function () {
    expect((new UpdateBoardDto(name: 'Renamed', description: 'New desc'))->toArray())->toBe([
        'name' => 'Renamed',
        'description' => 'New desc',
    ]);
});

it('omits null fields', function () {
    expect((new UpdateBoardDto(name: 'Renamed'))->toArray())->toBe([
        'name' => 'Renamed',
    ]);
});

it('returns empty array when all fields are null', function () {
    expect((new UpdateBoardDto())->toArray())->toBe([]);
});
