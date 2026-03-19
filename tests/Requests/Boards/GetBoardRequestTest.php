<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\GetBoardRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetBoardRequest('uXjVKGmRXTo='))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=');
});

it('uses the GET method', function () {
    expect((new GetBoardRequest('uXjVKGmRXTo='))->getMethod())->toBe(Method::GET);
});

it('can perform the request', function () {
    Saloon::fake([
        GetBoardRequest::class => MockResponse::fixture('Boards/get-board'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new GetBoardRequest('uXjVKGmRXTo='));

    Saloon::assertSent(GetBoardRequest::class);

    expect($response->json('id'))->toBe('uXjVKGmRXTo=')
        ->and($response->json('name'))->toBe('Test Board');
});
