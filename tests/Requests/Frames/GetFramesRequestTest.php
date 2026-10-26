<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Frames\GetFramesRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetFramesRequest('uXjVKGmRXTo='))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames');
});

it('uses the GET method', function () {
    expect((new GetFramesRequest('uXjVKGmRXTo='))->getMethod())->toBe(Method::GET);
});

it('sends empty query params by default', function () {
    expect((new GetFramesRequest('uXjVKGmRXTo='))->query()->all())->toBe([]);
});

it('can perform the request', function () {
    Saloon::fake([
        GetFramesRequest::class => MockResponse::fixture('Frames/get-frames'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(new GetFramesRequest('uXjVKGmRXTo='));

    Saloon::assertSent(GetFramesRequest::class);

    expect($response->json('data'))->toBeArray()->toHaveCount(1)
        ->and($response->json('data.0.id'))->toBe('3458764591589797501')
        ->and($response->json('data.0.data.title'))->toBe('Sprint 1');
});
