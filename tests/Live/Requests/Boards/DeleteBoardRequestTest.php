<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\Facades\Miro;

it('can delete a board', function () {
    $created = Miro::createBoard(new CreateBoardDto(name: 'Board to Delete '.time(), teamId: $this->teamId()))->dto();

    $response = Miro::deleteBoard($created->id);

    expect($response->status())->toBe(204);
})->group('live');
