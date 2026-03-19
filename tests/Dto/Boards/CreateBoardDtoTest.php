<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;

it('serializes all fields', function () {
    $dto = new CreateBoardDto(
        name: 'My Board',
        description: 'A description',
        teamId: 'team_1',
    );

    expect($dto->toArray())->toBe([
        'name' => 'My Board',
        'description' => 'A description',
        'teamId' => 'team_1',
    ]);
});

it('omits null fields', function () {
    expect((new CreateBoardDto(name: 'My Board'))->toArray())->toBe([
        'name' => 'My Board',
    ]);
});
