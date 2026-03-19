<?php

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Items\BoardItemResponse;

it('can get a board item', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $note = Miro::createStickyNote($board->id, new CreateStickyNoteDto(
        content: 'Fetch me!',
        shape: 'square',
    ))->dto();

    $response = Miro::getBoardItem($board->id, $note->id);

    expect($response)->toBeInstanceOf(BoardItemResponse::class)
        ->and($response->successful())->toBeTrue();

    $item = $response->dto();

    expect($item)->toBeInstanceOf(BoardItemDto::class)
        ->and($item->id)->toBe($note->id)
        ->and($item->type)->toBe('sticky_note')
        ->and($item->data)->toBeArray()
        ->and($item->position)->toBeArray()
        ->and($item->createdAt)->not->toBeNull()
        ->and($item->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
