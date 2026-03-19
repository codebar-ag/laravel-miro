<?php

use CodebarAg\Miro\Dto\Frames\CreateFrameDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Frames\CreateFrameRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new CreateFrameRequest('uXjVKGmRXTo=', []))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames');
});

it('uses the POST method', function () {
    expect((new CreateFrameRequest('uXjVKGmRXTo=', []))->getMethod())->toBe(Method::POST);
});

it('can perform the request', function () {
    Saloon::fake([
        CreateFrameRequest::class => MockResponse::fixture('Frames/create-frame'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(
        new CreateFrameRequest('uXjVKGmRXTo=', (new CreateFrameDto(
            title: 'New Frame',
            fillColor: '#e6e6e6',
            width: 800.0,
            height: 600.0,
        ))->toArray())
    );

    Saloon::assertSent(CreateFrameRequest::class);

    expect($response->status())->toBe(201)
        ->and($response->json('id'))->toBe('3458764591589797502')
        ->and($response->json('data.title'))->toBe('New Frame');
});
