<?php

use CodebarAg\Miro\Dto\Frames\UpdateFrameDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\Frames\UpdateFrameRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new UpdateFrameRequest('uXjVKGmRXTo=', '3458764591589797501', []))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/frames/3458764591589797501');
});

it('uses the PATCH method', function () {
    expect((new UpdateFrameRequest('uXjVKGmRXTo=', '3458764591589797501', []))->getMethod())->toBe(Method::PATCH);
});

it('can perform the request', function () {
    Saloon::fake([
        UpdateFrameRequest::class => MockResponse::fixture('Frames/update-frame'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(
        new UpdateFrameRequest('uXjVKGmRXTo=', '3458764591589797501', (new UpdateFrameDto(
            title: 'Renamed Frame',
            fillColor: '#cccccc',
        ))->toArray())
    );

    Saloon::assertSent(UpdateFrameRequest::class);

    expect($response->json('data.title'))->toBe('Renamed Frame')
        ->and($response->json('style.fillColor'))->toBe('#cccccc');
});
