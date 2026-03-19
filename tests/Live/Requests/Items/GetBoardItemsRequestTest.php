<?php

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Items\BoardItemResponse;

it('can get board items', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    Miro::createStickyNote($board->id, new CreateStickyNoteDto(content: 'Item 1', shape: 'square'));
    Miro::createStickyNote($board->id, new CreateStickyNoteDto(content: 'Item 2', shape: 'square'));

    $response = Miro::getBoardItems($board->id);

    expect($response)->toBeInstanceOf(BoardItemResponse::class)
        ->and($response->successful())->toBeTrue();

    $items = $response->dto();

    expect($items)->toBeArray()
        ->toHaveCount(2)
        ->each->toBeInstanceOf(BoardItemDto::class);

    expect($items[0]->id)->not->toBeEmpty()
        ->and($items[0]->type)->toBe('sticky_note')
        ->and($items[0]->createdAt)->not->toBeNull()
        ->and($items[0]->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
