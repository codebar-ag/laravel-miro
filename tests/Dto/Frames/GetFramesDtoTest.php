<?php

use CodebarAg\Miro\Dto\Frames\GetFramesDto;

it('serializes all filter params', function () {
    expect((new GetFramesDto(limit: 10, cursor: 'abc123'))->toArray())->toBe([
        'limit' => 10,
        'cursor' => 'abc123',
    ]);
});

it('omits null fields', function () {
    expect((new GetFramesDto(limit: 5))->toArray())->toBe(['limit' => 5]);
});

it('returns empty array when all fields are null', function () {
    expect((new GetFramesDto)->toArray())->toBe([]);
});
