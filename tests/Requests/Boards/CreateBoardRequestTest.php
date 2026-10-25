<?php

use CodebarAg\Miro\Dto\Boards\CreateBoardDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Boards\CreateBoardRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new CreateBoardRequest([]))->resolveEndpoint())->toBe('/v2/boards');
});

it('uses the POST method', function () {
    expect((new CreateBoardRequest([]))->getMethod())->toBe(Method::POST);
});

it('can perform the request', function () {
    Saloon::fake([
        CreateBoardRequest::class => MockResponse::fixture('Boards/create-board'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new CreateBoardRequest((new CreateBoardDto(name: 'New Board'))->toArray()));

    Saloon::assertSent(CreateBoardRequest::class);

    expect($response->status())->toBe(201)
        ->and($response->json('id'))->toBe('uXjVKGmRXTo=')
        ->and($response->json('name'))->toBe('New Board');
});
