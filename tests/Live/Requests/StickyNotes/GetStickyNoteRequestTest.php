<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;

it('can get a sticky note', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $created = Miro::createStickyNote($board->id, new CreateStickyNoteDto(
        content: 'Fetch me!',
        shape: 'square',
        fillColor: 'light_yellow',
    ))->dto();

    $response = Miro::getStickyNote($board->id, $created->id);

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->successful())->toBeTrue();

    $note = $response->dto();

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->id)->toBe($created->id)
        ->and($note->type)->toBe('sticky_note')
        ->and($note->content)->toBe('Fetch me!')
        ->and($note->shape)->toBe('square')
        ->and($note->fillColor)->toBe('light_yellow')
        ->and($note->createdAt)->not->toBeNull()
        ->and($note->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
