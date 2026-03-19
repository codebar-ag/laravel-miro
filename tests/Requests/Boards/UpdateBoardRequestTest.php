<?php

use CodebarAg\Miro\Dto\Boards\UpdateBoardDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\UpdateBoardRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new UpdateBoardRequest('uXjVKGmRXTo=', []))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=');
});

it('uses the PATCH method', function () {
    expect((new UpdateBoardRequest('uXjVKGmRXTo=', []))->getMethod())->toBe(Method::PATCH);
});

it('can perform the request', function () {
    Saloon::fake([
        UpdateBoardRequest::class => MockResponse::fixture('Boards/update-board'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(
        new UpdateBoardRequest('uXjVKGmRXTo=', (new UpdateBoardDto(name: 'Renamed Board'))->toArray())
    );

    Saloon::assertSent(UpdateBoardRequest::class);

    expect($response->json('name'))->toBe('Renamed Board');
});
