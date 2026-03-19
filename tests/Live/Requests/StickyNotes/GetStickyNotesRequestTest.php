<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;

it('can get sticky notes from a board', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    Miro::createStickyNote($board->id, new CreateStickyNoteDto(content: 'Note 1', shape: 'square'));
    Miro::createStickyNote($board->id, new CreateStickyNoteDto(content: 'Note 2', shape: 'square'));

    $response = Miro::getStickyNotes($board->id);

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->successful())->toBeTrue();

    $notes = $response->dto();

    expect($notes)->toBeArray()
        ->toHaveCount(2)
        ->each->toBeInstanceOf(StickyNoteDto::class);

    expect($notes[0]->id)->not->toBeEmpty()
        ->and($notes[0]->type)->toBe('sticky_note');

    Miro::deleteBoard($board->id);
})->group('live');
