<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\Facades\Miro;

it('can delete a frame', function () {
    $board = Miro::createBoard(new CreateBoardDto(name: 'Live Test '.time(), teamId: $this->teamId()))->dto();
    $created = Miro::createFrame($board->id, new CreateFrameDto(title: 'Delete me!'))->dto();

    $response = Miro::deleteFrame($board->id, $created->id);

    expect($response->status())->toBe(204);

    Miro::deleteBoard($board->id);
})->group('live');
