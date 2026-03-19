<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Frames\FrameResponse;

it('can create a frame', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();

    $response = Miro::createFrame($board->id, new CreateFrameDto(
        title: 'Live Test Frame',
        fillColor: '#e6e6e6',
        positionX: 0.0,
        positionY: 0.0,
        width: 1920.0,
        height: 1080.0,
    ));

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->successful())->toBeTrue()
        ->and($response->status())->toBe(201);

    $frame = $response->dto();

    expect($frame)->toBeInstanceOf(FrameDto::class)
        ->and($frame->id)->not->toBeEmpty()
        ->and($frame->type)->toBe('frame')
        ->and($frame->title)->toBe('Live Test Frame')
        ->and($frame->fillColor)->toBe('#e6e6e6')
        ->and($frame->width)->toBe(1920.0)
        ->and($frame->height)->toBe(1080.0)
        ->and($frame->createdAt)->not->toBeNull()
        ->and($frame->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
