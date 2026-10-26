<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Frames\DeleteFrameRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new DeleteFrameRequest('uXjVKGmRXTo=', '3458764591589797501'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames/3458764591589797501');
});

it('uses the DELETE method', function () {
    expect((new DeleteFrameRequest('uXjVKGmRXTo=', '3458764591589797501'))->getMethod())->toBe(Method::DELETE);
});

it('can perform the request', function () {
    Saloon::fake([
        DeleteFrameRequest::class => MockResponse::fixture('Frames/delete-frame'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(new DeleteFrameRequest('uXjVKGmRXTo=', '3458764591589797501'));

    Saloon::assertSent(DeleteFrameRequest::class);

    expect($response->status())->toBe(204);
});
