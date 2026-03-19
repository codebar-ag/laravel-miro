<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Boards\BoardResponse;

it('can create a board', function () {
    $response = Miro::createBoard(new CreateBoardDto(
        name: 'Live Test Board '.time(),
        description: 'Created by live test',
    ));

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->successful())->toBeTrue()
        ->and($response->status())->toBe(201);

    $board = $response->dto();

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->not->toBeEmpty()
        ->and($board->name)->toContain('Live Test Board')
        ->and($board->description)->toBe('Created by live test')
        ->and($board->type)->toBe('board')
        ->and($board->viewLink)->not->toBeEmpty()
        ->and($board->createdAt)->not->toBeNull()
        ->and($board->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
