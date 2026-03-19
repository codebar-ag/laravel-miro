<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\GetBoardsRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetBoardsRequest())->resolveEndpoint())->toBe('/v2/boards');
});

it('uses the GET method', function () {
    expect((new GetBoardsRequest())->getMethod())->toBe(Method::GET);
});

it('sends empty query params by default', function () {
    expect((new GetBoardsRequest())->query()->all())->toBe([]);
});

it('forwards query params from constructor', function () {
    expect((new GetBoardsRequest(['limit' => 10, 'query' => 'test']))->query()->all())
        ->toBe(['limit' => 10, 'query' => 'test']);
});

it('can perform the request', function () {
    Saloon::fake([
        GetBoardsRequest::class => MockResponse::fixture('Boards/get-boards'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new GetBoardsRequest());

    Saloon::assertSent(GetBoardsRequest::class);

    expect($response->json('data'))->toBeArray()->toHaveCount(1)
        ->and($response->json('data.0.id'))->toBe('uXjVKGmRXTo=')
        ->and($response->json('data.0.name'))->toBe('Test Board');
});
