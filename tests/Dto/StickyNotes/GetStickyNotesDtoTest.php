<?php

use CodebarAg\Miro\Dto\StickyNotes\GetStickyNotesDto;

it('serializes all filter params', function () {
    expect((new GetStickyNotesDto(limit: 20, cursor: 'abc123'))->toArray())->toBe([
        'limit' => 20,
        'cursor' => 'abc123',
    ]);
});

it('omits null fields', function () {
    expect((new GetStickyNotesDto(limit: 5))->toArray())->toBe(['limit' => 5]);
});

it('returns empty array when all fields are null', function () {
    expect((new GetStickyNotesDto())->toArray())->toBe([]);
});
