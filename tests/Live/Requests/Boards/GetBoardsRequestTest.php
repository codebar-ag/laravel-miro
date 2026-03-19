<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Boards\BoardResponse;

it('can get boards', function () {
    $response = Miro::getBoards();

    expect($response)->toBeInstanceOf(BoardResponse::class)
        ->and($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()
        ->each->toBeInstanceOf(BoardDto::class);
})->group('live');
