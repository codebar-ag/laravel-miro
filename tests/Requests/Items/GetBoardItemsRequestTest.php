<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Items\GetBoardItemsRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetBoardItemsRequest('uXjVKGmRXTo='))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/items');
});

it('uses the GET method', function () {
    expect((new GetBoardItemsRequest('uXjVKGmRXTo='))->getMethod())->toBe(Method::GET);
});

it('sends empty query params by default', function () {
    expect((new GetBoardItemsRequest('uXjVKGmRXTo='))->query()->all())->toBe([]);
});

it('can perform the request', function () {
    Saloon::fake([
        GetBoardItemsRequest::class => MockResponse::fixture('Items/get-board-items'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new GetBoardItemsRequest('uXjVKGmRXTo='));

    Saloon::assertSent(GetBoardItemsRequest::class);

    expect($response->json('data'))->toBeArray()->toHaveCount(1)
        ->and($response->json('data.0.id'))->toBe('3458764591589797401')
        ->and($response->json('data.0.type'))->toBe('sticky_note');
});
