<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Dto\Frames\FrameDto;
use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\Facades\Miro;
use CodebarAg\Miro\Responses\Frames\FrameResponse;

it('can update a frame', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $created = Miro::createFrame($board->id, new CreateFrameDto(title: 'Original Title'))->dto();

    $response = Miro::updateFrame($board->id, $created->id, new UpdateFrameDto(
        title: 'Updated Title',
        fillColor: '#cccccc',
    ));

    expect($response)->toBeInstanceOf(FrameResponse::class)
        ->and($response->successful())->toBeTrue();

    $frame = $response->dto();

    expect($frame)->toBeInstanceOf(FrameDto::class)
        ->and($frame->id)->toBe($created->id)
        ->and($frame->title)->toBe('Updated Title')
        ->and($frame->fillColor)->toBe('#cccccc');

    Miro::deleteBoard($board->id);
})->group('live');
