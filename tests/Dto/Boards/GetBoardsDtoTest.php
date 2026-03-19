<?php

use CodebarAg\Miro\Dto\Boards\GetBoardsDto;

it('serializes all filter params', function () {
    $dto = new GetBoardsDto(
        teamId: 'team_1',
        projectId: 'project_1',
        query: 'sprint',
        owner: 'me',
        limit: 10,
        offset: 5,
        sort: 'last_modified',
    );

    expect($dto->toArray())->toBe([
        'team_id' => 'team_1',
        'project_id' => 'project_1',
        'query' => 'sprint',
        'owner' => 'me',
        'limit' => 10,
        'offset' => 5,
        'sort' => 'last_modified',
    ]);
});

it('omits null fields', function () {
    expect((new GetBoardsDto(limit: 5))->toArray())->toBe(['limit' => 5]);
});

it('returns empty array when all fields are null', function () {
    expect((new GetBoardsDto())->toArray())->toBe([]);
});
