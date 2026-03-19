<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;

it('can get sticky notes via the board sticky notes endpoint', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    Miro::createStickyNote($board->id, new CreateStickyNoteDto(content: 'Hello!', shape: 'square'));

    $response = Miro::getStickyNotes($board->id);

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()
        ->each->toBeInstanceOf(StickyNoteDto::class);

    Miro::deleteBoard($board->id);
})->group('live');
