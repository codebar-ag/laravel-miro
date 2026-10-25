<?php

use CodebarAg\Miro\MiroConnector;
use CodebarAg\Miro\Requests\StickyNotes\GetBoardStickyNotesRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('resolves the correct endpoint', function () {
    expect((new GetBoardStickyNotesRequest('uXjVKGmRXTo='))->resolveEndpoint())
        ->toBe('/v2/boards/uXjVKGmRXTo=/sticky_notes');
});

it('uses the GET method', function () {
    expect((new GetBoardStickyNotesRequest('uXjVKGmRXTo='))->getMethod())->toBe(Method::GET);
});

it('sends empty query params by default', function () {
    expect((new GetBoardStickyNotesRequest('uXjVKGmRXTo='))->query()->all())->toBe([]);
});

it('can perform the request', function () {
    Saloon::fake([
        GetBoardStickyNotesRequest::class => MockResponse::fixture('StickyNotes/get-board-sticky-notes'),
    ]);

    $connector = new MiroConnector();
    $response = $connector->send(new GetBoardStickyNotesRequest('uXjVKGmRXTo='));

    Saloon::assertSent(GetBoardStickyNotesRequest::class);

    expect($response->json('data'))->toBeArray()->toHaveCount(1)
        ->and($response->json('data.0.id'))->toBe('3458764591589797401');
});
