<?php

use CodebarAg\Miro\Dto\StickyNotes\UpdateStickyNoteDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\UpdateStickyNoteRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new UpdateStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401', []))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/sticky_notes/3458764591589797401');
});

it('uses the PATCH method', function () {
    expect((new UpdateStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401', []))->getMethod())->toBe(Method::PATCH);
});

it('can perform the request', function () {
    Saloon::fake([
        UpdateStickyNoteRequest::class => MockResponse::fixture('StickyNotes/update-sticky-note'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(
        new UpdateStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401', (new UpdateStickyNoteDto(
            content: 'Updated Note',
            fillColor: 'light_pink',
        ))->toArray())
    );

    Saloon::assertSent(UpdateStickyNoteRequest::class);

    expect($response->json('data.content'))->toBe('Updated Note')
        ->and($response->json('style.fillColor'))->toBe('light_pink');
});
