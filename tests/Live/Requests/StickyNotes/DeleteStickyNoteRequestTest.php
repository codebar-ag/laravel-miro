<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;

it('can delete a sticky note', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $created = Miro::createStickyNote($board->id, new CreateStickyNoteDto(
        content: 'Delete me!',
        shape: 'square',
    ))->dto();

    $response = Miro::deleteStickyNote($board->id, $created->id);

    expect($response->status())->toBe(204);

    Miro::deleteBoard($board->id);
})->group('live');
