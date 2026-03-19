<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\DeleteBoardRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new DeleteBoardRequest('uXjVKGmRXTo='))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=');
});

it('uses the DELETE method', function () {
    expect((new DeleteBoardRequest('uXjVKGmRXTo='))->getMethod())->toBe(Method::DELETE);
});

it('can perform the request', function () {
    Saloon::fake([
        DeleteBoardRequest::class => MockResponse::fixture('Boards/delete-board'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new DeleteBoardRequest('uXjVKGmRXTo='));

    Saloon::assertSent(DeleteBoardRequest::class);

    expect($response->status())->toBe(204);
});
