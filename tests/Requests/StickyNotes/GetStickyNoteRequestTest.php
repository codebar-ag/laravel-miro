<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\GetStickyNoteRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/sticky_notes/3458764591589797401');
});

it('uses the GET method', function () {
    expect((new GetStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'))->getMethod())->toBe(Method::GET);
});

it('can perform the request', function () {
    Saloon::fake([
        GetStickyNoteRequest::class => MockResponse::fixture('StickyNotes/get-sticky-note'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(new GetStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'));

    Saloon::assertSent(GetStickyNoteRequest::class);

    expect($response->json('id'))->toBe('3458764591589797401')
        ->and($response->json('data.content'))->toBe('Hello Miro!')
        ->and($response->json('data.shape'))->toBe('square')
        ->and($response->json('style.fillColor'))->toBe('light_yellow');
});
