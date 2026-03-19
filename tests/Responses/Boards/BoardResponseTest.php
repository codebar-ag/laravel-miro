<?php

use CodebarAg\Miro\Dto\Boards\BoardDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use CodebarAg\Miro\Responses\Boards\BoardResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('fromResponse returns a BoardDto on success', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetBoardRequest::class => MockResponse::make([
            'id' => 'uXjVKGmRXTo=',
            'name' => 'Test Board',
            'type' => 'board',
            'viewLink' => '',
        ], 200),
    ]));

    $response = BoardResponse::fromResponse($connector->send(new GetBoardRequest('uXjVKGmRXTo=')));

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeInstanceOf(BoardDto::class)
        ->and($response->dto()->id)->toBe('uXjVKGmRXTo=')
        ->and($response->dto()->name)->toBe('Test Board');
});

it('collectionFromResponse returns an array of BoardDto on success', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetBoardsRequest::class => MockResponse::make([
            'data' => [
                ['id' => 'board_1', 'name' => 'Board 1', 'type' => 'board', 'viewLink' => ''],
                ['id' => 'board_2', 'name' => 'Board 2', 'type' => 'board', 'viewLink' => ''],
            ],
        ], 200),
    ]));

    $response = BoardResponse::collectionFromResponse($connector->send(new GetBoardsRequest));

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()->toHaveCount(2)
        ->and($response->dto()[0])->toBeInstanceOf(BoardDto::class)
        ->and($response->dto()[0]->id)->toBe('board_1')
        ->and($response->dto()[1]->id)->toBe('board_2');
});

it('fromResponse returns null dto on failure', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetBoardRequest::class => MockResponse::make([
            'status' => 404,
            'code' => 'board_not_found',
            'message' => 'Board not found',
            'type' => 'error',
        ], 404),
    ]));

    $response = BoardResponse::fromResponse($connector->send(new GetBoardRequest('nonexistent')));

    expect($response->successful())->toBeFalse()
        ->and($response->failed())->toBeTrue()
        ->and($response->status())->toBe(404)
        ->and($response->dto())->toBeNull()
        ->and($response->error())->toBe('Board not found')
        ->and($response->errorCode())->toBe('board_not_found');
});

it('error and errorCode return null on success', function () {
    $connector = new MiroConnector;
    $connector->withMockClient(new MockClient([
        GetBoardRequest::class => MockResponse::make([
            'id' => 'uXjVKGmRXTo=', 'name' => 'Test Board', 'type' => 'board', 'viewLink' => '',
        ], 200),
    ]));

    $response = BoardResponse::fromResponse($connector->send(new GetBoardRequest('uXjVKGmRXTo=')));

    expect($response->error())->toBeNull()
        ->and($response->errorCode())->toBeNull();
});
