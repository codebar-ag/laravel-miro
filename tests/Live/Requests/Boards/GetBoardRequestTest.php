<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Boards\BoardResponse;

it('can get a board', function () {
    $created = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();

    $response = Miro::getBoard($created->id);

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->successful())->toBeTrue();

    $board = $response->dto();

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->toBe($created->id)
        ->and($board->name)->toBe($created->name)
        ->and($board->type)->toBe('board')
        ->and($board->viewLink)->not->toBeEmpty()
        ->and($board->createdAt)->not->toBeNull()
        ->and($board->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($created->id);
})->group('live');

it('returns a failed response for a non-existent board', function () {
    $response = Miro::getBoard('non_existent_board_id');

    expect($response->successful())->toBeFalse()
        ->and($response->failed())->toBeTrue()
        ->and($response->status())->toBe(400)
        ->and($response->dto())->toBeNull()
        ->and($response->error())->not->toBeNull()
        ->and($response->errorCode())->not->toBeNull();
})->group('live');
