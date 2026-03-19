<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Frames\FrameResponse;

it('can get a frame', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $created = Miro::createFrame($board->id, new CreateFrameDto(
        title: 'Fetch me!',
        width: 800.0,
        height: 600.0,
    ))->dto();

    $response = Miro::getFrame($board->id, $created->id);

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->successful())->toBeTrue();

    $frame = $response->dto();

    expect($frame)->toBeInstanceOf(FrameDto::class)
        ->and($frame->id)->toBe($created->id)
        ->and($frame->type)->toBe('frame')
        ->and($frame->title)->toBe('Fetch me!')
        ->and($frame->width)->toBe(800.0)
        ->and($frame->height)->toBe(600.0)
        ->and($frame->createdAt)->not->toBeNull()
        ->and($frame->modifiedAt)->not->toBeNull();

    Miro::deleteBoard($board->id);
})->group('live');
