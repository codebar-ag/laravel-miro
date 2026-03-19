<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;

it('maps all fields from response', function () {
    $dto = BoardDto::fromResponse([
        'id' => 'uXjVKGmRXTo=',
        'name' => 'My Board',
        'description' => 'A description',
        'type' => 'board',
        'viewLink' => 'https://miro.com/app/board/uXjVKGmRXTo=/',
        'team' => ['id' => 'team_1'],
        'project' => ['id' => 'project_1'],
        'createdAt' => '2024-01-01T00:00:00Z',
        'modifiedAt' => '2024-06-01T00:00:00Z',
    ]);

    expect($dto->id)->toBe('uXjVKGmRXTo=')
        ->and($dto->name)->toBe('My Board')
        ->and($dto->description)->toBe('A description')
        ->and($dto->type)->toBe('board')
        ->and($dto->viewLink)->toBe('https://miro.com/app/board/uXjVKGmRXTo=/')
        ->and($dto->teamId)->toBe('team_1')
        ->and($dto->projectId)->toBe('project_1')
        ->and($dto->createdAt)->toBe('2024-01-01T00:00:00Z')
        ->and($dto->modifiedAt)->toBe('2024-06-01T00:00:00Z');
});

it('sets optional fields to null when absent', function () {
    $dto = BoardDto::fromResponse([
        'id' => 'uXjVKGmRXTo=',
        'name' => 'My Board',
        'type' => 'board',
        'viewLink' => '',
    ]);

    expect($dto->description)->toBeNull()
        ->and($dto->teamId)->toBeNull()
        ->and($dto->projectId)->toBeNull()
        ->and($dto->createdAt)->toBeNull()
        ->and($dto->modifiedAt)->toBeNull();
});
