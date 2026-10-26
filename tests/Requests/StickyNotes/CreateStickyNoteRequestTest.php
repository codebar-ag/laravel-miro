<?php

use CodebarAg\Miro\Dto\StickyNotes\CreateStickyNoteDto;
use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\CreateStickyNoteRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new CreateStickyNoteRequest('uXjVKGmRXTo=', []))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/sticky_notes');
});

it('uses the POST method', function () {
    expect((new CreateStickyNoteRequest('uXjVKGmRXTo=', []))->getMethod())->toBe(Method::POST);
});

it('can perform the request', function () {
    Saloon::fake([
        CreateStickyNoteRequest::class => MockResponse::fixture('StickyNotes/create-sticky-note'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(
        new CreateStickyNoteRequest('uXjVKGmRXTo=', (new CreateStickyNoteDto(
            content: 'New Note',
            shape: 'square',
            fillColor: 'light_yellow',
        ))->toArray())
    );

    Saloon::assertSent(CreateStickyNoteRequest::class);

    expect($response->status())->toBe(201)
        ->and($response->json('id'))->toBe('3458764591589797402')
        ->and($response->json('data.content'))->toBe('New Note');
});
