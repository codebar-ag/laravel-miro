<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Dto\StickyNotes\StickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\StickyNotes\StickyNoteResponse;

it('can create a sticky note', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();

    $response = Miro::createStickyNote($board->id, new CreateStickyNoteDto(
        content: 'Hello from live test!',
        shape: 'square',
        fillColor: 'light_yellow',
        textAlign: 'center',
        textAlignVertical: 'top',
        positionX: 0.0,
        positionY: 0.0,
        positionOrigin: 'center',
    ));

    expect($response)->toBeInstanceOf(StickyNoteResponse::class)
        ->and($response->successful())->toBeTrue()
        ->and($response->status())->toBe(201);

    $note = $response->dto();

    expect($note)->toBeInstanceOf(StickyNoteDto::class)
        ->and($note->id)->not->toBeEmpty()
        ->and($note->type)->toBe('sticky_note')
        ->and($note->content)->toBe('Hello from live test!')
        ->and($note->shape)->toBe('square')
        ->and($note->fillColor)->toBe('light_yellow')
        ->and($note->textAlign)->toBe('center')
        ->and($note->textAlignVertical)->toBe('top')
        ->and($note->createdAt)->not->toBeNull()
        ->and($note->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
