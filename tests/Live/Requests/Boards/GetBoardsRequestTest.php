<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Dto\Boards\GetBoardsDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Boards\BoardResponse;

it('can get boards', function () {
    $response = Miro::getBoards(new GetBoardsDto(teamId: $this->teamId()));

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()
        ->each->toBeInstanceOf(BoardDto::class);
})->group('live');
