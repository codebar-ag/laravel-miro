<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Frames\FrameResponse;

it('can get frames from a board', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    Miro::createFrame($board->id, new CreateFrameDto(title: 'Frame 1'));
    Miro::createFrame($board->id, new CreateFrameDto(title: 'Frame 2'));

    $response = Miro::getFrames($board->id);

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->successful())->toBeTrue();

    $frames = $response->dto();

    expect($frames)->toBeArray()
        ->toHaveCount(2)
        ->each->toBeInstanceOf(FrameDto::class);

    expect($frames[0]->id)->not->toBeEmpty()
        ->and($frames[0]->type)->toBe('frame');

    Miro::deleteBoard($board->id);
})->group('live');
