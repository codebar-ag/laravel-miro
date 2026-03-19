<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Frames\GetFrameRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetFrameRequest('uXjVKGmRXTo=', '3458764591589797501'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames/3458764591589797501');
});

it('uses the GET method', function () {
    expect((new GetFrameRequest('uXjVKGmRXTo=', '3458764591589797501'))->getMethod())->toBe(Method::GET);
});

it('can perform the request', function () {
    Saloon::fake([
        GetFrameRequest::class => MockResponse::fixture('Frames/get-frame'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new GetFrameRequest('uXjVKGmRXTo=', '3458764591589797501'));

    Saloon::assertSent(GetFrameRequest::class);

    expect($response->json('id'))->toBe('3458764591589797501')
        ->and($response->json('data.title'))->toBe('Sprint 1');
});
