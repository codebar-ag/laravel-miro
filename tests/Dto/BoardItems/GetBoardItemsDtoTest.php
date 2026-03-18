<?php

use CodebarAg\Miro\Dto\BoardItems\GetBoardItemsDto;

it('serializes all filter params', function () {
    expect((new GetBoardItemsDto(limit: 10, cursor: 'abc123', type: 'sticky_note'))->toArray())->toBe([
        'limit' => 10,
        'cursor' => 'abc123',
        'type' => 'sticky_note',
    ]);
});

it('omits null fields', function () {
    expect((new GetBoardItemsDto(type: 'frame'))->toArray())->toBe(['type' => 'frame']);
});

it('returns empty array when all fields are null', function () {
    expect((new GetBoardItemsDto)->toArray())->toBe([]);
});
