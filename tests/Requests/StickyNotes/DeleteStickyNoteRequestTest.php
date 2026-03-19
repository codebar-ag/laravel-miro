<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\DeleteStickyNoteRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new DeleteStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/sticky_notes/3458764591589797401');
});

it('uses the DELETE method', function () {
    expect((new DeleteStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'))->getMethod())->toBe(Method::DELETE);
});

it('can perform the request', function () {
    Saloon::fake([
        DeleteStickyNoteRequest::class => MockResponse::fixture('StickyNotes/delete-sticky-note'),
    ]);

    $connector = new MiroConnector;
    $response = $connector->send(new DeleteStickyNoteRequest('uXjVKGmRXTo=', '3458764591589797401'));

    Saloon::assertSent(DeleteStickyNoteRequest::class);

    expect($response->status())->toBe(204);
});
