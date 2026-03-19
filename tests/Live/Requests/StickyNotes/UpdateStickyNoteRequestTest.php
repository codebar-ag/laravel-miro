<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;

it('can update a sticky note', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $created = Miro::createStickyNote($board->id, new CreateStickyNoteDto(
        content: 'Original content',
        shape: 'square',
        fillColor: 'light_yellow',
    ))->dto();

    $response = Miro::updateStickyNote($board->id, $created->id, new UpdateStickyNoteDto(
        content: 'Updated content',
        fillColor: 'light_pink',
    ));

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->successful())->toBeTrue();

    $note = $response->dto();

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->id)->toBe($created->id)
        ->and($note->content)->toBe('Updated content')
        ->and($note->fillColor)->toBe('light_pink');

    Miro::deleteBoard($board->id);
})->group('live');
