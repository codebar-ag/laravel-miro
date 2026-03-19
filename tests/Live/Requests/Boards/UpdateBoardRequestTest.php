<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Boards\BoardResponse;

it('can update a board', function () {
    $created = Miro::createBoard(new CreateBoardDto(name: 'Live Test Board '.time(), teamId: $this->teamId()))->dto();

    $response = Miro::updateBoard($created->id, new UpdateBoardDto(
        name: 'Updated Board Name',
        description: 'Updated description',
    ));

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->successful())->toBeTrue();

    $board = $response->dto();

    expect($board)->toBeInstanceOf(BoardDto::class)
        ->and($board->id)->toBe($created->id)
        ->and($board->name)->toBe('Updated Board Name')
        ->and($board->description)->toBe('Updated description');

    Miro::deleteBoard($created->id);
})->group('live');
