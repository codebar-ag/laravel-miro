<?php

use CodebarAg\Miro\Dto\BoardItems\BoardItemDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Items\GetBoardItemRequest;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use CodebarAg\Miro\Responses\Items\BoardItemResponse;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('fromResponse returns a BoardItemDto on success', function () {
    $connector = new MiroConnector();
    $connector->withMockClient(new MockClient([
        GetBoardItemRequest::class => MockResponse::make([
            'id' => '3458764591589797401',
            'type' => 'sticky_note',
            'data' => ['content' => 'Hello'],
            'position' => ['x' => 0.0, 'y' => 0.0, 'origin' => 'center'],
            'geometry' => ['width' => 199.0, 'height' => 199.0],
        ], 200),
    ]));

    $response = BoardItemResponse::fromResponse(
        $connector->send(new GetBoardItemRequest('uXjVKGmRXTo=', '3458764591589797401'))
    );

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeInstanceOf(BoardItemDto::class)
        ->and($response->dto()->id)->toBe('3458764591589797401')
        ->and($response->dto()->type)->toBe('sticky_note');
});

it('collectionFromResponse returns an array of BoardItemDto on success', function () {
    $connector = new MiroConnector();
    $connector->withMockClient(new MockClient([
        GetBoardItemsRequest::class => MockResponse::make([
            'data' => [
                ['id' => 'item_1', 'type' => 'sticky_note', 'data' => [], 'position' => [], 'geometry' => []],
                ['id' => 'item_2', 'type' => 'frame', 'data' => [], 'position' => [], 'geometry' => []],
            ],
        ], 200),
    ]));

    $response = BoardItemResponse::collectionFromResponse(
        $connector->send(new GetBoardItemsRequest('uXjVKGmRXTo='))
    );

    expect($response->successful())->toBeTrue()
        ->and($response->dto())->toBeArray()->toHaveCount(2)
        ->and($response->dto()[0])->toBeInstanceOf(BoardItemDto::class)
        ->and($response->dto()[0]->id)->toBe('item_1')
        ->and($response->dto()[1]->id)->toBe('item_2');
});

it('fromResponse returns null dto on failure', function () {
    $connector = new MiroConnector();
    $connector->withMockClient(new MockClient([
        GetBoardItemRequest::class => MockResponse::make([
            'status' => 404,
            'code' => 'item_not_found',
            'message' => 'Item not found',
            'type' => 'error',
        ], 404),
    ]));

    $response = BoardItemResponse::fromResponse(
        $connector->send(new GetBoardItemRequest('uXjVKGmRXTo=', 'nonexistent'))
    );

    expect($response->successful())->toBeFalse()
        ->and($response->status())->toBe(404)
        ->and($response->dto())->toBeNull()
        ->and($response->error())->toBe('Item not found')
        ->and($response->errorCode())->toBe('item_not_found');
});
